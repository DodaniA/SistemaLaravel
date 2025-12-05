<div>
    <!-- Botón para abrir el modal -->
    <flux:button @click="$flux.modal('modal-cita').show()">
        Nueva Cita
    </flux:button>

    <!-- Modal -->
    <flux:modal name="modal-cita" class="space-y-6">
        <div>
            <flux:heading size="lg">Agendar Nueva Cita</flux:heading>
            <flux:subheading>Complete el formulario para crear una cita médica</flux:subheading>
        </div>

        @if (session('success'))
            <div class="rounded-md border border-green-600/30 bg-green-600/10 px-4 py-2 text-sm text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="crear" class="flex flex-col gap-6">
            <flux:select
                wire:model="doctor_id"
                :label="__('Doctor')"
                required
            >       <flux:select.option value="">{{ __('Seleccione un doctor') }}
                    </flux:select.option>
                @foreach($doctores as $doctor)
                    <flux:select.option value="{{ $doctor->id }}">
                        {{ $doctor->user?->name . ' - ' . $doctor->especialidad?->nombre ?: 'Doctor ' . $doctor->id }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            @error('doctor_id')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <flux:input
                wire:model="fecha_hora"
                :label="__('Fecha y hora de la cita')"
                type="datetime-local"
                required
            />
            @error('fecha_hora')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <flux:input
                wire:model="motivo"
                :label="__('Motivo de la cita')"
                required
                placeholder="Describe brevemente el motivo de la cita"
            />
            @error('motivo')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror

            <div class="flex gap-2 justify-end">
                <flux:button type="button" variant="ghost" @click="$flux.modal('modal-cita').close()">
                    Cancelar
                </flux:button>
                <flux:button type="submit" variant="primary">
                    {{ __('Crear cita') }}
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>