<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria in(1,2)  ORDER BY prioridad";

	$arrUnidadesGestion=$con->obtenerFilasArreglo($consulta);
?>	

var arrUnidadesGestion=<?php echo $arrUnidadesGestion?>;
Ext.onReady(inicializar);

function inicializar()
{
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidadesGestion,0,0,400);
    cmbUnidadGestion.setValue(arrUnidadesGestion[0][0]);
    cmbUnidadGestion.on('select',recargarFrame);
    
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
                                                                html:'<b>Unidad de Gesti&oacute;n Judicial:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbUnidadGestion,'-',
                                                            {
                                                                icon:'../imagenesDocumentos/16/file_extension_xlsx.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Exportar...',
                                                                menu:	[
                                                                			{
                                                                                
                                                                                
                                                                                text:'Estructura unidad de gestión',
                                                                                handler:function()
                                                                                        {
                                                                                            enviarFormularioDatos('../modulosEspeciales_SGJP/exportarInformacionOrganigrama.php',[['uG',cmbUnidadGestion.getValue()]]);
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                
                                                                                
                                                                                text:'Estructura de las unidades de gestión judicial por edificio',
                                                                                handler:function()
                                                                                        {
                                                                                            enviarFormularioDatos('../modulosEspeciales_SGJP/exportarInformacionOrganigramaGeneral.php',[]);
                                                                                        }
                                                                                
                                                                            }
                                                                		]
                                                                
                                                            }
                                                           
                                                		],
                                                items:	[
                                                            new Ext.ux.IFrameComponent({ 

                                                                                            id: 'frameVistaOrganigrama', 
                                                                                            anchor:'100% 100%',
                                                                                            region:'center',
                                                                                            
    
                                                                                            url: '../paginasFunciones/white.php',
                                                                                            style: 'width:100%;height:100%' 
                                                                                    })
                                                        ]
                                            }
                                         ]
                            }
                        )   
	recargarFrame();
}

function recargarFrame()
{
	gEx('frameVistaOrganigrama').load	(
    								{
                                        url:'../modulosEspeciales_SGJP/tblOrganigrama.php',
                                        params:	{
                                                    uG:gEx('cmbUnidadGestion').getValue()
                                                }
    								}
                                )
}                                