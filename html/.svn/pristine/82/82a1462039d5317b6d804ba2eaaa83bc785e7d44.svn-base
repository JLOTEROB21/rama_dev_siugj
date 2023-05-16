<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
$consulta="SELECT DISTINCT anioExpediente,anioExpediente FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$_SESSION["idUsr"].
				" ORDER BY anioExpediente";
	$arrAnio=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT anioExpediente FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$_SESSION["idUsr"].
				" ORDER BY anioExpediente desc";
	$anioExpediente=$con->obtenerValor($consulta);
	
	$consulta="SELECT claveMateria,materia,promocioneFirmadas FROM _480_tablaDinamica";
	$arrMateriasPromociones="[]";
	
	$consulta="SELECT id__17_tablaDinamica,UPPER(nombreUnidad) FROM _17_tablaDinamica";
	$arrJuzgados=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,icono,tamano FROM 7011_situacionEventosAudiencia";
	$arrSituaciones=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE categoriaDespacho in(2,3,4) and idEstado=2 ORDER BY nombreUnidad";
	$arrDespachos=$con->obtenerFilasArreglo($consulta);
	
	$arrEspecialidades="";
	$consulta="SELECT id__637_tablaDinamica,nombreEspecialidadDespacho FROM _637_tablaDinamica ORDER by nombreEspecialidadDespacho";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica WHERE especialidad=".$fila[0]." ORDER BY nombreTipoProceso";
		$arrTiposProceso=$con->obtenerFilasArreglo($consulta);
		$o="['".$fila[0]."','".cv($fila[1])."',".$arrTiposProceso."]";
		if($arrEspecialidades=="")
			$arrEspecialidades=$o;
		else
			$arrEspecialidades.=",".$o;
	}
	$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
	$arrEstados=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica ORDER BY nombreTipoProceso";
	$arrTiposProcesoGlobal=$con->obtenerFilasArreglo($consulta);	

	$consulta="SELECT idTipoCarpeta,nombreTipoCarpeta FROM 7020_tipoCarpetaAdministrativa";
	$arrTipoCarpeta=$con->obtenerFilasArreglo($consulta);	
?>

var arrTipoCarpeta=<?php echo $arrTipoCarpeta?>;
var idNodoSeleccionado=-1;
var arrTiposProcesoGlobal=<?php echo $arrTiposProcesoGlobal?>;
var arrEstados=<?php echo $arrEstados?>;
var arrEstadoProceso=[['1','Abierto'],['3','Cerrado']];
var arrEstadoProcesoGlobal=[['0','No Iniciado'],['1','Abierto'],['3','Cerrado']];
var arrEspecialidades=[<?php echo $arrEspecialidades?>];
var arrDespachos=<?php echo $arrDespachos?>;
var arrCategorias=<?php echo $arrCategorias?>;
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var arrSemaforo=<?php echo $arrSituaciones?>;
var arrTipoSeguimiento=[['1','Acuerdo'],['2','Promoci&oacute;n registrada']];
var enviarPromocion=-1;
var arrJuzgados=<?php echo $arrJuzgados?>;
var IdDocumento='';
var nombreDocumento='';
var arrMateriasPromociones=<?php echo $arrMateriasPromociones?>;
var anioExpediente='<?php echo $anioExpediente?>';
var arrAnio=<?php echo $arrAnio?>;

var arrSituacionPromocion=[['1','En espera de env&iacute;o a juzgado','../images/bullet-grey.png'],['2','En espera de atenci\xF3n','../images/bullet-yellow.png'],
							['3','Atendida','../images/bullet-green.png']];
var nodoExpedienteSel=null;

Ext.onReady(inicializar);

