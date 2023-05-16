<?php
session_start();
include("conexionBD.php");
include("configurarIdiomaJS.php");
$idFormulario=bD($_GET["idFormulario"]);
$idRegistro=bD($_GET["idRegistro"]);
$idActor=bD($_GET["idActor"]);
$nVersion=bD($_GET["v"]);

$consulta="select a.idRevisorProceso,concat(i.Paterno,' ',i.Materno,', ',i.Nom) as nombre,'' as afiliacion,estado,idFormDictamen,date_format(fechaAsignacion,'%d/%m/%Y') as fechaAsignacion,
			if(fechaDictamen is null,'',date_format(fechaDictamen,'%d/%m/%Y')) as fechaDictamen,(select nombreFormulario from 900_formularios where idFormulario=a.idFormularioDictamen) as formatoEval,
			(SELECT COUNT(*) FROM 9050_comentariosSeccion WHERE idResponsableComentario=a.idUsuarioRevisor and idActor=-".$idActor." AND version=a.versionRegistro AND idReferencia=a.idReferencia AND idFormularioBase=a.idFormulario) as nComentarios,a.idUsuarioRevisor 
			from 955_revisoresProceso a,802_identifica i where i.idUsuario=a.idUsuarioRevisor and a.idFormulario=".$idFormulario." and a.idReferencia=".$idRegistro."
			and a.estado in (0,1,2) and idActorProcesoEtapa=".$idActor." and a.versionRegistro=".$nVersion." order by nombre";


$arrAutores=uEJ($con->obtenerFilasArreglo($consulta));
$tipoFormulario="15";
$consulta="select f.idFormulario from 948_actoresVSFormulariosDictamen ad,900_formularios f where f.idFormulario=ad.idFormulario and f.tipoFormulario=".$tipoFormulario." and idActor=".$idActor;

$idFormularioD=$con->obtenerValor($consulta);
?>
Ext.form.TriggerField.override	(
                                    {
                                        afterRender: function() 
                                        			{
                                             			Ext.form.TriggerField.superclass.afterRender.call(this);
                                        			}
                                    }
                               	);



var idForm;
var idReg;

Ext.onReady(inicializarCombos);
var numIni=1;
function inicializarCombos()
{
	idForm=gE('idFormulario').value;
    idReg=gE('idRegistro').value;
	idActor=gE('actor').value;
    var pPagina=new Ext.data.HttpProxy	(
                                            {
                                                url: '../paginasFunciones/funcionesProyectos.php', 
                                                method:'POST' 
                                            }
                                        );
                                        
    var lector =new Ext.data.JsonReader	(
                                            {
                                                root: 'autores',
                                                totalProperty: 'numAutores',
                                                id:'idAutor'
                                            }, 
                                            [
                                                {name:'idAutor',mapping:'idAutor'},
                                                {name: 'apPat', mapping: 'apPat'},
                                                {name: 'apMat', mapping: 'apMat'},
                                                {name: 'nombres', mapping: 'nombres'},
                                                {name:	'fichaOrg',mapping:'fichaOrg'}
                                            ]
                                        );	
    var parametros=	{
                        funcion:'80',
                        idFormulario:idForm,
                        idRegistro:idReg,
                        actor:idActor,
                        datosAutor:''
                    }


        generarComboApPaterno(pPagina,lector,parametros);
        generarComboApMaterno(pPagina,lector,parametros);
        generarComboNombres(pPagina,lector,parametros);	
        crearGridAutores();
	Ext.getCmp('cmbApPaterno').focus(true,10);
		
}

