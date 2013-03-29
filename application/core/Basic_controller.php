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
    
    public function load_page($name = 'home') {
        $this->current_page = $name;
        $this->content = $this->load->view($this->location.$name, $this, true);
        if (file_exists($this->location.'/'.$name.'_scripts'.'.php'))
            $this->scripts = $this->load->view($this->location.$name.'_scripts', $this, true);
        if (file_exists($this->location.'/'.$name.'_styles'.'.php'))
            $this->styles = $this->load->view($this->location.$name.'_styles', $this, true);
        $this->load->view($this->template, $this);
    }
}

/* End of file Basic_controller.php */
/* Location: ./application/libraries/Basic_controller.php */