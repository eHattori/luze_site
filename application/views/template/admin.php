
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Baldan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="EC9">

    <!-- Le styles -->
    <link href="<?php echo url_css("bootstrap.css")?>" rel="stylesheet">
    <link href="<?php echo url_css("dsv.css")?>" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="<?php echo url_css("bootstrap-responsive.css")?>" rel="stylesheet">

    <link rel="shortcut icon" href="<?php echo url_img("favicon.ico")?>">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo site_url("admin")?>">Baldan</a>
          	<?php if(getNomeUsuarioLogin()):?>
          <div class="btn-group pull-right">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <span id="nome_usuario_login"><?php echo getNomeUsuarioLogin();?></span>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
            	<li><a href="<?php echo site_url()."admin/usuariocontroller/alterar_usuario_logado";?>">Alterar dados</a></li>
              	<li><a href="<?php echo site_url()."admin/logincontroller/logout";?>">Logout</a></li>
            </ul>
          </div>          
          <div class="nav-collapse">
            <?php echo get_menu()?>
          </div>
            <?php  endif;?>
        </div>
      </div>
    </div>

    <div class="container">
		<div style="min-height:430px;">
	      <?php echo $conteudo; ?>
		</div>
      	<footer>
        	<br>
        	<hr>
        	<p>&copy; EC9 2012</p>
      	</footer>
    </div>
    
     <script type="text/javascript">	
	 	var site_url = "<?php echo site_url()?>";
	    var base_url = "<?php echo base_url()?>";
	    var url_img  = "<?php echo url_img()?>";
	    var url_arq	 = "<?php echo url_arquivos()?>";	 
        
	</script>

    <script src="<?php echo url_js("libs/jquery-1.7.2.min.js")?>"></script>
    <script src="<?php echo url_js("plugins/MI.js")?>"></script>
    <script src="<?php echo url_js("plugins/uteis.js")?>"></script>
    <script src="<?php echo url_js("libs/jquery.form.js")?>"></script>
	<script src="<?php echo url_js("libs/jquery.validate.js")?>"></script>
    <script src="<?php echo url_js("plugins/util_validate.js")?>"></script>
    <script src="<?php echo url_js("libs/jquery.maskedinput.js")?>"></script>
    
    
    <script src="<?php echo url_js("plugins/bootstrap-alert.js")?>"></script>
    <script src="<?php echo url_js("plugins/bootstrap-modal.js")?>"></script>
    <script src="<?php echo url_js("plugins/bootstrap-dropdown.js")?>"></script>
    <script src="<?php echo url_js("plugins/bootstrap-scrollspy.js")?>"></script>
    <script src="<?php echo url_js("plugins/bootstrap-tab.js")?>"></script>
    <script src="<?php echo url_js("plugins/bootstrap-tooltip.js")?>"></script>
    <script src="<?php echo url_js("plugins/bootstrap-popover.js")?>"></script>
    <script src="<?php echo url_js("plugins/bootstrap-button.js")?>"></script>
    <script src="<?php echo url_js("plugins/bootstrap-collapse.js")?>"></script>
    <script src="<?php echo url_js("plugins/bootstrap-carousel.js")?>"></script>
    <script src="<?php echo url_js("plugins/bootstrap-typeahead.js")?>"></script>
    
    <script type="text/javascript"> var site_url = "<?php echo site_url()?>";</script>
    
    <?php
    	echo $_scripts;
    	echo $_styles;
    ?>
    
 </body>
 </html>

 