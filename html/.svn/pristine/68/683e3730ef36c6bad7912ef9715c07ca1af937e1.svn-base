<?php
	include_once("conexionBD.php");


function obtenerDatosReporte()
{
	global $con;
	
	$consulta1="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='20' AND temaProceso='48'";
	$res1=$con->obtenerValor($consulta1);

	$consulta2="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='1' AND temaProceso='31'";
	$res2=$con->obtenerValor($consulta2);

	$consulta3="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='1' AND temaProceso='30'";
	$res3=$con->obtenerValor($consulta3);

	$consulta4="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='1' AND temaProceso='36'";
	$res4=$con->obtenerValor($consulta4);

	$consulta5="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='1' AND temaProceso='46'";
	$res5=$con->obtenerValor($consulta5);

	$consulta6="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='4' AND temaProceso='34'";
	$res6=$con->obtenerValor($consulta6);

	$consulta7="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='4' AND temaProceso='38'";
	$res7=$con->obtenerValor($consulta7);

	$consulta8="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='4' AND temaProceso='39'";
	$res8=$con->obtenerValor($consulta8);

	$consulta9="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='4' AND temaProceso='40'";
	$res9=$con->obtenerValor($consulta9);

	$consulta10="SELECT COUNT(id__632_tablaDinamica) FROM _632_tablaDinamica WHERE tipoProceso='5' ";
	$res10=$con->obtenerValor($consulta10);
	
	$o='{"V20_48":"'.$res1.'","1_31":"'.$res2.'","1_30":"'.$res3.'","1_36":"'.$res4.'","1_46":"'.$res5.'","4_34":"'.$res6.'"."4_38":"'.$res7.'","4_39":"'.$res8.'","4_40":"'.$res9.'","5_0":"'.$res10.'"}';
	
	return $o;
}

function obtenerDatosReporte2()
{
	global $con;
	
	$arrDatos=array();
	
	$arreglo=array(1213,1214,1218,1206,1191,1184,1177,1182);
	$numero=count($arreglo);
	
	for($i=0; $i<$numero;$i++)
	{
		$consulta="SELECT COUNT(id__847_gridDerechoVulnerableRegistroTutela)FROM _847_gridDerechoVulnerableRegistroTutela 
					WHERE derechoVulnerableRegistroTutela='".$arreglo[$i]."'";
		$res=$con->obtenerValor($consulta);
		
		if(!isset($arrDatos[$arreglo[$i]]))
		{
			$arrDatos[$arreglo[$i]]=array();
			
			$obj["total"]=$res;
			array_push($arrDatos[$arreglo[$i]],$obj);
		}
	}
	
	return $arrDatos;
}


function obtenerDatosReporte3()
{
	global $con;
	
	$arrDatos=array();
	
	$arreglo=array(1213,1214,1218,1206,1191,1184,1177,1182);
	$numero=count($arreglo);
	
	for($i=0; $i<$numero;$i++)
	{
		$consulta="SELECT COUNT(id__847_gridDerechoVulnerableRegistroTutela)FROM _847_gridDerechoVulnerableRegistroTutela g,_847_tablaDinamica a,_699_tablaDinamica act
					WHERE g.idReferencia=a.id__847_tablaDinamica and derechoVulnerableRegistroTutela='".$arreglo[$i]."'
					and act.carpetaAdministrativaActuacionesIntervinientes=a.carpetaAdministrativa and act.tipoActuacion=22 and act.idEstado>1";
		$res=$con->obtenerValor($consulta);
		
		if(!isset($arrDatos[$arreglo[$i]]))
		{
			$arrDatos[$arreglo[$i]]=array();
			
			$obj["total"]=$res;
			array_push($arrDatos[$arreglo[$i]],$obj);
		}
	}
	
	return $arrDatos;
}




?>