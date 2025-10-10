<x-layouts.app :title="__('Usuarios')" >
     <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold dark:text-neutral-100">{{ __('Usuarios') }}</h1>
    </div>

    <livewire:users-table />

</x-layouts.app>
