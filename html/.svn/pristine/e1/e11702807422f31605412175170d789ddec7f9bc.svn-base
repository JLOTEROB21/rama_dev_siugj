<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__44_tablaDinamica,CONCAT(IF(claveTipoMarcador='','',CONCAT('[',claveTipoMarcador,'] ')),nombreMarcador) AS marcador,descripcion 
				FROM _44_tablaDinamica WHERE situacion=1";
	$arrTiposMarcadores=$con->obtenerFilasArreglo($consulta);
?>
var uploadControl;
var objGlobal;
var objConfiguracionFirmaElectronica=window.parent.gEx('btnCertificacionProceso').oConfiguracion;
var confEditor=null;
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
	
	
	
    var urlConfiguracion='../../modulosEspeciales_SGJP/Scripts/configCKEditorSeleccionFormato.js';
    if(gE('permiteEdicionTextoEnriquecido').value=='0')
	{
		urlConfiguracion='../../modulosEspeciales_SGJP/Scripts/configCKEditorEjecucionSLV2.js';
	}
    var oVisor;
    
    
    if((gE('idDocumentoAdjunto').value=='-1')&&((gE('permiteSeleccionPlantilla').value=='1')&&(gE('permiteEdicionTextoEnriquecido').value=='1')))
    {
    	
    	oVisor=	{
                    region:'center',
                    html:'<br /><table width="100%"><tr><td align="center"><textarea style="width:450px" id="txtDocumento">'+
                            '</textarea></td></tr></table>'
                }
    }
    else
    {
    	
       oVisor=new Ext.ux.IFrameComponent({ 
        
                                                id: 'hSpVisor', 
                                                anchor:'100% 100%',
                                                hidden:false,
                                                region:'center',
                                                url: '../paginasFunciones/white.php',
                                                style: 'width:100%;height:100%' 
                                        })
    }
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
                                                                hidden:(gE('idDocumentoAdjunto').value!='-1'),
                                                                disabled:(gE('idRegistroFormato').value=='-1'),
                                                                text:'Guardar documento',
                                                                tooltip:'Guardar documento',
                                                                handler:function()
                                                                        {
                                                                            guardarDocumento(function(){refrescarMenuDTD()});
                                                                        }
    
                                                            },
                                                            '-',
                                                            {
                                                                icon:'../imagenesDocumentos/16/file_extension_pdf.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnDownload',
                                                                hidden:(gE('idDocumentoAdjunto').value!='-1'),
                                                                disabled:(gE('idRegistroFormato').value=='-1'),
                                                                text:'Descargar documento',
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
                                                                disabled:(gE('idRegistroFormato').value=='-1'),
                                                                text:'Imprimir documento',
                                                                tooltip:'Imprimir documento',
                                                                handler:function()
                                                                        {
                                                                            imprimirDocumento();
                                                                        }
    
                                                            },'-',
                                                            {
                                                                icon:'../images/page_white_stack.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnGalery',
                                                                hidden:(gE('idDocumentoAdjunto').value!='-1')&&(gE('permiteSeleccionPlantilla').value=='1'),
                                                                text:'Galeria de plantillas',
                                                                tooltip:'Galeria de plantillas',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaAddDocumento();
                                                                        }
    
                                                            },'-',
                                                            {
                                                                icon:'../images/page_word.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnWord',
                                                                hidden:(gE('idDocumentoAdjunto').value!='-1'),
                                                                text:'Adjuntar documento',
                                                                tooltip:'Adjuntar documento',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaDatosDocumento();
                                                                        }
    
                                                            },'-',
                                                            
                                                            {
                                                                icon:'../images/page_word.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnUpload',
                                                               	hidden:((gE('idDocumentoAdjunto').value=='-1')||(gE('sL').value=='2')),
                                                                text:'Actualizar documento',
                                                                tooltip:'Actualizar documento',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaActualizarDocumento();
                                                                        }
    
                                                           },'-',
                                                           {
                                                                icon:'../images/firma.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnSign',
                                                               	hidden:true,
                                                                text:'',
                                                                handler:function()
                                                                        {
                                                                            firmarDocumentoExec();
                                                                        }
    
                                                           },'-',
                                                           {
                                                                icon:'../images/icon_changelog.gif',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnHistorialDoc',
                                                                hidden:true,
                                                                tooltip:'Ver historial documento',
                                                                text:'Ver historial documento',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaHistorial();
                                                                        }
    
                                                            }
                                                		],
                                                items:	[
                                                            oVisor
                                                        ]
                                            }
                                         ]
                            }
                        )
    
    if(gE('idDocumentoAdjunto').value=='-1')
    {
        editor1=	CKEDITOR.replace('txtDocumento',
                                                         {
                                                            
                                                            customConfig:((gE('sL').value=='1')||(gE('sL').value=='2'))?urlConfiguracionSL:urlConfiguracion,
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
    
        if((gE('sL').value=='1')||(gE('sL').value=='2'))
            editor1.setReadOnly(true);
	}
    else
    {
    	gEx('hSpVisor').load	(
                                    {
                                        url:'../visoresGaleriaDocumentos/visorDocumentosWord.php',
                                        params:	{
                                                    iDocumento:gE('idDocumentoAdjunto').value,
                                                    cPagina:'sFrm=true'
                                                }
                                    }
                                );
    }
    
    if(objConfiguracionFirmaElectronica)
    {
    	gEx('btnSign').setText(objConfiguracionFirmaElectronica.etiqueta);
    	gEx('btnSign').show();
        
    }
}

function refrescarMenuDTD()
{
	window.parent.mostrarMenuDTD();
}

function imprimirDocumento()
{


	if(gE('idDocumentoAdjunto').value!='-1')
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
        var arrParametros=[['id',bE('1_'+gE('idDocumentoAdjunto').value)],['modoPrinter','1']];
        enviarFormularioDatos('../paginasFunciones/obtenerArchivosPDFWORD.php',arrParametros,'GET','frameEnvio');
    	return;
    }

    guardarDocumento(
    					function()
                        {
                        	var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'"}';
	
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
    				);
    
	
	
	
	
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
				bE(CKEDITOR.instances.txtDocumento.getData())+'","idFormulario":"-2","idRegistro":"'+gE('idInformacionDocumento').value+
                '","idReferencia":"'+gE('idInformacionDocumento').value+'","idFormularioProceso":"'+gE('idFormularioProceso').value+'"}';
	
	function funcAjax4(peticion_http)
	{
		var resp=peticion_http.responseText;
		
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			gE('idRegistroFormato').value=arrResp[1];
			
			if(confEditor && typeof(confEditor.functionAfterSaveDocument)!='undefined')
				confEditor.functionAfterSaveDocument();
			if(typeof(funcionEjecucion)!='undefined')
				funcionEjecucion();
			
		}
		else
		{
			
			msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
		}
	}
	obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax4, 'POST','funcion=1&cadObj='+bE(cadObj),true);
	
	
}

