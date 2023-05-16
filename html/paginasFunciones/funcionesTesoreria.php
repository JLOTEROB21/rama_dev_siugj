<?php session_start();
	include("conexionBD.php"); 
	include_once("cContabilidad.php");
	include_once("cTesoreria.php");
	include_once("libreriasFunciones/planPagos.php");	
	include_once("cfdi/funcionesFacturacion.php");
	$consulta="SELECT DISTINCT archivoInclude FROM 554_tiposProductos WHERE archivoInclude<>''";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		@include_once($fila[0]);
	}
	include_once("cfdi/cFDIFinkok.php");
	
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
			obtenerNominasPago();
		break;
		case 2:
			buscarEmpleadoNomina();
		break;
		case 3:
			registrarPagoNomina();
		break;
		case 4:
			registrarDatosBanco();
		break;
		case 5:
			obtenerDatosBanco();
		break;
		case 6:
			registrarDatosSucursal();
		break;
		case 7:
			registrarDatosCuenta();
		break;
		case 8:
			buscarCodigoProductoCaja();
		break;
		case 9:
			registrarVentaCaja();
		break;
		case 10:
			registrarDatosChequera();
		break;
		case 11:
			registrarCostosPlanEstudio();
		break;
		case 12:
			registrarCostosPlanEstudioGrado();
		break;
		case 13:
			registrarArregloCostosPlanEstudioGrado();
		break;
		case 14:
			obtenerTabuladorPlanPagoConcepto();
		break;
		case 15:
			obtenerTabuladorFechasPlanPago();
		break;
		case 16:
			registrarFechasTabuladorPago();
		break;
		case 17:
			obtenerTabuladorPlanPagoConceptoInscripcionAlumno();
		break;
		case 18:
			obtenerMontosTabuladorPlanPago();
		break;
		case 19:
			obtenerConfiguracionInterfaceCosteo();
		break;
		case 20:
			registrarCostoServicioPlan();
		break;
		case 21:
			obtenerCostoServicios();
		break;
		case 22:
			guardarCostoServiciosEstandarDescuento();
		break;
		case 23:
			obtenerValoresCostoServiciosEstandarDescuento();
		break;
		case 24:
			obtenerConfiguracionAvanzadaPlanPagos();
		break;
		case 25:
			guardarConfiguracionAvanzadaPlanPagos();
		break;
		case 26:
			obtenerZonasCategoria();
		break;
		case 27:
			obtenerZonasCategoriaDisponible();
		break;
		case 28:
			registrarZonasCategoria();
		break;
		case 29:
			removerZonasCategoria();
		break;
		case 30:
			registrarPorcentajeIVAZona();
		break;
		case 31:
			obtenerHistorialPorcentajeIVA();
		break;
		case 32:
			obtenerAdeudosClientes();
		break;
		case 33:
			registrarAbonoAdeudo();
		break;
		case 34:
			registrarCancelacionVentaPedido();
		break;
		case 35:
			obtenerNotasCreditoVigentes();
		break;
		case 36:
			registrarDevolucionProducto();
		break;
		case 37:
			obtenerAbonosAdeudo();
		break;
		case 38:
			obtenerAdeudosAProveedor();
		break;
		case 39:
			registrarAbonoAdeudoProveedor();
		break;
		case 40:
			registrarDatosReestructuracion();
		break;
		case 41:
			removerSerieCertificado();
		break;
		case 42:
			registrarSerieCertificado();
		break;
		case 43:
			buscarClienteFactura();
		break;
		case 44:
			buscarClienteFacturacionTipoCliente();
		break;
		case 45:
			obtenerDatosClienteFactura();
		break;
		case 46:
			generarCFDIVentaCaja();
		break;
		case 47:
			registrarComprobanteElectronico();
		break;
		case 48:
			cancelarComprobanteElectronico();
		break;
		case 49:
			modificarSituacionTimbradoEmpresa();
		break;
		case 50:
			buscarProveedorFactura();
		break;
		case 51:
			guardarComprobantesIngresoEgreso();
		break;
		case 52:
			verificarRFCClienteProveedor();
		break;
		case 53:
			reenviarComprobante();
		break;
		case 54:
			cambiarSituacionComprobante();
		break;
		case 55:
			obtenerVentasCaja();
		break;
		case 56:
			reintentarTimbradoFacturaCaja();
		break;
		case 57:
			obtenerIDComprobanteVenta();
		break;
		case 58:
			buscarClaveAutorizacion();
		break;
		case 59:
			obtenerExistenciaProductoCaja();
		break;
		case 60:
			obtenerNombreTipoCliente();
		break;
		case 61:
			obtenerVentasCliente();
		break;
		case 62:
			obtenerAbonosPedido();
		break;
		case 63:
			generarFacturaPublicoGeneral();
		break;
		
		case 64:
			registrarFirmaManifiestoEmpresa();
		break;
		case 65:
			obtenerCostoServiciosPorConcepto();
		break;
		case 66:
			obtenerPlanEstudioDisponiblesModuloPromociones();
		break;
		case 67:
			registrarPlanesEstudioModuloPromociones();
		break;
		case 68:
			obtenerPlanesEstudioModuloPromociones();
		break;
		case 69:
			obtenerPlanesEstudioModuloPromocionesRemover();
		break;
		case 70:
			removerPlanesEstudioModuloPromociones();
		break;
		case 71:
			registrarPerfilDescuento();
		break;
		case 72:
			registrarPerfilDescuentoGrado();
		break;
		case 73:
			removerPerfilDescuento();
		break;
		case 74:
			cancelarVentaCaja();
		break;
		case 75:
			retimbrarComprobanteFactura();
		break;
		case 76:
			registrarVentaCajaV2();
		break;
		case 77:
			verificarExistenciaCostoProducto();
		break;
		
	}
	
	function obtenerNominasPago()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT n.idNomina,n.quincenaAplicacion as nQuincena,quincenaAplicacion as noQuincena,fechaInicioIncidencias as inicioPeriodo,fechaFinIncidencias as finPeriodo,p.nombrePerfil,configuracion,ambitoAplicacion,n.descripcion 
					FROM 672_nominasEjecutadas n,662_perfilesNomina p WHERE etapa=1000 AND institucion='".$_SESSION["codigoInstitucion"]."' AND p.idPerfilesNomina=n.idPerfil";
		$resNom=$con->obtenerFilas($consulta);
		$arrNominas="";
		$ct=0;
		while($fNom=mysql_fetch_row($resNom))
		{
		  
		  
		  $descripcion=$fNom[8];
		  if($descripcion=="")
			  $descripcion="N/E";
		  
		  $tblAplica="<br><br><table>";
		  if($fNom[7]==1)
		  {
			  $tblAplica="<tr heigth='21'><td width='110'></td><td><span class='copyrigthSinPaddingNegro'>Toda la instituci&oacute;n</span></td></tr>";	
		  }
		  else
		  {
			  $cadObj='{"arreglo":'.str_replace("'","\"",$fNom[6])."}";	
		  
			  $obj=json_decode($cadObj);
			  
			  foreach($obj->arreglo as $e)
			  {
				  $comp="";
				  if(isset($e[2]))
				  {
					  $consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$e[2];
					  $nCalculo=$con->obtenerValor($consulta);
					  $comp="<td width='5'></td><td width='180'><b>Combinado con c&aacute;lculo:</b></td><td width='200'>".$nCalculo."</td>";	
				  }
				  switch($e[0])
				  {
					  case 2:
						  $consulta="select unidad from 817_organigrama where codigoUnidad='".$e[1]."'";
						  $depto=$con->obtenerValor($consulta);
						  $tblAplica.="<tr height='21'><td width='110'><b>Depto/&Aacute;rea:</b></td><td>".$depto."</td>".$comp."</tr>";
					  break;
					  case 3:
						  $consulta="select concat(Paterno,' ',Materno,' ',Nom) as nombre from 802_identifica where idUsuario='".$e[1]."'";
						  $nombre=$con->obtenerValor($consulta);
						  $tblAplica.="<tr height='21'><td width='110'><b>Empleado:</b></td><td>".$nombre."</td>".$comp."</tr>";
					  break;
					  case 4:
						  $consulta="select puesto from 819_puestosOrganigrama where cvePuesto='".$e[1]."'";
						  $puesto=$con->obtenerValor($consulta);
						  $tblAplica.="<tr height='21'><td width='110'><b>Puesto:</b></td><td>".$puesto."</td>".$comp."</tr>";
					  break;
					  case 5:
						  $consulta="select txtTipoContratacion from _669_tablaDinamica where id__669_tablaDinamica='".$e[1]."'";
						  $tContratacion=$con->obtenerValor($consulta);
						  $tblAplica.="<tr height='21'><td width='110'><b>Tipo contrataci&oacute;n:</b></td><td>".$tContratacion."</td>".$comp."</tr>";
					  break;	
					  case 6:
						  $consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta='".$e[1]."'";
						  $criterio=$con->obtenerValor($consulta);
						  $tblAplica.="<tr height='21'><td width='150'><b>Criterio de b&uacute;squeda:</b></td><td>".$criterio."</td>".$comp."</tr>";
					  break;	
					  case 7:
						  $consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad='".$e[1]."'";
						  $criterio=$con->obtenerValor($consulta);
						  $tblAplica.="<tr height='21'><td width='150'><b>Instituci&oacute;n:</b></td><td>".$criterio."</td>".$comp."</tr>";
					  break;	
				  }	
			  }
			  
		  }
		  $tblAplica."</table>";
		  $descripcion="<table><tr height='21'><td width='80' align='left'><span class='corpo8_bold'>Descripci&oacute;n:</span></td><td width='400' align='left'><span class='copyrigthSinPaddingNegro'>".$descripcion."</td></tr><tr height='21'><td><span class='corpo8_bold'>Aplicado a:</span></td><td><span class='copyrigthSinPaddingNegro'>".$tblAplica."</span></td></tr></table>";
		  
		  
		  $obj='{"idNomina":"'.$fNom[0].'","nQuincena":"'.$fNom[1].'","noQuincena":"'.$fNom[1].'","descripcion":"'.$descripcion.'","inicioPeriodo":"'.$fNom[3].'","finPeriodo":"'.$fNom[4].'","nombrePerfil":"'.$fNom[5].'"}';
		  
		  if($arrNominas=="")	
			  $arrNominas=$obj;
		  else
			  $arrNominas.=",".$obj;
		  $ct++;
	  }
		
		
		echo '{"numReg":"'.$ct.'","registros":['.$arrNominas.']}';
	}
	
	function registrarPagoNomina()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idNomina=$_POST["idNomina"];
		$consulta="update 671_asientosCalculosNomina set pagado=1,responsablePago=".$_SESSION["idUsr"].",fechaPago='".date("Y-m-d")."' where idUsuario=".$idUsuario." and idNomina=".$idNomina;
		eC($consulta);
	}
	
	function buscarEmpleadoNomina()
	{
		global $con;
		$idNomina=$_POST["idNomina"];
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		$consulta="";
		$comp="";
		
		
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="select a.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status,a.pagado as situacionEmpleado, a.idUsuario as noEmpleado
							from 802_identifica i,671_asientosCalculosNomina a   
							where i.idUsuario= a.idUsuario and a.idNomina=".$idNomina." and  Paterno like '".$criterio."%'";
			break;
			case "2": //Materno
				$consulta="select a.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status,a.pagado as situacionEmpleado, a.idUsuario as noEmpleado  
							from 802_identifica i,671_asientosCalculosNomina a 
							where i.idUsuario= a.idUsuario and a.idNomina=".$idNomina." and Materno like '".$criterio."%'";
			break;
			case "3": //Nombre
				$consulta="select a.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status,a.pagado as situacionEmpleado, a.idUsuario as noEmpleado   
							from 802_identifica i,671_asientosCalculosNomina a  where i.idUsuario= a.idUsuario and a.idNomina=".$idNomina." and Nom like '".$criterio."%'";
			break;
			case "4": //No empleado
				$consulta="select a.idUsuario,Paterno, Materno,Nom as Nom,Nombre,'' as Status,a.pagado as situacionEmpleado, concat('<b>',a.idUsuario,'</b>') as noEmpleado  
							from 802_identifica i,671_asientosCalculosNomina a where i.idUsuario= a.idUsuario and a.idNomina=".$idNomina."  and i.idUsuario like '".$criterio."%'";
			break;
		}
		$consulta.=" order by Paterno,Materno,Nom asc";
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
			$obj='{"situacionEmpleado":"'.$fila[6].'","noEmpleado":"'.$fila[7].'","idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'","Status":"'.$situaciones.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$nFilas.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
		
		
	}
	
	function registrarDatosBanco()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$query="select count(*) from 6000_bancos where nombreBanco='".cv($obj->nombreBanco)."' and idBanco!=".$obj->idBanco;
		$nBancos=$con->obtenerValor($query);
		if($nBancos>0)
		{
			echo "<br>El nombre del banco ingresado ya existe";
			return;
		}
		$consulta[$x]="begin";
		$x++;
		
		if($obj->idBanco=="-1")
		{
			$consulta[$x]="INSERT INTO 6000_bancos(nombreBanco,nombreCorto,idFuncionLayOutTranferencia,idFuncionLayOutRecepcion,fechaCreacion,idResponsableCreacion) 
						VALUES('".cv($obj->nombreBanco)."','".cv($obj->nombreCorto)."',".$obj->idFuncionEscritorLayOut.",".$obj->idFuncionLectorLayOut.",'".date("Y-m-d H:i")."','".$_SESSION["idUsr"]."')";
			$x++;
		}
		else
		{
			$consulta[$x]="update 6000_bancos set nombreBanco='".cv($obj->nombreBanco)."',nombreCorto='".cv($obj->nombreCorto)."',idFuncionLayOutTranferencia=".$obj->idFuncionEscritorLayOut.",idFuncionLayOutRecepcion=".$obj->idFuncionLectorLayOut.",
						fechaModificación='".date("Y-m-d H:i")."',idResponsableModificacion='".$_SESSION["idUsr"]."',situacion=".$obj->situacion." where idBanco=".$obj->idBanco;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			if($obj->idBanco==-1)
			{
				$query="select last_insert_id()";
				$obj->idBanco=$con->obtenerValor($query);
			}
			echo "1|".$obj->idBanco;
		}
	}
	
	function obtenerDatosBanco()
	{
		global $con;
		$idBanco=$_POST["idBanco"];
		$consulta="select * from 6000_bancos where idBanco=".$idBanco;
		$fBanco=$con->obtenerPrimeraFila($consulta);
		$nFuncionTrans="";
		if($fBanco[3]!="")
		{
			$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fBanco[3];
			$nFuncionTrans=$con->obtenerValor($consulta);
		}
		$nFuncionRecep="";
		if($fBanco[4]!="")
		{
			$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fBanco[4];
			$nFuncionRecep=$con->obtenerValor($consulta);
		}
		$arrHijos=obtenerDatosSucursales($idBanco);
		$comp="leaf:true";
		if($arrHijos!="[]")
			$comp="leaf:false,children:".$arrHijos;
		$cadObj='[{"icon":"../images/user_gray.png","id":"'.$fBanco[0].'","text":"[<b>'.cv($fBanco[2]).'</b>] '.cv($fBanco[1]).'","tipo":"0","nombreBanco":"'.cv($fBanco[1]).'","nombreCorto":"'.cv($fBanco[2]).
				'","idFuncionLayOutTranferencia":"'.$fBanco[3].'","nombreFuncionTransferencia":"'.$nFuncionTrans.'","idFuncionLayOutRecepcion":"'.$fBanco[4].
				'","nombreFuncionRecepcion":"'.$nFuncionRecep.'","situacion":"'.$fBanco[9].'",'.$comp.'}]';	
		
		echo $cadObj;
	}
	
	function obtenerDatosSucursales($idBanco)
	{
		global $con;
		$arrElementos="";
		$obj="";
		$consulta="SELECT * FROM 6001_sucursales WHERE idBanco=".$idBanco." ORDER BY nombreSucursal";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT codigoInternacional,lada,telefono,extension,nombreContacto FROM 6003_telefonosContacto WHERE idSucursal=".$fila[0];
			$arrTelefonos=$con->obtenerFilasArreglo($consulta);
			$consulta="SELECT emailContacto,titularEmail FROM 6002_emailContactoSucursalBancaria WHERE idSucursal= ".$fila[0];
			$arrMail=$con->obtenerFilasArreglo($consulta); 
			
			$lblText='[<b>No. Sucursal</b> '.$fila[2].'] <b>Sucursal:</b> <span class=\'letraRojaSubrayada8\' style=\'color:#B0281A !important\'>'.cv($fila[3])."</span>";
			$lblDomicio="";
			if($fila[4]!="")
				$lblDomicio="Calle: ".$fila[4];
			
			if($fila[5]!="")
			{
				if($lblDomicio=="")
					$lblDomicio="Número: ".$fila[5];
				else
					$lblDomicio.=" Número: ".$fila[5];
			}
			
			if($fila[6]!="")
			{
				if($lblDomicio=="")
					$lblDomicio="Colonia: ".$fila[6];
				else
					$lblDomicio.=" Colonia: ".$fila[6];
			}
			
			if($fila[7]!="")
			{
				if($lblDomicio=="")
					$lblDomicio="C.P.: ".$fila[7];
				else
					$lblDomicio.=" C.P.: ".$fila[7];
			}
			$existePresedente=false;
			if($fila[10]!="")
			{
				$consulta="SELECT localidad FROM 822_localidades WHERE cveLocalidad='".$fila[10]."'";
				$localidad=$con->obtenerValor($consulta);
				if($lblDomicio=="")
					$lblDomicio="Loc. ".$localidad;
				else
					$lblDomicio.=". Loc. ".$localidad;
				$existePresedente=true;
			}
			
			if($fila[9]!="")
			{
				$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fila[9]."'";
				$municipio=$con->obtenerValor($consulta);
				if($lblDomicio=="")
					$lblDomicio="Mpio. ".$municipio;
				else
					if($existePresedente)
						$lblDomicio.=", Mpio. ".$municipio;
					else
						$lblDomicio.=". Mpio. ".$municipio;
				$existePresedente=true;
			}
			
			if($fila[8]!="")
			{
				$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fila[8]."'";
				$estado=$con->obtenerValor($consulta);
				if($lblDomicio=="")
					$lblDomicio="Edo. ".$estado;
				else
					if($existePresedente)
						$lblDomicio.=", Edo. ".$estado;
					else
						$lblDomicio.=". Edo. ".$estado;

			}
			
			if($lblDomicio!="")
				$lblText.="(".$lblDomicio.")";
			$arrHijos=obtenerDatosCuenta($fila[0]);
			$comp="leaf:true";
			if($arrHijos!="[]")
				$comp="leaf:false,children:".$arrHijos;
			$obj='{"icon":"../images/sitemap_color.png","arrMail":'.$arrMail.',"arrTelefonos":'.$arrTelefonos.',"tipo":"1","noSucursal":"'.$fila[2].'","nombreSucursal":"'.$fila[3].'","calle":"'.$fila[4].'","numero":"'.$fila[5].'","colonia":"'.$fila[6].'","cp":"'.$fila[7].'","estado":"'.$fila[8].
					'","municipio":"'.$fila[9].'","localidad":"'.$fila[10].'","id":"s'.$fila[0].'","idSucursal":"'.$fila[0].'","text":"'.$lblText.'",'.$comp.'}';
			if($arrElementos=="")
				$arrElementos=$obj;
			else	
				$arrElementos.=",".$obj;
		}
		return "[".$arrElementos."]";
	}
	
	function obtenerDatosCuenta($idSucursal)
	{
		global $con;
		$arrElementos="";
		$obj="";
		$consulta="SELECT * FROM 6004_cuentasBancarias WHERE idSucursal=".$idSucursal." ORDER BY noCuenta";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$lblText="[<b>Cta.</b> ".$fila[3];
			if($fila[4]!="")
			{
				$lblText.=", <b>CLABE:</b> ".$fila[4];
			}
			$lblText.="] ".$fila[2].", <b>Titular de la cuenta:</b> ".$fila[14];
			$comp="leaf:true";
			$arrHijos=obtenerDatosChequeras($fila[0]);
			if($arrHijos!="[]")
				$comp="leaf:false,children:".$arrHijos;
			$consulta="SELECT f.idUsuario,u.Nombre FROM 6006_firmantesChequera f,800_usuarios u WHERE u.idUsuario=f.idUsuario AND f.idCuentaCheques=".$fila[0]." order by u.Nombre";
			$arrFirmantes=$con->obtenerFilasArreglo($consulta);
			
			$obj='{"responsablesFirma":'.$arrFirmantes.',"tipoCuenta":"'.$fila[15].'","icon":"../images/coins.png","tipo":"2","descripcionCuenta":"'.cv($fila[2]).'","noCuenta":"'.cv($fila[3]).'","clabeInterbancaria":"'.cv($fila[4]).'","monedaCuenta":"'.cv($fila[5]).
					'","diaCorte":"'.cv($fila[6]).'","cuentaCheques":"'.cv($fila[7]).'",
					"fechaApertura":"'.cv($fila[8]).'","noCliente":"'.cv($fila[9]).'","nombreCliente":"'.cv($fila[14]).'","id":"c'.$fila[0].'","idCuenta":"'.$fila[0].'","text":"'.$lblText.'",'.$comp.'}';
			if($arrElementos=="")
				$arrElementos=$obj;
			else	
				$arrElementos.=",".$obj;	
		}
		return "[".$arrElementos."]";
	}
	
	function obtenerDatosChequeras($idCuenta)
	{
		global $con;
		
		$arrElementos="";
		$obj="";
		$consulta="SELECT * FROM 6005_chequerasCuentasBancarias WHERE idCuentaBancaria=".$idCuenta." ORDER BY noChequera";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$lblText="[<b>No. Chequera:</b> ".$fila[2];
			$lblText.=", <span class='corpo8_bold'>Folios del </span> ".$fila[4]." <span class='corpo8_bold'>al</span> ".$fila[5].", <span class='corpo8_bold'>Folio Actual:</span> ".$fila[7]."] <b>Descripci&oacute;n:</b> ".$fila[3];
			$obj='{"icon":"../images/money_bookers.png","tipo":"3","noChequera":"'.$fila[2].'","descripcion":"'.cv($fila[3]).'","folioInicial":"'.$fila[4].'","folioFinal":"'.$fila[5].'","folioActual":"'.$fila[7].'",
					"situacion":"'.$fila[6].'","idChequera":"'.$fila[0].'","text":"'.$lblText.'","id":"ch'.$fila[0].'",leaf:true}';
			if($arrElementos=="")
				$arrElementos=$obj;
			else	
				$arrElementos.=",".$obj;	
		}
		return "[".$arrElementos."]";
	}
	
	function registrarDatosSucursal()
	{
		
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		if($obj->idSucursal==-1)
		{
			$consulta[$x]="INSERT INTO 6001_sucursales(idBanco,noSucursal,nombreSucursal,calle,numero,colonia,cp,estado,municipio,localidad,fechaCreacion,idResponsableCreacion)
						VALUES(".$obj->idBanco.",'".cv($obj->noSucursal)."','".cv($obj->nombreSucursal)."','".cv($obj->calle)."','".cv($obj->numero)."','".cv($obj->colonia).
						"','".cv($obj->cp)."','".cv($obj->estado)."','".cv($obj->municipio)."','".cv($obj->localidad)."','".date("Y-m-d H:i")."',".$_SESSION["idUsr"].")";
			$x++;
			$consulta[$x]="set @idSucursal:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="update 6001_sucursales set noSucursal='".cv($obj->noSucursal)."',nombreSucursal='".cv($obj->nombreSucursal)."',calle='".cv($obj->calle).
						"',numero='".cv($obj->numero)."',colonia='".cv($obj->colonia)."',cp='".cv($obj->cp)."',estado='".cv($obj->estado).
						"',municipio='".cv($obj->municipio)."',localidad='".cv($obj->localidad)."',fechaModificación='".date("Y-m-d H:i").
						"',idResponsableModificacion=".$_SESSION["idUsr"]." where idSucursal=".$obj->idSucursal;
			$x++;
			$consulta[$x]="set @idSucursal:=".$obj->idSucursal;
			$x++;
			$consulta[$x]="DELETE FROM 6002_emailContactoSucursalBancaria WHERE idSucursal=@idSucursal";
			$x++;
			$consulta[$x]="DELETE FROM 6003_telefonosContacto WHERE idSucursal=@idSucursal";
			$x++;
		}
		if(sizeof($obj->telefonos)>0)
		{
			foreach($obj->telefonos as $t)
			{
				$consulta[$x]="INSERT INTO 6003_telefonosContacto(codigoInternacional,lada,telefono,extension,nombreContacto,idSucursal)
								VALUES('".cv($t->codigoInternacional)."','".cv($t->lada)."','".cv($t->telefono)."','".cv($t->extension)."','".cv($t->nombreContacto)."',@idSucursal)";
				$x++;
			}
		}
		if(sizeof($obj->email)>0)
		{
			foreach($obj->email as $e)
			{
				$consulta[$x]="INSERT INTO 6002_emailContactoSucursalBancaria(emailContacto,titularEmail,idSucursal)
								VALUES('".cv($e->emailContacto)."','".cv($e->titularEmail)."',@idSucursal)";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function registrarDatosCuenta()
	{
		
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$diaCorte="NULL";
		if($obj->diaCorte!="")
			$diaCorte=$obj->diaCorte;
		$fechaApertura="NULL";
		if($obj->fechaApertura!="")
			$fechaApertura="'".$obj->fechaApertura."'";
		if($obj->idCuenta==-1)
		{
			$query="select count(*) from 6004_cuentasBancarias where noCuenta='".$obj->noCuenta."' and idSucursal=".$obj->idSucursal;
			$nCuentas=$con->obtenerValor($query);
			if($nCuentas>0)
			{
				echo "<br>El n&uacute;mero de cuenta ya sa sido registrado anteriormente";
				return;
			}
			
			$consulta[$x]="INSERT INTO 6004_cuentasBancarias(idSucursal,noCliente,noCuenta,descripcionCuenta,clabeInterbancaria,fechaApertura,
							monedaCuenta,diaCorte,cuentaCheques,nombreCliente,fechaCreacion,idResponsableCreacion,idTipoCuentaBancaria)
							VALUES(".$obj->idSucursal.",'".$obj->noCliente."','".$obj->noCuenta."','".cv($obj->descripcionCuenta)."','".$obj->clabeInterbancaria."',".$fechaApertura.
							",".$obj->monedaCuenta.",".$diaCorte.",".$obj->cuentaCheques.",'".cv($obj->nombreCliente)."','".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$obj->tipoCuenta.")";

			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$query="select count(*) from 6004_cuentasBancarias where noCuenta='".$obj->noCuenta."' and idCuenta<>".$obj->idCuenta;
			$nCuentas=$con->obtenerValor($query);
			if($nCuentas>0)
			{
				echo "<br>El n&uacute;mero de cuenta ya sa sido registrado anteriormente";
				return;
			}
			$consulta[$x]="update 6004_cuentasBancarias set noCliente='".$obj->noCliente."',noCuenta='".$obj->noCuenta."',descripcionCuenta='".cv($obj->descripcionCuenta)."',
						clabeInterbancaria='".$obj->clabeInterbancaria."',fechaApertura=".$fechaApertura.",
							monedaCuenta=".$obj->monedaCuenta.",diaCorte=".$diaCorte.",cuentaCheques=".$obj->cuentaCheques.",nombreCliente='".cv($obj->nombreCliente)."',
							fechaModificación='".date("Y-m-d H:i")."',idResponsableModificacion=".$_SESSION["idUsr"].",idTipoCuentaBancaria=".$obj->tipoCuenta." where idCuenta=".$obj->idCuenta;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idCuenta;
			$x++;
			
		}
		
		$consulta[$x]="delete from 6006_firmantesChequera where idCuentaCheques=@idRegistro";
		$x++;
		if(sizeof($obj->responsablesFirma)>0)
		{
			foreach($obj->responsablesFirma as $f)
			{
				$consulta[$x]="INSERT INTO 6006_firmantesChequera(idUsuario,idCuentaCheques) VALUES(".$f->idUsuario.",@idRegistro)";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;

		eB($consulta);
		
	}
	
	function buscarCodigoProductoCaja()
	{
		global $con;
		$codigo=$_POST["codigo"];
		$idCaja=$_POST["idCaja"];
		$tipoBusqueda=$_POST["tipoBusqueda"];
		$tipoCliente=$_POST["tipoCliente"];
		$idCliente=$_POST["idCliente"];
		
		$consulta="SELECT p.* from 6007_instanciasCaja i,6006_perfilesCaja p WHERE p.idPerfilCaja=i.idPerfilCaja AND idCaja=".$idCaja;
		$fCaja=$con->obtenerPrimeraFila($consulta);	
		$idFuncionCatalogoProducto=$fCaja[3];
		$idFuncionVentaProducto=$fCaja[4];
		$cadObj='{"idCaja":"'.$idCaja.'","codigo":"'.$codigo.'","tipoBusqueda":"'.$tipoBusqueda.'","tipoCliente":"'.$tipoCliente.'","idCliente":"'.$idCliente.'"}';
		$obj=json_decode($cadObj);
		$cache=NULL;
		$arrObj="";

		$arrProducto=resolverExpresionCalculoPHP($idFuncionCatalogoProducto,$obj,$cache);
		
		
		
		$metaData="";
		if(($arrProducto)&&(sizeof($arrProducto)>0))
		{
			foreach($arrProducto as $fProducto)
			{
				
				
				if(isset($fProducto["metaData"]))
				{
					$metaData=$fProducto["metaData"];
				}
				else
				{
					
					$dimensiones="";
					if($fProducto["dimensiones"]!="")
						$dimensiones=bE(serialize($fProducto["dimensiones"]));
					$padre="null";
					if(isset($fProducto["padre"])&&($fProducto["padre"]!="")&&($fProducto["padre"]!="-1"))
					{
						$padre=$fProducto["padre"];
					}
					$hoja="true";
					
					if(isset($fProducto["hoja"])&&($fProducto["hoja"]!="")&&($fProducto["hoja"]!="-1"))
					{
						$hoja=$fProducto["hoja"];
					}
					
					if(!isset($fProducto["subtotal"]))
						$fProducto["subtotal"]="";
						
					if(!isset($fProducto["iva"]))
						$fProducto["iva"]="";
					
					if(!isset($fProducto["total"]))
						$fProducto["total"]="";
					
					$idRegistro=-1;
					if(isset($fProducto["idRegistro"]))
					{
						$idRegistro=$fProducto["idRegistro"];
					}
					$sL=0;
					if(isset($fProducto["sL"]))
						$sL=$fProducto["sL"];
					$numDevueltos=0;
					if(isset($fProducto["numDevueltos"]))
						$numDevueltos=$fProducto["numDevueltos"];
					if($fProducto["imagen"]=="[]")	
						$fProducto["imagen"]="";
						
					$descuento=0;
					if(isset($fProducto["descuento"]))	
						$descuento=$fProducto["descuento"];
						
						
					$costoUnitarioConDescuento=0;
					if(isset($fProducto["costoUnitarioConDescuento"]))	
						$costoUnitarioConDescuento=$fProducto["costoUnitarioConDescuento"];	
						
					$tipoPrecio=0;
					
					if(isset($fProducto["tipoPrecio"]))	
						$tipoPrecio=$fProducto["tipoPrecio"];
					
					$productoConExistencia=1;
					if(isset($fProducto["productoConExistencia"]))
						$productoConExistencia=$fProducto["productoConExistencia"];
					
					
					$oProducto='{"unidadMedida":"'.$fProducto["unidadMedida"].'","arrUnidadMedida":'.$fProducto["arrUnidadesMedida"].',"costoUnitarioConDescuento":"'.$costoUnitarioConDescuento.
								'","precioUnitarioOriginal":"'.$fProducto["costoUnitario"].'","tipoPrecio":"'.$tipoPrecio.'","descuento":"'.$descuento.'","numDevueltos":"'.$numDevueltos.
								'","sL":"'.$sL.'","idRegistro":"'.$idRegistro.'","llave":"'.$fProducto["llaveProducto"].'","porcentajeIVA":"'.$fProducto["porcentajeIVA"].'","descripcion":"'.
								cv($fProducto["descripcion"]).'","cveProducto":"'.cv($fProducto["cveProducto"]).'","concepto":"'.cv($fProducto["concepto"]).'","costoUnitario":"'.$fProducto["costoUnitarioNeto"].
								'","cantidad":"'.$fProducto["cantidad"].'","subtotal":"'.$fProducto["subtotal"].'","iva":"'.$fProducto["iva"].'","total":"'.$fProducto["total"].'","imagen":['.
								$fProducto["imagen"].'],"tipoConcepto":"'.$fProducto["tipoConcepto"].'","idProducto":"'.$fProducto["idProducto"].'","detalle":['.($fProducto["detalle"]).'],"tipoMovimiento":"'.
							$fProducto["tipoMovimiento"].'","dimensiones":"'.$dimensiones.'","_parent":'.$padre.',"_is_leaf":'.$hoja.',"productoConExistencia":"'.$productoConExistencia.'"}';
				
					
					if($arrObj=="")
					{
						$arrObj=$oProducto;	
					}
					else
						$arrObj.=",".$oProducto;	
				}
			}
		}
		echo '1|['.$arrObj.']|'.$metaData;
		
		
	}
	
	function registrarVentaCaja()
	{
		global $con;
		
		$numDias=60;
		$libro=new cContabilidad();
		$idCaja=$_POST["idCaja"];
		$tipoOperacion=$_POST["tipoOperacion"];//1 Venta, 2 Pedido
		$arrDevoluciones=array();
		$arrApartados=array();	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT p.* from 6007_instanciasCaja i,6006_perfilesCaja p WHERE p.idPerfilCaja=i.idPerfilCaja AND idCaja=".$idCaja;
		$fCaja=$con->obtenerPrimeraFila($consulta);	
		$idFuncionCatalogoProducto=$fCaja[3];
		$idFuncionVentaProducto=$fCaja[4];
		if($idFuncionVentaProducto=="")
			$idFuncionVentaProducto=-1;
			
		
		$x=0;
		$query[$x]="begin";
		$x++;
		switch($tipoOperacion)
		{
			case 1://Venta
				if(isset($obj->tipoCliente))
				{
					$query[$x]="INSERT INTO 6008_ventasCaja(fechaVenta,idResponsableVenta,idCaja,situacion,subtotal,iva,total,formaPago,datosCompra,tipoCliente,idCliente,totalDescuento)
								VALUES('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$idCaja.",1,'".$obj->subtotal."','".$obj->iva."','".$obj->total."','".$obj->formaPago."','".dv($obj->datosCompra)."',".$obj->tipoCliente.",".$obj->idCliente.",".$obj->totalDescuento.")";
					$x++;
				}
				else
				{
					$query[$x]="INSERT INTO 6008_ventasCaja(fechaVenta,idResponsableVenta,idCaja,situacion,subtotal,iva,total,formaPago,datosCompra)
								VALUES('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$idCaja.",1,'".$obj->subtotal."','".$obj->iva."','".$obj->total."','".$obj->formaPago."','".dv($obj->datosCompra)."')";
					$x++;
				}
				$query[$x]="set @idVenta:=(select last_insert_id())";
				$x++;
				$folioVenta=generarNombreArchivoTemporal(1,"");
				$query[$x]="UPDATE 6008_ventasCaja SET folioVenta='".$folioVenta."' WHERE idVenta=@idVenta";
				$x++;
				if((isset($obj->idPedido))&&($obj->idPedido!=-1))
				{
					$query[$x]="UPDATE 6008_ventasCaja SET idPedido=".$obj->idPedido." WHERE idVenta=@idVenta";
					$x++;
					$query[$x]="UPDATE 6934_pedidosTienda SET situacion=2 WHERE idPedidoTienda=".$obj->idPedido;
					$x++;
				}
				
				foreach($obj->arrProductos as $p)
				{
					if($p->porcentajeIVA=="")
						$p->porcentajeIVA=0;
						
					if(isset($obj->tipoCliente))
					{
						$query[$x]="INSERT INTO 6009_productosVentaCaja(idVenta,idProducto,tipoProducto,cantidad,costoUnitario,subtotal,iva,claveProducto,total,tipoMovimiento,dimensiones,llave,porcentajeIVA,descuentoTotal,descuentoUnitario,metaData,descripcion)
									VALUES(@idVenta,".$p->idProducto.",".$p->tipoConcepto.",".$p->cantidad.",".$p->costoUnitario.",".$p->subtotal.",".$p->iva.",'".$p->cveProducto."',".$p->total.",'".$p->tipoMovimiento.
									"','".bD($p->dimensiones)."','".$p->llave."',".$p->porcentajeIVA.",".$p->descuento.",".$p->descuentoUnitario.",'".cv($p->metaData)."','".cv($p->descripcion)."')";
						
						
						$x++;
					}
					else
					{
						$query[$x]="INSERT INTO 6009_productosVentaCaja(idVenta,idProducto,tipoProducto,cantidad,costoUnitario,subtotal,iva,claveProducto,total,tipoMovimiento,dimensiones,metaData,descripcion)
									VALUES(@idVenta,".$p->idProducto.",".$p->tipoConcepto.",".$p->cantidad.",".$p->costoUnitario.",".$p->subtotal.",".$p->iva.",'".$p->cveProducto."',".$p->total.",'".$p->tipoMovimiento.
									"','".bD($p->dimensiones)."','".cv($p->metaData)."','".cv($p->descripcion)."')";
						$x++;
					}
					
					
					if($p->metaData!='')
					{
						$query[$x]="set @idProductoVenta:=(select last_insert_id())";
						$x++;
						$oMeta=json_decode($p->metaData);
						$reflectionClase = new ReflectionObject($oMeta);
						foreach ($reflectionClase->getProperties() as $property => $value) 
						{
							$nombre=$value->getName();
							$valor=$value->getValue($oMeta);
							$query[$x]="INSERT INTO 6010_productosVentaMetaData(idProductoVenta,campo,valor) VALUES(@idProductoVenta,'".cv($nombre)."','".cv($valor)."')";
							$x++;
						}
					}
					
					
				}
				
				
				foreach($obj->desgloceFormaPago as $fP)
				{
					$query[$x]	="INSERT INTO 6024_detalleFormaPagoVenta(idFormaPago,montoPago,idVenta,tipoVenta) VALUES(".$fP->formaPago.",".$fP->montoPago.",@idVenta,1)";
					$x++;
				}
				
				if(sizeof($obj->arrNotasCredito)>0)
				{
					foreach($obj->arrNotasCredito as $n)
					{
						$query[$x]="UPDATE 6947_notasCredito SET situacion=0,idTipoUsoMovimiento=1,idUsoMovimiento=@idVenta WHERE idNota=".$n->idNota;
						$x++;	
					}	
				}
				
				if($obj->montoNota>0)
				{
					$query[$x]="INSERT INTO 6947_notasCredito(fechaCreacion,total,idTipoOrigenMovimiento,idOrigenMovimiento,situacion,tipoCliente,idCliente)
									values('".date("Y-m-d H:i:s")."',".$obj->montoNota.",1,@idVenta,1,".$obj->tipoCliente.",".$obj->idCliente.")";
					$x++;
					$query[$x]="set @idNota:=(select last_insert_id())";
					$x++;
					$query[$x]="UPDATE 6947_notasCredito SET folioNota=idNota WHERE idNota=@idNota";
					$x++;
				}
				
				$porcIva=$obj->iva/$obj->total;
				$datosVenta=json_decode($obj->datosCompra);
				
				if(($obj->formaPago==3)||($obj->formaPago==4))
				{
					
					$fechaVencimiento=date("Y-m-d",strtotime("+".$numDias." days",strtotime(date("Y-m-d"))));
					
					
					$query[$x]="INSERT INTO 6942_adeudos(tipoAdeudo,idReferencia,fechaCreacion,subtotal,iva,total,tipoCliente,idCliente,situacion,fechaVencimiento)
								VALUES(1,@idVenta,'".date("Y-m-d H:i:s")."',".$obj->subtotal.",".$obj->iva.",".$obj->total.",".$obj->tipoCliente.",".$obj->idCliente.",1,'".$fechaVencimiento."')";
					$x++;
					$query[$x]="set @idAdeudo:=(select last_insert_id())";
					$x++;
					
					if($datosVenta->montoAbono>0)
					{
						$consulta="select sum(montoAbono) from 6936_controlPagos where idAdeudo=@idAdeudo";
						$montoAbonado=$con->obtenerValor($consulta);	
						$saldo=$obj->total-$montoAbonado;
						$saldoVirtual=$saldo-$datosVenta->montoAbono;
						$subtotal=0;
						$iva=0;
						if($saldoVirtual<=0)
						{
							$query="select sum(iva) from 6936_controlPagos where idAdeudo=@idAdeudo";
							$totalIVA=$con->obtenerValor($query);
							$diferenciaIVA=$obj->iva-$totalIVA;
							$iva=$diferenciaIVA;
							$subtotal=$montoAbonado-$iva;
							$query[$x]="UPDATE 6942_adeudos SET situacion=2 WHERE idAdeudo=@idAdeudo";
							$x++;
						}
						else
						{
				
							$iva=str_replace(",","",number_format($datosVenta->montoAbono*$porcIva,2));	
				
							$subtotal=$datosVenta->montoAbono-$iva;
						}
						
						$folioAbono=generarNombreArchivoTemporal(1,"");
						
						$formaPago="1";
						if($datosVenta->pagoEfectivo->montoPagado>0)
						{

							if($datosVenta->pagoTarjeta->montoPagado>0)
							{
								$formaPago=9;
							}
						}
						else
						{
							if($datosVenta->pagoTarjeta->montoPagado>0)
							{
								$formaPago=2;
							}	
						}
						
						$query[$x]="INSERT INTO 6936_controlPagos(montoAbono,fechaAbono,idAdeudo,formaPago,horaAbono,idResponsableCobro,idCaja,subtotal,iva,folioAbono)
										VALUES(".$datosVenta->montoAbono.",'".date("Y-m-d")."',@idAdeudo,".$formaPago.",'".date("H:i:s")."',".$_SESSION["idUsr"].",".$idCaja.",".$subtotal.",".$iva.",'".$folioAbono."')";
						$x++;
						
					}
				}
				
			break;
			case 2://Pedido
				$oPedido=json_decode($obj->datosCompra);
				$query[$x]="INSERT INTO 6934_pedidosTienda(fechaCreacion,idResponsablePedido,idCaja,situacion,subtotal,iva,montoTotal,tipoCliente,idUsuarioPedido,totalDescuento,montoAnticipo,datosPedido)
							VALUES('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$idCaja.",1,'".$obj->subtotal."','".$obj->iva."','".$obj->total."',".$obj->tipoCliente.",".$obj->idCliente.",".$obj->totalDescuento.",".
							$oPedido->montoAbono.",'".cv($obj->datosCompra)."')";
				$x++;
				
				$query[$x]="set @idVenta:=(select last_insert_id())";
				$x++;
				$folioVenta=generarNombreArchivoTemporal(1,"");
				$query[$x]="UPDATE 6934_pedidosTienda SET folioPedido='".$folioVenta."' WHERE idPedidoTienda=@idVenta";
				$x++;
				
				foreach($obj->arrProductos as $p)
				{
					$query[$x]="INSERT INTO 6935_productosPedidoTienda(idPedido,idProducto,tipoProducto,cantidad,precioUnitario,subtotal,iva,total,llaveProducto,porcentajeIVA,descuentoTotal,descuentoUnitario)
								VALUES(@idVenta,".$p->idProducto.",".$p->tipoConcepto.",".$p->cantidad.",".$p->costoUnitario.",".$p->subtotal.",".$p->iva.",".$p->total.",'".$p->llave."',".$p->porcentajeIVA.",".$p->descuento.",".$p->descuentoUnitario.")";
					$x++;
				}
				
				foreach($obj->desgloceFormaPago as $fP)
				{
					$query[$x]	="INSERT INTO 6024_detalleFormaPagoVenta(idFormaPago,montoPago,idVenta,tipoVenta) VALUES(".$fP->formaPago.",".$fP->montoPago.",@idVenta,2)";
					$x++;
				}
				
				
				
				
				
				$query[$x]="INSERT INTO 6942_adeudos(tipoAdeudo,idReferencia,fechaCreacion,subtotal,iva,total,tipoCliente,idCliente,situacion,fechaVencimiento)
								VALUES(2,@idVenta,'".date("Y-m-d H:i:s")."',".$obj->subtotal.",".$obj->iva.",".$obj->total.",".$obj->tipoCliente.",".$obj->idCliente.",1,'".$fechaVencimiento."')";
				$x++;
				
				$query[$x]="set @idAdeudo:=(select last_insert_id())";
				$x++;
				
				if($oPedido->montoAbono>0)
				{
					$porcIva=$obj->iva/$obj->total;
					$consulta="select sum(montoAbono) from 6936_controlPagos where idAdeudo=@idAdeudo";
					$montoAbonado=$con->obtenerValor($consulta);	
					$saldo=$obj->total-$montoAbonado;
					$saldoVirtual=$saldo-$oPedido->montoAbono;
					$subtotal=0;
					$iva=0;
					if($saldoVirtual<=0)
					{
						$query="select sum(iva) from 6936_controlPagos where idAdeudo=@idAdeudo";
						$totalIVA=$con->obtenerValor($query);
						$diferenciaIVA=$obj->iva-$totalIVA;
						$iva=$diferenciaIVA;
						$subtotal=$montoAbonado-$iva;
						$query[$x]="UPDATE 6942_adeudos SET situacion=2 WHERE idAdeudo=@idAdeudo";
						$x++;
					}
					else
					{
			
						$iva=str_replace(",","",number_format($oPedido->montoAbono*$porcIva,2));	
			
						$subtotal=$oPedido->montoAbono-$iva;
					}
					
					$folioAbono=generarNombreArchivoTemporal(1,"");
					
					$formaPago="1";
					if($oPedido->pagoEfectivo->montoPagado>0)
					{

						if($oPedido->pagoTarjeta->montoPagado>0)
						{
							$formaPago=9;
						}
					}
					else
					{
						if($oPedido->pagoTarjeta->montoPagado>0)
						{
							$formaPago=2;
						}	
					}
					
					
					
					$query[$x]="INSERT INTO 6936_controlPagos(montoAbono,fechaAbono,idAdeudo,formaPago,horaAbono,idResponsableCobro,idCaja,subtotal,iva,folioAbono)
									VALUES(".$oPedido->montoAbono.",'".date("Y-m-d")."',@idAdeudo,".$formaPago.",'".date("H:i:s")."',".$_SESSION["idUsr"].",".$idCaja.",".$subtotal.",".$iva.",'".$folioAbono."')";
					$x++;
				}
				
				
				
			break;
			case 3://Guardar pedido
				$arrProductos="";
				$query[$x]="set @idVenta:=".$obj->idPedido;
				$x++;
				foreach($obj->arrProductos as $p)
				{
					if($p->idRegistro!=-1)
					{
						if($arrProductos=="")
							$arrProductos=$p->idRegistro;
						else
							$arrProductos.=",".$p->idRegistro;
						
					}
				}
				if($arrProductos=="")
					$arrProductos=-1;
					
				
				
				$objAsiento='{
								"tipoMovimiento":"",
								"cantidadOperacion":"",
								"idProducto":"",
								"tipoReferencia":"3",
								"datoReferencia1":"'.$obj->idPedido.'",
								"datoReferencia2":"",
								"complementario":"",
								"dimensiones":null
							}';
							
							
				$consulta="SELECT idProducto,cantidad,llaveProducto FROM 6935_productosPedidoTienda WHERE idPedido=".$obj->idPedido;	
				$res=$con->obtenerFilas($consulta);
				$c=NULL;
				while($fila=mysql_fetch_row($res))
				{
					$consulta="SELECT idAlmacen from 6901_catalogoProductos WHERE idProducto=".$fila[0];
					$idAlmacen=$con->obtenerValor($consulta);
					
					$c=new cAlmacen($idAlmacen);
					$oProducto=json_decode($objAsiento);
					$oProducto->tipoMovimiento=33;
					$oProducto->cantidadOperacion=$fila[1];
					$oProducto->idProducto=$fila[0];
					$oProducto->dimensiones=convertirLlaveDimensiones($fila[2]);
					array_push($arrDevoluciones,$oProducto);
					
				}	
					
				$c->asentarArregloMovimientos($arrDevoluciones,$query,$x,true);
								
					
					
				$query[$x]="DELETE from 6935_productosPedidoTienda where idPedido=".$obj->idPedido." and idProductoPedido not IN (".$arrProductos.")";
				$x++;			
				foreach($obj->arrProductos as $p)
				{
					if($p->idRegistro==-1)
					{
						$query[$x]="INSERT INTO 6935_productosPedidoTienda(idPedido,idProducto,tipoProducto,cantidad,precioUnitario,subtotal,iva,total,llaveProducto,porcentajeIVA,descuentoUnitario,descuentoTotal)
									VALUES(@idVenta,".$p->idProducto.",".$p->tipoConcepto.",".$p->cantidad.",".$p->costoUnitario.",".$p->subtotal.",".$p->iva.",".$p->total.",'".$p->llave."',".$p->porcentajeIVA.",".$p->descuentoUnitario.",".$p->descuento.")";
						$x++;
					}
					else
					{
						
						
						$query[$x]="update 6935_productosPedidoTienda set cantidad=".$p->cantidad.",precioUnitario=".$p->costoUnitario.",subtotal=".$p->subtotal.",iva=".$p->iva.
									",total=".$p->total.",porcentajeIVA=".$p->porcentajeIVA.",descuentoTotal=".$p->descuento.",descuentoUnitario=".$p->descuentoUnitario." where idProductoPedido=".$p->idRegistro;
						$x++;	
					}
				}
				
				
				$query[$x]="update 6934_pedidosTienda set idCaja=".$obj->idCaja.",subtotal='".$obj->subtotal."',iva='".$obj->iva."',montoTotal='".$obj->total."',totalDescuento=".$obj->totalDescuento." where idPedidoTienda=@idVenta";
				$x++;
				
			break;
		}
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			
			if($tipoOperacion!=3)
			{
				$consulta="select @idVenta";
				$idVenta=$con->obtenerValor($consulta);
				if($tipoOperacion==1)
				{
					if(sizeof($obj->arrNotasCredito)>0)
					{
						$query=array();
						$x=0;
						$query[$x]="begin";
						$x++;
						foreach($obj->arrNotasCredito as $n)	
						{
							$consulta="SELECT total FROM 6947_notasCredito WHERE idNota=".$n->idNota;
							$totalNota=$con->obtenerValor($consulta);
							
							
							$consulta="select @idAdeudo";
							$idAdeudo=$con->obtenerValor($consulta);
							if($idAdeudo!="")
							{
								$consulta="select sum(montoAbono) from 6936_controlPagos where idAdeudo=".$idAdeudo;
								$montoAbonado=$con->obtenerValor($consulta);	
								
								$saldo=$obj->total-$montoAbonado;
						
								
								$saldoVirtual=$saldo-$totalNota;
								
								$subtotal=0;
								$iva=0;
								if($saldoVirtual<=0)
								{
									$query="select sum(iva) from 6936_controlPagos where idAdeudo=".$idAdeudo;
									$totalIVA=$con->obtenerValor($query);
									$diferenciaIVA=$obj->iva-$totalIVA;
									$iva=$diferenciaIVA;
									$subtotal=$totalNota-$iva;
								}
								else
								{
						
									$iva=str_replace(",","",number_format($totalNota*$porcIva,2));	
						
									$subtotal=$totalNota-$iva;
								}
								$folioAbono=generarNombreArchivoTemporal(1,"");
								$query[$x]="INSERT INTO 6936_controlPagos(montoAbono,fechaAbono,idAdeudo,formaPago,horaAbono,idResponsableCobro,idCaja,datosComp,folioAbono)
												VALUES(".$totalNota.",'".date("Y-m-d")."',".$idAdeudo.",5,'".date("H:i:s")."',".$_SESSION["idUsr"].",".$idCaja.",'{\"idNota\":\"".$n->idNota."\"}','".$folioAbono."')";
								$x++;
							}
							
						}
						$query[$x]="commit";
						$x++;
						$con->ejecutarBloque($query);
					}
				}
				
				$consulta="select * from 6009_productosVentaCaja where idVenta=".$idVenta;
				$resProd=$con->obtenerFilas($consulta);
				$arrAsientos=array();
				while($fProducto=mysql_fetch_row($resProd))
				{
					
					if(($fProducto[11]!="")&&($fProducto[11]!=0))
					{
						$cadObj='{"tipoMovimiento":"'.$fProducto[11].'","montoOperacion":"'.$fProducto[8].'","dimensiones":[],"idProductoVenta":"'.$fProducto[0].'"}';
						$obj=json_decode($cadObj);
						if($fProducto[10]!="")
							$obj->dimensiones=unserialize($fProducto[10]);
						else
							$obj->dimensiones=array();
						$obj->dimensiones["idVenta"]=$idVenta;
						$obj->dimensiones["idCaja"]=$idCaja;
						array_push($arrAsientos	,$obj);
					}
				}
				
			
				if(sizeof($arrAsientos)>0)
				{
	
					if($libro->asentarArregloMovimientos($arrAsientos))
					{
						
						if($idFuncionVentaProducto!=-1)
						{
							$cadObj='{"idCaja":"'.$idCaja.'","idVenta":"'.$idVenta.'","tipoOperacion":"'.$tipoOperacion.'"}';
							$obj=json_decode($cadObj);
							$cache=NULL;
							resolverExpresionCalculoPHP($idFuncionVentaProducto,$obj,$cache);	
						}
						echo "1|".$idVenta;
					}			
				}
				else
				{

					if($idFuncionVentaProducto!=-1)
					{
						$cadObj='{"idCaja":"'.$idCaja.'","idVenta":"'.$idVenta.'","tipoOperacion":"'.$tipoOperacion.'"}';
						$obj=json_decode($cadObj);
						$cache=NULL;
						
						resolverExpresionCalculoPHP($idFuncionVentaProducto,$obj,$cache);	
					}
					echo "1|".$idVenta;
				}
			}
			else
			{
				$consulta="SELECT idProducto,cantidad,llaveProducto FROM 6935_productosPedidoTienda WHERE idPedido=".$obj->idPedido;	
				$res=$con->obtenerFilas($consulta);
				$c=NULL;
				while($fila=mysql_fetch_row($res))
				{
					$consulta="SELECT idAlmacen from 6901_catalogoProductos WHERE idProducto=".$fila[0];
					$idAlmacen=$con->obtenerValor($consulta);
					
					$c=new cAlmacen($idAlmacen);
					$oProducto=json_decode($objAsiento);
					$oProducto->tipoMovimiento=30;
					$oProducto->cantidadOperacion=$fila[1];
					$oProducto->idProducto=$fila[0];
					$oProducto->dimensiones=convertirLlaveDimensiones($fila[2]);
					array_push($arrApartados,$oProducto);
					
				}	
				$query=NULL;
				$x=NULL;		
				$c->asentarArregloMovimientos($arrApartados,$query,$x,true);
				echo "1|";
			}
		}
	}
	
	function registrarDatosChequera()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$query="select count(*) from 6005_chequerasCuentasBancarias where idCuentaBancaria=".$obj->idCuentaBancaria." and noChequera=".$obj->nChequera." and idChequera<>".$obj->idChequera;
		$nReg=$con->obtenerValor($query);
		if($nReg>0)
		{
			echo "<br>El n&uacute;mero de chequera ya se encuentra registrado";
			return;
		}
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idChequera==-1)
		{
			$consulta[$x]="INSERT INTO 6005_chequerasCuentasBancarias(idCuentaBancaria,noChequera,descripcion,folioInicial,folioFinal,situacion,folioActual,fechaCreacion,idResponsableCreacion)
						VALUES(".$obj->idCuentaBancaria.",".$obj->nChequera.",'".cv($obj->descripcion)."',".$obj->folioInicial.",".$obj->folioFinal.",".$obj->situacion.",".$obj->folioActual.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].")";
			$x++;
		}
		else
		{
			$consulta[$x]="update 6005_chequerasCuentasBancarias set noChequera=".$obj->nChequera.",descripcion='".cv($obj->descripcion)."',folioInicial=".$obj->folioInicial.",folioFinal=".$obj->folioFinal.
						",situacion=".$obj->situacion.",folioActual=".$obj->folioActual.",fechaModificación='".date("Y-m-d H:i:s")."',idResponsableModificacion=".$_SESSION["idUsr"]." where idChequera=".$obj->idChequera;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function registrarCostosPlanEstudio()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$idProgramaEducativo=$obj->idPrograma;
		$tipo=$obj->tipo;
		$comp="";
		switch($tipo)
		{
			case 8:
				$comp="AND idInstanciaPlanEstudio=".$obj->idInstancia;
			break;
			case 12:
				$comp="AND idProgramaEducativo=".$idProgramaEducativo;
				$obj->idInstancia="NULL";
			break;
			case 16:
				$comp="";
				$idProgramaEducativo="NULL";
				$obj->idInstancia="NULL";
				
				
			break;
		}
		
		foreach($obj->arrCostos as $o)
		{
			$consulta[$x]="delete from 6011_costoConcepto where plantel='".$obj->plantel."' and idCiclo=".$obj->idCiclo." and idPeriodo=".$obj->idPeriodo." and idConcepto=".$o->idConcepto." ".$comp;
			$x++;
		}
		foreach($obj->arrCostos as $o)
		{
			
			
			$consulta[$x]="INSERT INTO 6011_costoConcepto(idConcepto,valor,plantel,idInstanciaPlanEstudio,idCiclo,idPeriodo,idProgramaEducativo)
					VALUES(".$o->idConcepto.",'".$o->costo."','".$obj->plantel."',".$obj->idInstancia.",".$obj->idCiclo.",".$obj->idPeriodo.",".$idProgramaEducativo.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function registrarCostosPlanEstudioGrado()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$query="select idCostoConcepto from 6011_costoConcepto where plantel='".$obj->plantel."' and idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio." and idCiclo=".$obj->idCiclo." 
			and idPeriodo=".$obj->idPeriodo." and idConcepto=".$obj->idConcepto." and tipoConcepto=".$obj->tipoConcepto." and idElemento=".$obj->idElemento." and tipoElemento=".$obj->tipoElemento;
		$idRegistro=$con->obtenerValor($query);
		
		if($idRegistro=="")
		{
			$idProgramaEducativo=obtenerIdProgramaEducativoInstancia($obj->idInstanciaPlanEstudio);
			$grado="NULL";
			if($obj->idElemento==1)
				$grado=$obj->idElemento;
			$query="INSERT INTO 6011_costoConcepto(idConcepto,valor,plantel,idInstanciaPlanEstudio,idCiclo,idPeriodo,tipoConcepto,idElemento,tipoElemento,grado,idProgramaEducativo)
					VALUES(".$obj->idConcepto.",'".$obj->costo."','".$obj->plantel."',".$obj->idInstanciaPlanEstudio.",".$obj->idCiclo.",".$obj->idPeriodo.",".$obj->tipoConcepto.",".$obj->idElemento.",".$obj->tipoElemento.",".$grado.",".$idProgramaEducativo.")";
		}
		else
			$query="update 6011_costoConcepto set valor='".$obj->costo."' where idCostoConcepto=".$idRegistro;
		
		if($con->ejecutarConsulta($query))
		{
			$consulta="SELECT funcionEjecucionGuardar FROM 6013_columnasInterfaceCosto WHERE tipoConcepto=".$obj->tipoConcepto." AND idConcepto=".$obj->idConcepto;
			$cadFuncion=$con->obtenerValor($consulta);
			if($cadFuncion!="")
			{
				$objFuncion=json_decode($cadFuncion);
				if($objFuncion!=NULL)
				{
					$objParametro='{"valor":"'.$obj->costo.'","plantel":"'.$obj->plantel.'","idCiclo":"'.$obj->idCiclo.'","idPeriodo":"'.$obj->idPeriodo.'","idConcepto":"'.$obj->idConcepto.
								'","tipoConcepto":"'.$obj->tipoConcepto.'","idElemento":"'.$obj->idElemento.'","tipoElemento":"'.$obj->tipoElemento.'","idInstanciaPlanEstudio":"'.$obj->idInstanciaPlanEstudio.'"}';
					$oParametro=json_decode($objParametro);
					if($objFuncion->tipoFuncion==1)
					{
						eval($objFuncion->funcion.'($oParametro);');
					}
					else
					{
						$cadObj='{"param1":""}';
						$obj=json_decode($cadObj);
						$obj->param1=$oParametro;
						$cache=NULL;
						resolverExpresionCalculoPHP($objFuncion->funcion,$obj,$cache);	
					}
				}	
			}
			
			echo "1|";
		}
	}
	
	function registrarArregloCostosPlanEstudioGrado()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$arrFuncionesEjecutar=array();
		$query[$x]="begin";
		$x++;
		foreach($obj->arrValores as $o)
		{
			
			if(!isset($arrFuncionesEjecutar[$o->tipoConcepto."_".$o->idConcepto]))
			{
				$consulta="SELECT funcionEjecucionGuardar FROM 6013_columnasInterfaceCosto WHERE tipoConcepto=".$o->tipoConcepto." AND idConcepto=".$o->idConcepto;
				$cadFuncion=$con->obtenerValor($consulta);
				if($cadFuncion!="")
					$arrFuncionesEjecutar[$o->tipoConcepto."_".$o->idConcepto]=json_decode($cadFuncion);
				else
					$arrFuncionesEjecutar[$o->tipoConcepto."_".$o->idConcepto]=NULL;
			}
			
			$consulta="select idCostoConcepto from 6011_costoConcepto where plantel='".$obj->plantel."' and idInstanciaPlanEstudio=".$o->idInstanciaPlanEstudio." and idCiclo=".$obj->idCiclo." 
				and idPeriodo=".$obj->idPeriodo." and idConcepto=".$o->idConcepto." and tipoConcepto=".$o->tipoConcepto." and idElemento=".$o->idElemento." and tipoElemento=".$o->tipoElemento;
			$idRegistro=$con->obtenerValor($consulta);
			
			if($idRegistro=="")
			{
				$idProgramaEducativo=obtenerIdProgramaEducativoInstancia($o->idInstanciaPlanEstudio);
				$grado="NULL";
				if($o->idElemento==1)
					$grado=$o->idElemento;
				$query[$x]="INSERT INTO 6011_costoConcepto(idConcepto,valor,plantel,idInstanciaPlanEstudio,idCiclo,idPeriodo,tipoConcepto,idElemento,tipoElemento,grado,idProgramaEducativo)
						VALUES(".$o->idConcepto.",'".$o->valor."','".$obj->plantel."',".$o->idInstanciaPlanEstudio.",".$obj->idCiclo.",".$obj->idPeriodo.",".$o->tipoConcepto.",".$o->idElemento.",".$o->tipoElemento.",".$grado.",".$idProgramaEducativo.")";
			}
			else
				$query[$x]="update 6011_costoConcepto set valor='".$o->valor."' where idCostoConcepto=".$idRegistro;
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			foreach($obj->arrValores as $o)
			{
				$objFuncion=$arrFuncionesEjecutar[$o->tipoConcepto."_".$o->idConcepto];
				if($objFuncion!=NULL)
				{
					$objParametro='{"valor":"'.$o->valor.'","plantel":"'.$obj->plantel.'","idCiclo":"'.$obj->idCiclo.'","idPeriodo":"'.$obj->idPeriodo.'","idConcepto":"'.$o->idConcepto.
								'","tipoConcepto":"'.$o->tipoConcepto.'","idElemento":"'.$o->idElemento.'","tipoElemento":"'.$o->tipoElemento.'","idInstanciaPlanEstudio":"'.$o->idInstanciaPlanEstudio.'"}';
					$oParametro=json_decode($objParametro);
					if($objFuncion->tipoFuncion==1)
					{
						eval($objFuncion->funcion.'($oParametro);');
					}
					else
					{
						$cadObj='{"param1":""}';
						$obj=json_decode($cadObj);
						$obj->param1=$oParametro;
						$cache=NULL;
						resolverExpresionCalculoPHP($objFuncion->funcion,$obj,$cache);	
					}
				}
			}
			echo "1|";
		}
	}
	
	function obtenerTabuladorPlanPagoConcepto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$comp="";
		if($obj->idElemento=="")
			$obj->idElemento=-1;
		if($obj->idInstanciaPlanEstudio=="")
			$obj->idInstanciaPlanEstudio=-1;
		if($obj->tipoConcepto==1)
		{
			$consulta="SELECT idPlanPago FROM 564_conceptosVSPlanPago WHERE idConcepto=".$obj->idConcepto;
			$listPlanPago=$con->obtenerListaValores($consulta);
			if($listPlanPago=="")
				$listPlanPago=-1;
			$comp=" and idPlanPago in (".$listPlanPago.")";
		}
		$consulta="select idCostoConcepto from 6011_costoConcepto where plantel='".$obj->plantel."' and idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio." and idCiclo=".$obj->idCiclo." 
				and idPeriodo=".$obj->idPeriodo." and idConcepto=".$obj->idConcepto." and tipoConcepto=".$obj->tipoConcepto." and idElemento=".$obj->idElemento." and tipoElemento=".$obj->tipoElemento;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$idRegistro=-1;
		$consulta="
					SELECT * FROM (
					SELECT noPago,idPlanPago,(SELECT tituloPlanPagos FROM _673_tablaDinamica WHERE id__673_tablaDinamica=t.idPlanPago) AS nombrePlanPago,
					(SELECT etiquetaPago FROM _673_gridPagosPlan WHERE idReferencia=t.idPlanPago AND noPago=t.noPago) AS etiquetaPago,pagoIndividual,montoDescuento1,pagoDescuento1,montoDescuento2,pagoDescuento2,
					(SELECT fechaMaximaPago FROM 6016_fechaPagoConDescuento WHERE idCostoConcepto=t.idCostoConcepto AND idPlanPago=t.idPlanPago AND noPago=t.noPago) AS fechaMaximaDescuento
					FROM 6015_tabuladorPlanPagosConcepto t WHERE idCostoConcepto=".$idRegistro." ".$comp.") AS tmp ORDER BY nombrePlanPago,noPago";
		$arrObj=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObj).'}';
	}
	
	function obtenerTabuladorFechasPlanPago()
	{
		global $con;
		
		
		$consulta="SELECT noPago,t.id__673_tablaDinamica AS idPlanPago,tituloPlanPagos AS nombrePlanPago,etiquetaPago,'' AS fechaMaximaDescuento 
					FROM _673_gridPagosPlan g,_673_tablaDinamica t WHERE g.idReferencia=t.id__673_tablaDinamica ORDER BY tituloPlanPagos,noPago";
		$arrObj=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObj).'}';
		
		
	}
	
	function registrarFechasTabuladorPago()
	{
		global $con;
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		foreach($obj->arrElementos as $e)
		{
			$consulta="select idCostoConcepto from 6011_costoConcepto where plantel='".$obj->plantel."' and idInstanciaPlanEstudio=".$e->idInstanciaPlanEstudio." and idCiclo=".$obj->idCiclo." 
					and idPeriodo=".$obj->idPeriodo." and idConcepto=".$e->idConcepto." and tipoConcepto=".$e->tipoConcepto." and idElemento=".$e->idElemento." and tipoElemento=".$e->tipoElemento;
			$idRegistro=$con->obtenerValor($consulta);
			if($idRegistro=="")
			{
				$consulta="INSERT INTO 6011_costoConcepto(idConcepto,valor,plantel,idInstanciaPlanEstudio,idCiclo,idPeriodo,tipoConcepto,idElemento,tipoElemento)
						VALUES(".$e->idConcepto.",'0','".$obj->plantel."',".$e->idInstanciaPlanEstudio.",".$obj->idCiclo.",".$obj->idPeriodo.",".$e->tipoConcepto.",".$e->idElemento.",".$e->tipoElemento.")";
				if($con->ejecutarConsulta($consulta))
					$idRegistro=$con->obtenerUltimoID();
				else
					return;
			}
			if(sizeof($obj->arrFechas)>0)
			{
				foreach($obj->arrFechas as $f)
				{
					$consulta="SELECT idFechaProntoPago FROM 6016_fechaPagoConDescuento WHERE idCostoConcepto=".$idRegistro." AND idPlanPago=".$f->idPlanPago." AND noPago=".$f->noPago;
					$idFecha=$con->obtenerValor($consulta);
					if($idFecha=="")
					{
						$query[$x]="INSERT INTO 6016_fechaPagoConDescuento(idCostoConcepto,idPlanPago,noPago,fechaMaximaPago) VALUES(".$idRegistro.",".$f->idPlanPago.",".$f->noPago.",'".$f->fecha."')";
					}
					else
					{
						$query[$x]="update 6016_fechaPagoConDescuento set fechaMaximaPago='".$f->fecha."' where idFechaProntoPago=".$idFecha;
					}
					$x++;
	
				}
			}
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function obtenerTabuladorPlanPagoConceptoInscripcionAlumno()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$comp="";
		if($obj->idElemento=="")
			$obj->idElemento=-1;
		if($obj->idInstanciaPlanEstudio=="")
			$obj->idInstanciaPlanEstudio=-1;
		if($obj->tipoConcepto==1)
		{
			$consulta="SELECT idPlanPago FROM 564_conceptosVSPlanPago WHERE idConcepto=".$obj->idConcepto;
			$listPlanPago=$con->obtenerListaValores($consulta);
			if($listPlanPago=="")
				$listPlanPago=-1;
			$comp=" and idPlanPago in (".$listPlanPago.")";
		}
		$consulta="select idCostoConcepto from 6011_costoConcepto where plantel='".$obj->plantel."' and idInstanciaPlanEstudio=".$obj->idInstanciaPlanEstudio." and idCiclo=".$obj->idCiclo." 
				and idPeriodo=".$obj->idPeriodo." and idConcepto=".$obj->idConcepto." and tipoConcepto=".$obj->tipoConcepto."  and tipoElemento=".$obj->tipoElemento; ///and idElemento=".$obj->idElemento."

		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$idRegistro=-1;
		$consulta="
					SELECT * FROM (
					SELECT noPago,idPlanPago,(SELECT tituloPlanPagos FROM _673_tablaDinamica WHERE id__673_tablaDinamica=t.idPlanPago) AS nombrePlanPago,
					(SELECT etiquetaPago FROM _673_gridPagosPlan WHERE idReferencia=t.idPlanPago AND noPago=t.noPago) AS etiquetaPago,pagoIndividual,montoDescuento1,pagoDescuento1,montoDescuento2,pagoDescuento2,
					(SELECT fechaMaximaPago FROM 6016_fechaPagoConDescuento WHERE idCostoConcepto=t.idCostoConcepto AND idPlanPago=t.idPlanPago AND noPago=t.noPago) AS fechaMaximaDescuento
					FROM 6015_tabuladorPlanPagosConcepto t WHERE idCostoConcepto=".$idRegistro." ".$comp.") AS tmp ORDER BY nombrePlanPago,noPago";
		$arrObj=$con->obtenerFilasJSON($consulta);
		//$resPagos=$con->obtenerFilas($consulta);
		$nRegistros=$con->filasAfectadas;
		/*$arrObj="";
		while($fila=mysql_fetch_row($resPagos))
		{
			$obj='';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}*/
		//echo '{"numReg":"'.$nRegistros.'","registros":['.$arrObj.']}';
		echo '{"numReg":"'.$nRegistros.'","registros":'.utf8_encode($arrObj).'}';
	}
	
	function obtenerMontosTabuladorPlanPago()
	{
		global $con;
		$arrPagos="";
		$arrParametros=array();
		$complementario="";
		$s=$_POST["idConceptoBase"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$aServicios=explode("_",$s);
		$plantel=$aServicios[0];
		$idProgramaEducativo=$aServicios[1];
		$idPlanEstudio=$aServicios[2];
		$idGrado=$aServicios[3];
		$idConcepto=$aServicios[4];		
		$listaServicios=$_POST["listaServicios"];
		$costoServicio=$_POST["costoServicio"];
		$arrConceptoBase=explode("_",$s);
		$idInstancia=$arrConceptoBase[2];
		
		$consulta="SELECT * FROM 564_conceptosVSOperacionesCargosDescuentos WHERE idConcepto =".$idConcepto." ORDER BY ordenAplicacion";

		$res=$con->obtenerFilas($consulta);
		$arrColumnas=array();
		while($fila=mysql_fetch_row($res))
		{
			if($fila[7]==1)
			{
				$oConf[0]=1;
				$oConf[1]=$fila[0];
				array_push($arrColumnas,$oConf);
				
				
			}
			$consulta="SELECT idColumna FROM 565_configuracionColumnaOperacion WHERE idOperacion=".$fila[0]." ORDER BY idColumna";
			$resCol=$con->obtenerFilas($consulta);
			while($fCol=mysql_fetch_row($resCol))
			{
				$oConf[0]=2;
				$oConf[1]=$fCol[0];
				array_push($arrColumnas,$oConf);
			}
		}
		
		$consulta="SELECT DISTINCT idPlanPago FROM 6023_planesPagosConceptoPlanteles WHERE idConcepto=".$idConcepto." AND plantel='".$arrConceptoBase[0]."' and aplicaPlantel=1";
		$listaPlanPagos=$con->obtenerListaValores($consulta);
		
		if($listaPlanPagos=="")
			$listaPlanPagos=-1;
		
		/*$filaConf=obtenerConfiguracionPlanEstudio(986,"",$idInstancia);
		
		
		
		if($filaConf)
		{
			$consulta="SELECT DISTINCT idPlanPago FROM _986_gridPlanesPago WHERE idReferencia=".$filaConf[0];
			$listaPlanPagos2=$con->obtenerListaValores($consulta);	
			if($listaPlanPagos2!="")
			{
				$listaPlanPagos=$listaPlanPagos2;
			}
		}*/

		$arrParametros["idInstanciaPlanEstudio"]=$idInstancia;
		$arrParametros["idServicio"]=$idConcepto;
		$arrParametros["idCiclo"]=$idCiclo;
		$arrParametros["idPeriodo"]=$idPeriodo;
		$arrParametros["plantel"]=$plantel;
		$arrParametros["idProgramaEducativo"]=$idProgramaEducativo;
		$arrParametros["grado"]=$idGrado;

		
		$consulta="SELECT idCostoConcepto FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$idProgramaEducativo." AND 
					idInstanciaPlanEstudio=".$idPlanEstudio." and grado=".$idGrado." and idConcepto=".$idConcepto." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
		$idCostoConcepto=$con->obtenerValor($consulta);
		if($idCostoConcepto=="")
			$idCostoConcepto=-1;
		
		$consulta="SELECT DISTINCT idPlanPago FROM 561_conceptosIngreso i,564_conceptosVSPlanPago c  WHERE i.idConcepto =".$idConcepto." 
					AND c.idConcepto=i.idConcepto and idPlanPago in (".$listaPlanPagos.")";

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT nombrePlanPago FROM 6020_planesPago WHERE idPlanPagos=".$fila[0];
			$nombrePlanPago=$con->obtenerValor($consulta);
			
			$resObj=calcularPlanPagosMonto($costoServicio,$fila[0],$arrParametros,false,$idConcepto);


			foreach($resObj as $o)
			{
					
				$fechaVencimiento="";
				$consulta="SELECT valor FROM 6016_valoresReferenciaCosteoServicios WHERE idCostoConcepto =".$idCostoConcepto." AND idPlanPago=".$fila[0]." AND noPago=".$o["noPago"]." AND noColumna=0";
				$fechaVencimiento=$con->obtenerValor($consulta);
				$complementario="";
				if(sizeof($arrColumnas)>0)
				{
					foreach($arrColumnas as $c)
					{
						if($c[0]==2)
						{
							$consulta="SELECT valor FROM 6016_valoresReferenciaCosteoServicios WHERE idCostoConcepto =".$idCostoConcepto." AND idPlanPago=".$fila[0]." AND noPago=".$o["noPago"]." AND noColumna=".$c[1];
							$valor=$con->obtenerValor($consulta);
							$complementario.=",'".$valor."'";
						}
						else
						{
							$vColumna=0;
							foreach($o["arrDescuestosCargos"] as $col)
							{
								if($col["idConcepto"]==$c[1])
								{
									$vColumna=$col["opMonto"];
								}
							}
							$complementario.=",'".$vColumna."'";
						}
					}
				}
				$obj="['".$o["noPago"]."','".$fila[0]."','".cv($nombrePlanPago)."','".cv($o["etiquetaPago"])."','".$o["pagoIndividual"]."','".$fechaVencimiento."'".$complementario."]";
				if($arrPagos=="")
					$arrPagos=$obj;
				else
					$arrPagos.=",".$obj;
			}
		}
		echo "1|[".$arrPagos."]";
	}
	
	function obtenerConfiguracionInterfaceCosteo()
	{
		global $con;
		$idConcepto=$_POST["idConcepto"];
		$aCampos="{name: 'noPago'},{name: 'idPlanPago'},{name: 'nombrePlanPago'},{name: 'etiquetaPago'},{name: 'pagoIndividual'},{name:'fechaVencimiento'}";
		$aColumnas="new Ext.grid.CheckboxSelectionModel(),{header:'No. Pago',width:65,align:'center',sortable:false,menuDisabled :true,css:'text-align:right !important;',dataIndex:'noPago'},".
                   "{header:'Plan de pagos',width:250,align:'left',sortable:false,menuDisabled :true,css:'text-align:left !important;',dataIndex:'nombrePlanPago'},".
                   "{header:'Pago',width:250,align:'left',sortable:false, menuDisabled :true,css:'text-align:left !important;',dataIndex:'etiquetaPago',summaryRenderer:formatearResumen},".
                   "{header:'Pago Neto',width:90,dataIndex:'pagoIndividual',align:'left',sortable:false, menuDisabled :true,css:'text-align:right !important;',renderer:'usMoney',summaryType:'sum'},".
					"{header:'Fecha de vencimiento <a href=\"javascript:mostrarVentanaAsignarFechaPlanV2(\\'".bE("fechaVencimiento")."\\')\"><img src=\"../images/pencil.png\" width=\"13\" height=\"13\"></a>',width:150,dataIndex:'fechaVencimiento',".
					" align:'center',sortable:false,hidden:(consideraFechaVencimiento==0),editor:{xtype:'datefield'},menuDisabled :true,css:'text-align:right !important;',renderer:formatearSoloFecha}";
		
		
		$consulta="SELECT * FROM 564_conceptosVSOperacionesCargosDescuentos WHERE idConcepto =".$idConcepto." ORDER BY ordenAplicacion";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			if($fila[7]==1)
			{
				$aCampos.=",{name:'op_".$fila[0]."'}";
				$aColumnas.=",{header:'<div style=\'word-wrap:break-word; white-space:normal\'>".cv($fila[3])."</div>',width:110,dataIndex:'op_".$fila[0]."',align:'center',sortable:false, menuDisabled :true,css:'text-align:right !important;',renderer:'usMoney',summaryType:'sum'}";
			}
			$consulta="SELECT idColumna,etiqueta,anchoColumna,tipoValor FROM 565_configuracionColumnaOperacion WHERE idOperacion=".$fila[0]." ORDER BY idColumna";
			$resCol=$con->obtenerFilas($consulta);
			while($fCol=mysql_fetch_row($resCol))
			{
				$editor="";
				$renderer="";
				switch($fCol[3])
				{
					case 1: //Decimal
					$editor="{xtype:'numberfield',allowDecimals:true,allowNegative:false}";
					$renderer="function(val){return val}";
					break;
					case 2:  //Entero
					$editor="{xtype:'numberfield',allowDecimals:false,allowNegative:false}";
					$renderer="function(val){return Ext.util.Format.number(val,'0,000')}";
					break;
					case 5:
					case 4:
					case 3: //Fecha
						$editor="{xtype:'datefield',minValue:'".date("Y-m-d")."'}";
						$renderer="formatearSoloFecha";
					break;
				}
				$aCampos.=",{name:'ref_".$fCol[0]."_".$fCol[3]."'}";
				$aColumnas.=",{header:'<div style=\'word-wrap:break-word; white-space:normal\'>".cv($fCol[1])." <a href=\"javascript:mostrarVentanaAsignarFechaPlanV2(\\'".bE("ref_".$fCol[0]."_".$fCol[3])."\\')\">".
							"<img src=\"../images/pencil.png\" width=\"13\" height=\"13\"></a></div>',width:".$fCol[2].",dataIndex:'ref_".$fCol[0]."_".$fCol[3]."',align:'center',sortable:false, menuDisabled :true,css:'text-align:right !important;',renderer:".$renderer.",editor:".$editor."}";
			}
		}
		
		echo '1|[{"arrCampos":['.$aCampos.'],"arrColumnas":['.$aColumnas.']}]';				   
	}
	
	function registrarCostoServicioPlan()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$idCiclo=$obj->idCiclo;
		$idPeriodo=$obj->idPeriodo;
		$arrServicios=explode(",",$obj->arrServicios);
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($arrServicios as $s)	
		{
			$aServicios=explode("_",$s);
			$plantel=$aServicios[0];
			$idProgramaEducativo=$aServicios[1];
			$idPlanEstudio=$aServicios[2];
			$idGrado=$aServicios[3];
			$idServicio=$aServicios[4];
			
			$consulta="SELECT idCostoConcepto FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$idProgramaEducativo." AND 
					idInstanciaPlanEstudio=".$idPlanEstudio." and grado=".$idGrado." and idConcepto=".$idServicio." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
			$idCostoConcepto=$con->obtenerValor($consulta);
			if($idCostoConcepto=="")
			{
				$query[$x]="INSERT INTO 6011_costoConcepto(idConcepto,valor,plantel,idInstanciaPlanEstudio,idCiclo,idPeriodo,grado,idProgramaEducativo,fechaVencimiento,idPerfilCosteo)
							VALUES(".$idServicio.",'".$obj->costoServicio."','".$plantel."',".$idPlanEstudio.",".$idCiclo.",".$idPeriodo.",".$idGrado.",".$idProgramaEducativo.",NULL,".$obj->idPerfilCosteo.")";
				$x++;
				$query[$x]="set @idRegistro:=(select last_insert_id())";
				$x++;
			}
			else
			{
				$query[$x]="update 6011_costoConcepto set valor='".$obj->costoServicio."',fechaVencimiento=NULL where  idCostoConcepto=".$idCostoConcepto;
							
				$x++;
				$query[$x]="set @idRegistro:=".$idCostoConcepto."";
				$x++;
			}
			
			$query[$x]="delete from 6016_valoresReferenciaCosteoServicios  where  idCostoConcepto=@idRegistro";
			$x++;
			foreach($obj->arrPagos as $p)
			{
				if($p->fechaVencimiento!="")
				{
					$query[$x]="INSERT INTO 6016_valoresReferenciaCosteoServicios(idCostoConcepto,idPlanPago,noPago,noColumna,valor)
								VALUES(@idRegistro,".$p->idPlanPago.",".$p->noPago.",0,'".$p->fechaVencimiento."')";
					$x++;
				}
				if(sizeof($p->arrReferencias)>0)
				{
					foreach($p->arrReferencias as $r)
					{
						$query[$x]="INSERT INTO 6016_valoresReferenciaCosteoServicios(idCostoConcepto,idPlanPago,noPago,noColumna,valor)
										VALUES(@idRegistro,".$p->idPlanPago.",".$p->noPago.",".$r->idColumna.",'".$r->valor."')";
						$x++;
					}
				}
			}
		
		}
		
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function obtenerCostoServicios()
	{
		global $con;
		$idNodo=$_POST["idNodo"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$aServicios=explode("_",$idNodo);
		$plantel=$aServicios[0];
		$idProgramaEducativo=$aServicios[1];
		$idPlanEstudio=$aServicios[2];
		$idGrado=$aServicios[3];
		$idServicio=$aServicios[4];
		
		$consulta="SELECT valor,fechaVencimiento FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$idProgramaEducativo." AND 
				idInstanciaPlanEstudio=".$idPlanEstudio." and grado=".$idGrado." and idConcepto=".$idServicio." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
		
		$fDatos=$con->obtenerPrimeraFila($consulta);
		if($fDatos)
			echo "1|".$fDatos[0]."|".$fDatos[1];
		else
			echo "1|0|";
	}
	
	function guardarCostoServiciosEstandarDescuento()
	{
		global $con;
		$x=0;
		$query[$x]="begin";
		$x++;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		$idCiclo=$obj->idCiclo;
		$idPeriodo=$obj->idPeriodo;
		$arrServicios=explode(",",$obj->arrServicios);
		$fechaVencimiento="NULL";
		if($obj->fechaVencimiento!="")
			$fechaVencimiento="'".$obj->fechaVencimiento."'";
		foreach($arrServicios as $s)	
		{
			$aServicios=explode("_",$s);
			$plantel=$aServicios[0];
			$idProgramaEducativo=$aServicios[1];
			$idPlanEstudio=$aServicios[2];
			$idGrado=$aServicios[3];
			$idServicio=$aServicios[4];
			
			$consulta="SELECT idCostoConcepto FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$idProgramaEducativo." AND 
					idInstanciaPlanEstudio=".$idPlanEstudio." and grado=".$idGrado." and idConcepto=".$idServicio." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
			$idCostoConcepto=$con->obtenerValor($consulta);
			if($idCostoConcepto=="")
			{
				$query[$x]="INSERT INTO 6011_costoConcepto(idConcepto,valor,plantel,idInstanciaPlanEstudio,idCiclo,idPeriodo,grado,idProgramaEducativo,fechaVencimiento,idPerfilCosteo)
							VALUES(".$idServicio.",'".$obj->costoServicio."','".$plantel."',".$idPlanEstudio.",".$idCiclo.",".$idPeriodo.",".$idGrado.",".$idProgramaEducativo.",".$fechaVencimiento.",".$obj->idPerfilCosteo.")";
				$x++;
				$query[$x]="set @idCostoConcepto:=(select last_insert_id())";
				$x++;
			}
			else
			{
				$query[$x]="update 6011_costoConcepto set valor='".$obj->costoServicio."',fechaVencimiento=".$fechaVencimiento." where  idCostoConcepto=".$idCostoConcepto;
							
				$x++;
				$query[$x]="set @idCostoConcepto:=".$idCostoConcepto;
				$x++;
			}
			$query[$x]="delete from 6016_valoresReferenciaComplementariosCosteoServicios where idCostoConcepto=@idCostoConcepto";
			$x++;
			
			foreach($obj->arrDescuentos as $d)
			{
				$query[$x]="INSERT INTO 6016_valoresReferenciaComplementariosCosteoServicios(idCostoConcepto,valorReferencia1,valorReferencia2,valorReferencia3,valorReferencia4)
							VALUES(@idCostoConcepto,'".$d->valorDescuento."','".$d->tipoDescuento."','".$d->fechaLimite."','".$d->costoServicio."')";
				$x++;
			}
			
		
		}
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function obtenerValoresCostoServiciosEstandarDescuento()
	{
		global $con;
		$idNodo=$_POST["idNodo"];
		$idCiclo=$_POST["idCiclo"];
		$idPeriodo=$_POST["idPeriodo"];
		$aServicios=explode("_",$idNodo);
		$plantel=$aServicios[0];
		$idProgramaEducativo=$aServicios[1];
		$idPlanEstudio=$aServicios[2];
		$idGrado=$aServicios[3];
		$idServicio=$aServicios[4];
		$consulta="SELECT idCostoConcepto from 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$idProgramaEducativo." AND 
				idInstanciaPlanEstudio=".$idPlanEstudio." and grado=".$idGrado." and idConcepto=".$idServicio." AND idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo;
		$idCostoConcepto=$con->obtenerValor($consulta);
		if($idCostoConcepto=="")
			$idCostoConcepto=-1;
		$consulta="SELECT valorReferencia1 as valorDescuento,valorReferencia2 as tipoDescuento,valorReferencia3 as fechaLimiteAplicacion,valorReferencia4 as costoServicio 
					FROM 6016_valoresReferenciaComplementariosCosteoServicios WHERE idCostoConcepto=".$idCostoConcepto;
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';
		
	}
	
	function obtenerConfiguracionAvanzadaPlanPagos()
	{
		global $con;
		$idPlanPagos=$_POST["idPlanPagos"];	
		$idConcepto=$_POST["idConcepto"];
		
		$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=1 AND status=1 ORDER BY unidad";
		$res=$con->obtenerFilas($consulta);
		$numReg=0;
		$registros="";
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT aplicaPlantel,valorReferencia,tipoValorReferencia FROM 6023_planesPagosConceptoPlanteles WHERE idPlanPago=".$idPlanPagos." and idConcepto=".$idConcepto." AND plantel='".$fila[0]."'";
			$fPlantel=$con->obtenerPrimeraFila($consulta);
			if(!$fPlantel)
			{
				$fPlantel[0]="";
				$fPlantel[1]="";
				$fPlantel[2]="";
				
			}
			
			if($fPlantel[0]==1)
				$fPlantel[0]="true";
			else
				$fPlantel[0]="false";
			
			
			
			
			$o='{"plantel":"'.$fila[0].'","nombrePlantel":"'.cv($fila[1]).'","aplicaPlantel":'.$fPlantel[0].',"valorReferencia":"'.$fPlantel[1].'","tipoValorReferencia":"'.$fPlantel[2].'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;	
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$registros.']}';
	}
	
	function guardarConfiguracionAvanzadaPlanPagos()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from 6023_planesPagosConceptoPlanteles where idPlanPago=".$obj->idPlanPagos." and idConcepto=".$obj->idConcepto;
		$x++;
		foreach($obj->planteles as $p)
		{
			if($p->valorReferencia=="")
				$p->valorReferencia="NULL";
			if($p->tipoValorReferencia=="")
				$p->tipoValorReferencia="NULL";
			$query[$x]="INSERT INTO 6023_planesPagosConceptoPlanteles(idPlanPago,idConcepto,plantel,aplicaPlantel,valorReferencia,tipoValorReferencia)
					VALUES(".$obj->idPlanPagos.",".$obj->idConcepto.",'".$p->plantel."',".$p->aplicaPlantel.",".$p->valorReferencia.",".$p->tipoValorReferencia.")";

			$x++;
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
		
	function obtenerZonasCategoria()
	{
		global $con;	
		$idCategoria=$_POST["idCategoria"];
		$numReg=0;
		$registros="";
		$consulta="SELECT c.idZona FROM 6937_zonas z,6939_zonasCategoriaIVA c WHERE c.idCategoria=".$idCategoria." AND c.idZona=z.idZona order by zona";
		$res=$con->obtenerFilas($consulta);
		while($f=mysql_fetch_row($res))
		{
			$consulta="SELECT porcentajeIVA,fechaInicio FROM 6940_porcentajeIVACategoria WHERE idCategoria=".$idCategoria." AND idZona=".$f[0]." order by fechaInicio desc";
			$fPorcentaje=$con->obtenerPrimeraFila($consulta);
			
			$o='{"idZona":"'.$f[0].'","porcentaje":"'.$fPorcentaje[0].'","fechaInicio":"'.$fPorcentaje[1].'"}';
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;	
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$registros.']}';
	}
	
	function obtenerZonasCategoriaDisponible()
	{
		global $con;	
		$idCategoria=$_POST["idCategoria"];
		$consulta="SELECT idZona,zona FROM 6937_zonas WHERE idZona NOT IN (SELECT idZona FROM 6939_zonasCategoriaIVA WHERE idCategoria=".$idCategoria.") order by zona";
		
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';	
	}
	
	function registrarZonasCategoria()
	{
		global $con;	
		$idCategoria=$_POST["idCategoria"];
		$zonas=$_POST["zonas"];
		$arrZonas=explode(",",$zonas);
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($arrZonas as $z)
		{
			$query[$x]="INSERT INTO 6939_zonasCategoriaIVA(idCategoria,idZona) VALUES(".$idCategoria.",".$z.")";
			
			$x++;
		}
		$query[$x]="commit";
		$x++;
		
		eB($query);
		
	}
	
	function removerZonasCategoria()
	{
		global $con;	
		$idCategoria=$_POST["idCategoria"];
		$zonas=$_POST["zonas"];
		
		$query="delete from 6939_zonasCategoriaIVA where idCategoria=".$idCategoria." and idZona in (".$zonas.")";
		
		eC($query);
		
	}
	
	function registrarPorcentajeIVAZona()
	{
		global $con;	
		$idCategoria=$_POST["idCategoria"];
		$idZona=$_POST["idZona"];
		$porcentaje=$_POST["porcentaje"];
		$fechaInicio=$_POST["fechaInicio"];
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="DELETE FROM 6940_porcentajeIVACategoria WHERE idCategoria=".$idCategoria." AND idZona=".$idZona." AND fechaInicio>='".$fechaInicio."'";
		$x++;
		$query[$x]="INSERT INTO 6940_porcentajeIVACategoria(idCategoria,idZona,fechaInicio,porcentajeIVA) VALUES(".$idCategoria.",".$idZona.",'".$fechaInicio."',".$porcentaje.")";
		$x++;
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function obtenerHistorialPorcentajeIVA()
	{
		global $con;	
		$idCategoria=$_POST["idCategoria"];
		$idZona=$_POST["idZona"];
		$consulta="SELECT idPorcentaje,porcentajeIVA as porcentaje,fechaInicio FROM 6940_porcentajeIVACategoria WHERE idCategoria=".$idCategoria." AND idZona=".$idZona." order by fechaInicio desc";
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';	
	}
	
	function obtenerAdeudosClientes()
	{
		global $con;	
		$tipoCliente=$_POST["tipoCliente"];
		$idCliente=$_POST["idCliente"];
		$numReg=0;
		$registros="";
		$consulta="SELECT idAdeudo,tipoAdeudo,idReferencia,fechaCreacion,total,fechaVencimiento FROM 6942_adeudos WHERE tipoCliente=".$tipoCliente." AND idCliente=".$idCliente." AND situacion=1 order by fechaCreacion desc";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT p.formaPago,folioVenta FROM 6008_ventasCaja v,600_formasPago p WHERE idVenta=".$fila[2]." AND p.idFormaPago=v.formaPago";
			$fVenta=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT SUM(montoAbono) FROM 6936_controlPagos WHERE idAdeudo=".$fila[0];
			
			$montoAbono=$con->obtenerValor($consulta);
			$saldo=$fila[4]-$montoAbono;
			$o='{"idAdeudo":"'.$fila[0].'","tipoAdeudo":"'.cv($fVenta[0]).'","folioAdeudo":"'.$fVenta[1].'","fechaAdeudo":"'.$fila[3].'","montoAdeudo":"'.$fila[4].'","montoAbonado":"'.$montoAbono.'","saldo":"'.$saldo.'","descripcion":"","fechaVencimiento":"'.$fila[5].'"}';
			
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$registros.']}';	
	}
	
	function registrarAbonoAdeudo()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$idCaja=$_POST["idCaja"];
		
		$obj=json_decode($cadObj);
		$query="SELECT iva,total FROM 6008_ventasCaja WHERE idVenta=".$obj->idVenta;
		$fVenta=$con->obtenerPrimeraFila($query);
		
		$porcIva=$fVenta[0]/$fVenta[1];
		
		$query="select sum(montoAbono) from 6936_controlPagos where idAdeudo=".$obj->idAdeudo;
		$montoAbonado=$con->obtenerValor($query);	
		
		$saldo=$fVenta[1]-$montoAbonado;

		$o=json_decode($obj->datosCompra);
		$saldoVirtual=$saldo-$o->cantidadAbono;
		
		$subtotal=0;
		$iva=0;
		if($saldoVirtual<=0)
		{
			$query="select sum(iva) from 6936_controlPagos where idAdeudo=".$obj->idAdeudo;
			$totalIVA=$con->obtenerValor($query);
			$diferenciaIVA=$fVenta[0]-$totalIVA;
			$iva=$diferenciaIVA;
			$subtotal=$montoAbonado-$iva;
		}
		else
		{

			$iva=str_replace(",","",number_format($o->cantidadAbono*$porcIva,2));	

			$subtotal=$o->cantidadAbono-$iva;
		}
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$folioAbono=generarNombreArchivoTemporal(1,"");
		$consulta[$x]="INSERT INTO 6936_controlPagos(montoAbono,fechaAbono,idAdeudo,formaPago,datosComp,horaAbono,idResponsableCobro,idCaja,subtotal,iva,folioAbono)
					VALUES(".$o->cantidadAbono.",'".date("Y-m-d")."',".$obj->idAdeudo.",".$obj->formaPago.",'".cv($obj->datosCompra)."','".date("H:i:s")."','".$_SESSION["idUsr"]."',".$idCaja.",".$subtotal.",".$iva.",'".$folioAbono."')";
		
		$x++;
		if($saldoVirtual<=0)
		{
			$consulta[$x]="UPDATE 6942_adeudos SET situacion=2 WHERE idAdeudo=".$obj->idAdeudo;
			$x++;
		}
		
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idRegistro";
			$idAbono=$con->obtenerValor($query);	
			echo "1|".$idAbono;
		}

	}
	
	function registrarCancelacionVentaPedido()
	{
		global $con;
		$tipoOperacion=$_POST["tipoOperacion"];
		$idReferencia=$_POST["idReferencia"];
		$motivo=$_POST["motivo"];
		$idCaja=$_POST["idCaja"];
		
		$x=0;

		$query[$x]="begin";
		$x++;		
		
		switch($tipoOperacion)
		{
			case 1://Venta
			
				$query[$x]="UPDATE 6008_ventasCaja SET situacion=3 WHERE idVenta=".$idReferencia;	
				$x++;
				
				$consulta="SELECT idAdeudo FROM 6942_adeudos where tipoAdeudo=1 AND idReferencia=".$idReferencia;
				$idAdeudo=$con->obtenerValor($consulta);
				if($idAdeudo!="")
				{
					$consulta="SELECT SUM(montoAbono) FROM 6936_controlPagos WHERE idAdeudo=".$idAdeudo;
					$montoAbono=$con->obtenerValor($consulta);	
					$query[$x]="UPDATE 6942_adeudos SET situacion=3 WHERE idAdeudo=".$idAdeudo;
					$x++;
					
					$consulta="SELECT tipoCliente,idCliente FROM 6008_ventasCaja WHERE idVenta=".$idReferencia;
					$fVenta=$con->obtenerPrimeraFila($consulta);
					
					$query[$x]="INSERT INTO 6944_registroMovimientosCaja(tipoMovimiento,idReferencia,comentarios,idResponsableMovimiento,fechaMovimiento,idCaja)
								values(1,".$idReferencia.",'".cv($motivo)."',".$_SESSION["idUsr"].",'".date("Y-m-d H:i:s")."',".$idCaja.")";
					$x++;
					$query[$x]="set @idMovimientoCaja:=(select last_insert_id())";
					$x++;
					
					$query[$x]="INSERT INTO 6943_saldosCliente(tipoCliente,idCliente,tipoMovimiento,tipoOperacion,idReferencia,fechaOperacion,idResponsableOperacion,idMovimientoCaja)
								values(".$fVenta[0].",".$fVenta[1].",1,1,".$idReferencia.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",@idMovimientoCaja)";
					$x++;
					
				}
				
				
				
			break;
			case 2://Pedido
				$query[$x]="UPDATE 6934_pedidosTienda SET situacion=3 WHERE idPedidoTienda=".$idReferencia;	
				$x++;
				$query[$x]="INSERT INTO 6944_registroMovimientosCaja(tipoMovimiento,idReferencia,comentarios,idResponsableMovimiento,fechaMovimiento,idCaja)
							values(2,".$idReferencia.",'".cv($motivo)."',".$_SESSION["idUsr"].",'".date("Y-m-d H:i:s")."',".$idCaja.")";
				$x++;
				$query[$x]="set @idMovimientoCaja:=(select last_insert_id())";
				$x++;
			
			break;	
		}
		$query[$x]="commit";
		$x++;	
		eB($query);
			
	}
	
	function obtenerNotasCreditoVigentes()
	{
		global $con;
		$tBusqueda=$_POST["tBusqueda"];
		$tipoCliente=$_POST["tipoCliente"];
		$criterio=$_POST["criterio"];//1 folio;2 Cliente
		$condAux="";
		switch($tBusqueda)
		{
			case 1:
				$condAux=" WHERE folioNota='".$criterio."'  AND situacion=1";
			break;
			case 2:
				$condAux=" WHERE tipoCliente=".$tipoCliente." AND idCliente=".$criterio." AND situacion=1";
			break;	
		}
		
		$numReg=0;
		$registros="";
		$consulta="SELECT idNota,fechaCreacion,folioNota,total,tipoCliente,idCliente FROM 6947_notasCredito ".$condAux;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$cliente="Público General";
			if($fila[4]!=1)
				$cliente=obtenerNombreCliente($fila[4],$fila[5]);
			$o='{"idNotaCredito":"'.$fila[0].'","fechaCreacion":"'.cv($fila[1]).'","folioNota":"'.$fila[2].'","montoNota":"'.$fila[3].'","cliente":"'.cv($cliente).'"}';
			
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$registros.']}';	
	}
	
	function registrarDevolucionProducto()
	{
		global $con;	
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		if($obj->montoReintegro==0)
		{
			$obj->montoReintegro=-1;
		}
		
		$query[$x]="INSERT INTO 6949_devolucionesProducto(fechaDevolucion,horaDevolucion,idVenta,idCaja,responsableCaja,montoDevolucion,montoReintegro,formaDevolucion,comentariosAdicionales,idMotivoDevolucion)
					VALUES('".date("Y-m-d")."','".date("H:i:s")."',".$obj->idVenta.",".$obj->idCaja.",".$_SESSION["idUsr"].",".$obj->montoDevolucion.",".$obj->montoReintegro.",".$obj->formaDevolucion.",'".
					cv($obj->comentariosAdicionales)."',".$obj->idMotivoDevolucion.")";
		$x++;
		$query[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		
		if($obj->montoReintegro>0)
		{
			
			if($obj->formaDevolucion==2)
			{
				$consulta="SELECT tipoCliente,idCliente FROM 6008_ventasCaja WHERE idVenta=".$obj->idVenta;
				$fVenta=$con->ObtenerPrimeraFila($consulta);
				$query[$x]="INSERT INTO 6947_notasCredito(fechaCreacion,total,idTipoOrigenMovimiento,idOrigenMovimiento,situacion,tipoCliente,idCliente)
							VALUES('".date("Y-m-d")."','".$obj->montoReintegro."',3,@idRegistro,1,".$fVenta[0].",".$fVenta[1].")";
	
				$x++;
				$query[$x]="set @idNota:=(select last_insert_id())";
				$x++;
				$query[$x]="update 6947_notasCredito set folioNota=@idNota where idNota=@idNota";
				$x++;
			}
		}
		
		$tipoMovimiento=34;
		if($obj->idMotivoDevolucion==1)
			$tipoMovimiento=35;
		
		
		
		$objAsiento='{
						  "tipoMovimiento":"'.$tipoMovimiento.'",
						  "cantidadOperacion":"",
						  "idProducto":"",
						  "tipoReferencia":"3",
						  "datoReferencia1":"'.$obj->idVenta.'",
						  "datoReferencia2":"",
						  "complementario":"",
						  "dimensiones":null
					  }';
					  
		$arrDevoluciones=array();	
		$c=NULL;
		foreach($obj->arrProductos as $p)
		{
			$query[$x]="INSERT INTO 6950_productosDevolucion(idProductoVenta,cantidad,idDevolucion) VALUES(".$p->idRegistroProducto.",".$p->cantidad.",@idRegistro)";
			$x++;
			
			
			$consulta="SELECT idProducto,llave FROM 6009_productosVentaCaja WHERE idProductoVenta=".$p->idRegistroProducto;
			$fProductoVenta=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT idAlmacen from 6901_catalogoProductos WHERE idProducto=".$fProductoVenta[0];
			$idAlmacen=$con->obtenerValor($consulta);
			$c=new cAlmacen($idAlmacen);
			$oProducto=json_decode($objAsiento);
			
			$oProducto->cantidadOperacion=$p->cantidad;
			
			
			$oProducto->idProducto=$fProductoVenta[0];
			$oProducto->dimensiones=convertirLlaveDimensiones($fProductoVenta[1]);
			array_push($arrDevoluciones,$oProducto);
			
			
		}
		
		$c->asentarArregloMovimientos($arrDevoluciones,$query,$x,true);
		
		$totalNota=$obj->montoDevolucion;
		$consulta="SELECT idAdeudo,total,subtotal,iva FROM 6942_adeudos WHERE tipoAdeudo=1 AND idReferencia=".$obj->idVenta;
		$fAdeudo=$con->obtenerPrimeraFila($consulta);
		$idAdeudo=$fAdeudo[0];
		if($idAdeudo!="")
		{
			$porcIva=$fAdeudo[3]/$fAdeudo[1];
			$consulta="select sum(montoAbono) from 6936_controlPagos where idAdeudo=".$idAdeudo;
			$montoAbonado=$con->obtenerValor($consulta);	
			
			$saldo=$fAdeudo[1]-$montoAbonado;
			$saldoVirtual=$saldo-$totalNota;
			
			$subtotal=0;
			$iva=0;
			if($saldoVirtual<=0)
			{
				$consulta="select sum(iva) from 6936_controlPagos where idAdeudo=".$idAdeudo;
				$totalIVA=$con->obtenerValor($consulta);
				$diferenciaIVA=$obj->iva-$totalIVA;
				$iva=$diferenciaIVA;
				$subtotal=$totalNota-$iva;
				
				$query[$x]="UPDATE 6942_adeudos SET situacion=2 WHERE idAdeudo=".$idAdeudo;
				$x++;
			}
			else
			{
	
				$iva=str_replace(",","",number_format($totalNota*$porcIva,2));	
	
				$subtotal=$totalNota-$iva;
			}
			$folioAbono=generarNombreArchivoTemporal(1,"");
			$query[$x]="INSERT INTO 6936_controlPagos(montoAbono,fechaAbono,idAdeudo,formaPago,horaAbono,idResponsableCobro,idCaja,datosComp,folioAbono)
							VALUES(".$totalNota.",'".date("Y-m-d")."',".$idAdeudo.",6,'".date("H:i:s")."',".$_SESSION["idUsr"].",".$obj->idCaja.",@idRegistro,'".$folioAbono."')";
			$x++;
		}

		if($obj->idMotivoDevolucion==4)
		{
			$consulta="SELECT idFactura FROM 6008_ventasCaja WHERE idVenta=".$obj->idVenta;
			$idFactura=$con->obtenerValor($consulta);
			if($idFactura!="")
			{
				$t=new cFDIFinkok();	
				$motivo="Venta cancelada";
				$t->cancelarComprobante($idFactura,$motivo);
			}
			
			$query[$x]="update 6008_ventasCaja set situacion=0 where idVenta=".$obj->idVenta;
			$x++;
		
		}


		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			
			
			
			$consulta="select @idRegistro";
			$idDevolucion=$con->obtenerValor($consulta);	
			echo "1|".$idDevolucion;	
		}
	} 
	
	function obtenerAbonosAdeudo()
	{
		global $con;
		$idAdeudo=-1;
		if(isset($_POST["idVenta"]))
		{
			$idVenta=$_POST["idVenta"];
		
		
			$consulta="SELECT idAdeudo FROM 6942_adeudos WHERE tipoAdeudo=1 AND idReferencia=".$idVenta;
			$idAdeudo=$con->obtenerValor($consulta);
		}
		if(isset($_POST["idAdeudo"]))
			$idAdeudo=$_POST["idAdeudo"];
		$consulta="SELECT idControlPago AS idAbono,fechaAbono,montoAbono,formaPago,idComprobante FROM 6936_controlPagos WHERE idAdeudo=".$idAdeudo;
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';	
	}
	
	function obtenerAdeudosAProveedor()
	{
		global $con;
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$consulta="select * from (SELECT idAdeudo,a.total AS montoTotal ,fechaVencimiento AS fechaLimitePago,a.fechaCreacion,p.fechaCreacion AS fechaPedido,
					p.idPedido  AS folioPedido,p.idProveedor,
					CONCAT(rfc1,'-',rfc2,'-',rfc3) AS rfc,
					CONCAT(IF(apPaterno IS NULL,'',apPaterno),' ',IF(apMaterno IS NULL,'',apMaterno),' ',razonSocial) AS proveedor,
					if((SELECT SUM(montoAbono) FROM 6936_controlPagos WHERE idAdeudo=a.idAdeudo) is null,0,(SELECT SUM(montoAbono) FROM 6936_controlPagos WHERE idAdeudo=a.idAdeudo)) AS totalAbonos
					FROM 6942_adeudos a,6930_pedidos p,6927_empresas e WHERE a.situacion=1 AND a.tipoAdeudo=4 and a.tipoCliente=0
					AND p.idPedido=a.idReferencia AND e.idEmpresa=p.idProveedor) as tmp where 1=1 and  ".$condWhere;	
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));			
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';	
	}
	
	function registrarAbonoAdeudoProveedor()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		
		$obj=json_decode($cadObj);
		
		
		$datosAbono=obtenerDesgloceAbonoAdeudoProveedor($obj->folioPedido,$obj->idAdeudo,$obj->cantidadAbono);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$folioAbono=generarNombreArchivoTemporal(1,"");
		
		$consulta[$x]="INSERT INTO 6936_controlPagos(montoAbono,fechaAbono,idAdeudo,formaPago,datosComp,horaAbono,idResponsableCobro,idCaja,subtotal,iva,comentarios,folioAbono)
					VALUES(".$obj->cantidadAbono.",'".$obj->fechaAbono."',".$obj->idAdeudo.",".$obj->formaPago.",'','".date("H:i:s")."','".$_SESSION["idUsr"]."',0,".$datosAbono["subtotal"].",".$datosAbono["iva"].",'".cv($obj->comentarios)."','".$folioAbono."')";
		
		$x++;
		if($datosAbono["saldoVirtual"]<=0)
		{
			$consulta[$x]="UPDATE 6942_adeudos SET situacion=2 WHERE idAdeudo=".$obj->idAdeudo;
			$x++;
		}
		
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		
		
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idRegistro";
			$idAbono=$con->obtenerValor($query);	
			echo "1|".$idAbono;
		}

	}
	
	function registrarDatosReestructuracion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->tipoDescuento=="")
			$obj->tipoDescuento="NULL";
		if($obj->porcentajeDescuento=="")
			$obj->porcentajeDescuento=0;
			
			
		$query="select idDatoReestructura from 3006_datosReestructura where idFormulario=".$obj->idFormulario." and idReferencia=".$obj->idRegistro;
		$idDatoReestructura=$con->obtenerValor($query);
		if($idDatoReestructura=="")
			$idDatoReestructura=-1;
		
		if($idDatoReestructura==-1)
		{	
			$consulta[$x]="INSERT INTO 3006_datosReestructura(idFormulario,idReferencia,noPagos,diferenciaCentavosFinal,tipoDescuento,porcentajeDescuento,montoReestructurar)
							VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$obj->noPagos.",".$obj->diferenciaCentavosFinal.",".$obj->tipoDescuento.",".$obj->porcentajeDescuento.",".$obj->montoReestructurar.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="UPDATE 3006_datosReestructura SET noPagos=".$obj->noPagos.",diferenciaCentavosFinal=".$obj->diferenciaCentavosFinal.",tipoDescuento=".$obj->tipoDescuento.
							",porcentajeDescuento=".$obj->porcentajeDescuento.",montoReestructurar=".$obj->montoReestructurar." WHERE idDatoReestructura=".$idDatoReestructura;
			$x++;
			$consulta[$x]="set @idRegistro:=".$idDatoReestructura;
			$x++;
		}
		
		$consulta[$x]="delete from 3007_conceptosConsiderarReestructura where idReestructura=@idRegistro";
		$x++;
		foreach($obj->arrMovimientos as $m)
		{
			$consulta[$x]="INSERT INTO 3007_conceptosConsiderarReestructura(idConcepto,noPago,idReestructura) VALUES(".$m->idMovimiento.",".$m->noPago.",@idRegistro)";
			$x++;
		}
		
		$consulta[$x]="delete from 3008_pagosReestructura where idReestructura=@idRegistro";
		$x++;
		foreach($obj->arrReestructura as $r)
		{
			if($r->montoDescuento=="")
				$r->montoDescuento="NULL";
			if($r->fechaVencimientoDescuento=="")
				$r->fechaVencimientoDescuento="NULL";
			else
				$r->fechaVencimientoDescuento="'".$r->fechaVencimientoDescuento."'";
			$consulta[$x]="INSERT INTO 3008_pagosReestructura(descripcionConcepto,montoPago,fechaVencimiento,montoPagoDescuento,fechaVencimientoDescuento,idReestructura)
					VALUES('".cv($r->concepto)."',".$r->monto.",'".$r->fechaVencimiento."',".$r->montoDescuento.",".$r->fechaVencimientoDescuento.",@idRegistro)";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function removerSerieCertificado()
	{
		global $con;	
		$idSerie=$_POST["idSerie"];
		$consulta="DELETE FROM 688_seriesCertificados WHERE idSerieCertificado=".$idSerie;
		eC($consulta);
		
		
	}
	
	function registrarSerieCertificado()
	{
		global $con;	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->idSerie==-1)
			$consulta="INSERT INTO 688_seriesCertificados(serie,folioInicial,folioActual,idCertificado) VALUES('".cv($obj->serie)."','".$obj->folioInicial."','".$obj->folioInicial."',".$obj->idCertificado.")";
		else
			$consulta="update 688_seriesCertificados set serie='".cv($obj->serie)."' where idSerieCertificado=".$obj->idSerie;
		if($con->ejecutarConsulta($consulta))
		{
			$idSerie=$obj->idSerie;
			if($idSerie==-1)
				$idSerie=$con->obtenerUltimoID();
			echo "1|".$idSerie;	
		}
		
		
	}
	
	function buscarClienteFactura()
	{
		global $con;	
		global $referenciaFiltros;
		$valorBusqueda=$_POST["query"];
		$tipoBusqueda=$_POST["tipoBusqueda"];
		$consulta="SELECT * FROM (
					
					SELECT e.idEmpresa,CONCAT(rfc1,'-',rfc2,'-',rfc3) AS rfc,
					IF(tipoEmpresa=1,CONCAT(apPaterno,' ',apMaterno,' ',razonSocial),razonSocial) AS razonSocial
					FROM 6927_empresas e,6927_categoriaEmpresa c WHERE  referencia='".$referenciaFiltros."' AND c.idEmpresa=e.idEmpresa AND c.idCategoria=1) AS tmp WHERE ";
		
		switch($tipoBusqueda)
		{
			case 1:
				$consulta.=" rfc like '".$valorBusqueda."%'";
			break;
			case 2:
				$consulta.=" razonSocial like '%".$valorBusqueda."%'";
			break;
		}
		$consulta.=" ORDER BY rfc";
	
		$res=$con->obtenerFilas($consulta);
		$arrRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			$domFiscal=generarDomicilioFiscalCliente($fila[0]);
			$o='{"idEmpresa":"'.$fila[0].'","rfc":"'.$fila[1].'","razonSocial":"'.cv($fila[2]).'","domicilioFiscal":"'.cv($domFiscal).'"}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrRegistros.']}';
	}
	
	function buscarClienteFacturacionTipoCliente()
	{
		global $con;	
		global $referenciaFiltros;
		$tipoCliente=$_POST["tipoCliente"];
		$idCliente=$_POST["idCliente"];
		
		$consulta="SELECT idEmpresaFacturacion FROM 6956_tiposClientesVSClientesFacturacion WHERE tipoCliente=".$tipoCliente." AND idCliente=".$idCliente;
		
		$listEmpresas=$con->obtenerListaValores($consulta);
		
		if($listEmpresas=="")
			$listEmpresas=-1;
		
		$consulta="SELECT e.idEmpresa,CONCAT(rfc1,'-',rfc2,'-',rfc3) AS rfc,
					IF(tipoEmpresa=1,CONCAT(apPaterno,' ',apMaterno,' ',razonSocial),razonSocial) AS razonSocial
					FROM 6927_empresas e where idEmpresa in(".$listEmpresas.")";
		
		
		$consulta.=" ORDER BY rfc";
	
		$res=$con->obtenerFilas($consulta);
		$arrRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			$domFiscal=generarDomicilioFiscalCliente($fila[0]);
			$o='{"idEmpresa":"'.$fila[0].'","rfc":"'.$fila[1].'","razonSocial":"'.cv($fila[2]).'","domicilioFiscal":"'.cv($domFiscal).'"}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerDatosClienteFactura()
	{
		global $con;	
		$idEmpresa=$_POST["idEmpresa"];
		$consulta="SELECT e.idEmpresa,CONCAT(rfc1,'-',rfc2,'-',rfc3) AS rfc,
					IF(tipoEmpresa=1,CONCAT(apPaterno,' ',apMaterno,' ',razonSocial),razonSocial) AS razonSocial
					FROM 6927_empresas e where idEmpresa =".$idEmpresa;
	
		$fEmpresa=$con->obtenerPrimeraFila($consulta);
		
		$domFiscal=generarDomicilioFiscalCliente($fEmpresa[0]);
		echo "1|".$fEmpresa[1]."|".$fEmpresa[2]."|".$domFiscal;
	}
	
	function generarCFDIVentaCaja()
	{
		global $con;
		$idVenta=$_POST["idVenta"];
		$idCliente=$_POST["idCliente"];
		$tipoFacturacion=$_POST["tipoFacturacion"];
		$idEmpresa=-1;
		if(isset($_POST["idEmpresa"]))
			$idEmpresa=$_POST["idEmpresa"];
		
		$idCertificado=-1;
		if(isset($_POST["idCertificado"]))
			$idCertificado=$_POST["idCertificado"];
			
		$idSerie=-1;		
		if(isset($_POST["idSerie"]))
			$idSerie=$_POST["idSerie"];
			
		$consulta="";
		
		if($tipoFacturacion==0)
			$consulta="SELECT idCaja FROM 6008_ventasCaja WHERE idVenta=".$idVenta;
		else
			$consulta="SELECT idCaja FROM 6936_controlPagos WHERE idControlPago=".$idVenta;
			
		$idCaja=$con->obtenerValor($consulta);		
			
		$consulta="SELECT idEmpresa,idCertificado,idSerie FROM 6007_instanciasCaja WHERE idCaja=".$idCaja;
		$fCaja=$con->obtenerPrimeraFila($consulta);
		
		if(($idEmpresa==-1)&&($fCaja[0]!=""))
			$idEmpresa=$fCaja[0];

		if(($idEmpresa==-1)&&($fCaja[1]!=""))
			$idCertificado=$fCaja[1];
		
		if(($idEmpresa==-1)&&($fCaja[2]!=""))
			$idSerie=$fCaja[2];
			
		if($tipoFacturacion==0)							
			$objFactura=generarXMLVentaCajaGeneralV2($idVenta,$idCliente,$idEmpresa,$idCertificado,$idSerie,true);
		else
			$objFactura=generarXMLVentaCajaGeneralAbono($idVenta,$idCliente,$idEmpresa,$idCertificado,$idSerie,true);
		
		$oFactura=new cFacturaCFDI();
		$oFactura->setObjFactura($objFactura);

		$XMLFactura=$oFactura->generarXML();
		
		$idFactura="";
		if($tipoFacturacion==0)	
			$idFactura=$oFactura->registrarXML(4,$idVenta);
		else
			$idFactura=$oFactura->registrarXML(6,$idVenta);
		$oFactura->generarSelloDigital($idFactura);


		$XML=$oFactura->cargarComprobanteXML($idFactura);
		$resultado=$oFactura->validarXML($XML);
		
		if($resultado["errores"])
		{
			$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=5,comentarios='".cv($resultado["arrErrores"])."' WHERE idFolio=".$idFactura;			
			$con->ejecutarConsulta($consulta);
			echo "1|2";
		}
		else
		{
			$t=new cFDIFinkok();	
			
			if($t->timbrarComprobante($idFactura))
			{
				$x=0;
				$query[$x]="begin";
				$x++;
				if($tipoFacturacion==0)	
					$query[$x]="UPDATE 6008_ventasCaja SET idFactura= ".$idFactura." WHERE idVenta=".$idVenta;
				else
					$query[$x]="UPDATE 6936_controlPagos SET idComprobante= ".$idFactura." WHERE idControlPago=".$idVenta;
				$x++;
				$query[$x]="commit";
				$x++;				
				eB($query);

			}
			else
			{
				echo "1|2";
			}
			
		}
		
		
		
	}
	
	function registrarComprobanteElectronico()
	{
		global $con;	
		$cadObj=bD($_POST["cadObj"]);
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->noParcialidad=="")
			$obj->noParcialidad="NULL";
		if($obj->totalParcialidad=="")
			$obj->totalParcialidad="NULL";
			
		$descuentos=0;
		foreach($obj->arrTotales as $t)
		{
			if($t->idConcepto==6)
			{
				$descuentos=$t->montoConcepto;
				break;	
			}	
		}
		
		$subtotal=0; //* Obligatorio
		foreach($obj->arrTotales as $t)
		{
			if($t->idConcepto==5)
			{
				$subtotal=$t->montoConcepto;
				break;	
			}	
		}	
		
		foreach($obj->arrTotales as $t)
		{
			if($t->idConcepto==12)
			{
				$total=$t->montoConcepto;
				break;	
			}	
		}
		
		$complemento=0;
		if(isset($obj->complemento))
		{
			$complemento=$obj->complemento;
		}
		
		
		if($con->existeCampo("complemento","706_comprobanteFactura"))
		{
			$consulta[$x]="INSERT INTO 706_comprobanteFactura(tipoComprobante,fechaCrecion,idEmpresa,idCliente,fechaDocumento,idCertificado,idSerie,moneda,
						tipoCambio,formaPago,noParcialidad,totalParcialidad,condicionPago,idFormaPago,otroFormaPago,noCuentaPago,lugarExpedicion,subtotal,
						total,descuentos,comentariosAdicionales,motivoDescuento,complemento)
						VALUES(".$obj->tipoComprobante.",'".date("Y-m-d H:i:s")."',".$obj->idEmpresa.",".$obj->idCliente.",'".$obj->fechaComprobante."',".$obj->idCertificado.
						",".$obj->idSerie.",".$obj->moneda.",".$obj->tipoCambio.",".$obj->formaPago.",".$obj->noParcialidad.",".$obj->totalParcialidad.",'".
						cv($obj->condicionesPago)."',".$obj->metodoPago.",'".cv($obj->metodoPagoEspecifique)."','".$obj->noCuenta."','".cv($obj->lugarExpedicion).
						"',".$subtotal.",".$total.",".$descuentos.",'".cv($obj->comentariosAdicionales)."','".cv($obj->motivoDescuento)."',".$complemento.")";
		}
		else
		{
			$consulta[$x]="INSERT INTO 706_comprobanteFactura(tipoComprobante,fechaCrecion,idEmpresa,idCliente,fechaDocumento,idCertificado,idSerie,moneda,
						tipoCambio,formaPago,noParcialidad,totalParcialidad,condicionPago,idFormaPago,otroFormaPago,noCuentaPago,lugarExpedicion,subtotal,
						total,descuentos,comentariosAdicionales,motivoDescuento)
						VALUES(".$obj->tipoComprobante.",'".date("Y-m-d H:i:s")."',".$obj->idEmpresa.",".$obj->idCliente.",'".$obj->fechaComprobante."',".$obj->idCertificado.
						",".$obj->idSerie.",".$obj->moneda.",".$obj->tipoCambio.",".$obj->formaPago.",".$obj->noParcialidad.",".$obj->totalParcialidad.",'".
						cv($obj->condicionesPago)."',".$obj->metodoPago.",'".cv($obj->metodoPagoEspecifique)."','".$obj->noCuenta."','".cv($obj->lugarExpedicion).
						"',".$subtotal.",".$total.",".$descuentos.",'".cv($obj->comentariosAdicionales)."','".cv($obj->motivoDescuento)."')";
		}
		
		$x++;
		$consulta[$x]="set @idComprobante=(select last_insert_id())";
		$x++;
		foreach($obj->arrConceptos as $c)
		{
			$idConcepto="NULL";
			$llave="";
			if($c->idConcepto!="")
			{
				$arrLlave=explode("_",$c->idConcepto);
				$idConcepto=$arrLlave[0];
				$llave=$arrLlave[1];
			}
			$consulta[$x]="INSERT 707_conceptosFactura(idComprobante,idConcepto,llave,descripcionConcepto,cantidad,unidadMedida,
							costoUnitario,subtotal,tasaIVA,totalIVA,descUnitario,totalDescuento,total,clave,cabecera) values(@idComprobante,".$idConcepto.",
							'".$llave."','".cv($c->descripcion)."',".$c->cantidad.",".$c->unidadMedida.",".$c->costoUnitario.",".$c->subtotal.
							",".$c->tasaIVA.",".$c->iva.",".$c->descuentoUnitario.",".($c->descuentoUnitario*$c->cantidad).",".$c->total.",'".cv($c->clave)."','".cv(urldecode($c->cabecera))."')";
			$x++;
		}
		
		
		foreach($obj->arrTotales as $c)
		{
			if($c->tasaConcepto=="")
				$c->tasaConcepto="NULL";
			$consulta[$x]="INSERT INTO 709_impuestosRetencionesComprobante(idComprobante,tipoConcepto,idConcepto,tasaConcepto,montoConcepto,etiquetaConcepto)
							VALUES(@idComprobante,".$c->tipoConcepto.",".$c->idConcepto.",".$c->tasaConcepto.",".$c->montoConcepto.",'".$c->etiqueta."')";
			$x++;
		}

		if(isset($obj->complemento)&&($obj->complemento!=0))
		{
			$query="SELECT funcionGeneradoraComplemento FROM 6956_complementosComprobantes WHERE idRegistro=".$obj->complemento;

			$funcionGeneradoraComplemento=$con->obtenerValor($query);

			eval($funcionGeneradoraComplemento.'QueryGuardar($obj,$consulta,$x);');
			
			
		}
		
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idComprobante";
			$idComprobante=$con->obtenerValor($query);

			$objFactura=generarObjetoComprobanteJSON($obj,true);
			
			$oFactura=new cFacturaCFDI();
			$oFactura->setObjFactura($objFactura);
			
			$XMLFactura=$oFactura->generarXML();
			
			$idFactura=$oFactura->registrarXML(5,$idComprobante);
			$oFactura->generarSelloDigital($idFactura);
			
			$XML=$oFactura->cargarComprobanteXML($idFactura);
			
			$resultado=$oFactura->validarXML($XML);
			if($resultado["errores"])
			{
				$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=5,comentarios='".cv($resultado["arrErrores"])."' WHERE idFolio=".$idFactura;			
				$con->ejecutarConsulta($consulta);
			}
			else
			{
				$t=new cFDIFinkok();	
				$t->timbrarComprobante($idFactura);
			}
			echo "1|";
			
				
		}
		

	}
	
	function cancelarComprobanteElectronico()
	{
		global $con;	
		$t=new cFDIFinkok();	
		$iC=$_POST["iC"];
		$motivo=$_POST["motivo"];
		$arrCFDI=explode(",",$iC);
		foreach($arrCFDI as $c)
		{
			$t->cancelarComprobante($c,$motivo);		
		}
		echo "1|";
	}
	
	function modificarSituacionTimbradoEmpresa()
	{
		global $con;	
		$idRegistro=$_POST["idRegistro"];
		$valor=$_POST["valor"];
		$consulta="UPDATE 715_situacionEmpresasTimbrado SET situacion=".$valor." WHERE idSituacion=".$idRegistro;
		eC($consulta);
	}
	
	function buscarProveedorFactura()
	{
		global $con;	
		global $referenciaFiltros;
		$valorBusqueda=$_POST["valorBusqueda"];
		$tipoBusqueda=$_POST["tipoBusqueda"];
		$consulta="SELECT * FROM (
					
					SELECT e.idEmpresa,CONCAT(rfc1,'-',rfc2,'-',rfc3) AS rfc,
					IF(tipoEmpresa=1,CONCAT(apPaterno,' ',apMaterno,' ',razonSocial),razonSocial) AS razonSocial
					FROM 6927_empresas e,6927_categoriaEmpresa c WHERE  referencia='".$referenciaFiltros."' AND c.idEmpresa=e.idEmpresa AND c.idCategoria=2) AS tmp WHERE ";
		
		switch($tipoBusqueda)
		{
			case 1:
				$consulta.=" rfc like '".$valorBusqueda."%'";
			break;
			case 2:
				$consulta.=" razonSocial like '%".$valorBusqueda."%'";
			break;
		}
		$consulta.=" ORDER BY rfc";

		$res=$con->obtenerFilas($consulta);
		$arrRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			$domFiscal=generarDomicilioFiscalCliente($fila[0]);
			$o='{"idEmpresa":"'.$fila[0].'","rfc":"'.$fila[1].'","razonSocial":"'.cv($fila[2]).'","domicilioFiscal":"'.cv($domFiscal).'"}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrRegistros.']}';
	}
	
	
	function guardarComprobantesIngresoEgreso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		$x=0;
		$query[$x]="begin";
		$x++;
		
		if(!isset($_POST["esIngreso"]))
		{
			if($obj->idComprobante==-1)
			{
				$query[$x]="INSERT INTO 719_comprobanteFacturaEgreso(tipoComprobante,fechaCreacion,idEmpresa,idProveedor,fechaDocumento,condicionPago,idFormaPago,otroFormaPago,noCuentaPago,
							comentariosAdicionales,motivoDescuento,folio,serie,folioUUID)
							VALUES(".$obj->tipoComprobante.",'".date("Y-m-d H:i:s")."',".$obj->idEmpresa.",".$obj->idProveedor.",'".$obj->fechaComprobante."','".cv($obj->condicionesPago)."',".$obj->metodoPago.",'".cv($obj->metodoPagoEspecifique).
							"','".$obj->noCuenta."','".cv($obj->comentariosAdicionales)."','".cv($obj->motivoDescuento)."','".$obj->folio."','".cv($obj->serie)."','".cv($obj->folioUUID)."')";
				$x++;
				
				$query[$x]="set @idFactura:=(select last_insert_id())";
				$x++;
				
			}
			else
			{
				$query[$x]="update 719_comprobanteFacturaEgreso set tipoComprobante=".$obj->tipoComprobante.",idProveedor=".$obj->idProveedor.",fechaDocumento='".$obj->fechaComprobante."',condicionPago='".cv($obj->condicionesPago)."',
							idFormaPago=".$obj->metodoPago.",otroFormaPago='".cv($obj->metodoPagoEspecifique)."',noCuentaPago='".$obj->noCuenta."',comentariosAdicionales='".cv($obj->comentariosAdicionales).
							"',motivoDescuento='".cv($obj->motivoDescuento)."',folio='".$obj->folio."',serie='".cv($obj->serie)."',folioUUID='".cv($obj->folioUUID)."' where idComprobanteFactura=".$obj->idComprobante;
							
				$x++;
				$query[$x]="set @idFactura:=".$obj->idComprobante;
				$x++;
			}
			
			$query[$x]="DELETE FROM 720_conceptosFacturaEgreso WHERE idComprobante=@idFactura";
			$x++;
			$query[$x]="DELETE FROM 721_impuestosRetencionesComprobanteEgreso WHERE idComprobante=@idFactura";
			$x++;
			
			$ivaDeducible=0;
			foreach($obj->arrConceptos as $c)
			{
				$query[$x]="INSERT INTO 720_conceptosFacturaEgreso(idComprobante,descripcionConcepto,costoUnitario,cantidad,subtotal,totalIVA,tasaIVA,total,deducible,descuentoUnitario,descuentoTotal)
							VALUES(@idFactura,'".cv($c->descripcion)."',".$c->costoUnitario.",".$c->cantidad.",".$c->subtotal.",".$c->iva.",".$c->tasaIVA.",".$c->total.",".$c->deducible.",".$c->descuentoUnitario.",".$c->descuentoTotal.")";
				$x++;
				if($c->deducible==1)
					$ivaDeducible+=$c->iva;
			}
			
			$subtotal=0;
			$total=0;
			$descuentos=0;
			
			foreach($obj->arrTotales as $t)
			{
				if($t->tasaConcepto=="")
					$t->tasaConcepto="NULL";
				$query[$x]="INSERT INTO 721_impuestosRetencionesComprobanteEgreso(idComprobante,tipoConcepto,idConcepto,tasaConcepto,montoConcepto)
							VALUES(@idFactura,".$t->tipoConcepto.",".$t->idConcepto.",".$t->tasaConcepto.",".$t->montoConcepto.")";
				$x++;
				if($t->idConcepto==6)
					$descuentos=$t->montoConcepto;
				if($t->idConcepto==7)
					$subtotal=$t->montoConcepto;
				if($t->idConcepto==12)
					$total=$t->montoConcepto;
			}
			$query[$x]="update 719_comprobanteFacturaEgreso set subtotal=".$subtotal.",total=".$total.",descuentos=".$descuentos.",ivaDeducible=".$ivaDeducible." where idComprobanteFactura=@idFactura";
			$x++;
		}
		else
		{
			if($obj->idComprobante==-1)
			{
				$query[$x]="INSERT INTO 706_comprobanteFactura(tipoComprobante,fechaCrecion,idEmpresa,idCliente,fechaDocumento,condicionPago,idFormaPago,otroFormaPago,noCuentaPago,
							comentariosAdicionales,motivoDescuento,folio,serie,folioUUID,emitidoPorSistema)
							VALUES(".$obj->tipoComprobante.",'".date("Y-m-d H:i:s")."',".$obj->idEmpresa.",".$obj->idCliente.",'".$obj->fechaComprobante."','".cv($obj->condicionesPago)."',".$obj->metodoPago.",'".cv($obj->metodoPagoEspecifique).
							"','".$obj->noCuenta."','".cv($obj->comentariosAdicionales)."','".cv($obj->motivoDescuento)."','".$obj->folio."','".cv($obj->serie)."','".cv($obj->folioUUID)."',0)";
				$x++;
				
				$query[$x]="set @idFactura:=(select last_insert_id())";
				$x++;
				
			}
			else
			{
				$query[$x]="update 706_comprobanteFactura set tipoComprobante=".$obj->tipoComprobante.",idCliente=".$obj->idCliente.",fechaDocumento='".$obj->fechaComprobante."',condicionPago='".cv($obj->condicionesPago)."',
							idFormaPago=".$obj->metodoPago.",otroFormaPago='".cv($obj->metodoPagoEspecifique)."',noCuentaPago='".$obj->noCuenta."',comentariosAdicionales='".cv($obj->comentariosAdicionales).
							"',motivoDescuento='".cv($obj->motivoDescuento)."',folio='".$obj->folio."',serie='".cv($obj->serie)."',folioUUID='".cv($obj->folioUUID)."' where idComprobanteFactura=".$obj->idComprobante;
							
				$x++;
				$query[$x]="set @idFactura:=".$obj->idComprobante;
				$x++;
			}
			
			$query[$x]="DELETE FROM 707_conceptosFactura WHERE idComprobante=@idFactura";
			$x++;
			$query[$x]="DELETE FROM 709_impuestosRetencionesComprobante WHERE idComprobante=@idFactura";
			$x++;
			
			$ivaDeducible=0;
			foreach($obj->arrConceptos as $c)
			{
				if($c->descuentoTotal=="")
					$c->descuentoTotal=0;
				$query[$x]="INSERT INTO 707_conceptosFactura(idComprobante,descripcionConcepto,costoUnitario,cantidad,subtotal,totalIVA,tasaIVA,total,descUnitario,totalDescuento)
							VALUES(@idFactura,'".cv($c->descripcion)."',".$c->costoUnitario.",".$c->cantidad.",".$c->subtotal.",".$c->iva.",".$c->tasaIVA.",".$c->total.",".$c->descuentoUnitario.",".$c->descuentoTotal.")";
				$x++;
			}
			
			$subtotal=0;
			$total=0;
			$descuentos=0;
			
			foreach($obj->arrTotales as $t)
			{
				if($t->tasaConcepto=="")
					$t->tasaConcepto="NULL";
				$query[$x]="INSERT INTO 709_impuestosRetencionesComprobante(idComprobante,tipoConcepto,idConcepto,tasaConcepto,montoConcepto)
							VALUES(@idFactura,".$t->tipoConcepto.",".$t->idConcepto.",".$t->tasaConcepto.",".$t->montoConcepto.")";
				$x++;
				if($t->idConcepto==6)
					$descuentos=$t->montoConcepto;
				if($t->idConcepto==7)
					$subtotal=$t->montoConcepto;
				if($t->idConcepto==12)
					$total=$t->montoConcepto;
			}
			$query[$x]="update 706_comprobanteFactura set subtotal=".$subtotal.",total=".$total.",descuentos=".$descuentos." where idComprobanteFactura=@idFactura";
			$x++;
		}
		$query[$x]="commit";
		$x++;

		eB($query);
	}
	
	function verificarRFCClienteProveedor()
	{
		global $con;
		$rfc1=$_POST["rfc1"];
		$rfc2=$_POST["rfc2"];
		$rfc3=$_POST["rfc3"];
		$referencia=$_POST["referencia"];
		$idEmpresa=$_POST["idEmpresa"];
		$consulta="SELECT COUNT(*) FROM 6927_empresas WHERE 1=2 and rfc1='".$rfc1."' AND rfc2='".$rfc2."' AND rfc3='".$rfc3."' AND referencia='".$referencia."' and idEmpresa<>".$idEmpresa;
		$nReg=$con->obtenerValor($consulta);
		echo "1|".$nReg;
	}
	
	function reenviarComprobante()
	{
		$idComprobante=$_POST["iC"];
		$c=new cFDIFinkok();
		$c->enviarComprobanteEmail($idComprobante,true);
		echo "1|";		
	}
	
	function cambiarSituacionComprobante()
	{
		global $con;
		$idComprobante=$_POST["iC"];
		$val=$_POST["val"];
		
		$consulta="UPDATE 706_comprobanteFactura SET pagado=".$val." WHERE idComprobanteFactura=".$idComprobante;
		eC($consulta);
	
	}
	
	function obtenerVentasCaja()
	{
		global $con;
		
		$periodoDel=$_POST["periodoDel"];
		$periodoAl=$_POST["periodoAl"];
		$formaPago=$_POST["formaPago"];//148 37
		
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		
		$tiposProductos=array();
		$consulta="SELECT * FROM 554_tiposProductos";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$tiposProductos[$fila[0]]=$fila;
		}
		
		
		
		$condFormaPago="";
		if($formaPago!=0)
			$condFormaPago=" and formaPago=".$formaPago;
		
		
		$consulta="select * from (SELECT idVenta,date_format(fechaVenta,'%Y-%m-%d') AS fecha,folioVenta,total AS montoTotal,formaPago AS tipoVenta,idFactura AS idComprobante, 
					(SELECT CONCAT(rfc1,'-',rfc2,'-',rfc3) FROM 6927_empresas e,703_relacionFoliosCFDI r 
					WHERE e.idEmpresa=r.idClienteFactura AND r.idFolio=v.idFactura) AS rfcReceptor,
					(SELECT IF(e.tipoEmpresa=1,CONCAT(e.apPaterno,' ',e.apMaterno,' ',e.razonSocial),e.razonSocial) FROM 6927_empresas e,703_relacionFoliosCFDI r 
					WHERE e.idEmpresa=r.idClienteFactura AND r.idFolio=v.idFactura) AS nombreReceptor, situacion as situacionVenta,
					(SELECT situacion from 703_relacionFoliosCFDI r WHERE  r.idFolio=v.idFactura) AS situacionComprobante,
					(SELECT comentarios from 703_relacionFoliosCFDI r WHERE  r.idFolio=v.idFactura) AS comentariosComprobante,
					if(idFactura is null,'0','1') as facturado
					FROM 6008_ventasCaja v where  cast(fechaVenta as date)>='".$periodoDel."' and cast(fechaVenta as date)<='".$periodoAl."' ".$condFormaPago.") as tmp where ".$condWhere;
					
			
					
		$registros="";		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			

			$concepto="";
			
			$consulta="SELECT * FROM 6009_productosVentaCaja WHERE idVenta=".$fila[0];
			$rProductos=$con->obtenerFilas($consulta);
			while($fProductoVenta=mysql_fetch_row($rProductos))
			{
				$fConfiguracionProducto=$tiposProductos[$fProductoVenta[3]];

				$consulta="SELECT ".$fConfiguracionProducto[4]." FROM ".$fConfiguracionProducto[2]." WHERE ".$fConfiguracionProducto[3]."=".$fProductoVenta[2]; 

				$nombreProducto=$con->obtenerValor($consulta);
				$c=$nombreProducto;
				
				if($fConfiguracionProducto[5]!="")
				{
					if($fConfiguracionProducto[6]=="0")
						eval('$c='.$fConfiguracionProducto[5].'($fila[0],$fProductoVenta[0],$fProductoVenta[2],$nombreProducto);');
				}
				
				if($concepto=="")
					$concepto=$c;
				else
					$concepto.=",".$c;
			}
			
			$o='{"idVenta":"'.$fila[0].'","fecha":"'.$fila[1].'","folioVenta":"'.$fila[2].'","montoTotal":"'.$fila[3].'","tipoVenta":"'.$fila[4].'","idComprobante":"'.$fila[5].
				'","rfcReceptor":"'.$fila[6].'","nombreReceptor":"'.$fila[7].'","situacionVenta":"'.$fila[8].'","situacionComprobante":"'.$fila[9].'","comentariosComprobante":"'.
				$fila[10].'","facturado":"'.$fila[11].'","concepto":"'.cv($concepto).'"}';
			
			if($registros=="")
				$registros=$o;
			else
				$registros.=",".$o;
									
		}
		$numReg=$con->filasAfectadas;
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$registros.']}';	
	}
	
	function reintentarTimbradoFacturaCaja()
	{
		global $con;
		
		
		$idComprobante=$_POST["idComprobante"];
			
		$consulta="SELECT idReferencia,idCertificado,idSerie,(SELECT idReferencia FROM 687_certificadosSelloDigital WHERE idCertificado=r.idCertificado),idClienteFactura FROM 703_relacionFoliosCFDI r WHERE idFolio=".$idComprobante;
		$fComprobante=$con->obtenerPrimeraFila($consulta);
		
		
		$idEmpresa=$fComprobante[3];
		
		$idCertificado=$fComprobante[1];
		
		$idSerie=$fComprobante[2];
		
		$idVenta=$fComprobante[0];
		
		$idCliente=$fComprobante[4];
		
		$objFactura=generarXMLVentaCajaGeneral($idVenta,$idCliente,$idEmpresa,$idCertificado,$idSerie,true);
		
		$oFactura=new cFacturaCFDI();
		$oFactura->setObjFactura($objFactura);
		
		$XMLFactura=$oFactura->generarXML();

		$oFactura->actualizarXMLComprobante($idComprobante);
		
		$oFactura->generarSelloDigital($idComprobante);
		
		$XML=$oFactura->cargarComprobanteXML($idComprobante);
		
		$resultado=$oFactura->validarXML($XML);
		
		if($resultado["errores"])
		{
			$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=5,comentarios='".cv($resultado["arrErrores"])."' WHERE idFolio=".$idFactura;			
			$con->ejecutarConsulta($consulta);
			echo "1|";
		}
		else
		{
			$t=new cFDIFinkok();	
			if($t->timbrarComprobante($idComprobante))
			{
				echo "1|";

			}
			else
			{
				echo "1|";
			}
			
		}
		
	}
	
	
	function obtenerIDComprobanteVenta()
	{
		global $con	;
		$idVenta=$_POST["idVenta"];
		$consulta="SELECT idFactura FROM 6008_ventasCaja WHERE idVenta=".$idVenta;
		$idFactura=$con->obtenerValor($consulta);
		echo "1|".$idFactura;
	}
	
	function buscarClaveAutorizacion()
	{
		global $con;
		$cve=bD($_POST["cve"]);
		$consulta="SELECT COUNT(*) FROM 807_usuariosVSRoles r,800_usuarios u WHERE  u.password='".cv($cve)."' AND r.idUsuario=u.idUsuario AND  r.idRol=66";
		$res=$con->obtenerValor($consulta);
		echo "1|".$res;
	}
	
	function obtenerExistenciaProductoCaja()
	{
		global $con;
		$idProducto=$_POST["idProducto"];
		$llave=$_POST["llave"];
		$consulta="SELECT idAlmacen FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
		$idAlmacen=$con->obtenerValor($consulta);
		
		$c=new cAlmacen($idAlmacen);
		$dimensiones=convertirLlaveDimensiones($llave);	
		$existencia=$c->obtenerCantidadTiempoMovimiento($idProducto,4,$dimensiones);
		echo "1|".$existencia;
		
	}
	
	function obtenerNombreTipoCliente()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];	
		$tipoCliente=$_POST["tipoCliente"];
		$consulta="";
		switch($tipoCliente)	
		{
			case 2: //Alumno
				$consulta="SELECT CONCAT(IF(paterno IS NULL,'',paterno),' ',IF(materno IS NULL,'',materno),' ',IF(nombre IS NULL,'',nombre)) AS cliente FROM alumno where id=".$idRegistro;
			break;	
			case 3: //Empleado
				$consulta="SELECT CONCAT(IF(Paterno IS NULL,'',Paterno),' ',IF(Materno IS NULL,'',Materno),' ',IF(Nom IS NULL,'',Nom)) AS cliente FROM 802_identifica where idUsuario where idUsuario=".$idRegistro;
			break;	
		}
		$nombre=$con->obtenerValor($consulta);
		echo "1|".$nombre;
		
	}
	
	
	function obtenerVentasCliente()
	{
		global $con;
		
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$tipoCliente=$_POST["tipoCliente"];
		$idCliente=$_POST["idCliente"];
		
		$condWhere="1=1";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		
		
		$consulta="select * from(SELECT idVenta,date_format(fechaVenta,'%Y-%m-%d') as fechaVenta,folioVenta,formaPago,total,if(idFactura is null,'0','1') as idFactura FROM 6008_ventasCaja 
					WHERE tipoCliente=".$tipoCliente." AND idCliente=".$idCliente.") as tmp where 1=1 and ".$condWhere." ORDER BY fechaVenta DESC,folioVenta ASC limit ".$start.",".$limit;
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		$consulta="SELECT count(*) FROM 6008_ventasCaja WHERE tipoCliente=".$tipoCliente." AND idCliente=".$idCliente." and 1=1 and ".$condWhere;
		$numReg=$con->obtenerValor($consulta);
		
		echo '{"numReg":"'.$numReg.'","registros":'.$registros.'}';
		
		
	}
	
	function obtenerAbonosPedido()
	{
		global $con;
		$idVenta=-1;
		if(isset($_POST["idVenta"]))
		{
			$idVenta=$_POST["idVenta"];
			$consulta="SELECT idAdeudo FROM 6942_adeudos WHERE tipoAdeudo=2 AND idReferencia=".$idVenta;
			$idAdeudo=$con->obtenerValor($consulta);
		}
		if(isset($_POST["idAdeudo"]))
			$idAdeudo=$_POST["idAdeudo"];
		$consulta="SELECT idControlPago AS idAbono,fechaAbono,montoAbono,formaPago,idComprobante FROM 6936_controlPagos WHERE idAdeudo=".$idAdeudo;
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';	
	}
	
	function generarFacturaPublicoGeneral()
	{
		global $con;	
		$fInicio=$_POST["fInicio"];
		$fFin=$_POST["fFin"];
		$idEmpresaEmisor=$_POST["idEmpresaEmisor"];
		$idCertificado=$_POST["idCertificado"];
		$idSerie=$_POST["idSerie"];
		$listaFormasPago=$_POST["listaFormasPago"];
		if($listaFormasPago=="")
			$listaFormasPago=-1;
		$consulta="SELECT horasFacturacion,facturaIndividual,leyendaFactura FROM _1025_tablaDinamica";
		$fConfiguracion=$con->obtenerPrimeraFila($consulta);
		$fechaActual=date("Y-m-d H:i:s");

		$fechaLimiteFacturacion=strtotime("-".$fConfiguracion[0]." hours",strtotime($fechaActual));
		
//		$consulta="SELECT idVenta FROM 6008_ventasCaja WHERE idFactura IS NULL AND fechaVenta<='".date("Y-m-d H:i:s",$fechaLimiteFacturacion)."' AND formaPago IN (".$listaFormasPago.")";
		$consulta="SELECT idVenta FROM 6008_ventasCaja WHERE idFactura IS NULL AND fechaVenta>='".$fInicio."' and fechaVenta<='".$fFin." 23:59:59' AND formaPago IN (".$listaFormasPago.")";
		$res=$con->obtenerFilas($consulta);
		
		if($fConfiguracion[1]==1)
		{
			while($fila=mysql_fetch_row($res))
			{
				$idEmpresa=$idEmpresaEmisor;
				$objFactura=generarXMLVentaCajaGeneral($idVenta,0,$idEmpresa,$idCertificado,$idSerie,true);
				
				$oFactura=new cFacturaCFDI();
				$oFactura->setObjFactura($objFactura);
				
				$XMLFactura=$oFactura->generarXML();
				$idFactura="";
				
				$idFactura=$oFactura->registrarXML(4,$idVenta);
				
				$oFactura->generarSelloDigital($idFactura);
				$XML=$oFactura->cargarComprobanteXML($idFactura);
				$resultado=$oFactura->validarXML($XML);
				if($resultado["errores"])
				{
					$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=5,comentarios='".cv($resultado["arrErrores"])."' WHERE idFolio=".$idFactura;			
					$con->ejecutarConsulta($consulta);
					echo "1|2";
				}
				else
				{
					$t=new cFDIFinkok();	
					if($t->timbrarComprobante($idFactura))
					{
						echo "1|1";
		
					}
					else
					{
						echo "1|2";
					}
					
				}
					
			}
		}
		else
		{
			$totalSubtotal=0;
			$totalIVA=0;
			$listaVentas="";
			$idVenta=-1;
			while($fila=mysql_fetch_row($res))
			{
				$resVenta=obtenerValoresVenta($fila[0]);
				
				$totalSubtotal+=$resVenta["subtotal"];
				$totalIVA+=$resVenta["iva"];
				if($listaVentas=="")
					$listaVentas=$fila[0];
				else
					$listaVentas.=",".$fila[0];
				$idVenta=$fila[0];
				
			}
			
			if($listaVentas!="")
			{
				$idEmpresa=$idEmpresaEmisor;
				$objFactura=generarXMLVentaPublicoGeneral(0,$idEmpresa,$idCertificado,$idSerie,true,$totalSubtotal,$totalIVA,$fConfiguracion[2]);
				
				$oFactura=new cFacturaCFDI();
				$oFactura->setObjFactura($objFactura);
				
				$XMLFactura=$oFactura->generarXML();
				$idFactura="";
				
				$idFactura=$oFactura->registrarXML(4,$idVenta);
				
				$oFactura->generarSelloDigital($idFactura);
				$XML=$oFactura->cargarComprobanteXML($idFactura);
				$resultado=$oFactura->validarXML($XML);
				
			
				if($resultado["errores"])
				{
					$x=0;
					$query[$x]="begin";
					$x++;
					$query[$x]="UPDATE 6008_ventasCaja SET idFactura=".$idFactura." WHERE idVenta IN (".$listaVentas.")";
					$x++;
					$query[$x]="UPDATE 703_relacionFoliosCFDI SET situacion=5,comentarios='".cv($resultado["arrErrores"])."' WHERE idFolio=".$idFactura;			
					$x++;
					$query[$x]="commit";
					$x++;
					$con->ejecutarConsulta($consulta);
					echo "1|2";
				}
				else
				{
					$t=new cFDIFinkok();	
					if($t->timbrarComprobante($idFactura))
					{
						$x=0;
						$query[$x]="begin";
						$x++;
						$query[$x]="UPDATE 6008_ventasCaja SET idFactura=".$idFactura." WHERE idVenta IN (".$listaVentas.")";
						$x++;
						$query[$x]="commit";
						$x++;
						
						if($con->ejecutarBloque($query))
							echo "1|1";
		
					}
					else
					{
						echo "1|2";
					}
					
				}
				
			}
			else
				echo "1|1";
				
			
			
			
		}
		
		
	}
	
	function registrarFirmaManifiestoEmpresa()
	{
		global $con;
		$idEmpresa=$_POST["idEmpresa"];	
		$consulta="UPDATE 6927_empresas SET situacionManifiesto=2 WHERE idEmpresa=".$idEmpresa;
		eC($consulta);
	}
	
	function obtenerCostoServiciosPorConcepto()
	{
		global $con;
		$plantel=$_POST["plantel"];
		$ciclo=$_POST["ciclo"];
		$periodo=$_POST["periodo"];
		
		$consulta="SELECT idReferencia FROM _464_gridPeriodos WHERE id__464_gridPeriodos=".$periodo;
		$idPeriodicidad=$con->obtenerListaValores($consulta);
		
		$idConcepto=$_POST["idConcepto"];
		$arrDimensiones=array();
		$consulta="SELECT nivelCosteo,consideraFechaVencimiento,perfilCosteo FROM 561_conceptosIngreso WHERE idConcepto=".$idConcepto;
		$fConceptoIngreso=$con->obtenerPrimeraFila($consulta);
		$nivelCosteo=$fConceptoIngreso[0];
		$fechaVencimiento=$fConceptoIngreso[1];
		$perfilCosteo=$fConceptoIngreso[2];
		
		switch($nivelCosteo)
		{
			case 1:
					$o["idProgramaEducativo"]=-1;
					$o["programaEducativo"]="";
					$o["idPlanEstudios"]=-1;
					$o["planEstudios"]="";
					$o["idGrado"]="-1";
					$o["grado"]="";
					
					$consulta="SELECT valor FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND 
							 idConcepto=".$idConcepto." AND idCiclo=".$ciclo." AND idPeriodo=".$periodo;
					$costo=$con->obtenerValor($consulta);
					if($costo=="")
						$costo=0;
					$o["costo"]=$costo;
					array_push($arrDimensiones,$o);			
						
			break;
			case 2:
				$consulta="SELECT DISTINCT pe.idProgramaEducativo,pe.nombreProgramaEducativo FROM 4513_instanciaPlanEstudio i,4500_planEstudio p,4500_programasEducativos pe 
						WHERE sede='".$plantel."' AND i.idPlanEstudio=p.idPlanEstudio AND pe.idProgramaEducativo=p.idProgramaEducativo and i.idPeriodicidad=".$idPeriodicidad."  
						and i.situacion=1 ORDER BY pe.nombreProgramaEducativo";

				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$o["idProgramaEducativo"]=$fila[0];
					$o["programaEducativo"]=$fila[1];
					$o["idPlanEstudios"]=-1;
					$o["planEstudios"]="";
					$o["idGrado"]="-1";
					$o["grado"]="";
					
					$consulta="SELECT valor FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$o["idProgramaEducativo"]." AND 
							 idConcepto=".$idConcepto." AND idCiclo=".$ciclo." AND idPeriodo=".$periodo;
					$costo=$con->obtenerValor($consulta);
					if($costo=="")
						$costo=0;
					$o["costo"]=$costo;
					array_push($arrDimensiones,$o);
				}
				
			
			break;
			case 3:
				$consulta="SELECT DISTINCT pe.idProgramaEducativo,pe.nombreProgramaEducativo,i.idInstanciaPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p,4500_programasEducativos pe 
						WHERE sede='".$plantel."' AND i.idPlanEstudio=p.idPlanEstudio AND pe.idProgramaEducativo=p.idProgramaEducativo and i.idPeriodicidad=".$idPeriodicidad."   
						and i.situacion=1 ORDER BY pe.nombreProgramaEducativo,i.nombrePlanEstudios";

				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$o["idProgramaEducativo"]=$fila[0];
					$o["programaEducativo"]=$fila[1];
					
					$o["idPlanEstudios"]=$fila[2];
					$nInstancia=obtenerNombreInstanciaPlan($fila[2]);

					$nInstancia=str_replace("Modalidad:","<span style='color:#900'><b>Modalidad:</b></span>",$nInstancia);
					$nInstancia=str_replace("Turno:","<span style='color:#900'><b>Turno:</b></span>",$nInstancia);
					$o["planEstudios"]=$nInstancia;
					$o["idGrado"]="-1";
					$o["grado"]="";
					
					
					$consulta="SELECT valor FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$o["idProgramaEducativo"]." AND idInstanciaPlanEstudio=".$fila[2]."
							 and idConcepto=".$idConcepto." AND idCiclo=".$ciclo." AND idPeriodo=".$periodo;
					$costo=$con->obtenerValor($consulta);
					if($costo=="")
						$costo=0;
					$o["costo"]=$costo;
					
					
					
					array_push($arrDimensiones,$o);
				}
				
			break;
			case 4:
				$consulta="SELECT DISTINCT pe.idProgramaEducativo,pe.nombreProgramaEducativo,i.idInstanciaPlanEstudio,i.idPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p,4500_programasEducativos pe 
						WHERE sede='".$plantel."' AND i.idPlanEstudio=p.idPlanEstudio AND pe.idProgramaEducativo=p.idProgramaEducativo and i.idPeriodicidad=".$idPeriodicidad."  
						 and i.situacion=1 ORDER BY pe.nombreProgramaEducativo,i.nombrePlanEstudios";

				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$o["idProgramaEducativo"]=$fila[0];
					$o["programaEducativo"]=$fila[1];
					
					$o["idPlanEstudios"]=$fila[2];
					$nInstancia=obtenerNombreInstanciaPlan($fila[2]);

					$nInstancia=str_replace("Modalidad:","<span style='color:#900'><b>Modalidad:</b></span>",$nInstancia);
					$nInstancia=str_replace("Turno:","<span style='color:#900'><b>Turno:</b></span>",$nInstancia);
					$o["planEstudios"]=$nInstancia;
					
					$consulta="SELECT idGrado FROM 4546_estructuraPeriodo WHERE idCiclo=".$ciclo." AND idPeriodo=".$periodo." AND idInstanciaPlanEstudio=".$fila[2];
					$listGrado=$con->obtenerListaValores($consulta);
					if($listGrado=="")
						$listGrado=-1;
					
					
					$consulta="SELECT idEstructuraCurricular,upper(g.leyendaGrado) FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$fila[3].
							" and nivel=1 AND tipoUnidad=3 and g.idGrado in (".$listGrado.") ORDER BY  ordenGrado";
					$resMateria=$con->obtenerFilas($consulta);
					while($filaGrado=mysql_fetch_row($resMateria))
					{
						
					
						$o["idGrado"]=$filaGrado[0];
						$o["grado"]=$filaGrado[1];
						
						
						$consulta="SELECT valor FROM 6011_costoConcepto WHERE plantel='".$plantel."' AND idProgramaEducativo=".$o["idProgramaEducativo"]." AND idInstanciaPlanEstudio=".$fila[2]."
								 and grado=".$o["idGrado"]." and idConcepto=".$idConcepto." AND idCiclo=".$ciclo." AND idPeriodo=".$periodo;
						$costo=$con->obtenerValor($consulta);
						if($costo=="")
							$costo=0;
						$o["costo"]=$costo;
						
						
						
						array_push($arrDimensiones,$o);
					}
				}
			
			break;
			
		}
		
		$arrRegistros="";
		$nReg=0;
		foreach($arrDimensiones as $c)
		{
			
			$llave=$plantel."_".$c["idProgramaEducativo"]."_".$c["idPlanEstudios"]."_".$c["idGrado"]."_".$idConcepto;
			$obj='{"id":"'.$llave.'","idProgramaEducativo":"'.$c["idProgramaEducativo"].'","programaEducativo":"'.cv($c["programaEducativo"]).'","idPlanEstudios":"'.$c["idPlanEstudios"].
					'","planEstudios":"'.cv($c["planEstudios"]).'","idGrado":"'.$c["idGrado"].'","grado":"'.cv($c["grado"]).'","costo":"'.$c["costo"].'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$nReg++;
		}
		
		echo '{"numReg":"'.$nReg.'","fechaVencimiento":"'.$fechaVencimiento.'","nivelCosteo":"'.$nivelCosteo.'","perfilCosteo":"'.$perfilCosteo.'","registros":['.$arrRegistros.']}';
		
		
	}
	
	function obtenerPlanEstudioDisponiblesModuloPromociones()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT idInstanciaPlan FROM 3011_planesEstudioDescuentosPromociones WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$listInstancias=$con->obtenerListaValores($consulta);
		if($listInstancias=="")
			$listInstancias=-1;
		
		switch($idFormulario)
		{
			case "1057":
				$consulta="SELECT idInstanciaPlanEstudio,e.nombreProgramaEducativo FROM 4513_instanciaPlanEstudio i,4500_planEstudio p,4500_programasEducativos e 
							WHERE p.idPlanEstudio=i.idPlanEstudio AND e.idProgramaEducativo=p.idProgramaEducativo and i.situacion=1
							and idInstanciaPlanEstudio not in (".$listInstancias.")";
			break;
			case "1058":
				$consulta="SELECT idPeriodo FROM 3014_pluginPeriodos WHERE idFormulario=".$idFormulario." and idReferencia=".$idRegistro;
				$lPeriodos=$con->obtenerListaValores($consulta);
				
				if($lPeriodos=="")
					$lPeriodos=-1;
				
				$consulta="SELECT idReferencia FROM  _464_gridPeriodos WHERE id__464_gridPeriodos IN(".$lPeriodos.")";
				$tPeriodicidad=$con->obtenerListaValores($consulta);
				
				if($tPeriodicidad=="")
					$tPeriodicidad=-1;
				
				$consulta="SELECT idInstanciaPlanEstudio,e.nombreProgramaEducativo FROM 4513_instanciaPlanEstudio i,4500_planEstudio p,4500_programasEducativos e 
							WHERE idPeriodicidad IN (".$tPeriodicidad.") AND p.idPlanEstudio=i.idPlanEstudio AND e.idProgramaEducativo=p.idProgramaEducativo and i.situacion=1
							and idInstanciaPlanEstudio not in (".$listInstancias.")";			
			

			
			break;
		}
		
		$numReg=0;
		$res=$con->obtenerFilas($consulta);
		
		$arrRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			$nInstancia=obtenerNombreInstanciaPlan($fila[0]);

			$nInstancia=str_replace("Modalidad:","<span style='color:#900'><b>Modalidad:</b></span>",$nInstancia);
			$nInstancia=str_replace("Turno:","<span style='color:#900'><b>Turno:</b></span>",$nInstancia);
			$o='{"programaEducativo":"'.$fila[1].'","idPlanEstudios":"'.$fila[0].'","planEstudios":"'.cv($nInstancia).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function registrarPlanesEstudioModuloPromociones()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($obj->arrInstancias as $o)
		{
			$query[$x]="INSERT INTO 3011_planesEstudioDescuentosPromociones(idFormulario,idReferencia,idInstanciaPlan) VALUES(".$obj->idFormulario.",".$obj->idReferencia.",".$o->idInstancia.")";
			$x++;
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function obtenerPlanesEstudioModuloPromociones()
	{
		global $con;	
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		
		$consulta="SELECT idInstanciaPlan FROM 3011_planesEstudioDescuentosPromociones WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$listInstancias=$con->obtenerListaValores($consulta);
		if($listInstancias=="")
			$listInstancias=-1;
		$consulta="SELECT idInstanciaPlanEstudio,e.nombreProgramaEducativo,p.idPlanEstudio,e.idProgramaEducativo FROM 4513_instanciaPlanEstudio i,4500_planEstudio p,4500_programasEducativos e 
							WHERE p.idPlanEstudio=i.idPlanEstudio AND e.idProgramaEducativo=p.idProgramaEducativo
							and idInstanciaPlanEstudio in (".$listInstancias.")";
		
		
		$numReg=0;
		$res=$con->obtenerFilas($consulta);
		
		$arrRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			$nInstancia=obtenerNombreInstanciaPlan($fila[0]);

			$nInstancia=str_replace("Modalidad:","<span style='color:#900'><b>Modalidad:</b></span>",$nInstancia);
			$nInstancia=str_replace("Turno:","<span style='color:#900'><b>Turno:</b></span>",$nInstancia);
			
			$consulta="SELECT idEstructuraCurricular,upper(g.leyendaGrado),g.ordenGrado FROM 4505_estructuraCurricular e, 4501_Grado g WHERE g.idGrado=e.idUnidad AND e.idPlanEstudio=".$fila[2].
							" and nivel=1 AND tipoUnidad=3  ORDER BY  ordenGrado";//and g.idGrado in (".$listGrado.")
			$resMateria=$con->obtenerFilas($consulta);
			while($filaGrado=mysql_fetch_row($resMateria))
			{
				$arrComp="";
				
				switch($idFormulario)
				{
					case 1057:
						$consulta="SELECT c.idConcepto,c.nombreConcepto FROM _1057_gConceptoIngreso g,561_conceptosIngreso c WHERE idReferencia=".$idRegistro." AND c.idConcepto=g.conceptoIngreso ORDER BY g.id__1057_gConceptoIngreso";
					break;
					case 1058:
						$consulta="SELECT c.idConcepto,c.nombreConcepto FROM _1058_gConceptosIngresos g,561_conceptosIngreso c WHERE idReferencia=".$idRegistro." AND c.idConcepto=g.conceptoIngreso ORDER BY g.id__1058_gConceptosIngresos";
					break;
					
				}
				
				$resConcepto=$con->obtenerFilas($consulta);
				while($filaConcepto=mysql_fetch_row($resConcepto))
				{
					$query="SELECT idPerfilDescuento FROM 3012_gradosPlanesEstudioDescuento WHERE idFormulario=".$idFormulario.
							" AND idReferencia=".$idRegistro." AND idInstanciaPlan=".$fila[0]." AND idGrado=".$filaGrado[0].
							" AND idConcepto=".$filaConcepto[0];

					$valor=$con->obtenerValor($query);
				
					$arrComp.=',"c_'.$filaConcepto[0].'":"'.$valor.'"';
				}
				
				$o='{"idProgramaEducativo":"'.$fila[3].'","programaEducativo":"'.$fila[1].'","idPlanEstudios":"'.$fila[0].'","planEstudios":"'.cv($nInstancia).'","idGrado":"'.$filaGrado[0].'","grado":"'.cv($filaGrado[1]).'","ordinalGrado":"'.$filaGrado[2].'"'.$arrComp.'}';
				if($arrRegistros=="")
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
			}
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerPlanesEstudioModuloPromocionesRemover()
	{
		global $con;	
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT idInstanciaPlan FROM 3011_planesEstudioDescuentosPromociones WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;
		$listInstancias=$con->obtenerListaValores($consulta);
		if($listInstancias=="")
			$listInstancias=-1;
		$consulta="SELECT idInstanciaPlanEstudio,e.nombreProgramaEducativo,p.idPlanEstudio FROM 4513_instanciaPlanEstudio i,4500_planEstudio p,4500_programasEducativos e 
							WHERE p.idPlanEstudio=i.idPlanEstudio AND e.idProgramaEducativo=p.idProgramaEducativo
							and idInstanciaPlanEstudio in (".$listInstancias.")";
		
		
		$numReg=0;
		$res=$con->obtenerFilas($consulta);
		
		$arrRegistros="";
		while($fila=mysql_fetch_row($res))
		{
			$nInstancia=obtenerNombreInstanciaPlan($fila[0]);

			$nInstancia=str_replace("Modalidad:","<span style='color:#900'><b>Modalidad:</b></span>",$nInstancia);
			$nInstancia=str_replace("Turno:","<span style='color:#900'><b>Turno:</b></span>",$nInstancia);
			
			
			$o='{"programaEducativo":"'.$fila[1].'","idPlanEstudios":"'.$fila[0].'","planEstudios":"'.cv($nInstancia).'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function removerPlanesEstudioModuloPromociones()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		foreach($obj->arrInstancias as $o)
		{
			$query[$x]="delete from 3011_planesEstudioDescuentosPromociones where idFormulario=".$obj->idFormulario." and idReferencia=".$obj->idReferencia." and idInstanciaPlan=".$o->idInstancia;
			$x++;
			$query[$x]="delete from 3012_gradosPlanesEstudioDescuento where idFormulario=".$obj->idFormulario." and idReferencia=".$obj->idReferencia." and idInstanciaPlan=".$o->idInstancia;
			$x++;
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function registrarPerfilDescuento()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		foreach($obj->arrPerfil as $f)
		{
			$o="[\'".$f->descuento."\',\'".$f->fechaDescuento."\']";
			if($arrDescuentos=="")
				$arrDescuentos=$o;	
			else
				$arrDescuentos.=",".$o;	
		}
		$objComp='{"arrDescuentos":['.$arrDescuentos.']}';
		
		$consulta="";
		if($obj->idPerfil==-1)
		{
			$consulta="INSERT INTO 3013_perfilesDescuento(nombrePerfil,idFormulario,idReferencia,objComp) VALUES('".cv($obj->nombrePerfil)."',".$obj->idFormulario.",".$obj->idReferencia.",'".$objComp."')";
		}
		else
		{
			$consulta="update 3013_perfilesDescuento set nombrePerfil='".cv($obj->nombrePerfil)."',objComp='".$objComp."' where idRegistro=".$obj->idPerfil;
		}
		
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="select idRegistro,nombrePerfil,objComp from 3013_perfilesDescuento where idFormulario=".$obj->idFormulario." and idReferencia=".$obj->idReferencia;
			$arrPerfiles=$con->obtenerFilasArreglo($consulta);
			echo "1|".$arrPerfiles;
		}
		
	}
	
	function registrarPerfilDescuentoGrado()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		if($obj->idPerfilDescuento=="")
			$obj->idPerfilDescuento="NULL";
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->arrGrados as $g)
		{
			$query="SELECT idRegistro FROM 3012_gradosPlanesEstudioDescuento WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia." 
					AND idInstanciaPlan=".$g->idPlanEstudio." AND idGrado=".$g->idGrado." AND idConcepto=".$obj->idConcepto;
			$idRegistro=$con->obtenerValor($query);		
			if($idRegistro=="")
			{
				$consulta[$x]="INSERT INTO 3012_gradosPlanesEstudioDescuento(idFormulario,idReferencia,idInstanciaPlan,idGrado,idConcepto,idPerfilDescuento)
								VALUES(".$obj->idFormulario.",".$obj->idReferencia.",".$g->idPlanEstudio.",".$g->idGrado.",".$obj->idConcepto.
								",".$obj->idPerfilDescuento.")";
			}
			else
			{
				$consulta[$x]="UPDATE 3012_gradosPlanesEstudioDescuento SET idPerfilDescuento=".$obj->idPerfilDescuento." WHERE idRegistro=".$idRegistro;
			}
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function removerPerfilDescuento()
	{
		global $con;
		$idPerfil=$_POST["idPerfil"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 3013_perfilesDescuento WHERE idRegistro=".$idPerfil;
		$x++;
		$consulta[$x]="DELETE FROM 3012_gradosPlanesEstudioDescuento WHERE idPerfilDescuento=".$idPerfil;
		$x++;
		
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	
	function cancelarVentaCaja()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT COUNT(*) FROM 800_usuarios WHERE idUsuario=".$obj->autorizacion." AND PASSWORD='".cv($obj->password)."'";
		$nReg=$con->obtenerValor($consulta);
		
		if($nReg>0)
		{
			$consulta="UPDATE 6008_ventasCaja SET situacion=2,idUsrCancelo=".$_SESSION["idUsr"].",fechaCancelacion='".date("Y-m-d H:i:s")."',motivoCancelacion='".cv($obj->motivo)."',idCancelacionAutorizada=".$obj->autorizacion." WHERE idVenta=".$obj->idVenta;	
			if($con->ejecutarConsulta($consulta))
			{
				$consulta="SELECT idFactura FROM 6008_ventasCaja WHERE idVenta=".$obj->idVenta;	
				$idComprobante=$con->obtenerValor($consulta);
				if(($idComprobante!="")&&($idComprobante!="-1"))
				{
					$consulta="SELECT situacion FROM 703_relacionFoliosCFDI WHERE idFolio=".$idComprobante;
					$situacionComprobante=$con->obtenerValor($consulta);
					if($situacionComprobante==2)
					{
						$t=new cFDIFinkok();	
						$motivo=$obj->motivo;
						$t->cancelarComprobante($idComprobante,$motivo);		
					}

				}
				
				
				echo "1|1";
			}
			
		}
		else
		{
			echo "1|0";	
		}
		
		
	}
	
	function retimbrarComprobanteFactura()
	{
		global $con;
		$idComprobante=$_POST["iC"];
		
		$c=new cFacturaCFDI();
	
		
		
			
		$consulta="SELECT idReferencia,idCertificado,idSerie,(SELECT idReferencia FROM 687_certificadosSelloDigital WHERE idCertificado=r.idCertificado),idClienteFactura FROM 
				703_relacionFoliosCFDI r WHERE idFolio=".$idComprobante;
		
		$fComprobante=$con->obtenerPrimeraFila($consulta);
		
		
		$idEmpresa=$fComprobante[3];
		$idCertificado=$fComprobante[1];
		$idSerie=$fComprobante[2];
		$idVenta=$fComprobante[0];
		
		$consulta="SELECT * FROM 706_comprobanteFactura WHERE idComprobanteFactura=".$idVenta;
		
		$fComprobante=$con->obtenerPrimeraFila($consulta);
		$complemento=$fComprobante[29];
		
		$arrTotales="";
		$consulta="SELECT * FROM 709_impuestosRetencionesComprobante WHERE idComprobante=".$idVenta;
		$res=$con->obtenerFilas($consulta);
		while($f=mysql_fetch_row($res))
		{
			$o='{"etiqueta":"'.cv($f[6]).'","tipoConcepto":"'.$f[2].'","idConcepto":"'.$f[3].'","tasaConcepto":"'.$f[4].'","montoConcepto":"'.$f[5].'"}';
			if($arrTotales=="")
				$arrTotales=$o;
			else
				$arrTotales.=",".$o;
		}
		
		$arrConceptos="";
		$consulta="SELECT * FROM 707_conceptosFactura WHERE idComprobante=".$idVenta;
		$res=$con->obtenerFilas($consulta);
		while($f=mysql_fetch_row($res))
		{
			$o='{"clave":"'.cv($f[14]).'","cabecera":"'.cv($f[15]).'","idConcepto":"'.cv($f[2]).'","tipoConcepto":"1","descripcion":"'.cv($f[4]).
				'","unidadMedida":"'.cv($f[6]).'","costoUnitario":"'.cv($f[7]).'","descuentoUnitario":"'.cv($f[11]).'","cantidad":"'.cv($f[5]).
				'","subtotal":"'.cv($f[8]).'","iva":"'.cv($f[10]).'","tasaIVA":"'.cv($f[9]).'","total":"'.cv($f[13]).'","descuentoTotal":"'.cv($f[12]).'"}';
			if($arrConceptos=="")
				$arrConceptos=$o;
			else
				$arrConceptos.=",".$o;
		}
		
		
		
		$cObjComplemento="";
		
		switch($complemento)
		{
			case 1:

				
				
				$consulta="SELECT noNotaria,curp,entidadFederativa,adscripcion FROM _1026_tablaDinamica WHERE empresa=".$idEmpresa;
				$fDatosNotaria=$con->obtenerPrimeraFila($consulta);
				
				
				$arrDatosInmueble="";
				$consulta="SELECT * FROM 725_inmueblesComplementoNotario WHERE idComprobante=".$idVenta;
			
				$res=$con->obtenerFilas($consulta);
				while($f=mysql_fetch_row($res))
				{
					$oAux='{"idTipoInmueble":"'.$f[2].'","calle":"'.cv($f[3]).'","noExterior":"'.cv($f[4]).'","noInterior":"'.cv($f[5]).'","colonia":"'.cv($f[6]).'","localidad":"'.cv($f[7]).
							'","referencia":"'.cv($f[8]).'","municipio":"'.cv($f[9]).'","estado":"'.cv($f[10]).'","pais":"'.cv($f[11]).'","cp":"'.$f[12].'"}';
					if($arrDatosInmueble=="")
						$arrDatosInmueble=$oAux;
					else
						$arrDatosInmueble.=",".$oAux;
				}
				
				$arrDatosEnajenante="";
				
				$consulta="SELECT (nombre),(apellidoPaterno),(apellidoMaterno),UPPER(rfc),UPPER(curp),porcentaje,tipoPersona FROM 726_involucradosComplementoNotario 
							WHERE idComprobante=".$idVenta." AND tipoInvolucrado=1";
				$res=$con->obtenerFilas($consulta);
				while($f=mysql_fetch_row($res))
				{
					$oAux='{"apPaterno":"'.cv($f[1]).'","apMaterno":"'.cv($f[2]).'","nombre":"'.cv($f[0]).'","rfc":"'.cv($f[3]).'","curp":"'.cv($f[4]).'","tipoPersona":"'.$f[6].
							'","porcentaje":"'.cv($f[5]).'"}';
					if($arrDatosEnajenante=="")
						$arrDatosEnajenante=$oAux;
					else
						$arrDatosEnajenante.=",".$oAux;
				}
				
				$arrDatosAdquiriente="";
				
				
				$consulta="SELECT (nombre),(apellidoPaterno),(apellidoMaterno),UPPER(rfc),UPPER(curp),porcentaje,tipoPersona FROM 726_involucradosComplementoNotario 
							WHERE idComprobante=".$idVenta." AND tipoInvolucrado=2";
				$res=$con->obtenerFilas($consulta);
				while($f=mysql_fetch_row($res))
				{
					$oAux='{"apPaterno":"'.cv($f[1]).'","apMaterno":"'.cv($f[2]).'","nombre":"'.cv($f[0]).'","rfc":"'.cv($f[3]).'","curp":"'.cv($f[4]).'","tipoPersona":"'.$f[6].
							'","porcentaje":"'.cv($f[5]).'"}';
					if($arrDatosAdquiriente=="")
						$arrDatosAdquiriente=$oAux;
					else
						$arrDatosAdquiriente.=",".$oAux;
				}
				
				$consulta="SELECT * FROM 724_datosComplementoNotario WHERE idComprobante=".$idVenta;
				$fNotario=$con->obtenerPrimeraFila($consulta);
				
				$cObjComplemento=',"datosComplemento":{"incluirComplemento":"'.$fNotario[7].'","datosNotaria":{"noNotaria":"'.$fDatosNotaria[0].'","curpNotario":"'.$fDatosNotaria[1].'","entidadFederativa":"'.$fDatosNotaria[2].
								'","adscripcion":"'.cv($fDatosNotaria[3]).'"},"datosOperacion":{"noInstrumentoNotarial":"'.$fNotario[3].'","fechaInstrumentoNotarial":"'.$fNotario[2].'","subtotal":"'.
								$fNotario[5].'","iva":"'.$fNotario[6].'","total":"'.$fNotario[4].'"},"datosInmueble":['.$arrDatosInmueble.'],"tipoPropietario":"'.$fNotario[8].'","datosEnajenante":['.$arrDatosEnajenante.
								'],"tipoAdquiriente":"'.$fNotario[9].'","datosAdquiriente":['.$arrDatosAdquiriente.']}';
				
				
			break;
		}
		
		
		$cadObj='{"idEmpresa":"'.$idEmpresa.'","idCertificado":"'.$idCertificado.'","idSerie":"'.$idSerie.'","idCliente":"'.$fComprobante[4].'","fechaComprobante":"'.$fComprobante[5].'","lugarExpedicion":"'.cv($fComprobante[17]).'",
				"moneda":"'.$fComprobante[8].'","tipoCambio":"'.$fComprobante[9].'","formaPago":"'.$fComprobante[9].'","noParcialidad":"'.$fComprobante[11].'","totalParcialidad":"'.$fComprobante[12].
				'","condicionesPago":"'.cv($fComprobante[13]).'","metodoPago":"'.$fComprobante[14].'","metodoPagoEspecifique":"'.cv($fComprobante[15]).'","noCuenta":"'.cv($fComprobante[16]).'","complemento":"'.$fComprobante[29].
				'","tipoComprobante":"'.$fComprobante[1].'","motivoDescuento":"'.$fComprobante[23].'","comentariosAdicionales":"'.cv($fComprobante[21]).'","arrTotales":['.$arrTotales.'],"arrConceptos":['.$arrConceptos.']'.
				$cObjComplemento.'}';
		
		$obj=json_decode($cadObj);
		
		
		$oFactura=new cFacturaCFDI();
		$objFactura=generarObjetoComprobanteJSON($obj,true);
		
		
			
		$oFactura=new cFacturaCFDI();
		$oFactura->setObjFactura($objFactura);

		
		$XMLFactura=$oFactura->generarXML();

		$oFactura->actualizarXMLComprobante($idComprobante);
		
		$oFactura->generarSelloDigital($idComprobante);
		
		$XML=$oFactura->cargarComprobanteXML($idComprobante);
		
		$resultado=$oFactura->validarXML($XML);
		
		if($resultado["errores"])
		{
			$consulta="UPDATE 703_relacionFoliosCFDI SET situacion=5,comentarios='".cv($resultado["arrErrores"])."' WHERE idFolio=".$idFactura;			
			$con->ejecutarConsulta($consulta);
			echo "1|";
		}
		else
		{
			$t=new cFDIFinkok();	
			if($t->timbrarComprobante($idComprobante))
			{
				echo "1|";

			}
			else
			{
				echo "1|";
			}
			
		}
		
		
	}
	
	function registrarVentaCajaV2()
	{
		global $con;		
		$numDias=60;
		$oTesoreria=new cTesoreria();
		$idCaja=$_POST["idCaja"];
		$tipoOperacion=$_POST["tipoOperacion"];//1 Venta, 2 Pedido
		$arrDevoluciones=array();
		$arrApartados=array();	
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT p.*,i.idAlmacenAsociado from 6007_instanciasCaja i,6006_perfilesCaja p WHERE p.idPerfilCaja=i.idPerfilCaja AND idCaja=".$idCaja;
		$fCaja=$con->obtenerPrimeraFila($consulta);	
		$idFuncionCatalogoProducto=$fCaja[3];
		$idFuncionVentaProducto=$fCaja[4];
		if($idFuncionVentaProducto=="")
			$idFuncionVentaProducto=-1;			
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$query[$x]="INSERT INTO 6008_ventasCaja(fechaVenta,idResponsableVenta,idCaja,situacion,subtotal,iva,total,formaPago,datosCompra,tipoCliente,idCliente,totalDescuento,idAlmacen)
					VALUES('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$idCaja.",1,'".$obj->subtotal."','".$obj->iva."','".$obj->total."','".$obj->formaPago."','".dv($obj->datosCompra).
					"',".$obj->tipoCliente.",".$obj->idCliente.",".$obj->totalDescuento.",".$fCaja[14].")";
		$x++;
		
		$query[$x]="set @idVenta:=(select last_insert_id())";
		$x++;
		$folioVenta=generarNombreArchivoTemporal(1,"");
		$query[$x]="UPDATE 6008_ventasCaja SET folioVenta='".$folioVenta."' WHERE idVenta=@idVenta";
		$x++;
		
		
		foreach($obj->arrProductos as $p)
		{
			if($p->porcentajeIVA=="")
				$p->porcentajeIVA=0;
				
			
			$query[$x]="INSERT INTO 6009_productosVentaCaja(idVenta,idProducto,tipoProducto,cantidad,costoUnitario,subtotal,iva,claveProducto,total,tipoMovimiento,dimensiones,llave,
						porcentajeIVA,descuentoTotal,descuentoUnitario,metaData,descripcion,unidadMedida,costoUnitarioOriginal,productoConExistencia)
						VALUES(@idVenta,".$p->idProducto.",".$p->tipoConcepto.",".$p->cantidad.",".$p->costoUnitario.",".$p->subtotal.",".$p->iva.",'".$p->cveProducto."',".$p->total.",'".$p->tipoMovimiento.
						"','".bD($p->dimensiones)."','".$p->llave."',".$p->porcentajeIVA.",".$p->descuento.",".$p->descuentoUnitario.",'".cv($p->metaData)."','".cv($p->descripcion)."',
						".$p->unidadMedida.",".$p->costoUnitarioOriginal.",".$p->productoConExistencia.")";
			
			
			$x++;
						
			if($p->metaData!='')
			{
				$query[$x]="set @idProductoVenta:=(select last_insert_id())";
				$x++;
				$oMeta=json_decode($p->metaData);
				$reflectionClase = new ReflectionObject($oMeta);
				foreach ($reflectionClase->getProperties() as $property => $value) 
				{
					$nombre=$value->getName();
					$valor=$value->getValue($oMeta);
					$query[$x]="INSERT INTO 6010_productosVentaMetaData(idProductoVenta,campo,valor) VALUES(@idProductoVenta,'".cv($nombre)."','".cv($valor)."')";
					$x++;
				}
			}
			
			
		}
				
		foreach($obj->desgloceFormaPago as $fP)
		{
			$query[$x]	="INSERT INTO 6024_detalleFormaPagoVenta(idFormaPago,montoPago,idVenta,tipoVenta) VALUES(".$fP->formaPago.",".$fP->montoPago.",@idVenta,1)";
			$x++;
		}
		
		if(sizeof($obj->arrNotasCredito)>0)
		{
			foreach($obj->arrNotasCredito as $n)
			{
				$query[$x]="UPDATE 6947_notasCredito SET situacion=0,idTipoUsoMovimiento=1,idUsoMovimiento=@idVenta WHERE idNota=".$n->idNota;
				$x++;	
			}	
		}
		
		if($obj->montoNota>0)
		{
			$query[$x]="INSERT INTO 6947_notasCredito(fechaCreacion,total,idTipoOrigenMovimiento,idOrigenMovimiento,situacion,tipoCliente,idCliente)
							values('".date("Y-m-d H:i:s")."',".$obj->montoNota.",1,@idVenta,1,".$obj->tipoCliente.",".$obj->idCliente.")";
			$x++;
			$query[$x]="set @idNota:=(select last_insert_id())";
			$x++;
			$query[$x]="UPDATE 6947_notasCredito SET folioNota=idNota WHERE idNota=@idNota";
			$x++;
		}		
		
		
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			$queryID="select @idVenta";
			$idVenta=$con->obtenerValor($queryID);
			$datosCompra=json_decode($obj->datosCompra);
			
			
			if(isset($datosCompra->montoAdeudo)&&($datosCompra->montoAdeudo>0))
			{
				$cAdeudo=	'{
								"tipoAdeudo":"1",
								"idReferencia":"'.$idVenta.'",
								"subtotal":"'.$obj->subtotal.'",
								"iva":"'.$obj->iva.'",
								"total":"'.$obj->total.'",
								"tipoCliente":"'.$obj->tipoCliente.'",
								"idCliente":"'.$obj->idCliente.'",
								"fechaVencimiento":"'.$datosCompra->fechaVencimiento.'",
								"naturalezaAdeudo":"1" 
							}';							
							
				$oAdeudo=json_decode($cAdeudo);			
				
				$idAdeudo=$oTesoreria->registrarAdeudo($oAdeudo);
				
				if(isset($datosCompra->montoAbono)&&($datosCompra->montoAbono>0))
				{
				
					$cAbono=	'{
									"montoAbono":"",
									"idAdeudo":"",
									"formaPago":"",
									"datosComp":"",
									"idCaja":"",
									"tipoOperacion":"1",
									"comentarios":"",
									"idComprobante":"",
									"cobrado":"",
									"fechaCobro":""
								
								}';
								
					
					
					foreach($obj->desgloceFormaPago as $p)
					{
						$objAbono=json_decode($cAbono);
					
						$objAbono->idAdeudo=$idAdeudo;
						$objAbono->idCaja=$obj->idCaja;
						$objAbono->formaPago=$p->formaPago;
						$objAbono->montoAbono=$p->montoPago;
						
						if(isset($p->cobrado))
							$objAbono->cobrado=$p->cobrado;
						else
							$objAbono->cobrado=1;
						
						if(isset($p->fechaVencimiento))
							$objAbono->fechaCobro="'".$p->fechaVencimiento."'";
						
						
						$oTesoreria->registrarAbonoAdeudo($objAbono);		
					}
				}
			}
			
			if($idFuncionVentaProducto!=-1)
			{
				$cadObj='{"idCaja":"'.$idCaja.'","idVenta":"'.$idVenta.'","tipoOperacion":"'.$tipoOperacion.'"}';
				$obj=json_decode($cadObj);
				$cache=NULL;
				
				resolverExpresionCalculoPHP($idFuncionVentaProducto,$obj,$cache);	
			}
		
			echo "1|".$idVenta;
		}
		
		
	}
	
	function verificarExistenciaCostoProducto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		
		$cA=new cAlmacen($obj->idAlmacen);	
		
		$hayExistencia=0;
		$tPresupuestal=21; //Reemplazar
		$eExistencia=$cA->existeSuficienciaTiempoMovimientoV2($obj->idProducto,$obj->cantidad,$obj->unidadMedida,$tPresupuestal,convertirLlaveDimensiones($obj->llave));
		
		if($eExistencia)
		{
			$hayExistencia=1;
		}
		
		$consulta="SELECT idUnidadMedida FROM 6901_catalogoProductos WHERE idProducto=".$obj->idProducto;
		$unidadMedida=$con->obtenerValor($consulta);
		$precioUnitario=$obj->precioUnitario;
		if($obj->unidadMedida!=$unidadMedida)
		{
			$equivalencia=convertirUnidadesMedida(1,$unidadMedida,$obj->unidadMedida);	
			if($equivalencia==0)
			{
				$equivalencia=convertirUnidadesMedida(1,$obj->unidadMedida,$unidadMedida);	
				$op="*";
				if($equivalencia==0)
					$equivalencia=1;
			}
			else
				$op="/";
				
			if($op=="/")
				$precioUnitario=$precioUnitario/$equivalencia;		
			else
				$precioUnitario=$precioUnitario*$equivalencia;		
		}
		else
			$precioUnitario=$obj->precioUnitarioOriginal;
		
		
		
		$cResultado='{"eExistencia":"'.$hayExistencia.'","precioUnitario":"'.$precioUnitario.'"}';
		echo "1|".$cResultado;
		
	}
?>