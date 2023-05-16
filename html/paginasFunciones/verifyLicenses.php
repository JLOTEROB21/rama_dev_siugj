<?php	
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	
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
		case 1: //Autentificar Usuario
			verificarLicencia();
		break;
		case 2: //Autentificar Usuario
			registrarLicencia();
		break;
	}
	
	
	function verificarLicencia()
	{
		$clave=$_POST["clave"];
		$client = new nusoap_client("https://grupolatis.net/webServices/wsLicencias.php?wsdl","wsdl");


		$parametros=array();
		$parametros["claveLicencia"]=$clave;
		$response = $client->call("verificaLicenciaLatis", $parametros);
		echo "1|".$response;
		
	}
	
	function registrarLicencia()
	{
		global $con;
		$clave=$_POST["clave"];
		$idRegistro=$_POST["idRegistro"];
		$client = new nusoap_client("https://grupolatis.net/webServices/wsLicencias.php?wsdl","wsdl");


		$parametros=array();
		$parametros["claveLicencia"]=str_replace("-","",$clave);
		$parametros["macAddress"]="AC:1F:6B:21:C0:E2";
		$response = $client->call("registrarLicenciaLatis", $parametros);

		$oResp=json_decode(utf8_encode($response));

		if($idRegistro=='-1')
		{
			$descripcionProducto=$oResp->descripcionProducto;
			$tipoLicencia=$oResp->tipoLicencia;
			$consulta="INSERT INTO 000_registroLicencias(claveLicencia,fechaRegistro,idResponsableRegistro,situacionActual,descripcionProducto,tipoLicencia) VALUES('".
					cv($clave)."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,'".cv($descripcionProducto)."',".$tipoLicencia.")";
			$con->ejecutarConsulta($consulta);
			
		}
		else
		{
			$descripcionProducto=$oResp->descripcionProducto;
			$tipoLicencia=$oResp->tipoLicencia;
			$consulta="update 000_registroLicencias set claveLicencia='".cv($clave)."',fechaRegistro='".date("Y-m-d H:i:s")."',idResponsableRegistro=".$_SESSION["idUsr"].
					",situacionActual=1,descripcionProducto='".cv($descripcionProducto)."',tipoLicencia=".$tipoLicencia." where idRegistro=".$idRegistro;
			$con->ejecutarConsulta($consulta);
		}
		
		echo "1|".$response;
		
	}
?>	