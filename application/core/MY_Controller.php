<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador en el que deberán basarse todos los controladores del sitio
 * para concentrar la configuración, inicialización y el comportamiento común
 * para todo el sitio.
 *
 * @author Carlos Bello
 */
class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        // TODO: Inicializar temas de localización o internacionalización
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/libraries/MY_Controller.php */
