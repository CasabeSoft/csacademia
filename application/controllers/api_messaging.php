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
class Api_messaging extends Api_controller {
    
    protected function email_post() {
        $from = $this->session->userdata('email');
        $email = $this->input->post();
        
        $this->load->library('email');
        $this->email->clear();
        // TODO: Inicializar con configuración de email por cliente
        $config = $this->config->item('email', 'academy');
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");

        $this->email->from($from);
        $this->email->reply_to($from);
        $this->email->to($from);
        $this->email->bcc($email['to']);
        $this->email->subject($email['subject']);
        $this->email->message(nl2br($email['message']));
        $sent = $this->email->send();
        echo json_encode($sent);
    }
    
    public function email() {
        $this->setup_ajax_response_headers();
        try {
            switch ($this->input->server('REQUEST_METHOD')) {
                case 'POST':
                    $this->email_post();
                    break;
            }
        } catch (Exception $e) {
            $this->echo_json_error($e->getMessage());
        }
    }
    
    public function email_contact_get() {
        $this->load->model('Contact_model');
        echo json_encode($this->Contact_model->get_all_email());
    }
    
    public function email_contact() {
        $this->setup_ajax_response_headers();
        try {
            switch ($this->input->server('REQUEST_METHOD')) {
                case 'GET':
                    $this->email_contact_get();
                    break;
            }
        } catch (Exception $e) {
            $this->echo_json_error($e->getMessage());
        }
    }
    
    public function sms_post() {
        $sms = $this->input->post();
        $sent = FALSE;
        foreach ($sms['to'] as $to) {
            $result = send_sms('CSAcademia', $to, $sms['message']);
            $sent = $sent || $result->success;
            //Valida sms con textlocal
            //$sent = $sent || $result->status == 'success';
        }
        echo json_encode($sent);
    }
    
    public function sms() {
        $this->setup_ajax_response_headers();
        try {
            switch ($this->input->server('REQUEST_METHOD')) {
                case 'POST':
                    $this->sms_post();
                    break;
            }
        } catch (Exception $e) {
            $this->echo_json_error($e->getMessage());
        }
    }
    
    public function sms_contact_get() {
        $this->load->model('Contact_model');
        echo json_encode($this->Contact_model->get_all_mobile_phone());
    }
    
    public function sms_contact() {
        $this->setup_ajax_response_headers();
        try {
            switch ($this->input->server('REQUEST_METHOD')) {
                case 'GET':
                    $this->sms_contact_get();
                    break;
            }
        } catch (Exception $e) {
            $this->echo_json_error($e->getMessage());
        }
    }
    
}

/* End of file api_messaging.php */
/* Location: ./application/controllers/api_messaging.php */