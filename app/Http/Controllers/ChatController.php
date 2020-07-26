<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use App\Events\NewMessage;
use App\Jobs\SendEmailJob;

class ChatController extends Controller
{
    public function getUsersList()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        $unreadMessages = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where([['to', auth()->id()], ['is_read', false]])
            ->groupBy('from')
            ->get();

        $users = $users->map(function($user) use ($unreadMessages) {
            $userUnread = $unreadMessages->where('sender_id', $user->id)->first();

            $user->unread = $userUnread ? $userUnread->messages_count : 0;

            return $user;
        });


        return response()->json($users);
    }

    public function getChat($id)
    {
        Message::where('from', $id)->where('to', auth()->id())->update(['is_read' => true]);

        $messages = Message::where(function($query) use ($id) {
            $query->where([['from', auth()->id()], ['to', $id]]);
        })->orWhere(function($query) use ($id) {
            $query->where([['from', $id], ['to', auth()->id()]]);
        })->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'from' => auth()->id(),
            'to' => $request->user_id,
            'text' => $request->text
        ]);

        broadcast(new NewMessage($message));

        return response()->json($message);
    }

     public function sendEmail(Request $request)
    {
    	$data = [];
    	$user = User::find($request['to']);
        $data['email'] = $user['email'];
        $data['message'] = $request['text'];

        dispatch(new SendEmailJob($data));

        return response()->json(['success' => true]);
    }
}
