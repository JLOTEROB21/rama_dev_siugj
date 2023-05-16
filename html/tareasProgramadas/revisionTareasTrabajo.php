<?php 	ini_set("memory_limit","3000M");
		set_time_limit(999000);
	session_start();
	include("conexionBD.php");
	include_once("sgjp/libreriaFunciones.php");
	include_once("sgjp/funcionesGeneradorasCarpetas.php");
	$idUsuarioOriginal=1;
	if(isset($_SESSION["idUsr"]))
		$idUsuarioOriginal=$_SESSION["idUsr"];

	$fechaInicio=null;
	$fechaFin=null;
	
	if(isset($_GET["fechaInicio"]))
		$fechaInicio=$_GET["fechaInicio"];
		
	if(isset($_GET["fechaFin"]))
		$fechaFin=$_GET["fechaFin"];

	
	$tipoTarea=2;
	$mE=0;
	if(isset($_GET["mE"]))
		$mE=$_GET["mE"];

	$idRegistroTarea=registrarBitacoraEjecucionActividadTemporal($tipoTarea);
	try
	{
		$_SESSION["idUsr"]=3789;
		$_SESSION["deshabilitarNotificaciones"]=true;
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
		
		$fechaReferencia=date("Y-m-d",strtotime("-1 days",strtotime(date("Y-m-d"))));
		
		$consulta="SELECT * FROM _46_tablaDinamica WHERE idEstado>1.4 AND fechaCreacion>='".$fechaReferencia." 00:01'
					AND (id__46_tablaDinamica NOT 
					IN(
					SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=46 AND fechaRegistroSistema>='".$fechaReferencia." 00:01'
					) or notificacionCorreo=0)
					
					
					
					";
		
		if($fechaInicio!=null)
		{
			$consulta="SELECT * FROM _46_tablaDinamica WHERE idEstado>1.4 AND fechaCreacion>='".$fechaInicio." 00:01'
					AND fechaCreacion<='".$fechaFin." 23:59:59' and (id__46_tablaDinamica NOT 
					IN(
					SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=46 AND fechaRegistroSistema>='".$fechaInicio." 00:01'
					 AND fechaRegistroSistema<='".$fechaFin." 23:59:59') or notificacionCorreo=0)";
		}
		
		$resIniciales=$con->obtenerFilas($consulta);	
		
		$consulta="SELECT * FROM _96_tablaDinamica WHERE idEstado>1.4 AND fechaHoraRecepcionPromocion>='".$fechaReferencia." 00:01'
					AND (id__96_tablaDinamica NOT 
					IN(SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=96 AND fechaRegistroSistema>='".$fechaReferencia." 00:01') or 
					notificacionCorreo=0)";
		if($fechaInicio!=null)
		{
			$consulta="SELECT * FROM _96_tablaDinamica WHERE idEstado>1.4 AND fechaHoraRecepcionPromocion>='".$fechaInicio." 00:01'
					AND fechaHoraRecepcionPromocion<='".$fechaFin." 23:59:59' and (id__96_tablaDinamica NOT 
					IN(SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=96 AND fechaRegistroSistema>='".$fechaInicio.
					" 00:01' and fechaRegistroSistema<='".$fechaFin." 23:59:59') or 
					notificacionCorreo=0)";
		}
		
		$resPromociones=$con->obtenerFilas($consulta);	
		
		
		$consulta="SELECT * FROM _92_tablaDinamica WHERE idEstado>1.4 AND fechaCreacion>='".$fechaReferencia." 00:01'
						AND (id__92_tablaDinamica NOT 
						IN(SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=92 AND fechaRegistroSistema>='".$fechaReferencia." 00:01'))";
		if($fechaInicio!=null)
		{
			$consulta="SELECT * FROM _92_tablaDinamica WHERE idEstado>1.4 AND fechaCreacion>='".$fechaInicio." 00:01'
					AND fechaCreacion<='".$fechaFin." 23:59:59' and (id__92_tablaDinamica NOT 
					IN(SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=92 AND fechaRegistroSistema>='".$fechaInicio.
					" 00:01' and fechaRegistroSistema<='".$fechaFin." 23:59:59') )";
		}
		$resExhortos=$con->obtenerFilas($consulta);	
		
		
		$consulta="SELECT * FROM _622_tablaDinamica WHERE idEstado>=2 AND fechaCreacion>='".$fechaReferencia." 00:01'
					AND (id__622_tablaDinamica NOT 
					IN(
					SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=622 AND fechaRegistroSistema>='".$fechaReferencia." 00:01'
					) or notificacionCorreo=0)
					
					
					
					";
		
		if($fechaInicio!=null)
		{
			$consulta="SELECT * FROM _622_tablaDinamica WHERE idEstado>=2 AND fechaCreacion>='".$fechaInicio." 00:01'
					AND fechaCreacion<='".$fechaFin." 23:59:59' and (id__622_tablaDinamica NOT 
					IN(
					SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=622 AND fechaRegistroSistema>='".$fechaInicio." 00:01'
					 AND fechaRegistroSistema<='".$fechaFin." 23:59:59') or notificacionCorreo=0)";
		}
		
		$resLAVLV=$con->obtenerFilas($consulta);	
		
		
		$consulta="SELECT idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaAsignacion>='".$fechaReferencia.
					" 00:01' AND notificadoPGJ IN (0,2) AND situacion=1";
		
		if($fechaInicio!=null)
		{
			$consulta="SELECT idFormulario,idRegistroSolicitud FROM 7000_eventosAudiencia WHERE fechaAsignacion>='".$fechaInicio." 00:01' 
					AND fechaAsignacion<='".$fechaFin." 23:59:59'  and notificadoPGJ IN (0,2) AND situacion=1";
			
		}
		
		$resEventoNotificadoPGJ=$con->obtenerFilas($consulta);
		
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
		
		while($fila=mysql_fetch_assoc($resExhortos))
		{
	
			$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
					VALUES(".$idRegistroTarea.",92,".$fila["id__92_tablaDinamica"].",0,".$tipoTarea.")";
			$con->ejecutarConsulta($consulta);
		}
		
		while($fila=mysql_fetch_assoc($resLAVLV))
		{
	
			$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
					VALUES(".$idRegistroTarea.",622,".$fila["id__622_tablaDinamica"].",0,".$tipoTarea.")";
			$con->ejecutarConsulta($consulta);
		}

		while($fila=mysql_fetch_assoc($resEventoNotificadoPGJ))
		{
	
			$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
					VALUES(".$idRegistroTarea.",7000,".$fila["idRegistroEvento"].",0,".$tipoTarea.")";
			$con->ejecutarConsulta($consulta);
		}	

		if(mysql_num_rows($resIniciales)>0)
			mysql_data_seek($resIniciales,0);
			
		if(mysql_num_rows($resPromociones)>0)
			mysql_data_seek($resPromociones,0);
		
		
		if(mysql_num_rows($resExhortos)>0)
				mysql_data_seek($resExhortos,0);
				
		if(mysql_num_rows($resLAVLV)>0)
				mysql_data_seek($resLAVLV,0);

		if(mysql_num_rows($resEventoNotificadoPGJ)>0)
				mysql_data_seek($resEventoNotificadoPGJ,0);
								
		while($fila=mysql_fetch_assoc($resIniciales))
		{
			cambiarEtapaFormulario(46,$fila["id__46_tablaDinamica"],$fila["idEstado"],"",-1,"NULL","NULL",1022);
			$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=46 AND iRegistro=".$fila["id__46_tablaDinamica"].
					" AND tipoTarea=".$tipoTarea;
			
			$con->ejecutarConsulta($consulta);			
		}
			
		
		while($fila=mysql_fetch_assoc($resPromociones))
		{
			cambiarEtapaFormulario(96,$fila["id__96_tablaDinamica"],$fila["idEstado"],"",-1,"NULL","NULL",613);
			$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=96 AND iRegistro=".$fila["id__96_tablaDinamica"].
					" AND tipoTarea=".$tipoTarea;
			$con->ejecutarConsulta($consulta);	
		}	
		
		while($fila=mysql_fetch_assoc($resExhortos))
		{
			cambiarEtapaFormulario(92,$fila["id__92_tablaDinamica"],$fila["idEstado"],"",-1,"NULL","NULL",717);
			$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=92 AND iRegistro=".$fila["id__92_tablaDinamica"].
					" AND tipoTarea=".$tipoTarea;
			$con->ejecutarConsulta($consulta);	
		}
		
		while($fila=mysql_fetch_assoc($resLAVLV))
		{
			cambiarEtapaFormulario(622,$fila["id__622_tablaDinamica"],$fila["idEstado"],"",-1,"NULL","NULL",1153);
			$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=622 AND iRegistro=".$fila["id__622_tablaDinamica"].
					" AND tipoTarea=".$tipoTarea;
			$con->ejecutarConsulta($consulta);	
		}
		
		while($fila=mysql_fetch_assoc($resEventoNotificadoPGJ))
		{
			if(reportarAudienciaPGJ($fila["idFormulario"],$fila["idRegistroSolicitud"]))
			{
				$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=7000 AND iRegistro=".$fila["idRegistroEvento"].
						" AND tipoTarea=".$tipoTarea;
				$con->ejecutarConsulta($consulta);	
			}
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
	$_SESSION["deshabilitarNotificaciones"]=false;
?>