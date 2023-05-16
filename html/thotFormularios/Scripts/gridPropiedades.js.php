<?php session_start();
include("conexionBD.php"); 
include("configurarIdiomaJS.php");
$idFormulario=bD($_GET["idFormulario"]);

$consulta="select idTipoDocumento,tipoDocumento from 906_tipoDocumentos";
$tDocumentos=($con->obtenerFilasArreglo($consulta));

$query="select nombreEstilo,nombreEstilo from 932_estilos";
$arrEstilos=uEJ($con->obtenerFilasArreglo($query));

$res5=$con->obtenerFilas("select idIdioma,idioma,imagen from 8002_idiomas where idiomaSistema=1");
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

$query="select idEnlace,titulo,enlace,descripcion,tipoReferencia from 9040_listadoEnlaces where idFormulario=".$idFormulario." and tipoEnlace=0 order by titulo";
$arrEnlaces=$con->obtenerFilasArreglo($query);
if($arrEnlaces!="[]")
	$arrEnlaces="[['','Ninguno'],".substr($arrEnlaces,1);
else
	$arrEnlaces="[['','Ninguno']]";
	
$consulta="select idProceso,nombre from 4001_procesos order by nombre";
$arrProcesos=uEJ($con->obtenerFilasArreglo($consulta));

$consulta="SELECT idFuncion,nombreFuncion FROM 9033_funcionesScriptsSistema where idCategoria=1 ORDER BY nombreFuncion";
$arrFuncionesRenderer=$con->obtenerFilasArreglo($consulta);

$consulta="SELECT valor,texto FROM 1004_siNo";
$arrSiNo=$con->obtenerFilasArreglo($consulta);

$consulta="SELECT idRegistro, CONCAT('[',cveCategoria,'] ',nombreCategoria) FROM 00015_categoriasCamposFormulario ORDER BY nombreCategoria";
$arrCategoriasCampos=$con->obtenerFilasArreglo($consulta);
?>
var arrCategoriasCampos=<?php echo $arrCategoriasCampos ?>;
var arrSiNo=<?php echo $arrSiNo ?>;
var arrFuncionesRenderer=<?php echo $arrFuncionesRenderer?>;

var dsComboSeleccion;
var arrEnlaces=<?php echo $arrEnlaces?>;
var idDivSel;
var idElementoSel;
var arrProcesos=<?php echo $arrProcesos?>;
var ordenOpciones=[['0','Contenido'],['2','Orden de inserci\xF3n'],['1','Valor']];
var arrOrigenFechaHora=[['1','Fecha/hora del servidor'],['2','Fecha/hora del equipo local']];
function inicializarGrid()
{
	arrFuncionesRenderer.splice(0,0,['','Ninguno']);
	arrCategoriasCampos.splice(0,0,['0','Ninguno']);
	
    
    var cmbCategoriaCampos=crearComboExt('cmbCategoriaCampos',arrCategoriasCampos);
    var cmbCorrecionOrtografica=crearComboExt('cmbCorrecionOrtografica',arrSiNo);
    var cmbFuncionRenderer=crearComboExt('cmbFuncionRenderer',arrFuncionesRenderer);
    
	var comboSiNoObl=crearComboExt('cmbSiNoProp',arrSiNo);
    var comboNumTab=crearComboExt('comboNumTab',[]);
    comboSiNoObl.setPosition(0,0);
    var comboSiNoVin=crearComboExt('cmbSiNoVin',arrSiNo);
    comboSiNoVin.setPosition(0,0);
    var comboTipoDoc=crearComboExt('cmbTipoDocGrid',<?php echo $tDocumentos?>);
    comboTipoDoc.setPosition(0,0);
    var comboSiNoPermitirAgregar=crearComboExt('cmbSiNoPermitirAgregar',arrSiNo);
    comboSiNoPermitirAgregar.setPosition(0,0);
    
    var cmbPermiteModificar=crearComboExt('cmbPermiteModificar',arrSiNo);
    var cmbPermiteEliminar=crearComboExt('cmbPermiteEliminar',arrSiNo);
    
    var cmbListadoEnlaces=crearComboExt('cmbListadoEnlaces',arrEnlaces,0,0,200);

    ctrlDefault=crearComboExt('cmbDefault',[]);
    dsComboSeleccion=ctrlDefault.getStore();
    var ctrlVSesion=crearComboExt('cmbVersionCtrl',tVSesion);
    ctrlVSesion.setPosition(0,0);
    var arrTratoDec=[['1','Redondear'],['2','Truncar']];
    var ctlTratoDec=crearComboExt('cmbTratoDec',arrTratoDec,0,0);
    var cmbOrdenInsercion=crearComboExt('cmbOrdenInsercion',ordenOpciones);
   
 	var arrEstilos=<?php echo $arrEstilos?>;
    var objConfEstilo={};
    objConfEstilo.confVista='<tpl for="."><div class="search-item"><span class="{nombre}">{nombre}</span></div></tpl>';
    var cmbEstilos=crearComboExt('cmbEstilos',arrEstilos,0,0,0,objConfEstilo);
     
    var fuente={};
     
    var fechaCtrl=new Ext.form.DateField	(
                                                {
                                                    readOnly :false,
                                                    format:'d/m/Y'
                                                }
                                            )
    var fechaCtrl2=new Ext.form.DateField	(
                                                {
                                                    readOnly :false,
                                                    format:'d/m/Y'
                                                }
                                            )    

     var horaCtrl=new Ext.form.TimeField	(
                                                {
                                                    readOnly :false,
                                                    format:'H:i'
                                                }
                                            )
    var horaCtrl2=new Ext.form.TimeField	(
                                                {
                                                    readOnly :false,
                                                    format:'H:i'
                                                }
                                            )    
                                            
    var txtNombre=new Ext.form.TextField	(	
                                                {
                                                    id:'txtNombre',
                                                    maskRe:/^[a-zA-Z0-9]$/
                                                }
                                            )    


	var txtValorDefault=new Ext.form.TextField	(	
                                                    {
                                                        id:'txtValorDefault'
                                                    }
                                                )  
	
    
    var txtTituloCampo=new Ext.form.TextField	(	
                                                    {
                                                        id:'txtTituloCampo'
                                                    }
                                                )  
    
	var txtParametro=new Ext.form.TextField	(	
                                                {
                                                    id:'txtParametro',
                                                    maskRe:/^[a-zA-Z0-9]$/
                                                }
                                            )   

	var txtFormato=new Ext.form.TextField	(	
                                                {
                                                    id:'txtFormato'
                                                }
                                            )    
                                            
                                            
	 var txtArchConf=new Ext.form.TextField	(	
                                                {
                                                    id:'txtArchConf'
                                                }
                                            )                                            
     
     
    var txtEstiloComp=new Ext.form.TextField	(	
                                                {
                                                    id:'txtEstiloComp'
                                                }
                                            )   
    
    
    var txtEstiloCompList=new Ext.form.TextField	(	
                                                {
                                                    id:'txtEstiloList'
                                                }
                                            )  
                                                                                    
	var cmbOrigenFecha=crearComboExt('cmbOrigenFecha',arrOrigenFechaHora,0,0);                                            
                           
                           
                           
	                         
                                                                            
    var propsGrid = 	new Ext.grid.PropertyGrid	(
                                                        {
                                                        	tbar:	[
                                                            			{
                                                                            icon:'../images/cancel_round.png',
                                                                            tooltip:'Eliminar elemento',
                                                                            text:'Eliminar elemento',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:true,
                                                                            id:'btnDelElemento',
                                                                            handler:function()	
                                                                                    {
                                                                                        h.eliminarElemento(idElementoSel);
                                                                                    }
                                                                        },
                                                            			{
                                                                        	id:'btnModificarConElemento',
                                                                        	text:'Modificar configuraci&oacute;n',
                                                                            icon:'../images/pencil.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:true,
                                                                            handler:function()
                                                                            		{
                                                                                    	switch(tipoControl)
                                                                                        {
                                                                                        	case '4':
                                                                                            case '16':
                                                                                            case '19':
                                                                                            	var autocompleta='0';
                                                                                                if(tipoControl=='4')
                                                                                                {
                                                                                                	var div=h.gE(h.idDivSel);
                                                                                                    var nControl=div.getAttribute('controlInterno');
                                                                                                    var arrNomAnt=nControl.split('_');
                                                                                                    var control='_'+arrNomAnt[1];
                                                                                                    var ctrl=h.gE('_'+arrNomAnt[1]);
                                                                                                	if(ctrl.getAttribute('auto')=='true')
                                                                                                    	autocompleta='1';
                                                                                               	}
                                                                                            	var obj={tipoElemento:tipoControl,idElemento:h.idControlSel,auto:autocompleta};

                                                                                            	modificarOpcionesAlmacen(obj);
                                                                                            break;
                                                                                        	case '2':
                                                                                            case '14':
                                                                                            case '17':
                                                                                            	modificarOpcionesManuales(h.idControlSel);
                                                                                            break;
                                                                                            case '3':
                                                                                            case '15':
                                                                                            case '18':
                                                                                            	mostrarModificarIntervalo(h.idControlSel);
                                                                                            break;
                                                                                        	case '8':
                                                                                            	mostrarVentanaConfiguracionFecha();
                                                                                            break;
                                                                                        	case '22':
                                                                                            	var div=h.gE(h.idDivSel);
                                                                                                var nControl=div.getAttribute('controlInterno');
                                                                                                var arrNomAnt=nControl.split('_');
                                                                                                var control='_'+arrNomAnt[1];
                                                                                                mostrarVentanaCampoOperacion(control);
                                                                                            break;
                                                                                        	case '29':
                                                                                            	mostrarVentanaConfiguracionGrid('',h.idControlSel);

                                                                                            break;
                                                                                        }
                                                                                    }
                                                                        }
                                                                        
                                                            		],
                                                            id:'GridPropiedades',
                                                            region:'center',
                                                            
                                                            autoScroll:true,
                                                            title:'Propiedades del control',
                                                            customEditors: {
                                                            					'funcionRenderer':new Ext.grid.GridEditor(cmbFuncionRenderer),
                                                                                'categoriaCampo':new Ext.grid.GridEditor(cmbCategoriaCampos),
                                                                                'correcionOrtografica':new Ext.grid.GridEditor(cmbCorrecionOrtografica),
                                                                                'obligatorio': new Ext.grid.GridEditor(comboSiNoObl),
                                                                                'tipoArch':new Ext.grid.GridEditor(comboTipoDoc),
                                                                                'fechaMin':new Ext.grid.GridEditor(fechaCtrl),
                                                                                'fechaMax':new Ext.grid.GridEditor(fechaCtrl2),
                                                                                'horaMin':new Ext.grid.GridEditor(horaCtrl),
                                                                                'horaMax':new Ext.grid.GridEditor(horaCtrl2),
                                                                                'selDefault':new Ext.grid.GridEditor(ctrlDefault),
                                                                                'varSesion':new Ext.grid.GridEditor(ctrlVSesion),
                                                                                'actualizable': new Ext.grid.GridEditor(comboSiNoObl),
                                                                                'nombre':new Ext.grid.GridEditor(txtNombre),
                                                                                'valorDefault':new Ext.grid.GridEditor(txtValorDefault),
                                                                                'vincular':new Ext.grid.GridEditor(comboSiNoVin),
                                                                                'tratoDec':new Ext.grid.GridEditor(ctlTratoDec),
                                                                                'orden':new Ext.grid.GridEditor(comboNumTab),
                                                                                'estilo':new Ext.grid.GridEditor(cmbEstilos),
                                                                                'habilitado':new Ext.grid.GridEditor(comboSiNoVin),
                                                                                'visible':new Ext.grid.GridEditor(comboSiNoVin),
                                                                                'permitirAgregar':new Ext.grid.GridEditor(comboSiNoPermitirAgregar),
                                                                                'permiteModificar':new Ext.grid.GridEditor(cmbPermiteModificar),
                                                                                'permiteEliminar':new Ext.grid.GridEditor(cmbPermiteEliminar),
                                                                                'enlace':new Ext.grid.GridEditor(cmbListadoEnlaces),
                                                                                'ordenIns':new Ext.grid.GridEditor(cmbOrdenInsercion),
                                                                                'parametro':new Ext.grid.GridEditor(txtParametro),
                                                                                'formato':new Ext.grid.GridEditor(txtFormato),
                                                                                'origenFecha':new Ext.grid.GridEditor(cmbOrigenFecha),
                                                                                'archivoConf':new Ext.grid.GridEditor(txtArchConf),
                                                                                'estiloComplementario':new Ext.grid.GridEditor(txtEstiloComp),
                                                                                'estiloLista':new Ext.grid.GridEditor(txtEstiloCompList),
                                                                                'tituloCampo':new Ext.grid.GridEditor(txtTituloCampo)
                                                                                
                                                                                
                                                                                
                                                                            },
                                                            customRenderers:  {
                                                            					funcionRenderer:formatearFuncionRenderer,
                                                                                obligatorio:formatearValor,
                                                                                tipoArch:formatearTipoArch,
                                                                                fechaMin:formatearFecha,
                                                                                fechaMax:formatearFecha,
                                                                                horaMin:formatearHora,
                                                                                horaMax:formatearHora,
                                                                                selDefault:formatearSel,
                                                                                actualizable:formatearValor,
                                                                                varSesion:formatearVSesion,
                                                                                vincular:formatearValor,
                                                                                tratoDec:formatearTratoDec,
                                                                                enlace:formatearBtnEnlace,
                                                                                habilitado:formatearValor,
                                                                                visible:formatearValor,
                                                                                permitirAgregar:formatearSiNo,
                                                                                permiteEliminar:formatearSiNo,
                                                                                permiteModificar:formatearSiNo,
                                                                                enlace:formatearEnlace,
                                                                                ordenIns:formatearOrdenInsercion,
                                                                                minObl:formatearMinObl,
                                                                                paginaAgregacion:formatearAgregacion,
                                                                                almacenDatos:formatearOrigenDatos,
                                                                                origenFecha:formatearOrigenFecha,
                                                                                categoriaCampo: function(val)
                                                                                				{
                                                                                                	return formatearValorRenderer(arrCategoriasCampos,val);
                                                                                                },
                                                                                correcionOrtografica: formatearSiNo
                                                                                
                                                                            },
                                                            propertyNames: {
                                                            					funcionRenderer:'Funci&oacute;n renderer',
                                                                                estiloLista:'Estilo Listado',
                                                                                formato:'Formato de fecha',
                                                                                origenFecha:'Origen fecha/hora',
                                                                                etiqueta:'Etiqueta',
                                                                                nombre:'Nombre',
                                                                                obligatorio:'Obligatorio',
                                                                                ancho:'Ancho',
                                                                                longMax:'M&aacute;x. Longitud',
                                                                                alto:'Alto',
                                                                                fechaMin:'Fecha Min.',
                                                                                fechaMax:'Fecha M&aacute;x.',
                                                                                tamano:'Tam. m&aacute;ximo (kb)',
                                                                                numCol:'N&uacute;m. Columnas',
                                                                                anchoCelda:'Ancho Columna',
                                                                                selDefault:'Valor Default',
                                                                                minObl:'Selección m&iacute;nima',
                                                                                varSesion:'Valor de sesi&oacute;n',
                                                                                actualizable:'Modificable',
                                                                                tipoArch:'Tipo archivo',
                                                                                horaMin:'Hora m&iacute;nima',
                                                                                horaMax:'Hora m&aacute;xima',
                                                                                intervalo:'Intervalo',
                                                                                numDecimales:'# Decimales',
                                                                                separaMiles:'Separador Miles',
                                                                                separaDec:'Separador Decimales',
                                                                                tratoDec:'Trato decimales',
                                                                                vincular:'Vincular con Lita',
                                                                                enlace:'Vincular a enlace',
                                                                                orden:'Orden Tab.',
                                                                                estilo:'Estilo',
                                                                                estiloComplementario:'Estilo',
                                                                                habilitado:'Habilitado',
                                                                                visible:'Visible',
                                                                                permitirAgregar:'Permitir agregar',
                                                                                permiteModificar:'Permitir modificar',
                                                                                permiteEliminar:'Permitir eliminar',
                                                                                ordenIns:'Ordenar opciones por:',
                                                                                almacen:'Almac&eacute;n vinculado',
                                                                                wordMax:'M&aacute;x. palabras',
                                                                                parametro:'Par&aacute;metro',
                                                                                etExport:'Etiqueta exportaci&oacute;n',
                                                                                tagXML:'Tag XML',
                                                                                paginaAgregacion:'P&aacute;gina de agregaci&oacute;n',
                                                                                etiquetaAgregar:'Etiqueta Agregar',
                                                                                etiquetaRemover:'Etiqueta Remover',
                                                                                almacenDatos:'Origen de Datos',
                                                                                archivoConf:'Archivo de Conf.',
                                                                                valorDefault:'Valor Default',
                                                                                categoriaCampo: 'Categor&iacute;a del Campo',
                                                                                tituloCampo:'T&iacute;tulo Campo',
                                                                                correcionOrtografica: 'Verificar Ortograf&iacute;a'
                                                                                
                                                                                
                                                                                <?php 
                                                                                    echo $arrLblRender;
                                                                                ?>
                                                                            },
                                                            source: fuente,
                                                            viewConfig : 
                                                                            {
                                                                                forceFit: true,
                                                                                scrollOffset: 2 
                                                                            }
                                                            

                                                        }
                                                    );
    var colM=propsGrid.getColumnModel();                                                
    var nomCol=colM.getColumnId(1);
    var col=colM.getColumnById(nomCol);
    colM.setColumnHeader(1,'Valor');
    colM.setColumnHeader(0,'Propiedad');
    colM.setRenderer(1,formatearValor);
    propsGrid.on('beforeedit',validarEdicion);
    propsGrid.on('afteredit',regCambiado);                                                    	
    return propsGrid
}

