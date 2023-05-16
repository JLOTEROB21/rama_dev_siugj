<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
?>


function inyeccionCodigo()
{
	
	if(esRegistroFormulario())
    {
        if(typeof(obtenerDatosWebV2)=='undefined')
        {
            loadScript('../Scripts/funcionesAjaxV2.js', function()
                                                        {
                                                            determinarCentroReclusion();
                                                        }
                        );
        }
        else
        {
            determinarCentroReclusion();
        }
        
        
	}
    else
    {
    	if(gE('sp_5326').innerHTML=='Si')
        {
            mE('div_5327');
            mE('div_5328');
        }
        else
        {
        	if(gE('sp_5326').innerHTML=='')
            {
            	oE('div_5325');
            }
            oE('div_5327');
            oE('div_5328');
        }
    }
}

function determinarCentroReclusion()
{
	var cAdministrativa=gEN('_carpetaAdministrativavch')[0].value;
    
    
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            if(arrResp[1]=='1')
            {
            	mE('div_5325');
                mE('div_5326');
                mE('div_5334');
                gE('_prisionPreventivavch').setAttribute('val','obl');
                
            }
            else
            {
            	oE('div_5325');
                oE('div_5326');
                gE('_reclusoriovch').setAttribute('val','');
                
            }
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=110&cAdministrativa='+cAdministrativa,true);
    
    
    
}
