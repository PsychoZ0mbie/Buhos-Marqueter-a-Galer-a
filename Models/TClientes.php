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


        public function registroCliente($strNombre,$strApellido,$strEmail,$strPassword,$rolid){
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
                $query = "INSERT INTO person(firstname,lastname,email,password,roleid) VALUE(?,?,?,?,?)";
                $arrData = array($this->strNombre,
                                $this->strApellido,
                                $this->strEmail,
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
                    $query = "INSERT INTO tempdetail(personid,
                                                    productid,
                                                    attributeid,
                                                    subtopicid,
                                                    title,
                                                    price,
                                                    quantity,
                                                    length,
                                                    width,
                                                    subtopic,
                                                    type,
                                                    transactionid)
                            VALUE(?,?,?,?,?,?,?,?,?,?,?,?)";
                    $arrData = array($this->intIdUser,
                                    $pro['idproducto'],
                                    $pro['idatributo'],
                                    $pro['idsubcategoria'],
                                    $pro['nombre'],
                                    $pro['precio'],
                                    $pro['cantidad'],
                                    $pro['largo'],
                                    $pro['ancho'],
                                    $pro['subcategoria'],
                                    $pro['tipo'],
                                    $this->intIdTransaccion
                                    );
                    $request_insert = $this->con->insert($query,$arrData);
                }
            }else{
                $sqlDel = "DELETE FROM tempdetail
                    WHERE personid = $this->intIdUser 
                    AND transactionid = '$this->intIdTransaccion'";
                $requestDel = $this->con->delete($sqlDel);
                foreach ($productos as $pro) {
                    $query = "INSERT INTO tempdetail(personid,
                                                    productid,
                                                    attributeid,
                                                    subtopicid,
                                                    title,
                                                    price,
                                                    quantity,
                                                    length,
                                                    width,
                                                    subtopic,
                                                    type,
                                                    transactionid)
                            VALUE(?,?,?,?,?,?,?,?,?,?,?,?)";
                    $arrData = array($this->intIdUser,
                                    $pro['idproducto'],
                                    $pro['idatributo'],
                                    $pro['idsubcategoria'],
                                    $pro['nombre'],
                                    $pro['precio'],
                                    $pro['cantidad'],
                                    $pro['largo'],
                                    $pro['ancho'],
                                    $pro['subcategoria'],
                                    $pro['tipo'],
                                    $this->intIdTransaccion
                                    );
                    $request_insert = $this->con->insert($query,$arrData);
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

        public function insertPedidoDetail($idpedido,$idUser,$idproducto,$nombre,$precio,$cantidad,$largo,$ancho,$subcategoria,$tipo){
            $this->con = new Mysql();
            $sql = "INSERT INTO orderdetail(orderdataid,personid,productid,title,price,quantity,length,width,subtopic,type)
                    VALUE(?,?,?,?,?,?,?,?,?,?)";

            $arrData = array($idpedido,
                            $idUser,
                            $idproducto,
                            $nombre,
                            $precio,
                            $cantidad,
                            $largo,
                            $ancho,
                            $subcategoria,
                            $tipo);
            $request = $this->con->insert($sql,$arrData);
            return $request;
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
                            o.date,
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
                                        o.title,
                                        o.price,
                                        o.quantity,
                                        o.length,
                                        o.width,
                                        o.subtopic,
                                        o.type,
                                        p.idproduct
                                FROM orderdetail o
                                INNER JOIN product p
                                WHERE p.idproduct = o.productid AND o.orderdataid = $pedido";
                $request_detalle = $this->con->select_all($sqlDetalle);
                $request = array("orden" => $request_pedido, "detalle" => $request_detalle); 
            }
            return $request;
        }
                                                                                      
    }   
?>