<?php
	session_start();
	include("configurarIdiomaJS.php");
	
	
	
?>

ignorarOFB=false;

Ext.onReady(inicializar);

function inicializar()
{
	gE('_nombreFormulariovch').focus();

//    lanzarEvento(gE('_asociadoProcesoint'),'change');
	var _idFrmEntidadint=gE('_idFrmEntidadint');
	if(_idFrmEntidadint.selectedIndex!=0)
	    lanzarEvento(gE('_idFrmEntidadint'),'change');
    lanzarEvento(gE('_formularioBaseint'),'change');
    
	ignorarOFB=false;
}

function setEstadoInicial()
{
	var cmbEtapa=gE('_idEtapaint');
    var idEtapa=cmbEtapa.options[cmbEtapa.selectedIndex].value;
    var cmbPrincipal=gE('_formularioBaseint');
    var idPrincipal=cmbPrincipal.options[cmbPrincipal.selectedIndex].value;
    var hInicio=gE('_estadoInicialint');
    if((idEtapa!='-1')&&(idPrincipal=='1'))
    	hInicio.value=idEtapa;
    else
    	hInicio.value='0';
    
}

function validarFormulario(idFormulario)
{
	if(validarFormularios(idFormulario))
    {
    	var campoDictamen=gE('campoDictamen');
        if(campoDictamen!=null)
        {
        	var valor=campoDictamen.options[campoDictamen.selectedIndex].value;
            if(valor=='-1')
            {
            	function resp()
                {
                	campoDictamen.focus();
                }
            	msgBox('Debe indicar cual ser&aacute; el campo que contendr&aacute; el resultado del dict&aacute;men',resp);
            	return;
            }
            
            var campoComentario=gE('campoComentario');
            valor=campoComentario.options[campoComentario.selectedIndex].value;
            if(valor=='-1')
            {
            	function resp2()
                {
                	campoComentario.focus();
                }
            	msgBox('Debe indicar cual ser&aacute; el campo que contendr&aacute; el comentario del dict&aacute;men',resp2);
            	return;
            }
            var _configuracionFormulariovch=gE('_configuracionFormulariovch');
            var cadObj=bD(_configuracionFormulariovch.value);
            if(cadObj=='')
            {
            	_configuracionFormulariovch.value='{"campoDictamen":"'+campoDictamen.options[campoDictamen.selectedIndex].value+'","campoComentario":"'+campoComentario.options[campoComentario.selectedIndex].value+'"}';
            }
            else
            {
            	cadObj=setAtributoCadJson(cadObj,'campoDictamen',campoDictamen.options[campoDictamen.selectedIndex].value);
                cadObj=setAtributoCadJson(cadObj,'campoComentario',campoComentario.options[campoComentario.selectedIndex].value);
                _configuracionFormulariovch.value=cadObj;
                
            }
            
        }
    	gE(idFormulario).submit();
    }
}



function configurarGridAdmon(idFormulario)
{
	gE('idFormulario').value=idFormulario;
   	gE('frmConfFormulario').action='configurarGrid.php';
   	gE('frmConfFormulario').submit();
}

function configurarGantt(idFormulario)
{
	gE('idFormulario').value=idFormulario;
   	gE('frmConfFormulario').action='configurarGantt.php';
   	gE('frmConfFormulario').submit();
}

function cambioAsociado(combo)
{
	valor=combo.options[combo.selectedIndex].value;
    var proceso=gE('_idProcesoint');
    var etapa=gE('_idEtapaint');
    var principal=gE('_formularioBaseint');
    if(valor==0)
    {
    	oE('filaProceso');
        oE('filaEtapa');
        oE('filaFormularioPrincipal');
        proceso.removeAttribute('val');
        etapa.removeAttribute('val');
        principal.removeAttribute('val');
        selElemCombo(proceso,'-1');
        selElemCombo(principal,'-1');
        
    }
    else
    {
    	mE('filaProceso');
        mE('filaEtapa');
        if(!ignorarOFB)
	        mE('filaFormularioPrincipal');
        proceso.setAttribute('val','obl');
        etapa.setAttribute('val','obl');
        principal.setAttribute('val','obl');
    }
}

function formularioPrincipal(combo)
{
	valor=combo.options[combo.selectedIndex].value;
    var frmEntidad=gE('_idFrmEntidadint');
    var frmRepetible=gE('_frmRepetibleint');
    if(valor=='1')
    {
    	dE('_idFrmEntidadint');
        selElemCombo(frmEntidad,'-1');

    }
    else
    {
    	hE('_idFrmEntidadint');

    }
    setEstadoInicial();
    
	verificarListadoRegistros();
    
}

