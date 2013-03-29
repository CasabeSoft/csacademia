<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contact_model
 *
 * @author carlos
 */
class Contact_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_all() {
        return $this->db->from('contact')->get()->result_array();
    }
}

?>
