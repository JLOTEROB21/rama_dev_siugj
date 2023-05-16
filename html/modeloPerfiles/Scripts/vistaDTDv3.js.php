<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$conCalculos="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE idTipoConcepto=5";
	$arregloCalc=$con->obtenerFilasArreglo($conCalculos);
	$idProceso=bD($_GET["iP"]);
	
	
	$consulta="SELECT * FROM 4001_procesos WHERE idProceso=".$idProceso;
	$fDatosProceso=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idActor=bD($_GET["iA"]);	
		
	$iReferenciaRegistro=-1;
	$iFormularioPadreRegistro=-1;
	
	$consulta="select idEstado,responsable,idReferencia from _".$idFormulario."_tablaDinamica where id__".$idFormulario."_tablaDinamica=".$idRegistro;
	
	if($con->existeCampo("idProcesoPadre","_".$idFormulario."_tablaDinamica"))
	{
		$consulta="select idEstado,responsable,idReferencia,idProcesoPadre from _".$idFormulario."_tablaDinamica 
					where id__".$idFormulario."_tablaDinamica=".$idRegistro;
	}
	
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
		
	if($filaReg[2]!=-1)	
	{
		$iReferenciaRegistro=$filaReg[2];
	}
	
	if(isset($filaReg[3])&&($filaReg[3]!=-1))	
	{
		$iFormularioPadreRegistro=obtenerFormularioBase($filaReg[3]);
	}
		
	$participante=bD($_GET["idP"]);
	$consulta="SELECT idMenu,textoMenu,idFuncionVisualiza,icono FROM 808_titulosMenu where idProceso=".$idProceso." ORDER BY textoMenu";
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
				$cadObj='{"idFormulario":"'.$idFormulario.'","idRegistro":"'.$idRegistro.'","idActor":"'.$idActor.'","idMenu":"'.$fila[0].'"}';
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
			$consulta="SELECT o.idOpciones,o.textoOpcion,o.paginaUrlDestino,o.tipoEnlace,o.idContenido,o.idFuncionVisualizacion,o.tamano,o.idOpcion 
					FROM 811_menusVSOpciones m,809_opciones o WHERE o.idOpcion=m.idOpcion AND m.idMenu=".$fila[0]." ORDER BY m.orden";
	
			$resOpt=$con->obtenerFilas($consulta);
			$arrMenu="";
			while($filaOpt=mysql_fetch_row($resOpt))
			{
				$publicarOpcion=true;
				if($filaOpt[5]!=-1)
				{
					
					$cadObj='{"idFormulario":"'.$idFormulario.'","idRegistro":"'.$idRegistro.'","idActor":"'.$idActor.'","idOpcion":"'.$filaOpt[7].'"}';
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
								
								text:"'.$filaOpt[1].'",
								cls:"x-btn-text-icon btnVistaProceso",	
								height:50,
								id:"mnu_'.$filaOpt[7].'",
								minWidth:170,							
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
				$obj='{'.($fila[3]==""?"":" icon:'".$fila[3]."',cls:'x-btn-text-icon',").'"text":"'.$fila[1].'",height:50,minWidth:170,"menu":['.$arrMenu.']}';	
				$cadMenu.=",".$obj;
					
			}
		}
	}

	

	$consulta="SELECT titulo FROM 900_formularios WHERE idFormulario=".$idFormulario;
	$nombreFormulario=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(*) FROM 9074_documentosRegistrosProceso WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro;
	
	$nDocumentosAsociados=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos order by nombreCategoria";
	$arrTipoDocumento=$con->obtenerFilasArreglo($consulta);

?>

var permiteEliminarDocumento=true;
var mostrarBotonDocumentosAdjuntos=<?php echo $fDatosProceso["mostrarBotonDocumentosAdjuntos"]==1?"true":"false"?>;
var mostrarBotonProcesosAsociados=<?php echo $fDatosProceso["mostrarBotonProcesosAsociados"]==1?"true":"false"?>;
var procesoAperturado=false;
var ventanaAdjuntaDocumento=<?php echo $habilitarLatisScan?"100":"0" ?>;
var uploadControl;
var deshabiltarCargaIframe=false;
var primeraCargaFrame=true;
var ocultarDocumento=false;
var nodoDocumentoSeleccionado=null;
var idPerfil=<?php echo $idPerfil?>;
var iReferenciaRegistro='<?php echo $iReferenciaRegistro?>';
var	iFormularioPadreRegistro='<?php echo $iFormularioPadreRegistro?>';

var swfDocumento=null;
var arrTipoDocumento=<?php echo $arrTipoDocumento?>;
var arrMenu=<?php echo "[".$cadMenu."]"?>;

Ext.onReady(inicializar);

var totalBotones=0;
var oConfiguracion=null;
var nodoSel=null;
var opcionesMenus;

var hActor;
var hDComp;
var hIdFormulario;
var hIdRegistro;
var arrParamConfiguraciones;
var vListadoRegistros=false;
var fichaBaseMostrada=false;
var objConfDictamenFinal=null;
var idFormularioActivo=null;

