<?php
include_once("conexionBD.php");
include("numeroToLetra.php");


	$fechaReporte=date("d-m-Y");
	global $con;
	$tipoReporte='1';
	$idNomina='-1';
	if(isset($_POST["idNomina"]))
		$idNomina=$_POST["idNomina"];
	$codigoUnidad='-1';		
	
	if(isset($_POST["codigoUnidad"]))
		$codigoUnidad=$_POST["codigoUnidad"];
	$cadFinLinea="\r\n";
	$consultaSede="SELECT unidad,descripcion,claveDepartamental,cveClienteBancario FROM 817_organigrama WHERE codigoUnidad='".$codigoUnidad."'";
	$Plantel=$con->obtenerPrimeraFila($consultaSede);
	$consulta="SELECT fechaEstimadaPago,fechaFinIncidencias,montoTotalSueldoNeto FROM 672_nominasEjecutadas WHERE idNomina=".$idNomina;
	$fNomina=$con->obtenerPrimeraFila($consulta);
	$fechaPago=date("ymd",strtotime($fNomina[0]));
	
	$consulta="SELECT noSecuencia FROM 673_noSecuenciaTransferenciaNomina WHERE cuenta='".$Plantel[2]."' AND idNomina='".$idNomina."' AND plantel='".$codigoUnidad."'";
	$nSecuencia=$con->obtenerValor($consulta);
	if($nSecuencia=="")
	{
		$consulta="SELECT MAX(noSecuencia) FROM 673_noSecuenciaTransferenciaNomina WHERE fechaAplicacion='".$fNomina[0]."' AND cuenta='".$Plantel[2]."'";
		$nSecuencia=$con->obtenerValor($consulta);
		if($nSecuencia=="")
			$nSecuencia=0;
		$nSecuencia++;
		
		$query="insert into 673_noSecuenciaTransferenciaNomina(cuenta,fechaAplicacion,plantel,noSecuencia,idNomina) VALUES('".$Plantel[2]."','".$fNomina[0]."','".$codigoUnidad."',".$nSecuencia.",".$idNomina.")";
		$con->ejecutarConsulta($query);
		
	}
	
	
	$nSecuencia=str_pad($nSecuencia,4,"0",STR_PAD_LEFT);
	
	$razonSocial=str_pad("UGMSUR",36," ",STR_PAD_RIGHT);
	$claveCliente=str_pad($Plantel[3],12,"0",STR_PAD_LEFT);
	$cad="1";	
	$finalControl="15D01";
	$fPago=strtotime($fNomina[1]);
	$descripcion=$Plantel[1]." ".date("d",$fPago)." ".strtoupper($arrMesLetra[((date("m",$fPago)*1)-1)]);
	$descripcion=str_pad(substr($descripcion,0,20),20," ",STR_PAD_RIGHT);
	$cadInicial=$cad.$claveCliente.$fechaPago.$nSecuencia.$razonSocial.$descripcion.$finalControl;
	$consulta="SELECT objDetalle,sueldoNeto,idUsuario FROM 671_asientosCalculosNomina WHERE idNomina='".$idNomina."' and codDepartamento='".$codigoUnidad."' AND sueldoNeto>0";
	$res=$con->obtenerFilas($consulta);
	$noTotalAbono=str_pad($con->filasAfectadas,6,"0",STR_PAD_LEFT);
	$importeCargo=0;
	$tRegistro=3;
	$tOperacion=0;
	$mPago="001";
	$tPago="01";
	$cveMoneda="001";
	$cadDetalle="";
	$tCuentaAbono="03";
	$nTransferencia=1;
	
	
	$datosOpcionales=str_pad("",140," ",STR_PAD_LEFT);
	$datosFinales="000000";
	while($fila=mysql_fetch_row($res))
	{
		$importe=number_format($fila[1],2);
		$importe=str_replace(",","",$importe);
		$importeCargo+=$importe;
		$importe=str_replace(".","",$importe);
		$importe=str_pad($importe,18,"0",STR_PAD_LEFT);
		$consulta="SELECT txtCuentaBancaria FROM _497_tablaDinamica WHERE cmbDocente=".$fila[2];
		$nCuenta=$con->obtenerValor($consulta);
		$nCuenta=str_pad($nCuenta,20,"0",STR_PAD_LEFT);
		$concepto="TRANSFER".$nTransferencia;
		$concepto=str_pad($concepto,16," ",STR_PAD_RIGHT);
		$beneficiario="";
		$consulta="select upper(Paterno),upper(Materno),upper(Nom) from 802_identifica i where idUsuario=".$fila[2];
		$fNom=$con->obtenerPrimeraFila($consulta);
		$beneficiario=$fNom[2].",".$fNom[0]."/".$fNom[1];
		$beneficiario=str_pad($beneficiario,55," ",STR_PAD_RIGHT);
		$obj=$tRegistro.$tOperacion.$mPago.$tPago.$cveMoneda.$importe.$tCuentaAbono.$nCuenta.$concepto.$beneficiario.$datosOpcionales.$datosFinales;
		$cadDetalle.=$obj.$cadFinLinea;	
		$nTransferencia++;
	}
	
	$tRegistro="2";
	$tOperacion=1;
	$importeCargo=number_format($importeCargo,2);
	$importeCargo=str_replace(",","",$importeCargo);
	$importeCargo=str_replace(".","",$importeCargo);
	$importeCargo=str_pad($importeCargo,18,"0",STR_PAD_LEFT);
	$tipoCuenta="01";
	$numCuenta=str_pad($Plantel[2],20,"0",STR_PAD_LEFT);
	
	
	$cadGlobal=$tRegistro.$tOperacion.$cveMoneda.$importeCargo.$tipoCuenta.$numCuenta.$noTotalAbono;
	
	$tRegistro="4";
	$nAbono="000001";
	
	$cadControl=$tRegistro.$cveMoneda.$noTotalAbono.$importeCargo.$nAbono.$importeCargo;
	header("Content-Disposition: attachment; filename=archivoTransFerencia.txt"); 
	echo $cadInicial.$cadFinLinea;
	echo $cadGlobal.$cadFinLinea;
	echo $cadDetalle;
	echo $cadControl.$cadFinLinea;
?>
