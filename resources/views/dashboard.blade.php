<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

         @php
            $user = auth()->user();

           $completo = false;
            if ($user->role === 'Paciente') {
                $completo = \App\Models\Paciente::where('user_id', $user->id)->exists();
            } elseif ($user->role === 'Doctor') {
                $completo = \App\Models\Doctor::where('user_id', $user->id)->exists();
            }
        @endphp

         <p>Bienvenido, {{ $user->name }}</p>
        @if ($user->role === 'Paciente' && !$completo)
            <livewire:formulario-paciente />
        @endif
        @if ($user->role === 'Doctor' && !$completo)
            <livewire:formulario-medico />
        @endif
       
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app>