function inicializar()
{
	Ext.QuickTips.init();

	arrAnio.splice(0,0,['0','Cualquiera']);
	
	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                items:	[
                                                            {
                                                                xtype:'panel',
                                                                width:600,
                                                                collapsible:true,
                                                                region:'west',
                                                                collapsed:true,
                                                                id:'panelArbol',
                                                                layout:'border',
                                                                cls:'treeVistaExpedienteUsuario',
                                                                tbar:	[
                                                                            {
                                                                                xtype:'label',
                                                                                html:'<div class="letraNombreTableroNegro">A&ntilde;o del Proceso:</div>'
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:5
                                                                            },
                                                                            {
                                                                            	xtype:'label',
                                                                                html:'<div id="divAnio" style="width:160px"></div>'
                                                                            }
                                                                        ],
                                                                items:	[
                                                                                
                                                                            crearArbolExpedientes()
                                                                           ]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                items:	[
                                                                            {
                                                                                  xtype:'tabpanel',
                                                                                  region:'center',
                                                                                  id:'panelGrids',
                                                                                  activeTab:2,
                                                                                  cls:'tabPanelSIUGJ',
                                                                                  items:	[
                                                                                                crearArbolCarpetaAdministrativa(),
                                                                                                crearGridEventos(),
                                                                                                
                                                                                                {
                                                                                                    xtype:'panel',
                                                                                                    id:'pActuaciones',
                                                                                                    title:'Actuaciones/Escritos',
                                                                                                    listeners:	{
                                                                                                                    activate:function(p)
                                                                                                                                {
                                                                                                                                    if(!p.visualizado)
                                                                                                                                    {
                                                                                                                                        p.visualizado=1;
                                                                                                                                        gEx('frameRegistroEscritos').load	(
                                                                                                                                                                                {
                                                                                                                                                                                    scripts:true,
                                                                                                                                                                                    url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                                                    params:	{
                                                                                                                                                                                                cPagina: 'sFrm=true',
                                                                                                                                                                                                idProceso: 285,
                                                                                                                                                                                                pantallaCompleta:'1',
                                                                                                                                                                                                actor:"'23_0'",
                                                                                                                                                                                                parametrosProceso:bE('{"cAdministrativa":"'+(nodoExpedienteSel?nodoExpedienteSel.attributes.expediente:-1)+'"}'),
                                                                                                                                                                                                idFormulario: -1,
                                                                                                                                                                                                contentIframe:1
                                                                                                                                                                                            }
                                                                                                                                                                               }
                                                                                                                                                                            )
                                                                                                                                
                                                                                                                                        
                                                                                                                                    }
                                                                                                                                }
                                                                                                                },
                                                                                                    items:	[
                                                                                                    
                                                                                                                new Ext.ux.IFrameComponent({ 
                                    
                                                                                                                                                id: 'frameRegistroEscritos', 
                                                                                                                                                anchor:'100% 100%',
                                                                                                                                                loadFuncion:function(iFrame)
                                                                                                                                                            {
                                                                                                                                                                
                                                                                                                                                                
                                                                                                                                                               
                                                                                                                                                                
                                                                                                                                                            },
                                                        
                                                                                                                                                url: '../paginasFunciones/white.php',
                                                                                                                                                style: 'width:100%;height:100%' 
                                                                                                                                        })
                                                                                                    
                                                                                                    
                                                                                                                
                                                                                                                
                                                                                                            ]
                                                                                                }
                                                                                            ]
                                                                              },
                                                                            crearGridPropiedadesProceso()  
                                                                        ]
                                                            }
                                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   
	
    gEx('panelGrids').setActiveTab(0);
    gEx('panelGrids').hideTabStripItem('pActuaciones');	
    gEx('panelArbol').setWidth(360);
    
    var cmbAnio=crearComboExt('cmbAnio',arrAnio,0,0,150,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divAnio'});
    cmbAnio.setValue('0');
    
    cmbAnio.on('select',function(cmb,registro)
    					{
                        	idNodoSeleccionado=-1;
                        	gEx('arbolExpedientes').getRootNode().reload();
                        }
    			)
    
    
     setTimeout(function(){gEx('panelArbol').expand();}, 1000);
}


function crearArbolExpedientes()
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
                                                                    funcion:'8'
                                                                    
                                                                },
                                                    dataUrl:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            	
                            	c.baseParams.anio=gEx('cmbAnio')?gEx('cmbAnio').getValue():'0';
                                c.baseParams.noExpediente=gEx('txtNumeroExpediente').getValue();
                            	nodoExpedienteSel=null;
                                gEx('panelGrids').hideTabStripItem('pActuaciones');
                                
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	if(idNodoSeleccionado!=-1)
                                {
                                
                                    setTimeout(function()
                                                {
                                                    nodoSel=buscarNodoID(gEx('arbolExpedientes').getRootNode(),idNodoSeleccionado);
                                                    gEx('arbolExpedientes'). selectPath(nodoSel.getPath());
                                                    funcExpediente(nodoSel);
                                                   
                                                },500);
                                    
                                }
                            }
    				)										
	var arbolExpedientes=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolExpedientes',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:false,
                                                                cls:'treeVistaExpedienteUsuario',
                                                                region:'center',
                                                                root:raiz,
                                                                tbar:	[
                                                                			{
                                                                            	xtype:'label',
                                                                                html:'<div class="letraNombreTableroNegro">No. de Proceso:</b>&nbsp;&nbsp;</div>'
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:5
                                                                            },
                                                                            {
                                                                            	xtype:'textfield',
                                                                                width:140,
                                                                                cls:'controlSIUGJ',
                                                                                enableKeyEvents:true,
                                                                                id:'txtNumeroExpediente',
                                                                                listeners:	{
                                                                                				keypress:function(txt,e)
                                                                                                	{
                                                                                                    	if(e.charCode=='13')
                                                                                                        {
                                                                                                        	if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                            {
                                                                                                            	idNodoSeleccionado=-1;
                                                                                                            	gEx('arbolExpedientes').getRootNode().reload();
                                                                                                        		txt.ultimaBusqueda=txt.getValue();
                                                                                                            }
                                                                                                        }
                                                                                                    },
                                                                                                blur:function(txt)
                                                                                                	{
                                                                                                    	
                                                                                                    	if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                        {
                                                                                                        	idNodoSeleccionado=-1;
                                                                                                        	gEx('arbolExpedientes').getRootNode().reload();
                                                                                                        	txt.ultimaBusqueda=txt.getValue();
                                                                                                        }
                                                                                                        
                                                                                                    }
                                                                                			}
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:5
                                                                            },
                                                                            {
                                                                                icon:'../images/magnifier.png',
                                                                                cls:'x-btn-text-icon',
                                                                                width:25,
                                                                                tooltip:'B&uacute;squeda de Proceso Avanzada',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarBusquedaProcesoJudicial();
                                                                                        }
                                                                                
                                                                            },
                                                                             {
                                                                                icon:'../images/find_remove.png',
                                                                                cls:'x-btn-text-icon',
                                                                                tooltip:'Remover Filtros',
                                                                                width:25,
                                                                                handler:function()
                                                                                        {
                                                                                            gEx('cmbAnio').setValue('0');
                                                                                            gEx('txtNumeroExpediente').setValue('');
                                                                                            gEx('arbolExpedientes').getRootNode().reload();
                                                                                            gEx('gridAudiencias').getStore().removeAll();
                                                                                            gEx('gridCarpetaAdministrativa').getStore().removeAll();
                                                                                            recargarGridEscritos();
                                                                                        }
                                                                                
                                                                            }
                                                                		],
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	arbolExpedientes.on('click',funcExpediente);
	return  arbolExpedientes;
}

function funcExpediente(nodo, evento)
{

	nodoExpedienteSel=nodo;

    if(nodoExpedienteSel.attributes.tipo=='3')
    {

        if(nodoExpedienteSel.attributes.accesoVideograbaciones==0)
        {
        	gEx('panelGrids').hideTabStripItem('gridAudiencias');
            gEx('panelGrids').setActiveTab(0);
        }
        else
        {
        	gEx('panelGrids').unhideTabStripItem('gridAudiencias');
            gEx('panelGrids').unhideTabStripItem('pActuaciones');
        
        }
        recargarGridAudiencias();
        recargarGridDocumentos();
        recargarGridEscritos();
        gEx('gMetaDataProceso').getStore().reload();
    }
    else
    {

        
        gEx('gSeguimiento').getStore().removeAll();
        gEx('gridAudiencias').getStore().removeAll();
        gEx('gMetaDataProceso').getStore().removeAll();

    }
    
    
    
}



function recargarGridEscritos()
{
	if(gEx('frameRegistroEscritos'))
    {
        gEx('frameRegistroEscritos').load	(
                                                {
                                                    scripts:true,
                                                    url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                    params:	{
                                                                cPagina: 'sFrm=true',
                                                                idProceso: 285,
                                                                pantallaCompleta:'1',
                                                                parametrosProceso:bE('{"cAdministrativa":"'+(nodoExpedienteSel?nodoExpedienteSel.attributes.expediente:-1)+'"}'),
                                                                idFormulario: -1,
                                                                actor:"'23_0'",
                                                                contentIframe:1
                                                            }
                                               }
                                            )
	
    	 
    
    }
    
    
   
}

