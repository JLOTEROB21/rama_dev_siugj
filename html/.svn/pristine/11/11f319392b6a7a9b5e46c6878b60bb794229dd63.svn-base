<?php session_start();
include("configurarIdiomaJS.php");
$idDocumento=bD($_GET["iD"]);
$consulta="select nombreFormulario,idFormulario from 900_formularios where idProceso=".$idDocumento." and formularioBase=1";
$filaFormulario=$con->obtenerPrimeraFila($consulta);
$nombreFormulario=$filaFormulario[0];
$idFormulario=$filaFormulario[1];
$consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
$arrSiNo=uEJ($con->obtenerFilasArreglo($consulta));


$consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
$arrSiNo=$con->obtenerFilasArreglo($consulta);


$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where idIdioma=".$_SESSION["leng"]." and situacion=1 order by nombreGrupo";
$arrRolesSistema=uEJ($con->obtenerFilasArreglo($consulta));


$consulta="SELECT idTipoProceso,tipoProceso FROM 921_tiposProceso where idTipoProceso not in (1,15) ORDER BY tipoProceso";
$arrTiposProcesos=$con->obtenerFilasArreglo($consulta);	

$consulta="select idTipoProceso,tipoProceso from 921_tiposProceso where idTipoProceso not in (select idTipoProceso from 921_tiposProceso where procesoNormal=0) order by tipoProceso";
$arrTiposProc=$con->obtenerFilasArreglo($consulta);	


?>
var posEscenarioActual=0;
var arrEtapas=[];
var arrRolesParticipantesProceso=[];
var arrRolesSistema=<?php echo $arrRolesSistema?>;
var arrSiNo=<?php echo $arrSiNo?>;
var arrTipoNotificaciones=[];
Ext.onReady(inicializar);
var nodoSel=null;
var nodoSelComite=null;
var nodoSelRol=null;
var idProceso;
var tProceso;
var recargarTab=true;
var recargarTabLita=true;
function inicializar()
{
	arrEtapas=eval(bD(gE('arrEtapas').value));
	idProceso=gE('idDocumento').value;
    var iP=idProceso;
    tProceso=gE('tProceso').value;
	Ext.QuickTips.init();
   	var arbol=	generarArbol(<?php echo $idDocumento?>);
    //var gridOtrasSeccion=crearGridOtrasSecciones(<?php echo $idDocumento?>);

    var arrPaneles=new Array();
    var nPanel=1;
    
    arrPaneles.push(	{
    						id:'tab'+nPanel, 
                            layout:'border',                            
                            title:nPanel+'.- Configuraci&oacute;n general',
                            items:	[			
                            			arbol
                            		]
                        }
                   );
    
    nPanel++;
  
    arrPaneles.push({id:'tab'+nPanel, layout:'border',title:nPanel+'.- Roles participantes',items:	[crearArbolRoles()]});
    nPanel++;
    arrPaneles.push(	{
    						id:'tab'+nPanel,
                            height:450,
                            title:nPanel+'.- Configuraci&oacute;n de notificaciones',
                            layout:'border',
                            listeners:	{
                                            activate:function(p)
                                                    {
                                                        
                                                        if(!p.activado)
                                                        {
                                                            p.activado=true;
                                                            gEx('gNotificaciones').getView().refresh();
                                                        }  
                                                    }
                                        },
                            items:	[
                            			crearGridNotificaciones()
                                     ]
                         }
                    );
    nPanel++;  
    
   	
    arrPaneles.push(	
    
    					{
                        	
                        	xtype:'panel',
                            border:false,
                            id:'panel_'+nPanel,
                            layout:'border',
                            title:nPanel+'.- Escenario del proceso',
                            listeners:	{
                            				activate:function(p)
                                            		{
                                                    	if(!p.activado)
                                                        {
                                                        	var arrId=p.id.split('_');
                                                            
                                                        	gEx('tab'+arrId[1]).load(
                                                                                        {
                                                                                            url:'../modeloPerfiles/configuracionEscenario.php',
                                                                                            params:	{
                                                                                                        idProceso:+iP,
                                                                                                        cPagina:'sFrm=true|gConfS=true',
                                                                                                        scripts:true
                                                                                                     }
                                                                                        }
                                                                                    )
                                                        	p.activado=true;
                                                        }
                                                    }
                            			},
                            items:	[
                            
                            			{
                                        	xtype:'panel',
                                            layout:'border',
                                            region:'center',
                                            cls:'panelSiugjWrap',
                                            items:	[
                                            			new Ext.ux.IFrameComponent({ 
                
                                                                                        id: 'tab'+nPanel, 
                                                                                        anchor:'100% 100%',
                                                                                        region:'center',
                                                                                        loadFuncion:function(iFrame)
                                                                                                    {
                                                                                                    	var arrId=iFrame.id.split('-');
                                                                                                        var extIframe=gEx(arrId[1]);
                                                                                                        extIframe.getFrameWindow().scrollTo(0,posEscenarioActual);
                                                                                                        
                                                                                                        
                                                                                                        
                                                                                                    },
                
                                                                                        url: '../paginasFunciones/white.php',
                                                                                        style: 'width:100%;height:100%' 
                                                                                })
                                            		]
                                            
                                        }
                            			
                                       
                                    ]
						}                                    
                   );
	nPanel++; 
    
    
    arrPaneles.push(crearGridHASHRegistro());
    nPanel++; 
    
    
     
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                cls:'panelSiugjWrap',
                                                layout:'border',
                                                title: bD(gE('tituloModulo').value),
                                                items:	[
                                                            {
                                                              id:'tabPanel',
                                                              xtype:'tabpanel',
                                                              activeTab: 0,
                                                              cls:'tabPanelSIUGJ',
                                                              region:'center',
                                                              padding:1,
                                                              items:arrPaneles	
                                                          }
                                                        ]
                                            }
                                         ]
                            }
                        )  

	nPanel--;
    var x;             
    for(x=0;x<nPanel;x++)
    {
    	 gEx('tabPanel').setActiveTab(x);
    }
     gEx('tabPanel').setActiveTab(0);
    
}

