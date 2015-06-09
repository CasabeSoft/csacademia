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
class Config extends Basic_controller {

    public function __construct() {
        parent::__construct();
        if (!isLogged()) {
            redirect('/login');
            exit;
        }
    }
    
    protected function _echo_json_error($error) {
        http_response_code(500);
        echo json_encode($error);
    }
    
    protected function front_get() {
        $this->setup_ajax_response_headers();
        echo json_encode([
            'client_id' => $this->session->userdata('client_id')
        ]);
    }
    
    public function front() {
        switch ($this->input->server('REQUEST_METHOD')) {
            case 'GET':
                $this->front_get();
                break;
        }
    }
}

/* End of file config.php */
/* Location: ./application/controllers/config.php */
