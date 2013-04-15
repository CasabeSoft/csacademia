<?php

/**
 * User Helpers
 *
 * @author Leoanrdo Quintero 
 * @author Carlos Bello
 */
// ------------------------------------------------------------------------

/**
 * isLogged
 *
 * Valida si un usuario está autenticado.
 *
 * @return  bool	TRUE si autenticado, FALSE si no.
 */
if (!function_exists('isLogged')) {

    function isLogged() {

        $CI = &get_instance();

        //if ($CI->session->userdata('usuario')->email && $CI->session->userdata('usuario')->email !== '') {
        if ($CI->session->userdata('email') && $CI->session->userdata('email') !== '') {
            unset($CI);

            return TRUE;
        }

        return FALSE;
    }

}

/**
 * substract_fields
 * 
 * Extrae los campos deseados de un arreglo asociativo
 * 
 */
if (!function_exists('substract_fields')) {
    function substract_fields($array, $fields) {
        $result = [];
        foreach ($fields as $field) {
            $result[$field] = $array[$field];
        }
        return $result;
    }
}

?>
