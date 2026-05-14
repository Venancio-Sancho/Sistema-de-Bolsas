@extends('main')

@section('content')
<div class="container">
    <div class="card shadow-lg">

        <div class="card-header bg-dark text-white">
            <strong>📩 Conversas</strong>
        </div>

        <div class="list-group list-group-flush">

            @foreach($users as $user)
                <a href="{{ route('messages.chat', $user->id) }}" 
                   class="list-group-item list-group-item-action d-flex justify-content-between">

                    <span>👤 {{ $user->name }}</span>
                    <span class="badge bg-primary">Chat</span>

                </a>
            @endforeach

        </div>

    </div>
</div>
@endsection
