<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Application;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $results = Result::with('application.user')->get();
        return view('results.index', compact('results'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:applications,id_application',
            'decision' => 'required|in:approved,rejected,pending',
            'remarks' => 'nullable|string',
            'result_date' => 'required|date',
        ]);

        Result::create($request->all());

        return back()->with('success', 'Result created successfully.');
    }

    public function update(Request $request, $result_id)
    {
        $request->validate([
            'decision' => 'required|in:approved,rejected,pending',
            'remarks' => 'nullable|string',
            'result_date' => 'required|date',
        ]);

        $result = Result::findOrFail($result_id);
        $result->update($request->all());

        return back()->with('success', 'Result updated successfully.');
    }

    public function destroy($result_id)
    {
        $result = Result::findOrFail($result_id);
        $result->delete();

        return back()->with('success', 'Result deleted successfully.');
    }
}