function recargarGridDocumentos()
{
	gEx('gridCarpetaAdministrativa').getStore().load	(
    														{
                                                            	url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                params:	{
                                                                			cA:bE(nodoExpedienteSel.attributes.expediente)
                                                                		}
                                                            }
    													)
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

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

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
                                    	proxy.baseParams.funcion='29';
                                        proxy.baseParams.idCarpetaAdministrativa=-1;
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
       
	      

	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true,width:40});       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	chkRow,
                                                        {
                                                            header:'ID Documento',
                                                            width:100,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'idDocumento'
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:160,
                                                            sortable:true,
                                                            dataIndex:'fechaCreacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y H:i');
                                                                    }
                                                        },
                                                        
                                                        {
                                                            header:'Documento',
                                                            width:335,
                                                            sortable:true,
                                                            dataIndex:'nomArchivoOriginal',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'Tipo documento',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'categoriaDocumentos',
                                                            editor:cmbTipoDocumento,
                                                            renderer:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(formatearValorRenderer(arrCategorias,val));
                                                                    }
                                                        },
                                                        {
                                                            header:'Tama&ntilde;o',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'tamano',
                                                            renderer:function(val,meta,registro)
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
                                                                    	
                                                                        if(parseFloat(registro.data.idFormulario)>0)
	                                                                       	return '<a href="javascript:abrirProcesoOrigen(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')"><img src="../principalPortal/imagesSIUGJ/lupa.png" title="Abrir proceso origen" alt="Abrir proceso origen" /></a>';
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridCarpetaAdministrativa',
                                                            title:'Documentos del Proceso',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            clicksToEdit:1,
                                                            cm: cModelo,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false,
                                                            cls:'gridSiugjPrincipal',  
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                              icon:'../images/magnifier.png',
                                                                              cls:'x-btn-text-icon',
                                                                              width:25,
                                                                              text:'B&uacute;squeda de Documentos Avanzada',
                                                                              handler:function()
                                                                                      {
                                                                                          mostrarBusquedaDocumentosProcesoJudicial();
                                                                                      }
                                                                              
                                                                          },
                                                            		],
                                                            plugins:[filters],
                                                                                                              
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: true,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'<span style="color:#900"><b>{text}</b> ({[values.rs.length]} {[values.rs.length > 1 ? "Documentos" : "Documento"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    
	
    
    
    
    tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                  	mostrarVisorDocumentoProcesoIndice(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  )                                                    
                                                    
    return 	tblGrid;	
}

function mostrarVisorDocumentoProcesoIndice(extension,idDocumento,registro,nombreArchivo,cA)
{
	var obj={};
    obj.url='../visoresGaleriaDocumentos/visorDocumentosGeneralIndice.php';
    obj.ancho='100%';
    obj.alto='100%';
    

     
    obj.params=	[['iD',bE('iD_'+idDocumento)],['cPagina','sFrm=true'],['idCarpeta','-1'],
    			['carpetaJudicial',cA?cA:bE(nodoExpedienteSel.attributes.expediente)]];
    if(extension!='')
    	obj.params.push(['extension',extension]);
    if(nombreArchivo)
    	obj.params.push(['nombreArchivo',nombreArchivo]);
    abrirVentanaFancySuperior(obj);
	
}

function obtenerVersionCompletaDocumentos(iDocumento)

{
	
	
    var arrParametros=[['iDocumento',iDocumento]]
    enviarFormularioDatos('../modulosEspeciales_SICORE/obtenerDocumentoCompletoImpresion.php',arrParametros,'POST','frameDTD');
    primeraCargaFrame=false;
    
}

function frameLoad(iFrame)
{
	if(!primeraCargaFrame)
    {
    	setTimeout(function()
        			{
                       
                        iFrame.contentWindow.print();
                    },2000
                   );

    }
    else
    	primeraCargaFrame=false;
	
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
                                                        {name: 'horaInicioReal', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaTerminoReal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'urlMultimedia'},
                                                        {name: 'tipoAudiencia'},
                                                        {name: 'sala'},
                                                        {name: 'unidadGestion'},
                                                        {name: 'situacion'},
                                                        {name: 'juez'}  ,
                                                        {name: 'edificio'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'urlVideoConferencia'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(

                                                                                  {

                                                                                      url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                  }

                                                                              ),
                                                sortInfo: {field: 'fechaEvento', direction: 'ASC'},
                                                groupField: 'fechaEvento',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:false
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='28';
                                    }
                        )   
       
       
       
       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
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
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        
                                                                        	var comp='';
                                                                            if(registro.data.comentariosAdicionales!='')
                                                                            {
                                                                            	comp='&nbsp;&nbsp;<img src="../images/icon_comment.gif" title="'+cv(registro.data.comentariosAdicionales,true,true)+'" alt="'+cv(registro.data.comentariosAdicionales,true,true)+'" />';
                                                                            }
                                                                            return mostrarValorDescripcion(formatearValorRenderer(arrSituacionEvento,val))+comp;
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'',
                                                                width:60,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                css:'text-align:left;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{

                                                                        	var comp2='';
                                                                           	switch(val)
                                                                            {
                                                                            	case '1':
                                                                                	if(registro.data.urlVideoConferencia!='')
                                                                                		comp2='<a href="javascript:abrirVideoConferencia(\''+bE(registro.data.urlVideoConferencia)+'\')"><img src="../images/user_go.png" title="Ingresar a Audiencia" alt="Ingresar a Audiencia" /></a>'
                                                                                break;
                                                                            	case '2':
                                                                                
                                                                                	if(registro.data.urlMultimedia!='')
                                                                                    {
                                                                                    	if(registro.data.urlMultimedia.indexOf('sharepoint')==-1)
	                                                                                		comp2='<a href="javascript:abrirVideoGrabacion(\''+bE(registro.data.idEvento)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                              			else
                                                                                        	comp2='<a href="javascript:abrirVideoGrabacionTeams(\''+bE(registro.data.urlMultimedia)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                                	}
                                                                                
                                                                                	
                                                                              	break;
                                                                            }
                                                                        	return comp2;
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Expediente',
                                                                width:150,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Fecha audiencia',
                                                                width:170,
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
                                                            
                                                            {
                                                                header:'Hora de realizaci&oacute;n de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicioReal',
                                                                renderer:function(val,meta,registro)
                                                                	{

                                                                    	if(!val)
                                                                        {
                                                                        	return '(Datos no disponibles)';
                                                                        }
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaTerminoReal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaTerminoReal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaTerminoReal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de audiencia',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'tipoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Edificio',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'edificio',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(val);
                                                                        	return lblSala;
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Sala',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'sala',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Juez',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'juez'
                                                            },
                                                            {
                                                                header:'URL Video Conferencia',
                                                                width:900,
                                                                align:'left',
                                                                sortable:true,
                                                                dataIndex:'urlVideoConferencia',
                                                                css:'text-align:left;vertical-align:middle !important;',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<a href="javascript:abrirVideoConferencia(\''+bE(val)+'\')">'+mostrarValorDescripcion(val)+'</a>';
                                                                        }
                                                            }
                                                            
                                                           
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridAudiencias',
                                                                store:alDatos,
                                                                region:'center',
                                                                title:'Audiencias',
                                                                frame:false,
                                                                cm: cModelo,
                                                                cls:'gridSiugjPrincipal',  
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,      
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
                                                	
                                                    
                                                }
    							)

	tblGrid.getSelectionModel().on('rowdeselect',function()
    											{
                                                	
                                                }
    							)

	return 	tblGrid;

}

function recargarGridAudiencias()
{
	gEx('gridAudiencias').getStore().load	(
                                                {
                                                    url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                    params:	{
                                                                funcion:'28',
                                                                exp:nodoExpedienteSel.attributes.expediente
                                                            }
                                                }
                                            );
}


function abrirVideoConferencia(url)
{
	window.open(bD(url), '_blank');

}

function abrirVideoGrabacion(idEventoAudiencia)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorGrabacionAudiencia.php';
    obj.params=[['idEvento',idEventoAudiencia],['cPagina','sFrm=true']]
   	abrirVentanaFancySuperior(obj);
}

function abrirProcesoOrigen(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['actor',bE(0)],['dComp',bE('auto')]];
    abrirVentanaFancySuperior(obj);
    
    
}

function abrirProcesoBusqueda(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=true;
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['actor',bE(0)],['dComp',bE('auto')]];
    abrirVentanaFancySuperior(obj);
    
    
}


function recargarContenedorCentral()
{

	
    if((gE('iframe-frameRegistroEscritos'))&&(gEx('frameRegistroEscritos').getFrameWindow)&&(gEx('frameRegistroEscritos').getFrameWindow().recargarContenedorCentral))
    	gEx('frameRegistroEscritos').getFrameWindow().recargarContenedorCentral();
        
    gEx('arbolExpedientes').getRootNode().reload();
}

function mostrarBusquedaProcesoJudicial()
{
	var arrFiltroFecha=[['>=','>='],['>','>'],['=','='],['<','<'],['<=','<=']];
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            cls:'tabPanelSIUGJ',
                                                            id:'tabBusqueda',
                                                            region:'center',
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            title:'Criterios de b&uacute;squeda',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Despacho:'
                                                                                        },
                                                                                        {
                                                                                            x:150,
                                                                                            y:15,
                                                                                            html:'<div id="divDespacho"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Especialidad:'
                                                                                        },
                                                                                        {
                                                                                            x:150,
                                                                                            y:65,
                                                                                            html:'<div id="divEspecialidad"></div>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:120,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Tipo de Proceso:'
                                                                                        },
                                                                                        {
                                                                                            x:170,
                                                                                            y:115,
                                                                                            html:'<div id="divTipoProceso"></div>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:540,
                                                                                            y:120,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Estado del Proceso:'
                                                                                        },
                                                                                        {
                                                                                            x:730,
                                                                                            y:115,
                                                                                            html:'<div id="divEstadoProceso"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:170,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Fecha de Registro:'
                                                                                        },
                                                                                        {
                                                                                            x:190,
                                                                                            y:165,
                                                                                            html:'<div id="divCmbInicioFiltroFecha"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:370,
                                                                                            y:165,
                                                                                            html:'<div id="divFechaInicioFiltro" style="width:140"></div>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:520,
                                                                                            y:170,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Y'
                                                                                        },
                                                                                         {
                                                                                            x:550,
                                                                                            y:165,
                                                                                            html:'<div id="divCmbFinFiltro"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:730,
                                                                                            y:165,
                                                                                            html:'<div id="divFechaFinFiltroFecha" style="width:140"></div>'
                                                                                        },
                                                                                         
                                                                                        {
                                                                                            x:600,
                                                                                            y:220,
                                                                                            xtype:'button',
                                                                                            icon:'../images/magnifier.png',
                                                                                            cls:'btnSIUGJCancel',
                                                                                            width:140,
                                                                                            text:'Buscar',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        if((gEx('fInicioFiltro').getValue()!='')&&(gEx('cmbInicioFiltro').getValue()==''))
                                                                                                        {
                                                                                                            function resp1()
                                                                                                            {
                                                                                                                gEx('cmbInicioFiltro').focus();
                                                                                                            }
                                                                                                            msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp1);
                                                                                                            return;
                                                                                                        }
                                                                                                        
                                                                                                        if((gEx('fFinFiltro').getValue()!='')&&(gEx('cmbFinFiltro').getValue()==''))
                                                                                                        {
                                                                                                            function resp2()
                                                                                                            {
                                                                                                                gEx('cmbFinFiltro').focus();
                                                                                                            }
                                                                                                            msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp2);
                                                                                                            return;
                                                                                                        }
                                                                                                    
                                                                                                        var cadObj='{"depacho":"'+gEx('cmbDespachos').getValue()+'","especialidad":"'+gEx('cmbEspecialidad').getValue()+
                                                                                                        '","tipoProceso":"'+gEx('cmbTipoProceso').getValue()+'","estadoProceso":"'+gEx('cmbEstadoProceso').getValue()+
                                                                                                        '","fechaInicioRegistro":"'+(gEx('fInicioFiltro').getValue()?gEx('fInicioFiltro').getValue().format('Y-m-d'):'')+
                                                                                                        '","fechaFinRegistro":"'+(gEx('fFinFiltro').getValue()?gEx('fFinFiltro').getValue().format('Y-m-d'):'')+
                                                                                                        '","condFInicioFiltro":"'+gEx('cmbInicioFiltro').getValue()+'","condFFinFiltro":"'+gEx('cmbFinFiltro').getValue()+'"}';
                                                                                                    
                                                                                                    	gEx('tabBusqueda').setActiveTab(1);
                                                                                                        gEx('gResultadoBusqueda').getStore().load	(
                                                                                                                                                        {
                                                                                                                                                            url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                                                                                                            params:	{
                                                                                                                                                                        criterioBusqueda:cadObj
                                                                                                                                                                    }
                                                                                                                                                         }
                                
                                                                                                                                                    )
                                                                                                    }
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            x:750,
                                                                                            y:220,
                                                                                            xtype:'button',
                                                                                            cls:'btnSIUGJCancel',
                                                                                            width:140,
                                                                                            icon:'../images/find_remove.png',
                                                                                            
                                                                                            text:'Limpiar Filtros',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        gEx('cmbDespachos').setValue('');
                                                                                                        gEx('cmbEspecialidad').setValue('');
                                                                                                        gEx('cmbTipoProceso').setValue('');
                                                                                                        gEx('cmbEstadoProceso').setValue('');
                                                                                                        gEx('cmbInicioFiltro').setValue('');
                                                                                                        gEx('fInicioFiltro').setValue('');
                                                                                                        gEx('cmbFinFiltro').setValue('');
                                                                                                        gEx('fFinFiltro').setValue('');
                                                                                                        
                                                                                                        gEx('gResultadoBusqueda').getStore().removeAll();
                                                                                                    
                                                                                                                                                                            }
                                                                                            
                                                                                        }
                                                                            		]
                                                                        },
                                                            			crearGridResultadoProcesos()
                                                                    ]
                                                        }
                                            
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vBusquedaProcesos',
										title: 'B&uacute;squeda de Procesos Avanzada',
										width: 940,
										height:460,
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
                                                                	var cmbDespachos=crearComboExt('cmbDespachos',arrDespachos,0,0,750,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divDespacho'});
                                                                    var cmbEspecialidad=crearComboExt('cmbEspecialidad',arrEspecialidades,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divEspecialidad'});
                                                                    cmbEspecialidad.on('select',function(cmb,registro)
                                                                                                {
                                                                                                    gEx('cmbTipoProceso').setValue('');
                                                                                                    gEx('cmbTipoProceso').getStore().loadData(registro.data.valorComp);
                                                                                                }
                                                                                        )
                                                                    var cmbTipoProceso=crearComboExt('cmbTipoProceso',[],0,0,330,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divTipoProceso'});
                                                                    var cmbEstadoProceso=crearComboExt('cmbEstadoProceso',arrEstadoProceso,0,0,170,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divEstadoProceso'});
                                                                    var cmbInicioFiltro=crearComboExt('cmbInicioFiltro',arrFiltroFecha,0,0,170,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbInicioFiltroFecha'});
                                                                    new Ext.form.DateField	(
                                                                    							 {
                                                                                                    
                                                                                                    ctCls:'campoFechaSIUGJ',
                                                                                                    width:130,
                                                                                                    renderTo:'divFechaInicioFiltro',
                                                                                                    xtype:'datefield',
                                                                                                    id:'fInicioFiltro'
                                                                                                }
                                                                    						)
                                                                   
                                                                    
                                                                    var cmbFinFiltro=crearComboExt('cmbFinFiltro',arrFiltroFecha,0,0,170,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbFinFiltro'});
                                                                		
                                                                    new Ext.form.DateField	(
                                                                    							 {
                                                                                                    
                                                                                                    ctCls:'campoFechaSIUGJ',
                                                                                                    width:130,
                                                                                                    renderTo:'divFechaFinFiltroFecha',
                                                                                                    xtype:'datefield',
                                                                                                    id:'fFinFiltro'
                                                                                                }
                                                                    						)
                                                                
                                                            
                                                                
                                                                
																}
															}
												},
										buttons:	[
														{
															
															text: 'Cerrar',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
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

function crearGridResultadoProcesos()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'idFormulario'},
                                                        {name:'idCarpeta'},
		                                                {name: 'folioRegistro'},
                                                        {name: 'tipoCarpeta'},
		                                                {name:'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'codigoUnicoProceso'},
                                                        {name: 'tituloProceso'},
                                                        {name: 'tipoProceso'},
                                                        {name: 'especialidad'},
                                                        {name:'departamento'},
                                                        {name:'despacho'},
                                                        {name: 'estadoProceso'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

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
                                    	proxy.baseParams.funcion='10';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'Folio de Registro',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirProcesoBusqueda(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de Registro',
                                                                width:190,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val.format('d/m/Y H:i')+' hrs.';
                                                                            }
                                                            },
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'codigoUnicoProceso',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:setBusquedaCodigo(\''+bE(val)+'\',\''+bE(registro.data.idCarpeta)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de Expediente',
                                                                width:270,
                                                                sortable:true,

                                                                dataIndex:'tipoCarpeta',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoCarpeta,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'T&iacute;tulo del Proceso',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'tituloProceso'
                                                            },
                                                            
                                                            {
                                                                header:'Tipo de Proceso',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'tipoProceso',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrTiposProcesoGlobal,val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Especialidad',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'especialidad',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrEspecialidades,val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Departamento',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'departamento',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrEstados,val);
                                                                            }
                                                            },
                                                            
                                                            {
                                                                header:'Despacho',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'despacho',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrDespachos,val);
                                                                            }
                                                            },
                                                            
                                                            {
                                                                header:'Estado del Proceso',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'estadoProceso',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrEstadoProcesoGlobal,val);
                                                                            }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gResultadoBusqueda',
                                                                store:alDatos,
                                                                title:'Resultado',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,
                                                                cls:'gridSiugjPrincipal',
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

