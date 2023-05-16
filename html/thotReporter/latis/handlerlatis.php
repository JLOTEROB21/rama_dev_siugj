
<?php
require_once '../stimulsoft/classes.php';

// Error handlers
/*
function stiErrorHandler($errNo, $errStr, $errFile, $errLine) {
	$result = StiResult::error("[$errNo] $errStr ($errFile, Line $errLine)");
	StiResponse::json($result);
}

function stiShutdownFunction() {
	$err = error_get_last();
	if ($err != null && (($err['type'] & E_COMPILE_ERROR) || ($err['type'] & E_ERROR) || ($err['type'] & E_CORE_ERROR) || ($err['type'] & E_RECOVERABLE_ERROR))) {
		$result = StiResult::error("[{$err['type']}] {$err['message']} ({$err['file']}, Line {$err['line']})");
		StiResponse::json($result);
	}
}

set_error_handler('stiErrorHandler');
register_shutdown_function('stiShutdownFunction');
error_reporting(0);
*/

// Data adapters

require_once 'latis.php';




// You can configure the security level as you required.
// By default is to allow any requests from any domains.

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Engaged-Auth-Token');
header('Cache-Control: no-cache');
header("Content-Type: application/json; charset=utf-8");



// Data adapters

function getDataAdapter($request) {
	switch ($request->database) {
		case 'Latis': $dataAdapter = new StiLatisAdapter(); break;
		default: $dataAdapter = new StiLatisAdapter(); break;
	}
	
	if (isset($dataAdapter)) {
		$dataAdapter->parse($request->connectionString);
		return StiResult::success(null, $dataAdapter);
	}
	
	return StiResult::error("Tipo de base de datos desconocido [".$request->database."]");
}


// Process request

$request = new StiRequest();


$result = $request->parse();

if ($result->success) {
	$result = getDataAdapter($request);
	if ($result->success) {
		switch ($request->command) {
			case 'TestConnection':
				$result = $result->object->test();
				break;
			case 'RetrieveSchema':		
				if ($request->database == "Latis")
					$result = $result->object->retrieveSchema();
				else
					$result = $result->object->execute($request->queryString);
					
				break;
			case 'getReportList':
				$result = $result->object->getreportList();
				break;
			case 'getReport':
				if (isset($request->idReporte))
					$result = $result->object->getReport($request->idReporte);
				else
					$result = StiResult::error("Debe indicar el identificador del reporte. (idReporte)");
				break;	
			case 'getReportInformation':
				if (isset($request->idReporte))
					$result = $result->object->getreportInformation($request->idReporte);
				else
					$result = StiResult::error("Debe indicar el identificador del reporte. (idReporte)");
				break;	
			case 'generateReport':
				if (isset($request->idReporte))
					if (isset($request->parametrosReporte))
						$result = $result->object->generateReport($request->idReporte, $request->parametrosReporte);
					else 
						$result = StiResult::error("Debe indicar los parametros del reporte. (parametrosReporte)");
				else
					$result = StiResult::error("Debe indicar el identificador del reporte. (idReporte)");
				break;
			case 'RetrieveData':
				//StiResult::error("Comando desconocido[".$request->command."] [".$request->queryString."]");
				$result = $result->object->execute($request->queryString);
				break;
			default:
				$result = StiResult::error("Comando desconocido[".$request->command."] [".$request->queryString."]");
				break;		
		}	
	}
	else {
		$result = StiResult::error("Ocurrio un error mientras se conectaba a la base de datos");
	}
}
else {
	$result = StiResult::error("Ocurrio un error mientras se configuraba la conexion [".json_encode($request)."]");
}
if (isset($result)){
	StiResponse::json($result);
}

