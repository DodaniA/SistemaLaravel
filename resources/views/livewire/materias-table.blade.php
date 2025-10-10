<div class="space-y-4">
    @if (session('success'))
        <div class="rounded-md border border-green-600/30 bg-green-600/10 px-4 py-2 text-sm text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold dark:text-neutral-100">{{ __('Materias') }}</h2>
        @if (!$creating)
            <flux:button icon="plus" variant="primary" wire:click="openCreate">
                {{ __('Nueva materia') }}
            </flux:button>
        @endif
    </div>

    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
            <thead class="bg-neutral-50 dark:bg-neutral-800/60">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-neutral-600 dark:text-neutral-300">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-neutral-600 dark:text-neutral-300">Nombre</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase text-neutral-600 dark:text-neutral-300">Profesor</th>
                    <th class="px-4 py-3 text-right text-xs font-medium uppercase text-neutral-600 dark:text-neutral-300">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700 bg-white dark:bg-neutral-900">
                {{-- Fila para crear --}}
                @if ($creating)
                    <tr>
                        <td class="px-4 py-3">—</td>
                        <td colspan="3" class="px-4 py-3">
                            <form wire:submit.prevent="store" class="grid gap-3 md:grid-cols-3">
                                <div>
                                    <flux:input wire:model.defer="create.nombre" placeholder="Nombre de la materia" />
                                    @error('create.nombre') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <flux:select wire:model.defer="create.id_profesor" placeholder="Selecciona profesor">
                                        @foreach ($profesores as $p)
                                            <flux:select.option :value="$p->id">{{ $p->name }}</flux:select.option>
                                        @endforeach
                                    </flux:select>
                                    @error('create.id_profesor') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div class="flex items-center justify-end gap-2">
                                    <flux:button type="submit" size="sm" icon="check" variant="primary" wire:loading.attr="disabled">
                                        Guardar
                                    </flux:button>
                                    <flux:button type="button" size="sm" icon="x-circle" variant="ghost" wire:click="cancelCreate">
                                        Cancelar
                                    </flux:button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endif

                {{-- Fila por cada materia --}}
                @foreach ($materias as $m)
                    <tr wire:key="materia-{{ $m->id }}">
                        <td class="px-4 py-3">{{ $m->id }}</td>

                        {{-- Nombre --}}
                        <td class="px-4 py-3">
                            @if ($editId === $m->id)
                                <flux:input wire:model.defer="form.nombre" />
                                @error('form.nombre') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            @else
                                <div class="text-sm dark:text-neutral-100">{{ $m->nombre }}</div>
                            @endif
                        </td>

                        {{-- Profesor --}}
                        <td class="px-4 py-3">
                            @if ($editId === $m->id)
                                <flux:select wire:model.defer="form.id_profesor">
                                    @foreach ($profesores as $p)
                                        <flux:select.option :value="$p->id">{{ $p->name }}</flux:select.option>
                                    @endforeach
                                </flux:select>
                                @error('form.id_profesor') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            @else
                                <div class="text-sm text-neutral-600 dark:text-neutral-300">
                                    {{ optional($m->profesor)->name ?? '—' }}
                                </div>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                @if ($editId === $m->id)
                                    <flux:button size="sm" icon="check" variant="primary" wire:click="update">
                                        Actualizar
                                    </flux:button>
                                    <flux:button size="sm" icon="x-circle" variant="ghost" wire:click="cancel">
                                        Cancelar
                                    </flux:button>
                                @else
                                    <flux:button size="sm" icon="pencil" variant="ghost" wire:click="edit({{ $m->id }})">
                                        Editar
                                    </flux:button>
                                    <flux:button size="sm" icon="trash" variant="danger" wire:click="delete({{ $m->id }})"
                                        onclick="return confirm('¿Eliminar esta materia?')">
                                        Eliminar
                                    </flux:button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if ($materias->isEmpty())
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-neutral-500 dark:text-neutral-400">
                            No hay materias registradas.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
