<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idRegistro,mail FROM 805_configuracionMailSMTP where situacionActual=1 ORDER BY mail";
	$arrCuentas=$con->obtenerFilasArreglo($consulta);
	
	
	$arrConfMetaDatos="";
	$consulta="SELECT idMetaDato,nombreMetaDato,metodoResolucion,tipoDatoEntrada,funcionSistema,fuenteDatos 
				FROM 20003_catalogoMetaDatos WHERE situacionActual=1 ORDER BY nombreMetaDato";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$arrOpciones="";
		
		if($fila["metodoResolucion"]==2)
		{
			switch($fila["fuenteDatos"])
			{
				case 0:
					$arrOpciones="";
					$cacheCalculos=NULL;
					$cadParametros='{"idMetaDato":"'.$fila["idMetaDato"].'","carpetaAdministrativa":"","idCarpetaAdministrativa":"-1"}';
					$objParametros=json_decode($cadParametros);
					$aOpciones=resolverExpresionCalculoPHP($fila["funcionSistema"],$objParametros,$cacheCalculos);
					foreach($aOpciones as $o)
					{
						$o="['".$o["clave"]."','".cv($o["valor"])."']";
						if($arrOpciones=="")
							$arrOpciones=$o;
						else
							$arrOpciones.=",".$o;
					}
					
					$arrOpciones='['.$arrOpciones.']';
				break;
				case 1:
					$consulta="SELECT valor,etiqueta FROM 20004_opcionesMetaDatos WHERE idMetaDatos=".$fila["idMetaDato"]." ORDER BY etiqueta";
					$arrOpciones=$con->obtenerFilasArreglo($consulta);
				break;
				
			}
		}
		else
		{
			$arrOpciones='[]';
		}
		$oMeta="['".$fila["idMetaDato"]."','".cv($fila["nombreMetaDato"])."',".$fila["tipoDatoEntrada"].",".$arrOpciones."]";
		if($arrConfMetaDatos=="")
			$arrConfMetaDatos=$oMeta;
		else
			$arrConfMetaDatos.=",".$oMeta;
	}
	$arrConfMetaDatos="[".$arrConfMetaDatos."]";
	
	
	$consulta="SELECT idCategoria,nombreCategoria,idPerfilMetaDatos FROM 908_categoriasDocumentos order by nombreCategoria";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);

	$arrPerfilMetadato="";
	$consulta="SELECT idPerfilMetaDato,nombrePerfil FROM 20005_perfilesMetaDatos";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$consulta="SELECT m.idMetaDato,obligatorio FROM 20006_metaDatoPerfil m,20003_catalogoMetaDatos cM 
				WHERE idPerfilMetaDato=".$fila["idPerfilMetaDato"]." and cM.idMetaDato=m.idMetaDato and cM.metodoResolucion<>1";
		$arrMetaDatos=$con->obtenerFilasArreglo($consulta);
		$o="['".$fila["idPerfilMetaDato"]."','".cv($fila["nombrePerfil"])."',".$arrMetaDatos."]";
		if($arrPerfilMetadato=="")
			$arrPerfilMetadato=$o;
		else
			$arrPerfilMetadato.=",".$o;
	}
	$arrPerfilMetadato="[".$arrPerfilMetadato."]";
	$arrTipoDocumentos=$arrCategorias;
	
?>
var regMetaDato;

var arrObjetosMetaData=[];
var arrCategorias=<?php echo $arrTipoDocumentos?>;
var arrPerfilMetadato=<?php echo $arrPerfilMetadato?>;
var arrConfMetaDatos=<?php echo $arrConfMetaDatos?>;
var arrCuentas=<?php echo $arrCuentas?>;

Ext.onReady(inicializar);

