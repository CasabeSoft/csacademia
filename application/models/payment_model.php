<?php

/**
 * Description of family_model
 *
 * @author carlos
 */
class Payment_model extends CI_Model {

    private $client_id;
    public $FIELDS = [
        "id",
        "date",
        "amount",
        "concept",
        "student_id",
        "payment_period_id",
        "notes",
        "payment_period_year"
    ];

    public $NULLABLES = [
        'concept',
        'payment_period_id',
        'payment_period_year',
        'notes'       
    ];
    
    public function __construct() {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
    }

    public function get_all($student_id) {
        return $this->db->select("payment.*, payment_period_type.name AS payment_type_name")
                        ->from('payment')
                        ->join('payment_period', 'payment.payment_period_id = payment_period.id', 'left')
                        ->join('payment_period_type', 'payment_period.period_type = payment_period_type.id', 'left')
                        ->where('student_id', $student_id)
                        ->order_by("date", "desc")
                        ->get()->result_array();
    }

    public function get_payment_id($id) {
        return $this->db->select("payment.*, payment_type.name AS payment_type_name, contact.first_name, contact.last_name")
                        ->from('payment')
                        ->join('payment_type', 'payment.payment_type_id = payment_type.id')
                        ->join('contact', 'payment.student_id = contact.id')
                        ->where('payment.id', $id)
                        ->get()->row_array();
    }

    public function delete($id) {
        $this->db->delete('payment', 'id = ' . $id);
        return $id;
    }

    public function add($payment) {
        $cleanPayment = convert_nullables(
                substract_fields($payment, $this->FIELDS),
                $this->NULLABLES);
        unset($cleanPayment['id']);
        $this->db->insert('payment', $cleanPayment);
        return $this->db->insert_id();
    }

    public function update($payment) {
        $id = $payment['id'];
        $cleanPayment = convert_nullables(
                substract_fields($payment, $this->FIELDS),
                $this->NULLABLES);
        unset($cleanPayment['student_id']);
        unset($cleanPayment['id']);
        $this->db->update('payment', $cleanPayment, 'id = ' . $id);
        return $id;
    }

}

/* End of file payment_model.php */
/* Location: ./application/models/payment_model.php */

