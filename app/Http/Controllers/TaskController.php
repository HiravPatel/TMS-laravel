<?php

namespace App\Http\Controllers;

use App\Rules\desc;
use App\Models\Task;
use App\Rules\title;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignedto']);

    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }
    
     if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('task_name', 'LIKE', "%{$search}%")
             ->orWhereHas('project', function ($q2) use ($search) {
                  $q2->where('name', 'LIKE', "%{$search}%");
             })
                   ->orWhereHas('assignedto', function ($q3) use ($search) {
                  $q3->where('name', 'LIKE', "%{$search}%");
            });
        });
    }

    $tasks = $query->orderBy('id', 'desc')->paginate(3);

        return view('tasklist', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('storetask', compact('projects'));
    }

    public function getMembers($projectId)
    {
        $project = Project::with('members')->find($projectId);
        return response()->json($project->members);
    }


    public function store(Request $request)
    {
        $request->validate([
            'task_name'   => ['required',new title],
            'description' => ['required',new desc],
            'project_id'  => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'priority'    => 'required|string',
            'status'      => 'required|string',
            'start_date'  => 'date',
            'due_date'    => 'date|after_or_equal:start_date',
        ]);

        Task::create($request->all());

        return redirect()->route('tasklist')->with('success', 'Task created successfully!');
    }

    public function edit($id)
    {
        $task = Task::find($id);
        $projects = Project::all();

        return view('storetask', compact('task', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'task_name'   => ['required',new title],
            'description' => ['required',new desc],
            'project_id'  => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'priority'    => 'required|string',
            'status'      => 'required|string',
            'start_date'  => 'date',
            'due_date'    => 'date|after_or_equal:start_date',
        ]);

        $task = Task::find($id);
        $task->update($request->all());

        return redirect()->route('tasklist')->with('success', 'Task updated successfully!');
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return redirect()->route('tasklist')->with('success', 'Task deleted successfully!');
    }
}
