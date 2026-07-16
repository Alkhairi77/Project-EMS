<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * Register participant to an event.
     */
    public function store(string $eventId)
    {
        $event = Event::where('_id', $eventId)->where('status', 'Published')->firstOrFail();
        $user = Auth::user();

        // Check if already registered
        $existing = Registration::where('event_id', $event->_id)
            ->where('user_id', $user->_id)
            ->first();

        if ($existing) {
            return redirect()->route('participant.events.show', $event->_id)
                ->with('error', 'Anda sudah terdaftar di event ini!');
        }

        // Check quota
        $currentRegistrations = Registration::where('event_id', $event->_id)->count();
        if ($currentRegistrations >= $event->kapasitas) {
            return redirect()->route('participant.events.show', $event->_id)
                ->with('error', 'Kuota Sudah Penuh!');
        }

        // Create registration
        Registration::create([
            'event_id' => $event->_id,
            'user_id' => $user->_id,
            'registration_code' => Registration::generateCode(),
            'status' => 'Registered',
            'registered_at' => now(),
        ]);

        return redirect()->route('participant.dashboard')
            ->with('success', 'Pendaftaran berhasil! Tiket digital Anda sudah tersedia.');
    }

    /**
     * Check in a participant (Organizer action).
     */
    public function checkin(string $id)
    {
        $registration = Registration::findOrFail($id);

        // Verify the organizer owns this event
        $event = Event::where('_id', $registration->event_id)
            ->where('user_id', Auth::user()->_id)
            ->firstOrFail();

        if ($registration->status === 'Checked In') {
            return redirect()->route('organizer.events.attendees', $event->_id)
                ->with('error', 'Peserta ini sudah di-check in sebelumnya!');
        }

        $registration->update(['status' => 'Checked In']);

        return redirect()->route('organizer.events.attendees', $event->_id)
            ->with('success', 'Peserta berhasil di-check in!');
    }
}
