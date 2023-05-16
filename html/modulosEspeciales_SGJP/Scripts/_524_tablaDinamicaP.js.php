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
	
	$consulta="SELECT cveEstado,estado FROM 820_estados";
	$arrEstados=$con->obtenerFilasArreglo($consulta);	

	
	$permiteTurnoDirecto="false";
	$arrTurnoDirecto=array();
	$arrTurnoDirecto["157_0"]=1;
	$arrTurnoDirecto["112_0"]=1;
	$arrTurnoDirecto["1_0"]=1;
	
	foreach($arrTurnoDirecto as $idRol=>$rol)
	{
		if(existeRol("'".$idRol."'"))
		{
			$permiteTurnoDirecto="true";
			break;
		}
	}
	

?>

var permiteTurnoDirecto=<?php echo $permiteTurnoDirecto?>;
var arrEstados=<?php echo $arrEstados?>;
var cadObjBusqueda='';
var iNotififyAlerta=null;
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
    	gE('sticky').style='z-index:998';
        loadScript('../modulosEspeciales_SGJP/Scripts/cParticipante.js.php', function()
                                                                            {
                                                                            }
                    )
        loadScript('../Scripts/funcionesAjaxV2.js', function(){});
        
        loadCSS('../Scripts/classNotify/jquery.classynotty.css', function(){});
        loadScript('../Scripts/classNotify/jquery.classynotty.js', function(){});
        
        if(gE('idRegistroG').value=='-1')
        {
            gEx('f_sp_fechaRecepciondte').setValue(fechaActual);
        
            gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
    
            
            gEx('f_sp_horaRecepciontme').setValue(horaActual);
            gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
            
            gEN('_idActividadvch')[0].value=idActividad;
            gE('opt_tipoDelitovch_1').checked=true;
            selOpcion(gE('opt_tipoDelitovch_1'));
            
            
            asignarEvento(gE('_estadoEntidadExhortantevch'),'change',function()
                                        {
                                            buscarRepeticionExhorto();
                                        }
                        );
            
            asignarEvento(gE('_numeroCausaOrigenvch'),'change',function()
                                        {
                                            buscarRepeticionExhorto();
                                        }
                        );
            
		 	asignarEvento(gE('_noOficiovch'),'change',function()
                                        {
                                            buscarRepeticionExhorto();
                                        }
                        );
                        
                        
			                                 
            
        }
        else
        {
            idActividad=gEN('_idActividadvch')[0].value;
        } 
         
         
        gEx('btnAdd_grid_8207').setHandler(mostrarVentanaDelito) ;
        if(!permiteTurnoDirecto)
		{
        	oE('opt_tipoUnidadDestinovch_3');
            
            var lblUnidadDestino=gEN('et_tipoUnidadDestinovch')[2];
            lblUnidadDestino.style="display:none;"
            
        }
         

    }
    else
    {
    	idActividad=gEN('_idActividadvch')[0].value;
        if(gE('sp_8183').innerHTML=='Unidad Específica')
        {
        	mE('div_9460');
            mE('div_9459');
            mE('div_9461');
            mE('div_9462');
            oE('div_8221');
            oE('div_8222');
        }
        else
        {
        	oE('div_9460');
            oE('div_9459');
            oE('div_9461');
            oE('div_9462');
            mE('div_8221');
            mE('div_8222');
        }
        
        
	}
    gE('sp_8169').innerHTML='';
    crearGridParticipantes();
    var columnModel=gEx('grid_8207').getColumnModel();

     var funcionRendererColumana=columnModel.config[0].renderer;
     gEx('grid_8207').getColumnModel().config[0].renderer=function(val,meta,registro)
                                                                {
                                                                
                                                                    if(val=='0')
                                                                        return mostrarValorDescripcion('OTRO: '+registro.data.otroDelito);
                                                                     return funcionRendererColumana(val,meta,registro);
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
                                                                renderTo:'sp_8169',
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
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=8&idActividad='+idActividad+'&figuraJuridica='+fila.data.figura+'&idRegistro='+fila.data.idRegistro,true);
                                                                                                    
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
                                                                        gEx('grid_8207').getStore().add(r);
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

function buscarRepeticionExhorto()
{
	var entidadFederativa=gE('_estadoEntidadExhortantevch').options[gE('_estadoEntidadExhortantevch').selectedIndex].value;
    
    if((entidadFederativa=='')||(entidadFederativa=='-1'))
    	return;
    
    if(gE('_numeroCausaOrigenvch').value.trim()=='')
    	return;
        
    if(gE('_noOficiovch').value.trim()=='')
    	return;
    
	cadObjBusqueda='{"entidadFederativa":"'+entidadFederativa+'","numExpediente":"'+cv(gE('_numeroCausaOrigenvch').value.trim())+'","numOficio":"'+
    			cv(gE('_noOficiovch').value.trim())+'"}';
                
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var coincidencias=parseInt(arrResp[1]);
            
            if(coincidencias>0)
            {
            	mostrarAlerta(coincidencias);
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=226&cadObj='+cadObjBusqueda,true);
    
}



function mostrarAlerta(totalCoincidencias)
{
	var leyenda='';
    
    if(totalCoincidencias==1)
    	leyenda='Se ha detectado 1 posible coincidencia de exhorto repetido';
    else
    	leyenda='Se han detectado '+totalCoincidencias+' posibles coincidencias de exhorto repetido';
	if(iNotififyAlerta)
        iNotififyAlerta.cerrar();
    iNotififyAlerta=	$.ClassyNotty({
                            
                                        content : '<div style="text-align:center">'+leyenda+', para m&aacute;s detalle de click <a style="text-decoration:none" href="javascript:mostrarVentanaCoincidenciasExhortos()"><span style="color:#F00; font-size:15px"><b>AQU&Iacute;</b></span></a></div>',
                                        showTime:false
                                    });
}

function mostrarVentanaCoincidenciasExhortos(totalCoincidencias)
{
	if(iNotififyAlerta)
        iNotififyAlerta.cerrar();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridCoincidencias()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Posibles coincidencias',
										width: 750,
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
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

function crearGridCoincidencias()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'carpertaExhorto'},
		                                                {name:'fechaRecepcion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'entidadFederativa'},
                                                        {name: 'juzgadoExhortante'},
                                                        {name: 'noExpediente'},
                                                        {name: 'noOficio'},
                                                        {name:'figuraJuridica'},
                                                        {name:'documentos'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                  reader: lector,
                                                  proxy : new Ext.data.HttpProxy	(

                                                                                        {
    
                                                                                            url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'
    
                                                                                        }
    
                                                                                    ),
                                                  sortInfo: {field: 'fechaRecepcion', direction: 'ASC'},
                                                  groupField: 'fechaRecepcion',
                                                  remoteGroup:false,
                                                  remoteSort: false,
                                                  autoLoad:true
                                                  
                                              }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='227';
                                        proxy.baseParams.cadObj=cadObjBusqueda;
                                    }
                        )   
       
	var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),    
                                                            {
                                                                header:'',
                                                                width:40,
                                                                sortable:true,
                                                                dataIndex:'idRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<a href="javascript:abrirProcesoExhorto(\''+bE(val)+'\')"><img src="../images/magnifier.png"  width="14" height="14"/></a>';
                                                                        }
                                                            },                                                        
                                                            {
                                                                header:'Carpeta Exhorto',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'carpertaExhorto'
                                                            },
                                                            {
                                                                header:'Fecha de recepci&oacute;n',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'fechaRecepcion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Entidad federativa',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'entidadFederativa',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrEstados,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'No. Expediente',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'noExpediente'
                                                            },
                                                            {
                                                                header:'No. de oficio',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'noOficio'
                                                            },
                                                            {
                                                                header:'Juzgado Exhortante',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'juzgadoExhortante',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gCoincidencias',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,                                                                               
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    enableRowBody:true,
                                                                                                    getRowClass:formatearFilaCoincidencia,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	

}

