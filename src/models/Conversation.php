<?php

namespace Alewea\Mymoney\models;

use Alewea\Mymoney\core\Model;
use Alewea\Mymoney\models\User;

class Conversation extends Model
{
    static protected string $tableName = 'conversation';
    static public array $enabledCols = ['id_user1', 'id_user2'];
    
    public function getConversationCardData($id)
    {
        $user = new User;

        //get all the conversations of the current user
        // [ [1,2,1] [2,2,3]] - [id, id_user1, id_user2]
        $convers = $this->whereOr([
            'id_user1' => $id,
            'id_user2' => $id,
        ]);
        $cur_user = $_SESSION['USER'];
        
        //change id of a partner to actual data
        foreach($convers as &$conver)
        {
            if($conver['id_user1'] != $cur_user['id'])
            {
                $conver['partner'] = $user->first(['id' => $conver['id_user1']]);
            }
            else
            {
                 $conver['partner'] = $user->first(['id' => $conver['id_user2']]);
            }
        }

        foreach ($convers as &$conver) {
            $conver['message_data'] = $this->getLastMessageData($conver['id']);
            $conver['message_data']['unread_count'] = $this->getUnreadMessagesCount($conver['id']);
        }

        return $convers;
    }

    public function getLastMessageData(int $conversation_id)
    {
        $sql = 'SELECT id_user, message FROM messages WHERE id_conversation = :conv_id order by date DESC LIMIT 1';
        $ret = $this->query($sql, ['conv_id' => $conversation_id]);
        return $ret->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUnreadMessagesCount(int $conversation_id)
    {
        $current_user_id = $_SESSION['USER']['id'];
        $sql = 'SELECT count(*) FROM messages WHERE id_conversation = :conv_id AND id_user != :current_user_id AND is_read = 0';
        $ret = $this->query($sql, ['conv_id' => $conversation_id, 'current_user_id' => $current_user_id]);
        return $ret->fetchColumn();
    }
}