<?php $this->view('header');?>
<div class="container d-flex flex-column mt-2">
    <div class="text-center">
        <H1>Edit operation</H1>
    </div>
    <form  method="post">
        <div class="form-group mb-0">
            <label for="accountValueInput">Category</label>
            <select name="category_id" class="form-select form-select-lg mb-3 p-1">
                    <option value="">Choose a category</option>
                    <option disabled value="">INCOME</option>
                    <?php foreach($income_categories as $category): ?>
                        <?php if($current_category_id == $category['id']):?>
                            <option selected value="<?=$category['id']?>"><?=$category['name']?></option>
                        <?php else: ?>
                            <option value="<?=$category['id']?>"><?=$category['name']?></option>
                        <?php endif;?>
                    <?php endforeach;?>
                    <option disabled value="">EXPENSIS</option>
                    <?php foreach($expensis_categories as $category): ?>
                        <?php if($current_category_id == $category['id']):?>
                        <option selected value="<?=$category['id']?>"><?=$category['name']?></option>
                        <?php else: ?>
                            <option value="<?=$category['id']?>"><?=$category['name']?></option>
                        <?php endif;?>
                    <?php endforeach;?>
            </select>
            <small class="form-text text-danger"><?=$errors['value'];?></small>
        </div>

        <div class="form-group">
            <label for="accountValueInput">Value</label>
            <input type="number" name="value" class="form-control" id="accountValueInput" value="<?=$value?>">
            <small class="form-text text-danger"><?=$errors['value'];?></small>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a class="btn btn-secondary" href="/main">Back</a>
    </form>

</div>
<?php $this->view('footer');?>