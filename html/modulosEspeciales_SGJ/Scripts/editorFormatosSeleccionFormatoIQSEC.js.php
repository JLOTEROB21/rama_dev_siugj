<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__44_tablaDinamica,CONCAT(IF(claveTipoMarcador='','',CONCAT('[',claveTipoMarcador,'] ')),nombreMarcador) AS marcador,descripcion 
				FROM _44_tablaDinamica WHERE situacion=1";
	$arrTiposMarcadores=$con->obtenerFilasArreglo($consulta);
?>
var uploadControl;
var plantillaOriginal='';
var firmaFinal=false;
var configuraPublicacion=<?php echo existeRol("'154_0'")?"true":"false"?>;
var objGlobal;
var objConfiguracionFirmaElectronica=window.parent.gEx('btnCertificacionProceso').oConfiguracion;
var confEditor=null;
var arrMediosFirmaPermitidos=[];
var editor1;
var swfDocumento=null;
var objConfiguracionFirmaElectronica=window.parent.gEx('btnCertificacionProceso').oConfiguracion;
var IDMarcadores=0;
var arrCasoEspecial=[['ninguno','NINGUNO'],['no publicado','NO PUBLICADO'],['mal publicado','MAL PUBLICADO']];
var arrTiposMarcadores=<?php echo $arrTiposMarcadores?>;
var arrTipoResolucion=[['acuerdo','Acuerdo'],['audiencia','Audiencia'],['sentencia','Sentencia'],['sentencia interlocutoria','Sentencia Interlocutoria'],['sentencia definitiva','Sentencia Definitiva']];
var arrPublicarEn=[['EXPEDIENTE','EXPEDIENTE'],['EXPEDIENTILLO','EXPEDIENTILLO'],['INCIDENTES','INCIDENTES'],['TERCERÍA','TERCER\xEDA'],['EXHORTO','EXHORTO'],
    					['CUMPLIMIENTO','CUMPLIMIENTO'],['SECCION DE EJECUCION','SECCI\xD3N DE EJECUCI\xD3N'],['CUAD. DE AMP. TERCERISTA','CUAD. DE AMP. TERCERISTA'],
                        ['CUAD. AMP. ACT.','CUAD. AMP. ACT.'],['CUAD. AMP. DEM.','CUAD. AMP. DEM.'],['EXPEDIENTILLO DEL CUAD. AMP.','EXPEDIENTILLO DEL CUAD. AMP.'],
                        ['SENT. DEF.','SENT. DEF.'],['ACDOS. AUDIENCIA','ACDOS. AUDIENCIA'],['OTRO','OTRO']];
    
    
Ext.onReady(inicializar);

