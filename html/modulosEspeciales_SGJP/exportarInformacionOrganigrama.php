<?php ini_set('memory_limit', '20000M');
include("sesiones.php");
include("conexionBD.php");
include_once ("latis/cExcel.php");

$idUnidad=-1;
if(isset($_POST["uG"]))
	$idUnidad=$_POST["uG"];

$consulta="SELECT upper(nombreUnidad) FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$idUnidad;

$nombreUnidad=$con->obtenerValor($consulta);


$libro=new cExcel("",false,"Excel2007");

$libro->crearNuevaHoja();
$libro->cambiarTituloHoja(1,"Listado Puestos");
$libro->cambiarTituloHoja(0,"Generales");
$libro->cambiarHojaActiva(1);


$director="";
$nFila=1;
$libro->combinarCelda("A".$nFila,"C".$nFila);
$libro->setValor("A".$nFila,"PUESTOS ASIGNADOS");
$libro->setNegritas("A".$nFila);
$libro->setColorFondo("A".$nFila,"CCCCCC");

$nFila++;
$libro->setValor("A".$nFila,"NO.");
$libro->setAnchoColumna("A",8);
$libro->setValor("B".$nFila,"PUESTO");
$libro->setAnchoColumna("B",60);
$libro->setValor("C".$nFila,"EMPLEADO");
$libro->setAnchoColumna("C",60);
$libro->setNegritas("A".$nFila.":C".$nFila);
$libro->setColorFondo("A".$nFila.":C".$nFila,"CCCCCC");

$nFila++;

$arrPuestosVacantes=array();
$nPuestosAsignados=0;
$nPuestosVacantes=0;
$nJuecesControl=0;
$nJuecesEnjuiciamiento=0;
$nJuecesEjecucion=0;

$consulta="SELECT idPadre FROM _420_unidadGestion WHERE idOpcion=".$idUnidad;
$idPerfil=$con->obtenerValor($consulta);
if($idPerfil=="")
	$idPerfil=-1;

$arrHijos="";
$consulta="SELECT claveNivel,puestoOrganozacional,usuarioAsignado FROM _421_tablaDinamica WHERE idReferencia=".$idPerfil." AND tipoNivel=1";
$fila=$con->obtenerPrimeraFila($consulta);
if($fila)
{
	$director="VACANTE";
	if($fila[2]!="")
		$director=obtenerNombreUsuario($fila[2]);	
	$consulta="select * from _421_tablaDinamica WHERE idReferencia=".$idPerfil." AND claveNivel like '".$fila[0]."%' order by claveNivel";
	$res=$con->obtenerFilas($consulta);
	$nPuesto=1;
	while($filaOrganizacion=mysql_fetch_assoc($res))
	{
		$consulta="SELECT upper(nombrePuesto) FROM _416_tablaDinamica WHERE id__416_tablaDinamica=".$filaOrganizacion["puestoOrganozacional"];
		$nombrePuesto=$con->obtenerValor($consulta);
		
		$nombreEmpleado="";
		if($filaOrganizacion["usuarioAsignado"]!="")
		{
			
			$nombreEmpleado=obtenerNombreUsuario($filaOrganizacion["usuarioAsignado"]);

			$libro->setValor("A".$nFila,$nPuesto.".-");
			$libro->setValor("B".$nFila,$nombrePuesto);
			$libro->setValor("C".$nFila,$nombreEmpleado);
			$nFila++;
			$nPuesto++;
			$nPuestosAsignados++;
		}
		else
		{
			array_push($arrPuestosVacantes,$nombrePuesto);
			$nPuestosVacantes++;
		}
		
		
	}
	$libro->setBorde("A1:C".($nFila-1),"DE","000000");
	$nFila++;
	
	$nInicio=$nFila;
	$libro->combinarCelda("A".$nFila,"B".$nFila);
	$libro->setValor("A".$nFila,"PUESTOS VACANTES");
	$libro->setNegritas("A".$nFila.":"."B".($nFila+1));
	$libro->setColorFondo("A".$nFila.":"."B".($nFila+1),"CCCCCC");
	$nFila++;
	$libro->setValor("A".$nFila,"NO.");
	$libro->setAnchoColumna("A",8);
	$libro->setValor("B".$nFila,"PUESTO");
	$libro->setAnchoColumna("B",60);
	
	
	$nFila++;
	$nPuesto=1;
	foreach($arrPuestosVacantes as $p)
	{
		$libro->setValor("A".$nFila,$nPuesto.".-");
		$libro->setValor("B".$nFila,$p);
		$nFila++;
		$nPuesto++;
	}
	$libro->setBorde("A".$nInicio.":B".($nFila-1),"DE","000000");
	
	$totalJueces[1]=0;
	$totalJueces[2]=0;
	$totalJueces[3]=0;
	$arrJueces[1]="JUECES DE CONTROL";
	$arrJueces[2]="JUECES DE JUICIO ORAL";
	$arrJueces[3]="JUECES DE EJECUCIÓN";
	
	foreach($arrJueces as $idJuez=>$lblJuez)
	{
		$nFila++;
		$nInicio=$nFila;
		$libro->combinarCelda("A".$nFila,"C".$nFila);
		$libro->setValor("A".$nFila,$lblJuez);
		$libro->setNegritas("A".$nFila.":"."C".($nFila+1));
		$libro->setColorFondo("A".$nFila.":"."C".($nFila+1),"CCCCCC");
		$nFila++;
		$libro->setValor("A".$nFila,"NO.");
		$libro->setValor("B".$nFila,"CVE. JUEZ");
		$libro->setValor("C".$nFila,"NOMBRE ");
		$nFila++;
		$nPuesto=1;
		$consulta="SELECT j.clave,u.nombre FROM _26_tablaDinamica j,_26_tipoJuez tj,800_usuarios u WHERE tj.idPadre=j.id__26_tablaDinamica
					AND j.idReferencia=".$idUnidad." AND j.usuarioJuez=u.idUsuario AND j.usuarioJuez IS NOT NULL AND j.usuarioJuez<>-1 
					AND tj.idOpcion=".$idJuez." ORDER BY j.clave";
		$res=$con->obtenerFilas($consulta);
		while($f=mysql_fetch_row($res))
		{
			$libro->setValor("A".$nFila,$nPuesto.".-");
			$libro->setValor("B".$nFila,"'".$f[0]);
			$libro->setValor("C".$nFila,$f[1]);
			$nFila++;
			$nPuesto++;
			$totalJueces[$idJuez]++;
		}
		$libro->setBorde("A".$nInicio.":C".($nFila-1),"DE","000000");
	}
	
	$libro->cambiarHojaActiva(0);
	$nFila=1;
	$libro->combinarCelda("A".$nFila,"F".$nFila);
	$libro->setValor("A".$nFila,$nombreUnidad);
	$libro->setNegritas("A".$nFila);
	$libro->setColorFondo("A".$nFila,"CCCCCC");
	$libro->setAnchoColumna("A",30);
	$nFila++;
	$libro->combinarCelda("A".$nFila,"F".$nFila);
	$libro->setValor("A".$nFila,"Director: ".$director);
	$libro->setNegritas("A".$nFila);
	$libro->setColorFondo("A".$nFila,"CCCCCC");
	$libro->setAnchoColumna("A",30);
	$nFila++;
	$libro->setValor("A".$nFila,"Personal adscrito:");
	$libro->setValor("B".$nFila,$nPuestosAsignados);
	$libro->combinarCelda("B".$nFila,"F".$nFila);
	$nFila++;
	$libro->setValor("A".$nFila,"Vacantes:");
	$libro->setValor("B".$nFila,$nPuestosVacantes);
	$libro->combinarCelda("B".$nFila,"F".$nFila);
	$nFila++;
	$libro->setValor("A".$nFila,"Jueces de control:");
	$libro->setValor("B".$nFila,$totalJueces[1]);
	$libro->combinarCelda("B".$nFila,"F".$nFila);
	$nFila++;
	$libro->setValor("A".$nFila,"Jueces de juicio oral:");
	$libro->setValor("B".$nFila,$totalJueces[2]);
	$libro->combinarCelda("B".$nFila,"F".$nFila);
	$nFila++;
	$libro->setValor("A".$nFila,"Jueces de ejecución:");
	$libro->setValor("B".$nFila,$totalJueces[3]);
	$libro->combinarCelda("B".$nFila,"F".$nFila);
	$nFila++;
	$libro->setBorde("A1:F7","DE","000000");

	$libro->generarArchivo("Excel2007","personal_".str_replace(" ","_",$nombreUnidad).".xlsx");
	
}


?>