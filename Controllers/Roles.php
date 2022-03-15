<?php 
    class Roles extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
            getPermisos(2);
        }

        public function Roles(){
            if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
            $data['page_tag'] = "Roles | Buhos";
			$data['page_title'] = "Roles | Buhos";
			$data['page_name'] = "roles"; 
            $data['page_functions'] = "functions_roles.js"; 
            $this->views->getView($this,"roles",$data);
        }

        public function getRoles(){
            
                $arrData = $this->model->selectRoles();
                for ($i=0; $i < count($arrData); $i++) {
                    $btnPermisos = '';
                    $btnEditRol = '';
                    $btnDelRol = '';


                        $btnPermisos = '<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos('.$arrData[$i]['idrole'].')" title="Permisos"><i class="fas fa-key"></i></button>';

             
                        $btnEditRol = '<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol('.$arrData[$i]['idrole'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
                    
                    
                        $btnDelRol = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['idrole'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
                    
                    $arrData[$i]['options'] = '<div class="text-center">'.$btnPermisos.' '.$btnEditRol.' '.$btnDelRol.'</div>';
                }
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            
            die();
        }

        public function setRol(){
                $intIdrol = intval($_POST['idRol']);
                $strRol =  strClean($_POST['txtNombre']);

                if($intIdrol == 0){
                    //Crear
                    $request_rol = $this->model->insertRol($strRol);
                    $option = 1;
                }else{
                    //Actualizar
                    $request_rol = $this->model->updateRol($intIdrol, $strRol);
                    $option = 2;
                }

                if($request_rol > 0 )
                {
                    if($option == 1)
                    {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    }else{
                        $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                    }
                }else if($request_rol == 'exist'){
                    
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! El Rol ya existe.');
                }else{
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
		}

        public function getRol($idrol){ 
            if($_SESSION['permisosMod']['r']){
                $intIdrol = intval(strClean($idrol));
                if($intIdrol > 0){
                    $arrData = $this->model->selectRol($intIdrol);
                    if(empty($arrData))
                    {
                        $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                    }else{
                        $arrResponse = array('status' => true, 'data' => $arrData);
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
            }
            die();
		}

        public function delRol(){
			if($_POST){
                if($_SESSION['permisosMod']['d']){
                    $intIdrol = intval($_POST['idrol']);
                    $requestDelete = $this->model->deleteRol($intIdrol);
                    if($requestDelete == 'ok')
                    {
                        $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
                    }else if($requestDelete == 'exist'){
                        $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un Rol asociado a usuarios.');
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol.');
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
			}
			die();
		}

        public function getSelectRoles(){
			$htmlOptions = "";
			$arrData = $this->model->selectRoles();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
                    $htmlOptions .= '<option value="'.$arrData[$i]['idrole'].'">'.$arrData[$i]['role'].'</option>';
				}
			}
			echo $htmlOptions;
			die();		
		}
    }
?>