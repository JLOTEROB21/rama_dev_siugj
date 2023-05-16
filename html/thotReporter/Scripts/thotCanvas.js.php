
var ctx;
var lienzo;
var dibujarLinea=false;
var posXInicio=null;
var posYInicio=null;
var posXFin=null;
var posYFin=null;
var capaActual=null;



function inicializarCanvas()
{
	var canvas=gE('canvas');
    ctx=canvas.getContext('2d');
    lienzo=new cLienzo	(
    							{
                                	contenedor:'canvas2',
                                    ancho:800,
                                    alto:1200
                                }
    						);
                            
                            
	                          
                            
}

function dibujarLineaHorizontal(y)
{
	ctx.strokeStyle='#FF0000';
    var posX=0;
    var ancho=3;
    y-=0.5;
    ctx.lineWidth=1;
    ctx.beginPath();
    ctx.moveTo(posX,y);
    ctx.lineTo(ctx.canvas.width,y);
    ctx.closePath();
    ctx.stroke();    
}

function dibujarLineaVertical(x)
{
	ctx.strokeStyle='#0000FF';
    var posY=0;
    var ancho=3;
    var y;
	x-=0.5;
    ctx.lineWidth=1;
    ctx.beginPath();
    ctx.moveTo(x,posY);
    ctx.lineTo(x,ctx.canvas.height);
    ctx.closePath();
    ctx.stroke();
    ctx.strokeStyle='#000000';
}

function limpiarContexto()
{
 	ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
}