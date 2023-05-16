<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idProceso=base64_decode($_GET["proc"]);
	
	
	$consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta="select nombre,idTipoProceso,situacion from 4001_procesos where idProceso=".$idProceso;
	$fProceso=$con->obtenerPrimeraFila($consulta);
	$tProceso=$fProceso[1];
	
	$consulta="select numEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProceso;
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
			$columnas= "{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:210,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({  style: 'text-align:left'})}";
		else
			$columnas.=","."{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:210,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({  style: 'text-align:left'})}";
	$ancho+=210;	
	}	
	if($ancho==255)
		$ancho+=210;
	$columnasDP=$columnas;
	$columnasDR=uEJ($columnas);
	$columnas.=",{header:'Pasa a etapa:',width:330,dataIndex:'numEtapa',editor:cmbPasaEtapa,renderer:formatearEtapa}";	
	$columnasDP.=",{header:'Acci&oacute;n autor:',width:200,dataIndex:'accion',editor:cmbAccion,renderer:formatearAccion},{header:'Requiere respuesta:',width:130,dataIndex:'reqRespuesta',editor:cmbSiNo,renderer:formatearSiNo}";	
	$columnas=uEJ($columnas);
	$columnasDP=uEJ($columnasDP);
	
	$campos="{name:'valorOpt'}";
	$camposOpciones="valorOpt:''";
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
	
?>
var arrTiposDocumentos=<?php echo $arrTiposDocumentos?>;
var arrAccionesFirma=[['1','Firmar mediante FIEL'],['6','Firmar mediante FIREL'],['4','Firmar mediante documento'],['5','Autorizar documento'],['2','Rechazar firma'],['3','Solicitar ajustes']];
var arrEtapasNumero=<?php echo $arrEtapasNumero?>;
arrEtapasNumero.splice(0,0,['0','Ninguna']);
var arrAccionesConsecuentes=[['0','Continuar dentro del proceso'],['1','Cerra ventana de proceso']];

var arrEtapas=<?php echo $arrEtapas?>;
var arrAcciones=<?php echo $arrAcciones?>;
var arrNinguna=['0','Ninguna'];
arrEtapas.push(arrNinguna);
var arrAmbito=[['0','S\xF3lo Institucion/departamento'],['1','Instituci\xF3n/departamento y subdepartamentos']];
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
	var cadActores=gE('idActor').value+'|'+gE('tipoActor').value;
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=46&idProceso='+gE('idProceso').value+'&numEtapa='+et+'&cadActores='+cadActores+'&idPerfil='+gE('idPerfil').value,true);
	
}

function recargarTabEscenario()
{
	recargarPagina();
}


function crearGridActores()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'id'},
                                                                {name: 'actor'},
                                                                {name: 'tipo'} //1 rol; 2 comite
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Actor',
															width:200,
															sortable:true,
															dataIndex:'actor'
														},
                                                        {
                                                        	header:'Tipo actor',
															width:200,
															sortable:true,
															dataIndex:'tipo',
                                                            renderer:renderTipoUsuario
                                                        }
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridActores',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:490,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
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
                                                            y:10,
                                                            html:'Seleccione las acciones a agregar:'
                                                        },
                                                        gridAcciones
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar acci&oacute;n',
										width: 550,
										height:400,
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
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
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
	chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
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
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:500,
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

   msgConfirmWin('Est&aacute; seguro de querer remover a este actor?',resp,330,120);
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
    msgConfirmWin('Est&aacute; seguro de querer remover esta acci&oacute;n?',resp,330,120);       
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
    
    
    var cmbEtapas=crearComboExt('cmbEtapas',arrEtapas,80,35);
    cmbEtapas.setWidth(300);
    if(etAct !=undefined)
    	cmbEtapas.setValue(etAct);
    var etiqueta=gE('lblEtiqueta_'+idAccion).innerHTML.trim();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:lblEt
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Etapa:'
                                                        },
                                                        cmbEtapas,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Etiqueta:'
                                                        },
                                                        {
                                                        	x:80,
                                                            y:65,
                                                        	xtype:'textfield',
                                                            id:'txtEtiqueta',
                                                            width:200,
                                                            value:etiqueta
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Mensaje de confimaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:95,
                                                            xtype:'textarea',
                                                            id:'txtMensaje',
                                                            width:280,
                                                            height:80,
                                                            value:bD(gE('msgConf_'+idAccion).value)
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de etapa',
										width: 470,
										height:270,
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
                                                                        
                                                                        var obj='{"etiqueta":"'+cv(txtEtiqueta)+'","msgConf":"'+cv(txtMensaje)+'"}';
                                                                        
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
                                                                                    	cadSpan="<span class='corpo8'><font color='#000055'><b>"+lblEtRes+"</b></font><br><font color='green'><b> "+etapaPasa+"</b></font></span>&nbsp;&nbsp;<a href='javascript:modificarPasoEtapa("+idAccion+","+numEtapa+","+numEt+",12)'><img src='../images/pencil.png' title='Cambiar etapa' alt='Cambiar etapa'></a>";
                                                                                    break;
                                                                                	default:
	                                                                                	cadSpan="<span class='corpo8'><font color='#000055'><b>"+lblEtRes+"</b></font><font color='green'><b> "+etapaPasa+"</b></font></span>&nbsp;&nbsp;<a href='javascript:modificarPasoEtapa("+idAccion+","+numEtapa+","+numEt+")'><img src='../images/pencil.png' title='Cambiar etapa' alt='Cambiar etapa'></a>";
                                                                                }
                                                                                spanDestino.innerHTML=cadSpan;
                                                                                var lblEtiqueta=gE('lblEtiqueta_'+idAccion);
                                                                                lblEtiqueta.innerHTML=txtEtiqueta;
                                                                                gE('msgConf_'+idAccion).value=bE(txtMensaje);
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=52&idAccion='+idAccion+'&numEtapa='+numEt+'&objComp='+obj,true);
                                                                        
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
                                
	obtenerEtapasDisponibles(0,numEtapa,ventanaAM,cmbEtapas.getStore());                                

}

