<?php 
include("conexionBD.php"); 
?>
<html>
	<head>
    	<?php
$paramPOST=true;
$paramGET=true;
$arrPOST=array_values($_POST);
$ctPOST=sizeof($arrPOST);
$arrGET=array_values($_GET);
$ctGET=sizeof($arrGET);
$arrValores=null;
$arrLlaves=null;
$sqlmax = "SELECT disenoBanner,textoInfIzq,textInfDerecho,tituloPagina,Menu,barraIn FROM 4081_colorEstilo";
$unico= $con->obtenerPrimeraFila($sqlmax);
$banner=$unico[0];
$textoInfIzq=$unico[1];
$textoInfDer=$unico[2];
$tituloPagina=$unico[3];
$nomPagina=$_SERVER["PHP_SELF"];
$arrPagina=	explode("/",$nomPagina);
$nElementos=sizeof($arrPagina);
$nomPagina=$arrPagina[$nElementos-1];
$rutaNomPagina=$arrPagina[$nElementos-2]."/".$arrPagina[$nElementos-1];
$arrPagina=explode(".",$nomPagina);
$nomPagina=$arrPagina[0];
$guardarConfSession=true;

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

$pConfRegresar="../principal/inicio.php";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<link rel="stylesheet" type="text/css" href="../estilos/coma.css"/>
<style>
	input
	{
		padding:3px !important;
	}
	
	label
	{
		color:#006;
		font-size:12px;
	}
	
	body
	{
		color:#000000;
		font-size:11px;
	}
	
	.head 
	{
		background-color:#<?php echo $unico[4]?> !important;
		background-image: -moz-linear-gradient(#<?php echo $unico[4]?>,#<?php echo $unico[4]?>)  !important;;
		background-image: -webkit-gradient(linear,0% 0,0% 100%,from(#<?php echo $unico[4]?>),to(#<?php echo $unico[4]?>))  !important;;
		background-image: -webkit-linear-gradient(#<?php echo $unico[4]?>,#<?php echo $unico[4]?>  !important;);
		background-image: -o-linear-gradient(#<?php echo $unico[4]?>,#<?php echo $unico[4]?>)  !important;
		border-bottom: 1px solid #<?php echo $unico[4]?> !important;
		border-top: 1px solid #<?php echo $unico[4]?> !important;
	}
	.main
	{
		border-top: 1px solid #<?php echo $unico[4]?> !important ;
	}
	.container2 
	{
		background-color:#<?php echo $unico[4]?> !important;

	}
	
	.container
	{
		border-right: 0px !important;
	}
	
	.boton
	{
		background-color:#<?php echo $unico[4]?> !important;
		background-image: -moz-linear-gradient(#<?php echo $unico[4]?>,#<?php echo $unico[4]?>)  !important;;
		background-image: -webkit-gradient(linear,0% 0,0% 100%,from(#<?php echo $unico[4]?>),to(#<?php echo $unico[4]?>))  !important;;
		background-image: -webkit-linear-gradient(#<?php echo $unico[4]?>,#<?php echo $unico[4]?>  !important;);
		background-image: -o-linear-gradient(#<?php echo $unico[4]?>,#<?php echo $unico[4]?>)  !important;
	}
	
	
	.leftmenu 
	{
		width:110px !important;
	}
	.right
	{
		width: 600px !important;
	}
	.leftmenu 
	{
		width:110px !important;
	}
	.right
	{
		width: 600px !important;
	}
	
	.leftmenu li a:hover
	{
		background: #FFFFFF !important;
		color: #000000 !important;		
		border-top: 1px solid #FFFFFF !important;
		border-bottom: 1px solid  #FFFFFF !important;
		filter: alpha(opacity=60);
		-khtml-opacity: 0.6; 
		-moz-opacity: 0.6;
		opacity: 0.6; 
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=60)"
	}
	
	.leftmenu li a
	{
		text-shadow:0 0px 0 white !important;
		color: #FFFFFF !important;
	}
	
	.leftmenu li a.sel 
	{
		color: #000000 !important;
	}
	
</style>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>

<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>

<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>   
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type="text/javascript" src="../principal/Scripts/recuperarDatosAccesoTSJCDMX.js.php"></script>  
        

    </head>
	<body>
    	<div id="mlist">
            <div id="main">
                <div class="head inicio">
                    <div id="linkhistory"><a href="#">Recuperar datos de acceso</a><span>»</span></div>
                </div>
                <div class="main">
                    <div class="container2">
                        <div class="container">
                            <div class="leftmenu">
                                
                                <div id="filters"></div>
                            </div>
                            <div class="right">
                                <div id="pass_1">
                                <h1>Ingrese la dirección de correo electr&oacute;nico con la cual se registr&oacute;</h1>
                                <p>Por favor, ingrese su dirección de correo electr&oacute;nico, de esta forma recibir&aacute; un email con sus datos de acceso</p>
                                <form action="forms/recuperarclave">
                                    <div id="errormsg" class="errormsg"></div>
                                    <label>Correo electr&oacute;nico:</label>
                                    <input type="email" id="email"  style="width:300px" />
                                    <div class="clear"></div>
                                    
                                </form>
                                </div><br><br>
                                <table width="100%">
                                    <tr>
                                    	<td align="right">
                                    <input style="width:190px; float: right;" type="button" name="login" value="Recuperar datos de acceso" class="boton left" onClick="recuperarDatosAcceso()" /> <div class="load"><img src="http://sc.cuevana.tv/img/loader_small.gif" /></div><div class="clearl"></div></div>
                                    	</td>
                                    </td>
                                    </table>
                            </div>
                        </div>
                        </div>
                    <div class="clear"></div>
                </div>
            </div> 
		</div>                       
	</body>
</html>            