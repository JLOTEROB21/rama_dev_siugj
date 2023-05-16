<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idTableroControl=bD($_GET["iT"]);
	
	$nombreTabla="9060_tableroControl_".$idTableroControl;
	$consulta="SELECT tiempoActualizacion,registrosPagina,visibleBarraNotificaciones,horasAlertaPreventiva,permiteDelegarTareas FROM  9060_tablerosControl WHERE idTableroControl=".$idTableroControl;
	$fConfiguracion=$con->obtenerPrimeraFila($consulta);

	$tiempoActualizacion=$fConfiguracion[0];
	if($tiempoActualizacion=="")
		$tiempoActualizacion=0;
	
	$visibleBarraNotificaciones="false";
	if($fConfiguracion[2]==1)
		$visibleBarraNotificaciones="true";
		
	$horasAlertaPreventiva=$fConfiguracion[3];
	$permiteDelegarTareas=$fConfiguracion[4];
	$consulta="SELECT valor FROM 9062_configuracionUsuarioTableroControl WHERE idTableroControl=".$idTableroControl." AND idUsuario=".$_SESSION["idUsr"]." AND tipoConfiguracion=1";	
	$horasUsuario=$con->obtenerValor($consulta);
	if($horasUsuario!="")
		$horasAlertaPreventiva=$horasUsuario;	
	
	$consulta="	select cg.etiquetaCampo,tamanoColumna as 'tamColumna' ,nombreCampo,visible,alineacionValores,funcionRenderer
				from 9061_camposTableroControl cg where cg.idIdioma=".$_SESSION["leng"]." and cg.idTableroControl=".$idTableroControl." order by cg.orden";
	
	$res=$con->obtenerFilas($consulta);
	$campos='	{"name":"idRegistro"},{"name":"statusNotificacion"},{"name":"fechaVisualizacion"},{"name":"tipoNotificacion"},
				{"name":"contenidoMensaje"},{"name":"iFormulario"},{"name":"iRegistro"},{"name":"iReferencia"},
				{"name":"objConfiguracion"},{"name":"permiteAbrirProceso"},{"name":"idNotificacionBase"},{"name":"delegadaPor"},
				{"name":"nTurnados"},{"name":"marcarAtendidaAbrir"}';
	$filtroCampos="";
	$columnModel="new  Ext.grid.RowNumberer({width:60,idGridPaginacion:'paginadorGrid'}),
												{
													header:'ID Tarea',
													width:90,
													sortable:true,
													dataIndex:'idRegistro',
													align:'center',
													resizable:true
												},
												{
													header:'',
													width:50,
													sortable:true,
													dataIndex:'idNotificacionBase',
													align:'center',	
													hidden:".( $permiteDelegarTareas==0?"true":"false").",
													renderer:rendererTareaDelegada,
													resizable:false
												},
												{
													header:'',
													width:30,
													sortable:true,
													dataIndex:'nTurnados',
													align:'center',	
													hidden:".( $permiteDelegarTareas==0?"true":"false").",
													renderer:rendererTareaTurnada,
													resizable:false
												},
												{
													header:'',
													width:40,
													sortable:true,
													dataIndex:'statusNotificacion',
													align:'center',						
													renderer:statusNotificacion,
													resizable:false
												},
												{
													header:'',
													width:40,
													sortable:true,
													dataIndex:'permiteAbrirProceso',
													renderer:rendererPermiteAbrirProceso,
													align:'center',						
													resizable:false
												}
												";

	while($fila=$con->fetchRow($res))
	{
		if($fila[3]==0)
			continue;	
		
		$campos.=",{name: '".$fila[2]."'}";
			
			
		$alineacion="";
		switch($fila[4])
		{
			case 1:
				$alineacion="left";
			break;
			case 2:
				$alineacion="right";
			break;
			case 3:
				$alineacion="center";
			break;
			case 4:
				$alineacion="justify";
			break;
			
		}
		
		$funcionRenderer="renderer:mostrarValorDescripcion,";
		if($fila[5]!="")
		{
			$consulta="SELECT nombreFuncionJS FROM 9033_funcionesScriptsSistema WHERE idFuncion=".$fila[5];
			$funcRenderer=$con->obtenerValor($consulta);
			if($funcRenderer!="")
				$funcionRenderer="renderer:".$funcRenderer.",";
		}
		
		$columnModel.="	,{
							header:'".uEJ($fila[0])."',
							width:".$fila[1].",
							sortable:true,
							dataIndex:'".$fila[2]."',
							align:'center',".$funcionRenderer."
							css:'text-align: ".$alineacion." !important;',							
							resizable:false
						}";
		
		$tipoFiltro="";
		
		$consulta="SELECT upper(DATA_TYPE) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$con->bdActual."' AND TABLE_NAME='".$nombreTabla."'
					and COLUMN_NAME='".$fila[2]."'";
		
		$tipoDato=$con->obtenerValor($consulta);			
		switch($tipoDato)
		{
			case "DATE":
			case "DATETIME":
				$tipoFiltro="date";
			break;
			case "INT":
			case "DECIMAL":
				$tipoFiltro="numeric";
			break;
			case "TEXT":
			case "VARCHAR":
				$tipoFiltro="string";
			break;
		}
		if($tipoFiltro!="")
		{
			$tipoFiltro='{type:"'.$tipoFiltro.'", dataIndex: "'.$fila[2].'"}';			
			if($filtroCampos=="")
				$filtroCampos=$tipoFiltro;
			else						
				$filtroCampos.=",".$tipoFiltro;
		}
		
		
	}
	
	$arrValoresFiltro="";
	
	$arrIdFiltros="var arrIdFiltros=[];";
	$arrFiltros="";
	$consulta="SELECT * FROM 9065_filtrosGlobalesTableroControl WHERE idTableroControl=".$idTableroControl;
	$rConfiguracion=$con->obtenerFilas($consulta);
	while($fConfiguracion=$con->fetchRow($rConfiguracion))
	{
		
		$valor1="";
		$valor2="";
		$valor1Aux="";
		$valor2Aux="";
		$operador1="";
		$operador2="";
		if($fConfiguracion[6]!=-1)
		{
			
			$oParam='{"idTableroControl":"'.$idTableroControl.'","campo":"'.$fConfiguracion[2].'","idFiltro":"'.$fConfiguracion[0].'","noFiltro":""}';
			$objParametros=json_decode($oParam);
			$objParametros->noFiltro=1;
			
			$valor1=resolverExpresionCalculoPHP($fConfiguracion[6],$objParametros,$cacheCalculos);

			if(gettype($valor1)=='array')
			{
				$operador1=$valor1[0];
				$valor1=removerComillasLimite($valor1[1]);
				if(isset($valor1[2]))
					$valor1Aux=$valor1[2];
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
				if(isset($valor2[2]))
					$valor2Aux=$valor2[2];
			}
			else
			{
				$valor2=removerComillasLimite($valor2);
			}
				
		}
		
		$control="";
		switch($fConfiguracion[3])
		{
			case 1://Rango de valores numericos
			
				if($operador1=="")
					$operador1="=";
				
				if($operador2=="")
					$operador2="=";
					
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador1.'"}),new Ext.form.NumberField({id:"filtro1_'.$fConfiguracion[2].'",width:"40",allowDecimals:true,allowNegative:true,value:"'.$valor1.'", enableKeyEvents:true,cls:"controlSIUGJ"}),'.
						'{width:10,xtype:"tbspacer"},{ hidden:true, id:"btnClean_'.$fConfiguracion[2].'_1",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon",handler:function(btn){limpiarFiltro(btn)}},{"xtype":"label",html:"&nbsp;&nbsp;<span style=\"color:#000\"><b>y</b></span>&nbsp;&nbsp;"},crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador2.'"}),new Ext.form.NumberField({id:"filtro2_'.
							$fConfiguracion[2].'",width:"40",allowDecimals:true,allowNegative:true,value:"'.$valor2.'", enableKeyEvents:true,cls:"controlSIUGJ"}),{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_2",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon",handler:function(btn){limpiarFiltro(btn)}}';
				
				
				$arrIdFiltros.="arrIdFiltros.push(['filtro1_".$fConfiguracion[2]."','".$fConfiguracion[2]."','0','".$fConfiguracion[2]."','1']);";	
				$arrIdFiltros.="arrIdFiltros.push(['filtro2_".$fConfiguracion[2]."','".$fConfiguracion[2]."','0','".$fConfiguracion[2]."','2']);";			
							
							
			break;	
			
			case 3:// Lista de valores selección única (Textos)
			case 4:// Lista de valores selección multiple (Textos)
				
				$arrValores="";
				if($fConfiguracion[5]!=-1)
				{
					$oParam='{"idTableroControl":"'.$idTableroControl.'","campo":"'.$fConfiguracion[2].'","idFiltro":"'.$fConfiguracion[0].'"}';
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
					$consulta="SELECT DISTINCT ".$fConfiguracion[2].",".$fConfiguracion[2]." FROM ".$nombreTabla." ORDER BY ".$fConfiguracion[2];
					$arrValores=$con->obtenerFilasArreglo($consulta);
				}

				$compMulti="";
				if($fConfiguracion[3]==4)
					$compMulti=",multiSelect:true,funcionCheckBoxCheck:filtroMultiselect'";
				
				$arrValoresFiltro.="var arrValores_".$fConfiguracion[2]."=".$arrValores.";";
				$control='crearComboExt("filtro1_'.$fConfiguracion[2].'",arrValores_'.$fConfiguracion[2].',0,0,'.$fConfiguracion[4].',{valor:"'.$valor1.'"'.$compMulti.',listClass:"listComboSIUGJ", cls:"comboSIUGJ",fieldClass:"comboSIUGJ",ctCls:"comboWrapSIUGJ", height:30}),{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_1",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon",handler:function(btn){limpiarFiltro(btn)}}';
								
				$arrIdFiltros.="arrIdFiltros.push(['filtro1_".$fConfiguracion[2]."','".$fConfiguracion[2]."','0','".$fConfiguracion[2]."','1']);";	
			break;
			
			case 5: //Escritura de valor (Textos)
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
						$valor1.'", enableKeyEvents:true,cls:"controlSIUGJ"}),{width:10,xtype:"tbspacer"},{id:"btnClean_'.$fConfiguracion[2].'_1",hidden:true, width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon",handler:function(btn){limpiarFiltro(btn)}}';
				
				
				$arrIdFiltros.="arrIdFiltros.push(['filtro1_".$fConfiguracion[2]."','".$fConfiguracion[2]."','0','".$fConfiguracion[2]."','1']);";	

			break;	
			case 6://Rango de valores fechas
				if($operador1=="")
					$operador1="=";
				
				if($operador2=="")
					$operador2="=";
					
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador1.'"}),new Ext.form.DateField({"id":"filtro1_'.$fConfiguracion[2].'",value:"'.$valor1.'"})'.
						',{width:10,xtype:"tbspacer"},{hidden:true,  id:"btnClean_'.$fConfiguracion[2].'_1",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon",handler:function(btn){limpiarFiltro(btn)}},{"xtype":"label",html:"&nbsp;&nbsp;<span style=\"color:#000\"><b>y</b></span>&nbsp;&nbsp;"},crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador2.'"}),new Ext.form.DateField({"id":"filtro2_'.
						$fConfiguracion[2].'",value:"'.$valor2.'"}),{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_2",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon",handler:function(btn){limpiarFiltro(btn)}}';
				
				
				$arrIdFiltros.="arrIdFiltros.push(['filtro1_".$fConfiguracion[2]."','".$fConfiguracion[2]."','0','".$fConfiguracion[2]."','1']);";	
				$arrIdFiltros.="arrIdFiltros.push(['filtro2_".$fConfiguracion[2]."','".$fConfiguracion[2]."','0','".$fConfiguracion[2]."','2']);";		
			break;
			case 7: //Rango de valores hora
				if($operador1=="")
					$operador1="=";
				
				if($operador2=="")
					$operador2="=";
					
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador1.'"}),crearComboExt("filtro1_'.$fConfiguracion[2].'",arrHoras,0,0,120,{valor:"'.$valor1.'"}),'.
						',{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_1",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon",handler:function(btn){limpiarFiltro(btn)}},{"xtype":"label",html:"&nbsp;&nbsp;<span style=\"color:#000\"><b>y</b></span>&nbsp;&nbsp;"},
						crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador2.'"}),crearComboExt("filtro2_'.$fConfiguracion[2].'",arrHoras,0,0,120,{valor:"'.$valor2.'"}),{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_2",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon",handler:function(btn){limpiarFiltro(btn)}}';
				
				
				$arrIdFiltros.="arrIdFiltros.push(['filtro1_".$fConfiguracion[2]."','".$fConfiguracion[2]."','0','".$fConfiguracion[2]."','1']);";	
				$arrIdFiltros.="arrIdFiltros.push(['filtro2_".$fConfiguracion[2]."','".$fConfiguracion[2]."','0','".$fConfiguracion[2]."','2']);";
			break;
			case 8: //Rango de valores fecha hora
				if($operador1=="")
					$operador1="=";
				
				if($operador2=="")
					$operador2="=";
					
				$control='crearComboExt("op1_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador1.'"}),new Ext.form.DateField({"id":"filtro1_'.$fConfiguracion[2].'",value:"'.$valor1.'"})'.
						',crearComboExt("filtro1Aux_'.$fConfiguracion[2].'",arrHoras,0,0,120,{valor:"'.$valor1Aux.'"}),{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_1",width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon",handler:function(btn){limpiarFiltro(btn)}},{"xtype":"label",html:"&nbsp;&nbsp;<span style=\"color:#000\"><b>y</b></span>&nbsp;&nbsp;"},crearComboExt("op2_'.$fConfiguracion[2].'",arrCondicionales,0,0,40,{valor:"'.$operador2.'"}),new Ext.form.DateField({"id":"filtro2_'.
						$fConfiguracion[2].'",value:"'.$valor2.'"}),crearComboExt("filtro2Aux_'.$fConfiguracion[2].'",arrHoras,0,0,120,{valor:"'.$valor2Aux.'"}),
						{width:10,xtype:"tbspacer"},{hidden:true, id:"btnClean_'.$fConfiguracion[2].'_2", 0 width:40,height:30,ctCls:"botonEliminarFiltro",icon:"../principalPortal/imagesSIUGJ/deleteFilter.png",border:true,cls:"x-btn-icon",handler:function(btn){limpiarFiltro(btn)}}';
				
				
				$arrIdFiltros.="arrIdFiltros.push(['filtro1_".$fConfiguracion[2]."','".$fConfiguracion[2]."','0','".$fConfiguracion[2]."','1']);";	
				$arrIdFiltros.="arrIdFiltros.push(['filtro2_".$fConfiguracion[2]."','".$fConfiguracion[2]."','0','".$fConfiguracion[2]."','2']);";
			break;
		}
		$filtro='{"xtype":"label", "html":"<div class=\'letraNombreTablero\'>'.$fConfiguracion[1].':</div>"},{xtype:"tbspacer", width:30},'.$control;//,"-"'
		if($arrFiltros=="")
			$arrFiltros=$filtro;
		else
			$arrFiltros.=",".$filtro;
	}
	

	echo $arrValoresFiltro;
	echo $arrIdFiltros;
	

	$arrPuestosInferiores="";
	if($permiteDelegarTareas==1)
	{
		$consulta="SELECT claveNivel,e.idReferencia FROM _421_tablaDinamica e,_420_tablaDinamica p ,_420_unidadGestion uGP, _17_tablaDinamica uG
					WHERE usuarioAsignado=".$_SESSION["idUsr"]." AND e.idReferencia=p.id__420_tablaDinamica AND uGP.idPadre=p.id__420_tablaDinamica 
					AND uG.id__17_tablaDinamica=uGP.idOpcion AND uG.claveUnidad='".$_SESSION["codigoInstitucion"]."'";


		$fDatosOrganigrama=$con->obtenerPrimeraFila($consulta);



		
		if($fDatosOrganigrama)
		{

			$arrPuestos=array();
			obtenerPuestosHijosAsignaciones($fDatosOrganigrama[1],$fDatosOrganigrama[0],$arrPuestos);
	
			foreach($arrPuestos as $i=>$oPuesto)
			{
				$oTurno=	"
								{
	
									cls:'x-btn-text-icon',
									text:'".cv($oPuesto["nombre"])." [".cv($oPuesto["nombrePuesto"])."]',
									handler:function(btn)
											{
												designarTarea(btn,".$oPuesto["idUsuario"].",'".$oPuesto["clave"]."','".cv($oPuesto["nombre"])." [".cv($oPuesto["nombrePuesto"])."]"."')
											}
	
								}
							";
	
				if($arrPuestosInferiores=="")
					$arrPuestosInferiores=$oTurno;
				else
					$arrPuestosInferiores.=",".$oTurno;
			}
		}
	}
	
	
	$consulta="select HEX(AES_ENCRYPT('".$_SESSION["idUsr"]."', '".bD($versionLatis)."'))";
	$idUsuario=$con->obtenerValor($consulta);
