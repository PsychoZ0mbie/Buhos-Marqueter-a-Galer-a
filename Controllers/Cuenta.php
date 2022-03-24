<?php 
	require_once("Models/TProducto.php");
	
	class Cuenta extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function Cuenta(){
		
			$data['page_tag'] = "Cuenta | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Cuenta | ".NOMBRE_EMPRESA;
			$data['page_name'] = "cuenta";
			$this->views->getView($this,"cuenta",$data); 
		}

		

	}
 ?>