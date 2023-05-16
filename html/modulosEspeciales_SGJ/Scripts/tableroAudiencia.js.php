<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$arrEtapasProcesales=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	$idPerfilEvento=bD($_GET["iP"]);
	$idEvento=bD($_GET["iE"]);
	$carpetaAdministrativa=bD($_GET["cA"]);
	
	
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__171_tablaDinamica,nombreCategoria FROM _171_tablaDinamica";
	$arrTipoRecurso=$con->obtenerFilasArreglo($consulta);
	
	$arrEtiquetaFunciones=array();
	$consulta="SELECT valor,contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=2515 ORDER BY valor";
	$resOpciones=$con->obtenerFilas($consulta);
	while($fOpciones=mysql_fetch_row($resOpciones))
	{
		$arrEtiquetaFunciones[$fOpciones[0]]=$fOpciones[1];
	}
	
	$arrEtiquetasTiempos=array();
	$consulta="SELECT valor,contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=2557 ORDER BY valor";
	$resOpciones=$con->obtenerFilas($consulta);
	while($fOpciones=mysql_fetch_row($resOpciones))
	{
		$arrEtiquetasTiempos[$fOpciones[0]]=$fOpciones[1];
	}
		
	$cacheCalculos=NULL;
	$arrFunciones=array();

	foreach($arrEtiquetaFunciones as $x=>$titulo)
	{
		if(!isset($arrFunciones[$x]))
		{
			$arrFunciones[$x]=array();
			$arrFunciones[$x][0]="";
			if($x==2)
			{
				
				$arrFunciones[$x][1]="";
				$arrFunciones[$x][2]="";
				$arrFunciones[$x][3]="";
			}
		}
		
		
		$consulta="SELECT * FROM _173_tablaDinamica WHERE tipoFuncion=".$x." and situacionFuncion=1";
		$res=$con->obtenerFilas($consulta);
		while($fFuncion=mysql_fetch_assoc($res))
		{
			$etapaAudiencia=$fFuncion["etapaAudiencia"];
			
			if($etapaAudiencia=="")
				$etapaAudiencia=0;
			
			
			$sujetosProcesales="";
			$consulta="SELECT  idSujetoProcesal FROM _173_gSujetosProcesales WHERE idReferencia=".$fFuncion["id__173_tablaDinamica"];
			$sujetosProcesales=$con->obtenerListaValores($consulta);
			
			$objConf='{"tipoEnlace":"'.$fFuncion["tipoEnlace"].'","proceso":"'.$fFuncion["proceso"].'","repetible":"'.$fFuncion["repetible"].
						'","funcionJS":"'.$fFuncion["funcionJS"].'","urlLibreriaFunciones":"'.$fFuncion["urlLibreriaFunciones"].
						'","vinculaSujetoProcesal":"'.$fFuncion["vinculaSujetoProcesal"].'","sujetosProcesales":"'.$sujetosProcesales.
						'","multiplesSujetos":"'.$fFuncion["multiplesSujetos"].'"}';
			
			$mostrar=true;
			
			if(($fFuncion["funcionVisualizacion"]!="")&&($fFuncion["funcionVisualizacion"]!="-1"))
			{
				$cadParametros='{"idFuncion":"'.$fFuncion["id__173_tablaDinamica"].'","idEvento":"'.$idEvento.'","carpetaAdministrativa":"'.$carpetaAdministrativa.
								'"}';
				$objParametros=json_decode($cadParametros);
				$visualizable=removerComillasLimite(resolverExpresionCalculoPHP($fFuncion["funcionVisualizacion"],$objParametros,$cacheCalculos));
				$mostrar=($visualizable==true);
			}
			
			if($mostrar)
			{
				$o='	{
							text:"'.cv($fFuncion["tituloFuncion"]).'",
							cls:"x-btn-text-icon",								
							handler:function()
									{
										var cadObj='.$objConf.';
										ejecutarFuncionAccion(cadObj);
									}
						}';
					
					
				if($arrFunciones[$x][$etapaAudiencia]=="")					
					$arrFunciones[$x][$etapaAudiencia]=$o;
				else
					$arrFunciones[$x][$etapaAudiencia].=",".$o;
					
			}
					
		}
		
		
	}
	

	
$arrMenusFunciones="";

