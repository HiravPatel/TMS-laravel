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

    $query = Worklog::with(['project','user']);

    if ($user->role->role !== 'Admin') {   
        $query->where('user_id', $user->id);
    }

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('description', 'LIKE', "%{$search}%")
              ->orWhere('date', 'LIKE', "%{$search}%")
              ->orWhereHas('project', function($q2) use ($search) {
                  $q2->where('name', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('user', function($q4) use ($search) {
                  $q4->where('name', 'LIKE', "%{$search}%");
              });
        });
    }

    $logs = $query->orderBy('date')->paginate(10);

    return view('workloglist', compact('logs'));
}



    public function create()
    {
        $user = auth()->user();

        $projects = Project::whereHas('members', function ($q) use ($user) {
    $q->where('member_id', $user->id);  
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
public function edit($id)
{
    $user = auth()->user();
    $log = Worklog::findOrFail($id);

    $projects = Project::whereHas('members', function ($q) use ($user) {
        $q->where('member_id', $user->id);  
    })->get();

    return view('storeworklog', compact('log', 'projects'));
}

public function update(Request $request, $id)
{
    $log = Worklog::findOrFail($id);

    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'description' => 'nullable|string',
        'date' => 'required|date',
    ]);

    $log->update([
        'project_id' => $request->project_id,
        'description' => $request->description,
        'date' => $request->date,
    ]);

    return redirect()->route('workloglist')->with('success', 'Work log updated successfully!');
}

public function destroy($id){

    $log = Worklog::find($id);

    $log->delete();

    return redirect()->route('workloglist')->with('success', 'Work log deleted successfully!');
}
}
