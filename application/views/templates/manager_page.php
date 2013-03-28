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
                            <li class="<?php echo is_active($current_page, 'management') ?> dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo lang('menu_management'); ?>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <!--li class="<?php echo is_active($current_page, 'client') ?>"><a href="/admin/client"><?php echo lang('menu_client'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'role') ?>"><a href="/admin/role"><?php echo lang('menu_role'); ?></a></li-->                          
                                    <li class="<?php echo is_active($current_page, 'center') ?>"><a href="/admin/center"><?php echo lang('menu_center'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'level') ?>"><a href="/admin/level"><?php echo lang('menu_level'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'family_relationship') ?>"><a href="/admin/family_relationship"><?php echo lang('menu_family_relationship'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'leave_reason') ?>"><a href="/admin/leave_reason"><?php echo lang('menu_leave_reason'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'classroom') ?>"><a href="/admin/classroom"><?php echo lang('menu_classroom'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'group') ?>"><a href="/admin/group"><?php echo lang('menu_group'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'user') ?>"><a href="/admin/user"><?php echo lang('menu_user'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'teacher') ?>"><a href="/admin/teacher"><?php echo lang('menu_teacher'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'student') ?>"><a href="/admin/student"><?php echo lang('menu_student'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'contact') ?>"><a href="/contact/edit"><?php echo lang('menu_contact'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'qualification') ?>"><a href="/admin/qualification"><?php echo lang('menu_qualification'); ?></a></li>
                                </ul>
                            </li>
                            <li class="<?php echo is_active($current_page, 'reports') ?>"><a href="/manager/main"><?php echo lang('menu_reports'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'billing') ?>"><a href="/manager/main"><?php echo lang('menu_billing'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'tools') ?>"><a href="/manager/main"><?php echo lang('menu_tools'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'help') ?>"><a href="/manager/main"><?php echo lang('menu_help'); ?></a></li>
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
                            <li class="<?php echo is_active($current_page, 'close') ?> pull-right"><a href="/close"><?php echo lang('menu_close'); ?></a></li>
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