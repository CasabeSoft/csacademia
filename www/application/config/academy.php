<?php
/**
 * Configuración básica para la Academia.
 */

/**
 * Correo.
 * */
$config['email']['protocol'] = 'smtp'; // mail, sendmail, smtp
$config['email']['smtp_host'] = 'smtp.1and1.es';
$config['email']['smtp_port'] = '587';
$config['email']['smtp_user'] = 'contacto@casabesoft.com';
$config['email']['smtp_pass'] = 'contacto';
$config['email']['mailtype'] = 'html'; // text, html
$config['email']['charset'] = 'utf-8';
$config['email']['wordwrap'] = false;
$config['email']['crlf'] = "\r\n";
$config['email']['newline'] = "\r\n";

/**
 * Temas para el grocery crud
 * Value: datatables, flexigrid
 */
$config['grocery_crud_theme'] = 'flexigrid';

/** GTM */
$config['gtm_tag_id'] = 'GTM-XXXXXXX';

/* End of file academy.php */
/* Location: ./system/application/config/academy.php */
