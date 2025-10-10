<div class="space-y-4">
    <div>
        @if (session('success'))
            <div class="rounded-md border border-green-600/30 bg-green-600/10 px-4 py-2 text-sm text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="rounded-xl border border-neutral-200 dark:border-neutral-700 overflow-hidden">
        <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
            <thead class="bg-neutral-50 dark:bg-neutral-800/60">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-600 dark:text-neutral-300">Nombre</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-600 dark:text-neutral-300">Email</th>
                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-neutral-600 dark:text-neutral-300">Rol</th>
                    <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-neutral-600 dark:text-neutral-300">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700 bg-white dark:bg-neutral-900">
                @forelse ($users as $user)
                    <tr wire:key="user-{{ $user->id }}">

                        {{-- Nombre --}}
                        <td class="px-4 py-3 align-top">
                            @if ($editId === $user->id)
                                <flux:input wire:model.defer="form.name" placeholder="Nombre" class="w-full" />
                                @error('form.name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            @else
                                <div class="text-sm dark:text-neutral-100">{{ $user->name }}</div>
                            @endif
                        </td>

                        {{-- Email --}}
                        <td class="px-4 py-3 align-top">
                            @if ($editId === $user->id)
                                <flux:input type="email" wire:model.defer="form.email" placeholder="correo@ejemplo.com" class="w-full" />
                                @error('form.email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            @else
                                <div class="text-sm text-neutral-600 dark:text-neutral-300">{{ $user->email }}</div>
                            @endif
                        </td>

                        {{-- Rol --}}
                        <td class="px-4 py-3 align-top">
                            @if ($editId === $user->id)
                                <flux:select wire:model.defer="form.rol" class="w-full" placeholder="Selecciona rol">
                                    <flux:select.option value="Cordinador">Cordinador</flux:select.option>
                                    <flux:select.option value="Profesor">Profesor</flux:select.option>
                                    <flux:select.option value="Alumno">Alumno</flux:select.option>
                                </flux:select>
                                @error('form.rol') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            @else
                                <span class="inline-flex items-center rounded-md border px-2 py-0.5 text-xs dark:text-neutral-200 border-neutral-300/60 dark:border-neutral-700">
                                    {{ $user->rol }}
                                </span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-4 py-3 align-top">
                            <div class="flex items-center justify-end gap-2">
                                @if ($editId === $user->id)
                                    {{-- Actualizar (guardar) --}}
                                    <flux:button size="sm" icon="check" variant="primary" wire:click="update" wire:loading.attr="disabled">
                                        {{ __('Actualizar') }}
                                    </flux:button>

                                    {{-- Cancelar --}}
                                    <flux:button size="sm" icon="x-circle" variant="ghost" wire:click="cancel">
                                        {{ __('Cancelar') }}
                                    </flux:button>
                                @else
                                    {{-- Editar --}}
                                    <flux:button size="sm" icon="pencil" variant="ghost" wire:click="edit({{ $user->id }})">
                                        {{ __('Editar') }}
                                    </flux:button>

                                    {{-- Eliminar --}}
                                    <flux:button size="sm" icon="trash" variant="danger" wire:click="delete({{ $user->id }})" onclick="return confirm('¿Eliminar este usuario?')">
                                        {{ __('Eliminar') }}
                                    </flux:button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-neutral-500 dark:text-neutral-400">
                            No hay usuarios.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold dark:text-neutral-100">{{ __('Crear Usuarios') }}</h1>
</div>
<form method="POST" wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="name"
            :label="__('Nombre completo')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('Nombre ')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />
        <!-- Rol -->
        <flux:select wire:model="rol" 
            placeholder="Que tipo de usuario eres..."
            :label="__('Selecciona tu rol')"
            required>
            <flux:select.option>Cordinador</flux:select.option>
            <flux:select.option>Profesor</flux:select.option>
            <flux:select.option>Alumno</flux:select.option>
        </flux:select>

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Constraseña')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Contraseña')"
            viewable
        />
        
        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirmar Contraseña')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirmar Contraseña')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Crear Cuenta') }}
            </flux:button>
        </div>
    </form>

</div>