<?php 	include("conexionBD.php");
	ini_set("memory_limit","3000M");
	set_time_limit(999000);
	$idUsuarioOriginal=1;
	if(isset($_SESSION["idUsr"]))
		$idUsuarioOriginal=$_SESSION["idUsr"];
	$fechaActual=date("Y-m-d H:i:s");
	$tipoTarea=4;
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
		if(esDiaHabilInstitucion($fechaActual))
		{
			$consulta="SELECT * FROM 7021_carpetasAsignadasGuardia WHERE situacion=1";
			
			$resIniciales=$con->obtenerFilas($consulta);	
			
			while($fila=mysql_fetch_assoc($resIniciales))
			{
				$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea) 
						VALUES(".$idRegistroTarea.",7021,".$fila["idRegistro"].",0,".$tipoTarea.")";
				$con->ejecutarConsulta($consulta);
				
			}
			
			if(mysql_num_rows($resIniciales)>0)
				mysql_data_seek($resIniciales,0);
				
			
			while($fila=mysql_fetch_assoc($resIniciales))
			{
				$x=0;
				$query=array();
				$query[$x]="begin";
				$x++;
				$query[$x]="UPDATE 7006_carpetasAdministrativas SET unidadGestion='".$fila["unidadGestionOrigen"].
						"' WHERE carpetaAdministrativa='".$fila["carpetaAdministrativa"]."'";
				$x++;
				$query[$x]="UPDATE 7021_carpetasAsignadasGuardia SET situacion=2 WHERE idRegistro=".$fila["idRegistro"];
				$x++;
				$query[$x]="UPDATE 9076_registrosAsociados SET situacion=1 WHERE iFormulario=7021 AND iRegistro=".$fila["idRegistro"].
							" AND tipoTarea=".$tipoTarea;
				$x++;
				$query[$x]="commit";
				$x++;
				$con->ejecutarBloque($query);	
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
?>