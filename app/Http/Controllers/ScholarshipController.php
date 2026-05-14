<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function __construct(private NotificationService $notificationService)
    {
    }

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

        $scholarship = Scholarship::create($request->all());

        if ($scholarship->status === 'Disponível') {
            $this->notificationService->notifyStudents(
                'Nova bolsa disponível',
                "A bolsa \"{$scholarship->name}\" está disponível para candidatura até {$scholarship->end_date->format('d/m/Y')}."
            );
        }

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
        $wasAvailable = $scholarship->status === 'Disponível';

        $scholarship->update($request->all());

        if ($scholarship->status === 'Disponível' && ! $wasAvailable) {
            $this->notificationService->notifyStudents(
                'Bolsa disponível novamente',
                "A bolsa \"{$scholarship->name}\" está agora disponível para candidatura até {$scholarship->end_date->format('d/m/Y')}."
            );
        }

        return redirect()->back()->with('success', 'Bolsa atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->delete();

        return redirect()->back()->with('success', 'Bolsa apagada com sucesso!');
    }
}
