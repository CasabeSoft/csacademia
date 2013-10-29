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
        "group_id",
        "bank_notes"
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
        $this->db->select('contact.*, student.*, group.name as group_name, academic_period.name as course')
                ->from('contact')
                ->join('student', 'contact.id = student.contact_id')
                ->join('group', 'group.id = student.group_id', 'left outer')
                ->join('academic_period', 'academic_period.code = group.academic_period', 'left outer')
                ->where('contact.client_id', $this->client_id)
                ->order_by("first_name, last_name", "asc");
        if ($this->center_id != NULL)
            $this->db->where('student.center_id', $this->center_id);
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
        $this->db->select('contact.*, group.name')
                ->from('contact')
                ->join('student', 'contact.id = student.contact_id')
                ->join('group', 'student.group_id = group.id')
                ->where('client_id', $this->client_id)
                ->order_by("group.name, first_name, last_name", "asc");
        if ($isActive != NULL) {
            if ($isActive == 'true')
                $this->db->where('end_date IS NULL');
            else
                $this->db->where('end_date IS NOT NULL');
        }
        if ($center != 0)
            $this->db->where('student.center_id', $center);

        if ($month != 0) {
            $this->db->where('MONTH(date_of_birth)', $month);
        }
        return $this->db->get()->result_array();
    }

    public function get_payments($center = 0, $payment_type = 0, $month = 0, $state = 0) {
        $isActive = 'true';
        //$start_date = ' AND ' . date("m") . ' >= MONTH(start_date) AND ' . date("Y") . ' >= YEAR(start_date)';
        $start_date = '';
        $filter_month = '';
        $filter_payment_type = '';
        $filter_bank_payment = ' AND student.bank_payment = 0';
        if ($month != '0') {
            $filter_month = " AND piriod = '" . $month . "'";
            $months = array(1 => lang('form_january'), 2 => lang('form_february'), 3 => lang('form_march'), 4 => lang('form_april'),
                5 => lang('form_may'), 6 => lang('form_june'), 7 => lang('form_july'), 8 => lang('form_august'),
                9 => lang('form_september'), 10 => lang('form_october'), 11 => lang('form_november'), 12 => lang('form_december'));
            $key = array_search($month, $months);
            //$filter_month = ' AND MONTH(date) = ' . $month;
            $start_date = ' AND ( YEAR(start_date) < ' . date("Y") . ' OR ( YEAR(start_date) = ' . date("Y") . ' AND MONTH(start_date) <= ' . $key . ') )';
        }
        if ($payment_type != 0) {
            $filter_payment_type = ' AND payment_type_id = ' . $payment_type;
        }
        $this->db->select('contact.*, payment.*, payment_type.name as payment_type_name ')
                ->from('contact')
                ->join('student', 'contact.id = student.contact_id ' . $filter_bank_payment . $start_date)
                ->join('payment', 'payment.student_id = student.contact_id ' . $filter_month . $filter_payment_type, 'left outer')
                ->join('payment_type', 'payment.payment_type_id = payment_type.id', 'left outer')
                ->where('client_id', $this->client_id)                
                ->order_by("date, first_name, last_name", "asc");
                //->order_by("first_name, last_name", "asc");
        if ($isActive != NULL) {
            if ($isActive == 'true')
                $this->db->where('end_date IS NULL');
            else
                $this->db->where('end_date IS NOT NULL');
        }
        if ($center != 0)
            $this->db->where('center_id', $center);
        if ($state != 0) {
            if ($state == 1)
                $this->db->where('date IS NOT NULL');
            else
                $this->db->where('date IS NULL');
        }
        return $this->db->get()->result_array();
    }
    
    public function get_payments_bank($center = 0) {
        $isActive = 'true';
        //$start_date = ' AND ' . date("m") . ' >= MONTH(start_date) AND ' . date("Y") . ' >= YEAR(start_date)';
        $start_date = '';
        //$filter_month = '';
        //$filter_payment_type = '';
        $filter_bank_payment = ' AND student.bank_payment = 1';
        /*if ($month != '0') {
            $filter_month = " AND piriod = '" . $month . "'";
            $months = array(1 => lang('form_january'), 2 => lang('form_february'), 3 => lang('form_march'), 4 => lang('form_april'),
                5 => lang('form_may'), 6 => lang('form_june'), 7 => lang('form_july'), 8 => lang('form_august'),
                9 => lang('form_september'), 10 => lang('form_october'), 11 => lang('form_november'), 12 => lang('form_december'));
            $key = array_search($month, $months);
            //$filter_month = ' AND MONTH(date) = ' . $month;
            $start_date = ' AND ( YEAR(start_date) < ' . date("Y") . ' OR ( YEAR(start_date) = ' . date("Y") . ' AND MONTH(start_date) <= ' . $key . ') )';
        }
        if ($payment_type != 0) {
            $filter_payment_type = ' AND payment_type_id = ' . $payment_type;
        }*/
        $this->db->select('contact.*, student.bank_notes')
                ->from('contact')
                ->join('student', 'contact.id = student.contact_id ' . $filter_bank_payment . $start_date)
                //->join('payment', 'payment.student_id = student.contact_id ' . $filter_month . $filter_payment_type, 'left outer')
                //->join('payment_type', 'payment.payment_type_id = payment_type.id', 'left outer')
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
        /*if ($state != 0) {
            if ($state == 1)
                $this->db->where('date IS NOT NULL');
            else
                $this->db->where('date IS NULL');
        }*/
        return $this->db->get()->result_array();
    }

    public function get_by_group($groups_id) {
        $isActive = 'true';
        $this->db->select('student.*, contact.*, school_level.name')
                ->from('student')
                ->join('contact', 'contact.id = student.contact_id')
                ->join('school_level', 'school_level.id = student.school_level', 'left outer')
                ->where('group_id', $groups_id)
                ->order_by("contact.last_name, contact.first_name", "asc");
                //->order_by("contact.first_name, contact.last_name", "asc");
        if ($isActive != NULL) {
            if ($isActive == 'true')
                $this->db->where('end_date IS NULL');
            else
                $this->db->where('end_date IS NOT NULL');
        }
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