function crearGridHASHRegistro()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'nombreCampo'},
                                                        {name:'tipoDato'},
                                                        {name: 'esCampoDefault'},
                                                        {name: 'campoHash'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesProyectos.php'

                                                                                              }

                                                                                          ),
                                                            
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='362';
                                        proxy.baseParams.idProceso=gE('idDocumento').value;
                                        
                                    }
                        )   
       
       
	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: 'Considerar HASH',
													   dataIndex: 'campoHash',
													   width: 190
													}
												);
                                                       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:45}),
                                                        
                                                        {
                                                            header:'Campo de Formulario',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'nombreCampo',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var color='000';
                                                                        if(registro.data.esCampoDefault=='1')
                                                                        {
                                                                        	color='900';
                                                                        }
                                                                    	return '<span style="color:#'+color+'">'+val+'</span>';
                                                                    }
                                                        },
                                                        {
                                                            header:'Tipo de dato',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'tipoDato'
                                                        },
                                                        checkColumn
                                                        
                                                    ]
                                                );
                                                    
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gCamposTablero',
                                                            store:alDatos,
                                                            frame:false,
                                                            region:'center',
                                                           	border:false,
                                                            cls:'gridSiugjPrincipal',
                                                            cm: cModelo,
                                                            clicksToEdit:1,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            plugins:[checkColumn],
                                                            columnLines : false,                                                             
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



	var panel=new Ext.Panel (
                                {
                                    layout:'border',
                                    cls:'panelSiugj',
                                    title:'Campos HASH',
                                                            
                                    tbar: 	[
                                                {
                                                    xtype:'label',
                                                    html:'<div class="letraNombreTablero">Minutos de Diferencia (0 para ignorar):</div>'
                                                },
                                                {
                                                    xtype:'tbspacer',
                                                    width:10
                                                },
                                                {
                                                    xtype:'numberfield',
                                                    width:50,
                                                    id:'minutosDiferencia',
                                                    value:gE('hashDiferenciaTiempo').value,
                                                    cls:'controlSIUGJ',
                                                    allowDecimals:false,
                                                    allowNegative:false
                                                },
                                                {
                                                    xtype:'tbspacer',
                                                    width:10
                                                }
                                                ,
                                                {
                                                    icon:'../images/guardar.PNG',
                                                    cls:'x-btn-text-icon',
                                                    text:'Guardar',
                                                    handler:function()
                                                            {
                                                                var fila;
                                                                var x;
                                                                var arrRegistros='';
                                                                var o='';
                                                                for(x=0;x<gEx('gCamposTablero').getStore().getCount();x++)
                                                                {
                                                                    fila=gEx('gCamposTablero').getStore().getAt(x);
                                                                    
                                                                    if(fila.data.campoHash)
                                                                    {
                                                                        o='{"campo":"'+fila.data.nombreCampo+'"}';
                                                                        if(arrRegistros=='')
                                                                            arrRegistros=o;
                                                                        else  
                                                                            arrRegistros+=','+o;                                                                                          }
                                                                    
                                                                }
                                                                
                                                                
                                                                var cadObj='{"minutosDiferencia":"'+(gEx('minutosDiferencia').getValue()==''?'0':gEx('minutosDiferencia').getValue())+
                                                                            '","idProceso":"'+gE('idDocumento').value+'","arrRegistros":['+arrRegistros+']}';
                                                            
                                                                function funcAjax()
                                                                {
                                                                    var resp=peticion_http.responseText;
                                                                    arrResp=resp.split('|');
                                                                    if(arrResp[0]=='1')
                                                                    {
                                                                        msgBox('La Informaci&oacute;n ha sido almacenada correctamente');    
                                                                    }
                                                                    else
                                                                    {
                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                    }
                                                                }
                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=363&cadObj='+cadObj,true);
                                                            
                                                            }
                                                    
                                                }
                                            ],
                                    items:	[tblGrid]
                             	}
                             )

	return panel;
}
 
//Funcion para llenar treeview

var panelArbol;
var arbol=Ext.tree;

function cargarConfEscenario(idP)
{
    var iFrame=gE('frameDestino');
    iFrame.src='../modeloPerfiles/configuracionEscenario.php?idProceso='+idP+'&cPagina='+cv('sFrm=true');
}

function cargarConfEscenarioLita(idP)
{
    var iFrame=gE('frameDestinoLita');
    iFrame.src='../modeloPerfiles/configuracionEscenarioLita.php?idProceso='+idP+'&cPagina='+cv('sFrm=true');
}


function recargarArbolSecciones()
{
	gEx('arbolSecciones').getRootNode().reload();
}

