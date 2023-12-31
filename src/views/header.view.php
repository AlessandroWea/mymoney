<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyMoney</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
    <style>
        body {
            background-color: antiquewhite;
        }
    </style>
</head>
<body>

<?php
use Alewea\Mymoney\models\Message;
$messageModel = new Message();
  $messagesCount = $messageModel->getUnreadMessagesCount($_SESSION['USER']['id']);
?>

<div class="container-fluid">
  <nav class="navbar navbar-expand-lg navbar-light bg-light mb-1">
    <a class="navbar-brand" href="#">Mymoney</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <?php if(Alewea\Mymoney\core\Auth::logged_in()): ?>
            <?php $page_name = $page_name ?? ''?>
            <li class="nav-item <?=$page_name == 'main' ? 'active' : ''?>">
              <a class="nav-link" href="<?=path('main');?>">Home</a>
            </li>
            <li class="nav-item <?=$page_name == 'analytics' ? 'active' : ''?>">
              <a class="nav-link" href="<?=path('analytics');?>">Analytics</a>
            </li>
            <li class="nav-item <?=$page_name == 'wallet' ? 'active' : ''?>">
              <a class="nav-link" href="<?=path('wallet');?>">Wallet</a>
            </li>
            <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Amigos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="<?=path('amigos?type=requests')?>">Your requests</a>
                      <a class="dropdown-item" href="<?=path('amigos?type=requestyou')?>">Requests for you</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="<?=path('amigos')?>">View amigos</a>
                    </div>
                  </li>
            <li class="nav-item <?=$page_name == 'settings' ? 'active' : ''?>">
              <a class="nav-link" href="<?=path('settings');?>">Settings</a>
            </li>
            <li class="nav-item <?=$page_name == 'messages' ? 'active' : ''?>">
              <a class="nav-link" href="<?=path('messages');?>">Messages <span style="color: red;">(<?=$messagesCount?>)</span></a>
            </li>
            <li class="ml-auto float-end">
              <a class="nav-link" href="<?=path('logout');?>">Exit</a>
            </li>
          <?php else: ?>
            <li class="ml-auto float-end <?=$page_name == 'signup' ? 'active' : ''?>">
                <a class="nav-link " href="<?=path('signup');?>">Sign up</a>
            </li>
            <li class="ml-auto float-end <?=$page_name == 'login' ? 'active' : ''?>">
                <a class="nav-link" href="<?=path('login');?>">Login</a>
            </li> 
          <?php endif;?>
      </ul>
    </div>
  </nav>   
</div>