function generarComboApPaterno(pPagina,lector,parametros)
{
	var ds = new Ext.data.Store	(
                                    {
                                        proxy:	pPagina,												
                                        reader: lector,
                                        baseParams:	parametros
                                    }
                                );
	
	function funcCargarDatos(dSet,opciones)
    {
        var apPaterno=Ext.getCmp('cmbApPaterno').getValue();
        var apMaterno=Ext.getCmp('cmbApMaterno').getValue();
        var nombres=Ext.getCmp('cmbNombres').getValue();
        gE('lblAfiliacion').innerHTML='';
        oE('btnAgregarAutor');
        var datos='{"apPaterno":"'+cv(apPaterno)+'","apMaterno":"'+cv(apMaterno)+'","nombres":"'+cv(nombres)+'"}';
        dSet.setBaseParam('datosAutor',datos);
        //dSet.baseParams.datosAutor=datos;
        
    }
	ds.on('beforeload',funcCargarDatos);	
	
	var resultTpl = new Ext.XTemplate	(
											'<tpl for="."><div class="search-item">',
												'<b>{apPat}</b> {apMat}, {nombres}<br>{fichaOrg}<br>',
											'</div></tpl>'
										);
	
	var buscarApPaterno = new Ext.form.ComboBox	
	(
		{
			x:8,
			id:'cmbApPaterno',
			store: ds,
			displayField:'nombreC',
			typeAhead: false,
			minChars:1,
			loadingText: 'Buscando...',
			width: 250,
			pageSize:10,
			hideTrigger:true,
			tpl: resultTpl,
			applyTo: 'txtApPaterno',
			itemSelector: 'div.search-item'
		}
	);
	
	buscarApPaterno.on('select',funcSeleccionado);

}

function generarComboApMaterno(pPagina,lector,parametros)
{
	var ds = new Ext.data.Store	
	(
		{
			proxy:	pPagina,												
			reader: lector,
			baseParams:	parametros
		}
	);
	
   function funcCargarDatos(dSet,opciones)
    {
        var apPaterno=Ext.getCmp('cmbApPaterno').getValue();
        var apMaterno=Ext.getCmp('cmbApMaterno').getValue();
        var nombres=Ext.getCmp('cmbNombres').getValue();
        gE('lblAfiliacion').innerHTML='';
        oE('btnAgregarAutor');
        dSet.baseParams.datosAutor='{"apPaterno":"'+cv(apPaterno)+'","apMaterno":"'+cv(apMaterno)+'","nombres":"'+cv(nombres)+'"}';
    }

	ds.on('beforeload',funcCargarDatos);	
	
	var resultTpl = new Ext.XTemplate	(
											'<tpl for="."><div class="search-item">',
												'{apPat} <b>{apMat}</b>, {nombres}<br>{fichaOrg}',
											'</div></tpl>'
										);

	var buscarApMaterno = new Ext.form.ComboBox	
	(
		{
			x:8,
			id:'cmbApMaterno',
			store: ds,
			displayField:'nombreC',
			typeAhead: false,
			minChars:1,
			loadingText: 'Buscando...',
			width: 250,
			pageSize:10,
			hideTrigger:true,
			tpl: resultTpl,
			applyTo: 'txtApMaterno',
			itemSelector: 'div.search-item'
		}
	);
	buscarApMaterno.on('select',funcSeleccionado);
}

function generarComboNombres(pPagina,lector,parametros)
{
	var ds = new Ext.data.Store	
	(
		{
			proxy:	pPagina,												
			reader: lector,
			baseParams:	parametros
		}
	);
    
	
	function funcCargarDatos(dSet,opciones)
    {
        var apPaterno=Ext.getCmp('cmbApPaterno').getValue();
        var apMaterno=Ext.getCmp('cmbApMaterno').getValue();
        var nombres=Ext.getCmp('cmbNombres').getValue();
        gE('lblAfiliacion').innerHTML='';
        oE('btnAgregarAutor');
        dSet.baseParams.datosAutor='{"apPaterno":"'+cv(apPaterno)+'","apMaterno":"'+cv(apMaterno)+'","nombres":"'+cv(nombres)+'"}';
    }
	ds.on('beforeload',funcCargarDatos);	
	
	
	var resultTpl = new Ext.XTemplate	(
											'<tpl for="."><div class="search-item">',
												'{apPat} {apMat}, <b>{nombres}</b><br>{fichaOrg}',
											'</div></tpl>'
										);

	var buscarNombres = new Ext.form.ComboBox	
	(
		{
			x:8,
			id:'cmbNombres',
			store: ds,
			displayField:'nombreC',
			typeAhead: false,
			minChars:1,
			loadingText: 'Buscando...',
			width: 250,
			pageSize:10,
			hideTrigger:true,
			tpl: resultTpl,
			applyTo: 'txtNombres',
			itemSelector: 'div.search-item'
		}
	);
	buscarNombres.on('select',funcSeleccionado);
}

