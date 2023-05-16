<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
Ext.onReady(inicializar);
var nodoSelActividad=null;

function inicializar()
{
	Ext.QuickTips.init();
	var idFrm=gE('idFormulario').value;
    var idRef=gE('idReferencia').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'73',
																	idFormulario:idFrm,
                                                                    idReferencia:idRef
																},
													dataUrl:'../paginasFunciones/funcionesProyectos.php',
                                                    uiProviders:	{
                                                                        'col': Ext.ux.tree.ColumnNodeUI
                                                                    }
												}
											)	

    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'-1',
                                                      text:'Actividades',
                                                      draggable:false,
                                                      expanded :true,
                                                      icon:'../images/gantt.png'
                                                      
                                                  }
                                            )

	var panelActividades=new Ext.ux.tree.ColumnTree	(
                                              {
                                              	  id:'arbolActividades',
                                                  
                                                  useArrows:true,
                                                  autoScroll:true,
                                                  animate:false,
                                                  enableDD:true,
                                                  containerScroll:true,
                                                  height:400,
												  width:650,
                                                  root:raiz,
                                                  rootVisible:false,
                                                  rootVisible:true,
												  loader: cargadorArbol,
                                                 
                                                  
                                                  title:'',
                                                  collapsible: true,
                                                  draggable:false,
                                                  columns:[
                                                                     
                                                                {
                                                                    header: 'Actividad',
                                                                    dataIndex: 'text',
                                                                    width: 400
                                                                    
                                                                },
                                                                {
                                                                    header: 'Fecha de inicio',
                                                                    width: 100,
                                                                    dataIndex: 'fInicio',
                                                                    align: 'center'
                                                                },
                                                                {
                                                                    header: 'Fecha de t&eacute;rmino',
                                                                    width: 100,
                                                                    dataIndex: 'fFin',
                                                                    align: 'center'
                                                                }
                                                           ]
                                              }
                                          );   
    var panel=new Ext.Panel	(
        							{
                                    	id:'divPanel',
                                        renderTo:'tblArbolGantt',
                                         tbar:[
                                                  			{
                                                            	id:'btnVerGantt',
                                                            	text:'Ver diagrama de gantt',
                                                                icon:'../images/gantt.png',
																cls:'x-btn-text-icon',
                                                                hidden:false,
                                                                handler:function()
                                                                        {
                                                                        	verGantt();
                                                                        }
                                                                        	
                                                            }
                                                  
                                                  		],
                                        items:	[
                                                    panelActividades
                                        		]
        							}
                             )                                              	  
    panelActividades.render();
    panelActividades.expandAll();
    panelActividades.on('click',funcClikArbolActividades);  
}

function funcClikArbolActividades(nodo, evento)
{

	nodoSelActividad=nodo;
    if(nodoSelActividad.id!='-1')
	    tb_show(lblAplicacion,'../fichas/fichaDescripcionActividad.php?iA='+bE(nodo.id)+'&cPagina=sFrm=true&TB_iframe=true&height=480&width=600',"","scrolling=yes");
}


function verGantt()
{
	var idFrm=gE('idFormulario').value;
    var idRef=gE('idReferencia').value;
	 var param=Base64.encode('idFormulario='+idFrm+'&idReferencia='+idRef);
	window.parent.abrirVentana('../gantt/showGantt.php?param='+param);
}