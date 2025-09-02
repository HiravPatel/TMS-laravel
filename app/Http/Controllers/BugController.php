<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Rules\desc;
use App\Models\Task;
use App\Rules\OnlyAlpha;
use Illuminate\Http\Request;

class BugController extends Controller
{
    public function index(Request $request)
    {
        $query = Bug::with(['task', 'user']);

        if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

     if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('bug_name', 'LIKE', "%{$search}%")
             ->orWhereHas('task', function ($q2) use ($search) {
                  $q2->where('task_name', 'LIKE', "%{$search}%");
             })
                   ->orWhereHas('user', function ($q3) use ($search) {
                  $q3->where('name', 'LIKE', "%{$search}%");
            });
        });
    }

    $bugs = $query->orderBy('id', 'desc')->paginate(2);
        return view('buglist', compact('bugs'));
    }

    public function create()
    {
        $tasks = Task::with('assignedto')->get();
        return view('storebug', compact('tasks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bug_name' => ['required',new OnlyAlpha],
            'bug_desc' => ['required',new desc],
            'task_id'  => 'required|exists:tasks,id',
            'user_id'  => 'required|exists:users,id',
            'priority' => 'required|string',
            'status'   => 'required|string',
        ]);

        Bug::create($request->all());

        return redirect()->route('buglist')->with('success', 'Bug added successfully!');
    }

    public function getAssignedUser($taskId)
    {
        $task = Task::with('assignedto')->find($taskId);
        return response()->json($task->assignedto);
    }

    public function edit($id)
    {
        $bug = Bug::find($id);
        $tasks = Task::all();
        return view('storebug', compact('bug', 'tasks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bug_name' => ['required',new OnlyAlpha],
            'bug_desc' => ['required',new desc],
            'task_id'  => 'required|exists:tasks,id',
            'user_id'  => 'required|exists:users,id',
            'priority' => 'required|in:High,Medium,Low',
            'status'   => 'required|in:Todo,In Progress,Completed',
        ]);

        $bug = Bug::find($id);
        $bug->update($request->all());

        return redirect()->route('buglist')->with('success', 'Bug updated successfully.');
    }

    public function destroy($id)
    {
        $bug = Bug::find($id);
        $bug->delete();

        return redirect()->route('buglist')->with('success', 'Bug deleted successfully.');
    }
}
