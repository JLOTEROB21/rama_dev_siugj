<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);

	
?>
var idEvento=-1;

Ext.onReady(inicializar);


function inicializar()
{
	if(esRegistroFormulario())
    {
        var carpetaAdministrativa=gEN('_carpetaAdministrativavch')[0];
        
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                arrResp[1]='X';
                switch(arrResp[1])
                {
                    case 'A':
                        gE('opt_calsificacionvch_0').disabled=true;
                        gE('opt_calsificacionvch_1').disabled=true;
                        gE('opt_calsificacionvch_0').checked=true;
                        gE('_calsificacionvch').value='0';
                    break;
                    case 'B':
                        gE('opt_calsificacionvch_0').disabled=true;
                        gE('opt_calsificacionvch_1').disabled=true;
                        gE('opt_calsificacionvch_1').checked=true;
                         gE('_calsificacionvch').value='1';
                    break;
                    case 'X':
                    break;
                    
                }
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=149&cA='+carpetaAdministrativa.value,true);

   	} 
}