<?php	include("sesiones.php");
include("conexionBD.php"); 
include_once ("latis/cExcel.php");

$fechaInicio="-1";
if(isset($_POST["fechaInicio"]))
  $fechaInicio=$_POST["fechaInicio"];


$fechaFin="-1";
if(isset($_POST["fechaFin"]))
  $fechaFin=date("Y-m-d",strtotime("+1 month",strtotime($_POST["fechaFin"])));

$anioInicio=date("Y",strtotime($fechaInicio));
$mesInicio=date("m",strtotime($fechaInicio));
$anioFin=date("Y",strtotime($fechaFin));
$mesFin=date("m",strtotime($fechaFin));
$periodo="Del ".date("d/m/Y",strtotime($fechaInicio))." al ".date("d/m/Y",strtotime($fechaFin));


$libro=new cExcel("",false,"Excel2007");

$libro->setValor("A1","Periodo:");
$libro->setNegritas("A1");


$libro->setValor("B1",$periodo);
$nFila=3;
$columna="A";
$totalColumnas=1;


$arrTotalMes=array();
$libro->setValor("A".$nFila,"Juez");
$libro->setAnchoColumna("A",55);
$columna=$libro->obtenerSiguienteColumna($columna);

for($anio=$anioInicio;$anio<=$anioFin;$anio++)
{
	for($mes=$mesInicio;$mes<=12;$mes++)
	{
		$mesTermino=$anio."-".(str_pad($mes,2,STR_PAD_LEFT,"0"))."-01";
		
		if($mesTermino==$anioFin."-".$mesFin."-01")
			break;
		
		if($mes<11)
			$siguienteMes=strtotime($anio."-".(str_pad($mes+1,2,"0",STR_PAD_LEFT))."-01");
		else
		{
			$siguienteMes=strtotime(($anio+1)."-01-01");
			$mesInicio=1;
		}
			
		$libro->setValor($columna.$nFila,$arrMesLetra[$mes-1]." - ".$anio);
		$libro->setAnchoColumna($columna,18);
		$columna=$libro->obtenerSiguienteColumna($columna);
		$totalColumnas++;
		$libro->setValor($columna.$nFila,"Promedio audiencia (Min.)");
		$libro->setAnchoColumna($columna,25);
		$columna=$libro->obtenerSiguienteColumna($columna);
		$totalColumnas++;
	}
	$libro->setValor($columna.$nFila,"Total");
	$libro->setAnchoColumna($columna,18);
}
$libro->setColorFondo("A".$nFila.":".$columna.$nFila,"CCCCCC");
$columnaFinal=$columna;
$nFila++;




$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria=1 ORDER BY prioridad ";
$rUnidad=$con->obtenerFilas($consulta);
while($fUnidad=mysql_fetch_row($rUnidad))
{
	$columna="A";
	$libro->setValor($columna.$nFila,$fUnidad[1]);
	$libro->combinarCelda($columna.$nFila,$columnaFinal.$nFila);
	$libro->setHAlineacion($columna.$nFila,"I");
	$libro->setNegritas($columna.$nFila);
	$nFila++;

	$consulta="SELECT DISTINCT u.idUsuario,u.nombre  FROM  _26_tablaDinamica j,800_usuarios u WHERE j.idReferencia=".$fUnidad[0].
			" and j.usuarioJuez=u.idUsuario and usuarioJuez>0 AND usuarioJuez IS NOT NULL  order by u.Nombre";
	$rJuez=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($rJuez))
	{
		$anioInicio=date("Y",strtotime($fechaInicio));
		$mesInicio=date("m",strtotime($fechaInicio));
		$columna="A";
		$totalAudienciasJuez=0;
		$libro->setValor($columna.$nFila,$fila[1]);
		$columna=$libro->obtenerSiguienteColumna($columna);

		for($anio=$anioInicio;$anio<=$anioFin;$anio++)
		{
			for($mes=$mesInicio;$mes<=12;$mes++)
			{
				$mesInicioPeriodo=$anio."-".(str_pad($mes,2,STR_PAD_LEFT,"0"))."-01";
				
				if($mesInicioPeriodo==$anioFin."-".$mesFin."-01")
					break;
				
				if($mes<11)
					$siguienteMes=strtotime($anio."-".(str_pad($mes+1,2,"0",STR_PAD_LEFT))."-01");
				else
				{
					$siguienteMes=strtotime(($anio+1)."-01-01");
					$mesInicio=1;
				}
					
				$mesFinPeriodo=$anio."-".(str_pad($mes,2,"0",STR_PAD_LEFT))."-".date("d",strtotime("-1 days",$siguienteMes));
				$totalAudiencias=0;
				
				
				$consulta="SELECT COUNT(*)  FROM  7000_eventosAudiencia e,7001_eventoAudienciaJuez j WHERE j.idRegistroEvento=e.idRegistroEvento 
							AND e.fechaEvento>='".$mesInicioPeriodo."'  AND e.fechaEvento<'".$mesFinPeriodo."' AND e.situacion IN(1,2,4,5) AND j.idJuez=".$fila[0];
				$totalAudiencias=$con->obtenerValor($consulta);
				
				if(!isset($arrTotalMes[$mesInicioPeriodo]))
					$arrTotalMes[$mesInicioPeriodo]=0;
				
				$arrTotalMes[$mesInicioPeriodo]+=$totalAudiencias;
				
				$libro->setValor($columna.$nFila,$totalAudiencias);
				$totalAudienciasJuez+=$totalAudiencias;
				
				$columna=$libro->obtenerSiguienteColumna($columna);			
				
				
				$consulta="SELECT AVG(TIMESTAMPDIFF(MINUTE, horaInicioReal,horaTerminoReal ))  FROM  7000_eventosAudiencia e,7001_eventoAudienciaJuez j WHERE j.idRegistroEvento=e.idRegistroEvento 
							AND e.fechaEvento>='".$mesInicioPeriodo."'  AND e.fechaEvento<'".$mesFinPeriodo."' 
							AND e.situacion IN(1,2,4,5) AND j.idJuez=".$fila[0]." AND horaInicioReal IS NOT NULL AND (TIMESTAMPDIFF(MINUTE, horaInicioReal,horaTerminoReal )>15) AND  
							(TIMESTAMPDIFF(MINUTE, horaInicioReal,horaTerminoReal )<400)";
				$promedioAudiencia=$con->obtenerValor($consulta);
				$libro->setValor($columna.$nFila,$promedioAudiencia);
				$columna=$libro->obtenerSiguienteColumna($columna);			
							
				
				
				
				
			}
		}
		
		$libro->setValor($columna.$nFila,$totalAudienciasJuez);
		$nFila++;
		
	}
	
}
$columna="A";
$libro->setValor("A".$nFila,"Total:");
$columna=$libro->obtenerSiguienteColumna($columna);
$granTotal=0;
foreach($arrTotalMes as $fecha=>$total)
{
	$libro->setValor($columna.$nFila,$total);
	$granTotal+=$total;
	$columna=$libro->obtenerSiguienteColumna($columna);

}
$libro->setValor($columna.$nFila,$granTotal);
$libro->setColorFondo("A".$nFila.":".$columnaFinal.$nFila,"CCCCCC");

$libro->setBorde("A3:".$columnaFinal.$nFila,"DE");
$libro->generarArchivo("Excel2007","informeAudienciasJuezPorUGJ.xlsx");
?>