<?php

/**
 * User Helpers
 *
 * @author Leoanrdo Quintero
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


?>