function inicializar()
{
	
    var arrBtn=eval(bD(gE('arrBtn').value));
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

                                    	proxy.baseParams.iP=gE('idProcesoPrincipal').value;
                                        proxy.baseParams.iF=gE('idFormularioAux').value;
                                        proxy.baseParams.iR=gE('idRegistroAux').value;
                                        proxy.baseParams.iA=bD(gE('actor').value);
                                        proxy.baseParams.idP=gE('participante').value;
                                        
                                    }
    				)        
        
	cargadorArbol.on('load',function(proxy,node)
    								{
                                    	
                                    	var barraHerramientas=gEx('tPanelCentral').getTopToolbar();
                                        
                                        var x=0;
                                        for(x=0;x<barraHerramientas.items.length;x++)                                      
                                        {
                                            objTemp=barraHerramientas.items.itemAt(x);
                                            if(objTemp.objEliminable)
                                            {
                                                barraHerramientas.remove(objTemp);
                                                x--;
                                            }
                                            
                                        }
                                        
                                        
                                        var nodoRaiz=node.childNodes[0];
                                        opcionesMenus=nodoRaiz.childNodes;
                                        
                                        generarMenuOpciones();
                                        
                                        totalBotones=0;
                                        var permisos=raiz.childNodes[0].attributes.objAccionesDisponibles;
                                        oConfiguracion=permisos;

                                        var pos=2;
                                        if(permisos.someteRevision=='1')
                                        {
                                            var btnSomete;
                                            
                                            var objTemp;
                                        	var objSometeRevision=eval('['+bD(permisos.objSometeRevision)+']');      
                                            for(x=0;x<objSometeRevision.length;x++)                                      
                                            {

												var icono='../images/send_email_user.png';
                                                if(objSometeRevision[x].icono!=undefined && objSometeRevision[x].icono!='')
                                                {
                                                	icono='<?php echo $rutaImgenesEscenario?>/'+objSometeRevision[x].icono;
                                                }
                                                btnSomete=	{
                                                                icon:icono,
                                                                cls:'x-btn-text-icon',
                                                                id:'btnSometerRevision_'+pos,
                                                                height:50,
                                                                minWidth:170,
                                                                text:objSometeRevision[x].etiqueta,
                                                                handler:functionSometerRevision
                                                                        
                                                                              
                                                            }
                                                btnSomete.objConf=objSometeRevision[x];
                                                btnSomete.objConf.idPerfil=permisos.idPerfil;
                                                btnSomete.objEliminable=true;
                                               
                                                totalBotones++;
                                                if(x>0)
                                                {
                                                	var objSeparador={xtype: 'tbseparator'};
                                                    objSeparador.objEliminable=true;
                                                	barraHerramientas.insert(pos,objSeparador);
                                                    pos++;
                                                }
                                            	barraHerramientas.insertButton(pos,btnSomete);
                                                pos++;
                                                
                                            }
                                            barraHerramientas.doLayout();
                                           
                                        }
                                        
                                        if(permisos.realizaDictamenF=='1')
                                        {
                                        	/*if(pos>2)
                                            {
                                                var objSeparador={xtype: 'tbseparator'};
                                                objSeparador.objEliminable=true;
                                                barraHerramientas.insert(pos,objSeparador);
                                                pos++;
                                            }*/
                                            
                                            var arrDictamenFinal=eval('['+bD(permisos.objConfDictamenFinal)+']');
											var objConfDictamenFinal;
                                            var x;
                                            for(x=0;x<arrDictamenFinal.length;x++)
                                           	{
                                            	objConfDictamenFinal=arrDictamenFinal[x];
                                                var etiquetaFictamenFinal=objConfDictamenFinal.titulo;
                                                
                                                var btnDictamenFinal=null;
                                                var icono='../images/page_accept.png';
                                                
                                                if(objConfDictamenFinal.icono!='')
                                                {
                                                	icono='<?php echo $rutaImgenesEscenario?>/'+objConfDictamenFinal.icono;
                                                }

                                                if(objConfDictamenFinal.mostrarFormularioAsociado=='1')
                                                {
                                                    btnDictamenFinal=	{
                                                                            icon:icono,
                                                                            cls:'x-btn-text-icon',
                                                                            height:50,
			                                                                minWidth:170,
                                                                            id:'btnDictamenFinal_'+objConfDictamenFinal.idAccionesProcesoEtapaVSAcciones,
                                                                            text:etiquetaFictamenFinal,
                                                                            handler:crearTabPaginaDictamenSeccion
                                                                            
                                                                        }
                                                }
                                                else
                                                {
                                                      
                                                      var arrOpcionesDictamen=[];
                                                      var optTemp;
                                                      var xAux;
                                                      for(xAux=0;xAux<objConfDictamenFinal.arrOpciones.length;xAux++)
                                                      {
                                                          optTemp	=	{
                                                                          cls:'x-btn-text-icon',
                                                                          id:'btnOpcionDictamen_'+objConfDictamenFinal.idAccionesProcesoEtapaVSAcciones+'_'+objConfDictamenFinal.arrOpciones[xAux].idValor,
                                                                          text:objConfDictamenFinal.arrOpciones[xAux].etiqueta,
                                                                          height:50,
                                                                		  minWidth:170,
                                                                          handler:mostrarVentanaSeleccionDictamen
                                                                      };
                                                          
                                                          if((objConfDictamenFinal.arrOpciones[xAux].icono!='')&&((objConfDictamenFinal.arrOpciones[xAux].icono!='undefined')))
                                                          {
                                                          		optTemp.icon='<?php echo $rutaImgenesEscenario?>/'+objConfDictamenFinal.arrOpciones[xAux].icono;
                                                          }
                                                          optTemp.objConfiguracion=	{
                                                                                          mostrarComentarios:objConfDictamenFinal.mostrarComentariosAdicionales,
                                                                                          valorOpcion:objConfDictamenFinal.arrOpciones[xAux].idValor,
                                                                                          etapaCambio:objConfDictamenFinal.arrOpciones[xAux].etapaCambio,
                                                                                          etiqueta:objConfDictamenFinal.arrOpciones[xAux].etiqueta,
                                                                                          cerrarVentana:objConfDictamenFinal.accionFinalizar,
                                                                                          idPerfil:permisos.idPerfil
                                                                                      };
                                                          

                                                          optTemp.objConfDictamenFinalComplementario=objConfDictamenFinal;
                                                          
                                                          arrOpcionesDictamen.push	(optTemp);
                                                      }
                                                      
                                                      
                                                      btnDictamenFinal=	{
                                                                              icon:icono,
                                                                              cls:'x-btn-text-icon',
                                                                              height:50,
				                                                              minWidth:170,
                                                                              id:'btnDictamenFinal_'+objConfDictamenFinal.idAccionesProcesoEtapaVSAcciones,
                                                                              text:etiquetaFictamenFinal,
                                                                              menu:	arrOpcionesDictamen
                                                                              
                                                                          }
                                                }
                                                btnDictamenFinal.objConfDictamenFinalComplementario=objConfDictamenFinal;
                                                btnDictamenFinal.objEliminable=true;
                                               
                                                barraHerramientas.insertButton(pos,btnDictamenFinal);
                                                pos++;
                                                
                                                /*var objSeparador={xtype: 'tbseparator'};
                                                objSeparador.objEliminable=true;
                                                barraHerramientas.insert(pos,objSeparador);
                                                pos++;*/
                                                  
                                                totalBotones++;
                                            }
                                        }  
                                        
                                        if(permisos.certificaProceso=='1')
                                        {
                                        	totalBotones++;
                                            var confCertificaProceso=bD(permisos.confCertificaProceso);
                                            
                                            if(confCertificaProceso!='')
                                            {
                                            	var objConf=eval('['+(confCertificaProceso)+']')[0];
                                               
                                                gEx('btnCertificacionProceso').setText(objConf.etiqueta);
                                                gEx('btnCertificacionProceso').oConfiguracion=objConf;
                                                if(objConf.visualizarBoton=='0')
                                                	gEx('btnCertificacionProceso').hide();
                                                else
                                                	gEx('btnCertificacionProceso').show();
                                            }
                                            
                                            
                                            
                                        }  
                                        
                                        
                                        if(oConfiguracion.adjuntaDocumentos!='0')
                                        {
                                        	var oConfiguracionArchivo=bD(oConfiguracion.objConfAdjuntaDocumentos);
                                            if(oConfiguracionArchivo!='')
                                            {
                                            	oConfiguracionArchivo=eval('['+oConfiguracionArchivo+']')[0];
                                            }
                                            else
                                            {
                                            	oConfiguracionArchivo={};
                                                oConfiguracionArchivo.categoriaDocumento='0';
                                                oConfiguracionArchivo.extensionesPermitidas='*.pdf;*.jpg;*.jpeg;*.gif;*.png';
                                                oConfiguracionArchivo.tamanoMaximo='1000';
                                                oConfiguracionArchivo.tamanoMaximo='MB';
                                                
                                            }
                                            gEx('btnAdjuntarDocumento').objConf=oConfiguracionArchivo;
                                        }
                                        else
                                        {
                                        	gEx('tblDocumentosAdjuntos').hide();
                                        }
                                        
                                        if(oConfiguracion.remueveDocumentos=='0')
                                        {
                                        	permiteEliminarDocumento=false;
                                            gEx('gDocumentosAdjuntos').getView().refresh();
                                        }
                                        
                                       
                                        gEx('vContenedor').doLayout();
                                        
                                        if(!fichaBaseMostrada)
                                        {
                                        	setTimeout(function()
                                            			{
				                                            seccionSeleccionada(bE(1));
                                                            
                                                            
                                                        },500);
                                           	fichaBaseMostrada=true;
                                        
                                        }
                                        
                                        
                                        
                                        
                                    }
    				)            
 
 
 	var arrBotonesProceso=	[
    							
                                
                                {
                                    
                                    icon:'../images/firma.png',
                                    cls:'x-btn-text-icon',
                                    hidden:true,
                                    height:50,
                                    width:170,
                                    id:'btnCertificacionProceso',
                                    text:'Certificar proceso',
                                    handler:function(btn)
                                            {
                                                var oConfiguracion=btn.oConfiguracion;
                                                var arrAcciones='';
                                                var x;
                                                var accion;
                                                var oAccion='';
                                                for(x=0;x<oConfiguracion.arrAcciones.length;x++)
                                                {
                                                      accion=oConfiguracion.arrAcciones[x];
                                                      oAccion='{"idAccion":"'+accion.idAccion+'","etiquetaAccion":"'+accion.etiquetaAccion.replace(/"/gi,"'")+'","etapaEnvio":"'+accion.etapaEnvio+'"}';
                                                      if(arrAcciones=='')
                                                          arrAcciones=oAccion;
                                                      else
                                                          arrAcciones+=','+oAccion;
                                                }
                                                
                                                var cadConf='{"funcionManejoResultado":"procesoCertificacionFirmaRealizado","idFormulario":"'+gE('idFormularioAux').value+'","idRegistro":"'+gE('idRegistroAux').value+
                                                              '","actor":"'+bD(gE('actor').value)+'","arrAcciones":['+arrAcciones+']}';
                                                if(typeof(moduloCertificacionCargado)=='undefined')
                                                {
                                                      if(oConfiguracion.urlModuloCertificacion!='')
                                                          loadScript(oConfiguracion.urlModuloCertificacion,function()
                                                                                                          {
                                                                                                              eval(oConfiguracion.funcionModuloFirma+'(cadConf);');
                                                                                                          }
                                                                  )	
                                                }
                                                else
                                                {
                                                  eval(oConfiguracion.funcionModuloFirma+'(cadConf);');
                                                }
                                                
                                            }
                                    
                                },     
                                                                                                                               
                                
                              
                              
                              {
                                    
                                  icon:'../principalPortal/imagesSIUGJ/verHistorial.png',
                                  cls:'x-btn-text-icon',                                                                                                            
                                  id:'btnHistorial',
                                  height:50,
                                  width:170,
                                  hidden:gE('idRegistroAux').value=='-1',
                                  text:'Ver historial',
                                  handler:function()
                                          {
                                              mostrarHistorial();
                                          }
                                  
                              }
                              ,
                              {
                                    
                                  icon:'../principalPortal/imagesSIUGJ/documentosAdjuntos.png',
                                  cls:'x-btn-text-icon',                                                                                                            
                                  id:'btnDocumentos',
                                   height:50,
                                   width:170,
                                  enableToggle :true,
                                  //hidden:<?php echo ($nDocumentosAsociados==0)?"true":"false"?>,
                                  hidden:!mostrarBotonDocumentosAdjuntos,
                                  text:'Documentos asociados',
                                  
                                  toggleHandler:function(btn,accion)
                                              {
                                                  if(accion)
                                                      gEx('pDocumentos').expand()
                                                  else
                                                      gEx('pDocumentos').collapse()
                                              }
                                  
                              },
                              {
                                    
                                    icon:'../principalPortal/imagesSIUGJ/verProcesos.png',
                                    cls:'x-btn-text-icon',
                                     height:50,
                                     width:170,
                                    hidden:((iFormularioPadreRegistro=='-1')|| !mostrarBotonProcesosAsociados),
                                    id:'btnProcesoAsociado',
                                    text:'Ver proceso asociado',
                                    handler:function()
                                            {
                                                var obj={};    
                                                obj.ancho='100%';
                                                obj.alto='100%';
                                                obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                obj.params=[['idFormulario',iFormularioPadreRegistro],['idRegistro',iReferenciaRegistro],['idReferencia',-1],
                                                        ['dComp',bE('auto')],['actor',bE(0)]];
                                                abrirVentanaFancy(obj);
                                            }
                                    
                                }
                              
                              <?php
                                  echo $cadMenu;
                              ?>
                                ]
 	var posBtn=0;
    for(posBtn=0;posBtn<arrBtn.length;posBtn++)
    {
    	arrBotonesProceso.push('-');
        arrBotonesProceso.push(arrBtn[posBtn]);
    }
    var viewport = new Ext.Viewport(
    									{
                                            id:'vContenedor',
                                            layout: 'border',
                                            items: [
                                            			{
                                                        	xtype:'panel',
                                                            region:'center',
                                                            id:'panelContenedor',
                                                            baseCls: 'x-plain',
                                                            layout: 'border', 
                                                            items:	[
                                                                         {
                                                                        	xtype:'panel',
                                                                            region: 'north',
                                                                           	border:false,
                                                                            height:80,
                                                                            id:'panelBarra',
                                                                            items:	[
                                                                            			{
                                                                                        	xtype:'label',
                                                                                            html:'<div><span id="spBarra"></span><div class="btnCerrarVentana" onclick="javascript:cerrarVentana()"></div></div>'
                                                                                            
                                                                                        }
                                                                            		]
                                                                         } ,
                                                            			 {
                                                                        	xtype:'panel',
                                                                            region: 'west',
                                                                            border: true,
                                                                            collapsible:true,
                                                                            hidden:true,
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
                                                                            border:false,
                                                                            layout:'border',
                                                                            items:	[
                                                                                        {
                                                                                            xtype:'tabpanel',
                                                                                            enableTabScroll:true,
                                                                                            cls:'tabPanelCentralSIUGJ',
                                                                                            id:'tPanelCentral',
                                                                                            activeTab:0,
                                                                                            border:false,
                                                                                            region:'center',
                                                                                            tbar:	new Ext.Toolbar	(
                                                                                            							{
                                                                                                                        	cls:'toolBarVistaProceso',
                                                                                                                        	items:arrBotonesProceso
                                                                                                                        }
                                                                                            						),
                                                                                            items:	[
                                                                                                        {
                                                                                                            xtype:'panel',
                                                                                                            title:'<?php echo cv($nombreFormulario)?>',
                                                                                                            id:'panelBase',
                                                                                                            listeners:	{
                                                                                                            				activate:function(p)
                                                                                                                                      {
                                                                                                                                          marcarOpcionActiva(p);
                                                                                                                                      },
                                                                                                                                      
                                                                                                                        	resize:function()
                                                                                                                            		{
                                                                                                                                    	//generarMenuOpciones()
                                                                                                                                    }              
                                                                                                            			},
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
                                                                                                                                                                            body[0].onclick=cerrarMenusActivos;
                                                                                                                                                                            marcarOpcionActiva(gEx('panelBase'));
                                                                                                                                                                        } 
                                                                                                                                                })
                                                                                                                       ]
                                                                                                          }
                                                                                        
                                                                                                    ]
                                                                                        }
                                                                                    ]
                                                                        },
                                                                         {
                                                                        	xtype:'panel',
                                                                            region: 'east',
                                                                            border: true,
                                                                            id:'pDocumentos',
                                                                            collapsible:true,
                                                                            //collapsed:true,
                                                                            hideCollapseTool:true,
                                                                            title:'Documentos asociados',
                                                                            cls:'gridSiugjVistaExpedienteUsuario',
                                                                            hidden:!mostrarBotonDocumentosAdjuntos,
                                                                            width: 280,
                                                                            layout:'border',
                                                                        	items:	[
                                                                            			
                                                                            			crearGridDocumentosAdjuntos()
                                                                            
                                                                                        
                                                                                       
                                                                                    ]
                                                                                      
                                                                         },
                                                                        {
                                                                            xtype:'tabpanel',
                                                                            height:350,
                                                                            cls:'tabPanelSIUGJ',
                                                                            id:'panelListadoRegistros',
                                                                            hidden:true,
                                                                            region:'south',
                                                                            items:	[
                                                                                    ]
                                                                       
                                                                        }
                                                                       
                                                                    ]
                                                         }
                                                    ],
                                        	listeners:	{
                                            				afterrender:function()
                                                            			{
                                                                        	if(typeof(functionActerRenderer)!='undefined')
                                                                        		functionActerRenderer();
                                                                        },
                                            				resize:function()
                                                            		{
                                                                    	setTimeout(function()
                                                                        			{
                                                                                    	//gEx('panelBarra').setHeight(obtenerAlturaElemento('divBarra'));
                                                                                        gEx('vContenedor').doLayout();
                                                                                     },1000);
                                                                        
                                                                    	
                                                                    }
                                                            
                                            			}
                                            
                                    	}
                                  	);
                                    
                                    
	gEx('arbolOpciones').on('click',funcClikArbol); 
    //gEx('pDocumentos').hide();
    
    <?php
	
	if(isset($_SESSION["funcionCargaProceso"]) && ($_SESSION["funcionCargaProceso"]!=""))
	{
		if(isset($_SESSION["funcionRetrasoCargaProceso"]))
		{
	?>
    		setTimeout(function(){ <?php echo $_SESSION["funcionCargaProceso"].";"; ?> }, <?php echo $_SESSION["funcionRetrasoCargaProceso"]; ?>);
    <?php
		}
		else
			echo $_SESSION["funcionCargaProceso"].";";

		if(!isset($_SESSION["funcionCargaUnicaProceso"]) || ($_SESSION["funcionCargaUnicaProceso"]=="1"))
		{
			$_SESSION["funcionCargaProceso"]="";
			$_SESSION["funcionCargaUnicaProceso"]=1;
			
		}
	}
	?>
    if(mostrarBotonDocumentosAdjuntos)
    {
    	setTimeout(function()
                    {
                        gEx('pDocumentos').collapse();
                     },500);
    }
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
                                    actor:gE('actor').value,
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
                        actor:gE('actor').value,
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
                                    				activate:function(p)
                                                              {
                                                                  marcarOpcionActiva(p);
                                                              },
                                                    close:function(p)
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
                                                                                style: 'width:100%;height:100%' ,
                                                                                loadFuncion: function(el)
                                                                                            {
                                                                                                var body=gEx('frameGrid_'+idFormulario).getFrameDocument().getElementsByTagName('body');
                                                                                                body[0].onclick=cerrarMenusActivos;
                                                                                                marcarOpcionActiva(gEx('pGrid_'+idFormulario));
                                                                                            }
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
                            actor:bD(gE('actor').value),
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
        actor:gE('actor').value,
        o.titulo=objConf.titulo;
        o.params=[['actor',gE('actor').value],['eJE',bE('window.parent.registroSeccionPaginaEliminado('+objConf.idFormularioReferencia+','+objConf.modalidad+');')],['pM',(objConf.soloLectura=='1')?'0':'1'],['pE',(objConf.soloLectura=='1')?'0':'1'],['accionCancelar','window.parent.cerrarVentanaFancySinConfirmacion()'],['cPagina','sFrm=true'],['idFormulario',objConf.idFormularioReferencia],['idReferencia',objConf.idReferencia],['idRegistro',objConf.idRegistroReferencia]];
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
                                    actor:gE('actor').value,
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
                                                    				activate:function(p)
                                                                    		{
                                                                            	marcarOpcionActiva(p);
                                                                            },
                                                    				
                                                                   
                                                                    
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
                                                                                                style: 'width:100%;height:100%' ,
                                                                                                loadFuncion: function(el)
                                                                                                            {
                                                                                                                
                                                                                                                var body=gEx('frameFormulario_'+objConf.idFormularioReferencia).getFrameDocument().getElementsByTagName('body');
                                                                                                                body[0].onclick=cerrarMenusActivos;
                                                                                                                marcarOpcionActiva(gEx(idPanel));
                                                                                                            }
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
                                    actor:gE('actor').value,
                                    idFormulario:gE('idFormularioAux').value,
                                    idReferencia:gE('idReferencia').value,
                                    idRegistro:gE('idRegistroAux').value,
                                    idProcesoP:gE('idProcesoP').value,
                                    idUsuario:gE('idUsuario').value,
                                    eJs:bE('window.parent.registroSeccionBaseRealizado("'+bE(cadConf)+'",@idRegistro)|'+bD(gE('eJs').value))
                                }

            var objParametrosProceso={};                    
            var parametrosProceso=gE('parametrosProceso').value;                   
			if(parametrosProceso!='')
            {
                objParametrosProceso=eval('['+bD(parametrosProceso)+']')[0];
                
            }

            if(objParametrosProceso)
            {
                for(campo in objParametrosProceso)
                {
                	oParametros[campo]=objParametrosProceso[campo];
                   
                }
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
            

            
            if(!gEx('tblCenter').cargado)
            {
                gEx('tblCenter').load	(
                                            {
                                                url:URL,
                                                params:oParametros,
                                                scripts:true
                                            }
                                        )
                gEx('tblCenter').cargado=true;   
            }                                 
             
			
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
	fichaBaseMostrada=false;
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
        o.params=[['idFormularioProceso',objConf.idFormularioProceso],['actor',gE('actor').value],['sL',objConf.soloLectura],['modalidad',objConf.modalidad],['accionCancelar','window.parent.cerrarVentanaFancySinConfirmacion()'],['cPagina','sFrm=true'],['idFormulario',<?php echo $idFormulario?>],['idRegistro',<?php echo $idRegistro?>]];
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
                                actor:gE('actor').value,
                                idFormularioProceso:objConf.idFormularioProceso,
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
                                                				activate:function(p)
                                                                          {
                                                                              marcarOpcionActiva(p);
                                                                          },
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
                                                                                            style: 'width:100%;height:100%' ,
                                                                                            loadFuncion: function(el)
                                                                                                        {
                                                                                                            
                                                                                                            var body=gEx('frameFormulario_'+objConf.idFormularioReferencia).getFrameDocument().getElementsByTagName('body');
                                                                                                            body[0].onclick=cerrarMenusActivos;
                                                                                                            marcarOpcionActiva(gEx(idPanel));
                                                                                                        }
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

function mostrarVentanaComentario(idFormulario,idRegistro,actor,objConf,ctrl)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:50,
                                                            cls:'controlSIUGJ',
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
										height:260,
										layout: 'fit',
										plain:true,
                                        cls:'msgHistorialSIUGJ',
										modal:true,
                                        closable:false,
                                        id:'vEnvioCambioEtapa',
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
                                                        	cls:'btnSIUGJCancel',
                                                            width:140,
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
                                                                    
														},
                                                        {
															cls:'btnSIUGJ',
                                                            width:140,
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{

                                                                    	var comentario=gEx('txtComentario').getValue();
                                                                        var objConfMsg={};
                                                                        objConfMsg.comentario=comentario;
                                                                        objConfMsg.idFormulario=idFormulario;
                                                                        objConfMsg.idRegistro=idRegistro;
                                                                        objConfMsg.actor=actor;
                                                                        objConfMsg.oConfiguracion=objConf;
                                                                        objConfMsg.ctrl=ctrl;
                                                                        
                                                                        
                                                                        
                                                                        funcionSometimientoProceso(objConfMsg);

																		
																	}
														}
													]
									}
								);
	ventanaAM.show();
}


