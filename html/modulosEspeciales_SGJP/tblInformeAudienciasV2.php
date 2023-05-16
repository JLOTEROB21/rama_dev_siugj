<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");



$periodoInicial=$_POST["fechaInicio"];


$periodoFinal=$_POST["fechaFin"];

$arrAudiencias=array();

$filaContinuacionIniciales=0;
$filaContinuacionPromociones=0;


$libro=new cExcel("../modulosEspeciales_SGJP/formatos/plantillaAudienciasV2.xlsx",true,"Excel2007");	


$libro->setValor("A1","Periodo del ".date("d/m/Y",strtotime($periodoInicial))." al ".date("d/m/Y",strtotime($periodoFinal)));


$consulta="SELECT DISTINCT e.tipoAudiencia,t.tipoAudiencia FROM 7000_eventosAudiencia e,_4_tablaDinamica t 
		WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' AND e.situacion in(1,2,4,5)
		and e.tipoAudiencia=t.id__4_tablaDinamica and idFormulario in(46,11) order by t.tipoAudiencia";
$res=$con->obtenerFilas($consulta);
$nFilas=$con->filasAfectadas;
$posFila=5;
$libro->cambiarHojaActiva(1);
$libro->insertarFila($posFila,$nFilas);
while($fDatos=mysql_fetch_row($res))
{
	$libro->setValor("A".$posFila,$fDatos[1]);
	if($fDatos[0]==25)
		$filaContinuacionIniciales=$posFila-1;
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=15 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and idFormulario in(46,11) AND e.situacion in(1,2,4,5) AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$nReg++;
	}
	$libro->setValor("B".$posFila,$nReg);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=16 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and idFormulario in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		
		$nReg++;
	}
	
	$libro->setValor("C".$posFila,$nReg);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=17 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and idFormulario in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		
		$nReg++;
	}
	
	$libro->setValor("D".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=25 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and idFormulario in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		
		$nReg++;
	}
	
	$libro->setValor("E".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud,e.idRegistroEvento from 7000_eventosAudiencia e WHERE idCentroGestion=32 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and idFormulario in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$nRegTribunal=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fEventos[2];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
			$nRegTribunal++;
		else
			$nReg++;
		
		

	}
	
	$libro->setValor("F".$posFila,$nReg);
	$libro->setValor("J".$posFila,$nRegTribunal);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=33 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and idFormulario in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$nReg++;
	}
	
	$libro->setValor("G".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=34 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and idFormulario in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$nReg++;
	}
	
	$libro->setValor("H".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=35 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and idFormulario in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$nReg++;
	}
	
	$libro->setValor("I".$posFila,$nReg);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=36 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and idFormulario in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$nReg++;
	}
	
	$libro->setValor("K".$posFila,$nReg);
	
	$libro->setValor("L".$posFila,"=sum(B".$posFila.":K".$posFila.")");
	
	$posFila++;
}

$libro->setValor("B".$posFila,"=sum(B4:B".($posFila-1).")");
$libro->setValor("C".$posFila,"=sum(C4:C".($posFila-1).")");
$libro->setValor("D".$posFila,"=sum(D4:D".($posFila-1).")");
$libro->setValor("E".$posFila,"=sum(E4:E".($posFila-1).")");
$libro->setValor("F".$posFila,"=sum(F4:F".($posFila-1).")");
$libro->setValor("G".$posFila,"=sum(G4:G".($posFila-1).")");
$libro->setValor("H".$posFila,"=sum(H4:H".($posFila-1).")");
$libro->setValor("I".$posFila,"=sum(I4:I".($posFila-1).")");
$libro->setValor("J".$posFila,"=sum(J4:J".($posFila-1).")");
$libro->setValor("K".$posFila,"=sum(K4:K".($posFila-1).")");
$libro->setValor("L".$posFila,"=sum(L4:L".($posFila-1).")");
$libro->removerFila(4,1);

$libro->cambiarHojaActiva(0);


