<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$anioActual=date("Y");
	$arrAnios="";
	for($x=2011;$x<=$anioActual;$x++)
	{
		if($arrAnios=="")
			$arrAnios="['".$x."','".$x."']";
		else
			$arrAnios.=",['".$x."','".$x."']";
	}
	
?>
var arrAnios=[<?php echo $arrAnios?>];
Ext.onReady(inicializar);


function inicializar()
{
	new Ext.Viewport(	{
                            layout: 'border',
                            items: [
                            			{
                                        	xtype:'panel',
                                            region:'center',
                                            layout:'border',
                                            title: '<span class="letraRojaSubrayada8">Comentarios/Dudas</span>',
                                            items:[crearGridComentarios()]
										}
                                   ]                                            
						}
					)                                                           

}

function crearGridComentarios()
{
   var cmbSituacion=crearComboExt('cmbSituacion',[['1','En espera de atenci\xF3n'],['0','Atendido'],['1,0','Cualquier situaci\xF3n']]);
   cmbSituacion.setValue('1');
   cmbSituacion.on('select',function(cmb,registro)
   							{
                            	gEx('gridComentarios').getStore().reload();
                            }
   				)

	var cmbCiclo=crearComboExt('cmbCiclo',arrAnios,0,0,130);   
    cmbCiclo.setValue('<?php echo $anioActual?>');
   	cmbCiclo.on('select',function(cmb,registro)
   							{
                            	gEx('gridComentarios').getStore().reload();
                            }
   				)             
   var lector= new Ext.data.JsonReader({
                                        
                                        totalProperty:'numReg',
                                        fields: [
                                                    {name:'idComentario'},
                                                    {name: 'fechaComentario', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                    {name:'responsableComentario'},
                                                    {name:'emailResponsable'},
                                                    {name:'comentario'},
                                                    {name:'situacion'},
                                                    {name: 'fechaAtencion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                    {name:'responsableAtencion'},
                                                    {name: 'respuestaAtencion'}
                                                ],
                                        root:'registros'
                                        
                                    }
                                  );
 
                                                                                  
	var alDatos=new Ext.data.GroupingStore({
                                                        reader: lector,
                                                        proxy : new Ext.data.HttpProxy	(

                                                                                          {

                                                                                              url: '../paginasFunciones/funcionesPortal.php'

                                                                                          }

                                                                                      ),
                                                        sortInfo: {field: 'fechaComentario', direction: 'ASC'},
                                                        groupField: 'fechaComentario',
                                                        remoteGroup:false,
                                                        remoteSort: false,
                                                        autoLoad:true
                                                        
                                                    }) 
	alDatos.on('beforeload',function(proxy)
                                {
                                    proxy.baseParams.funcion='80';
                                    proxy.baseParams.situacion=cmbSituacion.getValue();
                                    proxy.baseParams.ciclo=cmbCiclo.getValue();

                                }
                    )   
   
   
    var expander = new Ext.ux.grid.RowExpander({
                                                        column:2,
                                                        tpl : new Ext.Template(
                                                                                    '<br /><p style="margin-left: 5em;margin-right: 3em;text-align:left"><span class="copyrigthSinPaddingNegro"><table>'+
                                                                                    '<tr height="21"><td></td><td colspan="2">'+
                                                                                    '<table width="800">'+
                                                                                    '<tr height="21"><td width="150"><span class="letraRojaSubrayada8">Duda/Comentario:</span></td>'+
                                                                                    '<td width="600"><span class="letraExt">{comentario}</span></td></tr>'+
                                                                                    '<tr height="21"><td width="150"><span class="letraRojaSubrayada8">Atendido por:</span></td>'+
                                                                                    '<td width="600"><span class="letraExt">{responsableAtencion}</span></td></tr>'+
                                                                                    '<tr height="21"><td ><span class="letraRojaSubrayada8">Respuesta:</span></td>'+
                                                                                    '<td ><span class="letraExt">{respuestaAtencion}</span></td>'+
                                                                                    '</tr></table>'+
                                                                                    '</td></tr>'+
                                                                                    '</table></span></p>'
                                                                                    
                                                                                )
                                                    });
   
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        expander,
                                                        {
                                                            header:'Folio',
                                                            width:140,
                                                            sortable:true,
                                                            dataIndex:'idComentario'
                                                        },
                                                        {
                                                            header:'Fecha de comentario',
                                                            width:140,
                                                            sortable:true,
                                                            dataIndex:'fechaComentario',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
	                                                                    	return val.format('d/m/Y H:i:s');
                                                                    }
                                                        },
                                                        {
                                                            header:'Comentario realizado por',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'responsableComentario'
                                                        },
                                                        {
                                                            header:'E-mail',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'emailResponsable'
                                                        },
                                                        
                                                        {
                                                            header:'Situaci&oacute;n',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'situacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val=='1')
                                                                        	return 'En espera de atenci&oacute;n'
                                                                         return 'Atendido';
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de atenci&oacute;n',
                                                            width:140,
                                                            sortable:true,
                                                            dataIndex:'fechaAtencion',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
	                                                                    	return val.format('d/m/Y H:i:s');
                                                                    }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridComentarios',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:true,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            plugins:[expander],
                                                            columnLines : true,
                                                            tbar:	[
                                                            			{
                                                                        	xtype:'label',
                                                                            html:'<span class="letraRojaSubrayada8"><b>Ciclo:</b></span>&nbsp;&nbsp;'
                                                                        },
                                                                        cmbCiclo,'-',
                                                            			{
                                                                        	xtype:'label',
                                                                            html:'&nbsp;&nbsp;<span class="letraRojaSubrayada8"><b>Mostrar comentarios en situaci&oacute;n:</b></span>&nbsp;&nbsp;'
                                                                        },
                                                            			cmbSituacion,'-',
                                                                        {
                                                                        	icon:'../images/pencil.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Atender comentario',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el comentario que desea atender');
                                                                                            return;
                                                                                        }
                                                                                        mostrarVentanaRespuesta(fila);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover comentario',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el comentario que desea remover');
                                                                                            return;
                                                                                        }
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
                                                                                                     	gEx('gridComentarios').getStore().reload();   
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=81&idComentario='+fila.get('idComentario'),true);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el comentario seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/arrow_refresh.PNG',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Refrescar',
                                                                            handler:function()
                                                                            		{
                                                                                    	gEx('gridComentarios').getStore().reload();   
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/salir.gif',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Regresar',
                                                                            handler:function()
                                                                            		{
                                                                                    	location.href='../principal/inicio.php';
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        
                                                            		],
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:true,
                                                                                                enableGroupingMenu:true,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false
                                                                                            })
                                                        }
                                                    );
    return 	tblGrid;	
}

