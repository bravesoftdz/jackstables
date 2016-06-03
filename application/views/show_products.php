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
			<h2 class="name"><?=$product->name?></h2>
			<div class="image">
			<?php if (!empty($product->image)){ ?>
				<img src="/images/products/<?=$product->image ?>">
		    <?php }else{ ?>
		    	<div class="placeholder"><img src="/images/image_placeholder.png"></div>
		    <?php } ?>
		    </div>
		    <div class="description">
			<?php if (!empty($product->description)){ ?>
				<p class="description"><?=$product->description?></p>
			<?php }else{ ?>
				<p>No description found</p>
		    <?php } ?>
			</div>

			<!-- <pre>
		    <?php var_dump($product); ?>
		    </pre> -->
	    </div>
    </div>
<?php endforeach; ?>
</div><!-- class row -->

</div><!-- products -->