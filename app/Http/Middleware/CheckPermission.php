<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\RoleMapping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $permission)
    {
        $user = Auth::user();

        if ($user && $user->role && ($user->role->role) === 'Admin') {
        return $next($request);
        }

        $hasPermission = RoleMapping::where('role_id', $user->role_id)
            ->whereHas('permission', function ($q) use ($permission) {
                $q->where('name', $permission);
            })
            ->exists();

        if (!$hasPermission) {
            abort(403, 'You do not have access to this page.');
        }

        return $next($request);
    }

}
