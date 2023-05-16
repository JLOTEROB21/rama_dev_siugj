<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");
	
$idFormulario=-1;
if(isset($_POST["idFormulario"]))
	$idFormulario=$_POST["idFormulario"];
else
	if(isset($_GET["idFormulario"]))
		$idFormulario=$_POST["idFormulario"];
$consulta="select idProceso from 900_formularios  where idFormulario=".$idFormulario;
$idProceso=$con->obtenerValor($consulta);
$consulta="SELECT * FROM 9057_configuracionSeccionesProceso WHERE idProceso=".$idProceso;
$resSecc=$con->obtenerFilas($consulta);
while($fSecc=mysql_fetch_row($resSecc))
{
	if($fSecc[5]!="")
		include_once($fSecc[5]); 
}
	
$excluirExt=true;
$arrConfiguraciones="";

function generarTablaModulos()
{
	global $arrConfiguraciones;
  	global $con;
  	global $accion;
  	global $objParametros;
  	global $actor;
	global $lblComiteS;
  	global $lblComiteP;

  $idFormulario=$objParametros->idFormulario;
  $idRegistro=$objParametros->idRegistro;
  
 /* if($_SESSION["idUsr"]!=1673)
  {
	  if(($idFormulario==464)&&(($idRegistro==84)||($idRegistro==46)||($idRegistro==44)||($idRegistro==63)))
	  {
		  $idFormulario="";
	  }
  }*/
  $consulta="select nombreFormulario,nombreTabla,idProceso,campoDescriptivo from 900_formularios  where idFormulario=".$idFormulario;
  $filaFrm=$con->obtenerPrimeraFila($consulta);
  $campoDescriptivo=$filaFrm[3];
  $nFormulario=$filaFrm[0];
  $nTabla=$filaFrm[1];
  $idProceso=$filaFrm[2];
  $enlace="javascript:f.enviarFichaProyecto(".$idFormulario.",\"".base64_encode("ver")."\")";
  $imgFicha="../images/bullet_green.png";
  $tblRegistro="";
  $ocultarMenuDTD="";
  $consulta="select idEstado,responsable from ".$nTabla." where id_".$nTabla."=".$idRegistro;
  $filaReg=$con->obtenerPrimeraFila($consulta);
  $etapaReg=$filaReg[0];
  $respRegistro=$filaReg[1];
	$idParticipante="-1"; 
	
	
	$consulta="SELECT idPerfil FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$actor;
	$idPerfil=$con->obtenerValor($consulta);
	if($idPerfil=="")
		$idPerfil="-1";
	else
	{
		$consulta="SELECT situacion FROM 206_perfilesEscenarios WHERE idPerfil=".$idPerfil;
		$situacionPerfil=$con->obtenerValor($consulta);	
		if($situacionPerfil!=1)
			$idPerfil="-1";
	}
	

  if($actor!=0)
  {
		if($objParametros->participante==0)
	 	{
			$consulta="select aa.idGrupoAccion,aa.complementario,aa.complementario2,aa.complementario3 from 944_actoresProcesoEtapa ap,
					947_actoresProcesosEtapasVSAcciones aa where 
				  	aa.idActorProcesoEtapa=ap.idActorProcesoEtapa and ap.numEtapa=".$etapaReg." and ap.idProceso=".$idProceso." 
					and ap.idActorProcesoEtapa=".$actor;
			if($idPerfil!=-1)
				$consulta.=" and idPerfil=".$idPerfil;
			else
				$consulta.=" and idPerfil is null";
		}
		else
		{
			$consulta="SELECT idProyectoVSParticipanteVSEtapa FROM 995_proyectosVSParticipantesVSEtapas
						WHERE idProyecto=".$idProceso." AND idParticipante=".$actor." AND numEtapa=".$etapaReg;

			$idParticipante=$con->obtenerValor($consulta);
			$consulta="SELECT idGrupoAccion,'' AS complementario,'' as complementario2,'' as complementario3 FROM 997_accionesParticipanteVSProcesoVSEtapa WHERE idProyectoParticipante=".$idParticipante;

		}
		$resAcciones=$con->obtenerFilas($consulta);
		$arrAcciones=array();
		while($filaAcciones=mysql_fetch_row($resAcciones))
		{
			$arrAcciones[$filaAcciones[0]][0]="".$filaAcciones[1];
			$arrAcciones[$filaAcciones[0]][1]="".$filaAcciones[2];
			$arrAcciones[$filaAcciones[0]][2]="".$filaAcciones[3];
		}
  }

	
	//echo $consulta;
	
  $someteRevision=false;
  $modificaElementos=false;
  if($actor==-255)
  	$modificaElementos=true;
  $asignaRevisores=false;
  $realizaDictamenF=false;
  $realizaDictamenP=false;
  $marcarElementos=false;
  $asignaComites=false;
  $obtieneUsuarioPerfil=false;
  $seleccionaUsrPerfil=false;
  $contrataPersonal=false;
  $elijeCanditatoPuesto=false;

  	if(isset($arrAcciones["1"][0]))
	  	$someteRevision=true;
  	if(isset($arrAcciones["2"][0]))
	  	$modificaElementos=true;
  	if(isset($arrAcciones["3"][0]))
	  	$asignaRevisores=true;
  	if(isset($arrAcciones["4"][0]))
	  	$realizaDictamenP=true;
  	if(isset($arrAcciones["5"][0]))
	  	$realizaDictamenF=true;
  	if(isset($arrAcciones["6"][0]))
	  	$marcarElementos=true;
	if(isset($arrAcciones["12"][0]))
		$asignaComites=true;
	if(isset($arrAcciones["16"][0]))
		$obtieneUsuarioPerfil=true;
		
	if(isset($arrAcciones["17"][0]))
		$seleccionaUsrPerfil=true;
	if(isset($arrAcciones["18"][0]))
		$contrataPersonal=true;
	if(isset($arrAcciones["19"][0]))
		$elijeCanditatoPuesto=true;								
  
  $consulta="select estado from 963_estadosElementoDTD where idFormulario=".$idFormulario." and idReferencia=".$idRegistro;

  $estado=$con->obtenerValor($consulta);
  
  if($estado=="1")
  {
	  $btnBloqueado="&nbsp;<img src='../images/lock.png' alt='Elemento bloqueado, no puede ser editado' title='Elemento bloqueado, no puede ser editado'>";
	  $elemBloqueado=true;
  }
  else
  {
	  $elemBloqueado=false;
	  $btnBloqueado="";
  }
  
  
  $btnBloqueoElem="";
  if($marcarElementos)
  {
	  if($elemBloqueado)
		  $btnBloqueoElem="&nbsp;<a href='javascript:f.quitarBloqueo(\"".base64_encode($idFormulario)."\",\"".base64_encode($idRegistro)."\")'><img src='../images/lock_delete.png' title='Quitar bloqueo de edici&oacute;n' alt='Quitar bloqueo de edici&oacute;n'></a>";
	  else
		  $btnBloqueoElem="&nbsp;<a href='javascript:f.bloquearElemento(\"".base64_encode($idFormulario)."\",\"".base64_encode($idRegistro)."\")'><img src='../images/lock_add.png' title='Bloquear elemento para evitar edici&oacute;n' alt='Bloquear elemento para evitar edici&oacuten'></a>";
  }
  $btnModificar="";
  

  $aplicarExcepcion=false;
  if($objParametros->participante==1)
  {
	  $consulta="SELECT pe.funciones FROM 996_proyectosParticipantesElementosDTD pe WHERE  
					   pe.idProyectoParticipante=".$idParticipante." and idElemento=-".$idFormulario;
	  $funcion=$con->obtenerValor($consulta);
	  
	  if($funcion=="1")
		  $aplicarExcepcion=true;
  }
  //Eliminar
  

  if((($modificaElementos)||($aplicarExcepcion))&&!$elemBloqueado)
  {
	  $accionM=base64_encode("modificar");
	  $btnModificar="<a href='javascript:f.enviarFichaProyecto(".$idFormulario.",\"".$accionM."\")'>[<img width='9' height='9' src='../images/pencil.png' title ='Modificar' alt='Modificar'> <span style='font-size: 9px; color:#F00 '>Editar</span>]</a>";
  }
  
	$idProceso=obtenerIdProcesoFormulario($idFormulario);
	$consulta="select max(version) from 9036_respaldosProceso where idProceso=".$idProceso." and idRegistro=".$idRegistro;
	
	$mVersion=$con->obtenerValor($consulta);
	if($mVersion=="")
		$mVersion=0;
	else
		$mVersion++;
	
  $consulta="SELECT COUNT(*) FROM 2002_comentariosRegistro WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." and comentario<>''";
  $nComentarios=$con->obtenerValor($consulta);

?>
  
  
  <table <?php echo $ocultarMenuDTD?> id="tblDTD" width="230">
  <?php
  	if($idRegistro!="-1")
	{
  ?>
  	<tr height='2'>
          <td colspan='3' align='left'>
         <!-- <i><b>Datos de registro:</b></i>-->
          </td>
      </tr>
      <tr height='2'>
          <td colspan='3' style='background-color:#990000'>
      
          </td>
     </tr>
      <tr height='10'>
          <td colspan='3' >
              
          </td>
      </tr>
    
     
      
    	<tr>
          <td colspan='3'>
          		<table width="90%">
                <?php 
				if($idFormulario==278)
				{
				
				?>
                <tr>
                  <td align="left" valign="top"  colspan="2">
                  <a href="javascript:obtenerVersionHTML()"><img src="../images/report_disk.png" title="Ver proyecto completo" alt="Ver proyecto completo"/></a>&nbsp;&nbsp;<a href="javascript:obtenerVersionHTML()"><span class="letraRojaSubrayada8">Ver proyecto completo</span></a><br /><br />
                  
                  </td>
                 
              </tr>
              <?php
				}
			  ?>
                <tr>
                	<td align="left" colspan="2" >
                    <?php
					  if($nComentarios>0)
					  {
						  echo '(<a href="javascript:mostrarGridComentarios()"><span class="letraRojaSubrayada8">'.$nComentarios.' comentarios</span></a>)&nbsp;<a href="javascript:mostrarGridComentarios()"><span class="letraExt">Ver comentarios</span></a>&nbsp;<a href="javascript:mostrarGridComentarios()"><img src="../images/icon_comment.gif"></a><br><br>';
					  }
					  ?>
                    </td>
                    
                </tr>
                  
                </table> 
                
          </td>
     </tr>
    <?php
		
	}

	//if($actor!=0)
	{
		$consulta="SELECT * FROM 9057_configuracionSeccionesProceso WHERE idProceso=".$idProceso;
		if($idPerfil!="-1")
		{
			$consulta.=" and idPerfil=".$idPerfil;
		}
		else
			$consulta.=" and idPerfil is null";

		

		$resSecc=$con->obtenerFilas($consulta);
		while($fSecc=mysql_fetch_row($resSecc))
		{
			$lblEtiqueta=$fSecc[1];

			if($fSecc[6]!="")
			{
				/*$cadObj='{"idFormulario":"'.$idFormulario.'","idReferencia":"'.$idRegistro.'","actor":"'.$actor.'"}';
				$obj=json_decode($cadObj);
				$lblEtiqueta=trimComillas(resolverExpresionCalculoPHP($fSecc[6],$obj));	*/
				
				eval ('$lblEtiqueta='.$fSecc[6].'($idFormulario,$idRegistro,$actor,$fSecc[1]);');
			}
			
			$mostrarOpcion=false;
			$arrEtapas=explode(",",$fSecc[8]);
			if($lblEtiqueta!="")
			{
				if(($fSecc[8]=="")||(existeValor($arrEtapas,$etapaReg)))
				{
					$mostrarOpcion=true;
				}
			}
			if($mostrarOpcion)
			{
				echo 	"<tr height='25'>
							<td colspan='3' align='left'>
							<table>
								<tr>
								<td width=\"20\">
								<img src='../images/bg_list.gif'>
								</td>
								<td width=\"200\">
									<a title='".$fSecc[1]."' href='javascript:".$fSecc[3]."'><span id='seccion_".$fSecc[0]."' class='letraExt' style='color:#000'>".$lblEtiqueta."</span></a>
								</td>
								</tr>
							</table>				
							</td>
						</tr>";
			}
		}		
	}
	  ?>
   <tr height='15'>
          <td colspan='3' align='left'>
          </td>
    </tr>
	<tr height='25'>
          <td colspan='3' align='left'><i><b>
              Secciones</i></b>
          </td>
      </tr>
      <tr height='2'>
          <td colspan='3' style='background-color:#990000'>
              <!--<a href="javascript:regresar1Pagina()" style="color:#FFF"><b>Probar</b></a>-->
          </td>
     </tr>
      <tr height='10'>
          <td colspan='3' >
              
          </td>
      </tr>

  <tr height="25">
  <td width="18"><img src='<?php echo $imgFicha ?>' alt=''></td><td width='1'></td><td align="left" class='letraFicha' id="td_1"><a href='<?php echo $enlace ?>'><?php echo $nFormulario?></a>&nbsp;<?php echo $btnModificar.$btnBloqueado.$btnBloqueoElem?></td>
  </tr>
  
<?php
  
	$constante=1;
	if($actor<0)
		$constante=-1;
		
	if($actor!=0)
	{
		if($objParametros->participante==0)
		{
			$consulta="select tipoActor,actor from 944_actoresProcesoEtapa where idActorProcesoEtapa=".$actor*$constante;
			$filaActor=$con->obtenerPrimeraFila($consulta);
			
			$tipoActor=$filaActor[0];
			$act=$filaActor[1];
		}
		else
		{
			$tipoActor=1;
			$act=$actor;
		}
	}
	else
	{
		$tipoActor="1";
		$act=0;
	}
	
	$idComite="-1";
	$mostrarAgendaComite=false;
	$arrAccionesParticipante=array();
	if($tipoActor==1)
	{

		if($objParametros->participante==0)
		{
			if($idPerfil!=-1)
			{
				$consulta="select e.idFormulario,nombreFormulario,titulo,e.tipoElemento,nombreTabla,e.obligatorio,e.idElementoDTD,e.funcionExclusion,e.idFuncionVisualizacion,e.idFuncionEdicion from 
							203_elementosDTD e,900_formularios f where e.idFormulario=f.idFormulario and 
							e.idProceso=".$idProceso." and e.noEtapa<=".$etapaReg."  and e.idPerfil=".$idPerfil."
							order by orden";	
							
				
			}
			else
			{
				$consulta="select e.idFormulario,nombreFormulario,titulo,e.tipoElemento,nombreTabla,e.obligatorio,e.idElementoDTD,e.funcionExclusion,e.idFuncionVisualizacion,e.idFuncionEdicion from 
							203_elementosDTD e,900_formularios f where e.idFormulario=f.idFormulario and 
							e.idProceso=".$idProceso." and f.idEtapa<=".$etapaReg." and e.idPerfil is null
							order by orden";
			}
			
			
		}
		else
		{
			$consulta="SELECT e.idFormulario,pe.funciones FROM 996_proyectosParticipantesElementosDTD pe,203_elementosDTD e WHERE  
						e.idElementoDTD=pe.idElemento AND pe.idProyectoParticipante=".$idParticipante." and e.idPerfil is null";

			$resElemento=$con->obtenerFilas($consulta);
			$arrFrm="";
			while($filaElemento=mysql_fetch_row($resElemento))
			{
				if($arrFrm=="")
					$arrFrm=$filaElemento[0];
				else
					$arrFrm.=",".$filaElemento[0];
				$arrAccionesParticipante[$filaElemento[0]]=$filaElemento[1];
			}
			if($arrFrm=="")
			{
				$arrFrm=-1;
			}
			$consulta="select e.idFormulario,nombreFormulario,titulo,e.tipoElemento,nombreTabla,e.obligatorio,e.idElementoDTD,e.funcionExclusion,e.idFuncionVisualizacion,e.idFuncionEdicion from 
				203_elementosDTD e,900_formularios f where e.idFormulario=f.idFormulario and 
				e.idProceso=".$idProceso." and f.idEtapa<=".$etapaReg." and e.idFormulario in(-1,".$arrFrm.")
				and e.idPerfil is null 	order by orden";


		}
	}
	else
	{
		$mostrarAgendaComite=true;
		$consulta="select idComite from 234_proyectosVSComitesVSEtapas where idProyectoVSComiteVSEtapa=".$act;
		$idComite=$con->obtenerValor($consulta);
		if($idPerfil!=-1)
		{
			$consulta="select idFormulario from 203_elementosDTD dtd where dtd.idPerfil=".$idPerfil;
		}
		else
		{
			$consulta="select idFormulario from 245_proyectosComitesElementosDTD eD,203_elementosDTD dtd where 
						dtd.idElementoDTD=eD.idElemento and  eD.idProyectoComite=".$act." and dtd.idPerfil is null";
		}			
					
					
		$arrFrm=$con->obtenerListaValores($consulta);		
		if($arrFrm=="")
			$arrFrm="-1";
			
		if($idPerfil!=-1)
		{
			$consulta="select e.idFormulario,nombreFormulario,titulo,e.tipoElemento,nombreTabla,e.obligatorio,e.idElementoDTD,e.funcionExclusion,e.idFuncionVisualizacion,e.idFuncionEdicion from 
						203_elementosDTD e,900_formularios f where e.idFormulario=f.idFormulario and 
						e.idProceso=".$idProceso." and e.noEtapa<=".$etapaReg." and e.idFormulario in(".$arrFrm.") and e.idPerfil=".$idPerfil." order by orden";

		}
		else
		{
			$consulta="select e.idFormulario,nombreFormulario,titulo,e.tipoElemento,nombreTabla,e.obligatorio,e.idElementoDTD,e.funcionExclusion,e.idFuncionVisualizacion,e.idFuncionEdicion from 
				203_elementosDTD e,900_formularios f where e.idFormulario=f.idFormulario and 
				e.idProceso=".$idProceso." and f.idEtapa<=".$etapaReg." and e.idFormulario in(".$arrFrm.") and e.idPerfil is null order by orden";

		}
		
	}

	$res=$con->obtenerFilas($consulta);
	
	$ct=1;
	$arrConfiguraciones="var arrParamConfiguraciones=new Array();";
	$ctParamFunciones=0;
	$arrValoresReemplazo[0][0]="@formulario";
	$arrValoresReemplazo[0][1]=$idFormulario;
	$arrValoresReemplazo[1][0]="@registro";
	$arrValoresReemplazo[1][1]=$idRegistro;
	$enlace="";
	$ctTD=2;
	$oblRestantes=0;
	$tabla="";
	$estado="";

	while($f=mysql_fetch_row($res))
	{
		$idFrm=$f[0];
		if($f[7]=="1")
		{
			
			if(excluirFormulario($idProceso,$f[0],$idRegistro,$actor))
				continue;
		}
		
		
		if(($f[8]!="0")&&($f[8]!="")&&($f[8]!="-1"))
		{
			$cacheCalculo=null;
			$cadObj='{"numEtapa":"'.$etapaReg.'","idFormularioEvaluacion":"'.$idFrm.'","idFormulario":"'.$idFormulario.'","idReferencia":"'.$idRegistro.'","actor":"'.$actor.'"}';
			$obj=json_decode($cadObj);
			$resultado=resolverExpresionCalculoPHP($f[8],$obj,$cacheCalculo);
			if(($resultado=="0")||($resultado=="'0'")||($resultado===false))
			{
				continue;
			}
		}
		
		$btnModificar="";
		
		if($f[5]=="1")
			$asterisco="<font color='red'>*</font>";
		else
			$asterisco="";
		$aplicarExcepcion=false;
		
		if($objParametros->participante==1)
		{
			
			
			if($arrAccionesParticipante[$f[0]]==1)
				$aplicarExcepcion=true;
		}
		
		
		if($actor==-255)
			$modificaElementos=true;
			
		if((!$aplicarExcepcion)&&($f[9]!="0")&&($f[9]!="")&&($f[9]!="-1"))
		{

			$cacheCalculo=null;

			$cadObj='{"numEtapa":"'.$etapaReg.'","idFormularioEvaluacion":"'.$idFrm.'","idFormulario":"'.$idFormulario.'","idReferencia":"'.$idRegistro.'","actor":"'.$actor.'"}';
			$obj=json_decode($cadObj);
			$resultado=resolverExpresionCalculoPHP($f[9],$obj,$cacheCalculo);
			if(gettype($resultado)=='string')
				$resultado=removerComillasLimite($resultado);

			if(($resultado=="1")||($resultado===true))
			{
					
				$aplicarExcepcion=true;
				
			}
		}	
			
			
		if(($modificaElementos)||($aplicarExcepcion))
				$accion=base64_encode("agregar");
			else
				$accion=base64_encode("ver");

		$consulta="select estado from 963_estadosElementoDTD where idFormulario=".$idFrm." and idReferencia=".$idRegistro;
		
		$estado=$con->obtenerValor($consulta);
		
		if($estado=="1")
		{
			$btnBloqueado="&nbsp;<img src='../images/lock.png' alt='Elemento bloqueado, no puede ser editado' title='Elemento bloqueado, no puede ser editado'>";
			$elemBloqueado=true;
		}
		else
		{
			$elemBloqueado=false;
			$btnBloqueado="";
		}
		
		$btnBloqueoElem="";
		if($marcarElementos)
		{
			if($elemBloqueado)
				$btnBloqueoElem="&nbsp;<a href='javascript:f.quitarBloqueo(\"".base64_encode($idFrm)."\",\"".base64_encode($idRegistro)."\")'><img src='../images/lock_delete.png' title='Quitar bloqueo de edici&oacute;n' alt='Quitar bloqueo de edici&oacute;n'></a>";
			else
				$btnBloqueoElem="&nbsp;<a href='javascript:f.bloquearElemento(\"".base64_encode($idFrm)."\",\"".base64_encode($idRegistro)."\")'><img src='../images/lock_add.png' title='Bloquear elemento para evitar edici&oacute;n' alt='Bloquear elemento para evitar edici&oacuten'></a>";
		}

		switch($f[3])
		{
			case 0:
				$nTabla="select id_".$f[4]." from ".$f[4]." where idReferencia=".$idRegistro;
				
				$fila=$con->obtenerPrimeraFila($nTabla);
				
				if(($fila)||((!$modificaElementos)&&(!$aplicarExcepcion)))
				{
					
					$accion=base64_encode("ver");
					$enlace="javascript:f.enviarAsociado(".$f[0].",".$ctTD.",\"".$accion."\")";
					if($fila)
						$img="<a href='".$enlace."'><img src='../images/bullet_green.png' alt=''></a>";
					else
						$img="<a href='".$enlace."'><img src='../images/bullet_red.png' alt=''></a>";
				}
				else
				{
					
					$accion=base64_encode("agregar");
					if($f[5]=="1")
						$oblRestantes++;
					$enlace="javascript:f.enviarAsociado(".$f[0].",".$ctTD.",\"".$accion."\")";
					$img="<a href='".$enlace."'><img src='../images/bullet_red.png' alt=''></a>";
				}
				
				if((($modificaElementos)||($aplicarExcepcion))&&($fila)&&(!$elemBloqueado))
				{
					$accionM=base64_encode("modificar");
					$btnModificar="<a href='javascript:f.enviarAsociado(".$f[0].",".$ctTD.",\"".$accionM."\")'>[<img width='9' height='9' src='../images/pencil.png' title ='Modificar' alt='Modificar'> <span style='font-size: 9px; color:#F00;'>Editar</span>]</a>";
				}
			break;
			case 1:
				$nTablaModulo=$f[4];
				$consulta="select modulo,paginaAsociada,paginaVistaAsociada from 200_modulosPredefinidosProcesos where idGrupoModulo=".$f[2]." and idIdioma=".$_SESSION["leng"];
				
				
				$filaR=$con->obtenerPrimeraFila($consulta);		
				$arrConfiguraciones.="arrParamConfiguraciones[".$ctParamFunciones."]=new Array();";
				$arrConfiguraciones.="arrParamConfiguraciones[".$ctParamFunciones."][0]='".$filaR[1]."';";
				$arrConfiguraciones.="arrParamConfiguraciones[".$ctParamFunciones."][2]='".$filaR[2]."';";
				$consulta="select nombreParametro,valorParametro from 242_parametrosEnlaces where idEnlace=".$f[2]." and tipoEnlace=0";
				$resParam=$con->obtenerFilas($consulta);
				$obj="";
				$arrObj="";
				while($filaParam=mysql_fetch_row($resParam))
				{
					$obj=$filaParam[0].":'".$filaParam[1]."'";
					if($arrObj=="")
						$arrObj=$obj;
					else
						$arrObj.=','.$obj;
					
				}
				$numParam=sizeof($arrValoresReemplazo);
				for($pos=0;$pos<$numParam;$pos++)
				{
					$arrObj=str_replace($arrValoresReemplazo[$pos][0],$arrValoresReemplazo[$pos][1],$arrObj);	
				}
				$arrConfiguraciones.="arrParamConfiguraciones[".$ctParamFunciones."][1]={".$arrObj."};";
				$fila=null;
				if($nTablaModulo!="")
				{
					$nTablaFrm="select idFormulario from ".$nTablaModulo." where idReferencia=".$idRegistro." and idFormulario=".$idFormulario;
	//				echo $nTablaFrm."<br>";
					
					$fila=$con->obtenerPrimeraFila($nTablaFrm);
				}
				else
					$fila=true;
				$btnModificar="";
				if($fila)
					$accion=base64_encode("ver");
				else
				{
					
					if(($modificaElementos)||($aplicarExcepcion))
						$accion=base64_encode("agregar");
					else
						$accion=base64_encode("ver");
				}
				if((($modificaElementos)||($aplicarExcepcion))&&($fila)&&(!$elemBloqueado))
				{
					$accionM=base64_encode("modificar");
					$btnModificar="<a href='javascript:f.enviarPaginaEnlace(".$ctParamFunciones.",".$ctTD.",\"".$accionM."\")'>[<img width='9' height='9' src='../images/pencil.png' title ='Modificar' alt='Modificar'> <span style='font-size: 9px; color:#F00'>Editar</span>]</a>";
				}

				$enlace="javascript:f.enviarPaginaEnlace(".$ctParamFunciones.",".$ctTD.",\"".$accion."\")";
				if($fila)			
				{
					$img="<a href='".$enlace."'><img src='../images/bullet_green.png' alt=''></a>";
				}
				else
				{
					if($f[5]=="1")
						$oblRestantes++;
					$img="<a href='".$enlace."'><img src='../images/bullet_red.png' alt=''></a>";
				}
				$ctParamFunciones++;
			break;
			case 2:
				$idProcesoAux=$f[2];
				$idFormularioBase=obtenerFormularioBase($idProcesoAux);
				$nTablaAux=obtenerNombreTabla($idFormularioBase);
				
				$sL=0;

				if(((!$modificaElementos)&&(!$aplicarExcepcion))||($elemBloqueado))
					$sL=1;
				$tVista=1;
				$respRegistroUsr=$respRegistro;
				$consulta="SELECT complementario FROM 203_elementosDTD WHERE idFormulario=".$f[0]." AND idProceso=".$idProceso;
				if($idPerfil!=-1)
				{
					$consulta.=" and idPerfil=".$idPerfil;
				}
				else
					$consulta.=" and idPerfil is null";
					
					
				$complementario=$con->obtenerValor($consulta);
				$msgComp="";
				if($complementario!="")
				{
					$arrComp=explode(",",$complementario);
					$actorProcHijo="'".$arrComp[0]."'";
					if($arrComp[1]!=0)
					{
						if($arrComp[1]>0)
						{
							$consulta="select descParticipacion from 953_elementosPerfilesParticipacionAutor where idElementoPerfilAutor=".$arrComp[1];
							$participacion=$con->obtenerValor($consulta);
							
							$consulta="SELECT idUsuario FROM 246_autoresVSProyecto WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND claveParticipacion=".$arrComp[1];
							$respRegistroUsr=$con->obtenerValor($consulta);
							if($respRegistroUsr=="")
							{
								$sL=1;
								$respRegistroUsr=0;
								$msgComp="&nbsp;<img src='../images/exclamation.png' title='Este proceso ha sido configurado para que los registros que se creen en en proceso sean vinculados al usuario con participaci&oacute;n: ".$participacion.", no obstante dicha participaci&oacute;n no ha sido asignado a&uacute;n en el registro padre, debido a lo anterior no es posible crear nuevos registros de este proceso' 								
										alt='Este proceso ha sido configurado para que los registros que se creen en en proceso sean vinculados al usuario con participaci&oacute;n: ".$participacion.", no obstante dicha participaci&oacute;n no ha sido asignado a&uacute;n en el registro padre, debido a lo anterior no es posible crear nuevos registros de este proceso'>";
							}
						}
						else
						{
							$consulta="SELECT nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$arrComp[3];
							$nCampo=$con->obtenerValor($consulta);	
							$query="select * from ".$nTabla." where id_".$nTabla."=".$idRegistro;
							$resName=$con->obtenerFilas($query);
							
							if($con->filasAfectadas>0)
							{
								$filaRegName=mysql_fetch_assoc($resName);
								$respRegistroUsr=$filaRegName[$nCampo];
							}
							else
								$respRegistroUsr=0;
							
						}
					}

					$tVista=$arrComp[2];
					
					$consulta="SELECT vistaListadoRegistros FROM 900_formularios WHERE idFormulario=".$idFormularioBase;
					$tVisor=$con->obtenerValor($consulta);
					
					$enlace="javascript:f.enviarProcesoVinculado(\"".bE($idRegistro)."\",\"".bE($idProceso)."\",\"".bE($idProcesoAux)."\",\"".bE($respRegistroUsr)."\",\"".bE($actorProcHijo)."\",\"".bE($sL)."\",\"".bE($tVista)."\",\"".bE($tVisor)."\")";
					$f[1]="<font color='#990000'></font>".$f[1].$msgComp."";
				}
				else
				{
					$enlace="";
					$f[1]="<font color='#990000'></font>".$f[1]."&nbsp;<img src='../images/exclamation.png' title='No puede trabajar con el proceso debido a que a&uacute;n no ha sido configurado completamente, se recomienda lo reporte con el responsable de la configuraci&oacute;n del presente proceso para que solucione el problema' alt='No puede trabajar con el proceso debido a que a&uacute;n no ha sido configurado completamente, se recomienda lo reporte con el responsable de la configuraci&oacute;n del presente proceso para que solucione el problema'>";
				}
				//$nTabla="select id_".$nTablaAux." from ".$nTablaAux." where idReferencia=".$idRegistro;
				$consulta="select nombreTabla,idFormulario from 900_formularios where idFormulario=".$idFormularioBase;
				$filaFrm=$con->obtenerPrimeraFila($consulta);
				$nTablaAux=$filaFrm[0];
				$condWhere="";
				
				if($tVista==1)
					$condWhere=" where idProcesoPadre=".$idProceso." and idReferencia=".$idRegistro;
				else
				{
					$idFrmAutores=incluyeModulo($idProcesoAux,3);
					if($idFrmAutores=="-1")
						$condWhere=" where responsable=".$respRegistroUsr;
					else
						$condWhere=" where id_".$nTablaAux." in (select distinct idReferencia from 246_autoresVSProyecto where idUsuario=".$respRegistroUsr." and idFormulario=".$idFormularioBase.")";
				}
				$consulta="select id_".$nTablaAux.",idEstado from ".$nTablaAux." ".$condWhere;
				
				$fila=$con->obtenerPrimeraFila($consulta);
				if($fila)
				{
					$img="<a href='".$enlace."'><img src='../images/bullet_green.png' alt=''></a>";
				}
				else
				{
					if($f[5]=="1")
						$oblRestantes++;
					$img="<a href='".$enlace."'><img src='../images/bullet_red.png' alt=''></a>";
				}
			break;
		}
		
		if($enlace!="")
		{
			$tabla.= "
					<tr height='25'>
						<td>".$img."</td><td width='1'></td><td class='letraFicha' id='td_".$ctTD."'><a href='".$enlace."'>".($f[1])." ".$asterisco."</a>&nbsp;".$btnModificar.$btnBloqueado.$btnBloqueoElem."</td>
					</tr>
					";
		}
		else
		{
			$tabla.= "
					<tr height='25'>
						<td>".$img."</td><td width='1'></td><td class='letraFicha' id='td_".$ctTD."'>".($f[1])." ".$asterisco."&nbsp;".$btnModificar.$btnBloqueado.$btnBloqueoElem."</td>
					</tr>
					";
		}
		$ct++;
		$ctTD++;
	}
	
	$tabla.="<tr><td><br><br><br><br></td></tr>";
	$existeAccion=false;
	$tablaComp="<tr height='25'>
					<td colspan='3' align='left'><i><b>
						Acciones</i></b>
					</td>
				</tr>
				<tr height='2'>
					<td colspan='3' style='background-color:#990000'>
						
					</td>
					</tr>
				<tr height='10'>
					<td colspan='3' >
						
					</td>
					</tr>
			";

	

	
	
	if(($oblRestantes==0)&&($someteRevision))//Someter a revision
	{
		$lblTitulo="Someter a revisión";
		$msgConf="Está seguro de querer someter este registro a revisión?";
		$cerrar=1;
		$funcioEjecucion="";
		if($arrAcciones["1"][1]!="")
		{
			$obj=json_decode($arrAcciones["1"][1]);

			$lblTitulo=$obj->etiqueta;
			$msgConf=$obj->msgConf;
			if(isset($obj->cerrar))
				$cerrar=$obj->cerrar;
			if(isset($obj->funcionEjecutar))
				$funcioEjecucion=$obj->funcionEjecutar;
		}
		$tablaComp.="<tr height='25'>
					<td colspan='3' align='left'>
						<img src='../images/pencil_go.png'>
						<a title='".$lblTitulo."' href='javascript:f.someter(\"".bE($msgConf)."\",\"".bE($cerrar)."\",\"".bE($funcioEjecucion)."\")'><span class='letraFicha'>".$lblTitulo."</span></a>
						<br><br>
					</td>
					</tr>";
		$existeAccion=true;
	}
	if(($asignaRevisores)&&($tipoActor==2))
	{
		$consulta="SELECT rc.idRolComiteFunciones FROM 2007_rolesVSComites r,2009_rolesComitesFunciones rc WHERE 
				rc.idRolVSComite=r.idRolVSComite AND r.rol IN(".$_SESSION['idRol'].") AND r.idComite=".$idComite." AND rc.idFuncionComite=3";
		$idRolComiteFunciones=$con->obtenerValor($consulta);
		
		if($idRolComiteFunciones=="")
		{
			$asignaRevisores=false;
		}
	}	
	$mostrarAgendaComite=false;
	if($mostrarAgendaComite)		
	{
		$idReferenciaAgenda=str_pad($idComite,3,"0",STR_PAD_LEFT).str_pad($idFormulario,6,"0",STR_PAD_LEFT).str_pad($idRegistro,6,"0",STR_PAD_LEFT);
		$tablaComp.="<tr height='25'>
						<td colspan='3' align='left'>
							<img src='../images/calendar.png'>
							<a title='Agenda de reuniones' href='javascript:f.agendaReuniones(\"".$idReferenciaAgenda."\")'><span class='letraFicha'>Agenda de reuniones</span></a>
						</td>
					</tr>";
		$existeAccion=true;
	}
	$cadAsignaRevisor="";	
	if($asignaRevisores)
	{
		$cadAsignaRevisor="<tr height='25'>
						<td colspan='3' align='left'>
							<img src='../images/users.png'>
							<a title='Revisores' href='javascript:f.asignarRevisores()'><span class='letraFicha'>Revisores...</span></a>
						</td>
					</tr>";
		$existeAccion=true;
	}
	
	if(($realizaDictamenP)&&($tipoActor==2))
	{
		$consulta="SELECT rc.idRolComiteFunciones FROM 2007_rolesVSComites r,2009_rolesComitesFunciones rc WHERE 
				rc.idRolVSComite=r.idRolVSComite AND r.rol IN(".$_SESSION['idRol'].") AND r.idComite=".$idComite." AND rc.idFuncionComite=4";

		$idRolComiteFunciones=$con->obtenerValor($consulta);
		if($idRolComiteFunciones=="")
		{
			$realizaDictamenP=false;
		}
	}
	
	$consulta="SELECT COUNT(etapaActual)-1 AS versionRegistro FROM 941_bitacoraEtapasFormularios WHERE etapaActual=".$etapaReg." AND idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
	$nVersion=$con->obtenerValor($consulta);
	if($nVersion<0)
		$nVersion=0;
	
	if($realizaDictamenP)//Dictamen parcial
	{
		$existeAccion=true;
		
		$consulta="select af.idFormulario,af.estado,f.nombreTabla from 948_actoresVSFormulariosDictamen af,900_formularios f where f.idFormulario=af.idFormulario and f.tipoFormulario=13 and af.idActor=".$actor;
		$filaFrmDictamen=$con->obtenerPrimeraFila($consulta);
		$formularioDictamen=$filaFrmDictamen[0];
		$idRegDictamen=$filaFrmDictamen[1];
		$nTablaD=$filaFrmDictamen[2];
		$consulta="select idRegistro from 964_registroDictamenes where idActor=".$actor." and idReferencia=".$idRegistro." and tipoDictamen='P' and versionRegistro='".$nVersion."'";
		
		$idRegDictamen=$con->obtenerValor($consulta);
		if($idRegDictamen=="")
		{
			$lblEtiqueta='Realizar dictamen parcial';

			if($arrAcciones["4"][2]!="")
			{
				$obj=json_decode($arrAcciones["4"][2]);

				$lblEtiqueta=$obj->etiqueta;
			}
			$tablaComp.=$cadAsignaRevisor."<tr height='25'>
						<td colspan='3' align='left'>
							<img src='../images/page_edit2.png'>
							<a title='".$lblEtiqueta."' href='javascript:f.realizarDictamenP(".$formularioDictamen.",".$idRegistro.")'><span class='letraFicha'>".$lblEtiqueta."</span></a>
						</td>
						</tr>";
		}
		else
		{
			$lblEtiqueta='Realizar dictamen parcial';
			if($arrAcciones["4"][2]!="")
			{
				$obj=json_decode($arrAcciones["4"][2]);

				$lblEtiqueta=$obj->etiqueta;
			}
			$tablaComp.="<tr height='25'>
						<td colspan='3' align='left'>
							<img src='../images/page_white_magnify.png'>
							<a title='".$lblEtiqueta." (Ver resultado)' href='javascript:f.verDictamenP(".$formularioDictamen.",".$idRegDictamen.")'><span class='letraFicha'>".$lblEtiqueta." (Ver resultado)</span></a>
						</td>
						</tr>";
		}
	}
	
	if(($realizaDictamenF)&&($tipoActor==2))
	{
		$consulta="SELECT rc.idRolComiteFunciones FROM 2007_rolesVSComites r,2009_rolesComitesFunciones rc WHERE 
				rc.idRolVSComite=r.idRolVSComite AND r.rol IN(".$_SESSION['idRol'].") AND r.idComite=".$idComite." AND rc.idFuncionComite=4";
		$idRolComiteFunciones=$con->obtenerValor($consulta);
		if($idRolComiteFunciones=="")
		{
			$realizaDictamenF=false;
		}
	}
	
	$veOtrosDictamenes=false;
	
	if($realizaDictamenF)
	{
		$existeAccion=true;
		$consulta="SELECT ae.* FROM 947_actoresProcesosEtapasVSAcciones ae,944_actoresProcesoEtapa pe WHERE 
					pe.idActorProcesoEtapa=ae.idActorProcesoEtapa AND ae.idGrupoAccion IN (4,5) AND pe.numEtapa=".$etapaReg."
					AND pe.idProceso=".$idProceso." AND ae.idActorProcesoEtapa<>".$actor;
		if($idPerfil!=-1)
		{
			$consulta.=" and pe.idPerfil=".$idPerfil;	
		}
		else
		{
			$consulta.=" and pe.idPerfil is null";
		}
		$resDictamenes=$con->obtenerFilas($consulta);
		
		$nDictamenes=$con->filasAfectadas;
		$consulta="select af.idFormulario,af.estado,f.nombreTabla from 948_actoresVSFormulariosDictamen af,900_formularios f where f.idFormulario=af.idFormulario and f.tipoFormulario=14 and af.idActor=".$actor;
		$filaFrmDictamen=$con->obtenerPrimeraFila($consulta);
		$formularioDictamen=$filaFrmDictamen[0];
		$idRegDictamen=$filaFrmDictamen[1];
		$nTablaD=$filaFrmDictamen[2];
		$consulta="select idRegistro from 964_registroDictamenes where versionRegistro='".$nVersion."' and idFormulario=".$idFormulario." and idReferencia=".$idRegistro." and idActor=".$actor." and tipoDictamen='F'";

		$idRegDictamen=$con->obtenerValor($consulta);
		
		if($idRegDictamen=="")
		{
			$permitirDictamenFinal=false;
			$comp="";
			if($arrAcciones[5][1]!="")
			{
				
				$consulta="SELECT a.idGrupoAccion,a.idActorProcesoEtapa 
							FROM 947_actoresProcesosEtapasVSAcciones a,944_actoresProcesoEtapa p 
							WHERE p.idActorProcesoEtapa=a.idActorProcesoEtapa and 
							(
								p.asocAutomatico=1
								or
								(
									p.asocAutomatico=0 and 
									(select idActorEvaluador from 998_actoresEvaluadoresAsignados where idFormulario=".$idFormulario." and idRegistro=".$idRegistro." and idActorProcesoEtapa=a.idActorProcesoEtapa) is not null
								)
							)
							and
							a.idAccionesProcesoEtapaVSAcciones IN(".$arrAcciones[5][1].")";
				
				
				if($idPerfil!=-1)
				{
					$consulta.=" and p.idPerfil=".$idPerfil;	
				}
				else
				{
					$consulta.=" and p.idPerfil is null";
				}
				
				
				$resDependenciasD=$con->obtenerFilas($consulta);
				$permitirDictamenFinal=true;
				$listDependencia="";
				$ct=1;
				while($filaDep=mysql_fetch_row($resDependenciasD))				
				{
					$veOtrosDictamenes=true;
					$tDictamen="";
					if($filaDep[0]==4)
						$tDictamen="P";
					else
						$tDictamen="F";
					$consulta="SELECT idDictamenes FROM 964_registroDictamenes WHERE idActor=".$filaDep[1]." AND idReferencia=".$idRegistro." AND tipoDictamen='".$tDictamen."' and versionRegistro=".$nVersion;
					$filaD=$con->obtenerPrimeraFila($consulta);
					
					if(!$filaD)
					{
						
						$permitirDictamenFinal=false;
						$consulta="select actor,tipoActor from 944_actoresProcesoEtapa where idActorProcesoEtapa=".$filaDep[1];
						
						$filaAt=$con->obtenerPrimeraFila($consulta);
						$nActor="";
						if($filaAt[1]=="1")
							$nActor=$ct.".- Rol: ".obtenerTituloRol($filaAt[0]);
						else
						{
							$consulta="select c.nombreComite from 234_proyectosVSComitesVSEtapas pc,2006_comites c where c.idComite=pc.idComite and pc.idProyectoVSComiteVSEtapa=".$filaAt[0];
							
							$nComite=$con->obtenerValor($consulta);
							$nActor=$ct.".- Comité: ".$nComite;
						}
						if($listDependencia=="")
							$listDependencia=$nActor;
						else
							$listDependencia.=", ".$nActor;
						$ct++;
						
					}
				}
				if(!$permitirDictamenFinal)
					$comp="&nbsp;<img src='../images/lock.png' title='No se puede llevar acabo el dictámen final debido a que se esperan los resultados de dictámen correspondientea cada uno de los siguientes actores: ".$listDependencia."' alt='No se puede llevar acabo el dictámen final debido a que se esperan los resultados de dictámen correspondientea cada uno de los siguientes actores: ".$listDependencia."'>";
			}
			else
			{
				$permitirDictamenFinal=true;
			}
			$tablaComp.=$cadAsignaRevisor."<tr height='25'>
						<td colspan='3' align='left'>
							<img src='../images/page_accept.png'>
						";
			
			$lblEtiqueta='Realizar dictamen final';
			if($arrAcciones["5"][2]!="")
			{
				$obj=json_decode($arrAcciones["5"][2]);

				$lblEtiqueta=$obj->etiqueta;
			}
			
			if($permitirDictamenFinal)
				$tablaComp.="<a title='".$lblEtiqueta."' href='javascript:f.realizarDictamenFinal(".$formularioDictamen.",".$idRegistro.")'>";
			$tablaComp.="<span class='letraFicha'>".$lblEtiqueta."".$comp."</span>";
			
			if($permitirDictamenFinal)
				$tablaComp.="</a>";
			$tablaComp.="	</td>
					</tr>";
		}
		else
		{
			$lblEtiqueta='Realizar dictamen final';
			if($arrAcciones["5"][2]!="")
			{
				$obj=json_decode($arrAcciones["5"][2]);

				$lblEtiqueta=$obj->etiqueta;
			}
			$tablaComp.="<tr height='25'>
					<td colspan='3' align='left'>
						<img src='../images/page_white_magnify.png'>
						<a title='".$lblEtiqueta." (Ver resultado)' href='javascript:f.verDictamenFinal(".$formularioDictamen.",".$idRegDictamen.")'><span class='letraFicha'>".$lblEtiqueta." (Ver resultado)</span></a>
					</td>
					</tr>";
		}
		
		
		if(($nDictamenes>0)&&($veOtrosDictamenes))
		{
			$tablaComp.="<tr height='25'>
					<td colspan='3' align='left'><br><br>
					<a href='javascript:verOtrosDictamenes()'>
						<span class='copyrigthSinPadding' title='En este proceso se ha configurado que otros actores puedan realizar dictámenes sobre este registro, para ver los resultados de dichos dictámenes de click aquí' alt='En este proceso se ha configurado que otros actores puedan realizar dictámenes sobre este registro, para ver los resultados de dichos dictámenes de click aquí'><img src='../images/magnifier.png'>&nbsp;Ver situación de otros dictámenes</span>
					</a>
						
					</td>
					</tr>";
		}
		
	}

	if(($actor<0)&&($actor!=-255)) //Dictamen revisor
	{
		$existeAccion=true;
		//$consulta="select idFormDictamen from 955_revisoresProceso where idUsuarioRevisor=".$_SESSION["idUsr"]." and idActorProcesoEtapa=".($actor*-1);
		$consulta="select idFormDictamen from 955_revisoresProceso where idReferencia=".$idRegistro." and versionRegistro=".$nVersion." and idUsuarioRevisor=".$_SESSION["idUsr"]." and idActorProcesoEtapa=".($actor*-1);
		$idFormDictamen=$con->obtenerValor($consulta);
		$consulta="select af.idFormulario from 948_actoresVSFormulariosDictamen af,900_formularios f where f.idFormulario=af.idFormulario and f.tipoFormulario=15 and af.idActor=".($actor*-1);
		$formularioDictamen=$con->obtenerValor($consulta);

		if($idFormDictamen=="-1")
		{
			$lblEtiqueta='Realizar dictamen';
			if($arrAcciones["1"][1]!="")
			{
				$obj=json_decode($arrAcciones["1"][1]);

				$lblEtiqueta=$obj->etiqueta;
			}
			$tablaComp.="<tr height='25'>
					<td colspan='3' align='left'>
						<img src='../images/pencil.png'>
						<a title='".$lblEtiqueta."' href='javascript:f.realizarDictamenRevisor(".$formularioDictamen.",\"".bE($idRegistro)."\")'><span class='letraFicha'>".$lblEtiqueta."</span></a>
					</td>
					</tr>";
		}
		else
		{
			$lblEtiqueta='Realizar dictamen';
			if($arrAcciones["1"][1]!="")
			{
				$obj=json_decode($arrAcciones["1"][1]);

				$lblEtiqueta=$obj->etiqueta;
			}
			$tablaComp.="<tr height='25'>
					<td colspan='3' align='left'>
						<img src='../images/fechaVerdeBullet.gif'>
						<a title='".$lblEtiqueta." (Ver Resultado)' href='javascript:f.verDictamenRevisor(".$formularioDictamen.",".$idFormDictamen.")'><span class='letraFicha'>".$lblEtiqueta." (Ver Resultado)</span></a>
					</td>
					</tr>";
		}
	}
	
	if($asignaComites)
	{
		$tablaComp.="<tr height='25'>
						<td colspan='3' align='left'>
							<img src='../images/users.png'>
							<a title='Revisores' href='javascript:f.asignarComites(\"".bE($arrAcciones["12"][0])."\")'><span class='letraFicha'>Asignar ".strtolower($lblComiteS)." de evaluación</span></a>
						</td>
					</tr>";
		$existeAccion=true;
	}
	
	if($obtieneUsuarioPerfil)
	{
		$tablaComp.="<tr height='25'>
						<td colspan='3' align='left'>
							<img src='../images/users.png'>
							<a title='Revisores' href='javascript:f.verCandidatos(\"".bE($idRegistro)."\")'><span class='letraFicha'>Obtener candidatos que cumplan perfil</span></a>
						</td>
					</tr>";
		$existeAccion=true;
	}
  	/*if($seleccionaUsrPerfil)
	{
		$tablaComp.="<tr height='25'>
						<td colspan='3' align='left'>
							<img src='../images/users.png'>
							<a title='Revisores' href='javascript:f.asignarComites(\"".bE($arrAcciones["12"][0])."\")'><span class='letraFicha'>Asignar ".strtolower($lblComiteS)." de evaluación</span></a>
						</td>
					</tr>";
		$existeAccion=true;
	}*/
  	if($contrataPersonal)
	{
		$tablaComp.="<tr height='25'>
						<td colspan='3' align='left'>
							<img src='../images/users.png'>
							<a title='Revisores' href='javascript:f.contratarCandidato(\"".bE($idRegistro)."\")'><span class='letraFicha'>Contratar candidato</span></a>
						</td>
					</tr>";
		$existeAccion=true;
	}
	
  	if($elijeCanditatoPuesto)
	{
		$tablaComp.="<tr height='25'>
						<td colspan='3' align='left'>
							<img src='../images/users.png'>
							<a title='Revisores' href='javascript:f.elegirCandidato(\"".bE($idRegistro)."\")'><span class='letraFicha'>Elegir candidato a puesto</span></a>
						</td>
					</tr>";
		$existeAccion=true;
	}
	
	echo $tabla;
    if($existeAccion)
		echo $tablaComp;
?>
  </table>
  <input type="hidden" id="hActorMenuDTD" value="<?php echo $actor?>" />
  <input type="hidden" id="idProceso" value="<?php echo $idProceso?>" />
  <input type="hidden" id="etapaReg" value="<?php echo $etapaReg?>" />  
  <input type="hidden" id="vActual" value="<?php echo $mVersion?>" />  
  <input type="hidden" id="idPerfil" value="<?php echo $idPerfil?>" />  
  
  <?php
  	if($objParametros->participante==1)
	{
?>
		<input type="hidden"  id="idParticipante" value="<?php echo $idParticipante ?>" />
<?php
	}
  ?>
  <br /><br />
<?php
}

