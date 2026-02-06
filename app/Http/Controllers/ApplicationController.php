<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Buscar todas bolsas (para o modal Add + Edit)
        $scholarships = Scholarship::all();

        // Se for administrador (access_level = 1)
        if (auth()->user()->access_level == 1) {
            // Admin vê todas as candidaturas, com os dados do usuário
            $applications = Application::with('scholarship', 'user')->get();
        } else {
            // Estudante vê apenas as suas
            $applications = Application::with('scholarship')
                            ->where('id_user', auth()->id())
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

        if (strtolower(trim($scholarship->status)) === 'indisponivel') {
            return back()->withErrors([
                'id_scholarship' => 'Bolsa indisponível.'
            ])->withInput();
        }

        // Salvar ficheiros
        $files = [];
        foreach ([
            'bilhete',
            'atestado_pobreza',
            'declaracao_bairro',
            'declaracao_agregado',
            'declaracao_rendimento',
            'aproveitamento'
        ] as $fileField) {

            if ($request->hasFile($fileField)) {
                $files[$fileField . '_path'] =
                    $request->file($fileField)->store('applications', 'public');
            }
        }

        Application::create(array_merge([
            'id_user' => $user->id,
            'id_scholarship' => $request->id_scholarship,
            'application_date' => $request->application_date,

            // CORRIGIDO: Removido espaço não-quebrável em snapshot_year
            'snapshot_course' => optional($user->course)->course_name,
            'snapshot_year'   => $user->level,
            'snapshot_period' => $user->period,

            'status' => 'pending'
        ], $files));

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

        if (strtolower(trim($scholarship->status)) === 'indisponivel') {
            return back()->withErrors([
                'id_scholarship' => 'Bolsa indisponível.'
            ])->withInput();
        }

        $files = [];
        foreach ([
            'bilhete',
            'atestado_pobreza',
            'declaracao_bairro',
            'declaracao_agregado',
            'declaracao_rendimento',
            'aproveitamento'
        ] as $fileField) {

            if ($request->hasFile($fileField)) {
                $files[$fileField . '_path'] =
                    $request->file($fileField)->store('applications', 'public');
            }
        }

        $application->update(array_merge([
            'id_scholarship' => $request->id_scholarship,
            'application_date' => $request->application_date,
        ], $files));

        return back()->with('success', 'Candidatura atualizada com sucesso!');
    }

    /**
     * NOVO MÉTODO: Atualiza apenas o status de uma candidatura (uso do Admin).
     */
    public function changeStatus(Request $request, $id_application)
    {
        // 1. Encontrar a candidatura
        $application = Application::findOrFail($id_application);

        // 2. Checagem de Admin (baseado na sua lógica access_level = 1)
        if (auth()->user()->access_level != 1) {
            return back()->with('error', 'Acesso negado para alterar o status.');
        }

        // 3. Validação do Status
        $request->validate([
            'status' => 'required|in:pending,approved,rejected', // Garante que é um dos 3 valores
        ]);

        // 4. Atualizar o status
        $application->update([
            'status' => $request->status,
        ]);
        
        // Mensagem de sucesso para o Admin
        $user_name = optional($application->user)->name ?? 'Usuário Desconhecido';
        return back()->with('success', "Status da candidatura de **{$user_name}** atualizado para **" . ucfirst($application->status) . "**.");
    }

//Permite que o Admin baixe um documento específico de uma candidatura.
     //
    public function downloadDocument($id_application, $file_field)
    {
        // 1. Verificar se é Admin
        if (auth()->user()->access_level != 1) {
            return back()->with('error', 'Acesso negado. Apenas administradores podem baixar documentos.');
        }

        // 2. Encontrar a candidatura
        $application = Application::findOrFail($id_application);

        // Mapear o campo para o caminho real do arquivo no storage
        $pathField = $file_field . '_path';

        // 3. Verificar se o campo existe no modelo e se tem um caminho
        if (!array_key_exists($pathField, $application->getAttributes()) || !$application->{$pathField}) {
            return back()->with('error', 'Documento não encontrado para esta candidatura.');
        }
        
        $filePath = $application->{$pathField};

        // 4. Verificar se o arquivo existe no disco (storage/app/public)
        if (Storage::disk('public')->exists($filePath)) {
            // Retorna o arquivo para download
            return Storage::disk('public')->download($filePath);
        }

        return back()->with('error', 'O arquivo não foi encontrado no servidor.');
    }


    public function destroy($id_application)
    {
        $application = Application::findOrFail($id_application);
        $application->delete();

        return back()->with('success', 'Candidatura removida com sucesso!');
    }
}