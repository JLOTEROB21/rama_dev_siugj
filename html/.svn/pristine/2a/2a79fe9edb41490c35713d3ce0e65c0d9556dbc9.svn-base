<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);

	
?>
var idEvento=-1;
var cadenaFuncionValidacion='prepararGuardado';

Ext.onReady(inicializar);


function inicializar()
{
	if(esRegistroFormulario())
    {
        var carpetaAdministrativa=gEN('_carpetaAdministrativavch')[0];
        if(gE('idRegistroG').value=='-1')
        {
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    gE('opt_materiaDestinovch_'+arrResp[2]).checked=true;
                    gE('_materiaDestinovch').value=arrResp[2];
                    if(arrResp[3]!='-1')
                    {
	                    selElemCombo(gE('_fiscaliavch'),arrResp[3]);
                        gE('_fiscaliavch').disabled=true;
                    }
                    
                    
                    switch(arrResp[1])
                    {
                        case 'A':
                            gE('opt_motivoIncompetenciavch_2').disabled=true;
                            gE('opt_motivoIncompetenciavch_1').disabled=true;
                            gE('opt_motivoIncompetenciavch_2').checked=true;
                            gE('_motivoIncompetenciavch').value='2';
                        break;
                        case 'B':
                            gE('opt_motivoIncompetenciavch_2').disabled=true;
                            gE('opt_motivoIncompetenciavch_1').disabled=true;
                            gE('opt_motivoIncompetenciavch_1').checked=true;
                            gE('_motivoIncompetenciavch').value='1';
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
}


function prepararGuardado()
{
	var _fiscaliavch=gE('_fiscaliavch');
	if((gE('_materiaDestinovch').value=='1')&&(gE('_motivoIncompetenciavch').value=='2'))
    {
    	var valor=	_fiscaliavch.options[_fiscaliavch.selectedIndex].value;
        if(parseInt(valor)==-1)
        {
        	msgBox('Debe indicar la fiscal&iacute;a de la carpeta a remitir');
        	return false;
        }
    }
    
    gE('_fiscaliavch').disabled=false;
	return true;
}