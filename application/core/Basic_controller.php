<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador de base para implementar controladores que sirven páginas
 * con una información y estructura común.
 *
 * @author Carlos Bello
 */
class Basic_controller extends MY_Controller {

    var $location;
    var $template;
    var $title;
    var $description;
    var $styles;
    var $content;
    var $scripts;
    var $current_page;
    var $menu_template;
    var $centers;

    public function __construct() {
        parent::__construct();
        $this->load_centers();
    }

    public function load_page($name = 'home') {
        $this->current_page = $name;
        $this->content = $this->load->view($this->location . $name, $this, true);
        if (file_exists(APPPATH . 'views/' . $this->location . $name . '_scripts' . '.php'))
            $this->scripts = $this->load->view($this->location . $name . '_scripts', $this, true);
        if (file_exists(APPPATH . 'views/' . $this->location . $name . '_styles' . '.php'))
            $this->styles = $this->load->view($this->location . $name . '_styles', $this, true);
        $this->load->view($this->template, $this);
    }

    public function load_centers() {

        $cliente_id = $this->session->userdata('client_id');
        if (!empty($cliente_id)) {
            $this->load->model('General_model');
            $this->centers = $this->General_model->get_all_centers($cliente_id);
        }
    }

}

/* End of file Basic_controller.php */
/* Location: ./application/libraries/Basic_controller.php */