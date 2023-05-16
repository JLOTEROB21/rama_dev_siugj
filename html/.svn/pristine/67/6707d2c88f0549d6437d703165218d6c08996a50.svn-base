<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");	
	
	$cA=$_GET["cA"];
	$arrPartes="";
	$listParteProcesal="";
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica where id__5_tablaDinamica in(10,2,3,4,5,9) order by nombreTipo";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);
	$arrParteProcesal="";
	$res=$con->obtenerFilas($consulta);
	while($filaFigura=mysql_fetch_row($res))
	{
		if($listParteProcesal=="")
			$listParteProcesal=$filaFigura[0];
		else
			$listParteProcesal.=",".$filaFigura[0];
		
		$oFigura=determinarLeyendaFiguraJuridica($filaFigura[0],-1,$cA)	;
		$filaFigura[1]=$oFigura[1];
			
		$consulta="SELECT idDetalle,etiquetaDetalle FROM _5_gDetallesTipo WHERE idReferencia=".$filaFigura[0];
		$arrEspecificacion=$con->obtenerFilasArreglo($consulta);
		$o="['".$filaFigura[0]."','".cv($filaFigura[1])."',".$arrEspecificacion."]";
		if($arrParteProcesal=="")
			$arrParteProcesal=$o;
		else
			$arrParteProcesal.=",".$o;
			
			
		$oMenu="	{
						cls:'x-btn-text-icon',
						text:'".$filaFigura[1]."',
						handler:function()
								{
									var objConf={};
									objConf.ocultaIdentificacion=true;
									objConf.ocultaEdoCivil=true;
									objConf.idActividad=-1;
									objConf.idCarpeta=gE('idCarpetaAdministrativa').value;
									objConf.afterRegister=function(idFigura,nombre,tipoParticipante)
														{
															selPersona='p_'+idFigura+'_'+tipoParticipante;
															gEx('arbolSujetos').getRootNode().reload();
															
														}

									agregarParticipanteVentana(".$filaFigura[0].",'".cv($filaFigura[1])."',objConf);
								}
						
					}";
		if($arrPartes=="")
			$arrPartes=$oMenu;
		else			
			$arrPartes.=",".$oMenu;			
		
	}
	if($listParteProcesal=="")
		$listParteProcesal=-1;
	
	$arrPartes="[".$arrPartes."]";	
	
	$consulta="SELECT idGenero,genero FROM 1005_generoUsuario";
	$arrGenero=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__378_tablaDinamica,nacionalidad FROM _378_tablaDinamica WHERE id__378_tablaDinamica<>1 ORDER BY nacionalidad";
	$arrNacionalidades=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=21 and claveElemento<>0";
	$arrTipoDiligencias=$con->obtenerFilasArreglo($consulta);
	
	$fechaActual=date("Y-m-d");
	
	
	$consulta="SELECT idDetalle,etiquetaDetalle FROM _5_gDetallesTipo";
	$arrEspecificacionParteProcesal=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__415_tablaDinamica,medioNotificacion FROM _415_tablaDinamica order by prioridad";
	$aMediosNotificacion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=22 order by claveElemento";
	$arrResultadoDiligencias=$con->obtenerFilasArreglo($consulta);
	
	$arrCentrosDetencion="";
	$oCentro='';
	$consulta="SELECT id__2_tablaDinamica,nombre,calle,numero,cp,(SELECT municipio FROM 821_municipios WHERE cveMunicipio=p.cveMunicipio)AS municipio,
			colonia,prefijo 
			FROM _2_tablaDinamica p WHERE id__2_tablaDinamica<>15 ORDER BY nombre";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		
		$domicilio=$fila[2]." No. ".$fila[3]." C.P. ".$fila[4]." Colonia ".$fila[6]." , ".$fila[5].", Ciudad de México";
		$oCentro="['".$fila[0]."','".cv($fila[1])."','".cv($domicilio)."','".$fila[7]."']";
		if($arrCentrosDetencion=="")
			$arrCentrosDetencion=$oCentro;
		else
			$arrCentrosDetencion.=",".$oCentro;
	}
	
	$consulta="SELECT id__32_tablaDinamica,LOWER(tipoIdentificacion) FROM _32_tablaDinamica WHERE id__32_tablaDinamica NOT IN(19,9999,13,17) ORDER BY 	tipoIdentificacion";

	$arrTipoIdentificacion=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idDetalle, descripcion FROM _415_gEspecificaciones order by prioridad";
	$aMediosNotificacionDetalle2=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
?>
var uploadControl;
var editorMail=null;
var editorMailSetValor='';
var urlConsultaDocumentos='';
var generaExposicion=true;
var borrarDiligencia=false;
var reprocesarDiligencia=false;
var nodoBandeja;
var arrRespNotificacion1=[['1','Se notific\xF3 a la persona'],['2','El n\xFAmero est\xE1 equivocado']];
var arrRespNotificacion2=[['1','No contest\xF3'],['2','El n\xFAmero NO existe'],['3','Otro']];
var selDiligencia='';
var arrSiNo=<?php echo $arrSiNo?>;
var arrTiempo=null;
var horaInicio=null;
var horaFin=null;
var arrResultadoDiligencia2daVisita=[['1','Se encontr\xF3 al destinatario'],['2','NO se encontr\xF3 al destinatario, recibe otra persona'],['3','NO se encontr\xF3 al destinatario, nadie atendi\xF3']];
var arrResultadoDiligencia=[['1','Se encontr\xF3 a la persona'],['2','No se encontr\xF3 a la persona, se dej\xF3 citatorio'],['3','En espera de resultado']];
var arrEtapasProcesales=[];
var arrCategorias=<?php echo $arrCategorias?>;
var arrMailDestinatario=[];
var arrMailAdjuntos=[];
var arrResultadoMail=[['1','Se obtuvo respuesta'],['0','NO se obtuvo respuesta'],['2','En espera de respuesta']];
var aMediosNotificacionDetalle2=<?php echo $aMediosNotificacionDetalle2?>;
var arrAudienciasNotifica=[];
var arrTipoIdentificacion=<?php echo $arrTipoIdentificacion?>;
var arrCentrosDetencion=[<?php echo $arrCentrosDetencion?>];
var arrResultadoDiligencias=<?php echo $arrResultadoDiligencias?>;
var arrResultadoDiligenciasMP=arrResultadoDiligencias;
var aMediosNotificacionCatalogo=<?php echo $aMediosNotificacion ?>;
var maxPasos=3;
var selPersona='';
var arrEspecificacionParteProcesal=<?php echo $arrEspecificacionParteProcesal?>;
var arrParteProcesal=[<?php echo $arrParteProcesal?>];
var listParteProcesal='<?php echo $listParteProcesal?>';
var arrNacionalidades=<?php echo $arrNacionalidades?>;
var arrTipoDiligencias=<?php echo $arrTipoDiligencias?>;
var arrTipoFigura=<?php echo $arrTipoFigura?>;
var arrGenero=<?php echo $arrGenero?>;
var nodoSujetoSel=null;
var nodoMedioSel=null;
var idParticipanteSel=-1;
var idDiligencia=-1;
var funcAfterLoadMedio=null;
var enviarPaso2=false;
var medioSel='';  
var selFilaDiligencia='';
Ext.onReady(inicializar);

function inicializar()
{
	selDiligencia=gE('idDiligencia').value=='-1'?'':gE('idDiligencia').value;
	selPersona=gE('selPersona').value;
	horaInicio=Date.parseDate('<?php echo $fechaActual?> 07:00:00','Y-m-d H:i:s');
	horaFin=Date.parseDate('<?php echo $fechaActual?> 21:59:00','Y-m-d H:i:s');
	arrTiempo=generarIntervaloHoras(horaInicio,horaFin,1,'H:i','H:i \\hr\\s.');
	arrAudienciasNotifica=eval(bD(gE('arrAudiencias').value));
	var cmbEstado=crearComboExt('cmbEstado',arrEstados,70,65,170);
    cmbEstado.on('select',obtenerMunicipios);
    var cmbMunicipio=crearComboExt('cmbMunicipio',[],320,65,180);

    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b></b></span>',                                               
                                                items:	[
                                                            {
                                                                xtype:'panel',
                                                                layout:'border',
                                                                region:'west',
                                                                width:250,
                                                                title:'Partes procesales',
                                                                items:	[
                                                                            crearArbolSujetosProcesales()
                                                                        ]
                                                            },
                                                            {
                                                            	xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                region:'center',
                                                                                layout:'border',
                                                                                items:	[
                                                                                			crearGridDiligencias()
                                                                                		]
                                                                            },
                                                                            
                                                                            {
                                                                            	id:'pContacto',
                                                                                collapsible:true,
                                                                                region:'south',
                                                                                height:260+(gE('vTAudiencia').value=='1'?15:0),
                                                                            	title:'Datos de contacto',
                                                                                layout:'border',
                                                                                items:	[
                                                                                			{
                                                                                                  xtype:'tabpanel',
                                                                                                  id:'panelContacto',
                                                                                                  activeTab:1,
                                                                                                  
                                                                                                  disabled:true,
                                                                                                  region:'center',  
                                                                                                  tbar:	[
                                                                                                            {
                                                                                                                icon:'../images/guardar.JPG',
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                hidden:gE('sL').value=='1',
                                                                                                                text:'Guardar datos de contacto',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            guardarDatosContacto();
                                                                                                                        }
                                                                                                                
                                                                                                            }
                                                                                                        ],                                                                                
                                                                                                  items:	[
                                                                                                              {
                                                                                                                  xtype:'panel',
                                                                                                                  id:'pDomicilio',
                                                                                                                  layout:'absolute',
                                                                                                                  title:'Domicilio',
                                                                                                                  bodyStyle:{"background-color":"#E8E8E8","font-size":"11px"}, 
                                                                                                                  defaultType: 'label',
                                                                                                                  items:	[
                                                                                                                              {
                                                                                                                                  x:10,
                                                                                                                                  y:10,
                                                                                                                                  html:'Calle:'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:70,
                                                                                                                                  y:5,
                                                                                                                                  xtype:'textfield',
                                                                                                                                  width:410,
                                                                                                                                  id:'txtCalle'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:510,
                                                                                                                                  y:10,
                                                                                                                                  html:'No. Ext:'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:590,
                                                                                                                                  y:5,
                                                                                                                                  xtype:'textfield',
                                                                                                                                  width:120,
                                                                                                                                  id:'txtNoExt'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:10,
                                                                                                                                  y:40,
                                                                                                                                  html:'No. Int:'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:70,
                                                                                                                                  y:35,
                                                                                                                                  xtype:'textfield',
                                                                                                                                  width:120,
                                                                                                                                  id:'txtNoInt'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:250,
                                                                                                                                  y:40,
                                                                                                                                  html:'Colonia:'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:320,
                                                                                                                                  y:35,
                                                                                                                                  xtype:'textfield',
                                                                                                                                  width:160,
                                                                                                                                  id:'txtColonia'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:510,
                                                                                                                                  y:40,
                                                                                                                                  html:'C.P.:'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:590,
                                                                                                                                  y:35,
                                                                                                                                  xtype:'textfield',
                                                                                                                                  width:100,
                                                                                                                                  id:'txtCP'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:10,
                                                                                                                                  y:70,
                                                                                                                                  html:'Estado:'
                                                                                                                              },
                                                                                                                              cmbEstado,
                                                                                                                              
                                                                                                                              {
                                                                                                                                  x:250,
                                                                                                                                  y:70,
                                                                                                                                  html:'Municipio:'
                                                                                                                              },
                                                                                                                             cmbMunicipio,
                                                                                                                              {
                                                                                                                                  x:510,
                                                                                                                                  y:70,
                                                                                                                                  html:'Localidad:'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:590,
                                                                                                                                  y:65,
                                                                                                                                  xtype:'textfield',
                                                                                                                                  width:160,
                                                                                                                                  id:'txtLocalidad'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:10,
                                                                                                                                  y:100,
                                                                                                                                  html:'Entre la calle:'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:105,
                                                                                                                                  y:95,
                                                                                                                                  xtype:'textfield',
                                                                                                                                  width:270,
                                                                                                                                  id:'txtEntreCalle'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:395,
                                                                                                                                  y:100,
                                                                                                                                  html:'y la calle:'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:470,
                                                                                                                                  y:95,
                                                                                                                                  xtype:'textfield',
                                                                                                                                  width:280,
                                                                                                                                  id:'txtYCalle'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:10,
                                                                                                                                  y:130,
                                                                                                                                  html:'Otras referencias:'
                                                                                                                              },
                                                                                                                              {
                                                                                                                                  x:130,
                                                                                                                                  y:125,
                                                                                                                                  xtype:'textarea',
                                                                                                                                  width:620,
                                                                                                                                  height:40,
                                                                                                                                  id:'txtReferencias'
                                                                                                                              }
                                                                                                                          ]
                                                                                                              },
                                                                                                              {
                                                                                                                  xtype:'panel',
                                                                                                                  layout:'absolute',
                                                                                                                  id:'pMail',
                                                                                                                  title:'Correo electr&oacute;nico - Tel&eacute;fonos',
                                                                                                                  bodyStyle:{"background-color":"#E8E8E8","font-size":"11px"}, 
                                                                                                                  defaultType: 'label',
                                                                                                                  items:	[
                                                                                                                                crearGridTelefono(),
                                                                                                                                crearGridMail()
                                                                                                                            ]
                                                                                                              }
                                                                                                          ]
                                                                                              }
                                                                                		]
                                                                            }
                                                                            
                                                                			
                                                                		]
                                                            }
                                                        ]
                                            }
                                         ]
                            }
                        )  
                        
	gEx('panelContacto').setActiveTab(0); 
    //mostrarVentanaAperturaNotificacionNotificador(bE('{"idOrden":"'+gE('idOrden').value+'"}'))                        
}

function crearArbolSujetosProcesales()
{
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
                                                                    funcion:'40',
                                                                    iC:gE('idCarpeta').value,
                                                                    cA:gE('carpetaJudicial').value,
                                                                    iO:gE('idOrden').value,
                                                                    sujetosProcesales:listParteProcesal
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            	nodoSujetoSel=null;
                               	gEx('btnAddDiligencia').disable();
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	if(selPersona!='')
                                {
                                	var nodo=gEx('arbolSujetos').getNodeById(selPersona);
                                    gEx('arbolSujetos').getSelectionModel().select(nodo);
                                    funcSujeto(nodo);
                                }
                            }
    				)										
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolSujetos',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:false,
                                                                region:'center',
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Agregar parte...',
                                                                                menu:	<?php echo $arrPartes?>
                                                                                
                                                                            },
                                                                            '-',
                                                                            {
                                                                                icon:'../images/wrench.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Herramientas',
                                                                                menu:	[
                                                                                			{
                                                                                                icon:'../images/page_white_gear.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Configuraci&oacute;n de correo saliente',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaConfiguracionCorreoSaliente();
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                		]
                                                                                
                                                                                
                                                                            }
                                                                            
                                                                		]
                                                            }
                                                        )
         
         
                                                    
	arbolSujetosJuridicos.on('click',funcSujeto);
	arbolSujetosJuridicos.on('dblclick',funcSujetodblClick);                           
	return  arbolSujetosJuridicos;
}

function funcSujeto(nodo, evento)
{
	nodoSujetoSel=nodo;

    if(nodo.attributes.tipo=='1')
    {
    	var arrDatosNodo=nodo.id.split('_');
        idParticipanteSel=arrDatosNodo[1];
        obtenerDatosContacto(idParticipanteSel);
        gEx('panelContacto').enable();
        gEx('btnAddDiligencia').enable();
        
    }
    else
    {
    	limpiarDatosContacto();
        gEx('panelContacto').disable();
        gEx('panelContacto').setActiveTab(0);
        gEx('btnAddDiligencia').disable();
        
    }
    
    
}

function funcSujetodblClick(nodo, evento)
{
	nodoSujetoSel=nodo;
    if(nodo.attributes.tipo=='3')
    {
    	var arrDocumento=nodo.attributes.nombreDocumento.split('.');
    	var extension=arrDocumento[arrDocumento.length-1];
		mostrarVisorDocumentoProceso(extension,nodo.attributes.idDocumento);
    }
}

