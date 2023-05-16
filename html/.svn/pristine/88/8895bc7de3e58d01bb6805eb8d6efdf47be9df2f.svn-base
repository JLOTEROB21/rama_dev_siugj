<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$conCalculos="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE idTipoConcepto=5";
	$arregloCalc=$con->obtenerFilasArreglo($conCalculos);
	$idProceso=bD($_GET["iP"]);
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idActor=bD($_GET["iA"]);	
	$participante=bD($_GET["idP"]);
	$consulta="SELECT idMenu,textoMenu,idFuncionVisualiza FROM 808_titulosMenu where idProceso=".$idProceso." ORDER BY textoMenu";
	$res=$con->obtenerFilas($consulta);
	$cadMenu="";
	$constante=1;
	
	if($idActor<0)
		$constante=-1;
		
	if($idActor!=0)
	{
		if($participante==0)
		{
			$consulta="select tipoActor,actor from 944_actoresProcesoEtapa where idActorProcesoEtapa=".$idActor*$constante;
			$filaActor=$con->obtenerPrimeraFila($consulta);
			$tipoActor=$filaActor[0];
			$act=$filaActor[1];
		}
		else
		{
			$tipoActor=1;
			$act=$idActor;
		}
	}
	else
	{
		$tipoActor="1";
		$act=0;
	}
	
	while($fila=mysql_fetch_row($res))
	{
		$consulta="";
		$publicarMenu=true;
		
		if($publicarMenu)
		{
			if($fila[2]!=-1)
			{
				$cadObj='{"idFormulario":"'.$idFormulario.'","idRegistro":"'.$idRegistro.'","idActor":"'.$idActor.'"}';
				$obj=json_decode($cadObj);
				$cache=NULL;
				$resEval= resolverExpresionCalculoPHP($fila[2],$obj,$cache);
				if($resEval!=1)
				{
					$publicarMenu=false;
				}
			}
		}
		if($publicarMenu)
		{
			$consulta="SELECT o.idOpciones,o.textoOpcion,o.paginaUrlDestino,o.tipoEnlace,o.idContenido,o.idFuncionVisualizacion,o.tamano 
					FROM 811_menusVSOpciones m,809_opciones o WHERE o.idOpcion=m.idOpcion AND m.idMenu=".$fila[0]." ORDER BY m.orden";
	
			$resOpt=$con->obtenerFilas($consulta);
			$arrMenu="";
			while($filaOpt=mysql_fetch_row($resOpt))
			{
				$publicarOpcion=true;
				if($filaOpt[5]!=-1)
				{
					
					$cadObj='{"idFormulario":"'.$idFormulario.'","idRegistro":"'.$idRegistro.'","idActor":"'.$idActor.'"}';
					$obj=json_decode($cadObj);
					$cache=NULL;
					$resEval= resolverExpresionCalculoPHP($filaOpt[5],$obj,$cache);
					if($resEval!=1)
					{
						$publicarOpcion=false;
					}
				}
				$comp="";
				$cadOpc="";
				if($publicarOpcion)
				{
					switch($filaOpt[3])
					{
						case "1": //Contenido
						
							$arrDatos=explode("?",$filaOpt[2]);
							$idContenido=$filaOpt[4];
							$cadOpc="
										var idFormulario=gE('idFormularioAux').value;
										var idRegistro=gE('idRegistroAux').value;
										var arrParam=[['id',".$idContenido."],['cPagina','sFrm=true'],['idFormulario',idFormulario],['idRegistro',idRegistro]];
										var obj={}
										obj.titulo='".$filaOpt[1]."';
										obj.url='".$arrDatos[0]."';
										obj.params=arrParam;
										obj.ancho='95%';
										obj.alto='95%';
										abrirVentanaFancy(obj);
									";
		
						break;
						case "11": //Documento
		
							$arrDatos=explode(":",$filaOpt[2]);
							$cadOpc=$arrDatos[1].";";	
						break;
						case "0":  //pagina
							
							if(strpos($filaOpt[2],"print=1")===false)
							{
								if(strpos($filaOpt[2],"javascript")===false)
								{
									$cadOpc="
												var idFormulario=gE('idFormularioAux').value;
												var idRegistro=gE('idRegistroAux').value;
												
												var arrParam=[['cPagina','sFrm=true'],['idFormulario',idFormulario],['idRegistro',idRegistro]];
												var obj={}
												obj.titulo='".$filaOpt[1]."';
												obj.url='".$filaOpt[2]."';
												obj.params=arrParam;
												obj.ancho='95%';
												obj.alto='95%';
												abrirVentanaFancy(obj);
											";
								}
								else
								{
									$cadOpc=$filaOpt[2];
								}
							}
							else
							{
								
								$cadOpc="
											var idFormulario=gE('idFormularioAux').value;
											var idRegistro=gE('idRegistroAux').value;
											
											var arrParam=[['cPagina','sFrm=true'],['idFormulario',idFormulario],['idRegistro',idRegistro],['print',1]];
											enviarFormularioDatos('".$filaOpt[2]."',arrParam,'GET');
										";
							}
						break;
						
					}
					if($filaOpt[6]!="")
				{
	
					$comp='"icon":"../media/verBullet.php?id='.$filaOpt[0].'",';
				}
				
				$opt='	{

							text:"'.$filaOpt[1].'",'.$comp.'
							handler:function()
									{
										'.$cadOpc.'
									}
						}';
				if($arrMenu=="")
					$arrMenu=$opt;
				else
					$arrMenu.=",".$opt;
				}
			}
			if($arrMenu!="")
			{
				$obj='{"icon":"../images/bullet_green.png","text":"<b>'.$fila[1].'</b>","menu":['.$arrMenu.']}';	
				if($cadMenu=="")
					$cadMenu=$obj;
				else
					$cadMenu.=",".$obj;
			}
		}
	}
	
?>
var arrMenu=<?php echo "[".$cadMenu."]"?>;

Ext.onReady(inicializar);
var nodoSel=null;

