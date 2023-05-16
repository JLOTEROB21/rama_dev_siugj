<?php ini_set('memory_limit', '20000M');
include("sesiones.php");

include("conexionBD.php");
include_once("nusoap/nusoap.php");
include_once("sgjp/siajop.php");

ini_set('max_execution_time', 7200);


$arrPeriodos[0]["fechaInicio"]="2020-07-01";
$arrPeriodos[0]["fechaFin"]="2020-09-15";


/*
Porcentaje de audiencias efectivamente desahogadas en el Sistema Penal Acusatorio*/
foreach($arrPeriodos as $p)
{
	
	$totalCelebradas=0;
	$totalCanceladas=0;
	
	$consulta="SELECT count(*) FROM 7000_eventosAudiencia WHERE fechaEvento>='".$p["fechaInicio"]."' and fechaEvento<='".$p["fechaFin"].
				"' and  situacion IN(1,2,4,5) ";//and idCentroGestion<>50
	$totalCelebradas=$con->obtenerValor($consulta);
	
	$consulta="SELECT count(*) FROM 7000_eventosAudiencia WHERE fechaEvento>='".$p["fechaInicio"]."' and fechaEvento<='".$p["fechaFin"].
				"' and  situacion IN(6,3) ";
	$totalCanceladas=$con->obtenerValor($consulta);
	$totalUniverso=$totalCelebradas+$totalCanceladas;
	echo "<b>Periodo:</b> (".(date("Y",strtotime($p["fechaInicio"]))).") ".$arrMesLetra[(date("m",strtotime($p["fechaInicio"]))*1)-1].
		" - ".$arrMesLetra[(date("m",strtotime($p["fechaFin"]))*1)-1]." <br><br>Tota celebradasl: ".$totalCelebradas.
		", Total canceladas : ".$totalCanceladas.", Porcentaje desahogadas: ".(($totalCelebradas/$totalUniverso)*100)."<br><br>";
}

return;

/* Promedio de audiencias diarias celebradas por UGJ*/

foreach($arrPeriodos as $p)
{
	
	$arrFechas=array();
	$total=0;
	$consulta="SELECT fechaEvento FROM 7000_eventosAudiencia WHERE fechaEvento>='".$p["fechaInicio"]."' and fechaEvento<='".$p["fechaFin"].
				"' and  situacion IN(1,2,4,5)";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		//if((date("w",strtotime($fila[0]))>=1)||(date("w",strtotime($fila[0]))<=5))
		{
			if(!isset($arrFechas[date("Y-m-d",strtotime($fila[0]))]))
				$arrFechas[date("Y-m-d",strtotime($fila[0]))]=1;
			$total++;
		}
		
	}
	
	echo "<b>Periodo:</b> (".(date("Y",strtotime($p["fechaInicio"]))).") ".$arrMesLetra[(date("m",strtotime($p["fechaInicio"]))*1)-1]." - ".$arrMesLetra[(date("m",strtotime($p["fechaFin"]))*1)-1]." <br><br>Total: ".$total.", dias: ".sizeof($arrFechas).", promedio: ".($total/sizeof($arrFechas)/17)."<br><br>";
}
return;


/*
/* Carpetas registradas en el trimestre*/
/*foreach($arrPeriodos as $p)
{

	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
					WHERE fechaCreacion>='".$p["fechaInicio"]."' AND fechaCreacion<='".$p["fechaFin"]." 23:59:59' and tipoCarpetaAdministrativa=1
					and unidadGestion<>'012'";
		
		
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	echo $nCarpetas;
}
return;*/


