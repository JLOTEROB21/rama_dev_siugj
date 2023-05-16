
var diasMes=30;

function convertirLeyendaComputo(arrValores)
{
	var leyenda='';
    arrValores=normalizarValoresComputo(arrValores);
    
    if((arrValores[0]==0)&&(arrValores[1]==0)&&(arrValores[2]==0))
    {
    	return '0 a&ntilde;os, 0 meses, 0 dias';
    }
    
    
    if(arrValores[0]>0)
    {
    	leyenda+=arrValores[0]+(arrValores[0]==1?' a&ntilde;o':' a&ntilde;os');
    }
    
    if(arrValores[1]>0)
    {
    	if(leyenda=='')
    		leyenda+=arrValores[1]+(arrValores[1]==1?' mes':' meses');
        else
        	leyenda+=', '+arrValores[1]+(arrValores[1]==1?' mes':' meses');
    }
    
    if(arrValores[2]>0)
    {
    	if(leyenda=='')
    		leyenda+=arrValores[2]+(arrValores[2]==1?' dia':' dias');
        else
        	leyenda+=', '+arrValores[2]+(arrValores[2]==1?' dia':' dias');
    }
    
    return leyenda;
    
}

function sumarComputo(arrValores1,arrValores2)
{
	arrValores1=normalizarValoresComputo(arrValores1);
    arrValores2=normalizarValoresComputo(arrValores2);
    
	var arrValoresResultado=[];
    arrValoresResultado[0]=0;
    arrValoresResultado[1]=0;
    arrValoresResultado[2]=0;
    
    arrValoresResultado[2]=arrValores1[2]+arrValores2[2];
    if(arrValoresResultado[2]>diasMes)
    {
    	var meses=parseInt(arrValoresResultado[2]/diasMes);
        arrValoresResultado[2]-=(meses*diasMes);
        arrValoresResultado[1]=meses;
    }
    
    arrValoresResultado[1]+=arrValores1[1]+arrValores2[1];
    if(arrValoresResultado[1]>12)
    {
    	var anios=parseInt(arrValoresResultado[1]/12);
        arrValoresResultado[1]-=(anios*12);
        arrValoresResultado[0]=anios;
    }
    
    arrValoresResultado[0]+=arrValores1[0]+arrValores2[0];
    
    return arrValoresResultado;
}

function restarComputo(arrValores1,arrValores2)
{
	arrValores1=normalizarValoresComputo(arrValores1);
    arrValores2=normalizarValoresComputo(arrValores2);
    
	var arrValoresResultado=[];
    arrValoresResultado[0]=0;
    arrValoresResultado[1]=0;
    arrValoresResultado[2]=0;
    
    var arrValoresAux1=[];
    arrValoresAux1[0]=(arrValores1[0]*12)+arrValores1[1];
    arrValoresAux1[1]=arrValores1[2];
    
    var arrValoresAux2=[];
    arrValoresAux2[0]=(arrValores2[0]*12)+arrValores2[1];
    arrValoresAux2[1]=arrValores2[2];
    
    var arrValoresResultadoAux=[];
    arrValoresResultadoAux[0]=0;
    arrValoresResultadoAux[1]=0;
    if(arrValoresAux1[1]<arrValoresAux2[1])
    {
    	var diferencia=arrValoresAux2[1]-arrValoresAux1[1];
      	var nMeses=parseInt(diferencia/diasMes);
        if((diferencia%diasMes)>0)
        	nMeses++;
        
        if(arrValoresAux1[0]>nMeses)
        {
        	arrValoresAux1[0]-=nMeses;
            arrValoresAux1[1]+=(nMeses*diasMes);
        }
        
        else
        {
        	arrValoresResultado[0]=0;
            arrValoresResultado[1]=0;
            arrValoresResultado[2]=0;            
        	return arrValoresResultado;
        }
    }
    
    arrValoresResultadoAux[1]=arrValoresAux1[1]-arrValoresAux2[1];
    arrValoresResultadoAux[0]=arrValoresAux1[0]-arrValoresAux2[0];
    if(arrValoresResultadoAux[0]<0)
    {
    	arrValoresResultado[0]=0;
        arrValoresResultado[1]=0;
        arrValoresResultado[2]=0; 
    }
    else
    {
    	arrValoresResultado[0]=parseInt(arrValoresResultadoAux[0]/12);
        arrValoresResultado[1]=arrValoresResultadoAux[0]-(arrValoresResultado[0]*12);
        arrValoresResultado[2]=arrValoresResultadoAux[1];
    }
    return arrValoresResultado;
}

function normalizarValoresComputo(arrValores)
{
	arrValores[0]=(arrValores[0]=='')?0:parseInt(arrValores[0]);
    arrValores[1]=(arrValores[1]=='')?0:parseInt(arrValores[1]);
    arrValores[2]=(arrValores[2]=='')?0:parseInt(arrValores[2]);
    return arrValores;
}

function convertirDiasArrComputo(dias)
{
	var meses=parseInt(dias/diasMes);
	dias-=(meses*diasMes);
	var anios=(meses/12);
	meses-=(anios*12);
	
	var arrComputo=[];
	arrComputo[0]=anios;
	arrComputo[1]=meses;
	arrComputo[2]=dias;
	
	return arrComputo;
	
}
