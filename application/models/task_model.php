<?php

/**
 * Gestión de tareas
 *
 * @author Leonardo Quintero
 */
class Task_model extends CI_Model {

    public $FIELDS = [
        "id",
        "start_date",
        "end_date",
        "task",
        "description",
        "imporance",
        "task_type_id",
        "task_state_id",
        "login_id"
    ];
    
    private $DEFAUL_FILTER = [
        'start_date' => NULL
    ];

    public function __construct() {
        parent::__construct();
    }

    public function get_all($filter = []) {
        $this->db->select('task.*, task_type.name AS task_type_name, task_state.name AS task_state_name, login.email AS login_email')
                ->from('task')
                ->join('task_type', 'task.task_type_id = task_type.id')
                ->join('task_state', 'task.task_state_id = task_state.id')
                ->join('login', 'task.login_id = login.id')
                ->order_by('start_date', 'asc');        
        foreach ($this->DEFAUL_FILTER as $key => $defaultValue) {
            $value = array_key_exists($key, $filter) ? $filter[$key] : $defaultValue;
            switch ($key) {
                default:
                    if (!empty($value))
                        $this->db->where($key, $value);
            }
        }
        $where = "(task_type_id = 1 OR login_id = " . $this->session->userdata('id') . ")"; 
        $this->db->where($where);
        return $this->db->get()->result_array();
    }

    public function delete($id) {
        $this->db->delete('task', 'id = ' . $id);
        return $id;
    }

    public function add($task) {
        unset($task['id']);
        unset($task['task_type_name']);
        unset($task['task_state_name']);
        unset($task['login_email']);
        $this->db->trans_start();
        $this->db->insert('task', $task);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        return $id;
    }

    public function update($task) {
        $id = $task['id'];
        unset($task['id']);
        unset($task['task_type_name']);
        unset($task['task_state_name']);
        unset($task['login_email']);
        $this->db->update('task', $task, 'id = ' . $id);
        return $id;
    }

}

/* End of file task_model.php */
/* Location: ./application/models/task_model.php */
