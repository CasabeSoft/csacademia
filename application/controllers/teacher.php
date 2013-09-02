<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * TEMPORAL. Probablemente este código deba ser heredado o integrado
 * en los controladores de estudiantes y profesores.
 *
 * @author Carlos Bello
 */
class Teacher extends Basic_controller {
    public function __construct() {
        parent::__construct();
        $this->template = 'templates/manager_page';
        $this->location = 'manager/';
        $this->menu_template = 'templates/manager_menu'; 
    }

    public function admin() {
        $this->current_page();
        $this->title = lang('page_manage_teachers');
        $this->subject = lang('subject_teacher');
        $this->editMode = 'true';
        $this->load_page('teacher_admin');
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
            $this->load->model('Teacher_model');
            echo json_encode($this->Teacher_model->get_all($filter));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function add() {
        $this->setup_ajax_response_headers();
        try {
            $contact = $this->input->post();
            $this->load->model('Teacher_model');
            echo json_encode($this->Teacher_model->add($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function delete($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Teacher_model');
            echo json_encode($this->Teacher_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function update() {
        $this->setup_ajax_response_headers();
        try {
            $contact = $this->input->post();
            $this->load->model('Teacher_model');
            echo json_encode($this->Teacher_model->update($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function teachers_report($filter) {

        try {
            /*$filter = $this->input->post();
            if (!is_array($filter))
                $filter = [];*/
            $this->load->model('Teacher_model');
            $this->load->helper('Util_helper');
            $teachers = $this->Teacher_model->get_all(["isActive" => $filter]);
            
            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4');
            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);
            //$mpdf->SetHeader('Document Title|Center Text|{PAGENO}');
            $mpdf->SetFooter('|Página {PAGENO}|');
            
            $html = '
<body>

    <table border="0" width="100%" >
        <tbody>
        <tr>
            <td rowspan="2" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
            <td><p class="title-font"><b>Profesores</b></td>
        </tr>
        <tr>
        <td>';
           // $html .= '<p><b>Grupo: </b>' . $group['name'] . ' <b>Centro: </b>' . $group['center'] . ' <b>Profesor: </b>' . $group['first_name'] . ' ' . $group['last_name'];
            $html .= /*'</p></td>*/ '
        </tr>
        </tbody>
    </table>
    ';

            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th class="td_center">#</td>';
            $html .= '<th>Nombre</td>';
            $html .= '<th>Teléfono</td>';
            $html .= '<th>Fecha Nac.</td>';
            $html .= '<th>Dirección</td>';
            //$html .= '<th>start_time</td>';
            //$html .= '<th>end_time</td>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($teachers AS $teacher) {
                $dateNormal = db_to_Local($teacher['date_of_birth']);
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $teacher['first_name'] . ' ' . $teacher['last_name'] . '</td>';
                $html .= '<td>' . $teacher['phone_mobile'] . '</td>';
                $html .= '<td>' . $dateNormal . '</td>';
                $html .= '<td>' . $teacher['address'] . '</td>';
                //$html .= '<td>' . $teacher['start_time'] . '</td>';
                //$html .= '<td>' . $teacher['end_time'] . '</td>';
                $html .= '</tr>';
                $count++;
            }
            $html .='</tbody></table>
    <br />
<body>';
            //$this->setup_ajax_response_headers();
            //header("Content-Type: text/plain");
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('Profesores.pdf', 'I');
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
}

/* End of file teacher.php */
/* Location: ./application/controllers/teacher.php */
