<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT u.idUsuario,CONCAT(u.Nombre,' (',uG.nombreUnidad,')')AS nombre FROM _26_tablaDinamica t,800_usuarios u,_17_tablaDinamica uG WHERE usuarioJuez<>-1 AND usuarioJuez IS NOT NULL AND u.idUsuario=t.usuarioJuez
			AND uG.id__17_tablaDinamica=t.idReferencia AND idUsuario NOT IN(3122) ORDER BY u.Nombre";
	$arrJueces=$con->obtenerFilasArreglo($consulta);
?>

var arrJueces=<?php echo $arrJueces?>;

Ext.onReady(inicializar);

function inicializar()
{
	var cmbJuecez=crearComboExt('cmbJuecez',arrJueces,0,0,700);
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
                                                                html:'<b>Indique el juez cuyo informe desea obtener:</b>&nbsp;&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbJuecez,'-',
                                                            {
                                                                icon:'../images/script_go.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Generar informe',
                                                                handler:function()
                                                                        {
                                                                           var idJuez=gEx('cmbJuecez').getValue();
                                                                           if(idJuez=='')
                                                                           {
                                                                           		function resp()
                                                                                {
                                                                                	gEx('cmbJuecez').focus();
                                                                                }
                                                                           		msgBox('Debe seleccionar el juez cuyo informe desea generar',resp);
                                                                                return;
                                                                           }
                                                                           
                                                                           
                                                                           var arrParam=[['fechaInicio',window.parent.gEx('dtrFechaInicio').getValue().format('Y-m-d')],['fechaFin',window.parent.gEx('dtrFechaFin').getValue().format('Y-m-d')],['idJuez',idJuez]];
                                                                           enviarFormularioDatos('../modulosEspeciales_SGJP/informeDesempenioJuez.php',arrParam);
                                                                           
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