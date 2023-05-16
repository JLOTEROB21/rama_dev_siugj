<?php session_start();
	include("configurarIdiomaJS.php"); 
	include_once("diccionarioTerminos.php");


	if(isset($_GET["idUsuario"]))
		$idUsuario=$_GET["idUsuario"];
	else
		$idUsuario="-1";

	$consultaCiclo="SELECT idCiclo,nombreCiclo FROM 4526_ciclosEscolares ORDER BY nombreCiclo";
	$arregloCiclo=$con->obtenerFilasArreglo($consultaCiclo);
	
	$consultaSituacion="SELECT idEstadoAlumno,estado FROM 4119_estadosAlumno ORDER BY idEstadoAlumno";
	$arregloSituacion=$con->obtenerFilasArreglo($consultaSituacion);
	$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE unidadPadre='0001' AND institucion=1 ORDER BY unidad";
	$arrSedes=$con->obtenerFilasArreglo($consulta);
?>
var arrSedes=<?php echo $arrSedes?>;
Ext.onReady(inicializar);
var idEsquemaGrupo=-1;
var idInstanciaSel=-1;
function inicializar()
{
    crearGrid();
}

function obtenerProgramas(combo,registro)
{
	Ext.getCmp('cmbProgramas').reset();
    Ext.getCmp('cmbGrados').reset();
    Ext.getCmp('cmbGrados').getStore().removeAll();
    Ext.getCmp('cmbGrupos').reset();
    Ext.getCmp('cmbGrupos').getStore().removeAll();
	var idCiclo=registro.get('id');
    idCiclo='{"idCiclo":"'+idCiclo+'"}';
    function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
        	var arrDatos=eval(arrResp[1]);
            var tamano=arrDatos.length;
            
              Ext.getCmp('cmbProgramas').getStore().loadData(arrDatos);
              Ext.getCmp('cmbProgramas').show();
              Ext.getCmp('lblPrograma').show();
		}
		else
		{
     		Ext.getCmp('cmbProgramas').hide();
        	Ext.getCmp('lblPrograma').hide();
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesHorarios.php',funcAjax, 'POST','funcion=2&param='+cv(idCiclo),true);
}


function obtenerGrados(combo,registro)
{
	Ext.getCmp('cmbGrados').reset();
    Ext.getCmp('cmbGrupos').reset();
    Ext.getCmp('cmbGrupos').getStore().removeAll();
    var idPrograma=registro.get('id');
    idInstanciaSel=idPrograma;
    combo.setRawValue(registro.get('valorComp'));
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
        	var arrDatos=eval(arrResp[1]);
            Ext.getCmp('cmbGrados').getStore().loadData(arrDatos);
            idEsquemaGrupo=arrResp[2];
            if(idEsquemaGrupo=='1')
            {
            	gEx('cmbGrupos').hide();
                gEx('lblGrupos').hide();
            }
            else
            {
            	gEx('cmbGrupos').show();
                gEx('lblGrupos').show();
            }
              
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=11&idInstanciaPlanEstudio='+idPrograma,true);
}

function obtenerGrupos(combo,registro)
{
	Ext.getCmp('cmbGrupos').reset();
    
	if(idEsquemaGrupo=='1')
    	return;
    var idInstancia=idInstanciaSel;
    var idCiclo=Ext.getCmp('cmbCiclo').getValue();
    
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
        	var arrDatos=eval(arrResp[1]);
            var tamano=arrDatos.length;
            Ext.getCmp('cmbGrupos').getStore().loadData(arrDatos);
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=12&idInstancia='+idInstancia+'&ciclo='+idCiclo,true);
}


function validarFrm(form)
{
	if(validarFormularios(form))
    {
    	gE(form).submit();
    }
}

function regresar(usr)
{
	var arrParam=[['idUsuario',usr]];
	enviarFormularioDatos('intermediaMostrar.php',arrParam);	
}

function mostrarFichaMedica(idUsr)
{
	TB_show(lblAplicacion,'../Usuarios/fichaMedica.php?idAlumno='+idUsr+'&TB_iframe=true&height=550&width=840',"");

}

function recargar()
{
	var idUsuario=gE('idUsuario').value;
    var idCiclo=gE('idCiclo').value;
    var arrParam=[['idUsuario',idUsuario],['idCiclo',idCiclo]];
	enviarFormularioDatos('datosAlumnos.php',arrParam);	
}