foreach($arrEtiquetaFunciones as $x=>$titulo)	
{
	$icono="";	
	
	switch($x)
	{
		case 1:
			$icono="page_white_edit.png";
		break;
		case 2:
			$icono="page_process.png";
		break;
		case 3:
			$icono="pencil.png";
		break;
		case 4:
			$icono="wrench.png";
		break;
	}
	
	$mostrarMenus=false;
	
	foreach($arrFunciones[$x] as $tiempos=>$restoTiempo)
	{
		if($restoTiempo!="")
		{
			$mostrarMenus=true;
			break;
		}
	}
	
	if($mostrarMenus)
	{
		$arrOpcionesTiempos="";
		$arrGeneral="";
		foreach($arrEtiquetasTiempos as $idTiempo=>$etiquetaTiempo)
		{
			
			if(isset($arrFunciones[$x][$idTiempo])&&($arrFunciones[$x][$idTiempo]!=""))
			{
				if($idTiempo!=0)
				{
					
					$oA="	{
								text:'".cv($arrEtiquetasTiempos[$idTiempo])."',
								menu:	[
											".$arrFunciones[$x][$idTiempo]."
										]
							}";
				
					
				
					if($arrOpcionesTiempos=="")
						$arrOpcionesTiempos=$oA;
					else	
						$arrOpcionesTiempos.=",".$oA;
				}
				else
					$arrGeneral=$restoTiempo;
			}
			
				
		}
		
		
		if($arrGeneral!="")
		{
			if($arrOpcionesTiempos=="")
				$arrOpcionesTiempos=$arrGeneral;
			else	
				$arrOpcionesTiempos.=",".$arrGeneral;
		}
		
		
		
		$oMenu="
				{
					icon:'../images/".$icono."',
					cls:'x-btn-text-icon',
					text:'".cv($titulo)."',
					menu:[".$arrOpcionesTiempos."]
					
				},'-',
				";

		
		if($arrMenusFunciones=="")
			$arrMenusFunciones=$oMenu;
		else
			$arrMenusFunciones.="".$oMenu;
	}
}



?>
var arrTipoRecurso=<?php echo $arrTipoRecurso?>;
var nodoSujetoSel=-1;
var idPerfil=<?php echo $idPerfilEvento?>;
var arrCategorias=<?php echo $arrCategorias?>;
var arrEtapasProcesales=<?php echo $arrEtapasProcesales?>;
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var nodoSelCheck=null;
Ext.onReady(inicializar);

