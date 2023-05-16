<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$arrRoles=array();
	$idProceso=bD($_GET["iP"]);
	$consulta="SELECT rol FROM 943_rolesActoresProceso WHERE idProceso=".$idProceso;
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$arrRoles[obtenerTituloRol($fila[0])]=$fila[0];
		
	}
	ksort($arrRoles);
	$cadRoles="";
	if(sizeof($arrRoles)>0)
	{
		foreach($arrRoles as $nombreRol=>$rol)
		{
			$o="['".$rol."','".$nombreRol."']";	
			if($cadRoles=="")
				$cadRoles=$o;
			else
				$cadRoles.=",".$o;
		}	
	}
	$cadRoles='['.$cadRoles.']';
	$arrComites=array();
	$consulta="SELECT idComite FROM 235_proyectosVSComites WHERE idProyecto=".$idProceso;
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$arrComites[obtenerNombreComite($fila[0])]=$fila[0];
		
	}

	ksort($arrComites);
	$cadComites="";
	if(sizeof($arrComites)>0)
	{
		foreach($arrComites as $nombreComite=>$idComite)
		{
			$o="['".$idComite."','".$nombreComite."']";	
			if($cadComites=="")
				$cadComites=$o;
			else
				$cadComites.=",".$o;
		}	
	}
	$cadComites='['.$cadComites.']';
	
	
	$consulta="select nombreFormulario,idFormulario from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
	$filaFormulario=$con->obtenerPrimeraFila($consulta);
	$nombreFormulario=$filaFormulario[0];
	$idFormulario=$filaFormulario[1];

	$consulta="SELECT numEtapa,numEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." ORDER BY numEtapa";	
	$arrEtapas=$con->obtenerFilasArreglo($consulta);
	
	
	
	$consulta="select idTipoProceso,tipoProceso from 921_tiposProceso where idTipoProceso not in (select idTipoProceso from 921_tiposProceso where procesoNormal=0) order by tipoProceso";
	$arrTiposProc=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT numEtapa, nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." order by numEtapa";
	$resEt=$con->obtenerFilas($consulta);
	$arrObj="";
	while($filaEt=mysql_fetch_row($resEt))
	{
		$obj="['".$filaEt[0]."','".removerCerosDerecha($filaEt[0]).".- ".$filaEt[1]."']";
		if($arrObj=="")
			$arrObj=$obj;
		else
			$arrObj.=",".$obj;
	}
	$arrEt="[".uEJ($arrObj)."]";
	
?>

var aRoles=<?php echo $cadRoles ?>;
var aComites=<?php echo $cadComites ?>;
var arrEtapas=<?php echo $arrEtapas?>;
var arrNumElementos=[];

Ext.onReady(inicializar);

function inicializar()
{
	var cmbTipoActor=crearComboExt('cmbTipoActor',[['1','Rol'],['2','Comit\xE9']],0,0,130);//
    cmbTipoActor.setValue('1');
	cmbTipoActor.on('select',function(cmb,registro)
    						{
                            	gEx('cmbActorEscenario').reset();
                            	switch(registro.data.id)
                                {
                                	case '1':
                                    	gEx('cmbActorEscenario').getStore().loadData(aRoles);
                                        if(aRoles.length>0)
                                        	cmbActor.setValue(aRoles[0][0]);
                                    break;
                                    case '2':
                                    	gEx('cmbActorEscenario').getStore().loadData(aComites);
                                         if(aComites.length>0)
                                        	cmbActor.setValue(aComites[0][0]);
                                    break;
                                }
                               dispararEventoSelectCombo('cmbActorEscenario',true);
                            }
    				)
    var cmbActor=crearComboExt('cmbActorEscenario',aRoles,0,0,300);
    if(aRoles.length>0)
	    cmbActor.setValue(aRoles[0][0]);
    cmbActor.on('select',function(cmb,registro)
    					{
                     			gEx('arbolSecciones').getRootNode().reload();
                                gEx('gridOtrasSecciones').getStore().reload();
                                
                                
                               	if(gE('iframe-frameContenido'))
                               	{
                                    gEx('frameContenido').load	(
                                                                  {
                                                                      url:'../procesos/configuracionEscenarioActor.php',
                                                                      scripts:true,
                                                                      params:	{
                                                                                    cPagina:'sFrm=true',
                                                                                    idProceso:gE('idProceso').value,
                                                                                    tipoActor:gEx('cmbTipoActor').getValue(),
                                                                                    idActor:registro.data.id
                                                                                }
                                                                  }
                                                              ) 
                        		}
                        }
    			)
    var arbol=	generarArbol();
     var gridOtrasSeccion=crearGridOtrasSecciones();
    var tabElementos=	new   Ext.TabPanel (	{
                                                   	x:10,
                                                    y:10,
                                                    id:'tArbol',
                                                    activeTab:0,
                                                    height:450,
                                                    width:'95%',
                                                    items:	[
                                                                
                                                                {
                                                                    xtype:'panel',
                                                                    title:'Elementos del proceso',
                                                                    items:[arbol]
                                                                }  ,
                                                                {
                                                                    xtype:'panel',
                                                                    title:'Otras secciones disponibles',
                                                                    items:[gridOtrasSeccion]
                                                                } 
                                                            ]
                                                }
                                             )
                    
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b></b></span>',
                                                tbar:	[
                                                			{
                                                            	xtype:'label',
                                                                html:'<span style="color:#900; font-weight:bold">Tipo de actor:</span>&nbsp;&nbsp;'
                                                            },
                                                            cmbTipoActor,
                                                            '-',
                                                            {
                                                            	xtype:'label',
                                                                html:'<span style="color:#900; font-weight:bold">Actor:</span>&nbsp;&nbsp;'
                                                            },
                                                            cmbActor,'-',
                                                            {
                                                            	xtype:'checkbox',
                                                                id:'chkPerfilActivo',
                                                             	boxLabel:'Perfil activo',
                                                                listeners:	{
                                                                				check:function(chk,valor)
                                                                                		{
                                                                                        	var activo=0;
                                                                                            if(valor)
                                                                                            	activo=1;
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
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=346&idProceso='+gE('idProceso').value+'&tipoActor='+
                                                                                            				gEx('cmbTipoActor').getValue()+'&idActor='+gEx('cmbActorEscenario').getValue()+'&activo='+activo,true);
                                                                                        }
                                                                
                                                                			}   
                                                            }
                                                		],
                                                items:	[
                                                            {
                                                            	xtype:'tabpanel',
                                                                region:'center',
                                                                activeTab:0,
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                title:'Configuraci&oacute;n General',
                                                                                layout:'absolute',
                                                                                items:	[
                                                                                			tabElementos
                                                                                		]
                                                                            },
                                                                            {
                                                                            	xtype:'panel',
                                                                                title:'Configuraci&oacute;n de Escenario',
                                                                                items:	[
                                                                                			new Ext.ux.IFrameComponent({ 
                
                                                                                                                            id: 'frameContenido', 
                                                                                                                            anchor:'100% 100%',
                                                                                                                            url:'../procesos/configuracionEscenarioActor.php',
                                                                                                                            style: 'width:100%;height:100%',
                                                                                                                            scripts:true,
                                                                                                                            params:	{
                                                                                                                                            cPagina:'sFrm=true',
                                                                                                                                            idProceso:gE('idProceso').value,
                                                                                                                                            tipoActor:gEx('cmbTipoActor').getValue(),
                                                                                                                                            idActor:gEx('cmbActorEscenario').getValue()
                                                                                                                                        } 
                                                                                                                    })
                                                                                		]
                                                                            }
                                                                		]
                                                            }
                                                        ]
                                            }
                                         ]
                            }
                        )  
                        
                         
}

