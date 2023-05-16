<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__44_tablaDinamica,CONCAT(IF(claveTipoMarcador='','',CONCAT('[',claveTipoMarcador,'] ')),nombreMarcador) AS marcador,descripcion 
				FROM _44_tablaDinamica WHERE situacion=1";
	$arrTiposMarcadores=$con->obtenerFilasArreglo($consulta);
?>
var uploadControl;
var arrMediosFirmaPermitidos=[];
var editor1;
var swfDocumento=null;
var objConfiguracionFirmaElectronica=window.parent.gEx('btnCertificacionProceso').oConfiguracion;
var IDMarcadores=0;
var arrTiposMarcadores=<?php echo $arrTiposMarcadores?>;

Ext.onReady(inicializar);

function inicializar()
{
	<?php
	if(isset($tipoFirmaPermitida[1]))
	{
	?>
		arrMediosFirmaPermitidos.push('1');
	<?php
	}
	
	if(isset($tipoFirmaPermitida[2]))
	{
	?>
		arrMediosFirmaPermitidos.push('6');
	<?php
	}
	
	if(isset($tipoFirmaPermitida[4]))
	{
	?>
		arrMediosFirmaPermitidos.push('4');
	<?php
	}
	?>

	var urlConfiguracionSL='../../modulosEspeciales_SGJP/Scripts/configCKEditorEjecucionSL.js';
    var urlConfiguracion='../../modulosEspeciales_SGJP/Scripts/configCKEditor.js';
    
    
     new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                border:false,
                                                tbar:	[
                                                			{
                                                                icon:'../images/guardar.PNG',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnSave',
                                                                
                                                                tooltip:'Guardar documento',
                                                                handler:function()
                                                                        {
                                                                            guardarDocumento();
                                                                        }
    
                                                            },
                                                            '-',
                                                            {
                                                                icon:'../imagenesDocumentos/16/file_extension_pdf.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnDownload',
                                                                tooltip:'Descargar documento',
                                                                handler:function()
                                                                        {
                                                                            guardarDocumentoPDF();
                                                                        }
    
                                                            },
                                                            '-',
                                                            {
                                                                icon:'../images/printer.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnPrint',
                                                                tooltip:'Imprimir documento',
                                                                handler:function()
                                                                        {
                                                                            imprimirDocumento();
                                                                        }
    
                                                            },'-',
                                                            {
                                                                icon:'../images/firma.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnSing',
                                                                
                                                                tooltip:'Firmar documento',
                                                                handler:function()
                                                                        {
                                                                            firmarDocumento(editor1);
                                                                        }
    
                                                            }
                                                		],
                                                items:	[
                                                            {
                                                            	
                                                                region:'center',
                                                                html:'<table width="100%"><tr><td align="center"><textarea style="width:450px" id="txtDocumento">'+
                                                                		'</textarea></td></tr></table>'
                                                            }
                                                        ]
                                            }
                                         ]
                            }
                        )
    
	editor1=	CKEDITOR.replace('txtDocumento',
                                                     {
                                                     	
                                                        customConfig:(gE('sL').value=='1'?urlConfiguracionSL:urlConfiguracion),
                                                        height:370,
                                                        width:700,
                                                        on:	{
                                                        		instanceReady:function(evt)
                                                                			{
                                                                            	//evt.editor.execCommand('maximize');
                                                                                var boton=$('.cke_button__psavefirmaelectronica');
                                                                               
                                                                                if((boton.length>0)&&(!objConfiguracionFirmaElectronica))
                                                                                {
                                                                                	boton[0].style.display='none';
                                                                                }
                                                                            }
                                                                
                                                        	}
                                                     }
                                    );
                                    
	                  
	editor1.setData(bD(gE('txtCuerpo').value));

	if(gE('sL').value=='1')
	    editor1.setReadOnly(true);

    
}

function refrescarMenuDTD()
{
	window.parent.mostrarMenuDTD();
}

