<div class="row">

	<div class="col-md-12">

		<form method="POST">
		  <div class="form-group">
		    <label for="name">Your Name</label>
		    <input type="text" class="form-control" id="name" name="name" <?php if (!empty($_POST['name'])){ echo 'value="'.htmlentities($_POST['name']).'"'; } ?>>
		  </div>  

		  <div class="form-group">
		    <label for="email">Email</label>
		    <input type="email" class="form-control" id="email" name="email" <?php if (!empty($_POST['email'])){ echo 'value="'.htmlentities($_POST['email']).'"'; } ?>>
		  </div>
		  <div class="form-group">
		    <label for="comments">Comments</label>
		    <textarea  name="comments" class="form-control" id="comments"><?php if (!empty($_POST['comments'])){ echo htmlentities($_POST['comments']); } ?></textarea>
		  </div>

		    <button type="submit" class="btn btn-primary">Submit</button>
		</form>

	</div>

</div>