var hActor;
var hDComp;
var hIdFormulario;
var hIdRegistro;
var arrParamConfiguraciones;
var vListadoRegistros=false;
function inicializar()
{
	if((window.opener!=null)&&(typeof(window.opener.ejecutarCargaDTD)!='undefined'))
    {
    	window.opener.ejecutarCargaDTD();
    }
	var arrBtn=eval(bD(gE('arrBtn').value));
    
    if(arrMenu.length>0)
    {
    	var x;
        for(x=0;x<arrMenu.length;x++)
        {
        	arrBtn.push(arrMenu[x]);
        }
    }
    
	hActor=gE('actor').value;
    hDComp=gE('dComp').value;
    hIdFormulario=gE('idFormularioAux').value;
    hIdRegistro=gE('idRegistroAux').value;
	var valPart=gE('participante').value;
	var IdUsuario=gE("idUsuario").value;
    var idProcesoPadre=gE('idProcesoP').value;
    var idRef=gE('idReferencia').value;

	Ext.QuickTips.init();
	var objParam={
                        actor:hActor,
                        dComp:hDComp,
                        idFormulario:hIdFormulario,
                        idRegistro:hIdRegistro,
                        cPagina:'sFrm=true',
                        participante:valPart,
                        idProcesoP:idProcesoPadre,
                        idReferencia:idRef,
                        idUsuario:IdUsuario
                    };
	var funcPHPEjecutarNuevo=gE('funcPHPEjecutarNuevo').value;                    
    if(funcPHPEjecutarNuevo!='')
    	objParam.funcPHPEjecutarNuevo=funcPHPEjecutarNuevo;
    var funcEJs=gE('funcEJs').value;                    
    if(funcEJs!='')
    	objParam.funcEJs=funcEJs; 
    var viewport = new Ext.Viewport({
            layout: 'border',
            items: [
           
            	 {
                    xtype: 'box',
                    region: 'north',
                    applyTo: 'header',
                    height: 30
                },
                {
                	layout:'border',
                    region: 'west',
                    id: 'menuDTD', 
                    title: 'Elementos',
                    margins: '2 0 5 5',
                    border: false,
                    split:true,
                    width: 240,
                    items:	[
                    			{
                                	 id:'idMenuDTD',
                                	 region:'center',
                                     autoScroll:true,
                                     autoLoad:	{
                                                     url:'../modeloPerfiles/menuDTD.php',
                                                     scripts:true,
                                                    
                                                     params:objParam
                                                }
                                }
                    		],
                    
                    collapsible: true,
                    margins: '0 0 0 5'
                   
                	
            },
            {
            	xtype:'panel',
                region:'center',
                tbar:arrBtn,
                layout:'border',
                items:	[
                            new Ext.ux.IFrameComponent({ 
                                
                                                            id: 'tblCenter', 
                                                            region:'center',
                                                            anchor:'100% 100%',
                                                            url: '../paginasFunciones/white.php',
                                                            style: 'width:100%;height:100%',
                                                            loadFuncion: function(el)
                                                                            {
                                                                                var body=gEx('tblCenter').getFrameDocument().getElementsByTagName('body');
                                                                                body[0].onclick=function(val)	
                                                                                                {
                                                                                                    window.parent.Ext.menu.MenuMgr.hideAll();
                                                                                                }
                                                                            } 
                                                    })
            
          				]
           }
           /* {
                region:'center',
                id:'tblCenter',
                tbar:arrBtn,
                autoScroll: true,
                xtype:'iframepanel',
                deferredRender: false,
               
                listeners:{
                				documentloaded:function(el)
                                			{
                                            	var body=el.getFrameDocument().getElementsByTagName('body');
                                                body[0].onclick=function(val)	
                                                				{
                                                                	window.parent.Ext.menu.MenuMgr.hideAll();
                                                                }
                                            } 
                			},
                loadMask:	{
                                msg:'Cargando'
                            }
            }*/
              ]
        });
}

function enviarFichaProyecto(idFrm,accion2)
{
	
    var Accion;
    
	if(idFrm==undefined)
    	idFrm=gE('idFormularioAux').value;
	if(accion2==undefined)
		Accion='<?php echo bE('ver')?>';
	else
    	Accion=accion2;    
    var hConf;
    var confO
    hConf=document.getElementsByName('confReferencia')[1];
    confO=hConf.value;
    var tblCenter=Ext.getCmp('tblCenter');
    if(accion2=='<?php echo base64_encode("modificar")?>')
    {
		var tblCenter=Ext.getCmp('tblCenter');
	    var documento=tblCenter.getFrameDocument();
    	var confRef=documento.getElementsByName('confReferencia')[0];
    	confO=confRef.value;
    }
    var idReg=gE('idRegistroAux').value;

    tblCenter.load(
    				{
                    	url:'../modeloPerfiles/proxyFormulario.php',
                        params:	{
                        			idRegistro:idReg,
                                    idFormulario:idFrm,
                                    idReferencia:gE('idReferencia').value,
                                    cPagina:'sFrm=true',
                                    accion:Accion,
                                    eJs:'<?php echo base64_encode("window.parent.enviarFichaProyecto();return")?>',
                                    confReferencia:confO
                                 }
                      }
                    );
    marcarEnlace('td_1');
}

function enviarPaginaIFrame(pagina,parametros)
{
	var tblCenter=Ext.getCmp('tblCenter');
	tblCenter.load({url:pagina,params:parametros, scripts:true});
}

function mostrarMenuDTD(idReg)
{

	if(typeof(idReg)!='undefined')
    {
    	regresar1Pagina();
    	redireccionarEtapa1(idReg);
        
    }
    else
    {
    	
    	recargarMenuDTD();
     }
}

function redireccionarEtapa1(idRegistro)
{
	gE('registroRecarga').value=idRegistro;
	gE('frmEnvioNuevo').submit();
    
}

function recargarMenuDTD()
{
	var idRegistro=gE('idRegistroAux').value;
    var idFrm=gE('idFormularioAux').value;
    var menuDTD=Ext.getCmp('idMenuDTD');
    var hActor=gE('actor').value;
    var hDComp=gE('dComp').value;
    var valPart=gE('participante').value;
    menuDTD.load(	{
                    	url:'../modeloPerfiles/menuDTD.php',
                        scripts:true,
                                                    
                        params:{
                                  actor:hActor,
                                  dComp:hDComp,
                                  idFormulario:idFrm,
                                  idRegistro:idRegistro,
                                  cPagina:'sFrm=true',
                                  refrescarContenido:'0',
                                  participante:valPart
                              }
                  	}
                );
}

function enviarPaginaEnlace(configuracion,td,accion)
{
	var pagina;
	switch(accion)
    {
    	case '<?php echo base64_encode("agregar")?>':
        	pagina=arrParamConfiguraciones[configuracion][0];	
        break;
        case '<?php echo base64_encode("ver")?>':
        	pagina=arrParamConfiguraciones[configuracion][2];
        break;
        case '<?php echo base64_encode("modificar")?>':
        	pagina=arrParamConfiguraciones[configuracion][0];	
        break;
    }
        	
    var objParametros=arrParamConfiguraciones[configuracion][1];
    objParametros.eJs='<?php echo base64_encode("window.parent.mostrarMenuDTD()")?>';
    objParametros.cPagina='sFrm=true';
    Ext.getCmp('tblCenter').load(
    								{
                                    	url:pagina,
                                        params:objParametros,
                                        scripts:true
                                    }	
    							)
    								
    
    marcarEnlace('td_'+td);
}

function marcarEnlace(id)
{
	/*var idMenuDTD=Ext.getCmp('idMenuDTD');
    idMenuDTD.getFrameWindow().marcarEnlace(id);*/
    var x;
    x=1;
    while(true)
    {
    	var td=gE('td_'+x);
        if(td==null)
         	return;
            
       	if(id=='td_'+x)
			setClase(td,'letraRoja');				     
        else
            setClase(td,'letraFicha');				     
        x++; 
    }
}

