<?php $this->view('header', compact('page_name'));?>
<div class="container d-flex flex-column mt-2">
    <div class="text-center">
        <H1>Wallet</H1>
        <h4>Net: <?=$net?> rub</h4>
    </div>

    <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Value</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($accounts)): $num = 0;?>
      <?php foreach($accounts as $account): $num++?>
          <tr>
              <th scope="row"><?=$num;?></th>
              <td><?=$account['name']?></td>
              <td><?=$account['value']?> rub</td>
              <td>
                <a class="btn btn-primary" href="<?=path('wallet/edit/' . $account['id'])?>">Edit</a>
                <a class="btn btn-danger" href="<?=('wallet/delete/' . $account['id'])?>">Delete</a>
                <?php if($_SESSION['ACTIVE_ACCOUNT']['id'] !== $account['id']): ?>
                    <a class="btn btn-secondary" href="<?=path('wallet/switch/' . $account['id'])?>">Switch to</a>
                <?php endif; ?>
              </td>
          </tr>
      <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4" class="text-center"><h2>There are no accounts yet!</h2></td>
        </tr>
    <?php endif; ?>
  </tbody>
</table>
   <div class="text-center">
        <a class="btn btn-success pr-4 pl-4" href="<?=path('wallet/add')?>">+</a>
   </div>
</div>
<?php $this->view('footer');?>