//Porcentaje de carpetas que finalizan en la etapa de control
/*foreach($arrPeriodos as $p)
{
	
	$arrFechas=array();
	$total=0;
	
	$consulta="SELECT DISTINCT c.carpetaAdministrativa FROM  7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa c 
				WHERE tipoAudiencia=15 AND e.situacion NOT IN(3) 
				AND c.tipoContenido=3 AND e.idRegistroEvento=c.idRegistroContenidoReferencia";
	$listaCarpetasIntermedia=$con->obtenerListaValores($consulta,"'");
	if($listaCarpetasIntermedia=="")
		$listaCarpetasIntermedia=-1;
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
					WHERE fechaCreacion>='".$p["fechaInicio"]."' AND fechaCreacion<='".$p["fechaFin"].
					" 23:59:59' and tipoCarpetaAdministrativa=1 and unidadGestion<>'012'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;	
		
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
				WHERE fechaCreacion>='".$p["fechaInicio"]."' AND fechaCreacion<='".$p["fechaFin"]." 23:59:59' and tipoCarpetaAdministrativa=1
				and unidadGestion<>'012' and carpetaAdministrativa not in(".$listaCarpetasIntermedia.")";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	
	
	
	$consulta="SELECT DISTINCT  idEvento FROM 3013_registroResolutivosAudiencia WHERE (tipoResolutivo=8 AND valor=1) OR (tipoResolutivo=9 AND valor=1)";
	$listaEventos=$con->obtenerListaValores($consulta);
	if($listaEventos=="")
		$listaEventos=-1;
		
	$consulta="SELECT DISTINCT carpetaAdministrativa FROM(
			SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE situacion IN(3,6,8,9,17,19) and unidadGestion<>'012'
			UNION
			SELECT c.carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa c,7000_eventosAudiencia e,7006_carpetasAdministrativas cA WHERE 
			c.tipoContenido=3 AND e.idRegistroEvento=c.idRegistroContenidoReferencia  and cA.carpetaAdministrativa=c.carpetaAdministrativa and 
			cA.unidadGestion<>'012' AND e.idRegistroEvento IN(".$listaEventos.")) AS tmp where carpetaAdministrativa IN (".$listaCarpetas.") ";
	
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetasCerradas=$con->filasAfectadas;

	echo "<b>Periodo:</b> (".(date("Y",strtotime($p["fechaInicio"]))).") ".$arrMesLetra[(date("m",strtotime($p["fechaInicio"]))*1)-1]." - ".$arrMesLetra[(date("m",strtotime($p["fechaFin"]))*1)-1]." <br><br>Universo: ".$nCarpetas.", Cerradas: ".$nCarpetasCerradas.", promedio: ".($nCarpetasCerradas==0?0:(($nCarpetasCerradas/$nCarpetas)*100))."<br><br>";
}
return;
*/

//Porcentaje de carpetas que finalizan en la etapa de intermedia
/*foreach($arrPeriodos as $p)
{
	
	$arrFechas=array();
	$total=0;
	
	$consulta="SELECT DISTINCT c.carpetaAdministrativa FROM  7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa c 
				WHERE tipoAudiencia=15 AND e.situacion NOT IN(3) 
				AND c.tipoContenido=3 AND e.idRegistroEvento=c.idRegistroContenidoReferencia";
	$listaCarpetasIntermedia=$con->obtenerListaValores($consulta,"'");
	if($listaCarpetasIntermedia=="")
		$listaCarpetasIntermedia=-1;
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
					WHERE fechaCreacion>='".$p["fechaInicio"]."' AND fechaCreacion<='".$p["fechaFin"].
					" 23:59:59' and tipoCarpetaAdministrativa=1 and unidadGestion<>'012'";
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	if($listaCarpetas=="")
		$listaCarpetas=-1;
	$nCarpetas=$con->filasAfectadas;	
		
		
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
				WHERE fechaCreacion>='".$p["fechaInicio"]."' AND fechaCreacion<='".$p["fechaFin"]." 23:59:59' and tipoCarpetaAdministrativa=1
				and unidadGestion<>'012' and carpetaAdministrativa  in(".$listaCarpetasIntermedia.")";
	
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	if($listaCarpetas=="")
		$listaCarpetas=-1;
	
	
	$consulta="SELECT DISTINCT  idEvento FROM 3013_registroResolutivosAudiencia WHERE (tipoResolutivo=8 AND valor=1) OR (tipoResolutivo=9 AND valor=1)";
	$listaEventos=$con->obtenerListaValores($consulta);
	if($listaEventos=="")
		$listaEventos=-1;
		
	$consulta="SELECT DISTINCT carpetaAdministrativa FROM(
			SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE situacion IN(3,6,8,9,17,19) and unidadGestion<>'012'
			UNION
			SELECT c.carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa c,7000_eventosAudiencia e,7006_carpetasAdministrativas cA WHERE 
			c.tipoContenido=3 AND e.idRegistroEvento=c.idRegistroContenidoReferencia  and cA.carpetaAdministrativa=c.carpetaAdministrativa and 
			cA.unidadGestion<>'012' AND e.idRegistroEvento IN(".$listaEventos.")) AS tmp where carpetaAdministrativa IN (".$listaCarpetas.") ";
	
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetasCerradas=$con->filasAfectadas;

	echo "<b>Periodo:</b> (".(date("Y",strtotime($p["fechaInicio"]))).") ".$arrMesLetra[(date("m",strtotime($p["fechaInicio"]))*1)-1]." - ".$arrMesLetra[(date("m",strtotime($p["fechaFin"]))*1)-1]." <br><br>Universo: ".$nCarpetas.", Cerradas: ".$nCarpetasCerradas.", promedio: ".($nCarpetasCerradas==0?0:(($nCarpetasCerradas/$nCarpetas)*100))."<br><br>";
}
return;
*/

/* Porcentaje de carpetas que se desahogan por la v&iacute;a del procedimiento abreviado*/