function inicializar()
{
	Ext.QuickTips.init();
    var arrPanelesRight=[];
    arrPanelesRight.push	(
    							{
                                    xtype:'panel',
                                    layout:'border',
                                    title:'Asistencia de Participantes',
                                    items:	[
                                                crearArbolSujetosProcesales()
                                            ]
                                }
    						);
    
    
    var vista=new Ext.Viewport(	{
                                layout: 'border',
                                listeners:	{
                                                show : {
                                                            buffer : 3000,
                                                            fn : function() 
                                                            {
                                                               
                                                                vista.doLayout();
                                                            }
                                                        }
                                             },
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                items:	[	
                                                
                                                			{
                                                            	xtype:'tabpanel',
                                                                id:'tblRight',
                                                                width:450,
                                                                activeTab:0,
                                                                collapsible:true,
                                                                region:'east',                                                                
                                                                items:	arrPanelesRight
                                                            },
                                                            {
                                                            	xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                region:'center',
                                                                                border:false,
                                                                                id:'btnBarraPrincipal',
                                                                               
                                                                                tbar:	[
                                                                                			
                                                                                            {
                                                                                                icon:'../images/salir.gif',
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Salir',
                                                                                                id:'btnSalir',
                                                                                                hidden:(!window.parent),
                                                                                                handler:function()
                                                                                                        {
                                                                                                            function resp(btn)
                                                                                                            {
                                                                                                            	if(btn=='yes')
                                                                                                                {
                                                                                                                	window.parent.cerrarVentanaFancy();
                                                                                                                }
                                                                                                            }
                                                                                                            msgConfirm('Est&aacute; seguro de querer salir de la audiencia?',resp);
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                		],
                                                                                title:'Proceso Judicial [<span style="color:#900"><b>'+gE('carpetaAdministrativa').value+'</b></span>]',
                                                                                items:	[
                                                                                			new Ext.ux.IFrameComponent({ 
                
                                                                                                            id: 'frameContenido', 
                                                                                                            region:'center',
                                                                                                            anchor:'100% 100%',
                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:100%',
                                                                                                            loadFuncion: function(el)
                                                                                                                        {
                                                                                                                            var body=gEx('frameContenido').getFrameDocument().getElementsByTagName('body');
                                                                                                                            
                                                                                                                            body[0].onclick=cerrarMenusActivos;
                                                                                                                           
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
                        
	gEx('frameContenido').load	(
    								{
                                    	url:'../modulosEspeciales_SGJ/datosAudienciaTablero.php',
                                        params:	{
                                        			cPagina:'sFrm=true',
                                                    sL:gE('sL').value,
                                        			idEvento:gE('idEventoAudiencia').value
                                        		}
                                    }
    							)                        
                         
	if(gE('vC').value=='1')
    {
    	var barra=gEx('btnBarraPrincipal').getTopToolbar( );
        var x;
        var ctrl;
        for(x=0;x<barra.items.length;x++)
        {
        	ctrl=barra.items.items[x]
            
            if(ctrl.id!='btnSalir')
            {	

            	ctrl.hide();
            }
        	
        }
        
    }
	
}

function crearArbolSujetosProcesales()
{
	var arrTipoParticipante=[['1','Parte Procesal'],['2','Juez']];
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idParticipante'},
		                                                {name: 'nombreParticipante'},
		                                                {name:'asistencia'},
		                                                {name: 'horaEntrada'},
                                                        {name: 'horaSalida'},
                                                        {name: 'tipoParticipante'},
                                                        {name: 'comentariosAdicionales'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreParticipante', direction: 'ASC'},
                                                            groupField: 'tipoParticipante',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='19';
                                        proxy.baseParams.idEventoAudiencia=gE('idEventoAudiencia').value;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),  
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'asistencia',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var imagen='';
                                                                            var titulo='';
                                                                            switch(val)
                                                                            {
                                                                            	case '0':
                                                                                	imagen='control_pause.png';
                                                                                    titulo='En Espera de Registro';
                                                                                break;
                                                                                case '1':
                                                                                	imagen='icon_big_tick.gif';
                                                                                    titulo='Asisti&oacute;';
                                                                                break;
                                                                                case '3':
                                                                                	imagen='cross.png';
                                                                                    titulo='NO Asisti&oacute;';
                                                                                break;
                                                                                case '2':
                                                                                	imagen='accept_green.png';
                                                                                    titulo='Asisti&oacute;, se ausent&oacute;';
                                                                                break;
                                                                            }
                                                                        	return '<img src="../images/'+imagen+'" title="'+(titulo)+'" alt="'+(titulo)+'" width="14" height="14">';
                                                                        }
                                                            },   
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'asistencia',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	return '<a href="javascript:hModificarAsistencia(\''+bE(registro.data.idParticipante)+'\')"><img src="../images/pencil.png" title="Modificar Asistencia" alt="Modificar Asistencia" width="14" height="14"></a>';
                                                                        }
                                                            }, 
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'tipoParticipante',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	return formatearValorRenderer(arrTipoParticipante,val);
                                                            			}
                                                            },                                                       
                                                            {
                                                                header:'Participante',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'nombreParticipante',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Situacion Asistencia',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:function(val,meta,registro)
                                                                			{
                                                                            	var lblEtiqueta='';
                                                                                
                                                                                switch(registro.data.asistencia)
                                                                                {
                                                                                    case '0':
                                                                                        return '';
                                                                                    break;
                                                                                    case '1':
                                                                                        lblEtiqueta='<span style="color:#900; font-weight:bold;">Asisti&oacute;</span>.<br>Hora de Entrada/Salida: '+registro.data.horaEntrada+' hrs. - '+registro.data.horaSalida+' hrs.';
                                                                                    	if(val!='')
                                                                                        {
                                                                                        	lblEtiqueta+='<br><b>Comentarios Adicionales:</b><br>'+val;
                                                                                        }
                                                                                    
                                                                                    break;
                                                                                    case '3':
                                                                                    	lblEtiqueta='<span style="color:#900; font-weight:bold;">NO Asisti&oacute;</span>. '
                                                                                        if(val!='')
                                                                                        {
                                                                                        	lblEtiqueta+='<br><b>Comentarios Adicionales:</b><br>'+val;
                                                                                        }
                                                                                        
                                                                                    break;
                                                                                    case '2':

                                                                                        lblEtiqueta='<span style="color:#900; font-weight:bold;">Asisti&oacute;</b>, se ausent&oacute</span>.<br>Hora de Entrada/Salida: '+registro.data.horaEntrada+' hrs. - '+registro.data.horaSalida+' hrs.';
                                                                                   		if(val!='')
                                                                                        {
                                                                                        	lblEtiqueta+='<br><b>Comentarios Adicionales:</b><br>'+val;
                                                                                        }
                                                                                    break;
                                                                                }
                                                                            	return lblEtiqueta;
                                                                            }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gAsistencia',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                
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


function crearArbolProcesos()
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
                                                                    funcion:'18',
                                                                    iE:bE(gE('idEventoAudiencia').value),
                                                                    cA:bE(gE('carpetaAdministrativa').value)
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
                                                }
                                            )		
										
											
										
	var arbolProcesos=new Ext.ux.tree.TreeGrid	(
                                                    {
                                                        
                                                        id:'arbolProcesos',
                                                        useArrows:true,
                                                        animate:true,
                                                        width:250,
                                                        enableDD:false,
                                                        ddScroll:true,
                                                        containerScroll: true,
                                                        autoScroll:true,
                                                        border:false,
                                                        height:((obtenerDimensionesNavegador()[0])/2)-45,
                                                        root:raiz,
                                                        lines : false,
                                                        enableSort:false,
                                                        loader: cargadorArbol,
                                                        rootVisible:false,
                                                        columns:[
                                                                    
                                                                    {
                                                                        header:'Flujo',
                                                                        width:230,
                                                                        dataIndex:'text'
                                                                    },
                                                                    {
                                                                        header:'Fecha registro',
                                                                        width:160,
                                                                        dataIndex:'fechaCreacion'
                                                                    },
                                                                    
                                                                    {
                                                                        header:'Situaci&oacute;n',
                                                                        width:500,
                                                                        dataIndex:'situacion'
                                                                    }
                                                                 ]
                                                    }
                                                )
         
         
                                                    
	arbolProcesos.on('dblclick',funcClickArbolProcesos);	                                                    
                                                    
	return  arbolProcesos;
}

function funcClickArbolProcesos(nodo, evento)
{
	if(nodo.attributes.tipo!='0')
    {
    	
        var obj={};
        var params=[['idRegistro',nodo.attributes.idRegistro],['idFormulario',nodo.attributes.idFormulario],['dComp',bE('auto')],['actor',bE('0')]];
        obj.ancho='90%';
        obj.alto='95%';
        obj.url='../modeloPerfiles/vistaDTDv3.php';
        obj.params=params;
        obj.modal=true;
        abrirVentanaFancy(obj);
        
        
        
    }
}

function crearArbolCarpetaAdministrativa()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
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
                                                            sortInfo: {field: 'etapaProcesal', direction: 'ASC'},
                                                            groupField: 'etapaProcesal',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='19';
                                        proxy.baseParams.iE=bE(gE('idEventoAudiencia').value);
                                        proxy.baseParams.cA=bE(gE('carpetaAdministrativa').value);
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
       
	var expander = new Ext.ux.grid.RowExpander({
                                                column:1,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
                                                    '<tr><td ><span class="TSJDF_Control">{descripcion}</span><br /><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            });        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        expander,
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
                                                            dataIndex:'fechaCreacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y H:i');
                                                                    }
                                                        },{
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
                                                            sortable:true,
                                                            dataIndex:'etapaProcesal',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasProcesales,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Documento',
                                                            width:250,
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
                                                            id:'gridCarpetaAdministrativa',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            title:'Carpeta Administrativa',
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,  
                                                            plugins:[expander,filters],                                                          
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :true,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: true,
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

function crearGridAcciones()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idAccion'},
		                                                {name: 'etiqueta'},
		                                                {name: 'tipoModulo'},
		                                                {name: 'datosConfiguracion'}
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
                                                            sortInfo: {field: 'etiqueta', direction: 'ASC'},
                                                            groupField: 'etiqueta',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='20';
                                        proxy.baseParams.iE=bE(gE('idEventoAudiencia').value);
                                        proxy.baseParams.cA=bE(gE('carpetaAdministrativa').value);
                                        proxy.baseParams.iP=bE(idPerfil);
                                    }
                        )   
       
    
    
        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        
                                                        {
                                                            header:'Acci&oacute;n',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'etiqueta'
                                                        },
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'datosConfiguracion',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(gE('sL').value=='1')
                                                                        	return '';
                                                                    	return '<a href="javascript:dispararAccion(\''+val+'\')"><img src="../images/right1.png" title="Disparar acci&oacute;n" alt="Disparar acci&oacute;n" /></a>'
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridAccionesDisponibles',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            disabled:(gE('sL').value=='1'),
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,  
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

function dispararAccion(cadConf)
{
	var cadObj=bD(cadConf);
    var oConf=eval('['+cadObj+']')[0];
    var dConf=oConf.objConf;
    if(oConf.ejecutarFuncion.indexOf('(')!==-1)
    {
    	eval(oConf.ejecutarFuncion+';');
    }
    else
    	eval(oConf.ejecutarFuncion+'(dConf);');
}

function crearGridAudiencias()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idEvento'},
		                                                {name: 'fechaEvento',type:'date',dateFormat:'Y-m-d'},
		                                                {name: 'tipoAudiencia'},
                                                        {name: 'situacion'},
		                                                {name: 'horarioProgramado'},
                                                        {name: 'horarioReal'},
                                                        {name: 'etapaProcesal'}
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
                                                            sortInfo: {field: 'etapaProcesal', direction: 'ASC'},
                                                            groupField: 'etapaProcesal',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='21';
                                        proxy.baseParams.iE=bE(gE('idEventoAudiencia').value);
                                        proxy.baseParams.cA=bE(gE('carpetaAdministrativa').value);
                                        
                                    }
                        )   
       
    
    
        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        
                                                        {
                                                            header:'Fecha de audiencia',
                                                            width:130,
                                                            sortable:true,
                                                            dataIndex:'fechaEvento',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val.format('d/m/Y')
                                                                    }
                                                        },
                                                        {
                                                            header:'Tipo de audiencia',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'tipoAudiencia',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'Horario programado',
                                                            width:360,
                                                            sortable:true,
                                                            dataIndex:'horarioProgramado',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'Situaci&oacute;n',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'situacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrSituacionEvento,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Horario desarrollo',
                                                            width:360,
                                                            sortable:true,
                                                            dataIndex:'horarioReal',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'Etapa procesal',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'etapaProcesal',
                                                            renderer:function(val)
                                                                    {
                                                                    	return formatearValorRenderer(arrEtapasProcesales,val);
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridAudiencias',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            title:'Historial de audiencias',
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,  
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :true,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: true,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'<span style="color:#900"><b>{text}</b> ({[values.rs.length]} {[values.rs.length > 1 ? "Audiencias" : "Audiencia"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    

		tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var obj={};
                                    obj.url='../modulosEspeciales_SGJP/tableroAudiencia.php';
                                    obj.ancho='100%';
                                    obj.alto='100%';
                                    obj.openEffect='fade';
                                    modal=true;
                                    obj.params=[['idEventoAudiencia',registro.data.idEvento],['cPagina','sFrm=true']];
                               		abrirVentanaFancy(obj);   
                              }
                  )                                                    
                               

	                  
    return 	tblGrid;
}

