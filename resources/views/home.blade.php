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

         .play-buttons {
             display: flex;
             gap: 20px;
         }

         .play-buttons button {
             padding: 14px 32px;
             font-size: 1rem;
             background: #222;
             color: #fff;
             border: none;
             border-radius: 4px;
             cursor: pointer;
         }

         .play-buttons button:hover {
             background: #444;
         }
     </style>

     @include('components.nav')

     <main>
         <h1>Hexed</h1>
         <div class="play-buttons">
             <a href="{{ route('game') }}"><button>Play vs AI</button></a>
             <button>Friendly</button>
         </div>
     </main>
 </x-layout>