function obtenerEtapasDisponibles(idActor,et,ventana,almacen,ninguna,grupoElemento)
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
	            ventana.show();
            else
            	llenarOpcionesDictamen(idActor,grupoElemento,ventana);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=51&idProceso='+idProceso+'&numEtapa='+et,true);
}

function llenarOpcionesDictamen(idActor,idGrupoElemento,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrParam=eval(arrResp[1]);
            gEx('etiquetaAccion').setValue(arrResp[2]);
            gEx('cmAccionEnvio').setValue(arrResp[3]);
            gEx('cmbMostrarFormularioAsociado').setValue(arrResp[4]);
            Ext.getCmp('gridOpcionesManuales').getStore().loadData(arrParam);
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=54&idActor='+idActor+'&idElemento='+idGrupoElemento,true);


}

function modificarPasoEtapa(idAccion,numEtapa,etAct,gA)
{
	configurarSometeRevision(idAccion,numEtapa,etAct,gA)
}


function configurarDictamenFinal(iA,iAccion,e,idGrupoElemento)
{
	var cmAccionEnvio=crearComboExt('cmAccionEnvio',arrAccionesConsecuentes,235,355,210);
	cmAccionEnvio.setValue('0');
    
    
    var cmbMostrarFormularioAsociado=crearComboExt('cmbMostrarFormularioAsociado',arrSiNo,630,355,80);
    cmbMostrarFormularioAsociado.setValue('1');
    
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
	var cmbPasaEtapa=crearComboExt('cmbPasaEtapa',arrEtapas);
    var dsOpciones= [<?php echo "[".$filaDefault."]" ?>];
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
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Clave',
                                                            width:100,
                                                            dataIndex:'valorOpt',
                                                            editor: new Ext.form.TextField   (
                                                                                                    {
                                                                                                      
                                                                                                       style: 'text-align:left'
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
                                                            frame:true,
                                                            clicksToEdit: 1,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            columnLines:true,
                                                            width:<?php echo $ancho+35 ?>,
                                                            title:'Ingrese los posibles valores de dict&aacute;men:',
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
                                                                                        tblOpciones.startEditing(alOpciones.getCount()-1,1);
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
                                                                                       msgConfirmWin('Est&aacute; seguro de querer eliminar esta opci&oacute;n?',funcConfirmDel);
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
                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','La opci&oacute;n ingresada ya se encuentra registrada',funcOK);
            }
        }
    }
    tblOpciones.on('afteredit',funcEdicion);
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:40,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
   
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Etiqueta de la acci&oacute;n:'
                                                        },
                                                        {
                                                        	x:135,
                                                            y:5,
                                                            xtype:'textfield',
                                                            id:'etiquetaAccion',
                                                            width:250
                                                            
                                                        },
                                                        panelGrid,
                                                        {
                                                        	x:10,
                                                            y:360,
                                                            xtype:'label',
                                                            html:'Acción a ejecutar una vez dictaminado:'
                                                        },
                                                        cmAccionEnvio,
                                                        {
                                                        	x:470,
                                                            y:360,
                                                            xtype:'label',
                                                            html:'Mostrar formulario asociado:'
                                                        },
                                                        cmbMostrarFormularioAsociado
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
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
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST',
                                                                            'funcion=53&objOpciones={"idActor":"'+idActor+'","etiqueta":"'+gEx('etiquetaAccion').getValue()+
                                                                            '","opciones":'+opciones+'}&accionFinalizar='+cmAccionEnvio.getValue()+'&mostrarFormulario='+
                                                                            gEx('cmbMostrarFormularioAsociado').getValue()+'&idAccion='+idAccion,true);
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    var ventanaPregCerradas = new Ext.Window(
                                            {
                                                title: 'Opciones de dictamen',
                                                width: <?php echo ($ancho+65) ?> ,
                                                height:470,
                                                minWidth: 300,
                                                minHeight: 100,
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
                                                                           gEx('etiquetaAccion').focus(false,500);
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: 'Cancelar',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaPregCerradas.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	
	
	obtenerEtapasDisponibles(idActor,et,ventanaPregCerradas,cmbPasaEtapa.getStore(),true,grupoElemento);
    
}

function formatearEtapa(val)
{
	var pos=existeValorMatriz(arrEtapas,val);
    if(pos>-1)
		return removerCerosDerecha(val+'')+'.- '+arrEtapas[pos][1];
    else
    	return val;
}

var arrSiNo=<?php echo $arrSiNo?>;
 
function formatearSiNo(val)
{
	var pos=existeValorMatriz(arrSiNo,val);
    if(pos>-1)
		return arrSiNo[pos][1];
    else
    	return val;
}
 
function configurarDictamenParcial(iA,iAccion,e,idGrupoElemento)
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
    var grupoElemento=null;
    if(idGrupoElemento!=undefined)
    	grupoElemento=idGrupoElemento;
	var cmbAccion=crearComboExt('cmbAccion',arrAcciones);
   
    var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo);
    var dsOpciones= [<?php echo "[".$filaDefaultDP."]" ?>];
    alOpciones=		new Ext.data.SimpleStore(
                                                {
                                                    fields:	[
                                                                <?php 
                                                                    echo $camposDP;
                                                                ?>
                                                            ]
                                                }
                                            );
    
    alOpciones.loadData(dsOpciones);
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Clave',
                                                            width:100,
                                                            dataIndex:'valorOpt',
                                                            editor: new Ext.form.TextField   (
                                                                                                    {
                                                                                                      
                                                                                                       style: 'text-align:left'
                                                                                                    }
                                                                                                )
                                                        }
                                                        ,
                                                        <?php 
                                                            echo $columnasDP;
                                                        ?>
                                                    ]
                                                );
    
    
    
    tblOpciones=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOpcionesManuales',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 1,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            columnLines:true,
                                                            width:<?php echo $ancho+35 ?>,
                                                            title:'Ingrese los posibles valores de dict&aacute;men:',
                                                            tbar: [
                                                                    {
                                                                        text: 'Agregar opci&oacute;n',
                                                                        icon:'../images/add.png',
                                                                        handler : function()
                                                                                  {
                                                                                        var r=new RegistroOpciones	(
                                                                                                                        {
                                                                                                                            <?php echo $camposOpcionesDP?>
                                                                                                                        }
                                                                                                                    ) 	
                                                                                        alOpciones.add(r);	
                                                                                        tblOpciones.startEditing(alOpciones.getCount()-1,1);
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
                                                                                       msgConfirmWin('Est&aacute; seguro de querer eliminar esta opci&oacute;n?',funcConfirmDel);
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
                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','La opci&oacute;n ingresada ya se encuentra registrada',funcOK);
            }
        }
    }
    tblOpciones.on('afteredit',funcEdicion);
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:40,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
   
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Etiqueta de la acci&oacute;n:'
                                                        },
                                                        {
                                                        	x:135,
                                                            y:5,
                                                            xtype:'textfield',
                                                            id:'etiquetaAccion',
                                                            width:250
                                                            
                                                        },
                                                        panelGrid
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
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
                                                                            
                                                                        if(resul)
                                                                        {
                                                                            var opciones=obtenerValoresOpcionesManualesDP();
                                                                            
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
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=69&objOpciones={"idActor":"'+idActor+'","etiqueta":"'+gEx('etiquetaAccion').getValue()+'","opciones":'+opciones+'}&idAccion='+idAccion,true);
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    var ventanaPregCerradas = new Ext.Window(
                                            {
                                                title: 'Opciones de dictamen',
                                                width: <?php echo ($ancho+65) ?> ,
                                                height:470,
                                                minWidth: 300,
                                                minHeight: 100,
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
                                                                         	gEx('etiquetaAccion').focus(false,500);
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: 'Cancelar',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaPregCerradas.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	llenarOpcionesDictamenParcial(idActor,ventanaPregCerradas,idGrupoElemento);

}

function llenarOpcionesDictamenParcial(idActor,ventana,idGrupoElemento)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            gEx('etiquetaAccion').setValue(arrResp[2]);
            Ext.getCmp('gridOpcionesManuales').getStore().loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=71&idActor='+idActor+'&idGrupoElemento='+idGrupoElemento,true);
}




function configurarDictamenRevisor(idAccion,et,idGrupoElemento)
{
	
    var grupoElemento=null;
    if(idGrupoElemento!=undefined)
    	grupoElemento=idGrupoElemento;
	
    var dsOpciones= [<?php echo "[".$filaDefaultDR."]" ?>];
    alOpciones=		new Ext.data.SimpleStore(
                                                {
                                                    fields:	[
                                                                <?php 
                                                                    echo $camposDR;
                                                                ?>
                                                            ]
                                                }
                                            );
    
    alOpciones.loadData(dsOpciones);
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Clave',
                                                            width:100,
                                                            dataIndex:'valorOpt',
                                                            editor: new Ext.form.TextField   (
                                                                                                    {
                                                                                                      
                                                                                                       style: 'text-align:left'
                                                                                                    }
                                                                                                )
                                                        }
                                                        ,
                                                        <?php 
                                                            echo $columnasDR;
                                                        ?>
                                                    ]
                                                );
    
    
    
    tblOpciones=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOpcionesManualesDR',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 1,
                                                            cm: cmFrmDTD,
                                                            height:270,
                                                            columnLines:true,
                                                            width:<?php echo $ancho+35-350 ?>,
                                                            title:'Ingrese los posibles valores de dict&aacute;men:',
                                                            tbar: [
                                                                    {
                                                                        text: 'Agregar opci&oacute;n',
                                                                        icon:'../images/add.png',
                                                                        handler : function()
                                                                                  {
                                                                                        var r=new RegistroOpciones	(
                                                                                                                        {
                                                                                                                            <?php echo $camposOpcionesDP?>
                                                                                                                        }
                                                                                                                    ) 	
                                                                                        alOpciones.add(r);	
                                                                                        tblOpciones.startEditing(alOpciones.getCount()-1,1);
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
                                                                                       msgConfirmWin('Est&aacute; seguro de querer eliminar esta opci&oacute;n?',funcConfirmDel);
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
                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','La opci&oacute;n ingresada ya se encuentra registrada',funcOK);
            }
        }
    }
    tblOpciones.on('afteredit',funcEdicion);
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
   
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
                                        id:'btnAceptar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
                                                                            
                                                                        if(resul)
                                                                        {
                                                                            var opciones=obtenerValoresOpcionesManualesDR();
                                                                            
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
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=70&objOpciones={"opciones":'+opciones+'}&idAccion='+idAccion,true);
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    var ventanaPregCerradas = new Ext.Window(
                                            {
                                                title: 'Opciones de dictamen',
                                                width: <?php echo ($ancho+65-350) ?> ,
                                                height:400,
                                                minWidth: 300,
                                                minHeight: 100,
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
                                                                           
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: 'Cancelar',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaPregCerradas.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	
    llenarOpcionesDictamenRevisores(ventanaPregCerradas,idGrupoElemento);

}

function llenarOpcionesDictamenRevisores(ventana,idGrupoElemento)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            Ext.getCmp('gridOpcionesManualesDR').getStore().loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=72&idGrupoElemento='+idGrupoElemento,true);
}

function validarOpciones(dSet,tblEditor)
{
	var res=validarCampoNoVacio(tblOpciones.getStore(),'valorOpt');
	if(res!='-1')
	{
		function funcClickOk()
		{
			tblOpciones.startEditing(res-1,1);
			return false
		}
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','El contenido de esta celda no puede estar vac&iacute;a',funcClickOk);
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
			Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','El texto a mostrar como opci&oacute;n debe ser ingresado, al menos en su idioma',funcClickOk);	
			
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
                                //Ext.getCmp('btnFinalizarPCerradas').fireEvent('click');
                            }
                            return false;
                        }
                        Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>', 'El texto a mostrar como opci&oacute;n no ha sido especificado en todos lo idiomas, desea continuar', funcConfirmacion);
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
                '"etapa":"'+reg.get('numEtapa')+'"}';
        if(opciones=='')
            opciones=cadTemp;
        else
            opciones+=','+cadTemp;
    }
    return '['+opciones+']';
}

