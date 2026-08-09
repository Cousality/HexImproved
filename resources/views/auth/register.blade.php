<x-layout>
    @include('components.nav')

    <x-auth-card title="Create an Account">

        <form action="" method="POST">

            @csrf

            <div class="auth-field">
                <label class="auth-label">
                    Name
                </label>

                <input type="text" name="name" class="auth-input" placeholder="Enter name">
            </div>

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

            <div class="auth-field">
                <label class="auth-label">
                    Confirm Password
                </label>

                <input type="password" name="password_confirmation" class="auth-input" placeholder="Confirm password">
            </div>

            <button type="submit" class="hexed-button hexed-button--primary auth-submit">
                Register
            </button>

        </form>

        <x-slot:footer>
            Already have an account? <a href="/login">Login here</a>
        </x-slot:footer>

    </x-auth-card>

</x-layout>
