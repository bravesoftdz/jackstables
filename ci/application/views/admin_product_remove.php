<form method="POST">
Are you sure you want to remove <?=htmlentities($product->name)?>?
<input type="hidden" name="remove" value="1">
<button type="submit" class="btn btn-danger">Remove</button> <a href="<?=base_url().'admin/products'?>" class="btn btn-info">Cancel</a>
</form>