function obtenerValoresOpcionesManualesDR()
{
	var opciones='';
    var cadTemp='';
    
    var tblOpciones=Ext.getCmp('gridOpcionesManualesDR');
    var cm=tblOpciones.getColumnModel();
    var ct=tblOpciones.getStore().getCount();
    var reg;
    var x;
    
    for(x=0;x<ct;x++)
    {
        reg=tblOpciones.getStore().getAt(x);
        var valColumnas=obtenerValoresColumnasRegistroGR(cm,reg);
        cadTemp='{"vOpcion":"'+cv(reg.get('valorOpt'))+'",'+
                '"columnas":['+valColumnas+']}';
        if(opciones=='')
            opciones=cadTemp;
        else
            opciones+=','+cadTemp;
    }
    return '['+opciones+']';
}

function obtenerValoresOpcionesManualesDP()
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
                '"accion":"'+reg.get('accion')+'",'+
                '"reqRespuesta":"'+reg.get('reqRespuesta')+'"'+
                '}';
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
    var nColDes=2;
    if(cm.getColumnCount()-nColDes-2==0)
    	nColDes=1;
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

function obtenerValoresColumnasRegistroGR(cm,reg)
{
	var columnas='';
	var idLeng='';
	var tColum='';
	var x;
    
	for(x=2;x<cm.getColumnCount();x++)
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
   abrirVentana('../modeloPerfiles/formularios.php?idFormulario='+idFormulario+'&cPagina='+cv('mR1=false|mI=false'),800,600);
}

