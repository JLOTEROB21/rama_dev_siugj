<?php
	session_start();
	header("charset=utf-8");
	include("centrogeo/conexionBD.php"); 
	include("centrogeo/configurarIdioma.php");
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
				obtenerRegistrosTblFormularios();
			break;
			case 2:
				cambiarOrden();
			break;
			case 3:
				cambiarCampoOrden();
			break;
			case 4:
				cambiarNumRegistrosPaginas();
			break;
			case 5:
				cambiarAgrupacion();
			break;
		}
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
		$consulta="select nombreTabla,idFrmEntidad from 900_formularios where idFormulario=".$idFormulario;
		$fila=$con->obtenerPrimeraFila($consulta);
		$tablaFormulario=$fila[0];
		$condFiltro="";
		$filtroUsuario="";
		$consulta="select idFiltro from 915_confGridVSRol where idConfGrid=".$idConfiguracion." and idRol in(".$_SESSION["idRol"].")";
		$idFiltro=$con->obtenerValor($consulta);
		if($idFiltro=="")
			$idFiltro="-1";
		$consulta="select tokenMysql from 917_consultasFiltroGrid where idFiltro=".$idFiltro;
		$res=$con->obtenerFilas($consulta);
		$consultaConf="";
		while($fila=mysql_fetch_row($res))
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
				//Valores directos de tabla
			$consulta="	select e.nombreCampo,e.idGrupoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where tipoElemento not in(-1,0,1,2,4,14,16) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";
			$camposAux="id_".$tablaFormulario." as idRegistro,".$con->obtenerListaValores($consulta,"`");
			//valor de contenidos en otras tablas
			$consulta="	select e.nombreCampo,e.idGrupoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where (tipoElemento=4 or tipoElemento=16) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";
			$res=$con->obtenerFilas($consulta);
			$camposRefTablas="";
			while($filas=mysql_fetch_row($res))
			{
				$queryConf="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[1];
				$filaConf=$con->obtenerPrimeraFila($queryConf);
				$tablaD=$filaConf[2];
				$campoP=$filaConf[3];
				$campoId=$filaConf[4];
				$consultaRefTablas="(select tc.".$campoP." from ".$tablaD." tc where tc.".$campoId."=".$tablaFormulario.".".$filas[0].")";
				$camposRefTablas.=",".$consultaRefTablas." as `".$filas[0]."`";
			}
			//valor de opciones ingresadas por el usuario manualmente
			$consulta="	select e.nombreCampo,e.idGrupoElemento from 901_elementosFormulario e,907_camposGrid cg 
						where (tipoElemento=2 or tipoElemento=14) and cg.idElementoFormulario=e.idGrupoElemento and cg.idConfGrid=".$idConfiguracion." order by idGrupoCampo";
			$res=$con->obtenerFilas($consulta);
			$camposRefOpciones="";
			while($filas=mysql_fetch_row($res))
			{
				$consultaRefTablas="(select contenido from 902_opcionesFormulario where idIdioma=".$_SESSION["leng"]." and idGrupoElemento=".$filas[1]." and valor=".$tablaFormulario.".".$filas[0]." )";
				$camposRefOpciones.=",".$consultaRefTablas." as `".$filas[0]."`";
			}
			//valores de variables de sistema
			
			$consulta="select campoUsr
						 as nombreCampo
						 ,cg.idElementoFormulario
						 from 907_camposGrid cg,9017_camposControlFormulario cc where cc.tipoElemento=cg.idElementoFormulario where
						 cg.idIdioma=".$_SESSION["leng"]." and cg.idElementoFormulario<0 and cg.idConfGrid=".$idConfiguracion;
			$res=$con->obtenerFilas($consulta);	
			$camposRefSistema="";
			while($filas=mysql_fetch_row($res))
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
				}
				$camposRefSistema.=",".$consultaRefSistema." as `".$filas[0]."`";
			}
			
			$condWhere=" where 1=1 ";
			
			if(($idReferencia!="")&&($idReferencia!='-1'))
				$condWhere.=" and idReferencia=".$idReferencia;

			if($idEstado!="-1")
				$condWhere.=" and idEstado=".$idEstado;
			
			$orden=" order by ".$_POST["sort"]." ".$_POST["dir"];
			
			
			$consulta2="select * from (select ".$camposAux.$camposRefTablas.$camposRefOpciones.$camposRefSistema." from ".$tablaFormulario." ".$condWhere." ".$consultaConf." ".$condFiltro.") as vQuery ".$filtroUsuario;
			//echo $consulta2;
			if($posMax>=0)
			{
				$consulta="select * from (select ".$camposAux.$camposRefTablas.$camposRefOpciones.$camposRefSistema." from ".$tablaFormulario." ".$condWhere." ".$consultaConf." ".$condFiltro." ".$orden.") as vQuery ".$filtroUsuario." limit ".$posMin.",".$posMax;
				$consulta=str_replace(',,',',',$consulta);
			}
			else
				$consulta=$consulta2;
				
			$consulta2=str_replace(',,',',',$consulta2);
			$numElementos=$con->contarRegistros($consulta2);
			
			$datos=$con->obtenerFilasArreglo($consulta);
			echo $consulta;
			
			$json=$con->obtenerFilasJson($consulta);
			
			$arrJson='{"numReg":'.$numElementos.',registros:'.uEJ($json).'}';		
		}
		else
		{
			$arrJson='{"numReg":"0",registros:[]}';					
		}
		echo $arrJson;
	}
		
	function formatearFiltro($filtro)
	{
		$campo="`".$filtro["field"]."`";
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
		switch($campo)
		{
			case '`responsableCreacion`':
				$campo="`responsable`";
			break;
			case '`fechaModificacion`':
				$campo="`fechaModif`";
			break;
			case '`responsableModificacion`':
				$campo="`respModif`";
			break;
			case '`unidadUsuarioRegistro`':
				$campo="`codigoUnidad`";
			break;
			case '`institucionUsuarioRegistro`':
				$campo="`codigoInstitucion`";
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
?>