<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para orperaciones generales de gestión (CRUD). 
 *
 * @author Carlos Bello
 * @author Leonardo Quintero
 */
class Crud extends Basic_controller {
    private $crud;
    var $crud_view;
    
    public function __construct() {
        parent::__construct();
        if (!isLogged()) {
            redirect('denied');
            exit;
        }
        $this->load->library('grocery_CRUD');
        $this->template = 'templates/crud_template';
        $this->description = 'Página de administración general';
        $this->crud = new grocery_CRUD();
        $this->crud->set_language($this->lang_folder);
        $this->crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $this->current_page();
    }

    public function load_page() {
        $this->load->view($this->template, $this);
    }
    
    protected function set_page_title($title = '') {
        $this->page_header = lang($title);
        $this->title = "CasabeSoft Academia - " . $this->page_header;
    }
    
    public function client() {
        $this->set_page_title('page_manage_clients');

        $this->crud->set_table('client');
        $this->crud->set_subject('Cliente');
        $this->crud->columns('id', 'name');
        $this->crud->display_as('id', 'Código')
                    ->display_as('name', 'Nombre');
        $this->crud->required_fields('name');
        $this->crud->fields('name');
        $this->crud_view = $this->crud->render();
        
        $this->load_page();
    }

    public function role() {
        $this->set_page_title('page_manage_roles');

        $this->crud->set_table('role');
        $this->crud->set_subject('Rol');
        $this->crud->columns('code', 'description');
        $this->crud->display_as('code', 'Código')
                ->display_as('description', 'Descripción');
        $this->crud->required_fields('code', 'description');
        $this->crud->fields('code', 'description');
        $this->crud_view = $this->crud->render();
        
        $this->load_page();
    }

    public function user() {
        $this->set_page_title('page_manage_users');

        $this->crud->set_table('login');
        $this->crud->set_subject('Usuario');
        $this->crud->columns('id', 'email', 'password', 'client_id', 'role_code');
        $this->crud->display_as('id', 'Código')
                ->display_as('email', 'Correo')
                ->display_as('password', 'Contraseña')
                ->display_as('client_id', 'Cliente')
                ->display_as('role_code', 'Rol');

        $this->crud->required_fields('email', 'password', 'client_id', 'role_code');
        $this->crud->fields('email', 'password', 'client_id', 'role_code');
        $this->crud->change_field_type('password', 'password');
        $this->crud->set_relation('client_id', 'client', 'name');
        $this->crud->set_relation('role_code', 'role', 'description');

        $this->crud->callback_edit_field('password', array($this, 'set_password_input_to_empty'));
        $this->crud->callback_add_field('password', array($this, 'set_password_input_to_empty'));
        $this->crud->callback_before_update(array($this, 'encrypt_password_callback'));

        $this->crud_view = $this->crud->render();
        $this->load_page();
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
        $this->set_page_title('page_manage_centers');

        $this->crud->set_table('center');
        $this->crud->set_subject('Centro');
        $this->crud->columns('id', 'client_id', 'name');
        $this->crud->display_as('id', 'Código')
                ->display_as('client_id', 'Cliente')
                ->display_as('name', 'Nombre');

        $this->crud->required_fields('name');
        $this->crud->fields('client_id', 'name');
        $this->crud->set_relation('client_id', 'client', 'name');

        $this->crud_view = $this->crud->render();
        $this->load_page();
    }

    public function level() {
        $this->set_page_title('page_manage_levels');

        $this->crud->set_table('level');
        $this->crud->set_subject('Nivel');
        $this->crud->columns('code', 'description', 'price');
        $this->crud->display_as('code', 'Código')
                ->display_as('description', 'Descripción')
                ->display_as('price', 'Precio');

        $this->crud->required_fields('code', 'description', 'price');
        $this->crud->fields('code', 'description', 'price');

        $this->crud_view = $this->crud->render();
        $this->load_page();
    }

    public function family_relationship() {
        $this->set_page_title('page_manage_relationships');

        $this->crud->set_table('family_relationship');
        $this->crud->set_subject('Familiar');
        $this->crud->columns('code', 'name');
        $this->crud->display_as('code', 'Código')
                ->display_as('name', 'Nombre');

        $this->crud->required_fields('code', 'name');
        $this->crud->fields('code', 'name');

        $this->crud_view = $this->crud->render();
        $this->load_page();
    }

