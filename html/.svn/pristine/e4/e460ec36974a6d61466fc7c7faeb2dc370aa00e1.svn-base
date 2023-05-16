<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__628_tablaDinamica,nombreRecurso FROM _628_tablaDinamica";
	$arrRecursos=$con->obtenerFilasArreglo($consulta);
	$fechaActual=date("Y-m-d");
?>


var arrRecursos=<?php echo $arrRecursos?>;
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
                                                title: gE('vistaGlobal').value=='0'?'<span class="letraRojaSubrayada8" style="font-size:14px"><b>Cub&iacute;culos: <span style="color:#000">'+gE('lblUnidad').value+'</span></b></span>':'',
                                                items:	[
                                                            crearGridCubiculos()
                                                        ]
                                            }
                                         ]
                            }
                        )  
}


function crearGridCubiculos()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'idRecurso'},
		                                                {name: 'horaInicio', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name: 'carpetaAdministrativa'},
                                                        {name: 'carpetaInvestigacion'},
                                                        {name: 'imputado'},
                                                        {name: 'tipoAudiencia'},
                                                        {name: 'lblRecurso'}
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
                                                            sortInfo: {field: 'idRecurso', direction: 'ASC'},
                                                            groupField: 'idRecurso',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='305';
                                        proxy.baseParams.unidadGestion=gE('adscripcion').value;
                                        proxy.baseParams.fInicio=gEx('dtePeriodoInicial').getValue().format('Y-m-d');
                                        proxy.baseParams.fFin=gEx('dtePeriodoFinal').getValue().format('Y-m-d');
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        
                                                        {
                                                            header:'Cub&iacute;culo',
                                                            width:170,
                                                            sortable:true,
                                                            dataIndex:'idRecurso',
                                                            renderer:function(val)
                                                            		{
                                                                    
                                                                    	var lbltiqueta=formatearValorRenderer(arrRecursos,val);
                                                                        if(gE('adscripcion').value=='0')
                                                                        	return lbltiqueta;
                                                                        var arrEtiqueta=lbltiqueta.split('-');
                                                                    	return arrEtiqueta[0].trim();
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha',
                                                            width:90,
                                                            sortable:true,
                                                            dataIndex:'horaInicio',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                        },
                                                        {
                                                            header:'Hora',
                                                            width:50,
                                                            sortable:true,
                                                            dataIndex:'horaInicio',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val.format('H:i');
                                                                        }
                                                        },
                                                        {
                                                            header:'Carpeta Judicial',
                                                            width:160,
                                                            sortable:true,
                                                            dataIndex:'carpetaAdministrativa',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val;
                                                                        }
                                                        },
                                                        {
                                                            header:'Carpeta de Investigaci&oacute;n',
                                                            width:400,
                                                            sortable:true,
                                                            dataIndex:'carpetaInvestigacion',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val;
                                                                        }
                                                        },
                                                        
                                                        {
                                                            header:'Imputados',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'imputado',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val;
                                                                        }
                                                        },
                                                        {
                                                            header:'Tipo de audiencia',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'tipoAudiencia',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val;
                                                                        }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridCubiculos',
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
                                                                            html:'&nbsp;&nbsp;&nbsp;<span style="font-size:14px"><b>Periodo del:</b></span>&nbsp;&nbsp;&nbsp;'
                                                                        },
                                                                        {
                                                                            xtype:'datefield',
                                                                            id:'dtePeriodoInicial',
                                                                            value:'<?php echo $fechaActual?>',
                                                                            listeners:	{
                                                                                            select:function()
                                                                                                    {
                                                                                                        recargarGridEventos();
                                                                                                    }
                                                                                                    
                                                                                        }
                                                                        },'-',
                                                                        {
                                                                            xtype:'label',
                                                                            html:'&nbsp;&nbsp;&nbsp;<span style="font-size:14px"><b> al:</b></span>&nbsp;&nbsp;&nbsp;'
                                                                        },
                                                                        {
                                                                            xtype:'datefield',
                                                                            id:'dtePeriodoFinal',
                                                                            value:'<?php echo $fechaActual?>',
                                                                            listeners:	{
                                                                                            select:function()
                                                                                                    {
                                                                                                        recargarGridEventos();
                                                                                                    }
                                                                                                    
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

function recargarGridEventos()
{
	gEx('gridCubiculos').getStore().reload();
}