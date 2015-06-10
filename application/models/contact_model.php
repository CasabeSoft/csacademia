<?php

/**
 * Gestión de contactos
 *
 * @author carlos
 */
class Contact_model extends CI_Model {

    private $client_id;
    private $center_id;
    public $FIELDS = [
        "id",
        "first_name",
        "last_name",
        "sex",
        "email",
        "phone_mobile",
        "phone",
        "picture",
        "notes",
        "address",
        "postal_code",
        "town",
        "province",
        "date_of_birth",
        "occupation",
        "id_card",
        "client_id",
    ];
    public $NULLABLES = [
        'date_of_birth'
    ];

    public function __construct() {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
        $this->center_id = $this->session->userdata('current_center')['id'];
    }

    public function get_contacts() {
        return $this->db->from('contact')
                        ->join('student', 'contact.id = student.contact_id', 'left')
                        ->join('teacher', 'contact.id = teacher.contact_id', 'left')
                        ->where('client_id = ' . $this->client_id)
                        ->where('student.contact_id', NULL)
                        ->where('teacher.contact_id', NULL)
                        ->get()->result_array();
    }

    public function get_student($activo = '', $grupo = '') {
        $this->db->from('contact')
                ->join('student', 'contact.id = student.contact_id', 'left')
                ->where('client_id = ' . $this->client_id)
                ->where('student.contact_id', NULL);
        if (!empty($activo)) {
            if ($activo == 1) {
                $this->db->where('student.end_date', NULL);
            } else {
                $this->db->where('student.end_date', 'IS NOT NULL');
            }
        }
        if (!empty($grupo)) {
            $this->db->where('student.gorup_id', $grupo);
        }
        return $this->db->get()->result_array();
    }

    public function delete($id) {
        $this->db->delete('contact', 'id = ' . $id . ' and client_id = ' . $this->client_id);
        return $id;
    }

    public function add($contact) {
        unset($contact['id']);
        $contact['client_id'] = $this->client_id;
        $this->db->trans_start();
        $this->db->insert('contact', convert_nullables($contact, $this->NULLABLES));
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        return $id;
    }

    public function update($contact) {
        $id = $contact['id'];
        unset($contact['client_id']);
        unset($contact['id']);
        $this->db->update('contact', convert_nullables($contact, $this->NULLABLES), 'id = ' . $id . ' and client_id = ' . $this->client_id);
        return $id;
    }

    public function get_all_email() {
        $this->db->select('contact.id, CONCAT(first_name, last_name) AS name, sex, email, group_id, ' .
                'student.end_date IS NULL AND teacher.end_date IS NULL AS is_active, ' .
                '(CASE WHEN student.contact_id IS NOT NULL THEN "S" ' .
                ' WHEN teacher.contact_id IS NOT NULL THEN "T" ' .
                ' ELSE "C" END) AS contact_type', FALSE)
            ->from('contact')
            ->join('student', 'contact.id = student.contact_id', 'left')
            ->join('teacher', 'contact.id = teacher.contact_id', 'left')
            ->where('client_id', $this->client_id)
            ->where('email IS NOT NULL AND TRIM(email) <> ""');
        if ($this->center_id != NULL) {
            $this->db->where('(student.center_id IS NULL OR student.center_id = ' . $this->center_id . ')');
        }
        return $this->db->get()->result_array();
    }

}

/* End of file contact_model.php */
/* Location: ./application/models/contact_model.php */
