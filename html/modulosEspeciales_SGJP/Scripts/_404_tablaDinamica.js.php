<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	
	$consulta="SELECT nombreCorto,totalPuntos FROM _000_catalogoSeccionesCuestionariosEvaluacion WHERE idCuestionario=".$idFormulario." ORDER BY orden";
	$res=$con->obtenerFilas($consulta);
	
?>


var arrSecciones=[];
var arrSeccion1=[];
var arrSeccion2=[];
var arrSeccion3=[];
var arrSeccion4=[];
var arrSeccion5=[];
var arrSeccion6=[];
var arrSeccion7=[];
var arrSeccion8=[];
/*var cadenaFuncionValidacion='';*/

function inyeccionCodigo()
{	
	

    arrSeccion1.push('p1');
    arrSeccion1.push('p2');
    arrSeccion1.push('p3A1');
    arrSeccion1.push('p3A2');
    arrSeccion1.push('p3B1');
    arrSeccion1.push('p3B2');
    arrSeccion1.push('p3C1');
    arrSeccion1.push('p3C2');
    arrSeccion1.push('p3D1');
    arrSeccion1.push('p3D2');
    arrSeccion1.push('p4');
    arrSeccion1.push('p5');
    arrSeccion1.push('p6');
    arrSeccion1.push('p7');
    arrSeccion1.push('p8');
    arrSeccion1.push('p9');
    arrSeccion1.push('p10');
    arrSeccion1.push('p11');
    arrSeccion1.push('p12');
    

    arrSeccion2.push('p13');
    arrSeccion2.push('p14A');
    arrSeccion2.push('p14B');
    arrSeccion2.push('p15');
    arrSeccion2.push('p16A');
    arrSeccion2.push('p16B');
    arrSeccion2.push('p16C');
    arrSeccion2.push('p17');
    

    arrSeccion3.push('p18');
    arrSeccion3.push('p19');
    arrSeccion3.push('p20');
    arrSeccion3.push('p21');
    arrSeccion3.push('p22');
    

    arrSeccion4.push('p23');
    arrSeccion4.push('p24');
    arrSeccion4.push('p25');
    arrSeccion4.push('p26');
    arrSeccion4.push('p27');
    arrSeccion4.push('p28A');
    arrSeccion4.push('p28B');
    arrSeccion4.push('p28C');
    arrSeccion4.push('p29');
    arrSeccion4.push('p30A');
    arrSeccion4.push('p30B');
    arrSeccion4.push('p30C');
    arrSeccion4.push('p31');
    arrSeccion4.push('p32');
    arrSeccion4.push('p33');
    arrSeccion4.push('p34');
    arrSeccion4.push('p35');
    arrSeccion4.push('p36');
    arrSeccion4.push('p37');
    arrSeccion4.push('p38');
    

    arrSeccion5.push('p39');
    arrSeccion5.push('p40');
    arrSeccion5.push('p41');
    arrSeccion5.push('p42');
    arrSeccion5.push('p43A');
    arrSeccion5.push('p43B');
    arrSeccion5.push('p43C');
    arrSeccion5.push('p44');
    arrSeccion5.push('p45');
    arrSeccion5.push('p46A');
    arrSeccion5.push('p46B');
    arrSeccion5.push('p46C');
    arrSeccion5.push('p47');
    arrSeccion5.push('p48');
    arrSeccion5.push('p49');
    

    arrSeccion6.push('p51');
    arrSeccion6.push('p52');
    arrSeccion6.push('p53');
    arrSeccion6.push('p54A');
    arrSeccion6.push('p54B');
    arrSeccion6.push('p54C');
    

    arrSeccion7.push('p55');
    arrSeccion7.push('p56');
    

    arrSeccion8.push('p57');
    arrSeccion8.push('p58');
    arrSeccion8.push('p59');
    arrSeccion8.push('p60');
    arrSeccion8.push('p61');
    arrSeccion8.push('p62');
    arrSeccion8.push('p63');
    
    <?php
	$nSeccion=1;
	while($fila=mysql_fetch_row($res))
	{
		echo "arrSecciones.push(['".cv($fila[0])."',".$fila[1].",arrSeccion".$nSeccion.",0]); ";
		$nSeccion++;
	}
	?>
	

	if(esRegistroFormulario())
    {
    	calcularValorTotal();
            
            
	}
    else
    {
    	gE('_[total]vch').innerHTML='<span id="sp_8534">'+Ext.util.Format.number(gEN('_totalvch')[0].value,'0.00')+ ' %</span>';
    }
    
    inicializarSecciones();
    
       

}