function inicializar()
{
	regMetaDato=crearRegistro	(
										[
                                            {name:'idRegistro'},
                                            {name: 'idPropiedad'},
                                            {name:'valor'},
                                            {name:'nombreDocumento'}
                                        ]
									);
	arrConfMetaDatos.splice(0,0,['0','Tipo Documental',arrCategorias]);
	var cmbCuenta=crearComboExt('cmbCuenta',arrCuentas,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl'});
    cmbCuenta.on('select',function(cmb,registro)		
    						{
                            	gEx('arbolBuzones').getRootNode().reload();
                            }
    			)
    cmbCuenta.setValue(arrCuentas[0][0]);
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                cls:'panelSiugj',
                                                title: 'Cuentas de Correo',
                                                tbar:	[	
                                                			{
                                                            	html:'<span class="SIUGJ_Etiqueta">Cuenta de Correo:&nbsp;&nbsp;</span>'
                                                            },
                                                            cmbCuenta
                                                		],
                                                items:	[
                                                            {
                                                                xtype:'panel',
                                                                region:'center',
                                                                border:false,
                                                                layout:'border',
                                                                items:	[
                                                                            crearArbolBuzones(),
                                                                            {
                                                                            	xtype:'panel',
                                                                                layout:'border',
                                                                                region:'center',
                                                                                items:	[
                                                                                			 crearGridCorreosRecibidos()
                                                                                		]
                                                                            }
                                                                           
                                                                        ]
                                                            }
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearArbolBuzones()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'4'
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_CorreoElectronico.php'
                                                }
                                            )		
	
    cargadorArbol.on('beforeload',function(proxy,nodoCarga)
    						{
                            	proxy.baseParams.iC=bE(gEx('cmbCuenta').getValue());

									
                                
                            }
    				)
    
    cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            		
									setTimeout	(	function()
                                                    {
                                                        var nodo=nodoCarga.childNodes[0];
                                                        gEx('arbolBuzones').getSelectionModel().select(nodo);
                                                        funcBandeja(nodo);
                                                    },500
                                                 )
                                
                            }
    				)									
										
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolBuzones',
                                                                border:true,
                                                                width:200,
                                                                region:'west',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	arbolSujetosJuridicos.on('click',funcBandeja);	                      
	return  arbolSujetosJuridicos;
}

function funcBandeja(nodo, evento)
{
	nodoBandeja=nodo;
	if(nodo.childNodes.length==0)
    {
    	gEx('gMailsRecibidos').getStore().removeAll();
    	gEx('gMailsRecibidos').getStore().load	(
        											{
                                                    	params:	{
                                                        			funcion:'5',
                                                                    b:nodoBandeja.id,
                                                                    start:0,
                                                                    limit:10,
                                                                    iC:bE(gEx('cmbCuenta').getValue())
                                                        		}
                                                    }
        										);
        
    }
    
    
    
}

function obtenerCorreosBuzon(buzon)
{
	var iO=0;
    var iP=0;
    var tN=0;
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
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=38&iO='+iO+'&iP='+iP+'&tN='+tN+'&b='+buzon,true);
}

