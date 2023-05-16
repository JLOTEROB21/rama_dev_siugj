<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=$_GET["iF"];
	$idRegistro=$_GET["iR"];
	
	$consulta="SELECT * FROM 3300_respuestasSolicitudPromocion WHERE idFormulario=".$idFormulario." AND idReferencia=".
			$idRegistro." and notificadoPGJ<>3";
	$fDatosRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos order by nombreCategoria";
	$arrTipoDocumento=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$arrEtapasProcesales=$con->obtenerFilasArreglo($consulta);
	
	$fechaNotificacion="--/--/----";
	if($fDatosRegistro &&($fDatosRegistro["fechaNotificacion"]))
		$fechaNotificacion=date("d/m/Y H:i:s",strtotime($fDatosRegistro["fechaNotificacion"]));
	$mensajeNotificacion="(Sin mensaje)";	
	$consulta	="SELECT mensaje FROM 3010_bitacoraNotificacionPGJ WHERE iFormulario=".$idFormulario." AND iRegistro=".$idRegistro.
			" ORDER BY fechaNotificacion DESC";
	$mensajeNotificacion=$con->obtenerValor($consulta);	
	if($mensajeNotificacion=="")
		$mensajeNotificacion="(Sin mensaje)";	
				
?>
var uploadControl;
var mensajeNotificacion='<?php echo $mensajeNotificacion?>';
var fechaNotificacion='<?php echo $fechaNotificacion?>';
var situacionActual='<?php echo $fDatosRegistro?$fDatosRegistro["notificadoPGJ"]:0?>';
var resultadoNotificacion=[['0','En espera de env\xEDo'],['2','Con errores NO notificado'],['1','Notificado']];
var arrEtapasProcesales=<?php echo $arrEtapasProcesales?>;
var arrTipoDocumento=<?php echo $arrTipoDocumento?>;
var registroDocumentoSel=null;
var arrCategorias=<?php echo $arrCategorias?>;

Ext.onReady(inicializar);

