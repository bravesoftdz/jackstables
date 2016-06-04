<div class="one-product">
	<div class="row">
	<div class="col-md-12">
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

				<button class="buy-now-button btn btn-primary">Buy Now</button>
		    </div>
	</div>
	</div>
</div>
<script src="<?=base_url('js/one-product.js')?>"></script>