<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	include("funcionesActores.php");

	$idFormulario=bD($_GET["iF"]);
	$idUsuario=-1;
	if(isset($_GET["idUsuario"]))
		$idUsuario=bD($_GET["idUsuario"]);
	if($idUsuario=="")
		$idUsuario=-1;
	$actor=-1;
	if(isset($_GET["actor"]))
		$actor=bD($_GET["actor"]);
	
	$idProceso=obtenerIdProcesoFormulario($idFormulario);
	$idReferencia=-1;
	if(isset($_GET["iR"]))
		$idReferencia=bD($_GET["iR"]);
	
	$cadObj='{"p16":{"p1":"'.$idFormulario.'","p2":"'.$idProceso.'","p3":"-1","p4":"-1","p5":"'.$idReferencia.'","p6":"-1"}}';
	$paramObj=json_decode($cadObj);


	$arrQueries=resolverQueries($idFormulario,5,$paramObj,false,true);
	

	
	$consulta="SELECT nombre,idTipoProceso FROM 4001_procesos WHERE idProceso=".$idProceso;
	$fConfiguracionProceso=$con->obtenerPrimeraFila($consulta);
	
	$tituloModulo=$fConfiguracionProceso[0];
	$tipoProceso=$fConfiguracionProceso[1];
	
	
	$consulta="select f.idConfGrid,campoAgrupacion,btnAgregarLabel,btnModificarLabel,btnEliminarLabel,btnVerLabel,mostrarVistaPrevia,
				botonesOcultar,botonesPersonales,configuracionExtra,configuracionEventos from 909_configuracionTablaFormularios f where f.idFormulario=".$idFormulario;

	$filaConfFrm=$con->obtenerPrimeraFila($consulta);
	$idConfiguracion=$filaConfFrm[0];
	$campoAgrupacion=$filaConfFrm[1];
	$vistaPrevia=$filaConfFrm[6];

	$btnAgregarLabel="Crear nuevo expediente";
	if($tipoProceso==1)
		$btnAgregarLabel="Agregar registro";
	
	
	if($filaConfFrm[2]!="")
		$btnAgregarLabel=$filaConfFrm[2];
	
	$btnModificarLabel="Editar expediente";
	if($tipoProceso==1)
		$btnModificarLabel="Editar registro";
		
	if($filaConfFrm[3]!="")
		$btnModificarLabel=$filaConfFrm[3];
		
	$btnEliminarLabel="Eliminar expediente";
	if($tipoProceso==1)
		$btnEliminarLabel="Eliminar registro";
	if($filaConfFrm[4]!="")
		$btnEliminarLabel=$filaConfFrm[4];
		
	$btnVerLabel="Abrir expediente";
	if($tipoProceso==1)
		$btnVerLabel="Ver ficha";
		
	if($filaConfFrm[5]!="")
		$btnVerLabel=$filaConfFrm[5];
	
	
	
	if($vistaPrevia==1)
		$vistaPrevia="false";
	else
		$vistaPrevia="true";
	$btnOcultar=$filaConfFrm[7];
	
	$btnPersonales=$filaConfFrm[8];
	$cadBotones="";
	if($btnPersonales!="")
	{
		$objBotones=json_decode($btnPersonales);
		foreach($objBotones->arrBotones as $btn)
		{
			if($btn->leyenda=="-")
				$objBtn="'-'";
			else
			{
				$icono="";
				if(isset($btn->icono))
				{
					if($btn->icono!="")
						$icono= "icon:'".$btn->icono."',";
				}
				$id="";
				if(isset($btn->idBtn))
				{
					if($btn->idBtn!="")
						$id= "id:'".$btn->idBtn."',";
				}
				$deshabilitado="";
				if(isset($btn->deshabilitado))
				{
					if($btn->deshabilitado!="")
						$deshabilitado= "disabled:'".$btn->deshabilitado."',";
				}
				$visible="";
				if(isset($btn->visible))
				{
					if($btn->visible!="")
						$visible= "visible:'".$btn->visible."',";
				}
				$objBtn="{
							  ".$icono.$id.$deshabilitado.$visible."
							  cls:'x-btn-text-icon',
							  text:'".$btn->leyenda."',
							  handler:function()
									  {
										  ".$btn->cuerpoFuncion."
									  }
							  
						  }";
			}
			if($cadBotones=="")
				$cadBotones=$objBtn;
			else
				$cadBotones.=",".$objBtn;
		}
	}
	if($cadBotones!="")
		$cadBotones=",".$cadBotones;
	$confExtra=$filaConfFrm[9];
	if($confExtra!="")
	{
		$objConfExtra=json_decode($confExtra);
		
		
	}
	$configuracionEventos=$filaConfFrm[10];
	
	$consulta="SELECT campoUsr FROM 9017_camposControlFormulario WHERE campoMysql='".$campoAgrupacion."'";
	$campoAux=$con->obtenerValor($consulta);
	if($campoAux!="")
		$campoAgrupacion=$campoAux;
	$queryTabla="select nombreTabla from 900_formularios where idFormulario=".$idFormulario;

	$nomTabla=$con->obtenerValor($queryTabla);
	$filtroCampos="";
	$consulta="	select cg.titulo,tamanoColumna as 'tamColumna',case cg.alineacionValores when 1 then 'left' when 2 then 'right' when 3 then 'center' 
				when 4 then 'justify' end as alineacion,cg.idElementoFormulario,
				if((select distinct(tipoElemento) from 901_elementosFormulario where 
				idGrupoElemento=cg.idElementoFormulario) is null,cg.idElementoFormulario,(select distinct(tipoElemento) 
				from 901_elementosFormulario where idGrupoElemento=cg.idElementoFormulario)) as tipoElemento,
				if((select distinct(nombreCampo) from 901_elementosFormulario where 
				idGrupoElemento=cg.idElementoFormulario) is null,
				 case cg.idElementoFormulario
					 when '-10' then 'fechaCreacion'
					 when '-11' then 'responsableCreacion'
					 when '-12' then 'fechaModificacion'
					 when '-13' then 'responsableModificacion'
					 when '-14' then 'unidadUsuarioRegistro'
					 when '-15' then 'institucionUsuarioRegistro'
					 when '-16' then 'dtefechaSolicitud'
					 when '-17' then 'tmeHoraInicio'
					 when '-18' then 'tmeHoraFin'
					 when '-19' then 'dteFechaAsignada'
					 when '-20' then 'tmeHoraInicialAsignada'
					 when '-21' then 'tmeHoraFinalAsignada'
					 when '-22' then 'unidadReservada'
					 when '-23' then 'tmeHoraSalida'
					 when '-24' then 'estado'
   				     when '-25' then 'codigoRegistro'
					 when '-27' then 'fechaUltimoSometimiento'
					 when '-28' then 'fechaAgendaComite'
					 end
				   ,(select distinct(nombreCampo) 
				from 901_elementosFormulario where idGrupoElemento=cg.idElementoFormulario)) as nombreCampo,idFuncionRenderer

				from 907_camposGrid cg where 
				cg.idIdioma=".$_SESSION["leng"]." and cg.idConfGrid=".$idConfiguracion." order by cg.orden";

	$res=$con->obtenerFilas($consulta);

	$campos="{name: 'idRegistro' },{name: 'noRegistroPag' },{name:'permisos'},{name:'idActorRegistro'},{name:'participacion'},{name:'fechaAtencionComite'},{name:'idEtapaRegistro'}";
