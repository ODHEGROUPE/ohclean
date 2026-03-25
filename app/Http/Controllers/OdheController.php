<?php

namespace App\Http\Controllers;

use App\Models\OdheContent;
use App\Models\OdheTeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OdheController extends Controller
{
    public function edit(): View
    {
        $odheContent = OdheContent::firstOrCreate([], [
            'hero_title' => 'À Propos de Nous',
            'hero_subtitle' => "Découvrez notre histoire et notre engagement envers l'excellence du pressing",
            'story_badge' => 'Notre Histoire',
            'story_title' => 'Votre Pressing de Confiance depuis 2020',
            'team_title' => 'Rencontrez Notre Équipe',
            'team_subtitle' => 'Des professionnels passionnés et expérimentés au service de votre satisfaction.',
        ]);

        $teamMembers = OdheTeamMember::query()
            ->orderBy('display_order')
            ->orderBy('id')
            ->get();

        return view('admin.pages.odhe.about', compact('odheContent', 'teamMembers'));
    }

    public function updateContent(Request $request): RedirectResponse
    {
        $odheContent = OdheContent::firstOrCreate([]);

        $validated = $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string|max:1000',
            'story_badge' => 'nullable|string|max:255',
            'story_title' => 'nullable|string|max:255',
            'story_text_1' => 'nullable|string',
            'story_text_2' => 'nullable|string',
            'story_image' => 'nullable|image|max:4096',
            'team_title' => 'nullable|string|max:255',
            'team_subtitle' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('story_image')) {
            if ($odheContent->story_image) {
                Storage::disk('public')->delete($odheContent->story_image);
            }
            $validated['story_image'] = $request->file('story_image')->store('odhe', 'public');
        }

        $odheContent->update($validated);

        return redirect()
            ->route('admin.odhe.about.edit')
            ->with('success', 'Contenu À propos mis à jour avec succès.');
    }

    public function storeTeamMember(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'team_function' => 'nullable|string|max:255',
            'team_photo' => 'nullable|image|max:4096',
            'show_in_team' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'name' => $validated['name'],
            'team_function' => $validated['team_function'] ?? null,
            'show_in_team' => $request->boolean('show_in_team'),
            'display_order' => $validated['display_order'] ?? 0,
        ];

        if ($request->hasFile('team_photo')) {
            $data['team_photo'] = $request->file('team_photo')->store('odhe/team', 'public');
        }

        OdheTeamMember::create([
            'name' => $data['name'],
            'function' => $data['team_function'],
            'photo' => $data['team_photo'] ?? null,
            'is_active' => $data['show_in_team'],
            'display_order' => $data['display_order'],
        ]);

        return redirect()
            ->route('admin.odhe.about.edit')
            ->with('success', 'Membre ajouté à la team ODHE.');
    }

    public function updateTeamMember(Request $request, OdheTeamMember $member): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'team_function' => 'nullable|string|max:255',
            'team_photo' => 'nullable|image|max:4096',
            'show_in_team' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'name' => $validated['name'],
            'function' => $validated['team_function'] ?? null,
            'is_active' => $request->boolean('show_in_team'),
            'display_order' => $validated['display_order'] ?? 0,
        ];

        if ($request->hasFile('team_photo')) {
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $data['photo'] = $request->file('team_photo')->store('odhe/team', 'public');
        }

        $member->update($data);

        return redirect()
            ->route('admin.odhe.about.edit')
            ->with('success', 'Membre de la team mis à jour.');
    }

    public function destroyTeamMember(OdheTeamMember $member): RedirectResponse
    {
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }

        $member->delete();

        return redirect()
            ->route('admin.odhe.about.edit')
            ->with('success', 'Membre supprimé de la team ODHE.');
    }
}
