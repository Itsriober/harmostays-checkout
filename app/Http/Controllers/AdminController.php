<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin dashboard home
    public function index()
    {
        return view('admin.index');
    }

    // List all users
    public function users()
    {
        // Placeholder: Fetch all users
        return view('admin.users');
    }

    // List all payments
    public function payments()
    {
        // Placeholder: Fetch all payments
        return view('admin.payments');
    }
}
