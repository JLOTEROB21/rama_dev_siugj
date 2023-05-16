<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include("funcionesClonacionReportesThot.php");
	include_once("conectoresAccesoDatos/administradorConexiones.php");
	
	
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
				guardarReporte();
			break;
			case 2:
				guardarElementoReporte();
			break;
			case 3:
				actualizarPosicionElemento();
			break;
			case 4:
				actualizarControl();
			break;
			case 5:
				eliminarElementoReporte();
			break;
			case 6:
				actualizarTamanoGrid();
			break;
			case 7:
				obtenerDataSets();
			break;
			case 8:
				obtenerCamposTabla();
			break;
			case 9:
				guardarPregunta();
			break;
			case 10:
				guardarParametroReporte();
			break;
			case 11:
				eliminarParametro();
			break;
			case  12:
				eliminarAlmacenDatos();
			break;
			case 13:
				vincularSeccionAlmacen();
			break;
			case 14:
				obtenerDataSetsElemento();
			break;
			case 15:
				agregarCamposSeccion();
			break;
			case 16:
				guadarParametrosDataSet();
			break;
			case 17:
				obtenerCamposTablaComp();
			break;
			case 18:
				actualizarCamposProy();
			break;
			case 19:
				removerCamposProy();
			break;
			case 20:
				modificarPregunta();
			break;
			case 21:
				modificarNombreAlmacen();
			break;
			case 22:	
				obtenerTablasVinculadas();
			break;
			case 23:
				vincularTablaAlmacen();
			break;
			case 24:
				removerTablaAlmacen();
			break;
			case 25:
				obtenerParametrosPendientes();
			break;
			case 26:
				obtenerReportesDisponibleMapa();
			break;
			case 27:
				obtenerParametrosReporte();
			break;
			case 28:
				guardarVinculacionReporte();
			break;
			case 29:
				removerVinculacionReporte();
			break;
			case 30:
				modificarValorParametro();
			break;
			case 31:
				eliminarReporte();
			break;
			case 32:
				obtenerCategoriaAlmacenGrafico();
			break;
			case 33:
				eliminarCategoriaAlmacenGrafico();
			break;
			case 34:
				crearAlmacenGrafico();
			break;
			case 35:
				obtenerConfiguracionOrigenDatos();
			break;
			case 36:
				guardarCategoriaGrafico();
			break;
			case 37:
				obtenerSerieAlmacenGrafico();
			break;
			case 38:
				eliminarSerieAlmacenGrafico();
			break;
			case 39:
				guardarSerieGrafico();
			break;
			case 40:
				guardarOrigenDatoGrafico();
			break;
			case 41:
				obtenerSedesEstado();
			break;
			case 42:
				obtenerSedesEstadoV2();
			break;
			case 43:
				obtenerEstadosV2();
			break;
			case 44:
				obtenerSeccionesCuestionario();
			break;
			case 45:
				guardarCuestionario();
			break;
			case 46:
				guardarElementoCuestionario();
			break;
			case 47:
				removerElementoCuestionario();
			break;
			case 48:
				guardarRespuestaCuestionario();
			break;
			case 49:
				actualizarSituacionRevisores();
			break;
			case 50:
				obtenerCamposTablaSistema();
			break;
			case 51:
				obtenerOpcionesCampoTabla();
			break;
			case 52:
				obtenerValoresTablaSistema();
			break;
			case 53:

				obtenerEstilosSistema();
			break;
			case 54:
				removerEstilo();
			break;
			case 56:
				guardarPropiedadesGrafico();
			break;
			case 57:
				obtenerRespuestaPreguntasCuestionario();
			break;
			case 100:
				clonarReporte();
			break;
			
		}
	}
	
	function guardarReporte()
	{
		global $con;
		$idReporte=$_POST["idReporte"];
		$titulo=$_POST["titulo"];
		$descripcion=$_POST["descripcion"];
		if($idReporte=="-1")
			$consulta="insert 9010_reportesThot (nombreReporte,descripcion,fechaCreacion,idUsuarioResponsable) 
						values('".cv($titulo)."','".cv($descripcion)."','".date('Y-m-d')."',".$_SESSION["idUsr"].")";
		else
			$consulta="update 9010_reportesThot set nombreReporte='".cv($titulo)."',descripcion='".cv($descripcion)."' where idReporte=".$idReporte;
		if($con->ejecutarConsulta($consulta))
		{
			if($idReporte=='-1')
				$idReporte=$con->obtenerUltimoID();
			echo "1|".$idReporte;
					
		}
	}
	
	function guardarElementoReporte()
	{
		global $mostrarXML;
		$mostrarXML=false;
		$res=crearControlVistaElemento($_POST["datosP"]);
		echo $res;
	}
	
	function actualizarPosicionElemento()
	{
		global $con;
		$param=$_POST["param"];
		$obj=json_decode($param);
		$posX=$obj->posX;
		$posY=$obj->posY;
		$idElemento=$obj->idElemento;
		$consulta="update 9011_elementosReportesThot set posX=".$posX.",posY=".$posY." where idGrupoElemento=".$idElemento;
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="select idGrupoElemento,posX,posY from 9011_elementosReportesThot where  idPadre=".$idElemento;
			$arrHijos=$con->obtenerFilasArreglo($consulta);
			echo "1|".$arrHijos;
		}
		else
			echo "|";
	}
	
	function actualizarControl()
	{
		global $con;
		$comp="";
		
		$accion=$_POST["accion"];
		$idControl=$_POST["idControl"];
		$valor=$_POST["valor"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="select nombreCampo,tipoElemento from 9011_elementosReportesThot where idGrupoElemento=".$idControl;
		$fValor=$con->obtenerPrimeraFila($query);
		$viejoValor=$fValor[0];
		$tipoElemento=$fValor[1];
		
		switch($accion)
		{
			case 1: //nombre
				
				if($tipoElemento!=31)
				{
					$consulta[$x]="update 9011_elementosReportesThot set nombreCampo='".$valor."' where idGrupoElemento=".$idControl;
					$x++;
				}
				else
				{
					$cadObj="";
					$query="select campoConf7 from 9012_configuracionElemReporteThot WHERE idElemReporte=".$idControl;
					$cadConf=$con->obtenerValor($query);
					if($cadConf=="")
						$cadObj='{"caption":"'.cv($valor).'"}';
					else
						$cadObj=setAtributoCadJson($cadConf,"caption",cv($valor));
					$consulta[$x]="update 9011_elementosReportesThot set nombreCampo='' where idGrupoElemento=".$idControl;
					$x++;
					$consulta[$x]="update 9012_configuracionElemReporteThot SET campoConf7='".cv($cadObj)."' WHERE idElemReporte=".$idControl;
					$x++;
					$comp="|".bE($cadObj);
				}
				
				
			break;
			case 2: //etiqueta
				$idIdioma=$_POST["idIdioma"];
				$consulta[$x]="update 9011_elementosReportesThot set nombreCampo='".$valor."' where idIdioma=".$idIdioma." and idGrupoElemento=".$idControl;
				$x++;
			break;
			case 4: //ancho
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf1='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 6: //alto
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf2='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 11: //X
				$consulta[$x]="update 9011_elementosReportesThot set posX=".$valor." where idGrupoElemento=".$idControl;
				$x++;
			break;
			case 12: //Y
				$consulta[$x]="update 9011_elementosReportesThot set posY=".$valor." where idGrupoElemento=".$idControl;
				$x++;
			break;
			case 23: //intervalo
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf3='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 29: //estilo
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf12='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 30: //Color fondo
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf13='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 31: //Color fondo 1
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf13='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 32: //Color fondo 2
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf12='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 33: //vInicial
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf4='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 34: //almacen de datos(graficoa)
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf5='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 35:
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf10='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 36:
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf11='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 37:
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf12='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			break;
			case 38:
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf7='".cv(bD($valor))."' where idElemReporte=".$idControl;
				$x++;
			break;
			case 39:
				$cadObj="";
				$query="select campoConf7 from 9012_configuracionElemReporteThot WHERE idElemReporte=".$idControl;
				$cadConf=$con->obtenerValor($query);
				$objGraficoConf=json_decode($cadConf);
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf3='".$valor."' where idElemReporte=".$idControl;
				$x++;
				
				$query="select objPropiedadesGrafico from 9026_tiposGraficos WHERE idTiposGraficos=".$valor;
				$objPropiedadesDefault=$con->obtenerValor($query);
				$cadPropiedades=str_replace("\n","",$objPropiedadesDefault);
				$cadPropiedades=str_replace("\r","",$cadPropiedades);
				$cadPropiedades=str_replace("\t","",$cadPropiedades);
				if($cadPropiedades=="")
					$cadPropiedades="{}";
				
				$objPropiedades=json_decode($cadPropiedades);
				
				$titulo="";
				if(isset($objGraficoConf->caption))
					$titulo=$objGraficoConf->caption;
				$cadConf="";
				if(isset($objPropiedades->arrPropiedades))
				{
					foreach($objPropiedades->arrPropiedades as $obj)
					{
						$vDefault="";
						
						eval('if(isset($objGraficoConf->'.$obj->id.')) $vDefault=$objGraficoConf->'.$obj->id.';');
						if(($vDefault=="")&&(isset($obj->valorDefault)))
							$vDefault=$obj->valorDefault;
						if($vDefault!="")
						{
							$objConf='"'.$obj->id.'":"'.$vDefault.'"';
							if($cadConf=="")
								$cadConf.=$objConf;
							else
								$cadConf.=",".$objConf;
						}
					}
				}
				if(($cadConf=="")&&(isset($objGraficoConf->caption)))
					$cadConf='"caption":"'.$objGraficoConf->caption.'"';
				$cadConf="{".$cadConf."}";
				
				$consulta[$x]="update 9012_configuracionElemReporteThot SET campoConf7='".cv($cadConf)."' WHERE idElemReporte=".$idControl;
				
				$x++;
				$comp=bE($cadConf)."|".bE($objPropiedadesDefault);
				
			break;
			case 40:
				$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf13='".$valor."' where idElemReporte=".$idControl;
				$x++;
			break;
			
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			echo "1|".$comp;
		}
		else
			echo "|";
	}
	
	function eliminarElementoReporte()
	{
		global $con;
		$x=0;
		$idElemento=bD($_POST["idGrupoElemento"]);
		$query="select tipoElemento from 9011_elementosReportesThot where  idGrupoElemento=".$idElemento;
		$tElemento=$con->obtenerValor($query);
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9011_elementosReportesThot where idGrupoElemento=".$idElemento;
		$x++;
		$consulta[$x]="delete from 9012_configuracionElemReporteThot where idElemReporte=".$idElemento;
		$x++;
		if($tElemento==23)
		{
			$query="select campoConf3 from 9012_configuracionElemReporteThot where idElemReporte=".$idElemento;	
			$idImagen=$con->obtenerValor($query);
			$consulta[$x]="delete from 983_imagenesFormularios where idArchivo=".$idImagen;
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			echo "1|";
		}
		else
			echo "|";
	}
	
	function actualizarTamanoGrid()
	{
		global $con;
		$idReporte=$_POST["idReporte"];
		$accion=$_POST["accion"]; //0 ancho;1 alto	
		$valor=$_POST["valor"];
		$campo="";
		if($accion==0)
			$campo="ancho";
		else
			$campo="alto";
		$x=0;	
		$consulta[$x]="update 9010_reportesThot set ".$campo."=".$valor." where idReporte=".$idReporte;
		$x++;
		/*if($campo=="ancho")
		{
			$consulta[$x]="update 9012_configuracionElemReporteThot set campoConf1=".($valor-15)." where idElemReporte in (select idGrupoElemento from 9011_elementosReportesThot where idReporte=".$idReporte." and tipoElemento=25)";
			$x++;
		}*/
		eB($consulta);
	}
	
	
	function obtenerDataSets()
	{
		global $con;
		$idReporte=$_POST["idReporte"];
		$tipoDataSet="1";
		if(isset($_POST["tipoDataSet"]))
			$tipoDataSet=$_POST["tipoDataSet"];
			
		$mAlmacenDatos=true;
		$mConsultaAux=true;	
		if(isset($_POST["mAlmacenDatos"])&&($_POST["mAlmacenDatos"]==0))	
		{
			$mAlmacenDatos=false;
		}
		
		if(isset($_POST["mConsultaAux"])&&($_POST["mConsultaAux"]==0))	
		{
			$mConsultaAux=false;
		}
			
		$arrDataSet="";
		$consulta="select * from 9014_almacenesDatos where idReporte=".$idReporte." and tipoDataSet=".$tipoDataSet." order by nombreDataSet ";
		$resAlmacen=$con->obtenerFilas($consulta);
		$arrAlmacenes="";
		$arrAlmacenesCon="";
		$arrAlmacenesGraf="";
		while($filaAl=mysql_fetch_row($resAlmacen))
		{
			$distinct=$filaAl[17];
			$nRegistros=$filaAl[18];
			$arrOrden="";
			if($filaAl[13]!='')
			{
				$objOrden=json_decode($filaAl[13]);
				foreach($objOrden as $orden)	
				{
					$cadOrden="['".$orden->campo."','".$orden->orden."']";
					if($arrOrden=='')
						$arrOrden=$cadOrden;
					else
						$arrOrden.=",".$cadOrden;
				}
				
			}
			$arrOrden="[".$arrOrden."]";
			$cadParam=$filaAl[10];
			$arrParam=explode(",",$cadParam);
			$listParam="";
			$ct=1;
			if($cadParam!="")
			{
				foreach($arrParam as $param)
				{
					$comp="";
					$consulta="select valorUsr,tipoValor from 9014_valoresParametroAlmacenesDatos where parametro='".$param."' and idDataSet=".$filaAl[0];
					$tValor="";
					$valor="";
					$filaParam=$con->obtenerPrimeraFila($consulta);
					if(!$filaParam)
					{
						$comp="&nbsp;<img src='../images/exclamation.png' title='A&uacute;n no se ha asignado un valor a este par&aacute;metro' alt='A&uacute;n no se ha asignado un valor a este par&aacute;metro'>";
						
					}
					else
					{
						$tValor=$filaParam[1];
						$valor=$filaParam[0];
						if($filaParam[1]=="1")
							$comp="&nbsp;(Valor: '".$filaParam[0]."')";
						else
							$comp="&nbsp;(Valor: [".$filaParam[0]."])";
					}
					$obj='{"tipoValor":"'.$tValor.'","valor":"'.$valor.'","dSetPadre":"'.$filaAl[0].'","nParametro":"'.$param.'","tipo":"p","draggable":false,"text":"'.$param.$comp.'","id":"hcp_'.$filaAl[0]."_".$ct.'","allowDrop":false,"icon":"../images/bullet_green.png", "cls":"cssNodoParticipante","iconCls":"cssNodoImagen", "leaf":true}';
					if($listParam=="")
						$listParam=$obj;
					else	
						$listParam.=",".$obj;
					$ct++;
				}
			}
			
			
			$camposProy=explode(",",$filaAl[3]);
			$arrCampos="";
			$ct=1;
			$objArrCampos="";
			$arrErrores="";
			$textoAlmacen=$filaAl[1];
			if($filaAl[11]!=2)
			{
				foreach($camposProy as $campo)
				{
					if($objArrCampos=="")
						$objArrCampos="'".$campo."'";
					else
						$objArrCampos.=",'".$campo."'";
					$arrDatoCampo=explode("_",$campo);
					
					$nombreTabla=explode(".",$campo);
					
					if(strpos($nombreTabla[0],"tablaDinamica")!==false)
					{
						$arrDatoCampo=explode("_",$nombreTabla[0]);
						$campoAux=ucfirst($arrDatoCampo[2]);
						$consulta="select nombreFormulario from 900_formularios where idFormulario=".$arrDatoCampo[1];
						$tituloProceso=$con->obtenerValor($consulta);
						
						$campoAux=$tituloProceso.".".$nombreTabla[1];	
					}
					else
					{
						if($campo[0]!="_")
						{
							if(isset($arrDatoCampo[1]))
								$campoAux=ucfirst($arrDatoCampo[1]);
							else	
								$campoAux=ucfirst($arrDatoCampo[0]);	
						}
						else
						{
							$arrDatoCampo=explode("_",$nombreTabla[0]);
							$campoAux=ucfirst($arrDatoCampo[2]).".".$nombreTabla[1];	
						}
					}
					switch($filaAl[8])
					{
						case "1":
							$campoAux="Promedio(".$campoAux.")";
							$campo="avg(".$filaAl[3].")";
						break;
						case "2":
							
						break;
						case "3":
							$campoAux="Sumatoria(".$campoAux.")";
							$campo="sum(".$filaAl[3].")";
						break;
						case "4":
							$campoAux="Valor m&aacute;ximo(".$campoAux.")";
							$campo="max(".$filaAl[3].")";
						break;
						case "5":
							$campoAux="Valor  m&iacute;nimo(".$campoAux.")";
							$campo="min(".$filaAl[3].")";
						break;
						case "6":
							$campoAux="Contar registros";
							$campo="count(".$filaAl[3].")";
						break;
						case "7":
							$campoAux="Ra&iacute;z cuadrada(".$campoAux.")";
							$campo="sqrt(".$filaAl[3].")";
						break;
							
					}
					$obj='{
							  "dSetPadre":"'.$filaAl[0].'",	
							  "tipo":"c",
							  "draggable":false,
							  "text":"'.$campoAux.'",
							  "nCampo":"'.$campo.'",
							  "id":"hc_'.$filaAl[0]."_".$ct.'",
							  "allowDrop":false,
							  "cls":"cssNodoParticipante",
							  "iconCls":"cssNodoImagen",
							  "icon":"../images/bullet_green.png",
							  "leaf":true
						}';
				
					if($arrCampos=="")
						$arrCampos=$obj;
					else	
						$arrCampos.=",".$obj;
					$ct++;
				}
			
				$condiciones="";
				$cadCond=$filaAl[7];
				$arrCondiciones=json_decode($cadCond);
				foreach($arrCondiciones as $condicion)
				{
					$condiciones.=" ".$condicion->tokenUsuario;	
				}
				if($condiciones=="")
					$condiciones="Sin condiciones";
				$tabla="<table><tr height='21'><td width='80' valign='top'><b>ID Consulta:</b></td><td valign='top'>".$filaAl[0]."</td></tr><tr height='21'><td width='80' valign='top'><b>Tabla:</b></td><td valign='top'>".$filaAl[9]."</td></tr><tr height='21'><td valign='top'><b>Descripci&oacute;n:</b></td><td valign='top'>".$filaAl[2]."</td></tr><tr height='21'><td valign='top'><b>Condiciones:</b></td><td valign='top'>".$condiciones."</td></tr></table>";
				$objJava='{parametros:"'.$cadParam.'",campos:['.$objArrCampos.'],condicion:'.$cadCond.',tabla:"'.$filaAl[9].'",operacion:"'.$filaAl[8].'",nombreDataSet:"'.$filaAl[1].'",descripcion:"'.$filaAl[2].'"}';
				$arrRes=validarConsultaAlmacen($filaAl[0],$con);
				
				
				if(sizeof($arrRes)>0)
				{
					
					foreach($arrRes as $resp)
					{
						if($arrErrores=="")
							$arrErrores="['".$resp."']";
						else
							$arrErrores.=",['".$resp."']";
					}
					
					$textoAlmacen='<font color=\'#FF0000\'>'.$filaAl[1].' <img src=\'../images/exclamation.png\' title=\'Alguna de las condiciones de filtrado presentan errores, ingrese al m&oacute;dulo correspondiente para m&aacute;s detalle\' alt=\'Alguna de las condiciones de filtrado presentan errores, ingrese al m&oacute;dulo correspondiente para m&aacute;s detalle\'></font>';	
				}
			}
			else
			{
				$objJava="''";	
				$tabla="";
				$arrCampos="";
			}
			$arrErrores="[".$arrErrores."]";
			
			if($filaAl[11]!=2)
			{
				$obj='	{
							"arrErrores":'.$arrErrores.',
							"tipo":"t",
							"idConexion":"'.$filaAl[16].'",
							"diferenteValor":"'.$distinct.'",
							"tipoAlmacen":"'.$filaAl[11].'",
							"numRegistros":"'.$nRegistros.'",
							"draggable":false,
							"objJava":'.$objJava.',
							"text":"'.$textoAlmacen.'",
							"qtip":"'.$tabla.'",
							"id":"'.$filaAl[0].'",
							"allowDrop":false,
							"descripcion":"'.$filaAl[2].'",
							"icon":"../images/s.gif",
							"cls":"cssDespachos",
							
							"operacion":"'.$filaAl[8].'",
							"categoria":"'.$filaAl[11].'",
							"nombreDataSet":"'.$filaAl[1].'",
							"orden":'.$arrOrden.',
							leaf:false,
							children:	[
											{
												"tipo":"cc",
												"dSetPadre":"'.$filaAl[0].'",	
												"draggable":false,
												"text":"Campos proyectados",
												"id":"c_'.$filaAl[0].'",
												"allowDrop":false,
												"cls":"cssDespachos",
												"icon":"../images/database_table.png",
												"iconCls":"cssNodoImagen",
												"leaf":false,
												"categoria":"'.$filaAl[11].'",
												"children":['.$arrCampos.']
											},
											{
												"tipo":"cp",
												"draggable":false,
												"text":"Par&aacute;metros de entrada",
												"cls":"cssDespachos",
												"id":"p_'.$filaAl[0].'",
												"allowDrop":false,
												"icon":"../images/database_connect.png",
												"iconCls":"cssNodoImagen",
												"leaf":false,
												"children":['.$listParam.']
											}
										]	
						}';	
			}
			else
			{
				$obj='	{
							"arrErrores":'.$arrErrores.',
							"tipo":"t",
							"draggable":false,
							"objJava":'.$objJava.',
							"text":"'.$textoAlmacen.'",
							"qtip":"'.$tabla.'",
							"id":"'.$filaAl[0].'",
							"idConexion":"'.$filaAl[16].'",
							"allowDrop":false,
							"descripcion":"'.$filaAl[2].'",
							"icon":"../images/s.gif",
							"cls":"cssDespachos",
							"operacion":"'.$filaAl[8].'",
							"categoria":"'.$filaAl[11].'",
							"nombreDataSet":"'.$filaAl[1].'",
							"orden":'.$arrOrden.',
							leaf:false,
							children:	[
											{
												"tipo":"cp",
												"draggable":false,
												"text":"Par&aacute;metros de entrada",
												"id":"p_'.$filaAl[0].'",
												"allowDrop":false,
												"cls":"cssDespachos",
												"icon":"../images/database_connect.png",
												"leaf":false,
												"children":['.$listParam.']
											}
										]	
						}';	
			}
				
			switch($filaAl[11])
			{
				case 0:
					if($arrAlmacenes=="")
						$arrAlmacenes=$obj;
					else
						$arrAlmacenes.=",".$obj;
				break;
				case 1:
					if($arrAlmacenesCon=="")
						$arrAlmacenesCon=$obj;
					else
						$arrAlmacenesCon.=",".$obj;
				break;
				case 2:
					if($arrAlmacenesGraf=="")
						$arrAlmacenesGraf=$obj;
					else
						$arrAlmacenesGraf.=",".$obj;
				break;
			}
		}
		$arrAlmacenesGraf="[".$arrAlmacenesGraf."]";
		$arrAlmacenes="[".$arrAlmacenes."]";
		
		$obj1='	{
						"allowChildren":true,
						"draggable":false,
						"cls":"cssEspecialidad",
						"text":"Almacenes de datos",
						"id":"0",
						"allowDrop":false,
						"icon":"../images/s.gif",
						"expanded":true,
						"tipo":"ad",
						children:'.$arrAlmacenes.'
					}';
		if($tipoDataSet==1)
		{
			$obj3='	{
							"allowChildren":true,
							"draggable":false,
							"icon":"../images/s.gif",
							"text":"Almacenes para gr&aacute;ficas",
							"id":"-20",
							"cls":"cssEspecialidad",
							"allowDrop":false,
							"expanded":true,
							"tipo":"ag",
							children:'.$arrAlmacenesGraf.'
						}';					
		}
		else
			$obj3="";
			
		$obj2='	{
						"allowChildren":true,
						"draggable":true,
						"cls":"cssEspecialidad",
						"icon":"../images/s.gif",
						"text":"Consultas auxiliares",
						"id":"-10",
						"allowDrop":false,
						"expanded":true,
						"tipo":"ca",
						children:['.$arrAlmacenesCon.']
					}
					';	

		$cadTree="";
		if($mAlmacenDatos)
			$cadTree=$obj1;
			
		if($obj3!="")
		{
			$cadTree.=",".$obj3;
		}			
		
		if($mConsultaAux)
			if($cadTree!="")
				$cadTree.=",".$obj2;
			else
				$cadTree=$obj2;
		
		echo "[".$cadTree."]";
	}
	
	function obtenerCamposTabla()
	{
		global $con	;
		$nTabla="";
		$tipoTabla="";
		$arrTablas="";
		$idConexion=0;
		if(isset($_POST["idConexion"]))
			$idConexion=$_POST["idConexion"];
		if(!isset($_POST["idDataSet"]))
		{
			$nTabla=bD($_POST["nTabla"]);
			$arrTablas=explode(",",$nTabla);
			
		}
		else
		{
			$consulta="select * from 9014_almacenesDatos where idDataSet=".$_POST["idDataSet"];
			$filaAlmacen=$con->obtenerPrimeraFila($consulta);
			$nTabla=$filaAlmacen[9];
			$arrTablas=explode(",",$nTabla);
			$idConexion=$filaAlmacen[16];
		}
		$arrCamposFinal=array();
		$numTablasAsoc=sizeof($arrTablas);
		foreach($arrTablas as $nTabla)
		{	
			$conAux=$con;
			if($idConexion!=0)
				$conAux=generarInstanciaConector($idConexion);

			if($conAux->conexion)
			{
				$arrTemp=$conAux->obtenerCamposTabla($nTabla,true,false,true,1);
				if(sizeof($arrTemp)>0)
				{

					foreach($arrTemp as $tmp=>$resto)
					{
						$arrCamposFinal[$tmp]=$resto;
					}
				}
			}
		}
		
		ksort($arrCamposFinal);
		$arrObj="";
		foreach($arrCamposFinal as $nCampo=>$objCampo)
		{
			$obj="['".$objCampo[0]."','".$nCampo."','".$objCampo[1]."','".$objCampo[2]."','".$objCampo[3]."','".$objCampo[4]."','".$objCampo[5]."']";
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		echo "1|[".uEJ($arrObj)."]"."|".$idConexion;
	}
	
	function guardarPregunta()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$nTabla=$obj->tabla;
		$camposProy=$obj->camposProy;
		$operacion=$obj->operacion;
		$arrToken=$obj->tokenSql;
		$nombreDataSet=$obj->nombreDataSet;
		$descripcion=$obj->descripcion;
		$idReporte=$obj->idReporte;
		$parametros=$obj->parametros;
		$numRegistros=isset($obj->numRegistros)?$obj->numRegistros:1000;
		$distinto=isset($obj->distinto)?$obj->distinto:1;
		
		$orden='[]';
		if(isset($obj->arrOrden))
			$orden=bD($obj->arrOrden);
			
		$condWhere="";
		$nodosFiltro="";
		foreach($arrToken as $token)
		{
			$condWhere.=",".$token->tokenMysql;
			$objF='{"tokenUsuario":"'.$token->tokenUsuario.'","tokenMysql":"'.$token->tokenMysql.'","tokenTipo":"'.$token->tokenTipo.'"}';
			if($nodosFiltro=="")
				$nodosFiltro=$objF;
			else
				$nodosFiltro.=",".$objF;
		}
		$nodosFiltro="[".$nodosFiltro."]";
		if($condWhere!="")
			$condWhere=" where ".$condWhere;
		$queryOp="";	
		switch($operacion)
		{
			case 1:
				$queryOp="select avg(".$camposProy.")";
			break;
			case 2:
				$queryOp="select ".$camposProy;				
			break;
			case 3:
				$queryOp="select sum(".$camposProy.")";
			break;
			case 4:
				$queryOp="select max(".$camposProy.")";			
			break;
			case 5:
				$queryOp="select min(".$camposProy.")";			
			break;
			case 6:
				$camposProy="1";
				$queryOp="select count(".$camposProy.") as nRegistros";
			break;
			case 7:
				$queryOp="select sqrt(".$camposProy.")";
			break;	
		}	
		$tipoDataSet="1";	
		if(isset($obj->tipoDataSet))
			$tipoDataSet=$obj->tipoDataSet;	
		$consultaDSet=$queryOp." from ".$nTabla.$condWhere;
		$consulta="begin";
		if($numRegistros=="")
			$numRegistros=0;
		if($con->ejecutarConsulta($consulta))
		{
			
			$consulta="INSERT INTO 9014_almacenesDatos(nombreDataSet,descripcion,camposProy,consulta,idReporte,idUsuario,nodosFiltro,operacion,nTabla,parametros,tipoAlmacen,tipoDataSet,orden,idConexion,obtenerValoresDistintos,numRegistros)
						VALUES('".$nombreDataSet."','".$descripcion."','".$camposProy."','".cv($consultaDSet)."',".$idReporte.",".$_SESSION["idUsr"].
						",'".cv($nodosFiltro)."',".$operacion.",'".$nTabla."','".cv($parametros)."',".$obj->tipoAlmacen.",".$tipoDataSet.",'".$orden."',".(isset($obj->idConexion)?$obj->idConexion:0).",".$distinto.",'".$numRegistros."')";	
			
			if($con->ejecutarConsulta($consulta))
			{
				$idAlmacen=$con->obtenerUltimoID();
				$x=0;
				$query[$x]="commit";
				$x++;
				if($con->ejecutarBloque($query))
				{
					echo "1|";
					return;
				}
			}
		}
		echo "|";
	}
	
	function modificarPregunta()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$arrToken=$obj->tokenSql;
		$idAlmacen=$obj->idAlmacen;
		$parametros=$obj->parametros;
		$numRegistros=$obj->numRegistros;
		if($numRegistros=="")
			$numRegistros=0;
		$distinto=$obj->distinto;
		$orden="";
		if(isset($obj->arrOrden))
			$orden=bD($obj->arrOrden);
		$condWhere="";
		$nodosFiltro="";
		foreach($arrToken as $token)
		{
			$condWhere.=",".$token->tokenMysql;
			$objF='{"tokenUsuario":"'.$token->tokenUsuario.'","tokenMysql":"'.$token->tokenMysql.'","tokenTipo":"'.$token->tokenTipo.'"}';
			if($nodosFiltro=="")
				$nodosFiltro=$objF;
			else
				$nodosFiltro.=",".$objF;
		}
		$nodosFiltro="[".$nodosFiltro."]";
		if($condWhere!="")
			$condWhere=" where ".$condWhere;
		
		$consulta="select consulta from 9014_almacenesDatos where idDataSet=".$idAlmacen;
		$queryConsulta=$con->obtenerValor($consulta);	
		$posWhere=strpos($queryConsulta," where ");
		if($posWhere!==false)
		{
			$cadAux=substr($queryConsulta,0,$posWhere-1);
			$consultaDSet=$cadAux.$condWhere;
		}
		else	
			$consultaDSet=$queryConsulta.$condWhere;
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="update 9014_almacenesDatos set consulta='".cv($consultaDSet)."',nodosFiltro='".cv($nodosFiltro)."',parametros='".cv($parametros)."',orden='".$orden."',obtenerValoresDistintos=".$distinto.",numRegistros='".$numRegistros."' where idDataSet=".$idAlmacen;
			if($con->ejecutarConsulta($consulta))
			{
				$x=0;
				$arrParam=explode(",",$parametros);
				$cadParametros='';
				foreach($arrParam as $param)
				{
					if($cadParametros=="")
						$cadParametros="'".$param."'";
					else
						$cadParametros.=",'".$param."'";
				}
				$query[$x]="DELETE FROM 9014_valoresParametroAlmacenesDatos WHERE parametro NOT IN(".$cadParametros.") AND idDataSet=".$idAlmacen;
				$x++;
				$query[$x]="commit";
				$x++;
				if($con->ejecutarBloque($query))
				{
					echo "1|";
					return;
				}
			}
		}
		echo "|";
	}
	
	function guardarParametroReporte()
	{
		global $con;
		$idReporte=$_POST["idReporte"];
		$idParametro=$_POST["idParametro"];
		$nombre=$_POST["nombre"];
		$descripcion=$_POST["descripcion"];
		
		if($idParametro=="-1")
			$consulta="insert into 9015_parametrosReporte(parametro,descripcion,idReporte) values('".cv($nombre)."','".cv($descripcion)."',".$idReporte.")";
		else
			$consulta="update 9015_parametrosReporte set parametro='".cv($nombre)."',descripcion='".cv($descripcion)."' where idParametro=".$idParametro;
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT idParametro,parametro,descripcion FROM 9015_parametrosReporte WHERE idReporte=".$idReporte." ORDER BY parametro";
			$arrParam=$con->obtenerFilasArreglo($consulta);
			echo "1|".uEJ($arrParam);
		}
		else
			echo "|";


	}
	
	function eliminarParametro()
	{
		global $con;	
		$idParametro=$_POST["idParametro"];
		$idReporte=$_POST["idReporte"];
		
		$consulta="delete from 9015_parametrosReporte where idParametro=".$idParametro;
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT idParametro,parametro,descripcion FROM 9015_parametrosReporte WHERE idReporte=".$idReporte." ORDER BY parametro";
			$arrParam=$con->obtenerFilasArreglo($consulta);
			echo "1|".uEJ($arrParam);
		}
		else
			echo "|";
	}
	
	function eliminarAlmacenDatos()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 9014_almacenesDatos WHERE idDataSet=".$idAlmacen;
		$x++;
		$consulta[$x]="DELETE FROM 9014_categoriasAlmacenesGraficos WHERE idAlmacen=".$idAlmacen;
		$x++;
		$consulta[$x]="DELETE FROM 9014_seriesAlmacenesGraficos WHERE idAlmacen=".$idAlmacen;
		$x++;
		$consulta[$x]="DELETE FROM 9014_categoriasAlmacenesGraficos WHERE idAlmacen=".$idAlmacen;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);	
	}
	
	function vincularSeccionAlmacen()
	{
		global $con;
		$idElemento=bD($_POST["idElemento"]);
		$idAlmacen=$_POST["idAlmacen"];
		$consulta="insert into 9016_seccionesVSAlmacen(idSeccion,idAlmacen,principal) values(".$idElemento.",".$idAlmacen.",1)";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerDataSetsElemento()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$arrDataSet="";
		$consulta="select * from 9014_almacenesDatos where idDataset in(select idAlmacen from 9016_seccionesVSAlmacen where idSeccion=".$idElemento.") order by nombreDataSet";
		$resAlmacen=$con->obtenerFilas($consulta);
		$arrAlmacenes="";
		while($filaAl=mysql_fetch_row($resAlmacen))
		{
			$cadParam=$filaAl[10];
			$arrParam=explode(",",$cadParam);
			$listParam="";
			$ct=1;
			if($cadParam!="")
			{
				foreach($arrParam as $param)
				{
					$obj='{"tipo":"1", "draggable":false,"text":"'.$param.'","id":"hcpE_'.$filaAl[0]."_".$ct.'","allowDrop":false,"icon":"../images/bullet_green.png", "leaf":true}';
					if($listParam=="")
						$listParam=$obj;
					else	
						$listParam.=",".$obj;
					$ct++;
				}
			}
			$camposProy=explode(",",$filaAl[3]);
			$arrCampos="";
			$ct=1;
			$objArrCampos="";
			
			foreach($camposProy as $campo)
			{
				if($objArrCampos=="")
					$objArrCampos="'".$campo."'";
				else
					$objArrCampos.=",'".$campo."'";
				switch($filaAl[8])
				{
					case "1":
						$campo="Promedio(".$campo.")";
					break;
					case "2":
					break;
					case "3":
						$campo="Sumatoria(".$campo.")";
					break;
					case "4":
						$campo="Valor m&aacute;ximo(".$campo.")";
					break;
					case "5":
						$campo="Valor  m&iacute;nimo(".$campo.")";
					break;
					case "6":
						$campo="Contar registros";
					break;
					case "7":
						$campo="Ra&iacute;z cuadrada(".$campo.")";
					break;
						
				}
				$obj='{
						  "draggable":false,
						  "text":"'.$campo.'",
						  "descripcion":"'.$filaAl[2].'",
						  "id":"hcE_'.$filaAl[0]."_".$ct.'",
						  "allowDrop":false,
						  "checked":false,
						  "icon":"../images/bullet_green.png",
						  "leaf":true
					}';
			
				if($arrCampos=="")
					$arrCampos=$obj;
				else	
					$arrCampos.=",".$obj;
				$ct++;
			}
			$condiciones="";
			$cadCond=$filaAl[7];
			$arrCondiciones=json_decode($cadCond);
			foreach($arrCondiciones as $condicion)
			{
				$condiciones.=$condicion->tokenUsuario;	
			}
			if($condiciones=="")
				$condiciones="Sin condiciones";
			$nodoParam="";
			if($listParam!="")
			{	
				$nodoParam='	
								,{
									"draggable":false,
									"text":"<i>Par&aacute;metros de entrada</i>",
									"id":"pE_'.$filaAl[0].'",
									"allowDrop":false,
									"icon":"../images/database_connect.png",
									"leaf":false,
									"children":['.$listParam.']
								}';
			}
			$tabla="<table><tr><td width='80'><b>Tabla:</b></td><td>".$filaAl[9]."</td></tr><tr><td><b>Descripci&oacute;n:</b></td><td>".$filaAl[2]."</td></tr><tr><td ><b>Condiciones:</b></td><td>".$condiciones."</td></tr></table>";
			$objJava='{parametros:"'.$cadParam.'",campos:['.$objArrCampos.'],condicion:'.$cadCond.',tabla:"'.$filaAl[9].'",operacion:"'.$filaAl[8].'",nombreDataSet:"'.$filaAl[1].'",descripcion:"'.$filaAl[2].'"}';
			$obj='	{
						"draggable":false,
						"objJava":'.$objJava.',
						"text":"'.$filaAl[1].'",
						"qtip":"'.$tabla.'",
						"id":"e_'.$filaAl[0].'",
						"allowDrop":false,
						"icon":"../images/icon_code.gif",
						"operacion":"'.$filaAl[8].'",
						leaf:false,
						children:	[
										{
											"draggable":false,
											"text":"<i>Campos proyectados</i>",
											"id":"cE_'.$filaAl[0].'",
											"allowDrop":false,
											"icon":"../images/database_table.png",
											"leaf":false,
											"children":['.$arrCampos.'
														]
										}'.$nodoParam.'
										
									]	
					}';
			if($arrAlmacenes=="")
				$arrAlmacenes=$obj;
			else
				$arrAlmacenes.=",".$obj;
		}
		$arrAlmacenes="[".$arrAlmacenes."]";
		
		$obj1='	{
						"allowChildren":true,
						"draggable":false,
						"text":"<font color=\'#990000\'><i>Almacenes de datos</i></font>",
						"id":"e0",
						"allowDrop":false,
						"icon":"../images/database.png",
						"expanded":true,
						children:'.$arrAlmacenes.'
					}';
		/*$obj2='	{
						"allowChildren":true,
						"draggable":true,
						"text":"<font color=\'#990000\'><i>Almacenes predefinidos</i></font>",
						"id":"-10",
						"allowDrop":false,
						"icon":"../images/database.png",
						"expanded":true,
						children:[]
					}
					
					';	*/						
		echo "[".$obj1."]";
		
		
	}
	
	function agregarCamposSeccion()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$idElemento=$obj->idElemento;
		$cadCampos=$obj->campos;
		$arrCampos=explode(",",$cadCampos);
		$query="select * from 9011_elementosReportesThot where idGrupoElemento=".$idElemento;
		$filaElem=$con->obtenerPrimeraFila($query);
		$idReporte=$filaElem[2];
		$posXPadre=$filaElem[6];
		$posYPadre=$filaElem[7];
		$query="select * from 9012_configuracionElemReporteThot where idElemReporte=".$idElemento;
		$filaConfElem=$con->obtenerPrimeraFila($query);
		$ancho=$filaConfElem[2];
		$alto=$filaConfElem[3];
		$query="SELECT idElementoReporteSig FROM 903_variablesSistema for update";
		$idGrupoElemento=$con->obtenerValor($query);
		$ct=0;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrControles="";
		$posX=($ancho/2);
		$posY=5;
		
		foreach($arrCampos as $campo)
		{
			$consulta[$x]="insert into 9011_elementosReportesThot(idIdioma,idReporte,tipoElemento,idGrupoElemento,nombreCampo,posX,posY,eliminable,idPadre)
							values(0,".$idReporte.",26,".($idGrupoElemento+$ct).",'".$campo."',".$posX.",".$posY.",1,".$idElemento.")";
			$x++;
			$consulta[$x]="insert into 9012_configuracionElemReporteThot(idElemReporte,campoConf1,campoConf12) values(".($idGrupoElemento+$ct).",'','letraExt')";
			$x++;
			
			$arrDatoCampo=explode("_",$campo);
			if(strpos($campo,"tablaDinamica")!==false)
			{
				$campoAux=ucfirst($arrDatoCampo[2]);
				$arrCampo2=explode(".",$campoAux);
				$consultaAux="select nombreFormulario from 900_formularios where nombreTabla='_".$arrDatoCampo[1]."_".$arrCampo2[0]."'";
				$tituloProceso=$con->obtenerValor($consultaAux);
				$campoAux=str_replace("TablaDinamica",$tituloProceso,$campoAux);	
			}
			else
				$campoAux=ucfirst($arrDatoCampo[1]);	
			
			
			$obj="['".($idGrupoElemento+$ct)."','[".$campoAux."]','".$posX."','".$posY."']";
			if($arrControles=="")
				$arrControles=$obj;
			else
				$arrControles.=",".$obj;
			$ct++;
			
		}
		
		$consulta[$x]="update 903_variablesSistema set idElementoReporteSig=".($idGrupoElemento+$ct);
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|[".uEJ($arrControles)."]";
		else
			echo "|";

	}
	
	function guadarParametrosDataSet()
	{
		global $con;	
		$idAlmacen=$_POST["almacen"];
		$param=$_POST["parametro"];
		$tipo=$_POST["tipo"];
		$valor=$_POST["valor"];
		$valorUsr=$_POST["valorUsr"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9014_valoresParametroAlmacenesDatos where parametro='".bD($param)."' and idDataSet=".$idAlmacen;
		$x++;
		$consulta[$x]="insert into 9014_valoresParametroAlmacenesDatos(parametro,valor,valorUsr,tipoValor,idDataset) values('".bD($param)."','".$valor."','".$valorUsr."',".$tipo.",".$idAlmacen.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))		
			echo "1|";
		else
			echo "|";
	}

	function obtenerCamposTablaComp()
	{
		global $con	;
		$idDataSet=$_POST["idDataSet"];
		$consulta="select * from 9014_almacenesDatos where idDataSet=".$idDataSet;
		$filaAlmacen=$con->obtenerPrimeraFila($consulta);
		$nTabla=$filaAlmacen[9];
		$idConexion=$filaAlmacen[16];
		$camposProy=$filaAlmacen[3];
		$arrCampos=explode(",",$camposProy);
		
		$arrTablas=explode(",",$nTabla);
		$arrCamposFinal=array();
		$numTablasAsoc=sizeof($arrTablas);
		foreach($arrTablas as $nTabla)
		{	
			$conAux=$con;
			if($idConexion!=0)
				$conAux=generarInstanciaConector($idConexion);
			if($conAux->conexion)
			{
				$arrTemp=$conAux->obtenerCamposTabla($nTabla,true,false,true,1);
				if(sizeof($arrTemp)>0)
				{
					foreach($arrTemp as $tmp=>$resto)
					{
						$arrCamposFinal[$tmp]=$resto;
					}
				}
			}
		}
		
		
		
		
		ksort($arrCamposFinal);
		$arrObj="";
		foreach($arrCamposFinal as $nCampo=>$objCampo)
		{
			if(!existeValor($arrCampos,$objCampo[0]))
			{
				$obj="['".$objCampo[0]."','".$nCampo."','".$objCampo[1]."','".$objCampo[2]."','".$objCampo[3]."','".$objCampo[4]."','".$objCampo[5]."']";
				if($arrObj=="")
					$arrObj=$obj;
				else
					$arrObj.=",".$obj;
			}
		}
		echo "1|[".uEJ($arrObj)."]";
	}
	
	function actualizarCamposProy()
	{
		global $con;
		$idDataSet=$_POST["idDataSet"];
		$cadCampos=$_POST["cadCampos"];
		$camposProy=$cadCampos;
		$categoria=$_POST["categoria"];
		$operacion=$_POST["operacion"];
		$queryOp="";
		$consulta="select camposProy,consulta from 9014_almacenesDatos where idDataSet=".$idDataSet;
		$filasAlmacen=$con->obtenerPrimeraFila($consulta);
		$campoConsulta=$filasAlmacen[1];
		$campos=$filasAlmacen[0];
		if($categoria==0)
		{
			
			if($campos=="")
				$campos=$cadCampos;
			else
				$campos.=",".$cadCampos;
		}
		else
			$campos=$camposProy;
		switch($operacion)
		{
			case 1:
				$queryOp="select avg(".$camposProy.")";
			break;
			case 2:
				$queryOp="select ".$campos;				
			break;
			case 3:
				$queryOp="select sum(".$camposProy.")";
			break;
			case 4:
				$queryOp="select max(".$camposProy.")";			
			break;
			case 5:
				$queryOp="select min(".$camposProy.")";			
			break;
			case 6:
				$camposProy="1";
				$queryOp="select count(".$camposProy.") as nRegistros";
			break;
			case 7:
				$queryOp="select sqrt(".$camposProy.")";
			break;	
		}	
		$queryNew=$queryOp;
		$pos=strpos($campoConsulta," where ");
		if($pos!==false)
		{
			$cadAux=substr($campoConsulta,$pos);
			$queryNew.=$cadAux;	
		}
		$consulta="update 9014_almacenesDatos set camposProy='".cv($campos)."',operacion=".cv($operacion).",consulta='".cv($queryNew)."' where idDataSet=".$idDataSet;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerCamposProy()
	{
		global $con;
		$nCampo=$_POST["nCampo"];
		$idDataSet=$_POST["idDataSet"];
		$consulta="select camposProy from 9014_almacenesDatos where idDataSet=".$idDataSet;
		$camposProy=$con->obtenerValor($consulta);
		$campos=removerCampo($camposProy,$nCampo);
		$consulta="update 9014_almacenesDatos set camposProy='".$campos."' where idDataSet=".$idDataSet;
		eC($consulta);
	}
	
	function modificarNombreAlmacen()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$nombre=$_POST["nombre"];
		$descripcion=$_POST["descripcion"];
		$consulta="update 9014_almacenesDatos set nombreDataSet='".cv($nombre)."',descripcion='".cv($descripcion)."' where idDataSet=".$idAlmacen;	
		eC($consulta);
	}
	
	function obtenerTablasVinculadas()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$consulta="select nTabla,idConexion from 9014_almacenesDatos where idDataSet=".$idAlmacen;
		$fAlmacen=$con->obtenerPrimeraFila($consulta);
		$nTablas=$fAlmacen[0];
		$idConexion=$fAlmacen[1];
		$arrTablas=explode(",",$nTablas);
		$objTablas="";
		$arrTablasV="";
		$condWhereFD="";
		foreach($arrTablas as $tabla)
		{
			$datosTabla=explode("_",$tabla);
			if(strpos($tabla,"tablaDinamica")===false)
			{
				$tipoTabla="Sistema";
				if(sizeof($datosTabla)>1)
					$nomTablaParaUsuario=$datosTabla[1];
				else
					$nomTablaParaUsuario=$datosTabla[0];
				if($idConexion!=0)
					$nomTablaParaUsuario=$tabla;
				$nProceso="N/A";
			}	
			else
			{
				$query="select titulo,nombreFormulario,p.nombre from 900_formularios f,4001_procesos p where p.idProceso=f.idProceso and nombreTabla='".$tabla."'".$condWhereFD;
				$filaFrm=$con->obtenerPrimeraFila($query);
				if($filaFrm)
				{
					$tipoTabla="Formulario Din&aacute;mico";
					$nProceso=$filaFrm[2];
					$nomTablaParaUsuario=$filaFrm[0];
					
				}
				
			}
			
			$obj="['".$tabla."','".ucfirst($nomTablaParaUsuario)."','".$tipoTabla."','".$nProceso."']";
			if($arrTablasV=="")
				$arrTablasV=$obj;
			else
				$arrTablasV.=",".$obj;
		}
		echo "1|[".$arrTablasV."]|".$idConexion;
	}
	
	function vincularTablaAlmacen()
	{
		global $con;
		$nTabla=$_POST["nTabla"];	
		$idAlmacen=$_POST["idAlmacen"];
		$consulta="update 9014_almacenesDatos set nTabla=concat(nTabla,',".$nTabla."') where idDataSet=".$idAlmacen;
		eC($consulta);
	}
	
	function removerTablaAlmacen()
	{
		global $con;
		$nTablaDel=$_POST["nTabla"];
		$idAlmacen=$_POST["idAlmacen"];
		$idReporte=$_POST["idReporte"];
		$tDataSet="1";
		if(isset($_POST["tDataSet"]))
			$tDataSet=$_POST["tDataSet"];
		$consulta="select * from 9014_almacenesDatos where tipoDataSet=".$tDataSet." and idDataSet=".$idAlmacen;
		$filaAlmacen=$con->obtenerPrimeraFila($consulta);
		$camposProy=$filaAlmacen[3];
		
		$nTabla=$filaAlmacen[9];
		$parametros=$filaAlmacen[10];
		$camposDel="";
		$camposAux="";
		$arrCampos=explode(",",$camposProy);
		foreach($arrCampos as $campo)
		{
			if((strpos($campo,$nTablaDel)===false)||(strpos($campo,$nTablaDel)>0))
			{
				if($camposAux=="")
					$camposAux=$campo;
				else	
					$camposAux.=",".$campo;
			}
			else
			{
				if($camposDel=="")
					$camposDel="'".$campo."'";
				else
					$camposDel.=",'".$campo."'";
			}
		}
		$arrTablas=explode(",",$nTabla);
		$tablasAux="";
		foreach($arrTablas as $tabla)
		{
			if($tabla!=$nTablaDel)
			{
				if($tablasAux=="")
					$tablasAux=$tabla;
				else	
					$tablasAux.=",".$tabla;
			}
		}
		$arrParametros=explode(",",$parametros);
		$nodosAux="";
		$parametrosAux="";
		if($camposDel=="")
			$camposDel='-1';
		$x=0;
		$query[$x]="begin";
		$x++;
		if($tDataSet=="1")
		{
			$query[$x]="delete from 9011_elementosReportesThot where idReporte=".$idReporte." and nombreCampo in (".$camposDel.")";
			$x++;
		}
		$query[$x]="update 9014_almacenesDatos set camposProy='".$camposAux."',nTabla='".$tablasAux."' where idDataSet=".$idAlmacen;
		$x++;
		
		$query[$x]="commit";
		$x++;
		eB($query);	
	}
	
	function obtenerParametrosPendientes()
	{
		global $con;	
		$idAlmacen=$_POST["idAlmacen"];
		$idAlmacenPadre=$_POST["idAlmacenPadre"];
		$consulta="SELECT parametro FROM 9014_valoresParametroAlmacenesDatos WHERE idDataSet=".$idAlmacen;
		$listaParam=$con->obtenerListaValores($consulta,"'");
		if($listaParam=="")
			$listaParam="''";
		$consulta="SELECT parametros FROM 9014_almacenesDatos WHERE idDataSet=".$idAlmacen;
		$listaParam=$con->obtenerListaValores($consulta);
		$obj="";
		$cadObj="";
		if($listaParam!="")
		{
			$arrParam=explode(",",$listaParam);
			
			foreach($arrParam as $param)
			{
				$consulta="SELECT valorUsr FROM 9014_valoresParametroAlmacenesDatos WHERE parametro='".$param."' AND idDataSet=".$idAlmacen;
				$valorUsr=$con->obtenerValor($consulta);
				
				$obj="['".$param."','".$param."','".$valorUsr."']";
				if($cadObj=="")
					$cadObj=$obj;
				else
					$cadObj.=",".$obj;
			}
		}
		$consulta="SELECT idAlmacen FROM 9016_seccionesVSAlmacen WHERE idSeccion=".$idAlmacenPadre;
		$idAlmacen=$con->obtenerValor($consulta);
		if($idAlmacen=="")
			$idAlmacen="-1";
		$consulta="SELECT camposProy FROM 9014_almacenesDatos WHERE idDataSet=".$idAlmacen;
		$filaProy=$con->obtenerPrimeraFila($consulta);
		$camposProy=$filaProy[0];
		$arrCamposProy=explode(",",$camposProy);
		$camposProy="";
		foreach($arrCamposProy as $campo)
		{
			if($camposProy=="")
				$camposProy="['".$campo."','".$campo."']";
			else
				$camposProy.=",['".$campo."','".$campo."']";
		}
		$camposProy="[".$camposProy."]";
		echo "1|[".$cadObj."]|".$camposProy;
	}
	
	function obtenerReportesDisponibleMapa()
	{
		global $con;
		$consulta="SELECT idReporte,nombreReporte,descripcion FROM 9010_reportesThot WHERE idReporte NOT IN (SELECT idReporte FROM 9023_reportesMapaCurricular)";
		$arrReportes=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrReportes);
		
	}
	
	function obtenerParametrosReporte()
	{
		global $con;	
		$idReporte=$_POST["idReporte"];
		$consulta="SELECT parametro,parametro,'' as valor,'' as tipoValor,'' as valorReal FROM 9015_parametrosReporte where idReporte=".$idReporte;
		$arrDatos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrDatos);
	}
	
	function guardarVinculacionReporte()
	{
		global $con;	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$idReporte=$obj->idReporte;
		$params=$obj->params;
		$leyenda=$obj->leyenda;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 9023_reportesMapaCurricular(idReporte,leyendaReporte) values(".$idReporte.",'".cv($leyenda)."')";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$idReporteMapa=$con->obtenerUltimoID();
			$x=0;
			foreach($params as $p)
			{
				$consulta2[$x]="insert into 9024_valorParamReportesMapaCurricular(idReporteMapa,parametro,tipoValor,valor) 
								values(".$idReporteMapa.",'".cv($p->parametro)."','".cv($p->tipoValor)."','".cv($p->valor)."')";
				$x++;
			}		
			$consulta2[$x]="commit";
			$x++;
			eB($consulta2);
		}
		else
			echo "|";
	}
	
	function removerVinculacionReporte()
	{
		global $con;
		$idReporte=$_POST["idReporte"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9023_reportesMapaCurricular where idReporteMapa=".$idReporte;
		$x++;
		$consulta[$x]="delete from 9024_valorParamReportesMapaCurricular where idReporteMapa=".$idReporte;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
			
	}
	
	function modificarValorParametro()
	{
		global $con;
		$valorUsr=$_POST["valorUsr"];
		$parametro=$_POST["parametro"];
		$tipo=$_POST["tipo"];
		$idReporte=$_POST["idReporte"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9024_valorParamReportesMapaCurricular where parametro='".$parametro."' and idReporteMapa=".$idReporte;
		$x++;
		
		$consulta[$x]="insert into 9024_valorParamReportesMapaCurricular(idReporteMapa,parametro,tipoValor,valor) 
								values(".$idReporte.",'".cv($parametro)."','".cv($tipo)."','".cv($valorUsr)."')";
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		
		$valor=$valorUsr;
		
		switch($tipo)
		{
			case 3:
			case 4:
				$query="select descripcionValor from 8003_valoresSesion where idValorSesion=".$valor;
				$valor=$con->obtenerValor($query);
			break;
			case 9:
				$query="select valorUsr from 9025_valoresPagina where valorPagina='".$valor."'";
				$valor=$con->obtenerValor($query);
			break;
		}
		if($con->ejecutarBloque($consulta))
			echo "1|".uEJ($valor);
		else
			echo "|";
		
	}
	
	function eliminarReporte()
	{
		global $con;
		$idReporte=$_POST["idReporte"];
		
		$query="SELECT idElemento FROM 9011_elementosReportesThot WHERE idReporte=".$idReporte;

		$listElemReporte=$con->obtenerListaValores($query);
		
		if($listElemReporte=="")
			$listElemReporte="-1";
		$query="SELECT idDataSet FROM 9014_almacenesDatos WHERE idReporte=".$idReporte." AND tipoDataSet=1";
		$listDataSet=$con->obtenerListaValores($query);
		if($listDataSet=="")
			$listDataSet="-1";
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 9010_reportesThot WHERE idReporte=".$idReporte;
		$x++;
		$consulta[$x]="DELETE FROM 9011_elementosReportesThot WHERE idElemento IN (".$listElemReporte.")";
		$x++;
		$consulta[$x]="DELETE FROM 9012_configuracionElemReporteThot WHERE idElemReporte IN (".$listElemReporte.")";
		$x++;
		$consulta[$x]="DELETE FROM 9014_almacenesDatos WHERE idReporte=".$idReporte." AND tipoDataSet=1";
		$x++;
		$consulta[$x]="DELETE FROM 9014_valoresParametroAlmacenesDatos WHERE idDataSet IN(".$listDataSet.")";
		$x++;
		$consulta[$x]="DELETE FROM 9015_parametrosReporte WHERE idReporte=".$idReporte;
		$x++;
		$consulta[$x]="DELETE FROM 9016_seccionesVSAlmacen WHERE idAlmacen IN (".$listDataSet.")";
		$x++;
		$consulta[$x]="DELETE FROM 9014_categoriasAlmacenesGraficos WHERE idAlmacen IN (".$listDataSet.")";
		$x++;
		$consulta[$x]="DELETE FROM 9014_seriesAlmacenesGraficos WHERE idAlmacen IN (".$listDataSet.")";
		$x++;
		$consulta[$x]="DELETE FROM 9014_valoresAlmacenGrafico WHERE idAlmacen IN (".$listDataSet.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerCategoriaAlmacenGrafico()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];	
		$consulta="SELECT complementario FROM 9014_almacenesDatos WHERE idDataSet=".$idAlmacen;
		$confAlmacen=$con->obtenerValor($consulta);
		$consulta="select idCategoriaAlmacenGrafico,nombreCategoria,color,tipoCategorias,comp1,valor from 9014_categoriasAlmacenesGraficos where idAlmacen=".$idAlmacen." order by idCategoriaAlmacenGrafico";
		$arrCat=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrCat."|".$confAlmacen;
	}
	
	function eliminarCategoriaAlmacenGrafico()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];	
		$consulta="delete from 9014_categoriasAlmacenesGraficos where idCategoriaAlmacenGrafico=".$idCategoria;
		eC($consulta);
	}
	
	function crearAlmacenGrafico()
	{
		global $con;
		$nombre=$_POST["nombreAlmacen"]	;
		$descripcion=$_POST["descripcion"];
		$idReporte=$_POST["idReporte"];
		$consulta="INSERT INTO 9014_almacenesDatos(nombreDataSet,descripcion,idReporte,idUsuario,tipoAlmacen,tipoDataSet) 
					VALUES('".cv($nombre)."','".cv($descripcion)."',".$idReporte.",".$_SESSION["idUsr"].",2,1)";
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT idDataSet,nombreDataSet FROM 9014_almacenesDatos WHERE tipoAlmacen=2 AND tipoDataSet=1 AND idReporte=".$idReporte;
			$arrAlmacenes=$con->obtenerFilasArreglo($consulta);					
			echo "1|".$con->obtenerUltimoID()."|".$arrAlmacenes;
		}
	}
	
	function obtenerConfiguracionOrigenDatos()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];
		$consulta="SELECT idCategoriaAlmacenGrafico,nombreCategoria FROM 9014_categoriasAlmacenesGraficos WHERE idAlmacen=".$idAlmacen." ORDER BY idCategoriaAlmacenGrafico";
		$resCategorias=$con->obtenerFilas($consulta);
		$arrFilas="";
		$consulta="SELECT nombreSerie,idSerieAlmacenGrafico FROM 9014_seriesAlmacenesGraficos WHERE idAlmacen=".$idAlmacen." order by idSerieAlmacenGrafico";
		$arrSeries=$con->obtenerFilasArregloPHP($consulta);
		while($filaCat=mysql_fetch_row($resCategorias))
		{
			$comp="";
			if(sizeof($arrSeries)>0)
			{
				foreach($arrSeries as $serie)
				{
					$consulta="select tipoValor,valor,color,etiqueta from 9014_valoresAlmacenGrafico where idCategoria=".$filaCat[0]." and idSerie=".$serie[1]." and idAlmacen=".$idAlmacen;
					$f=$con->obtenerPrimeraFila($consulta);
					$tValor=$f[0];
					$valor="";
					switch($tValor)
					{
						case 1:
							$valor=$f[1];
						break;
						case 7:
							$valor=$f[1];
							$arrDatos=explode("|",$valor);
							$consulta="SELECT nombreDataSet FROM 9014_almacenesDatos WHERE idDataSet=".$arrDatos[0];
							$valor="[".$con->obtenerValor($consulta)."]";
						break;
						case 11:
							$valor=$f[1];
							$arrDatos=explode("|",$valor);
							$consulta="SELECT nombreDataSet FROM 9014_almacenesDatos WHERE idDataSet=".$arrDatos[0];
							$datosCampo=explode("_",$arrDatos[1]);
							$nCampo="";
							$valor="[".$con->obtenerValor($consulta)."]";
						break;	
						case 22:
							$valor=$f[1];
							$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$valor;
							$valor="Función: ".$con->obtenerValor($consulta);
						break;
					}
					$comp2="";
					if($f[3]!="")
						$comp2="<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;<b>Etiqueta:</b> ".$f[3];
					if($comp=="")
						$comp=",'<span style=\"border-style:solid; border-width:1px; border-color:#000;height:10px;width:10px;background-color:#".$f[2]."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;".$valor.$comp2."'";
					else
						$comp.=",'<span style=\"border-style:solid; border-width:1px; border-color:#000;height:10px;width:10px;background-color:#".$f[2]."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;".$valor.$comp2."'";	
					
				}
			}
			$obj="['".$filaCat[0]."','".$filaCat[1]."'".$comp."]";
			if($arrFilas=="")
				$arrFilas=$obj;
			else
				$arrFilas.=",".$obj;
		}
		$consulta="SELECT nombreSerie,idSerieAlmacenGrafico FROM 9014_seriesAlmacenesGraficos WHERE idAlmacen=".$idAlmacen." order by idSerieAlmacenGrafico";
		$arrSeries=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".$arrSeries."|[".$arrFilas."]";	
	}
	
	function guardarCategoriaGrafico()
	{
		global $con;
		$listIdCategorias="";
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$condicionesFiltro=cv(bD($obj->condicionesFiltro));
		$complementario=bD($obj->complementario);
		if($condicionesFiltro!="")
		{
			$complementario=setAtributoCadJson($complementario,"condicionFiltro",$condicionesFiltro);
		}
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9014_almacenesDatos set complementario='".cv($complementario)."' where idDataSet=".$obj->idAlmacen;
		$x++;
		$consulta[$x]="";
		$posTmp=$x;
		$x++;
		$consulta[$x]="";
		$x++;
		
		foreach($obj->categorias as $c)
		{
			if($c->idCategoria==-1)
			{
				$consulta[$x]="INSERT INTO 9014_categoriasAlmacenesGraficos(idAlmacen,nombreCategoria,color,tipoCategorias,comp1,valor) 
							VALUES(".$obj->idAlmacen.",'".cv($c->categoria,false)."','".$c->color."',".$c->tipo.",'".$c->comp."','".cv($c->valor)."')";
				
				$x++;
			}
			else
			{
				$consulta[$x]="update 9014_categoriasAlmacenesGraficos set nombreCategoria='".cv($c->categoria,false)."',color='".$c->color."',tipoCategorias=".$c->tipo.",comp1='".$c->comp."',valor='".cv($c->valor)."'
								where idCategoriaAlmacenGrafico=".$c->idCategoria;
				
				$x++;
				if($listIdCategorias=="")
					$listIdCategorias=$c->idCategoria;
				else
					$listIdCategorias.=",".$c->idCategoria;
			}
		}
		if($listIdCategorias=="")
			$listIdCategorias=-1;
		
		$consulta[$posTmp]="delete from 9014_categoriasAlmacenesGraficos where idAlmacen=".$obj->idAlmacen." and idCategoriaAlmacenGrafico not in (".$listIdCategorias.")";
		$posTmp++;
		$consulta[$posTmp]="DELETE FROM 9014_valoresAlmacenGrafico WHERE idAlmacen=".$obj->idAlmacen." and idCategoria not in (".$listIdCategorias.")";
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select idCategoriaAlmacenGrafico,nombreCategoria,color from 9014_categoriasAlmacenesGraficos where idAlmacen=".$obj->idAlmacen;
			$arrCat=$con->obtenerFilasArreglo($query);
			echo "1|".$arrCat;	
		}
	}
	
	function obtenerSerieAlmacenGrafico()
	{
		global $con;
		$idAlmacen=$_POST["idAlmacen"];	
		$consulta="SELECT complementario2 FROM 9014_almacenesDatos WHERE idDataSet=".$idAlmacen;
		$confAlmacen=$con->obtenerValor($consulta);
		$consulta="select idSerieAlmacenGrafico,nombreSerie,titulo,color,tipoSerie,comp1,valor from 9014_seriesAlmacenesGraficos where idAlmacen=".$idAlmacen." order by idSerieAlmacenGrafico";
		$arrCat=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".$arrCat."|".$confAlmacen;
	}
	
	function eliminarSerieAlmacenGrafico()
	{
		global $con;
		$idSerie=$_POST["idSerie"];	
		$consulta="delete from 9014_seriesAlmacenesGraficos where idSerieAlmacenGrafico=".$idSerie;
		eC($consulta);
	}
	
	function guardarSerieGrafico()
	{
		global $con;
		$listIdCategorias="";
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$condicionesFiltro=cv(bD($obj->condicionesFiltro));
		$complementario=bD($obj->complementario);
		if($condicionesFiltro!="")
		{
			$complementario=setAtributoCadJson($complementario,"condicionFiltro",$condicionesFiltro);
		}
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9014_almacenesDatos set complementario2='".cv($complementario)."' where idDataSet=".$obj->idAlmacen;
		$x++;
		$consulta[$x]="";
		$posTmp=$x;
		$x++;
		$consulta[$x]="";

		$x++;
		$listSeries="";
		
		foreach($obj->series as $c)
		{
			if($c->idSerie==-1)
			{
				$consulta[$x]="INSERT INTO 9014_seriesAlmacenesGraficos(idAlmacen,nombreSerie,titulo,color,tipoSerie,comp1,valor) 
							VALUES(".$obj->idAlmacen.",'".cv($c->serie)."','".cv($c->leyenda)."','".$c->color."',".$c->tipo.",'".$c->comp."','".cv($c->valor)."')";
				
				$x++;
			}
			else
			{
				$consulta[$x]="update 9014_seriesAlmacenesGraficos set nombreSerie='".cv($c->serie)."',titulo='".cv($c->leyenda)."',color='".$c->color."',
							tipoSerie=".$c->tipo.",comp1='".$c->comp."',valor='".cv($c->valor)."' where idSerieAlmacenGrafico=".$c->idSerie;
				
				$x++;
				if($listSeries=="")
					$listSeries=$c->idSerie;
				else
					$listSeries.=",".$c->idSerie;
			}
		}
		if($listSeries=="")
			$listSeries=-1;

		$consulta[$posTmp]="delete from 9014_seriesAlmacenesGraficos where idAlmacen=".$obj->idAlmacen." and idSerieAlmacenGrafico not in (".$listSeries.")";
		$posTmp++;
		$consulta[$posTmp]="DELETE FROM 9014_valoresAlmacenGrafico WHERE idAlmacen=".$obj->idAlmacen." and idSerie not in(".$listSeries.")";

		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			$query="select idSerieAlmacenGrafico,nombreSerie,titulo,color from 9014_seriesAlmacenesGraficos where idAlmacen=".$obj->idAlmacen;
			$arrCat=$con->obtenerFilasArreglo($query);
			echo "1|".$arrCat;	
		}
	}
	
	function guardarOrigenDatoGrafico()
	{
		global $con;
		$idCategoria=$_POST["idCategoria"];
		$idSerie=$_POST["idSerie"];
		$idAlmacen=$_POST["idAlmacen"];
		$tValor=$_POST["tValor"];
		$valor=$_POST["valor"];
		$color=$_POST["color"];
		$etiqueta=$_POST["etiqueta"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 9014_valoresAlmacenGrafico WHERE idCategoria=".$idCategoria." AND idSerie=".$idSerie." AND idAlmacen=".$idAlmacen;
		$x++;
		$consulta[$x]="INSERT INTO 9014_valoresAlmacenGrafico(idCategoria,idSerie,idAlmacen,tipoValor,valor,color,etiqueta)
						VALUES(".$idCategoria.",".$idSerie.",".$idAlmacen.",".$tValor.",'".$valor."','".$color."','".cv($etiqueta)."')";
		$x++;					
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerSedesEstado()
	{
		global $con;
		$valor=$_POST["valor"];	
		$tConsulta=$_POST["tConsulta"];
		
		
		switch($tConsulta)
		{
			case 0:
				$consulta="SELECT DISTINCT c.Sede FROM _258_tablaDinamica e,_249_tablaDinamica c,246_autoresVSProyecto a WHERE 
							e.idReferencia=a.id_246_autoresVSProyecto AND c.id__249_tablaDinamica=a.idReferencia";
				$listaSedes=$con->obtenerListaValores($consulta);										
				if($listaSedes=="")
					$listaSedes="-1";
				$consulta="SELECT idOrganigrama,unidad FROM 817_organigrama WHERE codCentroCosto='".$valor."' AND STATUS=1 and idOrganigrama in
							(".$listaSedes.") order by unidad";
			break;
			case 1:
														
				$consulta="SELECT id__249_tablaDinamica,CONCAT(grupo,' [',DATE_FORMAT(Fecha,'%d/%m/%Y'),', ',DATE_FORMAT(horaInicio,'%h:%i %p'),']') FROM _249_tablaDinamica WHERE Sede=".$valor." ORDER BY grupo";
			break;
			case 2:
				$consulta="SELECT DISTINCT cmbPlantel FROM _309_tablaDinamica";
				$listaSedes=$con->obtenerListaValores($consulta);										
				if($listaSedes=="")
					$listaSedes="-1";
				$consulta="SELECT idOrganigrama,unidad FROM 817_organigrama WHERE codCentroCosto='".$valor."' AND STATUS=1 and idOrganigrama in
							(".$listaSedes.") order by unidad";
			break;
			case 3:
				$consulta="SELECT id__284_tablaDinamica, g.txtGrupo FROM _292_tablaDinamica t, 817_organigrama o,_284_tablaDinamica g WHERE 
						t.cmbPLantel= o.codigoUnidad AND o.idOrganigrama=".$valor." AND g.id__284_tablaDinamica=t.cmbCursos";
				
				
				
			break;
		}
		$arrSedes=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrSedes;
		
	}
	
	
	function clonarReporte()
	{
		global $con;
		$idReporte=$_POST["idReporte"];
		$titulo=$_POST["titulo"];
		$descripcion=$_POST["descripcion"];
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="INSERT INTO 9010_reportesThot(nombreReporte,descripcion,fechaCreacion,idUsuarioResponsable,ancho,alto)
							SELECT '".cv($titulo)."' AS nReporte,'".cv($descripcion)."' AS descripcion,'".date('Y-m-d')."' AS fechaCreacion,'".$_SESSION["idUsr"]."' AS idUsuarioResponsable,ancho,alto FROM 9010_reportesThot WHERE idReporte=".$idReporte;
			if($con->ejecutarConsulta($consulta))
			{
				$idNReporte=$con->obtenerUltimoID();	
				
				$consulta="INSERT INTO 9015_parametrosReporte(parametro,descripcion,idReporte)
							SELECT parametro,descripcion,'".$idNReporte."' AS idRep from 9015_parametrosReporte WHERE idReporte=".$idReporte;
				if(!$con->ejecutarConsulta($consulta))
					return;
				
				if(!clonarElementosReporte($idReporte,$idNReporte))
					return;
				if(!clonarAlmacenesReporte($idReporte,$idNReporte))
					return;
				$consulta="commit";
				if($con->ejecutarConsulta($consulta))
					echo "1|".$idNReporte;
			}
		}
	}
	
	function obtenerSedesEstadoV2()
	{
		global $con;
		$valor=$_POST["valor"];	
		$tConsulta=$_POST["tConsulta"];
		$institucion="";
		if(isset($_POST["codInstitucion"]))
			$institucion=$_POST["codInstitucion"];
		$arrSedesAsistentes="[]";
		switch($tConsulta)
		{
			case 0:
				$consulta="SELECT DISTINCT c.Sede FROM _320_tablaDinamica e,_249_tablaDinamica c,246_autoresVSProyecto a WHERE 
							e.idReferencia=a.id_246_autoresVSProyecto AND c.id__249_tablaDinamica=a.idReferencia and c.idEstado=1 and c.Sede IN (SELECT idOrganigrama FROM 817_organigrama WHERE unidadPadre LIKE '".$institucion."%' AND STATUS=1)";
				$listaSedes=$con->obtenerListaValores($consulta);										
				if($listaSedes=="")
					$listaSedes="-1";
				$consulta="SELECT idOrganigrama,unidad FROM 817_organigrama WHERE codCentroCosto='".$valor."' AND STATUS=1 and idOrganigrama in
							(".$listaSedes.") order by unidad";
				
				$query="SELECT DISTINCT ad.Institucion FROM _320_tablaDinamica e,_249_tablaDinamica c,246_autoresVSProyecto a,801_adscripcion ad WHERE 
							e.idReferencia=a.id_246_autoresVSProyecto AND c.id__249_tablaDinamica=a.idReferencia and c.idEstado=1 and c.Sede IN 
							(SELECT idOrganigrama FROM 817_organigrama WHERE unidadPadre LIKE '".$institucion."%' AND STATUS=1) and ad.idUsuario=a.idUsuario";
				$listaSedes=$con->obtenerListaValores($query,"'");										
				if($listaSedes=="")
					$listaSedes="-1";
				
				$query="SELECT idOrganigrama,unidad FROM 817_organigrama WHERE codCentroCosto='".$valor."' AND STATUS=1 and codigoUnidad in
							(".$listaSedes.") order by unidad";
				$arrSedesAsistentes=$con->obtenerFilasArreglo($query);
			break;
			case 1:
														
				$consulta="SELECT id__249_tablaDinamica,CONCAT(grupo,' [',DATE_FORMAT(Fecha,'%d/%m/%Y'),', ',DATE_FORMAT(horaInicio,'%h:%i %p'),']') FROM _249_tablaDinamica WHERE Sede=".$valor." and idEstado=1 ORDER BY grupo";
			break;
			
		}
		$arrSedes=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrSedes."|".$arrSedesAsistentes;
		
	}
	
	function obtenerEstadosV2()
	{
		global $con;
		$institucion=$_POST["valor"];
		$comp="";
		if($_SESSION["idUsr"]==2947)
		{
			$comp=" and codigo not in ('0009','0011')";
		}
		$consulta="SELECT codigo,tituloCentroC FROM 506_centrosCosto WHERE codigo IN (SELECT DISTINCT c.CentroCosto FROM _320_tablaDinamica e,_249_tablaDinamica c,246_autoresVSProyecto a WHERE 
					e.idReferencia=a.id_246_autoresVSProyecto AND c.id__249_tablaDinamica=a.idReferencia AND c.idEstado=1 AND c.Sede IN (SELECT idOrganigrama FROM 817_organigrama WHERE unidadPadre LIKE '".$institucion."%' AND STATUS=1)) 
					".$comp." ORDER BY tituloCentroC";
		$arrEstados=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrEstados;
	}
	
	function obtenerSeccionesCuestionario()
	{
		global $con;
		$idCuestionario=$_POST["idConsulta"];
		$consulta="SELECT idCuestionario,tituloCuestionario,descripcion,nombreCuestionario,tipoPonderacionElementosHijos,escalaEvaluacionFinal,solicitarComentariosFinales,mostrarPuntajeObtenido,tipoCuestionario,idEscalaCategoriaPreguntas 
					FROM 9051_cuestionarios WHERE idCuestionario=".$idCuestionario;
		$fCuestionario=$con->obtenerPrimeraFila($consulta);
		$claveCuestionario=str_pad($idCuestionario,4,"0",STR_PAD_LEFT);
		$consulta="SELECT * FROM 9052_elementosCuestionario WHERE codigoPadre='".$claveCuestionario."' order by ordenElemento";
		$res=$con->obtenerFilas($consulta);
		$cadElementos="";
		while($fila=mysql_fetch_row($res))
		{
			$prefijo=$fila[11];
			if($prefijo!="")
				$prefijo.=".- ";
			$obj='{campoTextoRespuesta:"'.$fila[15].'",campoIdRespuesta:"'.$fila[16].'",campoValorRespuesta:"'.$fila[17].'",tipoRespuesta:"'.$fila[3].'",idReferenciaRespuesta:"'.$fila[4].'",claseRespuesta:"'.$fila[8].'",presentarRespuesta:"'.$fila[13].'",incluirValorNoAplica:"'.$fila[14].'",
					ponderacionElementosHijos:"'.$fila[12].'",idElemento:"'.$fila[0].'",prefijo:"'.$fila[11].'",titulo:"'.cv($fila[1]).'",orden:"'.$fila[6].'",clase:"'.$fila[7].'",valorSeccion:"'.$fila[5].'",codigoUnidad:"'.$fila[10].'",id:"tc_'.$fila[0].'",text:"'.$prefijo.$fila[1].'","tipoElemento":"'.$fila[2].'"';
			$cadHijos=obtenerElementosCuestionarioHijos($fila[10]);

			$comp="";

			if($cadHijos=="[]")
				$comp=',leaf:true';
			else
				$comp=',leaf:false,children:'.$cadHijos.'';
			$obj.=$comp."}";	
			
			if($cadElementos=="")
				$cadElementos=$obj;
			else
				$cadElementos.=",".$obj;
		}
		$comp="";
		if($cadElementos=="")
			$comp=',leaf:true';
		else
			$comp=',leaf:false,children:['.$cadElementos.']';
		$objUnidad='{"categoriaRespuestas":"'.$fCuestionario[9].'","tipoCuestionario":"'.$fCuestionario[8].'","mostrarPuntajeObtenido":"'.$fCuestionario[7].'",nombreCuestionario:"'.cv($fCuestionario[3]).'","titulo":"'.cv($fCuestionario[1]).'","descripcion":"'.cv($fCuestionario[2]).'","ponderacionElementosHijos":"'.$fCuestionario[4].'","escalaEval":"'.$fCuestionario[5].'","comentariosFinales":"'.$fCuestionario[6].'",idElemento:"'.$fCuestionario[0].'",codigoUnidad:"'.$claveCuestionario.'",id:"p_'.$fCuestionario[0].'",text:"'.$fCuestionario[1].'","tipoElemento":"0"'.$comp.'}';
		
		echo "[".$objUnidad."]";
	}
	
	function obtenerElementosCuestionarioHijos($codigoPadre)
	{
		global $con;
		$consulta="SELECT * FROM 9052_elementosCuestionario WHERE codigoPadre='".$codigoPadre."'  order by ordenElemento";
		$res=$con->obtenerFilas($consulta);
		$cadElementos="";
		while($fila=mysql_fetch_row($res))
		{
			$prefijo=$fila[11];
			if($prefijo!="")
				$prefijo.=".- ";
			$obj='{campoTextoRespuesta:"'.$fila[15].'",campoIdRespuesta:"'.$fila[16].'",campoValorRespuesta:"'.$fila[17].'",tipoRespuesta:"'.$fila[3].'",idReferenciaRespuesta:"'.$fila[4].'",claseRespuesta:"'.$fila[8].'",presentarRespuesta:"'.$fila[13].'",incluirValorNoAplica:"'.$fila[14].'",
				ponderacionElementosHijos:"'.$fila[12].'",idElemento:"'.$fila[0].'",prefijo:"'.$fila[11].'",titulo:"'.cv($fila[1]).'",orden:"'.$fila[6].'",clase:"'.$fila[7].'",valorSeccion:"'.$fila[5].'",codigoUnidad:"'.$fila[10].'",id:"p_'.$fila[0].'",text:"'.$prefijo.$fila[1].'","tipoElemento":"'.$fila[2].'"';
			$cadHijos=obtenerElementosCuestionarioHijos($fila[10]);
			$comp="";
			if($cadHijos=="[]")
				$comp=',leaf:true';
			else
				$comp=',leaf:false,children:'.$cadHijos.'';
			$obj.=$comp."}";	
			if($cadElementos=="")
				$cadElementos=$obj;
			else
				$cadElementos.=",".$obj;
		}
		return "[".$cadElementos."]";
	}
	
	function guardarCuestionario()
	{
		global $con;
		$idCuestionario=$_POST["idCuestionario"];
		$titulo=$_POST["titulo"];
		$nombre=$_POST["nombre"];
		$descripcion=$_POST["descripcion"];
		$ponderacionHijos=$_POST["ponderacionHijos"];
		$mostrarPuntajeObtenido=$_POST["mostrarPuntaje"];
		$escala=$_POST["escala"];
		$solicitaComentarios=$_POST["solicitaComentarios"];
		$tipoCuestionario=$_POST["tipoCuestionario"];
		$idEscalaCategoriaPreguntas=$_POST["idEscalaCategoriaPreguntas"];
		
		if($idCuestionario=="-1")
			$consulta="insert 9051_cuestionarios (idEscalaCategoriaPreguntas,tipoCuestionario,nombreCuestionario,descripcion,fechaCreacion,idUsuario,tituloCuestionario,tipoPonderacionElementosHijos,escalaEvaluacionFinal,solicitarComentariosFinales,mostrarPuntajeObtenido) 
						values(".$idEscalaCategoriaPreguntas.",".$tipoCuestionario.",'".cv($nombre)."','".cv($descripcion)."','".date('Y-m-d H:i')."',".$_SESSION["idUsr"].",'".cv($titulo)."',".$ponderacionHijos.",".$escala.",".$solicitaComentarios.",".$mostrarPuntajeObtenido.")";
		else
			$consulta="update 9051_cuestionarios set idEscalaCategoriaPreguntas=".$idEscalaCategoriaPreguntas.",tipoCuestionario=".$tipoCuestionario.",mostrarPuntajeObtenido=".$mostrarPuntajeObtenido.",nombreCuestionario='".cv($nombre)."',descripcion='".cv($descripcion)."',tituloCuestionario='".cv($titulo).
					"', tipoPonderacionElementosHijos=".$ponderacionHijos.",escalaEvaluacionFinal=".$escala.",solicitarComentariosFinales=".$solicitaComentarios." where idCuestionario=".$idCuestionario;
		
		if($con->ejecutarConsulta($consulta))
		{
			if($idCuestionario=='-1')
				$idCuestionario=$con->obtenerUltimoID();
			echo "1|".$idCuestionario;
					
		}
	}
	
	function guardarElementoCuestionario()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$tRespuesta="NULL";
		$idReferenciaResp="NULL";
		if(isset($obj->tRespuesta))
		{
			$tRespuesta=$obj->tRespuesta;
			$idReferenciaResp=$obj->idReferenciaResp;
		}
		$claseRespuesta="NULL";
		if(isset($obj->claseRespuesta))
		{
			$claseRespuesta=$obj->claseRespuesta;
		}
		$ponderacionElementos="NULL";
		if(isset($obj->ponderacionElementos))
			$ponderacionElementos=$obj->ponderacionElementos;
		$presentaRespuesta="NULL";
		if(isset($obj->presentaRespuesta))
			$presentaRespuesta=$obj->presentaRespuesta;
			
		$valorNoaplica="NULL";
		if(isset($obj->valorNoaplica))
			$valorNoaplica=$obj->valorNoaplica;
		$codigoUnidad="";
		
		
		$campoEtiqueta="";
		if(isset($obj->campoEtiqueta))
			$campoEtiqueta=$obj->campoEtiqueta;
		$campoID="";
		if(isset($obj->campoID))
			$campoID=$obj->campoID;
		$campoValor="";
		if(isset($obj->campoValor))
			$campoValor=$obj->campoValor;
			
		if($obj->idElemento==-1)
		{
			$consulta[$x]="update 9052_elementosCuestionario set ordenElemento=ordenElemento+1 where codigoPadre='".$obj->codigoPadre."' and ordenElemento>=".$obj->orden;
			$x++;
			$query="SELECT MAX(codigoUnidad) FROM 9052_elementosCuestionario WHERE codigoPadre='".$obj->codigoPadre."'";
			$valorUnidad=$con->obtenerValor($query);
			$codigoIndividual="";
			if($valorUnidad=="")
				$codigoIndividual="0001";
			else
			{
				$codigoIndividual=substr($valorUnidad,-4);
				$codigoIndividual++;
				$codigoIndividual=str_pad($codigoIndividual,4,"0",STR_PAD_LEFT);
			}
			$codigoUnidad=$obj->codigoPadre.$codigoIndividual;
			$consulta[$x]="INSERT INTO 9052_elementosCuestionario(texto,tipoElemento,tipoRespuesta,idReferenciaRespuesta,valorSeccion,
							ordenElemento,claseTexto,claseRespuesta,codigoPadre,codigoUnidad,numeracion,ponderacionElementosHijos,presentarRespuesta,incluirValorNoAplica,
							campoTextoRespuesta,campoIdRespuesta,campoValorRespuesta)
							VALUES('".cv($obj->texto)."',".$obj->tipoElemento.",".$tRespuesta.",".$idReferenciaResp.",".$obj->valorSeccion.
							",".$obj->orden.",".$obj->clase.",".$claseRespuesta.",'".$obj->codigoPadre."','".$codigoUnidad."','".$obj->prefijo."',
							".$ponderacionElementos.",".$presentaRespuesta.",".$valorNoaplica.",'".$campoEtiqueta."','".$campoID."','".$campoValor."')";
			$x++;
		}
		else
		{
			$query="select ordenElemento from 9052_elementosCuestionario where idElementoCuestionario=".$obj->idElemento;
			$ordenE=$con->obtenerValor($query);
			
			if($ordenE!=$obj->orden)
			{
				$consulta[$x]="update 9052_elementosCuestionario set ordenElemento=ordenElemento+1 where codigoPadre='".$obj->codigoPadre."' and ordenElemento>=".$obj->orden." and ordenElemento<".$ordenE;
				$x++;
			}
			else
			{
				$consulta[$x]="update 9052_elementosCuestionario set ordenElemento=ordenElemento-1 where codigoPadre='".$obj->codigoPadre."' and ordenElemento<=".$obj->orden." and ordenElemento>".$ordenE;
				$x++;
			}
			
			$consulta[$x]="update 9052_elementosCuestionario set texto='".cv($obj->texto)."',tipoRespuesta=".$tRespuesta.",idReferenciaRespuesta=".$idReferenciaResp.
						",valorSeccion=".$obj->valorSeccion.",ordenElemento=".$obj->orden.",claseTexto=".$obj->clase.",claseRespuesta=".$claseRespuesta.
						",numeracion='".$obj->prefijo."',ponderacionElementosHijos=".$ponderacionElementos.",presentarRespuesta=".$presentaRespuesta.
						",incluirValorNoAplica=".$valorNoaplica.",campoTextoRespuesta='".$campoEtiqueta."',campoIdRespuesta='".$campoID."',campoValorRespuesta='".$campoValor."' where idElementoCuestionario=".$obj->idElemento;
			$x++;
		}
		
		
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function removerElementoCuestionario()
	{
		global $con;
		$idElemento=$_POST["idElemento"];
		$query="select * from 9052_elementosCuestionario where idElementoCuestionario=".$idElemento;
		$fElemento=$con->obtenerPrimeraFila($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 9052_elementosCuestionario set ordenElemento=ordenElemento-1 where codigoPadre='".$fElemento[9]."' and ordenElemento>".$fElemento[6];
		$x++;
		$consulta[$x]="delete from  9052_elementosCuestionario where idElementoCuestionario=".$idElemento;
		$x++;
		$consulta[$x]="delete from  9052_elementosCuestionario where codigoPadre like '".$fElemento[10]."%'";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarRespuestaCuestionario()
	{
		global $con;
		$esEvaluacionComite=$_POST["esEvaluacionComite"];
		$guardadoParcial=$_POST["guardadoParcial"];
		$cadObj=$_POST["cadObj"];
		
		$idUsuario=$_SESSION["idUsr"];
		if(isset($_POST["idUsuario"]))
			$idUsuario=$_POST["idUsuario"];
		
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		if($obj->idRegistro==-1)
		{
			$consulta[$x]="INSERT INTO 9053_resultadoCuestionario(idCuestionario,idReferencia1,idReferencia2,fechaRegistro,responsableRegistro,calificacionFinal,dictamen,comentariosFinales,situacion)
						VALUES(".$obj->idCuestionario.",".$obj->idReferencia1.",".$obj->idReferencia2.",'".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$obj->puntajeTotal.",".$obj->dictamen.",'".cv($obj->comentariosFinales)."',1)";
			$x++;	
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;					
		}
		else
		{
			$consulta[$x]="update 9053_resultadoCuestionario set  calificacionFinal=".$obj->puntajeTotal.",dictamen=".$obj->dictamen.",comentariosFinales='".cv($obj->comentariosFinales)."' where idRegistroCuestionario=".$obj->idRegistro;
			$x++;	
			$consulta[$x]="set @idRegistro:=".$obj->idRegistro;
			$x++;
		}
		
		$consulta[$x]="delete from 9054_respuestasCuestionario where idReferencia=@idRegistro";
		$x++;
		foreach($obj->arrRespuestas as $r)
		{
			
			
			if($r->valorTexto!="(null)")
				$r->valorTexto="'".cv($r->valorTexto)."'";
				
			
			$consulta[$x]="INSERT INTO 9054_respuestasCuestionario(idReferencia,idElemento,valorRespuesta,idRespuesta,valorRespuestaTexto) VALUES(@idRegistro,".$r->idElemento.",'".$r->valor."',".$r->idOpcion.",".($r->valorTexto).")";
			$x++;
		}
		if($guardadoParcial==0)
		{
			
			if($esEvaluacionComite==0)
			{
				/*if(existeRol("'1_0'"))
				{
					
					$query="SELECT idUsuarioVSProyecto FROM 1011_asignacionRevisoresProyectos WHERE  
							idFormulario=".$obj->idReferencia1."  AND idProyecto=".$obj->idReferencia2." and situacion=1 limit 0,1";
					$idRef=$con->obtenerValor($query);
					if($idRef=="")
						$idRef=-1;
					$consulta[$x]="UPDATE 1011_asignacionRevisoresProyectos SET situacion=2,fechaEvaluacion='".date("Y-m-d H:i")."',idReferencia=@idRegistro,idCuestionarioEval=".$obj->idCuestionario.",tipoCuestionario=1 
								WHERE idUsuarioVSProyecto=".$idRef;
					$x++;
				}
				else*/
				{
					$situacion=2;
					if(($obj->puntajeTotal<82)&&($idUsuario<>1585))
					{
						$query="SELECT inconsistencia,codigo FROM _546_tablaDinamica WHERE id__546_tablaDinamica=".$obj->idReferencia2;
						
						$fProyecto=$con->obtenerPrimeraFila($query);
						$inconsistencia=$fProyecto[0];
						if($inconsistencia!=0)
						{
							
							$query="select Nombre from 800_usuarios where idUsuario=".$_SESSION["idUsr"];
							$nRevisor=$con->obtenerValor($query);
							
							$arrAchivos=NULL;
							$arrCC=NULL;
							$cuerpoMail="Se ha evaluado el proyecto <b>".$fProyecto[1]."</b> por <b>".$nRevisor."</b> con una calificación de: <b>".$obj->puntajeTotal."</b><br><br>";
							@enviarMail("reporteProyectos2016@gmail.com","Proyecto evaluado",$cuerpoMail,"soportesmap@censida.net","",$arrAchivos,$arrCC);
						}
						
						if($inconsistencia>0)
							$situacion=3;
						
					}
					$consulta[$x]="update 9053_resultadoCuestionario set  situacion=2 where idRegistroCuestionario=@idRegistro";
					$x++;	
					$consulta[$x]="UPDATE 1011_asignacionRevisoresProyectos SET situacion=".$situacion.",fechaEvaluacion='".date("Y-m-d H:i")."',idReferencia=@idRegistro,idCuestionarioEval=".$obj->idCuestionario.",tipoCuestionario=1 
								WHERE idFormulario=".$obj->idReferencia1." AND idUsuario=".$idUsuario." AND idProyecto=".$obj->idReferencia2;
					$x++;
				}
			}
			else
			{
				$situacion=2;
				if(($obj->puntajeTotal<82)&&($idUsuario<>1585))
				{
					$query="SELECT inconsistencia,codigo FROM _546_tablaDinamica WHERE id__546_tablaDinamica=".$obj->idReferencia2;
					
					$fProyecto=$con->obtenerPrimeraFila($query);
					$inconsistencia=$fProyecto[0];
					if($inconsistencia!=0)
					{
						
						$query="select Nombre from 800_usuarios where idUsuario=".$_SESSION["idUsr"];
						$nRevisor=$con->obtenerValor($query);
						
						$arrAchivos=NULL;
						$arrCC=NULL;
						$cuerpoMail="Se ha evaluado el proyecto <b>".$fProyecto[1]."</b> por <b>".$nRevisor."</b> con una calificación de: <b>".$obj->puntajeTotal."</b><br><br>";
						@enviarMail("reporteProyectos2016@gmail.com","Proyecto evaluado",$cuerpoMail,"soportesmap@censida.net","",$arrAchivos,$arrCC);
					}
					
					if($inconsistencia>0)
							$situacion=3;
					
				}
								
				$consulta[$x]="UPDATE 1011_asignacionRevisoresProyectos SET situacion=".$situacion.",fechaEvaluacion='".date("Y-m-d H:i")."',idReferencia=@idRegistro,idCuestionarioEval=".$obj->idCuestionario.",tipoCuestionario=1 
							WHERE idFormulario=".$obj->idReferencia1." and idProyecto=".$obj->idReferencia2." and esEvaluacionComite=1";
				$x++;
				
				$query="SELECT COUNT(*) FROM 1011_asignacionRevisoresProyectos WHERE idFormulario=".$obj->idReferencia1." AND idProyecto=".$obj->idReferencia2." AND situacion=2 and esEvaluacionComite=0";
				$nReg=$con->obtenerValor($query);
				$evaluacionesFaltantes=5-$nReg;

				switch($evaluacionesFaltantes)
				{
					case 0:
					
					break;	
					case 1:
					case 2:
					case 3:
						$query="SELECT * FROM 1011_asignacionRevisoresProyectos WHERE idFormulario=".$obj->idReferencia1." AND idProyecto=".$obj->idReferencia2." AND situacion=1 AND esEvaluacionComite=0 limit 0,1";
						$fila=$con->obtenerPrimeraFila($query);
						
						
						$consulta[$x]="UPDATE 1011_asignacionRevisoresProyectos SET idUsuario=".$_SESSION["idUsr"].",situacion=2,fechaEvaluacion='".date("Y-m-d H:i")."',
								idReferencia=@idRegistro,idCuestionarioEval=".$obj->idCuestionario.",tipoCuestionario=1 ,idEvaluadorOriginal=".$fila[1]." WHERE idUsuarioVSProyecto=".$fila[0];
						
						$x++;
						
						
						
					break;
					
				}
				
				
			}
			
			
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idRegistro";
			$idReg=$con->obtenerValor($query);
			echo "1|".$idReg;
		}
		
	}
	
	function actualizarSituacionRevisores()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idReferencia=$_POST["idReferencia"];
		$idCuestionarioEval=$_POST["idCuestionario"];
		$tipoCuestionario=$_POST["tipoCuestionario"];
		$consulta="UPDATE 1011_asignacionRevisoresProyectos SET situacion=2,fechaEvaluacion='".date("Y-m-d H:i")."',idReferencia=".$idReferencia.",idCuestionarioEval=".$idCuestionarioEval.",tipoCuestionario=".$tipoCuestionario." 
					WHERE idFormulario=".$idFormulario." AND idUsuario=".$_SESSION["idUsr"]." AND idProyecto=".$idRegistro;
		eC($consulta);
	}
	
	
	function obtenerCamposTablaSistema()
	{
		global $con	;
		$tabla=bD($_POST["t"]);
		$idConexionAlmacen=0;
		$conAux=$con;
		
		
		if(isset($_POST["idConexionAlmacen"]))
			$idConexionAlmacen=$_POST["idConexionAlmacen"];
		if($idConexionAlmacen!=0)
			$conAux=generarInstanciaConector($idConexionAlmacen);
		
		echo "1|".$conAux->obtenerCamposTabla($tabla,false,true,false);
	}
	
	function obtenerOpcionesCampoTabla()
	{
		global $con;
		$campo=bD($_POST["c"]);
		$tabla=bD($_POST["t"]);
		$idConexionAlmacen=0;
		$conAux=$con;
		if(isset($_POST["idConexionAlmacen"]))
			$idConexionAlmacen=$_POST["idConexionAlmacen"];
		if($idConexionAlmacen!=0)
			$conAux=generarInstanciaConector($idConexionAlmacen);
		echo "1|".$conAux->obtenerListaValoresCampoTabla($campo,$tabla);
	}
	
	function obtenerValoresTablaSistema()
	{
		global $con;
		$nTabla=bD($_POST["t"]);
		$idTabla=bD($_POST["i"]);
		$etiqueta=bD($_POST["e"]);
		$idConexionAlmacen=0;
		$conAux=$con;
		
		
		if(isset($_POST["idConexionAlmacen"]))
			$idConexionAlmacen=$_POST["idConexionAlmacen"];
		if($idConexionAlmacen!=0)
			$conAux=generarInstanciaConector($idConexionAlmacen);
		echo "1|".$conAux->obtenerValoresTabla($nTabla,$idTabla,$etiqueta);
		
		
	}

	function obtenerEstilosSistema()
	{
		global $con;
		$ct=0;
		$arrReg="";
		$consulta="SELECT idEstilo,nombreEstilo,CONCAT(a.Paterno,' ',a.Materno,' ',a.Nom) AS responsableCreacion,fechaCreacion FROM 932_estilos e,802_identifica a WHERE  a.idUsuario=e.responsable ORDER BY nombreEstilo";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$definicion='.'.$fila[1].'{';
			$consulta="SELECT propiedadCss,valor FROM 933_elementosEstilo WHERE idEstilo=".$fila[0];
			$resEstilo=$con->obtenerFilas($consulta);
			while($fEstilo=mysql_fetch_row($resEstilo))
			{
				$definicion.=$fEstilo[0].":".$fEstilo[1].";";
			}
			$definicion.="}";
			$obj='{"idEstilo":"'.$fila[0].'","nombreEstilo":"'.$fila[1].'","responsableCreacion":"'.$fila[2].'","fechaCreacion":"'.$fila[3].'","definicionEstilo":"'.cv($definicion).'"}';
			if($arrReg=="")
				$arrReg=$obj;
			else
				$arrReg.=",".$obj;
			$ct++;
		}
		//$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$ct.'","registros":['.$arrReg.']}';
	}
	
	function removerEstilo()
	{
		global $con;
		$idEstilo=$_POST["idEstilo"];
		
		$consulta="select nombreEstilo from 932_estilos where idEstilo=".$idEstilo;
		$nombreEstilo=$con->obtenerValor($consulta);
		
		$nRegistros=0;
		$consulta="SELECT count(*) FROM 904_configuracionElemFormulario WHERE campoConf12='".$nombreEstilo."'";
		$nRegistros+=$con->obtenerValor($consulta);
		$consulta="SELECT * FROM 938_configuracionElemVistaFormulario WHERE campoConf12='".$nombreEstilo."'";
		$nRegistros+=$con->obtenerValor($consulta);
		$consulta="SELECT * FROM 9012_configuracionElemReporteThot WHERE campoConf12='".$nombreEstilo."'";
		$nRegistros+=$con->obtenerValor($consulta);
		if($nRegistros>0)
		{
			echo "<br>El estilo est&aacute; siendo refererido/utilizado";
			return;			
		}
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 932_estilos where idEstilo=".$idEstilo;
		$x++;
		$query[$x]="delete from 933_elementosEstilo where idEstilo=".$idEstilo;
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function guardarPropiedadesGrafico()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$idGrafico=$_POST["idGrafico"];
		$consulta="update 9012_configuracionElemReporteThot SET campoConf7='".cv($cadObj)."' WHERE idElemReporte=".$idGrafico;
		eC($consulta);
		
	}
	
	function obtenerRespuestaPreguntasCuestionario()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);

		$arrRegistros="";
		switch($obj->tipo)
		{
			case 0: //Escala evaluación
				$consulta="SELECT idElementoEscala,etiqueta FROM 4033_elementosEscala WHERE idEscalaCalificacion=".$obj->idValor." ORDER BY valorMinimo";
				$res=$con->obtenerFilas($consulta);	
				while($fila=mysql_fetch_row($res))
				{
					$consulta="SELECT valorRespuesta FROM 9059_respuestasCorrectasCuestionario WHERE idPregunta=".$obj->idPregunta." AND respuesta='".$fila[0]."'";
					$valor=$con->obtenerValor($consulta);
					
					$o="['".$fila[0]."','".cv($fila[1])."','".$valor."']";
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
				}
				
			
			break;
			case 1: //Almacén de datos
				$oRes=resolverConsulta($obj->idAlmacen,"",true,false,true);
				if($oRes["ejecutado"]==1)
				{
					$res=$oRes["resultado"];
					while($fila=mysql_fetch_assoc($res))
					{
					
						$consulta="SELECT valorRespuesta FROM 9059_respuestasCorrectasCuestionario WHERE idPregunta=".$obj->idPregunta." AND respuesta='".$fila[normalizarNombreCampo($obj->idRespuesta)]."'";

						$valor=$con->obtenerValor($consulta);
						
						$o="['".cv(isset($fila[normalizarNombreCampo($obj->idRespuesta)])?$fila[normalizarNombreCampo($obj->idRespuesta)]:'').
							"','".cv(isset($fila[normalizarNombreCampo($obj->campoEtiqueta)])?$fila[normalizarNombreCampo($obj->campoEtiqueta)]:'')."','".$valor."']";
						if($arrRegistros=="")
							$arrRegistros=$o;
						else
							$arrRegistros.=",".$o;
					}
						
				}
				
				
				
				

			break;
			case 2:  //Valores manuales
				$consulta="SELECT idRegistro,etiqueta FROM 9058_respuestasCuestionario WHERE idPregunta=".$obj->idValor." ORDER BY idRegistro";
				$res=$con->obtenerFilas($consulta);	
				while($fila=mysql_fetch_row($res))
				{
					$consulta="SELECT valorRespuesta FROM 9059_respuestasCorrectasCuestionario WHERE idPregunta=".$obj->idPregunta." AND respuesta='".$fila[0]."'";
					$valor=$con->obtenerValor($consulta);
					
					$o="['".$fila[0]."','".cv($fila[1])."','".$valor."']";
					if($arrRegistros=="")
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
				}
			break;
		}
		
		
		echo "1|[".$arrRegistros."]";
	}
?>