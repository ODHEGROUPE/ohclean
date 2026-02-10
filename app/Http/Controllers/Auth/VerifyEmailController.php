<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return $this->redirectByRole($user, true);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->redirectByRole($user, true);
    }

    /**
     * Redirige l'utilisateur selon son rôle
     */
    private function redirectByRole($user, bool $verified = false): RedirectResponse
    {
        $query = $verified ? '?verified=1' : '';

        if (in_array($user->role, ['ADMIN', 'AGENT_PRESSING'])) {
            return redirect()->intended(route('admin', absolute: false) . $query);
        }

        return redirect()->intended(route('home', absolute: false) . $query);
    }
}