function crearGridTelefono()
{
	var cmbTipoTelefono=crearComboExt('cmbTipoTelefono',arrTelefonos);
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'tipoTelefono'},
                                                                    {name: 'lada'},
                                                                    {name: 'numero'},
                                                                    {name: 'extension'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Tipo',
															width:100,
															sortable:true,
															dataIndex:'tipoTelefono',
                                                            editor:cmbTipoTelefono,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTelefonos,val);
                                                                    }
														},
														{
															header:'Lada',
															width:45,
															sortable:true,
															dataIndex:'lada',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
                                                        {
															header:'N&uacute;mero',
															width:130,
															sortable:true,
															dataIndex:'numero',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
                                                        {
															header:'Extensi&oacute;n',
															width:80,
															sortable:true,
															dataIndex:'extension',
                                                            editor:	{
                                                            			xtype:'numberfield',
                                                                        allowDecimals:false,
                                                                        allowNegative:false
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gTelefonos',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:150,
                                                            width:420,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Agregar tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'tipoTelefono'},
                                                                                                                        {name: 'lada'},
                                                                                                                        {name: 'numero'},
                                                                                                                        {name: 'extension'}
                                                                                                                    ]
                                                                                        						)
                                                                                   		var r=new reg	(
                                                                                        					{
                                                                                                            	tipoTelefono:'1',
                                                                                                                lada:'',
                                                                                                                numero:'',
                                                                                                                extension:''
                                                                                                            }
                                                                                        				)
                                                                                   
                                                                                    	gEx('gTelefonos').getStore().add(r);
                                                                                        gEx('gTelefonos').startEditing(gEx('gTelefonos').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Remover tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gTelefonos').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el tel&eacute;fono a remover');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gTelefonos').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el tel&eacute;fono seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function crearGridMail()
{
	
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'mail'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
                                                        {
															header:'E-Mail',
															width:250,
															sortable:true,
															dataIndex:'mail',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gMail',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:440,
                                                            y:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:150,
                                                            width:300,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Agregar E-Mail',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'mail'}
                                                                                                                    ]
                                                                                        						)
                                                                                   		var r=new reg	(
                                                                                        					{
                                                                                                            	mail:''
                                                                                                            }
                                                                                        				)
                                                                                   
                                                                                    	gEx('gMail').getStore().add(r);
                                                                                        gEx('gMail').startEditing(gEx('gMail').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Remover E-Mail',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gTelefonos').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la direcci&oacute;n de e-mail a remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gMail').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el e-mail seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function obtenerDatosContacto(idParticipanteContacto)
{

	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	limpiarDatosContacto();
        	oDatosContacto=eval('['+arrResp[1]+']')[0];

        	var telefonos='';
            var x;
            var o;
            var e;
            if(oDatosContacto.telefonos.length>0)
            {
            	for(x=0;x<oDatosContacto.telefonos.length;x++)	
                {
                	o=oDatosContacto.telefonos[x];
                	var reg=crearRegistro	(
                                                [
                                                    {name: 'tipoTelefono'},
                                                    {name: 'lada'},
                                                    {name: 'numero'},
                                                    {name: 'extension'}
                                                ]
                                            )
                    var r=new reg	(
                                        {
                                            tipoTelefono:o.tipoTelefono,
                                            lada:o.lada,
                                            numero:o.numero,
                                            extension:o.extension
                                        }
                                    )
               
                    gEx('gTelefonos').getStore().add(r);
                
                
                	
                    
                }
                
            }
            
            var email='';
            
            if(oDatosContacto.correos.length>0)
            {
            	
            	for(x=0;x<oDatosContacto.correos.length;x++)	
                {
                	o=oDatosContacto.correos[x];
                    var reg=crearRegistro	(
                                                [
                                                    {name: 'mail'}
                                                ]
                                            )
                    var r=new reg	(
                                        {
                                            mail:o.mail
                                        }
                                    )
               
                    gEx('gMail').getStore().add(r);
                }

            }
            
            gEx('txtCalle').setValue(oDatosContacto.calle);
            gEx('txtNoExt').setValue(oDatosContacto.noExt);
            gEx('txtNoInt').setValue(oDatosContacto.noInt);
            gEx('txtColonia').setValue(oDatosContacto.colonia);
            gEx('txtCP').setValue(oDatosContacto.cp);
			gEx('cmbEstado').setValue(oDatosContacto.estado);
            var pos=obtenerPosFila(gEx('cmbEstado').getStore(),'id',oDatosContacto.estado);
            if(pos>-1)
            {
                var registro=gEx('cmbEstado').getStore().getAt(pos);
                obtenerMunicipios(gEx('cmbEstado'),registro,function()
                                                {
                                                    gEx('cmbMunicipio').setValue(oDatosContacto.municipio);
                                                }
                                    )
                
			}            
            gEx('txtLocalidad').setValue(oDatosContacto.localidad);
            gEx('txtEntreCalle').setValue(oDatosContacto.entreCalle);
            gEx('txtYCalle').setValue(oDatosContacto.yCalle);
            gEx('txtReferencias').setValue(escaparBR(oDatosContacto.referencias));
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=116&idParticipante='+idParticipanteContacto,true);


	
}

function limpiarDatosContacto()
{
	gEx('txtCalle').setValue('');
    gEx('txtNoExt').setValue('');
    gEx('txtNoInt').setValue('');
    gEx('txtColonia').setValue('');
    gEx('txtCP').setValue('');
    gEx('txtCalle').setValue('');
    
    gEx('cmbEstado').setValue('');
    gEx('cmbMunicipio').setValue('');
    gEx('txtLocalidad').setValue('');
    gEx('txtEntreCalle').setValue('');
    gEx('txtYCalle').setValue('');
    gEx('txtReferencias').setValue('');
    gEx('gTelefonos').getStore().removeAll();
    gEx('gMail').getStore().removeAll();
}

function guardarDatosContacto()
{
	var txtCalle=gEx('txtCalle');
    var txtNoExt=gEx('txtNoExt');
    var txtNoInt=gEx('txtNoInt');
    var txtColonia=gEx('txtColonia');
    var txtCP=gEx('txtCP');
    var txtLocalidad=gEx('txtLocalidad');
    var txtEntreCalle=gEx('txtEntreCalle');
    var txtYCalle=gEx('txtYCalle');
    var txtReferencias=gEx('txtReferencias');
    var cmbEstado=gEx('cmbEstado');
    var cmbMunicipio=gEx('cmbMunicipio');
    
    var arrTelefonos='';
    
    var x;
    var fila;
    var o;
    for(x=0;x<gEx('gTelefonos').getStore().getCount();x++)
    {
        fila=gEx('gTelefonos').getStore().getAt(x);
        
        if(fila.data.numero=='')
        {
            function respTel()
            {
                gEx('gTelefonos').startEditing(x,3);
            }
            msgBox('Debe ingresar el n&uacute;mero telef&oacute;nico a agregar',respTel);
            return;
        }
        
        o='{"tipoTelefono":"'+fila.data.tipoTelefono+'","lada":"'+fila.data.lada+
            '","numero":"'+fila.data.numero+'","extension":"'+fila.data.extension+'"}';
        if(arrTelefonos=='')
            arrTelefonos=o;
        else
            arrTelefonos+=','+o;
    }
    
    var arrMail='';
    
    for(x=0;x<gEx('gMail').getStore().getCount();x++)
    {
        fila=gEx('gMail').getStore().getAt(x);
        if(!validarCorreo(fila.data.mail))
        {
            function respMail()
            {
                gEx('gMail').startEditing(x,1);
            }
            msgBox('El e-mail ingresado no es v&aacute;lido',respMail);
            return;
        }
        o='{"mail":"'+fila.data.mail+'"}';
        if(arrMail=='')
            arrMail=o;
        else
            arrMail+=','+o;
    }
    
    
    var cadObj='{"calle":"'+cv(txtCalle.getValue())+'","noExt":"'+cv(txtNoExt.getValue())+
                '","noInt":"'+cv(txtNoInt.getValue())+'","colonia":"'+cv(txtColonia.getValue())+
                '","cp":"'+cv(txtCP.getValue())+'","estado":"'+cmbEstado.getValue()+
                '","municipio":"'+cmbMunicipio.getValue()+'","localidad":"'+cv(txtLocalidad.getValue())+
                '","entreCalle":"'+cv(txtEntreCalle.getValue())+'","yCalle":"'+cv(txtYCalle.getValue())+
                '","referencias":"'+cv(txtReferencias.getValue())+'","arrTelefonos":['+arrTelefonos+
                '],"mail":['+arrMail+'],"idFormulario":"-7042",'+
                '"idRegistro":"'+gE('idOrden').value+'","idParticipante":"'+idParticipanteSel+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            msgBox('La informaci&oacute;n ha sido almacenada correctamente');
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=117&cadObj='+cadObj,true);
    
}

function mostrarVentanaAgregarNotificacion(nodoSujetoSel,fila)
{
	
	generaExposicion=true;
    borrarDiligencia=false;
    reprocesarDiligencia=false;
    
	var mostrarInfoOficina=false;
	idDiligencia=-1;
	funcAfterLoadMedio=null;
	var arrOrden=[];
	var x;
    var max=0;
    var idActa=-1;
    if(fila)
    {
    	idActa=fila.data.idActa;
    	
    }
    else
    {
    	max++;
    	var filaD;
    	for(x=0;x<gEx('gDiligencias').getStore().getCount();x++)
        {
        	filaD=gEx('gDiligencias').getStore().getAt(x);
            if(parseInt(filaD.data.situacionActa)==1)
            {
            	idActa=filaD.data.idActa;
                break;
            }
            
            
        }
    }
    
    if(idActa!=-1)
    {
        for(x=0;x<gEx('gDiligencias').getStore().getCount();x++)
        {
            filaD=gEx('gDiligencias').getStore().getAt(x);
            if(filaD.data.idActa==idActa)
            {
                max++;
            }
        }
    }
    
    for(x=1;x<=max;x++)
    {
    	arrOrden.push([x,x]);
    }
	var cmbOrden=crearComboExt('cmbOrden',arrOrden,470,35,80);
    cmbOrden.setValue(arrOrden[arrOrden.length-1][0]);
	
    

    var cmbHora_7=crearComboExt('cmbHora_7',arrTiempo,150,35,115);
   	cmbHora_7.setValue('<?php echo date("H:i") ?>');
    
    var cmbHora_9=crearComboExt('cmbHora_9',arrTiempo,150,35,115);
   	cmbHora_9.setValue('<?php echo date("H:i") ?>');
    
    var cmbHora_6=crearComboExt('cmbHora_6',arrTiempo,150,35,115);
   	cmbHora_6.setValue('<?php echo date("H:i") ?>');
    
    var cmbHora_8=crearComboExt('cmbHora_8',arrTiempo,150,35,115);
   	cmbHora_8.setValue('<?php echo date("H:i") ?>');
    
    var cmbHora_12=crearComboExt('cmbHora_12',arrTiempo,150,35,115);
   	cmbHora_12.setValue('<?php echo date("H:i") ?>');
    var cmbCentroDetencion_12=crearComboExt('cmbCentroDetencion_12',arrCentrosDetencion,150,65,400);
    var cmbIdentificacion_12=crearComboExt('cmbIdentificacion_12',arrTipoIdentificacion,200,95,350);
    cmbIdentificacion_12.on('select',function(cmb,registro)					
    								{
                                    	if(registro.data.id=='99')
                                        {
                                        	gEx('txtEspecifique_12').show();
                                        	gEx('lblEspecifique').show();
                                            gEx('txtEspecifique_12').focus();
                                        }
                                        else
                                        {
                                        	gEx('txtEspecifique_12').setValue('');
                                        	gEx('txtEspecifique_12').hide();
                                        	gEx('lblEspecifique').hide();
                                        }
                                    }
    						)
    
    var cmbHora_3=crearComboExt('cmbHora_3',arrTiempo,150,35,115);
   	cmbHora_3.setValue('<?php echo date("H:i") ?>');
    
    var cmbHora_4=crearComboExt('cmbHora_4',arrTiempo,150,35,115);
   	cmbHora_4.setValue('<?php echo date("H:i") ?>');
    
    var cmbHora_5=crearComboExt('cmbHora_5',arrTiempo,150,35,115);
   	cmbHora_5.setValue('<?php echo date("H:i") ?>');    
    
    var cmbAudienciaNotifica_5=crearComboExt('cmbAudienciaNotifica_5',arrAudienciasNotifica,150,65,400);
    if(gE('idEventoDeriva').value!='-1')
	    cmbAudienciaNotifica_5.setValue(gE('idEventoDeriva').value);
    
    var cmbHora_11_9=crearComboExt('cmbHora_11_9',arrTiempo,150,35,115);
   	cmbHora_11_9.setValue('<?php echo date("H:i") ?>');
    
    var cmbHora_11_10=crearComboExt('cmbHora_11_10',arrTiempo,150,35,115);
   	cmbHora_11_10.setValue('<?php echo date("H:i") ?>');
    
    var cmbHora_10_5=crearComboExt('cmbHora_10_5',arrTiempo,150,35,115);
   	cmbHora_10_5.setValue('<?php echo date("H:i") ?>');
    cmbHora_10_5.hide();
    
    var cmbHora_10_7=crearComboExt('cmbHora_10_7',arrTiempo,150,35,115);
   	cmbHora_10_7.setValue('<?php echo date("H:i") ?>');    
    
    var cmbAudienciaNotifica_10_7=crearComboExt('cmbAudienciaNotifica_10_7',arrAudienciasNotifica,150,65,400);
    if(gE('idEventoDeriva').value!='-1')
	    cmbAudienciaNotifica_10_7.setValue(gE('idEventoDeriva').value);
    
    
    var cmbIdentificacion_10_7=crearComboExt('cmbIdentificacion_10_7',arrTipoIdentificacion,200,65,350);
    cmbIdentificacion_10_7.on('select',function(cmb,registro)					
    								{
                                    	if(registro.data.id=='99')
                                        {
                                        	gEx('txtEspecifique_10_7').show();
                                        	gEx('lblEspecifique').show();
                                            gEx('txtEspecifique_10_7').focus();
                                        }
                                        else
                                        {
                                        	gEx('txtEspecifique_10_7').setValue('');
                                        	gEx('txtEspecifique_10_7').hide();
                                        	gEx('lblEspecifique').hide();
                                        }
                                    }
    						)
    
    
    
    
    var cmbAudienciaNotifica_10_5=crearComboExt('cmbAudienciaNotifica_10_5',arrAudienciasNotifica,200,5,400);
    cmbAudienciaNotifica_10_5.on('select',function(cmb,registro)			
    										{
                                            	var pos=existeValorMatriz(arrAudienciasNotifica,registro.data.id);
                                                
                                                var hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                                var fecha=Date.parseDate(arrAudienciasNotifica[pos][2],'Y-m-d');
                                                cmbHora_10_5.setValue(hora.format('H:i'));
                                                gEx('fecha_10_5').setValue(fecha.format('Y-m-d'));
                                                
                                            }
    							)
	var cmbAudienciaNotifica_10_52  =crearComboExt('cmbAudienciaNotifica_10_52',arrAudienciasNotifica,200,35,400);
	cmbAudienciaNotifica_10_52.setValue(gE('idEventoDeriva').value);
    
    
    var cmbHora_2_2=crearComboExt('cmbHora_2_2',arrTiempo,150,35,115);
   	cmbHora_2_2.setValue('<?php echo date("H:i") ?>');    
    
    var cmbAudienciaNotifica_2_2=crearComboExt('cmbAudienciaNotifica_2_2',arrAudienciasNotifica,150,65,400);
    if(gE('idEventoDeriva').value!='-1')
	    cmbAudienciaNotifica_2_2.setValue(gE('idEventoDeriva').value);                                
    
    var cmbHoraRespuesta_2_2=crearComboExt('cmbHoraRespuesta_2_2',arrTiempo,280,95,115);
   	cmbHoraRespuesta_2_2.setValue('<?php echo date("H:i") ?>');
    
    var cmbHora_10_6_2=crearComboExt('cmbHora_10_6_2',arrTiempo,150,35,115);
   	cmbHora_10_6_2.setValue('<?php echo date("H:i") ?>');    
    
    var cmbAudienciaNotifica_10_6_2=crearComboExt('cmbAudienciaNotifica_10_6_2',arrAudienciasNotifica,150,65,400);
    if(gE('idEventoDeriva').value!='-1')
	    cmbAudienciaNotifica_10_6_2.setValue(gE('idEventoDeriva').value);                                
    
    var cmbHoraRespuesta_10_6_2=crearComboExt('cmbHoraRespuesta_10_6_2',arrTiempo,280,95,115);
   	cmbHoraRespuesta_10_6_2.setValue('<?php echo date("H:i") ?>');
    
    var cmbHora_2_0=crearComboExt('cmbHora_2_0',arrTiempo,150,35,115);
   	cmbHora_2_0.setValue('<?php echo date("H:i") ?>');    
    
    var cmbAudienciaNotifica_2_0=crearComboExt('cmbAudienciaNotifica_2_0',arrAudienciasNotifica,150,65,400);
    if(gE('idEventoDeriva').value!='-1')
	    cmbAudienciaNotifica_2_0.setValue(gE('idEventoDeriva').value);                                
    
    var cmbHoraRespuesta_2_0=crearComboExt('cmbHoraRespuesta_2_0',arrTiempo,280,125,115);
   	cmbHoraRespuesta_2_0.setValue('<?php echo date("H:i") ?>');
    
    var cmbHora_10_6_0=crearComboExt('cmbHora_10_6_0',arrTiempo,150,35,115);
   	cmbHora_10_6_0.setValue('<?php echo date("H:i") ?>');    
    
    var cmbAudienciaNotifica_10_6_0=crearComboExt('cmbAudienciaNotifica_10_6_0',arrAudienciasNotifica,150,65,400);
    if(gE('idEventoDeriva').value!='-1')
	    cmbAudienciaNotifica_10_6_0.setValue(gE('idEventoDeriva').value);                                
    
    var cmbHoraRespuesta_10_6_0=crearComboExt('cmbHoraRespuesta_10_6_0',arrTiempo,280,125,115);
   	cmbHoraRespuesta_10_6_0.setValue('<?php echo date("H:i") ?>');
    
    
    
    var cmbHora_10_6_1=crearComboExt('cmbHora_10_6_1',arrTiempo,175,35,115);
   	cmbHora_10_6_1.setValue('<?php echo date("H:i") ?>');    
    
    var cmbAudienciaNotifica_10_6_1=crearComboExt('cmbAudienciaNotifica_10_6_1',arrAudienciasNotifica,175,65,400);
    if(gE('idEventoDeriva').value!='-1')
	    cmbAudienciaNotifica_10_6_1.setValue(gE('idEventoDeriva').value);                                
    
    
    
    
    var cmbHoraRespuesta_10_6_1=crearComboExt('cmbHoraRespuesta_10_6_1',arrTiempo,305,185,115);
   	cmbHoraRespuesta_10_6_1.setValue('<?php echo date("H:i") ?>');
    
    var cmbResultadoNotificacion_10_6_1=crearComboExt('cmbResultadoNotificacion_10_6_1',arrResultadoMail,175,155,300);
    cmbResultadoNotificacion_10_6_1.on('select',function(cmb,registro)
    											{
                                                	if(registro.data.id=='1')
                                                    {
                                                    	gEx('fechaRespuesta_10_6_1').show();
                                                        gEx('cmbHoraRespuesta_10_6_1').show();
                                                        gEx('lblFechaHoraRespuesta_10_6_1').show();
                                                    }
                                                    else
                                                    {
                                                    	gEx('fechaRespuesta_10_6_1').hide();
                                                        gEx('cmbHoraRespuesta_10_6_1').hide();
                                                        gEx('fechaRespuesta_10_6_1').setValue('');
                                                        gEx('cmbHoraRespuesta_10_6_1').setValue('');
                                                        gEx('lblFechaHoraRespuesta_10_6_1').hide();
                                                    }
                                                }
    								)
    
    
    cmbResultadoNotificacion_10_6_1.on('change',function(cmb,newValue)
    											{
                                                	switch(newValue)
                                                    {
                                                    	case '1':
                                                        case '0':
                                                        	generaExposicion=true;
                                                            reprocesarDiligencia=true;
                                                        break
                                                        case '2':
                                                        	generaExposicion=false;
															borrarDiligencia=true;	
                                                        break;
                                                    }
                                                }
    								)                                    
                                    
    //--2_1
    
    var cmbHora_2_1=crearComboExt('cmbHora_2_1',arrTiempo,175,35,115);
   	cmbHora_2_1.setValue('<?php echo date("H:i") ?>');    
    
    var cmbAudienciaNotifica_2_1=crearComboExt('cmbAudienciaNotifica_2_1',arrAudienciasNotifica,175,65,400);
    if(gE('idEventoDeriva').value!='-1')
	    cmbAudienciaNotifica_2_1.setValue(gE('idEventoDeriva').value);                                
    
    
    
    
    var cmbHoraRespuesta_2_1=crearComboExt('cmbHoraRespuesta_2_1',arrTiempo,305,185,115);
   	cmbHoraRespuesta_2_1.setValue('<?php echo date("H:i") ?>');
    
    var cmbResultadoNotificacion_2_1=crearComboExt('cmbResultadoNotificacion_2_1',arrResultadoMail,175,155,300);
    cmbResultadoNotificacion_2_1.on('select',function(cmb,registro)
    											{
                                                	if(registro.data.id=='1')
                                                    {
                                                    	gEx('fechaRespuesta_2_1').show();
                                                        gEx('cmbHoraRespuesta_2_1').show();
                                                        gEx('lblFechaHoraRespuesta_2_1').show();
                                                    }
                                                    else
                                                    {
                                                    	gEx('fechaRespuesta_2_1').hide();
                                                        gEx('cmbHoraRespuesta_2_1').hide();
                                                        gEx('fechaRespuesta_2_1').setValue('');
                                                        gEx('cmbHoraRespuesta_2_1').setValue('');
                                                        gEx('lblFechaHoraRespuesta_2_1').hide();
                                                    }
                                                }
    								)
                                    
	cmbResultadoNotificacion_2_1.on('change',function(cmb,newValue)
    											{
                                                	switch(newValue)
                                                    {
                                                    	case '1':
                                                        case '0':
                                                        	generaExposicion=true;
                                                            reprocesarDiligencia=true;
                                                        break
                                                        case '2':
                                                        	generaExposicion=false;
															borrarDiligencia=true;	
                                                        break;
                                                    }
                                                }
    								)                                    
                                    
    
    //
    
    
    var cmbHora_10_8=crearComboExt('cmbHora_10_8',arrTiempo,150,35,115);
   	cmbHora_10_8.setValue('<?php echo date("H:i") ?>'); 
    
    var cmbHora2daVisita_10_8=crearComboExt('cmbHora2daVisita_10_8',arrTiempo,320,155,115);
   	cmbHora2daVisita_10_8.setValue(''); 
    cmbHora2daVisita_10_8.hide();
    var cmbIdentificacion_10_8=crearComboExt('cmbIdentificacion_10_8',arrTipoIdentificacion,200,95,350);
    cmbIdentificacion_10_8.on('select',function(cmb,registro)					
    								{
                                    	if(registro.data.id=='99')
                                        {
                                        	gEx('txtEspecifique_10_8').show();
                                        	gEx('lblEspecifique').show();
                                            gEx('txtEspecifique_10_8').focus();
                                        }
                                        else
                                        {
                                        	gEx('txtEspecifique_10_8').setValue('');
                                        	gEx('txtEspecifique_10_8').hide();
                                        	gEx('lblEspecifique').hide();
                                        }
                                    }
    						)
    
    cmbIdentificacion_10_8.hide();
    
    var cmbIdentificacion2daVisita_10_8=crearComboExt('cmbIdentificacion2daVisita_10_8',arrTipoIdentificacion,200,35,350);
    cmbIdentificacion2daVisita_10_8.on('select',function(cmb,registro)					
    								{
                                    	if(registro.data.id=='99')
                                        {
                                        	gEx('txtEspecifique2daVisita_10_8').show();
                                        	gEx('lblEspecifique2daVisita_10_8').show();
                                            gEx('txtEspecifique2daVisita_10_8').focus();
                                        }
                                        else
                                        {
                                        	gEx('txtEspecifique2daVisita_10_8').setValue('');
                                        	gEx('txtEspecifique2daVisita_10_8').hide();
                                        	gEx('lblEspecifique2daVisita_10_8').hide();
                                        }
                                    }
    						)
    
    cmbIdentificacion2daVisita_10_8.hide();
    
    
    
    var cmbResultadoDiligencia_10_8=crearComboExt('cmbResultadoDiligencia_10_8',arrResultadoDiligencia,200,65,320);
    cmbResultadoDiligencia_10_8.on('change',function(cmb,newValue)
    										{
                                            	if(newValue!='3')
	                                            	reprocesarDiligencia=true;
                                            	
                                            }
    							)
    cmbResultadoDiligencia_10_8.on('select',function(cmb,registro)
    												{
                                                    	gEx('p2daVisita').disable();
                                                        borrarDiligencia=false;
                                                    	switch(registro.data.id)
                                                        {
                                                        	case '1':
                                                            	
                                                                gEx('lblLugarCitatorio_10_8').hide();
                                                                gEx('txtLugarFijoCitatorio_10_8').hide();
                                                                gEx('txtLugarFijoCitatorio_10_8').setValue('');
                                                                
                                                                gEx('lblPersona2daVisita_10_8').hide();
                                                                gEx('txtPersona_10_8').hide();
                                                                gEx('txtPersona_10_8').setValue('');
                                                                gEx('lblRelacion_10_8').hide();
                                                                gEx('txtRelacion_10_8').hide();
                                                                gEx('txtRelacion_10_8').setValue('');
                                                                
                                                            	gEx('lblFecha2daVisita_10_8').hide();
                                                            	gEx('cmbHora2daVisita_10_8').hide();
                                                                gEx('cmbHora2daVisita_10_8').setValue('');
                                                                gEx('txtFechadaVisita_10_8').hide();
                                                                gEx('txtFechadaVisita_10_8').setValue('');
                                                            	gEx('lblTipoIdentificacion_10_8').show();
                                                                gEx('cmbIdentificacion_10_8').show();
                                                                if(mostrarInfoOficina)
                                                                {
                                                                    gEx('lblDomicioOficina_10_8').show();
                                                                    gEx('txtDomicilio_10_8').show();
                                                                    gEx('txtDomicilio_10_8').focus();
                                                                    gEx('lblTipoOficina_10_8').show();
                                                                }
                                                                gEx('cmbResultado2daDiligencia_10_8').setValue('');
                                                            break;
                                                            case '2':
                                                            	gEx('p2daVisita').enable();
                                                            	gEx('lblFecha2daVisita_10_8').show();
                                                            	gEx('cmbHora2daVisita_10_8').show();
                                                                gEx('txtFechadaVisita_10_8').show();
                                                                gEx('lblPersona2daVisita_10_8').show();
                                                                gEx('txtPersona_10_8').show();
                                                                gEx('txtRelacion_10_8').show();
                                                                gEx('lblRelacion_10_8').show();
                                                                gEx('lblLugarCitatorio_10_8').show();
                                                                gEx('txtLugarFijoCitatorio_10_8').show();
                                                                gEx('cmbResultado2daDiligencia_10_8').setValue('');

                                                                if(mostrarInfoOficina)
                                                                {
                                                                    gEx('lblDomicioOficina_10_8').show();
                                                                    gEx('txtDomicilio_10_8').show();
                                                                    gEx('lblTipoOficina_10_8').show();
                                                                    gEx('txtDomicilio_10_8').focus();
                                                                }
                                                            case '3':
                                                            
                                                            	
                                                                
                                                            	gEx('lblTipoIdentificacion_10_8').hide();
                                                                gEx('cmbIdentificacion_10_8').hide();
                                                                gEx('cmbIdentificacion_10_8').setValue('');
                                                                if(registro.data.id=='3')
                                                                {
                                                                	borrarDiligencia=true;
	                                                                gEx('p2daVisita').disable();
                                                                    gEx('lblDomicioOficina_10_8').hide();
                                                                    gEx('txtDomicilio_10_8').hide();
                                                                    gEx('lblTipoOficina_10_8').hide();
                                                                    gEx('txtDomicilio_10_8').setValue('');
                                                                    gEx('lblFecha2daVisita_10_8').hide();
                                                                    gEx('cmbHora2daVisita_10_8').hide();
                                                                    gEx('cmbHora2daVisita_10_8').setValue('');
                                                                    gEx('txtFechadaVisita_10_8').hide();
                                                                    gEx('txtFechadaVisita_10_8').setValue('');
                                                                    
                                                                    gEx('lblPersona2daVisita_10_8').hide();
                                                                    gEx('txtPersona_10_8').hide();
                                                                    gEx('txtPersona_10_8').setValue('');
                                                                    gEx('lblRelacion_10_8').hide();
                                                                    gEx('txtRelacion_10_8').hide('');
                                                                    gEx('txtRelacion_10_8').setValue('');
                                                                    
                                                                    gEx('lblLugarCitatorio_10_8').hide();
                                                                    gEx('txtLugarFijoCitatorio_10_8').hide();
                                                                    gEx('txtLugarFijoCitatorio_10_8').setValue('');
                                                                    
                                                                }
                                                            break;
                                                        }
                                                    }
    							)
    
    var cmbResultado2daDiligencia_10_8=crearComboExt('cmbResultado2daDiligencia_10_8',arrResultadoDiligencia2daVisita,200,5,350);
    cmbResultado2daDiligencia_10_8.on('change',function()
    											{
                                                	reprocesarDiligencia=true;
                                                }
    								)
    cmbResultado2daDiligencia_10_8.on('select',function(cmb,registro)			
    											{	
                                                	gEx('lblPersona2daVisitaNotificacion_10_8').hide();
                                                    gEx('txtPersona2daVisitaNotificacion_10_8').hide();
                                                    gEx('txtPersona2daVisitaNotificacion_10_8').setValue('');
                                                    gEx('lblRelacion2daVisitaNotificacion_10_8').hide();
                                                    gEx('txtRelacion2daVisitaNotificacion_10_8').hide();
                                                    gEx('txtRelacion2daVisitaNotificacion_10_8').setValue('');
                                                    
                                                    
                                                    gEx('lblTipoIdentificacion2daVisita_10_8').hide();
                                                    gEx('cmbIdentificacion2daVisita_10_8').hide();
                                                    gEx('cmbIdentificacion2daVisita_10_8').setValue('');
                                                    gEx('lblEspecifique2daVisita_10_8').hide();
                                                    gEx('txtEspecifique2daVisita_10_8').hide();
                                                    gEx('txtEspecifique2daVisita_10_8').setValue('');
                                                    
                                                    gEx('lblLugarFijo2daVisita_10_8').hide();
                                                    gEx('txtLugarFijaCitatorio_10_8').hide();
                                                    gEx('txtLugarFijaCitatorio_10_8').setValue('');                                                    
                                                    
                                                    
                                                	switch(registro.data.id)
                                                    {
                                                    	case '1':
                                                        	gEx('lblTipoIdentificacion2daVisita_10_8').show();
                                                    		gEx('cmbIdentificacion2daVisita_10_8').show();
                                                        break;
                                                        case '2':
                                                        	gEx('lblPersona2daVisitaNotificacion_10_8').show();
                                                            gEx('txtPersona2daVisitaNotificacion_10_8').show();
                                                            gEx('lblRelacion2daVisitaNotificacion_10_8').show();
                                                            gEx('txtRelacion2daVisitaNotificacion_10_8').show();
                                                            
                                                        break;
                                                        case '3':
                                                        	gEx('lblLugarFijo2daVisita_10_8').show();
                                                    		gEx('txtLugarFijaCitatorio_10_8').show();
                                                        break;
                                                    }
                                                }
    								)
    
    
    //---/
    var cmbHora_1=crearComboExt('cmbHora_1',arrTiempo,150,35,115);
   	cmbHora_1.setValue('<?php echo date("H:i") ?>'); 
    
    var cmbHora2daVisita_1=crearComboExt('cmbHora2daVisita_1',arrTiempo,320,155,115);
   	cmbHora2daVisita_1.setValue(''); 
    cmbHora2daVisita_1.hide();
    var cmbIdentificacion_1=crearComboExt('cmbIdentificacion_1',arrTipoIdentificacion,200,95,350);
    cmbIdentificacion_1.on('select',function(cmb,registro)					
    								{
                                    	if(registro.data.id=='99')
                                        {
                                        	gEx('txtEspecifique_1').show();
                                        	gEx('lblEspecifique_1').show();
                                            gEx('txtEspecifique_1').focus();
                                        }
                                        else
                                        {
                                        	gEx('txtEspecifique_1').setValue('');
                                        	gEx('txtEspecifique_1').hide();
                                        	gEx('lblEspecifique_1').hide();
                                        }
                                    }
    						)
    
    cmbIdentificacion_1.hide();
    
    var cmbIdentificacion2daVisita_1=crearComboExt('cmbIdentificacion2daVisita_1',arrTipoIdentificacion,200,35,350);
    cmbIdentificacion2daVisita_1.on('select',function(cmb,registro)					
    								{
                                    	if(registro.data.id=='99')
                                        {
                                        	gEx('txtEspecifique2daVisita_1').show();
                                        	gEx('lblEspecifique2daVisita_1').show();
                                            gEx('txtEspecifique2daVisita_1').focus();
                                        }
                                        else
                                        {
                                        	gEx('txtEspecifique2daVisita_1').setValue('');
                                        	gEx('txtEspecifique2daVisita_1').hide();
                                        	gEx('lblEspecifique2daVisita_1').hide();
                                        }
                                    }
    						)
    
    cmbIdentificacion2daVisita_1.hide();
    
    
    
    var cmbResultadoDiligencia_1=crearComboExt('cmbResultadoDiligencia_1',arrResultadoDiligencia,200,65,320);
    cmbResultadoDiligencia_1.on('change',function(cmb,newValue)
    										{
                                            	if(newValue!='3')
	                                            	reprocesarDiligencia=true;
                                            	
                                            }
    							)
    cmbResultadoDiligencia_1.on('select',function(cmb,registro)
    												{
                                                    	gEx('p2daVisita_1').disable();
                                                        borrarDiligencia=false;
                                                    	switch(registro.data.id)
                                                        {
                                                        	case '1':
                                                            	
                                                                gEx('lblLugarCitatorio_1').hide();
                                                                gEx('txtLugarFijoCitatorio_1').hide();
                                                                gEx('txtLugarFijoCitatorio_1').setValue('');
                                                                
                                                                gEx('lblPersona2daVisita_1').hide();
                                                                gEx('txtPersona_1').hide();
                                                                gEx('txtPersona_1').setValue('');
                                                                gEx('lblRelacion_1').hide();
                                                                gEx('txtRelacion_1').hide();
                                                                gEx('txtRelacion_1').setValue('');
                                                                
                                                            	gEx('lblFecha2daVisita_1').hide();
                                                            	gEx('cmbHora2daVisita_1').hide();
                                                                gEx('cmbHora2daVisita_1').setValue('');
                                                                gEx('txtFechadaVisita_1').hide();
                                                                gEx('txtFechadaVisita_1').setValue('');
                                                            	gEx('lblTipoIdentificacion_1').show();
                                                                gEx('cmbIdentificacion_1').show();
                                                                if(mostrarInfoOficina)
                                                                {
                                                                    gEx('lblDomicioOficina_1').show();
                                                                    gEx('txtDomicilio_1').show();
                                                                    gEx('txtDomicilio_1').focus();
                                                                    gEx('lblTipoOficina_1').show();
                                                                }
                                                                gEx('cmbResultado2daDiligencia_1').setValue('');
                                                            break;
                                                            case '2':
                                                            	gEx('p2daVisita_1').enable();
                                                            	gEx('lblFecha2daVisita_1').show();
                                                            	gEx('cmbHora2daVisita_1').show();
                                                                gEx('txtFechadaVisita_1').show();
                                                                gEx('lblPersona2daVisita_1').show();
                                                                gEx('txtPersona_1').show();
                                                                gEx('txtRelacion_1').show();
                                                                gEx('lblRelacion_1').show();
                                                                gEx('lblLugarCitatorio_1').show();
                                                                gEx('txtLugarFijoCitatorio_1').show();
                                                                gEx('cmbResultado2daDiligencia_1').setValue('');

                                                                if(mostrarInfoOficina)
                                                                {
                                                                    gEx('lblDomicioOficina_1').show();
                                                                    gEx('txtDomicilio_1').show();
                                                                    gEx('lblTipoOficina_1').show();
                                                                    gEx('txtDomicilio_1').focus();
                                                                }
                                                            case '3':
                                                            
                                                            	
                                                                
                                                            	gEx('lblTipoIdentificacion_1').hide();
                                                                gEx('cmbIdentificacion_1').hide();
                                                                gEx('cmbIdentificacion_1').setValue('');
                                                                if(registro.data.id=='3')
                                                                {
                                                                	borrarDiligencia=true;
	                                                                gEx('p2daVisita_1').disable();
                                                                    gEx('lblDomicioOficina_1').hide();
                                                                    gEx('txtDomicilio_1').hide();
                                                                    gEx('lblTipoOficina_1').hide();
                                                                    gEx('txtDomicilio_1').setValue('');
                                                                    gEx('lblFecha2daVisita_1').hide();
                                                                    gEx('cmbHora2daVisita_1').hide();
                                                                    gEx('cmbHora2daVisita_1').setValue('');
                                                                    gEx('txtFechadaVisita_1').hide();
                                                                    gEx('txtFechadaVisita_1').setValue('');
                                                                    
                                                                    gEx('lblPersona2daVisita_1').hide();
                                                                    gEx('txtPersona_1').hide();
                                                                    gEx('txtPersona_1').setValue('');
                                                                    gEx('lblRelacion_1').hide();
                                                                    gEx('txtRelacion_1').hide('');
                                                                    gEx('txtRelacion_1').setValue('');
                                                                    
                                                                    gEx('lblLugarCitatorio_1').hide();
                                                                    gEx('txtLugarFijoCitatorio_1').hide();
                                                                    gEx('txtLugarFijoCitatorio_1').setValue('');
                                                                    
                                                                }
                                                            break;
                                                        }
                                                    }
    							)
    
    var cmbResultado2daDiligencia_1=crearComboExt('cmbResultado2daDiligencia_1',arrResultadoDiligencia2daVisita,200,5,350);
    cmbResultado2daDiligencia_1.on('change',function()
    											{
                                                	reprocesarDiligencia=true;
                                                }
    								)
    cmbResultado2daDiligencia_1.on('select',function(cmb,registro)			
    											{	
                                                	gEx('lblPersona2daVisitaNotificacion_1').hide();
                                                    gEx('txtPersona2daVisitaNotificacion_1').hide();
                                                    gEx('txtPersona2daVisitaNotificacion_1').setValue('');
                                                    gEx('lblRelacion2daVisitaNotificacion_1').hide();
                                                    gEx('txtRelacion2daVisitaNotificacion_1').hide();
                                                    gEx('txtRelacion2daVisitaNotificacion_1').setValue('');
                                                    
                                                    
                                                    gEx('lblTipoIdentificacion2daVisita_1').hide();
                                                    gEx('cmbIdentificacion2daVisita_1').hide();
                                                    gEx('cmbIdentificacion2daVisita_1').setValue('');
                                                    gEx('lblEspecifique2daVisita_1').hide();
                                                    gEx('txtEspecifique2daVisita_1').hide();
                                                    gEx('txtEspecifique2daVisita_1').setValue('');
                                                    
                                                    gEx('lblLugarFijo2daVisita_1').hide();
                                                    gEx('txtLugarFijaCitatorio_1').hide();
                                                    gEx('txtLugarFijaCitatorio_1').setValue('');                                                    
                                                    
                                                    
                                                	switch(registro.data.id)
                                                    {
                                                    	case '1':
                                                        	gEx('lblTipoIdentificacion2daVisita_1').show();
                                                    		gEx('cmbIdentificacion2daVisita_1').show();
                                                        break;
                                                        case '2':
                                                        	gEx('lblPersona2daVisitaNotificacion_1').show();
                                                            gEx('txtPersona2daVisitaNotificacion_1').show();
                                                            gEx('lblRelacion2daVisitaNotificacion_1').show();
                                                            gEx('txtRelacion2daVisitaNotificacion_1').show();
                                                            
                                                        break;
                                                        case '3':
                                                        	gEx('lblLugarFijo2daVisita_1').show();
                                                    		gEx('txtLugarFijaCitatorio_1').show();
                                                        break;
                                                    }
                                                }
    								)
    
   
	var paso=1;
	nodoMedioSel=null;
	var tFigura;
    var arrDetalles;
	pos=existeValorMatriz(arrParteProcesal,nodoSujetoSel.attributes.personaJuridica);
    tFigura=arrParteProcesal[pos][1];
    arrDetalles=arrParteProcesal[pos][2];
    var tPersonaJuridica=nodoSujetoSel.parentNode.attributes.tipoFigura;

	var lblFigura=tFigura;
    if(nodoSujetoSel.attributes.detalleFigura!='')
    {
    	pos=existeValorMatriz(arrParteProcesal[pos][2],nodoSujetoSel.attributes.detalleFigura,0,true);	
       	if(pos!=-1)
        {

        	lblFigura+=' '+arrParteProcesal[pos][2][pos][1];
        }
        
    }
    
    var cmbTipoDiligencia=crearComboExt('cmbTipoDiligencia',arrTipoDiligencias,140,35,220);
    
    cmbTipoDiligencia.on('select',function(cmb,registro)
    							{
                                	
                                	gEx('arbolMedio').getRootNode().reload();
                                }
    					)

    var cmbDetalleFigura=crearComboExt('cmbDetalleFigura',arrDetalles,760,35,180);    
    
    cmbDetalleFigura.on('select',function(cmb,registro)
    							{
                                	gEx('arbolMedio').getRootNode().reload();
                                }
    					)
    
    if(cmbDetalleFigura.getStore().getCount()==0)
    {
    	cmbDetalleFigura.hide();
    }
    else
    {

    	var posFila=obtenerPosFila(cmbDetalleFigura.getStore(),'id',nodoSujetoSel.attributes.detalleFigura);
        if(posFila==-1)
        {

        	cmbDetalleFigura.deshabilitado=false;
        }
        else
        {

        	cmbDetalleFigura.setValue(nodoSujetoSel.attributes.detalleFigura);
        	cmbDetalleFigura.disable();
            cmbDetalleFigura.deshabilitado=true;
        }
        	
    }
    
    
    var cmbAudienciaNotifica_2_3=crearComboExt('cmbAudienciaNotifica_2_3',arrAudienciasNotifica,150,5,400);
    if(gE('idEventoDeriva').value!='-1')
	    cmbAudienciaNotifica_2_3.setValue(gE('idEventoDeriva').value);  
    
    
    var cmbAudienciaNotifica_10_6_3=crearComboExt('cmbAudienciaNotifica_10_6_3',arrAudienciasNotifica,150,5,400);
    if(gE('idEventoDeriva').value!='-1')
	    cmbAudienciaNotifica_10_6_3.setValue(gE('idEventoDeriva').value);  
    
    
    var arrPaneles=[];
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_7',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_7',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_7
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_7').getValue()=='')
                                        {
                                        	function resp()
                                            {
                                            	gEx('fecha_7').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_7').getValue()=='')
                                        {
                                        	function resp2()
                                            {
                                            	gEx('cmbHora_7').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{

                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_7').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_7').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_7').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_7').getValue()+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_7').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_7').getValue()+
                                                    '","resultado":"1","citatorio":"0"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_7').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_7').setValue(oEdicion.horaDiligencia);

                                                        }                                     


	arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_9',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_9',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_9
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_9').getValue()=='')
                                        {
                                        	function resp_9()
                                            {
                                            	gEx('fecha_9').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_9);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_9').getValue()=='')
                                        {
                                        	function resp2_9()

                                            {
                                            	gEx('cmbHora_9').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_9);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{

                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_9').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_9').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_9').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_9').getValue()+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_9').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_9').getValue()+
                                                    '","resultado":"1","citatorio":"0"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_9').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_9').setValue(oEdicion.horaDiligencia);

                                                        } 
                                           
	arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_6',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_6',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_6
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_6').getValue()=='')
                                        {
                                        	function resp_6()
                                            {
                                            	gEx('fecha_6').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_6);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_6').getValue()=='')
                                        {
                                        	function resp2_6()

                                            {
                                            	gEx('cmbHora_6').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_6);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{

                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_6').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_6').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_6').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_6').getValue()+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_6').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_6').getValue()+
                                                    '","resultado":"1","citatorio":"0"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_6').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_6').setValue(oEdicion.horaDiligencia);

                                                        }                                                            
                                                        
	arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_8',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_8',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_8
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_8').getValue()=='')
                                        {
                                        	function resp_8()
                                            {
                                            	gEx('fecha_8').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_8);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_8').getValue()=='')
                                        {
                                        	function resp2_8()

                                            {
                                            	gEx('cmbHora_8').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_8);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{

                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_8').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_8').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_8').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_8').getValue()+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_8').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_8').getValue()+
                                                    '","resultado":"1","citatorio":"0"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_8').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_8').setValue(oEdicion.horaDiligencia);

                                                        }                                                        
                                         
                                         
	arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_12',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_12',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_12,
                                                            {
                                                            	x:10,
                                                                y:70,
                                                                xtype:'label',
                                                                html:'Centro de detenci&oacute;n:'

                                                                
                                                            },
                                                            cmbCentroDetencion_12,
                                                            {
                                                            	x:10,
                                                                y:100,
                                                                xtype:'label',
                                                                html:'Tipo de identificaci&oacute;n presentada:'

                                                                
                                                            },
                                                            cmbIdentificacion_12,
                                                            {
                                                            	x:10,
                                                                y:130,
                                                                id:'lblEspecifique',
                                                                hidden:true,
                                                                xtype:'label',
                                                                html:'Especifique:'

                                                                
                                                            },
                                                            {
                                                            	xtype:'textfield',
                                                            	x:150,
                                                                y:125,
                                                                hidden:true,
                                                                id:'txtEspecifique_12',
                                                                widht:300
                                                            }
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_12').getValue()=='')
                                        {
                                        	function resp_12()
                                            {
                                            	gEx('fecha_12').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_12);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_12').getValue()=='')
                                        {
                                        	function resp2_12()

                                            {
                                            	gEx('cmbHora_12').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_12);
                                        	return false;
                                        }
                                        
                                        
                                        if(gEx('cmbCentroDetencion_12').getValue()=='')
                                        {
                                        	function respCentro_12()
                                            {
                                            	gEx('cmbCentroDetencion_12').focus();
                                            }
                                            msgBox('Debe indicar el lugar de detenci&oacute;n en donde llev&oacute; a cabo la diligencia',respCentro_12);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbIdentificacion_12').getValue()=='')
                                        {
                                        	function respIdentificacion_12()
                                            {
                                            	gEx('cmbIdentificacion_12').focus();
                                            }
                                            msgBox('Debe indicar la identificaci&oacute;n presentada durante la diligencia',respIdentificacion_12);
                                        	return false;
                                        }
                                        
                                        if((gEx('cmbIdentificacion_12').getValue()=='99')&&(gEx('txtEspecifique_12').getValue()==''))
                                        {
                                        	function respEspIdentificacion_12()
                                            {
                                            	gEx('txtEspecifique_12').focus();
                                            }
                                            msgBox('Debe indicar la identificaci&oacute;n presentada durante la diligencia',respEspIdentificacion_12);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
										var domicilioCentro='';
                                        var pos=existeValorMatriz(arrCentrosDetencion,gEx('cmbCentroDetencion_12').getValue());
                                        domicilioCentro=arrCentrosDetencion[pos][2];
                                        
                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_12').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_12').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_12').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_12').getValue()+'","centroDetencion":"'+gEx('cmbCentroDetencion_12').getValue()+
                                                    '","lugarDetencion":"'+(arrCentrosDetencion[pos][3]+' '+gEx('cmbCentroDetencion_12').getRawValue())+
                                                    '","tipoIdentificacion":"'+gEx('cmbIdentificacion_12').getValue()+'","lblTipoIdentificacion":"'+
                                                    cv(gEx('cmbIdentificacion_12').getValue()==99?gEx('txtEspecifique_12').getValue():
                                                    gEx('cmbIdentificacion_12').getRawValue())+'","domicilioCentro":"'+domicilioCentro+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_12').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_12').getValue()+
                                                    '","resultado":"1","citatorio":"0","lugarDetencion":"'+gEx('cmbCentroDetencion_12').getValue()+
                                                    '","tipoIdentificacion":"'+gEx('cmbIdentificacion_12').getValue()+
                                                    '","especifiqueTipoIdentificacion":"'+cv(gEx('txtEspecifique_12').getValue())+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_12').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_12').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbCentroDetencion_12').setValue(oEdicion.lugarDetencion);
                                                            gEx('cmbIdentificacion_12').setValue(oEdicion.tipoIdentificacion);
                                                            gEx('txtEspecifique_12').setValue(oEdicion.especifiqueTipoIdentificacion);
                                                            dispararEventoSelectCombo('cmbIdentificacion_12');

                                                        }                                             


	arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_3',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_3',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_3
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_3').getValue()=='')
                                        {
                                        	function resp()
                                            {
                                            	gEx('fecha_3').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_3').getValue()=='')
                                        {
                                        	function resp2()

                                            {
                                            	gEx('cmbHora_3').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{

                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_3').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_3').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_3').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_3').getValue()+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_3').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_3').getValue()+
                                                    '","resultado":"1","citatorio":"0"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_3').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_3').setValue(oEdicion.horaDiligencia);

                                                        }       
                                                        
                                                        
	arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_4',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_4',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_4
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_4').getValue()=='')
                                        {
                                        	function resp()
                                            {
                                            	gEx('fecha_4').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_4').getValue()=='')
                                        {
                                        	function resp2()


                                            {
                                            	gEx('cmbHora_4').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{

                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_4').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_4').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_4').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_4').getValue()+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_4').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_4').getValue()+
                                                    '","resultado":"1","citatorio":"0"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_4').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_4').setValue(oEdicion.horaDiligencia);

                                                        }                                                         
    
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_5',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	gE('lblAdscripcion').innerHTML=tFigura.toLowerCase();
                                                                    
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_5',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_5,
                                                            {
                                                            	x:10,
                                                                y:70,
                                                                xtype:'label',
                                                                html:'Audiencia que se notifica:'
                                                            },
                                                            cmbAudienciaNotifica_5,
                                                            {
                                                            	x:10,
                                                                y:100,
                                                                hidden:!((gEx('cmbDetalleFigura').getValue()=='1')||(nodoSujetoSel.attributes.personaJuridica=='10')),
                                                                xtype:'label',
                                                                html:'Adscripci&oacute;n del <span id="lblAdscripcion">ministerio p&uacute;blico</span>:'
                                                            },
                                                            {
                                                            	x:200,
                                                                y:95,
                                                                hidden:!((gEx('cmbDetalleFigura').getValue()=='1')||(nodoSujetoSel.attributes.personaJuridica=='10')),
                                                                
                                                                xtype:'textfield',
                                                                width:350,
                                                                id:'txtAdscripcion_5',
                                                            }
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_5').getValue()=='')
                                        {
                                        	function resp_5()
                                            {
                                            	gEx('fecha_5').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_5);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_5').getValue()=='')
                                        {
                                        	function resp2_5()
                                            {
                                            	gEx('cmbHora_5').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_5);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbAudienciaNotifica_5').getValue()=='')
                                        {
                                        	function resp3_5()
                                            {
                                            	gEx('cmbAudienciaNotifica_5').focus();
                                            }
                                            msgBox('Debe indicar la audiencia que se notifica en la diligencia',resp3_5);
                                        	return false;
                                        }
                                        if((gEx('cmbDetalleFigura').getValue()=='1')||(nodoSujetoSel.attributes.personaJuridica=='10'))
                                        {
                                            if(gEx('txtAdscripcion_5').getValue()=='')
                                            {
                                                function resp4_5()
                                                {
                                                    gEx('txtAdscripcion_5').focus();
                                                }
                                                msgBox('Debe indicar la adscripci&oacute;n del '+tFigura.toLowerCase(),resp4_5);
                                                return false;
                                            }
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
										var pos=existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_5').getValue());
                                        
                                        var fecha=Date.parseDate(arrAudienciasNotifica[pos][2],'Y-m-d');
                                        var hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                        var lblAudiencia=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y')
                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_5').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_5').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_5').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_5').getValue()+'","horaAudiencia":"'+hora.format('H:i')+'","fechaAudiencia":"'+lblAudiencia+
                                                    '","adscripcionParticipante":"'+cv(gEx('txtAdscripcion_5').getValue())+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_5').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_5').getValue()+
                                                    '","resultado":"1","citatorio":"0","idAudienciaNotifica":"'+gEx('cmbAudienciaNotifica_5').getValue()+
                                                    '","adscripcionParticipante":"'+cv(gEx('txtAdscripcion_5').getValue())+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_5').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_5').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbAudienciaNotifica_5').setValue(oEdicion.idAudienciaNotifica);
                                                            gEx('txtAdscripcion_5').setValue(oEdicion.adscripcionParticipante);

                                                        } 
                                   
                                   
	arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_11_9',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_11_9',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_11_9
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_11_9').getValue()=='')
                                        {
                                        	function resp()
                                            {
                                            	gEx('fecha_11_9').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_11_9').getValue()=='')
                                        {
                                        	function resp2()


                                            {
                                            	gEx('cmbHora_11_9').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{

                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_11_9').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_11_9').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_11_9').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_11_9').getValue()+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_11_9').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_11_9').getValue()+
                                                    '","resultado":"1","citatorio":"0"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_11_9').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_11_9').setValue(oEdicion.horaDiligencia);

                                                        }                                       
      
    
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_11_9',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_11_9',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_11_9
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_11_9').getValue()=='')
                                        {
                                        	function resp()
                                            {
                                            	gEx('fecha_11_9').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_11_9').getValue()=='')
                                        {
                                        	function resp2()


                                            {
                                            	gEx('cmbHora_11_9').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{

                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_11_9').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_11_9').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_11_9').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_11_9').getValue()+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_11_9').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_11_9').getValue()+
                                                    '","resultado":"1","citatorio":"0"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_11_9').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_11_9').setValue(oEdicion.horaDiligencia);

                                                        } 
     
     
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_11_10',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_11_10',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_11_10
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_11_10').getValue()=='')
                                        {
                                        	function resp()
                                            {
                                            	gEx('fecha_11_10').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_11_10').getValue()=='')
                                        {
                                        	function resp2()


                                            {
                                            	gEx('cmbHora_11_10').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{

                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_11_10').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_11_10').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_11_10').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_11_10').getValue()+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_11_10').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_11_10').getValue()+
                                                    '","resultado":"1","citatorio":"0"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_11_10').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_11_10').setValue(oEdicion.horaDiligencia);

                                                        }  
                                                                                                                                            
    
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_10_5',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if(gE('idEventoUltimo').value!='-1')
                                                                        {
	                                                                    	gEx('cmbAudienciaNotifica_10_5').setValue(gE('idEventoUltimo').value);
                                                                            dispararEventoSelectCombo('cmbAudienciaNotifica_10_5');
                                                                        }
                                                                    	if((gEx('cmbTipoDiligencia').getValue()=='2')||(gEx('cmbTipoDiligencia').getValue()=='3'))
                                                                        {
                                                                        	gEx('lblAudienciaCita_10_5').show();
                                                                            gEx('cmbAudienciaNotifica_10_52').show();
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                        	gEx('lblAudienciaCita_10_5').hide();
                                                                            gEx('cmbAudienciaNotifica_10_52').hide();
                                                                        }
                                                                        
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Audiencia en la cual se notifica:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                hidden:true,
                                                                xtype:'datefield',
                                                                id:'fecha_10_5',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            cmbAudienciaNotifica_10_5,
                                                            {
                                                                x:10,
                                                                y:40,
                                                                hidden:true,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_10_5,
                                                            {
                                                                x:10,
                                                                y:40,
                                                                id:'lblAudienciaCita_10_5',
                                                                xtype:'label',
                                                                html:'Audiencia a la cual se cita:'
                                                            },
                                                            cmbAudienciaNotifica_10_52
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('cmbAudienciaNotifica_10_5').getValue()=='')
                                        {
                                        	function resp_10_5()
                                            {
                                            	gEx('cmbAudienciaNotifica_10_5').focus();
                                            }
                                            msgBox('Debe indicar la audiencia en la cual fu&eacute; realizada la notificaci&oacute;n',resp_10_5);
                                        	return false;
                                        }
                                        
                                        if((gEx('cmbTipoDiligencia').getValue()=='2')||(gEx('cmbTipoDiligencia').getValue()=='3'))
                                        {
                                            if(gEx('cmbAudienciaNotifica_10_52').getValue()=='')
                                            {
                                                function resp_10_52()
                                                {
                                                    gEx('cmbAudienciaNotifica_10_52').focus();
                                                }
                                                msgBox('Debe indicar la audiencia a la cual se cita en la notificaci&oacute;n',resp_10_52);
                                                return false;
                                            }
                                        }
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
										var pos=existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_10_5').getValue());
                                                
                                        var tAudienciaNotifica=arrAudienciasNotifica[pos][4];
                                        
                                        
                                        var tAudienciaNotifica2='';
                                        var lblFechaAudiencia2='';
                                        pos=existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_10_52').getValue());
                                        if(pos!=-1)
                                        {
                                        	tAudienciaNotifica2=arrAudienciasNotifica[pos][4];
                                            hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                            lblFechaAudiencia2=hora.format('d')+' de '+arrMeses[parseInt(hora.format('m')-1)][1]+' de '+
                                        						hora.format('Y')+' a las '+hora.format('H:i')+' hrs.';
                                        }
                                         
                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_10_5').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_10_5').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_10_5').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_10_5').getValue()+'","tAudienciaNotifica":"'+cv(tAudienciaNotifica)+'",'+
                                                    '"tAudienciaNotifica2":"'+tAudienciaNotifica2+'","fechaAudiencia2":"'+lblFechaAudiencia2+
                                                    '","nombreDeterminacion":"'+bD(gE('nombreDeterminacion').value)+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_10_5').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_10_5').getValue()+
                                                    '","resultado":"1","citatorio":"0","idEventoNotificacion":"'+gEx('cmbAudienciaNotifica_10_5').getValue()+
                                                    '","idEventoCita":"'+gEx('cmbAudienciaNotifica_10_52').getValue()+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_10_5').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_10_5').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbAudienciaNotifica_10_5').setValue(oEdicion.idEventoNotificacion);
                                                            gEx('cmbAudienciaNotifica_10_52').setValue(oEdicion.idEventoCita);

                                                        }  
    
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_10_7',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	gE('lblAdscripcion_10_7').innerHTML=tFigura.toLowerCase();
                                                                    	
                                                                        if(gEx('cmbTipoDiligencia').getValue()=='1')
                                                                    	{
                                                                        	gEx('lblAudiencia_10_7').hide();
                                                                            gEx('cmbAudienciaNotifica_10_7').hide();
                                                                            gEx('lblTipoIdentificacion_10_7').show();
                                                                            gEx('cmbIdentificacion_10_7').show();
                                                                            gEx('lblEspecifique_10_7').hide();
                                                                            gEx('txtEspecifique_10_7').hide();
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                        if(gEx('cmbTipoDiligencia').getValue()=='3')
                                                                    	{
                                                                        	gEx('lblAudiencia_10_7').show();
                                                                            gEx('cmbAudienciaNotifica_10_7').show();
                                                                            if(gE('idEventoDeriva').value!='-1')
	                                                                            gEx('cmbAudienciaNotifica_10_7').setValue(gE('idEventoDeriva').value);
                                                                                
                                                                            gEx('lblTipoIdentificacion_10_7').hide();
                                                                            gEx('cmbIdentificacion_10_7').hide();
                                                                            gEx('lblEspecifique_10_7').hide();
                                                                            gEx('txtEspecifique_10_7').hide();
                                                                        }
                                                                        
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_10_7',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_10_7,
                                                            {
                                                            	x:10,
                                                                y:70,
                                                                id:'lblAudiencia_10_7',
                                                                xtype:'label',
                                                                html:'Audiencia que se notifica:'
                                                            },
                                                            cmbAudienciaNotifica_10_7
                                                            ,
                                                            {
                                                            	x:10,
                                                                y:70,
                                                                id:'lblTipoIdentificacion_10_7',
                                                                xtype:'label',
                                                                html:'Tipo de identificaci&oacute;n presentada:'

                                                                
                                                            },
                                                            cmbIdentificacion_10_7,
                                                            {
                                                            	x:10,
                                                                y:100,
                                                                id:'lblEspecifique_10_7',
                                                                hidden:true,
                                                                xtype:'label',
                                                                html:'Especifique:'

                                                                
                                                            },
                                                            {
                                                            	xtype:'textfield',
                                                            	x:150,
                                                                y:105,
                                                                hidden:true,
                                                                id:'txtEspecifique_10_7',
                                                                widht:300
                                                            }
                                                            
                                                            ,
                                                            {
                                                            	x:10,
                                                                y:130,
                                                                hidden:!((gEx('cmbDetalleFigura').getValue()=='1')||(nodoSujetoSel.attributes.personaJuridica=='10')),
                                                                xtype:'label',
                                                                html:'Adscripci&oacute;n del <span id="lblAdscripcion_10_7">ministerio p&uacute;blico</span>:'
                                                            },
                                                            {
                                                            	x:200,
                                                                y:125,
                                                                hidden:!((gEx('cmbDetalleFigura').getValue()=='1')||(nodoSujetoSel.attributes.personaJuridica=='10')),
                                                                
                                                                xtype:'textfield',
                                                                width:350,
                                                                id:'txtAdscripcion_10_7',
                                                            }
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_10_7').getValue()=='')
                                        {
                                        	function resp_10_7()
                                            {
                                            	gEx('fecha_10_7').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_10_7);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_10_7').getValue()=='')
                                        {
                                        	function resp2_10_7()
                                            {
                                            	gEx('cmbHora_10_7').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_10_7);
                                        	return false;
                                        }
                                        if(gEx('cmbTipoDiligencia').getValue()=='2')
                                        {
                                            if(gEx('cmbAudienciaNotifica_10_7').getValue()=='')
                                            {
                                                function resp3_10_7()
                                                {
                                                    gEx('cmbAudienciaNotifica_10_7').focus();
                                                }
                                                msgBox('Debe indicar la audiencia que se notifica en la diligencia',resp3_10_7);
                                                return false;
                                            }
                                        }
                                        if(gEx('cmbTipoDiligencia').getValue()=='1')
                                        {
                                            if(gEx('cmbIdentificacion_10_7').getValue()=='')
                                            {
                                                function resp5_10_7()
                                                {
                                                    gEx('cmbIdentificacion_10_7').focus();
                                                }
                                                msgBox('Debe indicar la identificaci&oacute;n presentada en la diligencia',resp5_10_7);
                                                return false;
                                            }
                                            
                                            if((gEx('cmbIdentificacion_10_7').getValue()=='99')&&(gEx('txtEspecifique_10_7').getValue()==''))
                                            {
                                                function respEspIdentificacion_10_7()
                                                {
                                                    gEx('txtEspecifique_10_7').focus();
                                                }
                                                msgBox('Debe indicar la identificaci&oacute;n presentada durante la diligencia',respEspIdentificacion_10_7);
                                                return false;
                                            }
                                            
                                        }
                                        if((gEx('cmbDetalleFigura').getValue()=='1')||(nodoSujetoSel.attributes.personaJuridica=='10'))
                                        {
                                            if(gEx('txtAdscripcion_10_7').getValue()=='')
                                            {
                                                function resp4_10_7()
                                                {
                                                    gEx('txtAdscripcion_10_7').focus();
                                                }
                                                msgBox('Debe indicar la adscripci&oacute;n del '+tFigura.toLowerCase(),resp4_10_7);
                                                return false;
                                            }
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
										var pos=-1;
                                        if(gEx('cmbAudienciaNotifica_10_7').getValue()!='')
	                                       pos= existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_10_7').getValue());
                                        
                                        
                                        var horaAudiencia='';
                                        var lblAudiencia='';
                                        if(pos!=-1)
                                        {
                                         	var fecha=Date.parseDate(arrAudienciasNotifica[pos][2],'Y-m-d');
                                        	var hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                            horaAudiencia=hora.format('H:i');
                                        	lblAudiencia=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y')
                                        }
                                        
                                        var cadObj=',"diaDiligencia":"'+gEx('fecha_10_7').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_10_7').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_10_7').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_10_7').getValue()+'","horaAudiencia":"'+horaAudiencia+'","fechaAudiencia":"'+
                                                    lblAudiencia+'","adscripcionParticipante":"'+cv(gEx('txtAdscripcion_10_7').getValue())+
                                                    '","tipoIdentificacion":"'+gEx('cmbIdentificacion_10_7').getValue()+'","lblTipoIdentificacion":"'+
                                                    cv(gEx('cmbIdentificacion_10_7').getValue()==99?gEx('txtEspecifique_10_7').getValue():
                                                    gEx('cmbIdentificacion_10_7').getRawValue())+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_10_7').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_10_7').getValue()+
                                                    '","resultado":"1","citatorio":"0","idAudienciaNotifica":"'+gEx('cmbAudienciaNotifica_10_7').getValue()+
                                                    '","adscripcionParticipante":"'+cv(gEx('txtAdscripcion_10_7').getValue())+
                                                    '","tipoIdentificacion":"'+gEx('cmbIdentificacion_10_7').getValue()+
                                                    '","identificacionEspecifica":"'+cv(gEx('txtEspecifique_10_7').getValue())+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_10_7').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_10_7').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbAudienciaNotifica_10_7').setValue(oEdicion.idAudienciaNotifica);
                                                            gEx('txtAdscripcion_10_7').setValue(oEdicion.adscripcionParticipante);
                                                            gEx('cmbIdentificacion_10_7').setValue(oEdicion.tipoIdentificacion);
                                                            gEx('txtEspecifique_10_7').setValue(oEdicion.identificacionEspecifica);
                                                            
                                                            dispararEventoSelectCombo('cmbIdentificacion_10_7');
                                                            

                                                        } 
    
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_2_2',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_2_2',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_2_2,
                                                            {
                                                            	x:10,
                                                                y:70,
                                                                xtype:'label',
                                                                html:'Audiencia que se notifica:'
                                                            },
                                                            cmbAudienciaNotifica_2_2,
                                                            {
                                                            	x:10,
                                                                y:100,
                                                                xtype:'label',
                                                                html:'Fecha/hora de respuesta:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:95,
                                                                xtype:'datefield',
                                                                id:'fechaRespuesta_2_2',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            cmbHoraRespuesta_2_2
                                                           
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_2_2').getValue()=='')
                                        {
                                        	function resp_2_2()
                                            {
                                            	gEx('fecha_2_2').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_2_2);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_2_2').getValue()=='')
                                        {
                                        	function resp2_2_2()
                                            {
                                            	gEx('cmbHora_2_2').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_2_2);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbAudienciaNotifica_2_2').getValue()=='')
                                        {
                                        	function resp3_2_2()
                                            {
                                            	gEx('cmbAudienciaNotifica_2_2').focus();
                                            }
                                            msgBox('Debe indicar la audiencia que se notifica en la diligencia',resp3_2_2);
                                        	return false;
                                        }
                                        
                                        
                                        if(gEx('fechaRespuesta_2_2').getValue()=='')
                                        {
                                        	function respRespuesta_2_2()
                                            {
                                            	gEx('fechaRespuesta_2_2').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se recibi&oacute; respuesta de la diligencia',respRespuesta_2_2);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHoraRespuesta_2_2').getValue()=='')
                                        {
                                        	function resp2Respuesta_2_2()
                                            {
                                            	gEx('cmbHoraRespuesta_2_2').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se recibi&oacute; respuesta de la diligencia',resp2Respuesta_2_2);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
										var pos=existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_2_2').getValue());
                                        var fecha=gEx('fechaRespuesta_2_2').getValue();
                                        var lblFechaRespuesta=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y');

                                        fecha=Date.parseDate(arrAudienciasNotifica[pos][2],'Y-m-d');
                                        var hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                        var lblAudiencia=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y')
                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_2_2').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_2_2').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_2_2').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_2_2').getValue()+'","horaAudiencia":"'+hora.format('H:i')+
                                                    '","fechaAudiencia":"'+lblAudiencia+'","horaRespuesta":"'+gEx('cmbHoraRespuesta_2_2').getValue()+
                                                    '","fechaRespuesta":"'+lblFechaRespuesta+'","salaAudiencia":"'+parseInt(arrAudienciasNotifica[pos][5])+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_2_2').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_2_2').getValue()+
                                                    '","resultado":"1","citatorio":"0","idAudienciaNotifica":"'+gEx('cmbAudienciaNotifica_2_2').getValue()+
                                                    '","horaRespuesta":"'+gEx('cmbHoraRespuesta_2_2').getValue()+
                                                    '","fechaRespuesta":"'+gEx('fechaRespuesta_2_2').getValue().format('Y-m-d')+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_2_2').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_2_2').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbAudienciaNotifica_2_2').setValue(oEdicion.idAudienciaNotifica);
                                                            gEx('cmbHoraRespuesta_2_2').setValue(oEdicion.horaRespuesta);
                                                            gEx('fechaRespuesta_2_2').setValue(oEdicion.fechaRespuesta);

                                                        } 
    
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_10_6_2',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                        
                                                                        if(gEx('cmbTipoDiligencia').getValue()=='1')
                                                                        {
                                                                            cmbAudienciaNotifica_10_6_2.hide();
                                                                            gEx('lblAudienciaNotifica_10_6_2').hide();
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                            cmbAudienciaNotifica_10_6_2.show();
                                                                            gEx('lblAudienciaNotifica_10_6_2').show();
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_10_6_2',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_10_6_2,
                                                            {
                                                            	x:10,
                                                                y:70,
                                                                xtype:'label',
                                                                id:'lblAudienciaNotifica_10_6_2',
                                                                html:'Audiencia que se notifica:'
                                                            },
                                                            cmbAudienciaNotifica_10_6_2,
                                                            {
                                                            	x:10,
                                                                y:100,
                                                                xtype:'label',
                                                                html:'Fecha/hora de respuesta:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:95,
                                                                xtype:'datefield',
                                                                id:'fechaRespuesta_10_6_2',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            cmbHoraRespuesta_10_6_2
                                                           
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_10_6_2').getValue()=='')
                                        {
                                        	function resp_10_6_2()
                                            {
                                            	gEx('fecha_10_6_2').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_10_6_2);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_10_6_2').getValue()=='')
                                        {
                                        	function resp2_10_6_2()
                                            {
                                            	gEx('cmbHora_10_6_2').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_10_6_2);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbTipoDiligencia').getValue()!='1')
                                        {
                                            if(gEx('cmbAudienciaNotifica_10_6_2').getValue()=='')
                                            {
                                                function resp3_10_6_2()
                                                {
                                                    gEx('cmbAudienciaNotifica_10_6_2').focus();
                                                }
                                                msgBox('Debe indicar la audiencia que se notifica en la diligencia',resp3_10_6_2);
                                                return false;
                                            }
                                        }
                                        
                                        if(gEx('fechaRespuesta_10_6_2').getValue()=='')
                                        {
                                        	function respRespuesta_10_6_2()
                                            {
                                            	gEx('fechaRespuesta_10_6_2').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se recibi&oacute; respuesta de la diligencia',respRespuesta_10_6_2);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHoraRespuesta_10_6_2').getValue()=='')
                                        {
                                        	function resp2Respuesta_10_6_2()
                                            {
                                            	gEx('cmbHoraRespuesta_10_6_2').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se recibi&oacute; respuesta de la diligencia',resp2Respuesta_10_6_2);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
                                    	var lblAudiencia='';
                                        var lblHora='';
                                        var fecha=gEx('fechaRespuesta_10_6_2').getValue();
                                        var lblFechaRespuesta=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y');
    									var salaAudiencia='';
                                        if(gEx('cmbTipoDiligencia').getValue()!='1')
                                        {
                                            var pos=existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_10_6_2').getValue());
                                            
                                            fecha=Date.parseDate(arrAudienciasNotifica[pos][2],'Y-m-d');
                                            var hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                            lblAudiencia=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y');
                                            lblHora=hora.format('H:i');
                                            salaAudiencia=parseInt(arrAudienciasNotifica[pos][5]);
                                        }
                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_10_6_2').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_10_6_2').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_10_6_2').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_10_6_2').getValue()+'","horaAudiencia":"'+lblHora+
                                                    '","fechaAudiencia":"'+lblAudiencia+'","horaRespuesta":"'+gEx('cmbHoraRespuesta_10_6_2').getValue()+
                                                    '","fechaRespuesta":"'+lblFechaRespuesta+'","salaAudiencia":"'+salaAudiencia+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_10_6_2').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_10_6_2').getValue()+
                                                    '","resultado":"1","citatorio":"0","idAudienciaNotifica":"'+gEx('cmbAudienciaNotifica_10_6_2').getValue()+
                                                    '","horaRespuesta":"'+gEx('cmbHoraRespuesta_10_6_2').getValue()+
                                                    '","fechaRespuesta":"'+gEx('fechaRespuesta_10_6_2').getValue().format('Y-m-d')+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_10_6_2').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_10_6_2').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbAudienciaNotifica_10_6_2').setValue(oEdicion.idAudienciaNotifica);
                                                            gEx('cmbHoraRespuesta_10_6_2').setValue(oEdicion.horaRespuesta);
                                                            gEx('fechaRespuesta_10_6_2').setValue(oEdicion.fechaRespuesta);

                                                        } 
    
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_2_0',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_2_0',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_2_0,
                                                            {
                                                            	x:10,
                                                                y:70,
                                                                xtype:'label',
                                                                html:'Audiencia que se notifica:'
                                                            },
                                                            cmbAudienciaNotifica_2_0,
                                                            {
                                                            	x:10,
                                                                y:100,
                                                                xtype:'label',
                                                                html:'Medio de notificaci&oacute;n:'
                                                            },
                                                            {
                                                            	x:150,
                                                                y:95,
                                                                id:'txtOtroMedio_2_0',
                                                                width:300,
                                                                xtype:'textfield'
                                                            },
                                                            {
                                                            	x:10,
                                                                y:130,
                                                                xtype:'label',
                                                                html:'Fecha/hora de respuesta:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:125,
                                                                xtype:'datefield',
                                                                id:'fechaRespuesta_2_0',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            cmbHoraRespuesta_2_0
                                                           
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_2_0').getValue()=='')
                                        {
                                        	function resp_2_0()
                                            {
                                            	gEx('fecha_2_0').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_2_0);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_2_0').getValue()=='')
                                        {
                                        	function resp2_2_0()
                                            {
                                            	gEx('cmbHora_2_0').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_2_0);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbAudienciaNotifica_2_0').getValue()=='')
                                        {
                                        	function resp3_2_0()
                                            {
                                            	gEx('cmbAudienciaNotifica_2_0').focus();
                                            }
                                            msgBox('Debe indicar la audiencia que se notifica en la diligencia',resp3_2_0);
                                        	return false;
                                        }
                                        
                                        if(gEx('txtOtroMedio_2_0').getValue()=='')
                                        {
                                        	function respRespuestaMedio_2_0()
                                            {
                                            	gEx('txtOtroMedio_2_0').focus();
                                            }
                                            msgBox('Debe indicar el medio de notificaci&oacute;n mediante el cual se realiz&oacute; la diligencia',respRespuestaMedio_2_0);
                                        	return false;
                                        }
                                        
                                        if(gEx('fechaRespuesta_2_0').getValue()=='')
                                        {
                                        	function respRespuesta_2_0()
                                            {
                                            	gEx('fechaRespuesta_2_0').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se recibi&oacute; respuesta de la diligencia',respRespuesta_2_0);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHoraRespuesta_2_0').getValue()=='')
                                        {
                                        	function resp2Respuesta_2_0()
                                            {
                                            	gEx('cmbHoraRespuesta_2_0').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se recibi&oacute; respuesta de la diligencia',resp2Respuesta_2_0);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
										var pos=existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_2_0').getValue());
                                        var fecha=gEx('fechaRespuesta_2_0').getValue();
                                        var lblFechaRespuesta=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y');

                                        fecha=Date.parseDate(arrAudienciasNotifica[pos][2],'Y-m-d');
                                        var hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                        var lblAudiencia=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y')
                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_2_0').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_2_0').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_2_0').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_2_0').getValue()+'","horaAudiencia":"'+hora.format('H:i')+
                                                    '","fechaAudiencia":"'+lblAudiencia+'","horaRespuesta":"'+gEx('cmbHoraRespuesta_2_0').getValue()+
                                                    '","fechaRespuesta":"'+lblFechaRespuesta+'","salaAudiencia":"'+parseInt(arrAudienciasNotifica[pos][5])+
                                                    '","medioOtro":"'+cv(gEx('txtOtroMedio_2_0').getValue())+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_2_0').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_2_0').getValue()+
                                                    '","resultado":"1","citatorio":"0","idAudienciaNotifica":"'+gEx('cmbAudienciaNotifica_2_0').getValue()+
                                                    '","horaRespuesta":"'+gEx('cmbHoraRespuesta_2_0').getValue()+
                                                    '","fechaRespuesta":"'+gEx('fechaRespuesta_2_0').getValue().format('Y-m-d')+'","medioOtro":"'+
                                                    cv(gEx('txtOtroMedio_2_0').getValue())+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_2_0').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_2_0').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbAudienciaNotifica_2_0').setValue(oEdicion.idAudienciaNotifica);
                                                            gEx('cmbHoraRespuesta_2_0').setValue(oEdicion.horaRespuesta);
                                                            gEx('fechaRespuesta_2_0').setValue(oEdicion.fechaRespuesta);
                                                            gEx('txtOtroMedio_2_0').setValue(oEdicion.medioOtro)

                                                        } 
                                                        
	arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_10_6_0',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                        
                                                                        if(gEx('cmbTipoDiligencia').getValue()=='1')
                                                                        {
                                                                            cmbAudienciaNotifica_10_6_0.hide();
                                                                            gEx('lblAudienciaNotifica_10_6_0').hide();
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                            cmbAudienciaNotifica_10_6_0.show();
                                                                            gEx('lblAudienciaNotifica_10_6_0').show();
                                                                           
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_10_6_0',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_10_6_0,
                                                            {
                                                            	x:10,
                                                                y:70,
                                                                xtype:'label',
                                                                id:'lblAudienciaNotifica_10_6_0',
                                                                html:'Audiencia que se notifica:'
                                                            },
                                                            cmbAudienciaNotifica_10_6_0,
                                                            {
                                                            	x:10,
                                                                y:100,
                                                                xtype:'label',
                                                                html:'Medio de notificaci&oacute;n:'
                                                            },
                                                            {
                                                            	x:150,
                                                                y:95,
                                                                id:'txtOtroMedio_10_6_0',
                                                                width:300,
                                                                xtype:'textfield'
                                                            },
                                                            {
                                                            	x:10,
                                                                y:130,
                                                                xtype:'label',
                                                                html:'Fecha/hora de respuesta:'
                                                            },
                                                            {
                                                                x:150,
                                                                y:125,
                                                                xtype:'datefield',
                                                                id:'fechaRespuesta_10_6_0',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            cmbHoraRespuesta_10_6_0
                                                           
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_10_6_0').getValue()=='')
                                        {
                                        	function resp_10_6_0()
                                            {
                                            	gEx('fecha_10_6_0').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_10_6_0);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_10_6_0').getValue()=='')
                                        {
                                        	function resp2_10_6_0()
                                            {
                                            	gEx('cmbHora_10_6_0').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_10_6_0);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbTipoDiligencia').getValue()!='1')
                                        {
                                            if(gEx('cmbAudienciaNotifica_10_6_0').getValue()=='')
                                            {
                                                function resp3_10_6_0()
                                                {
                                                    gEx('cmbAudienciaNotifica_10_6_0').focus();
                                                }
                                                msgBox('Debe indicar la audiencia que se notifica en la diligencia',resp3_10_6_0);
                                                return false;
                                            }
										}
                                                                                
                                        if(gEx('txtOtroMedio_10_6_0').getValue()=='')
                                        {
                                        	function respRespuestaMedio_10_6_0()
                                            {
                                            	gEx('txtOtroMedio_10_6_0').focus();
                                            }
                                            msgBox('Debe indicar el medio de notificaci&oacute;n mediante el cual se realiz&oacute; la diligencia',respRespuestaMedio_10_6_0);
                                        	return false;
                                        }
                                        
                                        if(gEx('fechaRespuesta_10_6_0').getValue()=='')
                                        {
                                        	function respRespuesta_10_6_0()
                                            {
                                            	gEx('fechaRespuesta_10_6_0').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se recibi&oacute; respuesta de la diligencia',respRespuesta_10_6_0);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHoraRespuesta_10_6_0').getValue()=='')
                                        {
                                        	function resp2Respuesta_10_6_0()
                                            {
                                            	gEx('cmbHoraRespuesta_10_6_0').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se recibi&oacute; respuesta de la diligencia',resp2Respuesta_10_6_0);
                                        	return false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
                                    	var lblAudiencia='';
                                        var lblHora='';
                                        var fecha=gEx('fechaRespuesta_10_6_0').getValue();
                                        var lblFechaRespuesta=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y');
    									var salaAudiencia='';	
                                        if(gEx('cmbTipoDiligencia').getValue()!='1')
                                        {
                                            var pos=existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_10_6_0').getValue());
                                            fecha=Date.parseDate(arrAudienciasNotifica[pos][2],'Y-m-d');
                                            var hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                            lblAudiencia=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y');
                                            lblHora=hora.format('H:i');
                                            salaAudiencia=parseInt(arrAudienciasNotifica[pos][5]);
                                        }
                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_10_6_0').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_10_6_0').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_10_6_0').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_10_6_0').getValue()+'","horaAudiencia":"'+lblHora+
                                                    '","fechaAudiencia":"'+lblAudiencia+'","horaRespuesta":"'+gEx('cmbHoraRespuesta_10_6_0').getValue()+
                                                    '","fechaRespuesta":"'+lblFechaRespuesta+'","salaAudiencia":"'+salaAudiencia+
                                                    '","medioOtro":"'+cv(gEx('txtOtroMedio_10_6_0').getValue())+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_10_6_0').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_10_6_0').getValue()+
                                                    '","resultado":"1","citatorio":"0","idAudienciaNotifica":"'+gEx('cmbAudienciaNotifica_10_6_0').getValue()+
                                                    '","horaRespuesta":"'+gEx('cmbHoraRespuesta_10_6_0').getValue()+
                                                    '","fechaRespuesta":"'+gEx('fechaRespuesta_10_6_0').getValue().format('Y-m-d')+'","medioOtro":"'+
                                                    cv(gEx('txtOtroMedio_10_6_0').getValue())+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_10_6_0').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_10_6_0').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbAudienciaNotifica_10_6_0').setValue(oEdicion.idAudienciaNotifica);
                                                            gEx('cmbHoraRespuesta_10_6_0').setValue(oEdicion.horaRespuesta);
                                                            gEx('fechaRespuesta_10_6_0').setValue(oEdicion.fechaRespuesta);
                                                            gEx('txtOtroMedio_10_6_0').setValue(oEdicion.medioOtro)

                                                        } 
                                                                                                                
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_10_6_1',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                        
                                                                        if(gEx('cmbTipoDiligencia').getValue()=='1')
                                                                        {
                                                                            cmbAudienciaNotifica_10_6_1.hide();
                                                                            gEx('lblAudienciaNotifica_10_6_1').hide();
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                            cmbAudienciaNotifica_10_6_1.show();
                                                                            gEx('lblAudienciaNotifica_10_6_1').show();
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:175,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_10_6_1',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                            	x:250,
                                                                y:110,                                                                
                                                                xtype:'button',
                                                                icon:'../images/email_go.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Enviar correo',
                                                                handler:function()
                                                                        {
                                                                        	mostrarVentanaAdmonCorreo()
                                                                            
                                                                        }
                                                                
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_10_6_1,
                                                            {
                                                            	x:10,
                                                                y:70,
                                                                xtype:'label',
                                                                id:'lblAudienciaNotifica_10_6_1',
                                                                html:'Audiencia que se notifica:'
                                                            },
                                                            cmbAudienciaNotifica_10_6_1,
                                                            {
                                                            	x:10,
                                                                y:160,
                                                                xtype:'label',
                                                                html:'Resultado de la notificaci&oacute;n:'
                                                            },
                                                            cmbResultadoNotificacion_10_6_1,
                                                            {
                                                            	x:10,
                                                                y:190,
                                                                xtype:'label',
                                                                id:'lblFechaHoraRespuesta_10_6_1',
                                                                html:'Fecha/hora de respuesta:'
                                                            },
                                                            {
                                                                x:175,
                                                                y:185,
                                                                xtype:'datefield',
                                                                id:'fechaRespuesta_10_6_1',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            cmbHoraRespuesta_10_6_1
                                                           
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_10_6_1').getValue()=='')
                                        {
                                        	function resp_10_6_1()
                                            {
                                            	gEx('fecha_10_6_1').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_10_6_1);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_10_6_1').getValue()=='')
                                        {
                                        	function resp2_10_6_1()
                                            {
                                            	gEx('cmbHora_10_6_1').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_10_6_1);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbTipoDiligencia').getValue()!='1')
                                        {
                                            if(gEx('cmbAudienciaNotifica_10_6_1').getValue()=='')
                                            {
                                                function resp3_10_6_1()
                                                {
                                                    gEx('cmbAudienciaNotifica_10_6_1').focus();
                                                }
                                                msgBox('Debe indicar la audiencia que se notifica en la diligencia',resp3_10_6_1);
                                                return false;
                                            }
                                        }
                                        
                                        if(gEx('cmbResultadoNotificacion_10_6_1').getValue()=='')
                                        {
                                        	function resp2RespuestaResultado_10_6_1()
                                            {
                                            	gEx('cmbResultadoNotificacion_10_6_1').focus();
                                            }
                                            msgBox('Debe indicar el resultado de la diligencia',resp2RespuestaResultado_10_6_1);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbResultadoNotificacion_10_6_1')=='1')
                                        {
                                            if(gEx('fechaRespuesta_10_6_1').getValue()=='')
                                            {
                                                function respRespuesta_10_6_1()
                                                {
                                                    gEx('fechaRespuesta_10_6_1').focus();
                                                }
                                                msgBox('Debe indicar la fecha en que se recibi&oacute; respuesta de la diligencia',respRespuesta_10_6_1);
                                                return false;
                                            }
                                            
                                            
                                            if(gEx('cmbHoraRespuesta_10_6_1').getValue()=='')
                                            {
                                                function resp2Respuesta_10_6_1()
                                                {
                                                    gEx('cmbHoraRespuesta_10_6_1').focus();
                                                }
                                                msgBox('Debe indicar la hora en que se recibi&oacute; respuesta de la diligencia',resp2Respuesta_10_6_1);
                                                return false;
                                            }
                                        }
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
                                    	var lblAudiencia='';
                                        var lblHora='';
                                        var fecha=gEx('fechaRespuesta_10_6_1').getValue();
                                        var lblFechaRespuesta=(fecha==''?'':(fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y')));
    									var salaAudiencia='';
                                        if(gEx('cmbTipoDiligencia').getValue()!='1')
                                        {
                                            var pos=existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_10_6_1').getValue());
                                            fecha=Date.parseDate(arrAudienciasNotifica[pos][2],'Y-m-d');
                                            var hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                            lblAudiencia=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y');
                                            lblHora=hora.format('H:i');
                                            salaAudiencia=parseInt(arrAudienciasNotifica[pos][5]);
                                        }
                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_10_6_1').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_10_6_1').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_10_6_1').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_10_6_1').getValue()+'","horaAudiencia":"'+lblHora+
                                                    '","fechaAudiencia":"'+lblAudiencia+'","horaRespuesta":"'+gEx('cmbHoraRespuesta_10_6_1').getValue()+
                                                    '","fechaRespuesta":"'+lblFechaRespuesta+'","salaAudiencia":"'+salaAudiencia+
                                                    '","resultadoMail":"'+gEx('cmbResultadoNotificacion_10_6_1').getValue()+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var notificado=1;
                                        switch(gEx('cmbResultadoNotificacion_10_6_1').getValue())
                                        {
                                        	case '0':
                                            case '2':
                                            	notificado=0;
                                            break;
                                        }
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_10_6_1').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_10_6_1').getValue()+
                                                    '","resultado":"'+gEx('cmbResultadoNotificacion_10_6_1').getValue()+
                                                    '","citatorio":"0","idAudienciaNotifica":"'+gEx('cmbAudienciaNotifica_10_6_1').getValue()+
                                                    '","horaRespuesta":"'+gEx('cmbHoraRespuesta_10_6_1').getValue()+
                                                    '","fechaRespuesta":"'+(gEx('fechaRespuesta_10_6_1').getValue()!=''?gEx('fechaRespuesta_10_6_1').getValue().format('Y-m-d'):'')+
                                                    '","resultadoMail":"'+gEx('cmbResultadoNotificacion_10_6_1').getValue()+'","notificado":"'+notificado+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('cmbResultadoNotificacion_10_6_1').setValue(oEdicion.resultadoMail)
                                                            dispararEventoSelectCombo('cmbResultadoNotificacion_10_6_1');
                                                            gEx('cmbResultadoNotificacion_10_6_1').fireEvent('change',gEx('cmbResultadoNotificacion_10_6_1'),gEx('cmbResultadoNotificacion_10_6_1').getValue());
                                                            gEx('fecha_10_6_1').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_10_6_1').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbAudienciaNotifica_10_6_1').setValue(oEdicion.idAudienciaNotifica);
                                                            gEx('cmbHoraRespuesta_10_6_1').setValue(oEdicion.horaRespuesta);
                                                            gEx('fechaRespuesta_10_6_1').setValue(oEdicion.fechaRespuesta);
                                                            

                                                        } 
    
    
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_10_8',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	gEx('panelDomicilio_10_8').setActiveTab(0);
                                                                    	if((gEx('cmbDetalleFigura').getValue()=='1')||(nodoSujetoSel.attributes.personaJuridica=='10'))
                                                                        {
                                                                        	if(gEx('cmbDetalleFigura').getValue()=='1')	
                                                                            {
                                                                            	switch(nodoSujetoSel.attributes.personaJuridica)
                                                                                {
                                                                                	case '3':
                                                                                    	gE('lblTipoOficina_10_8').innerHTML=' de la Coordinación de Asesores Jurídicos Públicos de la Procuraduría General de la Ciudad de México';
                                                                                    break;
                                                                                    case '5':
                                                                                    	gE('lblTipoOficina_10_8').innerHTML='  de la Defensoría Pública de la Ciudad de México';
                                                                                    break;
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                            	gE('lblTipoOficina_10_8').innerHTML=' de la Procuraduría General de Justicia de la Ciudad de México';
                                                                            }
                                                                            mostrarInfoOficina=true;
                                                                            
                                                                        }
                                                                        
                                                                    
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                            var oDiligencia=eval('['+bD(fila.data.objDiligencia)+']')[0];
																			
                                                                            if(fila.data.enviadoCentralNotificadores=='1')
                                                                            {
                                                                            	gEx('btnEnviarCentral').hide();
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                       
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                            	xtype:'tabpanel',
                                                                width:600,
                                                                y:-2,
                                                                height:255,
                                                                activeTab:1,
                                                                id:'panelDomicilio_10_8',
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                id:'p1raVisita',
                                                                                bodyStyle:{"background-color":"#F5F5F5","font-size":"11px"}, 
                                                                                title:'Notificaci&oacute;n general',
                                                                                layout:'absolute',
                                                                                items:	[
                                                                                			{
                                                                                                x:10,
                                                                                                y:10,
                                                                                                xtype:'label',
                                                                                                html:'Fecha de la diligencia:'
                                                                                            },
                                                                                            {
                                                                                                x:150,
                                                                                                y:5,
                                                                                                xtype:'datefield',
                                                                                                id:'fecha_10_8',
                                                                                                value:'<?php echo date("Y-m-d")?>'
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:40,
                                                                                                xtype:'label',
                                                                                                html:'Hora de la diligencia:'
                                                                                            },
                                                                                            
                                                                                            cmbHora_10_8,
                                                                                            {
                                                                                            	x:340,
                                                                                                y:30,
                                                                                                xtype:'button',
                                                                                                id:'btnEnviarCentral',
                                                                                                icon:'../images/user_go.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Enviar a central de notificadores',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	
                                                                                                        	function resp(btn)
                                                                                                            {
                                                                                                            	if(btn=='yes')
                                                                                                                {
                                                                                                                	gEx('cmbResultadoDiligencia_10_8').setValue('3');
                                                                                                                	guardarDiligencia(true);
                                                                                                                }
                                                                                                            }
                                                                                                            msgConfirm('Est&aacute; seguro de querer enviar a central de notificadores la tarea de notificaci&oacute;n?',resp);
                                                                                                        	
                                                                                                            
                                                                                                        
                                                                                                        
                                                                                                        	
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            ,
                                                                                            {
                                                                                                x:10,
                                                                                                y:70,
                                                                                                xtype:'label',
                                                                                                html:'Resultado de la diligencia:'
                                                                                            },
                                                                                            cmbResultadoDiligencia_10_8,
                                                                                            {
                                                                                                x:10,
                                                                                                y:100,
                                                                                                hidden:true,
                                                                                                id:'lblTipoIdentificacion_10_8',
                                                                                                xtype:'label',
                                                                                                html:'Tipo de identificaci&oacute;n presentada:'
                                
                                                                                                
                                                                                            },
                                                                                            cmbIdentificacion_10_8,
                                                                                            {
                                                                                                x:10,
                                                                                                y:130,
                                                                                                id:'lblEspecifique',
                                                                                                hidden:true,
                                                                                                xtype:'label',
                                                                                                html:'Especifique:'
                                
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                xtype:'textfield',
                                                                                                x:150,
                                                                                                y:125,
                                                                                                hidden:true,
                                                                                                id:'txtEspecifique_10_8',
                                                                                                widht:300
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:160,
                                                                                                hidden:true,
                                                                                                id:'lblFecha2daVisita_10_8',
                                                                                                xtype:'label',
                                                                                                html:'Fecha/hora de pr&oacute;xima visita:'
                                                                                            },
                                                                                            
                                                                                            {
                                                                                            	x:200,
                                                                                                y:155,
                                                                                                hidden:true,
                                                                                                id:'txtFechadaVisita_10_8',
                                                                                                xtype:'datefield'
                                                                                            },
                                                                                            cmbHora2daVisita_10_8,
                                                                                            {
                                                                                                x:10,
                                                                                                y:188,
                                                                                                hidden:true,
                                                                                                id:'lblLugarCitatorio_10_8',
                                                                                                xtype:'label',
                                                                                                html:'Se fij&oacute; citatorio en:'
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:183,
                                                                                                hidden:true,
                                                                                                xtype:'textfield',
                                                                                                width:300,
                                                                                                id:'txtLugarFijoCitatorio_10_8'
                                                                                            },
                                                                                             {
                                                                                                x:10,
                                                                                                y:100,
                                                                                                hidden:true,
                                                                                                id:'lblPersona2daVisita_10_8',
                                                                                                xtype:'label',
                                                                                                html:'Persona que recibi&oacute; citatorio:'
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:95,
                                                                                                xtype:'textfield',
                                                                                                width:230,
                                                                                                hidden:true,
                                                                                                id:'txtPersona_10_8'
                                                                                            },
                                                                                             {
                                                                                                x:10,
                                                                                                y:130,
                                                                                                hidden:true,
                                                                                                id:'lblRelacion_10_8',
                                                                                                xtype:'label',
                                                                                                html:'Relaci&oacute;n / Cargo:'
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:125,
                                                                                                xtype:'textfield',
                                                                                                width:250,
                                                                                                hidden:true,
                                                                                                id:'txtRelacion_10_8'
                                                                                            },
                                                                                            
                                                                                            {
                                                                                                x:10,
                                                                                                y:216,
                                                                                                hidden:true,
                                                                                                id:'lblDomicioOficina_10_8',
                                                                                                xtype:'label',
                                                                                                html:'El domicilio corresponda a las oficinas de:'
                                                                                            },
                                                                                            {
                                                                                            	x:250,
                                                                                                y:211,
                                                                                                hidden:true,
                                                                                                xtype:'textfield',
                                                                                                width:320,
                                                                                                id:'txtDomicilio_10_8'
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:235,
                                                                                                hidden:true,
                                                                                                id:'lblTipoOficina_10_8',
                                                                                                xtype:'label',
                                                                                                html:'<span id="lblTipoOficina_10_8"></span>'
                                                                                            }
                                                                                		]
                                                                            },
                                                                            {
                                                                            	xtype:'panel',
                                                                                id:'p2daVisita',
                                                                                bodyStyle:{"background-color":"#F5F5F5","font-size":"11px"}, 
                                                                                title:'Resultado segunda visita',
                                                                                disabled:true,
                                                                                layout:'absolute',
                                                                                items:	[
                                                                                			{
                                                                                            	x:10,
                                                                                                y:10,
                                                                                                xtype:'label',
                                                                                                html:'Resultado de la diligencia:'
                                                                                            },
                                                                                            cmbResultado2daDiligencia_10_8,
                                                                                            {
                                                                                                x:10,
                                                                                                y:40,
                                                                                                hidden:true,
                                                                                                id:'lblPersona2daVisitaNotificacion_10_8',
                                                                                                xtype:'label',
                                                                                                html:'Persona que recibi&oacute; notificaci&oacute;n:'
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:35,
                                                                                                xtype:'textfield',
                                                                                                width:230,
                                                                                                hidden:true,
                                                                                                id:'txtPersona2daVisitaNotificacion_10_8'
                                                                                            },
                                                                                             {
                                                                                                x:10,
                                                                                                y:70,
                                                                                                hidden:true,
                                                                                                id:'lblRelacion2daVisitaNotificacion_10_8',
                                                                                                xtype:'label',
                                                                                                html:'Relaci&oacute;n / Cargo:'
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:65,
                                                                                                xtype:'textfield',
                                                                                                width:250,
                                                                                                hidden:true,
                                                                                                id:'txtRelacion2daVisitaNotificacion_10_8'
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:40,
                                                                                                hidden:true,
                                                                                                id:'lblTipoIdentificacion2daVisita_10_8',
                                                                                                xtype:'label',
                                                                                                html:'Tipo de identificaci&oacute;n presentada:'
                                
                                                                                                
                                                                                            },
                                                                                            cmbIdentificacion2daVisita_10_8,
                                                                                            {
                                                                                                x:10,
                                                                                                y:70,
                                                                                                id:'lblEspecifique2daVisita_10_8',
                                                                                                hidden:true,
                                                                                                xtype:'label',
                                                                                                html:'Especifique:'
                                
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                xtype:'textfield',
                                                                                                x:130,
                                                                                                y:65,
                                                                                                hidden:true,
                                                                                                id:'txtEspecifique2daVisita_10_8',
                                                                                                widht:350
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:40,
                                                                                                hidden:true,
                                                                                                id:'lblLugarFijo2daVisita_10_8',
                                                                                                xtype:'label',
                                                                                                html:'Lugar donde se fija la notificaci&oacute;n:'
                                
                                                                                                
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:35,
                                                                                                xtype:'textfield',
                                                                                                hidden:true,
                                                                                                id:'txtLugarFijaCitatorio_10_8',
                                                                                                width:350
                                                                                            }
                                                                                		]
                                                                            }
                                                                		]
                                                            }
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_10_8').getValue()=='')
                                        {
                                        	function resp_10_8()
                                            {
                                            	gEx('panelDomicilio_10_8').setActiveTab(0);
                                            	gEx('fecha_10_8').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_10_8);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_10_8').getValue()=='')
                                        {
                                        	function resp2_10_8()
											{
                                            	gEx('panelDomicilio_10_8').setActiveTab(0);
                                            	gEx('cmbHora_10_8').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_10_8);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbResultadoDiligencia_10_8').getValue()=='')
                                        {
                                        	function respResultado2_10_8()
                                            {
                                            	gEx('panelDomicilio_10_8').setActiveTab(0);
                                            	gEx('cmbResultadoDiligencia_10_8').focus();
                                            }
                                            msgBox('Debe indicar el resultado de la diligencia',respResultado2_10_8);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbResultadoDiligencia_10_8').getValue()=='1')
                                        {
                                        	generaExposicion=true;
                                            if(gEx('cmbIdentificacion_10_8').getValue()=='')
                                            {
                                                function respIdentificacion_10_8()
                                                {
                                                	gEx('panelDomicilio_10_8').setActiveTab(0);
                                                    gEx('cmbIdentificacion_10_8').focus();
                                                }
                                                msgBox('Debe indicar la identificaci&oacute;n presentada durante la diligencia',respIdentificacion_10_8);
                                                return false;
                                            }
                                            
                                            if((gEx('cmbIdentificacion_10_8').getValue()=='99')&&(gEx('txtEspecifique_10_8').getValue()==''))
                                            {
                                                function respEspIdentificacion_10_8()
                                                {
                                                	gEx('panelDomicilio_10_8').setActiveTab(0);
                                                    gEx('txtEspecifique_10_8').focus();
                                                }
                                                msgBox('Debe indicar la identificaci&oacute;n presentada durante la diligencia',respEspIdentificacion_10_8);
                                                return false;
                                            }
                                            
                                            if(mostrarInfoOficina)
                                            {
                                            	 if(gEx('txtDomicilio_10_8').getValue()=='')
                                                {
                                                    function respDomicilio_10_8()
                                                    {
                                                    	gEx('panelDomicilio_10_8').setActiveTab(0);
                                                        gEx('txtDomicilio_10_8').focus();
                                                    }
                                                    msgBox('Debe indicar a qu&eacute; corresponde el domicilio sobre el cual se hizo la diligencia',respDomicilio_10_8);
                                                    return false;
                                                }
                                            }
                                            
                                        }
                                        
                                        if(gEx('cmbResultadoDiligencia_10_8').getValue()=='2')
                                        {
                                        	if(gEx('txtFechadaVisita_10_8').getValue()=='')
                                            {
                                            	function respFecha2da_10_8()
                                                {
                                                	gEx('panelDomicilio_10_8').setActiveTab(0);
                                                	gEx('txtFechadaVisita_10_8').focus();
                                                }
                                                msgBox('Debe indicar la fecha marcada en el citatorio para segunda visita',respFecha2da_10_8);
                                                return false;
                                            }
                                            
                                            if(gEx('cmbHora2daVisita_10_8').getValue()=='')
                                            {
                                            	function respHora2da_10_8()
                                                {
                                                	gEx('panelDomicilio_10_8').setActiveTab(0);
                                                	gEx('cmbHora2daVisita_10_8').focus();
                                                }
                                                msgBox('Debe indicar la hora marcada en el citatorio para segunda visita',respHora2da_10_8);
                                                return false;
                                            }
                                        	
                                            
                                            if(gEx('txtPersona_10_8').getValue()=='')
                                            {
                                            	function respPersona2da_10_8()
                                                {
                                                	gEx('panelDomicilio_10_8').setActiveTab(0);
                                                	gEx('txtPersona_10_8').focus();
                                                }
                                                msgBox('Debe indicar el nombre de la persona que recibi&oacute; el citatorio',respPersona2da_10_8);
                                                return false;
                                            }
                                            
                                            if(gEx('txtRelacion_10_8').getValue()=='')
                                            {
                                            	function respRelacion2da_10_8()
                                                {
                                                	gEx('panelDomicilio_10_8').setActiveTab(0);
                                                	gEx('txtRelacion_10_8').focus();
                                                }
                                                msgBox('Debe indicar la relaci&oacute;/cargo que tiene persona que recibi&oacute; el citatorio con el destinatario',respRelacion2da_10_8);
                                                return false;
                                            }
                                            
                                            if(gEx('txtLugarFijoCitatorio_10_8').getValue()=='')
                                            {
                                            	function respFijoCitatorio2da_10_8()
                                                {
                                                	gEx('panelDomicilio_10_8').setActiveTab(0);
                                                	gEx('txtLugarFijoCitatorio_10_8').focus();
                                                }
                                                msgBox('Debe indicar el lugar en el cual se fij&oacute; el citatorio',respFijoCitatorio2da_10_8);
                                                return false;
                                            }
                                                                    
                                            
                                            if(mostrarInfoOficina)
                                            {
                                            	 if(gEx('txtDomicilio_10_8').getValue()=='')
                                                {
                                                    function respDomicilio_10_8()
                                                    {
                                                    	gEx('panelDomicilio_10_8').setActiveTab(0);
                                                        gEx('txtDomicilio_10_8').focus();
                                                    }
                                                    msgBox('Debe indicar a qu&eacute; corresponde el domicilio sobre el cual se hizo la diligencia',respDomicilio_10_8);
                                                    return false;
                                                }
                                            }
                                            
                                        }
                                        
                                        if(gEx('cmbResultado2daDiligencia_10_8').getValue()!="")
                                        {
                                        	switch(gEx('cmbResultado2daDiligencia_10_8').getValue())
                                            {
                                            	
                                            	case '1':
                                                	
                                                        if(gEx('cmbIdentificacion2daVisita_10_8').getValue()=='')
                                                        {
                                                            function respIdentificacion2daVisita_12()
                                                            {
                                                            	gEx('p2daVisita').setActiveTab(1);
                                                                gEx('cmbIdentificacion2daVisita_10_8').focus();
                                                            }
                                                            msgBox('Debe indicar la identificaci&oacute;n presentada durante la diligencia',respIdentificacion2daVisita_12);
                                                            return false;
                                                        }
                                                        
                                                        if((gEx('cmbIdentificacion2daVisita_10_8').getValue()=='99')&&(gEx('cmbIdentificacion2daVisita_10_8').getValue()==''))
                                                        {
                                                            function respEspIdentificacion2daVisita_12()
                                                            {
                                                                gEx('p2daVisita').setActiveTab(1);
                                                                gEx('txtEspecifique2daVisita_10_8').focus();
                                                            }
                                                            msgBox('Debe indicar la identificaci&oacute;n presentada durante la diligencia',respEspIdentificacion2daVisita_12);
                                                            return false;
                                                        }
                                                    
                                                break;
                                                case '2':
                                                	if(gEx('txtPersona2daVisitaNotificacion_10_8').getValue()=='')
                                                    {
                                                        function respPersona2daVisita_12()
                                                        {
                                                            gEx('p2daVisita').setActiveTab(1);
                                                            gEx('txtPersona2daVisitaNotificacion_10_8').focus();
                                                        }
                                                        msgBox('Debe indicar el nombre de la persona que recibe la notificaci&oacute;n',respPersona2daVisita_12);
                                                        return false;
                                                    }
                                                    
                                                    if(gEx('txtRelacion2daVisitaNotificacion_10_8').getValue()=='')
                                                    {
                                                        function respPersonaRelacion2daVisita_12()
                                                        {
                                                            gEx('p2daVisita').setActiveTab(1);
                                                            gEx('txtRelacion2daVisitaNotificacion_10_8').focus();
                                                        }
                                                        msgBox('Debe indicar el cargo/relaci&oacute;n de la persona que recibe la notificaci&oacute;n',respPersonaRelacion2daVisita_12);
                                                        return false;
                                                    }
                                                break;
                                                case '3':
                                                	if(gEx('txtLugarFijaCitatorio_10_8').getValue()=='')
                                                    {
                                                        function respLugarFijaCitatorio2daVisita_12()
                                                        {
                                                            gEx('p2daVisita').setActiveTab(1);
                                                            gEx('txtLugarFijaCitatorio_10_8').focus();
                                                        }
                                                        msgBox('Debe indicar el lugar en donde se fija la notificaci&oacute;n',respLugarFijaCitatorio2daVisita_12);
                                                        return false;
                                                    }
                                                break;
                                            }
                                        }
                                        else
                                        {
                                        	if(gEx('cmbResultadoDiligencia_10_8').getValue()!='1')
	                                        	generaExposicion=false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
										var tipoDomilio='';
                                        var lblDomicilio='';
                                        var txtCalle=gEx('txtCalle');
                                        var txtNoExt=gEx('txtNoExt');
                                        var txtNoInt=gEx('txtNoInt');
                                        var txtColonia=gEx('txtColonia');
                                        var txtCP=gEx('txtCP');
                                        var txtLocalidad=gEx('txtLocalidad');
                                        var cmbEstado=gEx('cmbEstado');
                                        var cmbMunicipio=gEx('cmbMunicipio');
                                        
                                        lblDomicilio=txtCalle.getValue();
                                        
                                        if(txtNoExt.getValue()!='')
                                        {
                                        	tokenNumero='';
                                            if(gEx('txtNoInt').getValue()=='')
                                            	tokenNumero='# '+txtNoExt.getValue();
                                            else
                                            	tokenNumero='No. Ext. '+txtNoExt.getValue();
                                        	if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+=' '+tokenNumero;
                                        }
                                        
                                        if(txtNoInt.getValue()!='')
                                        {
                                        	tokenNumero='No. Int. '+txtNoExt.getValue();
                                            
                                            if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+=' '+tokenNumero;
                                        }
                                        
                                        if(txtColonia.getValue()!='')
                                        {
                                        	tokenNumero='Colonia '+txtNoExt.getValue();
                                            
                                            if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+=' '+tokenNumero;
                                        }
                                        
                                        if(txtCP.getValue()!='')
                                        {
                                        	tokenNumero='C.P. '+txtNoExt.getValue();
                                            
                                            if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+=' '+tokenNumero;
                                        }
                                        
                                        if(cmbMunicipio.getValue()!='')
                                        {
                                        	tokenNumero=cmbMunicipio.getRawValue();
                                            
                                            if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+='. '+tokenNumero;
                                        }
                                        
                                        if(cmbEstado.getValue()!='')
                                        {
                                        	tokenNumero=cmbEstado.getRawValue();
                                            
                                            if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+=', '+tokenNumero;
                                        }
                                        var dia2daVisita='';
                                        var mes2daVisita='';
                                        var anio2daVisita='';
                                        var fecha2daVisita='';
                                        if(gEx('txtFechadaVisita_10_8').getValue()!='')
                                        {
                                        	fecha2daVisita=gEx('txtFechadaVisita_10_8').getValue().format('Y-m-d');
                                            dia2daVisita=gEx('txtFechadaVisita_10_8').getValue().format('d');
                                            mes2daVisita=gEx('txtFechadaVisita_10_8').getValue().format('m');
                                            mes2daVisita=arrMeses[parseInt(mes2daVisita)-1][1];
                                            anio2daVisita=gEx('txtFechadaVisita_10_8').getValue().format('Y');
                                        }
                                        
                                        var citatorio=0;
                                        if(gEx('cmbResultadoDiligencia_10_8').getValue()=='2')
                                        {
                                        	citatorio=1;
                                        }
                                        
                                        
                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_10_8').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_10_8').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_10_8').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_10_8').getValue()+'","tipoDomilio":"'+cv(gEx('txtDomicilio_10_8').getValue())+
                                                    '","lblDomicilio":"'+cv(lblDomicilio)+
                                                    '","tipoIdentificacion":"'+gEx('cmbIdentificacion_10_8').getValue()+'","lblTipoIdentificacion":"'+
                                                    cv(gEx('cmbIdentificacion_10_8').getValue()==99?gEx('txtEspecifique_10_8').getValue():
                                                    gEx('cmbIdentificacion_10_8').getRawValue())+'","fecha2daVisita":"'+ fecha2daVisita+                                            
                                                    '","hora2daVisita":"'+gEx('cmbHora2daVisita_10_8').getValue()+'","dia2daVisita":"'+dia2daVisita+
                                                    '","mes2daVisita":"'+mes2daVisita+'","anio2daVisita":"'+anio2daVisita+
                                                    '","personaCitatorio":"'+cv(gEx('txtPersona_10_8').getValue())+
                                                    '","relacionPersonaCitatorio":"'+cv(gEx('txtRelacion_10_8').getValue())+
                                                    '","lugarFijoCitatorio":"'+cv(gEx('txtLugarFijoCitatorio_10_8').getValue())+'","personaCitatorio":"'+cv(gEx('txtPersona_10_8').getValue())+
                                                    '","relacionPersonaCitatorio":"'+cv(gEx('txtRelacion_10_8').getValue())+
                                                    '","personaRecibe2daVisita":"'+cv(gEx('txtPersona2daVisitaNotificacion_10_8').getValue())+
                                                    '","relacionPersona2daVisita":"'+cv(gEx('txtRelacion2daVisitaNotificacion_10_8').getValue())+
                                                    '","tipoIdentificacion2daVisita":"'+gEx('cmbIdentificacion2daVisita_10_8').getValue()+
                                                    '","lblTipoIdentificacion2daVisita":"'+cv(gEx('cmbIdentificacion2daVisita_10_8').getValue()==99?gEx('txtEspecifique2daVisita_10_8').getValue():
                                                    gEx('cmbIdentificacion2daVisita_10_8').getRawValue())+'","lugarFijoCitatorio2daVisita":"'+
                                                    cv(gEx('txtLugarFijaCitatorio_10_8').getValue())+'","resultado2daVisita":"'+
                                                    gEx('cmbResultado2daDiligencia_10_8').getValue()+'","resultadoDiligencia":"'+
                                                    gEx('cmbResultadoDiligencia_10_8').getValue()+'","citatorio":"'+citatorio+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var citatorio=0;
                                        if(gEx('cmbResultadoDiligencia_10_8').getValue()=='2')
                                        {
                                        	citatorio=1;
                                        }
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_10_8').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_10_8').getValue()+
                                                    '","resultado":"1","citatorio":"'+citatorio+'","tipoDomilio":"'+gEx('txtDomicilio_10_8').getValue()+
                                                    '","tipoIdentificacion":"'+cv(gEx('cmbIdentificacion_10_8').getValue())+
                                                    '","especifiqueTipoIdentificacion":"'+cv(gEx('txtEspecifique_10_8').getValue())+
                                                    '","resultadoDiligencia":"'+gEx('cmbResultadoDiligencia_10_8').getValue()+'","fecha2daVisita":"'+
                                                    (gEx('txtFechadaVisita_10_8').getValue()==''?'':gEx('txtFechadaVisita_10_8').getValue().format('Y-m-d'))+
                                                    '","hora2daVisita":"'+gEx('cmbHora2daVisita_10_8').getValue()+
                                                    '","personaCitatorio":"'+cv(gEx('txtPersona_10_8').getValue())+
                                                    '","relacionPersonaCitatorio":"'+cv(gEx('txtRelacion_10_8').getValue())+
                                                    '","lugarFijoCitatorio":"'+cv(gEx('txtLugarFijoCitatorio_10_8').getValue())+
                                                    '","personaRecibe2daVisita":"'+cv(gEx('txtPersona2daVisitaNotificacion_10_8').getValue())+
                                                    '","relacionPersona2daVisita":"'+cv(gEx('txtRelacion2daVisitaNotificacion_10_8').getValue())+
                                                    '","tipoIdentificacion2daVisita":"'+gEx('cmbIdentificacion2daVisita_10_8').getValue()+
                                                    '","lblTipoIdentificacion2daVisita":"'+cv(gEx('cmbIdentificacion2daVisita_10_8').getValue()==99?gEx('txtEspecifique2daVisita_10_8').getValue():
                                                    gEx('cmbIdentificacion2daVisita_10_8').getRawValue())+'","lugarFijoCitatorio2daVisita":"'+
                                                    cv(gEx('txtLugarFijaCitatorio_10_8').getValue())+'","resultado2daVisita":"'+gEx('cmbResultado2daDiligencia_10_8').getValue()+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_10_8').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_10_8').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbResultadoDiligencia_10_8').setValue(oEdicion.resultadoDiligencia);
                                                            gEx('txtDomicilio_10_8').setValue(oEdicion.tipoDomilio);
                                                            gEx('cmbIdentificacion_10_8').setValue(oEdicion.resultadoDiligencia);
                                                            gEx('txtEspecifique_10_8').setValue(oEdicion.especifiqueTipoIdentificacion);
                                                            dispararEventoSelectCombo('cmbResultadoDiligencia_10_8');
                                                            dispararEventoSelectCombo('cmbIdentificacion_10_8');
                                                            gEx('txtFechadaVisita_10_8').setValue(oEdicion.fecha2daVisita);
                                                            gEx('cmbHora2daVisita_10_8').setValue(oEdicion.hora2daVisita);
                                                            gEx('txtPersona_10_8').setValue(oEdicion.personaCitatorio);
                                                            gEx('txtRelacion_10_8').setValue(oEdicion.relacionPersonaCitatorio);
                                                            gEx('txtLugarFijoCitatorio_10_8').setValue(oEdicion.lugarFijoCitatorio);
                                                            gEx('cmbResultado2daDiligencia_10_8').setValue(oEdicion.resultado2daVisita);
                                                            dispararEventoSelectCombo('cmbResultado2daDiligencia_10_8');
                                                            gEx('txtPersona2daVisitaNotificacion_10_8').setValue(oEdicion.personaRecibe2daVisita);
                                                            gEx('txtRelacion2daVisitaNotificacion_10_8').setValue(oEdicion.relacionPersona2daVisita);
                                                            gEx('cmbIdentificacion2daVisita_10_8').setValue(oEdicion.tipoIdentificacion2daVisita);
                                                            gEx('txtEspecifique2daVisita_10_8').setValue(oEdicion.lblTipoIdentificacion2daVisita);
                                                            gEx('txtLugarFijaCitatorio_10_8').setValue(oEdicion.lugarFijoCitatorio2daVisita);
                                                            
                                                           

                                                        }                                             

    //---1---
    
    
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_1',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	gEx('panelDomicilio_1').setActiveTab(0);
                                                                    	if((gEx('cmbDetalleFigura').getValue()=='1')||(nodoSujetoSel.attributes.personaJuridica=='10'))
                                                                        {
                                                                        	if(gEx('cmbDetalleFigura').getValue()=='1')	
                                                                            {
                                                                            	switch(nodoSujetoSel.attributes.personaJuridica)
                                                                                {
                                                                                	case '3':
                                                                                    	gE('lblTipoOficinaLey_1').innerHTML=' de la Coordinación de Asesores Jurídicos Públicos de la Procuraduría General de la Ciudad de México';
                                                                                    break;
                                                                                    case '5':
                                                                                    	gE('lblTipoOficinaLey_1').innerHTML='  de la Defensoría Pública de la Ciudad de México';
                                                                                    break;
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                            	gE('lblTipoOficinaLey_1').innerHTML=' de la Procuraduría General de Justicia de la Ciudad de México';
                                                                            }
                                                                            mostrarInfoOficina=true;
                                                                            
                                                                        }
                                                                        
                                                                    
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                            var oDiligencia=eval('['+bD(fila.data.objDiligencia)+']')[0];
																			
                                                                            if(fila.data.enviadoCentralNotificadores=='1')
                                                                            {
                                                                            	gEx('btnEnviarCentral').hide();
                                                                            }
                                                                        }
                                                                        
                                                                        
                                                                       
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                            	xtype:'tabpanel',
                                                                width:600,
                                                                y:-2,
                                                                height:255,
                                                                activeTab:1,
                                                                id:'panelDomicilio_1',
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                id:'p1raVisita_1',
                                                                                bodyStyle:{"background-color":"#F5F5F5","font-size":"11px"}, 
                                                                                title:'Notificaci&oacute;n general',
                                                                                layout:'absolute',
                                                                                items:	[
                                                                                			{
                                                                                                x:10,
                                                                                                y:10,
                                                                                                xtype:'label',
                                                                                                html:'Fecha de la diligencia:'
                                                                                            },
                                                                                            {
                                                                                                x:150,
                                                                                                y:5,
                                                                                                xtype:'datefield',
                                                                                                id:'fecha_1',
                                                                                                value:'<?php echo date("Y-m-d")?>'
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:40,
                                                                                                xtype:'label',
                                                                                                html:'Hora de la diligencia:'
                                                                                            },
                                                                                            
                                                                                            cmbHora_1,
                                                                                            {
                                                                                            	x:340,
                                                                                                y:30,
                                                                                                xtype:'button',
                                                                                                id:'btnEnviarCentral_1',
                                                                                                icon:'../images/user_go.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Enviar a central de notificadores',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	
                                                                                                        	function resp(btn)
                                                                                                            {
                                                                                                            	if(btn=='yes')
                                                                                                                {
                                                                                                                	gEx('cmbResultadoDiligencia_1').setValue('3');
                                                                                                                	guardarDiligencia(true);
                                                                                                                }
                                                                                                            }
                                                                                                            msgConfirm('Est&aacute; seguro de querer enviar a central de notificadores la tarea de notificaci&oacute;n?',resp);
                                                                                                        	
                                                                                                            
                                                                                                        
                                                                                                        
                                                                                                        	
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            ,
                                                                                            {
                                                                                                x:10,
                                                                                                y:70,
                                                                                                xtype:'label',
                                                                                                html:'Resultado de la diligencia:'
                                                                                            },
                                                                                            cmbResultadoDiligencia_1,
                                                                                            {
                                                                                                x:10,
                                                                                                y:100,
                                                                                                hidden:true,
                                                                                                id:'lblTipoIdentificacion_1',
                                                                                                xtype:'label',
                                                                                                html:'Tipo de identificaci&oacute;n presentada:'
                                
                                                                                                
                                                                                            },
                                                                                            cmbIdentificacion_1,
                                                                                            {
                                                                                                x:10,
                                                                                                y:130,
                                                                                                id:'lblEspecifique_1',
                                                                                                hidden:true,
                                                                                                xtype:'label',
                                                                                                html:'Especifique:'
                                
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                xtype:'textfield',
                                                                                                x:150,
                                                                                                y:125,
                                                                                                hidden:true,
                                                                                                id:'txtEspecifique_1',
                                                                                                widht:300
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:160,
                                                                                                hidden:true,
                                                                                                id:'lblFecha2daVisita_1',
                                                                                                xtype:'label',
                                                                                                html:'Fecha/hora de pr&oacute;xima visita:'
                                                                                            },
                                                                                            
                                                                                            {
                                                                                            	x:200,
                                                                                                y:155,
                                                                                                hidden:true,
                                                                                                id:'txtFechadaVisita_1',
                                                                                                xtype:'datefield'
                                                                                            },
                                                                                            cmbHora2daVisita_1,
                                                                                            {
                                                                                                x:10,
                                                                                                y:188,
                                                                                                hidden:true,
                                                                                                id:'lblLugarCitatorio_1',
                                                                                                xtype:'label',
                                                                                                html:'Se fij&oacute; citatorio en:'
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:183,
                                                                                                hidden:true,
                                                                                                xtype:'textfield',
                                                                                                width:300,
                                                                                                id:'txtLugarFijoCitatorio_1'
                                                                                            },
                                                                                             {
                                                                                                x:10,
                                                                                                y:100,
                                                                                                hidden:true,
                                                                                                id:'lblPersona2daVisita_1',
                                                                                                xtype:'label',
                                                                                                html:'Persona que recibi&oacute; citatorio:'
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:95,
                                                                                                xtype:'textfield',
                                                                                                width:230,
                                                                                                hidden:true,
                                                                                                id:'txtPersona_1'
                                                                                            },
                                                                                             {
                                                                                                x:10,
                                                                                                y:130,
                                                                                                hidden:true,
                                                                                                id:'lblRelacion_1',
                                                                                                xtype:'label',
                                                                                                html:'Relaci&oacute;n / Cargo:'
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:125,
                                                                                                xtype:'textfield',
                                                                                                width:250,
                                                                                                hidden:true,
                                                                                                id:'txtRelacion_1'
                                                                                            },
                                                                                            
                                                                                            {
                                                                                                x:10,
                                                                                                y:216,
                                                                                                hidden:true,
                                                                                                id:'lblDomicioOficina_1',
                                                                                                xtype:'label',
                                                                                                html:'El domicilio corresponda a las oficinas de:'
                                                                                            },
                                                                                            {
                                                                                            	x:250,
                                                                                                y:211,
                                                                                                hidden:true,
                                                                                                xtype:'textfield',
                                                                                                width:320,
                                                                                                id:'txtDomicilio_1'
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:235,
                                                                                                hidden:true,
                                                                                                id:'lblTipoOficina_1',
                                                                                                xtype:'label',
                                                                                                html:'<span id="lblTipoOficinaLey_1"></span>'
                                                                                            }
                                                                                		]
                                                                            },
                                                                            {
                                                                            	xtype:'panel',
                                                                                id:'p2daVisita_1',
                                                                                bodyStyle:{"background-color":"#F5F5F5","font-size":"11px"}, 
                                                                                title:'Resultado segunda visita',
                                                                                disabled:true,
                                                                                layout:'absolute',
                                                                                items:	[
                                                                                			{
                                                                                            	x:10,
                                                                                                y:10,
                                                                                                xtype:'label',
                                                                                                html:'Resultado de la diligencia:'
                                                                                            },
                                                                                            cmbResultado2daDiligencia_1,
                                                                                            {
                                                                                                x:10,
                                                                                                y:40,
                                                                                                hidden:true,
                                                                                                id:'lblPersona2daVisitaNotificacion_1',
                                                                                                xtype:'label',
                                                                                                html:'Persona que recibi&oacute; notificaci&oacute;n:'
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:35,
                                                                                                xtype:'textfield',
                                                                                                width:230,
                                                                                                hidden:true,
                                                                                                id:'txtPersona2daVisitaNotificacion_1'
                                                                                            },
                                                                                             {
                                                                                                x:10,
                                                                                                y:70,
                                                                                                hidden:true,
                                                                                                id:'lblRelacion2daVisitaNotificacion_1',
                                                                                                xtype:'label',
                                                                                                html:'Relaci&oacute;n / Cargo:'
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:65,
                                                                                                xtype:'textfield',
                                                                                                width:250,
                                                                                                hidden:true,
                                                                                                id:'txtRelacion2daVisitaNotificacion_1'
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:40,
                                                                                                hidden:true,
                                                                                                id:'lblTipoIdentificacion2daVisita_1',
                                                                                                xtype:'label',
                                                                                                html:'Tipo de identificaci&oacute;n presentada:'
                                
                                                                                                
                                                                                            },
                                                                                            cmbIdentificacion2daVisita_1,
                                                                                            {
                                                                                                x:10,
                                                                                                y:70,
                                                                                                id:'lblEspecifique2daVisita_1',
                                                                                                hidden:true,
                                                                                                xtype:'label',
                                                                                                html:'Especifique:'
                                
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                xtype:'textfield',
                                                                                                x:130,
                                                                                                y:65,
                                                                                                hidden:true,
                                                                                                id:'txtEspecifique2daVisita_1',
                                                                                                widht:350
                                                                                            },
                                                                                            {
                                                                                                x:10,
                                                                                                y:40,
                                                                                                hidden:true,
                                                                                                id:'lblLugarFijo2daVisita_1',
                                                                                                xtype:'label',
                                                                                                html:'Lugar donde se fija la notificaci&oacute;n:'
                                
                                                                                                
                                                                                            },
                                                                                            {
                                                                                            	x:200,
                                                                                                y:35,
                                                                                                xtype:'textfield',
                                                                                                hidden:true,
                                                                                                id:'txtLugarFijaCitatorio_1',
                                                                                                width:350
                                                                                            }
                                                                                		]
                                                                            }
                                                                		]
                                                            }
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_1').getValue()=='')
                                        {
                                        	function resp_1()
                                            {
                                            	gEx('panelDomicilio_1').setActiveTab(0);
                                            	gEx('fecha_1').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_1);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_1').getValue()=='')
                                        {
                                        	function resp2_1()
											{
                                            	gEx('panelDomicilio_1').setActiveTab(0);
                                            	gEx('cmbHora_1').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_1);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbResultadoDiligencia_1').getValue()=='')
                                        {
                                        	function respResultado2_1()
                                            {
                                            	gEx('panelDomicilio_1').setActiveTab(0);
                                            	gEx('cmbResultadoDiligencia_1').focus();
                                            }
                                            msgBox('Debe indicar el resultado de la diligencia',respResultado2_1);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbResultadoDiligencia_1').getValue()=='1')
                                        {
                                        	generaExposicion=true;
                                            if(gEx('cmbIdentificacion_1').getValue()=='')
                                            {
                                                function respIdentificacion_1()
                                                {
                                                	gEx('panelDomicilio_1').setActiveTab(0);
                                                    gEx('cmbIdentificacion_1').focus();
                                                }
                                                msgBox('Debe indicar la identificaci&oacute;n presentada durante la diligencia',respIdentificacion_1);
                                                return false;
                                            }
                                            
                                            if((gEx('cmbIdentificacion_1').getValue()=='99')&&(gEx('txtEspecifique_1').getValue()==''))
                                            {
                                                function respEspIdentificacion_1()
                                                {
                                                	gEx('panelDomicilio_1').setActiveTab(0);
                                                    gEx('txtEspecifique_1').focus();
                                                }
                                                msgBox('Debe indicar la identificaci&oacute;n presentada durante la diligencia',respEspIdentificacion_1);
                                                return false;
                                            }
                                            
                                            if(mostrarInfoOficina)
                                            {
                                            	 if(gEx('txtDomicilio_1').getValue()=='')
                                                {
                                                    function respDomicilio_1()
                                                    {
                                                    	gEx('panelDomicilio_1').setActiveTab(0);
                                                        gEx('txtDomicilio_1').focus();
                                                    }
                                                    msgBox('Debe indicar a qu&eacute; corresponde el domicilio sobre el cual se hizo la diligencia',respDomicilio_1);
                                                    return false;
                                                }
                                            }
                                            
                                        }
                                        
                                        if(gEx('cmbResultadoDiligencia_1').getValue()=='2')
                                        {
                                        	if(gEx('txtFechadaVisita_1').getValue()=='')
                                            {
                                            	function respFecha2da_1()
                                                {
                                                	gEx('panelDomicilio_1').setActiveTab(0);
                                                	gEx('txtFechadaVisita_1').focus();
                                                }
                                                msgBox('Debe indicar la fecha marcada en el citatorio para segunda visita',respFecha2da_1);
                                                return false;
                                            }
                                            
                                            if(gEx('cmbHora2daVisita_1').getValue()=='')
                                            {
                                            	function respHora2da_1()
                                                {
                                                	gEx('panelDomicilio_1').setActiveTab(0);
                                                	gEx('cmbHora2daVisita_1').focus();
                                                }
                                                msgBox('Debe indicar la hora marcada en el citatorio para segunda visita',respHora2da_1);
                                                return false;
                                            }
                                        	
                                            
                                            if(gEx('txtPersona_1').getValue()=='')
                                            {
                                            	function respPersona2da_1()
                                                {
                                                	gEx('panelDomicilio_1').setActiveTab(0);
                                                	gEx('txtPersona_1').focus();
                                                }
                                                msgBox('Debe indicar el nombre de la persona que recibi&oacute; el citatorio',respPersona2da_1);
                                                return false;
                                            }
                                            
                                            if(gEx('txtRelacion_1').getValue()=='')
                                            {
                                            	function respRelacion2da_1()
                                                {
                                                	gEx('panelDomicilio_1').setActiveTab(0);
                                                	gEx('txtRelacion_1').focus();
                                                }
                                                msgBox('Debe indicar la relaci&oacute;/cargo que tiene persona que recibi&oacute; el citatorio con el destinatario',respRelacion2da_1);
                                                return false;
                                            }
                                            
                                            if(gEx('txtLugarFijoCitatorio_1').getValue()=='')
                                            {
                                            	function respFijoCitatorio2da_1()
                                                {
                                                	gEx('panelDomicilio_1').setActiveTab(0);
                                                	gEx('txtLugarFijoCitatorio_1').focus();
                                                }
                                                msgBox('Debe indicar el lugar en el cual se fij&oacute; el citatorio',respFijoCitatorio2da_1);
                                                return false;
                                            }
                                                                    
                                            
                                            if(mostrarInfoOficina)
                                            {
                                            	 if(gEx('txtDomicilio_1').getValue()=='')
                                                {
                                                    function respDomicilio_1()
                                                    {
                                                    	gEx('panelDomicilio_1').setActiveTab(0);
                                                        gEx('txtDomicilio_1').focus();
                                                    }
                                                    msgBox('Debe indicar a qu&eacute; corresponde el domicilio sobre el cual se hizo la diligencia',respDomicilio_1);
                                                    return false;
                                                }
                                            }
                                            
                                        }
                                        
                                        if(gEx('cmbResultado2daDiligencia_1').getValue()!="")
                                        {
                                        	switch(gEx('cmbResultado2daDiligencia_1').getValue())
                                            {
                                            	
                                            	case '1':
                                                	
                                                        if(gEx('cmbIdentificacion2daVisita_1').getValue()=='')
                                                        {
                                                            function respIdentificacion2daVisita_12()
                                                            {
                                                            	gEx('p2daVisita').setActiveTab(1);
                                                                gEx('cmbIdentificacion2daVisita_1').focus();
                                                            }
                                                            msgBox('Debe indicar la identificaci&oacute;n presentada durante la diligencia',respIdentificacion2daVisita_12);
                                                            return false;
                                                        }
                                                        
                                                        if((gEx('cmbIdentificacion2daVisita_1').getValue()=='99')&&(gEx('cmbIdentificacion2daVisita_1').getValue()==''))
                                                        {
                                                            function respEspIdentificacion2daVisita_12()
                                                            {
                                                                gEx('p2daVisita_1').setActiveTab(1);
                                                                gEx('txtEspecifique2daVisita_1').focus();
                                                            }
                                                            msgBox('Debe indicar la identificaci&oacute;n presentada durante la diligencia',respEspIdentificacion2daVisita_12);
                                                            return false;
                                                        }
                                                    
                                                break;
                                                case '2':
                                                	if(gEx('txtPersona2daVisitaNotificacion_1').getValue()=='')
                                                    {
                                                        function respPersona2daVisita_12()
                                                        {
                                                            gEx('p2daVisita_1').setActiveTab(1);
                                                            gEx('txtPersona2daVisitaNotificacion_1').focus();
                                                        }
                                                        msgBox('Debe indicar el nombre de la persona que recibe la notificaci&oacute;n',respPersona2daVisita_12);
                                                        return false;
                                                    }
                                                    
                                                    if(gEx('txtRelacion2daVisitaNotificacion_1').getValue()=='')
                                                    {
                                                        function respPersonaRelacion2daVisita_12()
                                                        {
                                                            gEx('p2daVisita_1').setActiveTab(1);
                                                            gEx('txtRelacion2daVisitaNotificacion_1').focus();
                                                        }
                                                        msgBox('Debe indicar el cargo/relaci&oacute;n de la persona que recibe la notificaci&oacute;n',respPersonaRelacion2daVisita_12);
                                                        return false;
                                                    }
                                                break;
                                                case '3':
                                                	if(gEx('txtLugarFijaCitatorio_1').getValue()=='')
                                                    {
                                                        function respLugarFijaCitatorio2daVisita_12()
                                                        {
                                                            gEx('p2daVisita_1').setActiveTab(1);
                                                            gEx('txtLugarFijaCitatorio_1').focus();
                                                        }
                                                        msgBox('Debe indicar el lugar en donde se fija la notificaci&oacute;n',respLugarFijaCitatorio2daVisita_12);
                                                        return false;
                                                    }
                                                break;
                                            }
                                        }
                                        else
                                        {
                                        	if(gEx('cmbResultadoDiligencia_1').getValue()!='1')
	                                        	generaExposicion=false;
                                        }
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
										var tipoDomilio='';
                                        var lblDomicilio='';
                                        var txtCalle=gEx('txtCalle');
                                        var txtNoExt=gEx('txtNoExt');
                                        var txtNoInt=gEx('txtNoInt');
                                        var txtColonia=gEx('txtColonia');
                                        var txtCP=gEx('txtCP');
                                        var txtLocalidad=gEx('txtLocalidad');
                                        var cmbEstado=gEx('cmbEstado');
                                        var cmbMunicipio=gEx('cmbMunicipio');
                                        
                                        lblDomicilio=txtCalle.getValue();
                                        
                                        if(txtNoExt.getValue()!='')
                                        {
                                        	tokenNumero='';
                                            if(gEx('txtNoInt').getValue()=='')
                                            	tokenNumero='# '+txtNoExt.getValue();
                                            else
                                            	tokenNumero='No. Ext. '+txtNoExt.getValue();
                                        	if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+=' '+tokenNumero;
                                        }
                                        
                                        if(txtNoInt.getValue()!='')
                                        {
                                        	tokenNumero='No. Int. '+txtNoExt.getValue();
                                            
                                            if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+=' '+tokenNumero;
                                        }
                                        
                                        if(txtColonia.getValue()!='')
                                        {
                                        	tokenNumero='Colonia '+txtNoExt.getValue();
                                            
                                            if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+=' '+tokenNumero;
                                        }
                                        
                                        if(txtCP.getValue()!='')
                                        {
                                        	tokenNumero='C.P. '+txtNoExt.getValue();
                                            
                                            if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+=' '+tokenNumero;
                                        }
                                        
                                        if(cmbMunicipio.getValue()!='')
                                        {
                                        	tokenNumero=cmbMunicipio.getRawValue();
                                            
                                            if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+='. '+tokenNumero;
                                        }
                                        
                                        if(cmbEstado.getValue()!='')
                                        {
                                        	tokenNumero=cmbEstado.getRawValue();
                                            
                                            if(lblDomicilio=='')
                                            	lblDomicilio+=tokenNumero;
                                            else
                                            	lblDomicilio+=', '+tokenNumero;
                                        }
                                        var dia2daVisita='';
                                        var mes2daVisita='';
                                        var anio2daVisita='';
                                        var fecha2daVisita='';
                                        if(gEx('txtFechadaVisita_1').getValue()!='')
                                        {
                                        	fecha2daVisita=gEx('txtFechadaVisita_1').getValue().format('Y-m-d');
                                            dia2daVisita=gEx('txtFechadaVisita_1').getValue().format('d');
                                            mes2daVisita=gEx('txtFechadaVisita_1').getValue().format('m');
                                            mes2daVisita=arrMeses[parseInt(mes2daVisita)-1][1];
                                            anio2daVisita=gEx('txtFechadaVisita_1').getValue().format('Y');
                                        }
                                        
                                        var citatorio=0;
                                        if(gEx('cmbResultadoDiligencia_1').getValue()=='2')
                                        {
                                        	citatorio=1;
                                        }
                                        
                                        
                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_1').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_1').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_1').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_1').getValue()+'","tipoDomilio":"'+cv(gEx('txtDomicilio_1').getValue())+
                                                    '","lblDomicilio":"'+cv(lblDomicilio)+
                                                    '","tipoIdentificacion":"'+gEx('cmbIdentificacion_1').getValue()+'","lblTipoIdentificacion":"'+
                                                    cv(gEx('cmbIdentificacion_1').getValue()==99?gEx('txtEspecifique_1').getValue():
                                                    gEx('cmbIdentificacion_1').getRawValue())+'","fecha2daVisita":"'+ fecha2daVisita+                                            
                                                    '","hora2daVisita":"'+gEx('cmbHora2daVisita_1').getValue()+'","dia2daVisita":"'+dia2daVisita+
                                                    '","mes2daVisita":"'+mes2daVisita+'","anio2daVisita":"'+anio2daVisita+
                                                    '","personaCitatorio":"'+cv(gEx('txtPersona_1').getValue())+
                                                    '","relacionPersonaCitatorio":"'+cv(gEx('txtRelacion_1').getValue())+
                                                    '","lugarFijoCitatorio":"'+cv(gEx('txtLugarFijoCitatorio_1').getValue())+'","personaCitatorio":"'+cv(gEx('txtPersona_1').getValue())+
                                                    '","relacionPersonaCitatorio":"'+cv(gEx('txtRelacion_1').getValue())+
                                                    '","personaRecibe2daVisita":"'+cv(gEx('txtPersona2daVisitaNotificacion_1').getValue())+
                                                    '","relacionPersona2daVisita":"'+cv(gEx('txtRelacion2daVisitaNotificacion_1').getValue())+
                                                    '","tipoIdentificacion2daVisita":"'+gEx('cmbIdentificacion2daVisita_1').getValue()+
                                                    '","lblTipoIdentificacion2daVisita":"'+cv(gEx('cmbIdentificacion2daVisita_1').getValue()==99?gEx('txtEspecifique2daVisita_1').getValue():
                                                    gEx('cmbIdentificacion2daVisita_1').getRawValue())+'","lugarFijoCitatorio2daVisita":"'+
                                                    cv(gEx('txtLugarFijaCitatorio_1').getValue())+'","resultado2daVisita":"'+
                                                    gEx('cmbResultado2daDiligencia_1').getValue()+'","resultadoDiligencia":"'+
                                                    gEx('cmbResultadoDiligencia_1').getValue()+'","citatorio":"'+citatorio+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var citatorio=0;
                                        if(gEx('cmbResultadoDiligencia_1').getValue()=='2')
                                        {
                                        	citatorio=1;
                                        }
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_1').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_1').getValue()+
                                                    '","resultado":"1","citatorio":"'+citatorio+'","tipoDomilio":"'+gEx('txtDomicilio_1').getValue()+
                                                    '","tipoIdentificacion":"'+cv(gEx('cmbIdentificacion_1').getValue())+
                                                    '","especifiqueTipoIdentificacion":"'+cv(gEx('txtEspecifique_1').getValue())+
                                                    '","resultadoDiligencia":"'+gEx('cmbResultadoDiligencia_1').getValue()+'","fecha2daVisita":"'+
                                                    (gEx('txtFechadaVisita_1').getValue()==''?'':gEx('txtFechadaVisita_1').getValue().format('Y-m-d'))+
                                                    '","hora2daVisita":"'+gEx('cmbHora2daVisita_1').getValue()+
                                                    '","personaCitatorio":"'+cv(gEx('txtPersona_1').getValue())+
                                                    '","relacionPersonaCitatorio":"'+cv(gEx('txtRelacion_1').getValue())+
                                                    '","lugarFijoCitatorio":"'+cv(gEx('txtLugarFijoCitatorio_1').getValue())+
                                                    '","personaRecibe2daVisita":"'+cv(gEx('txtPersona2daVisitaNotificacion_1').getValue())+
                                                    '","relacionPersona2daVisita":"'+cv(gEx('txtRelacion2daVisitaNotificacion_1').getValue())+
                                                    '","tipoIdentificacion2daVisita":"'+gEx('cmbIdentificacion2daVisita_1').getValue()+
                                                    '","lblTipoIdentificacion2daVisita":"'+cv(gEx('cmbIdentificacion2daVisita_1').getValue()==99?gEx('txtEspecifique2daVisita_1').getValue():
                                                    gEx('cmbIdentificacion2daVisita_1').getRawValue())+'","lugarFijoCitatorio2daVisita":"'+
                                                    cv(gEx('txtLugarFijaCitatorio_1').getValue())+'","resultado2daVisita":"'+gEx('cmbResultado2daDiligencia_1').getValue()+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('fecha_1').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_1').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbResultadoDiligencia_1').setValue(oEdicion.resultadoDiligencia);
                                                            gEx('txtDomicilio_1').setValue(oEdicion.tipoDomilio);
                                                            gEx('cmbIdentificacion_1').setValue(oEdicion.resultadoDiligencia);
                                                            gEx('txtEspecifique_1').setValue(oEdicion.especifiqueTipoIdentificacion);
                                                            dispararEventoSelectCombo('cmbResultadoDiligencia_1');
                                                            dispararEventoSelectCombo('cmbIdentificacion_1');
                                                            gEx('txtFechadaVisita_1').setValue(oEdicion.fecha2daVisita);
                                                            gEx('cmbHora2daVisita_1').setValue(oEdicion.hora2daVisita);
                                                            gEx('txtPersona_1').setValue(oEdicion.personaCitatorio);
                                                            gEx('txtRelacion_1').setValue(oEdicion.relacionPersonaCitatorio);
                                                            gEx('txtLugarFijoCitatorio_1').setValue(oEdicion.lugarFijoCitatorio);
                                                            gEx('cmbResultado2daDiligencia_1').setValue(oEdicion.resultado2daVisita);
                                                            dispararEventoSelectCombo('cmbResultado2daDiligencia_1');
                                                            gEx('txtPersona2daVisitaNotificacion_1').setValue(oEdicion.personaRecibe2daVisita);
                                                            gEx('txtRelacion2daVisitaNotificacion_1').setValue(oEdicion.relacionPersona2daVisita);
                                                            gEx('cmbIdentificacion2daVisita_1').setValue(oEdicion.tipoIdentificacion2daVisita);
                                                            gEx('txtEspecifique2daVisita_1').setValue(oEdicion.lblTipoIdentificacion2daVisita);
                                                            gEx('txtLugarFijaCitatorio_1').setValue(oEdicion.lugarFijoCitatorio2daVisita);
                                                            
                                                           

                                                        }     
    
    
    
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_2_3',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                			{
                                                            	x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Audiencia que se notifica:'
                                                            },
                                                            cmbAudienciaNotifica_2_3,
                                                            crearGridSeguimientoTelefonico('2_3')
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	var cmbAudienciaNotifica_2_3=gEx('cmbAudienciaNotifica_2_3');
                                        
                                        if(gEx('cmbAudienciaNotifica_2_3').getValue()=='')
                                        {
                                        	function resp1_2_3()
                                            {
                                            	cmbAudienciaNotifica_2_3.focus();
                                            }
                                            msgBox('Debe indicar la audiencia que se notifica en la diligencia',resp1_2_3);
                                        	return false;
                                        }
                                        
                                    	var gSeguimiento=gEx('gSeguimiento_2_3');
                                        if(gSeguimiento.getStore().getCount()==0)
                                        {	
                                        	msgBox('Debe indicar almenos un registro de diligencia telef&oacute;nica');
                                        	return false;
                                        }
                                        
                                        var filaSeg=gSeguimiento.getStore().getAt(0);
                                        
                                        
										var pGenerar=true;
                                        
										if(filaSeg)
                                        {
                                        	if(filaSeg.data.situacion=='2')
                                            {
                                            	pGenerar=false;
                                            }
                                            else
                                            {
                                                var oDetalle=eval('['+bD(filaSeg.data.detalle)+']')[0];
                                                
                                                if(oDetalle.obtuvoRespuesta=='0')
                                                {
                                                    
                                                    switch(oDetalle.motivoNoRespuesta)
                                                    {
                                                        case '1': // NO contesto
                                                            if(oDetalle.programarLlamada=='1')
                                                            {
                                                                pGenerar=false;
                                                            }
                                                        break;
                                                        case '2': // No. no existe
                                                        break;
                                                        case '3':	//Otro
                                                            if(oDetalle.programarLlamada=='1')
                                                            {
                                                                pGenerar=false;
                                                            }
                                                        break;
                                                    }
                                                }
                                            }
                                        }

                                        if(!pGenerar)
                                        {
                                        	
											generaExposicion=false;
                                        	borrarDiligencia=true;	
                                        }
                                        else
                                        {
                                        	if(fila && fila.data.exposicionDiligencia.trim()=='')
                                            {
                                            	reprocesarDiligencia=true;
                                            }
                                        }
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
                                    	var gSeguimiento=gEx('gSeguimiento_2_3');
                                        var filaSeg=gSeguimiento.getStore().getAt(0);
                                        var pos=existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_2_3').getValue());
                                        fecha=Date.parseDate(arrAudienciasNotifica[pos][2],'Y-m-d');
                                        var hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                        var lblAudiencia=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y')
                                       	
                                        var motivoNoContacto='';
                                       	var detalle=eval('['+bD(filaSeg.data.detalle) +']')[0];
                                        
                                        if(detalle.obtuvoRespuesta=='1')
                                        {
                                        	motivoNoContacto=formatearValorRenderer(arrRespNotificacion1,detalle.respuestaObtenida);
                                        }
                                        else
                                        {
                                        	if(detalle.motivoNoRespuesta=='3')
                                            	motivoNoContacto=detalle.motivoNoRespuestaEspecifique;
                                            else
	                                        	motivoNoContacto=formatearValorRenderer(arrRespNotificacion2,detalle.motivoNoRespuesta);
                                        }
                                        
                                        
                                        
                                        
                                       
                                    	var cadObj=',"diaDiligencia":"'+filaSeg.data.fechaDiligencia.format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(filaSeg.data.fechaDiligencia.format('m'))-1][1]+
                                                    '","anioDiligencia":"'+filaSeg.data.fechaDiligencia.format('Y')+'","horaDiligencia":"'+
                                                    filaSeg.data.fechaDiligencia.format('H:i')+'","salaAudiencia":"'+parseInt(arrAudienciasNotifica[pos][5])+
                                                    '","fechaAudiencia":"'+lblAudiencia+'","horaAudiencia":"'+hora.format("H:i")+
                                                    '","resultadoLlamada":"'+ filaSeg.data.detalle+'","motivoNoContacto":"'+cv(motivoNoContacto,true,true)+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	
                                    	var arrSeguimientoTelefonico='';
                                        var gSeguimiento=gEx('gSeguimiento_2_3');
                                        var x;
                                        var fila;
                                        var oSeguimiento='';
                                        for(x=0;x<gSeguimiento.getStore().getCount();x++)
                                        {
                                        	fila=gSeguimiento.getStore().getAt(x);
                                            oSeguimiento='{"telefono":"'+fila.data.telefono+'","fechaDiligencia":"'+fila.data.fechaDiligencia.format('Y-m-d H:i')+
                                            			'","detalle":"'+fila.data.detalle+'","situacion":"'+fila.data.situacion+'"}';
                                           	if(arrSeguimientoTelefonico=='')
                                            	arrSeguimientoTelefonico=oSeguimiento;
                                            else
                                            	arrSeguimientoTelefonico+=','+oSeguimiento;
                                        }
                                        fila=gSeguimiento.getStore().getAt(0);
                                        var resultado=fila.data.situacion;
										var oDetalle=eval('['+bD(fila.data.detalle)+']')[0];
                                        var notificado=0;
                                        if((oDetalle.obtuvoRespuesta=='1')&&(oDetalle.respuestaObtenida=='1'))
                                        {
                                        	notificado=1;
                                        }
                                    	
                                    	var cadObj='{"fechaDiligencia":"'+fila.data.fechaDiligencia.format('Y-m-d')+
                                        			'","horaDiligencia":"'+fila.data.fechaDiligencia.format('H:i')+
                                                    '","resultado":"'+resultado+'","citatorio":"0","arrSeguimientoTelefonico":['+
                                                    arrSeguimientoTelefonico+'],"idAudienciaNotifica":"'+gEx('cmbAudienciaNotifica_2_3').getValue()+
                                                    '","notificado":"'+notificado+'"}';
                                       
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            
                                                            gEx('cmbAudienciaNotifica_2_3').setValue(oEdicion.idAudienciaNotifica);
                                                            var gSeguimiento=gEx('gSeguimiento_2_3');
                                                            var x;
                                                            var f;
                                                            var reg=crearRegistro	(
                                                            							[
                                                                                        	{name: 'telefono'},
                                                                                            {name: 'fechaDiligencia'},
                                                                                            {name:'detalle'},
                                                                                            {name: 'situacion'}
                                                                                        ]
                                                            						)
                                                            for(x=0;x<oEdicion.arrSeguimientoTelefonico.length;x++)
                                        					{
                                                            	f=oEdicion.arrSeguimientoTelefonico[x];
                                                            	r=new 	reg	(
                                                                				{
                                                                                	telefono:f.telefono,
                                                                                    fechaDiligencia:Date.parseDate(f.fechaDiligencia,'Y-m-d H:i'),
                                                                                    detalle:f.detalle,
                                                                                    situacion:f.situacion
                                                                                }
                                                                			)					
                                                            	gSeguimiento.getStore().add(r);
                                                            
                                                            }


                                                        }   
    
    
    
    
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_10_6_3',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                        
                                                                        if(gEx('cmbTipoDiligencia').getValue()=='1')
                                                                        {
                                                                            cmbAudienciaNotifica_10_6_3.hide();
                                                                            gEx('lblAudienciaNotifica_10_6_3').hide();
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                            cmbAudienciaNotifica_10_6_3.show();
                                                                            gEx('lblAudienciaNotifica_10_6_3').show();
                                                                            
                                                                        }
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                			{
                                                            	x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                id:'lblAudienciaNotifica_10_6_3',
                                                                html:'Audiencia que se notifica:'
                                                            },
                                                            cmbAudienciaNotifica_10_6_3,
                                                            crearGridSeguimientoTelefonico('10_6_3')
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	var cmbAudienciaNotifica_10_6_3=gEx('cmbAudienciaNotifica_10_6_3');
                                        
                                        if(gEx('cmbTipoDiligencia').getValue()!='1')
                                        {
                                            if(gEx('cmbAudienciaNotifica_10_6_3').getValue()=='')
                                            {
                                                function resp1_10_6_3()
                                                {
                                                    cmbAudienciaNotifica_10_6_3.focus();
                                                }
                                                msgBox('Debe indicar la audiencia que se notifica en la diligencia',resp1_10_6_3);
                                                return false;
                                            }
										}                                        
                                    	var gSeguimiento=gEx('gSeguimiento_10_6_3');
                                        if(gSeguimiento.getStore().getCount()==0)
                                        {	
                                        	msgBox('Debe indicar almenos un registro de diligencia telef&oacute;nica');
                                        	return false;
                                        }
                                        
                                        var filaSeg=gSeguimiento.getStore().getAt(0);

										var pGenerar=true;
                                        
										if(filaSeg)
                                        {
                                        	if(filaSeg.data.situacion=='2')
                                            {
                                            	pGenerar=false;
                                            }
                                            else
                                            {
                                                var oDetalle=eval('['+bD(filaSeg.data.detalle)+']')[0];
                                                
                                                if(oDetalle.obtuvoRespuesta=='0')
                                                {
                                                    
                                                    switch(oDetalle.motivoNoRespuesta)
                                                    {
                                                        case '1': // NO contesto
                                                            if(oDetalle.programarLlamada=='1')
                                                            {
                                                                pGenerar=false;
                                                            }
                                                        break;
                                                        case '2': // No. no existe
                                                        break;
                                                        case '3':	//Otro
                                                            if(oDetalle.programarLlamada=='1')
                                                            {
                                                                pGenerar=false;
                                                            }
                                                        break;
                                                    }
                                                }
                                            }
                                        }

                                        if(!pGenerar)
                                        {
                                        	
											generaExposicion=false;
                                        	borrarDiligencia=true;	
                                        }
                                        else
                                        {
                                        	if(fila && fila.data.exposicionDiligencia.trim()=='')
                                            {
                                            	reprocesarDiligencia=true;
                                            }
                                        }
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
                                    	var gSeguimiento=gEx('gSeguimiento_10_6_3');
                                        var filaSeg=gSeguimiento.getStore().getAt(0);
                                        var lblAudiencia='';
                                        var lblHora='';
                                        var salaAudiencia='';
                                        if(gEx('cmbTipoDiligencia').getValue()!='1')
                                        {
                                        
                                            var pos=existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_10_6_3').getValue());
                                            fecha=Date.parseDate(arrAudienciasNotifica[pos][2],'Y-m-d');
                                            var hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                            lblAudiencia=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y');
                                            lblHora=hora.format("H:i");
                                            salaAudiencia=parseInt(arrAudienciasNotifica[pos][5]);
										}      
                                        
                                        var motivoNoContacto='';
                                       	var detalle=eval('['+bD(filaSeg.data.detalle) +']')[0];
                                        
                                        if(detalle.obtuvoRespuesta=='1')
                                        {
                                        	motivoNoContacto=formatearValorRenderer(arrRespNotificacion1,detalle.respuestaObtenida);
                                        }
                                        else
                                        {
                                        	if(detalle.motivoNoRespuesta=='3')
                                            	motivoNoContacto=detalle.motivoNoRespuestaEspecifique;
                                            else
	                                        	motivoNoContacto=formatearValorRenderer(arrRespNotificacion2,detalle.motivoNoRespuesta);
                                        }
                                                                          
                                        
                                    	var cadObj=',"diaDiligencia":"'+filaSeg.data.fechaDiligencia.format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(filaSeg.data.fechaDiligencia.format('m'))-1][1]+
                                                    '","anioDiligencia":"'+filaSeg.data.fechaDiligencia.format('Y')+'","horaDiligencia":"'+
                                                    filaSeg.data.fechaDiligencia.format('H:i')+'","salaAudiencia":"'+salaAudiencia+
                                                    '","fechaAudiencia":"'+lblAudiencia+'","horaAudiencia":"'+lblHora+
                                                    '","resultadoLlamada":"'+ filaSeg.data.detalle+'","motivoNoContacto":"'+cv(motivoNoContacto,true,true)+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var arrSeguimientoTelefonico='';
                                        var gSeguimiento=gEx('gSeguimiento_10_6_3');
                                        var x;
                                        var fila;
                                        var oSeguimiento='';
                                        for(x=0;x<gSeguimiento.getStore().getCount();x++)
                                        {
                                        	fila=gSeguimiento.getStore().getAt(x);
                                            oSeguimiento='{"telefono":"'+fila.data.telefono+'","fechaDiligencia":"'+fila.data.fechaDiligencia.format('Y-m-d H:i')+
                                            			'","detalle":"'+fila.data.detalle+'","situacion":"'+fila.data.situacion+'"}';
                                           	if(arrSeguimientoTelefonico=='')
                                            	arrSeguimientoTelefonico=oSeguimiento;
                                            else
                                            	arrSeguimientoTelefonico+=','+oSeguimiento;
                                        }
                                        fila=gSeguimiento.getStore().getAt(0);
                                        var resultado=fila.data.situacion;
                                        
                                        var oDetalle=eval('['+bD(fila.data.detalle)+']')[0];
                                        var notificado=0;
                                        if((oDetalle.obtuvoRespuesta=='1')&&(oDetalle.respuestaObtenida=='1'))
                                        {
                                        	notificado=1;
                                        }
                                    	
                                    	var cadObj='{"fechaDiligencia":"'+fila.data.fechaDiligencia.format('Y-m-d')+
                                        			'","horaDiligencia":"'+fila.data.fechaDiligencia.format('H:i')+
                                                    '","resultado":"'+resultado+'","citatorio":"0","arrSeguimientoTelefonico":['+
                                                    arrSeguimientoTelefonico+'],"idAudienciaNotifica":"'+gEx('cmbAudienciaNotifica_10_6_3').getValue()+
                                                    '","notificado":"'+notificado+'"}';
                                       
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            
                                                            gEx('cmbAudienciaNotifica_10_6_3').setValue(oEdicion.idAudienciaNotifica);
                                                            var gSeguimiento=gEx('gSeguimiento_10_6_3');
                                                            var x;
                                                            var f;
                                                            var reg=crearRegistro	(
                                                            							[
                                                                                        	{name: 'telefono'},
                                                                                            {name: 'fechaDiligencia'},
                                                                                            {name:'detalle'},
                                                                                            {name: 'situacion'}
                                                                                        ]
                                                            						)
                                                            for(x=0;x<oEdicion.arrSeguimientoTelefonico.length;x++)
                                        					{
                                                            	f=oEdicion.arrSeguimientoTelefonico[x];
                                                            	r=new 	reg	(
                                                                				{
                                                                                	telefono:f.telefono,
                                                                                    fechaDiligencia:Date.parseDate(f.fechaDiligencia,'Y-m-d H:i'),
                                                                                    detalle:f.detalle,
                                                                                    situacion:f.situacion
                                                                                }
                                                                			)					
                                                            	gSeguimiento.getStore().add(r);
                                                            
                                                            }


                                                        }   
    
    
    
    //2_1
    arrPaneles.push	(
    					new Ext.Panel	(	{
                            
                                                x:0,
                                                y:0,
                                                id:'p_2_1',
                                                width:600,
                                                height:280,
                                                hidden:true,
                                                baseCls: 'x-plain',
                                                bodyStyle:{"font-size":"11px"}, 
                                                border:true,
                                                listeners:	{
                                                				show:function(p)
                                                                	{
                                                                    	
                                                                    	if((!p.vistoPrimeraVez)&&(fila))
                                                                        {
                                                                        	p.reloadObjetoEdicion(fila.data.objDiligencia);
                                                                    		p.vistoPrimeraVez=true;
                                                                        }
                                                                        
                                                                        if(gEx('cmbTipoDiligencia').getValue()=='1')
                                                                        {
                                                                            cmbAudienciaNotifica_2_1.hide();
                                                                            gEx('lblAudienciaNotifica_2_1').hide();
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                            cmbAudienciaNotifica_2_1.show();
                                                                            gEx('lblAudienciaNotifica_2_1').show();
                                                                            
                                                                        }
                                                                        
                                                                        
                                                                    }
                                                			},
                                                layout:'absolute',
                                                items:	[
                                                            {
                                                                x:10,
                                                                y:10,
                                                                xtype:'label',
                                                                html:'Fecha de la diligencia:'
                                                            },
                                                            {
                                                                x:175,
                                                                y:5,
                                                                xtype:'datefield',
                                                                id:'fecha_2_1',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            {
                                                            	x:250,
                                                                y:110,                                                                
                                                                xtype:'button',
                                                                icon:'../images/email_go.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Enviar correo',
                                                                handler:function()
                                                                        {
                                                                        	mostrarVentanaAdmonCorreo()
                                                                            
                                                                        }
                                                                
                                                            },
                                                            {
                                                                x:10,
                                                                y:40,
                                                                xtype:'label',
                                                                html:'Hora de la diligencia:'
                                                            },
                                                            cmbHora_2_1,
                                                            {
                                                            	x:10,
                                                                y:70,
                                                                xtype:'label',
                                                                id:'lblAudienciaNotifica_2_1',
                                                                html:'Audiencia que se notifica:'
                                                            },
                                                            cmbAudienciaNotifica_2_1,
                                                            {
                                                            	x:10,
                                                                y:160,
                                                                xtype:'label',
                                                                html:'Resultado de la notificaci&oacute;n:'
                                                            },
                                                            cmbResultadoNotificacion_2_1,
                                                            {
                                                            	x:10,
                                                                y:190,
                                                                xtype:'label',
                                                                id:'lblFechaHoraRespuesta_2_1',
                                                                html:'Fecha/hora de respuesta:'
                                                            },
                                                            {
                                                                x:175,
                                                                y:185,
                                                                xtype:'datefield',
                                                                id:'fechaRespuesta_2_1',
                                                                value:'<?php echo date("Y-m-d")?>'
                                                            },
                                                            cmbHoraRespuesta_2_1
                                                           
                                                        ]
                                            }
                                        )
                   	)
    
    arrPaneles[arrPaneles.length-1].funcionValidacion=function()
    								{
                                    	if(gEx('fecha_2_1').getValue()=='')
                                        {
                                        	function resp_2_1()
                                            {
                                            	gEx('fecha_2_1').focus();
                                            }
                                            msgBox('Debe indicar la fecha en que se llev&oacute; a cabo la diligencia',resp_2_1);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbHora_2_1').getValue()=='')
                                        {
                                        	function resp2_2_1()
                                            {
                                            	gEx('cmbHora_2_1').focus();
                                            }
                                            msgBox('Debe indicar la hora en que se llev&oacute; a cabo la diligencia',resp2_2_1);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbTipoDiligencia').getValue()!='1')
                                        {
                                            if(gEx('cmbAudienciaNotifica_2_1').getValue()=='')
                                            {
                                                function resp3_2_1()
                                                {
                                                    gEx('cmbAudienciaNotifica_2_1').focus();
                                                }
                                                msgBox('Debe indicar la audiencia que se notifica en la diligencia',resp3_2_1);
                                                return false;
                                            }
                                        }
                                        
                                        if(gEx('cmbResultadoNotificacion_2_1').getValue()=='')
                                        {
                                        	function resp2RespuestaResultado_2_1()
                                            {
                                            	gEx('cmbResultadoNotificacion_2_1').focus();
                                            }
                                            msgBox('Debe indicar el resultado de la diligencia',resp2RespuestaResultado_2_1);
                                        	return false;
                                        }
                                        
                                        if(gEx('cmbResultadoNotificacion_2_1')=='1')
                                        {
                                            if(gEx('fechaRespuesta_2_1').getValue()=='')
                                            {
                                                function respRespuesta_2_1()
                                                {
                                                    gEx('fechaRespuesta_2_1').focus();
                                                }
                                                msgBox('Debe indicar la fecha en que se recibi&oacute; respuesta de la diligencia',respRespuesta_2_1);
                                                return false;
                                            }
                                            
                                            
                                            if(gEx('cmbHoraRespuesta_2_1').getValue()=='')
                                            {
                                                function resp2Respuesta_2_1()
                                                {
                                                    gEx('cmbHoraRespuesta_2_1').focus();
                                                }
                                                msgBox('Debe indicar la hora en que se recibi&oacute; respuesta de la diligencia',resp2Respuesta_2_1);
                                                return false;
                                            }
                                        }
                                        
                                        
                                        return true;
                                    }
                                    
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetos=function()
    								{
                                    	var lblAudiencia='';
                                        var lblHora='';
                                        var fecha=gEx('fechaRespuesta_2_1').getValue();
                                        var lblFechaRespuesta=(fecha==''?'':(fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y')));
    									var salaAudiencia='';
                                        if(gEx('cmbTipoDiligencia').getValue()!='1')
                                        {
                                            var pos=existeValorMatriz(arrAudienciasNotifica,gEx('cmbAudienciaNotifica_2_1').getValue());
                                            fecha=Date.parseDate(arrAudienciasNotifica[pos][2],'Y-m-d');
                                            var hora=Date.parseDate(arrAudienciasNotifica[pos][3],'Y-m-d H:i:s');
                                            lblAudiencia=fecha.format('d')+' de '+arrMeses[parseInt(fecha.format('m'))-1][1]+' de '+fecha.format('Y');
                                            lblHora=hora.format('H:i');
                                            salaAudiencia=parseInt(arrAudienciasNotifica[pos][5]);
                                        }
                                    	var cadObj=',"diaDiligencia":"'+gEx('fecha_2_1').getValue().format('d')+'",'+
                                        			'"mesDiligencia":"'+arrMeses[parseInt(gEx('fecha_2_1').getValue().format('m'))-1][1]+
                                                    '","anioDiligencia":"'+gEx('fecha_2_1').getValue().format('Y')+'","horaDiligencia":"'+
                                                    gEx('cmbHora_2_1').getValue()+'","horaAudiencia":"'+lblHora+
                                                    '","fechaAudiencia":"'+lblAudiencia+'","horaRespuesta":"'+gEx('cmbHoraRespuesta_2_1').getValue()+
                                                    '","fechaRespuesta":"'+lblFechaRespuesta+'","salaAudiencia":"'+salaAudiencia+
                                                    '","resultadoMail":"'+gEx('cmbResultadoNotificacion_2_1').getValue()+'"';
                                        return cadObj;
                                    }
	
    arrPaneles[arrPaneles.length-1].obtenerParametrosObjetoSave=function()
    								{
                                    	var notificado=1;
                                        switch(gEx('cmbResultadoNotificacion_2_1').getValue())
                                        {
                                        	case '0':
                                            case '2':
                                            	notificado=0;
                                            break;
                                        }
                                        
                                    	var cadObj='{"fechaDiligencia":"'+gEx('fecha_2_1').getValue().format('Y-m-d')+
                                        			'","horaDiligencia":"'+gEx('cmbHora_2_1').getValue()+
                                                    '","resultado":"'+gEx('cmbResultadoNotificacion_2_1').getValue()+
                                                    '","citatorio":"0","idAudienciaNotifica":"'+gEx('cmbAudienciaNotifica_2_1').getValue()+
                                                    '","horaRespuesta":"'+gEx('cmbHoraRespuesta_2_1').getValue()+
                                                    '","fechaRespuesta":"'+(gEx('fechaRespuesta_2_1').getValue()!=''?gEx('fechaRespuesta_2_1').getValue().format('Y-m-d'):'')+
                                                    '","resultadoMail":"'+gEx('cmbResultadoNotificacion_2_1').getValue()+'","notificado":"'+notificado+'"}';
                                        return cadObj;
                                    } 
                                    
	arrPaneles[arrPaneles.length-1].reloadObjetoEdicion=function(objEdicion)
                                                        {
                                                        	var oEdicion=eval('['+bD(objEdicion)+']')[0];
                                                            gEx('cmbResultadoNotificacion_2_1').setValue(oEdicion.resultadoMail);
                                                            dispararEventoSelectCombo('cmbResultadoNotificacion_2_1');
                                                            gEx('cmbResultadoNotificacion_2_1').fireEvent('change',gEx('cmbResultadoNotificacion_2_1'),gEx('cmbResultadoNotificacion_2_1').getValue());
                                                            gEx('fecha_2_1').setValue(oEdicion.fechaDiligencia);
                                                            gEx('cmbHora_2_1').setValue(oEdicion.horaDiligencia);
                                                            gEx('cmbAudienciaNotifica_2_1').setValue(oEdicion.idAudienciaNotifica);
                                                            gEx('cmbHoraRespuesta_2_1').setValue(oEdicion.horaRespuesta);
                                                            gEx('fechaRespuesta_2_1').setValue(oEdicion.fechaRespuesta);
                                                            

                                                        } 
    //--
    
    
    arrPaneles.push	(crearGridDocumentosAdjuntos());
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                            x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'<b>Notificaci&oacute;n a:&nbsp;&nbsp;</b>'
                                                        },
                                                        {
                                                            x:140,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'<span style="color:#900">'+nodoSujetoSel.attributes.nombre+' ('+lblFigura+')</span></b>'
                                                        },
                                                        {
                                                            x:10,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'<b>Tipo de diligencia:</b>'
                                                        },
                                                        cmbTipoDiligencia,
                                                        {
                                                            x:400,
                                                            y:40,
                                                            //hidden:cmbDetalleFigura.getStore().getCount()==0,
                                                            xtype:'label',
                                                            html:'<b>Orden:</b>'
                                                        },
                                                        cmbOrden,
                                                        {
                                                            x:590,
                                                            y:40,
                                                            hidden:cmbDetalleFigura.getStore().getCount()==0,
                                                            xtype:'label',
                                                            html:'<b>Tipo de '+tFigura.toLowerCase()+':</b>'
                                                        },
                                                        cmbDetalleFigura,
                                            			{
                                                        	x:10,
                                                            y:70,
                                                            id:'fPaso_1',
                                                            width:930,
                                                            height:320,
                                                            title:'Seleccione el medio de notificaci&oacute;n',
                                                            xtype:'fieldset',
                                                            layout:'absolute',
                                                            items:	[
                                                            			crearArbolMedioNotificacion(tPersonaJuridica)
                                                            		]
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'fPaso_2',
                                                            width:930,
                                                            height:320,
                                                            hidden:true,
                                                            title:'Datos de la diligencia [Medio de notificaci&oacute;n: <span id="lblMedioNotificacion"></span>]',
                                                            xtype:'fieldset',
                                                            listeners:	{
                                                            				show:function()
                                                                            		{
                                                                                    	gEx('gDocumentos').getView().refresh();
                                                                                    	var medioNotificacion='';
                                                                                        
                                                                                        var lblMedio;
                                                                                        var nodo=nodoMedioSel.parentNode;
                                                                                        medioNotificacion=Ext.util.Format.stripTags(nodoMedioSel.attributes.text);
                                                                                        medioNotificacion=medioNotificacion.replace(/\-/gi,'');
                                                                                        while(nodo.id!='-1')
                                                                                        {
                                                                                        	lblMedio=Ext.util.Format.stripTags(nodo.attributes.text);
                                                                                            lblMedio=lblMedio.replace(/\-/gi,'');
                                                                                            medioNotificacion=lblMedio+' >> '+medioNotificacion;
                                                                                        	nodo=nodo.parentNode;
                                                                                        }
                                                                                        
                                                                                    	gE('lblMedioNotificacion').innerHTML=medioNotificacion;
                                                                                        
                                                                                        var x=0;
                                                                                        for(x=0;x<arrPaneles.length;x++)
                                                                                        {
                                                                                        	if(arrPaneles[x].id.indexOf('p_')!=-1)
	                                                                                        	arrPaneles[x].hide();
                                                                                        }
                                                                                        
                                                                                        
                                                                                        gEx('p_'+nodoMedioSel.id).show();
                                                                                        
                                                                                    }
                                                                            	
                                                            			},
                                                            layout:'absolute',
                                                            items:	arrPaneles
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'fPaso_3',
                                                            width:930,
                                                            height:320,
                                                            hidden:true,
                                                            title:'Exposici&oacute;n de la diligencia [Medio de notificaci&oacute;n: <span id="lblMedioNotificacion3"></span>]',
                                                            xtype:'fieldset',
                                                            listeners:	{
                                                            				show:function(panel)
                                                                            		{
                                                                                    	
                                                                                    	if(!panel.visualizado)
                                                                                        {
                                                                                        	
                                                                                            var editor1=	CKEDITOR.replace('txtExposicionDiligencia',
                                                                                                                                             {
                                                                                                                                                
                                                                                                                                                customConfig:'../../modulosEspeciales_SGJP/Scripts/configCKEditorNotificacion.js',
                                                                                                                                                height:190,
                                                                                                                                                enterMode : CKEDITOR.ENTER_BR,
                                                                                                                                                resize_enabled:false,
                                                                                                                                                on:	{
                                                                                                                                                        instanceReady:function(evt)
                                                                                                                                                                    {
                                                                                                                                                                    	
                                                                                                                                                                    	if((fila)&&(!borrarDiligencia))
                                                                                                                                                                        {

                                                                                                                                                                        	CKEDITOR.instances['txtExposicionDiligencia'].setData(fila.data.exposicionDiligencia);  
                                                                                                                                                                        	mostrarBotonReprocesar();
                                                                                                                                                                        }
                                                                                                                                                                        
                                                                                                                                                                        if(reprocesarDiligencia)
                                                                                                                                                                        {
                                                                                                                                                                        	
                                                                                                                                                                        	generarExposicionDiligencia();
                                                                                                                                                                            reprocesarDiligencia=false;
                                                                                                                                                                            mostrarBotonReprocesar();
                                                                                                                                                                            return;
                                                                                                                                                                        }
                                                                                                                                                                        
                                                                                                                                                                        if(borrarDiligencia)
                                                                                                                                                                        {

                                                                                                                                                                        	CKEDITOR.instances['txtExposicionDiligencia'].setData(''); 
                                                                                                                                                                            ocultarBotonReprocesar();
                                                                                                                                                                        }
                                                                                                                                                                        else
                                                                                                                                                                            if((CKEDITOR.instances['txtExposicionDiligencia'].getData()=='')&& generaExposicion)
                                                                                                                                                                            {

                                                                                                                                                                                generarExposicionDiligencia();
                                                                                                                                                                                mostrarBotonReprocesar();
                                                                                                                                                                            }
                                                                                                                                                                        
                                                                                                                                                                    }
                                                                                                                                                        
                                                                                                                                                    }
                                                                                                                                             }
                                                                                                                            );
                                                                                        
                                                                                            
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                        	 if(reprocesarDiligencia)
                                                                                            {
                                                                                                generarExposicionDiligencia();
                                                                                                reprocesarDiligencia=false;
                                                                                                mostrarBotonReprocesar();
                                                                                                return;
                                                                                            }
                                                                                        	if(borrarDiligencia)
                                                                                            {
                                                                                            	CKEDITOR.instances['txtExposicionDiligencia'].setData(''); 
                                                                                                ocultarBotonReprocesar();
                                                                                            }
                                                                                            else
                                                                                                if((CKEDITOR.instances['txtExposicionDiligencia'].getData()=='')&&(generaExposicion))
                                                                                                {
                                                                                                    generarExposicionDiligencia();
                                                                                                    mostrarBotonReprocesar();
                                                                                                }
                                                                                        }
                                                                                        panel.visualizado=true;
                                                                                    	gE('lblMedioNotificacion3').innerHTML=gE('lblMedioNotificacion').innerHTML;
                                                                                    }
                                                                            	
                                                            			},
                                                            layout:'absolute',
                                                            items:	[
                                                            			{
                                                                            x:10,
                                                                            y:10,
                                                                            xtype:'label',
                                                                            html:'<textarea id="txtExposicionDiligencia"></textarea>'
                                                                        }
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: fila?'Modificar notificaci&oacute;n':'Registrar notificaci&oacute;n',
										width: 980,
                                        id:'vAgregarNotificacion',
										height:470,
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
                                                                    
                                                                    	if(fila)
                                                                        {
                                                                        	idDiligencia=fila.data.idDiligencia;
                                                                        	funcAfterLoadMedio=function()
                                                                                                {
                                                                                                    var oMedio=fila.data.arrMediosNotificacion[0];
                                                                                                    var idMedio=oMedio.idMedio;
                                                                                                    if(oMedio.detalle1!='')
                                                                                                        idMedio+='_'+oMedio.detalle1;
                                                                                                    
                                                                                                    if(oMedio.detalle2!='')
                                                                                                        idMedio+='_'+oMedio.detalle2;
                                                                    								setTimeout	(	function()
                                                                                                                    {
                                                                                                                        var nodo=gEx('arbolMedio').getNodeById(idMedio);
					                                                                                                    gEx('arbolMedio').getSelectionModel().select(nodo);
                                                                                                   						funcMedioSel(nodo);
                                                                                                                        
                                                                                                                        if(enviarPaso2)
                                                                                                                        {
                                                                                                                        	irPaso(2,fila);
                                                                                                                        	enviarPaso2=false;
                                                                                                                        }
                                                                                                                    },1000
                                                                                                                )
                                                                                                    
                                                                                                    
                                                                                                }
                                                                            gEx('cmbOrden').setValue(fila.data.orden);
                                                                            gEx('cmbTipoDiligencia').setValue(fila.data.tipoDiligencia);
                                                                            gEx('cmbTipoDiligencia').disable();
                                                                            gEx('cmbDetalleFigura').setValue(fila.data.idDetalleParteProcesal);
                                                                            setTimeout	(	function()
                                                                            				{
                                                                                            	dispararEventoSelectCombo('cmbTipoDiligencia');
                                                                                            },500
                                                                            			)
                                                                            
                                                                           	var reg=crearRegistro  ( 	[
                                                                                                            {name: 'idDocumento'},
                                                                                                            {name: 'nombreDocumento'},
                                                                                                            {name: 'nombreDocumentoCorto'},
                                                                                                            {name: 'tamanoDocumento'},
                                                                                                            {name: 'fechaDocumento'},
                                                                                                            {name: 'extension'}
                                                                                                         ]
                                                                                                    )
                                                                             var x;
                                                                             var r;

                                                                             for(x=0;x<fila.data.arrDocumentos.length;x++)
                                                                             {
                                                                             	r=new reg(fila.data.arrDocumentos[x]);
                                                                                gEx('gDocumentos').getStore().add(r);
                                                                             }
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                    
                                                                    }
                                                                }
                                                    },
										buttons:	[
														{
															
															text: '<< Anterior',
                                                            disabled:true,
                                                            id:'btnAnterior',
															handler: function()
																	{
                                                                    	paso--;
                                                                    	if(paso==0)
                                                                        {
	                                                                    	paso=1;
                                                                        }
                                                                        irPaso(paso,fila);
																	}
														},'-',
														{
															
															text: 'Siguiente >>',
                                                            disabled:true,
                                                            id:'btnSiguiente',
															handler: function()
																	{
                                                                    	paso++;
                                                                        if(paso==3)
                                                                        {
                                                                        	if(!gEx('p_'+nodoMedioSel.id).funcionValidacion())
                                                                            {
                                                                            	paso--;
                                                                                return;
                                                                            }
                                                                        }
                                                                    	if(paso>maxPasos)
                                                                        {
	                                                                    	paso=maxPasos;
                                                                        }
                                                                        irPaso(paso,fila);
																	}
														},
                                                        {
															text: 'Finalizar',
                                                            id:'btnFinalizar',
                                                            disabled:true,
															handler:function()
																	{
																		guardarDiligencia();
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


function crearArbolMedioNotificacion(tPersona)
{
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
                                                                    funcion:'21'
                                                                    
                                                                    
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            	medioSel='';
                            	c.baseParams.tipoDiligencia=gEx('cmbTipoDiligencia').getValue()!=''?gEx('cmbTipoDiligencia').getValue():-1;
                                c.baseParams.tipoPersona=tPersona;
                                c.baseParams.detalle=gEx('cmbDetalleFigura').getValue()!=''?gEx('cmbDetalleFigura').getValue():-1;
                            	nodoMedioSel=null;
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	if(funcAfterLoadMedio)
                                {
                                	funcAfterLoadMedio();
                                }
                            }
    				)										
	var arbolMedio=new Ext.tree.TreePanel	(
                                                {	
                                                    x:0,
                                                    y:0,
                                                    border:true,
                                                    width:900,
                                                    height:280,
                                                    id:'arbolMedio',
                                                    useArrows:true,
                                                    animate:true,
                                                    enableDD:false,
                                                    ddScroll:true,
                                                    containerScroll: true,
                                                    autoScroll:true,
                                                    root:raiz,
                                                    loader: cargadorArbol,
                                                    rootVisible:false
                                                }
                                            )
         
	arbolMedio.on('click',funcMedioSel);
                                                              
	return  arbolMedio;
}

function funcMedioSel(nodo, evento)
{
	nodoMedioSel=nodo;
    if((medioSel!='')&&(medioSel!=nodo.id))
    {
    	reprocesarDiligencia=true;
    }
    
    
    medioSel=nodo.id;
    console.log(nodoMedioSel);
    if(nodoMedioSel.attributes.elegible=='1')
    	gEx('btnSiguiente').enable();
    else
    	gEx('btnSiguiente').disable();
    
}

function irPaso(nPaso,fila)
{
	var x;
	for(x=1;x<=maxPasos;x++)
    {
    	if(gEx('fPaso_'+x))
        	gEx('fPaso_'+x).hide();
    }	
    if(gEx('fPaso_'+nPaso))
	    gEx('fPaso_'+nPaso).show();
    
    if(nPaso==1)
    {
    	gEx('btnAnterior').disable();
        if(!fila)
	        gEx('cmbTipoDiligencia').enable();
        if(!gEx('cmbDetalleFigura').deshabilitado)
        {
        	gEx('cmbDetalleFigura').enable();
        }
    }
    else
    {
    	gEx('btnAnterior').enable();
        gEx('cmbTipoDiligencia').disable();
        gEx('cmbDetalleFigura').deshabilitado=gEx('cmbDetalleFigura').disabled;
        gEx('cmbDetalleFigura').disable();
        
    }
   
	if(nPaso==maxPasos)
    {
    	gEx('btnSiguiente').disable();
        gEx('btnFinalizar').enable();
    }
    else
    {
    	gEx('btnSiguiente').enable();        
        gEx('btnFinalizar').disable();
    }
}

function crearGridDocumentosAdjuntos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    
                                                                    {name: 'idDocumento'},
                                                                    {name: 'nombreDocumento'},
                                                                    {name: 'nombreDocumentoCorto'},
                                                                    {name: 'tamanoDocumento'},
                                                                    {name: 'fechaDocumento'},
                                                                    {name: 'extension'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	{
															header:'',
															width:25,
                                                            align:'center',
															sortable:true,
															dataIndex:'idDocumento',
                                                            renderer: function(val,meta,registro)
                                                            		{
                                                                    	var arrExtension=registro.data.nombreDocumento.split('.');
                                                                        var extension=arrExtension[arrExtension.length-1];
                                                                        
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+extension.toLowerCase()+'.png">';
                                                                    }
														},
														{
															header:'Documento',
															width:280,
															sortable:true,
															dataIndex:'nombreDocumento',
                                                            renderer:mostrarValorDescripcion
														}
														
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gDocumentos',
                                                            store:alDatos,
                                                            frame:false,
                                                            x:620,
                                                            y:0,
                                                            title:'Documentos adjuntos',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:220,
                                                            width:270,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar documento',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAdjuntarDocumento();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover documento',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el documento que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        tblGrid.getStore().remove(fila);
                                                                                        
                                                                                        
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	
    tblGrid.on('rowdblclick',function(g,nFila)
    						{
                            	var registroDocumentoSel=g.getStore().getAt(nFila);
                            	mostrarVisorDocumentoProceso(registroDocumentoSel.data.extension,registroDocumentoSel.data.idDocumento,registroDocumentoSel);
                            }
    		)
    
    return 	tblGrid;	
}

function mostrarVentanaAdjuntarDocumento()
{
	
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:10,
                                                            html:'Ingrese el documento a adjuntar:'
                                                        },
                                                        {
                                                            x:240,
                                                            y:5,
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:535,
                                                            y:6,
                                                            id:'btnUploadFile',
                                                            xtype:'button',
                                                            text:'Seleccionar...',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
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
                                                        } 

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Adjuntar documento',
										width: 650,
                                        id:'vDocumento',
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
                                                                
                                                                	var cObj={
                                                                    // Backend settings
                                                                                upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                file_post_name: "archivoEnvio",
                                                                 
                                                                                // Flash file settings
                                                                                file_size_limit : "1000 MB",
                                                                                file_types : "*.pdf;*.jpg;*.jpeg;*.gif;*.png",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                file_types_description : "Todos los archivos",
                                                                                file_upload_limit : 0,
                                                                                file_queue_limit : 1,
                                                                 
                                                                                
                                                                                upload_success_handler : subidaCorrecta
                                                                            };
                                                                
																	crearControlUploadHTML5(cObj);
                                                                }
                                                                
                                                                
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	if(uploadControl.files.length==0)
                                                                        {
                                                                            msgBox('Debe ingresar el documento que desea adjuntar');
                                                                            return;
                                                                        }
                                                                        uploadControl.start();
                                                                    	
																		
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
       	if( gE('txtFileName'))
	        gE('txtFileName').value=arrDatos[2];
        
        var reg=crearRegistro(	
        						[
        							{name: 'idDocumento'},
                                    {name: 'nombreDocumento'},
                                    {name: 'nombreDocumentoCorto'},
                                    {name: 'tamanoDocumento'},
                                    {name: 'fechaDocumento'},
                                    {name: 'extension'}
        						]
                               )
        
        
        var arrExtension=gEx("nombreArchivo").getValue().split('.');
        var r=new reg	(
        					{
                            	idDocumento:gEx("idArchivo").getValue(),
                                nombreDocumento:gEx("nombreArchivo").getValue(),
                                nombreDocumentoCorto:gEx("nombreArchivo").getValue(),
                                tamanoDocumento:'0',
                                fechaDocumento:'<?php echo date("Y-m-d H:i:s")?>',
                                extension:arrExtension[arrExtension.length-1]
                            }
        				)
        gEx('gDocumentos').getStore().add(r);
        
        gEx('vDocumento').close();         
       
        
        
        
    }
		
	
}

function generarExposicionDiligencia()
{
	var idPanel='p_'+nodoMedioSel.id;
    var panel=gEx(idPanel);
    var cadObjPanel=panel.obtenerParametrosObjetos();
    
    var cmbDetalleFigura=gEx('cmbDetalleFigura');
    
    var tFigura;
    var arrDetalles;
	pos=existeValorMatriz(arrParteProcesal,nodoSujetoSel.attributes.personaJuridica,0,true);
    tFigura=arrParteProcesal[pos][0];
	var tPersonaJuridica=nodoSujetoSel.parentNode.attributes.tipoFigura;
   	var cadObj='{"parteProcesal":"'+tPersonaJuridica+'","detalleParteProcesal":"'+(cmbDetalleFigura.getStore().getCount()==0?-1:cmbDetalleFigura.getValue())+
    			'","nombreDestinatario":"'+nodoSujetoSel.attributes.nombre+'","tipoDiligencia":"'+gEx('cmbTipoDiligencia').getValue()+
                '","idCarpeta":"'+gE('idCarpeta').value+'","resultado":"1","citatorio":"0","medioNotificacion":"'+nodoMedioSel.id+
                '","idOrden":"'+gE('idOrden').value+'"'+cadObjPanel+'}';
    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var oResp=eval('['+arrResp[1]+']')[0];
            CKEDITOR.instances['txtExposicionDiligencia'].setData(escaparBR(bD(oResp.exposicionDiligencia),true));  
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=22&cadObj='+cadObj,true);
    
    
    
    
}

function guardarDiligencia(enviadoCentral)
{
	var arrPersona=nodoSujetoSel.id.split('_');
	var idPanel='p_'+nodoMedioSel.id;
    var panel=gEx(idPanel);
    var cadObjPanel=panel.obtenerParametrosObjetoSave();
    var oSave=eval('['+cadObjPanel+']')[0];
    var cmbDetalleFigura=gEx('cmbDetalleFigura');
    
    var tFigura;
    var arrDetalles;
	pos=existeValorMatriz(arrParteProcesal,nodoSujetoSel.attributes.personaJuridica,0,true);
    tFigura=arrParteProcesal[pos][0];
   
   var arrDocumentos='';
   var oDocumento='';
   var x;
   var fila;
   for(x=0;x<gEx('gDocumentos').getStore().getCount();x++)
   {
	   fila=gEx('gDocumentos').getStore().getAt(x);
       oDocumento='{"idDocumento":"'+fila.data.idDocumento+'","nombreDocumento":"'+fila.data.nombreDocumento+'"}';
       if(arrDocumentos=='')
       		arrDocumentos=oDocumento;
       else
       		arrDocumentos+=','+oDocumento;
   }
   	
   	var arrMedio=nodoMedioSel.id.split('_');
    var oMedio=o='{"idMedio":"'+arrMedio[0]+'","detalle1":"'+(arrMedio[1]?arrMedio[1]:'')+'","detalle2":"'+(arrMedio[2]?arrMedio[2]:'')+
    '","detalle3":"'+cv(oSave.otroMedio?oSave.otroMedio:'')+'","resultado":"'+oSave.resultado+'","citatorio":"'+oSave.citatorio+'"}';
                  
     var objDiligencia='{"idOrden":"'+gE('idOrden').value+'","idDiligencia":"'+idDiligencia+'","fechaDiligencia":"'+oSave.fechaDiligencia+
     					'","tipoDiligencia":"'+gEx('cmbTipoDiligencia').getValue()+'","otroTipoDiligencia":"","parteProcesal":"'+tFigura+
                        '","detalleParteProcesal":"'+(cmbDetalleFigura.getStore().getCount()==0?-1:cmbDetalleFigura.getValue())+'","idParteProcesal":"'+arrPersona[1]+
                        '","nombreParteProcesal":"","idResponsableDiligencia":"<?php echo $_SESSION["idUsr"]?>","nombreResponsableDiligencia":"","exposicionDiligencia":"'+
                        cv(bE(CKEDITOR.instances['txtExposicionDiligencia']?CKEDITOR.instances['txtExposicionDiligencia'].getData():''))+'","arrMedioNotificacion":['+oMedio+'],"orden":"'+
                        gEx('cmbOrden').getValue()+'","arrDocumentos":['+arrDocumentos+'],"objDiligencia":"'+bE(cadObjPanel)+'","enviadoCentralNotificadores":"'+
                        (enviadoCentral?1:0)+'"}';
     
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	switch(arrResp[1])
            {
            	case '1':
                	gEx('gDiligencias').getStore().reload();
                    gEx('vAgregarNotificacion').close();
                    
                    selPersona=nodoSujetoSel.id;
                    gEx('arbolSujetos').getRootNode().reload();
                break;
                case '0':
                	function resp()
                    {
                    	gEx('gDiligencias').getStore().reload();
                        gEx('vAgregarNotificacion').close();
                        
                        selPersona=nodoSujetoSel.id;
                        gEx('arbolSujetos').getRootNode().reload();
                    }
                	msgBox('<b>NO</b> se ha podido enviar la notificaci&oacute;n a la central de notificadores debido al siguiente problema:<br><br>'+arrResp[2],resp);
                    return;
                break;
            }
        	
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=23&objDiligencia='+objDiligencia,true);
}

function crearGridDiligencias()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDiligencia'},
                                                        {name:'idActa'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'fechaDiligencia', type:'date', dateFormat:'Y-m-d'},
		                                                {name: 'tipoDiligencia'},
                                                        {name: 'otroTipoDiligencia'},
		                                                {name: 'idParteProcesal'},
                                                        {name: 'idDetalleParteProcesal'},
		                                                {name: 'idNombreParteProcesal'},
                                                        {name: 'nombreParte'},                                                        
                                                        {name: 'exposicionDiligencia'},
                                                        {name: 'lblNombreParteProcesal'},
                                                        {name: 'idResponsableDiligencia'},
                                                        {name: 'lblOtroResponsable'},
                                                        {name: 'arrMediosNotificacion'},
                                                        {name: 'orden'},
                                                        {name: 'objDiligencia'},
                                                        {name: 'arrDocumentos'},
                                                        {name: 'situacionActa'},
                                                        {name: 'noActa'},
                                                        {name: 'seEnviaCentralNotificadores'},
                                                        {name: 'enviadoCentralNotificadores'},
                                                        {name: 'idAcuseEnvioCentralNotificadores'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(

                                                                                    {
    
                                                                                        url: '../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
    
                                                                                    }
    
                                                                                ),
                                              sortInfo: {field: 'idDiligencia', direction: 'ASC'},
                                              groupField: 'noActa',
                                              remoteGroup:false,
                                              remoteSort: true,
                                              autoLoad:true
                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnModifyDiligencia').disable();
                                        gEx('btnDelDiligencia').disable();
                                    	proxy.baseParams.funcion='24';
                                        proxy.baseParams.idOrden=gE('idOrden').value;
                                        
                                    }
                        )   
      
      
      alDatos.on('load',function(proxy)
    								{
                                    	if(selDiligencia!='')
                                        {
                                        	var pos=obtenerPosFila(gEx('gDiligencias').getStore(),'idDiligencia',selDiligencia);
                                           	var registroSel=gEx('gDiligencias').getStore().getAt(pos);
                                            gEx('gDiligencias').getSelectionModel().selectRecords([registroSel]);
                                            enviarPaso2=true;
                                            modificarDiligencia();
                                        	selDiligencia='';
                                        }
                                        
                                        
                                    }
                )
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacionActa',
                                                                renderer:function(val,meta,registro)	
                                                                		{
                                                                        	if(parseInt(val)==2)
                                                                            {
                                                                            	return '<img src="../images/lock.png" title="Acta firmada/cerrada" alt="Acta firmada/cerrada">';
                                                                            }
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'No. de acta',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'noActa',
                                                                renderer:function(val,meta,registro)	
                                                                		{
                                                                        	return 'No. de acta: '+val;
                                                                        }
                                                            },
                                                            {
                                                                header:'ID Diligencia',
                                                                width:150,
                                                                hidden:true,
                                                                sortable:true,
                                                                dataIndex:'idDiligencia'
                                                            },
                                                            {
                                                                header:'Orden',
                                                                width:50,
                                                                sortable:true,
                                                                dataIndex:'orden'
                                                            },
                                                            {
                                                                header:'Fecha de la diligencia',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaDiligencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i:s');
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo diligencia',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'tipoDiligencia',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblTipoDiligencia=formatearValorRenderer(arrTipoDiligencias,val);
                                                                            if(parseInt(val)==0)
                                                                            {
                                                                            	lblTipoDiligencia+=': '+registro.data.otroTipoDiligencia;
                                                                            }
                                                                        	return mostrarValorDescripcion(lblTipoDiligencia);
                                                                        }
                                                            },
                                                            {
                                                                header:'Parte procesal',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idParteProcesal',
                                                                renderer:function(val,meta,registro)
                                                                		{
																			var lblParteProcesal='';
                                                                            lblParteProcesal=formatearValorRenderer(arrParteProcesal,val);
                                                                            
                                                                            if((registro.data.idDetalleParteProcesal!='')&&(registro.data.idDetalleParteProcesal!='-1'))
                                                                            {
                                                                            	lblParteProcesal+=' ('+formatearValorRenderer(arrEspecificacionParteProcesal,registro.data.idDetalleParteProcesal)+')';
                                                                            	
                                                                            }
                                                                        	return mostrarValorDescripcion(lblParteProcesal);
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre del destinatario',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'nombreParte',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val!='')
                                                                            	return val;
                                                                            return registro.data.lblNombreParteProcesal;
                                                                        }
                                                            },                                                       
                                                            
                                                            
                                                            
                                                            {
                                                                header:'Se contact&oacute; al destinatario',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'responsableDiligencia',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var x;
                                                                            var fila;
                                                                           
                                                                            var nNo=0;
                                                                            var nNA=0;
                                                                            for(x=0;x<registro.data.arrMediosNotificacion.length;x++)
                                                                            {
                                                                                fila=registro.data.arrMediosNotificacion[x];
                                                                                
                                                                                
                                                                                switch(parseInt(fila.resultado))
                                                                                {
                                                                                	case 1:
                                                                                    	return '<span style="color:#030"><b>S&iacute;</b></span>';
                                                                                    break;
                                                                                    case 2:
                                                                                    	nNo++;
                                                                                    break;
                                                                                    case 3:
                                                                                    	nNo++;
                                                                                    break;
                                                                                }
                                                                                
                                                                                   
                                                                            }
                                                                            if(nNA>0)
                                                                            {
                                                                                return '<span style="color:#900"><b>Indeterminado</b></span>';
                                                                            }
                                                                            else
                                                                            {
                                                                                return '<span style="color:#900"><b>No</b></span>';
                                                                            }
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gDiligencias',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                border:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : false,      
                                                                tbar:	[
                                                                			
                                                                            {
                                                                                icon:'../images/magnifier.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Ver orden de notificaci&oacute;n',
                                                                                handler:function()
                                                                                		{
                                                                                        	mostrarVentanaAperturaNotificacionNotificador(bE('{"idOrden":"'+gE('idOrden').value+'"}'))      
                                                                                        }
                                                                                
                                                                            },'-',
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnAddDiligencia',
                                                                                disabled:true,
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Agregar diligencia',
                                                                                handler:function()
                                                                                        {
                                                                                        	idDiligencia=-1;
                                                                                        	if(nodoSujetoSel==null)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la parte procesal cuya notificaci&oacute;n desea agregar');
                                                                                            	return;
                                                                                            }	
                                                                                        	mostrarVentanaAgregarNotificacion(nodoSujetoSel);
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                hidden:gE('sL').value=='1',
                                                                                id:'btnModifyDiligencia',
                                                                                text:'Modificar diligencia',
                                                                                handler:function()
                                                                                        {
                                                                                            modificarDiligencia();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnDelDiligencia',
                                                                                disabled:true,
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Remover diligencia',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gDiligencias').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la diligencia que desea remover');
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
                                                                                                            gEx('gDiligencias').getStore().remove(fila);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=122&iD='+fila.data.idDiligencia,true);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la diligencia seleccionada?',resp);
                                                                                            return;
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/page_white_stack.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnBuildActa',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Generar acta circunstanciada',
                                                                                handler:function()
                                                                                        {
                                                                                        	function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                var arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                
                                                                                                	if(arrResp[1]=='-1')
                                                                                                    {
                                                                                                    	msgBox('No existe alguna acta en modo de dise&ntilde;o');
                                                                                                    	return;
                                                                                                    }
                                                                                                
                                                                                                    objConf={
                                                                                                                ancho:900,
                                                                                                                alto:500,
                                                                                                                tipoDocumento:214,
                                                                                                                idActa:arrResp[1],
                                                                                                                idFormulario:-1,
                                                                                                                idRegistro:arrResp[1],
                                                                                                                
                                                                                                                urlConfiguracion:'../../modulosEspeciales_SGJP/Scripts/configCKEditorZoom.js',
                                                                                                                functionAfterSignDocument:function()
                                                                                                                						{
                                                                                                                                        	gEx('arbolSujetos').getRootNode().reload();
                                                                                                                                            cerrarActa(arrResp[1]);
                                                                                                                                            
                                                                                                                                            if(window.parent.recargarOrdenesNotificacion)
                                                                                                                                            	window.parent.recargarOrdenesNotificacion();
                                                                                                                                            
                                                                                                                                        },
                                                                                                                functionAfterLoadDocument:function()
                                                                                                                                        {
                                                                                                                                            setTimeout(function()
                                                                                                                                                        {
                                                                                                                                                            var body = CKEDITOR.instances.txtDocumento.editable().$;
                                                                                                                                            
                                                                                                                                                            var value = 113;
        
                                                                                                                                                            body.style.MozTransformOrigin = "top left";
                                                                                                                                                            body.style.MozTransform = "scale(" + (value/100)  + ")";
        
                                                                                                                                                            body.style.WebkitTransformOrigin = "top left";
                                                                                                                                                            body.style.WebkitTransform = "scale(" + (value/100)  + ")";
        
                                                                                                                                                            body.style.OTransformOrigin = "top left";
                                                                                                                                                            body.style.OTransform = "scale(" + (value/100)  + ")";
        
                                                                                                                                                            body.style.TransformOrigin = "top left";
                                                                                                                                                            body.style.Transform = "scale(" + (value/100)  + ")";
                                                                                                                                                            // IE
                                                                                                                                                            body.style.zoom = value/100;
                                                                                                                                                        
                                                                                                                                                            
                                                                                                                                                        },200
                                                                                                                                                    )
                                                                                                                                            
        
                                                                                                                                            
                                                                                                                                        }
                                                                                                                
                                                                                                             };
                                                                                                             
                                                                                                    var idActa =arrResp[1];
                                                                                                    var maxOrden=0;
                                                                                                    var arrFilas=[];
                                                                                                    var x;
                                                                                                    var f;
                                                                                                    var nFilas;
                                                                                                    var nDocumentos;
                                                                                                    var idDocumentosAnexos='';
                                                                                                    for(x=0;x<gEx('gDiligencias').getStore().getCount();x++)
                                                                                                    {
                                                                                                    	f=gEx('gDiligencias').getStore().getAt(x);
                                                                                                        if(f.data.idActa==idActa)
                                                                                                        {
                                                                                                        	arrFilas.push(f);
                                                                                                            if(maxOrden<parseInt(f.data.orden))
                                                                                                            {
                                                                                                            	maxOrden=parseInt(f.data.orden);
                                                                                                            }
                                                                                                        }
                                                                                                        
                                                                                                    }
                                                                                                    
                                                                                                    for(x=1;x<=maxOrden;x++)
                                                                                                    {
                                                                                                    	for(nFilas=0;nFilas<arrFilas.length;nFilas++)
                                                                                                        {
                                                                                                        	f=arrFilas[nFilas];
                                                                                                            if(x==parseInt(f.data.orden))
                                                                                                            {
                                                                                                               	for(nDocumentos=0;nDocumentos<f.data.arrDocumentos.length;nDocumentos++)
                                                                                                               	{
                                                                                                                  	if(idDocumentosAnexos=='')	
                                                                                                                      	idDocumentosAnexos=f.data.arrDocumentos[nDocumentos].idDocumento;
                                                                                                                   	else
                                                                                                                      	idDocumentosAnexos+=','+f.data.arrDocumentos[nDocumentos].idDocumento
                                                                                                                      
                                                                                                               	}
                                                                                                            }
                                                                                                        }
                                                                                                    }    
                                                                                                             
                                                                                                    if(idDocumentosAnexos!='')
                                                                                                    	objConf.documentoAdexos=idDocumentosAnexos;
                                                                                                       
                                                                                                    mostrarVentanaGeneracionDocumentos(objConf);
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=25&idOrden='+gE('idOrden').value,true);
                                                                                        
                                                                                        	
                                                                                        }
                                                                        	},'-',
                                                                            {
                                                                                icon:'../images/lock.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnCerrarActa',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Cerrar orden de notificaci&oacute;n',
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
                                                                                                        	if(window.parent.recargarOrdenesNotificacion)
                                                                                                            	window.parent.recargarOrdenesNotificacion();
                                                                                                            	
                                                                                                            recargarPagina();
                                                                                                            
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=41&iO='+gE('idOrden').value,true);
                                                                                                }
                                                                                        	}
                                                                                            msgConfirm('Est&aacute; seguro de querer cerrar la orden de notificaci&oacute;n',resp);
                                                                                        	
                                                                                        }
                                                                		
                                                                        	}
                                                                        ],                                                          
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    enableRowBody:true,
                                                                                                    getRowClass:formatearFilaDiligencia,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }

                                                        );
                                                        
		tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
        											{
                                                    	gEx('btnModifyDiligencia').disable();
                                        				gEx('btnDelDiligencia').disable();
                                                        
                                                        var nodo=gEx('arbolSujetos').getNodeById('p_'+registro.data.idNombreParteProcesal+'_'+registro.data.idParteProcesal);
                                                        gEx('arbolSujetos').getSelectionModel().select(nodo);
                                                        funcSujeto(nodo);

                                                    	if(parseInt(registro.data.situacionActa)==1)
                                                        {
                                                        	gEx('btnModifyDiligencia').enable();
                                        					gEx('btnDelDiligencia').enable();
                                                        }
                                                    }
        							)                                                        
                                                        
        
        tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
        											{
                                                    	gEx('btnModifyDiligencia').disable();
                                        				gEx('btnDelDiligencia').disable();
                                                    	
                                                    }
        							)
        
        return 	tblGrid;	
}

