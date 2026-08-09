@props(['title'])

<style>
    .auth-page {
        min-height: calc(100vh - 60px);
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--bg-dark);
        padding: 1.5rem;
    }

    .auth-card {
        width: 100%;
        max-width: 26rem;
        background: var(--bg-lighter);
        border: 1px solid rgba(253, 229, 217, 0.12);
        border-radius: var(--radius);
        box-shadow: 0 22px 60px rgba(18, 7, 24, 0.2);
        padding: 2.25rem;
    }

    .auth-title {
        font-family: "Fredoka", sans-serif;
        font-size: 1.9rem;
        font-weight: 600;
        color: var(--text-yellow);
        text-align: center;
        margin: 0 0 1.75rem;
    }

    .auth-field {
        margin-bottom: 1.1rem;
    }

    .auth-label {
        display: block;
        margin-bottom: 0.4rem;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--text-yellow);
    }

    .auth-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        border: 1px solid rgba(253, 229, 217, 0.18);
        background: rgba(253, 229, 217, 0.06);
        color: var(--accent-light);
        font-family: "Fredoka", sans-serif;
        font-size: 0.95rem;
    }

    .auth-input::placeholder {
        color: rgba(253, 229, 217, 0.4);
    }

    .auth-input:focus {
        outline: none;
        border-color: var(--text-yellow);
        background: rgba(253, 229, 217, 0.1);
    }

    .auth-submit {
        width: 100%;
        margin-top: 0.5rem;
    }

    .auth-footer {
        margin-top: 1.5rem;
        text-align: center;
        font-size: 0.85rem;
        color: rgba(253, 229, 217, 0.65);
    }

    .auth-footer a {
        color: var(--text-yellow);
        text-decoration: none;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }
</style>

<div class="auth-page">
    <div class="auth-card">

        <h1 class="auth-title">
            {{ $title }}
        </h1>

        {{ $slot }}

        @isset($footer)
            <div class="auth-footer">
                {{ $footer }}
            </div>
        @endisset

    </div>
</div>