//	new  Ext.grid.RowNumberer({width:35})
	$columnModel=			"/*new  Ext.grid.RowNumberer({width:30})
							,*/

							{
								header:'',
								width:40,
								sortable:false,
								renderer:function(val,meta,registro)
										{
											if(registro.data.permisos)
											{
												if(registro.get('permisos').indexOf('E')!=-1)
													return '<a href=\"javascript:removerRegistro(\''+bE(registro.get('idRegistro'))+'\')\"><img src=\"../images/delete.png\" alt=\"Eliminar registro\" title=\"Eliminar registro\"></a>'
											}
											
											return '';
										},
								dataIndex:'noRegistroPag',align:'left'
							}
							";
	$ct=1;
	while($filas=mysql_fetch_row($res))
	{
		$conf="";
		$comp="";
		
		$funcRenderer="";
		if($filas[6]!="")
		{
			$consulta="SELECT nombreFuncionJS FROM 9033_funcionesScriptsSistema WHERE idFuncion=".$filas[6];
			$funcRenderer=$con->obtenerValor($consulta);
		}
		if($funcRenderer=="")
		{
			switch($filas[4])
			{
				case 10:
					$conf="renderer: formatearTexto,";
				break;
				case 6:
				case 7:
					$conf="renderer: formatearDecimal,";
				break;
				case 8:
				case -10:
				case -12:
				case -16:
				case -19:
				case -27:
				case -28:
					$conf="renderer: formatearFecha,";
				break;
				case 12:
					$conf="renderer: formatearArchivo,";
				break;
				case -17:
				case -18:
				case -20:
				case -21:
				case -23:
				case 21:
					$conf="renderer: formatearTiempo,";
				break;
				case -24:
					$conf="renderer: formatearEtapa,";
				break;
				case 24:
					$conf="renderer: 'usMoney',";
				break;
				default:
					$conf="renderer: formatearValorEstandar,";
				break;
				
			}
		}
		else
		{
			$conf="renderer: ".$funcRenderer.",";
			switch($filas[4])
			{
				case 5:
				case 9:
					$conf="";
				break;
			}
		}
			
		$campos.=",{name: '".$filas[5]."' }";
		$tipoFiltro='string';
		switch($filas[4])
		{
			case 3:
			case 6:
			case 7:
			case 15:
				if($filas[4]==6)
				{
					$comp=',separadorDecimal:".",separadorMiles:"'.$fComp[3].'",numDecimales:"0"';
				}
				if($filas[4]==7)
				{
					$comp=',separadorDecimal:"'.$fComp[4].'",separadorMiles:"'.$fComp[3].'",numDecimales:"'.$fComp[7].'"';
				}
				$tipoFiltro='numeric';
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
			break;
			case 8:			
			case -10:
			case -12:
			case -16:
			case -19:
			case -27:
			case -28:
				$tipoFiltro='date';
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
			break;
			case 2:
			case 14:
			case 16:
				$tipoFiltro='list';
				
				if(($filas[4]==2)||($filas[4]==14))
				{
					$queryOpt="select valor as id,contenido as text from 902_opcionesFormulario where idIdioma=".$_SESSION["leng"]." and idGrupoElemento=".$filas[3];
					$arrOpt=utf8_encode($con->obtenerFilasJSON($queryOpt));
				}
				else
				{
					$queryConfOpt="select * from 904_configuracionElemFormulario where idElemFormulario=".$filas[3];
					$fConf=$con->obtenerPrimeraFila($queryConfOpt);
					$condWhere="";
					if($fConf[12]=="1")
					{
						$condWhere=" where";
						$queryConfOpt="select tokenMysql from 913_consultasFiltroElemento where idGrupoElemento=".$filas[3];
						$resFilasConf=$con->obtenerFilas($queryConfOpt);
						while($filasConf=mysql_fetch_row($resFilasConf))
						{
							$condWhere.=" ".$filasConf[0];
						}
						
					}
					if(strpos($fConf[2],"[")===false)
					{
						$queryOpt="select ".$fConf[4]." as id,".$fConf[3]." as text from ".$fConf[2].$condWhere;					
						
						$arrOpt=utf8_encode($con->obtenerFilasJSON($queryOpt));
					}
					else
						$arrOpt="[]";
				}
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".$arrOpt.",phpMode:true,tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".$arrOpt.",phpMode:true,tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
				
			break;
			case -13:
			case -11:
			case -25:
			case 5:
			case 9:
			case 10:
			case 11:
			case 15:
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
			break;
			case 4:
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
			break;
			case -14:
				$tipoFiltro='list';
				$queryOpt="select distinct(o.codigoUnidad),o.unidad from 817_organigrama o,".$nomTabla." t  where o.codigoUnidad=t.codigoUnidad order by unidad";					
				$arrOpt=$con->obtenerFilasArreglo($queryOpt);
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".($arrOpt).",phpMode:true,tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".($arrOpt).",phpMode:true,tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
			break;
			case -15:
			case -22:
				$tipoFiltro='list';
				$queryOpt="select distinct(o.codigoUnidad),o.unidad from 817_organigrama o,".$nomTabla." t  where o.codigoUnidad=t.codigoInstitucion order by unidad";					
				$arrOpt=$con->obtenerFilasArreglo($queryOpt);
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".($arrOpt).",phpMode:true,tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".($arrOpt).",phpMode:true,tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
			break;
			case -24:
				$tipoFiltro='list';
				$queryOpt="select numEtapa,concat(numEtapa,'.- ',nombreEtapa) from 4037_etapas  where idProceso=".$idProceso." order by numEtapa";					
				$arrOpt=$con->obtenerFilasArreglo($queryOpt);
				if($filtroCampos=="")
					$filtroCampos="{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".($arrOpt).",phpMode:true,tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
				else
					$filtroCampos.=",{type: '".$tipoFiltro."', dataIndex: '".$filas[5]."',options:".($arrOpt).",phpMode:true,tipoCampo:'".$filas[4]."',idCampo:'".$filas[3]."'}";
			break;
		}
		
		$columnModel.="	,{
							header:'".uEJ($filas[0])."',
							width:".$filas[1].",
							sortable:true,
							css:'text-align:".$filas[2]." !important;',
							dataIndex:'".$filas[5]."',".$conf."align:'left'".$comp."
							
						}";
		
		
		$ct++;
	}

	$consulta="select campoOrden,direccionOrden,numRegPag from 909_configuracionTablaFormularios where idFormulario=".$idFormulario;

	$fila=$con->obtenerPrimeraFila($consulta);

	if($tipoProceso!=1)
		$arrActoresDisp=obtenerActoresDisponiblesProceso($idProceso,$idUsuario,$actor);
	else
		$arrActoresDisp="[]";
	$ocultarConsultar="false";
	if(strpos($btnOcultar,"C")!==false)
		$ocultarConsultar="true";
	$ocultarAgregar="false";
	if(strpos($btnOcultar,"A")!==false)
		$ocultarAgregar="true";
		
	$ocultarModificar="false";
	if(strpos($btnOcultar,"M")!==false)
		$ocultarModificar="true";
	$ocultarEliminar="false";
	if(strpos($btnOcultar,"E")!==false)
		$ocultarEliminar="true";
	$ocultarSituacion="true";
	if(strpos($btnOcultar,"S")!==false)
		$ocultarSituacion="true";



	$consulta="select idEtapa,idProceso from 900_formularios where idFormulario=".$idFormulario;
	$filaResp=$con->obtenerPrimeraFila($consulta);
	$idEtapa=$filaResp[0];

	$consulta="select tp.ignoraPermisos from 4001_procesos p,921_tiposProceso tp where tp.idTipoProceso=p.idTipoProceso and p.idProceso=".$idProceso;
	$ignoraPermisos=$con->obtenerValor($consulta);
	
	
	$ocultarVerFormulario="false";
	$ocultarNuevoFormulario="false";
	$ocultarModificarFormulario="false";
	$ocultarEliminarFormulario="false";
	
	if($tipoProceso==1)
	{
		if($ignoraPermisos=="0")
		{
			$consulta="select permisos from 4002_rolesVSEtapas where etapa=".$idEtapa." and  proceso=".$idProceso." and idRol in(".$_SESSION["idRol"].")";

			$res=$con->obtenerFilas($consulta);
			while($filaPermisos=mysql_fetch_row($res))
			{
				$permisos=$filaPermisos[0];
				if(strpos($permisos,"C")!==false)
					$ocultarVerFormulario="true";
				if(strpos($permisos,"A")!==false)
					$ocultarNuevoFormulario="true";
				if(strpos($permisos,"M")!==false)
					$ocultarModificarFormulario="true";
				if(strpos($permisos,"E")!==false)
					$ocultarEliminarFormulario="true";
			}
		}
		else
		{
			$ocultarVerFormulario="true";
			$ocultarNuevoFormulario="true";
			$ocultarModificarFormulario="true";
			$ocultarEliminarFormulario="true";
		}
	}
	
	
	$cAcceso="";
	if($ocultarVerFormulario=="true")
		$cAcceso.="C";
		
	if($ocultarNuevoFormulario=="true")
		$cAcceso.="A";
	
	if($ocultarModificarFormulario=="true")
		$cAcceso.="M";
		
	if($ocultarEliminarFormulario=="true")
		$cAcceso.="E";
	
	$cacheCalculos=NULL;
	
	
	$arrValoresFiltro="";
	
	$arrIdFiltros="var arrIdFiltros=[];";
	
	$arrFiltros="";
	$consulta="SELECT * FROM 907_filtrosGlobalesGrid WHERE idConfiguracionGrid=".$idConfiguracion;
	$rConfiguracion=$con->obtenerFilas($consulta);
	while($fConfiguracion=mysql_fetch_row($rConfiguracion))
	{
		
		$valor1="";
		$valor2="";
		$operador1="";
		$operador2="";
		if($fConfiguracion[6]!=-1)
		{
			
			$oParam='{"idConfiguracion":"'.$idConfiguracion.'","idCampo":"'.$fConfiguracion[2].'","idFiltro":"'.$fConfiguracion[0].'","noFiltro":""}';
			$objParametros=json_decode($oParam);
			$objParametros->noFiltro=1;
			
			$valor1=resolverExpresionCalculoPHP($fConfiguracion[6],$objParametros,$cacheCalculos);
			
			if(gettype($valor1)=='array')
			{
				$operador1=$valor1[0];
				$valor1=removerComillasLimite($valor1[1]);
			}
			else
			{
				
				$valor1=removerComillasLimite($valor1);
				
			}
			
			$objParametros->noFiltro=2;
			$valor2=resolverExpresionCalculoPHP($fConfiguracion[6],$objParametros,$cacheCalculos);
			
			if(gettype($valor2)=='array')
			{
				$operador2=$valor2[0];
				$valor2=removerComillasLimite($valor2[1]);
			}
			else
			{
				$valor2=removerComillasLimite($valor2);
			}
				
		}
		
		
		$idConfiguracionCtrl=$fConfiguracion[2];
		$fConfiguracion[2]=str_replace("-","_",$fConfiguracion[2]);
		$control="";
		switch($fConfiguracion[3])
		{
			case 1://
			
				if($operador1=="")
					$operador1="=";
				
				if($operador2=="")
					$operador2="=";
					
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador1.'"}),new Ext.form.NumberField({id:"filtro1_'.$fConfiguracion[2].'",width:"40",allowDecimals:true,allowNegative:true,value:"'.$valor1.'", enableKeyEvents:true}),'.
						'{id:"btnClean_'.$fConfiguracion[2].'_1",icon:"../images/find_remove.png",border:true,width:20,cls:"x-btn-text-icon",handler:function(btn){limpiarFiltro(btn)}},{"xtype":"label",html:"&nbsp;&nbsp;<span style=\"color:#000\"><b>y</b></span>&nbsp;&nbsp;"},crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador2.'"}),new Ext.form.NumberField({id:"filtro2_'.
							$fConfiguracion[2].'",width:"40",allowDecimals:true,allowNegative:true,value:"'.$valor2.'", enableKeyEvents:true}),{id:"btnClean_'.$fConfiguracion[2].'_2",icon:"../images/find_remove.png",border:true,width:20,cls:"x-btn-text-icon",handler:function(btn){limpiarFiltro(btn)}}';
				
				$tipoControl="";
				$campo="";
				if($idConfiguracionCtrl<0)
				{
					$tipoControl=$idConfiguracionCtrl;
					
					$consulta="SELECT campoMysql FROM 9017_camposControlFormulario WHERE tipoElemento=".$idConfiguracionCtrl;
					$fCampo=$con->obtenerPrimeraFila($consulta);

					$campo=$fCampo[0];
				}
				else
				{
					$consulta="SELECT tipoElemento,nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$idConfiguracionCtrl;
					$fCampo=$con->obtenerPrimeraFila($consulta);
					$tipoControl=$fCampo[0];
					$campo=$fCampo[1];
					
					
				}
				
				$arrIdFiltros.="arrIdFiltros.push(['filtro1_".$fConfiguracion[2]."','".$fConfiguracion[2]."','".$tipoControl."','".$campo."','1']);";	
				$arrIdFiltros.="arrIdFiltros.push(['filtro2_".$fConfiguracion[2]."','".$fConfiguracion[2]."','".$tipoControl."','".$campo."','2']);";			
							
							
			break;	
			/*case 2:
				$control='new Ext.form.TextField({"id":"txt_'.$fConfiguracion[2].'",width:"'.$fConfiguracion[4].'"})';
			break;*/
			case 3://
			case 4://
				
				$arrValores="[]";
				if($fConfiguracion[5]!=-1)
				{
					$oParam='{"idConfiguracion":"'.$idConfiguracion.'","idCampo":"'.$idConfiguracionCtrl.'","idFiltro":"'.$fConfiguracion[0].'"}';
					$objParametros=json_decode($oParam);
					
					
					$res=resolverExpresionCalculoPHP($fConfiguracion[5],$objParametros,$cacheCalculos);	
					foreach($res as $opt)
					{
						$o="['".$opt["valor"]."','".$opt["etiqueta"]."']";
						if($arrValores=="")	
							$arrValores=$o;
						else
							$arrValores.=",".$o;
						
					}
					$arrValores="[".$arrValores."]";
				}
				else
				{
					if($idConfiguracionCtrl>0)
					{
						$consulta="SELECT nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$idConfiguracionCtrl;
						
						$nCampoTabla=$con->obtenerValor($consulta);
						
						$consulta="SELECT DISTINCT ".$nCampoTabla." FROM _".$idFormulario."_tablaDinamica";
						$listaValores=$con->obtenerListaValores($consulta,"'");
						if($listaValores=="")
							$listaValores=-1;
						
						$consulta="SELECT * FROM 904_configuracionElemFormulario WHERE idElemFormulario=".$idConfiguracionCtrl;
						$fConfControl=$con->obtenerPrimeraFila($consulta);
						$consultaCtrl=generarConsultaIdElementoTablaExterna($idConfiguracionCtrl,$arrQueries,$idFormulario);	
						$arrTablas=obtenerTablasConsulta($consultaCtrl);
						
						$auxQuery=explode(" where ",$consultaCtrl);
						
						$arrCampos=explode("@@",$fConfControl[3]);
						
						$camposFiltro="";
						$aCamposAux=array();
						foreach($arrCampos as $aC)
						{
							$arrProy=explode(".",$aC);
							$cAux=$aC;
							if(sizeof($arrProy)>1)
							{
								if(existeValor($arrTablas,$arrProy[0]))
								{
									$cAux="if(".$aC." is null,'',".$aC.")";
								}
							}
							array_push($aCamposAux,$cAux);
						}
						
						$consultaFinal="select distinct ".$fConfControl[4].",concat(".implode(",",$aCamposAux).") from ".implode(",",$arrTablas);
						if(sizeof($arrTablas)==1)
						{
							$consultaFinal.=" where ".$fConfControl[4]." in (".$listaValores.") order by ".$fConfControl[3];
							
						}
						else
						{
							$condWhereAux=str_replace("(","",$auxQuery[1]);
							$condWhereAux=str_replace(")","",$condWhereAux);
							$auxQuery=explode(" limit ",$condWhereAux);
							$condWhere=$auxQuery[0];
							$cWhereIncluida=false;
							$aAux=preg_split("[and|or|AND|OR]",trim($condWhere));
							foreach($aAux as $c)
							{
								$nTablasAsoc=0;
								foreach($arrTablas as $t)
								{
									if(strpos($c,$t.".")!==false)
									{
										$nTablasAsoc++;
									}
								}
								
								if($nTablasAsoc==2)
								{
									if(!$cWhereIncluida)
									{
										$consultaFinal.=" where ".trim($c);
										$cWhereIncluida=true;
											
									}
									else
										$consultaFinal.=" and ".trim($c);
								}
								
									
							}
							
							if(!$cWhereIncluida)
								$consultaFinal.=" where ".$fConfControl[4]." in (".$listaValores.") order by ".$fConfControl[3];
							else
								$consultaFinal.=" and ".$fConfControl[4]." in (".$listaValores.") order by ".$fConfControl[3];
						}
						
						
						$rOpciones=$con->obtenerFilas($consultaFinal);
						while($fOpciones=mysql_fetch_row($rOpciones))
						{
							$oTmp="['".cv($fOpciones[0])."','".cv($fOpciones[1])."']";
							if($arrValores=="[]")
								$arrValores=$oTmp;
							else
								$arrValores.=",".$oTmp;
						}
						
						$arrValores="[".$arrValores."]";	
					}
					else
					{
						switch($idConfiguracionCtrl)	
						{
							case -24:
								$queryOpt="select numEtapa,nombreEtapa from 4037_etapas  where idProceso=".$idProceso." order by numEtapa";					
								$rOptAux=$con->obtenerFilas($queryOpt);
								while($fOptAux=mysql_fetch_row($rOptAux))
								{
									if($arrValores=="[]")
										$arrValores="['".$fOptAux[0]."','".removerCerosDerecha($fOptAux[0]).".- ".cv($fOptAux[1])."']";
									else
										$arrValores.=",['".$fOptAux[0]."','".removerCerosDerecha($fOptAux[0]).".- ".cv($fOptAux[1])."']";
								}
								$arrValores="[".$arrValores."]";
							break;	
						}
					}
				
				}
				
				$compMulti="";
				if($fConfiguracion[3]==4)
					$compMulti=",multiSelect:true,funcionCheckBoxCheck:filtroMultiselect";
				
				$arrValoresFiltro.="var arrValores_".$fConfiguracion[2]."=".$arrValores.";";
				$control='crearComboExt("filtro1_'.$fConfiguracion[2].'",arrValores_'.$fConfiguracion[2].',0,0,'.$fConfiguracion[4].',{valor:"'.$valor1.'"'.$compMulti.'}),{id:"btnClean_'.$fConfiguracion[2].'_1",icon:"../images/find_remove.png",border:true,width:20,cls:"x-btn-text-icon",handler:function(btn){limpiarFiltro(btn)}}';
				$tipoControl="";
				$campo="";
				if($idConfiguracionCtrl<0)
				{
					$tipoControl=$idConfiguracionCtrl;
					
					$consulta="SELECT campoMysql FROM 9017_camposControlFormulario WHERE tipoElemento=".$idConfiguracionCtrl;
					$fCampo=$con->obtenerPrimeraFila($consulta);

					$campo=$fCampo[0];
				}
				else
				{
					$consulta="SELECT tipoElemento,nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$idConfiguracionCtrl;
					$fCampo=$con->obtenerPrimeraFila($consulta);
					$tipoControl=$fCampo[0];
					$campo=$fCampo[1];
				}
				
				$arrIdFiltros.="arrIdFiltros.push(['filtro1_".$fConfiguracion[2]."','".$fConfiguracion[2]."','".$tipoControl."','".$campo."','1']);";	
			break;
			
			case 5:
				if($operador1=="")
					$operador1="arrCondicionalesTexto[0][0]";
				else
				{
					switch(strtoupper($operador1))	
					{
						case '0':
						case 'I':
							$operador1="arrCondicionalesTexto[0][0]";
						break;
						case '1':
						case 'C':
							$operador1="arrCondicionalesTexto[0][1]";
						break;
					}
				}
				
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionalesTexto,0,0,80,{valor:'.$operador1.'}),new Ext.form.TextField({"id":"filtro1_'.$fConfiguracion[2].'",width:"'.$fConfiguracion[4].'",value:"'.
						$valor1.'", enableKeyEvents:true}),{id:"btnClean_'.$fConfiguracion[2].'_1",icon:"../images/find_remove.png",border:true,width:20,cls:"x-btn-text-icon",handler:function(btn){limpiarFiltro(btn)}}';
				$tipoControl="";
				$campo="";
				if($idConfiguracionCtrl<0)
				{
					$tipoControl=$idConfiguracionCtrl;
					
					$consulta="SELECT campoUsr FROM 9017_camposControlFormulario WHERE tipoElemento=".$idConfiguracionCtrl;
					
					$fCampo=$con->obtenerPrimeraFila($consulta);

					$campo=$fCampo[0];
				}
				else
				{
					$consulta="SELECT tipoElemento,nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$idConfiguracionCtrl;
					$fCampo=$con->obtenerPrimeraFila($consulta);
					$tipoControl=$fCampo[0];
					$campo=$fCampo[1];
					
					
				}
				
				$arrIdFiltros.="arrIdFiltros.push(['filtro1_".$fConfiguracion[2]."','".$fConfiguracion[2]."','".$tipoControl."','".$campo."','1']);";	

			break;	
			case 6://
				if($operador1=="")
					$operador1="=";
				
				if($operador2=="")
					$operador2="=";
					
					
					
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador1.'"}),new Ext.form.DateField({"id":"filtro1_'.$fConfiguracion[2].'",value:"'.$valor1.'"})'.
						',{id:"btnClean_'.$fConfiguracion[2].'_1",icon:"../images/find_remove.png",border:true,width:20,cls:"x-btn-text-icon",handler:function(btn){limpiarFiltro(btn)}},{"xtype":"label",html:"&nbsp;&nbsp;<span style=\"color:#000\"><b>y</b></span>&nbsp;&nbsp;"},crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador2.'"}),new Ext.form.DateField({"id":"filtro2_'.
						$fConfiguracion[2].'",value:"'.$valor2.'"}),{id:"btnClean_'.$fConfiguracion[2].'_2",icon:"../images/find_remove.png",border:true,width:20,cls:"x-btn-text-icon",handler:function(btn){limpiarFiltro(btn)}}';
				$tipoControl="";
				$campo="";
				if($idConfiguracionCtrl<0)
				{
					$tipoControl=$idConfiguracionCtrl;
					
					$consulta="SELECT campoMysql FROM 9017_camposControlFormulario WHERE tipoElemento=".$idConfiguracionCtrl;
					$fCampo=$con->obtenerPrimeraFila($consulta);

					$campo=$fCampo[0];
				}
				else
				{
					$consulta="SELECT tipoElemento,nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$idConfiguracionCtrl;
					$fCampo=$con->obtenerPrimeraFila($consulta);
					$tipoControl=$fCampo[0];
					$campo=$fCampo[1];
					
					
				}
				
				$arrIdFiltros.="arrIdFiltros.push(['filtro1_".$fConfiguracion[2]."','".$fConfiguracion[2]."','".$tipoControl."','".$campo."','1']);";	
				$arrIdFiltros.="arrIdFiltros.push(['filtro2_".$fConfiguracion[2]."','".$fConfiguracion[2]."','".$tipoControl."','".$campo."','2']);";		
			break;
			/*case 7:
				$control='new Ext.form.DateField({"id":"txt1_'.$fConfiguracion[2].'"})';
			break;	*/	
		}
		$filtro='{"xtype":"label",html:"<span style=\"color:#000\"><b>'.$fConfiguracion[1].':</b></span>&nbsp;&nbsp;"},'.$control.',"-"';
		if($arrFiltros=="")
			$arrFiltros=$filtro;
		else
			$arrFiltros.=",".$filtro;
	}
	
	
	
?>

<?php
	echo $arrValoresFiltro;
	echo $arrIdFiltros;
?>
var arrCondicionales=[['>','>'],['>=','>='],['=','='],['<','<'],['<=','<=']];
var arrCondicionalesTexto=[["like '@valor%'",'Inicia con'],["like '%@valor%'",'Contiene']];


var cAccion='<?php echo $cAcceso?>';
var iPermisos=<?php echo $ignoraPermisos?>;
var tipoProceso=<?php echo $tipoProceso?>;
var camposJava=new Array( <?php echo $campos; ?>);
var columnasJava=new Array(<?php echo $columnModel; ?>);
var idConfig=<?php echo $idConfiguracion;?>;
var arrActoresDisp=<?php echo $arrActoresDisp?>;
var ocultarEtiqueta=false;

Ext.onReady(inicializar);
var actor=-1;
var idActor=-1;
var tipoActor=-1;



function inicializar()
{
	var actor=gE('actor').value;

    if(actor!='-1')
    	ocultarEtiqueta=true;
    var gridRegistros=crearGridRegistros();

	if((actor!=-1)&&(gE('sL').value=='0'))
    {
    
    	gEx('btnNuevo').show();
    }  
    var x;
    var f;
    
    for(x=0;x<arrIdFiltros.length;x++)                                     
    {
    	f=arrIdFiltros[x];
        
        if(gEx('op'+f[4]+'_'+f[1]))
        {
        	var cadAccion="gEx('op"+f[4]+"_"+f[1]+"').on('select',function(cmb,registro){var idFiltro='filtro"+f[4]+"_"+f[1]+"';controlOperadorCambio(idFiltro);});";
            eval(cadAccion);
        }
        var ctrl=gEx('filtro'+f[4]+'_'+f[1]);
            
        switch(ctrl.getXType())
        {
            case 'textfield':
                ctrl.on('keyup',recargarGridRegistros);
            break;
            case 'datefield':
                ctrl.on('select',recargarGridRegistros);
            break;
            case 'numberfield':
                ctrl.on('keyup',recargarGridRegistros);
            break;
            case 'combo':
            	ctrl.on('select',recargarGridRegistros);
                
            break;
        }
        
        
        
    }
}

function filtroMultiselect(cmb,arr)
{
	var x;
    
    var listaValores='';
    for(x=0;x<arr.length;x++)
    {
    	if(listaValores=='')
        	listaValores=arr[x].inputValue;
        else
        	listaValores+=','+arr[x].inputValue;
        
    }
    cmb.setValue(listaValores);
   
	recargarGridRegistros();
}

function limpiarFiltro(btn)
{
	var id=btn.id.replace('__','_-');
	var arrDatos=id.split('_');
    
    gEx('filtro'+arrDatos[2]+'_'+arrDatos[1].replace('-','_')).setValue('');
    recargarGridRegistros();
}


function controlOperadorCambio(idFiltro)
{
	
	var filtro=gEx(idFiltro)
    var pos=existeValorMatriz(arrIdFiltros,idFiltro);
    f=arrIdFiltros[pos];
    var ctrl=gEx('filtro'+f[4]+'_'+f[1]);
    if(ctrl.getValue()=='')
	    ctrl.focus(false,200);
    else
    {
    	recargarGridRegistros();
    }
    
    
    
}


function recargarGridRegistros()
{
	gEx('gridRegistros').getStore().reload();
}

function crearGridRegistros()
{
	<?php
		$habilitarGrouping="true";
		if($campoAgrupacion=="0")
		{
			$habilitarGrouping="false";
			$campoAgrupacion=$fila[0]."";
		}
	?>
    
	var cmbActor=crearComboExt('cmbActor',arrActoresDisp,0,0,200);
   	
    if(arrActoresDisp.length>0)
    {
    	
	    cmbActor.setValue(arrActoresDisp[0][0]);
       	if(arrActoresDisp.length==1)
        	ocultarEtiqueta=true;    
    }
    else
    {
    	if(tipoProceso=='1')
        {
        	ocultarEtiqueta=true; 
            
            
        }
   	}
    
    cmbActor.on('select',function(combo,registro)
    					{
                        	gEx('gridRegistros').getStore().reload();
                        }
               )
               
	if(ocultarEtiqueta)       
    	cmbActor.hide();
        
    var lector= new Ext.data.JsonReader	(
                                            {
                                                idProperty: 'idRegistro',
                                                root: 'registros',
                                                totalProperty: 'numReg',
                                                fields: camposJava
                                            }
                                         );
    var dsTablaRegistros= new Ext.data.GroupingStore(
                                                      {
                                                          reader: lector,
                                                          remoteSort:true,
                                                          groupField:'<?php echo $campoAgrupacion?>',
                                                          proxy: new Ext.data.HttpProxy	(
                                                                                              {
                                                                                                  url: '../paginasFunciones/funcionesTblFormularios.php'
                                                                                              }
                                                                                          )
                                                          }
                                                 ) 
	var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ <?php echo $filtroCampos?> ]
                                                    }
                                                );                                                    
                                                    
	dsTablaRegistros.setDefaultSort('<?php echo $fila[0]?>', '<?php echo $fila[1]?>');
                                                    
                                                
	function cargarDatos(proxy,parametros)
    {
    	var cmbActor=gEx('cmbActor');
        
    	var idActor=cmbActor.getValue();
        if(idActor=='')
        	idActor=-1;
        tipoActor=-1;
        
        
        
        if(tipoProceso!='1')    
        {
            var pos=obtenerPosFila(cmbActor.getStore(),'id',idActor);
            var fila=cmbActor.getStore().getAt(pos);
            
            var obj=eval('['+fila.get('valorComp')+']')[0];
            var btnNuevo=gEx('btnNuevo');
            var btnEliminar=gEx('btnEliminar');
            
            tipoActor=obj.tipoActor;
            idActor=fila.get('id');
            if(btnEliminar!=undefined)
                btnEliminar.disable();
    
            if((obj.idActorAgregar!=undefined)&&(obj.idActorAgregar!='-1')&&(obj.idActorAgregar!='')&&('<?php echo $ocultarAgregar?>'=='false'))
            {
                if((btnNuevo!=undefined)&&(gE('sL').value=='0'))
                    btnNuevo.show();
                actor=bE(obj.idActorAgregar);
            }
            else
            {
                actor=-1;
                if(btnNuevo!=undefined)
                    btnNuevo.hide();
            }
        }
        var frameContenidoGrid=gEx('frameContenidoGrid');
        
        if(frameContenidoGrid!=undefined)
        {
            frameContenidoGrid.load	(
                                        {
                                            url:'../paginasFunciones/white.php'
                                            
                                        }
                                    )
		}
        
        
        
    	proxy.baseParams.idFormulario=<?php echo $idFormulario?>;
        proxy.baseParams.funcion=6;

        if(gE('tipoVista').value!='2')
        {
        	
            proxy.baseParams.idReferencia=gE('idReferencia').value;
            if(gE('idProcesoPadre').value!='-1')
            {
                proxy.baseParams.idProcesoPadre=gE('idProcesoPadre').value;
            }
		}        
        proxy.baseParams.idConfiguracion=idConfig;
        proxy.baseParams.idActor=idActor;
        proxy.baseParams.tipoActor=tipoActor;
       
       
       	var aFiltros='';
        
       	var x;
        var f;
        var o;
        var operador='';
        var filtro;
        var operando='';
        for(x=0;x<arrIdFiltros.length;x++)                                     
        {
            f=arrIdFiltros[x];
            filtro=gEx(f[0]);
            if(filtro.getValue()!='')
            {
            	
            	condicion='in('+cv(filtro.getValue())+')';
                
                if(filtro.getXType()=='checkboxcombo')
                {
                	var arrValores=filtro.getValue().split(',');
                    var aux;
                    var valoresCondicion='';
                    for(aux=0;aux<arrValores.length;aux++)
                    {
                    	if(valoresCondicion=='')
                        	valoresCondicion="'"+cv(arrValores[aux])+"'";
                        else
                        	valoresCondicion+=",'"+cv(arrValores[aux])+"'";
                    }
                	condicion='in('+valoresCondicion+')';
                }
                
                operando=gEx('op'+f[4]+'_'+f[1]);
                var busquedaInterna=1;
                if(operando)
                {
                    switch(filtro.getXType())
                    {
                    	case  'datefield':
                        	condicion=operando.getValue()+"'"+filtro.getValue().format('Y-m-d')+"'";
                        break;
                        case  'textfield':
                        	condicion=operando.getValue().replace('@valor',cv(filtro.getValue()));
                            if((f[2]=='4')||(f[2]=='16')||(f[2]=='-11')||(f[2]=='-13'))
                            {
                            	busquedaInterna=0;
                            }
                            
                        break;
                        default:
                        	condicion=operando.getValue()+"'"+filtro.getValue()+"'";
                        break;
                        
                    }
                }
                
                o='{"idControl":"'+f[1]+'","campo":"'+f[3]+'","tipo":"'+f[2]+'","condicion":"'+condicion+'","busquedaInterna":"'+busquedaInterna+'"}';
                if(aFiltros=='')
                    aFiltros=o;
                else
                    aFiltros+=','+o;
			}
        }
       
        proxy.baseParams.arrFiltroGlobal=bE('{"filtros":['+aFiltros+']}');
        
        
        
        
        
    }                                      
                                                    
	dsTablaRegistros.on('beforeload',cargarDatos);                                                 
    var modelColumn= new Ext.grid.ColumnModel   	(
												 		columnasJava
													);
	var tamPagina =
	<?php 	
		if($fila[2]=='')	
		  echo "1";
	  else
		  echo $fila[2]
	?>
