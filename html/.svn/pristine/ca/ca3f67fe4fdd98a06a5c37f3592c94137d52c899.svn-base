<?php session_start();
	include("conexionBD.php");
	include_once("diccionarioTerminos.php");
	$parametros="";
	$funcion="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
	}	
	switch($funcion)
	{
		case 1:
			agregarCalculoGrid();
		break;
		case 2:
			eliminarElementosCalculoGrid();
		break;
		case 3:
			modificarMonto();
		break;
		case 4:
			actualizarCalguloGrid();
		break;
		case 5:
			guardarComentarioPresupuesto();
		break;
		case 6:
			guardarDictamenPresupuesto();
		break;
		case 7:
			guardarConceptoGridPresupuesto();
		break;
		case 8:
			eliminarElementosConceptoGridPresupuesto();
		break;
		case 9:
			guardarDistribucionPresupuesto();
		break;
		case 10:
			guardarAjustePresupuestal();
		break;
		case 11:
			obtenerSesionesAfectacion();
		break;
		case 12:
			guardarSesionesAfectadas();
		break;
		
		case 13:
			obtenerFaltasReposicionHora();
		break;
		case 14:
			registrarReposicionHora();
		break;
		case 15:
			guardarPreguntasPresupuesto();
		break;
		case 16:
			guardarPrimerasPreguntasPresupuesto();
		break;
		case 17:
			obtenerPresupuestoRegistro();
		break;
		case 18:
			guardarPresupuestoRegistro();
		break;
		case 19:
			cancelarOperacion();
		break;
		case 20:
			obtenerPresupuestoInstitucion();
		break;
		case 21:
			guardarPresupuestoInstitucion();
		break;
		case 22:
			cancelarOperacionInstitucion();
		break;
		case 23:
			obtenerInstitucionesPatrocinadoras();
		break;
		case 24:
			obtenerInstitucionesPatrocinadorasNuevas();
		break;
		case 25:
			reemplazarInstitucionesPatrocinadora();
		break;
		case 26:
			removerInstitucionPatrocinadora();
		break;
		case 27:
			obtenerSesionesAfectacionComison();
		break;
		case 28:
			obtenerDescuentosBecasPromociones();
		break;
		case 29:
			registrarDescuentoBecasPromocionInscripcion();
		break;
		case 30:
			buscarCodigoRevalidacion();
		break;
		case 31:
			buscarDatosIDCodigoRevalidacion();
		break;
		case 32:
			buscarDatosAlumnoCobroServicios();
		break;
	}
	
	function agregarCalculoGrid()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$idRubro=$_POST["idRubro"];
		$calculo=$_POST["calculo"];
		$idConcepto=$_POST["idConcepto"];
		$costoUnitario=$_POST["costoUnitario"];
		$cantidad=$_POST["cantidad"];
		$id=$_POST["id"];
		
		$total=$costoUnitario*$cantidad;
		if($id=="-1")
		{
			$query="INSERT INTO 100_calculosGrid(idFormulario,idReferencia,calculo,costoUnitario,cantidad,total,idRubro,idConcepto) 
					VALUES(".$idFormulario.",".$idRegistro.",'".$calculo."',".$costoUnitario.",".$cantidad.",".$total.",".$idRubro.",".$idConcepto.")";
		}
		else
		{
			$query="UPDATE 100_calculosGrid SET idConcepto=".$idConcepto.",calculo='".$calculo."',costoUnitario=".$costoUnitario.",cantidad=".$cantidad.",total=".$total." WHERE idGridVSCalculo=".$id;
		}
		
		if ($con->ejecutarConsulta($query))
		{
			if($id==-1)
			{
				$id=$con->obtenerUltimoID();				
				$consulta="INSERT INTO 1049_presupuestoAutorizado2015(idConcepto,costoUnitario,cantidad,total,idFormulario,idReferencia,idRubro)
						VALUES(".$id.",".$costoUnitario.",".$cantidad.",".$total.",".$idFormulario.",".$idRegistro.",".$idRubro.")";
				$con->ejecutarConsulta($consulta);
				
			}
			else
			{
				$consulta="update 1049_presupuestoAutorizado2015 set costoUnitario=".$costoUnitario.",cantidad=".$cantidad.
							",total=".$total." where idConcepto=".$id;

				$con->ejecutarConsulta($consulta);
			}
			echo "1|".$id;
		}
		else
			echo "|";
	}
	
	function actualizarCalguloGrid()
	{
		global $con;
		$id=$_POST["id"];
		$montoAut=$_POST["montoAut"];
		$query="UPDATE 100_calculosGrid SET montoAutorizado=".$montoAut." WHERE idGridVSCalculo=".$id;
		eC($query);
	}
	
	function eliminarElementosCalculoGrid()
	{
		global $con;
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				/*$query[$ct]="update 100_calculosGrid set eliminado=cantidad WHERE idGridVSCalculo=".$arreglo[$x];
				$ct++;
				$query[$ct]="update 100_calculosGrid set cantidad=0,total=0 WHERE idGridVSCalculo=".$arreglo[$x];
				$ct++;*/
				$query[$ct]="delete from 100_calculosGrid WHERE idGridVSCalculo=".$arreglo[$x];
				$ct++;
				$query[$ct]="delete from 1049_presupuestoAutorizado2015 WHERE idConcepto=".$arreglo[$x];
				$ct++;
				
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
		else
		{
			echo "|";
		}
	}
	
	function modificarMonto()
	{
		global $con;
		$monto=$_POST["monto"];
		$tMonto=$_POST["tMonto"];
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="select * from 100_montosVarios where idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
		$fila=$con->obtenerPrimeraFila($query);
		if(!$fila)
		{
			$consulta[$x]="insert into 100_montosVarios(idFormulario,idReferencia,montoOrganizacion,montoDonante)
							values(".$idFormulario.",".$idReferencia.",0,0)";
			$x++;
		}
		$campo="";
		switch($tMonto)
		{
			case 1:
				$campo="montoOrganizacion";
			break;
			case 2:
				$campo="montoDonante";
			break;	
		}
		$consulta[$x]="update 100_montosVarios set ".$campo."=".$monto." where idFormulario=".$idFormulario." and idReferencia=".$idReferencia;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarComentarioPresupuesto()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$comentario=$_POST["comentario"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 1014_comentariosPresupuesto where idProyecto=".$idProyecto;
		$x++;
		$consulta[$x]="insert into 1014_comentariosPresupuesto(comentario,idProyecto) values('".cv($comentario)."',".$idProyecto.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function guardarDictamenPresupuesto()
	{
		global $con;
		$idProyecto=$_POST["idProyecto"];
		$dictamen=$_POST["dictamen"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 1012_dictamenesProyectos where idReferencia=".$idProyecto." and tipoDictamen=1";
		$x++;
		$consulta[$x]="INSERT INTO 1012_dictamenesProyectos(idFormulario,idReferencia,dictamen,fechaDictamen,idResponsable,tipoDictamen)
						VALUES(293,".$idProyecto.",".$dictamen.",'".date("Y-m-d")."',".$_SESSION["idUsr"].",1)"	;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);						
	}
	
	function guardarConceptoGridPresupuesto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);	
		if($obj->idMonto=="-1")
		{
			$query="INSERT INTO 100_gridPresupuesto(idFormulario,idReferencia,concepto,costoUnitario,cantidad,total,idRubro) 
					VALUES(".$obj->idFormulario.",".$obj->idRegistro.",'".cv($obj->concepto)."',".$obj->costoUnitario.",".$obj->cantidad.",".$obj->total.",".$obj->idRubro.")";
		}
		else
		{
			$query="UPDATE 100_gridPresupuesto SET concepto='".cv($obj->concepto)."',costoUnitario=".$obj->costoUnitario.",cantidad=".$obj->cantidad.",total=".$obj->total." WHERE idGridVSCalculo=".$obj->idMonto;
		}
		
		if ($con->ejecutarConsulta($query))
		{
			if($obj->idMonto==-1)
				$obj->idMonto=$con->obtenerUltimoID();
			echo "1|".$obj->idMonto;
		}
		else
			echo "|";
	}
	
	function eliminarElementosConceptoGridPresupuesto()
	{
		global $con;
		$cadena=$_POST["cadena"];
		$arreglo=explode(",",$cadena);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		
		if($con->ejecutarConsulta($consulta))
		{
			$ct=0;
			for($x=0;$x<$tamano;$x++)
			{
				
				$query[$ct]="delete from 100_gridPresupuesto WHERE idGridVSCalculo=".$arreglo[$x];
				$ct++;
			}
			
			$query[$ct]="commit";
			if($con->ejecutarBloque($query))
				echo "1|";
			else
				echo "|";
		}
		else
		{
			echo "|";
		}
	}
	
	function guardarDistribucionPresupuesto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		if($obj->t1=="")
			$obj->t1=0;
		if($obj->t2=="")
			$obj->t2=0;
		if($obj->t3=="")
			$obj->t3=0;	
		if($obj->t4=="")
			$obj->t4=0;			
		if($obj->idAnioPresupuesto=="-1")
			$consulta="INSERT INTO 100_anioPresupuestoDistribucion(idFormulario,idRegistro,nAnio,trimestre1,trimestre2,trimestre3,trimestre4)
					VALUES(".$obj->idFormulario.",".$obj->idRegistro.",".$obj->nAnio.",".$obj->t1.",".$obj->t2.",".$obj->t3.",".$obj->t4.")";
		else
			$consulta="update 100_anioPresupuestoDistribucion set trimestre1=".$obj->t1.",trimestre2=".$obj->t2.",trimestre3=".$obj->t3.",trimestre4=".$obj->t4."
					where idAnioPresupuesto=".$obj->idAnioPresupuesto;
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idAnioPresupuesto==-1)
				$obj->idAnioPresupuesto=$con->obtenerUltimoID();
			echo "1|".$obj->idAnioPresupuesto;
		}
	}
	
	function guardarAjustePresupuestal()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$query="SELECT idFormulario,idReferencia FROM 100_calculosGrid WHERE idGridVSCalculo=".$obj->idConceptoO;
		$fRegistro=$con->obtenerPrimeraFila($query);
		$idFormulario=$fRegistro[0];
		$idRegistro=$fRegistro[1];
		$consulta[$x]="UPDATE 100_calculosGrid SET montoAutorizado=montoAutorizado-".$obj->monto." WHERE idGridVSCalculo=".$obj->idConceptoO;
		$x++;
		if(isset($obj->idConceptoD))
		{
			$consulta[$x]="UPDATE 100_calculosGrid SET montoAutorizado=montoAutorizado+".$obj->monto." WHERE idGridVSCalculo=".$obj->idConceptoD;
			$x++;
			$consulta[$x]="set @idConceptoDestino:=".$obj->idConceptoD;
			$x++;
		}
		else
		{
			$consulta[$x]="INSERT INTO 100_calculosGrid(idFormulario,idReferencia,calculo,costoUnitario,cantidad,total,idRubro,montoAutorizado)
						VALUES(".$idFormulario.",".$idRegistro.",'".cv($obj->nConcepto)."',".$obj->monto.",".$obj->cantidad.",".$obj->monto.",".$obj->idCategoria.",".$obj->monto.")";
			$x++;
			$consulta[$x]="set @idConceptoDestino:=(select last_insert_id())";
			$x++;
		}
		$consulta[$x]="INSERT INTO 100_ajustesPresupuestales(montoAjuste,idConceptoOrigen,idConceptoDestino,fechaMovimiento,idUsuarioResp,idFormulario,idReferencia)
						VALUES(".$obj->monto.",".$obj->idConceptoO.",@idConceptoDestino,'".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$idFormulario.",".$idRegistro.")";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function obtenerSesionesAfectacion()
	{
		global $con;
		global $dic;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$deshabilitado="false";
		$sL=$_POST["sL"];
		if($sL==1)
			$deshabilitado="true";
			
			
		$consulta="select cmbSiNo from _484_tablaDinamica";
		$permiteRegistroFechasPrevias=$con->obtenerValor($consulta);	
			
		$consulta="SELECT idRegistroModuloSesionesClase FROM 4560_registroModuloSesionesClase WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$idRegistro=-1;
		
		$consulta="SELECT dteFechaInicial,dteFechaFinal,cmbDocentes,codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idReferencia;
		$filaReg=$con->obtenerPrimeraFila($consulta);
		$cadRegistros="";
		$consulta="SELECT idGrupo,g.nombreGrupo,m.nombreMateria,idInstanciaPlanEstudio FROM 4519_asignacionProfesorGrupo a,4520_grupos g,4502_Materias m 
					WHERE idUsuario=".$filaReg[2]." AND  a.fechaAsignacion and (('".$filaReg[0]."'>=a.fechaAsignacion and '".$filaReg[0]."'<=a.fechaBaja) or ('".$filaReg[1]."'>=a.fechaAsignacion and '".$filaReg[1]."'<=a.fechaBaja)  
					or ('".$filaReg[0]."'<=a.fechaAsignacion and '".$filaReg[1]."'>=a.fechaBaja)) and g.idGrupos=a.idGrupo and m.idMateria=g.idMateria and g.Plantel='".$filaReg[3]."'"; 
		$resGrupos=$con->obtenerFilas($consulta);
		$ct=0;
		$arrFechas=array();
		$arrGrupos=array();
		$listGrupos="";
		while($fila=mysql_fetch_row($resGrupos))
		{
			$arrGrupos[$fila[0]]=$fila;
			if($listGrupos=="")
				$listGrupos=$fila[0];
			else
				$listGrupos.=",".$fila[0];
		}
		if($listGrupos=="")
			$listGrupos=-1;	
			
		
		$consulta="SELECT noSesion,fechaSesion,horario,idGrupo FROM  4530_sesiones WHERE idGrupo in (".$listGrupos.") AND 
				fechaSesion>='".$filaReg[0]."' AND fechaSesion<='".$filaReg[1]."' order by fechaSesion,horario";

		$res=$con->obtenerFilas($consulta);
		while($fSesion=mysql_fetch_row($res))
		{
			$fila=$arrGrupos[$fSesion[3]];
			$arrSesion=explode(",",$fSesion[2]);
			$nInstancia=obtenerNombreInstanciaPlan($fila[3]);
			$tool=$dic["planEstudio"]["s"]["et"].": ".$nInstancia;
			foreach($arrSesion as $s)
			{
				$consulta="SELECT COUNT(*) FROM 4519_asignacionProfesorGrupo WHERE idGrupo=".$fSesion[3]." AND idUsuario=".$filaReg[2]." AND fechaAsignacion<='".$fSesion[1]."' AND fechabaja>='".$fSesion[1]."'";
				$nReg=$con->obtenerValor($consulta);
				
				if($nReg==0)
					continue;

				$dSesion=explode(" - ",$s);
				$lblComision="";
				$lblCheck="";
				$yaComisionada=false;
					
					
				$consulta="SELECT COUNT(*) FROM 4561_sesionesClaseModulo WHERE idGrupo=".$fSesion[3]." AND fechaSesion='".$fSesion[1]."' AND horaInicioBloque='".trim($dSesion[0])."' AND horaFinBloque='".trim($dSesion[1])."' AND idReferencia=".$idRegistro;
				$nReg=$con->obtenerValor($consulta);
				$checado="false";
				if($nReg>0)
					$checado="true";
				else
				{
					$consulta="SELECT COUNT(*) FROM 4561_sesionesClaseModulo WHERE idGrupo=".$fSesion[3]." AND fechaSesion='".$fSesion[1]."' AND horaInicioBloque='".trim($dSesion[0])."' AND horaFinBloque='".trim($dSesion[1])."' AND idReferencia<>".$idRegistro;
					$nReg=$con->obtenerValor($consulta);
					$checado="false";
					if($nReg>0)
					{
						$yaComisionada=true;
						$lblComision="(<span style='color:#FF0000'>Sesión ya comisionada, no se permite comisionar nuevamente</span>) ";
					}
					else
					{
						$consulta="SELECT pagado,(SELECT folioNomina FROM 672_nominasEjecutadas WHERE idNomina=c.idNomina),c.estadoFalta  FROM 4559_controlDeFalta c WHERE idGrupo=".$fSesion[3]." 
								AND fechaFalta='".$fSesion[1]."' AND horaInicial='".trim($dSesion[0])."'";	
						
						$fFalta=$con->obtenerPrimeraFila($consulta);		
						if($fFalta)
						{
							if($fFalta[0]==1)
							{
								$yaComisionada=true;
								$lblComision="(<span style='color:#FF0000'>Falta considerada en la nómina: ".$fFalta[1].", la cual se encuentra cerrada</span>) ";
							}
							else
							{
								if($fFalta[2]==1)
								{
									$yaComisionada=false;
									$lblComision="(<span style='color:#FF0000'>Falta justificada</span>) ";
								}
							}
						}
						else
						{
							$consulta="SELECT e.etapa,e.folioNomina FROM 4556_costoHoraDocentes c,672_nominasEjecutadas e WHERE idGrupo=".$fSesion[3]." AND 
										fechasesion='".$fSesion[1]."' AND horaInicioBloque='".trim($dSesion[0])."' AND e.idNomina=c.idNomina and c.fechasesion<=e.fechaCorteAsistencia";
							$fNomina=$con->obtenerPrimeraFila($consulta);

							if(($fNomina)&&(($fNomina[0]!=1)&&($fNomina[0]!=200)))	
							{
								$yaComisionada=true;
								$lblComision="(<span style='color:#FF0000'>Sesión considerada en la nómina: ".$fNomina[1].", la cual se encuentra cerrada</span>) ";
							}
						}
						
						
								
					}
				}
				
				if(!$yaComisionada)
					$lblCheck='checked:'.$checado.',';
				
				$obj='{disabled:'.$deshabilitado.',listeners:{checkchange:nodoCheck},icon:"../images/s.gif",idGrupo:"'.$fila[0].'",qtip :"'.$tool.'",fecha:"'.$fSesion[1].'",horaInicio:"'.trim($dSesion[0]).'",horaFin:"'.trim($dSesion[1]).'",noSesion:"'.$fSesion[0].'", id:"'.$ct.'",text:"<b>Sesi&oacute;n '.
						$fSesion[0].'</b> '.$lblComision.'de '.date("H:i",strtotime(trim($dSesion[0]))).' a '.date("H:i",strtotime(trim($dSesion[1]))).',<b>'.$dic["grupo"]["s"]["et"].':</b> '.$fila[1].', <b>'.$dic["materia"]["s"]["et"].':</b> '.$fila[2].'",draggable:false,'.$lblCheck.'editable:true,leaf:true}';
				if(!isset($arrFechas[$fSesion[1]]))
					$arrFechas[$fSesion[1]]=array();
				array_push($arrFechas[$fSesion[1]],$obj);
					
				$ct++;
			}
				
			$cadRegistros="";
			foreach($arrFechas as $fecha=>$resto)
			{
				$cadSesiones="";
				foreach($resto as $o)
				{
					if($cadSesiones=="")
						$cadSesiones=$o;
					else
						$cadSesiones.=",".$o;
				}
				$objGrupo='{disabled:'.$deshabilitado.',listeners:{checkchange:nodoCheck},icon:"../images/s.gif",id:"'.$ct.'",text:"<span class=\'letraRojaSubrayada8\' style=\'color:#900 !important\'> '.date("d/m/Y",strtotime($fecha)).'</span>",draggable:false,checked:false,editable:false,leaf:false,children:['.$cadSesiones.']}';
				if($cadRegistros=="")
					$cadRegistros=$objGrupo;
				else
					$cadRegistros.=",".$objGrupo;
				$ct++;
			}
			
		}
	
		echo "[".$cadRegistros."]";
	}
	
	function guardarSesionesAfectadas()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="SELECT idRegistroModuloSesionesClase FROM 4560_registroModuloSesionesClase WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")	
		{
			$consulta="insert into 4560_registroModuloSesionesClase(idFormulario,idReferencia,fechaRegistro) values(".$obj->idFormulario.",".$obj->idReferencia.",'".date("Y-m-d H:i")."')";
			if(!$con->ejecutarConsulta($consulta))
				return;
			$idRegistro=$con->obtenerUltimoID();
		}
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="delete from  4561_sesionesClaseModulo where idReferencia=".$idRegistro;
		$x++;
		
		foreach($obj->arrSesiones as $s)
		{
			$query[$x]="INSERT INTO 4561_sesionesClaseModulo(idGrupo,horaInicioBloque,horaFinBloque,fechaSesion,noSesion,idReferencia)
						VALUES(".$s->idGrupo.",'".$s->hInicio."','".$s->hFin."','".$s->fechaSesion."',".$s->noSesion.",".$idRegistro.")";
			$x++;
		}
		
		
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function obtenerFaltasReposicionHora()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$consulta="SELECT idFalta,idGrupo,fechaFalta,CONCAT(horaInicial,'-',horaFinal) AS horaFalta,
					CONCAT('<b>Grupo: </b>',g.nombreGrupo,'<b> Materia: </b>',m.nombreMateria) AS grupo,'0' AS
					tiempoReponer,idRegistroJustificacion,horaInicial,horaFinal,idInstanciaPlanEstudio,g.Plantel
					 FROM 4559_controlDeFalta c,4520_grupos g,4502_Materias m WHERE c.idUsuario=".$idUsuario." and  g.idGrupos=c.idGrupo AND m.idMateria=g.idMateria  
					 AND estadoFalta in (1,2) AND idReposicion IS NULL AND idRegistroJustificacion IS NOT null";
			 
		$res=$con->obtenerFilas($consulta);
		$nTiempo=0;
		$cadObj="";
		while($fila=mysql_fetch_row($res))					
		{
			$consulta="SELECT  cmbFormaReposicion, txtHorasReponer FROM _481_tablaDinamica WHERE id__481_tablaDinamica= ".$fila[6];
			$fReg=$con->obtenerPrimeraFila($consulta);
			if(($fReg)&&($fReg[0]!=1))
			{
				$hInicial=strtotime($fila[7]);
				$hFinal=strtotime($fila[8]);
				$horaFalta=date("H:i",$hInicial)." - ".date("H:i",$hFinal);
				if($fReg[0]==3)
					$nTiempo=$fReg[1];
				else
				{
					
					
					
					$arrRecesos=obtenerArregloRecesos();
					
					 $nTiempo=obtenerNumeroHorasBloque($fila[1],$fila[7],$fila[8],$fila[10],$arrRecesos);
					
					
				}
				$obj='{"idFalta":"'.$fila[0].'","grupo":"'.$fila[4].'","idGrupo":"'.$fila[1].'","fechaFalta":"'.$fila[2].'","horaFalta":"'.$horaFalta.'","tiempoReponer":"'.$nTiempo.'"}';
				if($cadObj=="")
					$cadObj=$obj;
				else
					$cadObj.=",".$obj;
			}
		}
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":['.$cadObj.']}';
		
	}
	
	function registrarReposicionHora()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$query="SELECT idUsuario,idGrupo FROM 4559_controlDeFalta WHERE idFalta=".$obj->idFalta;
		$fFalta=$con->obtenerPrimeraFila($query);
		$idUsuario=$fFalta[0];
		$idGrupo=$fFalta[1];
		$query="select max(noSesion) from 4530_sesiones where idGrupo=".$idGrupo." and tipoSesion=15";
		$nSesion=$con->obtenerValor($query);
		if($nSesion=="")
			$nSesion=1000;
		else
			$nSesion++;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="insert into 4562_registroReposicionSesion(fechaRegistro,idResponsableRegistro,idFalta,idUsuario) VALUES('".date("Y-m-d H:i")."',".$_SESSION["idUsr"].",".$obj->idFalta.",".$idUsuario.")";
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		foreach($obj->arrReposicion as $r)
		{
			$consulta[$x]="INSERT INTO 4563_sesionesReposicion(idRegistroReposicion,fechaReposicion,horaInicio,horaFin,noHoras,idAula,idGrupo)
							VALUES(@idRegistro,'".$r->fecha."','".$r->horaInicio."','".$r->horaFin."',".$r->nHoras.",".$r->idAula.",".$idGrupo.")";
			$x++;
			$consulta[$x]="INSERT INTO 4530_sesiones(noSesion,fechaSesion,horario,tipoSesion,situacionAsistencia,idGrupo)
							VALUES(".$nSesion.",'".$r->fecha."','".$r->horaInicio.":00 - ".$r->horaFin.":00',15,0,".$idGrupo.")";
			$x++;	
			$nSesion++;								
			
		}
		$consulta[$x]="UPDATE 4559_controlDeFalta SET idReposicion=@idRegistro WHERE idFalta=".$obj->idFalta;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function guardarPreguntasPresupuesto()
	{
		global $con;
		$valor=$_POST["valor"];
		$tipo=$_POST["tipo"];
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$campo="";
		if($tipo==0)
			$campo="proyectoUSA";
		else
			$campo="proyectoFDA";
			
		$consulta="UPDATE 9036_presupuestoModuloProyectos SET ".$campo."=".$valor." WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;	
		eC($consulta);
		
		
		
	}
	
	function guardarPrimerasPreguntasPresupuesto()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$proyectoUSA=$_POST["proyectoUSA"];
		$proyectoDFA=$_POST["proyectoDFA"];
		$consulta="select * from 9036_presupuestoModuloProyectos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro;	
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		if($fRegistro)
		{
			$consulta="UPDATE 9036_presupuestoModuloProyectos SET proyectoUSA=".$proyectoUSA." and proyectoFDA=".$proyectoDFA." WHERE idPatrocinador=".$fRegistro[0];
		}
		else
			$consulta="INSERT INTO 9036_presupuestoModuloProyectos(idFormulario,idReferencia,proyectoUSA,proyectoFDA) VALUES(".$idFormulario.",".$idRegistro.",".$proyectoUSA.",".$proyectoDFA.")";
		eC($consulta);
	}
	
	function obtenerPresupuestoRegistro()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$situacionOperacion=$_POST["situacionOperacion"];
		$query="SELECT SUM(montoOperacion) FROM 3001_movimientosRegistro WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." and tipoOperacion=-1 and situacion=1";
		$totalEgreso=$con->obtenerValor($query);
		if($totalEgreso=="")
			$totalEgreso=0;
		$query="SELECT SUM(montoOperacion) FROM 3001_movimientosRegistro WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." and tipoOperacion=1 and situacion=1";
		$totalIngreso=$con->obtenerValor($query);
		if($totalIngreso=="")
			$totalIngreso=0;
		$saldoRegistro=$totalIngreso-$totalEgreso;
		$objSaldos='{"totalEgreso":"'.$totalEgreso.'","totalIngreso":"'.$totalIngreso.'","saldo":"'.$saldoRegistro.'"}';
		
		$consulta="SELECT  idRegistroPresupuesto AS idOperacion,fechaOperacion,montoOperacion,tipoOperacion,concepto,comentarios,fechaCreacion,situacion,
					fechaCancelacion,motivoCancelacion,(SELECT Nombre FROM 800_usuarios WHERE idUsuario=respCancelacion) AS  responsable,idFormularioRef,idRegistroRef FROM 3001_movimientosRegistro WHERE 
					idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." and situacion in(".$situacionOperacion.") ORDER BY fechaOperacion desc";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).',"objSaldos":'.$objSaldos.'}';
		
	}
	
	function guardarPresupuestoRegistro()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$horaOperacion=date("Y-m-d H:i:s");
		if($obj->idOperacion==-1)
		{
			$consulta="INSERT INTO 3001_movimientosRegistro(idFormulario,idReferencia,fechaOperacion,montoOperacion,tipoOperacion,concepto,comentarios,fechaCreacion,respCreacion)
						VALUES(".$obj->idFormulario.",".$obj->idRegistro.",'".$obj->fechaOperacion."',".$obj->montoOperacion.",".$obj->tipoOperacion.",'".cv($obj->concepto)."','".cv($obj->comentarios)."','".$horaOperacion."',".$_SESSION["idUsr"].")";
		}
		else
		{
			$consulta="update 3001_movimientosRegistro set fechaOperacion='".$obj->fechaOperacion."',montoOperacion='".$obj->montoOperacion."',fechaModificacion='".$horaOperacion."',respModificacion=".$_SESSION["idUsr"].",
					tipoOperacion='".$obj->tipoOperacion."',concepto='".cv($obj->concepto)."',comentarios='".cv($obj->comentarios)."' where idRegistroPresupuesto=".$obj->idOperacion;

		}
		
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idOperacion==-1)
			{
				$obj->idOperacion=$con->obtenerUltimoID();
			}
			echo "1|".$obj->idOperacion."|".$horaOperacion;
		}
		
	}
	
	function cancelarOperacion()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$motivo=$_POST["motivo"];
		$consulta="update 3001_movimientosRegistro set respCancelacion=".$_SESSION["idUsr"].",fechaCancelacion='".date("Y-m-d H:i:s")."',motivoCancelacion='".cv($motivo)."',situacion=0 where idRegistroPresupuesto=".$idRegistro;
		eC($consulta);
	}
	
	function obtenerPresupuestoInstitucion()
	{
		global $con;
		$codigoInstitucion=bD($_POST["cI"]);

		$situacionOperacion=$_POST["situacionOperacion"];
		$query="SELECT SUM(montoOperacion) FROM 3002_movimientosRegistroInstitucion WHERE codigoInstitucion='".$codigoInstitucion."' and tipoOperacion=-1 and situacion=1";
		$totalEgreso=$con->obtenerValor($query);
		if($totalEgreso=="")
			$totalEgreso=0;
		$query="SELECT SUM(montoOperacion) FROM 3002_movimientosRegistroInstitucion WHERE codigoInstitucion='".$codigoInstitucion."' and tipoOperacion=1 and situacion=1";
		$totalIngreso=$con->obtenerValor($query);
		if($totalIngreso=="")
			$totalIngreso=0;
		$saldoRegistro=$totalIngreso-$totalEgreso;
		$objSaldos='{"totalEgreso":"'.$totalEgreso.'","totalIngreso":"'.$totalIngreso.'","saldo":"'.$saldoRegistro.'"}';
		
		$consulta="SELECT  idRegistroPresupuesto AS idOperacion,fechaOperacion,montoOperacion,tipoOperacion,concepto,comentarios,fechaCreacion,situacion,
					fechaCancelacion,motivoCancelacion,(SELECT Nombre FROM 800_usuarios WHERE idUsuario=respCancelacion) AS  responsable FROM 3002_movimientosRegistroInstitucion WHERE 
					codigoInstitucion='".$codigoInstitucion."' and situacion in(".$situacionOperacion.") ORDER BY fechaOperacion desc";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).',"objSaldos":'.$objSaldos.'}';
		
	}
	
	function guardarPresupuestoInstitucion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$horaOperacion=date("Y-m-d H:i:s");
		if($obj->idOperacion==-1)
		{
			$consulta="INSERT INTO 3002_movimientosRegistroInstitucion(codigoInstitucion,fechaOperacion,montoOperacion,tipoOperacion,concepto,comentarios,fechaCreacion,respCreacion)
						VALUES('".bD($obj->cI)."','".$obj->fechaOperacion."',".$obj->montoOperacion.",".$obj->tipoOperacion.",'".cv($obj->concepto)."','".cv($obj->comentarios)."','".$horaOperacion."',".$_SESSION["idUsr"].")";
		}
		else
		{
			$consulta="update 3002_movimientosRegistroInstitucion set fechaOperacion='".$obj->fechaOperacion."',montoOperacion='".$obj->montoOperacion."',fechaModificacion='".$horaOperacion."',respModificacion=".$_SESSION["idUsr"].",
					tipoOperacion='".$obj->tipoOperacion."',concepto='".cv($obj->concepto)."',comentarios='".cv($obj->comentarios)."' where idRegistroPresupuesto=".$obj->idOperacion;

		}
		
		if($con->ejecutarConsulta($consulta))
		{
			if($obj->idOperacion==-1)
			{
				$obj->idOperacion=$con->obtenerUltimoID();
			}
			echo "1|".$obj->idOperacion."|".$horaOperacion;
		}
		
	}
	
	function cancelarOperacionInstitucion()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$motivo=$_POST["motivo"];
		$consulta="update 3002_movimientosRegistroInstitucion set respCancelacion=".$_SESSION["idUsr"].",fechaCancelacion='".date("Y-m-d H:i:s")."',motivoCancelacion='".cv($motivo)."',situacion=0 where idRegistroPresupuesto=".$idRegistro;
		eC($consulta);
	}
	
	function obtenerInstitucionesPatrocinadoras()
	{
		global $con;
		
		$sort=$_POST["sort"];
		$dir=$_POST["dir"];
		$start=$_POST["start"];
		$limit=$_POST["limit"];
		$condWhere=" 1=1 ";
		if(isset($_POST["filter"]))
		{
			$condWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		}
		$consulta="SELECT o.idOrganigrama,codigoUnidad,unidad,o.descripcion,i.idPais,estado,if(i.idPais=146,(select municipio FROM 821_municipios WHERE cveMunicipio=i.municipio ),i.ciudad)as ciudad,
				(SELECT porcentajeRetencion FROM _1018_tablaDinamica WHERE institucionPatrocinadora=o.codigoUnidad limit 0,1) as porcentajeRetencion,
				(SELECT COUNT(*) FROM 9036_patrocinadoresProyectos WHERE codigoInstitucion=o.codigoUnidad) as numReferencias
						FROM 817_organigrama o,247_instituciones i WHERE institucion=1 and status not in(-1,0) AND i.idOrganigrama=o.idOrganigrama and ".$condWhere." and o.idOrganigrama<>".$_POST["idUnidad"]." ORDER BY ".$sort." ".$dir." limit ".$start.",".$limit;
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		$consulta="SELECT o.idOrganigrama,codigoUnidad,unidad,o.descripcion,i.idPais,estado,ciudad,
				(SELECT porcentajeRetencion FROM _1018_tablaDinamica WHERE institucionPatrocinadora=o.codigoUnidad limit 0,1) as porcentajeRetencion 
						FROM 817_organigrama o,247_instituciones i WHERE institucion=1 and status not in(-1,0) AND i.idOrganigrama=o.idOrganigrama and ".$condWhere." and o.idOrganigrama<>".$_POST["idUnidad"]." ORDER BY o.unidad";
		$con->obtenerFilas($consulta);				
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function obtenerInstitucionesPatrocinadorasNuevas()
	{
		global $con;
		$consulta="SELECT o.idOrganigrama,codigoUnidad,unidad,o.descripcion,i.idPais,estado,if(i.idPais=146,(select municipio FROM 821_municipios WHERE cveMunicipio=i.municipio ),i.ciudad)as ciudad,
				(SELECT porcentajeRetencion FROM _1018_tablaDinamica WHERE institucionPatrocinadora=o.codigoUnidad limit 0,1) as porcentajeRetencion 
						FROM 817_organigrama o,247_instituciones i WHERE institucion=1 and status=-1 AND i.idOrganigrama=o.idOrganigrama  ORDER BY o.unidad";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	function reemplazarInstitucionesPatrocinadora()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 817_organigrama set status=0 where idOrganigrama in (".$obj->arrUnificacion.")";
		$x++;
		$query="select codigoUnidad from 817_organigrama where idOrganigrama=".$obj->idBase; 
		$codigoBase=$con->obtenerValor($query);
		$query="select codigoUnidad from 817_organigrama where idOrganigrama in (".$obj->arrUnificacion.")";
		$res=$con->obtenerFilas($query);
		while($fila=mysql_fetch_row($res))
		{
			$query="SELECT * FROM 9036_patrocinadoresProyectos WHERE codigoInstitucion='".$fila[0]."'";
			$resPatrocinador=$con->obtenerFilas($query);
			
			while($fPatrocinador=mysql_fetch_row($resPatrocinador))
			{
				$consulta[$x]="UPDATE 9036_patrocinadoresProyectos SET codigoInstitucion='".$codigoBase."',codigoAnterior='".$fPatrocinador[3]."' WHERE idPatrocinador=".$fPatrocinador[0];
				$x++;
			}	
		}
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function removerInstitucionPatrocinadora()
	{
		global $con;
		$idOrganigrama=$_POST["idOrganigrama"];
		$query="update 817_organigrama set status=0 where idOrganigrama =".$idOrganigrama;
		eC($query);
	}
	
	function obtenerSesionesAfectacionComison()
	{
		global $con;
		global $dic;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$cadRegistros="";	
			
			
		$consulta="SELECT idRegistroModuloSesionesClase FROM 4560_registroModuloSesionesClase WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia;
		$idRegistro=$con->obtenerValor($consulta);
		if($idRegistro=="")
			$idRegistro=-1;
		
		$consulta="SELECT DISTINCT fechaSesion FROM 4561_sesionesClaseModulo WHERE idReferencia=".$idRegistro." ORDER BY fechaSesion";
		$rFecha=$con->obtenerFilas($consulta);
		while($fFecha=mysql_fetch_row($rFecha))
		{
			$consulta="SELECT * FROM 4561_sesionesClaseModulo WHERE idReferencia=".$idRegistro." and fechaSesion='".$fFecha[0]."' ORDER BY fechaSesion,horaInicioBloque";
			$res=$con->obtenerFilas($consulta);
			$cadSesiones="";
			while($fila=mysql_fetch_row($res))
			{
				
				$imgSituacion="";
				switch($fila[7])
				{
					case 0:
						$imgSituacion="<img src='../images/control_pause.png' title='En espera de autorizaci&oacute;n' alt='En espera de autorizaci&oacute;n'> ";
					break;
					case 1:
						$imgSituacion="<img src='../images/icon_big_tick.gif' title='Comisión autorizada/aplicada' alt='Comisión autorizada/aplicada'> ";
					break;
					case 2:
					case 4:
						$imgSituacion="<img src='../images/cross.png' title='Comisión NO aplicada, Motivo: sesión considerada en nómina cerrada' alt='Comisión NO aplicada, Motivo: sesión considerada en nómina cerrada'> ";
					break;
					case 3:
						$imgSituacion="<img src='../images/cross.png' title='Comisión NO aplicada, Motivo: falta asociada a la comisión previamente justificada' alt='Comisión NO aplicada, Motivo: falta asociada a la comisión previamente justificada'> ";
					break;
					case 10:
						$imgSituacion="<img src='../images/cancel_round.png' title='Comisión NO aplicada, Motivo: comisión cancelada' alt='Comisión NO aplicada, Motivo: comisión cancelada'> ";
					break;
					case 11:
						$imgSituacion="<img src='../images/icon_big_tick.gif' title='Comisión autorizada/aplicada, NO se puede cancelar puesto que se encuentra considerada en una nómina cerrada' alt='Comisión autorizada/aplicada, NO se puede cancelar puesto que se encuentra considerada en una nómina cerrada'> ";
					break;
					
						
				}
				
				$consulta="SELECT nombreGrupo,m.nombreMateria FROM 4520_grupos g, 4502_Materias m WHERE m.idMateria=g.idMateria AND g.idGrupos=".$fila[1];
				$fGpo=$con->obtenerPrimeraFila($consulta);
				
				$oSesion='{"icon":"../images/s.gif",id:"'.$fila[0].'",text:"'.$imgSituacion.'<b>Sesi&oacute;n '.$fila[5].'</b> de '.date("H:i",strtotime($fila[2])).' a '.date("H:i",strtotime($fila[3])).', <b>Grupo:</b> '.cv($fGpo[0]).', <b>Materia:</b> '.cv($fGpo[1]).'",draggable:false,leaf:true}';
				if($cadSesiones=="")
					$cadSesiones=$oSesion;
				else
					$cadSesiones.=",".$oSesion;
				
				
			}	
			$objGrupo='{"icon":"../images/s.gif",id:"'.$fFecha[0].'",text:"<span class=\'letraRojaSubrayada8\' style=\'color:#900 !important\'> '.date("d/m/Y",strtotime($fFecha[0])).'</span>",draggable:false,leaf:false,children:['.$cadSesiones.']}';
			if($cadRegistros=="")
				$cadRegistros=$objGrupo;
			else
				$cadRegistros.=",".$objGrupo;
		}
		echo "[".$cadRegistros."]";
	}
	
	function obtenerDescuentosBecasPromociones()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idRegistro=$_POST["idRegistro"];
		$sL=$_POST["sL"];
		
		
		$numReg=0;
		$consulta="SELECT idCiclo,idPeriodo,idInstanciaPlan,idGradoInscribe FROM _678_tablaDinamica WHERE id__678_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		
		
		$cadObj='{"idRegistroInscripcion":"'.$idRegistro.'","idCiclo":"'.$fRegistro[0].'","idPeriodo":"'.$fRegistro[1].'","idInstanciaPlan":"'.$fRegistro[2].'","idGrado":"'.$fRegistro[3].
				'","idPromocion":"","tipoPromocion":""}';
		$objParam=json_decode($cadObj);
		$cache=NULL;
		
		$arrRegistros="";
		
		if($sL==0)
		{
			$consulta="SELECT id__1058_tablaDinamica AS idPromocion,'1' AS tipo,tituloPromocion AS beneficio,txtDescripcion AS descripcion FROM _1058_tablaDinamica p, 3014_pluginPeriodos pr
						WHERE idEstado=2 AND cicloEscolar=".$fRegistro[0]." AND pr.idFormulario=1058 AND pr.idReferencia=p.id__1058_tablaDinamica AND pr.idPeriodo=".$fRegistro[1]."
						UNION
						SELECT id__1057_tablaDinamica AS idPromocion,'2' AS tipo,nombreBeca AS beneficio,txtDescripcion AS descripcion FROM _1057_tablaDinamica p
						WHERE p.idEstado=2";

			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				
					
				$objParam->idPromocion=$fila[0];
				$objParam->tipoPromocion=$fila[1];
				
				$aplicaPromocion=true;
				$consulta="SELECT count(*) FROM 3015_descuentoAplicablePromocion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro.
						" AND tipoDescuento=".$fila[1]." AND descuentoAplicable=1 and idDescuento=".$fila[0];
		
				$nReg=$con->obtenerValor($consulta);
				if($nReg==0)
				{

					$consulta="SELECT idRegla FROM _1058_gridReglasAplicacion WHERE idReferencia=".$fila[0];
					if($fila[1]==2)
						$consulta="SELECT iRegla FROM _1057_gridReglas WHERE idReferencia=".$fila[0];
					$rReglas=$con->obtenerFilas($consulta);	
					while($fRegla=mysql_fetch_row($rReglas))
					{
						$cumpleRegla=true;
						$consulta="SELECT idFuncionCumplimiento FROM _1064_gridFuncionesCumplimientoReglas WHERE idReferencia=".$fRegla[0];
						
						$rFuncionCumplimiento=$con->obtenerFilas($consulta);	
						while($fFuncionCumplimiento=mysql_fetch_row($rFuncionCumplimiento))
						{
							
							$resultado=resolverExpresionCalculoPHP($fFuncionCumplimiento[0],$objParam,$cache);
							if(($fila[0]==1)&&($fila[1]==1))
							{
								//echo $fFuncionCumplimiento[0].": ".$resultado."<br>";
							}
							if(($resultado==false)||($resultado==0))
							{
								$cumpleRegla=false;
								break;
							}
						}
						
						if(!$cumpleRegla)
						{
												
							$aplicaPromocion=false;
							break;
						}
						
					}
				}
				
				
				
				if($aplicaPromocion)
				{
					
					$consulta="SELECT COUNT(*) FROM 3015_descuentoAplicablePromocion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idDescuento=".$fila[0]." AND tipoDescuento=".$fila[1]." and descuentoAplicable=1";
					$nReg=$con->obtenerValor($consulta);
					
					$o='{"idPromocion":"'.$fila[0].'","tipo":"'.$fila[1].'","beneficio":"<input '.(($nReg>0)?"checked=checked":"")." ".(($sL==1)?"disabled=disabled":"").' onclick=\'chkSeleccionado(this)\' type=\'checkbox\' name=\'chkPromociones\' id=\'chk_'.$fila[0].'_'.$fila[1].'\'> '.cv($fila[2]).'","descripcion":"'.cv($fila[3]).'"}';
					if($arrRegistros=='')
						$arrRegistros=$o;
					else
						$arrRegistros.=",".$o;
					$numReg++;
				}
						
			}
		}
		else
		{
			$consulta="SELECT id__1058_tablaDinamica AS idPromocion,'1' AS tipo,tituloPromocion AS beneficio,txtDescripcion AS descripcion FROM _1058_tablaDinamica p, 3014_pluginPeriodos pr
						WHERE id__1058_tablaDinamica in(SELECT idDescuento FROM 3015_descuentoAplicablePromocion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND tipoDescuento=1)
						UNION
						SELECT id__1057_tablaDinamica AS idPromocion,'2' AS tipo,nombreBeca AS beneficio,txtDescripcion AS descripcion FROM _1057_tablaDinamica p
						WHERE id__1057_tablaDinamica in(SELECT idDescuento FROM 3015_descuentoAplicablePromocion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND tipoDescuento=2)";
						
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($res))
			{
				$consulta="SELECT COUNT(*) FROM 3015_descuentoAplicablePromocion WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idDescuento=".$fila[0]." AND tipoDescuento=".$fila[1]." and descuentoAplicable=1";
				$nReg=$con->obtenerValor($consulta);
				
				$o='{"idPromocion":"'.$fila[0].'","tipo":"'.$fila[1].'","beneficio":"<input '.(($nReg>0)?"checked=checked":"")." ".(($sL==1)?"disabled=disabled":"").' onclick=\'chkSeleccionado(this)\' type=\'checkbox\' name=\'chkPromociones\' id=\'chk_'.$fila[0].'_'.$fila[1].'\'> '.cv($fila[2]).'","descripcion":"'.cv($fila[3]).'"}';
				if($arrRegistros=='')
					$arrRegistros=$o;
				else
					$arrRegistros.=",".$o;
				$numReg++;
						
			}
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	function registrarDescuentoBecasPromocionInscripcion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 3015_descuentoAplicablePromocion WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia;
		$x++;
		
		foreach($obj->arrPromociones as $p)
		{
			$consulta[$x]="INSERT INTO 3015_descuentoAplicablePromocion(idFormulario,idReferencia,idDescuento,tipoDescuento,descuentoAplicable) VALUES(".$obj->idFormulario.",".$obj->idReferencia.
							",".$p->idPromocion.",".$p->tipoPromocion.",".$p->seleccionado.")";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;	
		
		eB($consulta);
	}
	
	function buscarCodigoRevalidacion()
	{
		global $con;
		$cRevalidacion=$_POST["cRevalidacion"];
		$consulta="SELECT * FROM _1066_tablaDinamica WHERE codigo='".$cRevalidacion."' AND idEstado=3";
		$fDatos=$con->obtenerPrimeraFila($consulta);
		if($fDatos)
		{
			$instancia=$fDatos[26];
			$nInstancia=obtenerNombreInstanciaPlan($instancia);
			
			$consulta="SELECT gradoInscribe FROM 4574_solicitudesRevalidacion WHERE idFormulario=1066 AND idReferencia=".$fDatos[0];
			$gradoInscribe=$con->obtenerValor($consulta);
			
			$consulta="SELECT leyendaGrado FROM 4501_Grado WHERE idGrado=".$gradoInscribe;
			$leyendaGrado=$con->obtenerValor($consulta);
			
			
			$consulta="SELECT idPlanEstudio FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$instancia;
			$idPlanEstudio=$con->obtenerValor($consulta);
			
			$cadbj='{"idPlanEstudios":"'.$idPlanEstudio.'","idRegistro":"'.$fDatos[0].'","alumno":"'.cv($fDatos[10]." ".$fDatos[11]." ".$fDatos[12]).'","idGradoInscribe":"'.$gradoInscribe.'","idInstanciaPlanEstudio":"'.$instancia.'","nombrePlanEstudio":"'.cv($nInstancia).'","grado":"'.cv($leyendaGrado).'"}';
			echo "1|".$cadbj;
		}
		else
			echo "1|-1";
		
	}
	
	function buscarDatosIDCodigoRevalidacion()
	{
		global $con;
		$idFolio=$_POST["idFolio"];
		$consulta="SELECT * FROM _1066_tablaDinamica WHERE id__1066_tablaDinamica=".$idFolio;
		$fDatos=$con->obtenerPrimeraFila($consulta);
		if($fDatos)
		{
			
			$cadObj='{"nombre":"'.$fDatos[10].'","apPaterno":"'.$fDatos[11].'","apMaterno":"'.$fDatos[12].'","fechaNac":"'.$fDatos[13].'","genero":"'.$fDatos[14].'","estadoCivil":"'.$fDatos[15].'","nacionalidad":"'.
					$fDatos[16].'","edoNac":"'.$fDatos[17].'","curp":"'.$fDatos[18].'","telCasa":"'.$fDatos[19].'","telCelular":"'.$fDatos[20].'","EmailContacto":"'.$fDatos[21].'"}';			
			
			echo "1|".$cadObj;
		}
		else
			echo "1|-1";
		
	}
	
	function buscarDatosAlumnoCobroServicios()
	{
		global $con;
		
		
		$aplicaDescuento=true;
		
		$fechaActual=date("Y-m-d");
		$diaSemana=date("w",strtotime($fechaActual));
		$fechaLimite=date("Y-m-15");
		
		if(!(($diaSemana>0)&&($diaSemana<6)))
		{
			$aplicaDescuento=false;
		}
		
		
		$idRegistro=$_POST["idRegistro"];
		$arrRegistros=array();
		$aRegistros='';
		$arrGrupos[1]="A";
		$arrGrupos[2]="B";
		$arrGrupos[3]="C";
		$arrGrupos[4]="D";
		$arrGrupos[5]="E";
		
		
		$consulta="SELECT idCiclo FROM 4526_ciclosEscolares WHERE situacion=1";
		$idCiclo=$con->obtenerValor($consulta);
		
		$consulta="SELECT id__1069_tablaDinamica,apPaterno,apMaterno,nombre,curp,planEstudios,grados,grupo 
				FROM _1069_tablaDinamica WHERE id__1069_tablaDinamica=".$idRegistro;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$planEstudio=obtenerNombreInstanciaPlan($fila[5]);
			$consulta="SELECT leyendaGrado FROM 4501_Grado WHERE idGrado=".$fila[6];
			$grado=$con->obtenerValor($consulta);
			
			$consulta="SELECT idPeriodicidad FROM 4513_instanciaPlanEstudio WHERE idInstanciaPlanEstudio=".$fila[5];
			$idPeriodicidad=$con->obtenerValor($consulta);
			$consulta="SELECT id__464_gridPeriodos from _464_gridPeriodos WHERE idReferencia=".$idPeriodicidad." AND periodoDefaultActivo=1";
			$idPeriodo=$con->obtenerValor($consulta);
			$idMes=date("m")*1;
			
			$arrConceptosCobro="";
			$consulta="SELECT i.idConcepto,i.nombreConcepto,porcentajeIVA,t.costoServicio FROM _1070_tablaDinamica c,_1071_tablaDinamica t,561_conceptosIngreso i WHERE t.idReferencia=c.id__1070_tablaDinamica 
						AND t.planEstudios=".$fila[5]." AND t.grado=".$fila[6]." AND i.idConcepto=c.conceptoIngreso";
			
			$resConceptos=$con->obtenerFilas($consulta);
			while($fConcepto=mysql_fetch_row($resConceptos))
			{
				//$oC='{"idConceptoCobro":"'.$fConcepto[0].'","leyendaConcepto":"'.cv($fConcepto[1]).'","iva":"'.$fConcepto[2].'","costo":"'.$fConcepto[3].'","considerarCobro":false,"comentarios":""}';
				$descuento=0;
				$total=0;
				$pocentajeDescuento=0;
				$descDescuento="";
				if($fConcepto[3]>0)
				{
					
					
					
					if($aplicaDescuento)
					{
						
						switch($fConcepto[0])
						{
							case 14:
							
								$consulta="SELECT porcentaje,tipoBeca FROM _1081_tablaDinamica WHERE alumno=".$idRegistro." AND idEstado=2";
								$fBeca=$con->obtenerPrimeraFila($consulta);
								
								if($fBeca)
								{
									$pocentajeDescuento=$fBeca[0];
									$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=9497 AND valor=".$fBeca[1];
									$tipoBeca=$con->obtenerValor($consulta);
									$descDescuento="Descuento de ".number_format($fBeca[0],2)." % por tipo de beca: ".$tipoBeca;
								}
							break;
						}
						
						
						
					}
					
					
					$cobrable=1;
					$motivoNoCobro='';
					
					$consulta="SELECT p.idProductoVenta,folioVenta FROM 6009_productosVentaCaja p,6008_ventasCaja v WHERE v.tipoCliente=1 and 
								v.idCliente=".$fila[0]." AND v.situacion=1 and v.idVenta=p.idVenta AND idProducto=".$fConcepto[0];
					$rProductoVenta=$con->obtenerFilas($consulta);
					while($fProductoVenta=mysql_fetch_row($rProductoVenta))
					{
						$consulta="SELECT COUNT(*) FROM 6010_productosVentaMetaData WHERE idProductoVenta=".$fProductoVenta[0]." 
									AND ((campo='ciclo' AND valor='".$idCiclo."')||(campo='mes' AND valor='".$idMes."')||(campo='periodo' AND valor='".$idPeriodo."'))";
						$nCoincidencias=$con->obtenerValor($consulta);
						if($nCoincidencias==3)
						{
							$cobrable=0;
							$motivoNoCobro="El concepto ya ha sido cobrado previamente en la venta con folio: ".$fProductoVenta[1];
						}
						
					}
					
					
					$oC="['".$fConcepto[0]."','".cv($fConcepto[1])."','".$fConcepto[2]."','".$fConcepto[3]."',false,'','".$idCiclo."','".$idPeriodo."','".$idMes.
						"','".$pocentajeDescuento."','".cv($descDescuento)."',0,".$fConcepto[3].",1,'".$fechaLimite."',".$cobrable.",'".$motivoNoCobro."']";
					if($arrConceptosCobro=="")
						$arrConceptosCobro=$oC;
					else
						$arrConceptosCobro.=",".$oC;
				}
			}
			
			$o='{"arrConceptosCobro":['.$arrConceptosCobro.'],"periodicidad":"'.$idPeriodicidad.'","idRegistro":"'.$fila[0].'","apPaterno":"'.cv($fila[1]).'","apMaterno":"'.cv($fila[2]).'","nombre":"'.cv($fila[3]).'","curp":"'.cv($fila[4]).'","planEstudio":"'.cv($planEstudio).'","grado":"'.$grado.'","grupo":"'.$arrGrupos[$fila[7]].'"}';
			if($aRegistros=="")
				$aRegistros=$o;
			else
				$aRegistros.",".$o;
		}
		echo "1|[".$aRegistros."]";

	}
?>