function formatearFilaDiligencia(registro, numFila, rp, ds)
{
	var lblResponsableDiligencia='<?php echo $_SESSION["nombreUsr"]?>';
    if(parseInt(registro.data.idResponsableDiligencia)==0)
    {
    	lblResponsableDiligencia+=': '+registro.data.lblOtroResponsable;
    }
    
    var tblMedioNotificacion='';
    var x;
    var fila;
    var leyenda='';
    var leyendaResultado='';
    tblMedioNotificacion='<table width="800">';
    
    for(x=0;x<registro.data.arrMediosNotificacion.length;x++)
    {
    	fila=registro.data.arrMediosNotificacion[x];   
                                                                     
        leyenda=formatearValorRenderer(aMediosNotificacionCatalogo,fila.idMedio);
        if(fila.detalle1!='')
        {
            leyenda+=' - ';
            leyenda+=formatearValorRenderer(aMediosNotificacionDetalle2,fila.detalle1);
        }
        
        if(fila.detalle2!='')
        {
            leyenda+=' - ';
            leyenda+=formatearValorRenderer(aMediosNotificacionDetalle2,fila.detalle2);
        }
        
        if(fila.detalle3!='')
        {
            leyenda+=': ';
            leyenda+=fila.detalle3;
        }
        var objDiligencia=eval('['+bD(registro.data.objDiligencia)+']')[0];

        if(objDiligencia.arrSeguimientoTelefonico)
        {
        	
        	var registroSeguimiento=objDiligencia.arrSeguimientoTelefonico[0];
        	var lblDetalle='';
            var oDetalle=registroSeguimiento.detalle;
            oDetalle=eval('['+bD(oDetalle)+']')[0];
            
            if(registroSeguimiento.situacion!='2')
            {
                
                if(oDetalle.obtuvoRespuesta=='1')
                {
                    lblDetalle='Se obtuvo respuesta: '+formatearValorRenderer(arrRespNotificacion1,oDetalle.respuestaObtenida);
                }
                else
                {
                	if(oDetalle.motivoNoRespuesta=='3')
                    	lblDetalle='NO se obtuvo respuesta, motivo: '+decodeURIComponent(oDetalle.motivoNoRespuestaEspecifique)+'. ';
	                   else
                    
                    	lblDetalle='NO se obtuvo respuesta, motivo: '+formatearValorRenderer(arrRespNotificacion2,oDetalle.motivoNoRespuesta)+'. ';

                    
                    if(oDetalle.programarLlamada!='')
                    {
                        if(oDetalle.programarLlamada=='0')
                        {
                            lblDetalle+=' No se programa pr&oacute;xima llamada';
                        }
                        else
                        {
                            lblDetalle+=' Se programa pr&oacute;xima llamada: '+Date.parseDate(oDetalle.fechaProximaLlamada+' '+
                                        oDetalle.horaProximaLlamada,'Y-m-d H:i').format('d/m/Y H:i')+' hrs.';
                            if(oDetalle.detallesProximaLlamada.trim()!='')
                            {
                                lblDetalle+='<br><b>Detalles adicionales: </b>&nbsp;'+oDetalle.detallesProximaLlamada;
                            }
                        }
                    }
                }
                
            }
            else
            {
                
                  lblDetalle+='Se espera resultado de la llamada.';
                  if(oDetalle && oDetalle.detallesProximaLlamada && oDetalle.detallesProximaLlamada.trim()!='')
                  {
                      lblDetalle+='<br><b>Detalles adicionales: </b>&nbsp;'+decodeURIComponent(oDetalle.detallesProximaLlamada);
                  }
                
            }

            leyendaResultado=lblDetalle;
        }
        else
        {
        	if(objDiligencia.resultadoMail)
            {
            	leyendaResultado=formatearValorRenderer(arrResultadoMail,objDiligencia.resultadoMail);
            }
            else
            {
                if(objDiligencia.resultadoDiligencia)
                {
                    leyendaResultado=formatearValorRenderer(arrResultadoDiligencia,objDiligencia.resultadoDiligencia,1,true);
                    if(objDiligencia.resultadoDiligencia=='2')
                    {
                        leyendaResultado+=' (Pr&oacute;xima diligencia: '+Date.parseDate(objDiligencia.fecha2daVisita+' '+objDiligencia.hora2daVisita,'Y-m-d H:i').format('d/m/Y H:i')+' hrs.)';
                    }
                    
                    if((objDiligencia.resultado2daVisita)&&(objDiligencia.resultado2daVisita!=''))
                    {
                        leyendaResultado+='<br><b>Resultado de la segunda diligencia: </b>'+formatearValorRenderer(arrResultadoDiligencia2daVisita,objDiligencia.resultado2daVisita,1,true);
                    }
                    else
                    {
                        if((objDiligencia.resultadoDiligencia=='2') && (objDiligencia.resultado2daVisita==''))
                            leyendaResultado+='<br><b>Resultado de la segunda diligencia:</b> En espera de resultado';
                    }
                    
                }
                else
                    leyendaResultado=formatearValorRenderer(arrResultadoDiligenciasMP,fila.resultado,1,true);
            }
        }
        
        var leyendaCentral='';
        if(registro.data.seEnviaCentralNotificadores=='1')
        {
        	var resultado='';
            if(registro.data.enviadoCentralNotificadores=='1')
            {
            	resultado='&nbsp;<img src="../images/icon_big_tick.gif" width="13" height="13"> Env&iacute;o correcto (Folio de env&iacute;o: '+registro.data.idAcuseEnvioCentralNotificadores+')';
            }
            else
            {
            	
            	resultado='&nbsp;<img src="../images/cross.png" width="13" height="13"> <span style="color:#900">Env&iacute;o fallido</span> &nbsp;&nbsp;'+
                			'<a href="javascript:reenviarDiligenciaCentralNotificadores(\''+bE(registro.data.idDiligencia)+
                            '\')"><img src="../images/arrow_refresh.PNG" width="14" height="14" title="Reenviar a central de notificadores"></a>';
            
            }
        	leyendaCentral='<br>[&nbsp;<img src="../images/users.png" > Enviado a central de notificadores&nbsp;]: '+resultado+'';
            //leyendaResultado+='<br>[&nbsp;<img src="../images/users.png"> Enviado a central de notificadores&nbsp;]';
        }
       	tblMedioNotificacion+='<tr height="21"><td><span class="TSJDF_Control">'+leyenda+leyendaCentral+'<br><b>Resultado:</b> '+leyendaResultado+'</span></td></tr>';
    }
    tblMedioNotificacion+='</table>';
	var lblTable='<br><table width="100%">'+
    			'<tr height="21"><td width="40"></td><td width="150"><span class="TSJDF_Etiqueta">Responsable de la diligencia:</span></td>'+
                '<td width="750"><span class="TSJDF_Control">'+lblResponsableDiligencia+'</span></td></tr>'+
                '<tr height="21"><td ></td><td colspan="1"><span class="TSJDF_Etiqueta">Medios de notificaci&oacute;n:</span></td><td>'+tblMedioNotificacion+'</td></tr>'+
    			'<tr height="21"><td ></td><td colspan="2"><span class="TSJDF_Etiqueta">Exposici&oacute;n diligencia:</span></td></tr>'+
    			'<tr height="21"><td></td><td style="text-align:justify" colspan="2"><span class="TSJDF_Control">'+registro.data.exposicionDiligencia+'</span></td></tr>'+
                '</table><br>';
    rp.body=lblTable;	
    return 'x-grid3-row-expanded';
    
    
}