function crearGridHistorialAcciones()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idRegistro'},
                                                        {name: 'iFormulario'},
		                                                {name: 'iRegistro'},
		                                                {name: 'etiqueta'},
                                                        {name: 'situacion'},
                                                        {name: 'actor'}
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
                                                            sortInfo: {field: 'idRegistro', direction: 'ASC'},
                                                            groupField: 'etiqueta',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='22';
                                        proxy.baseParams.iE=bE(gE('idEventoAudiencia').value);
                                        
                                        
                                    }
                        )   
       
    
    
        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        
                                                        {
                                                            header:'Acci&oacute;n',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'etiqueta',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'Situaci&oacute;n',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'situacion',
                                                            renderer:mostrarValorDescripcion
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridHistorialAcciones',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,  
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
                                                    

		tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var obj={};
                                    var params=[['idRegistro',registro.data.iRegistro],['idFormulario',registro.data.iFormulario],['dComp',bE('auto')],['actor',bE(registro.data.actor)]];
                                    obj.ancho='100%';
                                    obj.alto='100%';
                                    obj.url='../modeloPerfiles/vistaDTDv3.php';
                                    obj.params=params;
                                    obj.modal=true;
                                    abrirVentanaFancy(obj);
                              }
                  )                                                    
                               

	                  
    return 	tblGrid;
}

