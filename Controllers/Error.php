<?php 
    class Errors extends Controllers{
        public function __construct(){
            parent::__construct();
        }

        public function notFound(){
            $data['page_tag'] = "Página no encontrada";
			$data['page_title'] = "Error 404: Página no encontrada";
			$data['page_name'] = "error"; 
            $this->views->getView($this,"error",$data);
        }
    }
    $notFound = new Errors();
    $notFound->notFound();
?>