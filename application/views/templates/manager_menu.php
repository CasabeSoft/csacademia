<?php
$current_page = $this->uri->segment(2);

function is_active($current_page, $page_name = 'user') {
    return $current_page == $page_name ? 'active' : '';
}
/*
function is_active($current_page, $page_name = 'main') {
    return $current_page == $page_name ? 'active' : '';
}
 */
?>
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
                            <li class="<?php echo is_active($current_page, 'client') ?>"><a href="/crud/client">Clientes</a></li>
                            <li class="<?php echo is_active($current_page, 'role') ?>"><a href="/crud/role">Roles</a></li>                          
                            <li class="<?php echo is_active($current_page, 'center') ?>"><a href="/crud/center">Centros</a></li>
                            <li class="<?php echo is_active($current_page, 'level') ?>"><a href="/crud/level">Niveles</a></li>
                            <li class="<?php echo is_active($current_page, 'family_relationship') ?>"><a href="/crud/family_relationship">Parent.</a></li>
                            <li class="<?php echo is_active($current_page, 'leave_reason') ?>"><a href="/crud/leave_reason">M. Baja</a></li>
                            <li class="<?php echo is_active($current_page, 'classroom') ?>"><a href="/crud/classroom">Aulas</a></li>
                            <li class="<?php echo is_active($current_page, 'group') ?>"><a href="/crud/group">Grupos</a></li>
                            <li class="<?php echo is_active($current_page, 'user') ?>"><a href="/crud/user">Usuarios</a></li>
                            <li class="<?php echo is_active($current_page, 'teacher') ?>"><a href="/crud/teacher">Prof.</a></li>
                            <li class="<?php echo is_active($current_page, 'student') ?>"><a href="/crud/student">Alumnos</a></li>
                            <li class="<?php echo is_active($current_page, 'contact') ?>"><a href="/contact/edit">Contactos</a></li>
                            <li class="<?php echo is_active($current_page, 'qualification') ?>"><a href="/crud/qualification">Calif.</a></li>
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