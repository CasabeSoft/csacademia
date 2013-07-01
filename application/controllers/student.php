<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Gestión de los datos de un estudiante.
 *
 * @author Carlos Bello
 */
class Student extends Basic_controller {

    var $levels;
    var $academicPeriods;
    var $leaveReasons;
    var $relationships;
    var $schoolLevels;

    public function __construct() {
        parent::__construct();
        $this->template = 'templates/manager_page';
        $this->location = 'manager/';
        $this->menu_template = 'templates/manager_menu';
    }

    public function admin() {
        $this->current_page();
        $this->title = lang('page_manage_students');
        $this->subject = lang('subject_student');
        $this->load->model('Group_model');
        $this->load->model('General_model');
        $this->editMode = is_null($this->session->userdata('current_center')['id']) ? 'false' : 'true';
        $this->levels = $this->db->select("code, description")->from('level')->get()->result_array();
        $this->groups = $this->Group_model->get_all();
        $this->leaveReasons = $this->db->select("code, description")->from('leave_reason')->get()->result_array();
        $this->relationships = $this->db->select("code, name")->from('family_relationship')->get()->result_array();
        $this->schoolLevels = $this->db->select("id, name")->from('school_level')->get()->result_array();
        $this->payments_types = $this->General_model->get_fields('payment_type', 'id, name');
        $this->load_page('student_admin');
    }

    protected function _echo_json_error($error) {
        http_response_code(500);
        echo json_encode($error);
    }