function funcionSometimientoProceso(objConf)
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


                    var cerrarVentana=objConf.ctrl.objConf.cerrarVentana;
                    var objAperturaProceso=arrResp[2];
                    var objConfAperturaProceso=null;
                    if(objAperturaProceso!='')
                    {
                        objAperturaProceso=eval('['+objAperturaProceso+']')[0];
                        objConfAperturaProceso={};
                        objConfAperturaProceso.idFormulario=objAperturaProceso.idFormulario;
                        objConfAperturaProceso.idRegistro=objAperturaProceso.idRegistro;
                        objConfAperturaProceso.dComp=bE('auto');
                        objConfAperturaProceso.actor=bE(objAperturaProceso.actor);
                        cerrarVentana='0'
                    }
                    
                    if(gEx('vEnvioCambioEtapa'))
                    {
                    	gEx('vEnvioCambioEtapa').close();
                    }
                    
                    if(typeof(objConf.ctrl.objConf.functionAfterSubmit)!='undefined')	
                    {
                          
                          eval(objConf.ctrl.objConf.functionAfterSubmit+'();');
                    }
                    regresar1Pagina(cerrarVentana=='1');
                    
                    if((objConf.ctrl.objConf.cerrarVentana=='1')&&(objConfAperturaProceso))
                    {
                        var obj={};    
                        obj.ancho='100%';
                        obj.alto='100%';
                        obj.url='../modeloPerfiles/vistaDTDv3.php';
                        obj.params=[['idFormulario',objConfAperturaProceso.idFormulario],['idRegistro',objConfAperturaProceso.idRegistro],['idReferencia',-1],
                                ['dComp',objConfAperturaProceso.dComp],['actor',objConfAperturaProceso.actor]];
                        window.parent.abrirVentanaFancy(obj);
                        return;
                    }
                    
                    
                    if(cerrarVentana=='0')
                    {
                        var cadDatos='{"actor":"'+bE(arrResp[1])+'"}';
                        function funcAjax(peticion_http)
                        {
                            var resp=peticion_http.responseText;
                            arrResp=resp.split('|');
                            if(arrResp[0]=='1')
                            {
                                
                                if(objConfAperturaProceso)
                                {
                                    var obj={};    
                                    obj.ancho='100%';
                                    obj.alto='100%';
                                    obj.url='../modeloPerfiles/vistaDTDv3.php';
                                    obj.funcionCerrar=function()
                                                        {
                                                        	recargarPermisosProcesoActual()
                                                            procesoAperturado=false;
                                                        };
                                    procesoAperturado=true;
                                    obj.params=[['idFormulario',objConfAperturaProceso.idFormulario],['idRegistro',objConfAperturaProceso.idRegistro],['idReferencia',-1],
                                            ['dComp',objConfAperturaProceso.dComp],['actor',objConfAperturaProceso.actor]];
                                     abrirVentanaFancy(obj);
								}
                                else
                                {
                                	recargarPagina();
                                }                                 
                                
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
            obtenerDatosWebV2('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=39&comentario='+objConf.comentario+'&idFormulario='+
                            objConf.idFormulario+'&idRegistro='+objConf.idRegistro+'&actor='+objConf.actor+'&idPerfil='+objConf.ctrl.objConf.idPerfil+
                            '&idAccionesProcesoEtapaVSAcciones='+objConf.ctrl.objConf.idAccionesProcesoEtapaVSAcciones,true);

        }
    }
    msgConfirm(objConf.ctrl.objConf.msgConf,resp);
}


