<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$fechaActual=date("Y-m-d");
	$horaActual=date("H:i");
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica where 
			id__5_tablaDinamica in	(2,4,5,6,100) order by nombreTipo";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);
	$listParteProcesal="";
	$arrParteProcesal="";
	$arrPartes="";
	$res=$con->obtenerFilas($consulta);
	while($filaFigura=mysql_fetch_row($res))
	{
		if($listParteProcesal=="")
			$listParteProcesal=$filaFigura[0];
		else
			$listParteProcesal.=",".$filaFigura[0];
		$consulta="SELECT idDetalle,etiquetaDetalle FROM _5_gDetallesTipo WHERE idReferencia=".$filaFigura[0];
		$arrDetalles=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT idOpcion FROM _5_tiposFiguras WHERE idPadre=".$filaFigura[0];
		$listFiguras=$con->obtenerListaValores($consulta);
		$o="['".$filaFigura[0]."','".cv($filaFigura[1])."',".$arrDetalles.",'".$listFiguras."']";
		if($arrParteProcesal=="")
			$arrParteProcesal=$o;
		else
			$arrParteProcesal.=",".$o;
		
		$o="{
				cls:'x-btn-text-icon',
				text:'".$filaFigura[1]."',
				handler:function()
						{
							agregarParticipante(".$filaFigura[0].",'".cv($filaFigura[1])."');
						}
				
			}";
		if($arrPartes=="")
			$arrPartes=$o;
		else			
			$arrPartes.=",".$o;
	}
	
	
	
	
	
	$arrPartes="[".$arrPartes."]";
	$idActividad=-1;
	
	if($idRegistro==-1)
		$idActividad=generarIDActividad($idFormulario);

	$consulta="SELECT id__35_denominacionDelito,denominacionDelito FROM _35_denominacionDelito ORDER BY denominacionDelito";
	$arrDelitos=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT iFormulario,iRegistro,carpetaExhorto FROM _92_tablaDinamica WHERE id__92_tablaDinamica=".$idRegistro;
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	
	$totalDocumentos=0;
	if($fRegistro[0]==524)
	{
		$consulta="SELECT * FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$fRegistro[0]." AND idRegistro=".$fRegistro[1].
					" and idDocumento not in(SELECT idDocumento FROM 9074_documentosRegistrosProceso WHERE idFormulario=92 AND idRegistro=".$idRegistro.")";
		$resDocumentosBase=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($resDocumentosBase))
		{	
				
			$consulta="INSERT INTO 9074_documentosRegistrosProceso(idFormulario,idRegistro,idDocumento,tipoDocumento) values(92,".$idRegistro.",".
						$fila["idDocumento"].",".$fila["tipoDocumento"].")";
			$con->ejecutarConsulta($consulta);
			registrarDocumentoCarpetaAdministrativa($fRegistro[2],$fila["idDocumento"],92,$idRegistro);
			$totalDocumentos++;
		}
	}
	
?>
var totalDocumentos='<?php echo $totalDocumentos?>';
var arrDelitos=<?php echo $arrDelitos?>;
var fechaActual='<?php echo $fechaActual?>';
var horaActual='<?php echo $horaActual ?>';
var arrTipoFigura=[<?php echo $arrParteProcesal?>];
var arrParteProcesal=arrTipoFigura;
var idActividad=<?php echo $idActividad?>;

function inyeccionCodigo()
{
	arrDelitos.push(['0','OTRO']);    
    if(esRegistroFormulario())
    {
    	loadScript('../modulosEspeciales_SGJP/Scripts/cParticipante.js.php', function()
                                                                            {
                                                                            }
                    )
                    
		loadScript('../Scripts/funcionesAjaxV2.js', function(){});
        if(gE('idRegistroG').value=='-1')
        { 
            gEx('f_sp_fechaRecepciondte').setValue(fechaActual);
            
            gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
    
            
            gEx('f_sp_horaRepepciontme').setValue(horaActual);
            gEx('f_sp_horaRepepciontme').fireEvent('change', gEx('f_sp_horaRepepciontme'), gEx('f_sp_horaRepepciontme').getValue());
            gEN('_idActividadvch')[0].value=idActividad;
        }
        else
        {

        	idActividad=gEN('_idActividadvch')[0].value;
        }      
        gEx('btnAdd_grid_8212').setHandler(mostrarVentanaDelito) ;  
        asignarEvento(gE('opt_chkOtroarr_1'),'click',function()
         												{
                                                        	
                                                        }
                       )
         
         
        lanzarEvento(gE('opt_chkOtroarr_1'),'click');
        
        
        
    }
    else
    {
    	idActividad=gEN('_idActividadvch')[0].value;
    }
    
    
    var columnModel=gEx('grid_8212').getColumnModel();

     var funcionRendererColumana=columnModel.config[0].renderer;
     gEx('grid_8212').getColumnModel().config[0].renderer=function(val,meta,registro)
                                                                {
                                                                
                                                                    if(val=='0')
                                                                        return mostrarValorDescripcion('OTRO: '+registro.data.otroDelito);
                                                                     return funcionRendererColumana(val,meta,registro);
                                                                }
    
    gE('sp_8211').innerHTML='';
    
    
    
	crearGridParticipantes();
    oE('_otroDelitovch');
    
    
    if(totalDocumentos!='0')
    {
    	window.parent.gEx('vistaDocuentosReferencia').getStore().reload();
        window.parent.gEx('vistaDocuentosProceso').getStore().reload();
    }
}