function agregarActorProceso(iP)
{
	var idProceso=iP;
	var arrActores=[];
	var cadActores=gE('idActor').value;
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
  obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=56&idProceso='+idProceso+'&idPerfil='+gE('idPerfil').value+'&cadActores='+cadActores,true);
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
   	msgConfirmWin('Est&aacute; seguro de querer remover a este actor?',respRemover,330,120);
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
                                                            y:10,
                                                            html:'Seleccione las acciones a agregar:'
                                                        },
                                                        gridAcciones
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar acci&oacute;n',
										width: 550,
										height:400,
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=59&cadAcciones='+cadAcciones+'&actor='+actor+'&idProceso='+idProceso+'&idPerfil='+gE('idPerfil').value,true);
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=58&idPerfil='+gE('idPerfil').value+'&actor='+actor+'&idProceso='+idProceso,true);
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
    msgConfirmWin('Est&aacute; seguro de querer remover esta acci&oacute;n?',resp,330,120);       
}

function configurarVerRegistros(idAc,vReg,tAccion)
{
	var arrVerRegistros=<?php echo $arrOpciones?>;
    
    var cmbVerRegistros=crearComboExt('cmbVerRegistros',arrVerRegistros,90,15);
    cmbVerRegistros.setWidth(350);
    if(vReg !=undefined)
    	cmbVerRegistros.setValue(vReg);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:20,
                                                            html:'Seleccione:'
                                                        },
                                                        cmbVerRegistros

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de registros que ver&aacute; el actor',
										width: 520,
										height:150,
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
                                                                                var cadSpan="<span class='letraAzulSubrayada7'> ("+vRegistros+") </span>&nbsp;&nbsp;<a href='javascript:configurarVerRegistros("+idAc+","+verRegistro+")'><img src='../images/pencil.png' title='Cambiar tipo de registros visto por actor' alt='Cambiar tipo de registros visto por actor'></a>";
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
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
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
        msgConfirmWin('Est&aacute; seguro de querer remover las dependencias de dictamen?',resp);
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
                                            width: 500,
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
	chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Actor',
															width:150,
															sortable:true,
															dataIndex:'actor'
														},
														{
															header:'Tipo',
															width:200,
															sortable:true,
															dataIndex:'tipo',
                                                            renderer:renderTipoUsuario
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:450,
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
    msgConfirmWin('Est&aacute; seguro de querer remover este actor como condici&oacute;n de dictamen final?',resp);            
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
	var arrDatos=[['idProceso',iP],['numEtapa',e],['idPerfil',bE(gE('idPerfil').value)]];
    enviarFormularioDatos('../modeloPerfiles/configurarDisparadores.php',arrDatos);
}

