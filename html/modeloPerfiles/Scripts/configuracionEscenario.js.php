<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idProceso=base64_decode($_GET["proc"]);
	
	
	$consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="select nombre,idTipoProceso,situacion from 4001_procesos where idProceso=".$idProceso." and situacion=1";
	$fProceso=$con->obtenerPrimeraFila($consulta);
	$tProceso=$fProceso[1];
	
	$consulta="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProceso." order by numEtapa";
	$resEtapas=$con->obtenerFilas($consulta);
	$arrEtapas=uEJ($con->obtenerFilasArreglo($consulta));
	
	$arrEtapasNumero="";
	while($fEtapas=mysql_fetch_row($resEtapas))
	{
		$o="['".$fEtapas[0]."','".removerCerosDerecha($fEtapas[0]).".- ".cv($fEtapas[1])."']";
		if($arrEtapasNumero=="")
			$arrEtapasNumero=$o;
		else
			$arrEtapasNumero.=",".$o;
	}
	
	$arrEtapasNumero="[".$arrEtapasNumero."]";
	
	$res5=$con->obtenerFilas("select idIdioma,idioma,imagen from 8002_idiomas where idiomaSistema=1");
	$columnas="";
	$ancho=470;
	while($fila5=mysql_fetch_row($res5))
	{
		if($columnas=="")
			$columnas= "{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:300,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({  cls:'controlSIUGJ'})}";
		else
			$columnas.=","."{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:300,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({cls:'controlSIUGJ'})}";
	$ancho+=210;	
	}	
	if($ancho==255)
		$ancho+=210;
	$columnasDP=$columnas;
	$columnasDR=uEJ($columnas);
	$columnas.=",{header:'Pasa a etapa:',width:350,dataIndex:'numEtapa',editor:cmbPasaEtapa,renderer:formatearEtapa}";	
	$columnasDP.=",{header:'Acci&oacute;n autor:',width:200,dataIndex:'accion',editor:cmbAccion,renderer:formatearAccion},{header:'Requiere respuesta:',width:130,dataIndex:'reqRespuesta',editor:cmbSiNo,renderer:formatearSiNo}";	
	$columnas=uEJ($columnas);
	$columnasDP=uEJ($columnasDP);
	
	$campos="{name:'valorOpt'},{name:'icono'}";
	$camposOpciones="icono:'',valorOpt:''";
	$filaDefault="''";
	if(mysql_data_seek($res5,0))
	{
		while($fila5=mysql_fetch_row($res5))
		{
			$campos.=",{name:'idioma_".$fila5[0]."'}";
			$camposOpciones.=",idioma_".$fila5[0].":''";
			$filaDefault.=",''";
		}	
	}
	$filaDefaultDR=$filaDefault;
	$filaDefaultDP=$filaDefault.=",'1'";
	$filaDefault.=",'0'";
	$camposDR=uEJ($campos);
	$camposDP=uEJ($campos.",{name:'accion'},{name:'reqRespuesta'}");
	$campos.=",{name:'numEtapa'}";
	$campos=uEJ($campos);
	$camposOpcionesDP=uEJ($camposOpciones.",accion:'1',reqRespuesta:'0'");
	$camposOpciones.=",numEtapa:'0'";
	$camposOpciones=uEJ($camposOpciones);
	if($tProceso!="9")
		$tOpcion=1;
	else
	{
		
		$tOpcion="9";
	}
	$consulta="select valorOpcion,opcion from 951_catalogoOpcionesVarios where tipoOpcion=".$tOpcion." and idIdioma=".$_SESSION["leng"];
	$arrOpciones=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select valorOpcion,opcion from 951_catalogoOpcionesVarios where tipoOpcion=2 and idIdioma=".$_SESSION["leng"];
	$arrAcciones=uEJ($con->obtenerFilasArreglo($consulta));
	
	$consulta="select idTiempoPresupuestal, nombreTiempo from 524_tiemposPresupuestales";
	$arrTiempos=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos ORDER BY nombreCategoria";
	$arrTiposDocumentos=$con->obtenerFilasArreglo($consulta);
	$arrTiposDocumentos=substr($arrTiposDocumentos,1);
	$arrTiposDocumentos="[['0','Seleccionado por usuario'],".$arrTiposDocumentos;
	
	$arrProcesosActivos="";
	$consulta="SELECT idProceso,nombre,cveProceso FROM 4001_procesos WHERE situacion=1 AND idTipoProceso=3 ORDER BY nombre";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$consulta="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$fila["idProceso"]." order by numEtapa";
		$resEtapas=$con->obtenerFilas($consulta);
		$arrEtapasNumeroAux="";
		while($fEtapas=mysql_fetch_row($resEtapas))
		{
			$o="[parseFloat('".$fEtapas[0]."'),'".removerCerosDerecha($fEtapas[0]).".- ".cv($fEtapas[1])."']";
			if($arrEtapasNumeroAux=="")
				$arrEtapasNumeroAux=$o;
			else
				$arrEtapasNumeroAux.=",".$o;
		}
		
		$o="['".cv($fila["idProceso"])."','[".$fila["cveProceso"]."] ".cv($fila["nombre"])."',[".$arrEtapasNumeroAux."]]";
		if($arrProcesosActivos=="")
		{
			$arrProcesosActivos=$o;
		}
		else
		{
			$arrProcesosActivos.=",".$o;
		}
			
	}
	
	
	$arrProcesosActivos="[".$arrProcesosActivos."]";
	
	
	
	
	
	
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=1 order by descripcionValor ";
	$arrValorSesion=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=2 order by descripcionValor ";
	$arrValorSistema=uEJ($con->obtenerFilasArreglo($consulta));
	
	$idFormularioBase=obtenerFormularioBase($idProceso);
	
	$consulta="select * from(SELECT idGrupoElemento as idGrupoElemento,nombreCampo FROM 901_elementosFormulario WHERE idFormulario=".$idFormularioBase." AND tipoElemento IN(2,3,4,5,6,7,8,9,10,11,12,14,15,16,21,22,24,25,31)
			union
			SELECT tipoElemento as idGrupoElemento,campoUsr as nombreCampo FROM 9017_camposControlFormulario) as tmp order by nombreCampo 
		";
	$arrCamposFormularioBase=$con->obtenerFilasArreglo($consulta);
	
?>


var posScrollActual=0;
var arrCamposFormularioBaseOrigen=<?php echo $arrCamposFormularioBase?>;
var arrCamposFormularioBaseDestino=[];
var arrValorSesionGlobal=<?php echo $arrValorSesion?>;
var arrValorSistemaGlobal=<?php echo $arrValorSistema?>;
var tiposLlenado=[['0','Ninguno'],['7','Funci\xF3n de sistema'],['6','Valor de formulario base'],['1','Valor de sesi\xF3n'],['8','Valor manual'],['2','Valor de sistema']];							
var arrProcesosActivos=<?php echo $arrProcesosActivos?>;
var arrTiposDocumentos=<?php echo $arrTiposDocumentos?>;
var arrSiNo=<?php echo $arrSiNo?>;
var arrAccionesFirma=[['10','Marcar para firma'],['1','Firmar mediante FIEL'],['6','Firmar mediante FIREL'],['4','Firmar mediante documento'],['5','Autorizar documento'],['2','Rechazar firma'],['3','Solicitar ajustes']];
var arrEtapasNumero=<?php echo $arrEtapasNumero?>;
arrEtapasNumero.splice(0,0,['0','Ninguna']);
var arrAccionesConsecuentes=[['0','Continuar dentro del proceso'],['1','Cerra ventana de proceso']];
var arrEtapas=<?php echo $arrEtapas?>;
var arrAcciones=<?php echo $arrAcciones?>;
var arrNinguna=['0','Ninguna'];
arrEtapas.push(arrNinguna);
var arrAmbito=[['0','S\xF3lo Instituci\xF3n/departamento'],['1','Instituci\xF3n/departamento y subdepartamentos']];
function formatearAccion(val)
{
	var pos=existeValorMatriz(arrAcciones,val);
    if(pos>-1)
		return arrAcciones[pos][1];
    else
    	return val;
}


RegistroOpciones =Ext.data.Record.create	(
												[
													<?php 
														echo $campos;
													?>
												]
											)

function agregarActor(et)
{
	var idProceso=gE('idProceso').value;
	var arrActores=[];
	var gridActores=crearGridActores();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione los actores a agregar:'
                                                        },
                                                        gridActores
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar actores',
										width: 690,
										height:500,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
                                        cls:'msgHistorialSIUGJ',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															id:'btnAceptar',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var filas=gridActores.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos un actor para agregar a la etapa');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var x;
                                                                        var etapa=et;
                                                                        var idProceso=gE('idProceso').value;
                                                                        var id;
                                                                        var tipo;
                                                                        var cadActores='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	id=filas[x].get('idActor');
                                                                            tipo=filas[x].get('tipo');
                                                                            
                                                                            if(cadActores=='')
                                                                            	cadActores=id+'|'+tipo;
                                                                            else
                                                                            	cadActores+=','+id+'|'+tipo;
                                                                        }
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                                recargarTabEscenario();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=46&idProceso='+idProceso+'&numEtapa='+etapa+'&cadActores='+cadActores,true);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
																	}
														}
														
													]
									}
								);
	obtenerActoresDisponibles(et,idProceso,ventanaAM,gridActores.getStore());
}



function renderTipoUsuario(val)
{
	if(val=='1')
    	return "Usuario";
    else
    	return "Comit&eacute;";
}

function obtenerActoresDisponibles(etapa,idProceso,ventanaAM,almacen)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
            almacen.loadData(datos);
        	ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=45&idProceso='+idProceso+'&numEtapa='+etapa,true);
}

function agregarAccion(actor)
{
	var idProceso=gE('idProceso').value;
	var arrActores=[];
	var gridAcciones=crearGridAcciones();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione las acciones a agregar:'
                                                        },
                                                        gridAcciones
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar acci&oacute;n',
										width: 600,
                                        cls:'msgHistorialSIUGJ',
										height:490,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															id:'btnAceptar',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var filas=gridAcciones.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos una acci&oacute;n para agregar al actor');
                                                                        	return;
                                                                        }
                                                                        var x;
                                                                        var cadAcciones='';
                                                                        var idGrupoAccion;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	idGrupoAccion=filas[x].get('idGrupoAccion');
                                                                            
                                                                            if(cadAcciones=='')
                                                                            	cadAcciones=idGrupoAccion;
                                                                            else
                                                                            	cadAcciones+=','+idGrupoAccion;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                                recargarTabEscenario();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=48&cadAcciones='+cadAcciones+'&actor='+actor,true);
																	}
														}
														
													]
									}
								);
	
	obtenerAccionesActoresDisponibles(actor,ventanaAM,gridAcciones.getStore());
}

