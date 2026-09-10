<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Our Wedding') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Great+Vibes&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen overflow-hidden bg-[#f8f3ec] font-sans text-[#3f342c] antialiased">
    <main class="grid h-screen overflow-hidden lg:grid-cols-[1.08fr_0.92fr]">
        <a href="/" class="group relative hidden h-screen overflow-hidden lg:block">
            <img src="{{ asset('images/wedding-hero.jpg') }}" alt="A wedding couple outdoors"
                class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105">
            <div class="absolute inset-0 bg-[#6f5542]/55"></div>
            <div class="relative flex h-full items-end p-12 text-white xl:p-20">
                <div>
                    <p class="font-sans text-xs uppercase tracking-[0.4em] text-white/75">Kim & Mitchell</p>
                    <p class="mt-4 font-serif text-5xl font-light leading-tight xl:text-6xl">Forever starts here.</p>
                    <div class="mt-6 h-px w-16 bg-white/70"></div>
                    <p class="mt-5 font-sans text-xs uppercase tracking-[0.3em] text-white/75">October 16, 2026</p>
                </div>
            </div>
        </a>

        <section class="flex h-screen items-center justify-center overflow-hidden px-6 py-6 sm:px-12 sm:py-8">
            <div class="w-full max-w-md">
                <a href="/" class="block text-center">
                    <p class="font-script text-5xl text-[#8b6a4d]">Kim & Mitchell</p>
                    <p class="mt-3 font-sans text-[10px] uppercase tracking-[0.35em] text-[#8b7869]">Our wedding</p>
                </a>

                <div class="mt-12">
                    {{ $slot }}
                </div>
            </div>
        </section>
        </div>
</body>

</html>
