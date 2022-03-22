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
			getPermisos(3);
        }

        public function Mensaje(){
            if(empty($_SESSION['permisosMod']['r'])){
                header("Location: ".base_url()."/dashboard");
                die();
            }
            $data['page_tag'] = "Mensaje";
            $data['page_title'] = "Mensaje";
            $data['page_name'] = "mensaje";
            $data['page_functions'] = "functions_mensajes.js"; 
            $this->views->getView($this,"mensajes",$data);
        }

        public function getMensajes(){
            if($_SESSION['permisosMod']['r']){
                $arrData = $this->model->selectMensajes();
                for ($i=0; $i < count($arrData) ; $i++) { 
					$btnView = '';
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['id'].')" title="Ver mensaje"><i class="far fa-eye"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getMensaje($id){
            if($_SESSION['permisosMod']['r']){
                $arrData = $this->model->selectMensaje($id);
                if(count($arrData)>0){
                    $arrResponse=array("status"=>true,"data"=>$arrData);
                }else{
                    $arrResponse=array("status"=>false,"msg"=>"Ha ocurrido un problema, inténtelo más tarde");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>