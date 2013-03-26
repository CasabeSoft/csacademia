<?php

function is_active($current_page, $page_name = 'main') {
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
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/lib/bootstrap/2.3.1/css/bootstrap.min.css') ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/lib/bootstrap/2.3.1/css/bootstrap-responsive.min.css') ?>" />
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo site_url('assets/lib/html5shiv/3.6.2-6/html5shiv.js') ?>"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo site_url('assets/ico/apple-touch-icon-144-precomposed.png') ?>">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo site_url('assets/ico/apple-touch-icon-114-precomposed.png') ?>">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo site_url('assets/ico/apple-touch-icon-72-precomposed.png') ?>">
        <link rel="apple-touch-icon-precomposed" href="<?php echo site_url('assets/ico/apple-touch-icon-57-precomposed.png') ?>">
        <link rel="shortcut icon" href="<?php echo site_url('assets/ico/favicon.png') ?>">    
        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/admin.css') ?>">
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
                    <a class="brand" href="/main">CS Academia</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li class="<?php echo is_active($current_page, 'managment') ?> dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    Gestión
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
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
                                    <li class="<?php echo is_active($current_page, 'contact') ?>"><a href="/contact/edit">Contactos</a></li>
                                    <li class="<?php echo is_active($current_page, 'qualification') ?>"><a href="/admin/qualification">Calif.</a></li>
                                </ul>
                            </li>
                            <li class="<?php echo is_active($current_page, 'reports') ?>"><a href="/manager/main">Informes</a></li>
                            <li class="<?php echo is_active($current_page, 'billing') ?>"><a href="/manager/main">Facturación</a></li>
                            <li class="<?php echo is_active($current_page, 'tools') ?>"><a href="/manager/main">Herramientas</a></li>
                            <li class="<?php echo is_active($current_page, 'help') ?>"><a href="/manager/main">Ayuda</a></li>
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
                            <li class="<?php echo is_active($current_page, 'help') ?> pull-right"><a href="/close">Salir</a></li>
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