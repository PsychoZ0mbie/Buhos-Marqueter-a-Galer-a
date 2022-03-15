<?php	
    class ProductosModel extends Mysql{

        public $intProductId;
        public $intPersonId;
        public $strTitle;
        public $intTopic;
        public $intSubTopic;
        public $decPrice;
        public $intStock;
        public $strRoute;
        public $intStatus;

        public function __construct(){
            parent::__construct();
        }

        /******************************************************PRODUCTS***************************************************************/
        public function selectProductos($idUser){
            $this->intPersonId = $idUser;
            $sql = "SELECT p.idproduct,
                            p.reference,
                            p.person_id,
                            p.title,
                            p.topic_id,
                            p.subtopic_id,
                            p.price,
                            p.stock,
                            DATE_FORMAT(p.datecreated, '%Y-%m-%d') as dateactual,
                            DATE_FORMAT(p.dateupdate, '%Y-%m-%d') as dateupdate,
                            p.route,
                            p.status,
                            t.idtopic,
                            t.person_id,
                            t.name as categoria,
                            t.status,
                            s.idsubtopic,
                            s.topic_id,
                            s.person_id,
                            s.name as subcategoria,
                            s.status 
                    FROM product p 
                    INNER JOIN producttopic t, productsubtopic s
                    WHERE p.person_id = $this->intPersonId AND p.person_id = t.person_id AND t.person_id = s.person_id
                            AND p.topic_id = t.idtopic AND t.idtopic = s.topic_id AND p.subtopic_id = s.idsubtopic";
            $request = $this->select_all($sql);
            return $request;
        }

        /******************************************************ATTRIBUTES***************************************************************/
        public function setAttribute($id,$strName){
            $sql="SELECT * FROM attribute WHERE name = '$strName' AND person_id = $id";
            $request = $this->select($sql);

            if(empty($request)){
                $query = "INSERT INTO attribute(person_id,name) VALUES(?,?)";
                $arrData = array($id,$strName);

                $request_insert = $this->insert($query,$arrData);
                $return = $request_insert;
            }else{
                $return ="exist";
            }
            return $return;
        }

        public function getAttributes($id){
            $sql = "SELECT * FROM attribute WHERE person_id = $id";
            $request = $this->select_all($sql);
            return $request;
        }

        public function delAttribute($id){
            $sql="DELETE FROM attribute WHERE id = $id";
            $request =$this->delete($sql);
            return $request;
        }
    }
?>