function guardarDocumentoPDF()
{
	guardarDocumento(
    					function()
                        {
                        	var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'"}';
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
    				);
	
	
	
	
	
}

function mostrarVentanaAddDocumento()
{
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearArbolPlantillas(),
                                            			{
                                            				xtype:'panel',
                                            				region:'center',
                                            				layout:'absolute',
                                            				items: 	[
                                           								{
                                           									x:0,
                                           									y:0,
                                           									xtype:'label',
																			html:'<textarea id="txtDocumentoDemo"></textarea>'
                                           								}
                                            						]
                                            			}                               			
                                            			
                                            			
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear documento',
                                        id:'wCreateDocumentDocument',
										width: 950,
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
																	var editor1=	CKEDITOR.replace('txtDocumentoDemo',
																										 {

																											customConfig:'../../modulosEspeciales_SGJP/Scripts/configCKEditorEjecucionSLV2.js',
																											width:700,
																											height:350,
																											resize_enabled:false,
																											on:	{
																													instanceReady:function(evt)
																																{
																																	


																																}

																												}
																										 }
																						);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(!nodoPlantillaSel)
																		{
																			msgBox('Debe seleccionar la plantilla a utilizar para generar el documento');
																			return;
																		}
																		ventanaAM.close();
                                                                        
                                                                        
                                                                        var cadObj='{"idGeneracionDocumento":"'+gE('idInformacionDocumento').value+'","tipoDocumento":"'+nodoPlantillaSel.id+'","tituloDocumento":"'+cv(nodoPlantillaSel.text)+
                                                                                        '","perfilValidacion":"'+nodoPlantillaSel.attributes.perfilValidacion+'","fechaLimite":"","modificaSituacionCarpeta":"0","situacion":"'+
                                                                                        '","descripcionActuacion":"","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'","idFormulario":"'+gE('idFormulario').value+
                                                                                        '","idRegistro":"'+gE('idRegistro').value+'","arrAlertas":[],"idFormularioProceso":"'+gE('idFormularioProceso').value+
                                                                                        '","categoriaDocumento":"'+gE('categoriaDocumento').value+'"}';
                                                                            
                                                                            
                                                                            
                                                                            
                                                                        function funcAjax(peticion_http)
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gE('idInformacionDocumento').value=arrResp[1];
                                                                                confEditor={
                                                                                                    tipoDocumento:nodoPlantillaSel.id,
                                                                                                    idFormulario:-2,
                                                                                                    idRegistro: arrResp[1],
                                                                                                    reprocesar:1,
                                                                                                    idRegistroFormato:gE('idRegistroFormato').value
        
                                                                                                 };
                                                                                
                                                                                
                                                                                
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
                                                                                function funcAjax2(peticion_http)
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        
                                                                                        var objDatos=eval('['+arrResp[1]+']')[0];
                                                                                        var objConfiguracionDocumento=objDatos;
                                                                                       
                                                                                        if((objConfiguracionDocumento.idDocumentoAdjunto)&&(objConfiguracionDocumento.idDocumentoAdjunto!='-1'))
                                                                                        {
                                                                                            /*
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
                                                                                                                    
                                                                                            gEx('btnSave').hide();
                                                                                            gEx('btnUpload').show();                        
																							gEx('btnDownload').enable();
                                                                                            gEx('btnPrint').enable();  */                                                                                                                  
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            //gEx('hSpVisor').hide();
                                                                                            editor1.setData(bD(objDatos.cuerpoDocumento));
                                                                                            gEx('btnSave').enable();
                                                                                            gEx('btnDownload').enable();
                                                                                            gEx('btnPrint').enable();
                                                                                        }
                                                                                        gE('tipoFormato').value=confEditor.tipoDocumento;
                                                                                        gE('idRegistroFormato').value=objDatos.idRegistroFormato;
                                                                                        
                                                                                        if(typeof(functionAfterLoadDocument)!='undefined')
                                                                                            functionAfterLoadDocument();
                                                                                        guardarDocumento(
                                                                                        					function()
                                                                                                            {
                                                                                                            	window.parent.mostrarMenuDTD();
                                                                                                            }
                                                                                        				)
                                                                                        ventanaAM.close();
                                                                                        
                                                                                        
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax2, 'POST','funcion=126&tipoDocumento='+confEditor.tipoDocumento+'&cadObj='+cadObj,true);
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=144&cadObj='+cadObj,true);
                                                                        
                                                                        
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

function crearArbolPlantillas()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
											{
												baseParams:{
																funcion:'188',
                                                                idFormularioProceso:gE('idFormularioProceso').value,
                                                                idFormulario:gE('idFormulario').value,
                                                                idRegistro:gE('idRegistro').value,
                                                                idPerfil:window.parent.oConfiguracion.idPerfil
															},
												dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
											}
										)		
										
											
										
	var arbolPlantillas=new Ext.tree.TreePanel	(
														{
															
															id:'arbolPlantillas',
															useArrows:true,
															autoScroll:true,
															animate:true,
															enableDD:true,
															width:280,
															region:'west',
															containerScroll: true,
															root:raiz,
															loader: cargadorArbol,
															rootVisible:false
														}
													)
			
							
	arbolPlantillas.on('click',funcPlantillaClick);	
	
	return arbolPlantillas;
}

