<?php
    class MensajeModel extends Mysql{

        public function __construct(){
            parent::__construct();
        }

        public function selectMensajes($options){
            if($options == 1){
				$options=" ORDER BY id DESC";
			}else if($options == 2){
				$options=" ORDER BY id ASC";
			}else if($options == 3){
				$options=" ORDER BY firstname";
			}else{
				$options=" ORDER BY id DESC";
			}

            $sql = "SELECT  id,
                            firstname,
                            lastname,
                            email,
                            phone,
                            message,
                            ip,
                            device,
                            useragent,
                            DATE_FORMAT(date, '%Y-%m-%d') as date
                            FROM contact
                            $options";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectMensaje($id){
            $sql = "SELECT  id,
                            firstname,
                            lastname,
                            email,
                            phone,
                            message,
                            ip,
                            device,
                            useragent,
                            DATE_FORMAT(date, '%Y-%m-%d') as date
                            FROM contact WHERE id=$id";
            $request = $this->select($sql);
            return $request;
        }
        public function deleteMensaje($id){
            $sql = "DELETE FROM contact WHERE id = $id";
            $request = $this->delete($sql);
            return $request;
        }
    }
?>