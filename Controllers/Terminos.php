<?php
    class Terminos extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
        }

        public function Terminos(){
            $data['page_tag'] = "Terminos | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Terminos | ".NOMBRE_EMPRESA;
			$data['page_name'] = "terminos";
            $this->views->getView($this,"terminos",$data);
        }
    }
?>