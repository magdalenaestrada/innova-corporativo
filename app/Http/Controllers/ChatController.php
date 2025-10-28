<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;

class ChatController extends Controller
{
    public function index()
    {
        // Get chats where the current user is either the sender or recipient
        $chats = Chat::where(function ($query) {
            $query->where('user_id', auth()->id())
                ->orWhere('recipient_id', auth()->id());
        })
            ->with(['messages' => function ($query) {
                // Get the messages, ordered by the latest
                $query->orderBy('created_at', 'desc');
            }])
            ->get();

        // Fetch all users except the logged-in user (for starting a new chat)
        $users = User::where('id', '!=', auth()->id())->get();

        return view('chats.index', compact('chats', 'users'));
    }


    public function show(Chat $chat)
    {
        // Check if the current user is part of this chat
        if ($chat->user_id !== auth()->id() && $chat->recipient_id !== auth()->id()) {
            abort(403);
        }

        $messages = $chat->messages()->with('user')->get();

        foreach($messages as $message){
            if($message->user_id != auth()->id()){
                $message->is_read = true;
                $message->save();
            }


        }

        return view('chats.show', compact('chat', 'messages'));
    }

    public function storeMessage(Request $request, Chat $chat)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $chat->messages()->create([
            'user_id' => auth()->id(),
            'body' => $validated['message'],
        ]);

        return redirect()->route('chats.show', $chat);
    }

    public function startChat(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id', // Ensure the recipient exists
        ]);

        // Check if a chat already exists between the two users
        $existingChat = Chat::where(function ($query) use ($validated) {
            $query->where('user_id', auth()->id())
                ->where('recipient_id', $validated['recipient_id']);
        })->orWhere(function ($query) use ($validated) {
            $query->where('user_id', $validated['recipient_id'])
                ->where('recipient_id', auth()->id());
        })->first();
        
           

        if ($existingChat) {
            return redirect()->route('chats.show', $existingChat); // Redirect to the existing chat
        }

        // Create a new chat
        $chat = Chat::create([
            'user_id' => auth()->id(),
            'recipient_id' => $validated['recipient_id'],
        ]);

        return redirect()->route('chats.show', $chat); // Redirect to the newly created chat
    }



 




}
