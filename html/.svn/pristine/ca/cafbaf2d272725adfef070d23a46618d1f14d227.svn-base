<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include_once("sanofi/funcionesPerfilCancer.php");
	if(isset($_SESSION["leng"]))
	{
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];
		$lenguaje=$_SESSION["leng"];
		
		switch($funcion)
		{
			case 1:
				obtenerUnidadesControl();
			break;
			case 2:
				registrarSerie();
			break;
			case 3:
				distribuirFolios();
			break;
			case 4:
				modificarDistribucionSerie();
			break;
			case 5:
				modificarSituacionSerie();
			break;
			case 6:
				validarFolioRegistro();
			break;
			case 7:
				obtenerRegistrosFolios();
			break;
			case 8:
				obtenerHistorialFolio();
			break;
			case 9:
				obtenerRegistrosFoliosAcompanamiento();
			break;
			case 10:
				obtenerHistorialAcompanamientoExpendiente();
			break;
			case 11:
				registroInsumosProyecto();
			break;
			case 12:
				obtenerRegistrosFoliosAcompanamientoPendientes();
			break;
			case 13:
				obtenerRegistrosFoliosAcompanamientoNuevos();
			break;
			case 14:
				registrarCorreoContacto();
			break;
			case 15:
				registrarTelefonoContacto();
			break;
			case 16:
				buscarCentrosSalud();
			break;
			case 17:
				enviarDatosCentroSaludPaciente();
			break;
			case 18:
				registrarBajaSeguimientoPaciente();
			break;
			case 19:
				obtenerRegistrosFoliosPacientesDiagnosticados();
			break;
			case 20:
				obtenerHistorialEstudiosTratamiento();
			break;
			case 21:
				registrarEventoAdverso();
			break;
			case 22:
				obtenerEventosAdversos();
			break;
			case 23:
				registrarParametrosPaciente();
			break;
			case 24:
				evaluarDiagnosticoPaciente();
			break;
			case 25:
				obtenerDiagnosticoPaciente();
			break;
			case 26:
				enviarMailPaciente();
			break;
			case 27:
				obtenerDatosMailSeguimiento();
			break;
			case 28:
				obtenerDatosMailRespuesta();
			break;
			case 29:
				obtenerEstadisticasMailPaciente();
			break;
			case 30:
				obtenerMailRespuestaSituacion();
			break;
			case 31 :
				marcarMail();
			break;
			case 32 :
				verificarBuzonEntrada();
			break;
			case 33:
				obtenerMatrizRiesgo();
			break;
			case 34:
				registrarNuevaRegla();
			break;
			case 35:
				registrarCondicionReglaPerfil();
			break;
			case 36:
				removerReglaPerfil();
			break;
			case 37:
				removerValorParametroRegla();
			break;
			case 38:
				registrarParametrosPacienteInterface();
			break;
			case 39:
				evaluarDiagnosticoPacienteV2();
			break;
			case 40:
				obtenerMatrizTratamientosEstudiosRiesgo();
			break;
			case 41:
				registrarNuevaReglaEstudioRiesgo();
			break;
			case 42:
				registrarCondicionReglaPerfilEstudioRiesgo();
			break;
			case 43:
				removerReglaPerfilEstudioRiesgo();
			break;
			case 44:
				removerValorParametroReglaEsttudioRiesgo();
			break;
			case 45:
				registrarEstudioTratamientoComentario();
			break;
			case 46:
				removerEstudioTratamientoComentario();
			break;
			case 47:
				obtenerOpcionesTratamiento();
			break;
			case 48:
				obtenerRegistrosFoliosAcompanamientoNegativos();
			break;
		}
	}
	
	function obtenerUnidadesControl()
	{
		global $con;
		$numReg=0;
		$arrRegistros="";
		$idFormulario=bD($_POST["iF"]);
		$idRegistro=bD($_POST["iR"]);
		$idSerie=bD($_POST["iS"]);
		$consulta="SELECT unidad,codigoUnidad,c.nombreCategoria FROM 817_organigrama o,817_categoriasUnidades c WHERE institucion IN(
				SELECT tipoUnidad FROM _1024_gridTiposUnidades WHERE idReferencia=".$idRegistro.") AND o.institucion=c.idCategoriaUnidadOrganigrama";

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$folioInicial=0;
			$folioFinal=0;
			
			$consulta="SELECT folioInicial,folioFinal FROM 3011_relacionFoliosSerie WHERE idSerie=".$idSerie." AND unidadControl='".$fila[1]."'";
			$fFolio=$con->obtenerPrimeraFila($consulta);
			if($fFolio)
			{
				$folioInicial=$fFolio[0];
				$folioFinal=$fFolio[1];
			}
			
			$totalFolios=($folioFinal-$folioInicial+1);
			if($folioInicial==0)
				$folioInicial="";
			if($folioFinal==0)
				$folioFinal="";
			if(($folioInicial==0)&&($folioFinal==0))		
			{
				$totalFolios=0;
			}
			
			
			
			
			$obj='{"codigoUnidad":"'.$fila[1].'","unidadControl":"'.cv($fila[0]).'","tipoUnidad":"'.$fila[2].'","folioInicial":"'.$folioInicial.'","folioFinal":"'.$folioFinal.'","totalFolios":"'.$totalFolios.'"';
			$consulta="SELECT id__1038_tablaDinamica,nombreCorto FROM _1038_tablaDinamica ORDER BY nombreCorto";
			$resInsumos=$con->obtenerFilas($consulta);
			while($filaInsumo=mysql_fetch_row($resInsumos))
			{
				$valor=0;
				
				$consulta="SELECT cantidad FROM 3012_relacionInsumosProyecto WHERE idSerie=".$idSerie." AND idInsumo=".$filaInsumo[0]." and codigoUnidad='".$fila[1]."'";

				$valor=$con->obtenerValor($consulta);
				if($valor=="")
					$valor=0;
				$obj.=',"insumo_'.$filaInsumo[0].'":"'.$valor.'"';
			}
			$obj.="}";
			
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function registrarSerie()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$consulta="";
		
		$query="SELECT COUNT(*) FROM 3010_seriesInsumosProyecto WHERE nombreSerie='".cv($obj->serie)."' AND idSerie<>".$obj->idSerie;
		$nReg=$con->obtenerValor($query);
		if($nReg>0)
		{
			echo "<br>Ya existe una serie con el título ingresado";
			return;	
		}
		$x=0;
		
		
		
		
		$consulta[$x]="begin";
		$x++;
		if($obj->idSerie==-1)
		{
			$consulta[$x]="INSERT INTO 3010_seriesInsumosProyecto(nombreSerie,descripcion,totalFolios,folioInicial,situacion) VALUES('".cv($obj->serie)."','".cv($obj->descripcion)."',".$obj->folioSerie.",".$obj->folioInicial.",1)";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			
		}
		else
		{
			$query="SELECT totalFolios,folioInicial FROM 3010_seriesInsumosProyecto WHERE idSerie=".$obj->idSerie;
			$fDatosFolio=$con->obtenerPrimeraFila($query);
			$totalFolios=$fDatosFolio[0];
			$folioInicial=$fDatosFolio[1];
			$consulta[$x]="UPDATE 3010_seriesInsumosProyecto SET folioInicial=".$obj->folioInicial.",nombreSerie='".cv($obj->serie)."',descripcion='".cv($obj->descripcion)."',totalFolios=".$obj->folioSerie." WHERE idSerie=".$obj->idSerie;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idSerie;
			$x++;
			if(($obj->folioSerie!=$totalFolios)||($obj->folioInicial!=$folioInicial))
			{
				$consulta[$x]="DELETE FROM 3011_relacionFoliosSerie WHERE idSerie=".$obj->idSerie;
				$x++;
			}
			
		}
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			$query="SELECT idSerie,concat(nombreSerie, ' [',if(situacion=1,'En diseño',(if(situacion=2,'Liberado, en ejecución','Cerrado'))),']'),descripcion,totalFolios,situacion,folioInicial FROM 3010_seriesInsumosProyecto ORDER BY nombreSerie";
			$arrSeries=$con->obtenerFilasArreglo($query);
			$query="select @idRegistro";
			$idSerie=$con->obtenerValor($query);
			echo "1|".$arrSeries."|".$idSerie;	
		}
		
	}
	
	function distribuirFolios()
	{
		global $con;
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$query[$x]="DELETE FROM 3011_relacionFoliosSerie WHERE idSerie=".$obj->idSerie;
		$x++;
		
		$arrUnidades=explode(",",$obj->arrUnidades);
		$numUnidades=sizeof($arrUnidades);
		
		$consulta="SELECT totalFolios,folioInicial FROM 3010_seriesInsumosProyecto where idSerie=".$obj->idSerie;
		$fSerie=$con->obtenerPrimeraFila($consulta);
		
		$folioInicial=$fSerie[1];
		$folioInicialAux=$folioInicial;
		$folioFinalAux="";
		$totalFolios=$fSerie[0];
		$folioFinal=$folioInicial+$totalFolios-1;
		$foliosPorUnidad=0;
		switch($obj->metodoDistribucion)
		{
			case 1:
				$foliosPorUnidad=str_replace(",","",number_format($totalFolios/$numUnidades,0));
				
			break;
			case 2:
				$foliosPorUnidad=$obj->cantidadFolios;
			break;	
		}
		
		$numReg=0;
		foreach($arrUnidades as $unidad)
		{
			/*if($numReg==$numUnidades)	
			{
				$folioFinalAux=$folioFinal;
			}
			else*/
			{
				$folioFinalAux=$folioInicialAux-1+$foliosPorUnidad;
				
			
			}
			
			if($folioFinalAux>$folioFinal)
				$folioFinalAux=$folioFinal;
				
			$query[$x]="INSERT INTO 3011_relacionFoliosSerie(folioInicial,folioFinal,idSerie,unidadControl) VALUES(".$folioInicialAux.",".$folioFinalAux.",".$obj->idSerie.",'".$unidad."')";
			$x++;
			$numReg++;
			$folioInicialAux=$folioFinalAux+1;
		}
		
		
		
		
		$query[$x]="commit";
		$x++;
		eB($query);
			
	}	
		
	function modificarDistribucionSerie()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->folioInicial=="")
			$obj->folioInicial="NULL";
		if($obj->folioFinal=="")
			$obj->folioFinal="NULL";
		$consulta="SELECT idRelacion FROM 3011_relacionFoliosSerie WHERE idSerie=".$obj->idSerie." AND unidadControl='".$obj->codigoUnidad."'";
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro!="")
		{
			$consulta="UPDATE 3011_relacionFoliosSerie SET folioInicial=".$obj->folioInicial.",folioFinal=".$obj->folioFinal." WHERE idRelacion=".$idRegistro;
		}
		else
		{
			$consulta="INSERT INTO 3011_relacionFoliosSerie(folioInicial,folioFinal,idSerie,unidadControl) VALUES(".$obj->folioInicial.",".$obj->folioFinal.",".$obj->idSerie.",'".$obj->codigoUnidad."')";	
		}
		eC($consulta);
			
		
	}
	
	function modificarSituacionSerie()
	{
		global $con;
		$idSerie=$_POST["idSerie"];
		$situacion=$_POST["situacion"];	
		$consulta="UPDATE 3010_seriesInsumosProyecto SET situacion=".$situacion." WHERE idSerie=".$idSerie;
		if($con->ejecutarConsulta($consulta))
		{
			$query="SELECT idSerie,concat(nombreSerie, ' [',if(situacion=1,'En diseño',(if(situacion=2,'Liberado, en ejecución','Cerrado'))),']'),descripcion,totalFolios,situacion,folioInicial FROM 3010_seriesInsumosProyecto ORDER BY nombreSerie";
			$arrSeries=$con->obtenerFilasArreglo($query);
			echo "1|".$arrSeries;	
		}
	}
	
	function validarFolioRegistro()
	{
		global $con;	
		$idSerie=$_POST["idSerie"];
		$folio=$_POST["folio"];
		$idRegistro=$_POST["idRegistro"];
		
		
		$codigoInstitucion=$_SESSION["codigoInstitucion"];
		$consulta="SELECT institucion FROM 817_organigrama WHERE codigoUnidad='".$codigoInstitucion."'";
		$institucion=$con->obtenerValor($consulta);
		
		switch($institucion) 
		{
			case 9: //Centro de salud
				$consulta="SELECT COUNT(*) FROM 3011_relacionFoliosSerie WHERE idSerie=".$idSerie." AND ".$folio.">=folioInicial AND ".$folio."<=folioFinal and unidadControl='".$codigoInstitucion."'";
				
			break;
			case 12: //Centro de atencion
			case 13:
				$consulta="SELECT COUNT(*) FROM 3011_relacionFoliosSerie WHERE idSerie=".$idSerie." AND ".$folio.">=folioInicial AND ".$folio."<=folioFinal";
			break;
		}
		$nFolios=$con->obtenerValor($consulta);
		/*if($nFolios==0)
		{
			echo "1|2";
			return;	
		}*/
		
		$consulta="SELECT id__1022_tablaDinamica,responsable FROM _1022_tablaDinamica WHERE idSerie=".$idSerie." AND folio=".$folio." and id__1022_tablaDinamica<>".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($consulta);

		if(!$fRegistro)
			echo "1|1";
		else
		{
			if($fRegistro[1]==$_SESSION["idUsr"])
				echo "1|3|".$fRegistro[0];
			else
			{
				$consulta="select Nombre from 800_usuarios where idUsuario=".$fRegistro[1];
				echo "1|4|".$con->obtenerValor($consulta);
			}
		}
	}
	
	function obtenerRegistrosFolios()
	{
		global $con;
		$idSerie=$_POST["idSerie"];
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		$comp="";
		
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		
		/*
		$codigoInstitucion=$_SESSION["codigoInstitucion"];
		$consulta="SELECT institucion FROM 817_organigrama WHERE codigoUnidad='".$codigoInstitucion."'";
		$institucion=$con->obtenerValor($consulta);
		switch($institucion) 
		{
			case 9: //Centro de salud
				$comp=" and codigoInstitucion='".$codigoInstitucion."'";
			break;
			case 12: //Centro de atencion

			break;
		}*/
		
		if((!existeRol("'115_0'"))&&(!existeRol("'113_0'")))
		{
			$comp=" and responsable=".$_SESSION["idUsr"];
		}
		
		if($_SESSION["idUsr"]=="1741")
			$comp=" and responsable=".$_SESSION["idUsr"];
		
		
		
		$consulta="select * from (SELECT id__1022_tablaDinamica AS idFolio,folio,fechaLlenado,fechaCreacion AS fechaCaptura,apPaterno,apMaterno,nombres AS nombre,idEstado AS situacion,jurisdiccion,
		(select nombre from 800_usuarios where idUsuario=t.responsable) as responsableCapturaFicha,(select nombre from 800_usuarios u,_1039_tablaDinamica c where idUsuario=c.responsable and c.idReferencia=t.id__1022_tablaDinamica limit 0,1) 
		as responsableCapturaCuestionario,
		if((select count(*) from _1039_tablaDinamica where idReferencia=t.id__1022_tablaDinamica)=0,'2','1') as situacionCaptura FROM _1022_tablaDinamica t where idSerie=".$idSerie.$comp.")
				tmo where ".$condWhere." ORDER BY CAST(folio AS SIGNED) limit ".$start.",".$limit;
		
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		$consulta="select * from (SELECT id__1022_tablaDinamica AS idFolio,folio,fechaLlenado,fechaCreacion AS fechaCaptura,apPaterno,apMaterno,nombres AS nombre,idEstado AS situacion,jurisdiccion,
		(select nombre from 800_usuarios where idUsuario=t.responsable) as responsableCapturaFicha,(select nombre from 800_usuarios u,_1039_tablaDinamica c where idUsuario=c.responsable and c.idReferencia=t.id__1022_tablaDinamica limit 0,1) 
		as responsableCapturaCuestionario,
		if((select count(*) from _1039_tablaDinamica where idReferencia=t.id__1022_tablaDinamica)=0,'2','1') as situacionCaptura FROM _1022_tablaDinamica t where idSerie=".$idSerie.$comp.")
				tmo where ".$condWhere." ORDER BY CAST(folio AS SIGNED)";
		
		$con->obtenerFilas($consulta);
		
		$numReg=$con->filasAfectadas;
		echo '{"numReg":"'.$numReg.'","registros":'.$registros.'}';
	}
	
	function obtenerHistorialFolio()
	{
		global $con;	
		$arrRegistros="";
		$idRegistro=$_POST["idRegistro"];
		$idFormulario=$_POST["idFormulario"];
		$numReg=0;
		$consulta="SELECT * FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormulario." and idRegistro=".$idRegistro." and (etapaActual<>etapaAnterior or etapaAnterior<>1) order by idRegistroEstado desc";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"idRegistro":"'.$fila[0].'","fechaCambio":"'.$fila[2].'","etapaAnterior":"'.$fila[4].'","etapaActual":"'.$fila[1].'","comentarios":"'.cv($fila[7]).'","referencia1":"'.$fila[8].'","referencia2":"'.$fila[9].'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
				
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerRegistrosFoliosAcompanamiento()
	{
		global $con;
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		
		$arrMotivosNoContacto=array();
		$arrMotivosNoContacto[0][0]="1";
		$arrMotivosNoContacto[0][1]="Se dejó recado";
		$arrMotivosNoContacto[1][0]="2";
		$arrMotivosNoContacto[1][1]="Fuera de Servicio";
		$arrMotivosNoContacto[2][0]="3";
		$arrMotivosNoContacto[2][1]="No contestan";
		
		
		
		$arrMotivosNoAgenda=array();
		$arrMotivosNoAgenda[0][0]="1";
		$arrMotivosNoAgenda[0][1]="Número telefónico no existe";
		$arrMotivosNoAgenda[1][0]="2";
		$arrMotivosNoAgenda[1][1]="Número equivocado";
		$arrMotivosNoAgenda[2][0]="3";
		$arrMotivosNoAgenda[2][1]="Otro";
		
		
		$comp="";
		if(!existeRol("'114_0'"))
		{
			$consulta="SELECT idPaciente FROM 3021_responsableSeguimientoPaciente WHERE idResponsableSeguimiento=".$_SESSION["idUsr"]." and fechaBaja is null";
			$lPacientes=$con->obtenerListaValores($consulta);	
			if($lPacientes=="")
				$lPacientes=-1;
			$comp=" and id__1022_tablaDinamica in (".$lPacientes.")";
		}
		
		
		$consulta="select * from (SELECT id__1022_tablaDinamica AS idFolio,folio,fechaLlenado,fechaCreacion AS fechaCaptura,apPaterno,apMaterno,nombres AS nombre,
						idEstado AS situacion,jurisdiccion,
						(SELECT fechaContacto FROM 3020_seguimientoPaciente WHERE idReferencia=t.id__1022_tablaDinamica ORDER BY fechaContacto DESC,idCuestionarioSeguimiento DESC limit 0,1) as fechaUltimoSeguimiento,
						(SELECT fechaProximoContacto FROM 3020_seguimientoPaciente WHERE idReferencia=t.id__1022_tablaDinamica ORDER BY fechaContacto DESC,idCuestionarioSeguimiento DESC limit 0,1) as proximaLlamada, 
						(SELECT contactoPaciente FROM 3020_seguimientoPaciente WHERE idReferencia=t.id__1022_tablaDinamica ORDER BY fechaContacto DESC,idCuestionarioSeguimiento DESC limit 0,1) as seContacto,
						(SELECT u.Nombre  FROM 3021_responsableSeguimientoPaciente r,800_usuarios u WHERE idPaciente=t.id__1022_tablaDinamica AND u.idUsuario=r.idResponsableSeguimiento) as responsableSeguimiento
					FROM _1022_tablaDinamica t where idEstado in (SELECT etapa FROM _1034_tablaDinamica) ".$comp."
					
					 )
					as tmp where ".$condWhere." ORDER BY folio";
					
		
					
		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		$registros="";
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT * FROM 3020_seguimientoPaciente WHERE idReferencia=".$fila[0]." ORDER BY fechaContacto DESC,idCuestionarioSeguimiento DESC";
			$fUltimo=$con->obtenerPrimeraFila($consulta);
			$lblTipoContacto="";
			$tipoContacto=$fUltimo[5];
			$valorReferencia=$fUltimo[6];
			$idReferencia=$fUltimo[1];
			switch($tipoContacto)
			{
				case "1":
					$lblTipoContacto="Llamada telefónica a: ".$valorReferencia."";
				break;
				case "2":
					$lblTipoContacto="Correo electr&oacute;nico a: ".$valorReferencia."";
				break;	
			}
			$descripcionUltimoSeguimiento=$lblTipoContacto;
			
			
			$lblMotivoNoContacto="";
			$pos=existeValorMatriz($arrMotivosNoContacto,$fUltimo[21]);
			if($pos!=-1)
				$lblMotivoNoContacto=$arrMotivosNoContacto[$pos][1];
			
			
			$pos=existeValorMatriz($arrMotivosNoAgenda,$fUltimo[25]);
		
			$motivoNoAgenda="";
			if($pos!=-1)
			{
				$motivoNoAgenda=$arrMotivosNoAgenda[$pos][1];
				if($fUltimo[25]==3)
				{
					$motivoNoAgenda.=": ".$fUltimo[27];	
				}
			}
			
			$consulta="SELECT email FROM _1022_gridEmail WHERE idReferencia=".$fila[0];
			$lMail=$con->obtenerListaValores($consulta,"'");
			if($lMail=="")
				$lMail=-1;
			
			
			$consulta="SELECT COUNT(*) FROM 3027_eMailRecibidos WHERE remitente IN (".$lMail.") AND situacion=0";
			$eMailSinLeer=$con->obtenerValor($consulta);
			
			$consulta="SELECT COUNT(*) FROM 3027_eMailRecibidos WHERE remitente IN (".$lMail.") AND situacion2=0";
			$eMailSinClasificar=$con->obtenerValor($consulta);
			
			switch($tipoContacto)
			{
				case 1:
				
				break;
				case 2:
					$consulta="SELECT situacion FROM 3026_mensajesContactoPaciente WHERE idReferenciaContacto=".$fUltimo[0];
					$situacion=$con->obtenerValor($consulta);
					switch($situacion)
					{
						case 1:
							$fUltimo[7]=2;
						break;
						case 2:
							$fUltimo[7]=1;
						break;
						case 3:
							$fUltimo[7]=0;
						break;	
					}
				break;
			}
			
			
			$obj='{"tipoIntentoContacto":"'.$tipoContacto.'","eMailSinLeer":"'.$eMailSinLeer.'","eMailSinClasificar":"'.$eMailSinClasificar.'","jurisdiccion":"'.$fila[8].'","idFolio":"'.$fila[0].'","folio":"'.$fila[1].
				'","fechaLlenado":"'.$fila[2].'","fechaCaptura":"'.$fila[3].'","apPaterno":"'.cv($fila[4]).'","apMaterno":"'.cv($fila[5]).'","nombre":"'.cv($fila[6]).'","situacion":"'.$fila[7].
				'","fechaUltimoSeguimiento":"'.$fUltimo[2].'","seContacto":"'.$fUltimo[7].'","proximaLlamada":"'.$fUltimo[23].'","comentariosAdicionales":"'.cv($fUltimo[26]).
				'","descripcionUltimoSeguimiento":"'.cv($descripcionUltimoSeguimiento).'","agendarSeguimiento":"'.$fUltimo[22].
				'","motivoNOAgenda":"'.cv($motivoNoAgenda).'","motivoNoContacto":"'.cv($lblMotivoNoContacto).'","responsableSeguimiento":"'.cv($fila[12]).'"}';	
			if($registros=="")
				$registros=$obj;
			else
				$registros.=",".$obj;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';		
	}
	
	function obtenerHistorialAcompanamientoExpendiente()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		
		$numReg=0;
		$registros="";
		$consulta="SELECT idCuestionarioSeguimiento, fechaContacto,tipoIntentoContacto,referenciaContacto,contactoPaciente,agendarSeguimiento,fechaProximoContacto,notasAdicionales,motivoNOAgenda,
						(select Nombre from 800_usuarios where idUsuario=s.idResponsableContacto) as idResponsableContacto 
					FROM 3020_seguimientoPaciente s WHERE idReferencia=".$idRegistro." ORDER BY idCuestionarioSeguimiento desc";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$o="";
			switch($fila[2])
			{
				case 1:
					$o='{"idCuestionarioSeguimiento":"'.$fila[0].'","fechaContacto":"'.$fila[1].'","agendarSeguimiento":"'.$fila[5].'","contactoPaciente":"'.$fila[4].'","fechaProximoContacto":"'.$fila[6].'","notasAdicionales":"'.cv($fila[7]).
						'","referenciaContacto":"'.$fila[3].'","tipoIntentoContacto":"'.$fila[2].'","motivoNOAgenda":"'.cv($fila[8]).'","idResponsableContacto":"'.cv($fila[9]).'","mailAsociado":""}';
				break;
				case 2:
				
					$consulta="SELECT situacion FROM 3026_mensajesContactoPaciente WHERE idReferenciaContacto=".$fila[0];
					$situacion=$con->obtenerValor($consulta);

					switch($situacion)
					{
						case 1:
							$fila[4]=2;
						break;
						case 2:
							$fila[4]=1;
						break;
						case 3:
							$fila[4]=0;
						break;	
					}
					
					$o='{"idCuestionarioSeguimiento":"'.$fila[0].'","fechaContacto":"'.$fila[1].'","agendarSeguimiento":"'.$fila[5].'","contactoPaciente":"'.$fila[4].'","fechaProximoContacto":"'.$fila[6].'","notasAdicionales":"'.cv($fila[7]).
					'","referenciaContacto":"'.$fila[3].'","tipoIntentoContacto":"'.$fila[2].'","motivoNOAgenda":"'.cv($fila[8]).'","idResponsableContacto":"'.cv($fila[9]).'","mailAsociado":""}';
				break;	
			}
			
			
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';	
	}
	
	function registroInsumosProyecto()
	{
		global $con;
		$idInsumo=$_POST["idInsumo"];	
		$valor=$_POST["valor"];	
		$idSerie=$_POST["idSerie"];	
		$codigoUnidad=$_POST["codigoUnidad"];
		$consulta="SELECT idRegistro FROM 3012_relacionInsumosProyecto WHERE idSerie=".$idSerie." AND idInsumo=".$idInsumo." and codigoUnidad='".$codigoUnidad."'";
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
		{
			$consulta="INSERT INTO 3012_relacionInsumosProyecto(idInsumo,idSerie,cantidad,codigoUnidad) VALUES(".$idInsumo.",".$idSerie.",".$valor.",'".$codigoUnidad."')";	
		}
		else
		{
			$consulta="UPDATE 3012_relacionInsumosProyecto SET cantidad=".$valor." WHERE idRegistro=".$idRegistro;
		}
		eC($consulta);
		
	}
	
	function obtenerRegistrosFoliosAcompanamientoPendientes()
	{
		global $con;
		
		$fechaActual=strtotime(date("Y-m-d"));
		
		
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		
		$arrMotivosNoContacto=array();
		$arrMotivosNoContacto[0][0]="1";
		$arrMotivosNoContacto[0][1]="Se dejó recado";
		$arrMotivosNoContacto[1][0]="2";
		$arrMotivosNoContacto[1][1]="Fuera de Servicio";
		$arrMotivosNoContacto[2][0]="3";
		$arrMotivosNoContacto[2][1]="No contestan";
		
		
		
		$arrMotivosNoAgenda=array();
		$arrMotivosNoAgenda[0][0]="1";
		$arrMotivosNoAgenda[0][1]="Número telefónico no existe";
		$arrMotivosNoAgenda[1][0]="2";
		$arrMotivosNoAgenda[1][1]="Número equivocado";
		$arrMotivosNoAgenda[2][0]="3";
		$arrMotivosNoAgenda[2][1]="Otro";
		
		$comp="";
		if(!existeRol("'114_0'"))
		{
			$consulta="SELECT idPaciente FROM 3021_responsableSeguimientoPaciente WHERE idResponsableSeguimiento=".$_SESSION["idUsr"]." and fechaBaja is null";
			$lPacientes=$con->obtenerListaValores($consulta);	
			if($lPacientes=="")
				$lPacientes=-1;
			$comp=" and id__1022_tablaDinamica in (".$lPacientes.")";
		}
		
		
		$consulta="select * from (SELECT id__1022_tablaDinamica AS idFolio,folio,fechaLlenado,fechaCreacion AS fechaCaptura,apPaterno,apMaterno,nombres AS nombre,idEstado AS situacion,jurisdiccion, 
					
					(SELECT fechaContacto FROM 3020_seguimientoPaciente WHERE idReferencia=t.id__1022_tablaDinamica ORDER BY fechaContacto DESC,idCuestionarioSeguimiento DESC limit 0,1) as fechaUltimoSeguimiento,
						(SELECT fechaProximoContacto FROM 3020_seguimientoPaciente WHERE idReferencia=t.id__1022_tablaDinamica ORDER BY fechaContacto DESC,idCuestionarioSeguimiento DESC limit 0,1) as proximaLlamada, 
						(SELECT contactoPaciente FROM 3020_seguimientoPaciente WHERE idReferencia=t.id__1022_tablaDinamica ORDER BY fechaContacto DESC,idCuestionarioSeguimiento DESC limit 0,1) as seContacto,
					(SELECT u.Nombre  FROM 3021_responsableSeguimientoPaciente r,800_usuarios u WHERE idPaciente=t.id__1022_tablaDinamica AND u.idUsuario=r.idResponsableSeguimiento) as responsableSeguimiento
					FROM _1022_tablaDinamica t where idEstado in (SELECT etapa FROM _1034_tablaDinamica) ".$comp.")
					as tmp where ".$condWhere." ORDER BY folio";
					
		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		$registros="";
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT * FROM 3020_seguimientoPaciente WHERE idReferencia=".$fila[0]." ORDER BY fechaContacto DESC,idCuestionarioSeguimiento DESC";
			$fUltimo=$con->obtenerPrimeraFila($consulta);
			
			
			if(($fUltimo[23]!="")&&($fechaActual>=strtotime($fUltimo[23])))
			{
			
				$lblTipoContacto="";
				$tipoContacto=$fUltimo[5];
				$valorReferencia=$fUltimo[6];
				$idReferencia=$fUltimo[1];
				switch($tipoContacto)
				{
					case "1":
						$lblTipoContacto="Llamada telefónica a: ".$valorReferencia."";
					break;
					case "2":
						$lblTipoContacto="Correo electr&oacute;nico a: ".$valorReferencia."";
					break;	
				}
				$descripcionUltimoSeguimiento=$lblTipoContacto;
				
				
				$lblMotivoNoContacto="";
				$pos=existeValorMatriz($arrMotivosNoContacto,$fUltimo[21]);
				if($pos!=-1)
					$lblMotivoNoContacto=$arrMotivosNoContacto[$pos][1];
				
				
				$pos=existeValorMatriz($arrMotivosNoAgenda,$fUltimo[25]);
			
				$motivoNoAgenda="";
				if($pos!=-1)
				{
					$motivoNoAgenda=$arrMotivosNoAgenda[$pos][1];
					if($fUltimo[25]==3)
					{
						$motivoNoAgenda.=": ".$fUltimo[27];	
					}
				}
				
				
				$consulta="SELECT email FROM _1022_gridEmail WHERE idReferencia=".$fila[0];
				$lMail=$con->obtenerListaValores($consulta,"'");
				if($lMail=="")
					$lMail=-1;
				
				
				$consulta="SELECT COUNT(*) FROM 3027_eMailRecibidos WHERE remitente IN (".$lMail.") AND situacion=0";
				$eMailSinLeer=$con->obtenerValor($consulta);
				
				$consulta="SELECT COUNT(*) FROM 3027_eMailRecibidos WHERE remitente IN (".$lMail.") AND situacion2=0";
				$eMailSinClasificar=$con->obtenerValor($consulta);
				
				
				switch($tipoContacto)
				{
					case 1:
					
					break;
					case 2:
						$consulta="SELECT situacion FROM 3026_mensajesContactoPaciente WHERE idReferenciaContacto=".$fUltimo[0];
						$situacion=$con->obtenerValor($consulta);
						switch($situacion)
						{
							case 1:
								$fUltimo[7]=2;
							break;
							case 2:
								$fUltimo[7]=1;
							break;
							case 3:
								$fUltimo[7]=0;
							break;	
						}
					break;
				}
				
				$obj='{"tipoIntentoContacto":"'.$tipoContacto.'","eMailSinLeer":"'.$eMailSinLeer.'","eMailSinClasificar":"'.$eMailSinClasificar.'","jurisdiccion":"'.$fila[8].'","idFolio":"'.$fila[0].'","folio":"'.$fila[1].'","fechaLlenado":"'.$fila[2].'","fechaCaptura":"'.$fila[3].'","apPaterno":"'.$fila[4].'","apMaterno":"'.$fila[5].'","nombre":"'.$fila[6].'","situacion":"'.$fila[7].
					'","fechaUltimoSeguimiento":"'.$fUltimo[2].'","seContacto":"'.$fUltimo[7].'","proximaLlamada":"'.$fUltimo[23].'","comentariosAdicionales":"'.cv($fUltimo[26]).'","descripcionUltimoSeguimiento":"'.cv($descripcionUltimoSeguimiento).'","agendarSeguimiento":"'.$fUltimo[22].
					'","motivoNOAgenda":"'.$motivoNoAgenda.'","motivoNoContacto":"'.$lblMotivoNoContacto.'","responsableSeguimiento":"'.cv($fila[12]).'"}';	
				if($registros=="")
					$registros=$obj;
				else
					$registros.=",".$obj;
				$numReg++;
			}
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';		
	}
	
	function obtenerRegistrosFoliosAcompanamientoNuevos()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		
		
		$fechaActual=strtotime(date("Y-m-d"));
		
		
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		
		$arrMotivosNoContacto=array();
		$arrMotivosNoContacto[0][0]="1";
		$arrMotivosNoContacto[0][1]="Se dejó recado";
		$arrMotivosNoContacto[1][0]="2";
		$arrMotivosNoContacto[1][1]="Fuera de Servicio";
		$arrMotivosNoContacto[2][0]="3";
		$arrMotivosNoContacto[2][1]="No contestan";
		
		
		
		$arrMotivosNoAgenda=array();
		$arrMotivosNoAgenda[0][0]="1";
		$arrMotivosNoAgenda[0][1]="Número telefónico no existe";
		$arrMotivosNoAgenda[1][0]="2";
		$arrMotivosNoAgenda[1][1]="Número equivocado";
		$arrMotivosNoAgenda[2][0]="3";
		$arrMotivosNoAgenda[2][1]="Otro";
		
		$consulta="select * from (SELECT id__1022_tablaDinamica AS idFolio,folio,fechaLlenado,fechaCreacion AS fechaCaptura,apPaterno,apMaterno,nombres AS nombre,idEstado AS situacion,jurisdiccion,
					(select count(*) from 3021_responsableSeguimientoPaciente where idPaciente=t.id__1022_tablaDinamica and fechaBaja is null) as nSeguimiento 
					FROM _1022_tablaDinamica t where idEstado in (SELECT etapa FROM _1034_tablaDinamica)
						)
					as tmp where ".$condWhere." and nSeguimiento=0 ORDER BY folio";
					
		
		$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		
		$consulta="select * from (SELECT id__1022_tablaDinamica AS idFolio,folio,fechaLlenado,fechaCreacion AS fechaCaptura,apPaterno,apMaterno,nombres AS nombre,idEstado AS situacion,jurisdiccion,
					(select count(*) from 3021_responsableSeguimientoPaciente where idPaciente=t.id__1022_tablaDinamica and fechaBaja is null) as nSeguimiento 
					FROM _1022_tablaDinamica t where idEstado in (SELECT etapa FROM _1034_tablaDinamica)
						)
					as tmp where ".$condWhere." and nSeguimiento=0 ORDER BY folio limit ".$start.",".$limit ;
					
		
					
		$res=$con->obtenerFilas($consulta);
		
		$registros="";
		while($fila=mysql_fetch_row($res))
		{
			$lblTipoContacto="";
			$tipoContacto=$fUltimo[5];
			$valorReferencia=$fUltimo[6];
			$idReferencia=$fUltimo[1];
			switch($tipoContacto)
			{
				case "1":
					$lblTipoContacto="Llamada telefónica a: ".$valorReferencia."";
				break;
				case "2":
					$lblTipoContacto="Correo electr&oacute;nico a: ".$valorReferencia."";
				break;	
			}
			$descripcionUltimoSeguimiento=$lblTipoContacto;
			
			
			$lblMotivoNoContacto="";
			$pos=existeValorMatriz($arrMotivosNoContacto,$fUltimo[21]);
			if($pos!=-1)
				$lblMotivoNoContacto=$arrMotivosNoContacto[$pos][1];
			
			
			$pos=existeValorMatriz($arrMotivosNoAgenda,$fUltimo[25]);
		
			$motivoNoAgenda="";
			if($pos!=-1)
			{
				$motivoNoAgenda=$arrMotivosNoAgenda[$pos][1];
				if($fUltimo[25]==3)
				{
					$motivoNoAgenda.=": ".$fUltimo[27];	
				}
			}
			
			
			$obj='{"jurisdiccion":"'.$fila[8].'","idFolio":"'.$fila[0].'","folio":"'.$fila[1].'","fechaLlenado":"'.$fila[2].'","fechaCaptura":"'.$fila[3].'","apPaterno":"'.$fila[4].'","apMaterno":"'.$fila[5].'","nombre":"'.$fila[6].'","situacion":"'.$fila[7].
				'","fechaUltimoSeguimiento":"'.$fUltimo[2].'","seContacto":"'.$fUltimo[7].'","proximaLlamada":"'.$fUltimo[23].'","comentariosAdicionales":"'.cv($fUltimo[26]).'","descripcionUltimoSeguimiento":"'.cv($descripcionUltimoSeguimiento).'","agendarSeguimiento":"'.$fUltimo[22].
				'","motivoNOAgenda":"'.$motivoNoAgenda.'","motivoNoContacto":"'.$lblMotivoNoContacto.'"}';	
			if($registros=="")
				$registros=$obj;
			else
				$registros.=",".$obj;
			
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';		
	}
	
	function registrarCorreoContacto()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];	
		$email=$_POST["email"];
		
		$consulta="INSERT INTO _1022_gridEmail(idReferencia,email) VALUES(".$idRegistro.",'".cv($email)."')";
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|".$con->obtenerUltimoID();	
		}
		
		
	}
	
	function registrarTelefonoContacto()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];	
		$lada=$_POST["lada"];
		$telefono=$_POST["telefono"];
		$tipo=$_POST["tipo"];
		
		$consulta="INSERT INTO _1022_gridTelefono(idReferencia,tipo,lada,numero) VALUES(".$idRegistro.",".$tipo.",'".$lada."','".$telefono."')";
		
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|".$con->obtenerUltimoID();	
		}
		
		
	}
	
	function buscarCentrosSalud()
	{
		global $con;
		$tBusqueda=$_POST["tBusqueda"];
		$consulta="";
		$listOrganigrama=-1;
		switch($tBusqueda)
		{
			case 1:
				$estado=$_POST["estado"];
				$municipio=$_POST["municipio"];
				
				$consulta="SELECT idOrganigrama FROM 247_instituciones WHERE estado='".$estado."'";
				if($municipio!="")
					$consulta.=" AND municipio='".$municipio."'";
				$listOrganigrama=$con->obtenerListaValores($consulta);
				if($listOrganigrama=="")
					$listOrganigrama=-1;
				
			break;
			case 2:
				$cp=$_POST["cp"];
				$consulta="SELECT idOrganigrama FROM 247_instituciones WHERE cp like '".$cp."%'";
				$listOrganigrama=$con->obtenerListaValores($consulta);
				if($listOrganigrama=="")
					$listOrganigrama=-1;
			break;	
		}
		
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT codigoUnidad,unidad,idOrganigrama FROM 817_organigrama where idOrganigrama IN (".$listOrganigrama.") AND institucion=9";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$telefonos="";
			$consulta="SELECT tipoTel,lada,telefono, extension FROM 818_telefonosOrganigrama WHERE idOrganigrama=".$fila[2];
			$rTelefonos=$con->obtenerFilas($consulta);
			while($ftelefonos=mysql_fetch_row($rTelefonos))
			{
				$t="";
				if($ftelefonos[1]!="")
					$t="(".$ftelefonos[1].") ";
				
				$t.=$ftelefonos[2];
				if($ftelefonos[3]!="")
					$t.=" (Ext. ".$ftelefonos[3].")";
				
				if($telefonos=="")
					$telefonos=$t;
				else
					$telefonos.=", ".$t;
			}
			
			
			$domicilio="";
			
			$consulta="select i.ciudad,i.estado, p.nombre,i.cp,i.municipio,i.email,calle,numero,colonia from 247_instituciones i,238_paises p where p.idPais=i.idPais and i.idOrganigrama=".$fila[2];
			$datosInst=$con->obtenerPrimeraFila($consulta);
			$datos="";
			
			
			if($datosInst[6]!="")
			{
				$domicilio=$datosInst[6];	
			}
			
			if($datosInst[7]!="")
			{
				$particula="";
				if($domicilio=="")
					$domicilio=" No. ".$datosInst[7];
				else
					$domicilio.=" No. ".$datosInst[7];

			}
			
			if($datosInst[8]!="")
			{
				$particula="";
				if($domicilio=="")
					$domicilio=" Colonia ".$datosInst[8];
				else
					$domicilio.=" Colonia ".$datosInst[8];

			}
			
			
			if($datosInst[3]!="")
			{
				if($domicilio=="")
					$domicilio="CP. ".$datosInst[3];
				else
					$domicilio.=". CP. ".$datosInst[3];
				
			}
			
			
			if($datosInst[0]!="")
			{
				$particula="";
				$consulta="select localidad FROM 822_localidades WHERE cveLocalidad='".$datosInst[0]."'";
				$localidad=$con->obtenerValor($consulta);
				if($localidad!="")
					$particula=$localidad;
				else
					$particula=", ".$datosInst[0];
				
				if($domicilio=="")
					$domicilio=$particula;
				else
					$domicilio.=", ".$particula;
			}
			
			if($datosInst[4]!="")
			{
				
				$particula="";
				$consulta="select municipio FROM 821_municipios WHERE cveMunicipio='".$datosInst[4]."'";
				$mpio=$con->obtenerValor($consulta);
				if($mpio!="")
					$particula=$mpio;
				else
					$particula=$datosInst[4];
				
				if($domicilio=="")
					$domicilio=$particula;
				else
					$domicilio.=", ".$particula;
			}
			
			if($datosInst[1]!="")
			{
				
				$particula="";
				$consulta="select estado FROM 820_estados WHERE cveEstado='".$datosInst[1]."'";
				$estado=$con->obtenerValor($consulta);
				if($estado!="")
					$particula=$estado;
				else
					$particula=$datosInst[1];
				
				if($domicilio=="")
					$domicilio=$particula;
				else
					$domicilio.=", ".$particula;
			}
			
			if($datosInst[2]!="")
			{
				$particula=$datosInst[2];
				if($domicilio=="")
					$domicilio=$particula;
				else
					$domicilio.=", ".$particula;
				
			}
			
			
			
			$o='{"codigoUnidad":"'.$fila[0].'","centroSalud":"'.cv($fila[1]).'","domicilio":"'.cv($domicilio).'","telefono":"'.$telefonos.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function enviarDatosCentroSaludPaciente()
	{
		global $con;
		$cc=bD($_POST["cc"]);
		$d=bD($_POST["d"]);
		$t=bD($_POST["t"]);
		$i=$_POST["i"];	
		
		if($t=="")
			$t="(No disponible)";
		$consulta="SELECT nombres,apPaterno,apMaterno FROM _1022_tablaDinamica WHERE id__1022_tablaDinamica=".$i;
		$fPaciente=$con->obtenerPrimeraFila($consulta);
		$arrParam=array();
		$arrParam["centroSalud"]=$cc;
		$arrParam["direccion"]=$d;
		$arrParam["telefono"]=$t;
		$arrParam["paciente"]=$fPaciente[0]." ".$fPaciente[1]." ".$fPaciente[2];
		
		$consulta="SELECT email FROM _1022_gridEmail WHERE idReferencia=".$i;
		$rUsuarios=$con->obtenerFilas($consulta);			
		while($fUsuario=mysql_fetch_row($rUsuarios))
		{
			$arrParam["eMailReceptor"]=$fUsuario[0];
			enviarMensajeEnvio(17,$arrParam);	
		}
		if($con->filasAfectadas>0)
			echo "1|1";
		else
			echo "1|0";
		
		
			
	}
	
	function registrarBajaSeguimientoPaciente()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];	
		$consulta="UPDATE 3021_responsableSeguimientoPaciente SET fechaBaja='".date("Y-m-d H:i:s")."' WHERE idPaciente=".$idRegistro." AND idResponsableSeguimiento=".$_SESSION["idUsr"];
		eC($consulta);
		
		
	}
	
	function obtenerRegistrosFoliosPacientesDiagnosticados()
	{
		global $con;
		$idSerie=$_POST["idSerie"];
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		
		$comp="";
		$codigoInstitucion=$_SESSION["codigoInstitucion"];
		$consulta="SELECT institucion FROM 817_organigrama WHERE codigoUnidad='".$codigoInstitucion."'";
		$institucion=$con->obtenerValor($consulta);
		switch($institucion) 
		{
			case 9: //Centro de salud
				$comp=" and codigoInstitucion='".$codigoInstitucion."'";
			break;
			case 12: //Centro de atencion

			break;
		}
		$consulta="select * from (SELECT id__1022_tablaDinamica AS idFolio,folio,fechaLlenado,fechaCreacion AS fechaCaptura,apPaterno,apMaterno,nombres AS nombre,idEstado AS situacion,jurisdiccion
		 FROM _1022_tablaDinamica t where idSerie=".$idSerie.$comp." and idEstado=6)
				tmo where ".$condWhere."  ORDER BY folio";
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		$numReg=$con->filasAfectadas;
		echo '{"numReg":"'.$numReg.'","registros":'.$registros.'}';
	}
	
	function obtenerHistorialEstudiosTratamiento()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];	
		$idProyecto=$_POST["idProyecto"];	
		
		
		$tipo=$_POST["tipo"];
		
		$arrConsulta="";
		
		
		
		$consulta="SELECT id__1025_tablaDinamica FROM _1025_tablaDinamica t WHERE idReferencia=".$idProyecto;
		$idReferencia=$con->obtenerValor($consulta);
		if($idReferencia=="")
			$idReferencia=-1;
			
		$consulta="SELECT tratamiento AS resultado FROM _1025_gTratamientos WHERE idReferencia=".$idReferencia."
					UNION
					SELECT estudio AS resultado FROM _1025_gEstudiosAplicables WHERE idReferencia=".$idReferencia;
						
		$listaRegistros="";
		$listaRegistros=$con->obtenerListaValores($consulta);
		if($listaRegistros=="")
		{
			$listaRegistros=-1	;
		}
		
		$consulta="SELECT id__1041_tablaDinamica,formularioAsociado,funcionInterpretacion FROM _1041_tablaDinamica WHERE tipo=".$tipo." and id__1041_tablaDinamica in (".$listaRegistros.")";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$cAux="(SELECT id__".$fila[1]."_tablaDinamica AS idRegistro,'".$fila[0]."' AS tipoEstudio,'".$fila[1]."' AS idFormulario,fechaRealizacion,comentariosAdicionales,'".$fila[2]."' as funcionInterpretacion FROM _".$fila[1]."_tablaDinamica WHERE idReferencia=".$idRegistro." and idProyecto=".$idProyecto.")";	
			if($arrConsulta=="")
				$arrConsulta=$cAux;
			else
				$arrConsulta.=" union ".$cAux;
		}
		$numReg=0;
		$registros="";
		$consulta="select * from (".$arrConsulta.") as tmp order by fechaRealizacion desc,idRegistro desc";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$descripcion="";
			if($fila[5]!="")
			{
				$oNull=NULL;
				$cadObj='{"idProyecto":"'.$idProyecto.'","tipoEstudio":"'.$fila[1].'","idFormulario":"'.$fila[1].'","idRegistro":"'.$fila[0].'"}';
				$objParam1=json_decode($cadObj);
				$descripcion=resolverExpresionCalculoPHP($fila[5],$objParam1,$oNull);	
			}
			
			$o='{"idRegistro":"'.$fila[0].'","fechaRealizacion":"'.$fila[3].'","tipoEstudio":"'.$fila[1].'","descripcion":"'.cv(removerComillasLimite($descripcion)).'","idFormulario":"'.$fila[2].'","comentariosAdicionales":"'.cv($fila[4]).'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
		
	}
	
	function registrarEventoAdverso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$arrAux=array();
		foreach($obj->arrDetalle as $d)
		{
			$c="";
			$fTermino="NULL";
			if(isset($d->fechaTermino))
				$fTermino="'".$d->fechaTermino."'";
			if(($d->idArchivo!="")&&($d->idArchivo!=-1))
			{
				$idDocumento=registrarDocumentoServidor($d->idArchivo,$d->nombreArchivo);
				$cadObj=str_replace('"idArchivo":"'.$d->idArchivo.'"','"idArchivo":"'.$idDocumento.'"',$cadObj);
				$c="INSERT INTO 1021_consecuenciasReporteEventoAdverso(tipoDetalle,detalle,idArchivo,nombreArchivo,fechaTermino,idReporteEvento)
					VALUES(".$d->tipoDetalle.",'".cv($d->detalle)."',".$idDocumento.",'".$d->nombreArchivo."',".$fTermino.",@idReporte)";
				
				
			}
			else
			{
				$c="INSERT INTO 1021_consecuenciasReporteEventoAdverso(tipoDetalle,detalle,idArchivo,nombreArchivo,fechaTermino,idReporteEvento)
					VALUES(".$d->tipoDetalle.",'".cv($d->detalle)."',-1,'',".$fTermino.",@idReporte)";
			}
			array_push($arrAux,$c);
			
		}
		
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="INSERT INTO 1020_reportesEventoAdverso(fechaCreacion,fechaEvento,idResponsable,idProyecto,objReporte,situacion,fechaDictamen,comentariosRespuesta,tipoEvento,idMedicamento,eventoSerio,
					idFormatoEventoSerio,idInvestigadorResponsable,descripcion,idReferencia)
					VALUES('".date("Y-m-d H:i:s")."','".$obj->fechaEvento."',".$_SESSION["idUsr"].",".$obj->idProyecto.",'".cv($cadObj)."',1,null,'',".$obj->tipoEvento.",".$obj->idMedicamento.",".$obj->eventoSerio.",".$obj->idNotificacionEventoAdverso.
					",NULL,'".cv($obj->descripcion)."',".$obj->idReferencia.")";
		$x++;
		$query[$x]="set @idReporte:=(select last_insert_id())";
		$x++;
			
		
		
		foreach($arrAux as $c)
		{
			$query[$x]=$c;
			$x++;
		}
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))	
		{
			if($idInvestigador!="")
			{
				$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$idInvestigador;
				$mail=$con->obtenerValor($consulta);
				if($mail!="")
				{
					$consulta="select @idReporte";
					$idEvento=$con->obtenerValor($consulta);
					$nombre=obtenerNombreUsuario($idInvestigador);
					
					$consulta="select concat('[Folio: ',codigo,'] ',tituloProyecto) FROM _278_tablaDinamica t WHERE id__278_tablaDinamica=".$idProyecto;
					$proyecto=$con->obtenerValor($consulta);			
					$folio=str_pad($idEvento,8,"0",STR_PAD_LEFT);
					
					$consulta="SELECT asunto,cuerpo FROM 2004_mensajesAcciones WHERE idAccionEnvio=5";
					$fMail=$con->obtenerPrimeraFila($consulta);
					$mensaje=str_replace("@Investigador",$nombre,$fMail[1]);
					$mensaje=str_replace("@folio",$folio,$mensaje);
					$mensaje=str_replace("@proyecto",$proyecto,$mensaje);
					
					
					
					enviarMail($mail,$fMail[0],$mensaje);
					
				}
				
			}
		}
		echo "1|";
			
	}
	
	function obtenerEventosAdversos()
	{
		global $con;	
		$idRegistro=$_POST["idRegistro"];	
		$idProyecto=$_POST["idProyecto"];
		$consulta="SELECT idReporteEventoAdverso AS idRegistro, fechaEvento,tipoEvento,eventoSerio,descripcion FROM 1020_reportesEventoAdverso WHERE idProyecto=".$idRegistro." and idReferencia=".$idProyecto;
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';	
	}
	
	function registrarParametrosPaciente()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		
		
		if($obj->categoriaT=="")
			$obj->categoriaT="NULL";
		if($obj->categoriaM=="")
			$obj->categoriaM="NULL";
		if($obj->categoriaN=="")
			$obj->categoriaN="NULL";
		
		$consulta="SELECT idRegistro FROM 3022_parametrosPaciente WHERE idPaciente=".$obj->idPaciente;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro==1)
			$consulta="UPDATE 3022_parametrosPaciente SET categoriaT=".$obj->categoriaT.",categoriaM=".$obj->categoriaM.",categoriaN=".$obj->categoriaN.",esperanzaVida=".$obj->esperanzaVida." WHERE idRegistro=".$idRegistro;
		else
			$consulta="INSERT INTO 3022_parametrosPaciente( categoriaT,categoriaM,categoriaN,esperanzaVida,idPaciente) VALUES(".$obj->categoriaT.",".$obj->categoriaM.",".$obj->categoriaN.",".$obj->esperanzaVida.",".$obj->idPaciente.")";
		eC($consulta);
		
	}
	
	function evaluarDiagnosticoPaciente()
	{
		global $con;	
		$idPaciente=$_POST["idPaciente"];
		
		$consulta="SELECT * FROM 3022_parametrosPaciente WHERE idPaciente=".$idPaciente;
		$fPaciente=$con->obtenerPrimeraFila($consulta);
		if($fPaciente)
		{
			$categoriaT=$fPaciente[1];
			$categoriaM=$fPaciente[2];
			$categoriaN=$fPaciente[3];
			$esperanzaVida=$fPaciente[4];
			$densidadAPE=NULL;
			
			$gleason=NULL;
			$ultimaBiopsia=NULL;
			
			$arrAPE=obtenerEstudiosTratamientosPaciente($idPaciente,1);
			
			if(sizeof($arrAPE)>0)
			{
				$densidadAPE=$arrAPE[sizeof($arrAPE)-1]	["nivelAPE"];
				
			}
			
			$arrBiopsia=obtenerEstudiosTratamientosPaciente($idPaciente,3);
			
			if(sizeof($arrBiopsia)>0)
			{
				$ultimaBiopsia=$arrBiopsia[sizeof($arrBiopsia)-1];	
				$gleason=$ultimaBiopsia["sumaGleason"];
				
			}
			
			$arrTactoRectal=obtenerEstudiosTratamientosPaciente($idPaciente,2);
			
			
			
			
			
			
			$objDiagnostico["riesgoPaciente"]="0";
			$objDiagnostico["idPaciente"]=$idPaciente;
			$objDiagnostico["estudios"]=array();
			$objDiagnostico["recomendaciones"]=array();
			
			if(($densidadAPE!=NULL)&&($ultimaBiopsia!=NULL))
			{
				/*$arrCategorias[1]["29"]=array();
				array_push($arrCategorias[1]["29"],1);
				
				$arrCategorias[2]["29"]=array();
				array_push($arrCategorias[2]["29"],1);
				array_push($arrCategorias[2]["29"],2);
				array_push($arrCategorias[2]["29"],3);
				array_push($arrCategorias[2]["29"],4);
				
				
				$arrCategorias[3]["29"]=array();
				array_push($arrCategorias[3]["29"],5);
				array_push($arrCategorias[3]["29"],6);
				
				
				$arrCategorias[4]["29"]=array();
				array_push($arrCategorias[4]["29"],7);
				
				$arrCategorias[5]["29"]=array();
				array_push($arrCategorias[5]["29"],8);
				array_push($arrCategorias[5]["29"],9);*/
	
	
				if((($categoriaT>=8)&&($categoriaT<=9))||($categoriaN==3))
				{
					$objDiagnostico["riesgoPaciente"]=5;
				}
				else
				{
					if(($densidadAPE>=20)||(($gleason>=8)&&($gleason<=10))||($categoriaT=="7"))		
					{
						$objDiagnostico["riesgoPaciente"]=4;	
					}
					else
					{
						if((($categoriaT>=5)&&($categoriaT<=6))&&($gleason==7)&&(($densidadAPE>=10)&&($densidadAPE<=20)))
						{
							$objDiagnostico["riesgoPaciente"]=3;	
						}
						else
						{
							
							$cumpleCriterioBiopsia=false;
							$nBiopsias=0;
							foreach($ultimaBiopsia as $m)
							{
								if(($m["resultado"]==1)	&&($m["porcentaje"]<50))
								{
									$nBiopsias++;	
								}
							}
							if($nBiopsias<3)
								$cumpleCriterioBiopsia=true;
							if(($categoriaT==3)&&($gleason<=6)&&($densidadAPE<=0.15)&&($cumpleCriterioBiopsia))
								$objDiagnostico["riesgoPaciente"]=1;
							else
								$objDiagnostico["riesgoPaciente"]=2;
								
						}
					}
				}
			
			}
			
			
			
			switch($objDiagnostico["riesgoPaciente"])			
			{
				case 1:
					
					if($esperanzaVida<20)
					{
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="4";
						array_push($objDiagnostico["estudios"],$oEstudio);
						
						$oEstudio=array();
						$oEstudio["tipo"]="1";
						$oEstudio["idEstudioDiagnostico"]="1";
						array_push($objDiagnostico["estudios"],$oEstudio);
						$oEstudio=array();
						$oEstudio["tipo"]="1";
						$oEstudio["idEstudioDiagnostico"]="2";
						array_push($objDiagnostico["estudios"],$oEstudio);
						
						$cambioProstata=false;
						$elevacionAPE=false;
						
						if(sizeof($arrTactoRectal)>1)
						{
							$muestra1=$arrTactoRectal[sizeof($arrTactoRectal)-1];
							$muestra2=$arrTactoRectal[sizeof($arrTactoRectal)-2];
							
							if($muestra1["resultado"]!=$muestra2["resultado"])
							{
								$cambioProstata=true;
							}
							
							
								
						}
						
						if(sizeof($arrAPE)>1)
						{
							$muestra1=$arrAPE[sizeof($arrTactoRectal)-1];
							$muestra2=$arrAPE[sizeof($arrTactoRectal)-2];
							
							if(($muestra2["nivelAPE"]*2)<=$muestra2["nivelAPE"])
							{
								$elevacionAPE=true;	
							}
							
						}
						
						if(($esperanzaVida>=10)&&($cambioProstata|| $elevacionAPE))
						{
							$oEstudio=array();
							$oEstudio["tipo"]="1";
							$oEstudio["idEstudioDiagnostico"]="3";
							array_push($objDiagnostico["estudios"],$oEstudio);
						}
						
						
						
						
						$oComentario=array();
						$oComentario["recomendaciones"]="APE cada 3 a 6 meses";
						array_push($objDiagnostico["recomendaciones"],$oComentario);
						
						$oComentario=array();
						$oComentario["recomendaciones"]="TR cada 6 a 12 meses";
						array_push($objDiagnostico["recomendaciones"],$oComentario);
						
						if($esperanzaVida>=10)
						{
							if(sizeof($ultimaBiopsia["muestras"])<10)
							{
								$oComentario=array();
								$oComentario["recomendaciones"]="Biopsia con aguja en 6 meses";
								array_push($objDiagnostico["recomendaciones"],$oComentario);
							}
							else
							{
								$oComentario=array();
								$oComentario["recomendaciones"]="Biopsia con aguja en 12 a 18 meses";
								array_push($objDiagnostico["recomendaciones"],$oComentario);	
							}
						}
						
						
						
					}
					else
					{
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="5";
						array_push($objDiagnostico["estudios"],$oEstudio);
					}
					
				
				break;
				case 2:
					if($esperanzaVida<10)
					{
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="4";
						array_push($objDiagnostico["estudios"],$oEstudio);
					}
					else
					{
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="4";
						array_push($objDiagnostico["estudios"],$oEstudio);
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="5";
						array_push($objDiagnostico["estudios"],$oEstudio);
					}
					
					
					$oEstudio=array();
					$oEstudio["tipo"]="1";
					$oEstudio["idEstudioDiagnostico"]="1";
					array_push($objDiagnostico["estudios"],$oEstudio);
					$oEstudio=array();
					$oEstudio["tipo"]="1";
					$oEstudio["idEstudioDiagnostico"]="2";
					array_push($objDiagnostico["estudios"],$oEstudio);
					
					
					
					$cambioProstata=false;
					$elevacionAPE=false;
					
					if(sizeof($arrTactoRectal)>1)
					{
						$muestra1=$arrTactoRectal[sizeof($arrTactoRectal)-1];
						$muestra2=$arrTactoRectal[sizeof($arrTactoRectal)-2];
						
						if($muestra1["resultado"]!=$muestra2["resultado"])
						{
							$cambioProstata=true;
						}
						
						
							
					}
					
					if(sizeof($arrAPE)>1)
					{
						$muestra1=$arrAPE[sizeof($arrTactoRectal)-1];
						$muestra2=$arrAPE[sizeof($arrTactoRectal)-2];
						
						if(($muestra2["nivelAPE"]*2)<=$muestra2["nivelAPE"])
						{
							$elevacionAPE=true;	
						}
						
					}
					
					if(($esperanzaVida>=10)&&($cambioProstata|| $elevacionAPE))
					{
						$oEstudio=array();
						$oEstudio["tipo"]="1";
						$oEstudio["idEstudioDiagnostico"]="3";
						array_push($objDiagnostico["estudios"],$oEstudio);
					}
					
					
					$oComentario=array();
					$oComentario["recomendaciones"]="APE cada 3 a 6 meses";
					array_push($objDiagnostico["recomendaciones"],$oComentario);
					
					$oComentario=array();
					$oComentario["recomendaciones"]="TR cada 6 a 12 meses";
					array_push($objDiagnostico["recomendaciones"],$oComentario);
					
					if($esperanzaVida>=10)
					{
						if(sizeof($ultimaBiopsia["muestras"])<10)
						{
							$oComentario=array();
							$oComentario["recomendaciones"]="Biopsia con aguja en 6 meses";
							array_push($objDiagnostico["recomendaciones"],$oComentario);
						}
						else
						{
							$oComentario=array();
							$oComentario["recomendaciones"]="Biopsia con aguja en 12 a 18 meses";
							array_push($objDiagnostico["recomendaciones"],$oComentario);	
						}
					}
					
				break;
				case 3:
					if($esperanzaVida<10)
					{
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="4";
						array_push($objDiagnostico["estudios"],$oEstudio);
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="5";
						array_push($objDiagnostico["estudios"],$oEstudio);
					}
					else
					{
						
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="5";
						array_push($objDiagnostico["estudios"],$oEstudio);
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="6";
						array_push($objDiagnostico["estudios"],$oEstudio);
					}
					
					
					$oEstudio=array();
					$oEstudio["tipo"]="1";
					$oEstudio["idEstudioDiagnostico"]="1";
					array_push($objDiagnostico["estudios"],$oEstudio);
					$oEstudio=array();
					$oEstudio["tipo"]="1";
					$oEstudio["idEstudioDiagnostico"]="2";
					array_push($objDiagnostico["estudios"],$oEstudio);
					
					
					
					$cambioProstata=false;
					$elevacionAPE=false;
					
					if(sizeof($arrTactoRectal)>1)
					{
						$muestra1=$arrTactoRectal[sizeof($arrTactoRectal)-1];
						$muestra2=$arrTactoRectal[sizeof($arrTactoRectal)-2];
						
						if($muestra1["resultado"]!=$muestra2["resultado"])
						{
							$cambioProstata=true;
						}
						
						
							
					}
					
					if(sizeof($arrAPE)>1)
					{
						$muestra1=$arrAPE[sizeof($arrTactoRectal)-1];
						$muestra2=$arrAPE[sizeof($arrTactoRectal)-2];
						
						if(($muestra2["nivelAPE"]*2)<=$muestra2["nivelAPE"])
						{
							$elevacionAPE=true;	
						}
						
					}
					
					if(($esperanzaVida>=10)&&($cambioProstata|| $elevacionAPE))
					{
						$oEstudio=array();
						$oEstudio["tipo"]="1";
						$oEstudio["idEstudioDiagnostico"]="3";
						array_push($objDiagnostico["estudios"],$oEstudio);
					}
					
					
					$oComentario=array();
					$oComentario["recomendaciones"]="APE cada 3 a 6 meses";
					array_push($objDiagnostico["recomendaciones"],$oComentario);
					
					$oComentario=array();
					$oComentario["recomendaciones"]="TR cada 6 a 12 meses";
					array_push($objDiagnostico["recomendaciones"],$oComentario);
					
					if($esperanzaVida>=10)
					{
						if(sizeof($ultimaBiopsia["muestras"])<10)
						{
							$oComentario=array();
							$oComentario["recomendaciones"]="Biopsia con aguja en 6 meses";
							array_push($objDiagnostico["recomendaciones"],$oComentario);
						}
						else
						{
							$oComentario=array();
							$oComentario["recomendaciones"]="Biopsia con aguja en 12 a 18 meses";
							array_push($objDiagnostico["recomendaciones"],$oComentario);	
						}
					}
					
				break;
				case 4:
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="5";
					array_push($objDiagnostico["estudios"],$oEstudio);
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="6";
					array_push($objDiagnostico["estudios"],$oEstudio);
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="7";
					array_push($objDiagnostico["estudios"],$oEstudio);
				break;
				case 5:
					if($categoriaN==3)
					{
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="5";
						array_push($objDiagnostico["estudios"],$oEstudio);
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="9";
						array_push($objDiagnostico["estudios"],$oEstudio);
					}
					else
					{
						if($categoriaT==9)	
						{
							$oEstudio=array();
							$oEstudio["tipo"]="2";
							$oEstudio["idEstudioDiagnostico"]="5";
							array_push($objDiagnostico["estudios"],$oEstudio);
							$oEstudio=array();
							$oEstudio["tipo"]="2";
							$oEstudio["idEstudioDiagnostico"]="8";
							array_push($objDiagnostico["estudios"],$oEstudio);
						}
						else
						{
							
							$oEstudio=array();
							$oEstudio["tipo"]="2";
							$oEstudio["idEstudioDiagnostico"]="5";
							array_push($objDiagnostico["estudios"],$oEstudio);
							$oEstudio=array();
							$oEstudio["tipo"]="2";
							$oEstudio["idEstudioDiagnostico"]="8";
							array_push($objDiagnostico["estudios"],$oEstudio);
														$oEstudio=array();
							$oEstudio["tipo"]="2";
							$oEstudio["idEstudioDiagnostico"]="6";
							array_push($objDiagnostico["estudios"],$oEstudio);
							$oEstudio=array();
							$oEstudio["tipo"]="2";
							$oEstudio["idEstudioDiagnostico"]="7";
							array_push($objDiagnostico["estudios"],$oEstudio);
						}
						
					}
				break;	
			}
			
			if(registrarDiagnosticoPaciente($objDiagnostico))
			
				echo "1|".$objDiagnostico["riesgoPaciente"];	
			else
				echo "1|";
		
			
			
		}
		else
			echo "1|";
		
		
	}
	
	function obtenerDiagnosticoPaciente()
	{
		global $con;	
		$idPaciente=$_POST["idRegistro"];
		
		$consulta="SELECT * FROM 3023_evaluacionPaciente WHERE idPaciente=".$idPaciente." ORDER BY  fechaDiagnostico DESC,idRegistro DESC";
		$fDiagnostico=$con->obtenerPrimeraFila($consulta);
		$numReg=0;
		$registros="";
		
		$arrTipos[0]="Estudios sugeridos";
		$arrTipos[1]="Tratamientos sugeridos";
		$arrTipos[2]="Notas adicionales";
		
		if($fDiagnostico)
		{
			$consulta="SELECT estudioTratamiento FROM _1041_tablaDinamica WHERE id__1041_tablaDinamica IN
					(SELECT idEstudioDiagnostico FROM 3024_estudiosTratamientosRecomendadosDiagnostico WHERE idDiagnostico=".$fDiagnostico[0]." AND tipo=1)";	
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$o='{"idRegistro":"'.$numReg.'","tipo":"'.cv($arrTipos[0]).'","descripcion":"'.$fila[0].'"}';
				if($registros=="")
					$registros=$o;
				else
					$registros.=",".$o;
			}
			
			$consulta="SELECT estudioTratamiento FROM _1041_tablaDinamica WHERE id__1041_tablaDinamica IN
					(SELECT idEstudioDiagnostico FROM 3024_estudiosTratamientosRecomendadosDiagnostico WHERE idDiagnostico=".$fDiagnostico[0]." AND tipo=2)";	
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$o='{"idRegistro":"'.$numReg.'","tipo":"'.cv($arrTipos[1]).'","descripcion":"'.$fila[0].'"}';
				if($registros=="")
					$registros=$o;
				else
					$registros.=",".$o;
			}
			
			$consulta="SELECT recomendacion FROM 3025_recomendacionesDiagnosticoPaciente WHERE idDiagnostico=".$fDiagnostico[0];	
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$o='{"idRegistro":"'.$numReg.'","tipo":"'.cv($arrTipos[2]).'","descripcion":"'.$fila[0].'"}';
				if($registros=="")
					$registros=$o;
				else
					$registros.=",".$o;
			}
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
		
		
	}
	
	function enviarMailPaciente()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
		$arrEmail=explode(",",$obj->destinatario);
		$emisor="contacto@unossegundos.org";
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		
		$consulta[$x]="INSERT INTO 3020_seguimientoPaciente(idReferencia,fechaContacto,horaContacto,idResponsableContacto,tipoIntentoContacto,referenciaContacto)
								VALUES(".$obj->idPaciente.",'".date("Y-m-d")."','".date("H:i:s")."',".$_SESSION["idUsr"].",2,'".$obj->destinatario."')";
		$x++;
		$consulta[$x]="set @idSeguimiento:=(select last_insert_id())";
		$x++;
				
		
		foreach($arrEmail as $m)
		{
			if(enviarMail($m,$obj->asunto,$obj->mensaje,$emisor,""))	
			{
				$consulta[$x]="INSERT INTO 3026_mensajesContactoPaciente(idPaciente,idReferenciaContacto,fechaCreacion,idResponsableEnvio,asunto,mensaje,destinatario)
							VALUES(".$obj->idPaciente.",@idSeguimiento,'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".cv($obj->asunto)."','".cv($obj->mensaje)."','".$m."')";
				$x++;
				$consulta[$x]="set @idMensaje:=(select last_insert_id())";
				$x++;
				
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerDatosMailSeguimiento()
	{
		global $con;	
		$iC=$_POST["iC"];
		
		
		$consulta="SELECT asunto,mensaje,destinatario,fechaCreacion FROM 3026_mensajesContactoPaciente WHERE idReferenciaContacto=".$iC;
		$fMail=$con->obtenerPrimeraFila($consulta);
		

		$cuerpo=str_replace("\r","<br>",$fMail[1]);
		$cuerpo=str_replace("\n","<br>",$fMail[1]);
		
		
		$cadObj='{"fechaEnvio":"'.$fMail[3].'","asunto":"'.cv($fMail[0]).'","destinatario":"'.cv($fMail[2]).'","adjuntos":[],"mensaje":"'.cv($cuerpo).'"}';
		echo "1|".$cadObj;
		
		
		
	}
	
	
	function obtenerDatosMailRespuesta()
	{
		global $con;	
		$iM=$_POST["iM"];
		
		
		$consulta="SELECT asunto,cuerpo,remitente,fechaMail FROM 3027_eMailRecibidos WHERE idEmail=".$iM;
		$fMail=$con->obtenerPrimeraFila($consulta);
		

		$cuerpo=str_replace("\r","<br>",$fMail[1]);
		$cuerpo=str_replace("\n","<br>",$fMail[1]);
		
		$adjuntos="";
		
		$consulta="SELECT a.idArchivo,nomArchivoOriginal,tamano  FROM 3028_eMailAdjuntos e,908_archivos a WHERE e.idMail=".$iM." AND a.idArchivo=e.idArchivo";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$a='{"idArchivo":"'.$fila[0].'","nombreArchivo":"'.cv($fila[1]).'","tamano":"'.$fila[2].'"}';
			if($adjuntos=="")
				$adjuntos=$a;
			else
				$adjuntos.=",".$a;
		}
		
		$cadObj='{"fechaEnvio":"'.$fMail[3].'","asunto":"'.cv($fMail[0]).'","remitente":"'.cv($fMail[2]).'","adjuntos":['.$adjuntos.'],"mensaje":"'.cv($cuerpo).'"}';
		echo "1|".$cadObj;
		
		
		
		
	}
	
	function obtenerEstadisticasMailPaciente()
	{
		global $con;
		$idPaciente=$_POST["idPaciente"];
		$consulta="SELECT email FROM _1022_gridEmail WHERE idReferencia=".$idPaciente;
		$lMail=$con->obtenerListaValores($consulta,"'");
		if($lMail=="")
			$lMail=-1;
		$consulta="SELECT COUNT(*) FROM 3027_eMailRecibidos WHERE remitente IN (".$lMail.") AND situacion=0";
		$eMailSinLeer=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 3027_eMailRecibidos WHERE remitente IN (".$lMail.") AND situacion2=0";
		$eMailSinClasificar=$con->obtenerValor($consulta);
		echo '1|{"sinLeer":"'.$eMailSinLeer.'","sinClasificar":"'.$eMailSinClasificar.'"}'	;
	}
	
	function obtenerMailRespuestaSituacion()
	{
		global $con;	
		$idPaciente=$_POST["idPaciente"];
		$situacion=$_POST["situacion"];
		$consulta="SELECT email FROM _1022_gridEmail WHERE idReferencia=".$idPaciente;
		$lMail=$con->obtenerListaValores($consulta,"'");
		if($lMail=="")
			$lMail=-1;
			
			
		switch($situacion)	
		{
			case 0:
				$consulta="SELECT * FROM 3027_eMailRecibidos WHERE remitente IN (".$lMail.") AND situacion=0 order by fechaMail desc";

			break;
			case 1:
				$consulta="SELECT * FROM 3027_eMailRecibidos WHERE remitente IN (".$lMail.") AND situacion2=0 order by fechaMail desc";
			break;
				
		}
		
		$numReg=0;
		$registros="";
		$resMail=$con->obtenerFilas($consulta);
		while($fMail=mysql_fetch_row($resMail))
		{
			$adjuntos="";
			$consulta="SELECT a.idArchivo,nomArchivoOriginal,tamano  FROM 3028_eMailAdjuntos e,908_archivos a WHERE e.idMail=".$fMail[0]." AND a.idArchivo=e.idArchivo";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$a='{"idArchivo":"'.$fila[0].'","nombreArchivo":"'.cv($fila[1]).'","tamano":"'.$fila[2].'"}';
				if($adjuntos=="")
					$adjuntos=$a;
				else
					$adjuntos.=",".$a;
			}
			$numReg++;
			
			$r='{"idMail":"'.$fMail[0].'","fechaRecepcion":"'.$fMail[7].'","asunto":"'.cv($fMail[1]).'","mensaje":"'.cv($fMail[2]).'","remitente":"'.cv($fMail[3]).'","adjuntos":['.$adjuntos.']}';
			
			if($registros=="")
				$registros=$r;
			else
				$registros.=",".$r;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';
	}
	
	function marcarMail()
	{
		global $con;
		$marca=$_POST["marca"];
		$idMail=$_POST["iM"];
		$consulta="UPDATE 3027_eMailRecibidos SET situacion=".$marca." WHERE idEmail=".$idMail;
		eC($consulta);
			
	}
	
	function verificarBuzonEntrada()
	{
		global $con;
		verificarMailPacientes();
		echo "1|";
	}
	
	function obtenerMatrizRiesgo()
	{
		global $con;	
		$idPerfil=$_POST["idPerfil"];
		$idFormulario=$_POST["idFormulario"];
		
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT idRegla,nivelRiesgo FROM 3029_reglasNivelRiesgo WHERE idReferencia=".$idPerfil." and idFormulario=".$idFormulario;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			
			$consulta="SELECT id__1045_gParametros,parametro,tipoValor,origenDatos FROM _1045_gParametros WHERE idReferencia=".$idPerfil." and aplicableMatriz=1";
			$resParam=$con->obtenerFilas($consulta);
			while($filaParam=mysql_fetch_row($resParam))
			{
				
				$valor="";
				$consulta="SELECT * FROM 3030_parametrosReglaNivelRiesgo WHERE idRegla=".$fila[0]." AND idParametro=".$filaParam[0];

				$fParamValor=$con->obtenerPrimeraFila($consulta);
				if($fParamValor)
				{
					switch($fParamValor[3])
					{
						case 1:
							$valor=$fParamValor[4].",".$fParamValor[5]."|1|";
							if($fParamValor[6]!="")
							$valor.=$fParamValor[6].",".$fParamValor[7];
						break;	
						case 2:
							$valor=$fParamValor[5];
						break;
						case 3:
							$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fParamValor[5];
	
							$valor=$fParamValor[5]."|".$con->obtenerValor($consulta);
						break;
					}
				}
				$comp.=',"p_'.$filaParam[0].'":"'.$valor.'"';
			}
			
			$o='{"idRegla":"'.$fila[0].'","idNivelRiesgo":"'.$fila[1].'"'.$comp.'}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function registrarNuevaRegla()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$idNivelRiesgo=$_POST["idNivelRiesgo"];
		$idFormulario=$_POST["idFormulario"];
		$consulta="INSERT INTO 3029_reglasNivelRiesgo(nivelRiesgo,idReferencia,idFormulario) VALUES(".$idNivelRiesgo.",".$idPerfil.",".$idFormulario.")";
		eC($consulta);
	}
	
	function registrarCondicionReglaPerfil()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="SELECT * FROM 3030_parametrosReglaNivelRiesgo WHERE idRegla=".$obj->idRegla." AND idParametro=".$obj->idParametro;
		$fParametros=$con->obtenerPrimeraFila($consulta);
		if($fParametros)
		{
			$consulta="update 3030_parametrosReglaNivelRiesgo set tipoValor=".$obj->tipoValor.",condicion1='".$obj->condicion1."',valor1='".
						$obj->valor1."',condicion2='".$obj->condicion2."',valor2='".$obj->valor2."' where idRegistro=".$fParametros[0];

		}
		else
		{
			$consulta="INSERT INTO 3030_parametrosReglaNivelRiesgo(idRegla,idParametro,tipoValor,condicion1,valor1,condicion2,valor2) 
					VALUES(".$obj->idRegla.",".$obj->idParametro.",".$obj->tipoValor.",'".$obj->condicion1."','".$obj->valor1."','".$obj->condicion2."','".$obj->valor2."')";
		}
		eC($consulta);
	}
	
	function removerReglaPerfil()
	{
		global $con;
		$idRegla=$_POST["iR"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 3029_reglasNivelRiesgo WHERE idRegla=".$idRegla;
		$x++;
		$consulta[$x]="DELETE FROM 3030_parametrosReglaNivelRiesgo WHERE idRegla=".$idRegla;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function removerValorParametroRegla()
	{
		global $con;
		$idRegla=$_POST["iR"];
		$idParametro=$_POST["iP"];
		$consulta="DELETE FROM 3030_parametrosReglaNivelRiesgo WHERE idRegla=".$idRegla." and idParametro=".$idParametro;
		eC($consulta);
	}
	
	function registrarParametrosPacienteInterface()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		$obj=json_decode($cadObj);
	
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 3031_parametrosPaciente where idProyecto=".$obj->idProyecto." and idPaciente=".$obj->idPaciente;// idPerfil=".$obj->idPerfil." and
		$x++;
		foreach($obj->arrPropiedades as $p)
		{
			foreach($p as $id=>$valor)
			{
				$aParam=explode("_",$id);
				$consulta[$x]="INSERT INTO 3031_parametrosPaciente(idPerfil,idProyecto,idPaciente,idParametro,valor)
								VALUES(".$obj->idPerfil.",".$obj->idProyecto.",".$obj->idPaciente.",".$aParam[1].",'".$valor."')";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);

		
	}
	
	function evaluarDiagnosticoPacienteV2()
	{
		global $con;	
		$idPaciente=$_POST["idPaciente"];
		$idProyecto=$_POST["idProyecto"];
		$arrParametros=array();
		$consulta="SELECT idPerfil FROM 3031_parametrosPaciente WHERE idProyecto=".$idProyecto." AND idPaciente=".$idPaciente." LIMIT 0,1";
		$idPerfilPaciente=$con->obtenerValor($consulta);
		$consulta="SELECT * FROM 3031_parametrosPaciente WHERE idPerfil=".$idPerfilPaciente." AND idProyecto=".$idProyecto." AND idPaciente=".$idPaciente;
		$rParametros=$con->obtenerFilas($consulta);
		while($fParam=mysql_fetch_row($rParametros))
		{
			$arrParametros[$fParam[4]]=$fParam[5];
		}
		
		$objDiagnostico["riesgoPaciente"]="0";
		$objDiagnostico["etiquetaRiesgoPaciente"]="No identificado";
		$objDiagnostico["idPaciente"]=$idPaciente;
		$objDiagnostico["estudios"]=array();
		$objDiagnostico["recomendaciones"]=array();
		
		$aNivelRiesgo=evaluarNivelRiesgo($idPerfilPaciente,$arrParametros,$idPaciente);

		if($aNivelRiesgo!==NULL)
		{
			$objDiagnostico["riesgoPaciente"]=$aNivelRiesgo[0];
			$objDiagnostico["etiquetaRiesgoPaciente"]=$aNivelRiesgo[1];
		}
		
			
		$densidadAPE=NULL;
		$gleason=NULL;
		$ultimaBiopsia=NULL;
		
		$arrAPE=obtenerEstudiosTratamientosPaciente($idPaciente,1);
		
		if(sizeof($arrAPE)>0)
		{
			$densidadAPE=$arrAPE[sizeof($arrAPE)-1]	["nivelAPE"];
			
		}
		
		$arrBiopsia=obtenerEstudiosTratamientosPaciente($idPaciente,3);
		
		if(sizeof($arrBiopsia)>0)
		{
			$ultimaBiopsia=$arrBiopsia[sizeof($arrBiopsia)-1];	
			$gleason=$ultimaBiopsia["sumaGleason"];
			
		}
		
		$arrTactoRectal=obtenerEstudiosTratamientosPaciente($idPaciente,2);
		
		
		
		
		
		
		
		
		/*switch($objDiagnostico["riesgoPaciente"])			
		{
			case 1:
				
				if($esperanzaVida<20)
				{
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="4";
					array_push($objDiagnostico["estudios"],$oEstudio);
					
					$oEstudio=array();
					$oEstudio["tipo"]="1";
					$oEstudio["idEstudioDiagnostico"]="1";
					array_push($objDiagnostico["estudios"],$oEstudio);
					$oEstudio=array();
					$oEstudio["tipo"]="1";
					$oEstudio["idEstudioDiagnostico"]="2";
					array_push($objDiagnostico["estudios"],$oEstudio);
					
					$cambioProstata=false;
					$elevacionAPE=false;
					
					if(sizeof($arrTactoRectal)>1)
					{
						$muestra1=$arrTactoRectal[sizeof($arrTactoRectal)-1];
						$muestra2=$arrTactoRectal[sizeof($arrTactoRectal)-2];
						
						if($muestra1["resultado"]!=$muestra2["resultado"])
						{
							$cambioProstata=true;
						}
						
						
							
					}
					
					if(sizeof($arrAPE)>1)
					{
						$muestra1=$arrAPE[sizeof($arrTactoRectal)-1];
						$muestra2=$arrAPE[sizeof($arrTactoRectal)-2];
						
						if(($muestra2["nivelAPE"]*2)<=$muestra2["nivelAPE"])
						{
							$elevacionAPE=true;	
						}
						
					}
					
					if(($esperanzaVida>=10)&&($cambioProstata|| $elevacionAPE))
					{
						$oEstudio=array();
						$oEstudio["tipo"]="1";
						$oEstudio["idEstudioDiagnostico"]="3";
						array_push($objDiagnostico["estudios"],$oEstudio);
					}
					
					
					
					
					$oComentario=array();
					$oComentario["recomendaciones"]="APE cada 3 a 6 meses";
					array_push($objDiagnostico["recomendaciones"],$oComentario);
					
					$oComentario=array();
					$oComentario["recomendaciones"]="TR cada 6 a 12 meses";
					array_push($objDiagnostico["recomendaciones"],$oComentario);
					
					if($esperanzaVida>=10)
					{
						if(sizeof($ultimaBiopsia["muestras"])<10)
						{
							$oComentario=array();
							$oComentario["recomendaciones"]="Biopsia con aguja en 6 meses";
							array_push($objDiagnostico["recomendaciones"],$oComentario);
						}
						else
						{
							$oComentario=array();
							$oComentario["recomendaciones"]="Biopsia con aguja en 12 a 18 meses";
							array_push($objDiagnostico["recomendaciones"],$oComentario);	
						}
					}
					
					
					
				}
				else
				{
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="5";
					array_push($objDiagnostico["estudios"],$oEstudio);
				}
				
			
			break;
			case 2:
				if($esperanzaVida<10)
				{
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="4";
					array_push($objDiagnostico["estudios"],$oEstudio);
				}
				else
				{
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="4";
					array_push($objDiagnostico["estudios"],$oEstudio);
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="5";
					array_push($objDiagnostico["estudios"],$oEstudio);
				}
				
				
				$oEstudio=array();
				$oEstudio["tipo"]="1";
				$oEstudio["idEstudioDiagnostico"]="1";
				array_push($objDiagnostico["estudios"],$oEstudio);
				$oEstudio=array();
				$oEstudio["tipo"]="1";
				$oEstudio["idEstudioDiagnostico"]="2";
				array_push($objDiagnostico["estudios"],$oEstudio);
				
				
				
				$cambioProstata=false;
				$elevacionAPE=false;
				
				if(sizeof($arrTactoRectal)>1)
				{
					$muestra1=$arrTactoRectal[sizeof($arrTactoRectal)-1];
					$muestra2=$arrTactoRectal[sizeof($arrTactoRectal)-2];
					
					if($muestra1["resultado"]!=$muestra2["resultado"])
					{
						$cambioProstata=true;
					}
					
					
						
				}
				
				if(sizeof($arrAPE)>1)
				{
					$muestra1=$arrAPE[sizeof($arrTactoRectal)-1];
					$muestra2=$arrAPE[sizeof($arrTactoRectal)-2];
					
					if(($muestra2["nivelAPE"]*2)<=$muestra2["nivelAPE"])
					{
						$elevacionAPE=true;	
					}
					
				}
				
				if(($esperanzaVida>=10)&&($cambioProstata|| $elevacionAPE))
				{
					$oEstudio=array();
					$oEstudio["tipo"]="1";
					$oEstudio["idEstudioDiagnostico"]="3";
					array_push($objDiagnostico["estudios"],$oEstudio);
				}
				
				
				$oComentario=array();
				$oComentario["recomendaciones"]="APE cada 3 a 6 meses";
				array_push($objDiagnostico["recomendaciones"],$oComentario);
				
				$oComentario=array();
				$oComentario["recomendaciones"]="TR cada 6 a 12 meses";
				array_push($objDiagnostico["recomendaciones"],$oComentario);
				
				if($esperanzaVida>=10)
				{
					if(sizeof($ultimaBiopsia["muestras"])<10)
					{
						$oComentario=array();
						$oComentario["recomendaciones"]="Biopsia con aguja en 6 meses";
						array_push($objDiagnostico["recomendaciones"],$oComentario);
					}
					else
					{
						$oComentario=array();
						$oComentario["recomendaciones"]="Biopsia con aguja en 12 a 18 meses";
						array_push($objDiagnostico["recomendaciones"],$oComentario);	
					}
				}
				
			break;
			case 3:
				if($esperanzaVida<10)
				{
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="4";
					array_push($objDiagnostico["estudios"],$oEstudio);
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="5";
					array_push($objDiagnostico["estudios"],$oEstudio);
				}
				else
				{
					
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="5";
					array_push($objDiagnostico["estudios"],$oEstudio);
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="6";
					array_push($objDiagnostico["estudios"],$oEstudio);
				}
				
				
				$oEstudio=array();
				$oEstudio["tipo"]="1";
				$oEstudio["idEstudioDiagnostico"]="1";
				array_push($objDiagnostico["estudios"],$oEstudio);
				$oEstudio=array();
				$oEstudio["tipo"]="1";
				$oEstudio["idEstudioDiagnostico"]="2";
				array_push($objDiagnostico["estudios"],$oEstudio);
				
				
				
				$cambioProstata=false;
				$elevacionAPE=false;
				
				if(sizeof($arrTactoRectal)>1)
				{
					$muestra1=$arrTactoRectal[sizeof($arrTactoRectal)-1];
					$muestra2=$arrTactoRectal[sizeof($arrTactoRectal)-2];
					
					if($muestra1["resultado"]!=$muestra2["resultado"])
					{
						$cambioProstata=true;
					}
					
					
						
				}
				
				if(sizeof($arrAPE)>1)
				{
					$muestra1=$arrAPE[sizeof($arrTactoRectal)-1];
					$muestra2=$arrAPE[sizeof($arrTactoRectal)-2];
					
					if(($muestra2["nivelAPE"]*2)<=$muestra2["nivelAPE"])
					{
						$elevacionAPE=true;	
					}
					
				}
				
				if(($esperanzaVida>=10)&&($cambioProstata|| $elevacionAPE))
				{
					$oEstudio=array();
					$oEstudio["tipo"]="1";
					$oEstudio["idEstudioDiagnostico"]="3";
					array_push($objDiagnostico["estudios"],$oEstudio);
				}
				
				
				$oComentario=array();
				$oComentario["recomendaciones"]="APE cada 3 a 6 meses";
				array_push($objDiagnostico["recomendaciones"],$oComentario);
				
				$oComentario=array();
				$oComentario["recomendaciones"]="TR cada 6 a 12 meses";
				array_push($objDiagnostico["recomendaciones"],$oComentario);
				
				if($esperanzaVida>=10)
				{
					if(sizeof($ultimaBiopsia["muestras"])<10)
					{
						$oComentario=array();
						$oComentario["recomendaciones"]="Biopsia con aguja en 6 meses";
						array_push($objDiagnostico["recomendaciones"],$oComentario);
					}
					else
					{
						$oComentario=array();
						$oComentario["recomendaciones"]="Biopsia con aguja en 12 a 18 meses";
						array_push($objDiagnostico["recomendaciones"],$oComentario);	
					}
				}
				
			break;
			case 4:
				$oEstudio=array();
				$oEstudio["tipo"]="2";
				$oEstudio["idEstudioDiagnostico"]="5";
				array_push($objDiagnostico["estudios"],$oEstudio);
				$oEstudio["tipo"]="2";
				$oEstudio["idEstudioDiagnostico"]="6";
				array_push($objDiagnostico["estudios"],$oEstudio);
				$oEstudio["tipo"]="2";
				$oEstudio["idEstudioDiagnostico"]="7";
				array_push($objDiagnostico["estudios"],$oEstudio);
			break;
			case 5:
				if($categoriaN==3)
				{
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="5";
					array_push($objDiagnostico["estudios"],$oEstudio);
					$oEstudio=array();
					$oEstudio["tipo"]="2";
					$oEstudio["idEstudioDiagnostico"]="9";
					array_push($objDiagnostico["estudios"],$oEstudio);
				}
				else
				{
					if($categoriaT==9)	
					{
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="5";
						array_push($objDiagnostico["estudios"],$oEstudio);
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="8";
						array_push($objDiagnostico["estudios"],$oEstudio);
					}
					else
					{
						
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="5";
						array_push($objDiagnostico["estudios"],$oEstudio);
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="8";
						array_push($objDiagnostico["estudios"],$oEstudio);
													$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="6";
						array_push($objDiagnostico["estudios"],$oEstudio);
						$oEstudio=array();
						$oEstudio["tipo"]="2";
						$oEstudio["idEstudioDiagnostico"]="7";
						array_push($objDiagnostico["estudios"],$oEstudio);
					}
					
				}
			break;	
		}*/
		
		
		
		if(registrarDiagnosticoPaciente($objDiagnostico))
		
			echo "1|".$objDiagnostico["riesgoPaciente"]."|".$objDiagnostico["etiquetaRiesgoPaciente"];	
		else
			echo "1|";
		
			
			
		
		
		
	}
	
	function obtenerMatrizTratamientosEstudiosRiesgo()
	{
		global $con;	
		$idPerfil=$_POST["idPerfil"];
		$idFormulario=$_POST["idFormulario"];
		$sL=$_POST["sL"];
		
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT idRegla,nivelRiesgo FROM 3032_reglasEstudiosTramientosNivelRiesgo WHERE idReferencia=".$idPerfil." and idFormulario=".$idFormulario;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$comp="";
			
			$consulta="SELECT id__1045_gParametros,parametro,tipoValor,origenDatos FROM _1045_gParametros WHERE idReferencia=".$idPerfil." and aplicableMatrizEstudios=1";
			$resParam=$con->obtenerFilas($consulta);
			while($filaParam=mysql_fetch_row($resParam))
			{
				
				$valor="";
				$consulta="SELECT * FROM 3033_parametrosReglaNivelRiesgoTratamientosEstudios WHERE idRegla=".$fila[0]." AND idParametro=".$filaParam[0];

				$fParamValor=$con->obtenerPrimeraFila($consulta);
				if($fParamValor)
				{
					switch($fParamValor[3])
					{
						case 1:
							$valor=$fParamValor[4].",".$fParamValor[5]."|1|";
							if($fParamValor[6]!="")
							$valor.=$fParamValor[6].",".$fParamValor[7];
						break;	
						case 2:
							$valor=$fParamValor[5];
						break;
						case 3:
							$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fParamValor[5];
	
							$valor=$fParamValor[5]."|".$con->obtenerValor($consulta);
						break;
					}
				}
				$comp.=',"p_'.$filaParam[0].'":"'.$valor.'"';
			}
			
			$arrTratamientos=array();
			$arrEstudios=array();
			$arrComentarios=array();
			
			$consulta="SELECT * FROM 3034_estudiosTratamientosComentariosNivelRiesgo WHERE idRegla=".$fila[0];
			$rEstudios=$con->obtenerFilas($consulta);
			while($fEstudio=mysql_fetch_row($rEstudios))
			{
				switch($fEstudio[2])
				{
					case 1://1 Estudio,2 Tratamiento; 3 comentario  
						$consulta="SELECT estudioTratamiento FROM _1041_tablaDinamica WHERE id__1041_tablaDinamica=".$fEstudio[3];
						$valor=$con->obtenerValor($consulta);
						$arrEstudios[$valor]["idEstudioTratamiento"]=$fEstudio[3];
						$arrEstudios[$valor]["idRegistro"]=$fEstudio[0];
						$arrEstudios[$valor]["idFuncionEvaluacion"]=$fEstudio[5];
					break;	
					case 2:
						$consulta="SELECT estudioTratamiento FROM _1041_tablaDinamica WHERE id__1041_tablaDinamica=".$fEstudio[3];
						$valor=$con->obtenerValor($consulta);
						$arrTratamientos[$valor]["idEstudioTratamiento"]=$fEstudio[3];
						$arrTratamientos[$valor]["idRegistro"]=$fEstudio[0];
						$arrTratamientos[$valor]["idFuncionEvaluacion"]=$fEstudio[5];
					break;	
					case 3:
						$valor=sizeof($arrComentarios);
						$arrComentarios[$valor]["idEstudioTratamiento"]=$fEstudio[3];
						$arrComentarios[$valor]["idRegistro"]=$fEstudio[0];
						$arrComentarios[$valor]["idFuncionEvaluacion"]=$fEstudio[5];
						$arrComentarios[$valor]["comentario"]=$fEstudio[4];
					break;	
				}
			}
			
			
			ksort($arrEstudios);
			ksort($arrTratamientos);
			$tabla="<table>".
					"<tr><td width='300'></td><td width='200'><b>Funci&oacute;n de evaluaci&oacute;n</b></td></tr>".
					"<tr><td colspan='2'><b>Tratamientos (".sizeof($arrTratamientos).")</b></td></tr>";
					
					foreach($arrTratamientos as $t => $resto)
					{
						
						if($resto["idFuncionEvaluacion"]=="")
							$resto["idFuncionEvaluacion"]=-1;
							
						$funcion="";	
						
						if($resto["idFuncionEvaluacion"]!=-1)
						{
							$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$resto["idFuncionEvaluacion"];
							$funcion=$con->obtenerValor($consulta);
							
						}
						if($sL==0)
							$tabla.="<tr><td><a href='javascript:removerElemento(\"".bE($resto["idRegistro"])."\")'><img src='../images/delete.png' width='13' height='13' title='Remover tratamiento' alt='Remover tratamiento'></a>&nbsp;&nbsp;".cv($t)."</td><td>".cv($funcion)."</td></tr>";	
						else
							$tabla.="<tr><td>".cv($t)."</td><td>".cv($funcion)."</td></tr>";	
						
					}
					
					$tabla.="<tr><td colspan='2'><b>Estudios (".sizeof($arrEstudios).")</b></td></tr>";
					
					foreach($arrEstudios as $t => $resto)
					{
						
						if($resto["idFuncionEvaluacion"]=="")
							$resto["idFuncionEvaluacion"]=-1;
							
						$funcion="";	
						
						if($resto["idFuncionEvaluacion"]!=-1)
						{
							$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$resto["idFuncionEvaluacion"];
							$funcion=$con->obtenerValor($consulta);
							
						}
						if($sL==0)
							$tabla.="<tr><td><a href='javascript:removerElemento(\"".bE($resto["idRegistro"])."\")'><img src='../images/delete.png' width='13' height='13' title='Remover tratamiento' alt='Remover tratamiento'></a>&nbsp;&nbsp;".cv($t)."</td><td>".cv($funcion)."</td></tr>";	
						else
							$tabla.="<tr><td>".cv($t)."</td><td>".cv($funcion)."</td></tr>";								
							
					}
					
					
					$tabla.="<tr><td colspan='2'><b>Comentarios (".sizeof($arrComentarios).")</b></td></tr>";
					
					foreach($arrComentarios as  $resto)
					{
						
						if($resto["idFuncionEvaluacion"]=="")
							$resto["idFuncionEvaluacion"]=-1;
							
						$funcion="";	
						
						if($resto["idFuncionEvaluacion"]!=-1)
						{
							$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$resto["idFuncionEvaluacion"];
							$funcion=$con->obtenerValor($consulta);
							
						}
						if($sL==0)
							$tabla.="<tr><td><a href='javascript:removerElemento(\"".bE($resto["idRegistro"])."\")'><img src='../images/delete.png' width='13' height='13' title='Remover tratamiento' alt='Remover tratamiento'></a>&nbsp;&nbsp;".cv($resto["comentario"])."</td><td>".cv($funcion)."</td></tr>";
						else
							$tabla.="<tr><td>".cv($resto["comentario"])."</td><td>".cv($funcion)."</td></tr>";
					}
					
					
			
			
			
			$tabla.="</table>";
			$o='{"tabla":"'.cv($tabla).'","idRegla":"'.$fila[0].'","idNivelRiesgo":"'.$fila[1].'"'.$comp.'}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function registrarNuevaReglaEstudioRiesgo()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$idNivelRiesgo=$_POST["idNivelRiesgo"];
		$idFormulario=$_POST["idFormulario"];
		$consulta="INSERT INTO 3032_reglasEstudiosTramientosNivelRiesgo(nivelRiesgo,idReferencia,idFormulario) VALUES(".$idNivelRiesgo.",".$idPerfil.",".$idFormulario.")";
		eC($consulta);
	}
	
	function registrarCondicionReglaPerfilEstudioRiesgo()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="SELECT * FROM 3033_parametrosReglaNivelRiesgoTratamientosEstudios WHERE idRegla=".$obj->idRegla." AND idParametro=".$obj->idParametro;
		$fParametros=$con->obtenerPrimeraFila($consulta);
		if($fParametros)
		{
			$consulta="update 3033_parametrosReglaNivelRiesgoTratamientosEstudios set tipoValor=".$obj->tipoValor.",condicion1='".$obj->condicion1."',valor1='".
						$obj->valor1."',condicion2='".$obj->condicion2."',valor2='".$obj->valor2."' where idRegistro=".$fParametros[0];

		}
		else
		{
			$consulta="INSERT INTO 3033_parametrosReglaNivelRiesgoTratamientosEstudios(idRegla,idParametro,tipoValor,condicion1,valor1,condicion2,valor2) 
					VALUES(".$obj->idRegla.",".$obj->idParametro.",".$obj->tipoValor.",'".$obj->condicion1."','".$obj->valor1."','".$obj->condicion2."','".$obj->valor2."')";
		}
		eC($consulta);
	}
	
	function removerReglaPerfilEstudioRiesgo()
	{
		global $con;
		$idRegla=$_POST["iR"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 3032_reglasEstudiosTramientosNivelRiesgo WHERE idRegla=".$idRegla;
		$x++;
		$consulta[$x]="DELETE FROM 3033_parametrosReglaNivelRiesgoTratamientosEstudios WHERE idRegla=".$idRegla;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function removerValorParametroReglaEsttudioRiesgo()
	{
		global $con;
		$idRegla=$_POST["iR"];
		$idParametro=$_POST["iP"];
		$consulta="DELETE FROM 3030_parametrosReglaNivelRiesgo WHERE idRegla=".$idRegla." and idParametro=".$idParametro;
		eC($consulta);
	}
	
	function registrarEstudioTratamientoComentario()
	{
		global $con;
		$cadObj=$_POST["cadObj"];		
		$obj=json_decode($cadObj);
		$consulta="INSERT INTO 3034_estudiosTratamientosComentariosNivelRiesgo(idRegla,tipoValor,idValor,comentario,idFuncionEvaluacion) 
					VALUES(".$obj->idRegla.",".$obj->tipoValor.",".$obj->idValor.",'".cv($obj->comentario)."',".$obj->idFuncionEvaluacion.")";
		eC($consulta);
		
		
	}
	
	function removerEstudioTratamientoComentario()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$consulta="DELETE FROM 3034_estudiosTratamientosComentariosNivelRiesgo WHERE idRegistro=".$idRegistro;
		eC($consulta);
	}
	
	
	
	function obtenerOpcionesTratamiento()
	{
		global $con;	
		$idPaciente=$_POST["idPaciente"];
		$idProyecto=$_POST["idProyecto"];
		
		
		$consulta="SELECT procesoAsociado FROM _1024_tablaDinamica WHERE id__1024_tablaDinamica=".$idProyecto;
		$idProceso=$con->obtenerValor($consulta);
		
		$idFormulario=obtenerFormularioBase($idProceso);
		$arrParametros=array();
		$consulta="SELECT idPerfil FROM 3031_parametrosPaciente WHERE idProyecto=".$idProyecto." AND idPaciente=".$idPaciente." LIMIT 0,1";
		$idPerfilPaciente=$con->obtenerValor($consulta);
		$consulta="SELECT * FROM 3031_parametrosPaciente WHERE idPerfil=".$idPerfilPaciente." AND idProyecto=".$idProyecto." AND idPaciente=".$idPaciente;

		$rParametros=$con->obtenerFilas($consulta);
		while($fParam=mysql_fetch_row($rParametros))
		{
			$arrParametros[$fParam[4]]=$fParam[5];
		}
		
		$consulta="SELECT riezgoPaciente FROM 3023_evaluacionPaciente WHERE idPaciente=".$idPaciente." ORDER BY idRegistro DESC LIMIT 0,1";
		$nivelRiesgo=$con->obtenerValor($consulta);
		
		$numOpciones=1;
		$opcionesTratamiento="";
		$consulta="SELECT idRegla FROM 3032_reglasEstudiosTramientosNivelRiesgo WHERE idFormulario=1045 AND nivelRiesgo=".$nivelRiesgo." and idReferencia=".$idPerfilPaciente;
		$resPerfiles=$con->obtenerFilas($consulta);
		while($fPerfiles=mysql_fetch_row($resPerfiles))
		{
			$arrHijos="";
			$cumpleRegla=cumpleReglasEstudioTratamiento($fPerfiles[0],$idPerfilPaciente,$nivelRiesgo,$arrParametros,$idPaciente);
			if($cumpleRegla)	
			{
				
				$arrHijos="";
				$consulta="SELECT * FROM 3034_estudiosTratamientosComentariosNivelRiesgo WHERE idRegla=".$fPerfiles[0]." AND tipoValor=2";
				$rEstudios=$con->obtenerFilas($consulta);
				while($fEstudio=mysql_fetch_row($rEstudios))
				{
					
					$mostrar=true;
					if(($fEstudio[5]!="")&&($fEstudio[5]!="-1"))
					{
						$cache=NULL;
						$cadObj='{"idRegla":"'.$idRegla.'","idPaciente":"","idPerfil":"","idNivel":"","arrParams":""}';
						$obj=json_decode($cadObj);
						
						$obj->idPaciente=$idPaciente;
						$obj->idPerfil=$idPerfilPaciente;
						$obj->idNivel=$nivelRiesgo;
						$obj->arrParams=$arrParametros;
						
						$resultado=trimComillas(resolverExpresionCalculoPHP($fEstudio[5],$obj,$cache));
	
						if(($resultado!=1)&&($resultado!=true))
						{
							
							$mostrar=false;	
						}	
					}
					
					if($mostrar)
					{
						$consulta="SELECT estudioTratamiento FROM _1041_tablaDinamica WHERE id__1041_tablaDinamica=".$fEstudio[3];
						$valor=$con->obtenerValor($consulta);
						$h='{"idEstudioTratamiento":"'.$fEstudio[3].'","tipo":"2","icon":"../images/s.gif","id":"t_0_'.$fEstudio[0].'_'.$fEstudio[3].'","text":"'.cv($valor).'",children:[],leaf:true}';
						if($arrHijos=="")
							$arrHijos=$h;
						else
							$arrHijos.=",".$h;
					}
						
						
				}
				
				$arrTratamientos='{"tipo":"0","expanded":true,"icon":"../images/s.gif","id":"t_0","text":"<b>Tratamientos</b>",children:['.$arrHijos.'],leaf:'.($arrHijos==""?"true":"false").'}';
				
				$arrHijos="";
				$consulta="SELECT * FROM 3034_estudiosTratamientosComentariosNivelRiesgo WHERE idRegla=".$fPerfiles[0]." AND tipoValor=1";
				$rEstudios=$con->obtenerFilas($consulta);
				while($fEstudio=mysql_fetch_row($rEstudios))
				{
					$mostrar=true;
					if(($fEstudio[5]!="")&&($fEstudio[5]!="-1"))
					{
						$cache=NULL;
						$cadObj='{"idRegla":"'.$idRegla.'","idPaciente":"","idPerfil":"","idNivel":"","arrParams":""}';
						$obj=json_decode($cadObj);
						
						$obj->idPaciente=$idPaciente;
						$obj->idPerfil=$idPerfilPaciente;
						$obj->idNivel=$nivelRiesgo;
						$obj->arrParams=$arrParametros;
						
						$resultado=trimComillas(resolverExpresionCalculoPHP($fEstudio[5],$obj,$cache));
	
						if(($resultado!=1)&&($resultado!=true))
						{
							
							$mostrar=false;	
						}
					}
					
					if($mostrar)
					{
						$consulta="SELECT estudioTratamiento FROM _1041_tablaDinamica WHERE id__1041_tablaDinamica=".$fEstudio[3];
						$valor=$con->obtenerValor($consulta);
						$h='{"idEstudioTratamiento":"'.$fEstudio[3].'","tipo":"1","icon":"../images/s.gif","id":"e_0_'.$fEstudio[0].'_'.$fEstudio[3].'","text":"'.cv($valor).'",children:[],leaf:true}';
						if($arrHijos=="")
							$arrHijos=$h;
						else
							$arrHijos.=",".$h;
					}
				}
				
				$arrEstudios=',{"tipo":"0","expanded":true,"icon":"../images/s.gif","id":"e_0","text":"<b>Estudios</b>",children:['.$arrHijos.'],leaf:'.($arrHijos==""?"true":"false").'}';
				
				
				
				$arrHijos="";
				$consulta="SELECT * FROM 3034_estudiosTratamientosComentariosNivelRiesgo WHERE idRegla=".$fPerfiles[0]." AND tipoValor=3";
				$rEstudios=$con->obtenerFilas($consulta);
				while($fEstudio=mysql_fetch_row($rEstudios))
				{
					$mostrar=true;
					if(($fEstudio[5]!="")&&($fEstudio[5]!="-1"))
					{
						$cache=NULL;
						$cadObj='{"idRegla":"'.$fPerfiles[0].'","idPaciente":"","idPerfil":"","idNivel":"","arrParams":""}';
						$obj=json_decode($cadObj);
						
						$obj->idPaciente=$idPaciente;
						$obj->idPerfil=$idPerfilPaciente;
						$obj->idNivel=$nivelRiesgo;
						$obj->arrParams=$arrParametros;
						
						$resultado=trimComillas(resolverExpresionCalculoPHP($fEstudio[5],$obj,$cache));
	
						if(($resultado!=1)&&($resultado!=true))
						{
							
							$mostrar=false;	
						}
					}
					
					if($mostrar)
					{
						$valor=$fEstudio[4];
						$h='{"tipo":"3","icon":"../images/s.gif","id":"c_0_'.$fEstudio[0].'","text":"'.cv($valor).'",children:[],leaf:true}';
						if($arrHijos=="")
							$arrHijos=$h;
						else
							$arrHijos.=",".$h;
					}
				}
				
				
				$arrComentarios=',{"tipo":"0","expanded":true,"icon":"../images/s.gif","id":"c_0","text":"<b>Comentarios adicionales</b>",children:['.$arrHijos.'],leaf:'.($arrHijos==""?"true":"false").'}';
				
				
				$o='{"tipo":"0","expanded":true,"icon":"../images/s.gif","id":"o_'.$numOpciones.'","text":"<span style=\'color:#900\'><b>Terapia '.$numOpciones.'</b></span>",leaf:false,children:['.$arrTratamientos.$arrEstudios.$arrComentarios.']}';
				if($opcionesTratamiento=="")
					$opcionesTratamiento=$o;
				else
					$opcionesTratamiento.=",".$o;
				$numOpciones++;
			}
				
		}
			
			
		echo "[".$opcionesTratamiento."]";
		
		
	}
	
	
	function obtenerRegistrosFoliosAcompanamientoNegativos()
	{
		global $con;
		
		$fechaActual=strtotime(date("Y-m-d"));
		
		
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		
		$comp="";
		if(!existeRol("'114_0'"))
		{
			$consulta="SELECT idPaciente FROM 3021_responsableSeguimientoPaciente WHERE idResponsableSeguimiento=".$_SESSION["idUsr"]." and fechaBaja is null";
			$lPacientes=$con->obtenerListaValores($consulta);	
			if($lPacientes=="")
				$lPacientes=-1;
			$comp=" and id__1022_tablaDinamica in (".$lPacientes.")";
		}
		
		
		$arrMotivosNoContacto=array();
		$arrMotivosNoContacto[0][0]="1";
		$arrMotivosNoContacto[0][1]="Se dejó recado";
		$arrMotivosNoContacto[1][0]="2";
		$arrMotivosNoContacto[1][1]="Fuera de Servicio";
		$arrMotivosNoContacto[2][0]="3";
		$arrMotivosNoContacto[2][1]="No contestan";
		
		
		
		$arrMotivosNoAgenda=array();
		$arrMotivosNoAgenda[0][0]="1";
		$arrMotivosNoAgenda[0][1]="Número telefónico no existe";
		$arrMotivosNoAgenda[1][0]="2";
		$arrMotivosNoAgenda[1][1]="Número equivocado";
		$arrMotivosNoAgenda[2][0]="3";
		$arrMotivosNoAgenda[2][1]="Otro";
		
		$consulta="select * from (SELECT id__1022_tablaDinamica AS idFolio,folio,fechaLlenado,fechaCreacion AS fechaCaptura,apPaterno,apMaterno,nombres AS nombre,idEstado AS situacion,jurisdiccion,
					(select count(*) from 3021_responsableSeguimientoPaciente where idPaciente=t.id__1022_tablaDinamica and fechaBaja is null) as nSeguimiento 
					
					FROM _1022_tablaDinamica t where idEstado in (1.5)".$comp." 
					
					
					
					
					
					)
					as tmp where ".$condWhere."  ORDER BY folio";
					
		
					
		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		$registros="";
		while($fila=mysql_fetch_row($res))
		{
			$lblTipoContacto="";
			$tipoContacto=$fUltimo[5];
			$valorReferencia=$fUltimo[6];
			$idReferencia=$fUltimo[1];
			switch($tipoContacto)
			{
				case "1":
					$lblTipoContacto="Llamada telefónica a: ".$valorReferencia."";
				break;
				case "2":
					$lblTipoContacto="Correo electr&oacute;nico a: ".$valorReferencia."";
				break;	
			}
			$descripcionUltimoSeguimiento=$lblTipoContacto;
			
			
			$lblMotivoNoContacto="";
			$pos=existeValorMatriz($arrMotivosNoContacto,$fUltimo[21]);
			if($pos!=-1)
				$lblMotivoNoContacto=$arrMotivosNoContacto[$pos][1];
			
			
			$pos=existeValorMatriz($arrMotivosNoAgenda,$fUltimo[25]);
		
			$motivoNoAgenda="";
			if($pos!=-1)
			{
				$motivoNoAgenda=$arrMotivosNoAgenda[$pos][1];
				if($fUltimo[25]==3)
				{
					$motivoNoAgenda.=": ".$fUltimo[27];	
				}
			}
			
			
			$obj='{"jurisdiccion":"'.$fila[8].'","idFolio":"'.$fila[0].'","folio":"'.$fila[1].'","fechaLlenado":"'.$fila[2].'","fechaCaptura":"'.$fila[3].'","apPaterno":"'.$fila[4].'","apMaterno":"'.$fila[5].'","nombre":"'.$fila[6].'","situacion":"'.$fila[7].
				'","fechaUltimoSeguimiento":"'.$fUltimo[2].'","seContacto":"'.$fUltimo[7].'","proximaLlamada":"'.$fUltimo[23].'","comentariosAdicionales":"'.cv($fUltimo[26]).'","descripcionUltimoSeguimiento":"'.cv($descripcionUltimoSeguimiento).'","agendarSeguimiento":"'.$fUltimo[22].
				'","motivoNOAgenda":"'.$motivoNoAgenda.'","motivoNoContacto":"'.$lblMotivoNoContacto.'"}';	
			if($registros=="")
				$registros=$obj;
			else
				$registros.=",".$obj;
			$numReg++;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}';		
	}
	
?>