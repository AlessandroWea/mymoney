<?php

 $this->view('admin/header', compact('page_name'));?>

      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
               <a class="btn btn-warning" href="/admin/categories/add">Add</a>

                <form method="get" class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">

                    <input type="text" value="<?=get('search');?>" name="search" class="form-control float-right" placeholder="Search">

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
                      <th>Type</th>
                      <th>Name</th>
                      <th>Active</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($rows as $row): ?>
                    <tr>
                      <td><?=$row['id']?></td>
                      <td><?=$row['type'] ? 'Income' : 'Expensis'?></td>
                      <td><?=$row['name']?></td>
                      <td><?=$row['disabled'] ? 'No' : 'Yes'?></td>
                      <td>
                        <a class="btn btn-primary" href="/admin/categories/edit/<?=$row['id']?>">Edit</a>
                        <?php if($row['disabled']): ?>
                          <a class="btn btn-danger" href="/admin/categories/enable/<?=$row['id']?>">Enable</a>
                        <?php else: ?>
                          <a class="btn btn-danger" href="/admin/categories/disable/<?=$row['id']?>">Disable</a>
                        <?php endif;?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->

            </div>
            <?php $pager->display(['search' => $search]); ?>

            <!-- /.card -->
          </div>
        </div>
       


<?php $this->view('admin/footer');?>