;   
	 var paginador=	new Ext.PagingToolbar	(
                                                    {
                                                          pageSize: tamPagina,
                                                          store: dsTablaRegistros,
                                                          displayInfo: true,
                                                          disabled:false
                                                      }
                                                   )                      
	var gridRegistros;

	var vConfig=	new Ext.grid.GroupingView({
                                                  enableNoGroups :true,
                                                  enableGrouping : <?php echo $habilitarGrouping?>,
                                                  enableGroupingMenu : true,
                                                  forceFit:false,
                                                  hideGroupedColumn : <?php echo $habilitarGrouping?>,
                                                  groupTextTpl: '<span class="letraFicha">{text}</span>',//(<font color="#000066">Total: </font> <font color="#FF0000">{values.rs.length}</font>)
                                                  startCollapsed :false
                                              })


	var oConfiguracion=		{
                                columnLines :true,
                                cm: modelColumn,
                                border:false,
                                id:'gridRegistros',
                                loadMask: true,
                                plugins: [filters],
                                store:dsTablaRegistros,
                                stripeRows :true,
                                bbar: paginador,
                                tbar:	[
                                           {
                                              xtype:'label',
                                              hidden:ocultarEtiqueta,
                                              html:'&nbsp;&nbsp;<span class="letraRojaSubrayada8"><b>Vista:</b></span>&nbsp;&nbsp;&nbsp;&nbsp;'
                                          },
                                          cmbActor
                                          ,
                                          '-',
                                          
                                          {
                                              id:'btnNuevo',
                                              icon:'../images/add.png',
                                              cls:'x-btn-text-icon',
                                              hidden:true,
                                              text:'<?php echo $btnAgregarLabel?>',
                                              handler:function()
                                                      {
                                                      
															if(tipoProceso!='1') 
                                                      		{
                                                              	var pag='../modeloPerfiles/vistaDTD.php';
                                                              	var arrDatos=[['idRegistro','-1'],['idFormulario','<?php echo $idFormulario?>'],['dComp','YWdyZWdhcg=='],['actor',actor],['idProcesoP',gE('idProcesoPadre').value],['idReferencia',gE('idReferencia').value],['idUsuario','<?php echo $_SESSION["idUsr"]?>']];    
                                                              	var nVentana='ventana_'+(new Date().format('h_i'))+'_'+generarNumeroAleatorio(1,10000);
                                                              	window.open('',nVentana, "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
                                                              	enviarFormularioDatos(pag,arrDatos,'POST',nVentana);
                                                            }
                                                            else
                                                            {
                                                            	var idReferencia=gE('idReferencia');
                                                                var arrDatos=[['idRegistro','-1'],['idFormulario',gE('idFormulario').value],['idReferencia',idReferencia.value],['dComp','<?php echo base64_encode("agregar")?>'],['formularioNormal','1']];
                                                                
                                                                var eJs=gE('eJs');
                                                                if(eJs!=null)
                                                                {
                                                                    var arr=['eJs',eJs.value];
                                                                    arrDatos.push(arr);
                                                                }
                                                                    
                                                                var soloContenido=gE('soloContenido').value;        
                                                                if(soloContenido=='1')
                                                                {
                                                                    var arreglo=new Array();
                                                                    arreglo[0]='cPagina';
                                                                    arreglo[1]='sFrm=true';
                                                                    arrDatos.push(arreglo);
                                                                }
                                                                enviarFormularioDatos('../modeloPerfiles/registroFormulario.php',arrDatos);
                                                            }
                                                      }
                                              
                                          },'-',
                                          {
                                              id:'btnAbrir',
                                              icon:'../images/book_open.png',
                                              cls:'x-btn-text-icon',
                                              disabled:true,
                                              hidden:<?php echo $ocultarConsultar?>,
                                              text:'<?php echo $btnVerLabel?>',
                                              handler:function()
                                                      {
                                                          var gridRegistros=gEx('gridRegistros');
                                                          var fila=gridRegistros.getSelectionModel().getSelected();
                                                          if(fila==null)
                                                          {
                                                              msgBox('Debe seleccionar el registro que desea abrir');
                                                              return;
                                                          }
                                                          
                                                          if(tipoProceso!='1') 
                                                      	  {
                                                          
                                                              var idActorRegistro=fila.get('idActorRegistro');
                                                              var pag='../modeloPerfiles/vistaDTD.php';
                                                              var arrDatos=[['idRegistro',fila.get('idRegistro')],['idFormulario','<?php echo $idFormulario?>'],['dComp','YXV0bw=='],['actor',idActorRegistro],['idProcesoP',gE('idProcesoPadre').value],['idReferencia',gE('idReferencia').value]];    
                                                              
                                                              if(tipoActor=='4')
                                                              {
                                                                  pag='../modeloPerfiles/vistaRevisor.php';  
                                                                  arrDatos.push(['idProceso','<?php echo $idProceso?>']);  
                                                                  arrDatos.push(['cPagina','sFrm=true']);  
                                                                  arrDatos[3][1]=bE('-'+cmbActor.getValue());
                                                              }
                                                              if(tipoActor=='5')
                                                              {
                                                                  arrDatos.push(['participante','1']);
                                                                  arrDatos[3][1]=fila.get('participacion');
                                                              }
                                                              var nVentana='ventana_'+(new Date().format('h_i'))+'_'+generarNumeroAleatorio(1,10000);
                                                              
                                                              
                                                              
                                                              window.parent.open('',nVentana, "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
                                                              enviarFormularioDatosV(pag,arrDatos,'POST',nVentana);
                                                          }    
                                                          else
                                                          {
                                                          		
                                                                var arrDatos=[['idRegistro',fila.get('idRegistro')],['idFormulario',gE('idFormulario').value],['formularioNormal','1']];
                                                                var soloContenido=gE('soloContenido').value;        
                                                                if(soloContenido=='1')
                                                                {
                                                                    var arreglo=new Array();
                                                                    arreglo[0]='cPagina';
                                                                    arreglo[1]='sFrm=true';
                                                                    arrDatos.push(arreglo);
                                                                }
                                                                enviarFormularioDatos('../modeloPerfiles/verFichaFormulario.php',arrDatos);
                                                          }
    
                                                          
                                                      }
                                              
                                          },'-',
                                          {
                                              id:'btnModificar',
                                              icon:'../images/pencil.png',
                                              cls:'x-btn-text-icon',
                                              disabled:true,
                                              hidden:true,
                                              text:'<?php echo $btnModificarLabel?>',
                                              handler:function()
                                                      {
                                                          var gridRegistros=gEx('gridRegistros');
                                                          var fila=gridRegistros.getSelectionModel().getSelected();
                                                          if(fila==null)
                                                          {
                                                              msgBox('Debe seleccionar el registro que desea editar');
                                                              return;
                                                          }
                                                          
                                                          
                                                          if(tipoProceso!='1') 
                                                      	  {
                                                          	
                                                          }
                                                          else
                                                          {
                                                          		var idReferencia=gE('idReferencia');
                                                                var idRef='-1';
                                                                if(idReferencia!=null)
                                                                    idRef=gE('idReferencia').value;
                                                                var arrDatos=[['idReferencia',idRef],['idRegistro',fila.get('idRegistro')],['idFormulario',gE('idFormulario').value],['dComp','<?php echo base64_encode("modificar")?>'],['formularioNormal','1']];
                                                                var soloContenido=gE('soloContenido').value;        
                                                                if(soloContenido=='1')
                                                                {
                                                                    var arreglo=new Array();
                                                                    arreglo[0]='cPagina';
                                                                    arreglo[1]='sFrm=true';
                                                                    arrDatos.push(arreglo);
                                                                }
                                                                enviarFormularioDatos('../modeloPerfiles/registroFormulario.php',arrDatos);
                                                          }
                                                          
                                                      }
                                              
                                          },'-',
                                          {
                                              id:'btnEliminar',
                                              icon:'../images/delete.png',
                                              cls:'x-btn-text-icon',
                                              disabled:true,
                                              hidden:<?php echo $ocultarEliminar?>,
                                              text:'<?php echo $btnEliminarLabel?>',
                                              handler:function()
                                                      {
                                                          var gridRegistros=gEx('gridRegistros');
                                                          var fila=gridRegistros.getSelectionModel().getSelected();
                                                          if(fila==null)
                                                          {
                                                              msgBox('Debe seleccionar el registro que desea eliminar');
                                                              return;
                                                          }
                                                          function resp(btn)
                                                          {
                                                              if(btn=='yes')
                                                              {
                                                                  function funcResp()
                                                                  {
                                                                      var arrResp=peticion_http.responseText.split('|');
                                                                      if(arrResp[0]=='1')
                                                                      {
                                                                          gridRegistros.getStore().remove(fila);
                                                                          var frameContenidoGrid=gEx('frameContenidoGrid');
                                                                          if(frameContenidoGrid!=undefined)
                                                                          {
                                                                              frameContenidoGrid.load	(
                                                                                                      {
                                                                                                          url:'../paginasFunciones/white.php'
                                                                                                          
                                                                                                      }
                                                                                                  )
                                                                          }
                                                                      }
                                                                      else
                                                                      {
                                                                           msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);				
                                                                      }
                                                                  }
                                                                  obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=39&idRegistro='+fila.get('idRegistro')+'&idFormulario=<?php echo $idFormulario?>',true);
                                                              }
                                                          }
                                                          msgConfirm('Est&aacute; seguro de querer eliminar el registro seleccionado?',resp);
                                                      }
                                              
                                          },'-',
                                          {
                                              icon:'../images/page_white_magnify.png',
                                              cls:'x-btn-text-icon',
                                              text:'Mostrar vista previa',
                                              hidden:true,
                                              handler:function()
                                                          {
                                                              //gEx('frameContenidoGrid').toggleCollapse(presionado);
                                                          }
                                              
                                          },
                                          {
                                              icon:'../images/gantt.png',
                                              cls:'x-btn-text-icon',
                                              text:'Ver situaci&oacute;n registro',
                                              hidden:false,
                                              hidden:<?php echo $ocultarSituacion?>,
                                              handler:function()
                                                          {
                                                              var gridRegistros=gEx('gridRegistros');
                                                              var fila=gridRegistros.getSelectionModel().getSelected();
                                                              if(fila==null)
                                                              {
                                                                  msgBox('Debe seleccionar el registro cuya situaci&oacute;n desea observar');
                                                                  return;
                                                              }
                                                              var obj={};
                                                              obj.ancho=920;
                                                              obj.alto=460;
                                                              obj.titulo='Situaci&oacute;n del registro';
                                                              obj.url='../reportes/estadisticasRegistros.php';
                                                              obj.params=[['idFormulario','<?php echo $idFormulario?>'],['idRegistro',fila.get('idRegistro')],['cPagina','sFrm=true']];
                                                              abrirVentanaFancy(obj);
                                                          }
                                              
                                          }
                                          <?php
                                              echo $cadBotones;
                                          ?>
                                      ],
                                view: vConfig
    
                                      
                            }

	if(gE('idProcesoPadre').value=='-1')
	{
    	oConfiguracion.width=960;
        oConfiguracion.height=500;
        
        var alto=500;
        <?php
			if($arrFiltros!="")
			{
				echo "alto=527;";
			}
		?>
													
        gridRegistros=		new Ext.Panel	(
        										{
                                                	renderTo:'tblListado',
                                                    width:960,
                                                    height:alto,
                                                    
                                                    <?php
														if($arrFiltros!="")
														{
													?>
                                                    	tbar:	new Ext.Toolbar(
                                                        							{
                                                                                        
                                                                                        items:	[
                                                                                        			<?php
																										echo $arrFiltros
																									?>
                                                                                        		]
                                                                                    }	
                                                        						),
                                                    <?php	
														}
													?>
                                                    
                                                	items:	[
                                                    			new Ext.grid.GridPanel	(
                                                                                              oConfiguracion
                                                                                          )
                                                    		]
                                                }
        									)
        				
        					
    }
    else
    {
    	
    	gridRegistros=	new Ext.Panel	(
                                            {
                                                region:'center',
                                                <?php
														if($arrFiltros!="")
														{
													?>
                                                    	tbar:	[
                                                        			<?php
																		echo $arrFiltros
																	?>
                                                        		],
                                                    <?php	
														}
													?>
                                                items:	[
                                                            new Ext.grid.GridPanel	(
                                                                                          oConfiguracion
                                                                                      )
                                                        ]
                                            }
                                        )
    
        
        
    	
                                                 
    	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                			
                                            gridRegistros
                                       ]
                            }
                        ) 
    
                                                  
    }                                          
	var objInicial={start:0, limit:tamPagina,funcion:6,idFormulario:<?php echo $idFormulario?>,idEstado:gE('idEstado').value,idConfiguracion:idConfig};                                              
                                              
	if(gE('tipoVista').value!='2')
    {
        
        objInicial.idReferencia=gE('idReferencia').value;
        if(gE('idProcesoPadre').value!='-1')
        {
            objInicial.idProcesoPadre=gE('idProcesoPadre').value;
        }
    }                                              
                                              
                                        
    dsTablaRegistros.load({params:objInicial});
	<?php
	if($configuracionEventos!="")
	{
		$objEventos=json_decode($configuracionEventos);

		foreach($objEventos->arrEventos as $eventos)
		{
			if($eventos->evt!="rowselect")
			{
				echo "dsTablaRegistros.on('".$evento->evt."',".$eventos->funcion.")";
			}
		}
	}
	?>
	gEx('gridRegistros').getSelectionModel().on('rowselect',function(sm,nFila,r)
    													{
                                                        	var registro=gEx('gridRegistros').getStore().getAt(nFila);
                                                        	var frameContenidoGrid=gEx('frameContenidoGrid');
                                                            gEx('btnAbrir').enable();
                                                            gEx('btnEliminar').enable();
                                                            gEx('btnModificar').enable();
                                                            
                                                            
                                                            var permisos=registro.get('permisos');
                                                            if((permisos.indexOf('E')==-1)||(gE('sL').value=='1'))
                                                            	gEx('btnEliminar').disable();
                                                                
                                                            if((permisos.indexOf('M')==-1)||(gE('sL').value=='1'))
                                                            	gEx('btnModificar').disable();    
                                                                
															objParam={
                                                                          cPagina:'sFrm=true',
                                                                          idRegistro:registro.get('idRegistro'),
                                                                          idFormulario:gE('idFormulario').value

                                                                      };
                                                                      
                                                                    
                                                        	
															if(frameContenidoGrid)
                                                            {
                                                                frameContenidoGrid.load	(
                                                                                            {
                                                                                                url:'../modeloPerfiles/verFichaFormulario.php',
                                                                                                scripts:true,
                                                                                                params:	objParam
                                                                                            }
                                                                                        )
															}                                                                                    
															<?php
																if($configuracionEventos!="")
																{
																	$objEventos=json_decode($configuracionEventos);
															
																	foreach($objEventos->arrEventos as $eventos)
																	{
																		if($eventos->evt=="rowselect")
																		{
																			echo $eventos->funcion."(sm,nFila,registro);";
																		}
																	}
																}
																?>                                                                                    
                                                                                    
                                                        }
    										)  
	                                            
	if(tipoProceso=='1')
 	{
    	var btnNuevo=gEx('btnNuevo');
        var btnAbrir=gEx('btnAbrir');
        var btnModificar=gEx('btnModificar');
        var btnEliminar=gEx('btnEliminar');
        if(cAccion.indexOf('C')!=-1)
        {
        	btnAbrir.show();
            
        }
        
        if(cAccion.indexOf('A')!=-1)
        {
        	btnNuevo.show();
           
        }
        
        if(cAccion.indexOf('M')!=-1)
        {
        	btnModificar.show();
           
        }
        
        if(cAccion.indexOf('E')!=-1)
        {
        	btnEliminar.show();
            
        }
    }                                          
	return gridRegistros;
    
}

