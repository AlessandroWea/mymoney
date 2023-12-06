<?php $this->view('header', compact('page_name'));?>

<style>
   a {
      color:  inherit;
      outline: none;
   }

   a:hover {
      outline: none;
      text-decoration: none;
      color: inherit;
   }

   #c:hover {
      background-color: lightblue;
   }
</style>

<div class="container">

<h1 class="text-center">Amigos (<?=count($rows)?>)</h1>
<div class="text-center mb-1">
   <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">+</button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request for amicizia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="">
           <input id="userid" type="text" value="12345" placeholder="Enter user's id">
           <p id="modal-message" class="text-danger">Message</p>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btnRequest" class="btn btn-primary">Request</button>
      </div>
    </div>
  </div>
</div>

<div id="amigos-container" class="row">

   <?php foreach($rows as $row): ?>
      <a href="#" id="c" class="amigo-card card w-100 m-1">
         <div class="car d-flex">
            <img src="money-bill-solid.svg" width="100px" alt="">
            <div class="card-body">
               <h5 class="card-title"><?=$row['username']?></h5>
               <div class="btns">
                  <button class="btn btn-sm btn-primary">Message</button>
                  <button data-type="remove" data-id="<?=$row['id']?>" class="btn btn-sm btn-danger">Remove</button>
               </div>
            </div>
         </div> 
      </a>
   <?php endforeach;?>

</div>

</div>
<?php $this->view('footer');?>

<script>
   
window.onload = () => {
   let amigosContainer = document.querySelector('#amigos-container');
   amigosContainer.addEventListener('click', (event) => {
      if(event.target.dataset.type == 'remove'){
         let userid = event.target.dataset.id;
         let data = JSON.stringify({'userid' : userid});

         if(confirm('Are you sure'))
         {
             request('POST', '/amigos/remove', data,
               function(){ 
                  if (this.status != 200) { 
                         alert(`Ошибка ${this.status}: ${this.statusText}`);
                     } else { 
                        let row = JSON.parse(this.responseText);
                        console.log(JSON.parse(this.responseText)) 
                        console.log(row.data);
                        if(row.type == 'amigo_ok')
                        {
                           let superparent = event.target.closest('.amigo-card');
                           amigosContainer.removeChild(superparent);
                        }
                     }
               },
               function(){
                  alert("Запрос не удался");
               });          
         }

 
      }
   });

   let btnRequest = document.querySelector('#btnRequest');

   btnRequest.addEventListener('click', () => {
      let userid = document.querySelector('#userid').value; // const?
      let data = JSON.stringify({'userid' : userid});

      request('POST', '/amigos/request', data,
         function(){ 
            if (this.status != 200) { 
                   alert(`Ошибка ${this.status}: ${this.statusText}`);
               } else { 
                  let row = JSON.parse(this.responseText);
                  console.log(JSON.parse(this.responseText)) 
                  console.log(row.data);

                  let modalMessage = document.querySelector('#modal-message');

                  if(row.type == 'amigo_ok')
                  {
                     $('#exampleModal').modal('hide');
                  }
                  else if(row.type == 'amigo_accepted')
                  {
                     modalMessage.textContent = 'This user is your amigo';
                  }
                  else if(row.type == 'amigo_requested')
                  {
                     modalMessage.textContent = 'Request is already sent';
                  }
                  else if(row.type == 'amigo_requested_you')
                  {
                     modalMessage.textContent = 'This user already sent you a request';
                  }
                  else
                  {
                     modalMessage.textContent = 'User not found';
                  }
               }
         },
         function(){
            alert("Запрос не удался");
         });
   });


}


</script>