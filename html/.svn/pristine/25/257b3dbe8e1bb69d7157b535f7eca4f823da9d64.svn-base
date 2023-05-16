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

	var urlConfiguracionSL='../../modulosEspeciales_SGJP/Scripts/configCKEditorEjecucionSL.js';
    var urlConfiguracion='../../modulosEspeciales_SGJP/Scripts/configCKEditorEjecucion.js';
    
	var editor1=	CKEDITOR.replace('txtDocumento',
                                                     {
                                                     	
                                                        customConfig:(gE('sL').value=='1'?urlConfiguracionSL:urlConfiguracion),
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

	if(gE('sL').value=='1')
	    editor1.setReadOnly(true);

    
}

function refrescarMenuDTD()
{
	window.parent.mostrarMenuDTD();
}