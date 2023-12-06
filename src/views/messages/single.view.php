
<?php $this->view('header', compact('page_name'));?>
<style>
   a {
      color:  black;
      outline: none;
   }

   a:hover {
      outline: none;
      text-decoration: none;
      color: black;
   }

   #c:hover {
      background-color: lightblue;
   }

   .list {
      font-size: 1.2rem;
   }

</style>
<div class="container">
  
<h1 class="text-center">Your conversation with <?=$user['username']?>!</h1>

<div id="messages-container" class="">
   <div class="list">
      <?php if(!empty($messages)): ?>
         <?php foreach ($messages as $message):?>
            <div class="d-flex align-items-center">
               <span class="mr-3"><?=$message['date'] ?? '2023-20-22 22:22'?></span>
               <span class="text-primary mr-2"><?=$message['id_user'] == $user['id'] ? $user['username'] : 'You'?> :</span>
               <span class=""><?=$message['message']?></span>
            </div>
         <?php endforeach; ?>

      <?php else: ?>
         <h2>Start writing right now!</h2>
      <?php endif;?>
   </div>

   <div class="action">
      <form method="post" action="#">
         <textarea name="message" class="mt-5" style="width: 100%;" id="" rows="5"></textarea>
         <button type="submit">Message!</button>        
      </form>

   </div>

</div>
<?php $this->view('footer');?>
<!-- 
CREATE TABLE conversation (
   id int primary key auto_increment NOT NULL,
   id_user1 int NOT NULL ,
   id_user2 int NOT NULL
);
drop table messages;
CREATE TABLE messages (
   id int primary key auto_increment NOT NULL,
   id_user int NOT NULL,
   id_conversation int NOT NULL,
   message text NOT NULL,
   is_read int NOT NULL,
   date datetime NULL

); -->

