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
$sqlmax = "SELECT disenoBanner,textoInfIzq,textInfDerecho,tituloPagina,Menu,barraIn,colorLeNivel2 FROM 4081_colorEstilo";
$unico= $con->obtenerPrimeraFila($sqlmax);
$banner=$unico[0];
$textoInfIzq=$unico[1];
$textoInfDer=$unico[2];
$tituloPagina=$unico[3];
$colorLetra=$unico[6];
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
		color: #<?php echo $colorLetra?> !important;
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
		color: #<?php echo $colorLetra?> !important;
	}
	
	.leftmenu li a.sel 
	{
		color: #<?php echo $colorLetra?> !important;
	}
	
	#mlist .head #linkhistory a 
	{
		color: #<?php echo $colorLetra?> !important;
	}
	
	#linkhistory 
	{
		text-shadow: 0 0 0 black; !important;
		line-height: 20px;
	}
</style>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>

<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>

<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>   
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type="text/javascript" src="../registroUsuario/Scripts/registroUsuarioSicoreWeb.js.php"></script>     
</head>
	<body>
    	<?php
								
			
			$idRegistro=-1;
			
		?>
    	<div id="mlist">
            <div id="main">
               <div class="head">
                    <div id="linkhistory"><a href="#!/registro">Registro de usuario</a><span>»</span></div>
                </div>
                <div class="main">
                    <div class="container2">
                    <div class="container">
                       
                        <div id="registro" class="right">
                            <div id="reg_1">
                                <div>
                                <span id="paso_1" style="display:" campoFocus="txtNombre">
                                    <h2 class="padbot">Datos generales</h2>
                                    <div style="height:350px">
									<table>
                                    <tr>
                                    	<td>
                                        	 <label>Nombre: <span style="color:#F00">*</span></label>
		                                    <input type="text" maxlength="40" style="width:180px" id='txtNombre' val='obj' campo='Nombre' />
                                        </td>
                                    	<td>
                                        	<label>Apellido Paterno: <span style="color:#F00">*</span></label>
		                                    <input type="text" name="txtApPaterno" id="txtApPaterno" maxlength="40"  style="width:160px" />
                                        </td>
                                        <td>
                                        	<label>Apellido Materno:</label>
		                                    <input type="text" maxlength="40" style="width:160px" id='txtApMaterno' />
                                        </td>
                                        
                                    </tr>
                                    
                                    <tr>
                                    	<td>
                                        	<label>E-mail: <span style="color:#F00">*</span></label>
		                                    <input type="text" maxlength="70" size="50" id='txtMail' val='' campo='' />
                                        </td>
                                        <td>
        	                               	<label>Confirme E-mail: <span style="color:#F00">*</span></label>
		                                    <input type="text" maxlength="70" size="50" id='txtMail2' val='' campo='' />
                                        </td>
                                        <td>
                                        	
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>Fecha de nacimiento: <span style="color:#F00">*</span></label>
		                                    <span id='dteFechaNac'></span>
                                        </td>
                                        <td>
                                        	<input type="hidden" name="hFechaNac" id="hFechaNac" val='obj' campo='Fecha de nacimiento' extId='f_dteFechaNac' />
		                                    <label>Sexo: <span style="color:#F00">*</span></label>
                                            <div style="color:#000000; font-size:11px" ><input type="radio" id="sexoM" name="sexo"  checked="checked" /> Hombre&nbsp;&nbsp;&nbsp; <input type="radio"  id="sexoF" name="sexo"   /> Mujer</div>
                                        </td>
                                        <td>
                                        	
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>Clave CURP: </label>
		                                    <input type="text" name="txtCURP" id="txtCURP" maxlength="18" size="30" />
                                        </td>
                                        <td>
                                        	<label>Tipo de identificaci&oacute;n:</label>
		                                     <select id="cmbTipoIdentificacion" style="width:180px" onChange="tipoIdentificacionSel(this)" >
                                              <option value="-1">Seleccione</option>
                                            <?php 
											$consulta="SELECT id__32_tablaDinamica,upper(tipoIdentificacion) FROM _32_tablaDinamica WHERE id__32_tablaDinamica NOT IN(19,9999,13,17) ORDER BY tipoIdentificacion";
											$con->generarOpcionesSelect($consulta);
											?>
                                            </select>
                                        </td>
                                        <td>
                                        	 <label>N&uacute;mero de identificaci&oacute;n: <span style="color:#F00" id="lblOblIdentificacion"></span></label>
		                                    <input type="text" maxlength="40"  style="width:160px" disabled="true" id='txtNoIdentificacion' val='obj' campo='Nombre' />
                                        </td>
                                    </tr>
                                    </table><br>
                                    </div>
                                    <table width="100%">
                                    	<tr>
                                        	<td align="right">
                                            	<table>
                                                	<tr>
                                                    	<td>
                                                        <input style="width:80px;line-height: 0px;" type="button" onClick="mostrarTab(2,1)" value="Siguiente >>" class="boton left" />
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </span> 
                                <span id="paso_2" style="display:none" campoFocus="txtCalle">
                                    <h2 class="padbot">Datos de contacto</h2>
                                    <div style="height:350px">
									<table>
                                    <tr>
                                    	<td colspan="2">
                                        	<label>Calle: </label>
		                                    <input type="text" name="txtCalle" id="txtCalle" maxlength="255" style="width:300px" />
                                        </td>
                                        <td>
                                        	<label>No Ext:</label>
		                                    <input type="text" maxlength="100" size="20" id='txtNoExt'  style="width:100px" />
                                        </td>
                                        <td>
                                        	<label>No Int:</label>
		                                    <input type="text" maxlength="100" size="20" id='txtNoInt' style="width:100px"/>
                                        </td>
                                        <td>
                                        	
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="1" width="150">
                                        	<label>Colonia: </label>
		                                    <input type="text" name="txtColonia" id="txtColonia" maxlength="255" style="width:180" />
                                        </td>
                                        <td width="150" colspan="3">
                                        	<label>C.P.:</label>
		                                    <input type="text" maxlength="100" size="20" id='txtCP'  style="width:80px" onKeyPress="return soloNumero(event,false,false,this)"/>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                    	
                                        <td width="150">
                                        	<label>Estado:</label>
		                                    <select id="cmbEstado" onChange="buscarMunicipio(this)">
                                            <?php 
											$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
											$con->generarOpcionesSelect($consulta,9);
											?>
                                            </select>
                                        </td>
                                        <td width="150" colspan="3">
                                        	<label>Municipio/Delegaci&oacute;n:</label>
		                                    <select id="cmbMunicipio">
                                            <option value="-1">Seleccione</option>
                                            <?php 
												$consulta="SELECT cveMunicipio,municipio FROM 821_municipios WHERE cveEstado=9 ORDER BY municipio";
												$con->generarOpcionesSelect($consulta);
											?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="3">
                                        	<label>T&eacute;lefonos de contacto: <span style="color:#F00">*</span></label>
                                        	<span id="gTelefono"></span><br>
                                        </td>
                                    </tr>
                                    
                                    
                                    </table><br>
                                    </div>
                                    <table width="100%">
                                    	<tr>
                                        	<td align="right">
                                            	<table>
                                                	<tr>
                                                    	<td>
                                                        <input style="width:80px;line-height: 0px;" type="button" onClick="mostrarTab(1,-1)" value="<< Anterior" class="boton left" />
                                                        </td>
                                                        <td>
                                                        <input style="width:80px;line-height: 0px;" type="button" onClick="mostrarTab(3,1)" value="Siguiente >>" class="boton left" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </span>    
                                
                                <span id="paso_3" style="display:none" campoFocus="txtProfesion">
                                    <h2 class="padbot">Datos profesionales</h2>
                                    <div style="height:350px">
									<table>
                                    <tr>
                                    	<td colspan="2">
                                        	<label>Profesi&oacute;n: <span style="color:#F00">*</span></label>
		                                    <input type="text" name="txtProfesion" id="txtProfesion" maxlength="40"  style="width:250px" />
                                        </td>
                                        <td>
                                        	<label>N&uacute;mero de c&eacute;dula profesional:</label>
		                                    <input type="text" maxlength="40" style="width:160px" id='txtCedula' onkeypress="return soloNumero(event,false,false,this)" />
                                        </td>
                                       
                                    </tr>
                                    
                                    <tr>
                                    	<td colspan="3">
                                        	<label>Nombre del despacho: </label>
		                                    <input type="text" maxlength="70"  id='txtNombreDespacho' style="width:430px" />
                                        </td>
                                        
                                    </tr>
                                    </table><br>
                                    </div>
                                    <table width="100%">
                                    	<tr>
                                        	<td align="right">
                                            	<table>
                                                	<tr>
                                                    	<td>
                                                        <input style="width:80px;line-height: 0px;" type="button" onClick="mostrarTab(2,-1)" value="<< Anterior" class="boton left" />
                                                        </td>
                                                        <td>
                                                        <input style="width:80px;line-height: 0px;" type="button" onClick="mostrarTab(4,1)" value="Siguiente >>" class="boton left" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </span>     
                                 <span id="paso_4" style="display:none">    
                                    <h2 class="padbot">Normas del sitio</h2>
                                    <div style="height:350px">
                                    <table >
                                    	<tr>
                                        	<td>
                                              
                                              <div style="width:560px; height:300px; overflow:auto">
                                              <br>
                                              <?php
											  	$consulta="SELECT txtPlantillaDocumento FROM _10_tablaDinamica WHERE id__10_tablaDinamica=500";
												$normas=$con->obtenerValor($consulta);
                                                  echo $normas;
                                              ?>
                                              </div><br /><br />
                                              <input type="checkbox" id='chkAcepto' />&nbsp;<span class="corpo8_bold" style="color: #006; font-size: 12px">He leído, y estoy de acuerdo con los t&eacute;rminos y condiciones de sitio</span>
                                          </td>
                                        </tr>
                                    </table><br>
                                    </div>
                                    <table width="100%">
                                    	<tr>
                                        	<td align="right">
                                            	<table>
                                                	<tr>
                                                    	<td>
                                                        <input style="width:80px;line-height: 0px;" type="button" onClick="mostrarTab(3,-1)" value="<< Anterior" class="boton left" />
                                                        </td>
                                                        <td>
                                                        <input style="width:80px;line-height: 0px;" type="button" onClick="crearCuentaUsuario()" value="Crear cuenta" class="boton left"  />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    	
								</span>
                                </div>
                                <div class="clear"></div>
                                <div class="but mar5 floatl">
                                
                                
                                
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

