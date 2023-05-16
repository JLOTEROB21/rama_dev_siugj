 <?php
require_once '../stimulsoft/helper.php';
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<title>Stimulsoft Reports.PHP - Viewer</title>
	<style>html, body { font-family: sans-serif; }</style>

	<!-- Office2013 White-Teal style -->
	<link href="../css/stimulsoft.viewer.office2013.whiteblue.css" rel="stylesheet">

	<!-- Stimulsoft Reports.JS -->
	<script src="../scripts/stimulsoft.reports.src.js" type="text/javascript"></script>
	
	<!-- Stimulsoft Dashboards.JS -->
	<!-- <script src="../scripts/stimulsoft.dashboards.js" type="text/javascript"></script>  -->
	
	<!-- Stimulsoft JS Viewer -->
	<script src="../scripts/stimulsoft.viewer.src.js" type="text/javascript"></script>
	
	<?php
		// Add JavaScript helpers and init options to work with the PHP server
		// You can change the handler file and timeout if required
		StiHelper::init('handler_viewer.php', 30);
	?>
	

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
Stimulsoft.Base.StiLicense.key = "6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHmgkBxjU0/UmAjZbab0bLsWj2KKQ1f2h2zVQgROa923/J9aga" + 
"lcVnGg+nc1D5EeJo2HbKA2gEtCNP1pehPSy8G2ctYYmeZGyYMb+h5TJxkcjMmZxSMvsnptsiE5D9l1poNO8vJpc58v" + 
"Pf9NBDcAxhmdWUAgFU3vGPYO/WhpOzoBpdplAgurmxCeB5gXDlFZla/9iPOlHgfLKNzGZ+aVv1OkSeuzGqPjNVUvBL" + 
"oSuCqhEnKqWr7MHmtHoVAqjda2vsrUEnCpKidQPanTeWodnY96ask+VehI4xI/GPFvD5UeaCdm2sW550Ex9x2NumT/" + 
"ZGY7Dsdg4XuapPzxJ9vrAqdmib5S9FmeW+DZnHwkhKi/3SccdPhbhOWw/CntjnlDWzGz9jqiy7rxe6kLhxgrQP37rm" + 
"yLWmMRoYTRk/j6Nh0j1jtvf4VSQTo97uB3l7GUk2IjDpWOtkQD4jQh6m7bccdK8+kYCIIRZ2Wi1Hr2Jfqohy1D/WBh" + 
"xWOtFroLhG+SJ100PwjepP7KtKmB+J+KPoVz";

var options = new Stimulsoft.Viewer.StiViewerOptions();
		options.toolbar.showSendEmailButton = true;
		options.toolbar.displayMode = Stimulsoft.Viewer.StiToolbarDisplayMode.Separated;
		options.appearance.fullScreenMode = true;
		options.appearance.scrollbarsMode = true;		
		options.height = "600px"; // Height for non-fullscreen mode



		
		
	StiOptions.WebServer.encryptData = false;
    Stimulsoft.Base.Localization.StiLocalization.setLocalizationFile("../localization/es.xml");
    function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
            });
        return result;
    }

    // Create Viewer component.
    // A description of the parameters can be found in the documentation at the link:
    // https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_js_web_viewer_showing_reports.htm
    var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);
		// Optional Viewer events for fine tuning. You can uncomment and change any event or all of them, if necessary.
		// In this case, the built-in handler will be overridden by the selected event.
		// You can read and, if necessary, change the parameters in the args before server-side handler.
		
		// All events and their details can be found in the documentation at the link:
		// https://www.stimulsoft.com/en/documentation/online/programming-manual/index.html?reports_js_web_viewer_viewer_events.htm
		
		
		
		/*
		// Process report variables before rendering.
		viewer.onPrepareVariables = function (args, callback) {
			
			// Call the server-side handler
			Stimulsoft.Helper.process(args, callback);
            alert('hola mundo2');
		}
		
		*/
		
				
		// Process SQL data sources. It can be used if it is necessary to correct the parameters of the data request.
		//viewer.onBeginProcessData = function (args, callback) {
			
			// Call the server-side handler
		//	Stimulsoft.Helper.process(args, callback);
            //alert('hola mundo3');
		//}
		
		
		
		/*
		
		// Manage export settings and, if necessary, transfer them to the server and manage there
		viewer.onBeginExportReport = function (args, callback) {
			
			// Call the server-side handler
			Stimulsoft.Helper.process(args, callback);
			
			// Manage export settings
			// args.fileName = "MyReportName";
		}
		
		*/
		
		/*
		
		// Process exported report file on the server side
		viewer.onEndExportReport = function (args) {
			
			// Prevent built-in handler (save the exported report as a file)
			args.preventDefault = true;
			
			// Call the server-side handler
			Stimulsoft.Helper.process(args);
		}
		
		*/
		
		/*
		
		// Send exported report to Email
		viewer.onEmailReport = function (args) {
			
			// Call the server-side handler
			Stimulsoft.Helper.process(args);
		}
		
		*/
		
		// Create a report and load a template from an MRT file:
		var report = new Stimulsoft.Report.StiReport();
		var filtervariables = null;
        reportcontents = '';

	var parametros = JSON.parse('<?=$_POST['parametros']?>');
	
	var data = { command:"getReport", idReporte:parametros.idreporte, database: "latis" };
    //var data = { command:"getReport", idReporte: findGetParameter("idreporte"), database: "latis" };
	
	




