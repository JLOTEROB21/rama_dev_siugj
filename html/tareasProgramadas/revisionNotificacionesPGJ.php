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

	$tipoOficio="52,60,58,59";

	$tipoTarea=7;
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
		$consulta="SELECT f.fechaFirma,i.carpetaAdministrativa,d.nombreFormato,f.idRegistroFormato,idDocumento,d.categoriaDocumento FROM 
					7035_informacionDocumentos i,3000_formatosRegistrados f, _10_tablaDinamica d
					WHERE f.firmado=1 and f.fechaFirma>='".$fechaReferencia."' AND f.idFormulario=-2 
					AND f.idRegistro=i.idRegistro AND d.id__10_tablaDinamica=f.tipoFormato
					AND d.categoriaDocumento IN(".$tipoOficio.") and f.idRegistroFormato not
					in(SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=-5 AND fechaAsignacion>='".$fechaReferencia." 00:01'
					union
					SELECT iRegistro FROM 9060_tableroControl_5 WHERE iFormulario=-5 AND fechaAsignacion>='".$fechaReferencia." 00:01'
					)"; 
		

		if($fechaInicio!=null)
		{
			$consulta="SELECT f.fechaFirma,i.carpetaAdministrativa,d.nombreFormato,f.idRegistroFormato,idDocumento,d.categoriaDocumento FROM 
					7035_informacionDocumentos i,3000_formatosRegistrados f, _10_tablaDinamica d
					WHERE f.firmado=1 and f.fechaFirma>='".$fechaInicio."' AND f.fechaFirma<='".$fechaFin." 23:59:59' AND f.idFormulario=-2 
					AND f.idRegistro=i.idRegistro AND d.id__10_tablaDinamica=f.tipoFormato
					AND d.categoriaDocumento IN(".$tipoOficio.") and f.idRegistroFormato not
					in(SELECT iRegistro FROM 9060_tableroControl_4 WHERE iFormulario=-5 AND fechaAsignacion>='".$fechaInicio.
						" 00:01' and fechaAsignacion<='".$fechaFin." 23:59:59'
					union
						SELECT iRegistro FROM 9060_tableroControl_5 WHERE iFormulario=-5 AND fechaAsignacion>='".$fechaInicio.
						" 00:01' and fechaAsignacion<='".$fechaFin." 23:59:59'
					)"; 
		}
		
		$resIniciales=$con->obtenerFilas($consulta);	
	
		
		while($fila=mysql_fetch_assoc($resIniciales))
		{
			$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
					VALUES(".$idRegistroTarea.",-5,".$fila["idRegistroFormato"].",0,".$tipoTarea.")";
			$con->ejecutarConsulta($consulta);
			
		}
		

		if(mysql_num_rows($resIniciales)>0)
			mysql_data_seek($resIniciales,0);
			
		
						
		while($fila=mysql_fetch_assoc($resIniciales))
		{
			$consulta="SELECT idRegistro FROM 3000_bitacoraFormatos WHERE idRegistroFormato= ".$fila["idRegistroFormato"]." ORDER BY idRegistro DESC";
			$idBitacora=$con->obtenerValor($consulta);
			switch($fila["categoriaDocumento"])
			{
				case 52:
				case 60:
					notificarResponsableMedidasCautelares($idBitacora);
				break;
				case 58:
				case 59:
					notificarResponsableRespuestaMedidasCautelares($idBitacora);
				break;
				
			}
			$consulta="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=-5 AND iRegistro=".$fila["idRegistroFormato"].
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
		echo $e->getMessage();
		actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,2,$e->getMessage());
	}
	$_SESSION["idUsr"]=$idUsuarioOriginal;
	$_SESSION["deshabilitarNotificaciones"]=false;
?>