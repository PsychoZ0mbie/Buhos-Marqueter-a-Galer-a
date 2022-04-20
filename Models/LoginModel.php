<?php 

	class LoginModel extends Mysql
	{
        private $intIdUsuario;
        private $strUsuario;
        private $strPassword;
        private $strToken;

		public function __construct()
		{
			parent::__construct();
        }	
        
        public function loginUser(string $usuario, string $password)
		{
			$this->strUsuario = $usuario;
			$this->strPassword = $password;
			$sql = "SELECT idperson,email FROM person WHERE 
					email = '$this->strUsuario' and 
					password = '$this->strPassword'";
			$request = $this->select($sql);
			return $request;
        }
        
        public function sessionLogin(int $iduser){
            $this->intIdUsuario = $iduser;
            //BUSCAR ROL
            $sql = "SELECT  idperson,
                            firstname,
                            lastname,
                            picture,
                            phone,
                            address,
                            email,
                            department,
                            city,
                            identification,
                            roleid
                    FROM person p
                    WHERE idperson = $this->intIdUsuario";
            $request = $this->select($sql);
            $_SESSION['userData'] = $request;
            return $request;
        }

        public function getUserEmail(string $email){
            $this->strUsuario = $email;
            $sql = "SELECT idperson, firstname, lastname FROM person WHERE
                    email='$this->strUsuario'";
            $request = $this->select($sql);
            return $request;
        }

        public function setTokenUser(int $idpersona,string $token){
            $this->intIdUsuario = $idpersona;
            $this->strToken = $token;
            $sql = "UPDATE person SET token = ? WHERE idperson = $this->intIdUsuario";
            $arrData = array($this->strToken);
            $request = $this->update($sql,$arrData);
            return $request;
        }

        public function getUsuario(string $email, string $token){
            $this->strUsuario=$email;
            $this->strToken = $token;
            $sql ="SELECT idperson FROM person WHERE
                    email = '$this->strUsuario' and token= '$this->strToken'";
            $request =$this->select($sql);
            return $request;
        }

        public function insertPassword(int $idpersona, string $pass){
            $this->intIdUsuario = $idpersona;
            $this->strPassword = $pass;
            $sql = "UPDATE person SET password = ?, token = ? WHERE idperson = $this->intIdUsuario";
            $arrData = array($this->strPassword,"");
            $request = $this->update($sql,$arrData);
            return $request;
        }
	}
 ?>