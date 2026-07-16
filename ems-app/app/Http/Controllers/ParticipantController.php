<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    /**
     * Participant Dashboard - show tickets.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $registrations = Registration::where('user_id', $user->_id)
            ->orderBy('created_at', 'desc')
            ->get();

        $upcoming = collect();
        $past = collect();

        foreach ($registrations as $reg) {
            $event = Event::find($reg->event_id);
            if ($event) {
                $reg->event = $event;
                if ($event->tanggal >= now()->format('Y-m-d')) {
                    $upcoming->push($reg);
                } else {
                    $past->push($reg);
                }
            }
        }

        return view('participant.dashboard', compact('upcoming', 'past'));
    }

    /**
     * Browse all published events with search and filter.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategori = $request->get('kategori');

        $events = Event::published()
            ->search($search)
            ->kategori($kategori)
            ->orderBy('tanggal', 'asc')
            ->get();

        $categories = ['Workshop', 'Seminar', 'Competition', 'Bootcamp', 'Webinar', 'Festival'];

        return view('participant.index', compact('events', 'categories', 'search', 'kategori'));
    }

    /**
     * Show event details.
     */
    public function show(string $id)
    {
        $event = Event::where('_id', $id)->where('status', 'Published')->firstOrFail();
        $sisaKuota = $event->sisa_kuota;

        // Check if current user already registered
        $alreadyRegistered = false;
        if (Auth::check()) {
            $alreadyRegistered = Registration::where('event_id', $event->_id)
                ->where('user_id', Auth::user()->_id)
                ->exists();
        }

        return view('participant.show', compact('event', 'sisaKuota', 'alreadyRegistered'));
    }
}
