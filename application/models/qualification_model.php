<?php

/**
 * Description of family_model
 *
 * @author carlos
 */
class Qualification_model extends CI_Model {

    private $client_id;
    public $FIELDS = [
        "student_id",
        "academic_period",
        "description",
        "qualification",
        "trinity",
        "london",
        "others",
        "eval1",
        "eval2",
        "eval3",
        "level_code"
    ];

    public function __construct() {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
    }

    public function get_all($student_id) {
        return $this->db->select("qualification.*, academic_period.name AS period, level.description AS level")
                        ->from('qualification')
                        ->join('academic_period', 'qualification.academic_period = academic_period.code')
                        ->join('level', 'qualification.level_code = level.code')
                        ->where('student_id', $student_id)
                        ->get()->result_array();
    }

}

/* End of file payment_model.php */
/* Location: ./application/models/payment_model.php */

