<?php session_start() ;
	$lenguaje="1";//1.-ESPAÑOL;2.- INGLES
	if(isset($_POST["leng"]))
	{
		$lenguaje=$_POST["leng"];
		$_SESSION["leng"]=$lenguaje;
	}
	else
		if(isset($_SESSION["leng"]))
		{
			$lenguaje=$_SESSION["leng"];
		}
		else
			$_SESSION["leng"]="1";

	
	$login="";
	if(isset($_SESSION["idUsr"]))
	{
		if($_SESSION["idUsr"]!="-1")
		{
			$login=$_SESSION["login"];
		}
	}
	
	function mostrarSiLog()
	{
		global $login;
		if($login=="")
			echo	"style=\"display:none\"";
		else
			echo "style=\"display:''\"";
	}
	
	function ocultarSiLog()
	{
		global $login;
		if($login=="")
			echo	"style=\"display:''\"";
		else
			echo "style=\"display:none\"";
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr"><!-- InstanceBegin template="/Templates/Ljournal_A.dwt.php" codeOutsideHTMLIsLocked="false" -->
<?php 
include("../conexionRevistaE.php");
include("configurarIdioma.php"); 
include("funcionesComunesRevistaE.php"); 
$consulta="SELECT IDIDIOMA,IDIOMA,IMAGEN FROM 8002_idiomas ORDER BY IDIOMA";
$res=getValores($consulta);


?>
<script language="javascript">
	function enviar(lenguaje)
	{
		gE('leng').value=lenguaje;
		gE('formLenguaje').submit();
	}
</script>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"/>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<link rel="stylesheet" type="text/css" href="/css/externas.css" media="screen" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>RSPM</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->

<link rel="stylesheet" type="text/css" href="/estilos/estilos.css" />
<link rel="stylesheet" type="text/css" href="/estilos/estilosPrincipal.css" />
<link rel="stylesheet" type="text/css" href="/Scripts/ext/resources/css/ext-all.css"/>
<script type="text/javascript" src="/Scripts/ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="/Scripts/ext/ext-all.js"></script>
<script type="text/javascript" src="/Scripts/funcionesAjax.js"></script>
<script type="text/javascript" src="/Scripts/funcionesPagina.js"></script>
<script type="text/javascript" src="/Scripts/funcionesUtiles.js.php"></script>

</head>
<body>

<div id="main_title">
  <div class="wrapper">
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="14%" valign="middle"><img src="logo_rspm_m.gif" alt="RSPM" width="129" height="110" longdesc="home" /> </td>
          <td width="26%" valign="middle"><img src="aniv_dorado.gif" alt=""  align="absmiddle" /></td>
          <td width="32%">
		   <form action="/buscador/search.php" method="get" id="site_search" name="site_search">
			<?php 

	if ($_SESSION["leng"]=="2")
	{	
?>
			<span class="document">Search this site:</span>
			<?php 
	}
		else
		{
		?>	
		<span class="document">Buscar en este sitio:</span>
			<?php 
			}
		?>	
			
			<?php 
	if ($_SESSION["leng"]=="2")
	$var_txt = "Search RSPM";
	else
	$var_txt = "Buscar RSPM";
	?>
			
			<input type="text" onfocus="if(this.value!=''){this.value=''}" class="x-combo-list-hd" maxlength="255" size="20" value="<?php echo $var_txt; ?>" name="fulltext" id="search"/>
			<input type="image" class="button" value="go" src="/images/search_ico.gif"/>
		    </form>

		  </td>
          <td width="28%">
		  	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="formLenguaje">
			<?php 
			while($fila=mysql_fetch_row($res)) 
			{
				echo "<a href=\"javascript:enviar('".$fila[0]."');\"><img src=\"images/banderas/".$fila[2]."\" border=\"0\" title=\"".$fila[1]."\" /></a>&nbsp;&nbsp; ";
			}
		  	?>
			
			<input type="hidden" id="leng" name="leng" value="" />
	  </form>

</td>
        </tr>
      </table>
  </div>
</div>

<!-- InstanceBeginEditable name="titular" -->
<div id="navigation">
	
	<div class="wrapper">
		<div class="links">
			
			
			<?php 

	if ($_SESSION["leng"]=="2")
	{	
?>
<ul class="tabs">
				<li><span><a href="/index.php?iss=1">Home</a></span></li>
				<li><span><a href="/index.php?iss=2">Directory</a></span></li>
				<li><span><a href="/index.php?iss=3">Subscribe</a></span></li>
				<li><a href="/index.php?iss=4">News</a></li>
				<li><span><a href="/sometimiento.php">Submission On Line </a><a href="/support.php"></a></span></li>
				<li><span><a href="/gb.php">Guestbook</a><a href="/punbb"></a></span></li>
				<li><span><a href="/index.php?iss=5">About RSPM </a></span></li>			
</ul>
<?php 
	}
		else
		{
		?>	
<ul class="tabs">
				<li><span><a href="/index.php?iss=1">Inicio</a></span></li>
				<li><span><a href="/index.php?iss=2">Directorio</a></span></li>
				<li><span><a href="/index.php?iss=3">Suscripciones </a></span></li>
				<li><span><a href="/index.php?iss=4">Informes y avisos </a></span></li>
				<li><a href="/sometimiento.php">Sometimiento en L&iacute;nea </a></li>
				
				<li><span><a href="/gb.php">Libro de visitas </a></span></li>
				<li><span><a href="/index.php?iss=5">Acerca de RSPM </a></span></li>			
		  </ul>
			<?php 
			}
		?>	
		<div class="clearer">&nbsp;</div>

	  </div>

	</div>
			
</div>


<div id="subnavigation">
	<div class="wrapper">
		<div class="content">
			<div class="links">
			<?php 

	if ($_SESSION["leng"]=="2")
	{	
?>
<a href="/examples/full.php" class="selected">Archive</a><a href="/estadisticas.php">Statistics</a><a href="/trabajos.php">Accepted manuscripts </a><a href="/actual.php">Current </a><a href="/editoriales.php">Editorials</a>		
<?php 
	}
		else
		{
		?>	
<a href="/examples/full.php" class="selected">Archivos</a><a href="/estadisticas.php">Estad&iacute;sticas</a><a href="/trabajos.php">Trabajos aceptados </a><a href="/actual.php">N&uacute;mero actual </a><a href="/editoriales.php">Editoriales</a>
<?php 
			}
		?>	
<div class="clearer">&nbsp;</div>
		  </div>
	  </div>
	</div>
</div>

<!-- InstanceEndEditable -->
<div id="main">
	<div class="wrapper">

		<div id="main_content">			


			<div id="main_single" class="p15">
				<table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
                  <tr>
                  <!-- InstanceBeginEditable name="menu_left" -->
				    <td width="18%">
				
				<?php 
	//Zonas
	$leng=$_SESSION["leng"];
	$sqlZonas = "SELECT tblzonas.IdZona,Titulo FROM tblzonas,tblzontitulos WHERE 
	tblzonas.IdZona=tblzontitulos.IdZona AND IdIdioma=$leng AND Publicada=1 ";
	//NIVEL 1 ZONAS
	$resultZonas = mysql_query($sqlZonas,$conexion)or die(mysql_error());
	while ($rowZonas = mysql_fetch_row($resultZonas))
	{
		$Zona=strtoupper($rowZonas[1]);
		echo "<p class='tituloTabla' >$Zona</p><br>";
		//Verificar si esa zona tiene algun tema asociado
		$resultZonaTema = mysql_query("SELECT IdTema FROM tblpertenecetema WHERE IdZona=$rowZonas[0]",$conexion)or die(mysql_error());
		if(mysql_affected_rows()!=0)
		{
			while ($rowZonaTema = mysql_fetch_row($resultZonaTema))
			{
				$s="SELECT tbltematitulos.IdTema,Titulo FROM tbltematitulos,tblcontenidos 
				WHERE tbltematitulos.IdTema=tblcontenidos.IdTema AND tbltematitulos.IdIdioma=tblcontenidos.IdIdioma 
				AND tbltematitulos.IdTema=$rowZonaTema[0] AND tbltematitulos.IdIdioma=$leng";
				$resultTiTema=mysql_query($s,$conexion)or die(mysql_error());		
				while ($rowTitTema = mysql_fetch_row($resultTiTema))//Agregar el link al contenido////////////////////*******
				{
					$sImg="SELECT Imagen,Descripcion FROM tbltematitulodesc WHERE IdTema=$rowTitTema[0]  AND Publicada=1";
					$resultImg=mysql_query($sImg,$conexion)or die(mysql_error());		
					while ($rowImg = mysql_fetch_row($resultImg))
					{
					if($rowImg[0]=="no")//No hay imagen
						echo "
						<a href='index.php?iss=$rowTitTema[0]&idioma=$leng&titulo=$rowTitTema[1]' title='$rowTitTema[1]' target='contenidos'>
						$rowTitTema[1]</a><br><br>";
					else//Mostrar imagen
						echo "
						<a href='index.php?iss=$rowTitTema[0]&idioma=$leng&titulo=$rowTitTema[1]' title='$rowTitTema[1]' target='contenidos'>
						<img src='images/$rowImg[0]' width=60 height=50></a><br><br>";
					}
				}
			}
		}
		
		//NIVEL 2 SECIONES
		$sqlSecciones = "SELECT tblsecciones.IdSeccion,Titulo,IdZona FROM tblsecciones,tblsecctitulos WHERE
		tblsecciones.IdSeccion=tblsecctitulos.IdSeccion AND tblsecciones.IdZona=$rowZonas[0] AND Publicada=1 AND IdIdioma=$leng";
		//echo $sqlSecciones,exit;
		$resultSecciones = mysql_query($sqlSecciones,$conexion)or die(mysql_error());
		while ($rowSecciones = mysql_fetch_row($resultSecciones))
		{
			$Seccion=$rowSecciones[1];
			echo "<div class='push'><b>$Seccion</b></div><br><br>";
			
			//Verificar si esa seccion tiene algun tema asociado
			$resultSeccTema = mysql_query("SELECT IdTema FROM tblpertenecetema WHERE IdSeccion=$rowSecciones[0]",$conexion)or die(mysql_error());
			if(mysql_affected_rows()!=0)
			{
			echo "<div id='example_content'>";
				while ($rowSeccTema = mysql_fetch_row($resultSeccTema))
				{
					$s="SELECT tbltematitulos.IdTema,Titulo FROM tbltematitulos,tblcontenidos 
					WHERE tbltematitulos.IdTema=tblcontenidos.IdTema AND tbltematitulos.IdIdioma=tblcontenidos.IdIdioma 
					AND tbltematitulos.IdTema=$rowSeccTema[0] AND tbltematitulos.IdIdioma=$leng";
					$resultTit=mysql_query($s,$conexion)or die(mysql_error());		
					while ($rowTit = mysql_fetch_row($resultTit))//Agregar el link al contenido y validar si es imagen
					{
						$sImg="SELECT Imagen,Descripcion FROM tbltematitulodesc WHERE IdTema=$rowTit[0] AND Publicada=1";
						$resultImg=mysql_query($sImg,$conexion)or die(mysql_error());		
						while ($rowImg = mysql_fetch_row($resultImg))
						{
						if($rowImg[0]=="no")//No hay imagen
						
							echo "<img src='images/bg_list_sub.gif' /><a href='index.php?iss=$rowTit[0]&idioma=$leng&titulo=$rowTit[1]' title='$rowImg[1]' target='contenidos'>
							$rowTit[1]</a><br>";
							
						else//Mostrar imagen
							echo "
							<a href='index.php?iss=$rowTit[0]&idioma=$leng&titulo=$rowTit[1]' title='$rowTit[1]' target='contenidos'>
							<img src='images/$rowImg[0]' width=60 height=50></a><br>";
						}
					}
				}
				echo "</div>";
			}
		}
	}
?>
					
					</td>
					<!-- InstanceEndEditable -->
                    <td width="1%" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="81%" bgcolor="#FFFFFF"><!-- InstanceBeginEditable name="content" --><h1>Full featured example</h1>
                      <div id="example_content">
				  
			      <p>conten</p>
				</div>					<!-- InstanceEndEditable -->				</td>
                  
				  
				  </tr>
                </table>
				
				
				<div class="clearer">&nbsp;</div>
		  </div>


			<div class="clearer">&nbsp;</div>
		</div>
	</div>
</div>

<div id="footer">
	<div class="wrapper">
		<div class="content">

		  <p class="right"><span class="small">&#169; 2009 <a href="http://www.insp.mx">INSTITUTO NACIONAL DE SALUD P&Uacute;BICA </a>. All rights Reserved.<br/>
LATIS's development, The power of the information</span></p>

			<p class="left">
				<a href="/index.php">RSPM</a> - <span class="copyrigth">ISSN: 0036-3634, ISSN E: 1606-7916</span></p>

			<p class="small">.		  </p>

			</div>
	</div>
</div>

</body>
<!-- InstanceEnd --></html>
