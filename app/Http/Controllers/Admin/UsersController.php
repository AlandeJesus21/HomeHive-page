<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('admin.usuarios.index', compact('users'));
    }

    public function indexad() 
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());

        return redirect()->route('admin.index')
            ->with('success', 'Usuario actualizado correctamente');
    }


    public function destroy($id)
    {
        User::destroy($id);

        return redirect()->route('admin.index')
            ->with('success', 'Usuario eliminado correctamente');
    }
}