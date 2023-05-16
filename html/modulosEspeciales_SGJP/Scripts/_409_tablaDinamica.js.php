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
    arrSeccion1.push('p13');
    
    arrSeccion2.push('p14');
    arrSeccion2.push('p15');

    arrSeccion3.push('p16');
    arrSeccion3.push('p17');
    arrSeccion3.push('p18');
    arrSeccion3.push('p19');    
    arrSeccion3.push('p20');
    arrSeccion3.push('p21');
    arrSeccion3.push('p22');
    
    arrSeccion4.push('p23');
    arrSeccion4.push('p24');
    
    arrSeccion5.push('p25');
    arrSeccion5.push('p26');
    
    
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
    	gE('_[total]vch').innerHTML='<span id="sp_8579">'+Ext.util.Format.number(gEN('_totalvch')[0].value,'0.00')+ ' %</span>';
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

function sumaP13(val)
{
	if(val==1)
    	val=3;
     return val;
}


function sumaP14(val)
{
	if(val==1)
    	val=30;
     return val;
}


function sumaP15(val)
{
	if(val==1)
    	val=10;
     return val;
}

function sumaP16(val)
{
	if(val==1)
    	val=1;
  	else
    {
        if(val==0)
        {
            val=4;
        }
    }
 return val;
}


function sumaP21(val)
{
	if(val==2)
    	val=1;
     return val;
}

function sumaP24(val)
{
	if(val==2)
    	val=1;
     return val;
}









































