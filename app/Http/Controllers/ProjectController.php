<?php

namespace App\Http\Controllers;

use App\Rules\desc;
use App\Models\User;
use App\Rules\title;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Mail\LeaderAssignedMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    $userId = Auth::id();
    $userRole = Auth::user()->role->role;

    $query = Project::with(['leader', 'members']);

    if (!in_array($userRole, ['Admin','Tester'])) {
        $query->where(function ($q) use ($userId) {
            $q->where('leader_id', $userId)
              ->orWhereHas('members', function ($q2) use ($userId) {
                  $q2->where('users.id', $userId);
              });
        });
    }

       if ($request->has('search') && $request->search != '') {
    $search = $request->search;
    $query->where(function ($q) use ($search) {
        $q->where('projects.name', 'LIKE', "%{$search}%")

        ->orWhereHas('leader', function ($q2) use ($search) {
            $q2->where('name', 'LIKE', "%{$search}%");
        })

        ->orWhereHas('members', function ($q3) use ($search) {
            $q3->where('name', 'LIKE', "%{$search}%");
        })
         ->orWhereRaw("UPPER(CONCAT(LEFT(SUBSTRING_INDEX(projects.name, ' ', 1), 1),
                                    LEFT(SUBSTRING_INDEX(SUBSTRING_INDEX(projects.name, ' ', 2), ' ', -1), 1),
                                    LEFT(SUBSTRING_INDEX(SUBSTRING_INDEX(projects.name, ' ', 3), ' ', -1), 1))) LIKE ?", ["%".strtoupper($search)."%"]);
    });
}


        $projects = $query->orderBy('id', 'desc')->paginate(12);

        return view('projectlist', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('storeproject', ['activePage' => 'storeproject'], compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required', new title],
            'description' => ['required', new desc],
            'start_date'  => 'required|date',
            'due_date'    => 'required|date|after_or_equal:start_date',
            'leader_id'   => 'required|exists:users,id',
            'members'     => 'required|array|exists:users,id',
        ]);

        $project = Project::create([
            'name'        => $request->name,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'due_date'    => $request->due_date,
            'leader_id'   => $request->leader_id,
        ]);

        if ($project) {
            if (!empty($request->members)) {
                $project->members()->attach($request->members);
            }

            if ($project->leader) {
                Mail::to($project->leader->email)->send(new LeaderAssignedMail($project));
            }

            return redirect()->route('projectlist')->with('success', 'Project created successfully.');
        } else {
            return back()->with('error', 'Failed to create project. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit($id)
    {
        $project = Project::with('members')->find($id);

        if (!$project) {
            return redirect()->route('projectlist')->with('error', 'Project not found.');
        }

        $users = User::all();
        return view('storeproject', ['activePage' => 'storeproject'], compact('project', 'users'));
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => ['required', new title],
            'description' => ['required', new desc],
            'start_date'  => 'required|date',
            'due_date'    => 'required|date|after_or_equal:start_date',
            'leader_id'   => 'required|exists:users,id',
            'members'     => 'required|array|exists:users,id',
        ]);

        $project = Project::find($id);

        if (!$project) {
            return redirect()->route('projectlist')->with('error', 'Project not found.');
        }

        $updated = $project->update([
            'name'        => $request->name,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'due_date'    => $request->due_date,
            'leader_id'   => $request->leader_id,
        ]);

        if ($updated) {
            $project->members()->sync($request->members);
            return redirect()->route('projectlist')->with('success', 'Project updated successfully.');
        } else {
            return redirect()->route('projectlist')->with('error', 'Failed to update project. Please try again.');
        }
    }

    /**
     * Remove the specified project.
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return redirect()->route('projectlist')->with('error', 'Project not found.');
        }

        $project->members()->detach();

        if ($project->delete()) {
            return redirect()->route('projectlist')->with('success', 'Project deleted successfully.');
        } else {
            return redirect()->route('projectlist')->with('error', 'Failed to delete project. Please try again.');
        }
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
