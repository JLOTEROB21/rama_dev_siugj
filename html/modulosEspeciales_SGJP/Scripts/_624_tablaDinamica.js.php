<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	$fechaSiguienteActual=date("Y-m-d",strtotime("+1 days",strtotime($fechaActual)));
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica ORDER BY prioridad";
	$arrUnidadGestion=$con->obtenerFilasArreglo($consulta);	
?>	
var arrUnidadGestion=<?php echo $arrUnidadGestion?>;
var idFormulario=<?php echo $idFormulario ?>;
var idRegistro=<?php echo $idRegistro ?>;
var cadenaFuncionValidacion='validarRegistroGuardia';
function inyeccionCodigo()
{
	
    if(esRegistroFormulario())
    {
    	gEx('f_sp_fechaIniciodte').setValue('<?php echo $fechaActual?>');
        gEx('f_sp_fechaIniciodte').fireEvent('change', gEx('f_sp_fechaIniciodte'), gEx('f_sp_fechaIniciodte').getValue());
        gEx('f_sp_fechaIniciodte').fireEvent('select', gEx('f_sp_fechaIniciodte'));
        gEx('f_sp_horaIniciotme').setValue('15:00');
        gEx('f_sp_horaIniciotme').fireEvent('change', gEx('f_sp_horaIniciotme'),gEx('f_sp_horaIniciotme').getValue());
        
        gEx('f_sp_horaFintme').setValue('08:59');
        gEx('f_sp_horaFintme').fireEvent('select', gEx('f_sp_horaFintme'));
		gEx('f_sp_horaFintme').fireEvent('change', gEx('f_sp_horaFintme'),gEx('f_sp_horaFintme').getValue());
        gEx('f_sp_fechaFindte').setValue('<?php echo $fechaSiguienteActual?>');
        gEx('f_sp_fechaFindte').fireEvent('change', gEx('f_sp_fechaFindte'), gEx('f_sp_fechaFindte').getValue());
        gEx('f_sp_fechaFindte').fireEvent('select', gEx('f_sp_fechaFindte'));
		
        
                
	}
    else
    {
    	
    	
    }
    crearGridJuecesGuardia();
}	

function crearGridJuecesGuardia()
{
	gE('sp_9944').innerHTML='';
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idJuez'},
		                                                {name:'nombreJuez'},
		                                                {name:'nombreUnidadGestion'},
                                                        {name:'noJuez'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_formulariosDinamicos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'noJuez', direction: 'ASC'},
                                                            groupField: 'noJuez',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='5';
                                        proxy.baseParams.idFormulario=idFormulario;
                                        proxy.baseParams.idRegistro=idRegistro;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            
                                                            
                                                            {
                                                                header:'No. de Juez',
                                                                width:90,
                                                                sortable:true,
                                                                dataIndex:'noJuez',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Nombre del Juez',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'nombreJuez',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Unidad de Gesti&oacute;n',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'nombreUnidadGestion',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrUnidadGestion,val);
                                                                            }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gJuezcesGuardia',
                                                                store:alDatos,
                                                                width:900,
                                                                height:190,
                                                                renderTo:'sp_9944',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,  
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:!esRegistroFormulario(),
                                                                                text:'Agregar Juez a Guardia',
                                                                                handler:function()
                                                                                        {
                                                                                        	mostrarVentanaAgregarJuez();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover Juez de Guardia',
                                                                                hidden:!esRegistroFormulario(),
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el juez que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	gEx('gJuezcesGuardia').getStore().remove(fila);	
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('¿Est&aacute; seguro de querer remover el juez seleccionado?',resp);
                                                                                        }
                                                                                
                                                                            }
                                                                		],                                                              
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


function recargarGridParticipantes()
{
	gEx('gJuezcesGuardia').getStore().reload();
}

