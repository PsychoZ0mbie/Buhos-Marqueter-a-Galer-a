<?php 
headerAdmin($data);
$order = $data['orderdata'];
$detail = $data['orderdetail'];
$total=0;
$company = $data['company'];
$subtotal = 0;

?>

<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div id="modalItem"></div>
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div id="orderInfo" class="position-relative overflow-hidden">
                    <?php if($order['status']=="approved"){?>
                        <div class="stamp"><img src="<?=media()?>/images/uploads/sello_pagado.png" alt=""></div>
                    <?php }else{?>   
                        <div class="stamp"><img src="<?=media()?>/images/uploads/sello_pendiente.png" alt=""></div>
                    <?php }?>  
                    <div class="d-flex justify-content-between flex-wrap mb-3">
                        <div class="mb-3 d-flex flex-wrap align-items-center">
                            <img src="<?=media()."/images/uploads/".$company['logo']?>" class="me-2" style="width=170px;height:170px;" alt="">
                            <div>
                                <p class="m-0 fw-bold"><?=$company['name']?></p>
                                <p class="m-0">Oswaldo Parrado Clavijo</p>
                                <p class="m-0">NIT 17.344.806-8 No responsable de IVA</p>
                                <p class="m-0"><?=$company['addressfull']?></p>
                                <p class="m-0">+<?=$company['phonecode']." ".$company['phone']?></p>
                                <p class="m-0"><?=$company['email']?></p>
                                <p class="m-0"><?=BASE_URL?></p>
                            </div>
                        </div>
                        <div class="text-start">
                            <p class="m-0"><span class="fw-bold">Fecha: </span><?=$order['date']?></p>
                            <p class="m-0"><span class="fw-bold">Pedido: </span>#<?=$order['idorder']?></p>
                            <p class="m-0"><span class="fw-bold">Transaccion: </span><?=$order['idtransaction']?></p>
                            <p class="m-0"><span class="fw-bold">Estado: </span><?=$order['status']?></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 mb-3">
                            <p class="m-0 mb-2 fw-bold">Cliente</p>
                            <p class="m-0">Nombre: <?=$order['name']?></p>
                            <p class="m-0">Teléfono: <?=$order['phone']?></p>
                            <p class="m-0">Email: <?=$order['email']?></p>
                            <p class="m-0">Dirección: <?=$order['address']?></p>
                            <p class="m-0 fw-bold mt-3">Notas:</p>
                            <p class="m-0"><?=$order['note']?></p> 
                        </div>
                    </div>
                    <table class="table items align-middle">
                        <thead class="text-center">
                            <tr>
                                <th>Descripcion</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        <?php 
                            if(count($detail) > 0){
                                foreach ($detail as $product) {
                                    $subtotal+= $product['quantity']*$product['price'];
                        ?>
                        <tr>
                            <?php
                                if($product['topic'] == 2 || $product['topic'] == 3){
                            ?>
                        <td class="text-start text-break">
                            <?=$product['description']?><br>
                        </td>
                            <?php 
                                }else{ 
                                    $arrProducts = json_decode($product['description'],true);
                                    $photo = "";
                                    if($arrProducts['photo']!=""){
                                        $photo = '<img src="'.media()."/images/uploads/".$arrProducts['photo'].'" width="70" height="70"><br>';
                                    }
                            ?>
                            <td class="text-start">
                                <?=$photo?>
                                <?=$arrProducts['name']?>
                            <?php
                                $margen = $arrProducts['margin'] > 0 ? '<li><span class="fw-bold t-color-3">Margen:</span> '.$arrProducts['margin'].'cm</li>' : "";
                                $colorMargen = $arrProducts['colormargin'] != "" ? '<li><span class="fw-bold t-color-3">Color margen:</span> '.$arrProducts['colormargin'].'</li>' : "";
                                $colorBorder = $arrProducts['colorborder'] != "" ? '<li><span class="fw-bold t-color-3">Color Borde:</span> '.$arrProducts['colorborder'].'</li>' : "";
                                $medidas = $arrProducts['width']."cm X ".$arrProducts['height']."cm";
                                $medidasMarco = ($arrProducts['width']+($arrProducts['margin']*2))."cm X ".($arrProducts['height']+($arrProducts['margin']*2))."cm"; 
                            ?>
                            <?php if($arrProducts['idType'] == 1 || $arrProducts['idType'] == 4 || $arrProducts['idType'] == 5){?>
                            <ul>
                                <li><span class="fw-bold text-start">Referencia:</span> <?=$arrProducts['reference']?></li>
                                <li><span class="fw-bold t-color-3">Orientación:</span> <?=$arrProducts['orientation']?></li>
                                <li><span class="fw-bold t-color-3">Estilo:</span> <?=$arrProducts['style']?></li>
                                <li><span class="fw-bold t-color-3">Medidas:</span> <?=$medidas?></li>
                                <?=$margen?>
                                <li><span class="fw-bold t-color-3">Medidas del marco:</span> <?=$medidasMarco?></li>
                                <?=$colorMargen?>
                                <?=$colorBorder?>
                            </ul>
                            <?php }else if($arrProducts['idType'] == 3 || $arrProducts['idType'] == 7){?>
                            <ul>
                                <li><span class="fw-bold t-color-3">Referencia:</span> <?=$arrProducts['reference']?></li>
                                <li><span class="fw-bold t-color-3">Orientación:</span> <?=$arrProducts['orientation']?></li>
                                <li><span class="fw-bold t-color-3">Estilo:</span> <?=$arrProducts['style']?></li>
                                <li><span class="fw-bold t-color-3">Medidas:</span> <?=$medidas?></li>
                            </ul>
                            <?php }else if($arrProducts['idType'] == 6){?>
                                <ul>
                                    <li><span class="fw-bold t-color-3">Referencia:</span> <?=$arrProducts['reference']?></li>
                                    <li><span class="fw-bold t-color-3">Orientación:</span> <?=$arrProducts['orientation']?></li>
                                    <li><span class="fw-bold t-color-3">Medidas:</span> <?=$medidas?></li>
                                    <?=$margen?>
                                    <li><span class="fw-bold t-color-3">Medidas del marco:</span> <?=$medidasMarco?></li>
                                    <?=$colorMargen?>
                                </ul>
                            <?php }else if($arrProducts['idType'] == 8){?>
                                <ul>
                                    <li><span class="fw-bold t-color-3">Estilo:</span> <?=$arrProducts['style']?></li>
                                    <li><span class="fw-bold t-color-3">Medidas:</span> <?=$medidas?></li>
                                    <?=$colorBorder?>
                                </ul>
                            <?php }else if($arrProducts['idType'] == 9){?>
                            <ul>
                                    <li><span class="fw-bold t-color-3">Estilo:</span> <?=$arrProducts['style']?></li>
                                    <li><span class="fw-bold t-color-3">Medidas:</span> <?=$medidas?></li>
                            </ul>
                            <?php }?>
                            </td>
                        <?php }?>
                        <td class="text-right"><?=formatNum(floor($product['price']),false)?></td>
                        <td class="text-center"><?= $product['quantity'] ?></td>
                        <td class="text-right"><?= formatNum(floor($product['price']*$product['quantity']),false)?></td>
                        </tr>
                        <?php 		
                            }
                        } 
                        ?>
                    </tbody>
                    <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Subtotal:</th>
                                <td class="text-right"><?= formatNum($subtotal,false)?></td>
                            </tr>
                            <?php
                                if(isset($data['cupon'])){
                                    $cupon = $data['cupon'];
                                    $subtotal = $subtotal - ($subtotal*($cupon['discount']/100));
                            ?>
                            <tr>
                                <th colspan="3" class="text-end">Cupon:</th>
                                <td class="text-right"><?= $cupon['code']." - ".$cupon['discount']?>%</td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Subtotal:</th>
                                <td class="text-right"><?= formatNum($subtotal,false)?></td>
                            </tr>
                            <?php }?>
                            <tr>
                                <th colspan="3" class="text-end">Envio:</th>
                                <td class="text-right"><?= formatNum($order['shipping'],false)?></td>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <td class="text-right"><?= formatNum($order['amount'],false)?></td>
                            </tr>
                    </tfoot>
                    </table>
                    <table class="table text-center">
                        <tbody>
                            <tr><td><p class="fw-bold">Después de 60 días no se responde por trabajos o pedidos finalizados</p></td></tr>
                            <tr><td><p class="fw-bold">Esta factura de compra venta se asimila en todos sus efectos
                                legales a la letra de cambio de acuerdo al ART.774 del código de comercio
                            </p></td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-6 text-start">
                        <a href="<?=base_url()?>/pedidos" class="btn btn-secondary text-white"><i class="fas fa-arrow-circle-left"></i> Regresar</a>
                    </div>
                    <div class="col-6 text-end">
                        <!--<button type="button" onclick="printJS({ printable: 'orderInfo', type: 'html', targetStyles: ['*'],documentTitle: '<?=$order['idtransaction']?>'})" class="btn btn-primary"><i class="fas fa-print"></i> Imprimir</button>-->
                        <button type="button" onclick="printDiv('orderInfo','<?=$order['idtransaction']?>')" class="btn btn-primary"><i class="fas fa-print"></i> Imprimir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>        