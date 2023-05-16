<?php
session_start();
include("configurarIdiomaJS.php");

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
	$arrLblRender=",etiqueta_".$fila5[0].":'<img src=\"../images/banderas/".$fila5[2]."\">&nbsp;&nbsp;".$etj["prpEtiqueta"]."'";
	$ct++;
	
}
echo "var arrIdiomas=[".uE($arrIdiomas)."];var nIdiomas=".$ct.";";

$consulta="select idProceso,nombre from 4001_procesos order by nombre";
$arrProcesos=uEJ($con->obtenerFilasArreglo($consulta));

$query="select nombreEstilo,nombreEstilo from 932_estilos";
$arrEstilos=uEJ($con->obtenerFilasArreglo($query));

$consulta="SELECT valor,texto FROM 1004_siNo";
$arrSiNo=$con->obtenerFilasArreglo($consulta);

?>

Ext.onReady(carga);
var elMovimiento;
var anchoDiv;
var altoDiv;
var valCompensacionX;
var valCompensacionY;
var maxX;
var minX; 
var maxY;
var minY;
var anchoPantalla;
var altoPantalla;
var mitadX;
var mitadY;
var posicionInicioX;
var posicionInicioY;
var ultimaPosX;
var ultimaPosY;
var lblPosX;
var lblPosY;
var controlSel=null;
var gridPropiedades;
var filaX;
var filaY;
var idControlSel;
var tipoControl;
var idDivAnt=null;
var idDivSel;


var posDivX;
var posDivY;
var arrSiNoAux=<?php echo $arrSiNo?>;
var arrAlineacion=[['0','Ninguno'],['1','Izquierda'],['2','Derecha'],['3','Justificada']];
var tdContenedor;

Ext.override	(Ext.grid.PropertyColumnModel, 
                                            {
                                                renderCell : function(val, meta, r)
                                                {
                                                    var renderer = this.grid.customRenderers[r.get('name')];
                                                    if(renderer)
                                                    {
                                                        return renderer.apply(this, arguments);
                                                    }
                                                    var rv = val;
                                                    if(Ext.isDate(val))
                                                    {
                                                        rv = this.renderDate(val);
                                                    }
                                                    else 
                                                        if(typeof val == 'boolean')
                                                        {
                                                            rv = this.renderBool(val);
                                                        }
                                                    return Ext.util.Format.htmlEncode(rv);
                                                }
                                            }
				);
                
Ext.override	(Ext.grid.PropertyGrid, 
                                        {
                                            initComponent : function()
                                            {
                                                this.customRenderers = this.customRenderers || {};
                                                this.customEditors = this.customEditors || {};
                                                this.lastEditRow = null;
                                                var store = new Ext.grid.PropertyStore(this);
                                                this.propStore = store;
                                                var cm = new Ext.grid.PropertyColumnModel(this, store);
                                                store.store.sort('name', 'ASC');
                                                this.addEvents
                                                (
                                                    'beforepropertychange',
                                                    'propertychange'
                                                );
                                                this.cm = cm;
                                                this.ds = store.store;
                                                Ext.grid.PropertyGrid.superclass.initComponent.call(this);
                                                this.mon(this.selModel, 'beforecellselect', function(sm, rowIndex, colIndex)
                                                                                            {
                                                                                                if(colIndex === 0)
                                                                                                {
                                                                                                    this.startEditing.defer(200, this, [rowIndex, 1]);
                                                                                                    return false;
                                                                                                }
                                                                                            }, 
                                                         this);
                                            },
                                            setProperty: function(property, value)
                                            {
                                                this.propStore.source[property] = value;
                                                var r = this.propStore.store.getById(property);
                                                if(r)
                                                {
                                                    r.set('value', value);
                                                }
                                                else
                                                {
                                                    r = new Ext.grid.PropertyRecord({name: property, value: value}, property);
                                                    this.propStore.store.add(r);
                                                }
                                            },
                                            removeProperty: function(property)
                                            {
                                                delete this.propStore.source[property];
                                                var r = this.propStore.store.getById(property);
                                                if(r)
                                                {
                                                    this.propStore.store.remove(r);
                                                }
                                            }
                                        }
					);


