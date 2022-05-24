<?php 
    class Dashboard extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
        }

        public function dashboard(){
            if($_SESSION['userData']['roleid'] != 1){
				header('Location: '.base_url().'/logout');
			}
            
            $data['page_tag'] = "Dashboard";
			$data['page_title'] = "Dashboard";
			$data['page_name'] = "dashboard"; 
            $data['page_functions'] = "functions_dashboard.js"; 
            $data['pedidos'] = $this->model->selectPedidos();
            $data['clientes'] = $this->model->selectClientes();
            $data['mensajes'] = $this->model->selectMensajes();
            $data['ventas'] = $this->model->selectVentas();
            $data['molduras'] = $this->model->selectMolduras();
            $data['cuadros'] = $this->model->selectCuadros();


            $this->views->getView($this,"dashboard",$data);
        }

        public function getPedidos(){
            if($_SESSION['userData']['roleid'] != 1){
                header('Location: '.base_url().'/logout');
            }
            $arrData = $this->model->selPedidos();
            if(count($arrData)>0){
                $arrResponse = array("status"=>true,"orden"=>$arrData);
            }else{
                $arrResponse = array("status"=>false,"msg"=>"No existen pedidos");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>