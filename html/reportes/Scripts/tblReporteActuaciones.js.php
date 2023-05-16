<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT concat('\"',claveUnidad,'\"') as claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE esDespacho=1  ORDER BY categoriaDespacho,nombreUnidad";
	$arrDespachos=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT id__624_tablaDinamica,nombreActuacion FROM _624_tablaDinamica ORDER BY nombreActuacion";
	$arrActuaciones=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica WHERE id__625_tablaDinamica NOT IN (12,10) ORDER BY nombreTipoProceso";
	$arrTiposProceso=$con->obtenerFilasArreglo($consulta);
?>
var arrActuaciones=<?php echo $arrActuaciones?>;
var arrTiposProceso=<?php echo $arrTiposProceso?>;
var arrDespachos=<?php echo $arrDespachos?>;
Ext.onReady(inicializar);

function inicializar()
{
	arrDespachos.splice(0,0,['0','Cualquiera']);
    arrActuaciones.splice(0,0,['0','Cualquiera']);
    arrTiposProceso.splice(0,0,['0','Cualquiera']);
	var cmbDespacho=crearComboExt('cmbDespacho',arrDespachos,0,0,250);
    cmbDespacho.setValue('0');
    var cmbTipoActuacion=crearComboExt('cmbTipoActuacion',arrActuaciones,0,0,350,{multiSelect:true});
    cmbTipoActuacion.setValue('0');
    var cmbTipoProceso=crearComboExt('cmbTipoProceso',arrTiposProceso,0,0,350,{multiSelect:true});
    cmbTipoProceso.setValue('0');
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                tbar:	[
                                                			{
                                                            	xtype:'label',
                                                            	html:'<span class="SIUGJ_Etiqueta">Despacho:</span>&nbsp;&nbsp;'
                                                                
                                                            },
                                                            cmbDespacho,
                                                            {
                                                            	xtype:'label',
                                                            	html:'&nbsp;&nbsp;<span class="SIUGJ_Etiqueta">Tipo de Actuaci&oacute;n:</span>&nbsp;&nbsp;'
                                                                
                                                            },
                                                            cmbTipoActuacion,
                                                            {
                                                            	xtype:'label',
                                                            	html:'&nbsp;&nbsp;<span class="SIUGJ_Etiqueta">Tipos de Proceso:</span>&nbsp;&nbsp;'
                                                                
                                                            },
                                                            cmbTipoProceso
                                                            
                                                		],
                                                items:	[
                                                
                                                			{
                                                            	xtype:'panel',
                                                                region:'center',
                                                				layout:'border',
                                                                tbar:	[
                                                                			{
                                                                                x:10,
                                                                                y:10,
                                                                                html:'<span class="SIUGJ_Etiqueta">Periodo del:</span>&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                                xtype:'datefield',
                                                                                id:'dteFechaInicio',
                                                                                value:'<?php echo date("Y-m-d") ?>',
                                                                                
                                                                            },
                                                                            {
                                                                                x:10,
                                                                                y:10,
                                                                                html:'<span class="SIUGJ_Etiqueta">&nbsp;&nbsp;al:&nbsp;&nbsp;</span>'
                                                                            },
                                                                             {
                                                                                xtype:'datefield',
                                                                                id:'dteFechaFin',
                                                                                value:'<?php echo date("Y-m-d") ?>',
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/Reinscribir.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Consultar',
                                                                                handler:function()
                                                                                        {
                                                                                        	gEx('btnExcel').enable();
                                                                                            gerenerarReporte()
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../imagenesDocumentos/16/file_extension_xlsx.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                id:'btnExcel',
                                                                                text:'Exportar a Excel',
                                                                                handler:function()
                                                                                        {
                                                                                            var arrDatos=[['formato','2'],['disposicion','1'],
                                                                                                            ['tipoProceso',gEx('cmbTipoProceso').getValue()],
                                                                                                            ['tipoActuacion',gEx('cmbTipoActuacion').getValue()],
                                                                                                            ['despacho',gEx('cmbDespacho').getValue()],
                                                                                                            ['fechaInicio',gEx('dteFechaInicio').getValue().format('Y-m-d')],
                                                                                                            ['fechaFin',gEx('dteFechaFin').getValue().format('Y-m-d')]
                                                                                                        ];
                                                                                            enviarFormularioDatos('../reportes/reporteActuaciones.php',arrDatos);
                                                                                        }
                                                                                
                                                                            }
                                                                		],
                                                                items:	[
                                                
                                                                            new Ext.ux.IFrameComponent({ 
                            
                                                                                                                        id: 'frameContenidoReporte', 
                                                                                                                        anchor:'100% 100%',
                                                                                                                        region:'center',
                                                                                                                        loadFuncion:function(iFrame)
                                                                                                                                    {
                                                                                                                                        
                                                                                                                                    },
            
                                                                                                                        url: '../paginasFunciones/white.php',
                                                                                                                        style: 'width:100%;height:100%' 
                                                                                                                })
                                                            
                                                        				]
                                                        	}
                                                        ]
                                            }
                                         ]
                            }
                        )   

	
}


function gerenerarReporte()
{
	gEx('frameContenidoReporte').load	(
    										{
                                            	url:'../reportes/reporteActuaciones.php',
                                                params: {
                                                			formato:gE('formato').value,
                                                            disposicion:1,
                                                            tipoProceso:gEx('cmbTipoProceso').getValue(),
                                                            tipoActuacion:gEx('cmbTipoActuacion').getValue(),
                                                            despacho: gEx('cmbDespacho').getValue(),
                                                            fechaInicio:gEx('dteFechaInicio').getValue().format('Y-m-d'),
                                                            fechaFin:gEx('dteFechaFin').getValue().format('Y-m-d')
                                                		}
                                            }
    									)
}