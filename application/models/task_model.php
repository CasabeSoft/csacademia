<?php

/**
 * Gestión de tareas
 *
 * @author Leonardo Quintero
 */
class Task_model extends CI_Model
{

    private $client_id;
    public $FIELDS = [
        "id",
        "start_date",
        "start_time",
        "end_date",
        "end_time",
        "task",
        "description",
        "imporance",
        "task_type_id",
        "task_state_id",
        "login_id"
    ];
    private $DEFAUL_FILTER = [
        'start_date' => null,
        'dialy' => true
    ];

    public function __construct()
    {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
    }

    public function get_all($filter = [])
    {
        $this->db->select('task.*, task_type.name AS task_type_name, task_importance.name AS task_importance_name, task_state.name AS task_state_name, login.email AS login_email')
                ->from('task')
                ->join('task_type', 'task.task_type_id = task_type.id')
                ->join('task_importance', 'task.task_importance_id = task_importance.id')
                ->join('task_state', 'task.task_state_id = task_state.id')
                ->join('login', 'task.login_id = login.id')
                ->where('task.client_id = ' . $this->client_id)
                ->order_by('start_date, start_time', 'asc');

        $dialy = array_key_exists('dialy', $filter) ? $filter['dialy'] : $this->DEFAUL_FILTER['dialy'];
        $start_date = array_key_exists('start_date', $filter) ? $filter['start_date'] : $this->DEFAUL_FILTER['start_date'];
        if ($dialy == 'true') {
            if (!empty($start_date)) {
                $this->db->where('start_date <= ', $start_date);
                $this->db->where('end_date >= ', $start_date);
                //$this->db->where('start_date', $start_date);
            }
        } else {
            if (!empty($start_date)) {
                $date = explode('-', $start_date);
                $this->db->where('YEAR(start_date)', $date[0]);
                $this->db->where('MONTH(start_date)', $date[1]);
            }
        }
        /* foreach ($this->DEFAUL_FILTER as $key => $defaultValue) {
          $value = array_key_exists($key, $filter) ? $filter[$key] : $defaultValue;
          switch ($key) {

          default:
          if (!empty($value))
          $this->db->where($key, $value);
          }
          } */
        $where = "(task_type_id = 1 OR login_id = " . $this->session->userdata('id') . ")";
        $this->db->where($where);
        return $this->db->get()->result_array();
    }

    public function delete($id)
    {
        $this->db->delete('task', 'id = ' . $id);
        return $id;
    }

    public function add($task)
    {
        unset($task['id']);
        unset($task['task_type_name']);
        unset($task['task_state_name']);
        unset($task['login_email']);
        $task['client_id'] = $this->client_id;
        $this->db->trans_start();
        $this->db->insert('task', $task);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        return $id;
    }

    public function update($task)
    {
        $id = $task['id'];
        unset($task['id']);
        unset($task['task_type_name']);
        unset($task['task_state_name']);
        unset($task['login_email']);
        unset($contact['client_id']);
        $this->db->update('task', $task, 'id = ' . $id . ' AND client_id = ' . $this->client_id);
        return $id;
    }
}

/* End of file task_model.php */
/* Location: ./application/models/task_model.php */