function generarArbol(idPadre)
{
	var cmbOrden=crearComboExt('cmbOrden',[],0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
    var cmbSinoObligatorio=crearComboExt('cmbSinoObligatorio',arrSiNo,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
    var cmbEtapa=crearComboExt('cmbEtapa',arrEtapas,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid',anchoList:350});
	var cmbSinoEdicionForzada=crearComboExt('cmbSinoEdicionForzada',arrSiNo,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
    
    var idProceso=gE('idDocumento').value;

    var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'id'},
		                                                {name: 'text'},
		                                                {name:'orden'},
		                                                {name: 'tituloO'},
                                                        {name: 'tipo'},
                                                        {name:'obligatorio'},
                                                        {name:'idFormulario'},
                                                        {name: 'noEtapa'},
                                                        {name:'idFuncionVisualizacion'},
                                                        {name:'idFuncionEdicion'},
                                                        {name: 'lblFuncionVisualizacion'},
                                                        {name:'lblFuncionEdicion'},
                                                        {name: 'conf'},
                                                        {name: 'idModulo'},
                                                        {name: 'complementario'},
                                                        {name: 'edicionForzada'},
                                                        {name: 'requiereConfiguracion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(

                                                                                {

                                                                                    url: '../paginasFunciones/funcionesProyectos.php'

                                                                                }

                                                                            ),
                                              sortInfo: {field: 'orden', direction: 'ASC'},
                                              groupField: 'text',
                                              remoteGroup:false,
                                              remoteSort: true,
                                              autoLoad:true
                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='22';
                                        proxy.baseParams.idProyecto=idProceso;
                                    
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                       
                                                        {
                                                            header:'Formulario',
                                                            width:420,
                                                            dataIndex:'text',
                                                            editor:{xtype:'textfield',cls:'controlSIUGJ'},
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var icoWarning='';
                                                                    	if(registro.data.requiereConfiguracion=='1')
                                                                        {
                                                                        	icoWarning='<img src="../images/warning.png" title="Este m&oacute;dulo requiere ser configurado para su uso, para hacerlo seleccione el elemento y de click en la opci&oacute;n de modificar configuraci&oacute;n del m&oacute;dulos">&nbsp;';
                                                                        }
                                                                    
                                                                    	if(registro.data.id!='0')
                                                                        {
                                                                        	return '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+icoWarning+val;
                                                                        }
                                                                        
                                                                        return val;
                                                                    }
                                                        },
                                                        {
                                                            header:'Orden',
                                                            width:90,
                                                            align:'center',
                                                            sortable:false,
                                                            dataIndex:'orden',
                                                            editor:cmbOrden
                                                        },
                                                        {
                                                            header:'No. etapa',
                                                            width:110,
                                                            align:'center',
                                                            sortable:false,
                                                            editor:cmbEtapa,
                                                            dataIndex:'noEtapa',
                                                            renderer:function(val)
                                                            		{
                                                                    	return '<div title="'+formatearValorRenderer(arrEtapas,val)+'" alt="'+formatearValorRenderer(arrEtapas,val)+'">'+val+'</div>';
                                                                    }
                                                        },
                                                        {
                                                            header:'Obligatorio',
                                                            width:125,
                                                            align:'center',
                                                            editor:cmbSinoObligatorio,
                                                            dataIndex:'obligatorio',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.id=='0')
                                                                        	return '';
                                                                    	if(val=='1')
                                                                        {
                                                                        	return '<span style="color:#900">S&iacute;<span>';
                                                                        }
                                                                        else
                                                                        {
                                                                        	return '<span style="color:#030">No<span>';
                                                                        }
                                                                    }
                                                        },
                                                        {
                                                            header:'Funci&oacute;n de visualizaci&oacute;n',
                                                            width:435,
                                                            dataIndex:'lblFuncionVisualizacion',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.id=='0')
                                                                        	return '';
                                                                    	var btnDelete='';
                                                                        if((val!='')&&(val!='-1'))
                                                                    		btnDelete='<a href="javascript:removerFuncion(\''+bE(registro.data.id)+'\',1)"><img src="../images/cross.png" width="14" height="14" title="Remover funci&oacute;n" alt="Remover funci&oacute;n"></a>&nbsp;';

                                                                    	return btnDelete+'<a href="javascript:addFuncion(\''+bE(registro.data.id)+'\',1)"><img src="../images/pencil.png" width="14" height="14" title="Asignar funci&oacute;n" alt="Asignar funci&oacute;n"> '+mostrarValorDescripcion(val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Funci&oacute;n de edici&oacute;n',
                                                            width:435,
                                                            dataIndex:'lblFuncionEdicion',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.id=='0')
                                                                        	return '';
                                                                    	var btnDelete='';
                                                                        if((val!='')&&(val!='-1'))
                                                                    		btnDelete='<a href="javascript:removerFuncion(\''+bE(registro.data.id)+'\',2)"><img src="../images/cross.png" width="14" height="14" title="Remover funci&oacute;n" alt="Remover funci&oacute;n"></a>&nbsp;';

                                                                    	return btnDelete+'<a href="javascript:addFuncion(\''+bE(registro.data.id)+'\',2)"><img src="../images/pencil.png" width="14" height="14" title="Asignar funci&oacute;n" alt="Asignar funci&oacute;n"> '+mostrarValorDescripcion(val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Edici&oacute;n condicionada',
                                                            width:210,
                                                            align:'center',
                                                            editor:cmbSinoEdicionForzada,
                                                            dataIndex:'edicionForzada',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.lblFuncionEdicion=='')
                                                                        	return '------';
                                                                    	if(registro.data.id=='0')
                                                                        	return '';
                                                                    	if(val=='1')
                                                                        {
                                                                        	return '<span style="color:#900">S&iacute;<span>';
                                                                        }
                                                                        else
                                                                        {
                                                                        	return '<span style="color:#030">No<span>';
                                                                        }
                                                                    }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'arbolSecciones',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            cls:'gridSiugjPrincipal',

                                                            stripeRows :false,
                                                            loadMask:true,
                                                            clicksToEdit:2,
                                                            columnLines : true, 
                                                            sm: new Ext.grid.RowSelectionModel(),                                                                                                                       
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



	tblGrid.on('beforeedit',function(e)
    						{
                            
                            	if((e.record.data.id=='0')&&(e.field!='text'))
                                	e.cancel=true;
                            
                            	var arrEtapas=[];
                            	switch(e.field)
                                {
                                	case 'orden':
                                    	var x=0;
                                        var arrOpcion=[];
                                        for(x=0;x<e.grid.getStore().getCount()-1;x++)
                                        {
                                        	o=[(x+1),(x+1)];
                                            arrOpcion.push(o);
                                        }
                                        gEx('cmbOrden').getStore().loadData(arrOpcion);
                                    break;
                                    case 'obligatorio':
                                        
                                    
                                    break;
                                    case 'noEtapa':
                                    break;
                                    case 'edicionForzada':
                                    
                                    	if(e.record.data.lblFuncionEdicion=='')
                                        	e.cancel=true;
                                    
                                    break;
                                }
                            }
    		)


	tblGrid.on('afteredit',function(e)
    						{
                            
                            	
                            	var arrEtapas=[];
                            	switch(e.field)
                                {
	                                case  'text':
                                    	var cadObj='{"idProceso":"'+gE('idProceso').value+'","idFormulario":"'+e.record.data.idFormulario+'","etiqueta":"'+e.value+'"}';
                                        function funcAjax2()
                                        {
                                            var resp=peticion_http.responseText;
                                            arrResp=resp.split('|');
                                            if(arrResp[0]=='1')
                                            {
                                                gEx('arbolSecciones').getStore().reload();
                                            }
                                            else
                                            {
                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                            }
                                        }
                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax2, 'POST','funcion=367&cadObj='+cadObj,true);	
                                    break;
                                	case 'orden':
                                    	var cadObj='{"idProceso":"'+gE('idProceso').value+'","idElemento":"'+e.record.data.id+'","orden":"'+e.value+'"}';
                                        function funcAjax2()
                                        {
                                            var resp=peticion_http.responseText;
                                            arrResp=resp.split('|');
                                            if(arrResp[0]=='1')
                                            {
                                                gEx('arbolSecciones').getStore().reload();
                                            }
                                            else
                                            {
                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                            }
                                        }
                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax2, 'POST','funcion=342&cadObj='+cadObj,true);	
                                    	
                                    break;
                                    case 'obligatorio':
                                        function funcAjax()
                                        {
                                            var resp=peticion_http.responseText;
                                            arrResp=resp.split('|');
                                            if(arrResp[0]=='1')
                                            {
                                               
                                                
                                                
                                            }
                                            else
                                            {
                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                            }
                                        }
                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=36&idElemento='+e.record.data.id+'&obligatorio='+e.value,true);
                                        
                                    
                                    
                                    break;
                                    case 'noEtapa':
                                    	var cadObj='{"idElemento":"'+e.record.data.id+'","noEtapa":"'+e.value+'"}';
                                        function funcAjax()
                                        {
                                            var resp=peticion_http.responseText;
                                            arrResp=resp.split('|');
                                            if(arrResp[0]=='1')
                                            {
                                                
                                            }
                                            else
                                            {
                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                            }
                                        }
                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=341&cadObj='+cadObj,true);

                                    break;
                                    case 'edicionForzada':
                                        function funcAjax()
                                        {
                                            var resp=peticion_http.responseText;
                                            arrResp=resp.split('|');
                                            if(arrResp[0]=='1')
                                            {
                                               
                                                
                                                
                                            }
                                            else
                                            {
                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                            }
                                        }
                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=366&idElemento='+e.record.data.id+'&edicionForzada='+e.value,true);
                                        
                                    
                                    
                                    break;
                                }
                            }
    		)



	tblGrid.getSelectionModel().on('rowselect',function(sm,numFila,registro)
                                                {
                                                    if(registro.data.requiereConfiguracion=='1')
                                                    {
                                                        gEx('btnConfModulo').show();
                                                    }
                                                    else
                                                    {
                                                        gEx('btnConfModulo').hide();
                                                    }
                                                }
                                    )


	tblGrid.getSelectionModel().on('rowdeselect',function(sm,numFila,registro)
                                                {
                                                    
                                                    gEx('btnConfModulo').hide();
                                                    
                                                }
                                    )

	var panel=new Ext.Panel (
    						{
                            	region:'center',
                                layout:'border',
                                tbar:	[
                                            {
                                                text:'Agregar elemento',
                                                icon:'../images/add.png',
                                                cls:'x-btn-text-icon',
                                                handler:function()
                                                        {
                                                            agregarElemento();
                                                        }
                                            },
                                            {
                                                text:'Remover elemento',
                                                icon:'../images/delete.png',
                                                cls:'x-btn-text-icon',
                                                handler:function()
                                                        {
                                                            quitarElemento();
                                                        }
                                            },
                          					{
                                                id:'btnConfModulo',
                                                text:'Modificar configuraci&oacute;n del m&oacute;dulo',
                                                icon:'../images/cog.png',
                                                cls:'x-btn-text-icon',
                                                hidden:true,
                                                handler:function()
                                                        {
                                                        	var fila=tblGrid.getSelectionModel().getSelected();
															if(!fila)
                                                            {
                                                            	msgBox('Debe seleccionar el elemento cuya configuraci&oacute;n desea editar');
                                                            	return;
                                                            }                                                        
                                                            if((fila.data.conf)&&(fila.data.conf!=''))
                                                            {
                                                                var objConf={};
                                                                objConf.ancho='100%';
                                                                objConf.alto='100%';
                                                                objConf.url=fila.data.conf;
                                                                objConf.params=[['idFormularioProceso',fila.data.idFormulario],['idProceso',idProceso],['cPagina','sFrm=true']];
                                                                abrirVentanaFancy(objConf);
                                                            }
                                                            else
                                                            {
                                                                function funcAjax()
                                                                {
                                                                    var resp=peticion_http.responseText;
                                                                    arrResp=resp.split('|');
                                                                    if(arrResp[0]=='1')
                                                                    {
                                                                        var conf=null;
                                                                        var arrConf=eval(arrResp[1]);
                                                                        if(arrConf.length>0)
                                                                            conf=arrConf[0];
                                                                        mostrarVentanaConfiguracionModulo(conf);
                                                                    }
                                                                    else
                                                                    {
                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                    }
                                                                }
                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=323&idModulo='+fila.data.idModulo+'&idProceso='+gE('idProceso').value,true);					
                                                            }
    
                                                            
                                                        }
                                            }
                                            
                                            
                                           
                                        ],
                                items:	[
                                			tblGrid
                                		]
                            }
    					)
    return 	panel;
}