function inicializarSecciones()
{
	
            	
	var x;
    var arrPreguntas;
    var p;
    var nControl;
    var aPregunta;
    for(x=1;x<=arrSecciones.length;x++)
    {
    	eval('arrPreguntas=arrSeccion'+x+';');
       	for(p=0;p<arrPreguntas.length;p++)
       	{
       		aPregunta=gE('_'+arrPreguntas[p]+'vch');
           	asignarEvento(aPregunta,'change',calcularEvaluacion)
       	}
    }
}

function calcularEvaluacion(ctrl)
{
	setTimeout(function()
    			{
                	var valor=ctrl.value;
                    var nPregunta=ctrl.id.substring(1);
                    nPregunta=nPregunta.substring(0,nPregunta.length-3);
                    var seccion=localizarSeccion(nPregunta);
                    
                    calcularValorSeccion(seccion);
                    
                    calcularValorTotal();
                },100
    			)
	
    
    
    
	
}

function localizarSeccion(nPregunta)
{
	var x;
    var aSeccion;
    var p;
    for(x=0;x<arrSecciones.length;x++)
    {
    	aSeccion=arrSecciones[x];
        for(p=0;p<aSeccion[2].length;p++)
        {
        	if(aSeccion[2][p]==nPregunta)
            	return [x,aSeccion];
        }
        
    }
}

function calcularValorSeccion(seccion)
{
	var x;
    var nPregunta;
    var preguntaCapital
    var existeFuncion;
    var valor;
    seccion[1][3]=0;
    for(x=0;x<seccion[1][2].length;x++)
    {
    	nPregunta=seccion[1][2][x];
        preguntaCapital=nPregunta.substring(0,1).toUpperCase()+nPregunta.substring(1);
        eval('existeFuncion=typeof(suma'+preguntaCapital+');');
        valor=gE('_'+nPregunta+'vch').value;
        if(valor=='')
        	valor=0;
        else
        {    
            if(existeFuncion!='undefined')
            {
            
                eval('valor=suma'+preguntaCapital+'('+valor+')');
            }
            else
	            valor=parseFloat(valor);

        }
         seccion[1][3]+=valor;
        
    }
	
    gEN('_seccion'+seccion[0]+'vch')[0].value=seccion[1][3];
    
    gEN('_seccion'+seccion[0]+'Pvch')[0].value=(seccion[1][3]/seccion[1][1])*100;
    
    gE('_seccion'+seccion[0]+'vch').innerHTML=seccion[1][3];
    
    gE('_seccion'+seccion[0]+'Pvch').innerHTML=(seccion[1][3]/seccion[1][1])*100;
    
}

function calcularValorTotal()
{
	var x;
    var arrPreguntas;
    var totalPreguntas=0;
    var totalPuntosConseguidos=0;

    for(x=0;x<arrSecciones.length;x++)
    {
    	arrPreguntas=arrSecciones[x];   

        totalPreguntas+=arrPreguntas[1];

    
        totalPuntosConseguidos+=parseInt(gEN('_seccion'+x+'vch')[0].value=='N/E'?0:gEN('_seccion'+x+'vch')[0].value);
        
    }
    
    var total=(totalPuntosConseguidos/totalPreguntas) *100;
    
    
    gEN('_totalvch')[0].value=total;
    
    gEN('_totalPvch')[0].value=totalPuntosConseguidos;
    
    gE('_totalvch').innerHTML=Ext.util.Format.number(total,'0.00')+ ' %';
    
    gE('_totalPvch').innerHTML=totalPuntosConseguidos;
    
    gEN('_totalMaximoPtsvch')[0].value=totalPreguntas;
    gE('_totalMaximoPtsvch').innerHTML=totalPreguntas;
    
}