function configurarEvaluacion(idAccion,et)
{
	var arrEtapas=[];
    var cmbPasaEtapa=crearComboExt('cmbPasaEtapa',arrEtapas);
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
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Clave',
                                                            width:100,
                                                            dataIndex:'valorOpt',
                                                            editor: new Ext.form.TextField   (
                                                                                                    {
                                                                                                      
                                                                                                       style: 'text-align:left'
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
                                                            frame:true,
                                                            clicksToEdit: 1,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            columnLines:true,
                                                            width:<?php echo $ancho+35 ?>,
                                                            title:'Ingrese los posibles valores de dict&aacute;men:',
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
                                                                                        tblOpciones.startEditing(alOpciones.getCount()-1,1);
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
                                                                                       msgConfirmWin('Est&aacute; seguro de querer eliminar esta opci&oacute;n?',funcConfirmDel);
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
                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','La opci&oacute;n ingresada ya se encuentra registrada',funcOK);
            }
        }
    }
    tblOpciones.on('afteredit',funcEdicion);
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
   
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
                                        id:'btnAceptar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
                                                                            
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
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=330&objOpciones={"opciones":'+opciones+'}&idAccion='+idAccion,true);
                                                                        }
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    var ventanaPregCerradas = new Ext.Window(
                                            {
                                                title: 'Opciones de evaluaci&oacute;n',
                                                width: <?php echo ($ancho+65) ?> ,
                                                height:470,
                                                minWidth: 300,
                                                minHeight: 100,
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
                                                                           
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: 'Cancelar',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaPregCerradas.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	
	
	obtenerEtapasDisponiblesEvaluacion(et,ventanaPregCerradas,cmbPasaEtapa.getStore(),true,idAccion);
    
}


function obtenerEtapasDisponiblesEvaluacion(et,ventana,almacen,ninguna,idAccion)
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
            llenarOpcionesEvaluacionSolicitud(idAccion,ventana);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=51&idProceso='+idProceso+'&numEtapa='+et,true);
}

