<?php 
	require_once("Models/TProducto.php");
	
	class Home extends Controllers{
		use TProducto;
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function home($params)
		{
			/*$params = strClean($params);
            $ruta = ucwords(str_replace("-"," ",$params));
			$data['products'] = $this->getProductosT();
			$data['galeria'] = $this->getProductosCategoriasT(2,$params,3);
			$data['marqueteria'] = $this->getProductosCategoriasT(1,$params,3);*/
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
