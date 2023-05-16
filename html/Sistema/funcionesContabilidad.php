<?php session_start();
	include("conexionBD.php"); 
	
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
			obtenerCuentas();
		break;
		case 2;
			eliminarTipoCuenta();
		break;
		case 3;
			eliminarNaturalezaCuenta();
		break;
		case 4:
			eliminarCategoriaCuenta();
		break;
		case 5:
			eliminarGrupoContableNegocio();
		break;
		case 6:
			eliminarGrupoContableProducto();
		break;
		case 7:
			eliminarTipoIVA();
		break;
		case 8:
			eliminarTiposCategoriaCuenta();
		break;
		case 9:
			guardarConfiguracionCuentas();
		break;
		case 10:
			guardarDatosCuenta();
		break;
		case 11:
			obtenerCodigo();
		break;
		case 12:
			desActivarCuenta();
		break;
		case 13:
			activarCuenta();
		break;		
		case 14:
			removerCuenta();
		break;
		case 15:
			removerNivel();
		break;
		case 16:
			guardarConfiguracionObjGasto();
		break;
		case 17:
			guardarDatosObjGasto();
		break;
		case 18:
			obtenerCodigoObjGasto();
		break;
		case 19:
			desActivarObjGasto();
		break;
		case 20:
			activarObjGasto();
		break;
		case 21:
			removerObjGasto();
		break;
		case 23:
			obtenerObjGasto();
		break;
		
		//Funciones tipos presupuesto
		case 24:		
			 obtenerTipoPresupuesto();
		break;	
		case 25:
			  guardarDatosTipoPresupuesto();
		break;	
		case 26:
			  desActivarTipoPresupuesto();
		break;	
		case 27:	
			  activarTipoPresupuesto();
		break;	
		case 28:	
			  removerTipoPresupuesto();
		break;
		
		//Funciones centro costo
		case 29:		
			 obtenerCentroCosto();
		break;	
		case 30:
			  guardarDatosCentroCosto();
		break;	
		case 31:
			  desActivarCentroCosto();
		break;	
		case 32:	
			  activarCentroCosto();
		break;	
		case 33:	
			  removerCentroCosto();
		break;
		
		case 34:
			guardarLibro();
		break;
		case 35:
			obtenerLibros();
		break;
		case 36:
			abrirLibro();
		break;
		case 37:
			obtenerConfiguracionLibro();
		break;
		case 38:
			generarNuevoAsiento();
		break;
		case 39:
			obtenerAsientosLibro();
		break;
		case 40:
			obtenerFolioTipoDoc();
		break;
		case 41:
			actualizarCampoAsiento();
		break;
		case 42:
			obtenerObjGastoLibroDiario();
		break;
		case 43:
			obtenerCuentasLibroDiario();
		break;
		case 44:
			eliminarPrograma();
		break;
		case 45:
			guardarRegPOA();
		break;
		case 46:
			eliminarRegPOA();
		break;
		case 47:
			cambiarEtapaRegistroPOA();
		break;
		case 48:
			obtenerEstructurasCuenta();			
		break;
		case 49:
			guardarPresupuestoPatrocinador();			
		break;
		case 50:
			obtenerInstituciones();			
		break;
		case 51:
			guardarPatrocinadorProyecto();			
		break;
		case 52:
			crearInstitucionOrg2();			
		break;
		case 53:
			eliminarPatrocinador();			
		break;
		case 54:
			agregarObjetoGastos();			
		break;
		case 55:
			eliminarObjetoGastos();			
		break;
		case 56:
			obtenerDepertamentosPrograma();			
		break;
		case 57:
			obtenerDepertamentosInstitucion();			
		break;
		case 58:
			obtenerPartidasDepertamentos();			
		break;
		case 59:
			guardarDepartamentosPrograma();			
		break;
		case 60:
			eliminarDepartamentoPrograma();			
		break;
		case 61:
			obtenerPartidas();			
		break;
		case 62:
			guardarPartidasVSDeptos();			
		break;
		case 63:
			obtenerProgramas();			
		break;
		case 64:
			agregarProgramasCiclo();			
		break;
		case 65:
			eliminarProgramasCiclo();			
		break;
		case 66:
			eliminarPartidaDepto();			
		break;
		case 67:
			obtenerCalculosAplicadosNomina();
		break;
		case 68:
			guardarAcumulador();
		break;
		case 69:
			removerAcumulador();
		break;
		case 70:
			guardarAsignacionOperacion();
		break;
		case 71:
			removerAsignacionAcumulador();
		break;
		case 72:
			guardarConceptosNomina();
		break;
		case 73:
			guardarPuestosCalculosAsoc();
		break;
		case 74:
			removerPuestoCalculo();
		break;
		case 75:
			obtenerDefinicionFactor();
		break;
		case 76:
			eliminarUnidadDepto();
		break;
		case 77:
			obtenerDeptosDisponiblesFactor();
		break;
		case 78:
			guardarVinculacionDeptoFactor();
		break;
		case 79:
			obtenerPuestosDisponiblesFactor();
		break;
		case 80:
			guardarPuestoFactor();
		break;
		case 81:
			asignarValorTodosPuestos();
		break;
		case 82:
			removerAsignacionTodosPuestos();
		break;
		case 83:
			factorRiesgoUsuario();
		break;
		case 84:
			buscarUsuarioInstitucion();
		break;
		case 85:
			guardarUsuarioFactor();
		break;
		case 86:
			borrarUsuarioFactor();
		break;
		case 87:
			obtenerEtapasMovimiento();
		break;
		case 88:
			registrarMovimientoCuentaConciliacionBancaria();
		break;
		case 89:
			generarSerieAleatoria();
		break;
		case 90:
			obtenerQuincenasCiclo();
		break;
		case 91:
			historialQuincenasCicloUsuario();
		break;
		case 92:
			removerPatrocinador();
		break;
		case 93:
			obtenerInstitucionPatrocinadora();
		break;
		case 94:
			marcarPuedeComprar();
		break;
		case 95:
			marcarNoPuedeComprar();
		break;
		case 96:
			obtenerContraRecibos();
		break;
		case 97:
			obtenerObjetosGastoCapitulo();
		break;
		case 98:
			obtenerCuentasCheques();
		break;
		case 99:
			eliminarBanco();
		break;
		case 100:
			obtenerDatosConceptos();
		break;
		case 101:
			eliminarCuentaBancaria();
		break;
		case 102:
			obtenerAdeudosOrdenPago();
		break;
		case 103:
			obtenerAdeudosCliente();
		break;
		case 104:
			obtenerClientes();
		break;
		case 105:
			registrarPagoCaja();
		break;
		case 106:
			obtenerCuentasBancarias();
		break;
		case 107:
			obtenerHistorialMovimientosCuenta();
		break;
		case 108:
			removerConfiguracionContableMovimiento();
		break;
		case 109:
			buscarCuentaContable();
		break;
		case 110:
			obtenerCategoriasConceptoDisponibles();
		break;
		case 111:
			guardarConfiguracionMovimiento();
		break;
		case 112:
			removerConfiguracionFolio();
		break;
		case 113:	
			actualizarOrigenFolioMovimento();
		break;
		case 114:
			actualizarFuncionOrigenFolioMovimento();
		break;
		case 115:
			guardarConfiguracionAsientoMovimeinto();
		break;
		case 116:
			guardarConfiguracionAsientoPresupuestoMovimeinto();
		break;
	}
	
	function obtenerCuentas()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$consulta="select c.idCuenta,c.nivel,c.codigoCompletoCta,c.codigoUnidadCta,c.tituloCta,tc.tituloTipo,c.idTipoCta,nc.tituloNaturaleza,
					c.idNaturalezaCta,c.codigoCta,c.idTipoEntradaHijo,c.valorInicialHijo,c.incrementoHijo,c.estado,if(c.estado=1,'Activo','Inactivo') as 'lblEstado',
					c.descripcion,c.cuentaEquivalenteCicloAnterior,(select concat('[',codigoUnidadCta,'] ',tituloCta) FROM 510_cuentas WHERE codigoCta=c.cuentaEquivalenteCicloAnterior) as nombreCuentaEquivalente
					from 510_cuentas c,501_tiposCuenta tc,502_naturalezaCuenta nc
					where c.ciclo=".$ciclo." and nc.idNaturalezaCta=c.idNaturalezaCta and tc.idTipoCta=c.idTipoCta and c.nivel=1 order by codigoUnidadCta";


		$res=$con->obtenerFilas($consulta);

		$arrCtas="";
		$objCta="";
		while($f=mysql_fetch_row($res))
		{
			$hijos=obtenerCuentasHijas($f[9],($f[1]+1),$ciclo);
			
			if($hijos=="[]")
				$comp='"leaf":true,"icon":"../images/s16.png"';
			else
				$comp='"leaf":false,"children":'.$hijos;
				
			$objCta='	{
							"codigoCompCta":"'.$f[2].'",
							"descripcion":"'.$f[15].'",
							"codCuentaEquivalente":"'.$f[16].'",
							"lblCuentaEquivalente":"'.$f[17].'",
							"id":"'.$f[0].'",
							"qtip":"'.$f[15].'",
							"nivel":"'.$f[1].'",
							"codUnidad":"'.$f[3].'",
							"codigoCta":"'.$f[9].'",
							"fraccionCodUnidad":"'.$f[3].'",
							"codPadre":"",
							"removible":"1",
							"estado":"'.$f[13].'",
							"lblEstado":"'.$f[14].'",
							"titulo":"'.$f[4].'",
							"tipoCta":"'.$f[5].'",
							"idTipoCta":"'.$f[6].'",
							"naturaleza":"'.$f[7].'",
							"idNaturaleza":"'.$f[8].'",
							"idTipoEntradaHijo":"'.$f[10].'",
							"valorInicialHijo":"'.$f[11].'",
							"incrementoHijo":"'.$f[12].'",'.$comp.'
							
						}
					';
			
			if($arrCtas=="")
				$arrCtas=$objCta;
			else
				$arrCtas.=','.$objCta;
			
		}
		echo "[".uEJ($arrCtas)."]";
	}
	
	function obtenerCuentasHijas($codPadre,$nivel,$ciclo)
	{
		global $con;
		$consulta="select campo2 from 500_variablesSistema where tipo=1 and idCiclo=".$ciclo;
		$separador=$con->obtenerValor($consulta);
		$consulta="select longitudCodigo from 512_configuracionNiveles where idCatalogo=1 and nivel=".$nivel." and idCiclo=".$ciclo;
		$longitudCodigo=$con->obtenerValor($consulta);
		if($longitudCodigo=="")
			return "[]";
		$cadComodin=str_pad("",$longitudCodigo,'_',STR_PAD_LEFT);
		$consulta="select c.idCuenta,c.nivel,c.codigoCompletoCta,c.codigoUnidadCta,c.tituloCta,tc.tituloTipo,c.idTipoCta,nc.tituloNaturaleza,
					c.idNaturalezaCta,c.codigoCta,c.idTipoEntradaHijo,c.valorInicialHijo,c.incrementoHijo,c.estado,if(c.estado=1,'Activo','Inactivo') as 'lblEstado',
					c.descripcion,c.cuentaEquivalenteCicloAnterior,(select concat('[',codigoUnidadCta,'] ',tituloCta) FROM 510_cuentas WHERE codigoCta=c.cuentaEquivalenteCicloAnterior) as nombreCuentaEquivalente from 510_cuentas c,501_tiposCuenta tc,502_naturalezaCuenta nc
					where c.ciclo=".$ciclo." and nc.idNaturalezaCta=c.idNaturalezaCta and tc.idTipoCta=c.idTipoCta and c.nivel=".$nivel." and c.codigoCta like '".$codPadre."%' order by codigoUnidadCta";
		

		$res=$con->obtenerFilas($consulta);
		$arrCtas="";
		$objCta="";
		while($f=mysql_fetch_row($res))
		{
			$fraccionCodUnidad=substr($f[3],strlen($f[3])-$longitudCodigo);
			$hijos=obtenerCuentasHijas($f[9],($f[1]+1),$ciclo);
			if($hijos=="[]")
				$comp='"leaf":true,"icon":"../images/s16.png"';
			else
				$comp='"leaf":false,"children":'.$hijos;
				
			$objCta='	{
							"codigoCompCta":"'.$f[2].'",
							"descripcion":"'.$f[15].'",
							"codCuentaEquivalente":"'.$f[16].'",
							"lblCuentaEquivalente":"'.$f[17].'",
							"qtip":"'.$f[15].'",
							"id":"'.$f[0].'",
							"nivel":"'.$f[1].'",
							"codUnidad":"'.$f[3].'",
							"codigoCta":"'.$f[9].'",
							"fraccionCodUnidad":"'.$fraccionCodUnidad.'",
							"codPadre":"'.$codPadre.'",
							"removible":"1",
							"estado":"'.$f[13].'",
							"lblEstado":"'.$f[14].'",
							"titulo":"'.$f[4].'",
							"tipoCta":"'.$f[5].'",
							"idTipoCta":"'.$f[6].'",
							"naturaleza":"'.$f[7].'",
							"idNaturaleza":"'.$f[8].'",
							"idTipoEntradaHijo":"'.$f[10].'",
							"valorInicialHijo":"'.$f[11].'",
							"incrementoHijo":"'.$f[12].'",'.$comp.'
						}
					';
			
			if($arrCtas=="")
				$arrCtas=$objCta;
			else
				$arrCtas.=','.$objCta;
			
		}
		return "[".($arrCtas)."]";
	}
	
	function eliminarTipoCuenta()
	{
		global $con;
		$id=base64_decode($_POST["id"]);
		$consulta="delete from 501_tiposCuenta where idTipoCta=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarNaturalezaCuenta()
	{
		global $con;
		$id=base64_decode($_POST["id"]);
		$consulta="delete from 502_naturalezaCuenta where idNaturalezaCta=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarCategoriaCuenta()
	{
		global $con;
		$id=base64_decode($_POST["id"]);
		$consulta="delete from 503_categoriasCuenta where idCategoriaCuenta=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarGrupoContableNegocio()
	{
		global $con;
		$id=base64_decode($_POST["id"]);
		$consulta="delete from 504_gruposContablesNegocio where idGrupoContableNegocio=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarGrupoContableProducto()
	{
		global $con;
		$id=base64_decode($_POST["id"]);
		$consulta="delete from 505_gruposContablesProductos where idGrupoContableProducto=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarTipoIVA()
	{
		global $con;
		$id=base64_decode($_POST["id"]);
		$consulta="delete from 509_tiposIva where idTipoIva=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarTiposCategoriaCuenta()
	{
		global $con;
		$id=base64_decode($_POST["id"]);
		$consulta="delete from 511_tipoCategoriaCuenta where idTipoCategoriaCta=".$id;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarConfiguracionCuentas()
	{
		global $con;
		$cadObjConf=$_POST["objConf"];
		$objConf=json_decode($cadObjConf);
		$comp="";
		$ciclo="-1";
		if(isset($objConf->ciclo))
		{
			$ciclo=$objConf->ciclo;
			$comp=" and idCiclo=".$ciclo;
		}
		$idCatalogo=$_POST["idCatalogo"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 500_variablesSistema where tipo=".$idCatalogo.$comp;
		$x++;
		$consulta[$x]="insert into 500_variablesSistema (campo1,campo2,campo3,tipo,campo4,idCiclo) 
						values('".$objConf->idCategoriaCuenta."','".cv($objConf->separador)."','".cv($objConf->cRelleno)."',".$idCatalogo.",'".$objConf->rellenarLongitud."',".$ciclo.")";
		
		$x++;
		if($idCatalogo<3)
		{
			$consulta[$x]="delete from 512_configuracionNiveles where idCatalogo=".$idCatalogo.$comp;
			$x++;
			foreach($objConf->nivelCfg as $f)
			{
				$valorInicio=$f->valorInicio;
				if($valorInicio=="")
					$valorInicio="NULL";
				$incremento=$f->incremento;
				if($incremento=="")
					$incremento="NULL";
				$consulta[$x]="insert into 512_configuracionNiveles (nivel,idCatalogo,idCodigoElemento,longitudCodigo,valorInicial,incremento,idCiclo) 
								values(".$f->nivel.",".$idCatalogo.",".$f->tipoEntrada.",".$f->lEntrada.",".$valorInicio.",".$incremento.",".$ciclo.")";
				
				$x++;	
			}
		}
		$consulta[$x]="commit";
		$x++;

		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarDatosCuenta()
	{
		global $con;
		$objConf=$_POST["objConf"];
		$obj=json_decode($objConf);
		$codigo=cv($obj->codigo);
		$codPadre=$obj->codPadre;
		$nivel=$obj->nivel;
		$consulta="select campo2,campo4 from 500_variablesSistema where tipo=1 and idCiclo=".$obj->ciclo;
		$fConfiguracion=$con->obtenerPrimeraFila($consulta);
		$separador=$fConfiguracion[0];
		$rellenar=$fConfiguracion[1];
		$consulta="select * from 512_configuracionNiveles where idCatalogo=1 and idCiclo=".$obj->ciclo."  order by nivel";
		$resNiveles=$con->obtenerFilas($consulta);
		$longitudTotal=0;
		$arrLongNiveles=array();
		while($filaNivel=mysql_fetch_row($resNiveles))
		{
			$arrLongNiveles["".$filaNivel[1]]=$filaNivel[4];
			$longitudTotal+=$filaNivel[4];
		}
		$nNiveles=sizeof($arrLongNiveles);
		$codigoNormalizado=$codigo;
		
		if($rellenar==1)
			$codigoNormalizado=str_pad($codigo,$arrLongNiveles["".$obj->nivel],"0",STR_PAD_LEFT);
		$codigoUnidad="";
		if($codPadre!="")
		{
			$consulta="SELECT codigoUnidadCta FROM 510_cuentas WHERE codigoCta='".$codPadre."'";
			$codigoCtaPadre=$con->obtenerValor($consulta);
			$codigoUnidad=$codigoCtaPadre.$separador.$codigoNormalizado;
		}
		else
			$codigoUnidad=$codigoNormalizado;
		
		$consulta="select idCuenta from 510_cuentas where idCuenta<>".$obj->idCuenta." and codigoUnidadCta='".$codigoUnidad."' and ciclo=".$obj->ciclo;
		$idCuenta=$con->obtenerValor($consulta);
		if($idCuenta!="")
		{
			echo "<br>* Ya existe una cuenta con el c&oacute;digo ingresado";
			return ;
		}

		$codicoCompCta=$codigoUnidad;
		$nInicio=$nivel+1;
		if($rellenar==1)
		{
			for($x=$nInicio;$x<=$nNiveles;$x++)
			{
				$codNivel=str_pad("",$arrLongNiveles["".$x],"0",STR_PAD_LEFT);
				$codicoCompCta.=$separador.$codNivel;
				
			}
		}
		if($obj->idCuenta=="-1")
		{
			$consulta="SELECT MAX(codigoCta) FROM 510_cuentas WHERE codigoCta LIKE '".$codPadre."____' AND ciclo=".$obj->ciclo;
			$maxHijo=$con->obtenerValor($consulta);
			if($maxHijo=="")
				$maxHijo=1;
			else
			{
				$maxHijo=substr($maxHijo,strlen($maxHijo)-4,4);
				$maxHijo=($maxHijo*1)+1;
			}
			$codigoCta=$codPadre.str_pad($maxHijo,4,"0",STR_PAD_LEFT);
			$consulta="insert into 510_cuentas(nivel,codigoCompletoCta,codigoUnidadCta,tituloCta,idTipoCta,idNaturalezaCta,
						codigoCta,idTipoEntradaHijo,valorInicialHijo,incrementoHijo,ciclo,descripcion,cuentaEquivalenteCicloAnterior) values(
						".$obj->nivel.",'".$codicoCompCta."','".$codigoUnidad."','".cv($obj->nCuenta)."',".$obj->tCuenta.",".$obj->naturalezaCta.
						",'".$codigoCta."',".$obj->codigoEHijo.",'".$obj->vInicialH."','".$obj->incrementoH."',".$obj->ciclo.",'".cv($obj->descripcion).
						"','".$obj->cuentaCicloAnterior."')";
		}
		else
		{
			$consulta="update 510_cuentas set codigoCompletoCta='".$codicoCompCta."',codigoUnidadCta='".$codigoUnidad."',tituloCta='".cv($obj->nCuenta)."',
					idTipoCta=".$obj->tCuenta.",idNaturalezaCta=".$obj->naturalezaCta.",descripcion='".cv($obj->descripcion)."',cuentaEquivalenteCicloAnterior='".$obj->cuentaCicloAnterior."',
					idTipoEntradaHijo=".$obj->codigoEHijo.",valorInicialHijo='".$obj->vInicialH."',incrementoHijo='".$obj->incrementoH."' where idCuenta=".$obj->idCuenta;		
		}
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerCodigo()
	{
		global $con;
		$codPadre=$_POST["codPadre"];
		$nivel=$_POST["nivel"];
		$vInicialH=$_POST["vInicialH"];
		$incrementoHijo=$_POST["incrementoH"];
		
		$consulta="select campo2 from 500_variablesSistema where tipo=1";
		$separador=$con->obtenerValor($consulta);
		$consulta="select * from 512_configuracionNiveles where idCatalogo=1 order by nivel";
		$resNiveles=$con->obtenerFilas($consulta);
		$longitudTotal=0;
		$arrLongNiveles=array();
		while($filaNivel=mysql_fetch_row($resNiveles))
		{
			$arrLongNiveles["".$filaNivel[1]]=$filaNivel[4];
			$longitudTotal+=$filaNivel[4];
		}
		$nNiveles=sizeof($arrLongNiveles);
		$codPadre=str_replace($separador,"",$codPadre);
		$cadComodin=str_pad("",$arrLongNiveles["".$nivel],'_',STR_PAD_LEFT);
		if($codPadre!="")
			$consulta="select max(codigoUnidadCta) from 510_cuentas where codigoUnidadCta like '".$codPadre.$separador.$cadComodin."'";
		else
			$consulta="select max(codigoUnidadCta) from 510_cuentas where codigoUnidadCta like '".$codPadre.$cadComodin."'";
		$maxUnidad=$con->obtenerValor($consulta);
		
		if($maxUnidad=="")
			$maxUnidad=$vInicialH;
		else
		{
			$maxUnidad=substr($maxUnidad,strlen($maxUnidad)-$arrLongNiveles["".$nivel]);
			$maxUnidad+=$incrementoHijo;
		}
		$maxUnidad=str_pad($maxUnidad,$arrLongNiveles["".$nivel],'0',STR_PAD_LEFT);
		echo "1|".$maxUnidad;		
	}
	
	function desActivarCuenta()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		$consulta="update 510_cuentas set estado=0 where codigoCompletoCta like '".$codigoCuenta."%'";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function activarCuenta()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		$consulta="update 510_cuentas set estado=1 where codigoCompletoCta like '".$codigoCuenta."%'";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerCuenta()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		$ciclo=$_POST["ciclo"];
		$consulta="delete from  510_cuentas where ciclo=".$ciclo." and codigoCompletoCta like '".$codigoCuenta."%'";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerNivel()
	{
		global $con;
		$nivel=$_POST["nivel"];
		$consulta="delete from  512_configuracionNiveles where nivel ='".$nivel."' and idCatalogo=1";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	//////////Objetos de gasto
	
	function obtenerObjGasto()
	{
		global $con;
		$consulta="	SELECT idObjetoGasto,clave,codigoControl,nombreObjetoGasto,IF(STATUS=1,'Activo','Inactivo') AS 'lblEstado',status,gravable,permiteContratoAbierto FROM 507_objetosGasto 
					WHERE (codigoControlPadre='' OR codigoControlPadre IS NULL) and (codigoInstitucion='".$_SESSION["codigoInstitucion"]."' or codigoInstitucion='*') ORDER BY CAST(clave AS SIGNED)";
		$res=$con->obtenerFilas($consulta);
		$arrCtas="";
		$objCta="";
		while($f=mysql_fetch_row($res))
		{
			$hijos=obtenerObjGastoHijas($f[2]);
			if($hijos=="[]")
				$comp='"leaf":true,"icon":"../images/s16.png"';
			else
				$comp='"leaf":false,"children":'.$hijos;
				
			$objCta='	{
							
							"id":"'.$f[0].'",
							"clave":"'.$f[1].'",
							"codUnidad":"'.$f[2].'",
							"removible":"1",
							"estado":"'.$f[5].'",
							"lblEstado":"'.$f[4].'",
							"titulo":"'.$f[3].'",
							"tipoNodo":"1",
							"gravable":"'.$f[6].'",
							"permiteContratoAbierto":"'.$f[7].'",
							'.$comp.'
						}
					';
			
			if($arrCtas=="")
				$arrCtas=$objCta;
			else
				$arrCtas.=','.$objCta;
			
		}
		echo "[".uEJ($arrCtas)."]";
	}
	
	function obtenerObjGastoHijas($codPadre)
	{
		global $con;
		
		
		$consulta="SELECT idObjetoGasto,clave,codigoControl,nombreObjetoGasto,IF(STATUS=1,'Activo','Inactivo') AS 'lblEstado',status,gravable,permiteContratoAbierto FROM 507_objetosGasto WHERE codigoControlPadre='".$codPadre."' 
					ORDER BY CAST(clave AS SIGNED)";
		
		$res=$con->obtenerFilas($consulta);
		$arrCtas="";
		$objCta="";
		while($f=mysql_fetch_row($res))
		{
			
			$hijos=obtenerObjGastoHijas($f[2]);
			if($hijos=="[]")
				$comp='"leaf":true,"icon":"../images/s16.png"';
			else
				$comp='"leaf":false,"children":'.$hijos;
			
			$objCta='	{
							
							"id":"'.$f[0].'",
							"clave":"'.$f[1].'",
							"codUnidad":"'.$f[2].'",
							"removible":"1",
							"estado":"'.$f[5].'",
							"lblEstado":"'.$f[4].'",
							"titulo":"'.$f[3].'",
							"tipoNodo":"2",
							"gravable":"'.$f[6].'",
							"permiteContratoAbierto":"'.$f[7].'",
							'.$comp.'
						}
					';
			
			if($arrCtas=="")
				$arrCtas=$objCta;
			else
				$arrCtas.=','.$objCta;
			
		}
		return "[".($arrCtas)."]";
	}
	
	function guardarDatosObjGasto()
	{
		global $con;
		$objConf=$_POST["objConf"];
		$obj=json_decode($objConf);
		$clave=$obj->clave;
		$nObjetoGasto=$obj->nObj;
		$tipoObjeto=$obj->tipo;
		$codPadre=$obj->codPadre;
		$consulta="select idObjetoGasto from 507_objetosGasto where idObjetoGasto<>".$obj->idObj." and clave='".$clave."' and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$idCuenta=$con->obtenerValor($consulta);
		$x=0;
		$query[$x]="begin";
		$x++;
		if($idCuenta!="")
		{
			if($tipoObjeto==1) //Partida
				echo "<br>* Ya existe una partida con la clave ingresada";
			else
				echo "<br>* Ya existe un objeto de gasto con la clave ingresada";
			return ;
		}
		if($obj->idObj=="-1")
		{
			$consulta="select max(codigoControl) from 507_objetosGasto where codigoControlPadre='".$codPadre."'";
			$maxCodigoControl=$con->obtenerValor($consulta);
			if($maxCodigoControl=="")
				$maxCodigoControl="1";
			else
				$maxCodigoControl+=1;

			$maxCodigoControl=str_pad($maxCodigoControl,"3","0",STR_PAD_LEFT);
			
			$maxCodigoControl= $codPadre.$maxCodigoControl;
			$longitud=0;
			if((strlen($maxCodigoControl)%3)!=0)
				$longitud=3-(strlen($maxCodigoControl)%3);

			$longitudTotal=strlen($maxCodigoControl)+$longitud;
			$codigoControl=str_pad($maxCodigoControl,$longitudTotal,"0",STR_PAD_LEFT);
			$query[$x]="insert into 507_objetosGasto(clave,nombreObjetoGasto,codigoControl,codigoControlPadre,status,codigoInstitucion,fechaCreacion,idResponsableCreacion,gravable,permiteContratoAbierto) 
						values('".cv($clave)."','".cv($nObjetoGasto)."','".$codigoControl."','".$codPadre."',1,'".$_SESSION["codigoInstitucion"]."','".date('Y-m-d')."',".$_SESSION["idUsr"].",".$obj->gravable.",".$obj->permiteContratoAbierto.")";
			$x++;
		}
		else
		{
			$query[$x]="insert into 507_historialObjetosGasto(idObjetoGasto,clave,nombreObjetoGasto,status,fechaCambio,idResponsableCambio,accion) 
						(select idObjetoGasto,clave,nombreObjetoGasto,status,'".date('Y-m-d')."' as fechaCambio,'".$_SESSION["idUsr"]."' as idResponsableCambio,'1' as accion from 507_objetosGasto where idObjetoGasto=".$obj->idObj.")";		
			$x++;
			$query[$x]="update 507_objetosGasto set gravable=".$obj->gravable.",permiteContratoAbierto=".$obj->permiteContratoAbierto.",clave=".cv($clave).",nombreObjetoGasto='".cv($nObjetoGasto)."' where idObjetoGasto=".$obj->idObj;		
			$x++;
		}
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerCodigoObjGasto()
	{
		global $con;
		$codPadre=$_POST["codPadre"];
		$nivel=$_POST["nivel"];
		$vInicialH=$_POST["vInicialH"];
		$incrementoHijo=$_POST["incrementoH"];
		
		$consulta="select campo2 from 500_variablesSistema where tipo=2";
		$separador=$con->obtenerValor($consulta);
		$consulta="select * from 512_configuracionNiveles where idCatalogo=2 order by nivel";
		$resNiveles=$con->obtenerFilas($consulta);
		$longitudTotal=0;
		$arrLongNiveles=array();
		while($filaNivel=mysql_fetch_row($resNiveles))
		{
			$arrLongNiveles["".$filaNivel[1]]=$filaNivel[4];
			$longitudTotal+=$filaNivel[4];
		}
		$nNiveles=sizeof($arrLongNiveles);
		$codPadre=str_replace($separador,"",$codPadre);
		$cadComodin=str_pad("",$arrLongNiveles["".$nivel],'_',STR_PAD_LEFT);
		if($codPadre!="")
			$consulta="select max(codigoUnidadObj) from 507_objetosGasto where codigoUnidadObj like '".$codPadre.$separador.$cadComodin."'";
		else
			$consulta="select max(codigoUnidadObj) from 507_objetosGasto where codigoUnidadObj like '".$codPadre.$cadComodin."'";
		$maxUnidad=$con->obtenerValor($consulta);
		
		if($maxUnidad=="")
			$maxUnidad=$vInicialH;
		else
		{
			$maxUnidad=substr($maxUnidad,strlen($maxUnidad)-$arrLongNiveles["".$nivel]);
			$maxUnidad+=$incrementoHijo;
		}
		$maxUnidad=str_pad($maxUnidad,$arrLongNiveles["".$nivel],'0',STR_PAD_LEFT);
		echo "1|".$maxUnidad;		
	}
	
	function desActivarObjGasto()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 507_historialObjetosGasto(idObjetoGasto,clave,nombreObjetoGasto,status,fechaCambio,idResponsableCambio,accion) 
						(select idObjetoGasto,clave,nombreObjetoGasto,status,'".date('Y-m-d')."' as fechaCambio,'".$_SESSION["idUsr"]."' as idResponsableCambio,'2' as accion from 507_objetosGasto where codigoControl like '".$codigoCuenta."%')";		
		$x++;
		$consulta[$x]="update 507_objetosGasto set status=0 where codigoControl like '".$codigoCuenta."%'";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function activarObjGasto()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 507_historialObjetosGasto(idObjetoGasto,clave,nombreObjetoGasto,status,fechaCambio,idResponsableCambio,accion) 
						(select idObjetoGasto,clave,nombreObjetoGasto,status,'".date('Y-m-d')."' as fechaCambio,'".$_SESSION["idUsr"]."' as idResponsableCambio,'3' as accion from 507_objetosGasto where codigoControl like '".$codigoCuenta."%')";		
		$x++;
		$consulta[$x]="update 507_objetosGasto set status=1 where codigoControl like '".$codigoCuenta."%'";
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerObjGasto()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 507_historialObjetosGasto(idObjetoGasto,clave,nombreObjetoGasto,status,fechaCambio,idResponsableCambio,accion) 
						(select idObjetoGasto,clave,nombreObjetoGasto,status,'".date('Y-m-d')."' as fechaCambio,'".$_SESSION["idUsr"]."' as idResponsableCambio,'4' as accion from 507_objetosGasto where codigoControl like '".$codigoCuenta."%')";		
		$x++;
		$consulta[$x]="delete from  507_objetosGasto where codigoControl like '".$codigoCuenta."%'";
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	////Tipos presupuesto
	
	function obtenerTipoPresupuesto()
	{
		global $con;
		$consulta="select tp.idTipoPresupuesto,tp.nivel,tp.codigoCompleto,tp.codigoUnidad,tp.tituloTipoP,tp.estado,
					if(tp.estado=1,'Activo','Inactivo') as 'lblEstado',tp.codigo,tp.idFuncion from 508_tiposPresupuesto tp  
					where 	tp.nivel=1 and (codigoInstitucion='".$_SESSION["codigoInstitucion"]."' or codigoInstitucion='*')";
		$res=$con->obtenerFilas($consulta);
		$arrCtas="";
		$objCta="";
		while($f=mysql_fetch_row($res))
		{
			//$hijos=obtenerTipoPresupuestoHijas($f[3],$f[1]);
			$hijos="[]";
			if($hijos=="[]")
				$comp='"leaf":true,"icon":"../images/s16.png"';
			else
				$comp='"leaf":false,"children":'.$hijos;
				
			$objCta='	{
							"codigoComp":"'.$f[2].'",
							"id":"'.$f[0].'",
							"nivel":"'.$f[1].'",
							"codUnidad":"'.$f[3].'",
							"codigo":"'.$f[7].'",
							"codPadre":"",
							"removible":"1",
							"idFuncion":"0",
							"funcion":"",
							"estado":"'.$f[5].'",
							"lblEstado":"'.$f[6].'",
							"titulo":"'.$f[4].'",'.$comp.'
						}
					';
			
			if($arrCtas=="")
				$arrCtas=$objCta;
			else
				$arrCtas.=','.$objCta;
			
		}
		echo "[".uEJ($arrCtas)."]";
	}
	
	function obtenerTipoPresupuestoHijas($codPadre,$nivel)
	{
		global $con;
		$separador="";
		$longitudCodigo=4;
		$cadComodin=str_pad("",$longitudCodigo,'_',STR_PAD_LEFT);
		$codPadreBusqueda=$codPadre.$cadComodin;
		
		$consulta="select tp.idTipoPresupuesto,tp.nivel,tp.codigoCompleto,tp.codigoUnidad,tp.tituloTipoP,tp.estado,
					if(tp.estado=1,'Activo','Inactivo') as 'lblEstado',tp.codigo,tp.idFuncion,fo.tituloCategoria from 508_tiposPresupuesto tp ,503_categoriasCuenta fo 
					where fo.idCategoriaCuenta=tp.idFuncion and tp.codigoUnidad like '".$codPadreBusqueda."'";
		$res=$con->obtenerFilas($consulta);
		$arrCtas="";
		$objCta="";
		while($f=mysql_fetch_row($res))
		{
			$fraccionCodUnidad=substr($f[3],strlen($f[3])-$longitudCodigo);
			$hijos=obtenerTipoPresupuestoHijas($f[3],$f[1]);
			if($hijos=="[]")
				$comp='"leaf":true,"icon":"../images/s16.png"';
			else
				$comp='"leaf":false,"children":'.$hijos;
			
			$objCta='	{
							"codigoComp":"'.$f[2].'",
							"id":"'.$f[0].'",
							"nivel":"'.$f[1].'",
							"codUnidad":"'.$f[3].'",
							"codigo":"'.$f[7].'",
							"codPadre":"'.$codPadre.'",
							"removible":"1",
							"idFuncion":"'.$f[8].'",
							"funcion":"'.$f[9].'",
							"estado":"'.$f[5].'",
							"lblEstado":"'.$f[6].'",
							"titulo":"'.$f[4].'",'.$comp.'
						}
					';
			
			
			if($arrCtas=="")
				$arrCtas=$objCta;
			else
				$arrCtas.=','.$objCta;
			
		}
		return "[".($arrCtas)."]";
	}
	
	function guardarDatosTipoPresupuesto()
	{
		global $con;
		$objConf=$_POST["objConf"];
		$obj=json_decode($objConf);
		$codigoTipoPresupuesto=cv($obj->codigo);
		$codPadre=$obj->codPadre;
		$codigo=obtenerCodigoTipoPresupuesto($codPadre);

		$nivel=$obj->nivel;
		$separador="";
		$codigoNormalizado=str_pad($codigo,4,"0",STR_PAD_LEFT);
		if($codPadre!="")
			$codigoUnidad=$codPadre.$separador.$codigoNormalizado;
		else
			$codigoUnidad=$codigoNormalizado;
		
		$consulta="select idTipoPresupuesto from 508_tiposPresupuesto where idTipoPresupuesto<>".$obj->idTipoP." and codigo='".$codigoTipoPresupuesto."'";
		$idCuenta=$con->obtenerValor($consulta);
		if($idCuenta!="")
		{
			echo "<br>* El c&oacute;digo ingresado ya se encuentra registrado";
			return ;
		}
		$longitudTotal=4*$nivel;
		$codigoCta=str_pad( str_replace($separador,"",$codPadre).$codigo,$longitudTotal,"0",STR_PAD_RIGHT);
		
		if($obj->idTipoP=="-1")
		{
			$consulta="insert into 508_tiposPresupuesto(nivel,codigoCompleto,codigoUnidad,tituloTipoP,codigo,idFuncion,codigoInstitucion) values
						(".$obj->nivel.",'".$codigoCta."','".$codigoUnidad."','".cv($obj->nTipoP)."','".$codigoTipoPresupuesto."',".$obj->funcion.",'".$_SESSION["codigoInstitucion"]."')";
		}
		else
		{
			$consulta="update 508_tiposPresupuesto set nivel=".$obj->nivel.",codigoCompleto='".$codigoCta."',codigoUnidad='".$codigoUnidad."',tituloTipoP='".cv($obj->nTipoP)."',
					codigo='".$codigoTipoPresupuesto."',idFuncion=".$obj->funcion." where idTipoPresupuesto=".$obj->idTipoP;		
		}
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerCodigoTipoPresupuesto($codPadre)
	{
		global $con;
		
		$vInicialH=1;
		$incrementoHijo=1;
		$cadComodin=str_pad("",4,'_',STR_PAD_LEFT);
		$consulta="select max(codigoUnidad) from 508_tiposPresupuesto where codigoUnidad like '".$codPadre.$cadComodin."'";
		$maxUnidad=$con->obtenerValor($consulta);
		if($maxUnidad=="")
			$maxUnidad=$vInicialH;
		else
		{
			$maxUnidad=substr($maxUnidad,strlen($maxUnidad)-4);
			$maxUnidad+=$incrementoHijo;
		}
		$maxUnidad=str_pad($maxUnidad,4,'0',STR_PAD_LEFT);
		return $maxUnidad;		
	}
	
	function desActivarTipoPresupuesto()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		$consulta="update 508_tiposPresupuesto set estado=0 where codigoCompleto like '".$codigoCuenta."%'";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function activarTipoPresupuesto()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		$consulta="update 508_tiposPresupuesto set estado=1 where codigoCompleto like '".$codigoCuenta."%'";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerTipoPresupuesto()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		$consulta="delete from  508_tiposPresupuesto where codigoCompleto like '".$codigoCuenta."%'";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	///Tipo centro costo
	
	function obtenerCentroCosto()
	{
		global $con;
		$consulta="select cc.idCentroCosto,cc.nivel,cc.codigoCompleto,cc.codigoUnidad,cc.tituloCentroC,cc.estado,
					if(cc.estado=1,'Activo','Inactivo') as 'lblEstado',cc.codigo,cc.idFuncion,fo.tituloCategoria,cc.codigoArea,
					(select unidad from 817_organigrama where codigoUnidad=cc.codigoArea) as lblUnidad
					from 506_centrosCosto cc ,503_categoriasCuenta fo 
					where fo.idCategoriaCuenta=cc.idFuncion and	cc.nivel=1";
		$res=$con->obtenerFilas($consulta);
		$arrCtas="";
		$objCta="";
		while($f=mysql_fetch_row($res))
		{
			$hijos=obtenerCentroCostoHijas($f[3],$f[1]);
			if($hijos=="[]")
				$comp='"leaf":true,"icon":"../images/s16.png"';
			else
				$comp='"leaf":false,"children":'.$hijos;
			$lblArea=$f[11];
			if($lblArea=="")
				$lblArea="N/A";	
			$objCta='	{
							"codigoComp":"'.$f[2].'",
							"id":"'.$f[0].'",
							"nivel":"'.$f[1].'",
							"codUnidad":"'.$f[3].'",
							"codigo":"'.$f[7].'",
							"codPadre":"",
							"removible":"1",
							"codigoArea":"'.$f[10].'",
							"lblArea":"'.$lblArea.'",
							"idFuncion":"'.$f[8].'",
							"funcion":"'.$f[9].'",
							"estado":"'.$f[5].'",
							"lblEstado":"'.$f[6].'",
							"titulo":"'.$f[4].'",'.$comp.'
						}
					';
			
			if($arrCtas=="")
				$arrCtas=$objCta;
			else
				$arrCtas.=','.$objCta;
			
		}
		echo "[".uEJ($arrCtas)."]";
	}
	
	function obtenerCentroCostoHijas($codPadre,$nivel)
	{
		global $con;
		$separador="";
		$longitudCodigo=4;
		$cadComodin=str_pad("",$longitudCodigo,'_',STR_PAD_LEFT);
		$codPadreBusqueda=$codPadre.$cadComodin;
		$consulta="select cc.idCentroCosto,cc.nivel,cc.codigoCompleto,cc.codigoUnidad,cc.tituloCentroC,cc.estado,
					if(cc.estado=1,'Activo','Inactivo') as 'lblEstado',cc.codigo,cc.idFuncion,fo.tituloCategoria,cc.codigoArea,
					(select unidad from 817_organigrama where codigoUnidad=cc.codigoArea) as lblUnidad from 506_centrosCosto cc ,503_categoriasCuenta fo 
					where fo.idCategoriaCuenta=cc.idFuncion and	cc.codigoUnidad like '".$codPadreBusqueda."'";
		$res=$con->obtenerFilas($consulta);
		$arrCtas="";
		$objCta="";
		while($f=mysql_fetch_row($res))
		{
			$fraccionCodUnidad=substr($f[3],strlen($f[3])-$longitudCodigo);
			$hijos=obtenerCentroCostoHijas($f[3],$f[1]);
			if($hijos=="[]")
				$comp='"leaf":true,"icon":"../images/s16.png"';
			else
				$comp='"leaf":false,"children":'.$hijos;
			$lblArea=$f[11];
			if($lblArea=="")
				$lblArea="N/A";
			$objCta='	{
							"codigoComp":"'.$f[2].'",
							"id":"'.$f[0].'",
							"nivel":"'.$f[1].'",
							"codUnidad":"'.$f[3].'",
							"codigo":"'.$f[7].'",
							"codPadre":"'.$codPadre.'",
							"removible":"1",
							"codigoArea":"'.$f[10].'",
							"lblArea":"'.$lblArea.'",
							"idFuncion":"'.$f[8].'",
							"funcion":"'.$f[9].'",
							"estado":"'.$f[5].'",
							"lblEstado":"'.$f[6].'",
							"titulo":"'.$f[4].'",'.$comp.'
						}
					';
			
			
			if($arrCtas=="")
				$arrCtas=$objCta;
			else
				$arrCtas.=','.$objCta;
			
		}
		return "[".($arrCtas)."]";
	}
	
	function guardarDatosCentroCosto()
	{
		global $con;
		$objConf=$_POST["objConf"];
		$obj=json_decode($objConf);
		$codigoCentro=cv($obj->codigo);
		$codPadre=$obj->codPadre;
		$codigo=obtenerCodigoCentroCosto($codPadre);

		$nivel=$obj->nivel;
		$separador="";
		$codigoNormalizado=str_pad($codigo,4,"0",STR_PAD_LEFT);
		if($codPadre!="")
			$codigoUnidad=$codPadre.$separador.$codigoNormalizado;
		else
			$codigoUnidad=$codigoNormalizado;
		
		$query="select idCentroCosto from 506_centrosCosto where idCentroCosto<>".$obj->idCentro." and codigo='".$codigoCentro."'";
		$idCentro=$con->obtenerValor($query);
		if($idCentro!="")
		{
			echo "<br>* El c&oacute;digo ingresado ya se encuentra registrado";
			return ;
		}
		$longitudTotal=4*$nivel;
		$codigoCta=str_pad( str_replace($separador,"",$codPadre).$codigo,$longitudTotal,"0",STR_PAD_RIGHT);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idCentro=="-1")
		{
			$consulta[$x]="insert into 506_centrosCosto(nivel,codigoCompleto,codigoUnidad,tituloCentroC,codigo,idFuncion,codigoArea) values
						(".$obj->nivel.",'".$codigoCta."','".$codigoUnidad."','".cv($obj->nTituloC)."','".$codigoCentro."',".$obj->funcion.",'".$obj->codUnidadArea."')";
			$x++;
			$consulta[$x]="insert into 4084_unidadesRoles(unidadRol,fechaCreacion,responsable,idCategoria) values('".cv($obj->nTituloC)."','".date('Y-m-d')."',".$_SESSION["idUsr"].",4)";
			$x++;
		}
		else
		{
			$consulta[$x]="update 506_centrosCosto set nivel=".$obj->nivel.",codigoCompleto='".$codigoCta."',codigoUnidad='".$codigoUnidad."',tituloCentroC='".cv($obj->nTituloC)."',
					codigo='".$codigoCentro."',idFuncion=".$obj->funcion.",codigoArea='".$obj->codUnidadArea."' where idCentroCosto=".$obj->idCentro;		
			$x++;
			$query="select tituloCentroC from 506_centrosCosto where idCentroCosto=".$obj->idCentro;	
			$tCentro=$con->obtenerValor($query);
			$consulta[$x]="update 4084_unidadesRoles set unidadRol='".cv($obj->nTituloC)."',fechaModif='".date('Y-m-d')."',respModif=".$_SESSION["idUsr"]." where unidadRol='".$tCentro."' and idCategoria=4";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerCodigoCentroCosto($codPadre)
	{
		global $con;
		
		$vInicialH=1;
		$incrementoHijo=1;
		$cadComodin=str_pad("",4,'_',STR_PAD_LEFT);
		$consulta="select max(codigoUnidad) from 506_centrosCosto where codigoUnidad like '".$codPadre.$cadComodin."'";
		$maxUnidad=$con->obtenerValor($consulta);
		if($maxUnidad=="")
			$maxUnidad=$vInicialH;
		else
		{
			$maxUnidad=substr($maxUnidad,strlen($maxUnidad)-4);
			$maxUnidad+=$incrementoHijo;
		}
		$maxUnidad=str_pad($maxUnidad,4,'0',STR_PAD_LEFT);
		return $maxUnidad;		
	}
	
	function desActivarCentroCosto()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		$consulta="update 506_centrosCosto set estado=0 where codigoCompleto like '".$codigoCuenta."%'";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function activarCentroCosto()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		$consulta="update 506_centrosCosto set estado=1 where codigoCompleto like '".$codigoCuenta."%'";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerCentroCosto()
	{
		global $con;
		$codigoCuenta=$_POST["codigoCta"];
		$consulta="delete from  506_centrosCosto where codigoCompleto like '".$codigoCuenta."%'";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarLibro()
	{
		global $con;
		$nombre=$_POST["nombre"];
		$descripcion=$_POST["descripcion"];
		$listRoles=$_POST["arrRoles"];
		$idLibro=$_POST["idLibro"];
		$x=0;
		$query="begin";
		$consulta=array();

		if($con->ejecutarConsulta($query))
		{
			if($idLibro=="-1")
				$query="insert into 590_librosDiarios(tituloLibro,descripcion) values('".cv($nombre)."','".cv($descripcion)."')";
			else
				$query="update 590_librosDiarios590_librosDiarios set tituloLibro='".cv($nombre)."',descripcion='".cv($descripcion)."' where idLibro=".$idLibro;
			if($con->ejecutarConsulta($query))
			{
				if($idLibro=="-1")
					$idLibro=$con->obtenerUltimoID();
				$arrRoles=explode(",",$listRoles);
				$nRoles=sizeof($arrRoles);
				$consulta[$x]="delete from 594_rolesVSLibros where idLibro=".$idLibro;
				$x++;
				for($y=0;$y<$nRoles;$y++)
				{
					$arrConf=explode("@",$arrRoles[$y]);
					$consulta[$x]="insert into 594_rolesVSLibros(idLibro,rol,permisos) values(".$idLibro.",'".$arrConf[0]."','".$arrConf[1]."')";
					
					$x++;
				}
			}
		}
		$consulta[$x]="commit";
		$x++;

		if($con->ejecutarBloque($consulta))
		{
			$permisos=obtenerPermisosLibro($idLibro);
			echo "1|".$idLibro."|".$permisos;
		}
		else
			echo "|";
	}
	
	function obtenerLibros()
	{
		global $con;
		$consulta="select * from 590_librosDiarios where idLibro in (select idLibro from 594_rolesVSLibros where rol in (".$_SESSION["idRol"].")) order by tituloLibro";

		$resLibros=$con->obtenerFilas($consulta);
		$arrLibros="";
		while($fLibro=mysql_fetch_row($resLibros))
		{
			$permisos=obtenerPermisosLibro($fLibro[0]);
			$obj="['".$fLibro[0]."','".$fLibro[1]."','".$fLibro[2]."','".$permisos."']";
			if($arrLibros=="")
				$arrLibros=$obj;
			else
				$arrLibros.=",".$obj;
				
		}
		
		echo "1|[".uEJ($arrLibros)."]";
	}
	
	function abrirLibro()
	{
		global $con;
		$idLibro=$_POST["idLibro"];
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT c.idDimension,c.nombreDimension,nombreEstructura,(select nombreFuncionJS from 9033_funcionesScriptsSistema WHERE idFuncion=c.idFuncionRenderer) as funcionRenderer FROM 592_dimensionesVigentesLibroDiario d,563_dimensiones c WHERE 
				 c.idDimension=d.idDimension AND cicloFiscal=".$ciclo." order by nombreDimension";
		$arrDimensiones=$con->obtenerFilasArreglo($consulta);	
		echo "1|[]|".$arrDimensiones;
	}
	
	function obtenerPermisosLibro($idLibro)
	{
		global $con;
		$consulta="select permisos from 594_rolesVSLibros where idLibro=".$idLibro." and rol in (".$_SESSION["idRol"].")";
		$permisos="";
		$resPermisos=$con->obtenerFilas($consulta);
		while($fPermisos=mysql_fetch_row($resPermisos))
		{
			if(strpos($fPermisos[0],"C")!==false)
			{
				
				if(strpos($permisos,"C")===false)
				{
					
					$permisos.="C";
				}
			}
			if(strpos($fPermisos[0],"R")!==false)
			{
				if(strpos($permisos,"R")===false)
					$permisos.="R";
			}
			if(strpos($fPermisos[0],"M")!==false)
			{
				if(strpos($permisos,"M")===false)
					$permisos.="M";
			}
		}
		return $permisos;
	}
	
	function obtenerConfiguracionLibro()
	{
		global $con;
		$idLibro=$_POST["idLibro"];
		$consulta="select tituloLibro,descripcion from 590_librosDiarios where idLibro=".$idLibro;
		$fila=$con->obtenerPrimeraFila($consulta);
		$consulta="select concat(rol,'@',permisos),rol,permisos from 594_rolesVSLibros where idLibro=".$idLibro;
		$resRol=$con->obtenerFilas($consulta);
		$arrRoles="";
		while($filaRol=mysql_fetch_row($resRol))
		{
			$objRol="['".$filaRol[0]."','".obtenerTituloRol($filaRol[1])." [".$filaRol[2]."]']";
			if($arrRoles=="")
				$arrRoles=$objRol;
			else
				$arrRoles.=",".$objRol;
		}
	
		echo "1|".uEJ($fila[0])."|".uEJ($fila[1])."|[".uEJ($arrRoles)."]";
	}
	
	function generarNuevoAsiento()
	{
		global $con;
		$idLibro=base64_decode($_POST["idLibro"]);
		$fecha=date('Y-m-d');
		$tDocumento="NULL";
		if(isset($_POST["tDocumento"]))
			$tDocumento=$_POST["tDocumento"];
		$nDocumento="";
		if(isset($_POST["nDocumento"]))
			$nDocumento=$_POST["nDocumento"];
		$consulta="insert into 514_asientos (fechaMovimiento,idUsuario,montoDebe,montoHaber,idTipocumento,noDocumento,idLibro)
					values('".$fecha."',".$_SESSION["idUsr"].",0.00,0.00,".$tDocumento.",'".$nDocumento."',".$idLibro.")";
		if($con->ejecutarConsulta($consulta))
		{
			$nMovimiento=$con->obtenerUltimoID();
			echo "1|".$nMovimiento."|".$fecha;
		}
		else
			echo "|";
	}
	
	function obtenerAsientosLibro()
	{
		global $con;
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$idLibro=base64_decode($_POST["idLibro"]);
		$cicloFiscal=$_POST["ciclo"];
		$consulta="select idCicloFiscal from 550_cicloFiscal where idCicloFiscal=".$cicloFiscal;
		$cicloFiscal=$con->obtenerValor($consulta);
		$tabla="595_asientosLibroDiarioC_".$cicloFiscal;
		if($idLibro==1)
			$condWhere=" 1=1";
		else
			$condWhere=" idLibroDiario=".$idLibro;
		
		$consulta="SELECT c.idDimension,nombreEstructura FROM 563_dimensiones c,592_dimensionesVigentesLibroDiario d WHERE c.idDimension=d.idDimension AND d.cicloFiscal=".$cicloFiscal;
		$arrDimensiones=$con->obtenerFilasArregloAsocPHP($consulta);	
		if($con->existeTabla($tabla))
		{
			$consulta="select idAsientoLibro,noMovimiento,fechaMovimiento,m.nombreConcepto,codigoCuenta,montoDebeOperacion,montoHaberOperacion,tipoOperacion,idResponsableMovimiento,descripcionMovimiento,
					folioMovimiento,noPoliza from ".$tabla." t,598_perfilesMovimientos m  where ".$condWhere. " and ".$cadCondWhere." and m.idConcepto=t.tipoMovimiento order by fechaMovimiento desc limit ".$start.",".$limit;

			$arrObj="";
			$resFilas=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($resFilas))
			{
				$consulta="SELECT idDimension,valorCampo,valorInterpretacion FROM 596_detallesAsientoLibroC_".$cicloFiscal." WHERE idAsiento=".$fila[0];
				$arrValoresDimensiones=$con->obtenerFilasArregloAsocPHP($consulta);	
				$valComp="";
				if(sizeof($arrDimensiones)>0)
				{
					foreach($arrDimensiones as $idDimension=>$dimension)
					{
							if(isset($arrValoresDimensiones[$idDimension]))
								$valComp.=',"'.$dimension.'":"'.$arrValoresDimensiones[$idDimension].'"';
							else
								$valComp.=',"'.$dimension.'":""';
							
					}
				}
				$obj='{"idAsientoLibro":"'.$fila[0].'","noMovimiento":"'.$fila[1].'","fechaMovimiento":"'.$fila[2].'","nombreConcepto":"'.$fila[3].'","codigoCuenta":"'.$fila[4].'","montoDebeOperacion":"'.$fila[5].'",
						"montoHaberOperacion":"'.$fila[6].'","tipoOperacion":"'.$fila[7].'","idResponsableMovimiento":"'.$fila[8].'","descripcionMovimiento":"'.$fila[9].'","folioMovimiento":"'.$fila[10].'","noPoliza":"'.$fila[11].'"'.$valComp.'}';
				if($arrObj=="")
					$arrObj=$obj;
				else
					$arrObj.=",".$obj;
			}
			$consulta="select montoDebeOperacion,montoHaberOperacion from ".$tabla." t,598_perfilesMovimientos m  where ".$condWhere. " and ".$cadCondWhere." and m.idConcepto=t.tipoMovimiento order by fechaMovimiento";
			$resTotal=$con->obtenerFilas($consulta);
			$totalDebe=0;
			$totalHaber=0;
			while($fTotal=mysql_fetch_row($resTotal))
			{
				$totalDebe+=$fTotal[0];
				$totalHaber+=$fTotal[1];
			}
			$diferencia=$totalDebe-$totalHaber;
			

//			"metaData":{"root":"registros","totalProperty":"numReg"},
			echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.($arrObj).'],"totalDebe":"$ '.number_format($totalDebe,2).'","totalHaber":"$ '.number_format($totalHaber,2).'","diferencia":"$ '.number_format($diferencia,2).'"}';
		}
		else
			echo '{"numReg":"0","registros":[]}';
	}
	
	function obtenerFolioTipoDoc()
	{
		global $con;
		$tipoDoc=$_POST["tipoDoc"];
		$idAsiento=$_POST["idAsiento"];
		$x=0;
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			
			$query="select * from 513_tiposDocumento where idTipoDocumento=".$tipoDoc." for update";
			$fila=$con->obtenerPrimeraFila($query);
			$actual=$fila[8];
			$longitudFolio=$fila[5];
			$separador=$fila[4];
			$varInicial=$fila[3];
			$incremento=$fila[8];
			$nFolio=$varInicial.$separador.str_pad($actual,$longitudFolio,"0",STR_PAD_LEFT);
			$consulta[$x]="update 513_tiposDocumento set valorActual=valorActual+".$incremento." where idTipoDocumento=".$tipoDoc;
			$x++;
			$consulta[$x]="update 514_asientos set idTipocumento=".$tipoDoc.",noDocumento='".$nFolio."' where idAsiento=".$idAsiento;
			$x++;
			$consulta[$x]="commit";
			$x++;
			if($con->ejecutarBloque($consulta))
				echo "1|".$nFolio;
			else
				echo "|";
			
			
		}
	}

	function actualizarCampoAsiento()
	{
		global $con;
		$idAsiento=$_POST["idAsiento"];
		$columna=$_POST["columna"];
		$valor=$_POST["valor"];
		$columnaVal="";
		$comp="";
		switch($columna)
		{
			case "4":
				$columnaVal="tipoPresupuesto";
			break;
			case "5":
				$columnaVal="programa";
			break;
			case "6":
				$columnaVal="centroCosto";
			break;
			case "7":
				$columnaVal="idProyecto";
				$idFormulario=$_POST["idFormulario"];
				$idReferencia=$_POST["idReferencia"];
				$consulta="select centroCosto from 986_vinculacionCC where idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
				$comp=$con->obtenerValor($consulta);
				if($comp!="")
				{
					$consulta="select centroCosto from 514_asientos where idAsiento=".$idAsiento;
					$cc=$con->obtenerValor($consulta);
					if($cc=="")
					{
						$columnaVal="centroCosto='".$comp."',idProyecto";
					}
				}
			break;
			case "9":
				$columnaVal="objetoGasto";
			break;
			case "12":
				$columnaVal="cuentaSimple='".$_POST["valor2"]."',cuentaMascara";
			break;
			case "13":
				$columnaVal="montoDebe";
			break;
			case "14":
				$columnaVal="montoHaber";
			break;
			case "15":
				$columnaVal="concepto";
			break;
		}
		$consulta="update 514_asientos set  ".$columnaVal."='".cv($valor)."' where idAsiento=".$idAsiento;
		if($con->ejecutarConsulta($consulta))
			echo "1|".$comp;
		else
			echo "|";
		
	}
	
	function obtenerObjGastoLibroDiario()
	{
		global $con;	
		$condWhere="";
		if(isset($_POST["filter"]))
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);

		if($condWhere=="")
			$condWhere=" 1=1 ";
		$consulta="select codigoCompletoObj ,tituloObj  from 507_objetosGasto where estado=1 and ".$condWhere." order by codigoCompletoObj";
		$arrObj=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.uEJ($arrObj).'}';
	}

	function obtenerCuentasLibroDiario()
	{
		global $con;
		$condWhere="";
		if(isset($_POST["filter"]))
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);

		if($condWhere=="")
			$condWhere=" 1=1 ";
		$consulta="select codigoCompletoCta, tituloCta , codigoCta as codigoSimple,idNaturalezaCta as tipoCta from 510_cuentas where 
					estado=1 and ".$condWhere." order by codigoCta";
		
		$arrObj=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.($arrObj).'}';
	}
	
	function eliminarPrograma()
	{
		global $con;
		$idPrograma=($_POST["id"]);
		$query="SELECT GROUP_CONCAT(ciclo) FROM 9117_estructurasVSPrograma WHERE idProgramaInstitucional=".$idPrograma." order by ciclo";
		$ciclo=$con->obtenerValor($query);
		if($ciclo!="")
		{
			echo "<br>El programa institucional est&aacute; siendo referido en la estructura program&aacute;tica de los ciclos: ".$ciclo;	
			return;	
		}
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 517_programas where idPrograma=".$idPrograma;
		$x++;
		$consulta[$x]="commit";
		$x++;
		//$consulta[$x]="delete from 517_programas where idPrograma=".$idPrograma;
		//$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarRegPOA()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$capitulo="";
		if($obj->objGasto!="")
		{
			$nCapitulo=strlen($obj->objGasto);
			$capitulo=str_pad(substr($obj->objGasto,0,1),$nCapitulo,"0",STR_PAD_RIGHT);
		}
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			if($obj->idRegistro=="")
			{
				$query="insert into 521_registrosPOA(codDepartamento,centroCosto,presupuesto,codPrograma,proyecto,objGasto,capitulo,producto,unidad,cantidad,
						costoPromedio,costoTotal,periodoAplicacion,cicloFiscal,respRegistro,fechaReg,idProceso) values
						('".$obj->codDepartamento."','".$obj->centroCosto."','".$obj->presupuesto."','".$obj->codPrograma."','".$obj->proyecto."','".$obj->objGasto.
						 "','".$capitulo."',".$obj->producto.",".$obj->unidad.",".$obj->cantidad.",".$obj->costoPromedio.
						 ",".$obj->costoTotal.",'".$obj->periodoAplicacion."',".$obj->cicloFiscal.",".$_SESSION["idUsr"].",'".date('Y-m-d')."',".$obj->idProceso.")";
				if(!$con->ejecutarConsulta($query))
					return;
				$idRegistro=$con->obtenerUltimoID();
			}
			else
			{
				$consulta="select situacion,version from 521_registrosPOA where idRegistroPOA=".$obj->idRegistro;
				$filaRegistro=$con->obtenerPrimeraFila($consulta);
				$situacion=$filaRegistro[0];
				$version=$filaRegistro[1];
				if($situacion!="1")
				{
					$x=0;
					$queryAux[$x]="insert into 521_modificacionesRegistrosPOA select * from 521_registrosPOA where idRegistroPOA=".$obj->idRegistro;
					$x++;
					$queryAux[$x]="update 521_registrosPOA set version=version+1 where idRegistroPOA=".$obj->idRegistro;
					$x++;
					$queryAux[$x]="update 521_modificacionesRegistrosPOA set respModif=".$_SESSION["idUsr"]." and fechaModif='".date('Y-m-d')."' where  version=".$version." and idRegistroPOA=".$obj->idRegistro;
					$x++;
					if(!$con->ejecutarBloque($queryAux))
						return;
					
				}
				$query="update 521_registrosPOA set centroCosto='".$obj->centroCosto."',presupuesto='".$obj->presupuesto."',
						codPrograma='".$obj->codPrograma."',proyecto='".$obj->proyecto."',objGasto='".$obj->objGasto."',capitulo='".$capitulo."',producto=".$obj->producto.",
						unidad=".$obj->unidad.",cantidad=".$obj->cantidad.",costoPromedio=".$obj->costoPromedio.",costoTotal=".$obj->costoTotal.",
						periodoAplicacion='".$obj->periodoAplicacion."',cicloFiscal=".$obj->cicloFiscal.",respModif=".$_SESSION["idUsr"].",fechaModif='".date('Y-m-d')."'
						 where idRegistroPOA=".$obj->idRegistro;
				if(!$con->ejecutarConsulta($query))
					return;
				
				$idRegistro=$obj->idRegistro;
			}
			$query="commit";
			if($con->ejecutarConsulta($query))
				echo "1|".$idRegistro;	
			else
				echo "|";
		}
		
		
	}
	
	function eliminarRegPOA()
	{
		global $con;
		$idReg=$_POST["idReg"];
		if($idReg=="")
		{
			echo "1|";
			return;
		}
		$consulta="delete from 521_registrosPOA where idRegistroPOA in (".$idReg.")";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function cambiarEtapaRegistroPOA()
	{
		global $con;
		$registros=$_POST["registros"];
		$etapa=$_POST["etapa"];
		$x=0;
		$comentario="";
		if($registros=="")
		{
			echo "1|";
			return;
		}
		if(isset($_POST["comentario"]))
			$comentario=$_POST["comentario"];
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 521_registrosPOA set situacion=".$etapa." where idRegistroPOA in (".$registros.")";
		$x++;
		$arrReg=explode(",",$registros);
		
		$query="select idProceso from 521_registrosPOA where idRegistroPOA in (".$registros.")";
		$idProceso=$con->obtenerValor($query);
		
		$query="select concat(cuenta,'_',tipoAfectacion,'_',porcAfectacion) as datosCta from 522_afectacionCuentasPOA where idProceso=".$idProceso." and numEtapa=".$etapa;
		$cadCuentas=$con->obtenerListaValores($query);
		$arrCuentasAfectadas=array();
		$afectarCta=false;
		if($cadCuentas!="")
		{
			$arrCuentasAfectadas=explode(",",$cadCuentas);
			$afectarCta=true;
		}
		foreach($arrReg as $reg)
		{
			$query="select * from 521_registrosPOA where idRegistroPOA=".$reg;
			$filaReg=$con->obtenerPrimeraFila($query);
			$consulta[$x]="insert into  521_bitacoraEtapasPOA (etapaActual,fechaCambio,idUsuarioCambio,etapaAnterior,idProceso,idRegistro,comentario)
							values(".$etapa.",'".date('Y-m-d')."',".$_SESSION["idUsr"].",".$filaReg[14].",".$filaReg[22].",".$filaReg[0].",'".cv($comentario)."')";
			$x++;
			
			if($afectarCta)
			{
				foreach($arrCuentasAfectadas as $ctaAfectada)
				{
					$datosCta=explode("_",$ctaAfectada);
					$montoDebe=0;
					$montoHaber=0;
					if($datosCta[1]=="1")
						$montoDebe=$filaReg[12]*($datosCta[2]/100);
					else
						$montoHaber=$filaReg[12]*($datosCta[2]/100);
					$query="select codigo from 508_tiposPresupuesto where codigoUnidad='".$filaReg[3]."'";
					$tPresupuesto=$con->obtenerValor($query);
					$consulta[$x]="insert into 514_asientos(fechaMovimiento,idUsuario,centroCosto,idProyecto,objetoGasto,tipoPresupuesto,cuentaMascara,cuentaSimple,
									montoDebe,montoHaber,idTipocumento,noDocumento,idLibro,concepto,programa) values('".date('Y-m-d')."',".$_SESSION["idUsr"].",'".$filaReg[2]."',
									'".$filaReg[5]."','".$filaReg[6]."','".$tPresupuesto."','".$datosCta[0]."','".str_replace("-","",$datosCta[0])."',".$montoDebe.",".$montoHaber.",
									3,'POA-".$filaReg[0]."',0,'Registro proceso POA',".$filaReg[4].")";
					$x++;
				}
			}
			
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
		
	}
	
	function obtenerEstructurasCuenta()
	{
		global $con;
		$condWhere="";
		$condWhereAux="";
		if(isset($_POST["accion"]))
		{
			
			switch($_POST["accion"])
			{
				case 1: //Deduccion
					$idConsulta=bD($_POST["idConsulta"]);
					$consulta="select codCuentaAfectacion from 661_afectacionesCuentasDeducPercepciones where idDeduccionPercepcion=".$idConsulta." and tipo=1";
					$listCta=$con->obtenerListaValores($consulta,"'");
					if($listCta=="")
						$listCta="''";
					$condWhereAux=" and cuenta not in(".$listCta.")";
				break;
				case 2: //Percepcion
					$idConsulta=bD($_POST["idConsulta"]);
					$consulta="select codCuentaAfectacion from 661_afectacionesCuentasDeducPercepciones where idDeduccionPercepcion=".$idConsulta." and tipo=2";
					$listCta=$con->obtenerListaValores($consulta,"'");
					if($listCta=="")
						$listCta="''";
					$condWhereAux=" and cuenta not in(".$listCta.")";
				break;
			}
			
			
		}
		
		
		if(isset($_POST["filter"]))
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);

		if($condWhere=="")
			$condWhere=" 1=1 ";
		$consulta="select * from (select idCuenta as idCuenta,codigoCompletoCta as cuenta, tituloCta as estructura from 510_cuentas) as temp where 
					cuenta is not null and ".$condWhere." ".$condWhereAux." order by cuenta";
		
		$arrObj=$con->obtenerFilasJson($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObj).'}';	
	}
		
	function guardarPresupuestoPatrocinador()
	{
		global $con;
		$codObjG=$_POST["codObjG"];
        $idPatrocinador=$_POST["idPatrocinador"];
        $valor=$_POST["valor"];
		$idFormulario=$_POST["idFornulario"];
		$idRegistro=$_POST["idRegistro"];
		
		$consultaP="SELECT idPresupuesto FROM 9037_presupuestoRegistro WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND objGasto=".$codObjG." AND patrocinador=".$idPatrocinador;
	    $id=$con->obtenerValor($consultaP);
		if($id=="")
		{
			$query="INSERT INTO 9037_presupuestoRegistro(idFormulario,idReferencia,objGasto,patrocinador,cantidad) 
					VALUES('".$idFormulario."','".$idRegistro."','".$codObjG."','".$idPatrocinador."','".$valor."')";
		}
		else
		{
			$query="UPDATE 9037_presupuestoRegistro SET cantidad=".$valor." WHERE idPresupuesto=".$id;
		}
		
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "2|";
	}
	
	function obtenerInstituciones()
	{
	 	global $con;
	 	$criterio=$_POST["criterio"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$consulta=" (select codigoUnidad,unidad from 817_organigrama where unidad like '".$criterio."%'  and institucion=1 and codigoUnidad not in 
					(SELECT codigoInstitucion FROM 9036_patrocinadoresProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." AND codigoInstitucion IS NOT NULL))";
		
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"codigoUnidad":"'.$fila[0].'","unidad":"'.$fila[1].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$con->filasAfectadas.'","instuciones":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function guardarPatrocinadorProyecto()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$query[$x]="begin";
		$x++;
		if($obj->periodInfTecnico=="")
			$obj->periodInfTecnico='NULL';
		if($obj->periodInfFinanciero=="")
			$obj->periodInfFinanciero='NULL';
		$consulta="SELECT porcentajeRetencion FROM _1018_tablaDinamica WHERE institucionPatrocinadora='".$obj->codigoInstitucion."'";
		$porcentajeRetencion=$con->obtenerValor($consulta);
		if($porcentajeRetencion=="")
		{
			$consulta="SELECT porcentajeRetencion FROM _1019_tablaDinamica";
			$porcentajeRetencion=$con->obtenerValor($consulta);
			if($porcentajeRetencion=="")
				$porcentajeRetencion=0;
		}

		$montoRetencion=$obj->montoPatrocinio*($porcentajeRetencion/100);
		if($obj->idRegistro==-1)
		{
			$query[$x]="INSERT INTO 9036_patrocinadoresProyectos(idFormulario,idReferencia,codigoInstitucion,montoPatrocinio,reqInformeTecnico,periodoInfTecnico,cadaInfTecnico,
					reqInformeFinanciero,periodoInfFinanciero,cadaInfFinanciero,estadoPatrocinio,observaciones,porcentajeRetencion,montoRetencion)
					VALUES(".$idFormulario.",".$idReferencia.",'".$obj->codigoInstitucion."',".$obj->montoPatrocinio.",".$obj->reqInformeTecnico.",".$obj->periodInfTecnico.",".$obj->cadaInfTecnico.",".$obj->reqInformeFinanciero.",".$obj->periodInfFinanciero.
					",".$obj->cadaInfFinanciero.",".$obj->edoPatrocinio.",'".cv($obj->observaciones)."',".$porcentajeRetencion.",".$montoRetencion.")";
			$x++;
			$query[$x]="set @idRegistro=(select LAST_INSERT_ID())";					
		}
		else
		{
			$query[$x]="update 9036_patrocinadoresProyectos set codigoInstitucion='".$obj->codigoInstitucion."',montoPatrocinio=".$obj->montoPatrocinio.",reqInformeTecnico=".$obj->reqInformeTecnico.",periodoInfTecnico=".$obj->periodInfTecnico.",
					cadaInfTecnico=".$obj->cadaInfTecnico.",reqInformeFinanciero=".$obj->reqInformeFinanciero.",periodoInfFinanciero=".$obj->periodInfFinanciero.",cadaInfFinanciero=".$obj->cadaInfFinanciero.",
					estadoPatrocinio=".$obj->edoPatrocinio.",observaciones='".cv($obj->observaciones)."',porcentajeRetencion=".$porcentajeRetencion.",montoRetencion=".$montoRetencion." where idPatrocinador=".$obj->idRegistro;
			$x++;
			$query[$x]="set @idRegistro=".$obj->idRegistro;
			
					
		}
		$x++;
		
		if($con->ejecutarBloque($query))
		{
			$consulta="select @idRegistro";
			$consulta="SELECT idPatrocinador,p.codigoInstitucion,unidad,montoPatrocinio,observaciones,porcentajeRetencion,montoRetencion,(montoPatrocinio-montoRetencion)
			 FROM 9036_patrocinadoresProyectos p,817_organigrama o WHERE o.codigoUnidad=p.codigoInstitucion and idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
			$arrPatrocinio=$con->obtenerFilasArreglo($consulta);
			echo "1|".$arrPatrocinio;
		}
	
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
		
		$consultaAux="SELECT MAX(codigoUnidad) FROM 817_organigrama WHERE unidadPadre='".$obj->codigoUPadre."'";
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
				$codigoUnidadNuevo=$obj->codigoUPadre.str_pad($codInst,$longInstitucion,"0",STR_PAD_LEFT);
				$situacion=1;
				if(isset($obj->institucionPatrocinadora))
					$situacion=-1;
				
				
				
				$query="insert into 817_organigrama(unidad,codigoFuncional,codigoUnidad,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,codigoDepto,claveDepartamental,STATUS) 
						value('".cv($obj->nombre)."','".$codigoUnidadNuevo."','".$codigoUnidadNuevo."','".cv($obj->descripcion)."',".
						$obj->institucion.",'".$codCC."','".$codigoUPadre."','".str_pad($codInst,$longInstitucion,"0",STR_PAD_LEFT)."','".$codUnidad."','',".$situacion.")";
				if($con->ejecutarConsulta($query))		
				{
					$idOrganigrama=$con->obtenerUltimoID();
					if(isset($obj->objInst))
					{
						$objInst=$obj->objInst;
						$ciudad="";
						$municipio="";
						if($objInst->idPais==146)
							$municipio=$objInst->ciudad;
						else
							$ciudad=$objInst->ciudad;
						$consulta[$x]="insert into 247_instituciones(idOrganigrama,cp,ciudad,estado,idPais,fechaCreacion,responsable,municipio) values
						('".$idOrganigrama."','".cv($objInst->cp)."','".cv($ciudad)."','".cv($objInst->estado)."',".cv($objInst->idPais).",'".date("Y-m-d")."',".$_SESSION["idUsr"].",'".$municipio."')";
						$x++;	
						
					}
					if(isset($obj->institucionPatrocinadora))
					{
						$consulta[$x]="INSERT INTO 817_elementosOrganigramaVSCategorias(idOrganigrama,idCategoria)
										VALUES(".$idOrganigrama.",1)";
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
						echo "1|".$codigoUnidadNuevo."|".$obj->nombre;
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
	
	function eliminarPatrocinador()
	{
		global $con;
		$cadena=$_POST["cadena"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$arreglo=explode(',',$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				$codUnidad=$arreglo[$x];
				$query[$ct]="delete from 9036_patrocinadoresProyectos where codUnidad=".$codUnidad." and idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
				$ct++;
				
				$query[$ct]="delete from 9037_presupuestoRegistro where patrocinador=".$codUnidad." and idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
				$ct++;
			}
			
			$query[$ct]="commit";
			
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "2|";
		}
	}
	
	function agregarObjetoGastos()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				$objGasto=$arreglo[$x];
				$query[$ct]="INSERT INTO 9035_objetosGastoPresupuesto(idProceso,objGasto) VALUES('".$idProceso."','".$objGasto."')";
				$ct++;
			
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "2|";
		}
	}
	
	function eliminarObjetoGastos()
	{
		global $con;
		$idProceso=$_POST["idProceso"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT idFormulario FROM 900_formularios WHERE idProceso=".$idProceso." AND formularioBase=1";
			$idFormulario=$con->obtenerValor($consulta);
			
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				$objGasto=$arreglo[$x];
				
				$query[$ct]="DELETE FROM 9035_objetosGastoPresupuesto WHERE idProceso=".$idProceso." AND objGasto=".$objGasto;
				$ct++;
				
				$query[$ct]="delete from 9037_presupuestoRegistro where idFormulario=".$idFormulario." and objGasto=".$objGasto;
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else	
				echo "2|";
		}
	
	}
	
	function obtenerDepertamentosPrograma()
	{
		global $con;
		global $SO;
		
		$idPrograma=$_POST["idPrograma"];
		$ruta=$_POST["ruta"];
		$arrDatos="";
		$consulta="SELECT idDepartamentoVSPrograma,d.codigoUnidad,unidad,partidas,codigoDepto FROM 
					9130_departamentoVSPrograma d,817_organigrama o WHERE idPrograma=".$idPrograma." AND 
					o.codigoUnidad=d.codigoUnidad and ruta='".$ruta."' order by unidad";
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		
		while($filaD=mysql_fetch_row($res))
		{
			$obj='{"idDepartamentoVSPrograma":"'.$filaD[0].'","codUnidad":"'.cv($filaD[1]).'","unidad":"'.cv($filaD[2]).'","partidas":"'.cv($filaD[3]).'","cveDepto":"'.$filaD[4].'"}';
			
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nFilas.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$nFilas.'","registros":['.($arrDatos).']}';
		
		echo $obj;
	}
	
	function obtenerDepertamentosInstitucion()
	{
		global $con;
		global $SO;
		$arrDatos="";
		$idPrograma=$_POST["idPrograma"];
		
		$comp="";
		if(isset($_POST["ruta"]))
			$comp=" and ruta='".$ruta."'";

		$consulta="SELECT codigoUnidad,unidad,descripcion,idOrganigrama,codigoDepto FROM 817_organigrama WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND codigoUnidad NOT IN 
		(SELECT codigoUnidad FROM 9130_departamentoVSPrograma WHERE  idPrograma=".$idPrograma.$comp.") AND institucion=0";

		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		while($filaD=mysql_fetch_row($res))
		{
			$obj='{"codigoUnidad":"'.$filaD[0].'","unidad":"'.cv($filaD[1]).'","descripcion":"'.cv($filaD[2]).'","idOrganigrama":"'.cv($filaD[3]).'","codigoDepto":"'.$filaD[4].'"}';
			
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nFilas.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$nFilas.'","registros":['.($arrDatos).']}';
		
		echo $obj;
	}
	
	function obtenerPartidasDepertamentos()
	{
		global $con;
		global $SO;
		$id=$_POST["id"];
		$arrDatos="";
		$tamano=0;

		$consulta="SELECT * FROM 9130_departamentoVSPrograma WHERE idDepartamentoVSPrograma=".$id ;
		$fila=$con->obtenerPrimeraFila($consulta);
		$partidas=$fila[5];
		if($partidas!="")
		{
			$arreglo=explode(",",$partidas);
			sort($arreglo);
			$tamano=sizeof($arreglo);
			for($x=0;$x<$tamano;$x++)
			{
				$partida=$arreglo[$x];
				$consulta="SELECT nombreObjetoGasto,clave FROM 507_objetosGasto WHERE codigoControl=".$partida."";
				$filaObj=$con->obtenerPrimeraFila($consulta);
				if(!$filaObj)
				{
					$consulta="SELECT nombreObjetoGasto,clave FROM 507_objetosGasto WHERE clave=".$partida."";
					$filaObj=$con->obtenerPrimeraFila($consulta);
				}
				
//				$consulta="select clave from 507_objetosGasto where codigoControl='".$partida."'";
				$consulta="select idObjGastoNoCompra from 9130_departamentoObjGastoNoCompra where idPrograma=".$fila[1]." and ruta='".$fila[6]."' and objetoGasto=".$partida." and departamento='".$fila[3]."' and ciclo=".$fila[4];
				$f=$con->obtenerPrimeraFila($consulta);
				$pComprar="Sí";
				if($f)
					$pComprar="No";
				$obj='{"clave":"'.$filaObj[1].'","nombreObjetoGasto":"'.cv($filaObj[0]).'","codigoControl":"'.$partida.'","idTabla":"'.$id.'","puedeComprar":"'.$pComprar.'"}';
				
				if($arrDatos=="")
					$arrDatos=$obj;
				else
					$arrDatos.=",".$obj;
			}
		}
		if($SO==2)
			$obj='{"numReg":"'.$tamano.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$tamano.'","registros":['.($arrDatos).']}';
		
		echo $obj;
	}
	
	function guardarDepartamentosPrograma()
	{
		global $con;
		
		$idPrograma=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		$cadena=$_POST["cadena"];
		//
		$ruta="";
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			for($x=0;$x<$tamano;$x++)
			{
				$elemento=$arreglo[$x];
				$datos=explode("_",$elemento);
				$codDepto=$datos[0];
				$idO=$datos[1];
				if(isset($_POST["ruta"]))
					$ruta=$_POST["ruta"];
				$query[$ct]="INSERT INTO 9130_departamentoVSPrograma(idPrograma,idOrganigrama,codigoUnidad,ciclo,ruta) 
							VALUES('".$idPrograma."','".$idO."','".$codDepto."','".$idCiclo."','".$ruta."')";
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		
		}
	}
	
	function eliminarDepartamentoPrograma()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="commit";
		
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				$id=$arreglo[$x];
				$query[$ct]="DELETE FROM 9130_departamentoVSPrograma WHERE idDepartamentoVSPrograma=".$id;
				$ct++;
			
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerPartidas()
	{
		global $con;
		global $SO;

		$comp="";
		if(isset($_POST["capitulo"]))
		{
			$comp=" and codigoControlPadre like '".$_POST["capitulo"]."%'";
		}
		$arrDatos="";
		$consulta="SELECT nombreObjetoGasto as nombre,clave,codigoControl FROM 507_objetosGasto WHERE nivel=3 ".$comp." order by clave";
		$res=$con->obtenerfilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		while($filaD=mysql_fetch_row($res))
		{
			$obj='{"nombre":"'.$filaD[0].'","clave":"'.cv($filaD[1]).'","codigoControl":"'.$filaD[2].'"}';
			
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nFilas.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$nFilas.'","registros":['.($arrDatos).']}';
		
		echo $obj;
	}
	
	function guardarPartidasVSDeptos()
	{
		global $con;
		
		$idProgra=$_POST["idPrograma"];
		$idCiclo=$_POST["idCiclo"];
		$cadenaDeptos=$_POST["cadenaDeptos"];
		$arregloDeptos=explode(",",$cadenaDeptos);
		$tamanoDeptos=sizeof($arregloDeptos);
		$cadenaObjetos=$_POST["cadena"];
		$arregloObjetos=explode(",",$cadenaObjetos);
		$tamanoObjetos=sizeof($arregloObjetos);
		
		$consulta="begin";
		if($con->ejecutarconsulta($consulta))
		{
			$ct=0;
			
			for($x=0;$x<$tamanoDeptos;$x++)
			{
				$elemento=$arregloDeptos[$x];
				
				$conPartidas="SELECT partidas FROM 9130_departamentoVSPrograma WHERE idDepartamentoVSPrograma=".$elemento;
				$partidas=$con->obtenerValor($conPartidas);
				
				$arregloPartidas=explode(",",$partidas);
				for($y=0;$y<$tamanoObjetos;$y++)
				{
					$objeto=$arregloObjetos[$y];
					
					if(!existeValor($arregloPartidas,$objeto))
					{
							array_push($arregloPartidas,$objeto);
					}
				
				}
				$tamano=sizeof($arregloPartidas);
				$cadenaInsertar="";
				for($z=0;$z<$tamano;$z++)
				{
					$objC=$arregloPartidas[$z];
					
					if($cadenaInsertar=="")
						$cadenaInsertar=$objC;
					else
						$cadenaInsertar.=",".$objC;
				}
				
				$query[$ct]="UPDATE 9130_departamentoVSPrograma SET partidas='".cv($cadenaInsertar)."' WHERE idDepartamentoVSPrograma=".$elemento;
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function obtenerProgramas()
	{
		global $con;
		global $SO;
		$idCiclo=$_POST["idCiclo"];
		
		$consulta="SELECT idPrograma,tituloPrograma,cvePrograma FROM 517_programas p WHERE estado=1 and idPrograma NOT IN (SELECT idPrograma FROM 9131_programaVSCiclo WHERE ciclo=".$idCiclo.")";
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		$arrDatos="";
		
		while($filaD=mysql_fetch_row($res))
		{
			$obj='{"idPrograma":"'.$filaD[0].'","tituloPrograma":"'.cv($filaD[1]).'","cvePrograma":"'.cv($filaD[2]).'"}';
			
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nFilas.'","registros":['.($arrDatos).']}';
		else
			$obj='{"numReg":"'.$nFilas.'","registros":['.($arrDatos).']}';
		
		echo $obj;
	}
	
	function agregarProgramasCiclo()
	{
		global $con;
		
		$idCiclo=$_POST["idCiclo"];
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			
			for($x=0;$x<$tamano;$x++)
			{
				$idPrograma=$arreglo[$x];
				$query[$ct]="INSERT INTO 9131_programaVSCiclo(idPrograma,ciclo,codigoInstitucion) VALUES('".$idPrograma."','".$idCiclo."','".$_SESSION["codigoInstitucion"]."') ";
				$ct++;
			}
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
	}
	
	function eliminarProgramasCiclo()
	{
		global $con;
		$idPrograma=base64_decode($_POST["idPrograma"]);
		$idCiclo=$_POST["idCiclo"];
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="DELETE FROM 9131_programaVSCiclo WHERE idPrograma=".$idPrograma." AND ciclo=".$idCiclo." AND codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$x++;
		$query[$x]="DELETE FROM 9130_departamentoVSPrograma WHERE ciclo=".$idCiclo." AND idPrograma=".$idPrograma." and codigoUnidad='".$_SESSION["codigoInstitucion"]."'";
		$x++;
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
	}
	
	function eliminarPartidaDepto()
	{
		global $con;
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$idTabla=$_POST["idTabla"];
		
		$conPartidas="SELECT partidas FROM 9130_departamentoVSPrograma WHERE idDepartamentoVSPrograma=".$idTabla;
		$partidas=$con->obtenerValor($conPartidas);
		$arregloPartidas=explode(",",$partidas);
		$tamanoPartidas=sizeof($arregloPartidas);
		
		$cadenaInsertar="";
		for($x=0;$x<$tamanoPartidas;$x++)
		{
			$elemento=$arregloPartidas[$x];
			if(!existeValor($arreglo,$elemento))
			{
				if($cadenaInsertar=="")
					$cadenaInsertar=$elemento;
				else	
					$cadenaInsertar.=",".$elemento;
			}
		}
		
		
		$query="UPDATE 9130_departamentoVSPrograma SET partidas='".cv($cadenaInsertar)."' WHERE idDepartamentoVSPrograma=".$idTabla;
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerCalculosAplicadosNomina()
	{
		global $con;
		//$idUsuario=$_POST["idUsuario"];
		$idUsuario="11618";
		if($idUsuario=="-1")
			$consulta="select d.idCalculo,c.codigo,c.nombreConsulta,afectacionNomina,quincenaAfectacion,nQuincenasAfectacion,cicloAfectacion,tipoCalculo,c.idConsulta ,orden 
						from 662_calculosNomina d,991_consultasSql c where c.idConsulta=d.idConsulta and idUsuarioAplica is null order by orden";	
		else
			$consulta="select d.idCalculo,c.codigo,c.nombreConsulta,afectacionNomina,quincenaAfectacion,nQuincenasAfectacion,cicloAfectacion,tipoCalculo,c.idConsulta ,orden 
						from 662_calculosNomina d,991_consultasSql c where c.idConsulta=d.idConsulta and idUsuarioAplica = ".$idUsuario." order by orden";
		
		$arrCalculos="";
		$resCalculos=$con->obtenerFilas($consulta);	
		$param="";
		$afectacion="";
		$nQuincenasAfectacion="";
		$afectacionCtas="";
						
		while($fila=mysql_fetch_row($resCalculos))
		{

				$param="<table>";
                $consulta="select idParametro,parametro from 993_parametrosConsulta where idConsulta=".$fila[8]." order by parametro";
				$resParam=$con->obtenerFilas($consulta);
				while($filaP=mysql_fetch_row($resParam))
				{
					$consulta="select valor,tipoValor from 663_valoresCalculos where idCalculo=".$fila[0]." and idParametro=".$filaP[0];
					$filaValParam=$con->obtenerPrimeraFila($consulta);
					$valor=$filaValParam[0];
					if($filaValParam[1]=="2")
					{
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
					}
					$param.="<tr height='21'><td valign='top'><b><span class='letraExt'>".$filaP[1]."=</span></b></td><td width='3'></td>
								<td valign='top'><span id='lblValor_".$fila[0]."_".$filaP[0]."'>".$valor."</span></td><td valign='top'>&nbsp;
								<a href='javascript:modificarValorParametro(\"".bE($fila[0])."\",\"".bE($filaP[0])."\",\"".bE($fila[9])."\")'>
								<img src='../images/pencil.png' title='Modificar valor par&aacute;metro' alt='Modificar valor par&aacute;metro'></a>
								</td>
							</tr>";
				}
										
                $param.="</table>";

			$obj='{
					"idCalculo":"'.$fila[0].'",
					"orden":"'.$fila[9].'",
					"tipoCalculo":"'.$fila[7].'",
					"codigo":"'.$fila[1].'",
					"nombreConsulta":"'.$fila[2].'",
					"parametros":"'.bE($param).'",
					"afectacionNomina":"'.$afectacion.'",
					"nQuincenasAfectacion":"'.$nQuincenasAfectacion.'",
					"afectacionCuentas":"'.$afectacionCtas.'",
					"cicloAfectacion":"'.$fila[6].'"
				}';
			if($arrCalculos=='')
				$arrCalculos=$obj;
			else
				$arrCalculos.=",".$obj;
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$arrCalculos.']}';
	}
	
	function guardarAcumulador()
	{
		global $con;
		$idAcumulador=$_POST["idAcumulador"];
		$nAcumulador=$_POST["nAcumulador"];
		$nivelAcumulador=$_POST["nivelAcumulador"];
		$idUsuario=$_POST["idUsuario"];
		$idPerfil="-1";
		if(isset($_POST["idPerfil"]))
			$idPerfil=$_POST["idPerfil"];
		if($idAcumulador=="-1")
			$consulta="insert into 665_acumuladoresNomina(nombreAcumulador,codigoInstitucion,nivelAcumulador,idUsuario,idPerfil) values('".$nAcumulador."','".$_SESSION["codigoInstitucion"]."',".$nivelAcumulador.",".$idUsuario.",".$idPerfil.")";
		else	
			$consulta="update 665_acumuladoresNomina set nombreAcumulador='".$nAcumulador."' where idAcumuladorNomina=".$idAcumulador;
		if($con->ejecutarConsulta($consulta))
		{
			$nivelAcumulador="0";
			if($idUsuario!="NULL")
			{
				$nivelAcumulador="1";
				$consulta="select idAcumuladorNomina,nombreAcumulador from 665_acumuladoresNomina where 
						codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and nivelAcumulador in  (".$nivelAcumulador.") and idUsuario=".$idUsuario;
		
			}
			else
			{
				$consulta="select idAcumuladorNomina,nombreAcumulador from 665_acumuladoresNomina where 
							nivelAcumulador in  (".$nivelAcumulador.") and idPerfil=".$idPerfil;
			}
			
			
			$arrConsulta=$con->obtenerFilasArreglo($consulta);
			echo "1|".uEJ($arrConsulta);
			
		}
		else
			echo "|";
	}
	
	function removerAcumulador()
	{
		global $con;
		$idAcumulador=$_POST["idAcumulador"];
		$consulta="delete from 665_acumuladoresNomina where idAcumuladorNomina=".$idAcumulador;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		
	}
	
	function guardarAsignacionOperacion()
	{
		global $con;
		$idCalculo=$_POST["idCalculo"];
		$idAcumulador=$_POST["idAcumulador"];
		$operacion=$_POST["operacion"];
		$consulta="insert into 666_acumuladoresCalculo(idCalculo,idAcumulador,operacion) values(".$idCalculo.",".$idAcumulador.",'".$operacion."')";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
	}
	
	function removerAsignacionAcumulador()
	{
		global $con;
		$idAcumulador=$_POST["idAcumulador"];
		$consulta="delete from 666_acumuladoresCalculo where idAcumuladorCalculo=".$idAcumulador;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		
	}
	
	function guardarConceptosNomina()
	{
		global $con;
		$cadObj=$_POST["cadObj"];	
		
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$consulta[$x]="UPDATE 991_consultasSql SET nombreConsulta='".cv($obj->identificador)."',descripcion='".cv($obj->descripcion)."',
				codigo='".cv($obj->codigo)."',idTipoConcepto=".$obj->tipoConcepto.",ambitoAplicacion=".$obj->ambito." where idConsulta=".$obj->idConcepto;
		$x++;
		
		$consulta[$x]="DELETE FROM 994_valoresDevueltoFuncion WHERE idConsulta=".$idConsulta;
		$x++;
		
		
		
		
		foreach($obj->arrValoresDevueltos as $o)
		{
			$consulta[$x]="INSERT INTO 994_valoresDevueltoFuncion(idConsulta,nombreValor,descripcion) VALUES(".$idConsulta.",'".cv($o->nombreValor)."','".cv($o->descripcion)."')";
			$x++;
			
		}
		
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarPuestosCalculosAsoc()
	{
		global $con;
		$listaPuestos=$_POST["listaPuestos"];
		$iCalculo=$_POST["idCalculo"];	
		$arrListPuesto=explode(",",$listaPuestos);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrListPuesto as $puesto)
		{
			$query="SELECT cvePuesto FROM 819_puestosOrganigrama WHERE idPuesto=".$puesto;
			$cvePuesto=$con->obtenerValor($query);
			$consulta[$x]="insert into 9115_calculosVSPuestos(idCalculo,cvePuesto,idPuesto) values(".$iCalculo.",'".$cvePuesto."',".$puesto.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$consulta="SELECT idCalculoVSPuesto,po.cvePuesto,po.puesto FROM 9115_calculosVSPuestos c,819_puestosOrganigrama po WHERE po.idPuesto=c.idPuesto
					and  idCalculo=".$iCalculo." ORDER BY po.puesto";
			$arrPuestos=$con->obtenerFilasArreglo($consulta);
			echo "1|".$arrPuestos."";	
		}
	}
	
	function removerPuestoCalculo()
	{
		global $con;
		$listPuesto=$_POST["listPuesto"];
		$consulta="DELETE FROM 9115_calculosVSPuestos WHERE idCalculoVSPuesto IN (".$listPuesto.")";
		eC($consulta);
	}

	
	function obtenerDefinicionFactor()
	{
		global $con;
		$idFactor=$_POST["idFactor"];
		$consulta="SELECT departamento,unidad FROM 670_factoresVSDepartamento f,817_organigrama o WHERE o.codigoUnidad=f.departamento and idFactor=".$idFactor." order by unidad";
		$resUnidades=$con->obtenerFilas($consulta);
		$arrUnidades="";
		$ct=1;
		while($filaUnidad=mysql_fetch_row($resUnidades))
		{
			$consulta="SELECT d.cvePuesto,p.puesto,valor,if(tipoValor=0,'Unidad','Porcentaje') as tipoValor,idDefinicionFactor FROM 669_definicionFactoresNomina d,819_puestosOrganigrama p 
						WHERE p.cvePuesto=d.cvePuesto and idFactor=".$idFactor." AND departamento='".$filaUnidad[0]."' ORDER BY p.puesto";
			$resPuesto=$con->obtenerFilas($consulta);
			$arrPuestos="";
			while($filaPuesto=mysql_fetch_row($resPuesto))
			{
				$oPuesto='{"id":"'.$filaPuesto[4].'","text":"'.$filaPuesto[1].'","tipo":"2","valor":"'.number_format($filaPuesto[2],2).'","tipoValor":"'.$filaPuesto[3].'","cvePuesto":"'.$filaPuesto[0].'","uiProvider":"col","leaf":true,"icon":"../images/user.png"}';
				if($arrPuestos=="")
					$arrPuestos=$oPuesto;
				else
					$arrPuestos.=",".$oPuesto;
			}
			$comp="";
			if($arrPuestos=="")
				$comp=',"leaf":true';
			else					
				$comp=',"leaf":false,"children":['.$arrPuestos.']';	
			$oUnidad='{"id":"d'.$ct.'","codigoDepto":"'.$filaUnidad[0].'","text":"'.$filaUnidad[1].'","tipo":"1","uiProvider":"col","icon":"../images/users.png"'.$comp.'}';	
			$ct++;
			if($arrUnidades=="")
				$arrUnidades=$oUnidad;
			else
				$arrUnidades.=",".$oUnidad;
		}
		echo "[".$arrUnidades."]";
	}
	
	function eliminarUnidadDepto()
	{
		global $con;
		$tipo=$_POST["tipo"];
		$valor=$_POST["valor"];
		$idFactor=$_POST["idFactor"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($tipo==1)
		{
			$consulta[$x]="delete from 670_factoresVSDepartamento where departamento='".$valor."' and idFactor=".$idFactor;
			$x++;
			$consulta[$x]="delete from 669_definicionFactoresNomina where departamento='".$valor."' and idFactor=".$idFactor;
			$x++;
		}
		else
		{
			$consulta[$x]="delete from 669_definicionFactoresNomina where idDefinicionFactor=".$valor;
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerDeptosDisponiblesFactor()
	{
		global $con;
		$idFactor=$_POST["idFactor"];
		$consulta="select departamento from 670_factoresVSDepartamento where idFactor=".$idFactor;
		$listFactores=$con->obtenerListaValores($consulta,"'");
		if($listFactores=="")
			$listFactores="''";
		$consulta="select codigoUnidad,unidad from 817_organigrama where status=1 and instColaboradora=0 and codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and codigoUnidad not in (".$listFactores.") order by unidad";
		$arrUnidades=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrUnidades);
	}
	
	function guardarVinculacionDeptoFactor()
	{
		global $con;
		$listDeptos=$_POST["listDeptos"];
		$idFactor=$_POST["idFactor"];
		$arrDeptos=explode(",",$listDeptos);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrDeptos as $depto)
		{
			$consulta[$x]="insert into 670_factoresVSDepartamento(idFactor,departamento) values (".$idFactor.",".$depto.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
			
	}
	
	function obtenerPuestosDisponiblesFactor()
	{
		global $con;
		$idFactor=$_POST["idFactor"];
		$codDepto=$_POST["codDepto"];
		$consulta="select cvePuesto from 669_definicionFactoresNomina where idFactor=".$idFactor." and departamento='".$codDepto."'";
		$listFactores=$con->obtenerListaValores($consulta,"'");
		if($listFactores=="")
			$listFactores="''";
		$consulta="select distinct cvePuesto,puesto,'' as valor,'0' as tipoValor from 653_unidadesOrgVSPuestos u,819_puestosOrganigrama p where p.idPuesto=u.idPuesto 
					and u.codUnidad='".$codDepto."' and u.codUnidad not in (".$listFactores.") order by puesto";
		$arrUnidades=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($arrUnidades);
	}
	
	function guardarPuestoFactor()
	{
		global $con;
		$cveFactor=$_POST["cveFactor"]	;
		$departamento=$_POST["departamento"];
		$idFactor=$_POST["idFactor"];
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->arrObj as $e)
		{
			$consulta[$x]="insert into 669_definicionFactoresNomina(idFactor,cveFactor,departamento,cvePuesto,valor,tipoValor,ciclo,periodo) 
						values(".$idFactor.",'".$cveFactor."','".$departamento."','".cv($e->cvePuesto)."','".$e->valor."',".$e->tipoValor.",".$e->ciclo.",".$e->periodo.")";
			$x++;	
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function asignarValorTodosPuestos()
	{
		global $con;
		$idFactor=$_POST["idFactor"];
		$valor=$_POST["valor"]	;
		$tipoValor=$_POST["tipoValor"];
		$cveFactor=$_POST["cveFactor"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 669_definicionFactoresNomina WHERE idFactor=".$idFactor;
		$x++;
		$consulta[$x]="DELETE FROM 670_factoresVSDepartamento WHERE idFactor=".$idFactor;
		$x++;
		$consulta[$x]="INSERT INTO 669_definicionFactoresNomina(idFactor,cveFactor,departamento,cvePuesto,valor,tipoValor)
						VALUE(".$idFactor.",'".$cveFactor."','-1','-1',".$valor.",".$tipoValor.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function removerAsignacionTodosPuestos()
	{
		global $con;
		$idFactor=$_POST["idFactor"];
		$consulta="delete from 669_definicionFactoresNomina where idFactor=".$idFactor." and departamento='-1' and cvePuesto='-1'";
		eC($consulta);
			
	}
	
	function factorRiesgoUsuario ()
	{
		global $con;
		global $SO;
		$idFactor=$_POST["idFactor"];
		$consulta="SELECT f.idUsuario,CONCAT(Paterno,' ',Materno,' ',Nom)AS nombre,IF(idTipoValor=0,'Unidad','Porcentaje') AS idTipoValor,cantidad,IF(estado=0,'Inactivo','Activo') AS estado,idUsuarioVSRiesgo,ciclo,periodo 
				   FROM 802_identifica i,9135_usuarioVSFactorRiesgo f 
				   WHERE i.idUsuario=f.idUsuario and idFactorRiesgo=".$idFactor." and estado=0 order by Paterno";
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		$cadena="";
		
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"idUsuarioVSRiesgo":"'.$fila[5].'","idUsuario":"'.$fila[0].'","nombre":"'.$fila[1].'","tipoValor":"'.$fila[2].'","cantidad":"'.number_format($fila[3],2).'","estado":"'.$fila[4].'","ciclo":"'.$fila[6].'","periodo":"'.$fila[7].'"}';
			
			if($cadena=="")
				$cadena=$obj;
			else
				$cadena.=",".$obj;
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nFilas.'","registros":['.($cadena).']}';
		else
			$obj='{"numReg":"'.$nFilas.'","registros":['.($cadena).']}';
		
		echo $obj;
	
	}
	
	function buscarUsuarioInstitucion()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		$codInst=$_POST["codInst"];
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="select i.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status,Institucion from 802_identifica i, 801_adscripcion a  where Paterno like '".$criterio."%' and Institucion='".$codInst."' and i.idUsuario=a.idUsuario  order by Paterno,Materno,Nom asc";
			break;
			case "2": //Materno
				$consulta=" (select i.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status,Institucion from 802_identifica i, 801_adscripcion a where Materno like '".$criterio."%' and Institucion='".$codInst."' and i.idUsuario=a.idUsuario order by Materno,Paterno,Nom asc)";
			break;
			case "3": //Nombre
				$consulta=" (select i.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status,Institucion from 802_identifica i, 801_adscripcion a where Nom like '".$criterio."%' and Institucion='".$codInst."'  and i.idUsuario=a.idUsuario  order by Nom,Paterno,Materno asc)";
			break;
		}
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		$ct=1;
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
			//echo $consulta;
			$resRol=$con->obtenerFilas($consulta);
			$situaciones="";
			while($filaRol=mysql_fetch_row($resRol))
			{
				if($filaRol[0]=='17_0')
				{
					$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'","Status":"'.$situaciones.'","codigoUnidad":"'.$fila[6].'"}';
					if($arrDatos=="")
						$arrDatos=$obj;
					else
						$arrDatos.=",".$obj;
					$ct++;	
				}
			}
		}
		
		$obj='{"num":"'.$ct.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function guardarUsuarioFactor()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idFactor=$_POST["idFactor"];
		$cantidad=$_POST["cantidad"];
		$tipo=$_POST["tipo"];
		$idCiclo=$_POST["idCiclo"];
		$periodo=$_POST["idQ"];
		
		$consulta="SELECT idUsuarioVSRiesgo FROM 9135_usuarioVSFactorRiesgo WHERE idUsuario=".$idUsuario." AND idFactorRiesgo=".$idFactor." AND ciclo=".$idCiclo." AND periodo='".$periodo."'";
		$id=$con->obtenerValor($consulta);
		if($id=="")
		{
			$query="INSERT INTO 9135_usuarioVSFactorRiesgo(idUsuario,idFactorRiesgo,idTipoValor,cantidad,estado,ciclo,periodo) 
					VALUES(".$idUsuario.",".$idFactor.",".$tipo.",".$cantidad.",0,".$idCiclo.",'".$periodo."')";
			if($con->ejecutarConsulta($query))		
				echo "1|";
			else
				echo "|";
		}
		else
		{
			echo "2|";
		}
		
	}
	
	function borrarUsuarioFactor()
	{
		global $con;
		
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		$consulta="begin";
		
		if($con->ejecutarconsulta($consulta))
		{
			$ct=0;
			
			for($x=0;$x<$tamano;$x++)
			{
			
				$query[$ct]="DELETE FROM 9135_usuarioVSFactorRiesgo WHERE idUsuarioVSRiesgo=".$arreglo[$x];
				$ct++;
			}
			
			$query[$ct]="commit";
			
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "2|";
		}
	}
	
	function obtenerEtapasMovimiento()
	{
		global $con;
		
		$consulta="SELECT numEtapa,descripcionEtapa FROM _649_gridEtapaMovimiento ORDER BY numEtapa";		
		$arrEtapas=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrEtapas;
	}
	
	function obtenerFormularioAsociado()
	{
		global $con;
		$tipoPago=$_POST["tipoPago"];
		$consulta="SELECT cmbFormularioAsocidado FROM _651_tablaDinamica WHERE id__651_tablaDinamica=".$tipoPago;
		$idFormulario=$con->obtenerValor($consulta);
		$ancho=0;
		$alto=0;
		$titulo="";
		if($idFormulario=="")
		
			$idFormulario="-1";
		if($idFormulario!="-1")
		{
			$consulta="select titulo,anchoGrid,altoGrid from 900_formularios where idFormulario=".$idFormulario;
			$filaForm=$con->obtenerPrimeraFila($consulta);	
			$ancho=$filaForm[1];
			$alto=$filaForm[2];
			$titulo=$filaForm[0];
		}
			
		echo "1|".$idFormulario."|".$ancho."|".$alto."|".$titulo;
			
	}
	
	function generarSerieAleatoria()
	{
		global $con;
		$valido=false;
		$codigo="";
		while(!$valido)
		{
			$codigo=generarCadenaAleatoria("0123456789",10);
			$consulta="SELECT idUsuario FROM 801_adscripcion  WHERE codigoRegAsistencia='".$codigo."'";
			$fila=$con->obtenerPrimeraFila($consulta);
			if(!$fila)
				$valido=true;
		
		}
		echo "1|".$codigo;
	}
	
	function obtenerQuincenasCiclo()
	{
		global $con;
		
		$idCiclo=$_POST["idCiclo"];
		
		$consulta="SELECT noQuincena,noQuincena FROM 656_calendarioNomina WHERE ciclo=2011 ORDER BY noQuincena";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		
		echo "1|".$arreglo;
	}
	
	function historialQuincenasCicloUsuario()
	{
		global $con;
		global $SO;
		$idFactor=$_POST["idFactor"];
		
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
		
		$consulta="SELECT f.idUsuario,CONCAT(Paterno,' ',Materno,' ',Nom)AS nombre,IF(idTipoValor=0,'Unidad','Porcentaje') AS idTipoValor,cantidad,IF(estado=0,'Inactivo','Activo') AS estado,idUsuarioVSRiesgo,ciclo,periodo 
				   FROM 802_identifica i,9135_usuarioVSFactorRiesgo f 
				   WHERE i.idUsuario=f.idUsuario and idFactorRiesgo=".$idFactor." and estado=1 ".$condWhere." order by ASC ciclo,ASC periodo";
		//echo $consulta;
		$res=$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		
		$cadena="";
		
		while($fila=mysql_fetch_row($res))
		{
			$obj='{"idUsuarioVSRiesgo":"'.$fila[5].'","idUsuario":"'.$fila[0].'","nombre":"'.$fila[1].'","tipoValor":"'.$fila[2].'","cantidad":"'.number_format($fila[3],2).'","estado":"'.$fila[4].'","ciclo":"'.$fila[6].'","periodo":"'.$fila[7].'"}';
			
			if($cadena=="")
				$cadena=$obj;
			else
				$cadena.=",".$obj;
		}
		
		if($SO==2)
			$obj='{"numReg":"'.$nFilas.'","registros":['.($cadena).']}';
		else
			$obj='{"numReg":"'.$nFilas.'","registros":['.($cadena).']}';
		
		echo $obj;
		
	}
	
	function removerPatrocinador()
	{
		global $con;
		$idPatrocinador=$_POST["idPatrocinador"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 9036_patrocinadoresProyectos where idPatrocinador=".$idPatrocinador;
		$x++;
		$consulta[$x]="delete from 9036_distribucionPresupuesto where idPresupuesto=".$idPatrocinador;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);

	}
	
	function obtenerInstitucionPatrocinadora()
	{
		global $con;
		$idPatrocinador=$_POST["idPatrocinador"];
		$consulta="SELECT codigoInstitucion,(SELECT unidad FROM 817_organigrama WHERE codigoUnidad=p.codigoInstitucion) AS institucion,montoPatrocinio,reqInformeTecnico,periodoInfTecnico,cadaInfTecnico,
					reqInformeFinanciero,periodoInfFinanciero,cadaInfFinanciero,estadoPatrocinio,observaciones FROM 9036_patrocinadoresProyectos p WHERE idPatrocinador=".$idPatrocinador;
		$fila=$con->obtenerPrimeraFila($consulta);		
		/*$consulta="SELECT monto FROM 9036_distribucionPresupuesto WHERE idPresupuesto=".$idPatrocinador." ORDER BY numMes";				
		$arrMeses=$con->obtenerListaValores($consulta,"'");*/
		$cadObj='{"codigoInstitucion":"'.$fila[0].'","institucion":"'.$fila[1].'","montoPatrocinio":"'.$fila[2].'","reqInfTecnico":"'.$fila[3].'","periodoInfTecnico":"'.$fila[4].'","cadaInfTecnico":"'.$fila[5].'","reqInfFinanciero":"'.$fila[6].'",
				"periodoInfFinanciero":"'.$fila[7].'","cadaInfFinanciero":"'.$fila[8].'","estadoPatrocinio":"'.$fila[9].'","observaciones":"'.cv($fila[10]).'"}';	
		echo "1|".$cadObj;
	}
	
	function marcarPuedeComprar()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="delete from 9130_departamentoObjGastoNoCompra where idPrograma=".$obj->idPrograma." and ruta='".$obj->ruta."' and objetoGasto in(".$obj->partidas.") and departamento='".$obj->departamento."' and ciclo=".$obj->ciclo;
		eC($consulta);
	}
	
	function marcarNoPuedeComprar()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$arrPartidas=explode(",",$obj->partidas);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($arrPartidas as  $p)
		{
			$consulta[$x]="insert into 9130_departamentoObjGastoNoCompra(idPrograma,ruta,objetoGasto,departamento,ciclo) values(".$obj->idPrograma.",'".$obj->ruta."',".$p.",'".$obj->departamento."',".$obj->ciclo.")";

			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
	}
	
	function obtenerContraRecibos()
	{
		global $con;
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$consulta="SELECT idContrarecibo,tipoMovimiento,concepto,noFactura,fechaRecepcion,p.txtRazonSocial2,montoFactura,ivaFactura,totalFactura,retencion,fechaPago,descuento,noPedido,noContraRecibo FROM 597_contrarecibos c,_405_tablaDinamica
					p WHERE p.id__405_tablaDinamica=c.idProveedor and ".$cadCondWhere." LIMIT ".$start.",".$limit;
		$arrObj=$con->obtenerFilasJson($consulta);
		$consulta="SELECT idContrarecibo,tipoMovimiento,concepto,noFactura,fechaRecepcion,p.txtRazonSocial2,montoFactura,ivaFactura,totalFactura,retencion,fechaPago,descuento,noPedido FROM 597_contrarecibos c,_405_tablaDinamica
					p WHERE p.id__405_tablaDinamica=c.idProveedor";
		$con->obtenerFilas($consulta);
		$nFilas=$con->filasAfectadas;
		echo '{"numReg":"'.$nFilas.'","registros":'.$arrObj.'}';
	}
	
	function obtenerObjetosGastoCapitulo()
	{
		global $con;
		$capitulo=$_POST["capitulo"];
		$consulta="SELECT codigoControl,CONCAT('[',clave,'] ',nombreObjetoGasto) AS objetoGasto  FROM 507_objetosGasto 
					WHERE STATUS=1 AND nivel=3 AND codigoControlPadre LIKE '".$capitulo."%' ORDER BY clave";
		$arrObjetosGasto=$con->obtenerFilasArreglo($consulta);					
		echo "1|".$arrObjetosGasto;
	}
	
	function obtenerCuentasCheques()
	{
		global $con;
		$idBanco=$_POST["idBanco"];
		$consulta="SELECT id__944_tablaDinamica,dteFechaApertura,numCuenta,clabe,divisas,folioInicial,folioSiguiente,situacion FROM _944_tablaDinamica
					WHERE idReferencia=".$idBanco;
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
			
	}
	
	function eliminarBanco()
	{
		global $con;
		$idBanco=$_POST["idBanco"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 600_bancos where idBanco=".$idBanco;
		$x++;
		$consulta[$x]="DELETE FROM 602_cuentasCheques WHERE idBanco=".$idBanco;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
			
	}
	
	function obtenerDatosConceptos()
	{
		global $con;
		$idConcepto=$_POST["idConcepto"];
		$tGrid=$_POST["tGrid"];
		switch($tGrid)
		{
			case 1:
				$consulta="SELECT idAfectacion as idRegistro,cuentaAfectacion,porcentaje as porcentajeAfectacion,tipoAfectacion,idFuncionAplicacion,(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=a.idFuncionAplicacion)AS funcionEjecucion 
							FROM 599_afectacionContableMovimiento a WHERE idPerfilMovimiento=".$idConcepto;
			break;
			case 2:
				$consulta="SELECT idAfectacion,nombreTiempo AS tiempoPresupuestal,porcentajeAfectacion,tipoAfectacion,idFuncionAplicacion,(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=t.idFuncionAplicacion)AS funcionEjecucion 
						FROM 599_afectacionPresupuestalMovimiento t,524_tiemposPresupuestales p WHERE 
						idPerfilMovimiento=".$idConcepto." AND  p.idTiempoPresupuestal=t.tiempoPresupuestal";
			break;
			case 3:
				$consulta="SELECT idFolio,prefijo,separador,longitud,fInicial,incremento,fActual,situacion FROM 597_foliosMovimientos
							WHERE idPerfilMovimiento=".$idConcepto;
			break;
		}
		$arrConsulta=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrConsulta).'}';
	}
	
	function eliminarCuentaBancaria()
	{
		global $con;
		$idCuenta=$_POST["idCuenta"];
		$consulta="delete from _944_tablaDinamica where id__944_tablaDinamica=".$idCuenta;
		eC($consulta);
	}
	
	function obtenerAdeudosOrdenPago()
	{
		global $con;
		$noOrdenPago=$_POST["noOrdenPago"];
		if($noOrdenPago=="")
			$noOrdenPago=-1;
		$consulta="SELECT * FROM 555_adeudosCliente WHERE ordenPago=".$noOrdenPago." AND situacion=1";
		$resAdeudos=$con->obtenerFilas($consulta);
		if($con->filasAfectadas==0)
		{
			echo "1|-1";
			return;
		}
		$ct=0;
		$arrAdeudos="";
		$arrConceptos=obtenerCatalogosTipoConcepto();
		$idCliente="";
		$tCliente="";
		$nombreCliente="";
		while($fila=mysql_fetch_row($resAdeudos))
		{
			if($ct==0)
			{
				$consulta="SELECT * FROM 599_tiposPersonasAfectacionContable WHERE idTipoBeneficiario=".$fila[4];
				$fCliente=$con->obtenerPrimeraFila($consulta);
				$consulta="select ".str_replace('"',"",$fCliente[2])." from ".$fCliente[1]." where ".$fCliente[3]."=".$fila[3];
				$fDatosCliente=$con->obtenerPrimeraFila($consulta);
				$idCliente=$fila[3];
				$tCliente=$fila[4];
				$nombreCliente=$fDatosCliente[0];
			}
			$ct++;
			$fCon=$arrConceptos[$fila[2]];
			if($fCon["campoClave"]=="")
				$fCon["campoClave"]="'' as clave";
			$consulta="select ".$fCon["campoClave"].",".$fCon["campoDescripcion"]." from ".$fCon["tabla"]." where ".$fCon["campoId"]."=".$fila[1];
			$fConcepto=$con->obtenerPrimeraFila($consulta);
			$obj="['".$fila[0]."','".$fConcepto[0]."','".$fConcepto[1]."','".$fila[6]."','".$fila[7]."','".$fila[8]."','".$fila[9]."','".$fila[11]."','".$fila[11]."','".$fila[14]."']";
			if($arrAdeudos=="")
				$arrAdeudos=$obj;
			else
				$arrAdeudos.=",".$obj;
		}
		
		$cadObj='{"idCliente":"'.$idCliente.'","tipoCliente":"'.$tCliente.'","nombreCliente":"'.$nombreCliente.'","arrAdeudos":['.$arrAdeudos.']}';
		echo "1|".$cadObj;
	}
	
	function obtenerCatalogosTipoConcepto()
	{
		global $con;
		$consulta="SELECT * FROM 557_tiposConcepto"; 
		$resConceptos=$con->obtenerFilas($consulta);
		$arrConceptos=array();
		while($fConcepto=mysql_fetch_row($resConceptos))
		{
			$arrConceptos[$fConcepto[0]]["tabla"]=$fConcepto[1];
			$arrConceptos[$fConcepto[0]]["campoId"]=$fConcepto[2];
			$arrConceptos[$fConcepto[0]]["campoClave"]=$fConcepto[4];
			$arrConceptos[$fConcepto[0]]["campoDescripcion"]=$fConcepto[5];
			
			
		}
		return $arrConceptos;
	}
	
	function obtenerAdeudosCliente()
	{
		global $con;
		$idCliente=$_POST["idCliente"];
		$tipoCliente=$_POST["tipoCliente"];
		$consulta="SELECT * FROM 555_adeudosCliente WHERE idCliente=".$idCliente." and tipoCliente=".$tipoCliente." AND situacion=1";
		$resAdeudos=$con->obtenerFilas($consulta);
		if($con->filasAfectadas==0)
		{
			echo "1|-1";
			return;
		}
		$ct=0;
		$arrAdeudos="";
		$arrConceptos=obtenerCatalogosTipoConcepto();
		$idCliente="";
		$tCliente="";
		$nombreCliente="";
		while($fila=mysql_fetch_row($resAdeudos))
		{
			if($ct==0)
			{
				$consulta="SELECT * FROM 599_tiposPersonasAfectacionContable WHERE idTipoBeneficiario=".$fila[4];
				$fCliente=$con->obtenerPrimeraFila($consulta);
				$consulta="select ".str_replace('"',"",$fCliente[2])." from ".$fCliente[1]." where ".$fCliente[3]."=".$fila[3];
				$fDatosCliente=$con->obtenerPrimeraFila($consulta);
				$idCliente=$fila[3];
				$tCliente=$fila[4];
				$nombreCliente=$fDatosCliente[0];
			}
			$ct++;
			$fCon=$arrConceptos[$fila[2]];
			if($fCon["campoClave"]=="")
				$fCon["campoClave"]="'' as clave";
			$consulta="select ".$fCon["campoClave"].",".$fCon["campoDescripcion"]." from ".$fCon["tabla"]." where ".$fCon["campoId"]."=".$fila[1];
			$fConcepto=$con->obtenerPrimeraFila($consulta);
			$obj="['".$fila[0]."','".$fConcepto[0]."','".$fConcepto[1]."','".$fila[6]."','".$fila[7]."','".$fila[8]."','".$fila[9]."','".$fila[11]."','".$fila[11]."','".$fila[14]."']";
			if($arrAdeudos=="")
				$arrAdeudos=$obj;
			else
				$arrAdeudos.=",".$obj;
		}
		
		$cadObj='{"idCliente":"'.$idCliente.'","tipoCliente":"'.$tCliente.'","nombreCliente":"'.$nombreCliente.'","arrAdeudos":['.$arrAdeudos.']}';
		echo "1|".$cadObj;
	}
	
	function obtenerClientes()
	{	
		global $con;
		$criterio=$_POST["criterio"];
		$tipoCliente=$_POST["tipoCliente"];
		$consulta="SELECT * FROM 599_tiposPersonasAfectacionContable WHERE idTipoBeneficiario=".$tipoCliente;
		$fCliente=$con->obtenerPrimeraFila($consulta);
		$consulta="select * from (select ".$fCliente[3]." as idCliente,".str_replace('"',"",$fCliente[2])." as nombreCliente 
					from ".$fCliente[1].") as tmp where nombreCliente like '".$criterio."%'";
		$arrClientes=$con->obtenerFilasJson($consulta);		
		echo '{"num":"'.$con->filasAfectadas.'","objetos":'.utf8_encode($arrClientes).'}';
	}
	
	function registrarPagoCaja()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->arrCobros as $c)
		{
			$consulta[$x]="INSERT INTO 556_pagosAdeudo(fechaPago,montoPago,idResponsableRegistro,idCaja,idAdeudo,confirmado)
							VALUES('".date("Y-m-d")."',".$c->montoAbono.",".$_SESSION["idUsr"].",".$obj->idCaja.",".$c->idAdeudo.",".$c->confirmado.")";
			$x++;
			if($c->confirmado==1)
			{
				$query="SELECT saldo FROM 555_adeudosCliente WHERE idAdeudo=".$c->idAdeudo;
				$saldo=$con->obtenerValor($query);
				$saldo-=$c->montoAbono;
				$status=1;
				if($saldo==0)
					$status=0;
				$consulta[$x]="UPDATE 555_adeudosCliente SET saldo=".$saldo.",situacion=".$status." WHERE idAdeudo=".$c->idAdeudo;
				$x++;	
			}
		}
		$consulta[$x]="commit";
		$x++;		
		eB($consulta);
	}
	
	function obtenerCuentasBancarias()
	{
		global $con;
		$idBanco=$_POST["idBanco"];
		
		$consulta="SELECT c.idCuenta,noCuenta,descripcionCuenta,clabeInterbancaria,s.nombreSucursal,concat('[',noCuenta,'] - ',descripcionCuenta) FROM 6004_cuentasBancarias c,6001_sucursales s WHERE s.idSucursal=c.idSucursal";
		
		$arrCuentas=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrCuentas;
	}
	
	function obtenerHistorialMovimientosCuenta()
	{
		global $con;
		$idCuenta=$_POST["idCuenta"];
		$consulta="SELECT idMovimientoAfectacionBancaria,fechaMovimiento,descripcion,deposito,retiro,conciliado,noReferencia,'0' AS editable FROM 6010_movimientosCuentasBancarias WHERE 
				idCuentaBancaria=".$idCuenta." ORDER BY fechaMovimiento asc";
		$arrRegistros=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrRegistros;
	}
	
	function buscarCuentaContable()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$ciclo=$_POST["ciclo"];
		$consulta="SELECT * FROM (SELECT codigoCta as codigoCuenta, CONCAT('[',codigoCompletoCta,'] ',tituloCta) AS nombreCuenta 
					FROM 510_cuentas) AS tmp WHERE nombreCuenta LIKE '%".$criterio."%'";
		$arrDatos=utf8_encode($con->obtenerFilasJson($consulta));
		echo '{"num":"'.$con->filasAfectadas.'","objetos":'.$arrDatos.'}';
	}
	
	function obtenerCategoriasConceptoDisponibles()
	{
		global $con;
		$consulta="SELECT idCategoriaConceptosIngreso as idCategoria,nombreCategoria,descripcion FROM 562_categoriasConceptosIngreso WHERE situacion=1";
		$arrDimension=$con->obtenerFilasJSON($consulta);
		$nReg=$con->filasAfectadas;
		echo '{"numReg":"'.$nReg.'","registros":'.utf8_encode($arrDimension).'}';
		
		
	}
	
	function guardarConfiguracionMovimiento()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idFolio==-1)
		{
			$consulta[$x]="INSERT INTO 597_foliosMovimientos(prefijo,separador,longitud,fInicial,incremento,fActual,situacion,idPerfilMovimiento) 
						VALUES('".cv($obj->prefijo)."','".cv($obj->separador)."',".$obj->longitud.",".$obj->fInicial.",".$obj->incremento.",".$obj->fActual.",".$obj->situacion.",".$obj->idPerfilMovimiento.")";
			$x++;
			$consulta[$x]="set @idFolio=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="update 597_foliosMovimientos set prefijo='".cv($obj->prefijo)."',separador='".cv($obj->separador)."',longitud=".$obj->longitud.",fInicial=".
							$obj->fInicial.",incremento=".$obj->incremento.",fActual=".$obj->fActual.",situacion=".$obj->situacion." where idFolio=".$obj->idFolio;
			$x++;
			$consulta[$x]="set @idFolio=".$obj->idFolio;
			$x++;
			
		}
		if($obj->situacion==1)
		{
			$consulta[$x]="update 597_foliosMovimientos set situacion=0 where idFolio<>@idFolio and idPerfilMovimiento=".$obj->idPerfilMovimiento;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function removerConfiguracionFolio()
	{
		global $con;
		$idFolio=$_POST["idFolio"];
		$consulta="DELETE FROM 597_foliosMovimientos WHERE idFolio=".$idFolio;
		eC($consulta);
	}
	
	function actualizarOrigenFolioMovimento()
	{
		global $con;
		$idMovimiento=$_POST["idMovimiento"];
		$origen=$_POST["origen"];
		$consulta="UPDATE 598_perfilesMovimientos SET tipoFolio=".$origen.",idFuncionSistema=NULL WHERE idConcepto=".$idMovimiento;
		eC($consulta);
	}
	
	function actualizarFuncionOrigenFolioMovimento()
	{
		global $con;
		$idMovimiento=$_POST["idMovimiento"];
		$idFuncion=$_POST["idFuncion"];
		$consulta="UPDATE 598_perfilesMovimientos SET idFuncionSistema=".$idFuncion." WHERE idConcepto=".$idMovimiento;
		eC($consulta);
	}
	
	function removerConfiguracionContableMovimiento()
	{
		global $con;
		$idAfectacion=$_POST["idAfectacion"];
		$tAfectacion=$_POST["tAfectacion"];
		if($tAfectacion==2)
			$consulta="DELETE FROM 599_afectacionPresupuestalMovimiento WHERE idAfectacion=".$idAfectacion;		
		else
			$consulta="DELETE FROM 599_afectacionContableMovimiento WHERE idAfectacion=".$idAfectacion;

		eC($consulta);
	}
	
	function guardarConfiguracionAsientoPresupuestoMovimeinto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idAfectacion==-1)
		{
			$consulta="INSERT INTO 599_afectacionPresupuestalMovimiento(idPerfilMovimiento,tiempoPresupuestal,porcentajeAfectacion,tipoAfectacion,idFuncionAplicacion)
						VALUES(".$obj->idPerfilMovimiento.",'".$obj->tiempoAfectacion."',".$obj->porcentaje.",".$obj->tipoAfectacion.",".$obj->idFuncionAplicacion.")";
		}
		else
		{
			$consulta="update 599_afectacionPresupuestalMovimiento set tiempoPresupuestal='".$obj->tiempoAfectacion."',porcentajeAfectacion=".$obj->porcentaje.",tipoAfectacion=".
			$obj->tipoAfectacion.",idFuncionAplicacion=".$obj->idFuncionAplicacion." where idAfectacion=".$obj->idAfectacion;
		}
		eC($consulta);
	}
	
	function guardarConfiguracionAsientoMovimeinto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idAfectacion==-1)
		{
			$consulta="INSERT INTO 599_afectacionContableMovimiento(idPerfilMovimiento,cuentaAfectacion,porcentaje,tipoAfectacion,idFuncionAplicacion)
						VALUES(".$obj->idPerfilMovimiento.",'".$obj->cuentaAfectacion."',".$obj->porcentaje.",".$obj->tipoAfectacion.",".$obj->idFuncionAplicacion.")";
		}
		else
		{
			$consulta="update 599_afectacionContableMovimiento set cuentaAfectacion='".$obj->cuentaAfectacion."',porcentaje=".$obj->porcentaje.",tipoAfectacion=".$obj->tipoAfectacion.",idFuncionAplicacion=".$obj->idFuncionAplicacion." where idAfectacion=".$obj->idAfectacion;
		}
		eC($consulta);
	}
	
	function registrarMovimientoCuentaConciliacionBancaria()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="select count(*) from 6010_movimientosCuentasBancarias where idCuentaBancaria=".$obj->idCuentaBancaria." and noReferencia='".$obj->referencia."'";
		$nRegistros=$con->obtenerValor($consulta);
		if($nRegistros>0)
		{
			echo "<br><br>El n&uacute;mero de referencia ingresado ya ha sido registrado anteriormente";
			return;
		}
		
		$consulta="INSERT INTO 6010_movimientosCuentasBancarias(fechaMovimiento,descripcion,noReferencia,deposito,retiro,conciliado,idResponsableMovimiento,fechaRegistroMovimiento,idCuentaBancaria)
				VALUES('".$obj->fechaMovimiento."','".cv($obj->descripcion)."','".$obj->referencia."',".$obj->deposito.",".$obj->retiro.",1,".$_SESSION["idUsr"].",'".date("Y-m-d H:i:s")."',".$obj->idCuentaBancaria.")";
		if($con->ejecutarConsulta($consulta))
		{
				echo "1|".$con->obtenerUltimoID();
		}
		
	}
?>