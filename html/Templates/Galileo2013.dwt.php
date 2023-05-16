<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0088)http://www.clubgalileo.com.mx/portal2013/index.php/team-bienvenida-alumnos-oto-2013.html -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" dir="ltr" slick-uniqueid="3"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!--<base href="http://www.clubgalileo.com.mx/portal2013/index.php/team-bienvenida-alumnos-oto-2013.html">--><base href=".">
  
  <meta name="keywords" content="Galileo Software Educativo">
  <meta name="author" content="Super User">
  <meta name="description" content="Club Galileo - Portal de sofware y contenido educativo">
  <meta name="generator" content="Joomla! - Open Source Content Management">
  <!-- TemplateBeginEditable name="doctitle" -->
  <title>TEAM Bienvenida Alumnos Oto 2013</title>
  <!-- TemplateEndEditable -->
<link href="http://www.clubgalileo.com.mx/portal2013/templates/galileo-olive/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
<link rel="stylesheet" href="../principalGalileo/archivos/position.css" type="text/css" media="screen,projection">
<link rel="stylesheet" href="../principalGalileo/archivos/layout.css" type="text/css" media="screen,projection">
<link rel="stylesheet" href="../principalGalileo/archivos/print.css" type="text/css" media="print">
<link rel="stylesheet" href="../principalGalileo/archivos/general.css" type="text/css">
<link rel="stylesheet" href="../principalGalileo/archivos/personal.css" type="text/css">
<link rel="stylesheet" href="../principalGalileo/archivos/modal.css" type="text/css">
<link rel="stylesheet" href="../principalGalileo/css/estilosGalileo.css" type="text/css">

<!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
<!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<?php
if(!isset($excluirExt))
{
?>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
<?php
}
?>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesGenerales.js"></script>
<?php
$ocultarFormulariosEnvio=false;
$nomPagina=$_SERVER["PHP_SELF"];
$arrPagina=	explode("/",$nomPagina);
$nElementos=sizeof($arrPagina);
$nomPagina=$arrPagina[$nElementos-1];
$rutaNomPagina=$arrPagina[$nElementos-2]."/".$arrPagina[$nElementos-1];
$arrPagina=explode(".",$nomPagina);
$nomPagina=$arrPagina[0];
$paramPOST=true;
$paramGET=false;
$guardarConfSession=false;
$arrPOST=array_values($_POST);
$ctPOST=sizeof($arrPOST);
$arrGET=array_values($_GET);
$ctGET=sizeof($arrGET);

$mostrarBanner=true;
$mostrarLogoHome=true;
$logoBanner="../principalGalileo/archivos/logoestudiantes.png";
?>
<!-- TemplateBeginEditable name="EditRegion100" -->
<!-- TemplateEndEditable -->

<?php
$arrValores=null;
$arrLlaves=null;
$nConfiguracion="-1";
if(($paramPOST)&&($ctPOST>0))
{
	$arrLlaves=array_keys($_POST);
	$arrValores=array_values($_POST);
}
else
{
	if(($paramGET)&&($ctGET>0))
	{
		$arrLlaves=array_keys($_GET);
		$arrValores=array_values($_GET);
	}
}


$ctParams=sizeof($arrLlaves);
$parametros='';
for($x=0;$x<$ctParams;$x++)
{
	if(gettype($arrValores[$x])=='array')
	{
		$cadAux="";
		foreach($arrValores[$x] as $v)
		{
			if($cadAux=="")
				$cadAux="'".$v."'";
			else
				$cadAux.=",'".$v."'";
		}
		$arrValores[$x]=$cadAux;
	}
	if($parametros=='')
	{
	  $parametros='"'.$arrLlaves[$x].'":"'.$arrValores[$x].'"';
	}
	else
	{
	  $parametros.=',"'.$arrLlaves[$x].'":"'.$arrValores[$x].'"';	
	}
}
if($parametros!='')
	$parametros.=',"paginaConf":"../'.$rutaNomPagina.'"';
else
	$parametros.='"paginaConf":"../'.$rutaNomPagina.'"';
$parametros='{'.$parametros.'}';
$objParametros=json_decode($parametros);
$pConfRegresar="";
$nConfRegresar="";


?>

