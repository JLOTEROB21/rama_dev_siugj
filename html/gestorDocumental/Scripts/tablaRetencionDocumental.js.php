<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos ORDER BY nombreCategoria";
	$arrTipoDocumental=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idProceso,nombre FROM 4001_procesos WHERE idTipoProceso=4 ORDER BY nombre";
	$arrProcesos=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__637_tablaDinamica,nombreEspecialidadDespacho FROM _637_tablaDinamica ORDER BY nombreEspecialidadDespacho";
	$arEspecialidades=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica ORDER BY nombreTipoProceso";
	$arTiposProcesos=$con->obtenerFilasArreglo($consulta);

	$sL=0;
	if(!existeRol("'52_0'"))
	{
		$sL=1;
	}
?>
var sL=<?php echo $sL==1?"true":"false"; ?>;
var nodoSel=null;
var arTiposProcesos=<?php echo $arTiposProcesos?>;
var arEspecialidades=<?php echo $arEspecialidades?>;
var versionSel=-1;
var arrProcesos=<?php echo $arrProcesos?>;
var arrSeries=[];
var arrSubSeries=[];
var arrTipoDocumental=<?php echo $arrTipoDocumental?>;
var arrPeriodosRetencion=[['1','Dias'],['2','Meses'],['3','A\xF1os']];
var arrSituacionTRD=[['1','En dise&ntilde;o',null,'../images/pencil.png'],['2','Publicado',null,'../images/accept_green.png'],['3','Inactivo',null,'../images/cancel_round.png']];
Ext.onReady(inicializar);

function inicializar()
{
	Ext.QuickTips.init();
	versionSel=gE('ultimaVersion').value;
	arrProcesos.splice(0,0,['0','Ninguno']);
	
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                cls:'panelSiugj',
                                                title: 'Tabla de Retenci&oacute;n Documental',
                                                tbar:	[
                                                			{
                                                                id:'btnRegresar',
                                                                width:'140',
                                                                text:'Cancelar',
                                                                xtype:'button',
                                                                icon:'../images/salir.gif',
                                                                cls:'btnSIUGJCancel',
                                                                handler:function()
                                                                        {
                                                                           function  resp(btn)
                                                                            {
                                                                                if(btn=='yes')
                                                                                {
                                                                                    location.href='../gestorDocumental/tblTablasRetencionDocumental.php';
                                                                                }
                                                                            }
                                                                            msgConfirm('¿Est&aacute; seguro de querer salir?',resp)
                                                                        }
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:10
                                                            },
                                                            {
                                                                id:'btnGuardar',
                                                                width:'140',
                                                                text:'Guardar',
                                                                hidden:sL,
                                                                xtype:'button',
                                                                icon:'../images/guardar.JPG',
                                                                cls:'btnSIUGJ',
                                                                handler:function()
                                                                        { 
                                                                            var txtClaveTabla=gEx('txtClaveTabla');
                                                                            var txtNombreTabla=gEx('txtNombreTabla');
                                                                            var txtDescripcion=gEx('txtDescripcion');
                                                                            var cmbProcesoArchivoGestion=gEx('cmbProcesoArchivoGestion');
                                                                            var cmbProcesoArchivoCentral=gEx('cmbProcesoArchivoCentral');
                                                                            
                                                                            if(txtClaveTabla.getValue()=='')
                                                                            {
                                                                                function resp()
                                                                                {
                                                                                    txtClaveTabla.focus();
                                                                                }
                                                                                msgBox('Debe indicar la clave de la Tabla de Retenci&oacute;n',resp);
                                                                                return;
                                                                            }
                                                                            
                                                                            
                                                                            
                                                                            
                                                                             if(txtNombreTabla.getValue()=='')
                                                                            {
                                                                                function resp3()
                                                                                {
                                                                                    txtNombreTabla.focus();
                                                                                }
                                                                                msgBox('Debe indicar el nombre de la Tabla de Retenci&oacute;n',resp3);
                                                                                return;
                                                                            }
                                                                            
                                                                            var cadObj='{"idRegistro":"'+gE('idTablaRetencion').value+'","cveTabla":"'+cv(gEx('txtClaveTabla').getValue())+
                                                                                        '","version":"0","nombreTabla":"'+cv(gEx('txtNombreTabla').getValue())+
                                                                                        '","descripcion":"'+cv(gEx('txtDescripcion').getValue())+
                                                                                        '","procesoArchivoGestion":"'+cmbProcesoArchivoGestion.getValue()+
                                                                                        '","procesoArchivoCentral":"'+cmbProcesoArchivoCentral.getValue()+'"}';

                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                    function respAux()
                                                                                    {
                                                                                        gE('idTablaRetencion').value=arrResp[1];
                                                                                        gEx('tabTabla').unhideTabStripItem(1);
        																				gEx('tabTabla').unhideTabStripItem(2);
                                                                                    }
                                                                                    msgBox('La informaci&oacute;n ha sido guardada correctamente',respAux);   
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=1&cadObj='+cadObj,true);

                                                                        
                                                                        }
                                                                
                                                            }
                                                            
                                                             
                                                		],
                                                items:	[	
                                                			{
                                                            	region:'center',
                                                                height:180,
                                                                border:false,
                                                                id:'tabTabla',
                                                                defaultType: 'label',
                                                                xtype:'tabpanel',
                                                                listeners:	{
                                                                				tabchange:function(p,tab)
                                                                                            {
                                                                                            	if(tab.id=='panelVersiones')
                                                                                                {
                                                                                                	setTimeout(function()
                                                                                                    			{
                                                                                                                		
                                                                                                                        
                                                                                                                        var alto=(obtenerDimensionesNavegador()[0]-290)+'px'
                                                                                                                        
                                                                                                                        $('.x-grid3-scroller')[1].style.height=alto;

                                                                                                                        
                                                                                                                 }, 500);


                                                                                              		
                                                                                                }
                                                                                            }
                                                                			},
                                                                cls:'tabPanelSIUGJ',
                                                                activeTab:1,
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                layout:'absolute',
                                                                                title:'Datos Generales',
                                                                                defaultType: 'label',
                                                                                items:	[
                                                                                
                                                                                			
                                                                                            {
                                                                                                x:20,
                                                                                                y:20,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Folio de registro'
                                                                                            },
                                                                                            {
                                                                                                x:20,
                                                                                                y:50,
                                                                                                cls:'SIUGJ_Control_Azul',
                                                                                                id:'lblFolioRegistro',
                                                                                                html:'POR ASIGNAR'
                                                                                            },
                                                                                            {
                                                                                                x:500,
                                                                                                y:20,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Fecha de registro'
                                                                                            },
                                                                                            
                                                                                            
                                                                                            {
                                                                                                x:500,
                                                                                                y:50,
                                                                                                cls:'SIUGJ_Control_Azul',
                                                                                                id:'lblFechaRegistro',
                                                                                                html:'POR ASIGNAR'
                                                                                            },
                                                                                            
                                                                                            
                                                                                			{
                                                                                                x:20,
                                                                                                y:120,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Cve. de la TRD: <span style="color:#F00">*</span>'
                                                                                            },
                                                                                            {
                                                                                                x:20,
                                                                                                y:150,
                                                                                                width:250,
                                                                                                readOnly:sL,
                                                                                                cls:'controlSIUGJ',
                                                                                                xtype:'textfield',
                                                                                                id:'txtClaveTabla'
                
                                                                                            },
                                                                                            
                                                                                            {
                                                                                                x:610,
                                                                                                y:115,
                                                                                                width:80,
                                                                                                hidden:true,
                                                                                                value:'0',
                                                                                                xtype:'textfield',
                                                                                                id:'txtVersion'
                
                                                                                            },
                                                                                            {
                                                                                                x:500,
                                                                                                y:120,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'T&iacute;tulo de la TRD: <span style="color:#F00">*</span>'
                                                                                            },
                                                                                            {
                                                                                                x:500,
                                                                                                y:150,
                                                                                                width:400,
                                                                                                readOnly:sL,
                                                                                                cls:'controlSIUGJ',
                                                                                                xtype:'textfield',
                                                                                                id:'txtNombreTabla'
                
                                                                                            },
                                                                                            {
                                                                                                x:20,
                                                                                                y:220,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Descripci&oacute;n de la TRD: <span style="color:#F00"></span>'
                                                                                            },
                                                                                            {
                                                                                                x:20,
                                                                                                y:250,
                                                                                                width:470,
                                                                                                height:70,
                                                                                                readOnly:sL,
                                                                                                cls:'controlSIUGJ',
                                                                                                xtype:'textarea',
                                                                                                id:'txtDescripcion'
                
                                                                                            }
                                                                                            
                                                                                            
                                                                                            
                                                			
                                                            
                                                                                		]
                                                                            },
                                                                            {
                                                                            	xtype:'panel',
                                                                                layout:'border',
                                                                                id:'panelVersiones',
                                                                                title:'Versiones',
                                                                                items:	[
                                                                                			{
                                                                                                layout:'border',
                                                                                                collapsible:true,
                                                                                                region:'west',
                                                                                                border:true,
                                                                                                width:350,
                                                                                                items:	[
                                                                                                			crearGridVersiones()
                                                                                                        ]
                                                                                            },
                                                                                            {
                                                                                            	layout:'border',
                                                                                                region:'center',
                                                                                                border:false,
                                                                                                items:	[
                                                                                                			crearGridRegistrosTRDs()
                                                                                                		]
                                                                                            }
                                                                                            
                                                                                		]
                                                                            },
                                                                            {
                                                                            	xtype:'panel',
                                                                                layout:'absolute',
                                                                                title:'Procesos Asociados',
                                                                                defaultType: 'label',
                                                                                items:	[
                                                                                            {
                                                                                            	x:20,
                                                                                                y:20,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Proceso a arrancar al conclu&iacute;r el tiempo de retenci&oacute;n en Archivo de Gesti&oacute;n:'
                                                                                            },
                                                                                            {	
                                                                                            	x:670,
                                                                                                y:15,
                                                                                                html:'<div id="spProceso1"></div>'
                                                                                            },
                                                                                            {
                                                                                            	x:20,
                                                                                                y:70,
                                                                                                cls:'SIUGJ_Etiqueta',
                                                                                                html:'Proceso a arrancar al conclu&iacute;r el tiempo de retenci&oacute;n en Archivo Central:'
                                                                                            },
                                                                                             {	
                                                                                            	x:670,
                                                                                                y:65,
                                                                                                html:'<div id="spProceso2"></div>'
                                                                                            }
                                                                                            
                                                                                			
                                                			
                                                            
                                                                                		]
                                                                            }
                                                                            
                                                                		]
                                                            }
                                                        ]
                                            }
                                         ]
                            }
                        )   

	gEx('tabTabla').setActiveTab(2);
	var cmbProcesoArchivoGestion=crearComboExt('cmbProcesoArchivoGestion',arrProcesos,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spProceso1'});
    cmbProcesoArchivoGestion.setValue('0');
    
    
    
    var cmbProcesoArchivoCentral=crearComboExt('cmbProcesoArchivoCentral',arrProcesos,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spProceso2'});
    cmbProcesoArchivoCentral.setValue('0');
	
    if(sL)
    {
    	cmbProcesoArchivoGestion.disable();
        cmbProcesoArchivoCentral.disable();
    }


	gEx('tabTabla').setActiveTab(0);

	var objInfo=eval(bD(gE('objInfo').value));
    if(objInfo.length>0)
    {
    	objInfo=objInfo[0];
    	var txtClaveTabla=gEx('txtClaveTabla');
        txtClaveTabla.setValue(objInfo.cveTabla);
        var txtVersion=gEx('txtVersion');
        txtVersion.setValue(objInfo.version);
        var txtNombreTabla=gEx('txtNombreTabla');
        txtNombreTabla.setValue(objInfo.nombreTabla);
        var txtDescripcion=gEx('txtDescripcion');
        txtDescripcion.setValue(escaparBR(objInfo.descripcion));
    	gEx('gRegistrosTRDs').enable();
        
        
        cmbProcesoArchivoGestion.setValue(objInfo.procesoArchivoGestion);
    	cmbProcesoArchivoCentral.setValue(objInfo.procesoArchivoCentral);
        gEx('lblFechaRegistro').setText(Date.parseDate(objInfo.fechaCreacion,'Y-m-d H:i:s').format('d/m/Y H:i:s'),false);
        gEx('lblFolioRegistro').setText(objInfo.folioRegistro,false);
    }
    
    gEx('txtClaveTabla').focus(false,500);
	
    
   if(gE('idTablaRetencion').value=='-1')                  
   {
   		gEx('tabTabla').hideTabStripItem(1);
        gEx('tabTabla').hideTabStripItem(2);
   }
	
    
   
	
}

function crearGridRegistrosTRDs()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'idSerie'},
		                                                {name:'idSubSerie'},
                                                        {name: 'cveSerie'},
		                                                {name:'cveSubSerie'},
		                                                {name: 'tipoDocumento'},
                                                        {name: 'soporteFisico'},
                                                        {name:'soporteElectronico'},
                                                        {name:'retencionArchivoGestion'},
                                                        {name: 'unidadRetencionArchivoGestion'},
                                                        {name: 'retencionArchivoCentral'},
                                                        {name:'unidadRetencionArchivoCentral'},
                                                        {name:'conservacionTotal'},
                                                        {name: 'eliminacion'},                                                        
                                                        {name: 'microfilmacionDigitalizacion'},
                                                        {name:'seleccion'},
                                                        {name: 'arrTiposProcesos'},
                                                        {name:'procedimiento'},
                                                        {name: 'tipoElemento'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesGestorDocumental.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'tipoDocumento', direction: 'ASC'},
                                                            groupField: 'tipoDocumento',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='3';
                                        proxy.baseParams.idTablaRetencion=gE('idTablaRetencion').value;
                                        gEx('btnEditarRegistro').disable();
                                    }
                        )   
    
    
    alDatos.on('load',function(proxy)
    								{
                                    	arrSeries=proxy.reader.jsonData.arrSeries;
                                        var totalDespachos=proxy.reader.jsonData.totalDespachos;
                                        
                                        var lblOficinas='';
                                        if(totalDespachos=='1')
                                        {
                                        	lblOficinas='1 oficina productora asociada';
                                        }
                                        else
                                        {
                                        	lblOficinas=totalDespachos+' oficinas productoras asociadas';
                                        }
                                        
                                        gEx('btnDespachosAsociados').setText(lblOficinas);

                                    }
                        ) 
      
       
	
	var cabecera = new Ext.ux.grid.ColumnHeaderGroup	(
                                                            {
                                                                rows: 	[
                                                                			[
                                                                                {header: '', colspan: 2, align: 'center'},
                                                                                {header: 'C&oacute;digo', colspan: 2, align: 'center'},
                                                                                {header: '', colspan: 1, align: 'center'},
                                                                                {header: 'Soporte', colspan: 2, align: 'center'},
                                                                                {header: 'Tiempo Retenci&oacute;n', colspan: 4, align: 'center'},
                                                                                {header: 'Disposici&oacute;n Final', colspan: 4, align: 'center'},
                                                                                {header: '', colspan: 1, align: 'center'}
																			]                                                                            
                                                                        ]
                                                            }
                                                        );

  
  
  var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly:true,singleSelect:true,width:40});
  
   var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:60}),
                                                            chkRow,
                                                            
                                                            {
                                                                header:'Serie',
                                                                width:80,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'cveSerie',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(registro.data.tipoElemento!='3')
                                                                            {
                                                                            	return val;
                                                                            }
                                                                           	
                                                                        }
                                                            },
                                                            {
                                                                header:'Subserie',
                                                                 width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'cveSubSerie',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(registro.data.tipoElemento!='3')
                                                                            {
                                                                            	return val;
                                                                            }
                                                                           	
                                                                        }
                                                            },
                                                            {
                                                                header:'Series, Subseries, Tipos Documentales',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'tipoDocumento',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(registro.data.tipoElemento=='3')
                                                                            {
                                                                            	return formatearValorRenderer(arrTipoDocumental,val);
                                                                            }
                                                                           	return val;
                                                                        }
                                                            },
                                                            {
                                                                header:'F&iacute;sico',
                                                                width:90,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'soporteFisico',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
                                                                            	return 'X';
                                                                        }
                                                            }
                                                            
                                                            ,
                                                            
                                                             {
                                                                header:'Electr&oacute;nico',
                                                                width:110,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'soporteElectronico',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
                                                                            	return 'X';
                                                                        }
                                                            }
                                                            ,
                                                            {
                                                                header:'Archivo Gesti&oacute;n',
                                                                width:140,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'retencionArchivoGestion'
                                                            },
                                                            {
                                                                header:'Unidad Tiempo',
                                                                width:140,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'unidadRetencionArchivoGestion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrPeriodosRetencion,val);
                                                                        }
                                                            },
                                                             {
                                                                header:'Archivo Central',
                                                                width:140,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'retencionArchivoCentral'
                                                            },
                                                            {
                                                                header:'Unidad Tiempo',
                                                                width:140,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'unidadRetencionArchivoCentral',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrPeriodosRetencion,val);
                                                                        }
                                                            },
                                                             {
                                                                header:'CT',
                                                                width:60,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'conservacionTotal',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
                                                                            	return 'X';
                                                                        }
                                                            }
                                                            
                                                            ,
                                                            {
                                                                header:'E',
                                                                width:60,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'eliminacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
                                                                            	return 'X';
                                                                        }
                                                            },
                                                            {
                                                                header:'MT',
                                                                width:60,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'microfilmacionDigitalizacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
                                                                            	return 'X';
                                                                        }
                                                            },
                                                            {
                                                                header:'S',
                                                                width:60,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'seleccion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
                                                                            	return 'X';
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Procedimiento',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'procedimiento'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gRegistrosTRDs',
                                                                store:alDatos,
                                                                
                                                                cls:'gridSiugjPrincipal',
                                                                region:'center',
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:sL,
                                                                                text:'Agregar...',
                                                                                menu:	[
                                                                                			{
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Serie',
                                                                                                handler:function()
                                                                                                        {	
                                                                                                        	
                                                                                                            mostrarVentanaSerie();
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            {
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Subserie',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaSubSerie();
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            {
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Tipo Documental',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaTipoDocumental()
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                
                                                                                		]
                                                                                
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                hidden:sL,
                                                                                width:15
                                                                            },
                                                                            {
                                                                            	id:'btnEditarRegistro',
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:sL,
                                                                                text:'Editar Registro de TRD',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el registro de TRD que desea editar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            switch(fila.data.tipoElemento)
                                                                                            {
                                                                                            	case '1':
                                                                                                	mostrarVentanaSerie(fila);
                                                                                                break;
                                                                                                case '2':
                                                                                                	mostrarVentanaSubSerie(fila);
                                                                                                break;
                                                                                                case '3':
                                                                                                	mostrarVentanaTipoDocumental(fila);
                                                                                                break;
                                                                                            }
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                            
                                                                            ,{
                                                                                xtype:'tbspacer',
                                                                                hidden:sL,
                                                                                width:15
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:sL,
                                                                                text:'Remover Registro de TRD',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                                msgBox('Debe seleccionar el registro de TRD que desea remover');
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            var cadObj='{"idRegistro":"'+fila.data.idRegistro+'","tipoElemento":"'+fila.data.tipoElemento+'"}';
                                                                                            
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
                                                                                                            obtenerRegistrosTRD();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=4&cadObj='+cadObj,true);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el elemento seleccionado?',resp);
                                                                                            
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                hidden:sL,
                                                                                width:15
                                                                            },
                                                                            {
                                                                                icon:'../images/users.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnDespachosAsociados',
                                                                                text:'0 unidades productoras asociadas',
                                                                                handler:function()
                                                                                        {
                                                                                           mostrarVentanaDespachosAsociadosTRD();
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                		],
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                sm:chkRow,
                                                                columnLines : false,
                                                                listeners:	{
                                                                				
                                                                                render:function()
                                                                                	{
                                                                                    	
                                                                                    }
                                                                			},
                                                                plugins:	[
                                                                				cabecera
                                                                                
                                                                			]
                                                            }
                                                        );
	
    tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
    											{
                                                	gEx('btnEditarRegistro').enable();
                                                }
    								)
     tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
    											{
                                                	gEx('btnEditarRegistro').disable();
                                                }
    								)
    
    return 	tblGrid;	
}

