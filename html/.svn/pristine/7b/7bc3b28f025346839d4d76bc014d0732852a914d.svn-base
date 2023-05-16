<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
include_once("sgjp/funcionesDocumentos.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script src="../Scripts/base64.js" ></script>
<script src="../modulosEspeciales_SGJP/Scripts/editorFormatos.js.php" ></script>
<script src="../Scripts/ckeditor/ckeditor.js" ></script>
</head>

<body>
<?php
                        	
							
	$archivo=$baseDir."/modulosEspeciales_SGJP/formatos/formato07.html";
	
	$funcionLlenado=-1;
	$cuerpoDocumento=leerContenidoArchivo($archivo);
	if($funcionLlenado!="-1")
	{
		$cache=NULL;
		$arrValoresReemplazo=resolverExpresionCalculoPHP($funcionLlenado,$objParametros,$cache);
		if(gettype($arrValoresReemplazo)=="array")
		{
			foreach($arrValoresReemplazo as $llave=>$valor)
			{
				$cuerpoDocumento=str_replace("[".$llave."]",$valor,$cuerpoDocumento);
			}
		}
	}
	
	
?>

<input type="hidden" id="txtCuerpo" value="<?php echo bE($cuerpoDocumento)?>" />
<table width="100%">
	<tr>
    	<td align="center">
            <div style="width:800px; text-align:justify">
            <?php echo ($cuerpoDocumento)?>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
