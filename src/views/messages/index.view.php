
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

</style>
<div class="container">
  
<h1 class="text-center">Your conversations!</h1>

   <div id="amigos-container" class="row">

<?php foreach($rows as $row): ?>
         <a href="/messages/single/<?=$row['conversation_id']?>" id="c" class="amigo-card card w-100 m-1">
            <div class="car d-flex">
               <img src="money-bill-solid.svg" width="100px" alt="">
               <div class="card-body">
                  <h5 class="card-title"><?=$row['username']?></h5>
                  <p><?=$row['message_data']['id'] == $row['id'] ? $row['username'] : 'You'?>: <?=$row['message_data']['message']?></p>
               </div>
            </div> 
         </a>
<?php endforeach; ?>
   </div>

</div>
<?php $this->view('footer');?>