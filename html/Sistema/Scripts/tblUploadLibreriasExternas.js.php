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
                                                cls:'panelSiugj',
                                                
                                                title: '<span class="tituloGrid">Librerias Externas</span>',
                                                items:	[
                                                            crearGridUpload()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridUpload()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'nombreArchivo'},
		                                                {name: 'fechaSubida', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name: 'tamano'}
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
                                                            sortInfo: {field: 'nombreArchivo', direction: 'ASC'},
                                                            groupField: 'nombreArchivo',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='89';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:45}),
                                                            
                                                            {
                                                                header:'Nombre del Archivo',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'nombreArchivo'
                                                            },
                                                            {
                                                                header:'Fecha de Carga',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaSubida',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:s');
                                                                        }
                                                            },
                                                            {
                                                                header:'Tama&ntilde;o',
                                                                width:180,
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
                                                                id:'gLiberiasExternas',
                                                                store:alDatos,
                                                                region:'center',
                                                                border:false,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                cls:'gridSiugj',
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/SignUp.gif',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Subir Archivo',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaSubirArchivo();
                                                                                        }
                                                                                
                                                                            }
                                                                		],

                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}

function mostrarVentanaSubirArchivo()
{	
	var uploader;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'panel',
                                                            
		                                           			width:800,
                                                            height:450,
                                                            layout:'absolute',
                                                            xtype:'panel',
                                                            cls:'panelSiugjStandar',
                                                            tbar:	[
                                                                        {
                                                                            id:'btnSelect',	
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            height:30,
                                                                            text: 'Agregar Documentos',                                                            
                                                                            handler: function()
                                                                                    {
                                                                                        $('#uploader_container').click()
                                                                                       // $('#linkTest')[0].click();
                    
                                                                                        
                                                                                    }
                                                                        },
                                                                        {
                                                                            id:'btnStart',	
                                                                            disabled:true,
                                                                            height:30,
                                                                            icon:'../images/SignUp.gif',
                                                                            cls:'x-btn-text-icon',
                                                                            text: 'Comenzar',                                                            
                                                                            handler: function()
                                                                                    {
                                                                                        arrResultados=[];
                                                                                        uploader.start();
                                                                                    }
                                                                        },
                                                                        {
                                                                            id:'btnPause',	
                                                                            icon:'../images/control_pause.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text: 'Pausar',
                                                                            height:30,
                                                                            disabled:true,                                                           
                                                                            handler: function()
                                                                                    {
                                                                                        
                                                                                       
                                                                                        gEx('btnStart').enable();
                                                                                        gEx('btnSelect').enable();
                                                                                        gEx('btnPause').disable();
                                                                                        uploader.stop();
                                                                                        
                                                                                    }
                                                                        },
                                                                        {
                                                                            xtype:'label',
                                                                            hidden:true,
                                                                            html:'<a id="linkTest">Open File</a>'
                                                                        }
                                                                    ],
                                                            items:	
                                                                    [
                                                                        {
                                                                           y:0,
                                                                           x:0,
                                                                           
                                                                            xtype:'label',
                                                                            html:	'<span id="tblUpload">'+
                                                                                    '<table width="800"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr></table>'+
                                                                                    '</span>'
                                                                        }
                                                                    ]
														}
                                                    ]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Subir Archivo',
										width: 825,
										height:540,
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
                                                                	  uploader=$("#uploader").pluploadQueue({
                                    
                                                                      runtimes : 'html5,flash,silverlight,html4',
                                                                      browse_button:'linkTest',
                                                                      url : "../paginasFunciones/procesarDocumentoUploadLibrerias.php",
                                                                      prevent_duplicates:true,
                                                                      file_data_name:'archivoEnvio',
                                                                      multiple_queues:true,
                                                                      max_retries:10,
                                                                      
                                                                      
                                                                      multipart_params:	{
                                                                                             
                                                                                          },
                                                                      
                                                                      rename : true,
                                                                      dragdrop: true,
                                                                      init:	{	
                                                                                  Init:function(up) 
                                                                                    {
                                                                                          uploader=up;
                                                                                      
                                                                                    },
                                                                                  UploadFile:function(up,archivos)
                                                                                                  {
                                                                                                      gEx('btnPause').enable();
                                                                                                      gEx('btnStart').disable();
                                                                                                      gEx('btnSelect').disable();
                                                                                                     
                                                                                                  },
                                                                                  UploadComplete:function(up,archivos)
                                                                                                  {
                                                                                                      gEx('btnStart').disable();
                                                                                                      gEx('btnSelect').enable();
                                                                                                      gEx('btnPause').disable();
                                                                                                      gEx('gLiberiasExternas').getStore().reload();
                                                                                                      
                                                                                                  },
                                                                                  FileUploaded:function(up,archivos,response)
                                                                                                  {
                                                                                                      var arrResp=response.response.split('|');
                                                                                                      if(arrResp[0]=='1')
                                                                                                      {
                                                                                                         
                                                                                                          up.removeFile(archivos);
                                                                                                          if(up.files.length==0)
                                                                                                          {
                                                                                                              gEx('btnPause').disable();
                                                                                                              gEx('btnStart').disable();
                                                                                                              gEx('btnSelect').enable();
                                                                                                          }
                                                                                                      }
                                                                                                  }
                                                                              },
                                                                      filters : 	{
                                                                                      // Maximum file size
                                                                                      max_file_size : '512mb',
                                                                                      // Specify what files to browse for
                                                                                      mime_types: [
                                                                                                     {title : "Archivo Fuente PHP", extensions : "php"}
                                                                                                  ]
                                                                                  },
                                                               
                                                                      // Resize images on clientside if we can
                                                                      resize: {
                                                                                  width : 200,
                                                                                  height : 200,
                                                                                  quality : 90,
                                                                                  crop: true // crop to exact dimensions
                                                                              },
                                                               
                                                               
                                                                      // Flash settings
                                                                      flash_swf_url : '../Scripts/plupload/js/Moxie.swf',
                                                                   
                                                                      // Silverlight settings
                                                                      silverlight_xap_url : '../Scripts/plupload/js/Moxie.xap'
                                                                  });
																}
															}
												},
										buttons:	[
														
														{
															text: 'Cerrar',
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