<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para la gestión de usuarios.
 * 
 * @author Leoanrdo Quintero
 */
class User_pages extends Basic_controller {

    function __construct() {
        parent::__construct();
        $this->template = 'templates/public_page';
        $this->location = 'user/';
        $this->load->model('Users_model');
        $this->load->library('form_validation');
    }

    /**
     *  Formulario para validar el acceso de un usuario.
     */
    function login() {

        $this->current_page();

        $this->form_validation->set_rules('userName', lang('form_username'), 'trim|required');
        $this->form_validation->set_rules('password', lang('form_password'), 'required|md5');

        if ($this->form_validation->run() == TRUE) {

            $email = $_POST['userName'];
            $password = $_POST['password'];

            //Validamos si es un usuario Administrador
            $isAdmin = $this->Users_model->is_user_administrator($email, $password);

            //Chequemos los datos ingresados en la db
            $result = $this->Users_model->verify_login($email, $password);

            //Si el usuario es el administrador o existe en la db..
            if (!empty($result) || $isAdmin) {
                $this->load->model('General_model');
                $client_id = $isAdmin
                        ? $this->General_model->get_first_client()
                        : $result->client_id;
                $center = $this->General_model->get_first_center($client_id);
                
                if ($isAdmin) {
                    $user = array(
                        'id' => 0,
                        'email' => $email,
                        'role_id' => '1',
                        'client_id' => $client_id,
                        'current_center' => $center
                    );
                } else {
                    $user = array(
                        'id' => $result->id,
                        'email' => $result->email,
                        'role_id' => $result->role_code,
                        'client_id' => $client_id,
                        'current_center' => $center
                    );
                }

                //..lo guardamos en sesion
                $this->session->set_userdata($user);

                //Ahora, comprobamos si existio alguna pagina a donde se quiso entrar
                /* if ($this->session->userdata('current_url')) {
                  redirect($this->session->userdata('current_url'));
                  } else { */

                /***
                * [CB] TODO: Descomentar bloque siguiente cuando se decida cuál
                * será la página por rol. De momento y para la demo
                * redirigir a todos los usuarios hacia la pagina main
                * para que se vea el título de la app y el logo del cliente.
                */
                /*
                //Según el rol del usuario lo enviamos a su página index
                switch ($user['role_id']) {
                    case 1:
                        redirect('admin/client');
                        break;
                    case 2:
                        redirect('manager/main');
                        break;
                    default:
                        redirect('manager/main');
                        break;
                }*/
                // De momento y hasta que se defina el bloque anterior:
                 redirect('manager/main');
                //}
            } else {
                // Si no existe el usuario envio el mensaje de error.
                $this->error = lang('message_error_login');
            }
        }
        if ($this->session->flashdata('message')) {
            $this->message = $this->session->flashdata('message');
        }

        $this->title = "CasabeSoft Academia - " . lang('menu_login');
        $this->description = "Control de accesos para clientes de CasabeSoft Academia.";
        $this->load_page('login');
    }

    /**
     *  Cerrar session del usuario.
     */
    function close() {
        $this->session->sess_destroy();
        redirect('/home');
    }

    /**
     *  Mostrar al usuario página de acceso denegado.
     */
    function denied() {
        $this->current_page();
        $this->title = "CasabeSoft Academia - " . lang('menu_login');
        $this->description = "Control de accesos para clientes de CasabeSoft Academia.";
        $this->load_page('denied');
    }

    /**
     * Valida si el correo está registrado en la bd. 
     */
    function _check_email($email) {
        return $this->Users_model->check_email($email);
    }

    /**
     * Cambiar contraseña del usuario. 
     */
    function change_password() {

        $this->current_page();
        if (!isLogged()) {
            redirect('/denied');
            exit;
        }
        $this->template = 'templates/manager_page';
        $this->menu_template = 'templates/manager_menu';


        $this->form_validation->set_rules('current_password', lang('form_current_password'), 'required|min_length[2]|max_length[20]|md5');
        $this->form_validation->set_rules('new_password', lang('form_new_password'), 'required|min_length[2]|max_length[20]|md5');
        $this->form_validation->set_rules('confirm_password', lang('form_confirm_password'), 'required|matches[new_password]');

        if ($this->form_validation->run() == TRUE) {

            $id = $this->session->userdata('id');
            $old_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');

            $change = $this->Users_model->change_password($id, $old_password, $new_password);

            if ($change) { //Si la contraseña fue cambiada .
                $this->message = lang('message_change_password');
            } else {
                $this->error = lang('message_error_change_password');
            }
        }

        $this->title = "CasabeSoft Academia - " . lang('menu_change_password');
        $this->description = "Cambiar contraseña para el usuario de CasabeSoft Academia.";
        $this->load_page('change_password');
    }

    function profile() {

        $this->current_page();
        if (!isLogged()) {
            redirect('/denied');
            exit;
        }
        $this->template = 'templates/manager_page';
        $this->menu_template = 'templates/manager_menu';

        $id = $this->session->userdata('id');

        $this->form_validation->set_rules('email', lang('form_email'), 'trim|required|callback__check_email');
        $this->form_validation->set_message('_check_email', lang('message_error_check_email'));

        if ($this->form_validation->run() == TRUE) {

            $fields = array(
                'email' => $this->input->post('email'),
            );

            $change = $this->Users_model->update_record($fields, array('id' => $id));

            if ($change) {                
                //..lo guardamos en sesion
                $this->session->set_userdata($fields);

                $this->message = lang('message_profile');
            } else {
                $this->error = lang('message_error_profile');
            }
        }

        $this->title = "CasabeSoft Academia - " . lang('menu_profile');
        $this->description = "Cambiar contraseña para el usuario de CasabeSoft Academia.";
        $this->load_page('profile');
    }

}

/* End of file user_pages.php */
/* Location: ./application/controllers/user_pages.php */