function mostrarVentanaSerie(fila)
{
	if(versionSel=='-1')
    {
    	msgBox('Primero debe crear una versi&oacute;n de la TRD');
    	return;
    }
	var cmbPeriodoArchivoGestion=null;
    var cmbPeriodoArchivoCentral=null;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            activeTab:0,
                                                            cls:'tabPanelSIUGJ',
                                                            items:	[
                                                            			{
                                                                        	title:'General',
                                                                            defaultType: 'label',
                                                                            layout:'absolute',
                                                                        	items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Cve. Serie: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            x:180,
                                                                                            y:5,
                                                                                            xtype:'textfield',
                                                                                            width:80,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtCveSerie'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:50,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'T&iacute;titulo de la Serie: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            x:180,
                                                                                            y:45,
                                                                                            xtype:'textfield',
                                                                                            width:550,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtTituloSerie'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:90,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Soporte:'
                                                                                        },	
                                                                                        {
                                                                                            x:180,
                                                                                            y:85,
                                                                                            id:'chkSoporteGroup',
                                                                                            width:250,
                                                                                            xtype:'checkboxgroup',
                                                                                            items: [
                                                                                                {boxLabel: 'F&iacute;sico', name: 'rdoSoporte', inputValue: 1, ctCls:'controlSIUGJ'},
                                                                                                {boxLabel: 'Electr&oacute;nico', name: 'rdoSoporte', inputValue: 2, ctCls:'controlSIUGJ'}
                                                                                                ]
                                                                                        },
                                                                                        {
                                                                                            x:0,
                                                                                            y:130,
                                                                                            xtype:'fieldset',
                                                                                            width:700,
                                                                                            cls:'x-fieldsetSIUGJ',
                                                                                            height:125,
                                                                                            layout:'absolute',
                                                                                            defaultType: 'label',
                                                                                            title:'Tiempo de retenci&oacute;n:',
                                                                                            items:	[
                                                                                                        {
                                                                                                            x:10,
                                                                                                            y:10,
                                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                                            html:'Archivo Gesti&oacute;n:'
                                                                                                        },
                                                                                                        {
                                                                                                            x:180,
                                                                                                            y:5,
                                                                                                            width:50,
                                                                                                            xtype:'numberfield',
                                                                                                            cls:'controlSIUGJ',
                                                                                                            id:'txtTiempoRetencionArchivoGestion',
                                                                                                            allowDecimals:false,
                                                                                                            allowNegative:false
                                                                                                        },
                                                                                                        {
                                                                                                            x:240,
                                                                                                            y:0,
                                                                                                            html:'<div id="divArchivoGestion"></div>'
                                                                                                        },
                                                                                                        {
                                                                                                            x:10,
                                                                                                            y:50,
                                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                                            html:'Archivo Central:'
                                                                                                        },
                                                                                                        
                                                                                                         {
                                                                                                            x:180,
                                                                                                            y:45,
                                                                                                            width:50,
                                                                                                            cls:'controlSIUGJ',
                                                                                                            xtype:'numberfield',
                                                                                                            id:'txtTiempoRetencionArchivoCentral',
                                                                                                            allowDecimals:false,
                                                                                                            allowNegative:false
                                                                                                        },
                                                                                                        {
                                                                                                            x:240,
                                                                                                            y:45,
                                                                                                            html:'<div id="divArchivoCentral"></div>'
                                                                                                        }
                                                                                                	]
                                                                                        },	
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:290,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Disposici&oacute;n Final:'
                                                                                        },	
                                                                                        {
                                                                                            x:180,
                                                                                            y:285,
                                                                                            id:'rdoDiposicionGroup',
                                                                                            width:500,
                                                                                            xtype:'radiogroup',
                                                                                            items: [
                                                                                                {boxLabel: 'CT', name: 'rdoDisposicion', inputValue: 1, ctCls:'controlSIUGJ'},
                                                                                                {boxLabel: 'E', name: 'rdoDisposicion', inputValue: 2, ctCls:'controlSIUGJ'},
                                                                                                {boxLabel: 'MT', name: 'rdoDisposicion', inputValue: 3, ctCls:'controlSIUGJ'},
                                                                                                {boxLabel: 'S', name: 'rdoDisposicion', inputValue: 4, ctCls:'controlSIUGJ'},
                                                                                                {boxLabel: '(Ninguno)', name: 'rdoDisposicion', inputValue: 0, ctCls:'controlSIUGJ'}
                                                                                                ]
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:330,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Procedimiento:'
                                                                                        },
                                                                                        {
                                                                                            x:180,
                                                                                            y:325,
                                                                                            id:'txtProcedimiento',
                                                                                            xtype:'textarea',
                                                                                            cls:'controlSIUGJ',
                                                                                            width:550,
                                                                                            height:50,
                                                                                        }
                                                                            		]
                                                                        },
                                                                        {
                                                                        	title:'Tipos de proceso asociados',
                                                                            defaultType: 'label',
                                                                            layout:'border',
                                                                            items:	[
                                                                            			crearGridSubserie(fila)
                                                                            		]
                                                                        }
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Serie',
										width: 880,
										height:540,
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
                                                                	gEx('txtCveSerie').focus(false,500);
                                                                    cmbPeriodoArchivoGestion=crearComboExt('cmbPeriodoArchivoGestion',arrPeriodosRetencion,0,0,110,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divArchivoGestion'});
    																cmbPeriodoArchivoCentral=crearComboExt('cmbPeriodoArchivoCentral',arrPeriodosRetencion,0,0,110,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divArchivoCentral'});
                                                                    if(fila)
                                                                    {
                                                                        var txtCveSerie=gEx('txtCveSerie');
                                                                        var txtTituloSerie=gEx('txtTituloSerie');
                                                                        var chkSoporteGroup=gEx('chkSoporteGroup');
                                                                        var txtTiempoRetencionArchivoGestion=gEx('txtTiempoRetencionArchivoGestion');
                                                                        var cmbPeriodoArchivoGestion=gEx('cmbPeriodoArchivoGestion');
                                                                        var txtTiempoRetencionArchivoCentral=gEx('txtTiempoRetencionArchivoCentral');
                                                                        var cmbPeriodoArchivoCentral=gEx('cmbPeriodoArchivoCentral');
                                                                        var rdoDiposicionGroup=gEx('rdoDiposicionGroup');
                                                                        var txtProcedimiento=gEx('txtProcedimiento');
                                                                        console.log(fila);
                                                                        
                                                                        txtCveSerie.setValue(fila.data.cveSerie);
                                                                        txtTituloSerie.setValue(fila.data.tipoDocumento);
                                                                        
                                                                        if(fila.data.conservacionTotal)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(1);
                                                                        }
                                                                         if(fila.data.eliminacion)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(2);
                                                                        }
                                                                         if(fila.data.microfilmacionDigitalizacion)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(3);
                                                                        }
                                                                         if(fila.data.seleccion)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(4);
                                                                        }
                                                                        
                                                                        chkSoporteGroup.setValue([fila.data.soporteFisico,fila.data.soporteElectronico]);
                                                                        txtTiempoRetencionArchivoGestion.setValue(fila.data.retencionArchivoGestion);
                                                                        cmbPeriodoArchivoGestion.setValue(fila.data.unidadRetencionArchivoGestion);
                                                                        txtTiempoRetencionArchivoCentral.setValue(fila.data.retencionArchivoCentral);
                                                                        cmbPeriodoArchivoCentral.setValue(fila.data.unidadRetencionArchivoCentral);
                                                                        //rdoDiposicionGroup.setValue(fila.data.cveSubSerie);
                                                                        txtProcedimiento.setValue(fila.data.procedimiento);
                                                                        
                                                                    }	
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var idRegistro=fila?fila.data.idRegistro:-1;
                                                                    	var txtCveSerie=gEx('txtCveSerie');
                                                                        
                                                                        if(txtCveSerie.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtCveSerie.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la clave de la serie',resp)
                                                                            return;
                                                                        }
                                                                        
                                                                        var txtTituloSerie=gEx('txtTituloSerie');
                                                                        
                                                                        
                                                                        if(txtTituloSerie.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtTituloSerie.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el t&iacute;tutlo de la serie',resp2)
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        var gRegistrosTRDs=gEx('gRegistrosTRDs');
                                                                        var x;
                                                                        var filaTRD;
                                                                        for(x=0;x<gRegistrosTRDs.getStore().getCount();x++)
                                                                        {
                                                                            filaTRD=gRegistrosTRDs.getStore().getAt(x);
                                                                            
                                                                            if(filaTRD.data.tipoElemento=='1')
                                                                            {
                                                                                
                                                                                if(
                                                                                	(filaTRD.data.cveSerie.toLowerCase()==txtCveSerie.getValue().toLowerCase())&&
                                                                                	//(filaTRD.data.tipoDocumento.toLowerCase()==txtTituloSerie.getValue().toLowerCase())&&
                                                                                    (filaTRD.data.idRegistro!=idRegistro)
                                                                                  )
                                                                                {
                                                                                	
                                                                                    function resp()
                                                                                    {
                                                                                        txtCveSerie.focus();
                                                                                    }
                                                                                    msgBox('La clave de serie que intenta agregar ya existe en la presente TRD',resp);
                                                                                    return;
                                                                                }

                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        var chkSoporteGroup=gEx('chkSoporteGroup');
                                                                        
                                                                        var aSoporte=chkSoporteGroup.getValue();
                                                                        
                                                                        var arrSoporte='';
                                                                        
                                                                        if(aSoporte)
                                                                        {
                                                                            var x;
                                                                            var o;
                                                                            for(x=0;x<aSoporte.length;x++)
                                                                            {
                                                                                
                                                                                o=aSoporte[x];
                                                                                if(arrSoporte=='')
                                                                                    arrSoporte=o.inputValue;
                                                                                else
                                                                                    arrSoporte+=','+o.inputValue;
                                                                                
                                                                            }
																		}                                                                        
                                                                        var txtTiempoRetencionArchivoGestion=gEx('txtTiempoRetencionArchivoGestion');
                                                                        var cmbPeriodoArchivoGestion=gEx('cmbPeriodoArchivoGestion');
                                                                        
                                                                        var txtTiempoRetencionArchivoCentral=gEx('txtTiempoRetencionArchivoCentral');
                                                                        var cmbPeriodoArchivoCentral=gEx('cmbPeriodoArchivoCentral');
                                                                        
                                                                        
                                                                        if(txtTiempoRetencionArchivoGestion.getValue()=='')
                                                                        {
                                                                        	cmbPeriodoArchivoGestion.setValue('');
                                                                            
                                                                        }
                                                                        
                                                                        if(txtTiempoRetencionArchivoCentral.getValue()=='')
                                                                        {
                                                                        	cmbPeriodoArchivoCentral.setValue('');
                                                                            
                                                                        }
                                                                        
                                                                       
                                                                        
                                                                        var rdoDiposicionGroup=gEx('rdoDiposicionGroup');
                                                                        var aDisposicion=rdoDiposicionGroup.getValue();
                                                                        
                                                                        var disposicionFinal='';
                                                                        var arrDisposicion='';
                                                                        var x;
                                                                        var o;
                                                                        if(aDisposicion)
                                                                        {
                                                                        	disposicionFinal=aDisposicion.inputValue;
																		}                                                                        
                                                                        
                                                                        var txtProcedimiento=gEx('txtProcedimiento');
                                                                        
                                                                        var gTipoProcesoAppend=gEx('gTipoProcesoAppend');
                                                                        
                                                                        
                                                                        var arrTipoProcesos='';
                                                                        var filaTipoProceso;
                                                                        var x;
                                                                        for(x=0;x<gTipoProcesoAppend.getStore().getCount();x++)
                                                                        {
                                                                        	filaTipoProceso=gTipoProcesoAppend.getStore().getAt(x);
                                                                            if(arrTipoProcesos=='')
                                                                            	arrTipoProcesos=filaTipoProceso.data.idTipoProceso;
                                                                            else
                                                                            	arrTipoProcesos+=','+filaTipoProceso.data.idTipoProceso;
                                                                            
                                                                            
                                                                        }
                                                                        
																		var cadObj='{"cveElemento":"'+cv(txtCveSerie.getValue())+'","tituloElemento":"'+cv(txtTituloSerie.getValue())+'","soporte":"'+arrSoporte+
                                                                        		'","tRetencionGestion":"'+txtTiempoRetencionArchivoGestion.getValue()+'","pRetencionGestion":"'+cmbPeriodoArchivoGestion.getValue()+
                                                                                '","tRetencionCentral":"'+txtTiempoRetencionArchivoCentral.getValue()+
                                                                                '","pRetencionCentral":"'+cmbPeriodoArchivoCentral.getValue()+
                                                                                '","disposicionFinal":"'+disposicionFinal+'","procedimiento":"'+cv(gEx('txtProcedimiento').getValue())+
                                                                                '","idRegistro":"'+idRegistro+'","tipoRegistro":"1","idTablaRetencion":"'+
                                                                                gE('idTablaRetencion').value+'","version":"'+versionSel+'","arrTipoProcesos":"'+arrTipoProcesos+'"}';
																		
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	obtenerRegistrosTRD();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);

                                                                        
                                                                    	
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();
    
    
    
}

function mostrarVentanaSubSerie(fila)
{
	if(versionSel=='-1')
    {
    	msgBox('Primero debe crear una versi&oacute;n de la TRD');
    	return;
    }
	var cmbSerie;
	var cmbPeriodoArchivoGestion;
    var cmbPeriodoArchivoCentral;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            activeTab:0,
                                                            cls:'tabPanelSIUGJ',
                                                            items:	[
                                                            			{
                                                                        	title:'General',
                                                                            defaultType: 'label',
                                                                            layout:'absolute',
                                                                        	items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Serie: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            x:230,
                                                                                            y:0,
                                                                                            html:'<div id="divSerie"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:50,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Cve. Sub Serie: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            x:230,
                                                                                            y:45,
                                                                                            xtype:'textfield',
                                                                                            width:80,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtSubSerie'
                                                                                        },
                                                                                        
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:90,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'T&iacute;titulo de la Sub Serie: <span style="color:#F00">*</span>'
                                                                                        },
                                                                                        {
                                                                                            x:230,
                                                                                            y:85,
                                                                                            xtype:'textfield',
                                                                                            width:550,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtTituloSerie'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:130,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Soporte:'
                                                                                        },	
                                                                                        {
                                                                                            x:230,
                                                                                            y:125,
                                                                                            id:'chkSoporteGroup',
                                                                                            width:250,
                                                                                            xtype:'checkboxgroup',
                                                                                            items: [
                                                                                                        {boxLabel: 'F&iacute;sico', name: 'rdoSoporte', inputValue: 1,ctCls:'controlSIUGJ'},
                                                                                                        {boxLabel: 'Electr&oacute;nico', name: 'rdoSoporte', inputValue: 2,ctCls:'controlSIUGJ'}
                                                                                                    ]
                                                                                        },
                                                                                        {
                                                                                            x:30,
                                                                                            y:160,
                                                                                            xtype:'fieldset',
                                                                                            width:700,
                                                                                            cls:'x-fieldsetSIUGJ',
                                                                                            height:125,
                                                                                            layout:'absolute',
                                                                                            defaultType: 'label',
                                                                                            title:'Tiempos de retenci&oacute;n',
                                                                                            items:	[
                                                                                                        {
                                                                                                            x:10,
                                                                                                            y:10,
                                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                                            html:'Archivo Gesti&oacute;n:'
                                                                                                        },
                                                                                                        {
                                                                                                            x:180,
                                                                                                            y:5,
                                                                                                            width:50,
                                                                                                            cls:'controlSIUGJ',
                                                                                                            xtype:'numberfield',
                                                                                                            id:'txtTiempoRetencionArchivoGestion',
                                                                                                            allowDecimals:false,
                                                                                                            allowNegative:false
                                                                                                        },
                                                                                                        {
                                                                                                            x:240,
                                                                                                            y:0,
                                                                                                            html:'<div id="divArchivoGestion"></div>'
                                                                                                        },
                                                                                                        {
                                                                                                            x:10,
                                                                                                            y:55,
                                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                                            html:'Archivo Central:'
                                                                                                        },
                                                                                                        
                                                                                                         {
                                                                                                            x:180,
                                                                                                            y:50,
                                                                                                            width:50,
                                                                                                            cls:'controlSIUGJ',
                                                                                                            xtype:'numberfield',
                                                                                                            id:'txtTiempoRetencionArchivoCentral',
                                                                                                            allowDecimals:false,
                                                                                                            allowNegative:false
                                                                                                        },
                                                                                                        {
                                                                                                            x:240,
                                                                                                            y:45,
                                                                                                            html:'<div id="divArchivoCentral"></div>'
                                                                                                        }
                                                                                                    ]
                                                                                        },	
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:295,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Disposici&oacute;n Final:'
                                                                                        },	
                                                                                        {
                                                                                            x:230,
                                                                                            y:290,
                                                                                            id:'rdoDiposicionGroup',
                                                                                            width:500,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            xtype:'radiogroup',
                                                                                            items: [
                                                                                                        {boxLabel: 'CT', name: 'rdoDisposicion', inputValue: 1,ctCls:'controlSIUGJ'},
                                                                                                        {boxLabel: 'E', name: 'rdoDisposicion', inputValue: 2,ctCls:'controlSIUGJ'},
                                                                                                        {boxLabel: 'MT', name: 'rdoDisposicion', inputValue: 3,ctCls:'controlSIUGJ'},
                                                                                                        {boxLabel: 'S', name: 'rdoDisposicion', inputValue: 4,ctCls:'controlSIUGJ'},
                                                                                                        {boxLabel: '(Ninguno)', name: 'rdoDisposicion', inputValue: 0,ctCls:'controlSIUGJ'}
                                                                                                    ]
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:330,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Procedimiento:'
                                                                                        },
                                                                                        {
                                                                                            x:230,
                                                                                            y:325,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtProcedimiento',
                                                                                            xtype:'textarea',
                                                                                            width:550,
                                                                                            height:50,
                                                                                        }
                                                                            		]
                                                                        },
                                                                        {
                                                                        	title:'Tipos de proceso asociados',
                                                                            defaultType: 'label',
                                                                            layout:'border',
                                                                            items:	[
                                                                            			crearGridSubserie(fila)
                                                                            		]
                                                                        }
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Sub Serie',
										width: 880,
										height:540,
										layout: 'fit',
										plain:true,
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
	                                                               	cmbSerie=crearComboExt('cmbSerie',arrSeries,0,0,550,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divSerie'});
                                                                
                                                                	cmbSerie.focus(false,500);
                                                                    
                                                                    
                                                                    cmbPeriodoArchivoGestion=crearComboExt('cmbPeriodoArchivoGestion',arrPeriodosRetencion,0,0,110,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divArchivoGestion'});
    																cmbPeriodoArchivoCentral=crearComboExt('cmbPeriodoArchivoCentral',arrPeriodosRetencion,0,0,110,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divArchivoCentral'});
                                                                    
																	
                                                                    if(fila)
                                                                    {
                                                                        var cmbSerie=gEx('cmbSerie');
                                                                        var txtSubSerie=gEx('txtSubSerie');
                                                                        var txtTituloSerie=gEx('txtTituloSerie');
                                                                        var chkSoporteGroup=gEx('chkSoporteGroup');
                                                                        var txtTiempoRetencionArchivoGestion=gEx('txtTiempoRetencionArchivoGestion');
                                                                        var cmbPeriodoArchivoGestion=gEx('cmbPeriodoArchivoGestion');
                                                                        var txtTiempoRetencionArchivoCentral=gEx('txtTiempoRetencionArchivoCentral');
                                                                        var cmbPeriodoArchivoCentral=gEx('cmbPeriodoArchivoCentral');
                                                                        var rdoDiposicionGroup=gEx('rdoDiposicionGroup');
                                                                        var txtProcedimiento=gEx('txtProcedimiento');
                                                                
                                                                        cmbSerie.setValue(fila.data.idSerie);
                                                                        txtSubSerie.setValue(fila.data.cveSubSerie);
                                                                        txtTituloSerie.setValue(fila.data.tipoDocumento);
                                                                        
                                                                        if(fila.data.conservacionTotal)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(1);
                                                                        }
                                                                         if(fila.data.eliminacion)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(2);
                                                                        }
                                                                         if(fila.data.microfilmacionDigitalizacion)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(3);
                                                                        }
                                                                         if(fila.data.seleccion)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(4);
                                                                        }
                                                                        
                                                                        chkSoporteGroup.setValue([fila.data.soporteFisico,fila.data.soporteElectronico]);
                                                                        txtTiempoRetencionArchivoGestion.setValue(fila.data.retencionArchivoGestion);
                                                                        cmbPeriodoArchivoGestion.setValue(fila.data.unidadRetencionArchivoGestion);
                                                                        txtTiempoRetencionArchivoCentral.setValue(fila.data.retencionArchivoCentral);
                                                                        cmbPeriodoArchivoCentral.setValue(fila.data.unidadRetencionArchivoCentral);
                                                                       
                                                                        txtProcedimiento.setValue(escaparBR(fila.data.procedimiento));
                                                                        
                                                                    }
                                                                    else
                                                                    {
                                                                        var gRegistrosTRDs=gEx('gRegistrosTRDs');
                                                                        var fSeleccionada=gRegistrosTRDs.getSelectionModel().getSelected();
                                                                        
                                                                        if((fSeleccionada)&&(fSeleccionada.data.tipoElemento=='1'))
                                                                        {
                                                                            var cmbSerie=gEx('cmbSerie');
                                                                            cmbSerie.setValue(fSeleccionada.data.idRegistro);
                                                                        }
                                                                    }
                                                                
                                                                }
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var idRegistro=fila?fila.data.idRegistro:-1;
                                                                    	var txtSubSerie=gEx('txtSubSerie');
                                                                        
                                                                        var cmbSerie=gEx('cmbSerie');
                                                                        
                                                                        
                                                                        if(cmbSerie.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbSerie.focus();
                                                                            }
                                                                            msgBox('Debe indicar la serie a la cual pertenece la subserie',resp)
                                                                            return;
                                                                        }
                                                                        
                                                                        var txtTituloSerie=gEx('txtTituloSerie');
                                                                        
                                                                        
                                                                        if(txtTituloSerie.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtTituloSerie.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el t&iacute;tutlo de la serie',resp2)
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var gRegistrosTRDs=gEx('gRegistrosTRDs');
                                                                        var x;
                                                                        var filaTRD;
                                                                        for(x=0;x<gRegistrosTRDs.getStore().getCount();x++)
                                                                        {
                                                                            filaTRD=gRegistrosTRDs.getStore().getAt(x);
                                                                            
                                                                            if(filaTRD.data.tipoElemento=='2')
                                                                            {
                                                                                
                                                                                if(
                                                                                	(filaTRD.data.cveSubSerie.toLowerCase()==txtSubSerie.getValue().toLowerCase())&&
                                                                                	(filaTRD.data.tipoDocumento.toLowerCase()==txtTituloSerie.getValue().toLowerCase())&&
                                                                                    (filaTRD.data.idRegistro!=idRegistro)&&(filaTRD.data.idSerie==cmbSerie.getValue())
                                                                                  )
                                                                                {
                                                                                	
                                                                                    function resp()
                                                                                    {
                                                                                        txtCveSerie.focus();
                                                                                    }
                                                                                    msgBox('La clave de subserie que intenta agregar ya existe en la presente TRD',resp);
                                                                                    return;
                                                                                }

                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        var chkSoporteGroup=gEx('chkSoporteGroup');
                                                                        
                                                                        var aSoporte=chkSoporteGroup.getValue();
                                                                        
                                                                        var arrSoporte='';
                                                                        
                                                                        if(aSoporte)
                                                                        {
                                                                            var x;
                                                                            var o;
                                                                            for(x=0;x<aSoporte.length;x++)
                                                                            {
                                                                                
                                                                                o=aSoporte[x];
                                                                                if(arrSoporte=='')
                                                                                    arrSoporte=o.inputValue;
                                                                                else
                                                                                    arrSoporte+=','+o.inputValue;
                                                                                
                                                                            }
																		}                                                                        
                                                                        var txtTiempoRetencionArchivoGestion=gEx('txtTiempoRetencionArchivoGestion');
                                                                        var cmbPeriodoArchivoGestion=gEx('cmbPeriodoArchivoGestion');
                                                                        
                                                                        var txtTiempoRetencionArchivoCentral=gEx('txtTiempoRetencionArchivoCentral');
                                                                        var cmbPeriodoArchivoCentral=gEx('cmbPeriodoArchivoCentral');
                                                                        
                                                                        
                                                                        if((txtTiempoRetencionArchivoGestion.getValue()!='')||(cmbPeriodoArchivoGestion.getValue()!=''))
                                                                        {
                                                                        	if(txtTiempoRetencionArchivoGestion.getValue()=='')
                                                                            {
                                                                            	function resp3()
                                                                                {
                                                                                	txtTiempoRetencionArchivoGestion.focus();
                                                                                }
                                                                                msgBox('Debe ingresar el tiempo de retenci&oacute;n en archivo de gesti&oacute;n',resp3)
                                                                                return;
                                                                            
                                                                            }
                                                                            
                                                                            if(cmbPeriodoArchivoGestion.getValue()=='')
                                                                            {
                                                                            	function resp4()
                                                                                {
                                                                                	cmbPeriodoArchivoGestion.focus();
                                                                                }
                                                                                msgBox('Debe ingresar el periodo de retenci&oacute;n en archivo de gesti&oacute;n',resp4)
                                                                                return;
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        if((txtTiempoRetencionArchivoCentral.getValue()!='')||(cmbPeriodoArchivoCentral.getValue()!=''))
                                                                        {
                                                                        	if(txtTiempoRetencionArchivoCentral.getValue()=='')
                                                                            {
                                                                            	function resp5()
                                                                                {
                                                                                	txtTiempoRetencionArchivoCentral.focus();
                                                                                }
                                                                                msgBox('Debe ingresar el tiempo de retenci&oacute;n en archivo de central',resp5)
                                                                                return;
                                                                            
                                                                            }
                                                                            
                                                                            if(cmbPeriodoArchivoCentral.getValue()=='')
                                                                            {
                                                                            	function resp6()
                                                                                {
                                                                                	cmbPeriodoArchivoCentral.focus();
                                                                                }
                                                                                msgBox('Debe ingresar el periodo de retenci&oacute;n en archivo de central',resp6)
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        var rdoDiposicionGroup=gEx('rdoDiposicionGroup');
                                                                        var aDisposicion=rdoDiposicionGroup.getValue();
                                                                        
                                                                        var disposicionFinal='';
                                                                        var arrDisposicion='';
                                                                        var x;
                                                                        var o;
                                                                        if(aDisposicion)
                                                                        {
                                                                        	disposicionFinal=aDisposicion.inputValue;
																		}                                                                        
                                                                        
                                                                        var txtProcedimiento=gEx('txtProcedimiento');
                                                                        
                                                                        var gTipoProcesoAppend=gEx('gTipoProcesoAppend');
                                                                        
                                                                        
                                                                        var arrTipoProcesos='';
                                                                        var filaTipoProceso;
                                                                        var x;
                                                                        for(x=0;x<gTipoProcesoAppend.getStore().getCount();x++)
                                                                        {
                                                                        	filaTipoProceso=gTipoProcesoAppend.getStore().getAt(x);
                                                                            if(arrTipoProcesos=='')
                                                                            	arrTipoProcesos=filaTipoProceso.data.idTipoProceso;
                                                                            else
                                                                            	arrTipoProcesos+=','+filaTipoProceso.data.idTipoProceso;
                                                                            
                                                                            
                                                                        }
                                                                        
																		var cadObj='{"cveElemento":"'+cv(txtSubSerie.getValue())+'","tituloElemento":"'+cv(txtTituloSerie.getValue())+'","soporte":"'+arrSoporte+
                                                                        		'","tRetencionGestion":"'+txtTiempoRetencionArchivoGestion.getValue()+'","pRetencionGestion":"'+cmbPeriodoArchivoGestion.getValue()+
                                                                                '","tRetencionCentral":"'+txtTiempoRetencionArchivoCentral.getValue()+
                                                                                '","pRetencionCentral":"'+cmbPeriodoArchivoCentral.getValue()+
                                                                                '","disposicionFinal":"'+disposicionFinal+'","procedimiento":"'+cv(gEx('txtProcedimiento').getValue())+
                                                                                '","idRegistro":"'+idRegistro+'","tipoRegistro":"2","idTablaRetencion":"'+gE('idTablaRetencion').value+
                                                                                '","idSerie":"'+cmbSerie.getValue()+'","version":"'+versionSel+'","arrTipoProcesos":"'+arrTipoProcesos+'"}';
																		
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	obtenerRegistrosTRD();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);

                                                                        
                                                                    	
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();
    
    
   	
}

function mostrarVentanaTipoDocumental(fila)
{
	if(versionSel=='-1')
    {
    	msgBox('Primero debe crear una versi&oacute;n de la TRD');
    	return;
    }
	var cmbSerie=null;
    var cmbSubSerie=null;
    var cmbTipoDocumental=null;
	var cmbPeriodoArchivoGestion=null;
    var cmbPeriodoArchivoCentral=null;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Serie: <span style="color:#F00">*</span>'
                                                        },
                                                        {
                                                            x:180,
                                                            y:0,
                                                            html:'<div id="divSerie"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:55,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Sub Serie: <span style="color:#F00">*</span>'
                                                        },
                                                        {
                                                            x:180,
                                                            y:45,
                                                            html:'<div id="divSubSerie"></div>'
                                                        },
                                                        
                                                        
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo Documental: <span style="color:#F00">*</span>'
                                                        },
                                                        {
                                                            x:180,
                                                            y:90,
                                                            html:'<div id="divTipoDocumental"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:140,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Soporte:'
                                                        },	
                                                        {
                                                        	x:180,
                                                            y:135,
                                                            id:'chkSoporteGroup',
                                                            width:250,
                                                            xtype:'checkboxgroup',
                                                            items: [
                                                                        {boxLabel: 'F&iacute;sico', name: 'rdoSoporte', inputValue: 1,ctCls:'controlSIUGJ'},
                                                                        {boxLabel: 'Electr&oacute;nico', name: 'rdoSoporte', inputValue: 2,ctCls:'controlSIUGJ'}
                                                                    ]
                                                        },
                                                        {
                                                        	x:0,
                                                            y:170,
                                                            xtype:'fieldset',
                                                            width:700,
                                                            height:125,
                                                            layout:'absolute',
                                                            defaultType: 'label',
                                                            cls:'x-fieldsetSIUGJ',
                                                            title:'Tiempo de retenci&oacute;n:',
                                                            items:	[
                                                            			{
                                                                        	x:10,
                                                                            y:10,
                                                                            cls:'SIUGJ_Etiqueta',
                                                                            html:'Archivo Gesti&oacute;n:'
                                                                        },
                                                                        {
                                                                        	x:180,
                                                                            y:5,
                                                                            width:50,
                                                                            cls:'controlSIUGJ',
                                                                            xtype:'numberfield',
                                                                            id:'txtTiempoRetencionArchivoGestion',
                                                                            allowDecimals:false,
                                                                            allowNegative:false
                                                                        },
                                                                        {
                                                                            x:240,
                                                                            y:0,
                                                                            html:'<div id="divArchivoGestion"></div>'
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:50,
                                                                            cls:'SIUGJ_Etiqueta',
                                                                            html:'Archivo Central:'
                                                                        },
                                                                        
                                                                         {
                                                                        	x:180,
                                                                            y:45,
                                                                            width:50,
                                                                            cls:'controlSIUGJ',
                                                                            xtype:'numberfield',
                                                                            id:'txtTiempoRetencionArchivoCentral',
                                                                            allowDecimals:false,
                                                                            allowNegative:false
                                                                        },
                                                                        {
                                                                            x:240,
                                                                            y:45,
                                                                            html:'<div id="divArchivoCentral"></div>'
                                                                        }
                                                            		]
                                                        },	
                                                        
                                                        {
                                                        	x:10,
                                                            y:310,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Disposici&oacute;n Final:'
                                                        },	
                                                        {
                                                        	x:180,
                                                            y:305,
                                                            id:'rdoDiposicionGroup',
                                                            width:500,
                                                            xtype:'radiogroup',
                                                            items: [
                                                                        {boxLabel: 'CT', name: 'rdoDisposicion', inputValue: 1,ctCls:'controlSIUGJ'},
                                                                        {boxLabel: 'E', name: 'rdoDisposicion', inputValue: 2,ctCls:'controlSIUGJ'},
                                                                        {boxLabel: 'MT', name: 'rdoDisposicion', inputValue: 3,ctCls:'controlSIUGJ'},
                                                                        {boxLabel: 'S', name: 'rdoDisposicion', inputValue: 4,ctCls:'controlSIUGJ'},
                                                                        {boxLabel: '(Ninguno)', name: 'rdoDisposicion', inputValue: 0,ctCls:'controlSIUGJ'}
                                                                    ]
                                                        },
                                                        {
                                                        	x:10,
                                                            y:360,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Procedimiento:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:355,
                                                            id:'txtProcedimiento',
                                                            xtype:'textarea',
                                                            cls:'controlSIUGJ',
                                                            width:600,
                                                            height:60,
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Tipo Documental',
										width: 880,
										height:550,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	
                                                                    
                                                                    
                                                                    cmbSerie=crearComboExt('cmbSerie',arrSeries,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divSerie'});
                                                                    cmbSerie.on('select',function(cmb,registro)
                                                                                            {
                                                                                                cmbSubSerie.setValue('');
                                                                                                cmbSubSerie.getStore().removeAll();
                                                                                                var subSerieTipoDocumental=[['0','Ninguno']];
                                                                                                var x;
                                                                                                for(x=0;x<registro.data.valorComp.length;x++)
                                                                                                {
                                                                                                	subSerieTipoDocumental.push(registro.data.valorComp[x]);
                                                                                                }
                                                                                                cmbSubSerie.getStore().loadData(subSerieTipoDocumental);
                                                                                            }
                                                                                )
                                                                    cmbSubSerie=crearComboExt('cmbSubSerie',[],0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divSubSerie'});
                                                                    
                                                                    cmbTipoDocumental=crearComboExt('cmbTipoDocumental',arrTipoDocumental,0,0,600,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divTipoDocumental',multiSelect:!fila});
                                                                        
                                                                    cmbPeriodoArchivoGestion=crearComboExt('cmbPeriodoArchivoGestion',arrPeriodosRetencion,0,0,110,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divArchivoGestion'});
    																cmbPeriodoArchivoCentral=crearComboExt('cmbPeriodoArchivoCentral',arrPeriodosRetencion,0,0,110,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divArchivoCentral'});
                                                                    
                                                                    
                                                                    if(fila)
                                                                    {
                                                                        var cmbSerie=gEx('cmbSerie');
                                                                        cmbSerie.setValue(fila.data.idSerie);
                                                                        var cmbSubSerie=gEx('cmbSubSerie');
                                                                        
                                                                        cmbSubSerie.setValue('');
                                                                        cmbSubSerie.getStore().removeAll();
                                                                        
                                                                        var pos=existeValorMatriz(arrSeries,fila.data.idSerie);
                                                                        
                                                                        cmbSubSerie.getStore().loadData(arrSeries[pos][2]);
                                                                        cmbSubSerie.setValue(fila.data.idSubSerie);
                                                                      
                                                                        
                                                                        var cmbTipoDocumental=gEx('cmbTipoDocumental');
                                                                        
                                                                        cmbTipoDocumental.setValue(fila.data.tipoDocumento);
                                                                        var chkSoporteGroup=gEx('chkSoporteGroup');
                                                                        var txtTiempoRetencionArchivoGestion=gEx('txtTiempoRetencionArchivoGestion');
                                                                        var cmbPeriodoArchivoGestion=gEx('cmbPeriodoArchivoGestion');
                                                                        var txtTiempoRetencionArchivoCentral=gEx('txtTiempoRetencionArchivoCentral');
                                                                        var cmbPeriodoArchivoCentral=gEx('cmbPeriodoArchivoCentral');
                                                                        var rdoDiposicionGroup=gEx('rdoDiposicionGroup');
                                                                        var txtProcedimiento=gEx('txtProcedimiento');
                                                                
                                                                        
                                                                       
                                                                        if(fila.data.conservacionTotal)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(1);
                                                                        }
                                                                         if(fila.data.eliminacion)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(2);
                                                                        }
                                                                         if(fila.data.microfilmacionDigitalizacion)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(3);
                                                                        }
                                                                         if(fila.data.seleccion)
                                                                        {
                                                                            rdoDiposicionGroup.setValue(4);
                                                                        }
                                                                        
                                                                        chkSoporteGroup.setValue([fila.data.soporteFisico,fila.data.soporteElectronico]);
                                                                        txtTiempoRetencionArchivoGestion.setValue(fila.data.retencionArchivoGestion);
                                                                        cmbPeriodoArchivoGestion.setValue(fila.data.unidadRetencionArchivoGestion);
                                                                        txtTiempoRetencionArchivoCentral.setValue(fila.data.retencionArchivoCentral);
                                                                        cmbPeriodoArchivoCentral.setValue(fila.data.unidadRetencionArchivoCentral);
                                                                       
                                                                        txtProcedimiento.setValue(escaparBR(fila.data.procedimiento));
                                                                        
                                                                    }
                                                                    else
                                                                    {
                                                                        var gRegistrosTRDs=gEx('gRegistrosTRDs');
                                                                        var fSeleccionada=gRegistrosTRDs.getSelectionModel().getSelected();
                                                                		
                                                                        if((fSeleccionada)&&(fSeleccionada.data.tipoElemento=='2'))
                                                                        {
                                                                            var cmbSerie=gEx('cmbSerie');
                                                                            cmbSerie.setValue(fSeleccionada.data.idSerie);
                                                                            var cmbSubSerie=gEx('cmbSubSerie');
                                                                            dispararEventoSelectCombo('cmbSerie');
                                                                            cmbSubSerie.setValue(fSeleccionada.data.idSubSerie);
                                                                        }
                                                                        
                                                                         if((fSeleccionada)&&(fSeleccionada.data.tipoElemento=='1'))
                                                                        {
                                                                            var cmbSerie=gEx('cmbSerie');
                                                                            cmbSerie.setValue(fSeleccionada.data.idRegistro);
                                                                            var cmbSubSerie=gEx('cmbSubSerie');
                                                                            dispararEventoSelectCombo('cmbSerie');
                                                                            cmbSubSerie.setValue('0');
                                                                            cmbSubSerie.disable();
                                                                        }
                                                                    }	
                                                                    cmbSerie.focus(false,500);
                                                                    
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var idRegistro=fila?fila.data.idRegistro:-1;
                                                                    	var txtSubSerie=gEx('txtSubSerie');
                                                                        
                                                                        
                                                                        var cmbSerie=gEx('cmbSerie');
                                                                        var cmbSubSerie=gEx('cmbSubSerie');
                                                                        var cmbTipoDocumental=gEx('cmbTipoDocumental');
                                                                        
                                                                        if(cmbSerie.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbSerie.focus();
                                                                            }
                                                                            msgBox('Debe indicar la serie a la cual pertenece el tipo documental',resp)
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbSubSerie.getValue()=='')
                                                                        {
                                                                        	function resp20()
                                                                            {
                                                                            	cmbSubSerie.focus();
                                                                            }
                                                                            msgBox('Debe indicar la suberie a la cual pertenece el tipo documental',resp20)
                                                                            return;
                                                                        }
                                                                        
                                                                         if(cmbTipoDocumental.getValue()=='')
                                                                        {
                                                                        	function resp30()
                                                                            {
                                                                            	cmbTipoDocumental.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo documental a agregar',resp30)
                                                                            return;
                                                                        }
                                                                        
                                                                        var arrTiposDocumentales=cmbTipoDocumental.getValue().split(',');
                                                                        var gRegistrosTRDs=gEx('gRegistrosTRDs');
                                                                        var x;
                                                                        var filaTRD;
                                                                        
                                                                        var z;
                                                                        for(z=0;z<arrTiposDocumentales.length;z++)
                                                                        {
                                                                        
                                                                            for(x=0;x<gRegistrosTRDs.getStore().getCount();x++)
                                                                            {
                                                                                
                                                                                filaTRD=gRegistrosTRDs.getStore().getAt(x);
                                                                                if(filaTRD.data.tipoElemento=='3')
                                                                                {
                                                                                    
                                                                                    if(
                                                                                        (filaTRD.data.idSerie==cmbSerie.getValue())&&
                                                                                        (filaTRD.data.idSubSerie==cmbSubSerie.getValue())&&
                                                                                        (filaTRD.data.idRegistro!=idRegistro)&&(filaTRD.data.tipoDocumento==arrTiposDocumentales[z])
                                                                                      )
                                                                                    {
                                                                                        
                                                                                        function resp()
                                                                                        {
                                                                                            cmbTipoDocumental.focus();
                                                                                        }
                                                                                        msgBox('El tipo documental '+formatearValorRenderer(arrTipoDocumental,arrTiposDocumentales[z])+' que intenta agregar ya existe en la serie/sub serie indicada',resp);
                                                                                        return;
                                                                                    }
    
                                                                                }
                                                                                
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                        var chkSoporteGroup=gEx('chkSoporteGroup');
                                                                        
                                                                        var aSoporte=chkSoporteGroup.getValue();
                                                                        
                                                                        var arrSoporte='';
                                                                        
                                                                        if(aSoporte)
                                                                        {
                                                                            var x;
                                                                            var o;
                                                                            for(x=0;x<aSoporte.length;x++)
                                                                            {
                                                                                
                                                                                o=aSoporte[x];
                                                                                if(arrSoporte=='')
                                                                                    arrSoporte=o.inputValue;
                                                                                else
                                                                                    arrSoporte+=','+o.inputValue;
                                                                                
                                                                            }
																		}                                                                        
                                                                        var txtTiempoRetencionArchivoGestion=gEx('txtTiempoRetencionArchivoGestion');
                                                                        var cmbPeriodoArchivoGestion=gEx('cmbPeriodoArchivoGestion');
                                                                        
                                                                        var txtTiempoRetencionArchivoCentral=gEx('txtTiempoRetencionArchivoCentral');
                                                                        var cmbPeriodoArchivoCentral=gEx('cmbPeriodoArchivoCentral');
                                                                        
                                                                        
                                                                        if((txtTiempoRetencionArchivoGestion.getValue()!='')||(cmbPeriodoArchivoGestion.getValue()!=''))
                                                                        {
                                                                        	if(txtTiempoRetencionArchivoGestion.getValue()=='')
                                                                            {
                                                                            	function resp3()
                                                                                {
                                                                                	txtTiempoRetencionArchivoGestion.focus();
                                                                                }
                                                                                msgBox('Debe ingresar el tiempo de retenci&oacute;n en archivo de gesti&oacute;n',resp3)
                                                                                return;
                                                                            
                                                                            }
                                                                            
                                                                            if(cmbPeriodoArchivoGestion.getValue()=='')
                                                                            {
                                                                            	function resp4()
                                                                                {
                                                                                	cmbPeriodoArchivoGestion.focus();
                                                                                }
                                                                                msgBox('Debe ingresar el periodo de retenci&oacute;n en archivo de gesti&oacute;n',resp4)
                                                                                return;
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                        if((txtTiempoRetencionArchivoCentral.getValue()!='')||(cmbPeriodoArchivoCentral.getValue()!=''))
                                                                        {
                                                                        	if(txtTiempoRetencionArchivoCentral.getValue()=='')
                                                                            {
                                                                            	function resp5()
                                                                                {
                                                                                	txtTiempoRetencionArchivoCentral.focus();
                                                                                }
                                                                                msgBox('Debe ingresar el tiempo de retenci&oacute;n en archivo de central',resp5)
                                                                                return;
                                                                            
                                                                            }
                                                                            
                                                                            if(cmbPeriodoArchivoCentral.getValue()=='')
                                                                            {
                                                                            	function resp6()
                                                                                {
                                                                                	cmbPeriodoArchivoCentral.focus();
                                                                                }
                                                                                msgBox('Debe ingresar el periodo de retenci&oacute;n en archivo de central',resp6)
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        var rdoDiposicionGroup=gEx('rdoDiposicionGroup');
                                                                        var aDisposicion=rdoDiposicionGroup.getValue();
                                                                        
                                                                        var disposicionFinal='';
                                                                        var arrDisposicion='';
                                                                        var x;
                                                                        var o;
                                                                        if(aDisposicion)
                                                                        {
                                                                        	disposicionFinal=aDisposicion.inputValue;
																		}                                                                        
                                                                        
                                                                        var txtProcedimiento=gEx('txtProcedimiento');
                                                                        
                                                                        
																		var cadObj='{"cveElemento":"","tituloElemento":"","soporte":"'+arrSoporte+
                                                                        		'","tRetencionGestion":"'+txtTiempoRetencionArchivoGestion.getValue()+'","pRetencionGestion":"'+cmbPeriodoArchivoGestion.getValue()+
                                                                                '","tRetencionCentral":"'+txtTiempoRetencionArchivoCentral.getValue()+
                                                                                '","pRetencionCentral":"'+cmbPeriodoArchivoCentral.getValue()+
                                                                                '","disposicionFinal":"'+disposicionFinal+'","procedimiento":"'+cv(gEx('txtProcedimiento').getValue())+
                                                                                '","idRegistro":"'+idRegistro+'","tipoRegistro":"3","idTablaRetencion":"'+gE('idTablaRetencion').value+
                                                                                '","idSerie":"'+cmbSerie.getValue()+'","idSubSerie":"'+cmbSubSerie.getValue()+
                                                                                '","tipoDocumento":"'+cmbTipoDocumental.getValue()+'","version":"'+versionSel+'"}';
																		
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	obtenerRegistrosTRD();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=2&cadObj='+cadObj,true);

                                                                        
                                                                    	
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();
    
    
   
}

function crearGridVersiones()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'version'},
                                                        {name: 'situacionActual'},
                                                        {name: 'fechaAplicacion', type:'date', dateFormat:'Y-m-d'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesGestorDocumental.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'version', direction: 'ASC'},
                                                            groupField: 'version',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='8';
                                        proxy.baseParams.iT=gE('idTablaRetencion').value;
                                        if(gEx('btnActivarTRD'))
	                                        gEx('btnActivarTRD').hide();
                                        if(gEx('btnDesactivarTRD'))
                                       		gEx('btnDesactivarTRD').hide();
                                        gEx('gRegistrosTRDs').getStore().removeAll();
                                    }
                        )   
    
    
    alDatos.on('load',function(proxy)
    								{
                                    	if(versionSel!=-1)
                                        {
                                        	setTimeout(function()
                                            			{
                                                        	var pos=obtenerPosFila(gEx('gVersiones').getStore(),'version',versionSel);
                                                        	gEx('gVersiones').getSelectionModel().selectRow(pos,false); 
                                                        
                                                        }
                                            		, 500);
                                        }
                                    }
                        )  
    
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	{
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'situacionActual',
                                                            renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrSituacionTRD,val);
                                                                    	return '<img src="'+arrSituacionTRD[pos][3]+'" title="'+arrSituacionTRD[pos][1]+'" alt="'+arrSituacionTRD[pos][1]+'">';
                                                                    }
                                                        },
                                                        {
                                                            header:'Versi&oacute;n',
                                                            width:250,
                                                            sortable:true,
                                                            dataIndex:'version',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrSituacionTRD,registro.data.situacionActual);
                                                                    	var lblEtiqueta='Versi&oacute;n: '+val+' ('+arrSituacionTRD[pos][1]+')';
                                                                        
                                                                        if(registro.data.fechaAplicacion)
                                                                        {
                                                                        	lblEtiqueta+='<br>Fecha de aplicaci&oacute;n: '+registro.data.fechaAplicacion.format('d/m/Y');
                                                                        }
                                                                        
                                                                        return lblEtiqueta;
                                                                    }
                                                        }
                                                    ]
                                                );

	var objConf= {
                      id:'gVersiones',
                      store:alDatos,
                      region:'center',
                      frame:false,
                      hideHeaders :true,
                      cm: cModelo,
                      stripeRows :false,
                      loadMask:true,
                      columnLines : false,
                      cls:'gridSiugjPrincipal',
                      view:new Ext.grid.GroupingView({
                                                          forceFit:false,
                                                          showGroupName: false,
                                                          enableGrouping :false,
                                                          enableNoGroups:false,
                                                          enableGroupingMenu:false,
                                                          hideGroupedColumn: false,
                                                          startCollapsed:false
                                                      })
                  }

	if(!sL)
    {
    	objConf.tbar=	[
                            {
                                icon:'../images/add.png',
                                cls:'x-btn-icon',
                                width:30,
                                tooltip:'Nueva versi&oacute;n de TRD',
                                handler:function()
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
                                                        	versionSel=arrResp[1];
                                                            console.log(versionSel);
                                                            gEx('gVersiones').getStore().reload();
                                                        }
                                                        else
                                                        {
                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                        }
                                                    }
                                                    obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=9&iT='+gE('idTablaRetencion').value,true);
                                                }
                                            }
                                            msgConfirm('¿Est&aacute; seguro de querer generar una nueva versi&oacute;n de la TRD?',resp);                                                                                        
                                        }
                                
                            },
                            {
                                icon:'../images/icon_documents.gif',
                                cls:'x-btn-icon',
                                width:30,
                                tooltip:'Clonar TRD',
                                handler:function()
                                        {
                                            var gVersiones=gEx('gVersiones');
                                            var fila=gVersiones.getSelectionModel().getSelected();
                                            
                                            if(!fila)
                                            {
                                                msgBox('Debe seleccionar la versi&oacute;n de la TRD que desea clonar');
                                                return;
                                            }
                                            
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
                                                            versionSel=arrResp[1];
                                                            gEx('gVersiones').getStore().reload();
                                                        }
                                                        else
                                                        {
                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                        }
                                                    }
                                                    obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=14&v='+versionSel+'&iT='+gE('idTablaRetencion').value,true);
                                                }
                                            }
                                            msgConfirm('¿Est&aacute; seguro de querer realizar una copia de la versi&oacute;n de la TRD seleccionada?',resp);   
                                        }
                                
                            },
                            {
                                icon:'../images/delete.png',
                                cls:'x-btn-icon',
                                width:30,
                                tooltip:'Remover versi&oacute;n de TRD',
                                handler:function()
                                        {
                                            var gVersiones=gEx('gVersiones');
                                            var fila=gVersiones.getSelectionModel().getSelected();
                                            
                                            if(!fila)
                                            {
                                                msgBox('Debe seleccionar la versi&oacute;n de la TRD que desea remover');
                                                return;
                                            }
                                            
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
                                                            versionSel=arrResp[1];
                                                            gEx('gVersiones').getStore().reload();
                                                        }
                                                        else
                                                        {
                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                        }
                                                    }
                                                    obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=15&v='+fila.data.version+'&iT='+gE('idTablaRetencion').value,true);
                                                }
                                            }
                                            msgConfirm('¿Est&aacute; seguro de querer remover la versi&oacute;n de la TRD seleccionada?',resp);   
                                        }
                                
                            },'-',
                            {
                                icon:'../images/accept_green.png',
                                cls:'x-btn-icon',
                                width:30,
                                hidden:true,
                                id:'btnActivarTRD',
                                tooltip:'Publicar versi&oacute;n de TRD',
                                handler:function()
                                        {
                                            var gVersiones=gEx('gVersiones');
                                            var fila=gVersiones.getSelectionModel().getSelected();
                                            
                                            if(!fila)
                                            {
                                                msgBox('Debe seleccionar la versi&oacute;n de la TRD que desea publicar');
                                                return;
                                            }
                                            
                                            mostrarVentanaActivarVersionTRD(fila);
                                            
                                        }
                                
                            },
                            {
                                icon:'../images/cancel_round.png',
                                cls:'x-btn-icon',
                                width:30,
                                id:'btnDesactivarTRD',
                                hidden:true,
                                tooltip:'Desactivar versi&oacute;n de TRD',
                                handler:function()
                                        {
                                            var gVersiones=gEx('gVersiones');
                                            var fila=gVersiones.getSelectionModel().getSelected();
                                            
                                            if(!fila)
                                            {
                                                msgBox('Debe seleccionar la versi&oacute;n de la TRD que desea desactivar');
                                                return;
                                            }
                                            
                                            mostrarVentanaDesactivarVersionTRD(fila);
                                               
                                        }
                                
                            },'-',
                            {
                                icon:'../images/document_go.png',
                                cls:'x-btn-icon',
                                width:30,
                                tooltip:'Exportar TRD',
                                handler:function()
                                        {
                                            var gVersiones=gEx('gVersiones');
                                            var fila=gVersiones.getSelectionModel().getSelected();
                                            
                                            if(!fila)
                                            {
                                                msgBox('Debe seleccionar la versi&oacute;n de la TRD que desea exportar');
                                                return;
                                            }
                                            
                                            mostrarVentanaExportarVersionTRD(fila);
                                               
                                        }
                                
                            }
                            
                        ]
    }
                                                
    var tblGrid=	new Ext.grid.GridPanel	(objConf);
    
    tblGrid.getSelectionModel().on('rowselect',function(sm,numFila,registro)
    											{
                                                	if(gEx('btnActivarTRD'))
	                                                	gEx('btnActivarTRD').hide();
                                                    if(gEx('btnDesactivarTRD'))
	                                                    gEx('btnDesactivarTRD').hide();
                                                    if((registro.data.situacionActual=='1')||(registro.data.situacionActual=='3'))
                                                    {
														if(gEx('btnActivarTRD'))
	                                                    	gEx('btnActivarTRD').show();
                                                    }
                                                    if(registro.data.situacionActual=='2')
                                                    {
                                                    	if(gEx('btnDesactivarTRD'))
	                                                    	gEx('btnDesactivarTRD').show();
                                                    }    
                                                	obtenerRegistrosTRD();
                                                }
    								);   
    
    
    tblGrid.getSelectionModel().on('rowdeselect',function(sm,numFila,registro)
    											{
                                                	if(gEx('btnActivarTRD'))
	                                                	gEx('btnActivarTRD').hide();
                                                    gEx('btnDesactivarTRD')
	                                                    gEx('btnDesactivarTRD').hide();
                                                	
                                                }
    								);  
    
    return 	tblGrid;
}

