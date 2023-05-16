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
		
	$consulta="select idEstado,responsable from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
	$filaReg=$con->obtenerPrimeraFila($consulta);
	$etapaRegistro=$filaReg[0];
	
	$respRegistro=$filaReg[1];
	$consulta="SELECT idPerfil FROM 944_actoresProcesoEtapa WHERE idActorProcesoEtapa=".$idActor;
	$idPerfil=$con->obtenerValor($consulta);
	if($idPerfil=="")
		$idPerfil="-1";
	else
	{
		$consulta="SELECT situacion FROM 206_perfilesEscenarios WHERE idPerfil=".$idPerfil;
		$situacionPerfil=$con->obtenerValor($consulta);	
		if($situacionPerfil!=1)
			$idPerfil="-1";
	}
		
	$participante=bD($_GET["idP"]);
	$consulta="SELECT idMenu,textoMenu,idFuncionVisualiza FROM 808_titulosMenu where idProceso=".$idProceso." ORDER BY textoMenu";
	$res=$con->obtenerFilas($consulta);
	$cadMenu="";
	$arrMenuRibbon="";	
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
								xtype:"button",
								text:Ext.util.Format.ellipsis("'.$filaOpt[1].'",52),
								tooltip:"'.$filaOpt[1].'",
								cls:"x-btn-text-icon",
								scale : "small",
								autoWidth:false,
								width:165,
								height:27,
								iconAlign : "left",
								'.$comp.'
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
					
					
					
				$objRibbon="	{
								  title:'".cv($fila[1])."',
								  ribbon:	[
											  {
												  title : 'Opciones disponibles',
												  cfg : 	{
															  columns : 5
															  
														  },
												  items : [".$arrMenu."
														  ]
														  
											  }
										  ]
								}";
				$arrMenuRibbon.=",".$objRibbon;
					
			}
		}
	}

	

	$consulta="SELECT titulo FROM 900_formularios WHERE idFormulario=".$idFormulario;
	$nombreFormulario=$con->obtenerValor($consulta);
?>

var arrMenu=<?php echo "[".$cadMenu."]"?>;

Ext.onReady(inicializar);
var oConfiguracion=null;
var nodoSel=null;