function imprimirDocumento()
{
	
	var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'","tipoFormato":"'+gE('tipoFormato').value+'","cuerpoFormato":"'+
				bE(CKEDITOR.instances.txtDocumento.getData())+'","idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistro').value+
				'","idReferencia":"'+gE('idReferencia').value+'","idFormularioProceso":"'+(gE('idFormularioProceso')?gE('idFormularioProceso').value:-1)+'"}';
	
	function funcAjax()
	{
		var resp=peticion_http.responseText;		
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			gE('idRegistroFormato').value=arrResp[1];
			var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'"}';
        	window.parent.recargarMenuDTD();
			function funcAjax2()
			{
				var resp=peticion_http.responseText;
				
				arrResp=resp.split('|');
				if(arrResp[0]=='1')
				{
					var iFrame=gE('frameEnvio');
					if(iFrame)
					{
						iFrame.parentNode.removeChild(iFrame);
					}

					primeraCargaFrame=false;
					iFrame=cE('iFrame');
					iFrame.name='frameEnvio';
					iFrame.id='frameEnvio';
					//iFrame.style='display:none';
					iFrame.style='width:1px; height:1px;';
					document.body.appendChild(iFrame);
					asignarEvento(iFrame,'load',frameLoad);
					var arrParametros=[['ref',generarNumeroAleatorio(10000,99999)+'_'+bE(gE('idRegistroFormato').value)]];
					enviarFormularioDatos('../modulosEspeciales_SGJP/obtenerDocumentoDigitalProceso.php',arrParametros,'POST','frameEnvio');
					
				}
				else
				{
					
					msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax2, 'POST','funcion=3&cadObj='+cadObj,true);
		}
		else
		{
			
			msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=1&cadObj='+bE(cadObj),true);
	
	
	
}

function frameLoad(iFrame)
{
    if(!primeraCargaFrame)
    {
        setTimeout(
                        function()
                        {
                            iFrame.contentWindow.print()
                        }, 10
                   );
        
        
    }
    else
        primeraCargaFrame=false;
    
}


function guardarDocumento(funcionEjecucion)
{
	
	var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'","tipoFormato":"'+gE('tipoFormato').value+'","cuerpoFormato":"'+
				bE(CKEDITOR.instances.txtDocumento.getData())+'","idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+
				gE('idRegistro').value+'","idReferencia":"'+gE('idReferencia').value+'","idFormularioProceso":"'+gE('idFormularioProceso').value+'"}';
	
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
        	window.parent.recargarMenuDTD();
			gE('idRegistroFormato').value=arrResp[1];
			
			if(typeof(confEditor.functionAfterSaveDocument)!='undefined')
				confEditor.functionAfterSaveDocument();
			if(typeof(funcionEjecucion)!='undefined')
				funcionEjecucion();
			
		}
		else
		{
			
			msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=1&cadObj='+bE(cadObj),true);
	
	
}

function guardarDocumentoPDF()
{
	var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'","tipoFormato":"'+gE('tipoFormato').value+'","cuerpoFormato":"'+
				bE(CKEDITOR.instances.txtDocumento.getData())+'","idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistro').value+
				'","idReferencia":"'+gE('idReferencia').value+'","idFormularioProceso":"'+(gE('idFormularioProceso')?gE('idFormularioProceso').value:-1)+'"}';
	
	function funcAjax()
	{
		var resp=peticion_http.responseText;		
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			gE('idRegistroFormato').value=arrResp[1];
			var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'"}';
	       	window.parent.recargarMenuDTD();
	
			function funcAjax2()
			{
				var resp=peticion_http.responseText;
				
				arrResp=resp.split('|');
				if(arrResp[0]=='1')
				{
					var arrParametros=[['ref',generarNumeroAleatorio(10000,99999)+'_'+bE(gE('idRegistroFormato').value)]];
					enviarFormularioDatos('../modulosEspeciales_SGJP/obtenerDocumentoDigitalProceso.php',arrParametros,'POST','_blank');
					
				}
				else
				{
					
					msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax2, 'POST','funcion=3&cadObj='+cadObj,true);
		}
		else
		{
			
			msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=1&cadObj='+bE(cadObj),true);
	
	
	
	
}

function firmarDocumento(e)
{
	var oConfiguracion=objConfiguracionFirmaElectronica;
	var arrAcciones='';
	var x;
	var accion;
	var oAccion='';
	for(x=0;x<oConfiguracion.arrAcciones.length;x++)
	{
		  accion=oConfiguracion.arrAcciones[x];
		  oAccion='{"idAccion":"'+accion.idAccion+'","etiquetaAccion":"'+accion.etiquetaAccion.replace(/"/gi,"'")+'","etapaEnvio":"'+accion.etapaEnvio+'","documentoFinal":"'+accion.documentoFinal+'"}';
		  if(arrAcciones=='')
			  arrAcciones=oAccion;
		  else
			  arrAcciones+=','+oAccion;
	}
	
	var cadConf='{"funcionManejoResultado":"procesoCertificacionFirmaRealizado","idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistro').value+
				  '","actor":"'+bD(gE('actor').value)+'","arrAcciones":['+arrAcciones+']}';
	
	
	if(e.readOnly)
	{
		mostrarVentanaFirmaElectronica(cadConf);
	}
	else
	{
		var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'","tipoFormato":"'+gE('tipoFormato').value+
				'","cuerpoFormato":"'+bE(CKEDITOR.instances.txtDocumento.getData())+'","idFormulario":"'+gE('idFormulario').value+
				'","idRegistro":"'+gE('idRegistro').value+'","idReferencia":"'+gE('idReferencia').value+
				'","idFormularioProceso":"'+gE('idFormularioProceso').value+'"}';
		
		function funcAjax()
		{
			var resp=peticion_http.responseText;
			
			arrResp=resp.split('|');
			if(arrResp[0]=='1')
			{
   	        	window.parent.recargarMenuDTD();
				gE('idRegistroFormato').value=arrResp[1];				
				mostrarVentanaFirmaElectronica(cadConf);
				
				
			}
			else
			{
				
				msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
			}
		}
		obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=1&cadObj='+bE(cadObj),true);
	
	}
	
}


function mostrarVentanaFirmaElectronica(objConf)
{
	objConf=eval('['+(objConf)+']')[0];	
	objGlobal=objConf;	
    var arrAccionesFirma=[];
    
    var x;
    var oAccion;
    for(x=0;x<objConf.arrAcciones.length;x++)
    {
    	oAccion=objConf.arrAcciones[x];
		if(parseFloat(oAccion.etapaEnvio)>0)
    	{
    		if((oAccion.idAccion=='1')||(oAccion.idAccion=='6')||(oAccion.idAccion=='4'))
    		{
    			if(existeValorArreglo(arrMediosFirmaPermitidos,oAccion.idAccion)==-1)
    			{
    				continue;
    			}
	
			
    		}
	    	arrAccionesFirma.push([oAccion.idAccion,oAccion.etiquetaAccion,oAccion.documentoFinal]);
	    }
    }
    
	var cmbAccionFirma=crearComboExt('cmbAccionFirma',arrAccionesFirma,150,5,300);
    cmbAccionFirma.on('select',function(cmb,registro)
    							{
                                	gEx('fSetFirma').hide();
									gEx('fSetFirmaDocumento').hide();
									gEx('fSetFirmaFirel').hide();
									
									gEx('vDocumento').setHeight(250);
                                	switch(registro.data.id)
                                    {
                                    	case '1':                                        	
											gEx('fSetFirmaDocumento').hide();
											gEx('fSetFirmaFirel').hide();
											gEx('fSetFirma').show();
											gEx('vDocumento').setHeight(380);
                                        break;
                                       	case '6':                                        	
											gEx('fSetFirmaDocumento').hide();
											gEx('fSetFirmaFirel').show();
											gEx('fSetFirma').hide();
											gEx('vDocumento').setHeight(380);
                                        break;
                                        break;
										case '4':
											gEx('fSetFirma').hide();
											gEx('fSetFirmaFirel').hide();
											gEx('fSetFirmaDocumento').show();
											gEx('vDocumento').setHeight(330);
                                        break;
                                    }
									
									gEx('vDocumento').center();
                                }
    				)
					
						
					
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	
                                                            x:10,
                                                            y:10,
                                                            html:'Acci&oacute;n a realizar:'
                                                            
                                                        },
                                                        cmbAccionFirma,
                                                        {
                                                        	
                                                            x:10,
                                                            y:40,
                                                            html:'Comentarios adicionales:'
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            width:580,
                                                            heigt:60,
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales'
                                                        },
                                                        {
                                                        	id:'fSetFirma',
                                                        	xtype:'fieldset',
                                                            width:580,
                                                            x:10,
                                                            y:160,
                                                            height:120,
															hidden:true,
                                                            defaultType: 'label',
                                                            layout:'absolute',
                                                            items:	[
                                                         				
                                                                        {
                                                                            x:10,
                                                                            y:10,
                                                                            html:'Ingrese su archivo de certificado digital (*.cer):'
                                                                        },
                                                                        {
                                                                            x:250,
                                                                            y:10,
                                                                            html:'<input style="font-size:11px !important;" type="file" id="fileCer" accept=".cer" style="width:250px">'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:40,
                                                                            html:'Ingrese su archivo de llave privada (*.key):'
                                                                        },
                                                                        {
                                                                            x:250,
                                                                            y:40,
                                                                            html:'<input style="font-size:11px !important;" type="file" id="fileKey" accept=".key" style="width:250px">'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:70,
                                                                            html:'Ingrese la contrase&ntilde;a de llave privada:'
                                                                        },
                                                                        {
                                                                            x:250,
                                                                            y:65,
                                                                            width:250,
                                                                            id:'txtPassword',
                                                                            xtype:'textfield',
                                                                            inputType:'password'
                                                                        }   
                                                            		]
                                                        },
                                                        {
                                                        	id:'fSetFirmaFirel',
                                                        	xtype:'fieldset',
                                                            width:580,
                                                            x:10,
                                                            y:160,
                                                            height:120,
															hidden:true,
                                                            defaultType: 'label',
                                                            layout:'absolute',
                                                            items:	[
                                                         				{
                                                                            x:10,
                                                                            y:10,
                                                                            html:'Ingrese su archivo de llave privada (*.pfx):'
                                                                        },
                                                                        {
                                                                            x:250,
                                                                            y:10,
                                                                            html:'<input style="font-size:11px !important;" type="file" id="filePFX" accept=".pfx" style="width:250px">'
                                                                        },
                                                                        
                                                                        {
                                                                            x:10,
                                                                            y:40,
                                                                            html:'Ingrese la contrase&ntilde;a de llave privada:'
                                                                        },
                                                                        {
                                                                            x:250,
                                                                            y:35,
                                                                            width:250,
                                                                            id:'txtPasswordFirel',
                                                                            xtype:'textfield',
                                                                            inputType:'password'
                                                                        }   
                                                            		]
                                                        },
														{
                                                        	id:'fSetFirmaDocumento',
                                                        	xtype:'fieldset',
															hidden:true,
                                                            width:580,
                                                            x:10,
                                                            y:150,
                                                            height:80,
                                                            defaultType: 'label',
                                                            layout:'absolute',
                                                            items:	[
                                                         				{
                                                                            x:10,
                                                                            y:10,
                                                                            html:'Ingrese su documento de firma:'
                                                                        },
																		{
                                                                            x:180,
                                                                            y:5,
                                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                                        },
                                                                       
                                                                        {
                                                                            x:475,
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
																		} 
                                                            		]
                                                        }
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										id:'vDocumento',
										title: 'Firmar documento',
										width: 625,
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
																	gEx('txtPassword').focus(false,500);																
																	
																	var cObj={
                                                                    // Backend settings
                                                                                            upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                            file_post_name: "archivoEnvio",
                                                                             
                                                                                            // Flash file settings
                                                                                            file_size_limit : "1000 MB",
                                                                                            file_types : "*.pdf; *.jpg; *.gif; *.png; *.jpeg",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                            file_types_description : "Todos los archivos",
                                                                                            file_upload_limit : 0,
                                                                                            file_queue_limit : 1,
                                                                             
                                                                                            
                                                                                            upload_success_handler : subidaCorrectaFinal
                                                                                        };   
																	crearControlUploadHTML5(cObj);
																}
															}
												},
										buttons:	[
														{
															
															text: 'Aceptar',                                                            
															handler: function()
																	{
																		if(cmbAccionFirma.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbAccionFirma.focus();
                                                                            }
                                                                            msgBox('Debe indicar la acci&oacute;n a realizar',resp);
                                                                            return;
                                                                        }
																		var objResultado={};
                                                                        objResultado.accion=cmbAccionFirma.getValue();
                                                                        objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
                                                                        objResultado.cadenaFirma='';
                                                                        
																		var pos=obtenerPosFila(gEx('cmbAccionFirma').getStore(),'id',objResultado.accion);
                                                                        var documentoFinal=gEx('cmbAccionFirma').getStore().getAt(pos).data.valorComp;
																		
                                                                       
                                                                       	switch(parseInt(cmbAccionFirma.getValue()))
																		{
																			case 1:
																				if(gE('fileCer').value=='')
																				{
																					function resp1Cer()
																					{
																						gE('fileCer').focus();
																					}
																					msgBox('Debe ingresar el archivo de certificado digital (*.cer)',resp1Cer);
																					return;
																				}
																				
																				if(gE('fileKey').value=='')
																				{
																					function resp2Cer()
																					{
																						gE('fileKey').focus();
																					}
																					msgBox('Debe ingresar el archivo de llave privada (*.key)',resp2Cer);
																					return;
																				}
																				
																				if(gEx('txtPassword').getValue().trim()=='')
																				{
																					function resp3Cer()
																					{
																						gEx('txtPassword').focus();
																					}
																					msgBox('Debe ingresar la contrase&ntilde;a de llave privada',resp3Cer);
																					return;
																				}
																				objResultado.cadenaFirma=''
																				var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+gE('idRegistroFormato').value+
																						'","cadena":"'+objResultado.cadenaFirma+'","tipoFirma":"1"}';															
																				
																				var oObj=eval('['+cadObj+']')[0];
																				
																				
																				var formData = new FormData();
																				
																				formData.append('passwd',AES_Encrypt(gEx('txtPassword').getValue()));
																				
																				
																				for(var campo in oObj)
																				{
																					
																					formData.append(campo,oObj[campo]);
																					
																					
																					
																				}
																				
																				
																				
																				formData.append('fCer',gE('fileCer').files[0]);
																				formData.append('fKey',gE('fileKey').files[0]);
																				mostrarMensajeProcesando('Firmando documento, &eacute;sta operaci&oacute;n puede tardar unos minutos...');
																				$.ajax	({
																							url: "../paginasFunciones/procesarDocumentoFirmaElectronica.php",
																							data: formData,
																							processData: false,
																							contentType: false,
																							type: 'POST',
																							success: function(data)
																									{
																										ocultarMensajeProcesando();
																										var oResp=eval('['+data+']')[0];
																										if(oResp.resultado=='1')
																										{
																											eval("window.parent."+objConf.funcionManejoResultado+'(objResultado);')
																											ventanaAM.close();
																										}
																										else
																										{
																											msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:<br><br>'+bD(oResp.mensaje));
																										}
																									}
																						});
																				
																				
																				
																			break
																			case 6:
																				
																				if(gE('filePFX').value=='')
																				{
																					function resp1CerFirel()
																					{
																						gE('filePFX').focus();
																					}
																					msgBox('Debe ingresar el archivo de llave privada (*.pfx)',resp1CerFirel);
																					return;
																				}
																				
																				
																				
																				if(gEx('txtPasswordFirel').getValue().trim()=='')
																				{
																					function resp2CerFirel()
																					{
																						gEx('txtPasswordFirel').focus();
																					}
																					msgBox('Debe ingresar la contrase&ntilde;a de llave privada',resp2CerFirel);
																					return;
																				}
																				objResultado.cadenaFirma=''
																				var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+gE('idRegistroFormato').value+
																						'","cadena":"'+objResultado.cadenaFirma+'","tipoFirma":"2"}';																
																				
																				
																				var oObj=eval('['+cadObj+']')[0];
																				
																				
																				var formData = new FormData();
																				
																				formData.append('passwd',AES_Encrypt(gEx('txtPasswordFirel').getValue()));
																				
																				
																				for(var campo in oObj)
																				{
																					formData.append(campo,oObj[campo]);
																				}
																				
																				
																				
																				formData.append('fCer',gE('filePFX').files[0]);
																				mostrarMensajeProcesando('Firmando documento, &eacute;sta operaci&oacute;n puede tardar unos minutos...');
																				
																				$.ajax	({
																							url: "../paginasFunciones/procesarDocumentoFirmaElectronica.php",
																							data: formData,
																							processData: false,
																							contentType: false,
																							type: 'POST',
																							success: function(data)
																									{
																										ocultarMensajeProcesando();
																										var oResp=eval('['+data+']')[0];
																										if(oResp.resultado=='1')
																										{
																											eval("window.parent."+objConf.funcionManejoResultado+'(objResultado);')
																											ventanaAM.close();
																										}
																										else
																										{
																											msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:<br><br>'+bD(oResp.mensaje));
																										}
																									}
																						});
																			break
																			case 4:
																				
                                                                                if(uploadControl.files.length==0)
                                                                                {
                                                                                    msgBox('Debe ingresar el documento mediante cual desea registrar su firma');
																					return;
                                                                                }
                                                                                uploadControl.start();
                                                                                
																			break;
																			default:
																				eval("window.parent."+objConf.funcionManejoResultado+'(objResultado);')
																				ventanaAM.close();
																			break;
																		}
                                                                       
                                                                       
                                                                       
                                                                        
																		
																		
																	}
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);


	ventanaAM.show();
	if(arrAccionesFirma.length==1)	
	{
		cmbAccionFirma.setValue(arrAccionesFirma[0][0]);
		cmbAccionFirma.fireEvent('select',cmbAccionFirma,cmbAccionFirma.getStore().getAt(0));
	}
}


function subidaCorrectaFinal(file, serverData) 
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
            
			
			var objResultado={};
			objResultado.accion=gEx('cmbAccionFirma').getValue();
			objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
			
			var pos=obtenerPosFila(gEx('cmbAccionFirma').getStore(),'id',objResultado.accion);
			
			var cadObj='{"documentoFinal":"'+gEx('cmbAccionFirma').getStore().getAt(pos).data.valorComp+'","idRegistroFormato":"'+gE('idRegistroFormato').value+'","idArchivo":"'+arrDatos[1]+'","cadena":"'+arrDatos[2]+'"}';

			function funcAjax2()
			{
				var resp=peticion_http.responseText;
				
				var oResp=eval('['+resp+']')[0];
				if(oResp.resultado=='1')					
				{
					
					eval("window.parent."+objGlobal.funcionManejoResultado+'(objResultado);')
				}
				else
				{
					
					msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+(oResp.mensaje));
				}
				
			}
			obtenerDatosWeb('../paginasFunciones/procesarDocumentoFirmaElectronica.php',funcAjax2, 'POST','cadObj='+cadObj,true);
			
			gEx('vDocumento').close();
            
		}
		
	
}