function formatearOrigenFecha(value)
{
	return formatearValorRenderer(arrOrigenFechaHora,value);
}

function formatearFuncionRenderer(valor)
{
	return formatearValorRenderer(arrFuncionesRenderer,valor);
}

function formatearOrigenDatos(valor)
{
	var btnModificar='<a href="javascript:modificarOrigenDatos()"><img src="../images/pencil.png" width="11" height="11" title="Modificar origen de datos" alt=="Modificar origen de datos" /></a>';
    var btnEliminar='<a href="javascript:removerOrigenDatos()"><img src="../images/delete.png" width="11" height="11" title="Remover origen de datos" alt=="Modificar origen de datos" /></a>';
	if(valor=='')
    	return btnModificar+' (Ninguno)';
    else
    {
    	var obj=eval('['+valor+']')[0];
        var nodoAlmacen=buscarNodoID(gEx(idArbolDataSet).getRootNode(),+obj.almacen);
        var almacen=nodoAlmacen.text;
        var lblEtiqueta='Almacen: '+almacen+', Etiqueta: ['+obj.campoEtUsuario+']';
        var lblEtiqueta2='<b>Almacen:</b> '+almacen+', <b>Etiqueta:</b> ['+obj.campoEtUsuario+']';
     	return btnModificar+'&nbsp;&nbsp;'+btnEliminar+' <span title="'+lblEtiqueta+'" alt="'+lblEtiqueta+'">'+lblEtiqueta2+'</span>';   
    }
    	
}

function formatearAgregacion(valor)
{
	return ' <a href="javascript:agregarFormulacionAgregacion(\''+bE(idElementoSel)+'\')"><img src="../images/pencil.png" width="13" height="13" /></a>&nbsp;'+valor;
}

function formatearMinObl(valor)
{
	if(valor=='-1')
    	return '0';
     return valor;
}

