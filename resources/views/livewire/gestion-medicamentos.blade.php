<div class="space-y-4">
    @if (session('success'))
        <div class="rounded-md border border-green-600/30 bg-green-600/10 px-4 py-2 text-sm text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <flux:heading size="lg">
            <h1 class="text-3xl font-bold text-gradient-orange">Gestión de Medicamentos</h1>
        </flux:heading>
        <flux:button wire:click="nuevo" variant="primary">
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
                    @foreach($medicamentos as $med)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $med->nombre_generico }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $med->concentracion }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $med->via?->nombre ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                {{ $med->efecto?->nombre ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <flux:button 
                                        wire:click="editar({{ $med->id }})"
                                        variant="ghost" 
                                        size="sm"
                                    >
                                        <flux:icon.pencil class="size-4" />
                                    </flux:button>
                                    <flux:button 
                                        wire:click="eliminar({{ $med->id }})"
                                        wire:confirm="¿Eliminar este medicamento?"
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

    @if($mostrarModal)
        <flux:modal name="modal-medicamento" class="space-y-6" wire:model="mostrarModal">
            <div>
                <flux:heading size="lg">
                    {{ $med_id ? 'Editar Medicamento' : 'Nuevo Medicamento' }}
                </flux:heading>
                <flux:subheading>
                    {{ $med_id ? 'Actualiza la información' : 'Completa el formulario' }}
                </flux:subheading>
            </div>

            <form wire:submit.prevent="guardar" class="space-y-6">
                <flux:input
                    wire:model="nombre_generico"
                    label="Nombre Genérico"
                    placeholder="Ej: Paracetamol"
                    required
                />
                @error('nombre_generico')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <flux:input
                    wire:model="concentracion"
                    label="Concentración"
                    placeholder="Ej: 500mg"
                    required
                />
                @error('concentracion')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <flux:select wire:model="via_id" label="Vía de Administración" required>
                    <option value="">Seleccione una vía</option>
                    @foreach($vias as $via)
                        <flux:select.option value="{{ $via->id }}">{{ $via->nombre }}</flux:select.option>
                    @endforeach
                </flux:select>
                @error('via_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <flux:select wire:model="efecto_id" label="Efecto" required>
                    <option value="">Seleccione un efecto</option>
                    @foreach($efectos as $efecto)
                        <flux:select.option value="{{ $efecto->id }}">{{ $efecto->nombre }}</flux:select.option>
                    @endforeach
                </flux:select>
                @error('efecto_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                <div class="flex gap-2 justify-end">
                    <flux:button type="button" variant="ghost" wire:click="cancelar">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ $med_id ? 'Actualizar' : 'Guardar' }}
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    @endif
</div>