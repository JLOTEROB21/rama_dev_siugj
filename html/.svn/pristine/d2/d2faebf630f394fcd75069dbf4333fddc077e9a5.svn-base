<?php	include("sesiones.php");
include("conexionBD.php"); 
include_once ("latis/cExcel.php");

$fechaInicio="-1";
if(isset($_POST["fechaInicio"]))
  $fechaInicio=$_POST["fechaInicio"];


$fechaFin="-1";
if(isset($_POST["fechaFin"]))
  $fechaFin=$_POST["fechaFin"];

$idJuez="-1";
if(isset($_POST["idJuez"]))
  $idJuez=$_POST["idJuez"];


$uFila=NULL;
$uFecha="";
$uGestion="";
$fFechaInicioUGA="";
$fFechaFinUGA="";
$arrUGAS=array();

$consulta="SELECT fechaEvento,idCentroGestion FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez ej WHERE 
	e.fechaEvento>='".$fechaInicio."' and e.fechaEvento<='".$fechaFin."' AND e.situacion IN(1,2,4,5) and 
ej.idRegistroEvento=e.idRegistroEvento AND ej.idJuez=".$idJuez." ORDER BY e.horaInicioEvento ASC";
$rFechas=$con->obtenerFilas($consulta);
while($fFechas=mysql_fetch_row($rFechas))
{
	if($uGestion!=$fFechas[1])
	{
		if($uFila!=NULL)
		{
			$fFechaFinUGA=$uFila[0];
			$arrUGAS[$fFechaInicioUGA."__".$fFechaFinUGA]=$uGestion;
			$fFechaFinUGA="";
		}
		
		$fFechaInicioUGA=$fFechas[0];
		$uGestion=$fFechas[1];
	}
	$uFila=$fFechas;
	
}

if(($fFechaFinUGA=="")&&($uFila!=NULL))
{
	$fFechaFinUGA=$uFila[0];
	$arrUGAS[$fFechaInicioUGA."__".$uFila[0]]=$uGestion;

}

$libro=new cExcel("",false,"Excel2007");
$nFila=1;
$libro->setValor("A".$nFila,"Juez:");
$libro->setNegritas("A".$nFila);
$libro->setValor("B".$nFila,obtenerNombreUsuario($idJuez));
$nFila++;
$libro->setValor("A".$nFila,"Periodo del informe:");
$libro->setNegritas("A".$nFila);
$periodoInforme="Del ".date("d/m/Y",strtotime($fechaInicio))." al ".date("d/m/Y",strtotime($fechaFin));

$libro->setValor("B".$nFila,$periodoInforme);
$nFila++;