function formatearDecimal(val,meta,registro,numFinal,numColumnas)
{
	var gridRegistros=gEx('gridRegistros');
    var columna=gridRegistros.getColumnModel().config[numColumnas];
    if(columna)
	    return formatearNumero(val,columna.numDecimales,columna.separadorDecimal,columna.separadorMiles);
    return val;
}

function formatearValorEstandar(val)
{
	return '<span title="'+val+'" alt="'+val+'">'+val+'</span>';
}

function formatearTiempo(val)
{
	var fecha=new Date();
    
	if(val!="")
    {
		return Date.parseDate(val,'H:i:s').format("H:i A");
    }
    return '';
}

function formatearFecha(val)
{
	if(val!="")
    {
		var arrValor=val.split('-');
        if(val.indexOf(':')==-1)
        {
        	return arrValor[2]+'/'+arrValor[1]+'/'+arrValor[0];	
        }
        else
        {
        	var anio=arrValor[2];
            var datos=anio.split(' ');
            anio=datos[0];
            var comp=' ';
            if(datos[1]!='00:00:00')
            {
            	comp=' '+datos[1];
            }
        	return anio+'/'+arrValor[1]+'/'+arrValor[0]+comp;
        }
    	
    }
    return '';
}

function formatearArchivo(val)
{
	var descArch='';
	if(val!='')
		descArch='<a href="../paginasFunciones/obtenerArchivos.php?id='+bE(val)+'"><img src="../images/download.png" alt="Descargar" title="Descargar" />&nbsp;&nbsp;Descargar</a>';
    else
    	descArch='Sin documento';
	return descArch;
}

