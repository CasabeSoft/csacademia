<?php
/**
 * Description of family_model
 *
 * @author carlos
 */
class Payment_model extends CI_Model {
    private $client_id;
    
    public $FIELDS = [        
        "id",
        "date",
        "amount",
        "piriod",
        "student_id",        
        "payment_type_id"
    ];
    
    public function __construct() {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
    }
    
    public function get_all($student_id) {
        return $this->db->from('payment')
                //->join('family', 'contact.id = family.contact_id')
                ->where('student_id', $student_id)
                ->get()->result_array();          
    }
    
    public function delete($payment_id) {
        $this->db->delete('payment', 'id = '.$payment_id);
        return $payment_id;        
    }
    
    public function add($family) {
        $this->db->trans_start();
        $family['client_id'] = $this->client_id; 
        $id = $this->Contact_model->add(substract_fields($family, $this->Contact_model->FIELDS));
        $family['contact_id'] = $id;    
        $this->db->insert('payment', substract_fields($family, $this->FIELDS));
        $this->db->trans_complete();
        return $id;
    }
    
    public function update($family) {
        $this->db->trans_start();
        $family['client_id'] = $this->client_id; 
        $id = $this->Contact_model->update(substract_fields($family, $this->Contact_model->FIELDS));
        $student_id = $family['student_id'];
        $cleanFamily = substract_fields($family, $this->FIELDS);
        unset($cleanFamily['student_id']);
        unset($cleanFamily['contact_id']);
        $this->db->update('payment', $cleanFamily, 'contact_id = '.$id.' AND student_id = '.$student_id);
        $this->db->trans_complete(); 
        return $id;
    }
}

/* End of file payment_model.php */
/* Location: ./application/models/payment_model.php */

