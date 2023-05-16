<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama";
	$arrUnidadGestion=$con->obtenerFilasArreglo($consulta);
	
	
	
	$arrEtapas="";
	$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=89 ORDER BY numEtapa";
	$rEtapas=$con->obtenerFilas($consulta);
	
	while($fEtapas=mysql_fetch_row($rEtapas))
	{
		$o="['".$fEtapas[0]."','".removerCerosDerecha($fEtapas[0]).". ".cv($fEtapas[1])."']";
		if($arrEtapas=="")
			$arrEtapas=$o;
		else
			$arrEtapas.=",".$o;
	}
	
	
	$arrEtapas="[".$arrEtapas."]";
	
	
?>


var arrSituacion=<?php echo $arrEtapas?>;
var arrUnidadGestion=<?php echo $arrUnidadGestion?>;

Ext.onReady(inicializar);

function inicializar()
{
	
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                tbar:	[
                                                			
                                                            {
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;&nbsp;<span id="lblCriterio"><b>Carpeta Judicial:&nbsp;&nbsp;</b></span>'
                                                            },
                                                            {
                                                            	xtype:'textfield',
                                                                width:300,
                                                                enableKeyEvents:true,
                                                                id:'txtCriterio',
                                                                listeners:	{
                                                                				specialkey:function(field, e)
                                                                                			{
                                                                                            	 if ((e.getKey() == e.ENTER)||(e.getKey() == e.TAB))
                                                                                                 {
                                                                                                 	realizarBusqueda();
                                                                                                 }
                                                                                            }
                                                                				
                                                                			}
                                                            }
                                                		],
                                               
                                                items:	[
                                                         	crearGridResultadoBusqueda()   
                                                        ]
                                            }
                                         ]
                            }
                        )
                        
	gEx('txtCriterio').focus(false,500);                        
                           
}

function crearGridResultadoBusqueda()
{
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'iRegistro'},
		                                                {name: 'iFormulario'},
		                                                {name:'carpetaInvestigacion'},
		                                                {name:'fechaRecepcion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'carpetaJudicial'},
                                                        {name: 'carpetaApelacion'},
                                                        {name: 'unidadGestion'},
                                                        {name: 'imputado'},
                                                        {name: 'victima'},
                                                        {name: 'salaPenal'},
                                                        {name: 'noToca'},
                                                        {name: 'resolucionImpugnada'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(

                                                                                {

                                                                                    url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                                    timeout:300000

                                                                                }

                                                                            ),
                                              sortInfo: {field: 'carpetaJudicial', direction: 'ASC'},
                                              groupField: 'carpetaJudicial',
                                              remoteGroup:false,
                                              remoteSort: false,
                                              autoLoad:false
                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                    	proxy.baseParams.funcion='300';
                                        
                                    }
                        )   
       
	alDatos.on('load',function(proxy)
    								{
                                    	
                                    }
                        )        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:30}),
                                                        chkRow,
                                                        
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'iRegistro',
                                                            renderer:function(val,meta,registro)
                                                            			{
                                                                        	if((val!='-1')&&(val!=''))
                                                                            {
                                                                            	return '<a href="javascript:abrirRegistroSolicitud(\''+bE(registro.data.iFormulario)+'\',\''+bE(val)+'\')"><img src="../images/magnifier.png"></a>';
                                                                                            
                                                                            }
                                                                        }
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'fechaRecepcion',
                                                            renderer:function(val)
                                                            			{
                                                                        	if(val)
	                                                                        	return val.format('d/m/Y H:i:s');
                                                                        }
                                                        },
                                                        {
                                                            header:'Carpeta de Investigaci&oacute;n',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'carpetaInvestigacion'
                                                        },
                                                         {
                                                            header:'Carpeta Judicial',
                                                            width:160,
                                                            sortable:true,
                                                            dataIndex:'carpetaJudicial'
                                                        },
                                                         {
                                                            header:'Unidad de Gestion',
                                                            width:280,
                                                            sortable:true,
                                                            dataIndex:'unidadGestion',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrUnidadGestion,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Carpeta de Apelaci&oacute;n',
                                                            width:160,
                                                            sortable:true,
                                                            dataIndex:'carpetaApelacion'
                                                        },
                                                        {
                                                            header:'TOCA',
                                                            width:160,
                                                            sortable:true,
                                                            dataIndex:'noToca'
                                                        },
                                                        {
                                                            header:'Sala Penal',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'salaPenal',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrUnidadGestion,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Resoluci&oacute;n impugnada',
                                                            width:450,
                                                            sortable:true,
                                                            dataIndex:'resolucionImpugnada',
                                                            renderer:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
                                                        },
                                                         {
                                                            header:'Imputado',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'imputado',
                                                            renderer:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
                                                        },
                                                         {
                                                            header:'V&iacute;ctima',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'victima',
                                                            renderer:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridResultadoBusqueda',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,
                                                            sm:chkRow,                                                         
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
    
    tblGrid.getSelectionModel().on(	'rowselect',function(sm,nFila,registro)
    											{
                                                	
                                                    
                                                }
    								)
    
    
    tblGrid.getSelectionModel().on(	'rowdeselect',function(sm,nFila,registro)
    											{
                                                	
                                                }
    								)
    return 	tblGrid;	
}


function abrirRegistroSolicitud(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=	[
                    ['idRegistro',bD(iR)],
                    ['idFormulario',bD(iF)],
                    ['dComp',bE('auto')],
                    ['acto',bE('0')]
                ]
                
    if(window.parent)             
        window.parent.abrirVentanaFancy(obj);
    else
        window.parent.abrirVentanaFancy(obj);
}

function formatearFila(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;
    p.body = '<br><br><table width="100%"><tr><td width="30"></td><td><b>Figuras jur&iacute;dicas</b><br><br>'+record.data.datosImputado+'</td></tr></table><br><br>';
    return 'x-grid3-row-expanded';
}

function realizarBusqueda()
{
	gEx('gridResultadoBusqueda').getStore().removeAll();    
    
    if(gEx('txtCriterio').getValue()!='')
    {
        gEx('gridResultadoBusqueda').getStore().load	(
                                                            	{
                                                                	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                                    params:	{
                                                                                funcion:300,
                                                                                valor:gEx('txtCriterio').getValue()
                                                                            }
                                                            	}
  	                                                      )
	}                                                          
}

