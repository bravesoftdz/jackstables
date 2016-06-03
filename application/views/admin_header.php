<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=$title?></title>
        <link rel="stylesheet" href="/css/admin/styles.css">

        <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	    <script src="/js/jquery-1.12.4.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    </head>
    <body>
    <div class="container">
    <nav class="navbar navbar-default navbar-fixed-top">
       <div class="navbar-header">
          <a class="navbar-brand" href="#">Jack's Table Emporium</a>
        </div>

         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Products <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/admin/products/view">View/Edit Products</a></li>
            <li><a href="/admin/products/add">Add Product</a></li>
          </ul>
        </li>

        <li><a href="/admin/categories">Categories</a>
      </ul>

            <div class="container">
        <p class="navbar-text navbar-right">Signed in as <a href="#" class="navbar-link"><?=$_SESSION['logged_in_user']?></a></p>
      </div>
    </div><!-- /.navbar-collapse -->



    </nav>