function inicializar()
{

	 loadScript('../Scripts/IQSec/Firma.js', function()
                                          {
                                          		firma = new fielnet.Firma({
                                                                            subDirectory: '../../Scripts/IQSec',
                                                                            ajaxAsync: false,
                                                                            controller: "https://validmobile.iqsec.mx/DemoFirma/Controlador.ashx"
                                                                            
                                                                        });    
                                          }
          );     

	var cmbTipoResolucionP=crearComboExt('cmbTipoResolucionP',arrTipoResolucion,10,30,250);
	if(gE('tipoAcuerdo') && (gE('tipoAcuerdo').value!='-1') && (gE('tipoAcuerdo').value!=''))
    {
    	cmbTipoResolucionP.setValue(arrTipoResolucion[parseInt(gE('tipoAcuerdo').value)-1][0]);
    }
    
    
    var cmbPublicarEnP=crearComboExt('cmbPublicarEnP',arrPublicarEn,10,125,250);
    
    cmbPublicarEnP.on('select',function(cmb,registro)
    							{
                                	if(registro.data.id=='OTRO')
                                    {
                                    	gEx('txtOtroPublicarP').show();
                                        gEx('txtOtroPublicarP').focus();
                                    
                                    }
                                    else
                                    {
                                    	gEx('txtOtroPublicarP').setValue('');
                                    	gEx('txtOtroPublicarP').hide();
                                    }
                                }
    					)
                        
    var cmbCasoEspecialP=crearComboExt('cmbCasoEspecialP',arrCasoEspecial,10,210,250);
	cmbCasoEspecialP.setValue('ninguno');
    
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
    
    
    if((gE('idDocumentoAdjunto').value=='-1')&&((gE('permiteSeleccionPlantilla').value=='1')||(gE('permiteEdicionTextoEnriquecido').value=='1')))
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
    
    
    var arrPaneles=[];
    arrPaneles.push(oVisor);
    if(gE('permiteConfiguracionBoletin').value=='1')
    {
    	var configuracionBoletin=bD(gE('configuracionBoletin').value);
    	var objConf=null;
        
        if(configuracionBoletin!='')
        {
        	objConf=eval('['+configuracionBoletin+']')[0];
            cmbTipoResolucionP.setValue(objConf.tipoResolucion);
			cmbPublicarEnP.setValue(objConf.publicarEn);
            cmbCasoEspecialP.setValue(objConf.casoEspecial);
        }
    	arrPaneles.push	(
        					{
                                xtype:'panel',
                                region:'east',
                                width:265,
                                collapsible:true,
                                id:'panelConfBoletin',
                                defaultType: 'label',
                                title:'Configuraci&oacute;n de publicaci&oacute;n en bolet&iacute;n',
                                layout:'absolute',
                                tbar:	[
                                			{
                                                icon:'../images/guardar.JPG',
                                                cls:'x-btn-text-icon',
                                               	hidden:(gE('idDocumentoAdjunto').value==-1),
                                                xtype:'button',
                                                text:'Guardar configuraci&oacute;n',
                                                handler:function()
                                                        {
                                                        	var configuracionDocumento=obtenerDatosConfiguracionBoletin();
                                                            if(configuracionDocumento!==false)
                                                            {
                                                             	var cadObj='{"idRegistroDocumento":"'+gE('idRegistroFormato').value+
                                                             	'","configuracionDocumento":"'+configuracionDocumento+'"}';
                                                                
                                                                function funcAjax()
                                                                {
                                                                    var resp=peticion_http.responseText;
                                                                    arrResp=resp.split('|');
                                                                    if(arrResp[0]=='1')
                                                                    {
                                                                        
                                                                    }
                                                                    else
                                                                    {
                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                    }
                                                                }
                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=204&cadObj='+cadObj,true);
                                                                
                                                                
                                                        	}
                                                        }
                                                
                                            }
                                		],
                                items:	[
                                            {
                                                x:10,
                                                y:10,
                                                html:'Tipo de resoluci&oacute;n:'
                                            },
                                            cmbTipoResolucionP,
                                            {
                                                x:10,
                                                y:70,
                                                html:'Fecha de resoluci&oacute;n:'
                                            },
                                            {
                                                x:145,
                                                y:65,
                                                xtype:'datefield',
                                                id:'dteFechaResolucionP',
                                                value:objConf?objConf.fechaResolucion:'<?php echo date("Y-m-d")?>'
                                            }
                                            ,{
                                                x:10,
                                                y:100,
                                                html:'Publicar en:'
                                            },
                                            cmbPublicarEnP,
                                            {
                                                x:10,
                                                y:155,
                                                hidden:true,
                                                width:250,
                                                xtype:'textfield',
                                                id:'txtOtroPublicarP',
                                                value:objConf?objConf.otroLugarPublicacion:''
                                            },
                                            {
                                                x:10,
                                                y:185,
                                                html:'Caso especial:'
                                            },
                                            cmbCasoEspecialP,
                                            {
                                                x:10,
                                                y:245,
                                                html:'Visibilidad:'
                                            },
                                            
                                            {id:'gVisibilidad1P',checked:objConf?(objConf.visibilidad=='1'?true:false):false,xtype:'radio',boxLabel: 'Normal', name: 'rgVisibilidad', inputValue: 1,x:110,y:240, listeners: {check: visibilidadCheckP}},
                                            {id:'gVisibilidad2P',checked:objConf?(objConf.visibilidad=='2'?true:false):false,xtype:'radio',boxLabel: 'Notificaci&oacute;n personal', name: 'rgVisibilidad', inputValue: 2,x:110,y:260, listeners: {check: visibilidadCheckP}},
                                            {id:'gVisibilidad3P',checked:objConf?(objConf.visibilidad=='3'?true:false):false,xtype:'radio',boxLabel: 'Secreto', name: 'rgVisibilidad', inputValue: 3,x:110,y:280, listeners: {check: visibilidadCheckP}},
                                            {
                                                x:10,
                                                y:310,
                                                html:'Permisos:'
                                            },
                                            {id:'gPermiso1P',xtype:'checkbox',boxLabel: 'Actor', inputValue: 1,x:110,y:305,checked:objConf?(objConf.permisos1=='1'?true:false):false},
                                            {id:'gPermiso2P',xtype:'checkbox',boxLabel: 'Demandado', inputValue: 2,x:110,y:325,checked:objConf?(objConf.permisos2=='1'?true:false):false},
                                            {id:'gPermiso3P',xtype:'checkbox',boxLabel: 'Tercero',  inputValue: 3,x:110,y:345,checked:objConf?(objConf.permisos3=='1'?true:false):false},
                                            {
                                                x:10,
                                                y:370,
                                                html:'Comentarios para publicaci&oacute;n:'
                                            },
                                            {
                                                x:10,
                                                y:390,
                                                height:40,
                                                width:250,
                                                xtype:'textarea',
                                                value:objConf?escaparBR(objConf.comentarios,true):'',
                                                id:'txtDetallesPublicacionP'
                                                
                                            }
                                            
                                            
                                        ]
                            }
        					
                        );
    }
     new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                cls:'panelSiugj',
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
																			if(gE('permitirGuardarSinModificacion').value=='0')
                                                                            {
                                                                                if((plantillaOriginal!='')&&(plantillaOriginal==bE(CKEDITOR.instances.txtDocumento.getData())))
                                                                                {
                                                                                    msgBox('Primero debe modificar el documento a guardar');
                                                                                    return;
                                                                                }
																			}                                                                        
                                                                            guardarDocumento(function(){refrescarMenuDTD()});
                                                                        }
    
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                hidden:(gE('idDocumentoAdjunto').value!='-1'),
                                                                width:30
                                                            },
                                                            {
                                                                icon:'../images/icon_documents.gif',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnWord',
                                                                hidden:(gE('idDocumentoAdjunto').value!='-1')||(gE('documentoFirmado').value=='1'),
                                                                text:'Adjuntar documento',
                                                                tooltip:'Adjuntar documento',
                                                                handler:function()
                                                                        {
                                                                        	var confBoletin=obtenerDatosConfiguracionBoletin();
                                                                        	
                                                                            if(confBoletin!==false)
                                                                                mostrarVentanaDatosDocumento();
                                                                        }
    
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                               
                                                               hidden:(gE('idDocumentoAdjunto').value!='-1')||(gE('documentoFirmado').value=='1'),
                                                                width:30
                                                            },
                                                            
                                                            
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
                                                                        	if(gE('permitirGuardarSinModificacion').value=='0')
                                                                            {
                                                                                if((plantillaOriginal!='')&&(plantillaOriginal==bE(CKEDITOR.instances.txtDocumento.getData())))
                                                                                {
                                                                                    msgBox('Primero debe modificar el documento cuyo pdf desea observar');
                                                                                    return;
                                                                                }
                                                                                guardarDocumentoPDF();
                                                                            }
                                                                        }
    
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                
                                                                hidden:(gE('idDocumentoAdjunto').value!='-1'),
                                                                width:30
                                                            },
                                                            {
                                                                icon:'../images/printer.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnPrint',
                                                                disabled:(gE('idRegistroFormato').value=='-1'),
                                                                text:'Imprimir documento',
                                                                tooltip:'Imprimir documento',
                                                                handler:function()
                                                                        {
                                                                        	if(gE('permitirGuardarSinModificacion').value=='0')
                                                                            {
                                                                                if((plantillaOriginal!='')&&(plantillaOriginal==bE(CKEDITOR.instances.txtDocumento.getData())))
                                                                                {
                                                                                    msgBox('Primero debe modificar el documento que desea imprimir');
                                                                                    return;
                                                                                }
                                                                            }
                                                                            imprimirDocumento();
                                                                        }
    
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                
                                                                //hidden:(gE('idRegistroFormato').value=='-1'),
                                                                width:30
                                                            },
                                                            
                                                            {
                                                                icon:'../images/page_white_stack.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnGalery',
                                                                hidden:(gE('idDocumentoAdjunto').value!='-1')||(gE('permiteSeleccionPlantilla').value=='0'),
                                                                text:'Galeria de plantillas',
                                                                tooltip:'Galeria de plantillas',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaAddDocumento();
                                                                        }
    
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                
                                                                hidden:(gE('idDocumentoAdjunto').value!='-1')||(gE('permiteSeleccionPlantilla').value=='0'),
                                                                width:30
                                                            },
                                                            {
                                                                icon:'../images/arrow_refresh.PNG',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnReprocesar',
                                                                
                                                                hidden:((gE('documentoFirmado').value=='1')||(gE('sL').value=='1')),      
                                                                
                                                                text:'Reprocesar documento',
                                                                tooltip:'Reprocesar documento',
                                                                handler:function()
                                                                        {
                                                                        	cargarPlantillaBase();
                                                                            if(gE('idRegistroFormato').value!='-1')
                                                                            {
                                                                            	guardarDocumento(function(){refrescarMenuDTD()});
                                                                            }
                                                                        }
    
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                
                                                                hidden:((gE('documentoFirmado').value=='1')||(gE('sL').value=='1')),    
                                                                width:30
                                                            },
                                                            
                                                            {
                                                                icon:'../images/icon_documents.gif',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnUpload',
                                                               	hidden:(gE('sL').value=='1')||((gE('idDocumentoAdjunto').value=='-1')||(gE('sL').value=='2')|| (gE('documentoFirmado').value=='1')),
                                                                text:'Modificar documento',
                                                                tooltip:'Actualizar documento',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaActualizarDocumento();
                                                                        }
    
                                                           },
                                                           {
                                                            	xtype:'tbspacer',
                                                                
                                                                hidden:(gE('sL').value=='1')||((gE('idDocumentoAdjunto').value=='-1')||(gE('sL').value=='2')|| (gE('documentoFirmado').value=='1')),
                                                                width:30
                                                            },
                                                           {
                                                                icon:'../images/firma.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnSign',
                                                               	hidden:true,
                                                                text:'',
                                                                handler:function()
                                                                        {
                                                                            firmarDocumentoPublicacionExec();
                                                                        }
    
                                                           },
                                                           {
                                                            	xtype:'tbspacer',
                                                                id:'spacerSign',
                                                                hidden:true,
                                                                width:30
                                                            },
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
                                                items:	arrPaneles
                                            }
                                         ]
                            }
                        )
    
    if(gE('idDocumentoAdjunto').value=='-1')
    {
    	var anchoVentana=(obtenerDimensionesNavegador()[1]*0.9);
        var altoVentana=(obtenerDimensionesNavegador()[0]*0.9);
        editor1=	CKEDITOR.replace('txtDocumento',
                                                         {
                                                            
                                                            customConfig:((gE('sL').value=='1')||(gE('sL').value=='2'))?urlConfiguracionSL:urlConfiguracion,
                                                            height:(altoVentana-60),
                                                            width:'100%',
                                                            on:	{
                                                                    instanceReady:function(evt)
                                                                                {
                                                                                    
                                                                                    var boton=$('.cke_button__psavefirmaelectronica');
                                                                                   
                                                                                    if((boton.length>0)&&(!objConfiguracionFirmaElectronica))
                                                                                    {
                                                                                        boton[0].style.display='none';
                                                                                    }
                                                                                    
                                                                                    
                                                                                    if(gE('idInformacionDocumento').value=='-1')
                                                                                    {

																						
                                                                                    	cargarPlantillaBase();
                                                                                    }
                                                                                    else    
                                                                                    {
                                                                                    	
                                                                                    	editor1.setData(bD(gE('txtCuerpo').value));
                                                                                        setTimeout(function()
                                                                                                    {                
                                                                                                        ajustarTamanoPlantilla(),350
                                                                                                    })
                                                                                    	
                                                                                     }  
                                                                                }
                                                                    
                                                                }
                                                         }
                                        );
                                        
                          
        
    	  
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
                                                    ocultarBarraSuperior:1,
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
    
    if(gEx('gVisibilidad2P'))
	    visibilidadCheck(gEx('gVisibilidad2P'),gEx('gVisibilidad2P').checked);
    
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
	
                            function funcAjax2(peticion_http)
                            {
                                var resp=peticion_http.responseText;
                                
                                arrResp=resp.split('|');
                                if(arrResp[0]=='1')
                                {
                                	refrescarMenuDTD();
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
                            obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax2, 'POST','funcion=3&cadObj='+cadObj,true);
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
	if(gE('idInformacionDocumento').value=='-1')
	{
    	cargarInformacionPlantillaDefault(funcionEjecucion);
    	return;
    }
    
    var objConfiguracion=obtenerDatosConfiguracionBoletin();
    if(objConfiguracion===false)
    	return;
	var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'","tipoFormato":"'+gE('tipoFormato').value+'","cuerpoFormato":"'+
				bE(CKEDITOR.instances.txtDocumento.getData())+'","idFormulario":"-2","idRegistro":"'+gE('idInformacionDocumento').value+
                '","idReferencia":"'+gE('idInformacionDocumento').value+'","idFormularioProceso":"'+gE('idFormularioProceso').value+
                '","objConfiguracion":"'+(objConfiguracion)+'"}';
	
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
                                	refrescarMenuDTD();
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
                                                                                                    actor:gE('actor').value,
                                                                                                    iFormularioProceso:gE('idFormularioProceso').value,
                                                                                                    idFormularioBase:gE('idFormulario').value,
                                                                                                    idRegistroBase:gE('idRegistro').value,
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
                                                            y:15,
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                        {
                                                            x:185,
                                                            y:45,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
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
                                                                	
                                                                    
                                                                    
                                                                    var oConf={
                                                                    // Backend settings
                                                                                            upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                            file_post_name: "archivoEnvio",
                                                                             
                                                                                            // Flash file settings
                                                                                            file_size_limit : "1000 MB",
                                                                                            file_types : "*.doc;*.docx;*.pdf",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                            file_types_description : "Todos los archivos",
                                                                                            file_upload_limit : 0,
                                                                                            file_queue_limit : 1,
                                                                                            upload_success_handler : subidaCorrecta,
                                                                                            
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
                        '","categoriaDocumento":"'+gE('categoriaDocumento').value+'","configuracionDocumento":"'+obtenerDatosConfiguracionBoletin()+'"}';
            
            
           
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
                                                            x:185,
                                                            y:5,
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                        {
                                                            x:185,
                                                            y:38,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        {
                                                            x:480,
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
                                                                                upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                file_post_name: "archivoEnvio",
                                                                 
                                                                                // Flash file settings
                                                                                file_size_limit : "1000 MB",
                                                                                file_types : "*.doc;*.docx; *.pdf",			// or you could use something like: "*.doc;*.wpd;*.pdf",
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
            
            cadObj='{"comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'","idArchivo":"'+arrDatos[1]+
            		'","nombreArchivo":"'+arrDatos[2]+'","idRegistroDocumento":"'+gE('idRegistroFormato').value+
                    '","configuracionDocumento":"'+obtenerDatosConfiguracionBoletin()+'"}';
			
            
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

function firmarDocumentoPublicacionExec()
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
    
    
    if((gE('sL').value=='1')||(gE('idDocumentoAdjunto').value!='-1'))
    {
    		
		mostrarVentanaFirmaElectronicaPublicacion(cadConf);
    }
    else
    {
    	guardarDocumento(
    						function ()
                            {
                            	mostrarVentanaFirmaElectronicaPublicacion(cadConf);
                            }
    					);
    
    }
				
				
			
	
}

/*function mostrarVentanaFirmaElectronicaPublicacion(cadConf)
{
	var configuracionPublicacionVisible=false;
	firmaFinal=false;
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
	    	arrAccionesFirma.push([oAccion.idAccion,oAccion.etiquetaAccion,oAccion.documentoFinal,oAccion.etapaEnvio]);
		}
    }
    
	var cmbAccionFirma=crearComboExt('cmbAccionFirma',arrAccionesFirma,150,5,300);
    cmbAccionFirma.on('select',function(cmb,registro)
    							{
                                	firmaFinal=false;

                                	if(registro.data.valorComp=='1')
                                    	firmaFinal=true;
                                	var alturaConfBoletin=0;
                                    gEx('fSetPublicacionBoletin').hide();
                                    gEx('panelFirma').hideTabStripItem(1);
                                    configuracionPublicacionVisible=false;
                                    if((registro.data.valorComp=='1')&&(configuraPublicacion))
                                    {
                                        gEx('panelFirma').unhideTabStripItem(1);
                                        configuracionPublicacionVisible=true;
                                        
                                        
                                        var configuracionBoletin=bD(gE('configuracionBoletin').value);
                                       
                                        var objConf=null;
                                        
                                        if(configuracionBoletin!='')
                                        {
                                            objConf=eval('['+configuracionBoletin+']')[0];
                                       
                                            gEx('cmbTipoResolucion').setValue(objConf.tipoResolucion);
                                            gEx('cmbPublicarEn').setValue(objConf.publicarEn);
                                            gEx('cmbCasoEspecial').setValue(objConf.casoEspecial);
                                            gEx('dteFechaResolucion').setValue(objConf.fechaResolucion);
                                            gEx('txtOtroPublicar').setValue(objConf.otroLugarPublicacion);
                                            gEx('gVisibilidad1').checked=objConf.visibilidad=='1';
                                            gEx('gVisibilidad2').checked=objConf.visibilidad=='2';
                                            gEx('gVisibilidad3').checked=objConf.visibilidad=='3';
                                            gEx('gPermiso1').checked=objConf.permisos1=='1';
                                            gEx('gPermiso2').checked=objConf.permisos2=='1';
                                            gEx('gPermiso3').checked=objConf.permisos3=='1';
                                            gEx('txtDetallesPublicacion').setValue(escaparBR(objConf.comentarios,true));
                                            visibilidadCheck(gEx('gVisibilidad2'),gEx('gVisibilidad2').checked);
                                        }	
                                        
                                        
                                        
                                    }
                                	gEx('fSetFirma').hide();
									gEx('fSetFirmaDocumento').hide();
									gEx('fSetFirmaFirel').hide();
									
									//gEx('vDocumento').setHeight(230);
                                	switch(registro.data.id)
                                    {
                                    	case '1':                                        	
											gEx('fSetFirmaDocumento').hide();
											gEx('fSetFirmaFirel').hide();
											gEx('fSetFirma').show();
											//gEx('vDocumento').setHeight(380+alturaConfBoletin);
                                        break;
                                       	case '6':                                        	
											gEx('fSetFirmaDocumento').hide();
											gEx('fSetFirmaFirel').show();
											gEx('fSetFirma').hide();
											//gEx('vDocumento').setHeight(380+alturaConfBoletin);
                                        break;
                                        break;
										case '4':
											gEx('fSetFirma').hide();
											gEx('fSetFirmaFirel').hide();
											gEx('fSetFirmaDocumento').show();
											//gEx('vDocumento').setHeight(380+alturaConfBoletin);
                                        break;
                                    }
									
									gEx('vDocumento').center();
                                }
    				)

	var cmbTipoResolucion=crearComboExt('cmbTipoResolucion',arrTipoResolucion,130,5,200);
	if(gE('tipoAcuerdo') && (gE('tipoAcuerdo').value!='-1') && (gE('tipoAcuerdo').value!=''))
    {
    	cmbTipoResolucion.setValue(arrTipoResolucion[parseInt(gE('tipoAcuerdo').value)-1][0]);
    }
    
    var cmbPublicarEn=crearComboExt('cmbPublicarEn',arrPublicarEn,130,65,220);
    
    cmbPublicarEn.on('select',function(cmb,registro)
    							{
                                	if(registro.data.id=='OTRO')
                                    {
                                    	gEx('txtOtroPublicar').show();
                                        gEx('txtOtroPublicar').focus();
                                    
                                    }
                                    else
                                    {
                                    	gEx('txtOtroPublicar').setValue('');
                                    	gEx('txtOtroPublicar').hide();
                                    }
                                }
    					)
    var arrCasoEspecial=[['ninguno','NINGUNO'],['no publicado','NO PUBLICADO'],['mal publicado','MAL PUBLICADO']];                    
    var cmbCasoEspecial=crearComboExt('cmbCasoEspecial',arrCasoEspecial,130,95,220);
	cmbCasoEspecial.setValue('ninguno');
    
    var tabla='<div><input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; width: 200px" /></div><div class="flash" id="fsUploadProgress">'+ 
					'</div><input type="hidden" name="hidFileID" id="hidFileID" value="" /> ';       					


	
				
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                           	defaultType: 'label',
											items: 	[
                                            
                                            			{
                                                        	xtype:'tabpanel',
                                                            id:'panelFirma',
                                                            activeTab:0,                                                            
                                                            region:'center',
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                        {
                                                                        	xtype:'panel',
                                                                            defaultType: 'label',
                                                                            layout:'absolute',
                                                                            baseCls: 'x-plain',
                                                                            title:'Firmar documento',
                                                                            items:	[
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
                                                                                            height:45,
                                                                                            xtype:'textarea',
                                                                                            id:'txtComentariosAdicionales'
                                                                                        },
                                                                                        {
                                                                                            id:'fSetFirma',
                                                                                            xtype:'fieldset',
                                                                                            width:580,
                                                                                            x:10,
                                                                                            y:125,
                                                                                            height:115,
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
                                                                                            y:125,
                                                                                            height:105,
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
                                                                                            y:125,
                                                                                            height:105,
                                                                                            defaultType: 'label',
                                                                                            layout:'absolute',
                                                                                            items:	[
                                                                                                        {
                                                                                                            x:10,
                                                                                                            y:30,
                                                                                                            html:'Ingrese su documento de firma:'
                                                                                                        },
                                                                                                        {
                                                                                                            x:185,
                                                                                                            y:25,
                                                                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                                                                        },
                                                                                                        {
                                                                                                            x:185,
                                                                                                            y:55,
                                                                                                            hidden:true,
                                                                                                            html:	'<div id="containerUploader"></div>'
                                                                                                        },
                                                                                                        {
                                                                                                            x:480,
                                                                                                            y:26,
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
                                                                                                        } 
                                                                                                    ]
                                                                                        }
                                 														
                                                                            
                                                                            		]
                                                                        },
                                                                        {
                                                                            id:'fSetPublicacionBoletin',
                                                                            xtype:'panel',
                                                                            baseCls: 'x-plain',
                                                                            defaultType: 'label', 
                                                                            title:'Configuraci&oacute;n de la publicaci&oacute;n en bolet&iacute;n',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                                        {
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'Tipo de resoluci&oacute;n:'
                                                                                        },
                                                                                        cmbTipoResolucion,
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'Fecha de resoluci&oacute;n:'
                                                                                        },
                                                                                        {
                                                                                        	x:130,
                                                                                            y:35,
                                                                                        	xtype:'datefield',
                                                                                            id:'dteFechaResolucion',
                                                                                            value:gE('fechaAcuerdo')?gE('fechaAcuerdo').value:'<?php echo date("Y-m-d")?>'
                                                                                        }
                                                                                        ,{
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'Publicar en:'
                                                                                        },
                                                                                        cmbPublicarEn,
                                                                                        {
                                                                                        	x:370,
                                                                                            y:65,
                                                                                            hidden:true,
                                                                                            width:200,
                                                                                            xtype:'textfield',
                                                                                            id:'txtOtroPublicar'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'Caso especial:'
                                                                                        },
                                                                                        cmbCasoEspecial,
                                                                                        {
                                                                                            x:10,
                                                                                            y:130,
                                                                                            html:'Visibilidad:'
                                                                                        },
                                                                                        
                                                                                        {id:'gVisibilidad1',xtype:'radio',boxLabel: 'Normal', name: 'rgVisibilidad', inputValue: 1,x:110,y:125,listeners: {check: visibilidadCheck}},
                                                                                        {id:'gVisibilidad2',xtype:'radio',boxLabel: 'Notificaci&oacute;n personal', name: 'rgVisibilidad', inputValue: 2,x:210,y:125,listeners: {check: visibilidadCheck}},
                                                                                        {id:'gVisibilidad3',xtype:'radio',boxLabel: 'Secreto', name: 'rgVisibilidad', inputValue: 3,x:380,y:125,listeners: {check: visibilidadCheck}},
                                                                                        {
                                                                                            x:10,
                                                                                            y:160,
                                                                                            html:'Permisos:'
                                                                                        },
                                                                                        {id:'gPermiso1',xtype:'checkbox',boxLabel: 'Actor', inputValue: 1,x:110,y:155},
                                                                                        {id:'gPermiso2',xtype:'checkbox',boxLabel: 'Demandado', inputValue: 2,x:210,y:155},
                                                                                        {id:'gPermiso3',xtype:'checkbox',boxLabel: 'Tercero',  inputValue: 3,x:380,y:155},
                                                                                        {
                                                                                            x:10,
                                                                                            y:190,
                                                                                            html:'Comentarios para publicaci&oacute;n:'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:220,
                                                                                            height:45,
                                                                                            width:540,
                                                                                            xtype:'textarea',
                                                                                            id:'txtDetallesPublicacion'
                                                                                            
                                                                                        }
                                                                                        
                                                                                    ]
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
										height:380,
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
                                                                	gEx('panelFirma').hideTabStripItem(1);
																	gEx('txtPassword').focus(false,500);																
																	
                                                                    var cObj= {

                                                                                  upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                  file_post_name: "archivoEnvio",
                                                                   
                                                                                  // Flash file settings
                                                                                  file_size_limit : "1000 MB",
                                                                                  file_types : "*.pdf; *.jpg; *.gif; *.png; *.jpeg",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                  file_types_description : "Todos los archivos",
                                                                                  file_upload_limit : 0,
                                                                                  file_queue_limit : 1,                                                                   
                                                                                 
                                                                                  upload_success_handler : subidaCorrectaFinalFirmaBoletin
                                                                               }  
																	
																	crearControlUploadHTML5(cObj);
                                                                }
															}
												},
										buttons:	[
														{
															
															text: 'Aceptar',                                                            
															handler: function()
																	{
                                                                    	var dteFechaResolucion=gEx('dteFechaResolucion');
                                                                        var txtOtroPublicar=gEx('txtOtroPublicar');
																		if(cmbAccionFirma.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('panelFirma').setActiveTab(0);
                                                                            	cmbAccionFirma.focus();
                                                                            }
                                                                            msgBox('Debe indicar la acci&oacute;n a realizar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(configuracionPublicacionVisible)
                                                                        {
                                                                        	if(cmbTipoResolucion.getValue()=='')
                                                                            {
                                                                            	function respTipoResolucion()
                                                                                {
                                                                                	gEx('panelFirma').setActiveTab(1);
                                                                                  	cmbTipoResolucion.focus();
                                                                                }
                                                                                msgBox('Debe indicar el tipo de resoluci&oacute;n a publicar',respPublicacion);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(dteFechaResolucion.getValue()=='')
                                                                            {
                                                                            	function respFechaResolucion()
                                                                                {
                                                                                	gEx('panelFirma').setActiveTab(1);
                                                                                  	dteFechaResolucion.focus();
                                                                                }
                                                                                msgBox('Debe indicar la fecha de la resoluci&oacute;n',respFechaResolucion);
                                                                                return;
                                                                            }
                                                                        
                                                                        	if(cmbPublicarEn.getValue()=='')
                                                                            {
                                                                            	function respLugar()
                                                                                {
                                                                                	gEx('panelFirma').setActiveTab(1);
                                                                                  	cmbPublicarEn.focus();
                                                                                }
                                                                                msgBox('Debe indicar el lugar donde se publicar&aacute;',respLugar);
                                                                                return;
                                                                            }
                                                                        	
                                                                            if((cmbPublicarEn.getValue()=='OTRO')&&(txtOtroPublicar.getValue()==''))
                                                                            {
                                                                            	function respOtroLugar()
                                                                                {
                                                                                	gEx('panelFirma').setActiveTab(1);
                                                                                  	txtOtroPublicar.focus();
                                                                                }
                                                                                msgBox('Debe indicar el lugar donde se publicar&aacute;',respOtroLugar);
                                                                                return;
                                                                            }
                                                                            
                                                                        
                                                                        	if(!gEx('gVisibilidad1').getValue() && !gEx('gVisibilidad2').getValue() &&!gEx('gVisibilidad3').getValue())
                                                                            {
                                                                            	function respPublicacion()
                                                                                {
                                                                                	gEx('panelFirma').setActiveTab(1);
                                                                                   	gEx('gVisibilidad1').focus();
                                                                                }
                                                                                msgBox('Debe indicar la visibilidad de la publicaci&oacute;n',respPublicacion);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        if(cmbCasoEspecial.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('panelFirma').setActiveTab(1);
                                                                            	cmbCasoEspecial.focus();
                                                                            }
                                                                            msgBox('Debe indicar si existe alg&uacute;n caso especial',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        
																		var objResultado={};
                                                                        objResultado.idRegistroFormato=gE('idRegistroFormato').value;
                                                                        objResultado.accion=cmbAccionFirma.getValue();
                                                                        objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
                                                                        objResultado.cadenaFirma='';
                                                                        
																		var pos=obtenerPosFila(gEx('cmbAccionFirma').getStore(),'id',objResultado.accion);
                                                                        var documentoFinal=gEx('cmbAccionFirma').getStore().getAt(pos).data.valorComp;
																		
                                                                       	switch(parseInt(cmbAccionFirma.getValue()))
																		{
																			case 1://Fiel
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
																				
                                                                                
                                                                                
                                                                                objResultado.cadenaFirma='';
                                                                                if(gE('publicaEnBoletin').value=='1')
                                                                                {
                                                                                    if(gEx('fSetPublicacionBoletin').isVisible())
                                                                                    {
                                                                                        var visibilidad=gEx('gVisibilidad1').getValue()?'1':gEx('gVisibilidad2').getValue()?'2':'3';
                                                                                        
                                                                                        objResultado.funcionEjecucion=bE('registrarPublicacionBoletin(\''+
                                                                                                                        bE('{"idRegistroFormato":"'+gE('idRegistroFormato').value+
                                                                                                                        '","visibilidad":"'+visibilidad+'","comentarios":"'+
                                                                                                                        cv(gEx('txtDetallesPublicacion').getValue())+
                                                                                                                        '","tipoResolucion":"'+cmbTipoResolucion.getValue()+
                                                                                                                        '","fechaResolucion":"'+dteFechaResolucion.getValue().format('Y-m-d')+
                                                                                                                        '","publicarEn":"'+cmbPublicarEn.getValue()+'","otroLugarPublicacion":"'+
                                                                                                                        cv(txtOtroPublicar.getValue())+'","casoEspecial":"'+gEx('cmbCasoEspecial').getValue()+
                                                                                                                        '","permisos1":"'+(gEx('gPermiso1').getValue()?1:0)+'","permisos2":"'+(gEx('gPermiso2').getValue()?1:0)+
                                                                                                                        '","permisos3":"'+(gEx('gPermiso3').getValue()?1:0)+'"}')+'\')');
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        if(firmaFinal)
                                                                                        {
                                                                                            objResultado.funcionEjecucion=bE('registrarAcuerdoPublicacionPromocionProcesoAcuerdo('+gE('idFormulario').value+','+gE('idReferencia').value+')');
                                                                                        }
                                                                                    }
                                                                                }
                                                                                else
                                                                                {
                                                                                	objResultado.funcionEjecucion='';
                                                                                }
                                                                                
																																
																				
																				
																				
                                                                                
                                                                                
                                                                                validateParDeLlavesModulo	(
                                                                                						function()
                                                                                                        {
                                                                                                        	objResultado.cadenaFirma=''
                                                                                                            var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+gE('idRegistroFormato').value+
																														'","cadena":"'+objResultado.cadenaFirma+'","tipoFirma":"1"}';			
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
                                                                                                                                                                    	ocultarMensajeProcesando();
                                                                                                                                                                        var resp=peticion_http.responseText;
                                                                                                                                                                        
                                                                                                                                                                        var oResp=eval('['+resp+']')[0];
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
																			case 6: //Firel
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
                                                                                if(gE('publicaEnBoletin').value=='1')
                                                                                {
                                                                                    if(gEx('fSetPublicacionBoletin').isVisible())
                                                                                    {
                                                                                        var visibilidad=gEx('gVisibilidad1').getValue()?'1':gEx('gVisibilidad2').getValue()?'2':'3';
                                                                                        
                                                                                        objResultado.funcionEjecucion=bE('registrarPublicacionBoletin(\''+
                                                                                                                        bE('{"idRegistroFormato":"'+gE('idRegistroFormato').value+
                                                                                                                        '","visibilidad":"'+visibilidad+'","comentarios":"'+
                                                                                                                        cv(gEx('txtDetallesPublicacion').getValue())+
                                                                                                                        '","tipoResolucion":"'+cmbTipoResolucion.getValue()+
                                                                                                                        '","fechaResolucion":"'+dteFechaResolucion.getValue().format('Y-m-d')+
                                                                                                                        '","publicarEn":"'+cmbPublicarEn.getValue()+'","otroLugarPublicacion":"'+
                                                                                                                        cv(txtOtroPublicar.getValue())+'","casoEspecial":"'+gEx('cmbCasoEspecial').getValue()+
                                                                                                                        '","permisos1":"'+(gEx('gPermiso1').getValue()?1:0)+'","permisos2":"'+(gEx('gPermiso2').getValue()?1:0)+
                                                                                                                        '","permisos3":"'+(gEx('gPermiso3').getValue()?1:0)+'"}')+'\')');
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        if(firmaFinal)
                                                                                        {
                                                                                            objResultado.funcionEjecucion=bE('registrarAcuerdoPublicacionPromocionProcesoAcuerdo('+gE('idFormulario').value+','+gE('idReferencia').value+')');
                                                                                        }
                                                                                    }
                                                                                }
                                                                                else
                                                                                {
                                                                                	objResultado.funcionEjecucion='';
                                                                                }
																				
																				
                                                                                
                                                                                validateUnicaLlavesModulo	(
                                                                                						function()
                                                                                                        {
                                                                                                        	objResultado.cadenaFirma=''
                                                                                                           	var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+gE('idRegistroFormato').value+
																											'","cadena":"'+objResultado.cadenaFirma+'","tipoFirma":"2"}';
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
                                                                                                                                                                            eval("window.parent."+objConf.funcionManejoResultado+'(objResultado);')
																																											ventanaAM.close();
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
																			case 4:
	                                                                           	 if(uploadControl.files.length==0)
                                                                                {
                                                                                    msgBox('Debe ingresar el documento mediante cual desea registrar su firma');
																					return;
                                                                                }
                                                                                uploadControl.start();
                                                                            	
																				
																			break;
                                                                            case 10:
                                                                            	var pos=existeValorMatriz(arrAccionesFirma,cmbAccionFirma.getValue());
                                                                            	objResultado.iFormulario=gE('idFormulario').value;
                                                                                objResultado.iReferencia=gE('idRegistro').value;
                                                                                objResultado.actor=bD(window.parent.gE('actor').value);
                                                                                objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
                                                                                objResultado.etapaCambio=arrAccionesFirma[pos][3];
                                                                                marcarRegistroParaFirma(objResultado);
                                                                                
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
*/
function mostrarVentanaFirmaElectronicaPublicacion(cadConf)
{
	mostrarVentanaFirmaElectronicaConsejo(cadConf);
	return;
	var configuracionPublicacionVisible=false;
	firmaFinal=false;
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
	    	arrAccionesFirma.push([oAccion.idAccion,oAccion.etiquetaAccion,oAccion.documentoFinal,oAccion.etapaEnvio]);
		}
    }
    

    

	
    var tabla='<div><input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; width: 200px" /></div><div class="flash" id="fsUploadProgress">'+ 
					'</div><input type="hidden" name="hidFileID" id="hidFileID" value="" /> ';       					


	
				
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                           	defaultType: 'label',
											items: 	[
                                            
                                            			{
                                                        	xtype:'panel',
                                                            id:'panelFirma',
                                                            layout:'absolute',     
                                                            defaultType: 'label',                                              
                                                            region:'center',
                                                            baseCls: 'x-plain',
                                                            items:	[
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
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										id:'vDocumento',
										title: 'Firmar documento',
										width: 800,
										height:340,
                                        cls:'msgHistorialSIUGJ',
										layout: 'fit',
										plain:true,
                                        closable:false,
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
                                                                    
                                                                    gEx('vDocumento').setHeight(340);
																	gEx('txtPassword').focus(false,500);																
																	
                                                                    var cObj= {

                                                                                  upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                  file_post_name: "archivoEnvio",
                                                                   
                                                                                  // Flash file settings
                                                                                  file_size_limit : "1000 MB",
                                                                                  file_types : "*.pdf; *.jpg; *.gif; *.png; *.jpeg",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                  file_types_description : "Todos los archivos",
                                                                                  file_upload_limit : 0,
                                                                                  file_queue_limit : 1,                                                                   
                                                                                 
                                                                                  upload_success_handler : subidaCorrectaFinalFirmaBoletin
                                                                               }  
																	
																	crearControlUploadHTML5(cObj);
                                                                    
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
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: 'Aceptar',   
                                                            cls:'btnSIUGJ',
                                                            width:140,                                                         
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
                                                                        objResultado.idRegistroFormato=gE('idRegistroFormato').value;
                                                                        objResultado.accion=cmbAccionFirma.getValue();
                                                                        objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
                                                                        objResultado.cadenaFirma='';
                                                                        
																		var pos=obtenerPosFila(gEx('cmbAccionFirma').getStore(),'id',objResultado.accion);
                                                                        var documentoFinal=gEx('cmbAccionFirma').getStore().getAt(pos).data.valorComp;
																		
                                                                       	switch(parseInt(cmbAccionFirma.getValue()))
																		{
																			case 1://Fiel
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
																				objResultado.cadenaFirma='';
                                                                                objResultado.funcionEjecucion='';
                                                                                
                                                                                
                                                                                
                                                                                validateParDeLlavesModulo	(
                                                                                                                function()
                                                                                                                {
                                                                                                                    objResultado.cadenaFirma=''
                                                                                                                    var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+gE('idRegistroFormato').value+
                                                                                                                                '","cadena":"'+objResultado.cadenaFirma+'","tipoFirma":"1"}';			
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
                                                                                                                                                                            function funcAjax(peticion_http)
                                                                                                                                                                            {
                                                                                                                                                                            
                                                                                                                                                                            	ocultarMensajeProcesando();
                                                                                                                                                                                var resp=peticion_http.responseText;
                                                                                                                                                                                
                                                                                                                                                                                var oResp=eval('['+resp+']')[0];
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
                                                                                                                                                                            obtenerDatosWebV2('../modulosEspeciales_SGJ/paginasFunciones/procesarDocumentoFirmaElectronicaIQSEC_2.php',funcAjax, 'POST','cadObj='+cadObj,true);
        
                                                                                                                                                                            
                                                                                                                                                                            
                                                                                                                                                                            
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
																			case 6: //Firel
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
                                                                                objResultado.funcionEjecucion='';
                                                                                
																				validateUnicaLlavesModulo	(
                                                                                						function()
                                                                                                        {
                                                                                                        	objResultado.cadenaFirma=''
                                                                                                           	var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+gE('idRegistroFormato').value+
																											'","cadena":"'+objResultado.cadenaFirma+'","tipoFirma":"2"}';
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
                                                                                                                                                                    function funcAjax(peticion_http)
                                                                                                                                                                    {
                                                                                                                                                                        var resp=peticion_http.responseText;
                                                                                                                                                                        
                                                                                                                                                                        var oResp=eval('['+resp+']')[0];
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
                                                                                                                                                                    obtenerDatosWebV2('../modulosEspeciales_SGJ/paginasFunciones/procesarDocumentoFirmaElectronicaIQSEC_2.php',funcAjax, 'POST','cadObj='+cadObj,true);

                                                                                                                                                                    
                                                                                                                                                                    
                                                                                                                                                                    
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
																			case 4:
	                                                                           	 if(uploadControl.files.length==0)
                                                                                {
                                                                                    msgBox('Debe ingresar el documento mediante cual desea registrar su firma');
																					return;
                                                                                }
                                                                                uploadControl.start();
                                                                            	
																				
																			break;
                                                                            case 10:
                                                                            	var pos=existeValorMatriz(arrAccionesFirma,cmbAccionFirma.getValue());
                                                                            	objResultado.iFormulario=gE('idFormulario').value;
                                                                                objResultado.iReferencia=gE('idRegistro').value;
                                                                                objResultado.actor=bD(window.parent.gE('actor').value);
                                                                                objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
                                                                                objResultado.etapaCambio=arrAccionesFirma[pos][3];
                                                                                marcarRegistroParaFirma(objResultado);
                                                                                
                                                                            break;
																			default:
                                                                            
                                                                           	    eval("window.parent."+objConf.funcionManejoResultado+'(objResultado);')
																				ventanaAM.close();
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
function subidaCorrectaFinalFirmaBoletin(file, serverData) 
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
            
			var cmbTipoResolucion=gEx('cmbTipoResolucion');
            var dteFechaResolucion=gEx('dteFechaResolucion');
            var cmbPublicarEn=gEx('cmbPublicarEn');
            var otroLugarPublicacion=gEx('otroLugarPublicacion');
            
			var objResultado={};
			objResultado.accion=gEx('cmbAccionFirma').getValue();
			objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
			if(gE('publicaEnBoletin').value=='1')
            {
                if(gEx('fSetPublicacionBoletin').isVisible())
                {
                    var visibilidad=gEx('gVisibilidad1').getValue()?'1':gEx('gVisibilidad2').getValue()?'2':'3';
                    
                    objResultado.funcionEjecucion=bE('registrarPublicacionBoletin(\''+
                                                    bE('{"idRegistroFormato":"'+gE('idRegistroFormato').value+
                                                    '","visibilidad":"'+visibilidad+'","comentarios":"'+
                                                    cv(gEx('txtDetallesPublicacion').getValue())+
                                                    '","tipoResolucion":"'+cmbTipoResolucion.getValue()+
                                                    '","fechaResolucion":"'+dteFechaResolucion.getValue().format('Y-m-d')+
                                                    '","publicarEn":"'+cmbPublicarEn.getValue()+'","otroLugarPublicacion":"'+
                                                    cv(txtOtroPublicar.getValue())+'","casoEspecial":"'+gEx('cmbCasoEspecial').getValue()+
                                                    '","permisos1":"'+(gEx('gPermiso1').getValue()?1:0)+'","permisos2":"'+(gEx('gPermiso2').getValue()?1:0)+
                                                    '","permisos3":"'+(gEx('gPermiso3').getValue()?1:0)+'"}')+'\')');
                }
                else
                {
                    if(firmaFinal)
                    {
                        objResultado.funcionEjecucion=bE('registrarAcuerdoPublicacionPromocionProcesoAcuerdo('+gE('idFormulario').value+','+gE('idReferencia').value+')');
                    }
                }
            }
            else
            {
            	objResultado.funcionEjecucion='';
            }
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
			obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/procesarDocumentoFirmaElectronicaIQSEC_1.php',funcAjax2, 'POST','cadObj='+cadObj,true);
			
			gEx('vDocumento').close();
            
		}
		
	
}

function cargarInformacionPlantillaDefault(funcionEjecucion)
{
	var objConfiguracion=obtenerDatosConfiguracionBoletin();
    if(objConfiguracion===false)
	    	return;
	var cObjDefault=eval('['+bD(gE('cObjDefault').value)+']')[0];
    if(cObjDefault.tipoDocumento=='')
    	return;
	var cadObj='{"idGeneracionDocumento":"'+gE('idInformacionDocumento').value+'","tipoDocumento":"'+cObjDefault.tipoDocumento+'","tituloDocumento":"'+cv(cObjDefault.tituloDocumento)+
                '","perfilValidacion":"'+cObjDefault.perfilValidacion+'","fechaLimite":"","modificaSituacionCarpeta":"0","situacion":"'+
                '","descripcionActuacion":"","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'","idFormulario":"'+gE('idFormulario').value+
                '","idRegistro":"'+gE('idRegistro').value+'","arrAlertas":[],"idFormularioProceso":"'+gE('idFormularioProceso').value+
                '","categoriaDocumento":"'+cObjDefault.categoriaDocumento+'"}';


	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gE('idInformacionDocumento').value=arrResp[1];
            
    		
            
            ///
            var cadObj='{"idRegistroFormato":"'+gE('idRegistroFormato').value+'","tipoFormato":"'+cObjDefault.tipoDocumento+'","cuerpoFormato":"'+
				bE(CKEDITOR.instances.txtDocumento.getData())+'","idFormulario":"-2","idRegistro":"'+gE('idInformacionDocumento').value+
                '","idReferencia":"'+gE('idInformacionDocumento').value+'","idFormularioProceso":"'+gE('idFormularioProceso').value+
                '","objConfiguracion":"'+(objConfiguracion)+'"}';
	
            function funcAjax4(peticion_http)
            {
                var resp=peticion_http.responseText;
                
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    gE('idRegistroFormato').value=arrResp[1];
                    gEx('btnSave').enable();
                    gEx('btnDownload').enable();
                    gEx('btnPrint').enable();
                    
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
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=144&cadObj='+cadObj,true);
    
    
}

function ajustarTamanoPlantilla()
{
	var body = CKEDITOR.instances.txtDocumento.editable().$;
                                                                                                              
    var value = 105;
    

    body.style.MozTransformOrigin = "top left";
    body.style.MozTransform = "scale(" + (value/100)  + ")";

    body.style.WebkitTransformOrigin = "top left";
    body.style.WebkitTransform = "scale(" + (value/100)  + ")";

    body.style.OTransformOrigin = "top left";
    body.style.OTransform = "scale(" + (value/100)  + ")";

    body.style.TransformOrigin = "top left";
    body.style.Transform = "scale(" + (value/100)  + ")";
    // IE
    body.style.zoom = value/100;  
}

function marcarRegistroParaFirma(obj)
{
	var cadObj=convertirCadenaJson(obj);
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        
        if(arrResp[0]=='1')
        {
            window.parent.regresar1Pagina(objConfiguracionFirmaElectronica.accionEjecucion=='1');    
            if(objConfiguracionFirmaElectronica.accionEjecucion=='0')
            	window.parent.recargarPagina();
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=200&cadObj='+cadObj,true);
}


function cargarPlantillaBase()
{

	var cObjDefault=eval('['+bD(gE('cObjDefault').value)+']')[0];

    confEditor={
                        tipoDocumento:cObjDefault.tipoDocumento,
                        idFormulario:-2,
                        idRegistro: -1,
                        reprocesar:1,
                        actor:gE('actor').value,
                        iFormularioProceso:gE('idFormularioProceso').value,
                        idFormularioBase:gE('idFormulario').value,
                        idRegistroBase:gE('idRegistro').value,
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
                                                                                                                               
            }
            else
            {
                //gEx('hSpVisor').hide();
                
                
               
                editor1.setData(bD(objDatos.cuerpoDocumento));
               
                
                gEx('btnSave').enable();
               // gEx('btnDownload').enable();
                //gEx('btnPrint').enable();
            }
            gE('tipoFormato').value=cObjDefault.tipoDocumento;
            gE('idRegistroFormato').value=objDatos.idRegistroFormato;
            
            if(typeof(functionAfterLoadDocument)!='undefined')
                functionAfterLoadDocument();
            
                            
                            
            setTimeout(function()
            			{   
                         
                			ajustarTamanoPlantilla();
                            plantillaOriginal=bE(editor1.getData());
            			},350
                      )
            
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax2, 'POST','funcion=126&tipoDocumento='+cObjDefault.tipoDocumento+'&cadObj='+cadObj,true);
    
}

function visibilidadCheck(chk,checado)
{
	if(checado)
    {
    	if(chk.id=='gVisibilidad2')
        {
        	gEx('gPermiso1').disable();
            gEx('gPermiso2').disable();
            gEx('gPermiso3').disable();
            gEx('gPermiso1').setValue(false);
            gEx('gPermiso2').setValue(false);
            gEx('gPermiso3').setValue(false);
        }
        else
        {
        	gEx('gPermiso1').enable();
            gEx('gPermiso2').enable();
            gEx('gPermiso3').enable();
        }
    }

}

function visibilidadCheckP(chk,checado)
{
	if(checado)
    {
    	if(chk.id=='gVisibilidad2P')
        {
        	gEx('gPermiso1P').disable();
            gEx('gPermiso2P').disable();
            gEx('gPermiso3P').disable();
            gEx('gPermiso1P').setValue(false);
            gEx('gPermiso2P').setValue(false);
            gEx('gPermiso3P').setValue(false);
        }
        else
        {
        	gEx('gPermiso1P').enable();
            gEx('gPermiso2P').enable();
            gEx('gPermiso3P').enable();
        }
    }

}


function obtenerDatosConfiguracionBoletin()
{
	var cadObjBoletin=gE('configuracionBoletin').value;
    if(gEx('panelConfBoletin'))
    {
    	var cmbTipoResolucion=gEx('cmbTipoResolucionP');
        var dteFechaResolucion=gEx('dteFechaResolucionP');
        var cmbPublicarEn=gEx('cmbPublicarEnP');
        var txtOtroPublicar=gEx('txtOtroPublicarP');
        if(cmbTipoResolucion.getValue()=='')
        {
            function respTipoResolucion()
            {
            	gEx('panelConfBoletin').expand();
                cmbTipoResolucion.focus();
            }
            msgBox('Debe indicar el tipo de resoluci&oacute;n a publicar',respPublicacion);
            return false;
        }
        
        if(dteFechaResolucion.getValue()=='')
        {
            function respFechaResolucion()
            {
               gEx('panelConfBoletin').expand();
                dteFechaResolucion.focus();
            }
            msgBox('Debe indicar la fecha de la resoluci&oacute;n',respFechaResolucion);
            return false;
        }
    
        if(cmbPublicarEn.getValue()=='')
        {
            function respLugar()
            {
                gEx('panelConfBoletin').expand();
                cmbPublicarEn.focus();
            }
            msgBox('Debe indicar el lugar donde se publicar&aacute;',respLugar);
            return false;
        }
        
        if((cmbPublicarEn.getValue()=='OTRO')&&(txtOtroPublicar.getValue()==''))
        {
            function respOtroLugar()
            {
                gEx('panelConfBoletin').expand();
                txtOtroPublicar.focus();
            }
            msgBox('Debe indicar el lugar donde se publicar&aacute;',respOtroLugar);
            return false;
        }
        
    
        if(!gEx('gVisibilidad1P').getValue() && !gEx('gVisibilidad2P').getValue() &&!gEx('gVisibilidad3P').getValue())
        {
            function respPublicacion()
            {
                gEx('panelConfBoletin').expand();
                gEx('gVisibilidad1P').focus();
            }
            msgBox('Debe indicar la visibilidad de la publicaci&oacute;n',respPublicacion);
            return false;
        }
    	
        var visibilidad=gEx('gVisibilidad1P').getValue()?'1':gEx('gVisibilidad2P').getValue()?'2':'3';
        cadObjBoletin=bE('{"visibilidad":"'+visibilidad+'","comentarios":"'+
                      cv(gEx('txtDetallesPublicacionP').getValue(),false,true)+
                      '","tipoResolucion":"'+cmbTipoResolucion.getValue()+
                      '","fechaResolucion":"'+dteFechaResolucion.getValue().format('Y-m-d')+
                      '","publicarEn":"'+cmbPublicarEn.getValue()+'","otroLugarPublicacion":"'+
                      cv(txtOtroPublicar.getValue(),false,true)+'","casoEspecial":"'+gEx('cmbCasoEspecialP').getValue()+
                      '","permisos1":"'+(gEx('gPermiso1P').getValue()?1:0)+'","permisos2":"'+(gEx('gPermiso2P').getValue()?1:0)+
                      '","permisos3":"'+(gEx('gPermiso3P').getValue()?1:0)+'"}');
    }
    
    
    return cadObjBoletin;
}

function validateParDeLlavesModulo(afterValidate) 
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


function validateUnicaLlavesModulo(afterValidate) 
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


function mostrarVentanaFirmaElectronicaConsejo(cadConf)
{
	var configuracionPublicacionVisible=false;
	firmaFinal=false;
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
	    	arrAccionesFirma.push([oAccion.idAccion,oAccion.etiquetaAccion,oAccion.documentoFinal,oAccion.etapaEnvio]);
		}
    }
    

    

	
    var tabla='<div><input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; width: 200px" /></div><div class="flash" id="fsUploadProgress">'+ 
					'</div><input type="hidden" name="hidFileID" id="hidFileID" value="" /> ';       					


	
				
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                           	defaultType: 'label',
											items: 	[
                                            
                                            			{
                                                        	xtype:'panel',
                                                            id:'panelFirma',
                                                            layout:'absolute',     
                                                            defaultType: 'label',                                              
                                                            region:'center',
                                                            baseCls: 'x-plain',
                                                            items:	[
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
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										id:'vDocumento',
										title: 'Firmar documento',
										width: 800,
										height:340,
                                        cls:'msgHistorialSIUGJ',
										layout: 'fit',
										plain:true,
                                        closable:false,
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
                                                                    
                                                                    gEx('vDocumento').setHeight(340);
																	gEx('txtPassword').focus(false,500);																
																	
                                                                    var cObj= {

                                                                                  upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                  file_post_name: "archivoEnvio",
                                                                   
                                                                                  // Flash file settings
                                                                                  file_size_limit : "1000 MB",
                                                                                  file_types : "*.pdf; *.jpg; *.gif; *.png; *.jpeg",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                  file_types_description : "Todos los archivos",
                                                                                  file_upload_limit : 0,
                                                                                  file_queue_limit : 1,                                                                   
                                                                                 
                                                                                  upload_success_handler : subidaCorrectaFinalFirmaBoletin
                                                                               }  
																	
																	crearControlUploadHTML5(cObj);
                                                                    
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
                                                                                                        case '6':      
                                                                                                        	                                 	                                  	
                                                                                                            gEx('fSetFirmaDocumento').hide();
                                                                                                            gEx('fSetFirmaFirel').hide();
                                                                                                            gEx('fSetFirma').hide();
                                                                                                            gEx('vDocumento').setHeight(340);
                                                                                                            
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
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: 'Aceptar',   
                                                            cls:'btnSIUGJ',
                                                            width:140,                                                         
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
                                                                        objResultado.idRegistroFormato=gE('idRegistroFormato').value;
                                                                        objResultado.accion=cmbAccionFirma.getValue();
                                                                        objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
                                                                        objResultado.cadenaFirma='';
                                                                        
																		var pos=obtenerPosFila(gEx('cmbAccionFirma').getStore(),'id',objResultado.accion);
                                                                        var documentoFinal=gEx('cmbAccionFirma').getStore().getAt(pos).data.valorComp;
																		
                                                                       	switch(parseInt(cmbAccionFirma.getValue()))
																		{
																			case 1://Fiel
																			case 6: //Firel
																				
																				objResultado.cadenaFirma=''
                                                                                objResultado.funcionEjecucion='';
                                                                                objResultado.cadenaFirma=''
                                                                                var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+gE('idRegistroFormato').value+
                                                                                '","cadena":"'+objResultado.cadenaFirma+'","tipoFirma":"2","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                                var oObj=eval('['+cadObj+']')[0];
                                                                                
                                                                                
                                                                                var formData = new FormData();
                                                                                
                                                                               
                                                                                for(var campo in oObj)
                                                                                {
                                                                                    formData.append(campo,oObj[campo]);
                                                                                }
                                                                                
                                                                                
                                                                                
                                                                                mostrarMensajeProcesando('Firmando documento, &eacute;sta operaci&oacute;n puede tardar unos minutos...');
                                                                                $.ajax	({
                                                                                            url: "../modulosFirmaElectronica/paginasFunciones/procesarDocumentoFirmaElectronicaConsejo.php",
                                                                                            data: formData,
                                                                                            processData: false,
                                                                                            contentType: false,
                                                                                            type: 'POST',
                                                                                            success: function(data)
                                                                                                    {
                                                                                                        
                                                                                                        var oResp=eval('['+data+']')[0];
                                                                                                        
                                                                                                        
                                                                                                        
                                                                                                        cadObj='{"archivoDestino":"'+oResp.archivoDestino+'","objOriginal":'+cadObj+'}';
                                                                                                        function funcAjax(peticion_http)
                                                                                                        {
                                                                                                            var resp=peticion_http.responseText;
                                                                                                            
                                                                                                            var oResp=eval('['+resp+']')[0];
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
                                                                                                        obtenerDatosWebV2('../modulosFirmaElectronica/paginasFunciones/procesarDocumentoFirmaElectronicaConsejo2.php',funcAjax, 'POST','cadObj='+cadObj,true);

                                                                                                    }
                                                                                        });
																				
                                                                                
																			break;
																			case 4:
	                                                                           	 if(uploadControl.files.length==0)
                                                                                {
                                                                                    msgBox('Debe ingresar el documento mediante cual desea registrar su firma');
																					return;
                                                                                }
                                                                                uploadControl.start();
                                                                            	
																				
																			break;
                                                                            case 10:
                                                                            	var pos=existeValorMatriz(arrAccionesFirma,cmbAccionFirma.getValue());
                                                                            	objResultado.iFormulario=gE('idFormulario').value;
                                                                                objResultado.iReferencia=gE('idRegistro').value;
                                                                                objResultado.actor=bD(window.parent.gE('actor').value);
                                                                                objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
                                                                                objResultado.etapaCambio=arrAccionesFirma[pos][3];
                                                                                marcarRegistroParaFirma(objResultado);
                                                                                
                                                                            break;
																			default:
                                                                            
                                                                           	    eval("window.parent."+objConf.funcionManejoResultado+'(objResultado);')
																				ventanaAM.close();
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