function recargarGrids()
{
	if(gEx('gActuacionDigital'))
    	gEx('gActuacionDigital').getStore().reload();
        
//	gEx('gridHistorialAcciones').getStore().reload();
    //gEx('gridCarpetaAdministrativa').getStore().reload();
    //gEx('gridAudiencias').getStore().reload();
    //gEx('arbolProcesos').getStore().reload();
    
    
    
}

function regresar1Pagina()
{
	recargarGrids();
}

function regresar2Pagina()
{
	recargarGrids();
	
}

function recargarContenedorCentral()
{
	recargarGrids();

    
}

function regresar1PaginaContenedor()
{
	recargarGrids();


}

function regresarPagina2Contenedor()
{
	recargarGrids();


}

function regresarContenedorCentral()
{
	recargarGrids();

}

var ignorarReset=false;
function chkParticipanteChange(nodo,valor)
{
	if(gE('vC').value=='1')
    	return;
	gEx('btnAcuerdosReparatorios').hide();
    gEx('btnComputoPena').hide();
	if(valor)
    {
    	nodoSelCheck=nodo;
    	var arrDatos=nodo.id.split('_');
        if(arrDatos[2]=='4')
        {
        	gEx('btnAcuerdosReparatorios').show();
            <?php
				if($_SESSION["idUsr"]==1)
				{
			?>
            gEx('btnComputoPena').show();
            <?php
				}
			?>
        }
    }
    else
    {
    	nodoSelCheck=null;
    }
	if((valor)&&(!ignorarReset))
    {
    	checarNodosHijos(gEx('arbolSujetos').getRootNode(),false);
        ignorarReset=true;
        nodo.getUI().toggleCheck(true);
        
    }
    ignorarReset=false;
}