function obtenerRegistrosTRD()
{
	var gVersiones=gEx('gVersiones');
	var fila=gVersiones.getSelectionModel().getSelected();
	versionSel=fila.data.version;
    
	var gRegistrosTRDs=gEx('gRegistrosTRDs');
    gRegistrosTRDs.getStore().load	(
    										{
                                            	url: '../paginasFunciones/funcionesGestorDocumental.php',
                                                params:	{
                                                            funcion:3,
                                                            idTablaRetencion:gE('idTablaRetencion').value,
                                                            version:versionSel
                                                        }
                                            }
    									)
}

function crearGridSubserie(fila)
{
	var dsDatos=[];
    if(fila)
    {
    	dsDatos=fila.data.arrTiposProcesos;
    }
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                   	
                                                                    {name:'especialidad'},
                                                                    {name: 'idTipoProceso'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
														{
															header:'Especialidad',
															width:280,
															sortable:true,
															dataIndex:'especialidad',
                                                            renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arEspecialidades,val);
                                                                        	

                                                                        }
														},
														{
															header:'Tipo de proceso',
															width:450,
															sortable:true,
															dataIndex:'idTipoProceso',
                                                            renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arTiposProcesos,val);
                                                                        	

                                                                        }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gTipoProcesoAppend',
                                                            store:alDatos,
                                                            frame:false,
                                                            cls:'gridSiugjPrincipal',
                                                            region:'center',
                                                            cm: cModelo,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar tipo de proceso',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentenaTipoProcesos();
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                            xtype:'tbspacer',
                                                                            width:15
                                                                        
                                                                        },
                                                                        
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover tipo de proceso',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gTipoProcesoAppend').getSelectionModel().getSelections();
                                                                                        if(fila.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el tipo de proceso que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                        		gEx('gTipoProcesoAppend').getStore().remove(fila);
                                                                                        	}
                                                                                        }
                                                                                        msgConfirm('¿Est&aacute; seguro de querer remover el tipo de proceso seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVentenaTipoProcesos()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			crearGridTiposProcesos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar tipo de proceso',
										width: 880,
										height:450,
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
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var filas=gEx('gTiposProcesosAdd').getSelectionModel().getSelections();
                                                                        
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar el tipo de proceso a asociar con la serie');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var pos;
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	pos=obtenerPosFila(gEx('gTipoProcesoAppend').getStore(),'idTipoProceso',filas[x].data.idTipoProceso);
                                                                        	
                                                                            if(pos==-1)
                                                                            	gEx('gTipoProcesoAppend').getStore().add(filas[x].copy());
                                                                        }
                                                                        
                                                                        ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}


