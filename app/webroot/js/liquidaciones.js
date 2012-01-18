function mostrarPerdidas(empleado_id)
{
	mes = $("#mes").html();
	anio = $("#anio").html();
	$.getJSON( "/rumaos/sueldosuen/perdidas/porempleadoyperiodo/"+empleado_id+"/"+mes+"/"+anio,  function(data)
                { 
						if (data.length>0)
						{
							htmlContent="<h2>Perdidas de "+$("#"+empleado_id+"-nombre").html()+"</h2><table><tr><th>Fecha</th><th>UEN</th><th>Tipo Perdida</th><th>Monto</th></tr>";
							for (i=0; i<data.length;i++)
							{
								htmlContent+="<tr><td>"+data[i].Perdida.fecha.substr(8,10)+"/"+data[i].Perdida.fecha.substr(5,2)+"/"+data[i].Perdida.fecha.substr(0,4)+"</td><td>"+data[i].Uen.nombre+"</td><td>"+data[i].Tipoperdida.nombre+"</td><td align='right'>"+parseFloat(data[i].Perdida.monto).toFixed(2)+"</td></tr>";
							}
							htmlContent+="</table>";
							$( "#dialog-perdidas" ).html(htmlContent);
                            $( "#dialog-perdidas" ).dialog( "open" );
						}
						else
						{
							alert("El Empleado no tiene Perdidas en el Mes");
						}

                }
    ); 
}
function mostrarComisiones(empleado_id)
{
	mes = $("#mes").html();
	anio = $("#anio").html();
	$.getJSON( "/rumaos/sueldosuen/comisiones/porempleadoyperiodo/"+empleado_id+"/"+mes+"/"+anio,  function(data)
                { 
						if (data.length>0)
						{
							htmlContent="<h2>Comisiones de "+$("#"+empleado_id+"-nombre").html()+"</h2><table><tr><th>Fecha</th><th>Tipo Comision</th><th>Monto</th></tr>";
							for (i=0; i<data.length;i++)
							{
								htmlContent+="<tr><td>"+data[i].Comision.fecha.substr(8,10)+"/"+data[i].Comision.fecha.substr(5,2)+"/"+data[i].Comision.fecha.substr(0,4)+"</td><td>"+data[i].Tipocomision.nombre+"</td><td align='right'>"+parseFloat(data[i].Comision.monto).toFixed(2)+"</td></tr>";
							}
							htmlContent+="</table>";
							$( "#dialog-perdidas" ).html(htmlContent);
                            $( "#dialog-perdidas" ).dialog( "open" );
						}
						else
						{
							alert("El Empleado no tiene Comisiones en el Mes");
						}

                }
    ); 
}
function mostrarAusentes(empleado_id)
{
	mes = $("#mes").html();
	anio = $("#anio").html();
	$.getJSON( "/rumaos/sueldosuen/ausentes/porempleadoyperiodo/"+empleado_id+"/"+mes+"/"+anio,  function(data)
                { 
						if (data.length>0)
						{
							htmlContent="<h2>Ausentes de "+$("#"+empleado_id+"-nombre").html()+"</h2><table><tr><th>Fecha</th><th>UEN</th><th>Motivo</th><th>Accion Correctiva</th></tr>";
							for (i=0; i<data.length;i++)
							{
								htmlContent+="<tr><td>"+data[i].Ausente.fecha.substr(8,10)+"/"+data[i].Ausente.fecha.substr(5,2)+"/"+data[i].Ausente.fecha.substr(0,4)+"</td><td>"+data[i].Uen.nombre+"</td><td>"+data[i].Ausente.motivo+"</td><td>"+data[i].Ausente.accion_correctiva+"</td></tr>";
							}
							htmlContent+="</table>";
							$( "#dialog-ausentes" ).html(htmlContent);
                            $( "#dialog-ausentes" ).dialog( "open" );
						}
						else
						{
							alert("El Empleado no tiene Ausentes en el Mes");
						}

                }
    ); 
}
function documentos(liquidacion_id,empleado_id)
{
	documentosHtml = $("#"+liquidacion_id+"-documentos").val();
	documentosEmpleado = documentosHtml.split(',');
	htmlContent="<h2>Documentación de "+$("#"+empleado_id+"-nombre").html()+"</h2><table><tr><th>Entregado</th><th>Tipo Documento</th></tr>";
	for (i=0; i<documentosEmpleado.length;i++)
	{
		documento = documentosEmpleado[i].split('!');
		htmlContent+="<tr><td><input type='checkbox' checked='true' name='' class='documento' id='"+documento[0]+"'/></td><td>"+documento[1]+"</td></tr>";
	}
	htmlContent+="</table>";
	htmlContent+="<input id='liquidacion_actual' type='hidden' value='"+liquidacion_id+"' />";
	htmlContent+="<h3>Observaciones</h3>"
	htmlContent+="<textarea id='pagada_conflicto' name='pagada_conflicto' cols='50' rows='5'></textarea>";
	$( "#dialog-documentos" ).html(htmlContent);
	$( "#dialog-documentos" ).dialog( "open" );
}
function pagar(liquidacion_id,pagada_conflicto)
{
	strDocumentos = "";
	if (liquidacion_id ==0)
	{
		liquidacion_id=$('#liquidacion_actual').val();
		
		$('.documento').each(function(element)
			{
				if ($(this).attr('checked'))
					strDocumentos+=$(this).attr("id")+",";
			}
		);
	}
	observaciones=$('#pagada_conflicto').val();
	$.get( "/rumaos/sueldosuen/liquidaciones/pagar/"+liquidacion_id+"/"+strDocumentos+"/"+pagada_conflicto+"/"+observaciones,  function(data)
                { 
                        
						datos=data.split('|');
                        if (datos[0].search("estado actualizado")!=-1)
                        {
							//alert($("#"+liquidacion_id+"-acciones").html());
							$("#"+liquidacion_id+"-acciones").html("<b>Pagada</b>")
							
                        }
                        else
                        {
                            alert("Un error ha ocurrido al intentar actualizar la liquidacion "+liquidacion_id);
                        }
						
                }
    ); 

}
function confirmarCierre()
{
	if (confirm("Transfiere sueldo y documentación de pagos pendientes y conflictivos a otra UEN?"))
	{
		location.href="./transferir";
	}
	else
	{
		location.href="./cerrarpagos";
	}
}
$( "#dialog-perdidas" ).dialog({
            autoOpen: false,
            height: 400,
            width: 750,
            modal: true,
            buttons: {
                "Cerrar": function() {
                        $( this ).dialog( "close" );
                    }
            },
            close: function() {
            }
        } );
$( "#dialog-comisiones" ).dialog({
            autoOpen: false,
            height: 400,
            width: 750,
            modal: true,
            buttons: {
                "Cerrar": function() {
                        $( this ).dialog( "close" );
                    }
            },
            close: function() {
            }
        } );		
$( "#dialog-ausentes" ).dialog({
            autoOpen: false,
            height: 400,
            width: 750,
            modal: true,
            buttons: {
                "Cerrar": function() {
                        $( this ).dialog( "close" );
                    }
            },
            close: function() {
            }
        } );				
$( "#dialog-documentos" ).dialog({
            autoOpen: false,
            height: 470,
            width: 750,
            modal: true,
            buttons: {
                "Cancelar": function() {
                        $( this ).dialog( "close" );
                    },
				"Pagar": function() {
                        pagar(0,0);
						$( this ).dialog( "close" );
                    },
				"Pagar con Conflicto": function() {
                        pagar(0,1);
						$( this ).dialog( "close" );
                    }
            },
            close: function() {
            }
        } );				