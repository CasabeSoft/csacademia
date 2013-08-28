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
            $value = array_key_exists($key, $filter)
                    ? $filter[$key]
                    : $defaultValue;
            switch ($key)
            {
                default:
                    if (! empty($value))
                        $this->db->where($key, $value);
            }            
        }
        return $this->db->get()->result_array();
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