function funcSeleccionado(combo,registro)
{
    var apPaterno=registro.get('apPat');
    var apMaterno=registro.get('apMat');
    var nombres=registro.get('nombres');
    mE('btnAgregarAutor');
    Ext.getCmp('cmbApPaterno').setValue(apPaterno);
    Ext.getCmp('cmbApMaterno').setValue(apMaterno);
    Ext.getCmp('cmbNombres').setValue(nombres);
    Ext.getCmp('cmbNombres').focus(false,100);
    gE('lblAfiliacion').innerHTML=registro.get('fichaOrg');
    gE('hIdAutor').value=registro.get('idAutor');
}

registroRevisor =Ext.data.Record.create	(
											[
												{name: 'idAutor'},
												{name: 'nombreAutor'},
                                                {name: 'afiliacion'},
                                                {name: 'situacion'},
                                                {name: 'dictamen'},
                                                {name: 'fechaAsigna'},
                                                {name:'fechaDictamen'}
											]
										)

var dsAutores= 	<?php echo $arrAutores ?>;

alAutores=	new Ext.data.SimpleStore(
										{
											fields:	[
														{name: 'idAutor'},
														{name: 'nombreAutor'},
														{name: 'afiliacion'},
                                                        {name: 'situacion'},
                                                        {name: 'dictamen'},
                                                        {name: 'fechaAsigna'},
                                                        {name: 'fechaDictamen'},
                                                        {name: 'formatoEval'},
                                                        {name: 'nComentarios', type:'int'},
                                                        {name: 'idUsuario'}
                                                        
													]
										}
									);
var arrPosiciones=new Array();
                                    