function desvincular(idCiclo,idPrograma,idGrado,idGrupo,situacion)
{
	var idUsuario=<?php echo $idUsuario ?>;
    //var comboP=gE('idSeccion');
//    var idPrograma=comboP.options[comboP.selectedIndex].value;
//	
//    var comboC=gE('idCiclo');
//    var idCiclo=comboC.options[comboC.selectedIndex].value;
//    if(idCiclo=='-1')
//    { 
//     	Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar un ciclo');
//        return;
//    }
//    
//    if(idPrograma=='-1')
//    { 
//     	Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar una secci&oacute;n');
//        return;
//    }
    
	function respPregunta(btn)
    {
        if(btn=='yes')
        {
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    recargarPagina();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=100&idPrograma='+idPrograma+'&idCiclo='+idCiclo+'&idUsuario='+idUsuario,true);
         }
    }  
    Ext.MessageBox.confirm(lblAplicacion,'Esta acci&oacute;n borrara toda la informacion del alumno realacionada con este programa y ciclo<br />Est&aacute; seguro de querer eliminar este registro',respPregunta); 
}

function crearGrid()
{
    var lector= new Ext.data.JsonReader({

                                            totalProperty :'numReg',
                                            fields: [
                                            			{name: 'idAlumnoTabla'},
                                               			{name: 'nombreCiclo', type:'int'},
                                                        {name: 'nombrePlanEstudios'},
                                                        {name: 'leyendaGrado'},
                                                        {name: 'nombreGrupo'},
                                                        {name: 'nombreStatus'}
		                                            ],
                                            root:'registros',
                                            remoteGroup:false,
                                            remoteSort: true
                                        }
                                      );
                                      
	var alDatos=new Ext.data.GroupingStore({
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(
                                                                                  {
                                                                                      url: '../paginasFunciones/funcionesProgramaAcademicoV2.php'
                                                                                      
                                                                                  }

                                                                              ),
                                                sortInfo: {field: 'nombreCiclo', direction: 'DESC'},
                                                groupField: 'nombrePlanEstudios',
                                                autoLoad:true,
                                                remoteSort: true
                                            })     

	alDatos.setDefaultSort('nombreCiclo', 'DESC');
    
    alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion=44;
                                        proxy.baseParams.idUsuario='<?php echo $idUsuario?>';

                                    }
				)	
    
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Ciclo',
															width:100,
															sortable:true,
															dataIndex:'nombreCiclo'
														},
                                                        {
															header:'<?php echo $dic["planEstudio"]["s"]["et"]?>',
															width:220,
															sortable:true,
															dataIndex:'nombrePlanEstudios'
														},
                                                        {
															header:'Grado',
															width:150,
															sortable:true,
															dataIndex:'leyendaGrado'
														},
                                                        {
															header:'Grupo',
															width:140,
															sortable:true,
															dataIndex:'nombreGrupo'
														},
                                                        {
															header:'Situaci&oacute;n',
															width:140,
															sortable:true,
															dataIndex:'nombreStatus'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridHistorial',
                                                            store:alDatos,
                                                            title:'Historial de alumnos',
                                                            frame:true,
                                                            renderTo:'gridPresupuesto',
                                                            cm: cModelo,
                                                            height:460,
                                                            width:850,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines :true,
                                                            view: new Ext.grid.GroupingView(	{
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:true,
                                                                                                    hideGroupedColumn: true
                                                                                            	}   
                                                                                            ),
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar Registro',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function(registro)
                                                                            	{
                                                                                    agregarRegistro(1);
                                                                                }
                                                                        },
                                                                        
                                                                        {
                                                                        	text:'Remover Registro',
                                                                            icon:'../images/cancel_round.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            	{
                                                                                	
                                                                                    var modeloSel=tblGrid.getSelectionModel();
                                                                                    var fila=modeloSel.getSelected();
                                                                                    
                                                                                    if(fila==null)
                                                                                    {
                                                                                    	msgBox('Debe seleccionar el registro que desea eliminar');
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
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProgramaAcademicoV2.php',funcAjax, 'POST','funcion=47&idAlumnoTabla='+fila.get('idAlumnoTabla'),true);
                                                                                       }

                                                                                    	
                                                                                    }
                                                                                    msgConfirm('Est&aacute; seguro de querer eliminar el registro seleccionado?',resp);
                                                                                    
                                                                                    
                                                                                    
                                                                                }
                                                                        }
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}

