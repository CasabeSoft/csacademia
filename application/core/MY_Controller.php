<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador en el que deberán basarse todos los controladores del sitio
 * para concentrar la configuración, inicialización y el comportamiento común
 * para todo el sitio.
 *
 * @author Carlos Bello
 * @author Leonardo Quintero
 */
class MY_Controller extends CI_Controller {
    
    public $lang_id;
    public $lang_code;
    public $lang_folder;
    
    public $role_id;
    public $client_id;
    
    public function __construct() {
        parent::__construct();
        $this->load->config('academy', TRUE);
        $this->role_id = $this->session->userdata('role_id');
        $this->client_id = $this->session->userdata('client_id');
        
        $url = base_url();
        
        //TODO: Cargar desde bbdd
        if ($this->session->userdata('lang') == 'en') {
            $this->config->set_item('language', 'english');
            $this->lang->load('app', 'english');
            $this->lang_id = '2';
            $this->lang_code = 'en';
            $this->lang_folder = 'english';
        } else {
            $this->config->set_item('language', 'spanish');
            $this->lang->load('app', 'spanish');
            $this->lang_id = '1';
            $this->lang_code = 'es';
            $this->lang_folder = 'spanish';
        }
    }
    
    function current_page() {
        $this->session->set_userdata('current_url', $this->uri->uri_string());
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/libraries/MY_Controller.php */
