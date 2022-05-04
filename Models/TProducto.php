<?php
require_once("Libraries/Core/Mysql.php");

    trait TProducto{
        private $con;
        private $intIdCategoria;
        private $strRuta;
        private $intIdProducto;



        public function getMolduras($tipo){
            $this->con = new Mysql();
            
            $sql = "SELECT 
                            idproduct,
                            title,
                            topicid,
                            subtopicid,
                            price,
                            waste,
                            DATE_FORMAT(datecreated, '%Y-%m-%d') as date,
                            route,
                            status
                    FROM product
                    WHERE topicid = 1 AND subtopicid = $tipo AND status = 1 ORDER BY title DESC";
             
            $request = $this->con->select_all($sql);
            for ($i=0; $i <count($request) ; $i++) { 
                $idproduct = $request[$i]['idproduct'];
                $sqlimg = "SELECT * FROM productimage WHERE productid=$idproduct";
                $requestimg = $this->con->select_all($sqlimg);
                $request[$i]['url'][0] = base_url()."/Assets/images/uploads/".$requestimg[0]['title'];
                $request[$i]['url'][1] = $requestimg[1]['title'];
            }
            return $request;
        }
        public function getColores(){
            $this->con = new Mysql();
            
            $sql = "SELECT *
                    FROM colors
                    WHERE status = 1 ORDER BY title ASC";
             
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getMoldura($id){
            $this->con = new Mysql();
            $sql = "SELECT 
                    idproduct,
                    title,
                    topicid,
                    price,
                    waste
                    FROM product 
                    WHERE topicid=1 AND idproduct=$id";
            $request = $this->con->select($sql);
            return $request;
        }
        public function getObras($arr){
            $options="";
            if(count($arr) && $arr[0] == "topic"){
                $options = " AND subtopicid = $arr[1]";
            }else if(count($arr) && $arr[0] == "tech"){
                $options = " AND techniqueid =$arr[1]";
            }else if(count($arr) && $arr[0] == 2){
                $options = " ORDER BY price DESC";
            }else if(count($arr) && $arr[0] == 3){
                $options = " ORDER BY price ASC";
            }
            $this->con = new MySql();
            $sql = "SELECT * FROM product WHERE topicid =2 $options";
            $request = $this->con->select_all($sql);
            for ($i=0; $i < count($request); $i++) { 
                $idproduct = $request[$i]['idproduct'];
                $sqlImg = "SELECT * FROM productimage WHERE productid = $idproduct";
                $requestImg = $this->con->select_all($sqlImg);
                $request[$i]['url'] = base_url()."/Assets/images/uploads/".$requestImg[0]['title'];
            }
            return $request;
        }

        /*
        public function getProductosT(){
            $this->con = new Mysql();
            $sql = "SELECT s.idsubtopic,
                            s.topicid, 
                            s.title as categoria,
                            t.idtechnique,
                            t.topicid,
                            t.title as subcategoria,
                            p.idproduct,
                            p.topicid,
                            p.subtopicid,
                            p.techniqueid,
                            p.title,
                            p.price,
                            p.route,
                            p.stock,
                            p.status
                    FROM product p
                    INNER JOIN techniques t, subtopics s
                    WHERE s.topicid = p.topicid AND 
                            t.topicid = p.topicid AND 
                            s.idsubtopic = p.subtopicid AND
                            t.idtechnique = p.techniqueid AND
                            p.status != 0
                    ORDER BY p.idproduct DESC limit 0,8";
            $request = $this->con->select_all($sql);
            if(count($request)){
                for ($i=0; $i < count($request) ; $i++) { 
                    $intProducto = $request[$i]['idproduct'];
                    $sql ="SELECT * FROM productimage
                            WHERE productid = $intProducto limit 1";
                    $requestImage = $this->con->select_all($sql);
                    $request[$i]['url_image'] = media()."/images/uploads/".$requestImage[0]['title'];
                    $request[$i]['price'] = number_format($request[$i]['price'],0,DEC,MIL);
                }
            }
            return $request;
            
        }
        public function getProductosCategoriasT($categoria,$params,$cant){
            $this->intIdCategoria = $categoria;
            $this->strRuta = $params;
            $this->con = new Mysql();
            
            if($this->strRuta ==""){
                $ruta = "";
            }else{
                $ruta = " AND s.route = '$this->strRuta' OR t.route = '$this->strRuta' AND
                            s.topicid = p.topicid AND 
                            t.topicid = p.topicid AND 
                            s.idsubtopic = p.subtopicid AND
                            t.idtechnique = p.techniqueid AND
                            p.subtopicid != 6 AND
                            p.status != 0 AND p.topicid = $this->intIdCategoria";
            }   
            if($cant!=""){
                $cant = "ORDER BY RAND() LIMIT $cant";
            }else{
                $cant="";
            }
           
            $sql = "SELECT s.idsubtopic,
                            s.topicid,
                            s.title as categoria,
                            s.route,
                            t.idtechnique,
                            t.topicid,
                            t.title as subcategoria,
                            t.route,
                            p.idproduct,
                            p.topicid,
                            p.subtopicid,
                            p.techniqueid,
                            p.title,
                            p.price,
                            p.route,
                            p.status,
                            p.stock
                    FROM product p
                    INNER JOIN techniques t, subtopics s
                    WHERE s.topicid = p.topicid AND 
                            t.topicid = p.topicid AND 
                            s.idsubtopic = p.subtopicid AND
                            t.idtechnique = p.techniqueid AND
                            p.status != 0 AND p.topicid = $this->intIdCategoria $ruta $cant";
            $request = $this->con->select_all($sql);
            if(count($request)){
                for ($i=0; $i < count($request) ; $i++) { 
                    $intProducto = $request[$i]['idproduct'];
                    $sql ="SELECT * FROM productimage
                            WHERE productid = $intProducto limit 1";
                    $requestImage = $this->con->select_all($sql);
                    $request[$i]['url_image'] = media()."/images/uploads/".$requestImage[0]['title'];
                    $request[$i]['price'] = number_format($request[$i]['price'],0,DEC,MIL);
                }
            }
            return $request;
        }
        public function getProductosViewT($params){
            $this->strRuta = $params;
            $this->con = new Mysql();

            $sql = "SELECT  c.idtopic,
                            c.title as titulo,
                            c.route as rutaC,
                            s.idsubtopic,
                            s.topicid,
                            s.title as categoria,
                            s.route as rutaS,
                            t.idtechnique,
                            t.topicid,
                            t.title as subcategoria,
                            p.idproduct,
                            p.topicid,
                            p.subtopicid,
                            p.techniqueid,
                            p.reference,
                            p.title,
                            p.description,
                            p.length,
                            p.width,
                            p.price,
                            p.route,
                            p.stock,
                            p.status
                    FROM product p
                    INNER JOIN techniques t, subtopics s, topics c
                    WHERE s.topicid = p.topicid AND 
                            t.topicid = p.topicid AND 
                            s.idsubtopic = p.subtopicid AND
                            t.idtechnique = p.techniqueid AND
                            c.idtopic = p.topicid AND
                            p.status != 0 AND p.route = '$this->strRuta'";
            $request = $this->con->select_all($sql);
            if(count($request)>0){
                for ($i=0; $i < count($request) ; $i++) { 
                    $intProducto = $request[$i]['idproduct'];
                    $sql ="SELECT * FROM productimage
                            WHERE productid = $intProducto";
                    $requestImage = $this->con->select_all($sql);
                    
                    if(count($requestImage)>0){
                        for ($j=0; $j < count($requestImage) ; $j++) { 
                            $requestImage[$j]['url_image'] = media()."/images/uploads/".$requestImage[$j]['title'];
                        }
                    }
                    //$request[$i]['price'] = number_format($request[$i]['price'],0,DEC,MIL);
                    $request[$i]['image'] = $requestImage;
                    
                }
            }
            return $request;
        }
        public function getProductosAtt($categoria){
            $this->con = new Mysql();
            $sql = "SELECT s.idsubtopic,
                    a.subtopicid,
                    a.idattribute,
                    a.title as atributo
                    FROM attribute a
                    INNER JOIN subtopics s
                    WHERE s.idsubtopic = a.subtopicid AND s.topicid = 1 AND a.subtopicid = $categoria";

            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getProductosAlT($categoria){
            $this->con = new Mysql();
            $sql = "SELECT s.idsubtopic,
                            s.topicid, 
                            s.title as categoria,
                            t.idtechnique,
                            t.topicid,
                            t.title as subcategoria,
                            p.idproduct,
                            p.topicid,
                            p.subtopicid,
                            p.techniqueid,
                            p.title,
                            p.price,
                            p.route,
                            p.stock,
                            p.status
                    FROM product p
                    INNER JOIN techniques t, subtopics s
                    WHERE s.topicid = p.topicid AND 
                            t.topicid = p.topicid AND 
                            s.idsubtopic = p.subtopicid AND
                            t.idtechnique = p.techniqueid AND
                            p.status != 0 AND p.topicid = $categoria
                    ORDER BY RAND() limit 3";
            $request = $this->con->select_all($sql);
            if(count($request)){
                for ($i=0; $i < count($request) ; $i++) { 
                    $intProducto = $request[$i]['idproduct'];
                    $sql ="SELECT * FROM productimage
                            WHERE productid = $intProducto limit 1";
                    $requestImage = $this->con->select_all($sql);
                    $request[$i]['url_image'] = media()."/images/uploads/".$requestImage[0]['title'];
                    $request[$i]['price'] = number_format($request[$i]['price'],0,DEC,MIL);
                }
            }
            return $request;
            
        }
        public function getProductInfo($idproducto,$atributo){
            $this->intIdProducto = $idproducto;
            $this->con = new Mysql();

            $sql =  "SELECT s.idsubtopic,
                            s.topicid, 
                            s.title as categoria,
                            t.idtechnique,
                            t.topicid,
                            t.title as subcategoria,
                            p.idproduct,
                            p.reference,
                            p.topicid,
                            p.subtopicid,
                            p.techniqueid,
                            p.title,
                            p.price,
                            p.route,
                            p.status
                    FROM product p
                    INNER JOIN techniques t, subtopics s
                    WHERE s.topicid = p.topicid AND 
                            t.topicid = p.topicid AND 
                            s.idsubtopic = p.subtopicid AND
                            t.idtechnique = p.techniqueid AND
                            p.status != 0 AND p.idproduct = $this->intIdProducto";
            $request = $this->con->select($sql);
            $sqlImg = "SELECT * FROM productimage WHERE productid = $request[idproduct]";
            $img = $this->con->select($sqlImg);
            $sqlAt="SELECT * FROM attribute WHERE idattribute = $atributo";
            $att = $this->con->select($sqlAt);
            if($att!=""){
                $request['atributo'] = $att['title'];
                $request['idatributo'] = $att['idattribute'];
            }
            $request['imagen'] = media()."/images/uploads/".$img['title'];
            return $request;
        }
        public function selectAtributo(int $idAtributo){
            $this->con = new Mysql();
			$sql = "SELECT a.idattribute,
                            a.topicid,
                            a.subtopicid,
                            a.title as titulo,
                            a.price,
                            t.idtopic,
                            s.idsubtopic,
                            s.title
                    FROM attribute a
                    INNER JOIN topics t, subtopics s
                    WHERE a.topicid = t.idtopic AND a.subtopicid = s.idsubtopic AND a.idattribute=$idAtributo";
			$request = $this->con->select($sql);
			return $request;
		}
        public function getProductSearch($busqueda){
            $this->con = new Mysql();
            $query = "SELECT COUNT(*) as total FROM product WHERE title LIKE '%$busqueda%' AND stock !=0";
            $total = $this->con->select($query);

            $sql = "SELECT 
                        s.idsubtopic,
                        s.topicid, 
                        s.title as categoria,
                        t.idtechnique,
                        t.topicid,
                        t.title as subcategoria,
                        p.idproduct,
                        p.topicid,
                        p.subtopicid,
                        p.techniqueid,
                        p.title,
                        p.price,
                        p.route,
                        p.stock,
                        p.status
                    FROM product p
                    INNER JOIN techniques t, subtopics s
                    WHERE p.title LIKE '%$busqueda%'  
                            AND s.topicid = p.topicid AND 
                            t.topicid = p.topicid AND 
                            s.idsubtopic = p.subtopicid AND
                            t.idtechnique = p.techniqueid AND
                            p.status != 0
                    ORDER BY p.title DESC";
            $request = $this->con->select_all($sql);
            if(count($request)){
                for ($i=0; $i < count($request) ; $i++) { 
                    $intProducto = $request[$i]['idproduct'];
                    $sqlimg ="SELECT * FROM productimage
                            WHERE productid = $intProducto limit 1";
                    $requestImage = $this->con->select_all($sqlimg);
                    $request[$i]['url_image'] = media()."/images/uploads/".$requestImage[0]['title'];
                    $request[$i]['price'] = number_format($request[$i]['price'],0,DEC,MIL);
                }
            }
            
            $request['productos'] = $request;
            $request['total'] = $total;
            return $request;
        }*/
    }

?>