function formatearOrdenInsercion(value)
{
	return formatearValorRenderer(ordenOpciones,value);
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

function establecerFuenteVacia()
{
	var fuente={};
    var gridPropiedades=Ext.getCmp('GridPropiedades');
    gridPropiedades.setSource(fuente);
    gridPropiedades.getView().refresh();
    gEx('btnDelElemento').hide();
	idElementoSel='';
}


function establecerFuente(idControl)
{

	var fuente={};
    var div=h.gE(idControl);
    idDivSel=idControl;
    divCtrlSel=div;

    var arrDatosDiv=idControl.split('_');
    idElementoSel=arrDatosDiv[1];

    var gridPropiedades=Ext.getCmp('GridPropiedades');

    gEx('btnModificarConElemento').hide();
    
    if(divCtrlSel.getAttribute('eliminable')=='1')
	    gEx('btnDelElemento').show();
    else
    	gEx('btnDelElemento').hide();
    var mostrarEtExport=false;
    if(divCtrlSel.getAttribute('etiquetaExportacion')!=null)
    	mostrarEtExport=true;
    var nomControl=div.getAttribute('controlInterno');
   
   
    
	var vOrden=div.getAttribute('orden');
    arrNomControl=nomControl.split('_');
    tipoControl=arrNomControl[2];
    
	var ctrlNombre=arrNomControl[1].substr(0,arrNomControl[1].length-3); 
    
    var nombreControlAplicacion='_'+arrNomControl[1];
    
    var ctrl=h.gE('_'+arrNomControl[1]);

    var x=parseInt(div.style.left.substr(0,div.style.left.length-2))-h.posDivX;
    var y=parseInt(div.style.top.substr(0,div.style.top.length-2))-h.posDivY;
    var obl=0;
    if(ctrl!=null)
    {
        obl=ctrl.getAttribute('val');
        if((obl==null)||(obl.indexOf('obl')==-1))
            obl=0;
        else
            obl=1;
	}
    var tControl=parseInt(tipoControl);
	var vVisible='1';
    var aVisible=div.getAttribute('visible');
    if(aVisible!=null)
    	vVisible=aVisible;
    var vHabilitado='1';
    var aHabilitado=div.getAttribute('habilitado');
    if(aHabilitado!=null)
    	vHabilitado=aHabilitado;
    var cFondo=div.getAttribute('colorFondo1');
    if(cFondo==null)
	   	cFondo='';
    
    gEx('btnAddAccion').disable();
    gEx('btnDelAyuda').disable();
    gEx('btnAddAyuda').enable();       
    if(h.gE('imgAyuda_'+idElementoSel)!=null)
	  	gEx('btnDelAyuda').enable();
    var tControl=tipoControl+'';
   
   	///
    var vDefault='';
    var vCategoria='';
    var vCorrecionOrtografica='';
    var objConfElemento;
    var cadObjConfElemento=divCtrlSel.getAttribute('objConfElemento');
    var fRenderer='';
    var estiloCtrl='';
    var anchoCampo='';
    var estiloCtrlLista='';
    var tituloCampoConf='';
    if(cadObjConfElemento && cadObjConfElemento!='')
    {
        
		objConfElemento=eval(bD(cadObjConfElemento))[0];
        vDefault=objConfElemento.campoConf16!=''?objConfElemento.campoConf16:'(Ninguno)';
        vCategoria=objConfElemento.campoConf14!=''?objConfElemento.campoConf14:'0';
        vCoreccionOrtografica=objConfElemento.campoConf15!=''?objConfElemento.campoConf15:'0';
        fRenderer=objConfElemento.campoConf18!=''?objConfElemento.campoConf18:'';
        estiloCtrl=objConfElemento.campoConf12!=''?objConfElemento.campoConf12:'';
        anchoCampo=objConfElemento.campoConf10!=''?objConfElemento.campoConf10:'';
        estiloCtrlLista=objConfElemento.campoConf13!=''?objConfElemento.campoConf13:'';
		tituloCampoConf=objConfElemento.campoConf21!=''?objConfElemento.campoConf21:'';
    }   
   
    ///
   
    switch(tControl)
    {
    	case '-1': 
        case '0':
        	ctrl=h.gE('btn_'+tipoControl);
        	var estiloCtrl=obtenerClase(ctrl);
        	fuente=	{
            			
                        X:x,
                        Y:y,
                        orden:vOrden,
                        estilo:estiloCtrl
                        
            		}
			gEx('btnAddAyuda').disable();                    
        break;
    	case '1':  //etiqueta
            var ct=0;
            var arrCampos=',';
            var valorEt='';
            var enlace=h.gE('_lbl'+h.idControlSel).getAttribute('enlace');
            for(ct=0;ct<nIdiomas;ct++)
            {
            	valorEt=h.gE('td_'+h.idControlSel+'_'+arrIdiomas[ct].idIdioma).value;
            	arrCampos+='"etiqueta_'+arrIdiomas[ct].idIdioma+'":"'+valorEt+'"';
            }
            var estilo=obtenerClase(ctrl);
            
            var txtObj='[{"ancho":"'+h.gE('_lbl'+idElementoSel).style.width.replace('px','')+'","alto":"'+h.gE('_lbl'+idElementoSel).style.height.replace('px','')+'","enlace":"'+enlace+'","X":"'+x+'","Y":"'+y+'"'+arrCampos+',"estilo":"'+estilo+'","visible":"'+vVisible+'"}]';
        	
            fuente=	eval(txtObj)[0];
            gEx('btnAddAyuda').disable()
        break;
    	case '2': //pregunta cerrada-Opciones Manuales
		case '3': //pregunta cerrada-Opciones intervalo
		case '4': //pregunta cerrada-Opciones tabla
        	gEx('btnModificarConElemento').show();
        	
            var pagina=ctrl.getAttribute('valorPagina');
            var vDefault='-1';
            
            var arrOpciones=[['-1','Ninguno']];
            var ct;
            var combo=h.gE('_'+ctrlNombre+'vch');
            
            var idFuncionRenderer='';
            if((combo.getAttribute('funcRenderer')!=null)&&(combo.getAttribute('funcRenderer')!=''))
            	idFuncionRenderer=combo.getAttribute('funcRenderer');
                
            vDefault=combo.getAttribute('vDefault');
            if(vDefault==null)
            	vDefault='-1';
            if(combo.options!=undefined)
            {
                for(ct=0;ct<combo.options.length;ct++)
                {
                    arrOpciones.push([combo.options[ct].value,combo.options[ct].text]);
                }
	            dsComboSeleccion.loadData(arrOpciones);
            }
            var anchoC=ctrl.getAttribute('ancho');
            if(ctrl.getAttribute('auto')!=null)
			{            
				
                fuente=	{
                            nombre:ctrlNombre,
                            X:x,
                            Y:y,
                            obligatorio:obl,
                            tituloCampo:tituloCampoConf,
                            orden:vOrden,
                            estiloComplementario:estiloCtrl,
                            ancho:anchoC,
                            visible:vVisible,
                            habilitado:vHabilitado,
                            categoriaCampo:vCategoria,
                            permitirAgregar:ctrl.getAttribute('permiteAgregar'),
                            estiloLista:estiloCtrlLista,
                            paginaAgregacion:pagina
                        }
             }  
             else
             {
             	fuente=	{
                            nombre:ctrlNombre,
                            X:x,
                            Y:y,
                            ancho:anchoC,
                            tituloCampo:tituloCampoConf,
                            obligatorio:obl,
                            selDefault:vDefault,
                            orden:vOrden,
                            estilo:estiloCtrl,
                            visible:vVisible,
                            habilitado:vHabilitado,
                            categoriaCampo:vCategoria,
                            permitirAgregar:ctrl.getAttribute('permiteAgregar'),
                            paginaAgregacion:pagina,
                            funcionRenderer:idFuncionRenderer
                        }
             } 
             if(tControl=='2')
             {
             	var oInsercion=h.gE('ordenOpt_'+arrNomControl[1]).value;
                if(oInsercion=='')
                	oInsercion='0';
             	fuente.ordenIns=oInsercion;
             }
             if(tControl=='4')
             {
             	var ctrl=h.gE('_'+arrNomControl[1]);
                var idAlmacen=ctrl.getAttribute('idAlmacen');
                if(idAlmacen!=null)
                {
                	var nodoRaiz=gEx('arbolDataSet').getRootNode();
                    var nodoAlmacen=buscarNodoID(nodoRaiz,idAlmacen);
	             	fuente.almacen=nodoAlmacen.text;
                }
             }
             
             gEx('btnAddAccion').enable();
		     
		break;
		case '6': //Número entero
        	var txtAncho=ctrl.size;
            var estiloCtrl=obtenerClase(ctrl);
            var separadorMiles=h.gE('sepMiles__'+arrNomControl[1]).value;
            var lita=h.gE('lita__'+arrNomControl[1]).value;
            
            var objAlmacen='';
            if(ctrl.getAttribute('objAlmacenDatos')!=null)
            	objAlmacen=bD(ctrl.getAttribute('objAlmacenDatos'));
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        ancho:txtAncho,
                        vincular:lita,
                        orden:vOrden,
                        estilo:estiloCtrl,
                        visible:vVisible,
                        tituloCampo:tituloCampoConf,
                        habilitado:vHabilitado,
                        separaMiles:separadorMiles,
                        valorDefault:vDefault,
                        categoriaCampo:vCategoria,
                        funcionRenderer:fRenderer,
                        almacenDatos:objAlmacen
            		}
        break;
		case '7': //Número decimal
        	var txtAncho=ctrl.size;
            var nDecimales=h.gE('numD_'+'_'+arrNomControl[1]).value;
            var separadorMiles=h.gE('sepMiles__'+arrNomControl[1]).value;
            var separadorDecimales=h.gE('sepDec__'+arrNomControl[1]).value;
            var lita=h.gE('lita__'+arrNomControl[1]).value;
            var estiloCtrl=obtenerClase(ctrl);
            
            var objAlmacen='';
            if(ctrl.getAttribute('objAlmacenDatos')!=null)
            	objAlmacen=bD(ctrl.getAttribute('objAlmacenDatos'));
                
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        ancho:txtAncho,
                        vincular:lita,
                        tituloCampo:tituloCampoConf,
                        orden:vOrden,
                        estilo:estiloCtrl,
                        visible:vVisible,
                        habilitado:vHabilitado,
                        numDecimales:nDecimales,
                        separaMiles:separadorMiles,
                        valorDefault:vDefault,
                        categoriaCampo:vCategoria,
                        funcionRenderer:fRenderer,
                        almacenDatos:objAlmacen
            		}
                           
		break;
		case '8': //Fecha
            
            var objAlmacen='';
            if(ctrl.getAttribute('objAlmacenDatos')!=null)
            	objAlmacen=bD(ctrl.getAttribute('objAlmacenDatos'));
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        orden:vOrden,
                        visible:vVisible,
                        estiloComplementario:estiloCtrl,
                        habilitado:vHabilitado,
                        valorDefault:vDefault,
                        tituloCampo:tituloCampoConf,
                        ancho:anchoCampo,
                        categoriaCampo:vCategoria,
                        funcionRenderer:fRenderer,
                        almacenDatos:objAlmacen
                        
            		}
             gEx('btnModificarConElemento').show();
		break;
		case '9'://Texto Largo 
        case '10': //Texto Enriquecido
        	var txtAncho;
            var txtAlto;
           
            if(tipoControl=='9')
            {
            	var idFuncionRenderer='';
                if((ctrl.getAttribute('funcRenderer')!=null)&&(ctrl.getAttribute('funcRenderer')!=''))
                    idFuncionRenderer=ctrl.getAttribute('funcRenderer');
             	var txtLongMax=ctrl.getAttribute('maxlength');
	            var txtMaxPalabras=ctrl.getAttribute('maxWord');
            	txtAncho=ctrl.style.width.replace('px','');
                var objAlmacen='';
	            if(ctrl.getAttribute('objAlmacenDatos')!=null)
    	        	objAlmacen=bD(ctrl.getAttribute('objAlmacenDatos'));
                txtAlto=ctrl.style.height.replace('px','');
                var estiloCtrl=obtenerClase(ctrl);
                fuente=	{
                            nombre:ctrlNombre,
                            X:x,
                            Y:y,
                            obligatorio:obl,
                            ancho:txtAncho,
                            alto:txtAlto,
                            orden:vOrden,
                            estilo:estiloCtrl,
                            visible:vVisible,
                            habilitado:vHabilitado,
                            longMax:txtLongMax,
                            tituloCampo:tituloCampoConf,
	                        wordMax:txtMaxPalabras,
                            almacenDatos:objAlmacen,
                            valorDefault:vDefault,
                            correcionOrtografica:vCoreccionOrtografica,
                            categoriaCampo:vCategoria,
                            funcionRenderer:idFuncionRenderer
                        }
            }  
            else
            {
            	var texto;
                
            	if(divCtrlSel.getAttribute('version2')==undefined)
                {
                    texto=h.gEx('_'+ctrlNombre+'vch');
                    
                    txtAncho=texto.getWidth();
                    txtAlto=texto.getHeight();
                }
                else
                {
                	
                	texto=h.CKEDITOR.instances['txt'+nombreControlAplicacion];
                    txtAncho=texto.config.width;
                    txtAlto=texto.config.height;
                    
                    
                    var ctrl= h.gE('txtEnriquecido_'+arrDatosDiv[1]);
                    var obl=0;
                
                    obl=ctrl.getAttribute('val');
                    if((obl==null)||(obl.indexOf('obl')==-1))
                        obl=0;
                    else
                        obl=1;
               
                    
                }
                fuente=	{
                            nombre:ctrlNombre,
                            X:x,
                            Y:y,
                            obligatorio:obl,
                            ancho:txtAncho,
                            alto:txtAlto,
                            orden:vOrden,
                            visible:vVisible,
                            tituloCampo:tituloCampoConf,
                            correcionOrtografica:vCoreccionOrtografica,
                            categoriaCampo:vCategoria,
                            funcionRenderer:fRenderer,
                            habilitado:vHabilitado
                            
                        }
                        
               if(divCtrlSel.getAttribute('version2')!=undefined)
               {
               		fuente.archivoConf=texto.config.customConfig;
                    
               }         
                        
            } 
             
		break;
        case '5': //Texto Corto
        	var idFuncionRenderer='';
            if((ctrl.getAttribute('funcRenderer')!=null)&&(ctrl.getAttribute('funcRenderer')!=''))
                idFuncionRenderer=ctrl.getAttribute('funcRenderer');
        	var txtAncho=ctrl.size;
            var txtLongMax=ctrl.getAttribute('maxlength');
            var txtMaxPalabras=ctrl.getAttribute('maxWord');
        	var estiloCtrl=obtenerClase(ctrl);
            
            var objAlmacen='';
            if(ctrl.getAttribute('objAlmacenDatos')!=null)
            	objAlmacen=bD(ctrl.getAttribute('objAlmacenDatos'));
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        ancho:txtAncho,
                        longMax:txtLongMax,
                        tituloCampo:tituloCampoConf,
                        wordMax:txtMaxPalabras,
                        orden:vOrden,
                        estilo:estiloCtrl,
                        visible:vVisible,
                        habilitado:vHabilitado,
                        valorDefault:vDefault,
                        almacenDatos:objAlmacen,
                        categoriaCampo:vCategoria,
                        correcionOrtografica:vCoreccionOrtografica,
                        funcionRenderer:idFuncionRenderer
            		}
		break;                   
		case '11': //Correo Electrónico
        	var txtAncho=ctrl.size;
            var txtLongMax=ctrl.getAttribute('maxlength');
        	var estiloCtrl=obtenerClase(ctrl);
           
            var objAlmacen='';
	        if(ctrl.getAttribute('objAlmacenDatos')!=null)
    	    	objAlmacen=bD(ctrl.getAttribute('objAlmacenDatos'));
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        ancho:txtAncho,
                        longMax:txtLongMax,
                        orden:vOrden,
                        estilo:estiloCtrl,
                        visible:vVisible,
                        tituloCampo:tituloCampoConf,
                        categoriaCampo:vCategoria,
                        habilitado:vHabilitado,
                        valorDefault:vDefault,
                        funcionRenderer:fRenderer,
                        almacenDatos:objAlmacen
            		}
		break;
		case '12': //Archivo
              var tam=objConfElemento.campoConf2;
              var tArch=objConfElemento.campoConf1;
              fuente=	{
                          nombre:ctrlNombre,
                          X:x,
                          Y:y,
                          obligatorio:obl,
                          tamano:tam,
                          tipoArch:tArch,
                          orden:vOrden,
                          tituloCampo:tituloCampoConf,
                          visible:vVisible,
                          categoriaCampo:vCategoria,
                          habilitado:vHabilitado,
                          estilo:estiloCtrl,
                      }	
		break;
        case '13': //Frame
        		txtAncho=ctrl.style.width.replace('px','');
                txtAlto=ctrl.style.height.replace('px','');
                var arrCampos=',';
                for(ct=0;ct<nIdiomas;ct++)
                {
                	
                    valorEt=h.gE('td_'+h.idControlSel+'_'+arrIdiomas[ct].idIdioma).value;
                    arrCampos+='"etiqueta_'+arrIdiomas[ct].idIdioma+'":"'+valorEt+'"';
                }
                var txtObj='[{"X":"'+x+'","Y":"'+y+'"'+arrCampos+',"ancho":"'+txtAncho+'","alto":"'+txtAlto+'","visible":"'+vVisible+'"}]';
        		fuente=	eval(txtObj)[0];
                fuente.categoriaCampo=vCategoria,
                gEx('btnAddAyuda').disable();
                
        break;
        case '14':
        case '15':
        case '16':
        	gEx('btnModificarConElemento').show();
        	vHidden='numCol_'+arrNomControl[1];
        	var numC=h.gE(vHidden).value;
            var ancho=h.gE('anchoCelda_'+arrNomControl[1]).value;
            var aDatos=h.gE('lista_'+arrNomControl[1]).value;
            var nDatos="[['100584','Ninguno'],"+aDatos.substr(1);
            var arrDatos=eval(nDatos);
            dsComboSeleccion.loadData(arrDatos);
            var vDefault=h.gE('default_'+arrNomControl[1]).value;
            if(vDefault=='-1')
            	vDefault='100584';
            if(ancho=='')
            	ancho=0;
            var estiloCtrl=obtenerClase(ctrl);
            var idFuncionRenderer='';
            if((ctrl.getAttribute('funcRenderer')!=null)&&(ctrl.getAttribute('funcRenderer')!=''))
                idFuncionRenderer=ctrl.getAttribute('funcRenderer');
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        numCol:numC,
                        anchoCelda:ancho,
                        selDefault:vDefault,
                        orden:vOrden,
                        categoriaCampo:vCategoria,
                        estilo:estiloCtrl,
                        visible:vVisible,
                        tituloCampo:tituloCampoConf,
                        habilitado:vHabilitado,
                        funcionRenderer:idFuncionRenderer,
                        obligatorio:obl
            		}
            if(tControl=='14')
            {
             	var oInsercion=h.gE('ordenOpt_'+arrNomControl[1]).value;
                if(oInsercion=='')
                	oInsercion='0';
             	fuente.ordenIns=oInsercion;
            }
            if(tControl=='16')
           {
              var ctrl=h.gE('_'+arrNomControl[1]);
              var idAlmacen=ctrl.getAttribute('idAlmacen');
              if(idAlmacen!=null)
              {
                  var nodoRaiz=gEx('arbolDataSet').getRootNode();
                  var nodoAlmacen=buscarNodoID(nodoRaiz,idAlmacen);
                  fuente.almacen=nodoAlmacen.text;
              }
           }
            gEx('btnAddAccion').enable();

        break;
        case '17':
        case '18':
        case '19':
        	gEx('btnModificarConElemento').show();
        	vHidden='numCol_'+arrNomControl[1];
        	var numC=h.gE(vHidden).value;
            var ancho=h.gE('anchoCelda_'+arrNomControl[1]).value;
            var aDatos=h.gE('lista_'+arrNomControl[1]).value;
            var nDatos="[['100584','Ninguno'],"+aDatos.substr(1);
            var arrDatos=eval(nDatos);
            dsComboSeleccion.loadData(arrDatos);
            var minimoObl=h.gE('minSel_'+arrNomControl[1]).value;
            if(ancho=='')
            	ancho=0;
            var estiloCtrl=obtenerClase(ctrl);
            var idFuncionRenderer='';
            if((ctrl.getAttribute('funcRenderer')!=null)&&(ctrl.getAttribute('funcRenderer')!=''))
                idFuncionRenderer=ctrl.getAttribute('funcRenderer');
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        numCol:numC,
                        anchoCelda:ancho,
                        minObl:minimoObl,
                        orden:vOrden,
                        tituloCampo:tituloCampoConf,
                        estilo:estiloCtrl,
                        visible:vVisible,
                        habilitado:vHabilitado,
                        categoriaCampo:vCategoria,
                        funcionRenderer:idFuncionRenderer
                        
            		}
            if(tControl=='17')
            {
             	var oInsercion=h.gE('ordenOpt_'+arrNomControl[1]).value;
                if(oInsercion=='')
                	oInsercion='0';
             	fuente.ordenIns=oInsercion;
            }
            if(tControl=='19')
             {
             	var ctrl=h.gE('_'+arrNomControl[1]);
                var idAlmacen=ctrl.getAttribute('idAlmacen');
                if(idAlmacen!=null)
                {
                	var nodoRaiz=gEx('arbolDataSet').getRootNode();
                    var nodoAlmacen=buscarNodoID(nodoRaiz,idAlmacen);
	             	fuente.almacen=nodoAlmacen.text;
                }
             }
        	gEx('btnAddAccion').enable();
		    
        break;
        case '20':
        	var vVSesion=h.gE('tipo_'+arrNomControl[1]).value;
            var vActualizable=h.gE('actualizable_'+arrNomControl[1]).value;
        	fuente=	{
            			nombre:ctrlNombre,
                        varSesion:vVSesion,
                        actualizable:vActualizable,
                        orden:vOrden
            		}
            
        break;
        case '21': //Hora
			var tmeFecha=h.gEx('f_sp_'+arrNomControl[1]);	
            var hFecha=h.gE('_'+arrNomControl[1]);
            var maxHora=hFecha.getAttribute('hMax');
            var minHora=hFecha.getAttribute('hMin');
            if(maxHora==null)
            	maxHora='';
            if(minHora==null)
            	minHora='';
            var interval=hFecha.getAttribute('intervalo');
            
           
            var objAlmacen='';
            if(ctrl.getAttribute('objAlmacenDatos')!=null)
            	objAlmacen=bD(ctrl.getAttribute('objAlmacenDatos'));
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        intervalo:interval,
                        obligatorio:obl,
                        horaMin:minHora,
                        horaMax:maxHora,
                        orden:vOrden,
                        tituloCampo:tituloCampoConf,
                        categoriaCampo:vCategoria,
                        visible:vVisible,
                        ancho:anchoCampo,
                        habilitado:vHabilitado,
                        valorDefault:vDefault,
                        estiloComplementario:estiloCtrl,
                        funcionRenderer:fRenderer,
                        almacenDatos:objAlmacen
            		}
		break;
        case '22':
        	gEx('btnModificarConElemento').show();
        	var nDecimales=h.gE('numD_'+'_'+arrNomControl[1]).value;
            var separadorMiles=h.gE('sepMiles__'+arrNomControl[1]).value;
            var separadorDecimales=h.gE('sepDec__'+arrNomControl[1]).value;
            var tratoDecimales=h.gE('tratoDec__'+arrNomControl[1]).value;
            var lita=h.gE('lita__'+arrNomControl[1]).value;
            var ctrlAux=h.gE('lbl__'+ctrlNombre+'flo');
			var estiloCtrl=obtenerClase(ctrlAux);
            
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        vincular:lita,
                        numDecimales:nDecimales,
                        separaMiles:separadorMiles,
                        separaDec:separadorDecimales,
                        tratoDec:tratoDecimales,
                        formula:'',
                        tituloCampo:tituloCampoConf,
                        categoriaCampo:vCategoria,
                        valorDefault:vDefault,
                        estilo:estiloCtrl,
                        funcionRenderer:fRenderer,
                        visible:vVisible
                        
            		}
        break;                    
    	case '23':
        	var txtAncho;
            var txtAlto;
            
            var imagen=h.gE('_'+ctrlNombre+'img');
            txtAncho=imagen.width;
            txtAlto=imagen.height;
           // var enlace=h.gE('_img'+h.idControlSel).getAttribute('enlace');
           enlace='';
            fuente=	{
                        nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        ancho:txtAncho,
                        alto:txtAlto,
                        categoriaCampo:vCategoria,
                        visible:vVisible,
                        enlace:enlace
                    }
        break;
        case '24':
        	var txtAncho=ctrl.size;
            var nDecimales=h.gE('numD_'+'_'+arrNomControl[1]).value;
            var separadorMiles=h.gE('sepMiles__'+arrNomControl[1]).value;
            var separadorDecimales=h.gE('sepDec__'+arrNomControl[1]).value;
            var lita=h.gE('lita__'+arrNomControl[1]).value;
        	var estiloCtrl=obtenerClase(ctrl);
           
            var objAlmacen='';
            if(ctrl.getAttribute('objAlmacenDatos')!=null)
                objAlmacen=bD(ctrl.getAttribute('objAlmacenDatos'));
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        tituloCampo:tituloCampoConf,
                        ancho:txtAncho,
                        vincular:lita,
                        orden:vOrden,
                        estilo:estiloCtrl,
                        visible:vVisible,
                        numDecimales:nDecimales,
                        separaMiles:separadorMiles,
                        habilitado:vHabilitado,
                        valorDefault:vDefault,
                        categoriaCampo:vCategoria,
                        funcionRenderer:fRenderer,
                        almacenDatos:objAlmacen
                        
            		}
        break;
        case '25':
        	
            var idFuncionRenderer='';
            if((ctrl.getAttribute('funcRenderer')!=null)&&(ctrl.getAttribute('funcRenderer')!=''))
                idFuncionRenderer=ctrl.getAttribute('funcRenderer');
        	
            var confCampo=eval('['+bD(ctrl.getAttribute('confCampo'))+']')[0];
            
            var txtAncho=confCampo.ancho;
            var estiloCtrl=obtenerClase(ctrl);
            
            fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        ancho:txtAncho,
                        orden:vOrden,
                        estilo:estiloCtrl,
                        visible:vVisible,
                        formato:confCampo.formato,
                        categoriaCampo:vCategoria,
                        origenFecha:confCampo.origenFecha,
                        funcionRenderer:idFuncionRenderer
                        
            		}
            
        break;
        case '29':
            var gridCtrl=h.gEx('grid_'+arrDatosDiv[1]);
            txtAncho=gridCtrl.getWidth();
            txtAlto=gridCtrl.getHeight();
            var contenedor=h.gE('contenedorSpanGrid_'+arrDatosDiv[1]);
            var pModificar=contenedor.getAttribute('permiteModificar');
            var pAgregar=contenedor.getAttribute('permiteAgregar');
            var pEliminar=contenedor.getAttribute('permiteEliminar');
            var etAgregar=contenedor.getAttribute('etAgregar');
            var etRemover=contenedor.getAttribute('etRemover');
            fuente=	{
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        ancho:txtAncho,
                        tituloCampo:tituloCampoConf,
                        alto:txtAlto,
                        orden:vOrden,
                        visible:vVisible,
                        habilitado:vHabilitado,
                        permiteModificar:pModificar,
                        permiteEliminar:pEliminar,
                        permitirAgregar:pAgregar,
                        etiquetaAgregar:etAgregar,
                        categoriaCampo:vCategoria,
                        estiloComplementario:estiloCtrl,
                        etiquetaRemover:etRemover
                    }
           gEx('btnModificarConElemento').show();
            
            
        break;
        case '30':
        	var estiloCtrl=obtenerClase(ctrl);
            var idFuncionRenderer='';
            if((ctrl.getAttribute('funcRenderer')!=null)&&(ctrl.getAttribute('funcRenderer')!=''))
                idFuncionRenderer=ctrl.getAttribute('funcRenderer');
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        estilo:estiloCtrl,
                        visible:vVisible,
                        funcionRenderer:idFuncionRenderer
                        
            		}
			var idAlmacen=ctrl.getAttribute('idAlmacen');
            if(idAlmacen!=null)
            {
                var nodoRaiz=gEx('arbolDataSet').getRootNode();
                var nodoAlmacen=buscarNodoID(nodoRaiz,idAlmacen);
                fuente.almacen=nodoAlmacen.text;
            }                    
        break;
        case '31':
        	var estiloCtrl=obtenerClase(ctrl);
        	fuente=	{
            			nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        estilo:estiloCtrl,
                        visible:vVisible,
                        valorDefault:vDefault,
                        categoriaCampo:vCategoria,
                        funcionRenderer:fRenderer,
                        parametro:ctrl.getAttribute('parametro')
                        
            		}
        break;
        case '33':
        	var txtAncho;
            var txtAlto;
            var imagen=h.gE('_'+ctrlNombre+'img');
            txtAncho=imagen.width;
            txtAlto=imagen.height;
           
            fuente=	{
                        nombre:ctrlNombre,
                        X:x,
                        Y:y,
                        ancho:txtAncho,
                        alto:txtAlto,
                        categoriaCampo:vCategoria,
                        visible:vVisible
                    }
        break;
    }    
    
    if(mostrarEtExport)
    	fuente.etExport=divCtrlSel.getAttribute('etiquetaExportacion');
    fuente.tagXML=divCtrlSel.getAttribute('tagXML');
    
    gridPropiedades.setSource(fuente);
    
    var datos=gridPropiedades.getStore();
    var posX=obtenerPosFila(datos,'name','X');
    var posY=obtenerPosFila(datos,'name','Y');
    if(posX>-1)
      	h.filaX=datos.getAt(posX);
    else
    	h.filaX=null;
  	if(posY>-1)
    	h.filaY=datos.getAt(posY);
    else
        h.filaY=null;
    gridPropiedades.getView().refresh();
}

