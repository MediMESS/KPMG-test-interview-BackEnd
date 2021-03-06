<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Validation\Rule;
use SebastianBergmann\Environment\Console;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] nom
     * @param  [string] prenom
     * @param  [string] role
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|unique:users',
            'role' => [
                'required',
                'string',
                Rule::in(['admin', 'user']),
            ],
            'password' => 'required|string|min:8|max:24',
        ]);
        $user = new User([
            'email' => $request->email,
            'role' => $request->role,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'status' => 'active',
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'error' => true,
                'message' => 'Erreur, veuillez vérifier vos informations'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        unset($user['password']);
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'user' => $user,
            'ok' => true,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ], 200);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'ok' => true,
            'message' => 'Vous êtes déconnecté'
        ], 200);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        echo Auth::user();
        // return response()->json($request->user());
    }
}