function cerrarActa(iA)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gDiligencias').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=26&idActa='+iA,true);
}

function mostrarVentanaCorreo()
{
	if(gE('configuradoSMTP').value=='0')
    {
    	function resp()
        {
        	mostrarVentanaConfiguracionCorreoSaliente(true);
        }
        msgBox('Primero debe configurar su servidor de correo saliente',resp);
    	return;
    }

	var lblAsunto=gEx('cmbTipoDiligencia').getRawValue().toUpperCase()+' '+nodoSujetoSel.attributes.nombre.toUpperCase()+' CARPETA '+gE('carpetaJudicial').value;
	arrMailDestinatario=[];
    arrMailAdjuntos=[];
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Email destinatario:'
                                                        },
                                                        {	x:140,
                                                        	y:5,
                                                            xtype:'label',
                                                            width:520,
                                                            height:40,
                                                            html:'<div id="txtDestinatario" style="width:520px;height:50px;background-color:#FFF; border-width: 1px;border-color:#000;border-style:solid;overflow: auto;"></div>'
                                                            
                                                        },
                                                        {
                                                            icon:'../images/add.png',
                                                            cls:'x-btn-text-icon',
                                                            x:670,
                                                            y:5,
                                                            width:100,
                                                            xtype:'button',
                                                            text:'Agregar mail...',
                                                            handler:function()
                                                                    {
                                                                        mostrarVentanaAgregarMailExistente();
                                                                    }
                                                            
                                                        }
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:75,
                                                            html:'Asunto:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:70,
                                                            xtype:'textfield',
                                                            width:520,
                                                            value:lblAsunto,
                                                            id:'txtAsunto'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:105,
                                                            html:'Documentos adjuntos:'
                                                        },
                                                        {	x:140,
                                                        	y:100,
                                                            xtype:'label',
                                                            width:520,
                                                            height:40,
                                                            html:'<div id="txtAdjuntos" style="width:520px;height:50px;background-color:#FFF; border-width: 1px;border-color:#000;border-style:solid;overflow: auto;"></div>'
                                                            
                                                        },
                                                        {
                                                            icon:'../images/add.png',
                                                            cls:'x-btn-text-icon',
                                                            x:670,
                                                            y:100,
                                                            width:100,
                                                            xtype:'button',
                                                            text:'Agregar documento...',
                                                            handler:function()
                                                                    {
                                                                        mostrarVentanaDocumentosEmail();
                                                                    }
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:170,
                                                            id:'txtCuerpoMail',
                                                            xtype:'htmleditor',
                                                            width:780,
                                                            height:'300'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Enviar correo',
										width: 830,
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
                                                                	var gMail=gEx('gMail');
                                                                    var x;
                                                                    var fila;
                                                                    for(x=0;x<gMail.getStore().getCount();x++)
                                                                    {
                                                                    	fila=gMail.getStore().getAt(x);
                                                                        arrMailDestinatario.push(fila.data.mail);    
                                                                            
                                                                    }
                                                                    
                                                                    renderizarCorreos(arrMailDestinatario);
                                                                    
                                                                    arrMailAdjuntos=eval(bD(gE('arrDocumentosOrdenNotificacion').value));
                                                                    renderizarDocumento(arrMailAdjuntos);
                                                                    var cadObj='{"medio":"'+nodoMedioSel.id+'","tipoDiligencia":"'+gEx('cmbTipoDiligencia').getValue()+'","tDiligencia":"'+
                                                                    			gEx('cmbTipoDiligencia').getRawValue()+'","carpetaJudicial":"'+gE('carpetaJudicial').value+
                                                                                '","detallePersona":"'+gEx('cmbDetalleFigura').getValue()+'"}';
                                                                    
                                                                    function funcAjax()
                                                                    {
                                                                        var resp=peticion_http.responseText;
                                                                        arrResp=resp.split('|');
                                                                        if(arrResp[0]=='1')
                                                                        {
                                                                            gEx('txtCuerpoMail').setValue(bD(arrResp[1]));
                                                                        }
                                                                        else
                                                                        {
                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                        }
                                                                    }
                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=29&cadObj='+cadObj,true);
                                                                    
																}
															}
												},
										buttons:	[
														{
															
															text: 'Enviar',                                                            
															handler: function()
																	{
																		function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	var x;
                                                                                var aDestinatarios='';
                                                                                for(x=0;x<arrMailDestinatario.length;x++)
                                                                                {
                                                                                	if(aDestinatarios=='')
                                                                                    	aDestinatarios=arrMailDestinatario[x];
                                                                                    else
                                                                                    	aDestinatarios+=','+arrMailDestinatario[x];
                                                                                }
                                                                                
                                                                                
                                                                                var aAdjuntos='';
                                                                                for(x=0;x<arrMailAdjuntos.length;x++)
                                                                                {
                                                                                	if(aAdjuntos=='')
                                                                                    	aAdjuntos=arrMailAdjuntos[x][0];
                                                                                    else
                                                                                    	aAdjuntos+=','+arrMailAdjuntos[x][0];
                                                                                }
                                                                                
                                                                                
                                                                                
                                                                            	var cadObj='{"idOrden":"'+gE('idOrden').value+'","tipoNotificacion":"'+nodoMedioSel.id+
                                                                                		'","idParticipante":"'+idParticipanteSel+'","destinatario":"'+aDestinatarios+
                                                                                        '","asunto":"'+cv(gEx('txtAsunto').getValue())+'","documentosAdjuntos":"'+aAdjuntos+
                                                                                        '","cuerpoMail":"'+cv(gEx('txtCuerpoMail').getValue())+'"}';
                                                                            
                                                                            	function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        gEx('gMailsEnviados').getStore().reload();
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=35&cadObj='+cadObj,true);
                                                                                
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer enviar el correo al destinatario',resp);
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

function renderizarCorreos(arrMails)
{
	var x;
    var lblMails='';
    var oMail='';
    for(x=0;x<arrMails.length;x++)
    {
    	oMail=arrMails[x]+' <a href="javascript:removerDestinatario(\''+bE(arrMails[x])+'\')"><img src="../images/delete.png"></a>';
        if(lblMails=='')
        	lblMails=oMail;
        else
        	lblMails+=','+oMail;
    }	
    
    gE('txtDestinatario').innerHTML=lblMails;
}

function removerDestinatario(m)
{
	var pos=existeValorArreglo(arrMailDestinatario,bD(m));
    arrMailDestinatario.splice(pos,1);
    renderizarCorreos(arrMailDestinatario);
}

function mostrarVentanaAgregarMailExistente()
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
                                                            html:'Seleccione las direcciones de correo electr&oacute;nico que desea agregar:'
                                                        },
                                                        crearGridMailEmail()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar mail',
										width: 500,
										height:320,
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
                                                                	var gMailCorreo=gEx('gMailCorreo');
                                                                    var gMail=gEx('gMail');
                                                                    var x;
                                                                    for(x=0;x<gMail.getStore().getCount();x++)
                                                                    {
                                                                    	gMailCorreo.getStore().add(gMail.getStore().getAt(x).copy());
                                                                    }
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
																		var filas=gEx('gMailCorreo').getSelectionModel().getSelections();
                                                                        var x;
                                                                        var fila;
                                                                        var pos;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	fila=filas[x];
                                                                            pos=existeValorArreglo(arrMailDestinatario,fila.data.mail);
                                                                            if(pos==-1)
                                                                            {
                                                                            	arrMailDestinatario.push(fila.data.mail);
                                                                            }
                                                                        }
                                                                        renderizarCorreos(arrMailDestinatario);
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

function crearGridMailEmail()
{
	
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'mail'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
                                                        {
															header:'E-Mail',
															width:300,
															sortable:true,
															dataIndex:'mail',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gMailCorreo',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:180,
                                                            width:430,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Registar nuevo E-Mail',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaRegistrarNuevoMail();
                                                                                    	
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function mostrarVentanaRegistrarNuevoMail()
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
                                                            html:'E-mail:'
                                                        },
                                                        {
                                                        	x:110,
                                                            y:5,
                                                            id:'txtMailAgregar',
                                                            xtype:'textfield',
                                                            width:350
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registrar nuevo E-Mail',
										width: 500,
										height:120,
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
                                                                	gEx('txtMailAgregar').focus(false,500);
                                                                    
                                                                    
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(!validarCorreo(gEx('txtMailAgregar').getValue()))
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('txtMailAgregar').focus();
                                                                            }
                                                                            msgBox('El correo ingresado NO es v&aacute;lido',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var pos=obtenerPosFila(gEx('gMail').getStore(),'mail',gEx('txtMailAgregar').getValue().trim());
                                                                        if(pos==-1)
                                                                        {
                                                                        
                                                                        	var cadObj='{"idParticipante":"'+(nodoSujetoSel.id.split('_')[1])+'","mail":"'+gEx('txtMailAgregar').getValue().trim()+'"}';
                                                                        	function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	funcSujeto(nodoSujetoSel);
                                                                                    arrMailDestinatario.push(gEx('txtMailAgregar').getValue().trim());
                                                                                    renderizarCorreos(arrMailDestinatario);
                                                                                    
                                                                                    var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'mail'}
                                                                                                                    ]
                                                                                        						)
                                                                                    var r=new reg	(
                                                                                                        {
                                                                                                            mail:gEx('txtMailAgregar').getValue().trim()
                                                                                                        }
                                                                                                    )
                                                                               
                                                                                    gEx('gMailCorreo').getStore().add(r);
                                                                                    ventanaAM.close();
                                                                                    
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=28&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
                                                                        	
                                                                        }
                                                                        else
                                                                        {
                                                                        	pos=existeValorArreglo(arrMailDestinatario,gEx('txtMailAgregar').getValue().trim());
                                                                            if(pos==-1)
                                                                            {
                                                                            	arrMailDestinatario.push(gEx('txtMailAgregar').getValue().trim());
                                                                                renderizarCorreos(arrMailDestinatario);
                                                                            }
                                                                            ventanaAM.close();
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
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

function mostrarVentanaDocumentosEmail()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridDocumentosEmail()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vAgregarDocumentoAdjunto',
										title: 'Agregar documento adjunto',
										width: 950,
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
                                                            
															handler: function()
																	{
                                                                    	var listaDocumentos='';
																		var filas=gEx('gridDocumentosEmail').getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos un documento que adjuntar');
                                                                        	return;
                                                                        }
                                                                        var x;
                                                                        var f;
                                                                        var pos;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                        	pos=existeValorMatriz(arrMailAdjuntos,f.data.idDocumento);
                                                                            if(pos==-1)
	                                                                        	arrMailAdjuntos.push([f.data.idDocumento,f.data.nomArchivoOriginal]);
                                                                        	
                                                                        }
                                                                        renderizarDocumento(arrMailAdjuntos);
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
    dispararEventoSelectCombo('cmbOridenDocumentosEmail');
}

