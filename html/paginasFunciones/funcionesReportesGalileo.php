<?php session_start();
	include("conexionBD.php"); 
	include("conexionBDGalileo.php");

	 
	
	$parametros="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
		if(isset($_POST["param"]))
		{
			$p=$_POST["param"];
			$parametros=json_decode($p,true);
			
		}
	}	
	
	switch($funcion)
	{
		case 1:
			obtenerEstadosSubsistema();
		break;
		case 2:
			obtenerPlatelesEstadosSubsistema();
		break;
		case 3:
			obtenerEstadoConexionPlanteles();
		break;
		case 4:
			registrarRegistroConexion();
		break;
	}
	
	function obtenerEstadosSubsistema()
	{
		global $con;
		global $conGalileo;
		$codigo=$_POST["codigo"];
		$consulta="SELECT DISTINCT edo FROM sedes WHERE proyecto='".$codigo."'";
		$listEdo=$conGalileo->obtenerListaValores($consulta);
		if($listEdo=="")
			$listEdo=-1;
			
		$consulta="select CVE_ENT,NOMBRE from geos_oid_c1 where CVE_ENT in (".$listEdo.")";
		$arrPlanteles=$conGalileo->obtenerFilasArreglo($consulta);
		echo "1|".$arrPlanteles;
	}
	
	function obtenerPlatelesEstadosSubsistema()
	{
		global $con;
		$conGalileo=generarInstanciaConector(8);
		$codigo=$_POST["codigo"];
		$listaEstados=$_POST["listEstados"];
		$listCursos="42,43,44";
		$consulta="SELECT CCT,nombre FROM sedes WHERE proyecto='".$codigo."' AND edo IN (".$listaEstados.")";
		$resPlantel=$conGalileo->obtenerFilas($consulta);
		$listEdo="";
		while($fila=mysql_fetch_row($resPlantel))
		{
			$consulta="	SELECT count(*) from mdl_groups g,mdl_groups_members m,mdl_user u WHERE u.institution='".$fila[0]."' and g.id=m.groupid and m.userid =u.id  AND 
						courseid IN (".$listCursos.") ORDER BY courseid";

			$nGrupos=$conGalileo->obtenerValor($consulta);
			if($nGrupos>0)
			{
				if($listEdo=="")
					$listEdo='["'.$fila[0].'","'.$fila[1].'"]';
				else
					$listEdo.=',["'.$fila[0].'","'.$fila[1].'"]';
			}
		}
		
		echo "1|[".$listEdo."]";			
			
	}
	
	function obtenerEstadoConexionPlanteles()
	{
		global $con;
		global $conGalileo;
		$subsistema=$_POST["subsistema"];
		$fechaSesion=$_POST["fechaSesion"];
		$horario=$_POST["horario"];
		$idCurso=$_POST["idCurso"];
		
		$datosHorario=explode("_",$horario);
		$res=NULL;
		$consulta="";
		switch($subsistema)
		{
			case "0002":
				$centroCosto="'0008','0009','0011','0014','0019','0022','0023','0028','0029'";
				if($subsistema=="0007")
					$centroCosto="0030";
				$consulta="select distinct codigoDepto from 817_organigrama where status=1 and 
							codigoUnidad like '".$subsistema."%' and codCentroCosto in (".$centroCosto.")";
				$res=$con->obtenerFilas($consulta);							
			break;
			default:
				$consulta="select codigoDepto from 817_organigrama where status=1 and codigoUnidad like '".$subsistema."%'";
				$listCct=$con->obtenerListaValores($consulta,"'");
				if($listCct=="")
					$listCct=-1;
				$consulta="SELECT cveCurso FROM _246_tablaDinamica WHERE id__246_tablaDinamica=".$idCurso;
				
				$listCursos=$con->obtenerListaValores($consulta);
				if($listCursos=="")
					$listCursos=-1;
				$consulta="SELECT DISTINCT u.institution FROM inscritosxsede i,mdl_user u WHERE u.id=i.iduser and u.institution IN(".$listCct.") and idgrupo in (".$datosHorario[1].") and curso in(".$listCursos.")";	

				$res=$conGalileo->obtenerFilas($consulta);
				//$res=$conGalileo->obtenerFilas($consulta);
			break;
							
		}
		
		
		$cadObj="";
		$ct=0;
		while($fila=mysql_fetch_row($res))
		{
			$conectado="false";
			$consulta="select distinct codigoUnidad,unidad from 817_organigrama where codigoDepto='".$fila[0]."'";
			$f=$con->obtenerPrimeraFila($consulta);
			if($f)
			{
				$consulta="SELECT COUNT(*) FROM 0_registroConexionSesion WHERE fechaConexion='".$fechaSesion."' AND  horario='".$datosHorario[0]."' AND plantel='".$f[0]."' and idCurso=".$idCurso;
				$nRegistros=$con->obtenerValor($consulta);
				if($nRegistros>0)
					$conectado="true";
				$obj='{"codigoUnidad":"'.$f[0].'","plantel":"'.$f[1].'","conectado":'.$conectado.'}';
				if($cadObj=="")
					$cadObj=$obj;
				else
					$cadObj.=",".$obj;
				$ct++;
			}
		}
		echo '{"numReg":"'.($ct).'","registros":['.$cadObj.']}';
	}
	
	function registrarRegistroConexion()
	{
		global $con;
		$idCurso=$_POST["idCurso"];
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$dGrupos=explode("_",$obj->horario);
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 0_registroConexionSesion where fechaConexion='".$obj->fecha."' and horario='".$dGrupos[0]."' and subsistema='".$obj->subsistema."' and idCurso=".$idCurso;

		$x++;

		foreach($obj->arrPlanteles as $p)
		{
			$consulta[$x]="INSERT INTO 0_registroConexionSesion(fechaConexion,idListGrupos,horario,plantel,subsistema,idCurso) 
						VALUES('".$obj->fecha."','".$dGrupos[1]."','".$dGrupos[0]."','".$p->codigoUnidad."','".$obj->subsistema."',".$idCurso.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
?>	