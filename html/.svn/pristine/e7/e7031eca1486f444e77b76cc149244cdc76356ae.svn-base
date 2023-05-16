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
                                                            crearGridDespachosAsociados()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridDespachosAsociados()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'codigoUnidad'},
		                                                {name: 'cveDespacho'},
		                                                {name:'nombreDespacho'},
                                                        {name:'objConfiguracion'},
                                                        {name: 'tipoUnidad'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'cveDespacho', direction: 'ASC'},
                                                            groupField: 'cveDespacho',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='20';
                                        proxy.baseParams.idGrupo=gE('idRegistro').value;
                                    }
                        )   


	var paginador=	new Ext.PagingToolbar	(
                                              {
                                                    pageSize: 1000,
                                                    store: alDatos,
                                                    displayInfo: true,
                                                    disabled:false
                                                }
                                             )     

       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:60}),
                                                            
                                                            {
                                                                header:'Cve. Del despacho',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'cveDespacho',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<a href="javascript:abrirInformacionDespacho(\''+bE(val)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre del despacho',
                                                                width:750,
                                                                sortable:true,
                                                                dataIndex:'nombreDespacho',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Tipo de unidad',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'tipoUnidad',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridDespachos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,
                                                                cls:'gridSiugjPrincipal',
                                                                bbar:[paginador],
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

function abrirInformacionDespacho(cveDespacho)
{
	var pos=obtenerPosFila(gEx('gridDespachos').getStore(),'cveDespacho',bD(cveDespacho));
    var fila=gEx('gridDespachos').getStore().getAt(pos);
    
    
    if(fila.data.objConfiguracion!='')
    {
        var objConf=eval('['+bD(fila.data.objConfiguracion)+']')[0];
        
        
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                var obj={};    
                obj.ancho='100%';
                obj.alto='100%';
                obj.modal=true;
                obj.url='../modeloPerfiles/vistaDTDv3.php';
                obj.params=[['idFormulario',arrResp[4]],['idRegistro',arrResp[1]],['idReferencia',-1],['dComp',arrResp[2]],['actor',bE(0)]];
                window.parent.abrirVentanaFancy(obj);
                ventanaAM.close();
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=71&p='+objConf.idProceso+
	                        '&r='+objConf.rolIngreso+'&u='+fila.data.codigoUnidad,true);
    }    
}