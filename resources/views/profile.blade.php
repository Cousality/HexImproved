<x-layout>
    @include('components.nav')


    @auth

        <style>
            .profile-page {
                width: 100%;
                background-color: var(--bg-dark);

            }
        </style>

        <div class="profile-page">

            <div class="profile-header">

                <div class="profile-name">

                    <h1>{{ auth()->user()->name }}</h1>

                    {{-- Gets the logged-in user's name --}}

                    <p>ELO: {{ auth()->user()->elo }}</p>
                </div>
                <div class="profile-picture">

                    <form action="{{ route('profile.picture') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="file" id="image" name="profile_picture" accept="image/*" onchange="this.form.submit()">
                        <label for="image">
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile picture"
                                width="110" height="110">

                            <span>Change Picture</span>
                        </label>
                    </form>
                </div>

            </div>

            <div class="profile-stats">

                <div>
                    <h2>1 </h2>
                    <p>Games Played</p>
                </div>

                <div>
                    <h2>2</h2>
                    <p>Wins</p>
                </div>

                <div>
                    <h2>0</h2>
                    <p>Losses</p>
                </div>
            </div>

            <div class="profile-games">

                <h2>Previous Games</h2>

                {{-- @foreach($previousGames as $game)

                    <div class="game-card">

                        <div @class([
                            'game-card',
                            'game-win' => $game->winner_id == auth()->user()->id,
                            'game-loss' => $game->winner_id != auth()->user()->id,
                        ])>
                            @if($game->winner_id == auth()->user()->id)
                                <p>Win</p>
                            @else
                                <p>Loss</p>
                            @endif

                            @if($game->player1_id == auth()->user()->id)
                                <p>Opponent: {{ $game->player2->name }}</p>
                            @else
                                <p>Opponent: {{ $game->player1->name }}</p>
                            @endif

                            <p>{{ $game->created_at->format('j M Y') }}</p>


                        </div>



                    </div>





                @endforeach
                <div class="pagination">

                    @if (!$previousGames->onFirstPage())
                        <a href="{{ $previousGames->previousPageUrl() }}">‹</a>
                    @endif

                    <span>{{ $previousGames->currentPage() }}</span>

                    @if ($previousGames->hasMorePages())
                        <a href="{{ $previousGames->nextPageUrl() }}">›</a>
                    @endif

                </div>

            </div>
        </div>
        --}}

        {{-- Gets the logged-in user's ELO --}}
    @else
        <p>You need to log in to view your profile.</p>
    @endauth

    @include('components.footer')
</x-layout>