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
	
	
	var cObj={

                    upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                    file_post_name: "archivoEnvio",
     
                    // Flash file settings
                    file_size_limit:'1024 MB',
                    file_types :"*.xlsx; *.json; *.xml",
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
                                                              html:'Ingrese el archivo a importar:'
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
                                                          	xtype:'panel',
                                                            x:10,
                                                            y:70,
                                                            width:750,
                                                            height:200,
                                                            cls:'panelSiugj',
                                                            title:'Resumen de Importaci&oacute;n',
                                                            layout:'border',
                                                            items:	[
			                                                        	crearGridResumenExportacion()
                                                                     ]
                                                        	}/*,
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
                                                            
                                                        }*/
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Importar Expedientes',
                                        id:'vImportarExpediente',
										width: 800,
										height:390,
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
                                                                	crearControlUploadHTML5(cObj);
																}
															}
												},
										buttons:	[
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
                                                                        gEx('btnStart').hide();
                                                                        gEx('btnCancel').hide();
                                                                        gEx('btnClose').show();
                                                                        gEx('btnUploadFile').hide();
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
                                                            id:'btnCancel',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															text: 'Cerrar',
                                                            cls:'btnSIUGJ',
                                                            width:140,
                                                            hidden:true,
                                                            id:'btnClose',
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
        
        
        var cadObj='{"idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+'","validarExistencia":"1","crearNuevaTRD":"1"}';
		
        function resp(btn)
        {
        	if(btn=='yes')
            {
                function funcAjax()
                {
                    var resp=peticion_http.responseText;
                    arrResp=resp.split('|');
                    
                    switch(arrResp[0])
                    {
                    	case '1':
                        	gEx('gridResumen').getStore().loadData(eval(arrResp[1]));
                        	gEx('grid_tblTabla').getStore().reload();
                        break;
                        case '2':
                        	mostrarVentanaResolucion(cadObj);
                        
                        break;
                        default:
                        	msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                        break;
                    }
                    
                    
                }
                obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=17&cadObj='+cadObj,true);
         	}
         }
         msgConfirm('¿Est&aacute; seguro de querer importar el archivo: '+arrDatos[2]+'?',resp);
           
        
        
        
        
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
															width:600,
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

function mostrarVentanaResolucion(cadObj)
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
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Se ha detectado que ya existe en el sistema una TRD con la misma clave y nombre.<br /><br />'+
                                                            		'¿Desea importar la informaci&oacute;n como una versi&oacute;n de la misma?'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Resoluci&oacute;n de importaci&oacute;n',
										width: 500,
										height:250,
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
															text: 'No',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: 'S&iacute;',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		   
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            
                                                                            switch(arrResp[0])
                                                                            {
                                                                                case '1':
                                                                                    gEx('gridResumen').getStore().loadData(eval(arrResp[1]));
                                                                                    gEx('grid_tblTabla').getStore().reload();
                                                                                    ventanaAM.close();
                                                                                break;
                                                                                case '2':
                                                                                break;
                                                                                default:
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                break;
                                                                            }
                                                                            
                                                                            
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=17&cadObj='+
                                                                        cadObj.replace('"validarExistencia":"1"','"validarExistencia":"0"').replace('"crearNuevaTRD":"1"','"crearNuevaTRD":"0"'),true);
                                                                            
                                                                         
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}