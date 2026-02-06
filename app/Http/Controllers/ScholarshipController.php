<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scholarship;

class ScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::all();
        return view('scholarships.index', compact('scholarships'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Completa,Parcial',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Disponível,Indisponível',
        ]);

        Scholarship::create($request->all());

        return redirect()->back()->with('success', 'Bolsa criada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:Completa,Parcial',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Disponível,Indisponível',
        ]);

        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update($request->all());

        return redirect()->back()->with('success', 'Bolsa atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->delete();

        return redirect()->back()->with('success', 'Bolsa apagada com sucesso!');
    }
}
