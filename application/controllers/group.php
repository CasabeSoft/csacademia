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
        $this->title = lang('page_manage_groups');
        $this->subject = lang('title_group');
        $this->load->model('General_model');
        $this->load->model('Teacher_model');
        $this->load->model('Student_model');
        $this->centers = $this->General_model->get_fields('center', 'id, name');
        $this->classrooms = $this->General_model->get_fields('classroom', 'id, name, capacity');
        $this->teachers = $this->Teacher_model->get_all();
        $this->levels = $this->General_model->get_fields('level', 'code, description', array('state' => 'A'));
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

    public function attendance() {
        $this->current_page();
        $this->title = lang('page_report_attendance');
        $this->subject = lang('subject_student');
        $this->load->model('General_model');
        $this->centers = $this->General_model->get_fields('center', 'id, name', array('client_id' => $this->client_id));
        $this->academic_periods = $this->General_model->get_fields('academic_period', 'code, name');
        $this->defaultAcademicPeriod = $this->General_model->get_default_academic_period();
        $this->load_page('group_attendance');
    }

    public function report_attendance($group_id, $month, $year) {

        try {
            $this->load->model('Student_model');
            $this->load->model('General_model');
            $this->load->model('Group_model');

            $students = $this->Student_model->get_by_group($group_id);
            $group = $this->Group_model->get_by_id($group_id);

            $months = array(lang('form_january'), lang('form_february'), lang('form_march'), lang('form_april'),
                lang('form_may'), lang('form_june'), lang('form_july'), lang('form_august'),
                lang('form_september'), lang('form_october'), lang('form_november'), lang('form_december'));
            $weekDays = array("monday", "tuesday", "wednesday", "thursday", "friday", "saturday");
            $weekDaysLetters = explode(',', lang('day_short_names'));
            $teachingDays = array();
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $index = 1;
            foreach ($weekDays as $day) {
                if ($group[$day] === "1")
                    $teachingDays[] = $index;
                $index++;
            }

            $count1 = 0;
            $dayLetter = '';
            foreach ($weekDays as $day) {
                if ($group[$day])
                    $dayLetter .= $weekDaysLetters[intval($count1)] . ' ';
                $count1++;
            }

            //$attendance = $this->Attendance_model->get_attendance_for_month($group_id, $year, $month);
            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4-L');
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);

            $html = '
<body>
    <table border="0" width="100%" >
        <tbody>
            <tr>
                <td  width="400px" style="text-align: right;"><img src="/assets/img/logo.png" width="120" /></td>
                <td ><p class="title-font"><b>' . lang('report_attendance') . ' - ' . lang('form_group') . ': ' . $group['name'] /*.  $group['center']*/ . '</b></td>
            </tr>
        </tbody>
    </table>
    <br>  
    <table border="0" width="100%" >
        <tbody>
        <tr>
            <td width="350px"><b>' . lang('form_level') . ': </b>' . $group['level'] . '</td>
            <td width="200px"><b>' . lang('form_classroom') . ': </b>' . $group['classroom'] . '</td>
            <td width="200px"><b>' . lang('form_days') . ': </b>' . $dayLetter . '</td>
            <td width="160px"><b>' . lang('form_schedule') . ': </b>' . $group['start_time'] . ' - ' . $group['end_time'] . '</td>               
        </tr>
        <tr>
            <td><b>' . lang('form_teacher') . ': </b>' . $group['first_name'] . ' ' . $group['last_name'] . '</td>
            <td><b>' . lang('form_center') . ': </b>' . $group['center'] . '</td>
            <td><b>' . lang('form_month') . ': </b>' .$months[intval($month - 1)] . '</td>
            <td><b>' . lang('form_academic_period') . ': </b>' . $group['academic_period'] . '</td>               
        </tr>
        </tbody>
    </table>
    <br><br>
';
            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th rowspan="2" class="td_center"></th>';
            $html .= '<th rowspan="2" width="340px">' . lang('form_name') . '</th>';
            $html .= '<th rowspan="2" width="150px">' . lang('form_school_level') . '</th>';
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $daysInWeek = date("w", mktime(0, 0, 0, $month, $day, $year));
                if (in_array($daysInWeek, $teachingDays)) {
                    $dayLetter = $weekDaysLetters[intval(date("w", mktime(0, 0, 0, $month, $day, $year)))-1];
                    $html .= '<th class="td_center">' . $dayLetter . '</th>';
                }
            }
            $html .= '</tr><tr>';
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $daysInWeek = date("w", mktime(0, 0, 0, $month, $day, $year));
                if (in_array($daysInWeek, $teachingDays)) {
                    $dayLetter = $weekDaysLetters[intval(date("w", mktime(0, 0, 0, $month, $day, $year)))-1];
                    $html .= '<th class="td_center">' . $day . '</th>';
                }
            }
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($students AS $student) {
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                //$html .= '<td>' . $student['first_name'] . ' ' . $student['last_name'] . '</td>';
                $html .= '<td>' . $student['last_name'] . ', ' . $student['first_name'] . '</td>';
                $html .= '<td>' . $student['name'] . '</td>';
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $daysInWeek = date("w", mktime(0, 0, 0, $month, $day, $year));
                    if (in_array($daysInWeek, $teachingDays)) {
                        $html .= '<td class="td_center"><input type="checkbox"></td>';
                    }
                }
                $count++;
                $html .= '</tr>';
            }
            $html .='</tbody></table>
                <br>
                <br>
                <p style="text-align: right;">Firma Profesor: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
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

    public function attendances_report() {

        try {
            $piriod = $this->input->post('period');
            $center = $this->input->post('center');
            $month = $this->input->post('month');
            $year = date("Y");//2013;

            $this->load->model('Student_model');
            $this->load->model('Group_model');

            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4-L');
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);

            $months = array(lang('form_january'), lang('form_february'), lang('form_march'), lang('form_april'),
                lang('form_may'), lang('form_june'), lang('form_july'), lang('form_august'),
                lang('form_september'), lang('form_october'), lang('form_november'), lang('form_december'));
            $weekDays = array("monday", "tuesday", "wednesday", "thursday", "friday", "saturday");
            //$weekDaysLetters = array("Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa");
            $weekDaysLetters = explode(',', lang('day_short_names'));
            
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            $groups = $this->Group_model->get_all_with_filter($piriod, $center);

            foreach ($groups as $group_id) {
                //echo 'id ' . $group_id;                exit();
                $html = '';
                
                $students = $this->Student_model->get_by_group($group_id['id']);
                $group = $this->Group_model->get_by_id($group_id['id']);
                //$attendance = $this->Attendance_model->get_attendance_for_month($group_id, $year, $month);

                $teachingDays = array();                

                $index = 1;
                foreach ($weekDays as $day) {
                    if ($group[$day] === "1")
                        $teachingDays[] = $index;
                    $index++;
                }

                $count1 = 0;
                $dayLetter = '';
                foreach ($weekDays as $day) {
                    if ($group[$day])
                        $dayLetter .= $weekDaysLetters[intval($count1)] . ' ';
                    $count1++;
                }

                $html .= '
<table border="0" width="100%" >
    <tbody>
        <tr>
            <td  width="400px" style="text-align: right;"><img src="/assets/img/logo.png" width="120" /></td>
            <td ><p class="title-font"><b>' . lang('report_attendance') . ' - ' . lang('form_group') . ': ' . $group['name'] /*.  $group['center']*/ . '</b></td>
        </tr>
    </tbody>
</table>
<br>     
<table border="0" width="100%" >
    <tbody>
    <tr>
        <td width="350px"><b>' . lang('form_level') . ': </b>' . $group['level'] . '</td>
        <td width="200px"><b>' . lang('form_classroom') . ': </b>' . $group['classroom'] . '</td>
        <td width="200px"><b>' . lang('form_days') . ': </b>' . $dayLetter . '</td>
        <td width="160px"><b>' . lang('form_schedule') . ': </b>' . $group['start_time'] . ' - ' . $group['end_time'] . '</td>               
    </tr>
    <tr>
        <td><b>' . lang('form_teacher') . ': </b>' . $group['first_name'] . ' ' . $group['last_name'] . '</td>
        <td><b>' . lang('form_center') . ': </b>' . $group['center'] . '</td>
        <td><b>' . lang('form_month') . ': </b>' .$months[intval($month - 1)] . '</td>
        <td><b>' . lang('form_academic_period') . ': </b>' . $group['academic_period'] . '</td>               
    </tr>
    </tbody>
</table>
<br>
<br>
';
                $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
                $html .= '<thead><tr>';
                $html .= '<th rowspan="2"></th>';
                $html .= '<th rowspan="2" width="340px">' . lang('form_name') . '</th>';
                $html .= '<th rowspan="2" width="150px">' . lang('form_school_level') . '</th>';
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $daysInWeek = date("w", mktime(0, 0, 0, $month, $day, $year));
                    if (in_array($daysInWeek, $teachingDays)) {
                        $dayLetter = $weekDaysLetters[intval(date("w", mktime(0, 0, 0, $month, $day, $year)))-1];
                        $html .= '<th class="td_center">' . $dayLetter . '</th>';
                    }
                }
                $html .= '</tr><tr>';
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $daysInWeek = date("w", mktime(0, 0, 0, $month, $day, $year));
                    if (in_array($daysInWeek, $teachingDays)) {
                        $dayLetter = $weekDaysLetters[intval(date("w", mktime(0, 0, 0, $month, $day, $year)))-1];
                        $html .= '<th class="td_center">' . $day . '</th>';
                    }
                }
                $html .= '</tr></thead><tbody>';
                $count = 1;
                foreach ($students AS $student) {
                    $html .= '<tr><td class="td_center">' . $count . '</td>';
                    //$html .= '<td>' . $student['first_name'] . ' ' . $student['last_name'] . '</td>';
                    $html .= '<td>' . $student['last_name'] . ', ' . $student['first_name'] . '</td>';
                    $html .= '<td>' . $student['name'] . '</td>';
                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        $daysInWeek = date("w", mktime(0, 0, 0, $month, $day, $year));
                        if (in_array($daysInWeek, $teachingDays)) {
                            $html .= '<td class="td_center"><input type="checkbox"></td>';
                        }
                    }
                    $count++;
                    $html .= '</tr>';
                }
                $html .='</tbody></table>
                    <br>
                    <br>
                    <p style="text-align: right;">Firma Profesor: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