function crearGridTiposProcesos()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idTipoProceso'},
		                                                {name: 'especialidad'}
		                                                
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesGestorDocumental.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'especialidad', direction: 'ASC'},
                                                            groupField: 'especialidad',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='10';
                                        
                                    }
                        )   
       
       
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                        	chkRow,
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'Especialidad',
                                                                width:290,
                                                                sortable:true,
                                                                dataIndex:'especialidad',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arEspecialidades,val);
                                                                        	

                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo proceso',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'idTipoProceso',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arTiposProcesos,val);
                                                                        	

                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gTiposProcesosAdd',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                sm:chkRow,
                                                                columnLines : false,
                                                                cls:'gridSiugjPrincipal',
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}


function mostrarVentanaDespachosAsociadosTRD()
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
                                                            y:10,
                                                            html:'<span class="SIUGJ_Etiqueta">Nombre TRD:</span>'
                                                        },
                                                        {
                                                        	x:130,
                                                            y:10,
                                                            html:'<span class="controlSIUGJ">'+gEx('txtNombreTabla').getValue()+' <span class="SIUGJ_Etiqueta">Versi&oacute;n TRD:</span><span class="controlSIUGJ">'+versionSel+'</span>'
                                                        },
                                                        
                                            			crearGridDespachosAsociadosTRD()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Oficinas productoras asociadas',
										width: 800,
										height:500,
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
															text: 'Cerrar',
                                                            cls:'btnSIUGJCancel',
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

