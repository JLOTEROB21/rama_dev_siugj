<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$iF=$_GET["iF"];
	$iR=$_GET["iR"];
	$fechaActual=date("Y-m-d");
	
	$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($iF,$iR);
	
	$consulta="SELECT t.id__17_tablaDinamica,c.tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas c,_17_tablaDinamica t 
			WHERE c.carpetaAdministrativa='".$carpetaAdministrativa."' AND c.unidadGestion=t.claveUnidad";
	$fCarpeta=$con->obtenerPrimeraFila($consulta);
	
	$idUnidad=$fCarpeta[0];
	
	$tipoJuez="";
	switch($fCarpeta[1])
	{
		case 1:
			$tipoJuez=1;
		break;
		case 5:
			$tipoJuez=2;
		break;
		case 6:
			$tipoJuez=3;
		break;
	}
	$tramite=0;	
	$arrJueces="";
	$consulta="SELECT usuarioJuez,CONCAT('[',clave,'] ',u.Nombre) FROM _26_tablaDinamica j,800_usuarios u,_26_tipoJuez tJ WHERE idReferencia=".$idUnidad.
			" AND u.idUsuario=j.usuarioJuez and tJ.idPadre=j.id__26_tablaDinamica and tJ.idOpcion in(".$tipoJuez.") ORDER BY clave";
	$res=$con->obtenerFilas($consulta);		
	while($fila=mysql_fetch_row($res))
	{
		$comp="";
		
		if(esJuezTramite($fila[0],$fechaActual))
		{
			$comp.=utf8_encode(" (Juez de tr\xE1mite)");
			$tramite=$fila[0];
		}
		$o="['".$fila[0]."','".$fila[1].$comp."']";
		if($arrJueces=="")
			$arrJueces=$o;
		else
			$arrJueces.=",".$o;
	}
	
?>

var juezTramite='<?php echo $tramite?>';
var arrJueces=[<?php echo $arrJueces?>];
var iFormulario=<?php echo $iF?>;
var iRegistro=<?php echo $iR?>;

var arrSituacionMensaje=[[2,'En espera de respuesta','900'],[3,'Respondido','0F6B01']];
function mostrarVentanaHistorialMensaje()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridMensajes()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial de mensajes',
										width: 800,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
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
function mostrarVentanaEnviarMensaje()
{
	var cmbDestinatario=crearComboExt('cmbDestinatario',arrJueces,140,5,450);
    if(juezTramite!='0')
	    cmbDestinatario.setValue(juezTramite);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'label',
                                                            x:10,
                                                            y:10,
                                                            html:'Destinatario:'
                                                        },
                                                        cmbDestinatario,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:40,
                                                            html:'Mensaje a enviar:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            width:650,
                                                            height:80,
                                                            x:10,
                                                            y:70,
                                                            id:'txtMensaje'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Enviar mensaje',
										width: 700,
										height:250,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('cmbDestinatario').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
																		if(cmbDestinatario.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbDestinatario.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar el destinatario del mensaje',resp);
                                                                        	return;
                                                                        }
                                                                        var txtMensaje=gEx('txtMensaje');
                                                                        if(txtMensaje.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtMensaje.focus();
                                                                            }
                                                                        	msgBox('Debe escribir el mensaje a enviar',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idFormulario":"'+iFormulario+'","idRegistro":"'+iRegistro+
                                                                        		'","destinatario":"'+cmbDestinatario.getValue()+'","mensaje":"'+
                                                                                cv(txtMensaje.getValue())+'","actorEnvio":"'+bD(gE('actor').value)+'"}';
                                                                        
                                                                        
                                                                        function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                           	 	function funcAjax(peticion_http)
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        gEx('gMensajeEnviados').getStore().reload();
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=236&cadObj='+cadObj,true);
                                                                            }
                                                                        
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer enviar el mensaje a <b>'+cmbDestinatario.getRawValue()+'</b>?',resp);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
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

function crearGridMensajes()
{

	  var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idMensaje'},
                                                        {name:'enviadoPor'},
		                                                {name: 'fechaEnvio', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name:'nombreUsuarioEnvio'},
		                                                {name:'comentarios'},
                                                        {name: 'comentarioRespuesta'},
                                                        {name: 'fechaRespuesta', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'situacion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaEnvio', direction: 'ASC'},
                                                            groupField: 'fechaEnvio',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='235';
                                        proxy.baseParams.idFormulario=iFormulario;
                                        proxy.baseParams.idRegistro=iRegistro;
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        
                                                        {
                                                            header:'Fecha de env&iacute;o',
                                                            width:120,
                                                            sortable:true,
                                                            dataIndex:'fechaEnvio',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val.format('d/m/Y H:i');
                                                                    }
                                                        },
                                                        {
                                                            header:'Enviado por',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'enviadoPor'
                                                        },
                                                        {
                                                            header:'Enviado a',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'nombreUsuarioEnvio'
                                                        },
                                                        {
                                                            header:'Situaci&oacute;n actual',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'situacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrSituacionMensaje,val);
                                                                    	return '<span style="color:#'+arrSituacionMensaje[pos][2]+'"><b>'+formatearValorRenderer(arrSituacionMensaje,val,1,true)+'</b></span>';
                                                                    }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gMensajeEnviados',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true, 
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/email_go.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Enviar Mensaje',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaEnviarMensaje();
                                                                                    }
                                                                            
                                                                        }
                                                                     ]    ,                                                       
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false,
                                                                                                enableRowBody:true,
                                                                            					getRowClass : formatearFilaRegistro
                                                                                            })
                                                        }
                                                    );
    return 	tblGrid;	
}

