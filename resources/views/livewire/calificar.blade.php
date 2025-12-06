<div class="space-y-6">
    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20 px-5 py-3 text-sm font-medium text-emerald-700 dark:text-emerald-300 shadow-sm">
            <div class="flex items-center gap-2">
                <flux:icon.check-circle class="size-5" />
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-lg border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 px-5 py-3 text-sm font-medium text-red-700 dark:text-red-300 shadow-sm">
            <div class="flex items-center gap-2">
                <flux:icon.exclamation-circle class="size-5" />
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div>
        <h1 class="text-3xl font-bold text-gradient-orange">Calificar Consultas</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Comparte tu experiencia con los doctores</p>
    </div>

    @if($citasCompletadas->isEmpty())
        <div class="rounded-xl border-2 border-dashed border-orange-200 dark:border-slate-700 bg-orange-50/50 dark:bg-slate-800/30 px-8 py-12 text-center">
            <flux:icon.star class="mx-auto size-12 text-orange-400 dark:text-orange-500 mb-3" />
            <p class="text-lg font-semibold text-slate-700 dark:text-slate-300">No tienes citas completadas para calificar</p>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Una vez completada una cita podrás calificar tu experiencia</p>
        </div>
    @else
        <div class="grid gap-4">
            @foreach($citasCompletadas as $cita)
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
                            <span class="badge-info flex items-center gap-1.5">
                                <flux:icon.check-circle class="size-3.5" />
                                Completada
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
                            wire:click="abrirModal({{ $cita->id }})"
                            variant="primary" 
                            size="sm"
                        >
                            Calificar
                        </flux:button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($mostrarModal)
        <flux:modal name="modal-calificar" class="space-y-6" wire:model="mostrarModal">
            <div>
                <h2 class="text-2xl font-bold text-gradient-orange">Calificar Consulta</h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Ayúdanos a mejorar compartiendo tu experiencia</p>
            </div>

            <form wire:submit.prevent="guardarCalificacion" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-800 dark:text-slate-100 mb-3">Calificación</label>
                    <div class="flex gap-3">
                        @for($i = 1; $i <= 5; $i++)
                            <button 
                                type="button"
                                wire:click="$set('calificacion', {{ $i }})"
                                class="text-4xl transition-all {{ $calificacion >= $i ? 'text-amber-400 scale-110' : 'text-slate-300 dark:text-slate-600 hover:scale-105' }}"
                                title="{{ $i }} estrellas"
                            >
                                ★
                            </button>
                        @endfor
                    </div>
                    <p class="text-sm text-orange-600 dark:text-orange-400 font-medium mt-2">
                        {{ $calificacion }} de 5 estrellas
                    </p>
                    @error('calificacion')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <flux:textarea
                        wire:model="comentario"
                        label="Comentario (opcional)"
                        placeholder="Comparte tu experiencia con el doctor..."
                        rows="4"
                    />
                    @error('comentario')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-2 justify-end border-t border-orange-100 dark:border-slate-700 pt-4">
                    <flux:button 
                        type="button" 
                        variant="ghost" 
                        wire:click="cerrarModal"
                    >
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Guardar Calificación
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    @endif
</div>