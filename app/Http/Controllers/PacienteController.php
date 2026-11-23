<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $buscar = trim($request->input('buscar', ''));

        $pacientes = Paciente::query()
            ->when($buscar, function ($consulta, $buscar) {
                $consulta->where('dni', 'like', "$buscar%")
                         ->orWhere('apellidos', 'ilike', "%$buscar%");
            })
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->paginate(10)
            ->withQueryString();

        return view('pacientes.index', compact('pacientes', 'buscar'));
    }

    public function create()
    {
        return view('pacientes.create', ['paciente' => new Paciente()]);
    }

    public function store(StorePacienteRequest $request)
    {
        Paciente::create($request->validated());

        return redirect()->route('pacientes.index')
            ->with('ok', 'Paciente registrado correctamente.');
    }

    public function show(Paciente $paciente)
    {
        $paciente->load([
            'citas'      => fn ($q) => $q->with('personalMedico')
                                         ->orderByDesc('fecha_hora'),
            'atenciones' => fn ($q) => $q->with('cita.personalMedico')
                                         ->orderByDesc('atenciones.created_at'),
        ]);

        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        //
    }

    public function update(UpdatePacienteRequest $request, Paciente $paciente)
    {
        //
    }

    public function destroy(Paciente $paciente)
    {
        //
    }
}