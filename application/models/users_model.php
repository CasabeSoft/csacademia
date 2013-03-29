<?php

/**
 * Description of usersModel
 *
 * @author carlos
 */
class Users_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtener un usuario según sus datos de autenticación.
     * 
     * @author Leonardo
     * @param $email (Correo del usuario)
     * @param $password (Contraseña del usuario)
     * @return array  
     */
    public function verifyLogin($email, $password) {

        $result = $this->db->select('id, email, role_code, client_id')
                ->where('email', $email)
                ->where('password', $password)
                ->limit(1)
                ->get('login')
                ->row();
        return $result;
    }   
   
}

?>
