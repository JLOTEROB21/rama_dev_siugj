<?php session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$query="select nombreEstilo,nombreEstilo from 932_estilos";
	$arrEstilos=uEJ($con->obtenerFilasArreglo($query));
	$res5=$con->obtenerFilas("select idIdioma,idioma,imagen from 8002_idiomas");
	$columnas="";
	$arrIdiomas="";
	$ct=0;
	$campoGrid="";
	$arrCamposGrid="";
	$arrLblRender="";
	while($fila5=mysql_fetch_row($res5))
	{
		$filaIdioma='{"idIdioma":"'.$fila5[0].'","idioma":"'.$fila5[1].'","imagen":"'.$fila5[2].'"}';
		if($arrIdiomas=="")
			$arrIdiomas=$filaIdioma;
		else
			$arrIdiomas.=",".$filaIdioma;
		$campoGrid='etiqueta_'.$fila5[0].':""';	
		$arrCamposGrid.=",".$campoGrid;
		$arrLblRender=",etiqueta_".$fila5[0].":'<img src=\"../images/banderas/".$fila5[2]."\">&nbsp;&nbsp;Etiqueta'";
		$ct++;
		
	}
	echo "var arrIdiomas=[".uE($arrIdiomas)."];var nIdiomas=".$ct.";";
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=1 order by descripcionValor ";
	$arrValorSesion=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=2 order by descripcionValor ";
	$arrValorSistema=uEJ($con->obtenerFilasArreglo($consulta));
	
	$idConsulta=bD($_GET["idConsulta"]);
	
	$consulta="select HEX(AES_ENCRYPT('".cv($idConsulta)."_complementario', '".bD($versionLatis)."'))";
	$llaveConsulta=$con->obtenerValor($consulta);
	$consulta="select tokenMysql,tokenUsr,tipoToken,valorDevuelto,idToken,comp1 from 992_tokensConsulta where idConsulta=".$idConsulta." order by idToken";

	$resTokens=$con->obtenerFilas($consulta);
	$arrConsulta="";
	while($filasT=mysql_fetch_row($resTokens))
	{
		$arrAux="";
		if($filasT[2]<0)
		{
			$consulta="select parametro,idParametro from 993_parametrosConsulta where idConsulta=".$filasT[2]*-1;
			
			$arrParam=$con->obtenerFilasArregloAsocPHP($consulta);
			if(sizeof($arrParam)>0)
			{
				foreach($arrParam as $p=>$idParametro)
				{
					$consulta="select valor,tipoValor from 994_valoresTokens where idToken=".$filasT[4]." and idParametro=".$idParametro;
					$fValor=$con->obtenerPrimeraFila($consulta);
					$valor=$fValor[0];
					$tipoValor=$fValor[1];
					$aux="['".$p."','".$valor."','".$tipoValor."']";
					if($arrAux=="")
						$arrAux=$aux;
					else
						$arrAux.=",".$aux;
					
				}
			}
		}
		if($filasT[5]=="")
			$filasT[5]=0;
		$obj="[\"".str_replace("\"","\\\"",$filasT[0])."\",\"".str_replace("\"","\\\"",$filasT[1])."\",\"".$filasT[2]."\",\"".$filasT[3]."\",[".$arrAux."],\"".$filasT[5]."\"]";
		if($arrConsulta=="")
			$arrConsulta=$obj;
		else
			$arrConsulta.=",".$obj;
		
	}
	$arrConsulta="[".uEJ($arrConsulta)."]";
	$arrParametros="";
	$consulta="select parametro from 993_parametrosConsulta where idConsulta=".$idConsulta;
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		if($arrParametros=="")
			$arrParametros="'".$fila[0]."'";
		else
			$arrParametros.=",'".$fila[0]."'";
	}
	$arrParametros="[".uEJ($arrParametros)."]";
	
	$bandera=bD($_GET["bandera"]);
	$categoria=bD($_GET["categoria"]);
	$arreglo="[]";
	if($categoria==-1)
	{
		
			$consulta="select idCategoriaConcepto,nombreCategoria from  991_categoriasConcepto where idCategoriaConcepto not in (0,1,2,6)";
		
	}
	else
		$consulta="select idCategoriaConcepto,nombreCategoria from  991_categoriasConcepto where idCategoriaConcepto in (".$categoria.")";
			
	$arreglo=$con->obtenerFilasArreglo($consulta);
	
	$arrTiposConcepto="[]";
	$lCategoriaExp="";
	$arrCategoriasExpresion="[['0,@totasCategorias','Todas']";
	$consulta="SELECT idCategoriaConcepto,nombreCategoria FROM 991_categoriasConcepto  order by nombreCategoria";
	$resCategoria=$con->obtenerFilas($consulta);
	while($fCat=mysql_fetch_row($resCategoria))
	{
		$arrCategoriasExpresion.=",['".$fCat[0]."','".cv($fCat[1])."']";
		if($lCategoriaExp=="")
			$lCategoriaExp=$fCat[0];
		else
			$lCategoriaExp.=",".$fCat[0];
	}
	
	$arrCategoriasExpresion.="]";
	$arrCategoriasExpresion=str_replace("@totasCategorias",$lCategoriaExp,$arrCategoriasExpresion);
	
	$lCategoriaFunSistema="";
	$arrCategoriasFunSistema="[['0,@totasCategorias','Todas']";
	$consulta="SELECT idCategoriaFuncionSistema,nombreCategoria FROM 9033_categoriasFuncionSistema order by nombreCategoria";
	$resCategoria=$con->obtenerFilas($consulta);
	while($fCat=mysql_fetch_row($resCategoria))
	{
		$arrCategoriasFunSistema.=",['".$fCat[0]."','".cv($fCat[1])."']";
		if($lCategoriaFunSistema=="")
			$lCategoriaFunSistema=$fCat[0];
		else
			$lCategoriaFunSistema.=",".$fCat[0];
	}
	
	$arrCategoriasFunSistema.="]";
	$arrCategoriasFunSistema=str_replace("@totasCategorias",$lCategoriaFunSistema,$arrCategoriasFunSistema);
	
?>
var arrCategoriasFunSistema=<?php echo $arrCategoriasFunSistema?>;
var arrCategoriasExpresion=<?php echo $arrCategoriasExpresion?>;
var arbolAlmacenEstructDatos;
var arrValorSesion=<?php echo $arrValorSesion ?>;
var arrValorSistema=<?php echo $arrValorSistema ?>;    
var arrParametrosCalculo=[];
var filtroUsuario;
var filtroMysql;
var arrParametros;
var arrAcumuladores;
var arrConsulta=[];
var frmProceso=false;
var mostrarCerrar=false;
var variableAcumRegistrada=[];


Ext.onReady(inicializar);

function inicializar()
{

	if(gE('mCerrar').value=='1')
    	mostrarCerrar=true;

	var ocultarModificar=true;
    
    if(bD(gE('idConsultaExp').value)!='-1')
    	ocultarModificar=false;
	arrEstructuras=eval(bD(gE('arrEstructuras').value));
	arrParametros=<?php echo $arrParametros?>;
	Ext.QuickTips.init();
    
    obj={};
    obj.permitirRegistroParametro=false;
    altura=obtenerDimensionesNavegador()[1];
    obj.alto=altura;
    obj.idReferencia=bD(gE('idConsultaExp').value);
    obj.tDataSet=3;
    obj.permitirRegistroParametro=true;
    obj.tituloConcepto='la configuraci&oacute;n';
	var arbol=crearArbolAlmacen(obj);
    
	//var arbolAlmacen=crearArbolAlmacen();
    arbolAlmacenEstructDatos=arbol;

	var ocultarAmonParam=false;
    if(gE('permiteAdmonParam').value=='0')
    	ocultarAmonParam=true;
   
	var gridCondiciones=crearGridCondiciones();    
   
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                items:	[
                                                            {
                                                                xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                title: '<span class="tituloGrid">'+bD(gE('tituloModulo').value)+'</span>',
                                                                border:false,
                                                                items:	[
                                                                             {
                                                                                xtype:'panel',
                                                                                collapsible:true,
                                                                                region: 'east',
                                                                                width:255,
                                                                                split:true,
                                                                                layout:'anchor',
                                                                                items:[arbol]
                                                                             },
                                                                             {
                                                                                xtype:'panel',
                                                                                region: 'center',
                                                                                layout:'border',
                                                                                listeners:	{
                                                                                                resize:function(p,ancho,alto)
                                                                                                        {
                                                                                                            
                                                                                                            //gE('spArea').style.width=ancho+'px !important;';
                                                                                                            //gE('spArea').style.height=(alto-85)+'px !important;';
                                                                                                        }
                                                                                            },	
                                                                                tbar:	[
                                                                                            
                                                                                            {
                                                                                                icon:'../images/salir.gif',
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Cerrar',
                                                                                                hidden:!mostrarCerrar,
                                                                                                handler:function()
                                                                                                        {
                                                                                                            window.parent.cerrarVentanaFancy();
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/salir.gif',
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Regresar',
                                                                                                hidden:mostrarCerrar,
                                                                                                handler:function()
                                                                                                        {
                                                                                                            regresarPagina();
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            '-',
                                                                                            {
                                                                                                icon:'../images/cog.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Configuraciones',
                                                                                                menu:	[
                                                                                                            {
                                                                                                                icon:'../images/layout.png',
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                text:'Administrar estructuras de datos',
                                                                                                                handler:function()	
                                                                                                                          {
                                                                                                                            mostrarVentanaEstructuraDatos();   
                                                                                                                          }
                                                                                                            },
                                                                                                             {
                                                                                                                icon:'../images/page_white_edit.png',
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                hidden:ocultarAmonParam,
                                                                                                                text:'Administraci&oacute;n de par&aacute;metros',
                                                                                                                handler:function()	
                                                                                                                          {
                                                                                                                            mostrarVentanaAdminParametros();   
                                                                                                                          }
                                                                                                            },
                                                                                                            {
                                                                                                                icon:'../images/page_white_edit.png',
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                text:'Registrar par&aacute;metro',
                                                                                                                hidden:ocultarAmonParam,
                                                                                                                handler:function()	
                                                                                                                          {
                                                                                                                            mostrarVentanaParametro();   
                                                                                                                          }
                                                                                                            },
                                                                                                            
                                                                                                            {
                                                                                                                text:'Registrar variable acumuladora',
                                                                                                                icon:'../images/page_white_edit.png',
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                handler:function()	
                                                                                                                          {
                                                                                                                            mostrarVentanaAcumulador();   
                                                                                                                          }
                                                                                                            },'-',
                                                                                                            {
                                                                                                                icon:'../images/tag_blue_edit.png',
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                hidden:ocultarModificar||ocultarAmonParam,
                                                                                                                text:'Modificar informaci&oacute;n de '+gE('lblCalculoS').value,
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            mostrarVentanaNombreExpresionModif()
                                                                                                                        }
                                                                                                            },'-',
                                                                                                            {
                                                                                                                cls:'x-btn-text-icon',
                                                                                                                text:'Obtener URL de Publicaci&oacute;n',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            mostrarVentanaURLPublicacion();
                                                                                                                        }
                                                                                                            }
                                                                                                        ]
                                                                                            },
                                                                                            '-',
                                                                                            {
                                                                                                icon:'../images/guardar.PNG',
                                                                                                cls:'x-btn-text-icon',
                                                                                                text:'Guardar cambios',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            guardarExpresionFinal();
                                                                                                        }
                                                                                            },'-',
                                                                                            {
                                                                                                id:'insertar',
                                                                                                text:'Insertar...',
                                                                                                menu:	[
                                                                                                            
                                                                                                            
                                                                                                            {
                                                                                                                text:'Expresi&oacute;n almacenada previamente',
                                                                                                                handler:function()	
                                                                                                                          {
                                                                                                                            mostrarVentanaExpresion(1);   
                                                                                                                          }
                                                                                                            },
                                                                                                            {
                                                                                                                
                                                                                                                text:'Invocaci&oacute;n de funci&oacute;n de sistema',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            mostrarFuncionesSistema();
                                                                                                                        }
                                                                                                            },
                                                                                                            
                                                                                                            {
                                                                                                                
                                                                                                                id:'parametro',
                                                                                                                text:'Parametro',
                                                                                                                disabled:true,
                                                                                                                menu:	[]
                                                                                                             },
                                                                                                            
                                                                                                             {
                                                                                                            
                                                                                                                text:'Valor constante',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            
                                                                                                                            mostrarVentanaValor();
                                                                                                                        }
                                                                                                            },
                                                                                                            {
                                                                                                                text:'Valor de consulta...',
                                                                                                                handler:function()
                                                                                                                        {
                                                                                                                            mostrarVentanaVinculacionCampoEspecial();
                                                                                                                        }
                                                                                                            },
                                                                                                            {
                                                                                                                id:'variableAcumuladora',
                                                                                                                text:'Variable acumuladora registrada',
                                                                                                                disabled:true,
                                                                                                                menu:	[]
                                                                                                             },'-',
                                                                                                             {
                                                                                                                
                                                                                                                text:'Elemento ciclo Para (For)',
                                                                                                                menu:	[
                                                                                                                            {
                                                                                                                               text:'Insertar cabecera',
                                                                                                                               handler:function()
                                                                                                                                      {
                                                                                                                                          var arrValor=new Array();
                                                                                                                                          arrValor[0]='for(';
                                                                                                                                          arrValor[1]='Para(';
                                                                                                                                          arrValor[2]=0;
                                                                                                                                          arrValor[3]='';
                                                                                                                                          arrValor[4]=[];
                                                                                                                                          arrConsulta[arrConsulta.length]=arrValor;
                                                                                                                                          generarSentenciaConsultaOperacion();
                                                                                                                                      }
                                                                                                                           },
                                                                                                                           {
                                                                                                                               text:'Separador condici&oacute;n',
                                                                                                                               handler:function()
                                                                                                                                      {
                                                                                                                                          var arrValor=new Array();
                                                                                                                                          arrValor[0]='; ';
                                                                                                                                          arrValor[1]=',';
                                                                                                                                          arrValor[2]=0;
                                                                                                                                          arrValor[3]='';
                                                                                                                                          arrValor[4]=[];
                                                                                                                                          arrConsulta[arrConsulta.length]=arrValor;
                                                                                                                                          generarSentenciaConsultaOperacion();
                                                                                                                                      }
                                                                                                                           }
                                                                                                                        ]
                                                                                                             },
                                                                                                             {
                                                                                                                 text:'Cabecera ciclo Mientras (While)',
                                                                                                                 handler:function()
                                                                                                                        {
                                                                                                                            var arrValor=new Array();
                                                                                                                            arrValor[0]='while(';
                                                                                                                            arrValor[1]='Mientras(';
                                                                                                                            arrValor[2]=0;
                                                                                                                            arrValor[3]='';
                                                                                                                            arrValor[4]=[];
                                                                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                                                                            generarSentenciaConsultaOperacion();
                                                                                                                        }
                                                                                                             },
                                                                                                             {
                                                                                                                text:'Elemento ciclo Por cada (Foreach)',
                                                                                                                menu:	[
                                                                                                                            {
                                                                                                                               text:'Insertar cabecera',
                                                                                                                               handler:function()
                                                                                                                                      {
                                                                                                                                          var arrValor=new Array();
                                                                                                                                          arrValor[0]='foreach(';
                                                                                                                                          arrValor[1]='Por cada(';
                                                                                                                                          arrValor[2]=0;
                                                                                                                                          arrValor[3]='';
                                                                                                                                          arrValor[4]=[];
                                                                                                                                          arrConsulta[arrConsulta.length]=arrValor;
                                                                                                                                          generarSentenciaConsultaOperacion();
                                                                                                                                      }
                                                                                                                           },
                                                                                                                           {
                                                                                                                               text:'Part&iacute;cula En',
                                                                                                                               handler:function()
                                                                                                                                      {
                                                                                                                                          var arrValor=new Array();
                                                                                                                                          arrValor[0]=' as ';
                                                                                                                                          arrValor[1]=' En';
                                                                                                                                          arrValor[2]=0;
                                                                                                                                          arrValor[3]='';
                                                                                                                                          arrValor[4]=[];
                                                                                                                                          arrConsulta[arrConsulta.length]=arrValor;
                                                                                                                                          generarSentenciaConsultaOperacion();
                                                                                                                                      }
                                                                                                                           },
                                                                                                                           {
                                                                                                                               text:'Separador llave/elemento',
                                                                                                                               handler:function()
                                                                                                                                      {
                                                                                                                                          var arrValor=new Array();
                                                                                                                                          arrValor[0]=' => ';
                                                                                                                                          arrValor[1]=' => ';
                                                                                                                                          arrValor[2]=0;
                                                                                                                                          arrValor[3]='';
                                                                                                                                          arrValor[4]=[];
                                                                                                                                          arrConsulta[arrConsulta.length]=arrValor;
                                                                                                                                          generarSentenciaConsultaOperacion();
                                                                                                                                      }
                                                                                                                           }
                                                                                                                        ]
                                                                                                             },
                                                                                                             '-',
                                                                                                             {
                                                                                                                   text:'Referencia a al almac&eacute;n de datos',
                                                                                                                   handler:function()
                                                                                                                          {
                                                                                                                              mostrarVentanaReferenciaAlmacenDatos()
                                                                                                                          }
                                                                                                             },
                                                                                                             {
                                        
                                                                                                                   text:'Ejecutar almac&eacute;n de datos / Consulta auxiliar',
                                                                                                                   handler:function()
                                                                                                                          {
                                                                                                                              mostrarVentanaEjecucionAlmacenDatos()
                                                                                                                          }
                                                                                                               }    
                                                                                                             
                                                                                                        ]
                                                                                                
                                                                                            },
                                                                                              
                                                                                             '-'
                                                                                             ,
                                                                                             {
                                                                                                 xtype:'button',
                                                                                                 text:'Remover',
                                                                                                 icon:'../images/delete.png',
                                                                                                 cls:'x-btn-text-icon',
                                                                                                 handler:function()
                                                                                                        {
                                                                                                            if(arrConsulta.length>0)
                                                                                                            {
                                                                                                                arrConsulta.splice(arrConsulta.length-1,1);
                                                                                                                generarSentenciaConsultaOperacion();
                                                                                                            }
                                                                                                        }
                                                                                             }
                                                                                                     
                                                                                             
                                                                                        ],
                                                                                items:	[
                                                                                            gridCondiciones
                                                                                            
                                                                                        ]
                                                                             }
                                                                             
                                                                        ]
                                                            }
                                                        ]
                                            }
                                         ]
                            }
                        )
    
    
        
	
     cargarParametros();
     generarSentenciaConsultaOperacion();
     obtenerAcumuladores();
	 
    var mnuParametro=Ext.getCmp('parametro');
    
    if(arrParametros.length>0)
    	 mnuParametro.enable();
	       
    
}