function carga()
{
	tdContenedor=gE('tdContenedor');
	anchoPantalla=screen.width;
    altoPantalla=screen.height;
    lblPosX=gE('lblPosX');
    lblPosY=gE('lblPosY');
    var valorAncho=gE('hAncho').value;
    var valorAlto=gE('hAlto').value;
    posicion=0;
   	minX=0;
    minY=0;
    maxX=parseInt(valorAncho)+10;
    maxY=valorAlto;
   
	if(navigator.userAgent.indexOf("Opera")>=0)
    {
    	navegador=0;
    }
    else
        if(navigator.userAgent.indexOf("MSIE")>=0)
        {
            navegador=0;

        }
        else 
        {
            navegador=1;
        }
    mitadX=(minX+maxX)/2;
    mitadX=mitadX.toFixed();
    mitadY=(minY+maxY)/2;
    mitadY=mitadY.toFixed();

    posDivX=obtenerPosX('frameTitulo');
	posDivY=obtenerPosY('frameTitulo');
    
    var comboSiNoObl=crearComboSiNo('cmbSiNoProp');
    
    var arrNElementos=new Array();
    var x;
    var nElemen=gE('hNElementos').value;
    var arrAux;
    for(x=1;x<=nElemen;x++)
    {
    	arrAux=new Array();
    	arrAux.push(x);
        arrAux.push(x);
    	arrNElementos.push(arrAux);
    }
    comboNumTab=crearComboExt('cmbNumTab',arrNElementos);
    
    comboSiNoObl.setPosition(0,0);
    var comboSiNoVin=crearComboSiNo('cmbSiNoVin');
    comboSiNoVin.setPosition(0,0);
    var comboTipoDoc=crearComboTipoDocumento('cmbTipoDocGrid');
    comboTipoDoc.setPosition(0,0);
    ctrlDefault=crearCombo('cmbDefault');
    var ctrlVSesion=crearComboValoresSession('cmbVersionCtrl');
    ctrlVSesion.setPosition(0,0);
    var cmbListadoEnlaces=crearComboExt('cmbListadoEnlaces',arrEnlaces,0,0,200);
    var cmbManenerFormatoHTML=crearComboExt('cmbManenerFormatoHTML',arrSiNoAux);
    var cmbAlineacion=crearComboExt('cmbAlineacion',arrAlineacion);
    var arrTratoDec=[['1','<?php echo $etj["lblRedondear"]?>'],['2','<?php echo $etj["lblTruncar"]?>']];
    var ctlTratoDec=crearComboExt('cmbTratoDec',arrTratoDec,0,0);
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
    var propsGrid = 	new Ext.grid.PropertyGrid	(
                                                        {
                                                            id:'GridPropiedades',
                                                            renderTo: 'tblPropiedades',
                                                            width: 220,
                                                            autoHeight: true,
                                                            title:'<?php echo $etj["lblPropControl"]?>',
                                                            customEditors: {
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
                                                                                'vincular':new Ext.grid.GridEditor(comboSiNoVin),
                                                                                'tratoDec':new Ext.grid.GridEditor(ctlTratoDec),
                                                                                'orden':new Ext.grid.GridEditor(comboNumTab),
                                                                                'estilo':new Ext.grid.GridEditor(cmbEstilos),
                                                                                'enlace':new Ext.grid.GridEditor(cmbListadoEnlaces),
                                                                                'formatoHTML':new Ext.grid.GridEditor(cmbManenerFormatoHTML),
                                                                                'alineacion':new Ext.grid.GridEditor(cmbAlineacion)
                                                                                
                                                                            },
                                                            customRenderers:
                                                                            {
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
                                                                                formula:formatearBtnFormula,
                                                                                enlace:formatearEnlace,
                                                                                formatoHTML:formatearValorSiNO,
                                                                                alineacion:formatearAlineacion
                                                                            },
                                                            propertyNames: 
                                                                            {
                                                                                etiqueta:'<?php echo $etj["prpEtiqueta"]?>',
                                                                                nombre:'<?php echo $etj["prpNombre"]?>',
                                                                                obligatorio:'<?php echo $etj["prpObligatorio"]?>',
                                                                                ancho:'<?php echo $etj["prpAncho"]?>',
                                                                                longMax:'<?php echo $etj["prpLongMax"]?>',
                                                                                alto:'<?php echo $etj["prpAlto"]?>',
                                                                                fechaMin:'<?php echo $etj["prpFechaMin"]?>',
                                                                                fechaMax:'<?php echo $etj["prpFechaMax"]?>',
                                                                                tamano:'<?php echo $etj["prpTamMax"]?>',
                                                                                numCol:'<?php echo $etj["prpNumCol"]?>',
                                                                                anchoCelda:'<?php echo $etj["prpAnchoCelda"]?>',
                                                                                selDefault:'<?php echo $etj["prpDefault"]?>',
                                                                                minObl:'<?php echo $etj["prpMinSel"]?>',
                                                                                varSesion:'<?php echo $etj["prpVSesion"]?>',
                                                                                actualizable:'<?php echo $etj["prpActualizable"]?>',
                                                                                tipoArch:'<?php echo $etj["prpTipoArch"]?>',
                                                                                horaMin:'<?php echo $etj["prpHoraMin"]?>',
                                                                                horaMax:'<?php echo $etj["prpHoraMax"]?>',
                                                                                intervalo:'<?php echo $etj["prpIntervalo"]?>',
                                                                                numDecimales:'<?php echo $etj["prpNumDecimales"]?>',
                                                                                separaMiles:'<?php echo $etj["prpSepMiles"]?>',
                                                                                separaDec:'<?php echo $etj["prpSepDec"]?>',
                                                                                tratoDec:'<?php echo $etj["prpTratoDec"]?>',
                                                                                formula:'<?php echo $etj["prpFormula"]?>',
                                                                                vincular:'Vincular con Lita',
                                                                                enlace:'Vincular a enlace',
                                                                                orden:'Orden Tab.',
                                                                                maxAncho:'M&aacute;x. ancho',
                                                                                estilo:'Estilo',
                                                                                alineacion:'Alineaci&oacute;n',
                                                                                formatoHTML:'Mantener formato HTML'
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
    colM.setColumnHeader(1,'<?php echo $etj["lblValor"]?>');
    colM.setColumnHeader(0,'<?php echo $etj["lblPropiedadN"]?>');
    colM.setRenderer(1,formatearValor);
    
    propsGrid.on('beforeedit',validarEdicion);
    propsGrid.on('afteredit',regCambiado);                                                    	
    gridPropiedades=propsGrid;
    
    var txtAncho=new Ext.form.NumberField	(
                                                {
                                                    id:'txtAncho',
                                                    renderTo:'divAncho',
                                                    width:50,
                                                    value:valorAncho,
                                                    allowDecimals:false
                                                }
                                            );
    txtAncho.on('change',cambioAncho);                                            
    var txtAlto=new Ext.form.NumberField	(
                                                {
                                                    id:'txtAlto',
                                                    renderTo:'divAlto',
                                                    width:50,
                                                    value:valorAlto,
                                                    allowDecimals:false
                                                }
                                            );   
    txtAlto.on('change',cambioAlto);	                                            
    var x;
    for(x=0;x<calibrarCtrl.length;x++)
    {
    	calibrarPosicion(calibrarCtrl[x]);
    }
}

function formatearAlineacion(valor)
{
	return formatearValorRenderer(arrAlineacion,valor);
}

function formatearValorSiNO(valor)
{
	return formatearValorRenderer(arrSiNoAux,valor);
}

function validarEdicion(e)
{
	if((e.record.id=='formula'))
    	e.cancel=true;
     
}

function formatearEnlace(value)
{
	return formatearValorRenderer(arrEnlaces,value);
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

function cambioAncho(combo,nuevoValor,viejoValor)
{
	var idFormulario=gE('idFormulario').value;
    var nValor=nuevoValor;
    if(nValor=='')
    	nValor=10;
    function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	var tdContenedor=gE('tdContenedor');
            tdContenedor.style.width=nuevoValor+'px';
            var frame=gE('frameTitulo');
            frame.style.width=nuevoValor+'px';
			maxX=nuevoValor+360;
            var tblTool=gE('divTool');
            tblTool.style.left=960+(parseInt(nuevoValor)-620)+'px';

        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=23000&ancho='+nValor+'&idFormulario='+idFormulario,true);
    
}

function cambioAlto(combo,nuevoValor,viejoValor)
{
	var idFormulario=gE('idFormulario').value;
    var nValor=nuevoValor;
    if(nValor=='')
    	nValor=10;
    function funcResp()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
        	var tdContenedor=gE('tdContenedor');
            tdContenedor.style.height=nuevoValor+'px';
            var frame=gE('frameTitulo');
            frame.style.height=nuevoValor+'px';
            maxY=nuevoValor+184;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=24000&alto='+nValor+'&idFormulario='+idFormulario,true);
}

function formatearFecha(valor)
{
	if(valor!='')
    {
    	valor=valor.format('d/m/Y');
    }
    return valor;
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
        	return fila.get('tipo');
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

function formatearBtnFormula(valor)
{
	var div=gE(idDivSel);
    var nControl=div.getAttribute('controlInterno');
	var arrNomAnt=nControl.split('_');
    var control='_'+arrNomAnt[1];
    
	return '<input type="button" value="..." class="btnPuntos" onclick=mostrarVentanaCampoOperacion(\''+control+'\')>';
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

function regCambiado(registro)
{
	var campo=registro.record.get('name');
	var valor=registro.value;
    var idControl=idControlSel;
    
    
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
        case 'vincular':
        	msgBox('El modulo Lita no se encuentra instalado en el sistema, contacte con grupo Latis para solucionar el problema');
        	return;
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
        case 'estilo':
        	accion=29;
        break;
         case 'enlace':
        	accion=37;
        break;
        //---
        case 'maxAncho':
        	accion=38;
        break;
        case 'formatoHTML':
        	accion=39;
        break;
        case 'alineacion':
        	accion=40;
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
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
            switch(campo)
            {
                case 'nombre':
                	var nControl=generarNomControl(valor,tipoControl);
                    var div=gE(idDivSel);
                    var nomAnterior=div.getAttribute('controlInterno');
                    var arrNomAnt=nomAnterior.split('_');
                    div.setAttribute('controlInterno',nControl+'_'+tipoControl);
                    var control=gE('_'+arrNomAnt[1]);
                    
                    var nombreControl='_'+arrNomAnt[1];
                    
                    
                    if(tipoControl=='8') //fecha
                    {
                    	var val=control.getAttribute('val');
                        var dteFecha=Ext.getCmp('f_sp_'+arrNomAnt[1]);	
                        var maxFecha=dteFecha.maxValue;
                        var minFecha=dteFecha.minValue;
                    	var tdContenedor=gE('td_'+idControlSel);
                        var spanFecha=gE('sp_'+arrNomAnt[1]);
                        var padre=spanFecha.parentNode;
                        padre.removeChild(spanFecha);
                        var nuevoContenedor=document.createElement('span')
                        nuevoContenedor.id='sp'+nControl;
                        padre.appendChild(nuevoContenedor);
                        control.id=nControl;
                        control.name=nControl;
                        crearCampoFecha('sp'+nControl,nControl,minFecha,maxFecha);
                    }
                    else
                        if(tipoControl=='12') //archivo
                        {
                            var tipoArch=gE('tipoArch_'+arrNomAnt[1]);
                            tipoArch.id='tipoArch'+nControl;
                            var tamArch=gE('tamArch_'+arrNomAnt[1]);
                            tamArch.id='tamArch'+nControl;
                            control.id=nControl;
                        }
 						else
                            if((tipoControl=='14')||(tipoControl=='15')||(tipoControl=='16'))
                            {
                            	var d=gE('default'+nombreControl);
                                d.id='default'+nControl;
                                var anchoCelda= gE('anchoCelda'+nombreControl);
                                anchoCelda.id='anchoCelda'+nControl;
                                var numCol=gE('numCol'+nombreControl);
                                numCol.id='numCol'+nControl;
                                var listaNum=gE('lista'+nombreControl);
                                listaNum.id='lista'+nControl;
                                control.id=nControl;
                                var arrElementosSel=listaNum.value;
                                var arrOpc=eval(arrElementosSel);
                                var span=document.createElement('span');
                                var spanDel=gE('span'+nombreControl);
                                var padre=spanDel.parentNode;
                                padre.removeChild(spanDel);
                                var anchoCol=anchoCelda.value;
                                var tablaCtrl=crearTabla(numCol.value,arrElementosSel,parseInt(tipoControl),nControl,anchoCol);
                                span.id='span'+nControl;
                                span.appendChild(tablaCtrl);
                                padre.appendChild(span);
                            }
                            else
                            {
                            	if((tipoControl=='17')||(tipoControl=='18')||(tipoControl=='19'))
                                {
                                	
                                    var anchoCelda= gE('anchoCelda'+nombreControl);
                                    anchoCelda.id='anchoCelda'+nControl;
                                    var numCol=gE('numCol'+nombreControl);
                                    numCol.id='numCol'+nControl;
                                    var listaNum=gE('lista'+nombreControl);
                                    listaNum.id='lista'+nControl;
                                    control.id=nControl;
                                    var arrElementosSel=listaNum.value;
                                    var arrOpc=eval(arrElementosSel);
                                    var span=document.createElement('span');
                                    var spanDel=gE('span'+nombreControl);
                                    var padre=spanDel.parentNode;
                                    padre.removeChild(spanDel);
                                    var anchoCol=anchoCelda.value;
                                    var tablaCtrl=crearTabla(numCol.value,arrElementosSel,parseInt(tipoControl),nControl,anchoCol);
                                    span.id='span'+nControl;
                                    span.appendChild(tablaCtrl);
                                    padre.appendChild(span);
                                	var minSel=gE('minSel'+nombreControl);
                                    minSel.id='minSel'+nControl;
                                    
                                }
                            	else
                                	if(tipoControl=='20')
                                    {
                                    	var hTipo=gE('tipo'+nombreControl);
                                		hTipo.id='tipo'+nControl;
                                        var hActualizable=gE('actualizable'+nombreControl);
                                		hActualizable.id='actualizable'+nControl;
                                        control.id=nControl;
                                        control.name=nControl;
                                        control.value=valor;
                                    }
                                    else
                            			control.id=nControl;
                            }
                break;
                case 'obligatorio':
                	var td=gE('td_obl_'+idControlSel);
                    
                	if(valor=='0')
                    {
                        td.innerHTML='';
                    
                    }
                    else
                    {
                    	td.innerHTML='<font color="red">*</font>';
                    }
                break;
                case 'ancho':
                    var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=gE('_'+arrNomAnt[1]);
                    if((tipoControl=='5')||(tipoControl=='11')||(tipoControl=='6')||(tipoControl=='7')) //texto corto, mail
                	{
                    	ctrl.setAttribute('size',valor);
                    }
                    if(tipoControl==9) //texto largo
                    {
                    	ctrl.setAttribute('cols',valor);
                    }
                    
                    if(tipoControl==10)
                    {
                    	var texto=Ext.getCmp('_'+arrNomAnt[1]);
                        texto.setWidth(valor);
                    }
                    
                    if(tipoControl==13)
                    {
                    	ctrl.style.width=valor+'px';
                    }
                     if(tipoControl=='23')
                    {
                    	ctrl.width=valor;
                    }
                break;
                case 'longMax':
					var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=gE('_'+arrNomAnt[1]);
                    ctrl.setAttribute('maxlength',valor);
                break;
                case 'alto':
                
                	var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=gE('_'+arrNomAnt[1]);
                	if(tipoControl==9) //texto largo
                    {
                        ctrl.setAttribute('rows',valor);
                    }    
                    if(tipoControl==10)
                    {
                    	var texto=Ext.getCmp('_'+arrNomAnt[1]);
                       
                    }
                    if(tipoControl==13)
                    {
                    	ctrl.style.height=valor+'px';
                    }
                    if(tipoControl=='23')
                    {
                    	ctrl.height=valor;
                    }
                    
                break;
                case 'fechaMin':
                    var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var dteFecha=Ext.getCmp('f_sp_'+arrNomAnt[1]);	
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
                	var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var dteFecha=Ext.getCmp('f_sp_'+arrNomAnt[1]);	
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
                	var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var tamArch=gE('tamArch_'+arrNomAnt[1]);
                    tamArch.value=valor;    
                break;
                case 'tipoArch': 
                    var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var tipoArch=gE('tipoArch_'+arrNomAnt[1]);
                    tipoArch.value=valor;
                    
                break;
                case 'X':
                    var div=gE(idDivSel);
                    div.style.left=parseInt(valor)+posDivX+'px';
                break;
                case 'Y':
                	var div=gE(idDivSel);
                    div.style.top=parseInt(valor)+posDivY+'px';
                break;
                case 'numCol':
                	var div=gE(idDivSel);
                 	var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	var nomControl='_'+arrNomAnt[1];
                    var arrElementosSel=gE('lista'+nomControl).value;
                   	var arrOpc=eval(arrElementosSel);
                    var span=document.createElement('span');
                    var spanDel=gE('span'+nomControl);
                    var padre=spanDel.parentNode;
                    padre.removeChild(spanDel);
                    var anchoCol=gE('anchoCelda'+nomControl).value;
                    var tablaCtrl=crearTabla(valor,arrElementosSel,parseInt(arrNomAnt[2]),nomControl,anchoCol);
                    span.id='span'+nomControl;
                    span.appendChild(tablaCtrl);
                    padre.appendChild(span);
                    gE('numCol'+nomControl).value=valor;
                    gE('nColumnas'+nomControl).value=valor;
                break;
                case 'anchoCelda':
                	var div=gE(idDivSel);
                 	var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	var nomControl='_'+arrNomAnt[1];
                    var arrElementosSel=gE('lista'+nomControl).value;
                   	var arrOpc=eval(arrElementosSel);
                    var span=document.createElement('span');
                    var spanDel=gE('span'+nomControl);
                    var padre=spanDel.parentNode;
                    padre.removeChild(spanDel);
                    var anchoCol=valor;
                    var tablaCtrl=crearTabla(gE('numCol'+nomControl).value,arrElementosSel,parseInt(arrNomAnt[2]),nomControl,anchoCol);
                    span.id='span'+nomControl;
                    span.appendChild(tablaCtrl);
                    padre.appendChild(span);
                    gE('anchoCelda'+nomControl).value=valor;
                    gE('ancho'+nomControl).value=valor;
                break;
                case 'selDefault':
                	var div=gE(idDivSel);
                 	var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	var nomControl='_'+arrNomAnt[1];
                    var defVal=gE('default'+nomControl).value;
                    if(valor!='100584')
	                    gE('opt'+nomControl+'_'+valor).checked=true;
                    else
                    {
                    	gE('opt'+nomControl+'_'+defVal).checked=false;
                    }
                    gE('default'+nomControl).value=valor;
                break;
                case 'minObl':
                    var div=gE(idDivSel);
                 	var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	var nomControl='_'+arrNomAnt[1];
                    gE('minSel'+nomControl).value=valor;
                    
                break;
                case 'varSesion':
                    var div=gE(idDivSel);
                 	var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	var nomControl='_'+arrNomAnt[1];
                    gE('tipo'+nomControl).value=valor;
                    
                break;
                case 'actualizable':
                    var div=gE(idDivSel);
                 	var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	var nomControl='_'+arrNomAnt[1];
                    gE('actualizable'+nomControl).value=valor;
                break;
                
                case 'horaMin':
                    var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var dteHora=Ext.getCmp('f_sp_'+arrNomAnt[1]);	
                break;
                case 'horaMax':
                    var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var dteHora=Ext.getCmp('f_sp_'+arrNomAnt[1]);	
                break;
                case 'intervalo':
                    var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var dteHora=Ext.getCmp('f_sp_'+arrNomAnt[1]);	
                break;
                case 'numDecimales':
                	var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	gE('numD__'+arrNomAnt[1]).value=valor;
                    evaluarExpresion('_'+arrNomAnt[1]);
                break;
                case 'separaMiles':
                    var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	gE('sepMiles__'+arrNomAnt[1]).value=valor;
                    evaluarExpresion('_'+arrNomAnt[1]);
                break;
                case 'separaDec':
                    var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	gE('sepDec__'+arrNomAnt[1]).value=valor;
                    evaluarExpresion('_'+arrNomAnt[1]);
                break;
                case 'tratoDec':
                    var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                	gE('tratoDec__'+arrNomAnt[1]).value=valor;
                    evaluarExpresion('_'+arrNomAnt[1]);
                break;
                case 'orden':
                	var div=gE(idDivSel);
                    var vValor=div.getAttribute('orden');
                	actualizarFocus(vValor,valor);
                    div.setAttribute('orden',valor);
               	break;
                case 'estilo':
                	var div=gE(idDivSel);
                    var nControl=div.getAttribute('controlInterno');
                    var arrNomAnt=nControl.split('_');
                    var ctrl=gE('_'+arrNomAnt[1]);
                    setClase(ctrl,valor);
                	
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
                                	link=gE('link_'+idControl);
                                    contenido=link.innerHTML;
                                    _lbl=gE('_lbl'+idControl);
                                    _lbl.innerHTML=contenido;
                                   
                                    
                                }
                                else
                                {
                                	_lbl=gE('_lbl'+idControl);
                                    contenido=_lbl.innerHTML;
                                    _lbl.innerHTML='<a id="link_'+idControl+'" href="javascript:doNothing()">'+contenido+'</a>';
                                }
                                 
                            break;
                            case '23':
                            	if(valor=='')
                                {
                                	link=gE('link_'+idControl);
                                    contenido=link.innerHTML;
                                    _lbl=gE('_img'+idControl);
                                    _lbl.innerHTML=contenido;
                                    
                                }
                                else
                                {
                                	_lbl=gE('_img'+idControl);
                                    contenido=_lbl.innerHTML;
                                    _lbl.innerHTML='<a id="link_'+idControl+'" href="javascript:doNothing()">'+contenido+'</a>';
                                }
                            break;
                        }
                		_lbl.setAttribute('enlace',valor);
                break;
                case 'maxAncho':
                	var div=gE(idDivSel);
                    div.setAttribute('maxAncho',valor);
                    var lbl=gE('_lbl'+idControl);
                    
                    lbl.style.width=valor+'px';
                break;
                case 'formatoHTML':
                	var div=gE(idDivSel);
                    div.setAttribute('formatoHTML',valor);
                break;
                case 'alineacion':
                	var div=gE(idDivSel);
                    div.setAttribute('alineacion',valor);
                break;
                default:
                    if(campo.indexOf('etiqueta')>-1)
                    {
                    	var idIdiomaPag=gE('hLeng').value;
                        if(idIdioma==idIdiomaPag)
                        {
                        	gE('_lbl'+idControl).innerHTML=valor;
                            gE('td_'+idControl+'_'+idIdioma).value=valor;
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
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=18000&accion='+accion+'&idControl='+idControl+'&valor='+cv(''+valor)+'&idIdioma='+idIdioma,true);
}

function generarNomControl(nombre,tipoControl)
{
	var nomControl='_'+nombre;
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
    }
    return nomControl+sufijo;
}

function establecerFuente(idControl)
{
    
	var fuente={};
    var div=gE(idControl);
    var gridPropiedades=Ext.getCmp('GridPropiedades');
    var nomControl=div.getAttribute('controlInterno');
	var vOrden=div.getAttribute('orden');
    arrNomControl=nomControl.split('_');
    tipoControl=arrNomControl[2];
	var ctrlNombre=arrNomControl[1].substr(0,arrNomControl[1].length-3); 
    var ctrl=gE('_'+arrNomControl[1]);
    var x=parseInt(div.style.left.substr(0,div.style.left.length-2))-posDivX;
    var y=parseInt(div.style.top.substr(0,div.style.top.length-2))-posDivY;
    
    var obl=0;
    var tControl=parseInt(tipoControl);

    
    if((tControl>1)&&(!(tControl>=13)&(tControl<=16)))
    {
    	var ctrl=gE('_'+arrNomControl[1]);
        var val=ctrl.getAttribute('val');

        if(val.indexOf('obl')>-1)
        	obl=1;
        else
        	obl=0;
    }

    switch(tipoControl)
    {
    	case '-1':
        case '0':
        	var estiloCtrl=obtenerClase(ctrl);
        	fuente=	{
            			
                        X:x,
                        Y:y,
                        orden:vOrden,
                        estilo:estiloCtrl
                        
            		}
            
        break;
    	case '1':  //etiqueta
            var ct=0;
            var arrCampos=',';
            var valorEt='';
            
            var vRef=div.getAttribute('ctrlRef');
            var tipoCtrl=div.getAttribute('tipoCtrl');
            var enlace=gE('_lbl'+idControlSel).getAttribute('enlace');
            if((vRef==null)||(tipoCtrl=='1'))
            {	
                for(ct=0;ct<nIdiomas;ct++)
                {
                    valorEt=gE('td_'+idControlSel+'_'+arrIdiomas[ct].idIdioma).value;
                    arrCampos+='"etiqueta_'+arrIdiomas[ct].idIdioma+'":"'+valorEt+'"';
                }
            }
            else
            	arrCampos='';
            var estilo=obtenerClase(ctrl);
            var txtObj='[{"enlace":"'+enlace+'","X":"'+x+'","Y":"'+y+'"'+arrCampos+',"estilo":"'+estilo+'"}]';
        	fuente=	eval(txtObj)[0];
            switch(div.getAttribute('tipoCtrl'))
            {
            	case '2':
                case '3':
                case '4':
                case '5':
                case '9':
                case '11':
                case '30':
                	fuente.maxAncho=div.getAttribute('maxAncho');
                break;
                case '10':
               		fuente.maxAncho=div.getAttribute('maxAncho');
                    fuente.alineacion=div.getAttribute('alineacion');
                	fuente.formatoHTML=div.getAttribute('formatoHTML');
                break;
            }
            
        break;
    	case '2': //pregunta cerrada-Opciones Manuales
		case '3': //pregunta cerrada-Opciones intervalo
		case '4': //pregunta cerrada-Opciones tabla
        	var estiloCtrl=obtenerClase(ctrl);
        	fuente=	{
            			
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        vincular:0,
                        orden:vOrden,
                        estilo:estiloCtrl
            		}
                    
              mE('btnDisparador');      
                    
		break;
		case '6': //Número entero
		case '7': //Número decimal
        	var txtAncho=ctrl.size;
            var estiloCtrl=obtenerClase(ctrl);
        	fuente=	{
            			
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        ancho:txtAncho,
                        vincular:0,
                        orden:vOrden,
                        estilo:estiloCtrl
            		}
		break;
		case '8': //Fecha
			var dteFecha=Ext.getCmp('f_sp_'+arrNomControl[1]);	
            var maxFecha=dteFecha.maxValue;
            var minFecha=dteFecha.minValue;
            if(maxFecha==null)
            	maxFecha='';
            if(minFecha==null)
            	minFecha='';
            
        	fuente=	{
            			
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        fechaMin:minFecha,
                        fechaMax:maxFecha,
                        vincular:0,
                        orden:vOrden
            		}
		break;
		case '9'://Texto Largo 
		case '10': //Texto Enriquecido
        	var txtAncho;
            var txtAlto;
           
            if(tipoControl=='9')
            {
            	txtAncho=ctrl.getAttribute('cols');
                txtAlto=ctrl.getAttribute('rows');
                var estiloCtrl=obtenerClase(ctrl);
                fuente=	{
            			
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        ancho:txtAncho,
                        alto:txtAlto,
                        orden:vOrden,
                        estilo:estiloCtrl
            		}
            }  
            else
            {
				var texto=Ext.getCmp('_'+ctrlNombre+'vch');
                txtAncho=texto.getWidth();
                txtAlto=texto.getHeight();
                fuente=	{
            			
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        ancho:txtAncho,
                        alto:txtAlto,
                        orden:vOrden
            		}
            } 
		break;
        case '5': //Texto Corto
		case '11': //Correo Electrónico
        	var txtAncho=ctrl.size;
            var txtLongMax=ctrl.getAttribute('maxlength');
        	var estiloCtrl=obtenerClase(ctrl);
        	fuente=	{
            			
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        ancho:txtAncho,
                        longMax:txtLongMax,
                        vincular:0,
                        orden:vOrden,
                        estilo:estiloCtrl
            		}
		break;
		case '12': //Archivo
              var tam=gE('tamArch_'+arrNomControl[1]).value;
              var tArch=gE('tipoArch_'+arrNomControl[1]).value;
              fuente=	{
                          
                          X:x,
                          Y:y,
                          obligatorio:obl,
                          tamano:tam,
                          tipoArch:tArch,
                          orden:vOrden
                      }	
		break;
        case '13': //Frame
        		txtAncho=ctrl.style.width.replace('px','');
                txtAlto=ctrl.style.height.replace('px','');
                var arrCampos=',';
                for(ct=0;ct<nIdiomas;ct++)
                {
                    valorEt=gE('td_'+idControlSel+'_'+arrIdiomas[ct].idIdioma).value;
                    arrCampos+='"etiqueta_'+arrIdiomas[ct].idIdioma+'":"'+valorEt+'"';
                }
                var txtObj='[{"X":"'+x+'","Y":"'+y+'"'+arrCampos+',"ancho":"'+txtAncho+'","alto":"'+txtAlto+'"}]';
        		fuente=	eval(txtObj)[0];
               
                
        break;
        case '14':
        case '15':
        case '16':
        
        	vHidden='numCol_'+arrNomControl[1];
        	var numC=gE(vHidden).value;
            var ancho=gE('anchoCelda_'+arrNomControl[1]).value;
            var aDatos=gE('lista_'+arrNomControl[1]).value;
            var nDatos="[['100584','<?php echo $etj["lblNinguno"]?>'],"+aDatos.substr(1);
            var arrDatos=eval(nDatos);
            dsComboSeleccion.loadData(arrDatos);
            var vDefault=gE('default_'+arrNomControl[1]).value;
            if(vDefault=='-1')
            	vDefault='100584';
            if(ancho=='')
            	ancho=0;
            var estiloCtrl=obtenerClase(ctrl);
        	fuente=	{
            			
                        X:x,
                        Y:y,
                        obligatorio:obl,
                        numCol:numC,
                        anchoCelda:ancho,
                        selDefault:vDefault,
                        vincular:0,
                        orden:vOrden,
                        estilo:estiloCtrl
            		}
        	mE('btnDisparador');      
        break;
        case '17':
        case '18':
        case '19':
        	vHidden='numCol_'+arrNomControl[1];
        	var numC=gE(vHidden).value;
            var ancho=gE('anchoCelda_'+arrNomControl[1]).value;
            var aDatos=gE('lista_'+arrNomControl[1]).value;
            var nDatos="[['100584','<?php echo $etj["lblNinguno"]?>'],"+aDatos.substr(1);
            var arrDatos=eval(nDatos);
            dsComboSeleccion.loadData(arrDatos);
            var minimoObl=gE('minSel_'+arrNomControl[1]).value;
            if(ancho=='')
            	ancho=0;
            var estiloCtrl=obtenerClase(ctrl);
        	fuente=	{
            			
                        X:x,
                        Y:y,
                        numCol:numC,
                        anchoCelda:ancho,
                        minObl:minimoObl,
                        vincular:0,
                        orden:vOrden,
                        estilo:estiloCtrl
            		}
        
        break;
        case '20':
        	
        	var vVSesion=gE('tipo_'+arrNomControl[1]).value;
            var vActualizable=gE('actualizable_'+arrNomControl[1]).value;
        	fuente=	{
            			
                        varSesion:vVSesion,
                        actualizable:vActualizable,
                        orden:vOrden
            		}
                    
            oE('btnAyuda');
        break;
        case '21': //Hora
			var tmeFecha=Ext.getCmp('f_sp_'+arrNomControl[1]);	
            var maxHora=tmeFecha.maxValue;
            var minHora=tmeFecha.minValue;
            if(maxHora==null)
            	maxHora='';
            if(minHora==null)
            	minHora='';
            var interval=tmeFecha.increment;
        	fuente=	{
            			
                        X:x,
                        Y:y,
                        intervalo:interval,
                        obligatorio:obl,
                        horaMin:minHora,
                        horaMax:maxHora,
                        vincular:0,
                        orden:vOrden
            		}
		break;
        case '22':
        	var nDecimales=gE('numD_'+'_'+arrNomControl[1]).value;
            var separadorMiles=gE('sepMiles__'+arrNomControl[1]).value;
            var separadorDecimales=gE('sepDec__'+arrNomControl[1]).value;
            var tratoDecimales=gE('tratoDec__'+arrNomControl[1]).value;
			var estiloCtrl=obtenerClase(ctrl);
        	fuente=	{
            			
                        X:x,
                        Y:y,
                        vincular:0,
                        numDecimales:nDecimales,
                        separaMiles:separadorMiles,
                        separaDec:separadorDecimales,
                        tratoDec:tratoDecimales,
                        formula:'',
                        estilo:estiloCtrl                        
            		}
        break;   
        case '23':
        	var txtAncho;
            var txtAlto;
            var enlace=gE('_img'+idControlSel).getAttribute('enlace');
            var imagen=gE('_'+ctrlNombre+'img');
            txtAncho=imagen.width;
            txtAlto=imagen.height;
            fuente=	{
                        X:x,
                        Y:y,
                        ancho:txtAncho,
                        alto:txtAlto,
                        enlace:enlace
                    }
        break;                 
    }
    gridPropiedades.setSource(fuente);
    gridPropiedades.getView().refresh();
    var datos=gridPropiedades.getStore();
    var posX=obtenerPosFila(datos,'name','X');
    var posY=obtenerPosFila(datos,'name','Y');
    if(posX>-1)
      	filaX=datos.getAt(posX);
    else
    	filaX=null;
  	if(posY>-1)
    	filaY=datos.getAt(posY);
    else
        filaY=null;
}

function evitaEventos(event)
{
    if(navegador==0)
    {
        window.event.cancelBubble=true;
        window.event.returnValue=false;
    }
    if(navegador==1) 
    	event.preventDefault();
}

function comienzoMovimiento(event, id)
{
	if((id=='divProp')||(id=='divTool'))
    {
    	idDivAnt=idDivSel;
    }
	idDivSel=id;
   	elMovimiento =document.getElementById(id);
    if(elMovimiento.getAttribute('movible')!=null)
    {
    	seleccionarControl(id);
        return;
    }
    altoDiv=elMovimiento.offsetHeight;
    anchoDiv=elMovimiento.offsetWidth;
	posicionInicioX=elMovimiento.style.left;
    posicionInicioY=elMovimiento.style.top;
   
    if(navegador==0)
    {
        cursorComienzoX=window.event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft;
        cursorComienzoY=window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop;
        document.attachEvent("onmousemove", enMovimiento);
        document.attachEvent("onmouseup", finMovimiento);
    }
    if(navegador==1)
    {   
        cursorComienzoX=event.clientX+window.scrollX;
        cursorComienzoY=event.clientY+window.scrollY;
        document.addEventListener("mousemove", enMovimiento, true);
        document.addEventListener("mouseup", finMovimiento, true);
    }
   
    elComienzoX=parseInt(elMovimiento.style.left);
    elComienzoY=parseInt(elMovimiento.style.top);
    if(elMovimiento.getAttribute('ignorarLimites')==null)
    {
    	seleccionarControl(id);
    }
    
    elMovimiento.style.zIndex=++posicion;
    if(elMovimiento.getAttribute('lanzaEvento')==null)
	    evitaEventos(event);
}

function seleccionarControl(id)
{
	var atClase;
    
	if(controlSel!=null)
    	setClase(controlSel,'');
    var arrDiv=id.split('_');
    idControlSel=arrDiv[1];
	var divSel=gE(id);
    var arrNomDiv=id.split('_');
    controlSel=gE('td_'+arrNomDiv[1]);
    setClase(controlSel,'seleccionado');
    establecerFuente(id);
    
}

function desSeleccionarControlSel()
{
	if(controlSel!=null)
    	controlSel.setAttribute('class','');
}

function enMovimiento(event)
{ 
	var xActual, yActual;
    if(estado==2)
    {
    
        if(navegador==0)
        {   
            xActual=window.event.clientX+document.documentElement.scrollLeft+document.body.scrollLeft;
            yActual=window.event.clientY+document.documentElement.scrollTop+document.body.scrollTop;
        } 
        if(navegador==1)
        {
            xActual=event.clientX+window.scrollX;
            yActual=event.clientY+window.scrollY;
        }
        var nuevoX=elComienzoX+xActual-cursorComienzoX-posDivX;

        var ignorar=elMovimiento.getAttribute('ignorarLimites');
        if(ignorar==null)
        {
            if(nuevoX<minX)
                nuevoX=minX;
            if((nuevoX+anchoDiv)>maxX)
                nuevoX=maxX-anchoDiv;
        }    
        var nuevoY=(elComienzoY+yActual-cursorComienzoY-posDivY);
        
        var ignorar=elMovimiento.getAttribute('ignorarLimites');
        if(ignorar==null)
        {
            if(nuevoY<minY)
                nuevoY=minY;
            if((nuevoY+altoDiv)>maxY)
                nuevoY=maxY-altoDiv;
		}
        elMovimiento.style.left=(nuevoX+posDivX)+"px";
        ultimaPosX=nuevoX;
        elMovimiento.style.top=(nuevoY+posDivY)+"px";
        ultimaPosY=nuevoY;
        evitaEventos(event);
	}
}

function finMovimiento(event)
{
	if(navegador==0)
    {   
    	document.detachEvent("onmousemove", enMovimiento);
        document.detachEvent("onmouseup", finMovimiento);
	}
    if(navegador==1)
    {
    	document.removeEventListener("mousemove", enMovimiento, true);
        document.removeEventListener("mouseup", finMovimiento, true);
	}
    
    var ignorar=elMovimiento.getAttribute('ignorarLimites');
    
    if(idDivAnt!=null)
    {
    	idDivSel=idDivAnt;
    	idDivAnt=null;
    }
    
    if((ignorar==null)||(ignorar=='actualizar'))
    {
        if(ultimaPosX!=undefined)
        {
            actualizarPosicionElemento();
            if(filaX!=null)
                filaX.set('value',ultimaPosX);
            if(filaY!=null)
                filaY.set('value',ultimaPosY);
        }
    }
}

function obtenerPosX(idObj)
{

  var curleft = 0;
  var obj=gE(idObj);
  if(obj.offsetParent)
      while(1)
      {
        curleft += obj.offsetLeft;
        if(!obj.offsetParent)
          break;
        obj = obj.offsetParent;
      }
  else if(obj.x)
      curleft += obj.x;
  return curleft;
}

function obtenerPosY(idObj)
{
  var curtop = 0;
  var obj=gE(idObj);
  if(obj.offsetParent)
      while(1)
      {
        curtop += obj.offsetTop;
        if(!obj.offsetParent)
          break;
        obj = obj.offsetParent;
      }
  else if(obj.y)
      curtop += obj.y;
  return curtop;
}

function calibrarPosicion(id)
{
	var elMovimiento=gE(id);
    elMovimiento.style.left=(parseInt(elMovimiento.style.left)+posDivX)+'px';
    elMovimiento.style.top=(parseInt(elMovimiento.style.top)+posDivY)+'px';
    
}

function checarCheck(id)
{
	var chk=gE(id);
	chk.checked=!chk.checked;
    mostrarRejila(chk);

}

function mostrarVentanaEnlace()
{

	var tablaTiposEnlace=[['0','<?php echo $etj["lblOpPagina"] ?>'],['2','<?php echo $etj["lblOpFormulario"] ?>']];
	
	
	var dsTipoEnlace= new Ext.data.SimpleStore	(
											 	{
													fields:	[
															 	{name:'id'},
																{name:'nombre'}
																
															]
												}
											)
	dsTipoEnlace.loadData(tablaTiposEnlace);	
	var selectTipoEnlace=document.createElement('select');
	var cmbTipoEnlace=new Ext.form.ComboBox	(
												{
													x:130,
													y:5,
													id:'cmbTipoEnlace',
													mode:'local',
													emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
													store:dsTipoEnlace,
													displayField:'nombre',
													valueField:'id',
													transform:selectTipoEnlace,
													editable:false,
													typeAhead: true,
													triggerAction: 'all',
													lazyRender:true,
													value:0
												
												}
											)
	
    
    cmbTipoEnlace.on('select',funcTipoEnlaceSel);
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
																					text:'Tipo de enlace:'
																				}
																			),
														cmbTipoEnlace
											
													]
										}
									);

	


	var ventanaTO = new Ext.Window(
								{
									title: '<?php echo $etj["lblAplicacion"]?>',
									width: 400,
									height:150,
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
																cmbTipoEnlace.focus();
															}
														}
											},
									buttons:	[
													{
														id:'btnAceptar',
														text: '<?php echo $etj["lblBtnAceptar"]?>',
														listeners:	{
																		click:function()
																			{
                                                                            
                                                                            	switch(cmbTipoEnlace.getValue())
                                                                                {
                                                                                	case '2':
                                                                                    	mostrarVentanaFormulariosDinamicos();
                                                                                    break;
                                                                                   /* case '4':
                                                                                    	mostrarVentanaProcesos();
                                                                                    break;
                                                                                    default:
                                                                                    	agregarOpcion();*/
                                                                                }
																				
																				ventanaTO.close();
																			}
																	}
													},
													{
														text: '<?php echo $etj["lblBtnCancelar"]?>',
														handler:function()
																{
																	ventanaTO.close();
																}
													}
												]
								}
							);
		ventanaTO.show();
	
}

