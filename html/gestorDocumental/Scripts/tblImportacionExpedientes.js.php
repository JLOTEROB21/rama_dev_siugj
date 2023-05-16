<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idRegistroPerfil,nombrePerfilExportacion FROM 20007_perfilesImportacionExportacionExpedientes WHERE tipoPerfil=2";
	$arrPerfilesExportacion=$con->obtenerFilasArreglo($consulta);
?>
Ext.onReady(inicializar);


function inicializar()
{
	
}

var arrPerfilesImportacion=<?php echo $arrPerfilesExportacion?>;

function mostrarVentanaImportacion()
{
	
	var cmbPerfilImportacion;
	var cObj={

                    upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                    file_post_name: "archivoEnvio",
     
                    // Flash file settings
                    file_size_limit:'1024 MB',
                    file_types :"*.*",
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
                                                              html:'Ingrese el documento a adjuntar:'
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
                                                        },
                                                        {
                                                              xtype:'label',
                                                              x:10,
                                                              y:60,
                                                              cls:'SIUGJ_Etiqueta',
                                                              html:'Perfil de Importaci&oacute;n a aplicar:'
                                                          },
                                                        	{
                                                              x:300,
                                                              y:55,
                                                              html:'<div id="divPerfilImportacion"></div>'
                                                          },
                                                          {
                                                          	xtype:'panel',
                                                            x:10,
                                                            y:100,
                                                            width:750,
                                                            height:200,
                                                            cls:'panelSiugj panelTitulo18',
                                                            title:'Resumen de Importaci&oacute;n',
                                                            layout:'border',
                                                            items:	[
			                                                        	crearGridResumenExportacion()
                                                                     ]
                                                        	},
                                                           {
                                                        	x:10,
                                                            y:350,
                                                            hidden:true,
                                                            html:'% Avance:'
                                                        },
                                                        {
                                                        	x:90,
                                                            y:345,
                                                            hidden:true,
                                                            xtype:'progress',
                                                            width:300
                                                            
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Importar Expedientes',
										width: 800,
										height:420,
										layout: 'fit',
										plain:true,
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
                                                                	cmbPerfilImportacion=crearComboExt('cmbPerfilImportacion',arrPerfilesImportacion,0,0,300,{renderTo:'divPerfilImportacion',ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl'});
                                                                	 crearControlUploadHTML5(cObj);
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
                                                            id:'btnCancel',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															text: 'Cerrar',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
                                                            hidden:true,
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
																		if(cmbPerfilImportacion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbPerfilImportacion.focus();
                                                                            }
                                                                            msgBox('Debe indicar el perfil de importaci&oacute;n a aplicar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                            msgBox('Debe ingresar el archivo que desea importar');
                                                                            return;
                                                                        }
                                                                        uploadControl.start();
                                                                        gEx('btnStart').hide();
                                                                        gEx('btnCancel').hide();
                                                                        gEx('btnClose').show();
                                                                        
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
        
        
        var cadObj='{"idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+'","idPerfilImportacion":"'+gEx('cmbPerfilImportacion').getValue()+
        			'","tipoOperacion":"1"}';
		function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	var oResultado=eval('['+arrResp[1]+']')[0];
               
               if(oResultado.error==1)
               {
                    function respFinal()
                    {
                    	gEx('gridResumen').getStore().loadData(oResultado.mensajeError);
                    }
                    msgBox('Ha ocurrido al menos un error que impide la importaci&oacute;n del expediente',respFinal)
                    return;
               }
               else
               {
                	mostrarVentanaInformacionExpediente(oResultado);
               	} 
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=7&cadObj='+cadObj,true);
        
        
        
        
        
    }
		
	
}



function crearGridResumenExportacion()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idResumen'},
                                                                    {name: 'resumen'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														
														{
															header:'',
															width:650,
															sortable:true,
															dataIndex:'resumen'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridResumen',
                                                            store:alDatos,
                                                            border:false,
                                                            frame:false,
                                                            cls:'gridSiugj',
                                                           	region:'center',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true
                                                        }
                                                    );
	return 	tblGrid;	
}

function mostrarVentanaInformacionExpediente(objInformacion)
{
	
	var claveUnidad='';
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
                                                            html:'C&oacute;digo &Uacute;nico de Proceso:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:300,
                                                            x:250,
                                                            y:5,
                                                            value:objInformacion.carpetaAdministrativa,
                                                            id:'txtExpediente',
                                                            cls:'controlSIUGJ'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:50,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Despacho asociado:'
                                                        },
                                                        {
                                                            x:250,
                                                            y:45,
                                                            html:'<div id="divComboDespacho">'
                                                        }
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Datos generales',
										width: 800,
										height:220,
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
                                                                	var oConf=	{
                                                                                    idCombo:'cmbDespacho',
                                                                                    anchoCombo:500,
                                                                                    posX:0,
                                                                                    posY:0,
                                                                                    raiz:'registros',
                                                                                    campoDesplegar:'nombreUnidad',
                                                                                    campoID:'claveUnidad',
                                                                                    funcionBusqueda:30,
                                                                                    renderTo:'divComboDespacho',
                                                                                    ctCls:'campoComboWrapSIUGJAutocompletar',
                                                                                    listClass:'listComboSIUGJControl',
                                                                                    paginaProcesamiento:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',
                                                                                    confVista:'<tpl for="."><div class="search-item">{nombreUnidad}<br></div></tpl>',
                                                                                    campos:	[
                                                                                                {name:'claveUnidad'},
                                                                                                {name:'nombreUnidad'}
                                                            
                                                                                            ],
                                                                                    funcAntesCarga:function(dSet,combo)
                                                                                                {
                                                                                                    claveUnidad='';
                                                                                                    var aValor=combo.getRawValue();
                                                                                                    dSet.baseParams.criterio=aValor;
                                                                                                    dSet.baseParams.iR=-1;
                                                                                                    
                                                                                                                                          
                                                                                                    
                                                                                                },
                                                                                    funcElementoSel:function(combo,registro)
                                                                                                {
                                                                                                    claveUnidad=registro.data.claveUnidad;
                                                                                                    
                                                                                                }  
                                                                                };
                                                                                
                                                                		var cmbDespacho=crearComboExtAutocompletar(oConf);
                                                                        
                                                                        
                                                                        if(objInformacion.lblUnidadGestion!='')
                                                                        {
                                                                        	cmbDespacho.setRawValue(objInformacion.lblUnidadGestion);
                                                                            claveUnidad=objInformacion.unidadGestion;
                                                                        }
                                                                        else
                                                                        {
                                                                        	cmbDespacho.setRawValue('[Despacho no registrado en sistema]');
                                                                            claveUnidad='';
                                                                        }
                                                                        gEx('txtExpediente').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var txtExpediente=gEx('txtExpediente');
                                                                        var cmbDespacho=gEx('cmbDespacho');
                                                                        
                                                                        if(txtExpediente.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtExpediente.focus();
                                                                            }
                                                                            msgBox('Debe indicar el expediente bajo el cual la informaci&oacute;n ser&aacute; importada',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(claveUnidad=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbDespacho.focus();
                                                                            }
                                                                            msgBox('Debe indicar el despacho bajo con el cual ser&aacute; asociado el expediente',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idArchivo":"'+cv(objInformacion.idArchivo)+'","nombreArchivo":"'+
                                                                        			cv(objInformacion.nombreArchivo)+'","tipoOperacion":"2","despacho":"'+
                                                                                    claveUnidad+'","expediente":"'+txtExpediente.getValue()+
                                                                                    '","idPerfilImportacion":"'+objInformacion.idPerfilImportacion+'"}';
                                                                     	
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var oResultado=eval('['+arrResp[1]+']')[0]
                                                                                gEx('gridResumen').getStore().loadData(eval(oResultado.informacion));
                                                                                gEx('grid_tblTabla').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=7&cadObj='+cadObj,true);   
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
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