<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlunoController extends Controller
{
    public function index()
    {
        return Inertia::render('Tenant/Alunos/Index', [
            'alunos' => Aluno::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email',
        ]);

        Aluno::create($request->all());

        return redirect()->back();
    }
}