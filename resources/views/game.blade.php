<x-layout>

    @include('components.nav')

    <svg width="1500" height="1500">

        @for ($row = 0; $row < 5; $row++)

            @for ($column = 0; $column < 5; $column++)
                @php
                    $x = 100 + $column * 96 + $row * 48;
                    $y = 100 + $row * 92;
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
                    fill="lightgray" stroke="black" data-row="{{ $row }}" data-column="{{ $column }}"
                    onClick="hexClicked(this)" />
            @endfor

        @endfor

    </svg>
    <script>
        const board =  [];
        document.querySelectorAll('polygon').forEach(hex => {
            board.push({
                row: Number(hex.dataset.row),
                column: Number(hex.dataset.column),
                owner: null,
                element: hex

            })
        });

        </script>

    <script>
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