function regresar()
{
	gE('frmRegresarForm').submit()
}


function llenarEtapas(combo)
{
	idProceso=combo.options[combo.selectedIndex].value;
    function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	var arrOpciones=eval(arrResp[1]);
            var comboD=gE('_idEtapaint');
            limpiarCombo(comboD);
            var numOpt=arrOpciones.length;
            var x;
            var opt;
            var ct=0;
            
            for(x=0;x<numOpt;x++)
            {
            	opt=document.createElement('option');
                opt.value=arrOpciones[x][0];
                opt.text=arrOpciones[x][1];
                comboD.options[x]=opt;
            }
            if(arrResp[2]=='1')
            {
            	oE('filaFormularioPrincipal');
                var combo=gE('_formularioBaseint');
                selElemCombo(combo,'-1');
            }
            else
            {
            	mE('filaFormularioPrincipal');
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=17&idProcesoPadre='+idProceso,true);
    
    
}

function accionRepetible(combo)
{
	var valor=combo.options[combo.selectedIndex].value;
    if(valor=='-1')
    {
    	//oE('filaRepetible');
        gE('_frmRepetibleint').removeAttribute('val');
        selElemCombo(gE('_frmRepetibleint'),'-1');
    }
    else
    {
    	//mE('filaRepetible');
        gE('_frmRepetibleint').setAttribute('val','obl');
    }
}

function enviarListadoConf(idFormulario)
{
	var arrParam=[['idFormulario',idFormulario]];
	enviarFormularioDatos('../modeloPerfiles/configurarGrid.php',arrParam);
}

function configurarCuestionario(idFormulario)
{

    var arrParam=[['idFormulario',idFormulario]];
    
    if((!window.parent)||(gE('redireccionarFormulario').value=='1'))
		enviarFormularioDatos('../thotFormularios/thotConfigurarFormulario.php',arrParam);
    else
    {
    	arrParam.push(['vistaIframe','1']);
    	var obj={};
        obj.params=arrParam;
        obj.ancho='100%';
        obj.alto='100%';
        obj.modal=true;
        obj.url='../thotFormularios/thotConfigurarFormulario.php';
        window.parent.abrirVentanaFancy(obj);
    }
}

function configurarVistaFormulario(idFormulario)
{
	var arrParam=[['idFormulario',idFormulario]];
	 if((!window.parent)||(gE('redireccionarFormulario').value=='1'))
		enviarFormularioDatos('../modeloPerfiles/configurarVistaFormulario.php',arrParam);
    else
    {
    	arrParam.push(['vistaIframe','1']);
        arrParam.push(['cPagina','sFrm=true']);
    	var obj={};
        obj.params=arrParam;
        obj.ancho='100%';
        obj.alto='100%';
        obj.url='../modeloPerfiles/configurarVistaFormulario.php';
        window.parent.abrirVentanaFancy(obj);
    }
}


function ventanaFolios()
{
	var arrDatos=[['1','Una vez guadado el nuevo registro'],['2','Antes de guardar el nuevo registro']];
    var arrTipoFolio=[['1','Generado a trav\xE9s de configuraci\xF3n manual'],['2','Generado mediante funci\xF3n programada']];
    
    
	var gridFolios=crearGridFolios();
    
    
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
                                                            html:'Tipo de folio:'
                                                        },
                                                        
                                                        {
                                                        	x:150,
                                                            y:10,
                                                            html:'<div id="divComboTipoFolio"></div>'
                                                        }
                                                        ,
                                                        
														gridFolios,
                                                        {
                                                        	x:10,
                                                            y:330,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Asignar folio:'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:325,
                                                            html:'<div id="divComboAsignarFolio"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:380,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Funci&oacute;n generadora de folio:'
                                                        },
                                                        {
                                                        	x:280,
                                                            y:375,
                                                            cls:'controlSIUGJ',
                                                            xtype:'textfield',
                                                            id:'txtFuncion',
                                                            disabled:true,
                                                            width:250
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Administraci&oacute;n de folios',
										width: 930,
										height:530,
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
                                                                	var cmbTipoFolio=crearComboExt('cmbTipoFolio',arrTipoFolio,0,0,450,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoFolio'});
                                                                    cmbTipoFolio.setValue('1');
                                                                    cmbTipoFolio.on('select',function(cmb,registro)
                                                                                            {
                                                                                                 function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        if(registro.get('id')=='1')
                                                                                                        {
                                                                                                            gEx('gridFolios').enable();
                                                                                                            gEx('txtFuncion').disable();
                                                                                                            gEx('btnAceptar').hide();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            gEx('txtFuncion').enable();
                                                                                                            gEx('gridFolios').disable();
                                                                                                            gEx('btnAceptar').show();
                                                                                                        }
                                                                                                       
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=327&tipoFolio='+registro.get('id')+'&idFormulario='+gE('idFrm').value,true);
                                                                                                
                                                                                            }
                                                                                    )
																	var cmbReglaFolio=crearComboExt('cmbReglaFolio',arrDatos,0,0,380,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboAsignarFolio'});
                                                                	cmbReglaFolio.on('select',funcFoliosSelect)
                                                                    llenarFolios(ventanaAM);	
                                                                }
															}
												},
										buttons:	[
                                        				{
															text: 'Cerrar',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
                                                        	id:'btnAceptar',
															text: 'Aceptar',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler:function()
																	{
																		var txtFuncion=gEx('txtFuncion');
                                                                        if(txtFuncion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtFuncion.focus();
                                                                            }
                                                                            msgConfirm('Debe indicar el nombre de la funci&oacute;n que generar&aacute; el folio de los registros:',resp);
                                                                            return; 
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=326&idFormulario='+gE('idFrm').value+'&nombreFuncion='+txtFuncion.getValue(),true);
																	}
														}
														
													]
									}
								);
	
	ventanaAM.show();
}

