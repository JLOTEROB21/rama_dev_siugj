<?php session_start();
include("conexionBD.php");
?>
<body>
<!-- TemplateBeginEditable name="EditRegion2" -->
<?php $raiz="..";?>
<!-- TemplateEndEditable -->
<tr>
	<td>
    <table width="100" height="100" align="center">
    	<tr>
        	<td align="center" valign="down">Procesando...
          <?php   
		  if(isset($raiz))
            {
              $raiz="..";
            }
			?>
            <img src="<?php echo $raiz ?>/images/loader.gif" />
          </td>
      </tr>       
      </table>
  </td>
</tr>
<!-- TemplateBeginEditable name="Datosguarda" -->
<?php




?>
<!-- TemplateEndEditable -->
</body>