';
                $mpdf->AddPage();
                $mpdf->WriteHTML($html);
            }
            header('Content-type: application/pdf');
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
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);
            //$mpdf->SetHeader('Document Title|Center Text|{PAGENO}');
            //$mpdf->SetFooter('|Página {PAGENO}|');

            $weekDays = array("monday", "tuesday", "wednesday", "thursday", "friday", "saturday");
            //$weekDaysLetters = array("Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa");
            $weekDaysLetters = explode(',', lang('day_short_names'));

            $count1 = 0;
            $dayLetter = '';
            foreach ($weekDays as $day) {
                if ($group[$day])
                    $dayLetter .= $weekDaysLetters[intval($count1)] . ' ';
                $count1++;
            }

            $html = '
<body> 
<table border="0" width="100%" >
    <tbody>
    <tr>
        <td rowspan="3" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
        <td colspan="4"><p class="title-font"><b>' . lang('form_group') . ': ' . $group['name'] . ' - ' . $group['center'] . '</b></td>
    </tr>
    <tr>
        <td width="280px"><b>' . lang('form_level') . ': </b>' . $group['level'] . '</td>
        <td width="120px"><b>' . lang('form_days') . ': </b>' . $dayLetter . '</td>
        <td width="160px"><b>' . lang('form_schedule') . ': </b>' . $group['start_time'] . ' - ' . $group['end_time'] . '</td>               
    </tr>
    <tr>
        <td><b>' . lang('form_teacher') . ': </b>' . $group['first_name'] . ' ' . $group['last_name'] . '</td>
        <td><b>' . lang('form_classroom') . ': </b>' . $group['classroom'] . '</td>
        <td><b>' . lang('form_academic_period') . ': </b>' . $group['academic_period'] . '</td>               
    </tr>
    </tbody>
