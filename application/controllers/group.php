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
    
    public function students_get($groups_id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->get_by_group($groups_id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function student_delete($student_id) {
        $this->setup_ajax_response_headers();
        try {
            $groups_id = 'NULL';
            
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->update_group($student_id, $groups_id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function student_add($student_id, $groups_id) {
        $this->setup_ajax_response_headers();
        try {
            //$student_id = $this->input->post('contact_id');
            //$groups_id = $this->input->post('group_id');
            
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->update_group($student_id, $groups_id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function student_update($student_id, $groups_id) {
        $this->setup_ajax_response_headers();
        try {
            //$student_id = $this->input->post('contact_id');
            //$groups_id = $this->input->post('group_id');
            
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->update_group($student_id, $groups_id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function get_attendance_for_date($group_id, $date) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Attendance_model');
            echo json_encode($this->Attendance_model->get_attendance_for_date($group_id, $date));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
 
    public function get_attendance_for_month($group_id, $year, $month) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Attendance_model');
            echo json_encode($this->Attendance_model->get_attendance_for_month($group_id, $year, $month));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }   
    public function add_student_attendance($student_id, $date) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Attendance_model');
            echo json_encode($this->Attendance_model->add_student_attendance($student_id, $date));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function delete_student_attendance($student_id, $date) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Attendance_model');
            echo json_encode($this->Attendance_model->delete_student_attendance($student_id, $date));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
}

/* End of file group.php */
/* Location: ./application/controllers/group.php */
