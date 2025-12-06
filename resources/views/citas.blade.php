<x-layouts.app :title="__('Citas')" >

@php
    $user = auth()->user();
@endphp
@if ($user->role === 'Paciente')
    <livewire:agenda-cita/>
    <livewire:agenda/>
@endif
@if ($user->role === 'Medico')
     <livewire:estadistica-citas/>
@endif
</x-layouts.app>
