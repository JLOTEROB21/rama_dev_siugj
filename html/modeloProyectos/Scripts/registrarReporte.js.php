<?php session_start();
include("configurarIdiomaJS.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	crearRichText('_reportevch','sReporte',700,450,'../fckconfigReporte.js',contenidoReporte);
    var _porcentajeAvanceflo=gE('_porcentajeAvanceflo');
    if(_porcentajeAvanceflo!=null)
    	_porcentajeAvanceflo.focus();
}

function eliminarDocumento(idArchivo)
{
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
                	var fila=gE('fila_'+idArchivo);
                    if(typeof(funcAgregar)!='undefined')
						funcAgregar(); 
                    if(fila!=null)
	                    fila.parentNode.removeChild(fila);  
                    else
                    	recargarPagina();	
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=95&idArchivo='+idArchivo,true);
		}
	}
	Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>','Est&aacute; seguro de querer eliminar el documento seleccionado?',resp);
}

function subirDocumento()
{
	var idReporte=gE('id').value;

	var fp = new Ext.FormPanel	(
									{
										fileUpload: true,
										width: 500,
										frame: true,
										autoHeight: true,
										bodyStyle: 'padding: 10px 10px 0 10px;',
										labelWidth: 100,
										defaults: 	{
														anchor: '100%',
														
														msgTarget: 'side'
													},
								
										items:	[
												 	{
														xtype: 'fileuploadfield',
														id: 'form-file',
														emptyText: 'Elija un documento',
														fieldLabel: 'Documento',
														name: 'image',
														buttonText: '',
														
														buttonCfg: 	{
																		iconCls: 'upload-icon'
																	}
													},
													{
														name:'titular',
														xtype: 'textfield',
														id: 'titulo',
														fieldLabel: 'T&iacute;tulo'
													
													},
													{
														name:'descript', 
														xtype: 'textarea',
														id: 'describe',
														fieldLabel: 'Descripcion'
													 },
													 {
														 xtype:'hidden',
														 name:'idReporte',
														 value:idReporte
													 }
												]
									}
								);
	
		ventana=new Ext.Window(
							   		{
										title:'Subir documento',
										width:450,
										height:235,
										layout:'fit',
										buttonAlign:'center',
										items:[fp],
										modal:true,
										plain:true,
										listeners:
                                                    {
                                                        show:
                                                                {
                                                                    buffer:10,
                                                                    fn:function()
                                                                            {
                                                                                
                                                                            }
                                                                }
                                                    },
											buttons: 	[
															{
																text: 'Agregar',
																handler: function()
																		{
																			archivo=gE('form-file-file');
																			archivoName=archivo.value;
                                                                            var titulo=Ext.getCmp('titulo');
                                                                            var txtTitulo=titulo.getValue();
                                                                            var archivo=Ext.getCmp('form-file');
                                                                            if(archivo.getValue()=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	
                                                                                }
                                                                            	msgBox('Debe seleccionar el documento a subir',resp);
                                                                                return;
                                                                            }
                                                                            if(txtTitulo=='')
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	//Ext.getCmp('titulo').setFocus();
                                                                                }
                                                                            	msgBox('Debe ingresar el título del documento',resp2);
                                                                                return;
                                                                            }
                                                                            
																			fp.getForm().submit	(	
                                                                                                    {
                                                                                                        url: '../media/guardarDocumentoReporte.php',
                                                                                                        waitMsg: 'Subiendo documento...',
                                                                                                        success: function()
                                                                                                                            {
                                                                                                                               
                                                                                                                                ventana.close();
                                                                                                                            },
                                                                                                        failure: this.falloAccion
                                                                                                    }
                                                                                                );
																				
																			
																
																		}
															},
															{
																text: 'Cancelar',
																handler: function()
																		{
																			ventana.close();
																		}
															}
														]
									}
							   )
		
		ventana.show();
}

function cancelar()
{
	function resp(btn)
    {
    	if(btn=='yes')
        {
        	regresarPagina();
        }
    }
    msgConfirm('Est&aacute; seguro de salir del registro de reporte?',resp);
    
}

function guardarBorrador()
{
	var _porcentajeAvanceflo=gE('_porcentajeAvanceflo');
    if(_porcentajeAvanceflo!=null)
    {
    	var porcentaje=_porcentajeAvanceflo.value;
        if(porcentaje=='')
        	porcentaje='0';
        porcentaje=parseFloat(porcentaje);
        var sPorcentajeTotal=gE('porcentajeTotal');
        var porcentajeTotal=parseFloat(sPorcentajeTotal.innerHTML);
        if((porcentajeTotal+porcentaje)>100)
        {
        	function respP()
            {
            	_porcentajeAvanceflo.focus();
            }
        	msgBox('El porcentaje de avance ingresado no es v&aacute;lido, ya que se exceder&iacute;a el 100% de realizaci&oacute;n de la actividad.',respP);
            return;
        }
    }

	gE('frmEnvio').submit();
}

function guardarReporte()
{
	if(validarFormularios('frmEnvio'))
    {
    	var _porcentajeAvanceflo=gE('_porcentajeAvanceflo');
        if(_porcentajeAvanceflo!=null)
        {
            var porcentaje=_porcentajeAvanceflo.value;
            if(porcentaje=='')
                porcentaje='0';
            porcentaje=parseFloat(porcentaje);
            var sPorcentajeTotal=gE('porcentajeTotal');
            var porcentajeTotal=parseFloat(sPorcentajeTotal.innerHTML);
            if((porcentajeTotal+porcentaje)>100)
            {
                function respP()
                {
                    _porcentajeAvanceflo.focus();
                }
                msgBox('El porcentaje de avance ingresado no es v&aacute;lido, ya que se exceder&iacute;a el 100% de realizaci&oacute;n de la actividad.',respP);
                return;
            }
        }

    	txtEnriquecido=Ext.ux.FCKeditorMgr.get('_reportevch');
        if(txtEnriquecido.GetHTML()=='')
        {
        	msgBox('El contenido del reporte no puede estar vac&iacute;o');
        	return;
        }
        function resp(btn)
        {
        	if(btn=='yes')
            {
            	gE('_situacionint').value='2';
            	gE('frmEnvio').submit();
            }
        }
        msgConfirm('Est&aacute; seguro de querer guardar el reporte como terminado?',resp);
    }
}
