<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$query="select propiedadUsr,propiedadCss,categoriaEstilo,valorDefault from 934_propiedadesCSS where idIdioma=".$_SESSION["leng"]." order by categoriaEstilo,propiedadUsr";	
	$arrPropiedadesEst=uEJ($con->obtenerFilasArreglo($query));
	
	$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='SiNo' order by orden";
	$arrSiNo=uEJ($con->obtenerFilasArreglo($query));
	$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='vAlineacion' order by orden";
	$arrVAlineacion=uEJ($con->obtenerFilasArreglo($query));
	$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='hAlineacion' order by orden";
	$arrHAlineacion=uEJ($con->obtenerFilasArreglo($query));
	$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='fuente' order by orden";
	$arrFuentes=uEJ($con->obtenerFilasArreglo($query));
	$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='estiloBorde' order by orden";
	$arrEstilosBorde=uEJ($con->obtenerFilasArreglo($query));
?>	
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
                                                                                            	/*var almacen=p.Ext.getCmp('cmbEstilos').getStore();
                                                                                                var registro=new regCombo({id:txtNombreEstilo.getValue(),nombre:txtNombreEstilo.getValue(),valorComp:''});
                                                                                                almacen.add(registro);*/
                                                                                                recargarPagina();
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

var arrSiNo=<?php echo $arrSiNo?>;
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
    var ctrlSiNo=crearComboExt('cmbSiNoAtt',arrSiNo);
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