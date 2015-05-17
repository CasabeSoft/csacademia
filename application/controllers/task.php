<<<<<<< OURS
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para la gestión de las tareas
 * 
 * @author Leonardo Quintero
 */
class Task extends Basic_controller {

    public function __construct() {
        parent::__construct();
        if (!isLogged()) {
            redirect('/login');
            exit;
        }
        $this->template = 'templates/manager_page';
        $this->location = 'manager/';
        $this->menu_template = 'templates/manager_menu';
    }

    public function admin() {
        $this->current_page();
        $this->title = lang('page_manage_tasks');
        $this->subject = lang('title_tasks');
        $this->load->model('General_model');
        $this->load->model('Task_model');
        $this->current_user = $this->session->userdata('id');
        $this->tasks_types = $this->General_model->get_fields('task_type', 'id, name');
        $this->tasks_importances = $this->General_model->get_fields('task_importance', 'id, name', 'client_id = ' . $this->client_id);
        $this->tasks_states = $this->General_model->get_fields('task_state', 'id, name, color', 'client_id = ' . $this->client_id);
        $this->users = $this->General_model->get_fields('login', 'id, email');
        $this->load_page('task_admin');
    }

    protected function _echo_json_error($error) {
        http_response_code(500);
        echo json_encode($error);
    }

