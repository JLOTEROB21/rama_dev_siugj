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
	$consulta="select tokenMysql,tokenUsr,tipoToken,valorDevuelto,idToken from 992_tokensConsulta where idConsulta=".$idConsulta." order by idToken";
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
		$obj="[\"".str_replace("\"","\\\"",$filasT[0])."\",\"".str_replace("\"","\\\"",$filasT[1])."\",\"".$filasT[2]."\",\"".$filasT[3]."\",[".$arrAux."]]";
		if($arrConsulta=="")
			$arrConsulta=$obj;
		else
			$arrConsulta.=",".$obj;
		
	}
	$arrConsulta="[".uEJ($arrConsulta)."]";
	$arrParametros="";
	if($idConsulta==-1)
	{
		$arrParametros="'idNomina','numEtapa'";
	}
	
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
	$consulta="SELECT idFuncion,nombreFuncion,tipoFuncion,if((select count(idParametro) from 9034_parametrosFuncionesSistema where idFuncion=f.idFuncion)>0,'1',0) as reqParam FROM 9033_funcionesSistema f ORDER BY nombreFuncion";
	$arrFunciones=uEJ($con->obtenerFilasArreglo($consulta));
	
?>
var arrParametrosCalculo=[];
var arrValorSesion=<?php echo $arrValorSesion ?>;
var arrValorSistema=<?php echo $arrValorSistema ?>;    
var arrProceso=[['1','idFormulario'],['2','idProceso'],['3','idRegistro'],['4','numEtapa']];
var filtroUsuario;
var filtroMysql;
var arrParametros;
var arrAcumuladores;
var arrConsulta=[];
var frmProceso=false;
Ext.onReady(inicializar);

function inicializar()
{
	arrParametros=<?php echo $arrParametros?>;
	Ext.QuickTips.init();
	var arbolAlmacen=crearArbolAlmacen();
    crearGridCondiciones();
    cargarParametros();
}

