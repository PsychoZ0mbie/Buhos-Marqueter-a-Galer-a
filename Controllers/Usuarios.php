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
		}

		public function Usuarios(){
			/*if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}*/
			$data['page_tag'] = "Usuarios | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Usuarios";
			$data['page_name'] = "usuarios";
			$this->views->getView($this,"usuarios",$data);
		}

		public function setUsuario(){
			if($_POST){
				if(empty($_POST['txtFirstName']) || empty($_POST['txtLastName']) || empty($_POST['txtPhone']) || empty($_POST['typeList']) 
				|| empty($_POST['txtEmail'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$idUsuario = intval($_POST['idUser']);
					$strNombre = ucwords(strClean($_POST['txtFirstName']));
					$strApellido = ucwords(strClean($_POST['txtLastName']));
					$intTelefono = intval(strClean($_POST['txtPhone']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$strPassword = strClean($_POST['txtPassword']);
					$intTipoId = intval(strClean($_POST['typeList']));
					$request_user = "";
					$foto = "";
					$foto_perfil="";
					
				
					if($idUsuario == 0){
						$option = 1;
						if($_FILES['txtImg']['name'] == ""){
							$foto_perfil = "avatar.png";
						}else{
							$foto = $_FILES['txtImg'];
							$foto_perfil = 'perfil_'.bin2hex(random_bytes(6)).'.gif';
						}
						$strPassword =  hash("SHA256",$_POST['txtPassword']);
						$request_user = $this->model->insertUsuario($strNombre, 
																	$strApellido,
																	$foto_perfil, 
																	$intTelefono, 
																	$strEmail,
																	$strPassword, 
																	$intTipoId);
					}else{
						$option = 2;
						$request = $this->model->selectUsuario($idUsuario);
						if($_FILES['txtImg']['name'] == ""){
							$foto_perfil = $request['picture'];
						}else{
							if($request['picture'] != "avatar.png"){
								deleteFile($request['picture']);
							}
							$foto = $_FILES['txtImg'];
							$foto_perfil = 'perfil_'.bin2hex(random_bytes(6)).'.gif';
						}
						$strPassword =  hash("SHA256",$_POST['txtPassword']);
						$request_user = $this->model->updateUsuario($idUsuario, 
																	$strNombre,
																	$strApellido,
																	$foto_perfil, 
																	$intTelefono, 
																	$strEmail,
																	$strPassword, 
																	$intTipoId);

					}

					if($request_user > 0 ){
						if($foto!=""){
							uploadImage($foto,$foto_perfil);
						}
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

        public function getUsuarios(){
			$options="";
			if(isset($_POST['orderBy'])){
				$options =intval($_POST['orderBy']);
			}
			$arrData = $this->model->selectUsuarios($options);
			for ($i=0; $i < count($arrData); $i++) { 
				$arrData[$i]['picture'] = base_url()."/Assets/images/uploads/".$arrData[$i]['picture'];
			}
			//$_SESSION['idUser'] == 1 and $_SESSION['userData']['idrole'
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getUsuario(){
			$idusuario = intval($_POST['idUser']);
			if($idusuario > 0){
				$arrData = $this->model->selectUsuario($idusuario);
				if(empty($arrData)){
					
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
					$arrData['url'] = base_url()."/Assets/images/uploads/".$arrData['picture'];
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
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
				$intIdUsuario = intval($_POST['idUser']);
				$request = $this->model->selectUsuario($intIdUsuario);

				if($request['picture'] !="avatar.png"){
					deleteFile($request['picture']);
				}

				$requestDelete = $this->model->deleteUsuario($intIdUsuario);
				if($requestDelete == 'ok')
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
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