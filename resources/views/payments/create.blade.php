@extends('dashboard')

@section('dashboard-content')
<div class="animate__animated animate__fadeInUp">
    <div class="flex items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Generate a New Payment</h1>
    </div>
    <div class="content-card">
        <form method="POST" action="{{ route('payments.store') }}" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-600 font-semibold mb-2">Property Name</label>
                    <input type="text" name="property_name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-harmostays-orange transition" required>
                </div>
                <div>
                    <label class="block text-gray-600 font-semibold mb-2">Customer Name</label>
                    <input type="text" name="customer_name" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-harmostays-orange transition" required>
                </div>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold mb-2">Customer Email</label>
                <input type="email" name="customer_email" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-harmostays-orange transition" required>
            </div>
            <div>
                <label class="block text-gray-600 font-semibold mb-2">Booking Details</label>
                <textarea name="booking_details" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-harmostays-orange transition" rows="4" required></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-600 font-semibold mb-2">Price (USDC)</label>
                    <input type="number" name="price" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-harmostays-orange transition" step="0.01" min="0" required>
                </div>
                <div>
                    <label class="block text-gray-600 font-semibold mb-2">Currency</label>
                    <select name="currency" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-harmostays-orange transition">
                        <option value="USD">USD</option>
                        <option value="KES">KES</option>
                        <option value="USDC">USDC</option>
                    </select>
                </div>
            </div>
            <div class="pt-4">
                <button type="submit" class="w-full md:w-auto bg-harmostays-orange text-white font-bold py-3 px-8 rounded-lg hover:bg-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg">Generate Payment Link</button>
            </div>
        </form>
    </div>
</div>
@endsection
