<?php 

	class Usuarios extends Controllers{
		public function __construct()
		{
			
			parent::__construct();
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(2);
		}

		public function Usuarios(){
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Usuarios | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Usuarios";
			$data['page_name'] = "usuarios";
			$data['page_functions'] = "functions_usuarios.js";
			$this->views->getView($this,"usuarios",$data);
		}

		public function setUsuario(){
			if(!empty($_SESSION['permisosMod']['w'])){
				if($_POST){
					if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['listRolid']))
					{
						$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
					}else{ 
						$idUsuario = intval($_POST['idUsuario']);
						$strNombre = ucwords(strClean($_POST['txtNombre']));
						$strApellido = ucwords(strClean($_POST['txtApellido']));
						$intTelefono = intval(strClean($_POST['txtTelefono']));
						$strEmail = strtolower(strClean($_POST['txtEmail']));
						$intTipoId = intval(strClean($_POST['listRolid']));
						$request_user = "";
					
						if($idUsuario == 0)
						{
							$option = 1;
							$strPassword =  empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);
							if($_SESSION['permisosMod']['w']){
								$request_user = $this->model->insertUsuario($strNombre, 
																			$strApellido, 
																			$intTelefono, 
																			$strEmail,
																			$strPassword, 
																			$intTipoId);
							}
						}else{
							$option = 2;
							$strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
							if($_SESSION['permisosMod']['u']){
								$request_user = $this->model->updateUsuario($idUsuario, 
																			$strNombre,
																			$strApellido, 
																			$intTelefono, 
																			$strEmail,
																			$strPassword, 
																			$intTipoId);
							}

						}

						if($request_user > 0 )
						{
							if($option == 1){
								$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
							}else{
								$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
							}
						}else if($request_user == 'exist'){
							$arrResponse = array('status' => false, 'msg' => '¡Atención! el email ó el teléfono ya está registrado, ingrese otro.');		
						}else{
							$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
						}
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
				
				die();
			}
		}

        public function getUsuarios(){
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectUsuarios();
				for ($i=0; $i < count($arrData); $i++) {
	
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
	
					if($_SESSION['permisosMod']['u']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrole'] ==1) || ($_SESSION['userData']['idrole'] ==1 and $arrData[$i]['idrole']!=1 )){	
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario(this,'.$arrData[$i]['idperson'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
						}else{
							$btnEdit = '<button class="btn btn-secondary btn-sm" disabled ><i class="fas fa-pencil-alt"></i></button>';
						}		
					}
					if($_SESSION['permisosMod']['d']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrole'] == 1) || ($_SESSION['userData']['idrole'] == 1 and $arrData[$i]['idrole'] != 1) and ($_SESSION['userData']['idperson'] != $arrData[$i]['idperson'] )){
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['idperson'].')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';
						}else{
							$btnDelete = '<button class="btn btn-secondary btn-sm" disabled ><i class="far fa-trash-alt"></i></button>';
						}
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getUsuario($idpersona){
			if($_SESSION['permisosMod']['r']){
				$idusuario = intval($idpersona);
				if($idusuario > 0){
					$arrData = $this->model->selectUsuario($idusuario);
					if(empty($arrData)){
					
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function getSelectUsuario(){
			$htmlOptions = "";
			$arrData = $this->model->selectUsuariosPicker();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['idperson'].'">'.$arrData[$i]['firstname'].' '.$arrData[$i]['lastname'].'</option>';
				}
			}
			echo $htmlOptions;
			die();	
		}
		public function delUsuario(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdUsuario = intval($_POST['idUsuario']);
					$requestDelete = $this->model->deleteUsuario($intIdUsuario);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		public function perfil(){
			$data['page_tag'] = "Perfil";
			$data['page_title'] = "Perfil";
			$data['page_name'] = "perfil";
			$data['page_functions'] = "functions_usuarios.js";
			$this->views->getView($this,"perfil",$data);
		}
		

		public function putPerfil(){
			if($_POST){
				if(empty($_POST['txtNombre']) ||empty($_POST['txtApellido'])  || empty($_POST['txtTelefono']) ||empty($_POST['txtId'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strNombre = strClean($_POST['txtNombre']);
					$strApellido = strClean($_POST['txtApellido']);
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$intDepartment = intval($_POST['listDepartamento']);
					$intCity = intval($_POST['listCiudad']);
					$strDireccion = strClean($_POST['txtDir']);
					$strId = strClean($_POST['txtId']);
					$foto = "";
					$foto_perfil="";

					$request = $this->model->selectUsuario($idUsuario);
					if($_FILES['profile-img']['name'] ==""){
						$foto_perfil =$request['picture'];
					}else{
						deleteFile($request['picture']);
						$foto = $_FILES['profile-img'];
						$foto_perfil = 'perfil_'.bin2hex(random_bytes(6)).'.jpg';
					}
					
						
					
					

					$strPassword = "";
					if(!empty($_POST['txtPassword'])){
						$strPassword = hash("SHA256",$_POST['txtPassword']);
					}
	
					$request_user = $this->model->updatePerfil($idUsuario,
																$strNombre,
																$strApellido,
																$foto_perfil,
																$intTelefono,
																$strDireccion,
																$intDepartment,
																$intCity,
																$strId,
																$strPassword);
					
					if($request_user){
						if($foto!=""){
							uploadImage($foto,$foto_perfil);
						}
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status'=> true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		
		public function getSelectDepartamentos(){
			$htmlDepartamento="";
			$htmlCiudad="";
			$arrDepartment = $this->model->selectDepartamento();
			$arrCity = $this->model->selectCiudad($_SESSION['userData']['departmentid']);
			if(count($arrDepartment) > 0){
				for ($i=0; $i < count($arrDepartment) ; $i++) { 
					if($_SESSION['userData']['departmentid']== $arrDepartment[$i]['iddepartment']){
						$htmlDepartamento .= '<option value="'.$arrDepartment[$i]['iddepartment'].'" selected>'.$arrDepartment[$i]['department'].'</option>';
					}else{
						$htmlDepartamento .= '<option value="'.$arrDepartment[$i]['iddepartment'].'">'.$arrDepartment[$i]['department'].'</option>';
					}
				}
			}
			if(count($arrCity) > 0){
				for ($i=0; $i < count($arrCity); $i++) { 
					if($_SESSION['userData']['cityid']== $arrCity[$i]['idcity']){
						$htmlCiudad .= '<option value="'.$arrCity[$i]['idcity'].'" selected>'.$arrCity[$i]['city'].'</option>';
					}else{
						$htmlCiudad .= '<option value="'.$arrCity[$i]['idcity'].'">'.$arrCity[$i]['city'].'</option>';
					}
				}
			}
			$arrResponse = array("department" =>$htmlDepartamento, "city"=>$htmlCiudad);
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getSelectCity($department){
			$htmlCiudad="";
			$arrData = $this->model->selectCiudad($department);
			if(count($arrData)>0){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlCiudad .= '<option value="'.$arrData[$i]['idcity'].'" selected>'.$arrData[$i]['city'].'</option>';
				}
			}
			echo $htmlCiudad;
		}
	}
 ?>