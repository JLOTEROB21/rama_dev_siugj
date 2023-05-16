<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

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
        	msgBox('El ID de control ingresado, ya est&aacute; siendo ocupado por otro control,<br> por favor especifique uno diferente');
            return;
        }
    }
    
    if(typeof(tipoElemento)!='number')
    	tipoElemento=parseInt(tipoElemento);
    
	switch(tipoElemento)
    {
    	
    	case 29:
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    p.crearControlGridFormulario(datosP,arrResp[1],'_'+obj.nID);
                    if(ventana!=undefined)
	                    ventana.close();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=56&cadObj='+datosP,true);
        break;
    	default:
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
                            if(ventana!=undefined)
                                ventana.close();
                        }
                        else
                        {
                            var opcionesElem=arrResp[2];
                            var arrContenido=crearControl(datosP,arrResp[1],opcionesElem);
                            insertarControl(arrContenido);
                            if(ventana!=undefined)
                                ventana.close();
                           
                        }
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=1&datosP='+datosP,true);
        break;
	}
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
    divCtrl.setAttribute('eliminable','1');
    if((tipoElemento!='1')&&(tipoElemento!='13')&&(tipoElemento!='22'))
    {
        arrElementosFocus.push('div_'+idElemento);
        divCtrl.setAttribute('orden',(arrElementosFocus.length));	
        var nReg=new regCombo({id:arrElementosFocus.length,nombre:arrElementosFocus.length});
        p.gEx('comboNumTab').getStore().add(nReg);
    }    
    
    divCtrl.style.position='absolute';
    if(contenidos[8]==undefined)  
        divCtrl.style.top=mitadY+'px';
    else
        divCtrl.style.top=parseInt(contenidos[8])+'px';	
   
   	if(contenidos[7]==undefined)     
   	{
   		divCtrl.style.left=mitadX+'px';
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
                 
   divCtrl.appendChild(tabla);
   
	if(tipoElemento!='20')
    {
    	divCtrl.onmouseover=	function()
                                {
                                    this.style.cursor="move"
                                }
   		tdContenedor.appendChild(divCtrl);
    	if((tipoElemento!='29')||((tipoElemento=='29')&&(contenidos[13]=='1')))
	        calibrarPosicion(divCtrl.id);  
    }
   	else
   	{
    	var contenedorTmp=gE('tblHidden');
        contenedorTmp.appendChild(divCtrl);
   	}
    
    
    
    switch(tipoElemento+'')
    {
    	case '4':
        	var objGuardado=eval(objDatosActual)[0];
            if(objGuardado.objTablaConf.autocompletar=='1')
            {
                var idHidden=contenidos[0][1];
                var nControl=idHidden.getAttribute('extId');
                
                var nombreControl=nControl.replace('ext_','');
                
                var almacen=new Ext.data.SimpleStore	(
                                                            {
                                                                fields:	[
                                                                            {name:'id'},
                                                                            {name:'nombre'},
                                                                            {name:'valorComp'}
                                                                            
                                                                        ]
                                                            }
                                                        )
                almacen.loadData([]);                                                    
                var comboTmp=document.createElement('select');
                var combo =new Ext.form.ComboBox	(
                                                            {
                                                                
                                                                id:'ext_'+nombreControl,
                                                                width:300,
                                                                store:almacen,
                                                                mode:'local',
                                                                transform:comboTmp,
                                                                editable:false,
                                                                typeAhead: true,
                                                                triggerAction: 'all',
                                                                lazyRender:true,
                                                                displayField:'nombre',
                                                                valueField:'id',
                                                                renderTo:'t_'+nombreControl
                                                            }
                                                        )
                                                        
                                                        
            }
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
        break;
    	case '8':
        	crearCampoFecha(param1,param2,param3,param4);
        break;
        case '10':
       		crearTextoEnriquecido(param1,param2,param3,param4) ;     
            setTimeout('inicializarTextoE()',1000);
        break;
        case '16':
        case '19':
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
        break;
        case '21':
        	crearCampoHora(param1,param2,param3,param4,parseInt(param5));     
        break;
        case '22':
        	/*
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
            */
        break;
        case '29':
        	crearCampoGridFormulario('grid_'+contenidos[3],'spanGrid_'+contenidos[3],contenidos[11],contenidos[12],contenidos[10],contenidos[9],'ME',true);
        break;
    }
    
   	seleccionarControl('div_'+contenidos[3]);
   	objControl='';
   	p.ctrlDestino=null;
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
                         var comboNum=p.gEx('comboNumTab');
                         comboNum.getStore().removeAt(comboNum.getStore().getCount()-1);
                      }
                      divControl.parentNode.removeChild(divControl);
                      p.establecerFuenteVacia();
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
      msgConfirm('Est&aacute; seguro de querer remover este elemento',resp);
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
            opcion.text='Seleccione';
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
            var nOrden=cE('input');
            nOrden.type='hidden';
            nOrden.value='0';
            nOrden.id='ordenOpt'+nomControl;
	        arr[0]=select;
            arr[1]=nOrden;
            arrContenido[0]=arr;
        break;
        case '3': //pregunta cerrada-Opciones intervalo
        	nomControl='_'+nControl+'vch';
            var arrOpc=eval(arrElementosSel);
            var select=document.createElement('select');
            select.setAttribute('val',val);
            select.id=nomControl;
            select.name=nomControl;
            llenarCombo(select,eval(arrElementosSel),true);
            var arr=new Array();
	        arr[0]=select;
            arrContenido[0]=arr;
            
        break;
        case '4': //pregunta cerrada-Opciones tabla
        	nomControl='_'+nControl+'vch';
            var arr=new Array();
            if(objDatos.objTablaConf.autocompletar!='1')
            {
                arrElementosSel=arrElementosSel.replace(',]',']').replace('_@_','|');
                var arrOpc=eval(arrElementosSel);
                var etiquetaOpt;
                var valor;
                var select=document.createElement('select');
                select.setAttribute('val',val);
                select.id=nomControl;
                select.name=nomControl;
                select.setAttribute('idAlmacen',objDatos.objTablaConf.tabla);
                var opcion;
                var ct=0;
                opcion=document.createElement('option');
                opcion.value='-1';
                opcion.text='Seleccione';
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
                
                arr[0]=select;
            }
            else
            {
            	
            	var span=cE('span');	
                span.id='t_'+nomControl;
                span.name='t_'+nomControl;
                var hidden=cE('input');
                hidden.type='hidden';
                hidden.value='';
                hidden.id=nomControl;
                hidden.name=nomControl;
                hidden.setAttribute('val',val);
                hidden.setAttribute('auto','true');
                hidden.setAttribute('ancho','300');
                hidden.setAttribute('extId','ext_'+nomControl);
                hidden.setAttribute('idAlmacen',objDatos.objTablaConf.tabla);
                arr.push(span);
                arr.push(hidden);
            }
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
            input.setAttribute('maxWord','0');
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
            lita.value='';
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
            lita.value='';
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
            input.setAttribute('fechaMin',objDatos.confCampo.fechaMin);
            input.setAttribute('fechaMax',objDatos.confCampo.fechaMax);
            input.setAttribute('diasSel',bE(objDatos.confCampo.diasSel));
            var arr=new Array();
            arr[0]=span;
            arr[1]=input;
        	arrContenido[0]=arr;
			param1='sp'+nomControl;
            param2=nomControl;                            
            param3=null;
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
            textArea.setAttribute('maxlength','0');
            textArea.setAttribute('maxWord','0');
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
            boton.value='Seleccione archivo ...';
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
            arrElementosSel=arrElementosSel.replace(',]',']').replace('_@_','|');
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
            if(tipoElemento=='16')
	            input.setAttribute('idAlmacen',objDatos.objTablaConf.tabla);
            
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
            
            if(tipoElemento=='14')
            {
                var nOrden=cE('input');
                nOrden.type='hidden';
                nOrden.value='0';
                nOrden.id='ordenOpt'+nomControl;
                arr[8]=nOrden;
            }
            arrContenido[0]=arr;
        break;
        case '17':
        case '18':
        case '19':
        	var nomControl='_'+nControl+'arr';
            arrElementosSel=arrElementosSel.replace(',]',']').replace('_@_','|');
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
            if(tipoElemento=='19')
	            input8.setAttribute('idAlmacen',objDatos.objTablaConf.tabla);
            
            arr[0]=span;
            arr[1]=input2;
            arr[2]=input3;        
            arr[3]=input5;
            arr[4]=input4;
            arr[5]=input5;
            arr[6]=input6;
            arr[7]=input7;
            arr[8]=input8;
            
            if(tipoElemento=='17')
            {
            	
                var nOrden=cE('input');
                nOrden.type='hidden';
                nOrden.value='0';
                nOrden.id='ordenOpt'+nomControl;
                arr[9]=nOrden;
            }
            arrContenido[0]=arr;
        
        break;
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
            label.innerHTML='0.00';
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
            
            var lita=document.createElement('input');
            lita.type='hidden';
            lita.value='';
            lita.id='lita_'+nomControl;
            
            var arr=new Array();
            arr[0]=label;
            arr[1]=sp_expresion;
            arr[2]=sp_numD;
            arr[3]=sp_sepMiles;
            arr[4]=sp_sepDec;
            arr[5]=sp_tratoDec;
            arr[6]=sp;
            arr[7]=lita;
            
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
        
        case '25': //Campo fecha/hora (Solo lectura)
        	nomControl='_'+nControl+'vch';
        	var confCampo=objDatos.confCampo;
            var input=document.createElement('input');
            input.type='text';
            input.id=nomControl;
            input.name=nomControl;
            input.readOnly=true;
            input.size=confCampo.ancho;
            input.setAttribute('class','');
            input.setAttribute('val',val);
            input.setAttribute('confCampo',bE(convertirCadenaJson(objDatos.confCampo)));
            input.setAttribute('funcRenderer','');
            input.value=confCampo.formato;
            var arr=new Array();
            arr[0]=input;
        	arrContenido[0]=arr;
        break;
        
        case '30':
        	nomControl='_'+objDatos.nomCampo+'vch';
        	var x;
            var pregunta=document.createElement('div');
            pregunta.id=nomControl;
            pregunta.name=nomControl;
            pregunta.setAttribute('idAlmacen',objDatos.almacen);
            pregunta.setAttribute('class','letraFicha');
            var arrDatosCampo=objDatos.campo.split('_');
            
            var nCampo;
            nCampo=objDatos.campoEtUsuario;
            pregunta.appendChild(document.createTextNode('['+dv(nCampo)+']'));
            var arr=new Array();
            arr[0]=pregunta;
        	arrContenido[0]=arr;  
           
        break;
        case '31':
        	nomControl='_'+nControl+'vch';
        	var confCampo=objDatos.confCampo;
            var label=document.createElement('span');
            label.setAttribute('class','letraFicha');
            label.id=nomControl;
            label.setAttribute('parametro',confCampo.parametro);
            label.innerHTML='<span>['+confCampo.parametro+']</span>';
            
            var arr=new Array();
            arr[0]=label;
        	arrContenido[0]=arr;
        break;
        case '33':
        	nomControl='_'+nControl+'img';
            var imagen=document.createElement('img');
            var confCampo=objDatos.confCampo;
            imagen.src='../images/imgNoDisponible.jpg';
            imagen.id=nomControl;
			imagen.width=confCampo.ancho;
            imagen.height=confCampo.alto;
            var arr=new Array();
            arr[0]=imagen;
        	arrContenido[0]=arr; 
      	break; 
    }
    
    var arrEliminar=document.createElement('div');
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
