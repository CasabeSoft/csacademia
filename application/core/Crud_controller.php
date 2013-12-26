<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para orperaciones generales de gestión (CRUD). 
 *
 * @author Carlos Bello
 * @author Leonardo Quintero
 */
class Crud_controller extends Basic_controller {

    var $crud;
    var $crud_view;    

    public function __construct() {
        parent::__construct();
        if (!isLogged()) {
            redirect('/denied');
            exit;
        }
        $this->load->library('grocery_CRUD');        
        $this->crud = new grocery_CRUD();
        $this->crud->set_language($this->lang_folder);
        $this->crud->set_theme($this->config->item('grocery_crud_theme', 'academy'));
        $this->current_page();
    }

    public function load_page() {
        $this->load->view($this->template, $this);
    }

    protected function set_page_title($title = '') {
        $this->page_header = lang($title);
        $this->title = "Dundee - " . $this->page_header;
    }

}

/* End of file Crud_controller.php */
/* Location: ./application/controllers/Crud_controller.php */
