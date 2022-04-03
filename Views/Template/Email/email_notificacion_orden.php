<?php 

$orden = $data['pedido']['orden'];
$detalle = $data['pedido']['detalle'];
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Orden</title>
	<style type="text/css">
		p{
			font-family: arial;letter-spacing: 1px;color: #7f7f7f;font-size: 12px;
		}
		hr{border:0; border-top: 1px solid #CCC;}
		h4{font-family: arial; margin: 0;}
		table{width: 100%; max-width: 600px; margin: 10px auto; border: 1px solid #CCC; border-spacing: 0;}
		table tr td, table tr th{padding: 5px 10px;font-family: arial; font-size: 12px;}
		#detalleOrden tr td{border: 1px solid #CCC;}
		.table-active{background-color: #CCC;}
		.text-center{text-align: center;}
		.text-right{text-align: right;}

		@media screen and (max-width: 470px) {
			.logo{width: 90px;}
			p, table tr td, table tr th{font-size: 9px;}
		}
	</style>
</head>
<body>
	<div>
		<br>
		<p class="text-center">Se ha generado una orden, a continuación encontrarás los datos.</p>
		<br>
		<hr>
		<br>
		<table>
			<tr>
				<td width="33.33%">
					<img src="<?= media();?>/images/uploads/icon.gif" alt="Logo" width="100px" height="100px">
				</td>
				<td width="33.33%">
					<div class="text-center">
						<h4><strong><?= NOMBRE_EMPRESA ?></strong></h4>
						<p>
							<?= DIRECCION ?> <br>
							Teléfono: <?= TELEFONO ?> <br>
							Correo: <?= EMAIL_REMITENTE ?>
						</p>
					</div>
				</td>
				<td width="33.33%">
					<div class="text-right">
						<p>
							No. Orden: <strong><?= $orden['idorderdata'] ?></strong><br>
                            Fecha: <?= $orden['date'] ?><br>
						</p>
					</div>
				</td>				
			</tr>
		</table>
		<table>
			<tr>
		    	<td width="140">Nombre:</td>
		    	<td><?= $orden['firstname'].' '.$orden['lastname'] ?></td>
		    </tr>
		    <tr>
		    	<td>Teléfono</td>
		    	<td><?= $orden['phone'] ?></td>
		    </tr>
		    <tr>
		    	<td>Dirección de envío:</td>
		    	<td><?= $orden['departamento']?>/<?= $orden['ciudad']?><br><?=$orden['address']?></td>
		    </tr>
			<tr>
		    	<td>Mensaje:</td>
		    	<td><?= $orden['comment']?></td>
		    </tr>
		</table>
		<table>
		  <thead class="table-active">
		    <tr>
		      <th>Descripción</th>
		      <th class="text-right">Precio</th>
		      <th class="text-center">Cantidad</th>
		      <th class="text-right">Total</th>
		    </tr>
		  </thead>
		  <tbody id="detalleOrden">
		  	<?php 
		  		if(count($detalle) > 0){
		  			$subtotal = 0;
		  			foreach ($detalle as $producto) {
		  				$precio = $producto['price'];
		  				$importe = $producto['price'] * $producto['quantity'];
						if($producto['quantity']>= 12){
							$importe = $producto['price'] * $producto['quantity'];
							$importe = $importe * 0.9;
						}else{
							$importe = $producto['price'] * $producto['quantity'];
						}
						  if($producto['width']==0 || $producto['length']==0){
							  $medidas="";
						  }else{
							  $medidas="<strong>Medidas:</strong> ".$producto['width']."cm X ".$producto['length']."cm";
						  }
		  	 ?>
		    <tr>
		      <td>
				  <strong>Referencia:</strong> <?= $producto['title'] ?><br>
			  	  <?= $medidas ?><br>
				  <strong>Categoria:</strong> <?= $producto['topic'] ?><br>
				  <strong>Técnica/Color:</strong> <?= $producto['subtopic'] ?><br>
				  <?php if($producto['type'] != ""){ ?>
				  <strong>Tipo:</strong> <?=$producto['type']?>
				  <?php }?>
			  </td>
		      <td class="text-right"><?= MS.number_format($precio,0,DEC,MIL)." ".MD?></td>
		      <td class="text-center"><?= $producto['quantity'] ?></td>
		      <td class="text-right"><?= MS.number_format($importe,0,DEC,MIL)." ".MD?></td>
		    </tr>
			<?php }
				} ?>
		  </tbody>
		  <tfoot>
		  		<tr>
		  			<th colspan="3" class="text-right">Subtotal:</th>
		  			<td class="text-right"><?= MS.number_format($orden['price'],0,DEC,MIL)." ".MD?></td>
		  		</tr>
		  		<tr>
		  			<th colspan="3" class="text-right">Envío:</th>
		  			<td class="text-right"><?= MS.number_format(ENVIO,0,DEC,MIL)." ".MD?></td>
		  		</tr>
		  		<tr>
		  			<th colspan="3" class="text-right">Total:</th>
		  			<td class="text-right"><?= MS.number_format($orden['price'],0,DEC,MIL)." ".MD ?></td>
		  		</tr>
		  </tfoot>
		</table>
		<div class="text-center">
			<p>Como todavía no ofrecemos el pago a través del sitio web,<br> 
				nos comunicaremos contigo por WhatsApp, teléfono o correo electrónico<br> 
				para organizar la entrega y el pago de tu compra</p>
			<h4>¡Gracias por confiar en nosotros!</h4>			
		</div>
	</div>									
</body>
</html>