function funcTipoEnlaceSel(combo,registro,indice)
{
	
}

function mostrarVentanaFormulariosDinamicos()
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
                                                            header:'Formulario',
                                                            width:200,
                                                            dataIndex:'nombre'
                                                        },
                                                        {
                                                        	header:'T&iacute;tulo',
                                                            width:150,
                                                            dataIndex:'titulo'
                                                        },
                                                        {
                                                        	header:'Descripci&oacute;n',
                                                            width:350,
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
                                                            height:300,
                                                            width:750,
                                                            title:'Seleccione formulario:'
                                                            
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
                            
    var arrProcesos=<?php echo $arrProcesos ?>;
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
                                                                        	msgBox('Debe seleccionar un formulario');
                                                                        	return;
                                                                        }
                                                                       
                                                                        if(filaSel.get('formularioBase')=='1')
                                                                        {
                                                                        	//var idProceso=filaSel.get('idProceso');
                                                                            var idFormulario=filaSel.get('idFormulario');
                                                                            agregarOpcion(nodoSel,'2',idFormulario);
                                                                            //agregarOpcion(nodoSel,'3',idProceso);
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                        	var idFormulario=filaSel.get('idFormulario');
                                                                            agregarOpcion(nodoSel,'2',idFormulario);
                                                                        }
                                                                        
                                                                        ventanaSelForm.close();
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelForm = new Ext.Window(
                                            {
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
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=14&idProceso='+registro.get('id'),true);
}

function actualizarFocus(vFocus,nFocus)
{
	var x;
    var div;
    var divCtrl;
    var orden;
    var nOrden;
    var ordenDiv;
    for(x=0;x<arrElementosFocus.length;x++)
    {
    	div=arrElementosFocus[x];
        divCtrl=gE(div);
        orden=divCtrl.getAttribute('orden');
        nOrden=parseInt(orden);
        if(vFocus>nFocus)
        {
        	if((nOrden>=nFocus)&&(nOrden<vFocus))
            	divCtrl.setAttribute('orden',(nOrden+1));
        
        }
        else
        {
        	if((nOrden>vFocus)&&(nOrden<=nFocus))
            	divCtrl.setAttribute('orden',(nOrden-1));
        	
        }
        
    }
}
