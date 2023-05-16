<?php	session_start();
	include("conexionBD.php");
	
	$marcaTiempo=date("Y-m-d H:i:S");
	$horaReferencia=date("Y-m-d",strtotime("-1 days",strtotime($marcaTiempo)))." 00:00:01";
	$_SESSION["idUsr"]=2390;
	$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"];
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
	$_SESSION["codigoUnidad"]="001";
	$_SESSION["codigoInstitucion"]="001";	
	
	
	
	$consulta=	"SELECT id__46_tablaDinamica,idEstado FROM _46_tablaDinamica WHERE fechaCreacion>='".$horaReferencia.
				"' AND idEstado in(2.7,2.5) AND id__46_tablaDinamica NOT IN 
				(
					SELECT iRegistro FROM 9060_tableroControl_4 WHERE fechaAsignacion>='".$horaReferencia."' AND iFormulario=46
				)";
				
	$res=$con->obtenerFilas($consulta);
	$total=$con->filasAfectadas;
	while($fila=mysql_fetch_row($res))
	{
		
		cambiarEtapaFormulario(46,$fila[0],$fila[1],"",-1,"NULL","NULL",264);
	}
		
?>