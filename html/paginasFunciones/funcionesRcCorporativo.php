<?php
	session_start();
	;
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
				guardarDatosCuenta();
			break;
			case 2:
				guardarDatosCuentaDeposito();
			break;
			case 3:
				guardarClienteCredito();
			break;
			case 4:
				obtenerDatosRep();
			break;
			case 5:
				actualizarCampoCredito();
			break;
			case 6:
				removerAval();
			break;
			case 7:
				agregarBien();
			break;
			case 8:
				removerBien();
			break;
			case 9:
				obtenerDatosEmpresa();
			break;
			case 10:
				generarNuevoCredito();
			break;
			case 11:
				obtenerCreditosCliente();
			break;
			case 12:
				removerDocumentoAnexo();
			break;
			case 13:
				vincularClienteCreditoNuevo();
			break;
			case 14:
				removerClientePrincipal();
			break;
			case 15:
				cambiarEtapaCredito();
			break;
			case 16:
				obtenerDatosRegistro();
			break;
			case 17:
				validarExistenciaPersonaFisica();
			break;
			case 18:
				validarExistenciaPersonaMoral();
			break;
			case 19:
				cambiarFechaCredito();
			break;
			case 20:
				obtenerNombreTitular();
			break;
			case 21:
				eliminarCliente();
			break;
			case 22:
				eliminarCredito();
			break;
			case 23:
				buscarEmpresa();
			break;
			case 24:
				obtenerSeccionesReporte();
			break;
			case 25:
				guardarReporte();
			break;
			case 26:
				obtenerReportesDisponibles();
			break;
		}
		
	}
	
	function guardarDatosCuenta()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$x=0;
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			if($obj->idCuenta=="-1")
			{
				$query="insert into 713_saldosCuentasBanco(idCredito,cuenta,idBanco,idTitular,tipoTitular,saldoM6,saldoM5,saldoM4,saldoM3,saldoM2,
								saldoM1,antiguedad,idUsrRegistro,fechaRegistro) values (".$obj->idCredito.",'".$obj->cuenta."',".$obj->idBanco.",
								".$obj->idTitular.",".$obj->tipoTitular.",".$obj->M6.",".$obj->M5.",".$obj->M4.",".$obj->M3.",".$obj->M2.",".$obj->M1.",
								'".cv($obj->antiguedad)."',".$_SESSION["idUsr"].",'".date('Y-m-d')."')";
				if(!$con->ejecutarConsulta($query))
				{
					echo "|";
					return;
				}
				$idCuenta=$con->obtenerUltimoID();
				$query="insert into 714_depositosCuentasBanco(idCredito,cuenta,idBanco,idTitular,tipoTitular,antiguedad,idUsrRegistro,fechaRegistro,idCuentaRef) 
								values (".$obj->idCredito.",'".$obj->cuenta."',".$obj->idBanco.",".$obj->idTitular.",".$obj->tipoTitular.",'".cv($obj->antiguedad).
								"',".$_SESSION["idUsr"].",'".date('Y-m-d')."',".$idCuenta.")";
				if(!$con->ejecutarConsulta($query))
				{
					echo "|";
					return;
				}
				$idCuentaDeposito=$con->obtenerUltimoID();

			}
			else
			{
				$consulta[$x]="update 713_saldosCuentasBanco set cuenta='".$obj->cuenta."',idBanco=".$obj->idBanco.",idTitular=".$obj->idTitular.",
							tipoTitular=".$obj->tipoTitular.",saldoM6=".$obj->M6.",saldoM5=".$obj->M5.",saldoM4=".$obj->M4.",saldoM3=".$obj->M3.",
							saldoM2=".$obj->M2.",saldoM1=".$obj->M1.",antiguedad='".cv($obj->antiguedad)."',
							idUsrModif=".$_SESSION["idUsr"].",fechaModif='".date('Y-m-d')."' where id_713_saldoCuentasBanco=".$obj->idCuenta;
				$x++;
				$idCuenta=$obj->idCuenta;
				$query="select id_714_depositoCuentasBanco from 714_depositosCuentasBanco where idCuentaRef=".$idCuenta;
				$idCuentaDeposito=$con->obtenerValor($query);
				$consulta[$x]="update 714_depositosCuentasBanco set cuenta='".$obj->cuenta."',idBanco=".$obj->idBanco.",idTitular=".$obj->idTitular.",
								tipoTitular=".$obj->tipoTitular.",antiguedad='".cv($obj->antiguedad)."',idUsrModif=".$_SESSION["idUsr"].",
								fechaModif= '".date('Y-m-d')."' where id_714_depositoCuentasBanco=".$idCuentaDeposito;
				$x++;
			}
			
			$consulta[$x]="commit";
			$x++;
			if($con->ejecutarBloque($consulta))
				echo "1|".$idCuenta."|".$idCuentaDeposito;
			else
				echo "|";
			
		}
		else
			echo "|";
	}
	
	function guardarDatosCuentaDeposito()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$consulta="update 714_depositosCuentasBanco set depositoM6=".$obj->D6.",depositoM5=".$obj->D5.",depositoM4=".$obj->D4.",
					depositoM3=".$obj->D3.",depositoM2=".$obj->D2.",depositoM1=".$obj->D1.",idUsrModif=".$_SESSION["idUsr"].",fechaModif='".date('Y-m-d')."' 
					where id_714_depositoCuentasBanco=".$obj->idCuenta;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function guardarClienteCredito()
	{
		global $con;
		$idCliente=$_POST["idCliente"];
		$tipoCliente=$_POST["tipoCliente"];
		$idCredito=$_POST["idCredito"];
		if($idCredito=="-1")
		{
			$consulta="insert into 750_creditos(idCliente,tipoCliente,fechaReg,respReg) values(".$idCliente.",".$tipoCliente.",'".date('Y-m-d')."',".$_SESSION["idUsr"].")";
		}
		else
		{
			$consulta="update 750_creditos set idCliente=".$idCliente.",tipoCliente=".$tipoCliente.",fechaModif='".date('Y-m-d')."',respModif=".$_SESSION["idUsr"]." where idCredito=".$idCredito;
		}
		if($con->ejecutarConsulta($consulta))
		{
			if($idCredito=="-1")
				$idCredito=$con->obtenerUltimoID();
			echo "1|".$idCredito;
		}
	}
	
	function obtenerDatosRep()
	{
		global $con;
		$idRep=$_POST["idRep"];
		if((!isset($_POST["tCliente"]))||($_POST["tCliente"]==1))
			$consulta="select concat(nombres,' ',paterno,' ',materno) as nombre,email,telefonos from 703_clientes where idCliente=".$idRep;
		else
			$consulta="select empresa,email,telefonos from 700_empresas where idEmpresa=".$idRep;
		$fila=$con->obtenerPrimeraFila($consulta);
		echo "1|".uEJ($fila[0])."|".uEJ($fila[1])."|".uEJ($fila[2]);
	}
	
	function actualizarCampoCredito()
	{
		global $con;
		$complementario="";
		$campo=$_POST["campo"];
		$valor=$_POST["valor"];
		$idCredito=$_POST["idCredito"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		switch($campo)
		{
			case 1:
				$campoM="mesesMayoresVentasAnio";
			break;
			case 2:
				if($valor=="")
					$valor=0;
				$valor=normalizarNumero($valor);
				$campoM="ventasAcumAnioAnt";
			break;
			case 3:
				if($valor=="")
					$valor=0;
				$valor=normalizarNumero($valor);
				$campoM="ventasAcumAnioAct";
			break;
			case 4:
				if($valor=="")
					$valor=0;
				$valor=normalizarNumero($valor);
				$campoM="montoSolicitado";
			break;
			case 5:
				if($valor=="")
					$valor=0;
				$valor=normalizarNumero($valor);
				$campoM="montoAutorizado";
			break;
			case 6:
				$campoM="destinoCredito";
			break;
			case 7:
				$campoM="captacionVia";
				if($valor!=12)
				{
					$complementario=", nomExpo=''";
				}
			break;
			case 8:
				$campoM="condicionado";
			break;
			case 9:
				$campoM="acuerdoComite";
			break;
			case 10:
				$campoM="montoAutorizado";
				if($valor=="")
					$valor=0;
				$valor=normalizarNumero($valor);
			break;
			case 11:
				$campoM="tasaInteres";
			break;
			case 12:
				$campoM="comision";
			break;
			case 13:
				$campoM="conferenciaCapitalHum";
			break;
			case 14:
				$campoM="fechaRenovacionLinea";
			break;
			case 15:
				$campoM="fechaComite";
			break;
			case 16:
				$campoM="fechaFondeo";
			break;
			case 17:
				$campoM="fechaEntrada";
			break;
			case 18:
				$campoM="cerradorRC";
			break;
			case 19:
				$campoM="cerradorFondo";
			break;
			case 20:
				$campoM="nomExpo";
			break;
		}
		$consulta[$x]="update 750_creditos set ".$campoM."='".$valor."' ".$complementario." where idCredito=".$idCredito;
		$x++;
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerAval()
	{
		global $con;
		$idAval=$_POST["idAval"];
		$consulta="delete from 709_aval where idAval=".$idAval;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "-1|";
	}
	
	function agregarBien()
	{
		global $con;
		$idCredito=$_POST["idCredito"];
		$bien=$_POST["bien"];
		$idBien=$_POST["idBien"];
		if($idBien=="-1")
			$consulta="insert into 714_bienesCredito(bien,idCredito,fechaRegistro,idResponsable) values('".cv($bien)."',".$idCredito.",'".date('Y-m-d')."',".$_SESSION["idUsr"].")";
		else
			$consulta="update 714_bienesCredito set bien='".cv($bien)."' where idBienesCredito=".$idBien;
		if($con->ejecutarConsulta($consulta))
		{
			if($idBien=="-1")
				$idBien=$con->obtenerUltimoID();
			echo "1|".$idBien;
		}
	}
	
	function removerBien()
	{
		global $con;
		$cadBien=$_POST["cadBien"];
		$consulta="delete from 714_bienesCredito where idBienesCredito in (".$cadBien.")";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerDatosEmpresa()
	{
		global $con;
		$idEmp=$_POST["idEmp"];
		$consulta="select empresa from 700_empresas where idEmpresa=".$idEmp;
		$fila=$con->obtenerPrimeraFila($consulta);
		echo "1|".uEJ($fila[0]);
	}
	
	function generarNuevoCredito()
	{
		global $con;
		$idCliente=base64_decode($_POST["idCliente"]);
		$tCliente=base64_decode($_POST["tCliente"]);
		if($tCliente==2)
			$consulta="select idResponsable from 700_empresas where idEmpresa=".$idCliente;
		else
			$consulta="select idResponsable from 703_clientes where idCliente=".$idCliente;
		$idPromotor=$con->obtenerValor($consulta);
		
		
		$consulta="insert into 750_creditos(idCliente,tipoCliente,fechaEntrada,idPromotor) values(".$idCliente.",".$tCliente.",'".date('Y-m-d')."',".$idPromotor.")";
		if($con->ejecutarConsulta($consulta))
		{
			$idCredito=$con->obtenerUltimoID();
			$folio=str_pad($idCredito,7,"0",STR_PAD_LEFT);
			$consulta="update 750_creditos set folio='".$folio."' where idCredito=".$idCredito;
			if($con->ejecutarConsulta($consulta))
				echo "1|".$idCredito;
			else
				echo "|";
		}
	}
	
	function obtenerCreditosCliente()
	{
		global $con;
		$iC=$_POST["iC"];
		$tC=$_POST["tC"];
		
		$consulta="select idCredito,folio,date_format(fechaEntrada,'%d/%m/%Y') as fecha,(select nombre from 800_usuarios where idUsuario=c.idPromotor) as nombreUsuario,s.estadoCredito from 750_creditos c,752_estadosCredito s where s.numEstado=c.status and idCliente=".$iC." and tipoCliente=".$tC;
		$datosCliente=$con->obtenerFilasArreglo($consulta);
		echo "1|".uEJ($datosCliente);
	}
	
	function removerDocumentoAnexo()
	{
		global $con;
		$iA=base64_decode($_POST["iA"]);
		$consulta="delete from 751_documentosAnexos where idAnexo=".$iA;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function vincularClienteCreditoNuevo()
	{
		global $con;
		$idCredito=$_POST["idCredito"];
		$idCliente=$_POST["idCliente"];
		$consulta="insert into 715_principalesClientes(idClientePrincipal,tipoCliente,idCredito,fechaRegistro,idResponsable) 
					values(".$idCliente.",2,".$idCredito.",'".date('Y-m-d')."',".$_SESSION["idUsr"].")";
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function removerClientePrincipal()
	{
		global $con;
		$idClienteP=base64_decode($_POST["iC"]);
		$consulta="delete from 715_principalesClientes where idPrincipalesClientes=".$idClienteP;
		if($con->ejecutarConsulta($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function cambiarEtapaCredito()
	{
		global $con;
		$idEtapa=bD($_POST["et"]);
		$idCredito=$_POST["idCredito"];
		$consulta="select status from 750_creditos where idCredito=".$idCredito;
		$estadoAnt=$con->obtenerValor($consulta);
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="update 750_creditos set status=".$idEtapa." where idCredito=".$idCredito;
		$x++;
		$query[$x]="insert into 754_bitacoraCredito(idEstadoAnterior,idEstadoActual,fechaCambio,idUsuarioResp,idCredito) 
					values(".$estadoAnt.",".$idEtapa.",'".date("Y-m-d")."',".$_SESSION["idUsr"].",".$idCredito.")";
		$x++;
		switch($idEtapa)
		{
			case 6:
				$query[$x]="update 750_creditos set status=".$idEtapa.",cerradorFondo=".$_SESSION["idUsr"]." where idCredito=".$idCredito;
				$x++;
			break;
			case 5:
			case 7:
			case 8:
				$query[$x]="update 750_creditos set status=".$idEtapa.",cerradorRC=".$_SESSION["idUsr"]." where idCredito=".$idCredito;
				$x++;
			break;
			default:
				$query[$x]="update 750_creditos set status=".$idEtapa." where idCredito=".$idCredito;
				$x++;
			break;
		}
		
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
			echo "1|";
		else
			echo "|";
	}
	
	function obtenerDatosRegistro()
	{
		global $con;
		$tRegistro=$_POST["tRegistro"];
		$idGrupo="";
		if($tRegistro==1)
		{
			$idGrupo=bD($_POST["idGrupo"]);
			$listUsr="-1";
			$consulta="select idUsuario from 807_usuariosVSRoles where codigoRol='38_".$idGrupo."'";
			$listUsr=$con->obtenerListaValores($consulta);
			$consulta="select idUsuario,Nombre from 800_usuarios where idUsuario in (".$listUsr.")";
		}
		else
			$consulta="select idUnidadesRoles,unidadRol from 4084_unidadesRoles where idCategoria=7 order by unidadRol";
		$arr=uEJ($con->obtenerFilasArreglo($consulta));
		echo "1|".$arr;
	}
	
	function validarExistenciaPersonaFisica()
	{
		global $con;
		$idCliente=$_POST["idCliente"];
		$rfc1=$_POST["rfc1"];
		$rfc2=$_POST["rfc2"];
		$rfc3=$_POST["rfc3"];
		$paterno=$_POST["paterno"];
		$materno=$_POST["materno"];
		$nombre=$_POST["nombre"];
		if(($rfc1!="")&&($rfc2!="")&&($rfc3!=""))
		{
			$consulta="Select paterno,materno,nombres from 703_clientes where rfc='".cv($rfc1)."' and RFC2='".cv($rfc2)."' and RFC3='".cv($rfc3)."' and idCliente<>".$idCliente;
			$filaCli=$con->obtenerPrimeraFila($consulta);
			
			if($filaCli)
			{
				echo "2|".uEJ($filaCli[0]." ".$filaCli[1]." ".$filaCli[2]);
				return;
			}
		}
		$consulta="Select idCliente from 703_clientes where paterno='".cv($paterno)."' and materno='".cv($materno)."' and nombres='".cv($nombre)."' and idCliente<>".$idCliente;
		
		$idCli=$con->obtenerValor($consulta);
		if($idCli!='')
		{
			echo "3|";
			return;
		}
		echo "1|";
	}
	
	function validarExistenciaPersonaMoral()
	{
		global $con;
		$idEmpresa=$_POST["idEmpresa"];
		$rfc1=$_POST["rfc1"];
		$rfc2=$_POST["rfc2"];
		$rfc3=$_POST["rfc3"];
		$empresa=$_POST["empresa"];
		
		
		$consulta="Select empresa from 700_empresas where rfc='".cv($rfc1)."' and RFC2='".cv($rfc2)."' and RFC3='".cv($rfc3)."' and idEmpresa<>".$idEmpresa;
		
		$idCli=$con->obtenerValor($consulta);
		if($idCli!='')
		{
			echo "2|".uEJ($idCli);
			return;
		}
		$consulta="Select idEmpresa from 700_empresas where empresa='".cv($empresa)."' and idEmpresa<>".$idEmpresa;
		
		$idCli=$con->obtenerValor($consulta);
		if($idCli!='')
		{
			echo "3|";
			return;
		}
		echo "1|";
	}
	
	function cambiarFechaCredito()
	{
		global $con;
		$idCredito=$_POST["idCredito"];	
		$fecha=$_POST["fechaRegistro"];
		$consulta="update 750_creditos set fechaEntrada='".$fecha."' where idCredito=".$idCredito;
		eC($consulta);
	}
	
	function obtenerNombreTitular()
	{
		global $con;
		$tipoTitular=$_POST["tipoTitular"];
		$idTitular=$_POST["idTitular"];
		if($tipoTitular==1)
			$consulta="SELECT CONCAT(nombres,' ',paterno,' ',materno) AS nombre FROM 703_clientes WHERE  idCliente=".$idTitular;
		else
			$consulta="SELECT empresa FROM 700_empresas WHERE idEmpresa=".$idTitular;
		$nTitular=$con->obtenerValor($consulta);
		echo "1|".uEJ($nTitular);
	}
	
	function eliminarCliente()
	{
		global $con;
		$idCliente=$_POST["idCliente"];
		$idTipoCliente=$_POST["idTipoCliente"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($idTipoCliente==1)
			$consulta[$x]="DELETE FROM 703_clientes WHERE idCliente=".$idCliente;
		else
			$consulta[$x]="delete  FROM 700_empresas WHERE idEmpresa=".$idCliente;
		$x++;
		$consulta[$x]="DELETE FROM 750_creditos WHERE idCliente=".$idCliente." AND tipoCliente=".$idTipoCliente;
		$x++;
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
	}
	
	function eliminarCredito()
	{
		global $con;
		$idCredito=$_POST["idCredito"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 750_creditos where idCredito=".$idCredito;
		$x++;
		$consulta[$x]="delete from 751_documentosAnexos where idCredito=".$idCredito;
		$x++;
		$consulta[$x]="delete from 709_aval where idCredito=".$idCredito;
		$x++;
		$consulta[$x]="delete from 713_saldosCuentasBanco where idCredito=".$idCredito;
		$x++;
		$consulta[$x]="delete from 714_bienesCredito where idCredito=".$idCredito;
		$x++;
		$consulta[$x]="delete from 714_depositosCuentasBanco where idCredito=".$idCredito;
		$x++;
		$consulta[$x]="delete from 715_principalesClientes where idCredito=".$idCredito;
		$x++;
		$consulta[$x]="delete from 754_bitacoraCredito where idCredito=".$idCredito;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function buscarEmpresa()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$consulta="SELECT cveEmpresa as idEmpresa,empresa FROM 700_vistaNombreClientesTotal WHERE empresa LIKE '%".$criterio."%'";
		$arrEmpresas=$con->obtenerFilasJSON($consulta);
		echo '{"num":"'.$con->filasAfectadas.'","empresas":'.utf8_encode($arrEmpresas).'}';
	}
	
	
	function obtenerSeccionesReporte()
	{
		global $con;
		$idReporte=$_POST["idReporte"];
		$arrSecciones=array();
		if($idReporte!=-1)
		{
			$consulta="select seccionesConf from 700_reportesConfiguracion where idReporte=".$idReporte;
			$secciones=$con->obtenerValor($consulta);
			if($secciones!="")
			{
				$arrAux=explode(",",$secciones);
				
				foreach($arrAux as $accion)
				{
					$datosExplode=explode("_",$accion);
					array_push($arrSecciones,$datosExplode[0]."_".$datosExplode[1]);
				}
			}
		}
		
		$arrObj="";
		$consulta="SELECT idSeccionReporte,seccionReporte,tipoSeccion FROM 700_seccionesReporte  ORDER BY orden";
		$resSec=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resSec))
		{
			$comp='';
			if($fila[2]==0)
				$comp='"leaf":true';
			else
			{
				$cadHijos="";
				$consulta="select idElementoReporte,elemento FROM 700_elementosSeccion WHERE idSeccion=".$fila[0]." order by elemento";
				$resElem=$con->obtenerFilas($consulta);
				while($fElem=mysql_fetch_row($resElem))
				{
					$cheked="false";
					if(existeValor($arrSecciones,'e_'.$fElem[0]))
						$cheked='true';
					$obj='{
								  
								  "tipo":"",
								  "draggable":false,
								  "text":"'.$fElem[1].'",
								  "id":"e_'.$fElem[0].'",
								  "icon":"../images/s.gif",
								  "allowDrop":false,
								  "checked":'.$cheked.',"leaf":true
								  
							}';
					if($cadHijos=="")
						$cadHijos=$obj;
					else
						$cadHijos.=",".$obj;
													
				}
				if($cadHijos=="")
					$comp='"leaf":true';
				else
				{
					$comp='"leaf":false,children:['.$cadHijos.']';
				}
					
			}
			$cheked="false";
			if(existeValor($arrSecciones,'s_'.$fila[0]))
				$cheked='true';
			$obj='{
								  
								  "tipo":"'.$fila[2].'",
								  "draggable":false,
								  "text":"<b>'.$fila[1].'</b>",
								  "nCampo":"",
								  "id":"s_'.$fila[0].'",
								  "allowDrop":false,
								  "icon":"../images/s.gif",
								  "checked":'.$cheked.','.$comp.'
								  
							}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;							
		}
		
		echo "[".$arrObj."]";
			
	}
	
	function guardarReporte()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idReporte=="-1")
		{
			$consulta="INSERT INTO 700_reportesConfiguracion (nombreReporte,descripcion,queryConf,seccionesConf,fechaCreacion,responsableCreacion) 
						VALUES('".cv($obj->nombreReporte)."','".cv($obj->descripcion)."','".cv(bD($obj->condicionesFiltrado))."','".cv($obj->camposIncluir)."','".date("Y-m-d")."',".$_SESSION["idUsr"].")";
						
		}
		else
		{
			$consulta="update 700_reportesConfiguracion set queryConf='".cv(bD($obj->condicionesFiltrado))."',seccionesConf='".cv($obj->camposIncluir)."' where idReporte=".$obj->idReporte;

		}
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idReporte=="-1")
				$obj->idReporte=$con->obtenerUltimoID();
			echo "1|".$obj->idReporte;
		}
	}
	
	function obtenerReportesDisponibles()
	{
		global $con;
		$consulta="select idReporte,nombreReporte,descripcion,queryConf,date_format(fechaCreacion,'%d/%m/%Y') as fechaCreacion FROM 700_reportesConfiguracion";
		$resReportes=$con->obtenerFilas($consulta);
		$arrReportes="";
		while($fila=mysql_fetch_row($resReportes))
		{
			$obj="['".$fila[0]."','".cv($fila[1])."','".cv($fila[2])."','".bE($fila[3])."','".$fila[4]."']";
			if($arrReportes=="")
				$arrReportes=$obj;
			else
				$arrReportes.=",".$obj;
		}
		echo "1|[".$arrReportes."]";
	}
?>