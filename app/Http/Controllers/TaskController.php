<?php

namespace App\Http\Controllers;

use App\Rules\desc;
use App\Models\Task;
use App\Rules\title;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
       $userId = Auth::id();
       $userRole = Auth::user()->role->role;

    $query = Task::with(['project', 'assignedto']);

    if (!in_array($userRole, ['Admin','Tester'])) {
    $query->where(function ($q) use ($userId) {
        $q->where('assigned_to', $userId);

    });
    }

      if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
     if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('description', 'LIKE', "%{$search}%")
              ->orWhere('due_date', 'LIKE', "%{$search}%")
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

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        return response()->json($project->members);
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_name'   => ['required', new title],
            'description' => ['required', new desc],
            'project_id'  => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'priority'    => 'required|string',
            'status'      => 'required|string',
            'start_date'  => 'required|date',
            'due_date'    => 'required|date|after_or_equal:start_date',
        ]);

        $task = Task::create($request->all());

        if ($task) {
            return redirect()->route('tasklist')->with('success', 'Task created successfully!');
        } else {
            return redirect()->route('tasklist')->with('error', 'Failed to create task. Please try again.');
        }
    }

    public function edit($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return redirect()->route('tasklist')->with('error', 'Task not found.');
        }

        $projects = Project::all();
        return view('storetask', compact('task', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'task_name'   => ['required', new title],
            'description' => ['required', new desc],
            'project_id'  => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'priority'    => 'required|string',
            'status'      => 'required|string',
            'start_date'  => 'date',
            'due_date'    => 'date|after_or_equal:start_date',
        ]);

        $task = Task::find($id);

        if (!$task) {
            return redirect()->route('tasklist')->with('error', 'Task not found.');
        }

        $updated = $task->update($request->all());

        if ($updated) {
            return redirect()->route('tasklist')->with('success', 'Task updated successfully!');
        } else {
            return redirect()->route('tasklist')->with('error', 'Failed to update task. Please try again.');
        }
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return redirect()->route('tasklist')->with('error', 'Task not found.');
        }

        if ($task->delete()) {
            return redirect()->route('tasklist')->with('success', 'Task deleted successfully!');
        } else {
            return redirect()->route('tasklist')->with('error', 'Failed to delete task. Please try again.');
        }
    }
public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:To Do,In progress,QA Tester,Completed,Reopened',
    ]);

    $task = Task::find($id);

    $task->update(['status' => $request->status]);

    return redirect()->route('tasklist')->with('success', 'Task status updated successfully.');
}

}