function removerFuncion(iElemento,tipo)
{
	var cadObj='{"iElemento":"'+bD(iElemento)+'","tipoElemento":"'+tipo+'"}';
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
                    var pos=obtenerPosFila(gEx('arbolSecciones').getStore(),'id',bD(iElemento));
                    var fila=gEx('arbolSecciones').getStore().getAt(pos);
                    
                    
                    var campo='';
                    switch(tipo)
                    {
                        case 1:
                            campo='lblFuncionVisualizacion';
                        break;
                        case 2:
                            campo='lblFuncionEdicion';
                        break;
                    }
                    
                    fila.set(campo,'');
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=310&cadObj='+cadObj,true);
        
     	}   
    }
    msgConfirm('¿Est&aacute; seguro de querer remover la funci&oacute;n de '+(tipo=='1'?'visualizaci&oacute;n':"edici&oacute;n")+'?',resp);

}


function addFuncion(iElemento,tipoFuncion)
{

	var pos=obtenerPosFila(gEx('arbolSecciones').getStore(),'id',bD(iElemento));
    var fila=gEx('arbolSecciones').getStore().getAt(pos);
    
    
    var campo='';
    var campoID='';
    switch(tipoFuncion)
    {
        case 1:
            campo='lblFuncionVisualizacion';
            campoID='idFuncionVisualizacion';
                                                       
        break;
        case 2:
            campo='lblFuncionEdicion';
            campoID='idFuncionEdicion';
        break;
    }
    
    

	asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre)
                                            {
                                            	var cadObj='{"iElemento":"'+bD(iElemento)+'","tipoElemento":"'+tipoFuncion+'","valor":"'+idConsulta+'"}';
                                                function funcAjax()
                                                {
                                                    var resp=peticion_http.responseText;
                                                    arrResp=resp.split('|');
                                                    if(arrResp[0]=='1')
                                                    {
                                                        fila.set(campo,nombre);
                                                        fila.set(campoID,idConsulta);
                                                        gEx('vAgregarExp').close();
                                                    }
                                                    else
                                                    {
                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                    }
                                                }
                                                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=311&cadObj='+cadObj,true);
                                                    
                                                
                                            
                                            	
                                                
                                            }
	mostrarVentanaExpresion(function(filaSel,ventana)
    						{
                                var cadObj='{"iElemento":"'+bD(iElemento)+'","tipoElemento":"'+tipoFuncion+'","valor":"'+filaSel.get('idConsulta')+'"}';
                                function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        fila.set(campo,filaSel.get('nombreConsulta'));
                                        fila.set(campoID,filaSel.get('idConsulta'));
                                        ventana.close();
                                    }
                                    else
                                    {
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=311&cadObj='+cadObj,true);
                                
                            }
    						,
    						true);
}



function agregarElemento()
{
	mostrarmenuAgregar();

}

function mostrarVentanaConfiguracionModulo(conf)
{
	
    switch(parseInt(nodoSel.attributes.idModulo))
    {
        
        case 12: //datos complementarios
        	mostrarVentanaConfDatosComplementarios();
        break;
        default:
        	if(parseInt(nodoSel.attributes.idModulo)<0)
	  	    	vConfigurarModuloProceso();
        break;
    }
    
    
}





function mostrarmenuAgregar()
{
	function generarFormAgregar()
	{
		var ctEstandares=0;
		var ctNoEstandares=0;
		var resp=eval(peticion_http.responseText)[0];
        var vModal;
        
		var raiz=new arbol.AsyncTreeNode(
                                            {
                                                id:'raiz',
                                                text:'',
                                                draggable:false,
                                                icon:"../images/s.gif",
                                                children:resp.modulos
                                            }
                                        )
                                        
		var raizNoEstandar=new arbol.AsyncTreeNode	(
                                                        {
                                                            id:'raizNoEstandar',
                                                            text:'',
                                                            draggable:false,
                                                            icon:"../images/s.gif",
                                                            children:resp.formularios
                                                        }
                                                    )
		
		var arbolElemStandard=new Ext.tree.TreePanel	(
															{
																id:'arbolAgregarE',
																title:'',
																rootVisible:false,
																lines:false,
                                                                height:300,
                                                                cls:'cssArbol',
																autoScroll:true,
																root: raiz
															}
														)
		var arbolElemNoEstandar=new Ext.tree.TreePanel	(
															{
																id:'arbolElemNoEstardar',
																title:'',
																rootVisible:false,
																lines:false,
                                                                height:300,
                                                                cls:'cssArbol',
																autoScroll:true,
																root: raizNoEstandar
															}
														)
	
	
		
		var tabs = new Ext.TabPanel	(
										{
											width:600,
                                            height:360,
                                            cls:'tabPanelSIUGJ',
											activeTab: 0,
											frame:false,
											border:false,
											items:	[
												
														{
															title:'M&oacute;dulos predefinidos',
                                                            id:'Modulos',
                                                            baseCls: 'x-plain',
                                                            items:
															[
																arbolElemStandard
															]
														},
                                                        {
															title:'Formularios del proceso',
                                                            id:'Formularios',
                                                            baseCls: 'x-plain',
                                                            items:
															[
																arbolElemNoEstandar
															]
														}
                                                        
														
											]
										}
									);
		
        
		var formulario=new Ext.FormPanel	(
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: [
																tabs,
                                                                {
                                                                	xtype:'label',
                                                                    x:10,
                                                                    y:360,
                                                                    cls:'SIUGJ_Etiqueta',
                                                                    html:'Si desea agregar un proceso de click <a href="javascript:agregarProceso()"> <font color="red"><b>AQU&Iacute;</b></font></a>'
                                                                }
															]
												}
											)
		var vModal=new Ext.Window	(
										{
                                        	id:'vAgregarElemento',
											title: '<?php echo $etj["lblTitAddNuevoElem"] ?>',
											width: 630,
											height:500,
											minWidth: 300,
											minHeight: 200,
											layout: 'fit',
											plain:true,
                                            cls:'msgHistorialSIUGJ',
											bodyStyle:'padding:5px;',
											buttonAlign:'center',
											modal:true,
											items:[formulario],
											buttons:	[
															{
																id:'btnCancelar',
																text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                cls:'btnSIUGJCancel',
	                                                            width:140,
																handler: 	function()
																			{
																				vModal.close();
																			}
															},
                                                            {
																id:'btnAgregar',
                                                                cls:'btnSIUGJ',
	                                                            width:140,
																text: '<?php echo $etj["lblBtnAceptar"] ?>',
																handler:	function()
																			{
                                                                                agregarElementosDTD(arbolElemStandard,arbolElemNoEstandar,vModal);
																			}
															}
														]
										}
									);
		vModal.show();
	}
	obtenerDatosWeb("../paginasFunciones/funcionesProyectos.php",generarFormAgregar,'POST','funcion=2&idProceso=<?php echo $idDocumento ?>',true);

}