function crearGridAcciones()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idGrupoAccion'},
                                                                {name: 'accion'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														chkRow,
														{
															header:'Acci&oacute;n',
															width:410,
															sortable:true,
															dataIndex:'accion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridAccion',
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:50,
                                                            stripeRows :false,                                                            
                                                            columnLines : false,
                                                            cls:'gridSiugjPrincipal',
                                                            cm: cModelo,
                                                            height:300,
                                                            width:550,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function obtenerAccionesActoresDisponibles(actor,ventanaAM,almacen)
{
	var idProceso=gE('idProceso').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
            almacen.loadData(datos);
        	ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=47&actor='+actor+'&idProceso='+idProceso,true);
}

function removerActor(idActor)
{

	function resp(btn)
    {
		if(btn=='yes')
        {
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    var fila=gE('filaActor_'+idActor);
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=49&idActorProcesoEtapa='+idActor,true);
        }
   }

   msgConfirm('¿Est&aacute; seguro de querer remover a este actor?',resp);
}

function removerAccion(idAccion)
{
	function resp(btn)
    {
		if(btn=='yes')
        {
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    var fila=gE('filaAccion_'+idAccion);
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=50&idAccion='+idAccion,true);
		}
	}
    msgConfirm('¿Est&aacute; seguro de querer remover esta acci&oacute;n?',resp);       
}

function configurarSometeRevision(idAccion,numEtapa,etAct,gA)
{
	var arrEtapas=[];
    var lblEt='Seleccione la etapa a la cual pasar&aacute; el proceso:';
    var lblEtRes='Pasa a etapa: '
    gAc=0;
    if(gA!=undefined)
    {
    	gAc=gA;
    	switch(gA)
        {
        	case 12:
            	lblEt='Seleccione la etapa de la cual se somar&aacute; los posibles comit&eacute;s asignables:';
                lblEtRes='Asignar comités de la etapa:';
            break;
        }
    }
    
    
    
    var etiqueta=gE('lblEtiqueta_'+idAccion).innerHTML.trim();
    
    
    var oConf=eval('['+bD(gE('oConf_'+idAccion).value)+']')[0];

    
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:lblEt
                                                        },
                                                        {
                                                        	x:10,
                                                            y:50,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Etapa:'
                                                        },
                                                        {
                                                        	x:120,
                                                            y:45,
                                                            html:'<div id="divComboEtapa"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Etiqueta:'
                                                        },
                                                        {
                                                        	x:120,
                                                            y:95,
                                                        	xtype:'textfield',
                                                            id:'txtEtiqueta',
                                                            width:300,
                                                            cls:'controlSIUGJ',
                                                            value:etiqueta
                                                        },
                                                        {
                                                        	x:460,
                                                            y:100,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'&Iacute;cono:'
                                                        },
                                                        {
                                                        	x:540,
                                                            y:95,
                                                            xtype:'textfield',
                                                            width:270,
                                                            cls:'controlSIUGJ',
                                                            value:oConf.icono!==undefined?oConf.icono:'',
                                                            id:'txtIcono'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:145,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Mensaje de confimaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:140,
                                                            xtype:'textarea',
                                                            id:'txtMensaje',
                                                            width:560,
                                                            height:55,
                                                            cls:'controlSIUGJ',
                                                            value:bD(gE('msgConf_'+idAccion).value)
                                                        },
                                                        {
                                                        	x:10,
                                                            y:210,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Permitir agregar comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:390,
                                                            y:205,
                                                            html:'<div id="divComboComentariosAdicionales"></div>'
                                                        },
                                                        
                                                        
                                                        {
                                                        	x:10,
                                                            y:260,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Acci&oacute;n a ejecutar una vez realizado el cambio de etapa:'
                                                        },
                                                        {
                                                        	x:500,
                                                            y:255,
                                                            html:'<div id="divComboAccionCambioEtapa"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:310,
                                                            xtype:'label',
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n de visualizaci&oacute;n:'
                                                        },
                                                        {
                                                          xtype:'textfield',
                                                          width:500,
                                                          x:250,
                                                          y:305,
                                                          cls:'controlSIUGJ',
                                                          value:oConf.lblFuncionVisualizacion!==undefined?oConf.lblFuncionVisualizacion:'',
                                                          id:'txtFuncionVisualizacionDictamenFinal',
                                                          readOnly:true
                                                      },
                                                      {
                                                          xtype:'label',
                                                          x:770,
                                                          y:307,
                                                          html:'<a href="javascript:agregarFuncionControlEscenario(2)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControlEscenario(2)"><img src="../images/cross.png"></a>'
                                                      },
                                                         {
                                                        	x:10,
                                                            y:360,
                                                            xtype:'label',
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n de validaci&oacute;n:'
                                                        },
                                                        {
                                                          xtype:'textfield',
                                                          width:500,
                                                          x:250,
                                                          y:355,
                                                          cls:'controlSIUGJ',
                                                          value:oConf.lblFuncionValidacion!==undefined?oConf.lblFuncionValidacion:'',
                                                          id:'txtFuncionAplicacionDictamenFinal',
                                                          readOnly:true
                                                      },
                                                      {
                                                          xtype:'label',
                                                          x:770,
                                                          y:357,
                                                          html:'<a href="javascript:agregarFuncionControlEscenario(1)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControlEscenario(1)"><img src="../images/cross.png"></a>'
                                                      }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de etapa',
										width: 850,
										height:500,
                                        cls:'msgHistorialSIUGJ',
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                
                                                                
                                                                	
                                                                	var cmbEtapas=crearComboExt('cmbEtapas',arrEtapas,0,0,690,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboEtapa'});
                                                                    
                                                                    
																	
                                                                    
                                                                    
                                                                    var cmbComentariosAdicionales=crearComboExt('cmbComentariosAdicionales',[['0','No'],['1','S\xED']],0,0,140,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboComentariosAdicionales'});
                                                                    cmbComentariosAdicionales.setValue(((oConf.solicitarComentarios==undefined)||(oConf.solicitarComentarios=='0'))?'0':'1');
                                                                    var cmAccionEnvio=crearComboExt('cmAccionEnvio',arrAccionesConsecuentes,0,0,310,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboAccionCambioEtapa'});
                                                                    cmAccionEnvio.setValue(((oConf.cerrarVentana==undefined)||(oConf.cerrarVentana=='0'))?'0':'1');
                                                                    	
                                                                	gEx('txtFuncionAplicacionDictamenFinal').idConsulta=oConf.funcionValidacionSistema!==undefined?oConf.funcionValidacionSistema:'-1';
                                                                    gEx('txtFuncionVisualizacionDictamenFinal').idConsulta=oConf.funcionVisualizacion!==undefined?oConf.funcionVisualizacion:'-1';
                                                                                         
                                                                    obtenerEtapasDisponibles(idAccion,0,numEtapa,ventanaAM,cmbEtapas.getStore(),undefined,undefined,etAct);
                                                                
                                                                }
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															id:'btnAceptar',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var cmbEtapas=gEx('cmbEtapas');
																		var numEt=cmbEtapas.getValue();
                                                                        var txtEtiqueta=gEx('txtEtiqueta').getValue();
                                                                        var txtMensaje=gEx('txtMensaje').getValue();
                                                                        
                                                                        if(numEt=='')
                                                                        {
                                                                        	msgBox('Debe Seleccionar la etapa a la cual pasar&aacute; el proceso');
                                                                        	return;
                                                                        }
                                                                        if(txtEtiqueta=='')
                                                                        {
                                                                        	msgBox('Debe ingresar la etiqueta a mostrar para esta acci&oacute;n');
                                                                            return;
                                                                        }
                                                                        
                                                                        if(txtMensaje=='')
                                                                        {
                                                                        	msgBox('Debe ingresar el mensaje mostrar para confirmar la acci&oacute;n');
                                                                            return;
                                                                        }
                                                                        
                                                                        var cmAccionEnvio=gEx('cmAccionEnvio');
                                                                        var cmbComentariosAdicionales=gEx('cmbComentariosAdicionales');
                                                                        
                                                                        var obj='{"etiqueta":"'+cv(txtEtiqueta)+'","msgConf":"'+cv(txtMensaje)+'","solicitarComentarios":"'+
                                                                        		cmbComentariosAdicionales.getValue()+'","cerrarVentana":"'+cmAccionEnvio.getValue()+
                                                                                '","icono":"'+cv(gEx('txtIcono').getValue())+'","funcionVisualizacion":"'+
                                                                                (gEx('txtFuncionVisualizacionDictamenFinal').getValue()==''?-1:gEx('txtFuncionVisualizacionDictamenFinal').idConsulta)+
                                                                                '","funcionValidacionSistema":"'+(gEx('txtFuncionAplicacionDictamenFinal').getValue()==''?-1:gEx('txtFuncionAplicacionDictamenFinal').idConsulta)+'"}';
                                                                        

                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var spanDestino=gE('tblEtapas_'+idAccion);
                                                                                var etapaPasa= cmbEtapas.getRawValue();
                                                                                var cadSpan;
                                                                                switch(gAc)
                                                                                {
                                                                                	case 12:
                                                                                    	cadSpan=lblEtRes+etapaPasa;
                                                                                    break;
                                                                                	default:
	                                                                                	cadSpan=lblEtRes+etapaPasa;
                                                                                }
                                                                                spanDestino.innerHTML='<div class="SIUGJ_ControlEtiqueta14_GrisClaro">'+cadSpan+'</div>';
                                                                                var lblEtiqueta=gE('lblEtiqueta_'+idAccion);
                                                                                lblEtiqueta.innerHTML=txtEtiqueta;
                                                                                gE('msgConf_'+idAccion).value=bE(txtMensaje);
                                                                                
                                                                                obj='{"etiqueta":"'+cv(txtEtiqueta)+'","msgConf":"'+cv(txtMensaje)+'","solicitarComentarios":"'+
                                                                        		cmbComentariosAdicionales.getValue()+'","cerrarVentana":"'+cmAccionEnvio.getValue()+
                                                                                '","icono":"'+cv(gEx('txtIcono').getValue())+'","funcionVisualizacion":"'+
                                                                                (gEx('txtFuncionVisualizacionDictamenFinal').getValue()==''?-1:gEx('txtFuncionVisualizacionDictamenFinal').idConsulta)+
                                                                                '","funcionValidacionSistema":"'+(gEx('txtFuncionAplicacionDictamenFinal').getValue()==''?-1:gEx('txtFuncionAplicacionDictamenFinal').idConsulta)+
                                                                                '","lblFuncionVisualizacion":"'+cv(gEx('txtFuncionVisualizacionDictamenFinal').getValue(),false,true)+'","lblFuncionValidacion":"'+
                                                                                cv(gEx('txtFuncionAplicacionDictamenFinal').getValue(),false,true)+'"}';
                                                                        
                                                                                gE('btnModificar_'+idAccion).innerHTML='<a href="javascript:modificarPasoEtapa('+idAccion+','+numEtapa+','+cmbEtapas.getValue()+')"><img src="../images/formularios/pencil.png" title="Cambiar etapa" alt="Cambiar etapa"></a>';
                                                                                gE('oConf_'+idAccion).value=bE(obj);
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=52&idAccion='+idAccion+'&numEtapa='+numEt+'&objComp='+obj,true);
                                                                        
                                                                        
																	}
														}
														
													]
									}
								);

	ventanaAM.show();
	                                

}

