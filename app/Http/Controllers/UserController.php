<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact( 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'roles_list' => 'required|array'
        ]);
        $record = User::create($request->all());
        //$record->roles()->attach($request->roles_list);
        $record->assignRole($request->input('roles_list'));
        return redirect()->route('users.index')
            ->with('success', 'تم اضافة المستخدم بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = User::findOrfail($id);
        return view('users.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:users,name,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'required|confirmed',
            'roles_list' => 'required|array'
        ]);
        $record = User::findOrfail($id);
        $record->update($request->all());
        $record->roles()->sync($request->roles_list);
        session()->flash('Edited');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = User::findorfail($id);
        $record->delete();
        session()->flash('Deleted');
        return back();
    }

}
