<?php 	
	include("../include/conexionBD.php");
	include_once("../include/cExcel.php");
	$data=$_POST["data"];
	$lineaInicial="1";
	if(isset($_POST["lineaInicial"]))
		$lineaInicial=$_POST["lineaInicial"];
		
	$letraInicial="A";
	if(isset($_POST["letraInicial"]))
		$letraInicial=$_POST["letraInicial"];
	
	$nArchivo="listado.xls";
	if(isset($_POST["nArchivo"]))
		$nArchivo=$_POST["nArchivo"];
	
	$cargarPlantilla=false;
	if(isset($_POST["plantilla"]))
		$nArchivo=true;
	
	$arrDatos= unserialize($data);
	$libro=new cExcel($nArchivo,$cargarPlantilla);
	$resultado=$libro->generarTablaMatriz($arrDatos,$letraInicial,$lineaInicial,true);
	$rangoEncabezado=$letraInicial.$lineaInicial.":".$resultado[0].$lineaInicial;
	$libro->setNegritas($rangoEncabezado);
	$libro->setHAlineacion($rangoEncabezado,"C");
	$libro->generarArchivo("Excel5");	
?>