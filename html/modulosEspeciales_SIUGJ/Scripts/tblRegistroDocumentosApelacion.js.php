<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos order by nombreCategoria";
	$arrTiposDocumentos=$con->obtenerFilasArreglo($consulta);
	
	
	$iF=$_GET["iF"];
	$iR=$_GET["iR"];
	$sL=$_GET["sL"];
	
	$permiteEdicionPresentaDocumento="true";
	$arrDocumentosIniciales=obtenerDocumentacionRequeridaClaseProceso($iF,$iR,$sL==1);
	$ventanaAdjuntaDocumento=$habilitarLatisScan?"110":"0";
	
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos order by nombreCategoria";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	

 	$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($iF,$iR);

	
?>
var arrEtapasProcesales=[];
var idCarpeta=-1;
var carpetaAdministrativa='<?php echo $carpetaAdministrativa?>';

var arrCategorias=<?php echo $arrCategorias?>;
var sL='<?php echo $sL?>';
var obligarAdjustarDocumentoPresenta=false;
var filaRegistro=null;
var tamanoMaxArchivo='50 MB';
var extensionesPermitidas='*.jpg;*.jpeg;*.pdf;*.mp3;*.mp4';
var ventanaAdjuntaDocumento=<?php echo $ventanaAdjuntaDocumento?>;
var permiteEdicionPresentaDocumento=<?php echo $permiteEdicionPresentaDocumento?>;
var arrDocumentosIniciales=<?php echo $arrDocumentosIniciales?>;
var arrTiposDocumentos=<?php echo $arrTiposDocumentos?>;
var arrTiposDocumentosPermtidos=<?php echo $arrTiposDocumentos?>;
var arrSiNo=<?php echo $arrSiNo?>;

Ext.onReady(inicializar);

function inicializar()
{
	idActividad=gE('idActividad').value;
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            crearGridDocumentosAsociados()
                                         ]
                            }
                        )   
}


