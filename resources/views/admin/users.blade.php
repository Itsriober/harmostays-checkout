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
                    @forelse($users as $user)
                    <tr class="transition hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-gray-700">{{ $user->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->is_admin)
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-harmostays-green text-white">
                                    Admin
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">
                                    User
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-400 py-10">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
