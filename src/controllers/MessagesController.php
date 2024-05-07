<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\models\Conversation;
use Alewea\Mymoney\models\User;
use Alewea\Mymoney\models\Message;

class MessagesController extends Controller
{
    public function actionIndex()
    {
        $conversation = new Conversation();
        $conversationUsers = $conversation->getConversationCardData($_SESSION['USER']['id']);
        $this->view('messages/index', [
            'rows' => $conversationUsers,
        ]); 
    }

    public function actionRedirect($id = null)
    {
        $conversationModel = new Conversation();
        $userModel = new User();
        $messageModel = new Message();

        $current_user_id = $_SESSION['USER']['id'];
        $conver_id = $conversationModel->getId($current_user_id, $id);
        if(!$conver_id)
        {
            if($userModel->first(['id'=>$id]))
            {
                $conver_id = $conversationModel->add(['id_user1'=> $_SESSION['USER']['id'], 'id_user2' => $id]);
            }
        }

        $this->redirect('messages/single/' . $conver_id);
    }

    public function actionSingle($id = null)
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

        // if not found try to ccreate a new conversation
        if(!$convers)
        {
            // check if the user by this ID exists
            if($userModel->first(['id'=>$id]))
            {
                $conversId = $conversationModel->add(['id_user1'=> $_SESSION['USER']['id'], 'id_user2' => $id]);
                $convers = $conversationModel->first(['id'=>$conversId]);
            }
        }

        if($convers['id_user1'] == $_SESSION['USER']['id'])
        {
            $partner_id = $convers['id_user2'];
            $user = $userModel->first(['id'=>$convers['id_user2']]);
        }
        else
        {
            $partner_id = $convers['id_user1'];
            $user = $userModel->first(['id'=>$convers['id_user1']]);
        }

        //get messages
        $messages = $messageModel->where([
            'id_conversation' => $id,
        ]);
        
        // if there are new messages, change their property 'is_read' to 1 (so, it is read)
        $messageModel->updateWhere([
            'id_conversation' => $id,
            'id_user' => $partner_id,
        ], [
            'is_read' => 1,
        ]);

        $this->view('messages/single', [
            'messages' => $messages,
            'user' => $user,
        ]);
    }
}