function crearGridDocumentosAsociados()
{
	
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:false,width:40});//checkOnly:true,
	var dsDatos=arrDocumentosIniciales;


    
    
    
    var alDatos=new Ext.data.GroupingStore({
                                                            reader: new Ext.data.ArrayReader({
                                                                                             	   fields:	[
                                                                                                                {name: 'idRegistro'},
                                                                                                                {name:'idDocumento'},
                                                                                                                {name:'presentaDocumento'},
                                                                                                                {name:'documentoDigital'},
                                                                                                                {name:'obligatorio'},
                                                                                                                {name:'tamano'}
                                                                                                            ]
                                                                                            }),
                                                            sortInfo: {field: 'idDocumento', direction: 'ASC'},
                                                            groupField: 'idDocumento'
                                            }
                                          )
                                                            
    
    alDatos.loadData(dsDatos);
    var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                        	chkRow,
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                        	{
                                                            	header:'Tipo de Documento',
																menuDisabled :true,
																width:400,
																sortable:true,
																dataIndex:'idDocumento',
																hidden:false,
																renderer:function (val,meta,registro,fila,columna)
                                                                        {
                                                                            return formatearValorRenderer(arrTiposDocumentosPermtidos,val);
                                                                        }
                                                        	},
                                                            {
                                                                header:'Nombre del Documento',
                                                                menuDisabled :true,
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'documentoDigital',
                                                                hidden:false,
                                                                renderer:textoBotonRendererDocumento
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
                                                    
	
    var objConf= {
                    id:'gDocumentos',
                    store:alDatos,
                    region:'center',
                    frame:false,
                    border:false,
                    clicksToEdit:1,
                    cm: cModelo,
                    stripeRows :true,
                    sm:chkRow,
                    cls:'gridSiugjPrincipal',
                    view:new Ext.grid.GroupingView({
                                                        forceFit:false,
                                                        showGroupName: false,
                                                        enableGrouping :false,
                                                        enableNoGroups:false,
                                                        enableGroupingMenu:false,
                                                        hideGroupedColumn: false,
                                                        startCollapsed:false
                                                    }),
                    loadMask:true,
                    columnLines : true
                }
    
    
    if(gE('sL').value=='0')
    {
    	objConf.tbar=	[
                  			{
                                  icon:'../images/add.png',
                                  cls:'x-btn-text-icon',
                                  text:'Agregar Documento',
                                  handler:function()
                                          {
                                              mostrarVentanaDocumentos();
                                          
                                          }
                              
                              },
                              {
                              		xtype:'tbspacer',
                                    width:10
                              },
                              
                              {
                                  icon:'../images/delete.png',
                                  cls:'x-btn-text-icon',
                                  disabled:true,
                                  id:'btnRemoveDocumento',
                                  text:'Remover Documento',
                                  handler:function()
                                          {
                                              var filas=gEx('gDocumentos').getSelectionModel().getSelections()
                                              if(filas.length==0)
                                              {
                                                  msgBox('Debe seleccionar almenos un documento a remover');
                                                  return;
                                              }
                                              
                                              
                                              
                                              var f;
                                              var x;
                                              var o='';
                                              var arrDocumentos='';
                                              for(x=0;x<filas.length;x++)
                                              {
                                                  f=filas[x];
                                                  if(arrDocumentos=='')
                                                      arrDocumentos=f.data.idRegistro;
                                                  else
                                                      arrDocumentos+=','+f.data.idRegistro;
                                              }
                                                  
                                              
                                              function respAux(btn)
                                              {
                                                  if(btn=='yes')
                                                  {
                                                      function funcAjax()
                                                      {
                                                          var resp=peticion_http.responseText;
                                                          arrResp=resp.split('|');
                                                          if(arrResp[0]=='1')
                                                          {
                                                              gEx('gDocumentos').getStore().remove(filas);
                                                              gEx('gDocumentos').getStore().loadData(arrDatos);
                                                             
                                                          }
                                                          else
                                                          {
                                                              msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                          }
                                                      }
                                                      obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRegistroDocumentos.php',funcAjax, 'POST','funcion=3&listaDocumentos='+arrDocumentos,true);
                                                  }
                                              }
                                              msgConfirm('Est&aacute; seguro de querer remover los documentos seleccionados?',respAux);
                                              
                                          }
                              
                              }
                          ];
    }
    
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                           objConf 
                                                        );

	tblGrid.on('beforeedit',function(e)
    						{
                            	e.cancel=gE('sL').value=='1';
                            }
                            
    		)
        
	tblGrid.getSelectionModel().on('rowselect',function(sm,numFila,registro)
    											{
                                                	gEx('btnRemoveDocumento').disable();
                                                	if(registro.data.obligatorio=='0')
                                                    {
                                                    	gEx('btnRemoveDocumento').enable()
                                                    }
                                                }
    							)        

	tblGrid.getSelectionModel().on('rowdeselect',function(sm,numFila,registro)
    											{
                                                	gEx('btnRemoveDocumento').disable();
                                                	
                                                }
    							)     

        return 	tblGrid;
   
   
   
}


