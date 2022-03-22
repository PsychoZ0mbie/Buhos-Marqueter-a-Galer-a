<?php
    require_once("Models/TClientes.php");
    class Contacto extends Controllers{
        use TClientes;
        public function __construct(){
            parent::__construct();
            session_start();
        }

        public function Contacto(){
            $data['page_tag'] = "Contacto | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Contacto | ".NOMBRE_EMPRESA;
			$data['page_name'] = "contacto";
            $this->views->getView($this,"contacto",$data);
        }

        public function setContacto(){
            if($_POST){

                $strNombre = ucwords(strClean($_POST['txtNombre']));
                $strApellido = ucwords(strClean($_POST['txtApellido']));
                $strEmail = strtolower(strClean($_POST['txtEmail']));
                $strTelefono = strClean($_POST['txtTelefono']);
                $mensaje = strClean($_POST['txtComentario']);
                $useragent = $_SERVER['HTTP_USER_AGENT'];
				$ip        = $_SERVER['REMOTE_ADDR'];
				$dispositivo= "PC";

				if(preg_match("/mobile/i",$useragent)){
					$dispositivo = "Movil";
				}else if(preg_match("/tablet/i",$useragent)){
					$dispositivo = "Tablet";
				}else if(preg_match("/iPhone/i",$useragent)){
					$dispositivo = "iPhone";
				}else if(preg_match("/iPad/i",$useragent)){
					$dispositivo = "iPad";
				}

                $request = $this->setMensaje($strNombre,$strApellido,$strEmail,$strTelefono,$mensaje,$ip,$dispositivo,$useragent);
                if($request > 0){
                    $dataEmail = array('email_remitente' => EMAIL_REMITENTE, 
                                            'email_usuario'=>$strEmail, 
                                            'email_copia'=>EMAIL_REMITENTE,
                                            'asunto' =>'Se ha enviado un nuevo mensaje',
                                            "mensaje"=>$mensaje,
                                            'nombre'=>$strNombre,
                                            'apellido'=>$strApellido,
                                            'telefono'=>$strTelefono);
                    sendEmail($dataEmail,'email_contacto');
                    $arrResponse = array("status"=>true,"msg"=>"El mensaje se ha enviado");
                }else{
                    $arrResponse = array("status"=>false,"msg"=>"No se ha podido enviar el mensaje");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>