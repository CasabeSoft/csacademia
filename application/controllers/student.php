<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * TEMPORAL. Probablemente este código deba ser heredado o integrado
 * en los controladores de estudiantes y profesores.
 *
 * @author Carlos Bello
 */
class Student extends Basic_controller {
    var $levels;
    var $academicPeriods;
    var $leaveReasons;
    
    public function __construct() {
        parent::__construct();
        $this->template = 'templates/manager_page';
        $this->location = 'manager/';
        $this->menu_template = 'templates/manager_menu'; 
    }

    public function admin() {
        $this->current_page();
        $this->title = lang('page_manage_students');
        $this->subject = lang('subject_student');
        $this->levels = $this->db->select("code, description")->from('level')->get()->result_array();
        $this->academicPeriods = $this->db->select("code, name")->from('academic_period')->get()->result_array();
        $this->leaveReasons = $this->db->select("code, description")->from('leave_reason')->get()->result_array();
        $this->load_page('student_admin');
    }
    
    protected function _echo_json_error($error) {
        http_response_code(500);
        echo json_encode($error);
    }
    
    public function get() {
        header("Content-type:text/json");
        try {
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->get_all());
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function add() {
        header("Content-type:text/json");
        try {
            $contact = $this->input->post();
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->add($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function delete($id) {
            header("Content-type:text/json");
        try {
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function update() {
        header("Content-type:text/json");
        try {
            $contact = $this->input->post();
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->update($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
}

/* End of file teacher.php */
/* Location: ./application/controllers/teacher.php */
