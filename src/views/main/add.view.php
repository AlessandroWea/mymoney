<?php $this->view('header', compact('page_name'));?>

<style>
    .info {
        background-color: #ddd;
        padding: 10px;
        margin: 3px;
    }

    .op-select {
        margin: 3px;
    }

</style>

<div class="container d-flex justify-content-center align-items-center flex-column mt-2">
 
    <div class="row">
        <form method="post">
            <h1>Adding a new operation</h1>
            <h3>Date: <?=$date;?></h2>
            <div class="text-center text-danger">
            <?= isset($errors['category_id']) ? $errors['category_id'] : '' ?>
        </div>
            <div class="input-group" >
                <div class="info">
                    <span class="" id="inputGroup-sizing-default">Category</span>
                </div>
                <select name="category_id" class="op-select" aria-label="Default select example">
                    <option value="" selected>Choose a category</option>
                    <option disabled value="">INCOME</option>
                    <?php foreach($income_categories as $category): ?>
                        <option value="<?=$category['id']?>"><?=$category['name']?></option>
                    <?php endforeach;?>
                    <option disabled value="">EXPENSIS</option>
                    <?php foreach($expensis_categories as $category): ?>
                        <option value="<?=$category['id']?>"><?=$category['name']?></option>
                    <?php endforeach;?>
                </select>
            </div>

            <div class="text-center text-danger">
                <?= isset($errors['value']) ? $errors['value'] : '' ?>
            </div>
            <div class="input-group" >
                <div class="info">
                    <span class="" id="inputGroup-sizing-default">Value</span>
                </div>
                <input name="value" class="op-select" type="number">
            </div>
   
            <div style class="input-group mt-2">
                <button type="submit" class="btn btn-primary fs-1-5">Add</button>
            </div> 
    </form>
    </div>

</div>
<?php $this->view('footer');?>