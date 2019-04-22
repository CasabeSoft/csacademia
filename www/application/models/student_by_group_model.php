<?php
/**
 * Group of students management
 */
class Student_by_group_model extends CI_Model
{
    private $client_id;
    
    public $FIELDS = [
        "groups_id",
        "student_id"
    ];
    
    public function __construct()
    {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
    }
    
    public function get_all($groups_id = '')
    {
        if (!empty($groups_id)) {
            $this->db->where('groups_id', $groups_id);
        }
        return $this->db->from('students_by_groups')
                ->join('group', 'students_by_groups.groups_id = group.id')
                ->join('student', 'students_by_groups.student_id = student.contact_id')
                ->join('contact', 'student.contact_id = contact.id')
                ->get()->result_array();
    }
    
    public function count_student_associated_with($groups_id = '')
    {
        if (!empty($groups_id)) {
            $this->db->where('groups_id', $groups_id);
        }
        return $this->db->from('students_by_groups')->count_all_results();
    }
    
    public function delete($student_id, $groups_id)
    {
        $this->db->delete('students_by_groups', 'student_id = '.$student_id.' AND groups_id = '.$groups_id);
        return $student_id;
    }
    
    public function add($student)
    {
        $student['client_id'] = $this->client_id;
        $student['contact_id'] = $id;
        $this->db->insert('students_by_groups', substract_fields($student, $this->FIELDS));
        return $id;
    }
    
    public function update($student)
    {
        $this->db->update('students_by_groups', $cleanFamily, 'groups_id = '.$id.' AND student_id = '.$student_id);
        return $id;
    }
}

/* End of file student_by_group_model.php */
/* Location: ./application/models/student_by_group_model.php */
