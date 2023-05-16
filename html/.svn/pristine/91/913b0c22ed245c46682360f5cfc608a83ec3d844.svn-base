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
<script type="text/javascript" src="../registroUsuario/Scripts/registroUsuario.js.php"></script>     
</head>
	<body>
    	<?php
								
			/*$parametros=obtenerParametrosBase64($objParametros->param);
			
			$idProceso=$parametros["idProcesoRegistro"];
			$idRegistro=$parametros["idRegistro"];*/
			$idProceso=46;
			$idRegistro=-1;
			$consulta="SELECT * FROM 9018_configuracionProcesoRegistro WHERE idProceso=".$idProceso;
			$filaConf=$con->obtenerPrimeraFila($consulta);
			$solAfiliacion=$filaConf[2];
			$solAceptacion=$filaConf[3];
			$normas=$filaConf[4];
			$codInstitucionConv=date("Y_m_d_H_i_s_".rand());
			if($idRegistro!=-1)
			{
				$consulta="SELECT idFormulario FROM 9118_convocatoriasPublicadas WHERE idRegistro=".$idRegistro." AND idProcesoRegistro=".$idProceso." AND STATUS=1";
				$idFormulario=$con->obtenerValor($consulta);
			
				$consulta="select codigoInstitucion from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
				$codInstitucionConv=$con->obtenerValor($consulta);
			}
		?>
    	<div id="mlist">
            <div id="main">
               <div class="head">
                    <div id="linkhistory"><a href="#!/registro">Registro</a><span>»</span></div>
                </div>
                <div class="main">
                    <div class="container2">
                    <div class="container">
                        <div class="leftmenu">
                            <ul>
                                <li><a href="../principal/login.php">Ingresar</a></li>
                                <li><a href="../principal/recuperarDatosAccesoOSC.php">B&uacute;squeda OSC</a></li>
                                <li><a href="#" class="sel">Registro</a></li>
                            </ul>
                        </div>
                        <div id="registro" class="right">
                            <div id="reg_1">
                            <form action="forms/registro" onSubmit="c.submitForm(this,logI,['usuario','password','password2','email','dia','mes','ano']);return false">
                                
                                <div>
                                    <h2 class="padbot">Complete los siguientes datos generales</h2>
                                    
									<table>
                                    <tr>
                                    	<td>
                                        	<label>Apellido Paterno</label>
		                                    <input type="text" name="txtApPaterno" id="txtApPaterno" maxlength="40" size="30" />
                                        </td>
                                        <td>
                                        	<label>Apellido Materno</label>
		                                    <input type="text" maxlength="40" size="30" id='txtApMaterno' />
                                        </td>
                                        <td>
                                        	 <label>Nombre:</label>
		                                    <input type="text" maxlength="40" size="30" id='txtNombre' val='obj' campo='Nombre' />
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>Prefijo (Dr., Sr.):</label>
		                                    <input type="text" maxlength="20" size="7" id='txtPrefijo' val='' campo='Prefijo' />
                                        </td>
                                        <td>
                                        	<label>Fecha de nacimiento</label>
		                                    <span id='dteFechaNac'></span>
                                        </td>
                                        <td>
                                        	<input type="hidden" name="hFechaNac" id="hFechaNac" val='obj' campo='Fecha de nacimiento' extId='f_dteFechaNac' />
		                                    <label>Sexo</label>
                                            <div style="color:#000000; font-size:11px" ><input type="radio" id="sexoM"  checked="checked" /> Hombre&nbsp;&nbsp;&nbsp; <input type="radio"  id="sexoF"  /> Mujer</div>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>E-mail:</label>
		                                    <input type="text" maxlength="50" size="50" id='txtMail' val='' campo='' />
                                        </td>
                                        <td>
        	                               	<label>Confirme E-mail:</label>
		                                    <input type="text" maxlength="50" size="50" id='txtMail2' val='' campo='' />
                                        </td>
                                        <td>
                                        	
                                        </td>
                                    </tr>
                                    </table><br>
                                     <?php
											if($solAfiliacion==1)
											{
										?>
                                    <h2 class="padbot">Complete los siguientes datos laborales</h2>
                                    <table>
                                        <tbody id="tablaInstitucion">
                                            <tr>
                                                <td width="130">
                                                    <label>Instituci&oacute;n:</label>
                                                    
                                                </td>
                                                <td>
                                                    <input type="text" name="txtInstitucion" id="txtInstitucion" size="70">
                                                    <input type="hidden"  id="idInstitucion" value="" />
                                                    <input type="hidden"  id="codInstitucion" value="" />
                                                </td>
                                                
                                            </tr>
                                            <tr style="display:" id="filaRegistro">
                                                  <td class="" height="23"></td>
                                                  <td align="right"><span class="corpo8_bold" style="font-size:11px">¿No encuentras la institución correcta?, registrala </span><a href="javascript:agregarInstitucion()"><span  style="color:#F00; font-size:11px"><b>AQUÍ</b></span></a>
                                                  </td>
                                              </tr>  
                                            <tr style="display:none" id="filaDatosC">
                                                  <td class="" height="23"></td>
                                                  <td><label id="lblDatosC" class="copyrigth"></label>
                                                      
                                                  </td>
                                              </tr>
                                            
                                            <tr style="display:none" id="filaDiv1">
                                                  <td class="letraFicha" height="23" ><label>División / Depto. / Área  1:</label></td>
                                                  <td >&nbsp;
                                                      <select id="cmbDiv_1"  onchange="comboDivisionCambio(this)">
                                                      </select>&nbsp;&nbsp;<a href="javascript:agregarDepto(1)"><img height="16" width="16" src="../images/book_add.jpg" alt="Registrar nueva División / Depto. / Área" title="Registrar nueva División / Depto. / Área" /></a>
                                                  </td>
                                              </tr>	
                                        </tbody>
                                    </table><br>
                                    <?php
											}
											if($solAceptacion==1)
											{
									?>
                                    <h2 class="padbot">Normas del sitio</h2>
                                    <table>
                                    	<tr>
                                        	<td>
                                              
                                              <div style="width:700px; height:100px; overflow:auto">
                                              <?php
                                                  echo $normas;
                                              ?>
                                              </div><br /><br /><br /><br />
                                              <input type="checkbox" id='chkAcepto' />&nbsp;<span class="corpo8_bold"><label>He leído, y estoy de acuerdo en cumplir las normas de sitio</label></span>
                                          </td>
                                        </tr>
                                    </table>
                                    	<?php
											}
										?>
                                </div>
                                <div class="clear"></div>
                                <div class="but mar5 floatl"><input style="width:80px" type="button" onClick="agregarAutor()" name="btnAgregarAutor" id="btnAgregarAutor" value="Registrarse" class="boton left" /><div class="clearl"></div></div>
                                
                                <input type="hidden" id="hIdAfiliacion" name="hIdAfiliacion" value="" />
                                <input type="hidden" id="hIdAutor" name="hIdAutor" value="" />
                                <input type="hidden" id="singular" value="<?php echo $singular?>" />
                                <input type="hidden" id="plural" value="<?php echo $plural?>" />
                                <input type="hidden" id="idProceso" value="<?php echo $idProceso?>" />
                                 <input type="hidden" id="idRegistro" value="<?php echo $idRegistro?>" />
                                 <input type="hidden" id="solAfiliacion" value="<?php echo $solAfiliacion?>" />
                                 <input type="hidden" id="codInstitucionConv" value="<?php echo $codInstitucionConv?>" />
                            </form>
                            </div>
                            <div id="reg_2" style="display:none">
                                <h1>Cuenta creada con éxito</h1>
                               
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="clear"></div>
                </div>
               
            </div> 
		</div>                       
	</body>
</html>      

