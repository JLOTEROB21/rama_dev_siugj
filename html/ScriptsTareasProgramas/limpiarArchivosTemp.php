<?php
	$tiempoLimite= 30;//min
	$dir='../archivosTemporales';
	
	$directorio=opendir($dir); 
	$arrArchivos=array();
	while ($archivo = readdir($directorio))
	{
		if(($archivo!='.')&&($archivo!='..'))
			array_push($arrArchivos,$archivo);
	}
	closedir($directorio); 
	$fechaActual=time();
	foreach($arrArchivos as $archivo)
	{
		$datosArchivo=explode("_",$archivo);
		$fechaHora=mktime($datosArchivo[5],$datosArchivo[6],$datosArchivo[7],$datosArchivo[3],$datosArchivo[4],$datosArchivo[2]);
		$diferencia=($fechaActual-$fechaHora)/60;
		
		if($diferencia>$tiempoLimite)
		{
			//echo date("d-m-Y H:i:s",$fechaActual)."-".date("d-m-Y H:i:s",$fechaHora)."  ".($diferencia)." Eliminando: ".$archivo."<br>";
			unlink($dir."/".$archivo);
		}
			
	}
	
?>