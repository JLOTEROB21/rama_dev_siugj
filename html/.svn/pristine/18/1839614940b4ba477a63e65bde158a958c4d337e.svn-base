<?php include("conexionBD.php");
	$idZona=0;
	if(isset($_GET["iZ"]))
		$idZona=$_GET["iZ"];
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="../principal/estilos/contacto.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>

<script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
<script type="text/javascript" src="../principal/Scripts/contacto.js.php"></script>
</head>

<body>
<table width="95%">
	<tr>
    	<td align="right">
			<img src="../principal/images/logoNeotrai.gif" width="200" />
		</td>
    </tr>
    
</table>
<div class="wrapper">		
		<form id="frmEnvio" class="blocks" >
			<p>
				<label>Nombre: <span style="color:#F00">*</span></label>
				<input type="text" class="text" id="nombre" name="name" val="obl" campo="Nombre"/>
			</p>
			<p>
				<label>Empresa: <span style="color:#F00">*</span></label>
				<input type="text" class="text" id="empresa" name="company" val="obl" campo="Empresa"/>
			</p>
			<p>
				<label>E-mail: <span style="color:#F00">*</span></label>
				<input type="text" class="text"id="mail" name="email" val="obl" campo="E-mail"/>
			</p>
			<p>
				<label>Telefono:</label>
				<input type="text" class="text" id="telefono" name="phone" />
			</p>
			<p class="area">
				<label>Comentario:</label>
				<textarea class="textarea" name="message" id="comentarios"></textarea>
			</p>
			<p>
				<label>&nbsp;</label>
				<input type="button" class="btn" value="- Enviar Mensaje -" onclick='enviarMensajeContacto()' />
			</p>
            <input type="hidden" id="idZona" value='<?php echo $idZona?>' />
		</form>
	</div>
	
</body>
</html>
