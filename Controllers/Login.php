<?php 

	class Login extends Controllers{
		public function __construct()
		{
			session_start();
			if(isset($_SESSION['login']))
			{
				header('Location: '.base_url().'/dashboard');
				die();
			}
			parent::__construct();
		}

		public function login()
		{
			$data['page_tag'] = "Login";
			$data['page_title'] = "Buhos marquetería y galeria";
			$data['page_name'] = "login";
			$data['page_functions'] = "functions_login.js";
			$this->views->getView($this,"login",$data);
		}
		

		public function loginUser(){
			if($_POST){
				if(empty($_POST['txtEmail']) || empty($_POST['txtPassword'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos' );
				}else{
					$strUsuario  =  strtolower(strClean($_POST['txtEmail']));
					$strPassword = hash("SHA256",$_POST['txtPassword']);
					$requestUser = $this->model->loginUser($strUsuario, $strPassword);
					if(empty($requestUser)){
						$arrResponse = array('status'=>false, 'msg'=> 'El usuario o la contraseña es incorrecto.');
					}else{
						$arrData =$requestUser;
						$_SESSION['idUser'] = $arrData['idperson'];
						$_SESSION['login'] = true;

						$arrData = $this->model->sessionLogin($_SESSION['idUser']);
						sessionUser($_SESSION['idUser']);

						$arrResponse = array('status'=>true, 'msg'=> 'Sesión iniciada.');

					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			
			die();
		}

		public function resetPass(){
			if($_POST){
				if(empty($_POST['txtEmailReset'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos');
				}else{
					$token = token();
					$strEmail = strtolower(strClean($_POST['txtEmailReset']));
					$arrData = $this->model->getUserEmail($strEmail);
					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'El usuario no existe');
					}else{
						$idpersona = $arrData['idperson'];
						$nombreUsuario = $arrData['firstname'].' '.$arrData['lastname'];

						$url_recovery = base_url().'/login/confirmUser/'.$strEmail.'/'.$token;
						$requestUpdate = $this->model->setTokenUser($idpersona,$token);

						$dataUsuario = array('nombreUsuario'=> $nombreUsuario, 'email_remitente' => EMAIL_REMITENTE, 'email_usuario'=>$strEmail, 'asunto' =>'Recuperar cuenta - '.NOMBRE_REMITENTE,'url_recovery' => $url_recovery);


						if($requestUpdate){
							
							$sendEmail = sendEmail($dataUsuario, 'email_cambioPassword');

							if($sendEmail){
								$arrResponse = array('status' => true, 'msg' => 'Se ha enviado un correo para cambiar la contraseña');
								
							}else{
								$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
							}
							
						}else{
							$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
						}
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function confirmUser(string $params){

			if(empty($params)){
				header('Location: '.base_url());
			}else{
				$arrParams = explode(',',$params);
				$strEmail = strClean($arrParams[0]);
				$strToken = strClean($arrParams[1]);
				
				$arrResponse = $this->model->getUsuario($strEmail,$strToken);

				if(empty($arrResponse)){
					header('Location: '.base_url());
				}else{
					
					$data['page_tag'] = "Cambiar contraseña";
					$data['page_title'] = "Cambiar contraseña";
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$data['page_name'] = "cambiar_contraseña";
					$data['idperson'] = $arrResponse['idperson'];
					$data['page_functions'] = "functions_login.js";
					$this->views->getView($this,"cambiar_password",$data);
				}
			}
			die();
		}

		public function setPassword(){
			if(empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtPassword']) || empty($_POST['txtToken']) || empty($_POST['txtPasswordConfirm'])){
				$arrResponse = array('status' => false,'msg' => 'Error de datos');
			}else{
				$intIdpersona = intval($_POST['idUsuario']);
				$strPassword = $_POST['txtPassword'];
				$strEmail = strClean($_POST['txtEmail']);
				$strToken = strClean($_POST['txtToken']);
				$strPasswordConfirm = $_POST['txtPasswordConfirm'];

				if($strPassword != $strPasswordConfirm){
					$arrResponse = array('status' => false,'msg'=>'Las contraseñas no coinciden');
				}else{
					$arrResponseUser = $this->model->getUsuario($strEmail, $strToken);
					if(empty($arrResponseUser)){
						$arrResponse = array('status' => false,'msg'=>'Error de datos.');
					}else{
						$strPassword = hash("SHA256",$strPassword);
						$requestPass = $this->model->insertPassword($intIdpersona, $strPassword);

						if($requestPass){
							$arrResponse = array('status' => true, 'msg' => 'Contraseña actualizada');
						}else{
							$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intente más tarde.');
						}
					}
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

	}
 ?>