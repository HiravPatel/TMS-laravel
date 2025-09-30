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
        $q->where('user_id', $userId);
    });
}

  if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('bug_name', 'LIKE', "%{$search}%")          
              ->orWhere('bug_desc', 'LIKE', "%{$search}%")
              ->orWhereHas('task', function ($q2) use ($search) { 
                  $q2->where('task_name', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('user', function ($q3) use ($search) {
                  $q3->where('name', 'LIKE', "%{$search}%");
              });
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
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            ], [
            'image.required' => 'Please upload an image.',
            'image.image'    => 'The file must be an image.',
            'image.mimes'    => 'Only jpeg, jpg, and png images are allowed.',
            'image.max'      => 'The image size must not exceed 2MB.',
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
            'status'   => 'required|in:Todo,In Progress,QA Tester,Completed,Reopened',
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            ], [
            'image.required' => 'Please upload an image.',
            'image.image'    => 'The file must be an image.',
            'image.mimes'    => 'Only jpeg, jpg, and png images are allowed.',
            'image.max'      => 'The image size must not exceed 2MB.',
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
   public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Todo,In Progress,QA Tester,Completed,Reopened',
    ]);

    $bug = Bug::find($id);
    $bug->status = $request->status;
    $bug->save();

    if ($request->status === 'Reopened' && Auth::user()->role->role == 'Tester') {
        return redirect()->route('editbug', $bug->id)
            ->with('success', 'Bug reopened. Please update details.');
    }

    return redirect()->route('buglist')->with('success', 'Status updated successfully!');
}


}
