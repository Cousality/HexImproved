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
    </style>


    @include('components.nav')

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
                fill="lightgray" stroke="black" data-row="{{ $tile['row'] }}" data-column="{{ $tile['column'] }}"
                onClick="hexClicked(this)" />
        @endforeach
    </svg>

    <script>
        const board = [];
        document.querySelectorAll('polygon').forEach(hex => {
            board.push({
                row: Number(hex.dataset.row),
                column: Number(hex.dataset.column),
                owner: null,
                element: hex
            })
        });

        let player1 = false;

        function hexClicked(hexElement) {
            const tile = board.find(hex => {
                return hex.element === hexElement
            })
            if (tile.owner === null) {
                tile.owner = player1 ? 'Player 1' : 'Player 2';
                hexElement.setAttribute('fill', player1 ? 'purple' : 'pink');
                player1 = !player1;
            } else {
                return;
            }
        }
    </script>
</x-layout>
