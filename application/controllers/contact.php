<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * TEMPORAL. Probablemente este código deba ser heredado o integrado
 * en los controladores de estudiantes y profesores.
 *
 * @author Carlos Bello
 */
class Contact extends Basic_controller {
    var $subject;
    var $editMode;
    
    public function __construct() {
        parent::__construct();
        $this->template = 'templates/manager_page';
        $this->location = 'manager/';
        $this->menu_template = 'templates/manager_menu'; 
    }

    public function admin() {
        $this->current_page();
        $this->title = lang('page_manage_contacts');
        $this->subject = lang('subject_contact');
        $this->editMode = 'true';
        $this->load_page('contact_admin');
    }
    
    protected function _echo_json_error($error) {
        http_response_code(500);
        echo json_encode($error);
    }
    
    public function get() {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Contact_model');
            echo json_encode($this->Contact_model->get_all());
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function add() {
        $this->setup_ajax_response_headers();
        try {
            $contact = $this->input->post();
            $this->load->model('Contact_model');
            echo json_encode($this->Contact_model->add($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function delete($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Contact_model');
            echo json_encode($this->Contact_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function update() {
        $this->setup_ajax_response_headers();
        try {
            $contact = $this->input->post();
            $this->load->model('Contact_model');
            echo json_encode($this->Contact_model->update($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */
