<h1><?php if (!empty($edit)){ echo 'Edit Product'; }else{ echo 'Add Product'; }?></h1>
<form method="POST">
  <div class="form-group">
    <label for="name">Product Name</label>
    <input type="text" class="form-control" id="name" <?php if (!empty($edit)){ echo 'value="'.htmlentities($product->name).'"'; } ?>>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description">
    <?php if (!empty($edit)){ echo htmlentities($product->description); } ?>
    </textarea>
  </div>
  <div class="form-group">
    <label for="category">Category</label>
    <input type="text" class="form-control" id="category" <?php if (!empty($edit)){ echo 'value="'.htmlentities($product->category).'"'; } ?>>
  </div> 

  <?php if (!empty($edit)): ?>



  <?php endif; ?>
  <button type="submit"><?php if (!empty($edit)){ echo 'Edit'; }else{ echo 'Add'; }?></button>
</form>
