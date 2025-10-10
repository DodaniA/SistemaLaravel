<div class="space-y-4">
    {{-- Mensajes --}}
    @if (session('success'))
        <div class="rounded-md border border-green-600/30 bg-green-600/10 px-4 py-2 text-sm text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold dark:text-neutral-100">{{ __('Inscripciones') }}</h2>
        @if (!$creating)
            <flux:button icon="plus" variant="primary" wire:click="openCreate">
                {{ __('Nueva inscripción') }}
            </flux:button>
        @endif
    </div>

    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
            <thead class="bg-neutral-50 dark:bg-neutral-800/60">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-600 dark:text-neutral-300">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-600 dark:text-neutral-300">Alumno</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-600 dark:text-neutral-300">Materia</th>
                    <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-neutral-600 dark:text-neutral-300">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700 bg-white dark:bg-neutral-900">

              
                @if ($creating)
                    <tr>
                        <td class="px-4 py-3 align-top">
                            <span class="text-neutral-400">—</span>
                        </td>
                        <td class="px-4 py-3 align-top">
                            <flux:select wire:model.defer="create.id_alumno" class="w-full" >
                               <flux:select.option value="">
                                    Selecciona alumno
                                </flux:select.option>
                                @foreach ($alumnos as $a)
                                    <flux:select.option value="{{ $a->id }}">{{ $a->name }}</flux:select.option>
                                @endforeach
                            </flux:select>
                            @error('create.id_alumno') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </td>
                        <td class="px-4 py-3 align-top">
                            <flux:select wire:model.defer="create.id_materia" class="w-full" >
                               <flux:select.option value="">
                                    Selecciona materia
                                </flux:select.option>
                                @foreach ($materias as $m)
                                    <flux:select.option value="{{ $m->id }}">{{ $m->nombre }}</flux:select.option>
                                @endforeach
                            </flux:select>
                            @error('create.id_materia') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </td>
                        <td class="px-4 py-3 align-top">
                            <div class="flex items-center justify-end gap-2">
                                <flux:button size="sm" icon="check" variant="primary" wire:click="store" wire:loading.attr="disabled">
                                    {{ __('Guardar') }}
                                </flux:button>
                                <flux:button size="sm" icon="x-circle" variant="ghost" wire:click="cancelCreate">
                                    {{ __('Cancelar') }}
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                @endif

               
                @forelse ($inscripciones as $i)
                    <tr wire:key="ins-{{ $i->id }}">
                        <td class="px-4 py-3 align-top">
                            <div class="text-sm text-neutral-600 dark:text-neutral-300">{{ $i->id }}</div>
                        </td>

                        {{-- Alumno --}}
                        <td class="px-4 py-3 align-top">
                            @if ($editId === $i->id)
                                <flux:select wire:model.defer="form.id_alumno" class="w-full" placeholder="Selecciona alumno">
                                    @foreach ($alumnos as $a)
                                        <flux:select.option value="{{ $a->id }}">{{ $a->name }}</flux:select.option>
                                    @endforeach
                                </flux:select>
                                @error('form.id_alumno') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            @else
                                <div class="text-sm dark:text-neutral-100">{{ optional($i->alumno)->name ?? '—' }}</div>
                            @endif
                        </td>

                        {{-- Materia --}}
                        <td class="px-4 py-3 align-top">
                            @if ($editId === $i->id)
                                <flux:select wire:model.defer="form.id_materia" class="w-full" placeholder="Selecciona materia">
                                        
                                    @foreach ($materias as $m)
                                        <flux:select.option value="{{ $m->id }}">{{ $m->nombre }}</flux:select.option>
                                    @endforeach
                                </flux:select>
                                @error('form.id_materia') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            @else
                                <div class="text-sm text-neutral-600 dark:text-neutral-300">{{ optional($i->materia)->nombre ?? '—' }}</div>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-4 py-3 align-top">
                            <div class="flex items-center justify-end gap-2">
                                @if ($editId === $i->id)
                                    <flux:button size="sm" icon="check" variant="primary" wire:click="update" wire:loading.attr="disabled">
                                        {{ __('Actualizar') }}
                                    </flux:button>
                                    <flux:button size="sm" icon="x-circle" variant="ghost" wire:click="cancel">
                                        {{ __('Cancelar') }}
                                    </flux:button>
                                @else
                                    <flux:button size="sm" icon="pencil" variant="ghost" wire:click="edit({{ $i->id }})">
                                        {{ __('Editar') }}
                                    </flux:button>
                                    <flux:button size="sm" icon="trash" variant="danger" wire:click="delete({{ $i->id }})" onclick="return confirm('¿Eliminar esta inscripción?')">
                                        {{ __('Eliminar') }}
                                    </flux:button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-neutral-500 dark:text-neutral-400">
                            No hay inscripciones.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