function recargarContenedorCentral(iFormulario,iRegistro)
{
	recargarMenuDTD();
    
     if(window.parent.recargarContenedorCentral)
		window.parent.recargarContenedorCentral(iFormulario,iRegistro);    
    
    
    /*if(procesoAperturado)
    {
    	procesoAperturado=false;
        recargarPermisosProcesoActual();
        return;
    }*/
    
    
    if((iFormulario)&&(gEx('frameGrid_'+iFormulario)))
    {

	    gEx('frameGrid_'+iFormulario).getFrameWindow().gEx('gridRegistros').getStore().reload();	
    }
    else
    {
		var arrPanel=gEx('tPanelCentral').getActiveTab().id.split('_');
        if(gEx('frameFormulario_'+arrPanel[1]))
        {
            if(gEx('frameFormulario_'+arrPanel[1]).getFrameWindow().recargarContenedorCentral)
            {
                gEx('frameFormulario_'+arrPanel[1]).getFrameWindow().recargarContenedorCentral(iFormulario,iRegistro);
            }
		}
        else
        {

        	if((gEx(gEx('tPanelCentral').getActiveTab().id).getFrameWindow)&&(gEx(gEx('tPanelCentral').getActiveTab().id).getFrameWindow().recargarContenedorCentral))
            {
                gEx(gEx('tPanelCentral').getActiveTab().id).getFrameWindow().recargarContenedorCentral(iFormulario,iRegistro);
            }
            
        }
    }
    
    
    
}