data = JSON.stringify(data);

Stimulsoft.Report.Dictionary.StiCustomDatabase.registerCustomDatabase({
		serviceName: "Latis",
		sampleConnectionString: "usuario=root;contrasena=micontrasena;",
		process: myLatisDatasourceDriver

	});


		
report.onBeginProcessData = function (args,callback) {	
	console.log('calling onbeginprocessdata on the server side:');
	console.log(args);
	console.log(callback);
	args.variables=filtervariables;
	args.idReporte=parametros.idreporte;
	Stimulsoft.Helper.process(args, callback);
    

}

viewer.onInteraction = function (args) {
	console.log('oninteracton data:');
	console.log(args);
if (args.action == "Variables") {

var variables = args.variables;

}
}
viewer.onEndExportReport = function (args) { 
			alert('completed');
			window.close();
		}


report.onPrepareVariables = function (args, callback) {
	console.log('calling onpreparevariables on the server side:');
	console.log(args);
	filtervariables = args.variables;
	Stimulsoft.Helper.process(args, callback);

}



function myLatisDatasourceDriver (command, callback) {
	var data = { command:command.command, dataSource:command.dataSource, connectionString: command.connectionString, queryString: command.queryString, database: "latis", timeout: command.timeout }
	data = JSON.stringify(data);
	console.log('Driver data:');
	console.log(command);
	data = encodeURIComponent(data);
	$.ajax({
	method: "POST",
	url: "../latis/handlerlatis.php",
	data: data
	})
	.done(function( response ) {
		console.log("Response from handlerlatis.php:");
		console.log(response);
		callback(response);
     //   document.open();
     //   document.write(response);
     //   document.close();
	});



//if (command.command == "TestConnection") callback({ success: true, notice: "Error" });
//if (command.command == "RetrieveSchema") callback({ success: true, data: demoData, types: demoDataTypes });

//if (command.command == "RetrieveData") callback({ success: true, data: demoData[command.queryString], types: demoDataTypes[command.queryString] });
}



    data = encodeURIComponent(data);
    //alert(data);
    $.ajax({
    method: "POST",
    url: "../stimulsoft/adapters/handler.php",
    data: btoa(data)
    })
    .done(function( response ) {
        //alert("llamada a handler terminada");		
		//console.log(response);
        //alert(response.success);
		objresponse = response;
		//alert(objresponse.success);
		//console.log(atob(objresponse.reportDefinition));
		//console.log(response);
		//report.loadFile("../reports/RegistroDelitos.mrt")
		report.loadPacked(atob(objresponse.reportDefinition));	
		var options = new Stimulsoft.Viewer.StiViewerOptions();
		options.exports.showExportDialog = false;
        viewer.report = report;

		report.renderAsync(function() {
			
			var parametros = JSON.parse('<?=$_POST['parametros']?>');

			
			
			console.log(parametros.destino);
			switch (parametros.destino) {
			case 'PDF':
					report.exportDocumentAsync(function (data) {
					Stimulsoft.System.StiObject.saveAs(data, "Report.pdf", "application/pdf");	
				}, Stimulsoft.Report.StiExportFormat.Pdf);
				break;
			case 'WORD':
				report.exportDocumentAsync(function (data) {
					Stimulsoft.System.StiObject.saveAs(data, "Report.doc", "application/word");	
				}, Stimulsoft.Report.StiExportFormat.Word2007);
				break;
			case 'EXCEL': 
				report.exportDocumentAsync(function (data) {
					Stimulsoft.System.StiObject.saveAs(data, "Report.xlsx", "application/xls");	
				}, Stimulsoft.Report.StiExportFormat.Excel2007);
				break;
			case 'HTML': 
				report.exportDocumentAsync(function (data) {
					Stimulsoft.System.StiObject.saveAs(data, "Report.html", "text/html");	
				}, Stimulsoft.Report.StiExportFormat.Html5);
				break;
			case 'PPT': 
				report.exportDocumentAsync(function (data) {
					Stimulsoft.System.StiObject.saveAs(data, "Report.ppt", "text/powerpoint");	
				}, Stimulsoft.Report.StiExportFormat.Ppt2007);
				break;
			case 'CSV': 
				report.exportDocumentAsync(function (data) {
					Stimulsoft.System.StiObject.saveAs(data, "Report.csv", "application/csv");	
				}, Stimulsoft.Report.StiExportFormat.Csv);
				break;
			case 'TXT': 
				report.exportDocumentAsync(function (data) {
					Stimulsoft.System.StiObject.saveAs(data, "Report.txt", "application/text");	
				}, Stimulsoft.Report.StiExportFormat.Text);
				break;

			case 'SVG': 
				report.exportDocumentAsync(function (data) {
					Stimulsoft.System.StiObject.saveAs(data, "Report.svg", "image/svg");	
				}, Stimulsoft.Report.StiExportFormat.ImageSvg);
				break;
			case 'VIEWER':
				viewer.renderHtml("viewerContent");
				break;
			}

	

			
});
		//console.log(report);
		/*
		var newwindow= window.open('', 'TheWindowCode', 'width=700, height=1200');
		
		content = '<html><TITLE>Codigo fuente del reporte</TITLE><body><pre><code>' + report.saveToJsonString() + ''
       newwindow.document.write(content);
    */
    });
    function onLoad() {		
			
		}



</script>
</head>
<body>
	<div id="viewerContent"></div>
</body>
</html>