?>

var horasAlertaPreventiva=<?php echo $horasAlertaPreventiva?>;
var expander =null;
var temporizador=null;
var tiempoActualizacion=<?php echo $tiempoActualizacion?>;
var visibleBarraNotificaciones=<?php echo $visibleBarraNotificaciones?>;

var camposJava=new Array( <?php echo $campos; ?>);
var columnasJava=new Array(<?php echo $columnModel; ?>);
var arrCondicionales=[['>','>'],['>=','>='],['=','='],['<','<'],['<=','<=']];

var arrCondicionalesTexto=[["like '@valor%'",'Inicia con'],["like '%@valor%'",'Contiene']];

var arrHoras=[];

Ext.onReady(inicializar);

function inicializar()
{
	
	var horaInicial=new Date(<?php echo date("Y")?>,5,10,0,0);
	var horaFinal=new Date(<?php echo date("Y")?>,5,10,23,59);
	arrHoras=generarIntervaloHoras(horaInicial,horaFinal,10);
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',                                                
                                                border:false,
                                                cls:'panelSiugj',
                                                layout:'border',
                                                
                                                <?php
												if($arrFiltros!="")
												{
											?>
												tbar:	[
															{
                                                                xtype:'tbspacer',
                                                                width:30
                                                            },
															
                                                            
                                                            <?php
																echo $arrFiltros.","
															?>
                                                            {
                                                                xtype:'tbspacer',
                                                                width:30
                                                            },
                                                            {
                                                                xtype:'label',
                                                                x:50,
                                                                cls:'letraNombreTablero',
                                                                html:'<div class="letraNombreTablero">Marcar notificaci&oacute;n como:&nbsp;&nbsp;</div>'
                                                            },
                                                            {
                                                                icon:'../principalPortal/imagesSIUGJ/btnAtendida.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'<span class="buttonGral" style="color:#1A3E9A">Atendida</span>',
                                                                width:120,
                                                                height:45,
                                                                handler:function()
                                                                        {
                                                                        	var gridRegistros=gEx('gridRegistros');
                                                                            var filas=gridRegistros.getSelectionModel().getSelections();
                                                                            if(filas.length==0)
                                                                            {
                                                                                msgBox('Debe seleccionar las notificaciones que desea marcar como atendidas');
                                                                                return;
                                                                            }
                                                                            
                                                                            var lista='';
                                                                            var x;
                                                                            for(x=0;x<filas.length;x++)
                                                                            {
                                                                                if(lista=='')
                                                                                    lista=filas[x].data.idRegistro;
                                                                                else
                                                                                    lista+=','+filas[x].data.idRegistro;
                                                                            }
                
                                                                            
                                                                            function resp(btn)
                                                                            {
                                                                                if(btn=='yes')
                                                                                {
                                                                                    function funcAjax(peticion_http)
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                            recargarGridRegistros();
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=46&l='+lista+'&s=2&iT=<?php echo $idTableroControl?>',true);
                                                                                    
                                                                                }
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer marcar las notificaciones seleccionadas como atendidas?',resp);
                                                                            
                                                                        }
                                                                
                                                            },
                                                            {
                                                                xtype:'tbspacer',
                                                                width:30
                                                            },
                                                            {
                                                                icon:'../principalPortal/imagesSIUGJ/btnEnEspera.png',
                                                                cls:'x-btn-text-icon',
                                                                width:150,
                                                                height:45,
                                                                text:'<span class="buttonGral" style="color:#1A3E9A">En espera de atenci&oacute;n</span>',
                                                                handler:function()
                                                                        {
                                                                        	var gridRegistros=gEx('gridRegistros');
                                                                            var filas=gridRegistros.getSelectionModel().getSelections();
                                                                            if(filas.length==0)
                                                                            {
                                                                                msgBox('Debe seleccionar las notificaciones que desea marcar como En espera de atenci&oacute;n');
                                                                                return;
                                                                            }
                                                                            
                                                                            var lista='';
                                                                            var x;
                                                                            for(x=0;x<filas.length;x++)
                                                                            {
                                                                                if(lista=='')
                                                                                    lista=filas[x].data.idRegistro;
                                                                                else
                                                                                    lista+=','+filas[x].data.idRegistro;
                                                                            }
                                                                            
                                                                            function resp(btn)
                                                                            {
                                                                                if(btn=='yes')
                                                                                {
                                                                                    function funcAjax(peticion_http)
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                            recargarGridRegistros();
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=46&l='+lista+'&s=1&iT=<?php echo $idTableroControl?>',true);
                                                                                    
                                                                                }
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer marcar las notificaciones seleccionadas como En espera de atenci&oacute;n?',resp);
                                                                        }
                                                                
                                                            },
														],
                                                        
											<?php	
												}
											?>
                                                items:	[
                                                            crearGridRegistros()
                                                        ]
                                            }
                                         ]
                            }
                        )   
                        
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
                var filtroAux=gEx('filtro'+f[4]+'Aux_'+f[1]);
                if(filtroAux)
                {
                 	filtroAux.on('select',recargarGridRegistros);                           
                }
            break;
            case 'numberfield':
                ctrl.on('keyup',recargarGridRegistros);
            break;
            case 'combo':
            	ctrl.on('select',recargarGridRegistros);
                
            break;
        }
        
        
        
    }   
    tiempoActualizacion=parseFloat(tiempoActualizacion);
    if((tiempoActualizacion>0)&&(gE('desactivarTemporizador').value=='0'))
    {
    	iniciarTemporizador();
        
    }
                       
                        
}

