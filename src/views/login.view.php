<?php $this->view('header');?>

<style>
 .fs-1-5 {
    font-size: 1.5rem;
 }

</style>

<div class="container">
    <form method="post">
        <h1 class="text-center mt-3 mb-3">Login form</h1>
        <?php if(!empty($errors)): ?>
            <p class="text-center text-danger"><?=$errors?></p>
        <?php endif; ?>
        <div class="input-group mb-3" >
            <div class="input-group-prepend">
                <span class="input-group-text fs-1-5" id="inputGroup-sizing-default">Username</span>
            </div>
            <input name="username" type="text" class="form-control fs-1-5"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text fs-1-5" id="inputGroup-sizing-default">Password</span>
            </div>
            <input name="password" type="password" class="form-control fs-1-5" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <button type="submit" class="btn btn-primary fs-1-5">Login</button>
        </div> 
    </form>
</div>

<?php $this->view('footer');?>