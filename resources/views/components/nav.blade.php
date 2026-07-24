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

        .logo a {
            color: inherit;
            text-decoration: none;
        }

        nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
            background: #222;
            color: #fff;
        }

        nav .logo {
            font-size: 1.3rem;
            font-weight: bold;
        }

        nav button {
            padding: 8px 18px;
            font-size: 0.95rem;
            background: #444;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        nav button:hover {
            background: #555;
        }
    </style>

    <nav>
        <div class="logo">
            <a href="{{ route('home') }}">Hexed</a>
        </div>
        <div>
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button>Logout</button>
                </form>
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
