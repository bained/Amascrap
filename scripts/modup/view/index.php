<?php include DIR_TMPL.'/header.php'; ?>


<div class="container">

<?php if($errors || $messages){ ?>

	<?php if($errors){ ?>
	<div class="col-xs-12"><div class="alert alert-warning" role="alert"><ul>
		<?php foreach($errors as $error){ ?>
			<li><?php echo $error; ?></li>
		<?php } ?>
	</ul></div></div>
	<?php } ?>

	<?php if($messages){ ?>
	<div class="col-xs-12"><div class="alert alert-success" role="alert"><ul>
		<?php foreach($messages as $message){ ?>
			<li><?php echo $message; ?></li>
		<?php } ?>
	</ul></div></div>
	<?php } ?>

	
<?php } ?>

<div class="col-xs-12">
	

	<form class="form-inline" action="/" method="post">
	  <div class="form-group">
	    <label for="exampleInputName2">Amazon.co.uk URL: </label>
	    <input type="text" class="form-control" id="exampleInputName2" placeholder="Enter product URL: http://amazon.co.uk..." name="url">
	  </div>

	  <button type="submit" class="btn btn-primary" name="get_amazon_data">Get Data</button>
	</form>


</div>
</div>

<?php
if($product_content) {
?>
<div class="container">
	<div class="col-xs-12">
		<h3>Product info</h3>

		<?php //print_r($product_content); ?>

		<strong>Name: </strong><?php echo $product_content['name']; ?><br />
		<strong>Price: </strong><?php echo $product_content['price']; ?> &pound;<br />
		<strong>Small picture: </strong><img src="<?php echo $product_content['smallimg']; ?>" alt="" />

		<div class="clearfix"></div>
	</div> <!-- /.col-xs-12 -->
	<div class="col-xs-12">
		<form action="/" method="post">
			<input type="hidden" name="name" value="<?php echo $product_content['name']; ?>" />
			<input type="hidden" name="code" value="<?php echo $product_content['code']; ?>" />
			<input type="hidden" name="price" value="<?php echo $product_content['price']; ?>" />
			<input type="hidden" name="smallimg" value="<?php echo $product_content['smallimg']; ?>" />
			<input type="hidden" name="shorturl" value="<?php echo $product_content['shorturl']; ?>" />
			<input type="hidden" name="longurl" value="<?php echo $product_content['longurl']; ?>" />


			<button type="submit" class="btn btn-primary" name="add_product_to_db">Add to DB</button>
		</form>
		

	</div> <!-- /.col-xs-12 -->
</div> <!-- /.container -->

<?php
}
?>

<?php include DIR_TMPL.'/footer.php'; ?>
