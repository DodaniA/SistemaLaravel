<div class="space-y-6">
    <flux:heading size="lg"><h1 class="text-3xl font-bold text-gradient-orange">Estadísticas de Calificaciones</h1></flux:heading>
    <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
        <flux:heading size="sm" class="mb-4">Distribución de Calificaciones</flux:heading>
        <canvas id="calificacionesChart" class="w-full" style="max-height: 400px;"></canvas>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      
        <div class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Calificaciones</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $totalCalificaciones }}</p>
                </div>
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <svg class="size-6 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-yellow-200 dark:border-yellow-700 bg-yellow-50 dark:bg-yellow-900/20 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-700 dark:text-yellow-400">Promedio</p>
                    <p class="text-3xl font-bold text-yellow-900 dark:text-yellow-100 mt-2">{{ $promedioCalificacion }}</p>
                    <div class="flex gap-0.5 mt-1">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="text-lg {{ $i <= round($promedioCalificacion) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}">★</span>
                        @endfor
                    </div>
                </div>
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <svg class="size-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

   
        <div class="rounded-lg border border-green-200 dark:border-green-700 bg-green-50 dark:bg-green-900/20 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-700 dark:text-green-400">Mejor</p>
                    <p class="text-3xl font-bold text-green-900 dark:text-green-100 mt-2">{{ $mejorCalificacion }}</p>
                    <div class="flex gap-0.5 mt-1">
                        @for($i = 1; $i <= $mejorCalificacion; $i++)
                            <span class="text-lg text-green-400">★</span>
                        @endfor
                    </div>
                </div>
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <svg class="size-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

        
        <div class="rounded-lg border border-red-200 dark:border-red-700 bg-red-50 dark:bg-red-900/20 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-red-700 dark:text-red-400">Peor</p>
                    <p class="text-3xl font-bold text-red-900 dark:text-red-100 mt-2">{{ $peorCalificacion }}</p>
                    <div class="flex gap-0.5 mt-1">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="text-lg {{ $i <= $peorCalificacion ? 'text-red-400' : 'text-gray-300 dark:text-gray-600' }}">★</span>
                        @endfor
                    </div>
                </div>
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                    <svg class="size-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

 <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

@script
<script>
    let chart = null;

    const labels = ['★', '★★', '★★★', '★★★★', '★★★★★'];

    function inicializarGrafico(datos) {
        const ctx = document.getElementById('calificacionesChart');
     
        if (chart) {
            chart.destroy();
        }

        const data = {
            labels: labels,
            datasets: [{
                label: 'Calificaciones',
                data: datos,
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)'
                ]
            }]
        };

        chart = new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    }

    inicializarGrafico(@json($datos));

    $wire.on('actualizarGraficoCalificaciones', (event) => {
        inicializarGrafico(event[0].datos);
    });
</script>
@endscript