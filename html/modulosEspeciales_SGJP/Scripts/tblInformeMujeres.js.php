<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	
?>

var arrTipoInforme=[['1','Informe de carpetas con mujeres como victima'],['2','Informe de carpetas bajo delito de feminicidio']];

Ext.onReady(inicializar);

function inicializar()
{
	var cmbTipoInforme=crearComboExt('cmbTipoInforme',arrTipoInforme,0,0,300);
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
                                                                html:'<b>Indique el tipo de informe desea obtener:</b>&nbsp;&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbTipoInforme,'-',
                                                            {
                                                                icon:'../images/script_go.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Generar informe',
                                                                handler:function()
                                                                        {
                                                                           var tipoInforme=gEx('cmbTipoInforme').getValue();
                                                                           if(tipoInforme=='')
                                                                           {
                                                                           		function resp()
                                                                                {
                                                                                	gEx('cmbTipoInforme').focus();
                                                                                }
                                                                           		msgBox('Debe seleccionar el tipo de informe desea generar',resp);
                                                                                return;
                                                                           }
                                                                           
                                                                           
                                                                           var arrParam=[['fechaInicio',gE('fechaInicio').value],['fechaFin',gE('fechaFin').value],['tipoInforme',tipoInforme]];
                                                                           enviarFormularioDatos('../modulosEspeciales_SGJP/generarInformeMujeres.php',arrParam);
                                                                           
                                                                        }
                                                                
                                                            }
                                                		],
                                               
                                                items:	[
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   
}