function textoBotonRendererDocumento(val,meta,registro,numFila)
{

    	var url='';
    	var arrDatos=val.split('|');
       	var nombreArchivo=arrDatos[0];
        var aArchivo=nombreArchivo.split('.');
       	var idDocumento=arrDatos[1];
        var extension=aArchivo[aArchivo.length-1];
        var comp='';
        if(gE('sL').value=='0')
        {
            if(val!='')
            {    
                comp='<a href="javascript:window.parent.visualizarDocumentoAdjuntoB64(\''+bE(idDocumento)+'\',\''+bE(extension)+'\')">'+arrDatos[0]+'</a>';
            }
            return comp;
		}
        else
        {
        	return '<a href="javascript:window.parent.visualizarDocumentoAdjuntoB64(\''+bE(idDocumento)+'\',\''+bE(extension)+'\')">'+arrDatos[0]+'</a>';
        }    
    
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
                                                                    	var f;
                                                                    	var listaDocumentos='';
																		var filas=gEx('gridDocumentos').getSelectionModel().getSelections();
                                                                        var x;
                                                                        var f;
                                                                        var pos;
                                                                        var reg=crearRegistro	(
                                                                        							[
                                                                                                    	{name: 'idRegistro'},
                                                                                                        {name: 'idReferencia'},
                                                                                                        {name:'idDocumento'},
                                                                                                        {name:'nombreDocumento'},
                                                                                                        {name:'tamanoDoc'},
                                                                                                        {name:'categoriaDocumento'}
                                                                                                    ]
                                                                        						);
                                                                        
                                                                        
                                                                        var arrDocumentos='';
                                                                        var f;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                        	oDocumento='{"idDocumento":"'+f.data.idDocumento+'"}';
                                                                            if(arrDocumentos=='')
                                                                            	arrDocumentos=oDocumento;
                                                                            else
                                                                            	arrDocumentos+=','+oDocumento;
                                                                        }
                                                                        var cadObj='{"idFormulario":"<?php echo $iF?>","idReferencia":"<?php echo $iR?>","arrDocumentos":['+arrDocumentos+']}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var arrDatos=eval(bD(arrResp[1]));
                                                                                gEx('gDocumentos').getStore().removeAll();
                                                                                gEx('gDocumentos').getStore().loadData(arrDatos);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRegistroDocumentos.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
                                                                        
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
	var cmbOridenDocumentos=crearComboExt('cmbOridenDocumentos',[['1','Carpeta Judicial']],0,0,250);
    cmbOridenDocumentos.setValue('1');
    cmbOridenDocumentos.on('select',function(cmb,registro)
    								{
                                    	switch(parseInt(registro.data.id))
                                        {
                                        	case 1:
                                            	gEx('gridDocumentos').getStore().load	(
                                                                                            {
                                                                                                url:'funcionesModulosEspeciales_SGP',
                                                                                                parms:	{
                                                                                                            funcion:19,
                                                                                                            cA:bE(carpetaAdministrativa),
                                                                                                            idCarpetaAdministrativa:idCarpeta
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
                                    	proxy.baseParams.funcion='19';
                                        proxy.baseParams.cA=bE(carpetaAdministrativa);
                                        proxy.baseParams.idCarpetaAdministrativa=idCarpeta;
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
                                                            dataIndex:'fechaRegistro',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y');
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
                                  	window.parent.mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  )                                                    
                                                    
    return 	tblGrid;	
}

function mostrarDocumentoAdjunto(rowIndex)
{
	var registro=gEx('grid_10680').getStore().getAt(bD(rowIndex));
   	var arrNombre=registro.data.nombreDocumento.split('.');
   	window.parent.mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
}

function mostrarVentanaAdjuntarDocumento()
{

	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrCategorias,185,5,350);

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
                                                            x:185,
                                                            y:35,
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:480,
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
                                                                             
                                                                                            
                                                                                            upload_success_handler : subidaCorrecta,
                                                                                            
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
        
        
        
        var cadObj='{"carpetaAdministrativa":"'+carpetaAdministrativa+'","idFormulario":"<?php echo $iF?>","idRegistro":"<?php echo $iR
					?>","idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+'","tipoDocumento":"'+gEx('cmbTipoDocumento').getValue()+
                    '","descripcion":"'+cv(gEx('txtDescripcion').getValue())+'"}';
    
        function funcAjax2(peticion_http)
        {
            var resp=peticion_http.responseText;
            
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
               	gEx('gridDocumentos').getStore().reload();
                gEx('vDocumento').close();                
            }
            else
            {
                
                msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
            }
        }
        obtenerDatosWebV2('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax2, 'POST','funcion=13&cadObj='+cadObj,false);
        
        
        
    }
		
	
}