function recargarArbolSecciones()
{
	gEx('arbolSecciones').getRootNode().reload();
}


function generarArbol()
{

	var cmbEtapa=crearComboExt('cmbEtapa',arrEtapas,0,0);
    var cmbOrden=crearComboExt('cmbOrden',[],0,0);
	var idProceso=gE('idProceso').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
                                                	autoLoad:false,
													baseParams:{
																	funcion:'22',
																	idProyecto:idProceso
                                                                    
																},
													dataUrl:'../paginasFunciones/funcionesProyectos.php'
												}
											)	
    
    cargadorArbol.on('beforeload',function(proxy)
    							{
                                	proxy.baseParams.tipoActor=gEx('cmbTipoActor').getValue();
                                    proxy.baseParams.actor=gEx('cmbActorEscenario').getValue();
    								gEx('btnOpcionesControl').disable();
                                }
    				)
                    

	cargadorArbol.on('load',function(proxy,nodo,respuesta)
    							{
                                	
                                }
    				)
                    
    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:-1,
                                                      text:'<?php echo uEJ($nombreFormulario) ?>',
                                                      draggable:false,
                                                      tipo:0,
                                                      orden:0,
                                                      idFormulario:'<?php echo $idFormulario?>',
                                                      expanded :true,
                                                      icon:'../images/Icono_txt.gif'
                                                  }
                                            )

	panelArbol=new Ext.ux.tree.EditorGrid	(
                                              {
                                              	  id:'arbolSecciones',
                                                  enableDD:true,
                                                  height:420,
                                                  width:950,
                                                  enableSort:false,
                                                  enableHdMenu:false,
                                                  loadMask: {msg: 'Cargando...' },
												  columns:	[
                                                  				
                                                                  {
                                                                      header:'Formulario',
                                                                      width:300,
                                                                      dataIndex:'text'
                                                                  },
                                                                  {
                                                                      header:'Orden',
                                                                      width:50,
                                                                      sortable:false,
                                                                      dataIndex:'orden',
                                                                      editor:cmbOrden
                                                                  },
                                                                  {
                                                                      header:'No. etapa',
                                                                      width:70,
                                                                      sortable:false,
                                                                      dataIndex:'noEtapa',
                                                                      editor:cmbEtapa
                                                                  },
                                                                  {
                                                                      header:'Obligatorio',
                                                                      width:85,
                                                                      align:'center',
                                                                      dataIndex:'obl'
                                                                  },
                                                                  {
                                                                      header:'Funci&oacute;n de visualizaci&oacute;n',
                                                                      width:350,
                                                                      dataIndex:'lblFuncionVisualizacion'
                                                                  },
                                                                  {
                                                                      header:'Funci&oacute;n de edici&oacute;n',
                                                                      width:350,
                                                                      dataIndex:'lblFuncionEdicion'
                                                                  }
                                                              ],
                                                  loader: cargadorArbol,
                                                  tbar:	[
                                                  			{
                                                            	text:'Elementos DTD',
                                                                menu:	[
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
                                                                                id:'btnNOObligatorio',
                                                                                text:'Marcar elemento como <font color="red"><b>NO</b></font> obligatorio',
                                                                                icon:'../images/update_nw.gif',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
                                                                                handler:function()
                                                                                        {
                                                                                            cambiarCondicionElemento(0);
                                                                                        }
                                                                            },
                                                                            {
                                                                                id:'btnObligatorio',
                                                                                text:'Marcar elemento como Obligatorio',
                                                                                icon:'../images/update_nw.gif',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:true,
                                                                                handler:function()
                                                                                        {
                                                                                            cambiarCondicionElemento(1);
                                                                                        }
                                                                            },
                                                                            {
                                                                            	id:'btnAgenda',
                                                                                text:'Vincular con agenda',
                                                                                icon:'../images/calendar.png',
                                                                                disabled:true,
                                                                                hidden:true,
                                                                                handler:function()
                                                                                        {
                                                                                        	mostrarVentanaViculacionAgenda();
                                                                                        }
                                                                            },
                                                                            {
                                                                            	id:'btnOpcionesControl',
                                                                                text:'Opciones de control',
                                                                                disabled:true,
                                                                                icon:'../images/process_accept.png',
                                                                                handler:function()
                                                                                        {
                                                                                        	mostrarVentanaOpcionesControl();
                                                                                        }
                                                                            }
                                                                		]
                                                            }
                                                  			
                                                  			,
                                                            {
                                                            	id:'btnConfModulo',
                                                            	text:'Modificar configuraci&oacute;n del m&oacute;dulo',
                                                                icon:'../images/cog.png',
																cls:'x-btn-text-icon',
                                                                hidden:true,
                                                                handler:function()
                                                                        {
                                                                        	if((nodoSel.attributes.conf)&&(nodoSel.attributes.conf!=''))
                                                                            {
                                                                                var objConf={};
                                                                                objConf.ancho='100%';
                                                                                objConf.alto='100%';
                                                                                objConf.url=nodoSel.attributes.conf;
                                                                                objConf.params=[['idProceso',idProceso],['cPagina','sFrm=true'],['tipoActor',gEx('cmbTipoActor').getValue()],['actor',gEx('cmbActorEscenario').getValue()]];
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
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=323&idModulo='+nodoSel.attributes.idModulo+'&idProceso='+gE('idProceso').value,true);					
																			}

                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                icon:'../images/mas.gif',
                                                                cls:'x-btn-text-icon',
                                                                text:'Administrar secciones',
                                                                hidden:true,
                                                                handler:function()
                                                                        {
                                                                        	mostrarVentanaSecciones();
                                                                        }
                                                            }
                                                            
                                                            
                                                           
                                                  		]
                                              }
                                          );                                                 	  
      
      //raiz.expand();
      panelArbol.on('beforeedit',function(e)
      							{
                                	var numHijos=gEx('arbolSecciones').getRootNode().childNodes[0].childNodes.length;
                                    var arrElementos=[];
                                    var ct;
                                    for(ct=1;ct<=numHijos;ct++)
                                    {
                                    	arrElementos.push([ct,ct]);
                                   	}
                                    gEx('cmbOrden').getStore().loadData(arrElementos);

                                }
                   ) 
      panelArbol.on('afteredit',function(e)
      							{
                                	var idElemento=e.node.id;
                                	switch(e.field)
                                    {
                                    	case 'orden':
                                        	var cadObj='{"idProceso":"'+gE('idProceso').value+'","idElemento":"'+idElemento+'","orden":"'+e.value+'","tipoActor":"'+gEx('cmbTipoActor').getValue()+'","actor":"'+gEx('cmbActorEscenario').getValue()+'"}';
                                        	function funcAjax2()
                                            {
                                                var resp=peticion_http.responseText;
                                                arrResp=resp.split('|');
                                                if(arrResp[0]=='1')
                                                {
                                                    gEx('arbolSecciones').getRootNode().reload();
                                                }
                                                else
                                                {
                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                }
                                            }
                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax2, 'POST','funcion=342&cadObj='+cadObj,true);	
                                        
                                        
                                        break;
                                        case 'noEtapa':
                                        	var cadObj='{"idElemento":"'+idElemento+'","noEtapa":"'+e.value+'"}';
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
                                    }
                                }
      				)
      
      panelArbol.expandAll();
      panelArbol.on('click',funcClikArbol);
      panelArbol.on('movenode',funcNodoMovido);
      return panelArbol;
     
}

