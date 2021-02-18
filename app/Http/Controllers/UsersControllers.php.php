<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Validation\Rule;

class UsersControllers extends Controller
{
    //
    public function getUser(Request $request)
    {
        $admin = Auth::user();
    }
}
