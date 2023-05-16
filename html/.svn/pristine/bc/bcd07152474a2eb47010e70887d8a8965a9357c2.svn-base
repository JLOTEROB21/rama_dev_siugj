<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$tipoAudiencia=$_GET["tipoAudiencia"];
	$formularioEvaluacion=$_GET["formularioEvaluacion"];
	
	$unidadGestion=$_GET["unidadGestion"];
	
	
	$totalSecciones=0;
	$consulta="SELECT nombreCorto,orden FROM _000_catalogoSeccionesCuestionariosEvaluacion 
			WHERE idCuestionario=".$formularioEvaluacion." ORDER BY orden";
	$res=$con->obtenerFilas($consulta);
	
	$arrCampos="";
	$arrColumnas="";
	$etiquetasGrafico="";
	while($fila=mysql_fetch_row($res))
	{
		if($etiquetasGrafico=="")
			$etiquetasGrafico="'".mb_substr($fila[0],0,20)."'";
		else
			$etiquetasGrafico.=",'".mb_substr($fila[0],0,20)."'";
		$arrCampos.=',{name: "seccion_'.($fila[1]-1).'"}';
		$arrColumnas.=",{
						  header:'".cv($fila[0])."',
						  width:120,
						  align:'center',
						  sortable:true,
						  dataIndex:'seccion_".($fila[1]-1)."',
						  renderer:function(val,meta,registro)
						  			{
										meta.attr='style=\"min-height:250px;\"';
										if(val=='')
                                        	val=0;
										return Ext.util.Format.number(val,'0.00')+ ' %';
									}
	
					  }";
		$totalSecciones++;					  
	}
	
	$consulta="	SELECT 	usuarioJuez as idJuez,CONCAT('[',clave,'] ',(SELECT nombre FROM 800_usuarios u WHERE u.idUsuario=usuarioJuez)) AS nombreJuez
				FROM _26_tablaDinamica j,_26_tipoJuez tj WHERE tj.idPadre=j.id__26_tablaDinamica and tj.idOpcion=1 and idReferencia
				IN(".$unidadGestion.") AND usuarioJuez<>-1 AND usuarioJuez IS NOT NULL order by clave";
	$arrJueces=$con->obtenerFilasArreglo($consulta);
	
?>

var totalGraficos=0;
var totalSecciones=<?php echo $totalSecciones?>;
var etiquetasGrafico=[<?php echo $etiquetasGrafico?>];
Ext.onReady(inicializar);

function inicializar()
{
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                border:false,
                                                layout:'border',
                                                items:	[
                                                            crearGridEvaluacion()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridEvaluacion()
{
	var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ {type: 'list', dataIndex: 'idJuez', phpMode:true, options:<?php echo $arrJueces?>} ]
                                                    }
                                                );     
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idJuez'},
                                                        {name: 'noJuez'},
                                                        {name: 'nombreJuez'},
		                                                {name:'unidadGestion'},
                                                        {name: 'total'},
                                                        {name: 'totalEvaluaciones'}
                                                        <?php echo $arrCampos?>
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesReportes.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'total', direction: 'DESC'},
                                                            groupField: 'unidadGestion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	totalGraficos=0;
                                    	gEx('btnImprimir').disable();
                                    	proxy.baseParams.funcion='22';
                                        proxy.baseParams.tipoAudiencia='<?php echo $tipoAudiencia?>';
                                        proxy.baseParams.formularioEvaluacion='<?php echo $formularioEvaluacion?>';
                                        proxy.baseParams.fechaFin=gE('fechaFin').value;
                                        proxy.baseParams.fechaInicio=gE('fechaInicio').value;
                                        proxy.baseParams.unidadGestion=gE('unidadGestion').value;
                                        
                                    }
                        )   
	
    
    alDatos.on('load',function(proxy)
    								{
                                    	dibujarGraficosDesempenio();
                                        
                                    }
                        )
           
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Juez',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'idJuez',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return registro.data.nombreJuez;
                                                                        }
                                                            },
                                                            {
                                                                header:'Unidad Gesti&oacute;n',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'unidadGestion'
                                                            },
                                                            {
                                                            	header:'Total',
                                                                width:80,
                                                                sortable:true,
                                                                dataIndex:'total',
                                                                align:'center',
                                                                renderer:function(val)
                                                                        {
                                                                        		if(val=='')
                                                                                	val=0;
                                                                                return Ext.util.Format.number(val,'0.00')+ ' %';
                                                                        }
                                                            },
                                                            {
                                                            	header:'# Evaluaciones',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'totalEvaluaciones',
                                                                align:'center',
                                                                renderer:function(val)
                                                                        {
                                                                        		
                                                                                return val;
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:380,
                                                                sortable:true,
                                                                dataIndex:'idJuez',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<div ><canvas id="canvas_'+val+'" Width="350" Height="250" ></canvas></div>';

                                                                        }
                                                            }
															<?php echo $arrColumnas?>
                                                            
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gEvaluacion',
                                                                store:alDatos,
                                                                region:'center',
                                                                border:false,
                                                                frame:false,
                                                                cm: cModelo,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/printer.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                id:'btnImprimir',
                                                                                text:'Obtener versi&oacute;n imprimible',
                                                                                handler:function()
                                                                                        {
                                                                                            obtenerVersionImprimible();
                                                                                        }
                                                                                
                                                                            }
                                                                		],
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                plugins:	[filters],
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