function crearGridBibliotecaApoyo()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'tituloRecursos'},
		                                                {name:'tipoRecurso'},
                                                        {name: 'descripcion'},
                                                        {name: 'origenRecurso'},
                                                        {name: 'url'},
                                                        {name: 'documentoAdjunto'},
                                                        {name: 'formaVisualizacion'}
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
                                                            sortInfo: {field: 'tipoRecurso', direction: 'ASC'},
                                                            groupField: 'tipoRecurso',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='33';
                                       
                                    }
                        )   
     
      var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				
                                                                        {type: 'string', dataIndex: 'tituloRecursos'}
                                                                        
                                                                    ]
                                                    }
                                                ); 
     var expander = new Ext.ux.grid.RowExpander({
                                                column:0,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
                                                    '<tr><td ><span class="TSJDF_Control">{descripcion}</span><br /><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            }); 
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                           
                                                            expander,
                                                            {
                                                                header:'T&iacute;tulo recurso',
                                                                width:600,
                                                                sortable:true,
                                                                dataIndex:'tituloRecursos',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Tipo recurso',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'tipoRecurso',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrTipoRecurso,val);
                                                                            }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gElementosApoyoLibreria',
                                                                title:'Documentos de apoyo',
                                                                store:alDatos,
                                                                collapsible:false,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                height:200,
                                                                stripeRows :true,
                                                                plugins:[expander,filters],
                                                                loadMask:true,
                                                                columnLines : false,                                                                
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
                                                        
		tblGrid.on('rowdblclick',function(grid,rowIndex)
    						{
                            	var fila=grid.getStore().getAt(rowIndex);
                                switch(fila.data.origenRecurso)
                                {
                                	case '1': //URL
                                    	switch(fila.data.formaVisualizacion)
                                        {
                                        	case '1':  //Nueva ventana
                                            	enviarFormularioDatos(fila.data.url,[],'GET','_blank');
                                            break;
                                            case '2':  //Ventana emergente
                                            	var obj={};
                                                obj.ancho='100%';
                                                obj.alto='100%';
                                                obj.title=fila.data.tituloRecursos;
                                                obj.url=fila.data.url;
                                                abrirVentanaFancy(obj);
                                            break;
                                            case '3':   //Descarga
                                            	enviarFormularioDatos(fila.data.url,[],'GET');                                            
                                            break;
                                        }
                                    break;
                                    case '2':  //Documento adjunto
                                    	switch(fila.data.formaVisualizacion)
                                        {
                                        	case '1':  //Nueva ventana
                                            	enviarFormularioDatos('../paginasFunciones/obtenerArchivosInline.php',[['id',bE(fila.data.documentoAdjunto)]],'GET','_blank');
                                            break;
                                            case '2':  //Ventana emergente
                                            	var obj={};
                                                obj.ancho='100%';
                                                obj.alto='100%';
                                                obj.title=fila.data.tituloRecursos;
                                                obj.params=[['id',bE(fila.data.documentoAdjunto)]];
                                                obj.url='../paginasFunciones/obtenerArchivosInline.php';
                                                abrirVentanaFancy(obj);
                                            break;
                                            case '3':   //Descarga
                                            	enviarFormularioDatos('../paginasFunciones/obtenerArchivos.php',[['id',bE(fila.data.documentoAdjunto)]],'GET','_blank');                                          
                                            break;
                                        }
                                    break;
                                    case '3': //Función javascript
                                    	eval(fila.data.url+'();');
                                    break;
                                    
                                }
                            }
    			)                                                        
                                                        
        
        return 	tblGrid;	
}

function cerrarMenusActivos()
{
	Ext.menu.MenuMgr.hideAll();
}

function ejecutarFuncionAccion(objConf)
{
    if(objConf.vinculaSujetoProcesal=='1')
    {
    	mostrarVentanaSujetosProcesales(objConf);
    }
    else
    {
    	continuarEjecucionFuncionAccion(objConf);
    } 
}

function continuarEjecucionFuncionAccion(objConf)
{
	
	if(objConf.tipoEnlace=='1')//JavaScript
    {
    	eval(objConf.funcionJS+'(objConf);');
    }
    else						//Proceso
    {
    
    	var cadProceso='{"multiplesSujetos":"'+(objConf.multiplesSujetos==""?0:objConf.multiplesSujetos)+'","figuraJuridica":"'+objConf.figuraJuridica+'","idUsuario":"'+objConf.idUsuario+'","proceso":"'+objConf.proceso+'","repetible":"'+objConf.repetible+'","idEvento":"'+gE('idEventoAudiencia').value+'"}';
        
    
    	function funcAjax(peticion_http)
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	var objProceso=eval('['+arrResp[1]+']')[0];
                var obj={};
                obj.ancho='100%';
                obj.alto='100%';
                obj.url='../modeloPerfiles/vistaDTDv3.php';
                obj.params=[['idEvento',gE('idEventoAudiencia').value],['carpetaAdministrativa',gE('carpetaAdministrativa').value],
                			['idFormulario',objProceso.idFormulario],['idRegistro',objProceso.idRegistro],['dComp',bE(objProceso.dComp)],
                            ['actor',bE(objProceso.actor)]];
                
                if(objConf.multiplesSujetos=='0')
                {
                 	obj.params.push(['idUsuario',objConf.idUsuario]);
                    obj.params.push(['figuraJuridica',objConf.figuraJuridica]);
                }
                else
                {
                	obj.params.push(['arrSujetosSeleccionados',bE(objConf.arrSujetosSeleccionados)]);
                }
                
                abrirVentanaFancy(obj);
                
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=34&cadProceso='+cadProceso,true);
    
    
    }
}

function mostrarVentanaSujetosProcesales(objConf)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														crearArbolSujetosProcesalesSeleccion(objConf)

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de sujetos procesales',
										width: 600,
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
                                                                    	var arrSujetosSeleccionados='';
                                                                        
                                                                    	var  arrNodos=gEx('arbolSujetosSeleccion').getChecked();
                                                                        if(arrNodos.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos un sujeto procesal');
                                                                        	return;
                                                                        }
                                                                    	
                                                                        var arrSujetos='';
                                                                        var x;
                                                                        
                                                                        if(objConf.multiplesSujetos=='0')
                                                                        {
                                                                        	var arrSujetos=arrNodos[0].id.split('_');
                                                                            
                                                                        	objConf.idUsuario=arrSujetos[1];
                                                                            objConf.figuraJuridica=arrSujetos[2];
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                        	var arrSujetos='';
                                                                            var obj='';
                                                                            var arrSujetosSeleccionados='';
                                                                        	for(x=0;x<arrNodos.length;x++)
                                                                            {
                                                                                arrSujetos=arrNodos[x].id.split('_');
                                                                                obj='{"idUsuario":"'+arrSujetos[1]+'","figuraJuridica":"'+arrSujetos[1]+'"}';
                                                                                if(arrSujetosSeleccionados=='')
                                                                                	arrSujetosSeleccionados=obj;
                                                                                else
                                                                                	arrSujetosSeleccionados+=','+obj;
                                                                            }
                                                                            
                                                                            objConf.arrSujetosSeleccionados='['+arrSujetosSeleccionados+']';
                                                                        }
                                                                        
                                                                        
																		continuarEjecucionFuncionAccion(objConf);
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

function crearArbolSujetosProcesalesSeleccion(objConf)
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
                                                                    funcion:'17',
                                                                    iE:bE(gE('idEventoAudiencia').value),
                                                                    cA:bE(gE('carpetaAdministrativa').value),
                                                                    sP:bE(objConf.sujetosProcesales)
                                                                    
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
                                                }
                                            )		
										
											
										
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                
                                                                id:'arbolSujetosSeleccion',
                                                                x:10,
                                                                y:10,
                                                                border:true,
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                height:240,
                                                                width:550,
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	arbolSujetosJuridicos.multiplesSujetos=objConf.multiplesSujetos;
    arbolSujetosJuridicos.on('checkchange',chkParticipanteChangeSeleccion);	                                                                
	return  arbolSujetosJuridicos;
}

