<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	
	$cAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
?>

var cAdministrativa='<?php echo $cAdministrativa?>';

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
                                                border:false,
                                                items:	[
                                                            crearGridResumenActuacion()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridResumenActuacion()
{

   var arrSituacionActual=[['1','En Espera de Atenci&oacute;n'],['2','Atendido/Cumplido'],['3','Vencido/Incumplido']];
   var lector= new Ext.data.JsonReader({
                                        
                                        totalProperty:'numReg',
                                        fields: [
                                                    {name:'idRegistro'},
                                                    {name: 'lblEtiquetaRegistro'},
                                                    {name:'fechaInicio', type:'date', dateFormat:'Y-m-d'},
                                                    {name: 'fechaMaximaAtencion',type:'date', dateFormat:'Y-m-d H:i:s'},
                                                    {name: 'situacionActual'},
                                                    {name: 'responsableAtencion'},
                                                    {name:'iFormulario'},
                                                    {name:'iRegistro'},
                                                    {name :'fechaAtencion',type:'date', dateFormat:'Y-m-d H:i:s'}
                                                ],
                                        root:'registros'
                                        
                                    }
                                  );
 
                                                                                  
var alDatos=new Ext.data.GroupingStore({
                                                        reader: lector,
                                                        proxy : new Ext.data.HttpProxy	(

                                                                                          {

                                                                                              url: '../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php'

                                                                                          }

                                                                                      ),
                                                        sortInfo: {field: 'fechaInicio', direction: 'ASC'},
                                                        groupField: 'fechaInicio',
                                                        remoteGroup:false,
                                                        remoteSort: false,
                                                        autoLoad:true
                                                        
                                                    }) 
alDatos.on('beforeload',function(proxy)
                                {
                                    proxy.baseParams.funcion='20';
                                    proxy.baseParams.cAdministrativa=cAdministrativa;
                                    proxy.baseParams.idFormulario=<?php echo $idFormulario?>;
                                    proxy.baseParams.idRegistro=<?php echo $idRegistro?>;
                                   
                                }
                    )   
   
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:60}),                                                        
                                                        {
                                                            header:'Actuaci&oacute;n',
                                                            width:430,
                                                            sortable:true,
                                                            dataIndex:'lblEtiquetaRegistro',
                                                            renderer:function(val,meta,registro)
                                                            			{
                                                                        
                                                                        	if(parseInt(registro.data.situacionActual)==2)
	                                                                        	return '<a href="javascript:abrirActuacion(\''+bE(registro.data.iFormulario)+'\',\''+bE(registro.data.iRegistro)+'\')">'+mostrarValorDescripcion(val)+'</a>'
                                                          					return val;
                                                                        }
                                                        },
                                                        {
                                                            header:'Fecha Inicio',
                                                            width:140,
                                                            sortable:true,
                                                            dataIndex:'fechaInicio',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val.format('d/m/Y');
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha L&iacute;mite de Atenci&oacute;n',
                                                            width:250,
                                                            sortable:true,
                                                            dataIndex:'fechaMaximaAtencion',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val.format('d/m/Y');
                                                                    }
                                                        },
                                                        {
                                                            header:'Responsable de Atenci&oacute;n',
                                                            width:350,
                                                            sortable:true,
                                                            dataIndex:'responsableAtencion',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'Situci&oacute;n Actual',
                                                            width:350,
                                                            sortable:true,
                                                            dataIndex:'situacionActual',
                                                            renderer:function(val,meta,registro)	
                                                            		{
                                                                    	
                                                                    	return formatearValorRenderer(arrSituacionActual,val);
                                                                    	
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de Atenci&oacute;n',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'fechaAtencion',
                                                            renderer:function(val,meta,registro)	
                                                            		{
                                                                    	if(val)
                                                                        	return val.format('d/m/Y H:i');
                                                                        return '------';
                                                                    }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridComentarios',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,
                                                            cls:'gridSiugjSeccion',
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


function abrirActuacion(iF,iR)
{
	 var obj={};    
      obj.ancho='100%';
      obj.alto='100%';
      obj.url='../modeloPerfiles/vistaDTDv3.php';
      obj.modal=true;
     
      obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['idReferencia',-1],
              ['dComp',bE('auto')],['actor',bE(0)]];
      window.parent.abrirVentanaFancy(obj);
}