function cargarParametros()
{
	
    var x;
    var menu;
    var mnuParametro=Ext.getCmp('parametro');
    var objParam;
    for(x=0;x<arrParametros.length;x++)
    {
    	var valor=arrParametros[x];
    	objParam=new Array();
        objParam[0]=valor;
        objParam[1]=valor;
    	arrParametrosCalculo.push(objParam);
    	
        menu=	{
                        id:'p'+valor,
                        text:'['+valor+']',
                        valorParam:valor,
                        handler:function()
                                {
                                    var arrValor=new Array();
                                    arrValor[0]=''+this.valorParam;
                                    arrValor[1]='['+this.valorParam+']';
                                    arrValor[2]=6;
                                    arrValor[3]='';
                                    arrValor[4]=[];
                                    arrConsulta[arrConsulta.length]=arrValor;
                                    generarSentenciaConsultaOperacion();
                                }
                    }
        mnuParametro.menu.add(menu);
    }
}

/*function crearArbolAlmacen()
{
	var iR=<?php echo $idConsulta?>;
    var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'7',
                                                                    idReporte:iR,
                                                                    tipoDataSet:3
																},
													dataUrl:'../paginasFunciones/funcionesThot.php'
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
                                              	  id:'arbolDataSet',
                                                  useArrows:true,
                                                  autoScroll:true,
                                                  animate:false,
                                                  enableDD:true,
                                                  height:600,
                                                  width:300,
                                                  containerScroll:true,
                                                  root:raiz,
                                                  rootVisible:false,
												  loader: cargadorArbol,
                                                  renderTo:'tblAlmacenes',
                                                  tbar:	[
                                                  			{
                                                            	id:'addDataSet',
                                                            	icon:'../images/database_add.png',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Crear almac&eacute;n de datos',
                                                                disabled:true,
                                                                handler:function()
                                                                		{
                                                                        
                                                                        	var idConsultaExp=bD(gE('idConsultaExp').value);
                                                                            if(idConsultaExp=='-1')
                                                                            {
                                                                            	msgBox('Antes de crear un almac&eacute;n de datos, primero debe guardar el nuevo c&aacute;lculo');
                                                                            	return;
                                                                            }
                                                                        	if(nodoSel.attributes.tipo=='ad')
                                                                            	mostrarVentanaTablasInvolucradas(true);
                                                                            else
                                                                            	mostrarVentanaTablasInvolucradas(false);
                                                                        }
                                                            },
                                                            {
                                                            	id:'delDataSet',
                                                            	icon:'../images/database_delete.png',
                                                                cls:'x-btn-text-icon',
                                                                disabled:true,
                                                                tooltip:'Eliminar almac&eacute;n de datos',
                                                                handler:function()
                                                                		{
                                                                        	if(nodoSel==null)
                                                                            {
                                                                            	msgBox('Debe seleccionar el almac&eacute;n de datos a eliminar');
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
                                                                                            nodoSel.remove();
                                                                                            nodoSel=null;
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=12&idAlmacen='+nodoSel.id,true);

                                                                                }
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer eliminar el almac&eacute;n de datos seleccionado?',resp)
                                                                        }
                                                            },
                                                            {
                                                            	id:'linkDataSet',
                                                            	icon:'../images/database_edit.png',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Modificar origen de datos',
                                                                disabled:true,
   	                                                            handler:function()
                                                                		{
                                                                        	mostrarVentanaTablasInvolucradasModif(false);
                                                                        }
                                                            },'-',
                                                            {
                                                            	id:'modificarNombreAlmacen',
                                                            	icon:'../images/tag_blue_edit.png',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Modificar nombre del almac&eacute;n',
                                                                hidden:true,
                                                                handler:function()
                                                                		{
	                                                                        mostrarVentanaModificarNombre();
                                                                        }
                                                            },   
                                                            {
                                                            	id:'modificarFiltroAlmacen',
                                                            	icon:'../images/pencil.png',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Modificar filtro de almac&eacute;n',
                                                                hidden:true,
                                                                handler:function()
                                                                		{
	                                                                        mostrarVentanaModifFiltro();
                                                                        }
                                                            },                                                            
                                                            {
                                                            	id:'modficarValorParametro',
                                                            	icon:'../images/building_edit.png',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Modificar valor de par&aacute;metro',
                                                                hidden:true,
                                                                handler:function()
                                                                		{
	                                                                        mostrarVentanaAsignarParam();
                                                                        }
                                                            },
                                                            {
                                                            	id:'addCamposProy',
                                                            	icon:'../images/add.png',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Agregar campos a proyectar',
                                                                hidden:true,
                                                                handler:function()
                                                                		{
	                                                                        agregarCampoProy();
                                                                        }
                                                            },
                                                            {
                                                            	id:'delCamposProy',
                                                            	icon:'../images/delete.png',
                                                                cls:'x-btn-text-icon',
                                                                tooltip:'Remover campo a proyectar',
                                                                hidden:true,
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
                                                                                        	nodoSel.remove();
                                                                                            nodoSel=null;
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=19&nCampo='+nodoSel.text+'&idDataSet='+nodoSel.attributes.dSetPadre,true);

                                                                                }
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer remover el campo seleccionado?',resp)
                                                                        }
                                                            }
                                                  		]
                                                                                                
                                               }
                                          );      
    //panelArbol.expandAll();
    panelArbol.on('click',funcClickArbol);
    return panelArbol;
}

function funcClickArbol(nodo)
{
	nodoSel=nodo;
    gEx('addDataSet').disable();
    gEx('delDataSet').disable();
    gEx('linkDataSet').disable();
    gEx('modficarValorParametro').hide();
    gEx('addCamposProy').hide();
    gEx('delCamposProy').hide();
    gEx('modificarFiltroAlmacen').hide();
    gEx('modificarNombreAlmacen').hide();
    switch(nodoSel.attributes.tipo)
    {
    	case 'p':
        	gEx('modficarValorParametro').show();
        break;
        case 'cc':
        	gEx('addCamposProy').show();
        break;
        case 'c':
            gEx('delCamposProy').show();
        break;
        case 't':
        	gEx('modificarFiltroAlmacen').show();
            gEx('delDataSet').enable();
            gEx('linkDataSet').enable();
            gEx('modificarNombreAlmacen').show();
        break;
        case 'ad':
        	gEx('addDataSet').enable();
        break;
        case 'ca':
        	gEx('addDataSet').enable();
        break;
        case 'ct':
        	
        break;
    }
}*/

function crearGridCondiciones()
{
	arrConsulta=<?php echo $arrConsulta?>;
	var panel=new Ext.FormPanel(	
                                          {
                                              region:'center',
                                              baseCls: 'x-plain',
                                              layout:'border',
                                              border:true,
                                              
                                              tbar: new Ext.Toolbar(
                                              							{
                                                                        	enableOverflow :true,
                                                                        	items:
                                              						 				[
                                                                                       
                                                                                         {
                                                                                               xtype:'button',
                                                                                               text:'{',
                                                                                               width:25,
                                                                                               handler:function()
                                                                                                      {
                                                                                                          var arrValor=new Array();
                                                                                                          arrValor[0]='{';
                                                                                                          arrValor[1]='{<br>';
                                                                                                          arrValor[2]=0;
                                                                                                          arrValor[3]='';
                                                                                                          arrValor[4]=[];
                                                                                                          arrConsulta[arrConsulta.length]=arrValor;
                                                                                                          generarSentenciaConsultaOperacion();
                                                                                                      }
                                                                                           },'-'
                                                                                         ,
                                                                                         {
                                                                                               xtype:'button',
                                                                                               text:'}',
                                                                                               width:25,
                                                                                               handler:function()
                                                                                                      {
                                                                                                          var arrValor=new Array();
                                                                                                          arrValor[0]='}';
                                                                                                          arrValor[1]='}<br>';
                                                                                                          arrValor[2]=0;
                                                                                                          arrValor[3]='';
                                                                                                          arrValor[4]=[];
                                                                                                          arrConsulta[arrConsulta.length]=arrValor;
                                                                                                          generarSentenciaConsultaOperacion();
                                                                                                      }
                                                                                           },'-',
                                                                                          {
                                                                                               xtype:'button',
                                                                                               text:'(',
                                                                                               width:25,
                                                                                               handler:function()
                                                                                                      {
                                                                                                          var arrValor=new Array();
                                                                                                          arrValor[0]='(';
                                                                                                          arrValor[1]='(';
                                                                                                          arrValor[2]=0;
                                                                                                          arrValor[3]='';
                                                                                                          arrValor[4]=[];
                                                                                                          arrConsulta[arrConsulta.length]=arrValor;
                                                                                                          generarSentenciaConsultaOperacion();
                                                                                                      }
                                                                                           },
                                                                                           '-',
                                                                                           {
                                                                                              xtype:'button',
                                                                                              text:'Y',
                                                                                              width:25,
                                                                                              handler:function()
                                                                                                    {
                                                                                                        if(validarOperador('Y'))
                                                                                                        {
                                                                                                            var arrValor=new Array();
                                                                                                            arrValor[0]='&&';
                                                                                                            arrValor[1]='Y';
                                                                                                            arrValor[2]=0;
                                                                                                            arrValor[3]='';
                                                                                                            arrValor[4]=[];
                                                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            generarSentenciaConsultaOperacion();
                                                                                                        }
                                                                                                    }
                                                                                         } ,'-',
                                                                                         {
                                                                                              xtype:'button',
                                                                                              text:'O',
                                                                                              width:25,
                                                                                              handler:function()
                                                                                                    {
                                                                                                        if(validarOperador('O'))
                                                                                                        {
                                                                                                            var arrValor=new Array();
                                                                                                            arrValor[0]='||';
                                                                                                            arrValor[1]='O';
                                                                                                            arrValor[2]=0;
                                                                                                            arrValor[3]='';
                                                                                                            arrValor[4]=[];
                                                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            generarSentenciaConsultaOperacion();
                                                                                                        }
                                                                                                    }
                                                                                         } ,'-',
                                                                                          {
                                                                                              xtype:'button',
                                                                                              text:')',
                                                                                              width:25,
                                                                                              handler:function()
                                                                                                    {
                                                                                                        if(validarOperador(')'))
                                                                                                        {
                                                                                                            var arrValor=new Array();
                                                                                                            arrValor[0]=')';
                                                                                                            arrValor[1]=')';
                                                                                                            arrValor[2]=0;
                                                                                                            arrValor[3]='';
                                                                                                            arrValor[4]=[];
                                                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            generarSentenciaConsultaOperacion();
                                                                                                        }
                                                                                                    }
                                                                                         } ,
                                                                                           '-'
                                                                                            ,
                                                                                          {
                                                                                               xtype:'button',
                                                                                               text:'.',
                                                                                               width:25,
                                                                                               handler:function()
                                                                                                      {
                                                                                                          var arrValor=new Array();
                                                                                                          arrValor[0]='.';
                                                                                                          arrValor[1]='.';
                                                                                                          arrValor[2]=0;
                                                                                                          arrValor[3]='';
                                                                                                          arrValor[4]=[];
                                                                                                          arrConsulta[arrConsulta.length]=arrValor;
                                                                                                          generarSentenciaConsultaOperacion();
                                                                                                      }
                                                                                           },'-'
                                                                                          ,
                                                                                          {
                                                                                               xtype:'button',
                                                                                               text:'+',
                                                                                               width:25,
                                                                                               handler:function()
                                                                                                      {
                                                                                                          if(validarOperador('+'))
                                                                                                          {
                                                                                                              var arrValor=new Array();
                                                                                                              arrValor[0]='+';
                                                                                                              arrValor[1]='+';
                                                                                                              arrValor[2]=0;
                                                                                                              arrValor[3]='';
                                                                                                              arrValor[4]=[];
                                                                                                              arrConsulta[arrConsulta.length]=arrValor;
                                                                                                              generarSentenciaConsultaOperacion();
                                                                                                          }
                                                                                                      }
                                                                                           },
                                                                                           '-'
                                                                                         ,
                                                                                          {
                                                                                             xtype:'button',
                                                                                             text:'-',
                                                                                             width:25,
                                                                                             handler:function()
                                                                                                    {
                                                                                                        if(validarOperador('-'))
                                                                                                        {
                                                                                                            var arrValor=new Array();
                                                                                                            arrValor[0]='-';
                                                                                                            arrValor[1]='-';
                                                                                                            arrValor[2]=0;
                                                                                                            arrValor[3]='';
                                                                                                            arrValor[4]=[];
                                                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            generarSentenciaConsultaOperacion();
                                                                                                       }
                                                                                                    }
                                                                                         },
                                                                                          '-'
                                                                                          ,
                                                                                          {
                                                                                             xtype:'button',
                                                                                             text:'*',
                                                                                             width:25,
                                                                                             handler:function()
                                                                                                    {
                                                                                                        if(validarOperador('*'))
                                                                                                        {
                                                                                                            var arrValor=new Array();
                                                                                                            arrValor[0]='*';
                                                                                                            arrValor[1]='*';
                                                                                                            arrValor[2]=0;
                                                                                                            arrValor[3]='';
                                                                                                            arrValor[4]=[];
                                                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            generarSentenciaConsultaOperacion();
                                                                                                        }
                                                                                                    }
                                                                                         },
                                                                                         '-'
                                                                                         ,
                                                                                          {
                                                                                             xtype:'button',
                                                                                             text:'/',
                                                                                             width:25,
                                                                                             handler:function()
                                                                                                    {
                                                                                                        if(validarOperador('+'))
                                                                                                        {
                                                                                                            var arrValor=new Array();
                                                                                                            arrValor[0]='/';
                                                                                                            arrValor[1]='/';
                                                                                                            arrValor[2]=0;
                                                                                                            arrValor[3]='';
                                                                                                            arrValor[4]=[];
                                                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            generarSentenciaConsultaOperacion();
                                                                                                        }
                                                                                                    }
                                                                                         },
                                                                                         '-',
                                                                                         {
                                                                                             xtype:'button',
                                                                                             text:'Si',
                                                                                             width:25,
                                                                                             handler:function()
                                                                                                    {
                                                                                                        var obj=null;
                                                                                                        var comp='';
                                                                                                        var arrValor=new Array();
                                                                                                        if(arrConsulta.length>0)
                                                                                                        {
                                                                                                            obj=arrConsulta[arrConsulta.length-1];
                                                                                                            if((obj[2]!='1')||(obj[0]==')'))
                                                                                                            {
                                                                                                                arrValor[0]=';';
                                                                                                                arrValor[1]='';
                                                                                                                arrValor[2]=0;
                                                                                                                arrValor[3]='';
                                                                                                                arrValor[4]=[];
                                                                                                                arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            }
                                                                                                            comp='<br>';
                                                                                                        }
                                                                                                        
                                                                                                        arrValor=new Array();
                                                                                                        arrValor[0]='if(';
                                                                                                        arrValor[1]=comp+'Si(';
                                                                                                        arrValor[2]=0;
                                                                                                        arrValor[3]='';
                                                                                                        arrValor[4]=[];
                                                                                                        arrConsulta[arrConsulta.length]=arrValor;
                                                                                                        generarSentenciaConsultaOperacion();
                                                                                                    }
                                                                                         },'-',
                                                                                         {
                                                                                             xtype:'button',
                                                                                             text:'Entonces',
                                                                                             handler:function()
                                                                                                    {
                                                                                                        var arrValor=new Array();
                                                                                                        arrValor[0]='){';
                                                                                                        arrValor[1]=') entonces<br />';
                                                                                                        arrValor[2]=0;
                                                                                                        arrValor[3]='';
                                                                                                        arrValor[4]=[];
                                                                                                        arrConsulta[arrConsulta.length]=arrValor;
                                                                                                        generarSentenciaConsultaOperacion();
                                                                                                    }
                                                                                         },'-',
                                                                                         {
                                                                                             xtype:'button',
                                                                                             text:'Sino',
                                                                                             handler:function()
                                                                                                    {
                                                                                                        var obj=null;
                                                                                                        var comp='';
                                                                                                        var arrValor=new Array();
                                                                                                        if(arrConsulta.length>0)
                                                                                                        {
                                                                                                            obj=arrConsulta[arrConsulta.length-1];
                                                                                                            if((obj[2]!='1')||(obj[0]==')'))
                                                                                                            {
                                                                                                                arrValor[0]=';';
                                                                                                                arrValor[1]='';
                                                                                                                arrValor[2]=0;
                                                                                                                arrValor[3]='';
                                                                                                                arrValor[4]=[];
                                                                                                                arrConsulta[arrConsulta.length]=arrValor;
                                                                                                                
                                                                                                            }
                                                                                                            comp='<br>';
                                                                                                        }
                                                                                                        
                                                                                                        arrValor=new Array();
                                                                                                        arrValor[0]='}else{';
                                                                                                        arrValor[1]=comp+'Sino<br />';
                                                                                                        arrValor[2]=0;
                                                                                                        arrValor[3]='';
                                                                                                        arrValor[4]=[];
                                                                                                        arrConsulta[arrConsulta.length]=arrValor;
                                                                                                        generarSentenciaConsultaOperacion();
                                                                                                    }
                                                                                         },'-',
                                                                                         {
                                                                                             xtype:'button',
                                                                                             text:'Fin si',
                                                                                             handler:function()
                                                                                                    {
                                                                                                        var obj=null;
                                                                                                        var comp='';
                                                                                                        var arrValor=new Array();
                                                                                                        if(arrConsulta.length>0)
                                                                                                        {
                                                                                                            obj=arrConsulta[arrConsulta.length-1];
                                                                                                            if((obj[2]!='1')||(obj[0]==')'))
                                                                                                            {
                                                                                                                arrValor[0]=';';
                                                                                                                arrValor[1]='';
                                                                                                                arrValor[2]=0;
                                                                                                                arrValor[3]='';
                                                                                                                arrValor[4]=[];
                                                                                                                arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            }
                                                                                                            comp='<br>';
                                                                                                        }
                                                                                                       
                                                                                                        
                                                                                                       
                                                                                                        arrValor=new Array();
                                                                                                        arrValor[0]='}';
                                                                                                        arrValor[1]=comp+'fin si';
                                                                                                        arrValor[2]=0;
                                                                                                        arrValor[3]='';
                                                                                                        arrValor[4]=[];
                                                                                                        arrConsulta[arrConsulta.length]=arrValor;
                                                                                                        generarSentenciaConsultaOperacion();
                                                                                                    }
                                                                                         },'-',
                                                                                         {
                                                                                             xtype:'button',
                                                                                             text:'>',
                                                                                             width:25,
                                                                                             handler:function()
                                                                                                    {
                                                                                                        if(validarOperador('>'))
                                                                                                        {
                                                                                                            var arrValor=new Array();
                                                                                                            arrValor[0]='>';
                                                                                                            arrValor[1]='>';
                                                                                                            arrValor[2]=0;
                                                                                                            arrValor[3]='';
                                                                                                            arrValor[4]=[];
                                                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            generarSentenciaConsultaOperacion();
                                                                                                        }
                                                                                                    }
                                                                                         },'-',
                                                                                         {
                                                                                             xtype:'button',
                                                                                             text:'&lt;',
                                                                                             width:25,
                                                                                             handler:function()
                                                                                                    {
                                                                                                        if(validarOperador('<'))
                                                                                                        {
                                                                                                            var arrValor=new Array();
                                                                                                            arrValor[0]='<';
                                                                                                            arrValor[1]='<';
                                                                                                            arrValor[2]=0;
                                                                                                            arrValor[3]='';
                                                                                                            arrValor[4]=[];
                                                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            generarSentenciaConsultaOperacion();
                                                                                                       }
                                                                                                    }
                                                                                         },'-',
                                                                                         {
                                                                                             xtype:'button',
                                                                                             text:'!',
                                                                                             width:25,
                                                                                             handler:function()
                                                                                                    {
                                                                                                        
                                                                                                            var arrValor=new Array();
                                                                                                            arrValor[0]='!';
                                                                                                            arrValor[1]='!';
                                                                                                            arrValor[2]=0;
                                                                                                            arrValor[3]='';
                                                                                                            arrValor[4]=[];
                                                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            generarSentenciaConsultaOperacion();
                                                                                                                                                                                        
                                                                                                    }
                                                                                         },'-',
                                                                                         {
                                                                                             xtype:'button',
                                                                                             text:'=',
                                                                                             width:25,
                                                                                             handler:function()
                                                                                                    {
                                                                                                        
                                                                                                            var arrValor=new Array();
                                                                                                            arrValor[0]='=';
                                                                                                            arrValor[1]='=';
                                                                                                            arrValor[2]=0;
                                                                                                            arrValor[3]='';
                                                                                                            arrValor[4]=[];
                                                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            generarSentenciaConsultaOperacion();
                                                                                                                                                                                        
                                                                                                    }
                                                                                         },
                                                                                         '-',
                                                                                         {
                                                                                             xtype:'button',
                                                                                             text:'Retornar valor',
                                                                                             handler:function()
                                                                                                    {
                                                                                                        var obj=null;
                                                                                                        var comp='';
                                                                                                        var arrValor=new Array();
                                                                                                        if(arrConsulta.length>0)
                                                                                                        {
                                                                                                            obj=arrConsulta[arrConsulta.length-1];
                                                                                                            if((obj[2]!='1')||(obj[0]==')'))
                                                                                                            {
                                                                                                                arrValor[0]=';';
                                                                                                                arrValor[1]='';
                                                                                                                arrValor[2]=0;
                                                                                                                arrValor[3]='';
                                                                                                                arrValor[4]=[];
                                                                                                                arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            }
                                                                                                        }
                                                                                                       
                                                                                                        comp='<br>';
                                                                                                        arrValor=new Array();
                                                                                                        arrValor[0]='$resultadoFinal= ';
                                                                                                        arrValor[1]='Valor final=';
                                                                                                        arrValor[2]=0;
                                                                                                        arrValor[3]='';
                                                                                                        arrValor[4]=[];
                                                                                                        arrConsulta[arrConsulta.length]=arrValor;
                                                                                                        generarSentenciaConsultaOperacion();
                                                                                                    }
                                                                                         },'-',
                                                                                         {
                                                                                             xtype:'button',
                                                                                             icon:'../images/flecha_azul_corta.gif',
                                                                                             width:25,
                                                                                             handler:function()
                                                                                                    {
                                                                                                        var obj=null;
                                                                                                        var comp='';
                                                                                                        var arrValor=new Array();
                                                                                                        if(arrConsulta.length>0)
                                                                                                        {
                                                                                                            obj=arrConsulta[arrConsulta.length-1];
                                                                                                            if((obj[2]!='1')||(obj[0]==')'))
                                                                                                            {
                                                                                                                arrValor[0]=';';
                                                                                                                arrValor[1]='';
                                                                                                                arrValor[2]=0;
                                                                                                                arrValor[3]='';
                                                                                                                arrValor[4]=[];
                                                                                                                arrConsulta[arrConsulta.length]=arrValor;
                                                                                                            }
                                                                                                        }
                                                                                                        arrValor=new Array();
                                                                                                        arrValor[0]='';
                                                                                                        arrValor[1]='<br />';
                                                                                                        arrValor[2]=0;
                                                                                                        arrValor[3]='';
                                                                                                        arrValor[4]=[];
                                                                                                        arrConsulta[arrConsulta.length]=arrValor;
                                                                                                        generarSentenciaConsultaOperacion();
                                                                                                    }
                                                                                         }
                                                                                         
                                                                                         
                                                                                         
                                                                                          
                                                                             		 ]
                                                                         }
                                                                    ),
                                              items: 	[//spArea
                                                          {
                                                          	xtype:'label',
                                                          	region:'center',
                                                            style: 	{
                                                            			backgroundColor:'#FFF'
                                                            		},
                                                            id:'txtArea',
                                                            
                                                            html:''
                                                          } 
                                                      ]
                                          }
                                      );
	
    return panel;
}

