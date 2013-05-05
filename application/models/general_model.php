<?php

/**
 * Modelo para la gestión general
 *
 * @author Leonardo Quintero
 */
class General_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all($table) {
        return $this->db->get($table)->result_array();
    }

    public function get_where($table, $where = '') {
        if (!empty($where)) {
            $this->db->where($where);
        }
        return $this->db->get($table)->result_array();
    }
    
    public function get_fields($table, $fields = '') {
        if (!empty($fields)) {
            $this->db->select($fields);
        }
        return $this->db->get($table)->result_array();
    }

    function insert($table, $fields) {
        $this->db->insert($table, $fields);
        return $this->db->insert_id();
    }

    function update($table, $fields, $where) {
        $this->db->update($table, $fields, $where);
        return $this->db->affected_rows();
    }

    function delete($table, $where) {
        $this->db->delete($table, $where);
        return;
    }            

}

?>
