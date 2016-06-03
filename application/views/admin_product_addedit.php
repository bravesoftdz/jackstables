<h1><?php if (!empty($edit)){ echo 'Edit Product'; }else{ echo 'Add Product'; }?></h1>

<?php if (isset($errors)): ?>
			<div class="alert alert-danger">
			  <strong>Error: </strong> <?=$errors?>
			</div>
<?php endif; ?>

<form method="POST">
  <div class="form-group">
    <label for="name">Product Name</label>
    <input type="text" class="form-control" id="name" name="name" <?php if (!empty($edit)){ echo 'value="'.htmlentities($product->name).'"'; }else if (!empty($_POST['name'])){ echo 'value="'.htmlentities($_POST['name']).'"'; } ?>>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea  name="description" class="form-control" id="description"><?php if (!empty($edit)){ echo htmlentities($product->description); }else if (!empty($_POST['description'])){ echo htmlentities($_POST['description']); } ?></textarea>
  </div>
  <div class="form-group">
    <label for="category">Category</label>
    <input type="text" name="category" class="form-control" id="category" <?php if (!empty($edit)){ echo 'value="'.htmlentities($product->category).'"'; }else if (!empty($_POST['category'])){ echo 'value="'.htmlentities($_POST['category']).'"'; } ?>>
  </div> 

  <div class="form-group">
    <label for="inventory_count">Inventory Count</label>
    <input type="number" min="0" name="inventory_count" class="form-control" id="inventory_count" <?php if (!empty($edit)){ echo 'value="'.htmlentities($product->inventory_count).'"'; }else if (!empty($_POST['inventory_count'])){ echo 'value="'.htmlentities($_POST['inventory_count']).'"'; } ?>>
  </div> 


  <?php if (!empty($edit)): ?>
  <input type="hidden" name="id" value="<?=$product->id?>" />


  <?php endif; ?>
  <button type="submit" class="btn btn-primary"><?php if (!empty($edit)){ echo 'Update'; }else{ echo 'Add'; }?></button>
</form>