function modificarParametrosEntrada(iP)
{
	var gridParametros=crearGridParametros(iP);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridParametros	
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificaci&oacute;n de par&aacute;metros de entrada',
										width: 620,
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
                                                                    	var filaVacia=validarCampoNoVacio(gridParametros.getStore(),'valor');
                                                                        
																		if(filaVacia==-1)
                                                                        {
                                                                        	var x;
                                                                            var arrP=new Array();
                                                                            var obj;
                                                                            var fila;
                                                                            var comp='';
                                                                            for(x=0;x<gridParametros.getStore().getCount();x++)
                                                                            {
                                                                            	fila=gridParametros.getStore().getAt(x);
                                                                            	obj=new Array();
                                                                                if(fila.get('valor')=='21')
                                                                                	comp='$';
                                                                                obj[0]=comp+fila.get('parametro');
                                                                                obj[1]=fila.get('valor');
                                                                                obj[2]=fila.get('tipoValor');
                                                                                arrP.push(obj);
                                                                            }
                                                                            arrConsulta[iP][4]=arrP;
                                                                            generarSentenciaConsultaOperacion();
                                                                            ventanaAM.close();
                                                                            	
                                                                        }
                                                                        else	
                                                                        	msgBox('Algunos valores de par&aacute;metros no han sido especificados');
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

function crearGridParametros(iP)
{
	var arrTipoEntrada=[['7','Consulta auxiliar'],['17','Par\xE1metro'],['1','Valor Constante'],['3','Valor de sesi\xF3n'],['4','Valor de sistema'],['21','Valor de variable acumuladora']];
	var cmbTipoEntrada=crearComboExt('cmbTipoEntrada',arrTipoEntrada);
	var dsDatos=arrConsulta[iP][4];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'parametro'},
                                                                {name: 'valor'},
                                                                {name: 'tipoValor'}
                                                                
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Par&aacute;metro',
															width:150,
															sortable:true,
															dataIndex:'parametro'
														},
														{
															header:'Tipo valor entrada',
															width:170,
															sortable:true,
															dataIndex:'tipoValor',
                                                            editor:cmbTipoEntrada,
                                                            renderer:function(val)
                                                            			{
                                                                        	if(val=='')
                                                                            	return val;
                                                                        	var pos=existeValorMatriz(arrTipoEntrada,val,0);
                                                                           if(pos!=-1)
	                                                                            return arrTipoEntrada[pos][1];
                                                                           else
                                                                           		return "";
                                                                        }
														},
                                                        {
                                                        	header:'Valor',
															width:200,
															sortable:true,
															dataIndex:'valor',
                                                            editor:{xtype:'textfield'},
                                                            renderer:function(val,meta,registro)
                                                            		{
																		if(registro.get('tipoValor')!='')
                                                                        {
                                                                            if(registro.get('tipoValor')=='1')
                                                                                return val;	
                                                                            else
                                                                            {
                                                                            	if(val!='')
                                                                                {
                                                                                	var matriz=new Array();
                                                                                    
                                                                                	switch(registro.get('tipoValor'))
                                                                                    {
                                                                                    
                                                                                    	case '3':
                                                                                        	matriz=arrValorSesion;
                                                                                        break;
                                                                                        case '4':
                                                                                            matriz=arrValorSistema;
                                                                                        break;
                                                                                        case '7':
                                                                                              matriz=obtenerAlmacenesDatosDisponibles('2');
                                                                                        break;
                                                                                         case '21':
                                                                                            matriz=arrAcumuladores;
                                                                                        break;
                                                                                        case '17':
                                                                                            matriz=arrParametrosCalculo;
                                                                                        break;
                                                                                    }


	                                                                            	return formatearValorRenderer(matriz,val);
                                                                                }
                                                                            }
                                                                        }
                                                                        return val;
                                                                    }
                                                            
                                                        }
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:590,
                                                            clicksToEdit:1
                                                           
                                                        }
                                                    );
	tblGrid.on('beforeedit',funcParamEdit);  
    tblGrid.on('afteredit',funcParamEditAfter);                                                    
	return 	tblGrid;	
}

function funcParamEdit(e)
{
	var cmbValor=crearComboExt('cmbValor',arrAcumuladores);
    var txtValor=new Ext.form.TextField({});
	if(e.record.get('tipoValor')!='')	
    {
    	
    	switch(e.record.get('tipoValor'))
        {
        	case '1':
            	e.grid.getColumnModel().setEditor(3,txtValor);
            break;
            
            case '3':
            	e.grid.getColumnModel().setEditor(3,cmbValor);
                cmbValor.getStore().loadData(arrValorSesion);
            break;
            case '4':
            	e.grid.getColumnModel().setEditor(3,cmbValor);
                cmbValor.getStore().loadData(arrValorSistema);
            break;
            case '7':
            	e.grid.getColumnModel().setEditor(3,cmbValor);
                 var arrConsultaAux=new Array();
                    var arbolDataSet=gEx('arbolDataSet');
                    var raiz=arbolDataSet.getRootNode();
                    var nodoConsulta=raiz.childNodes[1];
                    var x;
                    var obj;
                    for(x=0;x<nodoConsulta.childNodes.length;x++)
                    {
                        
                            obj=new Array();
                            obj[0]=nodoConsulta.childNodes[x].id;
                            obj[1]='Consulta: '+nodoConsulta.childNodes[x].text;
                            arrConsultaAux.push(obj);
                        
                    }
                    cmbValor.getStore().loadData(arrConsultaAux);
            break;
             case '21':
            	e.grid.getColumnModel().setEditor(3,cmbValor);
                cmbValor.getStore().loadData(arrAcumuladores);
            break;
            case '17':
            	e.grid.getColumnModel().setEditor(3,cmbValor);
                cmbValor.getStore().loadData(arrParametrosCalculo);
            break;
   		}
    }
    else
    	e.grid.getColumnModel().setEditor(3,null);
}

function funcParamEditAfter(e)
{
	var cmbValor=crearComboExt('cmbValor',arrAcumuladores);
    var txtValor=new Ext.form.TextField({});

	if(e.field=='tipoValor')	
    {
    	e.record.set('valor','');
    	switch(e.value)
        {
        	case '1':
            	e.grid.getColumnModel().setEditor(3,txtValor);
            break;
            /*case '2':
            	e.grid.getColumnModel().setEditor(3,cmbValor);
            break;*/
            case '3':
            	e.grid.getColumnModel().setEditor(3,cmbValor);
                cmbValor.getStore().loadData(arrValorSesion);
            break;
            case '4':
            	e.grid.getColumnModel().setEditor(3,cmbValor);
                cmbValor.getStore().loadData(arrValorSistema);
            break;
            case '7':
            	e.grid.getColumnModel().setEditor(3,cmbValor);
                 var arrConsultaAux=new Array();
                    var arbolDataSet=gEx('arbolDataSet');
                    var raiz=arbolDataSet.getRootNode();
                    var nodoConsulta=raiz.childNodes[1];
                    var x;
                    var obj;
                    for(x=0;x<nodoConsulta.childNodes.length;x++)
                    {
                        
                            obj=new Array();
                            obj[0]=nodoConsulta.childNodes[x].id;
                            obj[1]='Consulta: '+nodoConsulta.childNodes[x].text;
                            arrConsultaAux.push(obj);
                        
                    }
                    cmbValor.getStore().loadData(arrConsultaAux);
            break;
            case '15':
            case '21':
            	e.grid.getColumnModel().setEditor(3,cmbValor);
                cmbValor.getStore().loadData(arrAcumuladores);
            break;
            case '17':
            	e.grid.getColumnModel().setEditor(3,cmbValor);
                cmbValor.getStore().loadData(arrParametrosCalculo);
            break;
        }
    }
}

function mostrarVentanaExpresion(destino)
{
	var cmbCategoriaExpresion=crearComboExt('cmbCategoriaExpresion',arrCategoriasExpresion,160,10,350);
    cmbCategoriaExpresion.setValue(arrCategoriasExpresion[0][0]);
    cmbCategoriaExpresion.on('select',function(cmb,registro)
    									{
                                        	gEx('gExpresiones').getStore().load({params:{start:0, limit:15,funcion:146,idCategoria:registro.get('id')}});
                                        }
    						)
	var gridExpresiones=crearGridExpresiones();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:15,
                                                        	html:'Categor&iacute;a de la expresi&oacute;n: '
                                                        },
                                            			cmbCategoriaExpresion,
                                            			{
                                                        	x:10,
                                                            y:50,
                                                        	html:'Seleccione la expresi&oacute;n que desea agregar: '
                                                        },
														gridExpresiones

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar expresi&oacute;n',
										width: 800,
										height:415,
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
                                                                    	var filas=gridExpresiones.getSelectionModel().getSelected();
                                                                    	if(filas==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar la expresi&oacute;n a agregar');
                                                                        	return;
                                                                        }
                                                                        idConsulta=filas.get('idConsulta');
                                                                        if(destino==undefined)
                                                                        {
                                                                            mostrarCampoF('txtValor');
                                                                            var txtValor=Ext.getCmp('txtValor');
                                                                            txtValor.setValue(filas.get('nombreConsulta'));
                                                                            txtValor.disable();
                                                                            valExpresion=true;
                                                                        }
                                                                        else
                                                                        {
																			switch(destino)
                                                                            {
                                                                            	case 1:
                                                                                	var nombreConsulta=filas.get('nombreConsulta');	
                                                                                    var arrValor=new Array();
                                                                                    arrValor[0]= "'@"+nombreConsulta+"'";
                                                                                    arrValor[1]= '<span style=\'color:#900\'>Ejecutar: </span><span style=\'color:#000\'><b><i>'+nombreConsulta+'</i></b> </span>';
                                                                                    arrValor[2]= '-'+idConsulta;
                                                                                    arrValor[3]=filas.get('valorRetorno');
                                                                                    arrValor[4]=filas.get('parametros');
                                                                                    arrConsulta[arrConsulta.length]=arrValor;
                                                                                    generarSentenciaConsultaOperacion();
                                                                                break;
                                                                                case 2:
                                                                                	valRetornoExp=filas.get('valorRetorno');
                                                                                    switch(valRetornoExp)
                                                                                    {
                                                                                    	case 'date':
                                                                                        	if(operacionFecha=='-')
                                                                                            {
                                                                                            	mEx('lblTrato');
                                                                                                mEx('cmbUnidadRes');
                                                                                            }
                                                                                            if(operacionFecha=='+')
                                                                                            {
                                                                                            	msgBox('La expresi&oacute;n seleccionada no es compatible con la operaci&oacute;n');
	                                                                                            return;
                                                                                            }
                                                                                    	case 'int':
                                                                                        case 'tinyint':
                                                                                        	mEx('txtValorExp');
                                                                                            mEx('lblValor');
                                                                                            var txtValor=Ext.getCmp('txtValorExp');
                                                                                            txtValor.setValue(filas.get('nombreConsulta'));
                                                                                            
                                                                                            if((valRetornoExp=='tinyint')||(valRetornoExp=='int'))
                                                                                            {
                                                                                            	mEx('cmbUnidadSuma');
                                                                                                Ext.getCmp('cmbUnidadSuma').setPosition(300,65);
                                                                                            }
                                                                                        break;
                                                                                        default:
                                                                                        	msgBox('La expresi&oacute;n seleccionada no es compatible con la operaci&oacute;n');
                                                                                            return;
                                                                                        break;
																					}                                                                                	
                                                                                break;
                                                                            }
                                                                        	
                                                                        }
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
	//llenarGridExpresiones(ventanaAM,gridExpresiones);
}

function crearGridExpresiones()
{
	var dsDatos=[];
    
    var dsTablaRegistros = new Ext.data.JsonStore	(

																			{

																				root: 'registros',

																				totalProperty: 'numReg',

																				idProperty: 'idConsulta',

																				fields: 	[
                                                                                              {name: 'idConsulta'},
                                                                                              {name: 'nombreConsulta'},
                                                                                              {name: 'nombreCategoria'},
                                                                                              {name: 'descripcion'},
                                                                                              {name: 'valorRetorno'},
                                                                                              {name: 'parametros'}
                                                                                          ],

																				remoteSort:true,

																				proxy: new Ext.data.HttpProxy	(

																													{

																														url: '../paginasFunciones/funcionesProyectos.php'

																													}

																												)
                                                                              }
                                                    )

    function cargarDatos(proxy,parametros)
    {
        proxy.baseParams.funcion=146;
        proxy.baseParams.idCategoria=gEx('cmbCategoriaExpresion').getValue()
    }                                      

																	

	dsTablaRegistros.on('beforeload',cargarDatos); 
    
    
     var expander = new Ext.ux.grid.RowExpander({
                                                    column:2,
                                                    tpl : new Ext.Template(
                                                                                '<br><table >'+
                                                                                '<tr><td width:"230"><span class="letraRojaSubrayada8"><b>Descripci&oacute;n:</b></span></td><td></td></tr><tr><td></td><td><span class="copyrigthSinPadding">{descripcion}</span><br /><br /></td></tr>'+
                                                                                '</table>'
                                                                            )
    											}
                                               )
    var tamPagina =	15;     

																							

    var paginador=	new Ext.PagingToolbar	(

                                                {

                                                      pageSize: tamPagina,

                                                      store: dsTablaRegistros,

                                                      displayInfo: true,

                                                      disabled:false

                                                  }

                                               )   
	var filters = new Ext.ux.grid.GridFilters	(

    												{

                                                    	filters:	[ {type: 'string', dataIndex: 'nombreConsulta'}, {type: 'string', dataIndex: 'nombreCategoria'}]

                                                    }

                                                );                                                       
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
                                                        expander,
														chkRow,
                                                        {
															header:'ID Expresi&oacute;n',
															width:100,
															sortable:true,
															dataIndex:'idConsulta'
														},
														{
															header:'Expresi&oacute;n',
															width:320,
															sortable:true,
															dataIndex:'nombreConsulta'
														},
														{
															header:'Tipo expresion',
															width:270,
															sortable:true,
															dataIndex:'nombreCategoria',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val;
                                                                        }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gExpresiones',
                                                            store:dsTablaRegistros,
                                                            frame:true,
                                                            y:70,
                                                            cm: cModelo,
                                                            height:265,
                                                            width:750,
                                                            sm:chkRow,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            bbar: paginador,
                                                            plugins:[filters,expander]

                                                        }
                                                    );
	dsTablaRegistros.load({params:{start:0, limit:tamPagina,funcion:146}});                                                    
	return 	tblGrid;
}

