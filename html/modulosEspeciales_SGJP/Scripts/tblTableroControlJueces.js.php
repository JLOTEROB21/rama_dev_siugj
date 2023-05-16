<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


var arrEventos=[['1','Roles de Guardias'],['3','Incidencias de Jueces/Jueces/Magistrados'],['4','Vacaciones de Jueces/Magistrados']];



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
                                                cls:'panelSiugj',
                                                tbar:	[
                                                			{
                                                                
                                                            	html:'<div class="letraNombreTableroNegro">Tipo de eventos a observar:</div>'
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:15
                                                            },
                                                            {
                                                            	html:'<div id="divComboAccion"></div>'
                                                            }
                                                		],
                                                items:	[
                                                			{
                                                            	xtype:'panel',
                                                                region:'center',
                                                                border:false,
                                                            	items:	[
                                                                            new Ext.ux.IFrameComponent({ 
                                
                                                                                                              id: 'frameControl', 
                                                                                                              anchor:'100% 100%',
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


	var cmbAccion=crearComboExt('cmbAccion',arrEventos,0,0,450,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboAccion'});
    
    
    cmbAccion.on('select',function(cmb,registro)
    						{
                            
                            	var idUnidadGestion='';
                                switch(registro.data.id)
                                {
                                	case '1':
                                    	urlDestino='../modulosEspeciales_SGJP/tblCalendarioJuezGuardia.php';
                                    break;
                                    case '2':
                                    	urlDestino='../modulosEspeciales_SGJP/tblCalendarioJuezTramite.php';
                                    break;
                                    case '3':
                                    	urlDestino='../modulosEspeciales_SGJP/tblAgendaJuezIncidencias.php';
                                    	
                                    break;
                                    case '4':
                                    	urlDestino='../modulosEspeciales_SGJP/tblAgendaJuezVacaciones.php';
                                    break;
                                }
                            
                            	gEx('frameControl').load	(
                                								{
                                                                	url:urlDestino,
                                                                    params:	{
                                                                    			idUnidadGestion:gE('idUnidadGestion').value,
                                                                                cPagina:'sFrm=true'
                                                                    		}
                                                                }
                                							)
                            }
    			)


}
