<?php
    class Pedidos extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			
        }

        public function Pedidos(){
            $data['page_tag'] = "Pedidos";
            $data['page_title'] = "Pedidos";
            $data['page_name'] = "pedidos";
            $this->views->getView($this,"pedidos",$data);
        }

        public function getPedidos(){
            $admin=false;
            $idpersona = $_SESSION['idUser'];
            $idrol = $_SESSION['userData']['roleid'];
            if($_SESSION['userData']['roleid'] == 1){
                $admin =true;
            } 
            $options="";
            if(isset($_POST['orderBy'])){
                $options =intval($_POST['orderBy']);
            }
            $arrData = $this->model->selectPedidos($options,$idpersona,$idrol);
            $arrResponse = array("data"=>$arrData,"admin"=>$admin);
            //$_SESSION['idUser'] == 1 and $_SESSION['userData']['idrole'
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
        }

        public function getPedido(){
            if($_POST){

                $idpedido = intval($_POST['idpedido']);
                $idpersona = intval($_POST['idpersona']);
                $arrEstado = array("Pendiente","En proceso","Terminado","Enviado","Cancelado");

                $arrData = $this->model->selectPedido($idpedido,$idpersona);
                $arrData['price'] = formatNum($arrData['price']);
                $html="";
                for ($i=0; $i < count($arrEstado) ; $i++) { 
                    if($arrData['status'] == $arrEstado[$i]){
                        $html .='<option value="'.$i.'" selected>'.$arrEstado[$i].'</option>';
                    }else{
                        $html .='<option value="'.$i.'">'.$arrEstado[$i].'</option>';
                    }
                }
                $arrResponse = array("orden" => $arrData,"estado"=>$html);
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function updatePedido(){
            if($_POST){
                if($_SESSION['userData']['roleid'] == 1){
                    $idpedido = intval($_POST['idpedido']);
                    $idpersona = intval($_POST['idpersona']);
                    $estado = strClean($_POST['estado']);

                    $request = $this->model->updatePedido($idpedido,$idpersona,$estado);
                    if($request>0){
                        $arrResponse = array("status"=>true,"msg"=>"Se ha actualizado el pedido.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"No se ha podido actualizar, inténtelo más tarde");
                    }
                    sleep(3);
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }else{
                    header('Location: '.base_url().'/logout');
                }
            }
            die();
        }

        public function getPedidoDetalle(){
            if($_POST){
                $idpedido = intval($_POST['idpedido']);
                $idpersona = intval($_POST['idpersona']);
                $arrOrden = $this->model->selectPedido($idpedido,$idpersona);
                $arrOrdenDetalle = $this->model->selectPedidoDetalle($idpedido,$idpersona);
                $subtotal ="";

                if(!empty($arrOrden)){
                    for ($i=0; $i < count($arrOrdenDetalle); $i++) { 
                        $total = $arrOrdenDetalle[$i]['price'] * $arrOrdenDetalle[$i]['quantity'];
                        $arrOrdenDetalle[$i]['total'] = formatNum($total);
                        $arrOrdenDetalle[$i]['price'] = formatNum($arrOrdenDetalle[$i]['price']);
                    }
                    $arrOrden['price'] = formatNum($arrOrden['price']);
                    $arrResponse = array("status"=>true,"orden"=>$arrOrden,"detalle"=>$arrOrdenDetalle);
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"No existe el pedido o ha ocurrido un error.");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function delPedido(){
            if($_POST){
                if($_SESSION['userData']['roleid'] == 1){
                    $idpedido = intval($_POST['idpedido']);
                    $idpersona = intval($_POST['idpersona']);

                    $request = $this->model->deletePedido($idpedido,$idpersona);
                    if($request=="ok"){
                        $arrResponse = array("status"=>true,"msg"=>"Se ha eliminado el pedido.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"No se ha podido eliminar, inténtelo más tarde");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }else{
                    header('Location: '.base_url().'/logout');
                }
            }
            die();
        }
    }
?>