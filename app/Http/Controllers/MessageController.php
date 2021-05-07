<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Events\MessageSentEvent;

class MessageController extends Controller
{
    public function index()
    {
        $message = Message::with('user')->get();

        return $message;
    }

    public function store(Request $request)
    {

        $user = auth()->user();

        /*
        $message = $user->messages()->create([
            'message' => $request->input('message')
        ]);
        */

        $message = new Message;

        $message->forceFill([
            'user_id' => $user->id,
            'message' => $request->get('message'),
        ]);

        $message->save();

        // enviar mensaje al resto
        broadcast(new MessageSentEvent($message, $user))->toOthers();

        return [
            'message' => $message,
            'user' => $user,
        ];
    }
}
