<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
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
                                                            crearGridTramites()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridTramites()
{
   
   var lector= new Ext.data.JsonReader({
                                        
                                        totalProperty:'numReg',
                                        fields: [
                                                    {name:'idRegistro'},
                                                    {name:'actor'},
                                                    {name:'folio'},
                                                    {name: 'idFormulario'},
                                                    {name:'nombreTramite'},
                                                    {name:'categoriaTramite'},
                                                    {name:'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                    {name: 'situacion'},
                                                    {name:'fechaUltimoCambio', type:'date', dateFormat:'Y-m-d'},
                                                    {name: 'comentariosUltimoCambio'},
                                                    {name: 'responsableUltimoCambio'}
                                                ],
                                        root:'registros'
                                        
                                    }
                                  );
 
                                                                                  
var alDatos=new Ext.data.GroupingStore({
                                                        reader: lector,
                                                        proxy : new Ext.data.HttpProxy	(

                                                                                          {

                                                                                              url: '../paginasFunciones/funcionesModulosEspeciales_UGM_2.php'

                                                                                          }

                                                                                      ),
                                                        sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                        groupField: 'categoriaTramite',
                                                        remoteGroup:false,
                                                        remoteSort: false,
                                                        autoLoad:true
                                                        
                                                    }) 
alDatos.on('beforeload',function(proxy)
                                {
                                    proxy.baseParams.funcion='17';
                                    proxy.baseParams.idUsuario=gE('idUsuario').value;
                                    proxy.baseParams.idInstancia=gE('idInstancia').value;
                                }
                    )   
   
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        {
                                                            header:'',
                                                            width:25,
                                                            sortable:true,
                                                            dataIndex:'idRegistro',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return '<a href="javascript:window.parent.verRegistroProyecto(\''+bE(registro.data.idRegistro)+'\',\''+bE(registro.data.actor)+'\',\''+bE(registro.data.idFormulario)+'\')"><img src="../images/Icono_txt.gif" title="Abrir datos de tr&aacute;mite" alt="Abrir datos de tr&aacute;mite"></a>';
                                                                    }
                                                        },
                                                        {
                                                            header:'Folio',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'folio'
                                                        },
                                                        {
                                                            header:'Tr&aacute;mite',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'nombreTramite'
                                                        },
                                                        {
                                                            header:'Tipo tr&aacute;mite',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'categoriaTramite'
                                                        },
                                                        {
                                                            header:'Iniciado el',
                                                            width:110,
                                                            sortable:true,
                                                            dataIndex:'fechaRegistro',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val.format('d/m/Y');
                                                                    }
                                                        },
                                                        {
                                                            header:'Situaci&oacute;n actual',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'situacion'
                                                        },
                                                        {
                                                            header:'Fecha &uacute;ltima atenci&oacute;n',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'fechaUltimoCambio',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
	                                                                    	return val.format('d/m/Y');
                                                                    }
                                                        },
                                                        {
                                                            header:'Comentarios &uacute;ltima atenci&oacute;n',
                                                            width:450,
                                                            sortable:true,
                                                            renderer:mostrarValorDescripcion,
                                                            dataIndex:'comentariosUltimoCambio'
                                                        },
                                                        {
                                                            header:'Responsable &uacute;ltima atenci&oacute;n',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'responsableUltimoCambio'
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridTramites',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:true,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,
                                                            border:false,
                                                            frame:false,
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