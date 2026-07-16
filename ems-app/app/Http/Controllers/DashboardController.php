<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Redirect user to proper dashboard based on role.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'organizer') {
            return redirect()->route('organizer.dashboard');
        }

        return redirect()->route('participant.dashboard');
    }
}
