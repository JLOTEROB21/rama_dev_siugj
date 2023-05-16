<?php
session_start();
include("conexionBD.php"); 
include("configurarIdiomaJS.php");

$res5=$con->obtenerFilas("select idIdioma,idioma,imagen from 8002_idiomas");
$columnas="";
$ancho=105;
while($fila5=mysql_fetch_row($res5))
{
	if($columnas=="")
		$columnas= "{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:150,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({  style: 'text-align:left'})}";
	else
		$columnas.=","."{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:150,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({  style: 'text-align:left'})}";
$ancho+=150;	
}	
if($ancho==255)
	$ancho+=150;
$columnas=uEJ($columnas);

$campos="{name:'valorOpt'}";
$camposOpciones="valorOpt:''";
$filaDefault="''";
if(mysql_data_seek($res5,0))
{
	while($fila5=mysql_fetch_row($res5))
	{
		$campos.=",{name:'idioma_".$fila5[0]."'}";
		$camposOpciones.=",idioma_".$fila5[0].":''";
		$filaDefault.=",''";
	}	
}
$campos=uEJ($campos);
$camposOpciones=uEJ($camposOpciones);

$consulta="select idGrupoCampo,tipoCampo from 905_tiposCampoEntrada where idIdioma=".$_SESSION["leng"]." and idGrupoCampo in(5,6,7,11,24) order by tipoCampo";
$cuerpo=uEJ($con->obtenerFilasArreglo($consulta));
$consulta="select idTipoDocumento,tipoDocumento from 906_tipoDocumentos";
$tDocumentos=($con->obtenerFilasArreglo($consulta));
$idFormulario=$_GET["idFormulario"];
$consulta="select idProceso from 900_formularios where idFormulario=".$idFormulario;
$idProceso=$con->obtenerValor($consulta);
$consulta="select idEtapa,nombreEtapa from 4037_etapas where idProceso=".$idProceso." order by numEtapa";
$arrEtapas=$con->obtenerFilasArreglo($consulta);
$aEtapas=substr($arrEtapas,1);
echo "var arrEtapas=[['-1','".$etj["lblSinAccion"]."'],".($aEtapas).";";
														  
$query="select propiedadUsr,propiedadCss,categoriaEstilo,valorDefault from 934_propiedadesCSS where idIdioma=".$_SESSION["leng"]." order by categoriaEstilo,propiedadUsr";	
$arrPropiedadesEst=uEJ($con->obtenerFilasArreglo($query));

$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='SiNo' order by orden";
$arrSiNoCss=uEJ($con->obtenerFilasArreglo($query));
$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='vAlineacion' order by orden";
$arrVAlineacion=uEJ($con->obtenerFilasArreglo($query));
$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='hAlineacion' order by orden";
$arrHAlineacion=uEJ($con->obtenerFilasArreglo($query));
$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='fuente' order by orden";
$arrFuentes=uEJ($con->obtenerFilasArreglo($query));
$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='estiloBorde' order by orden";
$arrEstilosBorde=uEJ($con->obtenerFilasArreglo($query));

$arrExtImgValidas=explode("|",$imgExtValidas);
$nExtensiones=sizeof($arrExtImgValidas);
$arrValidacion="";
for($x=0;$x<$nExtensiones;$x++)
{
	$cad="(extension=='.".strtolower($arrExtImgValidas[$x])."')";
	if($arrValidacion=="")
		$arrValidacion=$cad;
	else
		$arrValidacion.="||".$cad;
}

$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=1 order by descripcionValor ";
$arrValorSesion=uEJ($con->obtenerFilasArreglo($consulta));
$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=2 order by descripcionValor ";
$arrValorSistema=uEJ($con->obtenerFilasArreglo($consulta));

$query="select idEnlace,titulo,enlace,descripcion,tipoReferencia from 9040_listadoEnlaces where idFormulario=".$idFormulario." and tipoEnlace=0 order by titulo";
$arrEnlaces=$con->obtenerFilasArreglo($query);
if($arrEnlaces!="[]")
	$arrEnlaces="[['','Ninguno'],".substr($arrEnlaces,1);
else
	$arrEnlaces="[['','Ninguno']]";
?>


var ventanaNuevoElemento=null;
var ventanaEtiquetas=null;
var ventanaOrigenDatosSel=null;
var ventanaPregCerradas=null
var ventanaIntervalo=null;
var ventanaPregAbiertas=null;
var tVSesion=[['1','<?php echo $etj["lblIdiomaAct"]?>'],['2','<?php echo $etj["lblGrupoUsr"]?>'],['3','<?php echo $etj["lblIdUsr"]?>'],['4','<?php echo $etj["lblLogin"]?>'],['5','<?php echo $etj["lblNombreUsr"]?>'],['6','<?php echo $etj["lblFechaActual"]?>'],['7','<?php echo $etj["lblHoraActual"]?>']];
var tipoElemento;
var idElemento;
var idFormulario;
var idOrigenD;
var param1;
var param2;
var param3;
var param4;
var param5;
var estado=2; //1 seleccionar;2 mover;
var filtroUsuario=new Array();
var filtroMysql=new Array();
var controlVPActivo=1;
var arrEnlaces=<?php echo $arrEnlaces?>;
//2281092289

var rgIdiomas = Ext.data.Record.create	
(
	[
        {name: 'idioma'},
        {name: 'idIdioma'},
        {name: 'etiqueta'}
	]
 );

var arrSiNo=[['0','<?php echo $etj["lblNo"] ?>'],['1','<?php echo $etj["lblSi"] ?>']];
var tDocumento=<?php echo $tDocumentos ?>;

RegistroOpciones =Ext.data.Record.create	(
												[
													<?php 
														echo $campos;
													?>
												]
											)

RegistroSimple =Ext.data.Record.create	(
											[
												{name:'id'},
												{name:'nombre'}
											]
										)

function lanzarVentanaConfiguracion(idElemento)
{
	idFormulario=gE('idFormulario').value;
	switch(idElemento)
    {
    	case 1:
			crearVentanaNuevoElemento(1);	        	
        break;
        case 2:
        case 3:
        case 4:
        	mostrarVentanaPreguntasCerradas();
        break;
        case 5:
        case 6:
        case 7:
			mostrarVentanaPreguntasAbiertas();        
        break;
        case 8:
        break;
        case 9:
        break;
        case 10:
        break;
        case 11:
       
        	mostrarVentanaPreguntasAbiertas();
        break;
        case 12:
        break;
        case 13:
        	crearVentanaNuevoElemento(13);
        break;
        case 14:
        	mostrarVentanaPreguntasOpciones();
        break;
        case 15:
        	mostrarVentanaPreguntasOpcionesMultiples();
        break;
        case 16:
        	mostrarVentanaCampoOculto();
        break;
    }

}

function cambiarColor(val)
{
	 return '<img src="../images/banderas/'+val+'" />';
}

function crearVentanaNuevoElemento(tElemento)
{
	var tituloVentana='<?php echo $etj["lblAgregarNElem"] ?>';
	lblBtnAceptar='<?php echo $etj["lblFinalizar"] ?>';
	function obtenerIdiomas()
	{
		var resp=eval(peticion_http.responseText);
		var tblGrid=crearGridElemento();
        var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: 	[
																tblGrid
															]
												}
											);
		
		ventanaEtiquetas = new Ext.Window(
											{
												title: tituloVentana,
												width: 750,
												height:280,
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
																			pIdioma=obtenerPosFila(alNameDTD,'idIdioma',gE('hLeng').value);
																			if(pIdioma!=-1)
																			{
																				tblGrid.startEditing(pIdioma,1);
																			}
																		}
																	}
														},
												buttons:	[
																{
																	id:'btnAceptar',
																	text: lblBtnAceptar,
																	listeners:	{
																					click:function()
																						{
																							if(validar(tblGrid))
																							{
                                                                                                var arrEtiqueta=obtenerValoresVentanaEtiquetas();
                                                                                                if(tElemento==1)
	                                                                                                objFinal='{"idFormulario":"'+idFormulario+'","pregunta":'+arrEtiqueta+',"tipoElemento":"'+tElemento+'","obligatorio":"0","posX":"'+mitadX+'","posY":"'+mitadY+'"}';
                                                                                                if(tElemento==13)
	                                                                                                objFinal='{"idFormulario":"'+idFormulario+'","pregunta":'+arrEtiqueta+',"tipoElemento":"'+tElemento+'","obligatorio":"0","posX":"'+mitadX+'","posY":"'+mitadY+'","confCampo":{"ancho":"400","alto":"200"}}';
                                                                                                
                                                                                                
                                                                                                guardarPregunta(objFinal,ventanaEtiquetas);
																								
																							}
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventanaEtiquetas.close();
																			}
																}
															]
											}
										);
        llenarDatos(resp,ventanaEtiquetas);
	}
	obtenerDatosWeb('../paginasFunciones/funciones.php',obtenerIdiomas, 'POST','funcion=4',true);
}

function mostrarVentanaCampoOculto()
{
    var btnSiguiente=	new Ext.Button	( 
                                            {
                                                text: '<?php echo $etj["lblFinalizar"]?>',
                                                minWidth:80,
                                                handler:function()
                                                        {
                                                            var idElemento=Ext.getCmp('idCmbValoresS').getValue();
                                                            if(idElemento=='')
                                                            {
                                                                function resp()
                                                                {
                                                                    gE('idCmbValoresS').focus(false,10);
                                                                }
                                                                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblDebeSelS"] ?>',resp);
                                                                return;
                                                            }
                                                            
                                                            var txtNombreCampo=Ext.getCmp('txtNombreCampo').getValue();
                                                            if(txtNombreCampo=='')
                                                            {
                                                                function resp()
                                                                {
                                                                    Ext.getCmp('txtNombreCampo').focus(false,10);
                                                                }
                                                                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblValInv"] ?>',resp);
                                                                return;
                                                            }
                                                            var confCampo='{"vSesion":"'+idElemento+'","complemento":""}';
                                                            var objFinal='{"idFormulario":"'+idFormulario+'","tipoElemento":"20","confCampo":'+confCampo+',"nomCampo":"'+txtNombreCampo+'","posX":"0","posY":"0","obligatorio":"0","pregunta":null}';
                                                            
                                                            guardarPregunta(objFinal,ventanaPregAbiertas);
                                                        }
                                            }
                                        );
                        
    var comboValoresS= crearComboValoresSession();		
    
                            
    
    var txtNombreCampo=new Ext.form.TextField	(
    												{
                                                    	id:'txtNombreCampo',
                                                        x:120,
                                                        y:35,
                                                        width:160,
                                                        hideLabel:true,
                                                        maskRe:/^[a-zA-Z0-9]$/
                                                       
                                                    }
    											)
    
    
                        
    var form = new Ext.form.FormPanel	(	
                                            {
                                                
                                                baseCls: 'x-plain',
                                                layout:'absolute',
                                                defaultType: 'numberfield',
                                                items: 	[
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:10,
                                                                                        text:'<?php echo $etj["lblValSession"]?>:'
                                                                                    }
                                                                                ) ,
                                                            comboValoresS,
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:40,
                                                                                        text:'<?php echo $etj["lblNomCampo"]?>:'
                                                                                    }
                                                                                ) ,
	                                                        txtNombreCampo,                        
                                                                                                                                                    
                                                           
                                                           
                                                        ]
                                            }
                                        );
    
    ventanaPregAbiertas = new Ext.Window	(
                                                {
                                                    title: '<?php echo $etj["lblInsHidden"]?>',
                                                    width: 430,
                                                    height:190,
                                                    minWidth: 280,
                                                    minHeight: 100,
                                                    layout: 'fit',
                                                    plain:true,
                                                    bodyStyle:'padding:5px;',
                                                    buttonAlign:'center',
                                                    items: form,
                                                    modal:true,
                                                    listeners : {
                                                                    show : {
                                                                                buffer : 10,
                                                                                fn : function() 
                                                                                {
                                                                                    
                                                                                }
                                                                            }
                                                                },
                                                    buttons:	[
                                                                    
                                                                    btnSiguiente,
                                                                    {
                                                                        text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                                        minWidth:80,
                                                                        handler:function()
                                                                                {
                                                                                    ventanaPregAbiertas.close();
                                                                                }
                                                                    }
                                                                ]
                                                }
                                            );
	
	ventanaPregAbiertas.show();
    comboValoresS.focus(false,10);
}

function crearGridElemento(datos)
{
	var tituloElemento;
    tituloElemento='<?php echo $etj["lblIngContE"] ?>';
	var dsNameDTD= 	[];					
    alNameDTD=		new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idioma'},
																{name: 'idIdioma'},
																{name: 'etiqueta'}
    														]
    											}
    										);
    alNameDTD.loadData(dsNameDTD);
	
	
	var cmFrmDTD= new Ext.grid.ColumnModel   	(
												 	[
													 	{
															header:'<?php echo $etj["lblLenguaje"]?>',
															width:80,
															dataIndex:'idioma',
															renderer: cambiarColor
														},
														{
															header:tituloElemento+' *',
															width:600,
															dataIndex:'etiqueta',
															editor: new Ext.form.TextField   (
																									{
																									   style: 'text-align:left'
																									}
																								)
														}
													]
												);
											
	tblFrmDTD=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                    	id:'gridEtiquetas',
                                                        store:alNameDTD,
                                                        frame:true,
                                                        clicksToEdit: 1,
                                                        cm: cmFrmDTD,
                                                        height:150,
                                                        width:740
                                                    }
							                    );
	
	return tblFrmDTD;	
}	

function llenarDatos(datos,ventanaEtiquetas)
{
	for (x=0;x<datos.length;x++)
	{
		
		var FilaRegistro = new rgIdiomas(
                                            {
                                                    idioma:datos[x].imagen,
                                                    idIdioma: datos[x].idIdioma,
                                                    etiqueta: ''
                                               }
                                          );
                                                  
        alNameDTD.add(FilaRegistro); 
	}
    ventanaEtiquetas.show();
}

function obtenerValoresVentanaEtiquetas()
{
	var dsGrid=Ext.getCmp('gridEtiquetas').getStore();
    var fila;
	var idIdioma;
	var etiqueta;
    var idElemento;
    var idSeccion;
    var idElemAnt;
    var idElemSig;
	var arrObj="";
	var obj;
	var x;
    var arrEtiqueta;
    for(x=0;x<dsGrid.getCount();x++)
	{
		fila=dsGrid.getAt(x);
		idIdioma=fila.get('idIdioma');
		etiqueta=fila.get('etiqueta');
		obj='{"idIdioma":"'+idIdioma+'","etiqueta":"'+cv(etiqueta)+'"}';
		if(arrObj=="")
			arrObj=obj;
		else
			arrObj+=','+obj;
	}
    arrEtiqueta='['+arrObj+']';

	return arrEtiqueta;
}

function validar(tblGrid)
{
	var res=validarCampos(tblGrid);
	switch(res)
	{
		case 0: //Sin problemas
			return true;	
		break;
		case 1: //Algun campo obligatorio del idioma original no fue ingresado
		
			function funcAceptar()
			{
				tblGrid.startEditing(filaError,celdaError);
				return false;
			}
			Ext.Msg.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgErrorCeldaVacia"] ?>',funcAceptar);
			
		break;
		case 2: //Algun campo obligatorio de idioma NO original fue ingresado
			function funcConfirmacion(btn)
			{
				if(btn=='yes')
				{
					var dSet=tblGrid.getStore();
					var fIdioma=obtenerFilaIdioma(dSet,gE('hLeng').value);
					var cModelo=tblGrid.getColumnModel();
					var campo='';
					var valor='';
					var col;
					for(col=0;col<cModelo.getColumnCount();col++)
					{
						campo=cModelo.getDataIndex(col);
						valor=fIdioma.get(campo);
						if(valor!='')
						{
							rellenarValoresVacios(dSet,campo,'['+valor+']');
						}
					}
					
					
					
					Ext.getCmp('btnAceptar').fireEvent('click');
				}
				else
					return false;
			}
			Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>', '<?php echo $etj["msgErrorOpcionV"] ?>', funcConfirmacion);
		break;
	}
}

function validarCampos(tblGrid)		
{
	var idIdioma=gE('hLeng').value;
	var dSet=tblGrid.getStore();
	var fila=obtenerFilaIdioma(dSet,idIdioma);
	
	if(fila!=null)
	{
		var cModelo=tblGrid.getColumnModel();
		var tituloColumna='';
		var campo;
		var valor;
		var posFila=obtenerPosFila(dSet,'idIdioma',idIdioma);
		var arrCampos='';
		
		for(x=0;x<cModelo.getColumnCount();x++)
		{
			tituloColumna=cModelo.getColumnHeader(x);
			if(tituloColumna.indexOf('*')>=0)
			{
				
				campo=cModelo.getDataIndex(x);
				valor=fila.get(campo);
				if(arrCampos=='')
					arrCampos=campo;
				else
					arrCampos+='|'+campo;
				if(trim(valor)=='')
				{
					filaError=posFila;
					celdaError=x;
					return 1;	
				}
			}
		}
		aCampo=arrCampos.split('|');
		for(x=0;x<dSet.getCount();x++)
		{
			if(x!=posFila)
			{
				fila=dSet.getAt(x);
				for(y=0;y<aCampo.length;y++)
				{
					valor=fila.get(aCampo[y]);
					if(trim(valor)=='')
					{
						filaError=posFila;
						celdaError=x;
						return 2;
					}
				}
			}
		}
	}
	return 0;
}

var objDatosActual;

function guardarPregunta(datosP,ventana)//accion 0 guardar Nuevo;1 modificar
{
	
	objDatosActual='['+datosP+']';
	var obj=eval('['+datosP+']');
	var idControl=dv(obj[0].nomCampo);
    var tipoElemento=obj[0].tipoElemento;
    if((tipoElemento>1)&&(tipoElemento!=22))
    {
    	var ctrl=gE(idControl);
        if(ctrl!=null)
        {
        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["errControlExiste"]?>');
            return;
        }
    }
    
    function funcResp()
    {
    	var arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
		{
        		var x;
                var cadenaExp='';
        		if(tipoElemento==22)
                {
                	
                    for(x=0;x<arrConsulta.length;x++)
                    {
                    	cadObj="['"+arrConsulta[x][0]+"','"+arrConsulta[x][1]+"','"+arrConsulta[x][2]+"']";
                    	 if(cadenaExp=='') 
                         	cadenaExp=cadObj;
                         else
                         	cadenaExp+=','+cadObj;
                    }
                }
        
        		if((tipoElemento==22)&&(obj[0].accion!="-1"))
                {
                	var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var control='_'+arrNomAnt[1];
                    gE('exp_'+control).value='['+cadenaExp+']';
                	evaluarExpresion(control);
                    ventana.close();
                }
                else
                {
                    var opcionesElem=arrResp[2];
                    var arrContenido=crearControl(datosP,arrResp[1],opcionesElem);
                    insertarControl(arrContenido);
                    ventana.close();
                }
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=1&datosP='+datosP,true);
}

function crearComboSiNo(id)
{
	var idCombo='idComboSiNo';
    if(id!=undefined)
    	idCombo=id;
	
	var dsDatos= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'tipo'}
																]
													}
												);
	dsDatos.loadData(arrSiNo);
	var comboSiNo=document.createElement('select');
	var cmbSiNo=new Ext.form.ComboBox	(
													{
                                                    	x:140,
                                                        y:65,
														id:idCombo,
														mode:'local',
														emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
														store:dsDatos,
														displayField:'tipo',
														valueField:'id',
														transform:comboSiNo,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
                                                        width:120
													}
												)
	return cmbSiNo;	
}

function mostrarVentanaPreguntasAbiertas()
{
		
    var btnSiguiente=	new Ext.Button	( 
                                            {
                                                text: '<?php echo $etj["lblFinalizar"]?>',
                                                minWidth:80,
                                                handler:function()
                                                        {
                                                            var idElemento=Ext.getCmp('idCmbTipoElemento').getValue();
                                                            if(idElemento=='')
                                                            {
                                                                function resp()
                                                                {
                                                                    gE('idCmbTipoElemento').focus(false,10);
                                                                }
                                                                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblDebeSelTE"] ?>',resp);
                                                                return;
                                                            }
                                                            
                                                            var txtNombreCampo=Ext.getCmp('txtNombreCampo').getValue();
                                                            if(txtNombreCampo=='')
                                                            {
                                                                function resp()
                                                                {
                                                                    Ext.getCmp('txtNombreCampo').focus(false,10);
                                                                }
                                                                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblValInv"] ?>',resp);
                                                                return;
                                                            }
                                                            
                                                            switch(idElemento)
                                                            {
                                                                case '5':
                                                                case '11': 	//Grupo Texto
                                                                    var txtLogitud=Ext.getCmp('txtLongitud');
                                                                    var txtAncho=Ext.getCmp('txtAncho');
                                                                    var longitud=txtLogitud.getValue();
                                                                    var ancho=txtAncho.getValue();
                                                                    if(longitud=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtLogitud.focus(false,10);
                                                                        }
                                                                        Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblValInv"] ?>',resp);;
                                                                        return;
                                                                    }
                                                                    if(ancho=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtAncho.focus(false,10);
                                                                        }
                                                                        Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblValInv"] ?>',resp);;
                                                                        return;
                                                                    }
                                                                
                                                                    objConfCampo='{"longitud":"'+longitud+'","ancho":"'+ancho+'"}'		  
                                                                break;
                                                                default:
                                                                    objConfCampo=null
                                                            }
                                                            
                                                            var objFinal='{"idFormulario":"'+idFormulario+'","tipoElemento":"'+idElemento+'","confCampo":'+objConfCampo+',"nomCampo":"'+txtNombreCampo+'","posX":"'+mitadX+'","posY":"'+mitadY+'","obligatorio":"'+comboSiNo.getValue()+'","pregunta":null}';
                                                            guardarPregunta(objFinal,ventanaPregAbiertas);
                                                        }
                                            }
                                        );
                        
    var comboTipoE= crearComboTipoElemento();		
    var comboTipoDoc=crearComboTipoDocumento();
    var comboSiNo=crearComboSiNo();
    comboSiNo.setValue('0');
    function funcSelectTipoE(c,r,i)
    {
        var id=r.get('id');
        var ancho;
        var alto;
        switch(id)
        {
            case '5':
            case '11': //Grupo Texto
                Ext.getCmp('grupoTexto').show();
                ventanaPregAbiertas.setHeight(320);
                
            break;
            default:
                Ext.getCmp('grupoTexto').hide();
                ventanaPregAbiertas.setHeight(190);
        }
        Ext.getCmp('txtNombreCampo').focus(false,10);
    }			
    comboTipoE.on('select',funcSelectTipoE);
                            
    var txtLongitud= new Ext.form.NumberField	({
                                                    id:'txtLongitud',
                                                    x:120,
                                                    y:5,
                                                    width:70,
                                                    hideLabel:true,
                                                    allowDecimals:false,
                                                    value:30
                                                });				
                                                        
    var txtAncho= new Ext.form.NumberField	({
                                                    id:'txtAncho',
                                                    x:120,
                                                    y:35,
                                                    width:70,
                                                    hideLabel:true,
                                                    allowDecimals:false,
                                                    value:30
                                                });	
    
    var txtNombreCampo=new Ext.form.TextField	(
    												{
                                                    	id:'txtNombreCampo',
                                                        x:140,
                                                        y:35,
                                                        width:160,
                                                        hideLabel:true,
                                                        maskRe:/^[a-zA-Z0-9]$/

                                                       
                                                    }
    											)
    
    var grupoTextoCorto=new Ext.form.FieldSet	(
                                                    {
                                                        id:'grupoTexto',
                                                        x:10,
                                                        y:105,
                                                        width:325,
                                                        height:100,
                                                        hidden:true,
                                                        layout: 'absolute',
                                                        title:'<?php echo $etj["lblConfControl"]?>',
                                                        items:	[
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:10,
                                                                                                width:200,
                                                                                                text:'<?php echo $etj["lblLongitud"]?>:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    txtLongitud,
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                width:200,
                                                                                                text:'<?php echo $etj["lblAncho"]?>:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    txtAncho
                                                                ]
                                                    }
                                                )
                        
    var form = new Ext.form.FormPanel	(	
                                            {
                                                
                                                baseCls: 'x-plain',
                                                layout:'absolute',
                                                defaultType: 'numberfield',
                                                items: 	[
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:10,
                                                                                        text:'<?php echo $etj["lblTipoEntrada"]?>:'
                                                                                    }
                                                                                ) ,
                                                            comboTipoE,
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:40,
                                                                                        text:'<?php echo $etj["lblNomCampo"]?>:'
                                                                                    }
                                                                                ) ,
	                                                        txtNombreCampo,                        
                                                                                                                                                    
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:70,
                                                                                        text:'<?php echo $etj["lblCampoObl"]?>:'
                                                                                    }
                                                                                ) , 
                                                            comboSiNo,
                                                            grupoTextoCorto
                                                           
                                                        ]
                                            }
                                        );
    
    ventanaPregAbiertas = new Ext.Window	(
                                                {
                                                    title: '<?php echo $etj["lblPropiedades"]?>',
                                                    width: 370,
                                                    height:190,
                                                    minWidth: 280,
                                                    minHeight: 100,
                                                    layout: 'fit',
                                                    plain:true,
                                                    bodyStyle:'padding:5px;',
                                                    buttonAlign:'center',
                                                    items: form,
                                                    modal:true,
                                                    listeners : {
                                                                    show : {
                                                                                buffer : 10,
                                                                                fn : function() 
                                                                                {
                                                                                    txtLongitud.focus(true,10);
                                                                                }
                                                                            }
                                                                },
                                                    buttons:	[
                                                                    
                                                                    btnSiguiente,
                                                                    {
                                                                        text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                                        minWidth:80,
                                                                        handler:function()
                                                                                {
                                                                                    ventanaPregAbiertas.close();
                                                                                }
                                                                    }
                                                                ]
                                                }
                                            );
	
	ventanaPregAbiertas.show();
    comboTipoE.focus(false,10);
}

function crearComboTipoElemento()
{
	var tEntradas=<?php echo $cuerpo ?>;
	var dsDatos= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'tipo'}
																]
													}
												);
	dsDatos.loadData(tEntradas);
	var comboDatos=document.createElement('select');
	var cmbDatos=new Ext.form.ComboBox	(
													{
														x:140,
														y:5,
														id:'idCmbTipoElemento',
														mode:'local',
														emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
														store:dsDatos,
														displayField:'tipo',
														valueField:'id',
														transform:comboDatos,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
														minListWidth:200
													}
												)
	return cmbDatos;	
}

function crearComboValoresSession(id)
{
	
	var dsDatos= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'tipo'}
																]
													}
												);
	dsDatos.loadData(tVSesion);
    
    if(id==undefined)
    	idCtrl='idCmbValoresS';
    else	
    	idCtrl=id;
    
	var comboDatos=document.createElement('select');
	var cmbDatos=new Ext.form.ComboBox	(
													{
														x:120,
														y:5,
														id:idCtrl,
														mode:'local',
														emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
														store:dsDatos,
														displayField:'tipo',
														valueField:'id',
														transform:comboDatos,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
                                                        width:250,
														minListWidth:300
													}
												)
	return cmbDatos;	
}

var dsComboSeleccion;

function crearCombo(idCombo)
{
	var tEntradas=[];
	dsComboSeleccion= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'tipo'}
																]
													}
												);
	dsComboSeleccion.loadData(tEntradas);
	var comboDatos=document.createElement('select');
	var cmbDatos=new Ext.form.ComboBox	(
													{
														id:idCombo,
														mode:'local',
														emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
														store:dsComboSeleccion,
														displayField:'tipo',
														valueField:'id',
														transform:comboDatos,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
														minListWidth:200
													}
												)
	return cmbDatos;	
}

function crearComboTipoDocumento(id)
{
	
	var dsDatos= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'tipo'}
																]
													}
												);
	dsDatos.loadData(tDocumento);
	var comboDocumentos=document.createElement('select');
    if(id ==undefined)
    	idCtrl='idCmbTipoDocumento';
    else   
    	idCtrl=id;
	var cmbDocumentos=new Ext.form.ComboBox	(
													{
														x:140,
														y:5,
														id:idCtrl,
														mode:'local',
														emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
														store:dsDatos,
														displayField:'tipo',
														valueField:'id',
														transform:comboDocumentos,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
														minListWidth:300,
                                                        width:200
													}
												)
	return cmbDocumentos;	
}