function crearGridParticipantes()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idParticipante'},
		                                                {name: 'nombreParticipante'},
		                                                {name:'figura'},
		                                                {name:'relacion'},
                                                        {name:'idRegistro'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_Juzgados.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'figura', direction: 'ASC'},
                                                            groupField: 'figura',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='1';
                                        proxy.baseParams.idActividad=idActividad;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idRegistro',
                                                                align:'center',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(!esRegistroFormulario())
                                                                            	return;
                                                                        	return '<a href="javascript:editarParte(\''+bE(registro.data.figura)+'\',\''+bE(val)+'\')"><img src="../images/pencil.png" title="Editar parte" alt="Editar parte"></a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre de la parte',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'nombreParticipante',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Calidad',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'figura',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoFigura,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Relacionado con:',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'relacion',
                                                                renderer:function(val,meta,registro)
                                                                		{	
                                                                        	meta.attr='style="height:auto !important;line-height:21px;"';
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gParticipantes',
                                                                store:alDatos,
                                                                width:900,
                                                                height:250,
                                                                renderTo:'sp_8211',
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
                                                                                text:'Agregar parte...',
                                                                                menu:	<?php echo $arrPartes?>
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover parte',
                                                                                hidden:!esRegistroFormulario(),
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la parte que desea remover');
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
                                                                                                            tblGrid.getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=8&figuraJuridica='+fila.data.figura+'&idRegistro='+fila.data.idRegistro,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('¿Est&aacute; seguro de querer remover la parte seleccionada?',resp);
                                                                                        }
                                                                                
                                                                            }
                                                                		],                                                              
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
        return 	tblGrid;
}


function agregarParticipante(f,parte)
{
	var objConf={};
    objConf.ocultaIdentificacion=true;
    objConf.idActividad=idActividad;
    objConf.idCarpeta=-1;
    objConf.afterRegister=recargarGridParticipantes;
	agregarParticipanteVentana(f,parte,objConf)
}

function recargarGridParticipantes()
{
	gEx('gParticipantes').getStore().reload();
}

function editarParte(f,iR)
{
	var objConf={};
    objConf.ocultaIdentificacion=true;
    objConf.idActividad=idActividad;
    objConf.idCarpeta=-1;
    objConf.afterRegister=recargarGridParticipantes;
    objConf.idParticipante=bD(iR);
    var pos=existeValorMatriz(arrTipoFigura,bD(f));
    var parte=arrTipoFigura[pos][1];
	agregarParticipanteVentana(bD(f),parte,objConf)
  
}

function mostrarVentanaDelito()
{
	var cmbDelito=crearComboExt('cmbDelito',arrDelitos,150,5,450);
    cmbDelito.on('select',function(cmb,registro)
    					{
                        	if(registro.data.id=='0')
                            {
                                gEx('lblEspecifique').show();
                                gEx('txtEspecifique').show();
                            }
                            else
                            {
                            	gEx('lblEspecifique').hide();
                                gEx('txtEspecifique').hide();
                                gEx('txtEspecifique').setValue('');
                            }
                        }
    			)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Delito:'
                                                        },
                                                        cmbDelito,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            hidden:true,
                                                            id:'lblEspecifique',
                                                            html:'Especifique:'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:35,
                                                            xtype:'textfield',
                                                            width:400,
                                                            hidden:true,
                                                            id:'txtEspecifique'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar delito',
										width: 650,
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(cmbDelito.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbDelito.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el delito a agregar',resp)
                                                                        	return;
                                                                        }	
                                                                        
                                                                        var reg=crearRegistro	(			
                                                                        							[
                                                                                                    	{name: 'idRegistro'},
                                                                                                        {name: 'idReferencia'},
                                                                                                        {name:'delito', type:'string'},
                                                                                                        {name:'otroDelito', type:'string'}
                                                                                                    ]
                                                                        						)
																		var r=new reg	(
                                                                        					{
                                                                                            	idRegistro:-1,
                                                                                                idReferencia:-1,
                                                                                                delito:cmbDelito.getValue(),
                                                                                                otroDelito:gEx('txtEspecifique').getValue()
                                                                                            }
                                                                        				)                                                                                                
                                                                        gEx('grid_8212').getStore().add(r);
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