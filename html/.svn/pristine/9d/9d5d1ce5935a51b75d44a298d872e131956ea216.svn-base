<?php session_start();
	include("conexionBD.php"); 
	include_once("funcionesEnvioMensajes.php"); 
	
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
		case 1: //Autentificar Usuario
			buscarUsuario($parametros);
		break;
		case 2: //Autentificar Usuario
			buscarAlumno($parametros);
		break;
		case 3:
			buscarProveedor();
		break;
		case 4:
			buscarCliente();
		break;
		
	}
	
function buscarUsuario($p)
{
	global $con;
	$permitirLog=true;
	global $considerarAdscripcion;
	/*$fechaCorte=strtotime(date("Y-m-d"));
	$existeArchivo=file_exists("./log.txt");
	if(($fechaCorte>=strtotime("2011-01-31"))||(!$existeArchivo))
	{
		
		$permitirLog=false;
		if($existeArchivo)
			unlink("log.txt");
	}*/
	
	if(!$permitirLog)
	{
		echo "false";
		return;
	}
	
	//$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr from 800_usuarios u,801_adscripcion a where a.idUsuario=u.idUsuario and u.Login='".cv($p["L"])."' and u.Password='".cv($p["P"])."' and cuentaActiva=1"; //and Status=1
	$consulta="SELECT id,correo_electronico,UPPER(CONCAT(IF(paterno IS NULL,'',paterno),' ',IF(materno IS NULL,'',materno),' ',IF(nombre IS NULL,'',nombre))),'','',1,0  
				FROM alumno  WHERE correo_electronico='".cv($_POST["L"])."' AND matricula='".cv($_POST["P"])."'";
	
	$res=$con->obtenerFilas($consulta);
	$fila=mysql_fetch_row($res);
	if($fila!=false)
	{
		$conAdscripcion="SELECT codigoUnidad FROM 801_adscripcion WHERE idUsuario=".$fila[0];
		$adscripcion=$con->obtenerValor($conAdscripcion);
		
		$conRol="SELECT idRol FROM 807_usuariosVSRoles WHERE idUsuario=".$fila[0]." AND idRol=1";
		$idRol=$con->obtenerValor($conRol);

		
		$_SESSION["idUsr"]=$fila[0];
		$_SESSION["login"]=$fila[1];
		$_SESSION["nombreUsr"]=$fila[2];
		$_SESSION["statusCuenta"]=$fila[6];
		$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
		$resRoles=$con->obtenerFilas($consulta);
		$listaGrupo="";
		while($fRoles=mysql_fetch_row($resRoles))
		{
			$arrRol=explode("_",$fRoles[0]);
			$rol="'".$fRoles[0]."'";
			if($arrRol[1]!="0")
				$rol.=",'".$arrRol[0]."_-1'";
			
			if($listaGrupo=="")
				$listaGrupo=$rol;
			else
				$listaGrupo.=",".$rol;
		}
		if($listaGrupo=="")
			$listaGrupo='-1';
		$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
		$_SESSION["codigoUnidad"]=$fila[4];
		$_SESSION["codigoInstitucion"]=$fila[3];
		guardarBitacoraInicioSesion();

	}
	else
	{
		$_SESSION["idUsr"]="-1";
		$_SESSION["login"]="";
		$_SESSION["idRol"]="-1000";
		$_SESSION["status"]="-1";
		guardarBitacoraInicioSesionFallida(cv($_POST["L"]));
	}
	$resultado= json_encode($fila);
	echo $resultado;
}

function buscarAlumno()
{
	global $con;
	$nombre=$_POST["query"];
	$tipoCliente=$_POST["tipoCliente"];
	$consulta="";
	if($tipoCliente==2)
	
		$consulta="SELECT * FROM (SELECT id as idUsuario,CONCAT(IF(paterno IS NULL,'',paterno),' ',IF(materno IS NULL,'',materno),' ',IF(nombre IS NULL,'',nombre)) AS cliente FROM alumno) AS tmp WHERE cliente LIKE '%".$nombre."%' ORDER BY cliente";
	else
	{
		
		$consulta="SELECT idUsuario FROM 807_usuariosVSRoles WHERE idRol=47";
		$listUsuario=$con->obtenerListaValores($consulta);
		if($listUsuario=="")
			$listUsuario=-1;
		$consulta="select * from(SELECT idUsuario,CONCAT(IF(Paterno IS NULL,'',Paterno),' ',IF(Materno IS NULL,'',Materno),' ',IF(Nom IS NULL,'',Nom)) AS cliente FROM 802_identifica where idUsuario in (".$listUsuario.")) as tmp where cliente LIKE '%".$nombre."%' ORDER BY cliente";
	}

	$registros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"num":"'.$con->filasAfectadas.'","personas":'.$registros.'}';
	
	
}

function buscarProveedor()
{
	global $con;	
	$nombre=$_POST["query"];
	$consulta="select * from (SELECT e.idEmpresa AS idProveedor,CONCAT('[',rfc1,'-',rfc2,'-',rfc3,'] ',
				CONCAT(IF(apPaterno IS NULL,'',apPaterno),' ',IF(apMaterno IS NULL,'',apMaterno),' ',razonSocial)) AS nombreProveedor 
				FROM 6927_empresas e,6927_categoriaEmpresa c where c.idEmpresa=e.idEmpresa and c.idCategoria=2) as tmp where nombreProveedor like '%".$nombre."%' order by nombreProveedor";
				
	$registros=utf8_encode($con->obtenerFilasJSON($consulta));
	echo '{"num":"'.$con->filasAfectadas.'","registros":'.$registros.'}';
	
}


function buscarCliente()
{
	global $con;
	$nombre=$_POST["query"];
	$tipoCliente=$_POST["tipoCliente"];
	$consulta="SELECT idFuncionBusqueda FROM 6941_tiposCliente WHERE idTipoCliente=".$tipoCliente;
	$res["numReg"]=0;
	$res["registros"]="[]";
	
	$idFuncion=$con->obtenerValor($consulta);
	if(($idFuncion!="")&&($idFuncion!="-1"))
	{
		$oNull=NULL;
		$cadObj='{"tipoCliente":"'.$tipoCliente.'","valor":"'.$nombre.'"}';
		$objParam1=json_decode($cadObj);
		$res=resolverExpresionCalculoPHP($idFuncion,$objParam1,$oNull);	
	}
	echo '{"num":"'.$res["numReg"].'","personas":'.$res["registros"].'}';
}

?>