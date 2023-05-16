<?php session_start();
	include("conexionBD.php"); 
 
	$colorFondoEx='D8C79E';
	$colorFondoIn='F3F6F9'; 
	$colorMenu='541C28';	 
	$colorBarraIn='AFA8F6'; 
	$colorMenuIn='FFFFFF';  
	$colorBanner='FFFFFF';
	$colorLink='CFCF95';
	$colorTiTabla='003300';
	$colorCelda1='FFFFDD';
	$colorCelda2='FFFFFF';
	$colorLeTabla='FFFFFF';
	$colorTxTabla='003366';
	$colorFuMenu='Arial';
	$tamFuMenu='100%';
	$colorBordeIn='FFFFFF';
	$tMenu="000000";
	$disenoBanner='<table width="100%"><tr><td align="center"></td><td align="center"></td><td align="center"></td></tr></table>';
	
	
	$consulta_borrar= "delete from 4081_colorEstilo";
	$consulta_insertar = "insert into 4081_colorEstilo(fondoEx,fondoIn,Menu,barraIn,MenuIn,Banner,Link,TiTabla,Celda1,Celda2,LeTabla,TxTabla,FuMenu,tamFuMenu,BordeIn,botonazo,disenoBanner) 
	values('".$colorFondoEx."','".$colorFondoIn."','".$colorMenu."','".$colorBarraIn."','".$colorMenuIn."','".$colorBanner."','".$colorLink."','".$colorTiTabla."','".$colorCelda1."','".$colorCelda2."','".$colorLeTabla."','".$colorTxTabla."','".$colorFuMenu."','".$tamFuMenu."','".$colorBordeIn."','".$tMenu."','".$disenoBanner."')";
	$con->ejecutarConsulta($consulta_borrar);
	$con->ejecutarConsulta($consulta_insertar);
?>
<body>
<form action="managerEstilos.php" method="POST" id="formaRegresa">
</form>

<script type="text/javascript">
<?php 
 echo "document.getElementById('formaRegresa').submit()"; 
?>
</script>
</body>
