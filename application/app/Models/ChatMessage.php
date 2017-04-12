<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'chat_messages';
    protected $fillable = ['message', 'chat_id', 'user_id'];
    protected $guarded = ['id'];

    /**
     * Chat that a chat message belongs
     *
     * @return object
     */
    public function chat() 
    {
        return $this->belongsTo('App\Models\Chat');
    }

    /**
     * User that a chat message belongs
     *
     * @return object
     */
    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the last message of a chat filtered by chat
     *
     * @return object
     */
    public static function getLastChatMessage($chatId)
    {
    	return self::with('user')->where('chat_id', $chatId)->orderBy('created_at', 'DESC')->first();
    }

    /**
     * Get all list users who has messages filtered by chat
     *
     * @return object
     */
    public static function getListOfUsers($chatId)
    {
		$messages = self::with('user')->where('chat_id', $chatId)->get();
        $users = array();
        foreach ($messages as $messages) {
        	if(!in_array($messages->user, $users, true)){      
	            array_push($users, $messages->user);
	        }
        }

        return $users;
    }

    /**
     * Get all chat messages with pagination
     *
     * @return object
     */
    public static function chatMessagesPagination($limit, $chatId)
    {
        $chatMessages = self::with('user')->where('chat_id', $chatId)->orderBy('created_at', 'DESC')->paginate($limit);

        return array(
            'meta' => [
                'pagination' => [
                    'current_page' => (int)$chatMessages->currentPage(),
                    'per_page' => (int)$chatMessages->perPage(),
                    'page_count' => (int)$chatMessages->lastPage(),
                    'total_count' => (int)$chatMessages->total(),
                ]
            ],
            'data' => $chatMessages->items()
        );
    }

}
