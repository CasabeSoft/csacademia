<?php
/**
 * Gestión de Profesores
 *
 * @author Carlos Bello
 */
class Teacher_model extends CI_Model {
    private $client_id;
    
    public $FIELDS = [
        "contact_id",
        "title", 
        "cv", 
        "type", 
        "start_date", 
        "end_date", 
        "state", 
        "bank_account_format", 
        "bank_account_number"
    ];
    
    public function __construct() {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
        $this->load->model('Contact_model');
    }
    
    public function get_all() {
        return $this->db->from('contact')
                ->join('teacher', 'contact.id = teacher.contact_id')
                ->where('client_id', $this->client_id)
                ->get()->result_array();                
    }
    
    public function delete($id) {
        $this->db->delete('teacher', 'contact_id = '.$id);  // Por si no hubiese eliminación en cascada
        return $this->Contact_model->delete($id);
    }
    
    public function add($teacher) {
        $this->db->trans_start();
        $teacher['client_id'] = $this->client_id;
        $id = $this->Contact_model->add(substract_fields($teacher, $this->Contact_model->FIELDS));
        $teacher['contact_id'] = $id;        
        $this->db->insert('teacher', substract_fields($teacher, $this->FIELDS));
        $this->db->trans_complete();        
        return $id;
    }
    
    public function update($teacher) {
        $this->db->trans_start();
        $teacher['client_id'] = $this->client_id;
        $id = $this->Contact_model->update(substract_fields($teacher, $this->Contact_model->FIELDS));
        $cleanTeacher = substract_fields($teacher, $this->FIELDS);
        unset($cleanTeacher['id']);
        unset($cleanTeacher['contact_id']);
        $this->db->update('teacher', $cleanTeacher, 'contact_id = '.$id);
        $this->db->trans_complete(); 
        return $id;
    }
}

/* End of file teacher_model.php */
/* Location: ./application/models/teacher_model.php */
