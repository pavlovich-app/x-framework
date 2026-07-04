<?php
use helpers\ArrayHelper;

$this->title = 'Home page';
?>

<form name="products" method="get">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="products">Products</label>
            <select id="products" class="form-control custom-select" name="products[]" multiple>
                <?php foreach( $product_names as $name ): ?>
                    <option value="<?= $this->encode( $name ) ?>"><?= $this->encode( $name ) ?></option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <button type="submit" class="btn btn-primary">Apply</button>
        </div>
    </div>
</form>

<?php if( !is_null($better) ): ?>
<table class="table table-striped table-bordered table-dark">
    <thead>
    <tr>
        <th scope="col">Restaurant ID</th>
        <th scope="col">Product Name</th>
        <th scope="col">Price</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach( $better as $product ): ?>
        <tr>
            <td><?= $this->encode( $product['restaurant_id'] ) ?></td>
            <td><?php foreach ( $product['names'] as $name ): ?><span class="badge badge-info"> <?= $this->encode($name) ?> </span> <?php endforeach; ?></td>
            <td>$ <?= $this->encode( $product['price'] ) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td class="text-right"><b>Total COST:</b></td>
            <td><b>$ <?= $this->encode( ArrayHelper::sumColumn($better, 'price') ) ?></b></td>
        </tr>
    </tfoot>
</table>
<?php elseif( is_null($better) && isset($this->get['products']) ): ?>
    <div class="alert alert-dark" role="alert">
        Restaurant: none
    </div>
<?php endif; ?>