function cargarParametros()
{
	var mnuParametro=Ext.getCmp('parametro');
    if(arrParametros.length>0)
    	 mnuParametro.enable();
    var x;
    var menu;
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


function crearArbolAlmacen()
{
	var iR=gE('idConsultaExp').value;
    var nEtapa=gE('numEtapa').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'7',
                                                                    idReporte:iR,
                                                                    tipoDataSet:6
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
                                                  height:350,
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
                                                                        	if(gE('idConsultaExp').value=='-1')
                                                                            {
                                                                            	msgBox('Para crear un almac&eacute;n de datos primero debe guardar el disparador')
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
}

function crearGridCondiciones()
{
	arrConsulta=<?php echo $arrConsulta?>;
	var panel=new Ext.FormPanel(	
                                          {
                                              renderTo:'tblPanel',
                                              baseCls: 'x-plain',
                                              layout:'absolute',
                                              defaultType: 'textfield',
                                              width:700,
                                              height:400,
                                              border:true,
                                              tbar: 	[
                                              				{
                                                                text:'Guardar',
                                                                icon:'../images/guardar.PNG',
                                                                cls:'x-btn-text-icon',
                                                                handler:function()
                                                                		{
                                                                        	guardarExpresionFinal();
                                                                        }
                                                             },
                                                             '-',
                                              				{
                                                             	id:'insertar',
                                                                text:'Insertar...',
                                                                menu:	[
                                                                			{
                                                                                text:'Crear variable acumuladora',
                                                                                handler:function()	
                                                                                          {
                                                                                            mostrarVentanaAcumulador();   
                                                                                          }
                                                                            },
                                                                            {
                                                                            	
                                                                                text:'Invocaci&oacute;n de funci&oacute;n',
                                                                                handler:function()
                                                                                		{
                                                                                        	mostrarFuncionesSistema();
                                                                                        }
                                                                            },
                                                                            {
                                                                                id:'parametro',
                                                                                text:'Parametro',
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
                                                             },
                                                             '-'
                                                             ,
                                                              {
                                                                   xtype:'button',
                                                                   text:'(',
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
                                                                  handler:function()
                                                                        {
                                                                        	if(validarOperador('O'))
                                                                            {
                                                                                var arrValor=new Array();
                                                                                arrValor[0]='||';
                                                                                arrValor[1]='O';
                                                                                arrValor[2]=1;
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
                                                                   text:'+',
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
                                                                 text:'=',
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
                                                             /*{
                                                                 xtype:'button',
                                                                 text:'Valor retorno',
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
                                                                                    arrValor[2]=01;
                                                                                    arrValor[3]='';
                                                                                    arrValor[4]=[];
                                                                                    arrConsulta[arrConsulta.length]=arrValor;
                                                                                }
                                                                        	}
                                                                           
                                                                           	comp='<br>';
                                                                            arrValor=new Array();
                                                                            arrValor[0]='$resultadoFinal=';
                                                                            arrValor[1]='Valor final=';
                                                                            arrValor[2]=0;
                                                                            arrValor[3]='';
                                                                            arrValor[4]=[];
                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                            generarSentenciaConsultaOperacion();
                                                                        }
                                                             },'-',*/
                                                             {
                                                                 xtype:'button',
                                                                 icon:'../images/flecha_azul_corta.gif',
                                                                
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
                                                             
                                                             
                                                             
                                                              
                                                  ],
                                              items: 	[
                                                          {
                                                              xtype:'panel',
                                                              border :false,
                                                              x:0,
                                                              y:0,
                                                              items:	[
                                                                          
                                                                          {
                                                                          	xtype:'label',
                                                                            x:10,
                                                                            y:105,
                                                                            html:'<table style=" width:700px; background-color:#FFF; line-height:normal !important; font-size:11px" ><tr><td valign="top" id="spArea" style=" overflow:scroll; height:350px; border-style:solid; border-width:1px"></td></tr></table>'
                                                                          }
                                                                      ]
                                                          }
                                                      ]
                                          }
                                      );
	if(arrConsulta.length>0)
    {
    	generarSentenciaConsultaOperacion();                                      
        obtenerAcumuladores();
        
    }
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
        /*switch(arrConsulta[x][2])
        {
        	case 10:
            case '10':
			
                apTag='<b>';
                cTag='</b>';
                compAux=' title="Variable acumuladora" alt="Variable acumuladora"';
                var nAcum=arrConsulta[x][2][0];
                nAcum=arrConsulta[x][1].substr(1);
                if(nAcum.substr(nAcum.length-1)=='=')
                    nAcum=nAcum.substr(0,nAcum.length-1);
                if(existeValorMatriz(arrAcumuladores,nAcum,0)==-1)
                {
                    var objAcum=new Array();
                    objAcum[0]=nAcum;
                    objAcum[1]='@'+nAcum;
                    arrAcumuladores.push(objAcum);
                }
            break;
            case 5:
            case '5':
			
                apTag='<font color="#FF0000">';
                cTag='</font>';
            break;
            case 1:
            case '1':
			
                apTag='<font color="#090">';
                cTag='</font>';
            break;
           case 20:
           case '20':
           		apTag='<font color="#900">';
                cTag='</font>';
                exclamacion='&nbsp;<a href="javascript:modificarValorParametroFuncion(\''+bE(x)+'\')"><img height="13" width="13" src="../images/pencil.png" title="Modificar valor de parametros" alt="Modificar valor de parametros"></a>';
           break;
           case 21:
           case '21':
           		apTag='<font color="#906">';
                cTag='</font>';
           break;
            
        }*/
        switch(arrConsulta[x][2])
        {
        	case 21:
            case '21':
			
                apTag='<b>';
                cTag='</b>';
                compAux=' title="Variable acumuladora" alt="Variable acumuladora"';
                var nAcum=arrConsulta[x][2][0];
                nAcum=arrConsulta[x][1].substr(1);
                if(nAcum.substr(nAcum.length-1)=='=')
                    nAcum=nAcum.substr(0,nAcum.length-1);
                if(existeValorMatriz(arrAcumuladores,nAcum,0)==-1)
                {
                    var objAcum=new Array();
                    objAcum[0]=nAcum;
                    objAcum[1]='@'+nAcum;
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
            
        }
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
    	txtConsulta+=' <span '+compAux+'>'+apTag+arrConsulta[x][1].replace(/<br>/g,'<br />')+cTag+exclamacion+'</span>';
    }
    gE('spArea').innerHTML=txtConsulta;
}

function validarOperador(operador)
{
	var arrValor=null;
	if(arrConsulta.length>0)
		arrValor=arrConsulta[arrConsulta.length-1];
	switch(operador)
    {
    	case 'Y':
        	if((arrValor==null)||((arrValor[2]=='1')&&(arrValor[1]!=')')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
        break;
        case 'O':
        	if((arrValor==null)||((arrValor[2]=='1')&&(arrValor[1]!=')')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
        break;
    	case '+':
        	if((arrValor==null)||((arrValor[2]=='1')&&(arrValor[1]!=')')))
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
        	if((arrValor==null)||((arrValor[2]=='1')&&(arrValor[1]!=')')))
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
        	if((arrValor==null)||((arrValor[2]=='1')&&(arrValor[1]!=')')))
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
        	if((arrValor==null)||((arrValor[2]=='1')&&(arrValor[1]!=')')))
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
        	if((arrValor==null)||((arrValor[2]=='1')&&(arrValor[1]!=')')))            
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
        break;
        case '<':
        	if((arrValor==null)||((arrValor[2]=='1')&&(arrValor[1]!=')')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
        break;
        case '=':
        	if((arrValor==null)||((arrValor[2]=='1')&&(arrValor[1]!='>')&&(arrValor[1]!='<')&&(arrValor[1]!=')')))
            {
            	msgBox('El operador '+operador+' no puede ser agregado debido a que debe ir precedido de un operando');
                return false;
            }
        break;
        case ')':
        	if((arrValor==null)||(arrValor[2]=='1'))
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
    var idConsultaExp=gE('idConsultaExp').value;
    
/*    if(arrConsulta.length==0)
    {
    	msgBox('La expresi&oacute;n no puede ser vac&iacute;a');
    	return;
    }
*/    var idProceso=gE('idPerfil').value;
    var nEtapa=gE('numEtapa').value;
    var valParametros='';
    var arrParam;
    var z;
    var cadParam='';
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
        
        token='{"tokenUsuario":"'+cv(arrConsulta[x][1])+'","tokenMysql":"'+cv(arrConsulta[x][0])+'","tipoToken":"'+arrConsulta[x][2]+'","valorDevuelto":"'+arrConsulta[x][3]+'","valParametros":"'+valParametros+'"}';
        if(arrTokens=='')
            arrTokens=token;
        else
            arrTokens+=','+token;
    }
    var valorRetorno=valorPredominio;
    var parametros='idNomina,numEtapa';
   /*
    for(x=0;x<arrParametros.length;x++)
    {
    	if(parametros=='')
        	parametros=arrParametros[x];
        else
        	parametros+=','+arrParametros[x];
            
	}*/
    
    objFinal='{"idConsulta":"'+idConsultaExp+'","tConsulta":"11","valorRetorno":"'+valorRetorno+'","tabla":"'+idProceso+'","campoProy":"'+nEtapa+'","tokenSql":['+arrTokens+'],"parametros":"'+cv(parametros)+'"}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
			guardarExpresion(objFinal,'Disparador de perfil de nómina: '+idProceso,'Etapa: '+nEtapa,'','15','0');
        }
        else
        {
            Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','La consulta ingresada presenta errores de sint&aacute;xis, por favor verif&iacute;quela');
            return;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=147&tb=&obj='+objFinal+'&tipo=2',true);
    
}

function obtenerAcumuladores()
{
	var x;
    var variableAcumuladora=Ext.getCmp('variableAcumuladora');
    var valor;
    for(x=0;x<arrConsulta.length;x++)
    {
    	if(arrConsulta[x][2]=='10')
        {
        	valor=arrConsulta[x][1].substr(1);
            
            if(valor.substr(valor.length-1)=='=')
            	valor=valor.substr(0,valor.length-1);
            if(gEx('ac'+valor)==null)
            {
            	
                variableAcumuladora.enable();
                var menu=	{
                                id:'ac'+valor,
                                text:valor,
                                handler:function()
                                        {
                                            
                                            var arrValor=new Array();
                                            arrValor[0]='$'+this.text;
                                            arrValor[1]='@'+this.text;
                                            arrValor[2]='21';
                                            arrValor[3]='';
                                            arrValor[4]=[];
                                            arrConsulta[arrConsulta.length]=arrValor;
                                            generarSentenciaConsultaOperacion();
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
                                                                                    arrValor[1]= ''+valor;
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
                                                        	x:150,
                                                            y:5
                                                        }
                                                        
													]
										}
									);
	var ventana = new Ext.Window(
									{
										title: 'Agregar variable acumuladora',
										width: 310,
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
                                                                                    var arrValor=new Array();
                                                                                    arrValor[0]= '$'+valor+'=';
                                                                                    arrValor[1]= '@'+valor+'=';
                                                                                    arrValor[2]= 21;
                                                                                    arrValor[3]='';
                                                                                    arrValor[4]=[];
                                                                                    arrConsulta[arrConsulta.length]=arrValor;
                                                                                    generarSentenciaConsultaOperacion();
                                                                                    var variableAcumuladora=Ext.getCmp('variableAcumuladora');
                                                                                    variableAcumuladora.enable();
                                                                                    var menu=	{
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
                                                                                                                arrConsulta[arrConsulta.length]=arrValor;
                                                                                                                generarSentenciaConsultaOperacion();
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

function guardarExpresion(objFinal,nombre,descripcion,codigo,idTipoConcepto,idAmbito)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(gE('idConsultaExp').value=='-1')
	        	gE('idConsultaExp').value=arrResp[1];
        	msgBox('La expresi&oacute;n ha sido guardada corectamente');
	        return;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=148&obj='+objFinal+'&nombre='+cv(nombre)+'&descripcion='+cv(descripcion)+'&codigo='+codigo+'&idTipoConcepto='+idTipoConcepto+'&idAmbito='+idAmbito,true);	
}

function mostrarFuncionesSistema()
{
	var gridFuncion=crearGridFunciones();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione la funci&oacute;n que desea ejecutar:'
                                                            
                                                        },
                                                        gridFuncion	

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Ejecutar funci&oacute;n',
										width: 420,
										height:420,
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
                                                                        var idProceso=gE('idPerfil').value;
																	    var numEtapa=gE('numEtapa').value;
                                                                        var idFuncion=fila.get('idFuncion');
                                                                        var nFuncion=fila.get('nFuncion');
                                                                        var requiereParametro=fila.get('requiereParametro');
                                                                        var obj='{"idFuncion":"'+idFuncion+'","idProceso":"'+idProceso+'","numEtapa":"'+numEtapa+'"}';
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
	var dsDatos=<?php echo $arrFunciones?>;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idFuncion'},
                                                                    {name: 'nFuncion'},
                                                                    {name: 'tipoFuncion'},
                                                                    {name: 'requiereParametro'}
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
															header:'Nombre de la funci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'nFuncion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:280,
                                                            width:390,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function registrarInvocacionFuncion(obj,nFuncion,valorParam,pos)
{
	var arrValor=new Array();
    arrValor[0]=obj;
    arrValor[1]='ejecutar '+nFuncion+'('+valorParam+')';
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
	var idProceso=gE('idPerfil').value;
    var numEtapa=gE('numEtapa').value;
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
                                                                            aux='{"parametro":"'+fila.get('parametro')+'","valor":"'+fila.get('asigna')+'","tipoValor":"'+fila.get('tipoParam')+'","valorSistema":"'+fila.get('valorSistema')+'"}';
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
                                                                    {name: 'valorSistema'}
                                                                    
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
	var idProceso=gE('idPerfil').value;
    var nEtapa=gE('numEtapa').value;
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
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=198&idInvocacion='+idInvocacion+'&idFuncion='+idFuncion,true);
}

function asignarValorParametroAlmacen(nFila)
{
    var arrTipoEntrada=[['7','Consulta auxiliar'],['1','Valor Constante'],['3','Valor de sesi\xF3n'],['4','Valor de sistema'],['21','Valor de variable acumuladora']];
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
                                                                        var valorSistema='';
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
                                                                            break;
                                                                        }            
                                                                        var fila=gEx('gridAsignaParametros').getStore().getAt(bD(nFila));
                                                                        var tipo=cmbTipoValor.getValue();
                                                                        if(tipo=='1')
                                                                            fila.set('asigna',''+valorUsr);
                                                                        else
                                                                            fila.set('asigna','['+valorUsr+']');
                                                                       fila.set('tipoParam',cmbTipoValor.getValue());
                                                                       fila.set('valorSistema',valorSistema);
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
        break;
        case '16':
        	cmbValor.getStore().loadData(arrProceso);
        	cmbValor.show();
        break;
      
        
    }
}

function modificarValorParametroFuncion(pos)
{
	
	var cadObj=	'['+arrConsulta[bD(pos)][0]+']';
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
										title: 'Vincular campo especial',
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
                    var nCampo=arrTabla[1];
                    
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
                                                                        arrValor[2]=21;
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
    var arrTipoEntrada=[['1','Valor Constante'],['16','Valor de proceso'],['3','Valor de sesi\xF3n'],['4','Valor de sistema'],['15','Valor de variable acumuladora']];
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
                                                                        var almacen=iAlmacen;
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
	
    var arrTipoEntrada=[['7','Consulta auxiliar'],['1','Valor Constante'],['16','Valor de proceso'],['3','Valor de sesi\xF3n'],['4','Valor de sistema']];
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
                                                                        var almacen=nodoSel.attributes.dSetPadre;
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
        case '16':
        	cmbValor.getStore().loadData(arrProceso);
        	cmbValor.show();
        break;
        
    }
}

function mostrarVentanaAdminParametros()
{
	var gParametro=crearGridParametros();
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

function crearGridParametros()
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