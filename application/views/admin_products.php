<h1>Products</h1>
<?php if (!empty($products)): ?>
<div class="row">
<div class="col-md-12">

<table class="table products">
<thead>
<tr><th>ID</th><th>Image</th><th>Name</th><th>Description</th><th>Category</th><th>Inventory Count</th><th>Actions</th></tr>
</thead>
<tbody>
<?php foreach($products as $p): ?>
	<tr>
		<td><?=$p->id?></td><td><?php if (!empty($p->image) && file_exists(__DIR__.'/../../images/products/'.$p->image)){ ?><img class="image" src="<?=base_url('images/products/'.$p->image)?>"><?php } ?></td><td><?=htmlentities($p->name)?></td><td><?=htmlentities($p->description)?></td>
		
		<td><?=htmlentities($p->category)?></td>
		<td><?=htmlentities($p->inventory_count)?></td>
		<td><a class="btn btn-info" role="button" href="<?=base_url().'admin/products/edit/'.$p->id?>">Edit</a> <a href="<?=base_url().'admin/products/remove/'.$p->id?>" id="remove-<?=$p->id?>" class="btn btn-danger">Remove</a></td>
	</tr>
<?php endforeach; ?>

</tbody>
</table>
</div>
</div>

<div class="row">
	<div class="col-md-1">
		<a class="btn btn-primary" href="<?=base_url().'admin/products/add'?>">Add</a>
	</div>
</div>

<?php else: ?>
			<div class="alert alert-danger">
			  There are no products. <a href="<?=base_url().'admin/products/add'?>">Add a product</a>
			</div>
<?php endif; ?>
