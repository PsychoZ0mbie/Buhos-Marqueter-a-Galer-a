<?php
    
    require_once("Models/EnmarcarTrait.php");
    class Enmarcar extends Controllers{
        use EnmarcarTrait;
        public function __construct(){
            session_start();
            parent::__construct();
        }

        public function enmarcar(){
            $company = getCompanyInfo();
            $data['page_tag'] = "Enmarcar |".$company['name'];
            $data['page_title'] = "Enmarcar |".$company['name'];
            $data['page_name'] = "enmarcar";
            $data['tipos'] = $this->selectTipos();
            $this->views->getView($this,"enmarcar",$data);
            
        }
        public function personalizar($params){
            $company = getCompanyInfo();
            $params = strClean($params);
            $request = $this->selectTipo($params);
            if(!empty($request)){
                $data['page_tag'] = 'Enmarcar '.$request['name'].' |'.$company['name'];
                $data['page_title'] = 'Enmarcar '.$request['name'].' |'.$company['name'];
                $data['page_name'] = "personalizar";
                $data['tipo'] = $request;
                $data['molduras'] = $this->getProducts();
                $data['colores'] = $this->selectColors();
                $data['app'] = "functions_personalizar.js";
                $this->views->getView($this,"personalizar",$data);
            }else{
                header("location: ".base_url()."/enmarcar");
            }
            
        }
        public function getProducts($option=null,$params=null){
            $html="";
            $request="";
            if($option == 1){
                $request = $this->searchT($params);
            }else if($option == 2){
                $request = $this->sortT($params);
            }else{
                $request = $this->selectProducts();
            }
            if(count($request)>0){
                for ($i=0; $i < count($request); $i++) { 

                    $type="";
                    $discount="";
                    $price = formatNum($request[$i]['price']);
                    $id = openssl_encrypt($request[$i]['id'],METHOD,KEY);
                    if($request[$i]['discount']>0){
                        $discount = '<span class="discount">'.$request[$i]['discount'].'%</span>';
                    }
                    if($request[$i]['type']==1){
                        $type='Moldura en madera';
                    }else{
                        $type='Moldura importada';
                    }
                    $html.='
                        <div class="col-4 col-lg-3 col-md-4 mb-3">
                            <div class="frame--item frame-main element--hover" data-id="'.$id.'" onclick="selectActive(this,`.frame-main`)">
                                '.$discount.'
                                <img src="'.$request[$i]['image'].'" alt="'.$type.'">
                            </div>
                        </div>
                    ';
                }
                $arrResponse = array("status"=>true,"data"=>$html);
            }else{
                $arrResponse = array("status"=>false,"data"=>$html);
            }
            
            return $arrResponse;
        }
        public function getProduct(){
            if($_POST){
                if(empty($_POST)){
                    $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                }else{
                    $id = intval(openssl_decrypt($_POST['id'],METHOD,KEY));
                    $request = $this->selectProduct($id);
                    if(!empty($request)){
                        $request['total'] = $this->calcularMarcoTotal();
                        $arrResponse = array("status"=>true,"data"=>$request);
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"No hay datos"); 
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function search($params){
            $search = strClean($params);
            $arrResponse = $this->getProducts(1,$params);
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function sort($params){
            $params = intval($params);
            $arrResponse = $this->getProducts(2,$params);
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function calcularMarco($altura,$ancho,$datos){
            $perimetro = ($altura+$ancho)*2+$datos['waste'];
            $total =0;
            
            if($datos['discount']>0){
                $total = ($datos['price'] - ($datos['price']*($datos['discount']/100)))*$perimetro;
            }else{
                $total = $datos['price']*$perimetro;
            }
            return $total;
        }
        public function calcularMarcoEstilos($estilo,$perimetro,$area){
            $material = $this->selectMaterials();
            $paspartu = $material[0]['price'];
            $hijillo = $material[1]['price'];
            $bocel = $material[2]['price'];
            $triplex = $material[5]['price'];
            $vidrio = $material[3]['price'];
            $total = 0;
            if($estilo == 1){
                $total = $area * $vidrio;
            }else if($estilo == 2){
                $total = ($area * $paspartu)+($perimetro*$bocel)+($area*$vidrio);
            }else if($estilo == 3){
                $total = ($area * $paspartu)+($area*$vidrio);
            }else if($estilo == 4){
                $total = ($area * $triplex)+($perimetro*$hijillo)+($area*$vidrio);
            }
            return $total;

        }
        public function calcularMarcoTotal(){
            if($_POST){
                $id = intval(openssl_decrypt($_POST['id'],METHOD,KEY));
                $request = $this->selectProduct($id);
                if(!empty($request)){

                    $margin = intval($_POST['margin'])*2;
                    $altura = floatval($_POST['height']) + $margin;
                    $ancho = floatval($_POST['width']) + $margin;
                    $estilo = intval($_POST['style']);
    
                    
                    $perimetro = ($altura+$ancho)*2;
                    $area = $altura*$ancho;
    
                    $marcoTotal = $this->calcularMarco($altura,$ancho,$request);
                    $marcoEstilos = $this->calcularMarcoEstilos($estilo,$perimetro,$area);
    
                    $total = (($marcoEstilos+$marcoTotal)*COMISION)+TASA;
                    $request['total'] = array("total"=>$total,"format"=>formatNum($total));
                    $arrResponse = array("status"=>true,"data"=>$request);
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"Datos no encontrados"); 
                }
                //$request['total'] = $this->calcularMarco(floatval($_POST['height']),floatval($_POST['width']),$id);
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
            
        }

    }
?>