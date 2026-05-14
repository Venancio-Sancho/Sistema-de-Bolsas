@extends('main')

@section('content')
<div class="container">
    <h3>Notificações</h3>

    @foreach($notifications as $n)
        <div class="card mb-2 {{ $n->is_read ? '' : 'border-primary' }}">
            <div class="card-body">
                <h5>{{ $n->title }}</h5>
                <p>{{ $n->message }}</p>

                @if(!$n->is_read)
                    <a href="{{ route('notifications.read', $n->id) }}" class="btn btn-sm btn-primary">
                        Marcar como lida
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection