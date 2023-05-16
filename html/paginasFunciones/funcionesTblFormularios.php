<?php 
	if(!isset($_POST["consultaAutomatica"]) ||($_POST["consultaAutomatica"]==0))
	{
		session_start();
	}
	else
	{
		$cookieSession=$_COOKIE["PHPSESSID"];
		$rutaDestino=session_save_path()."/sess_".$cookieSession;
		if(!file_exists($rutaDestino))
		{
			echo "c2VzaW9uQ2FkdWNhZGExMDA1ODQ=";
			return;
		}
	}
	
	
	include("conexionBD.php"); 
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	switch($funcion)
	{
		case 1:
			obtenerRegistrosTblFormularios(); //Si
		break;
		case 2:
			cambiarOrden(); //NO
		break;
		case 3:
			cambiarCampoOrden(); //NO
		break;
		case 4:
			cambiarNumRegistrosPaginas(); //No
		break;
		case 5:
			cambiarAgrupacion();//No
		break;
		case 6:
			obtenerRegistrosTblFormulariosVistaRegistros(); //Si
		break;
		case 7:
			obtenerRegistrosVistaTableroControl();//Si   ----OK
		break;
		case 8:
			obtenerRegistrosVistaTableroControlTemporizador();//Si  ----
		break;
		case 9:
			actualizarConfiguracionUsuarioTableroControl();//si
		break;
		case 10:
			obtenerUsuariosTareasTurnadas(); //no
		break;
		case 11:
			obtenerRegistrosAlertasNotificaciones();//si ----
		break;
		case 12:
			obtenerRegistrosInformacionAlertasNotificaciones(); //si
		break;
		case 13;
			obtenerRegistrosAlertasNotificacionesHora(); //si ----
		break;
	}
	
	
	function obtenerRegistrosTblFormularios()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$idConfiguracion=$_POST["idConfiguracion"];
		$idEstado=$_POST["idEstado"];
		$posMin=$_POST["start"];
		$posMax=$_POST["limit"];
		$idRegistro="0";
		$idFormulario=obtenerValorParametro("idFormulario");
		$idProceso="-1";
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		
		$consulta="select idTipoProceso FROM 4001_procesos WHERE idProceso=".$idProceso;
		$tipoProceso=$con->obtenerValor($consulta);
		
		$cadObj='{"p16":{"p1":"'.$idFormulario.'","p2":"'.$idProceso.'","p3":"-1","p4":"1","p5":"'.$idReferencia.'","p6":"-1"}}';
		$paramObj=json_decode($cadObj);

		$arrQueries=resolverQueries($idFormulario,5,$paramObj);
		$consulta="select nombreTabla,idFrmEntidad,complementario from 900_formularios where idFormulario=".$idFormulario;
		$fila=$con->obtenerPrimeraFila($consulta);
		$tablaFormulario=$fila[0];
		$complementario=$fila[2];
		$condFiltro="";
		$filtroUsuario="";
		$consulta="select idFiltro from 915_confGridVSRol where idConfGrid=".$idConfiguracion." and idRol in(".$_SESSION["idRol"].")";
		$idFiltro=$con->obtenerValor($consulta);

		$arrCamposProyeccion=array();

		if($idFiltro=="")
			$idFiltro="-1";
		$consulta="select tokenMysql from 917_consultasFiltroGrid where idFiltro=".$idFiltro;
		$res=$con->obtenerFilas($consulta);
		$consultaConf="";
		while($fila=$con->fetchRow($res))
		{
			$consultaConf.=$fila[0]." ";
		}
		if($consultaConf!="")
		{
			$consultaConf=str_replace('@usuario',$_SESSION["idUsr"],$consultaConf);
			$consultaConf=str_replace('@UnidadUsuario',$_SESSION["codigoUnidad"],$consultaConf);
			$consultaConf=str_replace('@instUsuario',$_SESSION["codigoInstitucion"],$consultaConf);
			$consultaConf=" and (".$consultaConf.")";
		}

		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				if(($arrFiltro[$x]["field"]!="responsableCreacion")&&($arrFiltro[$x]["field"]!="responsableModificacion"))
					$condFiltro.=" and ".formatearFiltro($arrFiltro[$x]);
				else
				{
					if($filtroUsuario=="")
						$filtroUsuario=" where ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					else
						$filtroUsuario.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
				}
			}
		}
		

		if($con->existeTabla($tablaFormulario))
		{
			
			/*	//Valores directos de tabla
			$consulta="	select e.nombreCampo,e.idGrupoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where tipoElemento not in(-1,0,1,2,4,14,16) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";

			$camposAux="id_".$tablaFormulario." as idRegistro,responsable,codigoUnidad,".$con->obtenerListaValores($consulta,"`");
			//valor de contenidos en otras tablas
			$consulta="	select e.nombreCampo,e.idGrupoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where (tipoElemento=4 or tipoElemento=16) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";
			$res=$con->obtenerFilas($consulta);
			$camposRefTablas="";
			while($filas=$con->fetchRow($res))
			{
				$queryConf="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[1];
				$filaConf=$con->obtenerPrimeraFila($queryConf);
				$tablaD=$filaConf[2];
				$campoP=$filaConf[3];
				$campoId=$filaConf[4];
				if(strpos($tablaD,"[")===false)
				{
					$consultaRefTablas="(select ".$campoP." from ".$tablaD." where ".$campoId."=".$tablaFormulario.".".$filas[0]." limit 0,1)";
				}
				else
				{
					$idAlmacen=str_replace("[","",$tablaD);
					$idAlmacen=str_replace("]","",$idAlmacen);
					
					$consulta="SELECT configuracion FROM 907_camposGrid WHERE idElementoFormulario=".$filas[1];
					
					$conf=$con->obtenerValor($consulta);
					if($conf!='')
					{
						$obj=json_decode($conf);
						if(isset($obj->consultaReemplazo)&&($obj->consultaReemplazo!=""))
							$idAlmacen=$obj->consultaReemplazo;
							
					}
					
					if($arrQueries[$idAlmacen]["ejecutado"]==1)
					{
						$arrCampos=str_replace(".","__",$campoP);
						$arrCampos=str_replace("@@",",",$arrCampos);
						$normalizado=normalizarQueryProyeccion($arrQueries[$idAlmacen]["query"]);

						$compOr="";
						if(strpos($normalizado,"where")!==false)
						{
							$arrComp=explode(" order ",$normalizado);
							$compOr="";
							$normalizado=$arrComp[0].$compOr;
							if(sizeof($arrComp)>1)
							{
								$normalizado.=" order ".$arrComp[1];
							}

						}
						$consultaRefTablas="(select concat(".$arrCampos.") from (".$normalizado.") tc where tc.".str_replace(".","__",$campoId)."=".$tablaFormulario.".".$filas[0]." limit 0,1)";
						
					}
					else
						$consultaRefTablas="'No se ha podido resolver'";
				}
				
				$camposRefTablas.=",".$consultaRefTablas." as `".$filas[0]."`";
			}
			//valor de opciones ingresadas por el usuario manualmente
			$consulta="	select e.nombreCampo,e.idGrupoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where (tipoElemento=2 or tipoElemento=14) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";
			$res=$con->obtenerFilas($consulta);
			$camposRefOpciones="";
			while($filas=$con->fetchRow($res))
			{
				$consultaRefTablas="(select contenido from 902_opcionesFormulario where idIdioma=".$_SESSION["leng"]." and idGrupoElemento=".$filas[1]." and valor=".$tablaFormulario.".".$filas[0]." )";
				$camposRefOpciones.=",".$consultaRefTablas." as `".$filas[0]."`";
			}
			//valores de variables de sistema
			
			$consulta="select campoUsr
						 as nombreCampo
						 ,cg.idElementoFormulario
						 from 907_camposGrid cg,9017_camposControlFormulario cc where cc.tipoElemento=cg.idElementoFormulario and
						 cg.idIdioma=".$_SESSION["leng"]." and cg.idElementoFormulario<0 and cg.idConfGrid=".$idConfiguracion;

			$res=$con->obtenerFilas($consulta);	
			$camposRefSistema="";
			while($filas=$con->fetchRow($res))
			{
				switch($filas[1])
				{
					case "-11":
					case "-13":
						$consultaRefSistema="(select Nombre from 802_identifica where idUsuario=".$tablaFormulario.".responsable)";
					break;
					case "-10":
						$consultaRefSistema="fechaCreacion";
					break;
					case "-12":
						$consultaRefSistema="fechaModif";
					break;
					case "-14":
						$consultaRefSistema="(select Unidad  from 817_organigrama where codigoUnidad=".$tablaFormulario.".codigoUnidad)";
					break;
					case "-15":
						$consultaRefSistema="(select Unidad  from 817_organigrama where codigoUnidad=".$tablaFormulario.".codigoInstitucion)";
					break;
					case "-16":
						$consultaRefSistema="dtefechaSolicitud";
					break;
					case "-17":
						$consultaRefSistema="tmeHoraInicio";
					break;
					case "-18":
						$consultaRefSistema="tmeHoraFin";
					break;
					case "-19":
						$consultaRefSistema="dteFechaAsignada";
					break;
					case "-20":
						$consultaRefSistema="tmeHoraInicialAsignada";
					break;
					case "-21":
						$consultaRefSistema="tmeHoraFinalAsignada";
					break;
					case "-22":
						$consultaRefSistema="unidadReservada";
					break;
					case "-23":
						$consultaRefSistema="tmeHoraSalida";
					break;
					case "-24":
						$query="select idProceso from 900_formularios where idFormulario=".$idFormulario;
						$idProceso=$con->obtenerValor($query);
						$consultaRefSistema="(select nombreEtapa from 4037_etapas where numEtapa=idEstado and idProceso=".$idProceso.")";
					break;
					case "-25":
						$consultaRefSistema="codigo";
					break;
				}
				$camposRefSistema.=",".$consultaRefSistema." as `".$filas[0]."`";
			}
			*/
			
				//Valores directos de tabla
			$consulta="	select e.nombreCampo,e.idGrupoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where tipoElemento not in(-1,0,1,2,4,14,16,30) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";
			
			$listaCampos=$con->obtenerListaValores($consulta,"`");
			$camposAux="id_".$tablaFormulario." as idRegistro,responsable,codigoUnidad,idEstado as idEtapaRegistro,".$listaCampos;
			
			$arrCamposProyeccion["idRegistro"]=1;
			$arrCamposProyeccion["responsable"]=1;
			$arrCamposProyeccion["codigoUnidad"]=1;
			$arrCamposProyeccion["idEtapaRegistro"]=1;
			
			$aAux=explode(",",$listaCampos);
			foreach($aAux as $c)
			{
				$arrCamposProyeccion[str_replace("`","",$c)]=1;
			}
			
			
			
			//valor de contenidos en otras tablas
			$consulta="	select e.nombreCampo,e.idGrupoElemento,e.tipoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where (tipoElemento=4 or tipoElemento=16) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";
			$res=$con->obtenerFilas($consulta);
			$camposRefTablas="";
			while($filas=$con->fetchRow($res))
			{
				$queryConf="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[1];
				$filaConf=$con->obtenerPrimeraFila($queryConf);
				$tablaD=$filaConf[2];
				$campoP=$filaConf[3];
				$campoId=$filaConf[4];
				if(strpos($tablaD,"[")===false)
				{
					$consultaRefTablas="(select ".$campoP." from ".$tablaD." where ".$campoId."=".$tablaFormulario.".".$filas[0]." limit 0,1)";
				}
				else
				{
					$idAlmacen=str_replace("[","",$tablaD);
					$idAlmacen=str_replace("]","",$idAlmacen);
					
					$consulta="SELECT configuracion FROM 907_camposGrid WHERE idElementoFormulario=".$filas[1];
					$conf=$con->obtenerValor($consulta);
					if($conf!='')
					{
						$obj=json_decode($conf);
						if(isset($obj->consultaReemplazo)&&($obj->consultaReemplazo!=""))
							$idAlmacen=$obj->consultaReemplazo;
							
					}
					
					if($arrQueries[$idAlmacen]["ejecutado"]==1)
					{
						
						$arrCampos=str_replace("@@",",",$campoP);
						$normalizado=normalizarQueryProyeccionOptimizacion($arrQueries[$idAlmacen]["query"],$arrCampos);
						
						$compOr="";
						if(strpos($normalizado,"where")!==false)
						{
							$arrComp=explode(" order ",$normalizado);
							$normalizado=$arrComp[0];
							if(sizeof($arrComp)>1)
							{
								$compOr.=" order ".$arrComp[1];
							}

						}
						else
						{
							
							$arrComp=explode(" order ",$normalizado);
							$normalizado=$arrComp[0];
							$normalizado.=" where 1=1";
							if(sizeof($arrComp)>1)
							{
								$compOr.=" order ".$arrComp[1];
							}
						}
						
						if($arrQueries[$idAlmacen]["idConexion"]==0)
							$consultaRefTablas="(".$normalizado." and ".$campoId."=".$tablaFormulario.".".$filas[0]." ".$compOr." limit 0,1)";
						else
						{
							$arrConsultaNormaliza=explode(" where ",$normalizado);
							$consultaRefTablas=str_replace("concat",$campoId.", concat",$arrConsultaNormaliza[0]);
							$conAux=$arrQueries[$idAlmacen]["conector"];
							$resAux=$conAux->obtenerFilas($consultaRefTablas);
							$consultaRefTablas="(SELECT (CASE ".$tablaFormulario.".".$filas[0]." ";
							while($filaAux=$conAux->obtenerSiguienteFila($resAux))
							{
								$consultaRefTablas.=" WHEN ".$filaAux[0]." THEN '".$filaAux[1]."'";
							}
							$consultaRefTablas.=" END))";
							
						}

						
					}
					else
					{
//						varDump($arrQueries[$idAlmacen]);
						
						if($arrQueries[$idAlmacen]["idConexion"]==0)
						{
							$aQueryAux=explode(" where ",$arrQueries[$idAlmacen]["query"]);
							
							$arrCampos=str_replace("@@",",",$campoP);
							$normalizado=normalizarQueryProyeccionOptimizacion($aQueryAux[0],$arrCampos);
							
							$compOr="";
							
								
							$arrComp=explode(" order ",$normalizado);
							$normalizado=$arrComp[0];
							
							
							$arrTablas=obtenerTablasConsulta($arrQueries[$idAlmacen]["query"]);
							if($arrTablas==1)
							{
							
								$normalizado.=" where 1=1";
								if(sizeof($arrComp)>1)
								{
									$compOr.=" order ".$arrComp[1];
								}
								
								$consultaRefTablas="(".$normalizado." and ".$campoId."=".$tablaFormulario.".".$filas[0]." ".$compOr." limit 0,1)";
							}
							else
							{
								$aAux=explode(" order ",$aQueryAux[1]);
								$normalizado.=" where ".normalizarCondicionesWhere($aAux[0]);
								if(sizeof($arrComp)>1)
								{
									$compOr.=" order ".$arrComp[1];
								}
								
								$consultaRefTablas="(".$normalizado." and ".$campoId."=".$tablaFormulario.".".$filas[0]." ".$compOr." limit 0,1)";

							}
							
						}
						else
							$consultaRefTablas="'No se ha podido resolver'";
					}
				}
				$camposRefTablas.=",".$consultaRefTablas." as `".$filas[0]."`";
			}
			//valor de opciones ingresadas por el usuario manualmente
			$consulta="	select e.nombreCampo,e.idGrupoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where (tipoElemento=2 or tipoElemento=14) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";

			$res=$con->obtenerFilas($consulta);
			$camposRefOpciones="";
			while($filas=$con->fetchRow($res))
			{
				$consultaRefTablas="(select contenido from 902_opcionesFormulario where idIdioma=".$_SESSION["leng"]." and idGrupoElemento=".$filas[1]." and valor=".$tablaFormulario.".".$filas[0]." )";
				$camposRefOpciones.=",".$consultaRefTablas." as `".$filas[0]."`";
			}
			
			$consulta="SELECT e.nombreCampo,e.idGrupoElemento FROM 901_elementosFormulario e,907_camposGrid cg 
						WHERE (tipoElemento=30) AND cg.idElementoFormulario=e.idGrupoElemento AND cg.idConfGrid=".$idConfiguracion." ORDER BY idGrupoCampo";

			$res=$con->obtenerFilas($consulta);
			while($filas=$con->fetchRow($res))
			{
				$consultaRefTablas="";
				$queryConf="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[1];
				$filaConf=$con->obtenerPrimeraFila($queryConf);
				$tablaD=$filaConf[2];
				$campoP=$filaConf[3];
				$campoId=$filaConf[4];
				$idAlmacen=str_replace("[","",$tablaD);
				$idAlmacen=str_replace("]","",$idAlmacen);
				
				$consulta="SELECT configuracion FROM 907_camposGrid WHERE idElementoFormulario=".$filas[1];
				$conf=$con->obtenerValor($consulta);
				if($conf!='')
				{
					$obj=json_decode($conf);
					if(isset($obj->consultaReemplazo)&&($obj->consultaReemplazo!=""))
						$idAlmacen=$obj->consultaReemplazo;
				}
				
				if($arrQueries[$idAlmacen]["ejecutado"]==1)
				{
					$arrCampos=str_replace("@@",",",$campoP);
					$normalizado=normalizarQueryProyeccionOptimizacion($arrQueries[$idAlmacen]["query"],$arrCampos);

					$compOr="";
					if(strpos($normalizado,"where")!==false)
					{
						$arrComp=explode(" order ",$normalizado);
						$normalizado=$arrComp[0];
						if(sizeof($arrComp)>1)
						{
							$compOr.=" order ".$arrComp[1];
						}

					}
					else
					{
						
						$arrComp=explode(" order ",$normalizado);
						$normalizado=$arrComp[0];
						$normalizado.=" where 1=1";
						if(sizeof($arrComp)>1)
						{
							$compOr.=" order ".$arrComp[1];
						}
					}
					
					if($arrQueries[$idAlmacen]["idConexion"]==0)
						$consultaRefTablas="(".$normalizado." ".$compOr." limit 0,1)";
					else
					{
						$arrConsultaNormaliza=explode(" where ",$normalizado);
						$consultaRefTablas=str_replace("concat",$campoId.", concat",$arrConsultaNormaliza[0]);
						$conAux=$arrQueries[$idAlmacen]["conector"];
						$resAux=$conAux->obtenerFilas($consultaRefTablas);
						$consultaRefTablas="(SELECT (CASE ".$tablaFormulario.".".$filas[0]." ";
						while($filaAux=$conAux->obtenerSiguienteFila($resAux))
						{
							$consultaRefTablas.=" WHEN ".$filaAux[0]." THEN '".$filaAux[1]."'";
						}
						$consultaRefTablas.=" END))";
						
					}
					//echo $consultaRefTablas."<br>";
				}
				else
					$consultaRefTablas="'Query No resuelta'";
				$camposRefOpciones.=",(".$consultaRefTablas.") as `".$filas[0]."`";
			}
			
			//valores de variables de sistema
			$consulta="select campoUsr
						 as nombreCampo
						 ,cg.idElementoFormulario
						 from 907_camposGrid cg,9017_camposControlFormulario cc where cc.tipoElemento=cg.idElementoFormulario and
						 cg.idIdioma=".$_SESSION["leng"]." and cg.idElementoFormulario<0 and cg.idConfGrid=".$idConfiguracion;

			$res=$con->obtenerFilas($consulta);	
			$camposRefSistema="";
			while($filas=$con->fetchRow($res))
			{
				switch($filas[1])
				{
					case "-11":
					case "-13":
						$consultaRefSistema="(select concat(Paterno,' ',Materno,' ',Nom) from 802_identifica where idUsuario=".$tablaFormulario.".responsable)";
					break;
					case "-10":
						$consultaRefSistema="fechaCreacion";
					break;
					case "-12":
						$consultaRefSistema="fechaModif";
					break;
					case "-14":
						$consultaRefSistema="(select Unidad  from 817_organigrama where codigoUnidad=".$tablaFormulario.".codigoUnidad)";
					break;
					case "-15":
						$consultaRefSistema="(select Unidad  from 817_organigrama where codigoUnidad=".$tablaFormulario.".codigoInstitucion)";
					break;
					case "-16":
						$consultaRefSistema="dtefechaSolicitud";
					break;
					case "-17":
						$consultaRefSistema="tmeHoraInicio";
					break;
					case "-18":
						$consultaRefSistema="tmeHoraFin";
					break;
					case "-19":
						$consultaRefSistema="dteFechaAsignada";
					break;
					case "-20":
						$consultaRefSistema="tmeHoraInicialAsignada";
					break;
					case "-21":
						$consultaRefSistema="tmeHoraFinalAsignada";
					break;
					case "-22":
						$consultaRefSistema="unidadReservada";
					break;
					case "-23":
						$consultaRefSistema="tmeHoraSalida";
					break;
					case "-24":
						$query="select idProceso from 900_formularios where idFormulario=".$idFormulario;
						$idProceso=$con->obtenerValor($query);
						$consultaRefSistema="(select concat(numEtapa,'.- ',nombreEtapa) from 4037_etapas where numEtapa=idEstado and idProceso=".$idProceso.")";
					break;
					case "-25":
						$consultaRefSistema="codigo";
					break;
					case "-27":
						$consultaRefSistema="(SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE 
											idFormulario=".$idFormulario." AND idRegistro=".$tablaFormulario.".id_".$tablaFormulario." ORDER BY fechaCambio DESC LIMIT 0,1)";
					break;
					case "-28":
						$consultaRefSistema="(SELECT dteFechaReunion FROM _916_tablaDinamica WHERE idReferencia like concat('%',LPAD('".$idFormulario."',6,'0'),LPAD(".$tablaFormulario.".id_".$tablaFormulario.",6,'0'))  ORDER BY dteFechaReunion DESC LIMIT 0,1)";
					break;
				}
				$camposRefSistema.=",".$consultaRefSistema." as `".$filas[0]."`";
			}
			
			
			
			$condWhere=" where idEstado<>1984 ";

			
			if(($idReferencia!="")&&($idReferencia!='-1'))
				$condWhere.=" and idReferencia=".$idReferencia;
			
			
			
			if($tipoProceso==1)
			{
				if(strpos($complementario,"{")!==false)
				{
					$obj=json_decode($complementario);
					switch($obj->condicion) //1 repgistrado por uss, 2 registrado en su depto; 3 registrado en su depto y subdepto;
					{
						case "1":
							$condWhere.=" and responsable=".$_SESSION["idUsr"];	
						break;
						case "2":
							$condWhere.=" and codigoUnidad='".$_SESSION["codigoUnidad"]."'";	
						break;
						case "3":
							$condWhere.=" and (codigoUnidad='".$_SESSION["codigoUnidad"]."' or codigoUnidad like '".$_SESSION["codigoUnidad"]."%')";	
						break;
						case "4":
							$condWhere.=" and (codigoInstitucion='".$_SESSION["codigoInstitucion"]."')";	
						break;
					}
				}
				
			}	
			
				

			if($idEstado!="-1")
				$condWhere.=" and idEstado=".$idEstado;
			
			$campoOrden=$_POST["sort"];
			
			
			$orden="";
			
			$campoAgrupador="";
			$consulta="  SELECT campoAgrupacion FROM 909_configuracionTablaFormularios f WHERE f.idFormulario=".$idFormulario;
			$campoAgrupador=$con->obtenerValor($consulta);
			
			if(($campoAgrupador!="")&&($campoAgrupador!="0"))
			{
				/*$consulta="select campoMysql from 9017_camposControlFormulario where campoUsr='".$campoAgrupador."'";
				$campoO=$con->obtenerValor($consulta);
				if($campoO!="")
					$campoAgrupador=$campoO;*/
				$orden=" order by ".$campoAgrupador;
			}
			
			$campoOrden=$_POST["sort"];
			if($campoOrden!="")
			{
				$consulta="select campoMysql from 9017_camposControlFormulario where campoUsr='".$campoOrden."'";
				$campoO=$con->obtenerValor($consulta);
				if($campoO!="")
					$campoOrden=$campoO;
				
				if($orden=="")
					$orden=" order by ";
				else
					$orden.=", ";
				$orden.=$campoOrden." ".$_POST["dir"];
			}
			
			
			$consulta2="select * from (select ".$camposAux.$camposRefTablas.$camposRefOpciones.$camposRefSistema." from ".$tablaFormulario." ".$condWhere." ".$consultaConf." ".$condFiltro." ".$orden.") as vQuery ".$filtroUsuario;

			if($posMax>=0)
			{
				$consulta="select * from (select ".$camposAux.$camposRefTablas.$camposRefOpciones.$camposRefSistema." from ".$tablaFormulario." ".$condWhere." ".$consultaConf." ".$condFiltro." ".$orden.") as vQuery ".$filtroUsuario." limit ".$posMin.",".$posMax;
				$consulta=str_replace(',,',',',$consulta);
				
			}
			else
				$consulta=$consulta2;

			

			$consulta2=str_replace(',,',',',$consulta2);
			$consulta2=str_replace("'distinct ","'",$consulta2);
			$consulta=str_replace("'distinct ","'",$consulta);
			$consulta=str_replace(',,',',',$consulta);


			$numElementos=$con->contarRegistros($consulta2);
			
			//$datos=$con->obtenerFilasArreglo($consulta);
			
			$json=$con->obtenerFilasJson($consulta);
			$arrJson='{"numReg":'.$numElementos.',registros:'.str_replace("__","",utf8_encode($json)).'}';		
		}
		else
		{
			$arrJson='{"numReg":"0",registros:[]}';					
		}
		echo $arrJson;
	}
	
	
		
	function formatearFiltro($filtro)
	{
		global $con;
		$consulta="SELECT campoUsr,campoMysql FROM 9017_camposControlFormulario";
		$arrCampos=$con->obtenerFilasArregloAsocPHP($consulta);	
		$campo=$filtro["field"];
		if(isset($arrCampos[$campo]))
			$campo=$arrCampos[$campo];
		$campo="`".$campo."`";
		$tipoDato=$filtro["data"]["type"];
		$condicion=" like ";
		if(isset($filtro["data"]["comparison"]))
		{
			switch($filtro["data"]["comparison"])
			{
				case "gt":
					$condicion=">";
				break;
				case "lt":
					$condicion="<";
				break;
				case "eq":
					$condicion="=";
				break;
			}
		}
		
		$valor="";
		switch($tipoDato)
		{
			case "numeric":
				$valor=$filtro["data"]["value"];
			break;
			case "date":
				$fecha=$filtro["data"]["value"];
				$arrFecha=explode('/',$fecha);
				$valor="'".$arrFecha[2]."/".$arrFecha[1]."/".$arrFecha[0]."'";
			break;
			case "list":
				$condicion=" in ";
				$arrValores=explode(',',$filtro["data"]["value"]);
				$nCt=sizeof($arrValores);
				for($x=0;$x<$nCt;$x++)
				{
					if($valor=='')
						$valor=$arrValores[$x];
					else
						$valor.=",".$arrValores[$x];
				}
				
				
				$valor="(".$valor.")";
			break;
			default:
				$valor="'".$filtro["data"]["value"]."%'";
			break;
		}
		
		
		
		return $campo.$condicion.$valor;
	}
		
	function cambiarOrden()
	{
		global $con;
		$orden=$_POST["orden"];
		$idConfiguracion=$_POST["idConfiguracion"];
		$consulta="update 909_configuracionTablaFormularios set direccionOrden='".$orden."' where idConfGrid=".$idConfiguracion;
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|";
		}
	}
	
	function cambiarCampoOrden()
	{
		global $con;
		$campoOrden=$_POST["campoOrden"];
		$idConfiguracion=$_POST["idConfiguracion"];
		$consulta="update 909_configuracionTablaFormularios set campoOrden='".$campoOrden."' where idConfGrid=".$idConfiguracion;

		if($con->ejecutarConsulta($consulta))
		{
			echo "1|";
		}
	}
	
	function cambiarNumRegistrosPaginas()
	{
		global $con;
		$numRegistro=$_POST["numReg"];
		$idConfiguracion=$_POST["idConfiguracion"];
		$consulta="update 909_configuracionTablaFormularios set numRegPag='".$numRegistro."' where idConfGrid=".$idConfiguracion;
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|";
		}
	}
	
	function cambiarAgrupacion()
	{
		global $con;
		$campoAgrupacion=$_POST["campoAgrupacion"];
		$idConfiguracion=$_POST["idConfiguracion"];
		$consulta="update 909_configuracionTablaFormularios set campoAgrupacion='".$campoAgrupacion."' where idConfGrid=".$idConfiguracion;
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|";
		}
		
	}
	
	function obtenerRegistrosTblFormulariosVistaRegistros()
	{
		global $con;
		$idUsuario=$_SESSION["idUsr"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=-1;
		if(isset($_POST["idReferencia"]))
			$idReferencia=$_POST["idReferencia"];
		$idConfiguracion=$_POST["idConfiguracion"];
		$idProcesoPadre=-1;
		if(isset($_POST["idProcesoPadre"]))
			$idProcesoPadre=$_POST["idProcesoPadre"];
		$posMin=$_POST["start"];
		$posMax=$_POST["limit"];
		$idActor=$_POST["idActor"];
		$tipoActor=$_POST["tipoActor"];
		
		$cadFiltrosGlobales="";
		if(isset($_POST["arrFiltroGlobal"]))
			$cadFiltrosGlobales=bD($_POST["arrFiltroGlobal"]);
		$parametrosProceso=NULL;
		if(isset($_POST["parametrosProceso"]))
			$parametrosProceso=json_decode(bD($_POST["parametrosProceso"]));
		
		
			
			
		$fGlobalInterno="";
		$fGlobalExterno="";
		
		
		
		$idRegistro="0";
		$idFormulario=obtenerValorParametro("idFormulario");
		$idProceso="-1";
		$idProceso=obtenerIdProcesoFormulario($idFormulario);
		$condWhere="";
		$arrActoresEtapa=array();
		$nTabla="_".$idFormulario."_tablaDinamica";	
		$arrParticipaciones=array();
		$idFrmAutores=-1;
		$complementario="";
		
		if($cadFiltrosGlobales!="")
		{
			$objFiltroGlobal=json_decode($cadFiltrosGlobales);
			
			foreach($objFiltroGlobal->filtros as $f)
			{

				if($f->tipo==10)
				{
					$objBusqueda=json_decode(bD($f->condicion));
					
					$cache=NULL;
					$cadObj='{"idFormulario":"'.$idFormulario.'","figuraJuridica":"'.$objBusqueda->condicion.'","nombreParticipante":"'.cv(urldecode($objBusqueda->valorBusqueda)).'"}';
					
					$obj=json_decode($cadObj);
					
					$resultado=removerComillasLimite(resolverExpresionCalculoPHP($objBusqueda->idFuncionBusqueda,$obj,$cache));
					
					$listRegistros=bD($resultado);
					if($listRegistros=="")
						$listRegistros=-1;
					$condicionGlobal="id_".$nTabla." in (".$listRegistros.")";
				}
				else
				{
					$condicionGlobal=$f->campo." ".urldecode($f->condicion);
				}

				if($f->busquedaInterna==1)
				{
					if($fGlobalInterno=="")		
						$fGlobalInterno=$condicionGlobal;
					else
						$fGlobalInterno.=" and ".$condicionGlobal;	
						
				}
				else
				{
					if($fGlobalExterno=="")		
						$fGlobalExterno=$condicionGlobal;
					else
						$fGlobalExterno.=" and ".$condicionGlobal;	
				}
					
			}
			
		}
		

		switch($tipoActor)
		{
			case -1: //Proceso normal
				//$listRegistros=77;
				//$condWhere=" where id_".$nTabla." in (".$listRegistros.")";
				$consulta="SELECT numEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." ORDER BY numEtapa";
				$res=$con->obtenerFilas($consulta);
				while($fEtapa=$con->fetchRow($res))
				{
					$arrActoresEtapa[($fEtapa[0]."")]=array();
					$arrActoresEtapa[($fEtapa[0]."")]["idActorProcesoEtapa"]=0;
					$permisos="";
					$consulta="SELECT permisos FROM 4002_rolesVSEtapas WHERE proceso=".$idProceso." AND etapa=".$fEtapa[0]." AND idRol IN (".$_SESSION["idRol"].")";

					$rPermisos=$con->obtenerFilas($consulta);
					while($fPermisos=$con->fetchRow($rPermisos))
					{
						if((strpos($fPermisos[0],"C")!==false)&&(strpos($permisos,"C")===false))
						{
							$permisos.="C";
						}
						
						if((strpos($fPermisos[0],"A")!==false)&&(strpos($permisos,"A")===false))
						{
							$permisos.="A";
						}
						
						if((strpos($fPermisos[0],"M")!==false)&&(strpos($permisos,"M")===false))
						{
							$permisos.="M";
						}
						
						if((strpos($fPermisos[0],"E")!==false)&&(strpos($permisos,"E")===false))
						{
							$permisos.="E";
						}
						
					}
					$arrActoresEtapa[($fEtapa[0]."")]["permisos"]=$permisos;
				}
			break;
			case 1: //Registrante
				$idPerfil=obtenerIdPerfilEscenario($idProceso,1,$idActor,true);

				$consulta="SELECT numEtapa,idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$idActor."' AND tipoActor=1 AND idProceso=".$idProceso." and idPerfil=".$idPerfil;
				
				
				
				$res=$con->obtenerFilas($consulta);
				while($fEtapa=$con->fetchRow($res))
				{
					$arrActoresEtapa[($fEtapa[0]."")]=array();
					$arrActoresEtapa[($fEtapa[0]."")]["idActorProcesoEtapa"]=bE($fEtapa[1]);
					$permisos="";
					$consulta="SELECT 'E' as elimina FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$fEtapa[1]." and idGrupoAccion=7";
					$permisos=$con->obtenerValor($consulta);
					
					
					$consulta="SELECT 'F' as elimina FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$fEtapa[1]." and idGrupoAccion=70";
					$permisosAux=$con->obtenerValor($consulta);
					if($permisos=="")
						$permisos=$permisosAux;
					else
						$permisos.=$permisosAux;
					
					$arrActoresEtapa[($fEtapa[0]."")]["permisos"]=$permisos;

				}

				$consulta="select complementario from 949_actoresVSAccionesProceso where actor ='".$idActor."' and idAccion=9 and idProceso=".$idProceso." and idPerfil=".$idPerfil." order by complementario";
				
				$complementario=$con->obtenerValor($consulta);
				
				switch($complementario)
				{
					case "1":
						$condWhere="";
					break;
					case "2":
						$condWhere=" where codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
					break;
					case "3":
						$condWhere=" where codigoUnidad like '".$_SESSION["codigoUnidad"]."%'";
					break;
					case "4":
						$condWhere=" where codigoUnidad='".$_SESSION["codigoUnidad"]."'";
					break;
					case "5":
						$idFrmAutores=incluyeModulo($idProceso,3);
						if($idFrmAutores=="-1")
							$condWhere=" where responsable=".$idUsuario;
						else
						{
							$consultaAux="select idReferencia,claveParticipacion,responsable from 246_autoresVSProyecto a wHERE a.idUsuario=".$idUsuario." AND a.idFormulario=".$idFormulario." order by idReferencia";
							$res=$con->obtenerFilas($consultaAux);
							$listRegistros="";
							while($fAux=$con->fetchRow($res))
							{
								if($listRegistros=="")
									$listRegistros=$fAux[0];	
								else
									$listRegistros.=",".$fAux[0];	
								if($listRegistros=="")
									$listRegistros="-1";
								if(!isset($arrParticipaciones[$fAux[0]]))
								{
									$arrParticipaciones[$fAux[0]]=array();
									$arrParticipaciones[$fAux[0]]["responsable"]=0;
								}
								$arrParticipaciones[$fAux[0]]["claveParticipacion"]=$fAux[1];
								$arrParticipaciones[$fAux[0]]["responsable"]+=$fAux[2];
								
							}
							$condWhere=" where id_".$nTabla." in (".$listRegistros.")";
						}
						
					break;
				}
			break;
			
			case 3:  //Rol
				$condWhereAmbito="";
				$compQuery="";
				
				
				$idPerfil=obtenerIdPerfilEscenario($idProceso,1,$idActor,true);
				
				$consulta="SELECT complementario FROM 943_rolesActoresProceso WHERE idProceso=".$idProceso." AND rol='".$idActor."'";

				$cadObj=$con->obtenerValor($consulta);
				if($cadObj!="")
				{
					$objComp=json_decode($cadObj);
					if(isset($objComp->filtro))
					{
						$compQuery=$objComp->filtro;
						$compQuery=str_replace("@idUsuarioSesion",$_SESSION["idUsr"],$compQuery);
					}
				}
				$consulta="SELECT numEtapa,idActorProcesoEtapa FROM 944_actoresProcesoEtapa WHERE actor='".$idActor."' AND tipoActor=1 AND idProceso=".$idProceso." and idPerfil=".$idPerfil;
				
				
				$res=$con->obtenerFilas($consulta);
				while($fEtapa=$con->fetchRow($res))
				{
					$arrActoresEtapa[($fEtapa[0]."")]=array();
					$arrActoresEtapa[($fEtapa[0]."")]["idActorProcesoEtapa"]=bE($fEtapa[1]);
					$permisos="";
					$consulta="SELECT 'E' as elimina FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$fEtapa[1]." and idGrupoAccion=7";
					$permisos=$con->obtenerValor($consulta);
					
					$consulta="SELECT 'F' as elimina FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$fEtapa[1]." and idGrupoAccion=70";
					$permisosAux=$con->obtenerValor($consulta);
					if($permisos=="")
						$permisos=$permisosAux;
					else
						$permisos.=$permisosAux;
					
					$arrActoresEtapa[($fEtapa[0]."")]["permisos"]=$permisos;
					$consulta="SELECT idAccionesProcesoEtapaVSAcciones FROM 947_actoresProcesosEtapasVSAcciones WHERE idActorProcesoEtapa=".$fEtapa[1]." AND idGrupoAccion=21";
					$idAccionProceso=$con->obtenerValor($consulta);
					if($idAccionProceso!="")
					{
						$consulta="SELECT codigoUnidad,ambito FROM 947_ampliacionesAmbitoRegistros WHERE idAccionesProcesoEtapaVSAcciones=".$idAccionProceso;
						$resProceso=$con->obtenerFilas($consulta);
						$compAmbito="";
						while($filaProceso=$con->fetchRow($resProceso))
						{
							if($filaProceso[0]<0)
							{
								switch($filaProceso[0])
								{
									case -1:
										$filaProceso[0]=$_SESSION["codigoInstitucion"];
									break;
									case -2:
										$filaProceso[0]=$_SESSION["codigoUnidad"];
									break;
								}
							}
							
							
							$consulta="select institucion from 817_organigrama where codigoUnidad='".$filaProceso[0]."'";
							$institucion=$con->obtenerValor($consulta);
							if($institucion==1)
							{
								$compAmbito=" codigoInstitucion='".$filaProceso[0]."'";
							}
							else
							{
								$compAmbito=" codigoUnidad='".$filaProceso[0]."'";
								if($filaProceso[1]==1)
								{
									$compAmbito='('.$compAmbito.' or codigoUnidad like "'.$filaProceso[0].'%")';
								}
							}
								
							
							
							if($condWhereAmbito!="")
								$condWhereAmbito.=" or ".$compAmbito;
							else
								$condWhereAmbito=$compAmbito;
						}
					}
				}
				
				$condWhere="where idEstado in (select distinct(numEtapa) from 944_actoresProcesoEtapa where actor ='".$idActor."' and idProceso=".$idProceso." and idPerfil=".$idPerfil.") ".$compQuery."";
				$aux="";
				if($condWhereAmbito=="")
				{
					$consulta="SELECT * FROM 949_actoresVSAccionesProceso WHERE actor ='".$idActor."' and idAccion=9 and idProceso=".$idProceso." and idPerfil=".$idPerfil;
					
						
					$fila=$con->obtenerPrimeraFila($consulta);
					$fila[3]=1;
					if($fila)
					{
						switch($fila[3])
						{
							case 1:  //Todos
							break;
							case 2: // En su institucion
								$aux=" codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
							break;
							case 3: // registados en su departamento y subdepartamentos
								$aux=" (codigoUnidad = '".$_SESSION["codigoUnidad"]."' or codigoUnidad like '".$_SESSION["codigoUnidad"]."%')";
							break;
							case 4: //registados en su departamento
								$aux=" codigoUnidad='".$_SESSION["codigoUnidad"]."'";
							break;
							case 5: //Solo en lo que el participa
							break;
							default:
								$aux="1=1";
						}
					}
					else
					{
						$aux=" and 1=1";
					}
				}
				else
				{
						$aux=" and (".$condWhereAmbito.")";
				}
				$consulta="select id_".$nTabla." from ".$nTabla." ".$condWhere.$aux;

				
				
				$listadoRegistro=$con->obtenerListaValores($consulta);
				if($listadoRegistro=="")
					$listadoRegistro="-1";
				$condWhere=" where id_".$nTabla." in (".$listadoRegistro.")";	
				
				
			break;
			
		}
		
		
					
		$consulta="SELECT configuracionExtra FROM 909_configuracionTablaFormularios WHERE idConfGrid=".$idConfiguracion;

		$fConfExtra=$con->obtenerPrimeraFila($consulta);
		
		if($fConfExtra[0]!="")
		{
			$oConfExtra=json_decode($fConfExtra[0]);

			if(isset($oConfExtra->condWherePrincipal))
			{
				$condWhere=" where ".$oConfExtra->condWherePrincipal;
				$condWhere=str_replace('@usuario',$_SESSION["idUsr"],$condWhere);
				$condWhere=str_replace('@UnidadUsuario',$_SESSION["codigoUnidad"],$condWhere);
				$condWhere=str_replace('@instUsuario',$_SESSION["codigoInstitucion"],$condWhere);	
				$condWhere=str_replace('@roles',$_SESSION["idRol"],$condWhere);	
				
				
			}
		}
		
		if($condWhere=="")
			$condWhere=" where idEstado<>1984 ";
		else
			$condWhere.=" and idEstado<>1984 ";

		
		$consulta="select idTipoProceso FROM 4001_procesos WHERE idProceso=".$idProceso;
		$tipoProceso=$con->obtenerValor($consulta);
		if($idReferencia=="")
			$idReferencia=-1;
		$cadObj='{"p16":{"p1":"'.$idFormulario.'","p2":"'.$idProceso.'","p3":"-1","p4":"-1","p5":"'.$idReferencia.'","p6":"-1"}}';
		$paramObj=json_decode($cadObj);
		$arrQueries=resolverQueries($idFormulario,5,$paramObj,false,true);
		
		
		$consulta="select nombreTabla,idFrmEntidad,complementario from 900_formularios where idFormulario=".$idFormulario;
		$fila=$con->obtenerPrimeraFila($consulta);
		$tablaFormulario=$fila[0];
		$complementario=$fila[2];
		$condFiltro="";
		$filtroUsuario="";
		$consulta="select idFiltro from 915_confGridVSRol where idConfGrid=".$idConfiguracion." and idRol='".$idActor."' and tipoFiltro=0";

		$idFiltro=$con->obtenerValor($consulta);
		if($idFiltro=="")
		{
			$consulta="select idFiltro from 915_confGridVSRol where idConfGrid=".$idConfiguracion." and idRol='".$idActor."' and tipoFiltro=1";

			$idFiltro=$con->obtenerValor($consulta);
			if($idFiltro=="")
				$idFiltro="-1";
		}

		$consulta="select tokenMysql from 917_consultasFiltroGrid where idFiltro=".$idFiltro;
		
		
		
		$res=$con->obtenerFilas($consulta);
		$consultaConf="";
		while($fila=$con->fetchRow($res))
		{
			$consultaConf.=$fila[0]." ";
		}
		
		if($consultaConf!="")
		{
			$consultaConf=str_replace('@usuario',$_SESSION["idUsr"],$consultaConf);
			$consultaConf=str_replace('@UnidadUsuario',$_SESSION["codigoUnidad"],$consultaConf);
			$consultaConf=str_replace('@instUsuario',$_SESSION["codigoInstitucion"],$consultaConf);
			$consultaConf=" and (".$consultaConf.")";
			
			if($parametrosProceso)
			{
				
				$reflectionClase = new ReflectionObject($parametrosProceso);
				foreach ($reflectionClase->getProperties() as $property => $value) 
				{
					$nombre=$value->getName();
					$valor=$value->getValue($parametrosProceso);
					
					$consultaConf=str_replace('['.$nombre.']',$valor,$consultaConf);
					
					
				}
				
			}
			
			
			
		}
		

		
		if($fGlobalInterno!="")
		{
			$condWhere=" where ".$fGlobalInterno." ".str_replace(" where "," and ",$condWhere);
		}
		
		$filtroGlobal="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				if(($arrFiltro[$x]["field"]!="responsableCreacion")&&($arrFiltro[$x]["field"]!="responsableModificacion"))
				{
					if($arrFiltro[$x]["field"]=="idRegistro")
						$arrFiltro[$x]["field"]="id__".$idFormulario."_tablaDinamica";
					switch($arrFiltro[$x]["data"]["tipoCampo"])
					{
					
						case 4:
							if($filtroGlobal=="")
								$filtroGlobal=$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
							else
								$filtroGlobal.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
						break;
						default:
							$condFiltro.=" and ".formatearFiltro($arrFiltro[$x]);
						break;	
					}
				}
				else
				{
					
					
					if($filtroUsuario=="")
						$filtroUsuario=" where ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					else
						$filtroUsuario.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					
					
					
				}
			}
		}		
		
		$arrCamposProyeccion=array();

		if($con->existeTabla($tablaFormulario))
		{
				//Valores directos de tabla
			$consulta="	select e.nombreCampo,e.idGrupoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where tipoElemento not in(-1,0,1,2,4,14,16,30) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";
			
			$listaCampos=$con->obtenerListaValores($consulta,"`");
			$camposAux="id_".$tablaFormulario." as idRegistro,responsable,codigoUnidad,idEstado as idEtapaRegistro,".$listaCampos;

			$arrCamposProyeccion["idRegistro"]=1;
			$arrCamposProyeccion["responsable"]=1;
			$arrCamposProyeccion["codigoUnidad"]=1;
			$arrCamposProyeccion["idEtapaRegistro"]=1;
			
			$aAux=explode(",",$listaCampos);
			foreach($aAux as $c)
			{
				$arrCamposProyeccion[str_replace("`","",$c)]=1;
			}
			
			
			//valor de contenidos en otras tablas
			$consulta="	select e.nombreCampo,e.idGrupoElemento,e.tipoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where (tipoElemento=4 or tipoElemento=16) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";
			$res=$con->obtenerFilas($consulta);
			$camposRefTablas="";
			while($filas=$con->fetchRow($res))
			{
				
				$consultaRefTablas=generarConsultaIdElementoTablaExterna($filas[1],$arrQueries,$idFormulario);	
				if(strpos($consultaRefTablas,"= responsable")!==false)
				{
					$consultaRefTablas=str_replace("= responsable","= ".$tablaFormulario.".responsable",$consultaRefTablas);
				}

				
				if(strpos($consultaRefTablas,"DATE_FORMAT(fechaCreacion,")!==false)
				{
					$consultaRefTablas=str_replace("DATE_FORMAT(fechaCreacion,","DATE_FORMAT(_".$idFormulario."_tablaDinamica.fechaCreacion,",$consultaRefTablas);
				}
				
				$camposRefTablas.=",".$consultaRefTablas." as `".$filas[0]."`";

				$arrCamposProyeccion[$filas[0]]=1;
			}
			
			//valor de opciones ingresadas por el usuario manualmente
			$consulta="	select e.nombreCampo,e.idGrupoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where (tipoElemento=2 or tipoElemento=14) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";

			$res=$con->obtenerFilas($consulta);
			$camposRefOpciones="";
			while($filas=$con->fetchRow($res))
			{

				$consultaRefTablas="(select contenido from 902_opcionesFormulario where idIdioma=".$_SESSION["leng"]." and idGrupoElemento=".$filas[1]." and valor=".$tablaFormulario.".".$filas[0]." )";
				$camposRefOpciones.=",".$consultaRefTablas." as `".$filas[0]."`";
				$arrCamposProyeccion[$filas[0]]=1;
			}
			
			$consulta="SELECT e.nombreCampo,e.idGrupoElemento FROM 901_elementosFormulario e,907_camposGrid cg 
						WHERE (tipoElemento=30) AND cg.idElementoFormulario=e.idGrupoElemento AND cg.idConfGrid=".$idConfiguracion." ORDER BY idGrupoCampo";

			$res=$con->obtenerFilas($consulta);
		
			while($filas=$con->fetchRow($res))
			{
				
				$consultaRefTablas="";
				$queryConf="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[1];
				
				$filaConf=$con->obtenerPrimeraFila($queryConf);
				
				$tablaD=$filaConf[2];
				$campoP=$filaConf[3];
				$campoId=$filaConf[4];
				$idAlmacen=str_replace("[","",$tablaD);
				$idAlmacen=str_replace("]","",$idAlmacen);
				
				$consulta="SELECT configuracion FROM 907_camposGrid WHERE idElementoFormulario=".$filas[1];
				$conf=$con->obtenerValor($consulta);
				if($conf!='')
				{
					$obj=json_decode($conf);
					if(isset($obj->consultaReemplazo)&&($obj->consultaReemplazo!=""))
						$idAlmacen=$obj->consultaReemplazo;
				}
				

				

				if($arrQueries[$idAlmacen]["ejecutado"]==1)
				{
					

					
					$arrCampos=str_replace("@@",",",$campoP);

					$normalizado=normalizarQueryProyeccionOptimizacion($arrQueries[$idAlmacen]["query"],$arrCampos);
					$normalizado=str_replace("select concat","SELECT GROUP_CONCAT(CONCAT",$normalizado);

					$normalizado=str_replace(") from",")) FROM",$normalizado);

					$compOr="";
					if(strpos($normalizado,"where")!==false)
					{
						$arrComp=explode(" order ",$normalizado);
						$normalizado=$arrComp[0];
						if(sizeof($arrComp)>1)
						{
							$compOr.=" order ".$arrComp[1];
						}

					}
					else
					{
						
						$arrComp=explode(" order ",$normalizado);
						$normalizado=$arrComp[0];
						$normalizado.=" where 1=1";
						if(sizeof($arrComp)>1)
						{
							$compOr.=" order ".$arrComp[1];
						}
					}
					
					if($arrQueries[$idAlmacen]["idConexion"]==0)
						$consultaRefTablas="(".$normalizado." ".$compOr." limit 0,1)";
					else
					{
						$arrConsultaNormaliza=explode(" where ",$normalizado);
						$consultaRefTablas=str_replace("concat",$campoId.", concat",$arrConsultaNormaliza[0]);
						$conAux=$arrQueries[$idAlmacen]["conector"];
						$resAux=$conAux->obtenerFilas($consultaRefTablas);
						$consultaRefTablas="(SELECT (CASE ".$tablaFormulario.".".$filas[0]." ";
						while($filaAux=$conAux->obtenerSiguienteFila($resAux))
						{
							$consultaRefTablas.=" WHEN ".$filaAux[0]." THEN '".$filaAux[1]."'";
						}
						$consultaRefTablas.=" END))";
						
					}
				/*	echo $consultaRefTablas."<br>";*/
				}
				else
					$consultaRefTablas="'Query No resuelta'";
					
				
				foreach($arrQueries[$idAlmacen]["camposFormularioReferencia"] as $campo)	
				{
					$consultaRefTablas=str_replace("'[_".$campo."_]'",$tablaFormulario.".".$campo,$consultaRefTablas);
				}
					
					
				$camposRefOpciones.=",(".$consultaRefTablas.") as `".$filas[0]."`";
				$arrCamposProyeccion[$filas[0]]=1;
			}

			//valores de variables de sistema
			$consulta="select campoUsr
						 as nombreCampo
						 ,cg.idElementoFormulario
						 from 907_camposGrid cg,9017_camposControlFormulario cc where cc.tipoElemento=cg.idElementoFormulario and
						 cg.idIdioma=".$_SESSION["leng"]." and cg.idElementoFormulario<0 and cg.idConfGrid=".$idConfiguracion;

			$res=$con->obtenerFilas($consulta);	
			$camposRefSistema="";
			while($filas=$con->fetchRow($res))
			{
				switch($filas[1])
				{
					case "-11":
					case "-13":
						$consultaRefSistema="(select concat(Paterno,' ',Materno,' ',Nom) from 802_identifica where idUsuario=".$tablaFormulario.".responsable)";
					break;
					case "-10":
						$consultaRefSistema="fechaCreacion";
					break;
					case "-12":
						$consultaRefSistema="fechaModif";
					break;
					case "-14":
						$consultaRefSistema="(select Unidad  from 817_organigrama where codigoUnidad=".$tablaFormulario.".codigoUnidad)";
					break;
					case "-15":
						$consultaRefSistema="(select Unidad  from 817_organigrama where codigoUnidad=".$tablaFormulario.".codigoInstitucion)";
					break;
					case "-16":
						$consultaRefSistema="dtefechaSolicitud";
					break;
					case "-17":
						$consultaRefSistema="tmeHoraInicio";
					break;
					case "-18":
						$consultaRefSistema="tmeHoraFin";
					break;
					case "-19":
						$consultaRefSistema="dteFechaAsignada";
					break;
					case "-20":
						$consultaRefSistema="tmeHoraInicialAsignada";
					break;
					case "-21":
						$consultaRefSistema="tmeHoraFinalAsignada";
					break;
					case "-22":
						$consultaRefSistema="unidadReservada";
					break;
					case "-23":
						$consultaRefSistema="tmeHoraSalida";
					break;
					case "-24":
						$query="select idProceso from 900_formularios where idFormulario=".$idFormulario;
						$idProceso=$con->obtenerValor($query);
						$consultaRefSistema="(select concat(numEtapa,'.- ',nombreEtapa) from 4037_etapas where numEtapa=idEstado and idProceso=".$idProceso.")";
					break;
					case "-25":
						$consultaRefSistema="codigo";
					break;
					case "-27":
						$consultaRefSistema="(SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE 
											idFormulario=".$idFormulario." AND idRegistro=".$tablaFormulario.".id_".$tablaFormulario." ORDER BY fechaCambio DESC LIMIT 0,1)";
					break;
					case "-28":
						$consultaRefSistema="id__".$idFormulario."_tablaDinamica";
					break;
				}
				$camposRefSistema.=",".$consultaRefSistema." as `".$filas[0]."`";

				$arrCamposProyeccion[$filas[0]]=1;
			}

			if($condWhere=="")
				$condWhere=" where 1=1 ";
			
			if(($idReferencia!="")&&($idReferencia!='-1'))
			{
				$condWhere="where 1=1 and idReferencia=".$idReferencia;
				
			}
			if($idProcesoPadre!=-1)	
				$condWhere.=" and idProcesoPadre=".$idProcesoPadre;
				
			if($tipoProceso==1)
			{
				
				
				if(strpos($complementario,"{")!==false)
				{
					$obj=json_decode($complementario);
					switch($obj->condicion) //1 repgistrado por uss, 2 registrado en su depto; 3 registrado en su depto y subdepto;
					{
						case "1":
							$condWhere.=" and responsable=".$_SESSION["idUsr"];	
						break;
						case "2":
							$condWhere.=" and codigoUnidad='".$_SESSION["codigoUnidad"]."'";	
						break;
						case "3":
							$condWhere.=" and (codigoUnidad='".$_SESSION["codigoUnidad"]."' or codigoUnidad like '".$_SESSION["codigoUnidad"]."%')";	
						break;
						case "4":
							$condWhere.=" and (codigoInstitucion='".$_SESSION["codigoInstitucion"]."')";	
						break;
					}
				}
				
			}	
			$orden="";
			
			
			
			$campoAgrupador="";
			$consulta="  SELECT campoAgrupacion FROM 909_configuracionTablaFormularios f WHERE f.idFormulario=".$idFormulario;
			$campoAgrupador=$con->obtenerValor($consulta);
			
			$campoProyOrden="";
			
			if(($campoAgrupador!="")&&($campoAgrupador!="0"))
			{
				$orden=" order by ".$campoAgrupador;
				if(!isset($arrCamposProyeccion[$campoAgrupador]))
					$campoProyOrden=",".$campoAgrupador;
					
				
			}
			
			$campoOrden=$_POST["sort"];
			if($campoOrden!="")
			{
				$consulta="select campoMysql from 9017_camposControlFormulario where campoUsr='".$campoOrden."'";
				$campoO=$con->obtenerValor($consulta);
				if($campoO!="")
					$campoOrden=$campoO;
				
				if($orden=="")
					$orden=" order by ";
				else
					$orden.=", ";
				$orden.=$campoOrden." ".$_POST["dir"];
				
				if(!isset($arrCamposProyeccion[$campoOrden]))
				{
					if($campoProyOrden=="")
						$campoProyOrden=",".$campoOrden;
					else
						$campoProyOrden.=",".$campoOrden;
				}
				
				
			}

			if($filtroGlobal!="")
			{
				if($filtroUsuario=="")
					$filtroUsuario=" where ".$filtroGlobal;
				else
					$filtroUsuario=" and ".$filtroGlobal;
			}
			
			if($fGlobalExterno!="")
			{
				if($filtroUsuario=="")
					$filtroUsuario=" where ".$fGlobalExterno;
				else
					$filtroUsuario=" and ".$fGlobalExterno;
			}


	
			$consulta2="select * from (select ".$camposAux.$camposRefTablas.$camposRefOpciones.$camposRefSistema.$campoProyOrden." from ".$tablaFormulario." ".$condWhere." ".$consultaConf." ".$condFiltro.") as vQuery ".$filtroUsuario." ".$orden;
			

			if($filtroUsuario=="")
			{
				$consulta2="select count(*) from ".$tablaFormulario." ".$condWhere." ".$consultaConf." ".$condFiltro." ".$orden;
			}
			if($posMax>=0)
			{
				if($filtroUsuario!="")
				{
					$consulta="select * from (select ".$camposAux.$camposRefTablas.$camposRefOpciones.$camposRefSistema.$campoProyOrden." from ".$tablaFormulario." ".$condWhere." ".$consultaConf." ".$condFiltro.") as vQuery ".$filtroUsuario." ".$orden.
								" limit ".$posMin.",".$posMax;
				}
				else
				{
					$consulta="select ".$camposAux.$camposRefTablas.$camposRefOpciones.$camposRefSistema.$campoProyOrden." from ".$tablaFormulario." ".$condWhere." ".$consultaConf." ".$condFiltro." ".$orden." limit ".$posMin.",".$posMax;
				}
				$consulta=str_replace(',,',',',$consulta);
			}
			else
				$consulta=$consulta2;		
			
			

			$consulta2=str_replace(',,',',',$consulta2);
			$consulta2=str_replace("'distinct ","'",$consulta2);
			$consulta=str_replace("'distinct ","'",$consulta);
			$consulta=str_replace(',,',',',$consulta);
			
			
			$numElementos=$con->obtenerValor($consulta2);
			if($numElementos=="")
				$numElementos=0;
			$arrObj="";
			

			$res=$con->obtenerFilas($consulta);
	
			$nPosReg=($posMin)+1;
			while($fila=$con->fetchRow($res))
			{
				$ct=sizeof($fila);
				$obj="{";
				$arrCmp="";
				for($x=0;$x<$ct;$x++)
				{
					$nomCampo=$con->fieldName($res,$x);
					$cmp='"'.$nomCampo.'":"'.dv(str_replace('"','"',$fila[$x])).'"';
					if($arrCmp=="")
						$arrCmp=$cmp;
					else
						$arrCmp.=",".$cmp;
				}
				$participacion="";
				if(sizeof($arrParticipaciones)>0)
				{
					$participacion=$arrParticipaciones[$fila[0]]["claveParticipacion"];
				}
				
				$permisos="";
				$idActorRegistro=0;
				if(sizeof($arrActoresEtapa)>0)
				{

					if(isset($arrActoresEtapa[($fila[3]."")]))
					{
						$idActorRegistro=$arrActoresEtapa[($fila[3]."")]["idActorProcesoEtapa"];
						$permisos=$arrActoresEtapa[($fila[3]."")]["permisos"];
					}

						
				}
				
				if(($permisos!="")&&($tipoActor==1))
				{
					if($idFrmAutores!=-1)
					{
						if($arrParticipaciones[$fila[0]]["responsable"]==0)
							$permisos="";
					}
					else
					{

						//if($fila[1]!=$idUsuario)
							//$permisos="";
					}
				}
				
				if($arrCmp=="")
					$arrCmp='"noRegistroPag":"'.$nPosReg.'","permisos":"'.$permisos.'","idActorRegistro":"'.$idActorRegistro.'","participacion":"'.$participacion.'"';
				else
					$arrCmp.=',"noRegistroPag":"'.$nPosReg.'","permisos":"'.$permisos.'","idActorRegistro":"'.$idActorRegistro.'","participacion":"'.$participacion.'"';
				
				$obj.=$arrCmp."}";
				if($arrObj=="")
					$arrObj=$obj;
				else
					$arrObj.=",".$obj;	
				$nPosReg++;
			}
			$arrJson='{"numReg":"'.($numElementos==""?0:$numElementos).'",registros:['.utf8_encode($arrObj).']}';		
		}
		else
		{
			$arrJson='{"numReg":"0",registros:[]}';					
		}
		echo $arrJson;
	}
	
	function obtenerRegistrosVistaTableroControl()
	{
		global $con;
		global $versionLatis;
		$arrNotificaciones=array();
		$filtroAuxiliar=0;
		if(isset($_POST["filtroAuxiliar"]))
			$filtroAuxiliar=$_POST["filtroAuxiliar"];
		
		$consulta="SELECT idNotificacion,marcarAtendidaAbrir FROM 9067_notificacionesProceso ORDER BY idNotificacion";
		$resNotificaciones=$con->obtenerFilas($consulta);
		while($fNotificaciones=$con->fetchRow($resNotificaciones))
		{
			
			$arrNotificaciones[$fNotificaciones[0]]=$fNotificaciones[1];
		}
		$fechaActual=date("Y-m-d H:i:s");	
		
		$idUsuario=-1;
		if(isset($_POST["iU"]))
		{
			$idUsuario=$_POST["iU"];
			
			
			$consulta="select AES_DECRYPT(UNHEX('".$idUsuario."'), '".bD($versionLatis)."') as idUsuario";
			$idUsuario=$con->obtenerValor($consulta);
			
		}
		
		$idConfiguracion=bD($_POST["iT"]);
		
		$arrProcesos=array();
		$consulta="SELECT idProceso,nombre FROM 4001_procesos";
		$rProcesos=$con->obtenerFilas($consulta);
		while($fProcesos=$con->fetchRow($rProcesos))
		{
			$arrProcesos[$fProcesos[0]]=$fProcesos[1];
		}
		
		$horasAlertaPreventiva=obtenerConfiguracionTableroControl($idConfiguracion,"horasAlertaPreventiva");
		
		if($horasAlertaPreventiva==NULL)
		{
			
			
			$consulta="SELECT tiempoActualizacion,registrosPagina,visibleBarraNotificaciones,horasAlertaPreventiva FROM  9060_tablerosControl WHERE idTableroControl=".$idConfiguracion;
			$fConfiguracion=$con->obtenerPrimeraFila($consulta);
			$horasAlertaPreventiva=$fConfiguracion[3];
		
			$consulta="SELECT valor FROM 9062_configuracionUsuarioTableroControl WHERE idTableroControl=".$idConfiguracion." AND idUsuario=".$idUsuario." AND tipoConfiguracion=1";	
			$horasUsuario=$con->obtenerValor($consulta);
			if($horasUsuario!="")
				$horasAlertaPreventiva=$horasUsuario;	
				
			registrarConfiguracionTableroControl($idConfiguracion,"horasAlertaPreventiva",$horasAlertaPreventiva);
					
				
		}
		
		
		$posMin=$_POST["start"];
		$posMax=$_POST["limit"];
		
		$sort="";
		$dir="";
		if(isset($_POST["sort"]))
		{
			$sort=$_POST["sort"];
			$dir=$_POST["dir"];
		}
		
		
		$orden="";
		if($sort!="")
			$orden=$sort." ".$dir;
		else
		{
			$consulta="SELECT GROUP_CONCAT(CONCAT(nombreCampo,' ',orden)) AS orden FROM 9066_configuracionOrdenTableroControl WHERE idTableroControl=".$idConfiguracion;
			$orden=$con->obtenerListaValores($consulta);
		}
		
		$cadFiltrosGlobales="";
		if(isset($_POST["arrFiltroGlobal"]))
			$cadFiltrosGlobales=bD($_POST["arrFiltroGlobal"]);
		
		
		$fGlobalInterno="";
		$fGlobalExterno="";
		
		if($cadFiltrosGlobales!="")
		{
			$objFiltroGlobal=json_decode($cadFiltrosGlobales);
			
			foreach($objFiltroGlobal->filtros as $f)
			{
				$condicionGlobal=$f->campo." ".urldecode($f->condicion);
				if($f->busquedaInterna==1)
				{
					if($fGlobalInterno=="")		
						$fGlobalInterno=$condicionGlobal;
					else
						$fGlobalInterno.=" and ".$condicionGlobal;	
						
				}
				else
				{
					if($fGlobalExterno=="")		
						$fGlobalExterno=$condicionGlobal;
					else
						$fGlobalExterno.=" and ".$condicionGlobal;	
				}
					
			}
			
		}
		
		
		$idRegistro="0";		

		$nombreTabla="9060_tableroControl_".$idConfiguracion;
		$cadCondWhere="(idUsuarioDestinatario=".$idUsuario;
		
		
		$cadCondWhere.=")";
		if($fGlobalInterno!="")
			$cadCondWhere.=" and ".$fGlobalInterno;
		
		if(isset($_POST["filter"]))
			$cadCondWhere.=" and ".generarCadenaConsultasFiltro($_POST["filter"]);
		
		$arrCamposProyeccion=array();

		if($con->existeTabla($nombreTabla))
		{
			$consulta="SELECT nombreCampo FROM 9061_camposTableroControl WHERE idTableroControl=".$idConfiguracion." AND nombreCampo not in('idRegistro','contenidoMensaje',
						'iFormulario','iRegistro','iReferencia','objConfiguracion','permiteAbrirProceso','tipoNotificacion','fechaVisualizacion') ORDER BY orden";	
			$listaCampos=$con->obtenerListaValores($consulta);
			if($listaCampos!="")
				$listaCampos=",".$listaCampos;
			
			$nFilas=0;
			$resRegistros=null;
			if($filtroAuxiliar==0)
			{
				$consulta="select count(*) from ".$nombreTabla." where ".$cadCondWhere;
				
				$nFilas=$con->obtenerValor($consulta);			
				
				$consulta="select idRegistro,contenidoMensaje,iFormulario,iRegistro,iReferencia,objConfiguracion,permiteAbrirProceso,
							tipoNotificacion,idNotificacionBase,(select usuarioDestinatario from ".$nombreTabla." t where t.idRegistro=tb.idNotificacionBase) as delegadaPor,".
							"(SELECT COUNT(*) FROM 9060_tableroControl_".$idConfiguracion." WHERE idNotificacionBase=tb.idRegistro) as nTurnados".$listaCampos.",
							if (fechaLimiteAtencion<'".$fechaActual."',2,if(DATE_ADD(fechaLimiteAtencion, Interval - ".$horasAlertaPreventiva." hour)<='".$fechaActual."',1,0)) as statusNotificacion,
							fechaVisualizacion,idNotificacion from ".$nombreTabla.
							  " tb where ".$cadCondWhere." order by ".$orden." limit ".$posMin.",".$posMax;
				
				
			}
			else
			{
				$consulta="select count(*) from (select idRegistro,contenidoMensaje,iFormulario,iRegistro,iReferencia,objConfiguracion,permiteAbrirProceso,
							tipoNotificacion,idNotificacionBase,(select usuarioDestinatario from ".$nombreTabla." t where t.idRegistro=tb.idNotificacionBase) as delegadaPor,".
							"(SELECT COUNT(*) FROM 9060_tableroControl_".$idConfiguracion." WHERE idNotificacionBase=tb.idRegistro) as nTurnados".$listaCampos.",
							if (fechaLimiteAtencion<'".$fechaActual."',2,if(DATE_ADD(fechaLimiteAtencion, Interval - ".$horasAlertaPreventiva." hour)<='".$fechaActual."',1,0)) as statusNotificacion,
							fechaVisualizacion,idNotificacion from ".$nombreTabla.
							  " tb where ".$cadCondWhere." order by ".$orden.") as tmp where statusNotificacion=".$filtroAuxiliar;
				
				$nFilas=$con->obtenerValor($consulta);			
				
				$consulta="select * from (select idRegistro,contenidoMensaje,iFormulario,iRegistro,iReferencia,objConfiguracion,permiteAbrirProceso,
							tipoNotificacion,idNotificacionBase,(select usuarioDestinatario from ".$nombreTabla." t where t.idRegistro=tb.idNotificacionBase) as delegadaPor,".
							"(SELECT COUNT(*) FROM 9060_tableroControl_".$idConfiguracion." WHERE idNotificacionBase=tb.idRegistro) as nTurnados".$listaCampos.",
							if (fechaLimiteAtencion<'".$fechaActual."',2,if(DATE_ADD(fechaLimiteAtencion, Interval - ".$horasAlertaPreventiva." hour)<='".$fechaActual."',1,0)) as statusNotificacion,
							fechaVisualizacion,idNotificacion from ".$nombreTabla.
							  " tb where ".$cadCondWhere." order by ".$orden.") as tmp  where statusNotificacion=".$filtroAuxiliar." limit ".$posMin.",".$posMax;
			}
			$resRegistros=$con->obtenerFilas($consulta);
			$arrRegistros="";
			while($fRegistro=$con->fetchAssoc($resRegistros))
			{
				$oReg='"marcarAtendidaAbrir":"'.(isset($arrNotificaciones[$fRegistro["idNotificacion"]])?$arrNotificaciones[$fRegistro["idNotificacion"]]:0).'"';

				foreach($fRegistro as $campo=>$valor)
				{
					
						
					if($campo=="iReferencia")
					{
						if(($fRegistro["iFormulario"]!="")&&(($fRegistro["iFormulario"]!="-1")))
						{
							if($fRegistro["iFormulario"]==123)
							{
	
								$consulta="SELECT iFormulario FROM _123_tablaDinamica WHERE id__123_tablaDinamica=".$fRegistro["iRegistro"];
								$iFrm=$con->obtenerValor($consulta);
								$idProceso=obtenerIdProcesoFormulario($iFrm);
								$valor=$arrProcesos[$idProceso];
							}
							else
							{
								$idProceso=obtenerIdProcesoFormulario($fRegistro["iFormulario"]);
								if(($idProceso!="")&&(isset($arrProcesos[$idProceso])))
									$valor=$arrProcesos[$idProceso];
							}
							
							if($valor=="-1")
								$valor="";
						}
					}
					
					if($oReg=="")
						$oReg='"'.$campo.'":"'.cv($valor).'"';
					else
						$oReg.=',"'.$campo.'":"'.cv($valor).'"';
				}
				$oReg='{'.$oReg.'}';
				if($arrRegistros=="")
					$arrRegistros=$oReg;
				else
					$arrRegistros.=",".$oReg;
			}
			
			$cadQueryComp="";
			
			$numRegistrosActivos=0;
			$consulta="SELECT COUNT(*) FROM ".$nombreTabla." WHERE (idUsuarioDestinatario=".$idUsuario.$cadQueryComp.") and idEstado=1";
			$numRegistrosActivos=$con->obtenerValor($consulta);
			$arrJson='{"numReg":'.$nFilas.',"numRegistrosActivos":"'.$numRegistrosActivos.'","registros":['.$arrRegistros.']}';		
		}
		else
		{
			$arrJson='{"numReg":"0",registros:[]}';					
		}
		echo $arrJson;
	}
	
	function obtenerRegistrosVistaTableroControlTemporizador()
	{
		global $con;
		global $versionLatis;
		$idConfiguracion=bD($_POST["iT"]);
		
		$idUsuario=-1;
		if(isset($_POST["iU"]))
		{
			$idUsuario=$_POST["iU"];
			$consulta="select AES_DECRYPT(UNHEX('".$idUsuario."'), '".bD($versionLatis)."') as idUsuario";
			$idUsuario=$con->obtenerValor($consulta);

		}
		
		$fechaActual=date("Y-m-d H:i:s");	
		
		$cadQueryComp="";
		if(existeRol("'112_0'"))
		{
			$cadQueryComp=" or idUsuarioDestinatario=1";
		}
		
		$horasAlertaPreventiva=obtenerConfiguracionTableroControl($idConfiguracion,"horasAlertaPreventiva");
		
		if($horasAlertaPreventiva==NULL)
		{
			$consulta="SELECT tiempoActualizacion,registrosPagina,visibleBarraNotificaciones,horasAlertaPreventiva FROM  9060_tablerosControl WHERE idTableroControl=".$idConfiguracion;
			$fConfiguracion=$con->obtenerPrimeraFila($consulta);
			$horasAlertaPreventiva=$fConfiguracion[3];
		
			$consulta="SELECT valor FROM 9062_configuracionUsuarioTableroControl WHERE idTableroControl=".$idConfiguracion." AND idUsuario=".$idUsuario." AND tipoConfiguracion=1";	
			$horasUsuario=$con->obtenerValor($consulta);
			if($horasUsuario!="")
				$horasAlertaPreventiva=$horasUsuario;	
				
			registrarConfiguracionTableroControl($idConfiguracion,"horasAlertaPreventiva",$horasAlertaPreventiva);
		}
	
	
		$ultimaFechaAsignacion=obtenerConfiguracionTableroControl($idConfiguracion,"ultimaFechaAsignacion");
		
		
		if($ultimaFechaAsignacion==NULL)
		{
			$ultimaFechaAsignacion=$fechaActual;
			registrarConfiguracionTableroControl($idConfiguracion,"ultimaFechaAsignacion",$ultimaFechaAsignacion);
		}
		
		$idRegistro="0";	
		$nombreTabla="9060_tableroControl_".$idConfiguracion;		
		
		$objResultado='{"registrosPendientes":"0","registrosVencidos":"0","registrosNuevos":"0"}';
		
		
		
		
		if($con->existeTabla($nombreTabla))
		{
			
			$consulta="SELECT COUNT(*) FROM ".$nombreTabla." WHERE (idUsuarioDestinatario=".$idUsuario.$cadQueryComp.") and idEstado=1";
			$registrosPendientes=$con->obtenerValor($consulta);
			
			$consulta="SELECT COUNT(*) FROM ".$nombreTabla." WHERE (idUsuarioDestinatario=".$idUsuario.$cadQueryComp.") and idEstado=2";
			$totalTareas=$con->obtenerValor($consulta);
			
			$consulta="SELECT COUNT(*) FROM ".$nombreTabla." WHERE (idUsuarioDestinatario=".$idUsuario.$cadQueryComp.") and idEstado=1 and fechaAsignacion>='".$ultimaFechaAsignacion."' and fechaVisualizacion is null";
			$registrosNuevos=$con->obtenerValor($consulta);
			
			
			$consulta="SELECT COUNT(*) FROM ".$nombreTabla." WHERE (idUsuarioDestinatario=".$idUsuario.$cadQueryComp.") and idEstado=1 AND fechaLimiteAtencion<'".$fechaActual."'";
			$registrosVencidos=$con->obtenerValor($consulta);
			
			$consulta="SELECT COUNT(*) FROM ".$nombreTabla." WHERE (idUsuarioDestinatario=".$idUsuario.$cadQueryComp.") and idEstado=1 AND DATE_ADD(fechaLimiteAtencion, Interval - ".$horasAlertaPreventiva." hour)<='".$fechaActual."' and fechaLimiteAtencion>'".$fechaActual."'";
			$registrosPorVencer=$con->obtenerValor($consulta);
			
			$objResultado='{"registrosPendientes":'.$registrosPendientes.',"registrosVencidos":'.$registrosVencidos.
						',"registrosPorVencer":'.$registrosPorVencer.',"registrosNuevos":'.$registrosNuevos.
						',"totalTareasAtendidas":"'.$totalTareas.'"}';
			
		}
		
			
		echo "1|".$objResultado;
	}
	
	function actualizarConfiguracionUsuarioTableroControl()
	{
		global $con;
		$tipoValor=$_POST["tipoValor"];
		$valor=$_POST["valor"];
		$iT=$_POST["iT"];
		
		
		$consulta="SELECT idRegistro FROM 9062_configuracionUsuarioTableroControl WHERE idTableroControl=".$iT." AND idUsuario=".$_SESSION["idUsr"]." AND tipoConfiguracion=".$tipoValor;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 9062_configuracionUsuarioTableroControl(idUsuario,tipoConfiguracion,valor,idTableroControl) VALUES(".$_SESSION["idUsr"].",".$tipoValor.",'".cv($valor)."',".$iT.")";
		}
		else
		{
			$consulta="update 9062_configuracionUsuarioTableroControl set valor='".cv($valor)."' where idRegistro=".$idRegistro;
		}
		if($con->ejecutarConsulta($consulta))
		{
			switch($tipoValor)
			{
				case 1:
					registrarConfiguracionTableroControl($iT,"horasAlertaPreventiva",$valor);
				break;
			}
		}
		echo "1|";
	}
	
	function obtenerUsuariosTareasTurnadas()
	{
		global $con;
		$iA=$_POST["idActividad"];
		$arrTareas="";
		$consulta="SELECT idRegistro,idUsuarioAtendio,usuarioDestinatario,fechaAtencion,fechaAsignacion,fechaVisualizacion,idUsuarioDestinatario FROM 9060_tableroControl_4 WHERE idNotificacionBase=".$iA;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			
			$arrTareaHijas=obtenerDelegacionesTarea($fila["idRegistro"]);
			
			$fechaAsignacion=date("d/m/Y H:i:s",strtotime($fila["fechaAsignacion"]));
			$fechaVisualizacion="------";
			if($fila["fechaVisualizacion"]!="")
				$fechaVisualizacion=date("d/m/Y H:i:s",strtotime($fila["fechaVisualizacion"]));
			$fechaAtencion="------";
			if($fila["fechaAtencion"]!="")
				$fechaAtencion=date("d/m/Y H:i:s",strtotime($fila["fechaAtencion"]));
			
			$oTarea='{"id":"'.$fila["idRegistro"].'","usuariosAsignado":"<span title=\''.cv($fila["usuarioDestinatario"]).'\' alt=\''.cv($fila["usuarioDestinatario"]).'\'>'.cv($fila["usuarioDestinatario"]).
				'</span>","fechaAsignacion":"'.$fechaAsignacion.'","fechaVisualizacion":"'.$fechaVisualizacion.'","atendio":"'.
				($fila["idUsuarioAtendio"]==$fila["idUsuarioDestinatario"]?"../images/accept_green.png":"").
				'","fechaAtencion":"'.$fechaAtencion.'","icon":"../images/user_go.png","leaf":'.($arrTareaHijas==""?"true":"false").
				',"children":['.$arrTareaHijas.'],"expanded":true}';
			if($arrTareas=="")
				$arrTareas=$oTarea;
			else
				$arrTareas.=",".$oTarea;
		}
		
		echo "[".$arrTareas."]";
	}

	function obtenerDelegacionesTarea($iA)
	{
		global $con;
		
		$arrTareas="";
		$consulta="SELECT idRegistro,idUsuarioAtendio,usuarioDestinatario,fechaAtencion,fechaAsignacion,
					fechaVisualizacion,idUsuarioDestinatario FROM 9060_tableroControl_4 WHERE idNotificacionBase=".$iA;
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			
			$arrTareaHijas=obtenerDelegacionesTarea($fila["idRegistro"]);
			
			$fechaAsignacion=date("d/m/Y H:i:s",strtotime($fila["fechaAsignacion"]));
			$fechaVisualizacion="------";
			if($fila["fechaVisualizacion"]!="")
				$fechaVisualizacion=date("d/m/Y H:i:s",strtotime($fila["fechaVisualizacion"]));
			$fechaAtencion="------";
			if($fila["fechaAtencion"]!="")
				$fechaAtencion=date("d/m/Y H:i:s",strtotime($fila["fechaAtencion"]));
			
			$oTarea='{"id":"'.$fila["idRegistro"].'","usuariosAsignado":"<span title=\''.cv($fila["usuarioDestinatario"]).'\' alt=\''.cv($fila["usuarioDestinatario"]).'\'>'.cV($fila["usuarioDestinatario"]).
				'</span>","fechaAsignacion":"'.$fechaAsignacion.'","fechaVisualizacion":"'.$fechaVisualizacion.'","atendio":"'.
				($fila["idUsuarioAtendio"]==$fila["idUsuarioDestinatario"]?"../images/accept_green.png":"").
				'","fechaAtencion":"'.$fechaAtencion.'","icon":"../images/user_go.png","leaf":'.($arrTareaHijas==""?"true":"false").
				',"children":['.$arrTareaHijas.']}';
			if($arrTareas=="")
				$arrTareas=$oTarea;
			else
				$arrTareas.=",".$oTarea;
		}
		
		return $arrTareas;
	}

	function obtenerRegistrosAlertasNotificaciones()
	{
		global $con;
		global $versionLatis;
		
		$idUsuario=-1;
		
		if(isset($_POST["iU"]))
		{
			$idUsuario=$_POST["iU"];
			$consulta="select AES_DECRYPT(UNHEX('".$idUsuario."'), '".bD($versionLatis)."') as idUsuario";
			$idUsuario=$con->obtenerValor($consulta);
		}
		
		$consulta="SELECT Institucion FROM 801_adscripcion WHERE idUsuario=".$idUsuario;
		$unidadGestion=$con->obtenerValor($consulta);
		
		$fechaActual=date("Y-m-d");	
		$consulta="SELECT idRegistro FROM 7038_tiposAlertaNotificaciones";// WHERE considerarNotificacionDelDia=1
		$listaAlertasMostrar=$con->obtenerListaValores($consulta);
		if($listaAlertasMostrar=="")
			$listaAlertasMostrar=-1;
			
		
		$consulta="SELECT distinct a.*,r.fechaRecordatorio FROM 7036_alertasNotificaciones a,7006_carpetasAdministrativas c,7037_recordatoriosPreviosNotificacion r 
				WHERE c.carpetaAdministrativa=a.carpetaAdministrativa AND c.unidadGestion='".$unidadGestion."' AND a.situacion in(1,4) 
				AND (idTitularAlerta=".$idUsuario." OR idTitularAlerta IS NULL) and r.idAlertaNotificacion=a.idRegistro
				AND r.fechaRecordatorio<='".$fechaActual." 23:59:59' and a.tipoAlerta in(".$listaAlertasMostrar.") order by r.fechaRecordatorio desc";
		$con->obtenerFilas($consulta);
		$totalAlertas=$con->filasAfectadas;
		
		$consulta="SELECT distinct a.idRegistro,r.fechaRecordatorio FROM 7036_alertasNotificaciones a,7006_carpetasAdministrativas c,7037_recordatoriosPreviosNotificacion r  
				WHERE c.carpetaAdministrativa=a.carpetaAdministrativa AND c.unidadGestion='".$unidadGestion."' AND a.situacion in(1) 
				AND (idTitularAlerta=".$idUsuario." OR idTitularAlerta IS NULL) and r.idAlertaNotificacion=a.idRegistro
				AND r.fechaRecordatorio<='".$fechaActual." 23:59:59' and a.tipoAlerta in(".$listaAlertasMostrar.")";
		$listaRegistros=$con->obtenerListaValores($consulta);
		if($listaRegistros=="")
			$listaRegistros=-1;
		$totalAlertasNuevas=$con->filasAfectadas;
		
		
		$consulta="SELECT distinct a.idRegistro,a.carpetaAdministrativa,a.descripcion,r.fechaRecordatorio FROM 7036_alertasNotificaciones a,7006_carpetasAdministrativas c,
				7037_recordatoriosPreviosNotificacion r 
				WHERE c.carpetaAdministrativa=a.carpetaAdministrativa AND c.unidadGestion='".$unidadGestion."' AND a.situacion in(1,4) 
				AND (idTitularAlerta=".$idUsuario." OR idTitularAlerta IS NULL) and r.idAlertaNotificacion=a.idRegistro
				AND r.fechaRecordatorio<='".$fechaActual." 23:59:59' and a.tipoAlerta in(".$listaAlertasMostrar.") order by r.fechaRecordatorio desc limit 0,5";
		
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		$objResultado='{"totalAlertas":"'.$totalAlertas.'","registrosNuevos":"'.$totalAlertasNuevas.'","arrRegistros":'.$arrRegistros.'}';
		
			
		echo "1|".$objResultado;
	}


	function obtenerRegistrosInformacionAlertasNotificaciones()
	{
		global $con;
		
		$idUsuario=$_SESSION["idUsr"];
		
		if(isset($_POST["iU"]))
		{
			$idUsuario=bD($_POST["iU"]);
		}
		$periodoInicio="";
		if(isset($_POST["fI"]))
			$periodoInicio=$_POST["fI"];
		
		$periodoFin="";
		if(isset($_POST["fF"]))
			$periodoFin=$_POST["fF"];
		
		$cA="";
		if(isset($_POST["cA"]))
			$cA=$_POST["cA"];
		
		$situacion=0;
		if(isset($_POST["status"]))
			$situacion=$_POST["status"];
		
		$tAlerta=-1;
		$valorReferencia1=-1;
		$valorReferencia2=-1;
		
		if(isset($_POST["tAlerta"]))
			$tAlerta=$_POST["tAlerta"];
		
		
		if(isset($_POST["valorReferencia1"]))
			$valorReferencia1=$_POST["valorReferencia1"];
		
		if(isset($_POST["valorReferencia2"]))
			$valorReferencia2=$_POST["valorReferencia2"];
		
		$esRecordatorioDia=false;
		if(isset($_POST["esRecordatorioDia"]))
		{
			$esRecordatorioDia=true;
		}
		
		$consulta="SELECT Institucion FROM 801_adscripcion WHERE idUsuario=".$idUsuario;
		$unidadGestion=$con->obtenerValor($consulta);
		$arrRegistros="";
		$numReg=0;
		
		$arrTipoAlertas=array();
		$consulta="SELECT idRegistro,funcionApertura FROM 7038_tiposAlertaNotificaciones";
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchRow($res))
		{
			$arrTipoAlertas[$fila[0]]=$fila[1];
		}

		$consulta="SELECT idRegistro FROM 7038_tiposAlertaNotificaciones WHERE considerarNotificacionDelDia=1";//.($esRecordatorioDia?2:1);
		$listaAlertasMostrar=$con->obtenerListaValores($consulta);
		if($listaAlertasMostrar=="")
			$listaAlertasMostrar=-1;
		
		
		$consulta="SELECT distinct a.idRegistro,a.carpetaAdministrativa,a.descripcion,a.valorReferencia1,a.valorReferencia2,a.fechaRegistro,
					(select Nombre from 800_usuarios where idUsuario=a.responsableRegistro) as responsableRegistro,a.tipoAlerta,
					fechaRecordatorio as fechaAlerta,idTitularAlerta,a.situacion,motivoCancelacion as comentariosAlerta,
					(select Nombre from 800_usuarios where idUsuario=a.responsableCancelacion) as responsableCancelacion 
					FROM 7036_alertasNotificaciones a,7006_carpetasAdministrativas c,
					7037_recordatoriosPreviosNotificacion r WHERE c.carpetaAdministrativa=a.carpetaAdministrativa AND c.unidadGestion='".$unidadGestion.
					"' AND a.situacion in(1,3,4) AND (idTitularAlerta=".$idUsuario." OR idTitularAlerta IS NULL) and r.idAlertaNotificacion=a.idRegistro ";
				
		
		if($cA!="")
		{
			$consulta="SELECT distinct a.idRegistro,a.carpetaAdministrativa,a.descripcion,a.valorReferencia1,a.valorReferencia2,a.fechaRegistro,
						(select Nombre from 800_usuarios where idUsuario=a.responsableRegistro) as responsableRegistro,a.tipoAlerta,
						fechaRecordatorio as fechaAlerta,idTitularAlerta,a.situacion,motivoCancelacion as comentariosAlerta,
						(select Nombre from 800_usuarios where idUsuario=a.responsableCancelacion) as responsableCancelacion 
						FROM 7036_alertasNotificaciones a,7037_recordatoriosPreviosNotificacion r WHERE  a.carpetaAdministrativa='".$cA.
						"' and  r.idAlertaNotificacion=a.idRegistro ";
		}
		
		if($periodoInicio!="")
		{
			$consulta.=" AND r.fechaRecordatorio>='".$periodoInicio." 00:00:01' AND r.fechaRecordatorio<='".$periodoFin." 23:59:59'";	
		}
		
		if($situacion!=0)
		{
			$consulta.=" and a.situacion in (".$situacion.")";
		}
		
		if($tAlerta!=-1)
		{
			$consulta.=" and a.tipoAlerta=".$tAlerta;
		}
		
		if($valorReferencia1!=-1)
		{
			$consulta.=" and a.valorReferencia1=".$valorReferencia1;
		}
		
		if($valorReferencia2!=-1)
		{
			$consulta.=" and a.valorReferencia2=".$valorReferencia2;
		}
		
		$listaRegistro="";
		$consulta.="and a.tipoAlerta in(".$listaAlertasMostrar.") order by fechaRecordatorio desc";

		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$detallesAdicionales="";
				$objConfiguracion="";
			$funcionApertura=$arrTipoAlertas[$fila["tipoAlerta"]];
			if($funcionApertura=="")
			{
			
				$detallesAdicionales="";
				$objConfiguracion="";
				switch($fila["tipoAlerta"])
				{
					case 1://Documento
						$consulta="SELECT * FROM 7035_informacionDocumentos WHERE idRegistro=".$fila["valorReferencia1"];
						$fDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
						$consulta="SELECT * FROM 3000_formatosRegistrados WHERE idFormulario=-2 AND idRegistro=".$fila["valorReferencia1"];
						
						$fDatosDocumento=$con->obtenerPrimeraFilaAsoc($consulta);
						
						if($fDatosDocumento)
						{
							if($fDatosDocumento["idDocumento"]!="")
							{
								$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fDatosDocumento["idDocumento"];
	
								$nombreArchivo=$con->obtenerValor($consulta);
								$arrExtension=explode(".",$nombreArchivo);
								$objConfiguracion='{"funcion":"mostrarDocumento","tipoVisor":"1","idDocumento":"'.$fDatosDocumento["idDocumento"].'","nombreDocumento":"'.cv($nombreArchivo).
											'","extension":"'.$arrExtension[sizeof($arrExtension)-1].'"}';
							}
							else
							{
								$objConfiguracion='{"funcion":"mostrarDocumento","tipoVisor":"2","tipoDocumento":"'.$fDatosDocumento["tipoFormato"].'","idDocumento":"'.
											$fDatosDocumento["idRegistroFormato"].'"}';
							}
						}
						break;
					case 2://Prescripcion
						$consulta="SELECT * FROM 7034_prescripciones WHERE idRegistro=".$fila["valorReferencia1"];
						$fDatosPrescripcion=$con->obtenerPrimeraFilaAsoc($consulta);
						
						
						if($fDatosPrescripcion)
						{
							if($fDatosPrescripcion["idFormulario"]==-1)
							{
								$objConfiguracion='{"funcion":"mostrarPrescripcion","tipoVisor":"1","idPrescripcion":"'.$fila["valorReferencia1"].'"}';
							}
							else
							{
								$objConfiguracion='{"funcion":"mostrarPrescripcion","tipoVisor":"2","idFormulario":"'.$fDatosPrescripcion["idFormulario"].
												'","idReferencia":"'.$fDatosPrescripcion["idReferencia"].'"}';
							}
						}
						
						
						break;
					case 4://Prescripcion
						$objConfiguracion='{"funcion":"mostrarPrescripcion","tipoVisor":"2","idFormulario":"'.$fila["valorReferencia1"].
											'","idReferencia":"'.$fila["valorReferencia2"].'"}';
						break;
					case 5://pena
						$consulta="SELECT p.idRegistro,IF(detallePena=-1,(SELECT pena FROM _406_tablaDinamica WHERE id__406_tablaDinamica=p.idPena),
									CONCAT((SELECT pena FROM _406_tablaDinamica WHERE id__406_tablaDinamica=p.idPena),' (',
									(SELECT subdetalle FROM _406_gridSubDetalle WHERE id__406_gridSubDetalle=p.detallePena),')')) AS detallePena,
									objDetalle FROM 7024_registroPenasSentenciaEjecucion p where p.idRegistro=".$fila["valorReferencia1"];
						$fPena=$con->obtenerPrimeraFila($consulta);
						$pena=$fPena[1];
						$compPena="";
						if($fPena[2]!="")
						{
							$oDetalle=json_decode($fPena[2]);
							if(isset($oDetalle->monto))
							{
								$compPena="<br>Monto: $ ".number_format($oDetalle->monto,2);
							}
							if(isset($oDetalle->tiposObjetos))
							{
								$arrObjetos=explode(",",$oDetalle->tiposObjetos);
								$compPena="<br>Tipo de objetos: ";
								$lObjetos="";
								foreach($arrObjetos as $o)
								{
									if($lObjetos=="")
										$lObjetos=$aTipoObjetos[$o];
									else
										$lObjetos.=",".$aTipoObjetos[$o];
								}
								$compPena.=$lObjetos;
							}
	
							if(isset($oDetalle->anios))
							{
								$arrPena=array();
								$arrPena[0]=$oDetalle->anios;
								$arrPena[1]=$oDetalle->meses;
								$arrPena[2]=$oDetalle->dias;
								$sentencia=$oDetalle->anios."_".$oDetalle->meses."_".$oDetalle->dias;
								$compPena="<br>Periodo a compurgar: ".convertirLeyendaComputo($arrPena);
							}
							
							$pena.=$compPena;
							
						}
						
						$detallesAdicionales="<br><b>Pena:</b> ".$pena;
					break;
					
				}
			}
			else
			{
				$objConfiguracion='{"funcion":"'.$funcionApertura.'","idFormulario":"'.$fila["valorReferencia1"].
								'","idReferencia":"'.$fila["valorReferencia2"].'"}';
	
			}
			$recordarPreviamente="";
			$consulta="SELECT fechaRecordatorio FROM 7037_recordatoriosPreviosNotificacion WHERE idAlertaNotificacion=".$fila["idRegistro"].
					" AND fechaRecordatorio<>'".$fila["fechaAlerta"]." 00:00:01'";
			$rFechas=$con->obtenerFilas($consulta);
			while($filaPrev=$con->fetchRow($rFechas))
			{
				$fecha=date("d/m/Y",strtotime($filaPrev[0]));
				if($recordarPreviamente=="")	
					$recordarPreviamente=$fecha;
				else
					$recordarPreviamente.="<br>".$fecha;
			}
			
			if($recordarPreviamente=="")
				$recordarPreviamente="------";
				

			$o='{"idRegistro":"'.$fila["idRegistro"].'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].'","descripcion":"'.cv($fila["descripcion"]).
				'","valorReferencia1":"'.$fila["valorReferencia1"].'","valorReferencia2":"'.$fila["valorReferencia2"].'","fechaRegistro":"'.$fila["fechaRegistro"].
				'","responsableRegistro":"'.cv($fila["responsableRegistro"]).'","tipoAlerta":"'.$fila["tipoAlerta"].'",
				"fechaAlerta":"'.$fila["fechaAlerta"].'","idTitularAlerta":"'.$fila["idTitularAlerta"].'","objConfiguracion":"'.bE($objConfiguracion).
				'","situacion":"'.$fila["situacion"].'","comentariosAlerta":"'.cv($fila["comentariosAlerta"]).
				'","responsableCancelacion":"'.cv($fila["responsableCancelacion"]).
				'","detallesAdicionales":"'.cv($detallesAdicionales).'","recordarPreviamente":"'.$recordarPreviamente.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
			
			if($listaRegistro=="")
				$listaRegistro=$fila["idRegistro"];
			else
				$listaRegistro.=",".$fila["idRegistro"];
			
		}
		if(($listaRegistro!="")&&($esRecordatorioDia))
		{
			$consulta="UPDATE 7036_alertasNotificaciones SET situacion=4 WHERE idRegistro IN(".$listaRegistro.") AND  situacion=1";
			$con->ejecutarConsulta($consulta);
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	
	
	}
	
	function obtenerRegistrosAlertasNotificacionesHora()
	{
		global $con;
		global $versionLatis;
		
		$idUsuario=-1;
		if(isset($_POST["iU"]))
		{
			$idUsuario=$_POST["iU"];
			$consulta="select AES_DECRYPT(UNHEX('".$idUsuario."'), '".bD($versionLatis)."') as idUsuario";
			$idUsuario=$con->obtenerValor($consulta);
		}

		$fechaActual=date("Y-m-d H:i:s");	
		$fechaDia=date("Y-m-d");
		$consulta="SELECT idRegistro FROM 7038_tiposAlertaNotificaciones WHERE considerarNotificacionDelDia=2";
		$listaAlertasMostrar=$con->obtenerListaValores($consulta);
		if($listaAlertasMostrar=="")
			$listaAlertasMostrar=-1;

		$consulta="SELECT a.idRegistro FROM 7036_alertasNotificaciones a,7037_recordatoriosPreviosNotificacion r  
				WHERE a.fechaAlerta='".$fechaDia."' and  idTitularAlerta=".$idUsuario." and a.situacion in(1)  
				and r.idAlertaNotificacion=a.idRegistro AND r.fechaRecordatorio<='".$fechaActual.
				"' and a.tipoAlerta in(".$listaAlertasMostrar.")";
		$listaNotificacion=$con->obtenerListaValores($consulta);
		
		$totalAlertasNuevas=$con->filasAfectadas;
		if($listaNotificacion!="")
		{
			$consulta="UPDATE 7036_alertasNotificaciones SET situacion=-1 WHERE idRegistro IN(".$listaNotificacion.")";
			$con->ejecutarConsulta($consulta);
		}
		$objResultado='{"registrosNuevos":"'.$totalAlertasNuevas.'"}';
		
			
		echo "1|".$objResultado;
	}
	
	
?>