function recargarGridRegistros(cAutomatica)
{
	if(!cAutomatica)
    	cAutomatica=0;
        
	var ultimoParametros=gEx('gridRegistros').getStore().lastOptions;
    
	Ext.apply(ultimoParametros.params,{consultaAutomatica:cAutomatica,filtroAuxiliar:window.parent.parent.filtroAuxiliar,arrFiltroGlobal:generarConsultaFiltros()});
    
    
    

	gEx('gridRegistros').getStore().reload(ultimoParametros);
}

function crearGridRegistros()
{
	var expander = new Ext.ux.grid.RowExpander({
                                                    column:3,
                                                    width:40,
                                                    expandOnEnter:false,
                                                    expandOnDblClick:false,
                                                    tpl : new Ext.Template(
                                                        '<table width="100%" >'+
                                                        '<tr><td  style="padding:10px">{contenidoMensaje}</td></tr>'+
                                                        '</table>'
                                                    )
                                                }); 	 


	expander.on('expand',function(exp,registro)
    						{
                            	if(registro.data.fechaVisualizacion=='')
                                {
                                	registrarVisualizacionNotificacion(registro.data.idRegistro);
                                }
                            }
    			)

	columnasJava.splice(1,0,expander);
	
        
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
                                                    
	
                                                    
                                                
	function cargarDatos(proxy,parametros)
    {
    	proxy.baseParams.iT=bE(<?php echo $idTableroControl?>);
        proxy.baseParams.funcion=7;
		proxy.baseParams.arrFiltroGlobal=generarConsultaFiltros();
        proxy.baseParams.iU='<?php echo $idUsuario?>';
        proxy.baseParams.filtroAuxiliar=window.parent.parent.filtroAuxiliar;
        
       
        
        
    }                                      
                                                    
	dsTablaRegistros.on('beforeload',cargarDatos);  
    dsTablaRegistros.on('load',function(dSet,registros,optionces)
    							{
                                	if(window.parent.actualizarBurbujaTareas)
                                    {
                                    	window.parent.actualizarBurbujaTareas(<?php echo $idTableroControl?>,dSet.reader.jsonData.numRegistrosActivos);
                                    }

                                }
    					); 
    var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly :true, width:40}); 
    columnasJava.splice(2,0,chkRow);                                             
    var modelColumn= new Ext.grid.ColumnModel   	(
												 		columnasJava
													);
	var tamPagina =<?php echo (!isset($fConfiguracion[1]) || $fConfiguracion[1]=="")?100:$fConfiguracion[1]?>;
	
	var paginador=	new Ext.PagingToolbar	(
                                                    {
                                                          pageSize: tamPagina,
                                                          id:'paginadorGrid',
                                                          store: dsTablaRegistros,
                                                          displayInfo: true,
                                                          disabled:false
                                                      }
                                                   )                      
	



	

	var oConfiguracion=		{
                                columnLines :false,
                                cm: modelColumn,
                                border:false,
                                id:'gridRegistros',
                                loadMask: true,
                                sm:chkRow,
                                cls:'gridSiugjPrincipal',
                                plugins: [expander,filters],
                                store:dsTablaRegistros,
                                stripeRows :false,
                                /*tbar:	[
                                			
                                            <?php
											if($arrPuestosInferiores!="")
											{
											?>	
												,
												'-',
												{
													icon:'../images/user_go.png',
													cls:'x-btn-text-icon',
													text:'Delegar actividad a...',
													menu: [<?php echo $arrPuestosInferiores?>]

												}
                                            <?php
											}
											?>
                                            
                                		],*/
                                bbar: [
                                		{
                                        	xtype:'tbspacer',
                                            width:40
                                        },
                                        {
                                        	xtype:'label',
                                            cls:'xtb-text',
                                            html:'<table><tr><td><img src="../principalPortal/imagesSIUGJ/warningWhite.png" /></td><td class="xtb-text">&nbsp;&nbsp;Notificar &nbsp;&nbsp;</td></tr><table>'
                                        },
                                        {
                                        	xtype:'numberfield',
                                            allowDecimals:false,
                                            allowNegative:false,
                                            width:50,
                                            value:horasAlertaPreventiva,
                                            id:'txtHorasNotificacion',
                                            listeners:	{
                                            				change:function(ctrl,newValue,oldValue)
                                                            		{
                                                                    	if((newValue==0)||(newValue==''))
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	ctrl.setValue(oldValue);
                                                                            	ctrl.focus();
                                                                            }
                                                                            msgBox('El valor ingresado NO es v&aacute;lido',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                if((window.parent.parent)&&(window.parent.parent.verificarNotificaciones))
                                                                                {
                                                                                	window.parent.parent.verificarNotificaciones(gE('idTableroControl').value);
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	ctrl.setValue(oldValue);
	                                                                            	ctrl.focus();
                                                                                }
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],resp2);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesTblFormularios.php',funcAjax, 'POST','funcion=9&tipoValor=1&valor='+newValue+'&iT='+gE('idTableroControl').value,true);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                    }
                                            			}
                                            
                                            
                                        },
                                        
                                        {
                                        	xtype:'label',
                                            cls:'xtb-text',
                                            html:'&nbsp;&nbsp;días antes de la fecha límite de vencimiento'
                                        },
                                        {
                                        	xtype:'tbspacer',
                                            width:(window.parent.parent.parent.obtenerDimensionesNavegador()[1]*0.28)
                                        },
                                        paginador
                                       ],
                                region:'center',
                                view: new Ext.grid.GroupingView(	
                                									{
                                                                          enableNoGroups :true,
                                                                          enableGrouping : false,
                                                                          enableGroupingMenu : true,
                                                                          forceFit:false,
                                                                          hideGroupedColumn : false,
                                                                          groupTextTpl: '<span class="letraFicha">{text}</span>',//(<font color="#000066">Total: </font> <font color="#FF0000">{values.rs.length}</font>)
                                                                          startCollapsed :false
                                                                    }
                                                                 )
    
                                      
                            }

	                                    
	var objInicial={start:0, limit:tamPagina,funcion:7,iT:bE(<?php echo $idTableroControl?>)};                                              
                                              
                                        
    dsTablaRegistros.load({params:objInicial});
	
	var gridRegistros=new Ext.grid.GridPanel	(
                                                      oConfiguracion
                                                  );	                                            


	                                
	return gridRegistros;
    
}

