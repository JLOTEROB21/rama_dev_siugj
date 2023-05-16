<?php ini_set('memory_limit', '20000M');
include("sesiones.php");
include("conexionBD.php");
include_once ("latis/cExcel.php");


$arrDatosGenerales=array();
$numHojas=0;
$libro=new cExcel("",false,"Excel2007");
$consulta="SELECT id__17_tablaDinamica,upper(tituloUnidad),upper(e.nombreInmueble) FROM _17_tablaDinamica u,_420_unidadGestion g,_1_tablaDinamica e WHERE 
			g.idOpcion=u.id__17_tablaDinamica AND u.idReferencia=e.id__1_tablaDinamica ORDER BY u.prioridad";
$rUnidad=$con->obtenerFilas($consulta);
while($fUnidad=mysql_fetch_row($rUnidad))
{
	$idUnidad=$fUnidad[0];	
	$nombreUnidad=$fUnidad[1];		
	
	$libro->crearNuevaHoja();
	$numHojas++;
	$libro->cambiarTituloHoja($numHojas,substr(str_replace("UNIDAD ESPECIALIZADA EN EJECUCIÓN Y SANCIONES PENALES","EJECUCIÓN",str_replace("UNIDAD DE GESTIÓN JUDICIAL","UGJ ",$nombreUnidad)),0,25));
	$libro->cambiarTituloHoja(0,"Generales");
	$libro->cambiarHojaActiva($numHojas);
	
	
	$director="";
	$nFila=1;
	$libro->combinarCelda("A".$nFila,"C".$nFila);
	$libro->setValor("A".$nFila,$nombreUnidad);
	$libro->setNegritas("A".$nFila);
	$libro->setColorFondo("A".$nFila,"CCCCCC");
	$nFila+=2;
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
		
		if(!isset($arrDatosGenerales[$fUnidad[2]]))
			$arrDatosGenerales[$fUnidad[2]]=array();
		
		
		$aDatosUnidad=array();
		$aDatosUnidad["nombreUGA"]=$nombreUnidad;
		$aDatosUnidad["director"]=$director;
		$aDatosUnidad["personalAdscrito"]=$nPuestosAsignados;
		$aDatosUnidad["vacantes"]=$nPuestosVacantes;
		$aDatosUnidad["juecesControl"]=$totalJueces[1];
		$aDatosUnidad["juecesJuicioOral"]=$totalJueces[2];
		$aDatosUnidad["juecesEjecucion"]=$totalJueces[3];

		array_push($arrDatosGenerales[$fUnidad[2]],$aDatosUnidad);
		
		
		
		
		
		
	}
	else
	{
		$libro->removerHoja($numHojas);
		$numHojas--;
	}
	
	
}


ksort($arrDatosGenerales);
$libro->cambiarHojaActiva(0);
$nFila=1;
$libro->combinarCelda("A".$nFila,"F".$nFila);
$libro->setValor("A".$nFila,"ESTRUCTURA DE LAS UNIDADES DE GESTIÓN JUDICIAL POR EDIFICIO");
$libro->setNegritas("A".$nFila);

$libro->setAnchoColumna("A",30);
$nFila+=2;


foreach($arrDatosGenerales as $edificio=>$arrUnidades)
{
	
	$libro->combinarCelda("A".$nFila,"K".$nFila);
	$libro->setValor("A".$nFila,$edificio);
	$libro->setNegritas("A".$nFila);
	$libro->setColorFondo("A".$nFila,"CCCCCC");
	$libro->setAnchoColumna("A",30);
	$libro->setBorde("A".$nFila.":K".$nFila,"DE","000000");
	$nFila+=2;
	foreach($arrUnidades as $unidad)
	{
		$nInicial=$nFila;
		$libro->combinarCelda("A".$nFila,"F".$nFila);
		$libro->setValor("A".$nFila,$unidad["nombreUGA"]);
		$libro->setNegritas("A".$nFila);
		$libro->setColorFondo("A".$nFila,"EFEFEF");
		$libro->setAnchoColumna("A",30);
		$nFila++;
		$libro->combinarCelda("A".$nFila,"F".$nFila);
		$libro->setValor("A".$nFila,"Director: ".$unidad["director"]);
		$libro->setNegritas("A".$nFila);
		$libro->setColorFondo("A".$nFila,"EFEFEF");
		$libro->setAnchoColumna("A",30);
		$nFila++;
		$libro->setValor("A".$nFila,"Personal adscrito:");
		$libro->setValor("B".$nFila,$unidad["personalAdscrito"]);
		$libro->combinarCelda("B".$nFila,"F".$nFila);
		$nFila++;
		$libro->setValor("A".$nFila,"Vacantes:");
		$libro->setValor("B".$nFila,$unidad["vacantes"]);
		$libro->combinarCelda("B".$nFila,"F".$nFila);
		$nFila++;
		$libro->setValor("A".$nFila,"Jueces de control:");
		$libro->setValor("B".$nFila,$unidad["juecesControl"]);
		$libro->combinarCelda("B".$nFila,"F".$nFila);
		$nFila++;
		$libro->setValor("A".$nFila,"Jueces de juicio oral:");
		$libro->setValor("B".$nFila,$unidad["juecesJuicioOral"]);
		$libro->combinarCelda("B".$nFila,"F".$nFila);
		$nFila++;
		$libro->setValor("A".$nFila,"Jueces de ejecución:");
		$libro->setValor("B".$nFila,$unidad["juecesEjecucion"]);
		$libro->combinarCelda("B".$nFila,"F".$nFila);
		$nFila++;
		$libro->setBorde("A".$nInicial.":F".($nFila-1),"DE","000000");
		$nFila+=2;
	}
}
$libro->generarArchivo("Excel2007","EstructuraUnidadesGestion.xlsx");

?>