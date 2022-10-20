<?php
    class Dashboard extends Controllers{
        public function __construct(){
            session_start();
            if(empty($_SESSION['login'])){
                header("location: ".base_url());
                die();
            }
            parent::__construct();
            getPermits(1);
        }

        public function dashboard(){
            if($_SESSION['permitsModule']['r']){
                $idUser = $_SESSION['userData']['roleid'] != 1 ? $_SESSION['idUser'] : "";

                $data['totalUsers'] = $this->model->getTotalUsers();
                $data['totalCustomers'] = $this->model->getTotalCustomers();
                $data['totalOrders'] = $this->model->getTotalOrders($idUser);
                $data['totalSales'] = $this->model->getTotalSales();
                $data['orders'] = $this->model->getLastOrders($idUser);
                $data['products'] = $this->model->getLastProducts();
                $data['page_tag'] = "Dashboard";
                $data['page_title'] = "Dashboard";
                $data['page_name'] = "dashboard";
                $data['app'] = "dashboard.js";
                $year = date('Y');
                $month = date('m');
                $data['salesMonth'] = $this->model->getSalesMonth($year,$month);
                $data['salesYear'] = $this->model->getSalesYear($year);
                //dep($data['salesMonth']);
                $this->views->getView($this,"dashboard",$data);
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function getSalesMonth(){
            if($_POST){
                $arrDate = explode(" - ",$_POST['date']);
                $month = $arrDate[0];
                $year = $arrDate[1];
                $request = $this->model->getSalesMonth($year,$month);
                $request['chart'] = "salespermonth";
                $script = getFile("Template/Chart/chart",$request);
                echo json_encode($script,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getSalesYear(){
            if($_POST){
                if(empty($_POST['date'])){
                    $arrResponse=array("status"=>false,"msg"=>"Error de datos");
                }else{
                    //$year = intval($_POST['date']);
                    $strYear = strval($_POST['date']);
                    if(strlen($strYear)>4){
                        $arrResponse=array("status"=>false,"msg"=>"La fecha es incorrecta."); 
                    }else{
                        $year = intval($_POST['date']);
                        $request = $this->model->getSalesYear($year);
                        $request['chart'] = "salesperyear";
                        $script = getFile("Template/Chart/chart",$request);
                        $arrResponse=array("status"=>true,"script"=>$script); 
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>