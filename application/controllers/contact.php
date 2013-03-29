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
        $this->location = 'contact/';
    }


    public function edit() {
        $this->title = "Gestión de contactos";
        $this->load_page('edit');
    }
    
}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */
