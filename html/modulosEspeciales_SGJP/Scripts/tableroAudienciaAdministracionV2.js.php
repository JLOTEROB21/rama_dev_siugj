<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$arrEtapasProcesales=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	$carpetaAdministrativa=bD($_GET["cA"]);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	$fechaActual=date("Y-m-d");
	$diaActual=date("N",strtotime($fechaActual));
	$fechaFinal=7-$diaActual;
	
	$fechaFinal=date("Y-m-d",strtotime("+".$fechaFinal." days",strtotime($fechaActual)));
	
	$consulta="SELECT  id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
	$arrAudiencias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__15_tablaDinamica,nombreSala FROM _15_tablaDinamica";
	$arrSalas=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idSituacion,icono,tamano FROM 7011_situacionEventosAudiencia";
	$arrSituaciones=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa";
	$arrSituacionesCarpeta=$con->obtenerFilasArreglo($consulta);
	
	
?>
var arrSituacionDiscos=[['1','Solicitados'],['2','Entregados'],['3','Cancelados'],['4','Por entregar']];
var arrSituacionesCarpeta=<?php echo $arrSituacionesCarpeta?>;
var nodoCarpetaSel=null;
var arrCategorias=<?php echo $arrCategorias?>;
var arrEtapasProcesales=<?php echo $arrEtapasProcesales?>;
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var arrSalas=<?php echo $arrSalas?>;
var arrAudiencias=<?php echo $arrAudiencias?>;
var arrUnidades=<?php echo $arrUnidades?>;
var lblCarpeta='';
var arrTipoActa=[['1','Derivada de Determinaci\xF3n'],['2','Derivada de audiencia']];
var arrSituacionActa=[['1','En registro'],['2','Concluida']];

var arrSemaforo=<?php echo $arrSituaciones?>;



Ext.onReady(inicializar);

function inicializar()
{
	
    var vista=new Ext.Viewport(	{
                                layout: 'border',
                                listeners:	{
                                                show : {
                                                            buffer : 3000,
                                                            fn : function() 
                                                            {
                                                               
                                                                vista.doLayout();
                                                            }
                                                        }
                                             },
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                items:	[	
                                                			/*
                                                			{
                                                            	xtype:'panel',
                                                                width:250,
                                                                collapsible:true,
                                                                region:'west',
                                                                layout:'ux.row',
                                                                items:	[
                                                                            {
                                                                            	xtype:'panel',
                                                                                rowHeight:0.5,
                                                                                width:'100%',
                                                                                title:'Sujetos procesales',
                                                                                items:	[
                                                                                			crearArbolSujetosProcesales()
                                                                                		]
                                                                            },
                                                                            {
                                                                            	xtype:'panel',
                                                                                rowHeight:0.5,
                                                                                width:'100%',
                                                                                title:'Flujos asociados a Carpeta Administrativa',
                                                                                items:	[
                                                                                			crearArbolProcesos()
                                                                                		]
                                                                            }
                                                                		]
                                                            },*/
                                                            {
                                                            	xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                region:'center',
                                                                                layout:'border',
                                                                                title:'Carpeta Judicial [<span style="color:#900"><b>'+gE('carpetaAdministrativa').value+'</b></span>]',
                                                                                items:	[
                                                                                            {
                                                                                                xtype:'tabpanel',
                                                                                                activeTab:0,
                                                                                                region:'center',
                                                                                                split:true,
                                                                                                height:200,
                                                                                                border:false,                                                                                
                                                                                                items:	[
                                                                                                			{
                                                                                                            	xtype:'panel',
                                                                                                                layout:'border',
                                                                                                                title:'Documentos asociados a la carpeta judicial',
                                                                                                                items:	[
                                                                                                                			crearArbolCarpetasJudiciales(),
                                                                                                                			crearArbolCarpetaAdministrativa()
                                                                                                                		]
                                                                                                            }
                                                                                                            <?php
																											if(existeRol("'69_0'")||existeRol("'106_0'")||existeRol("'112_0'")||existeRol("'90_0'")||existeRol("'81_0'"))
																											{
																											?>
                                                                                                            ,
                                                                                                            
                                                                                                            crearGridEventos()
                                                                                                            <?php
																											}
																											?>
                                                                                                            <?php
																											if(existeRol("'1_0'"))
																											{
																											?>
                                                                                                            ,
                                                                                                            
                                                                                                            crearGridNotificadores()
                                                                                                            <?php
																											}
																											?>
                                                                                                            ,
                                                                                                            crearGridAdministracionCopiasDiscos()
                                                                                                            //crearGridHistorialCarpeta()
                                                                                                        ]
                                                                                            }
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

function crearArbolSujetosProcesales()
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
                                                                    funcion:'17',
                                                                    iE:-1,
                                                                    cA:bE(gE('carpetaAdministrativa').value)
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
                                                }
                                            )		
										
											
										
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                
                                                                id:'arbolSujetos',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:false,
                                                                height:((obtenerDimensionesNavegador()[0])/2)-45,
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	arbolSujetosJuridicos.on('dblclick',funcClickSujeto);	                                                    
                                                    
	return  arbolSujetosJuridicos;
}

function funcClickSujeto(nodo, evento)
{
	if(nodo.attributes.tipo!='0')
    {
    	var arrId=nodo.id.split('_');
        
        var obj={};
        var params=[['idRegistro',arrId[1]],['idFormulario',47],['dComp',bE('auto')],['actor',bE('0')]];
        obj.ancho='90%';
        obj.alto='95%';
        obj.url='../modeloPerfiles/vistaDTDv3.php';
        obj.params=params;
        obj.modal=true;
        abrirVentanaFancy(obj);
        
        
        
    }
}

function crearArbolProcesos()
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
                                                                    funcion:'18',
                                                                    iE:bE(gE('idEventoAudiencia').value),
                                                                    cA:bE(gE('carpetaAdministrativa').value)
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
                                                }
                                            )		
										
											
										
	var arbolProcesos=new Ext.ux.tree.TreeGrid	(
                                                    {
                                                        
                                                        id:'arbolProcesos',
                                                        useArrows:true,
                                                        animate:true,
                                                        width:250,
                                                        enableDD:false,
                                                        ddScroll:true,
                                                        containerScroll: true,
                                                        autoScroll:true,
                                                        border:false,
                                                        height:((obtenerDimensionesNavegador()[0])/2)-45,
                                                        root:raiz,
                                                        lines : false,
                                                        enableSort:false,
                                                        loader: cargadorArbol,
                                                        
                                                        rootVisible:false,
                                                        columns:[
                                                                    
                                                                    {
                                                                        header:'Flujo',
                                                                        width:230,
                                                                        dataIndex:'text'
                                                                    },
                                                                    {
                                                                        header:'Fecha registro',
                                                                        width:160,
                                                                        dataIndex:'fechaCreacion'
                                                                    },
                                                                    
                                                                    {
                                                                        header:'Situaci&oacute;n',
                                                                        width:500,
                                                                        dataIndex:'situacion'
                                                                    }
                                                                 ]
                                                    }
                                                )
         
         
                                                    
	arbolProcesos.on('dblclick',funcClickArbolProcesos);	                                                    
                                                    
	return  arbolProcesos;
}

function funcClickArbolProcesos(nodo, evento)
{
	if(nodo.attributes.tipo!='0')
    {
    	
        var obj={};
        var params=[['idRegistro',nodo.attributes.idRegistro],['idFormulario',nodo.attributes.idFormulario],['dComp',bE('auto')],['actor',bE('0')]];
        obj.ancho='90%';
        obj.alto='95%';
        obj.url='../modeloPerfiles/vistaDTDv3.php';
        obj.params=params;
        obj.modal=true;
        abrirVentanaFancy(obj);
        
        
        
    }
}

function crearArbolCarpetaAdministrativa()
{
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrCategorias);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
                                                        {name:'idFormulario'},
                                                        {name:'idRegistro'},
                                                        {name:'idDocumento'},
                                                        {name: 'categoriaDocumentos'}
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
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='19';
                                        
                                        proxy.baseParams.cA=bE(nodoCarpetaSel.id);
                                    }
                        )   
       
    
    
    var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'date', dataIndex: 'fechaCreacion'},
                                                                        {type: 'string', dataIndex: 'nomArchivoOriginal'},
                                                                        {type: 'list', dataIndex: 'categoriaDocumentos', phpMode:true, options:arrCategorias}
                                                                    ]
                                                    }
                                                );    
       
	var expander = new Ext.ux.grid.RowExpander({
                                                column:1,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
                                                    '<tr><td ><span class="TSJDF_Control">{descripcion}</span><br /><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            });        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	new  Ext.grid.RowNumberer({width:30}),
                                                        expander,
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" />'
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:120,
                                                            hidden:<?php echo ($_SESSION["codigoInstitucion"]=="005")?"false":"true"; ?>,
                                                            sortable:true,
                                                            dataIndex:'fechaRegistro',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y');
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:120,
                                                            hidden:<?php echo ($_SESSION["codigoInstitucion"]=="005")?"false":"true"; ?>,
                                                            sortable:true,
                                                            dataIndex:'fechaCreacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y H:i');
                                                                    }
                                                        },{
                                                            header:'Tipo documento',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'categoriaDocumentos',
                                                            editor:cmbTipoDocumento,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCategorias,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Etapa procesal',
                                                            width:250,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'etapaProcesal',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasProcesales,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Documento',
                                                            width:500,
                                                            sortable:true,
                                                            dataIndex:'nomArchivoOriginal',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        
                                                        {
                                                            header:'Tama&ntilde;o',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'tamano',
                                                            renderer:function(val)
                                                            		{
                                                                    	return bytesToSize(parseInt(val),0);
                                                                    }
                                                        },
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if((registro.data.idFormulario=='')||((registro.data.idFormulario=='-1')&&(registro.data.idRegistro=='-1')))
                                                                        {
                                                                        	if(gE('sL').value=='1')
                                                                            	return '';
	                                                                        return '<a href="javascript:removerDocumento(\''+bE(val)+'\')"><img src="../images/delete.png" title="Remover documento" alt="Remover documento" /></a>';
                                                                        }
                                                                        else
                                                                        	if(registro.data.idFormulario!='-1')
	                                                                        	return '<a href="javascript:abrirProcesoOrigen(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')"><img src="../images/magnifier.png" title="Abrir proceso origen" alt="Abrir proceso origen" /></a>';
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCarpetaAdministrativa',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            clicksToEdit:1,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,  
                                                            plugins:[expander,filters],   
                                                            tbar:	[
                                                            			
                                                            			{
                                                                        	html:'<div style="height:20px"><b>Documentos asociados a la carpeta judicial <span id="lblCarpetaJudicial" style="color:#900">[]</span></b></div>'
                                                                        }
                                                            		],                                                       
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :<?php echo ($_SESSION["codigoInstitucion"]=="005")?"true":"false"; ?>,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: true,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'<span style="color:#900"><b>{text}</b> ({[values.rs.length]} {[values.rs.length > 1 ? "Documentos" : "Documento"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    
	
    tblGrid.on('afteredit',function(e)
    						{
                            	function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        
                                    }
                                    else
                                    {
                                    	function respErr()
                                        {
                                        	e.record.set(e.field,e.originalValue);
                                        }
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],respErr);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=57&iD='+e.record.data.idDocumento+'&tD='+e.value,true);
                                
                            }
    			)
    
    tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                  	mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  )                                                    
                                                    
    return 	tblGrid;	
}

function crearGridAcciones()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idAccion'},
		                                                {name: 'etiqueta'},
		                                                {name: 'tipoModulo'},
		                                                {name: 'datosConfiguracion'}
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
                                                            sortInfo: {field: 'etiqueta', direction: 'ASC'},
                                                            groupField: 'etiqueta',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='20';
                                        proxy.baseParams.iE=bE(gE('idEventoAudiencia').value);
                                        proxy.baseParams.cA=bE(gE('carpetaAdministrativa').value);
                                        proxy.baseParams.iP=bE(idPerfil);
                                    }
                        )   
       
    
    
        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        
                                                        {
                                                            header:'Acci&oacute;n',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'etiqueta'
                                                        },
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'datosConfiguracion',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(gE('sL').value=='1')
                                                                        	return '';
                                                                    	return '<a href="javascript:dispararAccion(\''+val+'\')"><img src="../images/right1.png" title="Disparar acci&oacute;n" alt="Disparar acci&oacute;n" /></a>'
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridAccionesDisponibles',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            disabled:(gE('sL').value=='1'),
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
                                                                                                startCollapsed:false
                                                                                            })
                                                        }
                                                    );
                                                    
	                  
    return 	tblGrid;
}

function dispararAccion(cadConf)
{
	var cadObj=bD(cadConf);
    var oConf=eval('['+cadObj+']')[0];
    var dConf=oConf.objConf;
    if(oConf.ejecutarFuncion.indexOf('(')!==-1)
    {
    	eval(oConf.ejecutarFuncion+';');
    }
    else
    	eval(oConf.ejecutarFuncion+'(dConf);');
}

function crearGridHistorialAcciones()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idRegistro'},
                                                        {name: 'iFormulario'},
		                                                {name: 'iRegistro'},
		                                                {name: 'etiqueta'},
                                                        {name: 'situacion'},
                                                        {name: 'actor'}
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
                                                            sortInfo: {field: 'idRegistro', direction: 'ASC'},
                                                            groupField: 'etiqueta',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='22';
                                        proxy.baseParams.iE=bE(gE('idEventoAudiencia').value);
                                        
                                        
                                    }
                        )   
       
    
    
        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        
                                                        {
                                                            header:'Acci&oacute;n',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'etiqueta',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'Situaci&oacute;n',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'situacion',
                                                            renderer:mostrarValorDescripcion
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridHistorialAcciones',
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
                                                                                                startCollapsed:false
                                                                                            })
                                                        }
                                                    );
                                                    

		tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var obj={};
                                    var params=[['idRegistro',registro.data.iRegistro],['idFormulario',registro.data.iFormulario],['dComp',bE('auto')],['actor',bE(registro.data.actor)]];
                                    obj.ancho='100%';
                                    obj.alto='100%';
                                    obj.url='../modeloPerfiles/vistaDTDv3.php';
                                    obj.params=params;
                                    obj.modal=true;
                                    abrirVentanaFancy(obj);
                              }
                  )                                                    
                               

	                  
    return 	tblGrid;
}

function recargarGrids()
{
	//gEx('gridHistorialAcciones').getStore().reload();
    //gEx('arbolProcesos').getStore().reload();
    if(gEx('gridCarpetaAdministrativa'))
	    gEx('gridCarpetaAdministrativa').getStore().reload();
    if(gEx('gridAudiencias'))
    	gEx('gridAudiencias').getStore().reload();   
    
    
    
}

function regresar1Pagina()
{
	recargarGrids();
}

function regresar2Pagina()
{
	recargarGrids();
	
}

function recargarContenedorCentral()
{
	recargarGrids();

    
}

function regresar1PaginaContenedor()
{
	recargarGrids();


}

function regresarPagina2Contenedor()
{
	recargarGrids();


}

function regresarContenedorCentral()
{
	recargarGrids();

}


function crearGridEventos()
{

	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idEvento'},
                                                        {name: 'carpetaAdministrativa'},
		                                                {name: 'fechaEvento', type:'date', dateFormat:'Y-m-d'},
		                                                {name: 'horaInicial', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'horaInicialReal', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinalReal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'urlMultimedia'},
                                                        {name: 'tipoAudiencia'},
                                                        {name: 'sala'},
                                                        {name: 'unidadGestion'},
                                                        {name: 'situacion'},
                                                        {name: 'juez'}  ,
                                                        {name: 'tImputados' },
                                                        {name: 'iFormulario' }, 
                                                        {name: 'iRegistro' },
                                                        {name: 'iFormularioSituacion'},                                                     
                                                        {name: 'iRegistroSituacion'},
                                                        {name: 'notificacionMAJO'},
                                                        {name: 'mensajeMAJO'},
                                                        {name: 'delitos'}  
                                                        
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
                                                            sortInfo: {field: 'fechaEvento', direction: 'ASC'},
                                                            groupField: 'fechaEvento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                    	proxy.baseParams.funcion='53';
                                        proxy.baseParams.cJ='<?php echo $carpetaAdministrativa?>';
                                        if(gEx('btnConfirmarAudiencia'))
	                                        gEx('btnConfirmarAudiencia').disable();
                                    }
                        )   
       
       
       var filters = new Ext.ux.grid.GridFilters	(
                                                        {
                                                            filters:	[
                                                            				{
                                                                            	type:'string',
                                                                                dataIndex:'carpetaAdministrativa'
                                                                            },
                                                                            {
                                                                            	type:'date',
                                                                                dataIndex:'fechaEvento'
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'tipoAudiencia',
                                                                                options:arrAudiencias,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'sala',
                                                                                options:arrSalas,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'string',
                                                                                dataIndex:'juez'
                                                                            }
                                                            			]
                                                        }
                                                    );  
       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'ID Evento',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'idEvento',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(gE('sL').value=='1')
                                                                            	return val;
                                                                        	return '<a href="javascript:abrirTableroAudiencia(\''+bE(val)+'\')">'+val+'</a>';
                                                                        }
                                                                
                                                            },
                                                            
                                                            
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var icono='';
                                                                            meta.attr='style="padding: 0px !important;"';
                                                                        	icono=formatearValorRenderer(arrSemaforo,val);    
                                                                            var tamano=formatearValorRenderer(arrSemaforo,val,2);                                                                            
                                                                            return '<img src="'+icono+'" width="'+tamano+'" height="'+tamano+'" title="'+formatearValorRenderer(arrSituacionEvento,val)+'" alt="'+formatearValorRenderer(arrSituacionEvento,val)+'">';
                                                                        }
                                                            },
                                                             {
                                                                header:'Situaci&oacute;n audiencia',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        
                                                                        	var comp='';
                                                                            /*if(registro.data.iRegistroSituacion!='-1')
                                                                            {
                                                                            	comp='<a href="javascript:abrirFormatoRegistro(\''+bE(registro.data.iFormularioSituacion)+'\',\''+
                                                                                		bE(registro.data.iRegistroSituacion)+'\')"><img src="../images/magnifier.png" title="Ver detalles..."'+
                                                                                        ' alt="Ver detalles..."></a> ';
                                                                            }*/
                                                                        	return comp+mostrarValorDescripcion(formatearValorRenderer(arrSituacionEvento,val));
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                css:'text-align:center;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                            var comp2='';
                                                                            
                                                                            
                                                                           	switch(val)
                                                                            {
                                                                            	case '4':
                                                                                	if(registro.data.urlCanal!='')
                                                                                		comp2='<a href="javascript:abrirVentanaSala(\''+bE(registro.data.sala)+'\')"><img src="../images/film_go.png" title="Visualizar audiencia" alt="Visualizar audiencia" /></a>'
                                                                                break;
                                                                                case '2':
                                                                                	if(registro.data.urlMultimedia!='')
                                                                                		comp2='<a href="javascript:abrirVideoGrabacion(\''+bE(registro.data.idEvento)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                              	break;
                                                                            }
                                                                            
                                                                            var comp='';
                                                                            if(registro.data.iRegistroSituacion!='-1')
                                                                            {
                                                                            	comp='<a href="javascript:abrirFormatoRegistro(\''+bE(registro.data.iFormularioSituacion)+'\',\''+
                                                                                		bE(registro.data.iRegistroSituacion)+'\')"><img src="../images/magnifier.png" title="Ver detalles..."'+
                                                                                        ' alt="Ver detalles..."></a> ';
                                                                            }
                                                                            
                                                                        	return comp+comp2;
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta judicial',
                                                                width:150,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Fecha audiencia',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'fechaEvento',
                                                                renderer:function(val)
                                                                	{
                                                                    	return val.format('d/m/Y');
                                                                    }
                                                            },
                                                            {
                                                                header:'Hora programada de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicial',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                            <?php
															if((existeRol("'69_0'"))||(existeRol("'1_0'"))||(existeRol("'107_0'"))||existeRol("'112_0'")||existeRol("'81_0'"))
															{
															?>
                                                            {
                                                                header:'Notificacion MAJO',
                                                                width:120,
                                                                align:'center',
                                                                hidden:gE('sL').value=='1',
                                                                sortable:true,
                                                                dataIndex:'notificacionMAJO',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	var comp='';
                                                                        var icono='';
                                                                    	if(val=='1')
                                                                        {
                                                                        	icono='icon_big_tick.gif';
                                                                            registro.data.mensajeMAJO='Enviado MAJO con &eacute;xito';
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(val=='')
                                                                            {
                                                                            	icono='icon_info.gif';
                                                                                registro.data.mensajeMAJO='Sin registro en bit&aacute;cora';

                                                                            }
                                                                            else
                                                                        		icono='cross.png';
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        return '<a href="javascript:reenviarMAJO(\''+bE(registro.data.idEvento)+'\')"><img src="../images/arrow_refresh.PNG" title="Reenviar a MAJO" alt="Reenviar a MAJO"/></a>&nbsp;&nbsp;<img src="../images/'+icono+
                                                                        	'" title="'+cv(registro.data.mensajeMAJO,true,true)+'" alt="'+cv(registro.data.mensajeMAJO,true,true)+'" />'+comp;
                                                                    }
                                                            },
                                                            <?php
															}
															?>
                                                            {
                                                                header:'Hora de realizaci&oacute;n de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicialReal',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(!val)
                                                                        {
                                                                        	return '(Datos no disponibles)';
                                                                        }
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinalReal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinalReal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinalReal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de audiencia',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'tipoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrAudiencias,val));
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Sala',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'sala',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrSalas,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Juez',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'juez'
                                                            },
                                                            {
                                                            	header:'Total imputados',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'tImputados'
                                                            },
                                                            {
                                                            	header:'Delitos',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'delitos',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                           
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridAudiencias',
                                                                store:alDatos,
                                                                region:'center',
                                                                title:'Historial de audiencias',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : true,      
                                                                plugins:	[filters],
                                                                tbar:	[
                                                                			<?php
																			if((existeRol("'69_0'"))||(existeRol("'1_0'"))||existeRol("'112_0'")||existeRol("'81_0'"))
																			{
																			?>
                                                                            {
                                                                                icon:'../images/calendar_edit.jpg',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Programar nueva audiencia',
                                                                                handler:function()
                                                                                        {
                                                                                         	registrarNuevaSolicitudAudiencia();   
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/addAccion.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Acciones audiencia',
                                                                                menu:	[
                                                                                			{
                                                                                            	id:'btnConfirmarAudiencia',
                                                                                                icon:formatearValorRenderer(arrSemaforo,'1'),
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                text:'Confirmar audiencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var fila;
                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();
                                                                                                            
                                                                                                            var obj={};    
                                                                                                            obj.ancho='100%';
                                                                                                            obj.alto='100%';
                                                                                                            obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                                            
                                                                                                            
                                                                                                            function funcAjax()
                                                                                                            {
                                                                                                                var resp=peticion_http.responseText;
                                                                                                                arrResp=resp.split('|');
                                                                                                                if(arrResp[0]=='1')
                                                                                                                {
                                                                                                                    var actor=arrResp[1];
                                                                                                                    
                                                                                                                    obj.params=[['idEventoReferencia',-1],['carpetaAdministrativa','<?php echo $carpetaAdministrativa?>'],['idFormulario',fila.data.iFormulario],['idRegistro',fila.data.iRegistro],['idReferencia',-1],
                                                                                                                            ['dComp',bE('auto')],['actor',bE(actor)]];
                                                                                                                    abrirVentanaFancy(obj);
                                                                                                                }
                                                                                                                else
                                                                                                                {
                                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                }
                                                                                                            }
                                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=108&iF='+fila.data.iFormulario+'&iR='+fila.data.iRegistro+'&r=69_0',true);
                                                                                                            
                                                                                                            
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            
                                                                                            
                                                                                            ,'-',
                                                                                            {
                                                                                            	id:'btnFinalizarAudiencia',
                                                                                                icon:formatearValorRenderer(arrSemaforo,'2'),
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                text:'Registrar finalizaci&oacute;n de audiencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var fila;
                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();
                                                                                                            
                                                                                                            mostrarVentanaFinalizarAudiencia(fila);
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            {
                                                                                            	id:'btnRegistrarAcuerdo',
                                                                                                icon:formatearValorRenderer(arrSemaforo,'6'),
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                text:'Registrar resoluci&oacute;n mediante acuerdo',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var fila;
                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();
                                                                                                            
                                                                                                            mostrarVentanaFinalizarPorAcuerdo(fila);
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            {
                                                                                            	id:'btnCancelarAudiencia',
                                                                                                icon:formatearValorRenderer(arrSemaforo,'3'),
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                text:'Cancelar audiencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var fila;                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();                                                                                                            
                                                                                                            mostrarVentanaCancelarAudiencia(fila);
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            {
                                                                                            	id:'btnModificarAudiencia',
                                                                                                icon:'../images/pencil.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                hidden:true,
                                                                                                text:'Modificar audiencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var fila;
                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();
                                                                                                            
                                                                                                            mostrarVentanaFinalizarAudiencia();
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            
                                                                                           
                                                                                            
                                                                                		]
                                                                                
                                                                            }
                                                                            <?php
																							}
																						   ?> 
                                                                        ],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );

	tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
    											{
                                                	gEx('btnConfirmarAudiencia').disable();
                                                    gEx('btnFinalizarAudiencia').disable();
                                                    gEx('btnRegistrarAcuerdo').disable();
                                                    gEx('btnCancelarAudiencia').disable();
                                                    gEx('btnModificarAudiencia').disable();
                                                    
                                                    switch(registro.data.situacion)
                                                    {
                                                    	case '0':  //En espera de confirmación
                                                        	gEx('btnConfirmarAudiencia').enable();
                                                            gEx('btnRegistrarAcuerdo').enable();
                                                            gEx('btnCancelarAudiencia').enable();
                                                            gEx('btnModificarAudiencia').enable();
                                                        break;
                                                        case '1':  //Confirmada
                                                        	gEx('btnRegistrarAcuerdo').enable();
                                                            gEx('btnCancelarAudiencia').enable();
                                                            gEx('btnModificarAudiencia').enable();
                                                            gEx('btnFinalizarAudiencia').enable();
                                                        break;
                                                        case '2':  //Finalizada
                                                        	
                                                        break;
                                                        case '3':  //Cancelado
                                                        	
                                                        break;
                                                        case '4':  //En desarrollo
                                                        	gEx('btnFinalizarAudiencia').enable();
                                                        break;
                                                        case '5':  //Pausada
                                                        	gEx('btnFinalizarAudiencia').enable();
                                                        break;
                                                        case '6':  //Resuelta por acuerdo
                                                        	
                                                        break;
                                                    }
                                                    
                                                }
    							)

	tblGrid.getSelectionModel().on('rowdeselect',function()
    											{
                                                	gEx('btnConfirmarAudiencia').disable();
                                                    gEx('btnFinalizarAudiencia').disable();
                                                    gEx('btnRegistrarAcuerdo').disable();
                                                    gEx('btnCancelarAudiencia').disable();
                                                    gEx('btnModificarAudiencia').disable();
                                                }
    							)

        return 	tblGrid;

}

function registrarSolicitudAudiencia(iE,cA)
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
            obj.params=[['idEventoReferencia',bD(iE)],['carpetaAdministrativa',bD(cA)],['idFormulario',185],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=52&iE='+bD(iE),true);
 
}

function registrarNuevaSolicitudAudiencia()
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
            obj.params=[['idEventoReferencia',-1],['carpetaAdministrativa','<?php echo $carpetaAdministrativa?>'],['idFormulario',185],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=54&cA=<?php echo $carpetaAdministrativa?>&iE=-1',true);
 
 
}

function mostrarVentanaAgregarDocumento()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:0,
                                                            y:0,
                                                            html:	'<span id="tblUpload">'+
                                                            		'<table width="720"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr></table>'+
                                                                	'</span>'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar documento a Carpeta Judicial:&nbsp;&nbsp;&nbsp;'+lblCarpeta,
										width: 750,
										height:350,
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
                                                                	$("#uploader").pluploadQueue({
                                    
                                                                                                    runtimes : 'html5,flash,silverlight,html4',
                                                                                                    url : "../modulosEspeciales_SGJP/procesarDocumentoCarpetaJudicial.php",
                                                                                                    prevent_duplicates:true,
                                                                                                    file_data_name:'archivoEnvio',
                                                                                                    multiple_queues:true,
                                                                                                    max_retries:10,
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                    multipart_params:	{
                                                                                                                            cA:nodoCarpetaSel.id
                                                                                                                        },
                                                                                                    
                                                                                                    rename : true,
                                                                                                    dragdrop: true,
                                                                                                    init:	{	
                                                                                                    	
                                                                                                                UploadComplete:function(up,archivos)
                                                                                                                                {
                                                                                                                                 	gEx('gridCarpetaAdministrativa').getStore().reload();
                                                                                                                                },
                                                                                                               	FileUploaded:function(up,archivos,response)
                                                                                                                				{
                                                                                                                                	
                                                                                                                                    if(response.response=='1|')
                                                                                                                                    {
                                                                                                                                    	up.removeFile(archivos);
                                                                                                                                    }
                                                                                                                                }
                                                                                                            },
                                                                                                    filters : 	{
                                                                                                                    // Maximum file size
                                                                                                                    max_file_size : '512mb',
                                                                                                                    // Specify what files to browse for
                                                                                                                    mime_types: [
                                                                                                                        {title : "Archivos de imagen", extensions : "jpg,gif,png"},
                                                                                                                        {title : "Documentos PDF", extensions : "pdf"}
                                                                                                                    ]
                                                                                                                },
                                                                                             
                                                                                                    // Resize images on clientside if we can
                                                                                                    resize: {
                                                                                                                width : 200,
                                                                                                                height : 200,
                                                                                                                quality : 90,
                                                                                                                crop: true // crop to exact dimensions
                                                                                                            },
                                                                                             
                                                                                             
                                                                                                    // Flash settings
                                                                                                    flash_swf_url : '../Scripts/plupload/js/Moxie.swf',
                                                                                                 
                                                                                                    // Silverlight settings
                                                                                                    silverlight_xap_url : '../Scripts/plupload/js/Moxie.xap'
                                                                                                });
																
                                                                	$("#uploader").bind('UploadComplete', function(up, files) 
                                                                                                          {
                                                                                                              // Called when all files are either uploaded or failed
                                                                                                              alert('ok');
                                                                                                         }
                                                                 
                                                                 						)
                                                                                                          
                                                                                                          
                                                                }
															}
												},
										buttons:	[
														{
															
															text: 'Cerrar',
                                                            
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

function crearArbolCarpetasJudiciales()
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
                                                                    funcion:'55',
                                                                    iE:-1,
                                                                    cA:bE(gE('carpetaAdministrativa').value)
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
                                                }
                                            )		
										
	
    cargadorArbol.on('load',function(l,raiz)
    						{
                            	
	                            nodoCarpetaSel=buscarNodoID(raiz.childNodes[0],gE('carpetaAdministrativa').value);
                                
                                
                                
                                nodoCarpetaSel.select();
                            	funcClickCarpetaJudicial(nodoCarpetaSel);
                            }
    				)
    											
										
	var arbolCarpetas=new Ext.tree.TreePanel	(
                                                            {
                                                                
                                                                id:'arbolCarpetas',
                                                                region:'west',
                                                                useArrows:true,
                                                                animate:true,
                                                                width:250,
                                                                title:'Carpetas Judiciales Asocidas',
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:false,
                                                                root:raiz,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                hidden:gE('sL').value=='1',
                                                                                id:'btnAdjuntar',
                                                                                text:'Adjuntar documentos',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAgregarDocumento();
                                                                                        }
                                                                                
                                                                            }
                                                                        ],  
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	arbolCarpetas.on('click',funcClickCarpetaJudicial);	                                                    
                                                    
	return  arbolCarpetas;
}

function funcClickCarpetaJudicial(nodo, evento)
{
	lblCarpeta='';
	nodoCarpetaSel=nodo;
    
    var arrCarpeta=[];
    var nodoAux=nodo;
    arrCarpeta.push(nodoAux.id);
    while(nodoAux.parentNode.id!='-1')
    {
    	arrCarpeta.push(nodoAux.parentNode.id);
    	nodoAux=nodoAux.parentNode;
    }
    
    var x;
    var color='030';
    for(x=arrCarpeta.length-1;x>=0;x--)
    {
    	if(x==0)
        	color='900';
    	if(lblCarpeta=="")
        	lblCarpeta='<span style="color:#'+color+'"><b>'+arrCarpeta[x]+'</b></span>';
        else
        	lblCarpeta+='<span style="color:#F00"><b> >> </b></span> <span style="color:#'+color+'"><b>'+arrCarpeta[x]+'</b></span>';
    }
    
    
	gEx('btnAdjuntar').enable();
    
    if(nodoCarpetaSel.id!=gE('carpetaAdministrativa').value)
    	gEx('btnAdjuntar').disable();
    
    gE('lblCarpetaJudicial').innerHTML='&nbsp;&nbsp;&nbsp;<b>'+lblCarpeta+'</b>';
    gEx('gridCarpetaAdministrativa').getStore().reload();
    
    
    
    
    
}

function removerDocumento(iD)
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
                                                            html:'Ingrese el motivo por el cual desea remover el documento'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            id:'txtMotivo',
                                                            xtype:'textarea',
                                                            width:500,
                                                            height:80
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Remover documento de carpeta judicial',
										width: 550,
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
                                                                	gEx('txtMotivo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtMotivo=gEx('txtMotivo');	
                                                                        if(txtMotivo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtMotivo.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el motivo por el cual desea remover el documento',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        function respQuestion(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                    	gEx('gridCarpetaAdministrativa').getStore().reload();
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=56&motivo='+cv(txtMotivo.getValue())+'&cA='+nodoCarpetaSel.id+'&iD='+bD(iD),true);
                                                                                
                                                                            
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer remover el documento de la carpeta judicial?',respQuestion);
                                                                        
                                                                        
                                                                        
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

function abrirProcesoOrigen(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['actor',bE(0)],['dComp',bE('auto')]];
    abrirVentanaFancy(obj);
    
    
}

function mostrarVentanaFinalizarAudiencia(fila)
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
            obj.params=[['idFormulario',321],['idRegistro',arrResp[1]],['idEvento',fila.data.idEvento],
            			['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=58&iFormulario=321&idEstadoIgn=2&iE='+fila.data.idEvento,true);
}

function mostrarVentanaFinalizarPorAcuerdo(fila)
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
            obj.params=[['idFormulario',322],['idRegistro',arrResp[1]],['idEvento',fila.data.idEvento],
            			['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=58&iFormulario=322&iE='+fila.data.idEvento,true);
}

function mostrarVentanaCancelarAudiencia(fila)
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
            obj.params=[['idFormulario',323],['idRegistro',arrResp[1]],['idEvento',fila.data.idEvento],
            			['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=58&iFormulario=323&iE='+fila.data.idEvento,true);
}

function mostrarVentanaModificarAudiencia(fila)
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
            obj.params=[['idFormulario',324],['idRegistro',arrResp[1]],['idEvento',fila.data.idEvento],
            			['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=59&iFormulario=324&iE='+fila.data.idEvento,true);
}


function abrirFormatoRegistro(iF,iR)
{

	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],
                ['dComp',bE('auto')],['actor',bE(0)]];
    abrirVentanaFancy(obj);
}

function abrirTableroAudiencia(iE)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudiencia.php';
    obj.params=[['idEventoAudiencia',bD(iE)]];    

    abrirVentanaFancy(obj);
}

function reenviarMAJO(iE)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gridAudiencias').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=83&iE='+bD(iE),true);
}


function abrirVentanaSala(iS)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorStreamSalaAudiencia.php';
    obj.params=[['idSala',iS],['cPagina','sFrm=true']]
    abrirVentanaFancy(obj);
}

function abrirVideoGrabacion(idEventoAudiencia)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorGrabacionAudiencia.php';
    obj.params=[['idEvento',idEventoAudiencia],['cPagina','sFrm=true']]
    abrirVentanaFancy(obj);
}

function crearGridNotificadores()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idActaNotificacion'},
		                                                {name: 'fechaActa', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name:'tipoActa'},
                                                        {name: 'tituloActa'},
		                                                {name:'fechaDeterminacionAudiencia',type:'date',dateFormat:'Y-m-d'},
                                                        {name: 'noDiligencias'},
                                                        {name: 'responsableActa'},
                                                        {name: 'situacion'},
                                                        {name: 'documentoActa'}
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
                                                            sortInfo: {field: 'fechaActa', direction: 'ASC'},
                                                            groupField: 'fechaActa',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnRemoverActa').disable();
                                    	proxy.baseParams.funcion='124';
                                        proxy.baseParams.cA=gE('carpetaAdministrativa').value;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),  
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idActaNotificacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(parseInt(registro.data.situacion)==2)
                                                                            {
                                                                            	return '<a href="javascript:visualizarActaCircunstanciada(\''+bE(val)+'\')"><img src="../images/page_white_magnify.png" title="Visualizar acta circunstanciada" alt="Visualizar acta circunstanciada"/></a>';
                                                                            }
                                                                        }
                                                            },                                                          
                                                            {
                                                                header:'Fecha del acta',
                                                                width:95,
                                                                sortable:true,
                                                                dataIndex:'fechaActa',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i:s');
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de acta',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'tipoActa',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoActa,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre determinaci&oacute;n/audiencia',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'tituloActa',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	meta.attr='style="height:auto !important;white-space: normal;line-height: 14px;"';
                                                                        	return mostrarValorDescripcion(val);
                                                                        	
                                                                        }
                                                            }
                                                            ,
                                                            {
                                                                header:'Total diligencias',
                                                                width:110,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'noDiligencias',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            },
                                                            {
                                                                header:'Registrado por',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'responsableActa',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Situaci&oacute;n acta',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacionActa,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gActaCircunstanciadaNotificadores',
                                                                store:alDatos,
                                                                title:'Notificaciones',
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Crear Acta Circunstanciada',
                                                                                handler:function()
                                                                                        {
                                                                                            var arrParam=[['cA',gE('carpetaAdministrativa').value],['iActa',-1]];
                                                                                            enviarFormularioDatos('../modulosEspeciales_SGJP/tblActaCircunstanciada.php',arrParam);
                                                                                            
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar Acta Circunstanciada',
                                                                                handler:function()
                                                                                        {
                                                                                         	var fila=  gEx('gActaCircunstanciadaNotificadores').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el registro del acta circunstanciada que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            var arrParam=[['cA',gE('carpetaAdministrativa').value],['iActa',fila.data.idActaNotificacion]];
                                                                                            enviarFormularioDatos('../modulosEspeciales_SGJP/tblActaCircunstanciada.php',arrParam);
                                                                                        }
                                                                                
                                                                            }
                                                                            ,'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                               	id:'btnRemoverActa',
                                                                                text:'Remover Acta Circunstanciada',
                                                                                handler:function()
                                                                                        {
                                                                                         	var fila=  gEx('gActaCircunstanciadaNotificadores').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el registro del acta circunstanciada que desea remover');
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
                                                                                                        	gEx('btnRemoverActa').disable();
                                                                                                            gEx('gActaCircunstanciadaNotificadores').getStore().remove(fila);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=125&iA='+fila.data.idActaNotificacion,true);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la acta seleccionada?',resp);
                                                                                            return;
                                                                                            
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
                                                        
	tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
    											{
                                                	gEx('btnRemoverActa').disable();
                                                    if(parseInt(registro.data.situacion)==1)
                                                    {
                                                    	gEx('btnRemoverActa').enable();
                                                    }
                                                }
    								)                                                        
                                                        
        return 	tblGrid;
}

