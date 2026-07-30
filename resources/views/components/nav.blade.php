    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg-dark: #2d133a;
            --bg-lighter: #422a4c;
            --text-yellow: #f6e999;
            --accent-light: #fde5d9;
            --player-1: #e274d3;
            --player-2: #a97fe6;
            --radius: 16px;
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
            border-bottom: 1px solid rgba(253, 229, 217, 0.1);
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
            background: #422a4c;
            color: #f6e999;
        }

        nav {
            display: flex;
            gap: 2rem;
            align-items: center;
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

        nav button {
            padding: 8px 18px;
            font-size: 0.95rem;
            font-family: Arial, Helvetica, sans-serif;
            background: #422a4c;
            color: #f6e999;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        nav button:hover {
            color: #fde5d9
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

            <div>
                @auth
                    <a action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button>Logout</button>
                    </a>
                    <a href="{{ route('profile') }}">
                        <button>Profile</button>
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        <button>Login</button>
                    </a>
                    <a href="{{ route('register') }}">
                        <button>Register</button>
                    </a>

                @endauth

            </div>
        </nav>
    </header>