function agregarElementosDTD(raizModulosP,raizFormProceso,vModal)
{
    var elementos='';
    var raiz=raizModulosP.getChecked();
    var raizNoEstandar=raizFormProceso.getChecked();
    for(x=0;x<raiz.length;x++)
    {
        objElemento='{"idModulo":"'+raiz[x].attributes.idModulo+'","tipo":"1","conf":"'+raiz[x].attributes.conf+'"}';
        if(elementos=='')
            elementos=objElemento;
        else
            elementos+=','+objElemento;
    }
    
    for(x=0;x<raizNoEstandar.length;x++)
    {
        objElemento='{"idFormulario":"'+raizNoEstandar[x].attributes.id+'", "tipo":"0"}';
        if(elementos=='')
            elementos=objElemento;
        else
            elementos+=','+objElemento;
    }
    var idProceso=gE('idDocumento').value;
    var obj='{"idProceso":"'+idProceso+'","elementos":['+elementos+']}';    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('arbolSecciones').getStore().reload();
            vModal.close();		
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=1&elementosDTD='+obj,true);
}


function quitarElemento()
{
	var arbolSecciones=gEx('arbolSecciones');
	var sModel=arbolSecciones.getSelectionModel();
	var nodo=sModel.getSelected();
	if(!nodo)
	{
		msgBox('Debe seleccionar el elemento que desea remover');
	}
	else
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
               		 	arbolSecciones.getStore().reload();
                    }
                    else
                    {
                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=14&idElemento='+nodo.data.id,true);
        	}
		}		 
        msgConfirm('Est&aacute; seguro de querer eliminar el elemento seleccionado?',resp);
	}
}

var rgIdiomas = Ext.data.Record.create	
(
	[
			{name: 'idioma'},
			{name: 'idIdioma'},
			{name: 'nombreDTD'},
			{name: 'descripcion'},
			{name: 'idDescripcion'}	
	  ]
 );

function llenarDatos(datos)
{
	
	for (x=0;x<datos.length;x++)
	{
		
		var FilaRegistro = new rgIdiomas(
                                            {
                                                    idioma:datos[x].imagen,
                                                    idIdioma: datos[x].idIdioma,
                                                    nombreDTD: datos[x].nombreDTD,
                                                    descripcion: datos[x].descripcion,
													idDescripcion: datos[x].idDescripcion

                                               }
                                          );
                                                  
        alNameDTD.add(FilaRegistro); 
	}
}

function cambiarColor(val)
{
	 return '<img src="../images/banderas/'+val+'" />';
}



Registro =Ext.data.Record.create	
(
	[
		{name:'id'},
		{name:'nombre'},
		{name:'descripcion'}
	]
)

function cargarDatos(origen)
{
	obtenerDatosWeb("../paginasFunciones/funcionesRevistaE.php",insertarDatos,'POST','funcion=4',true);
	function insertarDatos()
	{
		var DocXML=peticion_http.responseXML;
		var raiz=DocXML.getElementsByTagName("docXML");
		var nodos=raiz[0].childNodes;
		for(x=0;x<nodos.length;x++)
		{
			var n=nodos[x];
			var r=new Registro	(
									{
										id:n.childNodes[0].firstChild.nodeValue,
										nombre:n.childNodes[1].firstChild.nodeValue
									}
								);
			origen.add(r);
		}
	}
}

function eliminarDTD()
{
	Ext.Msg.confirm('<?php echo $etj["lblTitDelDTD"]?>','<?php echo $etj["lblMsgDelDTD"]?>',funcEliminarDTD);
	function funcEliminarDTD(btn)
	{
		if(btn=='yes')
		{
			
			function respEliminacion()
			{
				var resp=peticion_http.responseText;
				if(resp=='OK')
					window.location='tblDTD.php';
				else
				{
					msgBox('<?php echo $etj["lblErrorDel"]?> '+resp);
				
				}
			}
			obtenerDatosWeb("../paginasFunciones/guardarXML.php",respEliminacion,'POST','accion=5',true);
		}
	}
}


function crearArbolRoles()
{
	var idProceso=gE('idDocumento').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'42',
																	idProceso:idProceso
																},
													dataUrl:'../paginasFunciones/funcionesProyectos.php'
												}
											)	

	cargadorArbol.on('load',function(raiz,node)
    						{
                            	var x;
                                var nodo;
                                arrRolesParticipantesProceso=[['0','Actor de s\xF3lo lectura']];
                                for(x=0;x<node.childNodes.length;x++)
                                {
                                	nodo=node.childNodes[x];
                                    arrRolesParticipantesProceso.push([nodo.id,Ext.util.Format.stripTags(nodo.text)]);
                                }
                            	
                            }
    				)

    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'roles',
                                                      text:'Roles',
                                                      draggable:false,
                                                      expanded :true
                                                  }
                                            )

	var panelRol=new Ext.tree.TreePanel	(
                                              {
                                              	  id:'arbolRoles',
                                                  useArrows:true,
                                                  border:false,
                                                  autoScroll:true,
                                                  animate:false,
                                                  enableDD:true,
                                                  containerScroll:true,
                                                  region:'center',
                                                  root:raiz,
                                                  cls:'cssArbol',
                                                  rootVisible:false,
												  loader: cargadorArbol
                                                  
                                              }
                                          );                                                 	  

    panelRol.on('click',funcClikArbolRol);                                                 
    
    
    var panel= new Ext.Panel	(
                                {
                                    region:'center',
                                    border:false,
                                    layout:'border',
                                    cls:'panelSiugj',
                                    items:	[panelRol],
                                    tbar:	[
                                                {
                                                    id:'btnAgregarRol',
                                                    tooltip:'Agregar Rol',
                                                    icon:'../images/user_add.png',
                                                    cls:'x-btn-text-icon',
                                                    text:'Agregar Rol',
                                                    handler:function()
                                                            {
                                                                agregarRol();
                                                            }
                                                },
                                                {
                                                    width:10,
                                                    xtype:'tbspacer'
                                                },
                                                {
                                                    id:'btnRemoverRol',
                                                    tooltip:'Remover Rol',
                                                    icon:'../images/user_remove.png',
                                                    cls:'x-btn-text-icon',
                                                   	text:'Remover Rol',
                                                    handler:function()
                                                            {
                                                                removerRol();
                                                            }
                                                }
                                               
                                            ]
                                }
                            )
    
	return panel;						
}

function funcClikArbolRol(nodo, evento)
{
	nodoSelRol=nodo;
	
}