function formatearTexto(val)
{
	var cad=val.replace(/div/gi,'sp').replace(/p/gi,'par').replace(/br/gi,'').replace(/style/gi,'stilo');
	return '<span title="'+cad+'" alt="'+cad+'">'+val.replace(/div/gi,'sp').replace(/p/gi,'par').replace(/br/gi,'').replace(/style/gi,'stilo')+'</span>';
}

function removerRegistro(iR)
{
	function resp(btn)
    {
        if(btn=='yes')
        {
            function funcResp()
            {
                var arrResp=peticion_http.responseText.split('|');
                if(arrResp[0]=='1')
                {
                	var almacen=gEx('gridRegistros').getStore();
                    var pos=obtenerPosFila(almacen,'idRegistro',bD(iR));
                    var fila= almacen.getAt(pos);
                   	almacen.remove(fila);
                    var frameContenidoGrid=gEx('frameContenidoGrid');
                    if(frameContenidoGrid!=undefined)
                    {
                        frameContenidoGrid.load	(
                                                {
                                                    url:'../paginasFunciones/white.php'
                                                    
                                                }
                                            )
                    }
                }
                else
                {
                     msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);				
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=39&idRegistro='+bD(iR)+'&idFormulario=<?php echo $idFormulario?>',true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer eliminar el registro seleccionado?',resp);
}

function recargarContenedorCentral()
{
	gEx('gridRegistros').getStore().reload();
}

function regresar1Pagina()
{
	recargarContenedorCentral();
}

function regresar2Pagina()
{
	recargarContenedorCentral();
}


function regresar1PaginaContenedor()
{

	recargarContenedorCentral();
}

function regresarContenedorCentral()
{

	recargarContenedorCentral();
}

function regresarPagina2Contenedor()
{
	recargarContenedorCentral();
}

function ejecutarFuncionCambioEstado(idRegistro,idFormulario,idReferencia)
{
	recargarContenedorCentral();
}


function formatearEtapa(val)
{
	var arrDatos=val.split('.-');
    var valor=removerCerosDerecha(arrDatos[0])+'.- '+arrDatos[1];
    return valor;
}

