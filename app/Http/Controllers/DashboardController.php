<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $payments = \App\Models\Payment::where('user_id', auth()->id())->get();
        return view('dashboard-home', compact('payments'));
    }
}
