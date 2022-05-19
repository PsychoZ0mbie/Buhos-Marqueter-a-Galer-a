<?php 
	require_once("Models/TProducto.php");
	require_once("Models/LoginModel.php");
	class Cuenta extends Controllers{
		private $login;
		public function __construct()
		{
			parent::__construct();
			session_start();
			$this->login = new LoginModel();
		}

		public function Cuenta(){
		
			$data['page_tag'] = "Cuenta | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Cuenta | ".NOMBRE_EMPRESA;
			$data['page_name'] = "cuenta";
			$this->views->getView($this,"cuenta",$data); 
		}

		public function Recuperar(string $params){
			if(empty($params)){
				header("location: ".base_url());
			}else{

				$params = explode(",",$params);
				$strEmail = strClean($params[0]);
				$strToken = strClean($params[1]);
				
				$request = $this->login->getUsuario($strEmail,$strToken);
				if(empty($request)){
					header("location: ".base_url());	
				}else{
					$data['page_tag'] = "Recuperar | ".NOMBRE_EMPRESA;
					$data['page_title'] = "Recuperar | ".NOMBRE_EMPRESA;
					$data['page_name'] = "recuperar";
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$data['idperson'] = $request['idperson'];
					$this->views->getView($this,"recuperar",$data); 
				}
			}
			die();

		}
	}
 ?>