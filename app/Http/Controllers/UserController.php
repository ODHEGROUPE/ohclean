<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Affiche la liste des utilisateurs
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Filtre par rôle
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filtre par date d'inscription
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        // Recherche par nom, email ou téléphone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();
        return view('admin.pages.user.list', compact('users'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create(): View
    {
        return view('admin.pages.user.create');
    }

    /**
     * Enregistre un nouvel utilisateur
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'role' => 'required|in:CLIENT,AGENT_PRESSING,ADMIN',
        ], [
            'name.required' => 'Le nom est obligatoire',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'Cet email est déjà utilisé',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
            'role.required' => 'Le rôle est obligatoire',
            'role.in' => 'Le rôle sélectionné n\'est pas valide',
        ]);

        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'telephone' => $validated['telephone'],
                'adresse' => $validated['adresse'],
                'ville' => $validated['ville'],
                'role' => $validated['role'],
            ]);

            return redirect()
                ->route('users.index')
                ->with('success', 'Utilisateur créé avec succès');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur s\'est produite lors de la création')
                ->withInput();
        }
    }

    /**
     * Affiche les détails d'un utilisateur
     */
    public function show(User $user): View
    {
        return view('admin.pages.user.show', compact('user'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(User $user): View
    {
        return view('admin.pages.user.update', compact('user'));
    }

    /**
     * Met à jour un utilisateur
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'role' => 'required|in:CLIENT,AGENT_PRESSING,ADMIN',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.unique' => 'Cet email est déjà utilisé',
            'role.required' => 'Le rôle est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
        ]);

        try {
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'telephone' => $validated['telephone'] ?? null,
                'adresse' => $validated['adresse'] ?? null,
                'ville' => $validated['ville'] ?? null,
                'role' => $validated['role'],
            ];

            // Mettre à jour le mot de passe si fourni
            if ($request->filled('password')) {
                $data['password'] = Hash::make($validated['password']);
            }

            $user->update($data);

            return redirect()
                ->route('users.index')
                ->with('success', 'Utilisateur mis à jour avec succès');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur s\'est produite lors de la mise à jour')
                ->withInput();
        }
    }

    /**
     * Supprime un utilisateur
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->delete();

            return redirect()
                ->route('users.index')
                ->with('success', 'Utilisateur supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur s\'est produite lors de la suppression');
        }
    }
}
