<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'chat_messages';
    protected $fillable = ['message', 'chat_id', 'user_id'];
    protected $guarded = ['id'];

    public function chat() 
    {
        return $this->belongsTo('App\Models\Chat');
    }

    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    public static function getLastChatMessage($chatId)
    {
    	return self::with('user')->where('chat_id', $chatId)->orderBy('created_at', 'DESC')->first();
    }

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
}
