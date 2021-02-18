<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Validation\Rule;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        error_log("CHECK ADMIN");
        $admin = Auth::user();
        if ($admin->role !== "admin") {
            return response()->json([
                'error' => true,
                'message' => 'Vous n\'êtes pas autorisé à faire cette opération'
            ], 401);
        }
        return $next($request);
    }
}
