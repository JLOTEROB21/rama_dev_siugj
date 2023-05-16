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
<link rel="stylesheet" type="text/css" href="../estilos/coma.css"/>
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
<!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
<!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->

<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>

<style>
	input
	{
		padding:3px !important;
	}
	body
	{
		background-color:#FFF;
		background-image:none;
		color:#000;
	}
	
	label
	{
		color:#006;
		
	}
	
	
	
	
	.container
	{
		border-right: 0px !important;
	}
	
	.boton
	{
		<?php
			$unico[4]="BEBF19";
		?>
		background-color:#<?php echo $unico[4]?> !important;
		background-image: -moz-linear-gradient(#<?php echo $unico[4]?>,#<?php echo $unico[4]?>)  !important;;
		background-image: -webkit-gradient(linear,0% 0,0% 100%,from(#<?php echo $unico[4]?>),to(#<?php echo $unico[4]?>))  !important;;
		background-image: -webkit-linear-gradient(#<?php echo $unico[4]?>,#<?php echo $unico[4]?>  !important;);
		background-image: -o-linear-gradient(#<?php echo $unico[4]?>,#<?php echo $unico[4]?>)  !important;
		border-style:none;
		
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
	
	h2
	{
		font-size:14px;
		font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
		font:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
		font-weight:bold;
	}
	
	td
	{
		padding:1px
	}
	
	
</style>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>   
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../modulosEspeciales_Galileo/Scripts/funcionesInscripcionProyecto.js.php"></script>   
<script type="text/javascript" src="../registroUsuario/Scripts/registroInscripcionProyectoEst.js.php"></script>     
</head>
	<body style="background-color:#FFF !important">
    	<table width="100%">
        <tr>
        	<td align="center">
            
            <table style=" border:hidden; ">
            <tbody>
                <tr>
                    <td width="190" style=" border:hidden;">
                        <img src="../principalGalileo/archivos/logoestudiantes.png" alt="">
                    </td>
                    
                    
                </tr>
            </tbody>
            </table>
            <table>
            <tr>
            	<td align="left">
    	<?php
								
			$idProceso=61;
			$idProyecto=-1;
			if(isset($_POST["idProyecto"]))
				$idProyecto=$_POST["idProyecto"];
			else
				if(isset($_GET["idProyecto"]))
					$idProyecto=$_GET["idProyecto"];
			$consulta="SELECT cveEstado,estado FROM `820_estadosV2` ORDER BY estado";
			$arrEstado=$con->obtenerFilasArreglo($consulta);
			$consulta="SELECT  paginaRedireccion FROM _415_tablaDinamica WHERE id__415_tablaDinamica in (".$idProyecto.") limit 0,1";
			$pagRedireccion=$con->obtenerValor($consulta);
		?><br><br>
    	
                            <?php
								$consulta="SELECT p.tituloProyecto,t.descripcion FROM `_402_tablaDinamica` p,`_401_tablaDinamica` t WHERE id__402_tablaDinamica=t.cmbProyectoBase AND t.id__401_tablaDinamica in(".$idProyecto.")";
								$fProyecto=$con->obtenerPrimeraFila($consulta);
								$consulta="SELECT distinct nombreProyecto from `_401_tablaDinamica` t WHERE  t.id__401_tablaDinamica in(".$idProyecto.") order by nombreProyecto";
								$nomCursos=$con->obtenerListaValores($consulta,"<br>");
				
							?>
                            <form action="forms/registro" onSubmit="c.submitForm(this,logI,['usuario','password','password2','email','dia','mes','ano']);return false">
                                

                                    <table>
                                 	<tr height="21">
                                    	<td valign="top" colspan="3">
                                        	<h2 class="padbot">Curso al que inscribe:</h2>
                                        </td>
                                        
                                    </tr>
                                    <tr height="21">
                                    	<td valign="top" colspan="3" align="center">
                                        	<h2 class="padbot" style="color:#900"><?php echo $nomCursos?></h2>
                                        </td>
                                        
                                    </tr>
				<tr>
                                    	<td colspan="3" align="right">
						<table>
						<tr>
							<td>
                                        			<img src="../images/icon-question.gif">
							</td>
							<td>
		                                            <label style="font-size:11px; font-weight:bold">¿Tiene alguna duda? Rep&oacute;rtela <a href="javascript:mostrarVentanaDudaProyecto()"> <span style="color:#F00;font-size:11px" >AQU&Iacute;</span></a></label>
							</td>
						</tr>
						<table><br>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="3" align="right">
                                        	<table>
                                            	<tr>
                                                	<td width="300">
                                                    	<label>N&uacute;mero de grupos que participar&aacute;n en el curso<span style="color:#F00">*</span></label>
                                                    </td>
                                                    <td>
                                                    	<input type="text" name="noGrupos" id="noGrupos" maxlength="40" size="10" style="width:80px" val='obl' campo='N&uacute;mero de grupos que participar&aacute;n en el curso' onKeyPress="return soloNumero(event,false,false,this)"/>
                                                    </td>
                                                </tr>
                                            </table>
                                        	
		                                    
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                    	<td colspan="3"><br>
                                        <h2 class="padbot">Datos del profesor responsable de los grupos</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>Apellido Paterno <span style="color:#F00">*</span></label>
		                                    <input type="text" name="txtApPaterno" id="txtApPaterno" maxlength="40" size="30" val='obl' campo='Apellido Paterno'/>
                                        </td>
                                        <td>
                                        	<label>Apellido Materno</label>
		                                    <input type="text" maxlength="40" size="30" id='txtApMaterno' />
                                        </td>
                                        <td>
                                        	 <label>Nombre <span style="color:#F00">*</span></label>
		                                    <input type="text" maxlength="40" size="30" id='txtNombre' val='obl' campo='Nombre' />
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>Género</label>
                                            <div style="color:#000000; font-size:11px" ><input type="radio" id="sexoM" name="sexo"  checked="checked" /> Masculino&nbsp;&nbsp;&nbsp; <input type="radio" name="sexo"  id="sexoF"  /> Femenino</div>
                                        </td>
                                    	<td>
                                        	<label>Tel&eacute;fono (Casa)</label>
                                            <input type="text" maxlength="40" size="30" id='txtTelefono' onKeyPress="return soloNumero(event,false,false,this)"/>
                                            
                                        </td>
                                        <td>
                                        	<label>Tel&eacute;fono (Móvil)</label>
                                            <input type="text" maxlength="40" size="30" id='txtTelefonoMovil' onKeyPress="return soloNumero(event,false,false,this)"/>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                    	
                                    	<td>
                                        	<label>E-mail: <span style="color:#F00">*</span></label>
		                                    <input type="text" maxlength="50" size="30" id='txtMail' val='' campo='' />
                                        </td>
                                        <td>
        	                               	<label>Confirme E-mail:</label>
		                                    <input type="text" maxlength="50" size="30" id='txtMail2' val='' campo='' />
                                        </td>
                                        <td>
                                        	
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="3"><br>
                                        <h2 class="padbot">Datos del plantel</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="3" align="right">
                                        	<label style="font-size:11px; font-weight:bold">Si conoce la Clave del Centro de Trabajo(CCT) de su plantel, d&eacute; click <a href="javascript:buscarPorCCT()">
                                            <span style="color:#F00;font-size:11px" >AQU&Iacute;</span></a></label>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>Estado<span style="color:#F00">*</span></label>
                                            <div id="dEstado"></div>
		                                    
                                        </td>
                                        <td>
                                        	<label>Municipio<span style="color:#F00">*</span></label>
			                                <div id="dMunicipio"></div>
                                        </td>
                                        <td>
                                        	<label>Localidad<span style="color:#F00">*</span></label>
		                                    <div id="dLocalidad"></div>	
                                        </td>
                                    </tr>
                                    <tr>
                                    	
                                        <td colspan="2">
                                        	<label>Plantel<span style="color:#F00">*</span></label>
		                                    <div id="dPlantel"></div>	
                                        </td>
                                        <td>
                                        	 <label>Turno<span style="color:#F00">*</span></label>
		                                    <div id="dTurno"></div>	
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="3" align="left">
                                        	<label style="font-size:11px; font-weight:bold">¿Su plantel NO se encuentra en la plataforma?, reg&iacute;strela <a href="javascript:registrarPlantel()">
                                            <span style="color:#F00;font-size:11px" >AQU&Iacute;</span></a></label>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="3"><br>
                                        <h2 class="padbot">Datos del director del plantel</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>Apellido Paterno <span style="color:#F00">*</span></label>
		                                    <input type="text" name="txtApPaternoD" id="txtApPaternoD" maxlength="40" size="30" val='obl' campo='Apellido paterno del director'/>
                                        </td>
                                        <td>
                                        	<label>Apellido Materno</label>
		                                    <input type="text" maxlength="40" size="30" id='txtApMaternoD' />
                                        </td>
                                        <td>
                                        	 <label>Nombre <span style="color:#F00">*</span></label>
		                                    <input type="text" maxlength="40" size="30" id='txtNombreD' val='obl' campo='Nombre del director' />
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>Tel&eacute;fono del plantel <span style="color:#F00">*</span></label>
                                            <input type="text" maxlength="40" size="30" id='txtTelefonoMovilD' val='obl' campo='Tel&eacute;fono de contacto del director' onKeyPress="return soloNumero(event,false,false,this)"/>
                                            
                                        </td>
                                        <td>
                                        	<label>E-mail de contacto: </label>
		                                    <input type="text" maxlength="50" size="30" id='txtMailD' val='' campo='' />
                                        </td>
                                        <td>
        	                               	<label>Confirme E-mail:</label>
		                                    <input type="text" maxlength="50" size="30" id='txtMailD2' val='' campo='' />
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td colspan="3"><br>
                                        <span style="font-size:10px">Los campos marcados con asterisco(<span style="color:#F00">*</span>) son obligatorios</span>
                                        </td>
                                    </tr>
					<tr>
                                    	<td colspan="3" align="right">
						<table>
						<tr>
							<td>
                                        			<img src="../images/icon-question.gif">
							</td>
							<td>
		                                            <label style="font-size:11px; font-weight:bold">¿Tiene alguna duda? Rep&oacute;rtela <a href="javascript:mostrarVentanaDudaProyecto()"> <span style="color:#F00;font-size:11px" >AQU&Iacute;</span></a></label>
							</td>
						</tr>
						<table>
                                        </td>
                                    </tr>
                                    </table><br>
                                    <input type="hidden"  id="idProyecto" value="<?php echo $idProyecto?>">

                                    
                                 <input style="width:80px" type="button" onClick="agregarAutor()" name="btnAgregarAutor" id="btnAgregarAutor" value="Registrarse" class="boton left" /><div class="clearl"></div></div>
                                
                                
                                <input type="hidden" id="idProceso" value="<?php echo $idProceso?>" />
                                 <input type="hidden" id="tipoInscripcion" value="2" />
                                <input type="hidden" id="arrEstado" value="<?php echo bE($arrEstado)?>" />
                                <input type="hidden" id="pagRedireccion" value="<?php echo $pagRedireccion?>">
                                <br><br>
                            </form>
                            
                              
                                  <form method="post"	action="" id='frmEnvioDatos'>
                               
	                            </form>
                            
        	</td>
            </tr>
            </table>  
        </td>
        </tr>
        </table>                  
	</body>
</html>      