function mostrarVentanaPreguntasUnicas(tipoElemento)
{
	idFormulario=gE('idFormulario').value;
    
    var txtTamMax= new Ext.form.NumberField	({
                                                    id:'txtTamMax',
                                                    x:140,
                                                    y:35,
                                                    width:70,
                                                    hideLabel:true,
                                                    allowDecimals:false,
                                                    value:200
                                                });	                                                    					
                                                
    var txtAnchoTL= new Ext.form.NumberField	({
                                                    id:'txtAnchoTL',
                                                    x:120,
                                                    y:5,
                                                    width:100,
                                                    hideLabel:true,
                                                    allowDecimals:false,
                                                    value:400
                                                });	
                                                
    var txtAltoTL= new Ext.form.NumberField	({
                                                    id:'txtAltoTL',
                                                    x:120,
                                                    y:35,
                                                    width:100,
                                                    hideLabel:true,
                                                    allowDecimals:false,
                                                    value:250
                                                });	                                                                                                        

    var dteFechaMin=new Ext.form.DateField	(
                                                {
                                                    id:'dteFechaMin',
                                                    x:140,
                                                    y:5,
                                                    width:110,
                                                    hideLabel:true,
                                                    format:'d/m/Y'
                                                }
                                            )
                                            
    var dteFechaMax=new Ext.form.DateField	(
                                                {
                                                    id:'dteFechaMax',
                                                    x:140,
                                                    y:35,
                                                    width:110,
                                                    hideLabel:true,
                                                    format:'d/m/Y'
                                                }
                                            )  


	var tmeHoraMin=new Ext.form.TimeField	(
                                                {
                                                    id:'tmeHoraMin',
                                                    x:140,
                                                    y:5,
                                                    width:110,
                                                    hideLabel:true,
                                                    format:'H:i'
                                                }
                                            )
                                            
    var tmeHoraMax=new Ext.form.TimeField	(
                                                {
                                                    id:'tmeHoraMax',
                                                    x:140,
                                                    y:35,
                                                    width:110,
                                                    hideLabel:true,
                                                    format:'H:i'
                                                }
                                            )  

	var comboTipoDoc=crearComboTipoDocumento();
    var comboSiNo=crearComboSiNo();
    comboSiNo.setValue('0');
    
	comboSiNo.setPosition(140,35);

	var grupoArchivo=new Ext.form.FieldSet	(
                                                    {
                                                        id:'grupoArchivo',
                                                        x:10,
                                                        y:80,
                                                        width:375,
                                                        height:100,
                                                        hidden:true,
                                                        layout: 'absolute',
                                                        title:'<?php echo $etj["lblConfControl"]?>',
                                                        items:	[
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:10,
                                                                                                width:200,
                                                                                                text:'<?php echo $etj["lblTipoArchivo"]?>:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    comboTipoDoc,
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                width:200,
                                                                                                text:'<?php echo $etj["lblTamanoArchivo"]?>:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    txtTamMax
                                                                ]
                                                    }
                                                )
                                                
    var grupoHora=new Ext.form.FieldSet	(
                                                    {
                                                        id:'grupoHora',
                                                        x:10,
                                                        y:80,
                                                        width:400,
                                                        height:155,
                                                        hidden:true,
                                                        layout: 'absolute',
                                                        title:'<?php echo $etj["lblConfControl"]?>',
                                                        items:	[
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:10,
                                                                                                width:200,
                                                                                                text:'<?php echo $etj["lblHoraMin"]?>:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    tmeHoraMin,
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                width:200,
                                                                                                text:'<?php echo $etj["lblHoraMax"]?>:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    tmeHoraMax,
                                                                   
                                                                    {
                                                                    	xtype:'label',
                                                                        x:5,
                                                                        y:65,
                                                                        html:'<?php echo $etj["lblIntervalo"]?>:'
                                                                    },
                                                                    {
                                                                    	id:'tmeIntervalo',
                                                                    	xtype:'numberfield',
                                                                        x:140,
                                                                        y:60,
                                                                        value:15,
                                                                        width:60
                                                                        
                                                                    },
                                                                    {
                                                                    	x:205,
                                                                        y:65,
                                                                    	xtype:'label',
                                                                        text:'<?php echo $etj["lblMinutos"]?>'
                                                                    }
                                                                    ,
                                                                     new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:93,
                                                                                                html:'<font color="brown"><?php echo $etj["lblNoHora"]?></font>'
                                                                                                
                                                                                            }
                                                                                        )
                                                                    

                                                                ]
                                                    }
                                                ) 

	var grupoFecha=new Ext.form.FieldSet	(
                                                    {
                                                        id:'grupoFecha',
                                                        x:10,
                                                        y:80,
                                                        width:385,
                                                        height:115,
                                                        hidden:true,
                                                        layout: 'absolute',
                                                        title:'<?php echo $etj["lblConfControl"]?>',
                                                        items:	[
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:10,
                                                                                                width:200,
                                                                                                text:'<?php echo $etj["lblFechaMin"]?>:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    dteFechaMin,
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                width:200,
                                                                                                text:'<?php echo $etj["lblFechaMax"]?>:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    dteFechaMax,
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:65,
                                                                                                html:'<font color="brown"><?php echo $etj["lblNoFecha"]?></font>'
                                                                                                
                                                                                            }
                                                                                        )

                                                                ]
                                                    }
                                                ) 
                                                                                                   
                
    var grupoTextoLargo =new Ext.form.FieldSet	(
                                                    {
                                                        id:'grupoTextoLargo',
                                                        x:10,
                                                        y:80,
                                                        width:375,
                                                        height:100,
                                                        hidden:true,
                                                        layout: 'absolute',
                                                        title:'<?php echo $etj["lblConfControl"]?>',
                                                        items:	[
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:10,
                                                                                                width:200,
                                                                                                text:'<?php echo $etj["lblAncho"]?>:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    txtAnchoTL,
                                                                    new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                width:200,
                                                                                                text:'<?php echo $etj["lblAlto"]?>:'
                                                                                                
                                                                                            }
                                                                                        ),
                                                                    txtAltoTL
                                                                    
                                                                ]
                                                    }
                                                )        

    var btnSiguiente=	new Ext.Button	( 
                                            {
                                                text: '<?php echo $etj["lblFinalizar"]?>',
                                                minWidth:80,
                                                handler:function()
                                                        {
                                                           
                                                            var txtNombreCampo=Ext.getCmp('txtNombreCampo').getValue();
                                                            if(txtNombreCampo=='')
                                                            {
                                                                function resp()
                                                                {
                                                                    Ext.getCmp('txtNombreCampo').focus(false,10);
                                                                }
                                                                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblValInv"] ?>',resp);
                                                                return;
                                                            }
                                                            
                                                            switch(tipoElemento)
                                                            {
                                                                case 12:	//Grupo Archivo
                                                                    var cmbTipoDoc=Ext.getCmp('idCmbTipoDocumento');
                                                                    var txtTamMax=Ext.getCmp('txtTamMax');
                                                                    var tipoDoc=cmbTipoDoc.getValue();
                                                                    var tamMax=txtTamMax.getValue();
                                                                
                                                                    if(tipoDoc=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            cmbTipoDoc.focus(false,10);
                                                                        }
                                                                        Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblDebeElegir"] ?>',resp);
                                                                        return;
                                                                    }
                                                                    if(tamMax=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtTamMax.focus(false,10);
                                                                        }
                                                                        Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblValInv"] ?>',resp);;
                                                                        return;
                                                                    }
                                                                
                                                                    objConfCampo='{"tipoDoc":"'+tipoDoc+'","tamMax":"'+tamMax+'"}'	
                                                                break;
                                                                case 8:	//Grupo Fecha
                                                                    var dteFechaMin=Ext.getCmp('dteFechaMin');
                                                                    var dteFechaMax=Ext.getCmp('dteFechaMax');
                                                                    if(dteFechaMin.getValue()!='')
                                                                    {
                                                                        var f=new  Date(dteFechaMin.getValue());
                                                                        var fechaMin=f.format('d/m/Y');
                                                                    }
                                                                    else
                                                                        var fechaMin=''; 
                                                                    if(dteFechaMax.getValue()!='')
                                                                    {
                                                                        var f=new  Date(dteFechaMax.getValue());
                                                                        var fechaMax=f.format('d/m/Y');
                                                                    }
                                                                    else
                                                                        var fechaMax='';
                                                                    objConfCampo='{"fechaMin":"'+fechaMin+'","fechaMax":"'+fechaMax+'"}';		
                                                                break;                                                                    
                                                                case 9: //Grupo texto largo
                                                                case 10:
                                                                    var txtAltoTL=Ext.getCmp('txtAltoTL');
                                                                    var txtAnchoTL=Ext.getCmp('txtAnchoTL');
                                                                    var altoTL=txtAltoTL.getValue();
                                                                    var anchoTL=txtAnchoTL.getValue();
                                                                    if(anchoTL=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtAnchoTL.focus(false,10);
                                                                        }
                                                                        Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblValInv"] ?>',resp);;
                                                                        return;
                                                                    }
                                                                    if(altoTL=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            altoTL.focus(false,10);
                                                                        }
                                                                        Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblValInv"] ?>',resp);;
                                                                        return;
                                                                    }
                                                                    
                                                                
                                                                    objConfCampo='{"ancho":"'+anchoTL+'","alto":"'+altoTL+'"}'
                                                                
                                                                break;	
                                                                case 21:	//Grupo Fecha
                                                                    var tmeHoraMin=Ext.getCmp('tmeHoraMin');
                                                                    var tmeHoraMax=Ext.getCmp('tmeHoraMax');
                                                                    if(tmeHoraMin.getValue()!='')
                                                                    {
                                                                        
                                                                        var horaMin=tmeHoraMin.getValue();
                                                                    }
                                                                    else
                                                                        var horaMin=''; 
                                                                    if(tmeHoraMax.getValue()!='')
                                                                    {
                                                                       
                                                                        var horaMax=tmeHoraMax.getValue();
                                                                    }
                                                                    else
                                                                        var horaMax='';
                                                                        
                                                                    var tmeIntervalo=Ext.getCmp('tmeIntervalo');    
                                                                    if(tmeIntervalo.getValue()=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            tmeIntervalo.focus(false,10);
                                                                        }
                                                                        Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblValInt"] ?>',resp);
                                                                        return;
                                                                    }
                                                                    else
	                                                                    intervalo=tmeIntervalo.getValue();
                                                                        
                                                                    objConfCampo='{"horaMin":"'+horaMin+'","horaMax":"'+horaMax+'","intervalo":"'+intervalo+'"}';	
                                                            	break;
                                                            }
                                                            
                                                            var objFinal='{"idFormulario":"'+idFormulario+'","tipoElemento":"'+tipoElemento+'","confCampo":'+objConfCampo+',"nomCampo":"'+txtNombreCampo+'","posX":"'+mitadX+'","posY":"'+mitadY+'","obligatorio":"'+comboSiNo.getValue()+'","pregunta":null}';
                                                           	//alert(objFinal);
                                                            guardarPregunta(objFinal,ventanaPregAbiertas);
                                                        }
                                            }
                                        );
                        
    var txtNombreCampo=new Ext.form.TextField	(
    												{
                                                    	id:'txtNombreCampo',
                                                        x:140,
                                                        y:5,
                                                        width:160,
                                                        hideLabel:true,
                                                        maskRe:/^[a-zA-Z0-9]$/
                                                       
                                                    }
    											)
    
    var form = new Ext.form.FormPanel	(	
                                            {
                                                
                                                baseCls: 'x-plain',
                                                layout:'absolute',
                                                defaultType: 'numberfield',
                                                items: 	[
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:10,
                                                                                        text:'<?php echo $etj["lblNomCampo"]?>:'
                                                                                    }
                                                                                ) ,
	                                                        txtNombreCampo,
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:40,
                                                                                        text:'<?php echo $etj["lblCampoObl"]?>:'
                                                                                    }
                                                                                ) , 
                                                            comboSiNo,
                                                            grupoArchivo,
                                                            grupoFecha,
                                                            grupoTextoLargo,
                                                            grupoHora
                                                        ]
                                            }
                                        );
    
    var tituloVentana;
    
    switch(tipoElemento)
    {
        case 12: //Grupo Archivo
            Ext.getCmp('grupoFecha').hide();
            Ext.getCmp('grupoTextoLargo').hide();
            Ext.getCmp('grupoArchivo').show();
            Ext.getCmp('grupoHora').hide();
            tituloVentana='<?php echo $etj["lblInsArchivo"]?>';
        break;
        case 8: //Grupo Fecha
            Ext.getCmp('grupoArchivo').hide();
            Ext.getCmp('grupoTextoLargo').hide();
            Ext.getCmp('grupoHora').hide();
            Ext.getCmp('grupoFecha').show();
            
            tituloVentana='<?php echo $etj["lblInsFecha"]?>';
        break;
        case 9: //Grupo texto largo
            ancho=400;
            alto=250;
            tituloVentana='<?php echo $etj["lblInsTextoL"]?>';
        case 10:
            if(tipoElemento==10)
            {
                ancho=600;
                alto=400;
                tituloVentana='<?php echo $etj["lblInsTextoE"]?>';
            }
            Ext.getCmp('grupoArchivo').hide();
            Ext.getCmp('grupoFecha').hide();
            Ext.getCmp('grupoHora').hide();
            Ext.getCmp('txtAnchoTL').setValue(ancho);
            Ext.getCmp('txtAltoTL').setValue(alto);
            Ext.getCmp('grupoTextoLargo').show();
       	break;
        case 21:
            Ext.getCmp('grupoArchivo').hide();
            Ext.getCmp('grupoFecha').hide();
            //Ext.getCmp('txtAnchoTL').setValue(ancho);
            //Ext.getCmp('txtAltoTL').setValue(alto);
            Ext.getCmp('grupoTextoLargo').hide();
            Ext.getCmp('grupoHora').show();
                                             
        break;
    }
    
    ventanaPregAbiertas = new Ext.Window	(
                                                {
                                                    title: tituloVentana,
                                                    width: 440,
                                                    height:350,
                                                    minWidth: 280,
                                                    minHeight: 100,
                                                    layout: 'fit',
                                                    plain:true,
                                                    bodyStyle:'padding:5px;',
                                                    buttonAlign:'center',
                                                    items: form,
                                                    modal:true,
                                                    listeners : {
                                                                    show : {
                                                                                buffer : 10,
                                                                                fn : function() 
                                                                                {
                                                                                    //txtLongitud.focus(true,10);
                                                                                }
                                                                            }
                                                                },
                                                    buttons:	[
                                                                    
                                                                    btnSiguiente,
                                                                    {
                                                                        text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                                        minWidth:80,
                                                                        handler:function()
                                                                                {
                                                                                    ventanaPregAbiertas.close();
                                                                                }
                                                                    }
                                                                ]
                                                }
                                            );
	
    
    
	ventanaPregAbiertas.show();
    txtNombreCampo.focus(false,10);
}

function mostrarVEntCerrada(tipoElemento)
{
	
	idFormulario=gE('idFormulario').value;
	
    var dsOpciones= [<?php echo "[".$filaDefault."]" ?>];
    alOpciones=		new Ext.data.SimpleStore(
                                                {
                                                    fields:	[
                                                                <?php 
                                                                    echo $campos;
                                                                ?>
                                                            ]
                                                }
                                            );
    
    alOpciones.loadData(dsOpciones);
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'<?php echo $etj["titValorOp"]?>',
                                                            width:100,
                                                            dataIndex:'valorOpt',
                                                            editor: new Ext.form.TextField   (
                                                                                                    {
                                                                                                      
                                                                                                       style: 'text-align:left'
                                                                                                    }
                                                                                                )
                                                        }
                                                        ,
                                                        <?php 
                                                            echo $columnas;
                                                        ?>
                                                    ]
                                                );
    
    var txtNombreCampo=new Ext.form.TextField	(
                                                {
                                                    id:'txtNombreCampo',
                                                    x:140,
                                                    y:5,
                                                    width:160,
                                                    hideLabel:true,
                                                    maskRe:/^[a-zA-Z0-9]$/
                                                   
                                                }
                                            )
    
    tblOpciones=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOpcionesManuales',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 2,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:<?php echo $ancho+35 ?>,
                                                            title:'<?php echo $etj["titIngOpt"]?>:',
                                                            tbar: [
                                                                    {
                                                                        text: '<?php echo $etj["lblNuevaOp"] ?>',
                                                                        handler : function()
                                                                                  {
                                                                                        var r=new RegistroOpciones	(
                                                                                                                        {
                                                                                                                            <?php echo $camposOpciones?>
                                                                                                                        }
                                                                                                                    ) 	
                                                                                        alOpciones.add(r);	
                                                                                        tblOpciones.startEditing(alOpciones.getCount()-1,1);
                                                                                  }
                                                                    }
                                                                    ,
                                                                    {
                                                                        text:'<?php echo $etj["lblDelOp"] ?>',
                                                                        handler:function()
                                                                                {
                                                                                    var fila=tblOpciones.getSelectionModel().getSelectedCell();
                                                                                    if(fila!=null)
                                                                                    {
                                                                                        var posFila=alOpciones.getAt(fila[0]);
                                                                                        function funcConfirmDel(btn)
                                                                                        {
                                                                                            if(btn=="yes")
                                                                                            {
                                                                                                alOpciones.remove(posFila);
                                                                                            }
                                                                                        }
                                                                                        Ext.Msg.confirm('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgConfirmDel"]?>',funcConfirmDel);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["msgDebeSelElem"]?>');
                                                                                    }
                                                                                    
                                                                                }  
                                                                    }
                                                                    
                                                                  ]
                                                        }
                                                    );
    
    function funcEdicion(e)
    {
        if(e.field=='valorOpt')
        {
            var res=obtenerPosFila(e.grid.getStore(),'valorOpt',e.value);
            if((res!='-1')&&(e.row!=res))
            {
                function funcOK()
                {
                    e.record.set('valorOpt',e.originalValue);
                    e.grid.getView().refresh();
                    e.grid.startEditing(e.row,e.column);
                }
                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgErrorOpcionRep"]?>',funcOK);
            }
        }
    }
    tblOpciones.on('afteredit',funcEdicion);
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:65,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
    var comboSiNo=crearComboSiNo();
    comboSiNo.setValue('0');
	comboSiNo.setPosition(140,35);
    
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        new Ext.form.Label	(
                                                                                {
                                                                                    x:5,
                                                                                    y:10,
                                                                                    text:'<?php echo $etj["lblNomCampo"]?>:'
                                                                                }
                                                                            ) ,
                                                        txtNombreCampo,
                                                        new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:40,
                                                                                        text:'<?php echo $etj["lblCampoObl"]?>:'
                                                                                    }
                                                                                ) , 
                                                        comboSiNo,
                                                        panelGrid
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: '<?php echo $etj["lblFinalizar"] ?>',
                                        minWidth:80,
                                        id:'btnFinalizarPCerradas',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        if(btnSiguiente.getText()!='<?php echo $etj["lblFinalizar"]?>')
                                                                        {
                                                                            var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
                                                                            if(resul)
                                                                                mostrarVAyuda(ventanaPregCerradas,tblOpciones);
                                                                        }
                                                                        else
                                                                        {
                                                                        
                                                                            var txtNombreCampo=Ext.getCmp('txtNombreCampo').getValue();
                                                                            if(txtNombreCampo=='')
                                                                            {
                                                                                function resp()
                                                                                {
                                                                                    Ext.getCmp('txtNombreCampo').focus(false,10);
                                                                                }
                                                                                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblValInv"] ?>',resp);
                                                                                return;
                                                                            }
                                                                            
                                                                            
                                                                            var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
                                                                            
                                                                            if(resul)
                                                                            {
                                                                                var opciones=obtenerValoresOpcionesManuales();
                                                                                if(tipoElemento==undefined)
                                                                                	var objFinal='{"idFormulario":"'+idFormulario+'","nomCampo":"'+txtNombreCampo+'","pregunta":null,"tipoElemento":"2","posX":"'+mitadX+'","posY":"'+mitadY+'","obligatorio":"'+comboSiNo.getValue()+'","opciones":'+opciones+'}';
                                                                               	else
                                                                               		var objFinal='{"idFormulario":"'+idFormulario+'","nomCampo":"'+txtNombreCampo+'","pregunta":null,"tipoElemento":"'+tipoElemento+'","posX":"'+mitadX+'","posY":"'+mitadY+'","obligatorio":"'+comboSiNo.getValue()+'","opciones":'+opciones+'}'; 
                                                                                ventanaOrigenDatosSel.close();
                                                                                guardarPregunta(objFinal,ventanaPregCerradas);
                                                                            }
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaPregCerradas = new Ext.Window(
                                            {
                                                title: '<?php echo $etj["titOpcionesP"]?>',
                                                width: <?php echo ($ancho+65) ?> ,
                                                height:470,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                                            txtNombreCampo.focus();
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                    	ventanaOrigenDatosSel.close();
                                                                        ventanaPregCerradas.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	
	
	ventanaPregCerradas.show();
}

function validarOpciones(dSet,tblEditor)
{
	var res=validarCampoNoVacio(tblOpciones.getStore(),'valorOpt');
	if(res!='-1')
	{
		function funcClickOk()
		{
			tblOpciones.startEditing(res-1,1);
			return false
		}
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgErrorCeldaVacia"]?>',funcClickOk);
	}
	else
	{
		var cm=tblEditor.getColumnModel();
		var idIdioma=gE('hLeng').value;
		var nomColumn='idioma_'+idIdioma;
		var posCol=cm.findColumnIndex(nomColumn);
		var x;
		var res=validarCampoNoVacio(dSet,nomColumn);
		if(res!='-1')
		{
			function funcClickOk()
			{
				tblEditor.startEditing(res-1,posCol);
				return false;
			}
			Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgErrCeldaIdiVac"]?>',funcClickOk);	
			
		}
		else
		{
			var colName='';
            var numColums=cm.getColumnCount();
           
            for(x=2;x<numColums;x++)
            {
                colName=cm.getDataIndex(x);
                if(colName!=nomColumn)
                {
                    res=validarCampoNoVacio(dSet,colName);
                    if(res!='-1')
                    {
                        function funcConfirmacion(btn)
                        {
                            if(btn=='yes')
                            {
                                for(x=2;x<cm.getColumnCount();x++)
                                {
                                    colName=cm.getDataIndex(x);
                                    if(colName!=nomColumn)
                                        rellenarValoresVaciosColumna(dSet,colName,nomColumn);
                                }
                                Ext.getCmp('btnFinalizarPCerradas').fireEvent('click');
                            }
                            return false;
                        }
                        Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>', '<?php echo $etj["msgErrorOpciones"] ?>', funcConfirmacion);
                    }
                    else
                        return true;
                }
            }
            return true;
        	
		}
	}
}

function obtenerValoresColumnasRegistro(cm,reg)
{
	var columnas='';
	var idLeng='';
	var tColum='';
	var x;
	for(x=2;x<cm.getColumnCount();x++)
	{
		tColumn=cm.getDataIndex(x);
		idLeng=cm.getDataIndex(x).split('_')[1];
		if(columnas=='')
			columnas='{"idLeng":"'+idLeng+'","texto":"'+reg.get(tColumn)+'"}';
		else
			columnas+=',{"idLeng":"'+idLeng+'","texto":"'+reg.get(tColumn)+'"}';
	}
	return columnas;
}

function mostrarVentanaPreguntasCerradas()
{

	idOrigenD=1;
	var opcion1=new Ext.form.Radio	(
                                            {
                                                id:'opcion1',
                                                name:'origenD',
                                                value:1,
                                                boxLabel:'<?php echo $etj["lblOrigen1"]?>',
                                                x:40,
                                                y:45,
                                                
                                                checked:true
                                            }
                                        );
                                        
	opcion1.on('check',opcionClick);                                        
	var opcion2= new Ext.form.Radio	(
                                            {
                                                id:'opcion2',
                                                name:'origenD',
                                                value:2,
                                                boxLabel:'<?php echo $etj["lblOrigen2"]?>',
                                                x:40,
                                                y:75
                                            }
                                        );
	opcion2.on('check',opcionClick);                                            
	var opcion3=new Ext.form.Radio	(
                                            {
                                                id:'opcion3',
                                                name:'origenD',
                                                value:3,
                                                boxLabel:'<?php echo $etj["lblOrigen3"]?>',
                                                x:40,
                                                y:105
                                            }
                                        );   
	opcion3.on('check',opcionClick);   
    
    var opcion4=new Ext.form.Radio	(
                                            {
                                                id:'opcion4',
                                                name:'origenD',
                                                value:4,
                                                boxLabel:'<?php echo $etj["lblOrigen3"]?> (Autocompletar)',
                                                x:40,
                                                y:135
                                            }
                                        );   
	opcion4.on('check',opcionClick);                                           
    
	var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: 	[
                                                    
                                                    			{
                                                                	x:10,
                                                                    y:10,
                                                                	xtype:'label',
                                                                    text:'<?php echo $etj["lblSeleccioneOD"]?>:'
                                                                },
                                                    			opcion1,
                                                                opcion2,
                                                                opcion3,
                                                                opcion4
                                                    			
                                                    		]
												}
											);
		
	ventanaOrigenDatosSel = new Ext.Window(
											{
												title: '<?php echo $etj["lblOrigenD"]?>',
												width: 450,
												height:270,
												minWidth: 300,
												minHeight: 100,
												layout: 'fit',
												plain:true,
												modal:true,
												bodyStyle:'padding:5px;',
												buttonAlign:'center',
												items: form,
												buttons:	[
																{
																	id:'btnAceptar',
																	text: '<?php echo $etj["lblSiguiente"] ?> >>',
																	listeners:	{
																					click:function()
																						{
																							ventanaOrigenDatosSel.hide();
                                                                                            switch(idOrigenD)
                                                                                            {
                                                                                            	case 1:
                                                                                                	mostrarVEntCerrada();
                                                                                                break;
                                                                                                case 2:
                                                                                                	mostrarVIntervalo();
                                                                                                break;
                                                                                                case 3:
                                                                                                	mostrarVentanaSelTabla();
                                                                                                break;
                                                                                                case 4:
                                                                                                	mostrarVentanaSelTabla(null,true);
                                                                                                break;
                                                                                           
                                                                                            }
																							
																							
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventanaOrigenDatosSel.close();
																			}
																}
															]
											}
										);

		ventanaOrigenDatosSel.show();
}

function mostrarVentanaPreguntasOpciones()
{

	idOrigenD=14;
	var opcion1=new Ext.form.Radio	(
                                            {
                                                id:'opcion1',
                                                name:'origenD',
                                                value:14,
                                                boxLabel:'<?php echo $etj["lblOrigen1"]?>',
                                                x:40,
                                                y:45,
                                                checked:true
                                            }
                                        );
                                        
	opcion1.on('check',opcionClick);                                        
	var opcion2= new Ext.form.Radio	(
                                            {
                                                id:'opcion2',
                                                name:'origenD',
                                                value:15,
                                                boxLabel:'<?php echo $etj["lblOrigen2"]?>',
                                                x:40,
                                                y:75
                                            }
                                        );
	opcion2.on('check',opcionClick);                                            
	var opcion3=new Ext.form.Radio	(
                                            {
                                                id:'opcion3',
                                                name:'origenD',
                                                value:16,
                                                boxLabel:'<?php echo $etj["lblOrigen3"]?>',
                                                x:40,
                                                y:105
                                            }
                                        );   
	opcion3.on('check',opcionClick);                                            
    
	var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: 	[
                                                    
                                                    			{
                                                                	x:10,
                                                                    y:10,
                                                                	xtype:'label',
                                                                    text:'<?php echo $etj["lblSeleccioneOD"]?>:'
                                                                },
                                                    			opcion1,
                                                                opcion2,
                                                                opcion3
                                                    			
                                                    		]
												}
											);
		
	ventanaOrigenDatosSel = new Ext.Window(
											{
												title: '<?php echo $etj["lblOrigenD"]?>',
												width: 450,
												height:250,
												minWidth: 300,
												minHeight: 100,
												layout: 'fit',
												plain:true,
												modal:true,
												bodyStyle:'padding:5px;',
												buttonAlign:'center',
												items: form,
												buttons:	[
																{
																	id:'btnAceptar',
																	text: '<?php echo $etj["lblSiguiente"] ?> >>',
																	listeners:	{
																					click:function()
																						{
																							ventanaOrigenDatosSel.hide();
                                                                                            switch(idOrigenD)
                                                                                            {
                                                                                            	case 14:
                                                                                                	
                                                                                                	mostrarVEntCerrada(idOrigenD);
                                                                                                break;
                                                                                                case 15:
                                                                                                	mostrarVIntervalo(idOrigenD);
                                                                                                break;
                                                                                                case 16:
                                                                                                	mostrarVentanaSelTabla(idOrigenD);
                                                                                                break;
                                                                                           
                                                                                            }
																							
																							
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventanaOrigenDatosSel.close();
																			}
																}
															]
											}
										);

		ventanaOrigenDatosSel.show();
}

function mostrarVentanaPreguntasOpcionesMultiples()
{

	idOrigenD=17;
	var opcion1=new Ext.form.Radio	(
                                            {
                                                id:'opcion1',
                                                name:'origenD',
                                                value:17,
                                                boxLabel:'<?php echo $etj["lblOrigen1"]?>',
                                                x:40,
                                                y:45,
                                                checked:true
                                            }
                                        );
                                        
	opcion1.on('check',opcionClick);                                        
	var opcion2= new Ext.form.Radio	(
                                            {
                                                id:'opcion2',
                                                name:'origenD',
                                                value:18,
                                                boxLabel:'<?php echo $etj["lblOrigen2"]?>',
                                                x:40,
                                                y:75
                                            }
                                        );
	opcion2.on('check',opcionClick);                                            
	var opcion3=new Ext.form.Radio	(
                                            {
                                                id:'opcion3',
                                                name:'origenD',
                                                value:19,
                                                boxLabel:'<?php echo $etj["lblOrigen3"]?>',
                                                x:40,
                                                y:105
                                            }
                                        );   
	opcion3.on('check',opcionClick);     
    
	var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: 	[
                                                    
                                                    			{
                                                                	x:10,
                                                                    y:10,
                                                                	xtype:'label',
                                                                    text:'<?php echo $etj["lblSeleccioneOD"]?>:'
                                                                },
                                                    			opcion1,
                                                                opcion2,
                                                                opcion3
                                                    			
                                                    		]
												}
											);
		
	ventanaOrigenDatosSel = new Ext.Window(
											{
												title: '<?php echo $etj["lblOrigenD"]?>',
												width: 450,
												height:250,
												minWidth: 300,
												minHeight: 100,
												layout: 'fit',
												plain:true,
												modal:true,
												bodyStyle:'padding:5px;',
												buttonAlign:'center',
												items: form,
												buttons:	[
																{
																	id:'btnAceptar',
																	text: '<?php echo $etj["lblSiguiente"] ?> >>',
																	listeners:	{
																					click:function()
																						{
																							ventanaOrigenDatosSel.hide();
                                                                                            switch(idOrigenD)
                                                                                            {
                                                                                            	case 17:
                                                                                                	mostrarVEntCerrada(idOrigenD);
                                                                                                break;
                                                                                                case 18:
                                                                                                	mostrarVIntervalo(idOrigenD);
                                                                                                break;
                                                                                                case 19:
                                                                                                	mostrarVentanaSelTabla(idOrigenD);
                                                                                                break;
                                                                                           
                                                                                            }
																							
																							
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventanaOrigenDatosSel.close();
																			}
																}
															]
											}
										);

		ventanaOrigenDatosSel.show();
}

