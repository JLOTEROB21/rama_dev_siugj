var intervalo;
function doApplet()	
{
	intervalo=setInterval(establecerDocumentoFirma,1000);

}

function getAppletVars()	
{
	var	iderror	=	getAppletError(); 
	if(iderror>0)	
    {

		var	txterror=getAppletTxtError(); 
		alert(txterror); 
	}
	else	
    {
		var	sf=getAppletFirma();
								
		document.getElementById("txtResultado").value	=	sf;		
	}
}            


function establecerDocumentoFirma()
{

	var	f	=document.getElementById("documentoFirma").value;
    try	
    {
    	if((document.firma)&&((document.firma.setVars)))
        {
        	setAppletSource(f); 
	        setAppletCert("0"); 
            setAppletVars(US_REMOTE_FILE,US_NO_OCSP);         	
        }
    	//clearInterval(intervalo);
        
        
    }                        
    catch(e)	
    {
    	console.log(e);
   	 	return false;
    }
    
}