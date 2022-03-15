<?php
    
    require_once("Models/TProducto.php");
    require_once("Models/TCategorias.php");
    Class Catalogo extends Controllers{
        use TProducto, TCategorias;
        public function __construct(){
            parent::__construct();
            session_start();
        }
        
        /******************************Marquetería************************************/
        public function Marqueteria($params){

            $params = strClean($params);
            $ruta = ucwords(str_replace("-"," ",$params));

            $data['productC'] = $this->getProductosCategoriasT(1,$params);
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

            $data['productC'] = $this->getProductosCategoriasT(2,$params);
            $data['categoria'] = $this->getCategoriaT(2);
            $data['subcategoria'] = $this->getSubcategoriaT(2);
            $data['tecnicas'] = $this->getTecnicasT(2);
            $data['page_tag'] = "Galería | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Galería | ".NOMBRE_EMPRESA;
			$data['page_name'] = "galeria";
			$this->views->getView($this,"categoria",$data);
        }

        public function Producto($params){
            
            $params = strClean($params);
            $ruta = ucwords(str_replace("-"," ",$params));

            $data['product'] = $this->getProductosViewT($params);
            $data['atributos'] = $this->getProductosAtt($data['product'][0]['subtopicid']);
            $data['categoria'] = $this->getCategoriaT(2);
            $data['subcategoria'] = $this->getSubcategoriaT(2);
            $data['productsAl'] = $this->getProductosAlT($data['product'][0]['topicid']);
            $data['page_tag'] = "Galería | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Galería | ".NOMBRE_EMPRESA;
			$data['page_name'] = "galeria";
			$this->views->getView($this,"producto",$data);
        }
        public function Carrito(){
            
            $data['page_tag'] = "Carrito | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Carrito | ".NOMBRE_EMPRESA;
			$data['page_name'] = "carrito";
			$this->views->getView($this,"carrito",$data);
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
                    if(!isset($arrInfoProducto['atributo'])){
                        $arrInfoProducto['atributo']="";
                    }
                    if(!empty($arrInfoProducto)){
                        $arrProducto = array("idproducto"=>$idProducto,
                                            "idatributo" =>$intAtributo,
                                            "nombre" =>$arrInfoProducto['title'], 
                                            "precio"=>$intPrice,
                                            "cantidad" =>$intCant,
                                            "largo"=>$intLargo,
                                            "ancho"=>$intAncho,
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
    }
?>