function mostrarVIntervalo(tipoElemento)
{
	var txtNombreCampo=new Ext.form.TextField	(
                                                    {
                                                        id:'txtNombreCampo',
                                                        x:140,
                                                        y:5,
                                                        width:160,
                                                        hideLabel:true,
                                                        maskRe:/^[a-zA-Z0-9]$/
                                                       
                                                    }
                                                )
	
	var comboSiNo=crearComboSiNo();
    comboSiNo.setValue('0');
	comboSiNo.setPosition(140,35);

	var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: 	[
                                                    			new Ext.form.Label	(
                                                                                {
                                                                                    x:5,
                                                                                    y:10,
                                                                                    text:'<?php echo $etj["lblNomCampo"]?>:'
                                                                                }
                                                                            ) ,
                                                                txtNombreCampo,
                                                                new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                text:'<?php echo $etj["lblCampoObl"]?>:'
                                                                                            }
                                                                                        ) , 
                                                                comboSiNo,
                                                    
                                                    			{
                                                                	x:5,
                                                                    y:70,
                                                                	xtype:'label',
                                                                    text:'<?php echo $etj["lblIntInicio"]?>:'
                                                                },
                                                                {
                                                                	x:140,
                                                                    y:65,
                                                                    xtype:'numberfield',
                                                                    id:'txtInicio',
                                                                    allowDecimals:false
                                                                },
                                                                {
                                                                	x:5,
                                                                    y:100,
                                                                	xtype:'label',
                                                                    text:'<?php echo $etj["lblIntFin"]?>:'
                                                                },
                                                                {
                                                                	x:140,
                                                                    y:95,
                                                                    xtype:'numberfield',
                                                                    id:'txtFin',
                                                                    allowDecimals:false
                                                                },
                                                                {
                                                                	x:5,
                                                                    y:130,
                                                                	xtype:'label',
                                                                    text:'<?php echo $etj["lblIncremento"]?>:'
                                                                },
                                                                {
                                                                	x:187,
                                                                    y:125,
                                                                    xtype:'numberfield',
                                                                    id:'txtIncremento',
                                                                    value:'1',
                                                                    width:80,
                                                                    allowDecimals:false
                                                                    
                                                                }
                                                    			
                                                    			
                                                    		]
												}
											);
		
	ventanaIntervalo = new Ext.Window(
											{
												title: '<?php echo $etj["lblVentanaI"]?>',
												width: 340,
												height:260,
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
																			txtNombreCampo.focus();
																		}
																	}
														},
												buttons:	[
																{
																	id:'btnAceptar',
																	text: '<?php echo $etj["lblFinalizar"] ?>',
																	listeners:	{
																					click:function()
																						{
																							
																							var inicio=Ext.getCmp('txtInicio').getValue();
																						    var final=Ext.getCmp('txtFin').getValue();
                                                                                            var incremento=Ext.getCmp('txtIncremento').getValue();
                                                                                            var txtNombreCampo=Ext.getCmp('txtNombreCampo').getValue();
                                                                                            if(txtNombreCampo=='')
                                                                                            {
                                                                                                function resp()
                                                                                                {
                                                                                                    Ext.getCmp('txtNombreCampo').focus(false,10);
                                                                                                }
                                                                                                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblValInv"] ?>',resp);
                                                                                                return;
                                                                                            }
                                                                                            if(!esEntero(inicio))
                                                                                            {
                                                                                            	function resp()
                                                                                                {
                                                                                                	Ext.getCmp('txtInicio').focus();
                                                                                                }
                                                                                                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblValInv"] ?>',resp);
                                                                                            }
                                                                                            if(!esEntero(final))
                                                                                            {
                                                                                            	function resp()
                                                                                                {
                                                                                                	Ext.getCmp('txtFin').focus();
                                                                                                }
                                                                                                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblValInv"] ?>',resp);
                                                                                            }
                                                                                            if(!esEntero(incremento))
                                                                                            {
                                                                                            	function resp()
                                                                                                {
                                                                                                	Ext.getCmp('txtIncremento').focus();
                                                                                                }
                                                                                                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblValInv"] ?>',resp);
                                                                                            }
                                                                                            var objIntervalo='{"inicio":"'+inicio+'","fin":"'+final+'","intervalo":"'+incremento+'"}';
                                                                                            
                                                                                            if(tipoElemento==undefined)
	                                                                                            var objFinal='{"idFormulario":"'+idFormulario+'","pregunta":null,"tipoElemento":"3","objInt":'+objIntervalo+',"posX":"'+mitadX+'","posY":"'+mitadY+'","nomCampo":"'+txtNombreCampo+'","obligatorio":"'+comboSiNo.getValue()+'"}';
                                                                                            else
                                                                                            	var objFinal='{"idFormulario":"'+idFormulario+'","pregunta":null,"tipoElemento":"'+tipoElemento+'","objInt":'+objIntervalo+',"posX":"'+mitadX+'","posY":"'+mitadY+'","nomCampo":"'+txtNombreCampo+'","obligatorio":"'+comboSiNo.getValue()+'"}';
                                                                                            ventanaOrigenDatosSel.close();
                                                                                            guardarPregunta(objFinal,ventanaIntervalo);
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
                                                                            	ventanaOrigenDatosSel.close();
																				ventanaIntervalo.close();
																			}
																}
															]
											}
										);

		ventanaIntervalo.show();
}

function opcionClick(combo,checado)
{
	if(checado)
    {
    	idOrigenD=combo.value;
    }
}

function obtenerValoresOpcionesManuales()
{
	var opciones='';
    var cadTemp='';
    
    var tblOpciones=Ext.getCmp('gridOpcionesManuales');
    var cm=tblOpciones.getColumnModel();
    var ct=tblOpciones.getStore().getCount();
    var reg;
    var x;
    
    for(x=0;x<ct;x++)
    {
        reg=tblOpciones.getStore().getAt(x);
        var valColumnas=obtenerValoresColumnasRegistro(cm,reg);
        cadTemp='{"vOpcion":"'+reg.get('valorOpt')+'",'+
                '"columnas":['+valColumnas+']'+
                '}';
        if(opciones=='')
            opciones=cadTemp;
        else
            opciones+=','+cadTemp;
    }
    return '['+opciones+']';
}

function obtenerValoresVentanaIntervalo()
{
	var inicio=Ext.getCmp('txtInicio').getValue();
    var final=Ext.getCmp('txtFin').getValue();
	var obj='{"inicio":"'+inicio+'","fin":"'+final+'"}';
    return obj;
}

function crearControl(datos,idElemen,arrElementosSel)
{
	var control;
	var objDatos=eval('['+datos+']')[0];
    var idIdioma=gE('hIdidioma').value;
	var pregunta=new Array();
    var contPregunta;
    var clase='';
    tipoElemento=objDatos.tipoElemento;
    var arrPregunta=objDatos.pregunta;
    if(tipoElemento!='1')
	    var nControl=objDatos.nomCampo;     
    if(tipoElemento==1)
    	clase='letraFicha';
    else
    	clase='';
    idElemento=idElemen;
	var arrContenido=new Array();
    arrContenido[0]=pregunta;
    var val='';
    var asteriscoRojo=null;
    var nomControl;
    if((objDatos.obligatorio=='1')||(objDatos.obligatorio==1))
    {
		val='obl';
        asteriscoRojo=document.createElement('font');
        asteriscoRojo.setAttribute('color','red');
        asteriscoRojo.appendChild(document.createTextNode('*'));
        
	}
	
    switch(tipoElemento)
    {
    	case '1'://Etiqueta
        	nomControl='_lbl'+idElemen;
        	var x;
        	for(x=0;x<arrPregunta.length;x++)
            {
                if(arrPregunta[x].idIdioma=idIdioma)
                {
	                pregunta[x]=document.createElement('span');
                    pregunta[x].id=nomControl;
                    pregunta[x].name=nomControl;
                    pregunta[x].setAttribute('class','letraFichaRespuesta');
                    pregunta[x].appendChild(document.createTextNode(dv(arrPregunta[x].etiqueta)));
                    break;
                }
            }
            
            var etiquetas=objDatos.pregunta;
            var camposH='';
            var ct=1;
            for(x=0;x<etiquetas.length;x++)
            {
            	pregunta[ct]=document.createElement('input');
                pregunta[ct].type='hidden';
                pregunta[ct].value=dv(etiquetas[0].etiqueta);
                pregunta[ct].id='td_'+idElemen+'_'+etiquetas[0].idIdioma;
                pregunta[ct].name='td_'+idElemen+'_'+etiquetas[0].idIdioma;
            	ct++;
            }
            arrContenido[0]=pregunta;
        break;
        case '2'://pregunta cerrada-Opciones Manuales
        	nomControl='_'+nControl+'vch';
        	x=0;
            var arrOpc=objDatos.opciones;
            var valorOpt;
            var arrOpciones='';
            var etiquetaOpt='';
            var y;
            
            var select=document.createElement('select');
            select.setAttribute('val',val);
            select.id=nomControl;
            select.name=nomControl;
            var opcion;
            var ct=0;
            opcion=document.createElement('option');
            opcion.value='-1';
            opcion.text='<?php echo $etj["lblSeleccione"] ?>';
            select.options[ct]=opcion;
            ct++;
            for(x=0;x<arrOpc.length;x++)
            {	
                valorOpt=arrOpc[x].vOpcion;
                for(y=0;y<arrOpc[x].columnas.length;y++)
                {	
                    if(arrOpc[x].columnas[y].idLeng==idIdioma)
                    {
                        etiquetaOpt=arrOpc[x].columnas[y].texto;
                        opcion=document.createElement('option');
                        opcion.value=valorOpt;
                        opcion.text=etiquetaOpt;
                        select.options[ct]=opcion;
                        ct++;
                    }
                }
               
            }
            var arr=new Array();
	        arr[0]=select;
            arrContenido[0]=arr;
        break;
        case '3': //pregunta cerrada-Opciones intervalo
        	nomControl='_'+nControl+'vch';
            var arrOpc=eval(arrElementosSel);
            
            var select=document.createElement('select');
            select.setAttribute('val',val);
            select.id=nomControl;
            select.name=nomControl;
            var opcion;
            var ct=0;
            var etiquetaOpt;
            opcion=document.createElement('option');
            opcion.value='-1';
            opcion.text='<?php echo $etj["lblSeleccione"] ?>';
            select.options[ct]=opcion;
            ct++;
            for(x=0;x<arrOpc.length;x++)
            {	
            	etiquetaOpt=arrOpc[x];
                opcion=document.createElement('option');
                opcion.value=etiquetaOpt;
                opcion.text=etiquetaOpt;
                select.options[ct]=opcion;
                ct++;
                
            }
            var arr=new Array();
	        arr[0]=select;
            arrContenido[0]=arr;
            
        break;
        case '4': //pregunta cerrada-Opciones tabla
        	nomControl='_'+nControl+'vch';
            arrElementosSel=arrElementosSel.replace(',]',']');
            var arrOpc=eval(arrElementosSel);
            var etiquetaOpt;
            var valor;
            var select=document.createElement('select');
            select.setAttribute('val',val);
            select.id=nomControl;
            select.name=nomControl;
            var opcion;
            var ct=0;
            opcion=document.createElement('option');
            opcion.value='-1';
            opcion.text='<?php echo $etj["lblSeleccione"] ?>';
            select.options[ct]=opcion;
            ct++;
            for(x=0;x<arrOpc.length;x++)
            {	
            	etiquetaOpt=arrOpc[x][1];
                valor=arrOpc[x][0];
                opcion=document.createElement('option');
                opcion.value=valor;
                opcion.text=etiquetaOpt;
                select.options[ct]=opcion;
                ct++;
                
            }
            var arr=new Array();
	        arr[0]=select;
            arrContenido[0]=arr;
        break;
        case '5': //Texto Corto
        	nomControl='_'+nControl+'vch';
        	var confCampo=objDatos.confCampo;
            var input=document.createElement('input');
            input.type='text';
            input.id=nomControl;
            input.name=nomControl;
            input.setAttribute('maxlength',confCampo.longitud);
            input.size=confCampo.ancho;
            input.setAttribute('class','');
            input.setAttribute('val',val);
            
            var arr=new Array();
            arr[0]=input;
        	arrContenido[0]=arr;
        break;
        case '6': //Número entero
        	nomControl='_'+nControl+'int';
        	if(val=='')
            	val='num';
            else
            	val+='|num';
                
            var input=document.createElement('input');
            input.type='text';
            input.id=nomControl;
            input.name=nomControl;
			input.size='10';
            input.setAttribute('class','');
            input.setAttribute('val',val);
            
            if(navigator.userAgent.indexOf("MSIE")>=0)
            {
                input.onkeypress=	function()
                                        {
                                            return soloNumero(event,false,false);
                                        }
                
            }
            else
            {
               input.setAttribute('onkeypress','soloNumero(event,false,false)');
            }
            
            var sepMiles=document.createElement('input');
            sepMiles.type='hidden';
            sepMiles.value=',';
            sepMiles.id='sepMiles_'+nomControl;
            
            var lita=document.createElement('input');
            lita.type='hidden';
            lita.value=',';
            lita.id='lita_'+nomControl;
            
            var arr=new Array();
            arr[0]=input;
            arr[1]=sepMiles;
            arr[2]=lita;
        	arrContenido[0]=arr;    
        break;
        case '7': //Número decimal
        case '24': //Moneda
        	nomControl='_'+nControl+'flo';
        	 if(val=='')
            	val='flo';
            else
            	val+='|flo';
        	
            var input=document.createElement('input');
            input.type='text';
            input.id=nomControl;
            input.name=nomControl;
			input.size='10';
            input.setAttribute('class','');
            input.setAttribute('val',val);
            
            if(navigator.userAgent.indexOf("MSIE")>=0)
            {
                input.onkeypress=	function()
                                        {
                                            return soloNumero(event,true,false,this);
                                        }
                
            }
            else
            {
               input.setAttribute('onkeypress','soloNumero(event,true,false,this)');
            }
            
            var sepMiles=document.createElement('input');
            sepMiles.type='hidden';
            sepMiles.value=',';
            sepMiles.id='sepMiles_'+nomControl;
            
            var lita=document.createElement('input');
            lita.type='hidden';
            lita.value=',';
            lita.id='lita_'+nomControl;
           
            var sepDecimales=document.createElement('input');
            sepDecimales.type='hidden';
            sepDecimales.value='.';
            sepDecimales.id='sepDec_'+nomControl;
            
            var numDecimales=document.createElement('input');
            numDecimales.type='hidden';
            numDecimales.value='2';
            numDecimales.id='numD_'+nomControl;
            
            var arr=new Array();
            arr[0]=input;
            arr[1]=sepMiles;
            arr[2]=lita;
            arr[3]=sepDecimales;
            arr[4]=numDecimales;
        	arrContenido[0]=arr;    
        break;
        case '8': //Fecha
        	nomControl='_'+nControl+'dte';
        	 if(val=='')
            	val='dte';
            else
            	val+='|dte';
        	var confCampo=objDatos.confCampo;
            
            var span=document.createElement('span');
            span.id='sp'+nomControl;
            var input=document.createElement('input');
            input.type='hidden';
            input.id=nomControl;
            input.name=nomControl;
            input.setAttribute('val',val);
            input.setAttribute('extId','f_sp'+nomControl);
            
            var arr=new Array();
            arr[0]=span;
            arr[1]=input;
        	arrContenido[0]=arr;
			param1='sp'+nomControl;
            param2=nomControl;                            
            param3=confCampo.fechaMin;
            if(param3=='')
            	param3=null;
            param4=confCampo.fechaMax;
            if(param4=='')
            	param4=null;
        break;
        case '9': //Texto Largo 
        	nomControl='_'+nControl+'vch';
        	var confCampo=objDatos.confCampo;
            var textArea=document.createElement('textarea');
            textArea.id=nomControl;
            textArea.name=nomControl;
            textArea.style.width=confCampo.ancho+'px';
            textArea.style.height=confCampo.alto+'px';
            textArea.setAttribute('class','');
            textArea.setAttribute('val',val);
            var arr=new Array();
            arr[0]=textArea;
        	arrContenido[0]=arr;
        break;
        case '10': //Texto Enriquecido	
        	nomControl='_'+nControl+'vch';
        	var confCampo=objDatos.confCampo;
            var span=document.createElement('span');
            span.name='txtEnriquecido_'+idElemento;
            span.id=  'txtEnriquecido_'+idElemento;
			span.setAttribute('val',val);
            var arr=new Array();
            arr[0]=span;
            arrContenido[0]=arr;
            param1=nomControl;
            param2='txtEnriquecido_'+idElemento;
            param3=confCampo.ancho;
            param4=confCampo.alto;
            
        break;
        case '11':	//Correo Electrónico
        	nomControl='_'+nControl+'vch';
        	var confCampo=objDatos.confCampo;
            if(val=='')
            	val='mail';
            else
            	val+='|mail';
        	
            nomControl='_'+nControl+'vch';
        	var confCampo=objDatos.confCampo;
            var input=document.createElement('input');
            input.type='text';
            input.id=nomControl;
            input.name=nomControl;
            input.setAttribute('maxlength',confCampo.longitud);
            input.size=confCampo.ancho;
            input.setAttribute('class','');
            input.setAttribute('val',val);
            
            var arr=new Array();
            arr[0]=input;
        	arrContenido[0]=arr;
        break;
        case '12': //Archivo
        	var confCampo=objDatos.confCampo;
        	nomControl='_'+nControl+'fil';
            
            var hTipo=document.createElement('hidden');
            hTipo.id='tipoArch'+nomControl;
            hTipo.value=confCampo.tipoDoc;
            hTipo.type='hidden';
            
            var hTam=document.createElement('hidden');
            hTam.id='tamArch'+nomControl;
            hTam.value=confCampo.tamMax;
            hTam.type='hidden';
            
            var input=document.createElement('input');
            input.type='text';
            input.size='15';
            
            var boton=document.createElement('input');
            boton.type='button';
            boton.id=nomControl;
            boton.name=nomControl;
            boton.value='<?php echo $etj["lblSelArchivo"]?> ...';
            boton.setAttribute('val',val);
            boton.setAttribute('campo',contPregunta);
            
            var arr=new Array();
            arr[0]=hTipo;
            arr[1]=hTam;
            arr[2]=input;
            arr[3]=boton;
            
        	arrContenido[0]=arr;
        break;
        
        case '13': //frame
        	nomControl='_lbl'+idElemen;
        	var x;
            var legend=document.createElement('legend');
            var confCampo=objDatos.confCampo;
        	for(x=0;x<arrPregunta.length;x++)
            {
                if(arrPregunta[x].idIdioma=idIdioma)
                {
	                pregunta[x]=document.createElement('fieldset');
                    pregunta[x].id=nomControl;
                    pregunta[x].setAttribute('class','frameHijo');
                    pregunta[x].style.width=confCampo.ancho+'px';
                    pregunta[x].style.height=confCampo.alto+'px';
                    legend.appendChild(document.createTextNode(dv(arrPregunta[x].etiqueta)));
                    pregunta[x].appendChild(legend);
                    break;
                }
            }
            
            var etiquetas=objDatos.pregunta;
            var camposH='';
            var ct=1;
            for(x=0;x<etiquetas.length;x++)
            {
            	pregunta[ct]=document.createElement('input');
                pregunta[ct].type='hidden';
                pregunta[ct].value=dv(etiquetas[0].etiqueta);
                pregunta[ct].id='td_'+idElemen+'_'+etiquetas[0].idIdioma;
                pregunta[ct].name='td_'+idElemen+'_'+etiquetas[0].idIdioma;
            	ct++;
            }
            arrContenido[0]=pregunta;
        break;
        case '14':
        case '15':
        case '16':
			var nomControl='_'+nControl+'vch';
            var arrOpc=eval(arrElementosSel);
            var tablaCtrl=crearTabla(1,arrElementosSel,parseInt(tipoElemento),nomControl,'');
            var arr=new Array();
            var span=document.createElement('span');
            span.id='span'+nomControl;
            span.appendChild(tablaCtrl);
            arr[0]=span;
            var input=document.createElement('input');
            input.type='hidden';
            input.name=nomControl;
            input.id=nomControl;
            input.setAttribute('val',val);
            
            
            var input2=document.createElement('input');
            input2.type='hidden';
            input2.id='lista'+nomControl;
            input2.value=arrElementosSel;
            
            var input3=document.createElement('input');
            input3.type='hidden';
            input3.id='numCol'+nomControl;
            input3.value='1';
            
            var input4=document.createElement('input');
            input4.type='hidden';
            input4.id='default'+nomControl;
            input4.value='100584';
            
            var input5=document.createElement('input');
            input5.type='hidden';
            input5.id='anchoCelda'+nomControl;
            input5.value='0';
            
            var input6=document.createElement('input');
            input6.type='hidden';
            input6.id='nColumnas'+nomControl;
            input6.value='1';
            
            var input7=document.createElement('input');
            input7.type='hidden';
            input7.id='ancho'+nomControl;
            input7.value='0';
            
            arr[0]=span;
            arr[1]=input;
            arr[2]=input2;        
            arr[3]=input3;
            arr[4]=input4;
            arr[5]=input5;
            arr[6]=input6;
            arr[7]=input7;
            
            arrContenido[0]=arr;
        break
        case '17':
        case '18':
        case '19':
        	var nomControl='_'+nControl+'arr';
            var arrOpc=eval(arrElementosSel);
            var tablaCtrl=crearTabla(1,arrElementosSel,parseInt(tipoElemento),nomControl,'');
            var arr=new Array();
            var span=document.createElement('span');
            span.id='span'+nomControl;
            span.appendChild(tablaCtrl);
            arr[0]=span;
            var input2=document.createElement('input');
            input2.type='hidden';
            input2.id='lista'+nomControl;
            input2.value=arrElementosSel;
            var input3=document.createElement('input');
            input3.type='hidden';
            input3.id='numCol'+nomControl;
            input3.value='1';
            var input5=document.createElement('input');
            input5.type='hidden';
            input5.id='anchoCelda'+nomControl;
            input5.value='0';
            
            var input6=document.createElement('input');
            input6.type='hidden';
            input6.id='nColumnas'+nomControl;
            input6.value='1';
            
            var input7=document.createElement('input');
            input7.type='hidden';
            input7.id='ancho'+nomControl;
            input7.value='0';
            
            var input4=document.createElement('input');
            input4.type='hidden';
            input4.id='minSel'+nomControl;
            if(val.indexOf('obl')!=-1)
	            input4.value=1;
            else
            	input4.value=0;
            
            var input8=document.createElement('input');
            input8.type='hidden';
            input8.id=nomControl;
            input8.value='';
            
            arr[0]=span;
            arr[1]=input2;
            arr[2]=input3;        
            arr[3]=input5;
            arr[4]=input4;
            arr[5]=input5;
            arr[6]=input6;
            arr[7]=input7;
            arr[8]=input8;
            arrContenido[0]=arr;
        
        break
        case '20':
        	nomControl='_'+nControl+'vch';
        	var confCampo=objDatos.confCampo;
            var input=document.createElement('input');
            input.type='text';
            input.id=nomControl;
            input.name=nomControl;
            input.size='15';
			input.setAttribute('readOnly','readOnly');
            input.value=nControl;
            
            var hTipo=document.createElement('input');
            hTipo.type='hidden';
            hTipo.id='tipo'+nomControl;
            hTipo.value=confCampo.vSesion;
            
            var hActualizable=document.createElement('input');
            hActualizable.type='hidden';
            hActualizable.id='actualizable'+nomControl;
            hActualizable.value='1';
            
            var arr=new Array();
            arr[0]=input;
            arr[1]=hTipo;
            arr[2]=hActualizable;
        	arrContenido[0]=arr;
        	
        break;
        case '21': //Fecha
        	nomControl='_'+nControl+'vch';
        	 if(val=='')
            	val='vch';
            else
            	val+='';
        	var confCampo=objDatos.confCampo;
            
            var span=document.createElement('span');
            span.id='sp'+nomControl;
            var input=document.createElement('input');
            input.type='hidden';
            input.id=nomControl;
            input.name=nomControl;
            input.setAttribute('val',val);
            input.setAttribute('extId','f_sp'+nomControl);
            
            var arr=new Array();
            arr[0]=span;
            arr[1]=input;
        	arrContenido[0]=arr;
			param1='sp'+nomControl;
            param2=nomControl;                            
            param3=confCampo.horaMin;
            if(param3=='')
            	param3=null;
            param4=confCampo.horaMax;
            if(param4=='')
            	param4=null;
            param5=confCampo.intervalo;
            
        break;
        case '22':
        	nomControl='_'+nControl+'flo';
            param2=nomControl;
            var label=document.createElement('label');
            label.setAttribute('class','letraFicha');
            label.id='lbl_'+nomControl;
            label.name='lbl_'+nomControl;
            
            var sp_expresion=document.createElement('input');
            sp_expresion.id='exp_'+nomControl;
            sp_expresion.name='exp_'+nomControl;
            sp_expresion.type='hidden';
            
            
            var sp_numD=document.createElement('input');
            sp_numD.id='numD_'+nomControl;
            sp_numD.name='numD_'+nomControl;
            sp_numD.type='hidden';
            sp_numD.value='2';
            
            var sp_sepMiles=document.createElement('input');
            sp_sepMiles.id='sepMiles_'+nomControl;
            sp_sepMiles.name='sepMiles_'+nomControl;
            sp_sepMiles.type='hidden';
            sp_sepMiles.value=',';
            
            var sp_sepDec=document.createElement('input');
            sp_sepDec.id='sepDec_'+nomControl;
            sp_sepDec.name='sepDec_'+nomControl;
            sp_sepDec.type='hidden';
            sp_sepDec.value='.';
            
            var sp_tratoDec=document.createElement('input');
            sp_tratoDec.id='tratoDec_'+nomControl;
            sp_tratoDec.name='tratoDec_'+nomControl;
            sp_tratoDec.type='hidden';
            sp_tratoDec.value='1';
            
            var sp=document.createElement('input');
            sp.id=nomControl;
            sp.name=nomControl;
            sp.type='hidden';
            sp.value='';
            
            var arr=new Array();
            arr[0]=label;
            arr[1]=sp_expresion;
            arr[2]=sp_numD;
            arr[3]=sp_sepMiles;
            arr[4]=sp_sepDec;
            arr[5]=sp_tratoDec;
            arr[6]=sp;
            
            arrContenido[0]=arr;
            
            param1=objDatos.arrTokens;
            var arrTokens=param1;
            
            var x=0;
            var cadOperaciones='';
            for(x=0;x<arrTokens.length;x++)
            {
            	if(cadOperaciones=='')
                	cadOperaciones="['"+dv(arrTokens[x].tokenApp)+"','"+dv(arrTokens[x].tokenUsr)+"','"+arrTokens[x].tipoToken+"']";
                else
                	cadOperaciones+=",['"+dv(arrTokens[x].tokenApp)+"','"+dv(arrTokens[x].tokenUsr)+"','"+arrTokens[x].tipoToken+"']";
			}            
            sp_expresion.value='['+cadOperaciones+']';
            
        break;
        case '23':
        	nomControl='_'+nControl+'img';
            var imagen=document.createElement('img');
            var confCampo=objDatos.confCampo;
            imagen.src='../media/mostrarImgFrm.php?id='+Base64.encode(objDatos.idImagen);
            imagen.id=nomControl;
			imagen.width=confCampo.ancho;
            imagen.height=confCampo.alto;
            var arr=new Array();
            arr[0]=imagen;
        	arrContenido[0]=arr;  
        break;
    }
    
    var arrEliminar=document.createElement('div');
    var linkDel=document.createElement('a');
    linkDel.href='javascript:eliminarElemento('+idElemento+')';
    
    var imgDel=document.createElement('img');
    imgDel.src='../images/formularios/cross.png';
    imgDel.height='10';
    imgDel.width='10';
    imgDel.title='<?php echo $etj["lblEliminarElem"]?>';
    imgDel.alt='<?php echo $etj["lblEliminarElem"]?>';
    
    linkDel.appendChild(imgDel);
    arrEliminar.appendChild(document.createTextNode('  '));
    arrEliminar.appendChild(linkDel);
    
    arrContenido[1]=arrEliminar;
    arrContenido[2]=asteriscoRojo;
    arrContenido[3]=idElemen;
    arrContenido[4]=nomControl;
    arrContenido[5]=tipoElemento;
    return arrContenido;
}

