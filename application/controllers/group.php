<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para la gestión de Grupos
 * 
 * @author Leonardo Quintero
 */
class Group extends Basic_controller {

    public function __construct() {
        parent::__construct();
        $this->template = 'templates/manager_page';
        $this->location = 'manager/';
        $this->menu_template = 'templates/manager_menu';
    }

    public function admin() {
        $this->current_page();
        $this->title = lang('page_manage_groups');
        $this->subject = lang('subject_group');
        $this->load->model('General_model');
        $this->load->model('Student_model');
        $this->centers = $this->General_model->get_fields('center', 'id, name');
        $this->classrooms = $this->General_model->get_fields('classroom', 'id, name');
        $this->teachers = $this->General_model->get_fields('view_teacher', 'contact_id, full_name');
        $this->levels = $this->General_model->get_fields('level', 'code, description');
        $this->academic_periods = $this->General_model->get_fields('academic_period', 'code, name');
        $this->students = $this->Student_model->get_all();
        $this->load_page('group_admin');
    }

    protected function _echo_json_error($error) {
        http_response_code(500);
        echo json_encode($error);
    }

    public function get() {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Group_model');
            echo json_encode($this->Group_model->get_all());
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function add() {
        $this->setup_ajax_response_headers();
        try {
            $group = $this->input->post();
            $this->load->model('Group_model');
            echo json_encode($this->Group_model->add($group));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function delete($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Group_model');
            echo json_encode($this->Group_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function update() {
        $this->setup_ajax_response_headers();
        try {
            $group = $this->input->post();
            $this->load->model('Group_model');
            echo json_encode($this->Group_model->update($group));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function students_get($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Student_by_group_model');
            echo json_encode($this->Student_by_group_model->get_all($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function student_delete($student_id, $groups_id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Student_by_group_model');
            echo json_encode($this->Student_by_group_model->delete($student_id, $groups_id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function student_add() {
        $this->setup_ajax_response_headers();
        try {
            $student = $this->input->post();
            $this->load->model('Student_by_group_model');
            echo json_encode($this->Student_by_group_model->add($student));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function student_update() {
        $this->setup_ajax_response_headers();
        try {
            $student = $this->input->post();
            $this->load->model('Student_by_group_model');
            echo json_encode($this->Student_by_group_model->update($student));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

}

/* End of file group.php */
/* Location: ./application/controllers/group.php */
