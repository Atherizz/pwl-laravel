<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
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
