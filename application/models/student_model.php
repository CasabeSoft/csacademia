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
        'leave_reason_code',
        'start_date',
        'end_date',
        'school_level',
        'group_id'
    ];
    private $DEFAUL_FILTER = [
        'isActive' => 'true',
        'group_id' => NULL
    ];

    public function __construct() {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
        $this->center_id = $this->session->userdata('current_center')['id'];
        $this->load->model('Contact_model');
    }

    public function get_all($filter = []) {
        $this->db->from('contact')
                ->join('student', 'contact.id = student.contact_id')
                ->where('client_id', $this->client_id)
                ->order_by("first_name, last_name", "asc");
        if ($this->center_id != NULL)
            $this->db->where('center_id', $this->center_id);
        foreach ($this->DEFAUL_FILTER as $key => $defaultValue) {
            $value = array_key_exists($key, $filter) ? $filter[$key] : $defaultValue;
            switch ($key) {
                case 'isActive':
                    if ($value == 'true')
                        $this->db->where('end_date IS NULL');
                    else
                        $this->db->where('end_date IS NOT NULL');
                    break;
                default:
                    if (!empty($value))
                        $this->db->where($key, $value);
            }
        }
        return $this->db->get()->result_array();
    }

    public function get_birthday($isActive = NULL, $center = 0, $month = 0) {
        $this->db->from('contact')
                ->join('student', 'contact.id = student.contact_id')
                ->where('client_id', $this->client_id)
                ->order_by("first_name, last_name", "asc");
        if ($isActive != NULL) {
            if ($isActive == 'true')
                $this->db->where('end_date IS NULL');
            else
                $this->db->where('end_date IS NOT NULL');
        }
        if ($center != 0)
            $this->db->where('center_id', $center);
        
        if ($month != 0) {
            $this->db->where('MONTH(date_of_birth)', $month);
        }
        return $this->db->get()->result_array();
    }
    
    public function get_payments($center = 0, $payment_type=0, $month = 0) {
        $isActive = 'true';
        $this->db->select('contact.*, payment.*, payment_type.name as payment_type_name ')
                ->from('contact')
                ->join('student', 'contact.id = student.contact_id')
                ->join('payment', 'payment.student_id = student.contact_id', 'left outer') //
                ->join('payment_type', 'payment.payment_type_id = payment_type.id')
                ->where('client_id', $this->client_id)
                ->order_by("first_name, last_name", "asc");
        if ($isActive != NULL) {
            if ($isActive == 'true')
                $this->db->where('end_date IS NULL');
            else
                $this->db->where('end_date IS NOT NULL');
        }
        if ($center != 0)
            $this->db->where('center_id', $center);
        
        if ($payment_type != 0) {
            $this->db->where('payment_type_id', $payment_type);
        }
        if ($month != 0) {
            $this->db->where('MONTH(date)', $month);
        }
        return $this->db->get()->result_array();
    }

    public function get_by_group($groups_id) {
        $this->db->from('student')
                ->join('contact', 'contact.id = student.contact_id')
                ->where('group_id', $groups_id);
        if ($this->center_id != NULL)
            $this->db->where('center_id', $this->center_id);
        return $this->db->get()->result_array();
    }

    public function get_price_by_student($student_id) {
        $level = $this->db->select('price')
                ->from('student')
                ->join('group', 'group.id = student.group_id')
                ->join('level', 'level.code = group.level_code')
                ->where('contact_id', $student_id)
                ->get();
        return $level->num_rows() > 0 ? $level->row()->price : NULL;
    }

    public function get_group_by_student($student_id) {
        $level = $this->db->select('group_id')->from('student')
                ->where('contact_id', $student_id)
                ->get();
        return $level->num_rows() > 0 ? $level->row()->group_id : NULL;
    }

    public function get_level_by_group($groups_id) {
        $level = $this->db->select('level_code')->from('group')
                ->where('id', $groups_id)
                ->get();
        return $level->num_rows() > 0 ? $level->row()->level_code : NULL;
    }

    public function get_price_by_level($level_code) {
        $level = $this->db->select('price')->from('level')
                ->where('code', $level_code)
                ->get();
        return $level->num_rows() > 0 ? $level->row()->price : NULL;
    }

    public function delete($id) {
        $this->db->delete('student', 'contact_id = ' . $id);  // Por si no hubiese eliminación en cascada
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
        $this->db->update('student', convert_nullables($cleanStudent, $this->NULLABLES), 'contact_id = ' . $id);
        $this->db->trans_complete();
        return $id;
    }

    public function update_group($student_id, $groups_id) {
        //$this->db->update('student', '', 'contact_id = ' . $student_id);
        //$this->db->update('student')->where('contact_id', $student_id)->set('group_id', $groups_id);
        $this->db->query('UPDATE `student` SET `group_id` = ' . $groups_id . ' WHERE `contact_id` = ' . $student_id);
        return $student_id;
    }

}

/* End of file teacher_model.php */
/* Location: ./application/models/student_model.php */
