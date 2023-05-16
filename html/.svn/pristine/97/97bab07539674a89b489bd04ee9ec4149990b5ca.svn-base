<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa";
	$arrStatusCarpeta=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT DISTINCT anio,anio FROM 7004_seriesUnidadesGestion WHERE tipoDelito='EJEC' ORDER BY anio ASC";
	$arrCiclosCarpeta=$con->obtenerFilasArreglo($consulta);
	$anio=date("Y");
?>
var arrCiclosCarpeta=<?php echo $arrCiclosCarpeta?>;
var anio='<?php echo $anio?>';
var arrStatusCarpeta=<?php echo $arrStatusCarpeta?>;

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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:12px"><b>Carpetas Ejecuci&oacute;n [Ajustes]</b></span>',
                                                items:	[
                                                            crearGridCarpetas()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridCarpetas()
{
	var arrCiclo=arrCiclosCarpeta;
	var cmbCiclo=crearComboExt('cmbCiclo',arrCiclo,0,0,110);
    cmbCiclo.setValue(anio);
    cmbCiclo.on('select',function()
    						{
                            	gEx('gridCarpetas').getStore().reload();
                            }
    			)
    var arrStatusRegistro=[['10,100,5,3','Cualquier situaci\xF3n'],['10,3','En registro'],['100,5','Actualizado']];
    var arrStatusRegistroRenderer=[['3','<img src="../images/control_pause.png"> En registro'],['10','<img src="../images/control_pause.png"> En registro'],['100','<img src="../images/accept_green.png"> Actualizado'],['5','<img src="../images/accept_green.png"> Actualizado (Autorizado por evaluador)']];
    var cmbStatusRegistro=crearComboExt('cmbStatusRegistro',arrStatusRegistro,0,0,300);
    cmbStatusRegistro.setValue('10,100,5,3');
    cmbStatusRegistro.on('select',function()
    						{
                            	gEx('gridCarpetas').getStore().reload();
                            }
    			)
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'carpetaEjecucion'},
		                                                {name:'idActividad'},
                                                        {name: 'situacionCarpeta'},
		                                                {name: 'idEstado'},
                                                       	{name: 'totalImputados'}
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
                                                            sortInfo: {field: 'carpetaEjecucion', direction: 'ASC'},
                                                            groupField: 'carpetaEjecucion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='165';
                                        proxy.baseParams.ciclo=gEx('cmbCiclo').getValue();
                                        proxy.baseParams.situacion=gEx('cmbStatusRegistro').getValue();
                                        proxy.baseParams.uG='<?php echo $_SESSION["codigoInstitucion"]?>';
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'Carpeta de Ejecuci&oacute;n',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'carpetaEjecucion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:mostrarDatosCarpeta(\''+bE(registro.data.idRegistro)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Total imputados',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'totalImputados'
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n carpeta',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'situacionCarpeta',
                                                                 renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrStatusCarpeta,val);
                                                                        }
                                                            }
                                                            
                                                            ,
                                                            {
                                                                header:'Situaci&oacute;n registro',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'idEstado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrStatusRegistroRenderer,parseInt(val)+'');
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCarpetas',
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
                                                                                html:'<b>Ciclo: </b>&nbsp;&nbsp;'
                                                                            },
                                                                            cmbCiclo,'-',
                                                                            {
                                                                            	xtype:'label',
                                                                                html:'<b>Mostrar registros en situaci&oacute;n: </b>&nbsp;&nbsp;'
                                                                            },
                                                                            cmbStatusRegistro
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

function mostrarDatosCarpeta(iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tblPenasImputados.php';
    obj.params=[['iR',bD(iR)]];
    if(window.parent)
    	window.parent.abrirVentanaFancy(obj);
    else
    	abrirVentanaFancy(obj);
}

function recargarContenedorCentral()
{
	gEx('gridCarpetas').getStore().reload();
}