function crearTabla(nColumnas,datos,tipoControl,nombreCtrl,anchoCelda)
{
	var nCol=parseInt(nColumnas);
	var table=document.createElement('table');
    table.id='tbl'+nombreCtrl;
    table.style.backgroundColor="#FFF";
    var tbody=document.createElement('tbody');
    table.appendChild(tbody);
    var nCl=0;
    var fila;
    var x;
    var td;
    var opcion;
    var arrDatos=eval(datos);
    var tControl;
    if((tipoControl>=14) && (tipoControl<=16))
    	tControl='radio';
    if((tipoControl>=17) && (tipoControl<=19))
    	tControl='checkbox';
    
    for(x=0;x<arrDatos.length;x++)
    {
    	if(nCl==0)
        {	
        	fila=document.createElement('tr');
            tbody.appendChild(fila);
        }
        td=document.createElement('td');
        td.setAttribute('class','');
        
        opcion=document.createElement('input');
        opcion.type=tControl;
        if((tipoControl>=14) && (tipoControl<=16))
        {
	    	opcion.name='opt'+nombreCtrl;
            if(navigator.userAgent.indexOf("MSIE")>=0)
            {
                opcion.onclick=	function()
                                        {
                                            return selOpcion(this);
                                        }
                
            }
            else
            {
               opcion.setAttribute('onclick','selOpcion(this)');
            }
            
            
        }
    	if((tipoControl>=17) && (tipoControl<=19))
        {
    		opcion.name='opt_'+nombreCtrl+'[]';
            if(navigator.userAgent.indexOf("MSIE")>=0)
            {
                opcion.onclick=	function()
                                        {
                                            return selCheck(this);
                                        }
                
            }
            else
            {
               opcion.setAttribute('onclick','selCheck(this)');
            }
        }
        opcion.id='opt'+nombreCtrl+'_'+arrDatos[x][0];
        var et;
        opcion.value=arrDatos[x][0];
        opcion.setAttribute('disabled','disabled');
        et=document.createTextNode(' '+arrDatos[x][1]);
        nCl++;
        td.appendChild(opcion);
        td.appendChild(et);
        td.setAttribute('width',anchoCelda);
        fila.appendChild(td);
        if(nCl==nCol)
        	nCl=0;
    }
    return table;
}

function inicializarTextoE()
{
	//crearTextoEnriquecido(param1,param2,param3);
}

function crearTextoEnriquecido(id,idDivDestino,ancho,alto,valor)
{
	var texto=crearRichText(id,idDivDestino,ancho,alto,'',valor);
}

function insertarControl(contenidos)
{
   var tabla=document.createElement('table');
   var tbody=document.createElement('tbody');
   var fila=document.createElement('tr');
   tabla.setAttribute('class','tablaControl');
   var celda1=document.createElement('td');
   var celda2=document.createElement('td');
   var celda3=document.createElement('td');
   
   celda1.setAttribute('valign','top');
   celda1.id='td_obl_'+contenidos[3];
   celda1.width='10';
   if(contenidos[2]!=null)
	   celda1.appendChild(contenidos[2]);
   fila.appendChild(celda1);
   celda2.id='td_'+contenidos[3];
   celda2.setAttribute('class','');
   var x;
   for(x=0;x<contenidos[0].length;x++)
	   celda2.appendChild(contenidos[0][x]);
   celda3.setAttribute('valign','top');  
   celda3.appendChild(contenidos[1]);
	
   fila.appendChild(celda1);
   fila.appendChild(celda2);
   fila.appendChild(celda3);
   tbody.appendChild(fila);
   tabla.appendChild(tbody);
   var divCtrl=document.createElement('div');
   divCtrl.id='div_'+idElemento;
   divCtrl.setAttribute('controlInterno',contenidos[4]+"_"+contenidos[5]);
   
   if((tipoElemento!='1')&&(tipoElemento!='13')&&(tipoElemento!='22'))
   {
	    arrElementosFocus.push('div_'+idElemento);
		divCtrl.setAttribute('orden',(arrElementosFocus.length));	
		var nReg=new regCombo({id:arrElementosFocus.length,nombre:arrElementosFocus.length});
        Ext.getCmp('cmbNumTab').getStore().add(nReg);
   }    
   
   if(tipoElemento!='20')
   {
       divCtrl.style.top=mitadY+'px';
       divCtrl.style.left=mitadX+'px';
       divCtrl.style.position='absolute';
   }
   divCtrl.style.backgroundColor='#FFF';

   if(navigator.userAgent.indexOf("MSIE")>=0)
    {
        divCtrl.onmousedown=	function()
                                {
                                    comienzoMovimiento(event, this.id);
                                }
        
    }
    else
    {
       divCtrl.setAttribute('onmousedown','comienzoMovimiento(event, this.id)');
    }               
    if(tipoElemento!='20')
   	{             
       divCtrl.onmouseover=	function()
                            {
                                this.style.cursor="move"
                            }
	}                      
   
   divCtrl.appendChild(tabla);
   
	if(tipoElemento!='20')
   		tdContenedor.appendChild(divCtrl);
   	else
   	{
    	var contenedorTmp=gE('tblHidden');
        contenedorTmp.appendChild(divCtrl);
   	}
   if((tipoElemento=='8')||(tipoElemento==8))
        crearCampoFecha(param1,param2,param3,param4);
        
   if((tipoElemento=='10')||(tipoElemento==10))  
	   crearTextoEnriquecido(param1,param2,param3,param4) ;    
        
        
        
   if((tipoElemento=='21')||(tipoElemento==21))
   {

        crearCampoHora(param1,param2,param3,param4,parseInt(param5));     
    }    
   if((tipoElemento=='10')||(tipoElemento==10))
   {
   		setTimeout('inicializarTextoE()',1000);
   }
   
   
   
   if(tipoElemento=='4')
   {
		var objGuardado=eval(objDatosActual)[0];
        if((objGuardado.comboDependiente=='1')&&(objGuardado.controlDependiente!=undefined))
        {
        	var nombreControlD=objGuardado.controlDependiente;
            var condicion=objGuardado.condicion;
            var campoCondicion=objGuardado.campoCondicion;
            var nomCampo=objGuardado.nomCampo;
            var comboD=gE('_'+nombreControlD+'vch');
            comboD.setAttribute('cFiltro',campoCondicion);
            comboD.setAttribute('condicion',condicion);
            comboD.setAttribute('cDestino',nomCampo);
            asignarEventoChange(comboD); 	
        }
   }
   
   if((tipoElemento=='16')||(tipoElemento=='19'))
   {
		var objGuardado=eval(objDatosActual)[0];
        if((objGuardado.comboDependiente=='1')&&(objGuardado.controlDependiente!=undefined))
        {
        	var nombreControlD=objGuardado.controlDependiente;
            var condicion=objGuardado.condicion;
            var campoCondicion=objGuardado.campoCondicion;
            var nomCampo=objGuardado.nomCampo;
            var comboD=gE('_'+nombreControlD+'vch');
            comboD.setAttribute('cFiltro',campoCondicion);
            comboD.setAttribute('condicion',condicion);
            comboD.setAttribute('cDestino',nomCampo);
            asignarEventoChangeListado(comboD,tipoElemento); 	
        }
   }
   
   if((tipoElemento=='22')||(tipoElemento==22))
   {
		var arrTokens=param1;
        var x=0;
        var cadOperaciones='';
        for(x=0;x<arrTokens.length;x++)
        {
           
            if(arrTokens[x].tipoToken=='2')
            {
                funcionCalcular= function (evento)
                                {
                                    
                                    evaluarExpresion(param2);
                                };
    
        
                asignarEvento(arrTokens[x].tokenApp,'change',funcionCalcular);
            }                
        }            
        idDivSel='div_'+idElemento;
        evaluarExpresion(param2);
        
   }  
   
   seleccionarControl('div_'+contenidos[3]);
}

function eliminarElemento(idElemento)
{
     function resp(btn)
      {
          if(btn=='yes')
          {
              function funcResp()
              {
                  arrResp=peticion_http.responseText.split('|');
                  if(arrResp[0]=='1')
                  {
                      var divControl=gE('div_'+idElemento);
                      var pos=existeValorArreglo(arrElementosFocus,'div_'+idElemento);
                      if(pos!=-1)
                      {
                      	 var nOrden=divControl.getAttribute('orden');
                         arrElementosFocus.splice(pos,1);
                         var comboNum=Ext.getCmp('cmbNumTab');
                         comboNum.getStore().removeAt(comboNum.getStore().getCount()-1);
                      }
                      divControl.parentNode.removeChild(divControl);
                      gridPropiedades.setSource(null);
                      actualizarFocusEliminacion(nOrden);
                  }
                  else
                  {
                      msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                  }
              }
              obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=2&idGrupoElemento='+idElemento,true);
          }
      }
      Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgConfElimEl"]?>',resp);
}

function actualizarPosicionElemento()
{
	if(((parseInt(ultimaPosX)<0)||(parseInt(ultimaPosY)<0))&&(gE(idDivSel).getAttribute('tipoCtrl')!='-2'))
    {
    	
    	return;
    }
	var arrDiv=idDivSel.split('_');
	var idElemento=arrDiv[1];
	var objPos='{"posX":"'+ultimaPosX+'","posY":"'+ultimaPosY+'","idElemento":"'+idElemento+'"}';
	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	ultimaPosX=undefined;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=9&param='+objPos,true);
}

function mostrarVentanaFiltro(objFinal,nomTabla)
{

	idOrigenD=1;
	var opcion1=new Ext.form.Radio	(
                                            {
                                                id:'opcion1F',
                                                name:'origenD',
                                                value:1,
                                                boxLabel:'<?php echo $etj["lblOrigenCombo"]?>',
                                                x:40,
                                                y:45,
                                                
                                                checked:true
                                            }
                                        );
                                        
	opcion1.on('check',opcionClick);                                        
	var opcion2= new Ext.form.Radio	(
                                            {
                                                id:'opcion2F',
                                                name:'origenD',
                                                value:2,
                                                boxLabel:'<?php echo $etj["lblOrigenValorTabla"]?>',
                                                x:40,
                                                y:75
                                            }
                                        );
	opcion2.on('check',opcionClick);                                            
	                                          
    
	var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: 	[
                                                    
                                                    			{
                                                                	x:10,
                                                                    y:10,
                                                                	xtype:'label',
                                                                    text:'<?php echo $etj["lblSeleccioneOF"]?>:'
                                                                },
                                                    			opcion1,
                                                                opcion2
                                                    		]
												}
											);
		
	ventanaOrigenDatosSel = new Ext.Window(
											{
												title: '<?php echo $etj["lblOrigenF"]?>',
												width: 450,
												height:250,
												minWidth: 300,
												minHeight: 100,
												layout: 'fit',
												plain:true,
												modal:true,
												bodyStyle:'padding:5px;',
												buttonAlign:'center',
												items: form,
												buttons:	[
																{
																	id:'btnAceptar',
																	text: '<?php echo $etj["lblSiguiente"] ?> >>',
																	listeners:	{
																					click:function()
																						{
																							ventanaOrigenDatosSel.hide();
                                                                                            switch(idOrigenD)
                                                                                            {
                                                                                            	case 1:
                                                                                                	mostrarVentanaSelComboDep(objFinal,nomTabla);
                                                                                                break;
                                                                                                case 2:
                                                                                                	mostrarVentanaCondFiltro(objFinal,nomTabla);
                                                                                                	
                                                                                                break;
                                                                                              
                                                                                           
                                                                                            }
																							
																							
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventanaOrigenDatosSel.close();
																			}
																}
															]
											}
										);

		ventanaOrigenDatosSel.show();
}

function mostrarVentanaSelTabla(tipoElemento,autocompletar)
{
    idFormulario=gE('idFormulario').value;
	var alDatos = new Ext.data.JsonStore	(
                                                {
                                                    root: 'registros',
                                                    totalProperty: 'numReg',
                                                    idProperty: 'nomTablaOriginal',
                                                    fields:	[
                                                                {name:'nomTablaOriginal'},
                                                                {name:'tabla'}, 
                                                                {name:'tipoTabla'},
                                                                {name:'proceso'}
                                                            ],
                                                    remoteSort:false,
                                                    proxy: new Ext.data.HttpProxy	(
                                                                                        {
                                                                                            url: '../paginasFunciones/funcionesFormulario.php'
                                                                                            
                                                                                        }
                                                                                    )
                                                }
                                            );  
                                            
                                            
	var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[
                                                        				{
                                                                            type:'string',
                                                                           	dataIndex:'tabla' 
																		},
                                                                        {
                                                                            type:'list',
                                                                           	dataIndex:'tipoTabla',
                                                                            phpMode:true,
                                                                            options:	[
                                                                            				{
                                                                                            	id:'1',
                                                                                                text:'Formulario Din&aacute;mico'
                                                                                            },
                                                                            				{
                                                                                            	id:'2',
                                                                                                text:'Sistema'
                                                                                            }
                                                                            			] 
																		},
                                                                        {
                                                                            type:'string',
                                                                           	dataIndex:'proceso' 
																		}
                                                        			]
                                                    }
                                                );                                                                                                                           
    
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Tabla',
                                                            width:250,
                                                            dataIndex:'tabla',
                                                            sortable:true
                                                        },
                                                        {
                                                        	header:'Tipo',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'tipoTabla'
                                                        },
                                                        {
                                                        	header:'Proceso',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'proceso'
                                                        }
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridTabla',
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:700,
                                                            plugins: filters
                                                            
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    width:700,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
    
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid
                                                    ]
                                        }
                                    );
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Siguiente >>',
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                    	
                                                                        var filaSel= tblOpciones.getSelectionModel().getSelected();
                                                                        if(filaSel==null)
                                                                        {
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgErrDebeST"] ?>');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var nomTabla=filaSel.get('nomTablaOriginal');
                                                                        ventanaOrigenDatosSel.close();
                                                                        ventanaSelTabla.close();
                                                                        mostrarVentanaSelColumna(nomTabla,tipoElemento,autocompletar);
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelTabla = new Ext.Window(
                                            {
                                                title: 'Seleccione la tabla en la cual se basar&aacute; su consulta',
                                                width: 730 ,
                                                height:390,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                          			                  
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: 'Cancelar',
                                                                    handler:function()
                                                                    {
                                                                        ventanaSelTabla.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
                                        
	tblOpciones.getStore().load(
    								{	
                                    	params:	{
                                            		funcion:46
                                        		}	
                                    }
                               );                                        	
	ventanaSelTabla.show();                                        
	
}


var listUsuario;
var listApp;
var arrCampo;

function mostrarVentanaSelColumna(nomTabla,tipoElemento,auto)
{
	var autocompletar;
    
	listUsuario=new Array();
	listApp=new Array();
    
    
    arrCampo=null;

	var siguiente=0;
    var cmbCampoLlave=crearComboExt('cmbCampoLlave',[],135,240);
    var cmbCampoBusqueda=crearComboExt('cmbCampoBusqueda',[],135,270);
    
    var lblBtn='<?php echo $etj["lblFinalizar"] ?>';
    var comboSiNo=crearComboSiNo();
    comboSiNo.setValue('0');
	comboSiNo.setPosition(140,35);
    var comboSiNoF=crearComboSiNo('cmbSiNoF');
    comboSiNoF.setValue('0');
	comboSiNoF.setPosition(140,65);
    
    
    function funcCambioSiNoF(combo,registro,indice)
    {
		var nuevoValor=registro.get('id');
    	if(nuevoValor=='1')
        {
			Ext.getCmp('btnFinalizar').setText('<?php echo $etj["lblSiguiente"] ?> >>');
            siguiente=1;
        }
       	else
        {
        	Ext.getCmp('btnFinalizar').setText('<?php echo $etj["lblFinalizar"] ?>');
            siguiente=0;
         }
    	
    }
    
    comboSiNoF.on('select',funcCambioSiNoF);
    
    var txtNombreCampo=new Ext.form.TextField	(
                                                {
                                                    id:'txtNombreCampo',
                                                    x:140,
                                                    y:5,
                                                    width:160,
                                                    hideLabel:true,
                                                    maskRe:/^[a-zA-Z0-9]$/
                                                   
                                                }
                                            )
    var valorOculto=false;
    
    
    
    if(auto==undefined)
    {
    	autocompletar=0;
        var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                            			 new Ext.form.Label	(
                                                                                {
                                                                                    x:5,
                                                                                    y:10,
                                                                                    text:'<?php echo $etj["lblNomCampo"]?>:'
                                                                                }
                                                                            ) ,
                                                        txtNombreCampo,
                                                        new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:40,
                                                                                        text:'<?php echo $etj["lblCampoObl"]?>:'
                                                                                    }
                                                                                ) , 
                                                        comboSiNo,
                                                        new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:70,
                                                                                        text:'<?php echo $etj["lblFiltrar"]?>:',
                                                                                        hidden:valorOculto
                                                                                    }
                                                                                ) , 
                                                        comboSiNoF,
                                                        {
                                                        	xtype:'label',
                                                            x:5,
                                                            y:105,
                                                            html:'Configure el texto a mostrar como opci&oacute;n:'
                                                        }
                                                        ,
                                                        {
                                                        	xtype:'panel',
                                                            x:20,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/add.png',
                                                                            tooltip:'Agregar campo',
                                                                        	handler:function()
                                                                            		{
                                                                                    	mostrarVentanaSelCampo(arrCampo);
                                                                                    }
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            x:45,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/font_add.png',
                                                                            tooltip:'Agregar frase',
                                                                        	handler:function()
                                                                            		{
                                                                                    	mostrarVentanaFrase();
                                                                                    }
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            x:70,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/espacio.png',
                                                                            tooltip:'Agregar espacio en blanco',
                                                                        	handler:function()
                                                                            		{
                                                                                    	listUsuario.push('\' \'');
                                                                                        listApp.push('\' \'');
                                                                                        actualizarVistaOpcion();
                                                                                    }
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            x:95,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/delete.png',
                                                                            tooltip:'Remover elemento',
                                                                        	handler:function()
                                                                            		{
                                                                                    	listUsuario.pop();
                                                                                        listApp.pop();
                                                                                        actualizarVistaOpcion();
                                                                                    }
                                                                                    
                                                                        }
                                                            		]
                                                        },
                                                        
                                                        {
                                                        
                                                        	id:'txtVistaElemento',
                                                            xtype:'textarea',
                                                            x:20,
                                                            y:175,
                                                            width:500,
                                                            height:50,
                                                            readOnly:true
                                                        },
                                                        {
                                                        	x:5,
                                                            y:245,
                                                            xtype:'label',
                                                            html:'Campo ID:'
                                                        },
                                                        cmbCampoLlave
                                                        
                                                    ]
                                        }
                                    );
        
    }
    else
    {
    	autocompletar=1;
        var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                            			 new Ext.form.Label	(
                                                                                {
                                                                                    x:5,
                                                                                    y:10,
                                                                                    text:'<?php echo $etj["lblNomCampo"]?>:'
                                                                                }
                                                                            ) ,
                                                        txtNombreCampo,
                                                        new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:40,
                                                                                        text:'<?php echo $etj["lblCampoObl"]?>:'
                                                                                    }
                                                                                ) , 
                                                        comboSiNo,
                                                        new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:70,
                                                                                        text:'<?php echo $etj["lblFiltrar"]?>:',
                                                                                        hidden:valorOculto
                                                                                    }
                                                                                ) , 
                                                        comboSiNoF,
                                                        {
                                                        	xtype:'label',
                                                            x:5,
                                                            y:105,
                                                            html:'Configure el texto a mostrar como opci&oacute;n:'
                                                        }
                                                        ,
                                                        {
                                                        	xtype:'panel',
                                                            x:20,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/add.png',
                                                                            tooltip:'Agregar campo',
                                                                        	handler:function()
                                                                            		{
                                                                                    	mostrarVentanaSelCampo(arrCampo);
                                                                                    }
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            x:45,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/font_add.png',
                                                                            tooltip:'Agregar frase',
                                                                        	handler:function()
                                                                            		{
                                                                                    	mostrarVentanaFrase();
                                                                                    }
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            x:70,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/espacio.png',
                                                                            tooltip:'Agregar espacio en blanco',
                                                                        	handler:function()
                                                                            		{
                                                                                    	listUsuario.push('\' \'');
                                                                                        listApp.push('\' \'');
                                                                                        actualizarVistaOpcion();
                                                                                    }
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            x:95,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/delete.png',
                                                                            tooltip:'Remover elemento',
                                                                        	handler:function()
                                                                            		{
                                                                                    	listUsuario.pop();
                                                                                        listApp.pop();
                                                                                        actualizarVistaOpcion();
                                                                                    }
                                                                                    
                                                                        }
                                                            		]
                                                        },
                                                        
                                                        {
                                                        
                                                        	id:'txtVistaElemento',
                                                            xtype:'textarea',
                                                            x:20,
                                                            y:175,
                                                            width:500,
                                                            height:50,
                                                            readOnly:true
                                                        },
                                                        {
                                                        	x:5,
                                                            y:245,
                                                            xtype:'label',
                                                            html:'Campo ID:'
                                                        },
                                                        cmbCampoLlave,
                                                        {
                                                         	x:5,
                                                            y:275,
                                                            xtype:'label',
                                                            html:'Campo de b&uacute;squeda:'
                                                        },
                                                        cmbCampoBusqueda
                                                        
                                                    ]
                                        }
                                    );
    }
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: lblBtn,
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        var txtNombreCampo=Ext.getCmp('txtNombreCampo').getValue();
                                                                        if(txtNombreCampo=='')
                                                                        {
                                                                            function resp()
                                                                            {
                                                                                Ext.getCmp('txtNombreCampo').focus(false,10);
                                                                            }
                                                                            Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','El ID del campo es obligatorio',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(listApp.length==0)
                                                                        {
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','Al menos debe seleccionar un campo para proyectar como texto de la opci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        var x;
                                                                        var nomColumn='';
                                                                        for(x=0;x<listApp.length;x++)
                                                                        {
                                                                        	if(nomColumn=='')
                                                                        		nomColumn=listApp[x];
                                                                            else
                                                                            	nomColumn+=','+listApp[x];
                                                                        }
                                                                        
                                                                        var cLlave=cmbCampoLlave.getValue();
                                                                        if(cLlave=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el campo ID que identificara de manera unica a cada una de sus opciones');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cmbCampoBusqueda=Ext.getCmp('cmbCampoBusqueda');
                                                                        cBusqueda='';
                                                                        if(cmbCampoBusqueda!=null)
                                                                        	cBusqueda=cmbCampoBusqueda.getValue();
                                                                        var objTablaConf='{"tabla":"'+nomTabla+'","columna":"'+cv(nomColumn)+'","cLlave":"'+cLlave+'","autocompletar":"'+autocompletar+'","cBusqueda":"'+cBusqueda+'"}';
                                                                        
                                                                        if(siguiente=='0')
                                                                        {
                                                                        	if((tipoElemento==undefined)||(tipoElemento==null))
	                                                                            var objFinal='{"idFormulario":"'+idFormulario+'","pregunta":null,"tipoElemento":"4","objTablaConf":'+objTablaConf+',"posX":"'+mitadX+'","posY":"'+mitadY+'","nomCampo":"'+txtNombreCampo+'","obligatorio":"'+comboSiNo.getValue()+'","comboDependiente":"'+siguiente+'"}';
                                                                            else
                                                                                var objFinal='{"idFormulario":"'+idFormulario+'","pregunta":null,"tipoElemento":"'+tipoElemento+'","objTablaConf":'+objTablaConf+',"posX":"'+mitadX+'","posY":"'+mitadY+'","nomCampo":"'+txtNombreCampo+'","obligatorio":"'+comboSiNo.getValue()+'","comboDependiente":"'+siguiente+'"}';
                                                                            guardarPregunta(objFinal,ventanaSelCol);
                                                                        }
                                                                        else
                                                                       	{
                                                                        	if((tipoElemento==undefined)||(tipoElemento==null))
	                                                                        	var objFinal='"idFormulario":"'+idFormulario+'","pregunta":null,"tipoElemento":"4","objTablaConf":'+objTablaConf+',"posX":"'+mitadX+'","posY":"'+mitadY+'","nomCampo":"'+txtNombreCampo+'","obligatorio":"'+comboSiNo.getValue()+'","comboDependiente":"'+siguiente+'"';
                                                                            else
                                                                            	var objFinal='"idFormulario":"'+idFormulario+'","pregunta":null,"tipoElemento":"'+tipoElemento+'","objTablaConf":'+objTablaConf+',"posX":"'+mitadX+'","posY":"'+mitadY+'","nomCampo":"'+txtNombreCampo+'","obligatorio":"'+comboSiNo.getValue()+'","comboDependiente":"'+siguiente+'"';
                                                                            ventanaSelCol.close();
                                                                            mostrarVentanaFiltro(objFinal,nomTabla);
                                                                        }
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelCol = new Ext.Window(
                                            {
                                                title: '<?php echo $etj["lblSelColuma"]?>',
                                                width: 600 ,
                                                height:400,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                          			    	Ext.getCmp('txtNombreCampo').focus(false,10);              
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaSelCol.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	
	cargarColumnas(nomTabla,ventanaSelCol);
}

function mostrarVentanaFrase()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	xtype:'label',
                                                            html:'Frase:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        {
                                                        	id:'txtFrase',
                                                            x:70,
                                                            y:5,
                                                            width:280
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar frase',
										width: 400,
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
                                                                	Ext.getCmp('txtFrase').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var frase=Ext.getCmp('txtFrase').getValue();
                                                                        if(frase=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	Ext.getCmp('txtFrase').focus();
                                                                            }
                                                                        	msgBox('Debe ingresar la frase a insertar',resp);
                                                                        }
                                                                        listUsuario.push(frase);
                                                                        listApp.push("'"+frase+"'");
                                                                        actualizarVistaOpcion();
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

function mostrarVentanaSelCampo(arrCampo)
{
	
	var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'campo'},
                                                                    {name:'tipo'}
                                                                ]
                                                    }
                                                );

    alOpciones.loadData(arrCampo);
   
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        
                                                        {
                                                            header:'<?php echo $etj["lblCampo"]?>',
                                                            width:250,
                                                            dataIndex:'campo'
                                                        },
                                                        {
                                                        	header:'<?php echo $etj["lblTipoCampo"]?>',
                                                            width:150,
                                                            dataIndex:'tipo'
                                                        }
                                                       
                                                    ]
                                                );
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridTabla',
                                                            store:alOpciones,
                                                            frame:true,
                                                            cm: cmFrmDTD,
                                                            height:220,
                                                            width:490,
                                                            title:'Seleccione el campo a insertar'
                                                        }
                                                    );
  
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    x:10,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														panelGrid
													]
										}
									);

	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar campo',
										width: 530,
										height:330,
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
																		var fila=tblOpciones.getSelectionModel().getSelected();
                                                                        var campo=fila.get('campo');
                                                                        listUsuario.push(campo);
                                                                        listApp.push(campo);
                                                                        actualizarVistaOpcion();
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

function actualizarVistaOpcion()
{
	var x;
    var cadena='';
    for(x=0;x<listUsuario.length;x++)
    {
    	cadena+=listUsuario[x];	
    }
    Ext.getCmp('txtVistaElemento').setValue(cadena);
}

function cargarColumnas(nomTabla,ventana)
{
	function funcResp()
    {
    	var arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
		{
            	var arrTablas=eval(arrResp[1]);
                var arrTablasCmb=eval(arrResp[2]);
                Ext.getCmp('cmbCampoLlave').getStore().loadData(arrTablasCmb);
                var cmbCampoBusqueda=Ext.getCmp('cmbCampoBusqueda');
                if(cmbCampoBusqueda!=null)
	                cmbCampoBusqueda.getStore().loadData(arrTablasCmb);
               	ventana.show();
                arrCampo=arrTablas;
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=13&nomTabla='+nomTabla,true);
}

function mostrarVentanaSelComboDep(objFinal,tabla)
{
	var idFormulario=gE('idFormulario').value;
	var siguiente=0;
	var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'campo'},
                                                                    {name:'tipo'}
                                                                ]
                                                    }
                                                );
    
    
    var dsOpciones= [];
    
    alOpciones.loadData(dsOpciones);
    
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'<?php echo $etj["lblNomCtrSelec"]?>',
                                                            width:150,
                                                            dataIndex:'campo'
                                                        },
                                                        {
                                                        	header:'<?php echo $etj["lblAsociadoA"]?>',
                                                            width:300,
                                                            dataIndex:'tipo'
                                                        }
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridTabla',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 2,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:550,
                                                            title:'<?php echo $etj["lblElijaSelect"]?>:'
                                                            
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
    var lblBtn='<?php echo $etj["lblFinalizar"] ?>';
    
    
	var cmbCampo=crearComboCampos();
    
    
    
    
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid,
                                                        {
                                                        	x:10,
                                                            y:320,
                                                        	xtype:'label',
                                                            html:'<b><?php echo $etj["lblCondicionF"]?>:  </b><br><br><font color="brown"><?php echo $etj["lblDonde"]?></font>'
                                                            
                                                            
                                                        },
                                                        cmbCampo,
                                                        {
                                                        	x:10,
                                                            y:365,
                                                        	xtype:'label',
                                                            html:'<font color="brown"><?php echo $etj["lblSea"]?>.</font>'
                                                            
                                                            
                                                        },
                                                        
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: lblBtn,
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        
                                                                        var filaSel= tblOpciones.getSelectionModel().getSelected();
                                                                        if(filaSel==null)
                                                                        {
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgErrDebeSSO"] ?>');
                                                                        	return;
                                                                        }
                                                                        var campoCondicion=cmbCampo.getValue();
                                                                        if(campoCondicion=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbCampo.getValue().focus(false,10);
                                                                            }
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["lblDebeSelCampo"] ?>',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var nomColumn=filaSel.get('campo');
                                                                        objFinal="{"+objFinal+','+'"controlDependiente":"'+nomColumn+'","condicion":"=","campoCondicion":"'+campoCondicion+'"}';
                                                                        
                                                                        guardarPregunta(objFinal,ventanaSelComboDep);
                                                                       
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelComboDep = new Ext.Window(
                                            {
                                                title: '<?php echo $etj["lblSelColuma"]?>',
                                                width: 600 ,
                                                height:480,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                          			    	
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaSelComboDep.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	
    
	cargarControlesSelect(alOpciones,idFormulario,ventanaSelComboDep,tabla,dsDatosCampos);
}

function cargarControlesSelect(almacen,idFormulario,ventana,tabla,almacenCampos)
{
	function funcResp()
    {
    	var arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
		{
            	var arrTablas=eval(arrResp[1]);
                var arrCampos=eval(arrResp[2]);
                almacen.loadData(arrTablas);
                almacenCampos.loadData(arrCampos);
               	ventana.show();
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=15&idFormulario='+idFormulario+'&tabla='+tabla,true);
}

var dsDatosCampos;

function crearComboCampos()
{
	var tEntradas=[];
	dsDatosCampos= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'tipo'}
																]
													}
												);
	dsDatosCampos.loadData(tEntradas);
	var comboDatos=document.createElement('select');
	var cmbDatos=new Ext.form.ComboBox	(
													{
														x:115,
														y:340,
														id:'idCmbCampo',
														mode:'local',
														emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
														store:dsDatosCampos,
														displayField:'tipo',
														valueField:'id',
														transform:comboDatos,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
														minListWidth:200
													}
												)
	return cmbDatos;	
}

