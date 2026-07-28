<x-layout>

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
                fill="{{ $tile['owner'] === 'player1' ? 'blue' : ($tile['owner'] === 'player2' ? 'red' : 'lightgray') }}"
                stroke="black" data-row="{{ $tile['row'] }}" data-column="{{ $tile['column'] }}"
                data-owner="{{ $tile['owner'] }}" onClick="hexClicked(this)" />
        @endforeach

    </svg>



    //working on this shi rn
    <script>
        //stores tiles on the board   
        const board = [];
        //fins every polygon and pushes it into the board array with its row, column, owner, and element
        document.querySelectorAll('polygon').forEach(hex => {
            const tile = {
                row: Number(hex.dataset.row),
                column: Number(hex.dataset.column),
                owner: hex.dataset.owner || null,
                element: hex

            };
            board.push(tile);
        });



        let currentPlayer = 'player1';

        async function hexClicked(hexElement) {
            const tile = board.find(hex => hex.element === hexElement);

            if (tile.owner !== null) {
                alert('This tile is already owned!');
                return;
            }

            const response = await fetch('/game/move', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    row: tile.row,
                    column: tile.column,
                    player: currentPlayer
                })
            });

            if (!response.ok) {
                const error = await response.text();
                document.open();
                document.write(error);
                document.close();
                return;
            }

            const data = await response.json();

            tile.owner = currentPlayer;

            hexElement.setAttribute(
                'fill',
                currentPlayer === 'player1' ? 'blue' : 'red'
            );

            if (data.winner) {
                alert(currentPlayer + ' wins!');

                await fetch('/game/reset', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                location.reload();
                return;
            }

            currentPlayer = currentPlayer === 'player1' ?
                'player2' :
                'player1';
        }
    </script>


</x-layout>
