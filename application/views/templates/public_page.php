<?php 
function is_active($current_page, $page_name = 'home') {
    return $current_page == $page_name ? 'active' : '';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $description ?>">
    <meta name="author" content="Carlos Bello Pauste, Leonardo Quintero Morales">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap/2.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap/2.3.1/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap/docs.css">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/lib/html5shiv/3.6.2-6/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">    
    <link rel="stylesheet" type="text/css" href="../assets/css/public.css">
    <!-- Start page style -->
    <?php echo $styles ?>
    <!-- End page style -->
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="home">CS Academia</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="<?php echo is_active($current_page, 'home') ?>"><a href="home">Inicio</a></li>
              <li class="<?php echo is_active($current_page, 'about') ?>"><a href="about">A cerca de</a></li>
              <li class="<?php echo is_active($current_page, 'contact') ?>"><a href="contact">Contacto</a></li>
              <li class="<?php echo is_active($current_page, 'login') ?>"><a href="login">Acceder</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    
    <!-- Start page content -->
    <?php echo $content ?>
    <!-- End page content -->
    
    <script src="../assets/lib/jquery/1.9.1/jquery.min.js"></script>
    <script src="../assets/lib/bootstrap/2.3.1/js/bootstrap.min.js"></script>
    <!-- Start page scripts -->
    <?php echo $scripts ?>
    <!-- End page scripts -->
</body>
</html>