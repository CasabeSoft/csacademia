<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Gestión de los datos de un estudiante.
 *
 * @author Carlos Bello
 */
class Student extends Basic_controller {
    var $levels;
    var $academicPeriods;
    var $leaveReasons;
    var $relationships;
    var $schoolLevels;
    
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
        $this->load->model('Group_model');
        $this->load->model('General_model');
        $this->editMode = is_null($this->session->userdata('current_center')['id'])
                ? 'false' : 'true';
        $this->levels = $this->db->select("code, description")->from('level')->get()->result_array();
        $this->groups = $this->Group_model->get_all();
        $this->leaveReasons = $this->db->select("code, description")->from('leave_reason')->get()->result_array();
        $this->relationships = $this->db->select("code, name")->from('family_relationship')->get()->result_array();
        $this->schoolLevels = $this->db->select("id, name")->from('school_level')->get()->result_array();
        $this->payments_types = $this->General_model->get_fields('payment_type', 'id, name');
        $this->load_page('student_admin');
    }
    
    protected function _echo_json_error($error) {
        http_response_code(500);
        echo json_encode($error);
    }
    
    public function get() {
        $this->setup_ajax_response_headers();
        try {
            $filter = $this->input->post();
            if (! is_array($filter))
                $filter = [];
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->get_all($filter));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function add() {
        $this->setup_ajax_response_headers();
        try {
            $contact = $this->input->post();
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->add($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function delete($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function update() {
        $this->setup_ajax_response_headers();
        try {
            $contact = $this->input->post();
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->update($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function family_get($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Family_model');
            echo json_encode($this->Family_model->get_all($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function family_delete($student_id, $contact_id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Family_model');
            echo json_encode($this->Family_model->delete($student_id, $contact_id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function family_add() {
        $this->setup_ajax_response_headers();
        try {
            $family = $this->input->post();
            $this->load->model('Family_model');
            echo json_encode($this->Family_model->add($family));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function family_update() {
        $this->setup_ajax_response_headers();
        try {
            $family = $this->input->post();
            $this->load->model('Family_model');
            echo json_encode($this->Family_model->update($family));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function payments_get($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Payment_model');
            echo json_encode($this->Payment_model->get_all($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function payment_delete($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Payment_model');
            echo json_encode($this->Payment_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function payment_add() {
        $this->setup_ajax_response_headers();
        try {
            $payment = $this->input->post();
            $this->load->model('Payment_model');
            echo json_encode($this->Payment_model->add($payment));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function payment_update() {
        $this->setup_ajax_response_headers();
        try {
            $payment = $this->input->post();
            $this->load->model('Payment_model');
            echo json_encode($this->Payment_model->update($payment));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
}

/* End of file teacher.php */
/* Location: ./application/controllers/teacher.php */
