<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receta Médica</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            padding: 40px;
            font-size: 12px;
            line-height: 1.6;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        .header h1 { 
            color: #1e40af; 
            font-size: 24px;
            margin-bottom: 10px;
        }
        .doctor-info {
            margin: 10px 0;
            color: #4b5563;
        }
        .section { 
            margin-bottom: 25px; 
        }
        .section-title {
            background-color: #eff6ff;
            padding: 8px 12px;
            border-left: 4px solid #2563eb;
            font-weight: bold;
            font-size: 14px;
            color: #1e40af;
            margin-bottom: 12px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 5px 10px 5px 0;
            color: #374151;
            width: 30%;
        }
        .info-value {
            display: table-cell;
            padding: 5px 0;
            color: #1f2937;
        }
        .medicamento {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .medicamento-header {
            font-weight: bold;
            font-size: 14px;
            color: #059669;
            margin-bottom: 10px;
            border-bottom: 1px solid #d1fae5;
            padding-bottom: 5px;
        }
        .medicamento-details {
            margin: 8px 0;
            padding-left: 15px;
        }
        .indicaciones {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
        }
        .firma {
            margin-top: 60px;
            text-align: center;
        }
        .firma-linea {
            border-top: 2px solid #000;
            width: 300px;
            margin: 0 auto 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>RECETA MÉDICA</h1>
        <div class="doctor-info">
            <strong>{{ $receta->doctor->user?->name ?? 'N/A' }}</strong><br>
            {{ $receta->doctor->especialidad?->nombre ?? 'Sin especialidad' }}<br>
            @if($receta->doctor->cedula_profesional)
                Cédula Profesional: {{ $receta->doctor->cedula_profesional }}
            @endif
        </div>
    </div>

    <!-- Información del Paciente -->
    <div class="section">
        <div class="section-title">DATOS DEL PACIENTE</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Paciente:</div>
                <div class="info-value">{{ $receta->paciente->user?->name ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Fecha de emisión:</div>
                <div class="info-value">{{ $receta->created_at->format('d/m/Y H:i') }}</div>
            </div>
            @if($receta->cita)
                <div class="info-row">
                    <div class="info-label">Fecha de consulta:</div>
                    <div class="info-value">{{ \Carbon\Carbon::parse($receta->cita->fecha_hora)->format('d/m/Y') }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Indicaciones -->
    @if($receta->indicaciones)
        <div class="indicaciones">
            <strong>INDICACIONES GENERALES:</strong><br>
            {{ $receta->indicaciones }}
        </div>
    @endif

    <!-- Medicamentos -->
    <div class="section">
        <div class="section-title">MEDICAMENTOS RECETADOS</div>
        @foreach($receta->medicamentos as $index => $rm)
            <div class="medicamento">
                <div class="medicamento-header">
                    {{ $index + 1 }}. {{ $rm->medicamento->nombre_generico }} - {{ $rm->medicamento->concentracion }}
                </div>
                <div class="medicamento-details">
                    <strong>Dosis:</strong> {{ $rm->dosis }}<br>
                    <strong>Frecuencia:</strong> {{ $rm->frecuencia }}<br>
                    <strong>Duración:</strong> {{ $rm->duracion }}<br>
                    <strong>Vía de administración:</strong> {{ $rm->medicamento->via?->nombre ?? 'N/A' }}<br>
                    @if($rm->instrucciones)
                        <strong>Instrucciones especiales:</strong> {{ $rm->instrucciones }}<br>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Firma -->
    <div class="firma">
        <div class="firma-linea"></div>
        <strong>{{ $receta->doctor->user?->name ?? 'N/A' }}</strong><br>
        {{ $receta->doctor->especialidad?->nombre ?? 'Sin especialidad' }}
        @if($receta->doctor->cedula_profesional)
            <br>Cédula: {{ $receta->doctor->cedula_profesional }}
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        Este documento es una receta médica válida. Conservar en lugar seguro.
    </div>
</body>
</html>