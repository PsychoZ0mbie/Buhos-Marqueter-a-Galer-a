<?php 
    class ProductModel extends Mysql{
        private $intIdCategory;
        private $intIdSubCategory;
        private $intIdProduct;
        private $strReference;
		private $strName;
        private $strDescription;
        private $strShortDescription;
        private $intPrice;
        private $intDiscount;
        private $intStock;
		private $intStatus;
        private $strRoute;

        public function __construct(){
            parent::__construct();
        }
        /*************************Category methods*******************************/
        public function insertProduct(int $idCategory, int $idSubcategory,string $strReference, string $strName, string $strShortDescription,string $strDescription, int $intPrice, int $intDiscount, int $intStock, int $intStatus, string $route, array $photos){
            
            $this->intIdCategory = $idCategory;
            $this->intIdSubCategory = $idSubcategory;
            $this->strReference = $strReference;
			$this->strName = $strName;
            $this->strDescription = $strDescription;
            $this->intPrice = $intPrice;
            $this->intDiscount = $intDiscount;
            $this->intStock = $intStock;
			$this->intStatus = $intStatus;
			$this->strRoute = $route;
            $this->strShortDescription = $strShortDescription;

			$return = 0;
            $reference="";
            if($this->strReference!=""){
                $reference = "OR reference = '$this->strReference'";
            }
			$sql = "SELECT * FROM product WHERE name = '$this->strName' $reference";
			$request = $this->select_all($sql);

			if(empty($request))
			{ 
				$query_insert  = "INSERT INTO product(categoryid,subcategoryid,reference,name,shortdescription,description,price,discount,stock,status,route) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
	        	$arrData = array(
                    $this->intIdCategory,
                    $this->intIdSubCategory,
                    $this->strReference,
                    $this->strName,
                    $this->strShortDescription,
                    $this->strDescription,
                    $this->intPrice,
                    $this->intDiscount,
                    $this->intStock,
                    $this->intStatus,
                    $this->strRoute
        		);
	        	$request_insert = $this->insert($query_insert,$arrData);
                for ($i=0; $i < count($photos) ; $i++) { 
                    $sqlImg = "INSERT INTO productimage(productid,name) VALUES(?,?)";
                    $arrImg = array($request_insert,$photos[$i]['re_name']);
                    $requestImg = $this->insert($sqlImg,$arrImg);
                }
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}
        public function updateProduct(int $idProduct,int $idCategory, int $idSubcategory,string $strReference, string $strName, string $strShortDescription, string $strDescription, int $intPrice, int $intDiscount, int $intStock, int $intStatus, string $route, array $photos){
            $this->intIdProduct = $idProduct;
            $this->intIdCategory = $idCategory;
            $this->intIdSubCategory = $idSubcategory;
            $this->strReference = $strReference;
			$this->strName = $strName;
            $this->strDescription = $strDescription;
            $this->intPrice = $intPrice;
            $this->intDiscount = $intDiscount;
            $this->intStock = $intStock;
			$this->intStatus = $intStatus;
			$this->strRoute = $route;
            $this->strShortDescription = $strShortDescription;

            $reference="";
            if($this->strReference!=""){
                $reference = "OR reference = '$this->strReference' AND name = '{$this->strName}' AND idproduct != $this->intIdProduct";
            }

			$sql = "SELECT * FROM product WHERE name = '{$this->strName}' AND idproduct != $this->intIdProduct $reference";
			$request = $this->select_all($sql);

			if(empty($request)){
                

                $sql = "UPDATE product SET categoryid=?, subcategoryid=?, reference=?, name=?, shortdescription=?,description=?, 
                price=?,discount=?,stock=?,status=?, route=? WHERE idproduct = $this->intIdProduct";
                $arrData = array(
                    $this->intIdCategory,
                    $this->intIdSubCategory,
                    $this->strReference,
                    $this->strName,
                    $this->strShortDescription,
                    $this->strDescription,
                    $this->intPrice,
                    $this->intDiscount,
                    $this->intStock,
                    $this->intStatus,
                    $this->strRoute
        		);
				$request = $this->update($sql,$arrData);
                if(!empty($photos)){
                    $delImages = $this->deleteImages($this->intIdProduct);
                    for ($i=0; $i < count($photos) ; $i++) { 
                        $sqlImg = "INSERT INTO productimage(productid,name) VALUES(?,?)";
                        $arrImg = array($this->intIdProduct,$photos[$i]['rename']);
                        $requestImg = $this->insert($sqlImg,$arrImg);
                    }
                }
			}else{
				$request = "exist";
			}
			return $request;
		
		}
        public function deleteProduct($id){
            $this->intIdProduct = $id;
            $images = $this->selectImages($this->intIdProduct);
            for ($i=0; $i < count($images) ; $i++) { 
                deleteFile($images[$i]['name']);
            }
            $sql = "DELETE FROM product WHERE idproduct = $this->intIdProduct;SET @autoid :=0; 
            UPDATE productimage SET id = @autoid := (@autoid+1);
            ALTER TABLE productimage Auto_Increment = 1;";
            $request = $this->delete($sql);
            return $request;
        }
        public function selectProducts(){
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
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory,
                DATE_FORMAT(p.date, '%d/%m/%Y') as date
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory
            ORDER BY p.idproduct DESC
            ";
            $request = $this->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 
                    $idProduct = $request[$i]['idproduct'];
                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg = $this->select_all($sqlImg);
                    if(count($requestImg)>0){
                        $request[$i]['image'] = media()."/images/uploads/".$requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            return $request;
        }
        public function selectCategories(){
            $sql = "SELECT * FROM category ORDER BY idcategory ASC";       
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectSubCategories($id){
            $this->intIdCategory = $id;
            $sql = "SELECT  
                    s.idsubcategory,
                    s.name,
                    s.categoryid,
                    s.status,
                    c.idcategory,
                    c.name as category,
                    c.status
                    FROM subcategory s
                    INNER JOIN category c
                    ON c.idcategory = s.categoryid
                    WHERE s.categoryid = $this->intIdCategory
                    ORDER BY idsubcategory ASC";       
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectProduct($id){
            $this->intIdProduct = $id;
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
                s.idsubcategory,
                s.categoryid,
                s.name as subcategory,
                DATE_FORMAT(p.date, '%d/%m/%Y') as date
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory 
            AND p.idproduct = $this->intIdProduct";
            $request = $this->select($sql);
            $sqlImg = "SELECT * FROM productimage WHERE productid = $this->intIdProduct";
            $requestImg = $this->select_all($sqlImg);
            if(count($requestImg)){
                for ($i=0; $i < count($requestImg); $i++) { 
                    $request['image'][$i] = array("url"=>media()."/images/uploads/".$requestImg[$i]['name'],"name"=>$requestImg[$i]['name'],"rename"=>$requestImg[$i]['name']);
                }
            }
            return $request;
        }
        public function insertTmpImage(string $name, string $rename){
            $sql = "INSERT INTO imagetmp(name,re_name) VALUES(?,?)";
            $arrData = array($name,$rename);
            $request = $this->insert($sql,$arrData);
            return $request;
        }
        public function deleteTmpImage($rename = null){
            if($rename != null){
                $sql = "DELETE FROM imagetmp WHERE re_name = '$rename'; SET @autoid :=0; 
                UPDATE imagetmp SET id = @autoid := (@autoid+1);
                ALTER TABLE imagetmp Auto_Increment = 1;";
                $request = $this->delete($sql);
            }else{
                $sql = "DELETE FROM imagetmp ; SET @autoid :=0; 
                UPDATE imagetmp SET id = @autoid := (@autoid+1);
                ALTER TABLE imagetmp Auto_Increment = 1;";
                $request = $this->delete($sql);
            }
            return $request;
        }
        public function selectTmpImages(){
            $sql = "SELECT * FROM imagetmp";
            $request = $this->select_all($sql);
            for ($i=0; $i < count($request); $i++) { 
                $request[$i]['rename'] = $request[$i]['re_name'];
            }
            return $request;
        }
        public function selectImages($id){
            $this->intIdProduct = $id;
            $sql = "SELECT * FROM productimage WHERE productid=$this->intIdProduct";
            $request = $this->select_all($sql);
            for ($i=0; $i < count($request); $i++) { 
                $request[$i]['rename'] = $request[$i]['name'];
            }
            return $request;
        }
        public function deleteImages($id){
            $this->intIdProduct = $id;
            $sql = "DELETE FROM productimage WHERE productid=$this->intIdProduct";
            $request = $this->select_all($sql);
            return $request;
        }
        public function search($search){
            $sql="SELECT 
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
                DATE_FORMAT(p.date, '%d/%m/%Y') as date
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND
            p.name LIKE  '%$search%' || c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND
            c.name LIKE  '%$search%' || c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory AND
            s.name LIKE '%$search%'
            ";
            $request = $this->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 
                    $idProduct = $request[$i]['idproduct'];
                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg = $this->select_all($sqlImg);
                    if(count($requestImg)>0){
                        $request[$i]['image'] = media()."/images/uploads/".$requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            return $request;
        }
        public function sort($sort){
            $option=" ORDER BY p.idproduct DESC";
            if($sort == 2){
                $option = " ORDER BY p.idproduct ASC"; 
            }else if( $sort == 3){
                $option = " ORDER BY p.stock ASC"; 
            }
            $sql="SELECT 
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
                DATE_FORMAT(p.date, '%d/%m/%Y') as date
            FROM product p
            INNER JOIN category c, subcategory s
            WHERE c.idcategory = p.categoryid AND c.idcategory = s.categoryid AND p.subcategoryid = s.idsubcategory $option";
            $request = $this->select_all($sql);
            if(count($request)> 0){
                for ($i=0; $i < count($request); $i++) { 
                    $idProduct = $request[$i]['idproduct'];
                    $sqlImg = "SELECT * FROM productimage WHERE productid = $idProduct";
                    $requestImg = $this->select_all($sqlImg);
                    if(count($requestImg)>0){
                        $request[$i]['image'] = media()."/images/uploads/".$requestImg[0]['name'];
                    }else{
                        $request[$i]['image'] = media()."/images/uploads/image.png";
                    }
                }
            }
            return $request;
        }
    }
?>