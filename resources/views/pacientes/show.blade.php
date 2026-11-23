@extends('layouts.app')

@section('titulo', $paciente->apellidos . ', ' . $paciente->nombres)

@section('contenido')
    <hgroup>
        <h1>{{ $paciente->apellidos }}, {{ $paciente->nombres }}</h1>
        <p>DNI {{ $paciente->dni }} · {{ $paciente->fecha_nacimiento->age }} años</p>
    </hgroup>

    <article>
        <p><strong>Fecha de nacimiento:</strong>
           {{ $paciente->fecha_nacimiento->format('d/m/Y') }}</p>
        <p><strong>Sexo:</strong>
           {{ $paciente->sexo === 'F' ? 'Femenino' : 'Masculino' }}</p>
        <p><strong>Celular:</strong> {{ $paciente->telefono ?? '—' }}</p>
        <p><strong>Dirección:</strong> {{ $paciente->direccion ?? '—' }}</p>
    </article>

    <div class="acciones">
        <a href="{{ route('pacientes.edit', $paciente) }}" role="button">Editar</a>

        <form method="POST" action="{{ route('pacientes.destroy', $paciente) }}"
              onsubmit="return confirm('¿Eliminar este paciente?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="secondary">Eliminar</button>
        </form>

        <a href="{{ route('pacientes.index') }}">← Volver al listado</a>
    </div>

    <h2>Citas ({{ $paciente->citas->count() }})</h2>
    @forelse ($paciente->citas as $cita)
        <p>{{ $cita->fecha_hora->format('d/m/Y H:i') }} ·
           {{ $cita->personalMedico->apellidos }}
           ({{ $cita->personalMedico->especialidad }}) — {{ $cita->estado }}</p>
    @empty
        <p>Sin citas registradas.</p>
    @endforelse

    <h2>Atenciones ({{ $paciente->atenciones->count() }})</h2>
    @forelse ($paciente->atenciones as $atencion)
        <article>
            <header>
                {{ $atencion->cita->fecha_hora->format('d/m/Y H:i') }} ·
                {{ $atencion->cita->personalMedico->apellidos }}
            </header>
            <p><strong>Diagnóstico:</strong> {{ $atencion->diagnostico }}</p>
            <p><strong>Tratamiento:</strong> {{ $atencion->tratamiento }}</p>
            @if ($atencion->observaciones)
                <p><strong>Observaciones:</strong> {{ $atencion->observaciones }}</p>
            @endif
        </article>
    @empty
        <p>Sin atenciones registradas.</p>
    @endforelse
@endsection