function agregarRol()
{
	<?php
		if(!existeRol("'1_0'"))
			$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where vistosAdmin=1 and idIdioma=".$_SESSION["leng"]." and situacion=1 order by nombreGrupo";
		else
			$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where idIdioma=".$_SESSION["leng"]." and situacion=1 order by nombreGrupo";
		$arrRoles=uEJ($con->obtenerFilasArreglo($consulta));
	?>
    var idProceso=gE('idDocumento').value;
    var arrRoles=<?php echo $arrRoles;?>;
    var cmbExtensiones=crearComboExt('cmbExtensiones',[],75,35,250);
	cmbExtensiones.hide();
	
    
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items:
													[
													 	{
                                                        	id:'lblRol',
                                                            x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            xtype:'label',
                                                            html:'Rol:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:15,
                                                            xtype:'label',
                                                            html:'<div id="divComboRol"></div>'
                                                            
                                                        },
                                                        {
                                                        	id:'lblExtension',
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            xtype:'label',
                                                            html:'Extensi&oacute;n:',
                                                            hidden:true
                                                        },
                                                        cmbExtensiones
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar rol',
										width:560,
										height:180,
                                        cls:'msgHistorialSIUGJ',
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																var cmbRoles=crearComboExt('cmbRoles',arrRoles,0,0,400,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboRol'});
                                                                function rolSeleccionado(combo,registro,indice)
                                                                {
                                                                    cmbExtensiones.reset();
                                                                    var idRegistro=registro.get('id');
                                                                    var arrId=idRegistro.split('_');
                                                                    if(arrId[1]!=0)
                                                                    {
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var arrExtensiones=eval(arrResp[1]);
                                                                                cmbExtensiones.getStore().loadData(arrExtensiones);                
                                                                                cmbExtensiones.show();
                                                                                Ext.getCmp('lblExtension').show();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&extension='+arrId[1],true);
                                                                    }
                                                                    else
                                                                    {
                                                                        cmbExtensiones.hide();
                                                                        Ext.getCmp('lblExtension').hide();
                                                                    }
                                                                    
                                                                }
                                                                
                                                                cmbRoles.on('select',rolSeleccionado);
                                                                cmbRoles.focus(false,500);
															}
												}
											},
										buttons:
												[
                                                	
													{
														text:'Cancelar',
                                                        cls:'btnSIUGJCancel',
                                                        width:140,
														handler:function ()
															{
																ventana.close();
															}
													},
												 	{
														text:'Aceptar',
                                                        cls:'btnSIUGJ',
                                                        width:140,
														handler:function ()
															{
                                                            	var cmbRoles=gEx('cmbRoles');
                                                                var cmbExtensiones=gEx('cmbExtensiones');
                                                            	var rol=cmbRoles.getValue();
                                                                var arrId=rol.split('_');
                                                                var extension='0';
                                                                if(arrId[1]!=0)
                                                                	extension=cmbExtensiones.getValue();	
                                                                if(extension=='')
                                                                {
                                                                	function resp()
                                                                    {
                                                                    	cmbExtensiones.focus();
                                                                    }
                                                                	msgBox('Debe seleccionar una extensi&oacute;n del rol',resp);
                                                                    return;
                                                                }
                                                                
                                                                var codigoRolN=arrId[0]+'_'+extension;
                                                                
                                                                var rolPanel=gEx('arbolRoles');
                                                                var nodoRol=rolPanel.getNodeById(codigoRolN);
                                                                if(nodoRol!=null)
                                                                {
                                                                	ventana.close();
                                                                    return;
                                                                }
                                                                function funcAjax()
                                                                {
                                                                    var resp=peticion_http.responseText;
                                                                    arrResp=resp.split('|');
                                                                    if(arrResp[0]=='1')
                                                                    {
                                                                    	rolPanel.getRootNode().reload();
                                                                        ventana.close();
                                                                    }
                                                                    else
                                                                    {
                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                    }
                                                                }
                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=43&idProceso='+idProceso+'&rol='+codigoRolN,true);
                                                                
																
															}
													}
												 ]
									}
							   )
	ventana.show();
}

function removerRol()
{
	 var idProceso=gE('idDocumento').value;
	if(nodoSelRol==null)
    {
    	msgBox('Debe seleccionar el rol a remover');
        return;
    }
    
    function resp(btn)
    {
    	if(btn=='yes')
        {
        	var rol=nodoSelRol.id;
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    nodoSelRol.remove();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=44&idProceso='+idProceso+'&rol='+rol,true);
        
        }
    }
    msgConfirm('Esta seguro de querer remover el rol seleccionado?',resp);
}

function redimensionarIframe(iFrame)
{
    iFrame.height='110%';
    if(Ext.isGecko)
    	var the_height=iFrame.contentWindow.innerHeight+iFrame.contentWindow.scrollMaxY+30;
    else
    	var the_height=iFrame.contentWindow.document.body.scrollHeight;
    
    iFrame.scrolling='no';
    var tabPanel= Ext.getCmp('tabPanel');
    if(tabPanel!=null)
    {
        if(the_height>530)
            tabPanel.setHeight(the_height+20);
        else
            tabPanel.setHeight(530);
    }
}

function actualizaPrefijo(ctrl)
{
	var idProceso=gE('idDocumento').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=212&accion=1&idProceso='+idProceso+'&valor='+cv(ctrl.value),true);

}

function actualizaSeparador(ctrl)
{
	var idProceso=gE('idDocumento').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=212&accion=2&idProceso='+idProceso+'&valor='+cv(ctrl.value),true);
}

function recargarTabEscenario()
{
	var tab5=Ext.getCmp('tab5');
    var iP=idProceso;
    tab5.load({url:'../modeloPerfiles/configuracionEscenario.php',params:{idProceso:+iP,cPagina:'sFrm=true|gConfS=true',scripts:true}});
}

function topePresChange(combo)
{
	var idTope=combo.options[combo.selectedIndex].value;
    if(idTope==4)
    	mE('filaTopePorc');
    else
    {
    	oE('filaTopePorc');
        gE('margenCre').value='';
    }
}


function recargarEscenarioLita()
{
	var iP=gE('idProceso').value;
	Ext.getCmp('tab6').load({url:'../procesoPOA/configuracionEscenarioLitaPOA.php',params:{idProceso:+iP,cPagina:'sFrm=true|gConfS=true',scripts:true}});

}

function generarArbolPartipantes()
{
	var idProceso=gE('idDocumento').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'167',
																	idProyecto:idProceso
																},
													dataUrl:'../paginasFunciones/funcionesProyectos.php'
												}
											)	

    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'participantes',
                                                      text:'Participantes',
                                                      draggable:false,
                                                      expanded :true
                                                  }
                                            )

	

	panelArbol=new Ext.tree.TreePanel	(
                                              {
                                              	  id:'arbolParticipantes',
                                                  el:'tblParticipantesAccion',
                                                  useArrows:true,
                                                  autoScroll:true,
                                                  animate:false,
                                                  enableDD:true,
                                                  containerScroll:true,
                                                  height:280,
												  width:520,
                                                  root:raiz,
                                                  rootVisible:false,
												  loader: cargadorArbol,
                                                  tbar:	[
                                                  			{
                                                            	id:'btnAgregarParticipante',
                                                            	tooltip:'Agregar Participante a la etapa seleccionada',
                                                                icon:'../images/user_add.png',
																cls:'x-btn-text-icon',
                                                                disabled:true,
                                                                handler:function()
                                                                        {
                                                                        	agregarParticipante();
                                                                        }
                                                            },'-',
                                                            {
																id:'btnAgregarCEDTDPart',
                                                            	tooltip:'Agregar Elemento al participante seleccionado',
                                                                icon:'../images/brick_add.jpg',
																cls:'x-btn-text-icon',
                                                                disabled:true,
                                                                handler:function()
                                                                        {
                                                                        	agregarCElementoDTDParticipante();
                                                                        }
                                                            },'-',
                                                            {
																id:'btnAgregarAccion',
                                                            	tooltip:'Agregar una acci&oacute;n al participante seleccionado',
                                                                icon:'../images/lightning_add.png',
																cls:'x-btn-text-icon',
                                                                disabled:true,
                                                                handler:function()
                                                                        {
																			agregarAccionParticipante();
                                                                        }
                                                            },'-',
                                                            {
																id:'btnRemoverParticipante',
                                                            	tooltip:'Remover elemento seleccionado',
                                                                icon:'../images/delete.png',
																cls:'x-btn-text-icon',
																disabled:true,
                                                                handler:function()
                                                                        {
                                                                        	removerParticipante();
                                                                        }
                                                            },
															'-',
															
															{
																id:'btnCambiarElementoParticipante',	
																text:'Cambiar funci&oacute;n sobre el Elemento a:',
																hidden:true,
																cls:'x-btn-text-icon',
																icon:'../images/update_nw.gif',
																menu:	[
																			{
																				text:'S&oacute;lo Ver',
																				handler:function()
																						{
																							cambiarFuncionesParticipante('0');
																						}
																			},
																			{
																				text:'Ver y modificar',
																				handler:function()
																						{
																							cambiarFuncionesParticipante('1');
																						}
																			}		
																		]
															},'-',
                                                            {
																id:'btnModifEnvioEtapa',
                                                                text:'Modificar env&iacute;o de etapa',
                                                            	tooltip:'Modificar env&iacute;o de etapa',
                                                                icon:'../images/pencil.png',
																cls:'x-btn-text-icon',
																hidden:true,
                                                                handler:function()
                                                                        {
                                                                        	modificarPasoEtapaParticipante();
                                                                        }
                                                            }
                                                           
                                                  		]
                                              }
                                          );                                                 	  
    panelArbol.render();
    panelArbol.expandAll();
    panelArbol.on('click',funcClikArbolParticipantes);
}

