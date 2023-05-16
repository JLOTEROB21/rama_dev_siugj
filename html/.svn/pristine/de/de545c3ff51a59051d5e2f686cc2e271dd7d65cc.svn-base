<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionEventosAudiencia=$con->obtenerFilasArreglo($consulta);
	$fechaActual=date("Y-m-d");
?>

var arrSituacionEventosAudiencia=<?php echo $arrSituacionEventosAudiencia?>;


Ext.onReady(inicializar);


function inicializar()
{
	crearGridAudiencias();
}

function crearGridAudiencias()
{
	var cmbSituacion=crearComboExt('cmbSituacion',arrSituacionEventosAudiencia,0,0,250);
    cmbSituacion.setValue('1');
    cmbSituacion.on('select',function()
    						{
                            	recargarRegistros();
                            }
    			)
	  var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idEventoAudiencia'},
		                                                {name: 'fechaEvento', type:'date', dateFormat:'Y-m-d'},
		                                                {name:'carpetaAdministrativa'},
                                                        {name: 'horarioEvento'},
                                                        {name: 'situacion'}
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
                                    	proxy.baseParams.funcion='25';
                                        proxy.baseParams.fE=gEx('dteFechaEvento').getValue().format('Y-m-d');
                                        proxy.baseParams.cA=gEx('txtCarpetaAdministrativa').getValue();
                                        proxy.baseParams.s=gEx('cmbSituacion').getValue();
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:40,
                                                                sortable:true,
                                                                dataIndex:'idEventoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<a href="javascript:abrirConsolaEvento(\''+bE(val)+'\')"><img src="../images/right1.png" title="Abrir consola del evento" alt="Abrir consola del evento"></a>'
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha del evento',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'fechaEvento',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y')
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta administrativa',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                                
                                                            },
                                                            {
                                                                header:'Horario del evento',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'horarioEvento'
                                                                
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacionEventosAudiencia,val)
                                                                        }
                                                                
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridEventosAudiencia',
                                                                store:alDatos,
                                                                renderTo:'tblAudiencias',
                                                                frame:false,
                                                                width:960,
                                                                height:450,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                tbar:	[
                                                                			{
                                                                            	xtype:'label',
                                                                                html:'<b>Mostrar eventos:</b>&nbsp;&nbsp;'
                                                                            },'-',
                                                                            {
                                                                            	xtype:'label',
                                                                                html:'Con fecha:&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                            	xtype:'datefield',
                                                                                id:'dteFechaEvento',
                                                                                listeners:	{
                                                                                				select:function()
                                                                                                		{
                                                                                                        	recargarRegistros();	
                                                                                                        }
                                                                                			},
                                                                                value:'<?php echo $fechaActual?>'
                                                                            },'-',
                                                                			{
                                                                            	xtype:'label',
                                                                                html:'En situaci&oacute;n:&nbsp;&nbsp;'
                                                                            },
                                                                            cmbSituacion,'-',
                                                                			{
                                                                            	xtype:'label',
                                                                                html:'Carpeta administrativa:&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                            	xtype:'textfield',
                                                                                width:170,
                                                                                listeners:	{
                                                                                				change:function()
                                                                                                		{
                                                                                                        	recargarRegistros();	
                                                                                                        }
                                                                                			},
                                                                                id:'txtCarpetaAdministrativa'
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
        return 	tblGrid;
}

function recargarRegistros()
{
	gEx('gridEventosAudiencia').getStore().reload();
}

function abrirConsolaEvento(iE)
{
	var obj={};
    obj.url='../modulosEspeciales_SGJP/tableroAudiencia.php';
    obj.params=[['idEventoAudiencia',bD(iE)]];
    obj.ancho='100%';
    obj.alto='100%';
    obj.openEffect='fade';
    obj.funcionCerrar=recargarRegistros;
    window.parent.abrirVentanaFancy(obj);    
    
    
}