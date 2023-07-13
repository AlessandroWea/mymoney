<?php $this->view('header');?>

<style>
 .fs-1-5 {
    font-size: 1.5rem;
 }

</style>

<div class="container">
    <form method="post"">
        <h1 class="text-center mt-3 mb-3">Signup form</h1>

        <!-- username input -->
        <div class="text-center text-danger">
            <?= isset($errors['username']) ? $errors['username'] : '' ?>
        </div>
        <div class="input-group mb-3" >
            <div class="input-group-prepend">
                <span class="input-group-text fs-1-5" id="inputGroup-sizing-default">Username</span>
            </div>
            <?php if(isset($errors['username'])): ?>
                <input name="username" value="<?=post('username');?>" type="text" class="form-control fs-1-5 border-danger">
            <?php else: ?>
                <input name="username" value="<?=post('username');?>" type="text" class="form-control fs-1-5">
            <?php endif; ?>
        </div>

        <!-- email input -->
        <div class="text-center text-danger">
            <?= isset($errors['email']) ? $errors['email'] : '' ?>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text fs-1-5" id="inputGroup-sizing-default">Email</span>
            </div>
            <?php if(isset($errors['email'])): ?>
                <input name="email" value="<?=post('email');?>" type="text" class="form-control fs-1-5 border-danger">
            <?php else: ?>
                <input name="email" value="<?=post('email');?>" type="text" class="form-control fs-1-5">
            <?php endif; ?>
        </div>

        <!-- password input -->
        <div class="text-center text-danger">
            <?= isset($errors['password']) ? $errors['password'] : '' ?>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text fs-1-5" id="inputGroup-sizing-default">Password</span>
            </div>
            <?php if(isset($errors['password'])): ?>
                <input name="password" type="text" class="form-control fs-1-5 border-danger">
            <?php else: ?>
                <input name="password" type="text" class="form-control fs-1-5">
            <?php endif; ?>
        </div>

        <!-- password2 input -->
        <div class="text-center text-danger">
            <?= isset($errors['password2']) ? $errors['password2'] : '' ?>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text fs-1-5" id="inputGroup-sizing-default">Password repeat</span>
            </div>
            <?php if(isset($errors['password'])): ?>
                <input name="password2" type="text" class="form-control fs-1-5 border-danger">
            <?php else: ?>
                <input name="password2" type="text" class="form-control fs-1-5">
            <?php endif; ?>
        </div>
        
        <div class="input-group mb-3">
            <button type="submit" class="btn btn-primary fs-1-5">Signup</button>
        </div> 

    </form>
</div>

<?php $this->view('footer');?>