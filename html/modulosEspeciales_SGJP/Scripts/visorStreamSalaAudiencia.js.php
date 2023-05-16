<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var player;

$(document).ready(	function() 
	                    {
                        	

						setTimeout(	function()
                        			{ 
                                    	prepararMascarilla();
                                    	if(gE('player'))
                                        {

    										if(gE('url').value.indexOf('rtmp')!=-1)
                                            {

                                                player=flowplayer("player", "../Scripts/flowPlayer/flowplayer-3.2.18.swf",
                                                                                                                                    {
                                                                                                                                        
                                                                                                                                        clip: 		{
                                                                                                                                                        url: gE('url').value,
                                                                                                                                                        provider: 'rtmp'
                                                                                                                                                    },
                                                                                                                                        plugins: 	{
                                                                                                                                                        rtmp: 		{
                                                                                                                                                                        url: '../Scripts/flowPlayer/flowplayer.rtmp-3.2.13.swf',
                                                                                                                                                                        netConnectionUrl: gE('url').value
                                                                                                                                                                    },
                                                                                                                                                        controls: 	{
                                                                                                                                                                        fullscreen:false,
                                                                                                                                                                        autoHide:false,
                                                                                                                                                                        url: "../Scripts/flowPlayer/flowplayer.controls-3.2.16.swf"
                                                                                                                                                                    }
                                                                                                                                                    }
                                                                                                                                    }
                                                                    ); 
											}
                                            else
                                            {
												gE('container').style.height=(obtenerDimensionesNavegador()[0]*0.95)+'px';
												gE('container').style.width=(obtenerDimensionesNavegador()[1]*0.95)+'px';
                                            	player=OvenPlayer.create("player",		
                                                                                    {
                                                                                    	controls:true,
                                                                                        autoStart:true,
                                                                                        mute:false,
                                                                                        expandFullScreenUI:false,
                                                                                        title:'Conectando con la fuente...',
                                                                                        loadingRetryCount:2,
                                                                                        
                                                                                        waterMark: {
                                                                                                        image: 'http://localhost/images/accept.png',
                                                                                                        position: 'top-left',
                                                                                                        y: '100px',
                                                                                                        x: '100px',
                                                                                                        width: '400px',
                                                                                                        height: '300px',
                                                                                                        opacity: 0
                                                                                                    },
                                                                                       	
                                                                                        sources:	[
                                                                                        				{
                                                                                                        	file:gE('url').value
                                                                                                        }
                                                                                        			]
                                                                                    }
                                                                        ) 
                                            }
                                        }	                                                              
                                   	}, 1000);
                    	   
                                            
                                 
                        
                    }
                );	


function inhabilitar()
{
    return false
}


function prepararMascarilla()
{

	document.oncontextmenu=inhabilitar;
	var anchoPantalla=obtenerDimensionesNavegador()[1];
    var altoPantalla=obtenerDimensionesNavegador()[0];
    var anchoDiv=anchoPantalla*0.98;
    var altoDiv=altoPantalla*0.90;
    gE('player').style.left=((anchoPantalla/2) - (anchoDiv/2))+'px';
    gE('player').style.top=((altoPantalla/2) - (altoDiv/2))+'px';
    gE('player').style.width=anchoDiv+'px';
    gE('player').style.height=altoDiv+'px';
    gE('marca').style.left=((anchoPantalla/2) - (anchoDiv/2))+'px';
    gE('marca').style.top=((altoPantalla/2) - (altoDiv/2))+'px';
    gE('marca').style.width=anchoDiv+'px';
    gE('marca').style.height=(altoDiv-30)+'px';
}