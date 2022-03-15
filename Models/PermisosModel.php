<?php 

	class PermisosModel extends Mysql
	{   
        public $intIdpermiso;
        public $intRolid;
        public $intModuloid;
        public $r;
        public $w;
        public $u;
        public $d;

		public function __construct()
		{
			parent::__construct();
        }
        
        public function selectModulos(){
            $sql = "SELECT * FROM module";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPermisosRol(int $idrol){
            $this->intRolid = $idrol;
            $sql = "SELECT * FROM permits WHERE roleid = $this->intRolid";
            $request = $this->select_all($sql);
            return $request;
        }

        public function deletePermisos(int $idrol){
            $this->intRolid = $idrol;
            $sql = "DELETE FROM permits WHERE roleid = $this->intRolid";
            $request = $this->delete($sql);
            return $request;
        }

        public function insertPermisos(int $idrol, int $idmodulo, int $r, int $w, int $u, int $d){
			$this->intRolid = $idrol;
			$this->intModuloid = $idmodulo;
			$this->r = $r;
			$this->w = $w;
			$this->u = $u;
			$this->d = $d;
			$query_insert  = "INSERT INTO permits(roleid,moduleid,r,w,u,d) VALUES(?,?,?,?,?,?)";
        	$arrData = array($this->intRolid, $this->intModuloid, $this->r, $this->w, $this->u, $this->d);
        	$request_insert = $this->insert($query_insert,$arrData);		
	        return $request_insert;
        }
        
        public function permisosModulo(int $idrol){
            $this->intRolid = $idrol;
            $sql = "SELECT p.roleid,
                            p.moduleid,
                            m.title,
                            p.r,
                            p.w,
                            p.u,
                            p.d
                    FROM permits p
                    INNER JOIN module m
                    ON p.moduleid = m.idmodule
                    WHERE p.roleid = $this->intRolid";
            $request = $this->select_all($sql);
            $arrPermisos = array();
            for($i = 0; $i< count($request); $i++){
                $arrPermisos[$request[$i]['moduleid']] = $request[$i];
            }
            return $arrPermisos;
        }
	}
 ?>