function inicializar()
{
	if(gE('sL').value=='0')
    {
        new Ext.Button (
                                {
                                    icon:'../images/icon_big_tick.gif',
                                    cls:'x-btn-text-icon',
                                    text:'Guardar',
                                    width:110,
                                    height:30,
                                    renderTo:'contenedor1',
                                    handler:function()
                                            {
                                                guardarNotificacion();
                                            }
                                    
                                }
                            )
         new Ext.Button (
                                {
                                    icon:'../images/email_go.png',
                                    cls:'x-btn-text-icon',
                                    text:'Enviar respuesta',
                                    width:110,
                                    height:30,
                                    renderTo:'contenedor2',
                                    handler:function()
                                            {
                                            	if(gEx('vistaDocuentosAdjuntos').getStore().getCount()==0)
                                                {
                                                	msgBox('Debe ingresar almenos un documento que respalde la respuesta');
                                                    return;
                                                }
                                            	function resp(btn)
                                                {
                                                	if(btn=='yes')
                                                    {
														guardarNotificacion(enviarRespuesta);
                                                    }
                                                }
                                                msgConfirm('Est&aacute; seguro de querer enviar la respuesta?',resp);
                                            }
                                    
                                }
                            )
	}
	var arrSiNo=[['1','Se concede solicitud'],['2','Se niega solicitud']];
	var cmbRespuestaSolicitud=crearComboExt('cmbRespuestaSolicitud',arrSiNo,185,35,200);
    <?php
		if($fDatosRegistro)
		{
			echo "cmbRespuestaSolicitud.setValue('".$fDatosRegistro["procede"]."');";
		}
	?>
    
    if(gE('sL').value=='1')
    {
    	cmbRespuestaSolicitud.disable();
    }
    new Ext.Panel	(
                        {
          					height:600,
                            width:900,
                            renderTo:'divFrm',
                            border:false,
                            frame:false,
                            renderTo:'divFrm',
                            layout:'absolute',
                            items:	[
                                        {
                                            x:20,
                                            y:40,
                                            xtype:'label',
                                            html:'<span class="TSJDF_Etiqueta">Respuesta a la solicitud:</span>'
                                        },
                                        cmbRespuestaSolicitud,
                                        {
                                            xtype:'fieldset',
                                            id:'fArchivos',
                                            x:20,
                                            y:70,
                                            width:820,
                                            height:200,
                                            layout:'border',
                                            title:'Ingrese los documentos que respaldan la respuesta',
                                            items:	[
                                                        {
                                                            xtype:'panel',
                                                            layout:'border',
                                                            
                                                            region:'center',
                                                            tbar:	[
                                                                        {
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Agregar documento',
                                                                            handler:function()
                                                                                    {
                                                                                        mostrarVentanaDocumentos();   
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Remover documento',
                                                                            handler:function()
                                                                                    {
                                                                                        if(!registroDocumentoSel)
                                                                                        {
                                                                                            msgBox('Debe seleccionar el documento que desea remover');
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
                                                                                                        gEx('vistaDocuentosAdjuntos').getStore().reload();
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',funcAjax, 'POST','funcion=3&iF='+gE('idFormulario').value+
                                                                                                			'&iR='+gE('idRegistro').value+'&iD='+registroDocumentoSel.data.idDocumento,true);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el documento seleccionado?',resp);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                                    ],
                                                            items:	[
                                                            
                                                                        crearVistaDocumentosAdjuntos()
                                                                    ]
                                                        }
                                                        
                                                        
                                                    ]
                                        },
                                         {
                                            x:20,
                                            y:290,
                                            xtype:'label',
                                            html:'<span class="TSJDF_Etiqueta">Comentarios adicionales:</span>'
                                        },
                                        
                                        {
	                                        
                                        	x:20,
                                            y:320,
                                            xtype:'textarea',
                                            width:820,
                                            height:80,
                                            readOnly:gE('sL').value=='1',
                                            value:escaparBR('<?php echo $fDatosRegistro["comentariosAdicionales"]?>',true),
                                            id:'txtComentariosAdicionales'
                                        },
                                        {
                                        	x:20,
                                            y:420,
                                            xtype:'label',
                                            html:'<div class="SeparadorSeccion" id="" style="width: 850px;"><span id="">Resultado de Notificaci&oacute;n</span></div>'
                                        },
                                        {
                                            x:20,
                                            y:470,
                                            xtype:'label',
                                            html:'<span class="TSJDF_Etiqueta">Situaci&oacute;n actual:</span>'
                                        },
                                        {
                                            x:190,
                                            y:465,
                                            xtype:'label',
                                            html:'<span class="TSJDF_Control">'+formatearValorRenderer(resultadoNotificacion,situacionActual)+'</span>'
                                        },
                                        {
                                            x:20,
                                            y:500,
                                            xtype:'label',
                                            html:'<span class="TSJDF_Etiqueta">Fecha de notificaci&oacute;n:</span>'
                                        },
                                        {
                                            x:190,
                                            y:495,
                                            xtype:'label',
                                            html:'<span class="TSJDF_Control">'+fechaNotificacion+'</span>'
                                        },
                                        {
                                            x:20,
                                            y:530,
                                            xtype:'label',
                                            html:'<span class="TSJDF_Etiqueta">Mensaje notificaci&oacuten:</span>'
                                        },
                                        {
                                            x:190,
                                            y:525,
                                            xtype:'label',
                                            html:'<span class="TSJDF_Control">'+mensajeNotificacion+'</span>'
                                        }
                                    ]
                        } 
                    ) 
}


function crearVistaDocumentosAdjuntos()
{

   	var plantilla=new Ext.XTemplate(
                                        '<ul>',
                                            '<tpl for=".">',
                                                '<li class="elemento" title="{nombreDocumento}" alt="{nombreDocumento}">',
                                                    '<img src="../imagenesDocumentos/32/file_extension_{extension}.png"><br>',
                                                    '<span>{nombreDocumentoCorto}</span><br>',
                                                    '<span>{tamanoDocumento}</span>',
                                                '</li>',
                                            '</tpl>',
                                        '</ul>'
                                    );    
   
                                                                                      
	var alDatos=new Ext.data.JsonStore({
                                            root:'registros',
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idDocumento'},
		                                                {name: 'nombreDocumento'},
                                                        {name: 'nombreDocumentoCorto'},
		                                                {name: 'tamanoDocumento'},
		                                                {name: 'fechaDocumento'},
                                                        {name: 'extension'}
                                                        
                                            		],
                                            proxy : new Ext.data.HttpProxy	(
                                                                                  {
                                                                                      url: '../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php'
                                                                                  }

                                                                              ),
                                            autoLoad:true
                                        })   
       
     
	    
     
    alDatos.on('beforeload',function(proxy)
    								{
                                    	registroDocumentoSel=null;
                                    	proxy.baseParams.funcion='1';
                                        proxy.baseParams.idFormulario=gE('idFormulario').value;
                                        proxy.baseParams.idRegistro=gE('idRegistro').value;
                                        
                                    }
                        )   
       
    var vista=new Ext.DataView(
                                    {
                                        tpl: plantilla,                                        
                                        id:'vistaDocuentosAdjuntos',
                                       	width:800,
                                        height:190,
                                        autoScroll  : true,
                                        singleSelect: true,
                                        region:'center',
                                        border:true,
                                        overClass:'x-view-over',
                                        itemSelector: 'li.elemento',
                                        emptyText : '<div style="padding:10px;">No existen documentos registrados</div>',
                                        store:alDatos
                                    }
                                 )    
                                 
	vista.on('dblclick',function(dv,idx,nodo,e)
                      {
                          registroDocumentoSel=gEx('vistaDocuentosAdjuntos').getRecord(nodo);
                          mostrarVisorDocumentoProceso(registroDocumentoSel.data.extension,registroDocumentoSel.data.idDocumento,registroDocumentoSel);
                      }
              )                                  
                                                                        
     vista.on('click',function(dv,idx,nodo,e)
                      {
                          registroDocumentoSel=gEx('vistaDocuentosAdjuntos').getRecord(nodo);
                          
                      }
              )
                                             
	return   vista;                                 
                                    
}

function mostrarVentanaDocumentos()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridDocumentos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar documentos',
										width: 950,
										height:450,
                                        id:'vDocumentoVentana',
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
                                                            
															handler: function()
																	{
                                                                    	var listaDocumentos='';
																		var filas=gEx('gridDocumentos').getSelectionModel().getSelections();
                                                                        var x;
                                                                        var f;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                            if(listaDocumentos=='')
                                                                            	listaDocumentos=f.data.idDocumento;
                                                                            else
                                                                            	listaDocumentos+=','+f.data.idDocumento;
                                                                        }
                                                                        
                                                                        if(listaDocumentos=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos un documento a adjuntar a la orden de notificaci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistro').value+'","listaDocumentos":"'+listaDocumentos+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('vistaDocuentosAdjuntos').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
                                                                        
                                                                        
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
    dispararEventoSelectCombo('cmbOridenDocumentos');
}

function crearGridDocumentos()
{
	var cmbOridenDocumentos=crearComboExt('cmbOridenDocumentos',[['1','Carpeta Judicial'],['2','Documentos del proceso']],0,0,250);
    cmbOridenDocumentos.setValue('2');
    cmbOridenDocumentos.on('select',function(cmb,registro)
    								{
                                    	switch(parseInt(registro.data.id))
                                        {
                                        	case 1:
                                            	gEx('btnAddDocumento').show();
                                            	urlConsultaDocumentos='../paginasFunciones/funcionesModulosEspeciales_SGP.php';                                            	
                                            	gEx('gridDocumentos').getStore().load	(
                                                                                            {
                                                                                                params:	{
                                                                                                            funcion:19,
                                                                                                            cA:bE(gE('carpetaAdministrativa').value),
                                                                                                            idCarpetaAdministrativa:gE('idCarpeta').value
                                                                                                        }
                                                                                            }
                                                                                        )
                                            	
                                            break;
                                            case 2:	
                                            	gEx('btnAddDocumento').hide();
												urlConsultaDocumentos='../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php';
                                                gEx('gridDocumentos').getStore().load	(
                                                                                            {
                                                                                                
                                                                                                params:	{
                                                                                                            funcion:11,
                                                                                                            idFormulario:gE('idFormulario').value,
                                                                                                            idRegistro:gE('idRegistro').value
                                                                                                        }
                                                                                            }
                                                                                        )
                                            	
                                            break;
                                        }
                                    }
    					)
    
    
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrCategorias);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
                                                        {name:'idFormulario'},
                                                        {name:'idRegistro'},
                                                        {name:'idDocumento'},
                                                        {name: 'categoriaDocumentos'}
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
                                                sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                groupField: 'fechaRegistro',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:false
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{

                                    	proxy.proxy.conn.url=urlConsultaDocumentos;
                                    }
                        )   
       
    
    
    var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'date', dataIndex: 'fechaCreacion'},
                                                                        {type: 'string', dataIndex: 'nomArchivoOriginal'},
                                                                        {type: 'list', dataIndex: 'categoriaDocumentos', phpMode:true, options:arrCategorias}
                                                                    ]
                                                    }
                                                );    
       
	/*var expander = new Ext.ux.grid.RowExpander({
                                                column:1,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
                                                    '<tr><td ><span class="TSJDF_Control">{descripcion}</span><br /><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            });    */    

	var chkRow=new Ext.grid.CheckboxSelectionModel();
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	new  Ext.grid.RowNumberer({width:30}),
                                                        chkRow,
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" />'
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:120,
                                                            sortable:true,
                                                            dataIndex:'fechaCreacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y H:i');
                                                                    }
                                                        },
                                                        {
                                                            header:'Tipo documento',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'categoriaDocumentos',
                                                            editor:cmbTipoDocumento,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCategorias,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Etapa procesal',
                                                            width:250,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'etapaProcesal',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasProcesales,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Documento',
                                                            width:420,
                                                            sortable:true,
                                                            dataIndex:'nomArchivoOriginal',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        
                                                        {
                                                            header:'Tama&ntilde;o',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'tamano',
                                                            renderer:function(val)
                                                            		{
                                                                    	return bytesToSize(parseInt(val),0);
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridDocumentos',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            sm:chkRow,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            tbar:	[
                                                            			{
                                                                        	xtype:'label',
                                                                            html:'<b>Origen de los documentos:&nbsp;&nbsp;</b>'
                                                                        },
                                                                        cmbOridenDocumentos,'-',
                                                                        {
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            id:'btnAddDocumento',
                                                                            hidden:true,
                                                                            text:'Adjuntar documento',
                                                                            handler:function()
                                                                                    {
                                                                                        mostrarVentanaAdjuntarDocumento()
                                                                                    }
                                                                            
                                                                        }
                                                            		],
                                                            columnLines : true,  
                                                            plugins:[filters],   
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'<span style="color:#900"><b>{text}</b> ({[values.rs.length]} {[values.rs.length > 1 ? "Documentos" : "Documento"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    
	
    
    
    tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                  	mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  )                                                    
                                                    
    return 	tblGrid;	
}

