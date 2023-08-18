<?php $this->view('header', compact('page_name'));?>
<div class="container d-flex flex-column mt-2">
   <H1>Settings</H1>
   <form method="post">
   <small id="emailHelp" class="form-text text-danger"><?=isset($errors['username']) ? $errors['username'] : ''?></small>
   <div class="input-group mb-3">
      <div class="input-group-prepend">
         <span class="input-group-text" id="basic-addon1">Username</span>
      </div>
      <input type="text" name="username" value="<?=$username;?>" class="form-control"  aria-label="Username" aria-describedby="basic-addon1">
   </div>
   <small id="emailHelp" class="form-text text-danger"><?=isset($errors['email']) ? $errors['email'] : ''?></small>
   <div class="input-group mb-3">
      <div class="input-group-prepend">
         <span class="input-group-text" id="basic-addon1">Email</span>
      </div>
      <input type="email" name="email" value="<?=$email;?>" class="form-control"  aria-label="Email" aria-describedby="basic-addon1">
   </div>
   <small id="emailHelp" class="form-text text-danger"><?=isset($errors['password']) ? $errors['password'] : ''?></small>
   <div class="input-group mb-3">
      <div class="input-group-prepend">
         <span class="input-group-text" id="basic-addon1">Password</span>
      </div>
      <input type="password" name="password" class="form-control"  aria-label="password" aria-describedby="basic-addon1">
   </div>
   <div class="input-group mb-3">
      <div class="input-group-prepend">
         <span class="input-group-text" id="basic-addon1">Password Repeat</span>
      </div>
      <input type="password" name="password2" class="form-control"  aria-label="password" aria-describedby="basic-addon1">
   </div>
   <button class="btn btn-success">Update</button>
   </form>
</div>
<?php $this->view('footer');?>