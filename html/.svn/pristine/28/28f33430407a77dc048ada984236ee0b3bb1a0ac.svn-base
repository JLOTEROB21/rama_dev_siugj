<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT claveUnidad,CONCAT('[',claveFolioCarpetas,'] ',nombreUnidad) AS nombreUnidad FROM _17_tablaDinamica";
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
	var cmbCriterioBusqueda=crearComboExt('cmbCriterioBusqueda',[['1','Por nombre de participante'],['2','Por carpeta de investigaci\xF3n']],0,0,250);
    cmbCriterioBusqueda.setValue('1');
    
    var arrPorcentaje=[];
    var x;
    for(x=80;x<=100;x++)
    {
    	arrPorcentaje.push([x,x]);
    }
    
    var cmbPorcentaje=crearComboExt('cmbPorcentaje',arrPorcentaje,0,0,60);
    cmbPorcentaje.setValue(80);
    cmbPorcentaje.on('select',function()
    						{
                            	realizarBusqueda()
                            }
    				)
    cmbCriterioBusqueda.on('select',function(cmb,registro)
    								{
                                    	gEx('gridResultadoBusqueda').getStore().removeAll();
                                    	switch(registro.data.id)
                                        {
                                        	case '1':
                                            	gE('lblCriterio').innerHTML='Nombre del participante:&nbsp;&nbsp;';
                                                gEx('cmbPorcentaje').show();
                                                gEx('lblSimilitud').show();
                                            break;
                                            case '2':
                                            	gE('lblCriterio').innerHTML='Carpeta de investigaci&oacute;n:&nbsp;&nbsp;';  
                                                gEx('cmbPorcentaje').hide();  
                                                gEx('lblSimilitud').hide();                                            
                                            break;	
                                        }
                                        
                                        gEx('txtCriterio').setValue('');
                                        gEx('txtCriterio').focus(false,500);
                                        
                                    }
    						)
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
                                                                html:'Criterio de b&uacute;squeda:&nbsp;&nbsp;'
                                                            },
                                                            cmbCriterioBusqueda,'-',
                                                            {
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;&nbsp;<span id="lblCriterio">Nombre del participante:&nbsp;&nbsp;</span>'
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
                                                            }/*,'-',
                                                            {
                                                            	xtype:'label',
                                                                id:'lblSimilitud',
                                                                html:'&nbsp;&nbsp;&nbsp;&nbsp;Porcentaje de similitud:&nbsp;&nbsp;'
                                                            },
                                                            cmbPorcentaje*/
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
                                                        {name: 'unidadGestion'},
                                                        {name: 'datosImputado'},
                                                        {name: 'idEstado'},
                                                        {name: 'porcentaje',  type:'float'}
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
                                              sortInfo: {field: 'porcentaje', direction: 'DESC'},
                                              groupField: 'porcentaje',
                                              remoteGroup:false,
                                              remoteSort: false,
                                              autoLoad:false
                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnNOEncontrado').disable();
                                        gEx('btnEncontrado').disable();
                                    	proxy.baseParams.funcion='87';
                                        
                                    }
                        )   
       
	alDatos.on('load',function(proxy)
    								{
                                    	gEx('btnNOEncontrado').enable();
                                        gEx('gridResultadoBusqueda').getStore().sort('porcentaje','DESC');
                                        gEx('gridResultadoBusqueda').getView().refresh();
                                    }
                        )        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:30}),
                                                        chkRow,
                                                        {
                                                            header:'',
                                                            width:80,
                                                            sortable:true,
                                                            dataIndex:'porcentaje',
                                                            renderer:function(val,meta,registro)
                                                            			{
                                                                        	return '<span style="color#900"><b>'+Ext.util.Format.number(val,'0.00')+ '%</b></span>';
                                                                        }
                                                        },
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
                                                            header:'Situaci&oacute;n',
                                                            width:420,
                                                            sortable:true,
                                                            dataIndex:'idEstado',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrSituacion,val,1,true);
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
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/cross.png',
                                                                            cls:'x-btn-text-icon',
                                                                            id:'btnNOEncontrado',
                                                                            disabled:true,
                                                                            hidden:<?php echo existeRol("'155_0'")?"true":"false"?>,
                                                                            text:'Imprimir constancia de persona NO encontrada ',
                                                                            handler:function()
                                                                            		{
                                                                                    	obtenerContanciaBuqueda(0,gEx('txtCriterio').getValue(),'');	
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/icon_big_tick.gif',
                                                                            cls:'x-btn-text-icon',
                                                                            id:'btnEncontrado',
                                                                            disabled:true,
                                                                            hidden:<?php echo existeRol("'155_0'")?"true":"false"?>,
                                                                            text:'Imprimir constancia de persona encontrada',
                                                                            handler:function()
                                                                            		{
                                                                                    	var listaCarpetas='';
                                                                                        
                                                                                        var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        var x;
                                                                                        for(x=0;x<filas.length;x++)
                                                                                        {
                                                                                        	if(listaCarpetas=='')
                                                                                            {
                                                                                            	listaCarpetas=filas[x].data.carpetaJudicial;
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                            	listaCarpetas+=','+filas[x].data.carpetaJudicial;
                                                                                            }
                                                                                        }
                                                                                    	obtenerContanciaBuqueda(1,gEx('txtCriterio').getValue(),listaCarpetas);
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
                                                                                                startCollapsed:false,
                                                                                                enableRowBody:true,
                                                                            					getRowClass : formatearFila
                                                                                            })
                                                        }
                                                    );
    
    tblGrid.getSelectionModel().on(	'rowselect',function(sm,nFila,registro)
    											{
                                                	gEx('btnNOEncontrado').disable();
                                                    gEx('btnEncontrado').disable();
                                                	if(gEx('gridResultadoBusqueda').getSelectionModel().getSelections().length>0)
                                                    {
                                                    	
                                                        gEx('btnEncontrado').enable();
                                                    }
                                                    
                                                }
    								)
    
    
    tblGrid.getSelectionModel().on(	'rowdeselect',function(sm,nFila,registro)
    											{
                                                	gEx('btnNOEncontrado').disable();
                                                    gEx('btnEncontrado').disable();
                                                	if(gEx('gridResultadoBusqueda').getSelectionModel().getSelections().length==0)
                                                    {
                                                    	
                                                        gEx('btnNOEncontrado').enable();
                                                    }
                                                    else
                                                    {
                                                    	gEx('btnEncontrado').enable();
                                                    }
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
                                                                                funcion:80,
                                                                                tipoCriterio: gEx('cmbCriterioBusqueda').getValue(),
                                                                                valor:gEx('txtCriterio').getValue(),
                                                                                unidadGestion:'<?php echo existeRol("'163_0'")?$_SESSION["codigoInstitucion"]:''?>',
                                                                                porcentaje:gEx('cmbPorcentaje').getValue()
                                                                            }
                                                            	}
  	                                                      )
	}                                                          
}

var msgEspere;
var primeraCargaFrame=true;
function obtenerContanciaBuqueda(tipoConstancia,nombreBusqueda,carpetaJudicial)
{
	mostrarVentanaEspereImpresion();
	var arrParametros=[['tipoConstancia',tipoConstancia],['carpetaJudicial',carpetaJudicial],['nombreBusqueda',nombreBusqueda]]
    enviarFormularioDatos('../modulosEspeciales_SGJP/generarContanciaBusqueda.php',arrParametros,'POST','frameDTD');
    
}

function frameLoad(iFrame)
{
	if(!primeraCargaFrame)
    {
    	setTimeout(function()
        			{
                        ocultarMensajeEspereImpresion();
                        iFrame.contentWindow.print();
                    },2000
                   );

    }
    else
    	primeraCargaFrame=false;
	
}


function mostrarVentanaEspereImpresion()
{
	try
	{
		msgEspere=Ext.MessageBox.wait('Espere por favor...',lblAplicacion)
	}
	catch(err)
	{
		
	}
}

function ocultarMensajeEspereImpresion()
{
	try
	{
		msgEspere.hide()
	}
	catch(err)
	{
		
	}
}