function funcFoliosSelect(combo,registro)
{
	var idFormulario=gE('idFrm').value;
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=140&idFormulario='+idFormulario+'&idRegla='+registro.get('id'),true);

}


function llenarFolios(ventana)
{
	var idFormulario=gE('idFrm').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var cadDatos=arrResp[1];
            var arrDatos=eval(cadDatos);
            var gridFolios=Ext.getCmp('gridFolios');
            gridFolios.getStore().loadData(arrDatos);
            var cmbReglaFolio=Ext.getCmp('cmbReglaFolio');
            cmbReglaFolio.setValue(parseInt(arrResp[2]));
            gEx('cmbTipoFolio').setValue(arrResp[3]);
            gEx('txtFuncion').setValue(arrResp[4]);
            if(arrResp[3]=='1')
            {
                gEx('gridFolios').enable();
                gEx('txtFuncion').disable();
                gEx('btnAceptar').hide();
            }
            else
            {
                gEx('txtFuncion').enable();
                gEx('gridFolios').disable();
                gEx('btnAceptar').show();
            }
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=137&idFormulario='+idFormulario,true);
    
}

var rFolios=crearRegistro	(
								[
                                    {name: 'idFolio'},
                                    {name: 'prefijo'},
                                    {name: 'separador'},
                                    {name: 'longitud'},
                                    {name: 'incremento'},
                                    {name: 'inicio'},
                                    {name: 'numActual'},
                                    {name: 'activo'}
                                ]
							);

