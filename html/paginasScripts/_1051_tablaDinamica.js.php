<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);
	
	$consulta="SELECT tipoSustanciacion FROM _1051_tablaDinamica WHERE id__1051_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	$tipoSustanciacion=$fRegistro["tipoSustanciacion"];
	
	
?>

var tipoSustanciacion=<?php echo $tipoSustanciacion?>;

function inyeccionCodigo()
{
	if(tipoSustanciacion==1)
    {
        gE('sp_14224').innerHTML='Registro de Escrito de Demanda';
        window.parent.gE('opt_1051').innerHTML='Registro de Escrito de Demanda';
    }
    
}


function funcion_contenidoPublicacionvch_ready(evt)
{
	if(esRegistroFormulario())
    {
    	if(gE('idRegistroG').value=='-1')
      	{
    		evt.editor.setData('<div class="cwjdsjcs_not_editable"><p class="letraContenidoPublicacion">[Ingrese Contenido]</p></div>');
		}
    }
}