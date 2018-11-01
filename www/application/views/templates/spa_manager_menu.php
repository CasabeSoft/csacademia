<?php
// @codingStandardsIgnoreFile PSR1.Files.SideEffects
$current_page = $this->uri->segment(2);
$current_controller = $this->uri->segment(1);

function is_active($current_page, $page_name = 'user')
{
    return $current_page == $page_name ? 'active' : '';
}

function is_controller_active($current_controller, $controller_name = 'admin')
{
    return $current_controller == $controller_name ? 'active' : '';
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainMenu">
                <span class="sr-only">Ocultar</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/tools/tasks"><img src="/assets<?php echo $client_theme?>/img/logo_xs.png" class="logo"></a>
        </div>
        
        <div id="mainMenu" class="collapse navbar-collapse">
            <ul class="nav navbar-nav menu-font">
                <li class="<?php echo is_controller_active($current_controller, 'catalog') ?> dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <?php echo lang('menu_catalog'); ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <?php if ($this->role_id == ROLE_ADMINISTRATOR) { ?>
                            <li class="<?php echo is_active($current_page, 'client') ?>"><a href="/catalog/client"><?php echo lang('menu_client'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'role') ?>"><a href="/catalog/role"><?php echo lang('menu_role'); ?></a></li> 
                            <li class="<?php echo is_active($current_page, 'teacher') ?>"><a href="/catalog/teacher"><?php echo lang('menu_teacher'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'student') ?>"><a href="/catalog/student"><?php echo lang('menu_student'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'contact') ?>"><a href="/catalog/contact"><?php echo lang('menu_contacts'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'qualification') ?>"><a href="/catalog/qualification"><?php echo lang('menu_qualification'); ?></a></li>
                            <!--li class="<?php echo is_active($current_page, 'students_by_groups') ?>"><a href="/catalog/students_by_groups"><?php //echo lang('menu_student') . ' / ' . lang('menu_group');   ?></a></li-->
                            <li class="<?php echo is_active($current_page, 'payment') ?>"><a href="/catalog/payment"><?php echo lang('menu_payment'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'task_type') ?>"><a href="/catalog/task_type"><?php echo lang('menu_task_type'); ?></a></li>
                            <li class="<?php echo is_active($current_page, 'task') ?>"><a href="/catalog/task"><?php echo lang('menu_tasks'); ?></a></li>
                        <?php } ?>
                        <li class="<?php echo is_active($current_page, 'center') ?>"><a href="/catalog/center"><?php echo lang('menu_center'); ?></a></li>
                        <li class="<?php echo is_active($current_page, 'level') ?>"><a href="/catalog/level"><?php echo lang('menu_level'); ?></a></li>
                        <li class="<?php echo is_active($current_page, 'classroom') ?>"><a href="/catalog/classroom"><?php echo lang('menu_classroom'); ?></a></li>
                        <li class="<?php echo is_active($current_page, 'academic_period') ?>"><a href="/catalog/academic_period"><?php echo lang('menu_academic_period'); ?></a></li>
                        <li class="<?php echo is_active($current_page, 'leave_reason') ?>"><a href="/catalog/leave_reason"><?php echo lang('menu_leave_reason'); ?></a></li>
                        <li class="<?php echo is_active($current_page, 'family_relationship') ?>"><a href="/catalog/family_relationship"><?php echo lang('menu_family_relationship'); ?></a></li>
                        <li class="<?php echo is_active($current_page, 'school_level') ?>"><a href="/catalog/school_level"><?php echo lang('menu_school_level'); ?></a></li>   
                        <li class="<?php echo is_active($current_page, 'payment_type') ?>"><a href="/catalog/payment_type"><?php echo lang('menu_payment_type'); ?></a></li> 
                        <li class="<?php echo is_active($current_page, 'group') ?>"><a href="/catalog/group"><?php echo lang('menu_group'); ?></a></li>                           
                        <li class="<?php echo is_active($current_page, 'task_importance') ?>"><a href="/catalog/task_importance"><?php echo lang('menu_task_importance'); ?></a></li>
                        <li class="<?php echo is_active($current_page, 'task_state') ?>"><a href="/catalog/task_state"><?php echo lang('menu_task_state'); ?></a></li>
                        <?php if ($this->role_id == ROLE_ADMINISTRATOR || $this->role_id == ROLE_MANAGER) { ?>
                            <li class="<?php echo is_active($current_page, 'user') ?>"><a href="/catalog/user"><?php echo lang('menu_user'); ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="<?php echo is_controller_active($current_controller, 'manage') ?> dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <?php echo lang('menu_management'); ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <?php if ($this->role_id == ROLE_ADMINISTRATOR) { ?>
                            <li class="<?php echo is_active($current_page, 'contact') ?>"><a href="/manage/contact"><?php echo lang('menu_contacts'); ?></a></li>                            
                        <?php } ?>
                        <li class="<?php echo is_active($current_page, 'teacher') ?>"><a href="/manage/teacher"><?php echo lang('menu_teacher'); ?></a></li>
                        <li class="<?php echo is_active($current_page, 'student') ?>"><a href="/manage/student"><?php echo lang('menu_student'); ?></a></li>
                        <li class="<?php echo is_active($current_page, 'group') ?>"><a href="/manage/group"><?php echo lang('menu_group'); ?></a></li>
                    </ul>
                </li>
                <li class="<?php echo is_controller_active($current_controller, 'report') ?> dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <?php echo lang('menu_reports'); ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="<?php echo is_active($current_page, 'birthday') ?>"><a href="/report/birthday"><?php echo lang('menu_birthdays'); ?></a></li>
                        <?php if ($this->role_id == ROLE_ADMINISTRATOR || $this->role_id == ROLE_MANAGER) { ?>
                            <li class="<?php echo is_active($current_page, 'payments') ?>"><a href="/report/payments"><?php echo lang('menu_payment'); ?></a></li>
                        <?php } ?>
                        <li class="<?php echo is_active($current_page, 'payments_bank') ?>"><a href="/report/payments_bank"><?php echo lang('menu_payment_bank'); ?></a></li>
                        <li class="<?php echo is_active($current_page, 'attendance') ?>"><a href="/report/attendance"><?php echo lang('menu_assistance'); ?></a></li>
                    </ul>
                </li>
                <li class="<?php echo is_controller_active($current_controller, 'tools') ?> dropdown" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php echo lang('menu_tools'); ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="<?php echo is_active($current_page, 'tasks') ?>"><a href="/tools/tasks"><?php echo lang('menu_tasks'); ?></a></li>    
                        <li class="<?php echo is_active($current_page, 'bulk_operations') ?> dropdown-header"><a href="/tools/bulk_operations"><?php echo lang('menu_bulk_operations'); ?></a></li>    
                        <li><a href="/tools/bulk_operations/#/email"><?php echo lang('menu_bulk_email'); ?></a></li>    
                        <li><a href="/tools/bulk_operations/#/sms"><?php echo lang('menu_bulk_sms'); ?></a></li>    
                    </ul>
                </li>
                <li class="<?php echo is_controller_active($current_controller, 'help') ?> dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php echo lang('menu_help'); ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="<?php echo is_active($current_page, 'help') ?>"><a href="/help/about"><?php echo lang('menu_about'); ?></a></li>    
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><!-- currentSchool -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <?php echo lang('subject_center') . ": " . $this->session->userdata('current_center')['name']; ?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo site_url('/manager/change_to_center/NULL') ?>"><?php echo lang('filter_all') ?></a></li>
                        <?php
                        foreach ($this->centers as $center) {
                            $menuClass = $this->session->userdata('current_center')['id'] == $center['id'] ? 'selected' : '';
                            ?>
                            <li class="<?php echo $menuClass?>">
                                <a href="<?php echo site_url('/manager/change_to_center/' . $center['id']) ?>"><?php echo $center['name'] ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>     <!-- /currentSchool -->               
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <img src="/assets/img/personal.png" class="profilePhoto small">
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="disabled">
                            <a href="#"><img tabindex="-1" src="/assets/img/personal.png" class="profilePhoto medium">
                            </a>
                        </li>
                        <li class="disabled">
                            <a href="#"><span><?php echo $this->session->userdata('email'); ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="/change_password"><?php echo lang('menu_change_password'); ?></a>
                        </li>
                        <li>
                            <a href="/profile"><?php echo lang('menu_profile'); ?></a>
                        </li>
                        <li class="divider"></li>
                        <li class="dropdown-header"><?php echo lang('menu_lang'); ?></li>
                        <li class="<?php echo $this->session->userdata('lang') == 'es' ? 'selected' : '' ?>"><a href="<?php echo site_url('lang/es') ?>"><?php echo lang('menu_lang_es'); ?></a></li>
                        <li class="<?php echo $this->session->userdata('lang') == 'en' ? 'selected' : '' ?>"><a href="<?php echo site_url('lang/en') ?>"><?php echo lang('menu_lang_en'); ?></a></li>
                        <?php if ($this->role_id == ROLE_ADMINISTRATOR) { ?>
                            <li class="divider"></li>
                            <li class="dropdown-header"><?php echo lang('menu_see_as_client') ?></li>
                            <?php
                            $clients = $this->db->select('id, name')->from('client')->get()->result_array();
                            $client_id = $this->session->userdata('client_id');
                            foreach ($clients as $client) { ?>
                                <li class="<?php echo $client_id == $client['id'] ? 'selected' : '' ?>"><a href="/manager/change_to_client/<?php echo $client['id'] ?>"><?php echo $client['name'] ?></a></li>
                            <?php } ?>
                        <?php } ?>
                        <li class="divider"></li>
                        <li>
                            <a href="/close"><?php echo lang('menu_close'); ?></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
