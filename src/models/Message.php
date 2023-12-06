<?php

namespace Alewea\Mymoney\models;

use Alewea\Mymoney\core\Model;

class Message extends Model
{
    static protected string $tableName = 'messages';
    static public array $enabledCols = ['message', 'id_user', 'id_conversation' ,'is_read', 'date'];


    public function getUnreadMessagesCount(int $user_id)
    {
        dd($user_id);
        $sql = 'SELECT count(*) 
                FROM messages
                JOIN conversation
                    ON messages.id_conversation = conversation.id
                WHERE (conversation.id_user1 = :cur_id
                    OR conversation.id_user2 = :cur_id)
                    and messages.id_user != :cur_id
                    and messages.is_read = 0
                ';

        $ret = $this->query($sql, ['cur_id' => $user_id]);

        $rows = $ret->fetchColumn();

        return $rows;
    }
}