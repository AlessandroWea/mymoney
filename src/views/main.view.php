<?php $this->view('header');?>
<div class="container d-flex justify-content-center align-items-center flex-column mt-2">
    <input style="width: 150px" type="date" name="" id="">

    <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Income/Expensis</th>
      <th scope="col">Category</th>
      <th scope="col">Value</th>
    </tr>
  </thead>
  <tbody>
    <?php $num = 0 ?>
    <?php foreach($rows as $row): $num++?>
      <tr>
        <th scope="row"><?=$num?></th>
        <td><?=$row['type']?></td>
        <td><?=$row['category']?></td>
        <td><?=$row['value']?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<button class="btn btn-success" style="width:100px"type="button">Add</button>

</div>

<?php $this->view('footer');?>