<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Controlador para las páginas públicas que no requieren mucho
 * procesamiento, del lado del servidor.
 *
 * @author Carlos Bello
 * @author Leonardo Quintero
 */
class Public_pages extends Basic_controller
{

    public function __construct() {
        parent::__construct();
        $this->template = 'templates/public_page';
        $this->location = 'public/';
    }

    public function lang($lang) {

        if ($lang == 'en') {
            //establecemos la sesion lang en "en"
            $this->session->set_userdata(array('language' => true, 'lang' => 'en'));
            $current_url = $this->session->userdata('current_url');
        } else {
            //establecemos la sesion lang en "es"
            $this->session->set_userdata(array('language' => true, 'lang' => 'es'));
            $current_url = $this->session->userdata('current_url');
        }

        if (isset($current_url) && $current_url != '') {
            //redireccionamos a la url desde donde se hizo el cambio de idioma
            redirect($this->session->userdata('current_url'));
        } else {
            //cargamos la funcion index de este controller.
            //redirect('/home');
            redirect('/login');
        }
    }

    public function home() {
        $this->load_page('home', 'templates/spa_page');
    }

    public function about() {
        $this->current_page();

        $this->title = lang('menu_about');
        $this->description = 'Información a cerca de la aplicación CasabeSoft Academia.';
        $this->load_page('about');
    }
    
    protected function _echo_json_error($error, $httpErrorCode = 500) {
        http_response_code($httpErrorCode);
        echo json_encode($error);
    }

    protected function _send_email($fromAddress, $fromName, $to, $subject, $message) {
        /*
        $this->load->library('email');
        $config = $this->config->item('email', 'academy');

        $this->email->clear();
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");

        $this->email->from($fromAddress, $fromName);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message(nl2br($message));
        $sent = $this->email->send();
        //$this->email->print_debugger(array('headers'));
        return $sent;
        */
        // content-type para HTML
        $headers = "MIME-Version: 1.0" . PHP_EOL; //"\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . PHP_EOL; //"\r\n";

        // Mas headers
        $headers .= 'From: ' . $fromName . ' <' . $fromAddress . '>' . PHP_EOL; //"\r\n";
        //$headers .= 'Cc: ' . $fromName . ' <' . $fromAddress . '>' . PHP_EOL; //"\r\n";
        $headers .= 'Bcc: ' . $fromName . ' <' . $fromAddress . '>' . PHP_EOL; //"\r\n";
        //$headers .='Reply-To: ' . $fromName . ' <' . $fromAddress . '>' . PHP_EOL; //"\r\n";

        return mail($to, $subject, $message, $headers);
        //return mail($to, $subject, $message, 'From: ' . $fromAddress . PHP_EOL);
    }
    
    public function contact() {
        $this->setup_ajax_response_headers();
        try {
            $contact = $this->input->post();
            if (!($contact['name'] && ($contact['email'] || $contact['phone']))) {
                return $this->_echo_json_error('No enough data', 412);
            }
            $email = $contact['email'] ? $contact['email'] : EMAIL_CONTACT;
            $message = $contact['message'].
                    PHP_EOL . PHP_EOL . '---' . PHP_EOL.
                    $contact['name'] .
                    ($contact['email'] ? PHP_EOL . $contact['email'] : '') .
                    ($contact['phone'] ? PHP_EOL.$contact['phone'] : '') . PHP_EOL;
            $sent = $this->_send_email(
                $email,
                $contact['name'],
                EMAIL_CONTACT,
                CONTACT_MAIL_SUBJECT,
                $message
            );
            echo json_encode($sent);
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function error404() {
        $this->current_page();

        $this->title = lang('404');
        $this->description = 'CasabeSoft Academia - Página no encontrada';
        $this->load_page('404');
    }
}

/* End of file public_pages.php */
/* Location: ./application/controllers/public_pages.php */
