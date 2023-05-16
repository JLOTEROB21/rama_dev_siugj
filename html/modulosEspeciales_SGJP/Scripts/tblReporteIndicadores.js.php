<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica u,_17_gridDelitosAtiende d WHERE cmbCategoria=1 
				AND d.idReferencia=u.id__17_tablaDinamica AND d.tipoDelito IN('A','B','X','M') ORDER BY prioridad";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__35_denominacionDelito ,denominacionDelito FROM _35_denominacionDelito ORDER BY denominacionDelito ";
	$arrDelitos=$con->obtenerFilasArreglo($consulta);
?>

var arrDelitos=<?php echo $arrDelitos?>;
var arrUnidades=<?php echo $arrUnidades?>;


var arrCategorias=[['1','Generales'],['2','Calidad']];

Ext.onReady(inicializar);

function inicializar()
{
	var objConf={};
    objConf.multiSelect=true;
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidades,0,0,350,objConf);
    
    
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b></b></span>',
                                                tbar:	[
                                                			{
                                                            	xtype:'label',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;Periodo del:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dteFechaInicio',
                                                                value:'<?php echo date("Y-m-d")?>',
                                                                listeners:	{
                                                                				//select:cargarReporte
                                                                			}
                                                            },
                                                            {
                                                            	xtype:'label',
                                                                html:'<b>&nbsp;&nbsp;&nbsp;al:&nbsp;&nbsp;&nbsp;</b>'
                                                            },
                                                            {
                                                            	xtype:'datefield',
                                                                id:'dteFechaFin',
                                                                value:'<?php echo date("Y-m-d")?>',
                                                                listeners:	{
                                                                				//select:cargarReporte
                                                                			}
                                                            },'-',
                                                			{
                                                            	xtype:'label',
                                                            	html:'&nbsp;&nbsp;<b>Unidad de Gesti&oacute;n:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbUnidadGestion
                                                		],
                                                items:	[
                                                            crearGridIndicadores()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridIndicadores()
{
	var objConf={};
    objConf.multiSelect=true;
    arrDelitos.splice(0,0,['0','Cualquiera']);
	var cmbTipoDelito=crearComboExt('cmbTipoDelito',arrDelitos,0,0,600,objConf);
    cmbTipoDelito.setValue('0');
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'indicador'},
		                                                {name: 'valor'},
                                                        {name: 'categoria'}
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
                                                sortInfo: {field: 'categoria', direction: 'ASC'},
                                                groupField: 'categoria',
                                                remoteGroup:false,
                                                remoteSort: true,
                                                autoLoad:false
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='206';
                                        
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'Indicador',
                                                                width:550,
                                                                sortable:true,
                                                                dataIndex:'indicador'
                                                            },
                                                            {
                                                                header:'',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'valor'
                                                            },

                                                            {
                                                                header:'Categor&iacute;a',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'categoria',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrCategorias,val);
                                                                            }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gReporte',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                tbar:	[
                                                                			{
                                                                            	xtype:'label',
                                                                                html:'&nbsp;&nbsp;&nbsp;<b>Tipo delito:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            cmbTipoDelito,'-',
                                                                            {
                                                                                icon:'../images/icon_big_tick.gif',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Generar',
                                                                                handler:function()
                                                                                        {
                                                                                            
                                                                                            if(gEx('cmbUnidadGestion').getValue()=='')
                                                                                            {
                                                                                                msgBox('Debe seleccionar la unidad de gesti&oacute;n de la cual desea obtener el reporte');
                                                                                                return;
                                                                                            }
                                                                                            
                                                                                            cargarReporte();
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

function cargarReporte()
{
	gEx('gReporte').getStore().load	(
    									{
                                        	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                            params:	{
                                            			fechaInicio:gEx('dteFechaInicio').getValue().format('Y-m-d'),
                                                        fechaFin:gEx('dteFechaFin').getValue().format('Y-m-d'),
                                                        idUnidadGestion:gEx('cmbUnidadGestion').getValue(),
                                                        tipoDelito:gEx('cmbTipoDelito').getValue()
                                            		}
                                        }
    								)
}