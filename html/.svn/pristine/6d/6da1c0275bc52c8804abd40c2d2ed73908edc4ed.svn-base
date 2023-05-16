<?php include("conexionBD.php");
include_once ("latis/cExcel.php");
$baseDir=$_SERVER["DOCUMENT_ROOT"]."";

$fechaInicio="-1";
if(isset($_POST["fechaInicio"]))
	$fechaInicio=$_POST["fechaInicio"];


$fechaFin="-1";
if(isset($_POST["fechaFin"]))
	$fechaFin=$_POST["fechaFin"];	
	
$unidadGestion=-1;
if(isset($_POST["unidadGestion"]))
	$unidadGestion=$_POST["unidadGestion"];	

$periodo="Del ".date("d/m/Y",strtotime($fechaInicio))." al ".date("d/m/Y",strtotime($fechaFin));
$libro=new cExcel($baseDir."/modulosEspeciales_SGJP/formatos/plantillaSituacionResolutivosUGA.xlsx",false,"Excel2007");

$libro->setValor("A1","Periodo:");
$libro->setNegritas("A1");

$libro->setValor("A3","Fecha del evento");
$libro->setAnchoColumna("A",18);
$libro->setValor("B3","Hora de inicio");
$libro->setAnchoColumna("B",18);
$libro->setValor("C3","Carpeta Judicial");
$libro->setAnchoColumna("C",18);
$libro->setValor("D3","Tipo de audiencia");
$libro->setAnchoColumna("D",100);
$libro->setValor("E3","Situación");
$libro->setAnchoColumna("E",18);
$libro->setValor("F3","ID Evento");
$libro->setAnchoColumna("F",18);

$libro->setNegritas("A3:F3");
$libro->setColorFondo("A3:F3","DDDDDD");
$libro->setBorde("A3:F3","DE","000000");
$libro->setValor("B1",$periodo);

$arrEnRegistro=array();
$arrSinRegistro=array();


$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$unidadGestion."'";
$filaUnidad=$con->obtenerPrimeraFila($consulta);

$nFila=4;
$consulta="SELECT fechaEvento,horaInicioEvento,
(SELECT group_concat(carpetaAdministrativa) FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND 
idRegistroContenidoReferencia=e.idRegistroEvento) AS carpetaAdministrativa,
t.tipoAudiencia,
(SELECT situacion FROM 3014_registroResutadoAudiencia WHERE idEvento=e.idRegistroEvento) AS situacionResolutivo,idRegistroEvento
 FROM 7000_eventosAudiencia e,_4_tablaDinamica t
WHERE fechaEvento>='".$fechaInicio."' AND fechaEvento<='".$fechaFin."' AND idCentroGestion=".$filaUnidad[0]."
AND e.situacion IN(1,2,4,5,7) AND t.id__4_tablaDinamica=e.tipoAudiencia order by fechaEvento,horaInicioEvento";


$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{
	$libro->setValor("A".$nFila,date("d/m/Y",strtotime($fila[0])));
	$libro->setValor("B".$nFila,date("H:i",strtotime($fila[1])));
	$libro->setValor("C".$nFila,$fila[2]);
	$libro->setValor("D".$nFila,$fila[3]);
	
	
	$situacion="";
	switch($fila[4])
	{
		case "":
			$situacion="No registrado";	
			array_push($arrSinRegistro,$fila)	;		
		break;
		case "0":
			$situacion="En registro";
			array_push($arrEnRegistro,$fila);			
		break;
		case "1":
			$situacion="Registrado";			
		break;
	}
	
	$libro->setValor("E".$nFila,$situacion);
	$libro->setValor("F".$nFila,$fila[5]);
	$nFila++;
}
$libro->crearNuevaHoja();
$libro->cambiarHojaActiva(1);

$libro->setValor("A1","Periodo:");
$libro->setNegritas("A1");

$libro->setValor("A3","Fecha del evento");
$libro->setAnchoColumna("A",18);
$libro->setValor("B3","Hora de inicio");
$libro->setAnchoColumna("B",18);
$libro->setValor("C3","Carpeta Judicial");
$libro->setAnchoColumna("C",18);
$libro->setValor("D3","Tipo de audiencia");
$libro->setAnchoColumna("D",100);
$libro->setValor("E3","Situación");
$libro->setAnchoColumna("E",18);
$libro->setNegritas("A3:E3");
$libro->setColorFondo("A3:E3","DDDDDD");
$libro->setBorde("A3:E3","DE","000000");
$libro->setValor("B1",$periodo);

$nFila=4;
foreach($arrEnRegistro as $fila)
{
	
	$libro->setValor("A".$nFila,date("d/m/Y",strtotime($fila[0])));
	$libro->setValor("B".$nFila,date("H:i",strtotime($fila[1])));
	$libro->setValor("C".$nFila,$fila[2]);
	$libro->setValor("D".$nFila,$fila[3]);
	$libro->setValor("E".$nFila,"En registro");
	$nFila++;
}
$libro->crearNuevaHoja();
$libro->cambiarHojaActiva(2);

$libro->setValor("A1","Periodo:");
$libro->setNegritas("A1");

$libro->setValor("A3","Fecha del evento");
$libro->setAnchoColumna("A",18);
$libro->setValor("B3","Hora de inicio");
$libro->setAnchoColumna("B",18);
$libro->setValor("C3","Carpeta Judicial");
$libro->setAnchoColumna("C",18);
$libro->setValor("D3","Tipo de audiencia");
$libro->setAnchoColumna("D",100);
$libro->setValor("E3","Situación");
$libro->setAnchoColumna("E",18);
$libro->setNegritas("A3:E3");
$libro->setColorFondo("A3:E3","DDDDDD");
$libro->setBorde("A3:E3","DE","000000");
$libro->setValor("B1",$periodo);

$nFila=4;
foreach($arrSinRegistro as $fila)
{
	
	$libro->setValor("A".$nFila,date("d/m/Y",strtotime($fila[0])));
	$libro->setValor("B".$nFila,date("H:i",strtotime($fila[1])));
	$libro->setValor("C".$nFila,$fila[2]);
	$libro->setValor("D".$nFila,$fila[3]);
	$libro->setValor("E".$nFila,"Sin registro");
	$nFila++;
}
$libro->cambiarTituloHoja("0","Audiencias");
$libro->cambiarTituloHoja("1","En registro");
$libro->cambiarTituloHoja("2","Sin registro");
$libro->cambiarHojaActiva(0);
$libro->generarArchivo("Excel2007","situacionResolutivosUGA_".$filaUnidad[1].".xlsx");
?>