function dibujarGraficosDesempenio()
{

	setTimeout	(	
    				function()
                    { 
                    	var gEvaluacion=gEx('gEvaluacion');
                        var fila;
                        var x;
                        var radarChartData;
                        var arrDatos;
                        var ctAux;
                        for(x=0;x<gEvaluacion.getStore().getCount();x++)
                        {
                        	fila=gEvaluacion.getStore().getAt(x);
                            arrDatos=[];
                            for(ctAux=0;ctAux<totalSecciones;ctAux++)
                            {
                            	arrDatos.push(parseFloat(fila.get('seccion_'+ctAux)==''?0:fila.get('seccion_'+ctAux)));
                            }
                            
                            radarChartData =	{
                            						labels: etiquetasGrafico,
                                                    datasets:	[
                                                    				{
                                                                        fillColor: "rgba(255,0,0,0.2)",
																		strokeColor: "rgba(151,187,205,1)",
                                                                        pointColor: "rgba(220,220,220,1)",
                                                                        pointStrokeColor: "#fff",
                                                                        pointHighlightFill: "#fff",
                                                                        pointHighlightStroke: "rgba(220,220,220,1)",
                                                                        data: arrDatos
                                                                     }

                                                    			]

                            					}
                           	
                            var c=new Chart(gE('canvas_'+fila.data.idJuez).getContext("2d")).Radar(radarChartData, {
                                                                                                                    responsive: false,
                                                                                                                    scaleShowLabels:false,
                                                                                                                    pointLabelFontSize:8,
                                                                                                                    pointLabelFontColor:'#000'
                                                                                                                    
                                                                                                                }
                                                                                             );

                          c.onAnimationComplete=function(i)
                          						{
                                                	totalGraficos++;
                                                    if(totalGraficos==gEx('gEvaluacion').getStore().getCount())
                                                    {
                                                    	gEx('btnImprimir').enable();
                                                    }
                                                    else
                                                    {
                                                    	gEx('btnImprimir').disable();
                                                    }
                                                }
                            
                        }
                        
                	}, 
                    1500
                 );

}


function frameLoad(iFrame)
{
	if(!primeraCargaFrame)
    {
    	setTimeout(function()
        			{
                        ocultarMensajeEspereExhorto();
                        iFrame.contentWindow.print();
                    },2000
                   );

    }
    else
    	primeraCargaFrame=false;
	
}

var listaJueces='';
var msgEspere;
var primeraCargaFrame=true;
function obtenerVersionImprimible()
{
	var gEvaluacion=gEx('gEvaluacion');
    var x;
    var fila;
    var oJuez='';
    for(x=0;x<gEvaluacion.getStore().getCount();x++)
    {
    	fila=gEvaluacion.getStore().getAt(x);
        
        oJuez='{"idJuez":"'+fila.data.idJuez+'","grafico":"'+bE(gE('canvas_'+fila.data.idJuez).toDataURL('image/png'))+'"}';
        console.log(oJuez);
        if(listaJueces=='')
        	listaJueces=oJuez;
       	else
        	listaJueces+=','+oJuez;
        
    }
   
	var sort;
    var dir;
	
	//mostrarVentanaEspereExhorto();
	
    var arrParametros=[	['tipoAudiencia',<?php echo $tipoAudiencia?>],['fechaInicio',gE('fechaInicio').value],
    					['fechaFin',gE('fechaFin').value],['unidadGestion',gE('unidadGestion').value],
                        ['formularioEvaluacion',<?php echo $formularioEvaluacion ?>],['listaJueces',bE(listaJueces)],
                        ['sort',gEvaluacion.getStore().sortInfo.field],['dir',gEvaluacion.getStore().sortInfo.direction]
                       ];
    
    
    enviarFormularioDatos('../modulosEspeciales_SGJP/generarInformeDesempeno.php',arrParametros,'POST');
    
}

function mostrarVentanaEspereExhorto()
{
	try
	{
		msgEspere=Ext.MessageBox.wait('Espere por favor...',lblAplicacion)
	}
	catch(err)
	{
		
	}
}

function ocultarMensajeEspereExhorto()
{
	try
	{
		msgEspere.hide()
	}
	catch(err)
	{
		
	}
}