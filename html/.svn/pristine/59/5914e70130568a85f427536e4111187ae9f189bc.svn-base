<?php


$version = '2022.1.4';

// Error handlers

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


// Data adapters

require_once 'mysql.php';
require_once 'mssql.php';
require_once 'firebird.php';
require_once 'postgresql.php';
require_once 'oracle.php';
require_once 'odbc.php';
require_once '../../latis/latis.php';


// You can configure the security level as you required.
// By default is to allow any requests from any domains.

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Engaged-Auth-Token');
header('Cache-Control: no-cache');
//header("Content-Type: application/json; charset=utf-8");


// Common classes

class StiResult {
	public $success = true;
	public $notice = null;
	public $object = null;
	public $version = '2021.4.3';
	public static function success($notice = null, $object = null) {
		$result = new StiResult();
		$result->success = true;
		$result->notice = $notice;
		$result->object = $object;
		return $result;
	}

	public static function error($notice = null) {
		$result = new StiResult();
		$result->success = false;
		$result->notice = $notice;
		return $result;
	}
}

class StiRequest {
	public $command = null;
	public $idReporte = null;
	public $connectionString = null;
	public $queryString = null;
	public $database = null;
	public $dataSource = null;
	public $connection = null;
	public $timeout = null;
	public $filters = null;
	
	public function parse() {
		$input = file_get_contents('php://input');

		if (strlen($input) > 0 && mb_substr($input, 0, 1) != '{')
			$input = base64_decode(str_rot13($input));
			//echo $input;
			//$input = urldecode(base64_decode($input));
			//echo $input;
		$obj = json_decode($input);
		if ($obj == null) {
			$message = 'Error de Analisis Json #'.json_last_error();
			if (function_exists('json_last_error_msg'))
				$message .= ' ('.json_last_error_msg().')';
			
			return StiResult::error($message);
		}
		
		if (isset($obj->command)) $this->command = $obj->command;
		if ($this->command != 'TestConnection' && $this->command != 'ExecuteQuery' && $this->command != 'getReport')
			return StiResult::error('Comando Desconocido ['.$this->command.']');
		
		if (isset($obj->connectionString)) $this->connectionString = $obj->connectionString;
		if (isset($obj->queryString)) $this->queryString = $obj->queryString;
		if (isset($obj->database)) $this->database = $obj->database;
		if (isset($obj->dataSource)) $this->dataSource = $obj->dataSource;
		if (isset($obj->connection)) $this->connection = $obj->connection;
		if (isset($obj->timeout)) $this->timeout = $obj->timeout;
		if (isset($obj->idReporte)) $this->idReporte = $obj->idReporte;
		if (isset($obj->variables)) $this->filters = $obj->variables;
		
		return StiResult::success(null, $this);
	}
}

class StiResponse {
	public static function json($result, $exit = true) {
		unset($result->object);
		if (defined('JSON_UNESCAPED_SLASHES')) echo json_encode($result, JSON_UNESCAPED_SLASHES);
		else echo json_encode($result);
		if ($exit) exit;
	}
	public static function raw($result, $exit = true) {		
		echo $result;		

		if ($exit) exit;
	}
}


// Data adapters

function getDataAdapter($request) {
	
	switch ($request->database) {
		case 'MySQL': $dataAdapter = new StiMySqlAdapter(); break;
		case 'MS SQL': $dataAdapter = new StiMsSqlAdapter(); break;
		case 'Firebird': $dataAdapter = new StiFirebirdAdapter(); break;
		case 'PostgreSQL': $dataAdapter = new StiPostgreSqlAdapter(); break;
		case 'Oracle': $dataAdapter = new StiOracleAdapter(); break;
		case 'ODBC': $dataAdapter = new StiOdbcAdapter(); break;
		case 'latis': $dataAdapter = new StiLatisAdapter(); break;
	}
	
	if (isset($dataAdapter)) {
		$dataAdapter->parse($request->connectionString);
		return StiResult::success(null, $dataAdapter);
	}
	
	return StiResult::error("Unknown database type [".$request->database."]");
}


// Process request

$request = new StiRequest();
$result = $request->parse();
if ($result->success) {
	$result = getDataAdapter($request);
	$dataAdapter = $result->object;
	if ($result->success) {
		switch($request->command){
			case 'TestConnection':
				$result = $dataAdapter->test();
				break;
			case 'ExecuteQuery':				
				$result = $dataAdapter->execute($request->queryString);
				break;
			case 'getReport':				
				$result->reportDefinition = $dataAdapter->getReport($request->idReporte);				
				break;
			case 'RetrieveData':				
				$result = StiResult::error('Comando Desconocido ['.$this->command.']');				
				break;
			default: 
				$result = StiResult::error('Comando Desconocido ['.$this->command.']');
		}
		
		
		$result->handlerVersion = $version;
		$result->adapterVersion = $dataAdapter->version;
		$result->checkVersion = $dataAdapter->checkVersion;
	}
}

StiResponse::json($result);