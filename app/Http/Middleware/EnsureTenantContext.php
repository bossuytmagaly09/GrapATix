<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check of we in een dashboard context zitten met een ingelogde gebruiker
        if (auth()->check()) {
            $user = auth()->user();
            
            if ($user->organization_id) {
                Session::put('active_organization_id', $user->organization_id);
            }

            // Beveiliging: als men op een dashboard url zit
            if ($request->is('dashboard*')) {
                if ($user->can('access-master-dashboard')) {
                    // Master Admin mag door (en wordt doorgestuurd als hij op de main dashboard root belandt)
                    if ($request->is('dashboard') && !$user->organization_id) {
                        return redirect()->route('dashboard.master');
                    }
                } elseif (!$user->organization_id) {
                    // Gewone gebruiker (klant) zonder organisatie probeert dashboard in te komen
                    return redirect()->route('home')->with('error', 'Je hebt geen toegang tot het dashboard.');
                }
            }
        }

        // 2. In de toekomst kunnen we hier checken op route parameters (slugs)
        // bijv. if ($request->route('organization_slug')) { ... }

        return $next($request);
    }
}
