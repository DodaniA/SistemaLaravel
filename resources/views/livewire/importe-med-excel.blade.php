<div class="space-y-6">
    @if (session('success'))
        <div class="rounded-md border border-green-600/30 bg-green-600/10 px-4 py-2 text-sm text-green-700 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if (session('warning'))
        <div class="rounded-md border border-yellow-600/30 bg-yellow-600/10 px-4 py-2 text-sm text-yellow-700 dark:text-yellow-300">
            {{ session('warning') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-md border border-red-600/30 bg-red-600/10 px-4 py-2 text-sm text-red-700 dark:text-red-300">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="lg">Importar Medicamentos</flux:heading>
            <flux:subheading>Carga masiva de medicamentos desde archivo Excel</flux:subheading>
        </div>
        <flux:button wire:click="descargarPlantilla" variant="ghost">
            <flux:icon.arrow-down-tray class="size-5" />
            Descargar Plantilla
        </flux:button>
    </div>

    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
        <form wire:submit.prevent="importar" class="space-y-6">
            <!-- Información del formato -->
            <div class="rounded-md border border-blue-600/30 bg-blue-600/10 px-4 py-3 text-sm text-blue-700 dark:text-blue-300">
                <p class="font-semibold mb-2">Formato requerido del archivo:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li><strong>nombre_generico:</strong> Nombre del medicamento</li>
                    <li><strong>via_administracion:</strong> Vía de administración (Oral, Intravenosa, etc.)</li>
                    <li><strong>efecto:</strong> Efecto del medicamento (Analgésico, Antibiótico, etc.)</li>
                    <li><strong>concentracion:</strong> Concentración (500mg, 10ml, etc.)</li>
                </ul>
            </div>

            <!-- Selector de archivo -->
            <div>
                <flux:label>Archivo Excel/CSV</flux:label>
                <input 
                    type="file" 
                    wire:model="archivo"
                    accept=".xlsx,.xls,.csv"
                    class="mt-2 block w-full text-sm text-gray-900 dark:text-gray-100
                           file:mr-4 file:py-2 file:px-4
                           file:rounded-md file:border-0
                           file:text-sm file:font-semibold
                           file:bg-blue-50 file:text-blue-700
                           hover:file:bg-blue-100
                           dark:file:bg-blue-900 dark:file:text-blue-300"
                >
                @error('archivo')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror

                @if ($archivo)
                    <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Archivo seleccionado: <strong>{{ $archivo->getClientOriginalName() }}</strong>
                    </div>
                @endif
            </div>

            <!-- Botón de importar -->
            <div class="flex justify-end">
                <flux:button 
                    type="submit" 
                    variant="primary"
                    :disabled="$importando || !$archivo"
                >
                    @if($importando)
                        <flux:icon.arrow-path class="size-5 animate-spin" />
                        Importando...
                    @else
                        <flux:icon.arrow-up-tray class="size-5" />
                        Importar Medicamentos
                    @endif
                </flux:button>
            </div>
        </form>
    </div>

    <!-- Mostrar errores si los hay -->
    @if(!empty($errores))
        <div class="rounded-lg border border-red-600/30 bg-red-600/10 p-6">
            <flux:heading size="sm" class="text-red-700 dark:text-red-300 mb-4">
                Errores encontrados durante la importación
            </flux:heading>
            <div class="space-y-3">
                @foreach($errores as $error)
                    <div class="text-sm text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-900/20 p-3 rounded">
                        <strong>Fila {{ $error['fila'] }}:</strong>
                        <ul class="list-disc list-inside mt-1">
                            @foreach($error['errores'] as $mensaje)
                                <li>{{ $mensaje }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>