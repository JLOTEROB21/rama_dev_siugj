<?php session_start();
	include("configurarIdiomaJS.php");
	$consulta="SELECT idFuncion,nombreFuncionJS FROM 9033_funcionesScriptsSistema WHERE idCategoria=1";
	$arrFuncionesRenderer=$con->obtenerFilasArreglo($consulta);
	
?>
var arrFuncionesRenderer=<?php echo $arrFuncionesRenderer?>;
Ext.onReady(inicializar);
var posDivX;
var posDivY;
function inicializar()
{
	var x;
    posDivX=obtenerPosX('tblGrid');
	posDivY=obtenerPosY('tblGrid');

    for(x=0;x<calibrarCtrl.length;x++)
    {
    	calibrarPosicion(calibrarCtrl[x]);
    }
    ejecutarFuncionesInicio();
}

function asignarValorFormatoRenderer(idRenderer,tControl,nombreControl,idCtrl)
{
	var funcRenderer=rendererNulo;
    var posFunc=existeValorMatriz(arrFuncionesRenderer,idRenderer);
    if(posFunc!=-1)
    {
        eval('funcRenderer='+arrFuncionesRenderer[posFunc][1]+';');
        
    }
	switch(tControl)	
    {
    	case -1:

        	var arrElementos=gEN(nombreControl);
            var ct;
            for(ct=0;ct<arrElementos.length;ct++)
            {
            	
            	arrElementos[ct].innerHTML=funcRenderer(arrElementos[ct].innerHTML);
            }
        break;
    	case 0:
        	gE(nombreControl).innerHTML=funcRenderer(gE(nombreControl).innerHTML);
        break;
    	case 2:
        case 3:
        case 4:
        	var combo=gE(nombreControl);
            var ct;
            for(ct=0;ct<combo.options.length;ct++)
            {
            	var et=combo.options[ct].text;
                
                if(et!='Elija una opción')
                {
                	combo.options[ct].text=funcRenderer(combo.options[ct].text);
                }
            }
        break;
        case 14:
        case 15:
        case 16:
        case 17:
        case 18:
        case 19:
        	var arrElementos=gEN('et'+nombreControl);
            var ct;
            for(ct=0;ct<arrElementos.length;ct++)
            {
	            arrElementos[ct].innerHTML=funcRenderer(arrElementos[ct].innerHTML);
            }
            
        break;
    	case 30:
        	
        	gE('sp_'+idCtrl).innerHTML=funcRenderer(gE('sp_'+idCtrl).innerHTML);
        break;
    }
}