<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	
	$consulta="SELECT  idEstado FROM _578_tablaDinamica WHERE id__578_tablaDinamica=".$idRegistro;
	$idEstado=$con->obtenerValor($consulta);
?>	

var idEstado=<?php echo $idEstado?>;
function inyeccionCodigo()
{
	     
	if(idEstado==2)
    {
    	oE('div_9418');
        oE('div_9417');
        oE('div_9420');
        
        
        
    }
    else
    {
    	oE('div_9428');
        oE('div_9429');
    }
    

}	
