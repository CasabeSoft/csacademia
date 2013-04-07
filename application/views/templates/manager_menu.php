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
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="/manager/main">CS Academia</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="<?php echo is_controller_active($current_controller, 'admin') ?> dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo lang('menu_management'); ?>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if ($this->role_id === ROLE_ADMINISTRATOR) { ?>
                                <li class="<?php echo is_active($current_page, 'client') ?>"><a href="/admin/client"><?php echo lang('menu_client'); ?></a></li>
                                <li class="<?php echo is_active($current_page, 'role') ?>"><a href="/admin/role"><?php echo lang('menu_role'); ?></a></li>   
                            <?php } ?>
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
                            <li class="<?php echo is_active($current_page, 'academic_period') ?>"><a href="/admin/academic_period"><?php echo lang('menu_academic_period'); ?></a></li>
                        </ul>
                    </li>
                    <li class="<?php echo is_controller_active($current_controller, 'reports') ?>"><a href="/manager/main"><?php echo lang('menu_reports'); ?></a></li>
                    <li class="<?php echo is_controller_active($current_controller, 'billing') ?>"><a href="/manager/main"><?php echo lang('menu_billing'); ?></a></li>
                    <li class="<?php echo is_controller_active($current_controller, 'tools') ?>"><a href="/manager/main"><?php echo lang('menu_tools'); ?></a></li>
                    <li class="<?php echo is_controller_active($current_controller, 'help') ?>"><a href="/manager/main"><?php echo lang('menu_help'); ?></a></li>
                </ul>
                <ul class="nav pull-right">
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
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img width="20px" height="20px" src="../assets/img/personal.png">
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <div class="well-small" >
                                <div class="">
                                    <img width="70px" height="70px" src="../assets/img/personal.png">
                                </div>
                                <div class="">
                                    <?php echo $this->session->userdata('email'); ?>
                                    <br>
                                    <a class="" href="/change_password"><?php echo lang('menu_change_password'); ?></a>
                                    <a class="btn" href="/profile"><?php echo lang('menu_profile'); ?></a>
                                    <a class="btn pull-right" href="/close"><?php echo lang('menu_close'); ?></a>
                                </div>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>