function mostrarVentanaAdjuntarDocumento()
{

	

					
					
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrTipoDocumento,190,5,350);

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
                                                            html:'Tipo de documento a adjuntar:'
                                                        },
                                                        cmbTipoDocumento,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:40,
                                                            html:'Ingrese el documento a adjuntar:'
                                                        },
                                                        {
                                                            x:190,
                                                            y:35,
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:485,
                                                            y:36,
                                                            id:'btnUploadFile',
                                                            xtype:'button',
                                                            text:'Seleccionar...',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
							 {
                                                            x:185,
                                                            y:10,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo'

                                                        },
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        } ,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:70,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:10,
                                                            y:100,
                                                            width:600,
                                                            height:60,
                                                            id:'txtDescripcion'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Adjuntar documento',
										width: 650,
                                        id:'vDocumento',
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
                                                                
                                                                	var cObj={
                                                                    // Backend settings
                                                                                    upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                    file_post_name: "archivoEnvio",
                                                                     
                                                                                    // Flash file settings
                                                                                    file_size_limit : "1000 MB",
                                                                                    file_types : "*.pdf;*.jpg;*.jpeg;*.gif;*.png",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                    file_types_description : "Todos los archivos",
                                                                                    file_upload_limit : 0,
                                                                                    file_queue_limit : 1,
                                                                     
                                                                                    
                                                                                    upload_success_handler : subidaCorrecta
                                                                                };
                                                                
																	crearControlUploadHTML5(cObj);
                                                                }
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	if(cmbTipoDocumento.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbTipoDocumento.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de documento adjuntar');
                                                                            return;
                                                                        }
                                                                    	
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                            msgBox('Debe ingresar el documento que desea adjuntar');
                                                                            return;
                                                                        }
                                                                        uploadControl.start();
                                                                                
																		
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

