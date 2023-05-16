<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);

	$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
	if($idFormulario==708)
	{
		$consulta="SELECT carpetaAministrativaOrdenNotificacion FROM _708_tablaDinamica WHERE id__708_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
	
	}
	
	
?>	


var carpetaAdministrativa='<?php echo $carpetaAdministrativa?>';
Ext.onReady(inicializar);

function inicializar()
{
	
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                border:false,
                                                layout:'border',
                                                items:	[
                                                         	new Ext.ux.IFrameComponent({ 

                                                                                            id: 'frameContenidoExpediente', 
                                                                                            anchor:'95% 100%',
                                                                                            region:'center',
                                                                                            loadFuncion:function(iFrame)
                                                                                                        {
                                                                                                            
                                                                                                            
                                                                                                        },
    
                                                                                            url: '../paginasFunciones/white.php',
                                                                                            style: 'width:95%;height:500px' 
                                                                                    })   
                                                        ]
                                            }
                                         ]
                            }
                        )   


	gEx('frameContenidoExpediente').load (
    											{
                                                      scripts:true,
                                                      url:'../modulosEspeciales_SGJ/tableroAudienciaAdministracion.php',
                                                      params:	{
                                                                	cA:bE(carpetaAdministrativa),
                                                                    sL:<?php echo existeRol("'32_0'")?0:1 ?>  
                                                              	}
                                                 }
    									)
}