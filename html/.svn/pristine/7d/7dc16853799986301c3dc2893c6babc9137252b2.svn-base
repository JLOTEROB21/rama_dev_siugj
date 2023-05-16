<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	
?>

var validandoBillete=false;
var cadenaFuncionValidacion='validarBilleteDeposito';


function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	
    	if(gE('idRegistroG').value=='-1')
        {
        	
        	if(gEx('f_sp_fechaRecepciondte'))
            {
             	gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
             
             	gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
             	gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
             }
             if(gEx('f_sp_horaRecepciontme'))
             {
	             gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
             	gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
             }
         }
         gE('_noBilletevch').setAttribute('onkeypress','return soloNumero(event,false,false,this)');
         asignarEvento('_noBilletevch','change',function()
                                                        {
                                                            function funcAjax()
                                                            {
                                                                var resp=peticion_http.responseText;
                                                                arrResp=resp.split('|');
                                                                if(arrResp[0]=='1')
                                                                {
                                                                    if(arrResp[1]=='1')
                                                                    	mE('div_8669');
                                                                    else
                                                                    	oE('div_8669');
                                                                }
                                                                else
                                                                {
                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                }
                                                            }
                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=203&iR='+
                                                            				gE('idRegistroG').value+'&nB='+gE('_noBilletevch').value,true);
                                                        }
         
                       );
         
	}
    
}

function validarBilleteDeposito()
{
	if(gE('div_8669').style.display=='')
    {
    	msgBox('El número de billete ingresado ya ha sido registrado previamente!');
    	return false;
    }
    
    return true;
}

