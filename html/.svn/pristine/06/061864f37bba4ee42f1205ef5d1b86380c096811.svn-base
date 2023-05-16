<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
ini_set("memory_limit","6000M");
set_time_limit(999000);

$periodoInicial="";
if(isset($_POST["fechaInicio"]))
	$periodoInicial=$_POST["fechaInicio"];

$periodoFinal="";
if(isset($_POST["fechaFin"]))
	$periodoFinal=$_POST["fechaFin"];

$idEdificio=0;
if(isset($_POST["idEdificio"]))
	$idEdificio=$_POST["idEdificio"];

	
$nFila=4;

$libro=NULL;
if($tipoMateria=="P")
{
	$libro=new cExcel("../modulosEspeciales_SGJP/formatos/formatoReporteAudienciasPenal.xlsx",true,"Excel2007");	
	
}
else
{
	$libro=new cExcel("../modulosEspeciales_SGJP/formatos/formatoReporteAudiencias.xlsx",true,"Excel2007");	
}

$libro->setValor("B1","Del ".date("d",strtotime($periodoInicial))." de ".($arrMesLetra[(date("m",strtotime($periodoInicial))*1)-1])." de ".date("Y",strtotime($periodoInicial)).
				" al ".date("d",strtotime($periodoFinal))." de ".($arrMesLetra[(date("m",strtotime($periodoFinal))*1)-1])." de ".date("Y",strtotime($periodoFinal)));	
	
$uG='0';	
$idEdificio=0;
$consulta="SELECT idRegistroEvento,fechaEvento,horaInicioEvento,horaFinEvento,(SELECT descripcionSituacion FROM 7011_situacionEventosAudiencia WHERE idSituacion=e.situacion) as situacion,
			(SELECT nombreInmueble FROM _1_tablaDinamica WHERE id__1_tablaDinamica=e.idEdificio) as edificio,
			(SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=e.idCentroGestion) as centroGestion,
			(SELECT nombreSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=e.idSala) as sala,
			(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=e.tipoAudiencia) as tipoAudiencia,idFormulario,idRegistroSolicitud,
			horaInicioReal,horaTerminoReal,urlMultimedia
			FROM 7000_eventosAudiencia e where fechaEvento>='".$periodoInicial."' and fechaEvento<='".$periodoFinal."' 
			and horaInicioEvento is not null and horaFinEvento is not null ";		
	
if($uG!=0)		
{
	$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$uG."'";
	$iUnidad=$con->obtenerValor($query);
	$consulta.=" and idCentroGestion=".$iUnidad;
}
else
{
	$query="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE cmbCategoria=1";
	$iUnidad=$con->obtenerListaValores($query);
	$consulta.=" and idCentroGestion in(".$iUnidad.")";
}

if($idEdificio!=0)
{
	$consulta.=" and idEdificio=".$idEdificio;
}

$consulta.=" order by horaInicioEvento";

$numReg=0;
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{

	$query="SELECT GROUP_CONCAT(CONCAT('(',noJuez,') ',u.nombre, ' [',e.titulo,']') SEPARATOR '<br>') FROM 800_usuarios u,
				7001_eventoAudienciaJuez e WHERE u.idUsuario=e.idJuez AND e.idRegistroEvento=".$fila[0];

	$jueces=$con->obtenerValor($query);
	
	
	
	$carpeta="";
	$tipoAudiencia=$fila[8];
	$tAudiencia="";
	$carpetaInvestigacion="";
	$consulta="SELECT c.carpetaAdministrativa,(SELECT nombreTipoCarpeta FROM 7020_tipoCarpetaAdministrativa WHERE idTipoCarpeta=c.tipoCarpetaAdministrativa)  as tCarpeta
			FROM 7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c 
			WHERE tipoContenido=3 and idRegistroContenidoReferencia=".$fila[0]." and c.carpetaAdministrativa=con.carpetaAdministrativa";
	
	$fDatos=$con->obtenerPrimeraFila($consulta);
	
	$horaProgramada="De las ".date("H:i",strtotime($fila[2]))." hrs. a las ".date("H:i",strtotime($fila[3]))." Hrs";
	$horaRealizacion="";
	if($fila[11]!="")
		$horaRealizacion="De las ".date("H:i",strtotime($fila[11]))." hrs. a las ".date("H:i",strtotime($fila[12]))." Hrs";
	$libro->setValor("A".$nFila,$fila[0]);
	$libro->setValor("B".$nFila,$fDatos[0]);
	$libro->setValor("C".$nFila,$fDatos[1]);
	$libro->setValor("D".$nFila,$fila[1]);
	$libro->setValor("E".$nFila,$fila[4]);
	$libro->setValor("F".$nFila,$horaProgramada);
	$libro->setValor("G".$nFila,$horaRealizacion);
	$libro->setValor("H".$nFila,$fila[8]);
	$libro->setValor("I".$nFila,$fila[5]);
	$libro->setValor("J".$nFila,$fila[7]);
	$libro->setValor("K".$nFila,$jueces);
	$libro->setValor("L".$nFila,$fila[6]);
	$libro->setValor("M".$nFila,$fila[13]==""?"No":"Sí");
	$libro->setValor("N".$nFila,$fila[13]);
	
	if($tipoMateria=="P")
	{
		$arrRecursosAdicionalesRequeridos="";
		$consulta="SELECT * FROM 7001_recursosAdicionalesAudiencia WHERE idRegistroEvento=".$fila[0]." and tipoRecurso=1";
		
		$resRecursos=$con->obtenerFilas($consulta);
		while($filaRecurso=mysql_fetch_assoc($resRecursos))
		{
			
			$consulta="SELECT nombreRecurso FROM _628_tablaDinamica WHERE id__628_tablaDinamica=".$filaRecurso["idRecurso"];
			$nombreRecurso=$con->obtenerValor($consulta);
			if($arrRecursosAdicionalesRequeridos=="")
				$arrRecursosAdicionalesRequeridos=$nombreRecurso;
			else
				$arrRecursosAdicionalesRequeridos.="\n".$nombreRecurso;
		}
		
		$libro->setValor("O".$nFila,$arrRecursosAdicionalesRequeridos!=""?"Sí":"No");
		$libro->setValor("P".$nFila,$arrRecursosAdicionalesRequeridos);
	}
	$nFila++;
	
	
}




$libro->generarArchivo("Excel2007","informeAudiencias.xlsx");