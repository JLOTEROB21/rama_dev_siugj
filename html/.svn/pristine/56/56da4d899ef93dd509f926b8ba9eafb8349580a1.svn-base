<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);
	
	$idReferencia=($_GET["iRef"]);


	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica ORDER BY nombreTipo";
	$arrParticipante=$con->obtenerFilasArreglo($consulta);
	
?>

var arrParticipante=<?php echo $arrParticipante?>;
function inyeccionCodigo()
{

    if(esRegistroFormulario())
    {
    
    	var combo=gE('_participantevch');
        
        
       	var option=document.createElement('option');
      	option.text='Otro';
      	option.value='0';
      
      	combo.options[combo.length]=option;
        
        asignarEvento(gE('_participantevch'),'change',function(cmb)
        												{
                                                        	var opcion=cmb.options[cmb.selectedIndex].value;
                                                            if(opcion=='0')
                                                            {
                                                            	mE('div_16018');
                                                                mE('div_16019');
                                                                gE('_tiposFiguravch').setAttribute('val','obl');
                                                                gE('_relacionadoConvch').setAttribute('val','obl');
                                                                
                                                                
                                                            }
                                                            else
                                                            {
                                                            	oE('div_16018');
                                                                oE('div_16019');
                                                                oE('div_16020');
                                                                oE('div_16021');
                                                                gE('_tiposFiguravch').setAttribute('val','');
                                                                gE('_tiposFiguravch').selectedIndex=0;
                                                                
                                                                gE('_relacionadoConvch').setAttribute('val','');
                                                                gE('_relacionadoConvch').selectedIndex=0;
                                                            }
                                                        }
                      )
        
        
        
    }
    else
    {
    	
    }
}

