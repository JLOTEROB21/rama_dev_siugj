<?php 
include("conexionBD.php");

$periodoInicial="";
$periodoInicial=$_POST["fechaInicio"];

$periodoFinal="";
$periodoFinal=$_POST["fechaFin"];

$consulta=" UPDATE 7006_carpetasAdministrativas SET etapaProcesalActual=4 WHERE carpetaAdministrativa IN
(SELECT DISTINCT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE 
tipoContenido=3 AND idRegistroContenidoReferencia IN(
SELECT idRegistroEvento FROM 7000_eventosAudiencia WHERE tipoAudiencia=15 AND situacion NOT IN (3)
))  aND etapaProcesalActual<=4";
$con->ejecutarConsulta($consulta);

$libro=new cExcel("../modulosEspeciales_SGJP/formatos/informeMedidaPresentacion.xlsx",true,"Excel2007");	
$libro->setValor("C2","Periodo del ".date("d/m/Y",strtotime($periodoInicial))." al ".date("d/m/Y",strtotime($periodoFinal)));


$arrEventos=array();
$numFilas=2;
$consulta="SELECT DISTINCT c.carpetaAdministrativa,e.idRegistroEvento FROM 3014_registroMedidasCautelares r,7000_eventosAudiencia e,
7007_contenidosCarpetaAdministrativa c,7006_carpetasAdministrativas cA 
WHERE e.fechaEvento>='".$periodoInicial."' AND e.fechaEvento<='".$periodoFinal."' AND r.idEventoAudiencia=e.idRegistroEvento AND 
e.situacion IN(1,2,4,5) AND r.tipoMedida=1 AND c.tipoContenido=3 AND idRegistroContenidoReferencia=e.idRegistroEvento
AND cA.carpetaAdministrativa=c.carpetaAdministrativa order by c.carpetaAdministrativa";

$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{
	
	$consulta="SELECT COUNT(*) FROM 3014_registroMedidasCautelares WHERE idEventoAudiencia=".$fila[1]." and tipoMedida=1";
	$tImputados=$con->obtenerValor($consulta);
	
	
	if(!isset($arrEventos[$fila[0]]))
	{
		$arrEventos[$fila[0]]=0;
	}
	$arrEventos[$fila[0]]+=$tImputados;
	
}

foreach($arrEventos as $cCarpeta=>$total)
{
	$consulta="SELECT descripcionEtapa FROM 7009_etapasProcesales e,7006_carpetasAdministrativas c WHERE idEtapaProcesal=c.etapaProcesalActual
			AND c.carpetaAdministrativa='".$cCarpeta."'";
			
	$descripcionEtapa=$con->obtenerValor($consulta);		
	$libro->setValor("A".$numFilas,$cCarpeta);
	$libro->setValor("B".$numFilas,$total);
	$libro->setValor("C".$numFilas,$descripcionEtapa);
	
	$numFilas++;
}


//() AS etapa
$libro->cambiarHojaActiva(0);
$libro->generarArchivo("Excel2007","informe.xlsx");

?>