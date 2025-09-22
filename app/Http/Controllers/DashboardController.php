<?php

namespace App\Http\Controllers;

use App\Models\Bug;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
{
     $projects = Project::all();
    $selectedProject = null;

    if ($request->has('project_id')) {
        $selectedProject = Project::with('tasks')->find($request->project_id);
    }


    return view('dashboard', [
        'projectsCount' => Project::count(),
        'tasksCount'    => Task::count(),
        'bugsCount'     => Bug::count(),
        'usersCount'    => User::count(),
        'recentProjects' => Project::latest()->take(5)->get(),
        'recentUsers'    => User::latest()->take(4)->get(),
        'projects' => $projects,
        'selectedProject' => $selectedProject,
    ]);
}

}
