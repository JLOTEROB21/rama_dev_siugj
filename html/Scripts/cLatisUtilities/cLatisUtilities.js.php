<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var appName='Latis Utilities';

class cLatisUtilities
{
	_connected;
    _ipServer;
    _port;
    _wsImplLatis ;
    _wsLatis;
    _funcOnOpen;
    _funcOnMessage;
    _funcOnError;
	constructor(dirIP,puerto,funcOnMessage,funcOnError,funcOnOpen) 
    {
    	this._connected=false;
        this._ipServer=dirIP;
        this._port=puerto;
        this._wsImplLatis = window.WebSocket || window.MozWebSocket;
        this._wsLatis = new this._wsImplLatis('ws://'+this._ipServer+':'+this._port+'/');
        this._funcOnOpen=funcOnOpen;
        this._funcOnMessage=funcOnMessage;
        this._funcOnError=funcOnError;
        
        this._wsLatis.onerror = function(e)
                              	{
                                 	ocultarMensajeProcesando();
                                  	this._connected=false;
                                  	if(this._funcOnError)
                                      	this._funcOnError(e);	
                          		}
      	this._wsLatis.onmessage = function(e)
                                  {
                                     
                                      var cObj=eval('['+e.data+']')[0];
                                      if(this._funcOnMessage)
	                                      this._funcOnMessage(cObj);
        
                                     
                                      
                                  }
      	this._wsLatis.onopen = function(e)
                              {
									
                                  this._connected=true;
                                  if(this._funcOnOpen)
                                      this._funcOnOpen(e);
                              } 
    }
    
    isConected()
	{
        return this._wsLatis.readyState==1;
    }
     
    
    reconect(msg)
    {
        mostrarMensajeProcesando('Intentando reconectar con '+appName);
        cLatis=new cLatisUtilities(this._ipServer,this._port,his._funcOnMessage,this._funcOnError,function()
                                                                                                    {
                                                                                                        this.sendMessage(msg);
                                                                                                    }
									);
	}
    
    
    sendMessage(cDispositivo,msg,parametros)
    {
    	var objMsg='{"cDispositivo":"'+cDispositivo+'","comando":"'+msg+'"';
        var x;
        for(x=0;x<8;x++)
        {
        	objMsg+=',"data'+(x+1)+'":"'+(parametros[x]?cv(parametros[x]):'')+'"';
        }
        
        
        
        
        
        objMsg+='}';
    
    
        if(this.isConected())
            this._wsLatis.send(objMsg);
        else
        {
        
            function resp(btn)
            {
                if(btn=='yes')
                    this.reconect(objMsg);
            }
            msgConfirm('¿Se ha perdido la conexi&oacute;n con la aplicacion '+appName+', desea intentar reconectar?',resp);
        
            
        }
    }

	
    
	
}







/*

 

function getScanList()
{

    var tareaActiva=setInterval(function()
                                { 
                                    
                                    if( _connectedScan)
                                    {
                                        clearInterval(tareaActiva); 
                                        sendMessageScan('{"message":"listScanners","data1":"","data2":"","data3":""}');
                                        
                                        
                                        
                                    }
                                   
                                 }, 500);
}



function getCapabilities(dispositivo)
{

   if( _connectedScan)
    {
        sendMessageScan('{"message":"getCapabilities","data1":"'+dispositivo+'","data2":"","data3":""}');
    }
}


function setCapabilitie(capacidad,valor,dispositivo)
{
	if( _connectedScan)
    {
        sendMessageScan('{"message":"'+capacidad+'","data1":"'+valor+'","data2":"'+dispositivo+'"}');
    }

}


function startScanning(dispositivo)
{
	if( _connectedScan)
    {
        sendMessageScan('{"message":"startCapture","data1":"'+dispositivo+'"}');
    }
}*/