function llenarOpcionesEvaluacionSolicitud(idAccion,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrParam=eval(arrResp[1]);
            Ext.getCmp('gridOpcionesManuales').getStore().loadData(arrParam);
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=230&idAccion='+idAccion,true);	
}

function cambiarAmbitoResp(ctrl,a,tO)
{
	var valor=ctrl.options[ctrl.selectedIndex].value;
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
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=231&idAccion='+a+'&tipoOpcion='+tO+'&valor='+valor,true);
}

function configurarTiempoPresupuestal(iA,tP)
{
	var arrTiempos=<?php echo $arrTiempos?>;
	var cmbTiempos=crearComboExt('cmbTiempos',arrTiempos,140,35);
    cmbTiempos.setWidth(300);
    if(tP !=undefined)
    	cmbTiempos.setValue(tP);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el tiempo presupuestal que se asignar&aacute; al presupuesto autorizado'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Tiempo presupuestal:'
                                                        },
                                                        cmbTiempos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de tiempo presupuestal',
										width: 470,
										height:160,
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
																		var tiempo=cmbTiempos.getValue();
                                                                        if(tiempo=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el tiempo presupuestal que se asignar&aacute; al presupuesto autorizado');
                                                                        	return;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var spanDestino=gE('tblEtapas_'+iA);
                                                                                var etapaPasa= cmbTiempos.getRawValue();
                                                                                var cadSpan;
                                                                                cadSpan="<span class='corpo8'><font color='#000055'><b>Tiempo presupuestal: </b></font><br><font color='green'><b> "+etapaPasa+"</b></font></span>&nbsp;&nbsp;<a href='javascript:configurarTiempoPresupuestal("+iA+","+tiempo+")'><img src='../images/pencil.png' title='Modificar el tiempo presupuestal que tomar&aacute;n las partidas al ser autorizadas' alt='Modificar el tiempo presupuestal que tomar&aacute;n las partidas al ser autorizadas'></a>";
                                                                                spanDestino.innerHTML=cadSpan;
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=52&idAccion='+iA+'&numEtapa='+tiempo,true);
                                                                        
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
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

function removerUnidad(iU)
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
                    var fila=gE('filaAmbito_'+bD(iU));

                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=246&iU='+bD(iU),true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover la Instituci&oacute;n/departamento seleccionada(o)?',resp)
}