    public function get() {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->get_all());
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function add() {
        $this->setup_ajax_response_headers();
        try {
            $contact = $this->input->post();
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->add($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function delete($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function update() {
        $this->setup_ajax_response_headers();
        try {
            $contact = $this->input->post();
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->update($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function family_get($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Family_model');
            echo json_encode($this->Family_model->get_all($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function family_delete($student_id, $contact_id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Family_model');
            echo json_encode($this->Family_model->delete($student_id, $contact_id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function family_add() {
        $this->setup_ajax_response_headers();
        try {
            $family = $this->input->post();
            $this->load->model('Family_model');
            echo json_encode($this->Family_model->add($family));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function family_update() {
        $this->setup_ajax_response_headers();
        try {
            $family = $this->input->post();
            $this->load->model('Family_model');
            echo json_encode($this->Family_model->update($family));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function payments_get($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Payment_model');
            echo json_encode($this->Payment_model->get_all($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function payment_delete($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Payment_model');
            echo json_encode($this->Payment_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function payment_add() {
        $this->setup_ajax_response_headers();
        try {
            $payment = $this->input->post();
            $this->load->model('Payment_model');
            echo json_encode($this->Payment_model->add($payment));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function payment_update() {
        $this->setup_ajax_response_headers();
        try {
            $payment = $this->input->post();
            $this->load->model('Payment_model');
            echo json_encode($this->Payment_model->update($payment));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function payments_report($id) {

        /* $this->setup_ajax_response_headers();
          try {
          $this->load->model('Payment_model');
          echo json_encode($this->Payment_model->get_all($id));
          } catch (Exception $e) {
          $this->_echo_json_error($e->getMessage());
          } */

        /* $this->load->model('Payment_model');
          //echo json_encode($this->Payment_model->get_all($id));
          $this->load->library('PHPReport');
          $xxx = $this->Payment_model->get_all($id);
          $R = new PHPReport();
          $R->load(array(
          'id' => 'product',
          'data' => $xxx
          )

          );

          $R->render(); */
        try {
            $this->load->model('Payment_model');

            $payments = $this->Payment_model->get_all($id);
            $this->load->library('mpdf');
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
.gradient {
	border:0.1mm solid #220044; 
	background-color: #f0f2ff;
	background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
	box-shadow: 0.3em 0.3em #888888;
}
.rounded {
	border:0.1mm solid #220044; 
	background-color: #f0f2ff;
	background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
	border-radius: 2mm;
	background-clip: border-box;
}

table.list {
	border:1px solid #000000;
	font-family: sans-serif;
	font-size: 10pt;
	background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
}
table.list td, th {
	border:1px solid #000000;
	text-align: left;
	font-weight: normal;
}

</style>
<body>

<table border="0" width="100%" >
<tbody>
<tr>
<td rowspan="2" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
<td><p>Informe de Pagos</td>
</tr>
<tr>
<td><p>Alumno: </p></td>
</tr>
</tbody>
</table>
';

            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<td class="td_center">Fecha</td>';
            $html .= '<td class="td_center">Tipo de pago</td>';
            $html .= '<td class="td_center">Periodo</td>';
            $html .= '<td class="td_right">Importe</td>';
            $html .= '</tr></thead><tbody>';
            foreach ($payments AS $payment) {
                $html .= '<tr><td class="td_center">' . $payment['date'] . '</td>';
                $html .= '<td class="td_center">' . $payment['payment_type_name'] . '</td>';
                $html .= '<td class="td_center">' . $payment['piriod'] . '</td>';
                $html .= '<td class="td_right">' . $payment['amount'] . '</td></tr>';
            }
            $html .='</tbody></table>
<br />
<body>';
            //$this->setup_ajax_response_headers();
            //header("Content-Type: text/plain");
            //header('Content-type: application/pdf');
            $this->mpdf->WriteHTML($html);
            $this->mpdf->Output('pagos.pdf', 'I'); //exit;
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function payment_report($id) {

        try {
            $this->load->model('Payment_model');

            $payment = $this->Payment_model->get_payment_id($id);
            $this->load->library('mpdf');
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

.gradient {
	border:0.1mm solid #220044; 
	background-color: #f0f2ff;
	background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
	box-shadow: 0.3em 0.3em #888888;
}
.rounded {
	border:0.1mm solid #220044; 
	background-color: #f0f2ff;
	background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
	border-radius: 2mm;
	background-clip: border-box;
}
div.text {
	padding:0.8em; 
	margin-bottom: 0.7em;
}
p { 
        margin: 0.25em 0; 
}
table.list {
	border:1px solid #000000;
	font-family: sans-serif;
	font-size: 10pt;
	background-gradient: linear #c7cdde #f0f2ff 0 1 0 0.5;
}
table.list td, th {
	border:1px solid #000000;
	text-align: left;
	font-weight: normal;
}
.code {
	font-family: monospace;
	font-size: 9pt;
	background-color: #d5d5d5; 
	margin: 0.5em 0 0.5cm 0;
	padding: 0 0.3cm;
	border:0.2mm solid #000088; 
	box-shadow: 0.3em 0.3em #888888;
}
</style>
<body>

<div class="gradient text rounded">
<table border="0" width="100%" >
<tbody>
<tr>
<td rowspan="2" style=""><img src="/assets/img/logo.png" width="140" /></td>
<td><p style="font-size: 20px">RECIBO</td>
</tr>
<tr>
<td><p>
';
            $html .= 'Fecha: ' . $payment['date'];
            $html .= '
</p></td>
</tr>
</tbody>
</table>
</div>

<div class="gradient text rounded">
<p> Recibí de: </p>
<p>La cantidad de euros: </p>
<p> </p>
<p class="code"> <br> <br></p>
<p>Por: Pago 
';
            $html .= $payment['payment_type_name'] . '  ' .$payment['piriod'];
            $html .= '</p>
<p > </p>
<p>€  
';
            $html .= $payment['amount'];
            $html .= '
 Firmado: __________________________</p>
</div>           
<br />
<br />
<p> -------------------------------------------------------------------------------------------------------------------------------------------------------- </p>
<br />
<br />
<div class="gradient text rounded">
<table border="0" width="100%" >
<tbody>
<tr>
<td rowspan="2" style=""><img src="/assets/img/logo.png" width="140" /></td>
<td><p style="font-size: 20px">RECIBO</td>
</tr>
<tr>
<td><p>
';
            $html .= 'Fecha: ' . $payment['date'];
            $html .= '
</p></td>
</tr>
</tbody>
</table>
</div>

<div class="gradient text rounded">
<p> Recibí de: </p>
<p>La cantidad de euros: </p>
<p> </p>
<p class="code"> <br> <br></p>
<p>Por: Pago 
';
            $html .= $payment['payment_type_name'] . '  ' .$payment['piriod'];
            $html .= '</p>
<p > </p>
<p>€  
';
            $html .= $payment['amount'];
            $html .= '
 Firmado: __________________________</p>
</div>           
<br />
<body>';
            //$this->setup_ajax_response_headers();
            //header("Content-Type: text/plain");
            //header('Content-type: application/pdf');
            $this->mpdf->WriteHTML($html);
            $this->mpdf->Output('pagos.pdf', 'I'); //exit;
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

}

/* End of file teacher.php */
/* Location: ./application/controllers/teacher.php */  