function mostrarVentanaAgregarJuez()
{
	var registroSel=null;	

	 var oConf=	{
    					idCombo:'cmbJuezGuardia',
                        anchoCombo:400,
                        raiz:'registros',
                        posX:130,
                        posY:5,
                        
                        campoDesplegar:'lblEtiqueta',
                        campoID:'idJuez',
                        funcionBusqueda:4,
                        paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_formulariosDinamicos.php',
                        confVista:'<tpl for="."><div class="search-item">{lblEtiqueta}<br></div></tpl>',
                        campos:	[
                                    {name: 'idJuez'},
                                    {name: 'nombreJuez'},
                                    {name: 'nombreUnidadGestion'},
                                    {name: 'noJuez'},
                                    {name: 'idUnidadGestion'},
                                    {name: 'lblEtiqueta'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	registroSel=null;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	registroSel=registro;
                                        
                                    }  
    				};

	var cmbJuezGuardia=crearComboExtAutocompletar(oConf)

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Juez a agregar:'
                                                        },
                                                        cmbJuezGuardia
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Juez a Gurdia',
										width: 650,
										height:120,
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
                                                                	cmbJuezGuardia.focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(!registroSel)
                                                                        {
                                                                        	msgBox('Debe seleccionar el juez que desea agregar a la guardia');
                                                                        	return;
                                                                        }
                                                                        
                                                                         
                                    
                                                                        
                                                                        var reg=crearRegistro	(
                                                                        							[
	                                                                        							{name: 'idJuez'},
                                                                                                        {name:'nombreJuez'},
                                                                                                        {name:'nombreUnidadGestion'},
                                                                                                        {name:'noJuez'}
                                                                        							]
                                                                                                );
                                                                      	var r=new reg	(
                                                                        					{
                                                                                            	idJuez:registroSel.data.idJuez,
                                                                                                nombreJuez:registroSel.data.nombreJuez,
                                                                                                nombreUnidadGestion:registroSel.data.idUnidadGestion,
                                                                                                noJuez:registroSel.data.noJuez
                                                                                            }
                                                                        				);
                                                                        
																		var pos=obtenerPosFila(gEx('gJuezcesGuardia').getStore(),'idJuez',registroSel.data.idJuez);
                                                                        if(pos==-1)
                                                                    		gEx('gJuezcesGuardia').getStore().add(r);
                                                                    
                                                                   		ventanaAM.close();
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

function validarRegistroGuardia()
{
	if(gEx('f_sp_fechaIniciodte').getValue()>gEx('f_sp_fechaFindte').getValue())
    {
    	function resp()
        {
        	gEx('f_sp_fechaIniciodte').focus();
        }
    	msgBox('La fecha de inicio de la guardia NO puede ser mayor que la fecha de t&eacute;rmino',resp)
    	return false;
    }
    
    if(gEx('gJuezcesGuardia').getStore().getCount()==0)
    {
    	msgBox('Almenos debe agregar un juez de guardia');
    	return false;
    }
    
    
    var arrJueces="";
    var o='';
    var gJuezcesGuardia=gEx('gJuezcesGuardia');
    var x;
    var fila;
    for(x=0;x<gJuezcesGuardia.getStore().getCount();x++)
    {
    
        fila=gJuezcesGuardia.getStore().getAt(x);
        
        o='{"idJuez":"'+fila.data.idJuez+'","nombreUnidadGestion":"'+fila.data.nombreUnidadGestion+'","noJuez":"'+fila.data.noJuez+'"}';
        if(arrJueces=="")
            arrJueces=o;
        else
            arrJueces+=','+o;
    }        
    
    var objRegistro='{"arrJueces":['+arrJueces+']}';

    var id=gE('idRegistroG').value;
                        
    if(id=='-1')
    {
    	if(gE('funcPHPEjecutarNuevo').value=='')
	        gE('funcPHPEjecutarNuevo').value=bE('registrarJuecesGuardiaLeyMujeres(@idRegPadre,\''+bE(objRegistro)+'\')');
    	else
    		gE('funcPHPEjecutarNuevo').value=bE(bD(gE('funcPHPEjecutarNuevo').value)+'|'+('registrarJuecesGuardiaLeyMujeres(@idRegPadre,\''+bE(objRegistro)+'\')'));
    }
    else
    {
    
    	if(gE('funcPHPEjecutarModif').value=='')
	        gE('funcPHPEjecutarModif').value=bE('registrarJuecesGuardiaLeyMujeres(@idRegPadre,\''+bE(objRegistro)+'\')');
    	else
    		gE('funcPHPEjecutarModif').value=bE(bD(gE('funcPHPEjecutarModif').value)+'|'+('registrarJuecesGuardiaLeyMujeres(@idRegPadre,\''+bE(objRegistro)+'\')'));
    
        
    }
    

    
    
    return true;
    
}