function crearGridFolios()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idFolio'},
                                                                    {name: 'prefijo'},
                                                                    {name: 'separador'},
                                                                    {name: 'longitud'},
                                                                    {name: 'incremento'},
                                                                    {name: 'inicio'},
                                                                    {name: 'numActual'},
                                                                    {name: 'activo'}
                                                                    
                                                                    
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: 'Activo',
													   dataIndex: 'activo',
													   width: 100,
                                                       renderer:function(val)
                                                       			{
                                                                	if(val)
	                                                                	return 'S&iacute;';
                                                                     return 'No';
                                                                }
													}
												);
	
    var editorFila=new Ext.ux.grid.RowEditor	(
    												{
                                                        saveText: 'Guardar',
                                                        cancelText:'Cancelar',
                                                        minButtonWidth:140,
                                                        clicksToEdit:2
                                                    }
                                                );
    
    editorFila.on('validateedit',funcEditorValida);
    editorFila.on('canceledit',funcEditorCancelEdit);
    
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														{
															header:'Prefijo',
															width:110,
															sortable:true,
															dataIndex:'prefijo',
                                                            editor:new Ext.form.TextField	(
                                                            									{
                                                                                                	cls:'controlSIUGJ'
                                                                                                }
                                                            								)
                                                            
														},
														{
															header:'Separador',
															width:110,
															sortable:true,
															dataIndex:'separador',
                                                             editor:new Ext.form.TextField	(
                                                            									{
                                                                                                	cls:'controlSIUGJ'
                                                                                                }
                                                            								)
														},
														{
															header:'Longitud',
															width:110,
															sortable:true,
															dataIndex:'longitud',
                                                            editor:new Ext.form.NumberField	(
                                                            									{
                                                                                                	id:'txtLongitud',
                                                                                                    cls:'controlSIUGJ',
                                                                                                    allowDecimals:false,
                                                                                                    allowNegative:false
                                                                                                }
                                                            								)
														},
														{
															header:'Incremento',
															width:140,
															sortable:true,
															dataIndex:'incremento',
                                                            editor:new Ext.form.NumberField	(
                                                            									{
                                                                                                	id:'txtIncremento',
                                                                                                    cls:'controlSIUGJ',
                                                                                                    allowDecimals:false,
                                                                                                    allowNegative:false
                                                                                                }
                                                            								)
														},
														{
															header:'No. inicial',
															width:110,
															sortable:true,
															dataIndex:'inicio',
                                                            editor:new Ext.form.NumberField	(
                                                            									{
                                                                                                	id:'txtInicio',
                                                                                                    cls:'controlSIUGJ',
                                                                                                    allowDecimals:false,
                                                                                                    allowNegative:false
                                                                                                }
                                                            								)
														},
														{
															header:'No. actual',
															width:110,
															sortable:true,
															dataIndex:'numActual',
                                                            editor:new Ext.form.NumberField	(
                                                            									{
                                                                                                	id:'txtActual',
                                                                                                    cls:'controlSIUGJ',
                                                                                                    allowDecimals:false,
                                                                                                    allowNegative:false
                                                                                                }
                                                            								)
														},
                                                        checkColumn
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridFolios',
                                                            store:alDatos,
                                                            stripeRows :false,
                                                            
                                                            columnLines : false,
                                                            frame:false,
                                                            x:10,
                                                            y:60,
                                                            cm: cModelo,
                                                            height:240,
                                                            width:900,
                                                            cls:'gridSiugjFormularios',
                                                            plugins:[checkColumn,editorFila],
                                                            tbar:	[		
                                                            			{
                                                                        	id:'btnAgregar',
                                                                        	text:'Nuevo folio',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                        	handler:function()
                                                                            		{
                                                                                    	var estado=false;
                                                                                        if(tblGrid.getStore().getCount()==0)
                                                                                        	estado=true;
                                                                                    	var r=new rFolios	(
                                                                                                                {
                                                                                                                    idFolio:'-1',
                                                                                                                    prefijo:'',
                                                                                                                    separador:'',
                                                                                                                    longitud:'4',
                                                                                                                    incremento:'1',
                                                                                                                    inicio:'1',
                                                                                                                    numActual:'1',
                                                                                                                    activo:estado
                                                                                                                }
                                                                                                            )
                                                                                        nuevoReg=true;
                                                                                        editorFila.stopEditing();
                                                                                        tblGrid.getStore().add(r);
                                                                                        editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                        Ext.getCmp('btnAgregar').disable();
                                                                                        Ext.getCmp('btnRemover').disable();
                                                                                    }
                                                                        },
                                                                        {
                                                                        	id:'btnRemover',
                                                                        	text:'Eliminar folio',
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                        	handler:function()
                                                                            		{
                                                                                    	var arrCelda=tblGrid.getSelectionModel().getSelectedCell();
                                                                                        if(arrCelda==null)
                                                                                        {
                                                                                        	
                                                                                        	msgBox('Debe seleccionar el folio a remover');
                                                                                            return;
                                                                                        }
                                                                                        var fila=tblGrid.getStore().getAt(arrCelda[0]);
                                                                                        
                                                                                        if(fila.get('activo'))
                                                                                        {
                                                                                        	msgBox('No puede remover un folio marcado como activo');
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
                                                                                                    	tblGrid.getStore().remove(fila);
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=138&idFolio='+fila.get('idFolio'),true);
                                                                                                
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el folio seleccionado?',resp)
                                                                                        
                                                                                    }
                                                                        }
                                                            		]
                                                        }
                                                    );
	tblGrid.on('beforeedit',funcAntesEditar);                                                    
	return 	tblGrid;		
}

