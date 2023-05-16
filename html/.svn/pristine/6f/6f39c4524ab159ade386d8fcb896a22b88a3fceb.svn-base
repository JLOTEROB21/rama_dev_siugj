<?php session_start();
	include("centrogeo/conexionBD.php");
	$parametros="";
	$lPorcionCodFun=5; //cambar tambien en funciones proyectos
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
				if($codigoF==$codigoUPadre)
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
						$query="select max(codigoUnidad) from 817_organigrama where codigoFuncional like '".$codBusqueda."'";
						$valor=$con->obtenerValor($query);
						$codigoResto=substr($valor,0,strlen($valor)-5);
						$codUltimaUnidad=substr($valor,strlen($valor)-5);
						$codUltimaUnidad++;
						$codUltimaUnidad=str_pad($codUltimaUnidad,$lPorcionCodFun,'0',STR_PAD_LEFT);
						$tamValorO=strlen($valor);
						$valor+=1;
						$tamValorD=strlen($valor);
						$difCond=$tamValorO-$tamValorD;
						$valor=$codigoResto.$codUltimaUnidad;
						$codigoUnidadNuevo=$valor;
						$codigoFuncionalNuevo=str_pad($valor,$tamCodigo,'0',STR_PAD_RIGHT);
					}
					else
					{
						$valor=$codigoUPadre.$codigoInicial;	
						$codigoFuncionalNuevo=str_pad($valor,$tamCodigo,'0',STR_PAD_RIGHT);
						$codigoUnidadNuevo=$valor;
					}
				}
				
				
				
				$codCC="";
				if(isset($obj->CC))
					$codCC=$obj->CC;
				
				$query="insert into 817_organigrama(unidad,codigoFuncional,codigoUnidad,descripcion,institucion,codCentroCosto) 
						value('".cv($obj->nombre)."','".$codigoFuncionalNuevo."','".$codigoUnidadNuevo."','".cv($obj->descripcion)."',".$obj->institucion.",'".$codCC."')";
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
		$query="select codigoUnidad from 817_organigrama where unidadPadre='".$codUnidad."'";
		$resUnidad=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($resUnidad))
		{
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
		$codU=$_POST["codU"];
		$consulta="select o.unidad as institucion,cp,ciudad,estado,idPais from 247_instituciones i,817_organigrama o  where o.idOrganigrama=i.idOrganigrama and o.codigoUnidad = '".$codU."'";
		$obj=$con->obtenerFilasJson($consulta);
		if($SO==2)
			echo "1|".($obj);
		else
			echo "1|".utf8_encode($obj);
	}
	
	function obtenerPuestos()
	{
		global $con;
		$codigoU=$_POST["codigoU"];
		$consulta="select idPuesto,puesto as puesto,(select count(idTabulacion) from 652_tabulaciones where idPuesto=po.idPuesto and situacion=1) as numPuesto,cvePuesto,
					(select count(idTabulacion) from 652_tabulaciones where idPuesto=po.idPuesto and situacion=1 and idTabulacion in (select idTabulacion from 653_unidadesOrgVSPuestos)) as nPuestosAsign,
					(select count(idTabulacion) from 652_tabulaciones where idPuesto=po.idPuesto and situacion=1 and idTabulacion in (select idTabulacion from 653_unidadesOrgVSPuestos where situacion=1)) as nPuestosOcu
				   from 819_puestosOrganigrama po where codigoUnidad='".$codigoU."' order by puesto";
		$arrPuestos=$con->obtenerFilasArreglo($consulta);
		echo "1|",uEJ($arrPuestos);
	}
	
	function guardarPuesto()
	{
		global $con;
		$puesto=$_POST["puesto"];
		$codigoU=$_POST["codigoU"];
		$cvePuesto=$_POST["cvePuesto"];
		
		$consulta="insert into 819_puestosOrganigrama(codigoUnidad,puesto,cvePuesto) values('".$codigoU."','".cv($puesto)."','".$cvePuesto."')";
		if($con->ejecutarConsulta($consulta))
		{
			$idPuesto=$con->obtenerUltimoID();
			echo "1|".$idPuesto;
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
		$x=0;
		$cadComodin=str_pad("",$longInstitucion,"_",STR_PAD_RIGHT);
		$consultaAux="select max(codigoIndividual) from 817_organigrama where codigoUnidad like '".$codigoUPadre.$cadComodin."'";
		$codigoIndividual=$con->obtenerValor($consultaAux);
		if($codigoIndividual==0)
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
				$codigoUnidadNuevo=str_pad($codInst,$longInstitucion,"0",STR_PAD_LEFT);
				if(existeCodigoUnidadOrg($codUnidad))
				{
					echo "El c&oacute;digo de la instituci&oacute;n ingresado ya existe";
					return;
				}
				$codigoFuncionalNuevo=str_pad($codigoUnidadNuevo,10,"0",STR_PAD_RIGHT);
				$query="insert into 817_organigrama(unidad,codigoFuncional,codigoUnidad,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,claveDepartamental) 
						value('".cv($obj->nombre)."','".$codigoFuncionalNuevo."','".$codigoUnidadNuevo."','".cv($obj->descripcion)."',".
						$obj->institucion.",'".$codCC."','".$codigoUPadre."','".$codigoUnidadNuevo."','".$codUnidad."','')";
				if($con->ejecutarConsulta($query))		
				{
					$idOrganigrama=$con->obtenerUltimoID();
					if(isset($obj->objInst))
					{
						$objInst=$obj->objInst;
						$consulta[$x]="insert into 247_instituciones(idOrganigrama,cp,ciudad,estado,idPais,fechaCreacion,responsable) values
						('".$idOrganigrama."','".cv($objInst->cp)."','".cv($objInst->ciudad)."','".cv($objInst->estado)."',".cv($objInst->idPais).",'".date("Y-m-d")."',".$_SESSION["idUsr"].")";
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
				
				if(existeCodigoUnidadOrg($codUnidad,$idOrganigrama))
				{
					echo "El c&oacute;digo de la instituci&oacute;n ingresado ya existe";
					return;
				}
				
				$consulta[$x]="update 817_organigrama set unidad='".cv($obj->nombre)."', descripcion='".cv($obj->descripcion)."',codCentroCosto='".$codCC."',codigoDepto='".$codUnidad."' where idOrganigrama=".$idOrganigrama;
				
				$x++;
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
				if(existeCodigoUnidadOrg($codigoUnidadNuevo))
				{
					echo "El c&oacute;digo del &aacute;rea/depto ingresado ya existe";
					return;
				}
				
				$codigoFuncionalNuevo=str_pad($codigoUnidadNuevo,$maxLongitud,"0",STR_PAD_RIGHT);
				$query="insert into 817_organigrama(unidad,codigoFuncional,codigoUnidad,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,claveDepartamental) 
						value('".cv($obj->nombre)."','".$codigoFuncionalNuevo."','".$codigoUnidadNuevo."','".cv($obj->descripcion)."',".$obj->institucion.",'".$codCC."','".$codigoUPadre."','".$codigoIndividual."','".$codUnidad."','".$txtClaveDep."')";
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
		$comp="";
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto from 817_organigrama where institucion=1 order by  codigoFuncional";
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
				if($SO==2)
					$desc="<br>(".$ciudad.", ".$estado.", ".$pais.".".$cp.")";
				else
					$desc="<br>(".($ciudad).", ".($estado).", ".($pais).".".$cp.")";
			}
			else
			{
				$texto=cvJs($fila[0]);
				$desc="";
			}
			//$consulta="	select concat(tipoTel,'_',codArea,'_',lada,'_',telefono,'_',extension) as telefono from 818_telefonosOrganigrama where idOrganigrama=".$fila[2];
			
			//$telefonos=$con->obtenerListaValores($consulta);			
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
			if($SO==2)
				$objUnidad='{unidadPadre:"'.$fila[7].'",codigoIndividual:"'.$fila[8].'",id:"'.$fila[2].'",text:"'.$texto.'",CC:"'.$fila[6].'",CCDescrip:"'.$cc.'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",desc:"'.$desc.'",uiProvider:"col","telefonos":"'.$arrTel.'","descTel":"'.$descTel.'","codDepto":"'.$fila[9].'"';
			else
				$objUnidad='{unidadPadre:"'.$fila[7].'",codigoIndividual:"'.$fila[8].'",id:"'.$fila[2].'",text:"'.($texto).'",CC:"'.$fila[6].'",CCDescrip:"'.utf8_encode($cc).'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs(($fila[4])).'",institucion:"'.($fila[5]).'",desc:"'.$desc.'",uiProvider:"col","telefonos":"'.$arrTel.'","descTel":"'.$descTel.'","codDepto":"'.$fila[9].'"';
			$hijos='';
			$hijos=obtenerUnidadesHijasOrg2($fila[1]);																								  
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
	
	function obtenerUnidadesHijasOrg2($codigoFun)
	{
		global $con;
		global $lPorcionCodFun;
		$consulta="select unidad,codigoUnidad,idOrganigrama,codigoFuncional,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto from 817_organigrama where unidadPadre = '".$codigoFun."' order by codigoFuncional";
		$res=$con->obtenerFilas($consulta);
		$arrHijos="";
		$objHijo="";
		$hijos="";
		while($fila=mysql_fetch_row($res))
		{
			$codigoF=$fila[3];
			
			$texto=cvJs($fila[0]);
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
			
			$consulta="select tituloCentroC from 506_centrosCosto where codigoCompleto='".$fila[6]."'";
			$cc=$con->obtenerValor($consulta);
			
			$objHijo='{unidadPadre:"'.$fila[7].'",codigoIndividual:"'.$fila[8].'",id:"'.$fila[2].'",text:"'.$texto.'",CC:"'.$fila[6].'",CCDescrip:"'.$cc.'",draggable:false,codigoU:"'.$fila[1].'",codigoF:"'.$codigoF.'",editable:true,descripcion:"'.cvJs($fila[4]).'",institucion:"'.$fila[5].'",desc:"'.$desc.'",uiProvider:"col","telefonos":"'.$arrTel.'","descTel":"'.$descTel.'","codDepto":"'.$fila[9].'"';
			$hijos=obtenerUnidadesHijasOrg2($fila[1]);
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
		$consulta="select idTabulacion,codTabulacion,idZona,salarioMinimo,salarioMaximo,situacion,if((select count(idTabulacion) from 653_unidadesOrgVSPuestos where situacion=1 and idTabulacion=t.idTabulacion)>0,'No','Sí') as ocupado,tipoPuesto from 652_tabulaciones t where idPuesto=".$idPuesto;
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
		$codigoUnidad=substr($codigoUnidad,0,4);
		$consulta="select idPuesto, puesto from 819_puestosOrganigrama where codigoUnidad='".$codigoUnidad."'";
		$arrPuestos=uEJ($con->obtenerFilasArreglo($consulta));
		echo "1|".$arrPuestos;
	}
	
	function obtenerPuestosDisponibles()
	{
		global $con;
		$idPuesto=$_POST["idPuesto"];
		$lisTab="";
		$consulta="select t.idTabulacion from 653_unidadesOrgVSPuestos up,652_tabulaciones t where t.idTabulacion=up.idTabulacion and t.idPuesto=".$idPuesto;
		$lisTab=$con->obtenerListaValores($consulta);
		if($lisTab=="")
			$lisTab="-1";
		
		$consulta="select po.idTabulacion, codTabulacion,z.NombreZona,po.tipoPuesto from 652_tabulaciones po,650_zonas z 
					where situacion=1 and z.id_650_zonas=po.idZona and po.idPuesto=".$idPuesto." and po.idTabulacion not in (".$lisTab.")";
		$arrPuestos=uEJ($con->obtenerFilasArreglo($consulta));
		echo "1|".$arrPuestos;
	}
	
	function asignarPuestoUnidad()
	{
		global $con;
		$listPuesto=$_POST["listPuesto"];
		$unidad=$_POST["unidad"];
		$arrPuestos=explode(",",$listPuesto);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrPuestos as $puesto)
		{
			$situacion="0";
			$query="select idFump from 801_fumpEmpleado where idTabulacion=".$puesto." and activo=1";
			$filaT=$con->obtenerPrimeraFila($query);
			if($filaT)
				$situacion="1";
			$consulta[$x]="insert into 653_unidadesOrgVSPuestos(codUnidad,idTabulacion,situacion) values('".$unidad."',".$puesto.",".$situacion.")";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select idUnidadVSPuesto,op.idTabulacion,codTabulacion,p.puesto,z.NombreZona,op.situacion as status,
					if(op.situacion=0,'',(select u.Nombre from 801_adscripcion a,800_usuarios u where u.idUsuario=a.idUsuario and a.cod_Puesto=op.idTabulacion)) as ocupante from 
					652_tabulaciones t,819_puestosOrganigrama p,653_unidadesOrgVSPuestos op ,650_zonas z
						where t.idTabulacion=op.idTabulacion and p.idPuesto=t.idPuesto and z.id_650_zonas=t.idZona and op.codUnidad='".$unidad."'";
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
		$query="select idUnidadVSPuesto,op.idTabulacion,codTabulacion,p.puesto,z.NombreZona,op.situacion as status,
					if(op.situacion=0,'',(select u.Nombre from 801_fumpEmpleado a,800_usuarios u where u.idUsuario=a.idUsuario and a.idTabulacion=op.idTabulacion and a.activo=1)) as ocupante,tipoPuesto from 
					652_tabulaciones t,819_puestosOrganigrama p,653_unidadesOrgVSPuestos op ,650_zonas z
						where t.idTabulacion=op.idTabulacion and p.idPuesto=t.idPuesto and z.id_650_zonas=t.idZona and op.codUnidad='".$unidad."'";
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
		$consulta="select po.idTabulacion,p.puesto,codTabulacion,po.tipoPuesto,z.NombreZona,po.salarioMinimo,po.salarioMaximo 
					from 652_tabulaciones po,650_zonas z, 819_puestosOrganigrama p where p.idPuesto=po.idPuesto 
					and z.id_650_zonas=po.idZona and po.idTabulacion in (select idTabulacion from 653_unidadesOrgVSPuestos where codUnidad='".$codUnidad."' 
					and situacion=0) ";
		
		$arrPuestos=uEJ($con->obtenerFilasArreglo($consulta));
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
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 801_fumpEmpleado(idUsuario,tipoOperacion,fechaAplicacion,pQuincenaPago,pCicloPago,salario,fechaOperacion,respOperacion,idTabulacion,activo) values
						(".$obj->idUsuario.",1,'".$obj->fechaInicio."','".$obj->quincena."',".$obj->ciclo.",".$obj->salario.",'".date('Y-m-d')."',".$_SESSION["idUsr"].",".$obj->idTabulacion.",1)";
		$x++;
		$consulta[$x]="update 653_unidadesOrgVSPuestos set situacion=1 where idTabulacion=".$obj->idTabulacion;
		$x++;
		$consulta[$x]="update 801_adscripcion set cod_Puesto=".$obj->idTabulacion." where idUsuario=".$obj->idUsuario;
		$x++;
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
		
		$query="select idTabulacion,salario from 801_fumpEmpleado where idFump=".$obj->idFump;
		$filaFum=$con->obtenerPrimeraFila($query);
		$idTabulacion=$filaFum[0];
		$query="select p.puesto,tp.tipoPuesto,z.NombreZona,o.unidad,t.codTabulacion from 652_tabulaciones t,819_puestosOrganigrama p,650_zonas z,
                   653_unidadesOrgVSPuestos uO,817_organigrama o,801_tiposPuesto tp 
                  where tp.idTipoPuesto=t.tipoPuesto and o.codigoUnidad=uo.codUnidad and uo.idTabulacion=t.idTabulacion and z.id_650_zonas=t.idZona and 
                   p.idPuesto=t.idPuesto and t.idTabulacion= ".$idTabulacion;
		
		$filaPuesto=$con->obtenerPrimeraFila($query);
		
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 801_adscripcion set cod_Puesto='' where idUsuario=".$obj->idUsuario;
		$x++;
		$consulta[$x]="update  801_fumpEmpleado set puesto='".$filaPuesto[0]."',departamento='".$filaPuesto[3]."',tipoPuesto='".$filaPuesto[1]."',
						zona='".$filaPuesto[2]."',codigoTabulacion='".$filaPuesto[4]."', activo=0 where idFump=".$obj->idFump;
		$x++;
		$consulta[$x]="insert into 801_fumpEmpleado(idUsuario,tipoOperacion,fechaAplicacion,uQuincenaPago,uCicloPago,salario,fechaOperacion,respOperacion,idTabulacion,activo,comentarios,
						puesto,departamento,tipoPuesto,zona,codigoTabulacion) values
						(".$obj->idUsuario.",-1,'".$obj->fechaInicio."','".$obj->quincena."',".$obj->ciclo.",".$filaFum[1].",'".date('Y-m-d')."',".$_SESSION["idUsr"].",".$idTabulacion.",0,
						'".cv($obj->comentarios)."','".$filaPuesto[0]."','".$filaPuesto[3]."','".$filaPuesto[1]."','".$filaPuesto[2]."','".$filaPuesto[4]."')";
		$x++;
		$consulta[$x]="update 653_unidadesOrgVSPuestos set situacion=0 where idTabulacion=".$idTabulacion;
		$x++;
		
		$consulta[$x]="commit";
		$x++;
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
		
		$query="select idTabulacion,salario from 801_fumpEmpleado where idFump=".$obj->idFump;
		$filaFum=$con->obtenerPrimeraFila($query);
		$idTabulacion=$filaFum[0];
		$query="select p.puesto,tp.tipoPuesto,z.NombreZona,o.unidad,t.codTabulacion from 652_tabulaciones t,819_puestosOrganigrama p,650_zonas z,
                   653_unidadesOrgVSPuestos uO,817_organigrama o,801_tiposPuesto tp 
                  where tp.idTipoPuesto=t.tipoPuesto and o.codigoUnidad=uo.codUnidad and uo.idTabulacion=t.idTabulacion and z.id_650_zonas=t.idZona and 
                   p.idPuesto=t.idPuesto and t.idTabulacion= ".$idTabulacion;
		
		$filaPuesto=$con->obtenerPrimeraFila($query);
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update  801_fumpEmpleado set puesto='".$filaPuesto[0]."',departamento='".$filaPuesto[3]."',tipoPuesto='".$filaPuesto[1]."',
						zona='".$filaPuesto[2]."',codigoTabulacion='".$filaPuesto[4]."', activo=0 where idFump=".$obj->idFump;
		$x++;
		$consulta[$x]="insert into 801_fumpEmpleado(idUsuario,tipoOperacion,fechaAplicacion,pQuincenaPago,pCicloPago,salario,fechaOperacion,respOperacion,idTabulacion,activo,comentarios) values
						(".$obj->idUsuario.",0,'".$obj->fechaInicio."','".$obj->quincena."',".$obj->ciclo.",".$obj->salario.",'".date('Y-m-d')."',".$_SESSION["idUsr"].",".$idTabulacion.",1,
						'".cv($obj->comentarios)."')";
		
		$x++;
		$consulta[$x]="commit";
		$x++;
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
		$tDestino="662_calculosNomina";
		$arrConceptos=explode(",",$listConceptos);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($idUsuario=="NULL")
			$query="select count(idCalculo) from 662_calculosNomina where idUsuarioAplica is ".$idUsuario;
		else
			$query="select count(idCalculo) from 662_calculosNomina where idUsuarioAplica=".$idUsuario;
		$orden=$con->obtenerValor($query);
		$orden++;
		foreach($arrConceptos as $concepto)
		{
			$consulta[$x]="insert into ".$tDestino." (idConsulta,idUsuarioAplica,situacion,tipoCalculo,orden) values(".$concepto.",".$idUsuario.",1,".$tipo.",".$orden.")";
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
		$tabla="662_calculosNomina";
		$campoID="idCalculo";
		
		$consulta="update ".$tabla." set afectacionNomina=".$afectacion.",quincenaAfectacion='',nQuincenasAfectacion=null,cicloAfectacion=null where ".$campoID."=".$idConcepto;
		if($con->ejecutarConsulta($consulta))
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
		$nQuincenas=$_POST["nQuincenas"];
		$tipoConcepto=$_POST["tipoConcepto"];
		$tabla="662_calculosNomina";
		$campoID="idCalculo";
		$consulta="update ".$tabla." set quincenaAfectacion='".$quincena."',cicloAfectacion=".$ciclo.",nQuincenasAfectacion=".$nQuincenas." where ".$campoID."=".$idConcepto;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerConceptosDisponibles()
	{
		global $con;
		$tipo=$_POST["tipo"];
		$idUsuario=$_POST["idUsuario"];
		$nTabla="662_calculosNomina";
		if($idUsuario!="-1")
		{
			$consulta="select idConsulta,codigo,nombreConsulta,descripcion from 991_consultasSql where idTipoConcepto=".$tipo." and situacion=1 and ambitoAplicacion=2
					and idConsulta not in (select idConsulta from ".$nTabla."  where idUsuarioAplica = ".$idUsuario." and tipoCalculo=".$tipo.")";
		}
		else
		{
			$consulta="select idConsulta,codigo,nombreConsulta,descripcion from 991_consultasSql where idTipoConcepto=".$tipo." and situacion=1 and ambitoAplicacion=1
					and idConsulta not in (select idConsulta from ".$nTabla."  where idUsuarioAplica is null and tipoCalculo=".$tipo.")";
		
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
?>
