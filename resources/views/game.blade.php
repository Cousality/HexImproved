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
                fill="lightgray" stroke="black" data-row="{{ $tile['row'] }}" data-column="{{ $tile['column'] }}"
                onClick="hexClicked(this)" />
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
                owner: null,
                element: hex

            };
            board.push(tile);
        });



        let Player1 = false;

        function hexClicked(hexElement){

        const tile = board.find(function(hex){return hex.element === hexElement});

        if (tile.owner !==null){
            alert('This tile is already owned by a player!');
            return;
        }

        tile.owner = Player1 ? 'Player 1' : 'Player 2';

        if (Player1){
            
            hexElement.setAttribute('fill', 'blue');
        } else {
            hexElement.setAttribute('fill', 'red');
        }

        Player1 = !Player1;
        }

    



    </script>


</x-layout>
