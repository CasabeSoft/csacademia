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
            $this->load->model('Student_model');
            $this->load->model('General_model');
            $this->load->model('Group_model');

            $students = $this->Student_model->get_by_group($group_id);
            $group = $this->Group_model->get_by_id($group_id);

            $weekDays = array("monday", "tuesday", "wednesday", "thursday", "friday", "saturday");
            $weekDaysLetters = array("Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa");
            $teachingDays = array();
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $index = 1;
            foreach ($weekDays as $day) {
                if ($group[$day] === "1")
                    $teachingDays[] = $index;
                $index++;
            }

            //$attendance = $this->Attendance_model->get_attendance_for_month($group_id, $year, $month);
            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4-L');
            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);
            
            $html = '
<body>

    <table border="0" width="100%" >
        <tbody>
        <tr>
            <td rowspan="2" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
            <td><p class="title-font"><b>Informe de Asistencia</b></td>
        </tr>
        <tr>
        <td><p><b>Grupo: </b>';
            $html .= $group['name'] . ' <b>Centro: </b>' . $group['center'] . ' <b>Mes: </b>' . $month . '/' . $year . ' <b>Profesor: </b>' . $group['first_name'] . ' ' . $group['last_name'];
            $html .= '</p></td>
        </tr>
        </tbody>
    </table>
    ';

            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<td rowspan="2" class="td_center">#</td>';
            $html .= '<td  rowspan="2">Nombre</td>';
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $daysInWeek = date("w", mktime(0, 0, 0, $month, $day, $year));
                if (in_array($daysInWeek, $teachingDays)) {
                    $dayLetter = $weekDaysLetters[intval(date("w", mktime(0, 0, 0, $month, $day, $year)))];
                    $html .= '<td class="td_center">' . $dayLetter . '</td>';
                }
            }
            $html .= '</tr><tr>';
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $daysInWeek = date("w", mktime(0, 0, 0, $month, $day, $year));
                if (in_array($daysInWeek, $teachingDays)) {
                    $dayLetter = $weekDaysLetters[intval(date("w", mktime(0, 0, 0, $month, $day, $year)))];
                    $html .= '<td class="td_center">' . $day . '</td>';
                }
            }
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($students AS $student) {
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $student['first_name'] . ' ' . $student['last_name'] . '</td>';
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $daysInWeek = date("w", mktime(0, 0, 0, $month, $day, $year));
                    if (in_array($daysInWeek, $teachingDays)) {
                        $dayLetter = $weekDaysLetters[intval(date("w", mktime(0, 0, 0, $month, $day, $year)))];
                        $html .= '<td class="td_center"><input type="checkbox"></td>';
                    }
                }
                $count++;
                $html .= '</tr>';
            }
            $html .='</tbody></table>
    <br />
<body>';
            //$this->setup_ajax_response_headers();
            //header("Content-Type: text/plain");
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('Asistencia.pdf', 'I');
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function report_students($group_id) {

        try {
            $this->load->model('Student_model');
            $this->load->model('General_model');
            $this->load->model('Group_model');

            $students = $this->Student_model->get_by_group($group_id);
            $group = $this->Group_model->get_by_id($group_id);

            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4');
            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);
            //$mpdf->SetHeader('Document Title|Center Text|{PAGENO}');
            //$mpdf->SetFooter('|Página {PAGENO}|');
            
            $html = '
<body>

    <table border="0" width="100%" >
        <tbody>
        <tr>
            <td rowspan="2" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
            <td><p class="title-font"><b>Alumnos</b></td>
        </tr>
        <tr>
        <td><p><b>Grupo: </b>';
            $html .= $group['name'] . ' <b>Centro: </b>' . $group['center'] . ' <b>Profesor: </b>' . $group['first_name'] . ' ' . $group['last_name'];
            $html .= '</p></td>
        </tr>
        </tbody>
    </table>
    ';

            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<td class="td_center">#</td>';
            $html .= '<td>Nombre</td>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($students AS $student) {
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $student['first_name'] . ' ' . $student['last_name'] . '</td>';
                $html .= '</tr>';
                $count++;
            }
            $html .='</tbody></table>
    <br />
<body>';
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('Alumnos.pdf', 'I');
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }
    
    public function report_groups($filter) {

        try {
            //$filter = $this->input->post();
            //if (!is_array($filter))
             //   $filter = [];
            $this->load->model('Group_model');
            $groups = $this->Group_model->get_group_report(["academic_period" => $filter]);
            
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
            <td><p class="title-font"><b>Grupos</b></td>
        </tr>
        <tr>
        <td>';
           // $html .= '<p><b>Grupo: </b>' . $group['name'] . ' <b>Centro: </b>' . $group['center'] . ' <b>Profesor: </b>' . $group['first_name'] . ' ' . $group['last_name'];
            $html .= /*'</p></td>*/ '
        </tr>
        </tbody>
    </table>
    ';

            $html .= '<table class="list1" border="1" width="100%" style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th class="td_center">#</td>';
            $html .= '<th>Grupo</td>';
            $html .= '<th>Centro</td>';
            $html .= '<th>Aula</td>';
            $html .= '<th>Profesor</td>';
            $html .= '<th>Nivel</td>';
            $html .= '<th>Periodo</td>';
            $html .= '<th>Lu</td>';
            $html .= '<th>Ma</td>';
            $html .= '<th>Mi</td>';
            $html .= '<th>Ju</td>';
            $html .= '<th>Vi</td>';
            $html .= '<th>Sa</td>';
            $html .= '<th>Hora Inicio</td>';
            $html .= '<th>Hora Fin</td>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($groups AS $group) {
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $group['name'] . '</td>';
                $html .= '<td>' . $group['center'] . '</td>';
                $html .= '<td>' . $group['classroom'] . '</td>';
                $html .= '<td>' . $group['teacher'] . '</td>';
                $html .= '<td>' . $group['level'] . '</td>';
                $html .= '<td>' . $group['period'] . '</td>';
                $html .= '<td>' . $group['monday'] . '</td>';
                $html .= '<td>' . $group['tuesday'] . '</td>';
                $html .= '<td>' . $group['wednesday'] . '</td>';
                $html .= '<td>' . $group['thursday'] . '</td>';
                $html .= '<td>' . $group['friday'] . '</td>';
                $html .= '<td>' . $group['saturday'] . '</td>';
                $html .= '<td>' . $group['start_time'] . '</td>';
                $html .= '<td>' . $group['end_time'] . '</td>';
                $html .= '</tr>';
                $count++;
            }
            $html .='</tbody></table>
    <br />
<body>';
            
            header('Content-type: application/pdf');
            $mpdf->WriteHTML($html);
            $mpdf->Output('Alumnos.pdf', 'I');
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

}
/* End of file group.php */
/* Location: ./application/controllers/group.php */
