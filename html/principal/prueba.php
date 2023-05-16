<?php session_start();
ini_set("memory_limit","3000M");
set_time_limit(999000);
error_reporting(E_ALL);
include_once("conexionBD.php");
include_once("supremaCorte/libreriaFunciones.php");
include_once("SIUGJ/libreriaFuncionesReparto.php");
//enviarCorreoNotificacionV2(665,5706);
generarRepartoProceso(1009,72);

return;
$consulta="SELECT * FROM _000_datosEmpleados WHERE importado=0";
$res=$con->obtenerFilas($consulta);
while($fila=$con->fetchAssoc($res))
{
	$idUsuario=crearBaseUsuario($fila["PATERNO"],$fila["MATERNO"],$fila["NOMBRE"],trim($fila["MAIL"]),$fila["IDADSCRIPCION"],"","-1000,260","","",-1,false);
	$query=array();
	$x=0;
	$query[$x]="begin";
	$x++;
	
	$query[$x]="UPDATE 802_identifica SET Genero=".($fila["IDSEXO"]=="2"?1:0).",tipoIdentificacion=15,noIdentificacion='".$fila["PERNR"].
				"',Prefijo='".$fila["TRATAMIENTO"]."' WHERE idUsuario=".$idUsuario;
	$x++;
	if(trim($fila["CONMUTADOR"])!="")
	{
		$query[$x]="INSERT INTO 804_telefonos(Numero,Tipo,Tipo2,idUsuario,verificado,Extension) VALUES('".cv($fila["CONMUTADOR"])."',0,1,".$idUsuario.",0,'".$fila["EXT1"]."')";
		$x++;
	}
	
	$query[$x]="UPDATE 801_adscripcion SET institucionAbierto='".cv($fila["IDADSCRIPCION"])."',puestoAbierto='".cv($fila["PUESTO"])."' WHERE idUsuario=".$idUsuario;
	$x++;
	
	
	$query[$x]="UPDATE _000_datosEmpleados SET importado=1 WHERE PERNR=".$fila["PERNR"];
	$x++;
	
	$query[$x]="commit";
	$x++;
	
	if($con->ejecutarBloque($query))
	{
		
	}
					
}

return;

$arrDestinatario=array();
$mail[0]="marco.magana@linktic.com";
$mail[1]="marco.magana@linktic.com";
array_push($arrDestinatario,$mail);

$arrArchivos=array();
$oArchivos=array();
$oArchivos[0]="/var/www/html/repositorioDocumentos/documento_7783";
$oArchivos[1]="archivo.pdf";
array_push($arrArchivos,$oArchivos);

sendMensajeEnvioTwilio($arrDestinatario,"prueba","Esta es una prueba","notificaciones_siugj@linktic.com","",$arrArchivos);

return;
$cadParametros='{"idFormulario":"1","idRegistro":"2","idProceso":"3","iFormulario":"1","iRegistro":"2","idActorProceso":"4","campoTablaDestino":"",'.
				'"etapa":"5","idMacroProceso":"6","idRegistroProcesoEtapaMacroProceso":"7","idElementoEvaluacion":"8","tipoElemento":"9",'.
				'"idRegistroElemento":"10","lblEtiquetaElemento":"11","parametro1":"param1"}';
$objParametros=json_decode($cadParametros);
$cacheCalculos=false;
$resultado=resolverExpresionCalculoPHP(480,$objParametros,$cacheCalculos);
echo $resultado;
return;
varDUmp($_SESSION);
registrarDocumentoCarpetaAdministrativa("660013105001-20220000201",7778,696,1970,-1);
$nomPagina=$_SERVER["PHP_SELF"];
$arrPagina=	explode("/",$nomPagina);
$nElementos=sizeof($arrPagina);
$nomPagina=$arrPagina[$nElementos-1];
$rutaNomPagina=$arrPagina[$nElementos-2]."/".$arrPagina[$nElementos-1];
echo $rutaNomPagina;
?>
