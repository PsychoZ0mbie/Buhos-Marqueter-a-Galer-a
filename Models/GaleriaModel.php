<?php 

	class GaleriaModel extends Mysql
	{
        private $intIdCategoria;
        private $intIdSubcategoria;
        private $intIdTecnica;
        private $intIdProducto;
        private $strRuta;
        private $strProducto;
        private $intAlto;
        private $intAncho;
        private $intPrecio;
        private $strDescripcion;
        private $intStatus;
        private $strImagen;
        private $intMarco;
        private $strAutor;

		public function __construct(){
		
			parent::__construct();
		}

        /******************************Products************************************/
        public function insertProducto($categoria,$nombre,$autor,$subcategoria,$tecnica,$alto,$ancho,$marco,$precio,$descripcion,$ruta,$status,$imagenes){

            $this->strProducto = $nombre;
            $this->strAutor = $autor;
            $this->intIdCategoria = $categoria;
            $this->intIdSubcategoria = $subcategoria;
            $this->intIdTecnica = $tecnica;
            $this->intAlto = $alto;
            $this->intAncho = $ancho;
            $this->intMarco = $marco;
            $this->intPrecio = $precio;
            $this->strDescripcion = $descripcion;
            $this->strRuta = $ruta;
            $this->intStatus = $status;



            $return = "";
            $sql = "SELECT * FROM product WHERE title ='$this->strProducto'";
            $request = $this->select_all($sql);

            if(empty($request)){
                $query_insert = "INSERT INTO product (title,author,topicid,subtopicid,techniqueid,height,width,frame,price,
                                description,route,status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
                $arrData = array(
                                $this->strProducto,
                                $this->strAutor,
                                $this->intIdCategoria,
                                $this->intIdSubcategoria,
                                $this->intIdTecnica,
                                $this->intAlto,
                                $this->intAncho,
                                $this->intMarco,
                                $this->intPrecio,
                                $this->strDescripcion,
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
        public function updateProducto($idProducto,$categoria,$nombre,$autor,$subcategoria,$tecnica,$alto,$ancho,$marco,$precio,$descripcion,$ruta,$status,$imagenes){
            $this->intIdProducto = $idProducto;
            $this->strProducto = $nombre;
            $this->strAutor = $autor;
            $this->intIdCategoria = $categoria;
            $this->intIdSubcategoria = $subcategoria;
            $this->intIdTecnica = $tecnica;
            $this->intAlto = $alto;
            $this->intAncho = $ancho;
            $this->intMarco = $marco;
            $this->intPrecio = $precio;
            $this->strDescripcion = $descripcion;
            $this->strRuta = $ruta;
            $this->intStatus = $status;

            $return = "";
            $sql = "SELECT * FROM product WHERE title ='$this->strProducto' AND idproduct != $this->intIdProducto";
            $request = $this->select_all($sql);

            if(empty($request)){
                $query_update = "UPDATE product SET title=?,author=?,topicid=?,subtopicid=?,techniqueid=?,height=?,width=?,frame=?,price=?,
                                                    description=?,route=?,status=?
                                                    WHERE idproduct = $this->intIdProducto";
                $arrData = array(
                    $this->strProducto,
                    $this->strAutor,
                    $this->intIdCategoria,
                    $this->intIdSubcategoria,
                    $this->intIdTecnica,
                    $this->intAlto,
                    $this->intAncho,
                    $this->intMarco,
                    $this->intPrecio,
                    $this->strDescripcion,
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
                            techniqueid,
                            height,
                            width,
                            frame,
                            price,
                            description,
                            DATE_FORMAT(datecreated, '%Y-%m-%d') as date,
                            route,
                            status
                    FROM product
                    WHERE topicid = 2 $options";
             
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
                    author,
                    topicid,
                    subtopicid,
                    techniqueid,
                    height,
                    width,
                    frame,
                    price,
                    description,
                    DATE_FORMAT(datecreated, '%d-%m-%Y') as date,
                    route,
                    status
            FROM product
            WHERE topicid = 2 AND idproduct=$idproducto";
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
        /*public function updateTemp($product,$id,$title){
            $sql = "UPDATE product SET techniqueid=?,techniquename=? WHERE idproduct = $product";
            $array = array($id,$title);
            $request = $this->update($sql,$array);
        }*/
	}


    
 ?>