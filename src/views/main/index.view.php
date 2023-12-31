<?php $this->view('header', ['page_name'=>$page_name]);?>
<div class="container d-flex justify-content-center align-items-center flex-column mt-2">
    <form method="post" class="mb-1">
      <input id="datePicker" value="<?=$date;?>" style="width: 150px" type="date" name="date" id="">
      <button class="btn btn-secondary p-1">go to</button>
    </form>

    <p class="mb-0">Total income: <?=$total_income;?></p>
    <p class="mb-0">Total expensis: <?=$total_expensis;?></p>
    <table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Income/Expensis</th>
      <th scope="col">Category</th>
      <th scope="col">Comment</th>
      <th scope="col">Value</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($rows)): ?>
      <?php $num = 0 ?>
      <?php foreach($rows as $row): $num++?>
        <tr>
          <th scope="row"><?=$num?></th>
          <td><?=$row['type'] ? 'Expensis' : 'Income'?></td>
          <td><?=$row['category_name']?></td>
          <td><?=$row['comment']?></td>
          <td><?=$row['value']?></td>
          <td>
                <a class="btn btn-primary m-1" href="<?=path('main/edit/' . $row['id'])?>">Edit</a>
                <a class="btn btn-danger m-1" href="<?=path('main/delete/' . $row['id'])?>">Delete</a>
              </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
        <tr>
          <?php if(!empty($_SESSION['ACTIVE_ACCOUNT'])): ?>
            <td colspan="6" class="text-center"><h2>There were no operations yet!</h2></td>
          <?php else:?>
            <td colspan="6" class="text-center"><h2>Add an account to start adding operations!</h2></td>
          <?php endif;?>
        </tr>
    <?php endif; ?>
  </tbody>
</table>
<?php $is_show_pagination ? $pager->display() : '';?>
<?php if(!empty($_SESSION['ACTIVE_ACCOUNT'])): ?>
  <a href="<?=path('main/add');?>" class="btn btn-success" style="width:100px"type="button">Add</a>
<?php else:?>
  <button disabled class="btn btn-success" style="width:100px"type="button">Add</button>
<?php endif;?>
</div>
<?php $this->view('footer');?>

<script>
  // document.getElementById('datePicker').valueAsDate = new Date();

</script>