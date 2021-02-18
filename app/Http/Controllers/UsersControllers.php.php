<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Validation\Rule;

class UsersControllers extends Controller
{


    /**
     * Add User by Admin
     *
     * @param  [string] email
     * @param  [string] nom
     * @param  [string] prenom
     * @param  [string] role
     * @return [string] notif_email
     */

    public function addUser(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email|unique:users',
            'role' => [
                'required',
                'string',
                Rule::in(['admin', 'user']),
            ],
        ]);

        $password = uniqid();
        $user = new User([
            'email' => $request->email,
            'role' => $request->role,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'status' => $request->status,
            'password' => bcrypt($password),
        ]);

        $user->save();
        $user->password = $password;
        return response()->json([
            'user' => $user,
            'message' => 'Successfully created user!'
        ], 201);
    }
    //
    public function getUser(Request $request)
    {
        $admin = Auth::user();

        if($admin)
    }
}