function cambiarCondicionElemento(obligatorio)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gEx('btnObligatorio').hide();
            gEx('btnNOObligatorio').hide();
            Ext.getCmp('arbolSecciones').getRootNode().reload();
            
            nodoSel=null;
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=36&idElemento='+nodoSel.id+'&obligatorio='+obligatorio,true);
}

function funcClikArbol(nodo, evento)
{
	nodoSel=nodo;
    gEx('btnOpcionesControl').disable();
	if(!nodoSel.isRoot)
    	gEx('btnOpcionesControl').enable();
    if(nodoSel.attributes.obligatorio!=undefined)
    {
    	if(nodoSel.attributes.obligatorio=='1')
        {
        	Ext.getCmp('btnObligatorio').hide();   	
     		Ext.getCmp('btnNOObligatorio').show();
        }
        else
        {
        	Ext.getCmp('btnNOObligatorio').hide(); 
     		Ext.getCmp('btnObligatorio').show();
        }
    }
    else
    {
        Ext.getCmp('btnNOObligatorio').hide();
        Ext.getCmp('btnObligatorio').hide();   	
   }
   
  // alert(nodoSel.attributes.tipo);
   if(nodoSel.attributes.tipo=='0')
   		gEx('btnAgenda').enable();
   else
   		gEx('btnAgenda').disable();
		
   var idModulo=parseInt(nodoSel.attributes.idModulo);
   if((!nodoSel.attributes.conf)||(nodoSel.attributes.conf==''))
   {
   
       switch(idModulo)
       {
       
            case 9:
            case 3:
            case 11:
            case 12:
                Ext.getCmp('btnConfModulo').show();
            break;
            default:
                if(idModulo<0)
                    Ext.getCmp('btnConfModulo').show();
                else
                    Ext.getCmp('btnConfModulo').hide();
            break;
       }
	}
    else
    {
    	Ext.getCmp('btnConfModulo').show();
    }       
}