function crearGridDocumentosEmail()
{
	var cmbOridenDocumentos=crearComboExt('cmbOridenDocumentosEmail',[['1','Carpeta Judicial'],['2','Orden de notificaci\xF3n']],0,0,250);
    cmbOridenDocumentos.setValue('1');
    cmbOridenDocumentos.on('select',function(cmb,registro)
    								{
                                    	switch(parseInt(registro.data.id))
                                        {
                                        	case 1:
                                            	urlConsultaDocumentos='../paginasFunciones/funcionesModulosEspeciales_SGP.php';  
                                            	gEx('gridDocumentosEmail').getStore().load	(
                                                                                                {
                                                                                                    params:	{
                                                                                                                funcion:19,
                                                                                                                cA:bE(gE('carpetaJudicial').value),
                                                                                                                idCarpetaAdministrativa:gE('idCarpeta').value
                                                                                                            }
                                                                                                }
                                                                                            )
                                            	
                                            break;
                                            case 2:
                                            	urlConsultaDocumentos='../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'; 
                                            	gEx('gridDocumentosEmail').getStore().load	(
                                                                                                {
                                                                                                    params:	{
                                                                                                                funcion:34,
                                                                                                                iO:gE('idOrden').value
                                                                                                            }
                                                                                                }
                                                                                            )
                                            	
                                            break;
                                        }
                                    }
    					)
    
    
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
                                                        {name:'idFormulario'},
                                                        {name:'idRegistro'},
                                                        {name:'idDocumento'},
                                                        {name: 'categoriaDocumentos'}
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
                                                sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                groupField: 'fechaRegistro',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:false
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.proxy.conn.url=urlConsultaDocumentos;
                                    }
                        )   
       
    
    
    var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'date', dataIndex: 'fechaCreacion'},
                                                                        {type: 'string', dataIndex: 'nomArchivoOriginal'},
                                                                        {type: 'list', dataIndex: 'categoriaDocumentos', phpMode:true, options:arrCategorias}
                                                                    ]
                                                    }
                                                );    
       
   

	var chkRow=new Ext.grid.CheckboxSelectionModel();
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	new  Ext.grid.RowNumberer({width:30}),
                                                        chkRow,
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" />'
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:120,
                                                            sortable:true,
                                                            dataIndex:'fechaRegistro',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y');
                                                                    }
                                                        },
                                                        {
                                                            header:'Tipo documento',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'categoriaDocumentos',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCategorias,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Etapa procesal',
                                                            width:250,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'etapaProcesal',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasProcesales,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Documento',
                                                            width:420,
                                                            sortable:true,
                                                            dataIndex:'nomArchivoOriginal',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        
                                                        {
                                                            header:'Tama&ntilde;o',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'tamano',
                                                            renderer:function(val)
                                                            		{
                                                                    	return bytesToSize(parseInt(val),0);
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridDocumentosEmail',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            sm:chkRow,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            tbar:	[
                                                            			{
                                                                        	xtype:'label',
                                                                            html:'<b>Origen de los documentos:&nbsp;&nbsp;</b>'
                                                                        },
                                                                        cmbOridenDocumentos,'-',
                                                                        {
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Adjuntar documento',
                                                                            handler:function()
                                                                                    {
                                                                                        mostrarVentanaAdjuntarDocumentoEmail()
                                                                                    }
                                                                            
                                                                        }
                                                            		],
                                                            columnLines : true,  
                                                            plugins:[filters],   
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'<span style="color:#900"><b>{text}</b> ({[values.rs.length]} {[values.rs.length > 1 ? "Documentos" : "Documento"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    
	
    
    
    tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                  	mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  )                                                    
                                                    
    return 	tblGrid;	
}