    public function contact() {
        $this->set_page_title('page_manage_contacts');

        $this->crud->set_table('contact');
        $this->crud->set_subject('Contactos');
        $this->crud->columns('id', 'client', 'first_name', 'last_name', 'sex', 'email', 'phone_mobile', 'phone', 'picture', 'notes', 'address', 'postal_code', 'town', 'province', 'date_of_birth', 'occupation', 'id_card');
        $this->crud->display_as('id', 'Código')
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

        $this->crud->required_fields('client', 'first_name', 'last_name', 'sex', 'email', 'phone_mobile', 'phone', 'picture', 'notes', 'address', 'postal_code', 'town', 'province', 'date_of_birth', 'occupation', 'id_card');
        $this->crud->fields('client', 'first_name', 'last_name', 'sex', 'email', 'phone_mobile', 'phone', 'picture', 'notes', 'address', 'postal_code', 'town', 'province', 'date_of_birth', 'occupation', 'id_card');
        $this->crud->set_field_upload('picture', 'assets/uploads/files/contact');
        $this->crud->change_field_type('notes', 'text');
        $this->crud->set_relation_n_n('client', 'contacts_by_client', 'client', 'contact_id', 'client_id', 'name');

        $this->crud_view = $this->crud->render();
        $this->load_page();
    }
    
    public function  leave_reason() {
        $this->set_page_title('page_manage_leave_reasonss');

        $this->crud->set_table('leave_reason');
        $this->crud->set_subject('Motivo Baja');
        $this->crud->columns('code', 'description');
        $this->crud->display_as('code', 'Código')
                ->display_as('description', 'Descripción');

        $this->crud->required_fields('code', 'description');
        $this->crud->fields('code', 'description');

        $this->crud_view = $this->crud->render();
        $this->load_page();
    }
    
    public function classroom() {
        $this->set_page_title('page_manage_classrooms');

        $this->crud->set_table('classroom');
        $this->crud->set_subject('Aula');
        $this->crud->columns('id', 'center_id', 'capacity', 'notes', 'picture');
        $this->crud->display_as('id', 'Código')
                ->display_as('center_id', 'Centro')
                ->display_as('capacity', 'Capacidad')
                ->display_as('notes', 'Notas')
                ->display_as('picture', 'Foto');

        $this->crud->required_fields('center_id', 'capacity');
        $this->crud->fields('center_id', 'capacity', 'notes', 'picture');
        $this->crud->set_field_upload('picture', 'assets/uploads/files/classroom');
        $this->crud->set_relation('center_id', 'center', 'name');

        $this->crud_view = $this->crud->render();
        $this->load_page();
    }
    
    public function teacher() {
        $this->set_page_title('page_manage_teachers');
        
        $this->crud->set_table('teacher');
        $this->crud->set_subject('Profesor');
        $this->crud->columns('contact_id', 'center', 'title', 'cv', 'type', 'start_date', 'end_date', 'state', 'bank_account_format', 'bank_account_number');
        $this->crud->display_as('contact_id', 'Nombre')
                ->display_as('center', 'Centro')
                ->display_as('title', 'Titulación')
                ->display_as('cv', 'Curriculum')
                ->display_as('type', 'Tipo')
                ->display_as('start_date', 'Fecha Entrada')
                ->display_as('end_date', 'Fecha Salida')
                ->display_as('state', 'Estado')
                ->display_as('bank_account_format', 'Forma Pago')
                ->display_as('bank_account_number', 'Cuenta bancaria');

        $this->crud->required_fields('contact_id', 'center', 'title', 'cv', 'type', 'start_date', 'end_date', 'state', 'bank_account_format', 'bank_account_number');
        $this->crud->fields('contact_id', 'center', 'title', 'cv', 'type', 'start_date', 'end_date', 'state', 'bank_account_format', 'bank_account_number');
        $this->crud->set_relation('contact_id', 'contact', '{first_name} {last_name}');
        $this->crud->set_relation_n_n('center', 'teachers_by_centers', 'center', 'teacher_id', 'center_id', 'name');

        $this->crud_view = $this->crud->render();
        $this->load_page();
    }
    
