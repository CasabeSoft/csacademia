<?php
/**
 * Gestión de Alumnos
 *
 * @author Carlos Bello
 */
class Student_model extends CI_Model {
    private $client_id;
    private $center_id;
    
    public $FIELDS = [
        "contact_id",
        "center_id", 
        "start_date", 
        "school_level", 
        "school_name", 
        "language_years", 
        "pref_start_time", 
        "pref_end_time", 
        "current_academic_period",
        "bank_account_format",
        "bank_account_number",
        "bank_account_holder",
        "bank_payment",
        "leave_reason_code",
        "end_date",
        "group_id"
    ];
    
    public $NULLABLES = [
        'language_years',
        'current_academic_period',
        'leave_reason_code',
        'start_date',
        'end_date',
        'school_level',
        'group_id'
    ];
    
    public function __construct() {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
        $this->center_id = $this->session->userdata('current_center')['id'];
        $this->load->model('Contact_model');
    }
    
    public function get_all() {
        $this->db->from('contact')
                ->join('student', 'contact.id = student.contact_id')
                ->where('client_id', $this->client_id);
        if ($this->center_id != NULL)
            $this->db->where('center_id', $this->center_id);
        return $this->db->get()->result_array();          
    }
    
    public function delete($id) {
        $this->db->delete('student', 'contact_id = '.$id);  // Por si no hubiese eliminación en cascada
        return $this->Contact_model->delete($id);
    }
    
    public function add($student) {
        $this->db->trans_start();
        $student['client_id'] = $this->client_id; 
        $id = $this->Contact_model->add(substract_fields($student, $this->Contact_model->FIELDS));
        $student['contact_id'] = $id;    
        $cleanStudent = substract_fields($student, $this->FIELDS);
        $this->db->insert('student', convert_nullables($cleanStudent, $this->NULLABLES));
        $this->db->trans_complete();        
        return $id;
    }
    
    public function update($student) {
        $this->db->trans_start();
        $student['client_id'] = $this->client_id; 
        $id = $this->Contact_model->update(substract_fields($student, $this->Contact_model->FIELDS));
        $cleanStudent = substract_fields($student, $this->FIELDS);
        unset($cleanStudent['id']);
        unset($cleanStudent['contact_id']);
        $this->db->update('student', convert_nullables($cleanStudent, $this->NULLABLES), 'contact_id = '.$id);
        $this->db->trans_complete(); 
        return $id;
    }
}

/* End of file teacher_model.php */
/* Location: ./application/models/student_model.php */
