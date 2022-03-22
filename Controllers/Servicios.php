<?php
    class Servicios extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
        }

        public function Servicios(){
            $data['page_tag'] = "Servicios | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Servicios | ".NOMBRE_EMPRESA;
			$data['page_name'] = "servicios";
            $this->views->getView($this,"servicios",$data);
        }
    }
?>