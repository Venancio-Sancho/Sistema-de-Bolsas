<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Scholarship;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    public function __construct(private NotificationService $notificationService)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $scholarships = Scholarship::all();

        if (Auth::user()->access_level == 1) {
            $applications = Application::with('scholarship', 'user')->get();
        } else {
            $applications = Application::with('scholarship')
                ->where('id_user', Auth::id())
                ->get();
        }

        return view('applications.index', compact('applications', 'scholarships'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_scholarship' => 'required|exists:scholarships,id',
            'application_date' => 'required|date',
            'bilhete' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'atestado_pobreza' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'declaracao_bairro' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'declaracao_agregado' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'declaracao_rendimento' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'aproveitamento' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $user = Auth::user();
        $scholarship = Scholarship::findOrFail($request->id_scholarship);

        if ($this->isScholarshipUnavailable($scholarship)) {
            return back()->with('error', 'Esta bolsa está indisponível para candidatura.');
        }

        $files = [];

        foreach ([
            'bilhete',
            'atestado_pobreza',
            'declaracao_bairro',
            'declaracao_agregado',
            'declaracao_rendimento',
            'aproveitamento',
        ] as $fileField) {
            if ($request->hasFile($fileField)) {
                $files[$fileField . '_path'] = $request->file($fileField)->store('applications', 'public');
            }
        }

        $application = Application::create(array_merge([
            'id_user' => $user->id,
            'id_scholarship' => $request->id_scholarship,
            'application_date' => $request->application_date,
            'snapshot_course' => optional($user->course)->course_name,
            'snapshot_year' => $user->level,
            'snapshot_period' => $user->period,
            'status' => 'pending',
        ], $files));

        $this->notificationService->notifyAdmins(
            'Nova candidatura recebida',
            "{$user->name} candidatou-se à bolsa \"{$scholarship->name}\" em {$application->application_date}."
        );

        return back()->with('success', 'Candidatura submetida com sucesso!');
    }

    public function update(Request $request, $id_application)
    {
        $request->validate([
            'id_scholarship' => 'required|exists:scholarships,id',
            'application_date' => 'required|date',
        ]);

        $application = Application::findOrFail($id_application);
        $scholarship = Scholarship::findOrFail($request->id_scholarship);

        if ($this->isScholarshipUnavailable($scholarship)) {
            return back()->with('error', 'Esta bolsa está indisponível para candidatura.');
        }

        $files = [];

        foreach ([
            'bilhete',
            'atestado_pobreza',
            'declaracao_bairro',
            'declaracao_agregado',
            'declaracao_rendimento',
            'aproveitamento',
        ] as $fileField) {
            if ($request->hasFile($fileField)) {
                $files[$fileField . '_path'] = $request->file($fileField)->store('applications', 'public');
            }
        }

        $application->update(array_merge([
            'id_scholarship' => $request->id_scholarship,
            'application_date' => $request->application_date,
        ], $files));

        return back()->with('success', 'Candidatura atualizada com sucesso!');
    }

    public function changeStatus(Request $request, $id_application)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->access_level != 1) {
            return back()->with('error', 'Acesso negado.');
        }

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $application = Application::with('scholarship')->findOrFail($id_application);
        $application->update([
            'status' => $request->status,
        ]);

        $scholarshipName = optional($application->scholarship)->name ?? 'bolsa';

        $this->notificationService->create(
            $application->id_user,
            'Resultado da candidatura',
            "A sua candidatura para a bolsa \"{$scholarshipName}\" foi {$this->formatApplicationStatus($request->status)}."
        );

        return back()->with('success', 'Status atualizado com sucesso!');
    }

    public function downloadDocument($id_application, $file_field)
    {
        if (Auth::user()->access_level != 1) {
            return back()->with('error', 'Acesso negado.');
        }

        $application = Application::findOrFail($id_application);
        $pathField = $file_field . '_path';

        if (! $application->{$pathField}) {
            return back()->with('error', 'Documento não encontrado.');
        }

        $filePath = storage_path('app/public/' . $application->{$pathField});

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return back()->with('error', 'Arquivo não encontrado no servidor.');
    }

    public function destroy($id_application)
    {
        $application = Application::findOrFail($id_application);
        $application->delete();

        return back()->with('success', 'Candidatura removida com sucesso!');
    }

    private function formatApplicationStatus(string $status): string
    {
        return match ($status) {
            'approved' => 'aprovada',
            'rejected' => 'rejeitada',
            default => 'pendente',
        };
    }

    private function isScholarshipUnavailable(Scholarship $scholarship): bool
    {
        return Str::lower(Str::ascii(trim((string) $scholarship->status))) === 'indisponivel';
    }
}