<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Rules\desc;
use App\Models\Task;
use App\Rules\OnlyAlpha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BugController extends Controller
{
    public function index(Request $request)
    {
        $userId   = Auth::id();
$userRole = Auth::user()->role->role;

$query = Bug::with(['task', 'user']);

if ($userRole !== 'Tester') {
    $query->where(function ($q) use ($userId) {
        // Bug directly assigned to this user
        $q->where('user_id', $userId);

        //   OR bug belongs to a task assigned to this user
        //   ->orWhereHas('task', function ($q2) use ($userId) {
        //       $q2->where('assigned_to', $userId);
        //   })

        //   OR bug belongs to a task inside a project where user is leader
        //   ->orWhereHas('task.project', function ($q3) use ($userId) {
        //       $q3->where('leader_id', $userId);
        //   })

        //    OR bug belongs to a task inside a project where user is a member
        //   ->orWhereHas('task.project.members', function ($q4) use ($userId) {
        //       $q4->where('users.id', $userId);
        //   });
    });
}

$bugs = $query->orderBy('id', 'desc')->paginate(5);



        $bugs = $query->orderBy('id', 'desc')->paginate(5);
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
            'bug_name' => ['required', new OnlyAlpha],
            'bug_desc' => ['required', new desc],
            'task_id'  => 'required|exists:tasks,id',
            'user_id'  => 'required|exists:users,id',
            'priority' => 'required|string',
            'status'   => 'required|string',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/bugs'), $imageName);
            $data['image'] = 'uploads/bugs/' . $imageName;
        }

        $bug = Bug::create($data);

        if ($bug) {
            return redirect()->route('buglist')->with('success', 'Bug added successfully!');
        } else {
            return redirect()->route('buglist')->with('error', 'Failed to add bug. Please try again.');
        }
    }

    public function getAssignedUser($taskId)
    {
        $task = Task::with('assignedto')->find($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json($task->assignedto);
    }

    public function edit($id)
    {
        $bug = Bug::find($id);

        if (!$bug) {
            return redirect()->route('buglist')->with('error', 'Bug not found.');
        }

        $tasks = Task::all();
        return view('storebug', compact('bug', 'tasks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bug_name' => ['required', new OnlyAlpha],
            'bug_desc' => ['required', new desc],
            'task_id'  => 'required|exists:tasks,id',
            'user_id'  => 'required|exists:users,id',
            'priority' => 'required|in:High,Medium,Low',
            'status'   => 'required|in:Todo,In Progress,Completed',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $bug = Bug::find($id);

        if (!$bug) {
            return redirect()->route('buglist')->with('error', 'Bug not found.');
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($bug->image && file_exists(public_path($bug->image))) {
                unlink(public_path($bug->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/bugs'), $imageName);
            $data['image'] = 'uploads/bugs/' . $imageName;
        }

        $updated = $bug->update($data);

        if ($updated) {
            return redirect()->route('buglist')->with('success', 'Bug updated successfully.');
        } else {
            return redirect()->route('buglist')->with('error', 'Failed to update bug.');
        }
    }

    public function destroy($id)
    {
        $bug = Bug::find($id);

        if (!$bug) {
            return redirect()->route('buglist')->with('error', 'Bug not found.');
        }

        if ($bug->image && file_exists(public_path($bug->image))) {
            unlink(public_path($bug->image));
        }

        if ($bug->delete()) {
            return redirect()->route('buglist')->with('success', 'Bug deleted successfully.');
        } else {
            return redirect()->route('buglist')->with('error', 'Failed to delete bug.');
        }
    }

}
