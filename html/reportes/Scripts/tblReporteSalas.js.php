<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica";
	$arrSedes=$con->obtenerFilasArreglo($consulta);
?>

var arrSedes=<?php echo $arrSedes?>;
Ext.onReady(inicializar);

function inicializar()
{
	var cmbSede=crearComboExt('cmbSede',arrSedes,0,0,350);
    cmbSede.on('select',recargarReporte);
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
                                                                html:'<span class="SIUGJ_Etiqueta">Sede:</span>&nbsp;&nbsp;'
                                                            },
                                                            cmbSede
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

	
}


function recargarReporte()
{
	gEx('frameContenidoReporte').load	(
    										{	
                                            	url:'../reportes/frmlSalas.php',
                                                params:	{
                                                			idSede:gEx('cmbSede').getValue(),
                                                            cPagina: 'sFrm=true'
                                                		}
                                            }
    									)
}