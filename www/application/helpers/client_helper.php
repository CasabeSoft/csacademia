<?php

/**
 * Client Helpers
 */

if (!function_exists('get_subdomain')) {
    function get_subdomain()
    {
        return explode('.', explode(':', $_SERVER['HTTP_HOST'])[0])[0];
    }
    
    function subdomain_is_client($subdomain)
    {
        return file_exists(APPPATH . '../assets/themes/' . $subdomain . '/css/client.css');
    }
}

/* End of file client_helper.php */
/* Location: ./application/helpers/client_helper.php */