function funcNodoMovido(arbol,nodo,padreAnt,PadreAct,posicion)
{
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=13&idElemento='+nodo.id+'&posicion='+posicion,true);
}

function agregarElemento()
{
	var arbolSecciones=Ext.getCmp('arbolSecciones');
	var nodo=arbolSecciones.getRootNode();
	mostrarmenuAgregar(nodo);

}

function mostrarVentanaConfiguracionModulo(conf)
{
	
    switch(parseInt(nodoSel.attributes.idModulo))
    {
        case 3:
            vConfiguracionAutores(nodoSel.attributes.id);
        break;
        case 9:
        	mostrarVentanaConfiguracionPrespuesto();
        	//mostrarVentanaObjetosGasto();
        break;
        case 11: //fechas convocatorias
        	mostrarVentanaConfFechas(conf);
        break;
        case 12: //datos complementarios
        	mostrarVentanaConfDatosComplementarios();
        break;
        default:
        	if(parseInt(nodoSel.attributes.idModulo)<0)
	  	    	vConfigurarModuloProceso();
        break;
    }
    
    
}

function mostrarmenuAgregar(nodo)
{
	function generarFormAgregar()
	{
		var ctEstandares=0;
		var ctNoEstandares=0;
		var resp=eval(peticion_http.responseText)[0];
        var vModal;
        
		var raiz=new Ext.tree.AsyncTreeNode(
                                            {
                                                id:'raiz',
                                                text:'',
                                                draggable:false,
                                                icon:"../images/s.gif",
                                                children:resp.modulos
                                            }
                                        )
                                        
		var raizNoEstandar=new Ext.tree.AsyncTreeNode	(
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
																autoScroll:true,
																root: raizNoEstandar
															}
														)
	
	
		
		var tabs = new Ext.TabPanel	(
										{
											width:500,
                                            height:330,
                                            baseCls: 'x-plain',
											activeTab: 0,
											frame:true,
											border:true,
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
                                                                    y:335,
                                                                    html:'Si desea agregar un proceso como parte del DTD de click <a href="javascript:agregarProceso()"> <font color="red"><b>AQU&Iacute;</b></font></a>'
                                                                }
															]
												}
											)
		var vModal=new Ext.Window	(
										{
                                        	id:'vAgregarElemento',
											title: 'Agregar nuevo elemento',
											width: 530,
											height:440,
											minWidth: 300,
											minHeight: 200,
											layout: 'fit',
											plain:true,
											bodyStyle:'padding:5px;',
											buttonAlign:'center',
											modal:true,
											items:[formulario],
											buttons:	[
															{
																id:'btnAgregar',
																text: '<?php echo $etj["lblBtnAceptar"] ?>',
																handler:	function()
																			{
                                                                                agregarElementosDTD(arbolElemStandard,arbolElemNoEstandar,vModal);
																			}
															},
															{
																id:'btnCancelar',
																text: '<?php echo $etj["lblBtnCancelar"] ?>',
																handler: 	function()
																			{
																				vModal.close();
																			}
															}
														]
										}
									);
		vModal.show();
	}
	obtenerDatosWeb("../paginasFunciones/funcionesProyectos.php",generarFormAgregar,'POST','funcion=2&tipoActor='+gEx('cmbTipoActor').getValue()+'&actor='+gEx('cmbActorEscenario').getValue()+'&idProceso='+gE('idProceso').value,true);

    function agregarElementosDTD(raizModulosP,raizFormProceso,vModal)
    {
    	var elementos='';
        var raiz=raizModulosP.getChecked();
        var raizNoEstandar=raizFormProceso.getChecked();
        for(x=0;x<raiz.length;x++)
        {
            objElemento='{"idModulo":"'+raiz[x].attributes.idModulo+'","tipo":"1"}';
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
        var idProceso=gE('idProceso').value;
        var obj='{"tipoActor":"'+gEx('cmbTipoActor').getValue()+'","actor":"'+gEx('cmbActorEscenario').getValue()+'","idProceso":"'+idProceso+'","elementos":['+elementos+']}';    
    	
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	Ext.getCmp('arbolSecciones').getRootNode().reload();
                vModal.close();		
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=1&elementosDTD='+obj,true);
        
    }
}

function quitarElemento()
{
	var arbolSecciones=Ext.getCmp('arbolSecciones');
	var sModel=arbolSecciones.getSelectionModel();
	var nodo=sModel.getSelectedNode();
	if(nodo==null)
	{
		msgBox('Debe elegir un elemento a eliminar');
	}
	else
	{	
		var prof=nodo.getDepth();
		if(prof==0)
		{
			msgBox('No se puede eliminar el nodo ra&iacute;z');
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
               		 	nodo.remove() ;
                    }
                    else
                    {
                        msgBox('No se ha podido realizar la operaci&oacute;n debido al siguiente problema:'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=14&idElemento='+nodo.id,true);
        	}
		}		 
        Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','Est&aacute; seguro de querer eliminar el elemento seleccionado?',resp);
	}
}

