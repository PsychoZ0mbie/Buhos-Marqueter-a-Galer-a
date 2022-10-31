<?php
    
    require_once("Models/ProductTrait.php");
    require_once("Models/CategoryTrait.php");
    require_once("Models/CustomerTrait.php");
    require_once("Models/BlogTrait.php");
    class Home extends Controllers{
        use ProductTrait, CategoryTrait, CustomerTrait,BlogTrait;
        public function __construct(){
            session_start();
            parent::__construct();
        }

        public function home(){
            $company = getCompanyInfo();
            $data['page_tag'] = $company['name'];
            $data['page_title'] = $company['name'];
            /*$data['slider'] = $this->getRecCategoriesT(6);
            $data['category1'] = $this->getCategoriesShowT("4,5,6");
            $data['category2'] = $this->getCategoriesShowT("7,8,9");
            $data['products'] = $this->getProductsT(8);
            $data['popProducts'] = $this->getPopularProductsT(4);
            $data['recPosts'] = $this->getRecentPostsT(3);*/
            $data['page_name'] = "home";
            $this->views->getView($this,"home",$data);
        }
        public function currentCart(){
            if(isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){
                $arrProducts = $_SESSION['arrCart'];
                $html="";
                for ($i=0; $i < count($arrProducts) ; $i++) { 
                    if($arrProducts[$i]['topic'] == 1){
                        $photo = $arrProducts[$i]['photo'] != "" ? media()."/images/uploads/".$arrProducts[$i]['photo'] : $arrProducts[$i]['img'];
                        $html.= '
                        <li class="cartlist--item" data-id="'.$arrProducts[$i]['id'].'" data-topic ="'.$arrProducts[$i]['topic'].'" data-h="'.$arrProducts[$i]['height'].'"
                        data-w="'.$arrProducts[$i]['width'].'" data-m="'.$arrProducts[$i]['margin'].'" data-s="'.$arrProducts[$i]['style'].'" 
                        data-mc="'.$arrProducts[$i]['colormargin'].'" data-bc="'.$arrProducts[$i]['colorborder'].'" data-t="'.$arrProducts[$i]['idType'].'" data-f="'.$arrProducts[$i]['photo'].'">
                            <a href="'.$arrProducts[$i]['url'].'">
                                <img src="'.$photo.'" alt="'.$arrProducts[$i]['name'].'">
                            </a>
                            <div class="item--info">
                                <a href="'.$arrProducts[$i]['url'].'">'.$arrProducts[$i]['name'].'</a>
                                <div class="item--qty">
                                    <span>
                                        <span class="fw-bold">'.$arrProducts[$i]['qty'].' x</span>
                                        <span class="item--price">'.formatNum($arrProducts[$i]['price'],false).'</span>
                                    </span>
                                </div>
                            </div>
                            <span class="delItem"><i class="fas fa-times"></i></span>
                        </li>
                        ';
                    }
                }
                $total =0;
                $qty = 0;
                foreach ($arrProducts as $product) {
                    $total+=$product['qty']*$product['price'];
                    $qty+=$product['qty'];
                }
                $status=false;
                if(isset($_SESSION['login']) && !empty($_SESSION['arrCart'])){
                    $status=true;
                }
                $arrResponse = array("status"=>$status,"items"=>$html,"total"=>formatNum($total),"qty"=>$qty);
            }else{
                $arrResponse = array("items"=>"","total"=>formatNum(0),"qty"=>0);
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function delCart(){
            if($_POST){
                $id = $_POST['id'];
                $topic = intval($_POST['topic']);
                $total=0;
                $qtyCart=0;
                $arrCart = $_SESSION['arrCart'];

                if($topic == 1){
                    $height = floatval($_POST['height']);
                    $width = floatval($_POST['width']);
                    $margin = intval($_POST['margin']);
                    $style = $_POST['style'];
                    $type = intval($_POST['type']);
                    $borderColor = $_POST['bordercolor'];
                    $marginColor = $_POST['margincolor'];
                    $photo = $_POST['photo'];
                    
                    for ($i=0; $i < count($arrCart) ; $i++) { 
                        if($topic == $arrCart[$i]['topic'] && $id == $arrCart[$i]['id'] && $height == $arrCart[$i]['height']
                        && $width == $arrCart[$i]['width'] && $margin == $arrCart[$i]['margin'] && $style == $arrCart[$i]['style']
                        && $type == $arrCart[$i]['idType'] && $borderColor == $arrCart[$i]['colorborder'] && $marginColor == $arrCart[$i]['colormargin']
                        && $photo == $arrCart[$i]['photo']){
                            if($photo!=""){
                                deleteFile($photo);
                            }
                            unset($arrCart[$i]);
                            break;
                        }
                    }
                }
                
                sort($arrCart);
                $_SESSION['arrCart'] = $arrCart;
                foreach ($_SESSION['arrCart'] as $quantity) {
                    $qtyCart += $quantity['qty'];
                }

                if(!empty($_SESSION['arrShipping']['city'])){
                    $arrTotal = $this->calculateTotal($_SESSION['arrCart'],$_SESSION['arrShipping'],$_SESSION['arrShipping']['city']['id']);
                }else if(!empty($_SESSION['arrShipping'])){
                    $arrTotal = $this->calculateTotal($_SESSION['arrCart'],$_SESSION['arrShipping']);
                }else{
                    $arrTotal = $this->calculateTotal($_SESSION['arrCart']);
                }
                
                $subtotal = $arrTotal['subtotal'];
                $total = $arrTotal['total'];
                
                if($arrTotal['subtotalCoupon']> 0){
                    $arrResponse = array("status"=>true,"total" =>formatNum($total),"subtotal"=>formatNum($subtotal),"subtotalCoupon"=>formatNum($arrTotal['subtotalCoupon']),"qty"=>$qtyCart);
                }else{
                    $arrResponse = array("status"=>true,"total" =>formatNum($total),"subtotal"=>formatNum($subtotal),"qty"=>$qtyCart);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function calculateTotal($arrProducts,$arrShipping=null,$idCity =null){
            $subtotal = 0;
            $total=0;
            $subtotalCoupon=0;
            foreach ($arrProducts as $product) {
                $subtotal+=$product['qty']*$product['price'];
            }
            if(isset($_SESSION['couponInfo']) && $_SESSION['couponInfo']['status'] == true){
                $subtotalCoupon = $subtotal;
                $subtotal = $subtotal - ($subtotal * ($_SESSION['couponInfo']['discount']/100));
            }
            
            if($idCity != null){
                for ($i=0; $i < count($arrShipping['cities']) ; $i++) { 
                    if($arrShipping['cities'][$i]['id'] == $idCity){
                        $total = $subtotal + $arrShipping['cities'][$i]['value'];
                        $arrShipping['city'] = $arrShipping['cities'][$i];
                        $_SESSION['arrShipping'] = $arrShipping;
                        break;
                    }
                }
            }else if($arrShipping!=null){
                $total = $subtotal+$arrShipping['value'];
            }else{
                $total = $subtotal;
            }
            
            $arrTotal = array("subtotal"=>$subtotal,"total"=>$total,"subtotalCoupon" =>$subtotalCoupon);
            return $arrTotal;
        }

    }
?>