function enviarAsociado(idForm,td,action)
{
	var hConf;
    var confO;
    hConf=document.getElementsByName('confReferencia')[1];
    confO=hConf.value;
    var accion=action;
    var idRegistro=gE('idRegistroAux').value;
    var idFormularioAux=gE('idFormularioAux').value;
    var accionRedireccion=';window.parent.f.enviarAsociado('+idForm+','+idRegistro+',\''+accion+'\');return';
    var accionCancel='window.parent.f.enviarFichaProyecto('+idFormularioAux+',\''+bE('ver')+'\')';

    if(action=='<?php echo base64_encode("modificar")?>')
    {
        var tblCenter=Ext.getCmp('tblCenter');
	    var documento=tblCenter.getFrameDocument();
    	var confRef=documento.getElementsByName('confReferencia')[0];
        accionRedireccion=';window.parent.f.enviarAsociado('+idForm+','+idRegistro+',\'<?php echo base64_encode("ver")?>\');return';
        if(confRef)
        {
    		confO=confRef.value;
        	accionCancel='';
        }
        
       
    }
	
    
    var objParam=	{
    					cPagina:'sFrm=true',
    					idReferencia:idRegistro,
                        idFormulario:idForm,
                        idRegistro:'-1',
                        accion:action,
                        eJs:bE("window.parent.mostrarMenuDTD()"+accionRedireccion),
                        confReferencia:confO,
                        accionCancelar:bE(accionCancel)
    				}
    Ext.getCmp('tblCenter').load(
    								{
                                    	url:'../modeloPerfiles/proxyFormulario.php',
                                        params:objParam,
                                        scripts:true
                                    }	
    							)
    marcarEnlace('td_'+td);
    
}

function someter(msg,c,f)
{

	var solictarComentarios=false;
	var idReferencia=gE('idReferencia').value;
    if(window.opener)
    {
        var padreAux=window.opener.parent;
        var padre;
        if(idReferencia=='')
        {
            if(padreAux.document.URL.indexOf('vistaDTD')!=-1)
                padreAux=padreAux.opener.parent;
            if(padreAux.Ext.getCmp('content')!=undefined)
                padre=padreAux.Ext.getCmp('content').getFrameWindow().document.URL;
            else
                padre=padreAux.document.URL;
        }
        else
        {
            var tblCenter=padreAux.Ext.getCmp('tblCenter');
            if(tblCenter!=undefined)
                padre=tblCenter.getFrameWindow().document.URL;
            else
            {
                
                tblCenter=padreAux.Ext.getCmp('content');
                if(tblCenter!=undefined)
                    padre=tblCenter.getFrameWindow().document.URL;
                else
                    padre=null;
                
            }
        }
    }
    else
	    padre=null;
	var idRegistro=gE('idRegistroAux').value;
    var idFormulario=gE('idFormularioAux').value;
    var actor=gE('actor').value;
    var idParticipante=gE('idParticipante');
    if(idParticipante!=null)
    	actor=bE('-'+idParticipante.value);
    
    
   
    if(solictarComentarios)    
	    mostrarVentanaComentario (idFormulario,idRegistro,actor,msg,padre);
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
                        
                        if(gE('idProcesoP').value=='-1')
                        {
                        	
                            if(padre!=null)
                            {
                            	
								if(bD(f)=='')
                                {
                                    if(padre.indexOf('modeloProyectos/registros.php')!=-1)
                                    {
    									
                                        regresar1Pagina(true)
                                    }
                                    else
                                    {
                                    	
    
                                        regresar2Pagina(true);
                                    }
                            	}
                                
                            }
                            else
                            {
                            	
                            	if(bD(f)=='')
                                {
                                	
                                    if(window.opener.funcionAntesCerrar!=undefined)
                                    {
                                    	
                                        window.opener.funcionAntesCerrar();
                                    }
                                }
                                else
                                {
                                	
                                	eval(bD(f));


                                }
                                if(bD(c)=='1')
	                                window.close();
                            
                            }
                        }
                        else
                        {
                        	
							if(window.opener)//verificar
                            {	
                            	
                                if(window.opener.recargarContenedorCentral!=undefined)
                                    window.opener.recargarContenedorCentral() ;
                                else
                                {
                                    if(bD(f)=='')
                                    {
                                        if(padre!=null)
                                        {
                                        
                                          if(padre.indexOf('modeloProyectos/registros.php')!=-1)
                                          {
                                        	
                                              regresar1Pagina(true)
                                          }
                                          else
                                          {
                                          	
                                              regresar2Pagina(true);
                                          }
                                        }
                                        else
                                        {
                                        
                                          if(window.opener.funcionAntesCerrar!=undefined)
                                              window.opener.funcionAntesCerrar();
                                        }
                                    }
                                    else
                                    {
                                        eval(bD(f));
                                    }
                                }
                                if(bD(c)=='1')
                                    window.close();
                          }
                          else
                          {
                          	window.close();
                          }
                        }
                    }
                    else
                    {
                    	if(arrResp[0].indexOf('[')==0)
                        {
                            var arrErr=eval(arrResp[0]);
                            window.parent.mostrarVentanaError(arrErr);
                        }
                        else
	                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=39&comentario=&idFormulario='+idFormulario+'&idRegistro='+idRegistro+'&actor='+actor+'&idPerfil='+gE('idPerfil').value,true);
    
            }
        }
        msgConfirm(bD(msg),resp);
    }
}

