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
        $this->title = lang('page_manage_students');
        $this->subject = lang('title_student');
        $this->load->model('Group_model');
        $this->load->model('General_model');
        $this->editMode = is_null($this->session->userdata('current_center')['id']) ? 'false' : 'true';
        $this->levels = $this->db->select("*")->from('level')->get()->result_array();
        $this->groups = $this->Group_model->get_all_with_academic_period();
        $this->leaveReasons = $this->db->select("code, description")->from('leave_reason')->get()->result_array();
        $this->relationships = $this->db->select("code, name")->from('family_relationship')->get()->result_array();
        $this->schoolLevels = $this->db->select("id, name")->from('school_level')->get()->result_array();
        $this->payments_types = $this->General_model->get_fields('payment_period_type', 'id, name');
        $this->academicPeriods = $this->General_model->get_fields('academic_period', 'code, name');
        $this->load_page('student_admin');
    }

    public function birthday() {
        $this->current_page();
        $this->title = lang('page_report_birthday');
        $this->subject = lang('subject_student');
        $this->load->model('General_model');
        $this->centers = $this->General_model->get_fields('center', 'id, name', array('client_id' => $this->client_id));
        $this->load_page('student_birthday');
    }

    public function payments() {
        $this->current_page();
        $this->title = lang('page_report_payments');
        $this->subject = lang('subject_student');
        $this->load->model('General_model');
        $this->centers = $this->General_model->get_fields('center', 'id, name', array('client_id' => $this->client_id));
        $this->payments_types = $this->General_model->get_fields('payment_period_type', 'id, name');
        $this->piriods_used = $this->General_model->get_fields('payment', 'DISTINCT payment_period_id');
        $this->load_page('student_payment');
    }
    
    public function payments_bank() {
        $this->current_page();
        $this->title = lang('page_report_payments_bank');
        $this->subject = lang('subject_student');
        $this->load->model('General_model');
        $this->centers = $this->General_model->get_fields('center', 'id, name', array('client_id' => $this->client_id));
        $this->load_page('student_payment_bank');
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
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->get_all($filter));
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

    public function family_get_available() {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Family_model');
            echo json_encode($this->Family_model->get_available());
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

    public function family_relate() {
        $this->setup_ajax_response_headers();
        try {
            $family = $this->input->post();
            $this->load->model('Family_model');
            echo json_encode($this->Family_model->relate($family));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function get_price_by_student($student_id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Student_model');
            echo json_encode($this->Student_model->get_price_by_student($student_id));
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
            $this->load->model('General_model');
            $this->load->helper('Util_helper');

            $payments = $this->Payment_model->get_all($id);
            $student = $this->General_model->get_where('contact', 'id = ' . $id);
            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4');
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);

            $html = '
<body>
    <table border="0" width="100%" >
        <tbody>
            <tr>
                <td rowspan="2" style="text-align: right;"><img src="/assets/img/logo_print.png" width="140" /></td>
                <td><p class="title-font"><b>' . lang('menu_payment') . '</b></td>
            </tr>
            <tr>
                <td><p><b>' . lang('form_student') . ': </b>';
            $html .= $student[0]['first_name'] . ' ' . $student[0]['last_name'];
            $html .= '</p></td>
            </tr>
        </tbody>
    </table>
';

            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th class="td_center"></th>';
            $html .= '<th>' . lang('form_date') . '</th>';
            $html .= '<th>' . lang('form_payment_type') . '</th>';
            $html .= '<th>' . lang('form_piriod') . '</td>';
            $html .= '<th class="td_right">' . lang('form_amount') . '</th>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            $amount = 0;
            foreach ($payments AS $payment) {
                $dateNormal = db_to_Local($payment['date']);
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $dateNormal . '</td>';
                $html .= '<td>' . $payment['payment_type_name'] . '</td>';
                $html .= '<td>' . $payment['piriod'] . '</td>';
                $html .= '<td class="td_right">' . $payment['amount'] . '</td></tr>';
                $amount += $payment['amount'];
                $count++;
            }
            $html .= '<tr><td colspan="4" class="td_center"><b>TOTAL</b></td>';
            $html .= '<td class="td_right"><b>' . number_format($amount, 2, '.', '') . '</b></td></tr>';
            $html .='</tbody></table>
<body>';
            //header("Content-Type: text/plain");
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('pagos.pdf', 'I'); //exit;
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    /* public function payment_report($id) {

      try {
      $this->load->model('Payment_model');

      $payment = $this->Payment_model->get_payment_id($id);
      $this->load->library('mpdf');
      $mpdf = new mPDF('c', array(100, 100));

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

      <p> </p>

      <p>Por: Pago
      ';
      //<p>La cantidad de euros: </p>
      //<p class="code"> <br> <br></p>
      $html .= $payment['payment_type_name'] . '  ' . $payment['piriod'];
      $html .= '</p>
      <p > </p>
      <p>€
      ';
      $html .= $payment['amount'];
      $html .= '
      Firmado: ______________</p>
      </div>
      </body>';
      //$this->setup_ajax_response_headers();
      header("Content-Type: text/plain");
      header('Content-type: application/pdf');
      $mpdf->WriteHTML($html);
      $mpdf->Output('pagos.pdf', 'I'); //exit;
      } catch (Exception $e) {
      $this->_echo_json_error($e->getMessage());
      }
      } */

    public function payment_report($id) {

        try {
            $this->load->library('mpdf');
            //$header = 'Document header ' . $id;
            //$html1 = 'Your document content goes here';
            //$footer = 'Print date: ' . date('d.m.Y H:i:s') . '<br />Page {PAGENO} of {nb}';

            $this->load->model('Payment_model');
            $this->load->helper('Util_helper');
            $payment = $this->Payment_model->get_payment_id($id);

            $dateDB = $payment['date'];

            $dateNormal = db_to_Local($dateDB);

            $html = '
            <body>
              <table  style="text-align: center" border="0" width="100%" >
              <tbody>
                  <tr>
                      <td ><img src="/assets/img/logo_print.png" width="150" /></td>              
                  </tr>
                  <tr>
                      <td>
                         <p style="font-size: 12px">Avda. Juan Carlos I, 92-2.14 
                         <p style="font-size: 12px">Avda. Juan Carlos I, 79-8 B&nbsp;&nbsp;
                         <p style="font-size: 12px">28916 LEGANES
                      </td>
                  </tr>
                  <tr>
                      <td>
                         <p style="font-size: 12px">CIF: B79907044 
                         <p style="font-size: 12px">' . lang('title_phone') . ': 91 680 10 44 / 91 680 80 82                         
                      </td>
                  </tr>                  
              </tbody>
              </table>
              <hr>
              <div>
              '; //style="border:1px solid #000000;"
            $html .= '<p>' . lang('title_date') . ': ' . $dateNormal;
            $html .= '<p>' . $payment['first_name'] . ' ' . $payment['last_name'] . '</p>';
            $html .= '  
              
              <p>' . lang('title_payment') . ': 
              ';
            //<p>La cantidad de euros: </p>
            //<p class="code"> <br> <br></p>
            $html .= $payment['payment_type_name'] . '  ' . $payment['piriod'];
            $html .= '</p>
             
              <p>' . lang('title_amount') . ': €
              ';
            $html .= $payment['amount'];
            $html .= '<br><br>
                   <p style="text-align: center">www.dundeeschool.com</p>
              </div>
              </body>';
            // </p><p>Firmado: ______________</p>
            //$mpdf = new mPDF('utf-8', 'A4', 0, '', 12, 12, 25, 15, 12, 12);
            $mpdf = new mPDF('c', array(80, 125), '10', 1, 8, 13, 13, 0, 0, '');
            $mpdf->SetDisplayMode('fullpage');
            //$stylesheet = file_get_contents(site_url('assets/css/report.css'));
            //$mpdf->WriteHTML($stylesheet, 1);
            //$mpdf->SetHTMLHeader($header);
            //$mpdf->SetHTMLFooter($footer);
            $mpdf->SetJS('this.print();');
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function qualification_get($student_id) {
        $this->setup_ajax_response_headers();
        try {
            echo json_encode($this->General_model->get_where('qualification', "student_id = '" . $student_id . "'"));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function qualification_add() {
        $this->setup_ajax_response_headers();
        try {
            $qualification = $this->input->post();
            $this->General_model->insert('qualification', $qualification);
            echo true;
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function qualification_update() {
        $this->setup_ajax_response_headers();
        try {
            $qualification = $this->input->post();
            $where = ['student_id' => $qualification['student_id'],
                'academic_period' => $qualification['academic_period']];
            unset($qualification['student_id']);
            unset($qualification['academic_period']);
            $this->General_model->update('qualification', $qualification, $where);
            echo true;
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function qualification_delete($student_id, $academic_period) {
        $this->setup_ajax_response_headers();
        try {
            $where = ['student_id' => $student_id,
                'academic_period' => $academic_period];
            $this->General_model->delete('qualification', $where);
            echo true;
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function qualifications_report($student_id) {

        try {
            $this->load->model('Qualification_model');
            $this->load->model('General_model');

            $qualifications = $this->Qualification_model->get_all($student_id);
            $student = $this->General_model->get_where('contact', 'id = ' . $student_id);
            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4');
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);

            $html = '
<body>
    <table border="0" width="100%" >
        <tbody>
            <tr>
                <td rowspan="2" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
                <td><p class="title-font"><b>' . lang('menu_qualification') . '</b></td>
            </tr>
            <tr>
                <td><p><b>' . lang('form_student') . ': </b>';
            $html .= $student[0]['first_name'] . ' ' . $student[0]['last_name'];
            $html .= '</p></td>
            </tr>
        </tbody>
    </table>
';

            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th class="td_center"></th>';
            $html .= '<th>' . lang('form_academic_period') . '</th>';
            $html .= '<th>' . lang('form_level') . '</th>';
            $html .= '<th>' . lang('form_eval1') . '</th>';
            $html .= '<th>' . lang('form_eval2') . '</th>';
            $html .= '<th>' . lang('form_eval3') . '</th>';
            $html .= '<th>' . lang('form_qualification') . '</th>';
            $html .= '<th>' . lang('form_trinity') . '</th>';
            $html .= '<th>' . lang('form_london') . '</th>';
            $html .= '<th>' . lang('form_others') . '</th>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($qualifications AS $qualification) {
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $qualification['period'] . '</td>';
                $html .= '<td>' . $qualification['level'] . '</td>';
                $html .= '<td>' . $qualification['eval1'] . '</td>';
                $html .= '<td>' . $qualification['eval2'] . '</td>';
                $html .= '<td>' . $qualification['eval3'] . '</td>';
                $html .= '<td>' . $qualification['qualification'] . '</td>';
                $html .= '<td>' . $qualification['trinity'] . '</td>';
                $html .= '<td>' . $qualification['london'] . '</td>';
                $html .= '<td>' . $qualification['others'] . '</td></tr>';
                $count++;
            }
            $html .='</tbody></table>
<body>';
            //header("Content-Type: text/plain");
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('pagos.pdf', 'I'); //exit;
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function students_report($isActive = NULL, $group = '') {

        try {
            /* $filter = $this->input->post();
              if (!is_array($filter))
              $filter = []; */
            $this->load->model('Student_model');
            $this->load->helper('Util_helper');
            $students = $this->Student_model->get_all(["isActive" => $isActive, "group_id" => $group]);


            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4-L');
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);
            //$mpdf->SetHeader('Document Title|Center Text|{PAGENO}');
            $mpdf->SetFooter('|Página {PAGENO}|');

            $html = '
<body>

    <table border="0" width="100%" >
        <tbody>
            <tr>
                <td width="50%" rowspan="2" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
                <td><p class="title-font"><b>' . lang('menu_student') . '</b></td>
            </tr>
        </tbody>
    </table>
    ';
            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th class="td_center"></th>';
            $html .= '<th>' . lang('form_name') . '</th>';
            $html .= '<th>' . lang('form_start_date') . '</th>';
            $html .= '<th>' . lang('form_group') . '</th>';
            $html .= '<th>' . lang('form_academic_period') . '</th>';
            $html .= '<th>' . lang('form_date_of_birth') . '</th>';
            $html .= '<th>' . lang('form_phone') . '</th>';
            $html .= '<th>' . lang('form_address') . '</th>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($students AS $student) {
                $start_date = db_to_Local($student['start_date']);
                $birth_date = db_to_Local($student['date_of_birth']);
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $student['first_name'] . ' ' . $student['last_name'] . '</td>';
                $html .= '<td>' . $start_date . '</td>';
                $html .= '<td>' . $student['group_name'] . '</td>';
                $html .= '<td>' . $student['course'] . '</td>';
                $html .= '<td>' . $birth_date . '</td>';
                $html .= '<td>' . $student['phone'] . '</td>';
                $html .= '<td>' . $student['address'] . '</td>';
                $html .= '</tr>';
                $count++;
            }
            $html .='</tbody></table>
<body>';
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('Alumnos.pdf', 'I');
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function birthday_report() {

        try {
            $isActive = $this->input->post('state');
            $center = $this->input->post('center');
            $month = $this->input->post('month');
            $text_to_display = $this->input->post('text_to_display');

            $this->load->model('Student_model');
            $this->load->helper('Util_helper');
            $students = $this->Student_model->get_birthday($isActive, $center, $month);

            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4', '', 14, 0, 0, 13, 13, 0, 0, '');
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);

            $html = '
<body>
    <table class="birthday" border="0" width="100%" style="border-collapse: collapse">
        <tbody>
';
            $count = 1;
            $col = 1;
            foreach ($students AS $student) {

                if ($col == 1) {
                    $html .= '<tr><td>';
                } else {
                    $html .= '<td>';
                }

                if ($text_to_display == 1) {
                   $dateNormal = substr($student['date_of_birth'], 8, 2) . '/' . substr($student['date_of_birth'], 5, 2);  //db_to_Local($student['date_of_birth']); 
                } else {
                   $dateNormal = $student['name'];
                }
                                
                $html .= "<br>" . $student['first_name'] . ' ' . $student['last_name'] . "<br>";
                $html .= $student['address'] . "<br>";
                $html .= $student['postal_code'] . ' ' . $student['town'] . "<br>";
                $html .= $dateNormal;

                $count++;
                if ($col == 3) {
                    $html .= '</td></tr>';
                    $col = 0;
                } else {
                    $html .= '</td>';
                }
                $col++;
            }
            $html .='
         </tbody>
     </table>
<body>';
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('Alumnos.pdf', 'I');
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function payments_general_report() {

        try {
            $state = $this->input->post('state');
            $payment_type = $this->input->post('payment_type');
            $center = $this->input->post('center');
            $month = $this->input->post('month');
            $filter = '';
            $this->load->model('General_model');

            if ($center != '0') {
                $center_value = $this->General_model->get_fields('center', 'name', array('id' => $center));
                $filter .= '<b>' . lang('form_center') . ':</b> ' . $center_value[0]['name'] . ' &nbsp;&nbsp;&nbsp;&nbsp;';
            }
            if ($payment_type != '0') {
                $payment_type_value = $this->General_model->get_fields('payment_type', 'name', array('id' => $payment_type));
                $filter .= '<b>' . lang('subject_payment_type') . ':</b> ' . $payment_type_value[0]['name'] . ' &nbsp;&nbsp;&nbsp;&nbsp;';
            }
            if ($month != '0') {
                $filter .= '<b>' . lang('form_piriod') . ':</b> ' . $month . ' &nbsp;&nbsp;&nbsp;&nbsp;';
            }

            if ($state != 0) {
                if ($state == 1) {
                    $state_value = lang('btn_paid');
                } else {
                    $state_value = lang('btn_unpaid');
                }
                $filter .= '<b>' . lang('form_state') . ':</b> ' . $state_value . ' ';
            }
            $this->load->model('Student_model');
            $this->load->helper('Util_helper');
            $payments = $this->Student_model->get_payments($center, $payment_type, $month, $state);

            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4');
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);

            $html = '
<body>
    <table border="0" width="100%" >
        <tbody>
            <tr>
                <td width="50%" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
                <td><p class="title-font"><b>' . lang('menu_payment') . '</b></td>
            </tr>
        </tbody>
    </table>
    <p> ' . $filter . '</p>
';

            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th class="td_center"></th>';
            $html .= '<th>' . lang('form_name') . '</th>';
            $html .= '<th>' . lang('form_date') . '</th>';
            $html .= '<th>' . lang('form_payment_type') . '</th>';
            $html .= '<th>' . lang('form_piriod') . '</th>';
            $html .= '<th class="td_right">' . lang('form_amount') . '</th>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            $amount = 0;
            foreach ($payments AS $payment) {
                $dateNormal = db_to_Local($payment['date']);
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $payment['first_name'] . ' ' . $payment['last_name'] . '</td>';
                $html .= '<td>' . $dateNormal . '</td>';
                $html .= '<td>' . $payment['payment_type_name'] . '</td>';
                $html .= '<td>' . $payment['piriod'] . '</td>';
                $html .= '<td class="td_right">' . $payment['amount'] . '</td></tr>';
                $amount += $payment['amount'];
                $count++;
            }
            $html .= '<tr><td colspan="5" class="td_center"><b>TOTAL</b></td>';
            $html .= '<td class="td_right"><b>' . number_format($amount, 2, '.', '') . '</b></td></tr>';
            $html .='</tbody></table>
<body>';
            //header("Content-Type: text/plain");
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('pagos.pdf', 'I'); //exit;
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function payments_bank_report() {

        try {
            $center = $this->input->post('center');
            $filter = '';
            $this->load->model('General_model');

            if ($center != '0') {
                $center_value = $this->General_model->get_fields('center', 'name', array('id' => $center));
                $filter .= '<b>' . lang('form_center') . ':</b> ' . $center_value[0]['name'] . ' &nbsp;&nbsp;&nbsp;&nbsp;';
            }
            $this->load->model('Student_model');
            $this->load->helper('Util_helper');
            $payments = $this->Student_model->get_payments_bank($center);

            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4');
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);

            $html = '
<body>
    <table border="0" width="100%" >
        <tbody>
            <tr>
                <td width="50%" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
                <td><p class="title-font"><b>' . lang('menu_payment_bank') . '</b></td>
            </tr>
        </tbody>
    </table>
    <p> ' . $filter . '</p>
';

            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th class="td_center"></th>';
            $html .= '<th>' . lang('form_name') . '</th>';
            $html .= '<th>' . lang('form_notes') . '</th>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($payments AS $payment) {
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $payment['first_name'] . ' ' . $payment['last_name'] . '</td>';
                $html .= '<td>' . $payment['bank_notes'] . '</td></tr>';
                $count++;
            }
            $html .='</tbody></table>
<body>';
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('pagos_bancarios.pdf', 'I');
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

}

/* End of file teacher.php */
/* Location: ./application/controllers/teacher.php */  
