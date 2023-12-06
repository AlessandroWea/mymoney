<?php

namespace Alewea\Mymoney\models;

use Alewea\Mymoney\core\Model;

class Conversation extends Model
{
    static protected string $tableName = 'conversation';
    static public array $enabledCols = ['id_user1, id_user2'];
    public function getConversationCardData($id)
    {
        $sql = 'SELECT users.id, users.username, conversation.id as conversation_id
                FROM users
                JOIN conversation
                    ON users.id = IF(conversation.id_user1 = :cur_id, conversation.id_user2, conversation.id_user1)
                WHERE conversation.id_user1 = :cur_id
                    OR conversation.id_user2 = :cur_id';

        $ret = $this->query($sql, ['cur_id' => $id]);

        $rows = $ret->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($rows as &$row) {
            $row['message_data'] = $this->getLastMessageData($row['conversation_id']);
        }

        return $rows;
    }

    public function getLastMessageData(int $conversation_id)
    {
        $sql = 'SELECT id_user, message FROM messages WHERE id_conversation = :conv_id order by date LIMIT 1';
        $ret = $this->query($sql, ['conv_id' => $conversation_id]);
        return $ret->fetch(\PDO::FETCH_ASSOC);
    }
}