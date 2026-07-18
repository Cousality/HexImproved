<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hexed</title>
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
</head>

<body>

    @include('components.nav')

    <main>
        <h1>Hexed</h1>
        <div class="play-buttons">
            <button>Play</button>
            <button>Play</button>
        </div>
    </main>

</body>

</html>
