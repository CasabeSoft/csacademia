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
        $this->subject = lang('title_contact');
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
            echo json_encode($this->Contact_model->get_contacts());
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
            $this->load->model('General_model');
            $this->load->helper('Util_helper');
            $contacts = $this->Contact_model->get_contacts(["isActive" => $filter]);
            $client_info = $this->General_model->get_info_client_id($this->client_id);

            $logo_print = isset($client_info['report_logo']) ? $client_info['report_logo'] : 'logo_csacademia_print.png';

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
                <td width="50%" rowspan="2" style="text-align: right;"><img src="./assets/uploads/files/client/' . $logo_print . '" width="140" /></td>
                <td><p class="title-font"><b>' . lang('menu_contact') . '</b></td>
            </tr>
        </tbody>
    </table>
    ';
            $html .= '<table class="list1" border="1" width="100%"  style="border-collapse: collapse">';
            $html .= '<thead><tr>';
            $html .= '<th class="td_center"></th>';
            $html .= '<th>' . lang('form_name') . '</th>';
            $html .= '<th>' . lang('form_phone') . '</th>';
            $html .= '<th>' . lang('form_address') . '</th>';
            $html .= '</tr></thead><tbody>';
            $count = 1;
            foreach ($contacts AS $contact) {
                $html .= '<tr><td class="td_center">' . $count . '</td>';
                $html .= '<td>' . $contact['first_name'] . ' ' . $contact['last_name'] . '</td>';
                $html .= '<td>' . $contact['phone_mobile'] . '</td>';
                $html .= '<td>' . $contact['address'] . '</td>';
                $html .= '</tr>';
                $count++;
            }
            $html .='</tbody></table>
<body>';
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