function funcClikArbolParticipantes(nodo, evento)
{
	nodoSelParticipante=nodo;
	Ext.getCmp('btnRemoverParticipante').enable();
    switch(nodoSelParticipante.attributes.tipo)
    {
    	case '0':
            Ext.getCmp('btnAgregarParticipante').disable();
            Ext.getCmp('btnAgregarCEDTDPart').disable();
            Ext.getCmp('btnAgregarAccion').disable();
            Ext.getCmp('btnCambiarElementoParticipante').show();
        break;
        case '1':
            Ext.getCmp('btnCambiarElementoParticipante').hide();
            Ext.getCmp('btnAgregarCEDTDPart').disable();
            Ext.getCmp('btnAgregarAccion').disable();
            Ext.getCmp('btnRemoverParticipante').enable();
            Ext.getCmp('btnAgregarParticipante').disable();
        break;
        case '2':
        	Ext.getCmp('btnAgregarParticipante').enable();
            Ext.getCmp('btnAgregarCEDTDPart').disable();
            Ext.getCmp('btnAgregarAccion').disable();
            Ext.getCmp('btnRemoverParticipante').disable();
            Ext.getCmp('btnCambiarElementoParticipante').hide();
        break;
        case '3':
        	Ext.getCmp('btnAgregarParticipante').disable();
            Ext.getCmp('btnAgregarAccion').disable();
            Ext.getCmp('btnAgregarCEDTDPart').enable();
            Ext.getCmp('btnRemoverParticipante').disable();
            Ext.getCmp('btnCambiarElementoParticipante').hide();
        break;
         case '4':
        	Ext.getCmp('btnAgregarParticipante').disable();
            Ext.getCmp('btnAgregarCEDTDPart').disable();
            Ext.getCmp('btnRemoverParticipante').disable();
            Ext.getCmp('btnAgregarAccion').enable();
            Ext.getCmp('btnCambiarElementoParticipante').hide();
        break;
        case '5':
        	Ext.getCmp('btnAgregarParticipante').disable();
            Ext.getCmp('btnAgregarCEDTDPart').disable();
            Ext.getCmp('btnRemoverParticipante').enable();
            Ext.getCmp('btnAgregarAccion').disable();
            Ext.getCmp('btnCambiarElementoParticipante').hide();
        break;
    }
    
    if(nodoSelParticipante.attributes.modifEtapa!=undefined)
    	gEx('btnModifEnvioEtapa').show();
    else
    	gEx('btnModifEnvioEtapa').hide();
}


function agregarRolModulo()
{

	<?php
		$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where  idIdioma=".$_SESSION["leng"]." order by nombreGrupo";
		$arrRoles=uEJ($con->obtenerFilasArreglo($consulta));
	?>
    var arrRoles=<?php echo $arrRoles;?>;
    var cmbExtensiones=crearComboExt('cmbExtensiones',[],100,35,250);
	cmbExtensiones.hide();
	var cmbRoles=crearComboExt('cmbRoles',arrRoles,100,5,360);
    function rolSeleccionado(combo,registro,indice)
    {
    	cmbExtensiones.reset();
    	var idRegistro=registro.get('id');
        var arrId=idRegistro.split('_');
        if(arrId[1]!=0)
        {
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
					var arrExtensiones=eval(arrResp[1]);
                    cmbExtensiones.getStore().loadData(arrExtensiones);     
                    
                	cmbExtensiones.show();
		            Ext.getCmp('lblExtension').show();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&noTodos=true&extension='+arrId[1],true);
        
        	
        }
        else
        {
        	cmbExtensiones.hide();
            Ext.getCmp('lblExtension').hide();
        }
        
    }
    
    cmbRoles.on('select',rolSeleccionado);
    
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items:
													[
													 	{
                                                        	id:'lblRol',
                                                            x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Rol:'
                                                        },
                                                        cmbRoles,
                                                        {
                                                        	id:'lblExtension',
                                                        	x:10,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'Extensi&oacute;n:',
                                                            hidden:true
                                                        },
                                                        cmbExtensiones
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar rol',
										width:480,
										height:150,
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
                                                            	var rol=cmbRoles.getValue();
                                                                var arrId=rol.split('_');
                                                                var extension='0';
                                                                if(arrId[1]!=0)
                                                                	extension=cmbExtensiones.getValue();	
                                                                if(extension=='')
                                                                {
                                                                	function resp()
                                                                    {
                                                                    	cmbExtensiones.focus();
                                                                    }
                                                                	msgBox('Debe seleccionar una extensi&oacute;n del rol',resp);
                                                                    return;
                                                                }
                                                                var listRoles=gE('listRoles');
                                                                var codigoRol=arrId[0]+'_'+extension;
                                                                var rolExiste=existeRol('listRoles',codigoRol);
                                                                
                                                                if(!rolExiste)
                                                                {
                                                                	
                                                                	var option=document.createElement('option');
                                                                    option.value=codigoRol;
                                                                    var nExtension=cmbExtensiones.getValue();
                                                                    var txtExtension='';
                                                                    if(nExtension!='')
                                                                    {
                                                                    	txtExtension=' ('+cmbExtensiones.getRawValue()+')';
                                                                    }
                                                                    option.text=cmbRoles.getRawValue()+txtExtension;
                                                                    listRoles.options[listRoles.options.length]=option;
                                                                }
                                                                else
                                                                {
                                                                	msgBox('El rol seleccionado ya ha sido agregado previamente')
                                                                    return;
                                                                }
                                                                
                                                                ventana.close();
																
															}
													},
													{
														text:'Cancelar',
														handler:function ()
															{
																ventana.close();
															}
													}
												 ]
									}
							   )
	ventana.show();

}

function existeRol(idCombo,valor)
{
	var combo=gE(idCombo);
    var x;
    for(x=0;x<combo.options.length;x++)
    {
    	if(combo.options[x].value==valor)
        	return true;
    }
    return false;
}

function removerRolModulo()
{
	var cmbRoles=gE('listRoles');
	var rol=cmbRoles.selectedIndex;
	if(rol==-1)
	{
		msgBox('Debe elegir el rol a remover');
        return;
	}
    
    function resp(btn)
    {
    	if(btn=='yes')
        	cmbRoles[cmbRoles.selectedIndex]=null;
    }
   msgConfirm('Est&aacute; seguro de querer remover este rol',resp);
    
    
}

