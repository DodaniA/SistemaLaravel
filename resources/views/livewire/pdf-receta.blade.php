<div class="space-y-6">
    <flux:heading size="lg">Mis Recetas Médicas</flux:heading>

    @if($recetas->isEmpty())
        <div class="rounded-md border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-4 py-8 text-center">
            <p class="text-gray-600 dark:text-gray-400">No tienes recetas médicas.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($recetas as $receta)
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                    <!-- Header de la receta -->
                    <div class="flex items-start justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="size-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div>
                                    <flux:heading size="sm">
                                        Dr. {{ $receta->doctor->user?->name ?? 'N/A' }}
                                    </flux:heading>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $receta->doctor->especialidad?->nombre ?? 'Sin especialidad' }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm mt-3">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Fecha de emisión:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $receta->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                @if($receta->cita)
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Fecha de consulta:</span>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($receta->cita->fecha_hora)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            @if($receta->doctor->cedula_profesional)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                    Cédula Profesional: {{ $receta->doctor->cedula_profesional }}
                                </p>
                            @endif
                        </div>

                        <!-- Botón PDF -->
                        <flux:button 
                            wire:click="descargarPDF({{ $receta->id }})"
                            variant="primary"
                        >
                            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Descargar PDF
                        </flux:button>
                    </div>

                    <!-- Indicaciones -->
                    @if($receta->indicaciones)
                        <div class="mb-4">
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Indicaciones:</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100 bg-blue-50 dark:bg-blue-900/20 p-3 rounded">
                                {{ $receta->indicaciones }}
                            </p>
                        </div>
                    @endif

                    <!-- Medicamentos -->
                    @if($receta->medicamentos->isNotEmpty())
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Medicamentos recetados:</p>
                            <div class="space-y-3">
                                @foreach($receta->medicamentos as $rm)
                                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                        <div class="flex items-start gap-3">
                                            <svg class="size-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-900 dark:text-gray-100 mb-2">
                                                    {{ $rm->medicamento->nombre_generico }} - {{ $rm->medicamento->concentracion }}
                                                </p>
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-sm">
                                                    <div>
                                                        <span class="text-gray-600 dark:text-gray-400">Dosis:</span>
                                                        <span class="text-gray-900 dark:text-gray-100">{{ $rm->dosis }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-600 dark:text-gray-400">Frecuencia:</span>
                                                        <span class="text-gray-900 dark:text-gray-100">{{ $rm->frecuencia }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-gray-600 dark:text-gray-400">Duración:</span>
                                                        <span class="text-gray-900 dark:text-gray-100">{{ $rm->duracion }}</span>
                                                    </div>
                                                </div>
                                                @if($rm->instrucciones)
                                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">
                                                        <span class="font-medium">Instrucciones:</span> {{ $rm->instrucciones }}
                                                    </p>
                                                @endif
                                                <div class="flex gap-3 text-xs text-gray-500 dark:text-gray-400 mt-2">
                                                    <span>Vía: {{ $rm->medicamento->via?->nombre ?? 'N/A' }}</span>
                                                    <span>•</span>
                                                    <span>Efecto: {{ $rm->medicamento->efecto?->nombre ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>