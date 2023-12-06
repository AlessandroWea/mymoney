<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\models\Conversation;
use Alewea\Mymoney\models\User;
use Alewea\Mymoney\models\Message;

class Messages extends Controller
{
    public function index()
    {
        $conversation = new Conversation();
        $conversationUsers = $conversation->getConversationCardData($_SESSION['USER']['id']);
        $this->view('messages/index', [
            'rows' => $conversationUsers,
        ]);
    }

    public function single($id = null)
    {
        //get with whom messaging
        $conversationModel = new Conversation();
        $userModel = new User();
        $messageModel = new Message();

        if($this->isPost())
        {
            $message = $_POST['message'];

            $arr = [
                'id_user' => $_SESSION['USER']['id'],
                'id_conversation' => $id,
                'message' => $message,
                'is_read' => 0,
                'date' => date('Y-m-d H:i:s'),
            ];
            $messageModel->add($arr);

            $this->redirect('messages/single/' . $id);
        }

        $convers = $conversationModel->first(['id'=>$id]);
        if($convers['id_user1'] == $_SESSION['USER']['id'])
        {
            $user = $userModel->first(['id'=>$convers['id_user2']]);
        }
        else
        {
            $user = $userModel->first(['id'=>$convers['id_user1']]);
        }

        //get messages
        $messages = $messageModel->where([
            'id_conversation' => $id,
        ]);
        
        $this->view('messages/single', [
            'messages' => $messages,
            'user' => $user,
        ]);
    }
}