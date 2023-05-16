<?php include("conexionBD.php");
	$imagen=$HTTP_RAW_POST_DATA;
	
	$imagenData=substr($imagen, strpos($imagen, ",")+1);
	
	$unencodedImagenData=base64_decode($imagenData);
	$nombreArchivo=rand()."_".date("dmY_Hms");
	$fp = fopen( '../archivosTemporales/'.$nombreArchivo, 'wb' );
	fwrite( $fp, $unencodedImagenData);
	fclose( $fp );
	echo "1|".$nombreArchivo."|".$nombreArchivo."|".filesize('../archivosTemporales/'.$nombreArchivo);
?>