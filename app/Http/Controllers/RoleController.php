<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::paginate(10);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $records = Role::all();
        return view('roles.create', compact('records'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions_list' => 'required|array'
        ]);
        $record = Role::create($request->all());
        $record->permissions()->attach($request->permissions_list);
        session()->flash('Add');
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findorfail($id);
        $permissions = $role->permissions()->get();
        return view('roles.show', compact('role','permissions'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrfail($id);
        $permissions = Permission::all();
        return view('roles.edit', compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,'.$id,
            'permissions_list' => 'required|array'
        ]);
        $record = Role::findOrfail($id);
        $record->update($request->all());
        $record->permissions()->sync($request->permissions_list);
        session()->flash('edit');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Role::findorfail($id);
        $record->delete();
        session()->flash('delete');
        return back();
    }
}
