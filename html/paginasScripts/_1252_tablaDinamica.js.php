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

	$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso(1251,$idReferencia);
	
	$consulta="SELECT unidadGestion,tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$fRegistroDespacho=$con->obtenerPrimeraFilaAsoc($consulta);
	$unidadGestion=$fRegistroDespacho["unidadGestion"];
	$tipoCarpetaAdministrativa=$fRegistroDespacho["tipoCarpetaAdministrativa"];
	
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
	
	
	
	$consulta="SELECT fechaActual FROM 3505_fechaPublicacionModificaciones WHERE iFormulario=1251 AND iRegistro=".$idReferencia." ORDER BY idRegistro DESC";
	$fechaModificada=$con->obtenerValor($consulta);
	
	$esProvidenciaFijacionLista=esProvidenciaFijacionLista(1251,$idReferencia);	
	
	$consulta="SELECT upper(p.nombreFormato) FROM 9074_documentosRegistrosProceso d,908_archivos a,3000_formatosRegistrados f,_10_tablaDinamica p 
				WHERE d.idFormulario=1251 AND d.idRegistro=".$idReferencia." AND a.idArchivo=d.idDocumento AND f.idDocumento=a.idArchivo
				AND p.id__10_tablaDinamica=f.tipoFormato order by idDocumentoRegistro desc";
	$lblActuacion=$con->obtenerValor($consulta);
	
	if($lblActuacion=="")
	{
		$consulta="SELECT upper(c.nombreCategoria) FROM 9074_documentosRegistrosProceso d,908_archivos a,908_categoriasDocumentos c WHERE idFormulario=1251 AND idRegistro=".$idReferencia."
				AND a.idArchivo=d.idDocumento AND c.idCategoria=a.categoriaDocumentos order by idDocumentoRegistro desc";
		$lblActuacion=$con->obtenerValor($consulta);
	}
	
	
	

	
?>
var lblActuacion='<?php echo $lblActuacion?>';
var arrFijacionLista=[['4','Fijación en lista']];
var arrPrimeraInstancia=[['1','Mediante estado'],['3','No notificar']];
var arrSegundaInstancia=[['4','Fijación en lista'],['2','Mediante edicto'],['1','Mediante estado'],['3','No notificar']];


var esProvidenciaFijacionLista=<?php echo $esProvidenciaFijacionLista==1?"true":"false"; ?>;
var tipoCarpetaAdministrativa=<?php echo $tipoCarpetaAdministrativa?>;
var fechaPublicacion='<?php echo $fechaPublicacion?>';
var fechaModificada='<?php echo $fechaModificada?>';
function inyeccionCodigo()
{
    if(esRegistroFormulario())
    {
    	
        if(gE('idRegistroG').value=='-1')
      	{
            gEx('f_sp_fechaPublicaciondte').setValue('<?php echo $fechaModificada==""?$fechaPublicacion:$fechaModificada?>');
               
            gEx('f_sp_fechaPublicaciondte').fireEvent('change', gEx('f_sp_fechaPublicaciondte'), gEx('f_sp_fechaPublicaciondte').getValue());
            gEx('f_sp_fechaPublicaciondte').fireEvent('select', gEx('f_sp_fechaPublicaciondte'));
            gEx('f_sp_fechaPublicaciondte').disable();
           
           	gE('_resumenActuacionmem').value=lblActuacion;
            
            limpiarCombo(gE('_metodoNotificacionvch'));
            if(esProvidenciaFijacionLista)
            {
                limpiarCombo(gE('_metodoNotificacionvch'));
                llenarCombo(gE('_metodoNotificacionvch'),arrFijacionLista,true);
            }
            else
            {
                if(tipoCarpetaAdministrativa==1)
                {
                    
                    llenarCombo(gE('_metodoNotificacionvch'),arrPrimeraInstancia,true);
                }
                else
                {
                    llenarCombo(gE('_metodoNotificacionvch'),arrSegundaInstancia,true);
                }
            }
            
            if(gE('_metodoNotificacionvch').options.length==2)
            {
                gE('_metodoNotificacionvch').selectedIndex=1;
            }
                        
            			

            
         }
         else
         {
         	var opcionSeleccionada=gE('_metodoNotificacionvch').options[gE('_metodoNotificacionvch').selectedIndex].value;
         	selElemCombo(gE('_metodoNotificacionvch'),opcionSeleccionada);
         }           
                    
                    
		new Ext.Button	(
                            {
                                icon:'../images/pencil.png',
                                cls:'x-btn-text-icon',
                                renderTo:'sp_16209',
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
    	gE('sp_16210').innerHTML='<span style="font-size:14px">La fecha de publicaci&oacute;n ha presentado modificaciones,<br />para ver dichos cambios dé click'+
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
                                                                                                    value:gEx('f_sp_fechaPublicaciondte').getValue(),
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
                                                                        
                                                                        
                                                                        var cadObj='{"iFormulario":"1251","iRegistro":"<?php echo $idReferencia?>","fechaOriginal":"'+
                                                                        gEx('f_sp_fechaPublicaciondte').getValue().format('Y-m-d')+'","fechaActual":"'+gEx('fechaPublicacion').getValue().format('Y-m-d')+
                                                                        '","motivoCambio":"'+cv(gEx('txtMotivoCambio').getValue())+'"}';
                                                                        
                                                                        
                                                                        function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        gEx('f_sp_fechaPublicaciondte').setValue(gEx('fechaPublicacion').getValue());
                                                                                        gE('_fechaPublicaciondte').value=gEx('f_sp_fechaPublicaciondte').getValue().format('d/m/Y');
                                                                                
                                                                                        
                                                                                        gE('sp_16210').innerHTML=	'<span style="font-size:14px">La fecha de publicaci&oacute;n ha presentado modificaciones,<br />para ver dichos cambios dé click'+
																										        	' <a href="javascript:mostrarVentanaHistorialAjusteFecha()"><span style="color:#F00; font-weight:bold">AQUI</span></a></span>';
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php',funcAjax, 'POST','funcion=13&cadObj='+cadObj,true);

                                                                            
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
                                        proxy.baseParams.idFormulario=1251;
                                        proxy.baseParams.idRegistro='<?php echo $idReferencia?>';
                                        
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
