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
            redirect('/home');
        }
    }

    public function home() {
        $this->current_page();
        // TODO: Remplazar literales por acceso a texto desde recurso internacionalizado
        $this->title = "CasabeSoft Academia - " . lang('menu_home');
        $this->description = 'Página de inicio de CasabeSoft Academia.';
        $this->load_page('home');
    }

    public function about() {
        $this->current_page();
        // TODO: Remplazar literales por acceso a texto desde recurso internacionalizado
        $this->title = "CasabeSoft Academia - " . lang('menu_about');
        $this->description = 'Información a cerca de la aplicación CasabeSoft Academia.';
        $this->load_page('about');
    }

    public function contact() {
        $this->current_page();
        // TODO: Remplazar literales por acceso a texto desde recurso internacionalizado
        $this->title = "CasabeSoft Academia - " . lang('menu_contact');
        $this->description = "Información de contacto para pedidos o sugerencias relacionadas con CasabeSoft Academia.";
        $this->load_page('contact');
    }    

}

/* End of file public_pages.php */
/* Location: ./application/controllers/public_pages.php */