function formatearFilaCoincidencia(registro, numFila, p, ds)
{
	var arrParticipantes='';
    var fila;
    var x;
    var arrDocumentos='';
    for(x=0;x<registro.data.figuraJuridica.length;x++)
    {
    	fila=registro.data.figuraJuridica[x];
        if(arrParticipantes=='')
        	arrParticipantes=fila[1];
        else
        	arrParticipantes+='<br>'+fila[1];
    }

    for(x=0;x<registro.data.documentos.length;x++)
    {
    	fila=registro.data.documentos[x];
        if(arrDocumentos=='')
        	arrDocumentos='<a href="javascript:mostrarDocumentoListado(\''+bE(fila[1])+'\',\''+bE(fila[0])+'\')">'+fila[1]+'</a>';
        else
        	arrDocumentos+='<br><br><a href="javascript:mostrarDocumentoListado(\''+bE(fila[1])+'\',\''+bE(fila[0])+'\')">'+fila[1]+'</a>';
    }
    
	p.body = 	'<br><table width="800">'+
    			'<tr height="21"><td width="20"></td><td width="200" style="vertical-align:top"><b>Participantes:</b></td><td width="580" style="vertical-align:top">'+
                arrParticipantes+'</td></tr><tr><td width="20"></td><td colspan="2">'+arrDocumentos+'</td></tr>'+
                '</table><br>';
    return 'x-grid3-row-expanded';
}


function mostrarDocumentoListado(nomArchivoOriginal,idDocumento)
{
	var arrNombre=bD(nomArchivoOriginal).split('.');
	window.parent.mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),bD(idDocumento));
}

function abrirProcesoExhorto(iRegistro)
{
	window.parent.abrirFormularioProcesoFancy(bE(524),iRegistro,bE(0));
}


