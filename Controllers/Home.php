<?php 
	require_once("Models/TProducto.php");
	
	class Home extends Controllers{
		use TProducto;
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function home()
		{
			//$data['topics'] = $this->getCategoriasT();
			$data['products'] = $this->getProductosT();
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = NOMBRE_EMPRESA;
			$data['page_name'] = NOMBRE_EMPRESA;
			//$data['page'] = $pageContent;
			//$data['slider'] = $this->getCategoriasT(CAT_SLIDER);
			//$data['banner'] = $this->getCategoriasT(CAT_BANNER);
			//$data['productos'] = $this->getProductosT();
			$this->views->getView($this,"home",$data); 
		}

		

	}
 ?>
