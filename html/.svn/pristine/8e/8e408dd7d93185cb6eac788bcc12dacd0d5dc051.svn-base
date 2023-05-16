<?php
ini_set("memory_limit","3000M");
set_time_limit(999000);
include("sesiones.php");
include("conexionBD.php");


$periodoInicial="";
if(isset($_POST["fechaInicio"]))
	$periodoInicial=$_POST["fechaInicio"];

$periodoFinal="";
if(isset($_POST["fechaFin"]))
	$periodoFinal=$_POST["fechaFin"];

$nFila=4;

$libro=new cExcel("../modulosEspeciales_SGJP/formatos/plantillaInformeHorasEfectivasJuez.xlsx",true,"Excel2007");		

$libro->setAnchoColumna("A",40);
$libro->setAnchoColumna("B",18);
$libro->setAnchoColumna("C",18);
$libro->setAnchoColumna("D",18);
$libro->setAnchoColumna("E",18);
$libro->setAnchoColumna("F",25);


$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria=1 ORDER BY prioridad ";
$rUnidad=$con->obtenerFilas($consulta);
while($fUnidad=mysql_fetch_row($rUnidad))
{
	
	$libro->setValor("A".$nFila,$fUnidad[1]);
	$libro->combinarCelda("A".$nFila,"F".$nFila);
	$libro->setNegritas("A".$nFila);
	$nFila++;
	$libro->setValor("A".$nFila,"Juez");
	$libro->setValor("B".$nFila,"Fecha");
	$libro->setValor("C".$nFila,"Total de audiencias");
	$libro->setValor("D".$nFila,"Inicia");
	$libro->setValor("E".$nFila,"Termina");
	$libro->setValor("F".$nFila,"Duración");
	$libro->setNegritas("A".$nFila.":"."F".$nFila);
	$nFila++;
	$consulta="SELECT DISTINCT u.idUsuario,u.nombre,j.clave  FROM  _26_tablaDinamica j,800_usuarios u WHERE j.idReferencia=".$fUnidad[0].
			" and j.usuarioJuez=u.idUsuario and usuarioJuez>0 AND usuarioJuez IS NOT NULL  order by j.clave";
	$rJuez=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($rJuez))
	{
		$nEvento=1;
		$arrEventos=array();
		$consulta="SELECT * FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez a WHERE e.idRegistroEvento=a.idRegistroEvento
					AND e.fechaEvento>='".$periodoInicial."' AND e.fechaEvento<='".$periodoFinal."' AND a.idJuez=".$fila[0]." AND 
					e.situacion in(1,2,4,5) ORDER BY horaInicioEvento";
		$resEvento=$con->obtenerFilas($consulta);					
		while($fEvento=mysql_fetch_assoc($resEvento))
		{
			if(!isset($arrEventos[$fEvento["fechaEvento"]]))
			{
				$arrEventos[$fEvento["fechaEvento"]]=array();
			}
			array_push($arrEventos[$fEvento["fechaEvento"]],$fEvento);
			
		}
		
		foreach($arrEventos as $fecha=>$resto)
		{
			if($nEvento==1)
			{
				$libro->setValor("A".$nFila,"(".$fila[2].") ".$fila[1]);
				$libro->setColorFondo("A".$nFila.":F".$nFila,"CCCCCC","S");
				//$libro->setNegritas("A".$nFila.":F".$nFila);
				
			}
			$libro->setValor("B".$nFila,date("d/m/Y",strtotime($fecha)));
			$libro->setValor("C".$nFila,sizeof($resto));
			$libro->setHAlineacion("C".$nFila,"C");
			$totalDuracion=0;
			foreach($resto as $fEvento)
			{
				
				$horaInicioReal=$fEvento["horaInicioReal"];
				$horaTerminoReal=$fEvento["horaTerminoReal"];
				if($horaInicioReal=="")
				{
					$horaInicioReal=$fEvento["horaInicioEvento"];
					$horaTerminoReal=$fEvento["horaFinEvento"];
				}
				$horaInicioReal=strtotime($fEvento["horaInicioReal"]);
				$horaTerminoReal=strtotime($fEvento["horaTerminoReal"]);
				$libro->setValor("D".$nFila,date("H:i",$horaInicioReal));
				$libro->setValor("E".$nFila,date("H:i",$horaTerminoReal));
				$duracion=obtenerDiferenciaMinutos(date("Y-m-d H:i",$horaInicioReal),date("Y-m-d H:i",$horaTerminoReal));
				$totalDuracion+=$duracion;
				$lblDuracion=convertirMinutosToHora($duracion);
				
				$libro->setValor("F".$nFila,$lblDuracion);
				$nFila++;
				
			}
			$nEvento++;
			$libro->setValor("E".$nFila,"Total horas");
			$libro->setValor("F".$nFila,convertirMinutosToHora($totalDuracion));
			$libro->setColorFondo("A".$nFila.":F".$nFila,"CCCCCC","S");
			$libro->setNegritas("A".$nFila.":F".$nFila);
			$nFila++;
		}
		$nFila++;
	}
}

function convertirMinutosToHora($duracion)
{
	$horasDuracion=parteEntera($duracion/60,false);
	$minutosDuracion=$duracion-($horasDuracion*60);
	$lblDuracion="";
	if($horasDuracion>0)
	{
		$lblDuracion=$horasDuracion.($horasDuracion==1?" hora":" horas");
	}
	if($minutosDuracion>0)
	{
		if($lblDuracion=="")
			$lblDuracion=$minutosDuracion.($minutosDuracion==1? " minuto":" minutos");
		else
			$lblDuracion.=", ".$minutosDuracion.($minutosDuracion==1? " minuto":" minutos");
	}
	
	return $lblDuracion;
}

$libro->generarArchivo("Excel2007","informeAudienciasJuezPorUGJ.xlsx");


?>