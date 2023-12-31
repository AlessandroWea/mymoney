<style>
   .card {
      border: 2px solid black !important;
      color: black;
   }

   .card:hover {
      color: green;
      border-color: green !important;
   }

   a {
      text-decoration: none !important;
   }
</style>

<?php $this->view('header', compact('page_name'));?>
<div class="container d-flex flex-column mt-2">
   <H1 class="text-center">Analytics</H1>
   <div class="ards mt-5 d-flex justify-content-around">
      <a href="<?=path('analytics/overview/income');?>">
         <div class="card-hover card p-3" style="width: 15rem;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm64 320H64V320c35.3 0 64 28.7 64 64zM64 192V128h64c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64v64H448zm64-192c-35.3 0-64-28.7-64-64h64v64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
            <div class="card-body text-center">
               <h2 class="card-title">Income</h5>
            </div>
         </div>
      </a>

      <a href="<?=path('analytics/overview/expensis');?>">
         <div class="card-hover card p-3" style="width: 15rem;">
         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 64C28.7 64 0 92.7 0 128V384c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H64zm64 320H64V320c35.3 0 64 28.7 64 64zM64 192V128h64c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64v64H448zm64-192c-35.3 0-64-28.7-64-64h64v64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
            <div class="card-body text-center">
               <h2 class="card-title">Expensis</h5>
            </div>
         </div>
      </a>

   </div>


</div>
<?php $this->view('footer');?>