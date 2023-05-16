<?php session_start();
	include("conexionBD.php"); 
	include_once("funcionesNomina.php"); 
	
	include_once("cfdi/cNomina.php");
	include_once("cfdi/funciones.php");
	include_once("cfdi/cFDIFinkok.php");
	include_once("cfdi/funcionesNominaGeneral.php");
	
	$parametros="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
		if(isset($_POST["param"]))
		{
			$p=$_POST["param"];
			$parametros=json_decode($p,true);
			
		}
		
	}	
	
	switch($funcion)
	{
		case 1: 
			removerEtapaPerfil();
		break;
		case 2:
			guardarPerfilNomina();
		break;
		case 3:
			guardarAccionNomina();
		break;
		case 4:
			eliminarAccion();
		break;
		case 5:
			asignarUsuarioAccion();
		break;
		case 6:
			removerUsuarioAccion();
		break;
		case 7:
			obtenerResultadoNomina();
		break;
		case 8:
			guardarInstanciaNomina();
		break;
		case 9:
			eliminarInstanciaNomina();
		break;
		case 10:
			crearPerfilNomina();
		break;
		case 11:
			obtenerCalculosNomina();
		break;
		case 12:
			obtenerReportesPerfil();
		break;
		case 13:
			modificarPerfilNomina();
		break;
		case 14:
			obtenerDatosPerfilNomina();
		break;
		case 15:
			registrarActorPerfil();
		break;
		case 16:
			removerActorPerfil();
		break;
		case 17:
			obtenerActoresPerfil();
		break;
		case 18:
			guardarActoresEtapaNomina();
		break;
		case 19:
			removerActorNomina();
		break;
		case 20:
			removerEtapaNomina();
		break;
		case 21:
			cambiarSituacionNomina();
		break;
		case 22:
			obtenerInstitucionesAmbitoAccion();
		break;
		case 23:
			guardarAmbitoAccion();
		break;
		case 24:
			guardarOpcionesDictamenNomina();
		break;
		case 25:
			obtenerOpcionesDictamen();
		break;
		case 26:
			obtenerNominasEjecutadas();
		break;
		case 27:
			obtenerHistorialNomina();
		break;
		case 28:
			obtenerFechaInicioFalta();
		break;
		case 29:
			obtenerPeriodosPerfilNomina();
		break;
		case 30:
			generarFuncionAccionNomina();
		break;
		case 31:
			obtenerEntidadesPerfilAgrupador();
		break;
		case 32:
			obtenerNominasPlantel();
		break;
		case 33:
			asignarCategoriaCalculoNomina();
		break;
		case 34:
			timbrarAsientoNomina();
		break;
		case 35:
			reintentarTimbrado();
		break;
		case 36:
			registrarEtiquetaAgrupacion();
		break;
		case 37:
			obtenerEtiquetasAgrupacion();
		break;
		case 38:
			removerEtiquetaAgrupacion();
		break;
		case 39:
			obtenerInstitucionesAsignacionPerfil();
		break;
		case 40:
			registrarPerfilInstitucion();
		break;
		case 41:
			generarXMLAsientoNomina();
		break;
		case 42:
			timbrarXMLAsientoNomina();
		break;
		case 43:
			recrearXMLAsientoNomina();
		break;
		case 44:
			cancelarTimbreAsientoNomina();
		break;
		case 45:
			modificarConfiguracionNomina();
		break;
		case 46:
			actualizarValorCampoNominaAsiento();
		break;
		case 47:
			obtenerPerfilesImportacionDisponibles();
		break;
		case 48:
			registrarPerfilesImportacionPerfilNomina();
		break;
		case 49:
			obtenerPerfilesImportacionPerfilNomina();
		break;
		case 50:
			removerPerfilPerfilNomina();
		break;
		case 51:
			obtenerConfiguracionPerfilImportacion();
		break;
		case 52:
			modificarConfiguracionPerfilImportacion();
		break;
		case 53:
			actualizarConfiguracionPerfilImportacion();
		break;
		case 54:
			obtenerPerfilesImportacionPerfilNominaSelect();
		break;
		case 55:
			actualizarArchivoImportacionNomina();
		break;
		case 56:
			removerArchivoImportacionPerfilNomina();
		break;
		case 57:
			verificarNotificacionesNomina();
		break;
		case 100:
			obtenerEmpleadosNomina();
		break;
		case 101:
			modificarIgnorarGeneracionCalculo();
		break;
		case 102:
			calcularNominaIndividual();
		break;
		case 103:
			registrarClasificadorCalculo();
		break;
		case 104:	
			removerClasificadorCalculo();
		break;
		case 105:
			agregarClasificadorCalculo();
		break;
		case 106:
			quitarClasificadorCalculo();
		break;
		case 107:
			obtenerDetalleCalculo();
		break;
		case 108:
			registrarFiltroAplicacionCalculo();
		break;
		case 109:
			removerFiltroAplicacionCalculo();
		break;
		case 110:
			removerQuincenaAplicacionCalculo();
		break;
			
	}
	
	function  removerEtapaPerfil()
	{
		$idEtapa=$_POST["idEtapa"];
		$x=0;
		$consulta[$x]="DELETE FROM 662_etapasNomina WHERE idEtapa=".$idEtapa;
		$x++;
		$consulta[$x]="DELETE FROM 662_usuariosVSAccionesNomina WHERE idAccionNomina IN (SELECT idAccionNomina FROM 662_accionesEtapaNomina WHERE idEtapa=".$idEtapa.")";
		$x++;
		$consulta[$x]="DELETE FROM 662_accionesEtapaNomina WHERE idEtapa=".$idEtapa;
		$x++;
		eB($consulta);	
		
	}
	
	function guardarPerfilNomina()
	{
		global $con;	
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		
		$query="select count(*) from 662_etapasNomina where idPerfil=".$obj->idPerfil." and noEtapa=".$obj->noEtapa." and idEtapa<>".$obj->idEtapa;
		$nReg=$con->obtenerValor($query);
		if($nReg!=0)
		{
			echo "<br>El número de etapa ingresado ya ha sido registrado anteriormente";
			return;
		}
		if($obj->idEtapa==-1)
			$consulta="insert into 662_etapasNomina(nombreEtapa,noEtapa,idPerfil) values ('".cv($obj->tituloEtapa)."',".$obj->noEtapa.",".$obj->idPerfil.")";
		else
			$consulta="update 662_etapasNomina set nombreEtapa='".cv($obj->tituloEtapa)."',noEtapa=".$obj->noEtapa.",idPerfil=".$obj->idPerfil." where idEtapa=".$obj->idEtapa;
		eC($consulta);
	}
	
	function guardarAccionNomina()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$consulta="select count(*) from 662_accionesActorEtapaNomina where idActorEtapa=".$obj->idActor." and accion=".$obj->idAccion;
		$nReg=$con->obtenerValor($consulta);
		if($nReg==0)
		{
			
			$consulta="INSERT INTO 662_accionesActorEtapaNomina(idActorEtapa,idPerfil,accion) VALUES(".$obj->idActor.",".$obj->idPerfil.",".$obj->idAccion.")";
			eC($consulta);
		}
		else
			echo "1|";
	}
	
	function eliminarAccion()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$x=0;
		$consulta[$x]="DELETE FROM 662_accionesActorEtapaNomina WHERE idAccionNomina=".$idAccion;
		$x++;
		eB($consulta);
	}
	
	function asignarUsuarioAccion()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$idUsuario=$_POST["idUsuario"];
		$cadTerminales=$_POST["cadTerminales"];
		$query="select idUsuario from 662_usuariosVSAccionesNomina where idUsuario=".$idUsuario." and idAccionNomina=".$idAccion;
		$existe=$con->obtenerValor($query);
		if($existe=="")
		{
			$consulta="insert into 662_usuariosVSAccionesNomina(idUsuario,idAccionNomina,terminales) values(".$idUsuario.",".$idAccion.",'".$cadTerminales."')";
			eC($consulta);
		}
		else
		{
			echo "El usuario ya se encuentra asignado a la acci&oacute;n seleccionada"	;
		}
	}
	
	function removerUsuarioAccion()
	{
		global $con;
		$idUsuario=$_POST["iU"];
		$idAccion=$_POST["iA"];
		$consulta="delete from 662_usuariosVSAccionesNomina where idUsuario=".$idUsuario." and idAccionNomina=".$idAccion;
		eC($consulta);
	}
	
	function obtenerResultadoNomina()
	{
		global $con;
		$idNomina=$_POST["idNomina"];
		$consulta="SELECT tipoNomina,fechaEstimadaPago,idFormaPago FROM 672_nominasEjecutadas WHERE idNomina=".$idNomina;
		$fNomina=$con->obtenerPrimeraFila($consulta);
		$tNomina=$fNomina[0];
		$numReg=0;
		$arrDatos="";
		switch($tNomina)
		{
			case 2:
				$consulta="select a.cvePuesto as puesto,a.tipoContratacion as tipoPuesto,'0' as zona,concat(apPaterno,' ',apMaterno,' ',nombre) as titular,totalDeducciones,totalPercepciones,sueldoNeto,codDepartamento  as codigoDepto,i.idEmpleado,a.sueldoCompactado,
							a.tipoPago,a.situacion,a.horasTrabajador,a.idUnidadAgrupadora,a.identificador,descriptorIdentificador,a.idComprobante,a.idAsientoNomina,date_format(a.fechaPago,'%Y-%m-%d'),a.ignorarTimbrado
							from 671_asientosCalculosNomina a,693_empleadosNominaV2 i where i.idEmpleado=a.idUsuario and idNomina=".$idNomina;	
			
			
				$numReg=0;
				$arrDatos="";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$cadObj="";
					
					for($pos=0;$pos<17;$pos++)
					{
						if($cadObj=="")
							$cadObj="'".cv($fila[$pos])."'";
						else
							$cadObj.=",'".cv($fila[$pos])."'";
						
					}
					
					if($fila[16]!="")
					{
						$consulta="SELECT situacion,comentarios FROM 703_relacionFoliosCFDI WHERE idFolio=".$fila[16];
						$fSituacion=$con->obtenerPrimeraFila($consulta);
						$cadObj.=",'".$fSituacion[0]."'";
						if($fSituacion[0]==5)
						{
							
							$cadObj.=",'".cv($fSituacion[1])."'";	
							
						}
						else
							$cadObj.=",''";	
					}
					else
					{
						$total=$fila[5]-$fila[4];
		
						if($total>0.001)
							$cadObj.=",'1',''";
						else
							$cadObj.=",'6',''";
					}
					
					
					if($fila[18]=="")
						$fila[18]=$fNomina[1];
					
					
					$ignorarTimbrado="false";
					if($fila[19]==1)
						$ignorarTimbrado="true";
					$cadObj.=",'".$fila[17]."','".$fila[18]."',".$ignorarTimbrado;
					$o="[".$cadObj."]";
					if($arrDatos=="")
						$arrDatos=$o;
					else
						$arrDatos.=",".$o;
					$numReg++;
				}
			
			break;
			default:
				/*$consulta="select cvePuesto as puesto,tipoContratacion as tipoPuesto,idZona as zona,concat(Paterno,' ',Materno,' ',Nom) as titular,totalDeducciones,totalPercepciones,sueldoNeto,codDepartamento  as codigoDepto,i.idUsuario,a.sueldoCompactado,
							a.tipoPago,a.situacion,a.horasTrabajador,a.idUnidadAgrupadora,a.identificador,descriptorIdentificador,a.idComprobante,a.idAsientoNomina,date_format(a.fechaPago,'%Y-%m-%d'),a.ignorarTimbrado	
							from 671_asientosCalculosNomina a,802_identifica i where i.idUsuario=a.idUsuario and idNomina=".$idNomina;	
			*/
				$consulta="SELECT cvePuesto,tipoContratacion,idZona,totalDeducciones,totalPercepciones,sueldoNeto,codDepartamento,idUsuario,sueldoCompactado,a.tipoPago,a.situacion,a.horasTrabajador,a.idUnidadAgrupadora,
							a.identificador,descriptorIdentificador,a.idComprobante,a.idAsientoNomina,DATE_FORMAT(a.fechaPago,'%Y-%m-%d'),a.ignorarTimbrado,a.tipoPago 
							FROM 671_asientosCalculosNomina a  WHERE idNomina=".$idNomina;
			
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					
					$consulta="select * from 802_identifica where idUsuario=".$fila[7];
					$fIdentifica=$con->obtenerPrimeraFila($consulta);
					
					$situacionComprobante="";
					$comentarios="";
					if($fila[15]!="")
					{
						$consulta="SELECT situacion,comentarios FROM 703_relacionFoliosCFDI WHERE idFolio=".$fila[15];
						$fSituacion=$con->obtenerPrimeraFila($consulta);
						$situacionComprobante=$fSituacion[0];
						$comentarios=$fSituacion[1];
					}
					else
					{
						$total=$fila[4]-$fila[3];
		
						if($total>0.001)
						{
							
							$situacionComprobante=1;
							$comentarios="";
						}
						else
						{
							$situacionComprobante=6;
							$comentarios="";	
						}
							
					}
					
					
					$nombreEmpleado="";
					if($fIdentifica)
						$nombreEmpleado=$fIdentifica[2]." ".$fIdentifica[3]." ".$fIdentifica[1];
					else
					{
						$situacionComprobante=6;
						$fila[7]*=-1;
					}
					
					if($fila[17]=="")	
						$fila[17]=$fNomina[1];
					
					$metodoPago=$fila[19];
					if(($metodoPago=="")||($metodoPago=="-1"))
						$metodoPago=$fNomina[2]	;
					
					$o='{"puesto":"'.$fila[0].'","tipoPuesto":"'.$fila[1].'","zona":"'.$fila[2].'","titular":"'.cv($nombreEmpleado).'","totalDeducciones":"'.$fila[3].'","totalPercepciones":"'.$fila[4].'","sueldoNeto":"'.$fila[5].
						'","codigoDepto":"'.$fila[6].'","idUsuario":"'.$fila[7].'","sueldoCompactado":"'.$fila[8].'","tipoPago":"'.$fila[9].'","situacion":"'.$fila[10].'","horasTrabajador":"'.$fila[11].'",
						"idUnidadAgrupadora":"'.$fila[12].'","identificador":"'.$fila[13].'","descriptorIdentificador":"'.$fila[14].'","idComprobante":"'.$fila[15].'","situacionComprobante":"'.$situacionComprobante.'",
						"comentarios":"'.cv($comentarios).'","idAsientoNomina":"'.$fila[16].'","fechaPago":"'.$fila[17].'","ignorarTimbrado":'.($fila[18]==1?'true':'false').',"metodoPago":"'.$metodoPago.'"}';
					
					if($arrDatos=="")
						$arrDatos=$o;
					else
						$arrDatos.=",".$o;
					
					$numReg++;
				}
			
			
			
			break;
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrDatos.']}';
	}
	
	function guardarInstanciaNomina()
	{
		global $con;	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
	
		$institucion=$_SESSION["codigoInstitucion"];

		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		if($obj->fechaFalta=="")
			$obj->fechaFalta="NULL";
		else
			$obj->fechaFalta="'".$obj->fechaFalta."'";
			
		if($obj->fechaFaltaDesde=="")
			$obj->fechaFaltaDesde="NULL";
		else
			$obj->fechaFaltaDesde="'".$obj->fechaFaltaDesde."'";	

		$idUnidadAgrupadora=0;		
		
		$cadEntidades=bD($obj->entidadesAplica);
		$cadEntidades=str_replace("],[","@@",$cadEntidades);
		$cadEntidades=str_replace("]","",$cadEntidades);
		$cadEntidades=str_replace("[","",$cadEntidades);
		$arrEntidades=explode("@@",$cadEntidades);
		
		
		
		foreach($arrEntidades as $e)
		{
			$arrDatos=explode(",",str_replace("'","",$e));
			
			if($arrDatos[0]<0)
			{
				$idUnidadAgrupadora=$arrDatos[0]*-1;
				break;
			}
		}
		
		$tNomina="NULL";
		if(isset($obj->esquemaNomina))
			$tNomina=$obj->esquemaNomina;
		
		$idFormaPago="NULL";
		if(isset($obj->metodoPago))
			$idFormaPago=$obj->metodoPago;
		
		$idArchivoImportacion="NULL";
		if(isset($obj->idPerfilImportacion)&&($obj->idPerfilImportacion!='0'))
		{
			$idArchivoImportacion=registrarDocumentoServidor($obj->idArchivoImportacion,$obj->nombreArchivoImportacion);
			
		}
		
		
		if(($obj->tipoAplicacion==1)||($obj->nominasIndividuales==0))
		{
			$folioNomina=generarFolioNomina($obj->ciclo);
			$consulta[$x]="	INSERT INTO 672_nominasEjecutadas(idFormaPago,tipoNomina,idPerfil,fechaInicioIncidencias,fechaFinIncidencias,
							fechaEstimadaPago,etapa,configuracion,ciclo,quincenaAplicacion,ambitoAplicacion,descripcion,folioNomina,institucion,
							fechaCorteAsistencia,idUsuarioCreacion,fechaInicioFalta,idUnidadAgrupadora,idPerfilImportacion,idArchivoImportacion,versionNomina)
							VALUES(".$idFormaPago.",".$tNomina.",".$obj->tipoNomina.",'".$obj->fechaIniInc."','".$obj->fechaFinInc."','".$obj->fechaPago."',1,'".cv(bD($obj->entidadesAplica))."',".$obj->ciclo.",'".$obj->quincenaAplicacion."',".
							$obj->tipoAplicacion.",'".cv($obj->descripcion)."','".$folioNomina."','".$institucion."',".$obj->fechaFalta.",".$_SESSION["idUsr"].",".$obj->fechaFaltaDesde.",".$idUnidadAgrupadora.",".
							(isset($obj->idPerfilImportacion)?$obj->idPerfilImportacion:'0').",".$idArchivoImportacion.",".$obj->versionNomina.")";
			$x++;
			$consulta[$x]="set @idNomina:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 676_historialNomina(idNomina,fechaCambioEtapa,etapaAnterior,etapaActual,idResponsableCambio,comentarios) VALUES(@idNomina,'".date("Y-m-d H:i")."',NULL,1,".$_SESSION["idUsr"].",'Se crea nómina')";
			$x++;
		}
		else
		{
			$cadEntidades=bD($obj->entidadesAplica);
			$cadEntidades=str_replace("],[","@@",$cadEntidades);
			$cadEntidades=str_replace("]","",$cadEntidades);
			$cadEntidades=str_replace("[","",$cadEntidades);
			$arrEntidades=explode("@@",$cadEntidades);
			foreach($arrEntidades as $e)
			{
				
				$arrDatos=explode(",",str_replace("'","",$e));
				
				
				$cadElem="[['".$arrDatos[0]."','".$arrDatos[1]."','".$arrDatos[2]."']]";
				
					
				$folioNomina=generarFolioNomina($obj->ciclo);	
				$consulta[$x]="	INSERT INTO 672_nominasEjecutadas(idFormaPago,tipoNomina,idPerfil,fechaInicioIncidencias,fechaFinIncidencias,fechaEstimadaPago,
								etapa,configuracion,ciclo,quincenaAplicacion,ambitoAplicacion,descripcion,folioNomina,institucion,
								fechaCorteAsistencia,idUsuarioCreacion,fechaInicioFalta,idUnidadAgrupadora,idPerfilImportacion,idArchivoImportacion,versionNomina)
								VALUES(".$idFormaPago.",".$tNomina.",".$obj->tipoNomina.",'".$obj->fechaIniInc."','".$obj->fechaFinInc."','".$obj->fechaPago
								."',1,'".cv($cadElem)."',".$obj->ciclo.",'".$obj->quincenaAplicacion."',".$obj->tipoAplicacion.",'".cv($obj->descripcion).
								"','".$folioNomina."','".$institucion."',".$obj->fechaFalta.",".$_SESSION["idUsr"].",".$obj->fechaFaltaDesde.",".$idUnidadAgrupadora.
								",".(isset($obj->idPerfilImportacion)?$obj->idPerfilImportacion:'0').",".$idArchivoImportacion.",".$obj->versionNomina.")";
				$x++;	
				$consulta[$x]="set @idNomina:=(select last_insert_id())";
				$x++;
				$consulta[$x]="INSERT INTO 676_historialNomina(idNomina,fechaCambioEtapa,etapaAnterior,etapaActual,idResponsableCambio,comentarios) VALUES(@idNomina,'".date("Y-m-d H:i")."',NULL,1,".$_SESSION["idUsr"].",'Se crea nómina')";
				$x++;
				
			}
			
		}
		
		
		$consulta[$x]="commit";
		$x++;
	
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idNomina";
			$idNomina=$con->obtenerValor($query);
			echo "1|".$idNomina;
		}
	}
	
	function eliminarInstanciaNomina()
	{
		global $con;
		$idNomina=$_POST["idNomina"];
		$query="select * from 672_nominasEjecutadas where idNomina=".$idNomina;
		$filaNomina=$con->obtenerPrimeraFila($query);
		$x=0;
		$consulta[$x]="begin";	
		$x++;
		$consulta[$x]="DELETE FROM 672_nominasEjecutadas WHERE idNomina=".$idNomina;
		$x++;
		$consulta[$x]="DELETE FROM 671_asientosCalculosNomina WHERE idNomina=".$idNomina;
		$x++;
		$consulta[$x]="commit";	
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			
			$idPerfil=$filaNomina[1];
			$consulta="SELECT precisionDecimales,criterioPrecision,idFuncionRecalculo,idFuncionEliminacion FROM 662_perfilesNomina WHERE idPerfilesNomina=".$idPerfil;

			$fPerfil=$con->obtenerPrimeraFila($consulta);
			if(($fPerfil[3]!="")&&($fPerfil[3]!="-1"))
			{
				$cache=NULL;
				$cadObj='{"idNomina":"'.$idNomina.'"}';
				$obj=json_decode($cadObj);
				resolverExpresionCalculoPHP($fPerfil[3],$obj,$cache);
			}
			echo "1|";
		}
	}
	
	function crearPerfilNomina()
	{
		global $con;
		$nombrePerfil=$_POST["nombrePerfil"];
		$descripcion=$_POST["descripcion"];
		$idPeriodicidad=$_POST["idPeriodicidad"];
		$consulta="insert into 662_perfilesNomina(nombrePerfil,descripcion,fechaCreacion,idResponsable,idPeriodicidad,criterioPrecision,precisionDecimales) 
					values('".cv($nombrePerfil)."','".cv($descripcion)."','".date("Y-m-d")."',".$_SESSION["idUsr"].",".$idPeriodicidad.",2,2)";
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|".$con->obtenerUltimoID();
		}
	}
	
	function obtenerCalculosNomina()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$condWhere="1=1";
		
		
		$consulta="SELECT idPeriodicidad FROM 662_perfilesNomina WHERE idPerfilesNomina=".$idPerfil;
		$idPeriodicidad=$con->obtenerValor($consulta);
		
		$idFormularioCatPuestos=obtenerIDFormularioCategoria("CP");
		$idFormularioCatTiposContratacion=obtenerIDFormularioCategoria("TC");
		$idFormularioCatClasificacionPuestos=obtenerIDFormularioCategoria("CLP");
		
		
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$consulta="select idTipoPresupuesto,tituloTipoP from 508_tiposPresupuesto order by tituloTipoP";
								$arrTipoPresupuesto=$con->obtenerFilasArregloAsocPHP($consulta);
		$consulta="select d.idCalculo,c.codigo,c.nombreConsulta,afectacionNomina,tipoCalculo,c.idConsulta ,
				orden,categoriaCalculo,idFuncionGravamen,idEtiquetaAgrupadora,ambitoEtiqueta,etiquetaConcepto ,cveCalculo,idCalculoAsociado,mostrarSiValorCero,
				incluirEnCache,calcularSiCalculoAsociadoIgualCero
					from 662_calculosNomina d,991_consultasSql c where c.idConsulta=d.idConsulta and idUsuarioAplica is null and idPerfil=".$idPerfil." and ".$condWhere." order by orden limit ".$start.",".$limit;
		$resCalculos=$con->obtenerFilas($consulta);
		$nReg=0;
		$tipoConsulta=1;
		$cadObj="";
		while($fila=mysql_fetch_assoc($resCalculos))
		{
			$cadAcum="";	
			$consulta="SELECT a.idAcumuladorCalculo,a.operacion,n.nombreAcumulador FROM 666_acumuladoresCalculo a,665_acumuladoresNomina n 
						WHERE n.idAcumuladorNomina=a.idAcumulador AND a.idCalculo=".$fila["idCalculo"];
			$resAcum=$con->obtenerFilas($consulta);
			if($con->filasAfectadas>0)
			{
				$btnAgregar='';
				$cadAcum='<table width="100%"><tr><td>
                                                        	<table>
                                                    		<tr>
                                                                <td width="140" class="letraAzulSimple">
                                                                Acumulador  '.$btnAgregar.'
                                                                </td>
                                                                <td width="70" class="letraAzulSimple">
                                                                Operaci&oacute;n
                                                                </td>
                                                                
                                                            </tr>';
				while($filaAcum=mysql_fetch_row($resAcum))
				{
					$lblAccion="";
					switch($filaAcum[1])
					{
						case "+":
							$lblAccion="Sumar";
						break;
						case "-":
							$lblAccion="Restar";
						break;
						case "*":
							$lblAccion="Multiplicar";
						break;
						case "/":
							$lblAccion="Dividir";
						break;
						case "=":
							$lblAccion="Asignar";
						break;
						
					}
					$cadAcum.= '<tr id="fila_'.$filaAcum[0].'">
									<td class="" style="color:#000">
									<a href="javascript:removerAsignacionAcum(\''.bE($filaAcum[0]).'\')"><img src="../images/delete.png" width="13" height="13" title="Remover asignaci&oacute;n de acumulador" alt="Remover asignaci&oacute;n de acumulador"></a> 
									'.$filaAcum[2].'
									</td>
									<td class="" style="color:#000">'.$filaAcum[1]." (".$lblAccion.')</td>
									
								</tr>';	
					
				}
				$cadAcum.='	</table>
                                                       </td>
                                                   </tr>

                                                    </table>';										
                                                            
			}
			
			$cadParametros="";
			$consulta="select idParametro,parametro from 993_parametrosConsulta where idConsulta=".$fila["idConsulta"]." order by parametro";
			$resParam=$con->obtenerFilas($consulta);
			while($filaP=mysql_fetch_row($resParam))
			{
				$consulta="select valor,tipoValor from 663_valoresCalculos where idCalculo=".$fila["idCalculo"]." and idParametro=".$filaP[0];
				$filaValParam=$con->obtenerPrimeraFila($consulta);
				$valor=$filaValParam[0];
				
				
				
				switch($filaValParam[1])
				{
					case "21":
						$consulta="SELECT nombreAcumulador FROM 665_acumuladoresNomina WHERE idAcumuladorNomina=".$valor;
						$valor=$con->obtenerValor($consulta);
					break;
					case "2":
						if($idUsuario!="-1")
						{
							$consulta="select concat(orden,'.- [',co.codigo,'] ',co.nombreConsulta,' <br>[<b>Tipo:</b> ',if(idUsuarioAplica is null,'Global','Individual'),']')  from 662_calculosNomina c,
										991_consultasSql co where co.idConsulta=c.idConsulta and 
										c.idCalculo =".$valor;
						}
						else
						{
							$consulta="select concat(orden,'.- [',co.codigo,'] ',co.nombreConsulta)  from 662_calculosNomina c,
										991_consultasSql co where co.idConsulta=c.idConsulta and 
										c.idCalculo =".$valor;
						}
						$valor=$con->obtenerValor($consulta);
					break;
					default:
					break;
						
				}
				$cadParametros.="<tr height='21'><td valign='top'><b><span class='letraExt'>".$filaP[1].
								"=</span></b></td><td width='3'></td><td valign='top'><span id='lblValor_".$fila["idCalculo"]."_".$filaP[0].
								"'>".$valor."</span></td><td valign='top'>&nbsp;<a href='javascript:modificarValorParametro(\"".bE($fila["idCalculo"]).
								"\",\"".bE($filaP[0])."\",\"".bE($fila["orden"])."\")'><img height='13' width='13' src='../images/pencil.png' title='Modificar valor par&aacute;metro' alt='Modificar valor par&aacute;metro'></a></td></tr>";
			}
			if($cadParametros!="")
				$cadParametros="<table>".$cadParametros."</table>";
			
			
			$cadAplicacionPuestos='<table width="100%">
						  <tr height=\'21\'>
							  <td align="right">
								  	  <a href="javascript:agregarFiltroAfectacionCalculo(\''.bE($fila["idCalculo"]).'\')"><img src="../images/user_add.png" title=\'Agregar Filtro de Aplicaci&oacute;n\' alt=\'Agregar Filtro de Aplicaci&oacute;n\'/></a>
							  </td>
						  </tr>
						  <tr height="1">
							  <td style="background-color:#FF3">
							  </td>
						  </tr>
						  ';
			
			$consulta="SELECT idElemento,idRegistro,tipoElemento FROM 669_filtroAplicacionCalculosNomina WHERE idCalculo=".$fila["idCalculo"]." ORDER BY tipoElemento";
			$resTipoElemento=$con->obtenerFilas($consulta);
			while($filaElemento=mysql_fetch_row($resTipoElemento))
			{
				$lblElemento="";
				switch($filaElemento[2])
				{
					case 1: //Tipo de Contratación
						$consulta="SELECT tipoContratacion FROM _".$idFormularioCatTiposContratacion."_tablaDinamica where id__".$idFormularioCatTiposContratacion."_tablaDinamica=".$filaElemento[0];
						$lblElemento=$con->obtenerValor($consulta);
						$lblElemento.=" (Tipo de Contrataci&oacute;n)";
					
					break;
					case 2: //Clasificación del Puesto
						$consulta="SELECT nomPuesto FROM _".$idFormularioCatClasificacionPuestos."_tablaDinamica where id__".$idFormularioCatClasificacionPuestos."_tablaDinamica=".$filaElemento[0];
						$lblElemento=$con->obtenerValor($consulta);
						$lblElemento.=" (Clasificaci&oacute;n del Puesto)";
					break;
					case 3:	//Puesto
						$consulta="SELECT nomPuesto FROM _".$idFormularioCatPuestos."_tablaDinamica where id__".$idFormularioCatPuestos."_tablaDinamica=".$filaElemento[0];
						$lblElemento=$con->nombrePuesto($consulta);
						$lblElemento.=" (Puesto)";
					break;
				}
				$cadAplicacionPuestos.='<tr id="filaFiltro_'.$filaElemento[1].'"><td><a href="javascript:removerFiltro(\''.bE($filaElemento[1]).'\')"><img src="../images/delete.png" width="14" height="14"></a>&nbsp;&nbsp;'.$lblElemento.'</td></tr>';
			}
						  

			$cadAplicacionPuestos.='</table>';
			
			 $leyenda='';

			  switch($fila["afectacionNomina"])
			  {
				  case 1:
					  $checar1='checked="checked"';
					  $checar2="";
					  $checar3="";
					  $leyenda="N/A";
				  break;
				  case 2:
					  
					  $checar2='checked="checked"';
					  $checar1="";
					  $checar3="";
					  $leyenda="N/A";
				  break;
				  case 3:
					  
					  $checar3='checked="checked"';
					  $checar2="";
					  $checar1="";
					  
					  
					  
					  $cadAplicacionQuincena='<table width="100%">
											  <tr height=\'21\'>
												  <td align="right">
														  <a href="javascript:configurarQuincenasAplicacion(\''.$fila["idCalculo"].'\')"><img src="../images/pencil.png" alt="Configurar quincena aplicación" title="Configurar quincena aplicación"></a>
												  </td>
											  </tr>
											  <tr height="1">
												  <td style="background-color:#FF3">
												  </td>
											  </tr>
											  ';
					  
					  
					  $consulta="SELECT idRegistro,cicloAplicacion,quincenaAplicacion FROM 670_quincenasAplicacionCalculosNomina WHERE idCalculo=".$fila["idCalculo"].
					  			" ORDER BY cicloAplicacion,quincenaAplicacion";
					  $rQuincenaAplicacion=$con->obtenerFilas($consulta);
					  while($fQuincenaAplicacion=mysql_fetch_assoc($rQuincenaAplicacion))
					  {
						  $consulta="SELECT nombreElemento FROM _642_gElementosPeriodicidad WHERE idReferencia=".$idPeriodicidad.
						  			" and noOrdinal=".$fQuincenaAplicacion["quincenaAplicacion"];
						  $lblQuincena=$con->obtenerValor($consulta);
						  
						  $lblQuincena.=$fQuincenaAplicacion["cicloAplicacion"]==""?" (Cualquier Ciclo)":" (Ciclo: ".$fQuincenaAplicacion["cicloAplicacion"].")";
						  
						  $cadAplicacionQuincena.='<tr id="filaQuincena_'.$fQuincenaAplicacion["idRegistro"].'"><td><a href="javascript:removerQuincenaAplicacion(\''.
						  bE($fQuincenaAplicacion["idRegistro"]).'\')"><img src="../images/delete.png" width="14" height="14"></a>&nbsp;&nbsp;'.$lblQuincena.'</td></tr>';
					  }
					  
					  $cadAplicacionQuincena.='</table>';
					  
					  $leyenda=$cadAplicacionQuincena;
				  break;	
			  }

          $cadenaAfectacion='<input type="radio" id="chk_1_'.$fila["idCalculo"].'" name="aplicacion_'.$fila["idCalculo"].'" onclick="actualizarAfectacionNomina(this)" '.$checar1.'/>&nbsp;<span class="letraExt">Permanente</span><br />'.
						  	'<input type="radio" id="chk_2_'.$fila["idCalculo"].'" name="aplicacion_'.$fila["idCalculo"].'" onclick="actualizarAfectacionNomina(this)" '.$checar2.'/>&nbsp;<span class="letraExt">No afectar (Deshabilitar)</span><br />'.
		  					'<input type="radio" id="chk_3_'.$fila["idCalculo"].'" name="aplicacion_'.$fila["idCalculo"].'" onclick="actualizarAfectacionNomina(this)" '.$checar3.'/>&nbsp;<span class="letraExt">Aplicar a quincenas</span><br />';
			
			
			
			$afectacionContable='<table >';		
			$consulta="select * from 661_afectacionesCuentasDeducPercepciones where idDeduccionPercepcion=".$fila["idCalculo"]." and tipo=".$tipoConsulta;
			$btnAgregarCta='<a href="javascript:mostrarVentanaCuenta(\''.bE($fila["idCalculo"]).'\')"><img width="13" height="13" src="../images/add.png" alt="Agregar afectación de cuenta" title="Agregar afectación de cuenta" /></a>';
			$resCtas=$con->obtenerFilas($consulta);
			if($con->filasAfectadas>0)
			{
				$afectacionContable .="	<tr>
											<td class='fondoVerde7' align='center' width='150'><span style='color:#000'>Cuenta</span> ".$btnAgregarCta."</td>
											<td class='fondoVerde7' align='center' width='350'><span style='color:#000'>Descripci&oacute;n de cuenta</span></td>
											<td class='fondoVerde7' align='center' width='100'><span style='color:#000'>Tipo afectación</span></td>
											<td class='fondoVerde7' align='center' width='100'><span style='color:#000'>% afectación</span></td>
											<td class='fondoVerde7' align='center' width='300'><span style='color:#000'>Beneficiario</span></td>
											<td class='fondoVerde7' align='center' width='180'><span style='color:#000'>Tipo de presupuesto</span></td>
											<td></td>
										</tr>";
			}
			
			while($fCta=mysql_fetch_row($resCtas))
			{
				if($fCta[6]==1)
					$afectacion="Debe";
				else
					$afectacion="Haber";
				$consulta="select tituloCta,codigoUnidadCta from 510_cuentas where codigoCta='".$fCta[3]."'";
				$fEstructura=$con->obtenerPrimeraFila($consulta);
				$afectacionContable.='				
											<tr id="fila_'.$fila["idCalculo"].'_'.$fCta[0].'">
												<td class="fondoGrid7" align="left"><span style="color:#000">'.$fEstructura[1].'</span></td>
												<td class="fondoGrid7" align="left"><span style="color:#000">'.$fEstructura[0].'</span></td>
												<td class="fondoGrid7" align="left"><span id="afectacionTipoCta_'.$fCta[0].'" style="color:#000">'.$afectacion.'</span>&nbsp;<a href="javascript:modificarTipoAfectacion(\''.bE($fCta[0]).'\')">
													<img src="../images/pencil.png" alt="Modificar tipo de afectación" title="Modificar tipo de afectación" /></a>
												</td>
												<td class="fondoGrid7" align="left"><span id="afectacionCta_'.$fCta[0].'" style="color:#000">'.$fCta[5].' %</span>&nbsp;<a href="javascript:modficarPorcentaje(\''.bE($fCta[0]).'\')">
													<img src="../images/pencil.png" alt="Modificar porcentaje de afectación" title="Modificar porcentaje de afectación" /></a>
												</td>
												<td align="left" class="fondoGrid7">
													<span class="letraExt" id="lblBeneficiario_'.$fCta[0].'" style="color:#000">';

														if($fCta[8]!="")
														{
															if($fCta[8]==0)
															{
																$afectacionContable.="Empleado en cuestión";	
															}
															else
															{
																$consulta="";
																if($fCta[9]=="1")
																	$consulta="select txtBeneficiario from _217_tablaDinamica  where id__217_tablaDinamica=".$fCta[8];
																else
																	$consulta="select txtBeneficiario from _216_tablaDinamica  where id__216_tablaDinamica=".$fCta[8];
																$afectacionContable.=$con->obtenerValor($consulta);
															}
														}

													$afectacionContable.='</span>&nbsp;<a href="javascript:modificarBeneficiario(\''.bE($fCta[0]).'\'"><img src="../images/pencil.png" title="Modificar beneficiario" alt="Modificar beneficiario" /></a>
																			</td>
																			<td align="center" class="fondoGrid7">
																			<select id="cmbTipoPresupuesto_'.$fCta[0].'" onchange="modificarTipoRecurso(this)">
																			<option value="-1">Seleccione</option>'.$con->generarOpcionesSelectArregloAsocNoImp($arrTipoPresupuesto,$fCta[10]).'</select>
																			</td><td><a href="javascript:eliminarCuenta(\''.bE($fCta[0]).'\',\''.bE($fila["idCalculo"]).'\')"><img src="../images/delete.png" title="Remover configuración de cuenta" alt="Remover configuración de cuenta" /></a></td>
																			</tr>';

			
			}
			$afectacionContable.="</table>";
			
			if($fila["idEtiquetaAgrupadora"]=="")
				$fila["idEtiquetaAgrupadora"]=0;
			else
			{
				if($fila["ambitoEtiqueta"]=="")
					$fila["ambitoEtiqueta"]=3;
			}
			
			$etiquetaConcepto=$fila["etiquetaConcepto"];
			if($etiquetaConcepto=="")
			{

				$etiquetaConcepto=$fila["nombreConsulta"];
			}
			
			
			$clasificacionCalculo="<table><tr><td align='right' width='280'><a href='javascript:agregarClasificadorCalculo(\"".bE($fila["idCalculo"])."\")'><img src='../images/add.png'></a></td></tr>";
			
			$consulta="SELECT cc.idRegistro,cN.nombreClasificador,cN.idRegistro as iClasificador FROM 668_clasificacionCalculosNomina cc,667_clasificadoresNomina cN WHERE
					 cN.idRegistro=cc.idClasificador AND cc.idCalculo=".$fila["idCalculo"]." ORDER BY cN.nombreClasificador";
			$rClasificadores=$con->obtenerFilas($consulta);
			
			if($con->filasAfectadas>0)
			{
				$clasificacionCalculo.="<tr><td align='center'><b>Clasificador</b></td></tr>";
			}
			
			while($fClasificador=mysql_fetch_row($rClasificadores))
			{
				$clasificacionCalculo.="<tr id='filaClasificador_".$fClasificador[0]."'><td><a href='javascript:removerClasificadorCalculo(\"".bE($fClasificador[0])."\")'><img src='../images/delete.png' width='14' height='14'></a>&nbsp;&nbsp;&nbsp;(ID: ".$fClasificador[2].") ".$fClasificador[1]."</td></tr>";
			}
			$clasificacionCalculo.="</table>";
			
			$obj='{"etiquetaConcepto":"'.cv($etiquetaConcepto).'","idEtiquetaAgrupadora":"'.cv($fila["idEtiquetaAgrupadora"]).'","ambitoEtiqueta":"'.cv($fila["ambitoEtiqueta"]).
					'","idFuncionGravamen":"'.$fila["idFuncionGravamen"].'","categoriaCalculo":"'.$fila["categoriaCalculo"].'","idCalculo":"'.$fila["idCalculo"].
					'","orden":"'.$fila["orden"].'","tipoCalculo":"'.$fila["tipoCalculo"].'","codigo":"'.$fila["codigo"].'","nombreConsulta":"'.cv($fila["nombreConsulta"]).
					'","parametros":"'.cv($cadParametros).'","acumulador":"'.cv($cadAcum).'","aplicacionCalculo":"'.cv($cadAplicacionPuestos).
					'","afectacion":"'.cv($cadenaAfectacion).'","quincenaAplicacion":"'.cv($leyenda).'","afectacionContable":"'.cv($afectacionContable).
					'","cveCalculo":"'.cv($fila["cveCalculo"]).'","idCalculoAsociado":"'.$fila["idCalculoAsociado"].'","clasificacionCalculo":"'.cv($clasificacionCalculo).
					'","mostrarSiValorCero":"'.$fila["mostrarSiValorCero"].'","incluirEnCache":"'.$fila["incluirEnCache"].
					'","calcularSiCalculoAsociadoIgualCero":"'.$fila["calcularSiCalculoAsociadoIgualCero"].'"}';
			if($cadObj=="")
				$cadObj=$obj;
			else
				$cadObj.=",".$obj;
			$nReg++;
		}
		$consulta="select count(*) from 662_calculosNomina d,991_consultasSql c 
				where c.idConsulta=d.idConsulta and idUsuarioAplica is null and idPerfil=".$idPerfil;
		$nReg=$con->obtenerValor($consulta);		
		echo '{"numReg":"'.$nReg.'","registros":['.$cadObj.']}';
	}
	
	function obtenerReportesPerfil()
	{
		global $con;
		$idNomina=$_POST["idNomina"];
		$consulta="SELECT idPerfil FROM 672_nominasEjecutadas WHERE idNomina=".$idNomina;
		$idPerfil=$con->obtenerValor($consulta);
		$consulta="SELECT txtRutaReporte,txtTituloReporte FROM _502_tablaDinamica WHERE cmbPerfilNomina=".$idPerfil." AND situacion='1'
					ORDER BY txtTituloReporte";
		$arrReportes=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrReportes;
			
	}
	
	function modificarPerfilNomina()
	{
		global $con;
		$idPefil=$_POST["idPefil"];
		$accion=$_POST["accion"];
		$precision=$_POST["precision"];
		$nombrePerfil=$_POST["nombrePerfil"];
		$descripcion=$_POST["descripcion"];
		$idPeriodicidad=$_POST["idPeriodicidad"];
		$considerarAsistencia=$_POST["considerarAsistencia"];
		$limitarFechasPeriodo=$_POST["limitarFechasPeriodo"];
		$consulta="UPDATE 662_perfilesNomina SET limitarFechasPeriodo=".$limitarFechasPeriodo.",considerarAsistencia=".$considerarAsistencia.",idPeriodicidad=".$idPeriodicidad.",nombrePerfil='".cv($nombrePerfil)."',descripcion='".cv($descripcion)."',precisionDecimales=".$precision.",criterioPrecision=".$accion." WHERE idPerfilesNomina=".$idPefil;
		eC($consulta);
			
	}
	
	function obtenerDatosPerfilNomina()
	{
		global $con;
		$idPefil=$_POST["idPefil"];
		$consulta="SELECT * FROM 662_perfilesNomina WHERE idPerfilesNomina=".$idPefil;
		$fPerfil=$con->obtenerPrimeraFila($consulta);
		echo '1|{"limitarFechasPeriodo":"'.$fPerfil[11].'","considerarAsistencia":"'.$fPerfil[8].'","idPeriodicidad":"'.$fPerfil[7].'","nombrePerfil":"'.cv($fPerfil[1]).'","descripcion":"'.cv($fPerfil[2]).'","precisionDecimales":"'.$fPerfil[5].'","criterioPrecision":"'.$fPerfil[6].'"}';
			
	}
	
	function registrarActorPerfil()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$idRol=$_POST["idRol"];
		$consulta="INSERT INTO 662_actoresPerfilNomina(actor,tipoActor,idPerfil) VALUES('".$idRol."',1,".$idPerfil.")";
		eC($consulta);
		
	}
	
	function removerActorPerfil()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$idRol=$_POST["idRol"];
		$consulta="delete from 662_actoresPerfilNomina where actor='".$idRol."' and idPerfil=".$idPerfil;
		eC($consulta);
		
	}
	
	function obtenerActoresPerfil()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$consulta="SELECT actor FROM 662_actoresPerfilNomina WHERE idPerfil=".$idPerfil;
		$res=$con->obtenerFilas($consulta);
		$cadArr="";
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"icon":"../images/bullet_green.png","id":"'.$fila[0].'","text":"'.obtenerTituloRol($fila[0]).'","leaf":true}';
			if($cadArr=="")
				$cadArr=$obj;
			else
				$cadArr.=",".$obj;
		}
		echo "[".$cadArr."]";
	}
	
	function guardarActoresEtapaNomina()
	{
		global $con;
		$numEtapa=$_POST["numEtapa"];
		$cadActores=$_POST["cadActores"];
		$idPerfil=$_POST["idPerfil"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrActores=explode(",",$cadActores);
		foreach($arrActores as $a)
		{
			$arrAct=explode("|",$a);
			$query="select count(*) from 662_actoresEtapaNomina where idPerfil=".$idPerfil." and actor='".$arrAct[0]."' and tipoActor=".$arrAct[1]." and etapa=".$numEtapa;
			$nReg=$con->obtenerValor($query);
			if($nReg==0)
			{
				$consulta[$x]="INSERT INTO 662_actoresEtapaNomina(actor,etapa,tipoActor,idPerfil) VALUES('".$arrAct[0]."',".$numEtapa.",".$arrAct[1].",".$idPerfil.")";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function removerActorNomina($idActor="")
	{
		global $con;
		$idActorEtapa=-1;
		if($idActor=="")
			$idActorEtapa=$_POST["idActorEtapa"];
		else
			$idActorEtapa=$idActor;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 662_actoresEtapaNomina where idActorEtapaNomina=".$idActorEtapa;
		$x++;
		$consulta[$x]="delete from 662_accionesActorEtapaNomina where idActorEtapa=".$idActorEtapa;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($idActor=="")
			eB($consulta);
		else
		{
			return $con->ejecutarBloque($consulta);
		}
	}
	
	function removerEtapaNomina()
	{
		global $con;
		$noEtapa=$_POST["noEtapa"];
		$idPerfil=$_POST["idPerfil"];
		$consulta="SELECT * FROM 662_actoresEtapaNomina WHERE idPerfil=".$idPerfil." AND etapa=".$noEtapa;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			if(!removerActorNomina($fila[0]))
				return;
		}
		$consulta="delete from 662_etapasNomina WHERE noEtapa=".$noEtapa." AND idPerfil=".$idPerfil;
		eC($consulta);
		
		
	}
	
	function cambiarSituacionNomina()
	{
		$idNomina=$_POST["idNomina"];
		$nEtapa=$_POST["nEtapa"];
		$comentarios=isset($_POST["comentarios"])?$_POST["comentarios"]:"";
		
		
		
		if(cambiarEtapaNomina($idNomina,$nEtapa,$comentarios))
		{
			echo "1|";
		}
	}
	
	function obtenerInstitucionesAmbitoAccion()
	{
		global $con;
		$iA=$_POST["idAccion"];
		$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion in(1,11) ORDER BY unidad";
		$res=$con->obtenerFilas($consulta);
		$cadInstituciones="";
		$numReg=0;
		$consulta="SELECT configuracion FROM 662_accionesActorEtapaNomina WHERE idAccionNomina=".$iA;
		$configuracion=$con->obtenerValor($consulta);
		$objConf=NULL;
		if($configuracion!="")
			$objConf=json_decode($configuracion);
		$arrInstituciones=array();
		if(isset($objConf->arrInstituciones))
			$arrInstituciones=explode(",",$objConf->arrInstituciones);
		while($fila=mysql_fetch_row($res))
		{
			$existe="false";
			if(sizeof($arrInstituciones>0))
			{
				foreach($arrInstituciones as $i)
				{
					if($i==$fila[0])
					{
						$existe="true";
						break;
					}
				}
			}
			$obj='{"codigoInstitucion":"'.$fila[0].'","institucion":"'.cv($fila[1]).'","aplicaAccion":'.$existe.'}';
			if($cadInstituciones=="")
				$cadInstituciones=$obj;
			else
				$cadInstituciones.=",".$obj;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$cadInstituciones.']}';
	}
	
	function guardarAmbitoAccion()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$conf="";
		$cadInstituciones="";
		$x=0;
		$query[$x]="begin";
		$x++;
		$consulta="SELECT configuracion FROM 662_accionesActorEtapaNomina WHERE idAccionNomina=".$obj->idActor;
		$configuracion=$con->obtenerValor($consulta);
		if($configuracion=="")
			$configuracion='{"arrInstituciones":"'.$obj->instituciones.'"}';
		else
		{
			
			$configuracion=setAtributoCadJson($configuracion,"arrInstituciones",$obj->instituciones);
		}
		$configuracion=setAtributoCadJson($configuracion,"ambitoAccion",$obj->idAccion);
		
		if(isset($obj->etapaCambio))
		{
			$configuracion=setAtributoCadJson($configuracion,"etapaCambio",$obj->etapaCambio);
		}
		
		$query[$x]="update 662_accionesActorEtapaNomina set configuracion='".$configuracion."'  WHERE idAccionNomina=".$obj->idActor;
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function guardarOpcionesDictamenNomina()
	{
		global $con;
		$objOpciones=$_POST["objOpciones"];
		$idAccion=$_POST["idAccion"];
		$obj=json_decode($objOpciones);
		$x=0;
		$query[$x]="begin";
		$x++;
		$cadOpciones="";

		foreach($obj->opciones as $o)
		{
			$cadColumnas="";
			foreach($o->columnas as $c)
			{
				$cAux='{"idLeng":"'.$c->idLeng.'","texto":"'.cv($c->texto).'"}';
				if($cadColumnas=="")
					$cadColumnas=$cAux;
				else
					$cadColumnas.=",".$cAux;
			}
			$obj='{"vOpcion":"'.cv($o->vOpcion).'","columna":['.$cadColumnas.'],"etapa":"'.$o->etapa.'","funcionEjecucion":"'.$o->funcionEjecucion.'"}';
			if($cadOpciones=="")
				$cadOpciones=$obj;
			else
				$cadOpciones.=",".$obj;
		}
		$consulta="SELECT configuracion FROM 662_accionesActorEtapaNomina WHERE idAccionNomina=".$idAccion;
		$configuracion=$con->obtenerValor($consulta);
		if($configuracion=="")
			$configuracion='{"arrOpciones":"'.bE($cadOpciones).'"}';
		else
		{
			
			$configuracion=setAtributoCadJson($configuracion,"arrOpciones",bE($cadOpciones));
		}
		$query[$x]="update 662_accionesActorEtapaNomina set configuracion='".$configuracion."'  WHERE idAccionNomina=".$idAccion;
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function obtenerOpcionesDictamen()
	{
		global $con;
		$idAccion=$_POST["idAccion"];
		$consulta="SELECT configuracion FROM 662_accionesActorEtapaNomina WHERE idAccionNomina=".$idAccion;
		$configuracion=$con->obtenerValor($consulta);
		$arrOpciones="";
		if($configuracion!="")
		{
			$obj=json_decode($configuracion);
			if(isset($obj->arrOpciones))
			{
				$cadOpciones=bD($obj->arrOpciones);
				$cadAux='{"opciones":['.$cadOpciones.']}';
				$objAux=json_decode($cadAux);
				foreach($objAux->opciones as $o)
				{
					$oCad="['".$o->vOpcion."'";
					foreach($o->columna as $c)
					{
						$oCad.=",'".$c->texto."'";
					}
					$funcionEjecucion="0";
					if(isset($o->funcionEjecucion))
						$funcionEjecucion=$o->funcionEjecucion;
					if($funcionEjecucion=="")
						$funcionEjecucion=0;
					$oCad.=",'".$o->etapa."','".$funcionEjecucion."']";
					if($arrOpciones=="")
						$arrOpciones=$oCad;
					else
						$arrOpciones.=",".$oCad;
				}
			}
		}
		
		echo "1|[".$arrOpciones."]";
	}
	
	function obtenerNominasEjecutadas()
	{
		global $con;
		global $referenciaFiltros;
		
		$esNominaPorEmpresa=false;
		if(isset($_POST["esNominaPorEmpresa"]))
			$esNominaPorEmpresa=true;
		$ciclo=$_POST["ciclo"];
		$idPerfil=0;
		if(isset($_POST["idPerfil"]))
			$idPerfil=$_POST["idPerfil"];
		$arrPermisos=array();
		$arrPermisosCreados=array();
		$arrPlantelesVe=array();
		
		
		$consulta="SELECT idActorEtapaNomina,etapa,idPerfil FROM 662_actoresEtapaNomina WHERE actor IN (".$_SESSION["idRol"].")";

		$resA=$con->obtenerFilas($consulta);
		$cadPermiso="";
		$cadPlantelesVeNomina="";
		$cadPlantelesVisualiza=array();
		while($filaA=mysql_fetch_row($resA))
		{
			if(!isset($arrPermisos[$filaA[2]]))	
				$arrPermisos[$filaA[2]][($filaA[1]*1)]=array();
				
			$consulta="SELECT configuracion,accion FROM 662_accionesActorEtapaNomina WHERE idActorEtapa=".$filaA[0];	
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$configuracion=$fila[0];
				if($configuracion!="")
				{
					$plantel="";
					$obj=json_decode($configuracion);
					if(isset($obj->ambitoAccion))
					{
						switch($obj->ambitoAccion)
						{
							case 1://Nóminas generadas por el usuario
								$arrPermisosCreados[$filaA[2]][($filaA[1]*1)]=1;
							break;
							case 2://Nóminas pertenecientes a la institución del usuario
								$plantel=$_SESSION["codigoInstitucion"];
							break;
							case 3://Nóminas pertenecientes a la institución y subinstituciones del usuario
								$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion in(1,11) AND codigoUnidad LIKE '".$_SESSION["codigoInstitucion"]."%'";
								$plantel=$con->obtenerListaValores($consulta);
							break;
							case 4://Nóminas pertenecientes a instituciones especificadas
								if(sizeof($obj->arrInstituciones)>0)
								{
									foreach($obj->arrInstituciones as $i)
									{
										if($plantel=="")
											$plantel=$i;
										else
											$plantel.=",".$i;
									}
								}
							break;
							case 5://Todas las nóminas
								$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion in(1,11)";
								$plantel=$con->obtenerListaValores($consulta);
								
								
							break;
							/*case 7://Pertenecientes al centro de costo del usuario
							
								$consulta="SELECT distinct centroCosto FROM _1011_tablaDinamica WHERE id__1011_tablaDinamica IN (SELECT idReferencia FROM _1011_gridUsuarios WHERE usuario=".$_SESSION["idUsr"].")";
								$listCC=$con->obtenerListaValores($consulta);
								if($listCC=="")
									$listCC=-1;
								$plantel=$listCC;
								
								
								
							break;*/
							
						}

						if($plantel!="")
						{
							$arrPlanteles=explode(",",$plantel);

							foreach($arrPlanteles as $p)
							{
								if(!isset($arrPermisos[$filaA[2]][($filaA[1]*1)][$p]))
									$arrPermisos[$filaA[2]][($filaA[1]*1)][$p]="";
								
								switch($fila[1])	
								{
									case 1: //Ver nóminas
										$arrPlantelesVe[$filaA[2]][($filaA[1]*1)][$p]="";
										$cadPlantelesVisualiza[$p]=1;
									break;
									case 2:  //Calcular/recalcular nómina
										$arrPlantelesVe[$filaA[2]][($filaA[1]*1)][$p]="";
										if(strpos($arrPermisos[$filaA[2]][($filaA[1]*1)][$p],"G")===false)
											$arrPermisos[$filaA[2]][($filaA[1]*1)][$p].="G";
									break;
									case 3:	//Dictaminar nómina
										$arrPlantelesVe[$filaA[2]][($filaA[1]*1)][$p]="";
									break;
									case 4:	//Eliminar nómina
										$arrPlantelesVe[$filaA[2]][($filaA[1]*1)][$p]="";
										if(strpos($arrPermisos[$filaA[2]][($filaA[1]*1)][$p],"E")===false)
											$arrPermisos[$filaA[2]][($filaA[1]*1)][$p].="E";
									break;
									case 6:	//Modifica configuracion
										$arrPlantelesVe[$filaA[2]][($filaA[1]*1)][$p]="";
										if(strpos($arrPermisos[$filaA[2]][($filaA[1]*1)][$p],"M")===false)
											$arrPermisos[$filaA[2]][($filaA[1]*1)][$p].="M";
									break;
									case 7:	//Modifica Fecha de pago
										$arrPlantelesVe[$filaA[2]][($filaA[1]*1)][$p]="";
										if(strpos($arrPermisos[$filaA[2]][($filaA[1]*1)][$p],"P")===false)
											$arrPermisos[$filaA[2]][($filaA[1]*1)][$p].="P";
									break;
									
								}
							}
							
						}
					}
				}
			}
		}
		
		$condPerfil="";
		if($idPerfil!="0")
			$condPerfil=" and n.idPerfil=".$idPerfil;
		
		$consulta="SELECT idNomina,p.idPerfilesNomina,DATE_FORMAT(fechaInicioIncidencias,'%d/%m/%Y') AS fechaInicioIncidencias,DATE_FORMAT(fechaFinIncidencias,'%d/%m/%Y') AS fechaFinIncidencias,
				DATE_FORMAT(fechaEstimadaPago,'%d/%m/%Y') AS fechaEstimadaPago,IF(fechaPago IS NULL,'',DATE_FORMAT(fechaPago,'%d/%m/%Y')) AS fechaPago,etapa,n.descripcion,ambitoAplicacion,
				configuracion,p.idPerfilesNomina,folioNomina,quincenaAplicacion,institucion,idUsuarioCreacion,fechaUltimaEjecucion,fechaInicioFalta,fechaCorteAsistencia,n.idCentroCosto,idFormaPago,
				idPerfilImportacion,idArchivoImportacion,tipoEjecucionNomina FROM 672_nominasEjecutadas n,662_perfilesNomina p WHERE ciclo=".$ciclo.$condPerfil." and  p.idPerfilesNomina=n.idPerfil order by CAST(quincenaAplicacion AS UNSIGNED)  desc,folioNomina desc";
		
		$arrNominas="";
		$resNom=$con->obtenerFilas($consulta);
		$numReg=0;

		while($fNom=mysql_fetch_row($resNom))
		{
			$idReferenciaVisualizacion=$fNom[13];//18 Centro de costo
			//$idReferenciaVisualizacion=$fNom[18];
			if((isset($arrPlantelesVe[$fNom[10]][$fNom[6]][$idReferenciaVisualizacion]))||((isset($arrPermisosCreados[$fNom[10]][$fNom[6]]))&&($fNom[14]==$_SESSION["idUsr"])))
			{
				$lblUltimaEjecucion="No ha sido ejecutado";
				if($fNom[15]!="")
				{
					$lblUltimaEjecucion=date("d/m/Y H:i",strtotime($fNom[15]));
					$lblUltimaEjecucion.=" por ".obtenerNombreUsuarioPaterno($fNom[14]);
				}
				$permisos="";
				if(isset($arrPermisos[$fNom[10]][$fNom[6]][$idReferenciaVisualizacion]))
					$permisos=$arrPermisos[$fNom[10]][$fNom[6]][$idReferenciaVisualizacion];
				
				$consulta="SELECT nombreEtapa FROM 662_etapasNomina WHERE idPerfil=".$fNom[10]." AND noEtapa=".$fNom[6];
				$descEtapa=$con->obtenerValor($consulta);
				$descripcion=$fNom[7];
				if($descripcion=="")
					$descripcion="N/E";
				$tblAplica="<br><br><table>";
				if($fNom[8]==1)
				{
					$tblAplica="<tr heigth=\"21\"><td width=\"110\"></td><td><span class=\"copyrigthSinPaddingNegro\">Toda la instituci&oacute;n</span></td></tr>";	
				}
				else
				{
					$cadObj='{"arreglo":'.str_replace("'","\"",$fNom[9])."}";	
				
					$obj=json_decode($cadObj);

					foreach($obj->arreglo as $e)
					{
						$comp="";
						if(isset($e[2]))
						{
							$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$e[2];
							$nCalculo=$con->obtenerValor($consulta);
							$comp='<td width="5"></td><td width="180"><b>Combinado con c&aacute;lculo:</b></td><td width="200">'.$nCalculo.'</td>';	
						}
						if($e[0]>0)
						{
							switch($e[0])
							{
								case 2:
									$consulta="select unidad from 817_organigrama where codigoUnidad='".$e[1]."'";
									$depto=$con->obtenerValor($consulta);
									$tblAplica.="<tr height=\"21\"><td width=\"110\"><b>Depto/&Aacute;rea:</b></td><td width='180'>".$depto."</td>".$comp."</tr>";
								break;
								case 3:
									$consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica where idUsuario='".$e[1]."'";
									$nombre=$con->obtenerValor($consulta);
									$tblAplica.="<tr height=\"21\"><td width=\"110\"><b>Empleado:</b></td><td width='180'>".$nombre."</td>".$comp."</tr>";
								break;
								case 4:
									$consulta="select puesto from 819_puestosOrganigrama where cvePuesto='".$e[1]."'";
									$puesto=$con->obtenerValor($consulta);
									$tblAplica.="<tr height=\"21\"><td width=\"110\"><b>Puesto:</b></td><td width='180'>".$puesto."</td>".$comp."</tr>";
								break;
								case 5:
									$consulta="select txtTipoContratacion from _669_tablaDinamica where id__669_tablaDinamica='".$e[1]."'";
									$tContratacion=$con->obtenerValor($consulta);
									$tblAplica.="<tr height=\"21\"><td width=\"110\"><b>Tipo contrataci&oacute;n:</b></td><td width='180'>".$tContratacion."</td>".$comp."</tr>";
								break;	
								case 6:
									$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta='".$e[1]."'";
									$criterio=$con->obtenerValor($consulta);
									$tblAplica.="<tr height=\"21\"><td width=\"150\"><b>Criterio de b&uacute;squeda:</b></td><td width='180'>".$criterio."</td>".$comp."</tr>";
								break;	
								case 7:
									$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$e[1]."'";
									$criterio=$con->obtenerValor($consulta);
									$tblAplica.="<tr height=\"21\"><td width=\"150\"><b>Instituci&oacute;n:</b></td><td width='180'>".$criterio."</td>".$comp."</tr>";
								break;	
								case 10:
									$consulta="SELECT IF(e.tipoEmpresa=1,CONCAT('[',cveEmpresa,'] ',e.razonSocial,' ',e.apPaterno,' ',e.apMaterno),concat('[',cveEmpresa,'] ',e.razonSocial)) AS nombreEmpresa
												  FROM 6927_empresas e WHERE idEmpresa='".$e[1]."'";
									
									$criterio=$con->obtenerValor($consulta);
									$tblAplica.="<tr height=\"21\"><td width=\"150\"><b>Empresa:</b></td><td width='180'>".$criterio."</td>".$comp."</tr>";
								break;	
								case 11:
									$consulta="SELECT centroCosto  FROM 722_centrosCostos e WHERE idCentroCosto='".$e[1]."'";

									$criterio=$con->obtenerValor($consulta);
									$tblAplica.="<tr height=\"21\"><td width=\"150\"><b>Centro de Costo:</b></td><td width='180'>".$criterio."</td>".$comp."</tr>";
								break;	
							}	
						}
						else
						{
							$idEntidad=$e[0]*-1;
							$consulta="select nombreEntidadNomina,permiteSeleccionUnidades,idFuncionOrigenDatos from 679_entidadesAgrupadorasNomina where idEntidadNomina='".$idEntidad."'";
							$fEntidad=$con->obtenerPrimeraFila($consulta);
							$nEntidad=$fEntidad[0];
							$permiteSeleccionUnidades=$fEntidad[1];
							$entidad="Todas las unidades";
							if($e[1]!="0")
							{
								$arrElementos=array();
								$cadObj='{"idNomina":"-1"}';
								$obj=json_decode($cadObj);
								$cache=NULL;
								$arrElementos=resolverExpresionCalculoPHP($fEntidad[1],$obj,$cache);
								
								$cadArrElementos="";
								if(sizeof($arrElementos)>0)
								{
									foreach($arrElementos as $e)
									{
										if($e["codigoUnidad"]==$e[1])
											$entidad=cv($e["tituloUnidad"]);
									}
								}
							}
							$tblAplica.="<tr height=\"21\"><td width=\"230\"><b>".$nEntidad."<br>[Entidad Agrupadora]</b></td><td width='180'>".$entidad."</td>".$comp."</tr>";
						}
					}
					
				}
				$tblAplica."</table>";
				$descripcion='<table><tr height="21"><td width="80" align="left"><span class="corpo8_bold"><b>Descripci&oacute;n:</b></span></td><td width="400" align="left"><span class="copyrigthSinPaddingNegro">'.
				$descripcion.'</td></tr>
							<tr height="21"><td width="80" align="left"><span class="corpo8_bold"><b>&Uacute;ltima ejecución:</b></span></td><td width="400" align="left"><span class="copyrigthSinPaddingNegro">'.$lblUltimaEjecucion.'</span></td></tr>
							<tr height="21"><td><span class="corpo8_bold"><b>Aplicado a:</b></span></td><td><span class="copyrigthSinPaddingNegro">'.$tblAplica.'</span></td></tr>
								
							</table>';
				//$obj="['".$fNom[0]."','".$fNom[1]."','".$fNom[2]."','".$fNom[3]."','".$fNom[4]."','".$fNom[5]."','".$fNom[6]."','".$descripcion."','".$descEtapa."','".cv($fNom[7])."','".$fNom[11]."','".$fNom[12]."']";
				$ultimaEjecucion="";
				if($fNom[15]!="")
				{
					$ultimaEjecucion=date("d/m/Y H:i",strtotime($fNom[15]));
				}
				

				$consulta="SELECT nombreElemento,noOrdinal FROM _642_gElementosPeriodicidad e,662_perfilesNomina p WHERE e.idReferencia=p.idPeriodicidad and idPerfilesNomina=".$fNom[10]." and noOrdinal=".$fNom[12]." ORDER BY noOrdinal";
				$fPeriodo=$con->obtenerPrimeraFila($consulta);
				$periodo=$fPeriodo[1];
				$lblQuincena=$fPeriodo[0];
				
				$centroCosto="";
				if(($fNom[18]!="")&&($fNom[18]!="-1"))
				{
					$consulta="SELECT centroCosto FROM 722_centrosCostos WHERE idCentroCosto=".$fNom[18];
					$centroCosto=$con->obtenerValor($consulta);	
				}
				$archivoImportacion="";
				if(($fNom[21]!="")&&($fNom[21]!="-1"))
				{
					$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$fNom[21];
					$archivoImportacion=$con->obtenerValor($consulta);
					$consulta="select concat(nombrePerfil,' [',f.formatoImportacion,']') from 662_perfilesImportacionNomina pImp,720_perfilesImportacion p,721_formatosImportacion f 
								WHERE idPerfilImportacionNomina=".$fNom[20]." AND pImp.idPerfilImportacion=p.idPerfilConfiguracion AND f.idFormato=p.formatoImportacion ORDER BY nombrePerfil";

					$archivoImportacion.=" (".$con->obtenerValor($consulta).")";
				}
				
				$admiteImportacion=0;
				
				
				$consulta="SELECT COUNT(*) FROM 662_perfilesImportacionNomina WHERE idPerfilNomina=".$fNom[1];
				$admiteImportacion=$con->obtenerValor($consulta);
				
				$obj=	'{"archivoImportacion":"'.cv($archivoImportacion).'","idArchivoImportacion":"'.$fNom[21].'","admiteImportacion":"'.$admiteImportacion.
						'","metodoPago":"'.$fNom[19].'","centroCosto":"'.cv($centroCosto).'","plantel":"'.$fNom[13].'","fInicioFalta":"'.$fNom[16].'","fFinFalta":"'.
						$fNom[17].'","idNomina":"'.$fNom[0].'","nomina":"'.cv($fNom[1]).'","fInicioInc":"'.$fNom[2].'","fFinInc":"'.$fNom[3].'","fEstPago":"'.$fNom[4].'","fPago":"'.$fNom[5].'","etapa":"'.$fNom[6]
						.'","descripcion":"'.cv($descripcion).'","descEtapa":"'.cv($descEtapa).'","descripcionNomina":"'.cv($fNom[7]).'","folio":"'.$fNom[11].'","quincena":"'.$periodo.'","lblQuincena":"'.$lblQuincena.'","permisos":"'.$permisos.'",
						"fechaUltimaEjecucion":"'.$ultimaEjecucion.'","tipoEjecucionNomina":"'.$fNom[22].'"}';
				
				if($arrNominas=="")	
					$arrNominas=$obj;
				else
					$arrNominas.=",".$obj;
				$numReg++;
			}
		}
		$cadVisualiza="";
		foreach($cadPlantelesVisualiza as $p=>$v)
		{
			if($cadVisualiza=="")
				$cadVisualiza="'".$p."'";
			else
				$cadVisualiza.=",'".$p."'";
				
		}
		$arrNominas='{"numReg":"'.$numReg.'","registros":['.$arrNominas.'],"plantelesVisualiza":"'.$cadVisualiza.'"}';
		echo $arrNominas;
	}
	
	function obtenerHistorialNomina()
	{
		global $con;
		$idNomina=$_POST["idNomina"];
		$consulta="SELECT idHistorialNomina,fechaCambioEtapa,etapaAnterior,etapaActual AS etapaCambio,(select concat(Paterno,' ',Materno,' ',Nom) from 802_identifica where idUsuario=idResponsableCambio) AS  responsableCambio,comentarios 
					FROM 676_historialNomina WHERE idNomina=".$idNomina." ORDER BY fechaCambioEtapa desc";
		$arrObjetos=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObjetos).'}';
	}
	
	function obtenerFechaInicioFalta()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$nQuincena=$_POST["quincena"];
		$ciclo=$_POST["ciclo"];
		/*$consulta="SELECT max(fechaCorteAsistencia) FROM 672_nominasEjecutadas WHERE ciclo=".$ciclo." AND CAST(quincenaAplicacion AS SIGNED)=".($nQuincena-1)." AND idPerfil=".$idPerfil;
		$fechaInicioFalta=$con->obtenerValor($consulta);
		$fechaFinFalta="";
		if($fechaInicioFalta!="")
		{
			$fechaInicioFalta=strtotime($fechaInicioFalta);
			$fechaInicioFalta=strtotime("+1 days",$fechaInicioFalta);
			$fechaInicioFalta=date("Y-m-d",$fechaInicioFalta);
		}
		else
		{
			
			
			
			
			
			
		}*/
		
		/*$consulta="SELECT max(fechaFinIncidencias) FROM 672_nominasEjecutadas WHERE ciclo=".$ciclo." AND CAST(quincenaAplicacion AS SIGNED)=".($nQuincena-1)." AND idPerfil=".$idPerfil;
		$fechaInicioIncidencia=$con->obtenerValor($consulta);
		$fechaFinIncidencia="";
		
		if($fechaInicioIncidencia!="")
		{
			$fechaInicioIncidencia=strtotime($fechaInicioIncidencia);
			$fechaInicioIncidencia=strtotime("+1 days",$fechaInicioIncidencia);
			$fechaInicioIncidencia=date("Y-m-d",$fechaInicioIncidencia);
		}
		else
		{
			
		}*/
		
		$fechaInicioIncidencia="";
		$fechaInicioFalta="";
		$consulta="SELECT idPeriodicidad FROM 662_perfilesNomina WHERE idPerfilesNomina=".$idPerfil;
		$fPerfilNomina=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT noOrdinal,nombreElemento,mes,diaInicio FROM _642_gElementosPeriodicidad WHERE idReferencia=".
					$fPerfilNomina["idPeriodicidad"]." and noOrdinal=".$nQuincena;
		$fPeriodicidad=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$fechaInicioIncidencia=$ciclo."-".str_pad($fPeriodicidad["mes"],2,"0",STR_PAD_LEFT)."-".str_pad($fPeriodicidad["diaInicio"],2,"0",STR_PAD_LEFT);
		
		$consulta="SELECT * FROM _642_gElementosPeriodicidad WHERE idReferencia=".$fPerfilNomina["idPeriodicidad"].
				" AND noOrdinal>".$fPeriodicidad["noOrdinal"]." ORDER BY noOrdinal";
			
		$fPeriodo=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if(!$fPeriodo)
		{
			$consulta="SELECT * FROM _642_gElementosPeriodicidad WHERE idReferencia=".$fPerfilNomina["idPeriodicidad"]." ORDER BY noOrdinal";
			$fPeriodo=$con->obtenerPrimeraFilaAsoc($consulta);
			$ciclo++;
		
		}
		
		$fechaFinIncidencia=$ciclo."-".str_pad($fPeriodo["mes"],2,"0",STR_PAD_LEFT)."-".str_pad($fPeriodo["diaInicio"],2,"0",STR_PAD_LEFT);
		
		$fechaInicioFalta=$fechaInicioIncidencia;
		$fechaFinIncidencia=date("Y-m-d",strtotime("-1 days",strtotime($fechaFinIncidencia)));
		$fechaFinFalta=$fechaFinIncidencia;
		
		$objCadIncidencias='{"fechaInicioIncidencia":"'.$fechaInicioIncidencia.'","fechaFinIncidencia":"'.$fechaFinIncidencia.
							'","fechaInicioFalta":"'.$fechaInicioFalta.'","fechaFinFalta":"'.$fechaFinFalta.'"}';
		echo "1|".$objCadIncidencias;
		
	}
	
	function obtenerPeriodosPerfilNomina()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT idPeriodicidad,considerarAsistencia FROM 662_perfilesNomina WHERE idPerfilesNomina=".$idPerfil;
		$fPerfilNomina=$con->obtenerPrimeraFila($consulta);
		$idPeriodicidad=$fPerfilNomina[0];
		$considerarAsistencia=$fPerfilNomina[1];
		$arrPeriodo="";
		$consulta="SELECT noOrdinal,nombreElemento,mes,diaInicio FROM _642_gElementosPeriodicidad WHERE idReferencia=".$idPeriodicidad." ORDER BY noOrdinal";
		$res=$con->obtenerFilas($consulta);
		$posRes=0;
		while($fila=mysql_fetch_row($res))
		{
			$posRes++;
			$fechaInicio="";
			$fechaInicioSig="";
			if(($fila[2]!="")&&($fila[3]!=""))
			{
				$fechaInicio=$ciclo."-".str_pad($fila[2],2,"0",STR_PAD_LEFT)."-".str_pad($fila[3],2,"0",STR_PAD_LEFT);
			}
			
			$fSig=mysql_fetch_row($res);
			$posRes++;
			if($fSig)
			{
				
				if(($fSig[2]!="")&&($fSig[3]!=""))
				{
					$fechaInicioSig=$ciclo."-".str_pad($fSig[2],2,"0",STR_PAD_LEFT)."-".str_pad($fSig[3],2,"0",STR_PAD_LEFT);
					$fechaInicioSig=date("Y-m-d",strtotime("-1 days",strtotime($fechaInicioSig)));
				}
				mysql_data_seek($res,($posRes-1));
				$posRes--;
			}
			
			$obj="['".$fila[0]."','".$fila[1]."','".$fechaInicio."','".$fechaInicioSig."']";
			if($arrPeriodo=="")
				$arrPeriodo=$obj;
			else
				$arrPeriodo.=",".$obj;
		}
		echo "1|[".$arrPeriodo."]|".$considerarAsistencia;
		
	}
	
	function generarFuncionAccionNomina()
	{
		global $con;
		$accion=$_POST["accion"];
		$idPerfil=$_POST["idPerfil"];
		$lblAccion="";
		if($accion==1)
			$lblAccion="Recálculo";
		else
			$lblAccion="Eliminación";
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 991_consultasSql(nombreConsulta,situacion,tipoConsulta,eliminable,valorRetorno,comp1,idTipoConcepto,ambitoAplicacion,arrEstructuras)
					VALUES('Disparador de ".$lblAccion." de nómina: ".$idPerfil."',1,-11,1,'int','".$idPerfil."',-15,0,'[]')";
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		$consulta[$x]="INSERT INTO 993_parametrosConsulta(parametro,idConsulta) VALUES('idNomina',@idRegistro)";
		$x++;
		if($accion==1)
			$consulta[$x]="UPDATE 662_perfilesNomina SET idFuncionRecalculo=@idRegistro WHERE idPerfilesNomina=".$idPerfil;
		else
			$consulta[$x]="UPDATE 662_perfilesNomina SET idFuncionEliminacion=@idRegistro WHERE idPerfilesNomina=".$idPerfil;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$consulta="select @idRegistro";
			$idFuncion=$con->obtenerValor($consulta);
			echo "1|".$idFuncion;
		}
		
	}
	
	function obtenerEntidadesPerfilAgrupador()
	{
		global $con;
		$tipoElemento=$_POST["tipoElemento"];
		$consulta="SELECT idFuncionOrigenDatos FROM 679_entidadesAgrupadorasNomina WHERE idEntidadNomina=".$tipoElemento;
		$idFuncionSistema=$con->obtenerValor($consulta);
		$arrElementos=array();
		$cadObj='{"idNomina":"-1"}';
		$obj=json_decode($cadObj);
		$cache=NULL;
		$arrElementos=resolverExpresionCalculoPHP($idFuncionSistema,$obj,$cache);
		
		$cadArrElementos="";
		if(sizeof($arrElementos)>0)
		{
			foreach($arrElementos as $e)
			{
				$obj="['".cv($e["codigoUnidad"])."','".cv($e["tituloUnidad"])."']";
				if($cadArrElementos=="")
					$cadArrElementos=$obj;
				else
					$cadArrElementos.=",".$obj;
			}
		}
		echo "1|[".$cadArrElementos."]";
	}
	function obtenerNominasPlantel()
	{
		global $con;
		$plantel=$_POST["plantel"];
		$ciclo=$_POST["ciclo"];
//		$nomina="SELECT DISTINCT n.idNomina,CONCAT('[',n.folioNomina,'] ',n.descripcion,' (',n.fechaInicioIncidencias,' - ',
//					n.fechaFinIncidencias,')' ) AS periodoNomina FROM 672_nominasEjecutadas n,671_asientosCalculosNomina c 
//					WHERE n.idNomina=c.idNomina AND c.codDepartamento='".$plantel."' AND c.idCiclo='".$ciclo."' AND etapa<>'200' ORDER BY idNomina";
		$nomina="SELECT DISTINCT n.idNomina,CONCAT('[',n.folioNomina,'] ',n.descripcion,' (',DATE_FORMAT(n.fechaInicioIncidencias,'%d/%m/%Y'),
				' - ',DATE_FORMAT(n.fechaFinIncidencias,'%d/%m/%Y'),') faltas ( ',DATE_FORMAT(n.fechaInicioFalta,'%d/%m/%Y'),' - ',
				DATE_FORMAT(n.fechaCorteAsistencia,'%d/%m/%Y'),' )' ) AS periodoNomina FROM 672_nominasEjecutadas n,671_asientosCalculosNomina c 
				WHERE n.idNomina=c.idNomina AND c.codDepartamento='".$plantel."' AND c.idCiclo='".$ciclo."' AND etapa<>'200' ORDER BY idNomina";
		$arrReportes=$con->obtenerFilasArreglo($nomina);
		echo "1|".$arrReportes;
	}
	
	function asignarCategoriaCalculoNomina()
	{
		global $con;
		$tipoCampo=$_POST["tipoCampo"];
		$valor=$_POST["valor"];
		$idCalculo=$_POST["idCalculo"];
		$campo="";
		switch($tipoCampo)
		{
			case 1:
				$campo="categoriaCalculo";
			break;
			case 2:
			
				$campo="idFuncionGravamen";
			break;
			case 3:
			
				$campo="idEtiquetaAgrupadora";
			break;
			case 4:
			
				$campo="ambitoEtiqueta";
			break;
			case 5:
			
				$campo="tipoCalculo";
			break;
			case 6:
				$campo="etiquetaConcepto";
			break;
			case 7:
				$campo="cveCalculo";
			break;
			case 8:
				$campo="idCalculoAsociado";
			break;
			case 9:
				$campo="mostrarSiValorCero";
			break;
			case 10:
				$campo="incluirEnCache";
			break;
			case 11:
				$campo="calcularSiCalculoAsociadoIgualCero";
			break;
		}
		
		$consulta="UPDATE 662_calculosNomina SET ".$campo."='".cv($valor)."' WHERE idCalculo=".$idCalculo;
		eC($consulta);
	}
	
	function timbrarAsientoNomina()
	{
		global $con;
		$cT=new cFDIFinkok();
		$idAsiento=$_POST["idAsiento"];
		$c=new cNominaCFDI();
		$oNomina=generarXMLModuloNomina($idAsiento);
		$c->setObjNomina($oNomina);
		$XML=$c->generarXML();
		$idFactura=$c->registrarXML(1,$idAsiento);
		$c->generarSelloDigital();		
		
		$XML=$c->cargarComprobanteXML($idFactura);
		$resultado=$c->validarXMLNomina($XML);
		
		
		
		if($resultado["errores"])
		{
			$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=5,comentarios='".cv($resultado["arrErrores"])."' WHERE idFolio=".$idFactura;
			$con->ejecutarConsulta($consulta);
		}
		else
		{
			
			$cT->timbrarComprobante($idFactura);	
		}
		$consulta="SELECT situacion,comentarios FROM 703_relacionFoliosCFDI WHERE idFolio=".$idFactura;
		
		$fFolio=$con->obtenerPrimeraFila($consulta);

		
		echo "1|".$idFactura."|".$fFolio[0]."|".$fFolio[1];
	}
	
	function reintentarTimbrado()
	{
		global $con;
		$idAsiento=$_POST["idAsiento"];
		$cT=new cFDIFinkok();
		$consulta="SELECT idComprobante FROM 671_asientosCalculosNomina WHERE idAsientoNomina=".$idAsiento;
		$idComprobante=$con->obtenerValor($consulta);
		$c=new cNominaCFDI();
		$oNomina=generarXMLModuloNomina($idAsiento);
		$c->setObjNomina($oNomina);
		$XML=$c->generarXML();
		$c->actualizarXMLComprobante($idComprobante);
		$c->generarSelloDigital($idComprobante);
		
		$XML=$c->cargarComprobanteXML($idComprobante);
		$resultado=$c->validarXMLNomina($XML);
		if($resultado["errores"])
		{
			$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=5,comentarios='".cv($resultado["arrErrores"])."' WHERE idFolio=".$idFactura;
			$con->ejecutarConsulta($consulta);
		}
		else
		{
			
			$cT->timbrarComprobante($idFactura);	
		}
		
		$consulta="SELECT situacion,comentarios FROM 703_relacionFoliosCFDI WHERE idFolio=".$idComprobante;
		$fFolio=$con->obtenerPrimeraFila($consulta);
		echo "1|".$idFactura."|".$fFolio[0]."|".$fFolio[1];
	}	
	
	function registrarEtiquetaAgrupacion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idEtiqueta==-1)
			$consulta="INSERT INTO 718_etiquetasAgrupadoras(clave,etiqueta,idPerfilNomina,idCategoria,idCategoriaSAT) VALUES('".cv($obj->clave)."','".cv($obj->etiqueta)."',".$obj->idPerfil.",".$obj->idCategoria.",".$obj->idCategoriaSAT.")";
		else
			$consulta="update 718_etiquetasAgrupadoras set clave='".cv($obj->clave)."',etiqueta='".cv($obj->etiqueta)."',idCategoria=".$obj->idCategoria.",idCategoriaSAT=".$obj->idCategoriaSAT." where idEtiquetaAgrupadora=".$obj->idEtiqueta;
		
		eC($consulta);
	}

	function obtenerEtiquetasAgrupacion()
	{
		global $con;
		$idPerfilNomina=$_POST["idPerfil"];
		$consulta="SELECT idEtiquetaAgrupadora as idEtiqueta,clave,etiqueta,idCategoria,idCategoriaSAT FROM 718_etiquetasAgrupadoras WHERE idPerfilNomina=".$idPerfilNomina." ORDER BY etiqueta";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function removerEtiquetaAgrupacion()
	{
		global $con;
		$idEtiqueta=$_POST["idEtiqueta"];
		$consulta="DELETE FROM 718_etiquetasAgrupadoras WHERE idEtiquetaAgrupadora=".$idEtiqueta;
		eC($consulta);
	}
	
	function obtenerInstitucionesAsignacionPerfil()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$registros="";
		$numReg=0;
		$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE (institucion=1 || institucion=11) ORDER BY unidad";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$aplica="";
			$consulta="SELECT COUNT(*) FROM 662_perfilesNominaInstitucion WHERE idPerfilNomina=".$idPerfil." AND institucion='".$fila[0]."'";
			$nReg=$con->obtenerValor($consulta);
			$aplica="false";
			if($nReg>0)
				$aplica="true";
			$obj='{"codigoInstitucion":"'.$fila[0].'","institucion":"'.cv($fila[1]).'","aplica":'.$aplica.'}';
			$numReg++;
			if($registros=="")
				$registros=$obj;
			else
				$registros.=",".$obj;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$registros.']}'	;
	}
	
	function registrarPerfilInstitucion()
	{
		global $con;	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 662_perfilesNominaInstitucion WHERE idPerfilNomina=".$obj->idPerfil;
		$x++;
		$arrInstituciones=explode(",",$obj->arrInstituciones);
		foreach($arrInstituciones as $i)
		{
			$consulta[$x]="INSERT INTO 662_perfilesNominaInstitucion(idPerfilNomina,institucion) VALUES(".$obj->idPerfil.",'".$i."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function generarXMLAsientoNomina()
	{
		global $con;
		$cT=new cFDIFinkok();
		$idAsiento=$_POST["idAsiento"];
		$c=new cNominaCFDI();
		$oNomina=generarXMLModuloNomina($idAsiento);
		
		
		$c->setObjNomina($oNomina);

		$XML=$c->generarXML();

		$idFactura=$c->registrarXML(1,$idAsiento);

		$c->generarSelloDigital();
		
		
		$XML=$c->cargarComprobanteXML($idFactura);

		$resultado=$c->validarXMLNomina($XML);
		if($resultado["errores"])
		{
			$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=5,comentarios='".cv($resultado["arrErrores"])."' WHERE idFolio=".$idFactura;
			$con->ejecutarConsulta($consulta);
		}
		
		
		
		
		$consulta="SELECT situacion,comentarios FROM 703_relacionFoliosCFDI WHERE idFolio=".$idFactura;
		
		$fFolio=$con->obtenerPrimeraFila($consulta);

		
		echo "1|".$idFactura."|".$fFolio[0]."|".$fFolio[1];
	}
	
	function timbrarXMLAsientoNomina()
	{
		global $con;
		$idAsiento=$_POST["idAsiento"];
		$cT=new cFDIFinkok();
		$consulta="SELECT idComprobante FROM 671_asientosCalculosNomina WHERE idAsientoNomina=".$idAsiento;
		$idFactura=$con->obtenerValor($consulta);
		$cT->timbrarComprobante($idFactura);	
		$consulta="SELECT situacion,comentarios FROM 703_relacionFoliosCFDI WHERE idFolio=".$idFactura;
		$fFolio=$con->obtenerPrimeraFila($consulta);
		echo "1|".$idFactura."|".$fFolio[0]."|".$fFolio[1];
		
	}
	
	function recrearXMLAsientoNomina()
	{
		global $con;
		$idAsiento=$_POST["idAsiento"];

		$consulta="SELECT idComprobante,idNomina,cvePuesto,tipoContratacion,idUsuario FROM 671_asientosCalculosNomina WHERE idAsientoNomina=".$idAsiento;
		$fDatosAsiento=$con->obtenerPrimeraFila($consulta);
		$idComprobante=$fDatosAsiento[0];
		$idNomina=$fDatosAsiento[1];
		
		$consulta="SELECT tipoNomina FROM 672_nominasEjecutadas WHERE idNomina=".$idNomina;
		$tipoNomina=$con->obtenerValor($consulta);		
		
		$c=new cNominaCFDI();
		$oNomina=generarXMLModuloNomina($idAsiento);
		
		$c->setObjNomina($oNomina);
		$XML=$c->generarXML();
		//$c->actualizarXMLComprobante($idComprobante);
		$idFactura=$c->registrarXML(1,$idAsiento);
		$c->generarSelloDigital($idFactura);

		$XML=$c->cargarComprobanteXML($idFactura);
		
		$resultado=$c->validarXMLNomina($XML);
		
		if($resultado["errores"])
		{
			$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=5,comentarios='".cv($resultado["arrErrores"])."' WHERE idFolio=".$idFactura;			
			$con->ejecutarConsulta($consulta);
		}
		else
		{
			$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=1,comentarios='' WHERE idFolio=".$idFactura;			
			$con->ejecutarConsulta($consulta);	
			if(($fDatosAsiento[2]=="")||($fDatosAsiento[2]=="-1")||($fDatosAsiento[3]=="")||($fDatosAsiento[3]=="-1"))
			{
				switch($tipoNomina)
				{
					case 2:
						$consulta="SELECT regimenContratacion as regimen,idPuesto FROM 693_empleadosNominaV2 WHERE idEmpleado=".$fDatosAsiento[4];
					break;
					default: 
						$consulta="SELECT tipoContratacion,cod_Puesto FROM 801_adscripcion WHERE idUsuario=".$fDatosAsiento[4];
					break;
				}
				
				$fDatosAdscripcion=$con->obtenerPrimeraFila($consulta);
				if($fDatosAdscripcion[0]=="")
					$fDatosAdscripcion[0]="NULL";
				
				$consulta="UPDATE 671_asientosCalculosNomina SET cvePuesto='".$fDatosAdscripcion[1]."',tipoContratacion=".$fDatosAdscripcion[0]." WHERE idAsientoNomina=".$idAsiento;			
				$con->ejecutarConsulta($consulta);	
				$fDatosAsiento[2]=$fDatosAdscripcion[1];
				$fDatosAsiento[3]=$fDatosAdscripcion[0];
			}
			
			
		}
		$consulta="SELECT situacion,comentarios FROM 703_relacionFoliosCFDI WHERE idFolio=".$idFactura;
		$fFolio=$con->obtenerPrimeraFila($consulta);
		echo "1|".$idFactura."|".$fFolio[0]."|".$fFolio[1]."|".$fDatosAsiento[2]."|".$fDatosAsiento[3];
	}
	
	function cancelarTimbreAsientoNomina()
	{
		global $con;
		$idAsiento=$_POST["idAsiento"];
		$cT=new cFDIFinkok();
		$consulta="SELECT idComprobante FROM 671_asientosCalculosNomina WHERE idAsientoNomina=".$idAsiento;
		$idFactura=$con->obtenerValor($consulta);
		$cT->cancelarComprobante($idFactura,"");	
		$consulta="SELECT situacion,comentarios FROM 703_relacionFoliosCFDI WHERE idFolio=".$idFactura;
		$fFolio=$con->obtenerPrimeraFila($consulta);
		echo "1|".$idFactura."|".$fFolio[0]."|";
		
	}
	
	function modificarConfiguracionNomina()
	{
		global $con;
		$campo=bD($_POST["c"]);
		$valor=bD($_POST["v"]);
		$idNomina=bD($_POST["i"]);
		$consulta="UPDATE 672_nominasEjecutadas SET ".$campo."='".cv($valor)."' WHERE idNomina=".$idNomina;
		eC($consulta);
		
	}
	
	function actualizarValorCampoNominaAsiento()
	{
		global $con;	
		$idAsiento=$_POST["idAsiento"];
		$valor=$_POST["valor"];
		$campo=$_POST["campo"];
		
		
		switch($campo)
		{
			case 1:
				$campo="fechaPago";
			break;
			case 2:
				$campo="ignorarTimbrado";
			break;	
			case 3:
				$campo="tipoPago";
			break;	
		}
		
		$consulta="UPDATE 671_asientosCalculosNomina SET ".$campo."='".$valor."' WHERE idAsientoNomina=".$idAsiento;
		eC($consulta);	
	}
	
	function obtenerPerfilesImportacionDisponibles()
	{
		global $con;
		$idPerfilNomina=$_POST["idPerfilNomina"];
		$consulta="SELECT idPerfilImportacion FROM 662_perfilesImportacionNomina WHERE  idPerfilNomina=".$idPerfilNomina;
		$listaPerfiles=$con->obtenerListaValores($consulta);
		if($listaPerfiles=="")
			$listaPerfiles=-1;
		$consulta="SELECT idPerfilConfiguracion as idPerfil,nombrePerfil,descripcion,formatoImportacion FROM 720_perfilesImportacion WHERE idPerfilConfiguracion NOT IN (".$listaPerfiles.")";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
			
	}
	
	function registrarPerfilesImportacionPerfilNomina()
	{
		global $con;	
		$idPerfilNomina=$_POST["idPerfilNomina"];
		$listaPerfiles=$_POST["listaPerfiles"];
		$arrPerfiles=explode(",",$listaPerfiles);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrPerfiles as $p)
		{
			$consulta[$x]="INSERT INTO 662_perfilesImportacionNomina(idPerfilNomina,idPerfilImportacion,columnaEmpleado,considerarSoloEmpleadosImportados) VALUES(".$idPerfilNomina.",".$p.",1,1)";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
		
	}
	
	function obtenerPerfilesImportacionPerfilNomina()
	{
		global $con;	
		$idPerfil=$_POST["idPerfil"];
		$consulta="SELECT idPerfilImportacionNomina AS idPerfilImportacion,nombrePerfil,formatoImportacion AS tipoArchivo,descripcion,p.columnaEmpleado,p.considerarSoloEmpleadosImportados  
				FROM 662_perfilesImportacionNomina p,720_perfilesImportacion i WHERE p.idPerfilNomina=".$idPerfil." AND i.idPerfilConfiguracion=p.idPerfilImportacion 
				ORDER BY nombrePerfil";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	function removerPerfilPerfilNomina()
	{
		global $con;
		
		$idPerfil=$_POST["idPerfil"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 662_perfilesImportacionNomina WHERE idPerfilImportacionNomina=".$idPerfil;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerConfiguracionPerfilImportacion()
	{
		global $con;
		$idPerfilImportacion=$_POST["idPerfilImportacion"];
		$idPerfil=$_POST["idPerfil"];
		if($idPerfilImportacion==-1)
		{
			echo '{"numReg":"0","registros":[]}';
		}
		else
		{
			$consulta="SELECT orden,tipoCalculo,c.nombreConsulta,IF((etiquetaConcepto IS NULL OR etiquetaConcepto=''),c.nombreConsulta,etiquetaConcepto) AS etiquetaConcepto,n.idCalculo,
						(SELECT idColumnaAsociada FROM 662_configuracionPerfilImportacion WHERE idPerfilImportacion=".$idPerfilImportacion." AND idCalculoNomina=n.idCalculo) AS idColumna 
						FROM 662_calculosNomina n,991_consultasSql c WHERE idPerfil=".$idPerfil." AND c.idConsulta=n.idConsulta ORDER BY orden";
			$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
			echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		}
		
		
	}
	
	function modificarConfiguracionPerfilImportacion()
	{
		global $con;
		$idPerfilImportacion=$_POST["idPerfilImportacion"];
		$idCalculo=$_POST["idCalculo"];
		$idColumna=$_POST["idColumna"];
		$consulta="";
		if($idColumna=="")
		{
			$consulta="delete FROM 662_configuracionPerfilImportacion WHERE idPerfilImportacion=".$idPerfilImportacion." AND idCalculoNomina=".$idCalculo;
		}
		else
		{
			$consulta="SELECT idConfiguracion FROM 662_configuracionPerfilImportacion WHERE idPerfilImportacion=".$idPerfilImportacion." AND idCalculoNomina=".$idCalculo;
			$idConfiguracion=$con->obtenerValor($consulta);
			if($idConfiguracion=="")
			{
				$consulta="INSERT INTO 662_configuracionPerfilImportacion(idPerfilImportacion,idCalculoNomina,idColumnaAsociada) VALUES(".$idPerfilImportacion.",".$idCalculo.",".$idColumna.")";
			}
			else
			{
				$consulta="update 662_configuracionPerfilImportacion set idColumnaAsociada=".$idColumna." where idConfiguracion=".$idConfiguracion;
			}
		}
		eC($consulta);
		
		
	}
	
	function actualizarConfiguracionPerfilImportacion()
	{
		global $con;	
		$idPerfilImportacion=$_POST["idPerfilImportacion"];
		$tipoAccion=$_POST["tipoAccion"];
		$valor=$_POST["valor"];
		$campo="";
		switch($tipoAccion)
		{
			case 1:
				$campo="columnaEmpleado";
			break;	
			case 2:
				$campo="considerarSoloEmpleadosImportados";
			break;	
		}
		
		$consulta="UPDATE 662_perfilesImportacionNomina SET ".$campo."=".$valor." WHERE idPerfilImportacionNomina=".$idPerfilImportacion;
		eC($consulta);
		
	}
	
	function obtenerPerfilesImportacionPerfilNominaSelect()
	{
		global $con;	
		$idNomina=$_POST["iN"];
		$consulta="SELECT idPerfil FROM 672_nominasEjecutadas where idNomina=".$idNomina;
		
		$idPerfilNomina=$con->obtenerValor($consulta);
		$consulta="SELECT idPerfilImportacionNomina,concat(nombrePerfil,' [',f.formatoImportacion,']'),extensionesValidas FROM 662_perfilesImportacionNomina pImp,720_perfilesImportacion p,721_formatosImportacion f 
					WHERE pImp.idPerfilNomina=".$idPerfilNomina." AND pImp.idPerfilImportacion=p.idPerfilConfiguracion AND f.idFormato=p.formatoImportacion ORDER BY nombrePerfil";
		$aPerfiles=$con->obtenerFilasArreglo($consulta);
		echo "1|".$aPerfiles;
	}
	
	function actualizarArchivoImportacionNomina()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="select idArchivoImportacion from 672_nominasEjecutadas where idNomina=".$obj->idNomina;
		$idArchivoImportacion=$con->obtenerValor($consulta);
		
		
		if(($idArchivoImportacion!="")&&($idArchivoImportacion!="-1"))
		{
			removerDocumentoServidor($idArchivoImportacion);
			$consulta="UPDATE 672_nominasEjecutadas SET idArchivoImportacion=NULL WHERE idNomina=".$obj->idNomina;
			$con->ejecutarConsulta($consulta);
		}
		
		
		$idArchivoImportacion=registrarDocumentoServidor($obj->idArchivo,$obj->nombreArchivo);			
		$consulta="UPDATE 672_nominasEjecutadas SET idArchivoImportacion=".$idArchivoImportacion." WHERE idNomina=".$obj->idNomina;
		$con->ejecutarConsulta($consulta);
		
		
		echo "1|".$idArchivoImportacion;
		
		
		
		
	}
	
	function removerArchivoImportacionPerfilNomina()
	{
		global $con;
		$idNomina=$_POST["iN"];
		$consulta="select idArchivoImportacion from 672_nominasEjecutadas where idNomina=".$idNomina;
		$idArchivoImportacion=$con->obtenerValor($consulta);
		if(($idArchivoImportacion!="")&&($idArchivoImportacion!="-1"))
		{
			removerDocumentoServidor($idArchivoImportacion);
			$consulta="UPDATE 672_nominasEjecutadas SET idArchivoImportacion=NULL WHERE idNomina=".$idNomina;
			$con->ejecutarConsulta($consulta);
		}
		echo "1|";
			
	}
	
	function verificarNotificacionesNomina()
	{
		global $con;
		$idNomina=$_POST["idNomina"];
		
		$consulta="SELECT fechaOperacion,notificacion FROM 672_notificacionesNomina WHERE idNomina=".$idNomina." AND situacion=1 ORDER BY fechaOperacion";
		$arrNotificaciones=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".$arrNotificaciones;
		
		
		
	}
	
	
	function obtenerEmpleadosNomina()
	{
		global $con;
		
		
		$arrRegistros="";
		$arrUsuariosInv=array();
		$idNomina=$_POST["idNomina"];		
		
		$consulta="SELECT configuracion,fechaPago,idFormaPago FROM 672_nominasEjecutadas WHERE idNomina=".$idNomina;
		$fNomina=$con->obtenerPrimeraFilaAsoc($consulta);
		$configuracion=$con->obtenerValor($consulta);
		
		if($configuracion=="[]")
		{
			$consulta="SELECT idUsuario FROM 801_adscripcion WHERE cod_Puesto IS NOT NULL";	
			$resE=$con->obtenerFilas($consulta);
			while($fE=mysql_fetch_row($resE))
			{
				array_push($arrUsuariosInv,$fE[0]);
			}
		}
		else
		{
		
			$cadObj='{"arreglo":'.str_replace("'","\"",$configuracion)."}";	
			$obj=json_decode($cadObj);
			
			foreach($obj->arreglo as $e)
			{
				switch($e[0])
				{
					case 2: //institucion
						if(isset($e[2])&&($e[2]!=0))
						{
							$obj=json_decode('{"param1":"'.$e[1].'","param2":"'.$filaNomina[0].'"}');
							$cache=NULL;
							$arrUsr=array();
							$listUsr=resolverExpresionCalculoPHP($e[2],$obj,$cache);
							if(gettype($listUsr)!="array")
							{
								if($listUsr!=-1)
								{
									$listUsr=str_replace("'","",$listUsr);
									$arrUsrTmp=explode(",",$listUsr);
									foreach($arrUsrTmp as $u)
									{
										$objU[0]=$u["idUsuario"];
										$objU[1]=0;
										$objU[2]="";
										array_push($arrUsr,$objU);	
									}
									
								}
							}
							else
							{
								if(sizeof($listUsr)>0)
								{
									foreach($listUsr as $u)
									{
										$objU[0]=$u["idUsuario"];
										$objU[1]=$u["distintor"];
										$objU[2]=$u["etDistintor"];
										array_push($arrUsr,$objU);	
									}
								}
							}
							if(sizeof($arrUsr)>0)
							{
								foreach($arrUsr as $oUsr)
								{
									array_push($arrUsuariosInv,$oUsr[0]);
								}
							}
						}
						else
						{
							
							$consulta="SELECT idUsuario FROM 801_adscripcion WHERE Institucion='".$e[1]."' AND cod_Puesto IS NOT NULL";	
							$resE=$con->obtenerFilas($consulta);
							while($fE=mysql_fetch_row($resE))
							{
								array_push($arrUsuariosInv,$fE[0]);
							}
						
							
						}
					break;
					case 3: //Empleado
						array_push($arrUsuariosInv,$e[1]);
						
					break;
					case 4:  //Puesto
						if(isset($e[2])&&($e[2]!=0))
						{
							$obj=json_decode('{"param1":"'.$e[1].'","param2":"'.$filaNomina[0].'"}');
							$cache=NULL;
							$arrUsr=array();
							$listUsr=resolverExpresionCalculoPHP($e[2],$obj,$cache);
							if(gettype($listUsr)!="array")
							{
								if($listUsr!=-1)
								{
									$listUsr=str_replace("'","",$listUsr);
									$arrUsrTmp=explode(",",$listUsr);
									foreach($arrUsrTmp as $u)
									{
										$objU[0]=$u["idUsuario"];
										$objU[1]=0;
										$objU[2]="";
										array_push($arrUsr,$objU);	
									}
									
								}
							}
							else
							{
								if(sizeof($listUsr)>0)
								{
									foreach($listUsr as $u)
									{
										$objU[0]=$u["idUsuario"];
										$objU[1]=$u["distintor"];
										$objU[2]=$u["etDistintor"];
										array_push($arrUsr,$objU);	
									}
								}
							}
							if(sizeof($arrUsr)>0)
							{
								foreach($arrUsr as $oUsr)
								{
									array_push($arrUsuariosInv,$oUsr[0]);
								}
							}
						}
						else
						{
							$consulta="select idUsuario from 801_adscripcion where cod_Puesto='".$e[1]."'";	
							$resE=$con->obtenerFilas($consulta);
							while($fE=mysql_fetch_row($resE))
							{
								array_push($arrUsuariosInv,$fE[0]);
							}
						}
					break;
					case 5:  //Tipo de contratacion
						if(isset($e[2])&&($e[2]!=0))
						{
							$obj=json_decode('{"param1":"'.$e[1].'","param2":"'.$filaNomina[0].'"}');
							$cache=NULL;
							$arrUsr=array();
							$listUsr=resolverExpresionCalculoPHP($e[2],$obj,$cache);
							if(gettype($listUsr)!="array")
							{
								if($listUsr!=-1)
								{
									$listUsr=str_replace("'","",$listUsr);
									$arrUsrTmp=explode(",",$listUsr);
									foreach($arrUsrTmp as $u)
									{
										$objU[0]=$u["idUsuario"];
										$objU[1]=0;
										$objU[2]="";
										array_push($arrUsr,$objU);	
									}
									
								}
							}
							else
							{
								if(sizeof($listUsr)>0)
								{
									foreach($listUsr as $u)
									{
										$objU[0]=$u["idUsuario"];
										$objU[1]=$u["distintor"];
										$objU[2]=$u["etDistintor"];
										array_push($arrUsr,$objU);	
									}
								}
							}
							if(sizeof($arrUsr)>0)
							{
								foreach($arrUsr as $oUsr)
								{
									array_push($arrUsuariosInv,$oUsr[0]);
								}
							}
						}
						else
						{
							$consulta="select idUsuario from 801_adscripcion where tipoContratacion='".$e[1]."'";	
							$resE=$con->obtenerFilas($consulta);
							while($fE=mysql_fetch_row($resE))
							{
								array_push($arrUsuariosInv,$oUsr[0]);
							}
						}
					break;	
				}	
			}
		}
		$numReg=0;
		$listaUsuarios=implode(",",$arrUsuariosInv);
		$tPercepciones=0;
		$tDeducciones=0;
		$sueldoNeto=0;
		
		$consulta="SELECT Nombre,cod_Puesto,idZona,tipoContratacion,a.Institucion,u.idUsuario FROM 801_adscripcion a,800_usuarios u WHERE u.idUsuario IN(".$listaUsuarios.")
				AND a.idUsuario=u.idUsuario";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$puesto=$fila["cod_Puesto"];
			$tipoPuesto=$fila["tipoContratacion"];
			$idAsientoNomina=-1;
			$fechaPago=$fNomina["fechaPago"];
			$ignorarTimbrado="false";
			$totalDeducciones="0";
			$totalPercepciones="0";
			$sueldoNeto=0;
			$situacion=0;
			$metodoPago=$fNomina["idFormaPago"];
			$identificador="";
			$descriptorIdentificador="";
			$idComprobante="";
			$situacionComprobante="7";
			$comentarios="";
			$ignorarCalculo="false";
			$consulta="SELECT COUNT(*) FROM 672_usuariosIgnoraCalculo WHERE idNomina=".$idNomina." AND idUsuario=".$fila["idUsuario"];
			$nUsuarios=$con->obtenerValor($consulta);
			if($nUsuarios>0)
			{
				$ignorarCalculo="true";
			}
			
			$consulta="SELECT * FROM 671_asientosCalculosNomina WHERE idUsuario=".$fila["idUsuario"]." AND idNomina=".$idNomina;
			$fAsientoNomina=$con->obtenerPrimeraFilaAsoc($consulta);
			if($fAsientoNomina)
			{
				$puesto=$fAsientoNomina["cvePuesto"];
				$tipoPuesto=$fila["tipoContratacion"];
				$idAsientoNomina=$fAsientoNomina["idAsientoNomina"];
				$fechaPago=$fAsientoNomina["fechaPago"];
				$ignorarTimbrado=$fAsientoNomina["ignorarTimbrado"];
				$totalDeducciones=$fAsientoNomina["totalDeducciones"];
				$totalPercepciones=$fAsientoNomina["totalPercepciones"];
				$sueldoNeto=$fAsientoNomina["sueldoNeto"];
				$situacion=$fAsientoNomina["situacion"];
				$metodoPago=$fAsientoNomina["tipoPago"];
				$identificador="";
				$descriptorIdentificador="";
				$idComprobante=$fAsientoNomina["idComprobante"];
				$situacionComprobante="";
				$comentarios=$fAsientoNomina["tipoPago"];
				
				if($idComprobante!="")
				{
					$consulta="SELECT situacion,comentarios FROM 703_relacionFoliosCFDI WHERE idFolio=".$idComprobante;
					$fSituacion=$con->obtenerPrimeraFila($consulta);
					$situacionComprobante=$fSituacion[0];
					$comentarios=$fSituacion[1];
				}
				else
				{
					$situacionComprobante=8;
										
				}
				
			}
			$o='{"puesto":"'.$puesto.'","tipoPuesto":"'.$tipoPuesto.'","titular":"'.cv($fila["Nombre"]).
				'","totalDeducciones":"'.$totalDeducciones.'","totalPercepciones":"'.$totalPercepciones.'","sueldoNeto":"'.$sueldoNeto.
				'","codigoDepto":"'.$fila["Institucion"].'","idUsuario":"'.$fila["idUsuario"].'","situacion":"'.$situacion.
				'","idAsientoNomina":"'.$idAsientoNomina.'","fechaPago":"'.$fechaPago.'","ignorarTimbrado":'.$ignorarTimbrado.',
				"metodoPago":"'.$metodoPago.'","identificador":"'.$identificador.'","descriptorIdentificador":"'.$descriptorIdentificador.
				'","idComprobante":"'.$idComprobante.'","situacionComprobante":"'.$situacionComprobante.
				'","comentarios":"'.cv($comentarios).'","idZona":"'.$fila["idZona"].'","ignorarCalculo":'.$ignorarCalculo.'}';
		
			$tPercepciones+=$totalPercepciones;
			$tDeducciones+=$totalDeducciones;
			
		
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		$sueldoNeto=$tPercepciones-$tDeducciones;
		$metaData='{"numReg":"'.$numReg.'","tPercepciones":"'.$tPercepciones.'","tDeducciones":"'.$tDeducciones.'","sueldoNeto":"'.$sueldoNeto.'"}';
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.'],"infoAdicional":'.$metaData.'}';
		
	}
	
	function modificarIgnorarGeneracionCalculo()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idNomina=$_POST["idNomina"];
		$valor=$_POST["valor"];
		$consulta="";
		if($valor==1)
		{
			
			$consulta="INSERT INTO 672_usuariosIgnoraCalculo(idNomina,idUsuario) VALUES(".$idNomina.",".$idUsuario.")";
		}
		
		else
		{
			$consulta="DELETE FROM 672_usuariosIgnoraCalculo WHERE idNomina=".$idNomina." AND idUsuario=".$idUsuario;
		}
		eC($consulta);
		
	}
	
	
	function calcularNominaIndividual()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$objAux=json_decode($cadObj);
		if($objAux->noRegistroProcesados==1)
			unset($_SESSION["nominasEjecutadas"][$objAux->idNomina]);
		$removerCacheNomina=false;
		
		$objResNomina=calcularNominaUsuarioIndividualV2($objAux);
		//varDump($objResNomina);
		$objResultado='{"noCalculado":"1"}';
		if($objResNomina)
		{
			$objResultado='{"totalPercepciones":"'.$objResNomina->totalPercepciones.'","totalDeducciones":"'.$objResNomina->totalDeducciones.
							'","sueldoNeto":"'.$objResNomina->sueldoNeto.'","idAsientoNomina":"'.$objResNomina->idAsientoNomina.'"}';
			
		}
		
		if($objAux->noRegistroProcesados==$objAux->totalProceso)
		{
			unset($_SESSION["nominasEjecutadas"][$objAux->idNomina]);
		}
		echo "1|".$objResultado;
	}
	
	
	function registrarClasificadorCalculo()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$nClasificador=$_POST["nClasificador"];
		
		$consulta="INSERT INTO 667_clasificadoresNomina(idPerfil,nombreClasificador) VALUES(".$idPerfil.",'".cv($nClasificador)."')";
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT idRegistro,nombreClasificador FROM 667_clasificadoresNomina WHERE idPerfil=".$idPerfil." ORDER BY nombreClasificador";
			$arrClasificadores=$con->obtenerFilasArreglo($consulta);
			echo "1|".$arrClasificadores;
		}
	}
	
	function removerClasificadorCalculo()
	{
		global $con;
		$idClasificador=$_POST["idClasificador"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 667_clasificadoresNomina WHERE idRegistro=".$idClasificador;
		$x++;
		$consulta[$x]="DELETE FROM 668_clasificacionCalculosNomina WHERE idClasificador=".$idClasificador;
		$x++;
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			$consulta="SELECT idRegistro,nombreClasificador FROM 667_clasificadoresNomina WHERE idPerfil=".$idPerfil." ORDER BY nombreClasificador";
			$arrClasificadores=$con->obtenerFilasArreglo($consulta);
			echo "1|".$arrClasificadores;
		}
		
	}
	
	function agregarClasificadorCalculo()
	{
		global $con;
		$iCalculo=$_POST["iCalculo"];
		$idClasificadores=$_POST["idClasificadores"];
		$arrClasificadores=explode(",",$idClasificadores);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		foreach($arrClasificadores as $c)
		{
			$query="SELECT COUNT(*) FROM 668_clasificacionCalculosNomina WHERE idCalculo=".$iCalculo." AND idClasificador=".$c;
			$numReg=$con->obtenerValor($query);
			if($numReg==0)
			{
				$consulta[$x]="INSERT INTO 668_clasificacionCalculosNomina(idCalculo,idClasificador) VALUES(".$iCalculo.",".$c.")";
				$x++;
			}
		
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function quitarClasificadorCalculo()
	{
		global $con;
		$iRegistro=$_POST["iRegistro"];
		$consulta="DELETE FROM 668_clasificacionCalculosNomina WHERE idRegistro=".$iRegistro;
		eC($consulta);
	}
	
	function obtenerDetalleCalculo()
	{
		global $con;
		$tipo=$_POST["tipo"];
		$idAsiento=$_POST["idAsiento"];
		$tipoCalculo="";
		switch($tipo)
		{
			case "P":
				$tipoCalculo="2";
			break;
			case "D":
				$tipoCalculo="1";
			break;
			case "T":
				$tipoCalculo="1,2";
			break;
		}
		
		
		$consulta="SELECT idResultadoCalculo AS idCalculo,cveConcepto AS cveCalculo,nombreCalculo,valorCalculado as montoCalculado,r.tipoCalculo
				FROM 671_resultadosCalculosAsientoNomina r,662_calculosNomina c WHERE idAsientoNomina=".$idAsiento." AND r.tipoCalculo in(".$tipoCalculo.
				") and c.idCalculo=r.idAlineacionCalculo and (valorCalculado>0 or ( valorCalculado=0 and c.mostrarSiValorCero=1)) ORDER BY r.orden";
				
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';				
				
		
	}
		
	function registrarFiltroAplicacionCalculo()
	{
		global $con;
		$iC=$_POST["iC"];
		$iE=$_POST["iE"];
		$tE=$_POST["tE"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrElementos=explode(",",$iE);

		foreach($arrElementos as $e)
		{
			$query="SELECT COUNT(*) FROM 669_filtroAplicacionCalculosNomina WHERE idCalculo=".$iC." AND tipoElemento=".$tE." AND idElemento=".$e;
			$numReg=$con->obtenerValor($query);
			if($numReg==0)
			{
				$consulta[$x]="INSERT INTO 669_filtroAplicacionCalculosNomina(idCalculo,tipoElemento,idElemento) values(".$iC.",".$tE.",".$e.")";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$idFormularioCatPuestos=obtenerIDFormularioCategoria("CP");
			$idFormularioCatTiposContratacion=obtenerIDFormularioCategoria("TC");
			$idFormularioCatClasificacionPuestos=obtenerIDFormularioCategoria("CLP");
			$cadAplicacionPuestos='<table width="100%">
						  <tr height=\'21\'>
							  <td align="right">
								  	  <a href="javascript:agregarFiltroAfectacionCalculo(\''.bE($iC).'\')"><img src="../images/user_add.png" title=\'Agregar Filtro de Aplicaci&oacute;n\' alt=\'Agregar Filtro de Aplicaci&oacute;n\'/></a>
							  </td>
						  </tr>
						  <tr height="1">
							  <td style="background-color:#FF3">
							  </td>
						  </tr>
						  ';
			
			$consulta="SELECT idElemento,idRegistro,tipoElemento FROM 669_filtroAplicacionCalculosNomina WHERE idCalculo=".$iC." ORDER BY tipoElemento";
			$resTipoElemento=$con->obtenerFilas($consulta);
			while($filaElemento=mysql_fetch_row($resTipoElemento))
			{
				$lblElemento="";
				switch($filaElemento[2])
				{
					case 1: //Tipo de Contratación
						$consulta="SELECT tipoContratacion FROM _".$idFormularioCatTiposContratacion."_tablaDinamica where id__".$idFormularioCatTiposContratacion."_tablaDinamica=".$filaElemento[0];
						$lblElemento=$con->obtenerValor($consulta);
						$lblElemento.=" (Tipo de Contrataci&oacute;n)";
					
					break;
					case 2: //Clasificación del Puesto
						$consulta="SELECT nomPuesto FROM _".$idFormularioCatClasificacionPuestos."_tablaDinamica where id__".$idFormularioCatClasificacionPuestos."_tablaDinamica=".$filaElemento[0];
						$lblElemento=$con->obtenerValor($consulta);
						$lblElemento.=" (Clasificaci&oacute;n del Puesto)";
					break;
					case 3:	//Puesto
						$consulta="SELECT nomPuesto FROM _".$idFormularioCatPuestos."_tablaDinamica where id__".$idFormularioCatPuestos."_tablaDinamica=".$filaElemento[0];
						$lblElemento=$con->nombrePuesto($consulta);
						$lblElemento.=" (Puesto)";
					break;
				}
				$cadAplicacionPuestos.='<tr id="filaFiltro_'.$iC.'"><td><a href="javascript:removerFiltro(\''.bE($iC).'\')"><img src="../images/delete.png" width="14" height="14"></a>&nbsp;&nbsp;'.$lblElemento.'</td></tr>';
			}
			$cadAplicacionPuestos.='</table>';
			echo "1|".$cadAplicacionPuestos;
		}
		
	}
	
	function removerFiltroAplicacionCalculo()
	{
		global $con;
		$iR=$_POST["iR"];
		$consulta="DELETE FROM 669_filtroAplicacionCalculosNomina WHERE idRegistro=".$iR;
		eC($consulta);
	}
	
	function removerQuincenaAplicacionCalculo()
	{
		global $con;
		$iR=$_POST["iR"];
		$consulta="DELETE FROM 670_quincenasAplicacionCalculosNomina WHERE idRegistro=".$iR;
		eC($consulta);
	}
	
	
?>