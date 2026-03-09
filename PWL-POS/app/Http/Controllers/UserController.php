<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Praktikum 2.6 - CRUD Read (dengan Praktikum 2.7 - Relationship)
    public function index()
    {
        $user = UserModel::with('level')->get(); // Eager loading level relationship
        return view('user', ['data' => $user]);
    }

    // Praktikum 2.6 - CRUD Create (tampil form)
    public function tambah()
    {
        return view('user_tambah');
    }

    // Praktikum 2.6 - CRUD Create (simpan data)
    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user');
    }

    // Praktikum 2.6 - CRUD Update (tampil form)
    public function ubah($id)
    {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    // Praktikum 2.6 - CRUD Update (simpan data)
    public function ubah_simpan($id, Request $request)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }

    // Praktikum 2.6 - CRUD Delete
    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }

    public function profile($id, $name)
    {
        $user = [
            'id' => $id,
            'name' => $name,
            'email' => strtolower(str_replace(' ', '.', $name)) . '@pos.com',
            'role' => 'Kasir',
            'joined_date' => '2025-01-15'
        ];

        return view('user.profile', ['user' => $user]);
    }
}
