<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary Meta Tags -->
    <title>Kim & Mitchell | Our Wedding</title>

    <meta name="title" content="Kim & Mitchell | Our Wedding">
    <meta name="description"
        content="Join Kim and Mitchell as they celebrate their wedding day on October 16, 2026. After 8 beautiful years, forever starts here.">
    <meta name="author" content="Kim & Mitchell">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Open Graph / Facebook / Messenger -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Kim & Mitchell | Our Wedding">
    <meta property="og:description"
        content="Join Kim and Mitchell as they celebrate their wedding day on October 16, 2026. After 8 beautiful years, forever starts here.">
    <meta property="og:image" content="{{ url(versioned_asset('images/invitation-1.jpg')) }}">
    <meta property="og:image:secure_url" content="{{ url(versioned_asset('images/invitation-1.jpg')) }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Kim and Mitchell's Wedding">
    <meta property="og:site_name" content="Kim & Mitchell Wedding">
    <meta property="og:locale" content="en_US">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="Kim & Mitchell | Our Wedding">
    <meta name="twitter:description"
        content="Join Kim and Mitchell as they celebrate their wedding day on October 16, 2026. After 8 beautiful years, forever starts here.">
    <meta name="twitter:image" content="{{ url(versioned_asset('images/invitation-1.jpg')) }}">
    <meta name="twitter:image:alt" content="Kim and Mitchell's Wedding">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ versioned_asset('images/wedding-rings.png') }}">
    <link rel="apple-touch-icon" href="{{ versioned_asset('images/wedding-rings.png') }}">

    <!-- Additional -->
    <meta name="theme-color" content="#8f7259">


    <link rel="icon" type="image/png" href="{{ versioned_asset('images/wedding-rings.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Great+Vibes&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <style>
        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
            /* ← critical */
            max-width: 100%;
        }

        body {
            background: #F8F3EC;
            color: #3F342C;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
            /* keep this */
            position: relative;
            /* helps contain absolute children */
        }

        /* Prevent animated elements from creating overflow before they animate in */
        .fade-left,
        .fade-right {
            will-change: transform, opacity;
        }

        /* Optional but recommended – slightly smaller movement on mobile */
        @media (max-width: 640px) {
            .fade-left {
                transform: translateX(-24px);
            }

            .fade-right {
                transform: translateX(24px);
            }
        }

        .script {
            font-family: 'Great Vibes', cursive;
        }

        .serif {
            font-family: 'Cormorant Garamond', serif;
        }

        [x-cloak] {
            display: none !important;
        }

        .fade-up {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.9s ease, transform 0.9s ease;
        }

        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        .fade-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: opacity 0.9s ease, transform 0.9s ease;
        }

        .fade-left.show {
            opacity: 1;
            transform: translateX(0);
        }

        .fade-right {
            opacity: 0;
            transform: translateX(50px);
            transition: opacity 0.9s ease, transform 0.9s ease;
        }

        .fade-right.show {
            opacity: 1;
            transform: translateX(0);
        }

        .scale-in {
            opacity: 0;
            transform: scale(.92);
            transition: opacity 1s ease, transform 1s ease;
        }

        .scale-in.show {
            opacity: 1;
            transform: scale(1);
        }

        .hero-image {
            background-image:
                linear-gradient(rgba(45, 35, 27, .30),
                    rgba(45, 35, 27, .40)),
                url('{{ versioned_asset('images/wedding-hero.jpg') }}');
            background-size: cover;
            background-position: center;
        }

        .photo-placeholder {
            background:
                linear-gradient(135deg,
                    rgba(216, 199, 181, .8),
                    rgba(233, 222, 208, .8));
        }
    </style>
</head>