</table>
<br>
    ';
            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th class="td_center"></th>';
            $html .= '<th>' . lang('form_name') . '</th>';
            $html .= '<th>' . lang('form_school_level') . '</th>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($students AS $student) {
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $student['first_name'] . ' ' . $student['last_name'] . '</td>';
                $html .= '<td>' . $student['name'] . '</td>';
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

    public function report_groups($filter) {

        try {
            //$filter = $this->input->post();
            //if (!is_array($filter))
            //   $filter = [];
            $this->load->model('Group_model');
            $groups = $this->Group_model->get_group_report(["academic_period" => $filter]);

            $this->load->library('mpdf');
            $mpdf = new mPDF('c', 'A4-L');
            $mpdf->SetDisplayMode('fullpage');

            $stylesheet = file_get_contents(site_url('assets/css/report.css'));
            $mpdf->WriteHTML($stylesheet, 1);
            //$mpdf->SetHeader('Document Title|Center Text|{PAGENO}');
            $mpdf->SetFooter('|Página {PAGENO}|');
            
            $weekDaysLetters = explode(',', lang('day_short_names'));

            $html = '
<body>
    <table border="0" width="100%" >
        <tbody>
            <tr>
                <td width="50%" rowspan="2" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
                <td><p class="title-font"><b>' . lang('menu_group') . '</b></td>
            </tr>
        </tbody>
    </table>
    ';
            $html .= '<table class="list1" border="1" width="100%" style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            //$html .= '<th class="td_center">#</th>';
            $html .= '<th>' . lang('form_group') . '</th>';
            $html .= '<th>' . lang('form_center') . '</th>';
            $html .= '<th>' . lang('form_classroom') . '</th>';
            $html .= '<th>' . lang('form_teacher') . '</th>';
            $html .= '<th>' . lang('form_level') . '</th>';
            $html .= '<th>' . lang('form_academic_period') . '</th>';
            $html .= '<th>' . $weekDaysLetters[intval(0)] . '</th>';
            $html .= '<th>' . $weekDaysLetters[intval(1)] . '</th>';
            $html .= '<th>' . $weekDaysLetters[intval(2)] . '</th>';
            $html .= '<th>' . $weekDaysLetters[intval(3)] . '</th>';
            $html .= '<th>' . $weekDaysLetters[intval(4)] . '</th>';
            $html .= '<th>' . $weekDaysLetters[intval(5)] . '</th>';
            $html .= '<th>' . lang('form_start_time') . '</th>';
            $html .= '<th>' . lang('form_end_time') . '</th>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($groups AS $group) {
                $html .= '<tr>';
                //$html .= '<td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $group['name'] . '</td>';
                $html .= '<td>' . $group['center'] . '</td>';
                $html .= '<td>' . $group['classroom'] . '</td>';
                $html .= '<td>' . $group['first_name'] . ' ' . $group['last_name'] . '</td>';
                $html .= '<td>' . $group['level'] . '</td>';
                $html .= '<td>' . $group['period'] . '</td>';
                $html .= '<td>' . '<input type="checkbox" ' . ($group['monday'] == 1 ? 'checked="checked"' : '') . '></td>';
                $html .= '<td>' . '<input type="checkbox" ' . ($group['tuesday'] == 1 ? 'checked="checked"' : '') . '></td>';
                $html .= '<td>' . '<input type="checkbox" ' . ($group['wednesday'] == 1 ? 'checked="checked"' : '') . '></td>';
                $html .= '<td>' . '<input type="checkbox" ' . ($group['thursday'] == 1 ? 'checked="checked"' : '') . '></td>';
                $html .= '<td>' . '<input type="checkbox" ' . ($group['friday'] == 1 ? 'checked="checked"' : '') . '></td>';
                $html .= '<td>' . '<input type="checkbox" ' . ($group['saturday'] == 1 ? 'checked="checked"' : '') . '></td>';
                $html .= '<td>' . $group['start_time'] . '</td>';
                $html .= '<td>' . $group['end_time'] . '</td>';
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

}

/* End of file group.php */
/* Location: ./application/controllers/group.php */
