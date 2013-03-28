<?php
$current_page = $this->uri->segment(2);
$current_controller = $this->uri->segment(1);

function is_active($current_page, $page_name = 'user') {
    return $current_page == $page_name ? 'active' : '';
}
function is_controller_active($current_controller, $controller_name = 'admin') {
    return $current_controller == $controller_name ? 'active' : '';
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

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo site_url('assets/lib/html5shiv/3.6.2-6/html5shiv.js') ?>"></script>
        <![endif]-->

        <!-- Start page style -->
        <?php
        if (isset($css_files)) {
            foreach ($css_files as $file):
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
                            <li class="<?php echo  is_controller_active($current_controller, 'admin') ?> dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo lang('menu_management'); ?>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="<?php echo is_active($current_page, 'client') ?>"><a href="/admin/client"><?php echo lang('menu_client'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'role') ?>"><a href="/admin/role"><?php echo lang('menu_role'); ?></a></li>                          
                                    <li class="<?php echo is_active($current_page, 'center') ?>"><a href="/admin/center"><?php echo lang('menu_center'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'level') ?>"><a href="/admin/level"><?php echo lang('menu_level'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'family_relationship') ?>"><a href="/admin/family_relationship"><?php echo lang('menu_family_relationship'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'leave_reason') ?>"><a href="/admin/leave_reason"><?php echo lang('menu_leave_reason'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'classroom') ?>"><a href="/admin/classroom"><?php echo lang('menu_classroom'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'group') ?>"><a href="/admin/group"><?php echo lang('menu_group'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'user') ?>"><a href="/admin/user"><?php echo lang('menu_user'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'teacher') ?>"><a href="/admin/teacher"><?php echo lang('menu_teacher'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'student') ?>"><a href="/admin/student"><?php echo lang('menu_student'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'contact') ?>"><a href="/admin/contact"><?php echo lang('menu_contact'); ?></a></li>
                                    <li class="<?php echo is_active($current_page, 'qualification') ?>"><a href="/admin/qualification"><?php echo lang('menu_qualification'); ?></a></li>
                                </ul>
                            </li>
                            
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
                            <li class="<?php echo is_active($current_page, 'close') ?>"><a href="/close"><?php echo lang('menu_close'); ?></a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <!-- Start page content -->
        <br>
        <div class="well">
            <h2><?php echo $title_table; ?></h2>
            <?php $this->load->view($view_to_load) ?>
        </div>
        <!-- End page content -->

        <script src="<?php echo site_url('assets/lib/jquery/1.9.1/jquery.min.js') ?>"></script>
        <script src="<?php echo site_url('assets/lib/bootstrap/2.3.1/js/bootstrap.min.js') ?>"></script>        
        <!-- Start page scripts -->
        <?php
        if (isset($js_files)) {
            foreach ($js_files as $file):
                ?>
                <script src="<?php echo $file; ?>"></script>
                <?php
            endforeach;
        }
        ?>
        <!-- End page scripts -->
    </body>
</html>