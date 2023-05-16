<?php
	include_once("conexionBD.php");
	include_once("cExcel.php");
	include_once("./funciones/funcionesReportes.php");
	
	ini_set("memory_limit","256M");

	$tituloReporte="reporte2";

	$formato=$_POST["formato"];
	$disposicion=$_POST["disposicion"];
	
	$libro=new cExcel("reporte2.xls",true);	

	$datos=obtenerDatosReporte2();
	
	foreach($datos as $valor=>$p)
	{
		foreach ($p as $cantidad)
		{
			$total=$cantidad["total"];
			switch($valor)
			{
				case 1213:
							$libro->setValor("C11",$total);	
				break;
				case 1214:
							$libro->setValor("C12",$total);	
				break;
				case 1218:
							$libro->setValor("C13",$total);	
				break;
				case 1206:
							$libro->setValor("C14",$total);	
				break;
				case 1191:
							$libro->setValor("C15",$total);	
				break;
				case 1184:
							$libro->setValor("C16",$total);	
				break;
				case 1177:
							$libro->setValor("C17",$total);	
				break;
				case 1182:
							$libro->setValor("C18",$total);	
				break;
			}
		}
	}
	
	$datos=obtenerDatosReporte3();
	
	foreach($datos as $valor=>$p)
	{
		foreach ($p as $cantidad)
		{
			$total=$cantidad["total"];
			switch($valor)
			{
				case 1213:
							$libro->setValor("C25",$total);	
				break;
				case 1214:
							$libro->setValor("C26",$total);	
				break;
				case 1218:
							$libro->setValor("C27",$total);	
				break;
				case 1206:
							$libro->setValor("C28",$total);	
				break;
				case 1191:
							$libro->setValor("C29",$total);	
				break;
				case 1184:
							$libro->setValor("C30",$total);	
				break;
				case 1177:
							$libro->setValor("C31",$total);	
				break;
				case 1182:
							$libro->setValor("C32",$total);	
				break;
			}
		}
	}




	//$libro->generarArchivo("HTML");
	if($formato==2)
		$libro->generarArchivo("Excel2007",$tituloReporte.".xlsx");
	else
	{
		$libro->generarArchivoServidor("PDF",$tituloReporte.".pdf");
		header("Content-type:application/pdf"); 
		//header("Content-length: ".filesize($tituloReporte.".pdf")); 
		header("Content-Disposition: ".($disposicion==1?"inline":"attachment")."; filename=".$tituloReporte.".pdf");
		readfile($tituloReporte.".pdf");
		unlink($tituloReporte.".pdf");
	}

	function formatearFecha($fecha)
	{
		return date("d/m/Y",strtotime($fecha))	;
	}
	
	function formatearMoneda($monto)
	{
		return '$ '.number_format($monto,2);
	}

?>