function recargarPermisosProcesoActual()
{

	var idRegistro=gE('idRegistroAux').value;
    var idFormulario=gE('idFormularioAux').value;
    var actor=gE('actor').value;
	var cadObj='{"idFormulario":"'+bE(idFormulario)+'","idRegistro":"'+bE(idRegistro)+'","actor":"'+actor+'"}';

	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idFormulario',idFormulario],['idRegistro',idRegistro],['idReferencia',-1],
                    ['dComp',bE('auto')],['actor',arrResp[1]]];
            //window.parent.abrirVentanaFancy(obj);
            enviarFormularioDatos('../modeloPerfiles/vistaDTDv3.php',obj.params,'POST');
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=361&cadObj='+cadObj,true);

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
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'No se ha podido podido realizar la operaci&oacute;n debido a lo siguientes problemas:'
                                                            	
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
                                        cls:'msgHistorialSIUGJ',
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
                                                            cls:'btnSIUGJ',
                                                            width:140,
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
													 	new  Ext.grid.RowNumberer({width:40}),
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
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style="min-height:21px;height:auto;white-space: normal;';
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
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
                                                            stripeRows :false,
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
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

function crearTabPaginaDictamenSeccion(ctrl)
{
	var objConf=ctrl.objConfDictamenFinalComplementario;

    var idPanel='fPanel_'+objConf.idFormularioReferencia;
    var tPanelCentral=gEx('tPanelCentral');
    
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
																					style: 'width:100%;height:100%' ,
																					loadFuncion: function(el)
																								{
																									var body=gEx('frameFormulario_'+objConf.idFormularioReferencia).getFrameDocument().getElementsByTagName('body');
																									body[0].onclick=cerrarMenusActivos;
																									marcarOpcionActiva(gEx(idPanel));
																								}
																			})
												]
									}
						)
                      	                            
        tPanelCentral.setActiveTab(idPanel); 
        gEx(idPanel).confirmarCierre=true;
        

        var arrParam={
                        idFormulario:objConf.idFormularioReferencia,
                        idRegistro:'-1',
                        idReferencia:gE('idRegistroAux').value,
                        cPagina:'sFrm=true',
                        eJs:bE('window.parent.afterDictamenFinalDone('+gEx('btnDictamenFinal_'+objConf.idAccionesProcesoEtapaVSAcciones).objConfDictamenFinalComplementario.accionFinalizar+');return;'),
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

function generarMenuOpciones()
{
	var icono;
	var opciones=opcionesMenus;
    
    if(!opciones)
    	return;
	var maxColumnas=6;
    var tabla='<div id="divBarra" >'+
                    '<div class="wrapBarra">'+
                        '<div class="navBarra">'+
                        '<table class="tablaNavBarra"><tr>';
    var x;
    var etiqueta;
    var nColumna=0;
    var nodo;
    var objNodo;
    var colorLetra;
   	var subrayado='';
    
    
    for(x=0;x<opciones.length;x++)
    {
        nodo=opciones[x];
        
        objNodo=eval('['+bD(nodo.attributes.oConf)+']')[0];
        
       
        etiqueta=nodo.attributes.text;
        if(etiqueta.indexOf('*')!=-1)
        {
        	subrayado='border-bottom: solid 1px #F00 ';
        }
        else
        	subrayado='';
        
        etiqueta=etiqueta.replace('>*<','> <');
        icono=nodo.attributes.icon;
        
        if(nodo.attributes.icon.indexOf('bullet_green')!=-1)
        {
        	 icono='../images/bullet_green2.png';
        }
        else
        {
        	
            icono='../images/bullet_red2.png';
        }
        
        etiqueta='<td id="td_'+objNodo.idFormularioReferencia+'" class="tdMenuVistaDTD"><a id="opt_'+objNodo.idFormularioReferencia+'" href="javascript:seccionSeleccionada(\''+bE(nodo.id)+'\')">'+etiqueta+'</a></td>';
        
        tabla+=etiqueta;
        
        
    }
    
    
    tabla+='</tr></table>'+
        		'<div class="clearfix"></div>'+
        		'</div>'+
            '</div>'+
        '</div>';
    
    gE('spBarra').innerHTML=tabla;
	
}


function seccionSeleccionada(id)
{
	
    var pos=existeValorArregloObjetos(opcionesMenus,'id',bD(id));
	if(pos!=-1)
    {
    	funcClikArbol(opcionesMenus[pos]);
    }

}

function marcarOpcionActiva(p)
{

	if(idFormularioActivo)
    {
    	if(gE('td_'+idFormularioActivo))
	    	gE('td_'+idFormularioActivo).setAttribute('class','tdMenuVistaDTD');
    }
    
    if(p.id=='panelBase')
    {
    	idFormularioActivo=gE('idFormularioAux').value;
    }
    else
    {
    	var arrDatos=p.id.split('_');
        idFormularioActivo=arrDatos[1];
    }
  	
    if(gE('td_'+idFormularioActivo))
	    gE('td_'+idFormularioActivo).setAttribute('class','opcionSeleccionada');
	
}

function cerrarMenusActivos()
{
	Ext.menu.MenuMgr.hideAll();
}

function ejecutarFuncionIframe(funcion,params)
{
	
	var frameContenido=gEx('tPanelCentral').getActiveTab().items.items[0];
    var pagina=frameContenido.getFrameWindow();
    
    eval('pagina.'+funcion+'('+bD(params)+');');
}

function mostrarHistorial()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            frame:false,
											defaultType: 'label',
											items: 	[
														crearGridHistorial()

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial',
										width: 900,
                                        cls:'msgHistorialSIUGJ',
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
                                        shadow:false,
                                        closable:false,
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
                                                            cls:'btnSIUGJ',
                                                            width:160,
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

function crearGridHistorial()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'etapaOriginal'},
		                                                {name:'etapaCambio'},
		                                                {name:'responsable'},
                                                        {name: 'comentarios'}
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
                                                            sortInfo: {field: 'fechaOperacion', direction: 'DESC'},
                                                            groupField: 'fechaOperacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='241';
                                        proxy.baseParams.idFormulario=gE('idFormularioAux').value;
                                        proxy.baseParams.idRegistro=gE('idRegistroAux').value;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'Fecha',
                                                                width:210,
                                                                sortable:false,
                                                                menuDisabled :true,
                                                                align:'center',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val,meta,attr)
                                                                		{
                                                                        	meta.attr='style="height:auto;"';
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>'+val.format('H:i:s')+' hrs.');
                                                                        }
                                                            },
                                                            {
                                                                header:'Etapa original',
                                                                width:190,
                                                                menuDisabled :true,
                                                                sortable:false,
                                                                dataIndex:'etapaOriginal',
                                                                renderer:formatoTitulo2
                                                            },
                                                            {
                                                                header:'Etapa cambio',
                                                                width:190,
                                                                sortable:false,
                                                                menuDisabled :true,
                                                                dataIndex:'etapaCambio',
                                                                renderer:formatoTitulo2
                                                            },                                                            
                                                            {
                                                                header:'Responsable',
                                                                width:220,
                                                                menuDisabled :true,
                                                                sortable:false,
                                                                dataIndex:'responsable',
                                                                renderer:formatoTitulo3
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorial',
                                                        store:alDatos,
                                                        region:'center',
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,
                                                        cls:'gridSiugjSeccion',                                                                
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorial
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	
}

