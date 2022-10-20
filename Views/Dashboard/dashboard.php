<?php 
//dep($data['salesMonth']);exit;
    headerAdmin($data);
    $orders = $data['orders'];
    $products = $data['products'];
    $sales = $data['salesMonth']['sales'];
    $salesYear = $data['salesYear']['data'];
?>
<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div class="container-lg">
        <div class="row">
            <!--
            <div class="col-sm-6 col-lg-3">
                <div class="card mb-4 text-white bg-primary">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">26K
                            <div>Users</div>
                        </div>
                    </div>
                </div>
            </div>-->
            <?php if($_SESSION['userData']['roleid'] != 2 && $_SESSION['permitsModule']['r']){?>
            <div class="col-md-3">
                <div class="card mb-4 position-relative" style="--cui-card-cap-bg: #321fdb">
                    <div class="card-header position-relative d-flex justify-content-center align-items-center">
                        <svg class="icon icon-3xl text-white my-4">
                            <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                        </svg>
                        
                    </div>
                    <div class="card-body row text-center">
                        <div class="col">
                            <div class="fs-5 fw-semibold"><?=$data['totalUsers']?></div>
                            <div class="text-uppercase text-medium-emphasis small">Usuarios</div>
                        </div>
                    </div>
                    <a href="<?=base_url();?>/user" class="position-absolute w-100 h-100"></a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-4 position-relative" style="--cui-card-cap-bg: #3399ff">
                    <div class="card-header position-relative d-flex justify-content-center align-items-center">
                        <svg class="icon icon-3xl text-white my-4">
                            <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-user-follow"></use>
                        </svg>
                        
                    </div>
                    <div class="card-body row text-center">
                        <div class="col">
                            <div class="fs-5 fw-semibold"><?=$data['totalCustomers']?></div>
                            <div class="text-uppercase text-medium-emphasis small">Clientes</div>
                        </div>
                    </div>
                    <a href="<?=base_url();?>/customer" class="position-absolute w-100 h-100"></a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mb-4 position-relative" style="--cui-card-cap-bg: #f9b115">
                    <div class="card-header position-relative d-flex justify-content-center align-items-center">
                        <svg class="icon icon-3xl text-white my-4">
                            <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-dollar"></use>
                        </svg>
                        
                    </div>
                    <div class="card-body row text-center">
                        <div class="col">
                            <div class="fs-5 fw-semibold"><?=$data['totalSales']?></div>
                            <div class="text-uppercase text-medium-emphasis small">Ventas</div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
            <div class="col-md-3">
                <div class="card mb-4 position-relative" style="--cui-card-cap-bg: #e55353">
                    <div class="card-header position-relative d-flex justify-content-center align-items-center">
                        <svg class="icon icon-3xl text-white my-4">
                            <use xlink:href="<?=media()?>/coreui/coreui-free-bootstrap-admin-template/dist/vendors/@coreui/icons/svg/free.svg#cil-money"></use>
                        </svg>
                        
                    </div>
                    <div class="card-body row text-center">
                        <div class="col">
                            <div class="fs-5 fw-semibold"><?=$data['totalOrders']?></div>
                            <div class="text-uppercase text-medium-emphasis small">Pedidos</div>
                        </div>
                    </div>
                    <a href="<?=base_url();?>/orders" class="position-absolute w-100 h-100"></a>
                </div>
            </div>
        </div>
        <?php if($_SESSION['userData']['roleid'] != 2 && $_SESSION['permitsModule']['r']){?>
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <div class="d-flex align-items-center">
                        <input  class="date-picker salesMonth" name="salesMonth" placeholder="Month and year" required>
                        <button class="btn btn-sm btn-primary" id="btnSalesMonth"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <figure class="highcharts-figure"><div id="salesMonth"></div></figure>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <div class="d-flex align-items-center">
                        <input type="number" name="salesYear" id="sYear" placeholder="Year" min="2000" max="9999">
                        <button class="btn btn-sm btn-primary" id="btnSalesYear"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <figure class="highcharts-figure"><div id="salesYear"></div></figure>
            </div>
        </div>
        <?php }?>
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h4 class="mb-4">Últimos pedidos</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombres</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Monto</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($orders)){
                                        foreach ($orders as $order) {
                                ?>
                                <tr>
                                    <td><?=$order['idorder']?></td>
                                    <td><?=$order['firstname']." ".$order['lastname']?></td>
                                    <td><?=$order['status']?></td>
                                    <td><?=formatNum($order['amount'])?></td>
                                    <td><a href="<?=base_url()."/orders/order/".$order['idorder']?>" class="text-dark"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <?php } }else{?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay datos</td>
                                </tr>  
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <h4 class="mb-4">Últimos productos</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Descuento</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($products)){
                                        foreach ($products as $product) {
                                ?>
                                <tr>
                                    <td><?=$product['name']?></td>
                                    <td><?=formatNum($product['price'])?></td>
                                    <td><?=$product['discount']?>%</td>
                                    <td><a href="<?=base_url()."/shop/product/".$product['route']?>" target="_blank" class="text-dark"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                <?php } }else{?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay datos</td>
                                </tr>  
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php footerAdmin($data)?>     
<script>
    if(document.querySelector("#salesMonth")){
        Highcharts.chart('salesMonth', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Ventas de <?=$data['salesMonth']['month']." ".$data['salesMonth']['year']?>'
            },
            subtitle: {
                text: 'Total: <?=formatNum($data['salesMonth']['total'])?>'
            },
            xAxis: {
                categories: [
                    <?php
                        
                        for ($i=0; $i < count($sales) ; $i++) { 
                            echo $sales[$i]['day'].",";
                        }
                    ?>
                ]
            },
            yAxis: {
                title: {
                    text: ''
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: '',
                data: [
                    <?php
                        
                        for ($i=0; $i < count($sales) ; $i++) { 
                            echo $sales[$i]['total'].",";
                        }
                    ?>
                ]
            }]
        });
        Highcharts.chart('salesYear', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Ventas de <?=$salesYear[0]['year']?>'
            },
            subtitle: {
                text: 'Total: <?=formatNum($data['salesYear']['total'])?>'
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Sales: <b>{point.y:.0f} '+MD+'</b>'
            },
            series: [{
                name: 'Population',
                data: [
                    <?php
                        for ($i=0; $i < count($salesYear) ; $i++) { 
                            echo '["'.$salesYear[$i]['month'].'"'.",".''.$salesYear[$i]['sale'].'],';
                        }    
                    ?>
                    //['Shanghai', 24.2]
                ],
                dataLabels: {
                    enabled: true,
                    rotation: 0,
                    color: '#FFFFFF',
                    align: 'center',
                    y: 0, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji'
                    }
                }
            }]
        });
    }
</script> 
