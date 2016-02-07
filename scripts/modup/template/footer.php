
	<!-- Modal -->
	<div class="modal fade" id="AboutModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">About</h4>
	      </div>
	      <div class="modal-body">
	        Amascrap is developed by <a href="http://blog.nediko.info/" target="_blank">Nedialko Voiniagovski</a>.<br />
	        Amascrap uses the following technologies:<br>
	        - <a href="https://code.google.com/p/phpdesktop/">phpdesctop</a> for php GUI<br>
			- <a href="http://www.kratedesign.com/blog/2010/03/php-router-and-clean-urls/">Simple PHP Router and Clean URL’s</a> - for routing URLs<br>
			- <a href="http://getbootstrap.com/">Bootstrap</a> for CSS Framework
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>






	<script src="<?php echo JS_PATH; ?>jquery-1.11.3.min.js"></script>
	<script src="<?php echo JS_PATH; ?>bootstrap.min.js"></script>


<!-- // LOADING... -->
  <script type="text/javascript">

    $body = $("body");
		$('form').submit(function() {
				$body.addClass("loading");
				return true;
		});

  </script>

	<div class="loadingmodal"><!-- Place at bottom of page --></div>
<!-- // END LOADING... -->

<?php if(isset($mp) && $mp == 'settings'){ ?>
  <script type="text/javascript">


	$(document).on('change', '.btn-file :file', function() {
	  var input = $(this),
	      numFiles = input.get(0).files ? input.get(0).files.length : 1,
	      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	  input.trigger('fileselect', [numFiles, label]);
	});

	$(document).ready( function() {
	    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
	        
	        var input = $(this).parents('.input-group').find(':text'),
	            log = numFiles > 1 ? numFiles + ' files selected' : label;
	        
	        if( input.length ) {
	            input.val(log);
	            // alert(input.val(log));
	            console.log(input.val(log));
	        } else {
	            if( log ) alert(log);
	        }
	        // return;
	    });
	});

  </script>
<?php } ?>

</body>
</html>
