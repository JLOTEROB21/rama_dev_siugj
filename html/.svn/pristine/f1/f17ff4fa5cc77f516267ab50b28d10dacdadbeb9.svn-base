<?php session_start();
	$_SESSION["debuggerConsulta"]=0;
	include("conexionBD.php");
	include_once("funcionesFormularios.php");
	include("funcionesGuardarDatos.php");
	

	
	if(!isset($_SESSION["fechaUltimaOperacion"]) || ($_SESSION["fechaUltimaOperacion"]==""))
		$_SESSION["fechaUltimaOperacion"]=date("Y-m-d H:i:s");
	
	$pagRedireccion="";	
	$id="";
	
	$consulta=array();
	$numConsulta=0;
	$consulta[$numConsulta]="begin";
	$numConsulta++;
	
	$query="begin";
	$nQuery=0;
	$idPadre;
	$procedimientos="";
	$procNuevos="";
	$procModif="";
	$imagenesGaleria="";
	$funcPHPEjecutarNuevo="";
	$funcPHPEjecutarModif="";
	$idPerfil=-1;
	$soloContenido=0;
	
	
	$arrFuncionesEjecutar=array();
	$reenviar=true;
	$reenviarGlobal=true;
	
	if($con->ejecutarConsulta($query))
	{
		
		generarConsulta();
		
		if($procedimientos!="")
		{
			$arrProcedimientos=explode("|",$procedimientos);
			$z=sizeof($arrProcedimientos);
			for($x=0;$x<$z;$x++)
			{
				$consultaAux[$nQuery]="call ".$arrProcedimientos[$x];
				
				$nQuery++;
			}
		}
		if($procNuevos!="")
		{
			$arrProcedimientos=explode("|",$procNuevos);
			$z=sizeof($arrProcedimientos);
			for($x=0;$x<$z;$x++)
			{
				$consultaAux[$nQuery]="call ".$arrProcedimientos[$x];
				$nQuery++;
			}
		}
		if($procModif!="")
		{
			$arrProcedimientos=explode("|",$procModif);
			$z=sizeof($arrProcedimientos);
			for($x=0;$x<$z;$x++)
			{
				$consultaAux[$nQuery]="call ".$arrProcedimientos[$x];
				
				$nQuery++;
			}
		}
		
		
		if(($funcPHPEjecutarNuevo!="")&&($id=="-1"))
		{
			$arrFunciones=explode("|",$funcPHPEjecutarNuevo);
			foreach($arrFunciones as $funcion)
			{
				array_push($arrFuncionesEjecutar,$funcion);
			}
			
		}
		
		if(($funcPHPEjecutarModif!="")&&($id!="-1"))
		{
			$arrFunciones=explode("|",$funcPHPEjecutarModif);
			foreach($arrFunciones as $funcion)
			{
				array_push($arrFuncionesEjecutar,$funcion);
			}
		}
		
		if(isset($_POST["idFormularioDinamico"]))
		{
			$idFormulario=$_POST["idFormularioDinamico"];
			$myQuery="select tipoFormulario,idProceso,idFrmEntidad,configuracionFormulario  from 900_formularios where idFormulario=".$idFormulario;
			$filaProceso=$con->obtenerPrimeraFila($myQuery);
			$tipoFormulario=$filaProceso[0];
			$idProceso=$filaProceso[1];
			$idFrmEntidad=$filaProceso[2];
			$idReferencia="-1";
			$configuracionFormulario=$filaProceso[3];
			if(isset($_POST["_idReferenciaint"]))
				$idReferencia=$_POST["_idReferenciaint"];
			$nVersion=0;
			if(($idReferencia!="-1")&&($idReferencia!=""))
			{
				
				if($idFrmEntidad!="-1")
				{
					$nTabla=obtenerNombreTabla($idFrmEntidad);
					
					$myQuery="select idEstado from ".$nTabla." where id_".$nTabla."=".$idReferencia;
					$etapaReg=$con->obtenerValor($myQuery);
					if($etapaReg=="")
						$etapaReg=0;
					$myQuery="SELECT COUNT(etapaActual)-1 AS versionRegistro FROM 941_bitacoraEtapasFormularios WHERE etapaActual=".$etapaReg." AND idFormulario=".$idFrmEntidad." AND idRegistro=".$idReferencia;

					$nVersion=$con->obtenerValor($myQuery);
					if($nVersion<0)
						$nVersion=0;	
				}
			}
			
			switch($tipoFormulario)
			{
				case 13: //Dictamen parcial
					$myQuery="select idActor from 948_actoresVSFormulariosDictamen where idFormulario=".$idFormulario;
					$idActor=$con->obtenerValor($myQuery);
					$myQuery="select actor,tipoActor from 944_actoresProcesoEtapa where idActorProcesoEtapa=".$idActor;
					$filaActor=$con->obtenerPrimeraFila($myQuery);
					$actor=$filaActor[0];
					$tipoActor=$filaActor[1];
					if($tipoActor==2)
					{
						$myQuery="select idFormulario from 245_proyectosComitesElementosDTD ed,203_elementosDTD d where d.idElementoDTD=ed.idElemento  and idProyectoComite=".$actor;
						$arrFrm=$con->obtenerListaValores($myQuery);
						if($arrFrm=="")
							$arrFrm="-1";
					}
					else
					{
						$myQuery="select idFormulario from 203_elementosDTD where idProceso=".$idProceso;
						
						$arrFrm=$con->obtenerListaValores($myQuery);
						if($arrFrm=="")
							$arrFrm="-1";
						$arrFrm.=','.$idFrmEntidad;
					}
					
					$myQuery="select idGrupoElemento,idAccion,idValor from 954_accionesDictamenParcial where idFormulario=".$idFormulario;
					
					$resOpc=$con->obtenerFilas($myQuery);
					$arrOpciones=Array();
					$idGrupoE="";
					while($filaOpt=mysql_fetch_row($resOpc))
					{
						$idGrupoE=$filaOpt[0];
						$arrOpciones["".$filaOpt[2].""]=$filaOpt[1];	
					}
					$myQuery="select nombreCampo from 901_elementosFormulario where idGrupoElemento=".$idGrupoE;
					
					$nombreCampoD="_".$con->obtenerValor($myQuery)."vch";
					
					$valorCampoD=$_POST[$nombreCampoD];
					$accionEjecutar=$arrOpciones[$valorCampoD];
					if($accionEjecutar=="2")
					{
						$arregloFrm=explode(",",$arrFrm);
						$nFormulario=sizeof($arregloFrm);
						for($nCt=0;$nCt<$nFormulario;$nCt++)
						{
							$consultaAux[$nQuery]="insert into 963_estadosElementoDTD(idFormulario,idReferencia,estado) values(".$arregloFrm[$nCt].",".$idReferencia.",1)";
							$nQuery++;
						}
					}
					
					$consultaAux[$nQuery]="insert into 964_registroDictamenes(idFormulario,idRegistro,idReferencia,idActor,fechaDictamen,tipoDictamen,versionRegistro)
											values(".$idFormulario.",idRegPadre,".$idReferencia.",".$idActor.",'".date('Y-m-d')."','P',".$nVersion.")";
					$nQuery++;
					$consultaAux[$nQuery]="update 955_revisoresProceso set estado=3 where versionRegistro=".$nVersion." and idActorProcesoEtapa=".$idActor." and idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
					$nQuery++;
					if($configuracionFormulario!="")
					{
						$nomActor=obtenerNombreActor($idActor);
						$objParam='{"version":"'.$nVersion.'","idFormulario":"'.$idFrmEntidad.'","idRegistro":"'.$idReferencia.'","actor":"'.$nomActor.'","idActor":"'.$idActor.'"}';
						array_push($arrFuncionesEjecutar,'resolverConfiguracion('.$idFormulario.',idRegPadre,"'.cv($objParam).'","'.cv($configuracionFormulario).'");');
						
					}
					
					

				break;
				case 14: //Dictamen final
					$myQuery="select idActor from 948_actoresVSFormulariosDictamen where idFormulario=".$idFormulario;
					$idActor=$con->obtenerValor($myQuery);
					
					$myQuery="select idGrupoElemento,idEtapa,idValor from 911_disparadores where idFormulario=".$idFormulario;
					$resOpc=$con->obtenerFilas($myQuery);
					$arrOpciones=Array();
					$idGrupoE="";
					while($filaOpt=mysql_fetch_row($resOpc))
					{
						$idGrupoE=$filaOpt[0];
						$arrOpciones["".$filaOpt[2].""]=$filaOpt[1];	
					}
					
					$myQuery="select nombreCampo from 901_elementosFormulario where idGrupoElemento=".$idGrupoE;
					
					$nombreCampoD="_".$con->obtenerValor($myQuery)."vch";
					
					$valorCampoD=$_POST[$nombreCampoD];
					$numEtapa=$arrOpciones[$valorCampoD];
					
					$valorCampoComentario="";
					$myQuery="SELECT configuracionFormulario FROM 900_formularios WHERE idFormulario=".$idFormulario;
					$configuracionFormulario=$con->obtenerValor($myQuery);
					
					if($configuracionFormulario!="")
					{
						$oConfiguracion=json_decode($configuracionFormulario);
						$campoComentario=$oConfiguracion->campoComentario;
						
						$myQuery="select nombreCampo,tipoElemento from 901_elementosFormulario where idGrupoElemento=".$campoComentario;
						$fComentarios=$con->obtenerPrimeraFila($myQuery);
						$comentarioEvaluacion="_".$fComentarios[0].(($fComentarios[1]==9)?"mem":"vch");
						
						$valorCampoComentario=$_POST[$comentarioEvaluacion];
						
						
					}
					
					
					$funcionE="cambiarEtapaFormulario(".$idFrmEntidad.",".$idReferencia.",".$numEtapa.",'".cv($valorCampoComentario)."',".$idPerfil.",'NULL','NULL',".$idActor.");";

					array_push($arrFuncionesEjecutar,$funcionE);
					
					$consultaAux[$nQuery]="insert into 964_registroDictamenes(idFormulario,idRegistro,idReferencia,idActor,fechaDictamen,tipoDictamen,versionRegistro)
											values(".$idFormulario.",idRegPadre,".$idReferencia.",".$idActor.",'".date('Y-m-d')."','F',".$nVersion.")";
					$nQuery++;
					$consultaAux[$nQuery]="update 955_revisoresProceso set estado=3 where versionRegistro=".$nVersion." and idActorProcesoEtapa=".$idActor." and idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
					$nQuery++;
					if($configuracionFormulario!="")
					{
						$nomActor=obtenerNombreActor($idActor);
						$objParam='{"version":"'.$nVersion.'","idFormulario":"'.$idFrmEntidad.'","idRegistro":"'.$idReferencia.'","actor":"'.$nomActor.'","idActor":"'.$idActor.'"}';
						array_push($arrFuncionesEjecutar,'resolverConfiguracion('.$idFormulario.',idRegPadre,"'.cv($objParam).'","'.cv($configuracionFormulario).'");');
						
					}
				break;
				case 15: //Dictamen revisor
					$myQuery="select idActor from 948_actoresVSFormulariosDictamen where idFormulario=".$idFormulario;
					
					$idActor=$con->obtenerValor($myQuery);
					/*$idReferenciaEval="-1";
					if(isset($_POST["idReferenciaEval"]))
						$idReferenciaEval=$_POST["idReferenciaEval"];*/
					$consultaAux[$nQuery]="update 955_revisoresProceso set idFormDictamen=idRegPadre,estado=2,fechaDictamen='".date('Y-m-d')."' where idReferencia=".$idReferencia." and versionRegistro=".$nVersion." and idUsuarioRevisor=".$_SESSION["idUsr"]." and idActorProcesoEtapa=".$idActor;
					
					
					$nQuery++;
					if($configuracionFormulario!="")
					{
						$nomActor="Revisor (".obtenerNombreActor($idActor).")";
						$objParam='{"version":"'.$nVersion.'","idFormulario":"'.$idFrmEntidad.'","idRegistro":"'.$idReferencia.'","actor":"'.$nomActor.'","idActor":"-'.$idActor.'"}';
						array_push($arrFuncionesEjecutar,'resolverConfiguracion('.$idFormulario.',idRegPadre,"'.cv($objParam).'","'.cv($configuracionFormulario).'");');
						
					}
				break;
				default:
					if(($id=="-1")&&(esFormularioBase($idFormulario)))
					{
						$idFrmModulo=incluyeModulo($idProceso,3);
						
						if($idFrmModulo!="-1")
						{
							$queryAutores="select complementario  from 203_elementosDTD where idFormulario=".$idFrmModulo;
							$complementario=$con->obtenerValor($queryAutores);
							$arrConf=explode(",",$complementario);
							$consultaAux[$nQuery]="insert into 246_autoresVSProyecto(idUsuario,idFormulario,idReferencia,orden,claveParticipacion,responsable) values
													(".$_SESSION["idUsr"].",".$idFormulario.",idRegPadre,1,'".$arrConf[1]."',1)";
							
							$nQuery++;
						
						}
					}
				break;
			}
			
			if(isset($_POST["objCamposGrid"])&&($_POST["objCamposGrid"]!=""))
			{

				$objCamposGrid=json_decode(bD($_POST["objCamposGrid"]));
				generarCadenasCamposGrid($objCamposGrid,$consultaAux,$nQuery);
			}
		}
		
		if($nQuery==0)
			$consulta[$numConsulta]="commit";
		else
		{
			$consultaAux[$nQuery]="commit";
			$nQuery++;
		}
		
		
		
		if($con->ejecutarBloque($consulta))
		{
			if(isset($_POST["valorPost"]))
			{
				if($id=='-1')
				{
					$queryAux="select @idRegistroFormulario";
					$idPadre=$con->obtenerValor($queryAux);
				}
				$id=$_POST["valorPost"];
				
				if(isset($_POST["reemplazarIDSesion"]))
				{
					$numConfiguracion=$_POST["reemplazarIDSesion"];
					$cadSesion=$_SESSION["configuracionesPag"][$numConfiguracion]["parametros"];
					
					if(isset($_POST["sentenciaReemplazo"]))
						$cadenaBase=$_POST["sentenciaReemplazo"];
					else
						$cadenaBase='"idRegistro":"-1"';
					
					$valorIdRegistro=$idPadre;
					if(isset($_POST["valorReemplazo"]))
					{
						$valorReemplazo=str_replace("idRegPadre",$valorIdRegistro,$_POST["valorReemplazo"]);
					}
					else
						$valorReemplazo='"idRegistro":"'.$idPadre.'"';
					$cadSesion=str_replace($cadenaBase,$valorReemplazo,$cadSesion);
					$_SESSION["configuracionesPag"][$numConfiguracion]["parametros"]=$cadSesion;
					$id=$_POST["reemplazarIDSesion"];
				}
			}
			else
			{
				
				if($id=='-1')
				{
					$queryAux="select @idRegistroFormulario";
					$id=$con->obtenerValor($queryAux);
					
					$idPadre=$id;
					
				}
				
			}
			

			
			if($nQuery!=0)
			{
				for($x=0;$x<$nQuery;$x++)
				{
					$cadAux=$consultaAux[$x];
					$cadAux=str_replace('idRegPadre',$idPadre,$cadAux);
					$consultaAux[$x]=$cadAux;
				}
				if($reenviarGlobal)
				{
					
					if(!($con->ejecutarBloque($consultaAux)))
					{
						
						$reenviar=false;
						return;
					}
					
				}
			}
			
			if((!isset($_POST["post"]))&&(!isset($_POST["paramPost"])))
			{
				/*header("location:".$pagRedireccion);
				return;*/
			}
			

		}
		else
		{
			$reenviar=false;
			return;
		}
	}
	else
		return;
		
	function generarConsulta()
	{
		global $con;
		global $pagRedireccion;
		global $id;
		global $idPadre;
		global $numConsulta;
		global $consulta;
		global $procedimientos;
		global $procNuevos;
		global $procModif;
		global $funcPHPEjecutarNuevo;
		global $funcPHPEjecutarModif;
		global $reenviarGlobal;
		global $arrFuncionesEjecutar;
		global $imagenesGaleria;
		global $idPerfil;
		global $soloContenido;
		global $fechaOperacion;
		
		

		$idFormularioDinamico=isset($_POST["idFormularioDinamico"])?$_POST["idFormularioDinamico"]:0;
		
		
		$parametros=array_keys($_POST);

		$valores=array_values($_POST);
		
		$ct=sizeof($parametros);
		$campos="";
		$valoresCampos="";
		$tabla="";
		$id="";
		$campoId="";
		for($x=0;$x<$ct;$x++)
		{
			if($parametros[$x]=="tabla")
				$tabla=$valores[$x];
			else
				if($parametros[$x]=="id")
					$id=$valores[$x];	
				else
					if($parametros[$x]=="campoId")
						$campoId=$valores[$x];
					else
						if($parametros[$x]=="pagRedireccion")
							$pagRedireccion=$valores[$x];
						else
							if($parametros[$x]=="ejecutarProcedimiento")
								$procedimientos=$valores[$x];
							else
								if($parametros[$x]=="funcEjecutarNuevo")
									$procNuevos=$valores[$x];
								else
									if($parametros[$x]=="funcEjecutarModif")
										$procModif=$valores[$x];
									else
										if($parametros[$x]=="funcPHPEjecutarNuevo")
											$funcPHPEjecutarNuevo=base64_decode($valores[$x]);
										else
											if($parametros[$x]=="funcPHPEjecutarModif")
												$funcPHPEjecutarModif=base64_decode($valores[$x]);
											else
												if($parametros[$x]=="arrImagenesGaleria")
													$imagenesGaleria=base64_decode($valores[$x]);
												else
													if($parametros[$x]=="idPerfil")
														$idPerfil=$valores[$x];
													else
														if($parametros[$x]=="soloContenido")
															$soloContenido=$valores[$x];
						
		
			
		}
		$arrCampos=array();
		$arrCampos["fechaCreacion"]=$_SESSION["fechaUltimaOperacion"];
		$arrCampos["responsable"]=$_SESSION["idUsr"];
		
		if(($id=="")||($id=="-1"))//insertar
		{
			for($x=0;$x<$ct;$x++)
			{
				
				if(($parametros[$x]!="tabla")&&($parametros[$x]!="id")&&($parametros[$x]!="campoId")&&($parametros[$x][0]=='_')&&($parametros[$x]!="pagRedireccion"))
				{
					if($campos=="")
					{
						$field="`".nomCampo($parametros[$x])."`";
						
						
						$value=codCampo($parametros[$x],$valores[$x]);
						$arrCampos[str_replace("`","",$field)]=str_replace("'","",$value);
						if($value!='_NULL100584_')
						{
							$campos=$field;
							$valoresCampos=$value;
						}
					}
					else
					{
						$field="`".nomCampo($parametros[$x])."`";
						$value=codCampo($parametros[$x],$valores[$x]);
						$arrCampos[str_replace("`","",$field)]=str_replace("'","",$value);
						if($value!='_NULL100584_')
						{
							$campos.=",".$field;
							$valoresCampos.=",".$value;
						}
					}
				}			
			}
			
			$idProcesoBase=$idFormularioDinamico!=0?obtenerIdProcesoFormularioBase($idFormularioDinamico):-1;
			
			$llaveHash="";
			$queryAux="SELECT * FROM 00016_camposHashProceso WHERE idProceso=".$idProcesoBase;
			$resAux=$con->obtenerFilas($queryAux);
			while($fAux=mysql_fetch_assoc($resAux))
			{
				$token=$arrCampos[$fAux["campoTablaDestino"]];
				if($llaveHash=="")
					$llaveHash=$token;
				else
					$llaveHash.="_".$token;
			}
			
			if($llaveHash!="")
				$llaveHash=hash("sha512",$llaveHash);
			
			
			
			
			$queryAux="SELECT hashDiferenciaTiempo FROM 4001_procesos WHERE idProceso=".$idProcesoBase;
			$hashDiferenciaTiempo=$con->obtenerValor($queryAux);
			if($hashDiferenciaTiempo=="")
				$hashDiferenciaTiempo=0;
			
			$fechaHash=date("Y-m-d H:i:s",strtotime("-".$hashDiferenciaTiempo." minutes",strtotime($_SESSION["fechaUltimaOperacion"])));
			$queryAux="SELECT idRegistro FROM 00017_hashRegistrosProcesos WHERE hashRegistro='".$llaveHash."' AND fechaRegistro>='".$fechaHash."' AND idFormulario=".$idFormularioDinamico;
			
			if($hashDiferenciaTiempo==0)
			{
				$queryAux="SELECT idRegistro FROM 00017_hashRegistrosProcesos WHERE hashRegistro='".$llaveHash."' AND idFormulario=".$idFormularioDinamico;
			}

			$numRegistro=$con->obtenerValor($queryAux);
			if(($numRegistro=="")||($llaveHash==""))
			{
				$consulta[$numConsulta]="insert into ".$tabla."(".$campos.") values(".$valoresCampos.")";
				$numConsulta++;
				
				$consulta[$numConsulta]="set @idRegistroFormulario:=(select last_insert_id())";
				$numConsulta++;
				if($llaveHash!="")
				{
					$consulta[$numConsulta]="INSERT INTO 00017_hashRegistrosProcesos(idFormulario,idRegistro,hashRegistro,fechaRegistro) VALUES(".
											$idFormularioDinamico.",@idRegistroFormulario,'".$llaveHash."','".$_SESSION["fechaUltimaOperacion"]."')";
					
					$numConsulta++;
				}
			}
			else
			{
				$consulta[$numConsulta]="set @idRegistroFormulario:=".$numRegistro;
				$numConsulta++;
				$consulta[$numConsulta]="INSERT INTO 00018_hashProcesosDetectados(iFormulario,HASH,fechaDeteccion) VALUES(".$idFormularioDinamico.",'".$llaveHash."','".$_SESSION["fechaUltimaOperacion"]."')";
				$numConsulta++;
			}
			
			if(isset($_POST["_idEstadoint"])&&(isset($_POST["idFormularioDinamico"])))
			{
				array_push($arrFuncionesEjecutar,"cambiarEtapaFormulario(".$_POST["idFormularioDinamico"].",idRegPadre,".$_POST["_idEstadoint"].",'',".$idPerfil.")");
				array_push($arrFuncionesEjecutar,"registrarTemporizadorProceso(".$_POST["idFormularioDinamico"].",idRegPadre,".$_POST["_idEstadoint"].")");
			}
			
			
			
		}
		else//actualizar
		{
			$campoValor="";
			
			for($x=0;$x<$ct;$x++)
			{
				if(($parametros[$x]!="tabla")&&($parametros[$x]!="id")&&($parametros[$x]!="campoId")&&($parametros[$x][0]=='_')&&($parametros[$x]!="pagRedireccion"))
				{
					$field=nomCampo($parametros[$x]);

					$value=codCampo($parametros[$x],$valores[$x]);
					if($value=="CODE_405_100584")
					{
						return false;
					}
					if($value!='_NULL100584_')
					{
						$campos="`".$field."`";
						$valoresCampos=$value;
						if($campoValor=="")
							$campoValor=$campos."=".$valoresCampos;
						else
							$campoValor.=",".$campos."=".$valoresCampos;
					}
				}			
			}
			
			
			$consulta[$numConsulta]="update ".$tabla." set ".$campoValor." where ".$campoId."=".$id;
			
			$numConsulta++;
			$idPadre=$id;
		}
	}

	function nomCampo($campo)
	{
		return substr($campo,1,strlen($campo)-4);
	}
	
	function codCampo($campo,$valor)
	{
		
		global $directorioInstalacion;
		
		global $guardarArchivosBD;
		global $con;
		global $id;
		$sufijo=substr($campo,strlen($campo)-3);
		$sufijo=strtolower($sufijo);
		global $consultaAux;
		global $nQuery;
		global $reenviar;
		if($directorioInstalacion=="")
			$directorioInstalacion=$_SERVER["DOCUMENT_ROOT"];
		switch($sufijo)
		{
			case "tme":
				if($valor=="")
					$valor="NULL";
				else	
					$valor="'".cv($valor)."'";
				return $valor;
			break;
			case "dte":
				if($valor=="")
					$valor="NULL";
				else
				{
					$fechaTmp=explode("/",$valor);
					$valor="'".$fechaTmp[2]."-".$fechaTmp[1]."-".$fechaTmp[0]."'";
				}
				return $valor;
			break;
			case "dta":
				$valor="'".$_SESSION["fechaUltimaOperacion"]."'";
				return $valor;
			break;
			case "mem":
			case "vch":
				if($valor!='')
				{
					//$sustituye = array("\r\n","\n\r");
				//	$nValor=str_replace($sustituye,"\n\r",$valor);
					$valor="'".cv($valor)."'";
				}
				else
					$valor="NULL";
				return $valor;
			break;
			case "int":
			case "flo":

				if($valor=="")
					$valor="NULL";
				else
					$valor=normalizarNumero(cv($valor));
				return $valor;
			break;
			case "fil":
				$resultadoCopiaArchivo=false;
				$nomArchivo=nomCampo($campo);
				$nombreArchivoDestino=generarNombreArchivoTemporal();
				$archivoDestino=$directorioInstalacion."/archivosTemporales/".$nombreArchivoDestino;
				
				$binario_nombre_temporal=$_FILES[$nomArchivo]['tmp_name'] ;
				$binario_nombre=$_FILES[$nomArchivo]['name'];
				copy($binario_nombre_temporal,$archivoDestino);
						
				
				if (!empty($_FILES[$nomArchivo]['name']))
				{
					
					if(($valor=="")||($valor=="-1"))//Nuevo
					{
						$idArchivo=registrarDocumentoServidorRepositorio($nombreArchivoDestino,$binario_nombre,0,"");
						$valor=$idArchivo;
						
					}
					else//Actualizacion
					{
						$cuerpoDocumento=leerContenidoArchivo($archivoDestino);
						reemplazarArchivoRepositorio($valor,$cuerpoDocumento);
						unlink($archivoDestino);
					}
					
					/*if($resultadoCopiaArchivo===false)
					{
						echo "NO SE PUDO SUBIR DOCUMENTO !!!";
						return "CODE_405_100584";
					}*/
				}
				else
					$valor="_NULL100584_";
				return $valor;
			break;
			case "arr":
					$tabla="";
					$arrValores=array();
					if(isset($_POST["opt_".$campo]))
					{
						$tabla=$_POST[$campo];
						$arrValores=$_POST["opt_".$campo];
					}
					else
						if(isset($_POST["optListTabla_".$campo]))
						{
							$tabla=$_POST["optListTabla_".$campo];
							$arrValores=explode(",",$valor);
						}

					
					
					$idRegP="1";
					
					$numR=sizeof($arrValores);
					if($tabla!="")
					{
						$consultaAux[$nQuery]="delete from ".$tabla." where idPadre=idRegPadre";
	
						$nQuery++;
					}
					for($x=0;$x<$numR;$x++)
					{
						$consultaAux[$nQuery]="insert into  ".$tabla." (idPadre,idOpcion) values(idRegPadre,'".$arrValores[$x]."')";
						
						$nQuery++;
					}
					return "_NULL100584_";
			break;
		}
	}



