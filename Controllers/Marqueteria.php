<?php 
    class Marqueteria extends Controllers{
		public function __construct()
		{
			session_start();
			if(empty($_SESSION['login'])){
			
				header('Location: '.base_url().'/login');
				die();
			}
			parent::__construct();
		}
		/******************************Products************************************/
		public function productos(){
			if($_SESSION['userData']['roleid'] != 1){
				header('Location: '.base_url().'/logout');
			}
			$data['page_tag'] = "Marqueteria | Productos";
			$data['page_title'] = "Marqueteria | Productos";
			$data['page_name'] = "marqueteria";
			$this->views->getView($this,"marqueteria",$data);
		}

		public function getProductos(){
			if($_SESSION['userData']['roleid'] == 1){
				$options="";
				if(isset($_POST['orderBy'])){
					$options =intval($_POST['orderBy']);
				}
				$arrData = $this->model->selectProductos($options);
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}else{
				header('Location: '.base_url().'/logout');
			}
			die();
		}
		public function setProducto(){
			if($_SESSION['userData']['roleid'] == 1){
				if($_POST){
					if(empty($_POST['txtName']) || empty($_POST['topicList']) || empty($_POST['intPrice']) || empty($_POST['intWaste']) || empty($_POST['statusList'])){
						$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
					}else{ 
						$idProducto = intval($_POST['idProduct']);
						$strNombre = ucwords(strClean($_POST['txtName']));
						$intCategoria = intval(strClean($_POST['topicList']));
						$intEstado = intval(strClean($_POST['statusList']));
						$intPrecio = intval(strClean($_POST['intPrice']));
						$intDesperdicio = intval(strClean($_POST['intWaste']));
	
						$request_product = "";
						$foto=[];
						$foto_img=[];
	
						$ruta = strtolower(clear_cadena($strNombre));
						$ruta = str_replace(" ","-",$ruta);
						$ruta = str_replace("?","",$ruta);
						$ruta = str_replace("¿","",$ruta);
						
					
						if($idProducto == 0){
							$option = 1;
							foreach ($_FILES as $file) {
								if($file['name']==""){
									array_push($foto,"subirfoto.png");
								}else{
									array_push($foto,$file);
									array_push($foto_img,'pro_'.bin2hex(random_bytes(6)).'.gif');
								}
							}
							$request_product = $this->model->insertProducto(1,
																		$strNombre, 
																		$intCategoria, 
																		$intPrecio,
																		$intDesperdicio,
																		$ruta,
																		$intEstado,
																		$foto_img);
						}else{
							
							$option = 2;
							$request = $this->model->selectImage($idProducto);
							$flag = 0;
							foreach ($_FILES as $file) {
								if($file['name']==""){
									array_push($foto_img,[$request[$flag]['idimage'],$request[$flag]['title']]);
									array_push($foto,"");
								}else{
									if($request[$flag]['title'] != "subirfoto.png"){
										deleteFile($request[$flag]['title']);
									}
									array_push($foto,$file);
									array_push($foto_img,[$request[$flag]['idimage'],'pro_'.bin2hex(random_bytes(6)).'.gif']);
								}
								$flag++;
							}
							$request_product = $this->model->updateProducto($idProducto,
																		1,
																		$strNombre, 
																		$intCategoria, 
																		$intPrecio,
																		$intDesperdicio,
																		$ruta,
																		$intEstado,
																		$foto_img);
	
						}
	
						if($request_product > 0 ){
							if($option==1){
								for ($i=0; $i < count($foto) ; $i++) { 
									uploadImage($foto[$i],$foto_img[$i]);
								}
							}else{
								if(count($foto)){
									for ($i=0; $i < count($foto) ; $i++) { 
										if($foto[$i]!=""){
											uploadImage($foto[$i],$foto_img[$i][1]);
										}
									}
								}
							}
							if($option == 1){
								$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
							}else{
								$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
							}
						}else if($request_product == 'exist'){
							$arrResponse = array('status' => false, 'msg' => '¡Atención! el título ya existe, ingrese otro.');		
						}else{
							$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
						}
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}else{
				header('Location: '.base_url().'/logout');
			}
			die();

		}
		public function getProducto($producto){
			if($_SESSION['userData']['roleid'] == 1){

				$idProducto = intval($_POST['idProduct']);
				if($idProducto > 0){
					$arrData = $this->model->selectProducto($idProducto);
					if(empty($arrData)){
						
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						for ($i=0; $i < count($arrData['img']) ; $i++) { 
							$arrData['img'][$i] = base_url()."/Assets/images/uploads/".$arrData['img'][$i]['title'];
						}
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}else{
				header('Location: '.base_url().'/logout');
			}
			die();
		}
		public function delProducto(){
			if($_SESSION['userData']['roleid'] == 1){

				if($_POST){
					$intIdProducto = intval($_POST['idProduct']);
					$request = $this->model->selectProducto($intIdProducto);
	
					for ($i=0; $i < count($request['img']); $i++) { 
						if($request['img'][$i]['title'] !="subirfoto.png"){
							deleteFile($request['img'][$i]['title']);
						}
					}
					
	
					$requestDelete = $this->model->deleteProducto($intIdProducto);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}else{
				header('Location: '.base_url().'/logout');
			}
			die();
		}
		/******************************Colors************************************/

		public function colores(){
			if($_SESSION['userData']['roleid'] != 1){
				header('Location: '.base_url().'/logout');
			}
			$data['page_tag'] = "Marqueteria | Colores";
			$data['page_title'] = "Marqueteria | Colores";
			$data['page_name'] = "colores";
			$this->views->getView($this,"colores",$data);
		}
		public function getColores(){
			if($_SESSION['userData']['roleid'] == 1){

				$options="";
				if(isset($_POST['orderBy'])){
					$options =intval($_POST['orderBy']);
				}
				$arrData = $this->model->selectColors($options);
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}else{
				header('Location: '.base_url().'/logout');
			}
			die();
		}
		public function setColor(){
			if($_SESSION['userData']['roleid'] == 1){
				if($_POST){
					if(empty($_POST['txtName']) || empty($_POST['txtHexa']) || empty($_POST['statusList'])){
						$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
					}else{ 
						$idColor = intval($_POST['idColor']);
						$strNombre = ucwords(strClean($_POST['txtName']));
						$strHex = strtolower(strClean($_POST['txtHexa']));
						$intEstado = intval(strClean($_POST['statusList']));
	
						$request_product = "";
					
						if($idColor == 0){
							$option = 1;
							$request_product = $this->model->insertColor($strNombre,$strHex,$intEstado);
						}else{
							
							$option = 2;
							$request_product = $this->model->updateColor($idColor,$strNombre,$strHex,$intEstado);
	
						}
	
						if($request_product > 0 ){
							if($option == 1){
								$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
							}else{
								$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
							}
						}else if($request_product == 'exist'){
							$arrResponse = array('status' => false, 'msg' => '¡Atención! el título ya existe, ingrese otro.');		
						}else{
							$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
						}
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}else{
				header('Location: '.base_url().'/logout');
			}
			die();

		}
		public function getColor($color){
			if($_SESSION['userData']['roleid'] == 1){

				$idColor = intval($_POST['idcolor']);
				if($idColor > 0){
					$arrData = $this->model->selectColor($idColor);
					if(empty($arrData)){
						
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}else{
				header('Location: '.base_url().'/logout');
			}
			die();
		}
		public function delColor(){
			if($_SESSION['userData']['roleid'] == 1){
				if($_POST){
	
					$idColor = intval($_POST['idcolor']);
					
					$requestDelete = $this->model->deleteColor($idColor);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}else{
				header('Location: '.base_url().'/logout');
			}
			die();
		}


	}
?>