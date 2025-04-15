<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,',
                'password' => 'required|string',
                'role' => 'required|string'
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role
            ]);

            return redirect()->route('users')->with('success', 'Berhasil Menambah User');

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {

            $user = User::findOrFail($id);
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable',
                'role' => 'required|string'
            ]);

            if (!$request->password) {
                $request->password = $user->password;
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->role = $request->role;

            $user->save();
            return redirect()->route('users')->with('success', 'Berhasil Mengupdate User');

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function destroy($id) {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('users')->with('success', 'Berhasil Menghapus User');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

}
