<style>
   .card {
      border: 2px solid black !important;
      color: black;
   }

   .card:hover {
      color: green;
      border-color: green !important;
   }

   a {
      text-decoration: none !important;
   }
</style>

<?php

use Alewea\Mymoney\models\Category;

 $this->view('header');?>

<script>
<?php if($data): ?>
window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light2",
	animationEnabled: true,
	title: {
		text: ''

	},
	data: [{
		type: "pie",
		indexLabel: "{y}",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabelPlacement: "inside",
		indexLabelFontColor: "#36454F",
		indexLabelFontSize: 18,
		indexLabelFontWeight: "bolder",
		showInLegend: true,
		legendText: "{label}",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
<?php endif;?>
</script>


<div class="container d-flex flex-column mt-2">
   <div class="info text-center">
        <h1><?=$type == Category::$TYPE_INCOME ? 'Income' : 'Expensis'?></h1>
        <form method="POST" class="mb-0">
            <select name="date_type" class="form-select form-select-lg mb-3 p-1">
                <option selected>Choose the date</option>
                <option value="" disabled>----------</option>
                <?php $i = 0; ?>
                <?php foreach($this->date_types as $type):?>
                    <option <?=$current_date_type == $type ? 'selected' : ''?> value="<?=$i?>"><?=ucfirst(str_replace('-',' ', $type))?></option>
                <?php $i++; endforeach;?>
            </select>
            <button class="btn btn-secondary p-1">Go to</button>
        </form>

        <?php if($data):?>
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        <?php endif;?>
   </div>
   <p>Total: <?=$total?> rub</p>

   <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">#</th>
            <th scope="col">Category</th>
            <th scope="col">Value</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($data)): $num = 0?>
                <?php foreach($data as $row): $num++?>
                    <tr>
                        <th scope="row"><?=$num;?></th>
                        <td><?=$row['category']?></td>
                        <td><?=$row['value']?> rub</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <?php if(!empty($_SESSION['ACTIVE_ACCOUNT'])): ?>
                    <td colspan="5" class="text-center"><h2>There were no operations yet!</h2></td>
                <?php else:?>
                    <td colspan="5" class="text-center"><h2>Add an account first!</h2></td>
                <?php endif;?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $this->view('footer');?>