function sumaP1(val)
{
	if(val==2)
    	val=2;
     return val;
}

function sumaP3A1(val)
{
	if(val==1)
    	val=0.125;
     return val;
}

function sumaP3A2(val)
{
	if(val==1)
    	val=0.125;
     return val;
}

function sumaP3B1(val)
{
	if(val==1)
    	val=0.125;
     return val;
}

function sumaP3B2(val)
{
	if(val==1)
    	val=0.125;
     return val;
}

function sumaP3C1(val)
{
	if(val==1)
    	val=0.125;
     return val;
}

function sumaP3C2(val)
{
	if(val==1)
    	val=0.125;
     return val;
}

function sumaP3D1(val)
{
	if(val==1)
    	val=0.125;
     return val;
}

function sumaP3D2(val)
{
	if(val==1)
    	val=0.125;
     return val;
}

function sumaP5(val)
{
	if(val==2)
    	val=1;
     return val;
}

function sumaP6(val)
{
	if(val==2)
    	val=1;
     return val;
}

function sumaP8(val)
{
	if(val==2)
    	val=1;
     return val;
}

function sumaP9(val)
{
	if(val==1)
    	val=1.5;
     return val;
}

function sumaP10(val)
{
	if(val==2)
    	val=1;
     return val;
}

function sumaP12(val)
{
	if(val==2)
    	val=1;
     return val;
}

function sumaP11(val)
{
	if(val==1)
    	val=1.5;
     return val;
}

function sumaP14A(val)
{
	if(val==1)
    	val=2.5;
     return val;
}

function sumaP14B(val)
{
	if(val==1)
    	val=2.5;
     return val;
}

function sumaP15(val)
{
	if(val==1)
    	val=5;
     else
     	val=8;
     return val;
}

function sumaP17(val)
{
	if(val==1)
    	val=2;
     return val;
}

function sumaP18(val)
{
	if(val==1)
    	val=2;
     return val;
}

function sumaP19(val)
{
	if(val==1)
    	val=2;
     return val;
}

function sumaP20(val)
{
	if(val==1)
    	val=2;
     return val;
}

function sumaP21(val)
{
	if(val==1)
    	val=2;
     return val;
}

function sumaP22(val)
{
	if(val==1)
    	val=2;
     return val;
}

function sumaP23(val)
{
	if(val==1)
    	val=0.5;
     return val;
}

function sumaP24(val)
{
	if(val==1)
    	val=0.5;
     return val;
}

function sumaP25(val)
{
	if(val==1)
    	val=0.5;
     return val;
}

function sumaP26(val)
{
	if(val==1)
    	val=0;
	 return val;
}

function sumaP27(val)
{
	if(val==1)
    	val=0.5;
	else
    	val=3.5;
     return val;
}

function sumaP29(val)
{
	if(val==1)
    	val=4;
    else
    	val=1;
	return val;
}

function sumaP30(val)
{
	if(val==1)
    	val=3;
	return val;
}

function sumaP31(val)
{
	var valor=0;
	switch(val)
    {
    	case 2:
        	valor=0.5;
        break;
        case 3:
        	valor=1;
        break;
        case 4:
        	valor=1.5;
        break;
        case 5:
        	valor=2;
        break;
    }
    
    return valor;
}

function sumaP32(val)
{
	var valor=0;
	switch(val)
    {
    	case 2:
        	valor=0.5;
        break;
        case 3:
        	valor=1;
        break;
        case 4:
        	valor=1.5;
        break;
        case 5:
        	valor=2;
        break;
    }
    
    return valor;
}

function sumaP33(val)
{
	var valor=0;
	switch(val)
    {
    	case 2:
        	valor=0.5;
        break;
        case 3:
        	valor=1;
        break;
        case 4:
        	valor=1.5;
        break;
        case 5:
        	valor=2;
        break;
    }
    
    return valor;
}

function sumaP39(val)
{
	var valor=0;
	switch(val)
    {
    	case 2:
        	valor=0.5;
        break;
        case 3:
        	valor=1;
        break;
        case 4:
        	valor=1.5;
        break;
        case 5:
        	valor=2;
        break;
    }
    
    return valor;
}

