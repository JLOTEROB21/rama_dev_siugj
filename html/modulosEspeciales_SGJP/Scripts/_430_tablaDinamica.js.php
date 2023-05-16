<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);

	$consulta="SELECT rolDestinatarioEnvioFirma FROM _430_tablaDinamica WHERE id__430_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	
	$funcionDestinatario=$fRegistro[0];
	if($funcionDestinatario=="")
		$funcionDestinatario=-1;
	
	
?>	

var funcionDestinatario='<?php echo $funcionDestinatario?>';

function inyeccionCodigo()
{
	if(esRegistroFormulario())
	{
    	var opt=cE('option');
        opt.text='Función de sistema';
        opt.value='0';
    	gE('_rolDestinatarioEnvioFirmavch').options[gE('_rolDestinatarioEnvioFirmavch').options.length]=opt;
        
        asignarEvento('_rolDestinatarioEnvioFirmavch','change',function()
        													{
                                                            	var combo=gE('_rolDestinatarioEnvioFirmavch');
                                                                var valor=combo.options[combo.selectedIndex].value;
                                                                if(valor=='0')
                                                                {
                                                                	mE('div_8285');
                                                                }
                                                                else
                                                                {
                                                                	oE('div_8285');
                                                                    gE('_funcionDestinatariovch').value='';
                                                                    gEx('ext__funcionDestinatariovch').setValue('');
                                                                }
                                                            }
                     )
        
        selElemCombo(gE('_rolDestinatarioEnvioFirmavch'),funcionDestinatario);
        lanzarEvento('_rolDestinatarioEnvioFirmavch','change');
        
        
    }
    else
    {
    	if(funcionDestinatario=='0')
        {
	    	gE('sp_6837').innerHTML='Función de sistema';	
            
        }
        else
        	oE('div_8285');
    }
    
    
    
}