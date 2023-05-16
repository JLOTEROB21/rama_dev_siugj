<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var nodoSel=null;
Ext.onReady(inicializar);

function inicializar()
{
	Ext.QuickTips.init();
	gE('_nombrePerfilvch').focus();
	var idPerfil=gE('idPerfil').value;
    if(idPerfil!='-1')
    	crearArbolDTD(idPerfil);
}

function validarFrm()
{
	if(validarFormularios('frmEnvio'))
    	gE('frmEnvio').submit();
}

function crearArbolDTD(idPerfil)
{
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'50',
																	idPerfil:idPerfil
																},
													dataUrl:'../paginasFunciones/funcionesFormulario.php'
												}
											)	



    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'-1',
                                                      text:'DTD',
                                                      draggable:false,
                                                      expanded :true
                                                  }
                                            )

	panelArbol=new Ext.tree.TreePanel	(
                                              {
                                              	  id:'arbolDTD',
                                                  el:'arbolDTD',
                                                  useArrows:true,
                                                  autoScroll:true,
                                                  animate:false,
                                                  enableDD:true,
                                                  containerScroll:true,
                                                  height:800,
												  width:520,
                                                  root:raiz,
                                                  rootVisible:false,
												  loader: cargadorArbol,
                                                  title:'DTD del formato de exportaci&oacute;n',
                                                  tbar:	[
                                                  			/*{
                                                            	id:'btnUp',
                                                                icon:'../images/SignUp.gif',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Subir posici&oacute;n',
                                                                disabled:true,
                                                                handler:function ()
                                                                		{
                                                                        	var nodoPadre=nodoSel.parentNode;
                                                                            var nodoSig=nodoSel.nextSibling;
                                                                            var nodoAnt=nodoSel.previousSibling;
                                                                            nodoPadre.insertBefore(nodoSel,nodoAnt);
                                                                            hablitarBotonesUpDown(nodoSel);
                                                                            
                                                                       	}
                                                           	},'-',
                                                            {
                                                            	id:'btnDown',
                                                                icon:'../images/SignDown.gif',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Bajar posici&oacute;n',
                                                                disabled:true,
                                                                handler:function ()
                                                                		{
                                                                        	var nodoPadre=nodoSel.parentNode;
                                                                            var nodoSig=nodoSel.nextSibling;
                                                                            var nodoAnt=nodoSel.previousSibling;
                                                                            nodoPadre.insertBefore(nodoSig,nodoSel);
                                                                            hablitarBotonesUpDown(nodoSel);
                                                                            
                                                                       	}
                                                           	},*/
                                                            {
                                                            	id:'btnAgregar',
                                                                icon:'../images/add.png',
                                                                text:'Agregar...',
                                                                cls:'x-btn-text-icon',
                                                                disabled:true,
                                                                menu:	[
                                                                			{
                                                                            	text:'Elemento libre',
                                                                                handler:function()
                                                                             	   		{
                                                                                        
                                                                                        	function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                	var nNodo=new Ext.tree.TreeNode	(
                                                                                                                                        {
                                                                                                                                            id:arrResp[1],
                                                                                                                                            text:'nuevoElemento',
                                                                                                                                            icon:'../images/bullet_green.png'
                                                                                                                                        }
                                                                                                                                    );        
                                                                                                    nodoSel.appendChild(nNodo);
                                                                                                    ge.editNode=nNodo;
						                                                                            ge.startEdit(nNodo.ui.textNode);
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=53&idPadre='+nodoSel.id,true);
                                                                                        
                                                                                        
                                                                                			
                                                                                        }
                                                                            },
                                                                            {
                                                                            	text:'Elemento del proceso',
                                                                                handler:function()
                                                                                		{
                                                                                        
                                                                                        }
                                                                            }
                                                                		]
                                                                
                                                           	}
                                                            ,'-',
                                                            {
                                                            	id:'btnRemover',
                                                                icon:'../images/delete.png',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Remover elemento',
                                                                disabled:true,
                                                                handler:function ()
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
                                                                                        	nodoSel.remove();	
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=52&idElemento='+nodoSel.id,true);
                                                                                }
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer eliminar el elemento seleccionado?',resp)
                                                                        
                                                                       	}
                                                           	},'-',
                                                            {
                                                            	id:'btnModificar',
                                                                icon:'../images/pencil.png',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Modificar etiqueta del elemento',
                                                                disabled:true,
                                                                handler:function ()
                                                                		{
                                                                        	ge.editNode=nodoSel;
                                                                            ge.startEdit(nodoSel.ui.textNode);
                                                                       	}
                                                           	}
                                                            
                                                  		]
                                              }
                                          );      
	var ge = new Ext.tree.TreeEditor(panelArbol, {/* fieldconfig here */ }, 
    		{
                allowBlank:false,
                editDelay :100,
                blankText:'El nombre del tag XML no puede ser vac&iacute;a',
                selectOnFocus:true
            });
                                                                                     	  
    panelArbol.render();
    panelArbol.expandAll();
    panelArbol.on('textchange',funcTextoChange);
    panelArbol.on('click',funcClickArbol);
    panelArbol.on('nodedragover',funcionValidarNodoDrop);
    panelArbol.on('beforenodedrop',funcionNodoDrop);
}

