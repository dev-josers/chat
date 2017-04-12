<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ChatForm;
use App\Models\Chat;
use App\Models\ChatMessage;
use JWTAuth;

/**
 * This controller handles chat management as creation or updates
 */
class ChatController extends Controller
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
     * Create a new chat
     *
     * @return object
     */  
    public function store(ChatForm $request)
    {
        try {
            $user = JWTAuth::toUser();
            
            $chat = Chat::create([
                'name' => $request->get('name'),
                'user_id' => $user->id
            ]);

            $message = ChatMessage::create([
                'message' => $request->get('message'),
                'user_id' => $user->id,
                'chat_id' => $chat->id
            ]);

            $chat->last_chat_message = ChatMessage::getLastChatMessage($chat->id);
            $chat->users = ChatMessage::getListOfUsers($chat->id);
               

            return response()->json(['message' => 'Chat created successfully','data' => $chat], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error was encountered', 'errors'=> $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * List all chats using pagination
     *
     * @return object
     */
    public function listChats(Request $request)
    {
        $result = Chat::chatsPagination($request->input('limit')); 

        return response()->json($result);
    }    

    /**
     * Update a chat
     *
     * @return object
     */
    public function update(ChatForm $request, $id)
    {
        try {
            $user = JWTAuth::toUser();
            $chat = Chat::find($id);
            
            if($user->id != $chat->user_id) {
                throw new \Exception('You are trying to update a chat that is not yours.');
            }

            $chat->name = $request->get('name');            
            $chat->save();

            $chat->last_chat_message = ChatMessage::getLastChatMessage($chat->id);
            $chat->users = ChatMessage::getListOfUsers($chat->id);

            return response()->json(['message' => 'Chat updated successfully','data' => $chat]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error was encountered', 'errors'=> $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}