function mostrarVentanaComentario(idFormulario,idRegistro,actor,msg,padre)
{

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Si lo desea puede ingrese un comentario que acompañe a su registro:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            id:'txtComentario',
                                                            width:430,
                                                            height:90
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: lblAplicacion,
										width: 480,
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
                                                                	gEx('txtComentario').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var comentario=gEx('txtComentario').getValue();
                                                                    	function resp(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {
                                                                            	ventanaAM.close();
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                    	
																						if(gE('idProcesoP').value=='-1')
                                                                                        {
                                                                                            if(padre!=null)
                                                                                            {
    
                                                                                                if(padre.indexOf('modeloProyectos/registros.php')!=-1)
                                                                                                {
    
                                                                                                    regresar1Pagina(true)
                                                                                                }
                                                                                                else
                                                                                                {
    
                                                                                                    regresar2Pagina(true);
                                                                                                }
                                                                                            }
                                                                                            else
                                                                                            {
    
                                                                                                if(window.opener.funcionAntesCerrar!=undefined)
                                                                                                    window.opener.funcionAntesCerrar();
                                                                                                window.close();
                                                                                            
                                                                                            }
                                                                                    	}
                                                                                        else
                                                                                        {
                                                                                        	if(window.opener.recargarContenedorCentral!=undefined)
	                                                                                        	window.opener.recargarContenedorCentral() ;
                                                                                            else
                                                                                            {
                                                                                                 if(padre!=null)
                                                                                                {
                                                                                                
                                                                                                  if(padre.indexOf('modeloProyectos/registros.php')!=-1)
                                                                                                  {
                                                                                                
                                                                                                      regresar1Pagina(true)
                                                                                                  }
                                                                                                  else
                                                                                                  {
                                                                                                
                                                                                                      regresar2Pagina(true);
                                                                                                  }
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                
                                                                                                  if(window.opener.funcionAntesCerrar!=undefined)
                                                                                                      window.opener.funcionAntesCerrar();
                                                                                                  
                                                                                                
                                                                                                }
                                                                                            }
                                                                                            
                                                                                            window.close();
                                                                                        }
                                                                                        
                                                                                            
                                                                                        
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                    	if(arrResp[0].indexOf('[')==0)
                                                                                        {
                                                                                            var arrErr=eval(arrResp[0]);
                                                                                            window.parent.mostrarVentanaError(arrErr);
                                                                                        }
                                                                                        else
                                                                                        	msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=39&comentario='+cv(comentario)+'&idFormulario='+idFormulario+'&idRegistro='+idRegistro+'&actor='+actor,true);
                                                                    
                                                                            }
                                                                        }
                                                                        Ext.MessageBox.confirm(lblAplicacion,bD(msg),resp);
																		
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

function asignarRevisores()
{
	var idForm=gE('idFormularioAux').value;
	var idReg=gE('idRegistroAux').value;
    var idActor=gE('actor').value;
    var etapaReg=gE('etapaReg').value;
    var cPag='sFrm=true';
	var objParam=	{
                        idFormulario:idForm,
                        idRegistro:idReg,
                        cPagina:cPag,
                        idActorProcesoEtapa:idActor,
                        nEtapa:etapaReg
                  	};
                    
    var tblCenter=Ext.getCmp('tblCenter').load	(
    												{
                                                    	url:'../modeloProyectos/revisores.php',
                                                        params:objParam,
                                                        scripts:true
                                                    }
    											)
}

function actualizarSituacionDictamen()
{
	var idRegistro=gE('idRegistroAux').value;
    var idFrm=gE('idFormularioAux').value;
    var menuDTD=Ext.getCmp('idMenuDTD');
    var hActor=gE('actor').value;
    var hDComp=gE('dComp').value;
    var valPart=gE('participante').value;
    menuDTD.load(	{
                    	url:'../modeloPerfiles/menuDTD.php',
                        scripts:true,
                                                    
                        params:{
                                  actor:hActor,
                                  dComp:hDComp,
                                  idFormulario:idFrm,
                                  idRegistro:idRegistro,
                                  cPagina:'sFrm=true',
                                  participante:valPart
                                  
                              }
                  	}
                );
	regresar1Pagina(true);                
}

function verDictamenRevisor(idFrm,idReg)
{
	var cPag='sFrm=true';
	var arrParam={
    				idFormulario:idFrm,
                    idRegistro:idReg,
                    cPagina:cPag
                 };
    
    var tblCenter=Ext.getCmp('tblCenter').load	(
    												{
                                                    	url:'../modeloPerfiles/verFichaFormulario.php',
                                                        params:arrParam,
                                                        scripts:true
                                                    }
    											) 
	                                                       
}

function regresar1Pagina(cerrarVentana)
{
	var idReferencia=gE('idReferencia').value;
	var padre=window.opener.parent;

	if((idReferencia=='')||(idReferencia=='-1'))
    {

    	if(padre.document.URL.indexOf('vistaDTD')!=-1)
            padre=padre.opener.parent;
        padre.recargarContenedorCentral();
	}
    else
    {
		if(gE('idProcesoP').value=='-1')
        {
            if(padre.regresar1PaginaContenedor!=undefined)
                padre.regresar1PaginaContenedor();
        }
        else
        {
			 padre.recargarContenedorCentral() ;
            
        }
    
    }
    if(cerrarVentana!=undefined)
		window.close();	
    
}

function regresar2Pagina(cerrarVentana)
{
	var idReferencia=gE('idReferencia').value;
	var padre=window.opener.parent;
    
	if((idReferencia=='')||(idReferencia=='-1'))
    {
        if(padre.document.URL.indexOf('vistaDTD')!=-1)
 	       padre=padre.opener.parent;
        padre.regresarContenedorCentral();
	}
    else
    {
    	if(padre.regresarPagina2Contenedor!=undefined)
	    	padre.regresarPagina2Contenedor();
        else
        	 padre.regresarContenedorCentral();

    }
    if(cerrarVentana!=undefined)
		window.close();	

}

function regresar1PaginaContenedor()
{
	var content=Ext.getCmp('tblCenter');
    content.getFrameWindow().recargarPagina();
}

function regresarPagina2Contenedor()
{
	var content=Ext.getCmp('tblCenter');
    content.getFrameWindow().regresarPagina();
}

function bloquearElemento(f,r)
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
                	mostrarMenuDTD();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=78&idFormulario='+f+'&idReferencia='+r,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer bloquear este elemento para evitar su edici&oacute;n?',resp)
}

function quitarBloqueo(f,r)
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
                	mostrarMenuDTD();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=79&idFormulario='+f+'&idReferencia='+r,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer eliminar el bloqueo de edici&oacute;n que tiene este elemento?',resp)
}

function realizarDictamenFinal(idFrm,idRef)
{
	
	var cPag='sFrm=true';
	var arrParam={
    				paginaRedireccion:'../paginasFunciones/white.php',
    				idFormulario:idFrm,
                    idRegistro:'-1',
                    idReferencia:idRef,
                    idPerfil:gE('idPerfil').value,
                    cPagina:cPag,
                    eJs:'<?php echo base64_encode("window.parent.accionDictamenFinal();")?>',
                    accionCancelar:'window.parent.funcionInicio();',
                    paginaRedireccion:'../paginasFunciones/white.php'
                 };
    var tblCenter=Ext.getCmp('tblCenter').load	(
    												{
                                                    	url:'../modeloPerfiles/registroFormulario.php',
                                                        params:arrParam,
                                                        scripts:true
                                                    }
    											)            


}

function verDictamenFinal(idFrm,idReg)
{
	var cPag='sFrm=true';
	var arrParam={
    				idFormulario:idFrm,
                    idRegistro:idReg,
                    cPagina:cPag
                 };
     var tblCenter=Ext.getCmp('tblCenter').load	(
    												{
                                                    	url:'../modeloPerfiles/verFichaFormulario.php',
                                                        params:arrParam,
                                                        scripts:true
                                                    }
    											)            
}

function accionDictamenFinal()
{
	if(gE('idProcesoP').value=='-1')
    {
        if(typeof(window.opener.ejecutarFuncionCambioEstado)=='undefined' )
        {
            var padreAux=window.opener.parent;
            if(padreAux.document.URL.indexOf('vistaDTD')!=-1)
                padreAux=padreAux.opener.parent;
            var padre=padreAux.Ext.getCmp('content').getFrameWindow().document.URL;
            if(padre.indexOf('modeloProyectos/registros.php')!=-1)
                regresar1Pagina(true)
            else
                regresar2Pagina(true);
        }
        else
        {
        
            window.opener.ejecutarFuncionCambioEstado(gE('idRegistroAux').value,gE('idFormularioAux').value,gE('idReferencia').value);
            window.close();
        }
	}
    else
    {
    	if(window.opener.recargarContenedorCentral!=undefined)
            window.opener.recargarContenedorCentral() ;
        window.close();
    }

}

function realizarDictamenRevisor(idFrm,idRef)
{	

	var cPagina='sFrm=true';
	var arrParam=	{
    					paginaRedireccion:'../paginasFunciones/white.php',
    					idFormulario:idFrm,
                    	idRegistro:'-1',
                        idReferencia:bD(idRef),
                    	cPagina:cPagina,
                        eJs:'<?php echo base64_encode("window.parent.actualizarSituacionDictamen();")?>'
                    };
     var tblCenter=Ext.getCmp('tblCenter').load	(
    												{
                                                    	url:'../modeloPerfiles/registroFormulario.php',
                                                        params:arrParam,
                                                        scripts:true
                                                    }
    											)            

}

function realizarDictamenP(idFrm,idRef)
{
	var cPag='sFrm=true';
	var arrParam={
    				paginaRedireccion:'../paginasFunciones/white.php',
    				idFormulario:idFrm,
    				idFormulario:idFrm,
                    idRegistro:'-1',
                    idPerfil:gE('idPerfil').value,
                    idReferencia:idRef,
                    cPagina:cPag,
                    eJs:bE("window.parent.mostrarMenuDTD();window.parent.verDictamenP("+idFrm+",@idRegistro);")
                 };
    var tblCenter=Ext.getCmp('tblCenter').load	(
    												{
                                                    	url:'../modeloPerfiles/registroFormulario.php',
                                                        params:arrParam,
                                                        scripts:true
                                                    }
    											)
}

