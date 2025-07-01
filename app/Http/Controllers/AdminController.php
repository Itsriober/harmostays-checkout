<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with stats.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalPayments = Payment::count();
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        return view('admin.index', compact('totalUsers', 'totalPayments', 'totalRevenue'));
    }

    /**
     * List all users.
     */
    public function users()
    {
        $users = User::orderByDesc('created_at')->get();
        return view('admin.users', compact('users'));
    }

    /**
     * List all payments.
     */
    public function payments(Request $request)
    {
        $query = Payment::with('user')->orderByDesc('created_at');

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('booking_id', 'like', "%{$searchTerm}%")
                  ->orWhere('property_name', 'like', "%{$searchTerm}%")
                  ->orWhere('customer_name', 'like', "%{$searchTerm}%")
                  ->orWhere('customer_email', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        $payments = $query->get();

        return view('admin.payments', compact('payments'));
    }
}