function mostrarVentanaRespuesta(fila)
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
                                                            html:'Ingrese la respuesta a asignar al comentario:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:10,
                                                            y:40,
                                                            width:550,
                                                            height:100,
                                                            id:'txtRespuesta'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:170,
                                                            html:'Comentario adicional:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:10,
                                                            y:200,
                                                            width:550,
                                                            height:100,
                                                            id:'txtAdicional'
                                                        },
                                                        {
                                                        	xtype:'checkbox',
                                                            id:'chkEnviarMail',
                                                            x:10,
                                                            y:315,
                                                            checked:true,
                                                            boxLabel  : 'Enviar respuesta por E-mail'
                                                        }


													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Respuesta a Comentario [Folio: '+fila.get('idComentario')+']',
										width: 600,
										height:430,
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
                                                                	gEx('txtRespuesta').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtRespuesta=gEx('txtRespuesta');
                                                                        if(txtRespuesta.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtRespuesta.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la respuesta a dar al comentario',resp);
                                                                        	return;
                                                                        }
                                                                        var chkEnviarMail=gEx('chkEnviarMail');
                                                                        var txtAdicional=gEx('txtAdicional');
                                                                        var enviarRespuesta=0;
                                                                        if(chkEnviarMail.getValue())
                                                                        	enviarRespuesta=1;
                                                                        var cadObj='{"enviarRespuesta":"'+enviarRespuesta+'","respuesta":"'+cv(txtRespuesta.getValue())+'","adicional":"'+cv(txtAdicional.getValue())+'","idComentario":"'+fila.get('idComentario')+'","email":"'+fila.get('emailResponsable')+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridComentarios').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=82&cadObj='+cadObj,true);
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