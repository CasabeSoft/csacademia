<?php
/**
 * Gestión de Profesores
 *
 * @author Carlos Bello
 */
class Teacher_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('Contact_model');
    }
    
    public function get_all() {
        return $this->Contact_model->get_all();
    }
    
    public function delete($id) {
        return $this->Contact_model->delete($id);
    }
    
    public function add($contact) {
        return $this->Contact_model->add($contact);
    }
    
    public function update($contact) {
        return $this->Contact_model->update($contact);;
    }
}

/* End of file teacher_model.php */
/* Location: ./application/models/teacher_model.php */
