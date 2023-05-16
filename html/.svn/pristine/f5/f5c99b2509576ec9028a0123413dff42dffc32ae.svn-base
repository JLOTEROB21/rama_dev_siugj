<?php session_start();
	include("conexionBD.php");
	$parametros="";
	$funcion="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
	}	
	switch($funcion)
	{
		case 1:
			obtenerCatalogoConceptos();
		break;
		case 2:
			guardarComceptos();
		break;
		case 3:
			obtenerPartidas();
		break;
		case 4:
			registrarFlujoEfectivo();
		break;
		case 5:
			eliminarConceptoFlujo();
		break;
		case 6:
			guardarValorMes();
		break;
		case 7:
			guaradarFlujoEfectivoAutorizado();
		break;
		case 8:
			obtenerRegistroFlujoEfectivo();
		break;
		case 9:
			obtenerDatosRegistroConcepto();
		break;
		case 10:
			guardarModificacionRegistroConcepto();
		break;
		case 11:
			guardarValorMesAutorizado();
		break;
		case 12:
			obtenerInsidenciasPeriodo();
		break;
		case 13:
			buscarUsuarios();
		break;
		case 14:
			obtenerConfiguracionRolesEnfermeria();
		break;
		case 15:
			obtenerPersonasConfiguracionRolE();
		break;
		case 16:
			validarExisteConfiguracion();
		break;
		case 17:
			obtenerEmpleadosServicio();
		break;
		case 18:
			guardarPersonaRolEnfermeria();
		break;
		case 19:
			borrarPersonaRolEnfermeria();
		break;
		case 20:
			obtenerAlumnosComentarios();
		break;
		case 21:
			obtenerConcentradoCursos();
		break;
		case 22:
			guardarCursosCancelados();
		break;
		case 23:
			obtenerListaParticipantesCurso();
		break;
		case 24:
			agruparCursos();
		break;
		case 25:
			obtenerCursosAgrupados();
		break;
		case 26:
			guardarTotalGrupo();
		break;
		case 27:
			obtenerCursosGrupo();
		break;
		case 28:
			agregarCursosGrupo();
		break;
		case 29:
			quitarCursosGrupo();
		break;
		case 30:
			deshacerGrupo();
		break;
		case 31:
			obtenerCursosRechazados();
		break;
		case 32:
			restablecerCursosRechazados();
		break;
		case 33:
			obtenerTipoAudienciaCarpeta();
		break;
	}
	
	function obtenerCatalogoConceptos()
	{
		global $con;	
		
		$idCiclo=$_POST["idCiclo"];
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$consulta="SELECT *FROM 9316_conceptosCiclo WHERE ciclo=".$idCiclo." ".$condWhere ;
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		
		$arrConceptos="";
		while($fila=mysql_fetch_row($res))
		{
			
			$arregloMeses=Array();
			$cadenaMeses="";
			$total=0;
			$conMeses="SELECT mes,valor FROM 9317_conceptoMes WHERE idCatalogoConcepto=".$fila[0]." ORDER BY mes";
			$resM=$con->obtenerFilas($conMeses);
			while($fMes=mysql_fetch_row($resM))
			{
				$arregloMeses[$fMes[0]]=$fMes[1];
				$obj='"mes_'.$fMes[0].'":"'.$fMes[1].'"';
				if($cadenaMeses=="")
					$cadenaMeses=$obj;
				else
					$cadenaMeses.=",".$obj;
				
				$total=$total+$fMes[1];
			}
			
			$cadenaMeses=",".$cadenaMeses;
			$conNombrePartida="SELECT nombreObjetoGasto FROM 507_objetosGasto WHERE clave='".$fila[2]."'";
			$nomPart=$con->obtenerValor($conNombrePartida);
			
			$conNombreCal="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fila[7];
			$nomCalc=$con->obtenerValor($conNombreCal);
			
			//,"mes_0":"'.$fila[5].'","mes_1":"'.$fila[5].'","mes_2":"'.$fila[5].'","mes_3":"'.$fila[5].'","mes_4":"'.$fila[5].'","mes_5":"'.$fila[5].'","mes_6":"'.$fila[5].'","mes_7":"'.$fila[5].'","mes_8":"'.$fila[5].'","mes_9":"'.$fila[5].'","mes_10":"'.$fila[5].'","mes_11":"'.$fila[5].'","total":"'.$fila[5].'"
			$obj='{"idCatalogoConcepto":"'.$fila[0].'","nombre":"'.$fila[1].'","partida":"'.$fila[2].'","nombrePart":"'.$nomPart.'","tipoEntrada":"'.$fila[3].'","puedeModificar":"'.$fila[4].'","tipoConcepto":"'.$fila[5].'","idCalculo":"'.$fila[7].'","nomCalc":"'.$nomCalc.'"'.$cadenaMeses.',"total":"'.$total.'"}';	
			if($arrConceptos=="")
				$arrConceptos=$obj;
			else
				$arrConceptos.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrConceptos.']}';
		echo $obj;
	}
	
	function guardarComceptos()
	{
		global $con;
			
		$idCiclo=$_POST["idCiclo"];
		$tipoC=$_POST["tipoC"];
		$nombre=$_POST["nombre"];
		$partida=$_POST["partida"];
		$tipoE=$_POST["tipoE"];
		$modif=$_POST["modif"];
		$idCal=$_POST["idCal"];
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			$inserta="INSERT INTO 9316_conceptosCiclo(nombre,partida,tipoEntrada,puedeModificar,tipoConcepto,ciclo,idCalculo)
					VALUES ('".$nombre."','".$partida."',".$tipoE.",".$modif.",".$tipoC.",".$idCiclo.",".$idCal.")";
			
			if($con->ejecutarConsulta($inserta))
			{
				$id=$con->obtenerUltimoID();
				for($x=0;$x<12;$x++)
				{
					$query[$ct]="INSERT INTO 9317_conceptoMes(idCatalogoConcepto,mes,valor,valorAut)
								 VALUES (".$id.",".$x.",0,0)";
					$ct++;			 
				}
				
				$query[$ct]="commit";
				if($con->ejecutarBloque($query))
					echo "1|";
				else
					echo "|";
			}
		}
	}
	
	function obtenerPartidas()
	{
		global $con;
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		$consulta="SELECT clave,nombreObjetoGasto FROM 507_objetosGasto WHERE  clave NOT LIKE '%00' ".$condWhere;
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		
		$arrPartidas="";
		while($fila=mysql_fetch_row($res))
		{
			
			$obj='{"clave":"'.$fila[0].'","nombreObjetoGasto":"'.$fila[1].'"}';	
			if($arrPartidas=="")
				$arrPartidas=$obj;
			else
				$arrPartidas.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrPartidas.']}';
		echo $obj;
	}
	
	function registrarFlujoEfectivo()
	{
		global $con;
		
		$idCiclo=$_POST["idCiclo"];
		
		$conExiste="SELECT idRegistroFlujoE FROM 9318_registroFlujoE WHERE ciclo=".$idCiclo;
		$existe=$con->obtenerValor($conExiste);
		if($existe=="")
		{
			$query="INSERT INTO 9318_registroFlujoE (ciclo,registrado) VALUES(".$idCiclo.",1)";
		}
		else
		{
			$query="UPDATE 9318_registroFlujoE SET registrado=1 WHERE idRegistroFlujoE=".$existe;
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarConceptoFlujo()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			for($x=0;$x<$tamano;$x++)
			{
				$query[$ct]="DELETE FROM 9317_conceptoMes WHERE idCatalogoConcepto=".$arreglo[$x];
				$ct++;
				
				$query[$ct]="DELETE FROM 9316_conceptosCiclo WHERE idCatalogoConcepto=".$arreglo[$x];
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function guardarValorMes()
	{
		global $con;
		
		$mes=$_POST["mes"];
		$idTabla=$_POST["idTabla"];
		$valor=$_POST["valor"];
		
		$conExiste="SELECT idComceptoMes FROM 9317_conceptoMes WHERE mes=".$mes." AND idCatalogoConcepto=".$idTabla;
		$existe=$con->obtenerValor($conExiste);
		
		if($existe=="")
		{
			$query="INSERT INTO 9317_conceptoMes (idCatalogoConcepto,mes,valor,valorAut) VALUES(".$idTabla.",".$mes.",".$valor.",0)";
		}
		else
		{
			$query="UPDATE 9317_conceptoMes SET valor=".$valor." WHERE idComceptoMes=".$existe;
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
		
	}
	
	function guaradarFlujoEfectivoAutorizado()
	{
		global $con;
		
		$idCiclo=$_POST["idCiclo"];
		$idPrograma=$_POST["idPrograma"];
		$codigoU=$_POST["codigoU"];
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			$conRegistros="SELECT *FROM 9316_conceptosCiclo WHERE ciclo=".$idCiclo;
			$res1=$con->obtenerFilas($conRegistros);
			while($fila=mysql_fetch_row($res1))
			{
				$conMeses="SELECT mes,valorAut FROM 9317_conceptoMes WHERE idCatalogoConcepto=".$fila[0];
				$resMeses=$con->obtenerFilas($conMeses);
				$noFilas=$con->filasAfectadas;
				$montoTotal=0;
				while($fSuma=mysql_fetch_row($resMeses))
				{
					$montoTotal=$montoTotal+$fSuma[1];
				}
				
				$capitulo="";
				if($fila[2]!=="")
					$capitulo=obtenerCapituloPartida($fila[2]);
					
				$insertar="INSERT INTO 523_presupuestoAutorizado(ciclo,programa,depto,capitulo,partida,montoTotal,montoAjustado,tipoPresupuesto,institucion,tipoOrigen,idRegistroFlujoE)
							 VALUES(".$idCiclo.",".$idPrograma.",'".$codigoU."','".$capitulo."','".$fila[2]."',".$montoTotal.",0,1,'".$_SESSION["codigoInstitucion"]."',1,".$fila[0].")";
				
				 
				if($con->ejecutarConsulta($insertar))
				{
					//echo $insertar;
					$nvoId=$con->obtenerUltimoID();
					
					$conMeses2="SELECT mes,valorAut FROM 9317_conceptoMes WHERE idCatalogoConcepto=".$fila[0];
					$res2Meses=$con->obtenerFilas($conMeses2);
					while($fMes=mysql_fetch_row($res2Meses))
					{
						$query[$ct]="INSERT INTO 523_distribucionPresupuestoAutorizado(idPresupuestoAutorizado,nDistribucion,monto,montoAjustado)  
								 VALUES(".$nvoId.",".$fMes[0].",".$fMes[1].",0)";
						$ct++;		 
					}
				}
			}
			$conExiste="SELECT idRegistroAjusteFlujoE FROM 9319_registroAjusteFlujoE WHERE ciclo=".$idCiclo;
			$existe=$con->obtenerValor($conExiste);
			if($existe=="")
			{
				$query[$ct]="INSERT INTO 9319_registroAjusteFlujoE (ciclo,registrado) VALUES(".$idCiclo.",1)";
				$ct++;
			}
			else
			{
				$query[$ct]="UPDATE 9319_registroAjusteFlujoE SET registrado=1 WHERE idRegistroAjusteFlujoE=".$existe;
				$ct++;
			}
			
			//echo var_dump($query);
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerRegistroFlujoEfectivo()
	{
		global $con;
		
		$idCiclo=$_POST["idCiclo"];
		
		$consulta2="SELECT idRegistroFlujoE FROM 9318_registroFlujoE WHERE ciclo=".$idCiclo." AND registrado=1";
		$registrado2=$con->obtenerValor($consulta2);
		if(($registrado2=="") || ($registrado2=="0"))
			$registrado2=0;
		
		if($registrado2==0)
		{
			$nreg=0;
			$arrConceptos="";
		}
		else
		{
			  $condWhere="";
			  if(isset($_POST["filter"]))
			  {
				  $arrFiltro=$_POST["filter"];
				  $ct=sizeof($arrFiltro);
				  for($x=0;$x<$ct;$x++)
				  {
					  switch($arrFiltro[$x]["data"]["type"])
					  {
						  case 'string':
							  $condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
						  break;
					  }
				  }
			  }
			  
			  $consulta="SELECT *FROM 9316_conceptosCiclo WHERE ciclo=".$idCiclo." ".$condWhere ;
			  $res=$con->obtenerFilas($consulta);
			  $nreg=$con->filasAfectadas;
			  
			  $arrConceptos="";
			  while($fila=mysql_fetch_row($res))
			  {
				  $conRegistrado="SELECT idPresupuestoAutorizado FROM 523_presupuestoAutorizado WHERE idRegistroFlujoE=".$fila[0];
				  $registroA=$con->obtenerValor($conRegistrado);
				  if($registroA=="")
					  $registroA="-1";
				  
				  $arregloMeses=Array();
				  $cadenaMeses="";
				  $total=0;
				  $total2=0;
				  $conMeses="SELECT mes,valor,valorAut FROM 9317_conceptoMes WHERE idCatalogoConcepto=".$fila[0]." ORDER BY mes";
				  $resM=$con->obtenerFilas($conMeses);
				  while($fMes=mysql_fetch_row($resM))
				  {
					  if($registroA=="-1")
					  {
						  $objA=',"mesA_'.$fMes[0].'":"'.$fMes[2].'"';
					  }
					  else
					  {
						  $conRegAutorizado="SELECT monto FROM 523_distribucionPresupuestoAutorizado WHERE idPresupuestoAutorizado=".$registroA." AND nDistribucion=".$fMes[0];
						  $monto=$con->obtenerValor($conRegAutorizado);
						  $objA=',"mesA_'.$fMes[0].'":"'.$monto.'"';
					  
					  }
					  
					  //$arregloMeses[$fMes[0]]=$fMes[1];
					  $obj='"mes_'.$fMes[0].'":"'.$fMes[1].'"'.$objA;
					  if($cadenaMeses=="")
						  $cadenaMeses=$obj;
					  else
						  $cadenaMeses.=",".$obj;
					  
					  $total=$total+$fMes[1];
					  if($registroA=="-1")
					  {
						  $total2=$total2+$fMes[2];
					  }
					  else
					  {
						  $total2=$total2+$monto;
					  }
				  }
				  
				  $cadenaMeses=",".$cadenaMeses;
				  $conNombrePartida="SELECT nombreObjetoGasto FROM 507_objetosGasto WHERE clave='".$fila[2]."'";
				  $nomPart=$con->obtenerValor($conNombrePartida);
				  
				  $conNombreCal="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fila[7];
				  $nomCalc=$con->obtenerValor($conNombreCal);
				  
				  //,"mes_0":"'.$fila[5].'","mes_1":"'.$fila[5].'","mes_2":"'.$fila[5].'","mes_3":"'.$fila[5].'","mes_4":"'.$fila[5].'","mes_5":"'.$fila[5].'","mes_6":"'.$fila[5].'","mes_7":"'.$fila[5].'","mes_8":"'.$fila[5].'","mes_9":"'.$fila[5].'","mes_10":"'.$fila[5].'","mes_11":"'.$fila[5].'","total":"'.$fila[5].'"
				  $obj='{"idCatalogoConcepto":"'.$fila[0].'","nombre":"'.$fila[1].'","partida":"'.$fila[2].'","nombrePart":"'.$nomPart.'","tipoEntrada":"'.$fila[3].'","puedeModificar":"'.$fila[4].'","tipoConcepto":"'.$fila[5].'","idCalculo":"'.$fila[7].'","nomCalc":"'.$nomCalc.'"'.$cadenaMeses.',"total":"'.$total.'","totalAut":"'.$total2.'"}';	
				  if($arrConceptos=="")
					  $arrConceptos=$obj;
				  else
					  $arrConceptos.=",".$obj;
			  }
	    }
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrConceptos.']}';
		echo $obj;
	}
	
	function obtenerDatosRegistroConcepto()
	{
		global $con;
		$id=$_POST["id"];
		
		$consulta="SELECT *FROM 9316_conceptosCiclo WHERE idCatalogoConcepto=".$id;
		$fila=$con->obtenerPrimeraFila($consulta);
		
		echo "1|".$fila[0]."|".$fila[1]."|".$fila[2]."|".$fila[3]."|".$fila[4]."|".$fila[5]."|".$fila[7];
	}
	
	function guardarModificacionRegistroConcepto()
	{
		global $con;
		
		$id=$_POST["id"];
		$idCiclo=$_POST["idCiclo"];
		$tipoC=$_POST["tipoC"];
		$nombre=$_POST["nombre"];
		$partida=$_POST["partida"];
		$tipoE=$_POST["tipoE"];
		$modif=$_POST["modif"];
		$idCal=$_POST["idCal"];
			
		$query="UPDATE 9316_conceptosCiclo SET nombre='".$nombre."',partida='".$partida."',tipoEntrada=".$tipoE.",puedeModificar=".$modif.",tipoConcepto=".$tipoC.",idCalculo=".$idCal." WHERE idCatalogoConcepto=".$id;
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarValorMesAutorizado()
	{
		global $con;
		$mes=$_POST["mes"];
		$idTabla=$_POST["idTabla"];
		$valor=$_POST["valor"];
		//$valorAut=$_POST["valorAut"];
		
		$conExiste="SELECT idComceptoMes FROM 9317_conceptoMes WHERE mes=".$mes." AND idCatalogoConcepto=".$idTabla;
		$existe=$con->obtenerValor($conExiste);
		
		if($existe=="")
		{
			//$query="INSERT INTO 9317_conceptoMes (idCatalogoConcepto,mes,valor,valorAut) VALUES(".$idTabla.",".$mes.",".$valor.",".$valorAut.")";
		}
		else
		{
			$query="UPDATE 9317_conceptoMes SET valorAut=".$valor." WHERE idComceptoMes=".$existe;
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerCapituloPartida($partida)
	{
		  global $con;
		  $consulta="SELECT *FROM 507_objetosGasto WHERE clave='".$partida."'";
		  $fila=$con->obtenerPrimeraFila($consulta);
		  if($fila)
		  {
			  if($fila[4]=="") 
				  return $partida;
			  else
				  return obtenerCapituloPartida($fila[4]);
		  }
		  return "";
	}
	
	function obtenerInsidenciasPeriodo()
	{
		global $con;
		
		$fechaI=$_POST["fechaIni"];
		$fechaF=$_POST["fechaFin"];
		$idUsuario=$_POST["idUsr"];
		
		if($idUsuario=="-1")
		{
			$consulta="SELECT idUsuario,txtIncidencia FROM 9106_Justificaciones i, _809_tablaDinamica d WHERE id__809_tablaDinamica=tipo AND   fecha_Inicial>='".$fechaI."' AND fecha_Final<='".$fechaF."'";
		}
		else
		{
			$consulta="SELECT idUsuario,txtIncidencia FROM 9106_Justificaciones i, _809_tablaDinamica d WHERE id__809_tablaDinamica=tipo AND   fecha_Inicial>='".$fechaI."' AND fecha_Final<='".$fechaF."' and idUsuario=".$idUsuario;
		}
		
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		$arrUsuarios="";
		while($fila=mysql_fetch_row($res))
		{
			$conAscripcion="SELECT codigoUnidad FROM   801_adscripcion WHERE idUsuario=".$fila[0];
			$codU=$con->obtenerValor($conAscripcion);
			if($codU=="")
				$codU="-1";
			
			$conUnidad="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$codU."'";
			$nomU=$con->obtenerValor($conUnidad);
			
			$nombreU=obtenerNombreUsuario($fila[0]);
			$obj='{"nomU":"'.$nomU.'","nombreU":"'.$nombreU.'","incidensia":"'.$fila[1].'"}';	
			if($arrUsuarios=="")
				$arrUsuarios=$obj;
			else
				$arrUsuarios.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrUsuarios.']}';
		echo $obj;
	}
	
	function buscarUsuarios()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		$consulta="";
		$comp="";
		if(isset($_POST["rol"]))
		{
			$comp=" idUsuario in (select idUsuario from 807_usuariosVSRoles where codigoRol in(".bD($_POST["rol"]).")) and ";
		}
		$comp2="";
		if(isset($_POST["cond"]))
			$comp2=" and ".bD($_POST["cond"]);
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="select idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status,idUsuario as noUsuario from 802_identifica   where ".$comp." Paterno like '".$criterio."%'";
			break;
			case "2": //Materno
				$consulta="select idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status,idUsuario as noUsuario from 802_identifica  where ".$comp." Materno like '".$criterio."%'";
			break;
			case "3": //Nombre
				$consulta="select idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status,idUsuario as noUsuario from 802_identifica where ".$comp." Nom like '".$criterio."%'";
			break;
			case "4": //Nombre completo
				$consulta="select idUsuario,Paterno, Materno,Nom,Nombre,'' as Status,concat('<b>',idUsuario,'</b>') as noUsuario from 802_identifica where ".$comp." Nombre like '".$criterio."%'";
			break;
		}
		$consulta.=$comp2." order by Paterno,Materno,Nom asc";
		
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
			$resRol=$con->obtenerFilas($consulta);
			$situaciones="";
			while($filaRol=mysql_fetch_row($resRol))
			{
				$situaciones="";
				if($situaciones=="")
					$situaciones=obtenerTituloRol($filaRol[0]);
				else
					$situaciones.=",".obtenerTituloRol($filaRol[0]);
			}
			
			$consulta="SELECT Institucion,codigoUnidad,institucionAbierto,Dependencia FROM 801_adscripcion WHERE idUsuario=".$fila[0];
			$fAds=$con->obtenerPrimeraFila($consulta);
			$institucion="Sin información";
			$departamento="Sin información";
			if($fAds[0]!="")
			{
				$consulta="select unidad  from 817_organigrama where codigoUnidad='".$fAds[0]."'";
				$institucion=$con->obtenerValor($consulta);
				
			}
			else
			{
				if($fAds[2]!="")
					$institucion=$fAds[2];
					
					
			}
			
			if($fAds[1]!="")
			{
				$consulta="select unidad  from 817_organigrama where codigoUnidad='".$fAds[1]."'";
				$departamento=$con->obtenerValor($consulta);
				
			}
			else
			{
				if($fAds[3]!="")
					$departamento=$fAds[3];
			}
			$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'","Status":"'.$situaciones.'","institucion":"'.$institucion.'","departamento":"'.$departamento.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$nFilas.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	
	}
	
	function obtenerConfiguracionRolesEnfermeria()
	{
		global $con;
		
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		}
		
		$consulta="SELECT idConfiguracion,ciclo,idServicio,idPeriodo FROM 9315_configuracionRolEnfermeria ORDER BY ciclo DESC";
		$res=$con->obtenerFilas($consulta);
		$nofilas=$con->filasAfectadas;
		$arrConfig="";
		
		while($fila=mysql_fetch_row($res))
		{
			$conNomSer="SELECT servicioEnfermeria FROM _465_tablaDinamica WHERE id__465_tablaDinamica=".$fila[2];
			$nomSer=$con->obtenerValor($conNomSer);
			
			//$conNomTurno="SELECT txtTurno FROM _738_tablaDinamica WHERE id__738_tablaDinamica=".$fila[3];
//			$nomTurno=$con->obtenerValor($conNomTurno);
			
			$conNomPeriodo="SELECT etiqueta FROM 9315_periodosRoles WHERE noPeriodo=".$fila[3];
			$nomPeriodo=$con->obtenerValor($conNomPeriodo);
			
			$obj='{"idConfiguracion":"'.$fila[0].'","ciclo":"'.$fila[1].'","idServicio":"'.$fila[2].'","nomServicio":"'.$nomSer.'","idPeriodo":"'.$fila[3].'","nombrePeriodo":"'.$nomPeriodo.'"}';
			if($arrConfig=="")
				$arrConfig=$obj;
			else
				$arrConfig.=",".$obj;
		}
		$obj='{"num":"'.$nofilas.'","registros":['.uDJ($arrConfig).']}';
		echo $obj;
	
	}
	
	function obtenerPersonasConfiguracionRolE()
	{
		global $con;
		
		$idServicio=$_POST["idServicio"];
		
		
		$consulta="SELECT idEmpleadoRolEnfermeria,r.idUsuario,idTurno,CONCAT(Paterno,' ',Materno,' ',Nom) AS nombre,a.cod_Puesto,p.puesto,a.codigoUnidad,o.unidad 
				   FROM 9315_empleadoRolEnfermeria r, 802_identifica i,801_adscripcion a, 819_puestosOrganigrama p,817_organigrama o 
				   WHERE r.idUsuario=i.idUsuario AND r.idUsuario=a.idUsuario AND a.cod_Puesto=p.cvePuesto AND o.codigoUnidad=a.codigoUnidad AND idConfiguracion=".$idServicio." order by Paterno";
		$res=$con->obtenerFilas($consulta);
		$nofilas=$con->filasAfectadas;
		
		$arrPersonas="";
		
		while($fila=mysql_fetch_row($res))
		{
			$conNomTurno="SELECT txtTurno FROM _738_tablaDinamica WHERE id__738_tablaDinamica=".$fila[2];
		    $nomTurno=$con->obtenerValor($conNomTurno);
			
			$obj='{"idEmpleadoRolEnfermeria":"'.$fila[0].'","idUsuario":"'.$fila[1].'","idTurno":"'.$fila[2].'","nombre":"'.$fila[3].'","cod_Puesto":"'.$fila[4].'","puesto":"'.$fila[5].'","codigoUnidad":"'.$fila[6].'","unidad":"'.$fila[7].'","nombreTurno":"'.$nomTurno.'"}';
			if($arrPersonas=="")
				$arrPersonas=$obj;
			else
				$arrPersonas.=",".$obj;
		}
		$obj='{"num":"'.$nofilas.'","registros":['.$arrPersonas.']}';
		echo $obj;
		
	}
	
	function validarExisteConfiguracion()
	{
		global $con;
		
		$ciclo=$_POST["idCiclo"];
		$idServicio=$_POST["idServicio"];
		$idPeriodo=$_POST["idPeriodo"];
		
		$consulta="SELECT idConfiguracion FROM 9315_configuracionRolEnfermeria WHERE  ciclo=".$ciclo." AND idServicio=".$idServicio." AND idPeriodo=".$idPeriodo;
		$id=$con->obtenerValor($consulta);
		if($id=="")
		{
			$query="INSERT INTO 9315_configuracionRolEnfermeria(ciclo,idServicio,idPeriodo) VALUES(".$ciclo.",".$idServicio.",".$idPeriodo.")";
			if($con->ejecutarConsulta($query))
			{
				$id=$con->obtenerUltimoID();
				echo "1|".$id;
			}
			else
			{
				echo "|";
			}
		}
		else
		{
			echo "2|";
		}
	}
	
	function obtenerEmpleadosServicio()
	{
		global $con;
		//$idServicio=$_POST["idServicio"];
		$idPuesto=$_POST["idPuesto"];
		
		$arrPersonas="";
		//$conCategorias="SELECT id__865_tablaDinamica FROM _865_tablaDinamica c,_465_gridServicioCategoria s
//						WHERE  s.idReferencia=".$idServicio." AND id__865_tablaDinamica=idCategoria";
//		$cadenaCat=$con->obtenerListaValores($conCategorias);				
//		if($cadenaCat=="")
//		{
//			$obj='{"num":"0","registros":['.uDJ($arrPersonas).']}';
//			echo $obj;
//			return;
//		}
		
		//$conIdPusetos="SELECT idPuesto FROM _865_gridPuestosCategoria WHERE idReferencia IN (".$cadenaCat.")";
//		$listaPuestos=$con->obtenerListaValores($conIdPusetos);
//		if($listaPuestos=="")
//		{
//			$obj='{"num":"'.$nofilas.'","registros":['.uDJ($arrPersonas).']}';
//			echo $obj;
//			return;
//		}
		
		$conClavesPuestos="SELECT cvePuesto FROM 819_puestosOrganigrama WHERE idPuesto=".$idPuesto; //IN (".$listaPuestos.")";
		$resClaves=$con->obtenerFilas($conClavesPuestos);
		$noClaves=$con->filasAfectadas;
		if($noClaves==0)
		{
			$obj='{"num":"0","registros":['.uDJ($arrPersonas).']}';
			echo $obj;
			return;
		}
		else
		{
			$listaClaves="";
			while($fClave=mysql_fetch_row($resClaves))
			{
				if($listaClaves=="")
					$listaClaves="'".$fClave[0]."'";
				else
					$listaClaves.=",'".$fClave[0]."'";
			}
			
			$conCategoria="SELECT g.id__865_tablaDinamica,txtCategoria FROM _865_gridPuestosCategoria c,_865_tablaDinamica g 
						   WHERE idPuesto=".$idPuesto." AND id__865_tablaDinamica=c.idReferencia";
			$categoria=$con->obtenerPrimeraFila($conCategoria);
			if($categoria)
			{
				$idCategoria=$categoria[0];
				$nombreCat=$categoria[1];
			}
			else
			{
				$idCategoria="-1";
				$nombreCat="";
			}
			
			$consulta="SELECT a.idUsuario,CONCAT(Paterno,' ',Materno,' ',Nom) AS nombre,puesto,unidad,a.cod_Puesto 
					   FROM 801_adscripcion a,  817_organigrama o, 802_identifica i,819_puestosOrganigrama p
					   WHERE a.idUsuario=i.idUsuario AND a.codigoUnidad=o.codigoUnidad AND a.cod_Puesto=p.cvePuesto AND a.cod_Puesto IN (".$listaClaves.") ORDER BY unidad,nombre";
			$res=$con->obtenerFilas($consulta);
			$nofilas=$con->filasAfectadas;
			
			while($fila=mysql_fetch_row($res))
			{
				
				$obj='{"idUsuario":"'.$fila[0].'","nombre":"'.$fila[1].'","idCategoria":"'.$idCategoria.'","nombreCat":"'.$nombreCat.'","unidad":"'.$fila[3].'"}';
				if($arrPersonas=="")
					$arrPersonas=$obj;
				else
					$arrPersonas.=",".$obj;
			}
			$obj='{"num":"'.$nofilas.'","registros":['.uDJ($arrPersonas).']}';
			echo $obj;
		}
	}
	
	function guardarPersonaRolEnfermeria()
	{
		global $con;
		
		$idConfiguracion=$_POST["idConfiguracion"];
		$idTurno=$_POST["idTurno"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				$registro=explode("_",$arreglo[$x]);
				$conExiste="SELECT idEmpleadoRolEnfermeria FROM 9315_empleadoRolEnfermeria WHERE idUsuario=".$registro[0]." AND idConfiguracion=".$idConfiguracion." AND  idTurno=".$idTurno;
				//echo $conExiste;
				$id=$con->obtenerValor($conExiste);
				if($id=="")
				{
					$query[$ct]="INSERT INTO 9315_empleadoRolEnfermeria(idUsuario,idConfiguracion,idTurno,idCategoria) VALUES (".$registro[0].",".$idConfiguracion.",".$idTurno.",".$registro[1].")";
					$ct++;
				}
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
			
		}
		
	}
	
	function borrarPersonaRolEnfermeria()
	{
		global $con;
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
					$query[$ct]="DELETE FROM 9315_empleadoRolEnfermeria WHERE idEmpleadoRolEnfermeria=".$arreglo[$x];
					$ct++;
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}

	
	function obtenerAlumnosComentarios()
	{
		global $con;
		
		$idMateria=$_POST["idMateria"];
		$idGrupo=$_POST["idGrupo"];
		
		$consulta="SELECT c.idUsuario,CONCAT(Paterno,' ',Materno,' ',Nom) AS nombre,comentario FROM 4163_calBloqueMateria c, 802_identifica i 
				   WHERE idMateria=".$idMateria." AND idGrupo=".$idGrupo." AND bloque=".$idBloque." AND comentario<>'' AND c.idUsuario=i.idUsuario";
		$res=$con->obtenerFilas($consulta);		   
		$noFilas=$con->filasAfetadas;
		
		while($fila=mysql_fetch_row($res))
		{
			$fila[2];
		}
	}
	
	function obtenerConcentradoCursos()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		
		$arrCursos="";
		
		$conCursosAgrupados="SELECT idCurso FROM 9321_cursosAgrupados a,_870_tablaDinamica d WHERE  id__870_tablaDinamica=idCurso AND cmbCiclo=".$idCiclo;
		$listaAgrupados=$con->obtenerListaValores($conCursosAgrupados);
		if($listaAgrupados=="")
			$listaAgrupados="-1";
		
		$conCursosRechazados="SELECT idCurso FROM 9320_cursosRechazados r,_870_tablaDinamica d WHERE  id__870_tablaDinamica=idCurso AND cmbCiclo=".$idCiclo;
		$listaCursos=$con->obtenerListaValores($conCursosRechazados);
		if($listaCursos=="")
			$listaCursos="-1";
		
		$consulta="SELECT id__870_tablaDinamica,txtCurso,IntHoras,costoEstimado,cmbRubro,numpersonal,txtRubro,txtCategoria,cmbCategorias,d.codigoUnidad  
				   FROM _870_tablaDinamica d,_868_tablaDinamica r,_867_tablaDinamica c 
				   WHERE cmbCiclo=".$idCiclo." AND cmbRubro=id__868_tablaDinamica AND cmbCategorias=id__867_tablaDinamica and id__870_tablaDinamica not in (".$listaCursos.")";
		$res=$con->obtenerFilas($consulta);
		$nofilas=$con->filasAfectadas;
		
		while($fila=mysql_fetch_row($res))
		{
			$conNombreU="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fila[9]."'";
			$nombreU=$con->obtenerValor($conNombreU);
			
			$conParticipantes="SELECT usuario FROM _870_dtgUsuario WHERE idReferencia=".$fila[0];
			$participantes=$con->obtenerListaValores($conParticipantes);
			if($participantes=="")
				$participantes="-1";
			
			$obj='{"idCurso":"'.$fila[0].'","nombre":"'.$fila[1].'","noHoras":"'.$fila[2].'","costo":"'.$fila[3].'","idRubro":"'.$fila[4].'","nomRubro":"'.$fila[6].'","noPersonas":"'.$fila[5].'","idCategoria":"'.$fila[8].'","nomCategoria":"'.$fila[7].'","codUnidad":"'.$fila[9].'","nomUnidad":"'.$nombreU.'","participantes":"'.$participantes.'"}';
			if($arrCursos=="")
				$arrCursos=$obj;
			else
				$arrCursos.=",".$obj;
		}
		$obj='{"num":"'.$nofilas.'","registros":['.uDJ($arrCursos).']}';
		echo $obj;
	}
	
	function guardarCursosCancelados()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			for($x=0;$x<$tamano;$x++)
			{
				$conExiste="SELECT idCursoRechazado FROM 9320_cursosRechazados WHERE idCurso=".$arreglo[$x];
				$existe=$con->obtenerValor($conExiste);
				if($existe=="")
				{
					$query[$ct]="INSERT INTO 9320_cursosRechazados(idCurso,estado) VALUES(".$arreglo[$x].",1)";
				}
				else
				{
					$query[$ct]="UPDATE 9320_cursosRechazados SET estado=1 WHERE idCursoRechazado=".$existe;
				}
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerListaParticipantesCurso()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$condWhere="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				switch($arrFiltro[$x]["data"]["type"])
				{
					case 'string':
						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
					break;
				}
			}
		} 
		$consulta="SELECT idUsuario,Nombre FROM 802_identifica  WHERE idUsuario IN (".$cadena.") ".$condWhere." order by Nombre";
		
		$res=$con->obtenerFilas($consulta);
		$nreg=$con->filasAfectadas;
		
		$arrParticipantes="";
		while($fila=mysql_fetch_row($res))
		{
			
			$obj='{"idUsuario":"'.$fila[0].'","Nombre":"'.$fila[1].'"}';	
			if($arrParticipantes=="")
				$arrParticipantes=$obj;
			else
				$arrParticipantes.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrParticipantes.']}';
		echo $obj;
	}
	
	function agruparCursos()
	{
		global $con;
		
		$idRubro=$_POST["idRubro"];
		$idCiclo=$_POST["idCiclo"];
		$cadena=$_POST["cadena"];
		$nombre=$_POST["nombre"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			$conNumeroMov="SELECT noAgrupacionCursos FROM 903_variablesSistema for update";
			$ultimoNumero=$con->obtenerValor($conNumeroMov);
			$nuevoNumero=$ultimoNumero+1;
			
			$query[$ct]="UPDATE 903_variablesSistema SET noAgrupacionCursos=".$nuevoNumero;
			$ct++;
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
			{
				$consulta2="begin";
				if($con->ejecutarConsulta($consulta2))
				{
					$y=0;
					
					for($x=0;$x<$tamano;$x++)
					{
						$conExiste="SELECT idCursoAgrupado FROM 9321_cursosAgrupados WHERE idCurso=".$arreglo[$x];
						$existe=$con->obtenerValor($conExiste);
						if($existe=="")
						{
							$query[$y]="INSERT INTO 9321_cursosAgrupados(idCurso,noGrupo,nombre,ciclo,idRubro) VALUES(".$arreglo[$x].",".$nuevoNumero.",'".$nombre."',".$idCiclo.",".$idRubro.")";
						}
						else
						{
							$query[$y]="UPDATE 9321_cursosAgrupados SET noGrupo=".$nuevoNumero." WHERE idCursoAgrupado=".$existe;
						}
						$y++;
					}
					
					$query[$y]="commit";
					if($con->ejecutarBloque($query))
						echo "1|";
					else
						echo "|";
				}
			}
		}
	}
	
	function obtenerCursosAgrupados()
	{
		global $con;
		
		$idCiclo=$_POST["idCiclo"];
		
		$arrCursos="";
		
		$conGrupos="SELECT DISTINCT(noGrupo) FROM 9321_cursosAgrupados WHERE ciclo=".$idCiclo;
		$listaG=$con->obtenerListaValores($conGrupos);
		if($listaG=="")
			$listaG="-1";
		
		$consulta="SELECT DISTINCT(noGrupo),id__868_tablaDinamica,txtRubro,nombre,id__867_tablaDinamica,txtCategoria,costo 
					FROM 9321_cursosAgrupados a, _868_tablaDinamica r,_867_tablaDinamica c
					WHERE a.ciclo=".$idCiclo." AND idRubro=id__868_tablaDinamica AND id__867_tablaDinamica=cmbCategorias";
		$res=$con->obtenerFilas($consulta);
		$nofilas=$con->filasAfectadas;
		
		while($fila=mysql_fetch_row($res))
		{
			$conNoPer="SELECT SUM(numpersonal) FROM _870_tablaDinamica c,9321_cursosAgrupados a
						  WHERE  id__870_tablaDinamica=idCurso AND noGrupo=".$fila[0];
			$noPer=$con->obtenerValor($conNoPer);
			if($noPer=="")
				$noPer=0;
				
			if($fila[6]=="")	
				$fila[6]=0;
			$obj='{"noGrupo":"'.$fila[0].'","idRubro":"'.$fila[1].'","nombreRubro":"'.$fila[2].'","nombreGrupo":"'.$fila[3].'","idCategoria":"'.$fila[4].'","nomCategoria":"'.$fila[5].'","noPersonas":"'.$noPer.'","costo":"'.$fila[6].'"}';
			if($arrCursos=="")
				$arrCursos=$obj;
			else
				$arrCursos.=",".$obj;
		}
		$obj='{"num":"'.$nofilas.'","registros":['.uDJ($arrCursos).']}';
		echo $obj;
	}
	
	function guardarTotalGrupo()
	{
		global $con;
		$noGrupo=$_POST["noGrupo"];
		$valor=$_POST["valor"];
		
		$query="UPDATE 9321_cursosAgrupados SET costo=".$valor." WHERE noGrupo=".$noGrupo;
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerCursosGrupo()
	{
		global $con;
		$noGrupo=$_POST["noGrupo"];
		
		$conCursosAgrupados="SELECT idCurso FROM 9321_cursosAgrupados WHERE noGrupo=".$noGrupo;
		$listaA=$con->obtenerListaValores($conCursosAgrupados);
		if($listaA=="")
			$listaA="-1";
			
		$arreAgrupados="";
		
		$consulta="SELECT id__870_tablaDinamica,unidad,d.codigoUnidad,txtCurso,numpersonal,cmbRubro
						FROM _870_tablaDinamica d,817_organigrama o
						WHERE d.codigoUnidad=o.codigoUnidad AND id__870_tablaDinamica IN (".$listaA.")";
		$res=$con->obtenerFilas($consulta);
		$nofilas=$con->filasAfectadas;
		while($fila=mysql_fetch_row($res))
		{
			$conNombreR="SELECT txtRubro FROM _868_tablaDinamica WHERE id__868_tablaDinamica=".$fila[5];
			$nombreRubro=$con->obtenerValor($conNombreR);
				
			if($fila[4]=="")	
				$fila[4]=0;
			$obj='{"idCurso":"'.$fila[0].'","unidad":"'.$fila[1].'","codigoUnidad":"'.$fila[2].'","txtCurso":"'.$fila[3].'","numpersonal":"'.$fila[4].'","nombreRubro":"'.$nombreRubro.'"}';
			if($arreAgrupados=="")
				$arreAgrupados=$obj;
			else
				$arreAgrupados.=",".$obj;
		}
		$obj='{"num":"'.$nofilas.'","registros":['.uDJ($arreAgrupados).']}';
		echo $obj;	
	}
	
	function agregarCursosGrupo()
	{
		global $con;
		$noGrupo=$_POST["noGrupo"];
		$idCiclo=$_POST["idCiclo"];
		$idRubro=$_POST["idRubro"];
		$cadena=$_POST["cadena"];
		$nombre=$_POST["nombre"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				$conExiste="SELECT idCursoAgrupado FROM 9321_cursosAgrupados WHERE idCurso=".$arreglo[$x];
				$existe=$con->obtenerValor($conExiste);
				if($existe=="")
				{
					$query[$ct]="INSERT INTO 9321_cursosAgrupados(idCurso,noGrupo,nombre,ciclo,idRubro) VALUES(".$arreglo[$x].",".$noGrupo.",'".$nombre."',".$idCiclo.",".$idRubro.")";
				}
				else
				{
					$query[$ct]="UPDATE 9321_cursosAgrupados SET noGrupo=".$noGrupo." WHERE idCursoAgrupado=".$existe;
				}
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function quitarCursosGrupo()
	{
		global $con;
		$noGrupo=$_POST["noGrupo"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				
				$query[$ct]="DELETE FROM 9321_cursosAgrupados WHERE idCurso=".$arreglo[$x]." AND noGrupo=".$noGrupo;
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function deshacerGrupo()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				
				$query[$ct]="DELETE FROM 9321_cursosAgrupados WHERE noGrupo=".$arreglo[$x];
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerCursosRechazados()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		
		$arrCursos="";
		
		$consulta="SELECT id__870_tablaDinamica,txtCurso,IntHoras,costoEstimado,cmbRubro,numpersonal,txtRubro,txtCategoria,cmbCategorias,d.codigoUnidad  
				   FROM _870_tablaDinamica d,_868_tablaDinamica r,_867_tablaDinamica c,9320_cursosRechazados rz 
				   WHERE cmbCiclo=".$idCiclo." AND cmbRubro=id__868_tablaDinamica AND cmbCategorias=id__867_tablaDinamica and id__870_tablaDinamica=rz.idCurso";
		$res=$con->obtenerFilas($consulta);
		$nofilas=$con->filasAfectadas;
		
		while($fila=mysql_fetch_row($res))
		{
			$conNombreU="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$fila[9]."'";
			$nombreU=$con->obtenerValor($conNombreU);
			
			$conParticipantes="SELECT idUsuarios FROM _870_Usuarios WHERE idReferencia=".$fila[0];
			$participantes=$con->obtenerListaValores($conParticipantes);
			if($participantes=="")
				$participantes="-1";
			
			$obj='{"idCurso":"'.$fila[0].'","nombre":"'.$fila[1].'","noHoras":"'.$fila[2].'","costo":"'.$fila[3].'","idRubro":"'.$fila[4].'","nomRubro":"'.$fila[6].'","noPersonas":"'.$fila[5].'","idCategoria":"'.$fila[8].'","nomCategoria":"'.$fila[7].'","codUnidad":"'.$fila[9].'","nomUnidad":"'.$nombreU.'","participantes":"'.$participantes.'"}';
			if($arrCursos=="")
				$arrCursos=$obj;
			else
				$arrCursos.=",".$obj;
		}
		$obj='{"num":"'.$nofilas.'","registros":['.uDJ($arrCursos).']}';
		echo $obj;
	}
	
	function restablecerCursosRechazados()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				
				$query[$ct]="DELETE FROM 9320_cursosRechazados WHERE idCurso=".$arreglo[$x];
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerTipoAudienciaCarpeta()
	{
		global $con;
		$tC=$_POST["tC"];
		$tU=$_POST["tU"];
		if($tC==1)
			$tC="1,10";
		$consulta="SELECT distinct id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica a,_4_tiposUGJ tU,_4_chkCategoriaAudiencia tC
					WHERE tU.idPadre=a.id__4_tablaDinamica AND tC.idPadre=a.id__4_tablaDinamica AND tU.idOpcion in
					(SELECT tipoDelito FROM  _17_gridDelitosAtiende dA WHERE dA.idReferencia=".$tU.") 	 AND tC.idOpcion in(".$tC.") 
					ORDER BY tipoAudiencia";
		$arrAudiencias=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrAudiencias;
	}
?>