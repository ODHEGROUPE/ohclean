<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form (admin side).
     */
    public function edit(Request $request): View
    {
        return view('admin.pages.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the client profile page.
     */
    public function clientProfile(Request $request): View
    {
        $user = $request->user();
        $commandes = $user->commandes()->with('ligneCommandes.article')->latest()->take(5)->get();

        // Récupérer la dernière commande avec des coordonnées GPS pour la carte
        $derniereCommandeAvecGPS = $user->commandes()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->first();

        return view('client.pages.profile', [
            'user' => $user,
            'commandes' => $commandes,
            'derniereCommandeAvecGPS' => $derniereCommandeAvecGPS,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Rediriger vers la bonne page selon le contexte
        $referer = $request->headers->get('referer');
        if (str_contains($referer, '/admin/')) {
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }

        return Redirect::route('client.profile')->with('status', 'profile-updated');
    }

    /**
     * Update client profile.
     */
    public function updateClientProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user()->id],
            'telephone' => ['nullable', 'string', 'max:20'],
            'adresse' => ['nullable', 'string', 'max:500'],
            'ville' => ['nullable', 'string', 'max:100'],
        ]);

        $user = $request->user();
        $user->fill($request->only(['name', 'email', 'telephone', 'adresse', 'ville']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('client.profile')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
