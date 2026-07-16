<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Organizer Dashboard - show metrics and event list.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $events = Event::where('user_id', $user->_id)->orderBy('created_at', 'desc')->get();

        $totalEvents = $events->count();
        $activeEvents = $events->where('status', 'Published')->count();

        // Count total registrations across all organizer's events
        $eventIds = $events->pluck('_id')->toArray();
        $totalParticipants = Registration::whereIn('event_id', $eventIds)->count();

        return view('organizer.dashboard', compact('events', 'totalEvents', 'activeEvents', 'totalParticipants'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('organizer.events.create');
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'lokasi' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'harga' => 'required|integer|min:0',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam' => 'required|string',
            'kategori' => 'required|in:Workshop,Seminar,Competition,Bootcamp,Webinar,Festival',
            'status' => 'required|in:Draft,Published,Cancelled',
        ]);

        $validated['user_id'] = Auth::user()->_id;

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('banners', 'public');
            $validated['banner'] = $path;
        }

        Event::create($validated);

        return redirect()->route('organizer.dashboard')->with('success', 'Event berhasil dibuat!');
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(string $id)
    {
        $event = Event::where('_id', $id)->where('user_id', Auth::user()->_id)->firstOrFail();
        return view('organizer.events.edit', compact('event'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::where('_id', $id)->where('user_id', Auth::user()->_id)->firstOrFail();

        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'lokasi' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'harga' => 'required|integer|min:0',
            'tanggal' => 'required|date',
            'jam' => 'required|string',
            'kategori' => 'required|in:Workshop,Seminar,Competition,Bootcamp,Webinar,Festival',
            'status' => 'required|in:Draft,Published,Cancelled',
        ]);

        // Handle banner upload
        if ($request->hasFile('banner')) {
            // Delete old banner
            if ($event->banner) {
                Storage::disk('public')->delete($event->banner);
            }
            $path = $request->file('banner')->store('banners', 'public');
            $validated['banner'] = $path;
        }

        $event->update($validated);

        return redirect()->route('organizer.dashboard')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Delete the specified event.
     */
    public function destroy(string $id)
    {
        $event = Event::where('_id', $id)->where('user_id', Auth::user()->_id)->firstOrFail();

        // Delete banner file
        if ($event->banner) {
            Storage::disk('public')->delete($event->banner);
        }

        // Delete associated registrations
        Registration::where('event_id', $event->_id)->delete();

        $event->delete();

        return redirect()->route('organizer.dashboard')->with('success', 'Event berhasil dihapus!');
    }

    /**
     * Show attendees for a specific event.
     */
    public function attendees(string $id)
    {
        $event = Event::where('_id', $id)->where('user_id', Auth::user()->_id)->firstOrFail();
        $registrations = Registration::where('event_id', $event->_id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Load user data for each registration
        foreach ($registrations as $reg) {
            $reg->participant = \App\Models\User::find($reg->user_id);
        }

        return view('organizer.events.attendees', compact('event', 'registrations'));
    }
}
