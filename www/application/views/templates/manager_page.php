<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('templates/gtm', $this->config); ?>
        <?php renderHeaderGtm($this->config->item('gtm_tag_id', 'academy')); ?>
        <meta charset="utf-8">
        <title><?php echo "CSAcademia - " . $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $description ?>">
        <meta name="author" content="Carlos Bello Pauste, Leonardo Quintero Morales">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/lib/bootstrap/2.3.1/css/bootstrap.min.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/lib/bootstrap/2.3.1/css/bootstrap-responsive.min.css') ?>" />
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo site_url('node_modules/html5shiv/dist/html5shiv.js') ?>"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo site_url('assets/ico/apple-touch-icon-144-precomposed.png') ?>">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo site_url('assets/ico/apple-touch-icon-114-precomposed.png') ?>">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo site_url('assets/ico/apple-touch-icon-72-precomposed.png') ?>">
        <link rel="apple-touch-icon-precomposed" href="<?php echo site_url('assets/ico/apple-touch-icon-57-precomposed.png') ?>">
        <link rel="shortcut icon" href="<?php echo site_url('assets'.$client_theme.'/img/favicon.ico') ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/admin.css') ?>">
        <?php if ($subdomain_match_client) {?>
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets'.$client_theme.'/css/client.css') ?>">
        <?php } ?>        
        <!-- Start page style -->
        <?php echo $styles ?>
        <!-- End page style -->
    </head>
    <body>
        <?php renderBodyGtm($this->config->item('gtm_tag_id', 'academy')); ?>
        <?php $this->load->view($menu_template) ?>

        <!-- Start page content -->
        <?php echo $content ?>
        <!-- End page content -->

        <script src="/node_modules/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="/assets/lib/jquery-ui/1.10.2/ui/jquery-ui.js"></script>
        <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Start page scripts -->
        <?php echo $scripts ?>
        <!-- End page scripts -->
    </body>
</html>