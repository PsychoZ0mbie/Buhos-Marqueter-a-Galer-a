<?php 

	class RolesModel extends Mysql
	{
        public $intIdrol;
		public $strRol;
		public function __construct()
		{
			parent::__construct();
		}
        
        public function selectRoles(){
			$whereAdmin = "";
			/*if($_SESSION['idUser'] != 1){
				$whereAdmin = " idrole !=1";
			}*/
            $sql ="SELECT * FROM role ";//.$whereAdmin;
            $request = $this->select_all($sql);
            return $request;
        }

        public function insertRol(string $rol){

			$return = "";
			$this->strRol = $rol;

			$sql = "SELECT * FROM role WHERE role = '{$this->strRol}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO role(role) VALUES(?)";
	        	$arrData = array($this->strRol);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

        public function updateRol(int $idrol, string $rol){
			$this->intIdrol = $idrol;
			$this->strRol = $rol;

			$sql = "SELECT * FROM role WHERE role = '$this->strRol' AND idrole != $this->intIdrol";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE role SET role = ? WHERE idrole = $this->intIdrol ";
				$arrData = array($this->strRol);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}
        public function deleteRol(int $idrol){
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM person WHERE roleid = $this->intIdrol";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "DELETE FROM role WHERE idrole = $this->intIdrol;set @autoid :=0; 
				update role set idrole = @autoid := (@autoid+1);
				alter table role Auto_Increment = 1";
				$request = $this->delete($sql);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			}else{
				$request = 'exist';
			}
			return $request;
		}

        public function selectRol($idrol){ 
		  
			//BUSCAR ROLE
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM role WHERE idrole = $this->intIdrol";
			$request = $this->select($sql);
			return $request;
		}
	}
 ?>