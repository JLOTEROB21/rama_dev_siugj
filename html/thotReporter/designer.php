<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Generador de reportes</title>

	<!-- Office2013 style -->
	<link href="css/stimulsoft.viewer.office2013.whiteblue.css" rel="stylesheet">
	<link href="css/stimulsoft.designer.office2013.whiteblue.css" rel="stylesheet">

	<!-- Stimulsoft Reports.JS -->
	<script src="Scripts/stimulsoft.reports.src.js" type="text/javascript"></script>

	<!-- Stimulsoft JS Viewer (for preview tab) and Stimulsoft JS Designer-->
	<script src="Scripts/stimulsoft.viewer.src.js" type="text/javascript"></script>
	<script src="Scripts/stimulsoft.designer.src.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript">
		Stimulsoft.StiOptions.WebServer.url = "./stimulsoft/adapters/handler.php";
		Stimulsoft.Base.Localization.StiLocalization.addLocalizationFile("localization/es.xml",false,"es");      
		Stimulsoft.Base.Localization.StiLocalization.cultureName="es";
        StiOptions.WebServer.checkDataAdaptersVersion = false;
        Stimulsoft.Base.StiLicense.Key = "6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHl7YlQBeEnYDc5zgyMRBT2NfOYid4K+cpwCXvSq5vXaVXK2ra5wkZEwq97DlScdEqe2t00bpvTedPJcDg8Yq6HWUDWTetSmZZWH81Xel+kbCIBzNuQlugivW+UI+Jhr0Upywvhk2A8YT5s8+tWCF5rmJwrrKMGmB1f1jiGH8AmhJaBnEtFwALyejjzMChWxRl2xE6jX1p8DsMHoIZ9xdbL+lk1T8nvHsorTBwk3zKprBiqYcVDbuBSaqpNThyEZyiVS0sAxNzSfC3cgEQsxB504+nGx0OM9DDMCbtad8rFL2iftbyuyp/k98KF5B+PUvHLCZwi6gVmTLy+qvNEH4yDnC3/Udc6QdYJZKGSlF685vdvvnB9tNeg5em/agGN4M9HDXRsdpQ79qQaX2a4CbJ2XLMdkYnNtWMDJGUs/gqfkfLowmE7cIN5JYvwT2DGZZSuUhZNa8mYYEROyKfQiXVK7M8npr//dkVkuPwEGvY1+0ZcvKcgaBC2B9VqFce9m1bbYYojRoYsabw9gjg7wVjTP";
		var options = new Stimulsoft.Designer.StiDesignerOptions();
        

		options.appearance.fullScreenMode = true;
        options.appearance.showDialogsHelp = false;
        options.appearance.showLocalization = false;
		options.toolbar.showSendEmailButton = true;
        options.toolbar.showFileMenuAbout = false;
        options.toolbar.showFileMenuHelp = false;
        options.toolbar.showTooltipsHelp = false;
        
        
		var designer = new Stimulsoft.Designer.StiDesigner(options, "StiDesigner", false);
        
        //designer.viewer.options.appearance.showTooltipsHelp = false;
        //designer.viewer.viewerOptions = new Stimulsoft.Viewer.StiViewerOptions();
        //designer.viewer.viewerOptions.appearance.showTooltipsHelp = false;
        console.log(designer);
        
	//	Stimulsoft.Report.Dictionary.StiCustomDatabase.registerCustomDatabase({
        //    serviceName: "Latis",
        //    sampleConnectionString: "usuario=root;contrasena=micontrasena;",
        //    process: myLatisDatasourceDriver

//		});

		
		
		function str_rot13(str) {
  // eslint-disable-line camelcase
  //  discuss at: https://locutus.io/php/str_rot13/
  // original by: Jonas Raoni Soares Silva (https://www.jsfromhell.com)
  // improved by: Ates Goral (https://magnetiq.com)
  // improved by: Rafał Kukawski (https://blog.kukawski.pl)
  // bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
  //   example 1: str_rot13('Kevin van Zonneveld')
  //   returns 1: 'Xriva ina Mbaariryq'
  //   example 2: str_rot13('Xriva ina Mbaariryq')
  //   returns 2: 'Kevin van Zonneveld'
  //   example 3: str_rot13(33)
  //   returns 3: '33'

  return (str + '').replace(/[a-z]/gi, function (s) {
    return String.fromCharCode(s.charCodeAt(0) + (s.toLowerCase() < 'n' ? 13 : -13));
  });
};

designer.onBeginProcessData = function (event) {
	var data = { command:event.command, connectionString: event.connectionString, queryString: event.queryString, database: event.database, parameters: event.parameters, datasource: event.datasource, database: event.database }
	console.log("obbeginprocessdata");
    console.log(data);
    //data = JSON.stringify(data);	
	//window.alert(data);
    

}

designer.onEndProcessData = function(args) {
     var result = args.result;
     console.log(args);
}

function myLatisDatasourceDriver (command, callback) {
	var data = { command:command.command, connectionString: command.connectionString, queryString: command.queryString, database: "Latis", timeout: command.timeout }
    console.log("mylatisdatasourcedriver");
	console.log(data);
    data = JSON.stringify(data);
	
    
	data = encodeURIComponent(data);
	$.ajax({
	method: "POST",
	url: "latis/handlerlatis.php",
	data: data
	})
	.done(function( response ) {
		callback(response);
        //var newwindow= window.open('', '', 'width=300, height=300');
        //newwindow.document.write(JSON.stringify(response));
        
	});



//if (command.command == "TestConnection") callback({ success: true, notice: "Error" });
//if (command.command == "RetrieveSchema") callback({ success: true, data: demoData, types: demoDataTypes });

//if (command.command == "RetrieveData") callback({ success: true, data: demoData[command.queryString], types: demoDataTypes[command.queryString] });
}

        var demoData = {
            Table1: [{
                Column1: "value1",
                Column2: 1,
                Column3: Stimulsoft.System.Guid.newGuidString()
            }, {
                Column1: "value2",
                Column2: 2,
                Column3: Stimulsoft.System.Guid.newGuidString()
            }, {
                Column1: "value3",
                Column2: 3
            }
            ],
            Table2: [{
                Column1: "value1",
                Column2: 1
            }, {
                Column1: "value2",
                Column2: 2
            }, {
                Column1: "value3",
                Column2: 3
            }
            ]
        };

        var demoDataTypes = {
            Table1: {
                Column1: "string",
                Column2: "number",
                Column3: "Stimulsoft.System.Guid"
            },
            Table2: {
                Column1: "string",
                Column2: "Stimulsoft.System.Int32"
            }
        }

		// Load and design report
		var report = new Stimulsoft.Report.StiReport();
		report.loadFile("reports/NuevoReporte.mrt");
		designer.report = report;

		function onLoad() {
            //designer._options.viewerOptions.appearance.showTooltips = false;
            designer._options.viewerOptions.appearance.showTooltipsHelp = false;
            designer.renderHtml("designerContent");
            //designer.viewer.viewerOptions = new Stimulsoft.Viewer.StiViewerOptions();
            //designer.._options.viewerOptions = new Stimulsoft.Viewer.StiViewerOptions();
            //designer._options.viewerOptions.appearance.showTooltips = false;
            //designer._options.viewerOptions.appearance.showTooltipsHelp = false;
            ///designer.viewerOptions.appearance.showTooltips = false;
            console.log(designer);
            
           
		}
	</script>
	</head>
<body onload="onLoad();">
	<div id="designerContent"></div>
</body>
</html>
