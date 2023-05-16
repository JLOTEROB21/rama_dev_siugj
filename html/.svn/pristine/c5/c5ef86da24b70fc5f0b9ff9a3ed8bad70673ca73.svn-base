<?php session_start();
	include("conexionBD.php"); 


$usr=-1;
$passwd=-1;
$llave=-1;



if(isset($_POST["usr"]))
	$usr=$_POST["usr"];

if(isset($_POST["pwd"]))
	$passwd=$_POST["pwd"];
	
if(isset($_POST["keyMap"]))	
	$llave=$_POST["keyMap"];

$p=array();
$p["L"]=$usr;
$p["P"]=$passwd;
$p["llave"]=$llave;



function buscarUsuarioSUAT($p)
{
	global $con;
	
	
	if($p["llave"]!="283fd981527237e53338d873f31f2fec")
	{
		return false;
	}
	
	$permitirLog=true;
	global $considerarAdscripcion;
	
	
	$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr from 800_usuarios u,
				801_adscripcion a where a.idUsuario=u.idUsuario and u.Login='".cv($p["L"])."' and u.Password='".cv($p["P"])."' 
				and cuentaActiva=1"; //and Status=1
	

	$fila=$con->obtenerPrimeraFila($consulta);
	
	if($fila)
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
		return true;
	}
	else
	{
		return false;
	}
	
}
	
	
if(buscarUsuarioSUAT($p))
{
	header('Location:../principalPortal/inicio.php');
}
else
{
	header('Location:../principalPortal/loginError.php');
}
	
?>