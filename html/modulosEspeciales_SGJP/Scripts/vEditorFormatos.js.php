<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__44_tablaDinamica,CONCAT(IF(claveTipoMarcador='','',CONCAT('[',claveTipoMarcador,'] ')),nombreMarcador) AS marcador,descripcion 
				FROM _44_tablaDinamica WHERE situacion=1";
	$arrTiposMarcadores=$con->obtenerFilasArreglo($consulta);
?>


var IDMarcadores=0;
var arrTiposMarcadores=<?php echo $arrTiposMarcadores?>;

Ext.onReady(inicializar);

function inicializar()
{

	var editor1=	CKEDITOR.replace('txtDocumento',
                                                     {
                                                     	
                                                        customConfig:'../../modulosEspeciales_SGJP/Scripts/configCKEditorEjecucionSL.js',
                                                        on:	{
                                                        		instanceReady:function(evt)
                                                                			{
                                                                            	evt.editor.execCommand('maximize');
                                                                                var boton=$('.cke_button__psavefirmaelectronica');
                                                                               
                                                                                if((boton.length>0)&&(!objConfiguracionFirmaElectronica))
                                                                                {
                                                                                	boton[0].style.display='none';
                                                                                }
                                                                            }
                                                                
                                                        	}
                                                     }
                                    );
                                    
	                  
	editor1.setData(bD(gE('txtCuerpo').value));

	

    
}

function refrescarMenuDTD()
{
	window.parent.mostrarMenuDTD();
}