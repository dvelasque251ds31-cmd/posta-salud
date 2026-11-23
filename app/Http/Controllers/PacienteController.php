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
        //
    }

    public function store(StorePacienteRequest $request)
    {
        //
    }

    public function show(Paciente $paciente)
    {
        //
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