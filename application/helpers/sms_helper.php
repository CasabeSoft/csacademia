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
        
        //setlocale(LC_ALL, 'en_US');
        //$msg1 = iconv("UTF-8", "US-ASCII//TRANSLIT", $msg);
        //$msg1 = preg_replace('/[^a-z]/i', '', iconv("UTF-8", "US-ASCII//TRANSLIT", $msg));
        //$msg1 = preg_replace('/\p{Mn}/u', '', Normalizer::normalize($msg, Normalizer::FORM_KD));
        //$msg = iconv('UTF-8', 'US-ASCII', $msg);
        //$msg = iconv('UTF-8', 'UCS-2BE', $msg);
        //$msg = sms_tropo_unicode($msg);
        //$msg = unicodeMessageEncode($msg);
        //$msg = unicodeMessageDecode($msg);
        //$msg = rawurlencode($msg);
        //http://ecapy.com/reemplazar-acentos-espacios-o-cualquier-caracter-especial-en-php/
        //
        
        //$msg = mb_convert_encoding ($msg, 'US-ASCII', 'UTF-8');
        
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