    public function get() {
        $this->setup_ajax_response_headers();
        try {
            $filter = $this->input->post();
            if (!is_array($filter))
                $filter = [];
            $this->load->model('Task_model');
            echo json_encode($this->Task_model->get_all($filter));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function add() {
        $this->setup_ajax_response_headers();
        try {
            $task = $this->input->post();
            $this->load->model('Task_model');
            echo json_encode($this->Task_model->add($task));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function delete($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Task_model');
            echo json_encode($this->Task_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function update() {
        $this->setup_ajax_response_headers();
        try {
            $task = $this->input->post();
            
            $this->load->model('Task_model');
            echo json_encode($this->Task_model->update($task));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function tasks_report($date, $dialy) {
        try {
            $this->load->model('Task_model');
            $this->load->model('General_model');
            $this->load->helper('Util_helper');
            
            $filter = array('start_date' => $date, 'dialy' => $dialy);

            $tasks = $this->Task_model->get_all($filter);
            $client_info = $this->General_model->get_info_client_id($this->client_id);

            $logo_print = isset($client_info['report_logo']) ? $client_info['report_logo'] : 'logo_csacademia_print.png';
            
            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4');
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);
            
            $start_date = explode('-', $date);
            
            if ($dialy == 'true') {
                $text_date = '<b>' . lang('form_date') . ': </b>' . $start_date[2] . '/' . $start_date[1] . '/' .  $start_date[0];
            } else {
                $months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", 
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                $text_date = '<b>' . lang('form_month') . ': </b>' . $months[intval($start_date[1])-1] . '/' .  $start_date[0];
            }

            $html = '
<body>
    <table border="0" width="100%" >
        <tbody>
            <tr>
                <td rowspan="2" style="text-align: right;"><img src="./assets/uploads/files/client/' . $logo_print . '" width="140" /></td>
                <td><p class="title-font"><b>' . lang('menu_tasks') . '</b></td>
            </tr>
            <tr>
                <td><p>';
            $html .= $text_date . '</p></td>
            </tr>
        </tbody>
    </table>
';
            $html .= '<br>';
            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th class="td_center"></th>';
            //if ($dialy == 'false') {
                $html .= '<th>' . lang('form_date') . '</th>';
            //}
            $html .= '<th>' . lang('form_time') . '</th>';
            $html .= '<th>' . lang('form_task') . '</td>';
            $html .= '<th>' . lang('form_description') . '</td>';
            $html .= '<th>' . lang('form_importance') . '</td>';
            $html .= '<th>' . lang('form_type') . '</td>';
            $html .= '<th>' . lang('form_state') . '</td>';
            $html .= '<th>' . lang('subject_user') . '</td>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($tasks AS $task) {
                $start_date_text = db_to_Local($task['start_date']);
                $end_date = db_to_Local($task['end_date']);
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                //if ($dialy == 'false') {
                    $html .= '<td>' . $start_date_text . '</td>';
                //}
                $html .= '<td>' . substr($task['start_time'], 0, 5) . '</td>';
                $html .= '<td>' . $task['task'] . '</td>';
                $html .= '<td>' . $task['description'] . '</td>';
                $html .= '<td>' . $task['task_importance_name'] . '</td>';
                $html .= '<td>' . $task['task_type_name'] . '</td>';
                $html .= '<td>' . $task['task_state_name'] . '</td>';
                $html .= '<td>' . $task['login_email'] . '</td>';
                $html .= '</tr>';
                $count++;
            }
            $html .='</tbody></table>
<body>';
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('tareas.pdf', 'I'); //exit;
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
}

/* End of file task.php */
=======
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para la gestión de las tareas
 * 
 * @author Leonardo Quintero
 */
class Task extends Basic_controller {

    public function __construct() {
        parent::__construct();
        if (!isLogged()) {
            redirect('/login');
            exit;
        }
        $this->template = 'templates/manager_page';
        $this->location = 'manager/';
        $this->menu_template = 'templates/manager_menu';
    }

    public function admin() {
        $this->current_page();
        $this->title = lang('page_manage_tasks');
        $this->subject = lang('title_tasks');
        $this->load->model('General_model');
        $this->load->model('Task_model');
        $this->current_user = $this->session->userdata('id');
        $this->tasks_types = $this->General_model->get_fields('task_type', 'id, name');
        $this->tasks_importances = $this->General_model->get_fields('task_importance', 'id, name');
        $this->tasks_states = $this->General_model->get_fields('task_state', 'id, name, color');
        $this->users = $this->General_model->get_fields('login', 'id, email');
        $this->load_page('task_admin');
    }

    protected function _echo_json_error($error) {
        http_response_code(500);
        echo json_encode($error);
    }

    public function get() {
        $this->setup_ajax_response_headers();
        try {
            $filter = $this->input->post();
            if (!is_array($filter))
                $filter = [];
            $this->load->model('Task_model');
            echo json_encode($this->Task_model->get_all($filter));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function add() {
        $this->setup_ajax_response_headers();
        try {
            $task = $this->input->post();
            $this->load->model('Task_model');
            echo json_encode($this->Task_model->add($task));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function delete($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Task_model');
            echo json_encode($this->Task_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function update() {
        $this->setup_ajax_response_headers();
        try {
            $task = $this->input->post();
            
            $this->load->model('Task_model');
            echo json_encode($this->Task_model->update($task));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function tasks_report($date, $dialy) {
        try {
            $this->load->model('Task_model');
            $this->load->model('General_model');
            $this->load->helper('Util_helper');
            
            $filter = array('start_date' => $date, 'dialy' => $dialy);

            $tasks = $this->Task_model->get_all($filter);
            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4');
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);
            
            $start_date = explode('-', $date);
            
            if ($dialy == 'true') {
                $text_date = '<b>' . lang('form_date') . ': </b>' . $start_date[2] . '/' . $start_date[1] . '/' .  $start_date[0];
            } else {
                $months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", 
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                $text_date = '<b>' . lang('form_month') . ': </b>' . $months[intval($start_date[1])-1] . '/' .  $start_date[0];
            }

            $html = '
<body>
    <table border="0" width="100%" >
        <tbody>
            <tr>
                <td rowspan="2" style="text-align: right;"><img src="/assets/img/logo_print.png" width="140" /></td>
                <td><p class="title-font"><b>' . lang('menu_tasks') . '</b></td>
            </tr>
            <tr>
                <td><p>';
            $html .= $text_date . '</p></td>
            </tr>
        </tbody>
    </table>
';
            $html .= '<br>';
            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th class="td_center"></th>';
            //if ($dialy == 'false') {
                $html .= '<th>' . lang('form_date') . '</th>';
            //}
            $html .= '<th>' . lang('form_time') . '</th>';
            $html .= '<th>' . lang('form_task') . '</td>';
            $html .= '<th>' . lang('form_description') . '</td>';
            $html .= '<th>' . lang('form_importance') . '</td>';
            $html .= '<th>' . lang('form_type') . '</td>';
            $html .= '<th>' . lang('form_state') . '</td>';
            $html .= '<th>' . lang('subject_user') . '</td>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($tasks AS $task) {
                $start_date_text = db_to_Local($task['start_date']);
                $end_date = db_to_Local($task['end_date']);
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                //if ($dialy == 'false') {
                    $html .= '<td>' . $start_date_text . '</td>';
                //}
                $html .= '<td>' . substr($task['start_time'], 0, 5) . '</td>';
                $html .= '<td>' . $task['task'] . '</td>';
                $html .= '<td>' . $task['task'] . '</td>';
                $html .= '<td>' . $task['task_importance_name'] . '</td>';
                $html .= '<td>' . $task['task_type_name'] . '</td>';
                $html .= '<td>' . $task['task_state_name'] . '</td>';
                $html .= '<td>' . $task['login_email'] . '</td>';
                $html .= '</tr>';
                $count++;
            }
            $html .='</tbody></table>
<body>';
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('tareas.pdf', 'I'); //exit;
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
}

/* End of file task.php */
>>>>>>> THEIRS
/* Location: ./application/controllers/task.php */  