function obtenerEtapasDisponibles(idAccion,idActor,et,ventana,almacen,ninguna,grupoElemento,etAct)
{
	var idProceso=gE('idProceso').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrEt=eval(arrResp[1]);
            if(ninguna!=undefined)
            	arrEt.push(['0','Ninguna']);
            almacen.loadData(arrEt);
            if(grupoElemento==null)
            {
	            //ventana.show();
                if(etAct)
                	gEx('cmbEtapas').setValue(etAct);
            }
            else
            	llenarOpcionesDictamen(idAccion,idActor,grupoElemento,ventana);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=51&idProceso='+idProceso+'&numEtapa='+et,true);
}

function llenarOpcionesDictamen(idAccion,idActor,idGrupoElemento,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrParam=eval(arrResp[1]);
			if(arrResp[2]!='')
            {
            	var objDictamen=eval('['+arrResp[2]+']')[0];
                gEx('etiquetaAccion').setValue(objDictamen.etiqueta);
                if(objDictamen.accionFinalizar!==undefined)
                {
                	gEx('cmAccionEnvio').setValue(objDictamen.accionFinalizar);
                }
                if(objDictamen.mostrarFormularioAsociado!==undefined)
                {
                	gEx('cmbMostrarFormularioAsociado').setValue(objDictamen.mostrarFormularioAsociado);
                }
                
                if(objDictamen.funcionVisualizacion!==undefined)
                {
                	gEx('txtFuncionVisualizacionDictamenFinal').setValue(objDictamen.lblFuncionVisualizacion);	
                    gEx('txtFuncionVisualizacionDictamenFinal').idConsulta=objDictamen.funcionVisualizacion;
                }
                
                if(objDictamen.funcionValidacion!==undefined)
                {
                	gEx('txtFuncionAplicacionDictamenFinal').setValue(objDictamen.lblFuncionValidacion);	
                    gEx('txtFuncionAplicacionDictamenFinal').idConsulta=objDictamen.funcionValidacion;
                }
                
                if(objDictamen.icono!==undefined)
                {
                	 gEx('txtIcono').setValue(objDictamen.icono);
                }
                
               
                
			}
            else
            {
            	gEx('etiquetaAccion').setValue('Realiza dictamen final');
            	  
            }	
            Ext.getCmp('gridOpcionesManuales').getStore().loadData(arrParam);
        	//ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=54&idAccion='+bD(idAccion)+'&idElemento='+idGrupoElemento,true);


}

function modificarPasoEtapa(idAccion,numEtapa,etAct,gA)
{
	configurarSometeRevision(idAccion,numEtapa,etAct,gA)
}


function configurarDictamenFinal(iA,iAccion,e,idGrupoElemento,iF)
{
	
    var idAccion=bD(iAccion);
    var et=bD(e);
    var idActor=bD(iA);
	var arrEtapas=[];
    var grupoElemento=null;
    if(idGrupoElemento!=undefined)
    {
	    idGrupoElemento=bD(idGrupoElemento);
    	grupoElemento=idGrupoElemento;
    }
	var cmbPasaEtapa=crearComboExt('cmbPasaEtapa',arrEtapas,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
    var dsOpciones= [];
    alOpciones=		new Ext.data.SimpleStore(
                                                {
                                                    fields:	[
                                                                <?php 
                                                                    echo $campos;
                                                                ?>
                                                            ]
                                                }
                                            );
    
    alOpciones.loadData(dsOpciones);
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        {
                                                            header:'Clave',
                                                            width:100,
                                                            dataIndex:'valorOpt',
                                                            editor: new Ext.form.TextField   (
                                                                                                    {
                                                                                                    	cls:'controlSIUGJ'  
                                                                                                       
                                                                                                    }
                                                                                                )
                                                        },
                                                        {
                                                            header:'Icono',
                                                            width:140,
                                                            dataIndex:'icono',
                                                            editor: new Ext.form.TextField   (
                                                                                                    {
                                                                                                      
                                                                                                       cls:'controlSIUGJ'  
                                                                                                    }
                                                                                                )
                                                        }
                                                        ,
                                                        <?php 
                                                            echo $columnas;
                                                        ?>
                                                    ]
                                                );
    
    
    
    tblOpciones=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOpcionesManuales',
                                                            store:alOpciones,
                                                            frame:false,
                                                            clicksToEdit: 1,
                                                            cm: cmFrmDTD,
                                                            region:'center',
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines:false,
                                                            stripeRows :true,
                                                            width:<?php echo $ancho+35 ?>,
                                                            title:'Opciones para evaluaci&oacute;n',
                                                            tbar: [
                                                                    {
                                                                        text: 'Agregar opci&oacute;n',
                                                                        icon:'../images/add.png',
                                                                        handler : function()
                                                                                  {
                                                                                        var r=new RegistroOpciones	(
                                                                                                                        {
                                                                                                                            <?php echo $camposOpciones?>
                                                                                                                        }
                                                                                                                    ) 	
                                                                                        alOpciones.add(r);	
                                                                                        tblOpciones.startEditing(alOpciones.getCount()-1,0);
                                                                                  }
                                                                    }
                                                                    ,
                                                                    {
                                                                        text:'Eliminar Opci&oacute;n',
                                                                        icon:'../images/cancel_round.png',
                                                                        handler:function()
                                                                                {
                                                                                    var fila=tblOpciones.getSelectionModel().getSelectedCell();
                                                                                    if(fila!=null)
                                                                                    {
                                                                                        var posFila=alOpciones.getAt(fila[0]);
                                                                                        function funcConfirmDel(btn)
                                                                                        {
                                                                                        	
                                                                                            if(btn=="yes")
                                                                                            {
                                                                                                alOpciones.remove(posFila);
                                                                                            }
                                                                                        }
                                                                                       msgConfirm('¿Est&aacute; seguro de querer eliminar esta opci&oacute;n?',funcConfirmDel);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('Debe seleccionar la opci&oacute;n a remover');
                                                                                    }
                                                                                    
                                                                                }  
                                                                    }
                                                                    
                                                                  ]
                                                        }
                                                    );
    
    function funcEdicion(e)
    {
        if(e.field=='valorOpt')
        {
            var res=obtenerPosFila(e.grid.getStore(),'valorOpt',e.value);
            if((res!='-1')&&(e.row!=res))
            {
                function funcOK()
                {
                    e.record.set('valorOpt',e.originalValue);
                    e.grid.getView().refresh();
                    e.grid.startEditing(e.row,e.column);
                }
                msgBox('La opci&oacute;n ingresada ya se encuentra registrada',funcOK);
            }
        }
    }
    tblOpciones.on('afteredit',funcEdicion);
    
    
                            
   
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'border',
                                            defaultType: 'textfield',
                                            items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            activeTab:1,
                                                            id:'tabDictamenFinal',
                                                            cls:'tabPanelSIUGJ',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            title:'Generales',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:15,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            xtype:'label',
                                                                                            html:'Etiqueta de la acci&oacute;n:'
                                                                                        },
                                                                                        {
                                                                                            x:210,
                                                                                            y:10,
                                                                                            cls:'controlSIUGJ',
                                                                                            xtype:'textfield',
                                                                                            id:'etiquetaAccion',
                                                                                            width:520
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:65,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            xtype:'label',
                                                                                            html:'&Iacute;cono a presentar:'
                                                                                        },
                                                                                        {
                                                                                            x:210,
                                                                                            y:60,
                                                                                            cls:'controlSIUGJ',
                                                                                            xtype:'textfield',
                                                                                            width:520,
                                                                                            id:'txtIcono'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:120,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            xtype:'label',
                                                                                            html:'Acción a ejecutar una vez conclu&iacute;do:'
                                                                                        },
                                                                                        {
                                                                                            x:340,
                                                                                            y:115,
                                                                                            xtype:'label',
                                                                                            html:'<div id="divComboAccionEjecuta"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:175,
                                                                                            xtype:'label',
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Mostrar formulario asociado:'
                                                                                        },
                                                                                        {
                                                                                            x:280,
                                                                                            y:170,
                                                                                            xtype:'label',
                                                                                            html:'<div id="divComboFormularioAsociado"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:430,
                                                                                            y:175,
                                                                                            xtype:'label',
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'<a href="javascript:verFormulario('+bD(iF)+')">Editar formulario asociado</a>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:225,
                                                                                            xtype:'label',
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Funci&oacute;n de visualizaci&oacute;n:'
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:400,
                                                                                          x:280,
                                                                                          y:220,
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionVisualizacionDictamenFinal',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:700,
                                                                                          y:222,
                                                                                          html:'<a href="javascript:agregarFuncionControlEscenario(2)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControlEscenario(2)"><img src="../images/cross.png"></a>'
                                                                                      },
                                                                                         {
                                                                                            x:10,
                                                                                            y:275,
                                                                                            xtype:'label',
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Funci&oacute;n de validaci&oacute;n:'
                                                                                        },
                                                                                        {
                                                                                          xtype:'textfield',
                                                                                          width:400,
                                                                                          x:280,
                                                                                          y:270,
                                                                                          cls:'controlSIUGJ',
                                                                                          id:'txtFuncionAplicacionDictamenFinal',
                                                                                          readOnly:true
                                                                                      },
                                                                                      {
                                                                                          xtype:'label',
                                                                                          x:700,
                                                                                          y:277,
                                                                                          html:'<a href="javascript:agregarFuncionControlEscenario(1)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControlEscenario(1)"><img src="../images/cross.png"></a>'
                                                                                      }
                                                                            		]
                                                                        },
                                                                        tblOpciones
                                                            		]
                                                        }
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
                                        cls:'btnSIUGJ',
                                        width:140,
                                        id:'btnAceptar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                    	if(gEx('etiquetaAccion').getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	gEx('etiquetaAccion').focus();
                                                                            }
                                                                            msgBox('Debe ingresar la etiqueta de la acci&oacute;n',resp2);
                                                                            return;
                                                                        }
                                                                        var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
                                                                        var cmAccionEnvio=gEx('cmAccionEnvio');
                                                                        
                                                                        var txtFuncionVisualizacionDictamenFinal=gEx('txtFuncionVisualizacionDictamenFinal');
                                                                        var txtFuncionAplicacionDictamenFinal=gEx('txtFuncionAplicacionDictamenFinal');
                                                                        var objConfDictamen='{"etiqueta":"'+cv(gEx('etiquetaAccion').getValue())+'","accionFinalizar":"'+cmAccionEnvio.getValue()+
                                                                        					'","mostrarFormularioAsociado":"'+gEx('cmbMostrarFormularioAsociado').getValue()+
                                                                                            '","funcionVisualizacion":"'+((txtFuncionVisualizacionDictamenFinal.getValue()=='')?'-1':txtFuncionVisualizacionDictamenFinal.idConsulta)+
                                                                                            '","funcionValidacion":"'+((txtFuncionAplicacionDictamenFinal.getValue()=='')?'-1':txtFuncionAplicacionDictamenFinal.idConsulta)+
                                                                                            '","requiereTodasSecciones":"0","icono":"'+cv(gEx('txtIcono').getValue())+'"}';
                                                                            
                                                                        
                                                                            
                                                                        if(resul)
                                                                        {
                                                                            var opciones=obtenerValoresOpcionesManuales();
                                                                            
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	ventanaPregCerradas.close();
                                                                                    recargarTabEscenario();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=53&objOpciones={"idActor":"'+idActor+
                                                                            '","etiqueta":"'+cv(gEx('etiquetaAccion').getValue())+'","opciones":'+opciones+'}&objConfDictamen='+objConfDictamen+
                                                                            '&idAccion='+idAccion,true);
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    var ventanaPregCerradas = new Ext.Window(
                                            {
                                                title: 'Opciones de evaluaci&oacute;n',
                                                width: <?php echo ($ancho+300) ?> ,
                                                cls:'msgHistorialSIUGJ',
                                                height:470,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                                       		gEx('tabDictamenFinal').setActiveTab(0);
                                                                           	gEx('etiquetaAccion').focus(false,500);
                                                                           
                                                                           
                                                                           	var cmAccionEnvio=crearComboExt('cmAccionEnvio',arrAccionesConsecuentes,0,00,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboAccionEjecuta'});
																			cmAccionEnvio.setValue('0');
                                                                            
                                                                            
                                                                            var cmbMostrarFormularioAsociado=crearComboExt('cmbMostrarFormularioAsociado',arrSiNo,0,0,110,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboFormularioAsociado'});
																		    cmbMostrarFormularioAsociado.setValue('1');
                                                                        	obtenerEtapasDisponibles(iAccion,idActor,et,ventanaPregCerradas,cmbPasaEtapa.getStore(),true,grupoElemento);   
                                                                        	
                                                                        }
                                                                        
                                                                        
                                                                    }
                                                        },
                                                buttons:	[
                                                				{
                                                                    text: 'Cancelar',
                                                                    cls:'btnSIUGJCancel',
                                                            		width:140,
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaPregCerradas.close();
                                                                    }
                                                                },
                                                                btnSiguiente,
                                                                
                                                            ]
                                            }
                                        );
	
	ventanaPregCerradas.show();
	
 //
}

