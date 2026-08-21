<x-layout>
    <style>
        .game-page {
            width: min(100% - 32px, 1180px);
            min-height: calc(100vh - 60px);
            margin: 0 auto;
            padding: 56px 0 72px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            box-sizing: border-box;
        }

        .game-heading {
            margin-bottom: 28px;
        }

        .game-kicker {
            margin: 0 0 8px;
            color: var(--text-yellow);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .game-title {
            margin: 0;
            color: var(--text-yellow);
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 600;
            line-height: 1.05;
        }

        .game-subtitle {
            margin: 10px auto 0;
            color: rgba(253, 229, 217, 0.62);
            font-size: 0.92rem;
        }

        .game-panel {
            width: 100%;
            padding: clamp(20px, 4vw, 36px);
            border: 1px solid rgba(253, 229, 217, 0.12);
            border-radius: var(--radius);
            background:
                radial-gradient(circle at top, rgba(169, 127, 230, 0.09), transparent 42%),
                rgba(66, 42, 76, 0.45);
            box-shadow: 0 22px 60px rgba(18, 7, 24, 0.2);
            box-sizing: border-box;
        }

        .game-panel--compact {
            max-width: 620px;
        }

        .waiting-icon {
            display: grid;
            width: 58px;
            height: 64px;
            margin: 0 auto 20px;
            place-items: center;
            color: var(--bg-dark);
            background: var(--player-2);
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        }

        .waiting-icon svg {
            width: 25px;
            height: 25px;
            stroke: currentColor;
        }

        .waiting-copy {
            margin: 0 0 18px;
            color: rgba(253, 229, 217, 0.7);
        }

        .share-link {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 8px 8px 8px 14px;
            border: 1px solid rgba(246, 233, 153, 0.18);
            border-radius: 10px;
            background: rgba(45, 19, 58, 0.58);
            box-sizing: border-box;
            text-align: left;
        }

        .share-url {
            min-width: 0;
            flex: 1;
            overflow: hidden;
            color: var(--accent-light);
            font-family: "Courier New", monospace;
            font-size: 0.78rem;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .copy-button {
            min-height: 40px;
            flex: 0 0 auto;
        }

        .game-meta {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin-bottom: 18px;
        }

        .game-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            min-height: 30px;
            padding: 0 11px;
            border: 1px solid rgba(253, 229, 217, 0.12);
            border-radius: 999px;
            color: rgba(253, 229, 217, 0.72);
            background: rgba(45, 19, 58, 0.48);
            font-size: 0.74rem;
        }

        .game-chip-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--text-yellow);
        }

        .game-chip-dot.player1 {
            background: var(--player-1);
        }

        .game-chip-dot.player2 {
            background: var(--player-2);
        }

        .board-shell {
            width: 100%;
            padding: clamp(10px, 2vw, 20px);
            border: 1px solid rgba(253, 229, 217, 0.08);
            border-radius: 14px;
            background: rgba(45, 19, 58, 0.48);
            box-sizing: border-box;
            overflow: hidden;
        }

        .board-objective {
            position: relative;
            padding: 34px 46px;
        }

        .goal-edge {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            font-family: "Courier New", monospace;
            font-size: 0.66rem;
            font-weight: 800;
            letter-spacing: 0.09em;
            line-height: 1;
            text-transform: uppercase;
            pointer-events: none;
        }

        .goal-edge span {
            padding: 5px 8px;
            border-radius: 999px;
            background: var(--bg-dark);
            box-shadow: 0 0 0 4px rgba(45, 19, 58, 0.82);
            white-space: nowrap;
        }

        .goal-edge--top,
        .goal-edge--bottom {
            left: 46px;
            right: 46px;
            height: 26px;
            color: var(--player-1);
            border-color: var(--player-1);
        }

        .goal-edge--top {
            top: 5px;
            border-top: 4px solid;
        }

        .goal-edge--bottom {
            bottom: 5px;
            border-bottom: 4px solid;
        }

        .goal-edge--left,
        .goal-edge--right {
            top: 34px;
            bottom: 34px;
            width: 26px;
            color: var(--player-2);
            border-color: var(--player-2);
            writing-mode: vertical-rl;
        }

        .goal-edge--left {
            left: 5px;
            border-left: 4px solid;
        }

        .goal-edge--right {
            right: 5px;
            border-right: 4px solid;
        }

        .hex-board {
            display: block;
            width: 100%;
            height: auto;
            margin: 0 auto;
        }

        .hex-board polygon {
            transition: fill 160ms ease, filter 160ms ease, opacity 160ms ease;
        }

        .hex-board.is-playable polygon[data-owner=""] {
            cursor: pointer;
        }

        .hex-board.is-playable polygon[data-owner=""]:hover {
            fill: #76647d;
            filter: drop-shadow(0 0 7px rgba(246, 233, 153, 0.22));
        }

        .board-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
            margin-top: 16px;
            color: rgba(253, 229, 217, 0.58);
            font-size: 0.76rem;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .legend-swatch {
            width: 10px;
            height: 10px;
            border-radius: 3px;
        }

        .legend-swatch.player1 {
            background: var(--player-1);
        }

        .legend-swatch.player2 {
            background: var(--player-2);
        }

        @media (max-width: 640px) {
            .game-page {
                width: min(100% - 20px, 1180px);
                padding: 36px 0 48px;
            }

            .game-heading {
                margin-bottom: 20px;
            }

            .game-panel {
                padding: 16px;
            }

            .share-link {
                align-items: stretch;
                flex-direction: column;
                padding: 12px;
            }

            .share-url {
                padding: 2px 2px 6px;
                overflow: visible;
                text-overflow: clip;
                white-space: normal;
                overflow-wrap: anywhere;
            }

            .copy-button {
                width: 100%;
            }

            .board-objective {
                padding: 30px 30px;
            }

            .goal-edge {
                font-size: 0.54rem;
                letter-spacing: 0.06em;
            }

            .goal-edge span {
                padding: 4px 6px;
            }

            .goal-edge--top,
            .goal-edge--bottom {
                left: 30px;
                right: 30px;
                height: 22px;
            }

            .goal-edge--left,
            .goal-edge--right {
                top: 30px;
                bottom: 30px;
                width: 22px;
            }
        }
    </style>

    @include('components.nav')

    <main class="game-page">
        <div class="game-heading">
            <p class="game-kicker">Friendly match</p>
            <h1 class="game-title" id="turnTitle">
                @if (!$game->isFull()&& !$isAiGame)
                    {{ $role === null ? 'Join this game' : 'Waiting for an opponent…' }}
                @elseif ($game->status === 'finished')
                    Game over
                @else
                    {{ $isMyTurn ? 'Your turn' : "Opponent's turn" }}
                @endif
            </h1>
            <p class="game-subtitle">
                @if (!$game->isFull()&& !$isAiGame)
                    {{ $role === null ? 'Take the open seat and start playing.' : 'Share the invite below to start the match.' }}
                @elseif ($game->status === 'finished')
                    Thanks for playing Hex.
                @else
                    Connect your two sides before your opponent does.
                @endif
            </p>
        </div>

        @if (!$game->isFull() && !$isAiGame)
            @if ($role === null)
                <section class="game-panel game-panel--compact" aria-label="Join match">
                    <div class="waiting-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M16 20v-1.5a4.5 4.5 0 0 0-4.5-4.5H7a4.5 4.5 0 0 0-4.5 4.5V20"></path>
                            <circle cx="9.25" cy="7" r="4"></circle>
                            <path d="M17 8v6M14 11h6"></path>
                        </svg>
                    </div>
                    <p class="waiting-copy">One player is ready. Join them and claim the other side of the board.</p>
                    <form method="POST" action="{{ route('game.join', $game) }}">
                        @csrf
                        <x-button type="submit" variant="primary" size="large">
                            Join this game
                        </x-button>
                    </form>
                </section>
            @else
                <section class="game-panel game-panel--compact" aria-label="Invite opponent">
                    <div class="waiting-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="8"></circle>
                            <path d="M12 8v4l2.5 1.5"></path>
                        </svg>
                    </div>
                    <p class="waiting-copy">Send this link to a friend. This page will update when they join.</p>
                    <div class="share-link">
                        <span class="share-url" id="shareUrl">{{ route('game.show', $game) }}</span>
                        <button class="hexed-button hexed-button--secondary hexed-button--small copy-button"
                            id="copyInvite" type="button">
                            Copy link
                        </button>
                    </div>
                </section>
            @endif
        @else
            @php
                $svgWidth = 250 + $boardSize * 144;
                $svgHeight = 200 + $boardSize * 92;
            @endphp

            <section class="game-panel" aria-label="Hex game board">
                <div class="game-meta">
                    <span class="game-chip">
                        <span class="game-chip-dot"></span>
                        {{ $game->status === 'finished' ? 'Match finished' : 'Match in progress' }}
                    </span>
                    <span class="game-chip">
                        <span
                            class="game-chip-dot {{ $role === 'player1' ? 'player1' : ($role === 'player2' ? 'player2' : '') }}"></span>
                        @if ($role === 'player1')
                            You’re pink
                        @elseif ($role === 'player2')
                            You’re purple
                        @else
                            Spectating
                        @endif
                    </span>
                </div>

                <div class="board-shell">
                    <div class="board-objective">
                        <div class="goal-edge goal-edge--top" aria-hidden="true"><span>Player 1 · Pink</span></div>
                        <div class="goal-edge goal-edge--bottom" aria-hidden="true"><span>Player 1 · Pink</span></div>
                        <div class="goal-edge goal-edge--left" aria-hidden="true"><span>Player 2 · Purple</span></div>
                        <div class="goal-edge goal-edge--right" aria-hidden="true"><span>Player 2 · Purple</span></div>

                        <svg class="hex-board {{ $role && $isMyTurn ? 'is-playable' : '' }}" id="hexBoard"
                            viewBox="0 0 {{ $svgWidth }} {{ $svgHeight }}" role="img"
                            aria-label="Hex board. Player 1 pink connects top to bottom. Player 2 purple connects left to right.">
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
                                    fill="{{ $tile['owner'] === 'player1' ? '#e274d3' : ($tile['owner'] === 'player2' ? '#a97fe6' : '#5b4964') }}"
                                    stroke="#fde5d9" stroke-opacity="0.72" stroke-width="3"
                                    data-row="{{ $tile['row'] }}" data-column="{{ $tile['column'] }}"
                                    data-owner="{{ $tile['owner'] }}" onClick="hexClicked(this)" />
                            @endforeach
                        </svg>
                    </div>
                </div>

                <div class="board-legend" aria-label="Player colors">
                    <span class="legend-item"><span class="legend-swatch player1"></span>Player 1 · Pink · Top ↕
                        Bottom</span>
                    <span class="legend-item"><span class="legend-swatch player2"></span>Player 2 · Purple · Left ↔
                        Right</span>
                </div>
            </section>
        @endif
    </main>

    <script>
        const gameId = {{ $game->id }};
        const role = @json($role);
        const isAiGame = @json($isAiGame);
        const isGameFull = @json($game->isFull());
        let isMyTurn = @json($isMyTurn);
        const hexBoard = document.getElementById('hexBoard');
        const copyInvite = document.getElementById('copyInvite');


        const board = [];
        document.querySelectorAll('#hexBoard polygon').forEach(hex => {
            board.push({
                row: Number(hex.dataset.row),
                column: Number(hex.dataset.column),
                owner: hex.dataset.owner || null,
                element: hex,
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            copyInvite?.addEventListener('click', async () => {
                const shareUrl = document.getElementById('shareUrl')?.textContent?.trim();

                if (!shareUrl) {
                    return;
                }

                try {
                    await navigator.clipboard.writeText(shareUrl);
                    copyInvite.textContent = 'Copied!';
                    setTimeout(() => copyInvite.textContent = 'Copy link', 1800);
                } catch {
                    copyInvite.textContent = 'Copy failed';
                    setTimeout(() => copyInvite.textContent = 'Copy link', 1800);
                }
            });

            if (!window.Echo) {
                console.error('Laravel Echo was not loaded.');
                return;
            }

            window.Echo.private(`games.${gameId}`)
                .listen('GamePlayerJoined', (event) => {
                    console.log('Player joined:', event);

                    if (!isGameFull) {
                        window.location.reload();
                    }
                })
                .listen('GameMoveMade', (event) => {
                    console.log('Move received:', event);

                    const tile = board.find(tile =>
                        tile.row === Number(event.row) &&
                        tile.column === Number(event.column)
                    );

                    if (!tile) {
                        return;
                    }

                    tile.owner = event.role;
                    tile.element.dataset.owner = event.role;

                    tile.element.setAttribute(
                        'fill',
                        event.role === 'player1' ? '#e274d3' : '#a97fe6'
                    );

                    const title = document.getElementById('turnTitle');

                    if (event.winner) {
                        isMyTurn = false;
                        title.textContent =
                            event.winner === role ? 'You win!' : 'Opponent wins!';
                    } else {
                        isMyTurn = event.nextRole === role;
                        title.textContent =
                            isMyTurn ? 'Your turn' : "Opponent's turn";
                    }

                    syncBoardState();
                });
        });

        function syncBoardState() {
            hexBoard?.classList.toggle('is-playable', Boolean(role && isMyTurn));
        }

        async function hexClicked(hexElement) {
            if (!role || !isMyTurn) {
                return;
            }

            const tile = board.find(hex => hex.element === hexElement);

            if (tile.owner !== null) {
                return;
            }

            const moveUrl = isAiGame
                ? `/game/${gameId}/ai-move`
                : `/game/${gameId}/move`;

            const response = await fetch(moveUrl, {
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

            if (isAiGame) {
                data.board.forEach(updatedTile => {
                    const tile = board.find(tile =>
                        tile.row === updatedTile.row &&
                        tile.column === updatedTile.column
                    );

                    if (!tile) {
                        return;
                    }

                    tile.owner = updatedTile.owner;
                    tile.element.dataset.owner = updatedTile.owner ?? '';

                    if (updatedTile.owner === 'player1') {
                        tile.element.setAttribute('fill', '#e274d3');
                    } else if (updatedTile.owner === 'player2') {
                        tile.element.setAttribute('fill', '#a97fe6');
                    } else {
                        tile.element.setAttribute('fill', '#5b4964');
                    }
                });

                isMyTurn = !data.winner;

                if (data.winner === 1) {
                    title.textContent = 'You win!';
                } else if (data.winner === 2) {
                    title.textContent = 'AI wins!';
                } else {
                    title.textContent = 'Your turn';
                }

                syncBoardState();
                return;
            }

            // Existing friendly multiplayer handling
            tile.owner = role;
            tile.element.dataset.owner = role;

            hexElement.setAttribute(
                'fill',
                role === 'player1' ? '#e274d3' : '#a97fe6'
            );

            if (data.winner) {
                isMyTurn = false;
                title.textContent = 'You win!';
            } else {
                isMyTurn = false;
                title.textContent = "Opponent's turn";
            }

            syncBoardState();
        }
    </script>

    @include('components.footer')
</x-layout>