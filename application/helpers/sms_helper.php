<?php

/**
 * SMS Helpers
 *
 * @author Leoanrdo Quintero 
 * @author Carlos Bello
 */
// ------------------------------------------------------------------------

/**
 * send_sms
 *
 * Envía un SMS con el proveedor Tropo
 *
 * @return  json.
 */
if (!function_exists('send_sms')) {

    function send_sms($customerName = '', $numberToDial = '', $msg = '') {
        
        if (($numberToDial == "") || ($msg == "")) {
            return '';
        }
        // Base url
        $url = 'https://api.tropo.com/1.0/sessions';
        
        // prepare the body data. Example is JSON here
        $data = json_encode(array(
            'token' => '0a69b702cf731c43b491d211fe0fe30fb6fac13ad457ff436d97a29667b20e57b28be1db233f3c7d40ed85a3',
            'customerName' => $customerName,
            'numberToDial' => '+' . $numberToDial,
            'msg' => $msg
        ));
        
        // set up the request context
        $options = ["http" => [
                "method" => "POST",
                "header" => ["Accept: application/json",
                    "Content-Type: application/json"],
                "content" => $data
        ]];
        $context = stream_context_create($options);

        // make the request
        $response = file_get_contents($url, false, $context);
        
        return json_decode($response);
    }

}

/* End of file sms_helper.php */
/* Location: ./application/helpers/sms_helper.php */