function llenarGridExpresiones(ventanaAM,grid)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	grid.getStore().loadData(eval(arrResp[1]));
            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=146',true);
}

function mostrarVentanaParametro(grid)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Par&aacute;metro a registrar:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	id:'txtValorIns',
                                                        	x:150,
                                                            y:5,
                                                            enableKeyEvents :true,
                                                            maskRe:/^[_a-zA-Z0-9]$/,
                                                            width:200
                                                        }
													]
										}
									);

	


	var ventana = new Ext.Window(
									{
										title: 'Registrar par&aacute;metro',
										width: 380,
										height:120,
										minWidth: 300,
										minHeight: 100,
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
																	Ext.getCmp('txtValorIns').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															id:'btnAceptar',
															text: 'Aceptar',
															listeners:	{
																			click:function()
																				{
																					var valor=Ext.getCmp('txtValorIns').getRawValue();
                                                                                    if(valor=='')
                                                                                    {
                                                                                    	function resp()
                                                                                        {
                                                                                        	Ext.getCmp('txtValorIns').focus();
                                                                                        }
                                                                                    	msgBox('El par&aacute;metro ingresado no es v&aacute;lido',resp);
                                                                                    	return;
                                                                                    }	
                                                                                    
                                                                                    if(existeValorArreglo(arrParametros,valor)!=-1)
                                                                                    {
                                                                                    	msgBox('Ya existe un par&aacute;metro registrado con el nombre ingresado');
                                                                                        return;
                                                                                    }
                                                                                    
                                                                                    valor=valor.replace("$","");
                                                                                    valor=valor.replace("\"","");
                                                                                    valor=valor.replace("!","");
                                                                                    valor=valor.replace("#","");
                                                                                    valor=valor.replace("%","");
                                                                                    valor=valor.replace("&","");
                                                                                    
                                                                                    arrParametros[arrParametros.length]=valor;
                                                                                    ventana.close();
                                                                                    var mnuParametro=Ext.getCmp('parametro');
                                                                                    mnuParametro.enable();
                                                                                    var menu=	{
                                                                                                    id:'p'+valor,
                                                                                                    text:'['+valor+']',
                                                                                                    handler:function()
                                                                                                            {
                                                                                                                
                                                                                                                var arrValor=new Array();
                                                                                                                arrValor[0]=''+valor;
                                                                                                                arrValor[1]='['+valor+']';
                                                                                                                arrValor[2]=6;
                                                                                                                arrValor[3]='';
                                                                                                                arrValor[4]=[];
                                                                                                                arrConsulta[arrConsulta.length]=arrValor;
                                                                                                                generarSentenciaConsultaOperacion();
                                                                                                            }
                                                                                                }
                                                                                    mnuParametro.menu.add(menu);
                                                                                    objParam=new Array();
                                                                                    objParam[0]=valor;
                                                                                    objParam[1]=valor;
                                                                                    arrParametrosCalculo.push(objParam);
                                                                                    if(grid)
                                                                                    	grid.getStore().loadData(arrParametrosCalculo);
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

function generarSentenciaConsultaOperacion()
{
	var x;
    var txtConsulta='';
    sentenciaMysql='';
    var comp='';
    var compAux='';
    var valorParam='';
    var exclamacion='';
    var apTag='';
    var cTag='';
    arrAcumuladores=new Array();
	for(x=0;x<arrConsulta.length;x++)
    {
    	comp='';
        apTag='';
        cTag='';
        exclamacion='';
        compAux='';
		
        switch(arrConsulta[x][2])
        {
        	case 21:
            case '21':
                apTag='<b>';
                cTag='</b>';
                compAux=' title="Variable acumuladora" alt="Variable acumuladora"';
                var nAcum=arrConsulta[x][2][0];
                nAcum=arrConsulta[x][1].substr(1);
                //var nValorAcum=arrConsulta[x][0].substr(1);
                if(nAcum.substr(nAcum.length-1)=='=')
                {
                    nAcum=nAcum.substr(0,nAcum.length-1);
                    //nValorAcum=nValorAcum.substr(0,nValorAcum.length-1);
                }
               
                if(arrConsulta[x][5]!='0')
                {
                	var arrDatos=arrConsulta[x][1].split("[");
                    nAcum=arrDatos[0].replace("@","");
                }
               	nAcum=nAcum.replace("=","");
                if(existeValorMatriz(arrAcumuladores,nAcum,0)==-1)
                {
                    var objAcum=new Array();
                    objAcum[0]=nAcum;
                    objAcum[1]='@'+nAcum;
                    var idReferencia=0;
                    if(arrConsulta[x][5]!=undefined)
                    	idReferencia=arrConsulta[x][5];
                    objAcum[2]=idReferencia;
                    arrAcumuladores.push(objAcum);
                }
            break;
            case 1:
            case '1':
                apTag='<font color="#FF0000">';
                cTag='</font>';
            break;
            case 0:
            case '0':
                apTag='<font color="#090">';
                cTag='</font>';
            break;
           case 22:
           case '22':
           		apTag='<font color="#900">';
                cTag='</font>';
                exclamacion='&nbsp;<a href="javascript:modificarValorParametroFuncion(\''+bE(x)+'\')"><img height="13" width="13" src="../images/pencil.png" title="Modificar valor de parametros" alt="Modificar valor de parametros"></a>';
           break;
           case 7:
           case '7':
           case 11:
           case '11':
           		apTag='<font color="#906">';
                cTag='</font>';
           break;
           case '25':
           		if(arrConsulta[x][0].indexOf('|')==-1)
                {
                    var objAlmacen=eval('['+arrConsulta[x][0]+']')[0];
                    var ctAux;
                    var p;
                    arrConsulta[x][4]=new Array();
                    for(ctAux=0;ctAux<objAlmacen.parametros.length;ctAux++)
                    {
                        p=objAlmacen.parametros[ctAux];
                        arrConsulta[x][4].push([p.parametro,p.valorSistema,p.tipoValor]);
                    }
                    arrConsulta[x][0]=objAlmacen.tipoOrigen+'|'+objAlmacen.idOrigen;
                }
           break;
            
        }
        var paramVacio=false;
        
        if(arrConsulta[x][2]=='22')
        {
        	var comilla1=/\["/gi;
            var comilla2=/"\]/gi;
            
            
        	var cadObjAux=arrConsulta[x][0];
            cadObjAux=cadObjAux.replace(comilla1,'[\\"');
            cadObjAux=cadObjAux.replace(comilla2,'\\"]');

        	var objFuncion=eval('['+cadObjAux+']')[0];
            var ctAux;
            if(objFuncion.parametros!=undefined)
            {
                for(ctAux=0;ctAux<objFuncion.parametros.length;ctAux++)
                {
                    if(objFuncion.parametros[ctAux].tipoValor=='21')
                    {
                        var cadAux=objFuncion.parametros[ctAux].valorSistema;
                        var arrAux=cadAux.split('[');
                        var nAcum=arrAux[0];
                        if(existeValorMatriz(arrAcumuladores,nAcum,0)==-1)
                        {
                            var objAcum=new Array();
                            objAcum[0]=nAcum;
                            objAcum[1]='@'+nAcum;
                            objAcum[2]=objFuncion.parametros[ctAux].idReferencia;
                            arrAcumuladores.push(objAcum);
                            var idReferencia=objFuncion.parametros[ctAux].idReferencia;
                            
                             var variableAcumuladora=Ext.getCmp('variableAcumuladora');
                            
                            
                            valor=nAcum;
                            if(gEx('ac'+valor)==null)
                            {
                                variableAcumuladora.enable();
                                var menu;
                                if(idReferencia=='0')	
                                {
                                    menu=	{
                                                id:'ac'+valor,
                                                text:'@'+valor,
                                                handler:function()
                                                        {
                                                            
                                                            var arrValor=new Array();
                                                            arrValor[0]='$'+valor;
                                                            arrValor[1]='@'+valor;
                                                            arrValor[2]=21;
                                                            arrValor[3]='';
                                                            arrValor[4]=[];
                                                            arrValor[5]=idReferencia;
                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                            generarSentenciaConsultaOperacion();
                                                        }
                                            }
                                            
                                        
                                            
                                }
                                else
                                {
                                    if(gEx('ac'+arrConsulta[x][5])!=null)
                                        continue;
                                    var arrMenus=new Array();
                                    var pos=existeValorMatriz(arrEstructuras,idReferencia);
                                    var f=arrEstructuras[pos];
                                    var xAux;
                                    var menuAux;
                                    var vAux;
                                    var idMenu;
                                    if(valor.indexOf('[')!=-1)
                                    {
                                        var arrValor=valor.split('[');
                                        valor=arrValor[0];
                                    }
                                    for(xAux=0;xAux<f[2].length;xAux++)
                                    {
                                        vAux=valor+'["'+f[2][xAux][1]+'"]';
                                        vAux2=valor+'["'+f[2][xAux][0]+'"]';
                                        idMenu='ac_'+f[2][xAux][0];
                                        
                                        var calMenu= "menuAux=new Ext.menu.Item	(		{"+
                                                                                            "id:'"+idMenu+"',"+
                                                                                            "text:'"+f[2][xAux][1]+"',"+
                                                                                            "handler:function()"+
                                                                                                    "{"+
                                                                                                        "var arrValor=new Array();"+
                                                                                                        "arrValor[0]='$"+vAux2+"';"+
                                                                                                        "arrValor[1]='@"+vAux+"';"+
                                                                                                        "arrValor[2]=21;"+
                                                                                                        "arrValor[3]='';"+
                                                                                                        "arrValor[4]=[];"+
                                                                                                        "arrValor[5]='"+idReferencia+"';"+
                                                                                                        "arrConsulta[arrConsulta.length]=arrValor;"+
                                                                                                        "generarSentenciaConsultaOperacion();"+
                                                                                                    "}"+
                                                                                        "}"+
                                                                                   ")";
                                        eval(calMenu);
                                        arrMenus.push(menuAux);                
                                    }
                                   
                                    menu=	{
                                                id:'ac_'+idReferencia,
                                                text:'@'+valor,
                                                handler:function()
                                                        {
                                                            var arrID=this.id.split('_');
                                                            var arrValor=new Array();
                                                            arrValor[0]='$'+valor;
                                                            arrValor[1]='@'+valor;
                                                            arrValor[2]=21;
                                                            arrValor[3]='';
                                                            arrValor[4]=[];
                                                            
                                                            arrValor[5]=arrID[1]+'_'+arrID[2];
                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                            generarSentenciaConsultaOperacion();
                                                        },
                                                 menu:arrMenus
                                            }
                                }
                                variableAcumuladora.menu.add(menu);
                            
                            }
                            
                            
                            
                        }
                    }
                    else
                    {
                        if(objFuncion.parametros[ctAux].tipoValor=='')
                        {
                            paramVacio=true;
                            
                        }
                    }
                }
        	}
        } 
        
        if(paramVacio)
        	exclamacion='&nbsp;<a href="javascript:modificarValorParametroFuncion(\''+bE(x)+'\')"><img src="../images/exclamation.png" title="Algunos par&aacute;metros requerido para la ejecuci&oacute;n de esta expresi&oacute;n no han sido especificados, para hacerlo de click AQU&Iacute;" alt="Algunos par&aacute;metros requerido para la ejecuci&oacute;n de esta expresi&oacute;n no han sido especificados, para hacerlo de click AQU&Iacute;"></a>';   
        
        if((parseFloat(arrConsulta[x][2])<0)||(arrConsulta[x][2]=='25'))
        {
        	
            if(arrConsulta[x][4].length>0)
            {
                
                var y;
                
                for(y=0;y<arrConsulta[x][4].length;y++)
                {
                    valorParam='Sin valor';
                    
                    if(arrConsulta[x][4][y][1]!='')
                    {
                        valorParam=arrConsulta[x][4][y][1];
                        if(arrConsulta[x][4][y][2]=='2')
                            valorParam='@'+valorParam;
                       
                    }
                    else
                    {
                        exclamacion=' <img src="../images/exclamation.png" title="Esta expresi&oacute;n espera valores de de entrada como par&aacute;metros, los cuales no han sido ingresados a&uacute;n, para hacerlo de click sobre el nombre de la expresi&oacute;n" alt="Esta expresi&oacute;n espera valores de de entrada como par&aacute;metros, los cuales no han sido ingresados a&uacute;n, para hacerlo de click sobre el nombre de la expresi&oacute;n">';
                    }
                    if(comp=='')
                        comp='Parametros: ['+arrConsulta[x][4][y][0]+']='+valorParam;
                    else	
                        comp+=',['+arrConsulta[x][4][y][0]+']='+valorParam;
                   
                    
                }
                if(exclamacion=='')
                {
                    exclamacion=' <img src="../images/icon_info.gif" title="Esta expresi&oacute;n espera valores de de entrada como par&aacute;metros,  para modificar dichos valores de click sobre el nombre de la expresi&oacute;n" alt="Esta expresi&oacute;n espera valores de de entrada como par&aacute;metros,  para modificar dichos valores de click sobre el nombre de la expresi&oacute;n">';
                }
                apTag='<a href="javascript:modificarParametrosEntrada('+x+')"><font color="0000FF">';     
                cTag='</font></a>';
                compAux='title="'+comp+'"';
                
            }
        }
    	txtConsulta+=' <span '+compAux+'>'+apTag+arrConsulta[x][1].replace(/<br>/g,'<br />')+cTag+exclamacion+'</span>';
    }
    
    
    var tmp;
    for(tmp=0;tmp<variableAcumRegistrada.length;tmp++)
    {
    	if(existeValorMatriz(arrAcumuladores,variableAcumRegistrada[tmp][0],0)==-1)
        {
        	arrAcumuladores.push(variableAcumRegistrada[tmp]);
        }
    }
    
    gEx('txtArea').setText(txtConsulta,false);
}

function validarOperador(operador)
{
	var arrValor=null;
	if(arrConsulta.length>0)
		arrValor=arrConsulta[arrConsulta.length-1];
	switch(operador)
    {
    	case 'Y':
        	if((arrValor==null)||((arrValor[2]=='0')&&(arrValor[1]!=')')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
        break;
        case 'O':
        	if((arrValor==null)||((arrValor[2]=='0')&&(arrValor[1]!=')')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
        break;
    	case '+':
        	if((arrValor==null)||((arrValor[2]=='0')&&(arrValor[1]!=')')&&(arrValor[0]!='+')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
            if(arrValor[3]=='date')
            {
            	mostrarVentanaOperacionFecha('+');
            	return false;
            }
        break;
        case '-':
        	if((arrValor==null)||((arrValor[2]=='0')&&(arrValor[1]!=')')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
            if(arrValor[3]=='date')
            {
            	mostrarVentanaOperacionFecha('-');
            	return false;
            }
        break;
        case '*':
        	if((arrValor==null)||((arrValor[2]=='0')&&(arrValor[1]!=')')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
            if(arrValor[3]=='date')
            {
            	msgBox('El operador seleccionado no puede ser aplicado a operandos de tipo fecha');
            	return false;
            }
        break;
        case '/':
        	if((arrValor==null)||((arrValor[2]=='0')&&(arrValor[1]!=')')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
            if(arrValor[3]=='date')
            {
            	msgBox('El operador seleccionado no puede ser aplicado a operandos de tipo fecha');
            	return false;
            }
        break;
        case '>':
        	if((arrValor==null)||((arrValor[2]=='0')&&(arrValor[1]!=')')))            
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
        break;
        case '<':
        	if((arrValor==null)||((arrValor[2]=='0')&&(arrValor[1]!=')')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
        break;
        case '=':
        	if((arrValor==null)||((arrValor[2]=='0')&&(arrValor[1]!='>')&&(arrValor[1]!='<')&&(arrValor[1]!=')')&&(arrValor[0]!='+')&&(arrValor[0]!='-')&&(arrValor[0]!='*')&&(arrValor[0]!='/')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
        break;
        case ')':
        	if((arrValor==null)||((arrValor[2]=='0')&&(arrValor[0]!='+')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
        break;
    }
    return true;
}

var arrTiempo=[['days','D\xEDas'],['weeks','Semanas'],['months','Meses'],['years','A\xF1os']]
var arrValSuma=[['1','Valor num\xE9rico'],['2','Expresi\xF3n']];
var  operacionFecha='';

function mostrarVentanaOperacionFecha(operacion)
{
	operacionFecha=operacion;
	var oper='Suma';
    var lblAux='sumar';
    var cmbValorSuma=crearComboExt('cmbValorSuma',arrValSuma,110,35);
    
    function funValSumaChange(combo,registro)
    {
    	if(registro.get('id')=='1')
        {
			mEx('lblValor');
            mEx('txtValorSuma');
            mEx('cmbUnidadSuma');
            oEx('lblTrato');
            oEx('cmbUnidadRes');
            oEx('txtValorExp');
            Ext.getCmp('cmbUnidadSuma').setPosition(170,65);
        }
        else
        {
        	mostrarVentanaExpresion(2);
        	oEx('lblValor');
            oEx('txtValorExp');
            oEx('txtValorSuma');
            oEx('cmbUnidadSuma');
            oEx('lblTrato');
            oEx('cmbUnidadRes');
        }
    }
    cmbValorSuma.on('select',funValSumaChange);
    var cmbUnidadSuma=crearComboExt('cmbUnidadSuma',arrTiempo,170,65,110);
    cmbUnidadSuma.setValue('days');
    cmbUnidadSuma.hide();
    var cmbUnidadRes=crearComboExt('cmbUnidadRes',arrTiempo,110,95,110);
    cmbUnidadRes.hide();
    cmbUnidadRes.setValue('days');
    if(operacion=='-')
    {
    	oper='Resta';
        lblAux='restar';
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
                                                            html:'Operaci&oacute;n a ejecutar: <b>'+oper+'</b>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Valor a '+lblAux+':'
                                                        },
                                                        cmbValorSuma,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Valor: ',
                                                            hidden:true,
                                                            id:'lblValor'
                                                            
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            x:110,
                                                            y:65,
                                                            id:'txtValorSuma',
                                                            width:60,
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            hidden:true
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            x:110,
                                                            y:65,
                                                            width:180,
                                                            id:'txtValorExp',
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            readOnly:true,
                                                            hidden:true
                                                        },
                                                        cmbUnidadSuma,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Tratar valor en: ',
                                                            hidden:true,
                                                            id:'lblTrato'
                                                            
                                                        },
                                                        cmbUnidadRes

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: oper+'r valor a operando tipo fecha',
										width: 440,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var vSuma=cmbValorSuma.getValue();
																		if(vSuma=='')
                                                                        {
                                                                        	function respTV()
                                                                            {
                                                                            	cmbValorSuma.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar el tipo de valor a utilizar',respTV);
                                                                        	return;
                                                                        }		
                                                                        
                                                                        switch(vSuma)
                                                                        {
                                                                        	case '1':
                                                                            	var txtValorSuma=Ext.getCmp('txtValorSuma');
                                                                                if(txtValorSuma.getValue()=='')
                                                                                {
                                                                                	function respVal()
                                                                                    {
                                                                                    	txtValorSuma.focus();
                                                                                    }
                                                                                	msgBox('Debe ingresar el valor a '+lblAux,respVal);
                                                                                	return;
                                                                                }
                                                           						
                                                                                var arrValor=arrConsulta[arrConsulta.length-1];
                                                                                var nValor='('+arrValor[1]+' '+operacion+' '+txtValorSuma.getValue()+' '+cmbUnidadSuma.getRawValue()+')';
                                                                                var nValorSql='strtotime("'+operacion+' '+txtValorSuma.getValue()+' '+cmbUnidadSuma.getValue()+'",strtotime('+arrValor[0]+'))' ;
                                                                                var vRetorno='date';
                                                                                arrConsulta[arrConsulta.length-1][0]=nValorSql;
                                                                                arrConsulta[arrConsulta.length-1][1]=nValor
                                                                                arrConsulta[arrConsulta.length-1][3]=vRetorno;
                                                                                generarSentenciaConsultaOperacion();
                                                                            break;
                                                                            case '2':
                                                                            	switch(valRetornoExp)
                                                                                {
                                                                                	case 'int':
                                                                                    case 'tinyint':
                                                                                    	var txtValorSuma=gEx('txtValorExp');
                                                                                    	var arrValor=arrConsulta[arrConsulta.length-1];
                                                                                        var nValor='('+arrValor[1]+' '+operacion+' '+txtValorSuma.getValue()+' '+cmbUnidadSuma.getRawValue()+')';
                                                                                        var nValorSql='strtotime("'+operacion+' @'+txtValorSuma.getValue()+' '+cmbUnidadSuma.getValue()+'",strtotime('+arrValor[0]+'))' ;
                                                                                        var vRetorno='date';
                                                                                        arrConsulta[arrConsulta.length-1][0]=nValorSql;
                                                                                        arrConsulta[arrConsulta.length-1][1]=nValor;
                                                                                        arrConsulta[arrConsulta.length-1][2]=arrConsulta[arrConsulta.length-1][2]+'|-'+idConsulta;
                                                                                        arrConsulta[arrConsulta.length-1][3]=vRetorno;
                                                                                        generarSentenciaConsultaOperacion();	
                                                                                    break;
                                                                                    case 'date':
                                                                                    	switch(cmbUnidadRes.getValue())
                                                                                        {
                                                                                        	case 'days':
                                                                                            	var txtValorSuma=gEx('txtValorExp');
                                                                                                var arrValor=arrConsulta[arrConsulta.length-1];
                                                                                                var nValor='(('+arrValor[1]+' '+operacion+' '+txtValorSuma.getValue()+' '+') en '+cmbUnidadRes.getRawValue()+')';
                                                                                                var nValorSql='obtenerDiferenciaDias("'+arrValor[0]+'","@'+txtValorSuma.getValue()+'")' ;
                                                                                                var vRetorno='int';
                                                                                                arrConsulta[arrConsulta.length-1][0]=nValorSql;
                                                                                                arrConsulta[arrConsulta.length-1][1]=nValor;
                                                                                                arrConsulta[arrConsulta.length-1][2]=arrConsulta[arrConsulta.length-1][2]+'|-'+idConsulta;
                                                                                                arrConsulta[arrConsulta.length-1][3]=vRetorno;
                                                                                                generarSentenciaConsultaOperacion();	
                                                                                            break;
                                                                                            case 'weeks':
                                                                                            	var txtValorSuma=gEx('txtValorExp');
                                                                                                var arrValor=arrConsulta[arrConsulta.length-1];
                                                                                                var nValor='(('+arrValor[1]+' '+operacion+' '+txtValorSuma.getValue()+' '+') en '+cmbUnidadRes.getRawValue()+')';
                                                                                                var nValorSql='obtenerDiferenciaSemanas("'+arrValor[0]+'","@'+txtValorSuma.getValue()+'")' ;
                                                                                                var vRetorno='int';
                                                                                                arrConsulta[arrConsulta.length-1][0]=nValorSql;
                                                                                                arrConsulta[arrConsulta.length-1][1]=nValor;
                                                                                                arrConsulta[arrConsulta.length-1][2]=arrConsulta[arrConsulta.length-1][2]+'|-'+idConsulta;
                                                                                                arrConsulta[arrConsulta.length-1][3]=vRetorno;
                                                                                                generarSentenciaConsultaOperacion();	
                                                                                            
                                                                                            break;
                                                                                            case 'months':
                                                                                            	var txtValorSuma=gEx('txtValorExp');
                                                                                                var arrValor=arrConsulta[arrConsulta.length-1];
                                                                                                var nValor='(('+arrValor[1]+' '+operacion+' '+txtValorSuma.getValue()+' '+') en '+cmbUnidadRes.getRawValue()+')';
                                                                                                var nValorSql='obtenerDiferenciaMeses("'+arrValor[0]+'","@'+txtValorSuma.getValue()+'")' ;
                                                                                                var vRetorno='int';
                                                                                                arrConsulta[arrConsulta.length-1][0]=nValorSql;
                                                                                                arrConsulta[arrConsulta.length-1][1]=nValor;
                                                                                                arrConsulta[arrConsulta.length-1][2]=arrConsulta[arrConsulta.length-1][2]+'|-'+idConsulta;
                                                                                                arrConsulta[arrConsulta.length-1][3]=vRetorno;
                                                                                                generarSentenciaConsultaOperacion();	
                                                                                            
                                                                                            break;
                                                                                            case 'years':
                                                                                            	var txtValorSuma=gEx('txtValorExp');
                                                                                                var arrValor=arrConsulta[arrConsulta.length-1];
                                                                                                var nValor='(('+arrValor[1]+' '+operacion+' '+txtValorSuma.getValue()+' '+') en '+cmbUnidadRes.getRawValue()+')';
                                                                                                var nValorSql='obtenerDiferenciaAnios("'+arrValor[0]+'","@'+txtValorSuma.getValue()+'")' ;
                                                                                                var vRetorno='int';
                                                                                                arrConsulta[arrConsulta.length-1][0]=nValorSql;
                                                                                                arrConsulta[arrConsulta.length-1][1]=nValor;
                                                                                                arrConsulta[arrConsulta.length-1][2]=arrConsulta[arrConsulta.length-1][2]+'|-'+idConsulta;
                                                                                                arrConsulta[arrConsulta.length-1][3]=vRetorno;
                                                                                                generarSentenciaConsultaOperacion();	
                                                                                            
                                                                                            break;
                                                                                        }
                                                                                    break;
                                                                                }
                                                                            break;
                                                                            
                                                                        }
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

function guardarExpresionFinal()
{
	var x;
    var valorPredominio='int';
    var arrTokens='';
    var idConsultaExp=bD(gE('idConsultaExp').value);
    /*if(arrConsulta.length==0)
    {
    	msgBox('La expresi&oacute;n no puede ser vac&iacute;a');
    	return;
    }*/
    
    var valParametros='';
    var arrParam;
    var z;
    var cadParam='';
    var comp1='';
   
	for(x=0;x<arrConsulta.length;x++)
    {
    	arrParam=arrConsulta[x][4];
        valParametros='';
        for(z=0;z<arrParam.length;z++)
        {
        	cadParam=arrParam[z][0]+','+arrParam[z][1]+','+arrParam[z][2];
        	if(valParametros=='')
            	valParametros=cadParam;
            else
            	valParametros+='|'+cadParam;
        }
        comp1='';
        if(arrConsulta[x][5]!=undefined)
	        comp1=arrConsulta[x][5];
        token='{"comp1":"'+comp1+'","tokenUsuario":"'+cv(arrConsulta[x][1])+'","tokenMysql":"'+cv(arrConsulta[x][0])+'","tipoToken":"'+arrConsulta[x][2]+'","valorDevuelto":"'+arrConsulta[x][3]+'","valParametros":"'+valParametros+'"}';
        if(arrTokens=='')
            arrTokens=token;
        else
            arrTokens+=','+token;
    }
    var valorRetorno=valorPredominio;
    var parametros='';
   	if(typeof(arrParametrosCalculo)!='undefined')
   	{
        for(x=0;x<arrParametrosCalculo.length;x++)
        {
            if(parametros=='')
                parametros=arrParametrosCalculo[x][0];
            else
                parametros+=','+arrParametrosCalculo[x][0];
                
        }
    }
    
    var aEstructuras='';
    var f;
    var oEst='';
    var oAtt;
    var cadEstructura='';
    for(x=0;x<arrEstructuras.length;x++)
    {
    	f=arrEstructuras[x];
        cadEstructura='';
        for(z=0;z<f[2].length;z++)
        {
        	oAtt='{"nAtributo":"'+(f[2][z][0])+'","nAtributoUsr":"'+(f[2][z][1])+'"}';
            if(cadEstructura=='')
            	cadEstructura=oAtt;
            else
            	cadEstructura+=','+oAtt;
        }
        oEst='{"idEstructura":"'+f[0]+'","nEstructura":"'+cv(f[1])+'","tipoEstructura":"'+f[3]+'","idReferencia":"'+f[4]+'","regEstructura":['+cadEstructura+']}';
        if(aEstructuras=='')
        	aEstructuras=oEst;
        else
        	aEstructuras+=','+oEst;
    }
    aEstructuras=bE('['+aEstructuras+']');
  
    objFinal='{"idConsulta":"'+idConsultaExp+'","tConsulta":"3","valorRetorno":"'+valorRetorno+'","tabla":"","campoProy":"","tokenSql":['+arrTokens+'],"parametros":"'+cv(parametros)+'","arrEstructuras":"'+aEstructuras+'"}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(idConsultaExp=='-1')
            	mostrarVentanaNombreExpresion(objFinal);
            else
            {
                var nombre=gE('nombre').value;
                var descripcion=gE('descripcion').value;
                var codigo=gE('codigo').value;
                var idTipoConcepto=gE('idTipoConcepto').value;
                
                var idAmbito=gE('idAmbito').value;
                guardarExpresion(objFinal,nombre,descripcion,codigo,idTipoConcepto,idAmbito,null,false);
            }
        	

        }
        else
        {
            Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','La consulta ingresada presenta errores de sintaxis, por favor verif&iacute;quela');
            return;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=147&tb=&obj='+objFinal+'&tipo=2',true);
    
}


var arrAmbito=[['1','General'],['2','Individual']];
var tipoConcepto=<?php echo $arreglo?>;

function mostrarVentanaNombreExpresion(objFinal,ventanaOrigenDatosSel)
{
    var nombre='';
    var descripcion='';
    var codigo='';
    var idTipoConcepto='0';
    if(ventanaOrigenDatosSel ==undefined)
    {
    	if(bD(gE('idConsultaExp').value)!='-1')
	    	nombre=gE('nombre').value;
    	descripcion=gE('descripcion').value;
        codigo=gE('codigo').value;
        idTipoConcepto=gE('idTipoConcepto').value;
    }
    var cmbTipoConcepto=crearComboExt('cmbTipoConcepto',tipoConcepto,190,135,300);

    if((tipoConcepto.length>1)||((idTipoConcepto!='-1')&&(idTipoConcepto!='')))
	    cmbTipoConcepto.setValue(idTipoConcepto);
    else
    {
    	cmbTipoConcepto.setValue(tipoConcepto[0][0]);
        
    } 
      
	var lblOcultarTipo=false;
	if(tipoConcepto.length==1)
    {
    	cmbTipoConcepto.hide();
        lblOcultarTipo=true;
    }
        
    //cmbTipoConcepto.on('select',funcTipoConceptoChange);
    var cmbAmbitoAplicacion=crearComboExt('cmbAmbitoAplicacion',arrAmbito,190,165);
    var idAmbito=gE('idAmbito').value;
    if(idAmbito!='')
	    cmbAmbitoAplicacion.setValue(idAmbito);
    var ocultatLblAmbitoAplicacion=false;
    if((idTipoConcepto=='')||(idTipoConcepto=='0'))
    {
	    cmbAmbitoAplicacion.hide();
        ocultatLblAmbitoAplicacion=true;
    }
    
	var gridValoresDevuelve=crearGridCamposDevueltos();
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                        	html:'Cve. de la funci&oacute;n:'
                                                        },
                                                        {
                                                        	id:'txtCodigo',
                                                        	xtype:'textfield',
                                                            x:190,
                                                            y:5,
                                                            width:100,
                                                            value:codigo
                                                        },
														{
                                                        	x:10,
                                                            y:40,
                                                        	html:'Nombre de la funci&oacute;n:'
                                                        },
                                                        {
                                                        	id:'txtIdentificador',
                                                        	xtype:'textfield',
                                                            x:190,
                                                            y:35,
                                                            width:350,
                                                            value:nombre
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                        	html:'Descripci&oacute;n:'
                                                        },
														{
                                                        	id:'txtDescripcion',
                                                        	xtype:'textarea',
                                                            x:190,
                                                            y:65,
                                                            width:550,
                                                            height:60,
                                                            value:descripcion
                                                        },
                                                         {
                                                        	x:10,
                                                            y:140,
                                                            hidden:lblOcultarTipo,
                                                        	html:'Categor&iacute;a de la funci&oacute;n:'
                                                        },
                                                        cmbTipoConcepto,
                                                        {
                                                        	id:'lblAmbito',
                                                        	x:10,
                                                            y:170,
                                                        	html:'&Aacute;mbito de aplicaci&oacute;n:',
                                                            hidden:ocultatLblAmbitoAplicacion
                                                            
                                                        },
                                                        cmbAmbitoAplicacion,
                                                        {
                                                        	id:'lblValoresDevueltos',
                                                        	x:10,
                                                            y:190,
                                                        	html:'Valores Devueltos:'
                                                            
                                                        },
                                                        gridValoresDevuelve
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: gE('lblCalculoS').value,
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
                                                                	Ext.getCmp('txtCodigo').focus(true,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var codigoCon=gEx('txtCodigo').getValue();
                                                                        var idTipoConcepto=cmbTipoConcepto.getValue();
                                                                        var idAmbito=cmbAmbitoAplicacion.getValue();
                                                                    	var txtIdentificador=Ext.getCmp('txtIdentificador');
                                                                        if(txtIdentificador.getValue()=='')
                                                                        {	
                                                                        	function resp()
                                                                            {
                                                                            	txtIdentificador.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el nombre del '+gE('lblCalculoS').value,resp)
                                                                        	return;
                                                                        }
                                                                        var nombre=txtIdentificador.getValue();
                                                                        var descripcion=Ext.getCmp('txtDescripcion').getValue();
                                                                        var txtDescripcion=Ext.getCmp('txtDescripcion');
                                                                        
																		guardarExpresion(objFinal,nombre,descripcion,codigoCon,idTipoConcepto,idAmbito,ventanaAM,true);
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

function funcTipoConceptoChange(combo,registro)
{
	if(registro.get('id')=='0')
    {
    	var cmbAmbitoAplicacion=gEx('cmbAmbitoAplicacion');
        cmbAmbitoAplicacion.reset();
        cmbAmbitoAplicacion.hide();
        gEx('lblAmbito').hide();
    }
    else
    {
    	var cmbAmbitoAplicacion=gEx('cmbAmbitoAplicacion');
        cmbAmbitoAplicacion.setValue('1');
        cmbAmbitoAplicacion.show();
        gEx('lblAmbito').show();
    }
}

function obtenerAcumuladores()
{
	var x;
    var variableAcumuladora=Ext.getCmp('variableAcumuladora');
    var valor;
    for(x=0;x<arrConsulta.length;x++)
    {
    	
    	if(arrConsulta[x][2]=='21')
        {
        	
        	valor=arrConsulta[x][1].substr(1);
            if(valor.substr(valor.length-1)=='=')
            	valor=valor.substr(0,valor.length-1);
            if(gEx('ac'+valor)==null)
            {
                variableAcumuladora.enable();
                var menu;
                if(arrConsulta[x][5]=='0')	
                {
                	var calMenu="menu=	{"+
                                            "id:'ac"+valor+"',"+
                                            "text:'@"+valor+"',"+
                                            "handler:function()"+
                                                    "{"+
                                                        "var arrValor=new Array();"+
                                                        "arrValor[0]='$"+valor+"';"+
                                                        "arrValor[1]='@"+valor+"';"+
                                                        "arrValor[2]=21;"+
                                                        "arrValor[3]='';"+
                                                        "arrValor[4]=[];"+
                                                        "arrValor[5]="+arrConsulta[x][5]+";"+
                                                        "arrConsulta[arrConsulta.length]=arrValor;"+
                                                        "generarSentenciaConsultaOperacion();"+
                                                    "}"+
                                        "}";
                    
                            
                     eval(calMenu);    
                            
                }
                else
                {
					
					if(gEx('ac'+arrConsulta[x][5])==0)
                    	continue;
                    var arrMenus=new Array();
                    var pos=existeValorMatriz(arrEstructuras,arrConsulta[x][5]);
                    var f=arrEstructuras[pos];
                    var xAux;
                    var menuAux;
                    var vAux;
                    var idMenu;
                    if(valor.indexOf('[')!=-1)
                    {
                    	var arrValor=valor.split('[');
                        valor=arrValor[0];
                    }
                    for(xAux=0;xAux<f[2].length;xAux++)
                    {
                        vAux=valor+'["'+f[2][xAux][1]+'"]';
                        vAux2=valor+'["'+f[2][xAux][0]+'"]';
                        idMenu='ac_'+f[2][xAux][0];
                        
                        var calMenu= "menuAux=new Ext.menu.Item	(		{"+
                                                                            "id:'"+idMenu+"',"+
                                                                            "text:'"+f[2][xAux][1]+"',"+
                                                                            "handler:function()"+
                                                                                    "{"+
                                                                                        "var arrValor=new Array();"+
                                                                                        "arrValor[0]='$"+vAux2+"';"+
                                                                                        "arrValor[1]='@"+vAux+"';"+
                                                                                        "arrValor[2]=21;"+
                                                                                        "arrValor[3]='';"+
                                                                                        "arrValor[4]=[];"+
                                                                                        "arrValor[5]='"+arrConsulta[x][5]+"';"+
                                                                                        "arrConsulta[arrConsulta.length]=arrValor;"+
                                                                                        "generarSentenciaConsultaOperacion();"+
                                                                                    "}"+
                                                                        "}"+
                                                                   ")";
                        eval(calMenu);
                        arrMenus.push(menuAux);                
                    }
                   
                    menu=	{
                                id:'ac_'+arrConsulta[x][5],
                                text:'@'+valor,
                                handler:function()
                                        {
                                            var arrID=this.id.split('_');
                                            var arrValor=new Array();
                                            arrValor[0]='$'+valor;
                                            arrValor[1]='@'+valor;
                                            arrValor[2]=21;
                                            arrValor[3]='';
                                            arrValor[4]=[];
                                            
                                            arrValor[5]=arrID[1]+'_'+arrID[2];
                                            arrConsulta[arrConsulta.length]=arrValor;
                                            generarSentenciaConsultaOperacion();
                                        },
                                 menu:arrMenus
                            }
                }
                
                              
                variableAcumuladora.menu.add(menu);
        	}
        }
    }
}

function mostrarVentanaValor()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Valor a insertar:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	id:'txtValorIns',
                                                        	x:110,
                                                            y:5,
                                                            xtype:'textfield',
                                                            allowDecimals:true
                                                        }
                                                        
													]
										}
									);

	


	var ventana = new Ext.Window(
									{
										title: 'Agregar valor constante',
										width: 300,
										height:120,
										minWidth: 300,
										minHeight: 100,
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
																	Ext.getCmp('txtValorIns').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															id:'btnAceptar',
															text: 'Aceptar',
															listeners:	{
																			click:function()
																				{
																					var valor=Ext.getCmp('txtValorIns').getRawValue();
                                                                                    if(valor=='')
                                                                                    {
                                                                                    	function resp()
                                                                                        {
                                                                                        	Ext.getCmp('txtValorIns').focus();
                                                                                        }
                                                                                    	msgBox('El valor ingresado no es v&aacute;lido',resp);
                                                                                    	return;
                                                                                    }	
                                                                                    var arrValor=new Array();
                                                                                    arrValor[0]= ''+valor;
                                                                                    arrValor[1]= '"'+valor.replace(/\s/gi,'&nbsp;')+'"';
                                                                                    arrValor[2]= 1;
                                                                                    
                                                                                    if(arrValor[1].indexOf('.')>-1)
                                                                                    	arrValor[3]='float';
                                                                                    else
                                                                                    	arrValor[3]='int';
                                                                                    arrValor[4]=[];
                                                                                    arrConsulta[arrConsulta.length]=arrValor;
                                                                                   
                                                                                    generarSentenciaConsultaOperacion();
                                                                                    ventana.close();
                                                                                    
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

function mostrarVentanaAcumulador()
{
	var arrTipoVariable=[['0','Sin tipo']];
    var x;
    for(x=0;x<arrEstructuras.length;x++)
    {
    	arrTipoVariable.push([arrEstructuras[x][0],arrEstructuras[x][1]]);
    }

	var cmbTipoVariable=crearComboExt('cmbTipoVariable',arrTipoVariable,160,35,300);
    cmbTipoVariable.setValue('0');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Nombre de la variable:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	id:'txtVariableAcum',
                                                        	x:160,
                                                            enableKeyEvents :true,
                                                            maskRe:/^[_a-zA-Z0-9]$/,
                                                            y:5
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Tipo estructura:',
                                                            xtype:'label'
                                                        },
                                                        cmbTipoVariable,
                                                        {
                                                        	x:300,
                                                            y:65,
                                                            id:'chkInsertVariable',
                                                            xtype:'checkbox',
                                                            checked:true,
                                                            boxLabel :'Insertar variable acumuladora'
                                                        }
                                                        
													]
										}
									);
	var ventana = new Ext.Window(
									{
										title: 'Registrar variable acumuladora',
										width: 520,
										height:180,
										minWidth: 300,
										minHeight: 100,
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
																	Ext.getCmp('txtVariableAcum').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															id:'btnAceptar',
															text: 'Aceptar',
															listeners:	{
																			click:function()
																				{
																					var valor=Ext.getCmp('txtVariableAcum').getValue();
                                                                                    if(valor=='')
                                                                                    {
                                                                                    	function resp()
                                                                                        {
                                                                                        	Ext.getCmp('txtVariableAcum').focus();
                                                                                        }
                                                                                    	msgBox('El nombre ingresado no es v&aacute;lido',resp);
                                                                                    	return;
                                                                                    }	
                                                                                    if(Ext.getCmp('ac'+valor)!=null)
                                                                                    {
                                                                                    	msgBox('El nombre ingresado ya existe');
                                                                                    	return;
                                                                                    }
                                                                                    if(gEx('chkInsertVariable').getValue())
                                                                                    {
                                                                                        var arrValor=new Array();
                                                                                        arrValor[0]= '$'+valor+'=';
                                                                                        arrValor[1]= '@'+valor+'=';
                                                                                        arrValor[2]= 21;
                                                                                        arrValor[3]='';
                                                                                        arrValor[4]=[];
                                                                                        arrValor[5]=cmbTipoVariable.getValue();
                                                                                        arrConsulta[arrConsulta.length]=arrValor;
                                                                                        generarSentenciaConsultaOperacion();
                                                                                    }
                                                                                    var objAcumulador=new Array();
                                                                                    
                                                                                    objAcumulador[0]=valor;
                                                                                    objAcumulador[1]='@'+valor;
                                                                                    objAcumulador[2]=cmbTipoVariable.getValue();
                                                                                    arrAcumuladores.push(objAcumulador);
                                                                                    variableAcumRegistrada.push(objAcumulador);
                                                                                    var variableAcumuladora=Ext.getCmp('variableAcumuladora');
                                                                                    variableAcumuladora.enable();
                                                                                    var menu;
                                                                                    if(cmbTipoVariable.getValue()=='0')	
                                                                                    {
                                                                                    	menu=	{
                                                                                                    id:'ac'+valor,
                                                                                                    text:'@'+valor,
                                                                                                    handler:function()
                                                                                                            {
                                                                                                                
                                                                                                                var arrValor=new Array();
                                                                                                                arrValor[0]='$'+valor;
                                                                                                                arrValor[1]='@'+valor;
                                                                                                                arrValor[2]=21;
                                                                                                                arrValor[3]='';
                                                                                                                arrValor[4]=[];
                                                                                                                arrValor[5]='0';
                                                                                                                arrConsulta[arrConsulta.length]=arrValor;
                                                                                                                generarSentenciaConsultaOperacion();
                                                                                                            }
                                                                                                }
                                                                                 	}
                                                                                    else
                                                                                    {
                                                                                    	var arrMenus=new Array();
                                                                                        
                                                                                        var pos=existeValorMatriz(arrEstructuras,cmbTipoVariable.getValue());
                                                                                        var f=arrEstructuras[pos];
                                                                                        var x;
                                                                                        var menuAux;
                                                                                        var vAux;
                                                                                        var idMenu;
                                                                                        for(x=0;x<f[2].length;x++)
                                                                                        {
                                                                                        	vAux=valor+'["'+f[2][x][1]+'"]';
                                                                                            vAux2=valor+'["'+f[2][x][0]+'"]';
                                                                                            idMenu='ac_'+f[2][x][0];
                                                                                            
                                                                                            var calMenu= "menuAux=new Ext.menu.Item	(		{"+
                                                                                                                                                "id:'"+idMenu+"',"+
                                                                                                                                                "text:'"+f[2][x][1]+"',"+
                                                                                                                                                "handler:function()"+
                                                                                                                                                        "{"+
                                                                                                                                                            "var arrValor=new Array();"+
                                                                                                                                                            "arrValor[0]='$"+vAux2+"';"+
                                                                                                                                                            "arrValor[1]='@"+vAux+"';"+
                                                                                                                                                            "arrValor[2]=21;"+
                                                                                                                                                            "arrValor[3]='';"+
                                                                                                                                                            "arrValor[4]=[];"+
                                                                                                                                                            "arrValor[5]='"+cmbTipoVariable.getValue()+"';"+
                                                                                                                                                            "arrConsulta[arrConsulta.length]=arrValor;"+
                                                                                                                                                            "generarSentenciaConsultaOperacion();"+
                                                                                                                                                        "}"+
                                                                                                                                            "}"+
                                                                                                                                       ")";
                                                                                           	eval(calMenu);
                                                                                        	arrMenus.push(menuAux);                
                                                                                        }
                                                                                        
                                                                                    	menu=	{
                                                                                                    id:'ac_'+cmbTipoVariable.getValue(),
                                                                                                    text:'@'+valor,
                                                                                                    handler:function()
                                                                                                            {
                                                                                                                var arrID=this.id.split('_');
                                                                                                                var arrValor=new Array();
                                                                                                                arrValor[0]='$'+valor;
                                                                                                                arrValor[1]='@'+valor;
                                                                                                                arrValor[2]=21;
                                                                                                                arrValor[3]='';
                                                                                                                arrValor[4]=[];
                                                                                                                arrValor[5]=arrID[1]+'_'+arrID[2];
                                                                                                                arrConsulta[arrConsulta.length]=arrValor;
                                                                                                                generarSentenciaConsultaOperacion();
                                                                                                            },
                                                                                                     menu:arrMenus
                                                                                                }
                                                                                    }
                                                                                    variableAcumuladora.menu.add(menu);
                                                                                    ventana.close();
                                                                                    
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

function guardarExpresion(objFinal,nombre,descripcion,codigo,idTipoConcepto,idAmbito,ventana,recargar)
{
	var nConf=gE('idConfiguracion').value;
    var funcionGuardar=gE('funcionGuardar').value;
    
    var o='';
    var gValorDevuelto=gEx('gValorDevuelto');
    var fila;
    var x;
    var arrValoresDevueltos='';
    for(x=0;x<gValorDevuelto.getStore().getCount();x++)
    {
    
    	fila=gValorDevuelto.getStore().getAt(x);
        
        if(fila.data.nombreValor=='')
        {	
        	function respAux()
            {
            	gValorDevuelto.startEditing(x,2);
            }
            msgBox('Debe indicar el nombre del valor devuelto',respAux);
            return;
        }
        
        o='{"nombreValor":"'+cv(fila.data.nombreValor)+'","descripcion":"'+cv(fila.data.descripcion)+'"}';
        if(arrValoresDevueltos=='')
        	arrValoresDevueltos=o;
        else
        	arrValoresDevueltos+=','+o;
        
        
    }
    
    arrValoresDevueltos='{"arrValoresDevueltos":['+arrValoresDevueltos+']}';
    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
                if((ventana!=undefined)&&(ventana!=null))
	                ventana.close();
                function respGuardar()
                {
                	
                    if(funcionGuardar!='')
                    {
                    	funcionGuardar=bD(funcionGuardar);
                        funcionGuardar=funcionGuardar.replace('@idRegistro',arrResp[1]);
                        funcionGuardar=funcionGuardar.replace('@nConsulta',nombre);
                       	eval(funcionGuardar+';');
                    }
                
                	if(recargar)
	                    recargarPagina();
                	
                }
                msgBox('Los datos han sido guardados corectamente',respGuardar);
                
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=148&arrValoresDevueltos='+arrValoresDevueltos+'&nConf='+nConf+'&obj='+objFinal+'&nombre='+cv(nombre)+'&descripcion='+cv(descripcion)+'&codigo='+codigo+'&idTipoConcepto='+idTipoConcepto+'&idAmbito='+idAmbito,true);	
}

function mostrarFuncionesSistema()
{
	var cmbCategoriaFuncionSistema=crearComboExt('cmbCategoriaFuncionSistema',arrCategoriasFunSistema,160,10,350);
    cmbCategoriaFuncionSistema.setValue(arrCategoriasFunSistema[0][0]);
    cmbCategoriaFuncionSistema.on('select',function(cmb,registro)
    									{
                                        	gEx('gFuncionesSistema').getStore().load({params:{start:0, limit:15,funcion:336,idCategoria:registro.get('id')}});
                                        }
    						)
	var gridFuncion=crearGridFunciones();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:15,
                                                        	html:'Categor&iacute;a de la funci&oacute;n: '
                                                        },
                                            			cmbCategoriaFuncionSistema,
														{
                                                        	x:10,
                                                            y:50,
                                                            html:'Seleccione la funci&oacute;n que desea ejecutar:'
                                                            
                                                        },
                                                        gridFuncion	

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Ejecutar funci&oacute;n',
										width: 780,
										height:415,
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
																		var fila=gridFuncion.getSelectionModel().getSelected();
                                                                        if(fila==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar la funci&oacute;n a ejecutar');
                                                                            return;
                                                                        }
                                                                        var idConsulta=gE('idConsultaExp').value;
																	    var idFuncion=fila.get('idFuncion');
                                                                        var nFuncion=fila.get('nombreFuncion');
                                                                        var requiereParametro=fila.get('requiereParametro');
                                                                        var obj='{"idFuncion":"'+idFuncion+'","idConsulta":"'+idConsulta+'"}';
                                                                        if(requiereParametro==1)
                                                                        	mostrarVentanaParametrosFuncion(idFuncion,nFuncion);
                                                                        else
                                                                        	registrarInvocacionFuncion(obj,nFuncion,'');
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

function crearGridFunciones()
{
	
    var tamPagina=15;
    
    var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields:	[
                                                        {name: 'idFuncion'},
                                                        {name: 'nombreFuncion'},
                                                        {name: 'nombreFuncionPHP'},
                                                        {name: 'archivoInclude'},
                                                        {name: 'tipoFuncion'},
                                                        {name: 'requiereParametro'},
                                                        {name: 'idCategoria'}
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
                                                            sortInfo: {field: 'nombreFuncion', direction: 'ASC'},
                                                            groupField: 'nombreFuncion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='336';
                                        proxy.baseParams.idCategoria=gEx('cmbCategoriaFuncionSistema').getValue();
                                       
                                    }
                        )   
    
    var paginador=	new Ext.PagingToolbar	(

                                                {

                                                      pageSize: tamPagina,

                                                      store: alDatos,

                                                      displayInfo: true,

                                                      disabled:false

                                                  }

                                               )
    
    
    var expander = new Ext.ux.grid.RowExpander({
                                                    column:2,
                                                    tpl : new Ext.Template(
                                                                                '<br><table >'+
                                                                                '<tr><td width:"230"><span class="letraRojaSubrayada8"><b>Descripci&oacute;n:</b></span></td><td></td></tr><tr><td></td><td><span class="copyrigthSinPadding">{descripcion}</span><br /><br /></td></tr>'+
                                                                                '</table>'
                                                                            )
    											}
                                               )
    
    var filters = new Ext.ux.grid.GridFilters	(

    												{

                                                    	filters:	[ {type: 'string', dataIndex: 'nombreFuncion'}]

                                                    }

                                                );
    
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
                                                        expander,
														chkRow,
														{
															header:'Nombre de la funci&oacute;n',
															width:250,
															sortable:true,
															dataIndex:'nombreFuncion'
														},
                                                        {
															header:'Categor&iacute;a',
															width:220,
															sortable:true,
															dataIndex:'idCategoria',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCategoriasFunSistema,val);
                                                                    }
														}
                                                        
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gFuncionesSistema',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:70,
                                                            cm: cModelo,
                                                            height:265,
                                                            width:750,
                                                            plugins:[expander,filters],
                                                            bbar:[paginador],
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            sm:chkRow
                                                        }
                                                    );
	alDatos.load({params:{start:0, limit:tamPagina,funcion:336}});                                                                                                        
	return 	tblGrid;
}

function registrarInvocacionFuncion(obj,nFuncion,valorParam,pos)
{
	var arrValor=new Array();
    arrValor[0]=obj;
    arrValor[1]='Ejecutar: <i><span style=\'color:#000000 \'><b>'+nFuncion+'</b></span></i><b><span style=\'color:#1D0C72 \'>('+valorParam+')</span></b>';
    arrValor[2]=22;
    arrValor[3]='';
    arrValor[4]=[];
    if(pos==undefined)
	    arrConsulta[arrConsulta.length]=arrValor;
    else
    	arrConsulta[pos]=arrValor;
    generarSentenciaConsultaOperacion();
}

function mostrarVentanaParametrosFuncion(idFuncion,nFuncion,pos,arrParam)
{
	var idConsulta=gE('idConsultaExp').value;

	var gridParam=crearGridAsignaParametro();
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique los valores que se asignar&aacute;n a los siguientes par&aacute;metros:'
                                                        },
                                                        gridParam
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignaci&oacute;n de valor a par&aacute;metros',
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
                                                                    	var x;
                                                                        var fila;
                                                                        var arrParam='';
                                                                        var aux='';
                                                                        var valorParam='';
                                                                        var vParam='';
                                                                        for(x=0;x<gridParam.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridParam.getStore().getAt(x);
                                                                            
                                                                            vParam=obtenerTipoParam(fila.get('tipoParam'));
                                                                            aux='{"parametro":"'+fila.get('parametro')+'","valor":"'+fila.get('asigna')+'","tipoValor":"'+fila.get('tipoParam')+'","valorSistema":"'+fila.get('valorSistema')+'","idReferencia":"'+fila.get('idReferencia')+'"}';
                                                                            if(arrParam=='')
                                                                            	arrParam=aux;
                                                                            else
                                                                            	arrParam+=','+aux;
                                                                            
                                                                           	if(valorParam=='')
                                                                            	valorParam="' <span title=\"Tipo de par&aacute;metro: "+vParam+" \" alt=\"Tipo de par&aacute;metro: "+vParam+" \">"+fila.get('asigna')+"</span> '";
                                                                            else
                                                                            	valorParam+=",' <span title=\"Tipo de par&aacute;metro: "+vParam+" \" alt=\"Tipo de par&aacute;metro: "+vParam+" \">"+fila.get('asigna')+"</span> '";
                                                                            
                                                                        }
                                                                        var obj='{"idFuncion":"'+idFuncion+'","nFuncion":"'+nFuncion+'","parametros":['+arrParam+']}';
																		registrarInvocacionFuncion(obj,nFuncion,valorParam,pos);
                                                                        
                                                                        ventanaAM.close();
																	}
														}
													]
									}
								);
    llenarDatosParametros(gridParam.getStore(),idFuncion,'-1',ventanaAM,arrParam)
}

function crearGridAsignaParametro()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'parametro'},
                                                                    {name: 'asigna'},
                                                                    {name: 'tipoParam'},
                                                                    {name: 'valorSistema'},
                                                                    {name: 'idReferencia'}
                                                                    
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Par&aacute;metro',
															width:170,
															sortable:true,
															dataIndex:'parametro'
														},
                                                        {
															header:'Valor',
															width:200,
															dataIndex:'asigna',
                                                            renderer:function(val,metaData,registro,nFila)
                                                            		{
                                                                    	return val+'<a href="javascript:asignarValorParametroAlmacen(\''+bE(nFila)+'\')">&nbsp;&nbsp;<img src="../images/pencil.png" width="13" height="13" alt="Modificar valor del par&aacute;metro" title="Modificar valor del par&aacute;metro"></a>';
                                                                    }
														}

													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridAsignaParametros',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:460,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
	
}

function llenarDatosParametros(almacen,idFuncion,idInvocacion,ventana,arrParam)
{
	var idConsulta=gE('idConsultaExp').value;
    var fila;
    var valor;
    var elemParam;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            almacen.loadData(arrDatos)
            if(arrParam!=undefined)
            {
            	var x;
                for(x=0;x<almacen.getCount();x++)
                {
                	fila=almacen.getAt(x);
                    valor=fila.get('parametro');
                   
                	var pos=existeValorMatriz(arrParam,valor,0);
                    
                    if(pos!=-1)
                    {
                    	elemParam=arrParam[pos];
                    	fila.set('asigna',elemParam[1]);
                        fila.set('tipoParam',elemParam[2]);
                        fila.set('valorSistema',elemParam[3]);
                        fila.set('idReferencia',elemParam[4]);
                    }
               	}
            }
            
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=198&idInvocacion='+idInvocacion+'&idFuncion='+idFuncion+'&idConsulta='+idConsulta,true);
}

function asignarValorParametroAlmacen(nFila)
{
    var arrTipoEntrada=[['7','Consulta auxiliar'],['17','Par\xE1metro de c\xE1lculo'],['1','Valor Constante'],['3','Valor de sesi\xF3n'],['4','Valor de sistema'],['21','Valor de variable acumuladora']];
    var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoEntrada,140,5);
    cmbTipoValor.on('select',funcTipoEntradaChange2);
    var cmbValor=crearComboExt('cmbValor',[],140,35,270);
    cmbValor.on('select',function(cmb,registro)	
    							{
                                	gEx('cmbAtributos').reset();
                                	if(cmbTipoValor.getValue()=='21')
                                    {
                                    	if(cmbTipoValor.getValue()!='0')
                                        {
                                        	var pos=existeValorMatriz(arrEstructuras,registro.get('valorComp'));
                                            var f=arrEstructuras[pos];

                                            var xAux;
                                            var arrDatos=new Array();
                                            for(xAux=0;xAux<f[2].length;xAux++)
                                            {
                                            	arrDatos.push([f[2][xAux][0],f[2][xAux][1],registro.get('valorComp')]);
                                            }
                                          
                                            gEx('cmbAtributos').getStore().loadData(arrDatos);
                                        	gEx('lblAtributos').show();
                                        	gEx('cmbAtributos').show();
                                            gEx('cmbAtributos').enable();
                                        }
                                    }
                        		}
    			)
    var cmbAtributos=crearComboExt('cmbAtributos',[],140,65,270);
	cmbAtributos.disable();
    cmbAtributos.hide();
    cmbValor.hide();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de valor a asignar:'
                                                        },
                                                        cmbTipoValor,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Valor a asignar:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                        	id:'txtValorConstante',
                                                            x:140,
                                                            y:35
                                                        },
                                                        cmbValor,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'lblAtributos',
                                                            hidden:true,
                                                            html:'Valor atributo a asignar:'
                                                        },
                                                        cmbAtributos
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar valor a par&aacute;metro',
										width: 480,
										height:180,
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
																		if(cmbTipoValor.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el tipo de entrada al que pertenece el valor a asignar');
                                                                        	return;
                                                                        }
                                                                        var valorUsr;
                                                                        var valor;
                                                                        var valorSistema='';
                                                                        var idReferencia='0';
                                                                        switch(cmbTipoValor.getValue())
                                                                        {
                                                                        	case '1':
                                                                            	valor=gEx('txtValorConstante').getValue();
                                                                                valorUsr=valor;
                                                                                valorSistema=valor;
                                                                            break;
                                                                            default:
                                                                            	if(cmbValor.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar el valor que desea asignar');
                                                                                	return;
                                                                                }
                                                                                valorSistema=cmbValor.getValue();
                                                                                valorUsr=cmbValor.getRawValue();
                                                                                var cmbAtributos=gEx('cmbAtributos');
                                                                                if(cmbAtributos.getValue()!='')
                                                                                {
                                                                                	valorUsr=cmbValor.getRawValue()+'["'+cmbAtributos.getRawValue()+'"]';
                                                                                    valorSistema=cmbValor.getValue()+'["'+cmbAtributos.getValue()+'"]';
                                                                                }

                                                                                if(cmbTipoValor.getValue()=='21')
                                                                                {
                                                                                	var posAux=obtenerPosFila(cmbValor.getStore(),'id',cmbValor.getValue());
                                                                                    var fAux=cmbValor.getStore().getAt(posAux);
	                                                                                idReferencia=fAux.get('valorComp');
                                                                                }
                                                                            break;
                                                                        }            
                                                                        var fila=gEx('gridAsignaParametros').getStore().getAt(bD(nFila));
                                                                        
                                                                        var tipo=cmbTipoValor.getValue();
                                                                        if(tipo=='1')
                                                                            fila.set('asigna',''+valorUsr);
                                                                        else
                                                                            fila.set('asigna',valorUsr);
                                                                       fila.set('tipoParam',cmbTipoValor.getValue());
                                                                       fila.set('valorSistema',valorSistema);
                                                                       fila.set('idReferencia',idReferencia);

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

function funcTipoEntradaChange2(combo,registro)
{
	var txtValorConstante=gEx('txtValorConstante');
    txtValorConstante.hide();
    var cmbValor=gEx('cmbValor');
    cmbValor.hide();
    cmbValor.reset();
    var cmbAtributos=gEx('cmbAtributos');
    cmbAtributos.hide();
    cmbAtributos.reset();
    var lblAtributos=gEx('lblAtributos');
    lblAtributos.hide();
	switch(registro.get('id'))
    {
    	case '1':
        	txtValorConstante.show();
        break;
       
        case '3':
        	cmbValor.getStore().loadData(arrValorSesion);
        	cmbValor.show();
        break;
        case '4':
        	cmbValor.getStore().loadData(arrValorSistema);
        	cmbValor.show();
        break;
        case '7':
        	var arrConsultaAux=new Array();
            var arbolDataSet=gEx('arbolDataSet');
            var raiz=arbolDataSet.getRootNode();
            var nodoConsulta=raiz.childNodes[1];
            var x;
            var obj;
            for(x=0;x<nodoConsulta.childNodes.length;x++)
            {
            	
                    obj=new Array();
                    obj[0]=nodoConsulta.childNodes[x].id;
                    obj[1]='Consulta: '+nodoConsulta.childNodes[x].text;
                    arrConsultaAux.push(obj);
                
           	}
        	cmbValor.getStore().loadData(arrConsultaAux);
        	cmbValor.show();
        break;
        case '21':
        	cmbValor.getStore().loadData(arrAcumuladores);
        	cmbValor.show();
            lblAtributos.show();
            cmbAtributos.show();
        break;
        case '17':
        	cmbValor.getStore().loadData(arrParametrosCalculo);
        	cmbValor.show();
        break;
      
        
    }
}

function modificarValorParametroFuncion(pos)
{
	var cadParam=arrConsulta[bD(pos)];
    var comilla=/\["/gi;
    var comilla2=/"\]/gi;
    cadParam[0]=cadParam[0].replace(comilla,'[\\"')+'';
    cadParam[0]=cadParam[0].replace(comilla2,'\\"]')+'';
    
	var cadObj=	'['+cadParam[0]+']';
    var obj=eval(cadObj)[0];
   	var arrParametros=new Array();
    var objParam;
    var x;
    var p;
    for(x=0;x<obj.parametros.length;x++)
    {
    	p=obj.parametros[x];
        objParam=new Array();
        objParam[0]=p.parametro;
        objParam[1]=p.valor;
        objParam[2]=p.tipoValor;
        objParam[3]=p.valorSistema;
        if(p.idReferencia!=undefined)
        	objParam[4]=p.idReferencia;
        arrParametros.push(objParam);
   	}
   	mostrarVentanaParametrosFuncion(obj.idFuncion,obj.nFuncion,bD(pos),arrParametros);
}

function obtenerTipoParam(tipo)
{
	switch(tipo)
    {
    	case '1':
			return 'Valor constante';
        break;
        case '3':
			return 'Valor de sesi&oacute;n';
        break;
        case '4':
			return 'Valor de sistema';
        break;
        case '5':
        case '6':
        	return 'Valor de parametro';
        break;
        case '7':
        	return 'Valor de consulta auxiliar';
        break;
        case '17':
        	return 'Par&aacute;metro de expresi&oacute;n';
        break;
        case '21':
	        return 'Valor de variable acumuladora';
        break;
    }
    
    
    return '';
}

var arrOrigenesDatos=[['1','Almac\xE9n de datos'],['2','Consulta auxiliar']];

function mostrarVentanaVinculacionCampoEspecial()
{
	var cmbOrigenDatosCampo=crearComboExt('cmbOrigenDatosCampo',arrOrigenesDatos,340,5);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese el origen del cual obtendr&aacute; el valor el campo especial:'
                                                        },
                                                        cmbOrigenDatosCampo
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Valor de consulta',
										width: 600,
										height:125,
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
																		if(cmbOrigenDatosCampo.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el origen de datos del cual el campo especial obtendr&aacute; su valor');
                                                                        	return;
                                                                        }
                                                                        
                                                                        switch(cmbOrigenDatosCampo.getValue())
                                                                        {
                                                                        	case '1':
                                                                            case '2':
                                                                            	mostrarVentanaSeleccionOrigenDato(cmbOrigenDatosCampo.getValue());
                                                                                ventanaAM.close();
                                                                            break;
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

function mostrarVentanaSeleccionOrigenDato(tipo)
{
	var lblTipo='Seleccione el almac&eacute;n de datos que desea vincular al campo especial';
	if(tipo=='2')
    	lblTipo='Seleccione la consulta auxiliar que desea vincular al campo especial';
    
    var gridOrigenes=crearGridOrigenesDatos();
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:lblTipo
                                                        },
                                                        gridOrigenes
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de origen de datos',
										width: 400,
										height:390,
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
																	 	var filaSel=gridOrigenes.getSelectionModel().getSelected();
                                                                     	if(filaSel==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el almac&eacute;n de datos con el cual se vincular&aacute; el campo especial');
                                                                            return;
                                                                        }
                                                                        var idAlmacen=filaSel.get('idAlmacen');
                                                                        ventanaAM.close();
                                                                        
                                                                        if(tipo=='1')
                                                                        	mostrarVentanaCamposAlmacen(idAlmacen,tipo,filaSel.get('camposProy'),filaSel.get('nombre'));
                                                                        else
                                                                        {
                                                                        	validarVinculacionAlmacen(idAlmacen,tipo,eval(filaSel.get('camposProy'))[0][0],filaSel.get('nombre'));
                                                                        }
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
                                
	llenarGridAlmacen(gridOrigenes,tipo,ventanaAM);                                

}

function crearGridOrigenesDatos(tipo)
{
	var lblTitulo='Almac&eacute;n de datos';
    if(tipo=='2')
    	lblTitulo='Consulta auxiliar';
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idAlmacen'},
                                                                    {name: 'nombre'},
                                                                    {name: 'camposProy'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:lblTitulo,
															width:250,
															sortable:true,
															dataIndex:'nombre'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOrigenDatos',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:350,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
	
}

function llenarGridAlmacen(grid,tipo,ventana)
{
	var arrOrigenesDatos=[];
    var camposProy='';
	var arbolDataSet=gEx('arbolDataSet');
    var nodoRaiz=arbolDataSet.getRootNode();
    var nodoOrigen;
	if(tipo=='1')
    	nodoOrigen=obtenerHijosNodoArbol(nodoRaiz)[0];
    else
    	nodoOrigen=obtenerHijosNodoArbol(nodoRaiz)[1];

	var x;
    var obj
    var y;
    var camposProy='';
    var nodoAlmacen;
    var nodoCampos;
    var arrHijosOrigen=obtenerHijosNodoArbol(nodoOrigen);
    for(x=0;x<arrHijosOrigen.length;x++)
    {
    	camposProy='';
    	obj=new Array();
        nodoAlmacen=arrHijosOrigen[x];
        obj[0]=nodoAlmacen.id;
        obj[1]=nodoAlmacen.attributes.nombreDataSet;
        
        var nodoCampos=obtenerHijosNodoArbol(nodoAlmacen)[0];
        var arrNodosCamposProy=obtenerHijosNodoArbol(nodoCampos);
        var nCampoProy;
        for(y=0;y<arrNodosCamposProy.length;y++)
        {
        	if(arrNodosCamposProy[y].attributes!=undefined)
	        	nCampoProy=arrNodosCamposProy[y].attributes.nCampo;
            else
            	nCampoProy=arrNodosCamposProy[y].nCampo;    
        	
            cadObj="['"+nCampoProy+"','"+arrNodosCamposProy[y].text+"']";
            
        	if(camposProy=='')
            	camposProy=cadObj;
            else
            	camposProy+=','+cadObj;
            
        }
        
        obj[2]='['+camposProy+']';
        arrOrigenesDatos.push(obj);
    }        
     gEx('gridOrigenDatos').getStore().loadData(arrOrigenesDatos); 
     ventana.show();
}

function mostrarVentanaCamposAlmacen(idAlmacen,tipo,campoProy,nConsulta)
{
	var gridCamposProy=crearGridCamposProy();
    gridCamposProy.getStore().loadData(eval(campoProy));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el campo del cual desea obtener el valor:'
                                                        },
                                                        gridCamposProy

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de campo a proyectar',
										width: 390,
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
																		var filaSel=gridCamposProy.getSelectionModel().getSelected();
                                                                        if(filaSel==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el campo a proyectar en el control a agregar');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var campoProy=filaSel.get('nCampoO');
                                                                        ventanaAM.close();
                                                                        validarVinculacionAlmacen(idAlmacen,tipo,campoProy,nConsulta);
                                                                        
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

function crearGridCamposProy()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'nCampoO'},
                                                                {name: 'nCampo'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Campo',
															width:250,
															sortable:true,
															dataIndex:'nCampo'
														}													
                                                   ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:360,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function validarVinculacionAlmacen(idAlmacen,tipo,campoProy,nConsulta)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(arrResp[1]=='')
            {
            	var arrValor=new Array();
                arrValor[0]=idAlmacen;
                arrValor[1]='[Consulta: '+nConsulta+'] ';
                arrValor[2]=7;
                arrValor[3]='';
                arrValor[4]=[];
                arrConsulta[arrConsulta.length]=arrValor;
                generarSentenciaConsultaOperacion();                 
                
            }
            else
            {
            
            	var arrParam=eval(arrResp[1]);
                arrCamposAlmacen=eval(arrResp[2]);
                if(arrParam.length>0)
	             	mostrarVentanaAsignarParametro(arrParam,idAlmacen,tipo,campoProy,nConsulta); 
                else
                {
                	var arrTabla=campoProy.split('.');
                    var nCampo=arrTabla[0];
                    if(arrTabla.length>1)
                    	nCampo=arrTabla[1];
                    
                	var arrValor=new Array();
                    arrValor[0]=idAlmacen+'|'+campoProy;
                    arrValor[1]='[Consulta: '+nConsulta+', Campo: '+ucFirst(nCampo)+'] ';
                    arrValor[2]=11;
                    arrValor[3]='';
                    arrValor[4]=[];
                    arrConsulta[arrConsulta.length]=arrValor;
                    generarSentenciaConsultaOperacion();     
                }
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=25&idAlmacen='+idAlmacen+'&idAlmacenPadre=-1',true);
}

function mostrarVentanaAsignarParametro(datos,idAlmacen,tipo,campoProy,nConsulta)
{
	var gridParam=crearGridAsignaParametroAux(idAlmacen);
    gridParam.getStore().loadData(datos)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique los valores que se asignar&aacute;n a los siguientes par&aacute;metros:'
                                                        },
                                                        gridParam
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignaci&oacute;n de valor a par&aacute;metros',
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
                                                                    	
                                                                        var arrValor=new Array();
                                                                        if(tipo!='1')
                                                                        {
                                                                            arrValor[0]=idAlmacen;
                                                                            arrValor[1]='[Consulta: '+nConsulta+'] <a href="javascript:modificarParametrosAlmacen(\''+bE(idAlmacen)+'\')"><img height="13" width="13" src="../images/pencil.png" alt="Modificar valores de par&aacute;metros" title="Modificar valores de par&aacute;metros" /></a>';
                                                                        }
                                                                        else
                                                                        {
                                                                        	var arrTabla=campoProy.split('_');
                                                                        	arrValor[0]=idAlmacen+'|'+campoProy;
                                                                            arrValor[1]='[Consulta: '+nConsulta+', Campo: '+ucFirst(arrTabla[1])+'] <a href="javascript:modificarParametrosAlmacen(\''+bE(idAlmacen)+'\')"><img height="13" width="13" src="../images/pencil.png" alt="Modificar valores de par&aacute;metros" title="Modificar valores de par&aacute;metros" /></a>';
                                                                        }
                                                                        arrValor[2]=11;
                                                                        arrValor[3]='';
                                                                        arrValor[4]=[];
                                                                        arrConsulta[arrConsulta.length]=arrValor;
                                                                        generarSentenciaConsultaOperacion(); 
                                                                        ventanaAM.close();    	
																	}
														}
													]
									}
								);
	ventanaAM.show();
}

function crearGridAsignaParametroAux(idAlmacen)
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idParametro'},
                                                                    {name: 'parametro'},
                                                                    {name: 'asigna'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Par&aacute;metro',
															width:170,
															sortable:true,
															dataIndex:'parametro'
														},
                                                        {
															header:'Valor',
															width:200,
															dataIndex:'asigna',
                                                            renderer:function(val,metaData,registro,nFila)
                                                            		{
                                                                    	return val+'<a href="javascript:asignarValorParametroAlmacenAux(\''+(idAlmacen)+'\',\''+bE(registro.get('parametro'))+'\',\''+bE(nFila)+'\')">&nbsp;&nbsp;<img src="../images/pencil.png" width="13" height="13" alt="Modificar valor del par&aacute;metro" title="Modificar valor del par&aacute;metro"></a>';
                                                                    }
														}

													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridAsignaParametros',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:460,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
	
}

function asignarValorParametroAlmacenAux(iAlmacen,parametro,nFila)
{
    var arrTipoEntrada=[['17','Par\xE1metro de c\xE1lculo'],['1','Valor Constante'],['3','Valor de sesi\xF3n'],['4','Valor de sistema'],['21','Valor de variable acumuladora']];
   	var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoEntrada,140,5);
    cmbTipoValor.on('select',funcTipoEntradaChange2);
    var cmbValor=crearComboExt('cmbValor',[],140,35);
    cmbValor.setWidth(250);
    cmbValor.hide();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de valor a asignar:'
                                                        },
                                                        cmbTipoValor,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Valor a asignar:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                        	id:'txtValorConstante',
                                                            x:140,
                                                            y:35
                                                        },
                                                        cmbValor
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar valor a par&aacute;metro',
										width: 430,
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
																		if(cmbTipoValor.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el tipo de entrada al que pertenece el valor a asignar');
                                                                        	return;
                                                                        }
                                                                        var valorUsr;
                                                                        var valor;
                                                                        switch(cmbTipoValor.getValue())
                                                                        {
                                                                        	case '1':
                                                                            	valor=gEx('txtValorConstante').getValue();
                                                                                valorUsr=valor;
                                                                            break;
                                                                            default:
                                                                            	if(cmbValor.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar el valor que desea asignar');
                                                                                	return;
                                                                                }
                                                                                valor=cmbValor.getValue();
                                                                                valorUsr=cmbValor.getRawValue();
                                                                            break;
                                                                        }                                                                        
                                                                        var tipo=cmbTipoValor.getValue();
                                                                        var almacen=bE(iAlmacen);
                                                                        var param=parametro;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            
                                                                            	var fila=gEx('gridAsignaParametros').getStore().getAt(bD(nFila));
                                                                            	if(tipo=='1')
	                                                                            	fila.set('asigna',''+valorUsr);
                                                                                else
                                                                                	fila.set('asigna','['+valorUsr+']');
                                                                                gEx('arbolDataSet').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=16&valor='+valor+'&valorUsr='+valorUsr+'&parametro='+param+'&tipo='+tipo+'&almacen='+bD(almacen),true);
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

function modificarParametrosAlmacen(idAlmacen)
{
	var gridParam=crearGridAsignaParametroAux(idAlmacen);

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique los valores que se asignar&aacute;n a los siguientes par&aacute;metros:'
                                                        },
                                                        gridParam
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignaci&oacute;n de valor a par&aacute;metros',
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
	llenarParametrosAlmacen(idAlmacen,gridParam.getStore(),ventanaAM)
}

function llenarParametrosAlmacen(idAlmacen,almacen,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	almacen.loadData(eval(arrResp[1]));
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=25&idAlmacenPadre=-1&idAlmacen='+bD(idAlmacen),true);

}

function mostrarVentanaAsignarParam()
{
	
    var arrTipoEntrada=[['7','Consulta auxiliar'],['17','Par\xE1metro de c\xE1lculo'],['1','Valor Constante'],['3','Valor de sesi\xF3n'],['4','Valor de sistema']];
    var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoEntrada,140,5);
    cmbTipoValor.on('select',funcTipoEntradaChange);
    var cmbValor=crearComboExt('cmbValor',[],140,35);
    cmbValor.setWidth(250);
    cmbValor.hide();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de valor a asignar:'
                                                        },
                                                        cmbTipoValor,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Valor a asignar:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                        	id:'txtValorConstante',
                                                            x:140,
                                                            y:35
                                                        },
                                                        cmbValor
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar valor a par&aacute;metro',
										width: 430,
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
																		if(cmbTipoValor.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el tipo de entrada al que pertenece el valor a asignar');
                                                                        	return;
                                                                        }
                                                                        var valorUsr;
                                                                        var valor;
                                                                        switch(cmbTipoValor.getValue())
                                                                        {
                                                                        	case '1':
                                                                            	valor=gEx('txtValorConstante').getValue();
                                                                                valorUsr=valor;
                                                                            break;
                                                                            default:
                                                                            	if(cmbValor.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar el valor que desea asignar');
                                                                                	return;
                                                                                }
                                                                                valor=cmbValor.getValue();
                                                                                valorUsr=cmbValor.getRawValue();
                                                                            break;
                                                                        }                                                                        
                                                                        var tipo=cmbTipoValor.getValue();
                                                                        var almacen=(nodoSel.attributes.dSetPadre);
                                                                        var param=nodoSel.attributes.nParametro;
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	if(tipo=='1')
	                                                                            	nodoSel.setText(nodoSel.attributes.nParametro+' (<b>Valor:</b> '+valorUsr+')');
                                                                                else
                                                                                	nodoSel.setText(nodoSel.attributes.nParametro+' (<b>Valor:</b> ['+valorUsr+'])');
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=16&valor='+valor+'&valorUsr='+valorUsr+'&parametro='+bE(param)+'&tipo='+tipo+'&almacen='+almacen,true);

                                                                    	
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

