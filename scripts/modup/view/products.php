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



	<div class="col-xs-12 topbuttons">
		<form method="post" action="">
			<button type="submit" class="btn btn-default" name="submit_update_all_products">Update All Prices</button>
			<button type="submit" class="btn btn-default" name="submit_products_fullupdate">Products Full Update</button>
		</form>
	</div> <!-- /.col-xs-12 -->

	<div class="col-xs-12">



	<table class="table table-bordered">
		<tr>
			<th>Image</th>
			<th<?php if($order === 'name') echo ' class="to"'; ?>><a href="<?php echo $mpch.'name'; ?>">Name</a></th>
			<th<?php if($order === 'price') echo ' class="to"'; ?>><a href="<?php echo $mpch.'price'; ?>">Price</a></th>
			<th<?php if($order === 'latestprice') echo ' class="to"'; ?>><a href="<?php echo $mpch.'latestprice'; ?>">Last Price</a></th>
			<th>Link</th>
			<th<?php if($order === 'addedon') echo ' class="to"'; ?>><a href="<?php echo $mpch.'addedon'; ?>">Added on</a></th>
			<th<?php if($order === 'lastupdate') echo ' class="to"'; ?>><a href="<?php echo $mpch.'lastupdate'; ?>">Last update</a></th>
			<th class='actions'>Actions</th>
		</tr>
		<?php foreach ($all_products as $product) { ?>
			<tr>
				<td><img src="<?php echo DIR_SHOW_SM_IMG.$product['smallimg'] ?>" alt="" /></td>
				<td><a href="<?php echo $ppi.$product['id']; ?>"><?php echo cutstring($product['name'], 56); ?></a></td>
				<td><?php echo $product['price']; ?></td>
				<td><?php echo $product['latestprice']; ?> <?php echo $product['arrow']; ?></td>
				<td><a href="<?php echo $product['longurl']; ?>" target="_blank">Link</a></td>
				<td><?php echo gmtimestamp($product['addedon']); ?></td>
				<td><?php echo gmtimestamp($product['lastupdate']); ?></td>
				<td>
					<form method="post" action="">
						<input type="hidden" name="code" value="<?php echo $product['code']; ?>" />
						<div class="btn-group btn-group-xs" role="group" aria-label="...">
							<button type="submit" class="btn btn-primary" name="submit_product_update">Update &#163;</button>
							<button type="submit" class="btn btn-danger" name="submit_product_delete">Delete</button>
						</div>
					</form>
				</td>
			</tr>
		<?php } ?>
	</table>






	<nav><ul class="pagination">
		<?php //print_r($paging);
		foreach ($plinks as $li){
			if($li == $paging['current'] || $li == "..."){ ?>
				<li class="active"><span<?php if($li == "...") echo " class=\"trans\""; ?>><?php echo $li; ?></span></li>
			<?php } else { ?>
				<li><a href="<?php echo $mpi.$li; ?>"><?php echo $li; ?></a></li>
			<?php }
		} ?>		
	</ul></nav>







	</div> <!-- /.col-xs-12 -->

</div> <!-- /.container -->



<?php include DIR_TMPL.'/footer.php'; ?>
