<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	$idAuto=-1;
	$nombreArchivo="";
	if($idRegistro!=-1)
	{
		$consulta="SELECT autoRecurso FROM _944_tablaDinamica WHERE id__944_tablaDinamica=".$idRegistro;
		$idAuto=$con->obtenerValor($consulta);
		if($idAuto=="")
			$idAuto=-1;
		$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$idAuto;
		$nombreArchivo=$con->obtenerValor($consulta);
	}


?>



function inyeccionCodigo()
{
    if(esRegistroFormulario())
    {
		if(gE('idRegistroG').value=='-1')
      	{
        	gEx('f_sp_fechaRegistroEnvioApelacionTribunalSuperiorJusticiadte').setValue('<?php echo $fechaActual?>');
           
            gEx('f_sp_fechaRegistroEnvioApelacionTribunalSuperiorJusticiadte').fireEvent('change', gEx('f_sp_fechaRegistroEnvioApelacionTribunalSuperiorJusticiadte'), gEx('f_sp_fechaRegistroEnvioApelacionTribunalSuperiorJusticiadte').getValue());
            gEx('f_sp_fechaRegistroEnvioApelacionTribunalSuperiorJusticiadte').fireEvent('select', gEx('f_sp_fechaRegistroEnvioApelacionTribunalSuperiorJusticiadte'));
            
            
            gEx('f_sp_horaRecepcionEnvioApelacionTribunalSuperiorJusticiatme').setValue('<?php echo $horaActual?>');
           
            gEx('f_sp_horaRecepcionEnvioApelacionTribunalSuperiorJusticiatme').fireEvent('change', gEx('f_sp_horaRecepcionEnvioApelacionTribunalSuperiorJusticiatme'), gEx('f_sp_horaRecepcionEnvioApelacionTribunalSuperiorJusticiatme').getValue());
            gEx('f_sp_horaRecepcionEnvioApelacionTribunalSuperiorJusticiatme').fireEvent('select', gEx('f_sp_horaRecepcionEnvioApelacionTribunalSuperiorJusticiatme'));
		}    	             
                      
        
       
        
    }
    else
    {
    	if(gE('sp_13166').innerHTML!='Sobre Auto')
        {
        	oE('div_13164');
            oE('div_13175');
            oE('div_13169');
        }
    }
}



function mostrarAutoApela()
{
	var idAuto='<?php echo $idAuto?>';
    var nombreArchivo='<?php echo $nombreArchivo?>';
    
	if(esRegistroFormulario())
	{
        idAuto=gE('_autoRecursovch').options[gE('_autoRecursovch').selectedIndex].value;
        if(idAuto=='-1')
        {	
            msgBox('Debe seleccionar el auto que desea observar');
            return;
        }
        nombreArchivo=gE('_autoRecursovch').options[gE('_autoRecursovch').selectedIndex].text;
        
       
	}
    
    var extension=nombreArchivo.split('.');
    window.parent.mostrarVisorDocumentoProceso(extension[extension.length-1],idAuto,null,nombreArchivo);   
}
