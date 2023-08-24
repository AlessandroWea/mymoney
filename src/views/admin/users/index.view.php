<?php $this->view('admin/header', compact('page_name'));?>

      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <a class="btn btn-warning" href="/admin/users/add">Add</a>

                <form class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" value="<?=get('search','');?>" name="search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>User</th>
                      <th>Email</th>
                      <th>Date</th>
                      <th>Banned</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($rows as $row): ?>
                    <tr>
                      <td><?=$row['id']?></td>
                      <td><?=$row['username']?></td>
                      <td><?=$row['email']?></td>
                      <td><?=$row['date']?></td>
                      <td><?=$row['banned'] ? 'Yes' : 'No'?></td>
                      <td>
                        <?php if($row['banned']): ?>
                          <a class="btn btn-danger" href="/admin/users/unban/<?=$row['id']?>">Unban</a>
                        <?php else: ?>
                          <a class="btn btn-danger" href="/admin/users/ban/<?=$row['id']?>">Ban</a>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

            </div>
            <?php $pager->display(['search'=>$search]); ?>

            <!-- /.card -->
          </div>
        </div>
       
<?php $this->view('admin/footer');?>