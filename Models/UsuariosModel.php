<?php 

	class UsuariosModel extends Mysql
	{
		private $intIdUsuario;
		private $strNombre;
		private $strApellido;
		private $strPicture;
		private $intTelefono;
		private $strAddress;
		private $strEmail;
		private $intDepartmentId;
		private $intCityId;
		private $intTypeId;
		private $strIdentification;
		private $strPassword;
		private $strToken;
		private $intTipoId;
		private $strRolName;

		public function __construct(){
			parent::__construct();
		}	

		public function insertUsuario(string $nombre, string $apellido,string $picture, int $telefono, string $email, string $password, int $tipoid,string $rolName){

			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->strPicture = $picture;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->strRolName = $rolName;
			$return = 0;

			$sql = "SELECT * FROM person WHERE 
					email = '{$this->strEmail}' or phone = '{$this->intTelefono}'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO person(firstname,lastname,picture,phone,email,password,roleid,rolname) 
								  VALUES(?,?,?,?,?,?,?,?)";
	        	$arrData = array($this->strNombre,
        						$this->strApellido,
								$this->strPicture,
        						$this->intTelefono,
        						$this->strEmail,
        						$this->strPassword,
        						$this->intTipoId,
								$this->strRolName);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}

		public function selectUsuarios(){
			$sql = "SELECT idperson, firstname, lastname,picture, phone, email, roleid,rolname
			FROM person ORDER BY idperson DESC";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectUsuariosPicker(){
			$sql = "SELECT idperson, firstname, lastname, roleid FROM person WHERE roleid != 2";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectUsuario(int $idpersona){
			$this->intIdUsuario = $idpersona;
			$sql = "SELECT idperson,
			firstname,
			lastname,
			picture,
			phone,
			address,
			email,
			department,
			city,
			identification,
			roleid,
			rolname, 
			DATE_FORMAT(datecreated, '%d/%m/%Y') as date 
			FROM person 
			WHERE idperson = $this->intIdUsuario";
			$request = $this->select($sql);
			return $request;
		}

		public function updateUsuario(int $idUsuario, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid){

			$this->intIdUsuario = $idUsuario;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;

			$sql = "SELECT * FROM person WHERE (email = '{$this->strEmail}' AND idperson != $this->intIdUsuario)";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				if($this->strPassword  != "")
				{
					$sql = "UPDATE person SET firstname=?, lastname=?, phone=?, email=?, password=?, roleid=? 
							WHERE idperson = $this->intIdUsuario ";
					$arrData = array($this->strNombre,
	        						$this->strApellido,
	        						$this->intTelefono,
	        						$this->strEmail,
	        						$this->strPassword,
	        						$this->intTipoId);
				}else{
					$sql = "UPDATE persona SET firstname=?, lastname=?, phone=?, email=?, roleid=? 
							WHERE idperson = $this->intIdUsuario ";
					$arrData = array($this->strNombre,
	        						$this->strApellido,
	        						$this->intTelefono,
	        						$this->strEmail,
	        						$this->intTipoId);
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		
		}

		public function deleteUsuario(int $intIdpersona)
		{
			$this->intIdUsuario = $intIdpersona;
			$sql = "DELETE FROM person WHERE idperson = $this->intIdUsuario;set @autoid :=0; 
			update person set idperson = @autoid := (@autoid+1);
			alter table person Auto_Increment = 1";
			$request = $this->delete($sql);
			return $request;
		}

		public function updatePerfil(int $idUsuario, string $nombre,string $apellido, string $foto, int $telefono, string $direccion,
			 int $department, int $city, string $identification, string $password){

			$this->intIdUsuario = $idUsuario;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->strPicture = $foto;
			$this->intTelefono = $telefono;
			$this->strAddress = $direccion;
			$this->intDepartmentId = $department;
			$this->intCityId = $city;
			$this->strIdentification = $identification;
			$this->strPassword = $password;

			if($this->strPassword != ""){
				$sql = "UPDATE person SET 
								firstname=?,
								lastname=?, 
								picture=?, 
								phone=?,
								address=?,
								departmentid=?,
								cityid=?,
								identification=?,
								password=?
						WHERE idperson = $this->intIdUsuario";
				$arrData = array($this->strNombre,
								$this->strApellido,
								$this->strPicture,
								$this->intTelefono,
								$this->strAddress,
								$this->intDepartmentId,
								$this->intCityId,
								$this->strIdentification,
								$this->strPassword);

			}else{
				$sql = "UPDATE person SET 
								firstname=?, 
								lastname=?, 
								picture=?, 
								phone=?,
								address=?,
								departmentid=?,
								cityid=?,
								identification=?
						WHERE idperson = $this->intIdUsuario";
				$arrData = array($this->strNombre,
								$this->strApellido,
								$this->strPicture,
								$this->intTelefono,
								$this->strAddress,
								$this->intDepartmentId,
								$this->intCityId,
								$this->strIdentification,
								);
			}
			$request = $this->update($sql,$arrData);
			return $request;
		}
		public function selectId(){
			$sql ="SELECT * FROM identification";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectDepartamento(){
			$sql ="SELECT * FROM department";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectCiudad($deparment){
			$sql = "SELECT * FROM city WHERE departmentid = $deparment";
			$request = $this->select_all($sql);
			return $request;
		}
	}
 ?>