$libro->setValor("D3","='Tipos de audiencia x unidad'!B".($posFila-1));
$libro->setValor("D4","='Tipos de audiencia x unidad'!C".($posFila-1));
$libro->setValor("D5","='Tipos de audiencia x unidad'!D".($posFila-1));
$libro->setValor("D6","='Tipos de audiencia x unidad'!E".($posFila-1));
$libro->setValor("D7","='Tipos de audiencia x unidad'!F".($posFila-1));
$libro->setValor("D8","='Tipos de audiencia x unidad'!G".($posFila-1));
$libro->setValor("D9","='Tipos de audiencia x unidad'!H".($posFila-1));
$libro->setValor("D10","='Tipos de audiencia x unidad'!I".($posFila-1));
$libro->setValor("D11","='Tipos de audiencia x unidad'!K".($posFila-1));
$libro->setValor("D12","='Tipos de audiencia x unidad'!J".($posFila-1));
$libro->setValor("D13","=sum(D3:D12)");

$libro->cambiarHojaActiva(1);

$posFila+=6;
$posInicial=$posFila;

$consulta="SELECT DISTINCT e.tipoAudiencia,t.tipoAudiencia FROM 7000_eventosAudiencia e,_4_tablaDinamica t 
		WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' AND e.situacion in(1,2,4,5)
		and e.tipoAudiencia=t.id__4_tablaDinamica and e.idFormulario=185 order by t.tipoAudiencia";
$res=$con->obtenerFilas($consulta);
$nFilas=$con->filasAfectadas;

$libro->insertarFila($posInicial,$nFilas);
while($fDatos=mysql_fetch_row($res))
{
	$libro->setValor("A".$posFila,$fDatos[1]);
	if($fDatos[0]==25)
		$filaContinuacionPromociones=$posFila-1;
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=15 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' AND e.idFormulario=185 AND e.situacion in(1,2,4,5)  and  tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nReg++;
	}
	
	
	
	
	
	$libro->setValor("B".$posFila,$nReg);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=16 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' AND e.idFormulario=185 AND e.situacion in(1,2,4,5)  and tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nReg++;
	}
	
	$libro->setValor("C".$posFila,$nReg);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=17 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' AND e.idFormulario=185 AND e.situacion in(1,2,4,5)  and tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nReg++;
	}
	
	$libro->setValor("D".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=25 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' AND e.idFormulario=185 AND e.situacion in(1,2,4,5)  and tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nReg++;
	}
	
	$libro->setValor("E".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud,idRegistroEvento from 7000_eventosAudiencia e WHERE idCentroGestion=32 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' AND e.idFormulario=185 AND e.situacion in(1,2,4,5)  and tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$nRegTribunal=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fEventos[2];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
			$nRegTribunal++;
		else
			$nReg++;
	}
	
	$libro->setValor("F".$posFila,$nReg);
	$libro->setValor("J".$posFila,$nRegTribunal);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=33 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' AND e.idFormulario=185 AND e.situacion in(1,2,4,5)  and tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nReg++;
	}
	
	$libro->setValor("G".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=34 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' AND e.idFormulario=185 AND e.situacion in(1,2,4,5)  and tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nReg++;
	}
	
	$libro->setValor("H".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=35 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' AND e.idFormulario=185 AND e.situacion in(1,2,4,5)  and tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nReg++;
	}
	
	$libro->setValor("I".$posFila,$nReg);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=36 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' AND e.idFormulario=185 AND e.situacion in(1,2,4,5)  and tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
		$iFormulario=$con->obtenerValor($consulta);
		if($iFormulario!=96)
		{
			continue;
		}
		$nReg++;
	}
	
	$libro->setValor("K".$posFila,$nReg);	
	$libro->setValor("L".$posFila,"=sum(B".$posFila.":K".$posFila.")");
	$posFila++;
}


$libro->setValor("B".$posFila,"=sum(B".$posInicial.":B".($posFila-1).")");
$libro->setValor("C".$posFila,"=sum(C".$posInicial.":C".($posFila-1).")");
$libro->setValor("D".$posFila,"=sum(D".$posInicial.":D".($posFila-1).")");
$libro->setValor("E".$posFila,"=sum(E".$posInicial.":E".($posFila-1).")");
$libro->setValor("F".$posFila,"=sum(F".$posInicial.":F".($posFila-1).")");
$libro->setValor("G".$posFila,"=sum(G".$posInicial.":G".($posFila-1).")");
$libro->setValor("H".$posFila,"=sum(H".$posInicial.":H".($posFila-1).")");
$libro->setValor("I".$posFila,"=sum(I".$posInicial.":I".($posFila-1).")");
$libro->setValor("J".$posFila,"=sum(J".$posInicial.":J".($posFila-1).")");
$libro->setValor("K".$posFila,"=sum(K".$posInicial.":K".($posFila-1).")");
$libro->setValor("L".$posFila,"=sum(L".$posInicial.":L".($posFila-1).")");
$libro->removerFila($posInicial-1,1);

$libro->cambiarHojaActiva(0);
$libro->setValor("E3","='Tipos de audiencia x unidad'!B".($posFila-1));
$libro->setValor("E4","='Tipos de audiencia x unidad'!C".($posFila-1));
$libro->setValor("E5","='Tipos de audiencia x unidad'!D".($posFila-1));
$libro->setValor("E6","='Tipos de audiencia x unidad'!E".($posFila-1));
$libro->setValor("E7","='Tipos de audiencia x unidad'!F".($posFila-1));
$libro->setValor("E8","='Tipos de audiencia x unidad'!G".($posFila-1));
$libro->setValor("E9","='Tipos de audiencia x unidad'!H".($posFila-1));
$libro->setValor("E10","='Tipos de audiencia x unidad'!I".($posFila-1));
$libro->setValor("E11","='Tipos de audiencia x unidad'!K".($posFila-1));
$libro->setValor("E12","='Tipos de audiencia x unidad'!J".($posFila-1));
$libro->setValor("E13","=sum(E3:E12)");


$libro->cambiarHojaActiva(1);
$posFila+=6;
$posInicial=$posFila;
$consulta="SELECT DISTINCT e.tipoAudiencia,t.tipoAudiencia FROM 7000_eventosAudiencia e,_4_tablaDinamica t 
		WHERE fechaEvento>='".$periodoInicial."' AND fechaEvento<='".$periodoFinal."' AND e.situacion in(1,2,4,5)
		and e.tipoAudiencia=t.id__4_tablaDinamica and e.idFormulario not in(46,11) order by t.tipoAudiencia";
$res=$con->obtenerFilas($consulta);
$nFilas=$con->filasAfectadas;

$libro->insertarFila($posFila,$nFilas);
while($fDatos=mysql_fetch_row($res))
{
	
	$libro->setValor("A".$posFila,$fDatos[1]);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=15 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and e.idFormulario not in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		if($fEventos[0]==185)
		{
			$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
			$iFormulario=$con->obtenerValor($consulta);
			if($iFormulario==96)
			{
				continue;
			}
			
			
		}
		$nReg++;
	}
	$libro->setValor("B".$posFila,$nReg);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=16 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and e.idFormulario not in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		if($fEventos[0]==185)
		{
			$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
			$iFormulario=$con->obtenerValor($consulta);
			if($iFormulario==96)
			{
				continue;
			}
			
			
		}
		$nReg++;
	}
	
	$libro->setValor("C".$posFila,$nReg);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=17 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and e.idFormulario not in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		if($fEventos[0]==185)
		{
			$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
			$iFormulario=$con->obtenerValor($consulta);
			if($iFormulario==96)
			{
				continue;
			}
			
			
		}
		$nReg++;
	}
	
	$libro->setValor("D".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=25 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and e.idFormulario not in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		if($fEventos[0]==185)
		{
			$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
			$iFormulario=$con->obtenerValor($consulta);
			if($iFormulario==96)
			{
				continue;
			}
			
			
		}
		$nReg++;
	}
	
	$libro->setValor("E".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud,e.idRegistroEvento from 7000_eventosAudiencia e WHERE idCentroGestion=32 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and e.idFormulario not in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$nRegTribunal=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		if($fEventos[0]==185)
		{
			$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
			$iFormulario=$con->obtenerValor($consulta);
			if($iFormulario==96)
			{
				continue;
			}
			
			
		}
		
		
		
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 
					AND idRegistroContenidoReferencia=".$fEventos[2];
		$cAdministrativa=$con->obtenerValor($consulta);
		if(strpos($cAdministrativa,"TE/")!==false)
			$nRegTribunal++;
		else
			$nReg++;
		
		
	
	}
	
	$libro->setValor("F".$posFila,$nReg);
	$libro->setValor("J".$posFila,$nRegTribunal);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=33 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and e.idFormulario not in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		if($fEventos[0]==185)
		{
			$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
			$iFormulario=$con->obtenerValor($consulta);
			if($iFormulario==96)
			{
				continue;
			}
			
			
		}
		$nReg++;
	}
	
	$libro->setValor("G".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=34 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and e.idFormulario not in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		if($fEventos[0]==185)
		{
			$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
			$iFormulario=$con->obtenerValor($consulta);
			if($iFormulario==96)
			{
				continue;
			}
			
			
		}
		$nReg++;
	}
	
	$libro->setValor("H".$posFila,$nReg);
	
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=35 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and e.idFormulario not in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		if($fEventos[0]==185)
		{
			$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
			$iFormulario=$con->obtenerValor($consulta);
			if($iFormulario==96)
			{
				continue;
			}
			
			
		}
		$nReg++;
	}
	
	$libro->setValor("I".$posFila,$nReg);
	
	$consulta="SELECT e.idFormulario,e.idRegistroSolicitud from 7000_eventosAudiencia e WHERE idCentroGestion=36 AND fechaEvento>='".$periodoInicial."' 
			AND fechaEvento<='".$periodoFinal."' and e.idFormulario not in(46,11) AND e.situacion in(1,2,4,5)  AND tipoAudiencia=".$fDatos[0];
	$nReg=0;
	$resEventos=$con->obtenerFilas($consulta);
	while($fEventos=mysql_fetch_row($resEventos))
	{
		if($fEventos[0]==185)
		{
			$consulta="SELECT iFormulario FROM _185_tablaDinamica WHERE id__185_tablaDinamica=".$fEventos[1];
			$iFormulario=$con->obtenerValor($consulta);
			if($iFormulario==96)
			{
				continue;
			}
			
			
		}
		$nReg++;
	}
	
	$libro->setValor("K".$posFila,$nReg);
	
	$libro->setValor("L".$posFila,"=sum(B".$posFila.":K".$posFila.")");
	
	$posFila++;
}

$libro->setValor("B".$posFila,"=sum(B".$posInicial.":B".($posFila-1).")");
$libro->setValor("C".$posFila,"=sum(C".$posInicial.":C".($posFila-1).")");
$libro->setValor("D".$posFila,"=sum(D".$posInicial.":D".($posFila-1).")");
$libro->setValor("E".$posFila,"=sum(E".$posInicial.":E".($posFila-1).")");
$libro->setValor("F".$posFila,"=sum(F".$posInicial.":F".($posFila-1).")");
$libro->setValor("G".$posFila,"=sum(G".$posInicial.":G".($posFila-1).")");
$libro->setValor("H".$posFila,"=sum(H".$posInicial.":H".($posFila-1).")");
$libro->setValor("I".$posFila,"=sum(I".$posInicial.":I".($posFila-1).")");
$libro->setValor("J".$posFila,"=sum(J".$posInicial.":J".($posFila-1).")");
$libro->setValor("K".$posFila,"=sum(K".$posInicial.":K".($posFila-1).")");
$libro->setValor("L".$posFila,"=sum(L".$posInicial.":L".($posFila-1).")");
$libro->removerFila($posInicial-1,1);

$libro->cambiarHojaActiva(0);
$libro->setValor("F3","='Tipos de audiencia x unidad'!B".($posFila-1));
$libro->setValor("F4","='Tipos de audiencia x unidad'!C".($posFila-1));
$libro->setValor("F5","='Tipos de audiencia x unidad'!D".($posFila-1));
$libro->setValor("F6","='Tipos de audiencia x unidad'!E".($posFila-1));
$libro->setValor("F7","='Tipos de audiencia x unidad'!F".($posFila-1));
$libro->setValor("F8","='Tipos de audiencia x unidad'!G".($posFila-1));
$libro->setValor("F9","='Tipos de audiencia x unidad'!H".($posFila-1));
$libro->setValor("F10","='Tipos de audiencia x unidad'!I".($posFila-1));
$libro->setValor("F11","='Tipos de audiencia x unidad'!K".($posFila-1));
$libro->setValor("F12","='Tipos de audiencia x unidad'!J".($posFila-1));
$libro->setValor("F13","=sum(F3:F12)");

$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='001' AND fechaCreacion>='".$periodoInicial.
		"' AND fechaCreacion<='".$periodoFinal." 23:59:59'";

$nCarpetas=$con->obtenerValor($consulta);
$libro->setValor("B3",$nCarpetas);


$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='002' AND fechaCreacion>='".$periodoInicial.
		"' AND fechaCreacion<='".$periodoFinal." 23:59:59'";

