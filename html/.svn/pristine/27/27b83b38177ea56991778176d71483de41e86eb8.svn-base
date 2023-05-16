<?php

class StiConnectionInfo {
	public $host = "";
	public $port = "";
	public $database = "";
	public $userId = "";
	public $password = "";
	public $charset = "";
	public $dsn = "";
	public $privilege = "";
	public $dataPath = "";
	public $schemaPath = "";
}

class StiSender {
	const Viewer = "Viewer";
	const Designer = "Designer";
}

class StiDatabaseType {
	const MySQL = "MySQL";
	const MSSQL = "MS SQL";
	const PostgreSQL = "PostgreSQL";
	const Firebird = "Firebird";
	const Oracle = "Oracle";
	const ODBC = "ODBC";
	const Latis = "Latis";
}

class StiEventType {
	const PrepareVariables = "PrepareVariables";
	const BeginProcessData = "BeginProcessData";
	const CreateReport = "CreateReport";
	const OpenReport = "OpenReport";
	const SaveReport = "SaveReport";
	const SaveAsReport = "SaveAsReport";
	const PrintReport = "PrintReport";
	const BeginExportReport = "BeginExportReport";
	const EndExportReport = "EndExportReport";
	const EmailReport = "EmailReport";
}

class StiCommand {
	const TestConnection = "TestConnection";
	const ExecuteQuery = "ExecuteQuery";
	const RetrieveData = "RetrieveData";
}

class StiExportFormat {
	const Pdf = 1;
	const Text = 11;
	const Excel2007 = 14;
	const Word2007 = 15;
	const Csv = 17;
	const ImageSvg = 28;
	const Html = 32;
	const Ods = 33;
	const Odt = 34;
	const Ppt2007 = 35;
	const Html5 = 36;
	const Document = 1000;
}

class StiExportAction {
	const ExportReport = 1;
	const SendEmail = 2;
}

class StiRequest {
	public $sender = null;
	public $event = null;
	public $command = null;
	public $connectionString = null;
	public $queryString = null;
	public $database = null;
	public $dataSource = null;
	public $connection = null;
	public $timeout = null;
	public $idReporte = null;
	public $filters = null;
	public $variables= null;
	
	

	
	public function parse() {
		$input = file_get_contents('php://input');
		
		
		//$input = base64_decode($input);
		$input=urldecode($input);
        $message = "Occurio un error al procesar la cadena de connexion [".$input."]:".json_last_error();
		$obj = json_decode($input);
		
		if ($obj == null) {
			$message = "Occurio un error al procesar la cadena de connexion [".$input."]:".json_last_error();
			if (function_exists('json_last_error_msg'))
				$message .= ' ('.json_last_error_msg().')';
			
			return StiResult::error($message);
		}
		
		$parameterNames = array(
			'sender', 'event', 'command', 'connectionString', 'queryString', 'database', 'dataSource', 'connection',
			'timeout', 'data', 'fileName', 'action', 'printAction', 'format', 'formatName', 'settings', 'variables',
			'parameters', 'escapeQueryParameters', 'isWizardUsed','idReporte','parametrosReporte'
		);
		
		foreach ($parameterNames as $name) {
			if (isset($obj->{$name})) $this->{$name} = $obj->{$name};
		}

		if (isset($obj->command)) $this->command = $obj->command;
		//if ($this->command != 'TestConnection' && $this->command != 'ExecuteQuery' && $this->command != 'RetrieveSchema'&& $this->command != 'RetrieveData')
			//return StiResult::error('Comando Desconocido ['.$this->command.']');
		
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
		echo defined('JSON_UNESCAPED_SLASHES') ? json_encode($result, JSON_UNESCAPED_SLASHES) : json_encode($result);
		if ($exit) exit;
	}
}

class StiResult {
	public $success = true;
	public $notice = null;
	public $object = null;

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

class StiEmailSettings {
	// Email address of the sender
	public $from = null;

	// Name and surname of the sender
	public $name = null;

	// Email address of the recipient
	public $to = null;

	// Email Subject
	public $subject = null;

	// Text of the Email
	public $message = null;

	// Attached file name
	public $attachmentName = null;

	// Charset for the message
	public $charset = "UTF-8";

	// Address of the SMTP server
	public $host = null;

	// Port of the SMTP server
	public $port = 465;

	// The secure connection prefix - ssl or tls
	public $secure = "ssl";

	// Login (Username or Email) */
	public $login = null;

	// Password
	public $password = null;
	
	// The array of 'cc' addresses.
	public $cc = array();
	
	// The array of 'bcc' addresses.
	public $bcc = array();
}
