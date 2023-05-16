<?php 	session_start();
		include("conexionBD.php"); 
		include("funcionesExportacion.php");
		$_nombrePerfilvch=$_POST["_nombrePerfilvch"];
		$_descripcionvch=$_POST["_descripcionvch"];
		$configuracion=$_POST["configuracion"];
		$idProceso=$_POST["idProceso"];
		$idPerfil=$_POST["idPerfil"];
		$pagRedireccion="";
		$x=0;
		$query="begin";
		$reenviar=false;
		if($con->ejecutarConsulta($query))
		{
			if($idPerfil=="-1")
			{
				$consulta[$x]="delete from 9008_perfilesExportacion where idPerfilExportacion=".$idPerfil;
				$x++;
				$consulta[$x]="delete from 9009_elementosPerfilesExportacion where idPerfilExportacion=".$idPerfil;
				$x++;
				$pagRedireccion="../modeloPerfiles/perfilExportacion.php";
				$query="insert into 9008_perfilesExportacion(nombrePerfil,descripcion,idProceso) values('".cv($_nombrePerfilvch)."','".cv($_descripcionvch)."',".$idProceso.")";
				if($con->ejecutarConsulta($query))
					$idPerfil=$con->obtenerUltimoID();
				else
					return;
				cambiarValorObjParametros($configuracion,"idPerfil",$idPerfil);
				if(!crearDTDBase($idProceso,$idPerfil,"-1",$consulta,$x))
					return;
				$reenviar=true;
			}
			else
			{
				$pagRedireccion="../modeloPerfiles/tblPerfilesExportacion.php";
				$consulta[$x]="update 9008_perfilesExportacion set nombrePerfil='".cv($_nombrePerfilvch)."',descripcion='".cv($_descripcionvch)."' where idPerfilExportacion=".$idPerfil;		
				$x++;
			}
			$consulta[$x]="commit";
			$x++;		
			if($con->ejecutarBloque($consulta))
				$reenviar=true;
		}
		
		function crearDTDBase($idProceso,$idPerfil,$idPadre,&$consulta,&$x,$orden=1)
		{
			global $con;
			$idFormulario=obtenerFormularioBase($idProceso);
			$query="select nombre,repetible from  4001_procesos where idProceso=".$idProceso;
			$filaProc=$con->obtenerPrimeraFila($query);
			$nProceso=ucwords(quitarAcentos($filaProc[0],true));
			if(($filaProc[1]==1)&&($idPadre!="-1"))
			{
				$query="insert into 9009_elementosPerfilesExportacion(idPerfilExportacion,idPadre,tagXML,idElementoFormulario,idFormulario,tipoElemento,
						orden,idProceso,tipoFormulario,tipoElementoPerfil,ambito)	
						values(".$idPerfil.",".$idPadre.",'grupo".$nProceso."',0,0,0,0,".$idProceso.",0,0,".$idFormulario.")";
				if($con->ejecutarConsulta($query))
					$idPadre=$con->obtenerUltimoID();
				else
					return false;
			}
			$query="insert into 9009_elementosPerfilesExportacion(idPerfilExportacion,idPadre,tagXML,idElementoFormulario,idFormulario,tipoElemento,
					orden,idProceso,tipoFormulario,tipoElementoPerfil,ambito) 
					values(".$idPerfil.",".$idPadre.",'registro".$nProceso."',0,0,0,0,".$idProceso.",0,0,".$idFormulario.")";
			if($con->ejecutarConsulta($query))
				$idPadre=$con->obtenerUltimoID();
			else
				return false;
			if(crearDTDFormulario($idFormulario,$idPadre,$idProceso,$idPerfil,$consulta,$x,$orden,true))
			{
				$orden++;
				$query="SELECT idFormulario FROM 203_elementosDTD WHERE idProceso=".$idProceso." ORDER BY orden";
				$resElemento=$con->obtenerFilas($query);
				while($filaElemento=mysql_fetch_row($resElemento))
				{
					if(!crearDTDFormulario($filaElemento[0],$idPadre,$idProceso,$idPerfil,$consulta,$x,$orden,false))
					{
						return false;	
					}
					$orden++;
				}
			}
			return true;
		}
		
		function crearDTDFormulario($idFormulario,$idPadre,$idProceso,$idPerfil,&$consulta,&$x,$orden,$formularioBase=false)
		{
			global $con;
			$query="select nombreFormulario,tipoFormulario,titulo,frmRepetible from 900_formularios where idFormulario=".$idFormulario;
			$fila=$con->obtenerPrimeraFila($query);
			switch($fila[1])
			{
				case 0:
					$nFormulario=ucwords(quitarAcentos($fila[0],true));
					if((!$formularioBase)&&($fila[3]=="1"))
					{
						$query="insert into 9009_elementosPerfilesExportacion(idPerfilExportacion,idPadre,tagXML,idElementoFormulario,idFormulario,
								tipoElemento,orden,idProceso,tipoFormulario,tipoElementoPerfil,ambito)
							values(".$idPerfil.",".$idPadre.",'grupo".$nFormulario."',0,".$idFormulario.",0,".$orden.",".$idProceso.",0,0,".$idFormulario.")";
						$orden=0;
						if($con->ejecutarConsulta($query))
							$idPadre=$con->obtenerUltimoID();
						else
							return false;	
					}
					$query="insert into 9009_elementosPerfilesExportacion(idPerfilExportacion,idPadre,tagXML,idElementoFormulario,idFormulario,
							tipoElemento,orden,idProceso,tipoFormulario,tipoElementoPerfil,ambito)
							values(".$idPerfil.",".$idPadre.",'registro".$nFormulario."',0,".$idFormulario.",0,".$orden.",".$idProceso.",0,0,".$idFormulario.")";
					if($con->ejecutarConsulta($query))
						$idPadre=$con->obtenerUltimoID();
					else
						return false;
					$query="SELECT nombreCampo,idElementoC,tipoElemento FROM 901_elementosFormulario WHERE tipoElemento>0 AND tipoElemento NOT IN (1,13,23)
								AND idFormulario=".$idFormulario;
					$resElemento=$con->obtenerFilas($query);
					$orden=0;
					while($filaElemento=mysql_fetch_row($resElemento))
					{
						$idElemento=$filaElemento[1];
						$nCampo=quitarAcentos($filaElemento[0]);
						$tElemento=$filaElemento[2];
						$tDato=obtenerTipoDatoElementoFormulario($tElemento);
						$comp="";
						switch($tDato)
						{
							case "date":
								$comp="d/m/Y";
							break;
							case "time":
								$comp="H:m";
							break;
						}
						
						$consulta[$x]="insert into 9009_elementosPerfilesExportacion(idPerfilExportacion,idPadre,tagXML,idElementoFormulario,
										idFormulario,tipoElemento,orden,campoRef,tipoElementoPerfil,tipoDato,ambito,complementario)
										values(".$idPerfil.",".$idPadre.",'".$nCampo."',".$idElemento.",".$idFormulario.",".$tElemento.",".$orden.
										",'".$filaElemento[0]."',0,'".$tDato."',".$idFormulario.",'".$comp."')";
						$x++;
						$orden++;				
					}
					return true;
				break;
				case 10:
					$query="select funcionDTDXML from 200_modulosPredefinidosProcesos where idGrupoModulo=".$fila[2];
					$funcExportacion=$con->obtenerValor($query);
					$res=false;
					if($funcExportacion!="")
					{
						$funcExportacion.='($idFormulario,$idPadre,$idProceso,$idPerfil,$consulta,$x,$orden);';
						//echo $funcExportacion."<br>";
						eval('$res='.$funcExportacion);
						$orden++;
					}
					return $res;
				break;
				case 20:
					$idProceso=$fila[2];
					return crearDTDBase($idProceso,$idPerfil,$idPadre,$consulta,$x,$orden);
					$orden++;
				break;
				default:
					return true;
			}
			
			
		}
		
		
?>
<html>
	<body>
    	<?php
			$arrParam[0][0]="configuracion";
			$arrParam[0][1]=$configuracion;
			if($reenviar)
				enviarPagina($pagRedireccion,$arrParam);
		?>
    </body>
</html>
