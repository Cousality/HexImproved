<!DOCTYPE html>
<html lang="en">
<style>
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


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Hex' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    {{ $slot }}
</body>

</html>
