<?php

/**
 * Gestión de grupos
 *
 * @author Leonardo Quintero
 */
class Group_model extends CI_Model {

    private $client_id;
    private $center_id;
    public $FIELDS = [
        "id",
        "name",
        "center_id",
        "classroom_id",
        "teacher_id",
        "level_code",
        "academic_period",
        "monday",
        "tuesday",
        "wednesday",
        "thursday",
        "friday",
        "saturday",
        "start_time",
        "end_time"
    ];
    private $DEFAUL_FILTER = [
        'academic_period' => NULL
    ];

    public function __construct() {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
        $this->center_id = $this->session->userdata('current_center')['id'];
    }

    public function get_all($filter = []) {
        $this->db->select('group.*')
                ->from('group')
                ->join('center', 'group.center_id = center.id')
                ->where('client_id ', $this->client_id)
                ->order_by('name', 'asc');
        if ($this->center_id != NULL)
            $this->db->where('center_id', $this->center_id);
        foreach ($this->DEFAUL_FILTER as $key => $defaultValue) {
            $value = array_key_exists($key, $filter) ? $filter[$key] : $defaultValue;
            switch ($key) {
                default:
                    if (!empty($value))
                        $this->db->where($key, $value);
            }
        }
        return $this->db->get()->result_array();
    }

    public function get_all_with_academic_period() {
        $this->db->select('group.*, academic_period.name academic_period_name')
                ->from('group')
                ->join('center', 'group.center_id = center.id')
                ->join('academic_period', 'group.academic_period = academic_period.code')
                ->where('client_id ', $this->client_id)
                ->order_by('academic_period_name desc, name asc');
        if ($this->center_id != NULL)
            $this->db->where('center_id', $this->center_id);
        return $this->db->get()->result_array();
    }

    public function get_group_report($filter = []) {
        $this->db->select('group.*, center.name as center,  classroom.name as classroom, academic_period.name as period, level.description as level, contact.first_name, contact.last_name')
                ->from('group')
                ->join('contact', 'group.teacher_id = contact.id and contact.client_id = ' . $this->client_id)
                ->join('level', 'group.level_code = level.code and level.client_id = ' . $this->client_id)
                ->join('academic_period', 'group.academic_period = academic_period.code')
                ->join('classroom', 'group.classroom_id = classroom.id and group.center_id = classroom.center_id')
                ->join('center', 'group.center_id = center.id')
                ->where('center.client_id ', $this->client_id)
                ->order_by('period, center, name', 'asc');
        if ($this->center_id != NULL)
            $this->db->where('group.center_id', $this->center_id);
        foreach ($this->DEFAUL_FILTER as $key => $defaultValue) {
            $value = array_key_exists($key, $filter) ? $filter[$key] : $defaultValue;
            switch ($key) {
                default:
                    if (!empty($value))
                        $this->db->where($key, $value);
            }
        }
        return $this->db->get()->result_array();
    }

    public function get_by_id($id) {
        $this->db->select('group.*, center.name as center, contact.first_name, contact.last_name, level.description as level, classroom.name as classroom')
                ->from('group')
                ->join('level', 'group.level_code = level.code and level.client_id = ' . $this->client_id)
                ->join('contact', 'group.teacher_id = contact.id')
                ->join('center', 'group.center_id = center.id')
                ->join('classroom', 'group.classroom_id = classroom.id')
                ->where('center.client_id', $this->client_id)
                ->where('group.id', $id);

        return $this->db->get()->row_array();
    }

    public function delete($id) {
        $this->db->delete('group', 'id = ' . $id);
        return $id;
    }

    public function add($group) {
        unset($group['id']);
        $this->db->trans_start();
        $this->db->insert('group', $group);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        return $id;
    }

    public function update($group) {
        $id = $group['id'];
        unset($group['id']);
        $this->db->update('group', $group, 'id = ' . $id);
        return $id;
    }

}

/* End of file group_model.php */
/* Location: ./application/models/gruop_model.php */
