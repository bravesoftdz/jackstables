<h1>Products</h1>
<?php if (!empty($products)): ?>
<table class="products">
<thead>
<tr><th>ID</th><th>Image</th><th>Name</th><th>Description</th><th>Category</th><th>Actions</th></tr>
</thead>
<tbody>
<?php foreach($products as $p): ?>
	<tr>
		<td><?=$p->id?></td><td><?=$p->image?></td><td><?=htmlentities($p->name)?></td><td><?=htmlentities($p->description)?></td><td><?=htmlentities($p->category)?></td><td><button id="remove-<?=$p->id?>">Remove</button></td>
	</tr>
<?php endforeach; ?>

</tbody>
</table>
<?php else: ?>
			<div class="alert alert-danger">
			  There are no products. <a href="<?=base_url().'products/add'?>">Add a product</a>
			</div>
<?php endif; ?>