function crearGridCorreosRecibidos()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idMail'},
                                                        {name:'asunto'},
		                                                {name: 'fechaRecepcion', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name:'remitente'},
		                                                {name:'adjuntos'},
                                                        {name:'cuerpo'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_CorreoElectronico.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaEnvio', direction: 'ASC'},
                                                            groupField: 'fechaEnvio',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	var paginador=	new Ext.PagingToolbar	(
                                              {
                                                    pageSize: 10,
                                                    store: alDatos,
                                                    displayInfo: true,
                                                    disabled:false
                                                }
                                             )     
      
      
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                    	proxy.baseParams.funcion='5';
                                        proxy.baseParams.b=nodoBandeja.id;
                                        proxy.baseParams.iC=bE(gEx('cmbCuenta').getValue());
                                        

                                        
                                    }
                        )       
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
           
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'Fecha de recepci&oacute;n',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaRecepcion',
                                                                renderer:function(val,metaData)
                                                                		{
                                                                        	metaData.attr='style="font-size:11px;color:#555;white-space: normal;"';
                                                                        	return val.format('d/m/Y H:i')
                                                                        }
                                                            },
                                                            {
                                                                header:'Asunto',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'asunto',
                                                                renderer:function(val,metaData,registro)
                                                                		{
                                                                        	metaData.attr='style="font-size:11px;color:#555;white-space: normal;"';
                                                                            return '<a href="javascript:abrirContenidoCorreo(\''+bE(registro.data.idMail)+'\')">'+mostrarValorDescripcion(val)+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Remitente',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'remitente',
                                                                renderer:function(val,metaData)
                                                                		{
                                                                        	metaData.attr='style="font-size:11px;color:#555;white-space: normal;"';
                                                                        	return val.replace(/,/gi,'<br />');
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gMailsRecibidos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                cls:'gridSiugj',
                                                                bbar:[paginador],
                                                                sm:chkRow,
                                                                columnLines : false,     
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar Correo a Expediente',
                                                                                handler:function()
                                                                                        {
                                                                                            var filas=gEx('gMailsRecibidos').getSelectionModel().getSelections();
                                                                                            if(filas.length==0)
                                                                                            {	
                                                                                            	msgBox('Debe seleccionar almenos un correo electr&oacute;nico para agregar al expediente')
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            mostrarVentanaAgregarCorreoExpediente();
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
                                                                                                    enableRowBody:true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
                                                        
	tblGrid.on('rowdblclick(',function(grid,nFila)
                                                {
                                                	
                                                	
                                                }
                                    )                                                        
                                                        
        return 	tblGrid;

}


function abrirContenidoCorreo(iM)
{
	var pos=obtenerPosFila(gEx('gMailsRecibidos').getStore(),'idMail',bD(iM));
    var registro=gEx('gMailsRecibidos').getStore().getAt(pos);
    mostrarVentanaCorreoElectronico(registro.data.adjuntos,bD(registro.data.cuerpo),registro.data.idMail);
}

function obtenerArchivoMail(idMail,idNombreArchivo)
{
	var arrArchivo=bD(idNombreArchivo).split('.');
    var extension=arrArchivo[arrArchivo.length-1];

	var cadObj='{"idMail":"'+bD(idMail)+'","nombreArchivo":"'+bD(idNombreArchivo)+'","iC":"'+bE(gEx('cmbCuenta').getValue())+'"}';
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
       		var pos=existeValorMatriz(arrVisores,extension.toLowerCase());  
            if(pos!=-1) 
            	mostrarVisorDocumentoProceso(extension,arrResp[1],null,bD(idNombreArchivo));
            else
            {
            	location.href='../paginasFunciones/obtenerDocumentoEditorArchivos.php?id='+bE(arrResp[1])+'&nombreArchivo='+bD(idNombreArchivo);
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_CorreoElectronico.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true);
    
}


function mostrarVentanaCorreoElectronico(lblAdjuntos,cuerpoMail,idMail)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            activeTab:0,
                                                            cls:'tabPanelSIUGJ',
                                                            region:'center',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            title:'Cuerpo del Correo',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                            			{
                                                                                        	xtype:'label',
                                                                                            x:0,
                                                                                            y:0,
                                                                                            html:'<div class="controlSIUGJ" style="width:705px;height:150px; border-style:none; overflow:auto" class="cuerpoMail" id="divCuerpoMail">'+cuerpoMail+'</div>'
                                                                                        }
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            title:'Archivos Adjuntos ('+lblAdjuntos.length+')',
                                                                            layout:'border',
                                                                            items:	[crearGridAdjuntos(lblAdjuntos,idMail)]
                                                                        }
                                                            		]
                                                        }
                                            			
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Correo Electr&oacute;nico',
										width: 900,
										height:450,
                                        cls:'msgHistorialSIUGJ',
										layout: 'fit',
										plain:true,
                                        closable:true,
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
                                                            cls:'btnSIUGJ',
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

function crearGridAdjuntos(arrAdjuntos,idMail)
{
	var dsDatos=arrAdjuntos;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nombreArchivo'},
                                                                    {name: 'tamano'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														{
															header:'Nombre del Archivo',
															width:550,
															sortable:true,
															dataIndex:'nombreArchivo',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return '<a href="javascript:obtenerArchivoMail(\''+bE(idMail)+'\',\''+bE(val)+'\')">'+val+'</a>'
                                                                    }
														},
														{
															header:'Tama&ntilde;o',
															width:200,
															sortable:true,
															dataIndex:'tamano',
                                                            renderer:function(val)
                                                            		{
                                                                    	return bytesToSize(val);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            cm: cModelo,
                                                            region:'center',
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            cls:'gridSiugj',
                                                            columnLines : true
                                                        }
                                                    );
	return 	tblGrid;	
}


function mostrarVentanaAgregarCorreoExpediente()
{
	var carpetaAdministrativa=-1;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            activeTab:0,
                                                            id:'tabPanelAgregarCorreo',
                                                            region:'center',
                                                            cls:'tabPanelSIUGJ',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            cls:'panelSiugj',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Datos Generales',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'<span class="SIUGJ_Etiqueta">Expediente al cual se agrega:</span>'
                                                                                        },
                                                                                        {
                                                                                            x:320,
                                                                                            y:10,
                                                                                            html:'<div id="divComboExpediente"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:50,
                                                                                            html:'<span id="divInfoExpediente"></span>'
                                                                                        }
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            cls:'panelSiugj',
                                                                            layout:'border',
                                                                            defaultType: 'label',
                                                                            title:'Informaci&oacute;n Documentos Adjuntos',
                                                                            items:	[
                                                                            			crearGridMetadatos()
                                                                            		]
                                                                        }
                                                            			
                                                            		]
                                                        }
                                                        
                                                        
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Correo a Expediente',
										width: 800,
										height:470,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var oConf=	{
                                                                                    idCombo:'cmbExpedienteAgrega',
                                                                                    anchoCombo:300,
                                                                                    posX:0,
                                                                                    posY:0,
                                                                                    raiz:'registros',
                                                                                    campoDesplegar:'carpetaAdministrativa',
                                                                                    campoID:'carpetaAdministrativa',
                                                                                    funcionBusqueda:47,
                                                                                    renderTo:'divComboExpediente',
                                                                                    ctCls:'campoComboWrapSIUGJAutocompletar',
                                                                                    listClass:'listComboSIUGJ',
                                                                                    paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                                    confVista:'<tpl for="."><div class="search-item">{carpetaAdministrativa}<br></div></tpl>',
                                                                                    campos:	[
                                                                                                {name:'carpetaAdministrativa'},
                                                                                                {name:'carpetaAdministrativa'}
                                                            
                                                                                            ],
                                                                                    funcAntesCarga:function(dSet,combo)
                                                                                                {
                                                                                                	gE('divInfoExpediente'),innerHTML='';
                                                                                                    carpetaAdministrativa=-1;
                                                                                                    idCarpeta=-1;
                                                                                                    var aValor=combo.getRawValue();
                                                                                                    dSet.baseParams.criterio=aValor;
                                                                                                    dSet.baseParams.uG='<?php echo existeRol("'1_0'")?"":$_SESSION["codigoInstitucion"]?>';
                                                                                                    
                                                                                                                                          
                                                                                                    
                                                                                                },
                                                                                    funcElementoSel:function(combo,registro)
                                                                                                {
                                                                                                    carpetaAdministrativa=registro.data.carpetaAdministrativa;
														                                            idCarpeta=registro.data.idCarpeta;
                                                                                                    rendererInfoProcesoJudicial(carpetaAdministrativa,gE('divInfoExpediente'));
                                                                                                }  
                                                                                };
                                                                                
                                                                	var cmbExpedienteAgrega=crearComboExtAutocompletar(oConf);  
																
                                                                	var gMetaDatos=gEx('gMetaDatos');
                                                                    var oReg={};
                                                                    var x;
                                                                    var fila;
                                                                    var r;
                                                                    var reg;
                                                                    
                                                                    var filas=gEx('gMailsRecibidos').getSelectionModel().getSelections();
                                                                    var nFilas;
                                                                    var f;
                                                                    var filaMail;
                                                                    for(nFilas=0;nFilas<filas.length;nFilas++)
                                                                    {
                                                                    	filaMail=filas[nFilas];
                                                                        if(filaMail.data.adjuntos.length==0)
                                                                        {
                                                                        	f=filaMail.data.adjuntos[x];
                                                                            oReg={};
                                                                            oReg.idRegistro=bE(filaMail.data.idMail+'_sinAdjuntos');
                                                                            oReg.idPropiedad='0';
                                                                            oReg.valor='153';
                                                                            oReg.nombreDocumento='Cuerpo de correo';
                                                                            oReg.arrOpciones=arrCategorias;
                                                                            oReg.obligatorio='1';  
                                                                            oReg.tipoEntrada='0';  
                                                                            oReg.idDocumento =oReg.idRegistro;                                                                         
                                                                            r=new regMetaDato(oReg);
                                                                            gMetaDatos.getStore().add(r);
                                                                        }
                                                                        else
                                                                        {
                                                                            for(x=0;x<filaMail.data.adjuntos.length;x++)
                                                                            {
                                                                                f=filaMail.data.adjuntos[x];
                                                                                oReg={};
                                                                                oReg.idRegistro=bE(filaMail.data.idMail+'_'+f[0]);
                                                                                oReg.idPropiedad='0';
                                                                                oReg.valor='';
                                                                                oReg.nombreDocumento=f[0];
                                                                                oReg.arrOpciones=arrCategorias;
                                                                                oReg.obligatorio='1';  
                                                                                oReg.tipoEntrada='0';  
                                                                                oReg.idDocumento =oReg.idRegistro;                                                                         
                                                                                r=new regMetaDato(oReg);
                                                                                gMetaDatos.getStore().add(r);
                                                                                
                                                                            }
                                                                         }
                                                                	}
                                                                    
                                                                    gEx('cmbExpedienteAgrega').focus(false,500);
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
                                                                    	if(carpetaAdministrativa==-1)
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('tabPanelAgregarCorreo').setActiveTab(0);
                                                                            	gEx('cmbExpedienteAgrega').focus(false,500);
                                                                            }
                                                                        	msgBox('Debe indicar el expediente al cual ser&aacute; agregados los correos seleccionados',resp);
                                                                        	return;
                                                                        }
                                                                    	
																		var fila;
                                                                        var x;
                                                                        var arrObjetosMetaData=[];
                                                                        
                                                                        var gMetaDatos=gEx('gMetaDatos');
                                                                        
                                                                        for(x=0;x<gMetaDatos.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gMetaDatos.getStore().getAt(x);
                                                                            
                                                                            if((fila.data.obligatorio=='1')&&(fila.data.valor==''))
                                                                            {
                                                                            
                                                                            	function resp()
                                                                                {
                                                                                	gEx('tabPanelAgregarCorreo').setActiveTab(1);
                                                                                	gMetaDatos.startEditing(x,2);
                                                                                }
                                                                            	msgBox('Debe ingresar el valor del meta dato:<br>"'+formatearValorRenderer(arrConfMetaDatos,fila.data.idPropiedad)+
                                                                                		'"<br>Documento: '+fila.data.nombreDocumento+'',resp);
                                                                            	return;
                                                                            }
                                                                            
                                                                            var objRegistro={};
                                                                            var pos=existeValorArregloObjetos(arrObjetosMetaData,'idDocumento',fila.data.idDocumento);
                                                                            if(pos==-1)
                                                                            {
                                                                            	objRegistro={};
                                                                                objRegistro.idDocumento=fila.data.idDocumento;
                                                                                objRegistro.nombreDocumento=fila.data.nombreDocumento;
                                                                                objRegistro.metaData=[];
                                                                                objRegistro.metaData.push(fila);
                                                                                arrObjetosMetaData.push(objRegistro);
                                                                                
                                                                                
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                            	objRegistro=arrObjetosMetaData[pos];
                                                                                objRegistro.metaData.push(fila);
                                                                            }
                                                                            
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                       
																	
                                                                    	var arrInfo='';
                                                                    	var o='';
                                                                        var idDocumento;
                                                                        var arrInfoDocumento='';
                                                                        var y;
                                                                        var arrMetaDatos='';
                                                                        var oMeta;
                                                                        var objMetada='';
                                                                    	for(x=0;x<arrObjetosMetaData.length;x++)
                                                                        {
                                                                        	
                                                                        	objRegistro=arrObjetosMetaData[x];
                                                                            idDocumento=bD(objRegistro.idDocumento);

                                                                            arrInfoDocumento=idDocumento.split('_');
																			arrMetaDatos='';
                                                                            for(y=0;y<objRegistro.metaData.length;y++)
                                                                            {
                                                                            	valorEtiqueta='';
                                                                                fila=objRegistro.metaData[y];
                                                                                valor=fila.data.valor;
                                                                                
                                                                                if((fila.data.tipoEntrada=='5')&&(valor.format))
                                                                                {
                                                                                    valor=valor.format('Y-m-d');
                                                                                }
                                                                                
                                                                                if(fila.data.arrOpciones.length>0)
                                                                                {
                                                                                    valorEtiqueta=formatearValorRenderer(fila.data.arrOpciones,fila.data.valor);
                                                                                }
                                                                                
                                                                                if(fila.data.idPropiedad=='0')
                                                                                {
                                                                                    tipoDocumental=valor;
                                                                                }
                                                                                
                                                                                if(valorEtiqueta=='')
                                                                                    valorEtiqueta=valor;
                                                                                objMetada='{"idPropiedad":"'+fila.data.idPropiedad+'","tipoEntrada":"'+fila.data.tipoEntrada+
                                                                                        '","valor":"'+cv(valor)+'","valorEtiqueta":"'+cv(valorEtiqueta)+'"}';
                                                                                if(arrMetaDatos=='')
                                                                                	arrMetaDatos=objMetada;
                                                                                 else
                                                                                 	arrMetaDatos+=','+objMetada;
                                                                            }
                                                                            o='{"idMail":"'+arrInfoDocumento[0]+'","nombreArchivo":"'+cv(objRegistro.nombreDocumento)+'","metaDatos":['+arrMetaDatos+']}';
                                                                            if(arrInfo=='')
                                                                            	arrInfo=o;
                                                                            else
                                                                            	arrInfo+=','+o;
                                                                            
                                                                        }
                                                                        
                                                                        var cadObj='{"iC":"'+bE(gEx('cmbCuenta').getValue())+'","idCarpetaAdministrativa":"-1","carpetaAdministrativa":"'+carpetaAdministrativa+'","arrMails":['+arrInfo+']}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	msgBox('La operaci&oacute;n ha sido realizada exitosamente');
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_CorreoElectronico.php',funcAjax, 'POST','funcion=7&cadObj='+cadObj,true);

                                                                    }
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJ',
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

