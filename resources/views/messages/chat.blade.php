@extends('main')

@section('content')
<div class="container">
    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <strong>Chat com {{ $receiver->name }}</strong>
        </div>

        @if(session('success'))
            <div class="alert alert-success m-3 mb-0">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger m-3 mb-0">
                {{ session('error') }}
            </div>
        @endif

        <div id="chat-box" style="height:400px; overflow-y:auto; padding:15px; background:#f5f7fb;">
            @foreach($messages as $msg)
                <div class="mb-3 d-flex {{ $msg->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="p-3 rounded-4 shadow-sm {{ $msg->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-white' }}"
                        style="max-width:70%; position:relative;">

                        <small>
                            <strong>{{ $msg->sender->name }}</strong>
                        </small>

                        <p class="mb-1">{{ $msg->message }}</p>

                        <small class="text-muted">
                            {{ $msg->created_at->diffForHumans() }}
                        </small>

                        @if($msg->sender_id == auth()->id())
                            <div class="mt-2 text-end">
                                <form action="{{ route('messages.delete', $msg->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0">Apagar</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card-footer">
            <form method="POST" action="{{ route('messages.send') }}" class="d-flex gap-2">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                <input type="text" name="message" class="form-control rounded-3" placeholder="Digite a mensagem..." required>
                <button class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
</div>
@endsection
