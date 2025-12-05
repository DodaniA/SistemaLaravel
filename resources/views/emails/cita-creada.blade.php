<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .clima-info { display: flex; align-items: center; gap: 10px; }
    </style>
</head>
<body class="bg-background text-foreground antialiased">
    <div class="container mx-auto p-6">
        <div class="content-card">
            <div class="content-card-header">
                <h1 class="text-gradient-orange text-2xl font-bold">Cita Confirmada</h1>
            </div>
            <div class="p-6">
                <h2 class="text-lg font-semibold">¡Hola!</h2>
                <p class="mt-2">Estimado/a {{ $cita->paciente->user->name }},</p>
                <p>Tu cita ha sido creada exitosamente.</p>

                <h3 class="mt-4 font-semibold">Detalles de la cita:</h3>
                <ul class="mt-2 space-y-2">
                    <li><strong>Doctor:</strong> {{ $cita->doctor->user->name }}</li>
                    <li><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }}</li>
                    <li><strong>Motivo:</strong> {{ $cita->motivo }}</li>
                    <li><strong>Estado:</strong> {{ $cita->estado }}</li>
                </ul>

                @if($cita->clima)
                    @php
                        $climaData = json_decode($cita->clima, true);
                    @endphp
                    <div class="clima-info mt-4 flex items-center gap-4">
                        <img src="https://openweathermap.org/img/wn/{{ $climaData['icono'] ?? '' }}@2x.png"
                             alt="clima"
                             width="50"
                             height="50">
                        <div>
                            <strong>Clima en {{ $climaData['ciudad'] ?? '' }}, {{ $climaData['pais'] ?? '' }}:</strong><br>
                            {{ ucfirst($climaData['descripcion'] ?? '') }} - {{ round($climaData['temperatura'] ?? 0) }}°C
                            (Se siente: {{ round($climaData['sensacion'] ?? 0) }}°C)
                        </div>
                    </div>
                @endif
            </div>
            <div class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                <p>Gracias por usar nuestro sistema</p>
            </div>
        </div>
    </div>
</body>
</html>