function visualizarActaCircunstanciada(iA)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrNombre=arrResp[2].split('.');
            extension=arrNombre[arrNombre.length-1];
            mostrarVisorDocumentoProceso(extension,arrResp[1]);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=131&tD=214&iF=-1&iR='+bD(iA),true);
}

function crearGridHistorialCarpeta()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'fechaCambio', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name:'responsableCambio'},
                                                        {name: 'idEstadoAnterior'},		                                                
                                                        {name: 'idEstadoActual'},
                                                        {name: 'comentariosAdicionales'}
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
                                                            sortInfo: {field: 'fechaCambio', direction: 'DESC'},
                                                            groupField: 'fechaCambio',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                    	proxy.baseParams.funcion='124';
                                        proxy.baseParams.cA=gE('carpetaAdministrativa').value;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),  
                                                            
                                                            {
                                                                header:'Fecha de cambio',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaCambio',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i:s');
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n anterior',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'idEstadoAnterior',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacionesCarpeta,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'idEstadoActual',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacionesCarpeta,val);
                                                                        }
                                                            }
                                                            ,
                                                            {
                                                                header:'Responsable cambio',
                                                                width:250,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'responsableCambio',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gHistorialCambiosCarpeta',
                                                                store:alDatos,
                                                                title:'Historial de cambios de situaci&oacute;n',
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
						                                                                            getRowClass : formatearFila,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
                                                        
	               
        return 	tblGrid;
}


function formatearFila(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;
    
    p.body = '<p style="margin-left: 10em;margin-right: 3em;text-align:left"><span class="copyrigthSinPaddingNegro">'+
                (record.data.comentariosAdicionales.trim()==''?'(Sin comentarios)':record.data.comentariosAdicionales.trim()) +
	        '</span></p>';
    return 'x-grid3-row-expanded';
}

function crearGridAdministracionCopiasDiscos()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'situacionDiscos'},
		                                                {name: 'sentenciado'},
		                                                {name:'victima'},
		                                                {name:'mininisterioPublico'},
                                                        {name:'asesorJuridico'},
                                                        {name: 'defensa'},
                                                        {name: 'otros'},
                                                        {name: 'instituciones'}
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
                                                            sortInfo: {field: 'situacionDiscos', direction: 'ASC'},
                                                            groupField: 'situacionDiscos',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='163';
                                        proxy.baseParams.cA=gE('carpetaAdministrativa').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            
                                                            
                                                            {
                                                                header:'Situaci&oacute;n',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'situacionDiscos',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacionDiscos,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Imputado/Sentenciado',
                                                                width:150,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'sentenciado'
                                                            },
                                                            {
                                                                header:'V&iacute;ctima',
                                                                width:150,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'victima'
                                                             },
                                                            {
                                                                header:'Ministerio P&uacute;blico',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'mininisterioPublico'
                                                            
                                                            },
                                                            {
                                                                header:'Asesor Jur&iacute;dico',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'asesorJuridico'
                                                            },
                                                            {
                                                                header:'Defensa',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'defensa'
                                                            },
                                                            {
                                                                header:'Otros',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'otros'
                                                            },
                                                            {
                                                                header:'Instituciones',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'instituciones'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridAdministracionCopiasDisco',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                title:'Copias de discos',
                                                                tbar:	[
                                                                			{
                                                                            	xtype:'label',
                                                                                html:'<span class="letraRojaSubrayada8" style="font-size:12px"><b>Administraci&oacute;n General de Entrega de Discos</b></span>'
                                                                            }
                                                                		],
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
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}