function formatearFilaHistorial(record, rowIndex, p, ds)
{
	var xf = Ext.util.Format;
    p.body = '<BR><p style="margin-left: 4em;margin-right: 4em;text-align:justify"><br><span class="letraInfoHistorialSIUGJ">Comentarios:<br><br>' + ((record.data.comentarios.trim()=="")?"(Sin comentarios)":record.data.comentarios) + '<span></p><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTitulo(val)
{
	return '<span class="letraInfoHistorialSIUGJ">'+val+'</span>';
}

function formatoTitulo2(val)
{
	return '<div class="letraInfoHistorialSIUGJ">'+val+'</div>';
}

function formatoTitulo3(val)
{
	return '<div class="letraInfoHistorialSIUGJ">'+(val)+'</div>';
}

function procesoCertificacionFirmaRealizado(o)  //{"accion":"","cadenaFirma":"","comentarios":""}
{
	if(typeof(o)=='string')
    	o=eval('['+o+']')[0];

	
    oConfiguracion=gEx('btnCertificacionProceso').oConfiguracion;
    var documentoFinal='0';
    
	var x;
    var etapa=0;
    for(x=0;x<oConfiguracion.arrAcciones.length;x++)
    {
    	if(oConfiguracion.arrAcciones[x].idAccion==o.accion)
        {
        	etapa=oConfiguracion.arrAcciones[x].etapaEnvio;
            documentoFinal=oConfiguracion.arrAcciones[x].documentoFinal;
        	break;
        }
    }

	var cadObj='{"accionFirma":"'+o.accion+'","idFormulario":"'+gE('idFormularioAux').value+'","idRegistro":"'+gE('idRegistroAux').value+'","comentario":"'+
    			cv(o.comentarios)+'","etapa":"'+etapa+'","actor":"'+bD(gE('actor').value)+'","cadenaFirma":"'+cv(o.cadenaFirma)+
                '","funcionEjecucion":"'+(o.funcionEjecucion?o.funcionEjecucion:'')+'","documentoFinal":"'+documentoFinal+
                '","idRegistroFormato":"'+o.idRegistroFormato+'"}';
                
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            regresar1Pagina(oConfiguracion.accionEjecucion=='1');    
            if(oConfiguracion.accionEjecucion=='0')
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
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=349&cadObj='+cadObj,true);
    
    
	

}


function mostrarVentanaAdjuntarDocumento()
{

	var oConfArchivo=gEx('btnAdjuntarDocumento').objConf;
	var idRegistroAux=gE('idRegistroAux').value;
    if(idRegistroAux=='-1')
    {
    	msgBox('Primero debe guardar el formato de captura');
    	return;
    }

	var tabla='<div><input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; width: 290px" /></div><div class="flash" id="fsUploadProgress">'+ 
					'</div><input type="hidden" name="hidFileID" id="hidFileID" value="" /> ';       					
					
	var aTipoDocumentosConfiguracion=[];	
    
    var aCategoriaDocumentos=oConfArchivo.categoriaDocumento.split(',');
    				
	if(aCategoriaDocumentos.length>1)
    {
    	var xAux;
        var pos;
        for(xAux=0;xAux<aCategoriaDocumentos.length;xAux++)
        {
        	if(aCategoriaDocumentos[xAux]!='0')
            {
            	pos=existeValorMatriz(arrTipoDocumento,aCategoriaDocumentos[xAux]);
        		aTipoDocumentosConfiguracion.push(arrTipoDocumento[pos]);
            }
        }
    }
    else
    {
    	if(aCategoriaDocumentos[0]=='0')
        {
        	aTipoDocumentosConfiguracion=arrTipoDocumento;
        }
        else
        {
        	var pos=existeValorMatriz(arrTipoDocumento,aCategoriaDocumentos[0]);
        	aTipoDocumentosConfiguracion.push(arrTipoDocumento[pos]);
        }
    }                    
                    
                    

	
	
    
    
    
    
    
    
    var cObj={

                    upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                    file_post_name: "archivoEnvio",
     
                    // Flash file settings
                    file_size_limit : ((oConfArchivo.tamanoMaximo=='')||(oConfArchivo.tamanoMaximo=='0'))?'1000 MB':(oConfArchivo.tamanoMaximo+' '+oConfArchivo.unidadTamano),
                    file_types : oConfArchivo.extensionesPermitidas==''?'*.*':oConfArchivo.extensionesPermitidas,			// or you could use something like: "*.doc;*.wpd;*.pdf",
                    file_types_description : "Todos los archivos",
                    file_upload_limit : 0,
                    file_queue_limit : 1,
     
                   
                    upload_success_handler : subidaCorrecta,
                    
                    
                }
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	xtype:'label',
                                                            x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Tipo de documento a adjuntar:'
                                                        },
                                                        {
                                                            x:280,
                                                            y:15,                                                                                            
                                                            html:'<div id="dComboTipoDocumental"></div>'
                                                        },
                                                        
                                                      
                                                          {
                                                              xtype:'label',
                                                              x:10,
                                                              y:70,
                                                              cls:'SIUGJ_Etiqueta',
                                                              html:'Documento a adjuntar:'
                                                          },
                                                          {
                                                            x:280,
                                                            y:65,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right"><span style="font-size:11px" class="SIUGJ_Etiqueta">Porcentaje de avance:</span> <span style="font-size:11px" id="porcentajeAvance" class="SIUGJ_Etiqueta"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:590,
                                                            y:63,
                                                            id:'btnUploadFile',
                                                            width:120,
                                                            icon:'../images/add.png',
                                                            
                                                            xtype:'button',
                                                            cls:'btnSIUGJCancel',
                                                            text:'Seleccionar',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
                                                        {
                                                            x:720,
                                                            y:63,
                                                            width:120,
                                                            cls:'btnSIUGJCancel',
                                                            id:'btnScanFile',
                                                            icon:'../images/scanner.png',
                                                            
                                                            xtype:'button',
                                                            text:'Escanear',
                                                            hidden:ventanaAdjuntaDocumento==0,
                                                            handler:function()
                                                                    {
                                                                        var cadObj='{"afterScanFunction":"scanCorrectoDocument"}';
                                                                        var obj={};
                                                                        obj.ancho='100%';
                                                                        obj.alto='100%';
                                                                        obj.url='../scan/tLatisScanner.php';
                                                                        obj.params=[['cadObj',bE(cadObj)]];
                                                                        abrirVentanaFancy(obj);
                                                                        
                                                                        
                                                                        
                                                                    }
                                                        },
							 							{
                                                            x:185,
                                                            y:10,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo'

                                                        },
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        } ,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:70,
                                                            hidden:true,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:10,
                                                            y:100,
                                                            hidden:true,
                                                            width:600+ventanaAdjuntaDocumento,
                                                            height:60,
                                                            id:'txtDescripcion'
                                                        }

													]
										}
									);
	
    
    
	var ventanaAM = new Ext.Window(
									{
										title: 'Adjuntar documento',
										width: ventanaAdjuntaDocumento==0?750:860,
                                        cls:'msgHistorialSIUGJ',
                                        id:'vDocumento',
										height:250,
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
                                                                       cmbTipoDocumento=crearComboExt('cmbTipoDocumento',aTipoDocumentosConfiguracion,0,0,400,{renderTo:'dComboTipoDocumental',ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl'});
                                                                        
                                                                       if(aTipoDocumentosConfiguracion.length==1)
                                                                        {
                                                                            var pos=obtenerPosFila(gEx('cmbTipoDocumento').getStore(),'id',aTipoDocumentosConfiguracion[0][0]);
                                                                            if(pos!=-1)
                                                                            {
                                                                                gEx('cmbTipoDocumento').setValue(aTipoDocumentosConfiguracion[0][0]);
                                                                                gEx('cmbTipoDocumento').disable();
                                                                             }
                                                                            
                                                                        }
                                                                       
                                                                        
                                                                       crearControlUploadHTML5(cObj);
                                                                	
                                                                        
                                                                
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            width:140,
															cls:'btnSIUGJCancel',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            width:140,
															cls:'btnSIUGJ',
															handler: function()
																	{
                                                                    	if(gEx('cmbTipoDocumento').getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	gEx('cmbTipoDocumento').focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de documento adjuntar');
                                                                            return;
                                                                        }
                                                                    	
																		
                                                                       
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                            msgBox('Debe ingresar el documento que desea adjuntar');
                                                                            return;
                                                                        }
                                                                        uploadControl.start();
                                                                       
																	}
														}
														
													]
									}
								);
	ventanaAM.show();

	
}

