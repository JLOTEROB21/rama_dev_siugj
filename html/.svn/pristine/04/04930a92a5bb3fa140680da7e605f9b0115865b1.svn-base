<?php session_start();
	include("conexionBD.php"); 
	include("funcionesImagenes.php");
	$colorFondoEx=$_POST['colorFondoEx'];
	$colorFondoIn=$_POST['colorFondoIn'];
	$colorMenu=$_POST['colorMenu'];
	$colorBarraIn=$_POST['colorBarraIn'];
	$colorMenuIn=$_POST['colorMenuIn'];
	$colorBanner=$_POST['colorBanner'];
	$colorLink=$_POST['colorLink'];
	$colorTiTabla=$_POST['colorTiTabla'];
	$colorCelda1=$_POST['colorCelda1'];
	$colorCelda2=$_POST['colorCelda2'];

	$colorCelda3=$_POST['colorCelda3'];

	$colorLeTabla=$_POST['colorLeTabla'];
	$colorTxTabla=$_POST['colorTxTabla'];
	$colorFuMenu=$_POST['colorFuMenu'];
	$tamFuMenu=$_POST['tamFuMenu'];
	$colorBordeIn=$_POST['colorBordeIn'];
	$botonRadioMenu=$_POST['botonRadioMenu'];
	$disenoBanner=$_POST["valorContenido"];
	$sustituye = array("\r\n", "\n\r", "\n", "\r");
	$colorLeNivel1=$_POST['colorLeNivel1'];
	$colorLeNivel2=$_POST['colorLeNivel2'];
	
	$colorLePieIzq=$_POST['colorLePieIzq'];
	$colorTxTabla1=$_POST['colorTxTabla1'];
	$colorTxTabla2=$_POST['colorTxTabla2'];
	$colorTxTabla3=$_POST['colorTxTabla3'];
	$colorTxTabla4=$_POST['colorTxTabla4'];
	$colorTxTabla5=$_POST['colorTxTabla5'];
	$colorBorde1=$_POST['colorBorde1'];
	
	$colortxtImpre1=$_POST['colortxtImpre1'];
	$colortxtImpre2=$_POST['colortxtImpre2'];
	$colorCeldaImp1=$_POST['colorCeldaImp1'];
	$colorCeldaImp2=$_POST['colorCeldaImp2'];
	
	
	
	$disenoBanner=str_replace($sustituye,'',$disenoBanner);
	$pieDer=str_replace($sustituye,'',$_POST["valorPieDer"]);
	$pieIzq=str_replace($sustituye,'',$_POST["valorPieIzq"]);
	$tituloPag=$_POST["tituloPagina"];
	$consulta=array();
	$x=0;
	$consulta[$x]="begin";
	$x++;
	if ($botonRadioMenu=='color')
	{
		$botonazo=$_POST['colorBoton'];
	}
	else
	{
		$botonazo=NULL;
		
		if (!empty($_FILES['up']['name']))
		{
			 
				  $binario_nombre_temporal=$_FILES['up']['tmp_name'] ;
				  $binario_contenido='';
				  $binario_contenido = addslashes(fread(fopen($binario_nombre_temporal, "rb"), filesize($binario_nombre_temporal)));
				  $binario_nombre=$_FILES['up']['name'];
				  $binario_peso=$_FILES['up']['size'];
				  $binario_tipo=$_FILES['up']['type'];
				  $binario_descripcion=NULL;
				  $binario_titulo=NULL;
				  $tipoArchivo=4;
				  $consulta[$x] = "DELETE FROM 4080_archivosEditor WHERE tipoArchivo IN(4)";
				  $x++;
				  $consulta[$x] = "insert into 4080_archivosEditor(datosArchivo,tipoMIME,fechaSubida,tamArchivo,nombreArchivo,tipoArchivo,idUsuario,description,imageTitulo) 
								  values('".$binario_contenido."','".$binario_tipo."','".date('Y-m-d')."',".$binario_peso.",'".$binario_nombre."','".$tipoArchivo."',".$_SESSION["idUsr"].",'".$binario_descripcion."','".$binario_titulo."')";
				  $x++;
			
		}
	}
	
	
	if (!empty($_FILES['up2']['name']))
	{
			 
				  $binario_nombre_temporal=$_FILES['up2']['tmp_name'] ;
				  $binario_contenido='';
				  $binario_contenido = addslashes(fread(fopen($binario_nombre_temporal, "rb"), filesize($binario_nombre_temporal)));
				  $binario_nombre=$_FILES['up2']['name'];
				  $binario_peso=$_FILES['up2']['size'];
				  $binario_tipo=$_FILES['up2']['type'];
				  $binario_descripcion=NULL;
				  $binario_titulo=NULL;
				  $tipoArchivo=100;
				  $consulta[$x] = "DELETE FROM 4080_archivosEditor WHERE tipoArchivo IN(100)";
				  $x++;
				  $consulta[$x] = "insert into 4080_archivosEditor(datosArchivo,tipoMIME,fechaSubida,tamArchivo,nombreArchivo,tipoArchivo,idUsuario,description,imageTitulo) 
								  values('".$binario_contenido."','".$binario_tipo."','".date('Y-m-d')."',".$binario_peso.",'".$binario_nombre."','".$tipoArchivo."',".$_SESSION["idUsr"].",'".$binario_descripcion."','".$binario_titulo."')";
				  $x++;
	}
	
	
	$consulta[$x]="delete from 4081_colorEstilo";
	$x++;
	$consulta[$x]="insert into 4081_colorEstilo(fondoEx,fondoIn,Menu,barraIn,MenuIn,Banner,Link,TiTabla,Celda1,Celda2,LeTabla,TxTabla,FuMenu,tamFuMenu,BordeIn,botonazo,disenoBanner,textoInfIzq,textInfDerecho,tituloPagina,colorLeNivel1,colorLeNivel2,colorLePieIzq,TxTabla1,TxTabla2,TxTabla3,TxTabla4,Celda3,TxTabla5,colorBorde1,txtImpre1,txtImpre2,colorCeldaImp,colorCeldaImp2) 
				values('".cv($colorFondoEx)."','".cv($colorFondoIn)."','".cv($colorMenu)."','".cv($colorBarraIn)."','".cv($colorMenuIn)."','".cv($colorBanner)."','".cv($colorLink)."','".cv($colorTiTabla)."','".cv($colorCelda1)."','".cv($colorCelda2)."','".cv($colorLeTabla)."','".cv($colorTxTabla)."','".cv($colorFuMenu)."','".cv($tamFuMenu)."','".cv($colorBordeIn)."','".cv($botonazo)."','".cv($disenoBanner)."','".cv($pieIzq)."','".cv($pieDer)."','".cv($tituloPag)."','".cv($colorLeNivel1)."','".cv($colorLeNivel2)."','".cv($colorLePieIzq)."','".cv($colorTxTabla1)."','".cv($colorTxTabla2)."','".cv($colorTxTabla3)."','".cv($colorTxTabla4)."','".cv($colorCelda3)."','".cv($colorTxTabla5)."','".cv($colorBorde1)."','".cv($colortxtImpre1)."','".cv($colortxtImpre2)."','".cv($colorCeldaImp1)."','".cv($colorCeldaImp2)."')";
	
	$x++;
	$consulta[$x]="commit";
	$x++;
	$redireccionar=false;
	if($con->ejecutarBloque($consulta))
	{
		$redireccionar=true;
		$cPlantilla=new coloresPlantillas();
		if(file_exists('../images/main.gif'))
			unlink('../images/main.gif');
		$cPlantilla->cambiarColorMain($colorMenu,$colorFondoEx);
	}
	
?>
<body>
<form action="managerEstilos.php" method="POST" id="formaRegresa">

</form>

<script type="text/javascript">
<?php 
	if($redireccionar)
		echo "document.getElementById('formaRegresa').submit()"; 
?>
</script>

</body>
