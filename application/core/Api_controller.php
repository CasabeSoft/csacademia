<?php
/**
 * Controlador base para API REST
 */
class Api_controller extends MY_Controller
{
    
    public function setup_ajax_response_headers()
    {
        header("Content-type: text/json");
        header("Expires: -1");  // HACK! Necesario para evitar que el IE cachee las llamadas AJAX.
    }
    
    protected function echo_json_error($error, $code = 500)
    {
        http_response_code($code);
        echo json_encode($error);
    }
}

/* End of file Api_Controller.php */
/* Location: ./application/libraries/Api_Controller.php */
