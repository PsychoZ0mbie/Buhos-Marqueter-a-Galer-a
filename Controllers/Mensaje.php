<?php
    class Mensaje extends Controllers{
        public function __construct(){
            session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			parent::__construct();
        }

        public function Mensaje(){
            if($_SESSION['userData']['roleid'] != 1){
				header('Location: '.base_url().'/logout');
			}
            $data['page_tag'] = "Mensaje";
            $data['page_title'] = "Mensaje";
            $data['page_name'] = "mensaje";
            $this->views->getView($this,"mensajes",$data);
        }

        public function getMensajes(){
            if($_SESSION['userData']['roleid'] == 1){
                $options="";
				if(isset($_POST['orderBy'])){
					$options =intval($_POST['orderBy']);
				}
				$arrData = $this->model->selectMensajes($options);
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            }else{
                header('Location: '.base_url().'/logout');
            }
            die();
        }
        public function getMensaje(){
            if($_POST){
                if($_SESSION['userData']['roleid'] == 1){
                    $id = intval($_POST['id']);
                    $arrData = $this->model->selectMensaje($id);
                    if(count($arrData)>0){
                        $arrResponse=array("status"=>true,"data"=>$arrData);
                    }else{
                        $arrResponse=array("status"=>false,"msg"=>"Ha ocurrido un problema, inténtelo más tarde");
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }else{
                    header('Location: '.base_url().'/logout');
                }
            }
            die();
        }
        public function delMensaje(){
            if($_POST){
                if($_SESSION['userData']['roleid'] == 1){

                    $id = intval($_POST['id']);
                    $request = $this->model->deleteMensaje($id);
                    
                    if($request=="ok"){
                        $arrResponse = array("status"=>true,"msg"=>"Se ha eliminado el mensaje.");
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