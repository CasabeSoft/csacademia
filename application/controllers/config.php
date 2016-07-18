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
    
    protected function value_get($key) {
        $this->load->model('General_model');
        $client_id = $this->client_id;
        $value = $this->General_model->get_fields(
            'key_value_storage',
            '`key`, value',
            "client_id = $client_id and `key` = '$key'"
        );
        
        echo json_encode(current($value) ?: null);
    }

    protected function value_post() {
        $this->load->model('General_model');
        $key_value = $this->input->post();
        $key = $key_value['key'];
        $value = $key_value['value'];
        $client_id = $this->client_id;
        
        $existingValue = $this->General_model->get_where(
            'key_value_storage',
            "client_id = $client_id and `key` = '$key'"
        );
        
        if ($existingValue) {
            $saved = $this->General_model->update(
                'key_value_storage',
                ['value' => $value],
                "client_id = $client_id and `key` = '$key'"
            );    
        } else {
            $saved = $this->General_model->insert(
                'key_value_storage',
                [
                    'client_id' => $client_id,
                    'value' => $value,
                    'key' => $key,
                ]
            );
        }
        
        echo json_encode($saved);
    }
    
    public function value_delete($key) {
        $this->load->model('General_model');
        $client_id = $this->client_id;
        $this->General_model->delete(
            'key_value_storage',
            "client_id = $client_id and `key` = '$key'"
        );
        
        echo json_encode(true);
    }
    
    public function value($key = null) {
        $this->setup_ajax_response_headers();
        try {
            switch ($this->input->server('REQUEST_METHOD')) {
                case 'GET':
                    $this->value_get($key);
                    break;
                case 'POST':
                    $this->value_post();
                    break;
                case 'DELETE':
                    $this->value_delete($key);
            }
        } catch (Exception $e) {
            $this->echo_json_error($e->getMessage());
        }
    }
}

/* End of file config.php */
/* Location: ./application/controllers/config.php */
