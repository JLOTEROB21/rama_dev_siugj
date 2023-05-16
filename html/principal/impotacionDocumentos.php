<?php 

include("conexionBD.php");
include_once("nusoap/nusoap.php");


$client = new nusoap_client("http://10.10.21.39:8085/ws/wsSharedPoint.asmx?wsdl","wsdl");

$destino=$baseDir."/archivosTemporales/".generarNombreArchivoTemporal();
$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
		WHERE fechaCreacion<='2016-12-31' AND tipoCarpetaAdministrativa=1 and sincronizado=0 
		
		ORDER BY carpetaAdministrativa limit 0,1";

$res=$con->obtenerFilas($consulta);
while($f=mysql_fetch_row($res))
{
	$query=array();
	$x=0;
	$query[$x]="begin";
	$x++;
	$carpeta=$f[0];
	echo $carpeta."<br>";
	$parametros=array();
	$parametros["carpeta"]=str_replace("/","-",$carpeta);

	$response = $client->call("obtenerDocumentosCarpetaJudicial", $parametros);

	if(strpos($response["obtenerDocumentosCarpetaJudicialResult"],'"documentos"')!==false)
	{
		$oDocumento=json_decode($response["obtenerDocumentosCarpetaJudicialResult"]);
		foreach($oDocumento->documentos as $d)
		{
			$nArchivo=bD($d->nombreDocumento);
			if(strpos($nArchivo,".url")!==false)
				continue;
				

			$consulta="select count(*) from 908_archivos where fechaCreacion='".$d->fechaCeacion."' and nomArchivoOriginal='".cv(bD($d->nombreDocumento))."'";
			$nReg=$con->obtenerValor($consulta);
			
			if($nReg==0)
			{
				$parametrosContenido=array();
				$parametrosContenido["rutaDocumento"]=bD($d->rutaDocumento);
				echo $parametrosContenido["rutaDocumento"]."<br>";
				$response=$client->call("obtenerContenidoDocumentoCarpetaJudicial", $parametrosContenido);
				$objContenido=json_decode($response["obtenerContenidoDocumentoCarpetaJudicialResult"]);
				
				escribirContenidoArchivo($destino,bD($objContenido->contenido));
				$tamano=filesize ($destino);
				
				$consulta="INSERT INTO 908_archivos(fechaCreacion,responsable,nomArchivoOriginal,tipoArchivo,tamano,enBD,tipoDocumento,categoriaDocumentos)
							VALUES('".$d->fechaCeacion."',1,'".cv($nArchivo)."','application/octet-stream',".$tamano.",0,2,17)";
				
				if(!$con->ejecutarConsulta($consulta))
					return;
				$idDocumento=$con->obtenerUltimoID();
				
				if(!copy($destino,$baseDir."/repositorioDocumentos/documento_".$idDocumento))
				{
					return;
				}
				$query[$x]="INSERT INTO 7007_contenidosCarpetaAdministrativa(carpetaAdministrativa,fechaRegistro,responsableRegistro,tipoContenido,idFormulario,
							idRegistro,idRegistroContenidoReferencia,etapaProcesal)
							values('".$carpeta."','".$d->fechaCeacion."',1,1,-1,-1,".$idDocumento.",1)";
				$x++;
				unlink($destino);
			}
			
			
		}
		$query[$x]="UPDATE 7006_carpetasAdministrativas SET sincronizado=1 WHERE carpetaAdministrativa='".$carpeta."'";
		$x++;
		
		unset($oDocumento);
	}
	else
	{
		
		$query[$x]="UPDATE 7006_carpetasAdministrativas SET sincronizado=2 WHERE carpetaAdministrativa='".$carpeta."'";
		$x++;
	}
	
	$query[$x]="commit";
	$x++;
	
	$con->ejecutarBloque($query);
																  
	echo $f[0]."<br>";
}
?>