<?php
    require_once("Libraries/Core/Mysql.php");
    trait EnmarcarTrait{
        private $con;
        private $intIdProduct;

        public function selectTipos(){
            $this->con = new Mysql();
            $sql = "SELECT * FROM moldingcategory WHERE status = 1 ORDER BY id ASC";       
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function selectTipo($route){
            $this->con = new Mysql();
            $sql = "SELECT * FROM moldingcategory WHERE status = 1 AND route = '$route'";
            $request = $this->con->select($sql);
            return $request;
        }
        public function selectProducts(){
            $this->con = new Mysql();
            $sql = "SELECT * FROM molding WHERE status = 1 AND type ORDER BY waste DESC";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 
                    $idProduct = $request[$i]['id'];
                    $sqlImg = "SELECT * FROM moldingimage WHERE moldingid = $idProduct";
                    $requestImg = $this->con->select_all($sqlImg);
                    if(count($requestImg)>0){
                        $request[$i]['image'] = media()."/images/uploads/".$requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            return $request;
        }
        public function selectProduct($id){
            $this->con = new Mysql();
            $this->intIdProduct = $id;
            $sql = "SELECT reference,frame,price,discount,waste FROM molding WHERE id = $this->intIdProduct AND status = 1";
            $request = $this->con->select($sql);
            if(!empty($request)){
                $sqlImg = "SELECT * FROM moldingimage WHERE moldingid = $this->intIdProduct";
                $requestImg = $this->con->select_all($sqlImg);
                if(count($requestImg)){
                    for ($i=0; $i < count($requestImg); $i++) { 
                        $request['image'][$i] = array("url"=>media()."/images/uploads/".$requestImg[$i]['name'],"name"=>$requestImg[$i]['name'],"rename"=>$requestImg[$i]['name']);
                    }
                }
            }
            return $request;
        }
        public function selectColors(){
            $this->con = new Mysql();
            $sql = "SELECT * FROM moldingcolor WHERE status = 1 ORDER BY name ASC";       
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function searchT($search){
            $this->con = new Mysql();
            $sql = "SELECT * FROM molding WHERE status = 1 AND reference LIKE '%$search%'";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 
                    $idProduct = $request[$i]['id'];
                    $sqlImg = "SELECT * FROM moldingimage WHERE moldingid = $idProduct";
                    $requestImg = $this->con->select_all($sqlImg);
                    if(count($requestImg)>0){
                        $request[$i]['image'] = media()."/images/uploads/".$requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            return $request;
        }
        public function sortT($sort){
            $this->con = new Mysql();
            $option=" ORDER BY waste DESC";
            if($sort == 2){
                $option = " AND type = 1 ORDER BY waste DESC"; 
            }else if( $sort == 3){
                $option = " AND type = 2 ORDER BY waste DESC"; 
            }
            $sql = "SELECT * FROM molding WHERE status = 1 $option";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 
                    $idProduct = $request[$i]['id'];
                    $sqlImg = "SELECT * FROM moldingimage WHERE moldingid = $idProduct";
                    $requestImg = $this->con->select_all($sqlImg);
                    if(count($requestImg)>0){
                        $request[$i]['image'] = media()."/images/uploads/".$requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            return $request;
        }
        public function selectMaterials(){
            $this->con = new Mysql();
            $sql = "SELECT * FROM moldingmaterial";       
            $request = $this->con->select_all($sql);
            return $request;
        }
    }
    
?>