function setBusquedaCodigo(cU,iE)
{
	gEx('txtNumeroExpediente').setValue(bD(cU));
    gEx('cmbAnio').setValue('0');
    idNodoSeleccionado='e_'+bD(iE);
    
    gEx('arbolExpedientes').getRootNode().reload();
    gEx('vBusquedaProcesos').close();
}

function mostrarBusquedaDocumentosProcesoJudicial()
{
	var arrFormatosDocumento=[['pdf','Documentos PDF'],['doc,docx','Documentos de Word'],['jpg,jpeg,gif,bpm,png','Documentos de Imagen'],['wav,mp3','Documentos de Audio'],['mp4,avi,mov,3gp,wav','Documentos de Video']];
	var arrCondicionDocumento=[['1','Inicia con'],['2','Contiene'],['2','Termina con']];
    var arrCondicionDocumentoCuerpo=[['2','Contiene']];
	var arrFiltroFecha=[['>=','>='],['>','>'],['=','='],['<','<'],['<=','<=']];
	
   
    
    
    
    
    
    
    
    
    
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            region:'center',
                                                            id:'tblFiltros',
                                                            buttonAlign:'right',
                                                            activeTab:0,
                                                            cls:'tabPanelSIUGJ',
                                                            tbar:	new Ext.Toolbar(
                                                            							{
                                                                                        	buttonAlign:'right',
                                                                                        	items:	
                                                            
                                                            
                                                                                                    [
                                                                                                                {
                                                                                                                    xtype:'button',
                                                                                                                    icon:'../images/magnifier.png',
                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                    text:'Buscar',
                                                                                                                    handler:function()
                                                                                                                            {
                                                                                                                                if((gEx('fInicioFiltro').getValue()!='')&&(gEx('cmbInicioFiltro').getValue()==''))
                                                                                                                                {
                                                                                                                                    function resp1()
                                                                                                                                    {
                                                                                                                                    	gEx('tblFiltros').setActiveTab(1);
                                                                                                                                        gEx('cmbInicioFiltro').focus();
                                                                                                                                    }
                                                                                                                                    msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp1);
                                                                                                                                    return;
                                                                                                                                }
                                                                                                                                
                                                                                                                                if((gEx('fFinFiltro').getValue()!='')&&(gEx('cmbFinFiltro').getValue()==''))
                                                                                                                                {
                                                                                                                                    function resp2()
                                                                                                                                    {
                                                                                                                                    	gEx('tblFiltros').setActiveTab(1);
                                                                                                                                        gEx('cmbFinFiltro').focus();
                                                                                                                                    }
                                                                                                                                    msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp2);
                                                                                                                                    return;
                                                                                                                                }
                                                                                                                                
                                                                                                                                 if((gEx('fInicioFiltroDocumento').getValue()!='')&&(gEx('cmbInicioFiltroDocumento').getValue()==''))
                                                                                                                                {
                                                                                                                                    function resp10()
                                                                                                                                    {
                                                                                                                                    	gEx('tblFiltros').setActiveTab(0);
                                                                                                                                        gEx('cmbInicioFiltroDocumento').focus();
                                                                                                                                    }
                                                                                                                                    msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp10);
                                                                                                                                    return;
                                                                                                                                }
                                                                                                                                
                                                                                                                                if((gEx('fFinFiltroDocumento').getValue()!='')&&(gEx('cmbFinFiltroDocumento').getValue()==''))
                                                                                                                                {
                                                                                                                                    function resp20()
                                                                                                                                    {
                                                                                                                                    	gEx('fFinFiltroDocumento').setActiveTab(0);
                                                                                                                                        gEx('cmbFinFiltroDocumento').focus();
                                                                                                                                    }
                                                                                                                                    msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp20);
                                                                                                                                    return;
                                                                                                                                }
                                                                                                                            
                                                                                                                                var objProceso='{"depacho":"'+gEx('cmbDespachos').getValue()+'","especialidad":"'+gEx('cmbEspecialidad').getValue()+
                                                                                                                                                '","tipoProceso":"'+gEx('cmbTipoProceso').getValue()+'","estadoProceso":"'+gEx('cmbEstadoProceso').getValue()+
                                                                                                                                                '","fechaInicioRegistro":"'+(gEx('fInicioFiltro').getValue()?gEx('fInicioFiltro').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","fechaFinRegistro":"'+(gEx('fFinFiltro').getValue()?gEx('fFinFiltro').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","condFInicioFiltro":"'+gEx('cmbInicioFiltro').getValue()+'","condFFinFiltro":"'+gEx('cmbFinFiltro').getValue()+'"}';
                                                                                                                            
                                                                                                                            
                                                                                                                            
                                                                                                                            	var objDocumento='{"nombreDocumento":"'+cv(gEx('txtNombreDocumento').getValue())+'","condNombreDocumento":"'+gEx('cmbCondicionDocumento').getValue()+
                                                                                                                                                '","cuerpoDocumento":"'+cv(gEx('txtCuerpoDocumento').getValue())+'","condCuerpoDocumento":"'+
                                                                                                                                                gEx('cmbCondicionCuerpoDocumento').getValue()+'","formato":"'+gEx('cmbFormatoDocumento').getValue()+'","categoriaDocumento":"'+
                                                                                                                                                gEx('cmbCategoriaDocumentoFiltro').getValue()+
                                                                                                                                                '","fechaInicioRegistro":"'+(gEx('fInicioFiltroDocumento').getValue()?gEx('fInicioFiltroDocumento').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","fechaFinRegistro":"'+(gEx('fFinFiltroDocumento').getValue()?gEx('fFinFiltroDocumento').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","condFInicioFiltro":"'+gEx('cmbInicioFiltro').getValue()+'","condFFinFiltro":"'+gEx('cmbFinFiltro').getValue()+
                                                                                                                                                '","registradoPor":"'+(gEx('txtRegistradoPor').getValue())+'"}';
                                                                                                                            	
                                                                                                                                
                                                                                                                                var cadObj='{"objProceso":'+objProceso+',"objDocumento":'+objDocumento+'}';
                                                                                                                                
                                                                                                                                gEx('gResultadoBusquedaDocumento').getStore().load	(
                                                                                                                                                                                {
                                                                                                                                                                                    url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                                                                                                                                    params:	{
                                                                                                                                                                                                criterioBusqueda:cadObj
                                                                                                                                                                                            }
                                                                                                                                                                                 }
                                                        
                                                                                                                                                                            )
                                                                                                                            
                                                                                                                            	gEx('tblFiltros').setActiveTab(2);
                                                                                                                            }
                                                                                                                    
                                                                                                                },'-',
                                                                                                                {
                                                                                                                    xtype:'button',
                                                                                                                    icon:'../images/find_remove.png',
                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                    text:'Limpiar Filtros',
                                                                                                                    handler:function()
                                                                                                                            {
                                                                                                                                gEx('cmbDespachos').setValue('');
                                                                                                                                gEx('cmbEspecialidad').setValue('');
                                                                                                                                gEx('cmbTipoProceso').setValue('');
                                                                                                                                gEx('cmbEstadoProceso').setValue('');
                                                                                                                                gEx('cmbInicioFiltro').setValue('');
                                                                                                                                gEx('fInicioFiltro').setValue('');
                                                                                                                                gEx('cmbFinFiltro').setValue('');
                                                                                                                                gEx('fFinFiltro').setValue('');
                                                                                                                                
                                                                                                                                
                                                                                                                                gEx('txtCuerpoDocumento').setValue('');
                                                                                                                                gEx('cmbCondicionDocumento').setValue('');
                                                                                                                                gEx('txtNombreDocumento').setValue('');
                                                                                                                                gEx('cmbFormatoDocumento').setValue('');
                                                                                                                                gEx('cmbCategoriaDocumentoFiltro').setValue('');
                                                                                                                                gEx('txtRegistradoPor').setValue('');
                                                                                                                                gEx('cmbInicioFiltro').setValue('');
                                                                                                                                gEx('fInicioFiltroDocumento').setValue('');
                                                                                                                                gEx('cmbFinFiltro').setValue('');
                                                                                                                                gEx('fFinFiltroDocumento').setValue('');
                                                                                                                                
                                                                                                                                gEx('gResultadoBusquedaDocumento').getStore().removeAll();
                                                                                                                            }
                                                                                                                    
                                                                                                                }
                                                                                                            ]
                                                            							}
                                                                                    ),
                                                            items:	[
                                                            			
                                                                        {
                                                                        	xtype:'panel',
                                                                            defaultType: 'label',
                                                                            title:'Filtros de Documento',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Nombre del Documento:'
                                                                                        },
                                                                                        {
                                                                                        	x:240,
                                                                                            y:15,
                                                                                            html:'<div id="divCondicionDocumento"></div>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                        	x:370,
                                                                                            y:15,
                                                                                            xtype:'textfield',
                                                                                            width:180,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtNombreDocumento'
                                                                                        },
                                                                                        {
                                                                                            x:580,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Formato:'
                                                                                        },
                                                                                        {
                                                                                        	x:680,
                                                                                            y:15,
                                                                                            html:'<div id="divFormato"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Categor&iacute;a del Documento:'
                                                                                        },
                                                                                        {
                                                                                            x:240,
                                                                                            y:65,
                                                                                            html:'<div id="divCmbCategoriaDocumento"></div>'
                                                                                        },  
                                                                                        {
                                                                                            x:10,
                                                                                            y:120,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Cuerpo del Documento:'
                                                                                        },   
                                                                                        {
                                                                                            x:230,
                                                                                            y:115,
                                                                                            html:'<div id="divCmbCuerpoDocumento"></div>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                        	x:400,
                                                                                            y:115,
                                                                                            cls:'controlSIUGJ',
                                                                                            width:400,
                                                                                            xtype:'textfield',
                                                                                            id:'txtCuerpoDocumento'
                                                                                        },                                                                              
                                                                                        {
                                                                                            x:530,
                                                                                            y:70,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Registrado por:'
                                                                                        },
                                                                                        {
                                                                                        	x:680,
                                                                                            y:65,
                                                                                            xtype:'textfield',
                                                                                            width:240,
                                                                                            cls:'controlSIUGJ',
                                                                                            id:'txtRegistradoPor'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:170,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Fecha de Registro:'
                                                                                        },
                                                                                        {
                                                                                        	x:200,
                                                                                            y:165,
                                                                                            html:'<div id="divCmbInicioFiltro"></div>'
                                                                                        },
                                                                                        {
                                                                                        	x:390,
                                                                                            y:165,
                                                                                            html:'<div id="divDteInicioFiltro" style="width:140px"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:550,
                                                                                            y:170,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Y'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:575,
                                                                                            y:165,
                                                                                            html:'<div id="divCmbFinFiltro"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:765,
                                                                                            y:165,
                                                                                            html:'<div id="divFechaFinFiltro" style="width:140px"></div>'
                                                                                        }
                                                                                        
                                                                                         
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            defaultType: 'label',
                                                                            title:'Filtros de Proceso',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Despacho:'
                                                                                        },
                                                                                        {
                                                                                        	x:150,
                                                                                            y:15,
                                                                                            html:'<div id="divDespacho"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Especialidad:'
                                                                                        },
                                                                                         {
                                                                                            x:150,
                                                                                            y:65,
                                                                                            html:'<div id="divEspecialidad"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:120,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Tipo de Proceso:'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:170,
                                                                                            y:115,
                                                                                            html:'<div id="divTipoProceso"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:540,
                                                                                            y:120,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Estado del Proceso:'
                                                                                        },
                                                                                        {
                                                                                            x:730,
                                                                                            y:115,
                                                                                            html:'<div id="divEstadoProceso"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:170,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Fecha de Registro:'
                                                                                        },
                                                                                        {
                                                                                            x:190,
                                                                                            y:165,
                                                                                            html:'<div id="divCmbInicioFiltroFecha"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:370,
                                                                                            y:165,
                                                                                            html:'<div id="divFechaInicioFiltroFecha" style="width:140"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:520,
                                                                                            y:170,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Y'
                                                                                        },
                                                                                        {
                                                                                            x:550,
                                                                                            y:165,
                                                                                            html:'<div id="divCmbFinFiltroFecha"></div>'
                                                                                        },
                                                                                        {
                                                                                            x:730,
                                                                                            y:165,
                                                                                            html:'<div id="divFechaFinFiltroFecha" style="width:140"></div>'
                                                                                        }
                                                                            		]
                                                                        },
                                                                        crearGridResultadoProcesosDocumentos()
                                                            		]
                                                        }
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vBusquedaProcesos',
										title: 'B&uacute;squeda de Documentos Avanzada',
										width: 960,
										height:460,
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
                                                                	var cmbCondicionDocumento=crearComboExt('cmbCondicionDocumento',arrCondicionDocumento,0,0,120,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCondicionDocumento'});
																    cmbCondicionDocumento.setValue('2');
                                                                    var cmbFormatoDocumento=crearComboExt('cmbFormatoDocumento',arrFormatosDocumento,0,0,240,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divFormato'});
																	var cmbInicioFiltroDocumento=crearComboExt('cmbInicioFiltro',arrFiltroFecha,0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbInicioFiltro'});
                                                                	var cmbFinFiltroDocumento=crearComboExt('cmbFinFiltro',arrFiltroFecha,0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbFinFiltro'});
                                                                    new Ext.form.DateField	(
                                                                    							{
                                                                                                    xtype:'datefield',
                                                                                                    renderTo:'divDteInicioFiltro',
                                                                                                    ctCls:'campoFechaSIUGJ',
                                                                                                    width:130,
                                                                                                    id:'fInicioFiltroDocumento'
                                                                                                }
                                                                    						)
                                                                
                                                               		new Ext.form.DateField	( 
                                                                								{

                                                                                                    xtype:'datefield',
                                                                                                    ctCls:'campoFechaSIUGJ',
                                                                                                    width:130,
                                                                                                    renderTo:'divFechaFinFiltro',
                                                                                                    id:'fFinFiltroDocumento'
                                                                                                }
                                                                                            )
                                                                
                                                                
                                                                	var cmbCondicionCuerpoDocumento=crearComboExt('cmbCondicionCuerpoDocumento',arrCondicionDocumentoCuerpo,0,0,160,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbCuerpoDocumento'});
																    cmbCondicionCuerpoDocumento.setValue('2');
                                                                    
                                                                    var cmbCategoriaDocumentoFiltro=crearComboExt('cmbCategoriaDocumentoFiltro',arrCategorias,0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbCategoriaDocumento'});
                                                                
                                                                	gEx('tblFiltros').setActiveTab(1);
                                                                	////------/////
                                                                    
                                                                     var cmbEspecialidad=crearComboExt('cmbEspecialidad',arrEspecialidades,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divEspecialidad'});
                                                                    cmbEspecialidad.on('select',function(cmb,registro)
                                                                                                {
                                                                                                    gEx('cmbTipoProceso').setValue('');
                                                                                                    gEx('cmbTipoProceso').getStore().loadData(registro.data.valorComp);
                                                                                                }
                                                                                        )
                                                                    
                                                                    var cmbDespachos=crearComboExt('cmbDespachos',arrDespachos,0,0,750,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divDespacho'});
                                                                	var cmbTipoProceso=crearComboExt('cmbTipoProceso',[],0,0,330,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divTipoProceso'});
                                                                    var cmbEstadoProceso=crearComboExt('cmbEstadoProceso',arrEstadoProceso,0,0,170,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divEstadoProceso'});
                                                                    var cmbInicioFiltroDocumento=crearComboExt('cmbInicioFiltroDocumento',arrFiltroFecha,0,0,170,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbInicioFiltroFecha'});
                                                                    new Ext.form.DateField	(
                                                                    							 {
                                                                                                    
                                                                                                    ctCls:'campoFechaSIUGJ',
                                                                                                    width:130,
                                                                                                    renderTo:'divFechaInicioFiltroFecha',
                                                                                                    xtype:'datefield',
                                                                                                    id:'fInicioFiltro'
                                                                                                }
                                                                    						)
                                                                   
                                                                    
                                                                    var cmbFinFiltroDocumento=crearComboExt('cmbFinFiltroDocumento',arrFiltroFecha,0,0,170,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbFinFiltroFecha'});
                                                                		
                                                                    new Ext.form.DateField	(
                                                                    							 {
                                                                                                    
                                                                                                    ctCls:'campoFechaSIUGJ',
                                                                                                    width:130,
                                                                                                    renderTo:'divFechaFinFiltroFecha',
                                                                                                    xtype:'datefield',
                                                                                                    id:'fFinFiltro'
                                                                                                }
                                                                    						)
                                                                
                                                                
                                                                	gEx('tblFiltros').setActiveTab(0);
                                                                }
															}
												},
										buttons:	[
														{
															
															text: 'Cerrar',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
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


function crearGridResultadoProcesosDocumentos()
{
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
                                                        {name: 'carpetaAdministrativa'},
                                                        {name: 'categoriaDocumentos'},
                                                        {name: 'idCarpeta'},
                                                        {name: 'tipoCarpeta'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'tipoCarpeta',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='11';
                                        
                                    }
                        )   

	var expander = new Ext.ux.grid.RowExpander({
                                                column:2,
                                                width:40,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
                                                    '<tr><td ><span class="TSJDF_Control">{descripcion}</span><br /><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            });    
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                           new  Ext.grid.RowNumberer({width:60}),
                                                            expander,
                                                            {
                                                                header:'ID Documento',
                                                                width:100,
                                                                hidden:true,
                                                                sortable:true,
                                                                dataIndex:'idDocumento'
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idDocumento',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            
                                                                            var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                            return '<a href="javascript:visualizarDocumento(\''+bE(val)+'\')"><img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" /></a>'
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Fecha de registro',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                        {
                                                                            if(val)
                                                                                return val.format('d/m/Y H:i');
                                                                        }
                                                            },{
                                                                header:'Tipo documento',
                                                                width:240,
                                                                sortable:true,
                                                                dataIndex:'categoriaDocumentos',
                                                                renderer:function(val)
                                                                        {
                                                                            return mostrarValorDescripcion(formatearValorRenderer(arrCategorias,val));
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Documento',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'nomArchivoOriginal',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            
                                                            {
                                                                header:'Tama&ntilde;o',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'tamano',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            
                                                                            return bytesToSize(parseInt(val),0);
                                                                        }
                                                            },
                                                            {
                                                                header:'C&oacute;digo &uacute;nico de proceso',
                                                                width:260,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            
                                                                            return '<a href="javascript:setBusquedaCodigo(\''+bE(val)+'\',\''+bE(registro.data.idCarpeta)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                           {
                                                                header:'Tipo de Expediente',
                                                                width:260,
                                                                sortable:true,
                                                                dataIndex:'tipoCarpeta',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoCarpeta,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idDocumento',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            
                                                                            if(parseFloat(registro.data.idFormulario)>0)
                                                                                return '<a href="javascript:abrirProcesoOrigen(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')"><img src="../images/magnifier.png" title="Abrir proceso origen" alt="Abrir proceso origen" /></a>';
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gResultadoBusquedaDocumento',
                                                                store:alDatos,
                                                                cls:'gridSiugjPrincipal',
                                                                plugins:	[expander],
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                title:'Resultado',
                                                                columnLines : false,
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
        return 	tblGrid;
}

function setBusquedaCodigoProceso(cU,iE)
{
	gEx('txtNumeroExpediente').setValue(bD(cU));
    gEx('cmbAnio').setValue('0');
    idNodoSeleccionado='e_'+bD(iE);
    
    gEx('arbolExpedientes').getRootNode().reload();
    
}

function visualizarDocumento(iD)
{
	var pos=obtenerPosFila(gEx('gResultadoBusquedaDocumento').getStore(),'idDocumento',bD(iD));
    var registro=gEx('gResultadoBusquedaDocumento').getStore().getAt(pos);
    
    var arrNombre=registro.data.nomArchivoOriginal.split('.');
    var extension=arrNombre[arrNombre.length-1];
    var obj={};
    obj.url='../visoresGaleriaDocumentos/visorDocumentosGeneralBusqueda.php';
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=	[['iD',bE('iD_'+bD(iD))],['cPagina','sFrm=true'],['cPagina','sFrm=true'],['palabraBusqueda',gEx('txtCuerpoDocumento').getValue().trim()]];
    if(extension!='')
    	obj.params.push(['extension',extension]);
    
    abrirVentanaFancySuperior(obj);
    
}

function crearGridPropiedadesProceso()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idMeta'},
		                                                {name: 'metaData'},
		                                                {name:'valor'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'metaData', direction: 'ASC'},
                                                            groupField: 'metaData',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='30';
                                    	proxy.baseParams.cA=bE(nodoExpedienteSel.attributes.expediente);
                                        proxy.baseParams.tipoCarpeta=nodoExpedienteSel.attributes.tipoCarpeta;
                                       
                                        
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        {
                                                            header:'',
                                                            width:160,
                                                            sortable:true,
                                                            menuDisabled : true,
                                                            dataIndex:'metaData'
                                                        },
                                                        {
                                                            header:'',
                                                            width:300,
                                                            sortable:true,
                                                             menuDisabled : true,
                                                            dataIndex:'valor',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
                                                        },
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gMetaDataProceso',
                                                            store:alDatos,
                                                            region:'east',
                                                            collapsible:false,
                                                            title:'Datos del Proceso Judicial',
                                                            frame:false,
                                                            cm: cModelo,
                                                            cls:'gridSiugjVistaExpedienteUsuario',  
                                                            width:300,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false,
                                                            hideHeaders:true,
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

function visualizarTimeLine(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.openEffect='fade';
    obj.url='../modulosEspeciales_SGJ/frameHistorialCarpetaJudicial.php';
    obj.params=[['cA',cA],['cPagina','sFrm=true']];
    obj.titulo='Time Line, Proceso Judicial: '+bD(cA);
    abrirVentanaFancySuperior(obj);
}


function abrirVideoGrabacionTeams(url)
{
	var winFeatures = 'screenX=0,screenY=0,top=0,left=0,scrollbars,width=100,height=100';
    var winName = 'window';
    var win = window.open(bD(url),winName, winFeatures); 
    var extraWidth = win.screen.availWidth - win.outerWidth;
    var extraHeight = win.screen.availHeight - win.outerHeight;
    win.resizeBy(extraWidth, extraHeight);
    
    var timer = setInterval(function() { 
                                            if(win.closed) 
                                            {
                                                clearInterval(timer);
                                                
                                            }
                                        }, 1000);
    
    return win;
}
