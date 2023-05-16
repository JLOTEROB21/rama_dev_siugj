<?php session_start();

	
	include("conexionBD.php");
	include("funcionesPortal.php");
	if(esUsuarioLog())
	{
		header('Location:'.$paginaInicioLogin);
		return;
	}
	
	$consulta="SELECT DISTINCT archivoInclude FROM 808_configuracionEstilosMenu WHERE idConfiguracion=".$iEstiloMenu;
	$nombreRendererMenu=$con->obtenerValor($consulta);
	if($nombreRendererMenu!="")
	{
		include($nombreRendererMenu);

	}
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>TSJDF</title>

<meta name="format-detection" content="telephone=no"/>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="../estilos/fontAwesome.min.css">
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/xtheme-gray.css"/>
<link rel="stylesheet" type="text/css" href="./css/estilos2016.css"/>

<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/funcionesAjaxV2.js"></script>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>

<script type="text/javascript" src="../Scripts/jquery.min.js"></script>
<link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css"  type="text/css" media="screen" />
<script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

<script type="text/javascript" src="../principalPortal/Scripts/indexTSJDF.js.php"></script>

<style>

	@font-face
	{
		font-family:'SoberanaSans_Regular';
		src: url('../tipografias/Soberana/SoberanaSans/SoberanaSans-Regular.otf');
		src: url('../tipografias/Soberana/SoberanaSans/SoberanaSans-Regular.otf?#iefix') format('embedded-opentype'),
		
		
	}

  .nivoSlider
  {
	  max-width:1100px !important;
	  
  }
  
  
  
  .tdImagen
  {
	  padding:10px;
  }
  
  .tituloSeccion
  {
		font-size: 39px;
		line-height: 45px;
		color: #7F3F95;
		font-family: SoberanaSans_Regular
		
		padding-left: 30px;
		padding-right: 30px;
  }
  
  .resumenSeccion
  {
		color: #000;
		font-family: SoberanaSans_Regular;
		font-size: 16px;
		font-style: normal;
		font-variant: normal;
		font-weight: 300;
		line-height: 24px;
		
		
  }
  
  .parrafoSeccion
  {
		color: #000;
		font-family: SoberanaSans_Regular;
		font-size: 13px;
		font-style: normal;
		font-weight: 300;
		line-height: 24px;
		text-align: justify;
		
		
		
  }
  
  .menuSeccion
  {
	  color: #000;
	  font-family: SoberanaSans_Regular;
	  font-size: 13px;
	  font-style: normal;
	  font-weight: 300;
	  line-height: 24px;
	  text-align: justify;
	  padding-top:3px;
	  padding-bottom:3px;
  }
  
  .menuSeccion a
  {
	  text-decoration:none;
	  color: #333;
  }
  .menuSeccion b
  {
	  font-size: 15px;
  }
  
  

    
    .wrapper 
	{
		
    	
		height: 1600px !important;/*100% !important;*/
    	
    	margin: 0 auto; 
    	
    }
    
   
    
   .section
   {
	   max-height:100px !important;
	  
   }

	.tablaSeccion
	{
		 background-image:url(../principalCensida/images/page1-img4.jpg);
	}
   
   	.opcionSel
	{
		font-weight:bold;
	}
	
	
	.iconosBarra
	{
		color:#D14F4E;
		font-family: SoberanaSans_Regular;
		font-size:52px; 
		text-align:center;
	}
	
	.iconosBarra a
	{
		text-decoration:none;
		color:#D14F4E;
		font-family: SoberanaSans_Regular;
		font-size:52px; 
	}
	
	
	.leyendaBarra
	{
		color:#D14F4E;
		font-family: SoberanaSans_Regular;
		font-size:15px; 
		text-align:center;
	}
	
	.leyendaBarra a
	{
		color:#D14F4E;
		font-family: SoberanaSans_Regular;
		font-size:15px; 
		text-decoration:none;
	}
	
	.letraLogin
	{
		text-decoration:none; 
		font-family:SoberanaSans_Regular; 
		font-size:12px; 
		color:#900; 
		font-weight:bold;
	}
	
	.tdMenuSeccion
	{
		/*border-bottom-color:#CCC; 
		border-bottom-width:1px; 
		border-bottom-style:solid;*/
	}
	
	.tdMenuSeccion i
	{
		font-weight:bold;
		font-size:17px;
	}
	
</style>
<?php
	
	generarConfiguracionesMenus($iEstiloMenu);
	
	$nConfiguracion=0;
	$nombreImagen="fondo-SCG.png";

	if($tipoMateria=="SW")
		$nombreImagen="fondo-SCGv2.png";
	
	
?>	
</head>

