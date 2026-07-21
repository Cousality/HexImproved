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
        let player1 = false;

        function hexClicked(hex) {
            if (player1 == false) {
                hex.setAttribute('fill', 'blue');
                player1 = true;
            } else {
                hex.setAttribute('fill', 'red');
                player1 = false;
            }

        }
    </script>

</x-layout>