function agregarUnidad(iA)
{

	var oConf=	{
    					idCombo:'cmbDepartamento',
                        posX:150,
                        posY:35,
                        anchoCombo:350,
                        campoDesplegar:'unidad',
                        campoID:'codigoUnidad',
                        campoHDestino:'hUnidad',
                        funcionBusqueda:248,
                        paginaProcesamiento:'../paginasFunciones/funcionesProyectos.php',
                        confVista:'<tpl for="."><div class="search-item"><b>{unidad}</b> <br><span class="letraRojaSubrayada8">Instituci&oacute;n:</span> {institucion}</div></tpl>',
                        campos:	[
                                    {name:'codigoUnidad'},
                                    {name:'unidad'},
                                    {name:'institucion'}
                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	
                                    	gE('hUnidad').value='-1';
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	gE('hUnidad').value=registro.get('codigoUnidad');
                                    	
                                    }  
    				};
	var cmbDepartamento=crearComboExtAutocompletar(oConf);

	var cmbAmbito=crearComboExt('cmbAmbito',arrAmbito,80,65,300);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:5,
                                                            xtype:'radio',
                                                            id:'rdo_1',
                                                            name:'rdoUnidad',
                                                            boxLabel:'Instituci&oacute;n a la que pertenece:',
                                                            listeners:	{
                                                            				'check':validarRadio
                                                            			}
                                                        },
                                                        {
                                                        	x:200,
                                                            y:5,
                                                            id:'rdo_2',
                                                            xtype:'radio',
                                                            name:'rdoUnidad',
                                                            boxLabel:'Departamento al que pertenece:',
                                                            listeners:	{
                                                            				'check':validarRadio
                                                            			}
                                                        },
                                                        {
                                                        	x:390,
                                                            y:5,
                                                            id:'rdo_3',
                                                            xtype:'radio',
                                                            checked:true,
                                                            name:'rdoUnidad',
                                                            boxLabel:'Otra instituci&oacute;n/departamento:',
                                                            listeners:	{
                                                            				'check':validarRadio
                                                            			}
                                                        },
														{
                                                        	x:10,
                                                            y:40,
                                                            html:'Instituci&oacute;n/departamento:'
                                                        },
                                                        cmbDepartamento,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'&Aacute;mbito:'
                                                        },
                                                        cmbAmbito

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Instituci&oacute;n/departamento',
										width: 650,
										height:190,
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
                                                                	cmbDepartamento.focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var hUnidad=gE('hUnidad');
                                                                        if(gEx('rdo_3').getValue())
                                                                        {
                                                                          
                                                                            if(hUnidad.value=='-1')
                                                                            {
                                                                                function resp1()
                                                                                {
                                                                                    cmbDepartamento.focus();
                                                                                }
                                                                                msgBox('Debe indicar la Instituci&oacute;n/departamento que desea agregar',resp1);
                                                                                return;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(gEx('rdo_2').getValue())
                                                                            {
                                                                            	gE('hUnidad').value='-2';
                                                                            }
                                                                            else
                                                                            {
                                                                            	gE('hUnidad').value='-1';
                                                                            }
                                                                        }
                                                                        if(cmbAmbito.getValue()=='')
                                                                          {
                                                                              function resp2()
                                                                              {
                                                                                  cmbAmbito.focus();
                                                                              }
                                                                              msgBox('Debe indicar el &aacute;mbito de Instituci&oacute;n/departamento que desea agregar',resp2);
                                                                              return;
                                                                           }
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var tblUnidades=gE('tblUnidades_'+bD(iA));
                                                                                var fila=tblUnidades.insertRow(tblUnidades.rows.length);
                                                                                fila.setAttribute('id','filaAmbito_'+arrResp[1]);
                                                                                var celda1=fila.insertCell(0);
                                                                                celda1.setAttribute('class','fondoGrid7');
                                                                                var unidad='';
                                                                                if(gE('hUnidad').value=='-1')
                                                                                	unidad='Instituci&oacute;n a la que pertenece';
                                                                                else
                                                                                    if(gE('hUnidad').value=='-2')
                                                                                        unidad='Departamento al que pertenece';
                                                                                    else
                                                                                		unidad=cmbDepartamento.getRawValue();
                                                                                celda1.innerHTML="<a href='javascript:removerUnidad(\""+bE(arrResp[1])+"\")'><img alt='Remover Institución/departamento' title='Remover Institución/departamento' src='../images/delete.png'></a> "+unidad;
                                                                                var celda2=fila.insertCell(1);
                                                                                celda2.setAttribute('class','fondoGrid7'); 
                                                                                celda2.innerHTML=cmbAmbito.getRawValue();
                                                                                ventanaAM.close();
                                                                            }
                                                                            
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=247&codigoUnidad='+hUnidad.value+'&ambito='+cmbAmbito.getValue()+'&idAccion='+bD(iA),true);
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
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

function validarRadio(chk,checked)
{
	if(!checked)
    	return;
	var arrId=chk.id.split('_');
	var cmbDepartamento=gEx('cmbDepartamento');

	switch(arrId[1])
    {
    	case '1':
        case '2':
            gE('hUnidad').value=-1;
            cmbDepartamento.reset();
			cmbDepartamento.disable();        
            
        break;
        case '3':
        	cmbDepartamento.enable();
        break;
    }
}

