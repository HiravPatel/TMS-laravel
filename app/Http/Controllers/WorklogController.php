<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Rules\title;
use App\Models\Project;
use App\Models\Worklog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorklogController extends Controller
{

public function index(Request $request)
{
  $user = Auth::user();

    // Admin can see all logs, others only their own
    $query = Worklog::with(['project','user']);

    // Search functionality
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->Where('description', 'LIKE', "%{$search}%")
              ->orWhere('date', 'LIKE', "%{$search}%")
              ->orWhereHas('project', function($q2) use ($search) {
                  $q2->where('name', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('user', function($q4) use ($search) {
                  $q4->where('name', 'LIKE', "%{$search}%");
              });
        });
    }

    // Order and paginate
    $logs = $query->orderBy('date', 'desc')->paginate(10);

    return view('workloglist', compact('logs'));
}


    public function create()
    {
        $user = auth()->user();

        // Get only projects the logged-in user is assigned to
        $projects = Project::whereHas('members', function ($q) use ($user) {
    $q->where('member_id', $user->id);  // ✅ Correct
})->get();

        return view('storeworklog', compact('projects'));
    }



    public function store(Request $request)
    {
       $request->validate([
        'project_id' => 'required|exists:projects,id',
        'description' => 'nullable|string',
        'date' => 'required|date',
    ]);

    Worklog::create([
        'project_id' => $request->project_id,
        'description' => $request->description,
        'date' => $request->date,
        'user_id' => Auth::id(),
    ]);

    return redirect()->route('storeworklog')->with('success', 'Work added successfully!');
}
public function getDates($id)
{
    $project = Project::find($id);

    if (!$project) {
        return response()->json(['error' => 'Project not found'], 404);
    }

    return response()->json([
        'start_date' => $project->start_date,
        'due_date'   => $project->due_date,
    ]);
}
}
