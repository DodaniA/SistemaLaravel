<div class="space-y-6">
    @if (session('success'))
        <div class="animate-fade-in rounded-lg border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20 px-5 py-3 text-sm font-medium text-emerald-700 dark:text-emerald-300 shadow-sm">
            <div class="flex items-center gap-2">
                <flux:icon.check-circle class="size-5" />
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="animate-fade-in rounded-lg border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 px-5 py-3 text-sm font-medium text-red-700 dark:text-red-300 shadow-sm">
            <div class="flex items-center gap-2">
                <flux:icon.exclamation-circle class="size-5" />
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gradient-orange">Mis Citas</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Gestiona tus citas médicas programadas</p>
        </div>
        <flux:button wire:click="actualizarEstados" variant="primary" size="sm">
            Actualizar
        </flux:button>
    </div>

    @if($citas->isEmpty())
        <div class="rounded-xl border-2 border-dashed border-orange-200 dark:border-slate-700 bg-orange-50/50 dark:bg-slate-800/30 px-8 py-12 text-center">
            <flux:icon.calendar class="mx-auto size-12 text-orange-400 dark:text-orange-500 mb-3" />
            <p class="text-lg font-semibold text-slate-700 dark:text-slate-300">No tienes citas agendadas</p>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Crea una nueva cita para comenzar</p>
        </div>
    @else
        <div class="grid gap-4">
            @foreach($citas as $cita)
                <div class="stat-card stat-card-orange group overflow-hidden">
                    <div class="px-6 py-4 border-b border-orange-100 dark:border-slate-700 bg-gradient-to-r from-orange-50/80 dark:from-slate-900/50 to-white dark:to-slate-800">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="stat-icon stat-icon-orange">
                                    <flux:icon.user-circle class="size-6" />
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-800 dark:text-slate-100">
                                        {{ $cita->doctor->user?->name ?: 'Doctor ' . $cita->doctor_id }}
                                    </h3>
                                    <p class="text-xs text-slate-600 dark:text-slate-400">
                                        {{ $cita->doctor->especialidad?->nombre ?? 'Especialidad no definida' }}
                                    </p>
                                </div>
                            </div>
                            
                            @php
                                $estadoConfig = match($cita->estado) {
                                    'pendiente' => ['badge-warning', 'Pendiente', 'clock'],
                                    'completada' => ['badge-success', 'Completada', 'check-circle'],
                                    'cancelada' => ['badge-danger', 'Cancelada', 'x-circle'],
                                    default => ['badge-info', ucfirst($cita->estado), 'question-mark-circle'],
                                };
                            @endphp
                            
                            <span class="{{ $estadoConfig[0] }} flex items-center gap-1.5">
                                <flux:icon :name="$estadoConfig[2]" class="size-3.5" />
                                {{ $estadoConfig[1] }}
                            </span>
                        </div>
                    </div>

                    <div class="px-6 py-4 space-y-3">
                        <div class="flex items-center gap-3 text-slate-700 dark:text-slate-300">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-900/30">
                                <flux:icon.calendar class="size-5 text-orange-600 dark:text-orange-400" />
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Fecha y Hora</p>
                                <p class="font-semibold">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y') }}</p>
                                <p class="text-sm text-orange-600 dark:text-orange-400">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 text-slate-700 dark:text-slate-300">
                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex-shrink-0">
                                <flux:icon.information-circle class="size-5 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div class="flex-1">
                                <p class="text-xs font-medium text-slate-600 dark:text-slate-400">Motivo de la cita</p>
                                <p class="font-medium line-clamp-2">{{ $cita->motivo }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-3 border-t border-orange-100 dark:border-slate-700 bg-orange-50/30 dark:bg-slate-900/30 flex justify-end">
                        <flux:button 
                            wire:click="eliminar({{ $cita->id }})" 
                            wire:confirm="¿Estás seguro de eliminar esta cita?"
                            variant="danger" 
                            size="sm"
                        >
                            Eliminar
                        </flux:button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>