function funcTextoChange(nodo,texto,oldText)
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
            gEx('arbolDTD').getRootNode().reload();
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=51&idElemento='+nodo.id+'&valor='+cv(texto),true);
	
}

function funcClickArbol(nodo)
{
	nodoSel=nodo;
    //alert(nodoSel.attributes.orden);
    //alert(nodoSel.attributes.ambito);
    gEx('btnRemover').enable();
    gEx('btnAgregar').enable();
    gEx('btnModificar').enable();
}

function funcionNodoDrop(objDrop)
{
	var nodoDrop=objDrop.dropNode;
	var nodoPadreFuente=nodoDrop.parentNode;
    var nodoSigFuente=nodoDrop.nextSibling;
    var nodoAntFuente=nodoDrop.previousSibling;
    var idPadre=nodoPadreFuente.id;
    var nodoDestino=objDrop.target;
    var accion=objDrop.point;
    var nodoSigDestino;
    var nodoAntDestino;

    switch(accion)
    {
    	case 'append':
        	nodoSigDestino=null;
            idPadre=nodoDestino.id;
        break;
        case 'above':
        	nodoSigDestino=nodoDestino;
            idPadre=nodoDestino.parentNode.id;
           break;
        case 'bellow':
			nodoSigDestino=nodoDestino.nextSibling;       
            idPadre=nodoDestino.parentNode.id;
        break;
    }

   	var nSigD='-1';
    if(nodoSigDestino!=null)
   		nSigD=nodoSigDestino.id;
    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gEx('arbolDTD').getRootNode().reload();
            gEx('arbolDTD').expandAll();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            if(nodoSigFuente!=null)
	            nodoPadreFuente.insertBefore(nodoDrop,nodoSigFuente);
            else
            	nodoPadreFuente.appendChild(nodoDrop);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=54&nF='+nodoDrop.id+'&idPadre='+idPadre+'&nSigD='+nSigD,true);
}

function funcionValidarNodoDrop(objDrop)
{
	var nodoFuente=objDrop.dropNode;
    var nodoDestino=objDrop.target;
    if(nodoFuente.attributes.ambito!=nodoDestino.attributes.ambito)
    	objDrop.cancel=true;
}

function hablitarBotonesUpDown(nodo)
{
	var nodoPadre=nodoSel.parentNode;
    var nodoSig=nodoSel.nextSibling;
    if(nodoSig==null)
    	gEx('btnDown').disable();
    else
    	gEx('btnDown').enable();
    var nodoAnt=nodoSel.previousSibling;
    if(nodoAnt==null)
    	gEx('btnUp').disable();
    else
    	gEx('btnUp').enable();
}