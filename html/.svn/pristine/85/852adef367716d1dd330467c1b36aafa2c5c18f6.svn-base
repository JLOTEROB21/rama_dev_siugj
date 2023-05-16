<?php
include("conexionBD.php");

$urlDoc=$_GET["urlDoc"];
$nombreArchivo=$_GET["nombreArchivo"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style>
	html > body {
				  font-family: sans-serif;
				  overflow: hidden;
				}
				
	#titlebar	
	{
		  position: absolute;
		  z-index: 2;
		  top: 0px;
		  left: 0px;
		  height: 32px;
		  width: 100%;
		  overflow: hidden;
		  -webkit-box-shadow: 0px 1px 3px rgba(50, 50, 50, 0.75);
		  -moz-box-shadow: 0px 1px 3px rgba(50, 50, 50, 0.75);
		  box-shadow: 0px 1px 3px rgba(50, 50, 50, 0.75);
		  background-image: url(images/texture.png), linear-gradient(rgba(69, 69, 69, .95), rgba(82, 82, 82, .99));
		  background-image: url(images/texture.png), -webkit-linear-gradient(rgba(69, 69, 69, .95), rgba(82, 82, 82, .99));
		  background-image: url(images/texture.png), -moz-linear-gradient(rgba(69, 69, 69, .95), rgba(82, 82, 82, .99));
		  background-image: url(images/texture.png), -ms-linear-gradient(rgba(69, 69, 69, .95), rgba(82, 82, 82, .99));
		  background-image: url(images/texture.png), -o-linear-gradient(rgba(69, 69, 69, .95), rgba(82, 82, 82, .99));
	}
	
	#toolbarContainer 
	{
	  position: absolute;
	  z-index: 2;
	  bottom: 0px;
	  left: 0px;
	  height: 32px;
	  width: 100%;
	  overflow: hidden;
	  -webkit-box-shadow: 0px -1px 3px rgba(50, 50, 50, 0.75);
	  -moz-box-shadow: 0px -1px 3px rgba(50, 50, 50, 0.75);
	  box-shadow: 0px -1px 3px rgba(50, 50, 50, 0.75);
	  background-image: url(images/texture.png), linear-gradient(rgba(82, 82, 82, .99), rgba(69, 69, 69, .95));
	  background-image: url(images/texture.png), -webkit-linear-gradient(rgba(82, 82, 82, .99), rgba(69, 69, 69, .95));
	  background-image: url(images/texture.png), -moz-linear-gradient(rgba(82, 82, 82, .99), rgba(69, 69, 69, .95));
	  background-image: url(images/texture.png), -ms-linear-gradient(rgba(82, 82, 82, .99), rgba(69, 69, 69, .95));
	  background-image: url(images/texture.png), -o-linear-gradient(rgba(82, 82, 82, .99), rgba(69, 69, 69, .95));
	}
	
	
	#canvasContainer
	{
		overflow: auto;
		padding-top: 6px;
		padding-bottom: 6px;
		position: absolute;
		top: 32px;
		right: 0;
		bottom: 32px;
		left: 0;
		text-align: center;
		background-color: #888;
		background-image: url(images/texture.png);
	}
	
	
	
	#toolbarMiddleContainer
	{
		display: block;
		float: right;
		font-family: sans-serif;
		height: 33px;
		margin-bottom: 0px;
		margin-left: 0px;
		margin-right: 0px;
		margin-top: 0px;
		padding-bottom: 0px;
		padding-left: 0px;
		padding-right: 0px;
		padding-top: 0px;
		position: relative;
		right: 620.5px;
		visibility: visible;
		width: 193px;
		
		
	}
	
	
</style>
</head>

<body>
		<div id="viewer">
            <div id="titlebar">
                <div id="documentName" style="display:none"></div>
                <div id="titlebarRight">
                   
                </div>
           </div>
            <div id="toolbarContainer">
                <div id="toolbar">
                    <div id="toolbarLeft">
                        
                    </div>
                    <div id="toolbarMiddleContainer" class="outerCenter">
                        
                    </div>
                    <div id="toolbarRight">
                   </div>
                </div>
            </div>
            <div id="canvasContainer" style="text-align:center; vertical-align:central">
            	<video style="width:95%; height:95%;" src="<?php echo $urlDoc."&nombreArchivo=".$nombreArchivo?>" autoplay controls id="player">
                  El navegador no soporta el elemento <code>audio</code> de html5.
               </video>

            </div>
        </div>
        
        <script>
			document.getElementById('player').play();
		</script>
</body>
</html>