function scanCorrectoDocument(idDocumento,nombreDocumento)
{
	gEx('vDocumento').hide();
    gEx('pDocumentos').expand();
	subidaCorrecta({}, '1|'+idDocumento+'|'+nombreDocumento);
    cerrarVentanaFancy(); 
}

function subidaCorrecta(file, serverData) 
{


    file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
    var arrDatos=serverData.split('|');

    if ( arrDatos[0]!='1') 
    {

    } 
    else 
    {
        
        gEx("idArchivo").setValue(arrDatos[1]);
        gEx("nombreArchivo").setValue(arrDatos[2]);
       	if(gE('txtFileName'))
	        gE('txtFileName').value=arrDatos[2];
        
        
        var oConfArchivo=gEx('btnAdjuntarDocumento').objConf;
        
        var cadObj='{"idFormulario":"'+gE('idFormularioAux').value+'","idRegistro":"'+gE('idRegistroAux').value+'","idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+
        '","tipoDocumento":"'+gEx('cmbTipoDocumento').getValue()+'","descripcion":"'+cv(gEx('txtDescripcion').getValue())+'","asociarDocumentoExpediente":"'+oConfArchivo.asociarDocumentoExpediente+'"}';
    
        function funcAjax2(peticion_http)
        {
            var resp=peticion_http.responseText;
            
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                gEx('gDocumentosAdjuntos').getStore().reload();
                gEx('vDocumento').close();
                
            }
            else
            {
                
                msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
            }
        }
        obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax2, 'POST','funcion=23&cadObj='+cadObj,true);
        
        
        
    }
		
	
}


function afterDictamenFinalDone(cerrarVentana)
{
	regresar1Pagina(cerrarVentana==1);
	if(cerrarVentana==0)
	{
		function funcAjax1(peticion_http)
		{
		
			var resp=peticion_http.responseText;
			var arrResp=resp.split('|');
			if(arrResp[0]=='1')
			{
				
				var cadDatos='{"actor":"'+bE(arrResp[1])+'"}';
				function funcAjax(peticion_http2)
				{
					  var resp2=peticion_http2.responseText;
					  var arrResp2=resp2.split('|');
					  if(arrResp2[0]=='1')
					  {
						  recargarPagina();
					  }
					  else
					  {
						  msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp2[0]);
					  }
				}
				obtenerDatosWebV2('../paginasFunciones/funcionesEspecialesSistema.php',funcAjax, 'POST','funcion=3&nS='+gE('confPaginaRefrescar').value+'&cadObj='+cadDatos,false);
			}
			else
			{
			  	msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
			}
		
			
		}
		obtenerDatosWebV2('../paginasFunciones/funcionesProyectos.php',funcAjax1, 'POST','funcion=337&actor='+bD(gE('actor').value)+
						'&idFormulario='+gE('idFormularioAux').value+'&idRegistro='+gE('idRegistroAux').value+'&nRegistro=0&idPerfil='+idPerfil,false);
	}
}


function functionSometerRevision(ctrl)
{
	                                                             
    var solicitarComentarios=ctrl.objConf.solicitarComentarios=='1';
    var idReferencia=gE('idReferencia').value;
   
    var idRegistro=gE('idRegistroAux').value;
    var idFormulario=gE('idFormularioAux').value;
    var actor=gE('actor').value;
   
    if(solicitarComentarios)    
        mostrarVentanaComentario (idFormulario,idRegistro,actor,ctrl.objConf,ctrl);
    else
    {
        var comentario='';
        var objConfMsg={};
        objConfMsg.comentario=comentario;
        objConfMsg.idFormulario=idFormulario;
        objConfMsg.idRegistro=idRegistro;
        objConfMsg.actor=actor;
        objConfMsg.oConfiguracion=ctrl.objConf;
        objConfMsg.ctrl=ctrl;
        funcionSometimientoProceso(objConfMsg);
    }
}


function mostrarVentanaSeleccionDictamen(ctrl)
{

	var objConf=ctrl.objConfiguracion;

    var solicitarComentarios=objConf.mostrarComentarios=='1';
    var idReferencia=gE('idReferencia').value;
   
    var idRegistro=gE('idRegistroAux').value;
    var idFormulario=gE('idFormularioAux').value;
    var actor=gE('actor').value;
   
    if(solicitarComentarios)    
        mostrarVentanaComentarioDictamen (idFormulario,idRegistro,actor,objConf,ctrl);
    else
    {
        var comentario='';
        var objConfMsg={};
        objConfMsg.comentario=comentario;
        objConfMsg.idFormulario=idFormulario;
        objConfMsg.idRegistro=idRegistro;
        objConfMsg.actor=actor;
        objConfMsg.oConfiguracion=objConf;
        objConfMsg.ctrl=ctrl;
        objConfMsg.etapaCambio=objConf.etapaCambio;
        objConfMsg.etiqueta=objConf.etiqueta;
        objConfMsg.idPerfil=objConf.idPerfil;
        objConfMsg.cerrarVentana=false;
        funcionDictamenFinalProceso(objConfMsg);
    }
}

function mostrarVentanaComentarioDictamen(idFormulario,idRegistro,actor,objConf,ctrl)
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
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                             cls:'controlSIUGJ',
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
										height:260,
                                        id:'vEnvioCambioEtapa',
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
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
                                                                    	
                                                                        var comentario=gEx('txtComentario').getValue();
                                                                        var objConfMsg={};
                                                                        objConfMsg.comentario=comentario;
                                                                        objConfMsg.idFormulario=idFormulario;
                                                                        objConfMsg.idRegistro=idRegistro;
                                                                        objConfMsg.actor=actor;
                                                                        objConfMsg.oConfiguracion=objConf;
                                                                        objConfMsg.ctrl=ctrl;
                                                                        objConfMsg.etapaCambio=objConf.etapaCambio;
                                                                        objConfMsg.etiqueta=objConf.etiqueta;
                                                                        objConfMsg.idPerfil=objConf.idPerfil;
                                                                        objConfMsg.cerrarVentana=objConf.cerrarVentana;
                                                                        funcionDictamenFinalProceso(objConfMsg);
                                                                        	
                                                                            	
                                                                            
                                                                               
                                                                    
                                                                           
																		
																	}
														}
                                                        
													]
									}
								);
	ventanaAM.show();
}


