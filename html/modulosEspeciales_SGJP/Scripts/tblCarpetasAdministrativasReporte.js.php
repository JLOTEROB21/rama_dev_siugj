<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT DISTINCT anio,anio FROM 7004_seriesUnidadesGestion ORDER BY anio ASC";
	$arrCiclosCarpeta=$con->obtenerFilasArreglo($consulta);
	$anio=date("Y");
	
	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa";
	$arrSituacionCarpeta=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa FROM 7009_etapasProcesales";
	$arrEtapaProcesal=$con->obtenerFilasArreglo($consulta);	
	
?>
var arrEtapaProcesal=<?php echo $arrEtapaProcesal ?>;
var arrSituacionCarpeta=<?php echo $arrSituacionCarpeta ?>;
var anio='<?php echo $anio ?>';
var arrCiclosCarpeta=<?php echo $arrCiclosCarpeta?>;
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
                                                items:	[
                                                            crearGridCarpetasAdministrativas()
                                                        ]
                                            }
                                         ]
                            }
                        )   
	
}

function crearGridCarpetasAdministrativas()
{
	var cmbAnio=crearComboExt('cmbAnio',arrCiclosCarpeta,0,0,120);
    
    cmbAnio.setValue(anio);
    cmbAnio.on('select',recargarGrid);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'carpetaAdministrativa'},
		                                                {name: 'situacion'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'carpetaInicial'},
                                                        {name: 'carpetaOralidad'},
                                                        {name: 'carpetaEjecucion'},
                                                        {name: 'carpetaApelacion'}
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
                                                            sortInfo: {field: 'carpetaAdministrativa', direction: 'ASC'},
                                                            groupField: 'carpetaAdministrativa',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='62';
                                        proxy.baseParams.listaCarpetas=gE('listaCarpetas').value;
                                        
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
                                                                            	type:'list',
                                                                                dataIndex:'etapaProcesal',
                                                                                options:arrEtapaProcesal,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'situacion',
                                                                                options:arrSituacionCarpeta,
                                                                                phpMode:true
                                                                            }
                                                            			]
                                                        }
                                                    );  
       
       
       var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}),
                                                            chkRow,
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val)
                                                                			{
                                                                            	return '<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(val)+'\')">'+val+'</a>';
                                                                            }
                                                            },
                                                            {
                                                                header:'Fecha de creaci&oacute;n',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	return val.format('d/m/Y H:i:s');
                                                                    }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n carpeta',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                	{
                                                                    	return formatearValorRenderer(arrSituacionCarpeta,val);
                                                                    }
                                                            }
                                                            
                                                        ]
                                                    );
        
        
        
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'dCarpetas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                sm:chkRow,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : true,      
                                                                plugins:	[filters],
                                                               
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


function recargarContenedorCentral()
{
	recargarGrid();
}

function recargarGrid()
{
	gEx('dCarpetas').getStore().reload();
}

function registrarRemisionCarpetaJudicial()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
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
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',307],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=51&cA='+carpetaAdministrativa,true);
}

function abrirPanelAdministracionCarpeta(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAdministracion.php';
    obj.params=[['cA',cA]];
    obj.titulo='Carpeta Judicial: '+bD(cA);
    abrirVentanaFancy(obj);
    
}