function setEstadoSeleccionar()
{
	estado=1;
    gE('lblEstado').innerHTML='<?php echo $etj["lblMover"]?>';
}

function setEstadoMover()
{
	estado=2;
    gE('lblEstado').innerHTML='<?php echo $etj["lblSeleccionar"]?>';
}

function mostrarVentanaDisparadorCmbRadio()
{
	var gridElementos=crearGridElementosCombo();

	var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: [gridElementos]
												}
											);

	
	var ventanaDisparador = new Ext.Window(
											{
												title: '<?php echo $etj["lblIngresarD"]?>',
												width: 500,
												height:340,
												minWidth: 300,
												minHeight: 100,
												layout: 'fit',
												plain:true,
												modal:true,
												bodyStyle:'padding:5px;',
												buttonAlign:'center',
												items: form,
												buttons:	[
																{
																	id:'btnAceptar',
																	text: '<?php echo $etj["lblBtnAceptar"] ?>',
																	listeners:	{
																					click:function()
																						{
																							ventanaDisparador.close();
																							
																						}
																				}
																}
															]
											}
										);

	cargarValoresCombo(gridElementos.getStore(),idControlSel,ventanaDisparador);		
}

function cargarValoresCombo(dataSet,idGrupoElemento,ventana)
{
	
    function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	dataSet.loadData(eval(arrResp[1]));   
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=19&idGrupoElemento='+idGrupoElemento,true);
	ventana.show();
}

function crearGridElementosCombo()
{
	
	var dsNameDTD= 	[];					
    var alNameDTD=		new Ext.data.SimpleStore(
    											{
    												fields:	[
                                                    			{name: 'idGrupoElemento'},
    															{name: 'idValorOpcion'},
                                                                {name: 'valorOpcion'},
																{name: 'etapa'}
    														]
    											}
    										);
    alNameDTD.loadData(dsNameDTD);
	
	var comboEtapas=crearComboEtapas();
    
    
	var colM= new Ext.grid.ColumnModel   	(
												 	[
													 	{
															header:'<?php echo $etj["lblVOpcion"]?>',
															width:150,
															dataIndex:'valorOpcion'
														},
														{
															header:'<?php echo $etj["lblEEtapa"]?>',
															width:300,
															dataIndex:'etapa',
                                                            editor:comboEtapas,
                                                            renderer:renderizarEtapa
														}
													]
												);
											
	eGrid=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                    	id:'gridEtapas',
                                                        store:alNameDTD,
                                                        frame:true,
                                                        clicksToEdit: 1,
                                                        cm: colM,
                                                        height:250,
                                                        width:470
                                                    }
							                    );
	
    eGrid.on('afteredit',funcCambio);
    
	return eGrid;	
}	

function funcCambio(e)
{
	var obj='{"idGrupoElemento":"'+e.record.get('idGrupoElemento')+'","idFormulario":"<?php echo $idFormulario ?>","idEtapa":"'+e.value+'","idValor":"'+e.record.get('idValorOpcion')+'"}';
	
	function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=20&param='+obj,true);
}

function crearComboEtapas(id)
{
	var idCombo='idComboEtapas';
    if(id!=undefined)
    	idCombo=id;
	
	var dsDatos= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'tipo'}
																]
													}
												);
	dsDatos.loadData(arrEtapas);
	var comboEtapas=document.createElement('select');
	var cmbEtapas=new Ext.form.ComboBox	(
													{
														id:idCombo,
														mode:'local',
														emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
														store:dsDatos,
														displayField:'tipo',
														valueField:'id',
														transform:comboEtapas,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
                                                        width:120
													}
												)
	return cmbEtapas;	
}

function renderizarEtapa(valor)
{

	var x;
    for(x=0;x<arrEtapas.length;x++)
    {
    	if(arrEtapas[x][0]==valor)
        {
        	return arrEtapas[x][1];
        }
    }
	return '-1';
}

function mostrarRejila(check)
{
	var tdContenedor=gE('frameTitulo');
    var atClase;
    var cComp='';
    if(gE('verMarco').checked)
    	cComp='frameHijo';
    if(check.checked)
   	    setClase(tdContenedor,cComp+' gridRejilla');
    else
    	setClase(tdContenedor,cComp+' gridRejillaSinFondo');
}

var tipoCampoF;

function mostrarVentanaCondFiltro(objFinal,nomTabla)
{
	filtroUsuario=new Array();
    filtroMysql=new Array();
	var cmbCampo=crearComboGeneral('cmbCampo',null,'<?php echo $etj["lblElijaOpcion"]?>');
    cmbCampo.setPosition(10,40);
    cmbCampo.setWidth(180);
    
    function setCondicionValor(combo,registro,indice)
    {
    	var obj=eval('[{'+objFinal+'}]');
		var nTabla=obj[0].objTablaConf.tabla;
        var cmbCondicion=Ext.getCmp('cmbCondicion');
        var arr;
        cmbCondicion.reset();
        tipoCampoF=registro.get('comp1');
        switch(tipoCampoF)
        {
            case'optM':
            case 'optT':
                arr=arrCombo;
                mostrarCampoF('cmbValor');
                
                Ext.getCmp('cmbValor').reset();
                llenarOpciones(registro.get('id'),nTabla);
            break;
            case 'varchar':
                arr=arrVarchar;
                Ext.getCmp('txtValor').setValue('');
                mostrarCampoF('txtValor');
            break;
            case 'int':
                arr=arrInt;
                Ext.getCmp('intValor').setValue('0');
                mostrarCampoF('intValor');
            break;
            case 'decimal':
                arr=arrInt;
                Ext.getCmp('decValor').setValue('0.0');
                mostrarCampoF('decValor');
            break;
            case 'date':
                arr=arrInt;
                mostrarCampoF('dteValor');
            break;
        }
        cmbCondicion.getStore().loadData(arr);
        cmbCondicion.focus(false,10);
    }
    
    
    cmbCampo.on('select',setCondicionValor);
    var condicion=crearComboGeneral('cmbCondicion',null,'<?php echo $etj["lblElijaOpcion"]?>');
    condicion.setPosition(200,40);
    condicion.setWidth(125);
    
    function setFocoValor(combo,registro,indice)
    {
    	switch(tipoCampoF)
        {
            case'optM':
            case 'optT':
                Ext.getCmp('cmbValor').focus(false,10);
            break;
            case 'varchar':
            	Ext.getCmp('txtValor').focus(false,10);
            break;
            case 'int':
                Ext.getCmp('intValor').focus(false,10);
            break;
            case 'decimal':
                Ext.getCmp('decValor').focus(false,10);
            break;
            case 'date':
                Ext.getCmp('dteValor').focus(false,10);
            break;
        }
    	
    }
    
    condicion.on('select',setFocoValor);
    var valor=crearComboGeneral('cmbValor',null,'<?php echo $etj["lblElijaOpcion"]?>');
    valor.setPosition(335,40);
    valor.setWidth(185);
    
    var valorTxt=new Ext.form.TextField	(
    										{
                                            	id:'txtValor',
                                                width:130,
                                                x:335,
                                                y:40,
                                                hidden:true
                                                
                                            }	
    									)
    
    var valorDte=new Ext.form.DateField	(
    										{
                                            	id:'dteValor',
                                                width:100,
                                                x:335,
                                                y:40,
                                                hidden:true
                                            }
    									)
                                        
    var valorInt= new Ext.form.NumberField	(
                                                {
                                                    id:'intValor',
                                                    width:100,
                                                    x:335,
	                                                y:40,
                                                    hidden:true,
                                                    allowDecimals:false
                                                    
                                                }	
                                            )
                                            
	var valorDec= new Ext.form.TextField	(
                                                {
                                                    id:'decValor',
                                                    width:100,
                                                    x:335,
	                                                y:40,
                                                    hidden:true,
                                                    allowDecimals:true
                                                    
                                                }	
                                            )                                                                            
    
	var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                            
                                                        {
                                                            x:50,
                                                            y:15,
                                                            xtype:'label',
                                                            text:'<?php echo $etj["lblCampoF"]?>:'
                                                        },
                                                        cmbCampo,
                                                        {
                                                            x:225,
                                                            y:15,
                                                            xtype:'label',
                                                            text:'<?php echo $etj["lblCondicion"]?>:'
                                                        },
                                                        condicion,
                                                        {
                                                            x:375,
                                                            y:15,
                                                            xtype:'label',
                                                            text:'<?php echo $etj["lblValor"]?>:'
                                                        },
                                                        valor,
                                                        valorTxt,
                                                        valorDte,
                                                        valorInt,
                                                        valorDec,
                                                        {
                                                            xtype:'panel',
                                                            x:10,
                                                            y:80,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                            xtype:'button',
                                                                            text:'Agregar',
                                                                            icon:'../images/mas.gif',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                                    {
                                                                                        if(cmbCampo.getValue()=='')
                                                                                        {
                                                                                            function resp()
                                                                                            {
                                                                                                cmbCampo.focus(false,10);
                                                                                            }
                                                                                            Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblDebeSelCampo"]?>',resp);
                                                                                            return;
                                                                                        }
                                                                                        var campo=cmbCampo.getValue();
                                                                                        var condicionU;
                                                                                        var condicionM;
                                                                                        if(condicion.getValue()=='')
                                                                                        {
                                                                                            function resp()
                                                                                            {
                                                                                                condicion.focus(false,10);
                                                                                            }
                                                                                            Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblDebeSelCond"]?>',resp);
                                                                                            return;
                                                                                        }
                                                                                        condicionU=condicion.getRawValue();
                                                                                        condicionM=condicion.getValue();
                                                                                        var valorU='';
                                                                                        var valorM='';
                                                                                        
                                                                                        switch(tipoCampoF)
                                                                                        {
                                                                                            case 'optM':
                                                                                            case 'optT':
                                                                                                if(valor.getValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valor.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblDebeSelVal"]?>',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorM=valor.getValue();
                                                                                                valorU=valor.getRawValue();
                                                                                            break;
                                                                                            case 'varchar':
                                                                                                valorU="'"+valorTxt.getValue()+"'";
                                                                                                valorM="'"+valorTxt.getValue()+"'";
                                                                                            break;
                                                                                            case 'int':
                                                                                                if(valorInt.getValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valorInt.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblDebeSelVal"]?>',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorInt.getValue();
                                                                                                valorM=valorInt.getValue();
                                                                                                
                                                                                            break;
                                                                                            case 'decimal':
                                                                                                if(valorDec.getValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valorDec.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblDebeSelVal"]?>',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorDec.getValue();
                                                                                                valorM=valorDec.getValue();
                                                                                            break;
                                                                                            case 'date':
                                                                                                if(valorDte.getValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valorDte.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblDebeSelVal"]?>',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorDte.getValue().format('d/m/Y');
                                                                                                valorM="'"+valorDte.getValue().format('Y-m-d')+"'";
                                                                                                
                                                                                            break;
                                                                                            
                                                                                        }
                                                                                        var cadM=campo+' '+condicionM+' '+valorM;
                                                                                        var cadU=campo+' '+condicionU+' '+valorU;
                                                                                        filtroUsuario[filtroUsuario.length]=cadU;
                                                                                        filtroMysql[filtroMysql.length]=cadM;
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                            
                                                        
                                                               
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:100,
                                                            y:80,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                             xtype:'button',
                                                                             text:'Remover',
                                                                             icon:'../images/menos.gif',
                                                                             cls:'x-btn-text-icon',
                                                                             handler:function()
                                                                                    {
                                                                                        if(filtroUsuario.length>0)
                                                                                        {
                                                                                            filtroUsuario.splice(filtroUsuario.length-1,1);
                                                                                            filtroMysql.splice(filtroMysql.length-1,1);
                                                                                            generarSentencia();
                                                                                        }
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:195,
                                                            y:80,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                             xtype:'button',
                                                                             text:'(',
                                                                             handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='(';
                                                                                        filtroMysql[filtroMysql.length]='(';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:230,
                                                            y:80,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                             xtype:'button',
                                                                             text:')',
                                                                            handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]=')';
                                                                                        filtroMysql[filtroMysql.length]=')';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        
                                                        {
                                                            xtype:'panel',
                                                            x:265,
                                                            y:80,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                             xtype:'button',
                                                                             text:'Y',
                                                                            handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='<?php echo $etj["lblY"]?>';
                                                                                        filtroMysql[filtroMysql.length]='AND';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:300,
                                                            y:80,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                             xtype:'button',
                                                                             text:'O',
                                                                             handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='<?php echo $etj["lblO"]?>';
                                                                                        filtroMysql[filtroMysql.length]='OR';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            id:'txtConsulta',
                                                            xtype:'textarea',
                                                            x:10,
                                                            y:125,
                                                            width:500,
                                                            height:150,
                                                            readOnly:true
                                                        }
                                                    ]
                                        }
                                    );
		
	var ventanaOrigenDatosSel = new Ext.Window(
											{
												title: '<?php echo $etj["lblTitCondF"]?>',
												width: 550,
												height:350,
												minWidth: 300,
												minHeight: 100,
												layout: 'fit',
												plain:true,
												modal:true,
												bodyStyle:'padding:5px;',
												buttonAlign:'center',
												items: form,
												buttons:	[
																{
																	id:'btnAceptar',
																	text: '<?php echo $etj["lblFinalizar"] ?>',
																	listeners:	{
																					click:function()
																						{
                                                                                            function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                 
                                                                                                 	var x;
                                                                                                    var token;
                                                                                                    var arrTokens='';
                                                                                                    for(x=0;x<filtroUsuario.length;x++)
                                                                                                    {
                                                                                                    	token='{"tokenUsuario":"'+cv(filtroUsuario[x])+'","tokenMysql":"'+cv(filtroMysql[x])+'"}';
                                                                                                        if(arrTokens=='')
                                                                                                        	arrTokens=token;
                                                                                                        else
                                                                                                        	arrTokens+=','+token;
                                                                                                    }
                                                                                                    objFinal+=',"tokenSql":['+arrTokens+']';
                                                                                                    objFinal="{"+objFinal+"}";
                                                                                                    
                                                                                                    guardarPregunta(objFinal,ventanaOrigenDatosSel);
                                                                                                    
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblErrorSintaxis"]?>');
                                                                                                    return;
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=27&tb='+nomTabla+'&qry='+sentenciaMysql,true);
                                                                                            
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventanaOrigenDatosSel.close();
																			}
																}
															]
											}
										);
                                        
	cargarCamposTabla(ventanaOrigenDatosSel,objFinal);
}

function cargarCamposTabla(ventana,objFinal)
{
	var obj=eval('[{'+objFinal+'}]');
	var nTabla=obj[0].objTablaConf.tabla;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	 var arr=arrResp[2];
             var objArr=eval(arr);
             var cmbCampo=Ext.getCmp('cmbCampo');
             var dSet=cmbCampo.getStore();
             dSet.loadData(objArr);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=25&nomTabla='+nTabla,true);
	ventana.show();
}

var arrVarchar=[['<>','<?php echo $etj["lblDistintoA"]?>'],['=','<?php echo $etj["lblIgualA"]?>']];
var arrInt=[['>','<?php echo $etj["lblMayor"]?>'],['>=','<?php echo $etj["lblMayorIgualQ"]?>'],['<','<?php echo $etj["lblMenorA"]?>'],['<=','<?php echo $etj["lblMenorIgualQ"]?>'],['<>','<?php echo $etj["lblDistintoA"]?>'],['=','<?php echo $etj["lblIgualA"]?>']];
var arrCombo=[['<>','<?php echo $etj["lblDistintoA"]?>'],['=','<?php echo $etj["lblIgualA"]?>']];

function mostrarCampoF(idCampo)
{
	Ext.getCmp('cmbValor').hide();
	Ext.getCmp('txtValor').hide();
    Ext.getCmp('dteValor').hide();
    Ext.getCmp('intValor').hide();
    Ext.getCmp('decValor').hide();
    Ext.getCmp(idCampo).show();
}

function llenarOpciones(campo,tabla)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
     		Ext.getCmp('cmbValor').getStore().loadData(datos);		   	  
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=26&tb='+tabla+'&campo='+campo,true);
}

var sentenciaMysql;

function generarSentencia()
{
	var x;
    var txtConsulta='';
    sentenciaMysql='';
	for(x=0;x<filtroUsuario.length;x++)
    {
    	txtConsulta+=' '+filtroUsuario[x];
        sentenciaMysql+=' '+filtroMysql[x];
    }
    Ext.getCmp('txtConsulta').setValue(txtConsulta);
}

function mostrarVentanaAyuda()
{
	var img=gE('imgAyuda_'+idControlSel);
    cargarDatos=false;
    if(img!=null)
    	cargarDatos=true;

    function obtenerIdiomas()
    {
        var resp=eval(peticion_http.responseText);
        var tblAyuda=crearGridAyuda(resp);
        var form = new Ext.form.FormPanel(	
                                                {
                                                    baseCls: 'x-plain',
                                                    layout:'absolute',
                                                    defaultType: 'textfield',
                                                    items: 	[
                                                                tblAyuda	
                                                            ]
                                                }
                                            );
        
            ventanaAyuda = new Ext.Window(
                                            {
                                                title: '<?php echo $etj["titMsgAyuda"]?>',
                                                width: 630,
                                                height:250,
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
                                                                            pIdioma=obtenerPosFila(alNameDTD,'idIdioma',gE('hLeng').value);
                                                                            if(pIdioma!=-1)
                                                                            {
                                                                                tblFrmDTD.startEditing(pIdioma,1);
                                                                            }
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                               
                                                                {
                                                                    text: '<?php echo $etj["lblBtnAceptar"] ?>',
                                                                    id:'btnFinalizarAyuda',
                                                                    listeners:
                                                                                {
                                                                                    click:	{
                                                                                                fn:function()
                                                                                                    {
                                                                                                        if(validarDatosGridAyuda(tblAyuda.getStore(),'msgAyuda',gE('hLeng').value))
                                                                                                        {
                                                                                                        	
                                                                                                            var cuerpo='';
                                                                                                            var ct=tblAyuda.getStore().getCount();
                                                                                                            var reg;
                                                                                                            var cadTemp='';
                                                                                                            for(x=0;x<ct;x++)
                                                                                                            {
                                                                                                                reg=tblAyuda.getStore().getAt(x);
                                                                                                                cadTemp='{"idIdioma":"'+cv(reg.get('idIdioma'))+'","msgAyuda":"'+cv(reg.get('msgAyuda'))+'"}';
                                                                                                                if(cuerpo=='')
                                                                                                                    cuerpo=cadTemp;
                                                                                                                else
                                                                                                                    cuerpo+=','+cadTemp;
                                                                                                            }
                                                                                                            
                                                                                                           	
                                                                                                            obj='{"idGrupoElemento":"'+cv(idControlSel)+'","arrMsg":['+cuerpo+']}';
                                                                                                            function funcAjax()
                                                                                                            {
                                                                                                                var resp=peticion_http.responseText;
                                                                                                                arrResp=resp.split('|');
                                                                                                                if(arrResp[0]=='1')
                                                                                                                {
                                                                                                                	var idIdioma=gE('hIdidioma').value;
                                                                                                                	var objJson=eval('['+obj+']')[0];
                                                                                                                    var arrMsg=objJson.arrMsg;
                                                                                                                    var z;
                                                                                                                    msgAyuda='';
                                                                                                                    for(z=0;z<arrMsg.length;z++)
                                                                                                                    {
                                                                                                                    	if(arrMsg[z].idIdioma==idIdioma)
                                                                                                                        {
                                                                                                                        	msgAyuda=dv(arrMsg[z].msgAyuda);
                                                                                                                            break;
                                                                                                                        }
                                                                                                                    }
                                                                                                                    var spAyuda=gE('spAyuda_'+idControlSel);
                                                                                                                    var padreSp=spAyuda.parentNode;
                                                                                                                    padreSp.removeChild(spAyuda);
                                                                                                                    var spAyuda=document.createElement('span');
                                                                                                                    spAyuda.id='spAyuda_'+idControlSel;
                                                                                                                    var imagen=document.createElement('img');
                                                                                                                    if(Ext.isIE)
                                                                                                                    {
                                                                                                                        imagen.style.height=16;
                                                                                                                        imagen.style.width=16;
                                                                                                                    }
                                                                                                                    else
                                                                                                                    {
                                                                                                                        imagen.setAttribute('width',16);
                                                                                                                        imagen.setAttribute('height',16);
                                                                                                                    }
                                                                                                                    imagen.src='../images/formularios/sInterrogacion.jpg';
                                                                                                                    imagen.title=msgAyuda;
                                                                                                                    imagen.alt=msgAyuda;
                                                                                                                    imagen.id='imgAyuda_'+idControlSel;
                                                                                                                    spAyuda.appendChild(imagen);
                                                                                                                    padreSp.appendChild(spAyuda);
                                                                                                                    mE('btnDelAyuda');
                                                                                                                 	ventanaAyuda.close();  
                                                                                                                }
                                                                                                                else
                                                                                                                {
                                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                }
                                                                                                            }
                                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=28&param='+obj,true);
                                                                                                        }
                                                                                                    }
                                                                                            }
                                                                                }
                                                                },
                                                                {
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                        ventanaAyuda.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
        if(cargarDatos==true)                              
			llenarDatosAyuda(ventanaAyuda);                                        
        else
        	ventanaAyuda.show();
        

    }
    obtenerDatosWeb('../paginasFunciones/funciones.php',obtenerIdiomas, 'POST','funcion=4',true);
	
}

function llenarDatosAyuda(ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrMsg=eval(arrResp[1]);
            var x;
            var idIdioma;
            var msg;
            var gridAyuda=Ext.getCmp('gridAyuda');
            var almacen=gridAyuda.getStore();
            for(x=0;x<arrMsg.length;x++)
            {
            	idIdioma=arrMsg[x][0];
                msg=arrMsg[x][1];
                
                asignarMensajeAyuda(idIdioma,msg,almacen);
                ventana.show();
                
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=30&idGrupoElemento='+idControlSel,true);
}

function asignarMensajeAyuda(idIdioma,msg,almacen)
{
	var x;
    var nFilas=almacen.getCount();
    var fila;
    for(x=0;x<nFilas;x++)
    {
    	fila=almacen.getAt(x);
        if(fila.get('idIdioma')==idIdioma)
        {
        	fila.set('msgAyuda',msg);
            break;
        }
    }
}

function crearGridAyuda(datos)
{
	var dsNameDTD= 	[];					
    alNameDTD=		new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idioma'},
																{name: 'idIdioma'},
																{name: 'msgAyuda'},
    														]
    											}
    										);
    alNameDTD.loadData(dsNameDTD);
	llenarDatosGridAyuda(datos);
	
	var cmFrmDTD= new Ext.grid.ColumnModel   	(
												 	[
													 	{
															header:'<?php echo $etj["lblLenguaje"]?>',
															width:80,
															dataIndex:'idioma',
															renderer: cambiarColor
														},
														{
															header:'<?php echo $etj["msgAyuda"]?>',
															width:500,
															dataIndex:'msgAyuda',
															editor: new Ext.form.TextField   (
																									{
																									   
																									   style: 'text-align:left'
																									}
																								)
														}
													]
												);
											
	tblFrmDTD=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                    	id:'gridAyuda',
                                                        store:alNameDTD,
                                                        frame:true,
                                                        clicksToEdit: 1,
                                                        cm: cmFrmDTD,
                                                        height:150,
                                                        width:600
                                                    }
							                    );
	
	return tblFrmDTD;	
}	

function llenarDatosGridAyuda(datos)
{
	for (x=0;x<datos.length;x++)
	{
		
		var FilaRegistro = new rgIdiomas(
                                            {
                                                    idioma:datos[x].imagen,
                                                    idIdioma: datos[x].idIdioma,
                                                    msgAyuda: datos[x].msgAyuda

                                               }
                                          );
                                                  
        alNameDTD.add(FilaRegistro); 
	}
}

function validarGAyuda(dSet,columna,idIdioma)
{
	var fila;
	var nomDefault=false;
	var ct=0;
	for(x=0;x<dSet.getCount();x++)
	{
		fila=dSet.getAt(x);
		if(trim(fila.get(columna))!='')
		{
			if(fila.get('idIdioma')==idIdioma)
				nomDefault=true;
			ct++;
		}
	}
	if(dSet.getCount()==ct)
		return 0; //Sin problemas
	
	if(!nomDefault)
		return 1; //El nombre en idioma original no fue especificado
	
	return 2;
}

function validarDatosGridAyuda(dSet,columna,idIdioma)
{
	var res=validarGAyuda(dSet,columna,idIdioma);
	switch(res)
	{
		case 0: //Sin problemas
			return true;	
		break;
		case 1: //El nombre en idioma original no fue especificado
		
			function funcAceptar()
			{
				pIdioma=obtenerPosFila(dSet,'idIdioma',gE('hLeng').value);
				if(pIdioma!=-1)
				{
					tblFrmDTD.startEditing(pIdioma,1);
				}
				return false;
			}
			Ext.Msg.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgErrorAyuda"] ?>',funcAceptar);
			
		break;
		case 2:
			function funcConfirmacion(btn)
			{
				if(btn=='yes')
				{
					var fIdioma=obtenerFilaIdioma(dSet,gE('hLeng').value);
					rellenarValoresVacios(dSet,'msgAyuda','['+fIdioma.get('msgAyuda')+']');
					Ext.getCmp('btnFinalizarAyuda').fireEvent('click');
				}
				else
					return false;
			}
			Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>', '<?php echo $etj["msgErrorAyuda2"] ?>', funcConfirmacion);
		break;
	}
}

function eliminarAyuda()
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
    				var spAyuda=gE('spAyuda_'+idControlSel);
                    var padreSp=spAyuda.parentNode;
                    padreSp.removeChild(spAyuda);
                    var spAyuda=document.createElement('span');
                    spAyuda.id='spAyuda_'+idControlSel;
                    padreSp.appendChild(spAyuda);
   					oE('btnDelAyuda');
	            }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=29&idGrupoElemento='+idControlSel,true);
        }
    }
    Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgConfDelAyuda"]?>',resp);
}

var arrConsulta;