<body x-data="{
    guestName: @js(old('name', '')),
    rsvpOpen: @js(session()->has('rsvp_success') || $errors->any()),
    submitted: @js(session()->has('rsvp_success')),
    hasResponded: false,
    invitationOpen: false,
    selectedInvitation: 0,
    touchStartX: 0,
    touchStartY: 0,
    swipeDirection: null,
    isTransitioning: false,

    invitations: [
        '{{ versioned_asset('images/invitation-1.jpg') }}',
        '{{ versioned_asset('images/invitation-2.jpg') }}',
        '{{ versioned_asset('images/invitation-3.jpg') }}'
    ],

    init() {
        try {
            this.hasResponded = localStorage.getItem('wedding_rsvp_submitted') === 'true';

            if (this.submitted) {
                localStorage.setItem('wedding_rsvp_submitted', 'true');
                this.hasResponded = true;
            }

            if (this.hasResponded && !this.submitted) {
                this.rsvpOpen = false;
            }
        } catch (error) {
            // Continue normally when browser storage is unavailable.
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                }
            });
        }, {
            threshold: 0.15
        });

        document.querySelectorAll(
            '.fade-up, .fade-left, .fade-right, .scale-in'
        ).forEach(el => observer.observe(el));
    },

    changeInvitation(direction) {
        if (this.isTransitioning) return;
        this.isTransitioning = true;

        let next = this.selectedInvitation + direction;
        if (next < 0) next = this.invitations.length - 1;
        if (next >= this.invitations.length) next = 0;

        this.selectedInvitation = next;

        setTimeout(() => {
            this.isTransitioning = false;
        }, 400);
    },
}">

    {{-- ========================================================= --}}
    {{-- HERO --}}
    {{-- ========================================================= --}}

    <section class="relative h-screen min-h-[680px] bg-cover bg-center bg-no-repeat text-white"
        style="background-image: url('{{ versioned_asset('images/wedding-hero.jpg') }}');">
        {{-- Soft Beige Overlay --}}
        {{-- <div class="absolute inset-0 bg-[#d9c2aa]/30"></div> --}}
        <div class="absolute inset-0 bg-[#8f7259]/70"></div>
        {{-- Optional subtle white/beige gradient for readability --}}
        <div class="absolute inset-0 bg-gradient-to-b from-black/10 via-transparent to-black/20"></div>

        {{-- Hero Content --}}
        <div class="relative z-10 flex h-full items-center justify-center px-6 text-center">

            <div class="max-w-4xl">

                <p class="mb-12 text-sm font-light uppercase tracking-[0.45em]" data-aos>
                    After 8 beautiful years, forever starts here.
                </p>

                <h1 class="script text-7xl leading-none sm:text-8xl md:text-9xl">
                    Kim <span class="text-[24pt]">&</span> Mitchell
                </h1>

                <div class="mx-auto my-8 h-px w-24 bg-white/70"></div>

                <h2 class="serif text-4xl tracking-wide sm:text-5xl md:text-6xl">
                    October 16, 2026
                </h2>

                {{-- <p class="mt-6 text-sm uppercase tracking-[0.3em] sm:text-base">
                    October 16, 2026
                </p> --}}

                <div x-data="{ playing: false }">

                    <audio x-ref="song" src="{{ asset('audio/our-song.mp3') }}" @play="playing = true"
                        @pause="playing = false" @ended="playing = false"></audio>

                    <button type="button"
                        @click="
                            if (playing) {
                                $refs.song.pause();
                            } else {
                                $refs.song.play();
                            }
                        "
                        class="mt-12 inline-flex items-center gap-3 border border-white/70 px-7 py-3 text-xs uppercase tracking-[0.3em] transition duration-300 hover:bg-white hover:text-wedding-dark">
                        {{-- Music icon --}}
                        <svg x-show="!playing" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 18V5l10-2v13" />
                            <circle cx="6" cy="18" r="3" />
                            <circle cx="16" cy="16" r="3" />
                        </svg>

                        {{-- Pause icon --}}
                        <svg x-show="playing" x-cloak class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 5h3v14H7zM14 5h3v14h-3z" />
                        </svg>

                        <span x-text="playing ? 'Pause Our Song' : 'Play Our Song'"></span>
                    </button>

                </div>

            </div>

        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-0 right-0 flex justify-center animate-bounce">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 9l6 6 6-6" />
            </svg>
        </div>

    </section>


    {{-- ========================================================= --}}
    {{-- INTRO --}}
    {{-- ========================================================= --}}

    <section class="px-6 py-20 sm:py-28">

        <div class="mx-auto max-w-3xl text-center fade-up">

            <p class="script text-4xl text-wedding-brown">
                We are getting married
            </p>

            <h2 class="serif mt-3 text-4xl sm:text-5xl md:text-6xl font-light">
                And we'd love for you to be there
            </h2>

            <div class="mx-auto my-8 h-px w-16 bg-wedding-sand"></div>

            <p class="text-sm sm:text-base leading-8 text-wedding-muted">
                Two hearts, two stories, and one beautiful journey.
                We are so excited to celebrate this special chapter
                surrounded by the people who mean the most to us.
            </p>

        </div>

    </section>

    {{-- INVITATION SECTION --}}
    <section id="invitation" class="relative overflow-hidden bg-[#f5eee6] px-6 py-20 sm:px-8 sm:py-28 lg:px-12">
        <div class="mx-auto max-w-6xl">

            {{-- Section Header --}}
            <div class="mb-12 text-center fade-up">
                <p class="mb-3 text-xs font-semibold uppercase tracking-[0.3em] text-[#9a8068]">
                    You're Invited
                </p>

                <h2 class="font-serif text-4xl text-[#59483b] sm:text-5xl">
                    Our Invitation
                </h2>

                <div class="mx-auto mt-5 h-px w-16 bg-[#b9a28e]"></div>

                <p class="mx-auto mt-5 max-w-xl text-sm leading-7 text-[#806f61]">
                    We would be honored to celebrate this special day with you.
                    Please take a moment to view our wedding invitation.
                </p>
            </div>

            {{-- Invitation Images --}}
            <div class="grid gap-6 md:grid-cols-3">

                {{-- Invitation 1 --}}
                <div class="group cursor-pointer overflow-hidden rounded-xl border border-[#ded1c4] bg-white p-2 shadow-sm transition duration-500 hover:-translate-y-2 hover:shadow-xl fade-up"
                    @click="selectedInvitation = 0; invitationOpen = true">
                    <div class="overflow-hidden rounded-lg bg-[#faf7f3]">
                        <img src="{{ versioned_asset('images/invitation-1.jpg') }}" alt="Wedding Invitation 1"
                            class="h-auto w-full object-contain transition duration-700 group-hover:scale-[1.02]"
                            loading="lazy">
                    </div>
                </div>

                {{-- Invitation 2 --}}
                <div class="group cursor-pointer overflow-hidden rounded-xl border border-[#ded1c4] bg-white p-2 shadow-sm transition duration-500 hover:-translate-y-2 hover:shadow-xl fade-up"
                    @click="selectedInvitation = 1; invitationOpen = true">
                    <div class="overflow-hidden rounded-lg bg-[#faf7f3]">
                        <img src="{{ versioned_asset('images/invitation-2.jpg') }}" alt="Wedding Invitation 2"
                            class="h-auto w-full object-contain transition duration-700 group-hover:scale-[1.02]"
                            loading="lazy">
                    </div>
                </div>

                {{-- Invitation 3 --}}
                <div class="group cursor-pointer overflow-hidden rounded-xl border border-[#ded1c4] bg-white p-2 shadow-sm transition duration-500 hover:-translate-y-2 hover:shadow-xl fade-up"
                    @click="selectedInvitation = 2; invitationOpen = true">
                    <div class="overflow-hidden rounded-lg bg-[#faf7f3]">
                        <img src="{{ versioned_asset('images/invitation-3.jpg') }}" alt="Wedding Invitation 3"
                            class="h-auto w-full object-contain transition duration-700 group-hover:scale-[1.02]"
                            loading="lazy">
                    </div>
                </div>

            </div>

            {{-- Hint --}}
            <p class="mt-6 text-center text-xs tracking-wide text-[#9a8068]">
                Tap an invitation to view it
            </p>

        </div>
    </section>


    {{-- ========================================================= --}}
    {{-- PHOTO SECTION --}}
    {{-- ========================================================= --}}

    <section class="bg-wedding-beige px-6 py-20 sm:py-28">

        <div class="mx-auto max-w-6xl">

            <div class="mb-12 text-center fade-up">

                <p class="script text-4xl text-wedding-brown">
                    # Throwback
                </p>

                <h2 class="serif mt-2 text-4xl sm:text-5xl font-light">
                    A little rewind of our favorite adventures before forever began.
                </h2>

            </div>


            <div class="grid gap-6 md:grid-cols-3">

                {{-- PHOTO SET 1 --}}
                <div class="photo-placeholder aspect-[2/3] overflow-hidden fade-left relative group"
                    x-data="{
                        current: 0,
                        photos: [
                            '{{ versioned_asset('images/disney/1.jpg') }}',
                            '{{ versioned_asset('images/disney/2.jpg') }}',
                            '{{ versioned_asset('images/disney/3.jpg') }}',
                            '{{ versioned_asset('images/disney/4.jpg') }}',
                            '{{ versioned_asset('images/disney/5.jpg') }}',
                            '{{ versioned_asset('images/disney/6.jpg') }}',
                        ],
                        touchStartX: 0,
                        next() {
                            this.current = (this.current + 1) % this.photos.length;
                        },
                        prev() {
                            this.current = (this.current - 1 + this.photos.length) % this.photos.length;
                        }
                    }" @touchstart="touchStartX = $event.changedTouches[0].screenX"
                    @touchend="
                    const diff = $event.changedTouches[0].screenX - touchStartX;
                    if (Math.abs(diff) > 50) {
                    diff > 0 ? prev() : next();
                    }
                ">

                    {{-- Images --}}
                    <template x-for="(src, index) in photos" :key="index">
                        <img x-show="current === index" x-transition:enter="transition ease-out duration-400"
                            x-transition:enter-start="opacity-0 scale-105"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            :src="src" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                    </template>

                    {{-- Fallback if no images --}}
                    <div x-show="photos.length === 0" class="flex h-full items-center justify-center">
                        <div class="text-center text-wedding-muted">
                            <svg class="mx-auto mb-3 h-8 w-8" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-width="1" d="M3 5h18v14H3z" />
                                <circle cx="8.5" cy="10" r="1.5" />
                                <path d="M21 15l-5-5L5 19" />
                            </svg>
                            <p class="text-xs uppercase tracking-widest">Your Photo</p>
                        </div>
                    </div>

                    {{-- Dots --}}
                    <div x-show="photos.length > 1"
                        class="absolute bottom-3 left-1/2 z-10 flex -translate-x-1/2 gap-1.5">

                        <template x-for="(src, index) in photos" :key="index">

                            <button type="button" @click="current = index"
                                class="h-1.5 rounded-full transition-all duration-300"
                                :class="current === index ?
                                    'w-5 bg-white' :
                                    'w-1.5 bg-white/40'"
                                :aria-label="'View photo ' + (index + 1)"></button>

                        </template>

                    </div>

                    {{-- Optional arrows (appear on hover) --}}
                    <button @click="prev()" x-show="photos.length > 1"
                        class="absolute left-2 top-1/2 z-10 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-black/30 text-white opacity-0 backdrop-blur-sm transition group-hover:opacity-100">
                        ‹
                    </button>
                    <button @click="next()" x-show="photos.length > 1"
                        class="absolute right-2 top-1/2 z-10 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-black/30 text-white opacity-0 backdrop-blur-sm transition group-hover:opacity-100">
                        ›
                    </button>
                </div>


                {{-- PHOTO SET 2 --}}
                <div class="photo-placeholder aspect-[2/3] overflow-hidden fade-left relative group"
                    x-data="{
                        current: 0,
                        photos: [
                            '{{ versioned_asset('images/boracay/1.jpg') }}',
                            '{{ versioned_asset('images/boracay/2.jpg') }}',
                            '{{ versioned_asset('images/boracay/3.jpg') }}',
                            '{{ versioned_asset('images/boracay/4.jpg') }}',
                            '{{ versioned_asset('images/boracay/5.jpg') }}',
                        ],
                        touchStartX: 0,
                        next() {
                            this.current = (this.current + 1) % this.photos.length;
                        },
                        prev() {
                            this.current = (this.current - 1 + this.photos.length) % this.photos.length;
                        }
                    }" @touchstart="touchStartX = $event.changedTouches[0].screenX"
                    @touchend="
                    const diff = $event.changedTouches[0].screenX - touchStartX;
                    if (Math.abs(diff) > 50) {
                    diff > 0 ? prev() : next();
                    }
                ">

                    {{-- Images --}}
                    <template x-for="(src, index) in photos" :key="index">
                        <img x-show="current === index" x-transition:enter="transition ease-out duration-400"
                            x-transition:enter-start="opacity-0 scale-105"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            :src="src" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                    </template>

                    {{-- Fallback if no images --}}
                    <div x-show="photos.length === 0" class="flex h-full items-center justify-center">
                        <div class="text-center text-wedding-muted">
                            <svg class="mx-auto mb-3 h-8 w-8" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-width="1" d="M3 5h18v14H3z" />
                                <circle cx="8.5" cy="10" r="1.5" />
                                <path d="M21 15l-5-5L5 19" />
                            </svg>
                            <p class="text-xs uppercase tracking-widest">Your Photo</p>
                        </div>
                    </div>

                    {{-- Dots --}}
                    <div x-show="photos.length > 1"
                        class="absolute bottom-3 left-1/2 z-10 flex -translate-x-1/2 gap-1.5">

                        <template x-for="(src, index) in photos" :key="index">

                            <button type="button" @click="current = index"
                                class="h-1.5 rounded-full transition-all duration-300"
                                :class="current === index ?
                                    'w-5 bg-white' :
                                    'w-1.5 bg-white/40'"
                                :aria-label="'View photo ' + (index + 1)"></button>

                        </template>

                    </div>

                    {{-- Optional arrows (appear on hover) --}}
                    <button @click="prev()" x-show="photos.length > 1"
                        class="absolute left-2 top-1/2 z-10 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-black/30 text-white opacity-0 backdrop-blur-sm transition group-hover:opacity-100">
                        ‹
                    </button>
                    <button @click="next()" x-show="photos.length > 1"
                        class="absolute right-2 top-1/2 z-10 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-black/30 text-white opacity-0 backdrop-blur-sm transition group-hover:opacity-100">
                        ›
                    </button>
                </div>


                {{-- PHOTO SET 3 --}}
                <div class="photo-placeholder aspect-[2/3] overflow-hidden fade-left relative group"
                    x-data="{
                        current: 0,
                        photos: [
                            '{{ versioned_asset('images/baguio/1.jpg') }}',
                            '{{ versioned_asset('images/baguio/2.jpg') }}',
                            '{{ versioned_asset('images/baguio/3.jpg') }}',
                            '{{ versioned_asset('images/baguio/5.jpg') }}',
                            '{{ versioned_asset('images/baguio/6.jpg') }}',
                            '{{ versioned_asset('images/baguio/7.jpg') }}',
                            '{{ versioned_asset('images/baguio/8.jpg') }}',
                            '{{ versioned_asset('images/baguio/9.jpg') }}',
                        ],
                        touchStartX: 0,
                        next() {
                            this.current = (this.current + 1) % this.photos.length;
                        },
                        prev() {
                            this.current = (this.current - 1 + this.photos.length) % this.photos.length;
                        }
                    }" @touchstart="touchStartX = $event.changedTouches[0].screenX"
                    @touchend="
                    const diff = $event.changedTouches[0].screenX - touchStartX;
                    if (Math.abs(diff) > 50) {
                    diff > 0 ? prev() : next();
                    }
                ">

                    {{-- Images --}}
                    <template x-for="(src, index) in photos" :key="index">
                        <img x-show="current === index" x-transition:enter="transition ease-out duration-400"
                            x-transition:enter-start="opacity-0 scale-105"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            :src="src" class="absolute inset-0 h-full w-full object-cover"
                            loading="lazy">
                    </template>

                    {{-- Fallback if no images --}}
                    <div x-show="photos.length === 0" class="flex h-full items-center justify-center">
                        <div class="text-center text-wedding-muted">
                            <svg class="mx-auto mb-3 h-8 w-8" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-width="1" d="M3 5h18v14H3z" />
                                <circle cx="8.5" cy="10" r="1.5" />
                                <path d="M21 15l-5-5L5 19" />
                            </svg>
                            <p class="text-xs uppercase tracking-widest">Your Photo</p>
                        </div>
                    </div>

                    {{-- Dots --}}
                    <div x-show="photos.length > 1"
                        class="absolute bottom-3 left-1/2 z-10 flex -translate-x-1/2 gap-1.5">

                        <template x-for="(src, index) in photos" :key="index">

                            <button type="button" @click="current = index"
                                class="h-1.5 rounded-full transition-all duration-300"
                                :class="current === index ?
                                    'w-5 bg-white' :
                                    'w-1.5 bg-white/40'"
                                :aria-label="'View photo ' + (index + 1)"></button>

                        </template>

                    </div>
                    {{-- Optional arrows (appear on hover) --}}
                    <button @click="prev()" x-show="photos.length > 1"
                        class="absolute left-2 top-1/2 z-10 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-black/30 text-white opacity-0 backdrop-blur-sm transition group-hover:opacity-100">
                        ‹
                    </button>
                    <button @click="next()" x-show="photos.length > 1"
                        class="absolute right-2 top-1/2 z-10 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-black/30 text-white opacity-0 backdrop-blur-sm transition group-hover:opacity-100">
                        ›
                    </button>
                </div>

            </div>

        </div>

    </section>

    {{-- ========================================================= --}}
    {{-- FREQUENTLY ASKED QUESTIONS --}}
    {{-- ========================================================= --}}
    <section class="bg-wedding-beige px-6 py-24 sm:py-32">

        <div class="mx-auto max-w-3xl">

            {{-- Header --}}
            <div class="mb-16 text-center fade-up">
                <p class="script text-4xl text-wedding-brown">
                    Frequently Asked Questions
                </p>

                <h2 class="serif mt-2 text-4xl font-light sm:text-5xl">
                </h2>

                <div class="mx-auto my-7 h-px w-16 bg-wedding-sand"></div>

                <p class="mx-auto max-w-xl text-sm leading-8 text-wedding-muted sm:text-base">
                    A few gentle notes to help us keep our celebration intimate,
                    meaningful, and beautifully planned. Thank you for understanding.
                </p>
            </div>

            {{-- Questions --}}
            <div class="space-y-5" x-data="{ open: null }">

                {{-- 1 --}}
                <div class="overflow-hidden rounded-lg border border-wedding-sand/70 bg-wedding-cream">
                    <button type="button" @click="open = open === 1 ? null : 1"
                        class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left transition hover:bg-wedding-beige/50">
                        <h3 class="serif text-lg text-wedding-dark sm:text-xl">
                            Can I bring a plus-one?
                        </h3>
                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-wedding-sand text-wedding-brown transition-transform duration-300"
                            :class="open === 1 ? 'rotate-45' : ''">+</span>
                    </button>

                    <div x-show="open === 1" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="border-t border-wedding-sand/50 px-6 pb-6 pt-4">
                        <p class="serif text-base leading-8 text-wedding-muted">
                            No. Kindly celebrate with us only with the guest/s indicated on your invitation.
                            Due to our limited seating, we are unable to accommodate additional guests.
                            Thank you for understanding.
                        </p>
                    </div>
                </div>

                {{-- 2 --}}
                <div class="overflow-hidden rounded-lg border border-wedding-sand/70 bg-wedding-cream">
                    <button type="button" @click="open = open === 2 ? null : 2"
                        class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left transition hover:bg-wedding-beige/50">
                        <h3 class="serif text-lg text-wedding-dark sm:text-xl">
                            Can I wear white or black?
                        </h3>
                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-wedding-sand text-wedding-brown transition-transform duration-300"
                            :class="open === 2 ? 'rotate-45' : ''">+</span>
                    </button>

                    <div x-show="open === 2" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="border-t border-wedding-sand/50 px-6 pb-6 pt-4">
                        <p class="serif text-base leading-8 text-wedding-muted">
                            We kindly ask our guests to refrain from wearing white, as it is reserved
                            for the Bride and Groom. Black is also not part of our chosen palette.
                            We would love for you to follow our beige and champagne gold dress code.
                        </p>
                    </div>
                </div>

                {{-- 3 --}}
                <div class="overflow-hidden rounded-lg border border-wedding-sand/70 bg-wedding-cream">
                    <button type="button" @click="open = open === 3 ? null : 3"
                        class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left transition hover:bg-wedding-beige/50">
                        <h3 class="serif text-lg text-wedding-dark sm:text-xl">
                            Can I bring my kids?
                        </h3>
                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-wedding-sand text-wedding-brown transition-transform duration-300"
                            :class="open === 3 ? 'rotate-45' : ''">+</span>
                    </button>

                    <div x-show="open === 3" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="border-t border-wedding-sand/50 px-6 pb-6 pt-4">
                        <p class="serif text-base leading-8 text-wedding-muted">
                            We adore your little ones, but due to limited seating, this will be an
                            adults-only celebration. We hope you understand and thank you for
                            celebrating with us.
                        </p>
                    </div>
                </div>

                {{-- 4 --}}
                <div class="overflow-hidden rounded-lg border border-wedding-sand/70 bg-wedding-cream">
                    <button type="button" @click="open = open === 4 ? null : 4"
                        class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left transition hover:bg-wedding-beige/50">
                        <h3 class="serif text-lg text-wedding-dark sm:text-xl">
                            Will transportation be provided?
                        </h3>
                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-wedding-sand text-wedding-brown transition-transform duration-300"
                            :class="open === 4 ? 'rotate-45' : ''">+</span>
                    </button>

                    <div x-show="open === 4" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="border-t border-wedding-sand/50 px-6 pb-6 pt-4">
                        <p class="serif text-base leading-8 text-wedding-muted">
                            Transportation will be provided for the wedding entourage only.
                            Guests are kindly requested to arrange their own transportation.
                        </p>
                    </div>
                </div>

                {{-- 5 --}}
                <div class="overflow-hidden rounded-lg border border-wedding-sand/70 bg-wedding-cream">
                    <button type="button" @click="open = open === 5 ? null : 5"
                        class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left transition hover:bg-wedding-beige/50">
                        <h3 class="serif text-lg text-wedding-dark sm:text-xl">
                            Can I wear jeans or sleeveless outfits to church?
                        </h3>
                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-wedding-sand text-wedding-brown transition-transform duration-300"
                            :class="open === 5 ? 'rotate-45' : ''">+</span>
                    </button>

                    <div x-show="open === 5" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="border-t border-wedding-sand/50 px-6 pb-6 pt-4">
                        <p class="serif text-base leading-8 text-wedding-muted">
                            We kindly ask everyone to dress appropriately for the church ceremony
                            and follow our designated dress code. Thank you for helping us honor
                            the occasion.
                        </p>
                    </div>
                </div>

                {{-- 6 --}}
                <div class="overflow-hidden rounded-lg border border-wedding-sand/70 bg-wedding-cream">
                    <button type="button" @click="open = open === 6 ? null : 6"
                        class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left transition hover:bg-wedding-beige/50">
                        <h3 class="serif text-lg text-wedding-dark sm:text-xl">
                            Can I choose my seat?
                        </h3>
                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-wedding-sand text-wedding-brown transition-transform duration-300"
                            :class="open === 6 ? 'rotate-45' : ''">+</span>
                    </button>

                    <div x-show="open === 6" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="border-t border-wedding-sand/50 px-6 pb-6 pt-4">
                        <p class="serif text-base leading-8 text-wedding-muted">
                            Seats will be assigned in advance. Our team will be happy to guide you
                            to your designated seat. Just relax and enjoy the celebration!
                        </p>
                    </div>
                </div>

                {{-- 7 --}}
                <div class="overflow-hidden rounded-lg border border-wedding-sand/70 bg-wedding-cream">
                    <button type="button" @click="open = open === 7 ? null : 7"
                        class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left transition hover:bg-wedding-beige/50">
                        <h3 class="serif text-lg text-wedding-dark sm:text-xl">
                            Can I help the Bride during the wedding?
                        </h3>
                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-wedding-sand text-wedding-brown transition-transform duration-300"
                            :class="open === 7 ? 'rotate-45' : ''">+</span>
                    </button>

                    <div x-show="open === 7" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="border-t border-wedding-sand/50 px-6 pb-6 pt-4">
                        <p class="serif text-base leading-8 text-wedding-muted">
                            That is so sweet of you! But please don’t worry—we have someone
                            specially assigned to assist the Bride. Your presence and celebration
                            with us are more than enough.
                        </p>
                    </div>
                </div>

                {{-- 8 --}}
                <div class="overflow-hidden rounded-lg border border-wedding-sand/70 bg-wedding-cream">
                    <button type="button" @click="open = open === 8 ? null : 8"
                        class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left transition hover:bg-wedding-beige/50">
                        <h3 class="serif text-lg text-wedding-dark sm:text-xl">
                            Can I use my phone inside the church?
                        </h3>
                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-wedding-sand text-wedding-brown transition-transform duration-300"
                            :class="open === 8 ? 'rotate-45' : ''">+</span>
                    </button>

                    <div x-show="open === 8" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="border-t border-wedding-sand/50 px-6 pb-6 pt-4">
                        <p class="serif text-base leading-8 text-wedding-muted">
                            We kindly ask everyone to keep their phones on silent mode or switched
                            off during the ceremony, so we can all be fully present for this
                            special moment.
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </section>


    {{-- ========================================================= --}}
    {{-- WEDDING DETAILS --}}
    {{-- ========================================================= --}}

    <section id="details" class="bg-wedding-beige px-6 py-20 sm:py-28">

        <div class="mx-auto max-w-5xl">

            <div class="mb-12 text-center fade-up">

                <p class="script text-4xl text-wedding-brown">
                    Save the date
                </p>

                <h2 class="serif mt-2 text-4xl sm:text-5xl font-light">
                    Our Wedding Day
                </h2>

                <p class="mt-5 text-sm tracking-widest text-wedding-muted">
                    OCTOBER 16, 2026
                </p>

            </div>


            <div class="grid gap-6 md:grid-cols-2">

                {{-- CHURCH --}}
                <div class="bg-wedding-cream p-8 sm:p-10 text-center fade-left">

                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-full border border-wedding-sand">

                        <svg class="h-6 w-6 text-wedding-brown" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-width="1.5" d="M12 3v18M5 9h14M7 21h10M5 9l7-6 7 6" />
                        </svg>

                    </div>

                    <p class="script mt-6 text-3xl text-wedding-brown">
                        Ceremony
                    </p>

                    <h3 class="serif mt-2 text-3xl">
                        Iglesia Ni Cristo
                    </h3>

                    <p class="mt-4 text-sm leading-7 text-wedding-muted">
                        2:00 PM<br>
                        Koronadal City
                    </p>

                    <a href="https://maps.app.goo.gl/KLa8hnTH7d73ydDY8" target="_blank"
                        class="mt-7 inline-block border border-wedding-brown px-6 py-3 text-xs uppercase tracking-widest text-wedding-brown transition hover:bg-wedding-brown hover:text-white">
                        View on Google Maps
                    </a>

                </div>


                {{-- RECEPTION --}}
                <div class="bg-wedding-cream p-8 sm:p-10 text-center fade-right">

                    <div
                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-full border border-wedding-sand">

                        <svg class="h-6 w-6 text-wedding-brown" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-width="1.5" d="M4 20h16M5 20V9h14v11M8 9V5h8v4M9 13h6M9 16h6" />
                        </svg>

                    </div>

                    <p class="script mt-6 text-3xl text-wedding-brown">
                        Reception
                    </p>

                    <h3 class="serif mt-2 text-3xl">
                        Cino Niñas • Maya Hall
                    </h3>

                    <p class="mt-4 text-sm leading-7 text-wedding-muted">
                        4:00 PM<br>
                        Koronadal City
                    </p>

                    <a href="https://maps.app.goo.gl/nJTpdQxJzgmmuc7Q8" target="_blank"
                        class="mt-7 inline-block border border-wedding-brown px-6 py-3 text-xs uppercase tracking-widest text-wedding-brown transition hover:bg-wedding-brown hover:text-white">
                        View on Google Maps
                    </a>

                </div>

            </div>

        </div>

    </section>


    {{-- ========================================================= --}}
    {{-- QUOTE --}}
    {{-- ========================================================= --}}

    <section class="bg-wedding-dark px-6 py-20 text-center text-white sm:py-28">

        <div class="mx-auto max-w-3xl fade-up">

            <p class="serif text-3xl font-light italic leading-relaxed sm:text-4xl">
                “So they are no longer two, but one flesh.
                Therefore what God has joined together,
                let no one separate.”
            </p>

            <div class="mx-auto my-8 h-px w-12 bg-white/40"></div>

            <p class="text-xs uppercase tracking-[0.35em] text-white/60">
                Matthew 19:6
            </p>

        </div>

    </section>

    {{-- ========================================================= --}}
    {{-- RSVP --}}
    {{-- ========================================================= --}}

    <section class="px-6 py-24 sm:py-32">

        <div class="mx-auto max-w-3xl text-center fade-up">

            <p class="script text-5xl text-wedding-brown">
                Will you join us?
            </p>

            <h2 class="serif mt-4 text-4xl sm:text-5xl font-light">
                We would love to celebrate with you.
            </h2>

            <p class="mx-auto mt-6 max-w-xl text-sm leading-8 text-wedding-muted">
                Your presence would mean so much to us as we begin
                this new chapter together.
            </p>

            <button @click="if (!hasResponded) rsvpOpen = true" :disabled="hasResponded"
                :class="hasResponded ? 'cursor-not-allowed bg-wedding-muted/50' : 'bg-wedding-dark hover:bg-wedding-brown'"
                class="mt-10 px-10 py-4 text-xs uppercase tracking-[0.3em] text-white transition">
                <span x-text="hasResponded ? 'RSVP Already Submitted' : 'Yes, I\'ll be there'"></span>
            </button>

        </div>

    </section>


    {{-- ========================================================= --}}
    {{-- FOOTER --}}
    {{-- ========================================================= --}}

    <footer class="border-t border-wedding-sand px-6 py-10 text-center">

        <p class="script text-4xl text-wedding-brown">
            Kim & Mitchell
        </p>

        <p class="mt-3 text-[10px] uppercase tracking-[0.3em] text-wedding-muted">
            Forever starts here · 2026
        </p>

    </footer>


    {{-- ========================================================= --}}
    {{-- FULLSCREEN RSVP MODAL --}}
    {{-- ========================================================= --}}

    <div x-cloak x-show="rsvpOpen" x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[9999] flex min-h-screen items-center justify-center overflow-y-auto bg-wedding-cream">

        {{-- Close --}}
        <button @click="rsvpOpen = false"
            class="absolute right-5 top-5 z-10 flex h-11 w-11 items-center justify-center rounded-full border border-wedding-sand text-wedding-dark transition hover:bg-wedding-beige">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>


        <div class="w-full max-w-xl px-6 py-20">

            <div class="text-center">

                <p class="script text-5xl text-wedding-brown">
                    You're invited
                </p>

                <h2 class="serif mt-4 text-4xl sm:text-5xl font-light">
                    Kindly RSVP
                </h2>

                <p class="mx-auto mt-5 max-w-md text-sm leading-7 text-wedding-muted">
                    Please enter your name below to let us know
                    you'll be celebrating with us.
                </p>

            </div>


            <form method="POST" action="{{ route('guests.store') }}" class="mt-12" x-show="!submitted">
                @csrf

                <label class="mb-2 block text-xs uppercase tracking-widest text-wedding-muted">
                    Your Name
                </label>

                <input type="text" name="name" required placeholder="Enter your full name" x-model="guestName"
                    @input="guestName = guestName.toUpperCase()"
                    class="w-full border-0 border-b border-wedding-sand bg-transparent px-0 py-4 text-lg outline-none ring-0 placeholder:text-wedding-muted/60 focus:border-wedding-brown focus:ring-0">

                @error('name')
                    <p class="mt-2 text-left text-sm text-red-700">{{ $message }}</p>
                @enderror


                <button type="submit"
                    class="mt-10 w-full bg-wedding-dark px-6 py-4 text-xs uppercase tracking-[0.3em] text-white transition hover:bg-wedding-brown">
                    Confirm Attendance
                </button>

            </form>


            {{-- Success --}}
            <div x-show="submitted" x-transition class="mt-8 text-center">

                <div
                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full border border-wedding-sand">

                    <svg class="h-6 w-6 text-wedding-brown" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                    </svg>

                </div>

                <p class="mt-4 serif text-2xl">{{ session('rsvp_success', 'Thank you!') }}</p>

                <p class="mt-2 text-sm text-wedding-muted">
                    We can't wait to celebrate with you.
                </p>

            </div>

        </div>

    </div>


    {{-- INVITATION FULLSCREEN VIEWER --}}
    <div x-show="invitationOpen" x-transition.opacity x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black"
        @keydown.escape.window="invitationOpen = false" @click.self="invitationOpen = false"
        @touchstart="
        touchStartX = $event.changedTouches[0].screenX;
        touchStartY = $event.changedTouches[0].screenY;
     "
        @touchend="
        if (isTransitioning) return;

        const diffX = $event.changedTouches[0].screenX - touchStartX;
        const diffY = $event.changedTouches[0].screenY - touchStartY;

        if (Math.abs(diffX) > 60 && Math.abs(diffX) > Math.abs(diffY) * 1.5) {
            changeInvitation(diffX > 0 ? -1 : 1);
        }
     ">

        {{-- Close --}}
        <button @click="invitationOpen = false"
            class="absolute right-4 top-4 z-30 flex h-11 w-11 items-center justify-center rounded-full bg-black/40 text-2xl text-white backdrop-blur-sm transition hover:bg-black/60">
            &times;
        </button>

        {{-- Previous --}}
        <button @click.stop="changeInvitation(-1)"
            class="absolute left-3 top-1/2 z-30 hidden h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-black/40 text-3xl text-white backdrop-blur-sm transition hover:bg-black/60 sm:flex sm:left-5">
            &#8249;
        </button>

        {{-- Image with smooth animation --}}
        <div class="relative flex h-full w-full items-center justify-center overflow-hidden p-2 sm:p-6">
            <template x-for="(src, index) in invitations" :key="index">
                <img x-show="selectedInvitation === index"
                    x-transition:enter="transition ease-out duration-400 transform"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300 transform"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    :src="src" :alt="`Wedding Invitation ${index + 1}`"
                    class="absolute max-h-full max-w-full object-contain select-none" draggable="false" @click.stop>
            </template>
        </div>

        {{-- Next --}}
        <button @click.stop="changeInvitation(1)"
            class="absolute right-3 top-1/2 z-30 hidden h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-black/40 text-3xl text-white backdrop-blur-sm transition hover:bg-black/60 sm:flex sm:right-5">
            &#8250;
        </button>

        {{-- Counter --}}
        <div
            class="absolute bottom-6 left-1/2 z-30 -translate-x-1/2 rounded-full bg-black/50 px-5 py-2 text-sm tracking-wider text-white backdrop-blur-sm">
            <span x-text="selectedInvitation + 1"></span>
            /
            <span x-text="invitations.length"></span>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- ALPINE --}}
    {{-- ========================================================= --}}

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


</body>

</html>
