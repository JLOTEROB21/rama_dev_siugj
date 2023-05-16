<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__628_tablaDinamica,nombreRecurso FROM _628_tablaDinamica";
	$arrRecursos=$con->obtenerFilasArreglo($consulta);
	$fechaActual=date("Y-m-d");
	$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE codigoUnidad IN('00020008','00020003') ORDER BY unidad";
	$arrReclusorios=$con->obtenerFilasArreglo($consulta);
	
?>

var arrReclusorios=<?php echo $arrReclusorios?>;
var arrRecursos=<?php echo $arrRecursos?>;
Ext.onReady(inicializar);

function inicializar()
{
	arrReclusorios.splice(0,0,['0','Cualquiera']);
	var cmbReclusorio=crearComboExt('cmbReclusorio',arrReclusorios,0,0,450);
    cmbReclusorio.setValue('0');
	 new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Uso de Cub&iacute;culos<span style="color:#000"></span></b></span>',
                                                tbar:	[
                                                			{
                                                            	html:'<b>Reclusorio a observar:&nbsp;&nbsp;</b>'
                                                            },
                                                            cmbReclusorio,'-',
                                                            {
                                                                icon:'../images/icon_big_tick.gif',
                                                                cls:'x-btn-text-icon',
                                                                text:'Generar',
                                                                handler:function()
                                                                        {
                                                                            recargarAgendaCabinas();
                                                                        }
                                                                
                                                            }
                                                		],
                                                
                                                items:	[
                                                			{
                                                            	xtype:'panel',
                                                                region:'center',
                                                                items:	[
                                                                			new Ext.ux.IFrameComponent({ 
                
                                                                                            id: 'frameContenidoAudienciaGlobal', 
                                                                                            anchor:'100% 100%',
                                                                                            region:'center',
                                                                                            loadFuncion:function(iFrame)
                                                                                                        {
                                                                                                            
                                                                                                            //autofitIframe(iFrame);
                                                                                                        },

                                                                                            url: '../paginasFunciones/white.php',
                                                                                            style: 'width:100%;height:100%' 
                                                                                    })
                                                                		]
                                                            }
                                                			
                                                            /**/
                                                        ]
                                            }
                                         ]
                            }
                        )  
}




function recargarAgendaCabinas()
{
	gEx('frameContenidoAudienciaGlobal').load(	{
    											url:'../modulosEspeciales_SGJP/tblTableroAudienciasCabina.php',
                                                params:	{
                                                			adscripcion:gEx('cmbReclusorio').getValue(),
                                                            vistaGlobal:1
                                                         }
    										});
}