function crearGridAutores()
{

	var ocultarAgregarMiembro=true;
    if(gE('idComite').value!='-1')
    	ocultarAgregarMiembro=false;
    var x;
    var objPosicion;
    for(x=1;x<=dsAutores.length;x++)
    {
    	objPosicion=new Array();
        objPosicion[0]=x;
        objPosicion[1]=x;
    	arrPosiciones.push(objPosicion);
    }
    
    
	var cmbOrden=crearComboExt('cmbOrden',arrPosiciones);

	alAutores.loadData(dsAutores);	
	
	var cmAutores= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Revisor',
															width:220,
															sortable:true,
															dataIndex:'nombreAutor'

														},
                                                        
                                                        
														
														{
															header:'Afiliaci&oacute;n',
															width:245,
															sortable:true,
															dataIndex:'afiliacion',
                                                            hidden:true
														},
                                                        {
															header:'Fecha Asignaci&oacute;n',
															width:100,
															sortable:true,
															dataIndex:'fechaAsigna'
                                                            
														},
                                                        {
															header:'Situaci&oacute;n',
															width:250,
															sortable:true,
															dataIndex:'situacion',
                                                            renderer:formatearSituacion
														},
                                                        {
															header:'Formato evaluaci&oacute;n',
															width:120,
															sortable:true,
															dataIndex:'formatoEval'
														},
                                                        {
															header:'Fecha Dict&aacute;men',
															width:100,
															sortable:true,
															dataIndex:'fechaDictamen'
                                                            
														},
                                                        
                                                        {
															header:'',
															width:110,
															sortable:true,
															dataIndex:'dictamen',
                                                            renderer:formatearDictamen
														},
                                                         {
															header:'# Comentarios',
															width:110,
															sortable:true,
															dataIndex:'nComentarios',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(val>0)
                                                                        	return '<a href="javascript:mostrarVentanaComentarios(\''+bE(registro.get('idUsuario'))+'\')">'+val+' comentarios</a>';
                                                                         return val+' comentarios';
                                                                    }
														}
                                                        
												
													]
												);
														
	autores=	new Ext.grid.EditorGridPanel	(
														{
														id:'autores',
                                                        store:alAutores,
                                                        frame:true,
                                                        cm: cmAutores,
                                                        height:250,
                                                        width:950,
														
												        clicksToEdit:1,
														renderTo:'divAutores',
														tbar:[
                                                        
                                                        		{
                                                                	text:'Agregar miembro de <?php echo $lblComiteS?>',
                                                                    icon:'../images/add.png',
                                                                    cls:'x-btn-text-icon',
                                                                    hidden:ocultarAgregarMiembro,
																	handler:function()
																			{
                                                                            	mostrarVentanaMiembroComite();
                                                                            }
                                                                },
																{
																	text:'Remover revisor',
                                                                    icon:'../images/cancel_round.png',
                                                                    cls:'x-btn-text-icon',
																	handler:function()
																			{
																				var autores=Ext.getCmp('autores');
																				
																				var celda=autores.getSelectionModel().getSelectedCell();
																				
																				if(celda!=null)
																				{
																					fila=autores.getStore().getAt(celda[0]);
																					function funcConfirmDel(btn)
																					{
																						if(btn=="yes")
																						{
																							quitarAutor(fila,alAutores);
																						}
																					}
																					Ext.Msg.confirm('<?php echo $etj["lblAplicacion"] ?>','Est&aacute; seguro de querer remover el autor seleccionado?',funcConfirmDel);
																					
																				}
																				else
																				{
																					msgBox('Primero debe seleccionar al autor a remover');
																				}
																			}
																}
															 ]
													}
					
    											);
	autores.on('afteredit',funcEditar);
    
}

function formatearSituacion(val)
{
	switch(val)
    {
    	case '0':
        	return '<font color="#000066"><b>En espera de sometimiento a dictamen</b></font>';
        break;
        case '1':
        	return '<font color="#990000"><b>En espera de dictamen por parte de revisor</b></font>';
        break;
        case '2':
        	return '<font color="#006600"><b>Dictaminado</b></font>';
        break;
        
    }
}

function formatearDictamen(val)
{
	if(val=='-1')
    	return '';
    else
    	{
        	var cad='<a href="javascript:verDictamen('+val+')"><img src="../images/icon_document.gif" height="13" width="13"  alt="Ver dictamen" title="Ver dictamen"/>&nbsp;&nbsp;Ver dict&aacute;men</a>';
            return cad;
        }
}

