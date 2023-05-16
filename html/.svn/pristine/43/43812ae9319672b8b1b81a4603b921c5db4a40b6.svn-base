<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	if(isset($_SESSION["leng"]))
	{
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];
		$lenguaje=$_SESSION["leng"];
		
		switch($funcion)
		{
			case 1:
				obtenerDatosOrganizaciones();
			break;
			case 2:
				obtenerFormatoBoletin();
			break;
			case 3:
				removerArticuloBoletin();
			break;
			case 4:
				obtenerArticulosDisponibles();
			break;
			case 5:
				registrarArticulosBoletin();
			break;
			case 6:
				obtenerPublicacionesBoletin();
			break;
			case 7:
				obtenerVacantesPorEmpresa();
			break;
			case 8:
				obtenerVacantesPorCategoria();
			break;
			case 9:
				obtenerDatosAccesoEmpresa();
			break;
		}
	}
	
	function obtenerDatosOrganizaciones()
	{
		global $con;
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$cadEmpresas="";
		
		$comp="";
		$nombre=$_POST["nombre"];
		if($nombre!="")
			$comp=" txtRazonSocial like '%".cv($nombre)."%'";
		$compTipo="";
		$compSocio="";
		$tipoContribuyente=$_POST["tipoContribuyente"];
		if($tipoContribuyente=="1,2")
		{
			$compTipo=" or cmbTipoContribuyente is null";
		}
		$soloMiembros=$_POST["soloMiembros"];
		if($soloMiembros=="1,2")
		{
			$compSocio=" or radEsSocio is null";
		}
		if($comp=="")
			$comp=" (cmbTipoContribuyente in (".$tipoContribuyente.") ".$compTipo.") and (radEsSocio in (".$soloMiembros.") ".$compSocio.")";
		else
			$comp.=" and (cmbTipoContribuyente in (".$tipoContribuyente.") ".$compTipo.") and (radEsSocio in (".$soloMiembros.") ".$compSocio.")";
		
		$consulta="SELECT * FROM _716_tablaDinamica where ".$comp." ORDER BY txtNombreComercial limit ".$start.",".$limit;

		$res=$con->obtenerFilas($consulta);
		$nRegistros=0;
		while($fila=mysql_fetch_row($res))
		{
			$fila[19]=str_replace("#R","",$fila[19]);
			if($fila[25]=="")
				$fila[25]=-1;
			if($fila[26]=="")
				$fila[26]=-1;
			$consulta="SELECT txtGiro FROM _732_tablaDinamica WHERE id__732_tablaDinamica=".$fila[25];
			$giro=$con->obtenerValor($consulta);
			if($giro=="")
				$giro="No especificado";
			$consulta="SELECT subGiro FROM _732_GridSubgiro WHERE id__732_GridSubgiro=".$fila[26];
			$giro2=$con->obtenerValor($consulta);
			if($giro2=="")
				$giro2="No especificado";
			$telefonos="";
			$consulta="SELECT CONCAT('(',lada,') ',numTelefono) FROM _716_gridTelefono WHERE idReferencia=".$fila[0]." and (lada<>'' or numTelefono<>'')";
			$resTel=$con->obtenerFilas($consulta);
			while($fTel=mysql_fetch_row($resTel))
			{
				if($telefonos=="")
					$telefonos=$fTel[0];
				else
					$telefonos.="<br>".$fTel[0];
			}
			$direccion="";
			if($fila[13]!="")
			{
				$direccion="<b>Calle</b> ".$fila[13];
			}
			
			if($fila[14]!="")
			{
				if($direccion=="")
					$direccion="<b>Colonia</b> ".$fila[14];
				else
					$direccion.=" <b>Colonia</b> ".$fila[14];
			}
			
			if($fila[15]!="")
			{
				if($direccion=="")
					$direccion="<b>C.P.</b> ".$fila[15];
				else
					$direccion.=" <b>C.P.</b> ".$fila[15];
			}
			
			$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fila[17]."'";
			$municipio=$con->obtenerValor($consulta);
			$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fila[16]."'";
			$estado=$con->obtenerValor($consulta);
			$lblEstado=$municipio;
			if($estado!="")
			{
				if($lblEstado=="")
					$lblEstado=$estado;
				else
					$lblEstado.=", ".$estado;
			}
			if($direccion=="")
					$direccion=$lblEstado;
				else
					$direccion.=". ".$lblEstado;
			

			$obj='{"idOrganizacion":"'.$fila[0].'","nombreComercial":"'.cv($fila[10]).'","tipoContribuyente":"'.cv($fila[22]).'","razonSocial":"'.cv($fila[12]).
				'","direccion":"'.$direccion.'","paginaWeb":"'.cv($fila[18]).'","telefonos":"'.$telefonos.'","descripcion":"'.cv($fila[19]).'","giro1":"'.cv($giro).'","giro2":"'.cv($giro2).
				'","esSocio":"'.cv($fila[28]).'","solicitudSocio":"'.cv($fila[27]).'"}';
			if($cadEmpresas=="")
				$cadEmpresas=$obj;
			else
				$cadEmpresas.=",".$obj;
			$nRegistros++;
		}
		$consulta="SELECT count(*) FROM _716_tablaDinamica where ".$comp." ORDER BY txtNombreComercial";
		$nRegistros=$con->obtenerValor($consulta);
		echo '{"numReg":"'.$nRegistros.'","registros":['.$cadEmpresas.']}';
	}
	
	
	function obtenerFormatoBoletin()
	{
		global $con;
		
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		
		$tblResumen=generarFichaResumenArticulo($idRegistro);
		$tblArticulo=generarFichaArticulo($idRegistro);
		
		$tblCompleto='<table width="740">
						<tr>
							<td>'.$tblResumen.'
							</td>
						</tr>
						<tr height="20">
							<td></td>
						</tr>
						<tr height="1">
							<td style="background-color:#CCC">
							</td>
						</tr>
						<tr height="20">
							<td></td>
						</tr>
						<tr>
							<td>'.$tblArticulo.'
							</td>
						</tr>
					</table>';
		echo "1|".bE($tblCompleto);
		
		
	}
	
	function removerArticuloBoletin()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$consulta="DELETE FROM 3005_articulosBoletin WHERE idArticuloBoletin=".$idRegistro;
		eC($consulta);
			
	}
	
	function obtenerArticulosDisponibles()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$consulta="SELECT id__752_tablaDinamica as idArticulo,tituloArticulo  FROM _752_tablaDinamica WHERE idEstado=3 AND id__752_tablaDinamica 
					NOT IN (SELECT idArticulo FROM 3005_articulosBoletin WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia.") ORDER BY tituloArticulo";
		$arrRegistro=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistro).'}';
	}
	
	function registrarArticulosBoletin()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$arrArticulo=explode(",",$obj->listArticulo);
		foreach($arrArticulo as $iA)
		{
			$consulta[$x]="INSERT INTO 3005_articulosBoletin(idFormulario,idReferencia,idArticulo,idSeccion)
							VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$iA.",".$obj->idSeccion.")";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function obtenerPublicacionesBoletin()
	{
		global $con;
		$arrPublicaciones=array();
		$consulta="SELECT v.volumenTxt,anoVolumen,tituloPublicacion,fechaInicio,numeroBoletin,id__763_tablaDinamica FROM _763_tablaDinamica b,_759_tablaDinamica v WHERE b.idEstado=2 AND v.id__759_tablaDinamica=b.volumen ORDER BY anoVolumen,volumenTxt,numeroBoletin";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			if(!isset($arrPublicaciones[$fila[1]]))
				$arrPublicaciones[$fila[1]]=array();
			$obj["volumen"]=$fila[0];
			$obj["anoVolumen"]=$fila[1];
			$obj["tituloPublicacion"]=$fila[2];
			$obj["fechaInicio"]=$fila[3];
			$obj["numeroBoletin"]=$fila[4];
			$obj["idBoletin"]=$fila[5];
			array_push($arrPublicaciones[$fila[1]],$obj);
		}
		$cadPublicaciones="";
		if(sizeof($arrPublicaciones))
		{
			foreach($arrPublicaciones as $anio=>$resto)
			{
				$arrHijos="";
				foreach($resto as $publicacion)
				{
					$lblText="(".date("Y-m-d",strtotime($publicacion["fechaInicio"])).') Volumen '.$publicacion["volumen"].', Número '.$publicacion["numeroBoletin"].' <b>'.cv($publicacion["tituloPublicacion"])."</b>";
					$lblText2="(".date("Y-m-d",strtotime($publicacion["fechaInicio"])).') Volumen '.$publicacion["volumen"].', Número '.$publicacion["numeroBoletin"].' '.cv($publicacion["tituloPublicacion"])."";
					$oP='{"tipo":"2","link":"'.generarLinkBoletin($publicacion["idBoletin"]).'","icon":"../images/icon_documents.gif","id":"'.$publicacion["idBoletin"].'","text":"<span title=\''.$lblText2.'\' alt=\''.$lblText2.'\'>'.$lblText.'</span>","leaf":true}';
					if($arrHijos=="")
						$arrHijos=$oP;
					else
						$arrHijos.=",".$oP;
				}
				$oPublicacion='{"icon":"../images/bullet_green.png","id":"a'.$anio.'","text":"<b>Año:</b> '.$anio.'","tipo":"1","leaf":false,children:['.$arrHijos.']}';
				if($cadPublicaciones=="")
					$cadPublicaciones=$oPublicacion;
				else
					$cadPublicaciones.=",".$oPublicacion;
			}
		}
		echo '['.$cadPublicaciones.']';
	}
	
	function obtenerVacantesPorEmpresa()
	{
		global $con;
		$cad='';
		$tVacantes=0;
		$consulta="SELECT DISTINCT t.codigoInstitucion,o.unidad FROM _771_tablaDinamica t,817_organigrama o WHERE idEstado=2 AND o.codigoUnidad=t.codigoInstitucion ORDER BY unidad";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select count(*) from _771_tablaDinamica where codigoInstitucion='".$fila[0]."' and idEstado=2";
			$nReg=$con->obtenerValor($consulta);
			$o='{"icon":"../images/user_gray.png","id":"'.$fila[0].'","text":"'.cv($fila[1]).' ('.$nReg.')","tipo":"2",leaf:true}';
			if($cad=='')
				$cad=$o;
			else
				$cad.=",".$o;
			$tVacantes++;
		}
		if($tVacantes>0)
			$objFinal='{"icon":"../images/vcard.png","id":"0","tipo":"1","text":"<b>Vacantes por empresa ('.$tVacantes.')</b>","children":['.$cad.'],"leaf":false}';
		else
			$objFinal='{"icon":"../images/vcard.png","id":"0","tipo":"1","text":"<b>Vacantes por empresa ('.$tVacantes.')</b>","leaf":true}';
		echo '['.$objFinal.']';
		
	}
	
	function obtenerVacantesPorCategoria()
	{
		global $con;
		$cad='';
		$tVacantes=0;
		$consulta="SELECT DISTINCT c.id__772_tablaDinamica,c.nombreCategoria FROM _771_tablaDinamica t,_772_tablaDinamica c WHERE c.id__772_tablaDinamica=t.nombreCategoria and t.idEstado=2  ORDER BY c.nombreCategoria";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select count(*) from _771_tablaDinamica where nombreCategoria=".$fila[0]." and idEstado=2";
			$nReg=$con->obtenerValor($consulta);
			$o='{"icon":"../images/user_gray.png","id":"'.$fila[0].'","text":"'.cv($fila[1]).' ('.$nReg.')","tipo":"3",leaf:true}';
			if($cad=='')
				$cad=$o;
			else
				$cad.=",".$o;
			$tVacantes++;
		}
		if($tVacantes>0)
			$objFinal='{"icon":"../images/vcard.png","id":"0","tipo":"1","text":"<b>Vacantes por categoría ('.$tVacantes.')</b>","children":['.$cad.'],"leaf":false}';
		else
			$objFinal='{"icon":"../images/vcard.png","id":"0","tipo":"1","text":"<b>Vacantes por categoría ('.$tVacantes.')</b>","leaf":true}';
		echo '['.$objFinal.']';
	}
	
	function obtenerDatosAccesoEmpresa()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT codigoInstitucion FROM _716_tablaDinamica WHERE id__716_tablaDinamica=".$idRegistro;
		$institucion=$con->obtenerValor($consulta);
		$consulta="SELECT Login,PASSWORD FROM 800_usuarios u,801_adscripcion a WHERE u.idUsuario=a.idUsuario AND a.Institucion='".$institucion."'";
		$fLogin=$con->obtenerPrimeraFila($consulta);
		if($fLogin)
		{
			echo "1|".$fLogin[0]."|".$fLogin[1];
		}
		else
			echo "No cuenta con datos de acceso";
	}
?>