function generarConsultaFiltros()
{
	var aFiltros='';
    var x;
    var f;
    var o;
    var operador='';
    var filtro;
    var operando='';
    var campo='';
    for(x=0;x<arrIdFiltros.length;x++)                                     
    {
    	
        f=arrIdFiltros[x];
        filtro=gEx(f[0]);
        if(filtro.getValue()!='')
        {
            campo=f[3];
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
                    
                        var valorComp='';
                        var filtroAux=gEx('filtro'+f[4]+'Aux_'+f[1]);
                        if(filtroAux)
                        {
                            if($f[4]=='1')
                            {
                                if(filtroAux.getValue()=='')
                                    valorComp=' 00:00:00';
                                else
                                    valorComp=' '+filtroAux.getValue()+':00';
                            }
                            else
                            {
                                if(filtroAux.getValue()=='')
                                    valorComp=' 23:59:59';
                                else
                                    valorComp=' '+filtroAux.getValue()+':59';
                            }                                    
                        }
                        else
                        {
                        	campo='DATE('+campo+')';
                        }
                        condicion=operando.getValue()+"'"+filtro.getValue().format('Y-m-d')+valorComp+"'";
                    break;
                    case  'textfield':
                        condicion=operando.getValue().replace('@valor',cv(filtro.getValue()));
                        
                        
                    break;
                    default:
                        condicion=operando.getValue()+"'"+filtro.getValue()+"'";
                    break;
                    
                }
            }
            
            o='{"idControl":"'+f[1]+'","campo":"'+campo+'","tipo":"'+f[2]+'","condicion":"'+condicion+'","busquedaInterna":"'+busquedaInterna+'"}';
           
            if(aFiltros=='')
                aFiltros=o;
            else
                aFiltros+=','+o;
        }
    }
    
    var objFiltro=bE(('{"filtros":['+aFiltros+']}'));
    return objFiltro;
    
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

