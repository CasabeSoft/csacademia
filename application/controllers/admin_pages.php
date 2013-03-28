<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para las páginas de administración que no requieren mucho 
 * procesamiento, del lado del servidor.
 *
 * @author Carlos Bello
 * @author Leonardo Quintero
 */
class Admin_pages extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!isLogged()) {
            redirect('/denied');
            exit;
        }
        $this->load->library('grocery_CRUD');
    }

    public function client() {
        $this->current_page();
        //$rol = $this->session->userdata('role_id');

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('client');
        $crud->set_subject(lang('subject_client'));
        $crud->columns('id', 'name');
        $crud->display_as('id', lang('form_id'))
                ->display_as('name', lang('form_name'));

        $crud->required_fields('name');
        $crud->fields('name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_client');
        $data->title_table = lang('menu_client');
        $data->description = "Clientes";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }

    public function role() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('role');
        $crud->set_subject(lang('subject_role'));
        $crud->columns('code', 'description');
        $crud->display_as('code', lang('form_id'))
                ->display_as('description', lang('form_description'));

        $crud->required_fields('code', 'description');
        $crud->fields('code', 'description');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_role');
        $data->title_table = lang('menu_role');
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
        $crud->set_subject(lang('subject_user'));
        $crud->columns('id', 'email', 'password', 'client_id', 'role_code');
        $crud->display_as('id', lang('form_id'))
                ->display_as('email', lang('form_email'))
                ->display_as('password', lang('form_password'))
                ->display_as('client_id', lang('form_client'))
                ->display_as('role_code', lang('form_role'));

        $crud->required_fields('email', 'password', 'client_id', 'role_code');
        $crud->fields('email', 'password', 'client_id', 'role_code');
        $crud->change_field_type('password', 'password');
        $crud->set_relation('client_id', 'client', 'name');
        $crud->set_relation('role_code', 'role', 'description');

        $crud->callback_edit_field('password', array($this, 'set_password_input_to_empty'));
        $crud->callback_add_field('password', array($this, 'set_password_input_to_empty'));
        $crud->callback_before_update(array($this, 'encrypt_password_callback'));

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_user');
        $data->title_table = lang('menu_user');
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
        $crud->set_subject(lang('subject_center'));
        $crud->columns('id', 'client_id', 'name');
        $crud->display_as('id', lang('form_id'))
                ->display_as('client_id', lang('form_client'))
                ->display_as('name', lang('form_name'));

        $crud->required_fields('name');
        $crud->fields('client_id', 'name');
        $crud->set_relation('client_id', 'client', 'name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_center');
        $data->title_table = lang('menu_center');
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
        $crud->set_subject(lang('subject_level'));
        $crud->columns('code', 'description', 'price');
        $crud->display_as('code', lang('form_id'))
                ->display_as('description', lang('form_description'))
                ->display_as('price', lang('form_price'));

        $crud->required_fields('code', 'description', 'price');
        $crud->fields('code', 'description', 'price');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_level');
        $data->title_table = lang('menu_level');
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
        $crud->set_subject(lang('subject_family_relationship'));
        $crud->columns('code', 'name');
        $crud->display_as('code', lang('form_id'))
                ->display_as('name', lang('form_name'));

        $crud->required_fields('code', 'name');
        $crud->fields('code', 'name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_family_relationship');
        $data->title_table = lang('menu_family_relationship');
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
        $crud->set_subject(lang('subject_contact'));
        $crud->columns('id', 'client', 'first_name', 'last_name', 'sex', 'email', 'phone_mobile', 'phone', 'picture', 'notes', 'address', 'postal_code', 'town', 'province', 'date_of_birth', 'occupation', 'id_card');
        $crud->display_as('id', lang('form_id'))
                ->display_as('client', lang('form_client'))
                ->display_as('first_name', lang('form_first_name'))
                ->display_as('last_name', lang('form_last_name'))
                ->display_as('sex', lang('form_sex'))
                ->display_as('email', lang('form_email'))
                ->display_as('phone_mobile', lang('form_phone_mobile'))
                ->display_as('phone', lang('form_phone'))
                ->display_as('picture', lang('form_photo'))
                ->display_as('notes', lang('form_notes'))
                ->display_as('address', lang('form_address'))
                ->display_as('postal_code', lang('form_postal_code'))
                ->display_as('town', lang('form_town'))
                ->display_as('province', lang('form_province'))
                ->display_as('date_of_birth', lang('form_date_of_birth'))
                ->display_as('occupation', lang('form_occupation'))
                ->display_as('id_card', 'id_card');

        $crud->required_fields('client', 'first_name', 'last_name', 'sex', 'email', 'phone_mobile', 'phone', 'picture', 'notes', 'address', 'postal_code', 'town', 'province', 'date_of_birth', 'occupation', 'id_card');
        $crud->fields('client', 'first_name', 'last_name', 'sex', 'email', 'phone_mobile', 'phone', 'picture', 'notes', 'address', 'postal_code', 'town', 'province', 'date_of_birth', 'occupation', 'id_card');
        $crud->set_field_upload('picture', 'assets/uploads/files/contact');
        $crud->change_field_type('notes', 'text');
        $crud->field_type('sex','dropdown',
            array('M' => lang('form_sex_male'), 'F' => lang('form_sex_female')));
        $crud->set_relation_n_n('client', 'contacts_by_client', 'client', 'contact_id', 'client_id', 'name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_contact');
        $data->title_table = lang('menu_contact');
        $data->description = "Contactos";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }

    public function leave_reason() {
        $this->current_page();

        $crud = new grocery_CRUD();
        $crud->set_language($this->lang_folder);
        $crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $crud->set_table('leave_reason');
        $crud->set_subject(lang('subject_leave_reason'));
        $crud->columns('code', 'description');
        $crud->display_as('code', lang('form_id'))
                ->display_as('description', lang('form_description'));

        $crud->required_fields('code', 'description');
        $crud->fields('code', 'description');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_leave_reason');
        $data->title_table = lang('menu_leave_reason');
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
        $crud->set_subject(lang('subject_classroom'));
        $crud->columns('id', 'center_id', 'capacity', 'notes', 'picture');
        $crud->display_as('id', lang('form_id'))
                ->display_as('center_id', lang('form_center'))
                ->display_as('capacity', lang('form_capacity'))
                ->display_as('notes', lang('form_notes'))
                ->display_as('picture', lang('form_photo'));

        $crud->required_fields('center_id', 'capacity');
        $crud->fields('center_id', 'capacity', 'notes', 'picture');
        $crud->set_field_upload('picture', 'assets/uploads/files/classroom');
        $crud->set_relation('center_id', 'center', 'name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_classroom');
        $data->title_table = lang('menu_classroom');
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
        $crud->set_subject(lang('subject_teacher'));
        $crud->columns('contact_id', 'center', 'title', 'cv', 'type', 'start_date', 'end_date', 'state', 'bank_account_format', 'bank_account_number');
        $crud->display_as('contact_id', lang('form_name'))
                ->display_as('center', lang('form_center'))
                ->display_as('title', lang('form_title'))
                ->display_as('cv', lang('form_cv'))
                ->display_as('type', lang('form_type'))
                ->display_as('start_date', lang('form_start_date'))
                ->display_as('end_date', lang('form_end_date'))
                ->display_as('state', lang('form_state'))
                ->display_as('bank_account_format', lang('form_bank_account_format'))
                ->display_as('bank_account_number', lang('form_bank_account_number'));

        $crud->required_fields('contact_id', 'center', 'title', 'cv', 'type', 'start_date', 'end_date', 'state', 'bank_account_format', 'bank_account_number');
        $crud->fields('contact_id', 'center', 'title', 'cv', 'type', 'start_date', 'end_date', 'state', 'bank_account_format', 'bank_account_number');
        $crud->set_relation('contact_id', 'contact', '{first_name} {last_name}');
        $crud->set_relation_n_n('center', 'teachers_by_centers', 'center', 'teacher_id', 'center_id', 'name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_teacher');
        $data->title_table = lang('menu_teacher');
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
        $crud->set_subject(lang('subject_group'));
        $crud->columns('id', 'name', 'center_id', 'classroom_id', 'teacher_id', 'level_code', 'academic_period', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'start_time', 'end_time');
        $crud->display_as('id', lang('form_id'))
                ->display_as('name', lang('form_name'))
                ->display_as('center_id', lang('form_center'))
                ->display_as('classroom_id', lang('form_classroom'))
                ->display_as('teacher_id', lang('form_teacher'))
                ->display_as('level_code', lang('form_level'))
                ->display_as('academic_period', lang('form_academic_period'))
                ->display_as('monday', lang('form_monday'))
                ->display_as('tuesday', lang('form_tuesday'))
                ->display_as('wednesday', lang('form_wednesday'))
                ->display_as('thursday', lang('form_thursday'))
                ->display_as('friday', lang('form_friday'))
                ->display_as('saturday', lang('form_saturday'))
                ->display_as('start_time', lang('form_start_time'))
                ->display_as('end_time', lang('form_end_time'));

        $crud->required_fields('name', 'center_id', 'classroom_id', 'teacher_id', 'level_code', 'academic_period', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'start_time', 'end_time');
        $crud->fields('name', 'center_id', 'classroom_id', 'teacher_id', 'level_code', 'academic_period', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'start_time', 'end_time');
        $crud->set_relation('center_id', 'center', 'name');
        $crud->set_relation('classroom_id', 'classroom', 'notes');
        $crud->set_relation('teacher_id', 'teacher', 'contact_id');
        $crud->set_relation('level_code', 'level', 'description');


        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_group');
        $data->title_table = lang('menu_group');
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
        $crud->set_subject(lang('subject_student'));
        $crud->columns('contact_id', 'center_id', 'start_date', 'end_date', 'school_academic_period', 'school_name', 'language_years', 'pref_start_time', 'pref_end_time', 'current_academic_period', 'bank_account_format', 'bank_account_number', 'bank_account_holder', 'bank_payment', 'current_level_code', 'leave_reason_code');
        $crud->display_as('contact_id', lang('form_name'))
                ->display_as('center_id', lang('form_center'))
                ->display_as('start_date', lang('form_start_date'))
                ->display_as('end_date', lang('form_end_date'))
                ->display_as('school_academic_period', lang('form_school_academic_period'))
                ->display_as('school_name', lang('form_school_name'))
                ->display_as('language_years', lang('form_language_years'))
                ->display_as('pref_start_time', lang('form_pref_start_time'))
                ->display_as('pref_end_time', lang('form_pref_end_time'))
                ->display_as('current_academic_period', lang('form_academic_period'))
                ->display_as('bank_account_format', lang('form_bank_account_format'))
                ->display_as('bank_account_number', lang('form_bank_account_number'))
                ->display_as('bank_account_holder', lang('form_bank_account_holder'))
                ->display_as('bank_payment', lang('form_bank_payment'))
                ->display_as('current_level_code', lang('form_level'))
                ->display_as('leave_reason_code', lang('form_leave_reason'));

        $crud->required_fields('contact_id', 'center_id', 'start_date', 'end_date', 'school_academic_period', 'school_name', 'language_years', 'pref_start_time', 'pref_end_time', 'current_academic_period', 'bank_account_format', 'bank_account_number', 'bank_account_holder', 'bank_payment', 'current_level_code', 'leave_reason_code', 'group');
        $crud->fields('contact_id', 'center_id', 'start_date', 'end_date', 'school_academic_period', 'school_name', 'language_years', 'pref_start_time', 'pref_end_time', 'current_academic_period', 'bank_account_format', 'bank_account_number', 'bank_account_holder', 'bank_payment', 'current_level_code', 'leave_reason_code', 'group');
        $crud->set_relation('contact_id', 'contact', '{first_name} {last_name}');
        $crud->set_relation('center_id', 'center', 'name');
        $crud->set_relation('current_level_code', 'level', 'description');
        $crud->set_relation('leave_reason_code', 'leave_reason', 'description');
        $crud->set_relation_n_n('group', 'students_by_groups', 'group', 'student_id', 'groups_id', 'name');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_student');
        $data->title_table = lang('menu_student');
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
        $crud->set_subject(lang('subject_qualification'));
        $crud->columns('student_id', 'academic_period', 'description', 'qualification', 'trinity', 'longon', 'others', 'eval1', 'eval2', 'eval2');
        $crud->display_as('student_id', lang('form_name'))
                ->display_as('academic_period', lang('form_academic_period'))
                ->display_as('description', lang('form_description'))
                ->display_as('qualification', lang('form_qualification'))
                ->display_as('trinity', lang('form_trinity'))
                ->display_as('longon', lang('form_london'))
                ->display_as('others', lang('form_others'))
                ->display_as('eval1', lang('form_eval1'))
                ->display_as('eval2', lang('form_eval2'))
                ->display_as('eval3', lang('form_eval3'));

        $crud->required_fields('student_id', 'academic_period', 'description', 'qualification', 'trinity', 'longon', 'others', 'eval1', 'eval2', 'eval2');
        $crud->fields('student_id', 'academic_period', 'description', 'qualification', 'trinity', 'longon', 'others', 'eval1', 'eval2', 'eval2');
        $crud->set_relation('student_id', 'contact', '{first_name} {last_name}');

        $data = $crud->render();
        $data->title = "CasabeSoft Academia - " . lang('menu_qualification');
        $data->title_table = lang('menu_qualification');
        $data->description = "Calificaciones";
        $data->view_to_load = 'admin/admin';
        $this->load->view('templates/admin_page', $data);
    }

}

/* End of file grocery_pages.php */
/* Location: ./application/controllers/admin_pages.php */
