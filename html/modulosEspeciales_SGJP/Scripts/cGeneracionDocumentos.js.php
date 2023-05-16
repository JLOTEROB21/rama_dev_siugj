<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var uploadControl;
var swfDocumento=null;

var objConf=null;
var objGlobal=null;

var objConfiguracionDocumento=null;

var confEditor=null;
var urlConfiguracion='../../modulosEspeciales_SGJP/Scripts/configCKEditorEjecucionV2.js';
var urlConfiguracionSL='../../modulosEspeciales_SGJP/Scripts/configCKEditorEjecucionSL.js';


var firma =null;

Ext.onReady(inicializar);

function inicializar()
{
	Ext.QuickTips.init();
	
	if(typeof($)=='undefined')
	{
		loadScript('../../Scripts/jquery.min.js',function(){});
	}
	
    if(!$("#uploader").pluploadQueue)
	{
    	loadCSS('../../Scripts/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css',function(){});
		loadScript('../../Scripts/plupload/js/plupload.full.min.js',function()
        																	{
                                                                            	loadScript('../../Scripts/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js',function(){});
                                                                            	loadScript('../../Scripts/plupload/js/i18n/es.js',function(){});
                                                                            }
                                                                            );
		
		
    }
	
	loadScript('../Scripts/ckeditor/ckeditor.js', function()
                                          {
                                              
                                          }
          );
          
     loadScript('../Scripts/IQSec/Firma.js', function()
                                          {
                                          		firma = new fielnet.Firma({
                                                                            subDirectory: '../../Scripts/IQSec',
                                                                            ajaxAsync: false,
                                                                            controller: "https://validmobile.iqsec.mx/DemoFirma/Controlador.ashx"
                                                                            
                                                                        });    
                                          }
          );     


      
          
	

          
}

function mostrarVentanaGeneracionDocumentos(objConf)
{
	confEditor=objConf;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											tbar: 	[
														{
															icon:'../images/guardar.PNG',
															cls:'x-btn-text-icon',
															id:'btnSave',
															hidden:true,
															tooltip:'Guardar documento',
															handler:function()
																	{
																		guardarDocumento();
																	}

														},
                                                        {
															icon:'../images/page_word.png',
															cls:'x-btn-text-icon',
															id:'btnUpload',
															hidden:true,
                                                            text:'Actualizar documento',
															tooltip:'Actualizar documento',
															handler:function()
																	{
																		mostrarVentanaActualizarDocumento();
																	}

														},
														'-',
                                                        {
															icon:'../images/arrow_refresh.PNG',
															cls:'x-btn-text-icon',
															id:'btnReProcesar',
															hidden:true,
															tooltip:'Regenerar documento',
															handler:function()
																	{
																		function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	var oRespaldo={};
                                                                                for(var propiedad in confEditor)
                                                                                {
                                                                                	oRespaldo[propiedad]=confEditor[propiedad];
                                                                                    
                                                                                    
                                                                                }
                                                                                oRespaldo['reprocesar']=1;
                                                                                gEx('vCDocument').close();
                                                                                mostrarVentanaGeneracionDocumentos(oRespaldo);
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de regenerar el documento?',resp);
																	}

														},'-',
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
															hidden:true,
															tooltip:'Firmar documento',
															handler:function()
																	{
																		firmarDocumento();
																	}

														},'-',
														{
															icon:'../images/page_accept.png',
															cls:'x-btn-text-icon',
															id:'btnEval',
															menu: [],
															text:'Evaluar documento como..',
															hidden:true,
															tooltip:'Evaluar documento como..'

														},'-',
														{
															icon:'../images/user_go.png',
															cls:'x-btn-text-icon',
															id:'btnSend',
															hidden:true,
															menu: [],
															tooltip:'Enviar documento a...',
															text:'Enviar documento a...'

														},'-',
														{
															icon:'../images/icon_changelog.gif',
															cls:'x-btn-text-icon',
															id:'btnHistorial',
															tooltip:'Ver historial',	
															text:'Ver historial',
															handler:function()
																	{
                                                                    	
																		mostrarVentanaHistorialcDocumento();
																	}

														}
													],
											items: 	[
                                            			{
                                                        	x:0,
                                                            y:0,
                                                            hidden:false,
                                                            id:'hTxtDocumento',
                                                            region:'center',
                                                            html:'<textarea style="width:450px" id="txtDocumento"></textarea>'
                                                        },
                                                         new Ext.ux.IFrameComponent({ 

                                                                                        id: 'hSpVisor', 
                                                                                        anchor:'100% 100%',
                                                                                        hidden:false,
                                                                                        region:'center',
                                                                                        url: '../paginasFunciones/white.php',
                                                                                        style: 'width:100%;height:100%' 
                                                                                })
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Documento',
                                        id:'vCDocument',
										width: !objConf.ancho?800:objConf.ancho,
										height:!objConf.alto?480:objConf.alto,
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
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
    
    
    
    var editor1=	CKEDITOR.replace('txtDocumento',
                                                     {
                                                     	
                                                        customConfig:(confEditor.urlConfiguracion && (confEditor.urlConfiguracion!='')?confEditor.urlConfiguracion:urlConfiguracion),
                                                        height:(confEditor.alto?confEditor.alto:500)-185,
                                                        enterMode : CKEDITOR.ENTER_BR,
                                                        resize_enabled:false,
                                                        on:	{
                                                        		instanceReady:function(evt)
                                                                			{
                                                                            	if((confEditor.tipoDocumento)&&(confEditor.tipoDocumento!=-1)&&(confEditor.tipoDocumento!=''))
                                                                                {
                                                                                	var cadObj='';
                                                                                    
                                                                                    for(var propiedad in confEditor)
                                                                                    {
                                                                                        linea='"'+propiedad+'":"'+cv(confEditor[propiedad])+'"';
                                                                                        if(cadObj=='')
                                                                                            cadObj=linea;
                                                                                        else
                                                                                            cadObj+=','+linea;
                                                                                        
                                                                                    }
                                                                                    cadObj='{'+cadObj+'}';
                                                                                	function funcAjax()
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                        	
                                                                                        	var objDatos=eval('['+arrResp[1]+']')[0];
                                                                                           	objConfiguracionDocumento=objDatos;
                                                                                            configurarPermisos(objDatos.permisos);
                                                                                            if((objConfiguracionDocumento.idDocumentoAdjunto)&&(objConfiguracionDocumento.idDocumentoAdjunto!='-1'))
                                                                                            {
                                                                                            	if(objDatos.permisos.permiteEditar=='1')
                                                                                                {
                                                                                                	gEx('btnSave').hide();
                                                                                                    gEx('btnUpload').show();
                                                                                                    
                                                                                                    
                                                                                                }
                                                                                            	gEx('hTxtDocumento').hide();                                                                                                
                                                                                                gEx('hSpVisor').load	(
                                                                                                							{
                                                                                                                            	url:'../visoresGaleriaDocumentos/visorDocumentosWord.php',
                                                                                                                                params:	{
                                                                                                                                			iDocumento:objConfiguracionDocumento.idDocumentoAdjunto,
                                                                                                                                            cPagina:'sFrm=true'
                                                                                                                                        }
                                                                                                                            }
                                                                                                                        );
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                            	gEx('hSpVisor').hide();
                                                                                            	editor1.setData(bD(objDatos.cuerpoDocumento));
                                                                                            }
                                                                                            gE('tipoFormato').value=confEditor.tipoDocumento;
                                                                                            gE('idRegistroFormato').value=objDatos.idRegistroFormato;
                                                                                            
                                                                                            if(!gE('idFormulario'))
                                                                                            {
                                                                                            	var hFormulario=cE('input');
                                                                                            	hFormulario.id='idFormulario';
                                                                                            	hFormulario.type='hidden';
                                                                                            	document.body.appendChild(hFormulario);
                                                                                            }
                                                                                            gE('idFormulario').value=confEditor.idFormulario;
                                                                                            gE('idRegistro').value=confEditor.idRegistro;
                                                                                            gE('idReferencia').value=confEditor.idRegistro;
                                                                                            gE('sL').value=objDatos.sL;
                                                                                            
                                                                                            if(typeof(functionAfterLoadDocument)!='undefined')
																								functionAfterLoadDocument();
                                                                                            
                                                                                           if(typeof(confEditor.functionAfterLoadDocument)!='undefined')
																								confEditor.functionAfterLoadDocument();
                                                                                            
                                                                                            
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=126&tipoDocumento='+confEditor.tipoDocumento+'&cadObj='+cadObj,true);
                                                                                }
                                                                            
                                                                            
                                                                            	
                                                                            }
                                                                
                                                        	}
                                                     }
                                    );
}

