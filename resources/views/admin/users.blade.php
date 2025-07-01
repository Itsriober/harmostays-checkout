@extends('dashboard')

@section('dashboard-content')
<div class="animate__animated animate__fadeInUp">
    <div class="flex items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Users</h1>
    </div>
    <div class="content-card">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Example row, replace with @foreach($users as $user) --}}
                    <tr class="transition hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-gray-700">1</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Admin User</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">admin@example.com</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-harmostays-green text-white">
                                Admin
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-06-01</td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
