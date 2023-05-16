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
		$consulta="SELECT autoRecurso FROM _930_tablaDinamica WHERE id__930_tablaDinamica=".$idRegistro;
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
        	gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
           
            gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
            gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
            
            
            gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
           
            gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
            gEx('f_sp_horaRecepciontme').fireEvent('select', gEx('f_sp_horaRecepciontme'));
		}    	             
                      
        
       
        
    }
    else
    {
    	if(gE('sp_13113').innerHTML=='Sentencia')
        {
        	oE('div_13103');
            oE('div_13133');
            oE('div_13114');
        }
    }
}



function mostrarAutoApela()
{
	var idAuto='<?php echo $idAuto?>';
    var nombreArchivo='<?php echo $nombreArchivo?>';
    
	if(esRegistroFormulario())
	{
        idAuto=gE('_autoApelacionvch').options[gE('_autoApelacionvch').selectedIndex].value;
        if(idAuto=='-1')
        {	
            msgBox('Debe seleccionar el auto que desea observar');
            return;
        }
        nombreArchivo=gE('_autoApelacionvch').options[gE('_autoApelacionvch').selectedIndex].text;
        
       
	}
    
    var extension=nombreArchivo.split('.');
    window.parent.mostrarVisorDocumentoProceso(extension[extension.length-1],idAuto,null,nombreArchivo);   
}
