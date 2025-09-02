<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        
        $query = User::with('role');

    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;

        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('cno', 'like', "%{$search}%")
              ->orWhereHas('role', function($roleQuery) use ($search) {
                  $roleQuery->where('role', 'like', "%{$search}%");
              });
        });
    }

    $users = $query->orderBy('id')->paginate(3);

        return view('employeelist',['activePage' => 'employeelist'], compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('addemployee',['activePage' => 'addemployee'], compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('editemployee', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'name'    => 'required|string|max:50',
        'email'   => 'required|email|unique:users,email,' . $id,
        'cno'     => 'nullable|digits:10',
        'role_id' => 'required|exists:roles,id',
    ]);

    $user = User::find($id);
    $user->update([
        'name'    => $request->name,
        'email'   => $request->email,
        'cno'     => $request->cno,
        'role_id' => $request->role_id,
    ]);

    return redirect()->route('employeelist')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

    return redirect()->route('employeelist')->with('success', 'Employee deleted successfully.');
    }
}
