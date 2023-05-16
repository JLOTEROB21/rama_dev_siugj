<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	include_once("SIUGJ/libreriasFuncionesDespachos.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);
	$idReferencia=$_GET["iRef"];

	$fechaActual=date("Y-m-d")	;

	$horaActual=date("H:i");

	$unidadGestion=$_SESSION["codigoInstitucion"];
	
	$fechaActual=strtotime(date("Y-m-d H:i:s"));
	$idPerfil=obtenerPerfilHorarioLaboralDespacho($unidadGestion);
	$dia=date("w",$fechaActual);
	
	
	$consulta="SELECT horaInicial,horaTermino FROM 7022_diasHorarioPerilHorario WHERE idReferencia=".$idPerfil." AND dia=".$dia;
	$fRegistroHorario=$con->obtenerPrimeraFilaAsoc($consulta);
	$inicioJornadaDia=$fRegistroHorario?$fRegistroHorario["horaInicial"]:"07:00";
	$finJornadaDia=$fRegistroHorario?$fRegistroHorario["horaTermino"]:"17:00";
	$fechaPublicacion="";
	if(esDiaHabilInstitucion(date("Y-m-d",$fechaActual),$unidadGestion))
	{
		
		$fInicial=strtotime(date("Y-m-d",$fechaActual)." ".$inicioJornadaDia);	
		$fFinal=strtotime(date("Y-m-d",$fechaActual)." ".$finJornadaDia);	
		
		if($fechaActual>$fFinal)
		{
			$fechaActual=strtotime("+1 days",$fechaActual);
			$fechaPublicacion=obtenerSiguienteDiaHabil(date("Y-m-d",$fechaActual),$unidadGestion);
		}
		else
		{
			
			$fechaPublicacion=date("Y-m-d",$fechaActual);
		}
	}
	else
	{
		
		$fechaPublicacion=obtenerSiguienteDiaHabil(date("Y-m-d",$fechaActual),$unidadGestion);
	}
	
	$fechaModificada="";
	if($idRegistro!=-1)
	{
		$consulta="SELECT fechaActual FROM 3505_fechaPublicacionModificaciones WHERE iFormulario=".$idFormulario." AND iRegistro=".$idRegistro." ORDER BY idRegistro DESC";
		$fechaModificada=$con->obtenerValor($consulta);
	}
?>

var cadenaFuncionValidacion='prepararCambioFecha';
var objCambioFecha='';
var fechaPublicacion='<?php echo $fechaPublicacion?>';
var fechaModificada='<?php echo $fechaModificada?>';
function inyeccionCodigo()
{
    if(esRegistroFormulario())
    {
    	
    	gEx('f_sp_fechaEstimadaEstadodte').setValue('<?php echo $fechaModificada==""?$fechaPublicacion:$fechaModificada?>');
           
        gEx('f_sp_fechaEstimadaEstadodte').fireEvent('change', gEx('f_sp_fechaEstimadaEstadodte'), gEx('f_sp_fechaEstimadaEstadodte').getValue());
        gEx('f_sp_fechaEstimadaEstadodte').fireEvent('select', gEx('f_sp_fechaEstimadaEstadodte'));
        gEx('f_sp_fechaEstimadaEstadodte').disable();
       
       	
       
		new Ext.Button	(
                            {
                                icon:'../images/pencil.png',
                                cls:'x-btn-text-icon',
                                renderTo:'sp_16211',
                                cls:'btnSIUGJCancel',
                                width:50,
                                handler:function()
                                        {
                                            mostrarVentanaFechaPublicacion();
                                        }
                                
                            }
                        )                    
       
    }
    if(fechaModificada!='')
    {
    	gE('sp_16212').innerHTML='<span style="font-size:14px">La fecha de publicaci&oacute;n ha presentado modificaciones,<br />para ver dichos cambios dé click'+
        ' <a href="javascript:mostrarVentanaHistorialAjusteFecha()"><span style="color:#F00; font-weight:bold">AQUI</span></a></span>';
    }
    
}



function mostrarVentanaFechaPublicacion()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Fecha de publicaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:210,
                                                            y:5,
                                                            html:'<div id="divFechaPublicacion"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:50,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Motivo del cambio:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            width:660,
                                                            x:10,
                                                            y:80,
                                                            cls:'controlSIUGJ',
                                                            id:'txtMotivoCambio',
                                                            height:80
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar fecha publicaci&oacute;n',
										width: 700,
										height:320,
                                        cls:'msgHistorialSIUGJ',
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	new Ext.form.DateField	(
                                                                    							{
                                                                                                	id:'fechaPublicacion',
                                                                                                    renderTo:'divFechaPublicacion',
                                                                                                    value:gEx('f_sp_fechaEstimadaEstadodte').getValue(),
                                                                                                    minValue:'<?php echo $fechaActual?>',
                                                                                                    ctCls:'campoFechaSIUGJ'
                                                                                                }
                                                                                             )
																}
															}
												},
										buttons:	[
														
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    
                                                                    
                                                                    	if(gEx('fechaPublicacion').getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
	                                                                            gEx('fechaPublicacion').focus()	
                                                                            }
                                                                            msgBox('Debe indicar la fecha de publicaci&oacute;n',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        	
                                                                    
																		var txtMotivoCambio=gEx('txtMotivoCambio');
                                                                        if(txtMotivoCambio.getValue()=='')
                                                                        {
                                                                        	function respAux()
                                                                            {
                                                                            	gEx('txtMotivoCambio').focus();
                                                                            }
                                                                            msgBox('Debe indicar el motivo del cambio',respAux);
                                                                            return;
                                                                            
                                                                        }
                                                                        
                                                                        function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	objCambioFecha='{"iFormulario":"<?php echo $idFormulario?>","iRegistro":"<?php echo $idRegistro?>","fechaOriginal":"'+
                                                                                                gEx('f_sp_fechaEstimadaEstadodte').getValue().format('Y-m-d')+'","fechaActual":"'+gEx('fechaPublicacion').getValue().format('Y-m-d')+
                                                                                                '","motivoCambio":"'+cv(gEx('txtMotivoCambio').getValue())+'"}';
                                                                            	gEx('f_sp_fechaEstimadaEstadodte').setValue(gEx('fechaPublicacion').getValue());
                                                                                
                                                                                
                                                                                gE('_fechaEstimadaEstadodte').value=gEx('f_sp_fechaEstimadaEstadodte').getValue().format('d/m/Y');
                                                                                
                                                                                ventanaAM.close();
                                                                            
                                                                            }
                                                                        }
                                                                        msgConfirm('¿Est&aacute; seguro de querer modificar la fecha de publicaci&oacute;n?',resp);
                                                                        
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}