function formatearEtapa(val)
{
	var pos=existeValorMatriz(arrEtapas,val);
    if(pos>-1)
		return mostrarValorDescripcion(removerCerosDerecha(val+'')+'.- '+arrEtapas[pos][1]);
    else
    	return val;
}


 
function formatearSiNo(val)
{
	var pos=existeValorMatriz(arrSiNo,val);
    if(pos>-1)
		return arrSiNo[pos][1];
    else
    	return val;
}
 

function validarOpciones(dSet,tblEditor)
{
	var res=validarCampoNoVacio(tblOpciones.getStore(),'valorOpt');
	if(res!='-1')
	{
		function funcClickOk()
		{
			tblOpciones.startEditing(res-1,0);
			return false
		}
		msgBox('El contenido de esta celda no puede estar vac&iacute;a',funcClickOk);
	}
	else
	{
		var cm=tblEditor.getColumnModel();
		var idIdioma=gE('hLeng').value;
		var nomColumn='idioma_'+idIdioma;
		var posCol=cm.findColumnIndex(nomColumn);
		var x;
		var res=validarCampoNoVacio(dSet,nomColumn);
		if(res!='-1')
		{
			function funcClickOk()
			{
				tblEditor.startEditing(res-1,posCol);
				return false;
			}
			msgBox('El texto a mostrar como opci&oacute;n debe ser ingresado, al menos en su idioma',funcClickOk);	
			
		}
		else
		{
			var colName='';
            var numColums=cm.getColumnCount()-1;
           
            for(x=2;x<numColums;x++)
            {
                colName=cm.getDataIndex(x);
                if(colName!=nomColumn)
                {
                    res=validarCampoNoVacio(dSet,colName);
                    if(res!='-1')
                    {
                        function funcConfirmacion(btn)
                        {
                            if(btn=='yes')
                            {
                                for(x=2;x<cm.getColumnCount();x++)
                                {
                                    colName=cm.getDataIndex(x);
                                    if(colName!=nomColumn)
                                        rellenarValoresVaciosColumna(dSet,colName,nomColumn);
                                }
                                
                            }
                            return false;
                        }
                        msgConfirm('El texto a mostrar como opci&oacute;n no ha sido especificado en todos lo idiomas, desea continuar', funcConfirmacion);
                    }
                    else
                        return true;
                }
            }
            return true;
        	
		}
	}
    
    
}

function obtenerValoresOpcionesManuales()
{
	var opciones='';
    var cadTemp='';
    
    var tblOpciones=Ext.getCmp('gridOpcionesManuales');
    var cm=tblOpciones.getColumnModel();
    var ct=tblOpciones.getStore().getCount();
    var reg;
    var x;
    
    for(x=0;x<ct;x++)
    {
    	

        reg=tblOpciones.getStore().getAt(x);
		
        var valColumnas=obtenerValoresColumnasRegistro(cm,reg);
        cadTemp='{"vOpcion":"'+cv(reg.get('valorOpt'))+'",'+
                '"columnas":['+valColumnas+'],'+
                '"etapa":"'+reg.get('numEtapa')+'","icono":"'+cv(reg.data.icono)+'"}';
        
        console.log(cadTemp);
        
        if(opciones=='')
            opciones=cadTemp;
        else
            opciones+=','+cadTemp;
    }

    return '['+opciones+']';
}




function obtenerValoresColumnasRegistro(cm,reg)
{
	var columnas='';
	var idLeng='';
	var tColum='';
	var x;
    var nColDes=1;
	for(x=2;x<cm.getColumnCount()-nColDes;x++)
	{

		tColumn=cm.getDataIndex(x);
		idLeng=cm.getDataIndex(x).split('_')[1];
		if(columnas=='')
			columnas='{"idLeng":"'+idLeng+'","texto":"'+cv(reg.get(tColumn))+'"}';
		else
			columnas+=',{"idLeng":"'+idLeng+'","texto":"'+cv(reg.get(tColumn))+'"}';
	}
	return columnas;
}



function verFormulario(idFormulario)
{
	var obj={};
    obj.url='../modeloPerfiles/formularios.php';
    obj.params=[['redireccionarFormulario',1],['idFormulario',idFormulario],['cPagina','sFrm=true'],['accionCancelar',bE('window.parent.cerrarVentanaFancy()')]];
    obj.ancho='100%';
    obj.alto='100%';

   window.parent.abrirVentanaFancy(obj);
}

function agregarActorProceso(iP)
{
	var idProceso=iP;
	var arrActores=[];
	var gridActores=crearGridActores();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione los actores a agregar:'
                                                        },
                                                        gridActores
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar actores',
										width: 690,
										height:490,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															id:'btnAceptar',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var filas=gridActores.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos un actor para agregar al inicio del proceso');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var x;
                                                                       
                                                                        var idProceso=gE('idProceso').value;
                                                                        var id;
                                                                        var tipo;
                                                                        var cadActores='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	id=filas[x].get('idActor');
                                                                            tipo=filas[x].get('tipo');
                                                                            
                                                                            if(cadActores=='')
                                                                            	cadActores=id;
                                                                            else
                                                                            	cadActores+=','+id;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                                recargarTabEscenario();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=56&idProceso='+idProceso+'&cadActores='+cadActores,true);
																	}
														}
														
													]
									}
								);
	ventanaAM.show();                                
	obtenerActoresDisponiblesProceso(idProceso,ventanaAM,gridActores.getStore());
}

function obtenerActoresDisponiblesProceso(idProceso,ventana,almacen)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
            almacen.loadData(datos);
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=55&idProceso='+idProceso,true);	
}

function removerActorInicio(idA)
{
	function respRemover(btn)
    {
       
        if(btn=='yes')
        {
            
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    var fila=gE('filaActorInicio_'+idA);
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=57&idActor='+idA,true);
        }
    }
   	msgConfirm('¿Est&aacute; seguro de querer remover a este actor?',respRemover);
}

function agregarAccionInicio(actor)
{
	var idProceso=gE('idProceso').value;
	var arrActores=[];
	var gridAcciones=crearGridAcciones();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione las acciones a agregar:'
                                                        },
                                                        gridAcciones
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar acci&oacute;n',
										width: 600,
										height:490,
                                        cls:'msgHistorialSIUGJ',
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
                                        				,
														{
															id:'btnAceptar',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var filas=gridAcciones.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos una acción para agregar al actor');
                                                                        	return;
                                                                        }
                                                                        var x;
                                                                        var cadAcciones='';
                                                                        var idGrupoAccion;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	idGrupoAccion=filas[x].get('idGrupoAccion');
                                                                            
                                                                            if(cadAcciones=='')
                                                                            	cadAcciones=idGrupoAccion;
                                                                            else
                                                                            	cadAcciones+=','+idGrupoAccion;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                                recargarTabEscenario();
                                                                            }
                                                                            else
                                                                            {

                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=59&cadAcciones='+cadAcciones+'&actor='+actor+'&idProceso='+idProceso,true);
																	}
														}
														
													]
									}
								);
	
	obtenerAccionesActoresDisponiblesInicio(actor,ventanaAM,gridAcciones.getStore());
}

function obtenerAccionesActoresDisponiblesInicio(actor,ventanaAM,almacen)
{
	var idProceso=gE('idProceso').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
            almacen.loadData(datos);
        	ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=58&actor='+actor+'&idProceso='+idProceso,true);
}

function removerAccionInicio(idAccion)
{
	function resp(btn)
    {
		if(btn=='yes')
        {
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    var fila=gE('filaAccionInicio_'+idAccion);
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=60&idAccion='+idAccion,true);
		}
	}
    msgConfirm('¿Est&aacute; seguro de querer remover esta acci&oacute;n?',resp);       
}

function configurarVerRegistros(idAc,vReg,tAccion)
{
	var arrVerRegistros=<?php echo $arrOpciones?>;
    
    
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:15,
                                                            html:'<div id="divComboVerRegistro"></div>'
                                                        }
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de registros que ver&aacute; el actor',
										width: 720,
										height:190,
                                        cls:'msgHistorialSIUGJ',
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbVerRegistros=crearComboExt('cmbVerRegistros',arrVerRegistros,0,0,530,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboVerRegistro'});
                                                                    
                                                                    if(vReg !=undefined)
                                                                        cmbVerRegistros.setValue(vReg);
                                                                
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var cmbVerRegistros=gEx('cmbVerRegistros');
																		var verRegistro=cmbVerRegistros.getValue();
                                                                        if(verRegistro=='')
                                                                        {
                                                                        	msgBox('Debe Seleccionar el tipo de registros que ver&aacute; el actor');
                                                                        	return;
                                                                        }
                                                                        ;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var spanDestino=gE('tblVer_'+idAc);
                                                                                if(spanDestino==null)
                                                                                	spanDestino=gE('tblEtapas_'+idAc);
                                                                                var vRegistros= cmbVerRegistros.getRawValue();
                                                                                var cadSpan=vRegistros;
                                                                                gE('btnModificar_'+idAc).innerHTML='<a href="javascript:configurarVerRegistros('+idAc+','+cmbVerRegistros.getValue()+',1)"><img src="../images/formularios/pencil.png" title="Cambiar tipo de registros visto por actor" alt="Cambiar tipo de registros visto por actor"></a>';
                                                                                
                                                                                spanDestino.innerHTML=cadSpan;
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=61&tAccion='+tAccion+'&idAccion='+idAc+'&verRegistro='+verRegistro,true);
                                                                        
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();                                
}