function mostrarVentanaAdjuntarDocumentoEmail()
{
	   					
					
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:10,
                                                            html:'Ingrese el documento a adjuntar:'
                                                        },
                                                        {
                                                            x:185,
                                                            y:5,
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:480,
                                                            y:6,
                                                            id:'btnUploadFile',
                                                            xtype:'button',
                                                            text:'Seleccionar...',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
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
                                                            y:40,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:10,
                                                            y:70,
                                                            width:600,
                                                            height:60,
                                                            id:'txtDescripcion'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Adjuntar documento',
										width: 650,
                                        id:'vDocumentoMail',
										height:220,
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
                                                                
                                                                	var cObj={
                                                                    // Backend settings
                                                                                            upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                            file_post_name: "archivoEnvio",
                                                                             
                                                                                            // Flash file settings
                                                                                            file_size_limit : "1000 MB",
                                                                                            file_types : "*.pdf;*.jpg;*.jpeg;*.gif;*.png",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                            file_types_description : "Todos los archivos",
                                                                                            file_upload_limit : 0,
                                                                                            file_queue_limit : 1,
                                                                             
                                                                                            
                                                                                            upload_success_handler : subidaCorrectaEmail
                                                                                        };
                                                                
																	crearControlUploadHTML5(cObj);
                                                                }
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	
                                                                        
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                             msgBox('Debe ingresar el documento que desea adjuntar');
                                                                            return;
                                                                        }
                                                                        uploadControl.start();
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