/*foreach($arrPeriodos as $p)
{
	
	$arrFechas=array();
	$total=0;
	$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
				WHERE fechaCreacion>='".$p["fechaInicio"]."' AND fechaCreacion<='".$p["fechaFin"].
				" 23:59:59' and tipoCarpetaAdministrativa=1 and unidadGestion<>'012'";
	
	
	$listaCarpetas=$con->obtenerListaValores($consulta,"'");
	$nCarpetas=$con->filasAfectadas;
	
	$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativaBase IN(".$listaCarpetas.
	") AND tipoCarpetaAdministrativa=6 and unidadGestion<>'012'";

	$nEjecucion=$con->obtenerValor($consulta);

	echo "<b>Periodo:</b> (".(date("Y",strtotime($p["fechaInicio"]))).") ".$arrMesLetra[(date("m",strtotime($p["fechaInicio"]))*1)-1]." - ".$arrMesLetra[(date("m",strtotime($p["fechaFin"]))*1)-1]." <br><br>Universo: ".$nCarpetas.", Ejecucion: ".$nEjecucion.", promedio: ".($nCarpetas==0?0:(($nEjecucion/$nCarpetas)*100))."<br><br>";
}

return;

*/

/* Promedio diario de nuevas carpetas recibidas por UGJ en d&iacute;as laborables*/
/*$tipo=1; //habiles
foreach($arrPeriodos as $p)
{
	
	$arrFechas=array();
	$total=0;
	$consulta="SELECT t.fechaCreacion FROM _46_tablaDinamica t,7006_carpetasAdministrativas cA WHERE t.fechaCreacion>='".$p["fechaInicio"].
				" 00:00' AND t.fechaCreacion<='".$p["fechaFin"].
			" 23:59:59' AND idEstado>1.4 AND tipoAudiencia NOT IN (91,102,114) and cA.carpetaAdministrativa=t.carpetaAdministrativa
			";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$dia=date("w",strtotime($fila[0]));
		if($tipo==1)
		{
			if($dia>=1 && $dia<=5)
			{
				if(!isset($arrFechas[date("Y-m-d",strtotime($fila[0]))]))
					$arrFechas[date("Y-m-d",strtotime($fila[0]))]=1;
				$total++;
			}
		}
		else
		{
			
			if(!($dia>=1 && $dia<=5))
			{
				if(!isset($arrFechas[date("Y-m-d",strtotime($fila[0]))]))
					$arrFechas[date("Y-m-d",strtotime($fila[0]))]=1;
				$total++;
			}
		}
	}

	echo "<b>Periodo:</b> (".(date("Y",strtotime($p["fechaInicio"]))).") ".$arrMesLetra[(date("m",strtotime($p["fechaInicio"]))*1)-1]." - ".$arrMesLetra[(date("m",strtotime($p["fechaFin"]))*1)-1]." <br><br>Total: ".$total.", dias: ".sizeof($arrFechas).", promedio: ".(sizeof($arrFechas)>0?($total/sizeof($arrFechas)/12):0)."<br><br>";
}

return;*/
// Promedio diario de nuevas carpetas recibidas por UGJ en guardias
/*$tipo=2; //habiles
foreach($arrPeriodos as $p)
{
	
	$arrFechas=array();
	$total=0;
	$consulta="SELECT t.fechaCreacion FROM _46_tablaDinamica t,7006_carpetasAdministrativas cA WHERE t.fechaCreacion>='".$p["fechaInicio"]." 00:00' AND t.fechaCreacion<='".$p["fechaFin"].
			" 23:59:59' AND idEstado>1.4 AND tipoAudiencia NOT IN (91,102,114) and cA.carpetaAdministrativa=t.carpetaAdministrativa and unidadGestion<>'012'";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$dia=date("w",strtotime($fila[0]));
		if($tipo==1)
		{
			if($dia>=1 && $dia<=5)
			{
				if(!isset($arrFechas[date("Y-m-d",strtotime($fila[0]))]))
					$arrFechas[date("Y-m-d",strtotime($fila[0]))]=1;
				$total++;
			}
		}
		else
		{
			
			if(!($dia>=1 && $dia<=5))
			{
				if(!isset($arrFechas[date("Y-m-d",strtotime($fila[0]))]))
					$arrFechas[date("Y-m-d",strtotime($fila[0]))]=1;
				$total++;
			}
		}
	}

	echo "<b>Periodo:</b> (".(date("Y",strtotime($p["fechaInicio"]))).") ".$arrMesLetra[(date("m",strtotime($p["fechaInicio"]))*1)-1]." - ".$arrMesLetra[(date("m",strtotime($p["fechaFin"]))*1)-1]." <br><br>Total: ".$total.", dias: ".sizeof($arrFechas).", promedio: ".(sizeof($arrFechas)>0?($total/sizeof($arrFechas)/10):0)."<br><br>";
}
return;*/









?>