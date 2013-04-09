<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Configuración básica para la Academia.
 * 
 */

/**
 * Correo.
 * */
$config['email']['protocol'] = 'smtp'; // mail, sendmail, smtp
$config['email']['smtp_host'] = 'smtp.1and1.es';
$config['email']['smtp_port'] = '25';
$config['email']['smtp_user'] = 'contacto@casabesoft.com';
$config['email']['smtp_pass'] = 'c0nt4ct0';
$config['email']['mailtype'] = 'html'; // text, html
$config['email']['charset'] = 'utf-8'; // utf-8, iso-8859-1, ...
$config['email']['wordwrap'] = FALSE; // TRUE, FALSE

/**
 * Temas para el grocery crud
 * Value: datatables, flexigrid
 */
$config['grocery_crud_theme'] = 'datatables';

/* End of file academy.php */
/* Location: ./system/application/config/academy.php */