function formatearFilaRegistro(record, rowIndex, p, ds) 
{

	var xf = Ext.util.Format;
    p.body = '<br><br><table width="100%"><tr height="21"><td width="30"></td><td><br><b>Mensaje enviado:</b><br><br>'+record.data.comentarios.trim()+'</td></tr>';
    if(parseFloat(record.data.situacion)==3)
    {
        p.body +=	'<tr height="21"><td width="30"></td><td><br><b>Mensaje de respuesta'+(record.data.fechaRespuesta?' ('+record.data.fechaRespuesta.format("d/m/Y H:i")+' hrs.)':'')+':</b><br><br>'+(record.data.comentarioRespuesta.trim()==''?'(Sin comentario de respuesta)':record.data.comentarioRespuesta);
        p.body +=   '</td></tr>';
    }
    p.body +=   '</table><br><br>';
    return 'x-grid3-row-expanded';
}

function mostrarVentanaEnviarRespuestaMensajeMensaje()
{

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:10,
                                                            html:'Mensaje de respuesta a enviar:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            width:650,
                                                            height:80,
                                                            x:10,
                                                            y:40,
                                                            id:'txtMensaje'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Enviar mensaje',
										width: 700,
										height:220,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtMensaje').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
																		
                                                                        var txtMensaje=gEx('txtMensaje');
                                                                        if(txtMensaje.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtMensaje.focus();
                                                                            }
                                                                        	msgBox('Debe escribir la respuesta del mensaje a enviar',resp2);
                                                                        	return;

                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idFormulario":"'+iFormulario+'","idRegistro":"'+iRegistro+
                                                                        		'","mensaje":"'+cv(txtMensaje.getValue())+'"}';
                                                                        function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                           	 function funcAjax(peticion_http)
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                    window.parent.cerrarVentanaFancy();
                                                                                    ventanaAM.close();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=237&cadObj='+cadObj,true);
                                                                            }
                                                                        
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer enviar la respuesta del mensaje?',resp);
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
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





//-----


function mostrarVentanaHistorialMensajeDestinatario()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridMensajesDestinatario()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial de mensajes',
										width: 800,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
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



function crearGridMensajesDestinatario()
{
	
	  var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idMensaje'},
                                                        {name: 'enviadoPor'},
		                                                {name: 'fechaEnvio', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name: 'nombreUsuarioEnvio'},
		                                                {name: 'comentarios'},
                                                        {name: 'comentarioRespuesta'},
                                                        {name: 'fechaRespuesta', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'situacion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaEnvio', direction: 'ASC'},
                                                            groupField: 'fechaEnvio',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='238';
                                        proxy.baseParams.idRegistro=iRegistro;
                                        proxy.baseParams.idUsuario=<?php echo $_SESSION["idUsr"]?>;
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        
                                                        {
                                                            header:'Fecha de env&iacute;o',
                                                            width:110,
                                                            sortable:true,
                                                            dataIndex:'fechaEnvio',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val.format('d/m/Y H:i');
                                                                    }
                                                        },
                                                        {
                                                            header:'Enviado por',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'enviadoPor'
                                                        },
                                                        {
                                                            header:'Enviado a',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'nombreUsuarioEnvio'
                                                        },
                                                        {
                                                            header:'Situaci&oacute;n actual',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'situacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrSituacionMensaje,val);
                                                                    	return '<span style="color:#'+arrSituacionMensaje[pos][2]+'"><b>'+formatearValorRenderer(arrSituacionMensaje,val,1,true)+'</b></span>';
                                                                    }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gMensajeEnviados',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true, 
                                                                                                                     
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false,
                                                                                                enableRowBody:true,
                                                                            					getRowClass : formatearFilaRegistroDestinatario
                                                                                            })
                                                        }
                                                    );
    return 	tblGrid;	
}

function formatearFilaRegistroDestinatario(record, rowIndex, p, ds) 
{

	var xf = Ext.util.Format;
    p.body = '<br><br><table width="100%"><tr height="21"><td width="30"></td><td><br><b>Mensaje recibido:</b><br><br>'+record.data.comentarios.trim()+'</td></tr>';
    if(parseFloat(record.data.situacion)==3)
    {
        p.body +=	'<tr height="21"><td width="30"></td><td><br><b>Mensaje de respuesta'+(record.data.fechaRespuesta?' ('+record.data.fechaRespuesta.format("d/m/Y H:i")+' hrs.)':'')+':</b><br><br>'+(record.data.comentarioRespuesta.trim()==''?'(Sin comentario de respuesta)':record.data.comentarioRespuesta);
        p.body +=   '</td></tr>';
    }
    p.body +=   '</table><br><br>';
    return 'x-grid3-row-expanded';
}