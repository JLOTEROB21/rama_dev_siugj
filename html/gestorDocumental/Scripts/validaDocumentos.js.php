<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	var arrResultados=[];
    
    new Ext.TabPanel (
    						{
                                  
                                  activeTab:0,
                                  id:'tabPanelValidacion',
                                  height:600,
                                  width:1100,
                                  cls:'tabPanelSIUGJ',
                                  renderTo:'spPanel',
                                  items:	[
                                              {
                                                  xtype:'panel',
                                                  layout:'absolute',
                                                  cls:'panelSiugjStandar',
                                                  title:'Documento Digital',
                                                  items:	[
                                                              {
                                                                  x:20,
                                                                  y:20,
                                                                  xtype:'label',
                                                                  html:'<span class="letraTituloPublicacion" style="font-size:16px">Seleccione los documentos que desea validar:</span>'
                                                              },
                                                              {
                                                                  x:30,
                                                                  y:70,
                                                                  width:800,
                                                                  height:450,
                                                                  layout:'absolute',
                                                                  xtype:'panel',
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
                                                                                  icon:'../images/icon_big_tick.gif',
                                                                                  cls:'x-btn-text-icon',
                                                                                  text: 'Validar',                                                            
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
                                              },
                                              {
                                                  xtype:'panel',
                                                  title:'Hash de Documento',
                                                  layout:'absolute',
                                                  items:	[
                                                              {
                                                                  x:20,
                                                                  y:20,
                                                                  xtype:'label',
                                                                  html:'<span class="letraTituloPublicacion">Ingrese los HASH de los documentos que desea validar:</span>'
                                                              },
                                                              {
                                                                  x:30,
                                                                  y:70,
                                                                  width:800,
                                                                  height:300,
                                                                  layout:'border',
                                                                  xtype:'panel',                                                                                                
                                                                  items:	
                                                                          [
                                                                              crearGridHashDocumento()
                                                                          ]
                                                              }
                                                          ]
                                              },
                                              {
                                                  xtype:'panel',
                                                  title:'Resultado de Validaci&oacute;n',
                                                  layout:'border',
                                                  items:	[
                                                              crearGridResultado()
                                                          ]
                                              }
                                          ]
                                  
                              }
    
                        )
                        
	uploader=$("#uploader").pluploadQueue({
                                    
                                              runtimes : 'html5,flash,silverlight,html4',
                                              browse_button:'linkTest',
                                              url : "../gestorDocumental/procesarDocumentoValidacion.php",
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
                                                                              llenarDatosResultados(arrResultados);
                                                                              
                                                                          },
                                                          FileUploaded:function(up,archivos,response)
                                                                          {
                                                                              var arrResp=response.response.split('|');
                                                                              if(arrResp[0]=='1')
                                                                              {
                                                                                  arrResultados.push(eval('['+bD(arrResp[1])+']')[0]);
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


function crearGridHashDocumento()
{	
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'hash'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:45}),
														chkRow,
														{
															header:'HASH del Documento',
															width:600,
                                                            editor:	{
                                                            			xtype:'textarea',
                                                                        height:60,
                                                            		},
															sortable:true,
                                                            renderer:function(val)
                                                            		{
                                                                    	return escaparEnter(val);
                                                                    },
															dataIndex:'hash'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridValidadorHash',
                                                            store:alDatos,
                                                            frame:false,
                                                            cm: cModelo,
                                                            clicksToEdit:1,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            cls:'gridSiugj',
                                                            stripeRows :true,
                                                            region:'center',
                                                            columnLines : true,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar HASH',
                                                                            handler:function()
                                                                            		{
                                                                                    	var registro=crearRegistro (
                                                                                        								[
                                                                                                                        	{name: 'hash'}
                                                                                                                        ]
                                                                                        							)
                                                                                    
                                                                                    	var r=new registro	(
                                                                                        						{
                                                                                                                	hash:''
                                                                                                                }
                                                                                        					)
                                                                                    
                                                                                    
                                                                                    
                                                                                    	var gridValidadorHash=gEx('gridValidadorHash');
                                                                                        gridValidadorHash.getStore().add(r);
                                                                                        gridValidadorHash.startEditing(gridValidadorHash.getStore().getCount()-1,2);
                                                                                    
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover HASH',
                                                                            handler:function()
                                                                            		{
                                                                                    	var gridValidadorHash=gEx('gridValidadorHash');
                                                                                        var filas=gridValidadorHash.getSelectionModel().getSelections();
                                                                                        
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	
                                                                                        	msgBox('Debe seleccionar los elementos que desea remover')
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        
                                                                                       	function resp(btn)
                                                                                        {
                                                                                        	gridValidadorHash.getStore().remove(filas);
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover los elementos seleccionados?',resp);
                                                                                        
                                                                                        
                                                                                        
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                            icon:'../images/icon_big_tick.gif',
                                                                            cls:'x-btn-text-icon',
                                                                            text: 'Validar',                                                            
                                                                            handler: function()
                                                                                    {
                                                                                        var gridValidadorHash=gEx('gridValidadorHash');
                                                                                        var x;
                                                                                        var fila;
                                                                                        var o='';
                                                                                        var arrRegistros='';
                                                                                        for(x=0;x<gridValidadorHash.getStore().getCount();x++)
                                                                                        {
                                                                                        	fila=gridValidadorHash.getStore().getAt(x);
                                                                                            o='{"hash":"'+fila.data.hash+'"}';
                                                                                            if(arrRegistros=='')
                                                                                            	arrRegistros=o;
                                                                                            else
                                                                                            	arrRegistros+=','+o;
                                                                                        }
                                                                                        var cadObj='{"arrRegistros":['+arrRegistros+']}';
                                                                                        function funcAjax()
                                                                                        {
                                                                                            var resp=peticion_http.responseText;
                                                                                            arrResp=resp.split('|');
                                                                                            if(arrResp[0]=='1')
                                                                                            {
                                                                                                 arrResultados=eval(arrResp[1]);
                                                                                                 llenarDatosResultados(arrResultados);
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true);

                                                                                        
                                                                                      
                                                                                    }
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}

function crearGridResultado()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name:'idArchivo'},
                                                                    {name: 'nomArchivoOriginal'},
                                                                    {name:'sha512'},
                                                                    {name:'permiteMostrar'}
                                                                ]
                                                    }
                                                );


   

	
	
   	 
     var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:45}),
                                                            {
                                                                header:'',
                                                                width:40,
                                                                sortable:true,
                                                                dataIndex:'idArchivo',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if((val=='')||(!registro.data.permiteMostrar))
                                                                            {
                                                                            	return;
                                                                            }
                                                                            
                                                                            return '<a href="javascript:abrirDocumento(\''+bE(val)+'\')"><img src="../principalPortal/imagesSIUGJ/lupa.png" title="Ver Documento" alt="Ver Documento"></a>'
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre del Archivo',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'nomArchivoOriginal',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            },
                                                            {
                                                                header:'HASH de Documento',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'sha512',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'idArchivo',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='')
                                                                            {
                                                                            	return '<img src="../images/cancel_round.png" title="Documento NO registrado en sistema" alt="Documento NO registrado en sistema"> Documento NO registrado en sistema';
                                                                            }
                                                                            
                                                                            return '<img src="../images/accept_green.png" title="Documento registrado en sistema" alt="Documento registrado en sistema"> Documento registrado en sistema'
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gResultado',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                cls:'gridSiugj',
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true
                                                                
                                                               
                                                            }
                                                        );
        return 	tblGrid;
}

