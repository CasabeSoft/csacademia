<?php
/**
 * Gestión de Profesores
 *
 * @author Carlos Bello
 */
class Student_model extends CI_Model {
    public $FIELDS = [
        "contact_id",
        "center_id", 
        "start_date", 
        "school_academic_period", 
        "school_name", 
        "language_years", 
        "pref_start_time", 
        "pref_end_time", 
        "current_academic_period",
        "bank_account_format",
        "bank_account_number",
        "bank_account_holder",
        "bank_payment",
        "current_level_code",
        "leave_reason_code",
        "end_date",
    ];
    
    public $NULLABLES = [
        'language_years',
        'current_academic_period',
        'current_level_code',
        "leave_reason_code"
    ];
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Contact_model');
    }
    
    public function get_all() {
        return $this->db->from('contact')
                ->join('student', 'contact.id = student.contact_id')
                ->get()->result_array();                
    }
    
    public function delete($id) {
        $this->db->delete('student', 'contact_id = '.$id);  // Por si no hubiese eliminación en cascada
        return $this->Contact_model->delete($id);
    }
    
    public function add($student) {
        $this->db->trans_start();
        $id = $this->Contact_model->add(substract_fields($student, $this->Contact_model->FIELDS));
        $student['contact_id'] = $id;    
        $student['center_id'] = 1;    
        $this->db->insert('student', convert_nullables(substract_fields($student, $this->FIELDS), $this->NULLABLES));
        $this->db->trans_complete();        
        return $id;
    }
    
    public function update($student) {
        $this->db->trans_start();
        $id = $this->Contact_model->update(substract_fields($student, $this->Contact_model->FIELDS));
        $cleanStudent = substract_fields($student, $this->FIELDS);
        unset($cleanStudent['id']);
        unset($cleanStudent['contact_id']);
        $cleanStudent['center_id'] = 1; 
        $this->db->update('student', convert_nullables($cleanStudent, $this->NULLABLES), 'contact_id = '.$id);
        $this->db->trans_complete(); 
        return $id;
    }
}

/* End of file teacher_model.php */
/* Location: ./application/models/teacher_model.php */
