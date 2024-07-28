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
        dd($conversationUsers);
        $this->view('messages/index', [
            'rows' => $conversationUsers,
            'page_name' => 'messages'
        ]); 
    }

    public function actionCheck()
    {
        $i = file_get_contents('php://input');
        $a = json_decode($i);

        $page = $a->page;

        $userModel = new User();
        
        $conversationModel = new Conversation();
        $messageModel = new Message();

        if($page == 'messages')
        {
            $messages = $messageModel->getUnreadMessages($_SESSION['USER']['id']);

            if(!empty($messages))
            {
                 $this->json([
                    'type' => 'new',
                    'data' => $messages,
                ]);               
            }
            else
            {
                $this->json([
                    'type' => 'none',
                ]);
            }

        }
        else if($page == 'single')
        {
            $userid = $a->userid;
            $converid = $a->converid;
            $user = $userModel->first(['id'=>$userid]);

            $unreadMessage = $messageModel->first([
                        'id_conversation' => $converid,
                        'is_read' => 0
            ]);

            if($unreadMessage)
            {
               $messageModel->updateWhere([
                    'id' => $unreadMessage['id']
                ],
                [
                    'is_read' => 1
                ]);  


                $this->json([
                    'type' => 'new',
                    'data' => [
                        'message' => $unreadMessage['message'],
                        'date' => $unreadMessage['date'],
                        'username' => $user['username'],
                        'id_user' => $user['id']
                    ],
                ]);       
            } else
            {
                $this->json([
                    'type' => 'none',
                    'data' => []
                ]); 
            }
        }
        else // all other pages
        {
            $count = $messageModel->getUnreadMessagesCount($_SESSION['USER']['id']);

            $this->json([
                'count' => $count
            ]);
        }

        
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
        $page_name = 'single';
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
            'id' => $id,
            'page_name' => $page_name   
        ]);
    }
}