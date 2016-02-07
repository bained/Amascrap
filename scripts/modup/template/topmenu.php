
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Amascrap</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if($mp == 'index'){ ?>class="active"<?php } ?>><a href="/">Add product</a></li>
            <li <?php if($mp == 'products'){ ?>class="active"<?php } ?>><a href="<?php echo $WORKING_URL; ?>index.php/products/addedon">Products</a></li>
            <li <?php if($mp == 'prcchanged'){ ?>class="active"<?php } ?>><a href="<?php echo $WORKING_URL; ?>index.php/prcchanged/">Changed Price</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li <?php if($mp == 'settings'){ ?>class="active"<?php } ?>><a href="<?php echo $WORKING_URL; ?>index.php/settings">Settings</a></li>
            <!-- <li><a href="">Help</a></li> -->
            <li><a href="#" data-toggle="modal" data-target="#AboutModal">About</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
