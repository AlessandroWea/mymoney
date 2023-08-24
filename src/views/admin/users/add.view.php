<?php $this->view('admin/header', compact('page_name'));?>

<div class="row">

    <div class="card card-primary col-12">

        <!-- /.card-header -->
        <!-- form start -->
        <form method="post">
        <div class="card-body">
            <div class="form-group">
                <label for="inputUsername">
                    <span class="mr-3">Username</span>
                    <small class="text-center text-danger">
                        <?= isset($errors['username']) ? $errors['username'] : '' ?>
                    </small>
                </label>
                <input name="username" value="<?=post('username', '')?>" type="text" class="form-control" id="inputUsername" placeholder="Enter username">
            </div>

            <div class="form-group">
                <label for="inputEmail">
                    <span class="mr-3">Email</span>
                    <small class="text-center text-danger">
                        <?= isset($errors['email']) ? $errors['email'] : '' ?>
                    </small>
                </label>
                <input name="email" value="<?=post('email', '')?>" type="email" class="form-control" id="inputEmail" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="">Role</label>
                <div class="form-check">
                    <input id="radioRoleUser" class="form-check-input" type="radio" name="role" value="0" <?=checked('role',0)?>>
                    <label for="radioRoleUser" class="form-check-label">User</label>
                </div>
                <div class="form-check">
                    <input id="radioRoleAdmin" class="form-check-input" type="radio" value="1" name="role" <?=checked('role',1)?>>
                    <label for="radioRoleAdmin" class="form-check-label">Admin</label>
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword">
                    <span class="mr-3">Password</span>
                    <small class="text-center text-danger">
                        <?= isset($errors['password']) ? $errors['password'] : '' ?>
                    </small>
                </label>
                <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="inputPasswordRepeat">Password repeat</label>
                <input name="password2" type="password" class="form-control" id="inputPasswordRepeat" placeholder="Password">
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