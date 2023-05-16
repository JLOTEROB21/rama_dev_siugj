<?php 
	include("conexionBD.php"); 
	$ide= $_POST["id"];
	$proceso=$_POST["_idProcesoint"];
	$nEtapa=$_POST["_numEtapaint"];
	$etapa= $_POST["_nombreEtapavch"];
	$desc= $_POST["_descripcionvch"];
	$idCategoria=$_POST["categoria"];
	$situacion=$_POST["estado"];
	$finalizaEstado=$_POST["finalizaEstado"];
	$nombreMenuMacro="";
	if(isset($_POST["_tituloMenuvch"]))
		$nombreMenuMacro=$_POST["_tituloMenuvch"];
	$configuracion=$_POST["configuracion"];
	$x=0;
	$consulta=array();
	$query="begin";
	if($con->ejecutarConsulta($query))
	{
		if($ide==-1)
		{
			$guardar="insert into 4037_etapas(idProceso,numEtapa,nombreEtapa,descripcion,idCategoria,nombreMenuMacro,marcaFinProceso)values('".
					$proceso."','".$nEtapa."','".cv($etapa)."','".cv($desc)."',".$idCategoria.",'".cv($nombreMenuMacro)."',".$finalizaEstado.")";
			$resultado=$con->ejecutarConsulta($guardar);
			$ietapa=$con->obtenerUltimoID();
		}
		else
		{
			
			$query="select * from 4037_etapas where idEtapa=".$ide;
			$filaEt=$con->obtenerPrimeraFila($query);
			$idProceso=$filaEt[1];
			$aEtapa=$filaEt[2];	
			$consulta[$x]="update 4037_etapas set situacion=".$situacion.",idProceso='".$proceso."',numEtapa='".$nEtapa."',nombreEtapa='".$etapa."',descripcion='".$desc."',idCategoria=".$idCategoria.",
							nombreMenuMacro='".cv($nombreMenuMacro)."',marcaFinProceso='".$finalizaEstado."' where idEtapa='".$ide."'";
			$x++;
			$ietapa=$ide;
			$consulta[$x]="delete from 4002_rolesVSEtapas where idEtapa='".$ide."'";
			$x++;
			if($nEtapa!=$aEtapa)
			{
				$consulta[$x]="update 234_proyectosVSComitesVSEtapas set numEtapa=".$nEtapa." where idProyecto=".$idProceso." and numEtapa=".$aEtapa;
				$x++;
				$consulta[$x]="update 4002_rolesVSEtapas set etapa=".$nEtapa." where etapa=".$aEtapa." and proceso=".$idProceso;
				$x++;
				/*$consulta[$x]="update 4038_etapasVSUsuarios set idEtapa=".$nEtapa." where idEtapa=".$aEtapa." and idProceso=".$idProceso;
				$x++;*/
				/*$consulta[$x]="update 518_camposEtapa set numEtapa=".$nEtapa." where numEtapa=".$aEtapa." and idProceso=".$idProceso;
				$x++;
				$consulta[$x]="update 521_bitacoraEtapasPOA set etapaActual=".$nEtapa." where etapaActual=".$aEtapa." and idProceso=".$idProceso;
				$x++;
				$consulta[$x]="update 521_bitacoraEtapasPOA set etapaAnterior=".$nEtapa." where etapaAnterior=".$aEtapa." and idProceso=".$idProceso;
				$x++;
				$consulta[$x]="update 521_modificacionesRegistrosPOA set situacion=".$nEtapa." where situacion=".$aEtapa." and idProceso=".$idProceso;
				$x++;
				$consulta[$x]="update 521_registrosPOA set situacion=".$nEtapa." where situacion=".$aEtapa." and idProceso=".$idProceso;
				$x++;
				$consulta[$x]="update 522_afectacionCuentasPOA set numEtapa=".$nEtapa." where numEtapa=".$aEtapa." and idProceso=".$idProceso;
				$x++;	
				$consulta[$x]="update 912_reportes set idEtapa=".$nEtapa." where idEtapa=".$aEtapa." and idProceso=".$idProceso;
				$x++;	
				*/			
				$consulta[$x]="update 900_formularios set idEtapa=".$nEtapa." where idEtapa=".$aEtapa." and idProceso=".$idProceso;
				$x++;		
				$consulta[$x]="update 911_disparadores set idEtapa=".$nEtapa." where idEtapa=".$aEtapa." and idFormulario in (select idFormulario from 900_formularios
								where idProceso=".$idProceso.")";
				$x++;	
				
				$consulta[$x]="update 941_bitacoraEtapasFormularios set etapaActual=".$nEtapa." where etapaActual=".$aEtapa." and idFormulario in (select idFormulario from 900_formularios
								where idProceso=".$idProceso.")";
				$x++;	
				$consulta[$x]="update 941_bitacoraEtapasFormularios set etapaAnterior=".$nEtapa." where etapaAnterior=".$aEtapa." and idFormulario in (select idFormulario from 900_formularios
								where idProceso=".$idProceso.")";
				$x++;	
				$consulta[$x]="update 944_actoresProcesoEtapa set numEtapa=".$nEtapa." where numEtapa=".$aEtapa." and idProceso=".$idProceso;
				$x++;		
				$consulta[$x]="update 995_proyectosVSParticipantesVSEtapas set numEtapa=".$nEtapa." where numEtapa=".$aEtapa." and idProyecto=".$idProceso;
				$x++;		
				
				$consulta[$x]="UPDATE 947_actoresProcesosEtapasVSAcciones SET complementario='".$nEtapa."' WHERE 
								idGrupoAccion=1 AND CAST(complementario AS DECIMAL(10,2))=".$aEtapa." AND idActorProcesoEtapa IN
								(SELECT idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE idProceso=".$idProceso.")";
				$x++;
				$idFormularioBase=obtenerFormularioBase($idProceso);
				$consulta[$x]="update  _".$idFormularioBase."_tablaDinamica set idEstado=".$nEtapa." where idEstado=".$aEtapa;
				$x++;		
				
			}
		}
		$tipoProc=obtenerTipoProceso($proceso);
		if($tipoProc<3)
		{
			$listadoRoles=$_POST["listadoRoles"];
			if($listadoRoles!="")
			{
				$arrRoles=explode(",",$listadoRoles);
				$size=sizeof($arrRoles);
					
				for($j=0; $j<$size; $j++)
				{
					$arrRol=explode('|',$arrRoles[$j]);
					$consulta[$x]="insert into 4002_rolesVSEtapas(idEtapa,idRol,permisos,etapa,proceso)values('".$ietapa."','".$arrRol[0]."','".$arrRol[1]."',".$nEtapa.",".$proceso.")";
					$x++;
				}
			}
			$consulta[$x]="call actualizarPermisosEtapa(".$ietapa.")";
			$x++;
	
		}
	
		$consulta[$x]="commit";
		$x++;
		$con->ejecutarBloque($consulta);
	}
?>
<head>
	
</head>


<body>
	<form method="post" action="<?php echo $_POST["pagRedireccion"] ?>" id="frmEnvio">
    	<input type="hidden" name="idProceso" value="<?php echo $proceso?>" />
        <input type="hidden" name="tabActivo" value="1">
        <input type="hidden" name="configuracion" value="<?php echo $configuracion?>">
    </form>
    <script>
    	document.getElementById('frmEnvio').submit();
    </script>
</body>
