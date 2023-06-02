<?php $this->view('header');?>

<style>
 .fs-1-5 {
    font-size: 1.5rem;
 }

</style>

<div class="container">
    <form action="post"">
        <h1 class="text-center mt-3 mb-3">Signup form</h1>
        <div class="input-group mb-3" >
            <div class="input-group-prepend">
                <span class="input-group-text fs-1-5" id="inputGroup-sizing-default">Username</span>
            </div>
            <input type="text" class="form-control fs-1-5"  aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text fs-1-5" id="inputGroup-sizing-default">Email</span>
            </div>
            <input type="email" class="form-control fs-1-5" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text fs-1-5" id="inputGroup-sizing-default">Password</span>
            </div>
            <input type="password" class="form-control fs-1-5" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text fs-1-5" id="inputGroup-sizing-default">Password repeat</span>
            </div>
            <input type="password" class="form-control fs-1-5" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <button type="submit" class="btn btn-primary fs-1-5">Submit</button>
        </div> 
    </form>
</div>

<?php $this->view('footer');?>