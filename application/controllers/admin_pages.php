<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para las páginas de administración que no requieren mucho 
 * procesamiento, del lado del servidor.
 *
 * @author Carlos Bello
 */
class Admin_pages extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!isLogged()) {
            redirect('denied');
            exit;
        }
        $this->load->library('grocery_CRUD');
    }

    public function client() {
        $this->current_page();       

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('client');
        $crud->set_subject('Cliente');
        $crud->columns('id', 'name');
        $crud->display_as('id', 'Código')
                ->display_as('name', 'Nombre');

        $crud->required_fields('name');
        $crud->fields('name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Cientes";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }

    public function role() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('role');
        $crud->set_subject('Rol');
        $crud->columns('code', 'description');
        $crud->display_as('code', 'Código')
                ->display_as('description', 'Descripción');

        $crud->required_fields('code', 'description');
        $crud->fields('code', 'description');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Roles";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }

    public function user() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('login');
        $crud->set_subject('Usuario');
        $crud->columns('id', 'email', 'password', 'client_id', 'role_code');
        $crud->display_as('id', 'Código')
                ->display_as('email', 'Correo')
                ->display_as('password', 'Contraseña')
                ->display_as('client_id', 'Cliente')
                ->display_as('role_code', 'Rol');

        $crud->required_fields('email', 'password', 'client_id', 'role_code');
        $crud->fields('email', 'password', 'client_id', 'role_code');
        $crud->change_field_type('password', 'password');
        $crud->set_relation('client_id', 'client', 'name');
        $crud->set_relation('role_code', 'role', 'description');

        $crud->callback_edit_field('password', array($this, 'set_password_input_to_empty'));
        $crud->callback_add_field('password', array($this, 'set_password_input_to_empty'));
        $crud->callback_before_update(array($this, 'encrypt_password_callback'));

        $data = $crud->render();
        $data->title = lang('menu_admin');
        $data->description = "Usuarios";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }

    function encrypt_password_callback($post_array) {

        if (!empty($post_array['password'])) {
            $post_array['password'] = md5($post_array['password']);
        } else {
            unset($post_array['password']);
        }

        return $post_array;
    }

    function set_password_input_to_empty() {
        return "<input type='password' name='password' value='' />";
    }

    public function center() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('center');
        $crud->set_subject('Centro');
        $crud->columns('id', 'client_id', 'name');
        $crud->display_as('id', 'Código')
                ->display_as('client_id', 'Cliente')
                ->display_as('name', 'Nombre');

        $crud->required_fields('name');
        $crud->fields('client_id', 'name');
        $crud->set_relation('client_id', 'client', 'name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Centros";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }

    public function level() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('level');
        $crud->set_subject('Nivel');
        $crud->columns('code', 'description', 'price');
        $crud->display_as('code', 'Código')
                ->display_as('description', 'Descripción')
                ->display_as('price', 'Precio');

        $crud->required_fields('code', 'description', 'price');
        $crud->fields('code', 'description', 'price');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Niveles";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }

    public function family_relationship() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('family_relationship');
        $crud->set_subject('Familiar');
        $crud->columns('code', 'name');
        $crud->display_as('code', 'Código')
                ->display_as('name', 'Nombre');

        $crud->required_fields('code', 'name');
        $crud->fields('code', 'name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Familiares";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }

    public function contact() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('contact');
        $crud->set_subject('Contactos');
        $crud->columns('id', 'client', 'first_name', 'last_name', 'sex', 'email', 'phone_mobile', 'phone', 'picture', 'notes', 'address', 'postal_code', 'town', 'province', 'date_of_birth', 'occupation', 'id_card');
        $crud->display_as('id', 'Código')
                ->display_as('client', 'Cliente')
                ->display_as('first_name', 'Nombre')
                ->display_as('last_name', 'Apellidos')
                ->display_as('sex', 'Sexo')
                ->display_as('email', 'Correo')
                ->display_as('phone_mobile', 'Teléfono Movil')
                ->display_as('phone', 'Teléfono Fijo')
                ->display_as('picture', 'Foto')
                ->display_as('notes', 'Notas')
                ->display_as('address', 'Dircción')
                ->display_as('postal_code', 'Código Postal')
                ->display_as('town', 'Población')
                ->display_as('province', 'Provincia')
                ->display_as('date_of_birth', 'Fecha de Cumpleaños')
                ->display_as('occupation', 'Ocupación')
                ->display_as('id_card', 'id_card');

        $crud->required_fields('client', 'first_name', 'last_name', 'sex', 'email', 'phone_mobile', 'phone', 'picture', 'notes', 'address', 'postal_code', 'town', 'province', 'date_of_birth', 'occupation', 'id_card');
        $crud->fields('client', 'first_name', 'last_name', 'sex', 'email', 'phone_mobile', 'phone', 'picture', 'notes', 'address', 'postal_code', 'town', 'province', 'date_of_birth', 'occupation', 'id_card');
        $crud->set_field_upload('picture', 'assets/uploads/files/contact');
        $crud->change_field_type('notes', 'text');
        $crud->set_relation_n_n('client', 'contacts_by_client', 'client', 'contact_id', 'client_id', 'name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Contactos";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }
    
    public function  leave_reason() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('leave_reason');
        $crud->set_subject('Motivo Baja');
        $crud->columns('code', 'description');
        $crud->display_as('code', 'Código')
                ->display_as('description', 'Descripción');

        $crud->required_fields('code', 'description');
        $crud->fields('code', 'description');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Motivos Baja";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }
    
    public function classroom() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('classroom');
        $crud->set_subject('Aula');
        $crud->columns('id', 'center_id', 'capacity', 'notes', 'picture');
        $crud->display_as('id', 'Código')
                ->display_as('center_id', 'Centro')
                ->display_as('capacity', 'Capacidad')
                ->display_as('notes', 'Notas')
                ->display_as('picture', 'Foto');

        $crud->required_fields('center_id', 'capacity');
        $crud->fields('center_id', 'capacity', 'notes', 'picture');
        $crud->set_field_upload('picture', 'assets/uploads/files/classroom');
        $crud->set_relation('center_id', 'center', 'name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Aulas";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }
    
    public function teacher() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('teacher');
        $crud->set_subject('Profesor');
        $crud->columns('contact_id', 'center', 'title', 'cv', 'type', 'start_date', 'end_date', 'state', 'bank_account_format', 'bank_account_number');
        $crud->display_as('contact_id', 'Nombre')
                ->display_as('center', 'Centro')
                ->display_as('title', 'Titulación')
                ->display_as('cv', 'Curriculum')
                ->display_as('type', 'Tipo')
                ->display_as('start_date', 'Fecha Entrada')
                ->display_as('end_date', 'Fecha Salida')
                ->display_as('state', 'Estado')
                ->display_as('bank_account_format', 'Forma Pago')
                ->display_as('bank_account_number', 'Cuenta bancaria');

        $crud->required_fields('contact_id', 'center', 'title', 'cv', 'type', 'start_date', 'end_date', 'state', 'bank_account_format', 'bank_account_number');
        $crud->fields('contact_id', 'center', 'title', 'cv', 'type', 'start_date', 'end_date', 'state', 'bank_account_format', 'bank_account_number');
        $crud->set_relation('contact_id', 'contact', '{first_name} {last_name}');
        $crud->set_relation_n_n('center', 'teachers_by_centers', 'center', 'teacher_id', 'center_id', 'name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Profesores";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }
    
    public function group() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('group');
        $crud->set_subject('Grupo');
        $crud->columns('id', 'name', 'center_id', 'classroom_id', 'teacher_id', 'level_code', 'academic_period', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'start_time', 'end_time');
        $crud->display_as('id', 'Código')
                ->display_as('name', 'Nombre')
                ->display_as('center_id', 'Centro')
                ->display_as('classroom_id', 'Aula')
                ->display_as('teacher_id', 'Profesor')
                ->display_as('level_code', 'Nivel')
                ->display_as('academic_period', 'Periodo')
                ->display_as('monday', 'Lunes')
                ->display_as('tuesday', 'Martes')
                ->display_as('wednesday', 'Miercoles')
                ->display_as('thursday', 'Jueves')
                ->display_as('friday', 'Viernes')
                ->display_as('saturday', 'Sabado')
                ->display_as('start_time', 'Hora Inicio')
                ->display_as('end_time', 'Hora Final');

        $crud->required_fields('name', 'center_id', 'classroom_id', 'teacher_id', 'level_code', 'academic_period', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'start_time', 'end_time');
        $crud->fields('name', 'center_id', 'classroom_id', 'teacher_id', 'level_code', 'academic_period', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'start_time', 'end_time');
        $crud->set_relation('center_id', 'center', 'name');
        $crud->set_relation('classroom_id', 'classroom', 'notes');
        $crud->set_relation('teacher_id', 'teacher', 'contact_id');
        $crud->set_relation('level_code', 'level', 'description');


        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Grupos";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }
    
    public function student() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('student');
        $crud->set_subject('Alumno');
        $crud->columns('contact_id', 'center_id', 'start_date', 'end_date', 'school_academic_period', 'school_name', 'language_years', 'pref_start_time', 'pref_end_time', 'current_academic_period', 'bank_account_format', 'bank_account_number', 'bank_account_holder', 'bank_payment', 'current_level_code', 'leave_reason_code');
        $crud->display_as('contact_id', 'Nombre')
                ->display_as('center_id', 'Centro')
                ->display_as('start_date', 'Fecha Incial')
                ->display_as('end_date', 'Ficha final')
                ->display_as('school_academic_period', 'Periodo Escuela')
                ->display_as('school_name', 'Escuela')
                ->display_as('language_years', 'Idioma Años')
                ->display_as('pref_start_time', 'Hora inicial Pref.')
                ->display_as('pref_end_time', 'Hora final Pref.')
                ->display_as('current_academic_period', 'Periodo Actual')
                ->display_as('bank_account_format', 'Formato cuenta')
                ->display_as('bank_account_number', 'Cuenta Bancaria')
                ->display_as('bank_account_holder', 'Titular cuenta')
                ->display_as('bank_payment', 'Pago bancario')
                ->display_as('current_level_code', 'Nivel')
                ->display_as('leave_reason_code', 'Motivo baja');

        $crud->required_fields('contact_id', 'center_id', 'start_date', 'end_date', 'school_academic_period', 'school_name', 'language_years', 'pref_start_time', 'pref_end_time', 'current_academic_period', 'bank_account_format', 'bank_account_number', 'bank_account_holder', 'bank_payment', 'current_level_code', 'leave_reason_code', 'group');
        $crud->fields('contact_id', 'center_id', 'start_date', 'end_date', 'school_academic_period', 'school_name', 'language_years', 'pref_start_time', 'pref_end_time', 'current_academic_period', 'bank_account_format', 'bank_account_number', 'bank_account_holder', 'bank_payment', 'current_level_code', 'leave_reason_code', 'group');
        $crud->set_relation('contact_id', 'contact', '{first_name} {last_name}');
        $crud->set_relation('center_id', 'center', 'name');
        $crud->set_relation('current_level_code', 'level', 'description');
        $crud->set_relation('leave_reason_code', 'leave_reason', 'description');
        $crud->set_relation_n_n('group', 'students_by_groups', 'group', 'student_id', 'groups_id', 'name');        

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Alumnos";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }

    public function qualification() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('qualification');
        $crud->set_subject('Calificación');
        $crud->columns('student_id', 'academic_period', 'description', 'qualification', 'trinity', 'longon', 'others', 'eval1', 'eval2', 'eval2');
        $crud->display_as('student_id', 'Alumno')
                ->display_as('academic_period', 'Periodo')
                ->display_as('description', 'Descripción')
                ->display_as('qualification', 'Calificación')
                ->display_as('trinity', 'Trinity')
                ->display_as('longon', 'Longon')
                ->display_as('others', 'Otros')
                ->display_as('eval1', 'Eval1')
                ->display_as('eval2', 'Eval2')
                ->display_as('eval3', 'Eval3');

        $crud->required_fields('student_id', 'academic_period', 'description', 'qualification', 'trinity', 'longon', 'others', 'eval1', 'eval2', 'eval2');
        $crud->fields('student_id', 'academic_period', 'description', 'qualification', 'trinity', 'longon', 'others', 'eval1', 'eval2', 'eval2');
        $crud->set_relation('student_id', 'contact', '{first_name} {last_name}'); 

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_admin');
        $data->description = "Calificaciones";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }

}

/* End of file grocery_pages.php */
/* Location: ./application/controllers/admin_pages.php */
