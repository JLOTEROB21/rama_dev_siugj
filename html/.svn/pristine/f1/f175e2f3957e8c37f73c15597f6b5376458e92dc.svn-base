<?php 
	
	include("conexionBD.php");
	include_once("nusoap/nusoap.php");
	ini_set('default_socket_timeout', 160000);
	ini_set('post_max_size', '1024M');
	ini_set('upload_max_filesize', '1024M');

	
	function updateRecordsProcess($idProcess,$idForm,$objRegistersConfig)
	{
		return true;
	}
	
	function deteleRecordsProcess($idProcess,$idForm,$objRegistersConfig)
	{
		return true;
	}
	
	function insertRecordsProcess($idProcess,$idForm,$objRegistersConfig)
	{
		global $con;
		
		$cadRegistros=bD($objRegistersConfig);
		$cXML=simplexml_load_string($cadRegistros);
		
		$totalRegistros=0;
		$campos="";
		$valores="";
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$nombreTabla="_".$idForm."_tablaDinamica";
		
		$arrCampos=array();
		$consulta="SELECT * FROM information_schema.COLUMNS WHERE TABLE_NAME='".$nombreTabla."'";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$arrCampos[$fila["COLUMN_NAME"]]=1;
			if($campos=="")
				$campos=$fila["COLUMN_NAME"];
			else
				$campos.=",".$fila["COLUMN_NAME"];
		}
		
		foreach($cXML->recordForm as $registro)
		{	
			$valores="";	
			foreach($arrCampos as $campo=>$resto)
			{
	
				$exp='$valor=(string)$registro->'.$campo.";";
				eval($exp);
				if($valor=="")
					$valor="NULL";
				else
					$valor="'".$valor."'";
					
				if($valores=="")
					$valores=$valor;
				else
					$valores.=",".$valor;
					
			}
			$query[$x]="insert into ".$nombreTabla."(".$campos.") values(".$valores.")";
			$x++;
			$totalRegistros++;	
		}
		
		
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{	
			$consulta="SELECT id__".$idForm."_tablaDinamica FROM _".$idForm."_tablaDinamica WHERE codigo IS NULL ORDER BY id__".$idForm."_tablaDinamica";
			$res=$con->obtenerFilas($consulta);
			while($f=mysql_fetch_row($res))
				asignarFolioRegistro($idForm,$f[0]);
			return '<resultImport><resultado>1</resultado><totalRegistrosImportados>'.$totalRegistros.'</totalRegistrosImportados></resultImport>';
		}
		return '<resultImport><resultado>0</resultado><totalRegistrosImportados>0</totalRegistrosImportados></resultImport>'; 
	}

	
	function findRecordsProcess($idProcess,$idForm,$objRegistersConfig)
	{
		return true;
	}


	$arrParam=array();
	$server = new soap_server;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('updateRecordsProcess',array('idProcess'=>'xsd:string','idForm'=>'xsd:string','objRegistersConfig'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('deteleRecordsProcess',array('idProcess'=>'xsd:string','idForm'=>'xsd:string','objRegistersConfig'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('insertRecordsProcess',array('idProcess'=>'xsd:string','idForm'=>'xsd:string','objRegistersConfig'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	$server->register('findRecordsProcess',array('idProcess'=>'xsd:string','idForm'=>'xsd:string','objRegistersConfig'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','');
	
	
	if (isset($HTTP_RAW_POST_DATA)) 
	{
		$input = $HTTP_RAW_POST_DATA;
	}
	else 
	{
		$input = implode("rn", file('php://input'));
	}
	
	
	$server->service($input);
?>