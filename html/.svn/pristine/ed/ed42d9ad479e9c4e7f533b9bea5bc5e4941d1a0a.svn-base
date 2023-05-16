<?php session_start();
	;
	include("cContabilidad.php");
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include_once("cContabilidad.php");
	if(isset($_SESSION["leng"]))
	{
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];
		$lenguaje=$_SESSION["leng"];
		
		switch($funcion)
		{
			case "1":
				obtenerPresupuestoAutorizado();
			break;
			case "2":
				obtenerSituacionPresupuestal();
			break;
			case "3":
				obtenerSituacionTranferencia();
			break;
			case 4:
				realizarTransferenciaPresupuestal();
			break;
			case 5:
				obtenerDetalleMovimientosPresupuestales();
			break;
			case 6:
				obtenerTechoPresupuestalGlobal();
			break;
			case 7:
				obtenerTechoPresupuestalProgramaInstitucional();
			break;
			case 8:
				obtenerTechoPresupuestalDepartamento();
			break;
			case 9:
				aumentarDisminuirTechosPresupuestal();
			break;
			case 10:
				cerrarAjusteTechoPresupuestal();
			break;
			case 11:
				modificarechoPresupuestalDepto();
			break;
			case 12:
				obtenerPresupuestoProyectos();
			break;
			case 13:
				obtenerDesglocePresupuestoProyectos();
			break;
			case 14:
				obtenerProgramasRuta();
			break;
			case 15:
				obtenerDeptosRutaPrograma();
			break;
			case 16:
				obtenerCapitulosRutaProgramaDepto();
			break;
			case 17:
				agregarTechoPresupuestal();
			break;
			case 18:
				obtenerTechosPresupuestalesHistorico();
			break;
			case 19:
				importarTechosPresupuestales();
			break;
			case 20:
				obtenerPresupuestoAutorizadoDeteccionNecesidades();
			break;
			case 21:
				obtenerPresupuestoAutorizadoProgramaInstitucional();
			break;
			case 22:
				obtenerTechoPresupuestalProgramaDepto();
			break;
			case 23:
				obtenerTechoPresupuestalPrograma();
			break;
			case 24:
				clonarTechoPresupuestal();
			break;
			case 25:
				guardarFactorInflacion();
			break;
			case 26:
				obtenerPresupuestoIngresoAutorizado();
			break;
			case 27:
				obtenerPresupuestoIngresoAutorizadoDetalle();
			break;
			case 28:
				obtenerProgramasPresupuestarios();
			break;
			case 29:
				obtenerDepartamentoProgramas();
			break;
			case 30:
				obtenerPartidasPermitidasProgramaDepto();
			break;
			case 31:
				registrarPartidaPresupuestariaProgramaDepto();
			break;
			case 32:
				obtenerPresupuestoProgramaDepto();
			break;
			case 33:
				guardarMontoPresupuestoMes();
			break;
			case 34:
				obtenerSituacionPresupuestoCiclo();
			break;
			case 35:
				bloquearDefinicionPresupuesto();
			break;
			case 36:
				obtenerSituacionPresupuestalCiclo();
			break;
			case 37:
				verificarSuficienciaPresupuestalCiclo();
				
			break;
			case 38:
				obtenerSituacionPresupuestalVisorBase();
			break;
			case 39:
				obtenerDetallePresupuestal();
			break;
			
		}
	}
	
	function obtenerPresupuestoAutorizado()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$capitulo='';
		if(isset($_POST["capitulo"]))
			$capitulo=$_POST["capitulo"];
		
		
		$condWhere="";
		if(isset($_POST["depto"]))
			$condWhere=' and depto="'.$_POST["depto"].'"';
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);	
			
			
		$consulta="SELECT p.idPresupuestoAutorizado,p.programa,pr.cvePrograma,pr.tituloPrograma,p.depto,codigoDepto,o.unidad,p.partida,
				clave,nombreObjetoGasto ,p.montoTotal,p.montoAjustado,idTipoPresupuesto,tp.tituloTipoP,p.ruta FROM 523_presupuestoAutorizado p, 
				508_tiposPresupuesto tp,517_programas pr,817_organigrama o,507_objetosGasto ob	WHERE p.capitulo='".$capitulo."' and o.codigoUnidad=p.depto and pr.idPrograma=p.programa and tp.idTipoPresupuesto=p.tipoPresupuesto and  
				ob.codigoControl=p.partida and p.ciclo=".$ciclo." AND p.institucion='".$_SESSION["codigoInstitucion"]."' ".$condWhere." and ".$cadCondWhere." order by p.depto";

		$resPres=$con->obtenerFilas($consulta);
		$nRegistros=$con->filasAfectadas;
		$sql=$consulta;
		$arrObj="";
		$obj="";
		$ct=0;
		$arrRutas=obtenerCodigosRutas(NULL);
		while($fila=mysql_fetch_row($resPres))
		{
			$consulta="SELECT nDistribucion,monto,montoAjustado FROM 523_distribucionPresupuestoAutorizado WHERE  idPresupuestoAutorizado=".$fila[0]." ORDER BY nDistribucion";
			$resDist=$con->obtenerFilas($consulta);
			$arrMeses='';
			while($f=mysql_fetch_row($resDist))
			{
				$objMes='"mes'.$f[0].'":"'.$f[1].'","mes'.$f[0].'Ajuste":"'.$f[2].'"';
				$arrMeses.=",".$objMes;
			}
			if(isset($arrRutas[$fila[14]]))
			{
				$obj='	{
							"idPresupuestoAutorizado":"'.$fila[0].'",
							"programa":"'.$fila[1].'",
							"nPrograma":"['.$arrRutas[$fila[14]]." ".$fila[2].'] '.$fila[3].'",
							"depto":"'.$fila[3].'",
							"codigoDepto":"'.$fila[5].'",
							"unidad":"'.$fila[6].'",
							"partida":"'.$fila[7].'",
							"clave":"'.$fila[8].'",
							"nombreObjetoGasto":"'.$fila[9].'",
							"montoTotal":"'.$fila[10].'",
							"montoAjustado":"'.$fila[11].'",
							"idTipoPresupuesto":"'.$fila[12].'",
							"nTipoPresupuesto":"'.$fila[13].'"'.$arrMeses.'
						}';
				if($arrObj=="")	
					$arrObj=$obj;
				else
					$arrObj.=",".$obj;
				$ct++;
			}
		}
		
		echo '{"numReg":"'.$nRegistros.'","sql":"'.bE($sql).'","registros":['.$arrObj.']}';
	}
	
	function obtenerSituacionPresupuestal()
	{
		global $con;
		$rContabilidad=new cContabilidad();
		$iRegistro=bD($_POST["iRegistro"]);
		$iMonto=bD($_POST["iMonto"]);
		$arrTiempos="";
		$consulta="SELECT programa,depto,partida,ciclo,ruta,capitulo,tipoPresupuesto FROM 523_presupuestoAutorizado WHERE idPresupuestoAutorizado=".$iRegistro;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$programa=$fRegistro[0];
		$depto=$fRegistro[1];
		$partida=$fRegistro[2];
		$ciclo=$fRegistro[3];
		$ruta=$fRegistro[4];
		$capitulo=$fRegistro[5];
		$tipoPresupuesto=$fRegistro[6];
		$comp="";
		$arrDimensiones=array();
		if($iMonto!=0)
			$arrDimensiones["mes"]=($iMonto-1);

		$arrDimensiones["idPrograma"]=$programa;
		$arrDimensiones["ruta"]=$ruta;
		$arrDimensiones["ciclo"]=$ciclo;
		$arrDimensiones["departamento"]=$depto;
		$arrDimensiones["capitulo"]=$capitulo;
		$arrDimensiones["partida"]=$partida;
		$arrDimensiones["tipoPresupuesto"]=$tipoPresupuesto;	
		
		
		
		$consulta="SELECT idTiempoPresupuestal,nombreTiempo FROM 524_tiemposPresupuestales ORDER BY idTiempoPresupuestal";
		$resTiempo=$con->obtenerFilas($consulta);
		$montoTotal=0;
		while($filaTiempo=mysql_fetch_row($resTiempo))
		{
			$montoPres=$rContabilidad->obtenerSaldoPresupuesto($filaTiempo[0],$arrDimensiones);
			$obj='{"idTiempo":"'.$filaTiempo[0].'","tiempo":"'.$filaTiempo[1].'","monto":"'.$montoPres.'"}';
			$montoTotal+=$montoPres;
			if($arrTiempos=="")
				$arrTiempos=$obj;
			else
				$arrTiempos.=",".$obj;
		}
		$arrTiempos.=',{"idTiempo":"0","tiempo":"<font color=\'red\'><b>Total: </b></font>","monto":"'.$montoTotal.'"}';
		echo '{"registros":['.$arrTiempos.']}';
	}
	
	function obtenerSituacionTranferencia()
	{
		global $con;
		global $arrMesLetra;
		$iRegistro=($_POST["idRegistro"]);
		
		
		$arrTiempos="";
		$consulta="SELECT programa,depto,partida,ciclo,ruta FROM 523_presupuestoAutorizado WHERE idPresupuestoAutorizado=".$iRegistro;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$programa=$fRegistro[0];
		$depto=$fRegistro[1];
		$partida=$fRegistro[2];
		$ciclo=$fRegistro[3];
		$arrAsientos=array();
		$ruta=$fRegistro[4];

		for($x=0;$x<12;$x++)
		{
			$comp=" and mes=".$x;
			$consulta="SELECT monto,tiempoPresupuestal,operacion,mes FROM 528_asientosCuentasPresupuestales WHERE ruta='".$ruta."' tiempoPresupuestal=1 and programa='".$programa."' AND departamento='".$depto."' AND partida=".$partida." AND ciclo=".$ciclo." ".$comp;
			$resAsientos=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($resAsientos))
			{
				$monto=$fila[0]*$fila[2];
				if(!isset($arrAsientos[$fila[3]]))	
					$arrAsientos[$fila[3]]=$monto;
				else
					$arrAsientos[$fila[3]]+=$monto;
			}
		}
		
		$arrSaldos="";
		for($x=0;$x<12;$x++)
		{
			$obj="";
			if(isset($arrAsientos[$x]))
				$obj="['".$x."_".$arrAsientos[$x]."','".$arrMesLetra[$x]." Disponible: $ ".number_format($arrAsientos[$x],2,".",",")."']";
			else
				$obj="['".$x."_0','".$arrMesLetra[$x]." Disponible: $ 0.00']";
			if($arrSaldos=="")
				$arrSaldos=$obj;
			else
				$arrSaldos.=",".$obj;				
		}
		echo '1|['.$arrSaldos.']';
	}
	
	function realizarTransferenciaPresupuestal()
	{
		global $con;	
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);
		$query="SELECT * FROM 523_presupuestoAutorizado WHERE idPresupuestoAutorizado=".$obj->iRegistroO;
		$fOrigen=$con->obtenerPrimeraFila($query);
		$query="SELECT * FROM 523_presupuestoAutorizado WHERE idPresupuestoAutorizado=".$obj->iRegistroD;
		$fDestino=$con->obtenerPrimeraFila($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="update 523_presupuestoAutorizado set montoAjustado=montoAjustado-".$obj->montoTransferencia." where idPresupuestoAutorizado=".$obj->iRegistroO;
		$x++;
		$consulta[$x]="update 523_presupuestoAutorizado set montoAjustado=montoAjustado+".$obj->montoTransferencia." where idPresupuestoAutorizado=".$obj->iRegistroD;
		$x++;
		$consulta[$x]="update 523_distribucionPresupuestoAutorizado set montoAjustado=montoAjustado-".$obj->montoTransferencia." where idPresupuestoAutorizado=".$obj->iRegistroO." and nDistribucion=".$obj->mesOrigen;
		$x++;
		$consulta[$x]="update 523_distribucionPresupuestoAutorizado set montoAjustado=montoAjustado+".$obj->montoTransferencia." where idPresupuestoAutorizado=".$obj->iRegistroD." and nDistribucion=".$obj->mesDestino;
		$x++;
		$consulta[$x]="INSERT INTO 528_asientosCuentasPresupuestales(ciclo,programa,departamento,capitulo,partida,mes,monto,fechaOperacion,responsableOperacion,
						tiempoPresupuestal,operacion,idReferencia,idProceso,complementario,origenMovimiento,ruta)
						VALUES(".$fOrigen[1].",".$fOrigen[2].",'".$fOrigen[3]."',".$fOrigen[4].",".$fOrigen[5].",".$obj->mesOrigen.",".$obj->montoTransferencia.",'".date("Y-m-d")."',".$_SESSION["idUsr"].",
						1,-1,".$obj->iRegistroD.",0,'".cv($obj->motivo)."',1,'".$fOrigen[12]."')";
		$x++;
		$consulta[$x]="INSERT INTO 528_asientosCuentasPresupuestales(ciclo,programa,departamento,capitulo,partida,mes,monto,fechaOperacion,responsableOperacion,
						tiempoPresupuestal,operacion,idReferencia,idProceso,complementario,origenMovimiento,ruta)
						VALUES(".$fDestino[1].",".$fDestino[2].",'".$fDestino[3]."',".$fDestino[4].",".$fDestino[5].",".$obj->mesDestino.",".$obj->montoTransferencia.",'".date("Y-m-d")."',".$_SESSION["idUsr"].",
						1,1,".$obj->iRegistroO.",0,'".cv($obj->motivo)."',1,'".$fOrigen[12]."')";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerDetalleMovimientosPresupuestales()
	{
		global $con;
		global $arrMesLetra;
		$iRegistro=bD($_POST["iRegistro"]);
		$tiempoP=bD($_POST["tiempoP"]);
		$iMonto=bD($_POST["iMonto"]);
		$query="SELECT * FROM 523_presupuestoAutorizado WHERE idPresupuestoAutorizado=".$iRegistro;
		$fOrigen=$con->obtenerPrimeraFila($query);
		$comp="";
		if($iMonto!=0)
			$comp=" and mes=".($iMonto-1);
		$consulta="SELECT fechaOperacion,u.Nombre,monto,mes,operacion,origenMovimiento FROM 528_asientosCuentasPresupuestales ac,800_usuarios u
					WHERE u.idUsuario=ac.responsableOperacion AND ruta='".$fOrigen[12]."' and ciclo=".$fOrigen[1]." AND programa=".$fOrigen[2]."  AND departamento='".$fOrigen[3]." ' AND partida='".$fOrigen[5]."' and tiempoPresupuestal=".$tiempoP." ".$comp." ORDER BY fechaOperacion ";
		$resMovimientos=$con->obtenerFilas($consulta);	
		$arrOperaciones="";
		
		while($filaMovimiento=mysql_fetch_row($resMovimientos))
		{
			$op='+';
			if($filaMovimiento[4]=="-1")
				$op='-';
			$origen="";
			switch($filaMovimiento[5])
			{
				case 0:
					$origen="Dep&oacute;sito presupuesto autorizado";
				break;
				case 1:
					$origen="Transferencia presupuestal";
				break;	
			}
			$obj='{"fechaOperacion":"'.date("d/m/Y",strtotime($filaMovimiento[0])).'","responsable":"'.$filaMovimiento[1].'","monto":"'.$filaMovimiento[2].'","mes":"'.$arrMesLetra[$filaMovimiento[3]].'","operacion":"'.$op.'","origenMov":"'.$origen.'"}';
			if($arrOperaciones=="")	
				$arrOperaciones=$obj;
			else
				$arrOperaciones.=",".$obj;
		}
		echo '{"registros":['.$arrOperaciones.']}';
	}
	
	function obtenerTechoPresupuestalGlobal()
	{
		global $con;
		$arrObj="";
		$nObjetos=0;
		$ciclo=$_POST["ciclo"];
		
		
		$cadCampos="";
		$cadColumnas="";
		$cadCapitulos="";
		$consulta="SELECT DISTINCT t.fuenteFinanciamiento,p.tituloTipoP FROM 523_techosPresupuestales t,508_tiposPresupuesto p WHERE ciclo=".$ciclo." and p.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and p.idTipoPresupuesto=t.fuenteFinanciamiento";
		$resFuenteFinanciamento=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resFuenteFinanciamento))
		{
			$consulta="SELECT DISTINCT o.codigoControl,o.clave FROM 523_techosPresupuestales t,507_objetosGasto o WHERE o.codigoControl=t.capitulo AND ciclo=".$ciclo." AND fuenteFinanciamiento=".$fila[0]." order by o.clave";
			$resCapitulo=$con->obtenerFilas($consulta);
			while($filaCap=mysql_fetch_row($resCapitulo))
			{
				if($cadCampos=="")
				{
					$cadColumnas="{
									  header:' Cap. ".$filaCap[1]."<br>(".$fila[1].")',
									  width:140,
									  sortable:true,
									  align :'right',
									  summaryType:'sum',
									  renderer:'usMoney',
									  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
									  hideable:true
								  },";
					$cadCampos="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},";
					$cadCapitulos="['".$filaCap[0]."_".$fila[0]."',' Cap. ".$filaCap[1]." (".$fila[1].")']";								  
				}
				else
				{
					$cadCampos.="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},";
					$cadColumnas.="{
									  header:' Cap. ".$filaCap[1]."<br>(".$fila[1].")',
									  width:140,
									  align :'right',
									  sortable:true,
									  summaryType:'sum',
									  renderer:'usMoney',
									  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
									  hideable:true
								  },";
					$cadCapitulos.=",['".$filaCap[0]."_".$fila[0]."',' Cap. ".$filaCap[1]." (".$fila[1].")']";								  
				}
			}
		}
		
		
		$consulta="SELECT DISTINCT t.fuenteFinanciamiento,p.tituloTipoP FROM 523_techosPresupuestales t,508_tiposPresupuesto p WHERE ciclo=".$ciclo." and p.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' 
				and p.idTipoPresupuesto=t.fuenteFinanciamiento  order by p.tituloTipoP";
		$resFuenteFinanciamento=$con->obtenerFilas($consulta);
		
		$consulta="		SELECT DISTINCT ruta,
						CONCAT(
						(SELECT codigoGrupoFuncional FROM _497_tablaDinamica WHERE  id__497_tablaDinamica=p.grupoFuncional),' ',
						(SELECT codigoFuncion FROM _498_tablaDinamica WHERE  id__498_tablaDinamica=p.funcion),' ',
						(SELECT codigoSubFuncion FROM _500_tablaDinamica WHERE  id__500_tablaDinamica=p.subFuncion),' ',
						(SELECT codigoPrograma FROM _502_tablaDinamica WHERE  id__502_tablaDinamica=p.programaGasto),' ',
						(SELECT codigoActividadInst FROM _501_tablaDinamica WHERE  id__501_tablaDinamica=p.actividadInstitucional),' ',
						(SELECT codigoProgPresupuestal FROM _503_tablaDinamica WHERE id__503_tablaDinamica=p.partidaPresupuestal)) AS programaPresupuestal FROM 9117_estructuraPAT p WHERE ciclo=".$ciclo." and  codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$resRutas=$con->obtenerFilas($consulta);
		$consulta="select unidad from 817_organigrama where codigoUnidad='".$_SESSION["codigoInstitucion"]."'";
		$instituto=$con->obtenerValor($consulta);						
		while($filaRuta=mysql_fetch_row($resRutas))
		{
			$objBase='{"instituto":"'.$instituto.'","ruta":"'.$filaRuta[0].'","programaPresupuestario":"'.$filaRuta[1].'"';
			$consulta="SELECT p.idPrograma,p.cvePrograma,p.tituloPrograma FROM 9117_estructurasVSPrograma e,517_programas p WHERE p.idPrograma=e.idProgramaInstitucional AND  ciclo=".$ciclo." AND ruta='".$filaRuta[0]."'";
			$resProgramas=$con->obtenerFilas($consulta);
			while($fPrograma=mysql_fetch_row($resProgramas))
			{
				$totalRuta=0;
				if(mysql_num_rows($resFuenteFinanciamento)>0)
					mysql_data_seek($resFuenteFinanciamento,0);
				$objFinal=$objBase.',"codigoPI":"'.$fPrograma[1].'","programaInstitucional":"'.$fPrograma[2].'","idProgramaInstitucional":"'.$fPrograma[0].'"';
				while($fila=mysql_fetch_row($resFuenteFinanciamento))
				{
					$consulta="SELECT DISTINCT o.codigoControl,o.clave FROM 523_techosPresupuestales t,507_objetosGasto o WHERE  ciclo=".$ciclo." AND fuenteFinanciamiento=".$fila[0]." and o.codigoControl=t.capitulo order by o.clave";
					$resCapitulo=$con->obtenerFilas($consulta);
					while($filaCap=mysql_fetch_row($resCapitulo))
					{
						$consulta="select sum(techoPresupuestal) FROM 523_techosPresupuestales WHERE ciclo=".$ciclo."  and programaInstitucional=".$fPrograma[0]." and ruta='".$filaRuta[0]."' and  capitulo='".$filaCap[0]."' AND fuenteFinanciamiento=".$fila[0]." and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
						$monto=$con->obtenerValor($consulta);
						$objFinal.=',"cap_'.$filaCap[0].'_'.$fila[0].'":"'.$monto.'"';
						$totalRuta+=$monto;
					}
				}
				$objFinal.=',"total":"'.$totalRuta.'"}';
				if($arrObj=="")
					$arrObj=$objFinal;
				else
					$arrObj.=",".$objFinal;
				$nObjetos++;
					
			}
		}
		
		$columnas=	"	
						{
							header:'Instituto',
							width:200,
							sortable:true,
							dataIndex:'instituto',
							hidden:true,
							hideable:true
						},
						{
							header:'Programa Presupuestal',
							width:150,
							sortable:true,
							dataIndex:'programaPresupuestario',
							hideable:true
						},
						{
							header:'',
							width:60,
							sortable:true,
							dataIndex:'codigoPI',
							hideable:true
						},
						{
							header:'Programa institucional',
							width:350,
							sortable:true,
							dataIndex:'programaInstitucional',
							hideable:true
						},
						".$cadColumnas."
						{
							header:'Monto total',
							width:120,
							align :'right',
							sortable:true,
							dataIndex:'total',
							renderer:'usMoney',
							summaryType:'sum',
							hideable:true
						}
					";
		
		$campos=" {name:'ruta'},
				  {name: 'instituto'},
				  {name:'programaPresupuestario'},
				  {name:'programaInstitucional'},
				  {name: 'codigoPI'},
				  {name:'idProgramaInstitucional'},
					".$cadCampos."
				  {name:'total'}";
		echo '{"metaData":{"root":"registros","totalProperty":"numReg","fields":['.$campos.']},"numReg":"'.$nObjetos.'","registros":['.$arrObj.'],"campos":['.$columnas.'],"cadCapitulos":['.$cadCapitulos.']}';
	}
	
	
	function obtenerTechoPresupuestalProgramaInstitucional()
	{
		global $con;
		$arrObj="";
		$nObjetos=0;
		$ciclo=$_POST["ciclo"];
		$ruta=$_POST["ruta"];
		$idPrograma=$_POST["idPrograma"];
		$cadCampos="";
		$cadColumnas="";
		$consulta="SELECT DISTINCT t.fuenteFinanciamiento,p.tituloTipoP FROM 523_techosPresupuestales t,508_tiposPresupuesto p WHERE ciclo=".$ciclo." and p.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and p.idTipoPresupuesto=t.fuenteFinanciamiento";
		$resFuenteFinanciamento=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resFuenteFinanciamento))
		{
			$consulta="SELECT DISTINCT o.codigoControl,o.clave FROM 523_techosPresupuestales t,507_objetosGasto o WHERE ciclo=".$ciclo." AND fuenteFinanciamiento=".$fila[0]." and o.codigoControl=t.capitulo order by o.clave";
			$resCapitulo=$con->obtenerFilas($consulta);
			while($filaCap=mysql_fetch_row($resCapitulo))
			{
				if($cadCampos=="")
				{
					$cadColumnas="{
									  header:' Cap. ".$filaCap[1]."<br>(".$fila[1].")',
									  width:140,
									  sortable:true,
									  align :'right',
									  summaryType:'sum',
									  renderer:formatearMontoCapitulo,
									  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
									  hideable:true
								  },";
					$cadCampos="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},";
				}
				else
				{
					$cadCampos.="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},";
					$cadColumnas.="{
									  header:' Cap. ".$filaCap[1]."<br>(".$fila[1].")',
									  width:140,
									  align :'right',
									  sortable:true,
									  summaryType:'sum',
									  renderer:formatearMontoCapitulo,
									  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
									  hideable:true
								  },";
				}
			}
		}
		
		
		$consulta="SELECT DISTINCT t.fuenteFinanciamiento,p.tituloTipoP FROM 523_techosPresupuestales t,508_tiposPresupuesto p WHERE ciclo=".$ciclo." and p.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and p.idTipoPresupuesto=t.fuenteFinanciamiento order by p.tituloTipoP";
		$resFuenteFinanciamento=$con->obtenerFilas($consulta);
		
		$consulta="		SELECT DISTINCT p.ruta,
						CONCAT(
							(SELECT codigoGrupoFuncional FROM _497_tablaDinamica WHERE  id__497_tablaDinamica=p.grupoFuncional),' ',
							(SELECT codigoFuncion FROM _498_tablaDinamica WHERE  id__498_tablaDinamica=p.funcion),' ',
							(SELECT codigoSubFuncion FROM _500_tablaDinamica WHERE  id__500_tablaDinamica=p.subFuncion),' ',
							(SELECT codigoPrograma FROM _502_tablaDinamica WHERE  id__502_tablaDinamica=p.programaGasto),' ',
							(SELECT codigoActividadInst FROM _501_tablaDinamica WHERE  id__501_tablaDinamica=p.actividadInstitucional),' ',
							(SELECT codigoProgPresupuestal FROM _503_tablaDinamica WHERE id__503_tablaDinamica=p.partidaPresupuestal),' ',
							(SELECT CONCAT(cvePrograma,' ',tituloPrograma) FROM 517_programas WHERE idPrograma=e.idProgramaInstitucional)
						) AS programaInstitucional,e.idProgramaInstitucional
						FROM 9117_estructuraPAT p,9117_estructurasVSPrograma e WHERE p.ciclo=".$ciclo." AND p.ruta='".$ruta."' and p.ciclo=e.ciclo and e.ruta=p.ruta and p.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and e.idProgramaInstitucional=".$idPrograma;
		$resRutas=$con->obtenerFilas($consulta);
		$consulta="select distinct departamento from  523_techosPresupuestales where ciclo=".$ciclo." and programaInstitucional=".$idPrograma." and ruta='".$ruta."'";
		
		$listDeptos=$con->obtenerListaValores($consulta,"'");
		if($listDeptos=="")
			$listDeptos="''";
		while($filaRuta=mysql_fetch_row($resRutas))
		{
			$objBase='{"programaInstitucional":"'.$filaRuta[1].'","ruta":"'.$filaRuta[0].'","idProgramaInstitucional":"'.$filaRuta[2].'"';
			$consulta="SELECT o.codigoDepto,o.unidad,o.codigoUnidad FROM 817_organigrama o where o.codigoUnidad in (".$listDeptos.")";

			$resProgramas=$con->obtenerFilas($consulta);
			while($fPrograma=mysql_fetch_row($resProgramas))
			{
				$totalRuta=0;
				if(mysql_num_rows($resFuenteFinanciamento)>0)
					mysql_data_seek($resFuenteFinanciamento,0);
				$objFinal=$objBase.',"codigoDepto":"'.$fPrograma[2].'","cveDepto":"'.$fPrograma[0].'","departamento":"'.$fPrograma[1].'"';
				while($fila=mysql_fetch_row($resFuenteFinanciamento))
				{
					$consulta="SELECT DISTINCT o.codigoControl,o.clave FROM 523_techosPresupuestales t,507_objetosGasto o WHERE ciclo=".$ciclo." AND fuenteFinanciamiento=".$fila[0]." and o.codigoControl=t.capitulo  order by o.clave";
					$resCapitulo=$con->obtenerFilas($consulta);
					while($filaCap=mysql_fetch_row($resCapitulo))
					{
						$consulta="select sum(techoPresupuestal) FROM 523_techosPresupuestales WHERE ciclo=".$ciclo." AND programaInstitucional=".$filaRuta[2]." and  ruta='".$filaRuta[0]."' AND capitulo='".$filaCap[0]."' and departamento='".$fPrograma[2]."' and fuenteFinanciamiento=".$fila[0]." AND codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
						$monto=$con->obtenerValor($consulta);
						$objFinal.=',"cap_'.$filaCap[0].'_'.$fila[0].'":"'.$monto.'"';
						$totalRuta+=$monto;
					}
				}
				$objFinal.=',"total":"'.$totalRuta.'"}';
				if($arrObj=="")
					$arrObj=$objFinal;
				else
					$arrObj.=",".$objFinal;
				$nObjetos++;
					
			}
		}
		
		$columnas=	"	
						{
							header:'Programa institucional',
							width:200,
							sortable:true,
							dataIndex:'programaInstitucional',
							hideable:true,
							hidden:true
						},
						{
							header:'',
							width:60,
							sortable:true,
							dataIndex:'cveDepto',
							hideable:true
						},
					   
						{
							header:'Departamento',
							width:350,
							sortable:true,
							dataIndex:'departamento',
							hideable:true
						},
						".$cadColumnas."
						{
							header:'Monto total',
							width:120,
							align :'right',
							sortable:true,
							dataIndex:'total',
							renderer:'usMoney',
							summaryType:'sum',
							hideable:true
						}
					";
		
		$campos="	{name:'ruta'},
				  	{name: 'programaInstitucional'},
				  	{name: 'idProgramaInstitucional'},
				  	{name:'cveDepto'},
				  	{name:'codigoDepto'},
				  	{name: 'departamento'},
					".$cadCampos."
				  	{name:'total'}";
		echo '{"metaData":{"root":"registros","totalProperty":"numReg","fields":['.$campos.']},"numReg":"'.$nObjetos.'","registros":['.$arrObj.'],"campos":['.$columnas.']}';
		
		
		
	}
	
	function obtenerTechoPresupuestalDepartamento()
	{
		global $con;
		$arrObj="";
		$nObjetos=0;
		$ciclo=$_POST["ciclo"];
		$ruta=$_POST["ruta"];
		$idPrograma=$_POST["idPrograma"];
		$codigoDepartamento=$_POST["codigoDepartamento"];
		$fuenteFinanciamiento=$_POST["fuenteFinanciamiento"];
		$capitulo=$_POST["capitulo"];
		
		$consulta="		SELECT DISTINCT p.ruta,
						CONCAT(
							(SELECT codigoGrupoFuncional FROM _497_tablaDinamica WHERE  id__497_tablaDinamica=p.grupoFuncional),' ',
							(SELECT codigoFuncion FROM _498_tablaDinamica WHERE  id__498_tablaDinamica=p.funcion),' ',
							(SELECT codigoSubFuncion FROM _500_tablaDinamica WHERE  id__500_tablaDinamica=p.subFuncion),' ',
							(SELECT codigoPrograma FROM _502_tablaDinamica WHERE  id__502_tablaDinamica=p.programaGasto),' ',
							(SELECT codigoActividadInst FROM _501_tablaDinamica WHERE  id__501_tablaDinamica=p.actividadInstitucional),' ',
							(SELECT codigoProgPresupuestal FROM _503_tablaDinamica WHERE id__503_tablaDinamica=p.partidaPresupuestal),' ',
							(SELECT cvePrograma FROM 517_programas WHERE idPrograma=e.idProgramaInstitucional),' ',
							(SELECT concat(o.codigoDepto,' ',o.unidad) FROM 817_organigrama o where o.codigoUnidad='".$codigoDepartamento."')
						) AS departamento,e.idProgramaInstitucional
						FROM 9117_estructuraPAT p,9117_estructurasVSPrograma e WHERE p.ciclo=".$ciclo."   and e.idProgramaInstitucional=".$idPrograma." and  p.ciclo=e.ciclo and e.ruta=p.ruta and p.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' limit 0,1";

		$resRutas=$con->obtenerFilas($consulta);
		while($filaRuta=mysql_fetch_row($resRutas))
		{
			$objBase='{"codigoDepto":"'.$codigoDepartamento.'","departamento":"'.$filaRuta[1].'","ruta":"'.$filaRuta[0].'","idProgramaInstitucional":"'.$filaRuta[2].'"';
				$totalRuta=0;
				

				$consulta="SELECT DISTINCT t.objetoGasto,o.clave,o.nombreObjetoGasto FROM 523_techosPresupuestales t,507_objetosGasto o WHERE o.codigoControl=t.objetoGasto and ciclo=".$ciclo." AND ruta='".$ruta."' AND programaInstitucional='".$idPrograma."' AND departamento='".$codigoDepartamento."' 
							AND fuenteFinanciamiento='".$fuenteFinanciamiento."' AND capitulo='".$capitulo."'";

				$resCapitulo=$con->obtenerFilas($consulta);
				while($filaCap=mysql_fetch_row($resCapitulo))
				{
					$objFinal=$objBase;
					$consulta="select sum(techoPresupuestal) FROM 523_techosPresupuestales WHERE ciclo=".$ciclo." AND ruta='".$ruta."' AND programaInstitucional='".$idPrograma."' AND departamento='".$codigoDepartamento."' 
								AND fuenteFinanciamiento='".$fuenteFinanciamiento."' AND objetoGasto='".$filaCap[0]."'";
					$monto=$con->obtenerValor($consulta);
					$objFinal.=',"codigoObjetoGasto":"'.$filaCap[0].'","cveObjetoGasto":"'.$filaCap[1].'","objetoGasto":"'.$filaCap[2].'","total":"'.$monto.'"}';
					if($arrObj=="")
						$arrObj=$objFinal;
					else
						$arrObj.=",".$objFinal;
					$nObjetos++;
				}
		}
		echo '{"numReg":"'.$nObjetos.'","registros":['.$arrObj.']}';
	}
	
	function aumentarDisminuirTechosPresupuestal()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$ciclo=$obj->ciclo;
		$accion=$obj->accion;
		$porcentaje=$obj->porcentaje*$accion;
		$tAfectacion=$obj->tAfectacion;

		$listaCapitulos=$obj->listaCapitulos;
		$arrAux=explode(",",$listaCapitulos);
		$arrCapitulos=array();
		foreach($arrAux as $aux)
		{
			$objAux=explode("_",$aux);
			array_push($arrCapitulos,$objAux);
		}

		$x=0;
		$consulta[$x]="begin";
		$x++;
		foreach($obj->lista as $e)
		{
			switch($tAfectacion)
			{
				case 1:
					foreach($arrCapitulos as $capitulo)
					{
						$consulta[$x]="update 523_techosPresupuestales set techoPresupuestal=techoPresupuestal+(techoPresupuestal*(".$porcentaje."/100)) where ciclo=".$ciclo." and ruta='".$e->ruta."' 
									and programaInstitucional=".$e->programa." and capitulo='".$capitulo[0]."' and fuenteFinanciamiento=".$capitulo[1];
						$x++;
					}
				break;
				case 2:
					foreach($arrCapitulos as $capitulo)
					{
						$consulta[$x]="update 523_techosPresupuestales set techoPresupuestal=techoPresupuestal+(techoPresupuestal*(".$porcentaje."/100)) where ciclo=".$ciclo." and ruta='".$e->ruta."' 
									and programaInstitucional=".$e->programa." and departamento='".$e->departamento."' and capitulo='".$capitulo[0]."' and fuenteFinanciamiento=".$capitulo[1];
						$x++;
					}
				break;
				case 3:
					foreach($arrCapitulos as $capitulo)
					{
						$consulta[$x]="update 523_techosPresupuestales set techoPresupuestal=techoPresupuestal+(techoPresupuestal*(".$porcentaje."/100)) where ciclo=".$ciclo." and ruta='".$e->ruta."' 
										and programaInstitucional=".$e->programa." and departamento='".$e->departamento."' and objetoGasto='".$e->codigoObjetoGasto."' and fuenteFinanciamiento=".$capitulo[1];
						$x++;
					}
				break;
			}
		}
		$consulta[$x]="commit";
		$x++;		
		eB($consulta);
	}
	
	function cerrarAjusteTechoPresupuestal()
	{
		$ciclo=$_POST["ciclo"];
		$consulta="INSERT INTO 2000_cierresCicloProcesos(codigoInstitucion,ciclo,fechaCierre,idResponsableCierre,tipoCierre) VALUES('".$_SESSION["codigoInstitucion"]."',".$ciclo.",'".date("Y-m-d")."',".$_SESSION["idUsr"].",2)";			
		eC($consulta);
			
	}
	
	function modificarechoPresupuestalDepto()
	{
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="update 523_techosPresupuestales SET techoPresupuestal=".$obj->valor." WHERE ciclo=".$obj->ciclo." AND ruta='".$obj->ruta."' AND programaInstitucional=".$obj->idPrograma." AND departamento='".$obj->codigoDepto."'
					AND objetoGasto='".$obj->objetoGasto."' AND fuenteFinanciamiento=".$obj->fuenteFinanciamiento;			
		eC($consulta);
			
	}
	
	function obtenerPresupuestoProyectos()
	{
		global $con;
		$consulta="SELECT DISTINCT idReferencia FROM  100_gridPresupuesto WHERE idFormulario=278";
		$listProtocolos=$con->obtenerListaValores($consulta);
		if($listProtocolos=="")
			$listProtocolos="-1";
		$listaRegistrosProtocolos="";		
		$nReg=0;	
		
		$cadMeses='';
		
		for($x=0;$x<4;$x++)
		{
			for($y=0;$y<4;$y++)
			{
				$cadMeses.=',"mes'.($x+1)."_".($y+1).'":"0"';
			}
		}
		
		$consulta="SELECT id__278_tablaDinamica,(SELECT unidad FROM 817_organigrama WHERE codigoUnidad=t.codigoInstitucion) AS instituto,codigo,tituloProyecto,DATE_FORMAT(fechaCreacion,'%d/%m/%Y'),DATE_FORMAT(Fechainiciopro,'%d/%m/%Y'),DATE_FORMAT(fechatermino,'%d/%m/%Y'),idEstado FROM _278_tablaDinamica t WHERE id__278_tablaDinamica IN (".$listProtocolos.")";
		$resProtocolos=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resProtocolos))
		{
			
			$objAux='{"idProtocolo":"'.$fila[0].'","institucion":"'.cv($fila[1]).'","folio":"'.$fila[2].'","tituloProtocolo":"'.cv($fila[3]).'","fechaRegistro":"'.$fila[4].'","fechaInicio":"'.$fila[5].'","fechaTermino":"'.$fila[6].'","situacion":"'.$fila[7].'"';
			$consulta="SELECT DISTINCT capitulo,concat('[',clave,'] ',nombreObjetoGasto) FROM 100_conceptosGridPresupuesto c,100_gridPresupuesto g,507_objetosGasto o WHERE o.codigoControl=c.capitulo and g.idRubro=c.idConceptoGrid AND g.idReferencia=".$fila[0]." AND g.idFormulario=278";
			$resCapitulo=$con->obtenerFilas($consulta);
			while($fCap=mysql_fetch_row($resCapitulo))
			{
				$consulta="SELECT SUM(total) FROM 100_gridPresupuesto g,100_conceptosGridPresupuesto c WHERE c.idConceptoGrid=g.idRubro AND g.idFormulario=278 AND g.idReferencia=".$fila[0]." and c.capitulo='".$fCap[0]."'";	
				$monto=$con->obtenerValor($consulta);
				$obj=$objAux.',"montoPresupuesto":"'.$monto.'","capitulo":"'.$fCap[0].'","nCapitulo":"'.$fCap[1].'"'.$cadMeses.'}';
				if($listaRegistrosProtocolos=="")
					$listaRegistrosProtocolos=$obj;
				else
					$listaRegistrosProtocolos.=",".$obj;
				$nReg++;
			}
		}
		echo '{"nReg":"'.$nReg.'","registros":['.$listaRegistrosProtocolos.']}';
	}
	
	function obtenerDesglocePresupuestoProyectos()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$capitulo=$_POST["capitulo"];
		$consulta="SELECT g.idGridVSCalculo as idPresupuesto,g.concepto as concepto,c.nombreConcepto as tipoConcepto,costoUnitario as monto,cantidad,total FROM 100_gridPresupuesto g,100_conceptosGridPresupuesto c 
					WHERE c.idConceptoGrid=g.idRubro AND g.idFormulario=278 AND g.idReferencia=".$idRegistro." and c.capitulo='".$capitulo."'";	
		$arrObj=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrObj).'}';
		
	}
	
	function obtenerProgramasRuta()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$ruta=$_POST["ruta"];
		$consulta="select idPrograma, concat('[',cvePrograma,'] ',tituloPrograma) as tituloPrograma from 9117_estructurasVSPrograma e,517_programas p WHERE p.idPrograma=e.idProgramaInstitucional and e.ciclo=".$ciclo." AND e.ruta='".$ruta."' order by tituloPrograma";
		$arreglo=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arreglo;
	}
	
	function obtenerDeptosRutaPrograma()
	{	
		global $con;
		$ciclo=$_POST["ciclo"];
		$ruta=$_POST["ruta"];
		$idPrograma=$_POST["idPrograma"];
		$consulta="SELECT o.codigoUnidad,concat('[',codigoDepto,'] ',o.unidad) FROM 817_organigrama o,9130_departamentoVSPrograma d WHERE o.codigoUnidad=d.codigoUnidad AND ciclo=".$ciclo." AND  idPrograma=".$idPrograma." AND ruta='".$ruta."' order by unidad";
		$arrDeptos=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrDeptos;
	}
	
	function obtenerCapitulosRutaProgramaDepto()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$ruta=$_POST["ruta"];
		$idPrograma=$_POST["idPrograma"];
		$depto=$_POST["depto"];
		$listCapitulos=array();
		$consulta="SELECT partidas FROM 9130_departamentoVSPrograma WHERE ciclo=".$ciclo." and idPrograma=".$idPrograma." AND ruta='".$ruta."' AND codigoUnidad='".$depto."'";
		$partidas=$con->obtenerValor($consulta);
		$arrPartidas=explode(",",$partidas);
		foreach($arrPartidas as $p)
		{
			
			$capitulo=substr(str_replace("'","",$p),0,3);
			if(!existeValor($listCapitulos,$capitulo))
				array_push($listCapitulos,$capitulo);
		}
		$arrCapitulos="";
		foreach($listCapitulos as $c)
		{
			$consulta="SELECT codigoControl,CONCAT('[',clave,'] ',nombreObjetoGasto) AS objetoGasto FROM 507_objetosGasto WHERE codigoControl='".$c."'";
			$fila=$con->obtenerPrimeraFila($consulta);
			$consulta="SELECT codigoControl,CONCAT('[',clave,'] ',nombreObjetoGasto) AS objetoGasto FROM 507_objetosGasto WHERE codigoControl like '".$c."%' and nivel=3 and codigoControl in(".$partidas.") 
					and codigoControl not in (SELECT objetoGasto FROM 523_techosPresupuestales WHERE ciclo=".$ciclo." 
					AND programaInstitucional=".$idPrograma." AND ruta='".$ruta."' and capitulo=".$c." AND departamento='".$depto."')";
			$arrConceptos=$con->obtenerFilasArreglo($consulta);
			if($fila[0]!="")
			{
				$obj="['".$fila[0]."','".$fila[1]."',".$arrConceptos."]";
				if($arrCapitulos=="")
					$arrCapitulos=$obj;
				else
					$arrCapitulos.=",".$obj;
			}
		}
		echo "1|[".$arrCapitulos."]";
	}
	
	function agregarTechoPresupuestal()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$obj=json_decode($cadObj);	
		$consulta="INSERT INTO 523_techosPresupuestales(ciclo,programaInstitucional,objetoGasto,fuenteFinanciamiento,departamento,techoPresupuestal,ruta,capitulo,codigoInstitucion)
				VALUES(".$obj->ciclo.",".$obj->programaInstitucional.",'".$obj->objetoGasto."',".$obj->fuenteFinanciamiento.",'".$obj->departamento."',".$obj->techoPresupuestal.
				",'".$obj->programaPresupuestal."','".$obj->capitulo."','".$_SESSION["codigoInstitucion"]."')";
		eC($consulta);
	}
	
	function obtenerTechosPresupuestalesHistorico()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$consulta="select distinct ciclo from  523_techosPresupuestales t WHERE ciclo<".$ciclo." and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$res=$con->obtenerFilas($consulta);
		$arr="";
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select sum(techoPresupuestal) from 523_techosPresupuestales where ciclo=".$fila[0]." and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
			$suma=$con->obtenerValor($consulta);
			$obj="['".$fila[0]."','".$suma."']";
			if($arr=="")
				$arr=$obj;
			else
				$arr.=",".$obj;
		}
		
		echo "1|[".$arr."]";

	}
	
	function importarTechosPresupuestales()
	{
		global $con;
		$cicloOrigen=$_POST["cicloOrigen"];
		$cicloDestino=$_POST["cicloDestino"];
		$query="SELECT * FROM 523_techosPresupuestales WHERE ciclo=".$cicloOrigen." AND codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$res=$con->obtenerFilas($query);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 523_techosPresupuestales where ciclo=".$cicloDestino." and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$x++;
		while($fila=mysql_fetch_row($res))
		{
			$query="SELECT partidas,ruta FROM 9130_departamentoVSPrograma WHERE ciclo=".$cicloDestino." AND  idPrograma=".$fila[2]." and  codigoUnidad='".$fila[5]."'"; 
			$filaDepto=$con->obtenerPrimeraFila($query);
			$listPartidas=$filaDepto[0];
			$nRuta=$filaDepto[1];
			if($listPartidas!="")
			{
				$arrPartidas=explode(",",str_replace("'","",$listPartidas));
				
				if(existeValor($arrPartidas,$fila[3]))
				{
					
					$consulta[$x]="INSERT INTO 523_techosPresupuestales(ciclo,programaInstitucional,objetoGasto,fuenteFinanciamiento,departamento,techoPresupuestal,ruta,capitulo,codigoInstitucion)
						VALUES(".$cicloDestino.",".$fila[2].",'".$fila[3]."',".$fila[4].",'".$fila[5]."',".$fila[6].",'".$nRuta."','".$fila[8]."','".$fila[9]."')";

					$x++;				
				}
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}	
	
	
	function obtenerPresupuestoAutorizadoDeteccionNecesidades()
	{
		global $con;
		$arrObj="";
		$nObjetos=0;
		$ciclo=$_POST["ciclo"];
		$capitulo=$_POST["capitulo"];
		$cadCampos="";
		$cadColumnas="";
		$cadCapitulos="";
		$consulta="SELECT DISTINCT o.codigoControl,o.clave FROM 507_objetosGasto o WHERE o.codigoControl='".$capitulo."'";
		$filaCap=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT DISTINCT t.tipoPresupuesto,p.tituloTipoP FROM 9110_objetosGastoVSCiclo t,508_tiposPresupuesto p WHERE t.idCiclo=".$ciclo." and t.numEtapa=5 and p.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and (t.clave like '".$capitulo."%' or t.clave='".$capitulo."') and p.idTipoPresupuesto=t.tipoPresupuesto";
		$resFuenteFinanciamento=$con->obtenerFilas($consulta);
		if($con->filasAfectadas==0)
		{
			$consulta="SELECT DISTINCT idTipoPresupuesto,p.tituloTipoP FROM 508_tiposPresupuesto p WHERE p.codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
			$resFuenteFinanciamento=$con->obtenerFilas($consulta);
		}
		while($fila=mysql_fetch_row($resFuenteFinanciamento))
		{
			if($cadCampos=="")
			{
				$cadColumnas="{
								  header:' Cap. ".$filaCap[1]."<br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												if(parseFloat(val)>parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."_Aut))
													color='red';
												return '<span title=\'El presupuesto solicitado excede el autorizado\' alt=\'El presupuesto solicitado excede el autorizado\'><font color=\''+color+'\'>'+Ext.util.Format.usMoney(val)+'</font></span>';
											}
								  ,
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
								  hideable:true
							  },
							  {
								  header:' Autorizado Cap. ".$filaCap[1]."<br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:'usMoney',
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."_Aut',
								  hideable:true
							  },
							  {
								  header:' Diferencia Cap. ".$filaCap[1]."<br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  dataIndex:'dif_".$filaCap[0]."_".$fila[0]."_Aut',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												var diferencia=parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."_Aut)-parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0].");
												if(diferencia<0)
													color='red';
												registro.data.dif_".$filaCap[0]."_".$fila[0]."_Aut=diferencia;
												return '<font color=\''+color+'\'>'+Ext.util.Format.usMoney(diferencia)+'</font>';
											},
								  hideable:true
							  },
							  ";
				$cadCampos="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},{name: 'cap_".$filaCap[0]."_".$fila[0]."_Aut'},{name: 'dif_".$filaCap[0]."_".$fila[0]."_Aut'},";
				$cadCapitulos="['".$filaCap[0]."_".$fila[0]."',' Cap. ".$filaCap[1]." (".$fila[1].")'],['".$filaCap[0]."_".$fila[0]."_Aut',' Autorizado Cap. ".$filaCap[1]." (".$fila[1].")']";								  
			}
			else
			{
				$cadCampos.="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},{name: 'cap_".$filaCap[0]."_".$fila[0]."_Aut'},{name: 'dif_".$filaCap[0]."_".$fila[0]."_Aut'},";
				$cadColumnas.="{
								  header:' Cap. ".$filaCap[1]."<br>".$fila[1]."',
								  width:140,
								  align :'right',
								  sortable:true,
								  summaryType:'sum',
								  renderer:'usMoney',
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
								  hideable:true
							  }
							  ,
							  {
								  header:' Autorizado Cap. ".$filaCap[1]."<br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:'usMoney',
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."_Aut',
								  hideable:true
							  }
							  ,
							  {
								  header:' Diferencia Cap. ".$filaCap[1]."<br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  dataIndex:'dif_".$filaCap[0]."_".$fila[0]."_Aut',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												var diferencia=parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."_Aut)-parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0].");
												
												if(diferencia<0)
													color='red';
												registro.data.dif_".$filaCap[0]."_".$fila[0]."_Aut=diferencia;
												return '<font color=\''+color+'\'>'+Ext.util.Format.usMoney(diferencia)+'</font>';
											},
								  hideable:true
							  },
							  ";
				$cadCapitulos.=",['".$filaCap[0]."_".$fila[0]."',' Cap. ".$filaCap[1]." (".$fila[1].")'],['".$filaCap[0]."_".$fila[0]."_Aut',' Autorizado Cap. ".$filaCap[1]." (".$fila[1].")']";								  
			}
		}
		
		$consulta="		SELECT DISTINCT ruta,
						CONCAT(
						(SELECT codigoGrupoFuncional FROM _497_tablaDinamica WHERE  id__497_tablaDinamica=p.grupoFuncional),' ',
						(SELECT codigoFuncion FROM _498_tablaDinamica WHERE  id__498_tablaDinamica=p.funcion),' ',
						(SELECT codigoSubFuncion FROM _500_tablaDinamica WHERE  id__500_tablaDinamica=p.subFuncion),' ',
						(SELECT codigoPrograma FROM _502_tablaDinamica WHERE  id__502_tablaDinamica=p.programaGasto),' ',
						(SELECT codigoActividadInst FROM _501_tablaDinamica WHERE  id__501_tablaDinamica=p.actividadInstitucional),' ',
						(SELECT codigoProgPresupuestal FROM _503_tablaDinamica WHERE id__503_tablaDinamica=p.partidaPresupuestal)) AS programaPresupuestal FROM 9117_estructuraPAT p WHERE codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and ciclo=".$ciclo;
		$resRutas=$con->obtenerFilas($consulta);
		$consulta="select unidad from 817_organigrama where codigoUnidad='".$_SESSION["codigoInstitucion"]."'";
		$instituto=$con->obtenerValor($consulta);						
		while($filaRuta=mysql_fetch_row($resRutas))
		{
			$objBase='{"instituto":"'.$instituto.'","ruta":"'.$filaRuta[0].'","programaPresupuestario":"'.$filaRuta[1].'"';
			$consulta="SELECT p.idPrograma,p.cvePrograma,p.tituloPrograma FROM 9117_estructurasVSPrograma e,517_programas p WHERE p.idPrograma=e.idProgramaInstitucional AND  ciclo=".$ciclo." AND ruta='".$filaRuta[0]."'";

			$resProgramas=$con->obtenerFilas($consulta);
			while($fPrograma=mysql_fetch_row($resProgramas))
			{
				$totalRuta=0;
				if(mysql_num_rows($resFuenteFinanciamento)>0)
					mysql_data_seek($resFuenteFinanciamento,0);
				$objFinal=$objBase.',"codigoPI":"'.$fPrograma[1].'","programaInstitucional":"'.$fPrograma[2].'","idProgramaInstitucional":"'.$fPrograma[0].'"';
				while($fila=mysql_fetch_row($resFuenteFinanciamento))
				{
					$consulta="select sum(montoTotal) FROM 9110_objetosGastoVSCiclo WHERE idCiclo=".$ciclo." AND idPrograma=".$fPrograma[0]." and ruta='".$filaRuta[0]."' and  tipoPresupuesto=".$fila[0]." 
								AND (clave like '".$capitulo."%' or clave='".$capitulo."')  AND codInstitucion='".$_SESSION["codigoInstitucion"]."' and numEtapa=5";
					$monto=$con->obtenerValor($consulta);
					if($monto=="")
						$monto=0;
					$montoAutorizado=0;
					$consulta="SELECT SUM(montoAutorizado) FROM 523_techosAutorizadosConcentradora WHERE ciclo=".$ciclo." and idPrograma=".$fPrograma[0]." and ruta='".$filaRuta[0]."' and fuenteFinanciamiento=".$fila[0]."
							and capitulo='".$capitulo."' and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
					$montoAutorizado=$con->obtenerValor($consulta);	
					if($montoAutorizado=="")	
						$montoAutorizado=0;
					$objFinal.=',"cap_'.$filaCap[0].'_'.$fila[0].'":"'.$monto.'","cap_'.$filaCap[0].'_'.$fila[0].'_Aut":"'.$montoAutorizado.'"';
					$totalRuta+=$monto;
				}
				$objFinal.=',"total":"'.$totalRuta.'"}';
				if($arrObj=="")
					$arrObj=$objFinal;
				else
					$arrObj.=",".$objFinal;
				$nObjetos++;
					
			}
		}
		
		$columnas=	"	
						{
							header:'Instituto',
							width:200,
							sortable:true,
							dataIndex:'instituto',
							hidden:true,
							hideable:true
						},
						{
							header:'Programa Presupuestal',
							width:150,
							sortable:true,
							dataIndex:'programaPresupuestario',
							hideable:true
						},
						{
							header:'',
							width:60,
							sortable:true,
							dataIndex:'codigoPI',
							hideable:true
						},
						{
							header:'Programa institucional',
							width:350,
							sortable:true,
							dataIndex:'programaInstitucional',
							hideable:true
						},
						".$cadColumnas."
						{
							header:'Monto total',
							width:120,
							align :'right',
							sortable:true,
							dataIndex:'total',
							renderer:'usMoney',
							summaryType:'sum',
							hideable:true
						}
					";
		
		$campos=" {name:'ruta'},
				  {name: 'instituto'},
				  {name:'programaPresupuestario'},
				  {name:'programaInstitucional'},
				  {name: 'codigoPI'},
				  {name:'idProgramaInstitucional'},
					".$cadCampos."
				  {name:'total'}";
		echo '{"metaData":{"root":"registros","totalProperty":"numReg","fields":['.$campos.']},"numReg":"'.$nObjetos.'","registros":['.$arrObj.'],"campos":['.$columnas.'],"cadCapitulos":['.$cadCapitulos.']}';
		
		
		
	}
	
	function obtenerPresupuestoAutorizadoProgramaInstitucional()
	{
		global $con;
		$arrObj="";
		$nObjetos=0;
		$ciclo=$_POST["ciclo"];
		$ruta=$_POST["ruta"];
		$idPrograma=$_POST["idPrograma"];
		$capitulo=$_POST["capitulo"];
		
		$cadCampos="";
		$cadColumnas="";
		$consulta="SELECT DISTINCT o.codigoControl,o.clave FROM 507_objetosGasto o WHERE o.codigoControl='".$capitulo."'";
		$filaCap=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT DISTINCT t.tipoPresupuesto,p.tituloTipoP FROM 9110_objetosGastoVSCiclo t,508_tiposPresupuesto p WHERE t.idCiclo=".$ciclo." and p.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' 
					and (t.clave like '".$capitulo."%' or t.clave='".$capitulo."') and idPrograma=".$idPrograma." and ruta='".$ruta."' and p.idTipoPresupuesto=t.tipoPresupuesto AND  t.numEtapa=5";
		$resFuenteFinanciamento=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resFuenteFinanciamento))
		{
			
			if($cadCampos=="")
			{
				$cadColumnas="{
								  header:' Cap. ".$filaCap[1]."<br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												if(parseFloat(val)>parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."_Aut))
													color='red';
												return '<span title=\'El presupuesto solicitado excede el autorizado\' alt=\'El presupuesto solicitado excede el autorizado\'><font color=\''+color+'\'>'+Ext.util.Format.usMoney(val)+'</font></span>';
											},
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
								  hideable:true
							  },
							  {
								  header:' Autorizado Cap. ".$filaCap[1]."<br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:'usMoney',
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."_Aut',
								  hideable:true
							  },
							  {
								  header:' Diferencia Cap. ".$filaCap[1]."<br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												var diferencia=parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."_Aut)-parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0].");
												if(diferencia<0)
													color='red';
												return '<font color=\''+color+'\'>'+Ext.util.Format.usMoney(diferencia)+'</font>';
											},
								  hideable:true
							  },
							  ";
				$cadCampos="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},{name: 'cap_".$filaCap[0]."_".$fila[0]."_Aut'},";
			}
			else
			{
				$cadCampos.="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},{name: 'cap_".$filaCap[0]."_".$fila[0]."_Aut'},";
				$cadColumnas.=",{
								  header:' Cap. ".$filaCap[1]."<br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												if(parseFloat(val)>parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."_Aut))
													color='red';
												return '<span title=\'El presupuesto solicitado excede el autorizado\' alt=\'El presupuesto solicitado excede el autorizado\'><font color=\''+color+'\'>'+Ext.util.Format.usMoney(val)+'</font></span>';
											},
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
								  hideable:true
							  },
							  {
								  header:' Autorizado Cap. ".$filaCap[1]."<br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:'usMoney',
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."_Aut',
								  hideable:true
							  },
							  {
								  header:' Diferencia Cap. ".$filaCap[1]."<br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												var diferencia=parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."_Aut)-parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0].");
												if(diferencia<0)
													color='red';
												return '<font color=\''+color+'\'>'+Ext.util.Format.usMoney(diferencia)+'</font>';
											},
								  hideable:true
							  },
							";
			}
			
		}
		$arrObj="";
		$nObjetos="0";
		$consulta="select distinct o.clave,codigoControl,nombreObjetoGasto from 9110_objetosGastoVSCiclo t,507_objetosGasto o where 
					o.codigoControl=t.clave and  (t.clave like '".$capitulo."%' or t.clave='".$capitulo."') and t.idPrograma=".$idPrograma." and t.ruta='".$ruta."' and t.numEtapa=5";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			if(mysql_num_rows($resFuenteFinanciamento)>0)
			{
				mysql_data_seek($resFuenteFinanciamento,0);
				
			}
			$nObjetos++;
			$objBase='{"cveObj":"'.$fila[0].'","objetoGasto":"'.$fila[1].'","nombreGasto":"'.$fila[2].'"';
			$totalRuta=0;
			while($filaFuente=mysql_fetch_row($resFuenteFinanciamento))
			{
				$obj=$objBase;
				$consulta="select sum(montoTotal) from 9110_objetosGastoVSCiclo where tipoPresupuesto=".$filaFuente[0]." and clave='".$fila[1]."' and idPrograma=".$idPrograma." and ruta='".$ruta."' and numEtapa=5";
				$montoSolicitado=$con->obtenerValor($consulta);
				
				$montoAutorizado=0;
				$consulta="SELECT SUM(montoAutorizado) FROM 523_techosAutorizadosConcentradora WHERE ciclo=".$ciclo." and idPrograma=".$idPrograma." and ruta='".$ruta."' and fuenteFinanciamiento=".$filaFuente[0]."
						and objetoGasto='".$fila[1]."' and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
				$montoAutorizado=$con->obtenerValor($consulta);	
				if($montoAutorizado=="")	
					$montoAutorizado=0;
				$obj.=',"cap_'.$capitulo.'_'.$filaFuente[0].'":"'.$montoSolicitado.'","cap_'.$capitulo.'_'.$filaFuente[0].'_Aut":"'.$montoAutorizado.'"';
				$totalRuta+=$montoSolicitado;
			}
			$obj.=',"total":"'.$totalRuta.'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		
		
		$columnas=	"	
						
						{
							header:'',
							width:60,
							sortable:true,
							dataIndex:'cveObj',
							hideable:true
						},
					   	 {
															header:'',
															width:60,
															sortable:true,
															dataIndex:'objetoGasto',
                                                            hideable:true,
                                                            renderer:function (val,meta,registro)
                                                            		{
                                                                    	return \"<a href='javascript:modificar(\\\"\"+bE(val)+\"\\\")'><img src='../images/pencil.png' /></a>\";
                                                                    }
														},
						{
							header:'Objeto de gasto',
							width:350,
							sortable:true,
							dataIndex:'nombreGasto',
							hideable:true
						},
						".$cadColumnas."
						{
							header:'Monto total',
							width:120,
							align :'right',
							sortable:true,
							dataIndex:'total',
							renderer:'usMoney',
							summaryType:'sum',
							hideable:true
						}
					";
		
		$campos="	{name:'cveObj'},
				  	{name:'nombreGasto'},
					{name:'objetoGasto'},
				  	".$cadCampos."
				  	{name:'total'}";
					
		echo '{"metaData":{"root":"registros","totalProperty":"numReg","fields":['.$campos.']},"numReg":"'.$nObjetos.'","registros":['.$arrObj.'],"campos":['.$columnas.']}';
	}
	
	function obtenerTechoPresupuestalProgramaDepto()
	{
		global $con;
		$arrObj="";
		$nObjetos=0;
		$ciclo=$_POST["ciclo"];
		$ruta=$_POST["ruta"];
		$idPrograma=$_POST["idPrograma"];
		$capitulo=$_POST["capitulo"];
		$depto=$_POST["depto"];
		$cadCampos="";
		$cadColumnas="";
		
		
		$consulta="SELECT DISTINCT o.codigoControl,o.clave FROM 507_objetosGasto o WHERE o.codigoControl='".$capitulo."'";
		$filaCap=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT DISTINCT t.fuenteFinanciamiento,p.tituloTipoP FROM 523_techosPresupuestales t,508_tiposPresupuesto p WHERE t.ciclo=".$ciclo." and programaInstitucional=".$idPrograma." and ruta='".$ruta."' and departamento='".$depto."'
					and (t.objetoGasto like '".$capitulo."%' or t.objetoGasto='".$capitulo."')   and p.idTipoPresupuesto=t.fuenteFinanciamiento";
		$resFuenteFinanciamento=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resFuenteFinanciamento))
		{
			
			if($cadCampos=="")
			{
				$cadColumnas="
								{
								  header:' Solicitado <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												if(parseFloat(val)>parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."))
													color='red';
												return '<span title=\'El presupuesto solicitado excede el techo presupuestal\' alt=\'El presupuesto solicitado excede  excede el techo presupuestal\'><font color=\''+color+'\'>'+Ext.util.Format.usMoney(val)+'</font></span>';
											},
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."_Sol',
								  hideable:true
							  },
								{
								  header:' Techo <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:'usMoney',
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
								  hideable:true
							  },
							  
							  {
								  header:' Disponible <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												var diferencia=parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0].")-parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."_Sol);
												if(diferencia<0)
													color='red';
												return '<font color=\''+color+'\'>'+Ext.util.Format.usMoney(diferencia)+'</font>';
											},
								  hideable:true
							  },
							  ";
				$cadCampos="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},{name: 'cap_".$filaCap[0]."_".$fila[0]."_Sol'},";
			}
			else
			{
				$cadCampos.="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},{name: 'cap_".$filaCap[0]."_".$fila[0]."_Sol'},";
				$cadColumnas.=",
							{
								  header:' Solicitado <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												if(parseFloat(val)>parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."))
													color='red';
												return '<span title=\'El presupuesto solicitado excede el techo presupuestal\' alt=\'El presupuesto solicitado excede  excede el techo presupuestal\'><font color=\''+color+'\'>'+Ext.util.Format.usMoney(val)+'</font></span>';
											},
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."_Sol',
								  hideable:true
							  },
								{
								  header:' Techo <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:'usMoney',
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
								  hideable:true
							  },
							 
							  {
								  header:' Disponible <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												var diferencia=parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0].")-parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."_Sol);
												if(diferencia<0)
													color='red';
												return '<font color=\''+color+'\'>'+Ext.util.Format.usMoney(diferencia)+'</font>';
											},
								  hideable:true
							  },
							";
			}
			
		}
		$arrObj="";
		$nObjetos="0";
		
		$consulta="SELECT partidas FROM 9130_departamentoVSPrograma WHERE ciclo=".$ciclo." AND idPrograma=".$idPrograma." AND ruta='".$ruta."' AND codigoUnidad='".$depto."'";
		$listPartidas=$con->obtenerValor($consulta);
		
		$obj="";
			
		$consulta="select distinct o.clave,codigoControl,nombreObjetoGasto from 507_objetosGasto o where  codigoControl in (".$listPartidas.") and codigoControl like '".$capitulo."%'";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			if(mysql_num_rows($resFuenteFinanciamento)>0)
			{
				mysql_data_seek($resFuenteFinanciamento,0);
				
			}
			$nObjetos++;
			$objBase='{"cveObj":"'.$fila[0].'","objetoGasto":"'.$fila[1].'","nombreGasto":"'.$fila[2].'"';
			$totalRuta=0;
			while($filaFuente=mysql_fetch_row($resFuenteFinanciamento))
			{
				
				$consulta="SELECT techoPresupuestal FROM 523_techosPresupuestales WHERE ciclo=".$ciclo." AND programaInstitucional=".$idPrograma." AND ruta='".$ruta."' AND departamento='".$depto."' AND objetoGasto='".$fila[1]."'";
				$montoTecho=$con->obtenerValor($consulta);
				if($montoTecho=="")	
					$montoTecho=0;
				
				$consulta="SELECT SUM(montoTotal) FROM 9110_objetosGastoVSCiclo o WHERE idCiclo=".$ciclo." AND codDepto='".$depto."' AND idPrograma=".$idPrograma." AND ruta='".$ruta."' AND clave='".$fila[1]."' and numEtapa not in (6,7,8)";
				$montoSolicitado=$con->obtenerValor($consulta);	
				if($montoSolicitado=="")	
					$montoSolicitado=0;
				$obj=$objBase;
				$obj.=',"cap_'.$capitulo.'_'.$filaFuente[0].'":"'.$montoTecho.'","cap_'.$capitulo.'_'.$filaFuente[0].'_Sol":"'.$montoSolicitado.'"';
				$totalRuta+=$montoTecho;
				$obj.=',"total":"'.$totalRuta.'"}';
			}
			if($totalRuta!=0)
			{
				if($arrObj=="")
					$arrObj=$obj;
				else
					$arrObj.=",".$obj;
			}
		}
		
		
		$columnas=	"	
						
						{
							header:'',
							width:60,
							sortable:true,
							dataIndex:'cveObj',
							hideable:true
						},
					   
						{
							header:'Objeto de gasto',
							width:350,
							sortable:true,
							dataIndex:'nombreGasto',
							hideable:true
						},
						".$cadColumnas."
						{
							header:'Monto total',
							width:120,
							align :'right',
							sortable:true,
							dataIndex:'total',
							renderer:'usMoney',
							summaryType:'sum',
							hideable:true
						}
					";
		
		$campos="	{name:'cveObj'},
				  	{name:'nombreGasto'},
					{name:'objetoGasto'},
				  	".$cadCampos."
				  	{name:'total'}";
					
		echo '{"metaData":{"root":"registros","totalProperty":"numReg","fields":['.$campos.']},"numReg":"'.$nObjetos.'","registros":['.$arrObj.'],"campos":['.$columnas.']}';
		
		
	}
	
	function obtenerTechoPresupuestalPrograma()
	{
		global $con;
		$arrObj="";
		$nObjetos=0;
		$ciclo=$_POST["ciclo"];
		$ruta=$_POST["ruta"];
		$idPrograma=$_POST["idPrograma"];
		$capitulo=$_POST["capitulo"];
		$arrCapitulos=explode(",",$capitulo);
		$capitulo=substr($capitulo[0],0,3);

		$cadCampos="";
		$cadColumnas="";
		$consulta="SELECT DISTINCT o.codigoControl,o.clave FROM 507_objetosGasto o WHERE o.codigoControl='".$capitulo."'";
		$filaCap=$con->obtenerPrimeraFila($consulta);
		$consulta="SELECT DISTINCT t.fuenteFinanciamiento,p.tituloTipoP FROM 523_techosPresupuestales t,508_tiposPresupuesto p WHERE t.ciclo=".$ciclo." and programaInstitucional=".$idPrograma." and ruta='".$ruta."'
					and (t.objetoGasto like '".$capitulo."%' or t.objetoGasto='".$capitulo."')   and p.idTipoPresupuesto=t.fuenteFinanciamiento";
		$resFuenteFinanciamento=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resFuenteFinanciamento))
		{
			if($cadCampos=="")
			{
				$cadColumnas="
								{
								  header:' Solicitado <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												if(parseFloat(val)>parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."))
													color='red';
												return '<span title=\'El presupuesto solicitado excede el techo presupuestal\' alt=\'El presupuesto solicitado excede  excede el techo presupuestal\'><font color=\''+color+'\'>'+Ext.util.Format.usMoney(val)+'</font></span>';
											},
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."_Sol',
								  hideable:true
							  },
								{
								  header:' Techo <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:'usMoney',
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
								  hideable:true
							  },
							  
							  {
								  header:' Diferencia <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												var diferencia=parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0].")-parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."_Sol);
												if(diferencia<0)
													color='red';
												return '<font color=\''+color+'\'>'+Ext.util.Format.usMoney(diferencia)+'</font>';
											},
								  hideable:true
							  },
							  ";
				$cadCampos="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},{name: 'cap_".$filaCap[0]."_".$fila[0]."_Sol'},";
			}
			else
			{
				$cadCampos.="{name: 'cap_".$filaCap[0]."_".$fila[0]."'},{name: 'cap_".$filaCap[0]."_".$fila[0]."_Sol'},";
				$cadColumnas.=",
							{
								  header:' Solicitado <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												if(parseFloat(val)>parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."))
													color='red';
												return '<span title=\'El presupuesto solicitado excede el techo presupuestal\' alt=\'El presupuesto solicitado excede  excede el techo presupuestal\'><font color=\''+color+'\'>'+Ext.util.Format.usMoney(val)+'</font></span>';
											},
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."_Sol',
								  hideable:true
							  },
								{
								  header:' Techo <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:'usMoney',
								  dataIndex:'cap_".$filaCap[0]."_".$fila[0]."',
								  hideable:true
							  },
							 
							  {
								  header:' Diferencia <br>(".$fila[1].")',
								  width:140,
								  sortable:true,
								  align :'right',
								  summaryType:'sum',
								  renderer:function(val,meta,registro)
								  			{
												var color='green';
												var diferencia=parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0].")-parseFloat(registro.data.cap_".$filaCap[0]."_".$fila[0]."_Sol);
												if(diferencia<0)
													color='red';
												return '<font color=\''+color+'\'>'+Ext.util.Format.usMoney(diferencia)+'</font>';
											},
								  hideable:true
							  },
							";
			}
			
		}
		$arrObj="";
		$nObjetos="0";
		$consulta="SELECT objetoGasto FROM 523_techosPresupuestales WHERE ciclo=".$ciclo." AND programaInstitucional=".$idPrograma." AND ruta='".$ruta."' AND capitulo IN (".$capitulo.")";
		$listPartidas=$con->obtenerValor($consulta);
		if($listPartidas=="")
			$listPartidas="-1";
		$consulta="select distinct o.clave,codigoControl,nombreObjetoGasto from 507_objetosGasto o where  codigoControl in (".$listPartidas.")";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			if(mysql_num_rows($resFuenteFinanciamento)>0)
			{
				mysql_data_seek($resFuenteFinanciamento,0);
				
			}
			$nObjetos++;
			$objBase='{"cveObj":"'.$fila[0].'","objetoGasto":"'.$fila[1].'","nombreGasto":"'.$fila[2].'"';
			$totalRuta=0;
			while($filaFuente=mysql_fetch_row($resFuenteFinanciamento))
			{
				$obj=$objBase;
				$consulta="SELECT techoPresupuestal FROM 523_techosPresupuestales WHERE ciclo=".$ciclo." AND programaInstitucional=".$idPrograma." AND ruta='".$ruta."' AND objetoGasto='".$fila[1]."'";
				$montoTecho=$con->obtenerValor($consulta);
				if($montoTecho=="")	
					$montoTecho=0;
				
				$consulta="SELECT SUM(montoTotal) FROM 9110_objetosGastoVSCiclo o WHERE idCiclo=".$ciclo." AND  idPrograma=".$idPrograma." AND ruta='".$ruta."' AND clave='".$fila[1]."'";
				$montoSolicitado=$con->obtenerValor($consulta);	
				if($montoSolicitado=="")	
					$montoSolicitado=0;
				$obj.=',"cap_'.$capitulo.'_'.$filaFuente[0].'":"'.$montoTecho.'","cap_'.$capitulo.'_'.$filaFuente[0].'_Sol":"'.$montoSolicitado.'"';
				$totalRuta+=$montoTecho;
			}
			$obj.=',"total":"'.$totalRuta.'"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		$columnas=	"	
						
						{
							header:'',
							width:60,
							sortable:true,
							dataIndex:'cveObj',
							hideable:true
						},
					   
						{
							header:'Objeto de gasto',
							width:350,
							sortable:true,
							dataIndex:'nombreGasto',
							hideable:true
						},
						".$cadColumnas."
						{
							header:'Monto total',
							width:120,
							align :'right',
							sortable:true,
							dataIndex:'total',
							renderer:'usMoney',
							summaryType:'sum',
							hideable:true
						}
					";
		
		$campos="	{name:'cveObj'},
				  	{name:'nombreGasto'},
					{name:'objetoGasto'},
				  	".$cadCampos."
				  	{name:'total'}";
					
		echo '{"metaData":{"root":"registros","totalProperty":"numReg","fields":['.$campos.']},"numReg":"'.$nObjetos.'","registros":['.$arrObj.'],"campos":['.$columnas.']}';
		
		
	}
	
	function clonarTechoPresupuestal()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$capitulo=$_POST["capitulo"];
		$x=0;
		$query[$x]="begin";
		$x++;
		$consulta="SELECT DISTINCT ruta,programaInstitucional,objetoGasto,fuenteFinanciamiento FROM 523_techosPresupuestales WHERE ciclo=".$ciclo." AND codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and capitulo='".$capitulo."'";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select sum(techoPresupuestal) from 523_techosPresupuestales where ruta='".$fila[0]."' and programaInstitucional=".$fila[1]." and objetoGasto='".$fila[2]."' 
						and fuenteFinanciamiento=".$fila[3]." and ciclo=".$ciclo." and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
			$total=$con->obtenerValor($consulta);	
			$query[$x]="INSERT INTO 523_techosAutorizadosConcentradora(ruta,idPrograma,objetoGasto,fuenteFinanciamiento,montoAutorizado,capitulo,ciclo,codigoInstitucion) 
						VALUES('".$fila[0]."',".$fila[1].",'".$fila[2]."',".$fila[3].",".$total.",'".$capitulo."',".$ciclo.",'".$_SESSION["codigoInstitucion"]."')";
			$x++;					
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function guardarFactorInflacion()
	{
		global $con;
		$factor=$_POST["factor"];
		$ciclo=$_POST["ciclo"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from  523_factorInflacion where ciclo=".$ciclo." and codigoInstitucion='".$_SESSION["codigoInstitucion"]."'";
		$x++;
		$consulta[$x]="INSERT INTO 523_factorInflacion(factor,ciclo,codigoInstitucion) values(".$factor.",".$ciclo.",'".$_SESSION["codigoInstitucion"]."')";
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	
	function obtenerPresupuestoIngresoAutorizado()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
			
		$consulta="SELECT distinct cmbTipoIngreso FROM _578_tablaDinamica sc,_580_tablaDinamica s WHERE s.id__580_tablaDinamica=sc.cmbServicios AND sc.cmbCiclo=".$ciclo." and ".$cadCondWhere." order by cmbTipoIngreso";
		$resPres=$con->obtenerFilas($consulta);
		$ct=0;
		$arrObj="";
		$nRegistros=0;
		while($fila=mysql_fetch_row($resPres))
		{
			$consulta="SELECT id__580_tablaDinamica FROM _578_tablaDinamica sc,_580_tablaDinamica s WHERE s.id__580_tablaDinamica=sc.cmbServicios AND sc.cmbCiclo=".$ciclo." and cmbTipoIngreso=".$fila[0];
			$listServicios=$con->obtenerListaValores($consulta);
			if($listServicios=="")	
				$listServicios=-1;
			$arrMeses="";
			$consulta="SELECT * FROM 564_proyeccionCostoServicio WHERE ciclo=".$ciclo." AND idServicio in(".$listServicios.")";
			$resProy=$con->obtenerFilas($consulta);
			$arrMontos=array();
			$arrMontos[0]=0;
			$arrMontos[1]=0;
			$arrMontos[2]=0;
			$arrMontos[3]=0;
			$arrMontos[4]=0;
			$arrMontos[5]=0;
			$arrMontos[6]=0;
			$arrMontos[7]=0;
			$arrMontos[8]=0;
			$arrMontos[9]=0;
			$arrMontos[10]=0;
			$arrMontos[11]=0;
			$montoTotal=0;
			while($filaProy=mysql_fetch_row($resProy))
			{
				$arrMontos[0]+=$filaProy[8]*$filaProy[5];
				$arrMontos[1]+=$filaProy[9]*$filaProy[5];
				$arrMontos[2]+=$filaProy[10]*$filaProy[5];
				$arrMontos[3]+=$filaProy[11]*$filaProy[5];
				$arrMontos[4]+=$filaProy[12]*$filaProy[5];
				$arrMontos[5]+=$filaProy[13]*$filaProy[5];
				$arrMontos[6]+=$filaProy[14]*$filaProy[5];
				$arrMontos[7]+=$filaProy[15]*$filaProy[5];
				$arrMontos[8]+=$filaProy[16]*$filaProy[5];
				$arrMontos[9]+=$filaProy[17]*$filaProy[5];
				$arrMontos[10]+=$filaProy[18]*$filaProy[5];
				$arrMontos[11]+=$filaProy[19]*$filaProy[5];
				
				
			}
			for($x=0;$x<12;$x++)
			{
				
				$montoTotal+=$arrMontos[$x];
				$objMes='"mes'.$x.'":"'.$arrMontos[$x].'","mes'.$x.'Ajuste":"0"';
				$arrMeses.=",".$objMes;
			}
			$consulta="SELECT txtConceptoIngreso FROM _945_tablaDinamica WHERE id__945_tablaDinamica=".$fila[0];
			$nConcepto=$con->obtenerValor($consulta);
			$obj='	{
						"idConceptoIngreso":"'.$fila[0].'",
						"nombreConcepto":"'.$nConcepto.'",
						"montoTotal":"'.$montoTotal.'",
						"montoAjustado":"0"'.$arrMeses.'
						
					}';
			if($arrObj=="")	
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
			$nRegistros++;
		}
		$nRegistros--;
		echo '{"numReg":"'.$nRegistros.'","registros":['.$arrObj.']}';
	}
	
	function obtenerPresupuestoIngresoAutorizadoDetalle()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$idConcepto=$_POST["idConcepto"];
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
			
		$consulta="SELECT id__580_tablaDinamica,txtClave,txtEstudio FROM _578_tablaDinamica sc,_580_tablaDinamica s WHERE s.id__580_tablaDinamica=sc.cmbServicios AND sc.cmbCiclo=".$ciclo." and cmbTipoIngreso=".$idConcepto." 
					and ".$cadCondWhere." order by txtClave";
					
		$resPres=$con->obtenerFilas($consulta);
		$nRegistros=$con->filasAfectadas;
		$sql=$consulta;
		$arrObj="";
		$obj="";
		$ct=0;
		while($fila=mysql_fetch_row($resPres))
		{
			$arrMeses="";
			$consulta="SELECT * FROM 564_proyeccionCostoServicio WHERE ciclo=".$ciclo." AND idServicio=".$fila[0];
			$resProy=$con->obtenerFilas($consulta);
			$arrMontos=array();
			$arrMontos[0]=0;
			$arrMontos[1]=0;
			$arrMontos[2]=0;
			$arrMontos[3]=0;
			$arrMontos[4]=0;
			$arrMontos[5]=0;
			$arrMontos[6]=0;
			$arrMontos[7]=0;
			$arrMontos[8]=0;
			$arrMontos[9]=0;
			$arrMontos[10]=0;
			$arrMontos[11]=0;
			$montoTotal=0;
			while($filaProy=mysql_fetch_row($resProy))
			{
				$arrMontos[0]+=$filaProy[8]*$filaProy[5];
				$arrMontos[1]+=$filaProy[9]*$filaProy[5];
				$arrMontos[2]+=$filaProy[10]*$filaProy[5];
				$arrMontos[3]+=$filaProy[11]*$filaProy[5];
				$arrMontos[4]+=$filaProy[12]*$filaProy[5];
				$arrMontos[5]+=$filaProy[13]*$filaProy[5];
				$arrMontos[6]+=$filaProy[14]*$filaProy[5];
				$arrMontos[7]+=$filaProy[15]*$filaProy[5];
				$arrMontos[8]+=$filaProy[16]*$filaProy[5];
				$arrMontos[9]+=$filaProy[17]*$filaProy[5];
				$arrMontos[10]+=$filaProy[18]*$filaProy[5];
				$arrMontos[11]+=$filaProy[19]*$filaProy[5];
				
				
			}
			for($x=0;$x<12;$x++)
			{
				
				$montoTotal+=$arrMontos[$x];
				$objMes='"mes'.$x.'":"'.$arrMontos[$x].'","mes'.$x.'Ajuste":"0"';
				$arrMeses.=",".$objMes;
			}
			
			$obj='	{
						"idServicio":"'.$fila[0].'",
						"txtClave":"'.$fila[1].'",
						"txtEstudio":"'.cv($fila[2]).'",
						"montoTotal":"'.$montoTotal.'",
						"montoAjustado":"0"'.$arrMeses.'
						
					}';
			if($arrObj=="")	
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
			$ct++;
		}
		
		echo '{"numReg":"'.$nRegistros.'","sql":"'.bE($sql).'","registros":['.$arrObj.']}';
	}
	
	function obtenerProgramasPresupuestarios()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		echo "1|".obtenerProgramasInstitucionalesVigentes($idCiclo,2);
	}
	
	function obtenerDepartamentoProgramas()
	{
		global $con;
		$idPrograma=$_POST["idPrograma"];
		$consulta="SELECT o.codigoUnidad,concat('[',o.codigoDepto,'] ',o.unidad) FROM  9130_departamentoVSPrograma d,817_organigrama o WHERE d.idPrograma=".$idPrograma." AND d.codigoUnidad=o.codigoUnidad ORDER BY o.unidad";
		$arrDatos=$con->obtenerFilasArreglo($consulta);
		echo "1|".$arrDatos;	
	}
	
	function obtenerPartidasPermitidasProgramaDepto()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		$idPrograma=$_POST["idPrograma"];
		if($idPrograma=="")
			$idPrograma=-1;
		$depto=$_POST["depto"];
		if($depto=="")
			$depto=-1;
		$capitulo=$_POST["capitulo"];
		$tipoPresupuesto=$_POST["tipoPresupuesto"];	
		$consulta="SELECT partidas FROM 9130_departamentoVSPrograma WHERE idPrograma=".$idPrograma." AND codigoUnidad='".$depto."'";
		$partidas=$con->obtenerListaValores($consulta);
		if($partidas=="-1")
			$partidas=-1;
		$consulta="SELECT codigoControl,clave,nombreObjetoGasto FROM 507_objetosGasto WHERE codigoControl like '".$capitulo."%' and codigoControl IN (".$partidas.") ORDER BY clave,nombreObjetoGasto";	

		$arrReg=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrReg).'}';
	}
	
	function registrarPartidaPresupuestariaProgramaDepto()
	{
		global $con;
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		foreach($obj->registros as $r)
		{
			$consulta[$x]="INSERT INTO 523_presupuestoAutorizado(ciclo,programa,depto,capitulo,partida,montoTotal,montoAjustado,tipoPresupuesto,institucion)					
			VALUES(".$r->idCiclo.",".$r->idPrograma.",'".$r->departamento."','".$r->capitulo."','".$r->partida."',0,0,".$r->tipoPresupuesto.",'".$_SESSION["codigoInstitucion"]."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			for($mes=0;$mes<12;$mes++)
			{
				$consulta[$x]="INSERT INTO 523_distribucionPresupuestoAutorizado(idPresupuestoAutorizado,nDistribucion,monto,montoAjustado) VALUES(@idRegistro,".$mes.",0,0)";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
	}
	
	function obtenerPresupuestoProgramaDepto()
	{
		global $con;
		$ciclo=$_POST["ciclo"];
		$comp='';
		if(isset($_POST["capitulo"]))
			$comp=" and p.capitulo='".$_POST["capitulo"]."'";
		$condWhere="";
		if(isset($_POST["depto"]))
			$condWhere=' and depto="'.$_POST["depto"].'"';
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);	
			
			
		$consulta="SELECT p.idPresupuestoAutorizado,p.programa,pr.cvePrograma,pr.tituloPrograma,p.depto,codigoDepto,o.unidad,p.partida,
				clave,nombreObjetoGasto ,p.montoTotal,p.montoAjustado,idTipoPresupuesto,tp.tituloTipoP,
				(select concat('[',clave,'] ',nombreObjetoGasto) from 507_objetosGasto where codigoControl=p.capitulo) as nCapitulo FROM 523_presupuestoAutorizado p, 
				508_tiposPresupuesto tp,517_programas pr,817_organigrama o,507_objetosGasto ob,9117_estructurasVSPrograma e	WHERE e.idEstructuraVSPrograma=p.programa ".$comp." and o.codigoUnidad=p.depto and pr.idPrograma=e.idProgramaInstitucional 
				and tp.idTipoPresupuesto=p.tipoPresupuesto and  ob.codigoControl=p.partida and p.ciclo=".$ciclo." AND p.institucion='".$_SESSION["codigoInstitucion"]."' ".$condWhere." and ".$cadCondWhere." order by p.depto";

		$resPres=$con->obtenerFilas($consulta);
		$nRegistros=$con->filasAfectadas;
		$sql=$consulta;
		$arrObj="";
		$obj="";
		$ct=0;
		
		$arrRutas=obtenerProgramasInstitucionalesVigentes($ciclo,1);
		while($fila=mysql_fetch_row($resPres))
		{
			$arrMeses='';
			$consulta="SELECT nDistribucion,monto,montoAjustado FROM 523_distribucionPresupuestoAutorizado WHERE  idPresupuestoAutorizado=".$fila[0]." ORDER BY nDistribucion";
			$resDist=$con->obtenerFilas($consulta);
				
			if($con->filasAfectadas>0)
			{
				
				while($f=mysql_fetch_row($resDist))
				{
					$objMes='"mes'.$f[0].'":"'.$f[1].'","mes'.$f[0].'Ajuste":"'.$f[2].'"';
					$arrMeses.=",".$objMes;
				}
			}
			else
			{
				for($nMes=0;$nMes<12;$nMes++)
				{
					$objMes='"mes'.$nMes.'":"0","mes'.$nMes.'Ajuste":"0"';
					$arrMeses.=",".$objMes;
				}
				
			}
			if(isset($arrRutas[$fila[1]]))
			{
				$obj='	{
							"idPresupuestoAutorizado":"'.$fila[0].'",
							"programa":"'.$fila[1].'",
							"nPrograma":"'.$arrRutas[$fila[1]].'",
							"depto":"'.$fila[3].'",
							"codigoDepto":"'.$fila[5].'",
							"unidad":"'.$fila[6].'",
							"partida":"'.$fila[7].'",
							"clave":"'.$fila[8].'",
							"nombreObjetoGasto":"'.$fila[9].'",
							"montoTotal":"'.$fila[10].'",
							"montoAjustado":"'.$fila[11].'",
							"idTipoPresupuesto":"'.$fila[12].'",
							"nCapitulo":"'.$fila[14].'",
							"nPartida":"'."[".$fila[8]."] ".$fila[9].'",
							"nTipoPresupuesto":"'.$fila[13].'"'.$arrMeses.'
						}';
				if($arrObj=="")	
					$arrObj=$obj;
				else
					$arrObj.=",".$obj;
				$ct++;
			}
		}
		
		echo '{"numReg":"'.$nRegistros.'","sql":"'.bE($sql).'","registros":['.$arrObj.']}';
	}
	
	function guardarMontoPresupuestoMes()
	{
		global $con;
		$mes=$_POST["mes"];
		$idRegistro=$_POST["idRegistro"];
		$valor=$_POST["valor"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE 523_distribucionPresupuestoAutorizado SET monto=".$valor.",montoAjustado=".$valor." WHERE idPresupuestoAutorizado=".$idRegistro." AND nDistribucion=".$mes;
		$x++;
		$consulta[$x]="set @total:=(SELECT SUM(montoAjustado) FROM 523_distribucionPresupuestoAutorizado WHERE idPresupuestoAutorizado=".$idRegistro.")";
		$x++;
		$consulta[$x]="UPDATE 523_presupuestoAutorizado SET montoTotal=@total,	montoAjustado=@total WHERE idPresupuestoAutorizado=".$idRegistro;
		$x++;				

		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select @total";
			$total=$con->obtenerValor($query);
			echo "1|".$total;
		}
	}
	
	function obtenerSituacionPresupuestoCiclo()
	{
		global $con;
		$idCiclo=$_POST["idCiclo"];
		

		$lblSituacion="";
		$idSituacion=0;
		$consulta="SELECT COUNT(*) FROM 2000_cierresCicloProcesos WHERE ciclo=".$idCiclo." AND tipoCierre=10";
		$nReg=$con->obtenerValor($consulta);
		if($nReg==0)
		{
			$lblSituacion="En diseño";	
		}
		else
		{
			$lblSituacion= "Bloqueado";
			$idSituacion=2;	
		}
		echo '1|{"lblSituacion":"'.$lblSituacion.'","idSituacion":"'.$idSituacion.'"}';
		
	}
	
	function bloquearDefinicionPresupuesto()
	{
		global $con;
		$arrMovimientos=array();
		$idCiclo=$_POST["idCiclo"];
		$tipoMovimiento=20;
		
		$consulta="SELECT * FROM 523_presupuestoAutorizado WHERE ciclo=".$idCiclo;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrDimensiones=array();
			$arrDimensiones["idPrograma"]=$fila[2];
			$arrDimensiones["codigoUnidad"]=$fila[3];
			$arrDimensiones["idPartida"]=$fila[5];
			$arrDimensiones["idTipoPresupuesto"]=$fila[8];
			$consulta="SELECT montoAjustado,nDistribucion FROM 523_distribucionPresupuestoAutorizado WHERE idPresupuestoAutorizado=".$fila[0]." AND montoAjustado>0";
			$resMonto=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_row($resMonto))
			{
				$arrDimensiones["idMes"]=$fila[1];
				$cadObj='{"tipoMovimiento":"'.$tipoMovimiento.'","montoOperacion":"'.$fila[0].'","dimensiones":null}';
				$obj=json_decode($cadObj);
				$obj->dimensiones=$arrDimensiones;
				array_push($arrMovimientos,$obj);
				
			}
		}
		$c=new cContabilidad($idCiclo);
		$vNull=null;
		$vNull2=null;
		if($c->asentarArregloMovimientos($arrMovimientos,$vNull,$vNull2,true))
		{

			$consulta="INSERT INTO 2000_cierresCicloProcesos(ciclo,codigoInstitucion,fechaCierre,idResponsableCierre,tipoCierre) VALUES(".$idCiclo.",'".$_SESSION["codigoInstitucion"]."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",10)";
			eC($consulta);
		}
		
	}
	
	
	function obtenerSituacionPresupuestalCiclo()
	{
		global $con;
		$rContabilidad=new cContabilidad();
		$iRegistro=bD($_POST["iRegistro"]);
		$iMonto=bD($_POST["iMonto"]);
		$arrTiempos="";
		$consulta="SELECT programa,depto,partida,ciclo,ruta,capitulo,tipoPresupuesto FROM 523_presupuestoAutorizado WHERE idPresupuestoAutorizado=".$iRegistro;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$programa=$fRegistro[0];
		$depto=$fRegistro[1];
		$partida=$fRegistro[2];
		$ciclo=$fRegistro[3];
		$ruta=$fRegistro[4];
		$capitulo=$fRegistro[5];
		$tipoPresupuesto=$fRegistro[6];
		$comp="";
		$arrDimensiones=array();
		if($iMonto!=0)
			$arrDimensiones["idMes"]=($iMonto-1);

		$arrDimensiones["idPrograma"]=$programa;
		$arrDimensiones["codigoUnidad"]=$depto;
		$arrDimensiones["idPartida"]=$partida;
		$arrDimensiones["idTipoPresupuesto"]=$tipoPresupuesto;	

		
		
		$consulta="SELECT idTiempoPresupuestal,nombreTiempo FROM 524_tiemposPresupuestales ORDER BY idTiempoPresupuestal";
		$resTiempo=$con->obtenerFilas($consulta);
		$montoTotal=0;
		while($filaTiempo=mysql_fetch_row($resTiempo))
		{
			$montoPres=$rContabilidad->obtenerSaldoPresupuesto($filaTiempo[0],$arrDimensiones);
			$obj='{"idTiempo":"'.$filaTiempo[0].'","tiempo":"'.$filaTiempo[1].'","monto":"'.$montoPres.'"}';
			$montoTotal+=$montoPres;
			if($arrTiempos=="")
				$arrTiempos=$obj;
			else
				$arrTiempos.=",".$obj;
		}
		$arrTiempos.=',{"idTiempo":"0","tiempo":"<font color=\'red\'><b>Total: </b></font>","monto":"'.$montoTotal.'"}';
		echo '{"registros":['.$arrTiempos.']}';
	}
	
	function verificarSuficienciaPresupuestalCiclo()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$idCiclo=$obj->idCiclo;
		$arrDimensiones=array();
		$arrDimensiones["idPrograma"]=$obj->programa;
		$arrDimensiones["codigoUnidad"]=$obj->departamento;
		$arrDimensiones["idPartida"]=$obj->partida;
		$arrDimensiones["idTipoPresupuesto"]=$obj->tipoPresupuesto;
		
		$c=new cContabilidad($idCiclo);
		if($c->existeSuficienciaPresupuestal(1,$arrDimensiones,$obj->monto)==0)
			echo "1|1";
		else
			echo "1|0";
	}
	
	function obtenerSituacionPresupuestalVisorBase()
	{
		global $con;
		$c=new cContabilidad();
		$arrDimensiones=array();
		$aDimensiones=bD($_POST["aDimensiones"]);
		$obj=json_decode($aDimensiones);
		
		$cDimensiones=array();
		
		$consulta="SELECT d.idDimension,nombreDimension,idFuncionInterpretacion,nombreEstructura FROM 524_perfilPresupuestalVSDimensiones p,563_dimensiones d WHERE idPerfilPresupuestal=2 AND p.idDimension=d.idDimension ORDER BY orden";
		$resDimension=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($resDimension))
		{
			$cDimensiones[$fila[3]]=$fila;	
		}
	
		$llaveId="";
		$cadDimensiones="";
		$ultimaDimension="";
		foreach($obj->arrDimensiones as $d)
		{
			foreach($d as $propiedad=>$valor)
			{
				$arrDimensiones[$propiedad]=$valor;
				$ultimaDimension=$propiedad;
				$oLlave="";
				if($valor!="")
					$oLlave=$propiedad.":".$valor;
				else
					$oLlave=$propiedad.":@valor";
				if($llaveId=="")
					$llaveId=$oLlave;
				else
					$llaveId.=",".$oLlave;
			}
		}
		$sigDimension="";
		$posDimension=0;
		$nDimensiones=sizeof($cDimensiones);
		foreach($cDimensiones as $id=>$resto)
		{
			if($id==$ultimaDimension)
			{
					break;
			}
			$posDimension++;
			
		}
		if($posDimension<$nDimensiones-1)
		{
			$posDimension++;
			$numAux=0;
			foreach($cDimensiones as $id=>$resto)
			{
				if($numAux==$posDimension)
				{
					$sigDimension=$id;
					break;
				}
				$numAux++;
			}
		}
		$comp="";
		if($sigDimension!="")
			$llaveId.=','.$sigDimension.":";
		else
			$comp=',"leaf":true';
		$arrValoresDimension=array();
		if($arrDimensiones[$ultimaDimension]=="")
		{
			$dimensiones=array();
			
			foreach($arrDimensiones as $id=>$valor)	
			{
				if($id!=$ultimaDimension)
				{
					$dimensiones[$id]=$valor;
				}
			}
			
			$listAsiento=$c->obtenerIdAsientoPresupuestal($dimensiones,$obj->idPerfilPresupuestal);
			if($listAsiento!="")
			{
				$consulta="SELECT DISTINCT valorCampo FROM 571_detallesAsientoPresupuestal WHERE idAsiento IN(".$listAsiento.") AND idDimension=".$cDimensiones[$ultimaDimension][0];
				
				$listValores=$con->obtenerListaValores($consulta);
				if($listValores!="")
				{
					$arrValoresDimension=explode(",",$listValores);
				}
				else
					return;
			}
		}
		else
		{
			array_push($arrValoresDimension,$arrDimensiones[$ultimaDimension]);
		}
		
		$arrRenderer=array();
		
		$arrNodos="";
		if(sizeof($arrValoresDimension)>0)
		{
			foreach($arrValoresDimension as $d)
			{
				$llaveTmp=str_replace("@valor",$d,$llaveId);
				$arrDimensiones[$ultimaDimension]=$d;
				$etiqueta=$d;
				if($cDimensiones[$ultimaDimension][2]!="")
				{
					if(isset($arrRenderer[$ultimaDimension])&&isset($arrRenderer[$ultimaDimension][$d]))
					{
						$etiqueta=$arrRenderer[$ultimaDimension][$d];
						
					}
					else
					{
						$funcionInterpretacion=$cDimensiones[$ultimaDimension][2];
						$cadObj='{"valor":""}';
						$objParam=json_decode($cadObj);
						$objParam->valor=$d;
						$cacheConsulta=NULL;
						$etiqueta=cv(removerComillasLimite(resolverExpresionCalculoPHP($funcionInterpretacion,$objParam,$cacheConsulta)	));
						$arrRenderer[$ultimaDimension][$d]=$etiqueta;
					}
						
				}
				$cadColumnas='{"icon":"../images/s.gif","loader":cargadorNodo,"id":"'.$llaveTmp.'","dimension":"'.$cDimensiones[$ultimaDimension][1].'","etiqueta":"<span title=\''.($etiqueta).'\' alt=\''.($etiqueta).'\'>'.$etiqueta.
								'</span>","montoTotal":"@montoTotal"';
				$consulta="SELECT idTiempoPresupuestal,nombreTiempo FROM 524_tiemposPresupuestales WHERE idPerfilPresupuestal=".$obj->idPerfilPresupuestal." ORDER BY orden";
				$res=$con->obtenerFilas($consulta);
				$montoTotal=0;

				while($fila=mysql_fetch_row($res))
				{
					$saldo=$c->obtenerSaldoPresupuesto($fila[0],$arrDimensiones);
					$montoTotal+=$saldo;
					if($saldo>0)
						$cadColumnas.=',"monto_'.$fila[0].'":"<a style=\'color:#04A\' onclick=desgloceMonto(\''.bE($llaveTmp).'\',\''.bE($fila[0]).'\')>$ '.number_format($saldo,2).'</a>"';
					else
						$cadColumnas.=',"monto_'.$fila[0].'":"$ '.number_format($saldo,2).'"';
				}
				if($montoTotal>0)
					$cadColumnas=str_replace("@montoTotal","<a style='color:#04A' onclick=desgloceMonto('".bE($llaveTmp)."','".bE(0)."\')>$ ".number_format($montoTotal,2)."</a>",$cadColumnas);
				else
					$cadColumnas=str_replace("@montoTotal","$ ".number_format($montoTotal,2),$cadColumnas);
				$cadColumnas.=',expanded:false'.$comp.'}';
				if($arrNodos=="")
					$arrNodos=$cadColumnas;
				else
					$arrNodos.=",".$cadColumnas;
				
			}
		}
		echo '['.$arrNodos.']';
		
		
		
	}
	
	      

	
	function obtenerDetallePresupuestal()
	{
		global $con;
		$id=$_POST["id"];
		$tPresupuestal=$_POST["tPresupuestal"];
		if($tPresupuestal==0)
			$tPresupuestal=-1;
		$idPerfil=$_POST["idPerfil"];
		$aDimensionPerfil=array();
		$consulta="SELECT d.idDimension,d.idFuncionInterpretacion FROM 524_perfilPresupuestalVSDimensiones p,563_dimensiones d WHERE idPerfilPresupuestal=".$idPerfil." AND d.idDimension=p.idDimension ORDER BY orden";
		$resDimension=$con->obtenerFilas($consulta);
		while($fDimension=mysql_fetch_row($resDimension))
		{
			$aDimensionPerfil[$fDimension[0]]=$fDimension[1];
		}
		$cacheValores=array();
		$arrDimensiones=array();
		$aDimensiones=explode(",",$id);
		foreach($aDimensiones as $d)
		{
			$aTemp=explode(":",$d);
			if($aTemp[1]!="")
			{
				$arrDimensiones[$aTemp[0]]=$aTemp[1];
			}
		}
		$c=new cContabilidad();
		$listAsientos=$c->obtenerIdAsientoPresupuestal($arrDimensiones,$idPerfil,$tPresupuestal);
		if($listAsientos=="")
			$listAsientos=-1;
		$nReg=0;
		$vDimensiones=array();
		$arrRegistros="";
		$consulta="SELECT * FROM 570_asientosPresupuestales WHERE idAsientoPresupuestal IN(".$listAsientos.")";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT idDimension,valorCampo FROM 571_detallesAsientoPresupuestal WHERE idAsiento=".$fila[0];
			$resTp=$con->obtenerFilas($consulta);
			while($fTmp=mysql_fetch_row($resTp))
			{
				$vDimensiones[$fTmp[0]]=$fTmp[1];
			}
			$montoDeposito=0;
			$montoRetiro=0;
			if($fila[4]==1)
				$montoDeposito=$fila[3];
			else
				$montoRetiro=$fila[3];
			$comp="";
			foreach($aDimensionPerfil as $id=>$fRenderer)
			{
				$valor="";
				$etiqueta="";
				if(isset($vDimensiones[$id]))
				{
					$valor=$vDimensiones[$id];
					$etiqueta=$valor;
					if(isset($cacheValores[$id])&&(isset($cacheValores[$id][$valor])))
					{
						$etiqueta=$cacheValores[$id][$valor];
					}
					else
					{
						if($fRenderer!="")
						{
							$funcionInterpretacion=$fRenderer;
							$cadObj='{"valor":""}';
							$objParam=json_decode($cadObj);
							$objParam->valor=$valor;
							$cacheConsulta=NULL;
							$etiqueta=cv(removerComillasLimite(resolverExpresionCalculoPHP($funcionInterpretacion,$objParam,$cacheConsulta)	));
							$cacheValores[$id][$valor]=$etiqueta;
						}
					}
				}
				$comp.=',"dimension_'.$id.'":"'.$etiqueta.'"';

			}
			$o='{"idRegistro":"'.$fila[0].'","folioOperacion":"'.$fila[7].'","tiempoPresupuestal":"'.$fila[2].'","fechaOperacion":"'.$fila[1].'","descripcionOperacion":"'.$fila[6].'","montoDeposito":"'.$montoDeposito.
				'","montoRetiro":"'.$montoRetiro.'","idFormulario":"'.$fila[10].'","idReferencia":"'.$fila[11].'"'.$comp.'}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$nReg++;
		}
		
		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
	}
?>