function mostrarVentanaCampoOperacion(idControl)
{
	
	var soloLectura=false;
    var valor='';
    var accion='-1';
    if(idControl!=undefined)
    {
    	soloLectura=true;
        valor=idControl;
		accion=idControlSel;
    }
    
	arrConsulta=new Array();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                        	xtype:'label',
                                                            html:'<?php echo $etj["lblNomCampo"] ?>:'
                                                        },
                                                        {
                                                            id:'txtNombreCampo',
                                                            x:80,
                                                            y:10,
                                                            width:130,
                                                            hideLabel:true,
                                                            maskRe:/^[a-zA-Z0-9]$/,
                                                            disabled:soloLectura,
                                                            value:valor
                                                        }
														,
                                                        {
                                                            xtype:'panel',
                                                            x:10,
                                                            y:60,
                                                            tbar: 	[
                                                                                {
                                                                                  text:'Agregar valor',
                                                                                  icon:'../images/mas.gif',
                                                                                  cls:'x-btn-text-icon',
                                                                                  menu:	[
                                                                                              {
                                                                                              
                                                                                                  text:'Ingresado por m&iacute;',
                                                                                                  handler:function()
                                                                                                          {
                                                                                                              mostrarVentanaValor();
                                                                                                          }
                                                                                              },
                                                                                              {
                                                                                                  text:'Generado de una consulta',
                                                                                                  handler:	function()	
                                                                                                  			{
                                                                                                            	mostrarVentanaGenerarConsulta();
                                                                                                            }
                                                                                              },
                                                                                              {
                                                                                                  text:'De control de formulario',
                                                                                                  handler:function()	
                                                                                                  			{
                                                                                                            	mostrarVentanaControlFormulario();
                                                                                                            }
                                                                                                  
                                                                                              }
                                                                                              
                                                                                          ]
                                                                               },
                                                                                '-'
                                                                                ,
                                                                                
                                                                               {
                                                                                   xtype:'button',
                                                                                   text:'Remover',
                                                                                   icon:'../images/menos.gif',
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
                                                                                                arrValor[2]=1;
                                                                                                
                                                                                            
                                                                                                arrConsulta[arrConsulta.length]=arrValor;
                                                                                                
                                                                                                generarSentenciaConsultaOperacion();
                                                                                            }
                                                                                 },
                                                                                 '-',
                                                                                {
                                                                                   	xtype:'button',
                                                                                   	text:')',
                                                                                  	handler:function()
                                                                                          {
                                                                                              var arrValor=new Array();
                                                                                              arrValor[0]=')';
                                                                                              arrValor[1]=')';
                                                                                              arrValor[2]=1;
                                                                                              arrConsulta[arrConsulta.length]=arrValor;
                                                                                              generarSentenciaConsultaOperacion();
                                                                                          }
                                                                               } ,
                                                                                 '-'
                                                                                ,
                                                                               
                                                                                {
                                                                                     xtype:'button',
                                                                                     text:'+',
                                                                                     handler:function()
                                                                                            {
                                                                                            	var arrValor=new Array();
                                                                                                arrValor[0]='+';
                                                                                                arrValor[1]='+';
                                                                                                arrValor[2]=1;
                                                                                                arrConsulta[arrConsulta.length]=arrValor;
                                                                                                generarSentenciaConsultaOperacion();
                                                                                            }
                                                                                 },
                                                                                 '-'
                                                                                
                                                                               ,
                                                                                
                                                                                {
                                                                                   xtype:'button',
                                                                                   text:'-',
                                                                                   handler:function()
                                                                                          {
                                                                                              var arrValor=new Array();
                                                                                              arrValor[0]='-';
                                                                                              arrValor[1]='-';
                                                                                              arrValor[2]=1;
                                                                                              arrConsulta[arrConsulta.length]=arrValor;
                                                                                              generarSentenciaConsultaOperacion();
                                                                                          }
                                                                               },
                                                                                '-'
                                                                                ,
                                                                                {
                                                                                   xtype:'button',
                                                                                   text:'X',
                                                                                   handler:function()
                                                                                          {
                                                                                              var arrValor=new Array();
                                                                                              arrValor[0]='*';
                                                                                              arrValor[1]='X';
                                                                                              arrValor[2]=1;
                                                                                              arrConsulta[arrConsulta.length]=arrValor;
                                                                                              generarSentenciaConsultaOperacion();
                                                                                          }
                                                                               },
                                                                               '-'
                                                                               ,
                                                                                
                                                                                {
                                                                                   xtype:'button',
                                                                                   text:'/',
                                                                                   handler:function()
                                                                                          {
                                                                                              var arrValor=new Array();
                                                                                              arrValor[0]='/';
                                                                                              arrValor[1]='/';
                                                                                              arrValor[2]=1;
                                                                                              arrConsulta[arrConsulta.length]=arrValor;
                                                                                              generarSentenciaConsultaOperacion();
                                                                                          }
                                                                               }
                                                                                
                                                                	],
                                                                    
                                                                    
                                                            items:	[
                                                            			{
                                                                            id:'txtConsulta',
                                                                            xtype:'textarea',
                                                                            x:10,
                                                                            y:105,
                                                                            width:410,
                                                                            height:170,
                                                                            readOnly:true
                                                                        }
                                                            		]
                                                        }
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        
													]
										}
									);

	var ventana = new Ext.Window(
									{
										title: 'Insertar campo de operaci&oacute;n',
										width: 450,
										height:380,
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
																	Ext.getCmp('txtNombreCampo').focus();
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
																					var nombre=Ext.getCmp('txtNombreCampo').getValue();
                                                                                    if(nombre=='')
                                                                                    {
                                                                                    	function resp()
                                                                                        {
                                                                                        	Ext.getCmp('txtNombreCampo').focus();
                                                                                        }
                                                                                        msgBox('El ID del campo es obligatorio',resp);
                                                                                        return;
                                                                                    }
                                                                                    
                                                                                    var txtConsulta=Ext.getCmp('txtConsulta').getValue();
                                                                                    if(!validarConsulta(txtConsulta))
                                                                                    {
                                                                                    	function resp()
                                                                                        {
                                                                                        	Ext.getCmp('txtNombreCampo').focus();
                                                                                        }
                                                                                        msgBox('La expresi&oacute;n ingresada no es v&aacute;lida',resp);
                                                                                        return;
                                                                                    }
                                                                                    var x;
                                                                                    var arrTokens='';
                                                                                    var token='';
                                                                                    
                                                                                    if(validarExpresion(arrConsulta)=='NaN')
                                                                                    {
                                                                                    	msgBox('La expresi&oacute;n ingresada no es v&aacute;lida, favor de verificarla');
                                                                                    	return;
                                                                                    }
                                                                                    
                                                                                    for(x=0;x<arrConsulta.length;x++)
                                                                                    {
                                                                                    	token='{"tokenUsr":"'+cv(arrConsulta[x][1])+'","tokenApp":"'+cv(arrConsulta[x][0])+'","tipoToken":"'+cv(arrConsulta[x][2])+'"}';
                                                                                    	if(arrTokens=='')
                                                                                        	arrTokens=token;
                                                                                        else
                                                                                        	arrTokens+=','+token;
                                                                                    	
                                                                                    }
                                                                                    var idFormulario=gE('idFormulario').value;
                                                                                    var objFinal='{"idFormulario":"'+idFormulario+'","accion":"'+accion+'","nomCampo":"'+nombre+'","tipoElemento":"22","pregunta":"","obligatorio":"0","posX":"'+mitadX+'","posY":"'+mitadY+'","arrTokens":['+arrTokens+']}';
                                                                                    guardarPregunta(objFinal,ventana);
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
		if(accion=='-1')                                
			ventana.show();
        else
        	llenarConsultaCampoFormula(ventana);
}

function llenarConsultaCampoFormula(ventana)
{
	var div=gE(idDivSel);
    var nControl=div.getAttribute('controlInterno');
	var arrNom=nControl.split('_');
    var nombreCtrl='_'+arrNom[1];
	arrConsulta=eval(gE('exp_'+nombreCtrl).value);
    generarSentenciaConsultaOperacion();
	ventana.show();
}

function validarConsulta(consulta)
{
	return true;

}

//1 valor constante
//2 valor de campo
//3 valor de consulta

function generarSentenciaConsultaOperacion()
{
	var x;
    var txtConsulta='';
    sentenciaMysql='';
	for(x=0;x<arrConsulta.length;x++)
    {
    	txtConsulta+=' '+arrConsulta[x][1];
    }
    Ext.getCmp('txtConsulta').setValue(txtConsulta);
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
                                                            xtype:'numberfield',
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
																					var valor=Ext.getCmp('txtValorIns').getValue();
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
                                                                                    arrValor[0]= valor;
                                                                                    arrValor[1]= valor;
                                                                                    arrValor[2]= 1;
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

function mostrarVentanaControlFormulario()
{
	
	var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                        			{name:'id'},
                                                                 	{name:'campo'}
                                                                ]
                                                    }
                                                );
    
    
    var dsOpciones= [];
    
    alOpciones.loadData(dsOpciones);
    
    var chkModel=new Ext.grid.CheckboxSelectionModel();
    
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        chkModel,
                                                        {
                                                            header:'<?php echo $etj["lblCampo"]?>',
                                                            width:250,
                                                            dataIndex:'campo'
                                                        }
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridTabla',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 2,
                                                            cm: cmFrmDTD,
                                                            sm:chkModel,
                                                            height:300,
                                                            width:280
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
    
    
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        var fila=tblOpciones.getSelectionModel().getSelected();
                                                                        if(fila==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el campo a agregar');
                                                                        	return;
                                                                        }
                                                                        else
                                                                        {
                                                                        	var arrValor=new Array();
                                                                            arrValor[0]= fila.get('id');
                                                                            arrValor[1]= fila.get('campo');
                                                                            arrValor[2]= 2;
                                                                            arrConsulta[arrConsulta.length]=arrValor;
                                                                            generarSentenciaConsultaOperacion();
                                                                            ventanaSelCol.close();
                                                                        	
                                                                        }
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelCol = new Ext.Window(
                                            {
                                                title: 'Seleccione el campo que ser&aacute; su origen de datos',
                                                width: 320 ,
                                                height:400,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                          			    	   
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaSelCol.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
//	ventanaSelCol.show();
	cargarCamposForm(alOpciones,ventanaSelCol);	
}

function cargarCamposForm(dSet,ventana)
{
	var idFormulario=gE('idFormulario').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrCampos=eval(arrResp[1]);
            dSet.loadData(arrCampos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
     obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=40&idFormulario='+idFormulario,true);
}

function mostrarVentanaGenerarConsulta()
{
}

function validarExpresion(arrExp)
{
	var x;
    var expresionFinal='';
    for(x=0;x<arrExp.length;x++)
    {
    	if(arrExp[x][2]=='1')
        	expresionFinal+=arrExp[x][0];
        else
        {
        	if(arrExp[x][2]=='2')
            {
            	var valor=obtenerValorCampo(arrExp[x][0]);
                if (valor=="")
                	valor=0;
                expresionFinal+=valor;
            }
        }
    }
	try
    {
    	var resultado=eval(expresionFinal);
    }
    catch(e)
    {
    	var resultado='NaN';
    }
    return resultado;
}

function evaluarExpresion(control)
{
	var hExpresion=gE('exp_'+control);
    var arrExpresion=eval(hExpresion.value);
    
    var x;
    var expresionFinal='';
    for(x=0;x<arrExpresion.length;x++)
    {
    	if(arrExpresion[x][2]=='1')
        	expresionFinal+=arrExpresion[x][0];
        else
        {
        	if(arrExpresion[x][2]=='2')
            {
            	var valor=obtenerValorCampo(arrExpresion[x][0]);
                if (valor=="")
                	valor=0;
                expresionFinal+=valor;
            }
        }
    }
	try
    {
    	var resultado=eval(expresionFinal);
    }
    catch(e)
    {
    	var resultado='NaN';
    }
    var nDecimales=gE('numD_'+control).value;
    
    var nDecimales=gE('numD_'+control).value;
    var separadorMiles=gE('sepMiles_'+control).value;
    var separadorDecimales=gE('sepDec_'+control).value;
    var tratoDecimales=gE('tratoDec_'+control).value;
    var truncar=false;
    if(tratoDecimales=='2')
    	truncar=true;
    
    gE('lbl_'+control).innerHTML=formatearNumero(resultado,nDecimales,separadorDecimales,separadorMiles,truncar);	
    var ptrControl=gE(control);
    ptrControl.value=resultado;
    lanzarEvento(ptrControl,'change');
    
}

function obtenerValorCampo(campo)
{
	
	var control=gE(campo);
    var tipo=control.nodeName;
	switch(tipo)
	{
		case 'TEXTAREA':
		case 'INPUT':
			return control.value;
		break;
		case 'SELECT':
			return control.options[control.selectedIndex].value;
		break;
	}
}

function actualizarFocusEliminacion(vOrden)
{
	var x;
    var div;
    var orden;
    for(x=0;x<arrElementosFocus.length;x++)
    {
    	div=gE(arrElementosFocus[x]);
        orden=parseInt(div.getAttribute('orden'));
        if(orden>vOrden)
        	div.setAttribute('orden',(orden-1));
    }
}

function mostrarVentanaEstilos()
{
	controlVPActivo=1;
	var tblAtributos=crearGridAtributosEstilo();
    var panelVPrevia=new Ext.Panel	(
    								{
                                    	id:'panelVP',
                                    	x:485,
                                        y:50,
                                        width:220,
                                        height:220,
                                        title:'Vista previa',
                                        
                                        autoLoad: {url: '../estilos/vistaPreviaEstilos.php', params: 'control=1'},
                                        tbar:	[
                                        			{
                                                    	text:'Etiqueta',
                                                        handler:function()
                                                        		{
																	actualizarCss('estilo_tmp');
                                                                	Ext.getCmp('panelVP').load({url: '../estilos/vistaPreviaEstilos.php', params: 'control=1'});
                                                                    controlVPActivo=1;
                                                                }
                                                    },
                                                    {
                                                    	text:'Bot&oacute;n',
                                                        handler:function()
                                                        		{
                                                                	actualizarCss('estilo_tmp');
                                                                	Ext.getCmp('panelVP').load({url: '../estilos/vistaPreviaEstilos.php', params: 'control=2'});
                                                                    controlVPActivo=2;
                                                                }
                                                    },
                                                    {
                                                    	text:'Tabla',
                                                        handler:function()
                                                        		{
                                                                	actualizarCss('estilo_tmp');
                                                                	Ext.getCmp('panelVP').load({url: '../estilos/vistaPreviaEstilos.php', params: 'control=3'});
                                                                    controlVPActivo=3;
                                                                }
                                                    }
                                                    ,
                                                    {
                                                    	text:'Celda',
                                                        handler:function()
                                                        		{
                                                                	actualizarCss('estilo_tmp');
                                                                	Ext.getCmp('panelVP').load({url: '../estilos/vistaPreviaEstilos.php', params: 'control=4'});
                                                                    controlVPActivo=4;
                                                                }
                                                    }
                                        		]
                                    }
    							);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Nombre del estilo:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	x:130,
                                                            y:5,
                                                        	xtype:'textfield',
                                                            id:'txtNombreEstilo',
                                                            width:200,
                                                            maskRe:/^[a-zA-Z0-9\s]$/
                                                            
                                                        },
                                                        tblAtributos,
                                                        panelVPrevia
													]
										}
									);

	


	var ventana = new Ext.Window(
									{
										title: 'Crear estilo',
										width: 750,
										height:520,
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
                                                                        Ext.getCmp('txtNombreEstilo').focus(false,100);
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
                                                                                	var txtNombreEstilo=Ext.getCmp('txtNombreEstilo');
                                                                                    if(txtNombreEstilo.getValue()=='')
                                                                                    {
                                                                                    	function funcResp()
                                                                                        {
                                                                                        	txtNombreEstilo.focus();
                                                                                        }
                                                                                        
                                                                                    	msgBox('Debe ingresar el nombre del estilo a crear',funcResp);
                                                                                        return;
                                                                                    }
                                                                                    var cadEstilo=generarEstilo(txtNombreEstilo.getValue());
                                                                                    
                                                                                    function funcAjax()
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                        	if(arrResp[1]=='1')
																							{
                                                                                            	var almacen=Ext.getCmp('cmbEstilos').getStore();
                                                                                                var registro=new regCombo({id:txtNombreEstilo.getValue(),nombre:txtNombreEstilo.getValue(),valorComp:''});
                                                                                                almacen.add(registro);
	                                                                                            ventana.close();
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                            	function resp()
                                                                                                {
                                                                                                	txtNombreEstilo.focus();
                                                                                                }
                                                                                            	msgBox('El nombre de la clase ya se encuentra registrado, por favor ingrese uno diferente',resp);
                                                                                                return;
                                                                                            }                                                                                           
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=41&idEstilo=-1&defEstilo='+cadEstilo,true);
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

function formatearValor(value, metaData, record, rowIndex, colIndex, store)
{
	var x=0;
    for(x=0;x<arrSiNo.length;x++)
    {
    	if(arrSiNo[x][0]==value)
        	return arrSiNo[x][1];
    }
	return value;
	
}

function crearGridAtributosEstilo()
{
	
	var dsNameDTD= 	<?php echo $arrPropiedadesEst?>;					
    
    var lector=new Ext.data.ArrayReader({},	[	{name:'propiedadUsr'},
                                                {name: 'propiedadCss'},
                                                {name: 'categoria'},
                                                {name: 'valor'}
                                             ]
                                         );
    
	var cmFrmDTD= new Ext.grid.ColumnModel   	(
												 	[
													 	{
                                                        	id:'colAtributo',
															header:'Propiedad',
															width:210,
															dataIndex:'propiedadUsr'
														},
														{
                                                        	id:'colValor',
															header:'Valor',
															width:180,
															dataIndex:'valor',
                                                            editor:new Ext.form.TextField({})
														},
                                                        {
                                                        	id:'colCategoria',
															header:'catoger&iacute;a',
															width:180,
															dataIndex:'categoria',
                                                            hidden:true
														}
													]
												);
											
	tblFrmDTD=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                    	x:10,
                                                        y:50,
                                                        border:true,
                                                    	id:'gridAtributosEstilos',
                                                        store:new Ext.data.GroupingStore({
                                                                                            reader: lector,
                                                                                            data: dsNameDTD,
                                                                                            sortInfo:{field: 'propiedadUsr', direction: "ASC"},
                                                                                            groupField:'categoria'
                                                                                        }),
                                                        frame:true,
                                                        clicksToEdit: 1,
                                                        cm: cmFrmDTD,
                                                        height:370,
                                                        columnLines :true,
                                                        width:450,
                                                        view: new Ext.grid.GroupingView({
                                                                                            forceFit:true,
                                                                                            groupTextTpl: '{text}'
                                                                                        })
                                                    }
							                    );
	tblFrmDTD.on('beforeedit',funcEdicion);    
    tblFrmDTD.on('afteredit',funcEditado);                                                 
	return tblFrmDTD;	
}

var arrSiNoCss=<?php echo $arrSiNoCss?>;
var arrVAlineacion=<?php echo $arrVAlineacion?>;
var arrHAlineacion=<?php echo $arrHAlineacion?>;
var arrFuentes=<?php echo $arrFuentes?>;
var arrEstilosBorde=<?php echo $arrEstilosBorde?>;

function funcEdicion(e)
{
	var ctrlColor=new Ext.grid.GridEditor(new Ext.form.ColorField(	{
                                                                        id: 'color'
                                                                    }
                                                                 )
                                         );
	
	var ctrlNumero=new Ext.form.NumberField({allowDecimals:false,allowNegative:false});
    var ctrlNumeroF=new Ext.form.NumberField({allowDecimals:true,allowNegative:false});
    var ctrlImagen;
    var ctrlHorizontal=crearComboExt('cmbAHorizontal',arrHAlineacion);
    var ctrlVertical=crearComboExt('cmbAVertical',arrVAlineacion);
    var ctrlSiNo=crearComboExt('cmbSiNoAtt',arrSiNoCss);
    var ctrlFuente=crearComboExt('cmbFuentes',arrFuentes);
    var cmbEstilosB=crearComboExt('cmbEstilosB',arrEstilosBorde);
    
	var grid=e.grid;
    var cModel=grid.getColumnModel();
    var fila=e.record;
    var propiedad=fila.get('propiedadCss');
    switch(propiedad)
    {
    	case 'height':
        case 'width':
        case 'padding-right':
	    case 'padding-bottom':
        case 'padding-left':
        case 'padding-top':
        case 'border-right-width':
        case 'border-left-width':
        case 'border-bottom-width':
        case 'border-top-width':
        case 'font-size':
        	cModel.setEditor(1,ctrlNumero);
		break;
        case 'line-height':
        	cModel.setEditor(1,ctrlNumeroF);
        break;
        case 'text-decoration:underline':
        case 'font-weight:bold':
        case 'font-style:italic':
        	cModel.setEditor(1,ctrlSiNo);
        break;
        case 'text-align':
        	cModel.setEditor(1,ctrlHorizontal);
        break;
        case 'vertical-align':
        	cModel.setEditor(1,ctrlVertical);
        break;
        case 'font-family':
        	cModel.setEditor(1,ctrlFuente);
        break;
        case 'border-top-style':
        case 'border-bottom-style':
        case 'border-left-style':
        case 'border-right-style':
        	cModel.setEditor(1,cmbEstilosB);
        break;
        case 'border-bottom-color':
        case 'border-top-color':
        case 'border-right-color':
        case 'border-left-color':
        case 'color':
        case 'background-color':
        	cModel.setEditor(1,ctrlColor);
        break;
        default:
        	e.cancel=true;
    }
}	

function funcEditado(e)
{
    actualizarCss('estilo_tmp');
	Ext.getCmp('panelVP').load({url: '../estilos/vistaPreviaEstilos.php', params: 'control='+controlVPActivo});
}

function generarEstilo(nombreEstilo)
{
	var x;
    var dSet=Ext.getCmp('gridAtributosEstilos').getStore();
    var propiedad;
    var fila;
	var cuerpo='';
    var vPropiedad='';
    var estilo='';
    for(x=0;x<dSet.getCount();x++)
    {
    	fila=dSet.getAt(x);
        propiedad=fila.get('propiedadCss');
        valor=fila.get('valor');
        vPropiedad='';
        switch(propiedad)
        {
            case 'height':
            case 'width':
            case 'padding-right':
            case 'padding-bottom':
            case 'padding-left':
            case 'padding-top':
            case 'border-right-width':
            case 'border-left-width':
            case 'border-bottom-width':
            case 'border-top-width':
            case 'font-size':
               if((valor!='')&&(valor!='0'))
               		vPropiedad=propiedad+':'+valor+'px'+' !important';	
            break;
            case 'line-height':
               if((valor!='')&&(parseInt(valor)>0))
               		vPropiedad=propiedad+':'+valor+'px'+' !important';		
            break;
            case 'text-decoration:underline':
            case 'font-weight:bold':
            case 'font-style:italic':
            	if(valor=='Si')
                	vPropiedad=propiedad+' !important';	
            break;
            case 'text-align':
            	if(valor!='Normal')
                {
                	var pos=existeValorMatriz(arrHAlineacion,valor,0);
                    valor=arrHAlineacion[pos][2];
               		vPropiedad=propiedad+':'+valor+' !important';	
                }
            break;
            case 'vertical-align':
                if(valor!='Normal')
                {
                	var pos=existeValorMatriz(arrVAlineacion,valor,0);
                    valor=arrVAlineacion[pos][2];
                	vPropiedad=propiedad+':'+valor+' !important';	
                }
            break;
            case 'font-family':
               	vPropiedad=propiedad+':'+valor+' !important'	;
            break;
            case 'border-top-style':
            case 'border-bottom-style':
            case 'border-left-style':
            case 'border-right-style':
                if(valor!='Ninguno')
                {
                	var pos=existeValorMatriz(arrEstilosBorde,valor,0);
                    valor=arrEstilosBorde[pos][2];
                	vPropiedad=propiedad+':'+valor+' !important';		
                }
            break;
            case 'border-bottom-color':
            case 'border-top-color':
            case 'border-right-color':
            case 'border-left-color':
            case 'color':
            case 'background-color':
            	if((valor!=''))
               		vPropiedad=propiedad+':'+valor+' !important';		
               
            break;
            
        }
        
        if(vPropiedad!='')
        {
        	if(cuerpo=='')
            	cuerpo=vPropiedad;
            else
            	cuerpo+=';'+vPropiedad;
        }
        
	}    
    estilo='.'+nombreEstilo+'{'+cuerpo+'}';
    
    return estilo;
}

function actualizarCss(nEstilo)
{
	
	var tEstilo=gE(nEstilo);
    if(tEstilo!=null)
    	tEstilo.parentNode.removeChild(tEstilo);
	var estilo = document.createElement("style");
	estilo.type = "text/css";
    estilo.id=nEstilo;
    
    var contenido=generarEstilo(nEstilo);
    
    if (estilo.styleSheet)
   		estilo.styleSheet.cssText = contenido;
    else 
	   	estilo.appendChild(document.createTextNode(contenido));
    document.getElementsByTagName("head")[0].appendChild(estilo);

}

function mostrarVentanaImagenes()
{
    
    fp = new Ext.FormPanel	(
                                {
                                    fileUpload: true,
                                    width: 500,
                                    frame: true,
                                    bodyStyle: 'padding: 10px 10px 0 10px;',
                                    labelWidth: 100,
                                    defaults: 	{
                                                   
                                                    msgTarget: 'side'
                                                },
                            
                                    items:	[
                                    			{
														
														xtype: 'textfield',
														id: 'idControl',
                                                        width:130,
														fieldLabel: 'ID Control',
                                                        maskRe:/^[a-zA-Z0-9]$/
													
												},
                                                {
                                                    xtype: 'fileuploadfield',
                                                    id: 'form-file',
                                                    emptyText: 'Elija una Imagen',
                                                    fieldLabel: 'Imagen',
                                                    name: 'image',
                                                    buttonText: '',
                                                     width:'100%',
                                                    buttonCfg: 	{
                                                                    iconCls: 'upload-icon'
                                                                }
                                                },
                                                 {
                                                     xtype:'hidden',
                                                     name:'tipoArchivo',
                                                     value:1
                                                 }
                                                 
                                                 
                                            ]
                                }
                            );

    ventana=new Ext.Window(
                                {
                                    title:'Insertar Imagen',
                                    width:450,
                                    height:170,
                                    layout:'fit',
                                    buttonAlign:'center',
                                    items:[fp],
                                    modal:true,
                                    plain:true,
                                    listeners:
                                                {
                                                    show:
                                                            {
                                                                buffer:10,
                                                                fn:function()
                                                                        {
                                                                            
                                                                        }
                                                            }
                                                },
                                        buttons: 	[
                                                        {
                                                            text: 'Agregar',
                                                            handler: function()
                                                                    {
                                                                    	
                                                                        archivo=gE('form-file-file');
                                                                        archivoName=archivo.value;
                                                                        var extension = (archivoName.substring(archivoName.lastIndexOf("."))).toLowerCase();
                                                                        var idControl=Ext.getCmp('idControl').getValue();
                                                                        if(idControl=='')
                                                                        {
                                                                        	function respID()
                                                                            {
                                                                            	Ext.getCmp('idControl').focus();
                                                                            }
                                                                            msgBox('El ID del control es obligatorio',respID);
                                                                            return;
                                                                        }
                                                                        if(<?php echo $arrValidacion ?>)
                                                                        {
                                                                               fp.getForm().submit	(	
                                                                                                        {
                                                                                                            url: '../media/guardarImagenFormulario.php',
                                                                                                            waitMsg: 'Subiendo imagen...',
                                                                                                            success: function (fp,o)
                                                                                                            			{
                                                                                                                        	var idArchivo=o.result.idArchivo;
                                                                                                                            var ancho=o.result.ancho;
                                                                                                                            var alto=o.result.alto;
                                                                                                                            var objFinal='{"idFormulario":"'+idFormulario+'","pregunta":null,"tipoElemento":"23","nomCampo":"'+idControl+'","obligatorio":"0","posX":"'+mitadX+'","posY":"'+mitadY+'","idImagen":"'+idArchivo+'","confCampo":{"ancho":"'+ancho+'","alto":"'+alto+'"}}';
                                                                                                                            guardarPregunta(objFinal,ventana);
                                                                                                                            
                                                                                                                            
                                                                                                                        },
                                                                                                            failure: function (fp,o)
                                                                                                            		{
                                                                                                                    	function funcResp()
                                                                                                                        {
                                                                                                                            ventana.close();
                                                                                                                        }
                                                                                                                        Ext.MessageBox.alert(lblAplicacion,'No se ha podido guardar el archivo debido al siguiente problema: <br>'+o.result.error,funcResp);
                                                                                                                    }
                                                                                                        }
                                                                                                    );
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                            Ext.MessageBox.alert('Error de Archivo', 'El archivo ingresado no es v\u00e1lido');
                                                                        
                                                                        }
                                                            
                                                                    }
                                                        },
                                                        {
                                                            text: 'Cancelar',
                                                            handler: function()
                                                                    {
                                                                        ventana.close();
                                                                    }
                                                        }
                                                    ]
                                }
                           )
    ventana.show();
}

function mostrarVentanaAccion()
{
	var arbolAcciones=crearArbolAcciones();

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                        	html:'Acciones a realizar al seleccionar:'
                                                            
                                                        },
                                                        arbolAcciones

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Acciones del control',
										width: 730,
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
                                                                    	nodoArbolEventoSel=null;
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}

function crearArbolAcciones()
{
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'108',
                                                                    idControl:idControlSel
																},
													dataUrl:'../paginasFunciones/funcionesProyectos.php',
                                                    uiProviders:	{
                                                                        'col': Ext.ux.tree.ColumnNodeUI
                                                                    }
												}
											)	

    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'raizAcciones',
                                                      text:'Acciones',
                                                      draggable:false,
                                                      expanded :true
                                                  }
                                            )

	var panelArbol=new Ext.ux.tree.ColumnTree	(
                                                      {
                                                          id:'arbolAcciones',
                                                          title:' ',
                                                          useArrows:true,
                                                          autoScroll:true,
                                                          animate:false,
                                                          enableDD:true,
                                                          containerScroll:true,
                                                          height:290,
                                                          width:680,
                                                          root:raiz,
                                                          rootVisible:false,
                                                          loader: cargadorArbol,
                                                          columns:[
                                                                      {
                                                                          header:'Valor opci&oacute;n/Control',
                                                                          width:300,
                                                                          dataIndex:'text'
                                                                      },
                                                                       {
                                                                              header:'Tipo de control',
                                                                              width:120,
                                                                              dataIndex:'tipoControl'
                                                                      },
                                                                      {
                                                                      		header:'Acci&oacute;n',
                                                                            width:240,
                                                                            dataIndex:'accion'
                                                                      }
                                                                  ]
                                                      }
                                                  );                                                 	  
            
    panelArbol.expandAll();	
    panelArbol.on('click',funcClikArbol); 
    var panel=new Ext.Panel	(
        							{
                                    	id:'divPanel',
                                        x:10,
                                        y:45,
                                        items:	[
                                                    panelArbol
                                                ],
                                          tbar:	[
                                                  {
                                                      id:'btnAgregarOpcion',
                                                      tooltip:'Agregar opci&oacute;n de evento',
                                                      icon:'../images/add.png',
                                                      cls:'x-btn-text-icon',
                                                      handler:function()
                                                              {
                                                                  mostrarVentanaOpcionesEvento();
                                                              }
                                                  },
                                                  {
                                                      id:'btnAgregarCtrl',
                                                      tooltip:'Agregar acci&oacute;n sobre control',
                                                      icon:'../images/application_add.png',
                                                      cls:'x-btn-text-icon',
                                                      disabled:true,
                                                      handler:function()
                                                              {
                                                                  mostrarVentanaControlesAccion();
                                                              }
                                                  }
                                                  ,'-',
                                                  {
                                                      id:'btnRemoverOpcionesControl',
                                                      tooltip:'Remover Opci&oacute;n/Control',
                                                      icon:'../images/delete.png',
                                                      cls:'x-btn-text-icon',
                                                      handler:function()
                                                              {
                                                                  function respDel(btn)
                                                                  {
                                                                  	if(btn=='yes')
                                                                    {
                                                                    	var idElemento;
                                                                        if(nodoArbolEventoSel.attributes.tipo=='0')
                                                                        	idElemento=nodoArbolEventoSel.id;
                                                                        else
                                                                       		idElemento=nodoArbolEventoSel.attributes.idControl;
                                                                        
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	nodoArbolEventoSel.remove();
                                                                            	nodoArbolEventoSel=null;
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=114&tipo='+nodoArbolEventoSel.attributes.tipo+'&idElemento='+idElemento+'&idControl='+idControlSel,true);
                                                                    }
                                                                  }
                                                                  msgConfirm('Est&aacute; seguro de querer eliminar el elemento seleccionado?',respDel)
                                                                  
                                                                  
                                                              }
                                                  },
                                                  '-',
                                                  {
                                                      id:'btnCambiarAccion',
                                                      tooltip:'Modificar acci&oacute;n',
                                                      icon:'../images/pencil.png',
                                                      cls:'x-btn-text-icon',
                                                      disabled:true,
                                                      handler:function()
                                                              {
                                                                  mostrarVentanaModificarAccion();
                                                              }
                                                  }
                                                 
                                              ]
                                      }
                              )
    
    
       
    return panel;
}

