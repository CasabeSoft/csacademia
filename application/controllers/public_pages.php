<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Controlador para las páginas públicas que no requieren mucho 
 * procesamiento, del lado del servidor.
 *
 * @author Carlos Bello
 */
class Public_pages extends Base_controller {
    public function __construct() {
        parent::__construct();
        $this->template = 'templates/public_page';
        $this->location = 'public/';
    }
    
    public function home() {
        // TODO: Remplazar literales por acceso a texto desde recurso internacionalizado
        $this->title = 'CasabeSoft Academia - Inicio';
        $this->description = 'Página de inicio de CasabeSoft Academia.';
        $this->load_page('home');
    }
    
    public function about() {
        // TODO: Remplazar literales por acceso a texto desde recurso internacionalizado
        $this->title = 'CasabeSoft Academia - A cerca de';
        $this->description = 'Información a cerca de la aplicación CasabeSoft Academia.'; 
        $this->load_page('about');
    }
    
    public function contact() {
        // TODO: Remplazar literales por acceso a texto desde recurso internacionalizado
        $this->title = "CasabeSoft Academia - Contacto";
        $this->description = "Información de contacto para pedidos o sugerencias relacionadas con CasabeSoft Academia."; 
        $this->load_page('contact');
    }
    
    public function login() {
        // TODO: Remplazar literales por acceso a texto desde recurso internacionalizado
        $this->title = "CasabeSoft Academia - Iniciar sesión";
        $this->description = "Control de accesos para clientes de CasabeSoft Academia."; 
        $this->load_page('login');
    }
}

/* End of file public_pages.php */
/* Location: ./application/controllers/public_pages.php */