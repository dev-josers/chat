<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ChatMessageForm;
use App\Models\Chat;
use App\Models\ChatMessage;
use JWTAuth;

/**
 * This controller handles chat message management
 */
class ChatMessagesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Create a new chat message
     *
     * @return object
     */  
    public function store(ChatMessageForm $request, $id)
    {
        try {
            $user = JWTAuth::toUser();
            
            $chat = Chat::find($id);

            $message = ChatMessage::create([
                'message' => $request->get('message'),
                'user_id' => $user->id,
                'chat_id' => $chat->id
            ]);

            $message->user;

            return response()->json(['message' => 'Chat created successfully','data' => $message], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error was encountered', 'errors'=> $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * List all chat messages using pagination
     *
     * @return object
     */
    public function listChatMessages(Request $request, $id)
    {
        $result = ChatMessage::chatMessagesPagination($request->input('limit'), $id); 

        return response()->json($result);
    }

}