function crearGridOtrasSecciones()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idSeccion'},
		                                                {name: 'tituloSeccion'},
		                                                {name:'paginaJavaScript'},
		                                                {name:'funcionScript'},
                                                        {name: 'funcionInicializacion'},
                                                        {name: 'paginaIncludePhp'},
                                                        {name: 'funcionRenderer'},
                                                        {name: 'descripcion'}
                                                        
                                                        
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
                                                            sortInfo: {field: 'tituloSeccion', direction: 'ASC'},
                                                            groupField: 'tituloSeccion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='332';
                                        proxy.baseParams.idProceso=gE('idProceso').value;
                                        proxy.baseParams.tipoActor=gEx('cmbTipoActor').getValue();
                                        proxy.baseParams.idActor=gEx('cmbActorEscenario').getValue();
                                        
                                       
                                                                                    
                                        
                                    }
                        )   


	alDatos.on('load',function(proxy)
                     {
                     	if(proxy.reader.jsonData.situacion=='0')
                        	gEx('chkPerfilActivo').setValue(false);	 	
                        else
                            gEx('chkPerfilActivo').setValue(true);	 	
                             
                                                                          
                              
                     }
              )  
                        
	var expander = new Ext.ux.grid.RowExpander({
                                                column:3,
                                                expandOnEnter:false,
                                                tpl : new Ext.Template(
                                                    '<table >',
                                                    '<tr><td style="padding:5px; color:#666; font-style:italic">{descripcion}</td></tr>',
                                                    '</table>'
                                                )
                                            });                        
                           
                        
	var chkRow=new Ext.grid.CheckboxSelectionModel();       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            expander,
                                                            chkRow,
                                                            {
                                                                header:'Leyenda',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'tituloSeccion',
                                                                editor:{xtype:'textfield'}
                                                            },
                                                            {
                                                                header:'P&aacute;gina JavaScript <span class="letraRoja">*</span>',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'paginaJavaScript',
                                                                editor:{xtype:'textfield'}
                                                            },
                                                            {
                                                                header:'Funci&oacute;n JavaScript asociada<span class="letraRoja">*</span>',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'funcionScript',
                                                                editor:{xtype:'textfield'}
                                                            },
                                                            {
                                                                header:'Funci&oacute;n JavaScript inicializaci&oacute;n',
                                                                width:230,
                                                                sortable:true,
                                                                dataIndex:'funcionInicializacion',
                                                                editor:{xtype:'textfield'}
                                                            },
                                                            {
                                                                header:'P&aacute;gina include PHP',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'paginaIncludePhp',
                                                                editor:{xtype:'textfield'}
                                                            },
                                                            {
                                                                header:'Funci&oacute;n PHP renderer',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'funcionRenderer',
                                                                editor:{xtype:'textfield'}
                                                            }
                                                        ]
                                                    );


	var editorFila=new Ext.ux.grid.RowEditor	(
    												{
														id:'editor_gridOtrasSecciones',
                                                        saveText: 'Guardar',
                                                        cancelText:'Cancelar',
                                                        clicksToEdit:2
                                                    }
                                                );
	editorFila.on('afteredit',funcEditorAfterEditSeccion)                                                
    editorFila.on('beforeedit',funcEditorBeforeEditSeccion)
    editorFila.on('validateedit',funcEditorValidaSeccion);
    editorFila.on('canceledit',funcEditorCancelEditSeccion);
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridOtrasSecciones',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:425,
                                                                sm:chkRow,
                                                                plugins:[editorFila,expander],
                                                                tbar:	[
                                                                            {
                                                                            	id:'btnAdd_gridOtrasSecciones',
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar configuraci&oacute;n de secci&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                         	var tblGrid=gEx('gridOtrasSecciones');
                                                                                              var registroGrid=crearRegistro([
                                                                                                                                {name:'idSeccion'},
                                                                                                                                {name: 'tituloSeccion'},
                                                                                                                                {name:'paginaJavaScript'},
                                                                                                                                {name:'funcionScript'},
                                                                                                                                {name: 'funcionInicializacion'},
                                                                                                                                {name: 'paginaIncludePhp'},
                                                                                                                                {name: 'funcionRenderer'}
                                                                                                                                
                                                                                                                                
                                                                                                                            ]);
                                                                                              
                                                                                              var nReg=new registroGrid	(
                                                                                              								{
                                                                                                                              idSeccion:-1,
                                                                                                                              tituloSeccion:'',
                                                                                                                              paginaJavaScript:'',
                                                                                                                              funcionScript:'',
                                                                                                                              funcionInicializacion:'',
                                                                                                                              paginaIncludePhp:'',
                                                                                                                              funcionRenderer:''
                                                                                                                            }
                                                                                                                          )
                                                                                              
                                                                                              editorFila.stopEditing();
                                                                                              tblGrid.getStore().add(nReg);
                                                                                              tblGrid.nuevoRegistro=true;
                                                                                              editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                              Ext.getCmp('btnAdd_gridOtrasSecciones').disable();
                                                                                              Ext.getCmp('btnDel_gridOtrasSecciones').disable();	   
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnDel_gridOtrasSecciones',
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover configuraci&oacute;n de secci&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                            var filas=tblGrid.getSelectionModel().getSelections();
                                                                                            if(filas.length==0) 
                                                                                            {
                                                                                            	msgBox('Debe seleccionar al menos una secci&oacute;n para remover');
                                                                                                return;
                                                                                            }
                                                                                            var listTemporizadores='';
                                                                                            var x;
                                                                                            for(x=0;x<filas.length;x++)
                                                                                            {
                                                                                            	if(listTemporizadores=='')
                                                                                                	listTemporizadores=filas[x].get('idSeccion');
                                                                                                else
                                                                                                	listTemporizadores+=','+filas[x].get('idSeccion');
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
                                                                                                            tblGrid.getStore().remove(filas);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=334&listConfiguraciones='+listTemporizadores,true);

                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover las secciones seleccionadas?',resp);
                                                                                        }
                                                                                
                                                                            }
                                                                          ],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit: false,
                                                                                                    enableGrouping :false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}