function crearGridDespachosAsociadosTRD()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name: 'codigoUnidad'},
		                                                {name: 'nombreDespacho'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesGestorDocumental.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreDespacho', direction: 'ASC'},
                                                            groupField: 'nombreDespacho',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='12';
                                        proxy.baseParams.iR=gE('idTablaRetencion').value;
                                        proxy.baseParams.v=versionSel;
                                    }
                        )   

	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:40}),
                                                        chkRow,
                                                        {
                                                            header:'Oficina productora',
                                                            width:650,
                                                            sortable:true,
                                                            dataIndex:'nombreDespacho'
                                                        }
                                                    ]
                                                );
                                                

	var objConf=	{
                      id:'gDespachosAsociados',
                      store:alDatos,
                      x:10,
                      y:50,
                      sm:chkRow,
                      height:340,
                      frame:false,
                      cm: cModelo,
                      stripeRows :false,
                      loadMask:true,
                      columnLines : false,
                      cls:'gridSiugjPrincipal',
                      
                      view:new Ext.grid.GroupingView({
                                                          forceFit:false,
                                                          showGroupName: false,
                                                          enableGrouping :false,
                                                          enableNoGroups:false,
                                                          enableGroupingMenu:false,
                                                          hideGroupedColumn: false,
                                                          startCollapsed:false
                                                      })
                  }

	if(!sL)
    {
    	objConf.tbar=	[
                            {
                                icon:'../images/add.png',
                                cls:'x-btn-text-icon',
                                text:'Agregar oficina productora',
                                handler:function()
                                        {
                                            mostrarVentanAgregarDespachoOrganigrama()
                                        }
                                
                            },
                            {
                                xtype:'tbspacer',
                                width:10
                            },
                            {
                                icon:'../images/delete.png',
                                cls:'x-btn-text-icon',
                                text:'Remover oficina productora',
                                handler:function()
                                        {
                                            var filas=	gEx('gDespachosAsociados').getSelectionModel().getSelections();
                                            if(filas.length==0)
                                            {
                                                msgBox('Debe seleccionar las oficinas productoras que desea remover');
                                                return;
                                            }
                                            
                                            var f;
                                            function resp(btn)
                                            {
                                                if(btn=='yes')
                                                {
                                                    var arrDespachos='';
                                                    var x;
                                                    for(x=0;x<filas.length;x++)
                                                    {
                                                        f=  filas[x];
                                                        if(arrDespachos=='')
                                                            arrDespachos=f.data.idRegistro;
                                                        else
                                                            arrDespachos+=','+f.data.idRegistro;
                                                    }
                                                    
                                                    function funcAjax()
                                                    {
                                                        var resp=peticion_http.responseText;
                                                        arrResp=resp.split('|');
                                                        if(arrResp[0]=='1')
                                                        {
                                                            gEx('gDespachosAsociados').getStore().reload();
                                                            gEx('gRegistrosTRDs').getStore().reload();
                                                           
                                                        }
                                                        else
                                                        {
                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                        }
                                                    }
                                                    obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=13&arrDespachos='+arrDespachos,true);
                                                    
                                                }
                                            }
                                            msgConfirm('¿Est&aacute; seguro de querer remover las oficinas productoras seleccionadas?',resp);
                                            
                                        }
                                
                            }
                        ]
    }

    var tblGrid=	new Ext.grid.GridPanel	(objConf);
    return 	tblGrid;
}