function limpiarFiltro(btn)
{
	
	var id=btn.id.replace('__','_-');
	var arrDatos=id.split('_');
    
    gEx('filtro'+arrDatos[2]+'_'+arrDatos[1].replace('-','_')).setValue('');
    
    var filtroAux= gEx('filtro'+arrDatos[2]+'Aux_'+arrDatos[1].replace('-','_'));
    if(filtroAux)
    	filtroAux.setValue('');
    
    
    
    recargarGridRegistros();
}


function temporizadorActualizaciones()
{
	recargarGridRegistros(1);
    if(visibleBarraNotificaciones)
    {
    	
    }
}

function iniciarTemporizador()
{
	if(temporizador==null)
		temporizador=setInterval(temporizadorActualizaciones, tiempoActualizacion*60*1000);
}

function detenerTemporizador()
{
	clearInterval(temporizador);	
    temporizador=null;
}

function statusNotificacion(val)
{
	switch(val)
    {
    	case '0':
        	return '<img src="../images/warning_0.png" title=""El tiempo límite de atención se encuentra dentro de los intervalos normales" alt="El tiempo límite de atención se encuentra dentro de los intervalos normales">';
        break;
        case '1':
        	return '<img src="../images/warning_1.png" title="El tiempo límite de atención está por vencer" alt="El tiempo límite de atención está por vencer">';
        break;
        case '2':
        	return '<img src="../images/warning_2.png" title="El tiempo límite de atención ha vencido" alt="El tiempo límite de atención ha vencido">';
        break;
    }

}

