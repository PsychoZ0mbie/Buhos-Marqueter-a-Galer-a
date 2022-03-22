<?php
    class MensajeModel extends Mysql{

        public function __construct(){
            parent::__construct();
        }

        public function selectMensajes(){
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
                            FROM contact";
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
        
    }
?>