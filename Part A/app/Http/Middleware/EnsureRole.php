<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }
        if (! $user->is_active) {
            auth()->logout();
            return redirect()->route('login')->withErrors(['email' => 'Account is inactive.']);
        }
        if (! in_array($user->role, $roles, true)) {
            abort(403, 'You do not have permission to access this area.');
        }
        return $next($request);
    }
}