function validarEdicion(e)
{
	switch(e.record.id)
    {
    	case 'almacen':
    	case 'fechaMin':
        case 'fechaMax':
    	case 'formula':
        case 'paginaAgregacion':
        case 'almacenDatos':
        	e.cancel=true;
        break;
        
    }
}

function regCambiado(registro)
{
	var campo=registro.record.get('name');
	var valor=registro.value;
    var idControl=h.idControlSel;
    var div=h.gE(idDivSel);
    var cadenaObj='';
    var objConfElemento=!div.getAttribute('objConfElemento')?null:eval(bD(div.getAttribute('objConfElemento')))[0];
    
    
    var controlI=div.getAttribute('controlInterno');
    var arrDatosCtrl=controlI.split('_');
    var nameControl='_'+arrDatosCtrl[1];
    var ctrSeleccionado=h.gE(nameControl);
    var accion=-1;
    var idIdioma='-1';
    
	switch(campo)
    {
    	case 'nombre': //1
        	accion=1;
        break;
       
        case 'obligatorio': //3
        	accion=3;
        break;
        case 'ancho': //4
        	accion=4;
        break;
        case 'longMax': //5
        	accion=5;
        break;
        case 'alto': //6
        	accion=6;
        break;
        case 'fechaMin': //7
        	accion=7;
           	if(valor!='') 
        		valor=valor.format('d/m/Y');
        break;
        case 'fechaMax': //8
        	accion=8;
            if(valor!='')
            	valor=valor.format('d/m/Y');
        break;
        case 'tamano': //9
        	accion=9;
        break;
        case 'tipoArch': //10
        	accion=10;
        break;
        case 'X':
        	accion=11;  //11
        break;
        case 'Y':
        	accion=12;	//12
        break;
        case 'numCol':
        	accion=14; //14
        break;
        case 'anchoCelda':
        	accion=15;
        break;
        case 'selDefault':
        	accion=16;
        break;
        case 'minObl':
        	accion=17;
        break;
        case 'varSesion':
        	accion=18;
        break;
        case 'actualizable':
        	accion=19;
        break;
        case 'horaMin':
        	accion=21;
        break;
        case 'horaMax':
        	accion=22;
        break;
        case 'intervalo':
        	accion=23;
        break;
        case 'numDecimales':
        	accion=24;
        break;
        case 'separaMiles':
        	accion=25;
        break;
        case 'separaDec':
        	accion=26;
        break;
        case 'tratoDec':
        	accion=27;
        break;
        case 'orden':
        	accion=28;
        break;
        case 'estiloComplementario':
        case 'estilo':
        	accion=29;
        break;
        case 'habilitado':
        	accion=30;
        break;
        case 'visible':
        	accion=31;
        break;
        case 'vincular':
        	accion=32;
        break;
        
        case 'permitirAgregar':
        	accion=34;
        break;
        case 'permiteModificar':
        	accion=35;
        break;
        case 'permiteEliminar':
        	accion=36;
        break;
        case 'enlace':
        	accion=37;
        break;
        case 'ordenIns':
        	accion=38;
        break;
        case 'wordMax':
        	accion=39;
        break;
        case 'permitirAgregar':
        	accion=40;
        break;
        case 'parametro':
        	accion=41;
        break;
        case 'etExport':
			accion=42;
        break;
        case 'tagXML':
        	accion=43;
        break;
        case 'funcionRenderer':
        	accion=44;
        break;
        case 'etiquetaAgregar':
        	accion=45;
        break;
        case 'etiquetaRemover':
        	accion=46;
        break;
        case 'formato':
        	accion=47;
        break;
        case 'origenFecha':
        	accion=48;
        break;
        case 'archivoConf':
        	accion=49;
        break;
        case 'valorDefault':
        	accion=50;
        break;
        case 'categoriaCampo':
        	accion=51;
        break;
        case 'correcionOrtografica':
        	accion=52;
        break;
        case 'estiloLista':
        	accion=53;
        break;
        case 'tituloCampo':
        	accion=54;
        break;
        default:
            if(campo.indexOf('etiqueta')>-1)
            {
            	accion=2;
                var arrEt=campo.split('_');
                idIdioma=arrEt[1];
            }
        break;
    }
    
    
    
    function funcResp()
    {
    	var divElementoSeleccionado=h.gE(idDivSel);
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
            switch(campo)
            {
            	case 'wordMax':
                	var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=h.gE('_'+arrNomAnt[1]);
                    ctrl.setAttribute('maxWord',valor);
                break;
                case 'nombre':
                	var nControl=generarNomControl(valor,tipoControl);
                   
                    var div=h.gE(idDivSel);
                    var nomAnterior=div.getAttribute('controlInterno');
                    var arrNomAnt=nomAnterior.split('_');
                    div.setAttribute('controlInterno',nControl+'_'+tipoControl);
                    var control=gE('_'+arrNomAnt[1]);
                    var nombreControl='_'+arrNomAnt[1];
                    if(tipoControl=='8') //fecha
                    {
                    	var val=control.getAttribute('val');
                        var dteFecha=h.Ext.getCmp('f_sp_'+arrNomAnt[1]);	
                        var maxFecha=dteFecha.maxValue;
                        var minFecha=dteFecha.minValue;
                    	var tdContenedor=h.gE('td_'+idControlSel);
                        var spanFecha=h-gE('sp_'+arrNomAnt[1]);
                        var padre=spanFecha.parentNode;
                        padre.removeChild(spanFecha);
                        var nuevoContenedor=document.createElement('span')
                        nuevoContenedor.id='sp'+nControl;
                        padre.appendChild(nuevoContenedor);
                        control.id=nControl;
                        control.name=nControl;
                        h.crearCampoFecha('sp'+nControl,nControl,minFecha,maxFecha);
                    }
                    else
                        if(tipoControl=='12') //archivo
                        {
                            var tipoArch=h.gE('tipoArch_'+arrNomAnt[1]);
                            tipoArch.id='tipoArch'+nControl;
                            var tamArch=h.gE('tamArch_'+arrNomAnt[1]);
                            tamArch.id='tamArch'+nControl;
                            control.id=nControl;
                        }
 						else
                            if((tipoControl=='14')||(tipoControl=='15')||(tipoControl=='16'))
                            {
                            	var d=h.gE('default'+nombreControl);
                                d.id='default'+nControl;
                                var anchoCelda= h.gE('anchoCelda'+nombreControl);
                                anchoCelda.id='anchoCelda'+nControl;
                                var numCol=h.gE('numCol'+nombreControl);
                                numCol.id='numCol'+nControl;
                                var listaNum=h.gE('lista'+nombreControl);
                                listaNum.id='lista'+nControl;
                                control.id=nControl;
                                var arrElementosSel=listaNum.value;
                                var arrOpc=eval(arrElementosSel);
                                var span=document.createElement('span');
                                var spanDel=h.gE('span'+nombreControl);
                                var padre=spanDel.parentNode;
                                padre.removeChild(spanDel);
                                var anchoCol=anchoCelda.value;
                                var tablaCtrl=h.crearTabla(numCol.value,arrElementosSel,parseInt(tipoControl),nControl,anchoCol);
                                span.id='span'+nControl;
                                span.appendChild(tablaCtrl);
                                padre.appendChild(span);
                            }
                            else
                            {
                            	if((tipoControl=='17')||(tipoControl=='18')||(tipoControl=='19'))
                                {
                                	
                                    var anchoCelda= h.gE('anchoCelda'+nombreControl);
                                    anchoCelda.id='anchoCelda'+nControl;
                                    var numCol=h.gE('numCol'+nombreControl);
                                    numCol.id='numCol'+nControl;
                                    var listaNum=h.gE('lista'+nombreControl);
                                    listaNum.id='lista'+nControl;
                                    control.id=nControl;
                                    var arrElementosSel=listaNum.value;
                                    var arrOpc=eval(arrElementosSel);
                                    var span=document.createElement('span');
                                    var spanDel=h.gE('span'+nombreControl);
                                    var padre=spanDel.parentNode;
                                    padre.removeChild(spanDel);
                                    var anchoCol=anchoCelda.value;
                                    var tablaCtrl=h.crearTabla(numCol.value,arrElementosSel,parseInt(tipoControl),nControl,anchoCol);
                                    span.id='span'+nControl;
                                    span.appendChild(tablaCtrl);
                                    padre.appendChild(span);
                                	var minSel=h.gE('minSel'+nombreControl);
                                    minSel.id='minSel'+nControl;
                                    
                                }
                            	else
                                	if(tipoControl=='20')
                                    {
                                    	var hTipo=h.gE('tipo'+nombreControl);
                                		hTipo.id='tipo'+nControl;
                                        var hActualizable=h.gE('actualizable'+nombreControl);
                                		hActualizable.id='actualizable'+nControl;
                                        control.id=nControl;
                                        control.name=nControl;
                                        control.value=valor;
                                    }
                                    else
                                    {
                                    	if(tipoControl=='30')
                                        {
                                        	var control=h.gE('_'+arrNomAnt[1]);
                                        	control.id='_'+valor+'vch';
                                            div.setAttribute('controlInterno','_'+valor+'vch_30');
                                        }
                                        else
                                        	if(tipoControl=='10')
                                            {
                                            	if(div.getAttribute('version2')!=undefined);
                                                {
                                                	
                                                	div.setAttribute('controlInterno','_'+valor+'vch_10');
                                                    var arrDatosDiv=div.id.split('_');
                                                    var texto=h.CKEDITOR.instances['txt'+nameControl];
                                                    var ancho=texto.config.width;
                                                    var alto=texto.config.height;
                                                    var conf=texto.config.customConfig;
                                                    var contenedor=h.gE('txtEnriquecido_'+arrDatosDiv[1]);
                                                    while(contenedor.childNodes.length>0)
                                                    {
                                                    	contenedor.removeChild(contenedor.childNodes[0]);
                                                    }
                                                    h.crearRichTextV2('_'+valor+'vch','txtEnriquecido_'+arrDatosDiv[1],ancho,alto,conf,'');

                                                    
                                                }
                                            }
                                            else
                            					control.id=nControl;
                                    }
                            }
                break;
                case 'obligatorio':
                	var td=h.gE('td_obl_'+idControl);
                    
                    
                    if(tipoControl=='10')
                    {
                    	var div=h.gE(idDivSel);
                        var arrDatosDiv=div.id.split('_');
                    	var ctrl= h.gE('txtEnriquecido_'+arrDatosDiv[1]);
                        
                        if(valor=='0')
                        {
                            td.innerHTML='';
                            ctrl.setAttribute('val','');
                        
                        }
                        else
                        {
                            td.innerHTML='<font color="red">*</font>';
                            ctrl.setAttribute('val','obl');
                        }
                    }
                    else
                    {
                        var ctrl= h.gE(nameControl);
                        
                        if(valor=='0')
                        {
                            td.innerHTML='';
                           ctrl.setAttribute('val','');
                        
                        }
                        else
                        {
                            td.innerHTML='<font color="red">*</font>';
                            ctrl.setAttribute('val','obl');
                        }
                    }
                break;
                case 'ancho':
                    var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=h.gE('_'+arrNomAnt[1]);                    
                    
                    
                    
                    
                    switch(tipoControl)
                    {
                    	case '8':
                        case '21':
                        

                        	var controlExt=h.gEx('f_sp_'+arrNomAnt[1]);
                            controlExt.setWidth(parseInt(valor));
                            
                            objConfElemento.campoConf10=valor;
                            cadenaObj=convertirCadenaJson(objConfElemento);
                            divElementoSeleccionado.setAttribute('objConfElemento',bE('['+cadenaObj+']'));

                        break;
                    	case '1':
                        	h.gE('_lbl'+idElementoSel).style.width=valor+'px';
                        break;
                        case '4':
                        	ctrl.setAttribute('ancho',valor);
                            if(h.gEx('ext_'+ctrl.id))
                                h.gEx('ext_'+ctrl.id).setWidth(parseInt(valor));
                            else
                                ctrl.style.width=valor+'px';
                        break;
                        case '5':
                        case '11':
                        case '6':
                        case '7':
                        case '24':
                        
                        	ctrl.setAttribute('size',valor);
                        break;
                        case '25':
                            var tamAnterior=ctrl.getAttribute('size');
                            var confCampo=bD(ctrl.getAttribute('confCampo'));
                            confCampo=confCampo.replace('"ancho":"'+tamAnterior+'"','"ancho":"'+valor+'"');
                            ctrl.setAttribute('size',valor);
                            ctrl.setAttribute('confCampo',bE(confCampo));
                        break;
                        case '10':
                        	var texto;
                            
                            if(div.getAttribute('version2')==undefined)
                            {
                                texto=h.gEx('_'+arrNomAnt[1]);
	                        	texto.setWidth(valor);
                            }
                            else
                            {
                                
                                texto=h.CKEDITOR.instances['txt'+nameControl];
                                texto.resize(parseFloat(valor),texto.config.height)
                                texto.config.width=parseFloat(valor);
                                
                            }
                            
                            
                            
                        break;
                        case '13':
                        case '9':
                        	ctrl.style.width=valor+'px';
                        break;
                        case '23':
                        case '33':
                        	ctrl.width=valor;
                        break;
                        case '29':
                        	var gridCtrl=h.gEx('grid_'+idControl);
	                        gridCtrl.setWidth(parseInt(valor));
                        break;
                    }
                break;
                case 'longMax':
					var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=h.gE('_'+arrNomAnt[1]);
                    ctrl.setAttribute('maxlength',valor);
                   
                break;
                case 'alto':
                	var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=h.gE('_'+arrNomAnt[1]);
                	if(tipoControl=='1')
                    {
                    	h.gE('_lbl'+idElementoSel).style.height=valor+'px';
                    }
                     
                    if(tipoControl=='10')
                    {
                    	
                        
                        var texto;
                            
                        if(div.getAttribute('version2')==undefined)
                        {
                            var texto=h.gEx('_'+arrNomAnt[1]);                            
                        }
                        else
                        {
                            
                            texto=h.CKEDITOR.instances['txt'+nameControl];
                            texto.resize(texto.config.width,parseFloat(valor))
                            texto.config.height=parseFloat(valor);
                            
                        }
                        
                       
                    }
                    if((tipoControl=='13')||(tipoControl==9))
                    {
                    	ctrl.style.height=valor+'px';
                    }
                    if((tipoControl=='23')||(tipoControl=='33'))
                    {
                    	ctrl.height=valor;
                    }
                    if(tipoControl=='29')
                    {
                    	var gridCtrl=h.gEx('grid_'+idControl);
                        gridCtrl.setHeight(parseInt(valor));
                    }
                break;
                case 'fechaMin':
                    var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var dteFecha=h.gEx('f_sp_'+arrNomAnt[1]);	
                    if(!Ext.isDate(valor))
                    {
            			if(valor=='')
                    		valor=null;
                        else
                        	valor=new Date.parseDate(valor,'d/m/Y');
                    }
                        
                    dteFecha.setMinValue(valor);
                break;
                case 'fechaMax':
                	var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var dteFecha=h.gEx('f_sp_'+arrNomAnt[1]);	
                    if(!Ext.isDate(valor))
                    {
            			if(valor=='')
                    		valor=null;
                        else
                        	valor=new Date.parseDate(valor,'d/m/Y');
                    }
                    dteFecha.setMaxValue(valor);
                break;
                case 'tamano':
                	var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var tamArch=h.gE('tamArch_'+arrNomAnt[1]);
                    tamArch.value=valor;    
                break;
                case 'tipoArch': 
                    var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var tipoArch=h.gE('tipoArch_'+arrNomAnt[1]);
                    tipoArch.value=valor;
                    
                break;
                case 'X':
                    var div=h.gE(idDivSel);
                    div.style.left=(parseInt(valor)+parseInt(h.posDivX))+'px';
                break;
                case 'Y':
                	var div=h.gE(idDivSel);
                    
                    div.style.top=(parseInt(valor)+parseInt(h.posDivY))+'px';
                break;
                case 'numCol':
                	h.gE('numCol'+nameControl).value=valor;
                	generarTablaOpcionesCombo(idControl);
                break;
                case 'anchoCelda':
                	h.gE('anchoCelda'+nameControl).value=valor;
                    
                    //h.gE('ancho'+nameControl).value=valor;
                 	generarTablaOpcionesCombo(idControl);
                break;
                case 'selDefault':
                	var div=h.gE(idDivSel);
                 	var nControl=div.getAttribute('controlInterno');
                     switch(tipoControl)
                    {
                    	case '2':
                        case '3':
                        case '4':
                        	var arrNomAnt=nControl.split('_');
                            var nombreCtrl='_'+arrNomAnt[1];
                            var combo=h.gE(nombreCtrl);
                            combo.setAttribute('valDefault',valor);
                        	selElemCombo(combo,valor);
                        break;
                    	default:
                            var arrNomAnt=nControl.split('_');
                            var nomControl='_'+arrNomAnt[1];
                            var defVal=h.gE('default'+nomControl).value;
                            if(valor!='100584')
                                h.gE('opt'+nomControl+'_'+valor).checked=true;
                            else
                            {
                                h.gE('opt'+nomControl+'_'+defVal).checked=false;
                            }
                            h.gE('default'+nomControl).value=valor;
                   		break;
                   }
                break;
                case 'minObl':
                    var div=h.gE(idDivSel);
                 	var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	var nomControl='_'+arrNomAnt[1];
                    h.gE('minSel'+nomControl).value=valor;
                    
                break;
                case 'varSesion':
                    var div=h.gE(idDivSel);
                 	var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	var nomControl='_'+arrNomAnt[1];
                    h.gE('tipo'+nomControl).value=valor;
                    
                break;
                case 'actualizable':
                    var div=h.gE(idDivSel);
                 	var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	var nomControl='_'+arrNomAnt[1];
                    h.gE('actualizable'+nomControl).value=valor;
                break;
                case 'horaMin':
                    var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var dteHora=h.gEx('f_sp_'+arrNomAnt[1]);	
                break;
                case 'horaMax':
                    var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var dteHora=h.gEx('f_sp_'+arrNomAnt[1]);	
                break;
                case 'intervalo':
                    var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var dteHora=h.gEx('f_sp_'+arrNomAnt[1]);	
                break;
                case 'numDecimales':
                	var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	h.gE('numD__'+arrNomAnt[1]).value=valor;
                    h.evaluarExpresion('_'+arrNomAnt[1]);
                break;
                case 'separaMiles':
                    var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	h.gE('sepMiles__'+arrNomAnt[1]).value=valor;
                    h.evaluarExpresion('_'+arrNomAnt[1]);
                break;
                case 'separaDec':
                    var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	h.gE('sepDec__'+arrNomAnt[1]).value=valor;
                    h.evaluarExpresion('_'+arrNomAnt[1]);
                break;
                case 'tratoDec':
                    var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	h.gE('tratoDec__'+arrNomAnt[1]).value=valor;
                    h.evaluarExpresion('_'+arrNomAnt[1]);
                break;
                case 'orden':
                	var div=h.gE(idDivSel);
                    var vValor=div.getAttribute('orden');
                	h.actualizarFocus(vValor,valor);
                    div.setAttribute('orden',valor);
               	break;
                case 'estilo':
                	var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=h.gE('_'+arrNomAnt[1]);
	                setClase(ctrl,valor);
                    
                    switch(tipoControl)
                    {

                    	case '14':
                        case '15':
                        case '16':
                        case '17':
                        case '18':
                        case '19':
                        	var arrElementos=h.gEN('td__'+arrNomAnt[1]);
                            var x;
                            for(x=0;x<arrElementos.length;x++)
                            {
                            	setClase(arrElementos[x],valor);
                            }
                        break;
                        case '22':
                        	var ctrlAux=h.gE('lbl__'+arrNomAnt[1]);
			                setClase(ctrlAux,valor);
                        break;
                    }
                    
                   
                	
                break;
                case 'habilitado':
                	var div=h.gE(idDivSel);
                    div.setAttribute('habilitado',valor);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=h.gE('_'+arrNomAnt[1]);
                   	switch(tipoControl)
                    {
                        case '5':
                        case '6':
                        case '7':
                        case '9':
                        case '11':
                        case '24':
                        	if(valor=='0')
	                        	ctrl.disabled=true;
                            else
                            	ctrl.disabled=false;
                        break;
                        case '2':
                        case '3':
                        case '14':
                        case '15':
                        case '16':
                        case '17':
                        case '18':
                        case '19':
							var lista_rdo=h.gE('lista_'+arrNomAnt[1]).value;                        	
                            var arrElementos=eval(lista_rdo);
                            var x;
                            var idElemento;
                            for(x=0;x<arrElementos.length;x++)
                            {
                            	idElemento='opt_'+arrNomAnt[1]+'_'+arrElementos[x][0];
                                if(valor=='0')
                                    h.gE(idElemento).disabled=true;
                                else
                                    h.gE(idElemento).disabled=false;
                            }
                        break;
                        case '4':
                        	var combo=h.gEx('ext__'+arrNomAnt[1]);
                            if(valor=='0')
                            {
                            	if(combo!=null)
	                           		combo.disable()
                                else
                                	ctrl.disabled=true;
                            }
                            else
                            {
                            	if(combo!=null)
	                           		combo.enable()
                                else
                                	ctrl.disabled=false;
                            }
                        break;
                        case '10':
                        	if(div.getAttribute('version2')==undefined)
                            {
                                var texto=h.gEx('_'+arrNomAnt[1]);
                                var editorInterno=texto.getInnerEditor();
                                if(valor=='0')
                                {
                                    texto.disable();
                                    editorInterno.EditorDocument.body.disabled=true;
                                }
                                else
                                {
                                    texto.enable();
                                    editorInterno.EditorDocument.body.disabled=false;
                                }
                            }
                            else
                            {
                            	
                                
                                if(valor=='0')
                                {
                                    h.deshabilitarTextoEnriquecido('txt_'+arrNomAnt[1]);
                                }
                                else
                                {
                                    h.habilitarTextoEnriquecido('txt_'+arrNomAnt[1]);
                                }
                                
                            }
                        break;
                        case '8':
                        case '21':
                        	if(valor=='0')
	                        	h.gEx('f_sp_'+arrNomAnt[1]).disable();
                            else
                            	h.gEx('f_sp_'+arrNomAnt[1]).enable();
                        break;
                        case '29':
                        	var gridCtrl=h.gEx('grid_'+idControl);
                            if(valor=='0')
		                        gridCtrl.disable();
                            else
                            	gridCtrl.enable();
                        break;
                    }
                break;
                case 'vincular':
                	var div=h.gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	h.gE('lita__'+arrNomAnt[1]).value=valor;
                break;
                case 'visible':
                	var div=h.gE(idDivSel);
                    div.setAttribute('visible',valor);
                break;
                
                case 'permitirAgregar':
                    if(valor=='0')
                		h.gEx('btnAdd_'+'grid_'+idControl).hide();
                    else
                    	h.gEx('btnAdd_'+'grid_'+idControl).show();
                    h.gE('contenedorSpanGrid_'+idControl).setAttribute('permiteAgregar',valor);
                break;
                case 'permiteModificar':
                	h.gE('contenedorSpanGrid_'+idControl).setAttribute('permiteModificar',valor);
                break;
                case 'permiteEliminar':
                	if(valor=='0')
                		h.gEx('btnDel_'+'grid_'+idControl).hide();
                    else
                    	h.gEx('btnDel_'+'grid_'+idControl).show();
					 h.gE('contenedorSpanGrid_'+idControl).setAttribute('permiteEliminar',valor);
                break;
                case 'enlace':
                		var _lbl;
                        var contenido;
                        var link;
                		switch(tipoControl)
                        {
                        	case '1':
                            	if(valor=='')
                                {
                                	link=h.gE('link_'+idControl);
                                    contenido=link.innerHTML;
                                    _lbl=h.gE('_lbl'+idControl);
                                    _lbl.innerHTML=contenido;
                                   
                                    
                                }
                                else
                                {
                                	_lbl=h.gE('_lbl'+idControl);
                                    contenido=_lbl.innerHTML;
                                    _lbl.innerHTML='<a id="link_'+idControl+'" href="javascript:doNothing()">'+contenido+'</a>';
                                }
                                 
                            break;
                            case '23':
                            	if(valor=='')
                                {
                                	link=h.gE('link_'+idControl);
                                    contenido=link.innerHTML;
                                    _lbl=h.gE('_img'+idControl);
                                    _lbl.innerHTML=contenido;
                                    
                                }
                                else
                                {
                                	_lbl=h.gE('_img'+idControl);
                                    contenido=_lbl.innerHTML;
                                    _lbl.innerHTML='<a id="link_'+idControl+'" href="javascript:doNothing()">'+contenido+'</a>';
                                }
                            break;
                        }
                		_lbl.setAttribute('enlace',valor);
                break;
               	case 'ordenIns':
                	h.gE('ordenOpt'+nameControl).value=valor;
                    switch(tipoControl)
                    {
                    	case '2':
                        	var control=h.gE(nameControl);
                        	var arrDatos=eval(arrResp[1]);
                            //alert(arrResp[1]);
                            llenarCombo(control,arrDatos,true);
                        break;
                        case '17':
                        case '14':
                        	var arrDatos=arrResp[1];
                            var listaElementos=h.gE('lista'+nameControl);
                            listaElementos.value=arrDatos;
                            generarTablaOpcionesCombo(idControl);
                        break;
                    }
                break;
                case 'parametro':
                	var ctrl=h.gE(nameControl);
                    ctrl.setAttribute('parametro',valor);
                    ctrl.innerHTML='<span>['+valor+']</span>';
                break;
                case 'etExport':
                	var div=h.gE(idDivSel);
                    div.setAttribute('etiquetaExportacion',valor);
                break;
                case 'tagXML':
                	var div=h.gE(idDivSel);
                    div.setAttribute('tagXML',valor);
                break;
               	case 'funcionRenderer':
                	var nControl=obtenerNombreControlInterno(divCtrlSel);
                    h.gE(nControl).setAttribute('funcRenderer',valor);
                    
                    objConfElemento.campoConf18=valor;
                    cadenaObj=convertirCadenaJson(objConfElemento);
                	divElementoSeleccionado.setAttribute('objConfElemento',bE('['+cadenaObj+']'));
                    
                break;
                    
                break;
                case 'etiquetaAgregar':
                	h.gE('contenedorSpanGrid_'+idControl).setAttribute('etAgregar',valor);
                    h.gEx('btnAdd_grid_'+idControl).setText(valor);
                break;
                case 'etiquetaRemover':
                	h.gE('contenedorSpanGrid_'+idControl).setAttribute('etRemover',valor);
                    h.gEx('btnDel_grid_'+idControl).setText(valor);
                break;
                case 'formato':
                	var valorAnt=ctrSeleccionado.value;
                    var confCampo=bD(ctrSeleccionado.getAttribute('confCampo'));
                    confCampo=confCampo.replace('"formato":"'+valorAnt+'"','"formato":"'+valor+'"');
                    ctrSeleccionado.value=valor;
                    ctrSeleccionado.setAttribute('confCampo',bE(confCampo));
                break;
                case 'origenFecha':
                	
                    var confCampo=bD(ctrSeleccionado.getAttribute('confCampo'));
                    var objCampo=eval('['+confCampo+']')[0];
                    var valorAnt=objCampo.origenFecha;
                    confCampo=confCampo.replace('"origenFecha":"'+valorAnt+'"','"origenFecha":"'+valor+'"');
                    ctrSeleccionado.setAttribute('confCampo',bE(confCampo));
                break;
                case 'archivoConf':
	                var div=h.gE(idDivSel);
                    var arrDatosDiv=div.id.split('_');
                    var texto=h.CKEDITOR.instances['txt'+nameControl];
                    var ancho=texto.config.width;
                    var alto=texto.config.height;
                    var conf=valor;
                    var contenedor=h.gE('txtEnriquecido_'+arrDatosDiv[1]);
                    while(contenedor.childNodes.length>0)
                    {
                        contenedor.removeChild(contenedor.childNodes[0]);
                    }
                    h.crearRichTextV2('_'+valor+'vch','txtEnriquecido_'+arrDatosDiv[1],ancho,alto,conf,'');

                                            
                break;
                case 'valorDefault':
                	objConfElemento.campoConf16=valor;
                    cadenaObj=convertirCadenaJson(objConfElemento);
                    divElementoSeleccionado.setAttribute('objConfElemento',bE('['+cadenaObj+']'));
                    
                break;
                case 'categoriaCampo':
                	objConfElemento.campoConf14=valor;
                    cadenaObj=convertirCadenaJson(objConfElemento);
                    divElementoSeleccionado.setAttribute('objConfElemento',bE('['+cadenaObj+']'));
                    
                break;
                case 'correcionOrtografica':
                    objConfElemento.campoConf15=valor;
                    cadenaObj=convertirCadenaJson(objConfElemento);
                	divElementoSeleccionado.setAttribute('objConfElemento',bE('['+cadenaObj+']'));
                    
                break;
                case 'estiloComplementario':
                    objConfElemento.campoConf12=valor;
                    cadenaObj=convertirCadenaJson(objConfElemento);
                	divElementoSeleccionado.setAttribute('objConfElemento',bE('['+cadenaObj+']'));
                    h.recargarPagina();
                break;
                
                case 'estiloLista':
                    objConfElemento.campoConf13=valor;
                    cadenaObj=convertirCadenaJson(objConfElemento);
                	divElementoSeleccionado.setAttribute('objConfElemento',bE('['+cadenaObj+']'));
                    h.recargarPagina();
                break;
                case 'tituloCampo':
                    objConfElemento.campoConf21=valor;
                    cadenaObj=convertirCadenaJson(objConfElemento);
                	divElementoSeleccionado.setAttribute('objConfElemento',bE('['+cadenaObj+']'));
                    
                break;
                default:
                    if(campo.indexOf('etiqueta')>-1)
                    {
                    	var idIdiomaPag=h.gE('hLeng').value;
                        if(idIdioma==idIdiomaPag)
                        {
                        	h.gE('_lbl'+idControl).innerHTML=valor;
                            h.gE('td_'+idControl+'_'+idIdioma).value=valor;
                        }
                        
                    }
                break;
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=18&accion='+accion+'&idControl='+idControl+'&valor='+cv(''+valor)+'&idIdioma='+idIdioma,true);
}

function generarNomControl(nombre,tipoControl)
{
	var nomControl='_'+nombre;
    var sufijo='';
	switch(parseInt(tipoControl))
    {
    	case 2: //pregunta cerrada-Opciones Manuales
			sufijo="vch";
		break;					
		case 3: //pregunta cerrada-Opciones intervalo
			sufijo="vch";
		break;
		case 4: //pregunta cerrada-Opciones tabla
			sufijo="vch";
		break;
		case 5: //Texto Corto
			sufijo="vch";
		break;
		case 6: //Número entero
			sufijo="int";
		break;
		case 7: //Número decimal
			sufijo="flo";
		
		break;
		case 8: //Fecha
			sufijo="dte";
		break;
		case 9://Texto Largo 
			sufijo="mem";
		
		break;
		case 10: //Texto Enriquecido
			sufijo="vch";
		break;
		case 11: //Correo Electrónico
			sufijo="vch";
		break;
		case 12: //Archivo
			sufijo="fil";
		break;
        case 14: //pregunta cerrada-Opciones Manuales
			sufijo="vch";
		break;					
		case 15: //pregunta cerrada-Opciones intervalo
			sufijo="vch";
		break;
		case 16: //pregunta cerrada-Opciones tabla
			sufijo="vch";
		break;
        case 17: //pregunta cerrada-Opciones Manuales
			sufijo="arr";
		break;					
		case 18: //pregunta cerrada-Opciones intervalo
			sufijo="arr";
		break;
		case 19: //pregunta cerrada-Opciones tabla
			sufijo="arr";
		break;
        case 20:
        	sufijo="vch";
        break;
        case 21:
        	sufijo="vch";
        break;
        case 22:
        	sufijo='flo';
        break;
        case 23:
        	sufijo='img';
        break;
        case 24:
        	sufijo='flo';
        break;
        case 26:
        	sufijo='vch';
        break;
        case 30:
        	sufijo='vch';
        break;
         case 31:
        	sufijo='vch';
        break;
        
    
    }
    return nomControl+sufijo;
}

function formatearTratoDec(valor)
{
	var x=0;
    var cmbTratoDec=Ext.getCmp('cmbTratoDec');
    var dSet=cmbTratoDec.getStore();
    var nElem=dSet.getCount();    
    var fila;
    for(x=0;x<nElem;x++)
    {
    
    	fila=dSet.getAt(x);
        
    	if(fila.get('id')==valor)
        	return fila.get('nombre');
    }
	return valor;
}

function formatearFecha(valor,meta,registro)
{
	if(valor!='')
    {
    	valor=valor.format('d/m/Y')+'&nbsp;&nbsp;<a href="javascript:modificarFecha(\''+bE(registro.id)+'\')"><img src="../images/pencil.png" width="13" height="13"></a>';
        return valor;
    }
    return valor+'<a href="javascript:modificarFecha(\''+bE(registro.id)+'\')"><img src="../images/pencil.png" width="13" height="13"></a>';
}

function formatearHora(valor)
{
	try
    {
        if(valor!='')
        {
            valor=valor.format('H:i');
        }
        return valor;
    }
    catch(e)
    {    
    	return valor;
    }
}

function formatearSel(valor)
{
	var x=0;
    var nElem=dsComboSeleccion.getCount(); 
   	
    var fila;
    for(x=0;x<nElem;x++)
    {
    
    	fila=dsComboSeleccion.getAt(x);
    	if(fila.get('id')==valor)
        {
        	return fila.get('nombre');
        }
    }
	return valor;
	
}

function formatearTipoArch(valor)
{
	var x=0;
        
    for(x=0;x<tDocumento.length;x++)
    {
    	if(tDocumento[x][0]==valor)
        	return tDocumento[x][1];
    }
	return valor;
	
}

function formatearVSesion(valor)
{
	var x=0;
        
    for(x=0;x<tVSesion.length;x++)
    {
    	if(tVSesion[x][0]==valor)
        	return tVSesion[x][1];
    }
	return valor;
}

function formatearBtnEnlace(valor)
{
	return valor;
	var div=gE(idDivSel);
    var nControl=div.getAttribute('controlInterno');
	var arrNomAnt=nControl.split('_');
    var control='_'+arrNomAnt[1];
    
	return '<input type="button" value="..." class="btnPuntos" onclick=mostrarVentanaEnlace(\''+control+'\')>';
}



function formatearPermitirAgregar(value, metaData, record, rowIndex, colIndex, store)
{
	var x=0;
    for(x=0;x<arrSiNo.length;x++)
    {
    	if(arrSiNo[x][0]==value)
        {
        	if(value=='0')
	        	return arrSiNo[x][1];
            else
            	return arrSiNo[x][1]+' <a href="javascript:mostrarVentanaPermitirAgregar()"><img src="../images/pencil.png" height="14" width="14"></a>';
        }
    }
	return value;
	
}

function formatearSiNo(value)
{
	var x=0;
    for(x=0;x<arrSiNo.length;x++)
    {
    	if(arrSiNo[x][0]==value)
        	return arrSiNo[x][1];
    }
	return value;
}

function formatearEnlace(value)
{
	return formatearValorRenderer(arrEnlaces,value);
}

function agregarFormulacionAgregacion(iE)
{
	var arrControl=divCtrlSel.getAttribute('controlInterno').split('_');
    var nCtrl='_'+arrControl[1];
	var arrTipoFormulario=[['1','P\xE1gina'],['2','Formulario din\xE1mico']];
	var cmbTipoFormulario=crearComboExt('',arrTipoFormulario,175,5,200);
    cmbTipoFormulario.on('select',function(cmb,registro)
    								{
                                    	if(registro.get('id')=='1')
                                        {
                                        	gEx('vAgrega').setSize(550,140);
                                        }
                                        else
                                        {
                                       		gEx('vAgrega').setSize(550,110);
                                        }
                                    }
    					)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de formulario:'
                                                        },
                                                        cmbTipoFormulario,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Indique la URL de la p&aacute;gina:'
                                                        },
                                                        {
                                                        	x:175,
                                                            y:35,
                                                            width:300,
                                                            id:'txtUrl',
                                                            xtype:'textfield'
                                                            
                                                        }
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vAgrega',
										title: 'P&aacute;gina de agregaci&oacute;n',
										width: 550,
										height:110,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
                                        resizable : false,
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
                                                                    	var txtUrl=gEx('txtUrl');
																		if(cmbTipoFormulario.getValue()=='1')
                                                                        {
                                                                        	if(txtUrl.getValue()=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	txtUrl.focus();
                                                                                }
                                                                                msgBox('Debe indicar la URL de la p&aacute;gina que ser&aacute; utilizada para agregar nuevos elementos',resp);
                                                                                return;
                                                                            }
                                                                            
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                    h.gE(nCtrl).setAttribute('tipoPagina',cmbTipoFormulario.getValue());
                                                                                    h.gE(nCtrl).setAttribute('valorPagina',txtUrl.getValue());
                                                                                    establecerFuente('div_'+bD(iE));
                                                                                    ventanaAM.close();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=241&idElemento='+bD(iE)+'&tipoPagina='+cmbTipoFormulario.getValue()+'&valorPagina='+txtUrl.getValue(),true);

                                                                        }
                                                                        else
                                                                        {
                                                                        	mostrarVentanaFormulariosDinamicos(iE,nCtrl);	
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

function mostrarVentanaFormulariosDinamicos(iE,nCtrl)
{
	
	
    var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'idFormulario'},
                                                                    {name:'nombre'}, 
                                                                    {name:'titulo'},
                                                                    {name: 'descripcion'},
                                                                    {name:'idProceso'},
                                                                    {name:'formularioBase'}
                                                                      
                                                                ]
                                                    }
                                                );
    
    
    var dsOpciones= [];
    
    alOpciones.loadData(dsOpciones);
    
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Nombre del formulario',
                                                            width:250,
                                                            dataIndex:'nombre'
                                                        },
                                                        {
                                                        	header:'T&iacute;tulo',
                                                            width:150,
                                                            hidden:true,
                                                            dataIndex:'titulo'
                                                        },
                                                        {
                                                        	header:'Descripci&oacute;n',
                                                            width:400,
                                                            dataIndex:'descripcion'
                                                        }
                                                        
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridFormularios',
                                                            store:alOpciones,
                                                            frame:true,
                                                            cm: cmFrmDTD,
                                                            height:200,
                                                            width:750,
                                                            title:'Selecci&oacute;n de formulario:'
                                                            
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:50,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
    
    var cmbProcesos=crearComboExt('cmbProcesos',arrProcesos,390,5);
    cmbProcesos.on('select',cargarFormularios);
    
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
                                                            html:'Elija el proceso al cual pertenece el formulario que desea enlazar:'
                                                        },
                                                        cmbProcesos,
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
                                                                        	msgBox('Debe seleccionar el formulario que ser&aacute; utilizado para agregar nuevos elementos');
                                                                        	return;
                                                                        }
                                                                        var idFormulario=filaSel.get('idFormulario');
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                h.gE(nCtrl).setAttribute('tipoPagina',2);
                                                                                h.gE(nCtrl).setAttribute('valorPagina',filaSel.get('nombre'));
                                                                                establecerFuente('div_'+bD(iE));
                                                                                var ventana=gEx('vSelFormulario');
                                                                                ventana.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=241&idElemento='+bD(iE)+'&tipoPagina=2&valorPagina='+idFormulario,true);

                                                                        
                                                                        
                                                                        
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelForm = new Ext.Window(
                                            {
                                            	id:'vSelFormulario',
                                                title: 'Selecci&oacute;n de formulario',
                                                width: 780 ,
                                                height:450,
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
                                                                    	
                                                                        ventanaSelForm.close();
                                                                        
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	
    ventanaSelForm.show();
}

function cargarFormularios(combo,registro,indice)
{

	function funcResp()
    {
    	var arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
		{
            	var arrTablas=eval(arrResp[1]);
                var almacen=Ext.getCmp('gridFormularios').getStore();
                almacen.loadData(arrTablas);
               	ventana.show();
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=14&idProceso='+registro.get('id'),true);
}

function modificarOrigenDatos()
{
	listUsuarioEtBD=new Array();
	listAppEtBD=new Array();
    var arrCampos=[];
	var arrTipoConexion=[['11','Almac\xE9n de datos'],['7','Consulta auxiliar']];
	var cmbTipoConexion=crearComboExt('cmbTipoConexion',arrTipoConexion,110,5);
    cmbTipoConexion.on('select',function(cmb,registro)
    							{
                                	
                                	var arrAlmacenes;
                                	if(registro.get('id')=='7')
                                    {
                                    	arrAlmacenes=obtenerAlmacenesDatosDisponibles(2);
                                    }
                                    else
                                    {
                                    	arrAlmacenes=obtenerAlmacenesDatosDisponibles(1);
                                    }
                                    gEx('cmbAlmacen').getStore().loadData(arrAlmacenes);
                                }
    )
    
    var cmbAlmacen=crearComboExt('cmbAlmacen',[],110,35,260);
    cmbAlmacen.on('select',function(cmb,registro)
    						{
                            	var id=registro.get('id');
                                arrCampos=obtenerCamposDisponibles(id,true);
                                
                            }
    			)
    
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
                                                            html:'Conectar con:'
                                                        },
                                                        cmbTipoConexion,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                        	xtype:'label',
                                                            html:'Origen de datos:'
                                                        },
                                                        cmbAlmacen,
                                                        {
                                                            xtype:'label',
                                                            x:10,
                                                            y:80,
                                                            html:'Configure el texto a mostrar como etiqueta:'
                                                        }
                                                        ,
                                                        {
                                                            xtype:'panel',
                                                            x:20,
                                                            y:100,
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
                                                                                        mostrarVentanaSelCampoComboEt(arrCampos);
                                                                                    }
                                                                        }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:45,
                                                            y:100,
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
                                                                                        mostrarVentanaFraseEt();
                                                                                    }
                                                                        }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:70,
                                                            y:100,
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
                                                                                        listUsuarioEtBD.push('\' \'');
                                                                                        listAppEtBD.push('\' \'');
                                                                                        actualizarVistaOpcionEt();
                                                                                    }
                                                                        }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:95,
                                                            y:100,
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
                                                                                        listUsuarioEtBD.pop();
                                                                                        listAppEtBD.pop();
                                                                                        actualizarVistaOpcionEt();
                                                                                    }
                                                                                    
                                                                        }
                                                                    ]
                                                        },
                                                        
                                                        {
                                                        
                                                            id:'txtVistaElemento',
                                                            xtype:'textarea',
                                                            x:20,
                                                            y:135,
                                                            width:500,
                                                            height:50,
                                                            readOnly:true
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear etiqueta con conexi&oacute;n a almac&eacute;n',
										width: 580,
										height:280,
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
                                                                    	var nomColumn='';
                                                                        for(x=0;x<listAppEtBD.length;x++)
                                                                        {
                                                                        	if(nomColumn=='')
                                                                        		nomColumn=listAppEtBD[x];
                                                                            else
                                                                            	nomColumn+='@@'+listAppEtBD[x];
                                                                        }
                                                                        
                                                                    	if(cmbTipoConexion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoConexion.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de conexi&oacute;n a utilizar',resp);
                                                                            return;
                                                                        }
                                                                        if(cmbAlmacen.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbAlmacen.focus();
                                                                            }
                                                                            msgBox('Debe indicar el almac&eacute;n/consulta auxiliar a utilizar',resp2);
                                                                            return;
                                                                        }
                                                                        if(gEx('txtVistaElemento').getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbCampo.focus();
                                                                            }
                                                                            msgBox('Al menos debe seleccionar un campo para proyectar como texto de la etiqueta',resp3);
                                                                            return;
                                                                        }

                                                                        var campo=nomColumn;
                                                                        var objFinal='{"campoEtUsuario":"'+cv(gEx('txtVistaElemento').getValue())+'","almacen":"'+cmbAlmacen.getValue()+'","campo":"'+cv(campo)+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var nControl=obtenerNombreControlInterno(divCtrlSel);
                                                                             	h.gE(nControl).setAttribute('objAlmacenDatos',bE(dv(objFinal)));
                                                                                establecerFuente(divCtrlSel.id);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=205&idControl='+idElementoSel+'&cadObj='+objFinal,true);
                                                                        
                                                                        
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

function obtenerNombreControlInterno(divContenedor)
{
	var nomControl=divContenedor.getAttribute('controlInterno');
    arrNomControl=nomControl.split('_');
    tipoControl=arrNomControl[2];
   	var ctrlNombre='_'+arrNomControl[1]; 
    return ctrlNombre;
}

function removerOrigenDatos()
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
                    var nControl=obtenerNombreControlInterno(divCtrlSel);
                    
                    h.gE(nControl).setAttribute('objAlmacenDatos','');
                    establecerFuente(divCtrlSel.id);
                   
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=206&idControl='+idElementoSel,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover el origen de datos del control seleccionado?',resp);
}
