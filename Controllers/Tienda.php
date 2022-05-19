<?php
    
    require_once("Models/TProducto.php");
    require_once("Models/TCategorias.php");
    require_once("Models/TClientes.php");
    require_once("Models/LoginModel.php");

    Class Tienda extends Controllers{
        use TProducto, TCategorias,TClientes;
        private $login;
        private $mano_obra;
        public function __construct(){
            parent::__construct();
            session_start();
            $this->login = new LoginModel();
            $this->mano_obra= 1.05;
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
            $data['page_name'] = "procesarpedido";
            $this->views->getView($this,"procesarpedido",$data);
        }
        /******************************Métodos de paginas************************************/
        /******************************Marquetería************************************/
        public function getMuestras($params){
            $params = strClean($params);
            $params = str_replace(" ","",$params);
            $tipo = intval($params);
            $html="";
            $request = $this->getMolduras($tipo);
            for ($i=0; $i < count($request) ; $i++) { 
                $idproduct = openssl_encrypt($request[$i]['idproduct'], ENCRIPTADO,KEY);
                $html.='
                    <div class="measures__item" id="'.$idproduct.'" data-frame="'.$request[$i]['url'][1].'" data-border="'.$request[$i]['waste'].'" title="'.$request[$i]['title'].'">
                        <img src="'.$request[$i]['url'][0].'" alt="">
                    </div>
                ';
            }
            $arrResponse = array("status"=>true,"msg"=>"Molduras recuperadas","html"=>$html);
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getMuestrasTipo($params){
            $params = strClean($params);
            $params = str_replace(" ","",$params);
            $tipo = intval($params);
            $html="";
            $request = $this->getMoldurasTipo($tipo);
            for ($i=0; $i < count($request) ; $i++) { 
                $idproduct = openssl_encrypt($request[$i]['idproduct'], ENCRIPTADO,KEY);
                $html.='
                    <div class="measures__item" id="'.$idproduct.'" data-frame="'.$request[$i]['url'][1].'" data-border="'.$request[$i]['waste'].'" title="'.$request[$i]['title'].'">
                        <img src="'.$request[$i]['url'][0].'" alt="">
                    </div>
                ';
            }
            $arrResponse = array("status"=>true,"msg"=>"Molduras recuperadas","html"=>$html);
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
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

                $intTriplex = 13.5;
                $intPassepartout = 10;
                $intDobleMarco = 114;
                $intBocel = 40;
                $intVidrio = 9;
                //$intBastidor = 133;

                $id = openssl_decrypt($_POST['id'],ENCRIPTADO,KEY);
                $intHeight = floatval($_POST['height']);
                $intWidth = floatval($_POST['width']);
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
                
                $resultado = ($resultado * $request['price'])+$area+$borde+$vidrio;
                $resultado = $resultado *$this->mano_obra;
                echo json_encode(intval($resultado),JSON_UNESCAPED_UNICODE);
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
                        $intId = openssl_decrypt($_POST['intId'],ENCRIPTADO,KEY);
                        $intHeight = floatval($_POST['intHeight']);
                        $intWidth = floatval($_POST['intWidth']);
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

                            $triplexPrecio = 13.5;
                            $passepartoutPrecio = 10;
                            $dobleMarcoPrecio = 114;
                            $bocelPrecio = 40;
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
                            $precioMarco = (($perimetro*$precio) +$vidrio+$borde+$margin);
                            $precioMarco = $precioMarco*$this->mano_obra;

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
                        "titulo" => $requestCuadro['title'],
                        "autor" => $requestCuadro['author'],
                        "dimensiones" =>$requestCuadro['height']."cm X".$requestCuadro['width']."cm",
                        "tecnica"=>$requestCuadro['tecnica'],
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
        /******************************Galería************************************/
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
            if(count($request)>0){
                $html="";
                for ($i=0; $i < count($request); $i++) {
                    $route=base_url()."/tienda/producto/".$request[$i]['route'];
                    $price=formatNum($request[$i]['price']);
                    $html.='
                    <div class="card ms-1 mb-3 me-1" style="width: 18rem;" data-title="'.$request[$i]['title'].'" data-author="'.$request[$i]['author'].'">
                        <a href="'.$route.'" ><img src="'.$request[$i]['url'].'" class="card-img-top " alt="'.$request[$i]['author'].'"></a>
                        <div class="card-body text-center tex">
                            <a class="text__color text-decoration-none" href="'.$route.'" ><h5 class="card-title">'.$request[$i]['title'].'</h5></a>
                            <p class="card-text m-0">'.$request[$i]['height'].'cm x '.$request[$i]['width'].'cm</p>
                            <p class="card-text text-secondary">'.$request[$i]['tecnica'].'</p>
                            <p class="card-text text-secondary">Artista - '.$request[$i]['author'].'</p>
                            <p class="card-text">'.$price.'</p>
                            <a href="'.$route.'" class="btn_content"><i class="fas fa-shopping-cart"></i> Agregar</a>
                        </div>
                    </div>
                    ';
                }
                $arrResponse = array("status"=>true,"html"=>$html);
            }else{
                $arrResponse = array("status"=>false,"msg"=>"No hay productos");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getCuadrosAl(){
            //$autor = strClean($_POST['autor']);
            $request = $this->getObrasAl();
            if(count($request)>0){
                $html="";
                for ($i=0; $i < count($request); $i++) {
                    $route=base_url()."/tienda/producto/".$request[$i]['route'];
                    $price=formatNum($request[$i]['price']);
                    $html.='
                    <div class="card ms-1 mb-3 me-1" style="width: 18rem;" data-title="'.$request[$i]['title'].'" data-author="'.$request[$i]['author'].'">
                        <a href="'.$route.'" ><img src="'.$request[$i]['url'].'" class="card-img-top " alt="'.$request[$i]['author'].'"></a>
                        <div class="card-body text-center tex">
                            <a class="text__color text-decoration-none" href="'.$route.'" ><h5 class="card-title">'.$request[$i]['title'].'</h5></a>
                            <p class="card-text m-0">'.$request[$i]['height'].'cm x '.$request[$i]['width'].'cm</p>
                            <p class="card-text text-secondary">'.$request[$i]['tecnica'].'</p>
                            <p class="card-text text-secondary">Artista - '.$request[$i]['author'].'</p>
                            <p class="card-text">'.$price.'</p>
                            <a href="'.$route.'" class="btn_content"><i class="fas fa-shopping-cart"></i> Agregar</a>
                        </div>
                    </div>
                    ';
                }
                $arrResponse = array("status"=>true,"html"=>$html);
            }else{
                $arrResponse = array("status"=>false,"msg"=>"No hay productos");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        /******************************Carrito************************************/
        public function carritoInfo(){
            $cantidad=0;
            if(isset($_SESSION['arrCarrito']) && !empty($_SESSION['arrCarrito'])){
                $html="";
                $arrCarrito = $_SESSION['arrCarrito'];
                $resumen = 0;
                for ($i=0; $i < count($arrCarrito) ; $i++) { 
                    $subtotal = $arrCarrito[$i]['precio'] * $arrCarrito[$i]['cantidad'];
                    $resumen += $subtotal;
                    $cantidad+=$arrCarrito[$i]['cantidad'];
                    $precio = formatNum($arrCarrito[$i]['precio']);
                    
                    $id = openssl_encrypt($arrCarrito[$i]['idproducto'],ENCRIPTADO,KEY);
                    if($arrCarrito[$i]['idcategoria'] == 2){
                        $html.= '
                        <tr id="'.$id.'" idc="'.$arrCarrito[$i]['idcategoria'].'">
                            <td class="position-relative">
                                <span class="cursor__pointer btn_content position-absolute top-0 start-0 pt-1 pb-1 pe-2 ps-2 mt-1 rounded-circle btnDelete" title="Eliminar" name="eliminar">x</span>
                                <img src="'.$arrCarrito[$i]['url'].'" class="mb-2" style="height:100px; width:100px;">
                                <p class="m-0 text-secondary"><strong>Título: </strong>'.$arrCarrito[$i]['titulo'].'</p>
                                <p class="m-0 text-secondary"><strong>Dimensiones: </strong>'.$arrCarrito[$i]['dimensiones'].'</p>
                                <p class="m-0 text-secondary"><strong>Técnica: </strong>'.$arrCarrito[$i]['tecnica'].'</p>
                                <p class="m-0 text-secondary"><strong>Autor: </strong>'.$arrCarrito[$i]['autor'].'</p>
                            </td>
                            <td>1</td>
                            <td>'.$precio.'</td>
                            <td>'.$precio.'</td>
                        </tr>
                        ';
                    }else if($arrCarrito[$i]['idcategoria'] == 1){
                        $precioTotal = $arrCarrito[$i]['cantidad']*$arrCarrito[$i]['precio'];
                        $precioTotal = formatNum($precioTotal);
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
                            <td><input  type="number" class="text-center w-50" value="'.$arrCarrito[$i]['cantidad'].'" min="1" name="actualizar"></td>
                            <td>'.$precio.'</td>
                            <td>'.$precioTotal.'</td>
                        </tr>
                        ';
                    }
                }
                $arrResponse = array("status"=>true,"msg"=>"Hay productos","html"=>$html,"resumen"=>formatNum($resumen),"cantidad"=>$cantidad);
            }else{
                $arrResponse = array("status"=>false,"msg"=>"No hay productos","cantidad"=>$cantidad);
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
        public function actualizarCarrito(){
            if($_POST){
                $id = openssl_decrypt($_POST['id'],ENCRIPTADO,KEY);
                //$idCategoria = intval($_POST['idCategoria']);
                $tipoMargen = strClean($_POST['tipoMargen']);
                $tipoBorde = strClean($_POST['tipoBorde']);
                $tipoVidrio = strClean($_POST['tipoVidrio']);
                $margen = strClean($_POST['margen']);
                $medidasImagen = strClean($_POST['medidasImagen']);
                $medidasMarco = strClean($_POST['medidasMarco']);
                $actualizarCant = intval($_POST['cantidad']);
                
                if(is_numeric($id)){
                    if($actualizarCant > 0){
                        $resumen=0;
                        $cantidad=0;
                        $precioTotal=0;
                        $arrCarrito = $_SESSION['arrCarrito'];
                        for ($i=0; $i < count($arrCarrito) ; $i++) { 
                            if($arrCarrito[$i]['idproducto'] == $id && $arrCarrito[$i]['tipoMargen'] == $tipoMargen 
                            && $arrCarrito[$i]['tipoBorde'] == $tipoBorde
                            && $arrCarrito[$i]['tipoVidrio'] == $tipoVidrio && $arrCarrito[$i]['margen'] == $margen 
                            && $arrCarrito[$i]['medidasImagen'] == $medidasImagen && $arrCarrito[$i]['medidasMarco'] == $medidasMarco){
                                $arrCarrito[$i]['cantidad'] = $actualizarCant;
                                $precioTotal = $actualizarCant*$arrCarrito[$i]['precio'];
                                break;
                            }
                        }
                        $_SESSION['arrCarrito'] = $arrCarrito;
                        foreach ($_SESSION['arrCarrito'] as $key) {
                            $cantidad += $key['cantidad'];
                            $resumen += $key['cantidad'] * $key['precio'];
                        } 
                        $resumen = formatNum($resumen);
                        $precioTotal = formatNum($precioTotal);
                        $arrResponse = array("status"=>true,"msg"=>"Producto actualizado","resumen"=>$resumen,"cantidad"=>$cantidad,"total"=>$precioTotal);
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"La cantidad debe ser mayor a cero, inténtelo de nuevo.");
                    }
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"Ha ocurrido un problema, inténtelo de nuevo.");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function totalCarrito(){
            if(isset($_SESSION['arrCarrito']) && !empty($_SESSION['arrCarrito'])){
                $resumen=0;
                for ($i=0; $i < count($_SESSION['arrCarrito']) ; $i++) { 
                    $resumen += $_SESSION['arrCarrito'][$i]['cantidad'] * $_SESSION['arrCarrito'][$i]['precio'];
                }
                $resumen = formatNum($resumen);
                echo json_encode($resumen,JSON_UNESCAPED_UNICODE);
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
        /******************************Pedidos************************************/
        public function getSelectDepartamentos(){
			$htmlDepartamento="";
			$htmlCiudad="";
			$arrDepartment = $this->selectDepartamento();
			if(count($arrDepartment) > 0){
				for ($i=0; $i < count($arrDepartment) ; $i++) { 
					$htmlDepartamento .= '<option value="'.$arrDepartment[$i]['iddepartment'].'">'.$arrDepartment[$i]['department'].'</option>';
				}
			}
			$arrResponse = array("department" =>$htmlDepartamento);
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		public function getSelectCity($department){
			$htmlCiudad="";
			$arrData = $this->selectCiudad($department);
			if(count($arrData)>0){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlCiudad .= '<option value="'.$arrData[$i]['idcity'].'" selected>'.$arrData[$i]['city'].'</option>';
				}
			}
			$arrResponse = array("html"=>$htmlCiudad);
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
        public function setPedido(){
            if($_POST){
                if(empty($_POST['txtNombreOrden']) || empty($_POST['txtApellidoOrden']) || empty($_POST['txtIdentificacion'])
                || empty($_POST['txtEmailOrden']) || empty($_POST['listDepartamento']) || empty($_POST['listCiudad'])
                || empty($_POST['txtDireccion']) || empty($_POST['txtTelefono'])){
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
                    $status = "Pendiente";
                    $intPrecio=0;

                    for ($i=0; $i < count($_SESSION['arrCarrito']) ; $i++) { 
                        $intPrecio += $_SESSION['arrCarrito'][$i]['cantidad'] * $_SESSION['arrCarrito'][$i]['precio'];
                    }

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

                        $arrPedido = array(
                            "idpedido"=>$request_pedido,
                            "idusuario"=>$idUser,
                            "productos"=>$_SESSION['arrCarrito']
                        );
                        
                        $request = $this->insertPedidoDetail($arrPedido);
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
                        $this->deleteDetalleTemp($idUser);
                        session_regenerate_id(true);
                    }else{
                        $arrResponse = array("status" =>false,"msg","No se ha podido realizar el pedido, inténtelo más tarde.");
                    }
                    
                }
                
            }else{
                $arrResponse = array("status" =>false,"msg","No se ha podido realizar el pedido, inténtelo más tarde.");
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
        /******************************Cuenta************************************/
		public function setCliente(){
			if($_POST){
				if(empty($_POST['txtNombreCliente']) || empty($_POST['txtApellidoCliente']) || empty($_POST['txtEmailCliente']) || empty($_POST['txtPasswordCliente'])){
                    $arrResponse=array("status" => false, "msg" => "Datos incorrectos");
                }else{
                    $strNombre = ucwords(strClean($_POST['txtNombreCliente']));
                    $strApellido = ucwords(strClean($_POST['txtApellidoCliente']));
                    $strEmail = strtolower(strClean($_POST['txtEmailCliente']));
                    $strPassword = hash("SHA256",$_POST['txtPasswordCliente']);
                    $strPicture = "avatar.png";
                    $rolid = 2;

                    $request = $this->registroCliente($strNombre,$strApellido,$strPicture,$strEmail,$strPassword,$rolid);
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
        public function resetPass(){
			if($_POST){
				if(empty($_POST['txtEmailRecovery'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos');
				}else{
					$token = token();
					$strEmail = strtolower(strClean($_POST['txtEmailRecovery']));
					$arrData = $this->login->getUserEmail($strEmail);
					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'El usuario no existe');
					}else{
						$idpersona = $arrData['idperson'];
						$nombreUsuario = $arrData['firstname'].' '.$arrData['lastname'];

						$url_recovery = base_url().'/cuenta/recuperar/'.$strEmail.'/'.$token;
						$requestUpdate = $this->login->setTokenUser($idpersona,$token);

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
					$arrResponseUser = $this->login->getUsuario($strEmail, $strToken);
					if(empty($arrResponseUser)){
						$arrResponse = array('status' => false,'msg'=>'Error de datos.');
					}else{
						$strPassword = hash("SHA256",$strPassword);
						$requestPass = $this->login->insertPassword($intIdpersona, $strPassword);

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