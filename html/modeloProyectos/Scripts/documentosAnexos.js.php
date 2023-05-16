<?php
session_start();
include("configurarIdiomaJS.php");
?>

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
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=38&idArchivo='+idArchivo,true);
		}
	}
	Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>','Est&aacute; seguro de querer eliminar el documento seleccionado?',resp);
}

function subirDocumento()
{
	var idFormulario=gE('idFormulario').value;
    var idRegistro=gE('idRegistro').value;
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
														 name:'idFormulario',
														 value:idFormulario
													 },
                                                     {
                                                     	 xtype:'hidden',
														 name:'idRegistro',
														 value:idRegistro
                                                     }
													 
												]
									}
								);
	
		ventana=new Ext.Window(
							   		{
										title:'Subir documento',
										width:450,
										height:235,
                                        y:70,
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
                                                                                                        url: '../media/guardarDocumento.php',
                                                                                                        waitMsg: 'Subiendo documento...',
                                                                                                        waitTitle:'Espere un momento por favor',
                                                                                                        success: function()
                                                                                                                            {
                                                                                                                               if(typeof(funcAgregar)!='undefined')
																												                   	funcAgregar(); 
                                                                                                                                recargarPagina();
                                                                                                                                ventana.close();
                                                                                                                            },
                                                                                                        failure: function(e,o)
                                                                                                        		{
                                                                                                                	//console.log(o);
                                                                                                                }
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