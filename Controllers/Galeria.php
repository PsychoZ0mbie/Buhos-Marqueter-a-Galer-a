<?php 
    class Galeria extends Controllers{
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
		public function galeria(){
			if($_SESSION['userData']['roleid'] != 1){
				header('Location: '.base_url().'/logout');
			}
			$data['page_tag'] = "Galería | Productos";
			$data['page_title'] = "Galería | Productos";
			$data['page_name'] = "galeria";
			$this->views->getView($this,"galeria",$data);
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
					if(empty($_POST['txtName']) || empty($_POST['intWidth']) || empty($_POST['intHeight']) 
					|| empty($_POST['topicList'])|| empty($_POST['subtopicList'])|| empty($_POST['intPrice']) || empty($_POST['frameList']) || empty($_POST['statusList'])){
						$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
					}else{ 
						$idProducto = intval($_POST['idProduct']);
						$strDescripcion=strClean($_POST['txtDescription']);
						$strNombre = ucwords(strClean($_POST['txtName']));
						$strAutor = ucwords(strClean($_POST['txtAuthor']));
						$intAncho = intval(strClean($_POST['intWidth']));
						$intAlto = intval(strClean($_POST['intHeight']));
						$intCategoria = intval(strClean($_POST['topicList']));
						$intSubcategoria = intval(strClean($_POST['subtopicList']));
						$intMarco = intval(strClean($_POST['frameList']));
						$intEstado = intval(strClean($_POST['statusList']));
						$intPrecio = intval(strClean($_POST['intPrice']));
						$request_product = "";
						$foto=[];
						$foto_img=[];
	
						if($strAutor==""){
							$strAutor = "Desconocido";
						}
	
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
							$request_product = $this->model->insertProducto(2,
																		$strNombre, 
																		$strAutor,
																		$intCategoria, 
																		$intSubcategoria, 
																		$intAlto,
																		$intAncho, 
																		$intMarco,
																		$intPrecio,
																		$strDescripcion,
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
																		2,
																		$strNombre, 
																		$strAutor,
																		$intCategoria, 
																		$intSubcategoria, 
																		$intAlto,
																		$intAncho, 
																		$intMarco,
																		$intPrecio,
																		$strDescripcion,
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
	}
?>