function funcEditorAfterEditSeccion(rowEdit,obj,registro,nFila)
{

}

function funcEditorBeforeEditSeccion(rowEdit,fila)
{
	var datosEditor=rowEdit.getId().split('_')	
	var idGrid=datosEditor[1];
	var grid=Ext.getCmp(idGrid);
    grid.copiaRegistro=grid.getStore().getAt(fila).copy();
    grid.registroEdit=grid.getStore().getAt(fila);
	if((grid.soloLectura)&&(!grid.nuevoRegistro))
		return false;
}

function funcEditorValidaSeccion(rowEdit,obj,registro,nFila)
{
	var datosEditor=rowEdit.getId().split('_')	
	var idGrid=datosEditor[1];
	var grid=Ext.getCmp(idGrid);
	var cm=grid.getColumnModel();
	var nColumnas=cm.getColumnCount(false);
	var x;
	var editor;
	var dataIndex;
	var valor;
	for(x=0;x<nColumnas;x++)
	{
		if(cm.getColumnHeader(x).indexOf('*')!=-1)
		{
			dataIndex=cm.getDataIndex(x);
			valor=(eval('obj.'+dataIndex));
			if(valor=='')
			{
				function funcResp()
				{
					var ctrl=gEx('editor_'+dataIndex);
					ctrl.focus();
				}
				msgBox('La columna "'+cm.getColumnHeader(x).replace('*','')+'" no puede ser vac&iacute;a',funcResp);
				return false;
			}
		}	
	}
    
    
    var cadObj='{"tipoActor":"'+gEx('cmbTipoActor').getValue()+'","idActor":"'+gEx('cmbActorEscenario').getValue()+'","idSeccion":"'+registro.get('idSeccion')+'","tituloSeccion":"'+cv(obj.tituloSeccion)+'","paginaJavaScript":"'+cv(obj.paginaJavaScript)+
    			'","funcionScript":"'+cv(obj.funcionScript)+'","funcionInicializacion":"'+cv(obj.funcionInicializacion)+'","paginaIncludePhp":"'+
                cv(obj.paginaIncludePhp)+'","funcionRenderer":"'+cv(obj.funcionRenderer)+'","idProceso":"<?php echo $idProceso?>"}';
    
 
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	registro.set('idSeccion',arrResp[1]);
            Ext.getCmp('btnAdd_gridOtrasSecciones').enable();
			Ext.getCmp('btnDel_gridOtrasSecciones').enable();	
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=333&cadObj='+cadObj,true);
    
    return true;
   
}

function funcEditorCancelEditSeccion(rowEdit,cancelado)
{
	var datosEditor=rowEdit.getId().split('_')
	var idGrid=datosEditor[1];
	var grid=Ext.getCmp(idGrid);
	if(grid.nuevoRegistro)
		grid.getStore().removeAt(grid.getStore().getCount()-1);
	Ext.getCmp('btnDel_'+idGrid).enable();
    Ext.getCmp('btnAdd_'+idGrid).enable();
    var copiaRegistro=grid.copiaRegistro;
    
    var x=0;
    var arrCampos=grid.getStore().fields;
    var filaDestino=grid.registroEdit;

    for(x=0;x<arrCampos.items.length;x++)
    {
    	filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));

    }

    
	grid.nuevoRegistro=false;
}

function agregarProceso()
{
	gEx('vAgregarElemento').close();
	var arrTipoProceso=<?php echo $arrTiposProc ?>;
    var cmbTipoProceso=crearComboExt('cmbTipoProceso',arrTipoProceso,130,5);
    cmbTipoProceso.setWidth(250);
    cmbTipoProceso.on('select',buscarProceso);
    var cmbProceso=crearComboExt('cmbProceso',[],130,35);
    cmbProceso.setWidth(320);
    var cmbEtapa=crearComboExt('cmbEtapa',<?php echo $arrEt?>,130,65,320);
    
    
    var form = new Ext.form.FormPanel(	
										
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de proceso:'
                                                        },
                                                        cmbTipoProceso,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Proceso:'
                                                        },
                                                        cmbProceso,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Etapa:'
                                                        },
                                                        cmbEtapa
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar un proceso/elemento como parte del DTD',
										width: 490,
										height:215,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var idProceso=gE('idProceso').value;
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
                                                                            	Ext.getCmp('arbolSecciones').getRootNode().reload();
                																ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=176&tipoActor='+gEx('cmbTipoActor').getValue()+'&actor='+gEx('cmbActorEscenario').getValue()+'&idProcesoP='+idProceso+'&idProcesoV='+cmbProceso.getValue()+'&nEtapa='+cmbEtapa.getValue(),true);

                                                                    
                                                                    	
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
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

