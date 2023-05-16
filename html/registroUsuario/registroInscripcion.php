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
<script type="text/javascript" src="../planesEstudios/Scripts/funcionesInscripcion.js.php"></script>
<script type="text/javascript" src="../registroUsuario/Scripts/registroInscripcion.js.php"></script>     
</head>
	<body>
    	<?php
								
			/*$parametros=obtenerParametrosBase64($objParametros->param);
			
			$idProceso=$parametros["idProcesoRegistro"];
			$idRegistro=$parametros["idRegistro"];*/
			$idProceso=115;
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
                                <li><a href="javascript:irIngreso()">Ingresar</a></li>
                                <li><a href="#" class="sel">Registro</a></li>
                            </ul>
                        </div>
                        <div id="registro" class="right">
                            <div id="reg_1">
                            <?php
							
								$idCiclo=$objParametros->idCiclo;
								$idPeriodo=$objParametros->idPeriodo;
								$idInstancia=$objParametros->idInstancia;
								
								
								$consulta="SELECT nombreCiclo FROM 4526_ciclosEscolares WHERE idCiclo=".$idCiclo;
								$nombreCiclo=$con->obtenerValor($consulta);
								
								$consulta="SELECT nombrePeriodo FROM _464_gridPeriodos WHERE id__464_gridPeriodos=".$idPeriodo;
								$nombrePeriodo=$con->obtenerValor($consulta);
								
								$duracionPeriodo="";
								$consulta="SELECT fechaInicial,fechaFinal FROM 4544_fechasPeriodo WHERE idCiclo=".$idCiclo." AND idPeriodo=".$idPeriodo." AND idInstanciaPlanEstudio=".$idInstancia;
								$fFechas=$con->obtenerPrimeraFila($consulta);
								if(($fFechas)&&($fFechas[0]!="")&&($fFechas[1]!=""))
									$duracionPeriodo=" (<b>Del</b> ".date("d/m/Y",strtotime($fFechas[0]))." <b>al</b> ".date("d/m/Y",strtotime($fFechas[1])).")";
							
								$consulta="SELECT t.turno,m.nombre,pr.nombreProgramaEducativo FROM 4513_instanciaPlanEstudio i,4514_tipoModalidad m,4516_turnos t, 4500_planEstudio p,4500_programasEducativos pr
										WHERE pr.idProgramaEducativo=p.idProgramaEducativo AND p.idPlanEstudio=i.idPlanEstudio AND i.idTurno=i.idTurno AND m.idModalidad=i.idModalidad AND i.idInstanciaPlanEstudio=".$idInstancia;
								$fPlanEstudio=$con->obtenerPrimeraFila($consulta);
							?>
                            <form action="forms/registro" onSubmit="c.submitForm(this,logI,['usuario','password','password2','email','dia','mes','ano']);return false">
                                
                                <div>
                                    <table>
                                    <tr>
                                    	<td colspan="3">
                                        <h2 class="padbot">Registro de inscripción al Plan de Estudios:</h2>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                    	
                                        <td colspan="3">
                                        	<label><b>Plan de Estudios: </b>&nbsp;&nbsp;<span class="letraRojaSubrayada8" style="color:#900 !important"><?php echo $fPlanEstudio[2]?></span></label>
		                                    
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                    	<td colspan="">
                                        	<label><b>Ciclo: </b>&nbsp;&nbsp;<span class="letraRojaSubrayada8" style="color:#900 !important"><?php echo $nombreCiclo?></span></label>
                                            
                                        </td>
                                        <td colspan="3">
                                        	<label><b>Periodo: </b>&nbsp;&nbsp;<span class="letraRojaSubrayada8" style="color:#900 !important"><?php echo $nombrePeriodo.$duracionPeriodo?></span></label>
		                                    

                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                    	<td colspan="">
                                        	<label><b>Modalidad: </b>&nbsp;&nbsp;<span class="letraRojaSubrayada8" style="color:#900 !important"><?php echo $fPlanEstudio[1]?></span></label>
                                            
                                        </td>
                                        <td colspan="3">
                                        	<label><b>Turno: </b>&nbsp;&nbsp;<span class="letraRojaSubrayada8" style="color:#900 !important"><?php echo $fPlanEstudio[0]?></span></label>
		                                    

                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                    	<td colspan="3"><br>
                                        <h2 class="padbot">Complete los siguientes datos generales</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>Apellido Paterno <span style="color:#F00">*</span></label>
		                                    <input type="text" name="txtApPaterno" id="txtApPaterno" maxlength="40" size="30" />
                                        </td>
                                        <td>
                                        	<label>Apellido Materno</label>
		                                    <input type="text" maxlength="40" size="30" id='txtApMaterno' />
                                        </td>
                                        <td>
                                        	 <label>Nombre: <span style="color:#F00">*</span></label>
		                                    <input type="text" maxlength="40" size="30" id='txtNombre' val='obl' campo='Nombre' />
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>Fecha de nacimiento <span style="color:#F00">*</span></label>
		                                    <span id='dteFechaNac'></span>
                                        </td>
                                    	<td>
                                        	<input type="hidden" name="hFechaNac" id="hFechaNac" val='obl' campo='Fecha de nacimiento' extId='f_dteFechaNac' />
		                                    <label>Sexo</label>
                                            <div style="color:#000000; font-size:11px" ><input type="radio" id="sexoM" name="sexo"  checked="checked" /> Hombre&nbsp;&nbsp;&nbsp; <input type="radio" name="sexo"  id="sexoF"  /> Mujer</div>
                                        </td>
                                    	<td>
                                        	<label>Tel&eacute;fono (Casa)</label>
                                            <input type="text" maxlength="40" size="30" id='txtTelefono' val='obl' campo='Nombre' />
                                            
                                        </td>
                                        
                                        
                                        
                                        
                                    </tr>
                                    <tr>
                                    	<td>
                                        	<label>Tel&eacute;fono (Móvil)</label>
                                            <input type="text" maxlength="40" size="30" id='txtTelefonoMovil' val='obl' campo='Nombre' />
                                            
                                        </td>
                                    	<td>
                                        	<label>E-mail: <span style="color:#F00">*</span></label>
		                                    <input type="text" maxlength="50" size="50" id='txtMail' val='' campo='' />
                                        </td>
                                        <td>
        	                               	<label>Confirme E-mail:</label>
		                                    <input type="text" maxlength="50" size="50" id='txtMail2' val='' campo='' />
                                        </td>
                                        <td>
                                        	
                                        </td>
                                    </tr>
                                    
                                    </table>
                                    

                                    
                                </div>
                                <div class="clear"></div>
                                <div class="but mar5 floatl"> <input style="width:80px" type="button" onClick="agregarAutor()" name="btnAgregarAutor" id="btnAgregarAutor" value="Registrarse" class="boton left" /><div class="clearl"></div></div>
                                
                                <input type="hidden" id="hIdAfiliacion" name="hIdAfiliacion" value="" />
                                <input type="hidden" id="hIdAutor" name="hIdAutor" value="" />
                                <input type="hidden" id="singular" value="<?php echo $singular?>" />
                                <input type="hidden" id="plural" value="<?php echo $plural?>" />
                                <input type="hidden" id="idProceso" value="<?php echo $idProceso?>" />
                                 <input type="hidden" id="idRegistro" value="<?php echo $idRegistro?>" />
                                 <input type="hidden" id="solAfiliacion" value="<?php echo $solAfiliacion?>" />
                                 <input type="hidden" id="codInstitucionConv" value="<?php echo $codInstitucionConv?>" />
                                 <br><br><br><br><br><br><br><br><br><br><br><br>
                            </form>
                            
                                <input type="hidden" id="idCiclo" value="<?php echo $idCiclo?>">
                                <input type="hidden" id="idPeriodo" value="<?php echo $idPeriodo?>">
                                <input type="hidden" id="idInstancia" value="<?php echo $idInstancia?>">
                                  <form method="post"	action="" id='frmEnvioDatos'>
                               
	                            </form>
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

