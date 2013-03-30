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
    public function __construct() {
        parent::__construct();
        $this->template = 'templates/manager_page';
        $this->location = 'manager/';
        $this->menu_template = 'templates/manager_menu'; 
    }

    public function edit() {
        $this->title = "Gestión de contactos";
        $this->load_page('contact_edit');
    }
    
    protected function _echo_json_error($error) {
        http_response_code(500);
        echo json_encode($error);
    }
    
    public function lst() {
        header("Content-type:text/json");
        try {
            $this->load->model('Contact_model');
            echo json_encode($this->Contact_model->get_all());
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function add() {
        header("Content-type:text/json");
        try {
            $contact = $this->input->post();
            $this->load->model('Contact_model');
            echo json_encode($this->Contact_model->add($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function delete($id) {
            header("Content-type:text/json");
        try {
            $this->load->model('Contact_model');
            echo json_encode($this->Contact_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function update() {
        header("Content-type:text/json");
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