function agregarRegistro(bandera)
{
	var cmbCiclo=crearComboExt('cmbCiclo',<?php echo $arregloCiclo ?>,110,5,110);
    var cmbSede=crearComboExt('cmbSede',arrSedes,110,35,350);
    cmbSede.on('select',function(cmb,registro)
    					{
                        		Ext.getCmp('cmbProgramas').reset();
                                Ext.getCmp('cmbProgramas').getStore().removeAll();
                                Ext.getCmp('cmbGrados').reset();
                                Ext.getCmp('cmbGrados').getStore().removeAll();
                                Ext.getCmp('cmbGrupos').reset();
                                Ext.getCmp('cmbGrupos').getStore().removeAll();
                        	function funcAjax()
                            {
                                var resp=peticion_http.responseText;
                                arrResp=resp.split('|');
                                if(arrResp[0]=='1')
                                {
                                    cmbProgramas.getStore().loadData(eval(arrResp[1]));
                                }
                                else
                                {
                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                }
                            }
                            obtenerDatosWeb('../paginasFunciones/funcionesProgramaAcademicoV2.php',funcAjax, 'POST','funcion=45&plantel='+registro.get('id'),true);

                        }
    			)
    var cmbProgramas=crearComboExt('cmbProgramas',[],110,65,350);
    cmbProgramas.on('select',obtenerGrados);
    
    var cmbGrados=crearComboExt('cmbGrados',[],110,95);
    cmbGrados.on('select',obtenerGrupos);
    
    var cmbGrupos=crearComboExt('cmbGrupos',[],110,125);
    
    
    
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
                                                             html:'Ciclo:'
                                                         },
                                                     	cmbCiclo,
                                                        {
                                                             x:10,
                                                             y:40,
                                                             xtype:'label',
                                                             html:'Sede:'
                                                         },
                                                     	cmbSede,
                                                     	{
                                                             x:10,
                                                             y:70,
                                                             xtype:'label',
                                                             id:'lblPrograma',
                                                             html:'<?php echo $dic["planEstudio"]["s"]["et"] ?>:'
	                                                     },
                                                     	cmbProgramas,
                                                     	{
                                                             x:10,
                                                             y:100,
                                                             xtype:'label',
                                                             id:'lblGrado',
                                                             html:'Grado:'
	                                                     },
														 cmbGrados,
            	                                         {
        	    	                                         x:10,
                                                             y:130,
                                                             xtype:'label',
                                                             id:'lblGrupos',
                                                             html:'Grupo:'
                                                         },
                                                     	cmbGrupos
                                                         
													]
										}
									);
	var ventana = new Ext.Window(
									{
										title: 'Inscribir alumno a <?php echo $dic["grado"]["s"]["et"] ?>',
										width: 500,
										height:280,
										minWidth: 300,
										minHeight: 100,
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
															text: 'Aceptar',
															listeners:	{
																			click:function()
																				{
																					  var idCiclo=Ext.getCmp('cmbCiclo').getValue();
                                                                                      if(idCiclo=='')
                                                                                      {
                                                                                      
                                                                                          msgBox('Debe indicar el ciclo al cual inscribir&aacute; al alumnos');
                                                                                          return;
                                                                                      
                                                                                      }
																					  
                                                                                      var idPrograma=Ext.getCmp('cmbProgramas').getValue();
                                                                                      if(idPrograma=='')
                                                                                      {
                                                                                          msgBox('Debe seleccionar <?php echo strtolower($dic["planEstudio"]["s"]["el"]." ".$dic["planEstudio"]["s"]["et"]) ?> al cual inscribir&aacute; el alumno');
                                                                                          return;
                                                                                      
                                                                                      }

																					  var idGrado=Ext.getCmp('cmbGrados').getValue();
                                                                                      if(idGrado=='')
                                                                                      {
                                                                                          msgBox('Debe indicar  <?php echo strtolower($dic["grado"]["s"]["el"]." ".$dic["grado"]["s"]["et"]) ?> al cual inscribir&aacute; el alumno');
                                                                                          return;
                                                                                      
                                                                                      }
                                                                                      
                                                                                      var idGrupo='';
                                                                                      if(idEsquemaGrupo=='2')
                                                                                      {
                                                                                          var idGrupo=Ext.getCmp('cmbGrupos').getValue();
                                                                                          if(idGrupo=='')
                                                                                          {
                                                                                              msgBox('Debe indicar  <?php echo strtolower($dic["grupo"]["s"]["el"]." ".$dic["grupo"]["s"]["et"]) ?> al cual inscribir&aacute; el alumno');
	                                                                                          return;
                                                                                          }
																					  }                 
                                                                                      
                                                                                      var obj='{"idAlumno":"<?php echo $idUsuario?>","idCiclo":"'+idCiclo+'","idInstanciaPlanEstudio":"'+idInstanciaSel+'","idGrado":"'+idGrado+'","idGrupo":"'+idGrupo+'","idEsquemaGrupo":"'+idEsquemaGrupo+'"}';                                                                    
                                                                                      function funcAjax()
                                                                                        {
                                                                                            var resp=peticion_http.responseText;
                                                                                            arrResp=resp.split('|');
                                                                                            if(arrResp[0]=='1')
                                                                                            {
                                                                                                gEx('gridHistorial').getStore().reload();
                                                                                                ventana.close();
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProgramaAcademicoV2.php',funcAjax, 'POST','funcion=46&cadObj='+obj,true);

                                                                                      
																				}
																		}
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		ventana.close();
																	}
														}
													]
									}
								);
		//llenarMotivo(ventana,idMateria,horaInicio,horaFin,fecha,noSesion,idGrupo)
        ventana.show();
}