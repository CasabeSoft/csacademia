<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Description of Picture
 *
 * @author carlos
 */
class Picture extends MY_Controller
{

    public function __construct() {
        parent::__construct();
    }
        
    protected function _echo_json_error($error) {
        http_response_code(500);
        echo json_encode($error);
    }
    
    public function upload($table, $primary_key) {
        $this->load->model('General_model');
        header("Content-type:text/json");

        $config['upload_path'] = './assets/uploads/files/'.$table.'/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['min_size'] = 0;
        $config['max_size'] = 2048;
        $config['file_name'] = $primary_key.'-'.$_FILES['fileupload']['name'];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('fileupload')) {
            echo $this->_echo_json_error(array('error' => $this->upload->display_errors(), 'file' => $_FILES['fileupload']));
        } else {
            $currentPicture = $this->General_model->get_picture($table, $primary_key);
            if (! is_null($currentPicture)) {
                @unlink(realpath('./assets/uploads/files/'.$table.'/'.$currentPicture));
            }
            $data = $this->upload->data();
            $this->General_model->update_picture($table, $primary_key, $data['file_name']);
            echo json_encode(['picture' => $data['file_name']]);
        }
        @unlink($_FILES['fileupload']);
    }
}

/* End of file picture.php */
/* Location: ./application/controllers/picture.php */
