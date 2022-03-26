<?php
    class Pedidos extends controllers{
        public function __construct(){
            session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			parent::__construct();
			getPermisos(5);
        }

        public function Pedidos(){
            if(empty($_SESSION['permisosMod']['r'])){
                header("Location: ".base_url()."/dashboard");
                die();
            }
            $data['page_tag'] = "Pedidos";
            $data['page_title'] = "Pedidos";
            $data['page_name'] = "pedidos";
            $data['page_functions'] = "functions_pedidos.js"; 
            $this->views->getView($this,"pedidos",$data);
        }

        public function getPedidos(){
            if($_SESSION['permisosMod']['r']){
                $idrol = $_SESSION['userData']['idrole'];
                $idpersona = $_SESSION['userData']['idperson'];
                $arrData = $this->model->selectPedidos($idpersona,$idrol);
                for ($i=0; $i < count($arrData); $i++) { 
					$btnView = "";
					$btnEdit = "";
					$btnDelete = "";

                    if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm " onClick="fntViewInfo('.$arrData[$i]['idorderdata'].','.$arrData[$i]['personid'].')" title="Ver"><i class="far fa-eye"></i></button>';
					}else{
						$btnView = "";
					}

					if($_SESSION['permisosMod']['u'] && $_SESSION['userData']['idrole']==1){
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditInfo('.$arrData[$i]['idorderdata'].','.$arrData[$i]['personid'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}else{
						$btnEdit = "";
					}
                    if($_SESSION['permisosMod']['d'] && $_SESSION['userData']['idrole']==1){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelInfo('.$arrData[$i]['idorderdata'].','.$arrData[$i]['personid'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
					}else{
						$btnDelete = "";
					}

                    $arrData[$i]['price'] = MS.number_format($arrData[$i]['price'],0,DEC,MIL);
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function getPedido(){
            if($_POST){
                $idpedido = intval($_POST['idpedido']);
                $idpersona = intval($_POST['idpersona']);
                $arrEstado = array("Pendiente","En proceso","Terminado","Enviado");
                $arrData = $this->model->selectPedido($idpedido,$idpersona);
                $arrData['price'] = MS.number_format( $arrData['price'],0,DEC,MIL);
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
                if($_SESSION['permisosMod']['u']){
                    $idpedido = intval($_POST['idpedido']);
                    $idpersona = intval($_POST['idpersona']);
                    $estado = strClean($_POST['estado']);

                    $request = $this->model->updatePedido($idpedido,$idpersona,$estado);
                    if($request>0){
                        $arrResponse = array("status"=>true,"msg"=>"Se ha actualizado el pedido.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"No se ha podido actualizar, inténtelo más tarde");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

        public function getPedidoDetalle(){
            if($_POST){
                if($_SESSION['permisosMod']['r']){
                    $idpedido = intval($_POST['idpedido']);
                    $idpersona = intval($_POST['idpersona']);
                    $arrOrden = $this->model->selectPedido($idpedido,$idpersona);
                    $arrOrdenDetalle = $this->model->selectPedidoDetalle($idpedido,$idpersona);
                    $subtotal ="";

                    if(!empty($arrOrden)){
                        $arrOrden['price'] = MS.number_format($arrOrden['price'],0,DEC,MIL);
                        for ($i=0; $i < count($arrOrdenDetalle); $i++) { 
                            $arrOrdenDetalle[$i]['total'] = $arrOrdenDetalle[$i]['price'] * $arrOrdenDetalle[$i]['quantity'];
                            $arrOrdenDetalle[$i]['total'] = MS.number_format( $arrOrdenDetalle[$i]['total'],0,DEC,MIL);
                            $arrOrdenDetalle[$i]['price'] = MS.number_format($arrOrdenDetalle[$i]['price'],0,DEC,MIL);
                        }
                        $arrResponse = array("status"=>true,"orden"=>$arrOrden,"detalle"=>$arrOrdenDetalle);
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"No existe el pedido o ha ocurrido un error.");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
        }

        public function delPedido(){
            if($_POST){
                if($_SESSION['permisosMod']['d']){
                    $idpedido = intval($_POST['idorden']);
                    $idpersona = intval($_POST['idpersona']);

                    $request = $this->model->deletePedido($idpedido,$idpersona);
                    if($request=="ok"){
                        $arrResponse = array("status"=>true,"msg"=>"Se ha eliminado el pedido.");
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"No se ha podido eliminar, inténtelo más tarde");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                
            }
            die();
        }
    }
?>