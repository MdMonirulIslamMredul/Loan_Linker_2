@extends('layouts.app')

@section('title', 'Login - Loan Linker')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
            @if ($logoSettings->header_logo)
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('storage/' . $logoSettings->header_logo) }}"
                        alt="{{ $logoSettings->site_name ?? 'Loan Linker' }}" class="h-24 max-h-32 w-auto object-contain">
                </div>
            @else
                <h2 class="text-2xl font-bold text-center mb-6">Loan Linker Login</h2>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 pr-10 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700 focus:outline-none"
                            tabindex="-1">
                            {{-- Eye open icon --}}
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{-- Eye closed icon --}}
                            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 012.31-3.894M6.938 6.938A9.966 9.966 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.043 5.063M6.938 6.938L3 3m3.938 3.938l3.124 3.124M21 21l-3.938-3.938m0 0l-3.124-3.124m6.062 6.062L14.063 14.063" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="ml-2 block text-gray-700 text-sm">Remember Me</label>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-6 border-t pt-4">
                <p class="text-center text-gray-600 text-sm mb-3">Don't have an account?</p>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('register.customer') }}"
                        class="block text-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200">
                        Register as Customer
                    </a>
                    <a href="{{ route('register.bank_officer') }}"
                        class="block text-center bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-colors duration-200">
                        Register as Bank Officer
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    });
</script>
@endpush
