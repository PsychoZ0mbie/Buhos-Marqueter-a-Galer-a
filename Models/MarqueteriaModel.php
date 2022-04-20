<?php 

	class MarqueteriaModel extends Mysql
	{
        private $intIdCategoria;
        private $intIdSubcategoria;
        private $intIdProducto;
        private $strRuta;
        private $strProducto;
        private $intPrecio;
        private $intStatus;
        private $strImagen;


		public function __construct(){
		
			parent::__construct();
		}

        /******************************Products************************************/
        public function insertProducto($categoria,$nombre,$subcategoria,$precio,$ruta,$status,$imagenes){

            $this->strProducto = $nombre;
            $this->intIdCategoria = $categoria;
            $this->intIdSubcategoria = $subcategoria;
            $this->intPrecio = $precio;
            $this->strRuta = $ruta;
            $this->intStatus = $status;


            $return = "";
            $sql = "SELECT * FROM product WHERE title ='$this->strProducto'";
            $request = $this->select_all($sql);

            if(empty($request)){
                $query_insert = "INSERT INTO product (title,topicid,subtopicid,price,route,status) VALUES(?,?,?,?,?,?)";
                $arrData = array(
                                $this->strProducto,
                                $this->intIdCategoria,
                                $this->intIdSubcategoria,
                                $this->intPrecio,
                                $this->strRuta,
                                $this->intStatus);
                
                $request_insert = $this->insert($query_insert,$arrData);
                
                if($request_insert>0){
                    for ($i=0; $i < count($imagenes) ; $i++) { 
                        $query_img = "INSERT INTO productImage (productid,title) VALUES(?,?)";
                        $arrImg=array($request_insert,$imagenes[$i]);
                        $request_img = $this->insert($query_img,$arrImg);
                    }
                }
                

                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }
        public function updateProducto($idProducto,$categoria,$nombre,$subcategoria,$precio,$ruta,$status,$imagenes){
            $this->intIdProducto = $idProducto;
            $this->strProducto = $nombre;
            $this->intIdCategoria = $categoria;
            $this->intIdSubcategoria = $subcategoria;
            $this->intPrecio = $precio;
            $this->strRuta = $ruta;
            $this->intStatus = $status;

            $return = "";
            $sql = "SELECT * FROM product WHERE title ='$this->strProducto' AND idproduct != $this->intIdProducto";
            $request = $this->select_all($sql);

            if(empty($request)){
                $query_update = "UPDATE product SET title=?,topicid=?,subtopicid=?,price=?,route=?,status=? WHERE idproduct = $this->intIdProducto";
                $arrData = array(
                    $this->strProducto,
                    $this->intIdCategoria,
                    $this->intIdSubcategoria,
                    $this->intPrecio,
                    $this->strRuta,
                    $this->intStatus);
                
                $request_update = $this->update($query_update,$arrData);
                $return = $request_update;
                
                for ($i=0; $i < count($imagenes) ; $i++) { 
                    $id = $imagenes[$i][0];
                    $title = $imagenes[$i][1];
                    $query_img = "UPDATE productimage SET title=? WHERE idimage = $id";
                    $arrImg=array($title);
                    $request_img = $this->update($query_img,$arrImg);
                }
                
            }else{
                $return = "exist";
            }
            return $return;
        }
        public function selectProductos($options){
            if($options == 1){
				$options=" ORDER BY idproduct DESC";
			}else if($options == 2){
				$options=" ORDER BY idproduct ASC";
			}else if($options == 3){
				$options=" ORDER BY title";
			}else if($options == 4){
				$options=" ORDER BY author";
			}else if($options == 5){
				$options=" ORDER BY subtopicid";
			}else if($options == 6){
                $options=" ORDER BY techniqueid";
            }else{
				$options=" ORDER BY idproduct DESC";
			}
            
            $sql = "SELECT 
                            idproduct,
                            title,
                            author,
                            topicid,
                            subtopicid,
                            price,
                            DATE_FORMAT(datecreated, '%Y-%m-%d') as date,
                            route,
                            status
                    FROM product
                    WHERE topicid = 1 $options";
             
            $request = $this->select_all($sql);
            for ($i=0; $i <count($request) ; $i++) { 
                $idproduct = $request[$i]['idproduct'];
                $sqlimg = "SELECT * FROM productimage WHERE productid=$idproduct";
                $requestimg = $this->select_all($sqlimg);
                $request[$i]['url'] = base_url()."/Assets/images/uploads/".$requestimg[0]['title'];
            }
            return $request;
        }
        public function selectProducto($idproducto){
            $sql = "SELECT 
                    idproduct,
                    title,
                    topicid,
                    subtopicid,
                    price,
                    DATE_FORMAT(datecreated, '%d-%m-%Y') as date,
                    route,
                    status
            FROM product
            WHERE topicid = 1 AND idproduct=$idproducto";
            $request = $this->select($sql);

            $sqlImg = "SELECT * FROM productimage WHERE productid=$idproducto";
            $requestImg = $this->select_all($sqlImg);
            $request['img'] = $requestImg;
            return $request;
        }
        public function deleteProducto(int $idproducto){
			$this->intIdProducto = $idproducto;
			$sql = "DELETE FROM product WHERE idproduct = $this->intIdProducto";
			$request = $this->delete($sql);
			return $request;
		}
        public function selectImage($idproducto){
            $sql = "SELECT * FROM productimage WHERE productid = $idproducto";
            $request = $this->select_all($sql);
            return $request;
        }
        public function deleteImage($idproducto){
            $this->intIdProducto = $idproducto;
			$sql = "DELETE FROM productimage WHERE productid = $this->intIdProducto";
			$request = $this->delete($sql);
        }

        /*public function updateTemp($product,$id){
            $sql = "UPDATE product SET subtopicid=? WHERE idproduct = $product";
            $array = array($id);
            $request = $this->update($sql,$array);
        }*/

	}


    
 ?>