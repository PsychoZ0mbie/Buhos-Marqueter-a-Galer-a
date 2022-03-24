<?php
    class Politicas extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
        }

        public function Politicas(){
            $data['page_tag'] = "Politicas | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Politicas | ".NOMBRE_EMPRESA;
			$data['page_name'] = "politicas";
            $this->views->getView($this,"politicas",$data);
        }
    }
?>