<?php
if($guardarConfSession)
{
	if(isset($objParametros->configuracion))
	{
		$nConfiguracion=$objParametros->configuracion;
		$parametros=$_SESSION["configuracionesPag"][$nConfiguracion]["parametros"];			
		$objParametros=json_decode($parametros);
		if(isset($objParametros->confReferencia))
		{
			if(isset($_SESSION["configuracionesPag"][$objParametros->confReferencia]))
			{
				$configuracionAux=$_SESSION["configuracionesPag"][$objParametros->confReferencia]["parametros"];
				$objAux=json_decode($configuracionAux);
				$pConfRegresar=$objAux->paginaConf;
				$nConfRegresar=$objParametros->confReferencia;
				$pagRegresar="javascript:regresarPagina()";
			}
			//eliminarReferencia($nConfiguracion);
		}
	}
	else
	{
		if(isset($_SESSION["configuracionesPag"]))
		{
			$nConfiguracion=sizeof($_SESSION["configuracionesPag"])-1;
			
			$ultimaConf=$_SESSION["configuracionesPag"][$nConfiguracion]["parametros"];
			if($ultimaConf!=$parametros)
				$nConfiguracion++;
		}
		else
			$nConfiguracion=0;
		$_SESSION["configuracionesPag"][$nConfiguracion]["parametros"]=$parametros;
		if(isset($objParametros->confReferencia))
		{
			if($objParametros->confReferencia!="-1")
			{
				$_SESSION["configuracionesPag"][$nConfiguracion]["referencia"]=$objParametros->confReferencia;
			
				$configuracionAux=$_SESSION["configuracionesPag"][$objParametros->confReferencia]["parametros"];
				$objAux=json_decode($configuracionAux);
				$pConfRegresar=$objAux->paginaConf;
				$nConfRegresar=$objParametros->confReferencia;
				$pagRegresar="javascript:regresarPagina()";
			}
		}
	}
	
	
	if(($logSistemaAccesoPaginas)&&(isset($_SESSION["idUsr"])))
		guardarBitacoraAccesoPagina($rutaNomPagina,$parametros);
}
else
{
	if(($logSistemaAccesoPaginas)&&(isset($_SESSION["idUsr"])))
	{
		$parametros="";
		if($ctPOST>0)
		{
			$aLlaves=array_keys($_POST);
			$aValores=array_values($_POST);
			for($nCtParam=0;$nCtParam<$ctPOST;$nCtParam++)
			{
				$parametros.="&".$aLlaves[$nCtParam]."=".$aValores[$nCtParam];
			}
		}
		else
		{
			if($ctGET>0)
			{
				$aLlaves=array_keys($_GET);
				$aValores=array_values($_GET);
				for($nCtParam=0;$nCtParam<$ctGET;$nCtParam++)
				{
					$parametros.="&".$aLlaves[$nCtParam]."=".$aValores[$nCtParam];
				}
			}
		}
		guardarBitacoraAccesoPagina($rutaNomPagina,$parametros);
	}
}





?>
<script language="javascript">
	function enviar(lenguaje)
	{
		gE('leng').value=lenguaje;
		gE('formLenguaje').submit();
	}
	
	function regresarPagina()
	{
		if(gE('configuracionRegresar').value!='')
			gE('frmRegresar').submit();
		else
			recargarPagina();
	}
	
	function recargarPagina()
	{
		gE('frmRefrescarPagina').submit();
	}
	
</script>
<!--[if lte IE 6]>
<link href="/portal2013/templates/galileo-olive/css/ieonly.css" rel="stylesheet" type="text/css" />
<style type="text/css">
#line {
  width:98% ;
}
.logoheader {
  height:200px;
}
#header ul.menu {
  display:block !important;
  width:98.2% ;
}
</style>
<![endif]-->

<!--[if IE 7]>
<link href="/portal2013/templates/galileo-olive/css/ie7only.css" rel="stylesheet" type="text/css" />
<![endif]-->


<!-- TemplateBeginEditable name="head" -->
<!-- TemplateEndEditable -->
</head>
<body style="font-size: 100%;">
    
  <div id="all">
  		<?php
			if($mostrarBanner)
			{
		?>
        <div id="back">
            <div id="header">
                <div class="logoheader">
                                <h1 id="logo">
        
                                <table style=" border:hidden; ">
                                <tbody>
                                    <tr>
                                        <td width="190" style=" border:hidden;">
                                            <img src="<?php echo $logoBanner?>" alt="">
                                        </td>
                                        <td width="280" style=" border:hidden; ">
                                            <span class="header1">
                                            </span>
                                        </td>
                                        <?php
											if($mostrarLogoHome)
											{
										?>
                                        <td width="60" style=" border:hidden; text-align:right; vertical-align:bottom; ">
                                            <p align="rigth"><a href="http://www.clubgalileo.com.mx/portal2013/"><img src="../principalGalileo/archivos/home.png" border="0" alt=""></a></p>
                                        </td>
                                        <?php
											}
											
										?>
                                    </tr>
                                </tbody>
                                </table>
                                </h1>
                </div>
            </div>
        </div>
        <br />
        <?php
			}
		?>
        <table width="100%">
        <tr>
        	<td>
			<!-- TemplateBeginEditable name="EditRegion24" -->
			
			<!-- TemplateEndEditable -->
            
            </td>
        </tr>
        </table>
    </div>
    
    
    <?php
		  if(!$ocultarFormulariosEnvio)
		  {
	?>
			  <form method="post"	action="" id='frmEnvioDatos'>
				  <input type="hidden" name="confReferencia" value="<?php echo $nConfiguracion ?>" />
				  
				  
				  
			  </form>
			  <form method="post"	action="<?php echo $pConfRegresar?>" id='frmRegresar'>
				  <input type="hidden" name="configuracion" id="configuracionRegresar" value="<?php echo $nConfRegresar ?>" />
			  </form>
			  <form method="post"	action="<?php echo "../".$rutaNomPagina ?>" id='frmRefrescarPagina'>
				  <input type="hidden" name="configuracion" value="<?php echo $nConfiguracion ?>" />
			  </form>    
		  
	  <?php 	
		  }
		 ?>
</body>
</html>