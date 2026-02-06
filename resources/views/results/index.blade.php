@extends('main')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Application Results</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addResultModal">
            Add Result
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- RESULTS TABLE --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Scholarship</th>
                    <th>Decision</th>
                    <th>Remarks</th>
                    <th>Result Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @forelse($results as $result)
                <tr>
                    <td>{{ $result->application->user->name }}</td>
                    <td>{{ $result->application->scholarship->name }}</td>

                    <td>
                        @if($result->decision === 'approved')
                            <span class="badge bg-success">Approved</span>
                        @elseif($result->decision === 'rejected')
                            <span class="badge bg-danger">Rejected</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>

                    <td>{{ $result->remarks ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($result->result_date)->format('d/m/Y') }}</td>

                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editResultModal{{ $result->result_id }}">
                            Edit
                        </button>

                        <form action="{{ route('results.destroy', $result->result_id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>

                {{-- EDIT MODAL --}}
                <div class="modal fade" id="editResultModal{{ $result->result_id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('results.update', $result->result_id) }}" method="POST">
                                @csrf @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Result</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <label>Decision</label>
                                    <select name="decision" class="form-control mb-2" required>
                                        <option value="approved" {{ $result->decision == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $result->decision == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="pending" {{ $result->decision == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>

                                    <label>Remarks</label>
                                    <textarea name="remarks" class="form-control mb-2">{{ $result->remarks }}</textarea>

                                    <label>Result Date</label>
                                    <input type="date" name="result_date" class="form-control" value="{{ $result->result_date }}" required>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-success">Save changes</button>
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="6" class="text-center">No results found.</td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

{{-- ADD RESULT MODAL --}}
<div class="modal fade" id="addResultModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('results.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add Result</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <label>Application</label>
                    <select name="application_id" class="form-control mb-2" required>
                        <option value="">-- Select Application --</option>
                        @foreach(\App\Models\Application::with('user','scholarship')->get() as $app)
                            <option value="{{ $app->id_application }}">
                                {{ $app->user->name }} — {{ $app->scholarship->name }}
                            </option>
                        @endforeach
                    </select>

                    <label>Decision</label>
                    <select name="decision" class="form-control mb-2" required>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="pending">Pending</option>
                    </select>

                    <label>Remarks</label>
                    <textarea name="remarks" class="form-control mb-2"></textarea>

                    <label>Result Date</label>
                    <input type="date" name="result_date" class="form-control" required>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