function subidaCorrectaEmail(file, serverData) 
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
        
        
        
        var cadObj='{"carpetaAdministrativa":"'+gE('carpetaJudicial').value+'","idFormulario":"-1","idRegistro":"-1","idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+
        '","tipoDocumento":"6","descripcion":"'+cv(gEx('txtDescripcion').getValue())+'","idOrden":"'+gE('idOrden').value+'","esDocumentoAdjuntoMail":"1"}';
    
        function funcAjax2(peticion_http)
        {
            var resp=peticion_http.responseText;
            
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                arrMailAdjuntos.push([arrResp[1],arrResp[2]]);  
                renderizarDocumento(arrMailAdjuntos);
                gEx('vDocumentoMail').close(); 
                gEx('vAgregarDocumentoAdjunto').close();    
                                                                                
            }
            else
            {
                
                msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
            }
        }
        obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax2, 'POST','funcion=8&cadObj='+cadObj,false);
    }
}

function renderizarDocumento(arrDocumentos)
{

	var x;
    var lblDocumentos='';
    var oDoc='';
    for(x=0;x<arrDocumentos.length;x++)
    {
    	oDoc='<a href="javascript:visualizarDocumento(\''+bE(arrDocumentos[x][0])+'\')">'+arrDocumentos[x][1]+'</a> <a href="javascript:removerDocumento(\''+bE(arrDocumentos[x][0])+'\')"><img src="../images/delete.png"></a>';
        if(lblDocumentos=='')
        	lblDocumentos=oDoc;
        else
        	lblDocumentos+=', '+oDoc;
    }	
    
    gE('txtAdjuntos').innerHTML=lblDocumentos;
}

function removerDocumento(m)
{
	var pos=existeValorMatriz(arrMailAdjuntos,bD(m));
    arrMailAdjuntos.splice(pos,1);
    renderizarDocumento(arrMailAdjuntos);
}

function visualizarDocumento(iD)
{
	var pos=existeValorMatriz(arrMailAdjuntos,bD(iD));
    var arrDocumentos=arrMailAdjuntos[pos][0][1].split('.');
    var extension=arrDocumentos[arrDocumentos.length-1];
    mostrarVisorDocumentoProceso(extension,arrMailAdjuntos[pos][0]);
}

function mostrarVentanaConfiguracionCorreoSaliente(mVentanaCorreo)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'fieldset',
                                                            x:10,
                                                            y:0,
                                                            defaultType: 'label',
                                                            width:570,
                                                            height:160,
                                                            title:'Configuraci&oacute;n de correo entrante',
                                                            layout:'absolute',
                                                            items:	[
                                                            			{
                                                                            x:10,
                                                                            y:10,
                                                                            html:'Host servidor IMAP:'
                                                                        },
                                                                        {
                                                                            x:180,
                                                                            y:5,
                                                                            xtype:'textfield',
                                                                            width:300,
                                                                            value:'imap.gmail.com',
                                                                            id:'hostIMAP'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:40,
                                                                            html:'Puerto:',
                                                                            
                                                                        },
                                                                        {
                                                                            x:180,
                                                                            y:35,
                                                                            xtype:'numberfield',
                                                                            allowDecimals:false,
                                                                            allowNegative:false,
                                                                            width:60,
                                                                            value:'993',
                                                                            id:'puertoIMAP'
                                                                        },
                                                                       
                                                                        {
                                                                            x:270,
                                                                            y:35,
                                                                            xtype:'checkbox',
                                                                            id:'chkSSL',
                                                                            boxLabel:'Utilizar SSL'
                                                                        },
                                                                        {
                                                                        
                                                                            x:10,
                                                                            y:70,
                                                                            html:'Usuario:'
                                                                        },
                                                                        {
                                                                            x:180,
                                                                            y:65,
                                                                            xtype:'textfield',
                                                                            width:300,
                                                                            value:'',
                                                                            id:'txtUsuario'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:100,
                                                                            html:'Contrase&ntilde;a:'
                                                                        },
                                                                        {
                                                                            x:180,
                                                                            y:95,
                                                                            xtype:'textfield',
                                                                            width:120,
                                                                            value:'',
                                                                            inputType: 'password',
                                                                            id:'txtPassword'
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'fieldset',
                                                            x:10,
                                                            y:170,
                                                            defaultType: 'label',
                                                            width:570,
                                                            height:120,
                                                            title:'Configuraci&oacute;n de correo saliente',
                                                            layout:'absolute',
                                                            items:	[
                                                            			{
                                                                            x:10,
                                                                            y:10,
                                                                            html:'Host servidor SMTP:'
                                                                        },
                                                                        {
                                                                            x:180,
                                                                            y:5,
                                                                            xtype:'textfield',
                                                                            width:300,
                                                                            value:'smtp.gmail.com',
                                                                            id:'hostSMTP'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:40,
                                                                            html:'Puerto:',
                                                                            
                                                                        },
                                                                        {
                                                                            x:180,
                                                                            y:35,
                                                                            xtype:'numberfield',
                                                                            allowDecimals:false,
                                                                            allowNegative:false,
                                                                            width:60,
                                                                            value:'25',
                                                                            id:'puertoSMTP'
                                                                        },
                                                                       
                                                                        {
                                                                            x:270,
                                                                            y:35,
                                                                            xtype:'checkbox',
                                                                            id:'chkAutenticacion',
                                                                            boxLabel:'Utilizar autenticaci&oacute;n'
                                                                        }
                                                            		]
                                                         }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n servidor de correo saliente',
										width: 630,
										height:380,
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
                                                                		function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var arrDatos=eval(bD(arrResp[1]));
                                                                                if(arrDatos.length>0)
                                                                                {
                                                                                	var hostIMAP=gEx('hostIMAP');
                                                                                    var puertoIMAP=gEx('puertoIMAP');
                                                                                    var txtUsuario=gEx('txtUsuario');
                                                                                    var txtPassword=gEx('txtPassword');
                                                                                    
                                                                                    var hostSMTP=gEx('hostSMTP');
                                                                                    var puertoSMTP=gEx('puertoSMTP');
                                                                                    
                                                                                    
                                                                                    
                                                                                    hostIMAP.setValue(arrDatos[0].hostIMAP);
                                                                                    puertoIMAP.setValue(arrDatos[0].puertoIMAP);
                                                                                    txtUsuario.setValue(arrDatos[0].mail);
                                                                                    gEx('chkSSL').setValue(arrDatos[0].utilizarSSL=='1');
                                                                                    hostSMTP.setValue(arrDatos[0].hostSMTP);
                                                                                    puertoSMTP.setValue(arrDatos[0].puertoSMTP);
                                                                                    gEx('chkAutenticacion').setValue(arrDatos[0].autenticacionSMTP=='1');
                                                                                    
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=31&u=<?php echo bE($_SESSION["idUsr"])?>',true);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var hostIMAP=gEx('hostIMAP');
                                                                        var puertoIMAP=gEx('puertoIMAP');
                                                                        var txtUsuario=gEx('txtUsuario');
                                                                        var txtPassword=gEx('txtPassword');
                                                                        
                                                                        var hostSMTP=gEx('hostSMTP');
                                                                        var puertoSMTP=gEx('puertoSMTP');
                                                                        
                                                                        
                                                                        if(hostIMAP.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	hostIMAP.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la URL del servidor de correo entrante',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(puertoIMAP.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	puertoIMAP.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el puerto del servidor de correo entrante',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(txtUsuario.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtUsuario.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el usuario para el servidor de correo saliente',resp3);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(txtPassword.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	txtPassword.focus();
                                                                            }
                                                                           	msgBox('Debe ingresar la contrase&ntilde;a para el servidor de correo saliente',resp4);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(hostSMTP.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	hostSMTP.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la URL del servidor de correo saliente',resp5);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(puertoSMTP.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	puertoSMTP.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el puerto del servidor de correo saliente',resp6);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idUsuario":"<?php echo $_SESSION["idUsr"]?>","hostIMAP":"'+cv(hostIMAP.getValue())+
                                                                        '","puertoIMAP":"'+puertoIMAP.getValue()+'","usuario":"'+cv(txtUsuario.getValue())+
                                                                        '","passwd":"'+bE(txtPassword.getValue())+'","utilizarSSL":"'+
                                                                        (gEx('chkSSL').getValue()?'1':0)+'","hostSMTP":"'+cv(hostSMTP.getValue())+
                                                                        '","puertoSMTP":"'+puertoSMTP.getValue()+'","autenticacionSMTP":"'+
                                                                        (gEx('chkAutenticacion').getValue()?'1':0)+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gE('configuradoSMTP').value='1';
                                                                                ventanaAM.close();
                                                                                if(mVentanaCorreo)
	                                                                                mostrarVentanaCorreo();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=30&cadObj='+cadObj,true);
                                                                        
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

function crearGridSeguimientoTelefonico(id)
{
	
	 
                                                                                      
	var alDatos=new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'telefono'},
                                                                    {name: 'fechaDiligencia', type:'date', dateFormat:'Y-m-d H:i'},
                                                                    {name: 'detalle'},
                                                                    {name: 'situacion'}
                                                                ]
                                                    }
                                                );
	  
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:false,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	var lblSituacion='';
                                                                        	switch(val)
                                                                            {
                                                                            	case '0':
                                                                                	lblSituacion='<img src="../images/cancel_round.png" width="14" height="14" title="No se contact&oacute; a la persona" alt="No se contact&oacute; a la persona"/>';
                                                                                break;
                                                                                case '1':
                                                                                	lblSituacion='<img src="../images/accept_green.png" width="14" height="14" title="Se contact&oacute; a la persona" alt="Se contact&oacute; a la persona"/>';
                                                                                break;
                                                                                case '2':
                                                                                	lblSituacion='<img src="../images/control_pause.png" width="14" height="14" title="En espera de resultado de llamada" alt="En espera de resultado de llamada"/>';
                                                                                break;
                                                                            }
                                                                            
                                                                            return lblSituacion;
                                                                            
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha diligencia',
                                                                width:150,
                                                                sortable:false,
                                                                dataIndex:'fechaDiligencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i')
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Llamada a',
                                                                width:350,
                                                                sortable:false,
                                                                dataIndex:'telefono',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gSeguimiento_'+id,
                                                                store:alDatos,
                                                                x:10,
                                                                y:40,
                                                                height:205,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                id:'btnAddDiligenciaLlamada_'+id,
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar diligencia',
                                                                                handler:function()
                                                                                        {
                                                                                        	if(tblGrid.getStore().getCount()>0)
                                                                                            {
                                                                                                var fila=tblGrid.getStore().getAt(0);
                                                                                                if(fila.data.situacion=='2')
                                                                                                {
                                                                                                    msgBox('Primero debe registrar el resultado de la &uacute;ltima diligencia');
                                                                                                    return;
                                                                                                }
																							}                                                                                        
                                                                                         	mostrarVentanaDiligenciaTelefonica(null,'gSeguimiento_'+id);   
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnModifyDiligenciaLlamada_'+id,
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                text:'Modificar diligencia',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gSeguimiento_'+id).getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la diligencia que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            mostrarVentanaDiligenciaTelefonica(fila,'gSeguimiento_'+id);   
                                                                                        }
                                                                                
                                                                            }
                                                                            ,'-',
                                                                            {
                                                                            	id:'btnDelDiligenciaLlamada_'+id,
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                text:'Remover diligencia',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gSeguimiento_'+id).getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la diligencia que desea eliminar');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	gEx('gSeguimiento_'+id).getStore().remove(fila);
                                                                                                    gEx('btnModifyDiligenciaLlamada_'+id).disable();
                                                            										gEx('btnDelDiligenciaLlamada_'+id).disable();
                                                                                                }
                                                                                                
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la diligencia seleccionada?',resp);
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                        ],
                                                                view:new Ext.grid.GridView({
                                                                                                    
                                                                                                    enableRowBody:true,
                                                                                                    getRowClass:formatearFilaLlamada
                                                                                                    
                                                                                                })
                                                            }
                                                        );
        
        
        tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,r)
        											{
                                                    	if(nFila==0)
                                                        {
                                                        	gEx('btnModifyDiligenciaLlamada_'+id).enable();
                                                            gEx('btnDelDiligenciaLlamada_'+id).enable();
                                                        }
                                                        else
                                                        {
                                                        	gEx('btnModifyDiligenciaLlamada_'+id).disable();
                                                            gEx('btnDelDiligenciaLlamada_'+id).disable();
                                                        }
                                                      
                                                    }
        								)
        
        return 	tblGrid;
}

function formatearFilaLlamada(registro, numFila, rp, ds)
{
	var lblDetalle='';
	var oDetalle=registro.data.detalle;
    oDetalle=eval('['+bD(oDetalle)+']')[0];
    if(registro.data.situacion!='2')
    {
    	
		if(oDetalle.obtuvoRespuesta=='1')
        {
        	lblDetalle='Se obtuvo respuesta: '+formatearValorRenderer(arrRespNotificacion1,oDetalle.respuestaObtenida);
        }
        else
        {
        	lblDetalle='NO se obtuvo respuesta, motivo: '+formatearValorRenderer(arrRespNotificacion2,oDetalle.motivoNoRespuesta)+'. ';
            if(oDetalle.motivoNoRespuestaEspecifique!='')
            	lblDetalle+=' ('+oDetalle.motivoNoRespuestaEspecifique+').';
            if(oDetalle.programarLlamada!='')
            {
                if(oDetalle.programarLlamada=='0')
                {
                    lblDetalle+=' No se programa pr&oacute;xima llamada';
                }
                else
                {
                    lblDetalle+=' Se programa pr&oacute;xima llamada: '+Date.parseDate(oDetalle.fechaProximaLlamada+' '+
                                oDetalle.horaProximaLlamada,'Y-m-d H:i').format('d/m/Y H:i')+' hrs.';
                    if(oDetalle.detallesProximaLlamada.trim()!='')
                    {
                        lblDetalle+='<br /><b>Detalles adicionales: </b>&nbsp;'+oDetalle.detallesProximaLlamada;
                    }
                }
        	}
        }
        
    }
    else
    {
       	lblDetalle+='Se espera resultado de la llamada. ';
        if(oDetalle && oDetalle.detallesProximaLlamada && oDetalle.detallesProximaLlamada.trim()!='')
        {
            lblDetalle+='<br /><b>Detalles adicionales: </b>&nbsp;'+decodeURIComponent(oDetalle.detallesProximaLlamada);
        }
    }
	var lblTable='<br><table ><tr><td style="width:20px"></td><td style="width:530px"><span>'+lblDetalle+
                '</span></td></tr></table><br>';
    rp.body=lblTable;	
    return 'x-grid3-row-expanded';
    
    
}