function funcAntesEditar(e)
{
	var idFormulario=gE('idFrm').value;
	if(e.field=='activo')
    {
    	if(e.value==true)
        {
        	e.cancel=true;
        }
        else
        {
        	e.cancel=true;
            function resp(btn)
            {	
            	if(btn=='yes')
                {
                	var idFolio=e.record.get('idFolio');
                    function funcAjax()
                    {
                        var resp=peticion_http.responseText;
                        arrResp=resp.split('|');
                        if(arrResp[0]=='1')
                        {
                        	var almacen=e.grid.getStore();
                            var x;
                            for(x=0;x<almacen.getCount();x++)
                            {
                                almacen.getAt(x).set('activo',false);
                            }
                            e.record.set('activo',true);
                        }
                        else
                        {
                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                        }
                    }
                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=139&idFormulario='+idFormulario+'&idFolio='+idFolio,true);
                    
                	
                }
            }
            msgConfirm('Est&aacute; seguro de querer activar el folio seleccionado?',resp)
        }
    }
    
}

function funcEditorValida(rowEditor,obj,registro,nFila)
{	
	if(obj.longitud=='')
    {
    	function respLongitud()
        {
        	Ext.getCmp('txtLongitud').focus();
        }
    	msgBox('Debe ingresar la longitud de la secci&oacute;n num&eacute;rica del folio',respLongitud);
        return false;
    }
    if(obj.incremento=='')
    {
    	function respInc()
        {
        	Ext.getCmp('txtIncremento').focus();
        }
    	msgBox('Debe ingresar el incremento del folio',respInc);
        return false;
    }
    if(obj.inicio=='')
    {
    	function respInicio()
        {
        	Ext.getCmp('txtInicio').focus();
        }
    	msgBox('Debe ingresar n&uacute;mero inicial del folio',respInicio);
        return false;
    }
    
    if(obj.numActual=='')
    {
    	function respActual()
        {
        	Ext.getCmp('txtActual').focus();
        }
    	msgBox('Debe ingresar el n&uacute;mero actual del folio',respActual);
        return false;
    }
    var idFormulario=gE('idFrm').value;
    var obj='{"idFolio":"'+registro.get('idFolio')+'","prefijo":"'+cv(obj.prefijo)+'","separador":"'+cv(obj.separador)+'","longitud":"'+obj.longitud+'","incremento":"'+obj.incremento+'","inicio":"'+obj.inicio+'","nActual":"'+obj.numActual+'","idFormulario":"'+idFormulario+'"}';
    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	registro.set('idFolio',arrResp[1]);
            Ext.getCmp('btnAgregar').enable();
		    Ext.getCmp('btnRemover').enable();
            nuevoReg=false;
            Ext.getCmp('gridFolios').getStore().save();
            		
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            Ext.getCmp('btnAgregar').enable();
		    Ext.getCmp('btnRemover').enable();
            Ext.getCmp('gridFolios').getStore().rejectChanges();
            nuevoReg=false;
            return false;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=136&obj='+obj,true);
     
}

var nuevoReg=false;
function funcEditorCancelEdit(rowEdit,obj,registro,nFila)
{
	if(nuevoReg)
    {
    	var grid=Ext.getCmp('gridFolios');
        grid.getStore().removeAt(grid.getStore().getCount()-1);
    }
    Ext.getCmp('btnAgregar').enable();
    Ext.getCmp('btnRemover').enable();
    nuevoReg=false;
}

function perfilesExportacion()
{
	var idFormulario=gE('idFrm').value;
    var arrParam=[['idFormulario',idFormulario]];
    enviarFormularioDatos('../modeloPerfiles/tblPerfilesExportacion.php',arrParam);
    
}


function verificarListadoRegistros()
{
	var _frmRepetibleint=gE('_frmRepetibleint');
    var _formularioBaseint=gE('_formularioBaseint');
	var optFrmRepetible=_frmRepetibleint.options[_frmRepetibleint.selectedIndex].value;
    var optFormularioBase=_formularioBaseint.options[_formularioBaseint.selectedIndex].value;
    
	if((optFrmRepetible=='1')||(optFormularioBase=='1'))
    {
    	gE('tdListadoRegistro').setAttribute('class','opcionesConfiguracionFormulario');
        gE('linkListadoRegistro').setAttribute('style','display:');
    }
    else
    {
    	gE('tdListadoRegistro').setAttribute('class','');
        gE('linkListadoRegistro').setAttribute('style','display:none');
    }
}