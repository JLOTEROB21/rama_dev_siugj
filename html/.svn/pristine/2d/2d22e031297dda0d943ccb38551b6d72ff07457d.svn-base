<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT valor,texto FROM 1004_siNo WHERE idIdioma=1";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$consulta=" SELECT id__10_tablaDinamica,CONCAT('[',codigo,'] ',nombreFormato) AS nombreFormato FROM _10_tablaDinamica";
	$arrDocumentos=$con->obtenerFilasArreglo($consulta);
	
	$arrSituacion="";
	$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso= 165 ";
	$rEtapa=$con->obtenerFilas($consulta);
	while($fEtapa=mysql_fetch_row($rEtapa))
	{
		$o="['".$fEtapa[0]."','".removerCerosDerecha($fEtapa[0]).".- ".cv($fEtapa[1])."']";
		
		
		if($arrSituacion=="")
			$arrSituacion=$o;
		else
			$arrSituacion.=",".$o;
	}
	
?>

var arrSituacion=[<?php echo $arrSituacion?>];
var arrDocumentos=<?php echo $arrDocumentos?>;
var arrSiNo=<?php echo $arrSiNo?>;
Ext.onReady(inicializar);

function inicializar()
{
	var arrGrids=[];
    
    if(gE('mostrarGridJuez').value=='1')
    	arrGrids.push(crearGridJuecesConocimiento());
    
   	arrGrids.push(crearGridInformeJueces()); 
    
    																	
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                //title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b></b></span>',                                               
                                                items:	[
                                                            {
                                                            	xtype:'tabpanel',
                                                                region:'center',
                                                                activeTab:0,
                                                                items:	arrGrids
                                                            }
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridJuecesConocimiento()
{
	var cmbConoce=crearComboExt('cmbConoce',arrSiNo);
    var cmbCarpeta=crearComboExt('cmbCarpeta',[]);
    var cmbImputadoAsociado=crearComboExt('cmbImputadoAsociado',[]);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idJuez'},
                                                        {name:'nombreJuez'},
		                                                {name: 'tieneConocimiento'},
                                                        {name: 'coincidenciaBusqueda'},
		                                                {name:'carpetaConocimiento'},
                                                        {name: 'arrCarpetas'},
                                                        {name: 'imputadoAsociado'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php',
																								  timeout :60000
                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreJuez', direction: 'ASC'},
                                                            groupField: 'nombreJuez',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='93';
                                        proxy.baseParams.idFormulario=gE('idFormulario').value;
                                        proxy.baseParams.idRegistro=gE('idRegistro').value;
                                    }
                        )   
       
       
	
    var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: 'Tiene conocimiento',
													   dataIndex: 'tieneConocimiento',
													   width: 120
                                                       
													}
												);
    
    
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                           
                                                            {
                                                                header:'Nombre del juez',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'nombreJuez'
                                                            },
                                                            checkColumn,
                                                            {
                                                                header:'',
                                                                width:30,
                                                                hidden:(gE('sL').value=='1'),
                                                                sortable:true,
                                                                css:'text-align:center;',
                                                                dataIndex:'coincidenciaBusqueda',                                                                
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var comp='';
                                                                            if(registro.data.coincidenciaBusqueda.length>0)
                                                                            {
                                                                            	var lblRegistros='';
                                                                                if(registro.data.coincidenciaBusqueda.length==1)
                                                                                {
                                                                                	lblRegistros='Existe 1 registro que pudiese indicar el conocimiento del juez';
                                                                                }
                                                                                else
                                                                                {
                                                                                	lblRegistros='Existen '+registro.data.coincidenciaBusqueda+' registros que pudiesen indicar el conocimiento del juez';
                                                                                }
                                                                            	comp='<a href="javascript:mostrarVentanaCoincidencias(\''+bE(registro.data.idJuez)+'\')"><div class="burbujaCoincidencia" title="'+lblRegistros+'" alt="'+lblRegistros+'">'+registro.data.coincidenciaBusqueda.length+'</div></a>';
                                                                            }
                                                                        	return comp;
                                                                        }
                                                                
                                                            },                                                          
                                                            
                                                            {
                                                                header:'Carpeta asociada',
                                                                width:200,
                                                                sortable:true,
                                                                editor:cmbCarpeta,
                                                                dataIndex:'carpetaConocimiento',
                                                                
                                                            },    
                                                            {
                                                                header:'Imputado asociado',
                                                                width:300,
                                                                sortable:true,
                                                                editor:cmbImputadoAsociado,
                                                                dataIndex:'imputadoAsociado',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(registro.data.carpetaConocimiento!='')
                                                                            {
                                                                            	var pos=existeValorMatriz(registro.data.arrCarpetas,registro.data.carpetaConocimiento);
                                                                                var rCarpeta=registro.data.arrCarpetas[pos];
                                                                                
                                                                                return formatearValorRenderer(rCarpeta[2],val);
                                                                                
                                                                            }
                                                                        }
                                                                
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gJuecesConocimiento',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                clicksToEdit:1,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                plugins:[checkColumn],
                                                                columnLines : true,
                                                                title:'Jueces conocen causa',
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/guardar.PNG',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Guardar',
                                                                                hidden:(gE('sL').value=='1'),
                                                                                handler:function()
                                                                                        {
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	registrarInformacionJueces()
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer guardar la informaci&oacute;n referente a los jueces?',resp)
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
                                                        
        tblGrid.on('beforeedit',function(e)
                                {
                                    if((gE('sL').value=='1')||((e.field=='carpetaConocimiento')&&(!e.record.data.tieneConocimiento)))
                                    {
                                    	e.cancel=true;
                                    }
                                    
                                    
                                    if(e.field=='carpetaConocimiento')
                                    {
                                        
                                        gEx('cmbCarpeta').getStore().loadData(e.record.data.arrCarpetas);
                                    }
                                    else
                                    {
                                    	if(e.field=='imputadoAsociado')
                                        {
                                        	if(e.record.data.carpetaConocimiento=='')
                                            {
                                                e.cancel=true;
                                            }
                                            else
                                            {
                                            	var pos=existeValorMatriz(e.record.data.arrCarpetas,e.record.data.carpetaConocimiento);
                                                var rCarpeta=e.record.data.arrCarpetas[pos];                                                
                                                gEx('cmbImputadoAsociado').getStore().loadData(rCarpeta[2]);
                                            }
                                        }
                                    	
                                        
                                    }
                                }
                    )                                                        
        
        
        tblGrid.on('afteredit',function(e)
                                {
                                    if(e.field=='carpetaConocimiento')
                                    {
                                        e.record.set('imputadoAsociado','');
                                    }
                                    
                                     if(e.field=='tieneConocimiento')
                                    {
                                    	e.record.set('carpetaConocimiento','');
                                        e.record.set('imputadoAsociado','');
                                    }
                                    
                                 }
                   )
        
                                                        
        return 	tblGrid;
}

