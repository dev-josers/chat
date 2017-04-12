<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';
    protected $fillable = ['name', 'user_id'];
    protected $guarded = ['id'];

    /**
     * Messages that a chat has
     *
     * @return object
     */
    public function messages() 
    {
        return $this->hasMany('App\Models\ChatMessage');
    }

    /**
     * User that a chat belongs
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get all chats with pagination
     *
     * @return object
     */
    public static function chatsPagination($limit)
    {
        $chats = self::paginate($limit); 

        foreach ($chats->items() as &$chat) {
            $chat->last_chat_message = ChatMessage::getLastChatMessage($chat->id);
            $chat->users = ChatMessage::getListOfUsers($chat->id);
        }

        return array(
            'meta' => [
                'pagination' => [
                    'current_page' => (int)$chats->currentPage(),
                    'per_page' => (int)$chats->perPage(),
                    'page_count' => (int)$chats->lastPage(),
                    'total_count' => (int)$chats->total(),
                ]
            ],
            'data' => $chats->items()
        );
    }

}