function subidaCorrecta(file, serverData) 
{


    file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
    var arrDatos=serverData.split('|');

    if ( arrDatos[0]!='1') 
    {
    	
       
    } 
    else 
    {
        
        gEx("idArchivo").setValue(arrDatos[1]);
        gEx("nombreArchivo").setValue(arrDatos[2]);
        if(gE('txtFileName'))
	        gE('txtFileName').value=arrDatos[2];
        
        
        if(gEx('cmbOridenDocumentos').getValue()=='1')
        {
            var cadObj='{"carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'","idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+
            '","tipoDocumento":"'+gEx('cmbTipoDocumento').getValue()+'","descripcion":"'+cv(gEx('txtDescripcion').getValue())+
            '","idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistro').value+'"}';
        
            function funcAjax2(peticion_http)
            {
                var resp=peticion_http.responseText;
                
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    gEx('vistaDocuentosAdjuntos').getStore().reload();
                    gEx('gridDocumentos').getStore().reload();
                    
                    gEx('vDocumento').close();  
                    gEx('vDocumentoVentana').close();              
                }
                else
                {
                    
                    msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
                }
            }
            obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',funcAjax2, 'POST','funcion=4&cadObj='+cadObj,false);
        }
        
        
        
    }
		
	
}

function guardarNotificacion(funcGuardado)
{
	var cmbRespuestaSolicitud=gEx('cmbRespuestaSolicitud')	;
    
    if(cmbRespuestaSolicitud.getValue()=='')
    {
        function resp()
        {
        	cmbRespuestaSolicitud.focus();
        }
        msgBox('Debe indicar la respuesta a la solicitud',resp);
        return;
    }
    
    
    
    var cadObj='{"idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistro').value+'","respuestaSolicitud":"'+
    			cmbRespuestaSolicitud.getValue()+'","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                
                
    function funcAjax2(peticion_http)
    {
        var resp=peticion_http.responseText;
        
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(!funcGuardado)
	            msgBox('Los datos han sido guardados satisfactoriamente');            
            else
            	funcGuardado();
        }
        else
        {
            
            msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',funcAjax2, 'POST','funcion=5&cadObj='+cadObj,false);           
	                
}

function enviarRespuesta()
{
	function funcAjax2(peticion_http)
    {
        var resp=peticion_http.responseText;
        
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(arrResp[1]=='1')
            {
            	function respAux()
                {
                	recargarPagina();
                }
                msgBox('Se ha enviado la respuesta satisfactoriamente',respAux);
                return;
            }
            else
            {
            	function respAux2()
                {
                	recargarPagina();
                }
                msgBox('NO se ha podido enviar la respuesta',respAux2);
                return;
            }
            
        }
        else
        {
            
            msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',funcAjax2, 'POST','funcion=6&idFormulario='+gE('idFormulario').value+'&idRegistro='+gE('idRegistro').value,true);
}