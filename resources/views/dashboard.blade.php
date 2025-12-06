<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

         @php
            $user = auth()->user();

           $completo = false;
            if ($user->role === 'Paciente') {
                $completo = \App\Models\Paciente::where('user_id', $user->id)->exists();
            } elseif ($user->role === 'Medico') {
                $completo = \App\Models\Doctor::where('user_id', $user->id)->exists();
            }
        @endphp

         <p>Bienvenido, {{ $user->name }}</p>
        @if ($user->role === 'Paciente' && !$completo)
            <livewire:formulario-paciente />
        @endif
        @if ($user->role === 'Medico' && !$completo)
            <livewire:formulario-medico />
        @endif
        <livewire:card-doctores />

        <livewire:citas-doctor/>
    </div>
</x-layouts.app>