function verDictamenP(idFrm,idReg)
{
	var cPag='sFrm=true';
	var arrParam={
    				idFormulario:idFrm,
                    idRegistro:idReg,
                    cPagina:cPag
                  };
    var tblCenter=Ext.getCmp('tblCenter').load	(
    												{
                                                    	url:'../modeloPerfiles/verFichaFormulario.php',
                                                        params:arrParam,
                                                        scripts:true
                                                    }
    											)
  
}

function verOtrosDictamenes()
{
	var gridDictamenes=crearGridDictamenes();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                        	html:'Listado de dict&aacute;menes asociados al registro:'
                                                        },
                                                        gridDictamenes
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Dict&aacute;menes asociados al registro',
										width: 820,
										height:315,
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
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	llenarOtrosDictamenes(ventanaAM,gridDictamenes);
}

function crearGridDictamenes()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idDictamen'},
                                                                {name: 'responsable'},
                                                                {name: 'situacion'},
                                                                {name: 'fechaDictamen'},
                                                                {name: 'idReferencia'},
                                                                {name: 'idFormulario'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Responsable del dict&aacute;men',
															width:320,
															sortable:true,
															dataIndex:'responsable'
														},
														{
															header:'Situaci&oacute;n',
															width:150,
															sortable:true,
															dataIndex:'situacion'
														},
                                                        {
															header:'Fecha dict&aacute;men',
															width:90,
															sortable:true,
															dataIndex:'fechaDictamen'
														},
                                                        {
															header:'',
															width:130,
															sortable:true,
															dataIndex:'idReferencia',
                                                            renderer:function(val,ambito,registro)
                                                            		{
                                                                    	var idFormulario=registro.get('idFormulario');
                                                                    	if(val!='')
                                                                        {
                                                                        	return '<a href="javascript:verDictamen('+val+','+idFormulario+')"><img src="../images/icon_document.gif" />&nbsp;Ver dict&aacute;men'
                                                                        }
                                                                        return '';
                                                                    }
                                                        }
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridDictamenes',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:180,
                                                            width:770
                                                        }
                                                    );
	return 	tblGrid;
}

function llenarOtrosDictamenes(ventanaAM,gridDictamenes)
{
	var idProceso=gE('idProceso').value;
    var etapaReg=gE('etapaReg').value;
    var actor=gE('hActorMenuDTD').value;
    var idReg=gE('idRegistroAux').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gridDictamenes.getStore().loadData(eval(arrResp[1]));
        	ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=174&idProceso='+idProceso+'&actor='+actor+'&etapa='+etapaReg+'&idRegistro='+idReg,true);
    
}

