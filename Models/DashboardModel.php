<?php 

	class DashboardModel extends Mysql
	{
		public function __construct(){
			parent::__construct();
		}

        public function selectClientes(){
            $sql ="SELECT COUNT(*) as total FROM person WHERE roleid = 2";
            $request=$this->select($sql);
            $total = $request['total'];
            return $total;
        }
        public function selectPedidos(){
            $sql ="SELECT COUNT(*) as total FROM orderdata";
            $request=$this->select($sql);
            $total = $request['total'];
            return $total;
        }
        public function selectMensajes(){
            $sql ="SELECT COUNT(*) as total FROM contact";
            $request=$this->select($sql);
            $total = $request['total'];
            return $total;
        }
        public function selectProductos(){
            $sql ="SELECT COUNT(*) as total FROM product";
            $request=$this->select($sql);
            $total = $request['total'];
            return $total;
        }

        public function selPedidos(){
            $sql="SELECT idorderdata,personid,firstname,lastname,status,price FROM orderdata ORDER BY idorderdata DESC LIMIT 10";
            $request = $this->select_all($sql);
            if(count($request)>0){
                for ($i=0; $i < count($request); $i++) { 
                    $request[$i]['price'] = MS.number_format($request[$i]['price'],0,DEC,MIL);
                }
            }
            return $request;
        }

        public function selectVentas(){
            $sql ="SELECT * FROM orderdata WHERE status ='Enviado'";
            $request=$this->select_all($sql);
            $total=0;
            if(count($request)>0){
                for ($i=0; $i < count($request) ; $i++) { 
                    $total+=$request[$i]['price'];
                }
            }
            $total = MS.number_format($total,0,DEC,MIL);
            return $total;
        }
	}
 ?>