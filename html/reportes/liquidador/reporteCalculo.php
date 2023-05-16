<?php
include_once("conexionBD.php");
include_once("cExcel.php");
include_once('tcpdf/tcpdf.inc.php');

$fechaReporte=date("Y-m-d");
$arreglo="";
$tituloReporte="reporteCalculo";
$texto1="Valores de entrada";
$texto2="Resultados de la operación";

	if(isset($_POST["cadObj"]))
		$arreglo=bD($_POST["cadObj"]);
		
	
	$obj=json_decode($arreglo);
	$nombreConcepto=$obj->nombreConcepto;

	$tipoReporte=$obj->tipoReporte;
	$arrParametro=$obj->arrParametros;
	$arrCalculos=$obj->arrCalculos;
	
	$periodo=cambiarFormatoFecha($fechaReporte);

	$libro=new cExcel("reporteCalculo.xls",true);

	$libro->setAnchoColumna("A",'35');
	$libro->setAnchoColumna("B",'13');

	$libro->setValor("B9",$periodo);
	$libro->setValor("A11",$texto1);
	$libro->setNegritas("A11");
	$libro->setValor("A7",$nombreConcepto);
	
	$linea=13;
	
	foreach($arrParametro as $datos =>$valor)
	{
		//varDump($valor);
		
		$parametro=$valor->parametro;
		$valorF=$valor->valor;
		
		$libro->setValor("A".$linea,$parametro);
		$libro->setValor("B".$linea,$valorF);
		$linea++;
		
	}
	
	$linea++;

	

	

	$libro->setValor("A".$linea,$texto2);
	$libro->setNegritas("A".$linea);
	$linea++;
	$libro->setValor("B".$linea,"Pesos");
	$columna=$libro->obtenerSiguienteColumna("B");
	$consulta="SELECT valor,contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=16388 ORDER BY valor";
	$resDivisas=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($resDivisas))
	{
		$libro->setValor($columna.$linea,$fila["contenido"]);
		$columna=$libro->obtenerSiguienteColumna($columna);
	}
	
	$libro->setNegritas("B".$linea.":D".$linea);
	
	$linea++;
	$linea++;
	
	foreach($arrCalculos as $datos =>$valor)
	{
		mysql_data_seek($resDivisas,0);
		$calculo=$valor->calculo;
		$valorF=$valor->valor;
		
		$libro->setValor("A".$linea,$calculo);
		$libro->setValor("B".$linea,$valorF);
		$columna=$libro->obtenerSiguienteColumna("B");
		while($fila=mysql_fetch_assoc($resDivisas))
		{
			$valorDivisa=0;
			eval('$valorDivisa=$valor->moneda_'.$fila["valor"].";");
			$libro->setValor($columna.$linea,$valorDivisa);
			$columna=$libro->obtenerSiguienteColumna($columna);
		}
		
		$linea++;
	}
	
	$linea+=2;
	$libro->setValor("A".$linea,"Divisas - Tipo de cambio");
	$libro->setNegritas("A".$linea);
	$libro->setValor("C".$linea,"Cambio al dia:");
	$libro->setNegritas("C".$linea);
	$libro->setValor("D".$linea,cambiarFormatoFecha($obj->fechaCambioDivisa));

	$linea++;
	mysql_data_seek($resDivisas,0);	

	foreach($obj->arrTiposCambio as $tC)
	{
		$libro->setValor("A".$linea,$tC->etiquetaDivisa);
		$libro->setValor("B".$linea,$tC->tipoCambio);
		$linea++;
		
	}

	

	//$libro->generarArchivo("HTML");
	if($tipoReporte==1)
		$libro->generarArchivo("Excel5",$tituloReporte.".xls");
	else	
		$libro->generarArchivo("PDF",$tituloReporte.".pdf");
			
	

	function formatearFecha($fecha)
	{
		return date("d/m/Y",strtotime($fecha))	;
	}
	
	function formatearMoneda($monto)
	{
		return '$ '.number_format($monto,2);
	}


?>
