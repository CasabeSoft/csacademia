<?php

/**
 * Gestión de grupos
 *
 * @author Leonardo Quintero
 */
class Group_model extends CI_Model {

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

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        return $this->db->from('group')
                        ->get()->result_array();
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
