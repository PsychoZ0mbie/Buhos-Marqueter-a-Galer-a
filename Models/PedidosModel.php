<?php
    class PedidosModel extends Mysql{
        private $intIdpedido;
        private $intIdpersona;
        private $strEstado;
        public function __construct(){
            parent::__construct();
        }

        public function selectPedidos($options,$idpersona,$idrol){
            $datos="";
            if($options == 1){
				$options=" ORDER BY idorderdata DESC";
			}else if($options == 2){
				$options=" ORDER BY idorderdata ASC";
			}else if($options == 3){
				$options=" ORDER BY status";
			}else{
				$options=" ORDER BY idorderdata DESC";
			}
            if($idrol==1){
                $datos="";
            }else{
                $datos=" WHERE personid = $idpersona";
            }
            $sql = "SELECT idorderdata,
                            firstname,
                            lastname,
                            personid,
                            email,
                            phone,
                            DATE_FORMAT(date, '%Y-%m-%d') as date,
                            price,
                            status
                    FROM orderdata $datos $options";

            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPedido($idpedido,$idpersona){
            $this->intIdpedido = $idpedido;
            $this->intIdpersona = $idpersona;
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
                            DATE_FORMAT(o.date, '%Y-%m-%d') as date,
                            o.price,
                            o.paymenttype,
                            o.status,
                            c.idcity,
                            c.city as ciudad,
                            d.iddepartment,
                            d.department as departamento
                    FROM orderdata o
                    INNER JOIN city c, department d
                    WHERE idorderdata = $this->intIdpedido 
                    AND c.idcity=o.cityid 
                    AND d.iddepartment = o.departmentid
                    AND o.personid = $this->intIdpersona";
            $request = $this->select($sql);
            return $request;
        }

        public function selectPedidoDetalle($idpedido,$idpersona){
            $this->intIdpedido = $idpedido;
            $this->intIdpersona = $idpersona;
            $sql = "SELECT d.id,
                            d.orderdataid,
                            d.personid,
                            d.productid,
                            d.topicid,
                            d.picture,
                            d.title,
                            d.author,
                            d.dimensions,
                            d.technique,
                            d.margintype,
                            d.bordertype,
                            d.glasstype,
                            d.margin,
                            d.measureimage,
                            d.measureframe,
                            d.print,
                            d.quantity,
                            d.price,
                            o.idorderdata,
                            o.personid
                    FROM orderdetail d
                    INNER JOIN orderdata o
                    ON d.orderdataid = o.idorderdata AND d.personid = o.personid
                    WHERE d.orderdataid = $this->intIdpedido AND d.personid = $this->intIdpersona";
            $request = $this->select_all($sql);
            return $request;
        }

        public function updatePedido($idpedido,$idpersona,$estado){
            $this->intIdpedido = $idpedido;
            $this->intIdpersona = $idpersona;
            $this->strEstado = $estado;

            $sql = "UPDATE orderdata SET status=? 
                    WHERE idorderdata = $this->intIdpedido AND personid=$this->intIdpersona";
            $arrData = array($this->strEstado);
            $request = $this->update($sql,$arrData);
            return $request;
        }

        public function deletePedido($idpedido,$idpersona){
            $this->intIdpedido = $idpedido;
            $this->intIdpersona = $idpersona;

            $sql = "DELETE FROM orderdata WHERE idorderdata = $this->intIdpedido AND personid = $this->intIdpersona";
            $request = $this->delete($sql);
            return $request;
        }
    }
?>