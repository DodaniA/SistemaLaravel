<div class="space-y-6">
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

    <flux:heading size="lg">Receta Médica</flux:heading>

    <!-- Indicaciones Generales -->
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
        <flux:heading size="sm" class="mb-4">Indicaciones Generales</flux:heading>
        
        @if(!$receta)
            <form wire:submit.prevent="crearReceta" class="space-y-4">
                <flux:textarea
                    wire:model="indicaciones"
                    label="Indicaciones"
                    placeholder="Escribe las indicaciones generales de la receta..."
                    rows="4"
                    required
                />
                @error('indicaciones')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <flux:button type="submit" variant="primary">
                    Crear Receta
                </flux:button>
            </form>
        @else
            <form wire:submit.prevent="actualizarIndicaciones" class="space-y-4">
                <flux:textarea
                    wire:model="indicaciones"
                    label="Indicaciones"
                    rows="4"
                    required
                />
                @error('indicaciones')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <flux:button type="submit" variant="ghost" size="sm">
                    Actualizar Indicaciones
                </flux:button>
            </form>
        @endif
    </div>

    <!-- Medicamentos Recetados -->
    @if($receta)
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="sm">Medicamentos Recetados</flux:heading>
                <flux:button wire:click="abrirModalAgregar" variant="primary" size="sm">
                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Agregar Medicamento
                </flux:button>
            </div>

            @if(empty($medicamentosRecetados))
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    No hay medicamentos agregados a la receta.
                </div>
            @else
                <div class="space-y-3">
                    @foreach($medicamentosRecetados as $recetaMed)
                        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <svg class="size-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        <flux:heading size="sm">
                                            {{ $recetaMed['medicamento']['nombre_generico'] }}
                                        </flux:heading>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Concentración:</span>
                                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $recetaMed['medicamento']['concentracion'] }}
                                            </span>
                                        </div>

                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Vía:</span>
                                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $recetaMed['medicamento']['via']['nombre'] ?? 'N/A' }}
                                            </span>
                                        </div>

                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Dosis:</span>
                                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $recetaMed['dosis'] }}
                                            </span>
                                        </div>

                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Frecuencia:</span>
                                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $recetaMed['frecuencia'] }}
                                            </span>
                                        </div>

                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Duración:</span>
                                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $recetaMed['duracion'] }}
                                            </span>
                                        </div>

                                        @if($recetaMed['instrucciones'])
                                            <div class="md:col-span-2">
                                                <span class="text-gray-600 dark:text-gray-400">Instrucciones:</span>
                                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $recetaMed['instrucciones'] }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-2 ml-4">
                                    <flux:button 
                                        wire:click="abrirModalEditar({{ $recetaMed['id'] }})"
                                        variant="ghost" 
                                        size="sm"
                                    >
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </flux:button>
                                    <flux:button 
                                        wire:click="eliminarMedicamento({{ $recetaMed['id'] }})"
                                        wire:confirm="¿Estás seguro de eliminar este medicamento de la receta?"
                                        variant="danger" 
                                        size="sm"
                                    >
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </flux:button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <!-- Modal Agregar/Editar Medicamento -->
    @if($mostrarModal)
        <flux:modal name="modal-medicamento" class="space-y-6" wire:model="mostrarModal">
            <div>
                <flux:heading size="lg">
                    {{ $medicamentoEditando ? 'Editar Medicamento' : 'Agregar Medicamento' }}
                </flux:heading>
                <flux:subheading>
                    {{ $medicamentoEditando ? 'Actualiza la información del medicamento' : 'Completa los detalles del medicamento' }}
                </flux:subheading>
            </div>

            <form wire:submit.prevent="guardarMedicamento" class="space-y-6">
                <!-- Medicamento -->
                <flux:select
                    wire:model="medicamento_id"
                    label="Medicamento"
                    required
                >
                    <option value="">Seleccione un medicamento</option>
                    @foreach($medicamentos as $medicamento)
                        <option value="{{ $medicamento->id }}">
                            {{ $medicamento->nombre_generico }} - {{ $medicamento->concentracion }}
                        </option>
                    @endforeach
                </flux:select>
                @error('medicamento_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Dosis -->
                <flux:input
                    wire:model="dosis"
                    label="Dosis"
                    placeholder="Ej: 1 tableta, 5ml, etc."
                    required
                />
                @error('dosis')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Frecuencia -->
                <flux:input
                    wire:model="frecuencia"
                    label="Frecuencia"
                    placeholder="Ej: Cada 8 horas, 3 veces al día, etc."
                    required
                />
                @error('frecuencia')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Duración -->
                <flux:input
                    wire:model="duracion"
                    label="Duración"
                    placeholder="Ej: 7 días, 2 semanas, etc."
                    required
                />
                @error('duracion')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Instrucciones -->
                <flux:textarea
                    wire:model="instrucciones"
                    label="Instrucciones especiales (opcional)"
                    placeholder="Ej: Tomar con alimentos, evitar lácteos, etc."
                    rows="3"
                />
                @error('instrucciones')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

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
                        {{ $medicamentoEditando ? 'Actualizar' : 'Agregar' }}
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    @endif
</div>