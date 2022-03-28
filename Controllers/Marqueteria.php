<?php 
    class Marqueteria extends Controllers{
		public function __construct()
		{
			session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			parent::__construct();
			getPermisos(3);
		}
		/******************************Products************************************/
		public function Productos(){
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Marquetería | Productos";
			$data['page_title'] = "Marquetería | Productos";
			$data['page_name'] = "productos";
			$data['page_functions'] = "functions_marqueteria.js";
			$this->views->getView($this,"productos",$data);
		}

		public function getProductos(){
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectProductos();
				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = "";
					$btnEdit = "";
					$btnDelete = "";

					if($arrData[$i]['status'] == 1){
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}
					$url = base_url()."/catalogo/producto/".$arrData[$i]['route'];
					$btnView = '<a class="btn btn-info btn-sm title="Ver" href="'.$url.'" target="_blank"><i class="far fa-eye"></i></a>';

					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditInfo('.$arrData[$i]['idproduct'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}else{
						$btnEdit = '<button class="btn btn-secondary btn-sm" disabled ><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelInfo('.$arrData[$i]['idproduct'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
					}else{
						$btnDelete = '<button class="btn btn-secondary btn-sm" disabled ><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
					$arrData[$i]['price'] = MS.number_format($arrData[$i]['price'],0,DEC,MIL);
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setProducto(){
			if($_SESSION['permisosMod']['w']){
				if($_POST){
					if(empty($_POST['txtNombre']) || empty($_POST['listCategoria']) || empty($_POST['listTecnica']) || empty($_POST['listStatus'])
					|| empty($_POST['txtPrecio']) || empty($_POST['txtCantidad'])){
						
						$arrResponse = array("status" =>false,"msg"=>"Datos incorrectos.");
					}else{
						$intIdProducto = intval($_POST['idProducto']);
						$strProducto = ucwords(strClean($_POST['txtNombre']));
						$intIdCategoria = 1;
						$intIdSubcategoria = intval($_POST['listCategoria']);
						$intIdTecnica = intval($_POST['listTecnica']);
						$floatPrecio = intval($_POST['txtPrecio']);
						$intCantidad = intval($_POST['txtCantidad']);
						$strDescripcion = strClean($_POST['txtDescripcion']);
						$intStatus = intval($_POST['listStatus']);
						
						//$strReferencia = str_replace(" ","",$strProducto);
						//$strRefNombre =substr($strReferencia,0,2).substr($strReferencia,-2);
						$strReferencia = "ma".$intIdCategoria.$intIdSubcategoria.$intIdTecnica;
						

						$ruta = $strReferencia.strtolower(clear_cadena($strProducto));
						$ruta = str_replace(" ","-",$ruta);
						$ruta = str_replace("?","",$ruta);
						$ruta = str_replace("¿","",$ruta);
						//$strReferencia = $ruta;
						if($intIdProducto == 0){
							if($_SESSION['permisosMod']['w']){
								$request = $this->model->insertProducto($strReferencia,
																		$strProducto,
																		$intIdCategoria,
																		$intIdSubcategoria,
																		$intIdTecnica,
																		$floatPrecio,
																		$intCantidad,
																		$strDescripcion,
																		$ruta,
																		$intStatus);
								$option = 1;
							}
						}else{
							if($_SESSION['permisosMod']['u']){
								$request = $this->model->updateProducto($intIdProducto,
																		$strReferencia,
																		$strProducto,
																		$intIdCategoria,
																		$intIdSubcategoria,
																		$intIdTecnica,
																		$floatPrecio,
																		$intCantidad,
																		$strDescripcion,
																		$ruta,
																		$intStatus);
								$option = 2;
							}
						}
						if($request > 0){
							if($option == 1){
								$arrResponse = array('status'=>true,'idproducto'=>$request,'msg' => 'Datos guardados correctamente');
							}else{
								$arrResponse = array("status" =>true,"idproducto" =>$intIdProducto,"msg" =>"Datos actualizados correctamente");
							}
						}else if($request =="exist"){
							$arrResponse = array("status" =>false,"msg"=>"Ya existe el producto, revisa la papelera o intente con un nombre distinto.");
						}else{
							$arrResponse = array("status" =>false,"msg"=>"Ha ocurrido un problema, inténtelo más tarde");
						}
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
				die();
			}
		}

		public function getProducto($producto){
			if($_SESSION['permisosMod']['r']){
				$idProducto = intval($producto);
				if($idProducto > 0){
					$arrData = $this->model->selectProducto($idProducto);
					if(empty($arrData)){
						$arrResponse = array("status"=>true,"msg"=>"Datos no encontrador");
					}else{
						$arrImg = $this->model->selectImage($idProducto);
						if(count($arrImg)){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url'] = media()."/images/uploads/".$arrImg[$i]['title'];
							}
						}
					}

					$arrData['img'] = $arrImg;
					$arrResponse = array("status"=>true,"data"=>$arrData);
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delProducto(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){

					$intIdProducto = intval($_POST['idproducto']);
					$requestDelete = $this->model->deleteProducto($intIdProducto);
					if($requestDelete == 'ok'){
						$arrResponse = array('status' => true, 'msg' => 'Se ha enviado a la papelera');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	
		public function setImage(){
			if($_POST){
				if(empty($_POST['idProducto'])){
					$arrResponse = array('status' => false, 'msg' => 'Error, inténtelo más tarde.');
				}else{
					$idProducto = intval($_POST['idProducto']);
					$foto      = $_FILES['foto'];
					$imgNombre = 'pro_'.bin2hex(random_bytes(6)).'.gif';
					$request_image = $this->model->insertImage($idProducto,$imgNombre);
					if($request_image){
						$uploadImage = uploadImage($foto,$imgNombre);
						$arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Imagen cargada.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error, inténtelo más tarde.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delFile(){
			if($_POST){
				if(empty($_POST['idProducto']) || empty($_POST['file'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					//Eliminar de la DB
					$idProducto = intval($_POST['idProducto']);
					$imgNombre  = strClean($_POST['file']);
					$request_image = $this->model->deleteImage($idProducto,$imgNombre);

					if($request_image){
						$deleteFile =  deleteFile($imgNombre);
						$arrResponse = array('status' => true, 'msg' => 'Archivo eliminado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getPapelera(){
			if($_SESSION['permisosMod']['r']){

                $arrData = $this->model->selectPapelera();
				for ($i=0; $i < count($arrData); $i++) {
	
					$btnRecovery = '';
					$btnDelete = '';
	
					if($_SESSION['permisosMod']['u']){
						$btnRecovery = '<button class="btn btn-info btn-sm " onClick="fntRecoveryInfo('.$arrData[$i]['idproduct'].')" title="Recuperar"><i class="fas fa-undo"></i></button>';
					}else{
						$btnRecovery = '<button class="btn btn-secondary btn-sm" disabled ><i class="fas fa-undo"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelfEver('.$arrData[$i]['idproduct'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
					}else{
						$btnDelete = '<button class="btn btn-secondary btn-sm" disabled ><i class="far fa-trash-alt"></i></button>';
					}

					$arrData[$i]['options'] = '<div class="text-center">'.$btnRecovery.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getRecoveryProducto($idproducto){
			if($_SESSION['permisosMod']['u']){
				$idproducto = intval($idproducto);
				if($idproducto > 0){
					$arrData = $this->model->recovery($idproducto);
					if(empty($arrData)){
						$arrResponse = array("status"=>false,"msg"=>"Ha ocurrido un problema, inténtelo más tarde.");
					}else{
						$arrResponse = array("status"=>true,"msg"=>"Se ha recuperado.");
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		public function deleteRecovery($idproducto){
			if($_SESSION['permisosMod']['d']){

				$idproducto = intval($idproducto);
				if($idproducto > 0){
					$arrImg = $this->model->selectImage($idproducto);
					if(count($arrImg)){
						for ($i=0; $i < count($arrImg); $i++) { 
							deleteFile($arrImg[$i]['title']);
						}
					}
					$arrData = $this->model->deleteRecoveryInfo($idproducto);
					if($arrData=="ok"){
						$arrResponse = array("status"=>true,"msg"=>"Se ha eliminado.");
					}else{
						$arrResponse = array("status"=>false,"msg"=>"Error, inténtelo más tarde.");
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
        /******************************SubTopics************************************/
		public function Subcategorias(){
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Marquetería | Categorias";
			$data['page_title'] = "Marquetería | Categorias";
			$data['page_name'] = "Categorias";
			$data['page_functions'] = "functions_sub.js";
			$this->views->getView($this,"subcategorias",$data);
		}
        public function setSubcategoria(){
            if($_SESSION['permisosMod']['w']){
                if($_POST){
                    if(empty($_POST['txtNombre'])){
                        $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                    }else{

                        $intIdSubcategoria = intval($_POST['idSubcategoria']);
                        $strSubcategoria =  ucwords(strClean($_POST['txtNombre']));
						$intIdCategoria = 1;

						$ruta = strtolower(clear_cadena($strSubcategoria));
						$ruta = str_replace(" ","-",$ruta);

                        if($intIdSubcategoria == 0)
                        {
                            //Crear
                            if($_SESSION['permisosMod']['w']){

                                $request_categoria = $this->model->insertSubcategoria($strSubcategoria,$intIdCategoria,$ruta);
                                $option = 1;
                            }
                        }else{
                            //Actualizar
                            if($_SESSION['permisosMod']['u']){

                                $request_categoria = $this->model->updateSubcategoria($intIdSubcategoria, $strSubcategoria,$intIdCategoria,$ruta);
                                $option = 2;
                            }
                        }

                        if($request_categoria > 0 )
                        {
                            if($option == 1)
                            {
                                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                            }else{
                                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                            }
                        }else if($request_categoria == 'exist'){
                            
                            $arrResponse = array('status' => false, 'msg' => '¡Atención! La categoría ya existe.');
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
                die();
            }	
		}
        public function getSubcategorias(){
			if($_SESSION['permisosMod']['r']){

                $arrData = $this->model->selectSubcategorias();
				for ($i=0; $i < count($arrData); $i++) {
	
					$btnEdit = '';
					$btnDelete = '';
	
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditInfo(this,'.$arrData[$i]['idsubtopic'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelInfo('.$arrData[$i]['idsubtopic'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
        public function getSubcategoria($idSubcategoria){
			if($_SESSION['permisosMod']['r']){
				$intIdSubcategoria = intval($idSubcategoria);
				if($intIdSubcategoria > 0){
					$arrData = $this->model->selectSubcategoria($intIdSubcategoria);
					if(empty($arrData)){
					
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
                        //$arrData['url_portada'] = media().'/images/uploads/'.$arrData['image'];
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
        public function delSubcategoria(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){

					$intIdSubcategoria = intval($_POST['idSubcategoria']);

					$requestDelete = $this->model->deleteSubcategoria($intIdSubcategoria);
					if($requestDelete == 'ok'){
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar si está asociado a un producto.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		public function getSelectSubcategorias(){
			$html = "";
			$arrData =$this->model->selectSubcategorias();
			if(count($arrData)>0){
				for ($i=0; $i < count($arrData); $i++) { 
					$html .= '<option value="'.$arrData[$i]['idsubtopic'].'">'.$arrData[$i]['title'].'</option>';
				}
			}
			echo $html;
			die();
		}

		/******************************Techniques************************************/
		public function Tecnicas(){
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Marquetería | Subcategorias";
			$data['page_title'] = "Marquetería | Subcategorias";
			$data['page_name'] = "tecnicas";
			$data['page_functions'] = "functions_tec.js";
			$this->views->getView($this,"tecnicas",$data);
		}
		
        public function setTecnica(){
            if($_SESSION['permisosMod']['w']){
                if($_POST){
                    if(empty($_POST['txtNombre'])){
                        $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                    }else{

                        $intIdTecnica = intval($_POST['idTecnica']);
                        $strTecnica =  ucwords(strClean($_POST['txtNombre']));
						$intIdCategoria = 1;

						$ruta = strtolower(clear_cadena($strTecnica));
						$ruta = str_replace(" ","-",$ruta);

                        if($intIdTecnica == 0)
                        {
                            //Crear
                            if($_SESSION['permisosMod']['w']){

                                $request_tecnica = $this->model->insertTecnica($strTecnica,$intIdCategoria,$ruta);
                                $option = 1;
                            }
                        }else{
                            //Actualizar
                            if($_SESSION['permisosMod']['u']){

                                $request_tecnica = $this->model->updateTecnica($intIdTecnica, $strTecnica,$intIdCategoria,$ruta);
                                $option = 2;
                            }
                        }

                        if($request_tecnica > 0 )
                        {
                            if($option == 1)
                            {
                                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                            }else{
                                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                            }
                        }else if($request_tecnica == 'exist'){
                            
                            $arrResponse = array('status' => false, 'msg' => '¡Atención! La categoría ya existe.');
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
                die();
            }	
		}

        public function getTecnicas(){
			if($_SESSION['permisosMod']['r']){

                $arrData = $this->model->selectTecnicas();
				for ($i=0; $i < count($arrData); $i++) {
	
					$btnEdit = '';
					$btnDelete = '';
	
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditInfo(this,'.$arrData[$i]['idtechnique'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelInfo('.$arrData[$i]['idtechnique'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        public function getTecnica($idTecnica){
			if($_SESSION['permisosMod']['r']){
				$intIdTecnica = intval($idTecnica);
				if($intIdTecnica > 0){
					$arrData = $this->model->selectTecnica($intIdTecnica);
					if(empty($arrData)){
					
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
                        //$arrData['url_portada'] = media().'/images/uploads/'.$arrData['image'];
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

        public function delTecnica(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){

					$intIdTecnica = intval($_POST['idtecnica']);

					$requestDelete = $this->model->deleteTecnica($intIdTecnica);
					if($requestDelete == 'ok'){
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar si está asociado a un producto.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		public function getSelectTecnica(){
			$html="";
			$arrData = $this->model->selectTecnicas();
			if(count($arrData)>0){
				for ($i=0; $i < count($arrData); $i++) { 
					$html .= '<option value="'.$arrData[$i]['idtechnique'].'">'.$arrData[$i]['title'].'</option>';
				}
			}
			echo $html;
			die();
		}
		/******************************Attributes************************************/
		public function Atributos(){
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Marquetería | Atributos";
			$data['page_title'] = "Marquetería | Atributos";
			$data['page_name'] = "atributos";
			$data['page_functions'] = "functions_att.js";
			$this->views->getView($this,"atributos",$data);
		}
		
        public function setAtributo(){
            if($_SESSION['permisosMod']['w']){
                if($_POST){
                    if(empty($_POST['txtNombre']) || empty($_POST['listCategoria'])){
                        $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                    }else{

                        $intIdAtributo = intval($_POST['idAtributo']);
						$intIdSubcategoria = intval($_POST['listCategoria']);
						$strPrice = intval(($_POST['txtPrecio']));
                        $strAtributo =  ucwords(strClean($_POST['txtNombre']));
						$intIdCategoria = 1;


                        if($intIdAtributo == 0)
                        {
                            //Crear
                            if($_SESSION['permisosMod']['w']){

                                $request_atributo = $this->model->insertAtributo($strAtributo,$intIdCategoria,$intIdSubcategoria,$strPrice);
                                $option = 1;
                            }
                        }else{
                            //Actualizar
                            if($_SESSION['permisosMod']['u']){

                                $request_atributo = $this->model->updateAtributo($intIdAtributo, $strAtributo,$intIdCategoria,$intIdSubcategoria,$strPrice);
                                $option = 2;
                            }
                        }

                        if($request_atributo > 0 )
                        {
                            if($option == 1)
                            {
                                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                            }else{
                                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                            }
                        }else if($request_atributo == 'exist'){
                            
                            $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe.');
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
                die();
            }	
		}

        public function getAtributos(){
			if($_SESSION['permisosMod']['r']){

                $arrData = $this->model->selectAtributos();
				for ($i=0; $i < count($arrData); $i++) {
	
					$btnEdit = '';
					$btnDelete = '';
	
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditInfo(this,'.$arrData[$i]['idattribute'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelInfo('.$arrData[$i]['idattribute'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelete.'</div>';
					$arrData[$i]['price'] = MS.number_format($arrData[$i]['price'],0,DEC,MIL);
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        public function getAtributo($idAtributo){
			if($_SESSION['permisosMod']['r']){
				$intIdAtributo= intval($idAtributo);
				if($intIdAtributo > 0){
					$arrData = $this->model->selectAtributo($intIdAtributo);
					if(empty($arrData)){
					
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
                        //$arrData['url_portada'] = media().'/images/uploads/'.$arrData['image'];
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

        public function delAtributo(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){

					$intIdAtributo = intval($_POST['idatributo']);

					$requestDelete = $this->model->deleteAtributo($intIdAtributo);
					if($requestDelete == 'ok'){
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
    
?>