function verDictamen(val)
{
	var idFormulario=<?php echo $idFormularioD?>;
    var arrDatos=[['idFormulario',idFormulario],['idRegistro',val],['cPagina','sFrm=true']];
    window.parent.open('',"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
	window.parent.enviarFormularioDatos('../modeloPerfiles/verFichaFormulario.php',arrDatos,'POST','vAuxiliar');
	
}

function funcEditar(e)
{
	var idRef=gE('idRegistro').value;
    var idFrm=gE('idFormulario').value;
	if(e.field=='orden')
    {
	
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	if(e.value>e.originalValue)
                {
                	var x;
                    for(x=0;x<autores.getStore().getCount();x++)
                    {
                    	fila=autores.getStore().getAt(x);
                    	if(e.record.get('idAutor')!=fila.get('idAutor'))
                        {
                        	var vFila=parseInt(fila.get('orden'));
                            if((vFila>parseInt(e.originalValue))&&(vFila<=parseInt(e.value)))
                            	fila.set('orden',vFila-1);
                        }
                    }
                }
                else
                {
                	var x;
                    for(x=0;x<autores.getStore().getCount();x++)
                    {
                    	fila=autores.getStore().getAt(x);
                    	if(e.record.get('idAutor')!=fila.get('idAutor'))
                        {
                        	var vFila=parseInt(fila.get('orden'));
                            if((vFila>=parseInt(e.value))&&(vFila<parseInt(e.originalValue)))
                            	fila.set('orden',vFila+1);
                        }
                    }
                }
                
                autores.getStore().sort('orden','ASC');
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=26&idAutor='+e.record.get('idAutor')+'&nValor='+e.value+'&vValor='+e.originalValue+'&idFormulario='+idForm+'&idRegistro='+idRef,true);
        	
    }
}

function agregarAutor()
{
	var idActor=gE('actor').value;
    var idAutor=gE('hIdAutor').value;
    var idAut=idAutor;
    var nOrden=Ext.getCmp('autores').getStore().getCount();
    nOrden++;
    var cmbFormatoEval=gE('cmbFormatoEval');
    var idFormatoEval=cmbFormatoEval.options[cmbFormatoEval.selectedIndex].value;
	var estado=gE('eDictamen').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	//recargarPagina();
            var arrDatos=eval(arrResp[1]);
            gEx('autores').getStore().loadData(arrDatos);
            limpiarControles();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=81&idFormularioEval='+idFormatoEval+'&versionRegistro=<?php echo $nVersion?>&idAutor='+idAutor+'&idFormulario='+idForm+'&idRegistro='+idReg+'&idActor='+idActor+'&estado='+estado,true);
}

function limpiarControles()
{
	gE('lblAfiliacion').innerHTML='';
	gE('hIdAutor').value='';
	Ext.getCmp('cmbApPaterno').setValue('');
	Ext.getCmp('cmbApMaterno').setValue('');
	Ext.getCmp('cmbNombres').setValue('');
	Ext.getCmp('cmbApPaterno').focus(true,10);
	oE('btnAgregarAutor');
}

function quitarAutor(fila,alAutores)
{
	var orden=fila.get('orden');
	function funcEliminar()
	{
		var resp=peticion_http.responseText.split('|');
		if((resp[0]=='1')||(resp[0]==1))
		{
			alAutores.remove(fila);	
            var x;
            
            for(x=0;x<autores.getStore().getCount();x++)
            {
                filaAct=autores.getStore().getAt(x);
                var vFila=parseInt(filaAct.get('orden'));
                if(vFila>parseInt(orden))
                	filaAct.set('orden',vFila-1);
            }
            var cmbOrden=Ext.getCmp('cmbOrden');
            cmbOrden.getStore().removeAt(cmbOrden.getStore().getCount()-1);
            if(typeof(funcAgregar)!='undefined')
				funcAgregar();     
		}
		else
		{
			msgBox('No se ha podido realizar la operaci&oacute;n debido al siguiente problema:'+' <br />'+resp[0]);
		}
	}
	obtenerDatosWeb("../paginasFunciones/funcionesProyectos.php",funcEliminar,'POST','funcion=82&idAutor='+fila.get('idAutor')+'&idFormulario='+idForm+'&idRegistro='+idReg+'&orden='+orden,true);
}

/*function registrarNuevoRevisor()
{
    var cPagina=gE('cPagina').value;
    var idActor=gE('actor').value;
    var estado=gE('eDictamen').value;
    if(cPagina=='')
    {
    	var arrParam=[['idFormulario',idForm],['idRegistro',idReg],['idActor',idActor],['estado',estado],['versionRegistro','<?php echo $nVersion?>']];
    }
    else
    {
    	var arrParam=[['idFormulario',idForm],['idRegistro',idReg],['cPagina',cPagina],['idActor',idActor],['estado',estado],['versionRegistro','<?php echo $nVersion?>']];

    }
    enviarFormularioDatos('../modeloProyectos/agregarRevisor.php',arrParam);
}
*/
function comenzarRevision(idReg)
{
	var autores=Ext.getCmp('autores');
    var idFormulario=gE('idFormulario').value;
    var idActor=gE('actor').value;
    var idReferencia=gE('idRegistro').value;
	if(autores.getStore().getCount()==0)
    {
    	msgBox('Al menos debe asignar un revisor al proceso');
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
                	var fila=gE('tblRevisores_'+idReg);
                    fila.parentNode.removeChild(fila);
                    var x;
                    for(x=0;x<autores.getStore().getCount();x++)
                    {
                    	var fReg=autores.getStore().getAt(x);
                        fReg.set('situacion','1');
                    }
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=84&estado=1&id='+idReg+'&idFormulario='+idFormulario+'&idReferencia='+idReferencia+'&idActor='+idActor,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer comenzar el proceso de validaci&oacute;n por parte de los autores?',resp);
}

function mostrarVentanaMiembroComite()
{
	var nComite=gE('nComite').value;
	var gridMiembros=crearGridMiembroComite();
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione los miembros que desee asignar como revisor:'
                                                        },
                                                        gridMiembros

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Miembros del <?php echo $lblComiteS?>: '+nComite,
										width: 710,
										height:390,
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
																		
                                                                        var fRevisores=gridMiembros.getSelectionModel().getSelections();
                                                                        if(fRevisores.length==0)
                                                                        {
                                                                        
                                                                        	msgBox('Debe seleccionar al menos a un miembro para asignar como revisor');
	                                                                        return;
                                                                        }
                                                                        var listAutores=obtenerListadoArregloFilas(fRevisores,'idUsuario');
                                                                        agregarMiembroComite(listAutores);
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

    
    obtenerMiembrosComite(ventanaAM);
    
}

