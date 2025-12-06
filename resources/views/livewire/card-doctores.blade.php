<div class="space-y-6">
    <flux:heading size="lg">Doctores</flux:heading>

    @if($doctores->isEmpty())
        <div class="rounded-md border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-4 py-8 text-center">
            <p class="text-gray-600 dark:text-gray-400">No hay doctores registrados.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($doctores as $doctor)
                <div class="stat-card stat-card-orange">
                    <div class="stat-card-header">
                        <div class="stat-icon stat-icon-orange">
                            {{ substr($doctor->user?->name ?? 'D', 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-900 dark:text-white">
                                {{ $doctor->user?->name ?? 'Sin nombre' }}
                            </h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                {{ $doctor->especialidad?->nombre ?? 'Sin especialidad' }}
                            </p>
                        </div>
                    </div>

                    <div class="stat-card-content space-y-2">
                        <div class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                            <flux:icon icon="envelope" class="size-4 text-orange-600 dark:text-orange-400" />
                            <span>{{ $doctor->user?->email ?? 'Sin email' }}</span>
                        </div>

                        @if($doctor->cedula_profesional)
                            <div class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                                <flux:icon icon="document-text" class="size-4 text-orange-600 dark:text-orange-400" />
                                <span>{{ $doctor->cedula_profesional }}</span>
                            </div>
                        @endif

                        @if($doctor->descripcion)
                            <div class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">
                                {{ $doctor->descripcion }}
                            </div>
                        @endif
                    </div>

                    <div class="stat-card-footer">
                        <flux:button 
                            wire:click="abrirModal({{ $doctor->id }})"
                            variant="primary" 
                            class="w-full"
                        >
                            Ver más información
                        </flux:button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($mostrarModal && $doctorSeleccionado)
    <flux:modal name="modal-doctor" class="space-y-6 max-w-3xl" wire:model="mostrarModal">
        <div>
            <h2 class="text-2xl font-bold text-gradient-orange">
                {{ $doctorSeleccionado->user?->name ?? 'Doctor' }}
            </h2>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                {{ $doctorSeleccionado->especialidad?->nombre ?? 'Sin especialidad' }}
            </p>
        </div>

        <div class="space-y-4 p-4 bg-orange-50 dark:bg-orange-900/10 rounded-lg border border-orange-200 dark:border-orange-800">
            <div>
                <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Correo Electrónico</p>
                <p class="text-slate-900 dark:text-white mt-1 flex items-center gap-2">
                    <flux:icon icon="envelope" class="size-4 text-orange-600 dark:text-orange-400" />
                    {{ $doctorSeleccionado->user?->email ?? 'N/A' }}
                </p>
            </div>
            
            @if($doctorSeleccionado->cedula_profesional)
                <div>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Cédula Profesional</p>
                    <p class="text-slate-900 dark:text-white mt-1 flex items-center gap-2">
                        <flux:icon icon="document-text" class="size-4 text-orange-600 dark:text-orange-400" />
                        {{ $doctorSeleccionado->cedula_profesional }}
                    </p>
                </div>
            @endif

            @if($doctorSeleccionado->descripcion)
                <div>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Descripción</p>
                    <p class="text-slate-900 dark:text-white mt-1">
                        {{ $doctorSeleccionado->descripcion }}
                    </p>
                </div>
            @endif
        </div>

        <div class="border-t border-orange-200 dark:border-orange-800 pt-6">
            <livewire:estadistica-cal :doctorId="$doctorSeleccionado->id" :key="'estadistica-'.$doctorSeleccionado->id" />
        </div>

        <div class="flex justify-end border-t border-orange-200 dark:border-orange-800 pt-4">
            <flux:button 
                type="button" 
                variant="ghost" 
                wire:click="cerrarModal"
            >
                Cerrar
            </flux:button>
        </div>
    </flux:modal>
    @endif
</div>