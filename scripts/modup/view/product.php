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

	<table class="table table-bordered">
		<tr>
			<td>Image: </td>
			<td><img src="<?php echo DIR_SHOW_SM_IMG.$product['smallimg'] ?>" alt="" /></td>
		</tr>

		<tr>
			<td>Name: </td>
			<td><?php echo $product['name']; ?></td>
		</tr>
		<tr>
			<td>First Price</td>
			<td><?php echo $product['price']; ?></td>
		</tr>
		<tr>
			<td>Last Price</td>
			<td><?php echo $product['latestprice']; ?></td>
		</tr>
		<tr>
			<td>Added On</td>
			<td><?php echo gmtimestamp($product['addedon']); ?></td>
		</tr>
		<tr>
			<td>Last update</td>
			<td><?php echo gmtimestamp($product['lastupdate']); ?></td>
		</tr>
		<tr>
			<td>Original Link</td>
			<td><a href="<?php echo $product['longurl']; ?>" target="_blank">Link</a></td>
		</tr>
		<tr>
			<td>Short Link</td>
			<td>
				<a href="<?php echo $product['shorturl']; ?>" target="_blank">
				<?php echo $product['shorturl']; ?>
				</a>
			</td>
		</tr>
		<tr>
			<td>Actions</td>
			<td>
				<form method="post" action="" class="pull-left">
					<input type="hidden" name="code" value="<?php echo $product['code']; ?>" />
					<button type="submit" name="submit_product_update" class="btn btn-primary">Update price</button>
					<button type="submit" name="submit_product_full_update" class="btn btn-primary">Full update</button>
					<input type="hidden" name="first_price" value="<?php echo $product['latestprice']; ?>" />
					<button type="submit" name="submit_product_ch_first_price" class="btn btn-primary">Change First Price</button>
				</form>

				<form method="post" action="<?php echo $WORKING_URL; ?>index.php/products/" class="pull-right">
					<input type="hidden" name="code" value="<?php echo $product['code']; ?>" />
					<button type="submit" name="submit_product_delete" class="btn btn-danger">Delete product</button>
				</form>				
			</td>
		</tr>
	</table>


	</div> <!-- /.col-xs-12 -->

	<div class="col-xs-12">
		
	<?php include DIR_VIEW.'/traktor.php'; ?>

	</div>

</div> <!-- /.container -->



<?php include DIR_TMPL.'/footer.php'; ?>