function verDictamen(val,idFrm)
{
	var idFormulario=idFrm;
    var arrDatos=[['idFormulario',idFormulario],['idRegistro',val],['cPagina','sFrm=true']];
    window.parent.open('',"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
	window.parent.enviarFormularioDatos('../modeloPerfiles/verFichaFormulario.php',arrDatos,'POST','vAuxiliar');
	
}

function enviarProcesoVinculado(iR,iPP,iPV,iU,a,sl,tipoVista,tVisor)
{
	var cPag='sFrm=true';
	if(bD(tVisor)=='1')
    {
    	var arrParam={
    				
                        idProcesoP:iPP,
                        idReferencia:iR,
                        idProceso:iPV,
                        cPagina:cPag,
                        idUsuario:iU,
                        relacion:bE('1'),
                        actor:bD(a),
                        sL:bD(sl),
                        tVista:tipoVista
                        
                     };
        var tblCenter=Ext.getCmp('tblCenter').load	(
                                                        {
                                                            url:'../modeloProyectos/registros.php',
                                                            params:arrParam,
                                                            scripts:true
                                                        }
                                                    )
	}
    else
    {
        vListadoRegistros=true;                                          
        var arrParam={
                        
                        idProcesoP:bD(iPP),
                        idReferencia:bD(iR),
                        idProceso:bD(iPV),
                        cPagina:cPag,
                        idUsuario:bD(iU),
                        relacion:'1',
                        actor:bD(a),
                        sL:bD(sl),
                        tVista:bD(tipoVista)
                     };
        var tblCenter=Ext.getCmp('tblCenter').load	(
                                                        {
                                                            url:'../modeloPerfiles/vistaProcesos.php',
                                                            params:arrParam,
                                                            scripts:true
                                                        }
                                                    )    
	}                                                            
}

function regresarContenedorCentral()
{
	var content=Ext.getCmp('tblCenter');
    content.getFrameWindow().regresarPagina();
}

function asignarComites(eR)
{
	var idForm=gE('idFormularioAux').value;
	var idReg=gE('idRegistroAux').value;
    var idActor=gE('actor').value;
    var cPag='sFrm=true';
	var objParam=	{
                        idFormulario:idForm,
                        idRegistro:idReg,
                        cPagina:cPag,
                        etapaRef:eR
                  	};
                    
    var tblCenter=Ext.getCmp('tblCenter').load	(
    												{
                                                    	url:'../modeloProyectos/asignacionComite.php',
                                                        params:objParam,
                                                        scripts:true
                                                    }
    											)
}

function enviarAEtapa(e)
{
    var idRegistro=gE('idRegistroAux').value;
    var idFormulario=gE('idFormularioAux').value;
    var actor=gE('actor').value;
    var idParticipante=gE('idParticipante');
    if(idParticipante!=null)
    	actor=bE('-'+idParticipante.value);
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            regresar2Pagina(true);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=191&nEtapa='+e+'&idFormulario='+idFormulario+'&idRegistro='+idRegistro+'&actor='+actor,true);
}

function mostrarVersionesAnteriores()
{
	var gridVersiones=crearGridVersiones();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridVersiones

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'wVersiones',
										title: 'Versiones del registro',
										width: 500,
										height:450,
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

function crearGridVersiones()
{
	var dsDatos=eval(gE('regVersiones').value);
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'version'},
                                                                {name: 'fechaCreacion'},
                                                                {name: 'verFicha'},
                                                                {name: 'elaboro'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														
														{
															header:'Versi&oacute;n',
															width:100,
															sortable:true,
															dataIndex:'version'
														},
														{
															header:'Fecha creaci&oacute;n',
															width:120,
															sortable:true,
															dataIndex:'fechaCreacion'
														},
                                                        {
															header:'Elaborado por',
															width:180,
															sortable:true,
															dataIndex:'elaboro'
														},
                                                        {
                                                        	hidden:true,
															header:'',
															width:170,
															sortable:true,
															dataIndex:'verFicha',
                                                            renderer:function(val)
                                                            		{
                                                                    	return '<a href=javascript:verVersion("'+bE(val+'')+'")><img src="../images/lupa.png" height="13" width="13" /> Observar versi&oacute;n</a>';
                                                                    	
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridVersiones',
                                                            x:10,
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:290,
                                                            width:450,
                                                            tbar:	[
                                                            			{
                                                                        	text:'Comparar versiones',
                                                                            icon:'../images/page_white_magnify.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaVersiones();
                                                                                        
                                                                                    }
                                                                        }
                                                            		]
                                                           
                                                        }
                                                    );
	return 	tblGrid;		
}

function mostrarVentanaVersiones()
{
	var idRegistro=gE('idRegistroAux').value;
	var idProceso=gE('idProceso').value;
	var arrVersiones=[];
    
    var gridVersiones=gEx('gridVersiones');
    var x;
    var obj;
    var fila;
    for(x=0;x< gridVersiones.getStore().getCount();x++)
    {
    	fila=gridVersiones.getStore().getAt(x);
    	obj=new Array();
        obj[0]=fila.get('version');
        obj[1]=fila.get('version');
    	arrVersiones.push(obj);
        
    }
    var vActual=gE('vActual').value;
    obj=new Array();
	obj[0]='-'+vActual;
    obj[1]='Version actual';
    arrVersiones.push(obj);
    
	gEx('wVersiones').close();
    var cmbVersion1=crearComboExt('cmbVersion1',arrVersiones,130,5);
    cmbVersion1.setWidth(115);
    var cmbVersion2=crearComboExt('cmbVersion2',arrVersiones,130,35);
    cmbVersion2.setWidth(115);
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Versi&oacute;n base:'
                                                        },
                                                        cmbVersion1,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Comparar con versi&oacute;n:'
                                                        },
                                                        cmbVersion2

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Comparar versiones de registro',
										width: 350,
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
																		if(cmbVersion1.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbVersion1.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar la versi&oacute;n base que se usar&aacute; como referencia de comparaci&oacute;n',resp1);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbVersion2.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbVersion2.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar la versi&oacute;n con la cual se comparar&aacute; la versi&oacute;n base',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(cmbVersion1.getValue()==cmbVersion2.getValue())
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbVersion2.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar diferentes versiones para comparar',resp3);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var arrDatos=[['cPagina','sFrm=true'],['idProceso',idProceso],['idRegistro',idRegistro],['version1',cmbVersion1.getValue()],['version2',cmbVersion2.getValue()]];
                                                                        window.open('',"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
                                                                        enviarFormularioDatos('../modeloProyectos/compararXMLProceso.php',arrDatos,'POST','vAuxiliar');
                                                                        ventanaAM.close();
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

function verCandidatos(iS,idFormulario)
{
	crearVentanaSolicitantes(iS,idFormulario)
}

function elegirCandidato(iS)
{
    crearVentanaSeleccionados(bD(iS));
}

function contratarCandidato(iS)
{

}


function crearVentanaSolicitantes(iS)
{
	var idFormulario=gE('idFormularioAux').value;
	var gridC=crearGridC()
    var gridResultado=crearGridResul(iS);
    var ventana = new Ext.Window(
									{
                                    	id:'vCandidatos',
										width: 750,
										height:600,
										minWidth: 200,
										minHeight: 100,
										layout: 'absolute',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: [
                                        		  gridC,
                                                  gridResultado
                                                ]
                                        ,
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
															text: 'Cerrar',
															handler:function()
																	{
																		ventana.close();
																	}
														}
													]
									}
								);
	function funcAjax2()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1') 
        {
            if(arrResp[1]=='1')
            {
            	var arreglo=eval(arrResp[2]);
            }
            else
            {
            	var arreglo=[];
            }
            
            var grid=Ext.getCmp('gCalculos');
            grid.getStore().loadData(arreglo);
             
             ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesRecursosHumanos.php',funcAjax2, 'POST','funcion=6&idSolicitud='+bD(iS)+'&idFormulario='+(idFormulario),true);                                
     
}

function crearGridC(iS,idFormulario)
{
    var arrDatos=[];
    var dSetCalculos= new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    
                                                                    {name:'idCalculo'},
                                                                    {name:'nombreCalculo'},
                                                                    {name:'puntos'},
                                                                    {name:'tieneP'},
                                                                    {name: 'arrP'}
                                                                ]
                                                    }
                                                 )
    
	dSetCalculos.loadData(arrDatos);	
	var columnaCheck=new Ext.grid.CheckboxSelectionModel();
    var cmP= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            columnaCheck,
                                                            {
                                                                header:'Criterio',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'nombreCalculo'
                                                            },
                                                            {
                                                                header:'Puntos',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'puntos',
                                                                hidden:true
                                                            },
                                                            {
                                                                header:'Variables',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'tieneP',
                                                                renderer:function(val,meta,registro)
                                                                				{
                                                                					if(val==0)
                                                                                    {
                                                                                    	return '';
                                                                                    }    
                                                                                    else
                                                                                    {
                                                                                    	if(val=='')
                                                                                        {
                                                                                        	return '';
                                                                                        }
                                                                                        else
                                                                                        {   
                                                                                    		//return 'hola';
                                                                                            return '<a href="javascript:verParametros('+registro.get('idCalculo')+','+registro.get('arrP')+')"><img height="13" width="13" src="../images/magnifier.png" alt="Ver parametros" title="Ver parametros" /></a>';    
                                                                                        } 
                                                                                     }      
                                                                                }
                                                            }
                                                        ]
                                                    );
											
	var gridCalculos=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                    	x:10,
                                                        y:10,
														id:'gCalculos',
                                                        store:dSetCalculos,
                                                        frame:true,
                                                        cm: cmP,
                                                        sm:columnaCheck,
                                                        height:230,
                                                        width:700,
                                                        title:'Ingrese los criterios a considerar para realizar la b&uacute;squeda de candidatos a la vacante',
                                                        tbar:[
                                                            	  {
                                                                      text:'Agregar Criterio',
                                                                      icon:'../images/add.png',
                                                                      cls:'x-btn-text-icon',
                                                                      handler:function()
                                                                          {
                                                                              agregarCalculo();
                                                                          }
                                                                  },
                                                                  {
                                                                      text:'Remover Criterio',
                                                                      icon:'../images/cancel_round.png',
                                                                      cls:'x-btn-text-icon',
                                                                      handler:function()
                                                                          {
                                                                              removerCalculo();
                                                                          }
                                                                  },
                                                                  {
                                                                      text:'Obtener candidatos',
                                                                      icon:'../images/users.png',
                                                                      cls:'x-btn-text-icon',
                                                                      handler:function()
                                                                          {
                                                                             	obtenerCandidatos();
                                                                          }
                                                                  }
                                                                 ]
													}
    											);
	return gridCalculos;
}

var regCriterio=crearRegistro([
                                                                    
                                  {name:'idCalculo'},
                                  {name:'nombreCalculo'},
                                  {name:'puntos'},
                                  {name:'tieneP'},
                                  {name:'arrP'}
                              ]);