function funcTipoEntradaChange(combo,registro)
{
	var txtValorConstante=gEx('txtValorConstante');
    txtValorConstante.hide();
    var cmbValor=gEx('cmbValor');
    cmbValor.hide();
    var datosNodo=nodoSel.id.split('_');
	switch(registro.get('id'))
    {
    	case '1':
        	txtValorConstante.show();
        break;
        case '2':
        	cmbValor.getStore().loadData(arrParametrosRep);
        	cmbValor.show();
        break;
        case '3':
        	cmbValor.getStore().loadData(arrValorSesion);
        	cmbValor.show();
        break;
        case '4':
        	cmbValor.getStore().loadData(arrValorSistema);
        	cmbValor.show();
        break;
        case '7':
        	var arrConsultaAux=new Array();
            var arbolDataSet=gEx('arbolDataSet');
            var raiz=arbolDataSet.getRootNode();
            var nodoConsulta=raiz.childNodes[1];
            var x;
            var obj;
            for(x=0;x<nodoConsulta.childNodes.length;x++)
            {
            	if(datosNodo[1]!=nodoConsulta.childNodes[x].id)
                {
                    obj=new Array();
                    obj[0]=nodoConsulta.childNodes[x].id;
                    obj[1]='Consulta: '+nodoConsulta.childNodes[x].text;
                    arrConsultaAux.push(obj);
                }
           	}
        	cmbValor.getStore().loadData(arrConsultaAux);
        	cmbValor.show();
        break;
        case '17':
        	cmbValor.getStore().loadData(arrParametrosCalculo);
        	cmbValor.show();
        break;
        
    }
}