function mostrarVentanaOpcionesControl()
{
	
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	xtype:'label',
                                                            html:'Funci&oacute;n condicionante visualizaci&oacute;n:',
                                                            x:10,
                                                            y:10
                                                        }	,
                                                        {
                                                        	x:220,
                                                            y:5,
                                                            xtype:'textfield',
                                                            readOnly:true,
                                                            width:300,
                                                            id:'cmbFuncionVisualizacion'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            y:5,
                                                            x:540,
                                                            html:'<a href="javascript:mostrarVentanaFuncion(1)"><img src="../images/pencil.png" title="Asignar funci&oacute;n" alt="Asignar funci&oacute;n"></a>&nbsp;&nbsp;<a href="javascript:removerFuncion(1)"><img src="../images/delete.png" title="Remover funci&oacute;n" alt="Remover funci&oacute;n"></a>'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            html:'Funci&oacute;n condicionante edici&oacute;n:',
                                                            x:10,
                                                            y:40
                                                        },
                                                        {
                                                        	x:220,
                                                            y:35,
                                                            xtype:'textfield',
                                                            readOnly:true,
                                                            width:300,
                                                            id:'cmbFuncionVisualizacionEdit'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            y:35,
                                                            x:540,
                                                            html:'<a href="javascript:mostrarVentanaFuncion(2)"><img src="../images/pencil.png" title="Asignar funci&oacute;n" alt="Asignar funci&oacute;n"></a>&nbsp;&nbsp;<a href="javascript:removerFuncion(2)"><img src="../images/delete.png" title="Remover funci&oacute;n" alt="Remover funci&oacute;n"></a>'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Opciones de control',
										width: 650,
										height:150,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var cmbFuncionVisualizacion=gEx('cmbFuncionVisualizacion');
                                                                        var cmbFuncionVisualizacionEdit=gEx('cmbFuncionVisualizacionEdit');
                                                                    	var idFuncionEdicion='-1';
                                                                        if(cmbFuncionVisualizacionEdit.idFuncion)
                                                                        {
                                                                        	idFuncionEdicion=cmbFuncionVisualizacionEdit.idFuncion;
                                                                            if(idFuncionEdicion=='')
                                                                            	idFuncionEdicion=-1;
                                                                        }	
                                                                        var idFuncionVisualizacion='-1';
                                                                        if(cmbFuncionVisualizacion.idFuncion)
                                                                        {
                                                                        	idFuncionVisualizacion=cmbFuncionVisualizacion.idFuncion;
                                                                            if(idFuncionVisualizacion=='')
                                                                            	idFuncionVisualizacion=-1;
                                                                        }
                                                                    	var cadObj='{"idFuncionEdicion":"'+idFuncionEdicion+'","idFuncionVisualizacion":"'+idFuncionVisualizacion+'","idElemento":"'+nodoSel.id+'"}';
																		function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('arbolSecciones').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=335&cadObj='+cadObj,true);
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
    var cmbFuncionVisualizacion=gEx('cmbFuncionVisualizacion');
    cmbFuncionVisualizacion.setValue(nodoSel.attributes.lblFuncionVisualizacion);
    cmbFuncionVisualizacion.idFuncion=nodoSel.attributes.idFuncionVisualizacion;
    var cmbFuncionVisualizacionEdit=gEx('cmbFuncionVisualizacionEdit');
    cmbFuncionVisualizacionEdit.setValue(nodoSel.attributes.lblFuncionEdicion);
    cmbFuncionVisualizacionEdit.idFuncion=nodoSel.attributes.idFuncionEdicion;
}


function mostrarVentanaFuncion(tipoFuncion)
{
	asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre)
                                            {
                                            	var txtDestino='';
                                                if(tipoFuncion==1)
                                                	txtDestino='cmbFuncionVisualizacion';
                                                else
                                                	txtDestino='cmbFuncionVisualizacionEdit';
                                                gEx(txtDestino).setValue(nombre);
                                                gEx(txtDestino).idFuncion=idConsulta;
                                                gEx('vAgregarExp').close();
                                                
                                            }
	mostrarVentanaExpresion(function(fila,ventana)
    						{
                            	var txtDestino='';
                                if(tipoFuncion==1)
                                    txtDestino='cmbFuncionVisualizacion';
                                else
                                    txtDestino='cmbFuncionVisualizacionEdit';
                            	gEx(txtDestino).setValue(fila.get('nombreConsulta'));
                                gEx(txtDestino).idFuncion=fila.get('idConsulta');
                                ventana.close();
                            }
    						,
    						true);
}

function removerFuncion(tipoFuncion)
{
	var txtDestino='';
    if(tipoFuncion==1)
        txtDestino='cmbFuncionVisualizacion';
    else
        txtDestino='cmbFuncionVisualizacionEdit';
    gEx(txtDestino).setValue();
    gEx(txtDestino).idFuncion=-1;
}


