<?php
    
    require_once("Models/TProducto.php");
    require_once("Models/TCategorias.php");
    require_once("Models/TClientes.php");
    require_once("Models/LoginModel.php");

    Class Catalogo extends Controllers{
        use TProducto, TCategorias,TClientes;
        public $login;
        public function __construct(){
            parent::__construct();
            session_start();
            $this->login = new LoginModel();
        }
        
        /******************************Marquetería************************************/
        public function Marqueteria($params){

            $params = strClean($params);
            $ruta = ucwords(str_replace("-"," ",$params));

            $data['productC'] = $this->getProductosCategoriasT(1,$params,"");
            $data['categoria'] = $this->getCategoriaT(1);
            $data['subcategoria'] = $this->getSubcategoriaT(1);
            $data['tecnicas'] = $this->getTecnicasT(1);
            $data['page_tag'] = "Marquetería | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Marquetería | ".NOMBRE_EMPRESA;
			$data['page_name'] = "marqueteria";
			$this->views->getView($this,"categoria",$data);
        }
        public function Galeria($params){

            $params = strClean($params);
            $ruta = ucwords(str_replace("-"," ",$params));

            $data['productC'] = $this->getProductosCategoriasT(2,$params,"");
            $data['categoria'] = $this->getCategoriaT(2);
            $data['subcategoria'] = $this->getSubcategoriaT(2);
            $data['tecnicas'] = $this->getTecnicasT(2);
            $data['page_tag'] = "Galería | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Galería | ".NOMBRE_EMPRESA;
			$data['page_name'] = "galeria";
			$this->views->getView($this,"categoria",$data);
        }

        public function Buscar(){
            $data['page_tag'] = "Buscar | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Buscar | ".NOMBRE_EMPRESA;
			$data['page_name'] = "buscar";
			$this->views->getView($this,"buscar",$data);
        }

        public function Producto($params){
            
            $params = strClean($params);
            $ruta = ucwords(str_replace("-"," ",$params));

            $data['product'] = $this->getProductosViewT($params);
            $data['atributos'] = $this->getProductosAtt($data['product'][0]['subtopicid']);
            $data['categoria'] = $this->getCategoriaT(2);
            $data['subcategoria'] = $this->getSubcategoriaT(2);
            $data['productsAl'] = $this->getProductosAlT($data['product'][0]['topicid']);
            $data['page_tag'] = "Marquetería | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Marquetería | ".NOMBRE_EMPRESA;
			$data['page_name'] = "marqueteria";
			$this->views->getView($this,"producto",$data);
        }
        public function Carrito(){
            
            $data['page_tag'] = "Carrito | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Carrito | ".NOMBRE_EMPRESA;
			$data['page_name'] = "carrito";
			$this->views->getView($this,"carrito",$data);
        }

        public function procesarPedido(){
            if(empty($_SESSION['arrCarrito'])){
                header('location: '.base_url());
                die();
            }
            if(isset($_SESSION['login'])){
                $this->setDetalleTemp();
            }
            $data['page_tag'] = "Procesar Pedido | ".NOMBRE_EMPRESA;
            $data['page_title'] = "Procesar Pedido | ".NOMBRE_EMPRESA;
            $data['page_name'] = "procesar pedido";
            $this->views->getView($this,"procesarpedido",$data);
        }

        public function addCarrito(){
            if($_POST){
                //unset($_SESSION['arrCarrito']);exit;
                $arrCarrito = array();
                $cantCarrito = 0;
                $idProducto = openssl_decrypt($_POST['idProduct'],ENCRIPTADO,KEY);
                $intPrice = intval($_POST['intPrice']);
                $intLargo = intVal($_POST['intLargo']);
                $intAncho = intval($_POST['intAncho']);
                $intCant = intval($_POST['intCant']);
                $intAtributo = intval($_POST['idAtributo']);
                
                if(is_numeric($idProducto) && is_numeric($intCant)){
                    $arrInfoProducto = $this->getProductInfo($idProducto,$intAtributo);
                    //dep($arrInfoProducto);exit;
                    if(!isset($arrInfoProducto['atributo'])){
                        $arrInfoProducto['atributo']="";
                    }
                    if($arrInfoProducto['subtopicid'] == 6){
                        $arrInfoProducto['subcategoria']="";
                    }
                    if(!empty($arrInfoProducto)){
                        $arrProducto = array("idproducto"=>$idProducto,
                                            "idatributo" =>$intAtributo,
                                            "idsubcategoria"=>$arrInfoProducto['subtopicid'],
                                            "nombre" =>$arrInfoProducto['title'], 
                                            "precio"=>$intPrice,
                                            "cantidad" =>$intCant,
                                            "largo"=>$intLargo,
                                            "ancho"=>$intAncho,
                                            "categoria"=>$arrInfoProducto['categoria'],
                                            "subcategoria"=>$arrInfoProducto['subcategoria'],
                                            "tipo" =>$arrInfoProducto['atributo'],
                                            "imagen" =>$arrInfoProducto['imagen']
                                            );

                        if(isset($_SESSION['arrCarrito'])){
                            $on =true;
                            $arrCarrito = $_SESSION['arrCarrito'];
                            for ($i=0 ; $i < count($arrCarrito)  ; $i++ ) { 
                                if($arrCarrito[$i]["idproducto"] == $idProducto && $arrCarrito[$i]["largo"] == $intLargo && $arrCarrito[$i]["ancho"] == $intAncho
                                && $arrCarrito[$i]["idatributo"] == $intAtributo){
                                    $arrCarrito[$i]["cantidad"] += $intCant;
                                    $on = false;
                                }
                            }
                            
                            if($on){
                                array_push($arrCarrito,$arrProducto);
                            }
                            $_SESSION['arrCarrito']=$arrCarrito;
                        }else{                            
                            array_push($arrCarrito,$arrProducto);
                            $_SESSION['arrCarrito'] = $arrCarrito;
                        }
                        foreach ($_SESSION['arrCarrito'] as $key) {
                            $cantCarrito += $key['cantidad'];
                        }
                        $html ="";
                        $arrResponse = array("status"=>true,"msg"=>"Se agregó al carrito","cantidad"=>$cantCarrito,"html"=>$html,"nombre"=>$arrProducto['nombre']);
                    }else{
                        $arrResponse = array("status"=>false,"El producto no existe");
                    }
                }else{
                    $arrResponse = array("status" => false,"msg"=>"Datos incorrectos");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                die();
            }
        }

        public function updateCarrito(){
            if($_POST){
                $idProducto = openssl_decrypt($_POST['idproducto'],ENCRIPTADO,KEY);
                $idAtributo = intval($_POST['idatributo']);
                $intLargo = intval($_POST['largo']);
                $intAncho = intval($_POST['ancho']);
                $intCant = intval($_POST['intCant']);
                $totalProducto =0;
                $total =0;
                $subtotal =0;

                if(is_numeric($idProducto) && is_numeric($idAtributo) && is_numeric($intLargo) && is_numeric($intAncho) && $intCant > 0){
                    $arrCarrito = $_SESSION['arrCarrito'];
                    for ($i=0 ; $i < count($arrCarrito)  ; $i++ ) {

                        if($arrCarrito[$i]["idproducto"] == $idProducto && $arrCarrito[$i]["idatributo"] ==$idAtributo 
                            && $arrCarrito[$i]["largo"] == $intLargo && $arrCarrito[$i]["ancho"] == $intAncho){
                            $arrCarrito[$i]["cantidad"] = $intCant;
                            $totalProducto = $intCant * $arrCarrito[$i]['precio'];
                            break;
                        }
                    }
                    $_SESSION['arrCarrito'] = $arrCarrito;
                    //dep($_SESSION['arrCarrito']);
                    foreach($_SESSION['arrCarrito'] as $key){
                        $subtotal += $key['cantidad'] * $key['precio'];
                    }
                    $arrResponse= array("status"=>true,
                                        "msg"=>"Cantidad actualizada",
                                        "totalproducto"=>MS.number_format($totalProducto,0,DEC,MIL),
                                        "subtotal"=>MS.number_format($subtotal,0,DEC,MIL)." ".MD,
                                        "envio"=>MS.number_format(ENVIO,0,DEC,MIL)." ".MD,
                                        "total"=>MS.number_format($subtotal+ENVIO,0,DEC,MIL)." ".MD);
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"Datos incorrectos");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function deleteCarrito(){
            if($_POST){
                $arrCarrito=array();
                $idProducto = openssl_decrypt($_POST['idproducto'],ENCRIPTADO,KEY);
                $idAtributo = intval($_POST['idatributo']);
                $intLargo = intval($_POST['largo']);
                $intAncho = intval($_POST['ancho']);
                $intCant = 0;
                $subtotal =0;
                $total = 0;

                if(is_numeric($idProducto) && is_numeric($idAtributo) && is_numeric($intLargo) && is_numeric($intAncho)){
                    $arrCarrito = $_SESSION['arrCarrito'];
                    for ($i=0; $i < count($arrCarrito) ; $i++) { 
                        if($arrCarrito[$i]["idproducto"] == $idProducto && $arrCarrito[$i]["idatributo"] ==$idAtributo 
                            && $arrCarrito[$i]["largo"] == $intLargo && $arrCarrito[$i]["ancho"] == $intAncho){
                                unset($arrCarrito[$i]);
                            }
                    }
                    sort($arrCarrito);
                    $_SESSION['arrCarrito'] = $arrCarrito;
                    foreach ($_SESSION['arrCarrito'] as $key) {
                        $intCant += $key['cantidad'];
                        $subtotal += $key['cantidad'] * $key['precio'];
                    }
                    $arrResponse = array("status"=>true,
                                        "msg"=>"Producto eliminado",
                                        "cantidad"=>$intCant,
                                        "subtotal"=>MS.number_format($subtotal,0,DEC,MIL)." ".MD,
                                        "total"=>MS.number_format($subtotal+ENVIO,0,DEC,MIL)." ".MD);
                }else{
                    $arrResponse=array("status"=>false,"msg"=>"Ha ocurrido un error, inténtelo de nuevo");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        
		public function setCliente(){
			if($_POST){
				if(empty($_POST['txtNombreCliente']) || empty($_POST['txtApellidoCliente']) || empty($_POST['txtEmailCliente']) || empty($_POST['txtPasswordCliente'])){
                    $arrResponse=array("status" => false, "msg" => "Datos incorrectos");
                }else{
                    $strNombre = ucwords(strClean($_POST['txtNombreCliente']));
                    $strApellido = ucwords(strClean($_POST['txtApellidoCliente']));
                    $strEmail = strtolower(strClean($_POST['txtEmailCliente']));
                    $strPassword = hash("SHA256",$_POST['txtPasswordCliente']);
                    $rolid = 2;

                    $request = $this->registroCliente($strNombre,$strApellido,$strEmail,$strPassword,$rolid);
                    if($request > 0){
                        
						$_SESSION['idUser'] = $request;
						$_SESSION['login'] = true;

						$arrData = $this->login->sessionLogin($_SESSION['idUser']);
						sessionUser($_SESSION['idUser']);

                        $arrResponse = array("status" => true,"msg"=>"Te has registrado exitosamente.");
                    }else if($request =="exist"){
                        $arrResponse = array("status" => false,"msg"=>"El usuario ya existe, por favor inicia sesión.");
                    }else{
                        $arrResponse = array("status" => false,"msg"=>"No es posible almacenar datos, inténtelo más tarde");

                    }

                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

			}
			die();
		}
        public function setDetalleTemp(){
            $idsession = session_id();
            $arrPedido = array("idcliente" =>$_SESSION['idUser'],
                                "idtransaccion" => $idsession,
                                "productos" => $_SESSION['arrCarrito']
                                );
            $this->insertDetalleTemp($arrPedido);
        }

        public function setPedido(){
            if($_POST){
                if(empty($_POST['txtNombreOrden']) || empty($_POST['txtApellidoOrden']) || empty($_POST['txtIdentificacion'])
                || empty($_POST['txtEmailOrden']) || empty($_POST['listDepartamento']) || empty($_POST['listCiudad'])
                || empty($_POST['txtDireccion']) || empty($_POST['txtTelefono']) || empty($_POST['txtPrecio'])){
                    $arrResponse = array("status"=>true,"msg"=>"Datos incorrectos");
                }else{


                    $idUser = intval($_SESSION['idUser']);
                    $strNombre = ucwords(strClean($_POST['txtNombreOrden']));
                    $strApellido = ucwords(strClean($_POST['txtApellidoOrden']));
                    $intIdentificacion = intval($_POST['txtIdentificacion']);
                    $strEmail = strtolower(strClean($_POST['txtEmailOrden']));
                    $intDepartamento = intval($_POST['listDepartamento']);
                    $intCiudad = intval($_POST['listCiudad']);
                    $strDireccion = strtolower(strClean($_POST['txtDireccion']));
                    $strComentario = strClean($_POST['txtComentario']);
                    $intTelefono = strClean($_POST['txtTelefono']);
                    $intPrecio = intval($_POST['txtPrecio']);
                    $status = "Pendiente";

                    $request_pedido = $this->insertPedido($idUser,
                                                    $strNombre,
                                                    $strApellido,
                                                    $intIdentificacion,
                                                    $strEmail,
                                                    $intDepartamento,
                                                    $intCiudad,
                                                    $strDireccion,
                                                    $strComentario,
                                                    $intTelefono,
                                                    $intPrecio,
                                                    $status
                                                    );
                    if($request_pedido>0){
                        foreach ($_SESSION['arrCarrito'] as $producto) {
                            $idUser = $_SESSION['idUser'];
                            $idproducto = $producto['idproducto'];
                            $nombre = $producto['nombre'];
                            $precio = $producto['precio'];
                            $cantidad = $producto['cantidad'];
                            $largo = $producto['largo'];
                            $ancho = $producto['ancho'];
                            $categoria = $producto['categoria'];
                            $subcategoria = $producto['subcategoria'];
                            $tipo = $producto['tipo'];

                            $request = $this->insertPedidoDetail($request_pedido,
                                                                $idUser,
                                                                $idproducto,
                                                                $nombre,
                                                                $precio,
                                                                $cantidad,
                                                                $largo,
                                                                $ancho,
                                                                $categoria,
                                                                $subcategoria,
                                                                $tipo);
                        }
                        $pedidoInfo = $this->getPedido($request_pedido);
                        $dataEmail = array('email_remitente' => EMAIL_REMITENTE, 
                                            'email_usuario'=>$pedidoInfo['orden']['email'], 
                                            'email_copia'=>EMAIL_COPIA,
                                            'asunto' =>'Se ha creado la orden No - '.$request_pedido,
                                            'pedido' =>$pedidoInfo);
                        $sendEmail = sendEmail($dataEmail, 'email_notificacion_orden');
                        $orden = openssl_encrypt($request_pedido,ENCRIPTADO,KEY);
                        $arrResponse = array("status"=>true,"orden"=>$orden,"msg"=>"Pedido realizado");
                        $_SESSION['ordendata'] = $arrResponse;
                        unset($_SESSION['arrCarrito']);
                        //session_regenerate_id(true);
                    }else{
                        $arrResponse = array("status" =>false,"msg","No se ha podido realizar el pedido");
                    }
                    
                }
                
            }else{
                $arrResponse = array("status" =>false,"msg","No se ha podido realizar el pedido");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function confirmarPedido(){
            if(empty($_SESSION['ordendata'])){
                header("location: ".base_url());
            }else{
                $dataorden = $_SESSION['ordendata'];
				$idpedido = openssl_decrypt($dataorden['orden'], ENCRIPTADO, KEY);
				$data['page_tag'] = "Confirmar Pedido";
				$data['page_title'] = "Confirmar Pedido";
				$data['page_name'] = "confirmarpedido";
				$data['orden'] = $idpedido;
				$this->views->getView($this,"confirmarpedido",$data);
            }
            unset($_SESSION['ordendata']);
        }

        public function getProductAtributo($idAtributo){
            $intIdAtributo= intval($idAtributo);
				if($intIdAtributo > 0){
					$arrData = $this->selectAtributo($intIdAtributo);
					if(empty($arrData)){
					
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
                        //$arrData['url_portada'] = media().'/images/uploads/'.$arrData['image'];
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
            die();
        }

        public function search(){
            if(empty($_REQUEST['s'])){
                header("Location: ".base_url());
            }else{
                $busqueda = strClean($_REQUEST['s']);
                $request = $this->getProductSearch($busqueda);
                
                $data['resultados'] = $request['total'];
                $data['productos'] = $request['productos'];

                $data['page_tag'] = "Buscar | ".NOMBRE_EMPRESA;
                $data['page_title'] = "Buscar | ".NOMBRE_EMPRESA;
                $data['page_name'] = "buscar";
                $this->views->getView($this,"buscar",$data);
            }
        }
    }
?>