?>
<html>
<body>
	
	<form method="post" action="<?php echo $_POST["pagRedireccion"] ?>" id="frmEnvio">
        <?php
		
		
		if(isset($_POST["post"])&&($_POST["post"]!=""))
		{
		?> 
    		<input type="hidden" value="<?php echo $id ?>" name="<?php echo $_POST["post"] ?>" />
		<?php
		}
        ?>
        <?php
			if(isset($_POST["_idReferenciaint"]))
				echo '<input type="hidden" name="idReferencia" value="'.$_POST["_idReferenciaint"].'">';
			if(isset($_POST["paramPost"]))
			{
				$cadParametros=$_POST["paramPost"];
				$objParametros=json_decode($cadParametros);
				$numE=sizeof($objParametros);
				for($x=0;$x<$numE;$x++)
				{
					echo "<input type='hidden' name='".$objParametros[$x]->nombreP."' value='".str_replace("idRegPadre",$idPadre,$objParametros[$x]->valorP)."'>";
				}
			}
		
		if($soloContenido==1)
		{
			echo "<input type='hidden' name='cPagina' value='sFrm=true'>";
		}
		?>
        
        
        
    </form>
</body>
	<script>

	function accionFinal()
	{

	<?php
		foreach($arrFuncionesEjecutar as $funcion)
		{
			$resultadoFunc=false;
			
			$funcionExec=str_replace("idRegPadre",$idPadre,$funcion).";";
			$funcionExec=str_replace(";;",";",$funcionExec);
			$funcionExec='$resultadoFunc='.$funcionExec;
			eval ($funcionExec);

			if(!$resultadoFunc)
			{
				$reenviar=false;
				break;
			}
		}

		$qImagenes=array();
		$x=0;
		$qImagenes[$x]="begin";
		$x++;

		if(($imagenesGaleria!="")&&($imagenesGaleria!="[]"))
		{
			$oImagen=json_decode($imagenesGaleria);
			foreach($oImagen as $img)
			{
				$listImagenes="";
				if(sizeof($img->arrImagenes)>0)
				{
					foreach($img->arrImagenes as $i)
					{
						$idImagen="-1";
						if(strpos($i->idArchivo,"_")===false)
							$idImagen=$i->idArchivo;
						else
						{
							$idImagen=registrarDocumentoServidor($i->idArchivo,$i->nombreArchivo);
							$qImagenes[$x]="INSERT INTO 9058_imagenesControlGaleria(idElementoFormulario,idArchivoImagen,idRegistro) VALUES(".$img->idCtrl.",".$idImagen.",".$idPadre.")";
							$x++;
							
							
							
						}
						if($listImagenes=="")
							$listImagenes=$idImagen;
						else
							$listImagenes.=",".$idImagen;
						
					}
				}
				if($listImagenes=="")
					$listImagenes=-1;
				$consultaImagen="select idArchivoImagen from 9058_imagenesControlGaleria WHERE idElementoFormulario=".$img->idCtrl." AND idArchivoImagen NOT IN (".$listImagenes.") and idRegistro=".$idPadre;
				$rImagen=$con->obtenerFilas($consultaImagen);
				while($fImagen=mysql_fetch_row($rImagen))
				{
					removerDocumentoServidor($fImagen[0]);	
				}
				$qImagenes[$x]="DELETE FROM 9058_imagenesControlGaleria WHERE idElementoFormulario=".$img->idCtrl." AND idArchivoImagen NOT IN (".$listImagenes.") and idRegistro=".$idPadre;
				$x++;
			}	
		}
		$qImagenes[$x]="commit";
		$x++;
		$con->ejecutarBloque($qImagenes);
		
		if(isset($_POST["eJs"]))
		{
			$arrFunciones=explode("|",base64_decode($_POST["eJs"]));
			$nFunciones=sizeof($arrFunciones);
			for($x=0;$x<$nFunciones;$x++)
				echo uEJ(str_replace("@idRegistro",$idPadre,$arrFunciones[$x])).";";
		}
		// $reenviar=false;
		if(($reenviar)&&($reenviarGlobal))
		{
			unset($_SESSION["fechaUltimaOperacion"]);
	  ?>
			document.getElementById('frmEnvio').submit();
	  <?php
		}
	?>
    }
	accionFinal();
	</script>
</html>