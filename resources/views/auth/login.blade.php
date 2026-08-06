<x-layout>
    @include('components.nav')

    <x-auth-card title="Login">

        <form action="" method="POST">

            @csrf

            <div class="auth-field">
                <label class="auth-label">
                    Email
                </label>

                <input type="email" name="email" class="auth-input" placeholder="Enter email">
            </div>

            <div class="auth-field">
                <label class="auth-label">
                    Password
                </label>

                <input type="password" name="password" class="auth-input" placeholder="Enter password">
            </div>

            <button type="submit" class="hexed-button hexed-button--primary auth-submit">
                Login
            </button>

        </form>

        <x-slot:footer>
            Don't have an account? <a href="/register">Sign up</a>
        </x-slot:footer>

    </x-auth-card>

</x-layout>
