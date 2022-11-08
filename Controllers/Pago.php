<?php
    
    require_once("Models/ProductTrait.php");
    require_once("Models/CustomerTrait.php");
    require_once("Models/LoginModel.php");
    class Pago extends Controllers{
        use ProductTrait, CustomerTrait;
        private $login;
        public function __construct(){
            session_start();
            parent::__construct();
            $this->login = new LoginModel();
        }

        /******************************Views************************************/
        public function pago(){
            if(isset($_SESSION['login']) && isset($_SESSION['arrCart']) && !empty($_SESSION['arrCart'])){
                $company=getCompanyInfo();
                $data['page_tag'] = $company['name'];
                $data['page_title'] ="Pago | ".$company['name'];
                $data['page_name'] = "pago";
                $data['credentials'] = getCredentials();
                $data['company'] = getCompanyInfo();
                $data['shipping'] = $this->selectShippingMode();
                $data['app'] = "functions_checkout.js";
                if(isset($_GET['cupon'])){
                    $cupon = strtoupper(strClean($_GET['cupon']));
                    $cuponData = $this->selectCouponCode($cupon);
                    if(!empty($cuponData)){
                        $data['cupon'] = $cuponData;
                        $data['cupon']['check'] = $this->checkCoupon($_SESSION['idUser'],$data['cupon']['id']);
                    }else{
                        header("location: ".base_url()."/pago");
                    }
                }
                $this->views->getView($this,"pago",$data); 
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function confirm(){
            if(isset($_SESSION['orderData'])){
                $company=getCompanyInfo();
                $data['page_tag'] = $company['name'];
                $data['page_title'] ="Confirmar pedido | ".$company['name'];
                $data['page_name'] = "confirm";
                $data['orderData'] = $_SESSION['orderData'];
                unset($_SESSION['orderData']);
                $this->views->getView($this,"confirm",$data); 
            }else{
                header("location: ".base_url());
                die();
            }
        }
        public function calcTotalCart($arrProducts,$code=null,$city=null){
            $arrShipping = $this->selectShippingMode();
            $total=0;
            $subtotal=0;
            $shipping =0;
            $cupon = 0;
            for ($i=0; $i < count($arrProducts) ; $i++) { 
                $subtotal += $arrProducts[$i]['price']*$arrProducts[$i]['qty']; 
            }
            if($arrShipping['id'] != 3){
                $shipping = $arrShipping['value'];
            }else if($city > 0){
                $cityVal = $this->selectShippingCity($city)['value'];
                $shipping = $cityVal;
            }
            $total = $subtotal + $shipping;
            if($code != ""){
                $arrCupon = $this->selectCouponCode($code);
                $cupon = $subtotal-($subtotal*($arrCupon['discount']/100));
                $total =$cupon + $shipping;
            }
            $arrData = array("subtotal"=>$subtotal,"total"=>$total,"cupon"=>$cupon);
            return $arrData;
        }
        public function calculateShippingCity(){
            if($_POST){
                $arrProducts = $_SESSION['arrCart'];
                $city = intval($_POST['city']);
                $code = strClean($_POST['cupon']);
                $arrData = $this->calcTotalCart($arrProducts,$code,$city);
                $arrData['subtotal'] = formatNum($arrData['subtotal']);
                $arrData['total'] = formatNum($arrData['total']);
                $arrData['cupon'] = formatNum($arrData['cupon']); 
                echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function checkShippingCity($id){
            $id = intval($id);
            $request = $this->selectShippingCity($id);
            if(!empty($request)){
                $arrResponse = array("status"=>true);
            }else{
                $arrResponse = array("status"=>false,"msg"=>"Por favor, seleccione una ciudad.");
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        /******************************Checkout methods************************************/
        public function checkData(){
            if($_POST){
                if(empty($_POST['txtNameOrder']) || empty($_POST['txtLastNameOrder']) || empty($_POST['txtEmailOrder']) || 
                empty($_POST['txtPhoneOrder']) || empty($_POST['txtAddressOrder']) || empty($_POST['country'])
                || empty($_POST['state']) || empty($_POST['city'])){
                    $arrResponse = array("status"=>false,"msg"=>"Error de datos");
                }else{
                    $arrData = array(
                        "firstname"=>strClean(ucwords($_POST['txtNameOrder'])),
                        "lastname"=>strClean(ucwords($_POST['txtLastNameOrder'])),
                        "email"=>strClean(strtolower($_POST['txtEmailOrder'])),
                        "phone"=>strClean($_POST['txtPhoneOrder']),
                        "address"=>strClean($_POST['txtAddressOrder']),
                        "country"=>strClean($_POST['country']),
                        "state"=>strClean($_POST['state']),
                        "city"=>strClean($_POST['city']),
                        "postalcode" =>strClean($_POST['txtPostCodeOrder']),
                        "note"=>strClean($_POST['txtNote'])
                    );
                    $_SESSION['checkData'] = $arrData;
                    $arrResponse = array("status"=>true,"msg"=>"Datos correctos");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function setOrder(){
            if($_POST){
                if(empty($_POST['data']) || empty($_SESSION['checkData'])){
                    $arrResponse = array("status"=>false,"msg"=>"Data error");
                }else{
                    $total = 0;
                    $arrTotal = array();
                    $idUser = $_SESSION['idUser'];
                    $objPaypal = json_decode($_POST['data']);
                    $arrInfo = $_SESSION['checkData'];
                    $amountData=array();
                    unset($_SESSION['checkData']);

                    if(!empty($_SESSION['arrCart'])){
                        if(!empty($_SESSION['arrShipping']['city'])){
                            $arrTotal = $this->calculateTotal($_SESSION['arrCart'],$_SESSION['arrShipping'],$_SESSION['arrShipping']['city']['id']);
                        }else{
                            $arrTotal = $this->calculateTotal($_SESSION['arrCart'],$_SESSION['arrShipping']);
                        }

                        
                        if(is_object($objPaypal)){
                            
                            $dataPaypal = $_POST['data'];
                            $idTransaction = $objPaypal->purchase_units[0]->payments->captures[0]->id;
                            $status = $objPaypal->purchase_units[0]->payments->captures[0]->status;
                            $firstname = $arrInfo['firstname'];
                            $lastname = $arrInfo['lastname'];
                            $email = $arrInfo['email'];
                            $phone = $arrInfo['phone'];
                            $postalCode = $arrInfo['postalcode'];  
                            $country = $arrInfo['country'];
                            $state = $arrInfo['state'];
                            $city = $arrInfo['city'];
                            $address = $arrInfo['address'];
                            $note = $arrInfo['note'];
                            $total = $arrTotal['total'];

                            if(isset($_SESSION['couponInfo'])){
                                $amountData['couponInfo'] = $_SESSION['couponInfo'];
                                if($amountData['couponInfo']['status'] == true){
                                    $this->setCoupon($amountData['couponInfo']['id'],$idUser,$amountData['couponInfo']['code']);
                                }
                                unset($_SESSION['couponInfo']);
                            }
                            $amountData['totalInfo'] = array("total"=>$arrTotal,"shipping"=>$_SESSION['arrShipping']);
                            $objAmount = json_encode($amountData,true);

                            unset($_SESSION['arrShipping']);

                            $requestOrder = $this->insertOrder($idUser,$idTransaction,$dataPaypal,$objAmount,$firstname,$lastname,$email,$phone,$country,$state,$city,$address,
                            $postalCode,$note,$total,$status);

                            if($requestOrder>0){

                                $arrOrder = array("idorder"=>$requestOrder,"iduser"=>$_SESSION['idUser'],"products"=>$_SESSION['arrCart']);
                                $request = $this->insertOrderDetail($arrOrder);
                                $orderInfo = $this->getOrder($requestOrder);
                                $orderInfo['amountData'] = $amountData;
                                $company = getCompanyInfo();
                                $dataEmailOrden = array(
                                    'asunto' => "Se ha generado un pedido",
                                    'email_usuario' => $_SESSION['userData']['email'], 
                                    'email_remitente'=>$company['email'],
                                    'company'=>$company,
                                    'email_copia' => $company['secondary_email'],
                                    'order' => $orderInfo );

								sendEmail($dataEmailOrden,"email_order");
                                $idOrder = openssl_encrypt($requestOrder,METHOD,KEY);
                                $idTransaction = openssl_encrypt($orderInfo['order']['idtransaction'],METHOD,KEY);
                                $arrResponse = array("status"=>true,"order"=>$idOrder,"transaction"=>$idTransaction,"msg"=>"Pedido realizado");
                                $_SESSION['orderData'] = $arrResponse;

                                unset($_SESSION['arrCart']);
                                
                                
                            }else{
                                $arrResponse = array("status"=>false,"msg"=>"No se ha podido realizar el pedido.");
                            }
                        }else{
                            $arrResponse = array("status"=>false,"msg"=>"Se ha producido un error en la transacción.");
                        }
                    }else{
                        $arrResponse = array("status"=>false,"msg"=>"Se ha producido un error en la transacción.");
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function getCountries(){
            $request = $this->selectCountries();
            $html='
            <option value="0" selected>Seleccione</option>
            <option value="'.$request['id'].'">'.$request['name'].'</option>
            ';
            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getSelectCountry($id){
            $request = $this->selectStates($id);
            $html='<option value="0" selected>Seleccione</option>';
            for ($i=0; $i < count($request) ; $i++) { 
                $html.='<option value="'.$request[$i]['id'].'">'.$request[$i]['name'].'</option>';
            }
            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getSelectState($id){
            $request = $this->selectCities($id);
            $html='<option value="0" selected>Seleccione</option>';
            for ($i=0; $i < count($request) ; $i++) { 
                $html.='<option value="'.$request[$i]['id'].'">'.$request[$i]['name'].'</option>';
            }
            echo json_encode($html,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>