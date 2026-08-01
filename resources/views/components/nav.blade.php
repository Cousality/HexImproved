 <style>
     * {
         box-sizing: border-box;
         margin: 0;
         padding: 0;
     }

     header {
         display: flex;
         justify-content: space-between;
         align-items: center;
         padding: 1.5rem 8%;
         background: rgba(45, 19, 58, 0.8);
         backdrop-filter: blur(10px);
         position: sticky;
         top: 0;
         z-index: 100;
         border-bottom: 1px solid var(--accent-light);
     }


     .logo-hex {
         width: 24px;
         height: 28px;
         background: var(--player-1);
         clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
         display: inline-block;
     }

     .logo {
         font-size: 1.8rem;
         letter-spacing: 2px;
         display: flex;
         align-items: center;
         gap: 10px;
         text-decoration: none;
         font-family: 'Fredoka', sans-serif;
         font-weight: 500;
         color: var(--text-yellow);
         text-decoration: none;
     }



     body {
         font-family: Arial, Helvetica, sans-serif;
         color: #f6e999;
     }

     nav {
         display: flex;
         gap: 2rem;
         align-items: center;
         backdrop-filter: blur(12px);
         /*--webkit-backdrop-filter: blur(12) */

     }

     nav a {
         color: var(--accent-light);
         text-decoration: none;
         font-weight: 500;
         transition: color 0.2s ease;
     }

     nav .logo {
         font-size: 1.3rem;
         font-weight: bold;
     }

     .auth-actions {
         display: flex;
         align-items: center;
         gap: 12px;
     }

     .auth-actions form {
         margin: 0;
     }



     @media (max-width: 600px) {
         .auth-actions {
             gap: 7px;
         }

         .hexed-button {
             min-height: 40px;
             padding-inline: 11px;
             font-size: 9px;
         }
     }
 </style>
 <header>
     <div class="logo">
         <a href="{{ route('home') }}" class="logo">
             <span class="logo-hex"></span>
             HEXED
         </a>
     </div>
     <nav>

         <div class="auth-actions" aria-label="Account actions">
             @auth
                 <x-button :href="route('profile')" variant="secondary">
                     Profile
                 </x-button>

                 <x-button :href="route('logout')" method="POST" variant="primary">
                     Logout
                 </x-button>
             @else
                 <x-button :href="route('login')" variant="secondary">
                     Login
                 </x-button>

                 <x-button :href="route('register')" variant="primary">
                     Register
                 </x-button>
             @endauth
         </div>
     </nav>
 </header>
