<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$consulta="SELECT * FROM _487_tablaDinamica WHERE id__487_tablaDinamica=".$idReferencia;
	
	$fBase=$con->obtenerPrimeraFilaAsoc($consulta);
	$tipoAcuerdo="";
	switch($fBase["iFormulario"])
	{
		case 480:
			$consulta="SELECT * FROM _480_tablaDinamica WHERE id__480_tablaDinamica=".$fBase["iReferencia"];
			$fOrigen=$con->obtenerPrimeraFilaAsoc($consulta);
			$tipoAcuerdo=$fOrigen["tipoDocumento"];
		break;
		default:
		break;
	}
	
	
?>
var tipoAcuerdo=<?php echo $tipoAcuerdo?>;

function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	
        
        gEx('f_sp_fechaResoluciondte').setValue('<?php echo $fBase["fechaAcuerdo"]?>');
     
        gEx('f_sp_fechaResoluciondte').fireEvent('change', gEx('f_sp_fechaResoluciondte'), gEx('f_sp_fechaResoluciondte').getValue());
        gEx('f_sp_fechaResoluciondte').fireEvent('select', gEx('f_sp_fechaResoluciondte'));
        
        
        if(tipoAcuerdo!='')
        {
        	gE('_tipoResolucionvch').selectedIndex=tipoAcuerdo;
        }
    }
   
}

  

