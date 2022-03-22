<?php
    class Nosotros extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
        }

        public function Nosotros(){
            $data['page_tag'] = "Nosotros | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Nosotros | ".NOMBRE_EMPRESA;
			$data['page_name'] = "nosotros";
            $this->views->getView($this,"nosotros",$data);
        }
    }
?>