<x-layout>
    @include('components.nav')

    @auth

    <form action="{{ route('profile.picture') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="file" name="profile_picture" accept="image/*">

    <button type="submit">Upload picture</button>
    </form>

    @if(auth()->user()->profile_picture)
        <img
            src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
            alt="Profile picture"
            width="150"
            height="150"
        >
    @endif

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