function chkParticipanteChangeSeleccion(nodo,valor)
{
	
	if(gEx('arbolSujetosSeleccion').multiplesSujetos=='0')
    {
        if((valor)&&(!ignorarReset))
        {
            checarNodosHijos(gEx('arbolSujetosSeleccion').getRootNode(),false);
            ignorarReset=true;
            nodo.getUI().toggleCheck(true);
            
        }
        ignorarReset=false;
	}
}

function recargarArbolSujetos()
{
	gEx('arbolSujetos').getRootNode().reload();
}

function crearGridResolutivosAcciones()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idFormulario'},
		                                                {name: 'idRegistro'},
		                                                {name:'tituloContenido'},
                                                        {name:'actor'}
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
                                                            sortInfo: {field: 'tituloContenido', direction: 'ASC'},
                                                            groupField: 'tituloContenido',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='41';
                                        proxy.baseParams.idEvento=gE('idEventoAudiencia').value;
                                       
                                    }
                        )   
     
      
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            {
                                                            	header:'',
                                                                width:50,
                                                                dataIndex:'idRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirRegistroExpedienteEvento(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\',\''+bE(registro.data.actor)+'\')"><img src="../images/magnifier.png"></a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Resolutivo/Acci&oacute;n',
                                                                width:600,
                                                                sortable:true,
                                                                dataIndex:'tituloContenido',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gResolutivos',
                                                                title:'Resolutivos/Acciones',
                                                                store:alDatos,
                                                                collapsible:false,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                height:200,
                                                                stripeRows :true,
                                                                loadMask:true,
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
    return tblGrid;                                                    
}

function abrirRegistroExpedienteEvento(iF,iR,a)
{
	 var obj={};
     obj.ancho='100%';
     obj.alto='100%';
     obj.url='../modeloPerfiles/vistaDTDv3.php';
     obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['actor',a],['dComp',bE('auto')]];
     abrirVentanaFancy(obj);
}

function crearGridDatosParticipantes()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idFormulario'},
		                                                {name: 'idRegistro'},
		                                                {name:'descripcion'},
		                                                {name: 'cumple'}
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
                                                            sortInfo: {field: 'descripcion', direction: 'ASC'},
                                                            groupField: 'descripcion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='42';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            {
                                                                header:'',
                                                                width:50,
                                                                sortable:true,
                                                                dataIndex:'cumple',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='1')
                                                                            {
                                                                            	return '<img src="../images/icon_big_tick.gif">';
                                                                            }
                                                                            else
                                                                            {
                                                                            	return '<img src="../images/cross.png">';
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'descripcion',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gDatosParticipante',
                                                                store:alDatos,
                                                                
                                                                region:'south',
                                                                frame:false,
                                                                cm: cModelo,
                                                                height:400,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
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
        
        
        tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    if(registro.data.idRegistro!='-1')
                                    {
                                    	var obj={};
                                        var params=[['idRegistro',registro.data.idRegistro],['idFormulario',registro.data.idFormulario],
                                        			['dComp',bE('auto')],['actor',bE('0')]];
                                        obj.ancho='90%';
                                        obj.alto='95%';
                                        obj.url='../modeloPerfiles/vistaDTDv3.php';
                                        obj.params=params;
                                        obj.modal=true;
                                        abrirVentanaFancy(obj);
                                    }
                                  
                              }
                  )   
        
        return 	tblGrid;
}

