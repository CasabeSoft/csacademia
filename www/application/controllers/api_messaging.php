<?php
/**
 * Controlador para las páginas de administración que no requieren mucho
 * procesamiento, del lado del servidor.
 *
 * @author Leonardo Quintero
 */
class Api_messaging extends Api_controller
{
    
    protected function email_post()
    {
        $from = $this->session->userdata('email');
        $email = $this->input->post();
        
        $this->load->model('General_model');
        $client_info = $this->General_model->get_info_client_id($this->client_id);
        
        // TODO: Inicializar con configuración de email por cliente
        // content-type para HTML
        $headers = "MIME-Version: 1.0" . PHP_EOL; //"\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . PHP_EOL; //"\r\n";
        $headers .= 'From: ' . $client_info['name'] . ' <' . $from . '>' . PHP_EOL; //"\r\n";
        $headers .= 'Bcc: ' . $client_info['name'] . ' <' . $from . '>' . PHP_EOL; //"\r\n";
        
        foreach ($email['to'] as $to) {
            $sent = mail($to, $email['subject'], nl2br($email['message']), $headers);
        }
        echo json_encode($sent);
    }
    
    public function email()
    {
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
    
    public function email_contact_get()
    {
        $this->load->model('Contact_model');
        echo json_encode($this->Contact_model->get_all_email());
    }
    
    public function email_contact()
    {
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
    
    public function sms_post()
    {
        $sms = $this->input->post();
        $sent = false;
        foreach ($sms['to'] as $to) {
            $result = send_sms('CSAcademia', $to, $sms['message']);
            $sent = $sent || $result->success;
        }
        echo json_encode($sent);
    }
    
    public function sms()
    {
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
    
    public function sms_contact_get()
    {
        $this->load->model('Contact_model');
        echo json_encode($this->Contact_model->get_all_mobile_phone());
    }
    
    public function sms_contact()
    {
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