function mostrarVentanaDiligenciaTelefonica(fila,idGrid)
{
	var cmbHora=crearComboExt('cmbHora',arrTiempo,265,5,115);
   	cmbHora.setValue(new Date().format('H:i'));
    var arrTelefonosContacto=[];
    var x;
    var filaTel;
    var lblTelefono;
    for(x=0;x<gEx('gTelefonos').getStore().getCount();x++)
    {
    	filaTel=gEx('gTelefonos').getStore().getAt(x);
        lblTelefono='';
        if(filaTel.data.lada!='')
        {
        	lblTelefono+='('+filaTel.data.lada+') ';
        }
        lblTelefono+=filaTel.data.numero;
        
        if(filaTel.data.extension!='')
        {
        	lblTelefono+=' Ext. '+fila.data.extension;
        }
        lblTelefono+=' ['+formatearValorRenderer(arrTelefonos,filaTel.data.tipoTelefono)+']';
        arrTelefonosContacto.push([lblTelefono,lblTelefono]);
    }
    
    var cmbTelefonos=crearComboExt('cmbTelefonos',arrTelefonosContacto,150,35,350);
    var cmbObtuvoRespuesta=crearComboExt('cmbObtuvoRespuesta',arrSiNo,150,65,115);
    cmbObtuvoRespuesta.on('select',function(cmb,registro)
    								{
                                    	if(registro.data.id=='1')
                                        {
                                        	gEx('lblResp1').show();
                                            gEx('cmbRespuestaObtenida').show();
                                            gEx('lblMotivo1').hide();
                                            gEx('cmbMotivo').hide();
                                            
                                            gEx('vLlamada').setSize(700,210);
                                            gEx('lblEspecifique').hide();
                                            gEx('txtEspecifique').hide();
                                            gEx('txtEspecifique').setValue('');
                                            
                                            gEx('lblLlamada1').hide();
                                            gEx('cmbProgramaLlamada').hide();
                                            gEx('cmbProgramaLlamada').setValue('');
                                            
                                            gEx('lblProximaLlamada1').hide();
                                            gEx('btnRecordar').hide();
                                            gEx('dteFechaProximaLlamada').hide();
                                            gEx('dteFechaProximaLlamada').setValue('');
                                            gEx('cmbHoraProximaLlamada').hide();
                                            gEx('cmbHoraProximaLlamada').setValue('');
                                            
                                            gEx('lblDetallesRecordatorio1').hide();
                                            gEx('txtDetallesRecordatorio').hide();
                                            gEx('txtDetallesRecordatorio').setValue('');
                                        }
                                        else
                                        {
                                        	gEx('lblResp1').hide();
                                            gEx('cmbRespuestaObtenida').hide();
                                            gEx('lblMotivo1').show();
                                            gEx('cmbMotivo').show();
                                        }
                                    }
    						)
    var cmbRespuestaObtenida=crearComboExt('cmbRespuestaObtenida',arrRespNotificacion1,150,95,200);
    cmbRespuestaObtenida.hide();
    
    var cmbMotivo=crearComboExt('cmbMotivo',arrRespNotificacion2,150,95,200);
    cmbMotivo.hide();
    cmbMotivo.on('select',function(cmb,registro)
    					{
                        	switch(registro.data.id)
                            {
                            	case '1':
                                case '3':
                                	gEx('vLlamada').setSize(700,260);
                                    
                                    
                                    gEx('lblLlamada1').show();
                                    gEx('cmbProgramaLlamada').show();
                                    
                                    if(registro.data.id=='3')
                                    {
                                    	gEx('lblEspecifique').show();
                                        gEx('txtEspecifique').show();
                                    }
                                    else
                                    {
                                    	gEx('lblEspecifique').hide();
                                        gEx('txtEspecifique').hide();
                                        gEx('txtEspecifique').setValue('');
                                    }
                                    
                                break;
                                default:
                                	gEx('vLlamada').setSize(700,210);
                                    gEx('lblEspecifique').hide();
                                    gEx('txtEspecifique').hide();
                                    gEx('txtEspecifique').setValue('');
                                    
                                    gEx('lblLlamada1').hide();
                                    gEx('cmbProgramaLlamada').hide();
                                    gEx('cmbProgramaLlamada').setValue('');
                                    
                                    gEx('lblProximaLlamada1').hide();
                                    gEx('btnRecordar').hide();
                                    gEx('dteFechaProximaLlamada').hide();
                                    gEx('dteFechaProximaLlamada').setValue('');
                                    gEx('cmbHoraProximaLlamada').hide();
                                    gEx('cmbHoraProximaLlamada').setValue('');
                                    
                                    gEx('lblDetallesRecordatorio1').hide();
                                    gEx('txtDetallesRecordatorio').hide();
                                    gEx('txtDetallesRecordatorio').setValue('');
                                break;
                            }
                        }
    				)
    var cmbProgramaLlamada=crearComboExt('cmbProgramaLlamada',arrSiNo,215,125,115);
    cmbProgramaLlamada.hide();
    cmbProgramaLlamada.on('select',function(cmb,registro)
    								{
                                    	if(registro.data.id=='1')
                                        {
                                        	gEx('vLlamada').setSize(700,370);
                                        	gEx('lblProximaLlamada1').show();
                                            gEx('btnRecordar').show();
                                            gEx('dteFechaProximaLlamada').show();
                                            gEx('dteFechaProximaLlamada').setValue(new Date().format('Y-m-d'));
                                            gEx('cmbHoraProximaLlamada').show();
                                            gEx('cmbHoraProximaLlamada').setValue(new Date().add(Date.MINUTE,1).format('H:i'));
                                            
                                            
                                            gEx('lblDetallesRecordatorio1').show();
                                            gEx('txtDetallesRecordatorio').show();
                                            
                                        }
                                        else
                                        {
                                        	gEx('vLlamada').setSize(700,260);
                                        	gEx('lblProximaLlamada1').hide();
                                            gEx('btnRecordar').hide();
                                            gEx('dteFechaProximaLlamada').hide();
                                            gEx('dteFechaProximaLlamada').setValue('');
                                            gEx('cmbHoraProximaLlamada').hide();
                                            gEx('cmbHoraProximaLlamada').setValue('');
                                            
                                            gEx('lblDetallesRecordatorio1').hide();
                                            gEx('txtDetallesRecordatorio').hide();
                                            gEx('txtDetallesRecordatorio').setValue('');
                                        }
                                    }
    					)
    var cmbHoraProximaLlamada=crearComboExt('cmbHoraProximaLlamada',arrTiempo,330,155,115);
    cmbHoraProximaLlamada.hide();
   	cmbHoraProximaLlamada.setValue('<?php echo date("H:i") ?>');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Fecha diligencia:'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:5,
                                                            xtype:'datefield',
                                                            id:'dteFechaDiligencia',
                                                            value:new Date().format('Y-m-d')
                                                        },
                                                        cmbHora,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'Llamada realizada a:'
                                                        },
                                                        cmbTelefonos,
                                                        {
                                                        	x:510,
                                                            y:33,
                                                            xtype:'button',
                                                            icon:'../images/add.png',
                                                            cls:'x-btn-text-icon',
                                                            text:'Agregar tel&eacute;fono',
                                                            handler:function()
                                                                    {
                                                                        mostrarVentanaAgregarTelefono()
                                                                    }
                                                            
                                                        }
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            xtype:'label',
                                                            html:'Se obtuvo respuesta:'
                                                        },
                                                        cmbObtuvoRespuesta,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            id:'lblResp1',
                                                            xtype:'label',
                                                            hidden:true,
                                                            html:'Respuesta obtenida:'
                                                        },
                                                        cmbRespuestaObtenida,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            id:'lblMotivo1',
                                                            xtype:'label',
                                                            hidden:true,
                                                            html:'Motivo:'
                                                        },
                                                        cmbMotivo,
                                                        {	
                                                        	x:380,
                                                            y:100,
                                                            id:'lblEspecifique',
                                                            hidden:true,
                                                            html:'Especifique:'
                                                        },
                                                        {
                                                        	x:465,
                                                            y:95,
                                                            width:190,
                                                            hidden:true,
                                                            xtype:'textfield',
                                                            id:'txtEspecifique'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            id:'lblLlamada1',
                                                            xtype:'label',
                                                            hidden:true,
                                                            html:'Programar llamada de seguimiento?:'
                                                        },
                                                        cmbProgramaLlamada,
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            id:'lblProximaLlamada1',
                                                            xtype:'label',
                                                            hidden:true,
                                                            html:'Fecha/hora pr&oacute;xima llamada:'
                                                        },
                                                        {
                                                        	x:215,
                                                            y:155,
                                                            hidden:true,
                                                            xtype:'datefield',
                                                            id:'dteFechaProximaLlamada',
                                                            value:'<?php echo date('Y-m-d')?>'
                                                        },
                                                        cmbHoraProximaLlamada,
                                                        {
                                                        	x:470,
                                                            y:153,
                                                            hidden:true,
                                                            id:'btnRecordar',
                                                            xtype:'button',
                                                            icon:'../images/clock_add.png',
                                                            cls:'x-btn-text-icon',
                                                            text:'Recordar en...',
                                                            menu:	[
                                                            			{
                                                                        	text:'5 minutos',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarMinutos(5);
                                                                                    }
                                                                        },'-',
                                                            			{
                                                                        	text:'10 minutos',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarMinutos(10);
                                                                                    }
                                                                        },'-',
                                                                        {
                                                                        	text:'20 minutos',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarMinutos(20);
                                                                                    }
                                                                        },'-',
                                                                        {
                                                                        	text:'30 minutos',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarMinutos(30);
                                                                                    }
                                                                        },'-',
                                                                        {
                                                                        	text:'45 minutos',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarMinutos(45);
                                                                                    }
                                                                        },'-',
                                                                        {
                                                                        	text:'1 hora',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarMinutos(60);
                                                                                    }
                                                                        },'-',
                                                                        {
                                                                        	text:'2 horas',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarMinutos(120);
                                                                                    }
                                                                        },'-',
                                                                        {
                                                                        	text:'4 horas',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarMinutos(480);
                                                                                    }
                                                                        }
                                                            		]
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:190,
                                                            id:'lblDetallesRecordatorio1',
                                                            xtype:'label',
                                                            hidden:true,
                                                            html:'Detalles del recordatorio:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:220,
                                                            width:645,
                                                            height:50,
                                                            hidden:true,
                                                            xtype:'textarea',
                                                            id:'txtDetallesRecordatorio'
                                                        }
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: !fila?'Agregar diligencia':'Modificar diligencia',
										width: 700,
										height:210,
										layout: 'fit',
										plain:true,
										modal:true,
                                        id:'vLlamada',
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
                                                                    	var dteFechaDiligencia=gEx('dteFechaDiligencia');
                                                                       	var cmbHora=gEx('cmbHora');
                                                                       	var cmbTelefonos=gEx('cmbTelefonos');
                                                                        var cmbObtuvoRespuesta=gEx('cmbObtuvoRespuesta');
                                                                        var cmbRespuestaObtenida=gEx('cmbRespuestaObtenida');
                                                                        var cmbMotivo=gEx('cmbMotivo');
                                                                        var txtEspecifique=gEx('txtEspecifique');
                                                                        var cmbProgramaLlamada=gEx('cmbProgramaLlamada');
                                                                        var dteFechaProximaLlamada=gEx('dteFechaProximaLlamada');
                                                                        var cmbHoraProximaLlamada=gEx('cmbHoraProximaLlamada');
                                                                        var txtDetallesRecordatorio=gEx('txtDetallesRecordatorio');
																		
                                                                        var fechaDiligencia='';
                                                                        var horaDiligencia='';
                                                                        var telefono='';
                                                                        var obtuvoRespuesta='';
                                                                        var respuestaObtenida='';
                                                                        var motivoNoRespuesta='';
                                                                        var motivoNoRespuestaEspecifique='';
                                                                        var programarLlamada='';
                                                                        var fechaProximaLlamada='';
                                                                        var horaProximaLlamada='';
                                                                        var detallesProximaLlamada=gEx('txtDetallesRecordatorio').getValue();
                                                                        
                                                                        if(dteFechaDiligencia.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	dteFechaDiligencia.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha de la diligencia',resp);
                                                                        	return;
                                                                        }
                                                                        fechaDiligencia=dteFechaDiligencia.getValue().format('Y-m-d');
                                                                        if(cmbHora.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbHora.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la hora de la diligencia',resp2);
                                                                        	return;
                                                                        }
                                                                        horaDiligencia=cmbHora.getValue();
                                                                        
                                                                        if(cmbTelefonos.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbTelefonos.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el n&uacute;mero telf&oacute;nico al cual llam&oacute;',resp3);
                                                                        	return;
                                                                        }                                                                        
                                                                        telefono=cmbTelefonos.getRawValue();
                                                                        
                                                                        if(cmbObtuvoRespuesta.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	cmbObtuvoRespuesta.focus();
                                                                            }
                                                                        	msgBox('Debe indicar si obtuvo respuesta',resp4);
                                                                        	return;
                                                                        }
                                                                        obtuvoRespuesta=cmbObtuvoRespuesta.getValue();
                                                                        
                                                                        if(cmbObtuvoRespuesta.getValue()=='1')
                                                                        {
                                                                            if(cmbRespuestaObtenida.getValue()=='')
                                                                            {
                                                                                function resp5()
                                                                                {
                                                                                    cmbRespuestaObtenida.focus();
                                                                                }
                                                                                msgBox('Debe indicar la respuesta obtenida',resp5);
                                                                                return;
                                                                            }
                                                                            
                                                                            respuestaObtenida=cmbRespuestaObtenida.getValue();
                                                                        }
                                                                        else
                                                                        {
                                                                            if(cmbMotivo.getValue()=='')
                                                                            {
                                                                                function resp6()
                                                                                {
                                                                                    cmbMotivo.focus();
                                                                                }
                                                                                msgBox('Debe indicar el motivo por el cual no obtuvo respuesta',resp6);
                                                                                return;
                                                                            }
                                                                            motivoNoRespuesta=cmbMotivo.getValue();
                                                                            
                                                                            if((cmbMotivo.getValue()=='3') && (txtEspecifique.getValue()==''))
                                                                            {
                                                                                function resp7()
                                                                                {
                                                                                    txtEspecifique.focus();
                                                                                }
                                                                                msgBox('Debe indicar el motivo por el cual no obtuvo respuesta',resp7);
                                                                                return;
                                                                            }
                                                                            motivoNoRespuestaEspecifique=txtEspecifique.getValue();
                                                                            
                                                                            if(cmbMotivo.getValue()!='2')
                                                                            {
                                                                            	if(cmbProgramaLlamada.getValue()=='')
                                                                                {
                                                                                    function resp8()
                                                                                    {
                                                                                        cmbProgramaLlamada.focus();
                                                                                    }
                                                                                    msgBox('Debe indicar si desea programar una pr&oacute;xima llamada',resp8);
                                                                                    return;
                                                                                }
                                                                                programarLlamada=cmbProgramaLlamada.getValue();
                                                                                
                                                                                if(cmbProgramaLlamada.getValue()=='1')
                                                                                {
                                                                                	if(dteFechaProximaLlamada.getValue()=='')
                                                                                    {
                                                                                        function resp9()
                                                                                        {
                                                                                            dteFechaProximaLlamada.focus();
                                                                                        }
                                                                                        msgBox('Debe indicar la fecha en la cual realizar&aacute; la pr&oacute;xima llamada',resp9);
                                                                                        return;
                                                                                    }
                                                                                    fechaProximaLlamada=dteFechaProximaLlamada.getValue().format('Y-m-d');
                                                                                    
                                                                                    if(cmbHoraProximaLlamada.getValue()=='')
                                                                                    {
                                                                                        function resp10()
                                                                                        {
                                                                                            cmbHoraProximaLlamada.focus();
                                                                                        }
                                                                                        msgBox('Debe indicar la hora en la cual realizar&aacute; la pr&oacute;xima llamada',resp10);
                                                                                        return;
                                                                                    }
                                                                                    
                                                                                    horaProximaLlamada=cmbHoraProximaLlamada.getValue();
                                                                                }
                                                                            }
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                        var oDetalle='{"fechaDiligencia":"'+fechaDiligencia+'","horaDiligencia":"'+horaDiligencia+
                                                                        '","telefono":"'+telefono+'","obtuvoRespuesta":"'+obtuvoRespuesta+'","respuestaObtenida":"'+respuestaObtenida+
                                                                        '","motivoNoRespuesta":"'+motivoNoRespuesta+'","motivoNoRespuestaEspecifique":"'+cv(motivoNoRespuestaEspecifique)+
                                                                        '","programarLlamada":"'+programarLlamada+'","fechaProximaLlamada":"'+fechaProximaLlamada+
                                                                        '","horaProximaLlamada":"'+horaProximaLlamada+'","detallesProximaLlamada":""}';
                                                                        
                                                                        var reg=crearRegistro	(
                                                                        							[
                                                                                                    	{name: 'telefono'},
                                                                                                        {name: 'fechaDiligencia'},
                                                                                                        {name:'detalle'},
                                                                                                        {name: 'situacion'}
                                                                                                    ]
                                                                        						);
                                                                        var r;
                                                                        var telefonoLlamada=telefono;
                                                                        if(!fila)
                                                                        {
                                                                            r=new reg	(
                                                                                                {	
                                                                                                    telefono: telefonoLlamada,
                                                                                                    fechaDiligencia: Date.parseDate(fechaDiligencia+' '+horaDiligencia,'Y-m-d H:i'),
                                                                                                    detalle: bE(oDetalle),
                                                                                                    situacion:respuestaObtenida=='1'?'1':'0'
                                                                                                }
                                                                                            )
                                                                                            
                                                                            gEx(idGrid).getStore().add(r);  
                                                                        }
                                                                        else
                                                                        {
                                                                        	fila.set('telefono',telefonoLlamada);
                                                                            fila.set('fechaDiligencia',Date.parseDate(fechaDiligencia+' '+horaDiligencia,'Y-m-d H:i'));
                                                                            fila.set('detalle',bE(oDetalle));
                                                                            fila.set('situacion',respuestaObtenida=='1'?'1':'0');
                                                                        }
                                                                        if( programarLlamada=='1')
                                                                        {
                                                                        	r=new reg	(
                                                                        					{	
                                                                                            	telefono: telefono,
                                                                                                fechaDiligencia: Date.parseDate(fechaProximaLlamada+' '+horaProximaLlamada,'Y-m-d H:i'),
                                                                                                detalle: bE('{"detallesProximaLlamada":"'+cv(detallesProximaLlamada)+'"}'),
                                                                                                situacion:'2'
                                                                                            }
                                                                        				)
                                                                            gEx(idGrid).getStore().add(r);              
                                                                        	
                                                                        }  
                                                                        gEx(idGrid).getStore().sort('fechaDiligencia','DESC');  
                                                                       
                                                                        
                                                                        
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
    
    if(fila)
    {
    	var dteFechaDiligencia=gEx('dteFechaDiligencia');
        var cmbHora=gEx('cmbHora');
        var cmbTelefonos=gEx('cmbTelefonos');
        var cmbObtuvoRespuesta=gEx('cmbObtuvoRespuesta');
        var cmbRespuestaObtenida=gEx('cmbRespuestaObtenida');
        var cmbMotivo=gEx('cmbMotivo');
        var txtEspecifique=gEx('txtEspecifique');
        var cmbProgramaLlamada=gEx('cmbProgramaLlamada');
        var dteFechaProximaLlamada=gEx('dteFechaProximaLlamada');
        var cmbHoraProximaLlamada=gEx('cmbHoraProximaLlamada');
        var txtDetallesRecordatorio=gEx('txtDetallesRecordatorio');
        
        dteFechaDiligencia.setValue(fila.data.fechaDiligencia.format('Y-m-d'));
        cmbHora.setValue(fila.data.fechaDiligencia.format('H:i'));
        cmbTelefonos.setValue(fila.data.telefono);
        
        if(fila.data.detalle!='')
        {
        	var oDetalle=eval('['+bD(fila.data.detalle)+']')[0];
            cmbObtuvoRespuesta.setValue(oDetalle.obtuvoRespuesta);
            dispararEventoSelectCombo('cmbObtuvoRespuesta');
            if(oDetalle.obtuvoRespuesta=='1')
            {
            	cmbRespuestaObtenida.setValue(oDetalle.respuestaObtenida);
            }
            else
            {
            	cmbMotivo.setValue(oDetalle.motivoNoRespuesta);
                dispararEventoSelectCombo('cmbMotivo');
                txtEspecifique.setValue(oDetalle.motivoNoRespuestaEspecifique);
                if(cmbProgramaLlamada.isVisible())
                {
                	cmbProgramaLlamada.setValue(oDetalle.programarLlamada);
                    dispararEventoSelectCombo('cmbProgramaLlamada');
                    if(oDetalle.programarLlamada=='1')
                    {
                    	dteFechaProximaLlamada.setValue(oDetalle.fechaProximaLlamada);
                        cmbHoraProximaLlamada.setValue(oDetalle.horaProximaLlamada);
                        txtDetallesRecordatorio.setValue(escaparBR(oDetalle.detallesProximaLlamada));
                    }
                    
                    
                }
                
                
            }
            
        }
        
    }
    	
}

function mostrarVentanaAgregarTelefono()
{
	var cmbTipoTel=crearComboExt('cmbTipoTel',arrTelefonos,70,5,110);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Tipo:'
                                                        },
                                                        cmbTipoTel,
                                                        {
                                                        	xtype:'numberfield',
                                                            width:40,
                                                            id:'txtLada',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            x:190,
                                                            y:5
                                                        },
                                                        {
                                                        	x:195,
                                                            y:30,
                                                            xtype:'label',
                                                            html:'Lada'
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            width:100,
                                                            id:'txtNumero',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            x:240,
                                                            y:5
                                                        }
                                                        ,
                                                        {
                                                        	x:270,
                                                            y:30,
                                                            xtype:'label',
                                                            html:'N&uacute;mero'
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            width:50,
                                                            id:'txtExtension',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            x:350,
                                                            y:5
                                                        },
                                                        {
                                                        	x:350,
                                                            y:30,
                                                            xtype:'label',
                                                            html:'Extensi&oacute;n'
                                                        }
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar tel&eacute;fono',
										width: 500,
										height:140,
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
																		var cmbTipoTel=gEx('cmbTipoTel');
                                                                        if(cmbTipoTel.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoTel.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de tel&eacute;fono a agregar',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var txtNumero=gEx('txtNumero');
                                                                        if(txtNumero.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtNumero.focus();
                                                                            }
                                                                            msgBox('Debe indicar el n&uacute;mero de tel&eacute;fono a agregar',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cadObj='{"tipoTel":"'+cmbTipoTel.getValue()+'","lada":"'+gEx('txtLada').getValue()+'","numero":"'+
                                                                        gEx('txtNumero').getValue()+'","extension":"'+gEx('txtExtension').getValue()+'","idParticipante":"'+
                                                                        nodoSujetoSel.attributes.idPersona+'"}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                
                                                                                var arrTelefonosContacto=[];
                                                                                var x;
                                                                                var filaTel;
                                                                                var lblTelefono;
                                                                                for(x=0;x<gEx('gTelefonos').getStore().getCount();x++)
                                                                                {
                                                                                    filaTel=gEx('gTelefonos').getStore().getAt(x);
                                                                                    lblTelefono='';
                                                                                    if(filaTel.data.lada!='')
                                                                                    {
                                                                                        lblTelefono+='('+filaTel.data.lada+') ';
                                                                                    }
                                                                                    lblTelefono+=filaTel.data.numero;
                                                                                    
                                                                                    if(filaTel.data.extension!='')
                                                                                    {
                                                                                        lblTelefono+=' Ext. '+fila.data.extension;
                                                                                    }
                                                                                    lblTelefono+=' ['+formatearValorRenderer(arrTelefonos,filaTel.data.tipoTelefono)+']';
                                                                                    arrTelefonosContacto.push([lblTelefono,lblTelefono]);
                                                                                }
                                                                                lblTelefono='';
                                                                                if(gEx('txtLada').getValue()!='')
                                                                                {
                                                                                    lblTelefono+='('+gEx('txtLada').getValue()+') ';
                                                                                }
                                                                                lblTelefono+=gEx('txtNumero').getValue();
                                                                                
                                                                                if(gEx('txtExtension').getValue()!='')
                                                                                {
                                                                                    lblTelefono+=' Ext. '+gEx('txtExtension').getValue();
                                                                                }
                                                                                lblTelefono+=' ['+formatearValorRenderer(arrTelefonos,gEx('cmbTipoTel').getValue())+']';
                                                                                
                                                                                
                                                                                arrTelefonosContacto.push([lblTelefono,lblTelefono]);
                                                                                funcSujeto(nodoSujetoSel);
                                                                                gEx('cmbTelefonos').getStore().loadData(arrTelefonosContacto);
                                                                                gEx('cmbTelefonos').setValue(lblTelefono);

                                                                                ventanaAM.close();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=33&cadObj='+cadObj,true);
                                                                        
                                                                        
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

function agregarMinutos(min)
{
	var dteFechaProximaLlamada=gEx('dteFechaProximaLlamada');
    var cmbHoraProximaLlamada=gEx('cmbHoraProximaLlamada');
    
    
    var fechaHora=Date.parseDate(dteFechaProximaLlamada.getValue().format('Y-m-d')+' '+cmbHoraProximaLlamada.getValue(),'Y-m-d H:i');
    fechaHora=fechaHora.add(Date.MINUTE,min);
    dteFechaProximaLlamada.setValue(fechaHora.format('Y-m-d'));
    cmbHoraProximaLlamada.setValue(fechaHora.format('H:i'));
    
    
}

function modificarDiligencia()
{
	var fila=gEx('gDiligencias').getSelectionModel().getSelected();
    if(!fila)
    {
        msgBox('Debe seleccionar la diligencia que desea modificar');
        return;
    }
    //var pos=existeValorMatriz(arrParteProcesal,fila.data.idParteProcesal);
    var iFigura=fila.data.idParteProcesal;//arrParteProcesal[pos][3];
    var id='p_'+fila.data.idNombreParteProcesal+'_'+iFigura;
    var nodo=gEx('arbolSujetos').getNodeById(id);
    gEx('arbolSujetos').getSelectionModel().select(nodo);
    funcSujeto(nodo);
    mostrarVentanaAgregarNotificacion(nodoSujetoSel,fila);
}

function ocultarBotonReprocesar()
{
	var boton=$('.cke_button__preprocesar');
                                                                               
    if(boton.length>0)
    {
        boton[0].style.display='none';
    }
}

function mostrarBotonReprocesar()
{
	var boton=$('.cke_button__preprocesar');
                                                                               
    if(boton.length>0)
    {
        boton[0].style.display='';
    }
}

function mostrarVentanaAdmonCorreo()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			crearGridAdmonCorreoEnviados()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Administraci&oacute;n de correo enviados',
										width: 950,
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
															handler: function()
																	{
																		
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

function crearGridAdmonCorreoEnviados()
{
	var arrSituacionMail=[['1','En espera de respuesta'],['2','Con respuesta se notific&oacute; a destinatario'],['3','Con respuesta, NO se notific&oacute; a destinatario']];
	var expander = new Ext.ux.grid.RowExpander({
                                                    column:2,
                                                    tpl : new Ext.Template(
                                                        '<table width="100%" >'+
                                                        '<tr><td  style="padding:10px">{detallesAdicionales}</td></tr>'+
                                                        '</table>'
                                                    )
                                                }); 


	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idMail'},
                                                        {name:'asunto'},
		                                                {name: 'fechaEnvio', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name:'destinatario'},
		                                                {name:'situacion'},
                                                        {name:'detallesAdicionales'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaEnvio', direction: 'ASC'},
                                                            groupField: 'fechaEnvio',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='36';
                                        proxy.baseParams.iO=gE('idOrden').value;
                                        proxy.baseParams.iP=idParticipanteSel;
                                        proxy.baseParams.tN=nodoMedioSel.id;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha de env&iacute;o',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaEnvio',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i')
                                                                        }
                                                            },
                                                            {
                                                                header:'Asunto',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'asunto',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Destinatario',
                                                                width:230,
                                                                sortable:true,
                                                                dataIndex:'destinatario',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.replace(/,/gi,'<br />');
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacionMail,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gMailsEnviados',
                                                                store:alDatos,
                                                                x:0,
                                                                y:0,
                                                                width:920,
                                                                height:360,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/mail.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Enviar nuevo correo electr&oacute;nico',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaCorreo();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/book_open.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Abrir buz&oacute;n de correo',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaBuzonCorreo();
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                        ],
                                                                columnLines : true,                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    enableRowBody:true,
                                                                                                    getRowClass:formatearFilaEmail,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;

}

function formatearFilaEmail(registro, numFila, rp, ds)
{
	var lblDetalle=registro.data.detallesAdicionales;
	
	var lblTable='<br><table width="100%"><tr><td style="padding:10px">'+lblDetalle+
                '</td></tr></table><br>';
    rp.body=lblTable;	
    return 'x-grid3-row-expanded';
    
    
}

function mostrarVentanaBuzonCorreo()
{
	editorMail=null;
    editorMailSetValor='';
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'panel',
                                                            region:'center',
                                                            border:false,
                                                            layout:'border',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            region:'center',
                                                                            border:false,
                                                                            layout:'border',
                                                                            items:	[
                                                                            			crearArbolBuzones(),
                                                                                        crearGridCorreosRecibidos()
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            height:230,
                                                                            collapsed:true,
                                                                            layout:'absolute',
                                                                            id:'pCuerpo',
                                                                            border:false,
                                                                            collapsible:true,
                                                                            region:'south',
                                                                            items:	[
                                                                            			{
	                                                                                        x:0,
                                                                                            y:0,
                                                                                            xtype:'fieldset',
                                                                                            width:200,
                                                                                            height:200,
                                                                                            title:'Adjuntos',
                                                                                            layout:'absolute',
                                                                                            items:	[
                                                                                            			{
                                                                                                        	x:0,
                                                                                                            y:0,
                                                                                                            xtype:'label',
                                                                                                            html:'<div style="width:165px;height:150px; border-style:none; overflow:auto" class="cuerpoMail" id="divAdjuntos"></div>'
                                                                                                        }
                                                                                            		]
                                                                                        },
                                                                                        {
	                                                                                        x:210,
                                                                                            y:0,
                                                                                            xtype:'fieldset',
                                                                                            width:750,
                                                                                            height:200,
                                                                                            title:'Mensaje',
                                                                                            layout:'absolute',
                                                                                            items:	[
                                                                                            			{
                                                                                                        	x:0,
                                                                                                            y:0,
                                                                                                            html:'<div class="controlSIUGJ" style="width:705px;height:150px; border-style:none; overflow:auto" class="cuerpoMail" id="divCuerpoMail"></div>'
                                                                                                        }
                                                                                            		]
                                                                                        }
                                                                            		]
                                                                        }
                                                            		]
                                                        }
                                                        
                                                        				
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Buz&oacute;n',
										width: 980,
										height:550,
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
                                                                	gEx('pCuerpo').collapse();
                                                                
                                                                
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		
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

function crearArbolBuzones()
{
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
                                                                    funcion:'37',
                                                                    iO:gE('idOrden').value
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                }
                                            )		
	
    cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            		
									setTimeout	(	function()
                                                    {
                                                        var nodo=nodoCarga.childNodes[0];
                                                        gEx('arbolBuzones').getSelectionModel().select(nodo);
                                                        funcBandeja(nodo);
                                                    },500
                                                 )
                                
                            }
    				)									
										
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolBuzones',
                                                                border:true,
                                                                width:200,
                                                                region:'west',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	arbolSujetosJuridicos.on('click',funcBandeja);	                      
	return  arbolSujetosJuridicos;
}


function funcBandeja(nodo, evento)
{
	nodoBandeja=nodo;
	if(nodo.childNodes.length==0)
    {
    	gEx('gMailsRecibidos').getStore().load	(
        											{
                                                    	params:	{
                                                        			funcion:'38',
                                                                    iO:gE('idOrden').value,
                                                                    iP:idParticipanteSel,
                                                                    tN:nodoMedioSel.id,
                                                                    b:nodoBandeja.id,
                                                                    start:0,
                                                                    limit:10
                                                        		}
                                                    }
        										);
        
    }
    
    
    
}

function obtenerCorreosBuzon(buzon)
{
	var iO=gE('idOrden').value;
    var iP=idParticipanteSel;
    var tN=nodoMedioSel.id;
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
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=38&iO='+iO+'&iP='+iP+'&tN='+tN+'&b='+buzon,true);
}

function crearGridCorreosRecibidos()
{
	
	

	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idMail'},
                                                        {name:'asunto'},
		                                                {name: 'fechaRecepcion', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name:'remitente'},
		                                                {name:'adjuntos'},
                                                        {name:'cuerpo'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaEnvio', direction: 'ASC'},
                                                            groupField: 'fechaEnvio',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	var paginador=	new Ext.PagingToolbar	(
                                              {
                                                    pageSize: 10,
                                                    store: alDatos,
                                                    displayInfo: true,
                                                    disabled:false
                                                }
                                             )     
      
      
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                    	proxy.baseParams.funcion='38';
                                        proxy.baseParams.iO=gE('idOrden').value;
                                        proxy.baseParams.iP=idParticipanteSel;
                                        proxy.baseParams.tN=nodoMedioSel.id;
                                        proxy.baseParams.b=nodoBandeja.id;

                                        
                                    }
                        )       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha de recepci&oacute;n',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaRecepcion',
                                                                renderer:function(val,metaData)
                                                                		{
                                                                        	metaData.attr='style="font-size:11px;color:#555;white-space: normal;"';
                                                                        	return val.format('d/m/Y H:i')
                                                                        }
                                                            },
                                                            {
                                                                header:'Asunto',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'asunto',
                                                                renderer:function(val,metaData)
                                                                		{
                                                                        	metaData.attr='style="font-size:11px;color:#555;white-space: normal;"';
                                                                            return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Remitente',
                                                                width:230,
                                                                sortable:true,
                                                                dataIndex:'remitente',
                                                                renderer:function(val,metaData)
                                                                		{
                                                                        	metaData.attr='style="font-size:11px;color:#555;white-space: normal;"';
                                                                        	return val.replace(/,/gi,'<br />');
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gMailsRecibidos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                bbar:[paginador],
                                                                tbar:	[
                                                                            
                                                                            
                                                                        ],
                                                                columnLines : false,                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    enableRowBody:true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
                                                        
	tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
                                                {
                                                	var x;
                                                    var listaAdjuntos='';
                                                    var lAdjunto='';
                                                    for(x=0;x<registro.data.adjuntos.length;x++)
                                                    {
                                                    	var arrExtension=registro.data.adjuntos[x][0].split('.');
                                                        extension=arrExtension[arrExtension.length-1].toLowerCase();
                                                    	lAdjunto='<a href="javascript:obtenerArchivoMail(\''+bE(registro.data.idMail)+'\',\''+bE(registro.data.adjuntos[x][0])+
                                                        			'\')"><img src="../imagenesDocumentos/16/file_extension_'+extension+'.png"> '+registro.data.adjuntos[x][0]+'</a>';
                                                        if(listaAdjuntos=='')
                                                        	listaAdjuntos=lAdjunto;
                                                        else
                                                        	listaAdjuntos+='<br>'+lAdjunto;
                                                    }
                                                	gE('divAdjuntos').innerHTML=listaAdjuntos;
                                                	gE('divCuerpoMail').innerHTML=bD(registro.data.cuerpo);
                                                	gEx('pCuerpo').expand();
                                                }
                                    )                                                        
                                                        
        return 	tblGrid;

}

function obtenerArchivoMail(idMail,idNombreArchivo)
{
	var arrArchivo=bD(idNombreArchivo).split('.');
    var extension=arrArchivo[arrArchivo.length-1];

	var cadObj='{"idMail":"'+bD(idMail)+'","nombreArchivo":"'+bD(idNombreArchivo)+'"}';
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
       		var pos=existeValorMatriz(arrVisores,extension.toLowerCase());  
            if(pos!=-1) 
            	mostrarVisorDocumentoProceso(extension,arrResp[1],null,bD(idNombreArchivo));
            else
            {
            	location.href='../paginasFunciones/obtenerDocumentoEditorArchivos.php?id='+bE(arrResp[1])+'&nombreArchivo='+bD(idNombreArchivo);
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=39&cadObj='+cadObj,true);
    
}


function reenviarDiligenciaCentralNotificadores(iD)
{

	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
       		switch(arrResp[1])
            {
            	case '1':
                    var pos=obtenerPosFila(gEx('gDiligencias').getStore(),'idDiligencia',bD(iD));
                    var registroSel=gEx('gDiligencias').getStore().getAt(pos);
                    
                    registroSel.set('enviadoCentralNotificadores','1');
                    registroSel.set('idAcuseEnvioCentralNotificadores',arrResp[2]);
                break;
                case '0':
                	function resp()
                    {
                    	
                    }
                	msgBox('<b>NO</b> se ha podido enviar la notificaci&oacute;n a la central de notificadores debido al siguiente problema:<br><br>'+arrResp[2],resp);
                    return;
                break;
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=42&idNotificacion='+bD(iD),true);


}