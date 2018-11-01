<?php
/**
 * Configuración básica para la Academia.
 *
 */

/**
 * Correo.
 * */
$config['email']['protocol'] = 'smtp'; // mail, sendmail, smtp
$config['email']['smtp_host'] = 'smtp.1and1.es';
$config['email']['smtp_port'] = '587';
//$config['smtp_crypto'] = 'tls';

//$config['email']['smtp_host'] = 'ssl://smtp.1and1.es';
//$config['email']['smtp_port'] = '465';

//$config['email']['smtp_host'] = 'auth.smtp.1and1.es';
//$config['email']['smtp_port'] = '25';

//$config['email']['smtp_host'] = 'ssl://smtp.1and1.es';
//$config['email']['smtp_port'] = '587';

//$config['email']['smtp_host'] = 'ssl://smtp.gmail.com';
//$config['email']['smtp_port'] = '465';

$config['email']['smtp_user'] = 'contacto@casabesoft.com'; //'casabesoft.academia@gmail.com';
$config['email']['smtp_pass'] = 'contacto';
$config['email']['mailtype'] = 'html'; // text, html
$config['email']['charset'] = 'utf-8'; // utf-8, iso-8859-1, ...
$config['email']['wordwrap'] = false; // TRUE, FALSE
$config['email']['crlf'] = "\r\n";
$config['email']['newline'] = "\r\n";
//$config['email']['smtp_timeout'] = 25;
//$config['email']['validation'] = TRUE;

/**
 * Temas para el grocery crud
 * Value: datatables, flexigrid
 */
$config['grocery_crud_theme'] = 'flexigrid';

/* End of file academy.php */
/* Location: ./system/application/config/academy.php */
