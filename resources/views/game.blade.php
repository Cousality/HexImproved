<x-layout>

    @include('components.nav')

    <svg width="900" height="700">

        @for ($row = 0; $row < 5; $row++)

            @for ($column = 0; $column < 5; $column++)

                @php
                    $x = 100 + ($column * 96) + ($row * 48);
                    $y = 100 + ($row * 92);
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
                    fill="lightgray"
                    stroke="black"
                    data-row="{{ $row }}"
                    data-column="{{ $column }}"
                    onClick="hexClicked(this)"
                />

            @endfor

        @endfor

    </svg>
    <script> 
    
        function hexClicked(hex) {
            hex.setAttribute('fill', 'lightblue');
        }
    </script>

</x-layout>