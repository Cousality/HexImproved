 <x-layout>
     <style>
         * {
             box-sizing: border-box;
             margin: 0;
             padding: 0;
         }

         body {
             font-family: Arial, Helvetica, sans-serif;
             background: #f4f4f4;
             color: #222;
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
             <a href="{{ route('game') }}"><button>Play</button></a>
             <button>Play</button>
         </div>
     </main>
 </x-layout>
