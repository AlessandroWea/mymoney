<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\models\User;
use Alewea\Mymoney\models\Amigos as AmigosModel;

class Amigos extends Controller
{
    public function index()
    {
        $page_name = 'amigos';
        $type = $_GET['type'] ?? 'index';
        $users = new User();
        $rows = [];
        $view_file = 'index';

        if($type == 'index')
        {
            $rows = $users->getAmigos();
            //get amigos
        }
        else if($type == 'requests')
        {
            $view_file = 'requests';
            $rows = $users->getRequestsAmigos();
            //get requests for amigos
        }
        else if($type == 'requestyou')
        {
            $view_file = 'requestyou';
            $rows = $users->getRequestYouAmigos();
        }

        $this->view('amigos/' . $view_file, compact('page_name','rows'));
    }

    public function remove()
    {
        $i = file_get_contents('php://input');
        $a = json_decode($i);
        $userid = $a->userid;

        $amigos = new AmigosModel();

        // if current user was first to request amigo
        $ret = $amigos->deleteWhere([
            'user1_id' => $_SESSION['USER']['id'],
            'user2_id' => $userid,
        ]);

        // if another user was first to request current user as amigo
        if(!$ret)
        {
            $ret = $amigos->deleteWhere([
                'user1_id' => $userid,
                'user2_id' => $_SESSION['USER']['id'],
            ]);
        }

        echo json_encode([
            'type' => 'amigo_ok',
            'data' => $ret,
        ]);
    }

    public function accept()
    {
        $i = file_get_contents('php://input');
        $a = json_decode($i);
        $userid = $a->userid;

        $amigos = new AmigosModel();

        $ret = $amigos->updateWhere([
            'user1_id' => $userid,
            'user2_id' => $_SESSION['USER']['id'],
        ], [
            'accepted' => 1,
            'date_accept' => date('Y-m-d H:i:s'),
        ]);

        echo json_encode([
            'type' => 'amigo_ok',
            'data' => $ret,
        ]);
    }

    public function request()
    {
        $i = file_get_contents('php://input');
        $a = json_decode($i);

        $userid = $a->userid;

        $response = [
            'type' => 'amigo_ok'
        ];

        $user = new User();
        $amigos = new AmigosModel();
        // if id = current user's id => ignore
        if($userid != $_SESSION['USER']['id'] && $user->first(['id'=>$userid]))
        {
            // check if request was alreay by current user
            $row = $amigos->first([
                'user1_id' => $_SESSION['USER']['id'],
                'user2_id' => $userid
            ]);

            if(!$row){
                // if not, check if secont user sent request
                $row = $amigos->first([
                    'user1_id' => $userid,
                    'user2_id' => $_SESSION['USER']['id']
                ]);

                // if not, continue making request
                if(!$row)
                {
                    $response['data'] = ['id' => $userid];
                    $amigos->add([
                        'user1_id' => $_SESSION['USER']['id'],
                        'user2_id' => $userid,
                        'accepted' => 0
                    ]);                  
                }
                else
                {
                    if($row['accepted'] == 1)
                    {
                        $response['type'] = 'amigo_accepted';
                        $response['data'] = ['id' => $row['user1_id']]; 
                    }
                    else
                    {
                        $response['type'] = 'amigo_requested_you';
                        $response['data'] = ['id' => $row['user1_id']];                        
                    }
     
                }

            }
            else   // if request already was made
            {
                if($row['accepted'] == 1)
                {
                    $response['type'] = 'amigo_accepted';
                    $response['data'] = ['id' => $row['user2_id']]; 
                }
                else
                {
                    $response['type'] = 'amigo_requested';
                    $response['data'] = ['id' => $row['user2_id']]; 
                }

            }

        }
        else
        {
            $response['type'] = 'amigo_notfound';
            $response['data'] = ['id' => 0];
        }

        echo json_encode($response);
    }
}