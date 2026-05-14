<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Application;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $total = Application::count();
        $approved = Application::where('status', 'approved')->count();
        $rejected = Application::where('status', 'rejected')->count();
        $pending = Application::where('status', 'pending')->count();

        return view('reports.index', compact(
            'total',
            'approved',
            'rejected',
            'pending'
        ));
    }

    public function filter(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $applications = Application::whereBetween('created_at', [$start, $end])->get();

        return view('reports.filter', compact('applications'));
    }



public function exportPDF()
{
    $applications = Application::all();

    $total = Application::count();
    $approved = Application::where('status', 'approved')->count();
    $rejected = Application::where('status', 'rejected')->count();
    $pending = Application::where('status', 'pending')->count();

    $pdf = Pdf::loadView('reports.pdf', compact(
        'applications',
        'total',
        'approved',
        'rejected',
        'pending'
    ));

    return $pdf->download('relatorio_bolsas.pdf');
}

}