var nodoArbolEventoSel=null;

function funcClikArbol(nodo)
{
	nodoArbolEventoSel=nodo;
	if(nodo.attributes.tipo==0)
    {
    	Ext.getCmp('btnAgregarCtrl').enable();
        Ext.getCmp('btnCambiarAccion').disable();
    }
    else
    {
   		Ext.getCmp('btnAgregarCtrl').disable(); 
        Ext.getCmp('btnCambiarAccion').enable();
    }
}

function mostrarVentanaOpcionesEvento()
{
	var gridOpcionesCtrl=crearGridOpcionesControl();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	html:'Seleccione las opci&oacute;nes del control,que desea considerar para sus acciones de evento:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        gridOpcionesCtrl

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Opciones del control',
										width: 360,
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
																		var filas=gridOpcionesCtrl.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar una elemento');
                                                                            return;
                                                                        }
                                                                        var listaValores='';
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(listaValores=='')
                                                                            	listaValores=filas[x].get('idOpcion');
                                                                            else
                                                                            	listaValores+=','+filas[x].get('idOpcion');
                                                                        }
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            var arbol=Ext.getCmp('arbolAcciones');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	arbol.getRootNode().reload();
                                                                                arbol.expandAll();
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=110&lOpciones='+listaValores+'&idControl='+idControlSel,true);
                                                                        
                                                                        
                                                                        
                                                                        
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
	
    llenarOpcionesControl(ventanaAM);
}

function crearGridOpcionesControl()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idOpcion'},
                                                                {name: 'opcion'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Opci&oacute;n',
															width:240,
															sortable:true,
															dataIndex:'opcion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOpcionesCtrl',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:310,
                                                            width:335,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function llenarOpcionesControl(ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	Ext.getCmp('gridOpcionesCtrl').getStore().loadData(eval(arrResp[1]));
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=109&idControl='+idControlSel,true);
}

function mostrarVentanaControlesAccion()
{
	var gridOpcionesCtrl=crearGridControlesAccion();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	html:'Seleccione los controles,que desea considerar para sus acciones:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        gridOpcionesCtrl
                                                        ,
                                                        {
                                                        	x:10,
                                                            y:290,
                                                            xtype:'fieldset',
                                                            title:'Opciones de visibilidad',
                                                            width:510,
                                                            height:65,
                                                        	items:[
                                                                        {
                                                                        	id:'rdoVisibilidad',
                                                                            xtype:'radiogroup',
                                                                            hideLabel:true,
                                                                            items:	[
                                                                                        {boxLabel: 'Ocultar control', name: 'accionOcultar', inputValue: 'O'},
                                                                                        {boxLabel: 'Mostrar control', name: 'accionOcultar', inputValue: 'M'},
                                                                                        {boxLabel: 'Ninguno', name: 'accionOcultar', inputValue: '',  checked: true}
                                                                                    ]
                                                                        }
                                                                  ]
                                                         }
                                                        ,
                                                        {
															x:10,
                                                            y:360,
                                                            xtype:'fieldset',
                                                            title:'Opciones de edici&oacute;n',
                                                            width:510,
                                                            height:65,
                                                        	items:[
                                                                        {
                                                                        	id:'rdoEdicion',
                                                                            xtype:'radiogroup',
                                                                            hideLabel:true,
                                                                            items:	[
                                                                                        {boxLabel: 'Habilitar control', name: 'accionEdicion', inputValue: 'H'},
                                                                                        {boxLabel: 'Deshabilitar control', name: 'accionEdicion', inputValue: 'D'},
                                                                                        {boxLabel: 'Ninguno', name: 'accionEdicion', inputValue: '',  checked: true}
                                                                                    ]
                                                                        }
                                                                  ]
                                                         }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de controles de acci&oacute;n',
										width: 550,
										height:510,
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
																		var filas=gridOpcionesCtrl.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar una elemento');
                                                                            return;
                                                                        }
                                                                        var listaValores='';
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(listaValores=='')
                                                                            	listaValores=filas[x].get('idControl');
                                                                            else
                                                                            	listaValores+=','+filas[x].get('idControl');
                                                                        }
                                                                        
                                                                        var opcionV=Ext.getCmp('rdoVisibilidad').getValue().getRawValue();
                                                                        var opcionE=Ext.getCmp('rdoEdicion').getValue().getRawValue();
                                                                        var listaAccion=opcionV+opcionE;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            var arbol=Ext.getCmp('arbolAcciones');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	arbol.getRootNode().reload();
                                                                                arbol.expandAll();
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=112&lControles='+listaValores+'&listaAccion='+listaAccion+'&idControl='+idControlSel+'&valorOpt='+nodoArbolEventoSel.id,true);
                                                                        
                                                                        
                                                                        
                                                                        
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
	
    llenarControlesAccion(ventanaAM);
}

function crearGridControlesAccion()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idControl'},
                                                                {name: 'control'},
                                                                {name: 'tipoElemento'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Control',
															width:240,
															sortable:true,
															dataIndex:'control'
														},
                                                        {
                                                        	header:'Tipo',
															width:190,
															sortable:true,
															dataIndex:'tipoElemento'
                                                        }
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCtrlAccion',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:230,
                                                            width:520,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function llenarControlesAccion(ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	Ext.getCmp('gridCtrlAccion').getStore().loadData(eval(arrResp[1]));
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=111&idControl='+idControlSel+'&valorOpt='+nodoArbolEventoSel.id+'&idFormulario='+idFormulario,true);
}

function mostrarVentanaModificarAccion()
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
                                                            xtype:'fieldset',
                                                            title:'Opciones de visibilidad',
                                                            width:450,
                                                            height:65,
                                                        	items:[
                                                                        {
                                                                        	id:'rdoVisibilidad',
                                                                            xtype:'radiogroup',
                                                                            hideLabel:true,
                                                                            items:	[
                                                                                        {boxLabel: 'Ocultar control', name: 'accionOcultar', id:'rdoOcultar', inputValue: 'O'},
                                                                                        {boxLabel: 'Mostrar control', name: 'accionOcultar', id:'rdoMostrar',inputValue: 'M'},
                                                                                        {boxLabel: 'Ninguno', name: 'accionOcultar',id:'rdoNinguno', inputValue: ''}
                                                                                    ]
                                                                        }
                                                                  ]
                                                         }
                                                        ,
                                                        {
															x:10,
                                                            y:90,
                                                            xtype:'fieldset',
                                                            title:'Opciones de edici&oacute;n',
                                                            width:450,
                                                            height:65,
                                                        	items:[
                                                                        {
                                                                        	id:'rdoEdicion',
                                                                            xtype:'radiogroup',
                                                                            hideLabel:true,
                                                                            items:	[
                                                                                        {boxLabel: 'Habilitar control', name: 'accionEdicion',id:'rdoHabilitar', inputValue: 'H'},
                                                                                        {boxLabel: 'Deshabilitar control', name: 'accionEdicion',id:'rdoDeshabilitar', inputValue: 'D'},
                                                                                        {boxLabel: 'Ninguno', name: 'accionEdicion', id:'rdoNingunoE',inputValue: ''}
                                                                                    ]
                                                                        }
                                                                  ]
                                                         }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar acci&oacute;n',
										width: 500,
										height:260,
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
                                                                    	var opcionV=Ext.getCmp('rdoVisibilidad').getValue().getRawValue();
                                                                        var opcionE=Ext.getCmp('rdoEdicion').getValue().getRawValue();
                                                                        var listaAccion=opcionV+opcionE;
                                                                        var arbol=Ext.getCmp('arbolAcciones');
                                                                        
																		function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	arbol.getRootNode().reload();
                                                                                arbol.expandAll();
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=113&idAccion='+nodoArbolEventoSel.attributes.idControl+'&listaAccion='+listaAccion,true);	
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
    var codAccion=nodoArbolEventoSel.attributes.codAccion;
    var rdoOcultar=false;
    var rdoMostrar=false;
    var rdoNinguno=false;
    ventanaAM.show();
    
   
    if(codAccion.indexOf('O')!=-1)
    {
    	rdoOcultar=true;
        Ext.getCmp('rdoOcultar').setValue(true);
        
    }
    if(codAccion.indexOf('M')!=-1)
    {
    	rdoMostrar=true;
        Ext.getCmp('rdoMostrar').setValue(true);
    }
    if(!rdoOcultar&&!rdoMostrar)
    {
    	rdoNinguno=true;
        Ext.getCmp('rdoNinguno').setValue(true);
    }
    
    
    var rdoHabilitar=false;
    var rdoDesHabilitar=false;
    var rdoNingunoE=false;
    
    if(codAccion.indexOf('H')!=-1)
    {
    	rdoHabilitar=true;
        Ext.getCmp('rdoHabilitar').setValue(true);
    }
    if(codAccion.indexOf('D')!=-1)
    {
    	rdoDesHabilitar=true;
        Ext.getCmp('rdoDeshabilitar').setValue(true);
    }
    if(!rdoHabilitar&&!rdoDesHabilitar)
    {
    	rdoNingunoE=true;
        Ext.getCmp('rdoNingunoE').setValue(true);
    }
    
	
}

function mostrarMarco(check)
{
	var idFormulario=gE('idFormulario').value;
	var tdContenedor=gE('frameTitulo');
    var atClase;
    var cComp='';
    var valor;
    if(gE('verGrid').checked)
    	cComp='gridRejilla';
    else
   		cComp='gridRejillaSinFondo';
    if(check.checked)
    {
   	    setClase(tdContenedor,'frameHijo '+cComp);
        gE('lblLegend').innerHTML='<b>'+gE('titulo').value+'</b>';
        valor=1;
    }
    else
    {
    	setClase(tdContenedor,cComp);
        gE('lblLegend').innerHTML='';
        valor=0;
    }
    
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
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=47&idFormulario='+idFormulario+'&valor='+valor,true);

    
}

function campoDescriptivoChange(combo)
{
	var idFormulario=gE('idFormulario').value;
	var campo='';
    if(combo.selectedIndex!=0)
    {
    	campo=combo.options[combo.selectedIndex].value;
    }
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
            combo.selectedIndex=0;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=48&idFormulario='+idFormulario+'&campo='+campo,true);   
}

function mostrarVentanaNombreGrid(iE)
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
                                                            html:'Ingrese el ID del Grid:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:5,
                                                            id:'txtID',
                                                            xtype:'textfield',
                                                            width:250,
                                                            maskRe:/^[a-zA-Z0-9]$/
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Ingrese ID de Grid',
										width: 430,
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
                                                                	gEx('txtID').focus(500);
																}
															}
												},
										buttons:	[
														{
															
															text: 'Siguiente >>',
															handler: function()
																	{
																		var txtId=gEx('txtID');
                                                                        if(txtId.getValue()=='')
                                                                        {
                                                                        	function funcResp()
                                                                            {
                                                                            	txtId.focus();
                                                                            }
                                                                        	msgBox('De ingresar el ID del grid',funcResp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var id=gE(txtId.getValue());
                                                                        if(id!=null)
                                                                        {
                                                                        	msgBox('El ID ingresado ya est&aacute; siendo usado por otro elemento del formulario');
                                                                        	return;
                                                                        }
                                                                        
                                                                        mostrarVentanaConfiguracionGrid(txtId.getValue(),iE);
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


function mostrarVentanaConfiguracionGrid(nID,iE)
{
	var gridConf=crearGridConfiguracionCampoGrid(nID,iE);
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridConf
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configurar grid',
										width: 880,
										height:460,
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
																		if(iE!=-1)
                                                                        {
                                                                        	ventanaAM.close();
                                                                        }
                                                                        else
                                                                        {
                                                                        	var idFormulario=gE('idFormulario').value;
                                                                            var x;
                                                                            var cadObj='';
                                                                            var obj;
                                                                            var fila;
                                                                            var cadObj=obtenerConfColumnasCamposGrid(iE,nID);
                                                                            var posX=mitadX-280;
                                                                            var posY=mitadY-150;
                                                                            cadObj='{"posX":"'+posX+'","posY":"'+posY+'","idFormulario":"'+idFormulario+'","nID":"'+nID+'","arrCampos":['+cadObj+']}';
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	crearControlGridFormulario(cadObj,arrResp[1],'_'+nID);
                                                                                	ventanaAM.close();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=56&cadObj='+cadObj,true);

                                                                        	 
                                                                           
                                                                           
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
	if(iE==-1)                              
		ventanaAM.show();	
    else
    {
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                ventanaAM.show();	
            	gEx('gridCampoGrid').getStore().loadData(eval(arrResp[1]));
            	
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=57&idElemento='+iE,true);
    }
}


function obtenerConfColumnasCamposGrid(iE,nID)
{
	var obj;
    var cadObj='';
    var gridConf=gEx('gridCampoGrid');
    var idFormulario=gE('idFormulario').value;
    
	for(x=0;x<gridConf.getStore().getCount();x++)
    {
        fila=gridConf.getStore().getAt(x);
        
         obj='{"idFormulario":"'+idFormulario+'","idElemento":"'+iE+'","idControl":"'+nID+'","idCampo":"'+fila.get('idCampo')+'","cabecera":"'+cv(fila.get('cabecera'))+'","ancho":"'+fila.get('ancho')+
                '","tipoCampo":"'+fila.get('tipoCampo')+'","obligatorio":"'+fila.get('obligatorio')+'",'+
               '"tablaOriginalVinculada":"'+fila.get('tablaOriginalVinculada')+'","tablaVinculada":"'+fila.get('tablaVinculada')+'","campoVinculado":"'+fila.get('campoVinculado')+'",'+
               '"campoUsrVinculado":"'+fila.get('campoUsrVinculado')+'","campoLlave":"'+fila.get('campoLlave')+'","campoUsrLlave":"'+fila.get('campoUsrLlave')+'","visible":"'+fila.get('visible')+'"}';
        if(cadObj=='')
            cadObj=obj;
        else
            cadObj+=','+obj;
              
    }
    return cadObj;
}

var arrCamposGrid=[
					  {name: 'idRegistroCampo'},
					  {name: 'idCampo'},
                      {name: 'cabecera'},
                      {name: 'ancho'},
                      {name: 'tipoCampo'},
                      {name: 'obligatorio'},
                      {name: 'tablaVinculada'},
                      {name: 'tablaOriginalVinculada'},
                      {name: 'campoVinculado'},
                      {name: 'campoUsrVinculado'},
	                  {name: 'campoUsrLlave'},
                      {name: 'campoLlave'},
                      {name: 'visible'},
                      {name: 'orden'}
                  ]

var registroCampoGrid=crearRegistro	(arrCamposGrid);
var nuevoReg=false;
var arrTipoCampo=[['2','Decimal'],['1','Entero'],['6','Fecha'],['7','Hora'],['5','Moneda'],['3','Texto'],['4','Vinculado a tabla']];

function crearGridConfiguracionCampoGrid(nID,iE)
{
	
    var dsDatos=[];
    
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idRegistroCampo'},
                                                        			{name: 'idCampo'},
                                                                    {name: 'cabecera'},
                                                                    {name: 'ancho'},
                                                                    {name: 'tipoCampo'},
                                                                    {name: 'obligatorio'},
                                                                    {name: 'tablaVinculada'},
                                                                    {name: 'tablaOriginalVinculada'},
                                                                    {name: 'campoVinculado'},
                                                                    {name: 'campoUsrVinculado'},
                                                                    {name: 'campoUsrLlave'},
                                                                    {name: 'campoLlave'},
                                                                    {name: 'visible'},
												                    {name: 'orden'}
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
                                                        	header:'ID Campo',
                                                            width:150,
                                                            sortable:true,
															dataIndex:'idCampo'
                                                        },
														{
															header:'Encabezado',
															width:150,
															sortable:true,
															dataIndex:'cabecera'
                                                            
														},
                                                        {
                                                        	header:'Ancho',
															width:80,
															sortable:true,
															dataIndex:'ancho'
                                                        },
                                                        {
                                                        	header:'Visible',
															width:80,
															sortable:true,
															dataIndex:'visible',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                    	var pos=existeValorMatriz(arrSiNo,val,0);
                                                                        if(pos!=-1)
	                                                                        return arrSiNo[pos][1];
                                                                        else
                                                                        	return "";
                                                                    }
                                                            
                                                        },
														{
															header:'Tipo de campo',
															width:130,
															sortable:true,
															dataIndex:'tipoCampo',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(val!=4)
                                                                        {
                                                                        	registro.set('tablaVinculada','');
                                                                            registro.set('tablaOriginalVinculada','');
                                                                            registro.set('campoVinculado','');
                                                                            registro.set('campoUsrVinculado','');
                                                                            registro.set('campoUsrLlave','');
                                                                            registro.set('campoLlave','');
                                                                        }
                                                                    	var pos=existeValorMatriz(arrTipoCampo,val,0);
                                                                        if(pos!=-1)
	                                                                        return arrTipoCampo[pos][1];
                                                                        else
                                                                        	return "";
                                                                    }
														},
                                                        {
                                                        	header:'Obligatorio',
															width:100,
															sortable:true,
															dataIndex:'obligatorio',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                    	var pos=existeValorMatriz(arrSiNo,val,0);
                                                                        if(pos!=-1)
	                                                                        return arrSiNo[pos][1];
                                                                        else
                                                                        	return "";
                                                                    }
                                                        	
                                                        },
                                                        {
                                                        	header:'Tabla vinculada',
															width:190,
															sortable:true,
															dataIndex:'tablaVinculada'
                                                        },
                                                        {
                                                        	header:'Campo vinculado',
															width:200,
															sortable:true,
															dataIndex:'campoVinculado',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return registro.get('campoUsrVinculado');
                                                                    }
                                                        },
                                                        {
                                                        	header:'Campo llave',
															width:200,
															sortable:true,
															dataIndex:'campoLlave',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return registro.get('campoUsrLlave');
                                                                    }
	                                                    }
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCampoGrid',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:5,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:360,
                                                            width:850,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	
                                                                        	text:'Agregar nueva columna',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaNuevaFila(tblGrid,nID,iE,null);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	
                                                                        	text:'Modificar columna',
                                                                            icon:'../images/pencil.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la columna a modificar');
                                                                                        	return;
                                                                                        }
                                                                                        mostrarVentanaNuevaFila(tblGrid,nID,iE,fila);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	
                                                                        	text:'Remover columna',
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la columna a modificar');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                                if(fila.get('idRegistroCampo')=='-1')
                                                                                                {
                                                                                                	tblGrid.getStore().remove(fila);
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                        	tblGrid.getStore().remove(fila);
                                                                                                            var cadObj=obtenerConfColumnasCamposGrid(iE,nID);
                                                                                                            var divGrid=gE('div_'+iE);
                                                                                                            if(divGrid!=null)
                                                                                                            {
                                                                                                                
                                                                                                                posX=divGrid.style.left.replace('px','');
                                                                                                                posY=divGrid.style.top.replace('px','');
                                                                                                                var idFormulario=gE('idFormulario');
                                                                                                                var gridCampo=gEx('grid_'+iE);
                                                                                                                cadObj='{"ancho":"'+gridCampo.getWidth()+'","alto":"'+gridCampo.getHeight()+'","posX":"'+posX+'","posY":"'+posY+'","idFormulario":"'+idFormulario+'","nID":"'+nID+'","arrCampos":['+cadObj+']}';
                                                                                                                divGrid.parentNode.removeChild(divGrid);
                                                                                                                crearControlGridFormulario(cadObj,iE,'_'+nID);
                                                                                                            }
                                                                                                            
                                                                                                            
                                                                                                            
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=59&idRegistroCampo='+fila.get('idRegistroCampo'),true);
                                                                                                    

                                                                                                }
                                                                                        	}
                                                                                       	}
                                                                                        msgConfirm('Est&aacute; seguro de querer remover la columna seleccionada?',resp);
                                                                                    }
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	                                                
	return 	tblGrid;		
}


