<?php $this->view('header');?>
<div class="container d-flex flex-column mt-2">
    <div class="text-center">
        <H1>Deleting an account</H1>
    </div>

    <form method="post">
        <div class="form-group">
            <label for="accountNameInput">Account name</label>
            <input type="text" value="<?=$row['name']?>" class="form-control" disabled id="accountNameInput" placeholder="Enter account's name">
        </div>
        <div class="form-group">
            <label for="accountValueInput">Value</label>
            <input type="number" value="<?=$row['value'];?>" class="form-control" disabled id="accountValueInput" value="0">
        </div>

        <button type="submit" class="btn btn-danger">Delete</button>
        <a class="btn btn-secondary" href="/wallet">Back</a>
    </form>

</div>
<?php $this->view('footer');?>