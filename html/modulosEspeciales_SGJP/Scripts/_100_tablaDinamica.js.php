<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
		
		
?>

var idRegistro=<?php echo $idRegistro?>;

function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	oE('div_10070');
        oE('div_10072');
        
    	if(gE('idRegistroG').value=='-1')
        {
        	selElemCombo(gE('_sistemavch'),'1');
            lanzarEvento(gE('_sistemavch'),'change');
        }
    }
    else
    {
    
    }
}