function condicionadoCambio(cmb,idAc,et)
{
	if(cmb.options[cmb.selectedIndex].value=='0')
    {
    	function resp(btn)
        {
        	if(btn=='yes')
            {
                function funcAjax()
                {
                    var resp=peticion_http.responseText;
                    arrResp=resp.split('|');
                    if(arrResp[0]=='1')
                    {
                        var fila=gE('filaTexto_'+idAc);
                        if(fila!=null)
	                        fila.parentNode.removeChild(fila);
                       
                        fila=gE('filaTablaDictamen_'+idAc);
	                  	if(fila!=null)
                        	fila.parentNode.removeChild(fila);
                    }
                    else
                    {
                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=62&idAccion='+idAc,true);
           }
           else
           	{
            	cmb.selectedIndex=1;
            }
        }
        msgConfirm('¿Est&aacute; seguro de querer remover las dependencias de dictamen?',resp);
    }
    else
    {
    	var gridActores=crearGridActores();
    	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione los actores de los cuales depender&aacute; la realizaci&oacute;n del dictamen final: '
                                                        },
                                                        gridActores
                                                        

													]
										}
									);
	
        var ventanaAM = new Ext.Window(
                                        {
                                            title: 'Configuraci&oacute;n dictamen final',
                                            width: 690,
                                            height:450,
                                            layout: 'fit',
                                            plain:true,
                                            modal:true,
                                            bodyStyle:'padding:5px;',
                                            buttonAlign:'center',
                                            items: form,
                                            listeners : {
                                                        show : {
                                                                    buffer : 10,
                                                                    fn : function() 
                                                                    {
                                                                    }
                                                                }
                                                    },
                                            buttons:	[
                                                            {
                                                                id:'btnAceptar',
                                                                text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                                handler: function()
                                                                        {
                                                                            var filas=gridActores.getSelectionModel().getSelections();
                                                                            var x;
                                                                            
                                                                            if(filas.length==0)
                                                                            {
                                                                            	msgBox('Debe seleccionar al menos un actor que condicionar&aacute; el proceso de dictamen final')
                                                                                return;
                                                                            }
                                                                            var arrActores='';
                                                                            for(x=0;x<filas.length;x++)
                                                                            {
                                                                            	if(arrActores=='')
                                                                                	arrActores=filas[x].get('idActor');
                                                                                else
                                                                                	arrActores+=','+filas[x].get('idActor');
                                                                            }
                                                                            
                                                                            
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	ventanaAM.close();
                                                                                	recargarTabEscenario();
                                                                                    
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=64&actores='+arrActores+'&idAccion='+idAc,true);
                                                                            
                                                                            
                                                                            
                                                                        }
                                                            },
                                                            {
                                                                text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                                handler:function()
                                                                        {
                                                                        	selElemCombo(cmb,'0');
                                                                            ventanaAM.close();
                                                                        }
                                                            }
                                                        ]
                                        }
                                    );
                                    
		llenarDatosGridActores(ventanaAM,gridActores.getStore(),idAc,et);                                   
        
    
    
    }
}

function crearGridActores()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idActor'},
                                                                {name: 'actor'},
                                                                {name: 'tipo'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														chkRow,
														{
															header:'Actor',
															width:270,
															sortable:true,
															dataIndex:'actor'
														},
														{
															header:'Tipo',
															width:230,
															sortable:true,
															dataIndex:'tipo',
                                                            renderer:renderTipoUsuario
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:50,
                                                            stripeRows :false,
                                                            columnLines : false,
                                                            cls:'gridSiugjPrincipal',
                                                            cm: cModelo,
                                                            height:300,
                                                            width:650,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function llenarDatosGridActores(ventana,almacen,idActor,et)
{
	var idProceso=gE('idProceso').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            almacen.loadData(arrDatos);
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=63&idActor='+idActor+'&numEtapa='+et+'&idProceso='+idProceso,true);
}

function removerDependencia(idAccion,idAccionD)
{
	function resp(btn)
    {
    	if(btn=='yes')
        {
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    recargarTabEscenario();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=65&idAccion='+idAccion+'&idAccionR='+idAccionD,true);
		}
    }
    msgConfirm('¿Est&aacute; seguro de querer remover este actor como condici&oacute;n de dictamen final?',resp);            
}

function agregarDependenciaDictamen(idAc,et)
{
	var cmbDependencia=gE('cmbCondicionado_'+idAc);
    condicionadoCambio(cmbDependencia,idAc,et);
    
}

function asociarAutomaticamente(ctrl)
{
	var valor=ctrl.options[ctrl.selectedIndex].value;
    var idActor=ctrl.id.split('_')[1];
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            if(ctrl.selectedIndex==1)
            	ctrl.selectedIndex=0;
            else
            	ctrl.selectedIndex=1;   
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=187&valor='+valor+'&idActor='+idActor,true);
    
}

function configurarDisparador(iP,e)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=true;
    obj.url='../modeloPerfiles/configurarDisparadores.php';
    obj.params=[['idProceso',iP],['numEtapa',e],['cPagina','sFrm=true']];
        
	window.parent.abrirVentanaFancy(obj);
}










function recargarTabEscenario()
{
	window.parent.posEscenarioActual=window.scrollY ;
	recargarPagina();
}

function configurarModuloFirmaCertificacion(iA,e,cConf)
{

	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Etiqueta: '
                                                        },
                                                        {
                                                        	x:130,
                                                            y:10,
                                                            width:350,
                                                            cls:'controlSIUGJ',
                                                            xtype:'textfield',
                                                        	id:'txtEtiqueta'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:55,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Acción a ejecutar una vez firmado/certificado el proceso:'
                                                        },
                                                        {
                                                        	x:500,
                                                            y:50,
                                                            html:'<div id="cmbAccionEjecutar"></div>'
                                                        }
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:95,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Visualizar bot&oacute;n de firma:'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:90,
                                                            html:'<div id="cmbVisualizaBoton"></div>'
                                                        },
                                                        crearGridAccionFirma()
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configurar m&oacute;dulo de certificaci&oacute;n firma',
										width: 880,
										height:520,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtEtiqueta').focus(false,500);
                                                                    
                                                                    
                                                                    var cmbAccionCertificado=crearComboExt('cmbAccionCertificado',arrAccionesConsecuentes,0,0,340,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'cmbAccionEjecutar'});
    																cmbAccionCertificado.setValue('0');
																	
                                                                    var cmbVisualizarBoton=crearComboExt('cmbVisualizarBoton',arrSiNo,0,0,140,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'cmbVisualizaBoton'});
																    cmbVisualizarBoton.setValue('1');
                                                                    
                                                                    
                                                                    if(cConf)
                                                                    {
                                                                        var cadConf='['+bD(cConf)+']';
                                                                        var oConf=eval(cadConf)[0];
                                                                        gEx('txtEtiqueta').setValue(oConf.etiqueta);
                                                                        gEx('cmbAccionCertificado').setValue(oConf.accionEjecucion);
                                                                        
                                                                        gEx('cmbVisualizarBoton').setValue(oConf.visualizarBoton);
                                                                        var arrDatos=[];
                                                                        var x;
                                                                        var pos;
                                                                        for(x=0;x<arrAccionesFirma.length;x++)
                                                                        {
                                                                            etiqueta=arrAccionesFirma[x][1];
                                                                            etapaEnvio='0';
                                                                            documentoFinal='0';
                                                                            pos=existeValorArregloObjetos(oConf.arrAcciones,'idAccion',arrAccionesFirma[x][0]);    
                                                                            if(pos!=-1)
                                                                            {
                                                                                etiqueta=oConf.arrAcciones[pos].etiquetaAccion;
                                                                                etapaEnvio=oConf.arrAcciones[pos].etapaEnvio;
                                                                                documentoFinal=oConf.arrAcciones[pos].documentoFinal;
                                                                                
                                                                            }
                                                                            
                                                                            arrDatos.push([arrAccionesFirma[x][0],etiqueta,etapaEnvio,documentoFinal]);        
                                                                        }
                                                                        
                                                                        
                                                                      
                                                                        
                                                                        gEx('gAccionesFirma').getStore().loadData(arrDatos);
                                                                        
                                                                        
                                                                    }




                                                                }
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',  
                                                            cls:'btnSIUGJ',
                                                            width:140,                                                          
															handler: function()
																	{
																		var txtEtiqueta=gEx('txtEtiqueta');
                                                                        if(txtEtiqueta.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtEtiqueta.fcus();
                                                                            }
                                                                            msgBox('Debe ingresar la etiqueta del m&oacute;dulo',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var arrAcciones='';
                                                                        var fila;
                                                                        var x=0;
                                                                        var oAccion='';
                                                                        var gAccionesFirma=gEx('gAccionesFirma');
                                                                        for(x=0;x<gAccionesFirma.getStore().getCount();x++)
                                                                        {
                                                                        	
                                                                        	fila=gAccionesFirma.getStore().getAt(x);
                                                                            
                                                                            if(fila.data.etiquetaAccion=='')
                                                                            	fila.data.etiquetaAccion=formatearValorRenderer(arrAccionesFirma,fila[0]);
                                                                            
                                                                            oAccion='{"idAccion":"'+fila.data.accion+'","etiquetaAccion":"'+cv(fila.data.etiquetaAccion)+
                                                                            			'","etapaEnvio":"'+fila.data.etapaCambio+'","documentoFinal":"'+fila.data.documentoFinal+'"}';
                                                                            if(arrAcciones=='')
                                                                            	arrAcciones=oAccion;
                                                                            else
                                                                            	arrAcciones+=','+oAccion;    
                                                                        }
                                                                        
                                                                        var cadObj='{"visualizarBoton":"'+gEx('cmbVisualizarBoton').getValue()+'","etiqueta":"'+cv(txtEtiqueta.getValue())+'","accionEjecucion":"'+gEx('cmbAccionCertificado').getValue()+
                                                                        			'","funcionModuloFirma":"","urlModuloCertificacion":"","arrAcciones":['+arrAcciones+']}';
                                                                       
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	
                                                                            	ventanaAM.close();
                                                                                recargarPagina();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=52&idAccion='+iA+'&numEtapa=NULL&objComp='+(cadObj),true);
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
    
    
    
}


function crearGridAccionFirma()
{
	var cmbEnvioEtapa=crearComboExt('cmbEnvioEtapa',arrEtapasNumero,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	var cmbDocumentoFinal=crearComboExt('cmbDocumentoFinal',arrSiNo,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
    var dsDatos=[];
    var x;
    for(x=0;x<arrAccionesFirma.length;x++)
    {
    	dsDatos.push([arrAccionesFirma[x][0],arrAccionesFirma[x][1],'0','0']);
    }
    
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'accion'},
                                                                    {name: 'etiquetaAccion'},
                                                                    {name: 'etapaCambio'},
                                                                    {name: 'documentoFinal'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														{
															header:'Acci&oacute;n',
															width:190,
                                                            hidden:true,
															sortable:true,
															dataIndex:'accion',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrAccionesFirma,val);
                                                                    }
														},
                                                        {
															header:'Acci&oacute;n',
															width:250,
															sortable:true,
															dataIndex:'etiquetaAccion',
                                                            renderer:mostrarValorDescripcion,
                                                            editor:{xtype:'textfield',cls:'controlSIUGJ'}
														},
														{
															header:'Enviar a etapa',
															width:350,
															sortable:true,
															dataIndex:'etapaCambio',
                                                            editor:cmbEnvioEtapa,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasNumero,val);
                                                                    }
														},
                                                        {
															header:'Es documento final',
															width:195,
															sortable:true,
															dataIndex:'documentoFinal',
                                                            editor:cmbDocumentoFinal,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrSiNo,val);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gAccionesFirma',
                                                            store:alDatos,
                                                            frame:false,
                                                            clicksToEdit:1,
                                                            x:10,
                                                            y:140,
                                                            title:'Configuraci&oacute;n de acciones',
                                                            cls:'gridSiugjPrincipal',
                                                            cm: cModelo,
                                                            loadMask:true,
                                                            stripeRows :false,
                                                            columnLines : false,
                                                            height:250
                                                            
                                                            
                                                        }
                                                    );
	                  
                                                    
	return 	tblGrid;
}


