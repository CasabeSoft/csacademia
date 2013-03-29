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
        $this->location = 'public/';
    }

    /**
     *  Formulario para validar el acceso de un usuario.
     */
    function login() {

        $this->current_page();
        $this->load->library('form_validation');
        $this->load->model('Users_model');
        // TODO: Remplazar literales por acceso a texto desde recurso internacionalizado

        $this->form_validation->set_rules('userName', lang('form_username'), 'trim|required');
        //$this->form_validation->set_rules('email', 'Correo', 'trim|required');
        $this->form_validation->set_rules('password', lang('form_password'), 'required|md5');

        if ($this->form_validation->run() == TRUE) {

            $email = $_POST['userName'];
            $password = $_POST['password'];           

            //Validamos si es un usuario Administrador
            $isAdmin = FALSE;

            //Chequemos los datos ingresados en la db
            $result = $this->Users_model->verifyLogin($email, $password);

            //Si el usuario es el administrador o existe en la db..
            if (!empty($result) || $isAdmin) {

                if ($isAdmin) {
                    $user = array(
                        'id' => 0,
                        'email' => $email,
                        'role_id' => '1',
                        'client_id' => '1'
                    );
                } else {
                    $user = array(
                        'id' => $result->id,
                        'email' => $result->email,
                        'role_id' => $result->role_code,
                        'client_id' => $result->client_id
                    );
                }

                //..lo guardamos en sesion
                $this->session->set_userdata($user);

                //Ahora, comprobamos si existio alguna pagina a donde se quiso entrar
                /* if ($this->session->userdata('current_url')) {
                  redirect($this->session->userdata('current_url'));
                  } else { */

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
                }
                //}
            } else {
                // Si no existe el usuario envio el mensaje de error.
                $this->error = 'Revise los campos por favor. El nombre de usuario o contraseña no son correctos.';
            }
        }
        if ($this->session->flashdata('message')) {
            $this->message = $this->session->flashdata('message');
        }

        $this->title = "CasabeSoft Academia - " . lang('menu_login');;
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
        $this->title = "CasabeSoft Academia - " . lang('menu_login');;
        $this->description = "Control de accesos para clientes de CasabeSoft Academia.";
        $this->load_page('denied');
    }

}

/* End of file user_pages.php */
/* Location: ./application/controllers/user_pages.php */
