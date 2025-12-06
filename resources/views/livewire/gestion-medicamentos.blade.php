<div class="space-y-4">
    @if (session('success'))
        <div class="rounded-md border border-green-600/30 bg-green-600/10 px-4 py-2 text-sm text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <flux:heading size="lg"><h1 class="text-3xl font-bold text-gradient-orange">Gestión de Medicamentos</h1></flux:heading>
        <flux:button wire:click="abrirModalCrear" variant="primary">
            <flux:icon.plus class="size-5" />
             Nuevo Medicamento
        </flux:button>
    </div>

    @if($medicamentos->isEmpty())
        <div class="rounded-md border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-4 py-8 text-center">
            <p class="text-gray-600 dark:text-gray-400">No hay medicamentos registrados.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Nombre Genérico
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Concentración
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Vía de Administración
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Efecto
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($medicamentos as $medicamento)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $medicamento->nombre_generico }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $medicamento->concentracion }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $medicamento->via?->nombre ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $medicamento->efecto?->nombre ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <flux:button 
                                        wire:click="abrirModalEditar({{ $medicamento->id }})"
                                        variant="ghost" 
                                        size="sm"
                                    >
                                        <flux:icon.pencil class="size-4" />
                                    </flux:button>
                                    <flux:button 
                                        wire:click="eliminar({{ $medicamento->id }})"
                                        wire:confirm="¿Estás seguro de eliminar este medicamento?"
                                        variant="danger" 
                                        size="sm"
                                    >
                                        <flux:icon.trash class="size-4" />
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Modal -->
    @if($mostrarModal)
        <flux:modal name="modal-medicamento" class="space-y-6" wire:model="mostrarModal">
            <div>
                <flux:heading size="lg">
                    {{ $modoEdicion ? 'Editar Medicamento' : 'Nuevo Medicamento' }}
                </flux:heading>
                <flux:subheading>
                    {{ $modoEdicion ? 'Actualiza la información del medicamento' : 'Completa el formulario para crear un medicamento' }}
                </flux:subheading>
            </div>

            <form wire:submit.prevent="guardar" class="space-y-6">
                <!-- Nombre Genérico -->
                <flux:input
                    wire:model="nombre_generico"
                    label="Nombre Genérico"
                    placeholder="Ej: Paracetamol"
                    required
                />
                @error('nombre_generico')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Concentración -->
                <flux:input
                    wire:model="concentracion"
                    label="Concentración"
                    placeholder="Ej: 500mg"
                    required
                />
                @error('concentracion')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

               <!-- Vía de Administración -->
                <flux:select
                    wire:model="via_id"
                    label="Vía de Administración"
                    required
                >
                    <option value="">Seleccione una vía</option>
                    @foreach($vias as $via)
                        <flux:select.option value="{{ $via->id }}">{{ $via->nombre }}</flux:select.option>
                    @endforeach
                </flux:select>
                @error('via_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <!-- Efecto -->
                <flux:select
                    wire:model="efecto_id"
                    label="Efecto"
                    required
                >
                    <option value="">Seleccione un efecto</option>
                    @foreach($efectos as $efecto)
                        <flux:select.option value="{{ $efecto->id }}">{{ $efecto->nombre }}</flux:select.option>
                    @endforeach
                </flux:select>
                @error('efecto_id')
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
                        {{ $modoEdicion ? 'Actualizar' : 'Guardar' }}
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    @endif
</div>