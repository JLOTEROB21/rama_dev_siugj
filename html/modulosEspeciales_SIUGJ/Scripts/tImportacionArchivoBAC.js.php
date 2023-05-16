<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

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
                                                items:	[
                                                            crearGridImportaciones()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridImportaciones()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'noMovimiento'},
                                                        {name: 'nombreArchivo'},
		                                                {name:'periodo'},
		                                                {name:'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'responsableImportacion'},
                                                        {name: 'totalMovimientos'},
                                                        {name: 'totalDepositos'},
                                                        {name: 'totalPagos'},
                                                        {name:'totalPrescritos'},
                                                        {name:'totalTraspasos'},
                                                        {name: 'movimientosConciliados'},
                                                        {name: 'movimientosSinConciliar'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloDepositos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'noMovimiento', direction: 'ASC'},
                                                            groupField: 'noMovimiento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='3';
                                        
                                    }
                        )   
       
      var cModelo= new Ext.grid.ColumnModel   	(
                                                      [
                                                          new  Ext.grid.RowNumberer({width:40}),
                                                          
                                                          {
                                                              header:'Nombre del archivo',
                                                              width:180,
                                                              sortable:true,
                                                              dataIndex:'nombreArchivo'
                                                          },
                                                          {
                                                              header:'Periodo',
                                                              width:180,
                                                              sortable:true,
                                                              dataIndex:'periodo',
                                                              renderer:function(val)
                                                              			{
                                                                        	return formatearValorRenderer(arrMeses,val);
                                                                        }
                                                          },
                                                          {
                                                              header:'Fecha registro',
                                                              width:180,
                                                              sortable:true,
                                                              dataIndex:'fechaRegistro',
                                                              renderer:function(val)
                                                              		{
                                                                    	return val.format('d/m/Y H:i');
                                                                    }
                                                          },
                                                          {
                                                              header:'Total movimientos',
                                                              width:180,
                                                              sortable:true,
                                                              dataIndex:'totalMovimientos'
                                                          },
                                                          {
                                                              header:'Total dep&oacute;sitos',
                                                              width:180,
                                                              sortable:true,
                                                              dataIndex:'totalDepositos'
                                                          },
                                                          {
                                                              header:'Total pagos',
                                                              width:180,
                                                              sortable:true,
                                                              dataIndex:'totalPagos'
                                                          },
                                                          {
                                                              header:'Total prescritos',
                                                              width:180,
                                                              sortable:true,
                                                              dataIndex:'totalPrescritos'
                                                          },
                                                          {
                                                              header:'Total traspasos',
                                                              width:180,
                                                              sortable:true,
                                                              dataIndex:'totalTraspasos'
                                                          },
                                                          {
                                                              header:'Movimientos conciliados',
                                                              width:210,
                                                              sortable:true,
                                                              dataIndex:'movimientosConciliados'
                                                          },
                                                          {
                                                              header:'Movimientos sin conciliar',
                                                              width:210,
                                                              sortable:true,
                                                              dataIndex:'movimientosSinConciliar'
                                                          }
                                                      ]
                                                  );
                                                  
      var tblGrid=	new Ext.grid.GridPanel	(
                                                          {
                                                              id:'gridImportaciones',
                                                              store:alDatos,
                                                              region:'center',
                                                              border:false,
                                                              frame:false,
                                                              cm: cModelo,
                                                              stripeRows :true,
                                                              loadMask:true,
                                                              tbar:	[
                                                              			{
                                                                        	icon:'../images/script_go.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Importar Archivo',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaImportacion();
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	xtype:'tbspacer',
                                                                            width:10
                                                                        },
                                                                        {
                                                                        	icon:'../images/magnifier.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Ver resultado de conciliaci&oacute;n',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gridImportaciones').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el registro cuya conciliaci&oacute;n desea observar');
                                                                                        	return;
                                                                                        }
                                                                                        abrirVentanaConciliacion(bE(fila.data.idRegistro));
                                                                                    }
                                                                            
                                                                        }
                                                              		],
                                                              cls:'gridSiugjPrincipal',
                                                              columnLines : false,                                                              
                                                              view:new Ext.grid.GroupingView({
                                                                                                  forceFit:false,
                                                                                                  showGroupName: false,
                                                                                                  enableGrouping :false,
                                                                                                  enableNoGroups:false,
                                                                                                  enableGroupingMenu:false,
                                                                                                  hideGroupedColumn: true,
                                                                                                  startCollapsed:false
                                                                                              })
                                                          }
                                                      );
      return 	tblGrid;	
}

function mostrarVentanaImportacion()
{
	
	var cmbPerfilImportacion;
	var cObj={

                    upload_url: "../modulosEspeciales_SIUGJ/paginasFunciones/procesarArchivoBAC.php", //lquevedor
                    file_post_name: "archivoEnvio",
     
                    // Flash file settings
                    file_size_limit:'20480 MB',
                    file_types :"*.xlsx; *.xls",
                    file_types_description : "Todos los archivos",
                    file_upload_limit : 0,
                    file_queue_limit : 1,  
                    upload_success_handler : subidaCorrecta,
                    
                    
                }
                
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
                                                              cls:'SIUGJ_Etiqueta',
                                                              html:'Ingrese el documento a importar:'
                                                          },
                                                          {
                                                            x:300,
                                                            y:5,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:	'<table width="310"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right"><span class="SIUGJ_Etiqueta" style="font-size:12px !important">Porcentaje de avance:</span> <span class="SIUGJ_Etiqueta" id="porcentajeAvance" style="font-size:12px !important"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:630,
                                                            y:6,
                                                            id:'btnUploadFile',
                                                            width:140,
                                                            icon:'../images/add.png',
                                                            cls:'btnSIUGJCancel',
                                                            xtype:'button',
                                                            text:'Seleccionar',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
                                                        {
                                                            x:185,
                                                            y:10,
                                                            hidden:false,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        
                                                        {
                                                            x:190,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo'

                                                        },
                                                        {
                                                            x:190,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        }
                                                       
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Importar Expedientes',
										width: 800,
										height:190,
										layout: 'fit',
										plain:true,
                                        id:'vImportar',
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	 crearControlUploadHTML5(cObj);
																}
															}
												},
										buttons:	[
                                        				
														
														{
															text: 'Cancelar',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
                                                            id:'btnClose',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140, 
                                                            id:'btnStart',                                                           
															handler: function()
																	{
																		
                                                                        
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                            msgBox('Debe ingresar el archivo que desea importar');
                                                                            return;
                                                                        }
                                                                        uploadControl.start();
                                                                        
                                                                        
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
    	function resp()
        {
	        abrirVentanaConciliacion(bE(arrDatos[1]));
        }
    	msgBox('El archivo ha sido procesado exitosamente',resp);
		gEx('vImportar').close();       
        gEx('gridImportaciones').getStore().reload();
        
        
        
        
    }
		
	
}


function abrirVentanaConciliacion(iR)
{
	var obj={};
    
    obj.url='../modulosEspeciales_SIUGJ/tblAdmonConciliacionBAC.php';
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=[['idImportacion',bD(iR)]]; 
    abrirVentanaFancySuperior(obj);
    
       
}