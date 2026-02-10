<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Service;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Article::with('service');

        // Filtre par service
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Filtre par statut (actif/inactif)
        if ($request->filled('actif')) {
            $query->where('actif', $request->actif === '1');
        }

        // Filtre par prix
        if ($request->filled('prix_min')) {
            $query->where('prix', '>=', $request->prix_min);
        }
        if ($request->filled('prix_max')) {
            $query->where('prix', '<=', $request->prix_max);
        }

        // Recherche par nom ou description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $articles = $query->latest()->paginate(10)->withQueryString();
        $services = Service::all();
        return view('admin.pages.article.list', compact('articles', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $services = Service::all();
        return view('admin.pages.article.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
        ], [
            'service_id.required' => 'Le service est obligatoire',
            'nom.required' => 'Le nom est obligatoire',
            'prix.required' => 'Le prix est obligatoire',
            'prix.min' => 'Le prix doit être positif',
        ]);

        try {
            Article::create($validated);

            return redirect()
                ->route('articles.index')
                ->with('success', 'Article créé avec succès');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur s\'est produite lors de la création')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): View
    {
        $article->load('service');
        return view('admin.pages.article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): View
    {
        $services = Service::all();
        return view('admin.pages.article.update', compact('article', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'actif' => 'boolean',
        ]);

        try {
            $article->update([
                'service_id' => $validated['service_id'],
                'nom' => $validated['nom'],
                'description' => $validated['description'] ?? null,
                'prix' => $validated['prix'],
                'actif' => $request->has('actif'),
            ]);

            return redirect()
                ->route('articles.index')
                ->with('success', 'Article mis à jour avec succès');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur s\'est produite lors de la mise à jour')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): RedirectResponse
    {
        try {
            $article->delete();

            return redirect()
                ->route('articles.index')
                ->with('success', 'Article supprimé avec succès');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Impossible de supprimer cet article car il est utilisé dans des commandes');
        }
    }
}
