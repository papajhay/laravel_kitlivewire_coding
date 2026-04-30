<x-layouts.app.sidebar>
    <flux:main>
        {{ $slot }}
         <flux:toast />
    </flux:main>

    <flux:toast />
</x-layouts.app.sidebar>
