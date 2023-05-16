<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT concat('\"',claveUnidad,'\"') as claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE esDespacho=1  ORDER BY categoriaDespacho,nombreUnidad";
	$arrDespachos=$con->obtenerFilasArreglo($consulta);
	
?>
var arrDespachos=<?php echo $arrDespachos?>;
Ext.onReady(inicializar);

function inicializar()
{
	arrDespachos.splice(0,0,['0','Cualquiera']);
    
    
	var cmbDespacho=crearComboExt('cmbDespacho',arrDespachos,0,0,250);
    cmbDespacho.setValue('0');
    var cmbTipoNotificacion=crearComboExt('cmbTipoNotificacion',[['0','Cualquiera'],['1','Notificados'],['2','NO Notificados']],0,0,350);
    cmbTipoNotificacion.setValue('0');
    
    
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
                                                            	html:'&nbsp;&nbsp;<span class="SIUGJ_Etiqueta">Situaci&oacute;n Notificaci&oacute;n:</span>&nbsp;&nbsp;'
                                                                
                                                            },
                                                            cmbTipoNotificacion
                                                            
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
                                                                                                            ['tipoNotificacion',gEx('cmbTipoNotificacion').getValue()],
                                                                                                            ['despacho',gEx('cmbDespacho').getValue()],
                                                                                                            ['fechaInicio',gEx('dteFechaInicio').getValue().format('Y-m-d')],
                                                                                                            ['fechaFin',gEx('dteFechaFin').getValue().format('Y-m-d')]
                                                                                                        ];
                                                                                            enviarFormularioDatos('../reportes/reporteNotificaciones.php',arrDatos);
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
                                            	url:'../reportes/reporteNotificaciones.php',
                                                params: {
                                                			formato:gE('formato').value,
                                                            disposicion:1,
                                                            tipoNotificacion:gEx('cmbTipoNotificacion').getValue(),
                                                            
                                                            despacho: gEx('cmbDespacho').getValue(),
                                                            fechaInicio:gEx('dteFechaInicio').getValue().format('Y-m-d'),
                                                            fechaFin:gEx('dteFechaFin').getValue().format('Y-m-d')
                                                		}
                                            }
    									)
}