function genenerarDTDProyecto()
{
	
	global $con;
	global $accion;
	global $actor;
	global $objParametros;
	global $idProcesoP;
	global $idReferencia;
	
	$idFormulario=$objParametros->idFormulario;
	$idRegistro=$objParametros->idRegistro;
	
	$consulta="select nombreFormulario,nombreTabla,idProceso from 900_formularios  where idFormulario=".$idFormulario;
	
	$fForm=$con->obtenerPrimeraFila($consulta);
	$nFormulario=$fForm[0];
	$nTabla=$fForm[1];
	$idProceso=$fForm[2];
	
	$tblRegistro="";
	$ocultarMenuDTD="";
	$constante=1;
	
	if($actor<0)
		$constante=-1;

	if($accion!="agregar")
	{
		if($actor!=0)
		{
			$consulta="select tipoActor,actor from 944_actoresProcesoEtapa where idActorProcesoEtapa=".($actor*$constante);
			$filaActor=$con->obtenerPrimeraFila($consulta);
			$tipoActor=$filaActor[0];
			$act=$filaActor[1];
		}
		else
		{
			$tipoActor=1;
			$act=0;
		}
		
	}
	
	?>
    <span id="divAcciones">
	<?php
	
	switch($accion)
	{
    	case "agregar":
			$consulta="SELECT actor FROM 949_actoresVSAccionesProceso WHERE idActorVSAccionesProceso=".$actor;
			$idActor=$con->obtenerValor($consulta);
			$idPerfil=obtenerIdPerfilEscenario($idProceso,1,$idActor);
			
			$tblRegistro="	<table id='tblRegistro'>
							<tr>
								<td><img src='../images/update_nw.gif' alt=''></td><td width='10'></td><td class='letraFicha' id='td_1'>".$nFormulario."</td>
							</tr>
							</table>
							<input type='hidden' id='idPerfil' value='".$idPerfil."' />  
						";
		break;
		case "modificar":
			generarTablaModulos();
		break;
		case "auto":
			generarTablaModulos();
		break;
	}

	echo $tblRegistro;
	
?>
	</span>
    <br /><br />
<?php
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr"><!-- InstanceBegin template="/Templates/Lhayas_B.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<style>
<?php
	generarFuentesLetras();
?>

	body
    {
		min-height:450px;
    	
    }
</style>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta name="description" content=""/>
<meta name="keywords" content="" />
<meta name="robots" content="index,follow" />
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
<link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
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
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<script type="text/javascript" src="../Scripts/funcionesGenerales.js"></script>


<?php 
$idEstiloMenu=0;
$procesoName="";
$mostrarRegresar=true;
$ocultarRegresar=!$mostrarOpcionRegresar;
$soloContenido=false;
$mostrarRegresarBajo=false;
$mostrarMenuNivel1=true;
$mostrarMenuNivel2=true;
$mostrarMenuIzq=false;
$mostrarTitulo=true;
$respetarEspacioRegresar=false;
$tamColumIzq="210";
$mostrarUsuario=true;
$mostrarPiePag=true;
$ocultarFormulariosEnvio=false;
$paginaDestino="";

$sqlmax = "SELECT disenoBanner,textoInfIzq,textInfDerecho,tituloPagina,Menu,txTabla3,txTabla4,TiTabla FROM 4081_colorEstilo";
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
$paramPOST=true;
$paramGET=false;
$guardarConfSession=false;
$arrPOST=array_values($_POST);
$ctPOST=sizeof($arrPOST);
$arrGET=array_values($_GET);
$ctGET=sizeof($arrGET);
$txMenuIncluye="";
$mostrarBotonesControlSistema=false;
$tituloModulo="";
?>

<!-- InstanceBeginEditable name="EditRegion5" -->
<script type="text/javascript" src="Scripts/menuDTD.js.php">
</script>
<style>
	.p15
	{
		padding: 1px !important;		
	}
	#main_content
	{
		padding: 1px !important;
	}
	#example_content
	{
		padding: 1px !important;
	}
</style>
<!-- InstanceEndEditable -->

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
<!-- InstanceBeginEditable name="doctitle" -->
<script>
	var f=window;
</script>

<!-- InstanceEndEditable -->
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
		$_SESSION["configuracionesPag"][$nConfiguracion]["tituloModulo"]=$tituloModulo;
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


<!-- InstanceBeginEditable name="head" -->
<?php

	$accion="";
	if(isset($objParametros->dComp))
		$accion=base64_decode($objParametros->dComp);
	
	$idFormulario="-1";
	if(isset($objParametros->idFormulario))
		$idFormulario=$objParametros->idFormulario;
		
	$idRegistro="-1";
	if(isset($objParametros->idRegistro))
		$idRegistro=$objParametros->idRegistro;
	$idProcesoP="";
	if(isset($objParametros->idProcesoP))
		$idProcesoP=$objParametros->idProcesoP;
	
	$idReferencia="";
	if(isset($objParametros->idReferencia))
		$idReferencia=$objParametros->idReferencia;
	$idUsuario=$_SESSION["idUsr"];
	if(isset($objParametros->idUsuario))
		$idUsuario=$objParametros->idUsuario;
?>
<!-- InstanceEndEditable -->

<?php 
$tipoConsult="";
$permisosArray=array();
if($procesoName!="")
{
	$consulta="select permisos from 942_funcionesRoles where proceso='".$procesoName."' and rol in (".$_SESSION["idRol"].")";
	$procesoResult=$con->obtenerFilas($consulta);
	while($procesoRow=mysql_fetch_row($procesoResult))
	{
		$permisos=$procesoRow[0];
		$arrPermisosArray=explode("_",$permisos);
		$ctPermisos=sizeof($arrPermisosArray);
		for($x=0;$x<$ctPermisos;$x++)
		{
			$permisosArray[$arrPermisosArray[$x]]=true;
		}
	}
}


$configuracion="";
if(isset($objParametros->configuracion))
	$configuracion=$objParametros->configuracion;
$cPagina="";
$iFrame=false;
if(isset($objParametros->cPagina))
	$cPagina=$objParametros->cPagina;

if(isset($objParametros->iFrame))
	$iFrame=$objParametros->iFrame;

$arrParam=array();
	
if($cPagina!="")	
{
	$arrConf=explode("|",$cPagina);
	$nConf=sizeof($arrConf);
	for($x=0;$x<$nConf;$x++)
	{
		$arrDatosP=explode("=",$arrConf[$x]);
		$arrParam[$arrDatosP[0]]=$arrDatosP[1];
	}
	if(isset($arrParam["b"]))
		$mostrarTitulo=false;
	if(isset($arrParam["mI"]))
		$mostrarMenuIzq=false;
	if(isset($arrParam["mnu1"]))
		$mostrarMenuNivel1=false;
	if(isset($arrParam["mnu2"]))
		$mostrarMenuNivel2=false;
	if(isset($arrParam["mR1"]))
		$mostrarRegresar=false;
	if(isset($arrParam["mR2"]))
		$mostrarRegresarBajo=true;
	if(isset($arrParam["mPie"]))
		$mostrarPiePag=false;
	if(isset($arrParam["sFrm"]))
		$soloContenido=true;
	if(isset($arrParam["gConfS"]))
		$guardarConfSession=false;
	
}

$consulta="SELECT idIdioma,idioma,imagen FROM 8002_idiomas ORDER BY idioma";
$res=$con->obtenerFilas($consulta);
?>
<title><?php echo $tituloPagina ?></title>
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
<?php
	if($soloContenido)
	{
?>
	<style>
	#main_content
	{
		padding: 0px !important;
	}
	.p15
	{
		padding: 0px !important;
	}
	#example_content
	{
		padding: 0px !important;
		margin-bottom: 0px !important;
	}
	</style>
<?php		
	}
?>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/controlesFrameWork.css"/>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/estiloSIUGJ.css"/>
</head>

<?php
		$main_single="main_single";
		$wrapper="wrapper";
		$main_hayas="main_hayas";
		$bgColor="";
		if($soloContenido)
		{
			$main_single="";
			$wrapper="";
			$main_hayas="";
			$bgColor='style=" background:#FFFFFF !important"';
		}
		
	?>

<body <?php echo $bgColor ?>>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<?php
	if(!$soloContenido)
	{
?>
<div id="main_title">
  <div class="wrapper">
  <?php
  	if($mostrarTitulo)
	{
		echo $banner; 
	} 
	?>
    <div class="transparencia" >
    	<table >
        	<tr height="25">
            	<td >
                	<?php
					if(!esUsuarioLog()&&$mostrarBotonesControlSistema)
					{
					?>
                    	<table class="transparencia2">
                        	<tr>
                            	<td align="right">
			                		<a href="javascript:ingresarSistema()"><img src="../images/botonIngreso.png"  /></a><a href="javascript:mostrarVentanaDuda()"><img src="../images/botonSoporte.png"  /></a>
                                </td>
                                <td align="left">
	                                
                                </td>
                            </tr>
                        </table>
                    <?php
					}
					else
					{
						if($mostrarBotonesControlSistema)
						{
					?>
                    	<table class="transparencia2">
                        	<tr>
                            	<td align="right">
			                		<a href="javascript:cerrarSesion()"><img src="../images/botonSalir.png" /></a>
                                </td>
                                <td align="left">
	                               <!-- &nbsp;<a href="javascript:cerrarSesion()">Cerrar sesión</a>-->
                                </td>
                            </tr>
                        </table>
						
					<?php
						}
					}
					
                    ?>
                </td>
                <td>
                </td>
            </tr>
       </table>
    </div>
  </div>
</div>
	
	<div id="navigation_hayas">
	<div class="wrapper_hayas">
    	
    	<div class="links_hayas">
		<ul class="tabs_hayas"  style="z-index:200 !important">
			<?php 
				
				if($mostrarMenuNivel1)
				{
					
					genearOpcionesMenusPrincipal($nomPagina,1,$idEstiloMenu);
				}
				
			?>
		</ul>
		<div class="clearer">&nbsp;</div>
		</div>

	</div>
	</div>
	<div id="subnavigation_hayas">
	<div class="wrapper">
		<div class="content">
			<div class="links">
            	<ul class="menu2" >
			<?php
				if($mostrarMenuNivel2)
				{
					genearOpcionesMenusPrincipal($nomPagina,2,$idEstiloMenu);
				}
			
			?>
            	</ul>
			<div class="clearerx">&nbsp;</div>
		  </div>
	  </div>
	</div>
</div>
<?php
	}
?>
	

	<div id="<?php echo $main_hayas ?>">
	<div class="<?php echo $wrapper ?>">

		<div id="main_content">		
		<div id="<?php echo $main_single ?>" class="p15">
		<div > 
			  <table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
               
			    <tr>    
					<?php  
					if((($mostrarMenuIzq)&&(!$soloContenido))||((isset($arrParam["mI"]))&&($arrParam["mI"]=='true')))
					{
					?>	
                    <td valign="top" style="width:<?php echo $tamColumIzq?>px" id="tdMenuIzq">
					
               		<div id="example_content" style="width:<?php echo $tamColumIzq?>px">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="top">
                        	<?php
                            genearOpcionesMenusPrincipal($nomPagina,3,$idEstiloMenu);
                            ?>
						</td>
						
                      </tr>
					  <tr>
					  <td>
					 
					  <!-- InstanceBeginEditable name="menu_left2" -->
					  
					  <!-- InstanceEndEditable -->
					  </td>
					  </tr>
                    </table>
					 </div>
                
                     </td>
					 <?php
					 }
					 ?>
                  <td width="1%" bgcolor="#FFFFFF">&nbsp;</td>
                  <td width="81%" bgcolor="#FFFFFF" valign="top">
				  <div id="example_content">  
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
				  	<td align="right">
						<table width="100%">
						<tr>
						<td>
							<?php 	
									if(!$ocultarRegresar)
									{

										if((($mostrarRegresar)&&(!$soloContenido))||((isset($arrParam["mR1"]))&&($arrParam["mR1"]=='true')))
										{
								?> 
											<table align="left" id="tblRegresar1">
											<tr>
											<td>
											<a href="<?php echo $pagRegresar ?>" class="letraVerde"><img width="24" height="24" src="../images/flechaizq.gif" border="0" /></a>
											</td>
											<td>
											<a href="<?php echo $pagRegresar ?>" class="letraVerde">&nbsp;&nbsp;<?php echo $et["regresar"] ?></a>
											</td>
											</tr>
											</table>
											<br />
								<?php 
										}
									}
									if($respetarEspacioRegresar)
										echo "<br><br>";
									echo "<input type=\"hidden\" value=\"".$_SESSION["leng"]."\" id=\"hLeng\"> ";
									
							?>
						</td>
						</tr>
						</table>
					</td>
				</tr>
				  <!-- InstanceBeginEditable name="content2" --> 
                   <tr>
                        <td>
                       
                        <?php
						  $scriptFrmEnvio="";
						  if(!isset($objParametros->refrescarContenido))
						  {
							  switch($accion)
							  {
								  case "agregar":
								  $comp="";
								  $compJS="";
								  		if(isset($objParametros->funcPHPEjecutarNuevo))
										{
											$comp=",funcPHPEjecutarNuevo:'".$objParametros->funcPHPEjecutarNuevo."'";	
										}
										
										if(isset($objParametros->funcEJs))
										{
											$compJS=bD($objParametros->funcEJs);
										}

									  $scriptFrmEnvio	="var parametrosFrm={pagRegresar:'".bE("window.parent.close();")."',idProcesoP:'".$idProcesoP."',idReferencia:'".$idReferencia."',idUsuario:'".$idUsuario."',idRegistro:'".$idRegistro."',idFormulario:'".$idFormulario."',cPagina:'sFrm=true',paginaRedireccion:'../modeloPerfiles/verFichaFormulario.php',eJs:'".base64_encode("window.parent.mostrarMenuDTD('@idRegistro');".$compJS."return;")."'".$comp."};
														var funcionInicio=function()
																		  {
																			  var paramAux=eval(bD(gE('arrParamComp').value));
																			  var x;
																			  for(x=0;x<paramAux.length;x++)
																			  {
																				  parametrosFrm[paramAux[x][0]]=paramAux[x][1];
																			  }
																			  f.enviarPaginaIFrame('../modeloPerfiles/registroFormulario.php',parametrosFrm);
																		  }
													  ";
									   
								  break;
								  case "modificar":
								  case "auto":
									  $scriptFrmEnvio	="var parametrosFrm={idRegistro:'".$idRegistro."',idFormulario:'".$idFormulario."',idReferencia:'".$idReferencia."',cPagina:'sFrm=true',paginaRedireccion:'../modeloPerfiles/verFichaFormulario.php',eJs:'".base64_encode("window.parent.mostrarMenuDTD();")."'};
													  var funcionInicio=function()
																		  {
																			  var paramAux=eval(bD(gE('arrParamComp').value));
																			  var x;
																			  for(x=0;x<paramAux.length;x++)
																			  {
																				  parametrosFrm[paramAux[x][0]]=paramAux[x][1];
																			  }
																			  

																			  f.enviarPaginaIFrame('../modeloPerfiles/verFichaFormulario.php',parametrosFrm);
																		  }
													  ";
								  break;
							  
						  		}
						  }
						  else
						  {
							  	$scriptFrmEnvio="var funcionInicio=function(){};";
						  }
						  $actor=0;
						  
						  if(isset($objParametros->actor))
							  $actor=base64_decode($objParametros->actor);
						  
						 
						  
						  genenerarDTDProyecto();
						  
					  ?>
                      	<script>
						
						<?php
							echo $scriptFrmEnvio;
						  	echo $arrConfiguraciones;
						?>
							f.arrParamConfiguraciones=arrParamConfiguraciones;
						</script>
                        
                        </td>
                   </tr>
				  <!-- InstanceEndEditable -->
				  <tr>
				  <td><br />
                  <?php
						if(!$ocultarFormulariosEnvio)
						{
				  ?>
                            <form method="post"	action="" id='frmEnvioDatos'>
                                <input type="hidden" name="confReferencia" value="<?php echo $nConfiguracion ?>" />
                                
                                <?php
									if($soloContenido)
									{
								?>
                                 <input type="hidden" name="cPagina" value="sFrm=true|mR1=true" />
                                <?php
									}
								?>
                                
                            </form>
                            <form method="post"	action="<?php echo $pConfRegresar?>" id='frmRegresar'>
                                <input type="hidden" name="configuracion" id="configuracionRegresar" value="<?php echo $nConfRegresar ?>" />
                            </form>
                            <form method="post"	action="<?php echo "../".$rutaNomPagina ?>" id='frmRefrescarPagina'>
                                <input type="hidden" name="configuracion" value="<?php echo $nConfiguracion ?>" />
                            </form>    
                        
				  	<?php 	
						}
					
							if(($mostrarRegresarBajo)&&(!$soloContenido))
							{
							?> 
							<table align="left" id="tblRegresar2">
							<tr>
							<td>
							<a href="<?php echo $pagRegresar ?>" class="letraVerde"><img src="../images/flechaizq.gif" border="0" /></a>
							</td>
							<td>
							<a href="<?php echo $pagRegresar ?>" class="letraVerde">&nbsp;&nbsp;<?php echo $et["regresar"] ?></a>
							</td>
							</tr>
							</table>
							<?php 
									}
							?>
				  </td>
				  </tr> 
				   </table>
				 </div>
				  </td>
				
                </tr>
              </table>
			  <div class="clearer">&nbsp;</div>
		 


			<div class="clearer">&nbsp;</div>
		</div>
	</div>
</div>
<?php
if(($mostrarPiePag)&&(!$soloContenido))
{
?>
<div id="footer">
	<div class="wrapper">
		<div class="content">

			<table width="100%">
            	<tr>
                	<td width="33%" align="left">
                        <span class="small">
                        <?php
                            echo $textoInfIzq;
                        ?>
                        </span>
                    </td>
                    <td width="34%"></td>
                    <td width="33%" align="right">
                    	<span class="small">
						<?php
                            echo $textoInfDer;
                        ?>
                        </span>
                    </td>
                    
                </tr>
            </table>
	  </div>
	</div>
</div>
<?php
}
?>
</body>
<!-- InstanceEnd --></html>