function mostrarVentanAgregarDespachoOrganigrama()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			crearOrganigramaDespachos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asociar oficina productora a TRD',
										width: 880,
										height:480,
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
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    
																		var arrNodos=[];
                                                                        obtenerNodoChecadosV2(gEx('tOrganigrama').getRootNode(),arrNodos);
																		var x;
                                                                        
                                                                        var arrDespachos='';
                                                                        for(x=0;x<arrNodos.length;x++)
                                                                        {
                                                                        	
                                                                            if(arrDespachos=='')
                                                                                arrDespachos="'"+arrNodos[x].attributes.codigoU+"'";
                                                                            else
                                                                                arrDespachos+=",'"+arrNodos[x].attributes.codigoU+"'";
																			
                                                                        }

																		var cadObj='{"iR":"'+gE('idTablaRetencion').value+'","v":"'+versionSel+'","arrDespachos":"'+arrDespachos+'"}';

                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                             	gEx('gDespachosAsociados').getStore().reload();
                                                                                gEx('gRegistrosTRDs').getStore().reload();
                                                                                ventanaAM.close();   
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=11&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();	
}

function crearOrganigramaDespachos()
{
	var raiz=new  Ext.tree.AsyncTreeNode	(
                                                      {
                                                          id:'-1',
                                                          text:'Raiz',
                                                          draggable:false,
                                                          expanded :true
                                                      }
                                              	)
                                        
    var cargadorArbol=new Ext.tree.TreeLoader(
                                                    {
                                                        baseParams:{
                                                                        funcion:'70',
                                                                        organigramaInst:'1',
                                                                        ignorarAdscripcion:1,
                                                                        idUsuario:-1
                                                                        
                                                                    },
                                                        dataUrl:'../paginasFunciones/funcionesOrganigrama.php',
                                                        uiProviders:	{
                                                                            'col': Ext.ux.tree.ColumnNodeUI
                                                                        }
                                                    }	


                                             )		                                        
    
                                    
    var organigrama = new Ext.ux.tree.TreeGrid	(
                                                    {
                                                        id:'tOrganigrama',
                                                        height:400,
                                                        width:840,
                                                        cls:'gridSiugjSeccion',
                                                        useArrows:true,
                                                        autoScroll:false,
                                                        animate:true,
                                                        enableDD:true,
                                                        containerScroll: false,
                                                        root:raiz,
                                                        region:'center',
                                                        enableSort:false,
                                                        loader: cargadorArbol,
                                                        rootVisible:false,                                                                
                                                        draggable:false,
                                                        columns:[
                                                                    
                                                                    {
                                                                        header:'Oficina productora',
                                                                        width:800,
                                                                        sortable:false,
                                                                        menuDisabled:true,
                                                                        dataIndex:'text'
                                                                    }/*,
                                                                    
                                                                    {
                                                                        header:'Cve. Departamental',
                                                                        width:180,
                                                                        menuDisabled:true,
                                                                        sortable:false,
                                                                        dataIndex:'cveDeptal'
                                                                    }*/
                                                                 ],
                                                         listeners: 	{
                                                                            'render': 	function(tp)
                                                                                        {
                                                                                            
                                                                                         }
                                                                            }

                                                       
                                                    }
                                            );





    
    organigrama.on('checkchange',nodoClick);
    organigrama.expandAll(); 
    return organigrama;  
}

