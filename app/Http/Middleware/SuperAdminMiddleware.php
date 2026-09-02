<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();

        if (! $user->isSuperAdmin() &&
            ! $user->isAdmin() &&
            ! $user->isOperationsHead() &&
            ! $user->isMarketingHead() &&
            ! $user->isHrHead() &&
            ! $user->isComplianceOfficer()
        ) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
