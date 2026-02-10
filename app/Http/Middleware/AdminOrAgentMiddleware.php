<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrAgentMiddleware
{
    /**
     * Handle an incoming request.
     * Seuls les administrateurs et les agents pressing peuvent accéder au dashboard
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Vérifier si l'utilisateur est admin ou agent pressing
        if (!in_array($user->role, ['ADMIN', 'AGENT_PRESSING'])) {
            return redirect()->route('home')->with('error', 'Accès non autorisé. Vous devez être administrateur ou agent pressing.');
        }

        return $next($request);
    }
}