function mostrarVentanaNombreExpresionModif()
{
	var nombre='';
    var descripcion='';
    var codigo='';
    var idTipoConcepto='';
    var cmbTipoObjetivo=crearComboExt('cmbTipoObjetivo',<?php echo $arrTiposConcepto?>,190,215);
    cmbTipoObjetivo.hide();
    nombre=gE('nombre').value;
    descripcion=gE('descripcion').value;
    codigo=gE('codigo').value;
    idTipoConcepto=gE('idTipoConcepto').value;
    
    var cmbTipoConcepto=crearComboExt('cmbTipoConcepto',tipoConcepto,190,155,300);
    cmbTipoConcepto.setValue(idTipoConcepto);
    cmbTipoConcepto.on('select',funcTipoConceptoChange);
    var cmbAmbitoAplicacion=crearComboExt('cmbAmbitoAplicacion',arrAmbito,190,185);
    var idAmbito=gE('idAmbito').value;
    if(idAmbito!='')
	    cmbAmbitoAplicacion.setValue(idAmbito);
    var ocultatLblAmbitoAplicacion=false;
    cmbAmbitoAplicacion.hide();
    
    var lblOcultarTipo=false;
	if(tipoConcepto.length==1)
    {
    	cmbTipoConcepto.hide();
        lblOcultarTipo=true;
    }
    
   
    var gridValoresDevuelve=crearGridCamposDevueltos();
    gridValoresDevuelve.getStore().loadData(eval(bD(gE('arrValoresDevuelto').value)));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                        	html:'Cve. '+gE('lblCalculoS').value+':'
                                                        },
                                                        {
                                                        	id:'txtCodigo',
                                                        	xtype:'textfield',
                                                            x:190,
                                                            y:5,
                                                            width:100,
                                                            value:codigo
                                                        },
														{
                                                        	x:10,
                                                            y:40,
                                                        	html:'Nombre '+gE('lblCalculoS').value+':'
                                                        },
                                                        {
                                                        	id:'txtIdentificador',
                                                        	xtype:'textfield',
                                                            x:190,
                                                            y:35,
                                                            width:350,
                                                            value:nombre
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                        	html:'Descripci&oacute;n:'
                                                        },
														{
                                                        	id:'txtDescripcion',
                                                        	xtype:'textarea',
                                                            x:190,
                                                            y:65,
                                                            width:450,
                                                            height:80,
                                                            value:descripcion
                                                        },
                                                         {
                                                        	x:10,
                                                            y:160,
                                                            hidden:lblOcultarTipo,
                                                        	html:'Tipo '+gE('lblCalculoS').value+':'
                                                        },
                                                        cmbTipoConcepto,
                                                        {
                                                        	id:'lblAmbito',
                                                        	x:10,
                                                            y:190,
                                                        	html:'&Aacute;mbito de aplicaci&oacute;n:',
                                                            hidden:true
                                                        },
                                                        cmbAmbitoAplicacion,
                                                        {
                                                        	id:'lblTipoObjeto',
                                                            x:10,
                                                            y:220,
                                                            hidden:true,
                                                            html:'Tipo de objeto:'
                                                        },
                                                        cmbTipoObjetivo,
                                                        {
                                                        	id:'lblValoresDevueltos',
                                                        	x:10,
                                                            y:190,
                                                        	html:'Valores Devueltos:'
                                                            
                                                        },
                                                        gridValoresDevuelve
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: gE('lblCalculoS').value,
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
                                                                	Ext.getCmp('txtCodigo').focus(true,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var codigoCon=gEx('txtCodigo').getValue();
                                                                        var idTipoConcepto=cmbTipoConcepto.getValue();
                                                                        var idAmbito=cmbAmbitoAplicacion.getValue();
                                                                    	var txtIdentificador=Ext.getCmp('txtIdentificador');
                                                                        if(txtIdentificador.getValue()=='')
                                                                        {	
                                                                        	function resp()
                                                                            {
                                                                            	txtIdentificador.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el identificador de la expresi&oacute;n',resp)
                                                                        	return;
                                                                        }
                                                                        var nombre=txtIdentificador.getValue();
                                                                        var descripcion=Ext.getCmp('txtDescripcion').getValue();
                                                                        var txtDescripcion=Ext.getCmp('txtDescripcion');
                                                                        var idConsultaExp=gE('idConsultaExp').value;
                                                                        var gValorDevuelto=gEx('gValorDevuelto');
                                                                        var arrValoresDevueltos='';
                                                                        for(x=0;x<gValorDevuelto.getStore().getCount();x++)
                                                                        {
                                                                        
                                                                            fila=gValorDevuelto.getStore().getAt(x);
                                                                            
                                                                            if(fila.data.nombreValor=='')
                                                                            {	
                                                                                function respAux()
                                                                                {
                                                                                    gValorDevuelto.startEditing(x,2);
                                                                                }
                                                                                msgBox('Debe indicar el nombre del valor devuelto',respAux);
                                                                                return;
                                                                            }
                                                                            
                                                                            o='{"nombreValor":"'+cv(fila.data.nombreValor)+'","descripcion":"'+cv(fila.data.descripcion)+'"}';
                                                                            if(arrValoresDevueltos=='')
                                                                                arrValoresDevueltos=o;
                                                                            else
                                                                                arrValoresDevueltos+=','+o;
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                       
                                                                        
                                                                        var cadObj='{"idConcepto":"'+bD(idConsultaExp)+'","codigo":"'+cv(codigoCon)+'","identificador":"'+cv(txtIdentificador.getValue())+
                                                                        			'","descripcion":"'+cv(descripcion)+'","tipoConcepto":"'+idTipoConcepto+'","ambito":"'+idAmbito+
                                                                                    '","arrValoresDevueltos":['+arrValoresDevueltos+']}';
                                                                        function funcAjax()
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesContabilidad.php',funcAjax, 'POST','funcion=72&cadObj='+cadObj,true);
                                                                        
																		
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

function mostrarVentanaConf(idCalculo)
{
	tb_show(lblAplicacion,'../nomina/interfaceCalculo.php?cPagina='+cv('mPie=false|mI=false|b=false|mR1=false')+'&idCalculo='+idCalculo+'&TB_iframe=true&height=420&width=600',"","scrolling=yes");

}

function mostrarVentanaReferenciaAlmacenDatos()
{
	var arrAlmacenes=obtenerAlmacenesDisponibles();
	var cmbAlmacenDatos=crearComboExt('cmbAlmacenDatos',arrAlmacenes,130,5,250);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Almac&eacute;n de datos:'
                                                        },
                                                        cmbAlmacenDatos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Insertar referencia a almac&eacute;n de datos',
										width: 500,
										height:130,
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
																		if(cmbAlmacenDatos.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar el almac&eacute;n de datos cuya referencia desea insertar');
                                                                        	return;
                                                                        }
                                                                        var arrValor=new Array();
                                                                        arrValor[0]='obtenerReferenciaAlmacenDatos($arrQueries,'+cmbAlmacenDatos.getValue()+');';
                                                                        arrValor[1]='Referencia a almac&eacute;n: '+cmbAlmacenDatos.getRawValue();
                                                                        arrValor[2]=0;
                                                                        arrValor[3]='';
                                                                        arrValor[4]=[];
                                                                        arrConsulta[arrConsulta.length]=arrValor;
                                                                        generarSentenciaConsultaOperacion();
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

function mostrarVentanaEjecucionAlmacenDatos()
{

    var arrTipoOrigen=[['1','Almac\xE9n de datos'],['2','Consulta auxiliar']];
    var cmbOrigenDatos=crearComboExt('cmbOrigenDatos',arrTipoOrigen,130,5,250);
    cmbOrigenDatos.on('select',function(cmb,registro)
    							{
                                	var arrAlmacenes=obtenerAlmacenesDatosDisponibles(registro.get('id'));
                                    gEx('cmbAlmacenDatos').getStore().loadData(arrAlmacenes);
                                    gEx('cmbAlmacenDatos').reset();
                                }
    				)
	var cmbAlmacenDatos=crearComboExt('cmbAlmacenDatos',[],130,35,250);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo Origen de datos:'
                                                        },
                                                        cmbOrigenDatos,
														{
                                                        	x:10,
                                                            y:40,
                                                            html:'Almac&eacute;n de datos:'
                                                        },
                                                        cmbAlmacenDatos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Insertar referencia a almac&eacute;n de datos',
										width: 500,
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
																		if(cmbAlmacenDatos.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar el almac&eacute;n de datos cuya referencia desea insertar');
                                                                        	return;
                                                                        }
                                                                        var arrParametros=new Array();
                                                                        var nodoOrigen=buscarNodoID(arbolAlmacenEstructDatos.getRootNode(),cmbAlmacenDatos.getValue());
                                                                        var arrParam=nodoOrigen.attributes.children[1].children;
                                                                        
                                                                        var ct=0;
                                                                        var p;
                                                                        for(ct=0;ct<arrParam.length;ct++)
                                                                        {
                                                                        	p=arrParam[ct];
                                                                            arrParametros.push([p.nParametro.substr(1),p.valor,p.tipoValor]);
                                                                        }
                                                                        
                                                                        var arrValor=new Array();
                                                                        arrValor[0]=cmbOrigenDatos.getValue()+'|'+cmbAlmacenDatos.getValue();
                                                                        arrValor[1]='Ejecutar '+cmbOrigenDatos.getRawValue()+': '+cmbAlmacenDatos.getRawValue();
                                                                        arrValor[2]='25';
                                                                        arrValor[3]='';
                                                                        arrValor[4]=arrParametros;
                                                                        arrConsulta[arrConsulta.length]=arrValor;
                                                                        generarSentenciaConsultaOperacion();
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

function mostrarVentanaAdminParametros()
{
	var gParametro=crearGridParametrosFuncion();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gParametro

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vAdmonParametro',
										title: 'Administraci&oacute;n de par&aacute;metros',
										width: 400,
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
															text: 'Cerrar',
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

function crearGridParametrosFuncion()
{
	var dsDatos=arrParametrosCalculo;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'valor'},
                                                                    {name: 'nombre'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Par&aacute;metro',
															width:250,
															sortable:true,
															dataIndex:'nombre'
														}													
                                                     ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridParametros',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:0,
                                                            y:0,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:270,
                                                            width:370,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Registrar par&aacute;metro',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaParametro(tblGrid);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover par&aacute;metro',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox("Debe seleccionar el par&aacute;metro que desea remover");
                                                                                            return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	var valor=fila.get('valor');
                                                                                            	var pos=existeValorMatriz(arrParametrosCalculo,valor);
                                                                                                arrParametrosCalculo.splice(pos,1);
                                                                                                tblGrid.getStore().remove(fila);
                                                                                                gEx('parametro').menu.remove(gEx('p'+valor));
                                                                                               
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el par&aacute;metro seleccionado',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}


function mostrarVentanaURLPublicacion()
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
                                                            html:'URL de Publicaci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            width:450,
                                                            x:150,
                                                            y:5,
                                                            value:'<?php echo $urlSitio."/webServices/wsServiciosInterconexion.php?ref=".$llaveConsulta ?>&wsdl',
                                                            id:'txtURL'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'URL de Publicaci&oacute;n (Web Services)',
										width: 650,
										height:130,
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
	ventanaAM.show();	
}


function crearGridCamposDevueltos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nombreValor'},
                                                                    {name: 'descripcion'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel( {checkOnly : true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Nombre Valor',
															width:140,
                                                            editor:	{
                                                            			xtype:'textfield'
                                                                        
                                                            		},	
															sortable:true,
															dataIndex:'nombreValor'
														},
														{
															header:'Descripci&oacute;n',
															width:350,
															sortable:true,
                                                            editor:	{
                                                            			xtype:'textarea',
                                                                        height:60
                                                                        
                                                            		},	
															dataIndex:'descripcion',
                                                            renderer:function(val)
                                                            		{
                                                                    	return escaparEnter(val);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:185,
                                                            x:190,
                                                            id:'gValorDevuelto',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            clicksToEdit:1,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:180,
                                                            width:575,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar Valor Devuelto',
                                                                            handler:function()
                                                                            		{
                                                                                    	var registro=crearRegistro (
                                                                                        								[
                                                                                                                        	{name: 'nombreValor'},
                                                                    														{name: 'descripcion'}
                                                                                                                        ]
                                                                                        							)
                                                                                    
                                                                                    
                                                                                    	var r=new registro	(
                                                                                        						{
                                                                                                                	nombreValor:'',
                                                                                                                    descripcion:''
                                                                                                                }
                                                                                        					)
                                                                                    
                                                                                    
                                                                                    
                                                                                    	var gValorDevuelto=gEx('gValorDevuelto');
                                                                                        gValorDevuelto.getStore().add(r);
                                                                                        gValorDevuelto.startEditing(gValorDevuelto.getStore().getCount()-1,2);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover Valor Devuelto',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gValorDevuelto').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {	
                                                                                        	msgBox('Debe seleccionar el registro que desea remover')
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el registro seleccionado?',resp);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );


	tblGrid.on('beforeedit',function(e)
    						{
                            	if(e.field=='descripcion')
                                {
                                	e.record.set('descripcion',escaparBR(e.record.data.descripcion,true));
                                }
                            }
    			)
	return 	tblGrid;	
}