foreach($arrUGAS as $fechas=>$ug)
{
	$aFechas=explode("__",$fechas);
	$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$ug;
	$unidadGestion=$con->obtenerValor($consulta);
	$periodo="Del ".date("d/m/Y",strtotime($aFechas[0]))." al ".date("d/m/Y",strtotime($aFechas[1]));

	$libro->setValor("A".$nFila,"Unidad de Gestión:");
	$libro->setNegritas("A".$nFila);
	$libro->setValor("B".$nFila,$unidadGestion);
	$nFila++;
	$libro->setValor("A".$nFila,"Audiencias del/al:");
	$libro->setNegritas("A".$nFila);
	$libro->setValor("B".$nFila,$periodo);
	$nFila++;
		
	
	$libro->setValor("A".$nFila,"Promedio de audiencias por dia: ");
	$libro->setBorde("A".$nFila.":B".$nFila,"DE");
	$libro->setNegritas("A".$nFila);
	$libro->setAnchoColumna("A",95);
	$libro->setAnchoColumna("B",26);
	$libro->setAnchoColumna("C",35);
	
	$fechaInicio=$aFechas[0];
	$fechaFin=$aFechas[1];
	
	$fInicio=strtotime($fechaInicio);
	$fIni=$fInicio;
	$fFin=strtotime($fechaFin);
	$totalDias=0;
	$totalAudiencias=0;
	
	while($fIni<=$fFin)
	{
		
		$consulta="SELECT COUNT(*)  FROM  7000_eventosAudiencia e,7001_eventoAudienciaJuez j WHERE j.idRegistroEvento=e.idRegistroEvento 
								AND e.fechaEvento='".date("Y-m-d",$fIni)."' and e.idCentroGestion=".$ug." AND e.situacion IN(1,2,4,5) AND j.idJuez=".$idJuez;
		$tAudiencias=$con->obtenerValor($consulta);
		$totalDias++;
		$totalAudiencias+=$tAudiencias;
		
		$fIni=strtotime("+1 day",$fIni);
		
	}

	$libro->setValor("B".$nFila,$totalDias==0?0:$totalAudiencias/$totalDias);
	
	

	$nFila+=2;
	$nFilaInicial=$nFila;
	$libro->setValor("A".$nFila,"Tipo de audiencia");
	$libro->setValor("B".$nFila,"Total de audiencias");
	$libro->setValor("C".$nFila,"Duración Promedio de audiencia (min)");
	
	$libro->setNegritas("A".$nFila.":C".$nFila);
	$libro->setColorFondo("A".$nFila.":C".$nFila,"CCCCCC");
	
	
	
	
	$nFila++;
	
	$consulta="SELECT tipoAudiencia , 
	(SELECT COUNT(*) FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." AND j.idRegistroEvento=e.idRegistroEvento AND 
	j.idJuez=".$idJuez." AND e.situacion  IN (1,2,4,5) AND e.tipoAudiencia=ta.id__4_tablaDinamica) AS nAudiencias,
	(
	SELECT AVG(TIMESTAMPDIFF(MINUTE, horaInicioReal,horaTerminoReal )) FROM 7000_eventosAudiencia e,
	7001_eventoAudienciaJuez j
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." AND  j.idRegistroEvento=e.idRegistroEvento AND 
	j.idJuez=".$idJuez." AND e.tipoAudiencia=ta.id__4_tablaDinamica AND e.situacion IN (1,2,4,5)
	 AND horaInicioReal IS NOT NULL AND (TIMESTAMPDIFF(MINUTE, horaInicioReal,horaTerminoReal )>15) AND  
	(TIMESTAMPDIFF(MINUTE, horaInicioReal,horaTerminoReal )<400)
	) AS promedioAudiencia FROM _4_tablaDinamica ta order by tipoAudiencia";
	
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		if($fila[1]>0)
		{
			
			$libro->setValor("A".$nFila,$fila[0]);
			$libro->setValor("B".$nFila,$fila[1]);
			$libro->setValor("C".$nFila,$fila[2]==""?"N/D":$fila[2]);
			
			
			$nFila++;
		}
	}
	
	$libro->setBorde("A".$nFilaInicial.":C".($nFila-1),"DE");
	$nFila+=2;
	$nFilaInicial=$nFila;
	$libro->setValor("A".$nFila,"Acción/determinación");
	$libro->setValor("B".$nFila,"Total");
	$libro->setNegritas("A".$nFila.":B".$nFila);
	$libro->setColorFondo("A".$nFila.":B".$nFila,"CCCCCC");
	
	
	$nFila++;

	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(42,43) AND valor=1";
	$total=$con->obtenerValor($consulta);
	$libro->setValor("A".$nFila,"Acuerdos reparatorios");
	$libro->setValor("B".$nFila,$total);
	$nFila++;


	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(10) AND valor=1";
	$total=$con->obtenerValor($consulta);
	$libro->setValor("A".$nFila,"Suspensiones condicionales de proceso");
	$libro->setValor("B".$nFila,$total);
	$nFila++;


	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(25) AND valor=1";
	$total=$con->obtenerValor($consulta);


	$libro->setValor("A".$nFila,"Procedimientos abreviados");
	$libro->setValor("B".$nFila,$total);
	$nFila++;
	
	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(15)";
	$total=$con->obtenerValor($consulta);

	$libro->setValor("A".$nFila,"Determinación de legal la detención");
	$libro->setValor("B".$nFila,$total);
	$nFila++;
	
	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(82)";
	$total=$con->obtenerValor($consulta);

	$libro->setValor("A".$nFila,"Determinación de NO legal la detención");
	$libro->setValor("B".$nFila,$total);
	$nFila++;



	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(50) AND valor=1 ";
	$total=$con->obtenerValor($consulta);
	
	$libro->setValor("A".$nFila,"Vinculaciones a proceso");
	$libro->setValor("B".$nFila,$total);
	$nFila++;

	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(93) ";
	
	$total=$con->obtenerValor($consulta);
	
	$libro->setValor("A".$nFila,"Sentencias condenatorias");
	$libro->setValor("B".$nFila,$total);
	$nFila++;

	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(92)  ";
	$total=$con->obtenerValor($consulta);
	
	$libro->setValor("A".$nFila,"Sentencias absolutorias");
	$libro->setValor("B".$nFila,$total);
	$nFila++;

	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(48,7) AND valor=1 ";
	$total=$con->obtenerValor($consulta);
	
	$libro->setValor("A".$nFila,"Órdenes de aprehension");
	$libro->setValor("B".$nFila,$total);
	$nFila++;

	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(47) AND valor=1 ";
	$total=$con->obtenerValor($consulta);
	
	$libro->setValor("A".$nFila,"Órdenes de cateo");
	$libro->setValor("B".$nFila,$total);
	$nFila++;

	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(9) AND valor=1 ";
	$total=$con->obtenerValor($consulta);
	
	$libro->setValor("A".$nFila,"Sobreseimientos");
	$libro->setValor("B".$nFila,$total);
	$nFila++;
	
	$consulta="SELECT COUNT(DISTINCT idEvento) FROM 3013_registroResolutivosAudiencia WHERE idEvento IN
	(
	SELECT e.idRegistroEvento
	 FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j 
	WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' and e.idCentroGestion=".$ug." and j.idRegistroEvento=e.idRegistroEvento AND j.idJuez=".$idJuez."
	)
	AND tipoResolutivo IN(62,
68,
76,
77,
97,
118,
119,
170,
293,
294,
295,
296,
323) ";
	
	$total=$con->obtenerValor($consulta);
	
	$libro->setValor("A".$nFila,"Audiencias diferidas");
	$libro->setValor("B".$nFila,$total);
	$nFila++;
	
	$libro->setBorde("A".$nFilaInicial.":B".($nFila-1),"DE");
	$nFila+=3;
}

$libro->generarArchivo("Excel2007","informeDesempenioJuez.xlsx");




?>