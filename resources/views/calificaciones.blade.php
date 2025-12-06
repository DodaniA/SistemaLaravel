<x-layouts.app :title="__('Calificaciones')" >
@php
    $user = auth()->user();
@endphp
@if ($user->role === 'Paciente')
    <livewire:calificar/>
@endif
@if ($user->role === 'Medico')
    <livewire:estadistica-cal/>
@endif

</x-layouts.app>
