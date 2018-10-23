<?php

/**
 * Students to classes attendance management
 */
class Attendance_model extends CI_Model
{
    private $client_id;
    
    public $FIELDS = [
        "student_id",
        "date",
    ];
    
    public function __construct()
    {
        parent::__construct();
        $this->client_id = $this->session->userdata('client_id');
    }
    
    public function get_attendance_for_date($group_id, $date)
    {
        return $this->db->select('attendance.*')
                ->from('attendance')
                ->join('student', 'attendance.student_id = student.contact_id')
                ->join('center', 'center.id = student.center_id')
                ->where('client_id', $this->client_id)
                ->where('group_id', $group_id)
                ->where('date', $date)
                ->get()->result_array();
    }
    
    public function get_attendance_for_month($group_id, $year, $month)
    {
        $nextYear = intval($year);
        $nextMonth = intval($month);
        if ($nextMonth == 12) {
            $nextMonth = 1;
            $nextYear = $nextYear + 1;
        } else {
            $nextMonth = $nextMonth + 1;
        }
        return $this->db->select('attendance.*')
                ->from('attendance')
                ->join('student', 'attendance.student_id = student.contact_id')
                ->join('center', 'center.id = student.center_id')
                ->where('client_id', $this->client_id)
                ->where('group_id', $group_id)
                ->where("date >= '".$year.'-'.$month."-01'")
                ->where("date < '".$nextYear.'-'.$nextMonth."-01'")
                ->get()->result_array();
    }
    
    public function add_student_attendance($student_id, $date)
    {
        $this->db->insert('attendance', ['student_id' => $student_id, 'date' => $date]);
        return $student_id;
    }
    
    public function delete_student_attendance($student_id, $date)
    {
        $this->db->delete('attendance', ['student_id' => $student_id, 'date' => $date]);
        return $student_id;
    }
}