function crearGridActuacionDigital()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idReferencia'},
                                                        {name:'idFormulario'},
                                                        {name:'situacion'},
		                                                {name: 'evaluacion'},
                                                        {name: 'actor'},
                                                        {name: 'accion'}
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
                                                            sortInfo: {field: 'situacion', direction: 'ASC'},
                                                            groupField: 'situacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='111';
                                        proxy.baseParams.idEvento=gE('idEventoAudiencia').value;
                                    }
                        )   
	
    
    
    alDatos.on('load',function(almacen,registros)
    								{
                                    	if(registros.length==0)
                                        {
                                        	gEx('tblRight').hideTabStripItem(1);
                                        }
                                    }
                        )   
    
           
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                                                                                       
                                                            {
                                                                header:'',
                                                                align:'center',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='')
                                                                            	val=0;
                                                                        	var icono='';
                                                                            var lblEtiqueta='';
                                                                            switch(parseInt(val))
                                                                            {
                                                                            	case 0:
                                                                                	icono='cross.png';
                                                                                    lblEtiqueta='No registrado';
                                                                                break;
                                                                                case 1:
                                                                                	icono='accept_green.png';
                                                                                    lblEtiqueta='En registro';
                                                                                break;
                                                                                case 2:
                                                                                	icono='icon_big_tick.gif';
                                                                                    lblEtiqueta='Registrado';
                                                                                break;
                                                                            }
                                                                        	return '<img src="../images/'+icono+'" title="'+lblEtiqueta+'" alt="'+lblEtiqueta+'">';
                                                                        }
                                                            },
                                                            {
                                                                header:'Evaluaci&oacute;n',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'evaluacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if((bD(registro.data.actor)=='0')&&(registro.data.idReferencia=='-1'))
                                                                            	return val;
                                                                        	return '<a href="javascript:abrirFormatoRegistro(\''+bE(registro.data.idFormulario)+
                                                                            		'\',\''+bE(registro.data.idReferencia)+'\',\''+registro.data.actor+
                                                                                    '\',\''+registro.data.accion+'\')">'+val+'</a>';
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gActuacionDigital',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                border:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                
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

function abrirFormatoRegistro(iF,iR,a,acc)
{
	
    
    
    var obj={};
    var params=[['idRegistro',bD(iR)],['idFormulario',bD(iF)],['dComp',acc],['actor',a],['idEvento',gE('idEventoAudiencia').value]];
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=params;
    obj.modal=true;
    abrirVentanaFancy(obj);
    
    
}

function ocultarPanelDerecho()
{
	gEx('tblRight').collapse();
}


function mostrarPanelDerecho()
{
	gEx('tblRight').expand();
}

function recargarArbolSujetos()
{
	gEx('arbolSujetos').getRootNode().reload();
}

function hModificarAsistencia(iP)
{
	var pos=obtenerPosFila(gEx('gAsistencia').getStore(),'idParticipante',bD(iP));
	var fila=gEx('gAsistencia').getStore().getAt(pos);
	var cmbHoraEntrada=crearCampoHoraExt('cmbHoraEntrada','00:00','23:59',1,false);
   	cmbHoraEntrada.setPosition(170,65);
    cmbHoraEntrada.setWidth(130);
    cmbHoraEntrada.setValue(fila.data.horaEntrada);
    var cmbHoraSalida=crearCampoHoraExt('cmbHoraSalida','00:00','23:59',1,false);
   	cmbHoraSalida.setPosition(330,65);
    cmbHoraSalida.setWidth(130);
    cmbHoraSalida.setValue(fila.data.horaSalida);
	
    
	var arrSiNoAsistio=[['3','No'],['1','S\xED'],['2','S\xED, pero tuvo que ausentarse']];
	var cmbAsistio=crearComboExt('cmbAsistio',arrSiNoAsistio,170,35,210);
    cmbAsistio.on('select',function(cmb,registro)
    						{
                            	if(registro.data.id=='3')
                                {
                                	cmbHoraEntrada.disable();
                                    cmbHoraSalida.disable();
                                }
                                else
                                {
                                	cmbHoraEntrada.enable();
                                    cmbHoraSalida.enable();
                                }
                            }
    				)
    
	if(fila.data.asistencia!=0)
    {
    	cmbAsistio.setValue(fila.data.asistencia);
    }
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'<b>Participante:</b>&nbsp;&nbsp;<span style="color:#900; font-weight:bold" id="lblParticipante">'+fila.data.nombreParticipante+'</span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>Asisti&oacute; a la Audiencia:</b>'
                                                        },
                                                        cmbAsistio
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>Hora de Entrada/Salida:</b>'
                                                        } ,
                                                        cmbHoraEntrada,
                                                        {
                                                        	x:313,
                                                            y:67,
                                                            html:'<b>/</b>'
                                                        } ,
                                                        cmbHoraSalida,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'<b>Comentarios Adicionales:</b>'
                                                        },
                                                        {	
                                                        	x:10,
                                                            y:130,
                                                            xtype:'textarea',
                                                            width:540,
                                                            height:60,
                                                            value:escaparBR(fila.data.comentariosAdicionales),
                                                            id:'comentariosAdicionales'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar Asistencia',
										width: 600,
										height:300,
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
																		var cmbAsistio=gEx('cmbAsistio');
                                                                        var cmbHoraEntrada=gEx('cmbHoraEntrada');
                                                                        var cmbHoraSalida=gEx('cmbHoraSalida');
                                                                        var comentariosAdicionales=gEx('comentariosAdicionales');
                                                                        
                                                                        var cadObj='{"idRegistro":"'+fila.data.idParticipante+'","asistio":"'+cmbAsistio.getValue()+
                                                                        			'","horaEntrada":"'+cmbHoraEntrada.getValue()+
                                                                        			'","horaSalida":"'+cmbHoraSalida.getValue()+
                                                                                    '","comentariosAdicionales":"'+cv(gEx('comentariosAdicionales').getValue())+
                                                                                    '"}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gAsistencia').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=20&cadObj='+cadObj,true);
                                                                        
                                                                        
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