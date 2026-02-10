<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnlyMiddleware
{
    /**
     * Handle an incoming request.
     * Seul l'administrateur peut effectuer cette action
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Vérifier si l'utilisateur est admin
        if ($user->role !== 'ADMIN') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Accès non autorisé. Seul l\'administrateur peut effectuer cette action.'
                ], 403);
            }
            return redirect()->back()->with('error', 'Accès non autorisé. Seul l\'administrateur peut effectuer cette action.');
        }

        return $next($request);
    }
}