function mostrarFormulario(idFormulario)
{
	var arrDatos=[['oCamposComp','1'],['idFormulario',bD(idFormulario)],['cPagina','mR1=false|mI=false']];
	window.open('',"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
    enviarFormularioDatosV('../modeloPerfiles/formularios.php',arrDatos,'POST','vAuxiliar');

}


var arrElementos;

function abrirEscenarioActor()
{
	var obj={};
    obj.url='../procesos/tblEscenarioActor.php';
    obj.title='Perfiles de escenarios';
    obj.params=[['idProceso',gE('idDocumento').value]];
    obj.ancho='90%';
    obj.alto='95%'
    abrirVentanaFancy(obj);
    
}

function crearGridNotificaciones(e)
{
	   var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idNotificacion'},
		                                                {name: 'tituloNotificacion'},
		                                                {name:'descripcion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesFormulario.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'tituloNotificacion', direction: 'ASC'},
                                                            groupField: 'tituloNotificacion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='232';
                                        proxy.baseParams.idProceso=idProceso;
                                       
                                    }
                        )   
    
    
    alDatos.on('load',function(proxy,registros)
    								{
                                    	arrTipoNotificaciones=[];
                                        var x;
                                        var fila;
                                        for(x=0;x<registros.length;x++)
                                        {
                                        	fila=registros[x];
                                            arrTipoNotificaciones.push([fila.data.idNotificacion,fila.data.tituloNotificacion]);
                                        }
                                        
                                        if(gEx('gConfiguracionNotificaciones'))
                                        {
                                        	gEx('gConfiguracionNotificaciones').getStore().reload();
                                        }
                                       
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:45}),
                                                        
                                                        {
                                                            header:'T&iacute;tulo notificaci&oacute;n',
                                                            width:500,
                                                            sortable:true,
                                                            dataIndex:'tituloNotificacion',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'Descripci&oacute;n',
                                                            width:450,
                                                            sortable:true,
                                                            dataIndex:'descripcion',
                                                            renderer:mostrarValorDescripcion
                                                        }
                                                    ]
                                                );
                                                    
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gNotificaciones',
                                                            store:alDatos,
                                                            border:false,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
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


	var panel=new Ext.Panel (
    						{
                            	region:'center',
                                layout:'border',
                                cls:'panelSiugj',
                                tbar:	[
                                            {
                                                icon:'../images/add.png',
                                                cls:'x-btn-text-icon',
                                                text:'Crear notificaci&oacute;n',
                                                handler:function()
                                                        {
                                                            var obj={};
                                                            obj.ancho='100%';
                                                            obj.alto='100%';
                                                            obj.titulo='Crear notificaci&oacute;n';
                                                            obj.url='../modeloPerfiles/notificacionProceso.php';
                                                            obj.modal=true;
                                                            obj.params=[['idNotificacion','-1'],['cPagina','sFrm=true'],['idProceso',idProceso]];
                                                            abrirVentanaFancy(obj);
                                                            
                                                            
                                                        }
                                                
                                            },
                                            {
                                                xtype:'tbspacer',
                                                width:10
                                            },
                                            {
                                                icon:'../images/pencil.png',
                                                cls:'x-btn-text-icon',
                                                text:'Modificar notificaci&oacute;n',
                                                handler:function()
                                                        {
                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                            
                                                            if(!fila)
                                                            {
                                                                msgBox('Debe seleccionar la notificaci&oacute;n que desea modificar');
                                                                return;
                                                            }
                                                            
                                                            var obj={};
                                                            obj.ancho='100%';
                                                            obj.alto='100%';
                                                            obj.modal=true;
                                                            obj.titulo='Modificar notificaci&oacute;n';
                                                            obj.url='../modeloPerfiles/notificacionProceso.php';
                                                            obj.params=[['idNotificacion',fila.data.idNotificacion],['cPagina','sFrm=true'],['idProceso',idProceso]];
                                                            abrirVentanaFancy(obj);
                                                            
                                                        }
                                                
                                            },
                                            {
                                                xtype:'tbspacer',
                                                width:10
                                            },
                                            {
                                                icon:'../images/delete.png',
                                                cls:'x-btn-text-icon',
                                                text:'Remover notificaci&oacute;n',
                                                handler:function()
                                                        {
                                                            var fila=tblGrid.getSelectionModel().getSelected();
                                                            
                                                            if(!fila)
                                                            {
                                                                msgBox('Debe seleccionar la notificaci&oacute;n que desea remover');
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
                                                                            
                                                                            gEx('gNotificaciones').getStore().reload();
                                                                        }
                                                                        else
                                                                        {
                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                        }
                                                                    }
                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=238&idNotificacion='+fila.data.idNotificacion,true);
                                                                }
                                                            }
                                                            msgConfirm('¿Est&aacute; seguro de querer remover la notificaci&oacute;n seleccionada?',resp);
                                                            
                                                            
                                                        }
                                                
                                            }
                                            
                                        ],
                                items:	[tblGrid]
                            }
    					)

    return 	panel;	
}


function recargarGridNotificaciones()
{
	gEx('gNotificaciones').getStore().reload();
}


function agregarProceso()
{
	gEx('vAgregarElemento').close();
	var arrTipoProceso=<?php echo $arrTiposProc ?>;
    
    
    
    var form = new Ext.form.FormPanel(	
										
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo de proceso:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:10,
                                                        	html:'<div id="cmbComboTipoProceso"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:65,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Proceso:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:60,
                                                        	html:'<div id="cmbComboProceso"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:115,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Etapa:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:110,
                                                        	html:'<div id="cmbComboEtapa"></div>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar proceso',
										width: 760,
										height:270,
                                        cls:'msgHistorialSIUGJ',
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	var cmbTipoProceso=crearComboExt('cmbTipoProceso',arrTipoProceso,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'cmbComboTipoProceso'});

                                                                    cmbTipoProceso.on('select',buscarProceso);
                                                                    var cmbProceso=crearComboExt('cmbProceso',[],0,0,550,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'cmbComboProceso'});
                                                                    var cmbEtapa=crearComboExt('cmbEtapa',arrEtapas,0,0,550,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'cmbComboEtapa'});
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var idProceso=gE('idProceso').value;
                                                                        var cmbTipoProceso=gEx('cmbTipoProceso');
                                                                        var cmbProceso=gEx('cmbProceso');
                                                                        var cmbEtapa=gEx('cmbEtapa');
                                                                        
																		if(cmbTipoProceso.getValue()=='')
                                                                        {
                                                                        	function respTipoProc()
                                                                            {
                                                                            	cmbTipoProceso.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el tipo de proceso a agregar como parte del DTD',respTipoProd);
                                                                        }
                                                                        if(cmbProceso.getValue()=='')
                                                                        {
                                                                        	function respProc()
                                                                            {
                                                                            	cmbProceso.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el proceso a agregar como parte del DTD',respProd);
                                                                        }
                                                                        if(cmbEtapa.getValue()=='')
                                                                        {
                                                                        	function respEtapa()
                                                                            {
                                                                            	cmbEtapa.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la etapa en la cual se agregar&aacute; el proceso como parte del DTD',respEtapa);
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('arbolSecciones').getStore().reload();
                																ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=176&idProcesoP='+idProceso+'&idProcesoV='+cmbProceso.getValue()+'&nEtapa='+cmbEtapa.getValue(),true);

                                                                    
                                                                    	
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
	
}

function buscarProceso(combo,registro,indice)
{
	var idTipoProceso=registro.get('id');
    var idProceso=gE('idProceso').value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var cmbProceso=Ext.getCmp('cmbProceso');
            cmbProceso.reset();
            var arrProcesos=eval(arrResp[1]);
       		cmbProceso.getStore().loadData(arrProcesos);   
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=175&idTipoProceso='+idTipoProceso+'&idProceso='+idProceso,true);
}

