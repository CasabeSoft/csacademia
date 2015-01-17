<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para las páginas públicas que no requieren mucho 
 * procesamiento, del lado del servidor.
 *
 * @author Carlos Bello
 * @author Leonardo Quintero
 */
class Public_pages extends Basic_controller {

    public function __construct() {
        parent::__construct();
        $this->template = 'templates/public_page';
        $this->location = 'public/';
    }

    public function lang($lang) {

        if ($lang == 'en') {
            //establecemos la sesion lang en "en"
            $this->session->set_userdata(array('language' => TRUE, 'lang' => 'en'));
            $current_url = $this->session->userdata('current_url');
        } else {
            //establecemos la sesion lang en "es"
            $this->session->set_userdata(array('language' => TRUE, 'lang' => 'es'));
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
        $this->current_page();

        $this->title = lang('menu_home');
        $this->description = 'Página de inicio de CasabeSoft Academia.';
        $this->load_page('home');
    }

    public function about() {
        $this->current_page();

        $this->title = lang('menu_about');
        $this->description = 'Información a cerca de la aplicación CasabeSoft Academia.';
        $this->load_page('about');
    }

    public function contact() {
        $this->current_page();

        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', lang('form_name'), 'required');
        $this->form_validation->set_rules('email', lang('form_email'), 'required');
        $this->form_validation->set_rules('subject', lang('form_subject'), 'required');
        $this->form_validation->set_rules('message', lang('form_message'), 'required');
        $this->form_validation->set_rules('privacy', lang('form_contact_privacy'), 'required');

        if ($this->form_validation->run() == TRUE) {

            $this->load->library('email');
            $config = $this->config->item('email', 'academy');

            $this->email->clear();
            $this->email->initialize($config);
            $this->email->set_newline("\r\n");

            $nameFrom = $this->input->post('name');
            $emailFrom = $this->input->post('email');
            $subjectFrom = $this->input->post('subject');
            $message = $this->input->post('message');
            $emailTo = EMAIL_CONTACT;

            $body = "<br/><b>Nombre:</b> " . $nameFrom;
            $body .= "<br/><br/><b>Email:</b> " . $emailFrom;
            $body .= "<br/><br/><b>Asunto:</b> " . $subjectFrom;
            $body .= "<br/><br/><b>Mensaje:</b><br/><br/> " . nl2br($message);
            $body .= "<br/><br/>Mensaje envidado desde el formulario de contacto de " . base_url() . " el " . date('d/m/Y, H:i:s', time()) . "<br/>";

            $this->email->from($emailFrom, $nameFrom);
            $this->email->to($emailTo);
            $this->email->subject('Formulario de contacto de CS Academia');
            $this->email->message($body);

            if ($this->email->send()) {
                $this->message = lang('message_email');
            } else {
                $this->error = lang('message_error_email');
            }
        }

        $this->title = lang('menu_contact');
        $this->description = "Información de contacto para pedidos o sugerencias relacionadas con CasabeSoft Academia.";
        $this->load_page('contact');
    }
    
    function error404() {
        $this->current_page();

        $this->title = lang('404');
        $this->description = 'CasabeSoft Academia - Página no encontrada';
        $this->load_page('404');
    }
}

/* End of file public_pages.php */
/* Location: ./application/controllers/public_pages.php */