<body  style="background:#CFD2B2">

	<table width="100%" cellpadding="0" cellspacing="0" >
    <tr>
    	<td align="center">
            <table style="background:#FFF;max-width:1200px; min-width:1200px; background-image: url('./images/<?php echo $nombreImagen?>');background-size: 100%;">
                <tr>
                    <td align="center">
                        <table width="100%" cellspacing="0" style="padding:0px; border:0px;" >
                            <tr>
                                <td colspan="6" align="center">
                                    <table ><!-- border-bottom:#BBB; border-bottom-style:solid; border-bottom-width:1px-->
                                        <tr>
                                            <td width="250"  style="text-align:left; padding-left:30px">
                                              <!--  <img src="./images/tribunal.png" height="120" >-->
                                            </td>
                                            <td  style="width:220px">
                                            </td>
                                            <td align="right">
                                                <table cellspacing="0" width="260">
                                                	<tr>
                                                        <td colspan="6" align="center">
                                                           
                                                        </td>
                                                    </tr>
                                                    <?php
													if($tipoMateria=="SW")
													{
													?>
                                                    <tr>
                                                    	<td colspan="2">
                                                        <span style="font-size: 11px; font-weight:bold;font-family: Lucida Grande,Arial,sans-serif;">¿Aún no tienes una cuenta? <a href="javascript:mostrarPantallaRegistro()" style="text-decoration:none"><span  style="color:#F00">Regístrate</span></a></span>
                                                        </td>
                                                        <td></td>
                                                    	<td colspan="2">
                                                        <span style="font-size: 11px; font-weight:bold;font-family: Lucida Grande,Arial,sans-serif;">¿Olvidaste tu contraseña? <a href="javascript:mostrarPantallaRecuperar()" style="text-decoration:none"><span  style="color:#F00">Recup&eacute;rala</span></a></span>
                                                        </td>
                                                        
                                                    </tr>
                                                    <tr>
                                                    	<td colspan="6" align="center">
                                                        <span style="font-size: 11px; font-weight:bold;font-family: Lucida Grande,Arial,sans-serif;">¿Tienes un c&oacute;digo de acceso a videograbaci&oacute;n? <a href="javascript:abrirPantallaVideoGrabacion()" style="text-decoration:none"><span  style="color:#F00">Ingresa AQU&Iacute;</span></a></span>
                                                        </td>
                                                        
                                                        
                                                    </tr>
                                                    <?php
													}
													?>
                                                    <tr>
                                                        <td aling="center">
                                                            <div class="btnAcceso" style="color:#1F3100"><li class="fa fa-user fa-fw"></li></div>
                                                            
                                                        </td>
                                                        <td>
                                                            
                                                            <input type="text" class="campoFormulario" id="txtUsuario" placeholder="Usuario" onKeyPress="ocultarError(event)">
                                                        </td>
                                                        <td width="60">&nbsp;&nbsp;&nbsp;
                                                        </td>
                                                        <td align="center" >
                                                            <div class="btnAcceso" style="color:#1F3100"><li class="fa fa-key fa-fw"></li></div>
                                                            
                                                        </td>
                                                        <td>
                                                            <input type="password" class="campoFormulario" id="txtPasswd" placeholder="Contrase&ntilde;a" onKeyPress="ocultarError(event)">
                                                        </td>
                                                        <td>
                                                            <a href="javascript:autenticar()" style="text-decoration:none"><img src="./images/btn_log.png"></a>
                                                        </td>
                                                       
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td colspan="6" align="right">
                                                            
                                                            <span id="lblErr1"  class="letraLogin" style="display:none;color:#F00; font-weight:bold">Usuario / Contrase&ntilde;a incorrecta</span>
                                                            
                                                           
                                                        </td>
                                                    </tr>
                                                    
                                                    
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td colspan="6" align="center">
                                <table width="100%" >
                                <tr>
                                	<td align="center">
                                <div >
                                    <div class="wrap" style="border-color:#050562">
                                        <nav>
                                        <ul class="menu" >
                                            
                                <?php
								
                                    genearOpcionesMenusPrincipal("inicio",3);
                                    
                                        
                                ?>		</ul>
                                        <div class="clearfix"></div>
                                        </nav>
                                    </div>	
                                </div>
                                	</td>
                                 </tr>
                                </table>
                                </td>	
                            </tr>
                            
                            
                        </table>
                        
                        
                        <table width="100%" style="min-height:500px">
                        <tr >
                        	<td style="min-height:400px">
                            </td>
                        </tr>
                        </table>
                        
                        <table width="100%" cellspacing="0" style="background-color:#FFF" >
                            <tr>
                                <td   align="center" valign="top">
                                
                            
                            
                                    <table width="100%" cellspacing="0" style="background-color:#1F3100" >
                                    <tr>
                                        <td   class="leyendaBarra" style="text-align:left;padding:10px" ><br>
                                       
                                        
                                        
                                        </td>
                                        <td   class="leyendaBarra" style="text-align:right;padding:10px" ><br><br>
                                        <span style="color:#FFF; line-height:20px; font-size:13px"><b>
                                        Ni&ntilde;os H&eacute;roes No. 132, 
                                        Col. Doctores, 
                                        Ciudad de M&eacute;xico, C.P. 06720</b>
                                        </span>
                                        </td>
                                    </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
					</td>
            	</tr>
           </table>
        	  <form method="post"	action="" id='frmEnvioDatos'>
        <input type="hidden" name="confReferencia" value="<?php echo $nConfiguracion ?>" />
        
      
        
    </form>
        </td>
    </tr>
    </table>
</body>
</html>