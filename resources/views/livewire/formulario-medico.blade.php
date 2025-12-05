<div class="space-y-4">
    <div>
        @if (session('success'))
            <div class="rounded-md border border-green-600/30 bg-green-600/10 px-4 py-2 text-sm text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif
        
        <p class="rounded-md border border-red-600/30 bg-red-600/10 px-4 py-2 text-sm text-red-700 dark:text-red-300">Completa tu informacion</p>
    </div>

    <form wire:submit.prevent="crear" class="flex flex-col gap-6">
     
        <flux:select wire:model="especialidad_id"
            placeholder="Selecciona especialidad..."
            :label="__('Selecciona tu especialidad')"
            required>
            @foreach($especialidades as $especialidad)
                <flux:select.option value="{{ $especialidad->id }}">
                    {{ $especialidad->nombre }}
                </flux:select.option>
            @endforeach
        </flux:select>
        @error('especialidad_id')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror

        <!-- Cédula Profesional -->
        <flux:input
            wire:model="cedula_profesional"
            :label="__('Cédula Profesional')"
            type="text"
            required
            placeholder="Cédula Profesional"
        />
        @error('cedula_profesional')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror

        <!-- Descripción -->
        <flux:input
            wire:model="descripcion"
            :label="__('Descripción')"
            type="text"
            placeholder="Descripción breve sobre el doctor"
        />
        @error('descripcion')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Añadir Información') }}
            </flux:button>
        </div>
    </form>
</div>
