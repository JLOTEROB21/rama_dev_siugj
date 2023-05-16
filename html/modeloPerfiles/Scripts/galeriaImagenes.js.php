<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var idCtrl=-1;
var imagenSel=null;
var uploadControl;

function mostrarGaleria(llave)
{
	idCtrl=bD(llave);
    imagenSel=null;
	var vistaImagenes=crearVistaImagen(bD(llave));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'anchor',
											items: 	[
                                            			{
                                                            xtype:'panel',
                                                          	anchor:'100% 100%',  
                                                            border:true,
                                                            frame:false,
                                                            tbar:	[
                                                                        {
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar imagen de archivo',
                                                                            handler:function()
                                                                                    {
                                                                                        mostrarVentanaAgregarImagen(bD(llave));
                                                                                    }
                                                                            
                                                                        },'-',
                                                                         {
                                                                            icon:'../images/camera_add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:true,
                                                                            text:'Agregar imagen de c&aacute;mara',
                                                                            handler:function()
                                                                                    {
                                                                                    	llaveGaleria=bD(llave);
                                                                                        var obj={};
                                                                                        obj.funcionAceptar=imagenCapturadaAceptada;
                                                                                        var c=new cImagen(obj);
                                                                                        
                                                                                        c.mostarVenanaCtrlImagen();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover imagen',
                                                                            disabled:true,
                                                                            id:'btnDelImagen',
                                                                            handler:function()
                                                                                    {
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	var aAux=eval(bD(gE('sp_'+idCtrl).getAttribute('arrElementos')));   
                                                                                                var x;
                                                                                                var arrImagenes='';
                                                                                                var o='';
                                                                                                for(x=0;x<aAux.length;x++)
                                                                                                {
                                                                                                    if((aAux[x].idArchivo!='-1')&&(aAux[x].idArchivo!=imagenSel.data.idArchivo))
                                                                                                    {
                                                                                                        o='{"imagen":"'+aAux[x].imagen+'","idArchivo":"'+aAux[x].idArchivo+'","tamano":"'+aAux[x].tamano+'"}';
                                                                                                        if(arrImagenes=='')
                                                                                                            arrImagenes=o;
                                                                                                        else
                                                                                                            arrImagenes+=','+o;
                                                                                                    }
                                                                                                }
                                                                                                gE('sp_'+idCtrl).setAttribute('arrElementos',bE('['+arrImagenes+']'));
                                                                                                gEx('phones').getStore().removeAll();
                                                                                                var arrImagenes=eval('['+arrImagenes+']');
                                                                                                gEx('phones').getStore().loadData(arrImagenes);
                                                                                                var sp=gE('sp_'+idCtrl);
																						        generarGaleriaImagen(arrImagenes,idCtrl,parseInt(sp.getAttribute('ancho')),parseInt(sp.getAttribute('alto')));
                                                                                                gEx('btnDelImagen').disable();
                                                                                            	
                                                                                                
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover la imagen seleccionada',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                                    ],
                                                            items:	[
                                                                        vistaImagenes
                                                                    ]
                                                    	}
                                                    ]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Galeria de im&aacute;genes',
										width: 650,
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

function crearVistaImagen(llave)
{
	 
                                      
    var aAux=eval(bD(gE('sp_'+llave).getAttribute('arrElementos')));   
                            
    var arrImagenes=[];
    var x;
    for(x=0;x<aAux.length;x++)
    {
    	if(aAux[x].idArchivo!='-1')
	    	arrImagenes.push(aAux[x]);
    }
    
	var alDatos=new Ext.data.JsonStore({
                                              
                                              data:arrImagenes,
                                              fields: [
                                                            {name:'idArchivo'},
                                                            {name: 'tamano'}
                                            			]
                                              
                                              
                                              
                                          }) 
                                          
	                                 
     
     
    
                                          
	var dataview = new Ext.DataView({
                                        store: alDatos,
                                       	visible:true,
                                        frame:false,
                                       	region:'center',
                                        border:false,
                                        autoHeight:true,
                                        tpl  : new Ext.XTemplate(
                                                                
                                                                    '<tpl for=".">',
                                                                        '<div class="thumb-wrap" style="width:150px; height:150px"><div class="thumb" >',
                                                                            '<img width="75" height="75" src="../paginasFunciones/obtenerArchivos.php?id={idArchivo:bE}" /></div>',
                                                                            '<span style="color: #000; font-size:10px"><b>{tamano:bytesToSize}</b></span>',
                                                                        '</div>',
                                                                    '</tpl>'

                                                            ),
                                        
                                       
                                        id: 'phones',
                                        overClass:'x-view-over',
									    itemSelector: 'div.thumb-wrap',
                                        singleSelect: true,
                                        multiSelect : false,
                                        emptyText : '<div style="padding:10px;">Sin imagenes</div>', 
                                        autoScroll  : true
                                    });
                                    
	dataview.on('click',function(dv,idx,nodo,e)
    							{
                                	imagenSel=dv.getRecord(nodo);
                                    gEx('btnDelImagen').enable();
                                    
                                }
    					)                                     
	
	return dataview;
}

function mostrarVentanaAgregarImagen(llave)
{
	llaveGaleria=llave;
	 
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
                                                              html:'Archivo de imagen: <span id="oblComprobante" style="color:#F00">*</span>'
                                                          },
                                                          
                                                          
                                                          {
                                                              x:140,
                                                              y:5,
                                                              html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                          },
                                                         
                                                          {
                                                              x:435,
                                                              y:6,
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
                                                          }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar imagen',
										width: 580,
										height:120,
										layout: 'fit',
										plain:true,
										modal:true,
                                        id:'vAgregarDocumento',
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
                                                                                upload_url: "../paginasFunciones/procesarDocumento.php", //lquevedor
                                                                                file_post_name: "archivoEnvio",
                                                                 
                                                                                // Flash file settings
                                                                                file_size_limit : "10 MB",
                                                                                file_types : "*.gif;*.png;*.jpg;*.jpeg;*.bpm",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                file_types_description : "Archivos de imagen",
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
                                                                    	if(uploadControl.files.length==0)
                                                                        {
                                                                            msgBox('Debe indicar el archivo de imagen que desea agregar');
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
	try 
    {
		file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
		
		var arrDatos=serverData.split('|');
		if ( arrDatos[0]!='1') 
		{
		} 
		else 
		{
            gEx('vAgregarDocumento').close();
            
            var aAux=eval(bD(gE('sp_'+idCtrl).getAttribute('arrElementos')));   
            var x;
            var arrImagenes='';
            var o='';
            for(x=0;x<aAux.length;x++)
            {
            	if(aAux[x].idArchivo!='-1')
                {
            		o='{"imagen":"'+aAux[x].imagen+'","idArchivo":"'+aAux[x].idArchivo+'","tamano":"'+aAux[x].tamano+'"}';
                    if(arrImagenes=='')
                    	arrImagenes=o;
                    else
                    	arrImagenes+=','+o;
                }
            }
            
            o='{"imagen":"'+arrDatos[1]+'","idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+'","tamano":"'+arrDatos[3]+'"}';
            if(arrImagenes=='')
                arrImagenes=o;
            else
                arrImagenes+=','+o;
            
            gE('sp_'+idCtrl).setAttribute('arrElementos',bE('['+arrImagenes+']'));
            gEx('phones').getStore().removeAll();
            var arrImagenes=eval('['+arrImagenes+']');
            var sp=gE('sp_'+idCtrl);
            generarGaleriaImagen(arrImagenes,idCtrl,parseInt(sp.getAttribute('ancho')),parseInt(sp.getAttribute('alto')));
            gEx('phones').getStore().loadData(arrImagenes);
            
		}
        
        
	} 
    catch (e) 
	{
		alert(e);
	}
}

function crearGridClaves()
{
	var store = new Ext.ux.maximgb.tg.AdjacencyListStore(	
      														{
                                                                autoLoad : true,
                                                                url: '../paginasFunciones/funcionesAlmacen.php',
                                                                reader: new Ext.data.JsonReader(
                                                                                                    {
                                                                                                        id: 'llave',
                                                                                                        root: 'registros',
                                                                                                        totalProperty: 'numReg',
                                                                                                        fields:	[
                                                                                                        			{name: 'id'},
                                                                                                                    {name: 'llave'},
                                                                                                                    {name: 'dimension'},
                                                                                                                    {name: 'codigoBarras'},
                                                                                                                    {name: 'codigoAlternativo'},
                                                                                                                    {name: '_parent'},
                                                                                                                    {name: 'ultimaDimension'},
                                                                                                                    {name: 'permiteGaleria'},
                                                                                                                    {name: '_is_leaf', type: 'bool'}
                                                                                                                ]
                                                                                                    }
                                                                                                    
                                                                                                )
                                                         	}
                                                          ); 
                
	
    store.on('beforeload',function(proxy)
    						{
                            	proxy.baseParams.funcion=173;
                            	proxy.baseParams.idProducto=gE('id').value;
                                
                            }
    		)
    				
                    
	store.on('load',function(almacen)
    				{
                    	gEx('btnModificar').disable();
                    	gEx('arbolCostos').getStore().expandAll();
                        if(gEx('arbolCostos').galeriaGlobal)
                        	gEx('btnGaleriaProducto').show();
                        else
                        	gEx('btnGaleriaProducto').hide();
                    }    
            )
    			                    
                    
    grid=new  Ext.ux.maximgb.tg.EditorGridPanel(	{
                                                        renderTo:'tblCostos',
                                                        enableDD: false,
                                                        border:true,
                                                        autoScroll:true,
                                                        disableSelection:true,
                                                        id:'arbolClaves',
                                                        store: store,
                                                        stripeRows: true,
                                                        columnLines :true,
                                                        loadMask :true,
                                                        width:900,
                                                        height:400,
                                                        clicksToEdit:1,
                                                        tbar:	[
                                                        			{
                                                                        	icon:'../images/application_view_icons.png',
                                                                            cls:'x-btn-text-icon',
                                                                            
                                                                            id:'btnGaleriaProducto',
                                                                            text:'Administrar Galeria de imagenes',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarGaleria('');
                                                                                    }
                                                                            
                                                                        }
                                                        		],
                                                        columns:	[
                                                                        {
                                                                            header: 'Especificaciones del producto',
                                                                            dataIndex: 'dimension',
                                                                            width: 365,
                                                                            renderer:function(v,meta,record)
                                                                            {
                                                                            
                                                                                 return [
                                                                                               '<img src="', Ext.BLANK_IMAGE_URL, '" class="ux-maximgb-tg-mastercol-icon" />',
                                                                                              
                                                                                               '<span class="ux-maximgb-tg-mastercol-editorplace">', v, '</span>'
                                                                                            ].join('');
                                                                                
                                                                                
                                                                            }
                                                                        },
                                                                        {
                                                                            header: '',
                                                                            dataIndex: 'permiteGaleria',
                                                                            width: 22,
                                                                            align:'center',
                                                                            renderer:function(val,meta,registro)
                                                                            		{
                                                                                    	var compGaleria='';
                                                                                        if(val=='1')
                                                                                        {
                                                                                        	grid.galeriaGlobal=false;
                                                                                            compGaleria='<a href="javascript:mostrarGaleria(\''+bE(registro.data.llave)+'\')"><img width="13" height="13" src="../images/application_view_icons.png" title="Galeria de imagenes" alt="Galeria de imagenes"></a>';
                                                                                           
                                                                                        }
                                                                                        return compGaleria;
                                                                                    }
                                                                            
                                                                        },
                                                                        
                                                                        
                                                                        {
                                                                            header: 'Codigo de barras',
                                                                            dataIndex: 'codigoBarras',
                                                                            width: 130,
                                                                            css:'text-align:right;',
                                                                            editor:	{xtype:'textfield'},
                                                                            renderer:function(val,meta,registro)
                                                                            		{
                                                                                    	if(registro.data.ultimaDimension=='0')
                                                                                        	return '';
                                                                                        else
                                                                                        	return val;
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                            header: 'Codigo alternativo',
                                                                            dataIndex: 'codigoAlternativo',
                                                                            width: 120,
                                                                            css:'text-align:right;',
                                                                            editor:	{xtype:'textfield'},
                                                                            renderer:function(val,meta,registro)
                                                                            		{
                                                                                    	if(registro.data.ultimaDimension=='0')
                                                                                        	return '';
                                                                                        else
                                                                                        	return val;
                                                                                    }
                                                                            
                                                                        }
                                                                    ]
                                                         
                                                
                                                        
                                                    }
                                              );
                                          
	
    grid.on('beforeedit',function(e)
    					{
                        	if(e.record.data.ultimaDimension=='0')
                            	e.cancel=true;
                        }
    		)
     
     
    grid.on('afteredit',function(e)
    					{
                        	var tipoCodigo=0;
                            if(e.field=='codigoBarras')
                            	tipoCodigo=1;
                            if(e.field=='codigoAlternativo')
                            	tipoCodigo=2;
                        
                        
                        	var cadObj='{"tipoCodigo":"'+tipoCodigo+'","valor":"'+e.value+'","llave":"'+e.record.data.llave+'","idProducto":"'+gE('id').value+'"}';
                        
                        	function funcAjax()
                            {
                                var resp=peticion_http.responseText;
                                arrResp=resp.split('|');
                                if(arrResp[0]=='1')
                                {
                                    
                                }
                                else
                                {
                                	function resp()
                                    {
                                    	e.record.set(e.field,e.originalValue);
                                    }
                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],resp);
                                }
                            }
                            obtenerDatosWeb('../paginasFunciones/funcionesAlmacen.php',funcAjax, 'POST','funcion=167&cadObj='+cadObj,true);

                        
                        }
    		)
	grid.galeriaGlobal=true;                                          
	return grid;  
   
}

function imagenCapturadaAceptada(resp)
{
    var arrResp=resp.split('|');
    if(arrResp[0]=='1')
    {
    	
      gEx('vTomarImagen').close();

      
      var aAux=eval(bD(gE('sp_'+idCtrl).getAttribute('arrElementos')));   
      var x;
      var arrImagenes='';
      var o='';
      for(x=0;x<aAux.length;x++)
      {
          if(aAux[x].idArchivo!='-1')
          {
              o='{"imagen":"'+aAux[x].imagen+'","idArchivo":"'+aAux[x].idArchivo+'","tamano":"'+aAux[x].tamano+'"}';
              if(arrImagenes=='')
                  arrImagenes=o;
              else
                  arrImagenes+=','+o;
          }
      }
      
      o='{"imagen":"'+arrResp[1]+'","idArchivo":"'+arrResp[1]+'","nombreArchivo":"'+arrResp[2]+'","tamano":"'+arrResp[3]+'"}';
      if(arrImagenes=='')
          arrImagenes=o;
      else
          arrImagenes+=','+o;
      
      gE('sp_'+idCtrl).setAttribute('arrElementos',bE('['+arrImagenes+']'));
      gEx('phones').getStore().removeAll();
      var arrImagenes=eval('['+arrImagenes+']');
      var sp=gE('sp_'+idCtrl);
      generarGaleriaImagen(arrImagenes,idCtrl,parseInt(sp.getAttribute('ancho')),parseInt(sp.getAttribute('alto')));
      gEx('phones').getStore().loadData(arrImagenes);    
        
    }
    else
    {
        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
    }
}