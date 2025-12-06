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

         <div class="w-full flex justify-end">
            <div class="inline-flex items-center rounded-md px-4 py-2  font-semibold shadow-sm">
                <span>Bienvenido, {{ $user->name }}</span>
                <span class="ml-3 text-sm font-bold text-gradient-orange">({{ $user->role }})</span>
            </div>
         </div>
        @if ($user->role === 'Paciente' && !$completo)
            <livewire:formulario-paciente />
        @endif
        @if ($user->role === 'Medico' && !$completo)
            <livewire:formulario-medico />
        @endif
        @if ($user->role === 'Paciente') 
        <livewire:card-doctores />
        @endif
        @if ($user->role === 'Medico') 
        <livewire:citas-doctor/>
        @endif
    </div>
</x-layouts.app>
