<x-guest-layout>
    <div class="text-center">
        <p class="font-script text-4xl text-[#8b6a4d]">Welcome back</p>
        <h1 class="mt-2 font-serif text-4xl font-light text-[#3f342c] sm:text-5xl">Sign in</h1>
        <p class="mt-3 text-sm leading-7 text-[#806f61]">Continue to your wedding dashboard.</p>
    </div>

    <x-auth-session-status class="mt-5 text-center text-sm text-[#8b6a4d]" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-7">
        @csrf

        <div>
            <label for="email" class="block text-xs uppercase tracking-[0.25em] text-[#806f61]">Email address</label>
            <input id="email"
                class="mt-3 block w-full border-0 border-b border-[#cdbba8] bg-transparent px-0 py-3 text-base text-[#3f342c] outline-none focus:border-[#8b6a4d] focus:ring-0"
                type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-700" />
        </div>

        <div class="mt-6">
            <label for="password" class="block text-xs uppercase tracking-[0.25em] text-[#806f61]">Password</label>
            <input id="password"
                class="mt-3 block w-full border-0 border-b border-[#cdbba8] bg-transparent px-0 py-3 text-base text-[#3f342c] outline-none focus:border-[#8b6a4d] focus:ring-0"
                type="password" name="password" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-700" />
        </div>

        <div class="mt-5 flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex items-center text-sm text-[#806f61]">
                <input id="remember_me" type="checkbox"
                    class="rounded border-[#cdbba8] text-[#8b6a4d] shadow-sm focus:ring-[#8b6a4d]" name="remember">
                <span class="ms-2">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-[#806f61] underline decoration-[#cdbba8] underline-offset-4 transition hover:text-[#8b6a4d]"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <button type="submit"
            class="mt-7 w-full bg-[#3f342c] px-6 py-4 text-xs uppercase tracking-[0.3em] text-white transition hover:bg-[#8b6a4d]">
            {{ __('Log in') }}
        </button>
    </form>
</x-guest-layout>
