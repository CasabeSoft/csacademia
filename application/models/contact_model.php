<?php
/**
 * Gestión de contactos
 *
 * @author carlos
 */
class Contact_model extends CI_Model {
    private $client_id;
    
    public $FIELDS = [
        "id",
        "first_name",
        "last_name",
        "sex",
        "email",
        "phone_mobile",
        "phone",
        "picture",
        "notes",
        "address",
        "postal_code",
        "town",
        "province",
        "date_of_birth",
        "occupation",
        "id_card",
        "client_id",
    ];
    
    public function __construct() {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
    }
    
    public function get_all() {
        return $this->db->from('contact')
                ->join('student', 'contact.id = student.contact_id', 'left')
                ->join('teacher', 'contact.id = teacher.contact_id', 'left')
                ->where('client_id = '.$this->client_id)
                ->where('student.contact_id', NULL)
                ->where('teacher.contact_id', NULL)
                ->get()->result_array();
    }
    
    public function delete($id) {
        $this->db->delete('contact', 'id = '.$id.' and client_id = '.$this->client_id);
        return $id;
    }
    
    public function add($contact) {
        unset($contact['id']); 
        $contact['client_id'] = $this->client_id;
        $this->db->trans_start();        
        $this->db->insert('contact', $contact);
        $id = $this->db->insert_id();        
        $this->db->trans_complete();        
        return $id;
    }
    
    public function update($contact) {
        $id = $contact['id'];
        unset($contact['client_id']);
        unset($contact['id']);
        $this->db->update('contact', $contact, 'id = '.$id.' and client_id = '.$this->client_id);
        return $id;
    }
}

/* End of file contact_model.php */
/* Location: ./application/models/contact_model.php */
