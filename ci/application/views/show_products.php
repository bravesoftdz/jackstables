<div class="products">

<?php $started = false; ?>
<?php foreach($products as $i => $product): 
	?>
	<?php if ($i % 4 == 0){ 
		if ($started){ ?></div><?php }
		$started = true;
		?>
		<div class="row">
	<?php } ?>
		<div class="col-md-3">
		<div class="product">
			<h2 class="name"><a href="<?=base_url('products/view/'.$product->id)?>"><?=$product->name?></a></h2>
			<div class="image">
			<?php if (!empty($product->image)){ ?>
				<a href="<?=base_url('products/view/'.$product->id)?>"><img src="<?=base_url('images/products/')?>/<?=$product->image ?>"></a>
		    <?php }else{ ?>
		    	<div class="placeholder"><a href="<?=base_url('products/view/'.$product->id)?>"><img src="<?=base_url('images/image_placeholder.png')?>"></a></div>
		    <?php } ?>
		    </div>
		    <div class="description">
			<?php if (!empty($product->description)){ ?>
				<p class="description"><?=$product->description?></p>
			<?php }else{ ?>
				<p>No description found</p>
		    <?php } ?>
			</div>
	    </div>
    </div>
<?php endforeach; ?>
</div><!-- class row -->

</div><!-- products -->