function mostrarVentanaNuevaFila(grid,nID,iE,fila)
{
	var lblModificar='Sin tabla vinculada';
    var lblBtnModificar='<a href="javascript:mostrarVentanaTablasCampoGrid()"><img width="13" heigth="13" src="../images/pencil.png" title="Vincular con tabla" alt="Vincular con tabla"></a>';
	
	var comboTipoCampo=crearComboExt('comboTipoCampo',arrTipoCampo,100,125,160);
    comboTipoCampo.on('select',function(combo,registro,indice)
    							{
                                	var comboCampoVinculado=gEx('comboCampoVinculado');
                                    var comboCampoLlave=gEx('comboCampoLlave');
                                	if(registro.get('id')=='4')
                                    {
                                    	gEx('lblTablaVinculada').setText(lblModificar+' '+lblBtnModificar,false);
                                        comboCampoVinculado.enable();
                                        comboCampoLlave.enable();
                                    }
                                    else
                                    {
                                    	gEx('lblTablaVinculada').setText(lblModificar);
                                        comboCampoVinculado.reset();
                                    	comboCampoVinculado.getStore().removeAll();
                                    	comboCampoVinculado.disable();
                                        comboCampoLlave.reset();
                                        comboCampoLlave.getStore().removeAll();
                                        comboCampoLlave.disable();
                                    
                                    }
                                    	
                                }		
                      );
    var comboCampoVinculado=crearComboExt('comboCampoVinculado',[],100,215);
    comboCampoVinculado.disable();
    var comboCampoLlave=crearComboExt('comboCampoLlave',[],100,245);
    comboCampoLlave.disable();
    var comboSiNo=crearComboExt('comboSiNo',arrSiNo,100,155,115);
    comboSiNo.setValue(0);
    var cmbVisibleSiNo=crearComboExt('cmbVisibleSiNo',arrSiNo,100,95,115);
    cmbVisibleSiNo.setValue(1);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'ID Campo:'
                                                        },
                                                        {
                                                        	id:'txtCampoID',
                                                        	x:100,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:200,
                                                            maskRe:/^[a-zA-Z0-9]$/
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Encabezado:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:35,
                                                            id:'txtEncabezado',
                                                            xtype:'textfield',
                                                            width:200
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Ancho:'
                                                            
                                                        },
                                                        {
                                                        	x:100,
                                                            y:65,
                                                            id:'txtAncho',
                                                            xtype:'numberfield',
                                                            value:150,
                                                            width:80
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Visible:'
                                                            
                                                        },
                                                        cmbVisibleSiNo,
                                                        
                                                        
                                                         {
                                                        	x:10,
                                                            y:130,
                                                            html:'Tipo de campo:'
                                                        },
                                                        comboTipoCampo,
                                                         {
                                                        	x:10,
                                                            y:160,
                                                            html:'Obligatorio:'
                                                        },
                                                        comboSiNo,
                                                         {
                                                        	x:10,
                                                            y:190,
                                                            html:'Tabla vinculada:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:190,
                                                            id:'lblTablaVinculada',
                                                            html:lblModificar
                                                        },
                                                        
                                                         {
                                                        	x:10,
                                                            y:220,
                                                            html:'Campo vinculado:'
                                                        },
                                                        comboCampoVinculado,
                                                         {
                                                        	x:10,
                                                            y:250,
                                                            html:'Campo llave:'
                                                        },
                                                        comboCampoLlave,
                                                        {
                                                        	id:'hTablaUsrVinculada',
                                                            value:'',
                                                            xtype:'hidden'
                                                        
                                                        },
                                                        {
                                                        	id:'hTablaOriVinculada',
                                                            value:'',
                                                        	xtype:'hidden'
                                                        
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar columna',
										width: 390,
										height:365,
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
                                                                	gEx('txtCampoID').focus(500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		if(validarDatosColumna())
                                                                        {
                                                                        
                                                                        	var txtCampoID=gEx('txtCampoID');
                                                                            var txtEncabezado=gEx('txtEncabezado');
                                                                            var txtAncho=gEx('txtAncho');
                                                                            var comboTipoCampo=gEx('comboTipoCampo');
                                                                            var hTablaUsrVinculada=gEx('hTablaUsrVinculada');
                                                                            var hTablaOriVinculada=gEx('hTablaOriVinculada');
                                                                            var comboCampoVinculado=gEx('comboCampoVinculado');
                                                                            var comboCampoLlave=gEx('comboCampoLlave');
                                                                            var idFormulario=gE('idFormulario').value;
                                                                            var idElemento=iE;
                                                                           	if(idElemento==-1)
                                                                            {
                                                                            	var regGrid=new registroCampoGrid(
                                                                                                                        {
                                                                                                                        	idRegistroCampo:'-1',
                                                                                                                        	idCampo:txtCampoID.getValue(),
                                                                                                                            cabecera:txtEncabezado.getValue(),
                                                                                                                            ancho:txtAncho.getValue(),
                                                                                                                            tipoCampo:comboTipoCampo.getValue(),
                                                                                                                            obligatorio:comboSiNo.getValue(),
                                                                                                                            tablaOriginalVinculada:hTablaOriVinculada.getValue(),
                                                                                                                            tablaVinculada:hTablaUsrVinculada.getValue(),
                                                                                                                            campoVinculado:comboCampoVinculado.getValue(),
                                                                                                                            campoUsrVinculado:comboCampoVinculado.getRawValue(),
                                                                                                                            campoLlave:comboCampoLlave.getValue(),
                                                                                                                            campoUsrLlave:comboCampoLlave.getRawValue(),
                                                                                                                            visible:cmbVisibleSiNo.getValue(),
                                                                                                                            orden:(grid.getStore().getCount()+1)
                                                                                                                        }
                                                                                                                     )
                                                                                grid.getStore().add(regGrid);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                            	var idRegistroCampo='-1';
                                                                                if(fila!=null)
                                                                                	idRegistroCampo=fila.get('idRegistroCampo');
                                                                            	 
                                                                                 if((fila==null)||(idRegistroCampo!='-1'))
                                                                                 {
                                                                                 
                                                                                 	
                                                                                 
                                                                                     var cadObj='{"idRegistroCampo":"'+idRegistroCampo+'","idElemento":"'+idElemento+'","idCampo":"'+txtCampoID.getValue()+'","cabecera":"'+cv(txtEncabezado.getValue())+'","ancho":"'+txtAncho.getValue()+'","tipoCampo":"'+comboTipoCampo.getValue()+
                                                                                                '","obligatorio":"'+comboSiNo.getValue()+'",'+'"tablaOriginalVinculada":"'+hTablaOriVinculada.getValue()+'","tablaVinculada":"'+hTablaUsrVinculada.getValue()+
                                                                                                '","campoVinculado":"'+comboCampoVinculado.getValue()+'",'+'"campoUsrVinculado":"'+comboCampoVinculado.getRawValue()+'","campoLlave":"'+comboCampoLlave.getValue()+
                                                                                                '","campoUsrLlave":"'+comboCampoLlave.getRawValue()+'","visible":"'+cmbVisibleSiNo.getValue()+'","orden":"'+(grid.getStore().getCount()+1)+'"}';
                                                                               
                                                                                     
                                                                                    function funcAjax()
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                        	if(fila==null)
                                                                                            {
                                                                                                var regGrid=new registroCampoGrid(
                                                                                                                                        {
                                                                                                                                            idRegistroCampo:arrResp[1],
                                                                                                                                            idCampo:txtCampoID.getValue(),
                                                                                                                                            cabecera:txtEncabezado.getValue(),
                                                                                                                                            ancho:txtAncho.getValue(),
                                                                                                                                            tipoCampo:comboTipoCampo.getValue(),
                                                                                                                                            obligatorio:comboSiNo.getValue(),
                                                                                                                                            tablaOriginalVinculada:hTablaOriVinculada.getValue(),
                                                                                                                                            tablaVinculada:hTablaUsrVinculada.getValue(),
                                                                                                                                            campoVinculado:comboCampoVinculado.getValue(),
                                                                                                                                            campoUsrVinculado:comboCampoVinculado.getRawValue(),
                                                                                                                                            campoLlave:comboCampoLlave.getValue(),
                                                                                                                                            campoUsrLlave:comboCampoLlave.getRawValue(),
                                                                                                                                            visible:cmbVisibleSiNo.getValue(),
                                                                                                                                            orden:(grid.getStore().getCount()+1)
                                                                                                                                        }
                                                                                                                                     )
                                                                                                grid.getStore().add(regGrid);
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                            	fila.set('idCampo',txtCampoID.getValue());
                                                                                            	fila.set('cabecera',txtEncabezado.getValue());
                                                                                                fila.set('ancho',txtAncho.getValue());
                                                                                                fila.set('tipoCampo',comboTipoCampo.getValue());
                                                                                                fila.set('obligatorio',comboSiNo.getValue());
                                                                                                
                                                                                                fila.set('tablaOriginalVinculada',hTablaOriVinculada.getValue());
                                                                                                fila.set('tablaVinculada',hTablaUsrVinculada.getValue());
                                                                                                fila.set('campoVinculado',comboCampoVinculado.getValue());
                                                                                                fila.set('campoUsrVinculado',comboCampoVinculado.getRawValue());
                                                                                                
                                                                                                fila.set('campoLlave',comboCampoLlave.getValue());
                                                                                                fila.set('campoUsrLlave',comboCampoLlave.getRawValue());
                                                                                                fila.set('visible',cmbVisibleSiNo.getValue());
                                                                                            }
                                                                                            
                                                                                            
                                                                                            var cadObj=obtenerConfColumnasCamposGrid(iE,nID);
                                                                                            var divGrid=gE('div_'+iE);
                                                                                            var idFormulario=gE('idFormulario').value;
                                                                                            
                                                                                            if(divGrid!=null)
                                                                                            {
                                                                                            	var gridAux=gEx('grid_'+iE);
                                                                                            	posX=divGrid.style.left.replace('px','');
                                                                                            	posY=divGrid.style.top.replace('px','');
                                                                                                
                                                                                                cadObj='{"ancho":"'+gridAux.getWidth()+'","alto":"'+gridAux.getHeight()+'","posX":"'+posX+'","posY":"'+posY+'","idFormulario":"'+idFormulario+'","nID":"'+nID+'","arrCampos":['+cadObj+']}';
                                                                                            }
                                                                                            else
                                                                                            	cadObj='{"posX":"'+posX+'","posY":"'+posY+'","idFormulario":"'+idFormulario+'","nID":"'+nID+'","arrCampos":['+cadObj+']}';
                                                                                            divGrid.parentNode.removeChild(divGrid);
                                                                                            
                                                                                           
                                                                                            ventanaAM.close();
                                                                                            crearControlGridFormulario(cadObj,iE,'_'+nID);
                                                                                            
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=58&cadObj='+cadObj,true);
                                                                            	}
                                                                                else
                                                                                {
                                                                                	fila.set('idCampo',txtCampoID.getValue());
                                                                                    fila.set('cabecera',txtEncabezado.getValue());
                                                                                    fila.set('ancho',txtAncho.getValue());
                                                                                    fila.set('tipoCampo',comboTipoCampo.getValue());
                                                                                    fila.set('obligatorio',comboSiNo.getValue());
                                                                                    
                                                                                    fila.set('tablaOriginalVinculada',hTablaOriVinculada.getValue());
                                                                                    fila.set('tablaVinculada',hTablaUsrVinculada.getValue());
                                                                                    fila.set('campoVinculado',comboCampoVinculado.getValue());
                                                                                    fila.set('campoUsrVinculado',comboCampoVinculado.getRawValue());
                                                                                    
                                                                                    fila.set('campoLlave',comboCampoLlave.getValue());
                                                                                    fila.set('campoUsrLlave',comboCampoLlave.getRawValue());
                                                                                    fila.set('visible',cmbVisibleSiNo.getValue());
                                                                                    
                                                                                    
                                                                                }
                                                                        	}
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
                                
	if(fila!=null)                                
    {
    	var txtCampoID=gEx('txtCampoID');
        //txtCampoID.disable();
        txtCampoID.setValue(fila.get('idCampo'));
        var txtEncabezado=gEx('txtEncabezado');
        txtEncabezado.setValue(fila.get('cabecera'));
        var txtAncho=gEx('txtAncho');
        txtAncho.setValue(fila.get('ancho'));
        cmbVisibleSiNo.setValue(fila.get('visible'));
        var comboTipoCampo=gEx('comboTipoCampo');
        comboTipoCampo.setValue(fila.get('tipoCampo'));
        comboSiNo.setValue(fila.get('obligatorio'));
        if(fila.get('tipoCampo')=='4')
        {
        	gEx('lblTablaVinculada').setText(fila.get('tablaVinculada')+' '+lblBtnModificar,false);
        	function funcResp()
            {
                var arrResp=peticion_http.responseText.split('|');
                if(arrResp[0]=='1')
                {
                        var arrTablas=eval(arrResp[1]);
                        var arrTablasCmb=eval(arrResp[2]);
                        Ext.getCmp('comboCampoVinculado').getStore().loadData(arrTablasCmb);
                        Ext.getCmp('comboCampoVinculado').enable();
                        Ext.getCmp('comboCampoLlave').getStore().loadData(arrTablasCmb);
                        Ext.getCmp('comboCampoLlave').enable();
                        var hTablaUsrVinculada=gEx('hTablaUsrVinculada');
                        hTablaUsrVinculada.setValue(fila.get('tablaVinculada'));
                        var hTablaOriVinculada=gEx('hTablaOriVinculada');
                        hTablaOriVinculada.setValue(fila.get('tablaOriginalVinculada'));
                        var comboCampoVinculado=gEx('comboCampoVinculado');
                        comboCampoVinculado.setValue(fila.get('campoVinculado'));
                        var comboCampoLlave=gEx('comboCampoLlave');
                        comboCampoLlave.setValue(fila.get('campoLlave'));
                        ventanaSelTabla.close();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=13&nomTabla='+fila.get('tablaVinculada'),true);
            

        }
        else
        {
       		var hTablaUsrVinculada=gEx('hTablaUsrVinculada');
            hTablaUsrVinculada.setValue(fila.get('tablaVinculada'));
            var hTablaOriVinculada=gEx('hTablaOriVinculada');
            hTablaOriVinculada.setValue(fila.get('tablaOriginalVinculada'));
            var comboCampoVinculado=gEx('comboCampoVinculado');
            comboCampoVinculado.setValue(fila.get('campoVinculado'));
            var comboCampoLlave=gEx('comboCampoLlave');
            comboCampoLlave.setValue(fila.get('campoLlave'));
        }
		
       
    }
	ventanaAM.show();	
}

function mostrarVentanaTablasCampoGrid()
{
	 
	var alDatos = new Ext.data.JsonStore	(
                                                {
                                                    root: 'registros',
                                                    totalProperty: 'numReg',
                                                    idProperty: 'nomTablaOriginal',
                                                    fields:	[
                                                                {name:'nomTablaOriginal'},
                                                                {name:'tabla'}, 
                                                                {name:'tipoTabla'},
                                                                {name:'proceso'}
                                                            ],
                                                    remoteSort:false,
                                                    proxy: new Ext.data.HttpProxy	(
                                                                                        {
                                                                                            url: '../paginasFunciones/funcionesFormulario.php'
                                                                                            
                                                                                        }
                                                                                    )
                                                }
                                            );  
                                            
                                            
	var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[
                                                        				{
                                                                            type:'string',
                                                                           	dataIndex:'tabla' 
																		},
                                                                        {
                                                                            type:'list',
                                                                           	dataIndex:'tipoTabla',
                                                                            phpMode:true,
                                                                            options:	[
                                                                            				{
                                                                                            	id:'1',
                                                                                                text:'Formulario Din&aacute;mico'
                                                                                            },
                                                                            				{
                                                                                            	id:'2',
                                                                                                text:'Sistema'
                                                                                            }
                                                                            			] 
																		},
                                                                        {
                                                                            type:'string',
                                                                           	dataIndex:'proceso' 
																		}
                                                        			]
                                                    }
                                                );                                                                                                                           
    
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Tabla',
                                                            width:250,
                                                            dataIndex:'tabla',
                                                            sortable:true
                                                        },
                                                        {
                                                        	header:'Tipo',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'tipoTabla'
                                                        },
                                                        {
                                                        	header:'Proceso',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'proceso'
                                                        }
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridTabla',
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:700,
                                                            plugins: filters
                                                            
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    width:700,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
    
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid
                                                    ]
                                        }
                                    );
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                    	
                                                                        var filaSel= tblOpciones.getSelectionModel().getSelected();
                                                                        if(filaSel==null)
                                                                        {
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','Debe seleccionar la tabla con la cual se vincular&aacute; el campo del grid');
                                                                        	return;
                                                                        }
                                                                        var nomTabla=filaSel.get('nomTablaOriginal');
                                                                        var tablaUsr=filaSel.get('tabla');
                                                                        
                                                                        gEx('lblTablaVinculada').setText(tablaUsr+' <a href="javascript:mostrarVentanaTablasCampoGrid()"><img width="13" heigth="13" src="../images/pencil.png" title="Vincular con tabla" alt="Vincular con tabla"></a>',false);
                                                                        gEx('hTablaUsrVinculada').setValue(tablaUsr);
                                                                        gEx('hTablaOriVinculada').setValue(nomTabla);

                                                                        
                                                                        function funcResp()
                                                                        {
                                                                            var arrResp=peticion_http.responseText.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                    var arrTablas=eval(arrResp[1]);
                                                                                    var arrTablasCmb=eval(arrResp[2]);
                                                                                    Ext.getCmp('comboCampoVinculado').getStore().loadData(arrTablasCmb);
                                                                                    Ext.getCmp('comboCampoVinculado').enable();
                                                                                    Ext.getCmp('comboCampoLlave').getStore().loadData(arrTablasCmb);
                                                                                    Ext.getCmp('comboCampoLlave').enable();
                                                                                    ventanaSelTabla.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=13&nomTabla='+nomTabla,true);
                                                                        
                                                                        
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelTabla = new Ext.Window(
                                            {
                                                title: 'Seleccione la tabla en la cual se basar&aacute; su consulta',
                                                width: 730 ,
                                                height:390,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                          			                  
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: 'Cancelar',
                                                                    handler:function()
                                                                    {
                                                                        ventanaSelTabla.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
                                        
	tblOpciones.getStore().load(
    								{	
                                    	params:	{
                                            		funcion:46
                                        		}	
                                    }
                               );                                        	
	ventanaSelTabla.show();	
}

function validarDatosColumna()
{
	var txtCampoID=gEx('txtCampoID');
    var txtEncabezado=gEx('txtEncabezado');
    var txtAncho=gEx('txtAncho');
    var comboTipoCampo=gEx('comboTipoCampo');
    var hTablaUsrVinculada=gEx('hTablaUsrVinculada');
    var comboCampoVinculado=gEx('comboCampoVinculado');
    var comboCampoLlave=gEx('comboCampoLlave');
    
    if(txtCampoID.getValue()=='')
    {
    	function funcRespID()
        {
        	txtCampoID.focus();
        }
    	msgBox('El ID del campo es obligatorio',funcRespID);
        return false;
    }
    
    if(txtEncabezado.getValue()=='')
    {
    	function funcRespEncabezado()
        {
        	txtEncabezado.focus();
        }
    	msgBox('El encabezado de la columna es obligatoria',funcRespEncabezado);
        return false;
    }
    
    if(txtAncho.getRawValue()=='')
    {
    	function funcRespAncho()
        {
        	txtAncho.focus();
        }
    	msgBox('El ancho de la columna es obligatorio',funcRespAncho);
        return false;
    }
    
    if(comboTipoCampo.getValue()=='')
    {
    	function funcRespTipoCol()
        {
        	comboTipoCampo.focus();
        }
    	msgBox('Debe indicar el tipo de columna',funcRespTipoCol);
        return false;
    }
    
    if(comboTipoCampo.getValue()=='4')
    {
        if(hTablaUsrVinculada.getValue()=='')
        {
            function funcRespTablaUsr()
            {
                
            }
            msgBox('Debe indicar la tabla con la cual se vincula la columna',funcRespTablaUsr);
            return false;
        }
        
        if(comboCampoVinculado.getValue()=='')
        {
        	function funcCampoVinculado()
            {
            	comboCampoVinculado.focus();
            }
            msgBox('Debe indicar el campo con el cual se vincular&aacute; la columna',funcCampoVinculado);
        	return false;
        }
        
        if(comboCampoLlave.getValue()=='')
        {
        	function funcCampoLlave()
            {
            	comboCampoLlave.focus();
            }
            msgBox('Debe indicar el campo llave con el cual se vincular&aacute; la columna',funcCampoLlave);
        	return false;
        }
	}
    return true;
}

function crearControlGridFormulario(cadObj,idElem,nControl)
{
	idElemento=idElem;
	var obj=eval('['+cadObj+']')[0];
    var arrObjCampos=obj.arrCampos;
    var x;
    var asterisco;
    var fila;
    var oculto;
    var arrCampos=new Array();
    var arrCabeceras=new Array();
    for (x=0;x<arrObjCampos.length;x++)
    {
        asterisco="";
        fila=arrObjCampos[x];
        
        if(fila.obligatorio=="1")
            asterisco=' <font color="red">*</font>';
        oculto=false;
        if(fila.visible=="0")
        {
            oculto=true;
            asterisco="";
        }
        arrCampos.push({name:fila.idCampo});
        arrCabeceras.push({
                                            header:decodeURIComponent(fila.cabecera+asterisco),
                                            width:parseInt(fila.ancho),
                                            sortable:true,
                                            dataIndex:fila.idCampo,
                                            hidden:oculto
                        });
        
            
    }
    
    var arrEliminar=document.createElement('div');
    var linkDel=document.createElement('a');
    var nomControl=nControl;
    linkDel.href='javascript:eliminarElemento('+idElemento+')';
    
    var imgDel=document.createElement('img');
    imgDel.src='../images/formularios/cross.png';
    imgDel.height='10';
    imgDel.width='10';
    imgDel.title='Eliminar este elemento';
    imgDel.alt='Eliminar este elemento';
    
    linkDel.appendChild(imgDel);
    arrEliminar.appendChild(document.createTextNode('  '));
    arrEliminar.appendChild(linkDel);
    var arrElem=new Array();
    var span1=cE('span');
    span1.id='contenedorSpanGrid_'+idElemento;
    span1.setAttribute('permiteModificar','1');
    span1.setAttribute('permiteEliminar','1');
    span1.setAttribute('val','');
    var span2=cE('span');
    span2.id='spanGrid_'+idElemento;
	span1.appendChild(span2);
    arrElem.push(span1);
    var arrContenido=new Array();
    arrContenido[0]=arrElem;
    arrContenido[1]=arrEliminar;
    arrContenido[2]=null;
    arrContenido[3]=idElemento;
    arrContenido[4]=nomControl;
    arrContenido[5]='29';
    insertarControl(arrContenido);
    var ancho=560;
    var alto=300;
    if(typeof(obj.ancho)!='undefined')
    	ancho=obj.ancho;
   	if(typeof(obj.alto)!='undefined')
    	alto=obj.alto;
    
    crearCampoGridFormulario('grid_'+idElemento,span2.id,ancho,alto,arrObjCampos,arrCabeceras,'ME');
    var divGrid=gE('div_'+idElem);
    divGrid.style.left=obj.posX+'px';
    divGrid.style.top=obj.posY+'px';
}

function mostrarVentanaHiperEnlace()
{
	var gridEnlace=crearGridEnlace();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridEnlace

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Listado de enlaces',
										width: 600,
										height:370,
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
    
	llenarDatosEnlaces(ventanaAM);
}

function llenarDatosEnlaces(ventana)
{
	var idFormulario=gE('idFormulario').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            gEx('gridListadoEnlaces').getStore().loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=61&tEnlace=0&idFormulario='+idFormulario,true);
}

function crearGridEnlace()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idEnlace'},
                                                                {name: 'titulo'},
                                                                {name: 'url'},
                                                                {name: 'descripcion'},
                                                                {name: 'tipoEnlace'}
                                                                 
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'T&iacute;tulo',
															width:150,
															sortable:true,
															dataIndex:'titulo'
														},
														{
															header:'Enlace',
															width:200,
															sortable:true,
															dataIndex:'url'
														},
                                                        {
															header:'Descripci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'descripcion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridListadoEnlaces',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:560,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            text:'Crear enlace',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaNuevoEnlace();
                                                                                    
                                                                                    }
                                                                        },
                                                                         {
                                                                        	icon:'../images/pencil.png',
                                                                            text:'Modificar enlace',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelections();
                                                                                        if(fila.length==0)
                                                                                        {
                                                                                            msgBox('Primero debe seleccionar el par&aacute;metro a modificar');
                                                                                            return;	
                                                                                        }
                                                                                        mostrarVentanaConfiguracionEnlace(fila[0].get('tipoEnlace'),fila[0].get('idEnlace'),null);
                                                                                    
                                                                                    }
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            text:'Eliminar enlace',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelections();
                                                                                        if(fila.length==0)
                                                                                        {
                                                                                            msgBox('Primero debe seleccionar el enlace a eliminar');
                                                                                            return;	
                                                                                        }
                                                                                        var idEnlace=obtenerListadoArregloFilas(fila,'idEnlace');
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
                                                                                                    	
                                                                                                    	tblGrid.getStore().remove(fila);
                                                                                                        var arrDatosCombo=new Array();
                                                                                                        arrDatosCombo.push(['','Ninguno']);
                                                                                                        var x;
                                                                                                        var filaTemp;
                                                                                                        for(x=0;x<tblGrid.getStore().getCount();x++)
                                                                                                        {
                                                                                                        	filaTemp=tblGrid.getStore().getAt(x);
                                                                                                        	arrDatosCombo.push([filaTemp.get('idEnlace'),filaTemp.get('titulo')]);
                                                                                                            
                                                                                                        }
                                                                                                        gEx('cmbListadoEnlaces').getStore().loadData(arrDatosCombo);
                                                                                                        arrEnlaces=arrDatosCombo;
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=62&idEnlace='+idEnlace,true);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer eliminar el enlace seleccionado?',resp);
                                                                                    }
                                                                        }
                                                                       
                                                            		]
                                                        }
                                                    );

	return 	tblGrid;	
}



function mostrarVentanaNuevoEnlace()
{
	var arrTipoEnlace=[['1','A pagina'],['2','Hacia reporte thot']];
	var cmbTipoEnlace=crearComboExt('cmbTipoEnlace',arrTipoEnlace,100,5);
    cmbTipoEnlace.setValue('1');
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
                                                            html:'Tipo de enlace'
                                                        },
                                                        cmbTipoEnlace

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear enlace',
										width: 330,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var tipoEnlace=	cmbTipoEnlace.getValue();
                                                                        switch(tipoEnlace)	
                                                                        {
                                                                        	case '1':
                                                                            	mostrarVentanaConfiguracionEnlace(1,-1,null);
                                                                            break;
                                                                            case '2':
                                                                            	mostrarVentanaSelReporte();
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

function mostrarVentanaConfiguracionEnlace(tipoEnlace,idEnlace,objParam)
{
	var arrFormasApertura=[['1','En una nueva ventana'],['2','Embebido el formulario']];
	var cmbFormaApertura=crearComboExt('cmbFormaApertura',arrFormasApertura,110,140);
    cmbFormaApertura.setValue('1');
    var gridParametros=crearGridParametrosEnlace(tipoEnlace);
    var desHabilitado=false;
    var valUrl='';
    if(objParam!=null)
    {
    	gridParametros.getStore().loadData(objParam.arrParam);
        valUrl=objParam.url;
        
    } 
    
    if(tipoEnlace!='1')
    	desHabilitado=true;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'T&iacute;tulo:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            x:110,
                                                            y:5,
                                                            id:'txtTitulo',
                                                            width:250
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Enlace:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            x:110,
                                                            y:35,
                                                            id:'txtEnlace',
                                                            width:330,
                                                            value:valUrl,
                                                            disabled:desHabilitado
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Decripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:110,
                                                            y:65,
                                                            id:'txtDescripcion',
                                                            width:330,
                                                            height:70
                                                        },
                                                        {
                                                        	x:10,
                                                            y:145,
                                                            html:'Forma de apertura:'
                                                        },
                                                        cmbFormaApertura,
                                                        gridParametros

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n del enlace',
										width: 570,
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
                                                                	gEx('txtTitulo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtTitulo=gEx('txtTitulo');
                                                                        var txtEnlace=gEx('txtEnlace');
                                                                        var txtDescripcion=gEx('txtDescripcion');
                                                                        
                                                                        if(txtTitulo.getValue()=='')
                                                                        {
                                                                        	function respTitulo()
                                                                            {
                                                                            	txtTitulo.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el t&iacute;tulo del enlace',respTitulo);
                                                                        }
                                                                        if(txtEnlace.getValue()=='')
                                                                        {
                                                                        	function respEnlace()
                                                                            {
                                                                            	txtEnlace.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la URL del enlace',respEnlace);
                                                                        }
                                                                        var arrParam='';
                                                                        var x;
                                                                        var obj;
                                                                        var fila;
                                                                        
                                                                        for(x=0;x<gridParametros.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridParametros.getStore().getAt(x);
                                                                            if(fila.get('parametro')=='')
                                                                            {
                                                                            	function respNomParametro()
                                                                                {
                                                                                	gridParametros.starEditing(x,2);
                                                                                }
                                                                            	msgBox('El nombre del par&aacute;metro es obligatorio',respNomParametro);
                                                                            	return;
                                                                            }
                                                                            
                                                                            if(fila.get('tipoValor')=='')
                                                                            {
                                                                            	function respTipoValor()
                                                                                {
                                                                                	gridParametros.starEditing(x,3);
                                                                                }
                                                                            	msgBox('Debe indicar el tipo de valor a asignar al par&aacute;metro',respTipoValor);
                                                                            	return;
                                                                            }
                                                                            
                                                                            if(fila.get('valor')=='')
                                                                            {
                                                                            	function respValor()
                                                                                {
                                                                                	gridParametros.starEditing(x,4);
                                                                                }
                                                                            	msgBox('Debe ingresar el valor del par&aacute;metro',respValor);
                                                                            	return;
                                                                            }
                                                                        }
                                                                        
                                                                        for(x=0;x<gridParametros.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridParametros.getStore().getAt(x);
                                                                        	obj='{"parametro":"'+fila.get('parametro')+'","tipo":"'+fila.get('tipoValor')+'","valor":"'+fila.get('valor')+'"}';
                                                                            if(arrParam=='')
                                                                            	arrParam=obj;
                                                                            else
                                                                            	arrParam+=','+obj;
                                                                       	}
                                                                        
                                                                        
                                                                        var cadObj='{"tipoReferencia":"'+tipoEnlace+'","idFormulario":"'+gE('idFormulario').value+'","idEnlace":"'+idEnlace+'","titulo":"'+cv(txtTitulo.getValue())+'","enlace":"'+cv(txtEnlace.getValue())+'","descripcion":"'+cv(txtDescripcion.getValue())+'","fApertura":"'+cmbFormaApertura.getValue()+'","arrParam":['+arrParam+']}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var arrDatos=eval(arrResp[1]);
                                                                                gEx('gridListadoEnlaces').getStore().loadData(arrDatos);
                                                                                
                                                                                arrDatos.splice(0,0,['','Ninguno','','','']);
                                                                                gEx('cmbListadoEnlaces').getStore().loadData(arrDatos);
                                                                                arrEnlaces=arrDatos;
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=60&tEnlace=0&cadObj='+cadObj,true);
                                                                        

                                                                        
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
	if(idEnlace=="-1")                                
		ventanaAM.show();	
    else
    	llenarDatosEnlaceModificacion(ventanaAM,idEnlace);

}

function llenarDatosEnlaceModificacion(ventana,idEnlace)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var cadObj='['+arrResp[1]+']';
            var obj=eval(cadObj)[0];
            gEx('txtTitulo').setValue(obj.txtTitulo);
            gEx('txtEnlace').setValue(obj.txtEnlace);
            gEx('txtDescripcion').setValue(obj.txtDescripcion);
            gEx('cmbFormaApertura').setValue(obj.formaApertura);
            
        	gEx('gridParametrosEnlace').getStore().loadData(obj.arrParametros);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=63&idEnlace='+idEnlace,true);
}


var registroGridParametro=crearRegistro([
                                            {name: 'idParametro'},
                                            {name: 'parametro'},
                                            {name: 'tipoValor'},
                                            {name: 'valor'}

                                        ])

var arrValorSesion=<?php echo $arrValorSesion ?>;
var arrValorSistema=<?php echo $arrValorSistema ?>; 
var arrValoresFormulario=[['1','idFormulario'],['4','idProceso'],['5','idProcesoPadre'],['2','idRegistro'],['3','idReferencia']];

function crearGridParametrosEnlace(tipoEnlace)
{
	var ocultarBotones=false;
    if(tipoEnlace!='1')
    	ocultarBotones=true;
	var arrTipoValor=[['1','Valor constante'],['3','Valor de sesi\xF3n'],['4','Valor de sistema'],['5','Valor de formulario']];
	var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoValor);
    
    cmbTipoValor.on('select',funcTipoValorChange);
    
    var txtEditor=new Ext.form.TextField({id:'txtEditor'});
    var cmbEditor=crearComboExt('cmbEditor',[],0,0,200);
    
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idParametro'},
                                                                {name: 'parametro'},
                                                                {name: 'tipoValor'},
                                                                {name: 'valor'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Par&aacute;metro',
															width:150,
															sortable:true,
															dataIndex:'parametro',
                                                            editor:new Ext.form.TextField({id:'txtParametro'})
														},
														{
															header:'Tipo de valor',
															width:150,
															sortable:true,
															dataIndex:'tipoValor',
                                                            editor:cmbTipoValor,
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val!='')
                                                                        {
                                                                        	var pos=existeValorMatriz(arrTipoValor,val);
                                                                        	return arrTipoValor[pos][1];
                                                                    	}
                                                                        else
	                                                                        return '';
                                                                    }
														},
                                                        {
															header:'Valor',
															width:150,
															sortable:true,
															dataIndex:'valor',
                                                            editor:null,
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	var arrValores;
                                                                                switch(registro.get('tipoValor'))
                                                                                {
                                                                                	case '3':
                                                                                    	arrValores=arrValorSesion;
                                                                                    break;
                                                                                    case '4':
                                                                                    	arrValores=arrValorSistema;
                                                                                    break;
                                                                                    case '5':
                                                                                    	arrValores=arrValoresFormulario;
                                                                                    break;
                                                                                    default:
                                                                                    	arrValores=null;
                                                                                }
                                                                                if(arrValores!=null)
                                                                                {
                                                                                    if(val!='')
                                                                                    {
                                                                                        var pos=existeValorMatriz(arrValores,val);
                                                                                        return arrValores[pos][1];
                                                                                    }
                                                                                    else
                                                                                        return '';
                                                                            	}
                                                                                return val;
                                                                            }
														}
													]
												);
	
    
	
    
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridParametrosEnlace',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:180,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:540,
                                                            sm:chkRow,
                                                           
                                                            tbar: 	[
                                                            			{
                                                                        	id:'btnAddParametrosEnlace',
                                                                        	icon:'../images/add.png',
                                                                            text:'Agregar par&aacute;metro',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:ocultarBotones,
                                                                            handler:function()
                                                                            		{
                                                                                    	var nReg=new registroGridParametro	(
                                                                                                                                {
                                                                                                                                	idParametro:'-1',
                                                                                                                                    parametro:'',
                                                                                                                                    tipoValor:'',
                                                                                                                                    valor:''
                                                                                                                                    
                                                                                                                                }
                                                                                                                            )
                                                                                        
                                                                                       
                                                                                        tblGrid.getStore().add(nReg);
                                                                                        tblGrid.nuevoRegistro=true;
                                                                                        tblGrid.startEditing(tblGrid.getStore().getCount()-1,2);
                                                                                        
                                                                                    
                                                                                    }
                                                                        },
                                                                        {
                                                                        	id:'btnDelParametrosEnlace',
                                                                        	icon:'../images/delete.png',
                                                                            text:'Eliminar par&aacute;metro',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:ocultarBotones, 
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelections();
                                                                                        if(fila.length==0)
                                                                                        {
                                                                                            msgBox('Primero debe seleccionar el par&aacute;metro a eliminar');
                                                                                            return;	
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                            if(btn=='yes')
                                                                                            {
                                                                                                tblGrid.getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer eliminar el par&aacute;metro seleccionado?',resp);
                                                                                    
                                                                                    }
                                                                        }
                                                            		]
                                                            
                                                        }
                                                    );
	tblGrid.nuevoRegistro=false;                                                    
    if(tipoEnlace!='1')
    	tblGrid.on('beforeedit',funcAntesEditParam);
	     
	return 	tblGrid;
}

function funcAntesEditParam(e)
{
	if(e.field=='parametro')
    	e.cancel=true;
}

function funcTipoValorChange(combo,registro)
{
	var gridParametrosEnlace=gEx('gridParametrosEnlace');
    var txtEditor=gEx('txtEditor');
    var cmbEditor=gEx('cmbEditor');
    registro.set('valor','');
	switch(registro.get('id'))
    {
    	case '1':
			txtEditor.setValue('');
            gridParametrosEnlace.getColumnModel().setEditor(4,txtEditor);
        break;
        case '3':
        	cmbEditor.getStore().loadData(arrValorSesion);
            gridParametrosEnlace.getColumnModel().setEditor(4,cmbEditor);
        break;
        case '4':
        	cmbEditor.getStore().loadData(arrValorSistema);
            gridParametrosEnlace.getColumnModel().setEditor(4,cmbEditor);
        break;
        case '5':
        	cmbEditor.getStore().loadData(arrValoresFormulario);
            gridParametrosEnlace.getColumnModel().setEditor(4,cmbEditor);
        break;
    }
    
    
}

function mostrarVentanaSelReporte()
{
	var gridReportes=crearGridReportes();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el reporte hacia el cual desea crear el enlace:',
                                                            xtype:'label'
                                                        },
                                                        gridReportes
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de reporte a vincular',
										width: 680,
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
																		var fila=gridReportes.getSelectionModel().getSelected();
                                                                        if(fila==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el reporte con el cual desea generar el enlace');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var arrParam=eval(bD(fila.get('parametros')));
                                                                        var url=bD(fila.get('url'));
                                                                        var objParam={};
                                                                        objParam.arrParam=arrParam;
                                                                        objParam.url=url;
                                                                        mostrarVentanaConfiguracionEnlace(2,-1,objParam);
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

    
    llenarGridReportes(ventanaAM)
}

function crearGridReportes()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idReporte'},
                                                                {name: 'nombreReporte'},
                                                                {name: 'descripcion'},
                                                                {name: 'fechaCreacion'},
                                                                {name: 'parametros'},
                                                                {name: 'url'}
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
															header:'Nombre del reporte',
															width:150,
															sortable:true,
															dataIndex:'nombreReporte'
														},
														{
															header:'Descripci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'descripcion'
														},
                                                        {
															header:'Fecha de creaci&oacute;n',
															width:110,
															sortable:true,
															dataIndex:'fechaCreacion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                         	id:'gridReportes' ,  
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:650,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function llenarGridReportes(ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            gEx('gridReportes').getStore().loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=64',true);

}

function doNothing()
{}


