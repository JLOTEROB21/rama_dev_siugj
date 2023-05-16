<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	
	$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos";
	$arrTipoDocumentos=$con->obtenerFilasArreglo($consulta);
	
	
	
?>
var uploadControl;
var arrRegistrosDocumentoFinal=[];
var msgBoxEspere=null;
var objDocumentosConf={};
var registroFirmaActual;
var arrBloqueados=0;
var arrFirmados=0;
var arrDocumentosFinales=0;
var arrMediosFirmaPermitidos=[];
var arrTipoDocumentos=<?php echo $arrTipoDocumentos?>;
var primeraCargaFrame=true;
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
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                id:'panelPrincipal',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Documentos en Espera de Firma</b></span>',
                                                items:	[
                                                            crearGridDocumentosFirma()
                                                        ]
                                               
                                            }
                                         ]
                            }
                        )   

	recargarGridDocumentos();	                        
}

function crearGridDocumentosFirma()
{
	var cmbTipoDocumentosMuestra=crearComboExt('cmbTipoDocumentosMuestra',[['0','En espera de firma'],['1','Firmados'],['0,1','Cualquiera']],0,0,250);
    cmbTipoDocumentosMuestra.setValue('0');
    cmbTipoDocumentosMuestra.on('select',recargarGridDocumentos);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'nombreDocumento'},
		                                                {name:'situacionActual'},
		                                                {name:'fechaAsignacion', type:'date',dateFormat:'Y-m-d H:i:s'},
                                                        {name:'fecha'},
                                                        {name: 'carpetaAdministrativa'},
                                                        {name: 'iFormulario'},
                                                        {name: 'iRegistro'},
                                                        {name: 'tipoDocumento'},
                                                        {name: 'documentoFirmado'},
                                                        {name: 'documentoBloqueado'},
                                                        {name: 'fechaAtencion', type:'date',dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'idDocumentoPDF'},
                                                        {name: 'objConfirma'},
                                                        {name: 'actor'},
                                                        {name: 'idRegistroAtencion'},
                                                        {name: 'objDocumento'},
                                                        {name: 'objConfirmaProceso'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fecha', direction: 'ASC'},
                                                            groupField: 'fecha',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	arrBloqueados=0;
                                        arrFirmados=0;
                                        arrDocumentosFinales=0;
                                        var btnSign=gEx('btnSign');
    									btnSign.disable();
                                    	proxy.baseParams.funcion='17';
                                        
                                    }
                        )   

	var chkRow=new Ext.grid.CheckboxSelectionModel();
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idDocumentoPDF',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val!='')
                                                                            {
                                                                            	return '<a href="javascript:mostrarDocumento(\''+bE(val)+'\')" title="Ver documento" alt="Ver documento"><img src="../imagenesDocumentos/16/file_extension_pdf.png"></a>';
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'fecha'
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val)
                                                                		{
                                                                        	var imagen='../images/';
                                                                            var titulo='';
                                                                            switch(val)
                                                                            {
                                                                            	case '0':
                                                                                	imagen+='control_pause.png';
                                                                                    titulo='En espera de atenci&oacute;n';
                                                                                break;
                                                                            	case '1':
                                                                                	imagen+='icon_tick.gif';
                                                                                    titulo='Atendido';
                                                                                break;
                                                                            }
                                                                            
                                                                            return '<img src="'+imagen+'" title="'+titulo+'" alt="'+titulo+'">';
                                                                        }
                                                            },
                                                             {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idRegistroAtencion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirDocumentoEvaluacion(\''+bE(val)+'\')"><img src="../images/magnifier.png"></a>';
                                                                        }
                                                            },
                                                            /*{
                                                                header:'Carpeta Judicial',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:mostrarValorDescripcion
                                                            },*/
                                                            {
                                                                header:'Nombre del documento',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'nombreDocumento',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Fecha de asignaci&oacute;n',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'fechaAsignacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Fecha de atenci&oacute;n',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'fechaAtencion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
                                                                            	return val.format('d/m/Y H:i')
                                                                        }
                                                            },
                                                            {
                                                                header:'Firmado',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'documentoFirmado',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='1')
                                                                            	return 'S&iacute;';
                                                                            return 'No';
                                                                        }
                                                            },
                                                            {
                                                                header:'Bloqueado',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'documentoBloqueado',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='1')
                                                                            	return 'S&iacute;';
                                                                            return 'No';
                                                                        }
                                                            },
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gDocumentosFirma',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                sm:chkRow,
                                                                tbar:	[
                                                                			{
                                                                            	xtype:'label',
                                                                                html:'<b>Mostrar documentos:&nbsp;&nbsp;</b>'
                                                                            },
                                                                            cmbTipoDocumentosMuestra,
                                                                           '-',
                                                                           {
                                                                           		xtype:'label',
                                                                                html:'<b>Periodo del:&nbsp;&nbsp;</b>'
                                                                           },
                                                                           {
                                                                           		xtype:'datefield',
                                                                                id:'periodoInicio',
                                                                                listeners:	{
                                                                                				select: recargarGridDocumentos
                                                                                			},
                                                                                value:'<?php echo date("Y-m-d")?>'
                                                                           },
                                                                           {
                                                                           		xtype:'label',
                                                                                html:'<b>&nbsp;&nbsp;al:&nbsp;&nbsp;</b>'
                                                                           },
                                                                           {
                                                                           		xtype:'datefield',
                                                                                id:'periodoFin',
                                                                                listeners:	{
                                                                                				select: recargarGridDocumentos
                                                                                			},
                                                                                value:'<?php echo date("Y-m-d")?>'
                                                                           },'-',
                                                                			{
                                                                                icon:'../images/firma.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnSign',
                                                                                disabled:true,
                                                                                text:'Firmar documento',
                                                                                handler:function()
                                                                                        {
                                                                                        	var filas=gEx('gDocumentosFirma').getSelectionModel().getSelections();
                                                                                            if(filas.length==0)
                                                                                            {
                                                                                            	msgBox('De seleccionar almenos un documento para firmar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            firmarDocumentoPublicacionExec();
                                                                                        }
                    
                                                                           },
                                                                           '-',
                                                                			{
                                                                                icon:'../images/printer.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Imprimir documentos seleccionados',
                                                                                handler:function()
                                                                                        {
                                                                                        	var filas=gEx('gDocumentosFirma').getSelectionModel().getSelections();
                                                                                            if(filas.length==0)
                                                                                            {
                                                                                            	msgBox('De seleccionar almenos un documento para imprimir');
                                                                                            	return;
                                                                                            }
                                                                                            var listaDocumento='';
                                                                                            var x;
                                                                                            var fila;
                                                                                            for(x=0;x<filas.length;x++)
                                                                                            {
                                                                                            	fila=filas[x];
                                                                                                if(listaDocumento=='')
                                                                                                	listaDocumento=fila.data.idDocumentoPDF;
                                                                                                else
                                                                                                	listaDocumento+=','+fila.data.idDocumentoPDF;
                                                                                            }
                                                                                            
                                                                                            if(listaDocumento=='')
                                                                                            {
                                                                                            	msgBox('Almenos debe haber un documento para imprimir');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    obtenerVersionCompletaDocumentos(arrResp[1]);
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',funcAjax, 'POST','funcion=18&listaDocumento='+listaDocumento,true);
                                                                                            
                                                                                        }
                    
                                                                           }
                                                                		],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
	
    tblGrid.getSelectionModel().on('rowselect',function(sm,numFila,registro)
												{
                                                	revisarFilasSeleccionada();
                                                }
    								)
    
    
    tblGrid.getSelectionModel().on('rowdeselect',function(sm,numFila,registro)
												{
                                                	revisarFilasSeleccionada();
                                                }
    								)
    
    return 	tblGrid;	
}

function recargarGridDocumentos()
{
	gEx('gDocumentosFirma').getStore().load	(
    											{
                                                	url:'../paginasFunciones/funcionesModulosEspeciales_SICORE.php',
                                                    params:	{
                                                    			funcion:17,
                                                                periodoInicio:gEx('periodoInicio').getValue().format('Y-m-d'),
                                                                periodoFin:gEx('periodoFin').getValue().format('Y-m-d'),
                                                                tipoDocumentos:gEx('cmbTipoDocumentosMuestra').getValue()
                                                    		}
                                                }
    										);
}

function revisarFilasSeleccionada()
{
	arrRegistrosDocumentoFinal=[];
	var btnSign=gEx('btnSign');
    btnSign.disable();
    arrBloqueados=0;
	arrFirmados=0;
    arrDocumentosFinales=0;
    var filas=gEx('gDocumentosFirma').getSelectionModel().getSelections();
    var x;
    var p;
    for(x=0;x<filas.length;x++)
    {
    	if(filas[x].data.documentoFirmado=='1')
        {
        	arrFirmados++;
        }
        
        if(filas[x].data.documentoBloqueado=='1')
        {
        	arrBloqueados++;
        }
        else
        {
        	if(parseInt(filas[x].data.objDocumento.idFormulario)<0)
            {
                if(filas[x].data.objConfirma.permiteFirmar=='0')
                {
                    arrBloqueados++;
                }
            }
            else
            {
            	for(p=0;p<filas[x].data.objConfirmaProceso.arrAcciones.length;p++)
                {
                    if(filas[x].data.objConfirmaProceso.arrAcciones[p].documentoFinal=='1')
                    {
                    	arrRegistrosDocumentoFinal.push(filas[x]);
                        arrDocumentosFinales++;
                        break;
                    }
                }
            }
        }
        
        
    }
    
    
    if(arrBloqueados==0)
    {
    	btnSign.enable();
    }
}

function abrirRegistroSolicitud(iF,iR,a)
{
	if(window.parent.parent)
		window.parent.parent.abrirFormularioProcesoFancy(iF,iR,bE(a));
    else
    	abrirFormularioProcesoFancy(iF,iR,bE(a));
}


function firmarDocumentoPublicacionExec()
{
    var oArrAcciones=[{"idAccion":"1","etiquetaAccion":"Firmar mediante FIEL","etapaEnvio":"0","documentoFinal":"0"},{"idAccion":"6","etiquetaAccion":"Firmar mediante FIREL","etapaEnvio":"0","documentoFinal":"0"}];
	var arrAcciones='';
	var x;
	var accion;
	var oAccion='';
	for(x=0;x<oArrAcciones.length;x++)
	{
    	accion=oArrAcciones[x];
    	if((accion.idAccion=='10')||((arrFirmados>0)&&((accion.idAccion=='2')||(accion.idAccion=='3'))))
        	continue;
		
		  oAccion='{"idAccion":"'+accion.idAccion+'","etiquetaAccion":"'+accion.etiquetaAccion.replace(/"/gi,"'")+'","etapaEnvio":"'+accion.etapaEnvio+'","documentoFinal":"'+accion.documentoFinal+'"}';
		  if(arrAcciones=='')
			  arrAcciones=oAccion;
		  else
			  arrAcciones+=','+oAccion;
	}
	
	var cadConf='{"funcionManejoResultado":"procesoCertificacionFirmaRealizado","idFormulario":"","idRegistro":"","actor":"","arrAcciones":['+arrAcciones+']}';
    
    mostrarVentanaFirmaElectronicaPublicacion(cadConf);
    		
}

function mostrarVentanaFirmaElectronicaPublicacion(cadConf)
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
		
        if((oAccion.idAccion=='1')||(oAccion.idAccion=='6')||(oAccion.idAccion=='4'))
        {
            if(existeValorArreglo(arrMediosFirmaPermitidos,oAccion.idAccion)==-1)
            {
                continue;
            }

        
        }
        arrAccionesFirma.push([oAccion.idAccion,oAccion.etiquetaAccion,oAccion.documentoFinal,oAccion.etapaEnvio]);
		
    }
    
	var cmbAccionFirma=crearComboExt('cmbAccionFirma',arrAccionesFirma,150,5,300);
    cmbAccionFirma.on('select',function(cmb,registro)
    							{
                                	
                                	var alturaConfBoletin=0;
                                    
                                    /*gEx('panelFirma').hideTabStripItem(1);
                                    configuracionPublicacionVisible=false;
                                    if((registro.data.valorComp=='1')&&(configuraPublicacion))
                                    {
                                        gEx('panelFirma').unhideTabStripItem(1);
                                        configuracionPublicacionVisible=true;
                                    }*/
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
                                                                                                            x:180,
                                                                                                            y:25,
                                                                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                                                                        },
                                                                                                       
                                                                                                        {
                                                                                                            x:475,
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
                                                                	if(arrDocumentosFinales==0)
                                                                		gEx('panelFirma').hideTabStripItem(1);
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
                                                                             
                                                                                            
                                                                                            upload_success_handler : subidaCorrectaFinalFirmaBoletin
                                                                                        };   
																	
																}
															}
												},
										buttons:	[
														{
															
															text: 'Aceptar',                                                            
															handler: function()
																	{
                                                                    	var dteFechaResolucion=gEx('dteFechaResolucion');
                                                                        
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
                                                                                
                                                                                
                                                                                
                                                                                
                                                                            break
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
                                                                                
                                                                                
                                                                                
                                                                            break;
                                                                            case 4:
                                                                                if(uploadControl.files.length==0)
                                                                                {
                                                                                    msgBox('Debe ingresar el documento mediante cual desea registrar su firma');
																					return;
                                                                                }
                                                                                
                                                                                
                                                                            break;
                                                                            
                                                                        }
                                                                        
                                                                        ventanaAM.hide();
                                                                        mostrarVentanaFirmando();
																		firmarDocumentosSeleccionados();
																		
																		
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
			
            if(gEx('fSetPublicacionBoletin').isVisible())
            {
                var visibilidad=gEx('gVisibilidad1').getValue()?'1':gEx('gVisibilidad2').getValue()?'2':'3';
                
                objResultado.funcionEjecucion=bE('registrarPublicacionBoletin(\''+
                                                bE('{"idRegistroFormato":"'+registroFirmaActual.data.idDocumento+
                                                '","visibilidad":"'+visibilidad+'","comentarios":"'+
                                                cv(gEx('txtDetallesPublicacion').getValue())+
                                                '","tipoResolucion":"'+gEx('cmbTipoResolucion').getValue()+
                                                '","fechaResolucion":"'+gEx('dteFechaResolucion').getValue().format('Y-m-d')+
                                                '","publicarEn":"'+gEx('cmbPublicarEn').getValue()+'","otroLugarPublicacion":"'+
                                                cv(gEx('txtOtroPublicar').getValue())+'","casoEspecial":"'+gEx('cmbCasoEspecial').getValue()+
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
			
			var pos=existeValorArregloObjetos(registroFirmaActual.data.objConfirma.arrAcciones,'idAccion',objResultado.accion);
    		var documentoFinal=registroFirmaActual.data.objConfirma.arrAcciones[pos].documentoFinal;
			var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+registroFirmaActual.data.idDocumento+
            		'","idArchivo":"'+arrDatos[1]+'","cadena":"'+arrDatos[2]+'"}';

			function funcAjax2()
			{
				var resp=peticion_http.responseText;
				
				var oResp=eval('['+resp+']')[0];
				if(oResp.resultado=='1')					
				{
					funcionFirmaRealizado(objResultado);
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


function firmarDocumentosSeleccionados()
{
	var arrDocumentos=gEx('gDocumentosFirma').getSelectionModel().getSelections();
    ejecutarProcesoFirma(arrDocumentos.length,1,arrDocumentos,arrDocumentos[0]);
    
}

function ejecutarProcesoFirma(totalDocumentos,documentoActual,arrDocumentos,registro)
{
	
	objDocumentosConf.totalDocumentos=totalDocumentos;
    objDocumentosConf.documentoActual=documentoActual;
    objDocumentosConf.arrDocumentos=arrDocumentos;
	registroFirmaActual=registro;
    
	if(documentoActual>totalDocumentos)
    {	
    	
        gEx('gDocumentosFirma').getStore().reload();
        ocultarVentanaFirmando();
    	return;
    }
	msgBoxEspere.updateProgress(documentoActual/totalDocumentos,'Firmado documento '+documentoActual+' de '+totalDocumentos);
    
    var cmbAccionFirma=gEx('cmbAccionFirma');
    var objResultado={};
    
    objResultado.iT=registroFirmaActual.data.objDocumento.idTablero;
   	objResultado.iA=registroFirmaActual.data.objDocumento.idTarea;
    var documentoFinal=1;
    if(parseInt(registroFirmaActual.data.objDocumento.idFormulario)<0)
    {
       	
        switch(parseInt(cmbAccionFirma.getValue()))
        {
            case 1://Fiel
                
                objResultado.cadenaFirma=''
                
                var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+registro.data.idDocumento+
                        '","cadena":"'+objResultado.cadenaFirma+'","tipoFirma":"1","etapaEnvioFirma":"'+registroFirmaActual.data.objConfirma.confFirma.etapaEnvioFirma+
                        '","rolDestinatarioEnvioFirma":"'+registroFirmaActual.data.objConfirma.confFirma.rolDestinatarioEnvioFirma+
                        '","usuarioDestino":"'+registroFirmaActual.data.objConfirma.confFirma.usuarioDestino+
                        '","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'","rolActual":"'+
                        registroFirmaActual.data.objConfirma.permisosRol+'"}';															
                
                var oObj=eval('['+cadObj+']')[0];
                
                
                var formData = new FormData();
                
                formData.append('passwd',AES_Encrypt(gEx('txtPassword').getValue()));
                
                
                for(var campo in oObj)
                {
                    formData.append(campo,oObj[campo]);
                    
                }
                
                
                
                formData.append('fCer',gE('fileCer').files[0]);
                formData.append('fKey',gE('fileKey').files[0]);
                
                $.ajax	({
                            url: "../paginasFunciones/procesarDocumentoFirmaElectronica.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            success: function(data)
                                    {
                                        
                                        var oResp=eval('['+data+']')[0];
                                        if(oResp.resultado=='1')
                                        {
                                            funcionFirmaRealizado(objResultado);
                                            
                                        }
                                        else
                                        {
                                            msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:<br><br>'+bD(oResp.mensaje));
                                        }
                                    }
                        });
                
                
                
            break;
            case 6: //Firel
                
                objResultado.cadenaFirma=''
                var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+registro.data.idDocumento+
                        '","cadena":"'+objResultado.cadenaFirma+'","tipoFirma":"2","etapaEnvioFirma":"'+registroFirmaActual.data.objConfirma.confFirma.etapaEnvioFirma+
                        '","rolDestinatarioEnvioFirma":"'+registroFirmaActual.data.objConfirma.confFirma.rolDestinatarioEnvioFirma+
                        '","usuarioDestino":"'+registroFirmaActual.data.objConfirma.confFirma.usuarioDestino+
                        '","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'","rolActual":"'+
                        registroFirmaActual.data.objConfirma.permisosRol+'"}';																
                
                
                var oObj=eval('['+cadObj+']')[0];
                
                var formData = new FormData();
                formData.append('passwd',AES_Encrypt(gEx('txtPasswordFirel').getValue()));
                
                
                for(var campo in oObj)
                {
                    formData.append(campo,oObj[campo]);
                }
                
                
                
                formData.append('fCer',gE('filePFX').files[0]);
               
                
                $.ajax	({
                            url: "../paginasFunciones/procesarDocumentoFirmaElectronica.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            success: function(data)
                                    {
                                       
                                        var oResp=eval('['+data+']')[0];
                                        if(oResp.resultado=='1')
                                        {
                                            funcionFirmaRealizado(objResultado);
                                            
                                        }
                                        else
                                        {
                                            msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:<br><br>'+bD(oResp.mensaje));
                                        }
                                    }
                        });
            break;
            case 4:
                gEx('lPorcentaje').show();
                swfDocumento.startUpload();
            break;
            default:
                funcionFirmaRealizado(objResultado);
               
            break;
        }
    }
    else
    {
    	objResultado.accion=gEx('cmbAccionFirma').getValue();
        objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
        objResultado.cadenaFirma='';
        
        var pos=existeValorArregloObjetos(registro.data.objConfirmaProceso.arrAcciones,'idAccion',objResultado.accion);
        var documentoFinal=registro.data.objConfirmaProceso.arrAcciones[pos].documentoFinal;
        
        objResultado.etapaCambio=registro.data.objConfirmaProceso.arrAcciones[pos].etapaEnvio;
       
        switch(parseInt(cmbAccionFirma.getValue()))
        {
            case 1://Fiel
                
                objResultado.cadenaFirma=''
                objResultado.funcionEjecucion='';
                
                var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+registro.data.idDocumento+
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
                
                $.ajax	({
                            url: "../paginasFunciones/procesarDocumentoFirmaElectronica.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            success: function(data)
                                    {
                                        
                                        var oResp=eval('['+data+']')[0];
                                        if(oResp.resultado=='1')
                                        {
                                            funcionFirmaRealizado(objResultado);
                                            
                                        }
                                        else
                                        {
                                            msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:<br><br>'+bD(oResp.mensaje));
                                        }
                                    }
                        });
                
                
                
            break;
            case 6: //Firel
                
                objResultado.cadenaFirma='';
                objResultado.funcionEjecucion='';
                
                
                
                var cadObj='{"documentoFinal":"'+documentoFinal+'","idRegistroFormato":"'+registro.data.idDocumento+
                        '","cadena":"'+objResultado.cadenaFirma+'","tipoFirma":"2"}';																
                
                
                var oObj=eval('['+cadObj+']')[0];
                
                
                var formData = new FormData();
                
                formData.append('passwd',AES_Encrypt(gEx('txtPasswordFirel').getValue()));
                
                
                for(var campo in oObj)
                {
                    formData.append(campo,oObj[campo]);
                }
                
                
                
                formData.append('fCer',gE('filePFX').files[0]);
               
                
                $.ajax	({
                            url: "../paginasFunciones/procesarDocumentoFirmaElectronica.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            success: function(data)
                                    {
                                       
                                        var oResp=eval('['+data+']')[0];
                                        if(oResp.resultado=='1')
                                        {
                                            funcionFirmaRealizado(objResultado);
                                            
                                        }
                                        else
                                        {
                                            msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:<br><br>'+bD(oResp.mensaje));
                                        }
                                    }
                        });
            break;
            case 4:
                gEx('lPorcentaje').show();
                swfDocumento.startUpload();
            break;
            default:
                funcionFirmaRealizado(objResultado);
               
            break;
        }
    }
    
}

function mostrarDocumento(idDocumento)
{
	window.parent.mostrarVisorDocumentoProceso('pdf',bD(idDocumento));
}

function funcionFirmaRealizado(o)  //{"accion":"","cadenaFirma":"","comentarios":""}
{
	if(typeof(o)=='string')
    	o=eval('['+o+']')[0];

	if(o.iT!='')
    {

        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {                      
               ejecutarProcesoFirma(objDocumentosConf.totalDocumentos,objDocumentosConf.documentoActual+1,objDocumentosConf.arrDocumentos,objDocumentosConf.arrDocumentos[objDocumentosConf.documentoActual]);
                
            }
            else
            {
                msgBox('No se ha podido realizar la operación debido al siguiente problema:'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=152&iT='+o.iT+'&iA='+o.iA,true);
	}
    else
    {
    	 ejecutarProcesoFirma(objDocumentosConf.totalDocumentos,objDocumentosConf.documentoActual+1,objDocumentosConf.arrDocumentos,objDocumentosConf.arrDocumentos[objDocumentosConf.documentoActual]);
    }
}

/*
function funcionFirmaRealizado(o)  
{
	if(typeof(o)=='string')
    	o=eval('['+o+']')[0];

	var cadObj='{"accionFirma":"'+o.accion+'","idFormulario":"'+registroFirmaActual.data.iFormulario+'","idRegistro":"'+registroFirmaActual.data.iRegistro+
    		'","comentario":"'+cv(o.comentarios)+'","etapa":"'+o.etapaCambio+'","actor":"'+registroFirmaActual.data.actor+'","cadenaFirma":"'+cv(o.cadenaFirma)+
                '","idRegistroAtencion":"'+registroFirmaActual.data.idRegistroAtencion+'","funcionEjecucion":"'+(o.funcionEjecucion?o.funcionEjecucion:'')+'"}';
    
                
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	ejecutarProcesoFirma(objDocumentosConf.totalDocumentos,objDocumentosConf.documentoActual+1,objDocumentosConf.arrDocumentos,objDocumentosConf.arrDocumentos[objDocumentosConf.documentoActual]);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=17&cadObj='+cadObj,false);
}*/


function mostrarVentanaFirmando()
{
	confMessage=	{
    					closable:false,
                        progress :true,
                        width:350,
                        title:'Firmando documentos...'
    				};
	msgBoxEspere=Ext.MessageBox.show(confMessage);
    
    
    
	
}

function ocultarVentanaFirmando()
{
	msgBoxEspere.hide();
    gEx('vDocumento').close();
}

function obtenerVersionCompletaDocumentos(iDocumento)
{
    var arrParametros=[['iDocumento',iDocumento]]
    enviarFormularioDatos('../modulosEspeciales_SGJP/obtenerDocumentoCompletoImpresion.php',arrParametros,'POST','frameDTD');
    primeraCargaFrame=false;
    
}

function frameLoad(iFrame)
{
	if(!primeraCargaFrame)
    {
    	setTimeout(function()
        			{
                       
                        iFrame.contentWindow.print();
                    },2000
                   );

    }
    else
    	primeraCargaFrame=false;
	
}

function abrirDocumentoEvaluacion(iD)
{
	var pos=obtenerPosFila(gEx('gDocumentosFirma').getStore(),'idRegistroAtencion',bD(iD));	
    var fila=gEx('gDocumentosFirma').getStore().getAt(pos);
    if(fila.data.idDocumentoPDF=='')
    {
    
    	var o=bE(convertirCadenaJson(fila.data.objDocumento));
        var oDoc=fila.data.objDocumento;
        
        if(oDoc.idFormulario>0)
        {
        	var cadObj='{"idFormulario":"'+oDoc.idFormulario+'","idRegistro":"'+oDoc.idRegistro+'","idRol":"'+oDoc.actorAccesoProceso+'"}';
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    abrirRegistroSolicitud(bE(oDoc.idFormulario),bE(oDoc.idRegistro),arrResp[1]);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=35&cadObj='+cadObj,true);
        	
        }
        else
        {
    		mostrarVentanaAperturaDocumento(o,bE(fila.data.objDocumento.idTarea),bE(fila.data.objDocumento.idTablero));
    	}
    }
    else
    {
    	var oDoc=fila.data.objDocumento;
        var o='{"idDocumentoFinal":"'+fila.data.idDocumentoPDF+'","idFormulario":"'+oDoc.idFormulario+'","idRegistro":"'+
                    oDoc.idRegistro+'","idRegistroFormato":"'+oDoc.idRegistroFormato+'","actorAccesoProceso":"'+oDoc.actorAccesoProceso+
                    '","idRegistroInformacionDocumento":"'+oDoc.idRegistroInformacionDocumento+'"}';
        mostrarVentanaDocumentoAutorizado(o,bE(fila.data.objDocumento.idTarea),bE(fila.data.objDocumento.idTablero));
		
    }
    
}

function mostrarTableroNotificaciones()
{
	gEx('gDocumentosFirma').getStore().reload();
}