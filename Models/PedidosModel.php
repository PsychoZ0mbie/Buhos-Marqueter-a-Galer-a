<?php
    class PedidosModel extends Mysql{
        private $intIdpedido;
        private $intIdpersona;
        public function __construct(){
            parent::__construct();
        }

        public function selectPedidos(){
            $sql = "SELECT idorderdata,
                            firstname,
                            lastname,
                            personid,
                            DATE_FORMAT(date, '%d-%m-%Y') as date,
                            price,
                            status
                    FROM orderdata";

            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPedido($idpedido,$idpersona){
            $this->intIdpedido = $idpedido;
            $this->intIdpersona = $idpersona;
            $sql = "SELECT o.idorderdata,
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
                            d.title,
                            d.price,
                            d.quantity,
                            d.length,
                            d.width,
                            d.subtopic,
                            d.type,
                            o.idorderdata,
                            o.personid
                    FROM orderdetail d
                    INNER JOIN orderdata o
                    ON d.orderdataid = o.idorderdata AND d.personid = o.personid
                    WHERE d.orderdataid = $this->intIdpedido AND d.personid = $this->intIdpersona";
            $request = $this->select_all($sql);
            return $request;
        }
    }
?>