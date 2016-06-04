<div class ="row">

<div class="col-md-12">
<h1>Product Categories</h1>
<p>A unique list of categores for all the products</p>
<ul>
<?php foreach($categories as $c): ?>
<li><a href="<?=base_url('category/'.urlencode(strtolower($c)))?>" target="_blank"><?=$c?></a></li>
<?php endforeach; ?>
</ul>
</div>


</div>

<div class="row">

	<div class="col-md-12">
	<p>In order to add/remove categores you must edit each specific product and change its category</p>
	</div>

</div>