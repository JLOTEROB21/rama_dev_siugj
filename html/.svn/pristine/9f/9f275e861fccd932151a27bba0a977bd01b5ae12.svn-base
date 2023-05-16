<?php 
include("conexionBD.php");

$periodoInicial="";
$periodoInicial=$_POST["fechaInicio"];

$periodoFinal="";
$periodoFinal=$_POST["fechaFin"];

$nHojas=1;
$nFila=2;
$libro=new cExcel("../modulosEspeciales_SGJP/formatos/plantillaInformeExhortos.xlsx",true,"Excel2007");	

$fInicial=strtotime($periodoInicial);
$fFinal=strtotime($periodoFinal);

while($fInicial<=$fFinal)
{
	if($nHojas>1)
	{
		$libro->crearNuevaHoja();
		
		$libro->clonarRangoCeldas("A",1,"G",2,"A",1,0,$nHojas-1,true,true);
		$libro->cambiarHojaActiva($nHojas-1);
		
		
	}
	
	$libro->cambiarTituloHoja($nHojas-1,date("d",$fInicial).mb_strtoupper(substr($arrMesLetra[(date("m",$fInicial)*1)-1],0,3)).date("y",$fInicial));
	
	$fechaInicio=date("Y-m-d",$fInicial);
	$consulta="SELECT * FROM _524_tablaDinamica WHERE fechaCreacion>='".$fechaInicio."' AND fechaCreacion<'".$fechaInicio." 23:59:59' and idEstado>1 and idEstado<>4";
	$res=$con->obtenerFilas($consulta);
	if($con->filasAfectadas==0)
	{
		$libro->removerFila(2,1);
	}
	if($con->filasAfectadas>0)
	{
		$libro->insertarFila(3,$con->filasAfectadas-1);
	}
	
	
	while($fila=mysql_fetch_assoc($res))
	{
		$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fila["unidadAsignada"];
		$nombreUnidad=$con->obtenerValor($consulta);
		$libro->setValor("A".$nFila,$fila["numeroCausaOrigen"]);
		$libro->setValor("B".$nFila,$fila["noOficio"]);
		$libro->setValor("C".$nFila,$fila["juzgadoExhortante"]);
		$libro->setValor("D".$nFila,$nombreUnidad);
		$libro->setValor("E".$nFila,$fila["carpetaExhorto"]);
		$libro->setValor("F".$nFila,$fila["responsable"]);
		$libro->setValor("G".$nFila,obtenerNombreUsuario($fila["responsable"]));
		$nFila++;	
	}
	$fInicial=strtotime("+1 days",$fInicial);
	$nHojas++;
	
}

$libro->cambiarHojaActiva(0);
$libro->generarArchivo("Excel2007","informeExhortos_".date("Y-m-d",strtotime($periodoInicial))."_al_".date("Y-m-d",strtotime($periodoFinal)).".xlsx");

?>