function configurarSubidaDocumento(iA,nE,obj)
{
	var objConf={};
    if(obj!='')
    {
    	objConf=eval('['+bD(obj)+']')[0];
        
    }
    
	var arrUnidad=[['KB','KB'],['MB','MB'],['GB','GB']];
	
    
	
    
    
    
    
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Categor&iacute;a de documento a subir:'
                                                        },
                                                        {
                                                        	x:320,
                                                            y:10,
                                                            html:'<div id="divComboCategoriaDocumento"></div>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:65,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Extensiones permitidas:'
                                                        },
                                                        {
                                                        	x:280,
                                                            y:60,
                                                            id:'txtExtensiones',
                                                            width:300,
                                                            cls:'controlSIUGJ',
                                                            value:objConf.extensionesPermitidas?decodeURI(objConf.extensionesPermitidas):'',
                                                            xtype:'textfield'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tama&ntilde;o m&aacute;ximo permitido:'
                                                        },
                                                        {
                                                        	x:280,
                                                            y:115,
                                                            id:'txtTamano',
                                                            width:70,
                                                            cls:'controlSIUGJ',
                                                            value:objConf.tamanoMaximo?objConf.tamanoMaximo:'',
                                                            xtype:'numberfield',
                                                            allowNegative:false
                                                        },
                                                        {
                                                        	x:360,
                                                            y:110,
                                                            html:'<div id="divComboTamano"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:170,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Asociar documento con expediente?:'
                                                        },
                                                        {
                                                        	x:340,
                                                            y:165,
                                                            html:'<div id="divComboDocumento"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:220,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'No. Documentos Obligatorios:'
                                                        },
                                                        {
                                                        	x:280,
                                                            y:215,
                                                            width:40,
                                                            cls:'controlSIUGJ',
                                                            xtype:'numberfield',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            id:'txtNoObligatorios',
                                                            value:objConf.noDocumentosObligatorios?objConf.noDocumentosObligatorios:0
                                                        }
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n documento de subida',
										width: 780,
										height:380,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
                                        cls:'msgHistorialSIUGJ',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrTiposDocumentos,0,0,420,{multiSelect:true,ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboCategoriaDocumento'});
                                                                    cmbTipoDocumento.setValue('0');
                                                                    if(objConf.categoriaDocumento)
                                                                    {
                                                                        cmbTipoDocumento.setValue(objConf.categoriaDocumento);
                                                                    }
                                                                    
                                                                    
                                                                    var cmbUnidad=crearComboExt('cmbUnidad',arrUnidad,0,0,140,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTamano'});
																    cmbUnidad.setValue('MB');
                                                                    
                                                                    var cmbSiNoExpediente=crearComboExt('cmbSiNoExpediente',arrSiNo,0,0,140,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboDocumento'});
                                                                    cmbSiNoExpediente.setValue('1');
                                                                    if(objConf.asociarDocumentoExpediente)
                                                                    {
                                                                        cmbSiNoExpediente.setValue(objConf.asociarDocumentoExpediente);
                                                                    }
                                                                    
                                                                    if(objConf.unidadTamano)
                                                                    {
                                                                        cmbUnidad.setValue(objConf.unidadTamano);
                                                                    }
                                                                    
                                                                    
                                                                    
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var cmbTipoDocumento=gEx('cmbTipoDocumento');
                                                                        var cmbSiNoExpediente=gEx('cmbSiNoExpediente');
																		var cadObj='{"categoriaDocumento":"'+cmbTipoDocumento.getValue()+
                                                                        			'","extensionesPermitidas":"'+cv(gEx('txtExtensiones').getValue(),false,true)+
                                                                                    '","tamanoMaximo":"'+gEx('txtTamano').getValue()+
                                                                                    '","unidadTamano":"'+gEx('cmbUnidad').getValue()+'","asociarDocumentoExpediente":"'+
                                                                                    cmbSiNoExpediente.getValue()+'","noDocumentosObligatorios":"'+
                                                                                    (gEx('txtNoObligatorios').getValue()==''?0:gEx('txtNoObligatorios').getValue())+'"}';
																	
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	
                                                                                gE('btn_'+(iA)).innerHTML="<a href='javascript:configurarSubidaDocumento("+iA+","+nE+",\""+bE(cadObj)+"\")'><img src='../images/pencil.png' title='Configurar documentos de subida'  alt='Configurar documentos de subida'></a></span>";
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=52&idAccion='+(iA)+'&numEtapa='+(nE)+'&objComp='+cadObj,true);
                                                                    
                                                                    }
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
}


function removerFuncionControlEscenario(tipo)
{
	var control='';
    switch(tipo)
    {
    	case 1:
	    	control=gEx('txtFuncionAplicacionDictamenFinal');
    	break;
       case 2:
	    	control=gEx('txtFuncionVisualizacionDictamenFinal');
    	break;
        case 3:
	    	control=gEx('txtFuncionAplicacionArranqueScript');
    	break;
    }
    control.idConsulta='';
    control.setValue('');
}

function agregarFuncionControlEscenario(tipo)
{

	var control='';
	switch(tipo)
    {
    	case 1:
	    	control=gEx('txtFuncionAplicacionDictamenFinal');
    	break;
        case 2:
	    	control=gEx('txtFuncionVisualizacionDictamenFinal');
    	break;
        case 3:
	    	control=gEx('txtFuncionAplicacionArranqueScript');
    	break;
        
       
    }
    
    
    
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	control.idConsulta=idConsulta;
                                                control.setValue(nombre);
                                                
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }
    window.parent.mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                            	control.idConsulta=filaSelec.data.idConsulta;
                                control.setValue(filaSelec.data.nombreConsulta);
                                
                                
                                ventana.close();
                            }
    						,true);
    
}



function configurarArranqueProceso(iP,et,lblEtapa)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridAdministracionProcesosArranque(iP,et)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Arranque de Procesos, Etapa:&nbsp;'+bD(lblEtapa),
										width: 950,
										height:480,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
                                                        show : {
                                                                    buffer : 10,
                                                                    fn : function() 
                                                                    {
                                                                    }
                                                                }
                                                    },
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler: function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	

}


function crearGridAdministracionProcesosArranque(iP,nE)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'nombreProceso'},
		                                                {name:'etapaIngreso'},
                                                        {name: 'idProcesoDestino'},
                                                        {name:'lblEtapaIngreso'},
                                                        {name: 'funcionAplicacion'},
                                                        {name: 'lblFuncionAplicacion'},
                                                        {name: 'mostrarVentanaProceso'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesProyectos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreProceso', direction: 'ASC'},
                                                            groupField: 'nombreProceso',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='355';
                                        proxy.baseParams.iP=iP;
                                        proxy.baseParams.nE=nE;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            {
                                                                header:'Proceso',
                                                                width:350,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'nombreProceso'
                                                            },
                                                            {
                                                                header:'Etapa de Ingreso',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'lblEtapaIngreso'
                                                            },
                                                            {
                                                                header:'Aperturar Ventana de Proceso',
                                                                width:300,
                                                                align:'center',
                                                                sortable:true,
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSiNo,val);
                                                                        },
                                                                dataIndex:'mostrarVentanaProceso'
                                                            },
                                                            {
                                                                header:'Funci&oacute;n de Aplicaci&oacute;n',
                                                                width:400,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'lblFuncionAplicacion'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gProcesosArranque',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                cls:'gridSiugjPrincipal',
                                                                stripeRows :false,
                                                                columnLines : false,
                                                                loadMask:true,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar Arranque de Proceso',
                                                                                handler:function()
                                                                                        {
                                                                                         	mostrarVentanaConfiguracionArranqueProceso(iP,nE)	   
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar Arranque de Proceso',
                                                                                handler:function()
                                                                                        {
                                                                                         	var fila=gEx('gProcesosArranque').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el proceso cuyo arranque desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            mostrarVentanaConfiguracionArranqueProceso(iP,nE,fila);   
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover Arranque de Proceso',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gProcesosArranque').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el proceso cuyo arranque desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                         	gEx('gProcesosArranque').getStore().remove(fila);   
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=356&iR='+fila.data.idRegistro,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('¿Est&aacute; seguro de querer remover el arranque del proceso seleccionado?',resp);
                                                                                            
                                                                                            
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                        ],
     
                                                                columnLines : true,                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}


