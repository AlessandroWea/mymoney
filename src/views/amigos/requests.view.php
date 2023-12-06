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

<h1 class="text-center">You requested new amigos</h1>
<h2 id="amigos-count" class="text-center">(<?=count($rows)?>)</h1>

<div id="amigos-container" class="row">

   <?php foreach($rows as $row): ?>
      <a href="#" id="c" class="amigo-card card w-100 m-1">
         <div class="car d-flex">
            <img src="money-bill-solid.svg" width="100px" alt="">
            <div class="card-body">
               <h5 class="card-title"><?=$row['username']?></h5>
               <div class="btns">
                  <button type="button" id="btnCancel" data-id="<?=$row['id']?>" data-type='remove' class="btn btn-sm btn-danger">Cancel</button>
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
         let amigosCount = document.querySelector('#amigos-count');

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
                           amigosCount.textContent = '(' + amigosContainer.children.length + ')';
                        }
                     }
               },
               function(){
                  alert("Запрос не удался");
               });          
         }

 
      }
   });
}


</script>