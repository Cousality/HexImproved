<x-layout>
    <style>
        :root {
            --bg-dark: #2d133a;
            --bg-lighter: #422a4c;
            --text-yellow: #f6e999;
            --accent-light: #fde5d9;
            --player-1: #e274d3;
            --player-2: #a97fe6;
            --radius: 16px;
        }

        .bg-lighter {
            background-color: var(--bg-lighter);
        }

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
            color: var(--text-yellow);
        }

        .play-buttons {
            display: flex;
            gap: 20px;
            align-items: center;
        }
    </style>

    <body>
        @include('components.nav')

        <main>
            <h1>Play Hex</h1>
            <div class="mode-grid">
                <x-mode-card icon-variant="ai" kicker="Versus AI" title="Play vs AI"
                    description="Challenge a bot to a hex game. Choose from beginner to master."
                    button-text="Challenge AI" button-variant="secondary" :href="route('game.ai.create')" method="POST">
<<<<<<< HEAD

=======
>>>>>>> 2733ffedbd90239cdbce2064eb5eb2e3ad6e05d8
                    <x-slot:icon>
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="5" y="6" width="14" height="12" rx="3"></rect>
                            <path d="M9 11h.01M15 11h.01M9 15h6M12 6V3M10 3h4"></path>
                        </svg>
                    </x-slot:icon>

                </x-mode-card>

                <x-mode-card icon-variant="friendly" kicker="Multiplayer" title="Friendly match"
                    description="Create a fresh game and go head-to-head with a friend." button-text="Create a game"
                    button-variant="primary" :href="route('game.create')" method="POST">
                    <x-slot:icon>
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M16 20v-1.5a4.5 4.5 0 0 0-4.5-4.5H7a4.5 4.5 0 0 0-4.5 4.5V20"></path>
                            <circle cx="9.25" cy="7" r="4"></circle>
                            <path d="M17 8v6M14 11h6"></path>
                        </svg>
                    </x-slot:icon>
                </x-mode-card>
            </div>
        </main>
    </body>
    @include('components.footer')
</x-layout>