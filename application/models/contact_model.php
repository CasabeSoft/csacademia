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
    
    public function delete($id) {
        $this->db->delete('contact', 'id = '.$id);
        return $id;
    }
    
    public function add($contact) {
        unset($contact['id']);        
        $this->db->trans_start();        
        $this->db->insert('contact', $contact);
        $id = $this->db->insert_id();        
        $this->db->trans_complete();        
        return $id;
    }
    
    public function update($contact) {
        $id = $contact['id'];
        unset($contact['id']);
        $this->db->update('contact', $contact, 'id = '.$id);
        return $id;
    }
}

/* End of file Contact_model.php */
/* Location: ./application/models/Contact_model.php */
