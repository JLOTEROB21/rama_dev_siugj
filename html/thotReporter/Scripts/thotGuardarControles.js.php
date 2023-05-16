<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var valorAux;
var tipoElemento;

function guardarPregunta(datosP,ventana)//accion 0 guardar Nuevo;1 modificar
{
	objDatosActual='['+datosP+']';
	var obj=eval('['+datosP+']');
	var idControl=dv(obj[0].nomCampo);
    tipoElemento=obj[0].tipoElemento;
    if((tipoElemento>1)&&(tipoElemento!=22))
    {
    	var ctrl=gE(idControl);
        if(ctrl!=null)
        {
        	Ext.MessageBox.alert(lblAplicacion,'Ya existe un control con ID ingresado');
            return;
        }
    }
    function funcResp()
    {
    	var arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
		{
        	valorAux=arrResp[2];
            var x;
            var cadenaExp='';
            var opcionesElem=arrResp[2];
            var arrContenido=crearControl(datosP,arrResp[1],opcionesElem);
            insertarControl(arrContenido);
            if(ventana!=undefined)
	            ventana.close();
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcResp, 'POST','funcion=2&datosP='+datosP,true);
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
   celda1.width='1';
   if(contenidos[2]!=null)
	   celda1.appendChild(contenidos[2]);
   fila.appendChild(celda1);
   celda2.id='td_'+contenidos[3];
   celda2.setAttribute('class','');
   var x;
   for(x=0;x<contenidos[0].length;x++)
	   celda2.appendChild(contenidos[0][x]);
   celda3.setAttribute('valign','top');  
   //celda3.appendChild(contenidos[1]);
   fila.appendChild(celda1);
   fila.appendChild(celda2);
   fila.appendChild(celda3);
   tbody.appendChild(fila);
   tabla.appendChild(tbody);
   var divCtrl=document.createElement('div');
   if(contenidos[5]!='26')
	   	idElementoCtrl=idElemento;
   else
		idElementoCtrl=contenidos[3];
   divCtrl.id='div_'+idElementoCtrl;
   divCtrl.setAttribute('controlInterno',contenidos[4]+"_"+contenidos[5]);
   if(contenidos[6]!=undefined)
   		divCtrl.setAttribute('idPadre',contenidos[6]);
	divCtrl.style.position='absolute';
   if(contenidos[8]==undefined)  
	   	divCtrl.style.top=mitadY+'px';
   else
		divCtrl.style.top=parseInt(contenidos[8])+'px';	
   
   if(contenidos[7]==undefined)     
   {
       if(tipoElemento!='25')
            divCtrl.style.left=mitadX+'px';
       else
            divCtrl.style.left=(posDivX-2)+'px';	
	}
    else
    {
		divCtrl.style.left=parseInt(contenidos[7])+'px';    	   
   }
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
    divCtrl.onmouseover=	function()
                          	{
                            	this.style.cursor="move"
                          	}
   	divCtrl.appendChild(tabla);
    
	switch(tipoElemento)
    {
    	case '25':
        	divCtrl.setAttribute('almacenVinculado','0');
        break;
    	case '26':
    	case '27':
        case '28':
        	 setClase(divCtrl,'frameCtrl');
        break;
        
    }
    if(tdContenedor==null)
    	tdContenedor=gE('tdContenedor');
	tdContenedor.appendChild(divCtrl);
    if(contenidos[6]!=undefined)
    {
    	var divPadre=gE('div_'+contenidos[6]);
        if(divPadre!=null)
        {
            var zIndexPadre=divPadre.style.zIndex;
            if(zIndexPadre==null)
                zIndexPadre='1';
        }
        else
        	zIndexPadre='1';
    	divCtrl.style.zIndex=parseInt(zIndexPadre)+1;
		calibrarPosicion('div_'+idElementoCtrl);
        if(divPadre!=null)
	        divCtrl.name='divPadre_'+contenidos[6];
        else
        	divCtrl.name='divPadre_0';
    }
    else
    	divCtrl.name='divPadre_0';
    objControl='';
    p.ctrlDestino=null;
    
   	seleccionarControl('div_'+idElementoCtrl);
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
			Ext.Msg.alert(lblAplicacion,'El valor ingresado en la celda no es v&aacute;lido',funcAceptar);
			
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
			Ext.MessageBox.confirm(lblAplicacion, 'Algunos campos obligatorios no han sido especificados en todos los idiomas desea continuar', funcConfirmacion);
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

function crearControl(datos,idElemen,arrElementosSel)
{
	var control;
	var objDatos=eval('['+datos+']')[0];
    var idIdioma=gE('hIdIdioma').value;
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
                    pregunta[x].setAttribute('class','letraExt');
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
        case '25':
        	nomControl='_secc'+idElemen;
        	var x;
            x=0;
            var confCampo=objDatos.confCampo;
            pregunta[x]=document.createElement('table');
            pregunta[x].id=nomControl;
            pregunta[x].setAttribute('class','frameSeccion');
            pregunta[x].style.width=confCampo.ancho+'px';
            var cuerpo=cE('tbody');
            var fila=cE('tr');
            fila.id='filaPrincipal_'+idElemento;
            fila.style.height=confCampo.alto+'px';
            var td=cE('td');
            fila.appendChild(td);
            cuerpo.appendChild(fila);
            pregunta[x].appendChild(cuerpo);
            arrContenido[0]=pregunta;
        break;
        case '27':
        	nomControl='_lbl'+idElemen;
            var span=document.createElement('span');
            span.id=nomControl;
            span.setAttribute('vInicial','1');
            span.setAttribute('vIncremento','1');
             setClase(span,'letraExt');
            span.innerHTML='#';
            span.style.overflow='hidden';
            span.style.display='inline-block';
            var arr=new Array();
            arr[0]=span;
        	arrContenido[0]=arr;  
        break;
        case '28':
        	nomControl='_lbl'+idElemen;
            var span=document.createElement('span');
            span.id=nomControl;
            setClase(span,'letraExt');
            
            //var arrCampoProy=objDatos.campoProy.split('_');
            
            var campoProy=valorAux;
            
            span.style.overflow='hidden';
            span.style.display='inline-block';
            span.innerHTML=campoProy;
            var arr=new Array();
            arr[0]=span;
        	arrContenido[0]=arr;  
        break;
        case '31':
        	var arrOrigenDatos=bD(arrElementosSel).split('|');
            
        	nomControl='_Grafico'+idElemen;
            var tabla=document.createElement('table');
            var fila=document.createElement('tr');
            var celda=document.createElement('td');
            setClase(celda,'claseDivGrafico');
            var confCampo=objDatos.confCampo;
            celda.id=nomControl;
            celda.setAttribute('idAlmacen','');
			celda.style.width=confCampo.ancho+'px';
            celda.style.height=confCampo.alto+'px';
            celda.setAttribute('titulo',dv(objDatos.tituloGrafico));
            celda.setAttribute('idAlmacen',dv(objDatos.idAlmacen));
            celda.setAttribute('propiedadesGrafico',bE(arrOrigenDatos[0]));
            celda.setAttribute('objPropiedadesGrafico',bE(arrOrigenDatos[1]));
            
            
            
            tabla.appendChild(fila);
            fila.appendChild(celda);
            var label=document.createElement('label');
            label.innerHTML='Gr&aacute;fico: '+dv(objDatos.tituloGrafico);
            celda.appendChild(label);
            var arr=new Array();
            arr[0]=tabla;
        	arrContenido[0]=arr;  
        break;
    }
    
    var arrEliminar=document.createElement('div');
    var linkDel=document.createElement('a');
    linkDel.href='javascript:eliminarElemento("'+bE(idElemento)+'")';
    
    var imgDel=document.createElement('img');

    imgDel.src='../images/formularios/cross.png';
    imgDel.height='10';
    imgDel.width='10';
    imgDel.title='Eliminar elemento';
    imgDel.alt='Eliminar elemento';
    
    linkDel.appendChild(imgDel);
    arrEliminar.appendChild(document.createTextNode(''));
    arrEliminar.appendChild(linkDel);
    
    arrContenido[1]=arrEliminar;
    arrContenido[2]=asteriscoRojo;
    arrContenido[3]=idElemen;
    arrContenido[4]=nomControl;
    arrContenido[5]=tipoElemento;
    arrContenido[6]=objDatos.idPadre;
    arrContenido[7]=objDatos.posX;
    arrContenido[8]=objDatos.posY;
    return arrContenido;
}

function crearControlSeccion(cadArrCampos,idPadre)
{
	var control;
	var pregunta;
    var clase='';
   	clase='letraExt';
    var arrControlesSec=new Array();
    var arrCampos=eval(cadArrCampos);
    var x;
    var fCampo;
    for(x=0;x<arrCampos.length;x++)
    {
    	pregunta=new Array();
    	fCampo=arrCampos[x];
        idElemento=fCampo[0];
        var arrContenido=new Array();
        arrContenido[0]=pregunta;
        var val='';
        var asteriscoRojo=null;
        var nomControl='_lbl'+idElemento;
        pregunta[0]=document.createElement('span');
        pregunta[0].id='_lbl'+idElemento;
        setClase(pregunta[0],clase);
        pregunta[0].appendChild(document.createTextNode(fCampo[1]));
        var arrEliminar=document.createElement('div');
        var linkDel=document.createElement('a');
        linkDel.href='javascript:eliminarElemento("'+bE(idElemento)+'")';
        var imgDel=document.createElement('img');
        imgDel.src='../images/formularios/cross.png';
        imgDel.height='10';
        imgDel.width='10';
        imgDel.title='Eliminar elemento';
        imgDel.alt='Eliminar elemento';
        
        linkDel.appendChild(imgDel);
        arrEliminar.appendChild(document.createTextNode(''));
        arrEliminar.appendChild(linkDel);
        arrContenido[0]=pregunta;
        arrContenido[1]=arrEliminar;
        arrContenido[2]=asteriscoRojo;
        arrContenido[3]=idElemento;
        arrContenido[4]=nomControl;
        arrContenido[5]='26';
        arrContenido[6]=idPadre;
        arrContenido[7]=fCampo[2];
        arrContenido[8]=fCampo[3];
        arrControlesSec.push(arrContenido);
    }
    return arrControlesSec;
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
                      var divControl=gE('div_'+bD(idElemento));
                      var gridPropiedades=p.gEx('GridPropiedades');
                      divControl.parentNode.removeChild(divControl);
                      p.establecerFuenteVacia();
                  }
                  else
                  {
                      msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                  }
              }
              obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcResp, 'POST','funcion=5&idGrupoElemento='+idElemento,true);
          }
      }
      Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar el elemento seleccionado?',resp);
}

function insertarSeccionSepetible()
{
	var tElemento=25;
    var idReporte=gE('idReporte').value;
    var ancho=p.gEx('txtAncho').getValue()-15;
    var alto=25;
    var objFinal='{"idAlmacen":"-1","tipo":"0","idReporte":"'+idReporte+'","pregunta":"","tipoElemento":"'+tElemento+'","obligatorio":"0","posX":"0","posY":"'+mitadY+'","confCampo":{"ancho":"'+ancho+'","alto":"'+alto+'","tipoSeccion":"1"}}';	
	guardarPregunta(objFinal);
}


