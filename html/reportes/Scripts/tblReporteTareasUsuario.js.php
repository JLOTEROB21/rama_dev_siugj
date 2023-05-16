<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT distinct r.idRol,r.nombreGrupo FROM 801_adscripcion a,807_usuariosVSRoles u,8001_roles r WHERE Institucion='".$_SESSION["codigoInstitucion"]."'
				AND u.idUsuario=a.idUsuario AND r.idRol=u.idRol ORDER BY r.nombreGrupo";

	$arrRoles=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT distinct r.idRol FROM 801_adscripcion a,807_usuariosVSRoles u,8001_roles r WHERE Institucion='".$_SESSION["codigoInstitucion"]."'
				AND u.idUsuario=a.idUsuario AND r.idRol=u.idRol ORDER BY r.nombreGrupo";
	$listaRoles=$con->obtenerListaValores($consulta);
?>
var listaRoles='<?php echo $listaRoles?>';
var arrRoles=<?php echo $arrRoles?>;
Ext.onReady(inicializar);

function inicializar()
{
	var cmbRoles=crearComboExt('cmbRoles',arrRoles,0,0,600,{multiSelect:true});
    cmbRoles.setValue(listaRoles);
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                tbar:	[
                                                			{
                                                            	x:10,
                                                                y:10,
                                                                html:'<span class="SIUGJ_Etiqueta">Periodo del:&nbsp;&nbsp;</span>'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dteFechaInicio',
                                                                value:'<?php echo date("Y-m-d") ?>',
                                                                listeners:	{
                                                                				'select':function()
                                                                                		{
                                                                                        	
                                                                                        }
                                                                			}
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
                                                                listeners:	{
                                                                				'select':function()
                                                                                		{
                                                                                        	
                                                                                        }
                                                                			}
                                                            },
                                                            {
                                                            	x:10,
                                                                y:10,
                                                                html:'<span class="SIUGJ_Etiqueta">&nbsp;&nbsp;Roles a considerar:&nbsp;&nbsp;</span>'
                                                            },
                                                            cmbRoles,'-',
                                                            {
                                                                icon:'../images/Reinscribir.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Consultar',
                                                                handler:function()
                                                                        {
                                                                            recargarReporte()
                                                                        }
                                                                
                                                            }
                                                            
                                                		],
                                                items:	[
                                                             new Ext.ux.IFrameComponent({ 

                                                                                        id: 'frameContenidoReporte', 
                                                                                        anchor:'100% 100%',
                                                                                        border:false,
                                                                                        region:'center',
                                                                                        loadFuncion:function(iFrame)
                                                                                                    {
                                                                                                    	
                                                                                                        
                                                                                                        autofitIframe(iFrame,
                                                                                                        				function()
                                                                                                                        {
                                                                                                                        	/*setTimeout(function()
                                                                                                                            {
                                                                                                                                if(autoScroll>0)
                                                                                                                                	window.scrollTo(0,autoScroll);
                                                                                                                                
                                                                                                                            },500);*/
                                                                                                                         });
                                                                                                        
                                                                                                    },

                                                                                        url: '../paginasFunciones/white.php',
                                                                                        style: 'width:100%;height:700px' 
                                                                                })
                                                        ]
                                            }
                                         ]
                            }
                        )   

	recargarReporte();
}


function recargarReporte()
{
	gEx('frameContenidoReporte').load	(
    										{	
                                            	url:'../reportes/frmReporteTareasUsuario.php',
                                                params:	{
                                                			fechaInicio:gEx('dteFechaInicio').getValue().format('Y-m-d'),
                                                            fechaFin:gEx('dteFechaFin').getValue().format('Y-m-d'),
                                                            cPagina: 'sFrm=true',
                                                            roles:gEx('cmbRoles').getValue()
                                                		}
                                            }
    									)
}