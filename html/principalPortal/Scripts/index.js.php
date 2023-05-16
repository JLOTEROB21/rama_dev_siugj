Ext.onReady(inicializar);

function inicializar()
{
	var arrDimensiones=obtenerDimensionesNavegador();
    gE('filaInferior').setAttribute('height',arrDimensiones[0]-390);
    
    
     
}