function sumaP40(val)
{
	var valor=0;
	switch(val)
    {
    	case 2:
        	valor=0.5;
        break;
        case 3:
        	valor=1;
        break;
        case 4:
        	valor=1.5;
        break;
        case 5:
        	valor=2;
        break;
    }
    
    return valor;
}

function sumaP41(val)
{
	var valor=0;
	switch(val)
    {
    	case 2:
        	valor=0.5;
        break;
        case 3:
        	valor=1;
        break;
        case 4:
        	valor=1.5;
        break;
        case 5:
        	valor=2;
        break;
    }
    
    return valor;
}

function sumaP45(val)
{
	var valor=1;
	if(val==0)
    {
    	valor=4;
    }
    return valor;
    return valor;
}

function sumaP47(val)
{
	var valor=1;
    if(val=='0')
    	valor=2;
    return valor;
   
}

function sumaP48(val)
{
	var valor=0;
	switch(val)
    {
    	case 2:
        	valor=0.25;
        break;
        case 3:
        	valor=5;
        break;
        case 4:
        	valor=.75;
        break;
        case 5:
        	valor=1;
        break;
    }
    
    return valor;
}

function sumaP49(val)
{
	return 0;
}

function sumaP51(val)
{
	var valor=0;
	switch(val)
    {
    	case 2:
        	valor=0.125;
        break;
        case 3:
        	valor=.25;
        break;
        case 4:
        	valor=.375;
        break;
        case 5:
        	valor=1;
        break;
    }
    
    return valor;
}

function sumaP53(val)
{
	var valor=1;
	if(val==0)
    {
    	valor=4;
    }
    return valor;
   
}

function sumaP55(val)
{
	if(val==1)
    	val=2;
     return val;
}

function sumaP57(val)
{
	
	if(val==1)
    	val=2;
     return val;
}

function sumaP61(val)
{
	var valor=0;
	switch(val)
    {
    	case 2:
        	valor=0.5;
        break;
        case 3:
        	valor=1;
        break;
        case 4:
        	valor=1.5;
        break;
        case 5:
        	valor=2;
        break;
    }
    
    return valor;
}

function TSJDF_Titulo_Renderer(objeto,pdf,margenDerecho,tamanoFuente,margenIzquierdo,objHoja)
{
	
	var arrLineas;
    var arrLineasAux;
    var nWordWrap;
    var palabras;
    var pos;
    var ajusteHojaPosY=0;
    
    var tFuente=tamanoFuente;
    
    tFuente=parseFloat(window.getComputedStyle(gE(objeto.id)).getPropertyValue('font-size').replace('px',''))*relacionEscala;
    console.log(relacionEscala+'--'+tFuente);
    pdf.setFontSize(tFuente);
    
  
    
	objeto.texto=objeto.texto.replace(/<br \/>/gi, '\n').replace(/<br>/gi, '\n')
    arrLineas=objeto.texto.split('\n');
    arrLineasAux=[];
    
    for(pos=0;pos<arrLineas.length;pos++)
    {
    	
        nWordWrap= dividirCadena(pdf,arrLineas[pos],objHoja.posXFinal-margenIzquierdo-margenDerecho-objeto.posX,objeto);
        for(palabras=0;palabras<nWordWrap.length;palabras++)
        {
            arrLineasAux.push(nWordWrap[palabras]);
        }
    }
    
    for(pos=0;pos<arrLineasAux.length;pos++)
    {
        pdf.fromHTML('<div style="font-size: '+tFuente+'pt"><b>'+arrLineasAux[pos].toUpperCase()+'</b></div>',objeto.posX,objeto.posY+(pos*tFuente*tamanoInterlineado));
    }
    
    
    if(arrLineasAux.length>1)
    {
        ajusteHojaPosY=((arrLineasAux.length-1)*tFuente)*tamanoInterlineado;
        
    }
    
    objeto.ajusteHojaPosY=ajusteHojaPosY;
    return objeto;

}

function lineaDivisoria_Renderer(objeto,pdf,margenDerecho,tamanoFuente,margenIzquierdo,objHoja)
{
	
    objeto.ajusteHojaPosY=0;
    return objeto;
}