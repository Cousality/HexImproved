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

                </div>
                <div class="profile-picture">

                    <form action="{{ route('profile.picture') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <input type="file" id="image" name="profile_picture" accept="image/*" onchange="this.form.submit()">

                        <label for="image">

                            @if(auth()->user()->profile_picture)

                                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile picture">

                            @else

                                <div class="profile-picture-fallback">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>

                            @endif

                            <span>Change Picture</span>

                        </label>

                    </form>

                </div>

            </div>

            <div class="profile-stats">

                <div class="profile-elo">
                    <p>ELO: {{ auth()->user()->elo }}</p>
                </div>

                <div class="profile-stats-counters">

                    <div>
                        <h2>{{ $gamesPlayed }}</h2>
                        <p>Games Played</p>
                    </div>

                    <div>
                        <h2>{{ $wins }}</h2>
                        <p>Wins</p>
                    </div>

                    <div>
                        <h2>{{ $losses }}</h2>
                        <p>Losses</p>
                    </div>

                </div>

            </div>

            <div class="elo-chart">
                <h2>ELO History</h2>
                <canvas id="eloChart"></canvas>
            </div>

            <div class="profile-games">
                <h2>Previous Games</h2>

                @forelse($previousGames as $game)

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

                @empty

                    <div class="games-empty">
                        <h3>No games yet</h3>
                        <p>Play some games to see your history here!</p>
                    </div>

                @endforelse
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const eloHistory = @json($eloHistory->pluck('elo'));
            const eloValues = [1200, ...eloHistory];

            const ctx = document.getElementById('eloChart');

            new Chart(ctx, {
                type: 'line',

                data: {
                    labels: eloValues.map((_, index) =>
                        index === 0 ? 'Start' : `Game ${index}`
                    ),

                    datasets: [{
                        label: 'ELO',
                        data: eloValues,
                        borderColor: '#f6e999',
                        backgroundColor: '#f6e999'
                    }]
                },

                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    scales: {
                        x: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.2)'
                            }
                        },

                        y: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.2)'
                            }
                        }
                    },

                    plugins: {
                        legend: {
                            labels: {
                                color: 'white'
                            }
                        }
                    }
                }
            });
        </script>


        {{-- Gets the logged-in user's ELO --}}
    @else
        <p>You need to log in to view your profile.</p>
    @endauth

    @include('components.footer')
</x-layout>