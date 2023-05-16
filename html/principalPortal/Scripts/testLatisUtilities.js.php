<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	var c=new cLatisUtilities('127.0.0.1','1984',onMessage,onError,onOpen);
    inicializarComando(c);
    
}


function inicializarComando(c)
{
	var tareaActiva=setInterval(function()
                                { 
                                    
                                    if( c.isConected())
                                    {
                                        clearInterval(tareaActiva); 
                                        c.sendMessage('BIOMETRICO','getDispositivos',[]);
                                        
                                        
                                        
                                    }
                                   
                                 }, 500);
}


function onOpen(e)
{
	
}

function onError(e)
{
	console.log(e);
}

function onMessage(e)
{
	console.log(e);	
}