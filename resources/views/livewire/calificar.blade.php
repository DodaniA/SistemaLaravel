<div class="space-y-4">
    @if (session('success'))
        <div class="rounded-md border border-green-600/30 bg-green-600/10 px-4 py-2 text-sm text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-md border border-red-600/30 bg-red-600/10 px-4 py-2 text-sm text-red-700 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <flux:heading size="lg">Calificar Consultas</flux:heading>

    @if($citasCompletadas->isEmpty())
        <div class="rounded-md border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-4 py-8 text-center">
            <p class="text-gray-600 dark:text-gray-400">No tienes citas completadas pendientes de calificar.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($citasCompletadas as $cita)
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 space-y-2">
                            <flux:heading size="sm">
                                {{ $cita->doctor->user?->name . ' - ' . $cita->doctor->especialidad?->nombre ?: 'Doctor ' . $cita->doctor_id }}
                            </flux:heading>

                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                <flux:icon.calendar class="size-4" />
                                <span>{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }}</span>
                            </div>

                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                <strong>Motivo:</strong> {{ $cita->motivo }}
                            </div>
                        </div>

                        <div>
                            <flux:button 
                                wire:click="abrirModal({{ $cita->id }})"
                                variant="primary" 
                                size="sm"
                            >
                                <flux:icon.star class="size-4" />
                                Calificar
                            </flux:button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($mostrarModal)
        <flux:modal name="modal-calificar" class="space-y-6" wire:model="mostrarModal">
            <div>
                <flux:heading size="lg">Calificar Consulta</flux:heading>
                <flux:subheading>Ayúdanos a mejorar compartiendo tu experiencia</flux:subheading>
            </div>

            <form wire:submit.prevent="guardarCalificacion" class="space-y-6">

                <div>
                    <flux:label>Calificación</flux:label>
                    <div class="flex gap-2 mt-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button 
                                type="button"
                                wire:click="$set('calificacion', {{ $i }})"
                                class="text-3xl transition-colors {{ $calificacion >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                            >
                                ★
                            </button>
                        @endfor
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
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

                <!-- Botones -->
                <div class="flex gap-2 justify-end">
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