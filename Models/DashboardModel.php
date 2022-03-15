<?php 

	class DashboardModel extends Mysql
	{
		public function __construct(){
			parent::__construct();
		}

        public function selectUsuarios(){
            $sql ="SELECT COUNT(*) as total FROM persona WHERE status =1";
            $request=$this->select($sql);
            $total = $request['total'];
            return $total;
        }
        public function selectArticulos(){
            $sql ="SELECT COUNT(*) as total FROM post WHERE status =1";
            $request=$this->select($sql);
            $total = $request['total'];
            return $total;
        }
        public function selectSuscripciones(){
            $sql ="SELECT COUNT(*) as total FROM suscriptions";
            $request=$this->select($sql);
            $total = $request['total'];
            return $total;
        }
        public function selectContactos(){
            $sql ="SELECT COUNT(*) as total FROM contact";
            $request=$this->select($sql);
            $total = $request['total'];
            return $total;
        }
	}
 ?>