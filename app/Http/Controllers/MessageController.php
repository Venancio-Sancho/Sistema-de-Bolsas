<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $users = User::where('role', 'student')->get();
        } else {
            $users = User::where('role', 'admin')->get();
        }

        return view('messages.index', compact('users'));
    }

    public function show($userId)
    {
        $currentUser = Auth::user();
        $otherUser = User::findOrFail($userId);

        if (! $this->canChatWith($currentUser, $otherUser)) {
            abort(403);
        }

        $messages = Message::with(['sender', 'receiver'])
            ->where(function ($query) use ($userId) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('sender_id', $userId)
                    ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at')
            ->get();

        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->update(['is_read' => true]);

        return view('messages.chat', [
            'messages' => $messages,
            'receiver' => $otherUser,
            'user' => $otherUser,
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $sender = Auth::user();
        $receiver = User::findOrFail($request->receiver_id);

        if (! $this->canChatWith($sender, $receiver)) {
            return back()->with('error', 'So podes conversar com o utilizador permitido.');
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return redirect()
            ->route('messages.chat', $receiver->id)
            ->with('success', 'Mensagem enviada com sucesso.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = Message::findOrFail($id);

        if ($message->sender_id != Auth::id()) {
            return back()->with('error', 'Nao tens permissao para editar esta mensagem.');
        }

        if (now()->diffInMinutes($message->created_at) > 2) {
            return back()->with('error', 'Tempo de edicao expirado.');
        }

        $message->update([
            'message' => $request->message,
        ]);

        return back()->with('success', 'Mensagem editada com sucesso.');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id != Auth::id()) {
            return back()->with('error', 'Nao tens permissao para apagar esta mensagem.');
        }

        $message->delete();

        return back()->with('success', 'Mensagem apagada com sucesso.');
    }

    private function canChatWith(User $currentUser, User $otherUser): bool
    {
        if ($currentUser->role === 'student') {
            return $otherUser->role === 'admin';
        }

        if ($currentUser->role === 'admin') {
            return $otherUser->role === 'student';
        }

        return false;
    }
 }