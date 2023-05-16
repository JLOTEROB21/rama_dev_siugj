<?php 	include("conexionBD.php");
	ini_set("memory_limit","3000M");
	set_time_limit(999000);
	$idUsuarioOriginal=1;
	if(isset($_SESSION["idUsr"]))
		$idUsuarioOriginal=$_SESSION["idUsr"];
		
	$tipoTarea=1;
	$mE=0;
	if(isset($_GET["mE"]))
		$mE=$_GET["mE"];
	$idRegistroTarea=registrarBitacoraEjecucionActividadTemporal($tipoTarea);
	try
	{
		$_SESSION["idUsr"]=1;
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
	
		$consulta="SELECT * FROM _46_tablaDinamica WHERE idEstado=1.4 AND ctrlSolicitud IS NOT NULL AND ctrlSolicitud<>'' AND tipoAudiencia
					IN(
					SELECT id__4_tablaDinamica FROM _4_tablaDinamica WHERE tipoAtencion=2
					)";
		
		$resIniciales=$con->obtenerFilas($consulta);	
		
		$consulta="SELECT * FROM _96_tablaDinamica WHERE idEstado=1.4 AND ctrlSolicitud IS NOT NULL AND ctrlSolicitud<>'' AND tipoAudiencia
					IN(
					SELECT id__4_tablaDinamica FROM _4_tablaDinamica WHERE tipoAtencion=2
					)";
		
		$resPromociones=$con->obtenerFilas($consulta);	
		
		while($fila=mysql_fetch_assoc($resIniciales))
		{
			$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
					VALUES(".$idRegistroTarea.",46,".$fila["id__46_tablaDinamica"].",0,".$tipoTarea.")";
			$con->ejecutarConsulta($consulta);
			
		}
		while($fila=mysql_fetch_assoc($resPromociones))
		{
	
			$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
					VALUES(".$idRegistroTarea.",96,".$fila["id__96_tablaDinamica"].",0,".$tipoTarea.")";
			$con->ejecutarConsulta($consulta);
		}
		
		if(mysql_num_rows($resIniciales)>0)
			mysql_data_seek($resIniciales,0);
			
		if(mysql_num_rows($resPromociones)>0)
			mysql_data_seek($resPromociones,0);
		
		while($fila=mysql_fetch_assoc($resIniciales))
		{
			cambiarEtapaFormulario(46,$fila["id__46_tablaDinamica"],2.7,"",-1,"NULL","NULL",1022);
			$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=46 AND iRegistro=".$fila["id__46_tablaDinamica"].
					" AND tipoTarea=".$tipoTarea;
			
			$con->ejecutarConsulta($consulta);	
		}
		
		
		while($fila=mysql_fetch_assoc($resPromociones))
		{
			cambiarEtapaFormulario(96,$fila["id__96_tablaDinamica"],2,"",-1,"NULL","NULL",613);
			$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=96 AND iRegistro=".$fila["id__66_tablaDinamica"].
					" AND tipoTarea=".$tipoTarea;
			
			$con->ejecutarConsulta($consulta);	
		}
		
		actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,1,"");
		if($mE==1)
		{
			echo "<body><script>window.parent.cerrarVentanaFancy();</script></body>";
		}
	}
	catch(Exception $e)
	{
		if($mE==1)
		{
			echo $e->getMessage();
		}
		actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,2,$e->getMessage());
	}
	$_SESSION["idUsr"]=$idUsuarioOriginal;
?>