function nodoClick(nodo,status)
{
	checarNodosHijos(nodo,status);
}

function mostrarVentanaActivarVersionTRD(fila)
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
                                                            html:'Fecha de aplicaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:10,
                                                            html:'<div id="dteFechaAplicacion" style="width:150px"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:55,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:85,
                                                            xtype:'textarea',
                                                            width:460,
                                                            height:70,
                                                            id:'txtComentariosAdicionales',
                                                            cls:'controlSIUGJ'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Publicar versi&oacute;n de TRD',
										width: 510,
										height:300,
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
                                                                	new Ext.form.DateField(
                                                                                                {
                                                                                                    renderTo:'dteFechaAplicacion',
                                                                                                    width:140,
                                                                                                    id:'dteFechaActivacion',
                                                                                                    value:'<?php echo date("Y-m-d")?>',
                                                                                                    ctCls:'campoFechaSIUGJ'
                                                                                                    
                                                                                                }
                                                                                               )
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var dteFechaActivacion=gEx('dteFechaActivacion');
                                                                        
                                                                        if(dteFechaActivacion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	dteFechaActivacion.focus();
                                                                            }
                                                                            msgBox('Debe indicar la fecha en la cual aplicar&aacute; la TRD',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"iR":"'+gE('idTablaRetencion').value+'","v":"'+fila.data.version+'","fechaAplicacion":"'+
                                                                        			dteFechaActivacion.getValue().format('Y-m-d')+'","comentariosAdicionales":"'+
                                                                                    cv(gEx('txtComentariosAdicionales').getValue())+'","situacion":"2"}';
																	
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gVersiones').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=16&cadObj='+cadObj,true);
                                                                        
                                                                    
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();
}