    public function group() {
        $this->set_page_title('page_manage_groups');

        $this->crud->set_table('group');
        $this->crud->set_subject('Grupo');
        $this->crud->columns('id', 'name', 'center_id', 'classroom_id', 'teacher_id', 'level_code', 'academic_period', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'start_time', 'end_time');
        $this->crud->display_as('id', 'Código')
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

        $this->crud->required_fields('name', 'center_id', 'classroom_id', 'teacher_id', 'level_code', 'academic_period', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'start_time', 'end_time');
        $this->crud->fields('name', 'center_id', 'classroom_id', 'teacher_id', 'level_code', 'academic_period', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'start_time', 'end_time');
        $this->crud->set_relation('center_id', 'center', 'name');
        $this->crud->set_relation('classroom_id', 'classroom', 'notes');
        $this->crud->set_relation('teacher_id', 'teacher', 'contact_id');
        $this->crud->set_relation('level_code', 'level', 'description');
        
        $this->crud_view = $this->crud->render();        
        $this->load_page();
    }
    
    public function student() {
        $this->set_page_title('page_manage_students');
        
        $this->crud->set_table('student');
        $this->crud->set_subject('Alumno');
        $this->crud->columns('contact_id', 'center_id', 'start_date', 'end_date', 'school_academic_period', 'school_name', 'language_years', 'pref_start_time', 'pref_end_time', 'current_academic_period', 'bank_account_format', 'bank_account_number', 'bank_account_holder', 'bank_payment', 'current_level_code', 'leave_reason_code');
        $this->crud->display_as('contact_id', 'Nombre')
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

        $this->crud->required_fields('contact_id', 'center_id', 'start_date', 'end_date', 'school_academic_period', 'school_name', 'language_years', 'pref_start_time', 'pref_end_time', 'current_academic_period', 'bank_account_format', 'bank_account_number', 'bank_account_holder', 'bank_payment', 'current_level_code', 'leave_reason_code', 'group');
        $this->crud->fields('contact_id', 'center_id', 'start_date', 'end_date', 'school_academic_period', 'school_name', 'language_years', 'pref_start_time', 'pref_end_time', 'current_academic_period', 'bank_account_format', 'bank_account_number', 'bank_account_holder', 'bank_payment', 'current_level_code', 'leave_reason_code', 'group');
        $this->crud->set_relation('contact_id', 'contact', '{first_name} {last_name}');
        $this->crud->set_relation('center_id', 'center', 'name');
        $this->crud->set_relation('current_level_code', 'level', 'description');
        $this->crud->set_relation('leave_reason_code', 'leave_reason', 'description');
        $this->crud->set_relation_n_n('group', 'students_by_groups', 'group', 'student_id', 'groups_id', 'name');        

        $this->crud_view = $this->crud->render();        
        $this->load_page();
    }

    public function qualification() {
        $this->set_page_title('page_manage_qualifications');

        $this->crud->set_table('qualification');
        $this->crud->set_subject('Calificación');
        $this->crud->columns('student_id', 'academic_period', 'description', 'qualification', 'trinity', 'longon', 'others', 'eval1', 'eval2', 'eval2');
        $this->crud->display_as('student_id', 'Alumno')
                ->display_as('academic_period', 'Periodo')
                ->display_as('description', 'Descripción')
                ->display_as('qualification', 'Calificación')
                ->display_as('trinity', 'Trinity')
                ->display_as('longon', 'Longon')
                ->display_as('others', 'Otros')
                ->display_as('eval1', 'Eval1')
                ->display_as('eval2', 'Eval2')
                ->display_as('eval3', 'Eval3');

        $this->crud->required_fields('student_id', 'academic_period', 'description', 'qualification', 'trinity', 'longon', 'others', 'eval1', 'eval2', 'eval2');
        $this->crud->fields('student_id', 'academic_period', 'description', 'qualification', 'trinity', 'longon', 'others', 'eval1', 'eval2', 'eval2');
        $this->crud->set_relation('student_id', 'contact', '{first_name} {last_name}'); 

        $this->crud_view = $this->crud->render();        
        $this->load_page();
    }
}

/* End of file crud.php */
/* Location: ./application/controllers/crud.php */
