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

$unidadGestion="";
if(isset($_POST["unidadGestion"]))
	$unidadGestion=$_POST["unidadGestion"];



$nFila=2;
$libro=new cExcel("../modulosEspeciales_SGJP/formatos/informeCarpetasIniciales.xlsx",true,"Excel2007");	

$consulta="SELECT s.* FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE s.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$unidadGestion."'
			AND s.fechaCreacion>='".$periodoInicial."' AND s.fechaCreacion<='".$periodoFinal." 23:59:59' order by s.fechaCreacion";

$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_assoc($res))
{
	$fechaCreacion=strtotime($fila["fechaCreacion"]);
	$libro->setValor("A".$nFila,date("H:i",$fechaCreacion));
	$libro->setValor("B".$nFila,date("d",$fechaCreacion)." de ".($arrMesLetra[(date("m",$fechaCreacion)*1)-1])." de ".date("Y",$fechaCreacion));
	$libro->setValor("C".$nFila,$fila["carpetaAdministrativa"]);
	$libro->setValor("D".$nFila,$fila["folioCarpetaInvestigacion"]);
	
	$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
			FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila["idActividad"]." and
			i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=4";
	
	$imputado=$con->obtenerListaValores($consulta);
	
	$libro->setValor("E".$nFila,$imputado);
	$libro->setValor("F".$nFila,"");
	
	$consulta="SELECT GROUP_CONCAT(de.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito de WHERE d.idActividad=".$fila["idActividad"]."
					AND de.id__35_denominacionDelito=d.denominacionDelito ORDER BY d.denominacionDelito";
	$lblDelitos=$con->obtenerValor($consulta);
	
	$libro->setValor("G".$nFila,$lblDelitos);
	
	$consulta="SELECT concat(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno) )
			FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i WHERE r.idActividad=".$fila["idActividad"]." and
			i.id__47_tablaDinamica=r.idParticipante AND idFiguraJuridica=2";
	$victimas=$con->obtenerListaValores($consulta);
	
	$libro->setValor("H".$nFila,$victimas);
	$libro->setValor("I".$nFila,"");
	$libro->setValor("J".$nFila,"");
	
	$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fila["tipoAudiencia"];
	$tipoAudiencia=$con->obtenerValor($consulta);
	
	$libro->setValor("K".$nFila,$tipoAudiencia);
	$consulta="SELECT idRegistroEvento,horaInicioEvento,(SELECT descripcionSituacion FROM 7011_situacionEventosAudiencia 
				WHERE idSituacion=e.situacion) as situacion FROM  7000_eventosAudiencia e WHERE idFormulario=46 
				AND idRegistroSolicitud=".$fila["id__46_tablaDinamica"];
	$fEvento=$con->obtenerPrimeraFila($consulta);
	if($fEvento[1]!="")
	{
		$fechaEvento=strtotime($fEvento[1]);
		
		$libro->setValor("L".$nFila,date("d",$fechaEvento));
		$libro->setValor("M".$nFila,($arrMesLetra[(date("m",$fechaEvento)*1)-1]));
		$libro->setValor("N".$nFila,date("H:i",$fechaEvento));
		$libro->setValor("O".$nFila,$fEvento[2]);
	}
	if($fEvento[0]=="")
		$fEvento[0]=-1;
	$consulta="SELECT concat('(',noJuez,') ',(SELECT nombre FROM 800_usuarios WHERE idUsuario=ej.idJuez)) FROM 7001_eventoAudienciaJuez ej WHERE idRegistroEvento=".$fEvento[0];
	
	$listaJueces=$con->obtenerListaValores($consulta);
	$libro->setValor("P".$nFila,$listaJueces);
	
	$consulta="SELECT fiscalia,CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apPaterno IS NULL,'',apPaterno),' ',
			IF(apMaterno IS NULL,'',apMaterno)) AS fiscal FROM _286_tablaDinamica cf,_100_tablaDinamica f WHERE 
			f.idReferencia=".$fila["id__46_tablaDinamica"]." AND cf.id__286_tablaDinamica=claveFiscalia";
	$fFiscalia=$con->obtenerPrimeraFila($consulta);
	$libro->setValor("Q".$nFila,$fFiscalia[1]);
	$libro->setValor("R".$nFila,$fFiscalia[0]);
	$nFila++;
}

$libro->generarArchivo("Excel2007","informe.xlsx");