function funcionDictamenFinalProceso(objConf)
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
                    var cerrarVentana=objConf.cerrarVentana;
                    var objAperturaProceso=arrResp[2];
                    var objConfAperturaProceso=null;
                    if(objAperturaProceso!='')
                    {
                        objAperturaProceso=eval('['+objAperturaProceso+']')[0];
                        objConfAperturaProceso={};
                        objConfAperturaProceso.idFormulario=objAperturaProceso.idFormulario;
                        objConfAperturaProceso.idRegistro=objAperturaProceso.idRegistro;
                        objConfAperturaProceso.dComp=bE('auto');
                        objConfAperturaProceso.actor=bE(objAperturaProceso.actor);
                        cerrarVentana='0'
                    }
                    
                    if(gEx('vEnvioCambioEtapa'))
                    {
                    	gEx('vEnvioCambioEtapa').close();
                    }
                    
                    if(typeof(objConf.ctrl.objConfiguracion.functionAfterSubmit)!='undefined')	
                    {
                          
                          eval(objConf.ctrl.objConfiguracion.functionAfterSubmit+'();');
                    }
                    regresar1Pagina(cerrarVentana=='1');
                    
                    if((objConf.cerrarVentana=='1')&&(objConfAperturaProceso))
                    {
                        var obj={};    
                        obj.ancho='100%';
                        obj.alto='100%';
                        obj.url='../modeloPerfiles/vistaDTDv3.php';
                        obj.params=[['idFormulario',objConfAperturaProceso.idFormulario],['idRegistro',objConfAperturaProceso.idRegistro],['idReferencia',-1],
                                ['dComp',objConfAperturaProceso.dComp],['actor',objConfAperturaProceso.actor]];
                        window.parent.abrirVentanaFancy(obj);
                        return;
                    }
                    
                    
                    if(cerrarVentana=='0')
                    {
                        var cadDatos='{"actor":"'+bE(arrResp[1])+'"}';
                        function funcAjax(peticion_http)
                        {
                            var resp=peticion_http.responseText;
                            arrResp=resp.split('|');
                            if(arrResp[0]=='1')
                            {
                                if(objConfAperturaProceso)
                                {
                                    var obj={};    
                                    obj.ancho='100%';
                                    obj.alto='100%';
                                    obj.url='../modeloPerfiles/vistaDTDv3.php';
                                    obj.modal=true;
                                    obj.funcionCerrar=function()
                                                        {
                                                            recargarPermisosProcesoActual();
                                                            procesoAperturado=false;
                                                        };
                                    procesoAperturado=true;
                                    obj.params=[['idFormulario',objConfAperturaProceso.idFormulario],['idRegistro',objConfAperturaProceso.idRegistro],['idReferencia',-1],
                                            ['dComp',objConfAperturaProceso.dComp],['actor',objConfAperturaProceso.actor]];
                                     abrirVentanaFancy(obj);
								}
                                else
                                {
                                	recargarPagina();
                                }                                 
                                
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
            
			obtenerDatosWebV2('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=350&comentario='+cv(objConf.comentario)+
                            '&idFormulario='+objConf.idFormulario+'&idRegistro='+objConf.idRegistro+'&actor='+objConf.actor+'&idPerfil='+objConf.idPerfil+
                            '&etapaCambio='+objConf.etapaCambio+'&idAccionesProcesoEtapaVSAcciones='+
							objConf.ctrl.objConfDictamenFinalComplementario.idAccionesProcesoEtapaVSAcciones+
                             '&idFormularioDictamen='+objConf.ctrl.objConfDictamenFinalComplementario.idFormularioReferencia+
							'&valorResultado='+objConf.ctrl.objConfiguracion.valorOpcion,true);


        }
    }
    msgConfirm('¿Est&aacute; seguro de querer asentar como resultado: <b>'+objConf.etiqueta+'</b>?',resp);
}




function removerDocumento(idDocumento)
{
	detenerEvento();
	var cadObj='{"idFormulario":"'+gE('idFormularioAux').value+'","idRegistro":"'+gE('idRegistroAux').value+
    			'","idDocumento":"'+bD(idDocumento)+'"}';
    
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
                    gEx('gDocumentosAdjuntos').getStore().reload();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWebV2('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=351&cadObj='+cadObj,true);
        }
    }
    msgConfirm('¿Est&aacute; seguro de querer remover el documento seleccionado?',resp);
    
}

function frameLoad(iFrame)
{
	if(typeof(frameLoadPersonalizado)=='undefined')
    {

        if((!primeraCargaFrame)&&(!deshabiltarCargaIframe))
        {
            ocultarMensajeProcesando();
            
            setTimeout(function()
        			{
						
			iFrame.contentWindow.print();
			gEx('gDocumentosAdjuntos').getStore().reload();
                    },2000
                   );
            
        }
        else
            primeraCargaFrame=false;
     }
     else
     	frameLoadPersonalizado(iFrame);
	
}


function imprimirFormularioActivo()
{
	var panel=gEx('tPanelCentral').getActiveTab();
    if(panel.id=='panelBase')
    {
    	if(gEx('tblCenter').getFrameWindow().imprimirFormulario)
        {
        	
        	gEx('tblCenter').getFrameWindow().imprimirFormulario();
        }
    }
    else
    {
    	var arrFormulario=panel.id.split('_');
        
	    if(gEx('frameFormulario_'+arrFormulario[1]) && (gEx('frameFormulario_'+arrFormulario[1]).getFrameWindow().imprimirFormulario))
        {
        	gEx('frameFormulario_'+arrFormulario[1]).getFrameWindow().imprimirFormulario();
        }
    }
}

function ejecutarInvocacionPaginaScript(url,imprimir,iF,iR)
{
	primeraCargaFrame=!imprimir;
    var arrParametros=[['idRegistro',iR],['idFormulario',iF]];
    enviarFormularioDatos(url,arrParametros,'POST','frameDTD');
}


function cerrarVentana()
{
	function resp(btn)
    {
        if(btn=='yes')
            window.parent.cerrarVentanaFancy();
    }
    msgConfirm('¿Est&aacute; seguro de querer finalizar la sesi&oacute;n de trabajo sobre este proceso?',resp);
}

function crearGridDocumentosAdjuntos()
{
	  
       var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'nombreDocumento'},
		                                                {name:'nombreDocumentoCorto'},
                                                        {name: 'fechaDocumento',type:'date', dateFormat: 'Y-m-d H:i:s'},
                                                        {name: 'tamanoDocumento'},
                                                        {name: 'extension'},
                                                        {name: 'tipoDocumento'}
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
                                                            sortInfo: {field: 'fechaDocumento', direction: 'ASC'},
                                                            groupField: 'tipoDocumento',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='242';
                                        proxy.baseParams.iF=bE(gE('idFormularioAux').value);
                                        proxy.baseParams.iR=bE(gE('idRegistroAux').value);
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        {
                                                            header:'',
                                                            width:25,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'extension',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style="vertical-align: top;min-height:40px;height:auto;"';
                                                                        if((registro.data.tipoDocumento=='1')&&(permiteEliminarDocumento))
	                                                                    	return '<img style="cursor: pointer;" src="../imagenesDocumentos/16/file_extension_'+registro.data.extension+'.png" /><br /><br /><img style="cursor: pointer;" src="../principalPortal/imagesSIUGJ/remover.png" title="Remover documento" alt="Remover documento" onclick="javascript:removerDocumento(\''+bE(registro.data.idDocumento)+'\')" />';
                                                                    	else
                                                                        	return '<img style="cursor: pointer;" src="../imagenesDocumentos/16/file_extension_'+registro.data.extension+'.png"/>';
                                                                    }
                                                        },
                                                        {
                                                            header:'',
                                                            width:230,
                                                            sortable:true,
                                                            align:'left',
                                                            dataIndex:'nombreDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style="min-height:40px;height:auto;padding:10px;"';
                                                                    	return '<span title="'+val+'" alt="'+val+'">'+registro.data.nombreDocumentoCorto+'<br />'+registro.data.fechaDocumento.format('d/m/Y H:i')+
                                                                        		' hrs.<br />'+registro.data.tamanoDocumento+'</span>';
                                                                    }
                                                        },
                                                        {
                                                            header:'',
                                                            width:200,
                                                            sortable:true,
                                                            
                                                            dataIndex:'tipoDocumento',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val=='1'?'De referencia':'De resultado';
                                                                    }
                                                        }
                                                    ]
                                                );
                                 
    var arrOpciones=[];
    
    
    
                               
	
    var objConf=	{
                          id:'gDocumentosAdjuntos',
                          store:alDatos,
                          region:'center',
                          frame:false,
                          hideHeaders:true,
                          cm: cModelo,
                          stripeRows :false,
                          loadMask:true,
                          border:false,
                          columnLines : false,
                          cls:'gridSiugjPrincipal',
                          tbar:	 new Ext.Toolbar(
                          							{
                                                    	id:'tblDocumentosAdjuntos',
                                                    	items:	[
                          		
                                                                    {
                                                                        icon:'../principalPortal/imagesSIUGJ/add.png',
                                                                        cls:'x-btn-text-icon',
                                                                        width:270,
                                                                        id:'btnAdjuntarDocumento',
                                                                        text:'Adjuntar documento',
                                                                        handler:function()
                                                                                {
                                                                                    mostrarVentanaAdjuntarDocumento()
                                                                                }
                                                                        
                                                                    }
                                                                ]
                                                	}
                                                ),
                          
                          
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
    
                           
                                                
    var tblGrid=	new Ext.grid.GridPanel	(objConf);

	tblGrid.on('rowclick',function(grid, rowIndex, e)
                      {
                          var registro=gEx('gDocumentosAdjuntos').getStore().getAt(rowIndex);
                          mostrarVisorDocumentoProceso(registro.data.extension,registro.data.idDocumento,registro);
                      }
              )  

    return 	tblGrid;	
}
