<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl font-light text-[#3f342c] leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="min-h-[calc(100vh-65px)] bg-[#f8f3ec] py-8 sm:py-12">
        <div class="mx-auto max-w-5xl space-y-6 px-6 sm:px-8">
            <div class="border border-[#ded1c4] bg-[#fffdf9] p-6 shadow-sm sm:p-8">
                <p class="font-script text-4xl text-[#8b6a4d]">Welcome back</p>
                <p class="mt-2 text-sm text-[#806f61]">Here is a simple look at your wedding guest list.</p>
            </div>

            <div class="border border-[#ded1c4] bg-[#fffdf9] shadow-sm">
                <div class="flex items-end justify-between gap-4 border-b border-[#eadfd4] px-6 py-5 sm:px-8">
                    <div>
                        <p class="text-xs uppercase tracking-[0.25em] text-[#806f61]">Confirmed guests</p>
                        <p class="mt-1 font-serif text-5xl font-light text-[#3f342c]">{{ $guestCount }}</p>
                    </div>
                    <p class="text-right text-xs text-[#9a8068]">Names are listed below</p>
                </div>

                <div class="max-h-96 overflow-y-auto">
                    <table class="min-w-full text-left">
                        <thead class="sticky top-0 z-10 bg-[#f5eee6] text-xs uppercase tracking-[0.2em] text-[#806f61]">
                            <tr>
                                <th class="px-6 py-4 font-medium sm:px-8">Guest name</th>
                                <th class="px-6 py-4 text-right font-medium sm:px-8">RSVP date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eadfd4] text-sm text-[#3f342c]">
                            @forelse ($guests as $guest)
                                <tr>
                                    <td class="px-6 py-4 sm:px-8">{{ $guest->name }}</td>
                                    <td class="px-6 py-4 text-right text-[#806f61] sm:px-8">
                                        {{ $guest->created_at->format('M j, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-10 text-center text-sm text-[#806f61] sm:px-8">
                                        No guests have RSVP'd yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
