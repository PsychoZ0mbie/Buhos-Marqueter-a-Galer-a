<?php
    require_once("Libraries/Core/Mysql.php");

    trait TCategorias{
        private $con;
        private $intIdCategoria;
        private $intIdSubcategoria;
        private $intIdTecnica;

        public function getCategoriaT($categoria){
            $this->intIdCategoria = $categoria;
            $this->con = new Mysql();
            $sql="SELECT * FROM topics WHERE idtopic = $this->intIdCategoria";
            $request = $this->con->select_all($sql);
            return $request;
        }
        
        public function getSubCategoriaT($categoria){
            $this->intIdCategoria = $categoria;
            $this->con = new Mysql();

            $sql = "SELECT * FROM subtopics WHERE topicid = $this->intIdCategoria ORDER BY title ASC";
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getTecnicasT($categoria){
            $this->intIdTecnica = $categoria;
            $this->con = new Mysql();

            $sql = "SELECT * FROM techniques WHERE topicid = $this->intIdTecnica ORDER BY title ASC";
            $request = $this->con->select_all($sql);
            return $request;
        }
    }
?>