function crearGridMetadatos()
{
	
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'idPropiedad'},
		                                                {name:'valor'},
                                                        {name:'obligatorio'},
                                                        {name:'nombreDocumento'},
                                                        {name:'arrOpciones'},
                                                        {name:'tipoEntrada'},
                                                        {name:'idDocumento'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesAlmacen.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreDocumento', direction: 'ASC'},
                                                            groupField: 'nombreDocumento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Meta Dato',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'idPropiedad',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        
                                                                          	return '<b>'+formatearValorRenderer(arrConfMetaDatos,val)+'</b>'+(registro.data.obligatorio=='1'?' <span style="color:#F00">*</span>':'');
                                                                            
                                                                        }
                                                            },
                                                            {
                                                                header:'Valor',
                                                                width:370,
                                                                sortable:true,
                                                                dataIndex:'valor',
                                                                editor:{xtype:'textfield'},
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	var lblVal='';
                                                                        	if(registro.data.idPropiedad=='0')
                                                                            {
                                                                            	if(val!='153')
	                                                                            	lblVal='<a href="javascript:asignarTipoDocumental(\''+bE(registro.data.idRegistro)+'\')"><img width="14" height="14" src="../images/pencil.png" title="Asignar Tipo Documental" alt="Asignar Tipo Documental"></a>';    
                                                                           		
                                                                            }
                                                                            if(registro.data.arrOpciones.length>0)
                                                                            {
                                                                            	if(lblVal=='')
	                                                                            	lblVal=formatearValorRenderer(registro.data.arrOpciones,val);
                                                                                 else
                                                                                 	lblVal+=' '+formatearValorRenderer(registro.data.arrOpciones,val);
                                                                            }
                                                                            else
                                                                            {
                                                                            	
                                                                                switch(parseInt(registro.data.tipoEntrada))
                                                                                {
                                                                                    case 1:
                                                                                        return escaparEnter(val);
                                                                                    break;
                                                                                    case 2:
                                                                                        return val;
                                                                                    break;
                                                                                    case 3:
                                                                                        return val;
                                                                                    break;
                                                                                    case 4:
                                                                                        return Ext.util.Format.usMoney(val);
                                                                                    break;
                                                                                    case 5:
                                                                                       	if(val!='')
                                                                                        	return val.format('d/m/Y');
                                                                                    break;
                                                                                    case 6:
                                                                                        return val;
                                                                                    break;
                                                                               
                                                                                }
                                                                                
                                                                                	
                                                                            }
                                                                            return (registro.data.idPropiedad=='0')?'<b>'+lblVal+'</b>':lblVal;
                                                                        }
                                                            },
                                                            {
                                                                header:'Documento',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'nombreDocumento',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	return 'Nombre del Documento: '+val;
                                                                        }
                                                                
                                                               
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gMetaDatos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                clicksToEdit:1,
                                                                cm: cModelo,
                                                                cls:'gridSiugj',
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,                                                                
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
                                	var ctrl=null;
                                	
                                    switch(parseInt(e.record.data.tipoEntrada))
                                    {
                                        case 1:
                                            ctrl=new Ext.form.TextArea (
                                                                            {
                                                                                height:40,
                                                                                cls:'controlSIUGJ'
                                                                            }
                                                                        )
                                        break;
                                        case 2:
                                            ctrl=new Ext.form.NumberField (
                                                                            {
                                                                                allowDecimals:false,
                                                                                cls:'controlSIUGJ'
                                                                            }
                                                                        )
                                        break;
                                        case 3:
                                            ctrl=new Ext.form.NumberField (
                                                                            {
                                                                                allowDecimals:true,
                                                                                cls:'controlSIUGJ'
                                                                            }
                                                                        )
                                        break;
                                        case 4:
                                            ctrl=new Ext.form.NumberField (
                                                                            {
                                                                                allowDecimals:true,
                                                                                cls:'controlSIUGJ'
                                                                            }
                                                                        )
                                        break;
                                        case 5:
                                            ctrl=new Ext.form.DateField ({cls:'controlFechaSIUGJ'});
                                        break;
                                        case 6:
                                            ctrl=new Ext.form.TextField ({cls:'controlSIUGJ'});
                                        break;
                                        default:
                                            if((e.record.data.arrOpciones.length>0)&&(e.record.data.idPropiedad!='0'))
                                            {
                                                ctrl=crearComboExt('cmbEditor',e.record.data.arrOpciones,0,0,null,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl'});
                                            }
                                        break;
                                   
                                    }
                                    
                                    if(ctrl)
	                                	e.grid.getColumnModel().setEditor(2,ctrl);
                                    else
                                    	e.cancel=true;
                                }
        			)                                                        
                                                        
		
        return 	tblGrid;
}