function mostrarVentanaCoincidencias(iJ)
{
	var pos=obtenerPosFila(gEx('gJuecesConocimiento').getStore(),'idJuez',bD(iJ));
    var fila=gEx('gJuecesConocimiento').getStore().getAt(pos);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														crearGridCoincidencias(fila.data.coincidenciaBusqueda)

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Resultados de  b&uacute;squeda',
										width: 870,
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
                                                            hidden:(gE('sL').value=='1'),
															handler: function()
																	{
																		var filaCarpeta=gEx('idResultadoBusqueda').getSelectionModel().getSelected();
                                                                        if(!filaCarpeta)
                                                                        {
                                                                        	msgBox('Debe seleccionar la carpeta a asociar');
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(filaCarpeta.data.imputadoAplica=='')
                                                                        {
                                                                        	msgBox('Debe indicar el imputado con el cual se vincula el amparo');
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        fila.set('tieneConocimiento',true);
                                                                        fila.set('carpetaConocimiento',filaCarpeta.data.carpetaAdministrativa);
                                                                        fila.set('imputadoAsociado',filaCarpeta.data.imputadoAplica);
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

function crearGridCoincidencias(arrDatos)
{
	var cmbImputadosAplica=crearComboExt('cmbImputadosAplica',[]);
	var dsDatos=arrDatos;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'carpetaAdministrativa'},
                                                                    {name: 'imputados'},
                                                                    {name: 'imputadoAplica'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({'singleSelect':true,checkOnly:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Carpeta Judicial',
															width:150,
															sortable:true,
															dataIndex:'carpetaAdministrativa',
                                                            renderer:function(val)
                                                            		{
                                                                    	return '<a href="javascript:abrirCarpetaJudicial(\''+bE(val)+'\')">'+val+'</a>';
                                                                    }
														},
														{
															header:'Imputados',
															width:300,
															sortable:true,
															dataIndex:'imputados',
                                                            renderer:function(val)
                                                            		{
                                                                    	var lblImputados='';
                                                                        var x;
                                                                        for(x=0;x<val.length;x++)
                                                                        {
                                                                        	if(lblImputados=='')
                                                                            	lblImputados=val[x][1];
                                                                            else
                                                                            	lblImputados+="<br>"+val[x][1];
                                                                        }
                                                                        
                                                                        return lblImputados;
                                                                    }
														},
														{
															header:'Imputado aplica',
															width:300,
															sortable:true,
                                                           	editor:cmbImputadosAplica,
															dataIndex:'imputadoAplica',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return formatearValorRenderer(registro.data.imputados,val);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'idResultadoBusqueda',
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:10,
                                                            clicksToEdit:1,
                                                            sm:chkRow,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:360,
                                                            width:830
                                                            
                                                        }
                                                    );
                                                    
                                                    
	tblGrid.on('beforeedit',function(e)
    						{
                            	if(!e.grid.getSelectionModel().isSelected(e.row ))
                            		e.cancel=true;
                            	gEx('cmbImputadosAplica').getStore().loadData(e.record.data.imputados);
                            }
    		)                                                    
     
    tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
     												{
                                                    	registro.set('imputadoAplica','');
                                                    }
                                   )
                                   
    tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
     												{
                                                    	if(registro.data.imputados.length==1)
                                                        	registro.set('imputadoAplica',registro.data.imputados[0][0]);
                                                    }
                                   )
                                                    
	return 	tblGrid;	
}

function abrirCarpetaJudicial(c)
{
	
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAdministracion.php';
    obj.params=[['cA',c],['cPagina','sFrm=true'],['sL','1']];
    if(window.parent)
    	window.parent.abrirVentanaFancy(obj);
    else
    	abrirVentanaFancy(obj);
}

function crearGridInformeJueces()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idJuez'},
		                                                {name: 'nombreJuez'},
		                                                {name:'idDocumento'},
		                                                {name:'situacion'},
                                                        {name:'idRegistro'}
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
                                                sortInfo: {field: 'nombreJuez', direction: 'ASC'},
                                                groupField: 'idDocumento',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:true
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='94';
                                        proxy.baseParams.idFormulario=gE('idFormulario').value;
                                        proxy.baseParams.idRegistro=gE('idRegistro').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'Juez',
                                                                width:550,
                                                                sortable:true,
                                                                dataIndex:'nombreJuez'
                                                            },
                                                            {
                                                                header:'Documento de informe',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'idDocumento',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrDocumentos,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n informe',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacion,val,1,true);
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'idRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<a href="javascript:abrirVentanaDocumento(\''+bE(val)+'\')"><img src="../images/right1.png"></a>';
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gDocumentosInforme',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                title:'Documentos de Informes',
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/document_go.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:((gE('sL').value=='1')||(gE('mostrarGridJuez').value=='0')),
                                                                                text:'Generar documentos de informe',
                                                                                handler:function()
                                                                                        {
                                                                                        	registrarInformacionJueces(generarDocumentos);
                                                                                            
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

function registrarInformacionJueces(funcionAsociada)
{
	var arrJueces='';
	var gJuecesConocimiento=gEx('gJuecesConocimiento');
    var fila;
    var x;
    for(x=0;x<gJuecesConocimiento.getStore().getCount();x++)
    {
    	fila=gJuecesConocimiento.getStore().getAt(x);
        if(fila.data.tieneConocimiento)
        {
        
        	if(fila.data.carpetaConocimiento=='')
            {
            	msgBox('Debe indicar la carpeta atrav&eacute;s del cual el juez '+fila.data.nombreJuez+' tiene conocimiento');
            	return;
            }
            
            if(fila.data.idImputadoConocimiento=='')
            {
            	msgBox('Debe indicar el imputado del cual el juez '+fila.data.nombreJuez+' tiene conocimiento');
            	return;
            }
        
            j='{"idJuez":"'+fila.data.idJuez+'","tieneConocimiento":"'+(fila.data.tieneConocimiento?'1':'0')+
            	'","carpetaConocimiento":"'+fila.data.carpetaConocimiento+'","idImputadoConocimiento":"'+fila.data.imputadoAsociado+'"}';
            if(arrJueces=='')	
                arrJueces=j;
            else
                arrJueces+=','+j;
        }
    }
    
    var cadObj='{"idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistro').value+'","jueces":['+arrJueces+']}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(!funcionAsociada)
	            msgBox('La informaci&oacute;n ha sido almacenada correctamente');
            else
            	funcionAsociada();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=95&cadObj='+cadObj,true);
    
    
    
    
    
}

function generarDocumentos()
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gDocumentosInforme').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=96&idFormulario='+gE('idFormulario').value+
    				'&idRegistro='+gE('idRegistro').value,true);
    
}

function abrirVentanaDocumento(iR)
{
   	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};
    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            
            arrResp[1]=707;
            obj.params=[['idFormulario',363],['idRegistro',bD(iR)],['dComp',bE('auto')],['actor',bE(arrResp[1])]];
            
            
            if(window.parent)
                window.parent.abrirVentanaFancy(obj);
            else
                abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=97&iR='+bD(iR)+'&a='+gE('actor').value,true);
       
}

function recargarContenedorCentral()
{
	if(gEx('gJuecesConocimiento'))	
    	gEx('gJuecesConocimiento').getStore().reload();
    
    
    if(gEx('gDocumentosInforme'))	
    	gEx('gDocumentosInforme').getStore().reload();
    
}