function llenarDatosResultados(arrDatos)
{
	gEx('gridValidadorHash').getStore().removeAll();
	gEx('gResultado').getStore().removeAll();
	var registro=crearRegistro	(
    								[
                                    	{name:'idArchivo'},
                                        {name: 'nomArchivoOriginal'},
                                        {name:'sha512'},
                                        {name:'permiteMostrar'}
                                    ]
    							)

	var x;
    for(x=0;x<arrDatos.length;x++)
    {
    	var fila=arrDatos[x];
    
    	 var r=new registro	(
         						{
                                	idArchivo:fila.idArchivo,
                                    nomArchivoOriginal:fila.nomArchivoOriginal,
                                    sha512:fila.sha512,
                                    permiteMostrar:fila.permiteMostrar
                                }
         					)
    
    
    	gEx('gResultado').getStore().add(r);
    }

	gEx('tabPanelValidacion').setActiveTab(2);

}


function abrirDocumento(iD)
{
	var pos=obtenerPosFila(gEx('gResultado').getStore(),'idArchivo',bD(iD));
	var  registro=gEx('gResultado').getStore().getAt(pos);
	var arrNombre=registro.data.nomArchivoOriginal.split('.');
   	var extension=arrNombre[arrNombre.length-1];
    if(window.parent)
    	window.parent.mostrarVisorDocumentoProceso(extension,bD(iD),registro,registro.data.nomArchivoOriginal);
    else
	    mostrarVisorDocumentoProceso(extension,bD(iD),registro,registro.data.nomArchivoOriginal);
                                  
}