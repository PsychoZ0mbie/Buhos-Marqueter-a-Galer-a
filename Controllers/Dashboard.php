<?php 
    class Dashboard extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
            getPermisos(1);
        }

        public function dashboard(){
            if(empty($_SESSION['permisosMod']['r'])){
                header("Location: ".base_url()."/usuarios/perfil");
                die();
            }
            
            $data['page_tag'] = "Dashboard";
			$data['page_title'] = "Dashboard";
			$data['page_name'] = "dashboard"; 
            //$data['page_functions'] = "functions_dashboard.js"; 
            /*$data['usuarios'] = $this->model->selectUsuarios();
            $data['articulos'] = $this->model->selectArticulos();
            $data['suscripciones'] = $this->model->selectSuscripciones();
            $data['contactos'] = $this->model->selectContactos();*/
            $this->views->getView($this,"dashboard",$data);
        }
    }
?>