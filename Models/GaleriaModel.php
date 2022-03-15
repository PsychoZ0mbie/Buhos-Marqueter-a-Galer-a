<?php 

	class GaleriaModel extends Mysql
	{
        public $intIdCategoria;
        public $intIdSubcategoria;
        public $intIdTecnica;
        public $intIdProducto;
        public $strCategoria;
        public $strRuta;
        public $strTecnica;
        public $strSubcategoria;
        public $strReferencia;
        public $strProducto;
        public $intLargo;
        public $intAncho;
        public $floatPrecio;
        public $intCantidad;
        public $strDescripcion;
        public $intStatus;
        public $strImagen;



		public function __construct(){
		
			parent::__construct();
		}

        /******************************Products************************************/
        public function insertProducto($referencia,$nombre,$categoria,$subcategoria,$tecnica,$largo,$ancho,$precio,$cantidad,$descripcion,$ruta,$status){
            $this->strReferencia = $referencia;
            $this->strProducto = $nombre;
            $this->intIdCategoria = $categoria;
            $this->intIdSubcategoria = $subcategoria;
            $this->intIdTecnica = $tecnica;
            $this->intLargo = $largo;
            $this->intAncho = $ancho;
            $this->floatPrecio = $precio;
            $this->intCantidad = $cantidad;
            $this->strDescripcion = $descripcion;
            $this->strRuta = $ruta;
            $this->intStatus = $status;

            $return = "";
            $sql = "SELECT * FROM product WHERE title ='$this->strProducto' AND reference = '$this->strReferencia'";
            $request = $this->select_all($sql);

            if(empty($request)){
                $query_insert = "INSERT INTO product (reference,title,topicid,subtopicid,techniqueid,length,width,price,stock,
                                description,route,status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
                $arrData = array($this->strReferencia,
                                $this->strProducto,
                                $this->intIdCategoria,
                                $this->intIdSubcategoria,
                                $this->intIdTecnica,
                                $this->intLargo,
                                $this->intAncho,
                                $this->floatPrecio,
                                $this->intCantidad,
                                $this->strDescripcion,
                                $this->strRuta,
                                $this->intStatus);
                
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }
        public function updateProducto($idproducto,$referencia,$nombre,$categoria,$subcategoria,$tecnica,$largo,$ancho,$precio,$cantidad,$descripcion,$ruta,$status){
            $this->intIdProducto= $idproducto;
            $this->strReferencia = $referencia;
            $this->strProducto = $nombre;
            $this->intIdCategoria = $categoria;
            $this->intIdSubcategoria = $subcategoria;
            $this->intIdTecnica = $tecnica;
            $this->intLargo = $largo;
            $this->intAncho = $ancho;
            $this->floatPrecio = $precio;
            $this->intCantidad = $cantidad;
            $this->strDescripcion = $descripcion;
            $this->strRuta = $ruta;
            $this->intStatus = $status;

            $return = "";
            $sql = "SELECT * FROM product WHERE title ='$this->strProducto' AND idproduct != $this->intIdProducto";
            $request = $this->select_all($sql);

            if(empty($request)){
                $query_update = "UPDATE product SET reference=?,title=?,topicid=?,subtopicid=?,techniqueid=?,
                                                length=?,width=?,price=?,stock=?, description=?,route=?,status=?
                                                 WHERE idproduct = $this->intIdProducto";
                $arrData = array($this->strReferencia,
                                $this->strProducto,
                                $this->intIdCategoria,
                                $this->intIdSubcategoria,
                                $this->intIdTecnica,
                                $this->intLargo,
                                $this->intAncho,
                                $this->floatPrecio,
                                $this->intCantidad,
                                $this->strDescripcion,
                                $this->strRuta,
                                $this->intStatus);
                
                $request_update = $this->update($query_update,$arrData);
                $return = $request_update;
            }else{
                $return = "exist";
            }
            return $return;
        }
        public function selectProductos(){
            $sql = "SELECT s.idsubtopic,
                            s.title as categoria,
                            t.idtechnique,
                            t.title as tecnica,
                            p.idproduct,
                            p.reference,
                            p.title,
                            p.topicid,
                            p.subtopicid,
                            p.techniqueid,
                            p.length,
                            p.width,
                            p.price,
                            p.stock,
                            p.description,
                            DATE_FORMAT(p.datecreated, '%Y-%m-%d') as date,
                            p.route,
                            p.status
                    FROM product p
                    INNER JOIN subtopics s, techniques t
                    WHERE s.idsubtopic = p.subtopicid AND t.idtechnique = p.techniqueid 
                            AND p.topicid = 2 AND p.status != 0";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectProducto($idproducto){
            $sql = "SELECT s.idsubtopic,
                            s.title as categoria,
                            t.idtechnique,
                            t.title as tecnica,
                            p.idproduct,
                            p.reference,
                            p.title,
                            p.topicid,
                            p.subtopicid,
                            p.techniqueid,
                            p.length,
                            p.width,
                            p.price,
                            p.stock,
                            p.description,
                            DATE_FORMAT(p.datecreated, '%Y-%m-%d') as date,
                            p.route,
                            p.status
                    FROM product p
                    INNER JOIN subtopics s, techniques t
                    WHERE s.idsubtopic = p.subtopicid AND t.idtechnique = p.techniqueid 
                            AND p.topicid = 2 AND p.status != 0 AND p.idproduct = $idproducto";
            $request = $this->select($sql);
            return $request;
        }
        public function deleteProducto(int $idproducto){
			$this->intIdProducto = $idproducto;
			$sql = "UPDATE product SET status = ? WHERE idproduct = $this->intIdProducto";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

        public function insertImage(int $idproducto, string $imagen){
			$this->intIdProducto = $idproducto;
			$this->strImagen = $imagen;
			$query_insert  = "INSERT INTO productimage(productid,title) VALUES(?,?)";
	        $arrData = array($this->intIdProducto,
                            $this->strImagen);
	        $request_insert = $this->insert($query_insert,$arrData);
	        return $request_insert;
		}
        public function deleteImage(int $idproducto, string $imagen){
			$this->intIdProducto = $idproducto;
			$this->strImagen = $imagen;
			$query  = "DELETE FROM productimage 
						WHERE productid = $this->intIdProducto
						AND title = '{$this->strImagen}'";
	        $request_delete = $this->delete($query);
	        return $request_delete;
		}
        public function selectImage($idproducto){
            $sql = "SELECT * FROM productimage WHERE productid = $idproducto";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPapelera(){
            $sql = "SELECT idproduct,
                            reference,
                            title,
                            topicid,
                            route,
                            status
                    FROM product
                    WHERE topicid = 2 AND status = 0";
            $request = $this->select_all($sql);
            return $request;
        }
        public function recovery($idproducto){
            $this->intIdProducto = $idproducto;
            $sql="UPDATE product SET status = ? WHERE idproduct = $this->intIdProducto";
            $array = array(2);
            $request = $this->update($sql,$array);
            return $request;
        }
        public function deleteRecoveryInfo($idproducto){
            $this->intIdProducto = $idproducto;
            $sql = "DELETE FROM product WHERE idproduct =$this->intIdProducto";
            $request = $this->delete($sql);
            return $request;
        }

        /******************************SubTopics************************************/
        public function insertSubcategoria($subcategoria,$categoria,$ruta){
    
            $return = "";
            $this->strSubcategoria = $subcategoria;
            $this->intIdCategoria = $categoria;
            $this->strRuta = $ruta;
    
            $sql = "SELECT * FROM subtopics WHERE title = '{$this->strSubcategoria}' ";
            $request = $this->select_all($sql);
    
            if(empty($request))
            {
                $query_insert  = "INSERT INTO subtopics(title,topicid,route) VALUES(?,?,?)";
                $arrData = array($this->strSubcategoria,$this->intIdCategoria,$this->strRuta);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function updateSubcategoria(int $idSubcategoria, string $subcategoria,int $categoria,string $ruta){

            $this->intIdSubcategoria = $idSubcategoria;
            $this->strSubcategoria = $subcategoria;
            $this->intIdCategoria = $categoria;
            $this->strRuta = $ruta;
    
            $sql = "SELECT * FROM subtopics WHERE title ='{$this->strSubcategoria}' AND idsubtopic != $this->intIdSubcategoria";
            $request = $this->select_all($sql);
    
            if(empty($request)){
            
                $sql = "UPDATE subtopics SET title=?,topicid=?,route=? WHERE idsubtopic = $this->intIdSubcategoria";
                $arrData = array($this->strSubcategoria,
                                $this->intIdCategoria,
                                $this->strRuta);
                $request = $this->update($sql,$arrData);
            }else{
                $request = "exist";
            }
            return $request;
        }

        public function deleteSubcategoria(int $idSubcategoria){
		
			$this->intIdSubcategoria = $idSubcategoria;
			$sql = "SELECT * FROM product WHERE subtopicid = $this->intIdSubcategoria";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "DELETE FROM subtopics WHERE idsubtopic = $this->intIdSubcategoria;set @autoid :=0; 
                update subtopics set idsubtopic = @autoid := (@autoid+1);
                alter table subtopics Auto_Increment = 1;";
				$request = $this->delete($sql);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			}else{
				$request = 'exist';
			}
			return $request;
		}

        public function selectSubcategorias(){
            $sql = "SELECT t.idtopic,
                        s.idsubtopic,
                        s.title,
                        s.topicid
                    FROM subtopics s
                    INNER JOIN topics t
                    WHERE t.idtopic = 2 AND s.topicid = 2";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectSubcategoria(int $idSubcategoria){
			$this->intIdSubcategoria = $idSubcategoria;
			$sql = "SELECT t.idtopic,
                        t.title as topic,
                        s.idsubtopic,
                        s.title,
                        s.topicid
                    FROM subtopics s
                    INNER JOIN topics t
                    WHERE t.idtopic = s.topicid AND s.idsubtopic = $this->intIdSubcategoria";
			$request = $this->select($sql);
			return $request;
		}

        /******************************Techniques************************************/
        public function insertTecnica($tecnica,$categoria,$ruta){
    
            $return = "";
            $this->strTecnica = $tecnica;
            $this->intIdCategoria = $categoria;
            $this->strRuta = $ruta;
    
            $sql = "SELECT * FROM techniques WHERE title = '{$this->strTecnica}' ";
            $request = $this->select_all($sql);
    
            if(empty($request))
            {
                $query_insert  = "INSERT INTO techniques(title,topicid,route) VALUES(?,?,?)";
                $arrData = array($this->strTecnica,$this->intIdCategoria,$this->strRuta);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function updateTecnica(int $idTecnica, string $tecnica,int $categoria,string $ruta){

            $this->intIdTecnica = $idTecnica;
            $this->strTecnica = $tecnica;
            $this->intIdCategoria = $categoria;
            $this->strRuta = $ruta;
    
            $sql = "SELECT * FROM techniques WHERE title ='{$this->strTecnica}' AND idtechnique != $this->intIdTecnica";
            $request = $this->select_all($sql);
    
            if(empty($request)){
            
                $sql = "UPDATE techniques SET title=?,topicid=?,route=? WHERE idtechnique = $this->intIdTecnica";
                $arrData = array($this->strTecnica,
                                $this->intIdCategoria,
                                $this->strRuta);
                $request = $this->update($sql,$arrData);
            }else{
                $request = "exist";
            }
            return $request;
        }

        public function deleteTecnica(int $idTecnica){
		
			$this->intIdTecnica = $idTecnica;
			$sql = "SELECT * FROM product WHERE subtopicid = $this->intIdTecnica";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "DELETE FROM techniques WHERE idtechnique = $this->intIdTecnica;set @autoid :=0; 
                update techniques set idtechnique = @autoid := (@autoid+1);
                alter table techniques Auto_Increment = 1;";
				$request = $this->delete($sql);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			}else{
				$request = 'exist';
			}
			return $request;
		}

        public function selectTecnicas(){
            $sql = "SELECT t.idtopic,
                        s.idtechnique,
                        s.title,
                        s.topicid
                    FROM techniques s
                    INNER JOIN topics t
                    WHERE t.idtopic = 2 AND s.topicid = 2";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectTecnica(int $idTecnica){
			$this->intIdTecnica = $idTecnica;
			$sql = "SELECT t.idtopic,
                        t.title as topic,
                        s.idtechnique,
                        s.title,
                        s.topicid
                    FROM techniques s
                    INNER JOIN topics t
                    WHERE t.idtopic = s.topicid AND s.idtechnique = $this->intIdTecnica";
			$request = $this->select($sql);
			return $request;
		}
	}


    
 ?>