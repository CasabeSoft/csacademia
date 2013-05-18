<?php
/**
 * Description of family_model
 *
 * @author carlos
 */
class Family_model extends CI_Model {
    private $client_id;
    
    public $FIELDS = [
        "student_id",
        "contact_id",
        "relationship_code" 
    ];
    
    public function __construct() {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
        $this->load->model('Contact_model');
    }
    
    public function get_all($student_id) {
        return $this->db->from('contact')
                ->join('family', 'contact.id = family.contact_id')
                ->where('student_id', $student_id)
                ->get()->result_array();          
    }
    
    private function count_student_associated_with($contact_id) {
        return $this->db->from('family')->where('contact_id', $contact_id)->count_all_results();
    }
    
    public function delete($student_id, $contact_id) {
        $this->db->delete('family', 'student_id = '.$student_id.' AND contact_id = '.$contact_id);
        if ($this->count_student_associated_with($contact_id) == 0)
            $this->Contact_model->delete($contact_id);
        return $contact_id;        
    }
    
    public function add($family) {
        $this->db->trans_start();
        $family['client_id'] = $this->client_id; 
        $id = $this->Contact_model->add(substract_fields($family, $this->Contact_model->FIELDS));
        $family['contact_id'] = $id;    
        $this->db->insert('family', substract_fields($family, $this->FIELDS));
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
        $this->db->update('family', $cleanFamily, 'contact_id = '.$id.' AND student_id = '.$student_id);
        $this->db->trans_complete(); 
        return $id;
    }
}

/* End of file family_model.php */
/* Location: ./application/models/family_model.php */