function mostrarVentanaConfiguracionArranqueProceso(iP,nE,filaProceso)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Nombre del proceso:'
                                                        },
                                                        {
                                                        	x:210,
                                                            y:5,
                                                            html:'<div id="divCmbProceso"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:55,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Iniciar en etapa:'
                                                        },
                                                        {
                                                        	x:210,
                                                            y:50,
                                                            html:'<div id="divCmbEtapaInicio"></div>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Aperturar venta de proceso?:'
                                                        },
                                                        {
                                                        	x:280,
                                                            y:95,
                                                            html:'<div id="divCmbVentaProceso"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:145,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n de aplicaci&oacute;n:'
                                                        },
                                                        {
                                                            xtype:'textfield',
                                                            id:'txtFuncionAplicacion',
                                                            x:230,
                                                            y:140,
                                                            cls:'controlSIUGJ',
                                                            readOnly:true,
                                                            width:600
                                                        },
                                                        {
                                                            x:840,
                                                            y:142,
                                                            html:'<a href="javascript:abrirVentanaFuncion(1)"><img src="../images/pencil.png" /></a>&nbsp;&nbsp;&nbsp;<a href="javascript:removerFuncion(1)"><img src="../images/cross.png" /></a>'
                                                        },
                                                        crearGridCamposProcesoArranque(iP,nE,filaProceso?filaProceso.data.idRegistro:-1)
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Arranque de Proceso',
										width: 980,
										height:540,
										layout: 'fit',
										plain:true,
                                        cls:'msgHistorialSIUGJ',
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbProcesos=crearComboExt('cmbProcesos',arrProcesosActivos,0,0,650,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbProceso'});
                                                                	cmbProcesos.on('select',function(cmb,registro)
                                                                                            {
                                                                                                gEx('cmbEtapaInicioProceso').setValue('');
                                                                                                gEx('cmbEtapaInicioProceso').getStore().loadData(registro.data.valorComp);
                                                                                                recargarGridCamposArrancaProceso()
                                                                                            }
                                                                                )    
                                                                                
                                                                    var cmbEtapaInicioProceso=crearComboExt('cmbEtapaInicioProceso',[],0,0,450,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbEtapaInicio'});             
                                                                    var cmbAperturarVentana=crearComboExt('cmbAperturarVentana',arrSiNo,0,0,140,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbVentaProceso'});
																	cmbAperturarVentana.setValue('0');
                                                                
                                                                	gEx('txtFuncionAplicacion').idFuncion=-1;
                                                                    if(filaProceso)
                                                                    {
                                                                        
                                                                        cmbProcesos.setValue(filaProceso.data.idProcesoDestino);
                                                                        dispararEventoSelectCombo('cmbProcesos');
                                                                        gEx('cmbEtapaInicioProceso').setValue(parseFloat(filaProceso.data.etapaIngreso));
                                                                        cmbAperturarVentana.setValue(filaProceso.data.mostrarVentanaProceso);
                                                                        gEx('txtFuncionAplicacion').idFuncion=filaProceso.data.funcionAplicacion==''?-1:filaProceso.data.funcionAplicacion;
                                                                    	gEx('txtFuncionAplicacion').setValue(filaProceso.data.lblFuncionAplicacion);
                                                                    }  
                                                                }
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>', 
                                                            cls:'btnSIUGJ',
                                                            width:140,                                                           
															handler: function()
																	{
                                                                    	var cmbProcesos=gEx('cmbProcesos');	
                                                                        if(cmbProcesos.getValue()=='')
                                                                        {
                                                                        	function respAux()
                                                                            {
                                                                            	cmbProcesos.focus();
                                                                            }
                                                                            msgBox('Debe indicar el nombre del proceso a arrancar',respAux);
                                                                        	return;
                                                                        }
                                                                        var cmbEtapaInicioProceso=gEx('cmbEtapaInicioProceso');	
                                                                        if(cmbEtapaInicioProceso.getValue()=='')
                                                                        {
                                                                        	function respAux()
                                                                            {
                                                                            	cmbEtapaInicioProceso.focus();
                                                                            }
                                                                            msgBox('Debe indicar la etapa en la cual arrancar&aacute; el proceso',respAux);
                                                                        	return;
                                                                        }
                                                                    	var cmbAperturarVentana=gEx('cmbAperturarVentana');
                                                                    	var gCamposTablero=gEx('gCamposTablero');
                                                                        var x;
																		var fila;
                                                                        var aRegistros='';
                                                                        for(x=0;x<gCamposTablero.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gCamposTablero.getStore().getAt(x);
                                                                            
                                                                            if(fila.data.tipoLlenado=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	gCamposTablero.startEditing(x,3);
                                                                                }
                                                                                msgBox('Debe indicar el tipo de llenado del campo',resp)
                                                                            	return;
                                                                            }
                                                                            
                                                                            if((fila.data.tipoLlenado!='0')&&(fila.data.valor==''))
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	if(fila.data.tipoLlenado!='7')
	                                                                                	gCamposTablero.startEditing(x,3);
                                                                                }
                                                                                msgBox('Debe indicar el valor a asignar al campo destino',resp2)
                                                                            	return;
                                                                            }
                                                                            
                                                                            obj='{"campoDestino":"'+fila.data.nombreCampo+'","tipoLlenado":"'+fila.data.tipoLlenado+'","valor":"'+cv(fila.data.valor)+'"}';
                                                                            
                                                                            if(aRegistros=='')
                                                                            {
                                                                            	aRegistros=obj;
                                                                            }
                                                                            else
                                                                            {
                                                                            	aRegistros+=','+obj;
                                                                            }
                                                                        }
                                                                        
                                                                        var cadObj='{"idProcesoOrigen":"'+bD(iP)+'","idProcesoDestino":"'+cmbProcesos.getValue()+'","numEtapaOrigen":"'+bD(nE)+
                                                                        			'","numEtapaDestino":"'+cmbEtapaInicioProceso.getValue()+'","funcionAplicacion":"'+
                                                                                    gEx('txtFuncionAplicacion').idFuncion+'","registros":['+aRegistros+
                                                                                    '],"aperturarVentanaProceso":"'+cmbAperturarVentana.getValue()+'","idRegistro":"'+
                                                                                    (filaProceso?filaProceso.data.idRegistro:-1)+'"}';
                                                                        

																	
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('gProcesosArranque').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=354&cadObj='+cadObj,true);
                                                                        
                                                                    
                                                                    }
														}
														
													]
									}
								);
	ventanaAM.show();
     	
}


function crearGridCamposProcesoArranque(iP,nE,iR)
{
	var cmbLlenado=crearComboExt('cmbLlenado',tiposLlenado,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
  
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'nombreCampo'},
                                                        {name:'tipoDato'},
		                                                {name: 'tipoLlenado'},
                                                        {name: 'etiquetaValor'},
		                                                {name:'valor'},
                                                        {name: 'esCampoDefault'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesProyectos.php'

                                                                                              }

                                                                                          ),
                                                            
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='353';
                                        proxy.baseParams.idProcesOrigen=iP;
                                        proxy.baseParams.numEtapa=nE;
                                        proxy.baseParams.idRegistro=bE(iR);
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        {
                                                            header:'Campo de Formulario',
                                                            width:250,
                                                            sortable:true,
                                                            dataIndex:'nombreCampo',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var color='000';
                                                                        if(registro.data.esCampoDefault=='1')
                                                                        {
                                                                        	color='900';
                                                                        }
                                                                    	return '<span style="color:#'+color+'">'+mostrarValorDescripcion(val)+'</span>';
                                                                    }
                                                        },
                                                        {
                                                            header:'Tipo de dato',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'tipoDato'
                                                        },
                                                        {
                                                            header:'Tipo de llenado',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'tipoLlenado',
                                                            editor:cmbLlenado,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(tiposLlenado,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Valor',
                                                            width:300,
                                                            sortable:true,
                                                            editor:{xtype:'textfield'},
                                                            dataIndex:'valor',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var comp='';
                                                                        switch(registro.data.tipoLlenado)
                                                                        {
                                                                        	case '4':
                                                                            	comp='<a href=\'javascript:mostrarVentanaAlmacenDatosTableroControl("'+bE(registro.data.nombreCampo)+'")\'><img src="../images/pencil.png" width="14" height="14" title="Modificar" alt="Modificar"></a> ';
                                                                            break;
                                                                            case '7':
                                                                            	comp='<a href=\'javascript:mostrarVentanaFuncionSistemaTableroControl("'+bE(registro.data.nombreCampo)+'")\'><img src="../images/pencil.png" width="14" height="14" title="Modificar" alt="Modificar"></a> ';
                                                                            break;
                                                                        }
                                                                    	return comp+mostrarValorDescripcion(registro.data.etiquetaValor);
                                                                    }
                                                        }
                                                    ]
                                                );
                                                    
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gCamposTablero',
                                                            store:alDatos,
                                                            x:10,
                                                            y:175,
                                                            cls:'gridSiugjPrincipal',
                                                            frame:false,
                                                            height:230,
                                                           	border:true,
                                                            cm: cModelo,
                                                            clicksToEdit:1,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false, 
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false
                                                                                            })
                                                        }
                                                    );
                                                    
                                                    
    tblGrid.on('beforeedit',function(e)
    						{
                            	
                                
                                
                                if((e.field=='valor'))
                                {
                                	
                                	if(e.record.data.tipoLlenado=='0')
                                    {
                                    	e.cancel=true;
                                        return;
                                    }
                                
                                	var control=new Ext.form.TextField({id:'ctrlValor',cls:'controlSIUGJ'});
                                    
									switch(e.record.data.tipoLlenado)
                                    {
                                    	case '1': //Valor de sesión
                                        	control=crearComboExt('ctrlValor',arrValorSesionGlobal,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        case '2': //Valor de sistema
                                        	control=crearComboExt('ctrlValor',arrValorSistemaGlobal,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        /*case '3': //Consulta auxiliar
                                        	var arrAlmacenDatos=obtenerAlmacenesDatosDisponibles(2);
                                            control=crearComboExt('ctrlValor',arrAlmacenDatos,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        case '4': //Almacen de datos
                                        	
                                        break;
                                        case '5': //Valor de parámetro
                                        	control=crearComboExt('ctrlValor',arrParametrosGenerales,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;*/
                                        case '6':  //Valor de formulario base
                                        	control=crearComboExt('ctrlValor',arrCamposFormularioBaseOrigen,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
                                        break;
                                        case '7':  //Función de sistema
                                        	
                                        break;
                                        case '8':  //Valor manual
                                        	control=new Ext.form.TextField({id:'ctrlValor',cls:'controlSIUGJ'});
                                        break;
                                        
                                    }
                                    
                                    
                                    e.grid.getColumnModel().setEditor(3,control);
                                    
                                }
                                
                                
                                	
                                
                                
                            }
    			)
                
                
	tblGrid.on('afteredit',function(e)
    						{
                            	if(e.field=='tipoLlenado')
                                {
                                	e.record.set('valor','');
                                    e.record.set('etiquetaValor','');
                                }
                                
                                
                                if(e.field=='valor')
                                {
                                
                                	var control=gEx('ctrlValor');
                                	if(control)
                                    {
                                    	switch(e.record.data.tipoLlenado)
                                        {
                                            case '1': //Valor de sesión
                                               
                                            case '2': //Valor de sistema
                                               
                                            case '3': //Consulta auxiliar
                                            case '5': //Valor de parámetro    
                                            case '6':  //Valor de formulario base
                                            var etiquetaValor='';
                                            
                                            var pos=obtenerPosFila(control.getStore(),'id',e.record.data.valor);
                                            etiquetaValor=control.getStore().getAt(pos).data.nombre;
                                            e.record.set('etiquetaValor',etiquetaValor);
                                            
                                            break;
                                            case '4': //Almacen de datos
                                                
                                            break;
                                            case '7':  //Función de sistema
                                                
                                            break;
                                            case '8':  //Valor manual
                                                e.record.set('etiquetaValor',e.value);
                                            break;
                                            
                                        }
                                        
                                            
	                                	
                                    }
                                }
                                
                            }
    			)                
    
                                                    
    return 	tblGrid;	
}

function recargarGridCamposArrancaProceso()
{

	gEx('gCamposTablero').getStore().load	(
    											{
                                                	url:'../paginasFunciones/funcionesProyectos.php',
                                                    params:	{
                                                    			idProcesoDestino:bE(gEx('cmbProcesos').getValue())
                                        
                                                    		}
                                                                                                    
												}
    										);
}


function mostrarVentanaFuncionSistemaTableroControl(iCampo)
{
	
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	var pos=obtenerPosFila(gEx('gCamposTablero').getStore(),'nombreCampo',bD(iCampo));
                                                var fila=gEx('gCamposTablero').getStore().getAt(pos);
                                                fila.set('valor',idConsulta);
                                                fila.set('etiquetaValor',nombre);
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }
    mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                            	var pos=obtenerPosFila(gEx('gCamposTablero').getStore(),'nombreCampo',bD(iCampo));
                                var fila=gEx('gCamposTablero').getStore().getAt(pos);
                                fila.set('valor',filaSelec.data.idConsulta);
                                fila.set('etiquetaValor',filaSelec.data.nombreConsulta);
                                
                                ventana.close();
                            }
    						,true);
    
}

