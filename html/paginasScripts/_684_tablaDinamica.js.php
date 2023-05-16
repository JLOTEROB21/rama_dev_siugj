<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$fechaActual=date("Y-m-d")	;
	
	$horaActual=date("H:i");
	
	$consulta="SELECT sentencia FROM _684_tablaDinamica WHERE id__684_tablaDinamica=".$idRegistro;
	$sentencia=$con->obtenerValor($consulta);
	if($sentencia=="")
		$sentencia=-1;
		
	$consulta="SELECT lower(nomArchivoOriginal) FROM 908_archivos WHERE idArchivo=".$sentencia;
	$nomArchivoOriginal=$con->obtenerValor($consulta);
?>

var sentencia='<?php echo $sentencia?>';
var nombreSentencia='<?php echo $nomArchivoOriginal?>';


function inyeccionCodigo()
{
	
    if(!esRegistroFormulario())
    {
    	gE('div_10868').innerHTML='';
        
    	if(sentencia!='-1')
       {
       		var arrDocumento=nombreSentencia.split('.');
            var extension=arrDocumento[arrDocumento.length-1];
            
       		gE('div_10868').innerHTML='<a href="javascript:visualizarDocumento(\''+bE(sentencia)+'\',\''+bE(extension)+'\')"><img src="../imagenesDocumentos/16/file_extension_'+extension+'.png" /></a>';
       }
    }
   
    
  
	


}


function visualizarDocumento(iD,e)
{
	window.parent.mostrarVisorDocumentoProceso(bD(e),bD(iD));
}