function mostrarVentanaHistorialAjusteFecha()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			crearGridHistorial()	
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificaciones a fecha de publicaci&oacute;n',
										width: 910,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}

function crearGridHistorial()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'fechaOriginal', type:'date', dateFormat:'Y-m-d'},
		                                                {name:'fechaCambio', type:'date', dateFormat:'Y-m-d'},
		                                                {name:'responsable'},
                                                        {name: 'comentarios'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(
                                                                                              {
                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php'
                                                                                              }
                                                                                          ),
                                                            sortInfo: {field: 'fechaCambio', direction: 'DESC'},
                                                            groupField: 'fechaCambio',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='14';
                                        proxy.baseParams.idFormulario=<?php echo $idFormulario?>;
                                        proxy.baseParams.idRegistro='<?php echo $idRegistro?>';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'Fecha',
                                                                width:210,
                                                                sortable:false,
                                                                menuDisabled :true,
                                                                align:'center',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val,meta,attr)
                                                                		{
                                                                        	meta.attr='style="height:auto;"';
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>'+val.format('H:i:s')+' hrs.');
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha original',
                                                                width:190,
                                                                menuDisabled :true,
                                                                sortable:false,
                                                                dataIndex:'fechaOriginal',
                                                                renderer:formatoTitulo2
                                                            },
                                                            {
                                                                header:'Fecha cambio',
                                                                width:190,
                                                                sortable:false,
                                                                menuDisabled :true,
                                                                dataIndex:'fechaCambio',
                                                                renderer:formatoTitulo2
                                                            },                                                            
                                                            {
                                                                header:'Responsable',
                                                                width:220,
                                                                menuDisabled :true,
                                                                sortable:false,
                                                                dataIndex:'responsable',
                                                                renderer:formatoTitulo3
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorialFechaPublicacion',
                                                        store:alDatos,
                                                        region:'center',
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,
                                                        cls:'gridSiugjSeccion',                                                                
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorial
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	
}

function formatearFilaHistorial(record, rowIndex, p, ds)
{
	var xf = Ext.util.Format;
    p.body = '<BR><p style="margin-left: 4em;margin-right: 4em;text-align:justify"><br><span class="letraInfoHistorialSIUGJ">Motivo del cambio:<br><br>' + ((record.data.comentarios.trim()=="")?"(Sin comentarios)":record.data.comentarios) + '<span></p><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTitulo(val)
{
	return '<span class="letraInfoHistorialSIUGJ">'+val+'</span>';
}

function formatoTitulo2(val)
{
	return '<div class="letraInfoHistorialSIUGJ">'+val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'</div>';
}

function formatoTitulo3(val)
{
	return '<div class="letraInfoHistorialSIUGJ">'+(val)+'</div>';
}


function prepararCambioFecha()
{
	if(objCambioFecha=='')
    	return true;
    
    var id=<?php echo $idRegistro?>;
	if(id=='-1')
    {
        gE('funcPHPEjecutarNuevo').value=bE(bD(gE('funcPHPEjecutarNuevo').value)+'|modificarFechaPublicacionNotificacion(@idRegPadre,\''+bE(objCambioFecha)+'\')');
    }
    else
    {
        gE('funcPHPEjecutarModif').value=bE('modificarFechaPublicacionNotificacion('+id+',\''+bE(objCambioFecha)+'\')');
    }
    
    
    return true;
    
}