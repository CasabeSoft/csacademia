<?php
// @codingStandardsIgnoreFile PSR1.Files.SideEffects
$current_page = $this->uri->segment(2);

function is_active($current_page, $page_name = 'user')
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

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo site_url('node_modules/html5shiv/dist/html5shiv.js') ?>"></script>
        <![endif]-->

        <!-- Start page style -->
        <?php
        if (isset($css_files)) {
            foreach ($css_files as $file) :
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
        <link rel="shortcut icon" href="<?php echo site_url('assets'.$client_theme.'/img/favicon.ico') ?>">    
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/admin.css') ?>">

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
                    <a class="brand" href="/home">CS Academia</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="<?php echo is_active($current_page, 'client') ?>"><a href="/admin/client">Clientes</a></li>
                            <li class="<?php echo is_active($current_page, 'role') ?>"><a href="/admin/role">Roles</a></li>                          
                            <li class="<?php echo is_active($current_page, 'center') ?>"><a href="/admin/center">Centros</a></li>
                            <li class="<?php echo is_active($current_page, 'level') ?>"><a href="/admin/level">Niveles</a></li>
                            <li class="<?php echo is_active($current_page, 'family_relationship') ?>"><a href="/admin/family_relationship">Parent.</a></li>
                            <li class="<?php echo is_active($current_page, 'leave_reason') ?>"><a href="/admin/leave_reason">M. Baja</a></li>
                            <li class="<?php echo is_active($current_page, 'classroom') ?>"><a href="/admin/classroom">Aulas</a></li>
                            <li class="<?php echo is_active($current_page, 'group') ?>"><a href="/admin/group">Grupos</a></li>
                            <li class="<?php echo is_active($current_page, 'user') ?>"><a href="/admin/user">Usuarios</a></li>
                            <li class="<?php echo is_active($current_page, 'teacher') ?>"><a href="/admin/teacher">Prof.</a></li>
                            <li class="<?php echo is_active($current_page, 'student') ?>"><a href="/admin/student">Alumnos</a></li>
                            <li class="<?php echo is_active($current_page, 'contact') ?>"><a href="/admin/contact">Contactos</a></li>
                            <li class="<?php echo is_active($current_page, 'qualification') ?>"><a href="/admin/qualification">Calif.</a></li>
                            <li class="<?php echo is_active($current_page, 'close') ?>"><a href="close">Salir</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                    <div class="nav-collapse collapse pull-right">
                        <ul class="nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo lang('menu_lang') . lang('menu_lang_' . $this->lang_code); ?>
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
        <br><br><br><br><br><br><br><br>
        <div class="well">
            <?php $this->load->view($view_to_load) ?>
        </div>
        <!-- End page content -->

        <script src="<?php echo site_url('node_modules/jquery/dist/jquery.min.js') ?>"></script>
        <script src="<?php echo site_url('node_modules/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
        <!-- Start page scripts -->
        <?php
        if (isset($js_files)) {
            foreach ($js_files as $file) :
                ?>
                <script src="<?php echo $file; ?>"></script>
                <?php
            endforeach;
        }
        ?>
        <!-- End page scripts -->
    </body>
</html>