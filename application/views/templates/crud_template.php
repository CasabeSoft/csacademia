<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $description ?>">
        <meta name="author" content="Carlos Bello Pauste, Leonardo Quintero Morales">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo site_url('assets/lib/html5shiv/3.6.2-6/html5shiv.js') ?>"></script>
        <![endif]-->

        <!-- Start page style -->
        <?php
        if (isset($crud_view->css_files)) {
            foreach ($crud_view->css_files as $file):
                ?>
                <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
                <?php
            endforeach;
        }
        ?>
        <!-- End page style -->

        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/lib/bootstrap/2.3.1/css/bootstrap.min.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/lib/bootstrap/2.3.1/css/bootstrap-responsive.min.css') ?>" />

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo site_url('assets/ico/apple-touch-icon-144-precomposed.png') ?>">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo site_url('assets/ico/apple-touch-icon-114-precomposed.png') ?>">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo site_url('assets/ico/apple-touch-icon-72-precomposed.png') ?>">
        <link rel="apple-touch-icon-precomposed" href="<?php echo site_url('assets/ico/apple-touch-icon-57-precomposed.png') ?>">
        <link rel="shortcut icon" href="<?php echo site_url('assets/ico/favicon.png') ?>">    
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/admin.css') ?>">

    </head>
    <body>
        <?php $this->load->view('templates/manager_menu') ?>

        <!-- Start page content -->
        <div class="container container-first">
            <h1><?php echo $page_header ?></h1>
            <?php echo $crud_view->output; ?>
        </div>
        <!-- End page content -->

        <script src="<?php echo site_url('assets/lib/jquery/1.9.1/jquery.min.js') ?>"></script>
        <script src="<?php echo site_url('assets/lib/bootstrap/2.3.1/js/bootstrap.min.js') ?>"></script>        
        <!-- Start page scripts -->
        <?php
        if (isset($crud_view->js_files)) {
            foreach ($crud_view->js_files as $file):
                ?>
                <script src="<?php echo $file; ?>"></script>
                <?php
            endforeach;
        }
        ?>
        <!-- End page scripts -->
    </body>
</html>