function agregarCalculo()
{
    var arregloC=<?php echo $arregloCalc ?>;
    var comboCalculos=crearComboExt('comboCalculos',arregloC,70,10);
    var form2 = new Ext.form.FormPanel(	
										{
                                        	id:'formulario2',
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[ 
                                                        {
                                                            xtype:'label',
                                                            x:15,
                                                            y:15,
                                                            html:'<span><b>Criterio:</b></span>'
                                                        },
                                                        comboCalculos,
                                                        {
                                                            xtype:'label',
                                                            x:15,
                                                            y:40,
                                                            html:'<span><b>Puntos:</b></span>',
                                                            hidden:true
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            x:70,
                                                            y:35,
                                                            width:60,
                                                            id:'puntosC',
                                                            hidden:true
                                                        }
													]
										}
									);

    
    var ventana = new Ext.Window(
									{
										title: 'Agregar Criterio',
										width: 300,
										height:170,
										minWidth: 300,
										minHeight: 100,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form2,
                                        id:'ventana2',
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
															text: 'Aceptar',
															listeners:	{
																			click:function()
																				{
																					var idCalculo=Ext.getCmp('comboCalculos').getValue();
                                                                                    if(idCalculo=='')
                                                                                    {
                                                                                     	msgBox('Debe indicar el criterio a utilizar');
                                                                                        return;
                                                                                    }
                                                                                    
                                                                                    var puntosC=Ext.getCmp('puntosC').getValue();
                                                                                    if(puntosC=='')
                                                                                    {
                                                                                     	puntosC=0;
                                                                                    }
                                                                                    
                                                                                    var idC=idCalculo;
                                                                                    var almacenP=Ext.getCmp('gCalculos').getStore();
                                                                                    var pos=obtenerPosFila(almacenP,'idCalculo',idC);
                                                                                    if(pos==-1)
                                                                                    {
                                                                                        function funcAjax()
                                                                                        {
                                                                                            var resp=peticion_http.responseText;
                                                                                            arrResp=resp.split('|');
                                                                                            if(arrResp[0]=='1')
                                                                                            {
                                                                                                var arrDatos=eval(arrResp[1]);
                                                                                                if(arrDatos.length>0)
                                                                                                {
                                                                                                    ventana.close();
                                                                                                    tb_show(lblAplicacion,'../recursosHumanos/parametrosFiltro.php?cPagina='+cv('mPie=false|mI=false|b=false|mR1=false')+'&idCalculo='+idCalculo+'&TB_iframe=true&height=420&width=650',"","scrolling=yes");
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    var iC=idCalculo;
                                                                                                    var titulo=Ext.getCmp('comboCalculos').getRawValue();
                                                                                                    var param=bE('{}');
                                                                                                    var tiene=0;
                                                                                                    var r=new regCriterio({idCalculo:iC,nombreCalculo:titulo,puntos:puntosC,tieneP:tiene,arrP:param});
                                                                                                    var gCalculos=gEx('gCalculos');
                                                                                                    gCalculos.getStore().add(r);
                                                                                                    ventana.close();
                                                                                                }
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesRecursosHumanos.php',funcAjax, 'POST','funcion=7&idCalculo='+idCalculo,true);
                                                                                    }   
                                                                                    else
                                                                                    {
                                                                                    	ventana.close();
                                                                                    }
                                                                                }	
																		}
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
                                                                        ventana.close();
																	}
														}
													]        
									}
								);
        ventana.show();
}

function obtenerCandidatos()
{
	var filas=gEx('gCalculos').getStore().getCount();
    if(filas==0)
    {
    	msgBox('Debe agregar al menos un criterio de busqueda');
        return;
    }
    var gCalculos=gEx('gCalculos')	;
    var x;
    var filas;
    var cadObj='';
    var obj='';
    for(x=0;x<gCalculos.getStore().getCount();x++)
    {
    	filas=gCalculos.getStore().getAt(x);
        obj='{"idCalculo":"'+filas.get('idCalculo')+'","param":"'+filas.get('arrP')+'"}';
        if(cadObj=='')
        	cadObj=obj;
        else
        	cadObj+=','+obj;
            
    }
    cadObj='['+cadObj+']';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
         	var arreglo=eval(arrResp[1]);
            var almacen=gEx('gRes').getStore().loadData(arreglo);   
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProgAcademico.php',funcAjax, 'POST','funcion=136&cadObj='+cadObj,true);
}

function crearGridResul(iS)
{
	var arrDatos=[];
    var dSetResul= new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name:'idUsuario'},
                                                                    {name:'nombreUsuario'},
                                                                    {nmae: 'puntos'}
                                                                ]
                                                    }
                                                 )
    
	dSetResul.loadData(arrDatos);	
	var columnaCheck=new Ext.grid.CheckboxSelectionModel();
    var cmP= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            columnaCheck,
                                                            {
                                                                header:'Candidato',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'nombreUsuario',
                                                                renderer:function(val,meta,registro)
                                                                				{
                                                                					if(val=='')
                                                                                    	return '';
                                                                                    else
                                                                                    	return '<a href="javascript:verUsrNuevaPagina(\''+bE(registro.get('idUsuario'))+'\')">'+val+'</a>';    
                                                                                }
                                                            },
                                                            {
                                                            	header:'Puntos',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'puntos',
                                                                hidden:true
                                                            }
                                                        ]
                                                    );
											
	var gridRes=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                    	x:10,
                                                        y:280,
														id:'gRes',
                                                        store:dSetResul,
                                                        frame:true,
                                                        cm: cmP,
                                                        sm:columnaCheck,
                                                        height:230,
                                                        width:700,
                                                        title:'Resultado de busqueda',
                                                        tbar:[
                                                            	  {
                                                                      text:'Marcar Candidato',
                                                                      icon:'../images/add.png',
                                                                      cls:'x-btn-text-icon',
                                                                      handler:function()
                                                                          {
                                                                              marcarCandidato(iS);
                                                                          }
                                                                  }
                                                                 ]
													}
    											);
	return gridRes;
}

function seleccionar(iS)
{
    var vGrid=Ext.getCmp('deptos');
    var modeloSel=vGrid.getSelectionModel();
    var fila=modeloSel.getSelections();
    var tamano=fila.length;
    if(tamano==0)
    {
        msgBox('Debe seleccionar un candidato');
        return;
    }
    
    var cadena='';
    var gridS=Ext.getCmp('deptosServicio');
    for(x=0;x< tamano;x++)
    {
        var codDepto=fila[x].get('idUsuario');
       
            if(cadena!='')
               cadena+=','+codDepto;
            else
               cadena=codDepto;
    }		
    
    
     function funcAjax()
      {
          var resp=peticion_http.responseText;
          arrResp=resp.split('|');
          if(arrResp[0]=='1') 
          {
            	gEx('vCandidatos').close();
          }
          else
          {
              msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
          }
      }
      obtenerDatosWeb('../paginasFunciones/funcionesPlaneacion.php',funcAjax, 'POST','funcion=109&idSolicitud='+iS+'&cadena='+cadena,true);
       
}

function crearVentanaSeleccionados(iS)
{
	var grid2=crearGrid2(iS)
    var ventana1 = new Ext.Window(
									{
                                    	id:'vSelCandidato',
										width: 700,
										height:400,
										minWidth: 200,
										minHeight: 100,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: [
                                        		 grid2
                                                ]
                                        ,
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
															text: 'Cerrar',
															handler:function()
																	{
																		ventana1.close();
																	}
														}
													]
									}
								);
                                
	
        function funcAjax2()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1') 
            {
                var arreglo=eval(arrResp[1]);
                grid2.getStore().loadData(arreglo);
                ventana1.show();
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesPlaneacion.php',funcAjax2, 'POST','funcion=110&idSolicitud='+iS+'&idFormulario='+hIdFormulario,true);
                               
      
}