function asignarTipoDocumental(id)
{
	var idTipoDocumento=-1;
	var oConf=	{
    					idCombo:'cmbTipoDocumental',
                        anchoCombo:300,
                        posX:160,
                        posY:5,
                        raiz:'registros',
                        campoDesplegar:'nombreDocumento',
                        campoID:'idTipoDocumento',
                        funcionBusqueda:32,
                        paginaProcesamiento:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                        confVista:'<tpl for="."><div class="search-item">{nombreDocumento}<br></div></tpl>',
                        campos:	[
                                   	{name:'idTipoDocumento'},
                                    {name:'nombreDocumento'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	idTipoDocumento=-1;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        
                                                                              
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                        				{
                                        	idTipoDocumento=registro.data.idTipoDocumento;
                                            
                                        }
    				};

	var cmbTipoDocumental=crearComboExtAutocompletar(oConf);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:20,
                                                            html:'<span class="SIUGJ_Etiqueta">Tipo Documental:</span>'
                                                        },
                                                        {
                                                            x:210,
                                                            y:15,                                                                                            
                                                            html:'<div id="dComboValorTipoDocumental"></div>'
                                                        }
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignaci&oacute;n de Tipo Documental',
										width: 600,
										height:160,
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
                                                                	gEx('cmbTipoDocumental').focus(false,500);
                                                                    var oConf=	{
                                                                                    idCombo:'cmbTipoDocumental',
                                                                                    anchoCombo:300,
                                                                                    renderTo:'dComboValorTipoDocumental',
                                                                                    raiz:'registros',
                                                                                    campoDesplegar:'nombreDocumento',
                                                                                    campoID:'idTipoDocumento',
                                                                                    funcionBusqueda:32,
                                                                                    ctCls:'campoComboWrapSIUGJAutocompletar',
                                                                                    listClass:'listComboSIUGJ',
                                                                                    paginaProcesamiento:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                                    confVista:'<tpl for="."><div class="search-item">{nombreDocumento}<br></div></tpl>',
                                                                                    campos:	[
                                                                                                {name:'idTipoDocumento'},
                                                                                                {name:'nombreDocumento'}
                                                            
                                                                                            ],
                                                                                    funcAntesCarga:function(dSet,combo)
                                                                                                {
                                                                                                    idTipoDocumento=-1;
                                                                                                    var aValor=combo.getRawValue();
                                                                                                    dSet.baseParams.criterio=aValor;
                                                                                                    
                                                                                                                                          
                                                                                                    
                                                                                                },
                                                                                    funcElementoSel:function(combo,registro)
                                                                                                    {
                                                                                                        idTipoDocumento=registro.data.idTipoDocumento;
                                                                                                        
                                                                                                    }
                                                                                };
                                                            
                                                                var cmbTipoDocumental=crearComboExtAutocompletar(oConf);
                                                                
                                                                gEx('cmbTipoDocumental').focus(false,500);
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
																		if(idTipoDocumento==-1)
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('cmbTipoDocumental').focus(false,500);
                                                                            }
                                                                        	msgBox('Debe indicar el tipo documental a asignar',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var pos=obtenerPosFila(gEx('gMetaDatos').getStore(),'idRegistro',bD(id));
                                                                        var gMetaDatos=gEx('gMetaDatos');
                                                                        var fila;
                                                                        var filaMeta=gMetaDatos.getStore().getAt(pos);
                                                                        filaMeta.set('valor',idTipoDocumento);
                                                                        var arrFilasTmp=[];
                                                                        var arrFilasAux=[];
                                                                        
                                                                        var x;
                                                                        for(x=0;x<gMetaDatos.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gMetaDatos.getStore().getAt(x);
                                                                            if((fila.data.idPropiedad!='0')&&(fila.data.nombreDocumento==filaMeta.data.nombreDocumento))
                                                                            {
                                                                            	arrFilasTmp.push(fila);
                                                                                arrFilasAux.push(fila.copy());
                                                                            }
                                                                        }
                                                                        
                                                                        //arrPerfilMetadato
                                                                        gMetaDatos.getStore().remove(arrFilasTmp);
                                                                        var posFilaTipoDato=existeValorMatriz(arrCategorias,idTipoDocumento);
                                                                        var posFilaPerfil=existeValorMatriz(arrPerfilMetadato,arrCategorias[posFilaTipoDato][2]);
                                                                        var perfil=arrPerfilMetadato[posFilaPerfil];
                                                                        for(x=0;x<perfil[2].length;x++)
                                                                        {
                                                                        	fila=perfil[2][x];
                                                                        	pos=existeValorMatriz(arrConfMetaDatos,fila[0]);
                                                                        
                                                                            oReg={};
                                                                            oReg.idRegistro=bD(id)+'_'+fila[0];
                                                                            oReg.idPropiedad=fila[0];
                                                                            
                                                                            oReg.arrOpciones=arrConfMetaDatos[pos][3];
                                                                            oReg.nombreDocumento=filaMeta.data.nombreDocumento;
                                                                            oReg.obligatorio=fila[1];  
                                                                            oReg.tipoEntrada=arrConfMetaDatos[pos][2];
                                                                            oReg.idDocumento=bD(id);
                                                                            pos=existeValorArregloObjetos(arrFilasAux,'data.idPropiedad', oReg.idPropiedad);
                                                                            if(pos>-1)
                                                                            {
                                                                            	oReg.valor=arrFilasAux[pos].data.valor;
                                                                            }
                                                                            else
                                                                                oReg.valor='';
                                                                                                                                                    
                                                                            r=new regMetaDato(oReg);
                                                                         	gMetaDatos.getStore().add(r);
                                                                            
                                                                        }
                                                                        gMetaDatos.getStore().sort('nombreDocumento','ASC');
                                                                        gMetaDatos.getView().refresh();
                                                                        ventanaAM.close();
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJ',
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