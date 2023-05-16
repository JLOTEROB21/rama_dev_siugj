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

?>

var param1;
var param2;
var param3;
var param4;
var param5;
var objControl='';
var rgIdiomas = Ext.data.Record.create	
(
	[
        {name: 'idioma'},
        {name: 'idIdioma'},
        {name: 'etiqueta'}
	]
 );
 
var  RegistroOpciones =Ext.data.Record.create	(
                                                    [
                                                        <?php 
                                                            echo $campos;
                                                        ?>
                                                    ]
                                                )

function mostrarVentanaInsertarEtiqueta()
{
	
	var tituloVentana='Agregar etiqueta';
	lblBtnAceptar='Finalizar';
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
																		buffer : 100,
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
                                                                                            	var idReporte=gE('idReporte').value;
                                                                                                var arrEtiqueta=obtenerValoresVentanaEtiquetas();
                                                                                                var tElemento=1;
                                                                                                objFinal='{"idPadre":"@idPadre","idReporte":"'+idReporte+'","pregunta":'+arrEtiqueta+',"tipoElemento":"'+tElemento+'","obligatorio":"0","posX":"@posX","posY":"@posY"}';
                                                                                                objControl=objFinal;
                                                                                                ventanaEtiquetas.close();
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

function crearGridElemento(datos)
{
	var tituloElemento;
    tituloElemento='Titulo';
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
															header:'Lenguaje',
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

function cambiarColor(val)
{
	 return '<img src="../images/banderas/'+val+'" />';
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

function insertarControlClick(x,y,idPadre)
{
	var posXCtrl=x;
    var posYCtrl=y;
    objControl=objControl.replace('@posX',posXCtrl);
    objControl=objControl.replace('@posY',posYCtrl);
    objControl=objControl.replace('@idPadre',idPadre);
	guardarPregunta(objControl);
   	
}