function configurarCambioEtapaProceso(iP,et,lblEtapa)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridAdministracionProcesosAsociado(iP,et)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cambiar de Etapa a Proceso Asociado (Administraci&oacute;n), Etapa:&nbsp;'+bD(lblEtapa),
										width: 920,
										height:400,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
                                                        show : {
                                                                    buffer : 10,
                                                                    fn : function() 
                                                                    {
                                                                    }
                                                                }
                                                    },
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler: function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	

}


function crearGridAdministracionProcesosAsociado(iP,nE)
{
	var cmbEditor=crearComboExt('cmbEditor',[],0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'nombreProceso'},
		                                                {name:'etapaCambio'},
                                                        {name: 'funcionAplicacion'},
                                                        {name: 'lblFuncionAplicacion'},
                                                        {name: 'relacionProceso'},
                                                        {name: 'etapasProceso'},
                                                        {name: 'valor'},
                                                        {name: 'idProcesoDestino'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesProyectos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreProceso', direction: 'ASC'},
                                                            groupField: 'relacionProceso',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='357';
                                        proxy.baseParams.iP=iP;
                                        proxy.baseParams.nE=nE;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:50}),
                                                            
                                                            {
                                                                header:'Proceso',
                                                                width:300,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'nombreProceso'
                                                            },
                                                            {
                                                                header:'Relaci&oacute;n Proceso',
                                                                width:170,
                                                                dataIndex:'relacionProceso',
                                                                sortable:true,
                                                                renderer:function(val)
                                                                		{
                                                                        	return val=='1'?'Proceso Derivado':'Proceso Padre';
                                                                        }
                                                                
                                                            },
                                                            {
                                                                header:'Cambiar a Etapa',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'etapaCambio',
                                                                editor:cmbEditor,
                                                                renderer:function (val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(registro.data.etapasProceso,val,1,true));	
                                                                        }
                                                            },
                                                            {
                                                                header:'Funci&oacute;n de Aplicaci&oacute;n',
                                                                width:290,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'lblFuncionAplicacion',
                                                                renderer:function(val,meta,registro,numFila)
                                                                		{
                                                                        	if(parseFloat(registro.data.etapaCambio)!=0)
	                                                                        	return '<a href="javascript:registrarFuncionAplicacionCambioEtapa(\''+bE(numFila)+'\',\''+bE(registro.data.idRegistro)+'\')"><img height="14" width="14" src="../images/pencil.png" title="Agregar Funci&oacute;n de Aplicaci&oacute;n"></a>'+
                                                                                		'&nbsp;<a href="javascript:removerFuncionAplicacionCambioEtapa(\''+bE(numFila)+'\',\''+bE(registro.data.idRegistro)+'\')"><img height="14" width="14"  src="../images/cross.png" title="Remover Funci&oacute;n de Aplicaci&oacute;n"></a>&nbsp;&nbsp;'+mostrarValorDescripcion(val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gProcesosCambioEtapa',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cls:'gridSiugjPrincipal',
                                                                cm: cModelo,
                                                                clicksToEdit:1,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );


		tblGrid.on('beforeedit',function(e)
        						{
                                	gEx('cmbEditor').getStore().loadData(e.record.data.etapasProceso);
                                }
        			)
	
    	tblGrid.on('afteredit',function(e)
        						{
                                	function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            gEx('gProcesosCambioEtapa').getStore().reload();
                                        }
                                        else
                                        {
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=358&tR='+bE(e.record.data.relacionProceso)+'&iP='+iP+'&nE='+nE+'&iPD='+bE(e.record.data.idProcesoDestino)+'&v='+bE(e.value),true);
                                    
                                }
        			)
    
        return 	tblGrid;
}

function abrirVentanaFuncion(tipo)
{
	mostrarVentanaExpresion(	function(fila,ventana)
    							{
                                	if(tipo==1)
                                    {
                                        gEx('txtFuncionAplicacion').setValue(fila.get('nombreConsulta'));
                                        gEx('txtFuncionAplicacion').idFuncion=fila.get('idConsulta');
                                    }
                                    else
                                    {
                                        //gEx('txtFuncionVisualizacion').setValue(fila.get('nombreConsulta'));
                                        //gEx('txtFuncionVisualizacion').idFuncion=fila.get('idConsulta');
                                    }
                                    ventana.close();
                            	}
    							,true
                          );
}

function removerFuncion(tipo)
{
	if(tipo==1)
    {
        gEx('txtFuncionAplicacion').setValue('');
        gEx('txtFuncionAplicacion').idFuncion=-1;
    }
    else
    {
        //gEx('txtFuncionVisualizacion').setValue('');
        //gEx('txtFuncionVisualizacion').idFuncion=-1;
    }
}


function registrarFuncionAplicacionCambioEtapa(numFila,iR)
{


	asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                            	function funcAjax()
                                                {
                                                    var resp=peticion_http.responseText;
                                                    arrResp=resp.split('|');
                                                    if(arrResp[0]=='1')
                                                    {
                                                        var pos=parseInt(bD(numFila));
                                                        var fila=gEx('gProcesosCambioEtapa').getStore().getAt(pos);
                                                        fila.set('valor',idConsulta);
                                                        fila.set('lblFuncionAplicacion',nombre);
                                                        if(gEx('vAgregarExp'))
                                                            gEx('vAgregarExp').close();
                                                    }
                                                    else
                                                    {
                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                    }
                                                }
                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=359&iR='+iR+'&iF='+bE(idConsulta),true);

                                            
                                            
                                             	
                                            }
    mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                            	
                                function funcAjax()
                                {
                                	 var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        var pos=parseInt(bD(numFila));
                                        var fila=gEx('gProcesosCambioEtapa').getStore().getAt(pos);
                                        fila.set('valor',filaSelec.data.idConsulta);
                                        fila.set('lblFuncionAplicacion',filaSelec.data.nombreConsulta);                                
                                        ventana.close();
                                    }
                                    else
                                    {
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=359&iR='+iR+'&iF='+bE(filaSelec.data.idConsulta),true);
                            }
    						,true);
    
}

function removerFuncionAplicacionCambioEtapa(numFila,iR)
{
	var pos=parseInt(bD(numFila));
	var fila=gEx('gProcesosCambioEtapa').getStore().getAt(pos);
    fila.set('valor','');
	fila.set('lblFuncionAplicacion','');
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var pos=parseInt(bD(numFila));
            var fila=gEx('gProcesosCambioEtapa').getStore().getAt(pos);
            fila.set('valor',filaSelec.data.idConsulta);
            fila.set('lblFuncionAplicacion',filaSelec.data.nombreConsulta);                                
            ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=359&iR='+iR+'&iF=',true);

}

function dispararScript(iP,et,lblEtapa,objVal)
{	
	var oVal=eval(bD(objVal));
	var oReg=null;
    
    if(oVal.length>0)
    {
    	oReg=oVal[0];
    }
    
	
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'URL de Script a Ejecutar:'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:10,
                                                            xtype:'textfield',
                                                            width:550,
                                                            cls:'controlSIUGJ',
                                                            id:'txtURLScript',
                                                            value:oReg?oReg.urlScript:''
                                                        },
                                                        {
                                                        	x:10,
                                                            y:65,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Imprimir al ejecutar el Script?:'
                                                        },
                                                        {
                                                        	x:290,
                                                            y:55,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'<div id="cmbComboImprimir"></div>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:115,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n de Aplicaci&oacute;n:'
                                                        },
                                                        {
                                                          xtype:'textfield',
                                                          width:490,
                                                          x:250,
                                                          y:110,
                                                          cls:'controlSIUGJ',
                                                          id:'txtFuncionAplicacionArranqueScript',
                                                          readOnly:true,
                                                          value:oReg?oReg.lblFuncionAplicacion:''
                                                      },
                                                      {
                                                          xtype:'label',
                                                          x:760,
                                                          y:112,
                                                          html:'<a href="javascript:agregarFuncionControlEscenario(3)"><img src="../images/pencil.png"></a>&nbsp;&nbsp;<a href="javascript:removerFuncionControlEscenario(3)"><img src="../images/cross.png"></a>'
                                                      }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Disparar Script, Etapa: '+bD(lblEtapa),
										width: 850,
										height:280,
										layout: 'fit',
										plain:true,
                                        cls:'msgHistorialSIUGJ',
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbImprimir=crearComboExt('cmbImprimir',arrSiNo,0,0,140,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'cmbComboImprimir'});
                                                                    cmbImprimir.setValue('0');
                                                                    if(oReg)
                                                                    {
                                                                        cmbImprimir.setValue(oReg.imprimirScript);
                                                                    }
                                                                    
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var txtURLScript=gEx('txtURLScript');
                                                                        var cmbImprimir=gEx('cmbImprimir');
                                                                        var txtFuncionAplicacionArranqueScript=gEx('txtFuncionAplicacionArranqueScript');
                                                                        
                                                                       
                                                                        if(cmbImprimir.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbImprimir.focus();
                                                                            }
                                                                            msgBox('Debe indicar si se imprimira una vez ejecutado el Script',resp2)
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"urlScript":"'+cv(txtURLScript.getValue())+'","imprimir":"'+cmbImprimir.getValue()+
                                                                        			'","funcionAplicacion":"'+(txtFuncionAplicacionArranqueScript.idConsulta?txtFuncionAplicacionArranqueScript.idConsulta:-1)+
                                                                                    '","idProceso":"'+bD(iP)+'","numEtapa":"'+bD(et)+'"}';
                                                                                    
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	var objBtn='[{"functionAplicacion":"'+txtFuncionAplicacionArranqueScript.idConsulta+'","imprimirScript":"'+cmbImprimir.getValue()+'","lblFuncionAplicacion":"'+cv(txtFuncionAplicacionArranqueScript.getValue())+'","urlScript":"'+txtURLScript.getValue()+'"}]';
                                                                                	gE('btnScriptEjecutar_'+bD(iP)+'_'+bD(et)).innerHTML= "<a href='javascript:dispararScript(\""+iP+"\",\""+et+"\",\""+lblEtapa+"\",\""+bE(objBtn)+"\")'><img width=\"21\" height=\"21\" src=\"../images/formularios/linkChain.png\" title='Disparar Script' alt='Disparar Script'/></a></td>";
                                                                                    
                                                                                    
                                                                                    
                                                                                	 ventanaAM.close();
                                                                                }
                                                                                msgBox('Se ha guardado satisfactoriamente la configuraci&oacute;n del Script',resp);
                                                                                return;
                                                                            	  
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=360&cadObj='+cadObj,true);
                                                                        
                                                                                    
                                                                                    
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
    
    
   	gEx('txtFuncionAplicacionArranqueScript').idConsulta=oReg?oReg.functionAplicacion:-1;
}