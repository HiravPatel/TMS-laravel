<?php

namespace App\Http\Controllers;

use App\Rules\title;
use App\Models\Project;
use App\Models\Worklog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorklogController extends Controller
{

public function index(Request $request)
{
   $query = Worklog::with(['project', 'user']);

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")->orWhere('date', 'LIKE', "%{$search}%")
              ->orWhereHas('project', function($q2) use ($search) {
                  $q2->where('name', 'LIKE', "%{$search}%");
              })
              ->orWhereHas('user', function($q3) use ($search) {
                  $q3->where('name', 'LIKE', "%{$search}%");
              });
        });
    }

    $logs = $query->orderBy('date')->paginate(5);

    return view('workloglist', compact('logs'));
    }


    public function create()
    {
        $projects = Project::all();
        return view('storeworklog', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', new title],
            'project_id' => 'required|exists:projects,id',
            'date' => 'required|date',
        ]);

        Worklog::create([
            'title' => $request->title,
            'project_id' => $request->project_id,
            'date' => $request->date,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('workloglist')->with('success', 'Work added successfully!');
    }
}