function configurarModuloFirmaCertificacion(iA,e,cConf)
{

	var cmbVisualizarBoton=crearComboExt('cmbVisualizarBoton',arrSiNo,200,125,130);
    cmbVisualizarBoton.setValue('1');
	var cmbAccionCertificado=crearComboExt('cmbAccionCertificado',arrAccionesConsecuentes,350,35,300);
    cmbAccionCertificado.setValue('0');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Etiqueta: '
                                                        },
                                                        {
                                                        	x:130,
                                                            y:5,
                                                            width:350,
                                                            xtype:'textfield',
                                                        	id:'txtEtiqueta'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Acción a ejecutar una vez firmado/certificado el proceso:'
                                                        },
                                                        cmbAccionCertificado,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Funci&oacute;n de  firma/certificaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:65,
                                                            width:250,
                                                            xtype:'textfield',
                                                        	id:'txtFuncionCertificacion'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'URL m&oacute;dulo certificaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:95,
                                                            width:460,
                                                            xtype:'textfield',
                                                        	id:'txtURLModulo'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Visualizar bot&oacute;n de firma:'
                                                        },
                                                        cmbVisualizarBoton,
                                                        {
                                                        	xtype:'fieldset',
                                                            title:'Configuraci&oacute;n de acciones:',
                                                            width:830,
                                                            x:10,
                                                            y:160,
                                                            height:210,
                                                            layout:'absolute',
                                                            items:	[
                                                            			crearGridAccionFirma()
                                                            		]
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configurar m&oacute;dulo de certificaci&oacute;n firma',
										width: 880,
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
                                                                	gEx('txtEtiqueta').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
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
                                                                        
                                                                        var txtFuncionCertificacion=gEx('txtFuncionCertificacion');
                                                                        if(txtFuncionCertificacion.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtFuncionCertificacion.fcus();
                                                                            }
                                                                            msgBox('Debe ingresar la funci&oacute;n del m&oacute;dulo de firma/certificaci&oacute;n',resp2);
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
                                                                        
                                                                        var cadObj='{"visualizarBoton":"'+cmbVisualizarBoton.getValue()+'","etiqueta":"'+cv(txtEtiqueta.getValue())+'","accionEjecucion":"'+cmbAccionCertificado.getValue()+
                                                                        			'","funcionModuloFirma":"'+txtFuncionCertificacion.getValue()+'","urlModuloCertificacion":"'+gEx('txtURLModulo').getValue()+
                                                                                    '","arrAcciones":['+arrAcciones+']}';
                                                                        
                                                                        
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
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
    
    if(cConf)
    {
    	var cadConf='['+bD(cConf)+']';
        var oConf=eval(cadConf)[0];
        gEx('txtEtiqueta').setValue(oConf.etiqueta);
        cmbAccionCertificado.setValue(oConf.accionEjecucion);
        
        gEx('txtFuncionCertificacion').setValue(oConf.funcionModuloFirma);
        gEx('txtURLModulo').setValue(oConf.urlModuloCertificacion);
        cmbVisualizarBoton.setValue(oConf.visualizarBoton);
        var arrDatos=[];
        var x;
        for(x=0;x<oConf.arrAcciones.length;x++)
        {
        	arrDatos.push([oConf.arrAcciones[x].idAccion,oConf.arrAcciones[x].etiquetaAccion,oConf.arrAcciones[x].etapaEnvio,((oConf.arrAcciones[x].documentoFinal)?'0':oConf.arrAcciones[x].documentoFinal)]);
        }
        
        gEx('gAccionesFirma').getStore().loadData(arrDatos);
        
        
    }
    
}


function crearGridAccionFirma()
{
	var cmbEnvioEtapa=crearComboExt('cmbEnvioEtapa',arrEtapasNumero);
	var cmbDocumentoFinal=crearComboExt('cmbDocumentoFinal',arrSiNo);
	
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
															sortable:true,
															dataIndex:'accion',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrAccionesFirma,val);
                                                                    }
														},
                                                        {
															header:'Etiqueta',
															width:190,
															sortable:true,
															dataIndex:'etiquetaAccion',
                                                            renderer:mostrarValorDescripcion,
                                                            editor:{xtype:'textfield'}
														},
														{
															header:'Enviar a etapa',
															width:250,
															sortable:true,
															dataIndex:'etapaCambio',
                                                            editor:cmbEnvioEtapa,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasNumero,val);
                                                                    }
														},
                                                        {
															header:'Documento final',
															width:115,
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
                                                            x:0,
                                                            y:0,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:150
                                                            
                                                            
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
	var cmbUnidad=crearComboExt('cmbUnidad',arrUnidad,260,65,110);
    cmbUnidad.setValue('MB');
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrTiposDocumentos,200,5,300);
    cmbTipoDocumento.setValue('0');
    if(objConf.categoriaDocumento)
    {
    	cmbTipoDocumento.setValue(objConf.categoriaDocumento);
    }
    
    if(objConf.unidadTamano)
    {
    	cmbUnidad.setValue(objConf.unidadTamano);
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Categor&iacute;a de documento a subir:'
                                                        },
                                                        cmbTipoDocumento,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Extensiones permitidas:'
                                                        },
                                                        {
                                                        	x:170,
                                                            y:35,
                                                            id:'txtExtensiones',
                                                            width:300,
                                                            value:objConf.extensionesPermitidas?decodeURI(objConf.extensionesPermitidas):'',
                                                            xtype:'textfield'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Tama&ntilde;o m&aacute;ximo permitido:'
                                                        },
                                                        {
                                                        	x:170,
                                                            y:65,
                                                            id:'txtTamano',
                                                            width:70,
                                                            value:objConf.tamanoMaximo?objConf.tamanoMaximo:'',
                                                            xtype:'numberfield',
                                                            allowNegative:false
                                                        },
                                                        cmbUnidad
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n documento de subida',
										width: 540,
										height:210,
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var cadObj='{"categoriaDocumento":"'+cmbTipoDocumento.getValue()+
                                                                        			'","extensionesPermitidas":"'+cv(gEx('txtExtensiones').getValue(),false,true)+
                                                                                    '","tamanoMaximo":"'+gEx('txtTamano').getValue()+
                                                                                    '","unidadTamano":"'+gEx('cmbUnidad').getValue()+'"}';
																	
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