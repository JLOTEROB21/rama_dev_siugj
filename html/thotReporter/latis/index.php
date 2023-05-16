<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Form</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<body id="main_body" >

	<TITLE> Add/Remove dynamic rows in HTML table </TITLE>
	<SCRIPT language="javascript">
		function addRow(tableID) {

			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var colCount = table.rows[0].cells.length;

			for(var i=0; i<colCount; i++) {

				var newcell	= row.insertCell(i);

				newcell.innerHTML = table.rows[0].cells[i].innerHTML;
				//alert(newcell.childNodes);
				switch(newcell.childNodes[0].type) {
					case "text":
							newcell.childNodes[0].value = "";
							break;
					case "checkbox":
							newcell.childNodes[0].checked = false;
							break;
					case "select-one":
							newcell.childNodes[0].selectedIndex = 0;
							break;
				}
			}
		}

		function deleteRow(tableID) {
			try {
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;

			for(var i=0; i<rowCount; i++) {
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				if(null != chkbox && true == chkbox.checked) {
					if(rowCount <= 1) {
						alert("Debe existir al menos una condicion.");
						break;
					}
					table.deleteRow(i);
					rowCount--;
					i--;
				}


			}
			}catch(e) {
				alert(e);
			}
		}
        function showFilters(tableID){
           
            const chk = document.getElementById('chkconditions');
            if (chk.checked){
                document.getElementById(tableID).style.visibility="visible";
                document.getElementById('btnAgregarCondicion').style.visibility="visible";
                document.getElementById('btnEliminarCondicion').style.visibility="visible";
            }
            else   {
                document.getElementById(tableID).style.visibility="hidden";
                document.getElementById('btnAgregarCondicion').style.visibility="hidden";
                document.getElementById('btnEliminarCondicion').style.visibility="hidden";
            }
        }

        


    function getReportList(){
     var data = { command:"getReportList", database: "latis"}
     //alert(JSON.stringify(data));
     $.ajax({
        method: "POST",
        url: "../latis/handlerlatis.php",
        data: JSON.stringify(data)
        })
        .done(function( response ) {
            //alert("llamada a handler terminada");		
            //console.log(response);
            //alert(response.success);            
            console.log(response);		
            selectobj = document.getElementById('reportList')
            for(var report in response.reportes)
            {
                console.log(response.reportes[report].nombrereporte);
                var opt = document.createElement('option');
                opt.value = response.reportes[report].idregistro;
                opt.innerHTML = response.reportes[report].nombrereporte;
                selectobj.appendChild(opt);
            }
        });

    }
    function showreport(){
        var f = document.getElementById('TheForm');
        var deffiltros = {filtro1:"dddd", filtro2:"yyyyy"}
        var parametros = {idreporte:document.getElementById('reportList').value, filtros:deffiltros, destino: document.getElementById('destino').value}
        f.parametros.value = JSON.stringify(parametros);      
        //alert (f.parametros.value)  ;
        window.open('', 'TheWindow');
        f.submit();
    }
	</SCRIPT>
</HEAD>
<BODY onload="getReportList();">
<form id="TheForm" method="post" action="../latis/showReport.php" target="TheWindow">
<input type="hidden" name="parametros" value="{}" />
</form>



<TABLE id="optionstable" width="350px" border="0">
<TR>			
        <TD>Reporte:
            <SELECT name="reportlist" id="reportList">
				
            </SELECT>
        </TD>
</TR>
<TR>			
        <TD>Agregar condiciones al reporte: <INPUT type="checkbox" name="chkconditions" id="chkconditions" onclick="showFilters('conditionstable')"/></TD>
</TR>
<TR>			
        <TD>Enviar a:
            <SELECT name="destino" id="destino">
                <OPTION value="VIEWER">Visor de reportes</OPTION>
                <OPTION value="PDF">Adobe PDF</OPTION>
                <OPTION value="WORD">Microsoft Word</OPTION>
                <OPTION value="EXCEL">Microsoft Excel</OPTION>					
                <OPTION value="PPT">Powerpoint</OPTION>					
                <OPTION value="HTML">HTML</OPTION>
                <OPTION value="CSV">Texto delimitado (csv)</OPTION>
                <OPTION value="TXT">Texto simple (txt)</OPTION>
                <OPTION value="SVG">Imagen SVG</OPTION>
                <OPTION value="EMBEDREPORT">Reporte con datos incrustados</OPTION>
            </SELECT>
        </TD>
</TR>
<TR>
        <TD>
        <INPUT type="button" id="btnAgregarCondicion" value="Agregar Condicion" style="visibility:hidden" onclick="addRow('conditionstable')" />
        <INPUT type="button" id="btnEliminarCondicion" value="Eliminar condicion seleccionada" style="visibility:hidden" onclick="deleteRow('conditionstable')" />
</TR>
<TR>
        <TD>
        <INPUT type="button" id="lanzar" value="Mostrar reporte" onclick="showreport()" />        
</TR>
</TABLE>
<BR>
<BR><BR><BR><BR>
<TABLE id="conditionstable" width="350px" border="1" style="visibility:hidden">
    <TR>
        <TD><INPUT type="checkbox" name="chk"/></TD>
        <TD>
            <SELECT name="country">
                <OPTION value="FIELD1">FIELD1</OPTION>
                <OPTION value="FIELD2">FIELD2</OPTION>
                <OPTION value="FIELD3">FIELD3</OPTION>					
            </SELECT>
        </TD>
        <TD>
            <SELECT name="country">
                <OPTION value="EQUAL">es igual a</OPTION>
                <OPTION value="CONTAINS">contiene</OPTION>
                <OPTION value="MORETHAN">mayor que</OPTION>
                <OPTION value="LESSTHAN">menor que</OPTION>
                <OPTION value="NOTEQUAL">diferente de</OPTION>
            </SELECT>
        </TD>
        <TD><INPUT type="text" name="value"/></TD>
    </TR>
</TABLE>

</BODY>
</HTML>