function vConfigurarModuloProceso()
{
	var cmbActor=crearComboExt('cmbActor',[],310,5);
    cmbActor.setWidth(260);
    var cmbResponsable=crearComboExt('cmbResponsable',[],230,35);
    cmbResponsable.setWidth(340);
    cmbResponsable.on('select',funcSelectResponsable);
    var arrMostrarReg=[['1','Aquellos dados de alta dentro del proceso padre'],['2','Aquellos definidos para el actor en el escenario de proceso vinculado']];
    var cmbMostrarRegistro=crearComboExt('cmbMostrarRegistro',arrMostrarReg,230,95);
    cmbMostrarRegistro.setWidth(340);
    var cmbCampoFormulario=crearComboExt('cmbCampoFormulario',eval(bD(gE('arrCampos').value)),230,65);
    cmbCampoFormulario.setWidth(340);
    cmbCampoFormulario.hide();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el actor con el cual se ingresar&aacute; al proceso:'
                                                        },
                                                        cmbActor,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Los nuevos registros se asociar&aacute;n con:'
                                                        },
                                                        cmbResponsable,
                                                        {
                                                        	id:'lblFormularioB',
                                                        	x:10,
                                                            y:70,
                                                            html:'Campo de formulario base:',
                                                            hidden:true
                                                        },
                                                        cmbCampoFormulario,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Los registros que se mostrar&aacute;n son:'
                                                        },
                                                        cmbMostrarRegistro
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n de m&oacute;dulo de proceso',
										width: 620,
										height:230,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		if(cmbActor.getValue()=='')
                                                                        {
                                                                        	function respActor()
                                                                            {
                                                                            	cmbActor.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el actor con el cual se ingresar&aacute; al proceso',respActor);
                                                                            return;
                                                                        }
                                                                        if(cmbResponsable.getValue()=='')
                                                                        {
                                                                        	function respResponsable()
                                                                            {
                                                                            	cmbResponsable.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la figura a a la cual se asociar&aacute;n los nuevos registros',respResponsable);
                                                                            return;
                                                                        }
                                                                        var cmbCampoFormulario=gEx('cmbCampoFormulario');
                                                                        if(cmbResponsable.getValue()=='-10')
                                                                        {
                                                                        	if(cmbCampoFormulario.getValue()=='')
                                                                            {
                                                                            	function respCampoForm()
                                                                                {
                                                                                    cmbCampoFormulario.focus();
                                                                                }
                                                                                msgBox('Debe seleccionar el campo del formulario bajo el cual se asociar&aacute;n los registros',respCampoForm);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        if(cmbMostrarRegistro.getValue()=='')
                                                                        {
                                                                        	function respMostrarReg()
                                                                            {
                                                                            	cmbMostrarRegistro.focus();
                                                                            }
                                                                            msgBox('Debe indicar los registros que se mostrar&aacute;n en la vista del proceso',respMostrarReg);
                                                                            return;
                                                                        }
                                                                        var cadComplementaria=cmbActor.getValue()+','+cmbResponsable.getValue()+','+cmbMostrarRegistro.getValue()+','+cmbCampoFormulario.getValue();
                                                                        
                                                                        
                                                                        var idElemento=nodoSel.id;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                Ext.getCmp('arbolSecciones').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=182&idElemento='+idElemento+'&valor='+cadComplementaria,true);
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
    llenarDatosConfiguracionModuloProceso(ventanaAM);
}

function llenarDatosConfiguracionModuloProceso(ventana)
{
	var idProceso=gE('idProceso').value;
    var idElemento=nodoSel.id;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var obj=eval(arrResp[1])[0];
        	gEx('cmbResponsable').getStore().loadData(obj.opcionesAsoc);
            gEx('cmbActor').getStore().loadData(obj.opcionesActores);
            if(obj.actor!='')
            {
            	gEx('cmbActor').setValue(obj.actor);
                gEx('cmbResponsable').setValue(obj.asocRegistro);
                if(obj.asocRegistro=='-10')
                {
                	var cmbCampoFormulario=gEx('cmbCampoFormulario');
                	cmbCampoFormulario.setValue(obj.idCampoFrm);
                    cmbCampoFormulario.show();
                    gEx('lblFormularioB').show();
                    
                }
                gEx('cmbMostrarRegistro').setValue(obj.mostrarRegistro);
                
           	}
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=181&idProcesoV='+(parseInt(nodoSel.attributes.idModulo)*-1)+'&idProceso='+idProceso+'&idElemento='+idElemento,true);
}

function funcSelectResponsable(combo,registro)
{
	var idFormularioBase=gE('formularioBase').value;
	if(registro.get('id')=='-10')
    {
    	gEx('lblFormularioB').show();
        gEx('cmbCampoFormulario').show();
    }		
    else
     {
    	gEx('lblFormularioB').hide();
        gEx('cmbCampoFormulario').hide();
    }
}


function removerEtapa(e,iS)
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
                    gEx('gridOtrasSecciones').getStore().reload();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=343&e='+bD(e)+'&iS='+bD(iS),true);
            
		}
    }
    msgConfirm('Est&aacute; seguro de querer remover la etapa seleccionada?',resp);
}


function agregarEtapaSeccion(iS)
{
	var gridEtapasSeccion=crearGridEtapasSeccion(bD(iS));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridEtapasSeccion

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar etapa de visualizaci&oacute;n de secci&oacute;n',
										width: 500,
										height:350,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var listEtapas='';
                                                                        var filas=gridEtapasSeccion.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos una etapa para asignar a la secci&oacute;n');
                                                                            return;
                                                                        }
                                                                        var x;
                                                                        var f;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                            if(listEtapas=='')
                                                                            	listEtapas=f.data.numEtapa;
                                                                            else
                                                                            	listEtapas+=','+f.data.numEtapa;
                                                                        }
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridOtrasSecciones').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=345&listEtapas='+listEtapas+'&iS='+bD(iS),true);

                                                                        
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();		
}

function crearGridEtapasSeccion(iS)
{
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'numEtapa',type:'float'},
		                                                {name: 'nombreEtapa'}
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
                                                            sortInfo: {field: 'numEtapa', direction: 'ASC'},
                                                            groupField: 'numEtapa',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='344';
                                        proxy.baseParams.idSeccion=iS;
                                        proxy.baseParams.idProceso=gE('idProceso').value;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'No. Etapa',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'numEtapa',
                                                                renderer:removerCerosDerecha
                                                            },
                                                            {
                                                                header:'Etapa',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'nombreEtapa'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridEtapasSecc',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                border:true,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                height:245,
                                                                sm:chkRow,
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