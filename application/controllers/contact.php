<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * TEMPORAL. Probablemente este código deba ser heredado o integrado
 * en los controladores de estudiantes y profesores.
 *
 * @author Carlos Bello
 */
class Contact extends Basic_controller {

    var $subject;
    var $editMode;

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
        $this->title = lang('page_manage_contacts');
        $this->subject = lang('subject_contact');
        $this->editMode = 'true';
        $this->load_page('contact_admin');
    }

    protected function _echo_json_error($error) {
        http_response_code(500);
        echo json_encode($error);
    }

    public function get() {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Contact_model');
            echo json_encode($this->Contact_model->get_all());
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function add() {
        $this->setup_ajax_response_headers();
        try {
            $contact = $this->input->post();
            $this->load->model('Contact_model');
            echo json_encode($this->Contact_model->add($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function delete($id) {
        $this->setup_ajax_response_headers();
        try {
            $this->load->model('Contact_model');
            echo json_encode($this->Contact_model->delete($id));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function update() {
        $this->setup_ajax_response_headers();
        try {
            $contact = $this->input->post();
            $this->load->model('Contact_model');
            echo json_encode($this->Contact_model->update($contact));
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

    public function contacts_report($filter) {

        try {
            /*$filter = $this->input->post();
            if (!is_array($filter))
                $filter = [];*/
            $this->load->model('Contact_model');
            $this->load->helper('Util_helper');
            $contacts = $this->Contact_model->get_all(["isActive" => $filter]);

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
                <td width="50%" rowspan="2" style="text-align: right;"><img src="/assets/img/logo.png" width="140" /></td>
                <td><p class="title-font"><b>Contactos</b></td>
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
            foreach ($contacts AS $contact) {
                $dateNormal = db_to_Local($contact['date_of_birth']);
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $contact['first_name'] . ' ' . $contact['last_name'] . '</td>';
                $html .= '<td>' . $contact['phone_mobile'] . '</td>';
                $html .= '<td>' . $dateNormal . '</td>';
                $html .= '<td>' . $contact['address'] . '</td>';
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
            $mpdf->Output('Contactos.pdf', 'I');
            exit; 
        } catch (Exception $e) {
            $this->_echo_json_error($e->getMessage());
        }
    }

}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */
