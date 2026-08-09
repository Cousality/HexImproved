@props([
    'kicker',
    'title',
    'description',
    'iconVariant' => 'ai',
    'buttonText',
    'buttonVariant' => 'primary',
    'href' => null,
    'method' => 'GET',
])

<article class="mode-card bg-lighter">
    <div class="mode-icon {{ $iconVariant }}" aria-hidden="true">
        {{ $icon }}
    </div>
    <p class="mode-kicker">{{ $kicker }}</p>
    <h2 class="mode-title">{{ $title }}</h2>
    <p class="mode-copy">{{ $description }}</p>
    <div class="mode-action">
        <x-button :href="$href" :method="$method" :variant="$buttonVariant" size="large">
            {{ $buttonText }}
        </x-button>
    </div>
</article>
