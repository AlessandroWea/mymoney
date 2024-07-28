
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

<?php foreach($rows as $row): $partner = $row['partner'] ?>
         <a href="/messages/single/<?=$row['id']?>" id="c" class="amigo-card card w-100 m-1">
            <div class="car d-flex">
               <img src="money-bill-solid.svg" width="100px" alt="">
               <div class="card-body">
                  <h5 class="card-title"><?=$partner['username']?> <span id="count-<?=$row['id']?>">(<?=$row['message_data']['unread_count']?>)</span></h5>
                  <p id="message-<?=$row['id']?>"><?=$row['message_data']['id_user'] == $partner['id'] ? $partner['username'] : 'You'?>: <?=$row['message_data']['message']?></p>
               </div>
            </div> 
         </a>
<?php endforeach; ?>
   </div>

</div>

<?php $this->view('footer');?>

<script>
   window.onload = () => {
      let list = document.querySelector('.list');
      setInterval(function(){
         let data = JSON.stringify({'page' : '<?=$page_name?>'});

         request('POST', '/messages/check', data,
            function(xhr, data){ 
                     console.log(data) 
                     if(data.type == 'new')
                     {
                        let messages = data.data;
                        for(let i = 0; i < messages.length; i++)
                        {
                           let messageHolder = document.querySelector('#message-' + messages[i]["id"]);
                           messageHolder.textContent = messages[i]["message"];
                        }
                     }
            }); 
      }, 1000)
   }
</script>