function rendererPermiteAbrirProceso(val,meta,registro)
{
	if(val=='1')
    {
    	return '<a href="javascript:abrirEnlaceTarea(\''+bE(registro.data.objConfiguracion)+'\',\''+bE(registro.data.idRegistro)+
        		'\',\''+bE(registro.data.marcarAtendidaAbrir)+'\')"><img src="../principalPortal/imagesSIUGJ/lupa.png" title="Abrir expediente" alt="Abrir expediente"></a>';
    }
}

function abrirEnlaceTarea(objConfiguracion,iR,mA)
{
	var obj=eval('['+bD(objConfiguracion)+']')[0];
    if(bD(mA)=='0')
    {
    	
    	eval(obj.funcionApertura+'(\''+objConfiguracion+'\',\''+iR+'\',\''+bE('<?php echo $idTableroControl?>')+'\')');
    }
    else
    {
    	function funcAjax3(peticion_http)
        {

            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                eval(obj.funcionApertura+'(\''+objConfiguracion+'\',\''+iR+'\',\''+bE('<?php echo $idTableroControl?>')+'\')');
                recargarGridRegistros();
            }
            
        }
        obtenerDatosWebV2('../paginasFunciones/funcionesFormulario.php',funcAjax3, 'POST','funcion=300&iN='+(iR)+'&iT='+bE(<?php echo $idTableroControl?>),false);
    	
    }
    
}


