<?php include("conexionBD.php");
	$colorMenu=$_POST["colorMenu"];
	$colorLetraMenu=$_POST["colorLetraMenu"];
	$colorMenuMouseOver=$_POST["colorMenuMouseOver"];
	$colorLetraMouseOver=$_POST["colorLetraMouseOver"];
	$colorBurbuja=$_POST["colorBurbuja"];
	$colorLetraBurbuja=$_POST["colorLetraBurbuja"];

	
	
	$consulta="UPDATE 4081_configuracionPortal SET colorMenu='".$colorMenu."',colorLetraMenu='".$colorLetraMenu.
			"',colorMenuMouseOver='".$colorMenuMouseOver."',colorLetraMouseOver='".$colorLetraMouseOver.
			"',colorBurbuja='".$colorBurbuja."',colorLetraBurbuja='".$colorLetraBurbuja."'";

	if($con->ejecutarConsulta($consulta))
	{
		if (!empty($_FILES["bannerSuperior"]['name']))
		{
			$binario_nombre_temporal=$_FILES["bannerSuperior"]['tmp_name'] ;
			copy($binario_nombre_temporal,$baseDir."/principalPortal/imagesInstitucionales/header.png");			
		}
		
		if (!empty($_FILES["bannerInferior"]['name']))
		{
			$binario_nombre_temporal=$_FILES["bannerInferior"]['tmp_name'] ;
			copy($binario_nombre_temporal,$baseDir."/principalPortal/imagesInstitucionales/footer.png");
		}
		
		if (!empty($_FILES["pantallaCentral"]['name']))
		{
			$binario_nombre_temporal=$_FILES["pantallaCentral"]['tmp_name'] ;
			copy($binario_nombre_temporal,$baseDir."/principalPortal/imagesInstitucionales/bienvenido.png");
		}
		
		if (!empty($_FILES["imagenFondo"]['name']))
		{
			$binario_nombre_temporal=$_FILES["imagenFondo"]['tmp_name'] ;
			copy($binario_nombre_temporal,$baseDir."/principalPortal/imagesInstitucionales/fondo.jpg");
		}
		
		if (!empty($_FILES["imagenLogin"]['name']))
		{
			$binario_nombre_temporal=$_FILES["imagenLogin"]['tmp_name'] ;
			copy($binario_nombre_temporal,$baseDir."/principalPortal/imagesInstitucionales/loginFondo.png");
		}
		
		if (!empty($_FILES["archivoHojaEstilo"]['name']))
		{
			$binario_nombre_temporal=$_FILES["archivoHojaEstilo"]['tmp_name'] ;
			copy($binario_nombre_temporal,$baseDir."/Scripts/ext/resources/css/ext_cssComplementario.css");
		}
		
		
	}
	
	
	header('Location:../Sistema/frmConfiguracionPortal.php');
?>