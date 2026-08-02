<x-layout>
    <style>
        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            height: calc(100vh - 60px);
        }

        main h1 {
            font-size: 2.2rem;
            margin-bottom: 30px;
        }

        .share-link {
            background: var(--bg-lighter);
            padding: 8px 14px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 10px;
        }
    </style>

    @include('components.nav')

    <main>
        <h1 id="turnTitle">
            @if (! $game->isFull())
                {{ $role === null ? 'Join this game' : 'Waiting for an opponent…' }}
            @elseif ($game->status === 'finished')
                Game over
            @else
                {{ $isMyTurn ? 'Your turn' : "Opponent's turn" }}
            @endif
        </h1>

        @if (! $game->isFull())
            @if ($role === null)
                <form method="POST" action="{{ route('game.join', $game) }}">
                    @csrf
                    <x-button type="submit" variant="primary" size="large">
                        Join this game
                    </x-button>
                </form>
            @else
                <p>Send this link to a friend:</p>
                <p class="share-link">{{ route('game.show', $game) }}</p>
            @endif
        @else
            @php
                $svgWidth = 250 + $boardSize * 144;
                $svgHeight = 200 + $boardSize * 92;
            @endphp

            <svg width="{{ $svgWidth }}" height="{{ $svgHeight }}">
                @foreach ($board as $tile)
                    @php
                        $x = 100 + $tile['column'] * 96 + $tile['row'] * 48;
                        $y = 100 + $tile['row'] * 92;
                    @endphp

                    <polygon
                        points="
                            {{ $x }},{{ $y - 64 }}
                            {{ $x + 48 }},{{ $y - 32 }}
                            {{ $x + 48 }},{{ $y + 32 }}
                            {{ $x }},{{ $y + 64 }}
                            {{ $x - 48 }},{{ $y + 32 }}
                            {{ $x - 48 }},{{ $y - 32 }}
                        "
                        fill="{{ $tile['owner'] === 'player1' ? '#e274d3' : ($tile['owner'] === 'player2' ? '#a97fe6' : 'lightgray') }}"
                        stroke="white" stroke-width="3" data-row="{{ $tile['row'] }}" data-column="{{ $tile['column'] }}"
                        data-owner="{{ $tile['owner'] }}" onClick="hexClicked(this)" />
                @endforeach
            </svg>
        @endif
    </main>

    <script>
        const gameId = {{ $game->id }};
        const role = @json($role);
        let isMyTurn = @json($isMyTurn);

        const board = [];
        document.querySelectorAll('polygon').forEach(hex => {
            board.push({
                row: Number(hex.dataset.row),
                column: Number(hex.dataset.column),
                owner: hex.dataset.owner || null,
                element: hex,
            });
        });

        async function hexClicked(hexElement) {
            if (!role || !isMyTurn) {
                return;
            }

            const tile = board.find(hex => hex.element === hexElement);

            if (tile.owner !== null) {
                return;
            }

            const response = await fetch(`/game/${gameId}/move`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    row: tile.row,
                    column: tile.column
                })
            });

            const title = document.getElementById('turnTitle');

            if (!response.ok) {
                const error = await response.json().catch(() => null);
                alert(error?.message || 'Something went wrong.');
                return;
            }

            const data = await response.json();

            tile.owner = role;

            hexElement.setAttribute(
                'fill',
                role === 'player1' ? '#e274d3' : '#a97fe6'
            );

            if (data.winner) {
                isMyTurn = false;
                title.textContent = 'You win! 🎉';
            } else {
                isMyTurn = false;
                title.textContent = "Opponent's turn";
            }
        }
    </script>
</x-layout>