function mostrarVentanaAperturaProcesoNotificacion(cadObj,r,iT)
{

	var objConf=eval('['+bD(cadObj)+']')[0];  
	var actor=objConf.actorAccesoProceso;
	
	var pos=obtenerPosFila(gEx('gridRegistros').getStore(),'idRegistro',bD(r));
	var fila=gEx('gridRegistros').getStore().getAt(pos);    
	var obj={}; 

	if(actor=='0')
	{

		obj.params=[['idTarea',bD(r)],['idTablero',bD(iT)],['idFormulario',fila.data.iFormulario],['idRegistro',fila.data.iRegistro],['dComp',bE('auto')],['actor',bE(actor)]];
		obj.ancho='100%';
		obj.alto='100%';
		obj.modal=true;
		obj.url='<?php echo $visorExpedienteProcesos?>';
		obj.title=fila.data.tipoNotificacion;    
		if(window.parent.parent)
			window.parent.parent.abrirVentanaFancy(obj);
		else
			if(window.parent)
				window.parent.abrirVentanaFancy(obj);
			else
				abrirVentanaFancy(obj);
		if(fila.data.fechaVisualizacion=='')
		{
			registrarVisualizacionNotificacion(fila.data.idRegistro);
		}
	}
	else
	{
		function funcAjax2(peticion_http)
		{
			var resp=peticion_http.responseText;
			arrResp=resp.split('|');
			if(arrResp[0]=='1')
			{
				actor=arrResp[1];
				obj.params=[['idTarea',bD(r)],['idFormulario',fila.data.iFormulario],['idRegistro',fila.data.iRegistro],['dComp',bE('auto')],['actor',bE(actor)]];
				obj.ancho='100%';
				obj.alto='100%';
				obj.modal=true;
				obj.url='<?php echo $visorExpedienteProcesos?>';
				obj.title=fila.data.tipoNotificacion;   
				if(window.parent.parent)
					window.parent.parent.abrirVentanaFancy(obj);
				else
					if(window.parent)
						window.parent.abrirVentanaFancy(obj);
					else
						abrirVentanaFancy(obj);
				if(fila.data.fechaVisualizacion=='')
				{
					registrarVisualizacionNotificacion(fila.data.idRegistro);
				}


			}
			else
			{
				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
			}
		}
		obtenerDatosWebV2('../paginasFunciones/funcionesFormulario.php',funcAjax2, 'POST','funcion=239&iT='+iT+'&iA='+(r)+'&iR='+bE(fila.data.iRegistro)+'&iF='+bE(fila.data.iFormulario)+'&a='+bE(actor),false);


	}

}

