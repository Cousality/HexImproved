<x-layout>
    @include('components.nav')

    @auth
        <h1>{{ auth()->user()->name }}</h1>

        {{-- Gets the logged-in user's name --}}

        <p>ELO: {{ auth()->user()->elo }}</p>

        <p>Wins: {{ $wins }}</p>
        
        <p>Losses: {{ $losses }}</p>

        {{-- Gets the logged-in user's ELO --}}
    @else
        <p>You need to log in to view your profile.</p>
    @endauth
</x-layout>