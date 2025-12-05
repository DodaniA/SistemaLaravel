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
            <!-- Selección de Grupo Sanguíneo -->
            <flux:select
                wire:model="grupo_sanguineo_id"
                :label="__('Grupo Sanguíneo')"
                required
            >
                @foreach($grupos_sanguineos as $grupo)
                    <flux:select.option value="{{ $grupo->id }}">
                        {{ $grupo->tipo }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <!-- Diagnósticos Previos -->
            <flux:input
                wire:model="diagnosticos_previos"
                :label="__('Diagnósticos Previos')"
                required
                placeholder="Diagnósticos previos del paciente"
            />

            <!-- Alergias -->
            <flux:input
                wire:model="alergias"
                :label="__('Alergias')"
                required
                placeholder="Alergias del paciente"
            />

            <flux:button type="submit" variant="primary">
                {{ __('Añadir Informaciónr') }}
            </flux:button>
        </form>
    </div>
