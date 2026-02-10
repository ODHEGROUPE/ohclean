<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Service::withCount('articles');

        // Recherche par nom
        if ($request->filled('search')) {
            $query->where('nom', 'like', "%{$request->search}%");
        }

        // Tri par nombre d'articles
        if ($request->filled('tri')) {
            switch ($request->tri) {
                case 'articles_asc':
                    $query->orderBy('articles_count', 'asc');
                    break;
                case 'articles_desc':
                    $query->orderBy('articles_count', 'desc');
                    break;
                case 'nom_asc':
                    $query->orderBy('nom', 'asc');
                    break;
                case 'nom_desc':
                    $query->orderBy('nom', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $services = $query->paginate(10)->withQueryString();
        return view('admin.pages.service.list', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.pages.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();

            // Gestion de l'image
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('services', 'public');
                $validated['image'] = $path;
            }

            Service::create($validated);

            return redirect()
                ->route('services.index')
                ->with('success', 'Service créé avec succès.');
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
    public function show(Service $service): View
    {
        return view('admin.pages.service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): View
    {
        $service->load('articles');
        return view('admin.pages.service.update', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        try {
            $validated = $request->validated();

            // Gestion de l'image
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image si elle existe
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }
                $path = $request->file('image')->store('services', 'public');
                $validated['image'] = $path;
            }

            $service->update($validated);

            return redirect()
                ->route('services.index')
                ->with('success', 'Service mis à jour avec succès.');
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
    public function destroy(Service $service): RedirectResponse
    {
        try {
            // Supprimer l'image si elle existe
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $service->delete();

            return redirect()
                ->route('services.index')
                ->with('success', 'Service supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Une erreur s\'est produite lors de la suppression');
        }
    }
}
