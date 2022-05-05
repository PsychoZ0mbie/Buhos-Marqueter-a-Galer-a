<?php
    
    require_once("Models/TProducto.php");
    require_once("Models/TCategorias.php");
    require_once("Models/TClientes.php");
    require_once("Models/LoginModel.php");

    Class Tienda extends Controllers{
        use TProducto, TCategorias,TClientes;
        public $login;
        public function __construct(){
            parent::__construct();
            session_start();
            $this->login = new LoginModel();
        }
        
        /******************************Paginas************************************/
        public function marqueteria(){
            $data['page_tag'] = "Marqueteria | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Marqueteria | ".NOMBRE_EMPRESA;
			$data['page_name'] = "marqueteria";
            //$data['molduras'] =$this->getMolduras();
			$this->views->getView($this,"marqueteria",$data);
        }
        public function Galeria(){
            /*$data['productC'] = $this->getProductosCategoriasT(2,$params,"");
            $data['categoria'] = $this->getCategoriaT(2);
            $data['subcategoria'] = $this->getSubcategoriaT(2);
            $data['tecnicas'] = $this->getTecnicasT(2);*/
            $data['page_tag'] = "Galería | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Galería | ".NOMBRE_EMPRESA;
			$data['page_name'] = "galeria";
			$this->views->getView($this,"galeria",$data);
        }
        public function producto($params){
            
            $params = strClean($params);
            $title = ucwords(str_replace("-"," ",$params));
            $producto = $this->getProducto($params);
            if($producto == "no existe"){
                header('Location: '.base_url().'/error');
				die();
            }
            /*$data['product'] = $this->getProductosViewT($params);
            $data['atributos'] = $this->getProductosAtt($data['product'][0]['subtopicid']);
            $data['categoria'] = $this->getCategoriaT(2);
            $data['subcategoria'] = $this->getSubcategoriaT(2);
            $data['productsAl'] = $this->getProductosAlT($data['product'][0]['topicid']);*/
            $data['product'] = $producto;
            $data['page_tag'] = $title." | ".NOMBRE_EMPRESA;
			$data['page_title'] = $title." | ".NOMBRE_EMPRESA;
			$data['page_name'] = "producto";
			$this->views->getView($this,"producto",$data);
        }
        public function Carrito(){            
            $data['page_tag'] = "Carrito | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Carrito | ".NOMBRE_EMPRESA;
			$data['page_name'] = "carrito";
			$this->views->getView($this,"carrito",$data);
        }

        /******************************Métodos de paginas************************************/
        public function getMuestras($params){
            $params = strClean($params);
            $params = str_replace(" ","",$params);
            $tipo = intval($params);
            $request = $this->getMolduras($tipo);
            echo json_encode($request,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getColor(){
            $request = $this->getColores();
            echo json_encode($request,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function calcularMarco(){
            //dep($_POST);
            if($_POST){

                $intTriplex = 17;
                $intPassepartout = 10;
                $intDobleMarco = 114;
                $intBocel = 30;
                $intVidrio = 9;

                $id = intval($_POST['id']);
                $intHeight = intval($_POST['height']);
                $intWidth = intval($_POST['width']);
                $intHeightMargin = 0;
                $intWidthMargin = 0;
                $intMargin = 0;
                $intType = 1;
                $resultado=0;
                $area=0;
                $borde=0;
                $vidrio=0;

                $request = $this->getMoldura($id);

                if(isset($_POST['type'])){
                    $intType = intval($_POST['type']);
                    if($intType == 2){
                        $intMargin = intval($_POST['margin']);
                        if($intMargin != 0){
                            $intMargin*=2;
                            $intHeightMargin = $intHeight+$intMargin;
                            $intWidthMargin = $intWidth+$intMargin;
                            $area = ($intHeightMargin * $intWidthMargin)*$intTriplex;
                            $resultado = (($intHeightMargin+$intWidthMargin)*2) + $request['waste'];
                        }else{
                            $resultado = (($intHeight+$intWidth)*2) + $request['waste'];
                        }
                    }else if($intType == 3){
                        $intMargin = intval($_POST['margin']);
                        if($intMargin != 0){
                            $intMargin*=2;
                            $intHeightMargin = $intHeight+$intMargin;
                            $intWidthMargin = $intWidth+$intMargin;
                            $area = ($intHeightMargin * $intWidthMargin)*$intPassepartout;
                            $resultado = (($intHeightMargin+$intWidthMargin)*2) + $request['waste'];
                        }else{
                            $resultado = (($intHeight+$intWidth)*2) + $request['waste'];
                        }
                    }else{
                        $resultado = (($intHeight+$intWidth)*2) + $request['waste'];
                    }

                    if(isset($_POST['border'])){
                        $intBorder = intval($_POST['border']);
                        if($intBorder == 2){
                            $borde = (($intHeight+$intWidth)*2)*$intBocel;
                        }else if($intBorder == 3){
                            $borde = (($intHeight+$intWidth)*2)*$intDobleMarco;
                        }
                    }

                }else{
                    $resultado = (($intHeight+$intWidth)*2) + $request['waste'];
                }

                if(isset($_POST['glass'])){
                    //dep($_POST);
                    $glass = intval($_POST['glass']);
                    if($glass == 2){
                        if(isset($_POST['margin'])){
                            $margin = intval($_POST['margin'])*2;
                            $height = $intHeight+$margin;
                            $width = $intWidth+$margin;
                            $vidrio = ($height*$width)*$intVidrio;
                        }else{
                            $vidrio = ($intHeight*$intWidth)*$intVidrio;
                        }
                    }
                }
                
                $resultado = $resultado * $request['price']+$area+$borde+$vidrio;
                echo json_encode($resultado,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function agregarCarrito(){
            //dep($_POST);
            if($_POST){
                //unset($_SESSION['arrCarrito']);exit;
                $intIdTopic = intval($_POST['intIdTopic']);
                $cantCarrito = 0;
                $arrCarrito = array();

                if($intIdTopic == 1){
                    if(empty($_POST['intId']) || empty($_POST['strMargin']) || empty($_POST['strBorder']) || empty($_POST['strGlass']) || 
                    empty($_POST['intHeight']) || empty($_POST['intWidth']) || $_POST['intMargin'] < 0 || empty($_POST['intAddCant'])
                    || empty($_POST['intMarginType']) || empty($_POST['intBorderType']) || empty($_POST['intGlassType']) || $_POST['intAddCant'] < 0){

                        $arrResponse = array("status" => false,"msg"=>"Error de datos");

                    }else{
                        $intId = intval($_POST['intId']);
                        $intHeight = intVal($_POST['intHeight']);
                        $intWidth = intval($_POST['intWidth']);
                        $intMargin = intval($_POST['intMargin']) * 2;
                        $intMarginType = intval($_POST['intMarginType']);
                        $intBorderType = intval($_POST['intBorderType']);
                        $intGlassType = intval($_POST['intGlassType']);
                        $intAddCant = intval($_POST['intAddCant']);

                        $strMargin = strClean($_POST['strMargin']);
                        $strBorder = strClean($_POST['strBorder']);
                        $strGlass = strClean($_POST['strGlass']);

                        $requestMoldura = $this->getMoldura($intId);
                        if(!empty($requestMoldura)){

                            $triplexPrecio = 17;
                            $passepartoutPrecio = 10;
                            $dobleMarcoPrecio = 114;
                            $bocelPrecio = 30;
                            $vidrioPrecio = 9;

                            $precio = $requestMoldura['price'];
                            $desperdicio = $requestMoldura['waste'];

                            $margin = 0;
                            $borde = 0;
                            $vidrio = 0;

                            $area = ($intWidth + $intMargin)*($intHeight + $intMargin);
                            $perimetro = (($intWidth + $intHeight + $intMargin+$intMargin)*2) + $desperdicio;

                            if($intMarginType == 2){
                                $margin = $area * $triplexPrecio;
                            }else if($intMarginType == 3){
                                $margin = $area * $passepartoutPrecio;
                            }

                            if($intBorderType == 2){
                                $borde = (($intHeight+$intWidth)*2) * $bocelPrecio;
                            }else if($intBorderType == 3){
                                $borde = (($intHeight+$intWidth)*2) * $dobleMarcoPrecio;
                            }

                            if($intGlassType == 2){
                                $vidrio = $area * $vidrioPrecio;
                            }
                            $precioMarco = ($perimetro*$precio) +$vidrio+$borde+$margin;

                            $arrMarco = array(
                                "idproducto"=>$intId,
                                "idcategoria"=>$intIdTopic,
                                "referenciaMoldura"=>$requestMoldura['title'],
                                "tipoMargen" => $strMargin,
                                "tipoBorde" => $strBorder,
                                "tipoVidrio" => $strGlass,
                                "margen" => ($intMargin/2)."cm",
                                "medidasImagen"=>$intHeight."cm X ".$intWidth."cm",
                                "medidasMarco"=>($intHeight+$intMargin)."cm X ".($intWidth+$intMargin)."cm",
                                "cantidad"=>$intAddCant,
                                "precio"=>$precioMarco                   
                            );

                            if(isset($_SESSION['arrCarrito'])){
                                $arrCarrito = $_SESSION['arrCarrito'];
                                $flag = true;
                                for ($i=0; $i < count($arrCarrito); $i++) { 
                                    if($arrCarrito[$i]['idproducto'] == $arrMarco['idproducto'] && $arrCarrito[$i]['referenciaMoldura'] == $arrMarco['referenciaMoldura']
                                    && $arrCarrito[$i]['tipoMargen'] == $arrMarco['tipoMargen'] && $arrCarrito[$i]['tipoBorde'] == $arrMarco['tipoBorde']
                                    && $arrCarrito[$i]['tipoVidrio'] == $arrMarco['tipoVidrio'] && $arrCarrito[$i]['margen'] == $arrMarco['margen'] 
                                    && $arrCarrito[$i]['medidasImagen'] == $arrMarco['medidasImagen'] && $arrCarrito[$i]['medidasMarco'] == $arrMarco['medidasMarco']){
                                        $arrCarrito[$i]['cantidad'] += $intAddCant;
                                        $flag = false;
                                    }
                                }

                                if($flag){
                                    array_push($arrCarrito,$arrMarco);
                                }

                                $_SESSION['arrCarrito'] = $arrCarrito;
                            }else{
                                array_push($arrCarrito,$arrMarco);
                                $_SESSION['arrCarrito'] = $arrCarrito;
                                
                            }
                            foreach ($_SESSION['arrCarrito'] as $cantidad) {
                                $cantCarrito += $cantidad['cantidad'];
                            }
                            //dep($_SESSION['arrCarrito']);
                        }
                        $arrResponse = array("status"=>true,"msg"=>"Producto agregado","cantidad"=>$cantCarrito);
                    }
                }else if($intIdTopic == 2){
                    $id = openssl_decrypt($_POST['id'],ENCRIPTADO,KEY);
                    $requestCuadro  = $this->getObra($id);
                    $arrCarrito=array();
                    $arrCuadro = array(
                        "idproducto"=> $requestCuadro['idproduct'],
                        "idcategoria"=>$intIdTopic,
                        "autor" => $requestCuadro['author'],
                        "dimensiones" =>$requestCuadro['height']."cm X".$requestCuadro['width']."cm",
                        "cantidad"=>1,
                        "url"=>$requestCuadro['url'],
                        "precio" =>$requestCuadro['price']
                    );
                    
                    if(isset($_SESSION['arrCarrito'])){
                        $arrCarrito = $_SESSION['arrCarrito'];
                        $flag = true;
                        for ($i=0; $i < count($arrCarrito) ; $i++) { 
                            if($arrCarrito[$i]['idproducto'] == $arrCuadro['idproducto']){
                                $flag =false;
                                break;
                            }
                        }
                        if($flag){
                            array_push($arrCarrito,$arrCuadro);
                            $arrResponse = array("status"=>true,"msg"=>"Producto agregado");
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"El producto ya ha sido agregado");
                        }
                        $_SESSION['arrCarrito'] = $arrCarrito;
                    }else{
                        array_push($arrCarrito,$arrCuadro);
                        $_SESSION['arrCarrito'] = $arrCarrito;
                        $arrResponse = array("status"=>true,"msg"=>"Producto agregado");
                    }
                    foreach ($_SESSION['arrCarrito'] as $cantidad) {
                        $cantCarrito += $cantidad['cantidad'];
                    }
                    $arrResponse['cantidad'] = $cantCarrito;

                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getCuadros(){
            $options=array();
            //dep($_POST);
            if(!empty($_POST['topic'])){
                $topic = intval($_POST['topic']);
                $options = array("topic",$topic);
            }else if(!empty($_POST['tech'])){
                $tech = intval($_POST['tech']);
                $options = array("tech",$tech);
            }else if(!empty($_POST['order'])){
                //$options="";
                $options = array(intval($_POST['order']));
            }
            
            $request = $this->getObras($options);
            echo json_encode($request,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getCuadrosAl(){
            $autor = strClean($_POST['autor']);
            $request = $this->getObrasAl($autor);
            echo json_encode($request,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function carritoInfo(){
            if(isset($_SESSION['arrCarrito']) && !empty($_SESSION['arrCarrito'])){
                $html="";
                $arrCarrito = $_SESSION['arrCarrito'];
                $resumen = 0;
                for ($i=0; $i < count($arrCarrito) ; $i++) { 
                    $subtotal = $arrCarrito[$i]['precio'] * $arrCarrito[$i]['cantidad'];
                    $resumen += $subtotal;
                    $precio = formatNum($arrCarrito[$i]['precio']);
                    $id = openssl_encrypt($arrCarrito[$i]['idproducto'],ENCRIPTADO,KEY);
                    if($arrCarrito[$i]['idcategoria'] == 2){
                        $html.= '
                        <tr id="'.$id.'" idc="'.$arrCarrito[$i]['idcategoria'].'">
                            <td class="position-relative">
                                <span class="cursor__pointer btn_content position-absolute top-0 start-0 pt-1 pb-1 pe-2 ps-2 mt-1 rounded-circle btnDelete" title="Eliminar" name="eliminar">x</span>
                                <img src="'.$arrCarrito[$i]['url'].'" class="mb-2" style="height:100px; width:100px;">
                                <p class="m-0 text-secondary"><strong>Autor: </strong>'.$arrCarrito[$i]['autor'].'</p>
                                <p class="m-0 text-secondary"><strong>Dimensiones: </strong>'.$arrCarrito[$i]['dimensiones'].'</p>
                            </td>
                            <td>1</td>
                            <td>'.$precio.'</td>
                            <td>'.$precio.'</td>
                        </tr>
                        ';
                    }else if($arrCarrito[$i]['idcategoria'] == 1){
                        $html.= '
                        <tr id="'.$id.'" idc="'.$arrCarrito[$i]['idcategoria'].'" tm="'.$arrCarrito[$i]['tipoMargen'].'" tb="'.$arrCarrito[$i]['tipoBorde'].'"
                        tv="'.$arrCarrito[$i]['tipoVidrio'].'" m="'.$arrCarrito[$i]['margen'].'" mi="'.$arrCarrito[$i]['medidasImagen'].'" mm="'.$arrCarrito[$i]['medidasMarco'].'"
                        >
                            <td class="position-relative">
                                <span class="cursor__pointer btn_content position-absolute top-0 start-0 pt-1 pb-1 pe-2 ps-2 mt-1 rounded-circle btnDelete" title="Eliminar" name="eliminar">x</span>
                                <p class="m-0 mt-4 text-secondary"><strong>Referencia: </strong>'.$arrCarrito[$i]['referenciaMoldura'].'</p>
                                <p class="m-0 text-secondary"><strong>Tipo de margen: </strong>'.$arrCarrito[$i]['tipoMargen'].'</p>
                                <p class="m-0 text-secondary"><strong>Tipo de borde: </strong>'.$arrCarrito[$i]['tipoBorde'].'</p>
                                <p class="m-0 text-secondary"><strong>Tipo de vidrio: </strong>'.$arrCarrito[$i]['tipoVidrio'].'</p>
                                <p class="m-0 text-secondary"><strong>Margen: </strong>'.$arrCarrito[$i]['margen'].'</p>
                                <p class="m-0 text-secondary"><strong>Medidas de la imágen: </strong>'.$arrCarrito[$i]['medidasImagen'].'</p>
                                <p class="m-0 text-secondary"><strong>Medidas del marco: </strong>'.$arrCarrito[$i]['medidasMarco'].'</p>
                            </td>
                            <td><input  type="number" id="addCant" class="text-center w-50" value="'.$arrCarrito[$i]['cantidad'].'" min="1"></td>
                            <td>'.$precio.'</td>
                            <td>'.$precio.'</td>
                        </tr>
                        ';
                    }
                }
                $arrResponse = array("status"=>true,"msg"=>"Hay productos","html"=>$html,"resumen"=>formatNum($resumen));
            }else{
                $arrResponse = array("status"=>false,"msg"=>"No hay productos");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function eliminarCarrito(){
            if($_POST){
                $id = openssl_decrypt($_POST['id'],ENCRIPTADO,KEY);
                $idCategoria = intval($_POST['idCategoria']);
                $tipoMargen = strClean($_POST['tipoMargen']);
                $tipoBorde = strClean($_POST['tipoBorde']);
                $tipoVidrio = strClean($_POST['tipoVidrio']);
                $margen = strClean($_POST['margen']);
                $medidasImagen = strClean($_POST['medidasImagen']);
                $medidasMarco = strClean($_POST['medidasMarco']);

                if(is_numeric($id)){
                    $resumen=0;
                    $cantidad=0;
                    $arrCarrito = $_SESSION['arrCarrito'];
                    for ($i=0; $i < count($arrCarrito) ; $i++) { 
                        if($idCategoria == 1){
                            if($arrCarrito[$i]['idproducto'] == $id && $arrCarrito[$i]['tipoMargen'] == $tipoMargen 
                            && $arrCarrito[$i]['tipoBorde'] == $tipoBorde
                            && $arrCarrito[$i]['tipoVidrio'] == $tipoVidrio && $arrCarrito[$i]['margen'] == $margen 
                            && $arrCarrito[$i]['medidasImagen'] == $medidasImagen && $arrCarrito[$i]['medidasMarco'] == $medidasMarco){
                                unset($arrCarrito[$i]);
                                break;
                            }
                        }else if($idCategoria == 2){
                            if($arrCarrito[$i]['idproducto'] == $id){
                                unset($arrCarrito[$i]);
                                break;
                            } 
                        }
                    }
                    sort($arrCarrito);
                    $_SESSION['arrCarrito'] = $arrCarrito;
                    foreach ($_SESSION['arrCarrito'] as $key) {
                        $cantidad += $key['cantidad'];
                        $resumen += $key['cantidad'] * $key['precio'];
                    } 
                    $arrResponse = array("status"=>true,"msg"=>"Producto eliminado","resumen"=>formatNum($resumen),"cantidad"=>$cantidad);
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"Ha ocurrido un problema, inténtelo de nuevo.");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        /*
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
        }*/
    }
?>