function funcPlantillaClick(nodo)
{
	nodoPlantillaSel=nodo;
	
	if(nodo.attributes.tipoNodo=='2')
	{
	
		function funcAjax()
		{
			var resp=peticion_http.responseText;
			arrResp=resp.split('|');
			if(arrResp[0]=='1')
			{
				var objPlantilla=eval('['+arrResp[1]+']')[0];
				CKEDITOR.instances["txtDocumentoDemo"].setData(bD(objPlantilla.cuerpoDocumento));

			}
			else
			{
				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
			}
		}
		obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=143&iD='+nodo.id,true);
	}
	else
	{
		nodoPlantillaSel=null;
		CKEDITOR.instances["txtDocumentoDemo"].setData('');
	}
	
}

function mostrarVentanaDatosDocumento(importarDocumento)
{
	
	var tabla='<div><input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; width: 200px" /></div><div class="flash" id="fsUploadProgress">'+ 
					'</div><input type="hidden" name="hidFileID" id="hidFileID" value="" /> ';       					
					
                    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			
                                                        {
                                            			
                                            				x:10,
                                            				y:10,
                                                            html:'Ingrese documento a adjuntar:'
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
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Adjuntar documento',
										width: 600,
                                        id:'vInfoDocumento',
										height:150,
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
                                                                	
                                                                    
                                                                    
                                                                    var cObj={
                                                                    // Backend settings
                                                                                            upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                            file_post_name: "archivoEnvio",
                                                                             
                                                                                            // Flash file settings
                                                                                            file_size_limit : "1000 MB",
                                                                                            file_types : "*.doc;*.docx",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                            file_types_description : "Todos los archivos",
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
        	
			gEx("idArchivo").setValue(arrDatos[1]);
            gEx("nombreArchivo").setValue(arrDatos[2]);
            if(gE('txtFileName'))
	            gE('txtFileName').value=arrDatos[2];
            
            
            
            var cadObj='{"idGeneracionDocumento":"'+gE('idInformacionDocumento').value+'","tipoDocumento":"0","tituloDocumento":"'+cv(arrDatos[2])+
            			'","perfilValidacion":"0","fechaLimite":"","modificaSituacionCarpeta":"0","situacion":"'+
                        '","descripcionActuacion":"","carpetaAdministrativa":"'+
                        gE('carpetaAdministrativa').value+'","nombreArchivoTemp":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+
                        '","idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistro').value+
                        '","arrAlertas":[],"idFormularioProceso":"'+gE('idFormularioProceso').value+
                        '","categoriaDocumento":"'+gE('categoriaDocumento').value+'"}';
            
            
           
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    
                    gEx('vInfoDocumento').close();
                    refrescarMenuDTD();
                   	recargarPagina();
                    
                    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=144&cadObj='+cadObj,true);
            
			
            
		}
		
	} 
    catch (e) 
	{
		alert(e);
	}
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
                                            				y:10,
                                                            html:'Ingrese documento a adjuntar:'
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
                                                        },
                                                        {
                                            			
                                            				x:10,
                                            				y:70,
                                                            html:'Comentarios adicionales:'
                                            			},
                                                        {
                                                        	x:10,
                                                            y:100,
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
										height:270,
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
                                                                	 var cObj={
                                                                            // Backend settings
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
                                                                iDocumento:gE('idDocumentoAdjunto').value,
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

function mostrarVentanaHistorial()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            frame:false,
											defaultType: 'label',
											items: 	[
														crearGridHistorial()

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

function crearGridHistorial()
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
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>('+val.format('H:i:s')+' hrs.)');
                                                                        }
                                                            },
                                                            {
                                                                header:'Etapa original',
                                                                width:200,
                                                                sortable:true,
                                                                renderer:formatoTitulo,
                                                                dataIndex:'etapaOriginal'
                                                            },
                                                            {
                                                                header:'Etapa cambio',
                                                                width:200,
                                                                sortable:true,
                                                                renderer:formatoTitulo,
                                                                dataIndex:'etapaCambio'
                                                            },                                                            
                                                            {
                                                                header:'Responsable',
                                                                width:500,
                                                                sortable:true,
                                                                 renderer:formatoTitulo,
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
                                                                                            getRowClass : formatearFilaHistorial
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	
}

function formatearFilaHistorial(record, rowIndex, p, ds)
{
	var xf = Ext.util.Format;
    p.body = '<BR><p style="margin-left: 4em;margin-right: 4em;text-align:justify"><br><span class="menu"><span style="color: #001C02">Comentarios:</span><br><br><span style="color: #3B3C3B">' + ((record.data.comentarios.trim()=="")?"(Sin comentarios)":record.data.comentarios) + '</span></p><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTitulo(val)
{
	return '<span style="font-size:11px; color:#040033">'+val+'</span>';
}

function firmarDocumentoExec()
{
	if(gE('idInformacionDocumento').value=='-1')
    {
    	msgBox('Primero debe ingresar el documento');
    	return;
    }
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
    
    
    if((gE('sL').value=='1')||(gE('idDocumentoAdjunto').value!='-1'))
    {
    		
		mostrarVentanaFirmaElectronica(cadConf);
    }
    else
    {
    	guardarDocumento(
    						function ()
                            {
                            	mostrarVentanaFirmaElectronica(cadConf);
                            }
    					);
    
    }
				
				
			
	
}

function mostrarVentanaFirmaElectronica(cadConf)
{
	
    
    
	var objConf=eval('['+(cadConf)+']')[0];	
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
					
	var tabla='<div><input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; width: 200px" /></div><div class="flash" id="fsUploadProgress">'+ 
					'</div><input type="hidden" name="hidFileID" id="hidFileID" value="" /> ';       					
					
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
                                                                                            timeout: 600000,
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
					
					msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+oResp.mensaje);
				}
				
				
			}
			obtenerDatosWeb('../paginasFunciones/procesarDocumentoFirmaElectronica.php',funcAjax2, 'POST','cadObj='+cadObj,true);
			
			gEx('vDocumento').close();
            
		}
		
	
}