var hActor;
var hDComp;
var hIdFormulario;
var hIdRegistro;
var arrParamConfiguraciones;
var vListadoRegistros=false;
var fichaBaseMostrada=false;
var objConfDictamenFinal=null;
function inicializar()
{

	Ext.override(Ext.ButtonGroup,	{
    									onAfterLayout : function()
                                        				{
                                                        	
                                                        }
    								}
                                    
				)

	var arrBtn=eval(bD(gE('arrBtn').value));
    
    if(arrMenu.length>0)
    {
    	var x;
        for(x=0;x<arrMenu.length;x++)
        {
        	arrBtn.push(arrMenu[x]);
        }
    }

	Ext.QuickTips.init();
        
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'347'
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesProyectos.php'
                                                    
                                                }
                                            )		        
        
	cargadorArbol.on('beforeload',function(proxy)
    								{
                                    	gEx('btnSometerRevision').hide();
                                        gEx('btnDictamenParcial').hide();
                                        gEx('btnDictamenFinal').hide();
                                    	proxy.baseParams.iP=gE('idProcesoPrincipal').value;
                                        proxy.baseParams.iF=gE('idFormularioAux').value;
                                        proxy.baseParams.iR=gE('idRegistroAux').value;
                                        proxy.baseParams.iA=bD(gE('actor').value);
                                        proxy.baseParams.idP=gE('participante').value;
                                        
                                    }
    				)        
        
	cargadorArbol.on('load',function(proxy)
    								{
                                    	
                                    	
                                        
                                        var totalBotones=0;
                                        var permisos=raiz.childNodes[0].attributes.objAccionesDisponibles;
                                       	oConfiguracion=permisos;
                                        if(permisos.someteRevision=='1')
                                        {
                                        	var objSometeRevision=eval('['+bD(permisos.objSometeRevision)+']')[0];
                                            
                                            gEx('btnSometerRevision').setText(objSometeRevision.etiqueta);
                                            gEx('btnSometerRevision').objConf=objSometeRevision;
	                                        gEx('btnSometerRevision').show();
                                            totalBotones++;
                                        }
                                        
                                        if(permisos.realizaDictamenP=='1') 
                                        {   
	                                        gEx('btnDictamenParcial').show();
                                            totalBotones++;
                                        }
    
                                        if(permisos.realizaDictamenF=='1')
                                        {
                                        	totalBotones++;
                                            objConfDictamenFinal=eval('['+bD(permisos.objConfDictamenFinal)+']')[0];
                                            
                                            var objConfDictamenFinalComplementario=permisos.objConfDictamenFinalComplementario;
                                            if(objConfDictamenFinalComplementario!='')
                                            {
                                            	objConfDictamenFinalComplementario=eval('['+bD(objConfDictamenFinalComplementario)+']')[0];
                                                gEx('btnDictamenFinal').setText(objConfDictamenFinalComplementario.etiqueta);
                                            }
                                            
                                            gEx('btnDictamenFinal').show();
                                            
                                        }    
                                        
                                        
                                        if(totalBotones==0)    
                                        	gEx('btnCerrar').setWidth(110);
                                        gEx('vContenedor').doLayout();
                                        
                                       
                                        if(!fichaBaseMostrada)
                                        {
                                        	setTimeout(function()
                                            			{
				                                            gEx('arbolOpciones').fireEvent('click',raiz.childNodes[0].childNodes[0]);
                                                        },500);
                                           	fichaBaseMostrada=true;
                                        
                                        }
                                        
                                        
                                    }
    				)            
        
    var viewport = new Ext.Viewport(
    									{
                                            id:'vContenedor',
                                            layout: 'border',
                                            items: [
                                            			{
                                                        	xtype:'panel',
                                                            region:'center',
                                                            layout: 'border',
                                                            /*tbar:	new Ext.Toolbar	(	
                                                            							{
                                                                                        	id:'tblHerramientas',
                                                                                            enableOverflow: true,
                                                                                            items:	[
                                                                                                        
                                                                                                       {
                                                                                                       		id:'gBtnAcciones',
                                                                                                            xtype: 'buttongroup',
                                                                                                            title: 'Acciones del proceso',
                                                                                                            columns: 4,
                                                                                                            collapsible : true,
                                                                                                            defaults: 	{
                                                                                                                            scale: 'small'
                                                                                                                        },
                                                                                                            items:	[
                                                                                                                        
                                                                                                                    ]
                                                                                                        }
                                                                                                        <?php
                                                                                                            echo $arrSeccionesBtn;
                                                                                                       ?>
                                                                                                    ]
                                                            							}
                                                                                    ),*/
                                                            
                                                            		
                                                            items:	[
                                                                          
                                                                              				new Ext.ux.Ribbon(	
                                                                                            					{	
                                                                                                                	region:'north',
                                                                                                                    activeTab:0,
                                                                                                                    items:	[
                                                                                                                    			{
                                                                                                                                    title:'Principal',
                                                                                                                                    ribbon:	[
                                                                                                                                                {
                                                                                                                                                    title : 'Acciones del proceso',
                                                                                                                                                    cfg : 	{
                                                                                                                                                                columns : 6,
                                                                                                                                                                
                                                                                                                                                          	},
                                                                                                                                                    items : [
                                                                                                                                                              	{
                                                                                                                                                                	xtype:'button',
                                                                                                                                                                    icon:'../images/send_email_user.png',
                                                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                                                    hidden:true,
                                                                                                                                                                    scale : 'small',
                                                                                                                                                                    autoWidth:false,
                                                                                                                                                                    id:'btnSometerRevision',
                                                                                                                                                                    text:'Someter a revisi&oacute;n',
                                                                                                                                                                    iconAlign : 'left',
                                                                                                                                                                    handler:function(ctrl)
                                                                                                                                                                            {
                                                                                                                                                                                var solicitarComentarios=ctrl.objConf.solicitarComentarios=='1';
                                                                                                                                                                                var idReferencia=gE('idReferencia').value;
                                                                                                                                                                               
                                                                                                                                                                                var idRegistro=gE('idRegistroAux').value;
                                                                                                                                                                                var idFormulario=gE('idFormularioAux').value;
                                                                                                                                                                                var actor=gE('actor').value;
                                                                                                                                                                               
                                                                                                                                                                                if(solicitarComentarios)    
                                                                                                                                                                                    mostrarVentanaComentario (idFormulario,idRegistro,actor,ctrl.objConf);
                                                                                                                                                                                else
                                                                                                                                                                                {
                                                                                                                                                                                    function resp(btn)
                                                                                                                                                                                    {
                                                                                                                                                                                        if(btn=='yes')
                                                                                                                                                                                        {
                                                                                                                                                                                            function funcAjax(peticion_http)
                                                                                                                                                                                            {
                                                                                                                                                                                                var resp=peticion_http.responseText;
                                                                                                                                                                                                
                                                                                                                                                                                                arrResp=resp.split('|');
                                                                                                                                                                                                if(arrResp[0]=='1')
                                                                                                                                                                                                {
                                                                                                                                                                                                    regresar1Pagina(ctrl.objConf.cerrarVentana=='1');
                                                                                                                                                                                                    if(ctrl.objConf.cerrarVentana=='0')
                                                                                                                                                                                                    {
                                                                                                                                                                                                        var cadDatos='{"actor":"'+bE(arrResp[1])+'"}';
                                                                                                                                                                                                        function funcAjax(peticion_http)
                                                                                                                                                                                                        {
                                                                                                                                                                                                            var resp=peticion_http.responseText;
                                                                                                                                                                                                            arrResp=resp.split('|');
                                                                                                                                                                                                            if(arrResp[0]=='1')
                                                                                                                                                                                                            {
                                                                                                                                                                                                                recargarPagina();
                                                                                                                                                                                                            }
                                                                                                                                                                                                            else
                                                                                                                                                                                                            {
                                                                                                                                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                                                                                                            }
                                                                                                                                                                                                        }
                                                                                                                                                                                                        obtenerDatosWebV2('../paginasFunciones/funcionesEspecialesSistema.php',funcAjax, 'POST','funcion=3&nS='+gE('confPaginaRefrescar').value+'&cadObj='+cadDatos,false);
                                                                                                                                                                                                    }
                                                                                                                                                                                                }
                                                                                                                                                                                                else
                                                                                                                                                                                                {
                                                                                                                                                                                                    if(arrResp[0].indexOf('[')==0)
                                                                                                                                                                                                    {
                                                                                                                                                                                                        var arrErr=eval(arrResp[0]);
                                                                                                                                                                                                        mostrarVentanaError(arrErr);
                                                                                                                                                                                                    }
                                                                                                                                                                                                    else
                                                                                                                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                                                                                                }
                                                                                                                                                                                            }
                                                                                                                                                                                            obtenerDatosWebV2('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=39&comentario=&idFormulario='+idFormulario+'&idRegistro='+idRegistro+'&actor='+actor+'&idPerfil='+oConfiguracion.idPerfil,true);
                                                                                                                                                                                
                                                                                                                                                                                        }
                                                                                                                                                                                    }
                                                                                                                                                                                    msgConfirm(ctrl.objConf.msgConf,resp);
                                                                                                                                                                                }
                                                                                                                                                                            }
                                                                                                                                                                    
                                                                                                                                                                },
                                                                                                                                                                {
                                                                                                                                                                	xtype:'button',
                                                                                                                                                                    icon:'../images/pencil_go.png',
                                                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                                                    hidden:true,
                                                                                                                                                                    autoWidth:false,
                                                                                                                                                                    //width:160,
                                                                                                                                                                    scale : 'small',
                                                                                                                                                                    id:'btnDictamenParcial',
                                                                                                                                                                    text:'Realizar dictamen parcial',
                                                                                                                                                                    iconAlign : 'left',
                                                                                                                                                                    handler:function()
                                                                                                                                                                            {
                                                                                                                                                                                
                                                                                                                                                                            }
                                                                                                                                                                    
                                                                                                                                                                },
                                                                                                                                                                {
                                                                                                                                                                	xtype:'button',
                                                                                                                                                                    icon:'../images/page_accept.png',
                                                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                                                    hidden:true,
                                                                                                                                                                    autoWidth:false,
                                                                                                                                                                    //width:160,
                                                                                                                                                                    scale : 'small',
                                                                                                                                                                    id:'btnDictamenFinal',
                                                                                                                                                                    text:'Realizar dictamen final',
                                                                                                                                                                    iconAlign : 'left',
                                                                                                                                                                    handler:function()
                                                                                                                                                                            {
                                                                                                                                                                            	
                                                                                                                                                                                crearTabPaginaDictamenSeccion(objConfDictamenFinal);
                                                                                                                                                                            }
                                                                                                                                                                    
                                                                                                                                                                },
                                                                                                                                                                
                                                                                                                                                                {
                                                                                                                                                                	xtype:'button',
                                                                                                                                                                    icon:'../images/icon_comment.gif',
                                                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                                                    scale : 'small',
                                                                                                                                                                    hidden:((parseInt(gE('nComentarios').value)==0)||(gE('nComentarios').value=='')),
                                                                                                                                                                    id:'btnComentarios',
                                                                                                                                                                    text:((parseInt(gE('nComentarios').value)==1)?'1 Comentario':gE('nComentarios').value+' Comentarios')+
                                                                                                                                                                    	' (<span id="lblComentarios">'+((parseInt(gE('nNuevosComentarios').value)==1)?gE('nNuevosComentarios').value+' nuevo</span>':gE('nNuevosComentarios').value+' nuevos</span>')+')',
                                                                                                                                                                    autoWidth:false,
                                                                                                                                                                    iconAlign : 'left',
                                                                                                                                                                    handler:function()
                                                                                                                                                                            {
                                                                                                                                                                                mostrarGridComentarios();
                                                                                                                                                                            }
                                                                                                                                                                    
                                                                                                                                                                },
                                                                                                                                                                {
                                                                                                                                                                	xtype:'button',
                                                                                                                                                                    icon:'../images/salir.gif',
                                                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                                                    scale : 'small',
                                                                                                                                                                    id:'btnCerrar',
                                                                                                                                                                    text:'Cerrar',
                                                                                                                                                                    autoWidth:false,
                                                                                                                                                                    iconAlign : 'left',
                                                                                                                                                                    handler:function()
                                                                                                                                                                            {
                                                                                                                                                                                function resp(btn)
                                                                                                                                                                                {
                                                                                                                                                                                    if(btn=='yes')
                                                                                                                                                                                        window.parent.cerrarVentanaFancy();
                                                                                                                                                                                }
                                                                                                                                                                                msgConfirm('Est&aacute; seguro de querer finalizar la sesi&oacute;n de trabajo sobre este proceso?',resp);
                                                                                                                                                                            }
                                                                                                                                                                    
                                                                                                                                                                }
                                                                                                                                                            ]
                                                                                                                                                }
                                                                                                                                            ]
																																}
                                                                                                                                <?php
																																	echo $arrMenuRibbon
																																?>
                                                                                                                            ]                                                                                                                    					
                                                                                                               	}
                                                                                                              )
                                                                                      ,
                                                            			 {
                                                                        	xtype:'panel',
                                                                            region: 'west',
                                                                            border: true,
                                                                            collapsible:true,
                                                                            width: 220,
                                                                            layout:'anchor',
                                                                        	items:	[
                                                                                         new Ext.tree.TreePanel	(
                                                                                                                    {
                                                                                                                        id:'arbolOpciones',
                                                                                                                        useArrows:false,
                                                                                                                        autoScroll:true,
                                                                                                                        animate:true,
                                                                                                                        enableDD:false,
                                                                                                                        expanded:true,
                                                                                                                        anchor:'100% 100%',
                                                                                                                        containerScroll: true,
                                                                                                                        root:raiz,
                                                                                                                        bodyStyle:'background-color: #F5F5F5;',
                                                                                                                        border:false,
                                                                                                                        lines:false,
                                                                                                                        loader:cargadorArbol,
                                                                                                                        rootVisible:false
                                                                                                                    }
                                                                                                                ) 
                                                                                        
                                                                                      ]
                                                                                      
                                                                         },
                                                                                            
                                                                        {
                                                                            xtype:'panel',
                                                                            region:'center',
                                                                            //tbar:arrBtn,
                                                                            border:false,
                                                                            layout:'border',
                                                                            items:	[
                                                                                        {
                                                                                            xtype:'tabpanel',
                                                                                            enableTabScroll:true,
                                                                                            id:'tPanelCentral',
                                                                                            activeTab:0,
                                                                                            border:false,
                                                                                            region:'center',
                                                                                            items:	[
                                                                                                        {
                                                                                                            xtype:'panel',
                                                                                                            title:'<?php echo cv($nombreFormulario)?>',
                                                                                                            id:'panelBase',
                                                                                                            items:	[
                                                                                                                        new Ext.ux.IFrameComponent({ 
                                                                                                                            
                                                                                                                                                        id: 'tblCenter', 
                                                                                                                                                        region:'center',
                                                                                                                                                        anchor:'100% 100%',
                                                                                                                                                        url: '../paginasFunciones/white.php',
                                                                                                                                                        style: 'width:100%;height:100%',
                                                                                                                                                        listeners:	{
                                                                                                                                                        				render:function()
                                                                                                                                                                        		{
                                                                                                                                                                                	//gEx('arbolOpciones').setRootNode();
                                                                                                                                                                                }
                                                                                                                                                        			},
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
                                                                                        
                                                                                                    ]
                                                                                        }
                                                                                    ]
                                                                        },
                                                                        {
                                                                            xtype:'tabpanel',
                                                                            height:220,
                                                                            id:'panelListadoRegistros',
                                                                            hidden:true,
                                                                            //collapsible:true,
                                                                            region:'south',
                                                                            items:	[
                                                                                    ]
                                                                       
                                                                        }
                                                                       
                                                                    ]
                                                         }
                                                    ]
                                    	}
                                  	);
                                    
                                    
	gEx('arbolOpciones').on('click',funcClikArbol);        
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

function recargarMenuDTDEliminar()
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
    				idFormulario:idFrm,
                    idRegistro:'-1',
                    idReferencia:idRef,
                    cPagina:cPag,
                    eJs:'<?php echo base64_encode("window.parent.accionDictamenFinal();")?>',
                    accionCancelar:'window.parent.funcionInicio();',
                    paginaRedireccion:'../paginasFunciones/white.php'
                 };//idPerfil:gE('idPerfil').value,
                 
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

function enviarProcesoVinculado(iR,iPP,iPV,iU,a,sl,tipoVista,tVisor,iFP,iFV)
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
                        
                        
                        
	alDatos.on('load',function(proxy)
    								{
                						gE('lblComentarios').innerHTML='0 nuevos';
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
    p.body = '<BR><p style="margin-left: 2em;margin-right: 3em;text-align:justify"><span class="copyrigthSinPaddingNegro">&nbsp;' + (record.data.comentario) + '</span></p>';
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

//Nuevas funciones

function funcClikArbol(nodo,e)
{
	
	var id=parseFloat(nodo.id);
    
    if(id>=0)
    {
		
    	switch(nodo.attributes.tipoSeccion)
        {
        	case '0':
            	var oConf=bD(nodo.attributes.oConf).replace(/"vSL"/gi,'"'+nodo.attributes.rO+'"');
                if(nodo.attributes.repetible=='1')
                {
                	var funcion=bD(nodo.attributes.fc)+'(\''+bE(oConf)+'\');';
                   
                    eval(funcion);
                }
                else
                {
                	
                	if((parseInt(nodo.attributes.nReg)!=0)||(parseInt(nodo.attributes.rO)==0))
                    {
                    	var funcion=bD(nodo.attributes.fc)+'(\''+bE(oConf)+'\');';
                        
                        eval(funcion)
                    }
                }
            break;
            case '1':
            	var oConf=bD(nodo.attributes.oConf).replace(/"vSL"/gi,'"'+nodo.attributes.rO+'"');
                var funcion=bD(nodo.attributes.fc)+'(\''+bE(oConf)+'\');';
                eval(funcion)
            break;
            case '2':
            	var oConf=bD(nodo.attributes.oConf).replace(/"vSL"/gi,'"'+nodo.attributes.rO+'"');
                var funcion=bD(nodo.attributes.fc)+'(\''+bE(oConf)+'\');';
                eval(funcion)
            break;
        }
    }
}

function abrirProcesoVinculado(o)
{
	var objConf=eval('['+bD(o)+']')[0];
    crearTabListadoRegistrosProcesos(objConf);
}

function abrirSeccionListado(o)
{
	var objConf=eval('['+bD(o)+']')[0];
    
    crearTabListadoRegistroSeccion(objConf);
}

function abrirSeccionPagina(o)
{
	var objConf=eval('['+bD(o)+']')[0];
    crearTabPaginaRegistroSeccion(objConf);
}

function crearTabListadoRegistro(idFormulario,titulo)
{
	var panelListadoRegistros=gEx('panelListadoRegistros');
	panelListadoRegistros.add (
                                 {
                                    xtype:'panel',
                                    border:false,
                                    region:'center',
                                    id:'pGrid_'+idFormulario,
                                    closable:true,
                                    title:titulo,
                                    listeners:	{
                                                    close:function()
                                                            {
                                                                
                                                                if(panelListadoRegistros.items.length-1==0)
                                                                    panelListadoRegistros.hide();
                                                                gEx('vContenedor').doLayout();    
                                                            }
                                                },
                                    items:	[
                                                new Ext.ux.IFrameComponent({ 
                    
                                                                                id: 'frameGrid_'+idFormulario, 
                                                                                anchor:'100% 100%',
                                                                                border:false,
                                                                                url: '../paginasFunciones/white.php',
                                                                                style: 'width:100%;height:100%' 
                                                                        })
                                            ]
                                }
                    )
    panelListadoRegistros.show();  
    panelListadoRegistros.setActiveTab('pGrid_'+idFormulario);      
    gEx('vContenedor').doLayout();

}

function crearTabListadoRegistrosProcesos(objConf)
{
	var pGrid=gEx('pGrid_'+objConf.idFormularioReferencia);
    var panelListadoRegistros=gEx('panelListadoRegistros');
    if(!pGrid)
    {
    	
    	
        crearTabListadoRegistro(objConf.idFormularioReferencia,objConf.titulo);
        var arrParam={
                            
                            idProcesoPadre:objConf.idProcesoPadre,
                            idReferencia:objConf.idReferencia,
                            idProceso:objConf.idProcesoReferencia,
                            cPagina:'sFrm=true',
                            idUsuario:(objConf.idUsuario?objConf.idUsuario:'<?php echo $_SESSION["idUsr"]?>'),
                            actor:objConf.actor,
                            sL:objConf.soloLectura,
                            tipoVista:1,
                            idFormulario:objConf.idFormularioReferencia
                            
                         };
        
        
        gEx('frameGrid_'+objConf.idFormularioReferencia).load	(
                                                                    {
                                                                        url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                        params:arrParam,
                                                                        scripts:true
                                                                    }
                                                                )
        
                                       
   	}
    else
    {
    	panelListadoRegistros.setActiveTab('pGrid_'+objConf.idFormularioReferencia);    
		
    	gEx('frameGrid_'+objConf.idFormularioReferencia).getFrameWindow().gEx('gridRegistros').getStore().reload();	
    }
}

function crearTabListadoRegistroSeccion(objConf)
{
	
    var pGrid=gEx('pGrid_'+objConf.idFormularioReferencia);
    var panelListadoRegistros=gEx('panelListadoRegistros');
    if(!pGrid)
    {
    	crearTabListadoRegistro(objConf.idFormularioReferencia,objConf.titulo);
        var accionRedireccion='';
        var accionCancel='window.parent.f.enviarFichaProyecto('+idFormularioAux+',\''+bE('ver')+'\')';
    	
        
        var cadObjConf='{"modalidad":"'+objConf.modalidad+'","titulo":"'+objConf.titulo+'"}'
        
        var arrParam=	{
        					idFormulario:objConf.idFormularioReferencia,
                            cPagina:'sFrm=true',
                            objConfAux:bE(cadObjConf),
                            idReferencia:objConf.idReferencia,
                            sL:objConf.soloLectura,
                            idRegistro:'-1',
                            tipoSeccionProceso:1, // seccion formulario repetible
                            tipoVista:1,
                            eJs:bE("window.parent.mostrarMenuDTD()"+accionRedireccion),
                            accionCancelar:bE(accionCancel) 
                            
        				}
        
        gEx('frameGrid_'+objConf.idFormularioReferencia).load	(
                                                                    {
                                                                        url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                        params:arrParam,
                                                                        scripts:true
                                                                    }
                                                                )
        
                                       
   	}
    else
    {
    	panelListadoRegistros.setActiveTab('pGrid_'+objConf.idFormularioReferencia);    
		
    	gEx('frameGrid_'+objConf.idFormularioReferencia).getFrameWindow().gEx('gridRegistros').getStore().reload();	
    }
}

function crearTabPaginaRegistroSeccion(objConf,recargar)
{

	var tipoVista=1;
	var cadConf=convertirCadenaJson(objConf);
	var o={};
    URL='../modeloPerfiles/registroFormularioV2.php';
    if(objConf.idRegistroReferencia!='-1')
    {
        URL='../modeloPerfiles/verFichaFormularioV2.php';
        tipoVista=0;
    }
            
	if(objConf.modalidad=='1')
    {
        
        o.ancho=objConf.ancho?objConf.ancho:'90%';
        o.alto=objConf.alto?objConf.alto:'90%';
        o.modal=false;
        o.titulo=objConf.titulo;
        o.params=[['eJE',bE('window.parent.registroSeccionPaginaEliminado('+objConf.idFormularioReferencia+','+objConf.modalidad+');')],['pM',(objConf.soloLectura=='1')?'0':'1'],['pE',(objConf.soloLectura=='1')?'0':'1'],['accionCancelar','window.parent.cerrarVentanaFancySinConfirmacion()'],['cPagina','sFrm=true'],['idFormulario',objConf.idFormularioReferencia],['idReferencia',objConf.idReferencia],['idRegistro',objConf.idRegistroReferencia]];
        o.url=URL;    
        o.openEffect='elastic';
        o.closeEffect='elastic';
        o.funcionAntesCerrar=function()
                            {
                                var framePanel=$('.fancybox-iframe')[0];
                                
                                if((framePanel.contentWindow.confirmarCierre)&&(framePanel.getAttribute('confirmarCierre')))
                                {
                                    framePanel.contentWindow.confirmarCierre();
                                    return false;
                                }
                            }
                            
		abrirVentanaFancy(o);                            
        var framePanel=$('.fancybox-iframe')[0];
        framePanel.setAttribute('confirmarCierre',1);
        
    }
    else
    {
    	
        
    	if(!objConf.formularioBase)
    	{
            var idPanel='fPanel_'+objConf.idFormularioReferencia;
            var oParametros=	{
                                    accionCancelar:'window.parent.cerrarTab(\''+idPanel+'\')',
                                    cPagina:'sFrm=true',
                                    pM:(objConf.soloLectura=='1')?'0':'1',
                                    pE:(objConf.soloLectura=='1')?'0':'1',
                                    idFormulario:objConf.idFormularioReferencia,
                                    idReferencia:objConf.idReferencia,
                                    idRegistro:objConf.idRegistroReferencia,
                                    eJE:bE('window.parent.registroSeccionPaginaEliminado('+objConf.idFormularioReferencia+','+objConf.modalidad+');'),
                                    eJs:bE('window.parent.registroSeccionRealizado("'+bE(cadConf)+'",@idRegistro);return;')
                                }
    
            var tPanelCentral=gEx('tPanelCentral');
            
            if((!gEx(idPanel))||recargar)
            {
                if(!gEx(idPanel))
                {
                    tPanelCentral.add (
                                                 {
                                                    xtype:'panel',
                                                    border:false,
                                                    region:'center',
                                                    id:idPanel,
                                                    closable:true,
                                                    title:objConf.titulo,
                                                    listeners:	{
                                                                    beforeclose:function()
                                                                                {
                                                                                    var framePanel=gEx('frameFormulario_'+objConf.idFormularioReferencia);
                                                                                    if(framePanel.getFrameWindow().confirmarCierre && framePanel.confirmarCierre)
                                                                                    {
                                                                                        framePanel.getFrameWindow().confirmarCierre();
                                                                                        return false;
                                                                                    }
                                                                                }
                                                                },
                                                    items:	[
                                                    
                                                                new Ext.ux.IFrameComponent({ 
                                    
                                                                                                id: 'frameFormulario_'+objConf.idFormularioReferencia, 
                                                                                                anchor:'100% 100%',
                                                                                                border:false,
                                                                                                url: '../paginasFunciones/white.php',
                                                                                                style: 'width:100%;height:100%' 
                                                                                        })
                                                            ]
                                                }
                                    )
                }               	                            
                tPanelCentral.setActiveTab(idPanel); 
                gEx(idPanel).confirmarCierre=true;
                gEx('frameFormulario_'+objConf.idFormularioReferencia).load	(
                                                                                {
                                                                                    url:URL,
                                                                                    params:oParametros,
                                                                                    scripts:true
                                                                                }
                                                                            )
                
            }
            else
                tPanelCentral.setActiveTab(idPanel);  
    	}
        else
        {
        	var idPanel='panelBase';
            
            
            var aCancelar='window.parent.cerrarVentanaProceso()';
            if(gE('idRegistroAux').value!='-1')
            {
            	aCancelar='regresarPagina()';
            }
            
            var oParametros=	{
                                    accionCancelar:aCancelar,
                                    cPagina:'sFrm=true',
                                    pM:(objConf.soloLectura=='1')?'0':'1',
                                    pE:'0',
                                    idFormulario:gE('idFormularioAux').value,
                                    idReferencia:gE('idReferencia').value,
                                    idRegistro:gE('idRegistroAux').value,
                                    idProcesoP:gE('idProcesoP').value,
                                    idUsuario:gE('idUsuario').value,
                                    eJs:bE('window.parent.registroSeccionBaseRealizado("'+bE(cadConf)+'",@idRegistro);return;')
                                }
                                
                                
			
            
            var arrParamComp=eval(bD(gE('arrParamComp').value));
            var posComp=0;
            for(posComp=0;posComp<arrParamComp.length;posComp++)
            {
            	if(oParametros[arrParamComp[posComp][0]]==undefined)	
                {
                	oParametros[arrParamComp[posComp][0]]=arrParamComp[posComp][1];
                }
            }
            
            var tPanelCentral=gEx('tPanelCentral');
            tPanelCentral.setActiveTab(idPanel); 
            

            
            
            gEx('tblCenter').load	(
                                        {
                                            url:URL,
                                            params:oParametros,
                                            scripts:true
                                        }
                                    )
             
			
        }
    }
}

function cerrarVentanaProceso()
{
	
	if(window.parent.cerrarVentanaProcesoFinal)
    {
    	window.parent.cerrarVentanaProcesoFinal(gE('idFormularioAux').value,gE('idRegistroAux').value);
    }
    else
    	window.parent.cerrarVentanaFancy();
}

function cerrarVentanaFancySinConfirmacion()
{
	var framePanel=$('.fancybox-iframe')[0];
        framePanel.removeAttribute('confirmarCierre',0);
   	cerrarVentanaFancy();
}

function registroSeccionBaseRealizado(cadObj,idRegistro)
{

    	
	if(gE('idRegistroAux').value!='-1')
	{
    	
    	regresar1Pagina();
		recargarMenuDTD();
        
    }
    else
    {	
    	gE('idRegistroAux').value=idRegistro;
    	regresar1Pagina();
    	var cadDatos='{"idRegistro":"'+idRegistro+'","actor":"'+gE('actorEtapa1').value+'"}';
        function funcAjax(peticion_http)
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                recargarPagina();
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWebV2('../paginasFunciones/funcionesEspecialesSistema.php',funcAjax, 'POST','funcion=3&nS='+gE('confPaginaRefrescar').value+'&cadObj='+cadDatos,false);
    }
    
}

function registroSeccionRealizado(cadObj,idRegistro)
{
	recargarMenuDTD();
    var objConf=eval('['+bD(cadObj)+']')[0];
    objConf.idRegistroReferencia=idRegistro;
	crearTabPaginaRegistroSeccion(objConf,true)
    
    if(gEx('frameGrid_'+objConf.idFormularioReferencia))
    {
    	gEx('frameGrid_'+objConf.idFormularioReferencia).getFrameWindow().gEx('gridRegistros').getStore().reload();	
    }
    
    
}

function cerrarTab(iP)
{
	var tPanelCentral=gEx('tPanelCentral');
    tPanelCentral.remove(gEx(iP));
}

function recargarMenuDTD()
{
	gEx('arbolOpciones').getRootNode().reload();
}

function registroSeccionPaginaEliminado(iF,modalidad)
{
	recargarMenuDTD();
	if(modalidad=='1')
    	cerrarVentanaFancy();
    else
    {
    	gEx('fPanel_'+iF).confirmarCierre=false;
    	cerrarTab('fPanel_'+iF);
    }
    
    if(gEx('frameGrid_'+iF))
    {
    	gEx('frameGrid_'+iF).getFrameWindow().gEx('gridRegistros').getStore().reload();	
    }
    
}

function abrirSeccionPaginaModuloPredefinido(o)
{
	var objConf=eval('['+bD(o)+']')[0];
    crearTabPaginaRegistroSeccionModuloPredefinido(objConf);
}

function crearTabPaginaRegistroSeccionModuloPredefinido(objConf,recargar)
{
	var o={};
    URL='';
    if(objConf.soloLectura=='0')
    	URL=objConf.paginaRegistro;
    else    
    	URL=objConf.paginaVista;
    
	if(objConf.modalidad=='1')
    {
        o.ancho=(objConf.ancho && (objConf.ancho!=''))?objConf.ancho:'95%';
        o.alto=(objConf.alto && (objConf.alto!=''))?objConf.alto:'100%';
        o.modal=false;
        o.titulo=objConf.titulo;
        o.params=[['sL',objConf.soloLectura],['modalidad',objConf.modalidad],['accionCancelar','window.parent.cerrarVentanaFancySinConfirmacion()'],['cPagina','sFrm=true'],['idFormulario',<?php echo $idFormulario?>],['idRegistro',<?php echo $idRegistro?>]];
        o.url=URL;    
        o.openEffect='elastic';
        o.closeEffect='elastic';
        
        
        abrirVentanaFancy(o);
        var framePanel=$('.fancybox-iframe')[0];
        framePanel.setAttribute('confirmarCierre',1);
    }
    else
    {
    	var idPanel='fPanel_'+objConf.idFormularioReferencia;
        var oParametros=	{
        						cPagina:'sFrm=true',
                                modalidad:objConf.modalidad,
                                idFormulario:<?php echo $idFormulario?>,
                                idRegistro:<?php echo $idRegistro?>,
                                sL:objConf.soloLectura,
                                accionCancelar:'window.parent.cerrarTab('+idPanel+');'
                                
                            }

    	var tPanelCentral=gEx('tPanelCentral');
        
        if((!gEx(idPanel))||recargar)
        {
        	if(!gEx(idPanel))
            {
                tPanelCentral.add (
                                             {
                                                xtype:'panel',
                                                border:false,
                                                region:'center',
                                                id:idPanel,
                                                closable:true,
                                                title:objConf.titulo,
                                                listeners:	{
                                                                beforeclose:function()
                                                                            {
                                                                               	var framePanel=gEx('frameFormulario_'+objConf.idFormularioReferencia);
                                                                                if(framePanel.getFrameWindow().confirmarCierre && framePanel.confirmarCierre)
                                                                                {
                                                                                    framePanel.getFrameWindow().confirmarCierre();
                                                                                    return false;
                                                                                }
                                                                            }
                                                            },
                                                items:	[
                                                
                                                            new Ext.ux.IFrameComponent({ 
                                
                                                                                            id: 'frameFormulario_'+objConf.idFormularioReferencia, 
                                                                                            anchor:'100% 100%',
                                                                                            border:false,
                                                                                            url: '../paginasFunciones/white.php',
                                                                                            style: 'width:100%;height:100%' 
                                                                                    })
                                                        ]
                                            }
                                )
            }               	                            
        	tPanelCentral.setActiveTab(idPanel); 
            gEx(idPanel).confirmarCierre=true;
            gEx('frameFormulario_'+objConf.idFormularioReferencia).load	(
            																{
                                                                            	url:URL,
                                                                                params:oParametros,
		                                                                        scripts:true
                                                                            }
            															)
            
        }
        else
        	tPanelCentral.setActiveTab(idPanel);  
    }
}

function regresar1Pagina(cerrarVentana)
{
	var idReferencia=gE('idReferencia').value;
    
    if(window.parent.recargarContenedorCentral)
		window.parent.recargarContenedorCentral(gE('idFormularioAux').value,gE('idRegistroAux').value);    
    
    if(cerrarVentana)
    {
		window.parent.cerrarVentanaFancy();	
    }
    
}

function mostrarVentanaComentario(idFormulario,idRegistro,actor,objConf)
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
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            id:'txtComentario',
                                                            width:600,
                                                            height:90
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: lblAplicacion,
										width: 650,
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
                                                                            	
                                                                                function funcAjax(peticion_http)
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                    	
																						ventanaAM.close();
                                                                                        regresar1Pagina(objConf.cerrarVentana=='1');    
                                                                                        if(ctrl.objConf.cerrarVentana=='0')
                                                                                        {
                                                                                        	var cadDatos='{"actor":"'+bE(arrResp[1])+'"}';
                                                                                            function funcAjax(peticion_http)
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    recargarPagina();
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWebV2('../paginasFunciones/funcionesEspecialesSistema.php',funcAjax, 'POST','funcion=3&nS='+gE('confPaginaRefrescar').value+'&cadObj='+cadDatos,false);
                                                                                        }
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                    	if(arrResp[0].indexOf('[')==0)
                                                                                        {
                                                                                            var arrErr=eval(arrResp[0]);
                                                                                            mostrarVentanaError(arrErr);
                                                                                        }
                                                                                        else
                                                                                        	msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWebV2('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=39&comentario='+cv(comentario)+'&idFormulario='+idFormulario+'&idRegistro='+idRegistro+'&actor='+actor+'&idPerfil='+oConfiguracion.idPerfil,true);
                                                                    
                                                                            }
                                                                        }
                                                                        msgConfirm(objConf.msgConf,resp);
																		
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

function recargarContenedorCentral(iFormulario,iRegistro)
{
	recargarMenuDTD();	
    
    if((iFormulario)&&(gEx('frameGrid_'+iFormulario)))
    {
	    gEx('frameGrid_'+iFormulario).getFrameWindow().gEx('gridRegistros').getStore().reload();	
    }
    else
    {
    
    	var arrPanel=gEx('tPanelCentral').getActiveTab().id.split('_');
        if(gEx('frameFormulario_'+arrPanel[1]).getFrameWindow().recargarContenedorCentral)
        {
        	gEx('frameFormulario_'+arrPanel[1]).getFrameWindow().recargarContenedorCentral(iFormulario,iRegistro);
        }

    }
    
    
    
}

function mostrarVentanaError(arrResultado)
{
	var gridResultado=crearGridResultado();
	gridResultado.getStore().loadData(arrResultado);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'<span style="color:#000">No se ha podido podido realizar la operaci&oacute;n debido a lo siguientes problemas:</span>'
                                                            	
                                                        },
                                                        gridResultado

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Fallo al realizar operaci&oacute;n',
										width: 780,
										height:400,
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

function crearGridResultado()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'seccion'},
                                                                {name: 'error'}
                                                            ]
                                                }
                                            );


	 var lector= new Ext.data.ArrayReader({
                                            
                                            
                                            fields: [
                                               			{name: 'seccion'},
                                                       	{name: 'error'}
                                            		]
                                            
                                        }
                                      );

	var alDatos=new Ext.data.GroupingStore({
                                                  reader: lector,
                                                  sortInfo: {field: 'seccion', direction: 'ASC'},
                                                  groupField: 'seccion',
                                                  remoteGroup:false,
                                                  remoteSort: true,
                                                  autoLoad:false
                                                  
                                              }) 

    alDatos.loadData(dsDatos);
	
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'',
															width:40,
															sortable:true,
                                                            align:'center',
															dataIndex:'error',
                                                            renderer:function()
                                                            		{
                                                                    	return '<img src="../images/exclamation.png" width="13" height="13">';
                                                                    }
                                                            
														},
														{
															header:'Secci&oacute;n',
															width:110,
															sortable:true,
															dataIndex:'seccion'
														},
														{
															header:'Problema reportado',
															width:600,
															sortable:true,
															dataIndex:'error',
                                                            renderer:mostrarValorDescripcion
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:40,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:270,
                                                            width:750,
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

function crearTabPaginaDictamenSeccion(objConf)
{
    var idPanel='fPanel_'+objConf.idFormularioReferencia;
    var tPanelCentral=gEx('tPanelCentral');
    
    if(!gEx(idPanel))
    {
        if(!gEx(idPanel))
        {
            tPanelCentral.add (
                                         {
                                            xtype:'panel',
                                            border:false,
                                            region:'center',
                                            id:idPanel,
                                            closable:true,
                                            title:objConf.titulo,
                                            listeners:	{
                                                            beforeclose:function()
                                                                        {
                                                                            var framePanel=gEx('frameFormulario_'+objConf.idFormularioReferencia);
                                                                            if(framePanel.getFrameWindow().confirmarCierre && framePanel.confirmarCierre)
                                                                            {
                                                                                framePanel.getFrameWindow().confirmarCierre();
                                                                                return false;
                                                                            }
                                                                        }
                                                        },
                                            items:	[
                                            
                                                        new Ext.ux.IFrameComponent({ 
                            
                                                                                        id: 'frameFormulario_'+objConf.idFormularioReferencia, 
                                                                                        anchor:'100% 100%',
                                                                                        border:false,
                                                                                        url: '../paginasFunciones/white.php',
                                                                                        style: 'width:100%;height:100%' 
                                                                                })
                                                    ]
                                        }
                            )
        }               	                            
        tPanelCentral.setActiveTab(idPanel); 
        gEx(idPanel).confirmarCierre=true;
        

        var arrParam={
                        idFormulario:objConf.idFormularioReferencia,
                        idRegistro:'-1',
                        idReferencia:gE('idRegistroAux').value,
                        cPagina:'sFrm=true',
                        eJs:bE('window.parent.regresar1Pagina(true);return;'),
                        accionCancelar:'window.parent.cerrarTab(\''+idPanel+'\')',
                        paginaRedireccion:'../paginasFunciones/white.php'
                     };//idPerfil:gE('idPerfil').value,
        
        gEx('frameFormulario_'+objConf.idFormularioReferencia).load	(
                                                                        {
                                                                            url:'../modeloPerfiles/registroFormularioV2.php',
                                                                            params:arrParam,
                                                                            scripts:true
                                                                        }
                                                                    )
        
    }
    else
        tPanelCentral.setActiveTab(idPanel);    	
}

