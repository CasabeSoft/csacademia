<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para la gestión de Grupos
 * 
 * @author Leonardo Quintero
 */
class Group extends Basic_controller {

    public function __construct() {
        parent::__construct();
        $this->template = 'templates/manager_page';
        $this->location = 'manager/';
        $this->menu_template = 'templates/manager_menu';
    }

    public function admin() {
        $this->current_page();
        $this->title = lang('page_manage_groups');
        $this->subject = lang('subject_group');
        $this->load->model('General_model');
        $this->load->model('Teacher_model');
        $this->load->model('Student_model');
        $this->centers = $this->General_model->get_fields('center', 'id, name');
        $this->classrooms = $this->General_model->get_fields('classroom', 'id, name, capacity');
        $this->teachers = $this->Teacher_model->get_all();
        $this->levels = $this->General_model->get_fields('level', 'code, description');
        $this->academic_periods = $this->General_model->get_fields('academic_period', 'code, name');
        $this->students = $this->Student_model->get_all();
        $this->defaultAcademicPeriod = $this->General_model->get_default_academic_period();
        $this->load_page('group_admin');
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
            $this->load->model('Group_model');
            echo json_encode($this->Group_model->get_all($filter));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function add() {
        $this->setup_ajax_response_headers();
        try {
            $group = $this->input->post();
            $this->load->model('Group_model');
            echo json_encode($this->Group_model->add($group));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function delete($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Group_model');
            echo json_encode($this->Group_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function update() {
        $this->setup_ajax_response_headers();
        try {
            $group = $this->input->post();
            $this->load->model('Group_model');
            echo json_encode($this->Group_model->update($group));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function students_get($groups_id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->get_by_group($groups_id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function student_delete($student_id) {
        $this->setup_ajax_response_headers();
        try {
            $groups_id = 'NULL';
            
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->update_group($student_id, $groups_id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function student_add($student_id, $groups_id) {
        $this->setup_ajax_response_headers();
        try {
            //$student_id = $this->input->post('contact_id');
            //$groups_id = $this->input->post('group_id');
            
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->update_group($student_id, $groups_id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function student_update($student_id, $groups_id) {
        $this->setup_ajax_response_headers();
        try {
            //$student_id = $this->input->post('contact_id');
            //$groups_id = $this->input->post('group_id');
            
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->update_group($student_id, $groups_id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function get_attendance_for_date($group_id, $date) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Attendance_model');
            echo json_encode($this->Attendance_model->get_attendance_for_date($group_id, $date));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
 
    public function get_attendance_for_month($group_id, $year, $month) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Attendance_model');
            echo json_encode($this->Attendance_model->get_attendance_for_month($group_id, $year, $month));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }   
    public function add_student_attendance($student_id, $date) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Attendance_model');
            echo json_encode($this->Attendance_model->add_student_attendance($student_id, $date));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function delete_student_attendance($student_id, $date) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Attendance_model');
            echo json_encode($this->Attendance_model->delete_student_attendance($student_id, $date));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
        public function report_attendance($group_id, $month, $year) {

        try {
           // $this->load->model('Payment_model');
           // $this->load->model('General_model');
           // $this->load->helper('Util_helper');

           // $payments = $this->Payment_model->get_all($id);
          //  $student = $this->General_model->get_where('contact', 'id = ' . $id);
            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4');
            $html = '
<style>
.td_center{
        text-align:center; 
        padding: 0 0.5em;
}
.td_right{
        text-align:right; 
        padding: 0 0.5em;
}

table.list {
	border:1px solid #000000;
	font-family: sans-serif; /*sans-serif; Arial Unicode MS;*/
	font-size: 10pt;
	background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
}
table.list td, th {
	border:1px solid #000000;
	text-align: left;
	font-weight: normal;
}
.title-font{

}
</style>
<body>

<table border="0" width="100%" >
<tbody>
<tr>
<td rowspan="2" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
<td><p><b>Informe de Asistencia</b></td>
</tr>
<tr>
<td><p>Grupo: ';
$html .= $group_id . ' Mes: ' . $month . '/' . $year;            
$html .= '</p></td>
</tr>
</tbody>
</table>
';
            
            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<td class="td_center">#</td>';
            $html .= '<td class="td_center">Fecha</td>';
            $html .= '<td class="td_center">Tipo de pago</td>';
            $html .= '<td class="td_center">Periodo</td>';
            $html .= '<td class="td_right">Importe</td>';
            $html .= '</tr></thead><tbody>';
            /*$count = 1;
            foreach ($payments AS $payment) {
                $dateNormal = db_to_Local($payment['date']);
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td class="td_center">' . $dateNormal . '</td>';
                $html .= '<td class="td_center">' . $payment['payment_type_name'] . '</td>';
                $html .= '<td class="td_center">' . $payment['piriod'] . '</td>';
                $html .= '<td class="td_right">' . $payment['amount'] . '</td></tr>';
                $count++;
            }*/
            $html .='</tbody></table>
<br />
<body>';
            //$this->setup_ajax_response_headers();
            //header("Content-Type: text/plain");
            //header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('pagos.pdf', 'I'); //exit;
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

}

/* End of file group.php */
/* Location: ./application/controllers/group.php */
