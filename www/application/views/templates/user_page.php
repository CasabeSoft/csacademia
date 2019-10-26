<?php
// @codingStandardsIgnoreFile PSR1.Files.SideEffects
function is_active($current_page, $page_name = 'home')
{
    return $current_page == $page_name ? 'active' : '';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('templates/gtm', $this->config); ?>
        <?php renderHeaderGtm($this->config->item('gtm_tag_id', 'academy')); ?>
        <meta charset="utf-8">
        <title><?php echo "Dundee - " . $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $description ?>">
        <meta name="author" content="Carlos Bello Pauste, Leonardo Quintero Morales">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap/2.3.1/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap/2.3.1/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap/2.3.1/css/docs.css">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="../node_modules/html5shiv/dist/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="../assets<?php echo $client_theme?>/img/favicon.ico">    
        <link rel="stylesheet" type="text/css" href="../assets/css/public.css">
        <?php if ($subdomain_match_client) {?>
        <link rel="stylesheet" type="text/css" href="../assets/css/public.css">
        <link rel="stylesheet" type="text/css" href="../assets<?php echo $client_theme ?>/css/client.css">
        <?php } ?>
        <!-- Start page style -->
        <?php echo $styles ?>
        <!-- End page style -->
    </head>
    <body>
        <?php renderBodyGtm($this->config->item('gtm_tag_id', 'academy')); ?>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!--a class="brand" href="home">CS Academia</a-->
                    <!--div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="<?php echo is_active($current_page, 'home') ?>"><a href="home"><?php echo lang('menu_home'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'about') ?>"><a href="about"><?php echo lang('menu_about'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'contact') ?>"><a href="contact"><?php echo lang('menu_contact'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'login') ?>"><a href="login"><?php echo lang('menu_login'); ?></a></li>

                        </ul>
                    </div--><!--/.nav-collapse -->
                    <div class="nav-collapse collapse pull-right">
                        <ul class="nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo lang('menu_lang').": ".lang('menu_lang_' . $lang_code); ?>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo site_url('lang/es') ?>"><?php echo lang('menu_lang_es'); ?></a></li>
                                    <li><a href="<?php echo site_url('lang/en') ?>"><?php echo lang('menu_lang_en'); ?></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <!-- Start page content -->
        <?php echo $content ?>
        <!-- End page content -->

        <script src="../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="../assets/lib/bootstrap/2.3.1/js/bootstrap.min.js"></script>
        <!-- Start page scripts -->
        <?php echo $scripts ?>
        <!-- End page scripts -->
    </body>
</html>