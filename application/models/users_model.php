<?php

/**
 * Gestión de Usuarios
 *
 * @author Leonardo Quintero
 * @author Carlos Bello
 */
class Users_model extends CI_Model
{

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
    public function verify_login($email, $password) {

        $result = $this->db->select('id, email, role_code, client_id')
                ->where('email', $email)
                ->where('password', $password)
                ->limit(1)
                ->get('login')
                ->row();
        return $result;
    }

    /**
     * Obtener si el usuario es un Administrador.
     *
     * @param $mail
     * @param $password
     * @return bool
     */
    function is_user_administrator($mail, $password) {

        return (USER_ADMINISTRATOR === $mail) and (PASSWORD_ADMINISTRATOR === $password) ? true : false;
    }

    /**
     * Cambia la contraseña del usuario.
     *
     * @param $id
     * @param $oldPassword
     * @param $newPassword
     * @return bool
     */
    function change_password($id, $oldPassword, $newPassword) {

        $query = $this->db->select('id, password')
                ->where('id', $id)
                ->get('login');

        $result = $query->row();

        $db_password = $result->password;

        if ($db_password === $oldPassword) {
            $this->db->where('id', $id)
                    ->update('login', array('password' => $newPassword));

            return $this->db->affected_rows() == 1;
        }

        return false;
    }

    /**
     * Valida si el email existe.
     *
     * @param $email (Correo del usuario)
     * @return bool  (Si existe retorna FALSE )
     */
    function check_email($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('login');
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Actualiza un registro en la tabla.
     *
     * @param $fields (Arreglo con los campos y valores a modificar)
     * @param $where (Filtro de los campos a modificar)
     * @return int (Id del registro insertado)
     */
    function update_record($fields, $where) {
        $this->db->update('login', $fields, $where);

        return $this->db->affected_rows();
    }
}
