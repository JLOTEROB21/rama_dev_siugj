<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");


$periodoInicial="";
if(isset($_POST["fechaInicio"]))
	$periodoInicial=$_POST["fechaInicio"];

$periodoFinal="";
if(isset($_POST["fechaFin"]))
	$periodoFinal=$_POST["fechaFin"];

$tipoInforme="";
if(isset($_POST["tipoInforme"]))
	$tipoInforme=$_POST["tipoInforme"];

$fechaInicio=strtotime($periodoInicial);
$fechaFin=strtotime($periodoFinal);


$nFila=4;
$libro="";
if($tipoInforme==1)
	$libro=new cExcel("../modulosEspeciales_SGJP/formatos/formatoInformeMujeres.xlsx",true,"Excel2007");	
else
	$libro=new cExcel("../modulosEspeciales_SGJP/formatos/formatoInformeFeminicidios.xlsx",true,"Excel2007");		

$libro->setValor("B1","Del ".date("d",$fechaInicio)." de ".($arrMesLetra[(date("m",$fechaInicio)*1)-1])." de ".date("Y",$fechaInicio).
				" al ".date("d",$fechaFin)." de ".($arrMesLetra[(date("m",$fechaFin)*1)-1])." de ".date("Y",$fechaFin));

if($tipoInforme==1)
{
	$consulta="SELECT carpetaAdministrativa,tC.nombreTipoCarpeta,s.descripcion,
	(SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=c.idActividad AND idFiguraJuridica=2 AND r.idParticipante=p.id__47_tablaDinamica ORDER 
					BY nombre,apellidoPaterno,apellidoMaterno) AS victimas,
	(SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=c.idActividad AND idFiguraJuridica=4 AND r.idParticipante=p.id__47_tablaDinamica ORDER 
					BY nombre,apellidoPaterno,apellidoMaterno) AS imputados,c.idActividad,c.fechaCreacion
	 FROM 7006_carpetasAdministrativas c,7020_tipoCarpetaAdministrativa tC,7014_situacionCarpetaAdministrativa s
	WHERE c.fechaCreacion>='".$periodoInicial."' and c.fechaCreacion<='".$periodoFinal." 23:59:59' and tC.idTipoCarpeta=c.tipoCarpetaAdministrativa AND c.idActividad IN(
	SELECT r.idActividad FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE p.id__47_tablaDinamica=r.idParticipante
	AND p.genero=1 AND r.idFiguraJuridica=2
	) AND tipoCarpetaAdministrativa IN(1,5,6) AND
	s.idRegistro=c.situacion
	
	ORDER BY tipoCarpetaAdministrativa,carpetaAdministrativa";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		
		$consulta="SELECT GROUP_CONCAT(dl.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito dl WHERE d.idActividad=".$fila["idActividad"]." AND
						dl.id__35_denominacionDelito=d.denominacionDelito";
			
		$delitos=$con->obtenerValor($consulta);
		
		$libro->setValor("A".$nFila,$fila["carpetaAdministrativa"]);
		$libro->setValor("B".$nFila,$fila["fechaCreacion"]);
		$libro->setValor("C".$nFila,$fila["nombreTipoCarpeta"]);
		$libro->setValor("D".$nFila,$fila["imputados"]);
		$libro->setValor("E".$nFila,$fila["victimas"]);
		$libro->setValor("F".$nFila,$delitos);
		$libro->setValor("G".$nFila,$fila["descripcion"]);
	
		
	
		$nFila++;
	}
}
else
{
	$consulta="SELECT carpetaAdministrativa,tC.nombreTipoCarpeta,s.descripcion,
	(SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=c.idActividad AND idFiguraJuridica=2 AND r.idParticipante=p.id__47_tablaDinamica ORDER 
					BY nombre,apellidoPaterno,apellidoMaterno) AS victimas,
	(SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=c.idActividad AND idFiguraJuridica=4 AND r.idParticipante=p.id__47_tablaDinamica ORDER 
					BY nombre,apellidoPaterno,apellidoMaterno) AS imputados,c.idActividad,c.fechaCreacion
	 FROM 7006_carpetasAdministrativas c,7020_tipoCarpetaAdministrativa tC,7014_situacionCarpetaAdministrativa s
	WHERE c.fechaCreacion>='".$periodoInicial."' and c.fechaCreacion<='".$periodoFinal." 23:59:59' and tC.idTipoCarpeta=c.tipoCarpetaAdministrativa AND c.idActividad IN(
	SELECT dc.idActividad FROM _35_denominacionDelito de,_61_tablaDinamica dc WHERE de.denominacionDelito LIKE '%feminicidio%'
AND dc.denominacionDelito=de.id__35_denominacionDelito
	) AND tipoCarpetaAdministrativa IN(1,5,6) AND
	s.idRegistro=c.situacion
	
	ORDER BY tipoCarpetaAdministrativa,carpetaAdministrativa";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		
		$consulta="SELECT GROUP_CONCAT(dl.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito dl WHERE d.idActividad=".$fila["idActividad"]." AND
						dl.id__35_denominacionDelito=d.denominacionDelito";
			
		$delitos=$con->obtenerValor($consulta);
		
		$libro->setValor("A".$nFila,$fila["carpetaAdministrativa"]);
		$libro->setValor("B".$nFila,$fila["fechaCreacion"]);
		$libro->setValor("C".$nFila,$fila["nombreTipoCarpeta"]);
		$libro->setValor("D".$nFila,$fila["imputados"]);
		$libro->setValor("E".$nFila,$fila["victimas"]);
		$libro->setValor("F".$nFila,$delitos);
		$libro->setValor("G".$nFila,$fila["descripcion"]);
	
		
	
		$nFila++;
	}
}
if($tipoInforme==1)
	$libro->generarArchivo("Excel2007","informeMujeres.xlsx");
else
	$libro->generarArchivo("Excel2007","informeMujeresFeminicidios.xlsx");	