function registrarVisualizacionNotificacion(iR,funcionAccion)
{
	function funcAjax3(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	 var pos=obtenerPosFila(gEx('gridRegistros').getStore(),'idRegistro',iR);
   			 var fila=gEx('gridRegistros').getStore().getAt(pos);  
             
             
             var objConfiguracion=eval('['+fila.data.objConfiguracion+']')[0];
             if(objConfiguracion.afterVisualizacion && objConfiguracion.afterVisualizacion!='')
             {
             	eval(objConfiguracion.afterVisualizacion+'(fila);');
             }
             
             //fila.set('fechaVisualizacion',arrResp[1]);  
             if(funcionAccion)
             	funcionAccion();   
                
             
             
             
             
                
             
                
        }
        
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesFormulario.php',funcAjax3, 'POST','funcion=240&iN='+bE(iR)+'&iT='+bE(<?php echo $idTableroControl?>),false);
}

function designarTarea(btnPresed,idUsuario,cvePuesto,lblEtiqueta)
{
	var filas=gEx('gridRegistros').getSelectionModel().getSelections();
	if(filas.length==0)
	{
		msgBox('Debe seleccionar las actividades que desea delegar');
		return;
	}
	
	function resp(btn)
	{
		if(btn=='yes')
		{
			var x;
			var f;
			var actividadesDelegadas='';
			for(x=0;x<filas.length;x++)
			{
				f=filas[x];
				if(actividadesDelegadas=="")
					actividadesDelegadas=f.data.idRegistro;
				else
					actividadesDelegadas+=','+f.data.idRegistro;
			}
		
			var cadObj='{"idTablero":"<?php echo $idTableroControl?>","lblEtiqueta":"'+cv(lblEtiqueta)+'","idUsuario":"'+idUsuario+'","actividadesDelegadas":['+actividadesDelegadas+']}';
		
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				arrResp=resp.split('|');
				if(arrResp[0]=='1')
				{
					gEx('gridRegistros').getStore().reload();
				}
				else
				{
					msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=243&cadObj='+cadObj,true);
		}
		
	}
	msgConfirm('Est&aacute; seguro de querer delegar la actividad a:<br><br><b>'+btnPresed.text+'</b>?',resp);
}

function rendererTareaDelegada(val,meta,registro)
{
	if(val!='')
	{
		return '<img src="../images/exclamation.png" alt="Actividad delegada por: '+registro.data.delegadaPor+'" title="Actividad delegada por: '+registro.data.delegadaPor+'"><img src="../images/send_email_user.png" alt="Actividad delegada por: '+registro.data.delegadaPor+'" title="Actividad delegada por: '+registro.data.delegadaPor+'">'
	}
}

function rendererTareaTurnada(val,meta,registro)
{
	if((val!='')&&(val!='0'))
	{
		return '<a href="javascript:window.parent.parent.mostrarVentanaTareasDelegadas(\''+bE(registro.data.idRegistro)+'\')"><img src="../images/user_go.png" alt="La actividad ha sido delegada a '+((parseInt(val)==1)?'1 usuarios':val+' usuarios')+'" title="La actividad ha sido delegada a '+((parseInt(val)==1)?'1 usuarios':val+' usuarios')+'"></a>';
	}
}



//
function regresar1Pagina()
{

	recargarGridRegistros();
}

function regresar2Pagina()
{

	recargarGridRegistros();
	
}

function recargarContenedorCentral()
{

	recargarGridRegistros();

    
}

function regresar1PaginaContenedor()
{

	recargarGridRegistros();


}

function regresarPagina2Contenedor()
{

	recargarGridRegistros();


}

function regresarContenedorCentral()
{

	recargarGridRegistros();

}

function mostrarVentanaAperturaProcesoNotificacionMacroProceso(cadObj,r,iT)
{
	var objConfiguracion=setAtributoCadJson(bD(cadObj),'iTarea',bD(r));
    objConfiguracion=setAtributoCadJson(objConfiguracion,'iTablero',bD(iT));
    var pos=obtenerPosFila(gEx('gridRegistros').getStore(),'idRegistro',bD(r));
    var fila=gEx('gridRegistros').getStore().getAt(pos);    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');

        if(arrResp[0]=='1')
        {
        	var obj={};
            var confAux=eval('['+arrResp[1]+']')[0];
            obj.params=[['idFormulario',confAux.idFormulario],['idRegistro',confAux.idRegistro],['dComp',confAux.accion],['actor',bE(confAux.idActorIngreso)]];
            obj.ancho='100%';
            obj.alto='100%';
            obj.modal=true;
            obj.url='<?php echo $visorExpedienteProcesos?>';
            obj.title=fila.data.tipoNotificacion;   
            if(window.parent.parent)
                window.parent.parent.abrirVentanaFancy(obj);
            else
                if(window.parent)
                    window.parent.abrirVentanaFancy(obj);
                else
                    abrirVentanaFancy(obj);
            if(fila.data.fechaVisualizacion=='')
            {
                registrarVisualizacionNotificacion(bD(r));
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=305&cadObj='+objConfiguracion,true);
    
        
}



