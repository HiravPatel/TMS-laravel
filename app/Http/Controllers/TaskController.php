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

    // If Admin, show all tasks
    if ($userRole !== 'Admin') {
    $query->where(function ($q) use ($userId) {
        // Task is directly assigned to the user
        $q->where('assigned_to', $userId);

          // Task belongs to a project where user is leader
        //   ->orWhereHas('project', function ($q2) use ($userId) {
        //       $q2->where('leader_id', $userId);
        //   })

          // Task belongs to a project where user is a member
        //   ->orWhereHas('project.members', function ($q3) use ($userId) {
        //       $q3->where('users.id', $userId);
        //   });
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

}
