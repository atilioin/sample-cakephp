<style>
	tr:nth-child(even) {background: #EEE }
	tr:nth-child(odd) {background: #FFF}
</style>
<div class="tareas">
	<h2>Listado de Liquidaciones <?php echo date("m-Y",strtotime($periodo)); ?></h2>
	<?php if (count($pendientes)||count($pagados)): ?>
		<h2>UEN: <?php echo $uen['Uen']['nombre']; ?></h2>
		<?php if (count($pendientes)): ?>
			<center><h3>Liquidaciones A Pagar</h3></center>
			<table cellpadding="0" cellspacing="0" class="sortable" style="width:1250px;font-size:12px;">
				<thead>
					<tr>
						<th>Empleado</th>
						<th>Dias</th>
						<th>Importe Bono</th>
						<th>Total</th>
						<th>Total Anterior</th>
						<th>Sueldo</th>
						<th>Perdidas</th>
						<th>Comisiones</th>
						<?php ($hayaguinaldo)?e("<th>Aguinaldo</th>"):false; ?>
						<th>Sector</th>
						<th>Cobra Bono?</th>
						<th>Acciones</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
			<?php $total_tango=0 ?>
			<?php $total=0 ?>
			<?php $dec_sep='.'; $mil_sep=''; ?>
			<tbody style="overflow:auto;height:700px;">
			<?php foreach ($pendientes as $liquidacion): ?>
				<tr id="<?php echo $liquidacion["Liquidacion"]["id"]; ?>">
					<td id="<?php echo $liquidacion['Empleado']['id']; ?>-nombre"><?php echo $liquidacion['Empleado']['apellido']." ".$liquidacion['Empleado']['nombre']; ?></td>
					<td><?php echo $html->link($liquidacion['Liquidacion']['dias_tango'],"#",array('onclick'=>'javascript:mostrarAusentes('.$liquidacion['Liquidacion']['empleado_id'].');'));; ?></td>
					<td align="right"><?php echo number_format($liquidacion['Liquidacion']['monto_tango'],2,$dec_sep,$mil_sep); $total_tango+=$liquidacion['Liquidacion']['monto_tango']; ?></td>
					<td align="right"><span id='totalliquidacion-<?php echo $liquidacion['Empleado']['id']; ?>'><?php echo number_format($liquidacion['Liquidacion']['total'],2,$dec_sep,$mil_sep); $total+=$liquidacion['Liquidacion']['total'];?></span></td>
					<td align="right"><?php echo number_format($liquidacion['Liquidacion']['penultimototal'],2,$dec_sep,$mil_sep);?></td>			
					<td>
							<?php echo number_format($liquidacion['Empleado']['sueldo'],2,$dec_sep,$mil_sep) ?>
					</td>
					<td align="right"><?php if ($liquidacion['Liquidacion']['totalperdidas']) { echo $html->link(number_format($liquidacion['Liquidacion']['totalperdidas'],2,$dec_sep,$mil_sep),"#",array('onclick'=>'javascript:mostrarPerdidas('.$liquidacion['Liquidacion']['empleado_id'].');')); } else { echo "0.00"; } ?></td>			
					<td align="right"><?php if ($liquidacion['Liquidacion']['totalpremios']) { echo $html->link(number_format($liquidacion['Liquidacion']['totalpremios'],2,$dec_sep,$mil_sep),"#",array('onclick'=>'javascript:mostrarComisiones('.$liquidacion['Liquidacion']['empleado_id'].');')); } else { echo "0.00"; } ?></td>			
					<?php ($hayaguinaldo)?e("<td>".number_format($liquidacion['Liquidacion']['totalaguinaldo'],2,$dec_sep,$mil_sep)."</td>"):false; ?>
					<td>
							<?php echo $liquidacion['Empleado']['sector'] ?>
					</td>
					<td>
							<?php ($liquidacion['Empleado']['cobrabono'])?e("SI"):e("NO"); ?>
					</td>
					<td class="actions" id="<?php echo $liquidacion["Liquidacion"]["id"]; ?>-acciones">
							<?php if ($liquidacion["Liquidacion"]["estado"]=="Pendiente"): ?>
								<?php echo $html->link('Pagar',"#",array('onclick'=>'javascript:documentos('.$liquidacion['Liquidacion']['id'].','.$liquidacion['Liquidacion']['empleado_id'].');')); ?>
								<?php echo $html->link('Reclamo', array('action'=>'reclamo', $liquidacion['Liquidacion']['id'])); ?>
								<?php //echo $html->link('Conflicto', array('action'=>'conflicto', $liquidacion['Liquidacion']['id'])); ?>
								<?php 
									$documentos = "";
									foreach($liquidacion['Documentos'] as $documento) 
									{
										$documentos.=$documento['liquidaciones_tiposdocumentos']['tiposdocumento_id']."!".$documento['tiposdocumento']['nombre'].",";
									}
									$documentos=substr($documentos,0,strlen($documentos)-1);
								?>
								<input type="hidden" id="<?php echo $liquidacion["Liquidacion"]["id"]; ?>-documentos" value="<?php echo $documentos; ?>"/>
							<?php elseif ($liquidacion["Liquidacion"]["estado"]=="Modificación Aprobada"): ?>
								<?php echo $liquidacion["Liquidacion"]["estado"]." - "; ?>
								<?php echo $html->link('Pagar',"#",array('onclick'=>'javascript:documentos('.$liquidacion['Liquidacion']['id'].','.$liquidacion['Liquidacion']['empleado_id'].');')); ?>						
								<?php echo $html->link('Reclamo', array('action'=>'reclamo', $liquidacion['Liquidacion']['id'])); ?>
								<?php 
									$documentos = "";
									foreach($liquidacion['Documentos'] as $documento) 
									{
										$documentos.=$documento['liquidaciones_tiposdocumentos']['tiposdocumento_id']."!".$documento['tiposdocumento']['nombre'].",";
									}
									$documentos=substr($documentos,0,strlen($documentos)-1);
								?>
								<input type="hidden" id="<?php echo $liquidacion["Liquidacion"]["id"]; ?>-documentos" value="<?php echo $documentos; ?>"/>
							<?php else: ?>
								<?php echo $liquidacion["Liquidacion"]["estado"]; ?>
							<?php endif; ?>
							
					</td>
					<td>&nbsp;</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			<tr>
				<td colspan="2"><b>Totales</b></td>
				<td align="right"><b><?php echo $total_tango; ?></b></td>
				<td align="right"><b><?php echo $total ?></b></td>
			</tr>
			
		 </table>
	<?php endif; ?>
	
	
	<?php if (count($pagados)): ?>
			<center><h3>Liquidaciones Pagadas</h3></center>
			<table cellpadding="0" cellspacing="0" class="sortable" style="width:1250px;font-size:12px;">
				<thead>
					<tr>
						<th>Empleado</th>
						<th>Dias</th>
						<th>Importe Bono</th>
						<th>Total</th>
						<th>Total Anterior</th>
						<th>Sueldo</th>
						<th>Perdidas</th>
						<th>Comisiones</th>
						<?php ($hayaguinaldo)?e("<th>Aguinaldo</th>"):false; ?>
						<th>Sector</th>
						<th>Cobra Bono?</th>
						<th>Acciones</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
			<?php $total_tango=0 ?>
			<?php $total=0 ?>
			<?php $dec_sep='.'; $mil_sep=''; ?>
			<tbody style="overflow:auto;height:700px;">
			<?php foreach ($pagados as $liquidacion): ?>
				<tr id="<?php echo $liquidacion["Liquidacion"]["id"]; ?>">
					<td id="<?php echo $liquidacion['Empleado']['id']; ?>-nombre"><?php echo $liquidacion['Empleado']['apellido']." ".$liquidacion['Empleado']['nombre']; ?></td>
					<td><?php echo $html->link($liquidacion['Liquidacion']['dias_tango'],"#",array('onclick'=>'javascript:mostrarAusentes('.$liquidacion['Liquidacion']['empleado_id'].');'));; ?></td>
					<td align="right"><?php echo number_format($liquidacion['Liquidacion']['monto_tango'],2,$dec_sep,$mil_sep); $total_tango+=$liquidacion['Liquidacion']['monto_tango']; ?></td>
					<td align="right"><span id='totalliquidacion-<?php echo $liquidacion['Empleado']['id']; ?>'><?php echo number_format($liquidacion['Liquidacion']['total'],2,$dec_sep,$mil_sep); $total+=$liquidacion['Liquidacion']['total'];?></span></td>
					<td align="right"><?php echo number_format($liquidacion['Liquidacion']['penultimototal'],2,$dec_sep,$mil_sep);?></td>			
					<td>
							<?php echo number_format($liquidacion['Empleado']['sueldo'],2,$dec_sep,$mil_sep) ?>
					</td>
					<td align="right"><?php if ($liquidacion['Liquidacion']['totalperdidas']) { echo $html->link(number_format($liquidacion['Liquidacion']['totalperdidas'],2,$dec_sep,$mil_sep),"#",array('onclick'=>'javascript:mostrarPerdidas('.$liquidacion['Liquidacion']['empleado_id'].');')); } else { echo "0.00"; } ?></td>			
					<td align="right"><?php if ($liquidacion['Liquidacion']['totalpremios']) { echo $html->link(number_format($liquidacion['Liquidacion']['totalpremios'],2,$dec_sep,$mil_sep),"#",array('onclick'=>'javascript:mostrarComisiones('.$liquidacion['Liquidacion']['empleado_id'].');')); } else { echo "0.00"; } ?></td>			
					<?php ($hayaguinaldo)?e("<td>".number_format($liquidacion['Liquidacion']['totalaguinaldo'],2,$dec_sep,$mil_sep)."</td>"):false; ?>
					<td>
							<?php echo $liquidacion['Empleado']['sector'] ?>
					</td>
					<td>
							<?php ($liquidacion['Empleado']['cobrabono'])?e("SI"):e("NO"); ?>
					</td>
					<td class="actions" id="<?php echo $liquidacion["Liquidacion"]["id"]; ?>-acciones">
							<?php if ($liquidacion["Liquidacion"]["estado"]=="Pendiente"): ?>
								<?php echo $html->link('Pagar',"#",array('onclick'=>'javascript:documentos('.$liquidacion['Liquidacion']['id'].','.$liquidacion['Liquidacion']['empleado_id'].');')); ?>
								<?php echo $html->link('Reclamo', array('action'=>'reclamo', $liquidacion['Liquidacion']['id'])); ?>
								<?php //echo $html->link('Conflicto', array('action'=>'conflicto', $liquidacion['Liquidacion']['id'])); ?>
								<?php 
									$documentos = "";
									foreach($liquidacion['Documentos'] as $documento) 
									{
										$documentos.=$documento['liquidaciones_tiposdocumentos']['tiposdocumento_id']."!".$documento['tiposdocumento']['nombre'].",";
									}
									$documentos=substr($documentos,0,strlen($documentos)-1);
								?>
								<input type="hidden" id="<?php echo $liquidacion["Liquidacion"]["id"]; ?>-documentos" value="<?php echo $documentos; ?>"/>
							<?php elseif ($liquidacion["Liquidacion"]["estado"]=="Modificación Aprobada"): ?>
								<?php echo $liquidacion["Liquidacion"]["estado"]." - "; ?>
								<?php echo $html->link('Pagar',"#",array('onclick'=>'javascript:documentos('.$liquidacion['Liquidacion']['id'].','.$liquidacion['Liquidacion']['empleado_id'].');')); ?>						
								<?php echo $html->link('Reclamo', array('action'=>'reclamo', $liquidacion['Liquidacion']['id'])); ?>
								<?php 
									$documentos = "";
									foreach($liquidacion['Documentos'] as $documento) 
									{
										$documentos.=$documento['liquidaciones_tiposdocumentos']['tiposdocumento_id']."!".$documento['tiposdocumento']['nombre'].",";
									}
									$documentos=substr($documentos,0,strlen($documentos)-1);
								?>
								<input type="hidden" id="<?php echo $liquidacion["Liquidacion"]["id"]; ?>-documentos" value="<?php echo $documentos; ?>"/>
							<?php else: ?>
								<?php echo $liquidacion["Liquidacion"]["estado"]; ?>
							<?php endif; ?>
							
					</td>
					<td>&nbsp;</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
			<tr>
				<td colspan="2"><b>Totales</b></td>
				<td align="right"><b><?php echo $total_tango; ?></b></td>
				<td align="right"><b><?php echo $total ?></b></td>
			</tr>
			
		 </table>
	<?php endif; ?>
	
	<?php echo $html->link('Cerrar Pagos','#',array('onclick'=>'javascript:confirmarCierre();')); ?>		
	<?php else: ?>
	<h2>NO Hay Liquidaciones Asignadas a Usted en esta UEN</h2>
	<?php endif; ?>
	
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link('Cerrar Sesión',   array('controller'=>'usuarios','action'=>'logout')); ?> </li>
	</ul>
</div>
<div id="dialog-perdidas" title="Perdidas de Empleado" style="background-color:#E2EDFC;">
    <form id="actualizar_estado_documento">
        <fieldset>
            &nbsp;<label for="name">Name</label>
            <input type="text" name="name" id="name"  /><br/>
            &nbsp;<label for="email">Email</label>
            <input type="text" name="email" id="email" value=""  /><br/>
            &nbsp;<label for="password">Password</label>
            <input type="password" name="password" id="password" value=""  /><br/>
        </fieldset>
    </form>
</div>
<div id="dialog-comisiones" title="Comisiones de Empleado" style="background-color:#E2EDFC;">
    <form id="actualizar_estado_documento">
        <fieldset>
            &nbsp;<label for="name">Name</label>
            <input type="text" name="name" id="name"  /><br/>
            &nbsp;<label for="email">Email</label>
            <input type="text" name="email" id="email" value=""  /><br/>
            &nbsp;<label for="password">Password</label>
            <input type="password" name="password" id="password" value=""  /><br/>
        </fieldset>
    </form>
</div>
<div id="dialog-ausentes" title="Ausentes de Empleado" style="background-color:#E2EDFC;">
    <form id="actualizar_estado_documento">
        <fieldset>
            &nbsp;<label for="name">Name</label>
            <input type="text" name="name" id="name"  /><br/>
            &nbsp;<label for="email">Email</label>
            <input type="text" name="email" id="email" value=""  /><br/>
            &nbsp;<label for="password">Password</label>
            <input type="password" name="password" id="password" value=""  /><br/>
        </fieldset>
    </form>
</div>
<div id="dialog-documentos" title="Documentación Entregada a Empleado" style="background-color:#E2EDFC;">
    <form id="actualizar_estado_documento">
        <fieldset>
            &nbsp;<label for="name">Name</label>
            <input type="text" name="name" id="name"  /><br/>
            &nbsp;<label for="email">Email</label>
            <input type="text" name="email" id="email" value=""  /><br/>
            &nbsp;<label for="password">Password</label>
            <input type="password" name="password" id="password" value=""  /><br/>
        </fieldset>
    </form>
</div>
<span id="mes" style="visibility:hidden;"><?php echo date("m",strtotime($periodo)); ?></span>
<span id="anio" style="visibility:hidden;"><?php echo date("Y",strtotime($periodo)); ?></span>
<?php echo $this->Html->script('liquidaciones'); ?>