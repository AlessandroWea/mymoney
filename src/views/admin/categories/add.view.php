<?php $this->view('admin/header', compact('page_name'));?>

<div class="row">

    <div class="card card-primary col-12">

        <!-- /.card-header -->
        <!-- form start -->
        <form method="post">
        <div class="card-body">
            <div class="form-group">
                <label for="inputUsername">
                    <span class="mr-3">Name</span>
                    <small class="text-center text-danger">
                        <?= isset($errors['name']) ? $errors['name'] : '' ?>
                    </small>
                </label>
                <input name="name" value="<?=post('name', '')?>" type="text" class="form-control" id="inputUsername" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="">
                    Type
                    <small class="text-center text-danger">
                        <?= isset($errors['type']) ? $errors['type'] : '' ?>
                    </small>
                </label>
                <div class="form-check">
                    <input id="radioTypeIncome" class="form-check-input" type="radio" name="type" value="0" <?=checked('type',0)?>>
                    <label for="radioTypeIncome" class="form-check-label">Income</label>
                </div>
                <div class="form-check">
                    <input id="radioTypeExpensis" class="form-check-input" type="radio" name="type" value="1" <?=checked('type',1)?>>
                    <label for="radioTypeExpensis" class="form-check-label">Expensis</label>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        </form>
    </div>

</div>

<?php $this->view('admin/footer');?>