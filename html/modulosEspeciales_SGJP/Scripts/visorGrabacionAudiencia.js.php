<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var player;

$(document).ready(	function() 
                    {
                    	if(gE('url').value=='')
                        	return;
						setTimeout(	function()
                        			{ 
                                    	
                                        
                                       
                                        if(gE('useNoFlash').value=='1')
                                        {
                                        	
                                            var video=cE('video');
                                            video.id='player';
                                            video.controls='controls';
                                            video.autoplay='autoplay';
                                            video.controlsList='nodownload';
                                            video.style.height=(obtenerDimensionesNavegador()[0]*0.95)+'px';
											video.style.width=(obtenerDimensionesNavegador()[1]*0.95)+'px';
                                            
                                            var videoInfo=cE('source');
                                            videoInfo.id="mp4";
                                            videoInfo.type='video/mp4';
                                            videoInfo.src=gE('urlNoFlash').value;
                                            video.appendChild(videoInfo);
                                            gE('container').appendChild(video);
                                            
                                        }
                                        else
                                        {
                                            if(gE('rutaEmisor').value.indexOf('rtmp')!=-1)
                                            {
                                            
                                                if(gE('useNoFlash').value=='0')
                                                {
    
                                                    player=flowplayer("player", "../Scripts/flowPlayer/flowplayer-3.2.18.swf",
                                                                                                                                        {
                                                                                                                                            
                                                                                                                                            clip: 		{
                                                                                                                                                            url: gE('archivoVideo').value,
                                                                                                                                                            autoPlay: gE('autoPlay').value=='1',
                                                                                                                                                            provider: 'rtmp'
                                                                                                                                                            
                                                                                                                                                        },
                                                                                                                                           plugins: 	{
                                                                                                                                                            rtmp: 		{
                                                                                                                                                                            url: '../Scripts/flowPlayer/flowplayer.rtmp-3.2.13.swf',
                                                                                                                                                                            netConnectionUrl: gE('rutaEmisor').value
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
                                                    
                                                    gE('video').style.height=(obtenerDimensionesNavegador()[0]*0.90)+'px';
                                                    gE('video').style.width=(obtenerDimensionesNavegador()[1]*0.90)+'px';
    
    
                                                    
                                                    
                                           
                                                }
                                            }
                                            else
                                            {
    
                                                player=flowplayer("player", "../Scripts/flowPlayer/flowplayer-3.2.18.swf",
                                                                                                                                    {
                                                                                                                                        
                                                                                                                                        clip: 		{
                                                                                                                                                        autoPlay: gE('autoPlay').value=='1',
                                                                                                                                                        url: gE('url').value
                                                                                                                                                    },
                                                                                                                                        plugins: 	{
                                                                                                                                                        controls: 	{
                                                                                                                                                                        fullscreen:false,
                                                                                                                                                                        autoHide:false,
                                                                                                                                                                        url: "../Scripts/flowPlayer/flowplayer.controls-3.2.16.swf"
                                                                                                                                                                    }
                                                                                                                                                    }
                                                                                                                                    }
                                                                    ); 
                                            }                
                                        }   
                                        
                                        prepararMascarilla();                                             
                                   	}, 2000);
                    	   
                                            
                              
                        
                    }
                );	



function inhabilitar()
{
    //return false
}


function prepararMascarilla()
{
	
	document.oncontextmenu=inhabilitar;
	var anchoPantalla=obtenerDimensionesNavegador()[1];
    var altoPantalla=obtenerDimensionesNavegador()[0];
    var anchoDiv=anchoPantalla*0.98;
    var altoDiv=altoPantalla*0.98;
    gE('player').style.left=((anchoPantalla/2) - (anchoDiv/2))+'px';
    gE('player').style.top=((altoPantalla/2) - (altoDiv/2))+'px';
    gE('player').style.width=anchoDiv+'px';
    gE('player').style.height=altoDiv+'px';
    gE('marca').style.left=((anchoPantalla/2) - (anchoDiv/2))+'px';
    gE('marca').style.top=((altoPantalla/2) - (altoDiv/2))+'px';
    gE('marca').style.width=anchoDiv+'px';
    gE('marca').style.height=(altoDiv-50)+'px';
}