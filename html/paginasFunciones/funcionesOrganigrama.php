<?php session_start();
	include("conexionBD.php");
	include_once("funcionesActores.php");
	$parametros="";
	$lPorcionCodFun=4; //cambar tambien en funciones proyectos
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
		case "21":
			obtenerOrganigrama();
		break;
		case "22":
			crearUnidad();
		break;
		case "23":
			eliminarUnidad();
		break;
		case "24":
			modificarUnidad();
		break;
		case 25:
			if($tipoOrganigrama==0)
				obtenerOrganigramaUsuario();
			else
				obtenerOrganigramaUsuarioOrg2();
		break;
		case 26:
		
			asignarCodigoUnidadUsuario();
		break;
		case 27:
			obtenerDatosInstitucion();
		break;
		case 28:
			obtenerPuestos();
		break;
		case 29:
			guardarPuesto();
		break;
		case 30:
			eliminarPuesto();
		break;
		case 31:
			modificarPuesto();
		break;
		case 32:
			obtenerAreasUsuario();
		break;
		case 33:
			crearInstitucionOrg2();
		break;
		case 34:
			crearAreaDepto2();
		break;
		case 35:
			obtenerOrganigramaOrg2();
		break;
		case 36:
			guardarTabulacion();
		break;
		case 37:
			obtenerTabulaciones();
		break;
		case 38:
			removerTabulacion();
		break;
		case 39:
			existeCodTabulacion();
		break;
		case 40:
			obtenerPuestosInstitucion();
		break;
		case 41:
			obtenerPuestosDisponibles();
		break;
		case 42:
			asignarPuestoUnidad();
		break;
		case 43:
			obtenerPuestosUnidad();
		break;
		case 44:
			removerPuestoDepto();
		break;
		case 45:
			obtenerPuestosDisponiblesAdscripcion();	
		break;
		case 46:
			obtenerQuincena();
		break;
		case 47:
			asignarPuestoEmpleado();
		break;
		case 48:
			bajaPuestoEmpleado();
		break;
		case 49:
			agregarConceptoNomina();
		break;
		case 50:
			agregarAfectacionNomina();
		break;
		case 51:
			modificarTipoAfectacionNomina();
		break;
		case 52:
			modificarQuincenasAfectacion();
		break;
		case  53:
			obtenerConceptosDisponibles();
		break;
		case 54:
			modificarPuestoEmpleado();
		break;
		case 55:
			guardarCuentaBancaria();
		break;
		case 56:
			eliminarCuentaBancaria();
		break;
		case 57:
			obtenerCalculosDisponiblesNomina();
		break;
		case 58:
			guardarValorParametroNomina();
		break;
		case 59:
			modificarOrdenCalculo();
		break;
		case 60:
			obtenerElementosPais();
		break;
		case 61:
			activarDesactivarUnidad();
		break;
		case 62:
			obtenerPuestosAsocCalculo();
		break;
		case 63:
			obtenerPuestosDisponiblesAsocCalculo();
		break;
		case 64:
			crearUnidadProcesoInscripcion();
		break;
		case 65:
			seleccionarTodoTipoContratacion();
		break;
		case 66:
			obtenerResponsablesUnidad();
		break;
		case 67:
			removerResponsableUnidad();
		break;
		case 68:
			agregarResponsableUnidad();
		break;
		case 69:
			obtenerElementosPaisV2();
		break;
		case 70:
			obtenerOrganigramaAdscripcion();
		break;
		case 71:
			obtenerIDRegistroNodoOrganigrama();
		break;
		case 72:
			obtenerMunicipiosOrganigrama();
		break;
				
	}
	
	function obtenerOrganigrama()
	{
		global $con;
		$comp="";
		if(!isset($_POST["organigramaInst"]))
		{	
			$consulta="select codigoFuncionalRaiz from 903_variablesSistema";
			$codFun=$con->obtenerValor($consulta);
			
			$codFun=str_pad($_SESSION["codigoInstitucion"],strlen($codFun),'0',STR_PAD_RIGHT);
			$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto from 817_organigrama where codigoFuncional='".$codFun."' order by codigoFuncional";
		
		}
		else
		{
			$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto from 817_organigrama where institucion=1 order by  codigoFuncional";
		}
		$resOrg=$con->obtenerFilas($consulta);	
		$arrUnidades="";
		while($fila=mysql_fetch_row($resOrg))
		{
			$codFun=$fila[3];
			$codigoF=$fila[3];
			if($fila[5]=="1")
			{
				$texto=cvJs("<font color='blue'>".$fila[0]."</font>");
				$consulta="select idOrganigrama,cp,ciudad,estado,p.nombre from 247_instituciones i,238_paises p where p.idPais=i.idPais and i.idOrganigrama=".$fila[2];
				$filaD=$con->obtenerPrimeraFila($consulta);
				$desc="";
				$cp=$filaD[1];
				$ciudad=$filaD[2];
				$estado=$filaD[3];
				$pais=$filaD[4];
				if($cp!="")
					$cp=" C.P. ".$cp.".";
				$desc="<br>(".$ciudad.", ".$estado.", ".$pais.".".$cp.")";
			}
			else
			{
				$texto=cvJs($fila[0]);
				$desc="";
			}
			$consulta="	select concat(tipoTel,'_',codArea,'_',lada,'_',telefono,'_',extension) as telefono from 818_telefonosOrganigrama where idOrganigrama=".$fila[2];
			$telefonos=$con->obtenerListaValores($consulta);			
			$consulta="select tituloCentroC from 506_centrosCosto where codigoCompleto='".$fila[6]."'";
			$cc=$con->obtenerValor($consulta);
	
			$objUnidad='{id:"'.$fila[2].'",text:"'.$texto.'",CC:"'.$fila[6].'",CCDescrip:"'.$cc.'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",desc:"'.$desc.'",uiProvider:"col","telefonos":"'.$telefonos.'","descTel":""';
			$hijos='';
			$hijos=obtenerUnidadesHijas($fila[1],strlen($codFun));																								  
			if($hijos=='')
				$objUnidad.=',leaf:true,icon:"../images/users.png"}';
			else
				$objUnidad.=',children:['.$hijos.'],icon:"../images/user.png"}';
			if($arrUnidades=="")
				$arrUnidades=$objUnidad;
			else
				$arrUnidades.=",".$objUnidad;
		}		
		echo "[".uEJ($arrUnidades)."]";
	}
	
	function obtenerUnidadesHijas($codigoFun,$tamCodigo)
	{
		global $con;
		global $lPorcionCodFun;
		if(strlen($codigoFun)==$tamCodigo)
			return "";
		$cadComodines=str_pad("",$lPorcionCodFun,'_',STR_PAD_LEFT);
		$codigoBusqueda=$codigoFun.$cadComodines;
		$codigoBusqueda=str_pad($codigoBusqueda,$tamCodigo,'0',STR_PAD_RIGHT);
		$codigoPadre=str_pad($codigoFun,$tamCodigo,'0',STR_PAD_RIGHT);
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto from 817_organigrama where codigoFuncional like '".$codigoBusqueda."' and codigoFuncional<>'".$codigoPadre."' order by codigoFuncional";
		$res=$con->obtenerFilas($consulta);
		$arrHijos="";
		$objHijo="";
		$hijos="";
		while($fila=mysql_fetch_row($res))
		{
			$codigoF=$fila[3];
			if($fila[5]=="1")
			{
				$texto=cvJs("<font color='blue'>".$fila[0]."</font>");
				$consulta="select idOrganigrama,cp,ciudad,estado,p.nombre from 247_instituciones i,238_paises p where p.idPais=i.idPais and i.idOrganigrama=".$fila[2];
				$filaD=$con->obtenerPrimeraFila($consulta);
				$desc="";
				$cp=$filaD[1];
				$ciudad=$filaD[2];
				$estado=$filaD[3];
				$pais=$filaD[4];
				if($cp!="")
					$cp=" C.P. ".$cp.".";
				$desc="<br>(".$ciudad.", ".$estado.", ".$pais.".".$cp.")";
				
			}
			else
			{
				$texto=cvJs($fila[0]);
				$desc="";
			}
			$consulta="	select tipoTel,codArea,lada,telefono,extension from 818_telefonosOrganigrama where idOrganigrama=".$fila[2];
			$resTel=$con->obtenerFilas($consulta);	
			$descTel="";
			$arrTel="";
			while($filaTel=mysql_fetch_row($resTel))
			{
				$tipoTel="";
				switch($filaTel[0])
				{
					case 0:
						$tipoTel='Tel\u00E9fono';	
					break;
					case 2:
						$tipoTel='Fax';
					break;
				}
				$extension="";
				if($filaTel[4]!="")
					$extension="Ext.: ".$filaTel[4];
				
				$tel="[".$tipoTel."] (".$filaTel[1].") ".$filaTel[2]."-".$filaTel[3]." (".$extension.")";
				if($descTel=="")
					$descTel=$tel;
				else
					$descTel.="<br>".$tel;
				$telCod=$filaTel[0]."_".$filaTel[1]."_".$filaTel[2]."_".$filaTel[3]."_".$filaTel[4];
				
				if($arrTel=="")
					$arrTel=$telCod;
				else
					$arrTel.=",".$telCod;
			}
			
			$consulta="select tituloCentroC from 506_centrosCosto where codigoCompleto='".$fila[6]."'";
			$cc=$con->obtenerValor($consulta);
			
			$objHijo='{id:"'.$fila[2].'",text:"'.$texto.'",CC:"'.$fila[6].'",CCDescrip:"'.$cc.'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",desc:"'.$desc.'",uiProvider:"col","telefonos":"'.$arrTel.'","descTel":"'.$descTel.'"';
			$hijos=obtenerUnidadesHijas($fila[1],$tamCodigo);
			if($hijos=='')
				$objHijo.=',leaf:true,icon:"../images/users.png"}';
			else
				$objHijo.=',children:['.$hijos.'],icon:"../images/user.png"}';
			if($arrHijos=='')
				$arrHijos=$objHijo;
			else
				$arrHijos.=",".$objHijo;
		}
		return $arrHijos;
	}
	
	function crearUnidad()
	{
		global $con;
		global $lPorcionCodFun;
		$cadObj=$_POST["param"];
		$obj=json_decode($cadObj);
		$codigoUPadre=$obj->codigoUPadre;

		$tamUnidad=4;
		
		$codUnidad="";
		if(isset($obj->codUnidad))
			$codUnidad=$obj->codUnidad;
		
		$telefonos="";
		if(isset($obj->telefonos))
		{
			$telefonos=$obj->telefonos;
		}
		
		$idUsuario="-1000";
		if(isset($_SESSION["idUsr"]))
			$idUsuario=$_SESSION["idUsr"];
		
		$query="select codigoFuncional from 817_organigrama where codigoUnidad='".$codigoUPadre."'";
		$codigoF=$con->obtenerValor($query);
		$codigoFuncionalNuevo="";
		$codigoUnidadNuevo="";
		$x=0;
		$cadComodines=str_pad("",$lPorcionCodFun,'_',STR_PAD_LEFT);
		$codigoInicial=str_pad("1",$lPorcionCodFun,'0',STR_PAD_LEFT);
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			if($codUnidad=="")
			{
				
				$query="SELECT max(codigoUnidad) FROM 817_organigrama WHERE unidadPadre='".$codigoUPadre."'";

				$res=$con->obtenerValor($query);
				if($res!="")
				{
					$res++;
					$numUnidades=parteEntera(strlen($res)/$tamUnidad);

					if((sizeof($res)%$tamUnidad)!=0)
					{
						$numUnidades++;
					}
					
					$codigoUnidadNuevo=str_pad($res,($tamUnidad*$numUnidades),'0',STR_PAD_LEFT);
				}
				else
				{
					$valor=1;	
					$codigoFuncionalNuevo=str_pad($valor,$tamUnidad,'0',STR_PAD_LEFT);
					$codigoUnidadNuevo=$codigoUPadre.$codigoFuncionalNuevo;
				}
				
				$codigoIndividual=substr($codigoUnidadNuevo,strlen($codigoUnidadNuevo)-$tamUnidad);
				
				$codCC="";
				if(isset($obj->CC))
					$codCC=$obj->CC;
				
				$query="insert into 817_organigrama(unidad,codigoFuncional,codigoUnidad,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual) 
						value('".cv($obj->nombre)."','".$codigoUnidadNuevo."','".$codigoUnidadNuevo."','".cv($obj->descripcion)."',".$obj->institucion.",'".$codCC."','".$codigoUPadre."','".$codigoIndividual."')";
				if($con->ejecutarConsulta($query))		
				{
					$idOrganigrama=$con->obtenerUltimoID();
					if(isset($obj->objInst))
					{
						$objInst=$obj->objInst;
						$consulta[$x]="insert into 247_instituciones(idOrganigrama,cp,ciudad,estado,idPais,fechaCreacion,responsable) values
						('".$idOrganigrama."','".cv($objInst->cp)."','".cv($objInst->ciudad)."','".cv($objInst->estado)."',".cv($objInst->idPais).",'".date("Y-m-d")."',".$idUsuario.")";
						$x++;	
					}
					
					if($telefonos!="")
					{
						$arrTelefonos=explode(",",$telefonos);
						$nTel=sizeof($arrTelefonos);
						for($y=0;$y<$nTel;$y++)
						{
							$datosTel=explode("_",$arrTelefonos[$y]);
							$tipo=$datosTel[0];
							$codArea=$datosTel[1];
							$lada=$datosTel[2];
							$tel=$datosTel[3];
							$ext=$datosTel[4];
							$consulta[$x]="	insert into 818_telefonosOrganigrama(codArea,lada,telefono,extension,tipoTel,idOrganigrama) 
											values('".$codArea."','".$lada."','".$tel."','".$ext."',".$tipo.",".$idOrganigrama.")";
							$x++;	
						}
					}
					$consulta[$x]="commit";
					$x++;
					if($con->ejecutarBloque($consulta))
						echo "1|".$idOrganigrama."|".$codigoUnidadNuevo;
					else
						echo "|";
				}
			}
			else
			{
				$codCC="";
				if(isset($obj->CC))
					$codCC=$obj->CC;
				$x=0;
				$consulta[$x]="update 817_organigrama set unidad='".cv($obj->nombre)."', descripcion='".cv($obj->descripcion)."',codCentroCosto='".$codCC."' where codigoUnidad='".$codUnidad."'";
				$x++;
				$query="select idOrganigrama from 817_organigrama where codigoUnidad='".$codUnidad."'" ;
				$idOrganigrama=$con->obtenerValor($query);
				$consulta[$x]="	delete from 818_telefonosOrganigrama where idOrganigrama=".$idOrganigrama;
				$x++;		
				if($telefonos!="")
				{
					$arrTelefonos=explode(",",$telefonos);
					$nTel=sizeof($arrTelefonos);
					for($y=0;$y<$nTel;$y++)
					{
						$datosTel=explode("_",$arrTelefonos[$y]);
						$tipo=$datosTel[0];
						$codArea=$datosTel[1];
						$lada=$datosTel[2];
						$tel=$datosTel[3];
						$ext=$datosTel[4];
						$consulta[$x]="	insert into 818_telefonosOrganigrama(codArea,lada,telefono,extension,tipoTel,idOrganigrama) 
										values('".$codArea."','".$lada."','".$tel."','".$ext."',".$tipo.",".$idOrganigrama.")";
						$x++;										
							
					}
				}
				
				if(isset($obj->objInst))
				{
					$objInst=$obj->objInst;
					
					$consulta[$x]="update 247_instituciones set cp='".cv($objInst->cp)."',ciudad='".cv($objInst->ciudad)."',estado='".cv($objInst->estado)."',idPais=".$objInst->idPais." where idOrganigrama=".$idOrganigrama;
					$x++;
					$consulta[$x]="commit";
					if($con->ejecutarBloque($consulta))
						echo "1|".$idOrganigrama;
					else
						echo "|";
				}
				else
				{
					$consulta[$x]="commit";
					if($con->ejecutarBloque($consulta))
						echo "1|".$idOrganigrama;
					else
						echo "|";
				}
			}
		}
		else
			echo "|";
	}
	
	function eliminarUnidad()
	{
		global $con;
		$codU=$_POST["codUnidad"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$query="select institucion from 817_organigrama where codigoUnidad='".$codU."'";
		$institucion=$con->obtenerValor($query);
		
		$query="SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=".$institucion;
		$cadConf=$con->obtenerValor($query);
		
		if($cadConf!="")
		{
			$oConf=json_decode($cadConf);
			$idFormulario=obtenerFormularioBase($oConf->idProceso);
			$consulta[$x]="delete FROM _".$idFormulario."_tablaDinamica WHERE claveUnidad='".$codU."'";
			$x++;			
		}
		
		$consulta[$x]="insert into 817_historialOrganigrama(unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,cp,ciudad,estado,idPais,municipio,colonia,calle,numero,fechaModificacion,idResponsableModificacion,accion)
						select unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,cp,ciudad,estado,idPais,municipio,colonia,calle,numero,'".date('Y-m-d')."' as 'fechaModificacion', '".$_SESSION["idUsr"]."' as 'responsable','4' as accion 
						from 817_organigrama o,247_instituciones i  where i.idOrganigrama=o.idOrganigrama
						and o.codigoUnidad='".$codU."'";
						
		$x++;
		
		
		if(!isset($_POST["tipoOrg"]))
		{
			$consulta[$x]="delete from 817_organigrama where codigoFuncional like '".$codU."%'";
			$x++;
		}
		else
		{
			$consulta[$x]="delete from 817_organigrama where codigoUnidad = '".$codU."'";
			$x++;
			eliminarHijosOrg2($codU,$consulta,$x);
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarHijosOrg2($codUnidad,&$consulta,&$x)
	{
		global $con;
		$query="select codigoUnidad,institucion from 817_organigrama where unidadPadre='".$codUnidad."'";
		$resUnidad=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($resUnidad))
		{
			
			$query="SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=".$fila[1];
			$cadConf=$con->obtenerValor($query);
			
			if($cadConf!="")
			{
				$oConf=json_decode($cadConf);
				$idFormulario=obtenerFormularioBase($oConf->idProceso);
				$consulta[$x]="delete FROM _".$idFormulario."_tablaDinamica WHERE claveUnidad='".$fila[0]."'";
				$x++;			
			}
			
			$consulta[$x]="delete from 817_organigrama where codigoUnidad = '".$fila[0]."'";
			$x++;
			eliminarHijosOrg2($fila[0],$consulta,$x);
		}
		
	}
	
	function modificarUnidad()
	{
		global $con;
		$cadObj=$_POST["param"];
		$obj=json_decode($cadObj);
		$consulta="update 817_organigrama set unidad='".cv($obj->nombre)."',descripcion='".cv($obj->descripcion)."',institucion=".$obj->institucion." where codigoFuncional='".$obj->codigoFuncional."'";
		if($con->ejecutarConsulta($consulta))	
			echo "1|";
		else
			echo "|";
		
	}
	
	function obtenerOrganigramaUsuario()
	{
		global $con;
		$consulta="select codigoFuncionalRaiz from 903_variablesSistema";
		$codFun=$con->obtenerValor($consulta);
		$codigoI=$_POST["codigoInstitucion"];
		if($codigoI=='-1')
		{
			return "[]";
		}
		$codFun=str_pad($codigoI,strlen($codFun),'0',STR_PAD_RIGHT);
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion from 817_organigrama where codigoFuncional='".$codFun."' order by codigoFuncional";
		$fila=$con->obtenerPrimeraFila($consulta);	
		$codigoF=$fila[3];
		$arrUnidades='[{id:"'.$fila[2].'",text:"'.cvJs($fila[0]).'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",uiProvider:"col"';
		$hijos='';
		$hijos=obtenerUnidadesHijasUsuario($fila[1],strlen($codFun));																								  
		if($hijos=='')
			$arrUnidades.=',leaf:true,icon:"../images/users.png"}]';
		else
			$arrUnidades.=',children:['.$hijos.'],icon:"../images/user.png"}]';
		echo uEJ($arrUnidades);
	}
	
	function obtenerUnidadesHijasUsuario($codigoFun,$tamCodigo)
	{
		global $con;
		global $lPorcionCodFun;
		if(strlen($codigoFun)==$tamCodigo)
			return "";
		$cadComodines=str_pad("",$lPorcionCodFun,'_',STR_PAD_LEFT);
		$codigoBusqueda=$codigoFun.$cadComodines;
		$codigoBusqueda=str_pad($codigoBusqueda,$tamCodigo,'0',STR_PAD_RIGHT);
		$codigoPadre=str_pad($codigoFun,$tamCodigo,'0',STR_PAD_RIGHT);
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion from 817_organigrama where codigoFuncional like '".$codigoBusqueda."' and codigoFuncional<>'".$codigoPadre."' order by codigoFuncional";
		$res=$con->obtenerFilas($consulta);
		$arrHijos="";
		$objHijo="";
		$hijos="";
		while($fila=mysql_fetch_row($res))
		{
			$codigoF=$fila[3];
			$objHijo='{id:"'.$fila[2].'",text:"'.cvJs($fila[0]).'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",uiProvider:"col"';
			$hijos=obtenerUnidadesHijasUsuario($fila[1],$tamCodigo);
			if($hijos=='')
				$objHijo.=',leaf:true,icon:"../images/users.png"}';
			else
				$objHijo.=',children:['.$hijos.'],icon:"../images/user.png"}';
			if($arrHijos=='')
				$arrHijos=$objHijo;
			else
				$arrHijos.=",".$objHijo;
		}
		return $arrHijos;
	}
	
	function obtenerOrganigramaUsuarioOrg2()
	{
		global $con;
		$codigoI=$_POST["codigoInstitucion"];
		if($codigoI=='-1')
		{
			return "[]";
		}
		
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion from 817_organigrama where codigoUnidad='".$codigoI."' order by codigoFuncional";
		$fila=$con->obtenerPrimeraFila($consulta);	
		$codigoF=$fila[3];
		$arrUnidades='[{id:"'.$fila[2].'",text:"'.cvJs($fila[0]).'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",uiProvider:"col"';
		$hijos='';
		$hijos=obtenerUnidadesHijasUsuarioOrg2($fila[1]);																								  
		if($hijos=='')
			$arrUnidades.=',leaf:true,icon:"../images/users.png"}]';
		else
			$arrUnidades.=',children:['.$hijos.'],icon:"../images/user.png"}]';
		echo uEJ($arrUnidades);
	}
	
	function obtenerUnidadesHijasUsuarioOrg2($codigoFun)
	{
		global $con;
		
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion from 817_organigrama where unidadPadre = '".$codigoFun."' order by codigoFuncional";
		$res=$con->obtenerFilas($consulta);
		$arrHijos="";
		$objHijo="";
		$hijos="";
		while($fila=mysql_fetch_row($res))
		{
			$codigoF=$fila[3];
			$objHijo='{id:"'.$fila[2].'",text:"'.cvJs($fila[0]).'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",uiProvider:"col"';
			$hijos=obtenerUnidadesHijasUsuarioOrg2($fila[1]);
			if($hijos=='')
				$objHijo.=',leaf:true,icon:"../images/users.png"}';
			else
				$objHijo.=',children:['.$hijos.'],icon:"../images/user.png"}';
			if($arrHijos=='')
				$arrHijos=$objHijo;
			else
				$arrHijos.=",".$objHijo;
		}
		return $arrHijos;
	}
	
	function asignarCodigoUnidadUsuario()
	{
		global $con;
		$codigoU=$_POST["codigoU"];
		$idUsuario=$_POST["idUsuario"];
		$consulta="update 801_adscripcion set codigoUnidad='".$codigoU."' where idUsuario=".$idUsuario;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerDatosInstitucion()
	{
		global $con;
		global $SO;
		$consulta="";
		$idOrganigrama="";
		if(isset($_POST["codU"]))
		{
			$codU=$_POST["codU"];
			
			$consulta="select idOrganigrama from 817_organigrama o  where  o.codigoUnidad = '".$codU."'";
			$idOrganigrama=$con->obtenerValor($consulta);
			$consulta="select o.unidad as institucion,cp,ciudad,estado,idPais,municipio,colonia,calle,numero,o.codCentroCosto as 'centroCosto',o.idOrganigrama,
			 			'@telefonos'  as telefonos,'@descTel' as descTel,'@mails' as mails,codigoUnidad as codigoU,codigoDepto as codDepto,o.descripcion
						from 247_instituciones i,817_organigrama o  where o.idOrganigrama=i.idOrganigrama and o.codigoUnidad = '".$codU."'";
		}
		else
		{
			$idOrganigrama=$_POST["idOrganigrama"];
			$consulta="select o.unidad as institucion,cp,ciudad,estado,idPais,municipio,colonia,calle,numero,o.codCentroCosto as 'centroCosto',o.idOrganigrama,
						'@telefonos'  as telefonos,'@descTel' as descTel,'@mails' as mails,codigoUnidad as codigoU,codigoDepto as codDepto,o.descripcion
							from 247_instituciones i,817_organigrama o  where o.idOrganigrama=i.idOrganigrama and o.idOrganigrama = '".$idOrganigrama."'";
		}
		
		
		
		$obj=$con->obtenerFilasJson($consulta);
		
		$consulta="	select tipoTel,codArea,lada,telefono,extension from 818_telefonosOrganigrama where idOrganigrama=".$idOrganigrama;
		$resTel=$con->obtenerFilas($consulta);	
		$descTel="";
		$arrTel="";
		while($filaTel=mysql_fetch_row($resTel))
		{
			$tipoTel="";
			switch($filaTel[0])
			{
				case 0:
					$tipoTel='Tel\u00E9fono';	
				break;
				case 2:
					$tipoTel='Fax';
				break;
			}
			$extension="";
			if($filaTel[4]!="")
				$extension="Ext.: ".$filaTel[4];
			
			$tel="[".$tipoTel."] (".$filaTel[1].") ".$filaTel[2]."-".$filaTel[3]." (".$extension.")";
			if($descTel=="")
				$descTel=$tel;
			else
				$descTel.="<br>".$tel;
			$telCod=$filaTel[0]."_".$filaTel[1]."_".$filaTel[2]."_".$filaTel[3]."_".$filaTel[4];
			
			if($arrTel=="")
				$arrTel=$telCod;
			else
				$arrTel.=",".$telCod;
		}
		$obj=str_replace("@telefonos",$arrTel,$obj);
		$obj=str_replace("@descTel",$descTel,$obj);
		
		
		$consulta="SELECT email FROM 818_mailOrganigrama WHERE idOrganigrama=".$idOrganigrama;
		$mails=$con->obtenerListaValores($consulta,"");
		$obj=str_replace("@mails",$mails,$obj);
		if($SO==2)
			echo "1|".($obj);
		else
			echo "1|".utf8_encode($obj);
	}
	
	function obtenerPuestos()
	{
		global $con;
		$codigoU=$_POST["codigoU"];
		$inicio=$_POST["start"];
		$limite=$_POST["limit"];
		$cadAux="";
		if(isset($_POST["filter"]))
		{
			$cadAux=" and ".generarCadenaConsultasFiltro($_POST["filter"])	;
		}
		
		$consulta="select idPuesto,puesto,numPuestos,cvePuesto,
					(select count(idTabulacion) from 652_tabulaciones where idPuesto=po.idPuesto and situacion=1 and idTabulacion in (select idTabulacion from 653_unidadesOrgVSPuestos)) as puestosAsignados,
					(select count(idTabulacion) from 652_tabulaciones where idPuesto=po.idPuesto and situacion=1 and idTabulacion in (select idTabulacion from 653_unidadesOrgVSPuestos where situacion=1)) as puestosOcupados,
					(select unidad from 817_organigrama where codigoUnidad='".$codigoU."') as institucion,zona,tipoPuesto,horasPuesto,sueldoMinimo,sueldoMaximo,nivelRiesgo
				   from 819_puestosOrganigrama po where codigoUnidad='".$codigoU."' ".$cadAux." order by puesto limit ".$inicio.",".$limite;

		$arrPuestos=$con->obtenerFilasJSON($consulta);
		$consulta="select idPuesto  from 819_puestosOrganigrama  where codigoUnidad='".$codigoU."'";
		$con->obtenerFilas($consulta);
		$numReg=$con->filasAfectadas;
		echo '{"numReg":"'.$numReg.'","registros":'.uEJ($arrPuestos).'}';
	}
	
	function guardarPuesto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$idPuesto=$obj->idPuesto;
		$puesto=$obj->puesto;
		$codigoU=$obj->codigoU;
		$cvePuesto=$obj->cvePuesto;
		$idPuesto=$obj->idPuesto;
		$numPlazas=$obj->numPlazas;
		$zona=$obj->zona;
		$tipoPuesto=$obj->tipoPuesto;
		$horasPuesto=$obj->horasPuesto;
		$sueldoMinimo=$obj->sueldoMinimo;
		$sueldoMaximo=$obj->sueldoMaximo;
		if($idPuesto=="-1")
			$consulta="INSERT INTO 819_puestosOrganigrama(codigoUnidad,puesto,numPuestos,cvePuesto,horasPuesto,zona,sueldoMinimo,sueldoMaximo,tipoPuesto,nivelRiesgo)
						VALUES('".$codigoU."','".cv($puesto)."',".$numPlazas.",'".$cvePuesto."',".$horasPuesto.",".$zona.",".$sueldoMinimo.",".$sueldoMaximo.",".$tipoPuesto.",".$obj->riesgo.")";
		else
			$consulta="update 819_puestosOrganigrama set puesto='".cv($puesto)."',numPuestos=".$numPlazas.",cvePuesto='".$cvePuesto."',horasPuesto=".$horasPuesto.",zona=".$zona.
						",sueldoMinimo=".$sueldoMinimo.",sueldoMaximo=".$sueldoMaximo.",tipoPuesto=".$tipoPuesto.",nivelRiesgo=".$obj->riesgo." where idPuesto=".$idPuesto;

		if($con->ejecutarConsulta($consulta))
		{
			
			echo "1|";
		}
		else
			echo "|";
		
	}
	
	function modificarPuesto()
	{
		global $con;
		$puesto=$_POST["puesto"];
		$idPuesto=$_POST["idPuesto"];
		
		$cvePuesto=$_POST["cvePuesto"];
		$consulta="update 819_puestosOrganigrama set puesto='".cv($puesto)."',cvePuesto='".$cvePuesto."' where idPuesto=".$idPuesto;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarPuesto()
	{
		global $con;
		$idPuesto=$_POST["idPuesto"];

		$consulta="delete from  819_puestosOrganigrama where idPuesto=".$idPuesto;
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|";
		}
		else
			echo "|";
		
	}
	
	function obtenerAreasUsuario()
	{
		global $con;
		$consulta="select codigoFuncionalRaiz from 903_variablesSistema";
		$codFun=$con->obtenerValor($consulta);
		$codigoI=$_POST["codigoInstitucion"];
		if($codigoI=='-1')
		{
			return "[]";
		}
		$codFun=str_pad($codigoI,strlen($codFun),'0',STR_PAD_RIGHT);
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion from 817_organigrama where codigoFuncional='".$codFun."' order by codigoFuncional";
		$fila=$con->obtenerPrimeraFila($consulta);	
		$codigoF=$fila[3];
		$arrUnidades='[{id:"'.$fila[2].'",text:"'.cvJs($fila[0]).'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",checked:false';
		$hijos='';
		$hijos=obtenerAreasHijasUsuario($fila[1],strlen($codFun));																								  
		if($hijos=='')
			$arrUnidades.=',leaf:true,icon:"../images/users.png"}]';
		else
			$arrUnidades.=',children:['.$hijos.'],icon:"../images/user.png"}]';
		echo uEJ($arrUnidades);
	}
	
	function obtenerAreasHijasUsuario($codigoFun,$tamCodigo)
	{
		global $con;
		global $lPorcionCodFun;
		if(strlen($codigoFun)==$tamCodigo)
			return "";
		$cadComodines=str_pad("",$lPorcionCodFun,'_',STR_PAD_LEFT);
		$codigoBusqueda=$codigoFun.$cadComodines;
		$codigoBusqueda=str_pad($codigoBusqueda,$tamCodigo,'0',STR_PAD_RIGHT);
		$codigoPadre=str_pad($codigoFun,$tamCodigo,'0',STR_PAD_RIGHT);
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion from 817_organigrama where codigoFuncional like '".$codigoBusqueda."' and codigoFuncional<>'".$codigoPadre."' order by codigoFuncional";
		$res=$con->obtenerFilas($consulta);
		$arrHijos="";
		$objHijo="";
		$hijos="";
		while($fila=mysql_fetch_row($res))
		{
			$codigoF=$fila[3];
			$objHijo='{id:"'.$fila[2].'",text:"'.cvJs($fila[0]).'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",checked:false';
			$hijos=obtenerAreasHijasUsuario($fila[1],$tamCodigo);
			if($hijos=='')
				$objHijo.=',leaf:true,icon:"../images/users.png"}';
			else
				$objHijo.=',children:['.$hijos.'],icon:"../images/user.png"}';
			if($arrHijos=='')
				$arrHijos=$objHijo;
			else
				$arrHijos.=",".$objHijo;
		}
		return $arrHijos;
	}
	
	function crearInstitucionOrg2()
	{
		global $con;
		global $lPorcionCodFun;
		$longInstitucion=4;
		$cadObj=$_POST["param"];
		$obj=json_decode($cadObj);
		$codigoUPadre=$obj->codigoUPadre;
		$codUnidad="";
		$idOrganigrama=$obj->idOrganigrama;
		if(isset($obj->codUnidad))
			$codUnidad=$obj->codUnidad;
		$telefonos="";
		if(isset($obj->telefonos))
		{
			$telefonos=$obj->telefonos;
		}
		$email="";
		if(isset($obj->email))
		{
			$email=$obj->email;
		}
		$x=0;
		$cadComodin=str_pad("",$longInstitucion,"_",STR_PAD_RIGHT);
		$consultaAux="select max(codigoIndividual) from 817_organigrama where codigoUnidad like '".$codigoUPadre.$cadComodin."'";
		$codigoIndividual=$con->obtenerValor($consultaAux);
		if(($codigoIndividual==0)||($codigoIndividual==""))
			$codigoIndividual=1;
		else
			$codigoIndividual++;
		$codInst=$codigoIndividual;
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			if($idOrganigrama=="-1")
			{
				$codCC="";
				$codigoUnidadNuevo=str_pad($codInst,$longInstitucion,"0",STR_PAD_LEFT);
				$codigoUnidad=$codigoUPadre.$codigoUnidadNuevo;
				if($codUnidad!="")
				{
					/*if(existeCodigoUnidadOrg($codUnidad))
					{
						echo "El c&oacute;digo de la instituci&oacute;n ingresado ya existe";
						return;
					}*/
				}
				$consultaAux="SELECT MAX(LENGTH(codigoFuncional)) FROM 817_organigrama";
				$maxLongitud=$con->obtenerValor($consultaAux);
				$codigoFuncionalNuevo=str_pad($codigoUnidad,$maxLongitud,"0",STR_PAD_RIGHT);
				
				$query="insert into 817_organigrama(unidad,codigoFuncional,codigoUnidad,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,claveDepartamental,codigoInstitucion,fechaCreacion,responsableCreacion,instColaboradora) 
						value('".cv($obj->nombre)."','".$codigoFuncionalNuevo."','".$codigoUnidad."','".cv($obj->descripcion)."',".
						$obj->institucion.",'".$codCC."','".$codigoUPadre."','".$codigoUnidadNuevo."','".$codUnidad."','','".$_SESSION["codigoInstitucion"]."','".date("Y-m-d")."',".$_SESSION["idUsr"].",0)";
				
				if($con->ejecutarConsulta($query))		
				{
					$idOrganigrama=$con->obtenerUltimoID();
					if(isset($obj->objInst))
					{
						$objInst=$obj->objInst;
						$consulta[$x]="insert into 247_instituciones(idOrganigrama,cp,ciudad,estado,idPais,fechaCreacion,responsable,municipio,colonia,calle,numero) values
						('".$idOrganigrama."','".cv($objInst->cp)."','".cv($objInst->localidad)."','".cv($objInst->estado)."',".cv($objInst->idPais==""?"NULL":$objInst->idPais).",'".date("Y-m-d")."',".$_SESSION["idUsr"].",'".$objInst->municipio."','".$objInst->colonia."','".$objInst->calle."','".$objInst->numero."')";
						$x++;	
					}
					else
					{
						$consulta[$x]="insert into 247_instituciones(idOrganigrama) values ('".$idOrganigrama."')";
						$x++;
					}
					
					
					if(isset($obj->instPatrocinadora))
					{
						$consulta[$x]="update 817_organigrama set status=1 where idOrganigrama=".$idOrganigrama;
						$x++;
						$consulta[$x]="delete from 817_elementosOrganigramaVSCategorias where idOrganigrama=".$idOrganigrama." and idCategoria=1";
						$x++;
						$consulta[$x]="INSERT INTO 817_elementosOrganigramaVSCategorias(idOrganigrama,idCategoria) VALUES(".$idOrganigrama.",1)";
						$x++;
						$consulta[$x]="DELETE FROM _1018_tablaDinamica WHERE institucionPatrocinadora='".$codigoUnidad."'";
						$x++;
						$consulta[$x]="INSERT INTO _1018_tablaDinamica(institucionPatrocinadora,porcentajeRetencion) VALUES('".$codigoUnidad."',".$obj->porcentajeRetencion.")";
						$x++;
					}
					
					$consulta[$x]="DELETE FROM 818_mailOrganigrama WHERE idOrganigrama=".$idOrganigrama;
					$x++;
					if($email!="")
					{
						$arrMail=explode(",",$email);
						foreach($arrMail as $mail)
						{
							$consulta[$x]="INSERT INTO 818_mailOrganigrama(email,idOrganigrama) VALUES('".$mail."',".$idOrganigrama.")";
							$x++;
						}
						

					}
					
					if($telefonos!="")
					{
						$arrTelefonos=explode(",",$telefonos);
						$nTel=sizeof($arrTelefonos);
						for($y=0;$y<$nTel;$y++)
						{
							$datosTel=explode("_",$arrTelefonos[$y]);
							$tipo=$datosTel[0];
							$codArea=$datosTel[1];
							$lada=$datosTel[2];
							$tel=$datosTel[3];
							$ext=$datosTel[4];
							$consulta[$x]="	insert into 818_telefonosOrganigrama(codArea,lada,telefono,extension,tipoTel,idOrganigrama) 
											values('".$codArea."','".$lada."','".$tel."','".$ext."',".$tipo.",".$idOrganigrama.")";
							$x++;	
						}
					}
					
					
					
					$consulta[$x]="commit";
					$x++;
					
					
					if($con->ejecutarBloque($consulta))
						echo "1|".$idOrganigrama."|".$codigoUnidadNuevo;
					else
						echo "|";
				}
			}
			else
			{
				
				$codCC="";
				$x=0;
				$query="select codigoUnidad from 817_organigrama where idOrganigrama=".$idOrganigrama;
				$codigoUnidad=$con->obtenerValor($query);
				if($codUnidad!="")
				{
					/*if(existeCodigoUnidadOrg($codUnidad,$idOrganigrama))
					{
						echo "El c&oacute;digo de la instituci&oacute;n ingresado ya existe";
						return;
					}*/
				}
				if(isset($obj->objInst))
				{
					$consulta[$x]="insert into 817_historialOrganigrama(unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,cp,ciudad,estado,idPais,municipio,colonia,calle,numero,fechaModificacion,idResponsableModificacion,accion)
									select unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,cp,ciudad,estado,idPais,municipio,colonia,calle,numero,'".date('Y-m-d')."' as 'fechaModificacion', '".$_SESSION["idUsr"]."' as 'responsable','1' as accion from 817_organigrama o,247_instituciones i  where i.idOrganigrama=o.idOrganigrama
									and o.idOrganigrama=".$idOrganigrama;
									
					$x++;
				}
				else
				{
					$consulta[$x]="insert into 817_historialOrganigrama(unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,fechaModificacion,idResponsableModificacion,accion)
									select unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,'".date('Y-m-d')."' as 'fechaModificacion', '".$_SESSION["idUsr"]."' as 'responsable','1' as accion from 817_organigrama o  where 
									o.idOrganigrama=".$idOrganigrama;
									
					$x++;
				}

				$consulta[$x]="update 817_organigrama set institucion=".$obj->institucion.",unidad='".cv($obj->nombre)."', descripcion='".cv($obj->descripcion)."',codCentroCosto='".$codCC."',codigoDepto='".$codUnidad."' where idOrganigrama=".$idOrganigrama;
				
				$x++;
				$consulta[$x]="DELETE FROM 818_mailOrganigrama WHERE idOrganigrama=".$idOrganigrama;
				$x++;
				if($email!="")
				{
					$arrMail=explode(",",$email);
					foreach($arrMail as $mail)
					{
						$consulta[$x]="INSERT INTO 818_mailOrganigrama(email,idOrganigrama) VALUES('".$mail."',".$idOrganigrama.")";
						$x++;
					}
					

				}
				
				$consulta[$x]="	delete from 818_telefonosOrganigrama where idOrganigrama=".$idOrganigrama;
				$x++;		
				if($telefonos!="")
				{
					$arrTelefonos=explode(",",$telefonos);
					$nTel=sizeof($arrTelefonos);
					
					for($y=0;$y<$nTel;$y++)
					{
						$datosTel=explode("_",$arrTelefonos[$y]);
						$tipo=$datosTel[0];
						$codArea=$datosTel[1];
						$lada=$datosTel[2];
						$tel=$datosTel[3];
						$ext=$datosTel[4];
						$consulta[$x]="	insert into 818_telefonosOrganigrama(codArea,lada,telefono,extension,tipoTel,idOrganigrama) 
										values('".$codArea."','".$lada."','".$tel."','".$ext."',".$tipo.",".$idOrganigrama.")";
						$x++;										
					}
				}
				if(isset($obj->instPatrocinadora))
				{
					$consulta[$x]="update 817_organigrama set status=1 where idOrganigrama=".$idOrganigrama;
					$x++;
					$consulta[$x]="delete from 817_elementosOrganigramaVSCategorias where idOrganigrama=".$idOrganigrama." and idCategoria=1";
					$x++;
					$consulta[$x]="INSERT INTO 817_elementosOrganigramaVSCategorias(idOrganigrama,idCategoria) VALUES(".$idOrganigrama.",1)";
					$x++;
					$consulta[$x]="DELETE FROM _1018_tablaDinamica WHERE institucionPatrocinadora='".$codigoUnidad."'";
					$x++;
					$consulta[$x]="INSERT INTO _1018_tablaDinamica(institucionPatrocinadora,porcentajeRetencion) VALUES('".$codigoUnidad."',".$obj->porcentajeRetencion.")";
					$x++;
				}
				
				
				
				if(isset($obj->objInst))
				{
					$objInst=$obj->objInst;
					
					$consulta[$x]="update 247_instituciones set cp='".cv($objInst->cp)."',ciudad='".cv($objInst->localidad)."',estado='".cv($objInst->estado)."',idPais=".$objInst->idPais.",
									municipio='".cv($objInst->municipio)."',colonia='".cv($objInst->colonia)."',calle='".cv($objInst->calle)."',numero='".cv($objInst->numero)."' where idOrganigrama=".$idOrganigrama;
					$x++;
					$consulta[$x]="commit";
					if($con->ejecutarBloque($consulta))
						echo "1|".$idOrganigrama;
					else
						echo "|";
				}
				else
				{
					$consulta[$x]="commit";
					if($con->ejecutarBloque($consulta))
						echo "1|".$idOrganigrama;
					else
						echo "|";
				}
			}
		}
		else
			echo "|";
	}
	
	function crearAreaDepto2()
	{
		global $con;
		global $lPorcionCodFun;
		$longCodigo=4;
		$cadObj=$_POST["param"];
		$obj=json_decode($cadObj);
		$codigoUPadre=$obj->codigoUPadre;
		$codUnidad="";
		$idOrganigrama=$obj->idOrganigrama;
		
		if(isset($obj->codUnidad))
			$codUnidad=$obj->codUnidad;
		
		$telefonos="";
		if(isset($obj->telefonos))
		{
			$telefonos=$obj->telefonos;
		}
		$txtClaveDep=$obj->txtClaveDep;
		$x=0;
		$cadComodin=str_pad("",$longCodigo,"_",STR_PAD_RIGHT);
		$consultaAux="SELECT MAX(CHAR_LENGTH(codigoFuncional)) AS maxLongitud FROM 817_organigrama";
		$maxLongitud=$con->obtenerValor($consultaAux);
		if($maxLongitud==0)
			$maxLongitud=$longCodigo;
		
		$consultaAux="select max(codigoIndividual) from 817_organigrama where codigoUnidad like '".$codigoUPadre.$cadComodin."'";
		$codigoIndividual=$con->obtenerValor($consultaAux);
		if($codigoIndividual=="")
			$codigoIndividual=1;
		else
			$codigoIndividual++;
		$codInst=$codigoIndividual;
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			if($idOrganigrama=="-1")
			{
				$codCC="";
				if(isset($obj->CC))
					$codCC=$obj->CC;
				/*if(isset($obj->longCod))	
					$longCodigo=$obj->longCod;	*/
				$codigoIndividual=str_pad($codInst,$longCodigo,"0",STR_PAD_LEFT);
				
				$codigoUnidadNuevo=$codigoUPadre.$codigoIndividual;
				
				$normalizarCodigo=false;
				if(strlen($codigoUnidadNuevo)>$maxLongitud)
				{
					$maxLongitud=strlen($codigoUnidadNuevo);
					$normalizarCodigo=true;
				}
				
				
				$codigoFuncionalNuevo=str_pad($codigoUnidadNuevo,$maxLongitud,"0",STR_PAD_RIGHT);
				$query="insert into 817_organigrama(unidad,codigoFuncional,codigoUnidad,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,claveDepartamental,instColaboradora) 
						value('".cv($obj->nombre)."','".$codigoFuncionalNuevo."','".$codigoUnidadNuevo."','".cv($obj->descripcion)."',".$obj->institucion.",'".$codCC."','".$codigoUPadre."','".$codigoIndividual."','".$codUnidad."','".$txtClaveDep."',0)";
				if($con->ejecutarConsulta($query))		
				{
					$idOrganigrama=$con->obtenerUltimoID();
					if($telefonos!="")
					{
						$arrTelefonos=explode(",",$telefonos);
						$nTel=sizeof($arrTelefonos);
						for($y=0;$y<$nTel;$y++)
						{
							$datosTel=explode("_",$arrTelefonos[$y]);
							$tipo=$datosTel[0];
							$codArea=$datosTel[1];
							$lada=$datosTel[2];
							$tel=$datosTel[3];
							$ext=$datosTel[4];
							$consulta[$x]="	insert into 818_telefonosOrganigrama(codArea,lada,telefono,extension,tipoTel,idOrganigrama) 
											values('".$codArea."','".$lada."','".$tel."','".$ext."',".$tipo.",".$idOrganigrama.")";
							$x++;	
						}
					}
					if($normalizarCodigo)
					{
						$consulta[$x]="UPDATE 817_organigrama SET codigoFuncional=RPAD(codigoFuncional,".$maxLongitud.",0)";
						$x++;	
					}
					
					$consulta[$x]="commit";
					$x++;
					if($con->ejecutarBloque($consulta))
						echo "1|".$idOrganigrama."|".$codigoUnidadNuevo;
					else
						echo "|";
				}
			}
			else
			{
				
				$codCC="";
				if(isset($obj->CC))
					$codCC=$obj->CC;
				$x=0;
				if(isset($obj->longCod))	
					$longCodigo=$obj->longCod;	
				$codigoIndividual=str_pad($codUnidad,$longCodigo,"0",STR_PAD_LEFT);
				$codigoUnidadNuevo=$codigoUPadre.$codigoIndividual;
				$codigoFuncionalNuevo=str_pad($codigoUnidadNuevo,"10","0",STR_PAD_RIGHT);
				if(existeCodigoUnidadOrg($codigoUnidadNuevo,$idOrganigrama))
				{
					echo "El c&oacute;digo del &aacute;rea/depto ingresado ya existe";
					return;
				}
				
				$consulta[$x]="insert into 817_historialOrganigrama(unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,fechaModificacion,idResponsableModificacion,accion)
								select unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,'".date('Y-m-d')."' as 'fechaModificacion', '".$_SESSION["idUsr"]."' as 'responsable','1' as accion from 817_organigrama o  where 
								o.idOrganigrama=".$idOrganigrama;
								
				$x++;
				
				$consulta[$x]="update 817_organigrama set unidad='".cv($obj->nombre)."', descripcion='".cv($obj->descripcion)."',codCentroCosto='".$codCC."',codigoDepto='".$codUnidad."',claveDepartamental='".$txtClaveDep."' where idOrganigrama=".$idOrganigrama;
				
				$x++;
				$consulta[$x]="delete from 818_telefonosOrganigrama where idOrganigrama=".$idOrganigrama;
				$x++;		
				if($telefonos!="")
				{
					$arrTelefonos=explode(",",$telefonos);
					$nTel=sizeof($arrTelefonos);
					
					for($y=0;$y<$nTel;$y++)
					{
						$datosTel=explode("_",$arrTelefonos[$y]);
						$tipo=$datosTel[0];
						$codArea=$datosTel[1];
						$lada=$datosTel[2];
						$tel=$datosTel[3];
						$ext=$datosTel[4];
						$consulta[$x]="	insert into 818_telefonosOrganigrama(codArea,lada,telefono,extension,tipoTel,idOrganigrama) 
										values('".$codArea."','".$lada."','".$tel."','".$ext."',".$tipo.",".$idOrganigrama.")";
						$x++;										
							
					}
				}
				$consulta[$x]="commit";
				if($con->ejecutarBloque($consulta))
					echo "1|".$idOrganigrama;
				else
					echo "|";
			}
		}
		else
			echo "|";
	}
	
	function obtenerOrganigramaOrg2()
	{
		global $con;
		global $SO;
		
		ini_set("memory_limit","4096M");
		set_time_limit(999000);

		
		$comp="";	
		$condWhere="";
		$primeraCarga=$_POST["primeraCarga"];
		if($primeraCarga==1)
		{
			echo "[]";
			return;
		}
			
		if(!existeRol("'-3000_0'"))
		{
			$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,status,
					(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,
					(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad,					
					(SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as objConfiguracion,
					o.institucion as idTipoUnidad
					from 817_organigrama o where  (unidadPadre='' or unidadPadre is null) 
					and instColaboradora=0 order by  codigoFuncional";
		}
		else
		{
			$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,status,
					(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,
					(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad ,
					(SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as objConfiguracion,
					o.institucion as idTipoUnidad
					from 817_organigrama where codigoUnidad='".$_SESSION["codigoInstitucion"]."' order by  codigoFuncional";
		}
		$condWhere="";
		if(isset($_POST["jurisdiccion"]) && ($_POST["jurisdiccion"]!=""))
		{
			if($condWhere!="")
				$condWhere.=" and ";
				
			$condWhere="o.codigoUnidad like '".$_POST["jurisdiccion"]."%'";	
		}
		
		
		if(isset($_POST["categoria"]) && ($_POST["categoria"]!=""))
		{
			$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=17 AND claveDepartamental='".$_POST["categoria"]."'";
			$resCategorias=$con->obtenerFilas($consulta);
			$condCategoria="";
			if($condWhere!="")
				$condWhere.=" and ";	
			while($filaCategorias=mysql_fetch_assoc($resCategorias))
			{
				if($condCategoria=='')
					$condCategoria=" o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
				else
					$condCategoria.=" or o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
			}
			
			$condWhere.=" (".$condCategoria.")";
				
		}
		
		if(isset($_POST["distritoJudicial"]) && ($_POST["distritoJudicial"]!=""))
		{
			$arrDistritos=explode(",",$_POST["distritoJudicial"]);
			$listaDistritos="";
			foreach($arrDistritos as $d)
			{
				if($listaDistritos=="")
					$listaDistritos="'".$d."'";
				else
					$listaDistritos.=",'".$d."'";
			}
			$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=10 AND claveDepartamental in (".$listaDistritos.")";
			$resCategorias=$con->obtenerFilas($consulta);
			$condCategoria="";
			if($condWhere!="")
				$condWhere.=" and ";	
			while($filaCategorias=mysql_fetch_assoc($resCategorias))
			{
				if($condCategoria=='')
					$condCategoria=" o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
				else
					$condCategoria.=" or o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
			}
			
			$condWhere.=" (".$condCategoria.")";
				
		}
		
		if(isset($_POST["circuitoJudicial"]) && ($_POST["circuitoJudicial"]!=""))
		{
			$arrCircuitos=explode(",",$_POST["circuitoJudicial"]);
			$listaCircuitos="";
			foreach($arrCircuitos as $d)
			{
				if($listaCircuitos=="")
					$listaCircuitos="'".$d."'";
				else
					$listaCircuitos.=",'".$d."'";
			}
			$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=12 AND claveDepartamental in (".$listaCircuitos.")";
			$resCategorias=$con->obtenerFilas($consulta);
			$condCategoria="";
			if($condWhere!="")
				$condWhere.=" and ";	
			while($filaCategorias=mysql_fetch_assoc($resCategorias))
			{
				if($condCategoria=='')
					$condCategoria=" o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
				else
					$condCategoria.=" or o.codigoUnidad like '".$filaCategorias["codigoUnidad"]."%'";
			}
			
			$condWhere.=" (".$condCategoria.")";
				
		}
		
		if(isset($_POST["municipio"]) && ($_POST["municipio"]!=""))
		{
			$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE institucion=13 AND claveDepartamental='".$_POST["municipio"]."'";
			$resMunicipios=$con->obtenerFilas($consulta);
			$condMunicipio="";
			if($condWhere!="")
				$condWhere.=" and ";	
			while($filaMunicipio=mysql_fetch_assoc($resMunicipios))
			{
				if($condMunicipio=='')
					$condMunicipio=" o.codigoUnidad like '".$filaMunicipio["codigoUnidad"]."%'";
				else
					$condMunicipio.=" or o.codigoUnidad like '".$filaMunicipio["codigoUnidad"]."%'";
			}
			
			$condWhere.=" (".$condMunicipio.")";	
		}
		
		if(isset($_POST["nombreDespacho"]) && ($_POST["nombreDespacho"]!=""))
		{
			if($condWhere=="")
				$condWhere=" unidad like '%".$_POST["nombreDespacho"]."%'";	
			else
				$condWhere.=" and unidad like '%".$_POST["nombreDespacho"]."%'";	
		}
		
		if(isset($_POST["cveDespacho"]) && ($_POST["cveDespacho"]!=""))
		{
			if($condWhere=="")
				$condWhere=" claveDepartamental like '%".$_POST["cveDespacho"]."%'";	
			else
				$condWhere.=" and claveDepartamental like '%".$_POST["cveDespacho"]."%'";	
		}
		
		
		if(		
				($condWhere=="")&&
				(!isset($_POST["especialidad"]) ||( $_POST["especialidad"]==""))&&
				(!isset($_POST["atributosDespacho"]) ||( $_POST["atributosDespacho"]==""))&&
				(!isset($_POST["procesosCompete"]) ||( $_POST["procesosCompete"]==""))
			)
		{
			obtenerOrganigramaOrg3();
			return;
		}
		
		$consulta="SELECT idCategoriaUnidadOrganigrama FROM 817_categoriasUnidades WHERE esJuzgado=1";
		$listaTiposDespacho=$con->obtenerListaValores($consulta);
		if($listaTiposDespacho=="")
			$listaTiposDespacho=-1;
		
		$arrEstructuraOrganizacional=array();
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,status,
					(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,
					(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad,
					
					(SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as objConfiguracion,
					o.institucion as idTipoUnidad
					from 817_organigrama o where  ".($condWhere!=""?($condWhere." and "):"")." institucion in (".$listaTiposDespacho.") order by  codigoFuncional";
		
		
		$listaDespachosAtributos="";
		$arrListaDespacho=array();
		if(isset($_POST["atributosDespacho"]) && ($_POST["atributosDespacho"]!=""))
		{
			$consulta="SELECT DISTINCT idReferencia FROM _17_gridAtributosDespacho WHERE idAtributoDespacho IN(".$_POST["atributosDespacho"].")";
			$resAtributosDespacho=$con->obtenerFilas($consulta);
			while($fAtributo=mysql_fetch_assoc($resAtributosDespacho))
			{
				$arrListaDespacho[$fAtributo["idReferencia"]]=1;
			}
				
			
		}
		
		if(isset($_POST["procesosCompete"]) && ($_POST["procesosCompete"]!=""))
		{
			$consulta="SELECT DISTINCT idReferencia FROM _17_gridTiposProceso WHERE tipoProceso IN(".$_POST["procesosCompete"].")";
			$resAtributosDespacho=$con->obtenerFilas($consulta);
			while($fAtributo=mysql_fetch_assoc($resAtributosDespacho))
			{
				$arrListaDespacho[$fAtributo["idReferencia"]]=1;
			}
				
			
		}
		
		if(count($arrListaDespacho)>0)
		{
			foreach($arrListaDespacho as $idDespacho=>$resto)
			{
				if($listaDespachosAtributos=="")
					$listaDespachosAtributos=$idDespacho;
				else
					$listaDespachosAtributos.=",".$idDespacho;
			}
		}
		
		if((isset($_POST["especialidad"]) &&( $_POST["especialidad"]!=""))||($listaDespachosAtributos!=""))
		{
			if(isset($_POST["especialidad"]) &&( $_POST["especialidad"]!=""))
			{
				if($condWhere=="")
					$condWhere="e.especialidad=".$_POST["especialidad"];	
				else
					$condWhere.=" and e.especialidad=".$_POST["especialidad"];	
			}
			
			if(isset($_POST["detalleEspecialidad"]) &&( $_POST["detalleEspecialidad"]!=""))
			{
				if($condWhere=="")
					$condWhere="e.detalleEspecialidad='".$_POST["detalleEspecialidad"]."'";	
				else
					$condWhere.=" and e.detalleEspecialidad='".$_POST["detalleEspecialidad"]."'";	
			}


			if($listaDespachosAtributos!="")
			{
				if($condWhere=="")
					$condWhere="d.id__17_tablaDinamica in(".$listaDespachosAtributos.")";	
				else
					$condWhere.=" and d.id__17_tablaDinamica in(".$listaDespachosAtributos.")";	
			}

			$consulta="select unidad,o.codigoUnidad,idOrganigrama,codigoFuncional,o.descripcion,institucion,codCentroCosto,o.unidadPadre,codigoIndividual,codigoDepto,status,
					(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,
					(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad,
					
					(SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as objConfiguracion,
					o.institucion as idTipoUnidad
					from 817_organigrama o, _17_tablaDinamica d,_1284_tablaDinamica e where d.claveRegistro=o.codigoDepto and 
					e.idReferencia=d.id__17_tablaDinamica and ".($condWhere!=""?($condWhere." and "):"").
					" institucion in (".$listaTiposDespacho.") order by  codigoFuncional";
		}

		$resOrg=$con->obtenerFilas($consulta);	
		while($filaOrg=mysql_fetch_assoc($resOrg))
		{
			$claveUnidad=$filaOrg["codigoUnidad"];
			$o=array();
			$o["codigoUnidad"]=$filaOrg["codigoUnidad"];
			$o["infoUnidad"]=$filaOrg;
			agregarNodoDespachoEstructuraOrganizacional($arrEstructuraOrganizacional,$o);
		}

		
		$arrNodos="";
		foreach($arrEstructuraOrganizacional as $o=>$resto)
		{
			$oNodo=convertirObjetoNodo($resto);
			if($arrNodos=="")
				$arrNodos=$oNodo;
			else
				$arrNodos.=",".$oNodo;
		}
		
		echo '['.$arrNodos.']';
			
		
	}
	
	
	function agregarNodoDespachoEstructuraOrganizacional(&$arrEstructura,$nodo)
	{
		global $con;
		$arrDescomponerNodo=$nodo["codigoUnidad"];
		$arrRuta=array();
		
		$totalNiveles=strlen($nodo["codigoUnidad"])/4;
		
		
		for($x=0;$x<$totalNiveles;$x++)
		{
			$arrRuta[$x]=substr($nodo["codigoUnidad"],0,(4*($x+1)));
		}
		
	
		$cadena="";
		for($x=0;$x<$totalNiveles;$x++)
		{
			$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,status,
								(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,
								(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad,
								
								(SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as objConfiguracion,
								o.institucion as idTipoUnidad
								from 817_organigrama o where codigoUnidad='".$arrRuta[$x]."'";
			$filaNodo=$con->obtenerPrimeraFilaAsoc($consulta);
					
			if($x==0)
			{
				if(!isset($arrEstructura[$arrRuta[$x]]))
				{
					$arrEstructura[$arrRuta[$x]]=array();
					
					
					
					$arrEstructura[$arrRuta[$x]]["info"]=$filaNodo;
					$arrEstructura[$arrRuta[$x]]["hijos"]=array();	
				}
				
			}
			else
			{
				$cadena="";
				$pos=0;
				for($pos=0;$pos<$x;$pos++)
				{
					if($cadena=="")
						$cadena='$arrEstructura["'.$arrRuta[$pos].'"]';
					else
						$cadena.='["hijos"]["'.$arrRuta[$pos].'"]';
					
					eval('if(!isset('.$cadena.'))
							{
								$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,
											unidadPadre,codigoIndividual,codigoDepto,status,
								(case status when \'1\'  then \'Activo\' when \'0\' then \'Inactivo\' when \'2\' then \'Concentrador\' end) as activo,
								(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad,
								(SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as objConfiguracion,
								o.institucion as idTipoUnidad
								from 817_organigrama o where codigoUnidad=\''.$arrRuta[$pos].'\'";
								$filaNodoInfo=$con->obtenerPrimeraFilaAsoc($consulta);
								'.$cadena.'["info"]=$filaNodoInfo;
								'.$cadena.'["hijos"]=array();
							}
						');
					
					
				}
				
				
				//echo ($cadena.'["hijos"]["'.$arrRuta[$pos].'"]=array();'.$cadena.'["hijos"]["'.$arrRuta[$pos].'"]["info"]=$filaNodo;'.$cadena.'["hijos"]["'.$arrRuta[$pos].'"]["hijos"]=array()');
				
			}
			
			if(($x==$totalNiveles-1)&&($cadena!=""))
			{
				eval($cadena.'["hijos"]["'.$arrRuta[$x].'"]=array();'.$cadena.'["hijos"]["'.$arrRuta[$x].'"]["info"]=$filaNodo;'.$cadena.'["hijos"]["'.$arrRuta[$x].'"]["hijos"]=array();');
			}
			
		}
		
	}
	
	
	function convertirObjetoNodo($nodoObj)
	{
		global $con;
		$nodo=$nodoObj["info"];
		$codFun=$nodo["codigoFuncional"];
		$codigoF=$nodo["codigoFuncional"];
		$texto=cv($nodo["unidad"]);
		$desc="";
		$tipoUnidad=cv($nodo["tipoUnidad"]);
		
		$consulta="	select tipoTel,codArea,lada,telefono,extension from 818_telefonosOrganigrama where idOrganigrama=".$nodo["idOrganigrama"];
		$resTel=$con->obtenerFilas($consulta);	
		$descTel="";
		$arrTel="";
		while($filaTel=mysql_fetch_row($resTel))
		{
			$tipoTel="";
			switch($filaTel[0])
			{
				case 0:
					$tipoTel='Tel\u00E9fono';	
				break;
				case 2:
					$tipoTel='Fax';
				break;
			}
			$extension="";
			if($filaTel[4]!="")
				$extension="Ext.: ".$filaTel[4];
			
			$tel="[".$tipoTel."] (".$filaTel[1].") ".$filaTel[2]."-".$filaTel[3]." (".$extension.")";
			if($descTel=="")
				$descTel=$tel;
			else
				$descTel.="<br>".$tel;
			$telCod=$filaTel[0]."_".$filaTel[1]."_".$filaTel[2]."_".$filaTel[3]."_".$filaTel[4];
			
			if($arrTel=="")
				$arrTel=$telCod;
			else
				$arrTel.=",".$telCod;
		}
		
		$consulta="select tituloCentroC from 506_centrosCosto where codigoCompleto='".$nodo["codCentroCosto"]."'";
		$cc=$con->obtenerValor($consulta);
		$consulta="SELECT email FROM 818_mailOrganigrama WHERE idOrganigrama=".$nodo["idOrganigrama"];
		$mails=$con->obtenerListaValores($consulta,"");
		
		$objUnidad='{"expanded":true,"adscribeInstitucion":"1","mails":"'.$mails.'","codigoInstitucion":"'.$nodo["codigoUnidad"].
					'","status":"'.$nodo["status"].'","activo":"'.$nodo["activo"].
					'",unidadPadre:"'.$nodo["unidadPadre"].'",codigoIndividual:"'.$nodo["codigoIndividual"].
					'",id:"'.$nodo["idOrganigrama"].'",text:"'.($texto).'",CC:"'.$nodo["codCentroCosto"].'",'.
					'CCDescrip:"'.$cc.'",draggable:false,codigoU:"'.$nodo["codigoUnidad"].'",codigoF:"'.$codigoF.'","editable":true,"descripcion":"'.cvJs($nodo["descripcion"]).
					'",institucion:"'.$nodo["institucion"].'",desc:"'.$desc.'","telefonos":"'.$arrTel.'","descTel":"'.$descTel.'","codDepto":"'.$nodo["codigoDepto"].
					'","tipoUnidad":"'.$tipoUnidad.'","idTipoUnidad":"'.$nodo["idTipoUnidad"].'","cveDeptal":"'.$nodo["codigoDepto"].'"';
		$hijos='';
		$hijos=obtenerUnidadesHijasOrg2($nodoObj);																								  
		if($hijos=='[]')
			$objUnidad.=',leaf:true,icon:"../images/users.png"}';
		else
			$objUnidad.=',children:'.$hijos.',icon:"../images/user.png"}';
	
		return $objUnidad;
	}
	
	function obtenerUnidadesHijasOrg2($nodo)
	{
		$arrHijos="";
		foreach($nodo["hijos"] as $h)
		{
			$oHijo=convertirObjetoNodo($h);
			if($arrHijos=="")
				$arrHijos=$oHijo;
			else
				$arrHijos.=",".$oHijo;
		}
		return "[".$arrHijos."]";
	}
	
	
	function obtenerOrganigramaOrg3()
	{
		global $con;
		global $SO;
		$comp="";		
		if(!existeRol("'-3000_0'"))
		{
			$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,status,
					(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,
					(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad,
					
					(SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as objConfiguracion,
					o.institucion as idTipoUnidad
					from 817_organigrama o where  (unidadPadre='' or unidadPadre is null) 
					and instColaboradora=0 order by  codigoFuncional";
		}
		else
		{
			$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,status,
					(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,
					(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad ,
					(SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as objConfiguracion,
					o.institucion as idTipoUnidad
					from 817_organigrama where codigoUnidad='".$_SESSION["codigoInstitucion"]."' order by  codigoFuncional";
		}
		$resOrg=$con->obtenerFilas($consulta);	
		$arrUnidades="";
		while($fila=mysql_fetch_row($resOrg))
		{
			$codFun=$fila[3];
			$codigoF=$fila[3];
			$texto=cv($fila[0]);
			$desc="";
			$tipoUnidad=cv($fila[12]);
			
			$consulta="	select tipoTel,codArea,lada,telefono,extension from 818_telefonosOrganigrama where idOrganigrama=".$fila[2];
			$resTel=$con->obtenerFilas($consulta);	
			$descTel="";
			$arrTel="";
			while($filaTel=mysql_fetch_row($resTel))
			{
				$tipoTel="";
				switch($filaTel[0])
				{
					case 0:
						$tipoTel='Tel\u00E9fono';	
					break;
					case 2:
						$tipoTel='Fax';
					break;
				}
				$extension="";
				if($filaTel[4]!="")
					$extension="Ext.: ".$filaTel[4];
				
				$tel="[".$tipoTel."] (".$filaTel[1].") ".$filaTel[2]."-".$filaTel[3]." (".$extension.")";
				if($descTel=="")
					$descTel=$tel;
				else
					$descTel.="<br>".$tel;
				$telCod=$filaTel[0]."_".$filaTel[1]."_".$filaTel[2]."_".$filaTel[3]."_".$filaTel[4];
				
				if($arrTel=="")
					$arrTel=$telCod;
				else
					$arrTel.=",".$telCod;
			}
			
			$consulta="select tituloCentroC from 506_centrosCosto where codigoCompleto='".$fila[6]."'";
			$cc=$con->obtenerValor($consulta);
			$consulta="SELECT email FROM 818_mailOrganigrama WHERE idOrganigrama=".$fila[2];
			$mails=$con->obtenerListaValores($consulta,"");
			$objUnidad='{"expanded":true,"adscribeInstitucion":"1","mails":"'.$mails.'","codigoInstitucion":"'.$fila[1].'","status":"'.$fila[10].'","activo":"'.$fila[11].
							'",unidadPadre:"'.$fila[7].'",codigoIndividual:"'.$fila[8].'",id:"'.$fila[2].'",text:"'.($texto).'",CC:"'.$fila[6].'",'.
					'CCDescrip:"'.$cc.'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'","editable":true,"descripcion":"'.cvJs($fila[4]).
					'",institucion:"'.$fila[5].'",desc:"'.$desc.'","telefonos":"'.$arrTel.'","descTel":"'.$descTel.'","codDepto":"'.$fila[9].
					'","tipoUnidad":"'.$tipoUnidad.'","idTipoUnidad":"'.$fila[14].'","cveDeptal":"N/A"';
			$hijos='';
			$hijos=obtenerUnidadesHijasOrg3($fila[1],$fila[1]);																								  
			if($hijos=='')
				$objUnidad.=',leaf:true,icon:"../images/users.png"}';
			else
				$objUnidad.=',children:['.$hijos.'],icon:"../images/user.png"}';
			if($arrUnidades=="")
				$arrUnidades=$objUnidad;
			else
				$arrUnidades.=",".$objUnidad;
		}		
		
		
		echo "[".($arrUnidades)."]";
	}
	
	function obtenerUnidadesHijasOrg3($codigoFun,$institucion)
	{
		global $con;
		global $lPorcionCodFun;
		global $SO;
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,
					claveDepartamental,status,(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,
					(SELECT nombreCategoria FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as tipoUnidad,
					(SELECT objConfiguracion FROM 817_categoriasUnidades WHERE idCategoriaUnidadOrganigrama=o.institucion) as objConfiguracion,
					o.institucion as idTipoUnidad
					 from 817_organigrama o where unidadPadre = '".$codigoFun."' order by unidad";
		$res=$con->obtenerFilas($consulta);
		$arrHijos="";
		$objHijo="";
		$hijos="";
		$codigoF="";
		while($fila=mysql_fetch_row($res))
		{
			$tipoUnidad=$fila[13];
			$desc="";
			$consulta="	select tipoTel,codArea,lada,telefono,extension from 818_telefonosOrganigrama where idOrganigrama=".$fila[2];
			$resTel=$con->obtenerFilas($consulta);	
			$descTel="";
			$arrTel="";
			while($filaTel=mysql_fetch_row($resTel))
			{
				$tipoTel="";
				switch($filaTel[0])
				{
					case 0:
						$tipoTel='Tel\u00E9fono';	
					break;
					case 2:
						$tipoTel='Fax';
					break;
				}
				$extension="";
				if($filaTel[4]!="")
					$extension="Ext.: ".$filaTel[4];
				
				$tel="[".$tipoTel."] (".$filaTel[1].") ".$filaTel[2]."-".$filaTel[3]." (".$extension.")";
				if($descTel=="")
					$descTel=$tel;
				else
					$descTel.="<br>".$tel;
				$telCod=$filaTel[0]."_".$filaTel[1]."_".$filaTel[2]."_".$filaTel[3]."_".$filaTel[4];
				
				if($arrTel=="")
					$arrTel=$telCod;
				else
					$arrTel.=",".$telCod;
			}
			
			if(true)
			{
				$codigoF=$fila[3];
				$color="#033";
				if($fila[11]=="2")
					$color="#060";
				$texto="<font color='".$color."'>".cv($fila[0])."</font>";
				
				$consulta="select i.*,p.nombre from 247_instituciones i,238_paises p where p.idPais=i.idPais and i.idOrganigrama=".$fila[2];
				$filaD=$con->obtenerPrimeraFila($consulta);
				$desc="";
				$cp=$filaD[2];
				
				$ciudad=$filaD[3];
				$estado=$filaD[4];
				$pais=$filaD[12];
				$municipio=$filaD[8];
				$idPais=$filaD[5];
				$colonia=$filaD[9];
				$calle=$filaD[10];
				$numero=$filaD[11];
				$descripcion="";
				if($calle!="")
					$descripcion="Calle ".$calle." ";
				
				if($numero!="")
					$descripcion.="N&uacute;mero:  ".$numero." ";
				
				if($colonia!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT nombreColonia FROM 822_colonias WHERE cveColonia='".$colonia."'";
						$colonia=$con->obtenerValor($consulta);
					}
					$descripcion.="Colonia ".$colonia.", ";
				}
				if($ciudad!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT localidad FROM 822_localidades WHERE cveLocalidad='".$ciudad."'";
						$ciudad=$con->obtenerValor($consulta);
					}
					
					$descripcion.=$ciudad.", "; 	
				}
				if($municipio!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$municipio."'";
						$municipio=$con->obtenerValor($consulta);
					}
					
					$descripcion.=$municipio.", "; 	
				}
				
				if($estado!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$estado."'";
						$estado=$con->obtenerValor($consulta);
					}
					
					$descripcion.=$estado.", "; 	
				}
				$descripcion.=$pais;
				
				if($cp!="")
					$cp=", C.P. ".$cp.".";
				$descripcion.=$cp;
				
				if($SO==2)
					$desc="<br>(".$descripcion.")";
				else
					$desc="<br>(".($descripcion).")";
			}
			
			

			$cc='';
			$cveDeptal=$fila[10];
			$consulta="SELECT email FROM 818_mailOrganigrama WHERE idOrganigrama=".$fila[2];
			$mails=$con->obtenerListaValores($consulta,"");
			$adscribeInstitucion=1;
			$objHijo='{"expanded":false,"adscribeInstitucion":"'.$adscribeInstitucion.'","mails":"'.$mails.'","codigoInstitucion":"'.$institucion.'",'.
					'"status":"'.$fila[11].'","activo":"'.$fila[12].'",unidadPadre:"'.$fila[7].'",codigoIndividual:"'.$fila[8].'",id:"'.$fila[2].'",text:"'.$texto.'",'.
					'CC:"'.$fila[6].'",CCDescrip:"'.$cc.'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.
					cvJs($fila[4]).'",institucion:"'.$fila[5].'",'.'desc:"'.$desc.'","telefonos":"'.$arrTel.'","descTel":"'.$descTel.'","tipoUnidad":"'.
					$tipoUnidad.'","codDepto":"'.$fila[9].'","idTipoUnidad":"'.$fila[15].'","cveDeptal":"'.$cveDeptal.'"';
			$hijos=obtenerUnidadesHijasOrg3($fila[1],$fila[1]);
			if($hijos=='')
				$objHijo.=',leaf:true,icon:"../images/users.png"}';
			else
				$objHijo.=',children:['.$hijos.'],icon:"../images/user.png"}';
			if($arrHijos=='')
				$arrHijos=$objHijo;
			else
				$arrHijos.=",".$objHijo;
		}
		return $arrHijos;
	}
	
	
	function existeCodigoUnidadOrg($codigo,$idOrganigrama="-1")
	{
		global $con;
		if($codigo=="")
			return false;
		$consulta="select idOrganigrama from 817_organigrama where codigoDepto='".$codigo."' and idOrganigrama<>".$idOrganigrama;
		$fila=$con->obtenerPrimeraFila($consulta);
		if($fila)
			return true;
		else
			return false;
	}
	
	function guardarTabulacion()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$idTabulacion=$obj->idTabulacion;
		if($obj->idTabulacion=="-1")
			$consulta="insert into 652_tabulaciones(idPuesto,codTabulacion,idZona,salarioMinimo,salarioMaximo,situacion,tipoPuesto) values(".$obj->idPuesto.",'".cv($obj->codTabulacion)."',".$obj->idZona.",".$obj->salarioMin.",".$obj->salarioMax.",".$obj->situacion.",".$obj->tipoPuesto.")";
		else
			$consulta="update 652_tabulaciones set idPuesto=".$obj->idPuesto.",codTabulacion='".cv($obj->codTabulacion)."',idZona=".$obj->idZona.",salarioMinimo=".$obj->salarioMin.",salarioMaximo=".$obj->salarioMax.",situacion=".$obj->situacion.",tipoPuesto=".$obj->tipoPuesto." where idTabulacion=".$idTabulacion;
		if($con->ejecutarConsulta($consulta))		
		{
			if($idTabulacion=="-1")	
				$idTabulacion=$con->obtenerUltimoID();	
			$consulta="select count(idTabulacion) from 652_tabulaciones where idPuesto=".$obj->idPuesto." and situacion=1";
			$nPuestos=$con->obtenerValor($consulta);
			$consulta="select codigoUnidad from 819_puestosOrganigrama where idPuesto=".$obj->idPuesto;
			$codigoU=$con->obtenerValor($consulta);
			$consulta="select idPuesto,puesto as puesto,(select count(idTabulacion) from 652_tabulaciones where idPuesto=po.idPuesto and situacion=1) as numPuesto,cvePuesto,
					(select count(idTabulacion) from 652_tabulaciones where idPuesto=po.idPuesto and situacion=1 and idTabulacion in (select idTabulacion from 653_unidadesOrgVSPuestos)) as nPuestosAsign,
					(select count(idTabulacion) from 652_tabulaciones where idPuesto=po.idPuesto and situacion=1 and idTabulacion in (select idTabulacion from 653_unidadesOrgVSPuestos where situacion=1)) as nPuestosOcu
				   from 819_puestosOrganigrama po where codigoUnidad='".$codigoU."' order by puesto";
			$arrPuestos=$con->obtenerFilasArreglo($consulta);
			echo "1|".$idTabulacion."|".$nPuestos."|".uEJ($arrPuestos);
		}
	}
	
	function obtenerTabulaciones()
	{
		global $con;
		$idPuesto=$_POST["idPuesto"];
		$consulta="select idTabulacion,codTabulacion,idZona,salarioMinimo,salarioMaximo,situacion,if((select count(idTabulacion) 
		from 653_unidadesOrgVSPuestos where situacion=1 and idTabulacion=t.idTabulacion)>0,'No','Sí') as ocupado,tipoPuesto 
		from 652_tabulaciones t where idPuesto=".$idPuesto;
		$arrTab=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrTab);
	}
	
	function removerTabulacion()
	{
		global $con;
		$listado=$_POST["listado"];
		$consulta="delete from 652_tabulaciones where idTabulacion in (".$listado.")";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function existeCodTabulacion()
	{
		global $con;
		$idTabulacion=$_POST["idTabulacion"];
		$codTabulacion=$_POST["codTabulacion"];
		$consulta="select idTabulacion from 652_tabulaciones where codTabulacion='".$codTabulacion."' and idTabulacion<>".$idTabulacion;
		$fila=$con->obtenerPrimeraFila($consulta);
		if(!$fila)
			echo "1|";
		else
			echo "El c&oacute;digo de la tabulaci&oacute;n ingresado ya existe|";
	}
	
	function obtenerPuestosInstitucion()
	{
		global $con;
		$codigoUnidad=$_POST["codigoUnidad"];
		//$codigoUnidad=substr($codigoUnidad,0,4);
		$consulta="select idPuesto, concat('[',cvePuesto,'] ',puesto) from 819_puestosOrganigrama where codigoUnidad='".$codigoUnidad."' order by puesto";
		
		$arrPuestos=uEJ($con->obtenerFilasArreglo($consulta));
		echo "1|".$arrPuestos;
	}
	
	function obtenerPuestosDisponibles()
	{
		global $con;
		$idPuesto=$_POST["idPuesto"];
		$consulta="SELECT numPuestos FROM 819_puestosOrganigrama WHERE idPuesto=".$idPuesto;
		$numPuestos=$con->obtenerValor($consulta);
		$consulta="SELECT COUNT(idPuesto) FROM 653_unidadesOrgVSPuestos WHERE idPuesto=".$idPuesto;
		$numPuestosOcupados=$con->obtenerValor($consulta);
		echo "1|".$numPuestos."|".$numPuestosOcupados;
	}
	
	function asignarPuestoUnidad()
	{
		global $con;
		$numPuesto=$_POST["numPuesto"];
		$unidad=$_POST["unidad"];
		$idPuesto=$_POST["idPuesto"];

		$x=0;
		$consulta[$x]="begin";
		$x++;
		for($ct=0;$ct<$numPuesto;$ct++)
		{
			$consulta[$x]="insert into 653_unidadesOrgVSPuestos(codUnidad,idPuesto,situacion) values('".$unidad."',".$idPuesto.",0)";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select idUnidadVSPuesto,op.idPuesto,p.cvePuesto,p.puesto,z.NombreZona,op.situacion as status,
					if(op.situacion=0,'',(select u.Nombre from 801_fumpEmpleado a,800_usuarios u where u.idUsuario=a.idUsuario and a.idTabulacion=op.idPuesto and a.activo=1 and departamento='".$unidad."')) as ocupante,tipoPuesto from 
					819_puestosOrganigrama p,653_unidadesOrgVSPuestos op ,650_zonas z
						where p.idPuesto=op.idPuesto and z.id_650_zonas=p.zona and op.codUnidad='".$unidad."' order by p.puesto";
			$arrPuestosA=uEJ($con->obtenerFilasArreglo($query));
			echo "1|".$arrPuestosA;
		}
		else
			echo "|";
	}
	
	function obtenerPuestosUnidad()
	{
		global $con;
		$unidad=$_POST["unidad"];
		$query="select idUnidadVSPuesto,op.idPuesto,p.cvePuesto,p.puesto,z.NombreZona,op.situacion as status,
					if(op.situacion=0,'',(select u.Nombre from 801_fumpEmpleado a,800_usuarios u where u.idUsuario=a.idUsuario and a.idTabulacion=op.idUnidadVSPuesto and a.activo=1 and departamento='".$unidad."')) as ocupante,tipoPuesto from 
					819_puestosOrganigrama p,653_unidadesOrgVSPuestos op ,650_zonas z
						where p.idPuesto=op.idPuesto and z.id_650_zonas=p.zona and op.codUnidad='".$unidad."' order by p.puesto";
		$arrPuestosA=uEJ($con->obtenerFilasArreglo($query));
		echo "1|".$arrPuestosA;
	}
	
	function removerPuestoDepto()
	{
		global $con;
		$listado=$_POST["listado"];
		$consulta="delete from 653_unidadesOrgVSPuestos where idUnidadVSPuesto in (".$listado.")";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerPuestosDisponiblesAdscripcion()
	{
		global $con;
		$codUnidad=$_POST["codUnidad"];
		$salir=false;
		while(!$salir)
		{
		/*$consulta="select up.idUnidadVSPuesto,p.puesto,cvePuesto,p.tipoPuesto,z.NombreZona,p.sueldoMinimo,p.sueldoMaximo,p.idPuesto
					from 650_zonas z, 819_puestosOrganigrama p, 653_unidadesOrgVSPuestos up where p.idPuesto=up.idPuesto  and up.situacion=0 and codUnidad='".$codUnidad."'
					and z.id_650_zonas=p.zona ";*/
			$consulta="SELECT p.puesto,cvePuesto,p.tipoPuesto,z.NombreZona,p.sueldoMinimo,p.sueldoMaximo,p.idPuesto
						FROM 650_zonas z, 819_puestosOrganigrama p WHERE  p.codigoUnidad='".$codUnidad."' AND z.id_650_zonas=p.zona";
			
			$arrPuestos=uEJ($con->obtenerFilasArreglo($consulta));
			if($con->filasAfectadas!=0)
			{
				$salir=true;
			}
			else
			{
				$consulta="SELECT unidadPadre FROM 817_organigrama WHERE codigoUnidad='".$codUnidad."'";		
				$codUnidad=$con->obtenerValor($consulta);
				if($codUnidad=="")
					$salir=true;
			}
		}
		echo "1|".$arrPuestos;
	}
	
	function obtenerQuincena()
	{
		global $con;
		global $arrMesLetra;
		$ciclo=$_POST["ciclo"];
		$consulta="select noQuincena,mes from 656_calendarioNomina where ciclo=".$ciclo." and situacion=1";
		$resQ=$con->obtenerFilas($consulta);
		$arrQuincenas="";
		while($fila=mysql_fetch_row($resQ))
		{
			$etiqueta="1a. ";
			if(($fila[0]%2)==0)
				$etiqueta="2a. ";
			$obj="['".$fila[0]."','".$etiqueta." ".$arrMesLetra[$fila[1]-1]."']";
			if($arrQuincenas=="")
				$arrQuincenas=$obj;
			else
				$arrQuincenas.=",".$obj;
		}
		echo "1|[".uEJ($arrQuincenas)."]";
		
	}
	
	function asignarPuestoEmpleado()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$x=0;
		$obj=json_decode($cadObj);
		$consulta[$x]="begin";
		$x++;
		
		if(!isset($obj->idTabulacion))
		{
			$institucion=obtenerInstitucionDepto($obj->departamento);
			if($institucion==$obj->departamento)
				$obj->departamento="";
			$consulta[$x]="update 801_adscripcion SET Institucion='".$institucion."' ,codigoUnidad='".$obj->departamento."' WHERE idUsuario=".$obj->idUsuario;
			$x++;
		}
		else
		{
			$institucion=obtenerInstitucionDepto($obj->departamento);
			if($institucion==$obj->departamento)
				$obj->departamento="";
			$query="SELECT '' as codUnidad,cvePuesto,p.idPuesto,p.zona,p.tipoPuesto,p.horasPuesto FROM 819_puestosOrganigrama p WHERE p.idPuesto=".$obj->idTabulacion;
			$filaPuesto=$con->obtenerPrimeraFila($query);
			
			
			/*$consulta[$x]="insert into 801_fumpEmpleado(idUsuario,tipoOperacion,fechaAplicacion,pQuincenaPago,pCicloPago,salario,fechaOperacion,respOperacion,idPuesto,activo,puesto,idTabulacion,departamento,tipoPuesto,zona,
							tipoContratacion,horasTrabajador,horasCategoria) values
							(".$obj->idUsuario.",1,'".$obj->fechaInicio."','".$obj->quincena."',".$obj->ciclo.",".$obj->salario.",'".date('Y-m-d')."',".$_SESSION["idUsr"].",".$filaPuesto[2].",1,'".$filaPuesto[1]."',".$obj->idTabulacion.
							",'".$filaPuesto[0]."',".$filaPuesto[3].",".$filaPuesto[4].",".$obj->tipoContratacion.",".$obj->horasContratacion.",".$filaPuesto[5].")";
			$x++;*/
			/*$consulta[$x]="update 653_unidadesOrgVSPuestos set situacion=1 where idUnidadVSPuesto=".$obj->idTabulacion;
			$x++;*/
			
			
			$consulta[$x]="update 801_adscripcion set idTipoJornada=".$obj->tipoJornada.",idTipoContrato=".$obj->tipoContrato.", cod_Puesto='".$filaPuesto[2]."',Institucion='".$institucion."',codigoUnidad='".$obj->departamento.
						"',tipoContratacion='".$obj->tipoContratacion."',horasTrabajador=".$obj->horasContratacion." where idUsuario=".$obj->idUsuario;
			
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function bajaPuestoEmpleado()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$x=0;
		
		/*$query="select idTabulacion,salario,tipoContratacion,horasTrabajador,horasCategoria from 801_fumpEmpleado where idFump=".$obj->idFump;

		$filaFum=$con->obtenerPrimeraFila($query);
		$idTabulacion=$filaFum[0];
		if($idTabulacion=="")
			$idTabulacion=-1;*/
		/*$query="select p.cvePuesto,p.tipoPuesto,p.zona,p.codigoUnidad,p.idPuesto from 819_puestosOrganigrama p,650_zonas z,
                   653_unidadesOrgVSPuestos uO,817_organigrama o,801_tiposPuesto tp 
                  where tp.idTipoPuesto=p.tipoPuesto and o.codigoUnidad=uO.codUnidad and z.id_650_zonas=p.zona and 
                   p.idPuesto=p.idPuesto and uO.idUnidadVSPuesto= ".$idTabulacion;

		$filaPuesto=$con->obtenerPrimeraFila($query);
		if(!$filaPuesto)
		{
			$filaPuesto[0]="";	
			$filaPuesto[1]=0;	
			$filaPuesto[2]=-1;	
			$filaPuesto[3]='';	
			$filaPuesto[4]="";	
		}*/
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 801_adscripcion set cod_Puesto='',codigoUnidad='',horasTrabajador=0,tipoContratacion=-1 where idUsuario=".$obj->idUsuario;
		$x++;
		/*$consulta[$x]="update  801_fumpEmpleado set activo=0 where idFump=".$obj->idFump;
		$x++;
		if($filaFum[1]=="")
			$filaFum[1]=0;
		if($filaFum[4]=="")
			$filaFum[4]=0;
		if($filaFum[3]=="")
			$filaFum[3]=0;
		if($filaPuesto[4]=="")
			$filaPuesto[4]=0;
		$consulta[$x]="insert into 801_fumpEmpleado(idUsuario,tipoOperacion,fechaAplicacion,uQuincenaPago,uCicloPago,salario,fechaOperacion,respOperacion,idTabulacion,activo,comentarios,
						puesto,departamento,tipoPuesto,zona,idPuesto,tipoContratacion,horasTrabajador,motivoBaja,horasCategoria) values
						(".$obj->idUsuario.",-1,'".$obj->fechaInicio."','".$obj->quincena."',".$obj->ciclo.",".$filaFum[1].",'".date('Y-m-d')."',".$_SESSION["idUsr"].",".$idTabulacion.",0,
						'".cv($obj->comentarios)."','".$filaPuesto[0]."','".$filaPuesto[3]."','".$filaPuesto[1]."','".$filaPuesto[2]."',".$filaPuesto[4].",".$filaFum[2].",".$filaFum[3].",".$obj->motivoBaja.",".$filaFum[4].")";

		$x++;
		$consulta[$x]="update 653_unidadesOrgVSPuestos set situacion=0 where idUnidadVSPuesto=".$idTabulacion;
		$x++;*/
		
		$consulta[$x]="commit";
		$x++;
		//varDump($consulta);
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";		

			
	}
	
	function modificarPuestoEmpleado()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$x=0;
		
		$query="select idTabulacion,salario,tipoContratacion,horasTrabajador from 801_fumpEmpleado where idFump=".$obj->idFump;
		$filaFum=$con->obtenerPrimeraFila($query);
		$idTabulacion=$filaFum[0];
		$query="select p.puesto,tp.tipoPuesto,z.NombreZona,o.unidad,t.codTabulacion from 652_tabulaciones t,819_puestosOrganigrama p,650_zonas z,
                   653_unidadesOrgVSPuestos uO,817_organigrama o,801_tiposPuesto tp 
                  where tp.idTipoPuesto=t.tipoPuesto and o.codigoUnidad=uO.codUnidad and  z.id_650_zonas=t.idZona and 
                   p.idPuesto=t.idPuesto and t.idTabulacion= ".$idTabulacion;
		echo $query."<br>";
		$filaPuesto=$con->obtenerPrimeraFila($query);
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update  801_fumpEmpleado set puesto='".$filaPuesto[0]."',departamento='".$filaPuesto[3]."',tipoPuesto='".$filaPuesto[1]."',
						zona='".$filaPuesto[2]."',codigoTabulacion='".$filaPuesto[4]."', activo=0 where idFump=".$obj->idFump;
		echo $consulta[$x]."<br>";
		$x++;
		$consulta[$x]="insert into 801_fumpEmpleado(idUsuario,tipoOperacion,fechaAplicacion,pQuincenaPago,pCicloPago,salario,fechaOperacion,respOperacion,idTabulacion,activo,comentarios,tipoContratacion,horasTrabajador) values
						(".$obj->idUsuario.",0,'".$obj->fechaInicio."','".$obj->quincena."',".$obj->ciclo.",".$obj->salario.",'".date('Y-m-d')."',".$_SESSION["idUsr"].",".$idTabulacion.",1,
						'".cv($obj->comentarios)."',".$filaFum[2].",".$filaFum[3].")";
		echo $consulta[$x]."<br>";
		$x++;
		$consulta[$x]="commit";
		$x++;
		echo "1|";
		return;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
			
	}
	
	function agregarConceptoNomina()
	{
		global $con;
		$listConceptos=$_POST["listConceptos"];
		$tipo=$_POST["tipo"];
		$idUsuario="NULL";
		if(isset($_POST["idUsuario"])&&($_POST["idUsuario"]!="-1"))
			$idUsuario=$_POST["idUsuario"];
		$idPerfil="-1";
		if(isset($_POST["idPerfil"]))
			$idPerfil=$_POST["idPerfil"];
		$tDestino="662_calculosNomina";
		$arrConceptos=explode(",",$listConceptos);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($idUsuario=="NULL")
			$query="select max(orden) from 662_calculosNomina where idUsuarioAplica is ".$idUsuario." and idPerfil=".$idPerfil;
		else
			$query="select max(orden) from 662_calculosNomina where idUsuarioAplica=".$idUsuario." and idPerfil=".$idPerfil;
		$orden=$con->obtenerValor($query);
		$orden++;
		foreach($arrConceptos as $concepto)
		{
			if($tipo==-1)
			{
				$tipo=0;
				$query="SELECT idTipoConcepto FROM 991_consultasSql WHERE idConsulta=".$concepto;
				$tipo=$con->obtenerValor($query);
				if(($tipo!=1)&&($tipo!=2))
					$tipo=0;
					
			}
			$consulta[$x]="insert into ".$tDestino." (idConsulta,idUsuarioAplica,situacion,tipoCalculo,orden,idPerfil) values(".$concepto.",".$idUsuario.",1,".$tipo.",".$orden.",".$idPerfil.")";
			$x++;	
			$orden++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function agregarAfectacionNomina()
	{
		global $con;
		$idConcepto=$_POST["idConcepto"];
		$accion=$_POST["accion"];
		$tipoConcepto=$_POST["tipoConcepto"];
		$afectacion=$_POST["afectacion"];
		if($accion=="1")
			$consulta="insert into 660_afectacionesDeducPercepciones(idDeduccionPercepcion,afectacion) values(".$idConcepto.",".$afectacion.")";
		else
			$consulta="delete from 660_afectacionesDeducPercepciones where idDeduccionPercepcion=".$idConcepto." and afectacion=".$afectacion;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function modificarTipoAfectacionNomina()
	{
		global $con;
		$idConcepto=$_POST["idConcepto"];
		$tipoConcepto=$_POST["tipoConcepto"];
		$afectacion=$_POST["afectacion"];
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="update 662_calculosNomina set afectacionNomina=".$afectacion." where idCalculo=".$idConcepto;
		$x++;
		
		if($afectacion!=3)
		{
			$query[$x]="DELETE FROM 670_quincenasAplicacionCalculosNomina WHERE idCalculo=".$idConcepto;
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
	}
	
	function modificarQuincenasAfectacion()
	{
		global $con;
		$idConcepto=$_POST["idConcepto"];
		$ciclo=$_POST["ciclo"];
		$quincena=$_POST["quincena"];
		$cualquierCiclo=$_POST["cualquierCiclo"];
		
		
		$query="SELECT idPerfil FROM 662_calculosNomina WHERE idCalculo=".$idConcepto;
		$idPerfil=$con->obtenerValor($query);
		
		$query="SELECT idPeriodicidad FROM 662_perfilesNomina WHERE idPerfilesNomina=".$idPerfil;
		$idPeriodicidad=$con->obtenerValor($query);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrQuincenas=explode(",",$quincena);
		foreach($arrQuincenas as $q)
		{

			$query="SELECT COUNT(*) FROM 670_quincenasAplicacionCalculosNomina WHERE idCalculo=".$idConcepto.
					" AND cicloAplicacion=".$ciclo." AND quincenaAplicacion=".$q;
			if($cualquierCiclo==1)
			{
				$query="SELECT COUNT(*) FROM 670_quincenasAplicacionCalculosNomina WHERE idCalculo=".$idConcepto.
					" AND cicloAplicacion is null AND quincenaAplicacion=".$q;
			}
			$numReg=$con->obtenerValor($query);
			if($numReg==0)
			{
				$consulta[$x]="INSERT INTO 670_quincenasAplicacionCalculosNomina (idCalculo,cicloAplicacion,quincenaAplicacion)
								VALUES(".$idConcepto.",".($cualquierCiclo=="1"?"NULL":$ciclo).",".$q.")";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			
			$cadAplicacionQuincena='<table width="100%">
											  <tr height=\'21\'>
												  <td align="right">
														  <a href="javascript:configurarQuincenasAplicacion(\''.$idConcepto.'\')"><img src="../images/pencil.png" alt="Configurar quincena aplicación" title="Configurar quincena aplicación"></a>
												  </td>
											  </tr>
											  <tr height="1">
												  <td style="background-color:#FF3">
												  </td>
											  </tr>
											  ';
					  
					  
			  $consulta="SELECT idRegistro,cicloAplicacion,quincenaAplicacion FROM 670_quincenasAplicacionCalculosNomina WHERE idCalculo=".$idConcepto.
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
			
			
			
			echo "1|".$leyenda;
		}
		else
			echo "|";
	}
	
	function obtenerConceptosDisponibles()
	{
		global $con;
		$tipo=$_POST["tipo"];
		$idUsuario=$_POST["idUsuario"];
		$nTabla="662_calculosNomina";
		$idPerfil="-1";
		if(isset($_POST["idPerfil"]))
			$idPerfil=$_POST["idPerfil"];
		if($tipo==0)
		{
			$consulta="select idConsulta,codigo,nombreConsulta,descripcion from 991_consultasSql where idTipoConcepto=".$tipo." and situacion=1 
						and idConsulta not in (select idConsulta from ".$nTabla."  where tipoCalculo=".$tipo." and idPerfil=".$idPerfil.") and tipoConsulta<>10";
		}
		else
		{
			if($idUsuario!="-1")
			{
				$consulta="select idConsulta,codigo,nombreConsulta,descripcion from 991_consultasSql where idTipoConcepto=".$tipo." and situacion=1 
						and idConsulta not in (select idConsulta from ".$nTabla."  where idUsuarioAplica = ".$idUsuario." and tipoCalculo=".$tipo." and idPerfil=".$idPerfil.")";
			}
			else
			{
				$consulta="select idConsulta,codigo,nombreConsulta,descripcion from 991_consultasSql where idTipoConcepto=".$tipo." and situacion=1 
						and idConsulta not in (select idConsulta from ".$nTabla."  where idUsuarioAplica is null and tipoCalculo=".$tipo." and idPerfil=".$idPerfil.")";
			
			}
		}

		$arrConceptos=uEJ($con->obtenerFilasArreglo($consulta));	
		echo "1|".$arrConceptos;
	}
	
	function guardarCuentaBancaria()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$idCuentaUsuario=$obj->idCuentaUsuario;
		$consulta="";
		if($idCuentaUsuario=="-1")
		{
			$consulta="insert into 823_cuentasUsuario(idUsuario,idBanco,cuenta,clabe,usuarioTitular,titular,comentarios) values
						(".$obj->idUsuario.",".$obj->idBanco.",'".cv($obj->cuenta)."','".cv($obj->clabe)."',".$obj->usuarioTitular.",'".cv($obj->titular)."','".cv($obj->comentarios)."')";
		}
		else
		{
			$consulta="update 823_cuentasUsuario set idBanco=".$obj->idBanco.",cuenta='".cv($obj->cuenta)."',clabe='".cv($obj->clabe)."',usuarioTitular=".$obj->usuarioTitular.",
						titular='".cv($obj->titular)."',comentarios='".cv($obj->comentarios)."' where idCuentaUsuario=".$obj->idCuentaUsuario;

		}
		if($con->ejecutarConsulta($consulta))
		{
			if($idCuentaUsuario=="-1")
				$idCuentaUsuario=$con->obtenerUltimoID();
			echo "1|".$idCuentaUsuario;
		}
		else
			echo "|";
	}
	
	function eliminarCuentaBancaria()
	{
		global $con;
		$listCuentas=$_POST["listCuentas"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 823_cuentasUsuario where idCuentaUsuario in (".$listCuentas.")";
		$x++;
		$consulta[$x]="update  801_adscripcion set  idCuentaDeposito=null where idCuentaDeposito in(".$listCuentas.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerCalculosDisponiblesNomina()
	{
		global $con;
		$tipo=$_POST["tipo"];
		$idUsuario=($_POST["idUsuario"]);
		$orden=bD($_POST["orden"]);
		$consulta="";
		$comp="and c.orden<".$orden;
		if($idUsuario!=-1)
			$comp="";
		switch($tipo)
		{
			case 2:
				
				$consulta="select idCalculo, concat(orden,'.- [',co.codigo,'] ',co.nombreConsulta) from 662_calculosNomina c,991_consultasSql co where co.idConsulta=c.idConsulta and c.tipoCalculo=1 and c.idUsuarioAplica is null ".$comp;
			break;
			case 3:
				$consulta="select idCalculo, concat(orden,'.- [',co.codigo,'] ',co.nombreConsulta) from 662_calculosNomina c,991_consultasSql co where co.idConsulta=c.idConsulta and c.tipoCalculo=2 and c.idUsuarioAplica is null ".$comp;
			break;
			case 4:
				$consulta="select idCalculo, concat(orden,'.- [',co.codigo,'] ',co.nombreConsulta) from 662_calculosNomina c,991_consultasSql co where co.idConsulta=c.idConsulta and c.tipoCalculo=1 and c.idUsuarioAplica =".$idUsuario." and c.orden<".$orden;
			break;
			case 5:
				$consulta="select idCalculo, concat(orden,'.- [',co.codigo,'] ',co.nombreConsulta) from 662_calculosNomina c,991_consultasSql co where co.idConsulta=c.idConsulta and c.tipoCalculo=2 and c.idUsuarioAplica =".$idUsuario." and c.orden<".$orden;
			break;
		}
		$arrCalculos=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrCalculos);
	}
	
	function guardarValorParametroNomina()
	{
		global $con;
		$tipoParam=$_POST["tipoParam"];
		$valor=$_POST["valor"];
		$idConsulta=bD($_POST["idConsulta"]);
		$idParam=bD($_POST["idParam"]);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 663_valoresCalculos where idCalculo=".$idConsulta." and idParametro=".$idParam;
		$x++;
		$consulta[$x]="insert into 663_valoresCalculos(idCalculo,valor,tipoValor,idParametro) values(".$idConsulta.",'".$valor."',".$tipoParam.",".$idParam.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function modificarOrdenCalculo()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idCalculo=bD($_POST["idCalculo"]);
		$nOrden=$_POST["orden"];
		$query="select orden from 662_calculosNomina where idCalculo=".$idCalculo;
		$vOrden=$con->obtenerValor($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($nOrden>$vOrden)
		{
			if($idUsuario==-1)
				$consulta[$x]="update 662_calculosNomina set orden=orden-1 where orden<=".$nOrden." and orden>".$vOrden." and idUsuarioAplica is null";
			else
				$consulta[$x]="update 662_calculosNomina set orden=orden-1 where orden<=".$nOrden." and orden>".$vOrden." and idUsuarioAplica = ".$idUsuario;
		}
		else
		{
			if($idUsuario==-1)
				$consulta[$x]="update 662_calculosNomina set orden=orden+1 where orden>=".$nOrden." and orden<".$vOrden." and idUsuarioAplica is null";
			else
				$consulta[$x]="update 662_calculosNomina set orden=orden+1 where orden>=".$nOrden." and orden<".$vOrden." and idUsuarioAplica = ".$idUsuario;
		}
		$x++;
		$consulta[$x]="update 662_calculosNomina set orden=".$nOrden." where idCalculo=".$idCalculo;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	
	}
	
	function obtenerElementosPais()
	{
		global $con;
		$accion=$_POST["accion"];
		$codigo=$_POST["codigo"];
		$consulta="";
		switch($accion)
		{
			case 1:
				$consulta="select cveMunicipio,municipio from 821_municipios where cveEstado='".$codigo."' order by municipio";
			break;	
			case 2:
				$consulta="select cveLocalidad,localidad from 822_localidades where cveMunicipio='".$codigo."' order by localidad";
			break;	
			case 3:
				$consulta="select cveColonia,nombreColonia from 822_colonias where cveLocalidad='".$codigo."' order by nombreColonia";
			break;	
			case 4:
				$consulta="SELECT cveEstado,estado FROM 820_estados WHERE idPais= '".$codigo."' ORDER BY estado";
			break;	
			
		}
		$arrElemento=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrElemento);
			
	}
	
	function activarDesactivarUnidad()
	{
		global $con;
		$activo=$_POST["activo"];
		$codUnidad=$_POST["codUnidad"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$query="select institucion from 817_organigrama where codigoUnidad='".$codUnidad."'";
		$institucion=$con->obtenerValor($query);
		if($institucion==1)
		{
			$consulta[$x]=" insert into 817_historialOrganigrama(unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,cp,ciudad,estado,idPais,municipio,colonia,calle,numero,fechaModificacion,idResponsableModificacion,accion)
							select unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,cp,ciudad,estado,idPais,municipio,colonia,calle,numero,'".date('Y-m-d')."' as 'fechaModificacion', '".$_SESSION["idUsr"]."' as 'responsable','".(2+$activo)."' as accion 
							from 817_organigrama o,247_instituciones i  where i.idOrganigrama=o.idOrganigrama
							and o.codigoUnidad like '".$codUnidad."%'";
			$x++;
		}
		else
		{
			$consulta[$x]="insert into 817_historialOrganigrama(unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,fechaModificacion,idResponsableModificacion,accion)
							select unidad,descripcion,codCentroCosto,codigoDepto,claveDepartamental,'".date('Y-m-d')."' as 'fechaModificacion', '".$_SESSION["idUsr"]."' as 'responsable','".(2+$activo)."' as accion from 817_organigrama o  where 
							o.codigoUnidad like '".$codUnidad."%'";
							
			$x++;
		}
		$consulta[$x]="update 817_organigrama set status=".$activo." where codigoUnidad like '".$codUnidad."%'";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerPuestosAsocCalculo()
	{
		global $con;
		$idCalculo=$_POST["idCalculo"]	;
		$consulta="SELECT idCalculoVSPuesto,po.cvePuesto,po.puesto FROM 9115_calculosVSPuestos c,819_puestosOrganigrama po WHERE po.idPuesto=c.idPuesto
					and  idCalculo=".$idCalculo." ORDER BY po.puesto";
		$arrPuestos=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrPuestos;
	}
	
	function obtenerPuestosDisponiblesAsocCalculo()
	{
		global $con;
		$idCalculo=$_POST["idCalculo"]	;
		$listPuesto="";
		$consulta="select idPuesto from 9115_calculosVSPuestos where idCalculo=".$idCalculo;
		$listPuesto=$con->obtenerListaValores($consulta);
		if($listPuesto=="")
			$listPuesto="-1";
		//$consulta="SELECT po.idPuesto,po.cvePuesto,po.puesto FROM 819_puestosOrganigrama po WHERE po.idPuesto not in (".$listPuesto.") and codigoUnidad='".$_SESSION["codigoInstitucion"]."' ORDER BY po.puesto";
		$consulta="SELECT po.idPuesto,po.cvePuesto,po.puesto FROM 819_puestosOrganigrama po WHERE po.idPuesto not in (".$listPuesto.")  ORDER BY po.puesto";
		
		
		$consulta="SELECT id__632_tablaDinamica,cvePuesto,nombrePuesto FROM _632_tablaDinamica WHERE idEstado=2";
		
		$arrPuestos=utf8_encode($con->obtenerFilasArreglo($consulta));
		
		echo "1|".$arrPuestos;
	}
	
	function crearUnidadProcesoInscripcion()
	{
		global $con;
		global $lPorcionCodFun;

		$cadObj=$_POST["param"];
		$obj=json_decode($cadObj);
		$codigoUPadre=$obj->codigoUPadre;
		$codUnidad="";
		if(isset($obj->codUnidad))
			$codUnidad=$obj->codUnidad;
		
		$telefonos="";
		if(isset($obj->telefonos))
		{
			$telefonos=$obj->telefonos;
		}
		
		$idUsuario="-1000";
		if(isset($_SESSION["idUsr"]))
			$idUsuario=$_SESSION["idUsr"];
		
		$query="select codigoFuncional from 817_organigrama where codigoUnidad='".$codigoUPadre."'";

		$codigoF=$con->obtenerValor($query);
		$codigoFuncionalNuevo="";
		$codigoUnidadNuevo="";
		$x=0;
		$cadComodines=str_pad("",$lPorcionCodFun,'_',STR_PAD_LEFT);
		$codigoInicial=str_pad("1",$lPorcionCodFun,'0',STR_PAD_LEFT);
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			/*if(($codigoF==$codigoUPadre)&&($codigoF!=""))
			{
				$codigoFuncionalNuevo=$codigoF.$codigoInicial;
				$codigoUnidadNuevo=$codigoF.$codigoInicial;
				$consulta[$x]="update 817_organigrama set codigoFuncional=RPAD(codigoFuncional,".strlen($codigoFuncionalNuevo).",'0')";
				$x++;
				$consulta[$x]="update 903_variablesSistema set codigoFuncionalRaiz=RPAD(codigoFuncionalRaiz,".strlen($codigoFuncionalNuevo).",'0')";
				$x++;
			}
			else
			{
				$tamCodigo=strlen($codigoF);
				$codBusquedaOrigen=str_pad($codigoUPadre.$codigoInicial,$tamCodigo,'0',STR_PAD_RIGHT);
				$query="select codigoUnidad from 817_organigrama where codigoFuncional ='".$codBusquedaOrigen."'";
				$res=$con->obtenerValor($query);
				if($res!="")
				{
					$codBusqueda=str_pad($codigoUPadre.$cadComodines,$tamCodigo,'0',STR_PAD_RIGHT);
					//$query="select max(codigoUnidad) from 817_organigrama where codigoFuncional like '".$codBusqueda."'";
					
				}
				else
				{
					$valor=$codigoUPadre.$codigoInicial;	
					$codigoFuncionalNuevo=str_pad($valor,$tamCodigo,'0',STR_PAD_RIGHT);
					$codigoUnidadNuevo=$valor;
				}
			}*/
			$tamCodigo=strlen($codigoF);
			$query="select max(codigoUnidad) from 817_organigrama where institucion=1";
			$valor=$con->obtenerValor($query);
			$codigoResto=substr($valor,0,strlen($valor)-$lPorcionCodFun);
			$codUltimaUnidad=substr($valor,strlen($valor)-$lPorcionCodFun);
			$codUltimaUnidad++;
			$codUltimaUnidad=str_pad($codUltimaUnidad,$lPorcionCodFun,'0',STR_PAD_LEFT);
			$tamValorO=strlen($valor);
			$valor+=1;
			$tamValorD=strlen($valor);
			$difCond=$tamValorO-$tamValorD;
			$valor=$codigoResto.$codUltimaUnidad;
			
			$codigoUnidadNuevo=$valor;
			$codigoFuncionalNuevo=str_pad($valor,$tamCodigo,'0',STR_PAD_RIGHT);
			$query="insert into 817_organigrama(unidad,codigoFuncional,codigoUnidad,descripcion,institucion,instColaboradora) 
					value('".cv($obj->nombre)."','".$codigoFuncionalNuevo."','".$codigoUnidadNuevo."','',".$obj->institucion.",1)";
			if($con->ejecutarConsulta($query))		
			{
				$idOrganigrama=$con->obtenerUltimoID();
				if(isset($obj->objInst))
				{
					$objInst=$obj->objInst;
					$consulta[$x]="insert into 247_instituciones(idOrganigrama,cp,ciudad,estado,municipio,colonia,idPais,fechaCreacion,responsable,tipoInstitucion,email) values
					('".$idOrganigrama."','".cv($objInst->cp)."','".cv($objInst->localidad)."','".cv($objInst->estado)."','".cv($objInst->municipio)."','".cv($objInst->colonia)
					."',".cv($objInst->idPais).",'".date("Y-m-d")."',".$idUsuario.",".$obj->tipoInstitucion.",'".cv($obj->email)."')";
					$x++;	
				}
				
				if($telefonos!="")
				{
					$arrTelefonos=explode(",",$telefonos);
					$nTel=sizeof($arrTelefonos);
					for($y=0;$y<$nTel;$y++)
					{
						$datosTel=explode("_",$arrTelefonos[$y]);
						$tipo=$datosTel[0];
						$codArea=$datosTel[1];
						$lada=$datosTel[2];
						$tel=$datosTel[3];
						$ext=$datosTel[4];
						$consulta[$x]="	insert into 818_telefonosOrganigrama(codArea,lada,telefono,extension,tipoTel,idOrganigrama) 
										values('".$codArea."','".$lada."','".$tel."','".$ext."',".$tipo.",".$idOrganigrama.")";
						$x++;	
					}
				}
				$consulta[$x]="commit";
				$x++;
				if($con->ejecutarBloque($consulta))
					echo "1|".$idOrganigrama."|".$codigoUnidadNuevo;
				else
					echo "|";
			}
		}
		else
			echo "|";
	}
	
	function seleccionarTodoTipoContratacion()
	{
		global $con;
		$idCalculo=$_POST["iC"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from `660_afectacionesDeducPercepciones` WHERE idDeduccionPercepcion=".$idCalculo;
		$x++;
		$query="SELECT txtClave FROM _669_tablaDinamica";
		$resPuesto=$con->obtenerFilas($query);
		while($f=mysql_fetch_row($resPuesto))
		{
			$consulta[$x]="insert into 660_afectacionesDeducPercepciones(idDeduccionPercepcion,afectacion) values(".$idCalculo.",".$f[0].")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerResponsablesUnidad()
	{
		global $con;
		$codigoUnidad=$_POST["codigoUnidad"];
		$consulta="SELECT idOrganigrama,institucion FROM 817_organigrama WHERE codigoUnidad='".$codigoUnidad."'";
		$fUnidad=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT rol FROM 817_rolesVSCategoriasOrganigrama WHERE idCategoria=".$fUnidad[1];
		$res=$con->obtenerFilas($consulta);
		$cadUnidad="";
		$arrHijos=obtenerResponsablesAsignadosUnidad($codigoUnidad,"-3000_0");
		
		if($arrHijos=="[]")
			$cadUnidad='{"tipoNodo":"0","id":"-3000_0","text":"'.obtenerTituloRol('-3000_0').'","icon":"../images/vcard.png","leaf":true}';	
		else
			$cadUnidad='{"tipoNodo":"0","id":"-3000_0","text":"'.obtenerTituloRol('-3000_0').'","icon":"../images/vcard.png","leaf":false,"children":'.$arrHijos.'}';	
		while($fila=mysql_fetch_row($res))
		{
			if($fila[0]!="-3000_0")
			{
				$arrHijos=obtenerResponsablesAsignadosUnidad($codigoUnidad,$fila[0]);
				if($arrHijos=="[]")
					$objUnidad='{"tipoNodo":"0","id":"'.$fila[0].'","text":"'.obtenerTituloRol($fila[0]).'","icon":"../images/vcard.png","leaf":true}';	
				else
					$objUnidad='{"tipoNodo":"0","id":"'.$fila[0].'","text":"'.obtenerTituloRol($fila[0]).'","icon":"../images/vcard.png","leaf":false,"children":'.$arrHijos.'}';	
				$cadUnidad.=",".$objUnidad;
			}
		}
		echo '['.$cadUnidad.']';
	}
	
	function obtenerResponsablesAsignadosUnidad($codigoUnidad,$rol)
	{
		global $con;
		$arrHijos="";
		$consulta="select idResponsable,idUsuario from 817_responsablesUnidad where codigoUnidad='".$codigoUnidad."' and rol='".$rol."'";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$objUnidad='{"tipoNodo":"1","id":"'.$fila[0].'","text":"'.obtenerNombreUsuario($fila[1]).'","icon":"../images/user_gray.png","leaf":true}';	
			if($arrHijos=="")
				$arrHijos=$objUnidad;
			else
				$arrHijos.=",".$objUnidad;
		}
		
		return '['.$arrHijos.']';
	}
	
	
	function removerResponsableUnidad()
	{
		global $con;
		$idResponsable=$_POST["idResponsable"];
		$consulta="DELETE FROM 817_responsablesUnidad WHERE idResponsable=".$idResponsable;
		eC($consulta);	
	}
	
	function agregarResponsableUnidad()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="select count(*) from 817_responsablesUnidad where codigoUnidad='".$obj->codigoUnidad."' and idUsuario=".$obj->idUsuario." and rol='".$obj->rol."'";
		$nReg=$con->obtenerValor($query);
		if($nReg==0)
		{
			$consulta[$x]="INSERT INTO 817_responsablesUnidad(idUsuario,rol,codigoUnidad) VALUES(".$obj->idUsuario.",'".$obj->rol."','".$obj->codigoUnidad."')";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerElementosPaisV2()
	{
		global $con;
		$accion=$_POST["accion"];
		$codigo=$_POST["codigo"];
		$consulta="";
		switch($accion)
		{
			case 1:
				$consulta="select cveMunicipio,municipio from 821_municipiosV2 where cveEstado='".$codigo."' order by municipio";
			break;	
			case 2:
				$consulta="select cveLocalidad,localidad from 822_localidadesV2 where cveMunicipio='".$codigo."' order by localidad";
			break;	
			case 3:
				$consulta="select cveColonia,nombreColonia from 822_coloniasV2 where cveLocalidad='".$codigo."' order by nombreColonia";
			break;	
			
		}
		$arrElemento=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrElemento);
			
	}
	
	function obtenerOrganigramaAdscripcion()
	{
		global $con;
		global $SO;
		$comp="";		
		$ignorarAdscripcion=0;
		
		$idUsuario=$_POST["idUsuario"];
		if(isset($_POST["ignorarAdscripcion"]))
			$ignorarAdscripcion=$_POST["ignorarAdscripcion"];
			
			
		$consulta="SELECT  Institucion from 801_adscripcion WHERE idUsuario=".$idUsuario;
		$adscripcion=$con->obtenerValor($consulta);
		
		if(!existeRol("'-3000_0'"))
		{
			$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,status,
					(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,permiteAdscripcion from 817_organigrama where  
					(unidadPadre='' or unidadPadre is null) ".($ignorarAdscripcion==0?"and permiteAdscripcion=1":"")." order by  codigoFuncional";
		}
		else
		{
			$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,status,
					(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,permiteAdscripcion from 817_organigrama 
					where codigoUnidad='".$_SESSION["codigoInstitucion"]."' ".($ignorarAdscripcion==0?"and permiteAdscripcion=1":"")." order by  codigoFuncional";
		}
		

		
		$resOrg=$con->obtenerFilas($consulta);	
		$arrUnidades="";
		while($fila=mysql_fetch_row($resOrg))
		{
			$codFun=$fila[3];
			$codigoF=$fila[3];
			if($fila[5]=="1")
			{
				$color="#033";
				if($fila[10]=="2")
					$color="#060";
				$texto="<font color='".$color."'>".cv($fila[0])."</font>";
				$consulta="select i.*,p.nombre from 247_instituciones i,238_paises p where p.idPais=i.idPais and i.idOrganigrama=".$fila[2];
				$filaD=$con->obtenerPrimeraFila($consulta);
				$desc="";
				$cp=$filaD[2];
				
				$ciudad=$filaD[3];
				$estado=$filaD[4];
				$pais=$filaD[12];
				$municipio=$filaD[8];
				$idPais=$filaD[5];
				$colonia=$filaD[9];
				$calle=$filaD[10];
				$numero=$filaD[11];
				$descripcion="";
				if($calle!="")
					$descripcion="Calle ".$calle." ";
				
				if($numero!="")
					$descripcion.="N&uacute;mero:  ".$numero." ";
				
				if($colonia!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT nombreColonia FROM 822_colonias WHERE cveColonia='".$colonia."'";
						$colonia=$con->obtenerValor($consulta);
					}
					$descripcion.="Colonia ".$colonia.", ";
				}
				if($ciudad!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT localidad FROM 822_localidades WHERE cveLocalidad='".$ciudad."'";
						$ciudad=$con->obtenerValor($consulta);
					}
					
					$descripcion.=$ciudad.", "; 	
				}
				if($municipio!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$municipio."'";
						$municipio=$con->obtenerValor($consulta);
					}
					
					$descripcion.=$municipio.", "; 	
				}
				
				if($estado!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$estado."'";
						$estado=$con->obtenerValor($consulta);
					}
					
					$descripcion.=$estado.", "; 	
				}
				$descripcion.=$pais;
				
				if($cp!="")
					$cp=", C.P. ".$cp.".";
				$descripcion.=$cp;
				
				if($SO==2)
					$desc="<br>(".$descripcion.")";
				else
					$desc="<br>(".($descripcion).")";
			}
			else
			{
				$texto=cv($fila[0]);
				$desc="";
			}
			$consulta="	select tipoTel,codArea,lada,telefono,extension from 818_telefonosOrganigrama where idOrganigrama=".$fila[2];
			$resTel=$con->obtenerFilas($consulta);	
			$descTel="";
			$arrTel="";
			while($filaTel=mysql_fetch_row($resTel))
			{
				$tipoTel="";
				switch($filaTel[0])
				{
					case 0:
						$tipoTel='Tel\u00E9fono';	
					break;
					case 2:
						$tipoTel='Fax';
					break;
				}
				$extension="";
				if($filaTel[4]!="")
					$extension="Ext.: ".$filaTel[4];
				
				$tel="[".$tipoTel."] (".$filaTel[1].") ".$filaTel[2]."-".$filaTel[3]." (".$extension.")";
				if($descTel=="")
					$descTel=$tel;
				else
					$descTel.="<br>".$tel;
				$telCod=$filaTel[0]."_".$filaTel[1]."_".$filaTel[2]."_".$filaTel[3]."_".$filaTel[4];
				
				if($arrTel=="")
					$arrTel=$telCod;
				else
					$arrTel.=",".$telCod;
			}
			$adscribeInstitucion=$fila[12];
			$consulta="select tituloCentroC from 506_centrosCosto where codigoCompleto='".$fila[6]."'";
			$cc=$con->obtenerValor($consulta);
			$consulta="SELECT email FROM 818_mailOrganigrama WHERE idOrganigrama=".$fila[2];
			$mails=$con->obtenerListaValores($consulta,"");
			$objUnidad='{'.($adscribeInstitucion==1?("checked:".($adscripcion==$fila[1]?"true,":"false,")):"").'"adscribeInstitucion":"'.$fila[12].'","mails":"'.$mails.'","codigoInstitucion":"'.$fila[1].'","status":"'.$fila[10].'","activo":"'.$fila[11].'",unidadPadre:"'.$fila[7].'",codigoIndividual:"'.$fila[8].'",id:"'.$fila[2].'",text:"'.($texto).'",CC:"'.$fila[6].'",'.
					'CCDescrip:"'.$cc.'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",desc:"'.$desc.'",'.
					'"telefonos":"'.$arrTel.'","descTel":"'.$descTel.'","codDepto":"'.$fila[9].'","cveDeptal":"N/A"';
			$hijos='';
			$hijos=obtenerUnidadesHijasAdscripcion($fila[1],$fila[1],$ignorarAdscripcion,$adscripcion);																								  
			if($hijos=='')
				$objUnidad.=',leaf:true,icon:"../images/users.png"}';
			else
				$objUnidad.=',children:['.$hijos.'],icon:"../images/user.png"}';
			if($arrUnidades=="")
				$arrUnidades=$objUnidad;
			else
				$arrUnidades.=",".$objUnidad;
		}		
		
		
		echo "[".($arrUnidades)."]";
	}
	
	function obtenerUnidadesHijasAdscripcion($codigoFun,$institucion,$ignorarAdscripcion,$adscripcion)
	{
		global $con;
		global $lPorcionCodFun;
		global $SO;
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,
			codigoDepto,claveDepartamental,status,(case status when '1'  then 'Activo' when '0' then 'Inactivo' when '2' then 'Concentrador' end) as activo,permiteAdscripcion  
			from 817_organigrama where unidadPadre = '".$codigoFun."' ".($ignorarAdscripcion==0?"and permiteAdscripcion=1":"")." order by unidad";
		$res=$con->obtenerFilas($consulta);
		$arrHijos="";
		$objHijo="";
		$hijos="";
		$codigoF="";
		while($fila=mysql_fetch_row($res))
		{
			
			$desc="";
			$consulta="	select tipoTel,codArea,lada,telefono,extension from 818_telefonosOrganigrama where idOrganigrama=".$fila[2];
			$resTel=$con->obtenerFilas($consulta);	
			$descTel="";
			$arrTel="";
			while($filaTel=mysql_fetch_row($resTel))
			{
				$tipoTel="";
				switch($filaTel[0])
				{
					case 0:
						$tipoTel='Tel\u00E9fono';	
					break;
					case 2:
						$tipoTel='Fax';
					break;
				}
				$extension="";
				if($filaTel[4]!="")
					$extension="Ext.: ".$filaTel[4];
				
				$tel="[".$tipoTel."] (".$filaTel[1].") ".$filaTel[2]."-".$filaTel[3]." (".$extension.")";
				if($descTel=="")
					$descTel=$tel;
				else
					$descTel.="<br>".$tel;
				$telCod=$filaTel[0]."_".$filaTel[1]."_".$filaTel[2]."_".$filaTel[3]."_".$filaTel[4];
				
				if($arrTel=="")
					$arrTel=$telCod;
				else
					$arrTel.=",".$telCod;
			}
			
			if(true)
			{
				$codigoF=$fila[3];
				$color="#033";
				if($fila[11]=="2")
					$color="#060";
				$texto="<font color='".$color."'>".cv($fila[0])."</font>";
				
				$consulta="select i.*,p.nombre from 247_instituciones i,238_paises p where p.idPais=i.idPais and i.idOrganigrama=".$fila[2];
				$filaD=$con->obtenerPrimeraFila($consulta);
				$desc="";
				$cp=$filaD[2];
				
				$ciudad=$filaD[3];
				$estado=$filaD[4];
				$pais=$filaD[12];
				$municipio=$filaD[8];
				$idPais=$filaD[5];
				$colonia=$filaD[9];
				$calle=$filaD[10];
				$numero=$filaD[11];
				$descripcion="";
				if($calle!="")
					$descripcion="Calle ".$calle." ";
				
				if($numero!="")
					$descripcion.="N&uacute;mero:  ".$numero." ";
				
				if($colonia!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT nombreColonia FROM 822_colonias WHERE cveColonia='".$colonia."'";
						$colonia=$con->obtenerValor($consulta);
					}
					$descripcion.="Colonia ".$colonia.", ";
				}
				if($ciudad!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT localidad FROM 822_localidades WHERE cveLocalidad='".$ciudad."'";
						$ciudad=$con->obtenerValor($consulta);
					}
					
					$descripcion.=$ciudad.", "; 	
				}
				if($municipio!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$municipio."'";
						$municipio=$con->obtenerValor($consulta);
					}
					
					$descripcion.=$municipio.", "; 	
				}
				
				if($estado!="")
				{
					if($idPais=="146")
					{
						$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$estado."'";
						$estado=$con->obtenerValor($consulta);
					}
					
					$descripcion.=$estado.", "; 	
				}
				$descripcion.=$pais;
				
				if($cp!="")
					$cp=", C.P. ".$cp.".";
				$descripcion.=$cp;
				
				if($SO==2)
					$desc="<br>(".$descripcion.")";
				else
					$desc="<br>(".($descripcion).")";
			}
			
			

			$cc='';
			$cveDeptal=$fila[10];
			$consulta="SELECT email FROM 818_mailOrganigrama WHERE idOrganigrama=".$fila[2];
			$mails=$con->obtenerListaValores($consulta,"");
			$adscribeInstitucion=$fila[13];
			$objHijo='{'.($adscribeInstitucion==1?("checked:".($adscripcion==$fila[1]?"true,":"false,")):"").'"adscribeInstitucion":"'.$adscribeInstitucion.'","mails":"'.$mails.'","codigoInstitucion":"'.$institucion.'",'.
					'"status":"'.$fila[11].'","activo":"'.$fila[12].'",unidadPadre:"'.$fila[7].'",codigoIndividual:"'.$fila[8].'",id:"'.$fila[2].'",text:"'.$texto.'",'.
					'CC:"'.$fila[6].'",CCDescrip:"'.$cc.'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",'.
					'desc:"'.$desc.'","telefonos":"'.$arrTel.'","descTel":"'.$descTel.'","codDepto":"'.$fila[9].'","cveDeptal":"'.$cveDeptal.'"';
			$hijos=obtenerUnidadesHijasAdscripcion($fila[1],$fila[1],$ignorarAdscripcion,$adscripcion);
			if($hijos=='')
				$objHijo.=',leaf:true,icon:"../images/users.png"}';
			else
				$objHijo.=',children:['.$hijos.'],icon:"../images/user.png"}';
			if($arrHijos=='')
				$arrHijos=$objHijo;
			else
				$arrHijos.=",".$objHijo;
		}
		return $arrHijos;
	}
	
	
	function obtenerIDRegistroNodoOrganigrama()
	{
		global $con;
		$idProceso=$_POST["p"];
		$rolIngreso=$_POST["r"];
		$codigoUnidad=$_POST["u"];
		$idFormulario=obtenerFormularioBase($idProceso);
		
		$consulta="SELECT id__".$idFormulario."_tablaDinamica,idEstado FROM _".$idFormulario."_tablaDinamica WHERE claveUnidad='".$codigoUnidad."'";
		$fila=$con->obtenerPrimeraFila($consulta);
		
		$actor=obtenerActorProcesoIdRol($idProceso,$rolIngreso,$fila[1]);
		$act=bE($actor);
			
		echo "1|".$fila[0]."|".bE("auto")."|".$act."|".$idFormulario;
		
			
	}
	
	function obtenerMunicipiosOrganigrama()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$consulta="SELECT distinct claveDepartamental as codigoMunicipio,unidad as nombreMunicipio FROM 817_organigrama WHERE institucion=13 and unidad like '%".$criterio."%'  ORDER BY unidad";
		$arrJurisdiccion=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrJurisdiccion.'}';
	}
?>