function crearGrid2(iS)
{
	var arrDatos=[];
    var dSetDeptos= new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    
                                                                    {name:'idUsuario'},
                                                                    {name:'nombre'}
                                                                ]
                                                    }
                                                 )
    
	dSetDeptos.loadData(arrDatos);	
	var columnaCheck=new Ext.grid.CheckboxSelectionModel();	
	var cmDeptosS= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}),
                                                            columnaCheck,
                                                            {
                                                                header:'Empleado',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'nombre'
    
                                                            },
                                                            {
															header:'Ver Ficha',
															width:200,
															sortable:true,
                                                            renderer:function(val,ambito,registro)
                                                            {
                                                                    var id=registro.get('idUsuario');
                                                                    return '<a href="javascript:verUsrNuevaPagina(\''+bE(id)+'\')"><img height="16" width="16" src="../images/magnifier.png" alt="Ver Ficha" title="Ver Ficha"/></a>';
                                                            }
														}
                                                        ]
                                                    );
											
												
	tblDeptos=	new Ext.grid.GridPanel	(
                                                    {
                                                    	x:10,
                                                        y:10,
														id:'selecionados',
                                                        title:'Listado de candidatos al puesto',
                                                        store:dSetDeptos,
                                                        frame:true,
                                                        cm: cmDeptosS,
                                                        sm:columnaCheck,
                                                        height:350,
                                                        width:550
													}
    											);
	return tblDeptos;
}

function marcarCandidato(iS)
{
	var filas=Ext.getCmp('gRes').getSelectionModel().getSelections();
    var tamano=filas.length;
    if(tamano==0)
    {
    	msgBox('Debe seleccionar al menos un candidato');
        return;
    }
    
    var cadena='';
    var x;
    
    for(x=0;x< tamano;x++)
    {
    	var idUsuario=filas[x].get('idUsuario');
        
        if(cadena=='')
        	cadena=idUsuario;
        else
        	cadena+=','+idUsuario;    
    } 
    
    function funcAjax2()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1') 
        {
            var ventana=Ext.getCmp('vCandidatos');
            ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesRecursosHumanos.php',funcAjax2, 'POST','funcion=10&idFormulario='+hIdFormulario+'&idSolicitud='+bD(iS)+'&cadena='+cadena,true);
}

function removerCalculo()
{
	var filas=Ext.getCmp('gCalculos').getSelectionModel().getSelections();
    if(filas.length==0)
    {
    	msgBox('Debe seleccionar al menos un criterio');
        return;
    }
    
    var almacen=Ext.getCmp('gCalculos').getStore();
    almacen.remove(filas);
}

function mostrarGridComentarios()
{
	var gridComentarios=crearGridComentarios();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridComentarios

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Comentarios',
										width: 800,
										height:450,
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

function crearGridComentarios()
{
	
	 var alDatos= new Ext.data.JsonStore({
                                            
                                            totalProperty :'numReg',
                                            fields: [
                                            			{name: 'fechaComentario', type:'date'},
                                                        {name: 'actorComentario'},
                                                        {name: 'dictamen'},
                                                        {name: 'comentario'},
                                                        {name: 'idFormulario'},
                                                        {name: 'idRegistro'}
                                            		],
                                             proxy : new Ext.data.HttpProxy	(
                                                                                  {
                                                                                      url: '../paginasFunciones/funcionesProyectos.php'
                                                                                      
                                                                                  }

                                                                              ),
                                            sortInfo: {field: 'fechaComentario', direction: 'DESC'},
                                            autoLoad:true,
                                            root:'registros',
                                            remoteSort: false
                                        }
                                      );
    alDatos.setDefaultSort('fechaComentario', 'DESC');
    
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion=240;
                                        proxy.baseParams.idFormulario=gE('idFormularioAux').value;
                                        proxy.baseParams.idRegistro=gE('idRegistroAux').value;
                                    }
                        )
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														
														{
															header:'Dict&aacute;men / Resultado',
															width:550,
															sortable:true,
															dataIndex:'dictamen',
                                                            renderer:formatearDictamen
														},
                                                        {
															header:'Fecha comentario',
															width:150,
															sortable:true,
															dataIndex:'fechaComentario',
                                                            renderer:formatearfechaColor
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridComentarios',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loaMask:true,
                                                            stripeRows :true,
                                                            height:340,
                                                            width:770,
                                                            loadMask:true,
                                                            viewConfig: {
                                                                            forceFit:false,
                                                                            enableRowBody:true,
                                                                            getRowClass : formatearFila
                                                                        }
                                                        }
                                                    );
	return 	tblGrid;	
}

function formatearFila(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;
    p.body = '<BR><p style="margin-left: 2em;margin-right: 3em;text-align:justify"><span class="copyrigthSinPaddingNegro">&nbsp;' + (xf.stripTags(record.data.comentario)) + '</span></p>';
    return 'x-grid3-row-expanded';
}

function formatearDictamen(value, p, record) 
{
	return String.format(
                '<img src="../images/icon_comment.gif">&nbsp;<span class="corpo8_bold">{0}</span><br>&nbsp;&nbsp;&nbsp;&nbsp;(<span class="copyrigthVerde">{1}</span>)',
                	value, record.data.actorComentario
                );

}

function formatearfechaColor(value, p, record)
{
	return '<span class="letraRojaSubrayada8">'+formatearfecha(value, p, record)+'</span>';
}

function obtenerVersionImprimible()
{
	var idRegistro=gE('idRegistroAux').value;
   	var idProceso=gE('idProceso').value;
	var arrParam=[['idProceso',idProceso],['idRegistro',idRegistro]];
    enviarFormularioDatos('../reportes/exportarRegistroProceso.php',arrParam);
}

function agendaReuniones(idReferencia)
{
	var conf={};
    conf.url='../modeloPerfiles/tblFormularios.php';
    conf.ancho=880;
    conf.alto=460;
    conf.titulo='Agenda de reuniones';
    conf.params=[['idFormulario',916],['idReferencia',idReferencia],['cPagina','sFrm=true']];
    abrirVentanaFancy(conf);
}

function obtenerVersionHTML()
{
	var idRegistro=gE('idRegistroAux').value;
   	var idProceso=gE('idProceso').value;
    var ventanaAbierta=window.open('',"vVistaPrevia", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
	var arrParam=[['cPagina','mR1=false'],['idProceso',idProceso],['idRegistro',idRegistro]];
    enviarFormularioDatos('../reportes/exportarRegistroHTML.php',arrParam,'POST','vVistaPrevia');
}

function recargarContenedorCentral()
{
	var content=Ext.getCmp('tblCenter');

    if(!vListadoRegistros)
	    content.getFrameWindow().recargarPagina();
    else
    	content.getFrameWindow().recargarContenedorCentral();
}

function recargarProcesoActorNuevaEtapa(actor,iR,nR)
{
	var nRegistro=0;
    if(nR)
    	nRegistro=1;
	var idRegistro=gE('idRegistroAux').value;
    if(iR)
    	idRegistro=iR;
	if(actor)
		window.opener.verRegistroProyecto(bE(idRegistro),bE(actor),bE(gE('idFormularioAux').value));
    else
    {
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
               window.opener.verRegistroProyecto(bE(idRegistro),bE(arrResp[1]),bE(gE('idFormularioAux').value));
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=337&nRegistro='+nRegistro+'&actor='+bD(gE('actor').value)+'&idFormulario='+gE('idFormularioAux').value+'&idRegistro='+idRegistro+'&idPerfil='+gE('idPerfil').value,true);
    }
	
}

function obtenerFormatoPagoReferenciado(ref)
{
	var arrParam=[['referencia',ref]];
    enviarFormularioDatos('../reportes/generarPagoReferenciado.php',arrParam);
}