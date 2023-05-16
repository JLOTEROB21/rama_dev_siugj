<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos ORDER BY nombreCategoria";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	$fechaActual=date("Y-m-d");
	
?>
var arrCategorias=<?php echo $arrCategorias?>;

Ext.onReady(inicializar);

function inicializar()
{
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraTituloMetaDatos"><b>Reporte de Autos a Notificar por Estado</b></span>',
                                                tbar:	[
                                                			{
                                                            	xtype:'label',
                                                                cls:'letraLicenciaSub',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo del:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtePeriodoInicial',
                                                                value:'<?php echo $fechaActual?>',
                                                                listeners:	{
                                                                				select:function()
                                                                                		{
                                                                                        	recargarGridReporteEstado();
                                                                                        }
                                                                                        
                                                                			}
                                                            },'-',
                                                            {
                                                            	xtype:'label',
                                                                cls:'letraLicenciaSub',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>al:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dtePeriodoFinal',
                                                                value:'<?php echo $fechaActual?>',
                                                                listeners:	{
                                                                				select:function()
                                                                                		{
                                                                                        	recargarGridReporteEstado();
                                                                                        }
                                                                                        
                                                                			}
                                                            },'-',
                                                            {
                                                                icon:'../imagenesDocumentos/16/file_extension_pdf.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Exportar',
                                                                handler:function()
                                                                        {
                                                                            var arrParams=[['fechaInicio',gEx('dtePeriodoInicial').getValue().format('Y-m-d')],['fechaFin',gEx('dtePeriodoFinal').getValue().format('Y-m-d')]];
                                                                        	enviarFormularioDatos('../modulosEspeciales_SIUGJ/exportarReporteAutosNotificaPorEstado.php',arrParams,'GET');
                                                                        }
                                                                
                                                            }
                                                		],
                                                items:	[
                                                            crearGridReporteEstado()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridReporteEstado()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'nombreAuto'},
                                                        {name: 'tipoDocumento'},
                                                        {name:'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'enviadoEstado'},
                                                        {name:'fechaEnvioEstado', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'carpetaAdministrativa'},
                                                        {name:'iFormulario'},
                                                        {name:'iRegistro'}                                                        
		                                                
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaCreacion', direction: 'ASC'},
                                                            groupField: 'fechaCreacion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='9';
                                        proxy.baseParams.fechaInicio=gEx('dtePeriodoInicial').getValue().format('Y-m-d');
                                        proxy.baseParams.fechaFin=gEx('dtePeriodoFinal').getValue().format('Y-m-d');
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha de Creaci&oacute;n',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Nombre del Auto',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'nombreAuto'
                                                            },
                                                             
                                                            {
                                                                header:'Tipo de Documento',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'tipoDocumento',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrCategorias,val);
                                                                        }
                                                            },
                                                             {
                                                                header:'Notificado por Estado',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'enviadoEstado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val=='1'?'S&iacute;':'No';
                                                                        }
                                                            },
                                                             {
                                                                header:'Fecha de Notificaci&oacute;n',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'fechaEnvioEstado'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gReporteEstado',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,                                                                
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


function recargarGridReporteEstado()
{
	gEx('gReporteEstado').getStore().reload();
}