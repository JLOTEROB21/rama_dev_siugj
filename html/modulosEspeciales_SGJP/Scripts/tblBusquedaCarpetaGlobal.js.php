<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);
	
	
	
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
	$consulta="SELECT idTipoCarpeta,nombreTipoCarpeta FROM 7020_tipoCarpetaAdministrativa WHERE idTipoCarpeta not in(7,8,9) ORDER BY prioridad";
	if(!existeRol("'1_0'") && !existeRol("'90_0'") && !existeRol("'112_0'")&& !existeRol("'203_0'"))
	{
		$consulta="SELECT idTipoCarpeta,nombreTipoCarpeta FROM 7020_tipoCarpetaAdministrativa WHERE idTipoCarpeta 
					in (SELECT DISTINCT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='".$_SESSION["codigoInstitucion"].
					"') and idTipoCarpeta <>9";
	}
	
	$arrTipoCarpetaJudicial=$con->obtenerFilasArreglo($consulta);
	$listCarpetasCualquiera=$con->obtenerListaValores($consulta,"'");
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica";
	$arrUGAS=$con->obtenerFilasArreglo($consulta);
?>
var arrUGAS=<?php echo $arrUGAS?>;
var arrTipoCarpetaJudicial=<?php echo $arrTipoCarpetaJudicial?>;
var listCarpetasCualquiera="<?php echo $listCarpetasCualquiera?>";
var arrTipoFigura=<?php echo $arrTipoFigura?>;
var arrSituacion=<?php echo $arrEtapas?>;
var arrTipoCarpetaJudicial=<?php echo $arrTipoCarpetaJudicial?>;
Ext.onReady(inicializar);

function inicializar()
{
	arrTipoFigura.splice(0,0,['0','Cualquiera']);
	arrTipoCarpetaJudicial.splice(0,0,[listCarpetasCualquiera,'Cualquiera']);
    var cmbCriterioBusqueda=crearComboExt('cmbCriterioBusqueda',[['1','Por nombre de participante'],['2','Por carpeta de investigaci\xF3n']],0,0,250);
    cmbCriterioBusqueda.setValue('1');
    var cmbTipoFigura=crearComboExt('cmbTipoFigura',arrTipoFigura,0,0,180);
    cmbTipoFigura.setValue('4');
    cmbTipoFigura.on('select',realizarBusqueda);
    
    var cmbTipoCarpetaJudicial=crearComboExt('cmbTipoCarpetaJudicial',arrTipoCarpetaJudicial,0,0,250);
    cmbTipoCarpetaJudicial.setValue(listCarpetasCualquiera);
    cmbTipoCarpetaJudicial.on('select',realizarBusqueda);
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
                                                                html:'&nbsp;&nbsp;&nbsp;&nbsp;<span id="lblCriterio"><b>Ingrese el nombre que desea buscar:&nbsp;&nbsp;</b></span>'
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
                                                            },'-',
                                                            {
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;<span id="lblCriterio"><b>Tipo de Participaci&oacute;n:&nbsp;&nbsp;</b></span>'
                                                            },
                                                            cmbTipoFigura,'-',
                                                            {
                                                            	xtype:'label',
                                                                html:'&nbsp;&nbsp;<span id="lblCriterio"><b>Tipo de Carpeta Judicial:&nbsp;&nbsp;</b></span>'
                                                            },
                                                            cmbTipoCarpetaJudicial
                                                            
                                                            
                                                            
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
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'iRegistro'},
		                                                {name: 'iFormulario'},
                                                        {name:'tipoExpediente'},
                                                        {name:'idExpediente'},
		                                                {name:'fechaRecepcion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'expediente'},
                                                        {name: 'unidadGestion'},
                                                        {name: 'datosImputado'},
                                                        {name: 'idEstado'},
                                                        {name: 'carpetaInvestigacion'},
                                                        {name: 'delitos'},
                                                        {name: 'porcentaje',  type:'int'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(

                                                                                {

                                                                                    url: '../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',
                                                                                    timeout:600000

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
                                    	proxy.baseParams.funcion='19';
                                        
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:45}),
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
                                                            header:'Expediente',
                                                            width:160,
                                                            sortable:true,
                                                            dataIndex:'expediente',
                                                            renderer:function(val,meta,registro)
                                                            			{
                                                                        	return '<a href="javascript:abrirExpedienteSolicitud(\''+bE(val)+'\',\''+bE(registro.data.idExpediente)+'\')">'+val+'</a>';
                                                                            
                                                                        }
                                                        },
                                                         {
                                                            header:'Unidad de Gesti&oacute;n Judicial',
                                                            width:500,
                                                            sortable:true,
                                                            dataIndex:'unidadGestion',
                                                           	renderer:function(val)
                                                            			{
                                                                        	return formatearValorRenderer(arrUGAS,val);
                                                                        }
                                                        },
                                                         {
                                                            header:'Tipo de expediente',
                                                            width:250,
                                                            sortable:true,
                                                            dataIndex:'tipoExpediente',
                                                            renderer:function(val)
                                                            			{
                                                                        	return formatearValorRenderer(arrTipoCarpetaJudicial,val);
                                                                        }
                                                        },
                                                         {
                                                            header:'Carpeta de Investigaci&oacute;n',
                                                            width:450,
                                                            sortable:true,
                                                            dataIndex:'carpetaInvestigacion',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val;
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
    p.body = '<br><br><table width="100%"><tr><td width="30"></td><td><b>Figuras jur&iacute;dicas</b><br><br>'+record.data.datosImputado+'<br><br></td></tr></table><br><br>';//<tr><td width="30"></td><td><b>Delitos</b><br><br>'+record.data.delitos+'</td></tr>
    return 'x-grid3-row-expanded';
}

function realizarBusqueda()
{
	if(gEx('txtCriterio').getValue()!='')
    {
        gEx('gridResultadoBusqueda').getStore().removeAll();    
        gEx('gridResultadoBusqueda').getStore().load	(
                                                                    {
                                                                        url:'../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',
                                                                        params:	{
                                                                                    funcion:19,
                                                                                    tipoCriterio: 1,
                                                                                    tipoFigura:gEx('cmbTipoFigura').getValue(),
                                                                                    unidadGestion:'<?php echo $_SESSION["codigoInstitucion"]?>',
                                                                                    valor:gEx('txtCriterio').getValue(),
                                                                                    tipoCarpeta:gEx('cmbTipoCarpetaJudicial').getValue(),
                                                                                    porcentaje:gEx('cmbPorcentaje').getValue()
                                                                                }
                                                                    }
                                                              )
   }                                                       
}


function abrirExpedienteSolicitud(e,iE)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAdministracion.php';
    obj.params=	[
                    ['idCarpetaAdministrativa',bD(iE)],
                    ['cA',e]
                ]
                
    if(window.parent)             
        window.parent.abrirVentanaFancy(obj);
    else
        window.abrirVentanaFancy(obj);
}