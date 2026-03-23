<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Liste des notifications de l'utilisateur connecté.
     */
    public function index(): View
    {
        $notifications = auth()->user()
            ->notifications()
            ->with('commande')
            ->latest()
            ->paginate(20);

        return view('admin.pages.notification.index', compact('notifications'));
    }

    /**
     * Ouvrir une notification et la marquer comme lue.
     */
    public function open(Notification $notification): RedirectResponse
    {
        abort_if($notification->user_id !== auth()->id(), 403);

        if (!$notification->lue_at) {
            $notification->update(['lue_at' => now()]);
        }

        if ($notification->commande_id) {
            return redirect()->route('commandes.show', $notification->commande_id);
        }

        return redirect()->route('notifications.index');
    }

    /**
     * Marquer une notification comme lue.
     */
    public function markAsRead(Notification $notification): RedirectResponse
    {
        abort_if($notification->user_id !== auth()->id(), 403);

        if (!$notification->lue_at) {
            $notification->update(['lue_at' => now()]);
        }

        return back()->with('success', 'Notification marquée comme lue.');
    }

    /**
     * Marquer toutes les notifications comme lues.
     */
    public function markAllAsRead(): RedirectResponse
    {
        auth()->user()
            ->notifications()
            ->whereNull('lue_at')
            ->update(['lue_at' => now()]);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Supprimer une notification.
     */
    public function destroy(Notification $notification): RedirectResponse
    {
        abort_if($notification->user_id !== auth()->id(), 403);

        $notification->delete();

        return back()->with('success', 'Notification supprimée.');
    }
}
