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

    function get_first_client() {
        $client_id = $this->db->select('id')->from('client')->limit(1)->get();
        return $client_id->num_rows() > 0
                ? $client_id->row()->id
                : NULL;                
    }
    
    function get_first_center($client_id) {
        $center = $this->db->select('id, name')
                ->from('center')
                ->where('client_id', $client_id)
                ->limit(1)
                ->get()->result_array();
        return count($center) > 0
                ? $center[0]
                : ['id' => NULL, 'name' => lang('menu_all_centers')];
    }
    
    function get_all_centers($client_id) {
        return $this->db->select('id, name')
                ->from('center')
                ->where('client_id', $client_id)
                ->get()->result_array();
    }
    
    function get_center($id) {
        $center = $this->db->select('id, name')
                ->from('center')
                ->where('id', $id)
                ->get()->result_array();
        return count($center) > 0
                ? $center[0]
                : ['id' => NULL, 'name' => lang('menu_all_centers')];
    }
}

?>
