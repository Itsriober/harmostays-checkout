@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full flex flex-col items-center animate-fadeIn">
        <svg class="animate-spin h-12 w-12 text-indigo-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
        <h2 class="text-xl font-bold mb-2">Redirecting to PayGate...</h2>
        <p class="mb-4 text-gray-600">Please wait while we securely redirect you to complete your payment.</p>
        <div class="text-sm text-gray-400 mb-2">Do not close this window.</div>
        <div class="text-xs text-gray-500 break-all">PayGate URL: <span id="paygate-url">{{ $paygateUrl ?? 'N/A' }}</span></div>
        @if(isset($errorMsg))
            <div class="mt-4 p-3 bg-red-100 text-red-700 rounded-lg">
                <div class="font-semibold mb-2">Error:</div>
                <div class="text-sm">{{ $errorMsg }}</div>
                
                @if(isset($debugInfo))
                    <details class="mt-3">
                        <summary class="cursor-pointer text-xs font-medium">Debug Information</summary>
                        <div class="mt-2 text-xs bg-red-50 p-2 rounded border">
                            @if(isset($debugInfo['status']))
                                <div><strong>Status Code:</strong> {{ $debugInfo['status'] }}</div>
                            @endif
                            @if(isset($debugInfo['available_fields']))
                                <div><strong>Available Fields:</strong> {{ implode(', ', $debugInfo['available_fields']) }}</div>
                            @endif
                            @if(isset($debugInfo['raw_response']))
                                <div class="mt-1"><strong>Raw Response:</strong></div>
                                <pre class="whitespace-pre-wrap text-xs">{{ $debugInfo['raw_response'] }}</pre>
                            @endif
                        </div>
                    </details>
                @endif
            </div>
        @endif
    </div>
</div>
<script>
    var paygateUrl = @json($paygateUrl ?? '');
    if(paygateUrl && paygateUrl !== 'N/A') {
        setTimeout(function() {
            window.location.href = paygateUrl;
        }, 1500);
    }
</script>
@endsection