function crearGridMiembroComite()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idUsuario'},
                                                                {name: 'miembro'},
                                                                {name: 'rolComite'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Miembro',
															width:250,
															sortable:true,
															dataIndex:'miembro'
														},
														{
															header:'Rol <?php echo $lblComiteS?>',
															width:330,
															sortable:true,
															dataIndex:'rolComite'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridMiembros',
                                                            x:10,
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:670,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function obtenerMiembrosComite(ventana)
{
	var idComite=gE('idComite').value;
    var idFormulario=gE('idFormulario').value;
    var idReferencia=gE('idRegistro').value;
    var etapaReg=<?php echo $nVersion?>;
    var idActor=<?php echo $idActor?>;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gEx('gridMiembros').getStore().loadData(eval(arrResp[1]));
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=215&idActor='+idActor+'&etapaReg='+etapaReg+'&idComite='+idComite+'&idFormulario='+idFormulario+'&idReferencia='+idReferencia,true);

}

function agregarMiembroComite(idAutor)
{
	var idActor=gE('actor').value;
	var estado=gE('eDictamen').value;
    var idFormulario=gE('idFormulario').value;
    var idReferencia=gE('idRegistro').value;
	var cmbFormatoEval=gE('cmbFormatoEval');
    var idFormatoEval=cmbFormatoEval.options[cmbFormatoEval.selectedIndex].value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
	       recargarPagina()
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=81&idFormularioEval='+idFormatoEval+'&mRevisores=1&versionRegistro=<?php echo $nVersion?>&idAutor='+idAutor+'&idFormulario='+idFormulario+'&idRegistro='+idReferencia+'&idActor='+idActor+'&estado='+estado,true);
}

function asignarMiembroPresentador(ctrl)
{
	var idAutor=ctrl.options[ctrl.selectedIndex].value;
	var idActor=gE('actor').value;
	var idFormulario=gE('idFormulario').value;
    var idReferencia=gE('idRegistro').value;
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=216&versionRegistro=<?php echo $nVersion?>&idAutor='+idAutor+'&idFormulario='+idFormulario+'&idRegistro='+idReferencia+'&idActor='+idActor,true);
}

function registrarNuevoRevisor()
{
    var cPagina=gE('cPagina').value;
    var arrParam;
    var idActor=gE('actor').value;
    var versionRegistro=gE('nVersion').value;
    if(cPagina=='')
    {
        tb_show(lblAplicacion,'../modeloProyectos/agregarRevisor.php?versionRegistro='+versionRegistro+'&idActor='+(idActor)+'&idFormulario='+bE(idForm)+'&idRegistro='+bE(idReg)+'&TB_iframe=true&height=530&width=900',"","scrolling=yes",recargarPaginaAutores);
    }
    else
    {
        tb_show(lblAplicacion,'../modeloProyectos/agregarRevisor.php?versionRegistro='+versionRegistro+'&idActor='+(idActor)+'&cPagina='+cPagina+'&idFormulario='+bE(idForm)+'&idRegistro='+bE(idReg)+'&TB_iframe=true&height=530&width=900',"","scrolling=yes",recargarPaginaAutores);
    
    }
}

function recargarPaginaAutores(cerrarThick)
{
	
	recargarPagina();
}


function mostrarVentanaComentarios(iU)
{
	
    if(gE('sL')=='1')
    	ocultarBtn=true;
	var gridComentarios=crearGridComentarios(iU);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridComentarios

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Comentarios',
										width: 750,
										height:470,
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

function crearGridComentarios(iU)
{
	var lector= new Ext.data.JsonReader({
                                            idProperty:'idComentarioSeccion',
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idComentarioSeccion'},
                                                        {name: 'fechaComentario', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'comentario'},
                                                        {name: 'seccion'}
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
                                                            sortInfo: {field: 'fechaComentario', direction: 'DESC'},
                                                            groupField: 'seccion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        })     
        
        
        alDatos.on('beforeload',function(proxy)
                                        {
                                            proxy.baseParams.funcion=242;
                                            proxy.baseParams.idRegistro=<?php echo $idRegistro?>;
                                            proxy.baseParams.idFormularioBase=<?php echo $idFormulario?>;
                                            proxy.baseParams.idUsuario=bD(iU);
                                            proxy.baseParams.actor=-<?php echo $idActor?>;
                                            proxy.baseParams.version=<?php echo $nVersion?>;
                                            
                                            
                                        }
                            )
		
        
        var expander = new Ext.ux.grid.RowExpander({
                                                column:3,
                                                tpl : new Ext.Template(
                                                    '<table ><tr><td  width="100%" style="text-align: justify" ><br>{comentario}</td></tr></table>'
                                                )
                                            });
                                    
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            expander,
                                                            {
                                                                header:'Fecha comentario',
                                                                width:120,
                                                                sortable:true,
                                                                align:'left',
                                                                dataIndex:'fechaComentario',
                                                                renderer:formatearfechaColor
                                                            },
                                                            {
                                                                header:'Comentario',
                                                                width:500,
                                                                sortable:true,
                                                                align:'left',
                                                                dataIndex:'comentario'
                                                            },
                                                            {
                                                                header:'Secci&oacute;n',
                                                                width:550,
                                                                sortable:true,
                                                                align:'right',
                                                                dataIndex:'seccion'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridComentarios',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:true,
                                                                cm: cModelo,
                                                                height:390,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                plugins:[expander],
                                                                view: new Ext.grid.GroupingView(	{
                                                                                                        forceFit:false,
                                                                                                        showGroupName: true,
                                                                                                        enableNoGroups:false,
                                                                                                        enableGroupingMenu:true,
                                                                                                        hideGroupedColumn: true
                                                                                                    }   
                                                                                                )
                                                            }
                                                        );
        return 	tblGrid;	
}

function formatearfechaColor(value, p, record)
{
	return '<span class="letraRojaSubrayada8">'+formatearfecha(value, p, record)+'</span>';
}

function formatearFila(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;
    p.body = '<BR><p style="margin-left: 2em;margin-right: 3em;text-align:justify"><span class="copyrigthSinPaddingNegro">&nbsp;' + (xf.stripTags(record.data.comentario)) + '</span></p>';
    return 'x-grid3-row-expanded';
}