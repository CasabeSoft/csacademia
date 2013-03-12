<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para las páginas de administración que no requieren mucho 
 * procesamiento, del lado del servidor.
 *
 * @author Carlos Bello
 */
class Admin_pages extends Base_Controller {
    var $extra_info;
    
    public function __construct() {
        parent::__construct();
        $this->location = 'admin/';
        $this->template = 'templates/admin_page';
    }
    
    public function main() {
        // TODO: Remplazar literales por acceso a texto desde recurso internacionalizado
        $this->title = "CasabeSoft Academia - Principal";
        $this->description = "Págia principal de administración."; 
        $this->load_page('main');
    }
    
    public function managment() {
        // TODO: Remplazar literales por acceso a texto desde recurso internacionalizado
        $this->title = "CasabeSoft Academia - Gestión";
        $this->description = "Administración y gestión de datos."; 
        $this->extra_info = [ 
            "num_pages" => 4,
            "table" =>
                [
                    [1, 'Mark', 'Tompson', 'the_mark7@gmail.com'],
                    [2, 'Ashley', 'Jacobs', 'ash11927@yahoo.com'],
                    [3, 'Audrey', 'Ann', 'audann84@hotmail.com'],
                    [4, 'John', 'Robinson', 'jr5527@mail.ru'],
                    [5, 'Aaron', 'Butler', 'aaron_butler@gmail.com'],
                    [6, 'Chris', 'Albert', 'cab79@hotmail.com']
                ]
        ];
        $this->load_page('managment');
    }
}

/* End of file admin_pages.php */
/* Location: ./application/controllers/admin_pages.php */
