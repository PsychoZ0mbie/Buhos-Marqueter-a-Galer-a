<?php
    require_once("Libraries/Core/Mysql.php");
    trait TClientes{
        private $con;
        private $intIdUser;
        private $intIdTransaccion;
        private $strNombre;
        private $strApellido;
        private $strEmail;
        private $strPassword;
        private $intRolId;
        private $intIdentificacion;
        private $intDepartamento;
        private $intCiudad;
        private $strDireccion;
        private $strComentario;
        private $intTelefono;
        private $intPrice;
        private $strStatus;
        private $strTipoPago;


        public function registroCliente($strNombre,$strApellido,$strPicture,$strEmail,$strPassword,$rolid){
            $this->con = new Mysql();
            $this->strNombre = $strNombre;
            $this->strApellido = $strApellido;
            $this->strEmail = $strEmail;
            $this->strPassword = $strPassword;
            $this->intRolId = $rolid;
            $return="";
            
            $sql = "SELECT * FROM person WHERE email = '$this->strEmail'";
            $request = $this->con->select_all($sql);
            if(empty($request)){
                $query = "INSERT INTO person(firstname,lastname,picture,email,department,city,password,roleid) VALUE(?,?,?,?,?,?,?,?)";
                $arrData = array($this->strNombre,
                                $this->strApellido,
                                $strPicture,
                                $this->strEmail,
                                5,
                                1,
                                $this->strPassword,
                                $this->intRolId
                                );
                $request_insert = $this->con->insert($query,$arrData);
                $return = $request_insert;
            }else{
                $return ="exist";
            }
            return $return;
        }
        public function insertDetalleTemp(array $arrPedido){
            $this->con = new Mysql();
            $this->intIdUser = $arrPedido['idcliente'];
            $this->intIdTransaccion = $arrPedido['idtransaccion'];
            $productos = $arrPedido['productos'];

            $sql = "SELECT * FROM tempdetail
                    WHERE personid=$this->intIdUser 
                    AND transactionid = '$this->intIdTransaccion'";
            $request = $this->con->select_all($sql);
            if(empty($request)){
                foreach ($productos as $pro) {
                    if($pro['idcategoria'] == 2){

                        $query = "INSERT INTO tempdetail(personid,productid,topicid,title,author,dimensions,technique,quantity,price,transactionid)
                                VALUE(?,?,?,?,?,?,?,?,?,?)";
                        $arrData=array($this->intIdUser,
                                        $pro['idproducto'],
                                        $pro['idcategoria'],
                                        $pro['titulo'],
                                        $pro['autor'],
                                        $pro['dimensiones'],
                                        $pro['tecnica'],
                                        $pro['cantidad'],
                                        $pro['precio'],
                                        $this->intIdTransaccion);
                        $requestPro = $this->con->insert($query,$arrData);
                    }else if($pro['idcategoria'] == 1){
                        $query = "INSERT INTO tempdetail(personid,productid,topicid,title,margintype,bordertype,glasstype,margin,measureimage,
                                            measureframe,quantity,price,transactionid)
                                VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        $arrData=array($this->intIdUser,
                                        $pro['idproducto'],
                                        $pro['idcategoria'],
                                        $pro['referenciaMoldura'],
                                        $pro['tipoMargen'],
                                        $pro['tipoBorde'],
                                        $pro['tipoVidrio'],
                                        $pro['margen'],
                                        $pro['medidasImagen'],
                                        $pro['medidasMarco'],
                                        $pro['cantidad'],
                                        $pro['precio'],
                                        $this->intIdTransaccion);
                        $requestPro = $this->con->insert($query,$arrData);
                    }
                }
            }else{
                $sqlDel = "DELETE FROM tempdetail
                    WHERE personid = $this->intIdUser 
                    AND transactionid = '$this->intIdTransaccion'";
                $requestDel = $this->con->delete($sqlDel);
                foreach ($productos as $pro) {
                    if($pro['idcategoria'] == 2){

                        $query = "INSERT INTO tempdetail(personid,productid,topicid,title,author,dimensions,technique,quantity,price,transactionid)
                                VALUE(?,?,?,?,?,?,?,?,?,?)";
                        $arrData=array($this->intIdUser,
                                        $pro['idproducto'],
                                        $pro['idcategoria'],
                                        $pro['titulo'],
                                        $pro['autor'],
                                        $pro['dimensiones'],
                                        $pro['tecnica'],
                                        $pro['cantidad'],
                                        $pro['precio'],
                                        $this->intIdTransaccion);
                        $requestPro = $this->con->insert($query,$arrData);
                    }else if($pro['idcategoria'] == 1){
                        $query = "INSERT INTO tempdetail(personid,productid,topicid,title,margintype,bordertype,glasstype,margin,measureimage,
                                            measureframe,quantity,price,transactionid)
                                VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        $arrData=array($this->intIdUser,
                                        $pro['idproducto'],
                                        $pro['idcategoria'],
                                        $pro['referenciaMoldura'],
                                        $pro['tipoMargen'],
                                        $pro['tipoBorde'],
                                        $pro['tipoVidrio'],
                                        $pro['margen'],
                                        $pro['medidasImagen'],
                                        $pro['medidasMarco'],
                                        $pro['cantidad'],
                                        $pro['precio'],
                                        $this->intIdTransaccion);
                        $requestPro = $this->con->insert($query,$arrData);
                    }
                }
            }
        }
        public function insertPedido($idUser,$strNombre,$strApellido,$intIdentificacion,$strEmail,$intDepartamento,$intCiudad,$strDireccion,$strComentario,$intTelefono,$intPrice,$status){
            $this->con = new Mysql;
            $this->intIdUser = $idUser;
            $this->strNombre = $strNombre;
            $this->strApellido = $strApellido;
            $this->intIdentificacion = $intIdentificacion;
            $this->strEmail = $strEmail;
            $this->intDepartamento = $intDepartamento;
            $this->intCiudad = $intCiudad;
            $this->strDireccion = $strDireccion;
            $this->strComentario = $strComentario;
            $this->intTelefono = $intTelefono;
            $this->intPrice = $intPrice;
            $this->strStatus = $status;
            $sql = "INSERT INTO orderdata(personid,firstname,lastname,identification,email,departmentid,cityid,address,comment,phone,price,status)
                    VALUE(?,?,?,?,?,?,?,?,?,?,?,?)";
            $arrData = array($this->intIdUser,
                            $this->strNombre,
                            $this->strApellido,
                            $this->intIdentificacion,
                            $this->strEmail,
                            $this->intDepartamento,
                            $this->intCiudad,
                            $this->strDireccion,
                            $this->strComentario,
                            $this->intTelefono,
                            $this->intPrice,
                            $this->strStatus
                            );
            $request = $this->con->insert($sql,$arrData);
            return $request;
        }
        public function insertPedidoDetail(array $arrPedido){
            $this->con = new Mysql();
            $this->intIdUser = $arrPedido['idusuario'];
            $intIdPedido = $arrPedido['idpedido'];
            $productos = $arrPedido['productos'];
            foreach ($productos as $pro) {
                if($pro['idcategoria'] == 2){

                    $query = "INSERT INTO orderdetail(orderdataid,personid,productid,topicid,title,author,dimensions,technique,quantity,price)
                            VALUE(?,?,?,?,?,?,?,?,?,?)";
                    $arrData=array($intIdPedido,
                                    $this->intIdUser,
                                    $pro['idproducto'],
                                    $pro['idcategoria'],
                                    $pro['titulo'],
                                    $pro['autor'],
                                    $pro['dimensiones'],
                                    $pro['tecnica'],
                                    $pro['cantidad'],
                                    $pro['precio'],
                                    );
                    $requestPro = $this->con->insert($query,$arrData);
                }else if($pro['idcategoria'] == 1){
                    $query = "INSERT INTO orderdetail(orderdataid,personid,productid,topicid,picture,title,margintype,bordertype,glasstype,margin,measureimage,
                                        measureframe,print,quantity,price)
                            VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                    $arrData=array($intIdPedido,
                                    $this->intIdUser,
                                    $pro['idproducto'],
                                    $pro['idcategoria'],
                                    $pro['img'],
                                    $pro['referenciaMoldura'],
                                    $pro['tipoMargen'],
                                    $pro['tipoBorde'],
                                    $pro['tipoVidrio'],
                                    $pro['margen'],
                                    $pro['medidasImagen'],
                                    $pro['medidasMarco'],
                                    $pro['impresion'],
                                    $pro['cantidad'],
                                    $pro['precio'],
                                    );
                    $requestPro = $this->con->insert($query,$arrData);
                }
            }
            return $requestPro;
        }
        public function updatePedido($idpedido,$payment,$status){
            $this->con = new Mysql();
            $sql = "UPDATE orderdata SET paymenttype=?, status=? WHERE idorderdata = $idpedido";
            $array = array($payment,$status);
            $request = $this->con->update($sql,$array);
        }
        public function updateProducto($idproducto){
            $this->con = new Mysql();
            $sql = "UPDATE product SET status = ? WHERE idproduct = $idproducto";
            $array =array(2);
            $this->con->update($sql,$array);
        }
        public function getPedido($pedido){
            $this->con = new Mysql();
            $sql = "SELECT o.idorderdata,
                            o.personid,
                            o.firstname,
                            o.lastname,
                            o.identification,
                            o.email,
                            o.departmentid,
                            o.cityid,
                            o.address,
                            o.comment,
                            o.phone,
                            DATE_FORMAT(o.date, '%d-%m-%Y') as date,
                            o.price,
                            o.status,
                            d.iddepartment,
                            c.idcity,
                            d.department as departamento,
                            c.city as ciudad
                    FROM orderdata o
                    INNER JOIN department d, city c
                    WHERE o.idorderdata = $pedido
                    AND o.departmentid = d.iddepartment AND o.cityid = c.idcity";
            $request_pedido = $this->con->select($sql);
            if(count($request_pedido) > 0){
                $sqlDetalle = "SELECT o.orderdataid,
                                        o.personid,
                                        o.productid,
                                        o.topicid,
                                        o.title,
                                        o.price,
                                        o.author,
                                        o.dimensions,
                                        o.technique,
                                        o.margintype,
                                        o.bordertype,
                                        o.glasstype,
                                        o.margin,
                                        o.measureimage,
                                        o.measureframe,
                                        o.print,
                                        o.quantity,
                                        o.price,
                                        p.idproduct
                                FROM orderdetail o
                                INNER JOIN product p
                                WHERE p.idproduct = o.productid AND o.orderdataid = $pedido";
                $request_detalle = $this->con->select_all($sqlDetalle);
                $request = array("orden" => $request_pedido, "detalle" => $request_detalle); 
            }
            return $request;
        }
        public function setMensaje($strNombre,$strApellido,$strEmail,$strTelefono,$mensaje,$ip,$dispositivo,$useragent){
            $this->con = new Mysql();
            $sql = "INSERT INTO contact(firstname,lastname,email,phone,message,ip,device,useragent) VALUE(?,?,?,?,?,?,?,?)";
            $arrData = array($strNombre,
                            $strApellido,
                            $strEmail,
                            $strTelefono,
                            $mensaje,
                            $ip,
                            $dispositivo,
                            $useragent);
            $request = $this->con->insert($sql,$arrData);
            return $request;
        }
        public function selectDepartamento(){
            $this->con= new Mysql();
			$sql ="SELECT * FROM department";
			$request = $this->con->select_all($sql);
			return $request;
		}
		public function selectCiudad($deparment){
            $this->con= new Mysql();
			$sql = "SELECT * FROM city WHERE departmentid = $deparment";
			$request = $this->con->select_all($sql);
			return $request;
		}
        public function deleteDetalleTemp($idUser){
            $this->intIdUser = $idUser;
            $this->con = new Mysql();
            $sql = "DELETE FROM tempdetail
                WHERE personid = $this->intIdUser";
            $requestDel = $this->con->delete($sql);
        }
                                                                                      
    }   
?>