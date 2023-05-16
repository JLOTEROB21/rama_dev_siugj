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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:12px"><b>Registro de penas</b></span>',
                                                items:	[
                                                            crearGridPenas()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridPenas()
{
	
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistroPena'},
                                                        {name:'idRegistroParticipante'},
                                                        {name:'idSentenciado'},
		                                                {name: 'nombreImputado'}
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
                                                            sortInfo: {field: 'nombreImputado', direction: 'ASC'},
                                                            groupField: 'nombreImputado',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='166';
                                        proxy.baseParams.idActividad=gE('idActividad').value;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'Sentenciado',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'nombreImputado'
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n registro penas',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'idRegistroPena',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        
                                                                        	if(val=='')
                                                                            	return '<a href="javascript:agregarPenasSentenciado(\''+bE(registro.data.idSentenciado)+'\')"><img src="../images/add.png"> Sin registro</a>';
                                                                           	else
                                                                            	return '<a href="javascript:modificarPenasSenetenciado(\''+bE(val)+'\')"><img src="../images/pencil.png"> Con registro</a>';
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridSentenciados',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:(parseInt(gE('idEstado').value)==100),
                                                                                text:'Registrar setenciado/penas',
                                                                                handler:function()
                                                                                        {
                                                                                        	var obj={};
                                                                                            obj.ancho='100%';
                                                                                            obj.alto='100%';
                                                                                            obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                            obj.params=[['dComp','YWdyZWdhcg=='],['actor','MzU5'],['idFormulario','405'],['idRegistro','-1'],['idReferencia',gE('idRegistro').value],['pComp',bE('{"esActualizacionCarpeta":"1"}')]];
                                                                                            obj.funcionCerrar=recargarContenedorCentral;
                                                                                            abrirVentanaFancy(obj);
                                                                                            
                                                                                        }
                                                                                
                                                                            },'-',
                                                                			{
                                                                                icon:'../images/cross.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:(parseInt(gE('idEstado').value)==100),
                                                                                text:'Remover sentenciado',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gridSentenciados').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar al sentenciado que desea remover de la carpeta');
                                                                                            	return;
                                                                                            }
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                            window.parent.recargarContenedorCentral();
                                                                                                            recargarContenedorCentral();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=168&idRegistro='+fila.data.idRegistroParticipante,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover al sentenciado seleccionado de la carpeta?',resp);
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/icon_big_tick.gif',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:(parseInt(gE('idEstado').value)==100),
                                                                                text:'Finalizar actualizaci&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                            window.parent.recargarContenedorCentral();
                                                                                                            window.parent.cerrarVentanaFancy();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=167&idRegistro='+gE('idRegistro').value,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer finalizar la actualizaci&oacute;n de la carpeta?',resp);
                                                                                        }
                                                                                
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


function recargarContenedorCentral()
{
	gEx('gridSentenciados').getStore().reload();
}

function agregarPenasSentenciado(s)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['dComp','YWdyZWdhcg=='],['actor','MzU5'],['idFormulario','405'],['idRegistro','-1'],['idReferencia',gE('idRegistro').value],['pComp',bE('{"esActualizacionCarpeta":"1","sentenciado":"'+bD(s)+'"}')]];
    obj.funcionCerrar=recargarContenedorCentral;
    abrirVentanaFancy(obj);	
}

function modificarPenasSenetenciado(s)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['dComp',bE('auto')],['actor',bE(762)],['idFormulario','405'],['idRegistro',bD(s)]];
    obj.funcionCerrar=recargarContenedorCentral;
    abrirVentanaFancy(obj);	
}