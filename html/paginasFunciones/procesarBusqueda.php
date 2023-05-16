<?php
	session_start();
	;
	include("conexionBD.php"); 
	include_once("conectoresAccesoDatos/administradorConexiones.php"); 
	$parametros="";
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	switch($funcion)
	{
		case 1: 
			realizarBusqueda();
		break;
		case 2:
			buscarProducto();
		break;
	}
	
	function realizarBusqueda()
	{
		global $con;
		global $SO;
		$criterio=$_POST["criterio"];
		$idGrupoControl=$_POST["idGrupoControl"];
		$consulta="select * from 904_configuracionElemFormulario where idElemFormulario=".$idGrupoControl;
		$fila=$con->obtenerPrimeraFila($consulta);
		$idAlmacen=$fila[2];
		if(strpos($idAlmacen,"[")!==false)
		{

			$qy=bD($_POST["qy"]);
			
			
			
			$idAlmacen=str_replace("[","",$idAlmacen);
			$idAlmacen=str_replace("]","",$idAlmacen);

			$arrProy=obtenerCamposProyeccionQuery($qy);
			
			
			$partProyeccion="";
			foreach($arrProy as $campoProy)
			{
				
				if($partProyeccion=="")
				{
					if(strpos($campoProy," as ")===false)
						$partProyeccion=$campoProy." as '".str_replace(".","_",$campoProy)."'";
					else
						$partProyeccion=$campoProy;
				}
				else
				{
					if(strpos($campoProy," as ")===false)
						$partProyeccion.=",".$campoProy." as '".str_replace(".","_",$campoProy)."'";
					else
						$partProyeccion.=",".$campoProy;
				}
			}
			$partQuery=explode(" from ",$qy);
			
			
			
			$qy="select ".$partProyeccion." from ".$partQuery[1];
			
			$campoID=$fila[4];
			$buscarSobreCampo=false;
			$criterioBusqueda=2;
			if($buscarSobreCampo)
			{
				switch($criterioBusqueda)
				{
					case 1:
						$criterio=$criterio.'%';
					break;
					case 2:
						$criterio='%'.$criterio.'%';
					break;
					case 3:
						$criterio='%'.$criterio;
					break;	
				}
				$consulta="select * from (".$qy.") as tmp where ".str_replace(".","___",$fila[10])." like '".$criterio."'";
			}
			else
				$consulta=$qy;
			
			$conTmp="SELECT idConexion FROM 9014_almacenesDatos WHERE idDataSet=".$idAlmacen;
			$idConexion=$con->obtenerValor($conTmp);	
				
			$conAux=$con;	
			if($idConexion!=0)
			{
				$conAux=generarInstanciaConector($idConexion);
			}
				
				
	
			$resQuery=$conAux->obtenerFilas($consulta);
			$arrCamposProy=explode('@@',$fila[3]);
			
			$nFilas=0;
			$arrJSON="";
			$arrRegistros=array();
			$cadFinalMinus="";
			$criterioMinus=strtolower($criterio);
			
			while($fila=$conAux->obtenerSiguienteFilaAsoc($resQuery))
			{
				
				$textoProy="";
				foreach($arrCamposProy as $campo)
				{
					$cNormalizado=str_replace(".","_",$campo);
					
					
					//echo "----".$cNormalizado."<br><br>".var_dump(isset($fila[$cNormalizado]))."<br><br><br><br>-----";
					
					if(isset($fila[$cNormalizado]))
					{
						
						$textoProy.=trim($fila[$cNormalizado]);
					}
					else	
					{
						
						$textoProy.=str_replace("'","",$campo);
					}
				}
				$cadFinal=str_replace("'","\'",str_replace("' '"," ",$textoProy));
				$cadFinalMinus=strtolower($cadFinal);
				$considerarOpcion=false;
				

				
				if(!$buscarSobreCampo)
				{
					switch($criterioBusqueda)
					{
						case 1:
							$pos=strpos($cadFinalMinus,trim($criterioMinus));
							if($pos===0)
							{
								$subCriterio=substr($cadFinal,$pos,strlen($criterio));
								$cadFinal=str_ireplace($criterio,"<b><font color=black>".$subCriterio."</font></b>",$cadFinal);
								$considerarOpcion=true;
								$nFilas++;
							}
						break;
						case 2:

							$pos=strpos($cadFinalMinus,trim($criterioMinus));
							if($pos!==false)
							{
								$subCriterio=substr($cadFinal,$pos,strlen($criterio));
								$cadFinal=str_ireplace($criterio,"<b><font color=black>".$subCriterio."</font></b>",$cadFinal);
								$considerarOpcion=true;
								$nFilas++;
							}
						break;
						case 3:
							$ultimoSegmento=substr($cadFinalMinus,strlen(trim($cadFinalMinus))-strlen(trim($criterioMinus)));
							if($ultimoSegmento==$criterioMinus)
							{
								$cadFinal=str_ireplace($criterio,"<b><font color=black>".$ultimoSegmento."</font></b>",$cadFinal);
								$considerarOpcion=true;
								$nFilas++;
							}
						break;	
					}
					
				}
				else
					$considerarOpcion=true;

				if($considerarOpcion)
				{
					$cNormalizado=str_replace(".","_",$campoID);
					
					$arrRegistros[$cadFinalMinus."_".$fila[$cNormalizado]]["idOpcion"]=$fila[$cNormalizado];
					$arrRegistros[$cadFinalMinus."_".$fila[$cNormalizado]]["valor"]=cvJs($cadFinal);
				}
			}
			ksort($arrRegistros);
			if(sizeof($arrRegistros)>0)
			{
				foreach($arrRegistros as $dRegistro => $datos)
				{
					
					$obj='{"id":"'.$datos["idOpcion"].'","valor":"'.strip_tags($datos["valor"]).'","valorComp":"'.cv($datos["valor"]).'"}';
					if($arrJSON=="")
						$arrJSON=$obj;
					else
						$arrJSON.=",".$obj;
				}
			}
			if($SO==1)
				echo '{"num":"'.$nFilas.'","objetos":['.($arrJSON).']}';
			else
				echo '{"num":"'.$nFilas.'","objetos":['.uEJ($arrJSON).']}';
		}
		else
		{

			$consulta="select * from (select ".$fila[4]." as id,concat(".$fila[3].") as valor from ".$fila[2]." where ".$fila[10]." like '".$criterio."%') as tmp order by valor";
			$arrJSON=$con->obtenerFilasJson($consulta);
			if($SO==1)
				echo '{"num":"'.$con->filasAfectadas.'","objetos":['.utf8_encode($arrJSON).']}';
			else
				echo '{"num":"'.$con->filasAfectadas.'","objetos":['.uEJ($arrJSON).']}';
		}
	}
	
	
	function buscarProducto()
	{
		global $con;	
		$idProceso=$_POST["idProceso"];
		$idFormulario=obtenerFormularioBase($idProceso);
		$criterio=$_POST["criterio"];
		$idUsuario=$_SESSION["idUsr"];
		$arrObj="";
		$nReg=0;
		$consulta="(SELECT idReferencia FROM 246_autoresVSProyecto WHERE idUsuario=".$idUsuario." AND idFormulario=".$idFormulario.") union (SELECT idRegistro FROM 9202_accionesSolicitudUsuario WHERE idFormulario=".$idFormulario." 
				AND idUsuario=".$idUsuario." AND estado=1 AND accion=5)";
		$listRegistros=$con->obtenerListaValores($consulta);
		if($listRegistros=="")
			$listRegistros="-1";
		
		
		switch($idProceso)
		{
			case 96:
				$consulta="SELECT id__153_tablaDinamica,txtTituloRev,AnoFLD,d561.Titulo AS 'tituloRevista',VolumeFLD,NumFLD FROM _153_tablaDinamica d153,_561_tablaDinamica d561 
							WHERE d561.id__561_tablaDinamica=d153.cmbRevistas AND d153.txtTituloRev LIKE '%".$criterio."%' and id__153_tablaDinamica not in (".$listRegistros.") order by txtTituloRev";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$ficha='<table><tr><td valign=\'top\' class=\'letraRojaSubrayada8\'>Artículo:</td><td valign=\'top\' class=\'letraFicha\'>'.cvJs($fila[1]).'</td></tr><tr><td valign=\'top\'class=\'letraRojaSubrayada8\'>Año de publicación:</td><td valign=\'top\'class=\'letraFicha\'>'.$fila[2].'</td></tr><tr><td valign=\'top\'class=\'letraRojaSubrayada8\'>Revista:</td><td valign=\'top\'  class=\'letraFicha\'>'.cvJs($fila[3]).'</td></tr><tr><td valign=\'top\' class=\'letraRojaSubrayada8\'>Volumen / Número:</td><td class=\'letraFicha\'>'.$fila[4].'/ '.$fila[5].'</td></tr></table>';
					$obj='{"id":"'.$fila[0].'","valor":"'.cvJs($fila[1]).'","ficha":"'.$ficha.'"}';	
					if($arrObj=="")
						$arrObj=$obj;
					else
						$arrObj.=",".$obj;
					$nReg++;
				}
				
			break;
			case 109:
				$consulta="SELECT id__179_tablaDinamica,nombreCapitulo,txtAnio,Titulo,editorial,clas FROM _179_tablaDinamica 
							WHERE Titulo LIKE '%".$criterio."%' and id__179_tablaDinamica not in (".$listRegistros.") order by Titulo";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$tCap=$fila[1];
					if($fila[5]==1)
						$tCap="N/A";
					$ficha='	<table><tr><td class=\'letraRojaSubrayada8\'>Título libro:</td><td class=\'letraFicha\'>'.cvJs($fila[3]).'</td></tr><tr><td class=\'letraRojaSubrayada8\'>Título capítulo:</td><td class=\'letraFicha\'>'.cvJs($tCap).'</td></tr><tr><td class=\'letraRojaSubrayada8\'>Año de publicación:</td><td class=\'letraFicha\'>'.$fila[2].'</td></tr><tr><td class=\'letraRojaSubrayada8\'>Editorial:</td><td class=\'letraFicha\'>'.cvJs($fila[4]).'</td></tr></table>';
					$obj='{"id":"'.$fila[0].'","valor":"'.cvJs($fila[1]).'","ficha":"'.$ficha.'"}';	
					if($arrObj=="")
						$arrObj=$obj;
					else
						$arrObj.=",".$obj;
					$nReg++;
				}
			
			break;
			case 102:
				$consulta="SELECT id__172_tablaDinamica,Titulo,fellow,monto,
							(SELECT tituloProyecto FROM _278_tablaDinamica WHERE id__278_tablaDinamica=t.Proyecto)AS 'Proyecto',anio FROM _172_tablaDinamica t where t.fellow like '%".$criterio."%' and id__172_tablaDinamica not in (".$listRegistros.")";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$ficha='<table><tr><td class=\'letraRojaSubrayada8\'>Nombre del financiamiento:</td><td class=\'letraFicha\'>'.cvJs($fila[2]).'</td></tr><tr><td class=\'letraRojaSubrayada8\'>Año del financiamiento:</td><td class=\'letraFicha\'>'.$fila[5].'</td></tr><tr><td class=\'letraRojaSubrayada8\'>Institución:</td><td class=\'letraFicha\'>'.cvJs($fila[1]).'</td></tr><tr><td class=\'letraRojaSubrayada8\'>Monto:</td><td class=\'letraFicha\'>$ '.number_format($fila[3],2,'.',',').'</td></tr></table>';
					$obj='{"id":"'.$fila[0].'","valor":"'.cvJs($fila[2]).'","ficha":"'.$ficha.'"}';	
					if($arrObj=="")
						$arrObj=$obj;
					else
						$arrObj.=",".$obj;
					$nReg++;
				}
			break;
			case 106:
			
			break;
			case 99:
				$consulta="SELECT id__163_tablaDinamica,txtTitulo,institucion,Programa FROM _163_tablaDinamica t	WHERE t.txtTitulo LIKE '%".$criterio."%' and id__163_tablaDinamica not in (".$listRegistros.") order by txtTitulo";
				$res=$con->obtenerFilas($consulta);
				while($fila=mysql_fetch_row($res))
				{
					$ficha='<table><tr><td valign=\'top\' class=\'letraRojaSubrayada8\'>Tesis:</td><td valign=\'top\' class=\'letraFicha\'>'.cvJs($fila[1]).'</td></tr><tr><td valign=\'top\'class=\'letraRojaSubrayada8\'>Institución:</td><td valign=\'top\'class=\'letraFicha\'>'.cvJs($fila[2]).'</td></tr><tr><td valign=\'top\'class=\'letraRojaSubrayada8\'>Programa:</td><td valign=\'top\'  class=\'letraFicha\'>'.cvJs($fila[3]).'</td></tr></table>';
					$obj='{"id":"'.$fila[0].'","valor":"'.cvJs($fila[1]).'","ficha":"'.$ficha.'"}';	
					if($arrObj=="")
						$arrObj=$obj;
					else
						$arrObj.=",".$obj;
					$nReg++;
				}
			break;	
		}
		echo '{"num":"'.$nReg.'",objetos:['.$arrObj.']}';
		
		
	}