function mostrarVentanaDesactivarVersionTRD(fila)
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
                                                            html:'Ingrese el motivo de la desactivaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:45,
                                                            xtype:'textarea',
                                                            width:460,
                                                            height:70,
                                                            id:'txtComentariosAdicionales',
                                                            cls:'controlSIUGJ'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Desactivar versi&oacute;n de TRD',
										width: 510,
										height:260,
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
                                                                	gEx('txtComentariosAdicionales').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		
                                                                        
                                                                        var cadObj='{"iR":"'+gE('idTablaRetencion').value+'","v":"'+fila.data.version+'","fechaAplicacion":"","comentariosAdicionales":"'+
                                                                                    cv(gEx('txtComentariosAdicionales').getValue())+'","situacion":"3"}';
																	
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gVersiones').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesGestorDocumental.php',funcAjax, 'POST','funcion=16&cadObj='+cadObj,true);
                                                                        
                                                                    
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();
}

function mostrarVentanaExportarVersionTRD(fila)
{
	var cmbFormatoExportacion;
	var arrFormatoExportacion=[['1','Excel'],['2','JSON'],['3','XML']];
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
                                                            html:'Formato de exportaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:55,
                                                            html:'<div id="divCmbFormatoExportacion"></div>'
                                                        }
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Exportar versi&oacute;n de TRD',
										width: 450,
										height:240,
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
                                                                	cmbFormatoExportacion=crearComboExt('cmbFormatoExportacion',arrFormatoExportacion,0,0,400,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbFormatoExportacion'});
                                                                
                                                                	cmbFormatoExportacion.focus(false,500);
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
                                                        {
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		if(gEx('cmbFormatoExportacion').getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbFormatoExportacion.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar el formato de exportaci&oacute;n',resp)
                                                                        	return;
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        var arrParametros=[['idTablaRetencion',gE('idTablaRetencion').value],['version',versionSel],['formatoExportacion',gEx('cmbFormatoExportacion').getValue()]];
                                                                        enviarFormularioDatosV('../gestorDocumental/exportarTRD.php',arrParametros);
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();
}