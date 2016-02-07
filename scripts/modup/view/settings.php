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

		<h2>Load new DB-File</h2>

		<strong>Currently you use this file:</strong><br>
		<?php echo realpath(preg_replace('@^DB_DIR@', DB_DIR, $all_settings['database_file'])); ?><br><br><br>



		<form action="" method="post" enctype="multipart/form-data">
			
			<h4>Import DB-File</h4>

            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        Browse… <input name="db_file" type="file">
                    </span>
                </span>
                <input class="form-control" name="proba" readonly="" type="text">
            </div>
            <br>
            <button type="submit" name="submit_db_file" class="btn btn-primary">Submit</button>

			<!-- <input id="input-1" type="file" class="file"> -->
			
		</form>
		<br><br>
		<form action="" method="post">
			<h4>Restore Default DB-File</h4>

			<button type="submit" name="submit_restoreDefaultDB" class="btn btn-primary">Restore</button>
		</form>
		<hr>


		<h2>Products per page</h2>
		<form action="" method="post" class="form-inline">
			<!-- <label class="control-label">Amount of products on page</label> -->
			<div class="form-group">
			<div class="input-group">
				<input type="text" class="form-control" name="productsPerPage" value="<?php echo $all_settings['productsPerPage']; ?>" id="Amount" placeholder="Amount of products on page">
				<div class="input-group-addon">Number</div>
			</div>
			</div>
			<button type="submit" name="submit_productsPerPage" class="btn btn-primary">Submit</button>
		</form>
		<hr>


	</div> <!-- /.col-xs-12 -->

</div> <!-- /.container -->



<?php include DIR_TMPL.'/footer.php'; ?>
