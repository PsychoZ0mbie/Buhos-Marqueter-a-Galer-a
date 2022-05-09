<?php 
	require_once("Models/TProducto.php");
	
	class Home extends Controllers{
		use TProducto;
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function home($params){
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = NOMBRE_EMPRESA;
			$data['page_name'] = NOMBRE_EMPRESA;
			$this->views->getView($this,"home",$data); 
		}

		

	}
 ?>
