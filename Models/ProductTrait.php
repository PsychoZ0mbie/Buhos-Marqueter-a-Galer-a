<?php
    require_once("Libraries/Core/Mysql.php");
    trait ProductTrait{
        private $con;
        private $intIdProduct;

        public function getProductsT($cant=""){
            if($cant !=""){
                $cant = " LIMIT $cant";
            }
            $this->con=new Mysql();
            $sql = "SELECT 
                p.idproduct,
                p.categoryid,
                p.subcategoryid,
                p.reference,
                p.name,
                p.description,
                p.price,
                p.discount,
                p.description,
                p.stock,
                p.status,
                p.route,
                c.idcategory,
                c.name as category,
                c.route as routec,
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND p.status = 1 AND p.stock > 0
            ORDER BY p.idproduct DESC $cant
            ";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 

                    $request[$i]['priceDiscount'] =  $request[$i]['price']-($request[$i]['price']*($request[$i]['discount']*0.01));
                    $request[$i]['price'] = $request[$i]['price'];

                    $idProduct = $request[$i]['idproduct'];
                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg =  $this->con->select_all($sqlImg);

                    if(count($requestImg)>0){
                        $request[$i]['url'] = media()."/images/uploads/".$requestImg[0]['name'];
                        $request[$i]['image'] = $requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            //dep($request);exit;
            return $request;
        }
        public function getProductsPageT(int $pageNow, int $sort){
            $this->con=new Mysql();
            $perPage = PERPAGE;
            $option ="ORDER BY p.idproduct DESC";
            if($sort == 2){
                $option = "ORDER BY p.price DESC";
            }else if($sort == 3){
                $option = "ORDER BY p.price ASC";
            }

            $totalProducts =$this->con->select("SELECT COUNT(*) AS total FROM product WHERE status = 1")['total'];
            $totalPages = ceil($totalProducts/$perPage);
            $start = ($pageNow - 1) * $perPage;
            $start = $start < 0 ? 0 : $start;
            $sql = "SELECT 
                p.idproduct,
                p.categoryid,
                p.subcategoryid,
                p.reference,
                p.name,
                p.description,
                p.price,
                p.discount,
                p.description,
                p.stock,
                p.status,
                p.route,
                c.idcategory,
                c.name as category,
                c.route as routec,
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND p.status = 1
            $option LIMIT $start,$perPage
            ";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 

                    $request[$i]['priceDiscount'] =  $request[$i]['price']-($request[$i]['price']*($request[$i]['discount']*0.01));
                    $request[$i]['price'] = $request[$i]['price'];

                    $idProduct = $request[$i]['idproduct'];
                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg =  $this->con->select_all($sqlImg);

                    if(count($requestImg)>0){
                        $request[$i]['url'] = media()."/images/uploads/".$requestImg[0]['name'];
                        $request[$i]['image'] = $requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            $array = array("productos"=>$request,"paginas"=>$totalPages);
            //dep($request);exit;
            return $array;

        }
        public function getProductsSearchT(int $pageNow, int $sort, string $search){
            $this->con=new Mysql();
            $perPage = PERPAGE;
            $option ="ORDER BY p.idproduct DESC";
            if($sort == 2){
                $option = "ORDER BY p.price DESC";
            }else if($sort == 3){
                $option = "ORDER BY p.price ASC";
            }
            $sqlTotal = "SELECT COUNT(*) AS total
                        FROM product p 
                        INNER JOIN category c, subcategory s
                        WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid 
                        AND p.subcategoryid = s.idsubcategory AND p.status = 1 
                        AND (p.name LIKE '%$search%' || c.name LIKE '%$search%' || s.name LIKE '%$search%')";
                        
            $totalProducts =$this->con->select($sqlTotal)['total'];
            $totalPages = ceil($totalProducts/$perPage);
            $start = ($pageNow - 1) * $perPage;
            $start = $start < 0 ? 0 : $start;
            $sql = "SELECT 
                p.idproduct,
                p.categoryid,
                p.subcategoryid,
                p.reference,
                p.name,
                p.description,
                p.price,
                p.discount,
                p.description,
                p.stock,
                p.status,
                p.route,
                c.idcategory,
                c.name as category,
                c.route as routec,
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid 
            AND p.subcategoryid = s.idsubcategory AND p.status = 1 
            AND (p.name LIKE '%$search%' || c.name LIKE '%$search%' || s.name LIKE '%$search%')
            $option LIMIT $start,$perPage
            ";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 

                    $request[$i]['priceDiscount'] =  $request[$i]['price']-($request[$i]['price']*($request[$i]['discount']*0.01));
                    $request[$i]['price'] = $request[$i]['price'];

                    $idProduct = $request[$i]['idproduct'];
                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg =  $this->con->select_all($sqlImg);

                    if(count($requestImg)>0){
                        $request[$i]['url'] = media()."/images/uploads/".$requestImg[0]['name'];
                        $request[$i]['image'] = $requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            if(empty($request)){
                $totalPages = 1;
            }
            $array = array("productos"=>$request,"paginas"=>$totalPages,"total"=>$totalProducts,"buscar"=>$search);
            //dep($request);exit;
            return $array;

        }
        public function getProductsRandT($cant){
            if($cant !=""){
                $cant = " LIMIT $cant";
            }
            $this->con=new Mysql();
            $sql = "SELECT 
                p.idproduct,
                p.categoryid,
                p.subcategoryid,
                p.reference,
                p.name,
                p.description,
                p.price,
                p.discount,
                p.description,
                p.stock,
                p.status,
                p.route,
                c.idcategory,
                c.name as category,
                c.route as routec,
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND p.status = 1
            ORDER BY RAND() $cant
            ";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 

                    $request[$i]['priceDiscount'] =  $request[$i]['price']-($request[$i]['price']*($request[$i]['discount']*0.01));
                    $request[$i]['price'] = $request[$i]['price'];
                    $request[$i]['favorite'] = 0;

                    $idProduct = $request[$i]['idproduct'];

                    if(isset($_SESSION['login'])){
                        $idUser = $_SESSION['idUser'];
                        $sqlFavorite = "SELECT * FROM wishlist WHERE productid = $idProduct AND personid = $idUser";
                        $requestFavorite = $this->con->select($sqlFavorite);
                        if(!empty($requestFavorite)){
                            $request[$i]['favorite'] = $requestFavorite['status'];
                        }
                    }
                    $sqlRate = "SELECT AVG(rate) as rate FROM productrate WHERE productid = $idProduct";
                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg =  $this->con->select_all($sqlImg);
                    $requestRate =  $this->con->select($sqlRate);
                    $request[$i]['rate'] = $requestRate['rate'];

                    if(count($requestImg)>0){
                        $request[$i]['url'] = media()."/images/uploads/".$requestImg[0]['name'];
                        $request[$i]['image'] = $requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            //dep($request);exit;
            return $request;
        }
        public function getProductsCategoryT(string $category,string $subcategory,int $pageNow,int $sort){
            $this->con=new Mysql();
            $route="";
            if($subcategory!=""){
                $route=" AND c.route = '$category' AND s.route = '$subcategory'";
            }else{
                $route=" AND c.route = '$category'";
            }
            $perPage = PERPAGE;
            $option ="ORDER BY p.idproduct DESC";
            if($sort == 2){
                $option = "ORDER BY p.price DESC";
            }else if($sort == 3){
                $option = "ORDER BY p.price ASC";
            }
            $sqlTotal = "SELECT COUNT(p.idproduct) AS total 
            FROM product p 
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND p.status = 1 $route";
             
            $totalProducts =$this->con->select($sqlTotal)['total'];

            $totalPages = ceil($totalProducts/$perPage);
            $start = ($pageNow - 1) * $perPage;
            $start = $start < 0 ? 0 : $start;

            $sql = "SELECT 
                p.idproduct,
                p.categoryid,
                p.subcategoryid,
                p.reference,
                p.name,
                p.description,
                p.price,
                p.discount,
                p.description,
                p.stock,
                p.status,
                p.route,
                c.idcategory,
                c.name as category,
                c.route as routec,
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory,
                s.route as routes
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND p.status = 1 $route $option 
            LIMIT $start,$perPage";
            $request = $this->con->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 

                    $request[$i]['priceDiscount'] =  $request[$i]['price']-($request[$i]['price']*($request[$i]['discount']*0.01));
                    $request[$i]['price'] = $request[$i]['price'];
                    $request[$i]['favorite'] = 0;

                    $idProduct = $request[$i]['idproduct'];

                    if(isset($_SESSION['login'])){
                        $idUser = $_SESSION['idUser'];
                        $sqlFavorite = "SELECT * FROM wishlist WHERE productid = $idProduct AND personid = $idUser";
                        $requestFavorite = $this->con->select($sqlFavorite);
                        if(!empty($requestFavorite)){
                            $request[$i]['favorite'] = $requestFavorite['status'];
                        }
                    }
                    $sqlRate = "SELECT AVG(rate) as rate FROM productrate WHERE productid = $idProduct";
                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg =  $this->con->select_all($sqlImg);
                    $requestRate =  $this->con->select($sqlRate);
                    $request[$i]['rate'] = $requestRate['rate'];

                    if(count($requestImg)>0){
                        $request[$i]['url'] = media()."/images/uploads/".$requestImg[0]['name'];
                        $request[$i]['image'] = $requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            $array = array("productos"=>$request,"paginas"=>$totalPages);
            return $array;
        }
        public function getProductT(int $idProduct){
            $this->con=new Mysql();
            $this->intIdProduct = $idProduct;
            $sql = "SELECT 
                p.idproduct,
                p.categoryid,
                p.subcategoryid,
                p.reference,
                p.name,
                p.shortdescription,
                p.description,
                p.price,
                p.discount,
                p.stock,
                p.status,
                p.route,
                c.idcategory,
                c.name as category,
                c.route as routec,
                s.route as routes,
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory 
            AND p.idproduct = $this->intIdProduct";

            $request = $this->con->select($sql);
            $sqlImg = "SELECT * FROM productimage WHERE productid = $this->intIdProduct";
            $requestImg = $this->con->select_all($sqlImg);

            if(count($requestImg)){
                for ($i=0; $i < count($requestImg); $i++) { 
                    $request['image'][$i] = array("url"=>media()."/images/uploads/".$requestImg[$i]['name'],"name"=>$requestImg[$i]['name']);
                }
            }
            //dep($request);exit;
            return $request;
        }
        public function getProductPageT(string $route){
            $this->con=new Mysql();
            $sql = "SELECT 
                p.idproduct,
                p.categoryid,
                p.subcategoryid,
                p.reference,
                p.name,
                p.shortdescription,
                p.description,
                p.price,
                p.discount,
                p.stock,
                p.status,
                p.route,
                c.idcategory,
                c.name as category,
                c.route as routec,
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND p.status = 1
            AND p.route = '$route'";

            $request = $this->con->select($sql);
            if(!empty($request)){
                $request['priceDiscount'] =  $request['price']-($request['price']*($request['discount']*0.01));
                $request['price'] = $request['price'];
                $request['favorite'] = 0;
                $idProduct =$request['idproduct'];
    
                if(isset($_SESSION['login'])){
                    $idUser = $_SESSION['idUser'];
                    $sqlFavorite = "SELECT * FROM wishlist WHERE productid = $idProduct AND personid = $idUser";
                    $requestFavorite = $this->con->select($sqlFavorite);
                    if(!empty($requestFavorite)){
                        $request['favorite'] = $requestFavorite['status'];
                    }
                }
    
                $sqlRate = "SELECT AVG(rate) as rate, COUNT(rate) as total FROM productrate WHERE productid = $idProduct HAVING rate IS NOT NULL";
                $requestRate =  $this->con->select($sqlRate);
                //dep($requestRate);exit;
                if(!empty($requestRate)){
                    $request['rate'] = number_format($requestRate['rate'],1);
                    $request['reviews'] = $requestRate['total'];
                }else{
                    $request['rate'] = number_format(0,1);
                    $request['reviews'] = 0;
                }
                
                $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                $requestImg = $this->con->select_all($sqlImg);
    
                if(count($requestImg)){
                    for ($i=0; $i < count($requestImg); $i++) { 
                        $request['image'][$i] = array("url"=>media()."/images/uploads/".$requestImg[$i]['name'],"name"=>$requestImg[$i]['name']);
                    }
                }
            }
            return $request;
        }
    }
    
?>