$nCarpetas=$con->obtenerValor($consulta);
$libro->setValor("B4",$nCarpetas);

$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='003' AND fechaCreacion>='".$periodoInicial.
		"' AND fechaCreacion<='".$periodoFinal." 23:59:59'";

$nCarpetas=$con->obtenerValor($consulta);
$libro->setValor("B5",$nCarpetas);

$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='004' AND fechaCreacion>='".$periodoInicial.
		"' AND fechaCreacion<='".$periodoFinal." 23:59:59'";

$nCarpetas=$con->obtenerValor($consulta);
$libro->setValor("B6",$nCarpetas);

$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' AND fechaCreacion>='".$periodoInicial.
		"' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa not like 'TE/%'";

$nCarpetas=$con->obtenerValor($consulta);
$libro->setValor("B7",$nCarpetas);


$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='005' AND fechaCreacion>='".$periodoInicial.
		"' AND fechaCreacion<='".$periodoFinal." 23:59:59' and carpetaAdministrativa like 'TE/%'";

$nCarpetas=$con->obtenerValor($consulta);
$libro->setValor("B12",$nCarpetas);


$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='006' AND fechaCreacion>='".$periodoInicial.
		"' AND fechaCreacion<='".$periodoFinal." 23:59:59' ";

$nCarpetas=$con->obtenerValor($consulta);
$libro->setValor("B8",$nCarpetas);

$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='007' AND fechaCreacion>='".$periodoInicial.
		"' AND fechaCreacion<='".$periodoFinal." 23:59:59'";

$nCarpetas=$con->obtenerValor($consulta);
$libro->setValor("B9",$nCarpetas);

$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='008' AND fechaCreacion>='".$periodoInicial.
		"' AND fechaCreacion<='".$periodoFinal." 23:59:59'";

$nCarpetas=$con->obtenerValor($consulta);
$libro->setValor("B10",$nCarpetas);

$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE unidadGestion='009' AND fechaCreacion>='".$periodoInicial.
		"' AND fechaCreacion<='".$periodoFinal." 23:59:59'";

$nCarpetas=$con->obtenerValor($consulta);
$libro->setValor("B11",$nCarpetas);

$libro->setValor("B13","=sum(B3:B12)");

$consulta="SELECT COUNT(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='001'";
$nPromociones=$con->obtenerValor($consulta);
$libro->setValor("C3",$nPromociones);


$consulta="SELECT COUNT(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='002'";
$nPromociones=$con->obtenerValor($consulta);
$libro->setValor("C4",$nPromociones);


$consulta="SELECT COUNT(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='003'";
$nPromociones=$con->obtenerValor($consulta);
$libro->setValor("C5",$nPromociones);


$consulta="SELECT COUNT(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='004'";
$nPromociones=$con->obtenerValor($consulta);
$libro->setValor("C6",$nPromociones);

$consulta="SELECT COUNT(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='005' and c.carpetaAdministrativa not like 'TE/%'";
$nPromociones=$con->obtenerValor($consulta);
$libro->setValor("C7",$nPromociones);


$consulta="SELECT COUNT(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='005' and c.carpetaAdministrativa like 'TE/%'";
$nPromociones=$con->obtenerValor($consulta);
$libro->setValor("C12",$nPromociones);

$consulta="SELECT COUNT(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='006'";
$nPromociones=$con->obtenerValor($consulta);
$libro->setValor("C8",$nPromociones);


$consulta="SELECT COUNT(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='007'";
$nPromociones=$con->obtenerValor($consulta);
$libro->setValor("C9",$nPromociones);


$consulta="SELECT COUNT(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='008'";
$nPromociones=$con->obtenerValor($consulta);
$libro->setValor("C10",$nPromociones);

$consulta="SELECT COUNT(*) FROM  _96_tablaDinamica p, 7006_carpetasAdministrativas c WHERE p.fechaCreacion>='".$periodoInicial.
		"' AND p.fechaCreacion<='".$periodoFinal." 23:59:59' and p.carpetaAdministrativa=c.carpetaAdministrativa AND
		 p.idEstado>1 AND c.unidadGestion='009'";
$nPromociones=$con->obtenerValor($consulta);
$libro->setValor("C11",$nPromociones);
$libro->setValor("C13","=sum(C3:C12)");


$libro->generarArchivo("Excel2007","informe.xlsx");

?>