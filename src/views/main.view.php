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
    <tr>
      <th scope="row">1</th>
      <td>Income</td>
      <td>Salary</td>
      <td>30000</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Expensis</td>
      <td>Food</td>
      <td>1000</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="1">Expensis</td>
      <td>Taxi</td>
      <td>150</td>

    </tr>
  </tbody>
</table>
<button class="btn btn-success" style="width:100px"type="button">Add</button>

</div>

<?php $this->view('footer');?>