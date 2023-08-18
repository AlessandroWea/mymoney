<?php $this->view('header');?>
<div class="container d-flex flex-column mt-2">
    <div class="text-center">
        <H1>Edit an account</H1>
    </div>

    <form method="POST">
        <div class="form-group">
            <label for="accountNameInput">Account name</label>
            <input type="text" name="name" value="<?=$row['name'];?>" class="form-control" id="accountNameInput" placeholder="Enter account's name">
            <small class="form-text text-danger"><?=$errors['name'];?></small>        
        </div>
        <div class="form-group">
            <label for="accountValueInput">Value</label>
            <input type="number"  name="value" class="form-control" id="accountValueInput" value="<?=post('value',$row['value'])?>">
            <small class="form-text text-danger"><?=$errors['value'];?></small>        
        </div>

        <button type="submit" class="btn btn-primary">Add</button>
        <a class="btn btn-secondary" href="/wallet">Back</a>
    </form>

</div>
<?php $this->view('footer');?>