function imprimirDocumento()
{
	
	if((objConfiguracionDocumento.idDocumentoAdjunto)&&(objConfiguracionDocumento.idDocumentoAdjunto!='-1'))
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
        iFrame.style='width:1px; height:1px;';
        //iFrame.style='display:none';
        document.body.appendChild(iFrame);
        asignarEvento(iFrame,'load',frameLoad);
        var arrParametros=[['id',bE('1_'+objConfiguracionDocumento.idDocumentoAdjunto)],['modoPrinter','1']];
        enviarFormularioDatos('../paginasFunciones/obtenerArchivosPDFWORD.php',arrParametros,'GET','frameEnvio');
    	return;
    }
    
    
        
        
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
            var documentoAnexos='';
            if((confEditor.documentoAdexos)&&(confEditor.documentoAdexos!=''))
            {
            	documentoAnexos=',"documentoAdexos":"'+confEditor.documentoAdexos+'"';
                
            }
            
			var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'"'+documentoAnexos+'}';
	
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
					iFrame.style='width:1px; height:1px;';
					//iFrame.style='display:none';
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
                           	
                        }, 500
                   );
        
        
    }
    else
        primeraCargaFrame=false;
    
}

function guardarDocumento(funcionEjecucion)
{
	
	var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'","tipoFormato":"'+gE('tipoFormato').value+'","cuerpoFormato":"'+
				bE(CKEDITOR.instances.txtDocumento.getData())+'","idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+
				gE('idRegistro').value+'","idReferencia":"'+gE('idReferencia').value+'","idFormularioProceso":"-1"}';
	
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
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
	if((objConfiguracionDocumento.idDocumentoAdjunto)&&(objConfiguracionDocumento.idDocumentoAdjunto!='-1'))
    {
    	
        var arrParametros=[['id',bE('1_'+objConfiguracionDocumento.idDocumentoAdjunto)],['modoPrinter','1']];
        enviarFormularioDatos('../paginasFunciones/obtenerArchivosPDFWORD.php',arrParametros,'GET','_blank');
    	return;
    }
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
			var documentoAnexos='';
            if((confEditor.documentoAdexos)&&(confEditor.documentoAdexos!=''))
            {
            	documentoAnexos=',"documentoAdexos":"'+confEditor.documentoAdexos+'"';
                
            }
            
			var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'"'+documentoAnexos+'}';
	
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

function firmarDocumento()
{
	
	var aAcciones=[];
	
	<?php
	if(isset($tipoFirmaPermitida[1]))
	{
	?>
		aAcciones.push 	(
								{
									idAccion:1,
									etiquetaAccion:'Firmar mediante FIEL',
									documentoFinal:1
								}
						)
	<?php
	}
	
	if(isset($tipoFirmaPermitida[2]))
	{
	?>
		aAcciones.push 	(
								{
									idAccion:6,
									etiquetaAccion:'Firmar mediante FIREL',
									documentoFinal:1
								}
						)
	<?php
	}
	
	if(isset($tipoFirmaPermitida[4]))
	{
	?>
		aAcciones.push 	(
								{
									idAccion:4,
									etiquetaAccion:'Firmar mediante documento',
									documentoFinal:1
								}
						)
	<?php
	}
	?>
	
	
	var oConfiguracion=	{
							arrAcciones:	aAcciones
						};
	var arrAcciones='';
	var x;
	var accion;
	var oAccion='';
	for(x=0;x<oConfiguracion.arrAcciones.length;x++)
	{
		  accion=oConfiguracion.arrAcciones[x];
		  oAccion='{"idAccion":"'+accion.idAccion+'","etiquetaAccion":"'+accion.etiquetaAccion.replace(/"/gi,"'")+'","documentoFinal":"'+accion.documentoFinal+'"}';
		  if(arrAcciones=='')
			  arrAcciones=oAccion;
		  else
			  arrAcciones+=','+oAccion;
	}
	
	var cadConf='{"idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistro').value+'","arrAcciones":['+arrAcciones+']}';
	
	
                                                                                            
	if((CKEDITOR.instances["txtDocumento"].readOnly)||((objConfiguracionDocumento.idDocumentoAdjunto)&&(objConfiguracionDocumento.idDocumentoAdjunto!='-1')))
	{
		mostrarVentanaFirmaElectronica(cadConf);
	}
	else
	{
		var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'","tipoFormato":"'+gE('tipoFormato').value+
				'","cuerpoFormato":"'+bE(CKEDITOR.instances.txtDocumento.getData())+'","idFormulario":"'+gE('idFormulario').value+
				'","idRegistro":"'+gE('idRegistro').value+'","idReferencia":"'+gE('idReferencia').value+
				'","idFormularioProceso":"'+(gE('idFormularioProceso')?gE('idFormularioProceso').value:-1)+'"}';
		
		function funcAjax()
		{
			var resp=peticion_http.responseText;
			
			arrResp=resp.split('|');
			if(arrResp[0]=='1')
			{
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
	
	var cmbAccionFirma=null;
	objConf=eval('['+(objConf)+']')[0];	
	objGlobal=objConf;	
    var arrAccionesFirma=[];
    
    var x;
    var oAccion;
    for(x=0;x<objConf.arrAcciones.length;x++)
    {
    	oAccion=objConf.arrAcciones[x];
		arrAccionesFirma.push([oAccion.idAccion,oAccion.etiquetaAccion,oAccion.documentoFinal]);
    }
    
	
					
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                                                        {
                                                        	
                                                                            x:10,
                                                                            y:20,
                                                                            cls:'SIUGJ_Etiqueta',
                                                                            html:'Acci&oacute;n a realizar:'
                                                                            
                                                                        },
                                                                        {
                                                                        	x:180,
                                                                            y:15,
                                                                            html:'<div id="divAccion"></div>'
                                                                        },
                                                                        {
                                                                            
                                                                            x:10,
                                                                            cls:'SIUGJ_Etiqueta',
                                                                            y:70,
                                                                            html:'Comentarios adicionales:'
                                                                            
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:100,
                                                                            width:760,
                                                                            height:90,
                                                                            cls:'controlSIUGJ',
                                                                            xtype:'textarea',
                                                                            id:'txtComentariosAdicionales'
                                                                        },
                                                                        {
                                                                            id:'fSetFirma',
                                                                            xtype:'fieldset',
                                                                            width:760,
                                                                            x:10,
                                                                            y:200,
                                                                            height:150,
                                                                            hidden:true,
                                                                            cls:'x-fieldsetSIUGJ',
                                                                            defaultType: 'label',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:10,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Ingrese su archivo de certificado digital (*.cer):'
                                                                                        },
                                                                                        {
                                                                                            x:415,
                                                                                            y:5,
                                                                                            html:'<input class="controlSIUGJ" style="font-size:11px !important;" type="file" id="fileCer" accept=".cer" style="width:250px">'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:50,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Ingrese su archivo de llave privada (*.key):'

                                                                                        },
                                                                                        {
                                                                                            x:415,
                                                                                            y:45,
                                                                                            html:'<input class="controlSIUGJ" style="font-size:11px !important;" type="file" id="fileKey" accept=".key" style="width:250px">'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:90,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Ingrese la contrase&ntilde;a de llave privada:'
                                                                                        },
                                                                                        {
                                                                                            x:420,
                                                                                            y:85,
                                                                                            width:200,
                                                                                            id:'txtPassword',
                                                                                            xtype:'textfield',
                                                                                            cls:'controlSIUGJ',
                                                                                            inputType:'password'
                                                                                        }   
                                                                                    ]
                                                                        },
                                                                        {
                                                                            id:'fSetFirmaFirel',
                                                                            xtype:'fieldset',
                                                                            width:760,
                                                                            x:10,
                                                                            y:200,
                                                                            height:110,
                                                                            hidden:true,
                                                                            defaultType: 'label',
                                                                            cls:'x-fieldsetSIUGJ',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                                        {
                                                                                            x:10,
                                                                                            y:10,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Ingrese su archivo de llave privada (*.pfx):'
                                                                                        },
                                                                                        {
                                                                                            x:415,
                                                                                            y:5,
                                                                                            html:'<input class="controlSIUGJ" style="font-size:11px !important;" type="file" id="filePFX" accept=".pfx" style="width:250px">'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:50,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Ingrese la contrase&ntilde;a de llave privada:'
                                                                                        },
                                                                                        {
                                                                                            x:420,
                                                                                            y:45,
                                                                                            cls:'controlSIUGJ',
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
                                                                            width:760,
                                                                            x:10,
                                                                            y:200,
                                                                            height:100,
                                                                            defaultType: 'label',
                                                                            cls:'x-fieldsetSIUGJ',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                                        {
                                                                                            x:10,
                                                                                            y:30,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Ingrese su documento de firma:'
                                                                                        },
                                                                                        {
                                                                                            x:300,
                                                                                            y:25,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                                                        },
                                                                                        {
                                                                                            x:300,
                                                                                            y:55,
                                                                                            hidden:true,
                                                                                            html:	'<div id="containerUploader"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:595,
                                                                                            y:20,
                                                                                            width:140,
                                                                                            icon:'../images/add.png',
                                                                                            cls:'btnSIUGJCancel',
                                                                                            id:'btnUploadFile',
                                                                                            xtype:'button',
                                                                                            text:'Seleccionar',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        $('#containerUploader').click();
                                                                                                    }
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
                                        closable:false,
										width: 800,
										height:340,
                                        cls:'msgHistorialSIUGJ',
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
                                                                	firma.readCertificate('fileCer');
														           	firma.readPrivateKey('fileKey');
                                                                    firma.readPfx('filePFX');
																	gEx('txtPassword').focus(false,500);																
																	
                                                                    var oConf={
                                                                    // Backend settings
                                                                                            upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                            file_post_name: "archivoEnvio",
                                                                             
                                                                                            // Flash file settings
                                                                                            file_size_limit : "1000 MB",
                                                                                            file_types : "*.pdf; *.jpg; *.gif; *.png; *.jpeg",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                            file_types_description : "Todos los archivos",
                                                                                            file_upload_limit : 0,
                                                                                            file_queue_limit : 1,
                                                                             
                                                                                           
                                                                                            upload_success_handler : subidaCorrectaFinal,
                                                                                            
                                                                                        };
																	crearControlUploadHTML5(oConf);
                                                                    cmbAccionFirma=crearComboExt('cmbAccionFirma',arrAccionesFirma,0,0,400,{renderTo:'divAccion',ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl'});
                                                                	cmbAccionFirma.on('select',function(cmb,registro)
                                                                                                {
                                                                                                    firmaFinal=false;
                                                                
                                                                                                    if(registro.data.valorComp=='1')
                                                                                                        firmaFinal=true;
                                                                                                    
                                                                                                    
                                                                                                    gEx('fSetFirma').hide();
                                                                                                    gEx('fSetFirmaDocumento').hide();
                                                                                                    gEx('fSetFirmaFirel').hide();
                                                                                                    
                                                                                                    
                                                                                                    switch(registro.data.id)
                                                                                                    {
                                                                                                        case '1':                                        	
                                                                                                            gEx('fSetFirmaDocumento').hide();
                                                                                                            gEx('fSetFirmaFirel').hide();
                                                                                                            gEx('fSetFirma').show();
                                                                                                            gEx('vDocumento').setHeight(480);
                                                                                                        break;
                                                                                                        case '6':                                        	
                                                                                                            gEx('fSetFirmaDocumento').hide();
                                                                                                            gEx('fSetFirmaFirel').show();
                                                                                                            gEx('fSetFirma').hide();
                                                                                                            gEx('vDocumento').setHeight(440);
                                                                                                            
                                                                                                        break;
                                                                                                        break;
                                                                                                        case '4':
                                                                                                            gEx('fSetFirma').hide();
                                                                                                            gEx('fSetFirmaFirel').hide();
                                                                                                            gEx('fSetFirmaDocumento').show();
                                                                                                            gEx('vDocumento').setHeight(440);
                                                                                                            
                                                                                                        break;
                                                                                                        default:
                                                                                                            gEx('vDocumento').setHeight(340);
                                                                                                            
                                                                                                        break;
                                                                                                    }
                                                                                                    
                                                                                                    gEx('vDocumento').center();
                                                                                                }
                                                                                    )
																	
																}
															}
												},
										buttons:	[
														{
															text: 'Cancelar',
                                                            width:140,
                                                            cls:'btnSIUGJCancel',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: 'Aceptar',   
                                                            width:140,
                                                            cls:'btnSIUGJ',                                                         
															handler: function()
																	{
                                                                    	if(cmbAccionFirma.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbAccionFirma.focus();
                                                                            }
                                                                            msgBox('Debe indicar el medio de firma a realizar',resp);
                                                                            return;
                                                                        }
                                                                        
																		var objResultado={};
                                                                        objResultado.accion=cmbAccionFirma.getValue();
                                                                        objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
                                                                        objResultado.cadenaFirma='';
                                                                        
																		var pos=obtenerPosFila(gEx('cmbAccionFirma').getStore(),'id',objResultado.accion);
                                                                        var documentoFinal=gEx('cmbAccionFirma').getStore().getAt(pos).data.valorComp;
																		var compDocumentos='';
                                                                        if((confEditor.documentoAdexos)&&(confEditor.documentoAdexos!=''))
            	                                                           	compDocumentos=',"documentosAnexos":"'+confEditor.documentoAdexos+'"';
																		
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
                                                                                
                                                                                validateParDeLlaves	(
                                                                                						function()
                                                                                                        {
                                                                                                        	objResultado.cadenaFirma=''
                                                                                                            var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+gE('idRegistroFormato').value+
                                                                                                                    '","cadena":"'+objResultado.cadenaFirma+'","etapaEnvioFirma":"'+objConfiguracionDocumento.permisos.confFirma.etapaEnvioFirma+
                                                                                                                    '","rolDestinatarioEnvioFirma":"'+objConfiguracionDocumento.permisos.confFirma.rolDestinatarioEnvioFirma+
                                                                                                                    '","usuarioDestino":"'+objConfiguracionDocumento.permisos.confFirma.usuarioDestino+'","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+
                                                                                                                    '","rolActual":"'+objConfiguracionDocumento.permisos.permisosRol+'","tipoFirma":"1"'+compDocumentos+'}';															
                                                                                                            
                                                                                                            var oObj=eval('['+cadObj+']')[0];
                                                                                                            
                                                                                                            
                                                                                                            var formData = new FormData();
                                                                                                            
                                                                                                           
                                                                                                            
                                                                                                            
                                                                                                            for(var campo in oObj)
                                                                                                            {
                                                                                                                
                                                                                                                formData.append(campo,oObj[campo]);
                                                                                                                
                                                                                                                
                                                                                                                
                                                                                                            }
                                                                                                            
                                                                                                            
                                                                                                            
                                                                                                            mostrarMensajeProcesando('Firmando documento, &eacute;sta operaci&oacute;n puede tardar unos minutos...');
                                                                                                            $.ajax	({
                                                                                                                        url: "../modulosEspeciales_SGJ/paginasFunciones/procesarDocumentoFirmaElectronicaIQSEC_1.php",
                                                                                                                        data: formData,
                                                                                                                        processData: false,
                                                                                                                        contentType: false,
                                                                                                                        type: 'POST',
                                                                                                                        success: function(data)
                                                                                                                                {
                                                                                                                                    ocultarMensajeProcesando();
                                                                                                                                    var oResp=eval('['+data+']')[0];
                                                                                                                                    
                                                                                                                                    
                                                                                                                                    firma.signFileDigest(fielnet.Digest.Source.USER,oResp.sha256,fielnet.Format.B64,fielnet.Digest.SHA2,null,
                                                                                                                                                            function(e)
                                                                                                                                                            {
                                                                                                                                                                if(e.state=='0')
                                                                                                                                                                {
                                                                                                                                                                    cadObj='{"archivoDestino":"'+oResp.archivoDestino+'","transfer":"'+e.transfer+'","objOriginal":'+cadObj+'}';
                                                                                                                                                                    function funcAjax()
                                                                                                                                                                    {
                                                                                                                                                                        var resp=peticion_http.responseText;
                                                                                                                                                                        
                                                                                                                                                                        var oResp=eval('['+resp+']')[0];
                                                                                                                                                                        if(oResp.resultado=='1')
                                                                                                                                                                        {
                                                                                                                                                                            if(typeof(functionAfterSignDocument)!='undefined')
                                                                                                                                                                                functionAfterSignDocument();
                                                                                                                                                                            if(typeof(confEditor.functionAfterSignDocument)!='undefined')
                                                                                                                                                                                confEditor.functionAfterSignDocument();
                                                                                                                                                                            ventanaAM.close();
                                                                                                                                                                            gEx('vCDocument').close();
                                                                                                                                                                        }
                                                                                                                                                                        else
                                                                                                                                                                        {
                                                                                                                                                                            msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:<br><br>'+bD(oResp.mensaje));
                                                                                                                                                                        }
                                                                                                                                                                        
                                                                                                                                                                        
                                                                                                                                                                    }
                                                                                                                                                                    obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/procesarDocumentoFirmaElectronicaIQSEC_2.php',funcAjax, 'POST','cadObj='+cadObj,true);

                                                                                                                                                                    
                                                                                                                                                                    
                                                                                                                                                                    
                                                                                                                                                                }
                                                                                                                                                                else
                                                                                                                                                                {
                                                                                                                                                                    msgBox(e.description);
                                                                                                                                                                }
                        
                                                                                                                                                            }
                                                                                                                                    
                                                                                                                                    					)
                                                                                                                                    

                                                                                                                                    
                                                                                                                                }
                                                                                                                    });
                                                                                                        } 
                                                                                					)
                                                                                																				
																			break;
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
																				
                                                                                
                                                                                
                                                                                validateUnicaLlaves	(
                                                                                						function()
                                                                                                        {
                                                                                                        	objResultado.cadenaFirma=''
                                                                                                            var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+gE('idRegistroFormato').value+
                                                                                                                    '","cadena":"'+objResultado.cadenaFirma+'","etapaEnvioFirma":"'+objConfiguracionDocumento.permisos.confFirma.etapaEnvioFirma+
                                                                                                                    '","rolDestinatarioEnvioFirma":"'+objConfiguracionDocumento.permisos.confFirma.rolDestinatarioEnvioFirma+
                                                                                                                    '","usuarioDestino":"'+objConfiguracionDocumento.permisos.confFirma.usuarioDestino+'","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+
                                                                                                                    '","rolActual":"'+objConfiguracionDocumento.permisos.permisosRol+'","tipoFirma":"2"'+compDocumentos+'}';															
                                                                                                            
                                                                                                            var oObj=eval('['+cadObj+']')[0];
                                                                                                            
                                                                                                            
                                                                                                            var formData = new FormData();
                                                                                                            
                                                                                                           
                                                                                                            
                                                                                                            
                                                                                                            for(var campo in oObj)
                                                                                                            {
                                                                                                                
                                                                                                                formData.append(campo,oObj[campo]);
                                                                                                                
                                                                                                                
                                                                                                                
                                                                                                            }
                                                                                                            
                                                                                                            
                                                                                                            
                                                                                                            mostrarMensajeProcesando('Firmando documento, &eacute;sta operaci&oacute;n puede tardar unos minutos...');
                                                                                                            $.ajax	({
                                                                                                                        url: "../modulosEspeciales_SGJ/paginasFunciones/procesarDocumentoFirmaElectronicaIQSEC_1.php",
                                                                                                                        data: formData,
                                                                                                                        processData: false,
                                                                                                                        contentType: false,
                                                                                                                        type: 'POST',
                                                                                                                        success: function(data)
                                                                                                                                {
                                                                                                                                    ocultarMensajeProcesando();
                                                                                                                                    var oResp=eval('['+data+']')[0];
                                                                                                                                    
                                                                                                                                    
                                                                                                                                    firma.signFileDigest(fielnet.Digest.Source.USER,oResp.sha256,fielnet.Format.B64,fielnet.Digest.SHA2,null,
                                                                                                                                                            function(e)
                                                                                                                                                            {
                                                                                                                                                                if(e.state=='0')
                                                                                                                                                                {
                                                                                                                                                                    cadObj='{"archivoDestino":"'+oResp.archivoDestino+'","transfer":"'+e.transfer+'","objOriginal":'+cadObj+'}';
                                                                                                                                                                    function funcAjax()
                                                                                                                                                                    {
                                                                                                                                                                        var resp=peticion_http.responseText;
                                                                                                                                                                        
                                                                                                                                                                        var oResp=eval('['+resp+']')[0];
                                                                                                                                                                        if(oResp.resultado=='1')
                                                                                                                                                                        {
                                                                                                                                                                            if(typeof(functionAfterSignDocument)!='undefined')
                                                                                                                                                                                functionAfterSignDocument();
                                                                                                                                                                            if(typeof(confEditor.functionAfterSignDocument)!='undefined')
                                                                                                                                                                                confEditor.functionAfterSignDocument();
                                                                                                                                                                            ventanaAM.close();
                                                                                                                                                                            gEx('vCDocument').close();
                                                                                                                                                                        }
                                                                                                                                                                        else
                                                                                                                                                                        {
                                                                                                                                                                            msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:<br><br>'+bD(oResp.mensaje));
                                                                                                                                                                        }
                                                                                                                                                                        
                                                                                                                                                                        
                                                                                                                                                                    }
                                                                                                                                                                    obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/procesarDocumentoFirmaElectronicaIQSEC_2.php',funcAjax, 'POST','cadObj='+cadObj,true);

                                                                                                                                                                    
                                                                                                                                                                    
                                                                                                                                                                    
                                                                                                                                                                }
                                                                                                                                                                else
                                                                                                                                                                {
                                                                                                                                                                    msgBox(e.description);
                                                                                                                                                                }
                        
                                                                                                                                                            }
                                                                                                                                    
                                                                                                                                    					)
                                                                                                                                    

                                                                                                                                    
                                                                                                                                }
                                                                                                                    });
                                                                                                        } 
                                                                                					)
                                                                                
                                                                                
                                                                               
																				
																			break
																			case 4:
																				if(uploadControl.files.length==0)
                                                                                {
                                                                                    msgBox('Debe ingresar el documento que desea adjuntar');
                                                                                    return;
                                                                                }
                                                                                uploadControl.start();
																			break;
																		}
																		
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
			
			var cadObj='{"documentoFinal":"'+gEx('cmbAccionFirma').getStore().getAt(pos).data.valorComp+'","idRegistroFormato":"'+gE('idRegistroFormato').value+'","idArchivo":"'+arrDatos[1]+'","cadena":"'+arrDatos[2]+
						'","etapaEnvioFirma":"'+objConfiguracionDocumento.permisos.confFirma.etapaEnvioFirma+'","rolDestinatarioEnvioFirma":"'+
						objConfiguracionDocumento.permisos.confFirma.rolDestinatarioEnvioFirma+'","rolActual":"'+
						objConfiguracionDocumento.permisos.permisosRol+
						'","usuarioDestino":"'+objConfiguracionDocumento.permisos.confFirma.usuarioDestino+
						'","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';

			function funcAjax2()
			{
				var resp=peticion_http.responseText;
				var oResp=eval('['+resp+']')[0];
				if(oResp.resultado=='1')
					
				{
					
					if(typeof(functionAfterSignDocument)!='undefined')
						functionAfterSignDocument();
					if(typeof(confEditor.functionAfterSignDocument)!='undefined')
						confEditor.functionAfterSignDocument();
				}
				else
				{
					
					msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+bD(oResp.mensaje));
				}
			}
			obtenerDatosWeb('../paginasFunciones/procesarDocumentoFirmaElectronica.php',funcAjax2, 'POST','cadObj='+cadObj,true);
			
			gEx('vDocumento').close();
           	gEx('vCDocument').close();
            
		}
		
	
}

function configurarPermisos(permisos)
{
	
	var btnTurno;
	gEx('btnSave').hide();	
    gEx('btnReProcesar').hide();
	gEx('btnSing').hide();
	gEx('btnEval').hide();
	gEx('btnSend').hide();
	//gEx('btnSend').menu.removeAll();
	var arrMenuEnvio=[];
	var x;
    
    if(permisos.permiteReprocesar=='1')
    	gEx('btnReProcesar').show();
        
	if(permisos.permiteEditar=='1')
    {
		gEx('btnSave').show();
        
    }
	else
	{
		CKEDITOR.instances.txtDocumento.setReadOnly(true);
	}
	if(permisos.permiteFirmar=='1')
		gEx('btnSing').show();
	if((permisos.permiteEvaluar=='1')&&(permisos.confEvaluacion.arrOpciones.length>0))
	{
		gEx('btnEval').show();
		for(x=0;x<permisos.confEvaluacion.arrOpciones.length;x++)
		{
			btnTurno={
						
						text:permisos.confEvaluacion.arrOpciones[x].leyenda,
						handler:function(btn)
								{
									evaluarDocumento(btn);
								}
					}

					
									
			
			btnTurno.etapaEnvio=permisos.confEvaluacion.arrOpciones[x].etapaEnvio;
			btnTurno.rolDestinatario=permisos.confEvaluacion.arrOpciones[x].rolDestinatario;
			btnTurno.usuarioDestino=permisos.confEvaluacion.arrOpciones[x].usuarioDestino;
			btnTurno.IDEvaluacion=permisos.confEvaluacion.arrOpciones[x].IDEvaluacion;
			btnTurno.leyenda=permisos.confEvaluacion.arrOpciones[x].leyenda;
			
			gEx('btnEval').menu.add(btnTurno);
			
		}
		
		gEx('btnEval').menu.doLayout();
		
	}
	
	if((permisos.permiteTurnar=='1')&&(permisos.confTurno.arrOpciones.length>0))
	{
		gEx('btnSend').show();	
		var cTurno;
		for(x=0;x<permisos.confTurno.arrOpciones.length;x++)
		{
        	cTurno=permisos.confTurno.arrOpciones[x];
            if(!cTurno.hijos)
            {
                btnTurno={
                            icon:'../images/user_gray.png',
                            text:permisos.confTurno.arrOpciones[x].lblRol,
                            handler:function(btn)
                                    {
                                        turnarDocumento(btn);
                                    }
                        }
    
                        
                                        
                
                btnTurno.etapaEnvio=permisos.confTurno.arrOpciones[x].etapaEnvio;
                btnTurno.rolDestinatario=permisos.confTurno.arrOpciones[x].rolDestinatario;
                btnTurno.usuarioDestino=permisos.confTurno.arrOpciones[x].usuarioDestino;
                btnTurno.lblRol=permisos.confTurno.arrOpciones[x].lblRol;
			}
            else
            {
            	var arregloBotones=[];
                var aBtn=0;
                var btnAux='';
                var oBtn;
                for(aBtn=0;aBtn<cTurno.hijos.length;aBtn++)
                {
                	oBtn=cTurno.hijos[aBtn];
                	btnAux={
                                
                                text:oBtn.lblRol,
                                handler:function(btn)
                                        {
                                            turnarDocumento(btn);
                                        }
                            }
        			btnAux.etapaEnvio=oBtn.etapaEnvio;
                    btnAux.rolDestinatario=oBtn.rolDestinatario;
                    btnAux.usuarioDestino=oBtn.usuarioDestino;
                    btnAux.lblRol=oBtn.lblRol;
                	arregloBotones.push(btnAux);
                }
            	btnTurno={
                            icon:'../images/user_gray.png',
                            text:permisos.confTurno.arrOpciones[x].lblRol,
                            menu:	arregloBotones
                        }
            }
			gEx('btnSend').menu.add(btnTurno);
			
		}
		
		gEx('btnSend').menu.doLayout();
	}
}

function turnarDocumento(btnPresionado)
{

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                            				x:10,
                                            				y:10,
                                            				html:'Comentarios adicionales:'
                                            			},
                                            			{
                                            				x:10,
                                            				y:40,
                                            				id:'txtComentariosAdicionales',
                                            				xtype:'textarea',
                                            				width:600,
                                            				height:80,
                                            				
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Turnar documento a '+btnPresionado.lblRol,
										width: 650,
										height:220,
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
																	gEx('txtComentariosAdicionales').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		function resp(btn)
																		{
																			if(btn=='yes')
																			{
																				guardarDocumento	(
																										function()
																										{
																											var cadObj='{"idDocumento":"'+gE('idRegistroFormato').value+'","actor":"'+btnPresionado.rolDestinatario+'","etapaCambio":"'+btnPresionado.etapaEnvio+
																											'","comentarios":"'+cv(gEx('txtComentariosAdicionales').getValue())+'","rolActual":"'+objConfiguracionDocumento.permisos.permisosRol+
																											'","usuarioDestino":"'+btnPresionado.usuarioDestino+'"}';
																										
																											function funcAjax()
																											{
																												var resp=peticion_http.responseText;
																												arrResp=resp.split('|');
																												if(arrResp[0]=='1')
																												{
																													ventanaAM.close();
																													gEx('vCDocument').close();
																													if(typeof(confEditor.functionAfterTurn)!='undefined')
																														confEditor.functionAfterTurn();
																												}
																												else
																												{
																													msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																												}
																											}
																											obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=150&cadObj='+cadObj,true);
																										
																										}
																									)
																				
																			}
																		}
																		msgConfirm('Est&aacute; seguro de querer turnar el documento a '+btnPresionado.lblRol,resp);
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

function evaluarDocumento(btnPresionado)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                            				x:10,
                                            				y:10,
                                            				html:'Comentarios adicionales:'
                                            			},
                                            			{
                                            				x:10,
                                            				y:40,
                                            				id:'txtComentariosAdicionales',
                                            				xtype:'textarea',
                                            				width:600,
                                            				height:80,
                                            				
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Evaluar documento como '+btnPresionado.leyenda,
										width: 650,
										height:220,
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
																	gEx('txtComentariosAdicionales').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		function resp(btn)
																		{
																			if(btn=='yes')
																			{
																				guardarDocumento	(
																										function()
																										{
																											var cadObj='{"idDocumento":"'+gE('idRegistroFormato').value+'","actor":"'+btnPresionado.rolDestinatario+'","etapaCambio":"'+
																											btnPresionado.etapaEnvio+'","comentarios":"'+cv(gEx('txtComentariosAdicionales').getValue())+'","rolActual":"'+
																											objConfiguracionDocumento.permisos.permisosRol+'","resultadoEvaluacion":"'+btnPresionado.IDEvaluacion+
																											'","usuarioDestino":"'+btnPresionado.usuarioDestino+'"}';
																										
																											function funcAjax()
																											{
																												var resp=peticion_http.responseText;
																												arrResp=resp.split('|');
																												if(arrResp[0]=='1')
																												{
																													ventanaAM.close();
																													gEx('vCDocument').close();
																													if(typeof(confEditor.functionAfterValidate)!='undefined')
																														confEditor.functionAfterValidate();
																												}
																												else
																												{
																													msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																												}
																											}
																											obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=150&cadObj='+cadObj,true);
																										
																										}
																									)
																				
																			}
																		}
																		msgConfirm('Est&aacute; seguro de querer evaluar el documento como '+btnPresionado.leyenda,resp);
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

function mostrarVentanaHistorialcDocumento()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            frame:false,
											defaultType: 'label',
											items: 	[
														crearGridHistorialcDocumento()

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial del documento',
										width: 900,
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

function crearGridHistorialcDocumento()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'etapaOriginal'},
		                                                {name:'etapaCambio'},
		                                                {name:'responsable'},
                                                        {name: 'comentarios'}
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
                                                            sortInfo: {field: 'fechaOperacion', direction: 'DESC'},
                                                            groupField: 'fechaOperacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='151';
                                        proxy.baseParams.iD=gE('idRegistroFormato').value;
                                       
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val,metadata )
                                                                		{
                                                                        	metadata.attr='style="height:auto !important;"';
                                                                        	return formatoTitulocDocumento(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>('+val.format('H:i:s')+' hrs.)');
                                                                        }
                                                            },
                                                            {
                                                                header:'Etapa original',
                                                                width:200,
                                                                sortable:true,
                                                                renderer:formatoTitulocDocumento,
                                                                dataIndex:'etapaOriginal'
                                                            },
                                                            {
                                                                header:'Etapa cambio',
                                                                width:200,
                                                                sortable:true,
                                                                renderer:formatoTitulocDocumento,
                                                                dataIndex:'etapaCambio'
                                                            },                                                            
                                                            {
                                                                header:'Responsable',
                                                                width:500,
                                                                sortable:true,
                                                                 renderer:formatoTitulocDocumento,
                                                                dataIndex:'responsable'
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorial',
                                                        store:alDatos,
                                                        region:'center',
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,
                                                                                                                        
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorialcDocumento
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	
}

function formatearFilaHistorialcDocumento(record, rowIndex, p, ds)
{
	var xf = Ext.util.Format;
    p.body = '<BR><p style="margin-left: 4em;margin-right: 4em;text-align:justify"><br><span class="menu"><span style="color: #001C02">Comentarios:</span><br><br><span style="color: #3B3C3B">' + ((record.data.comentarios.trim()=="")?"(Sin comentarios)":record.data.comentarios) + '</span></p><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTitulocDocumento(val)
{
	return '<span style="font-size:11px; color:#040033">'+val+'</span>';
}

function mostrarVentanaActualizarDocumento()
{
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                            			
                                                            x:10,
                                                            y:20,
                                                            html:'Ingrese documento a adjuntar:'
                                                        },
                                                        {
                                                            x:185,
                                                            y:45,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        {
                                                            x:185,
                                                            y:15,
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                        {
                                                            x:480,
                                                            y:16,
                                                            id:'btnUploadFile',
                                                            xtype:'button',
                                                            text:'Seleccionar...',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
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
                                                        },
                                                        {
                                                        
                                                            x:10,
                                                            y:50,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                            x:10,
                                                            y:80,
                                                            width:550,
                                                            height:80,
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales'
                                                        }
                                            			
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Actualizar documento',
										width: 600,
										height:250,
										layout: 'fit',
										plain:true,
                                        id:'wActualizarDocument',
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var oConf=
                                                                	 {

                                                                      upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                      file_post_name: "archivoEnvio",
                                                       
                                                                      // Flash file settings
                                                                      file_size_limit : "1000 MB",
                                                                      file_types : "*.doc;*.docx",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                      file_types_description : "Todos los archivos",
                                                                      file_upload_limit : 0,
                                                                      file_queue_limit : 1,                                                       
                                                                     
                                                                      upload_success_handler : subidaCorrectaWordDocument
                                                                                                
                                                                      };  
																
                                                                	crearControlUploadHTML5(oConf);
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

function subidaCorrectaWordDocument(file, serverData) 
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
        	
			gEx("idArchivo").setValue(arrDatos[1]);
            gEx("nombreArchivo").setValue(arrDatos[2]);
            
            if(gE('txtFileName'))
	            gE('txtFileName').value=arrDatos[2];
            
            
			cadObj='{"comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'","idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+'","idRegistroDocumento":"'+gE('idRegistroFormato').value+'"}';
            
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                	gEx('wActualizarDocument').close(); 
                    gEx('hSpVisor').load	(
                                                {
                                                    url:'../visoresGaleriaDocumentos/visorDocumentosWord.php',
                                                    params:	{
                                                                iDocumento:objConfiguracionDocumento.idDocumentoAdjunto,
                                                                cPagina:'sFrm=true'
                                                            }
                                                }
                                            );
					                                           
                    
                    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=170&cadObj='+cadObj,true);
            
			
            
		}
		
	} 
    catch (e) 
	{
		alert(e);
	}
}

function validateParDeLlaves(afterValidate) 
{
           var strPassword = gEx('txtPassword').getValue();
           
            
            firma.validateKeyPairs(strPassword, function (data) {

                                                                    if (data.state == 0) 
                                                                    {
                                                                       if(afterValidate)
                                                                       		afterValidate();
                                                    
                                                                    }
                                                                    else 
                                                                    {
                                                                        msgBox(data.description);
                                                                        return false;
                                                                    }
                                                                }
                                                               );
}


function validateUnicaLlaves(afterValidate) 
{
           var strPassword = gEx('txtPasswordFirel').getValue();
           
            
            firma.openPfx(strPassword, function (data) {

                                                                    if (data.state == 0) 
                                                                    {
                                                                       if(afterValidate)
                                                                       		afterValidate();
                                                    
                                                                    }
                                                                    else 
                                                                    {
                                                                        msgBox(data.description);
                                                                        return false;
                                                                    }
                                                                }
                                                               );
}