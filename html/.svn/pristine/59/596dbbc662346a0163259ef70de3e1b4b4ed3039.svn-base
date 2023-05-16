Ext.onReady(inicializar);

var oMicrofono=null;

function inicializar()
{

}


function comenzarGrabacion()
{
	if(!oMicrofono)
		oMicrofono=new cMicrofonoReconocimiento({funcionTraslated:afterTraslated});
        
        
	if(gE('btnStart').value=='Comenzar')
    {
    	gE('btnStart').value='Finalizar';
        oMicrofono.startRecord();
    }
    else
    {
    	gE('btnStart').value='Comenzar';
        oMicrofono.finishRecord();
    }        
    
}


function afterTraslated(resultado)
{
	gE('txtResultado').innerHTML=bD(resultado.resultado);
    comenzarGrabacion();
}