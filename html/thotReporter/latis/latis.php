<?php
//ini_set('memory_limit', '512M');
class StiLatisAdapter {
	private $info = null;
	private $link = null;
	private $result = null;
	private $querydefinitions = null;
	public $version = '2021.4.3';	
	public $checkVersion = true;
	public $reportDefinition = null;
	
	private function getLastErrorResult() {
		$code = 0;
		$message = 'Desconocido';
		
		if ($this->info->isPdo) {	
			$info = $this->link->errorInfo();
			$code = $info[0];
			if (count($info) >= 3) $message = $info[2];
		}
		else {
			$code = $this->link->errno;
			if ($this->link->error) $message = $this->link->error;
		}
		
		if ($code == 0) return StiResult::error($message);
		return StiResult::error("[$code] $message");
	}
	

	private function prepare($query){
		$statement = str_replace('%%%DATABASESCHEMA%%%',getenv("LATIS_DATABASESCHEMA"),$query);
		return $statement;
	}

	public function retrieveSchema(){
			
		$result = $this->connect();
		if ($result->success) {
	
			$query = $this->link->query($this->prepare($this->querydefinitions["getSchema"]));
			if (!$query)
				return $this->getLastErrorResult();


			if ($query->num_rows > 0) {

			
				$result->types = array();
				$result->columns = array();
				$result->rows = array();
				
				
				//$result->count = $query->field_count;
				$tablename='';				
				if ($query->num_rows > 0) {					
					while ($rowItem = $query->fetch_assoc()) {						
							if ($tablename != $rowItem['nombreFormulario']){
								$tablename = $rowItem['nombreFormulario'];
								$result->types[$rowItem['nombreFormulario']] = array();
								$fields = array();
							}							
							$fieldtype='string';
							$type = strtolower($rowItem['tipoDato'] );
							switch ($type) {
								case 'short':
								case 'int':
								case 'int24':
								case 'long':
								case 'longlong':
								case 'bit':
									$fieldtype = 'int';
									break;
								case 'newdecimal':
								case 'float':
								case 'double':
									$fieldtype ='number';
									break;								
								case 'tiny':
									//if ($length == 1) return 'boolean';
									$fieldtype ='int';
									break;
								case 'string':
								case 'var_string':
									//if ($binary) return 'array';
									$fieldtype = 'string';
									break;
								case 'date':
								case 'datetime':
								case 'timestamp':
								case 'time':
								case 'year':
									$fieldtype = 'datetime';
									break;
								case 'blob':
								case 'geometry':
									$fieldtype = 'array';
									break;
							}											
							$fields[$rowItem['nombreColumna']] = $fieldtype;
							$result->types[$rowItem['nombreFormulario']] = $fields;
					}
				}
			
			}
			$this->disconnect();
		}
		
		return $result;
		
	}
	public function getReport($idreporte){	
		$result = $this->connect();
		if ($result->success) {				
			$query = $this->link->query($this->prepare(str_replace('%%%IDREPORTE%%%',$idreporte,$this->querydefinitions["getReportInformation"])));
			if (!$query)
				return $this->getLastErrorResult();
			if ($query->num_rows > 0) {
				//$result->count = $query->field_count;
				$result->Reportes = array();
				$tablename='';				
				while ($rowItem = $query->fetch_assoc()) {		
					$result =  base64_encode($rowItem["definicionReporte"]);
					return $result;
					
				}
				
			}
			else {
				$result =  StiResult::error("El id de reporte no existe.");
			}
			$this->disconnect();
		}
		return $result;
	}
	public function generateReport($idReporte, $parametrosReporte){	
		
		echo json_encode($parametrosReporte);
		$result = $this->connect();
		return $result;
	}
	public function getReportInformation($idreporte){			

		
		$result = $this->connect();
		if ($result->success) {				
			$query = $this->link->query($this->prepare(str_replace('%%%IDREPORTE%%%',$idreporte,$this->querydefinitions["getReportInformation"])));
			if (!$query)
				return $this->getLastErrorResult();
			if ($query->num_rows > 0) {
				//$result->count = $query->field_count;
				$result->Reportes = array();
				$tablename='';				
				while ($rowItem = $query->fetch_assoc()) {		
					$info = new stdClass();
					$definicionReporte = json_decode($rowItem["definicionReporte"]);
					$columnas = array();
					$fuentesDeDatos= array();
					
					//obtener todos los campos del reporte
					foreach($definicionReporte->Dictionary->DataSources as $datasource) {
						

						foreach($datasource->Columns as $campoReporte){
							$columna = new stdClass();
							$columna->Alias = $campoReporte->Alias;
							//$columna->nombreFisico = $campoReporte->NameInSource;
							$columna->tipo = $campoReporte->Type;
							$columnas[$campoReporte->NameInSource] = $columna;

						}
						$info->columnas = $columnas;
						$fuentesDeDatos[$datasource->Name] = $info;
						$reporte = new stdClass();
						$reporte->idRegistro = $rowItem["idRegistro"];
						$reporte->nombreReporte = $rowItem["nombreReporte"];
						$reporte->fuentesDatos = $fuentesDeDatos;
						$result->Reportes[$rowItem["nombreReporte"]] = $reporte;
						
					}
				}
				
			}
			else {
				$result =  StiResult::error("El id de reporte no existe.");
			}
			$this->disconnect();
		}
		return $result;
	}
	public function getreportlist(){			
		$result = $this->connect();
		if ($result->success) {	
			
			$query = $this->link->query($this->prepare($this->querydefinitions["getReportList"]));
			if (!$query)
				return $this->getLastErrorResult();
			if ($query->num_rows > 0) {
				$result->reportes = array();
				//$result->count = $query->field_count;
				$tablename='';				
				if ($query->num_rows > 0) {					
					while ($rowItem = $query->fetch_assoc()) {						
						$result->reportes[$rowItem["idregistro"]]= array();
						$info = new stdClass();
						$info->idregistro = $rowItem["idregistro"];
						$info->nombrereporte = $rowItem["nombrereporte"];
						$result->reportes[$rowItem["idregistro"]] = $info;
					}
				}
			}
			$this->disconnect();
		}
		return $result;
	}

	private function connect() {
		if ($this->info->isPdo) {
			try {
				$this->link = new PDO($this->info->dsn, $this->info->userId, $this->info->password);
			}
			catch (PDOException $e) {
				$code = $e->getCode();
				$message = $e->getMessage();
				return StiResult::error("[$code] $message");
			}
			
			return StiResult::success();
		}
	
		$this->link = new mysqli($this->info->host, $this->info->userId, $this->info->password, $this->info->database, $this->info->port);
		
		if ($this->link->connect_error)
			return StiResult::error("[{$this->link->connect_errno}] {$this->link->connect_error}");
		
		if (!$this->link->set_charset($this->info->charset))
			return $this->getLastErrorResult();
			
		
		$querystring = str_replace($this->querydefinitions["getUserInformation"],'%%%LOGIN%%%',$this->info->usuario);
		

		$query = $this->link->query($this->prepare($querystring));
		//return StiResult::error("[100] {SELECT * FROM grupolat_bpm.800_usuarios where login = '".$this->info->usuario."' ; }");	
			
		if ($this->link->affected_rows == 0){
				return StiResult::error("[100] {El usuario ".$this->info->usuario." no existe.}");			
		}
		
		return StiResult::success();		
		
	}
	
	private function disconnect() {
		if (!$this->link) return;
		if (!$this->info->isPdo) $this->link->close();
		$this->link = null;
	}
	
	public function parse($connectionString) {
		$connectionString = trim($connectionString);
		
		$filedata = file_get_contents(dirname(__FILE__).'/querydefinitions.json',true);		
		$querydefinitions = json_decode($filedata,true);
		$this->querydefinitions = $querydefinitions;
		$info = new stdClass();
		$info->isPdo = false;
		$info->dsn = '';
		$info->host = getenv("LATIS_DATABASESERVER");
		$info->port = getenv("LATIS_DATABASEPORT");
		$info->database = getenv("LATIS_DATABASESCHEMA");
		$info->userId = getenv("LATIS_DATABASEUSER");
		$info->password = getenv("LATIS_DATABASEPASSWORD");
		$info->charset = getenv("LATIS_DATABASECHARSET");
		$info->usuario = 'root';
		$info->contrasena = 'x';
		$parameters = explode(';', $connectionString);

		//this is hardcoded 
		
		
		foreach ($parameters as $parameter) {
			if (mb_strpos($parameter, '=') < 1) {
				if ($info->isPdo) $info->dsn .= $parameter.';';
				continue;
			}
			
			$pos = mb_strpos($parameter, '=');
			$name = mb_strtolower(trim(mb_substr($parameter, 0, $pos)));
			$value = trim(mb_substr($parameter, $pos + 1));
			
		

			switch ($name)
			{
				case 'server':
				case 'host':
				case 'location':
					$info->host = $value;
					if ($info->isPdo) $info->dsn .= $parameter.';';
					break;
				case 'usuario':
					$info->usuario = $value;
					break;
				case 'contrasena':
					$info->contrasena = $value;
					break;
				case 'port':
					$info->port = $value;
					if ($info->isPdo) $info->dsn .= $parameter.';';
					break;
						
				case 'database':
				case 'data source':
				case 'dbname':
					$info->database = $value;
					if ($info->isPdo) $info->dsn .= $parameter.';';
					break;
						
				case 'uid':
				case 'user':
				case 'username':
				case 'userid':
				case 'user id':
					$info->userId = $value;
					break;
						
				case 'pwd':
				case 'password':
					$info->password = $value;
					break;
						
				case 'charset':
					$info->charset = $value;
					if ($info->isPdo) $info->dsn .= $parameter.';';
					break;
					
				default:
					if ($info->isPdo && mb_strlen($parameter) > 0) $info->dsn .= $parameter.';';
					break;
			}
		}
		
		if (mb_strlen($info->dsn) > 0 && mb_substr($info->dsn, mb_strlen($info->dsn) - 1) == ';')
			$info->dsn = mb_substr($info->dsn, 0, mb_strlen($info->dsn) - 1);
		
		$this->info = $info;
		return StiResult::success();	
	}
	
	private function getStringType($type) {
		switch ($type) {
			case 1:
				return 'tiny';
			
			case 2:
			case 3:
			case 8:
			case 9:
				return 'int';
			
			case 16:
				return 'bit';
			
			case 4:
			case 5:
			case 246:
				return 'decimal';
			
			case 7:
			case 10:
			case 11:
			case 12:
			case 13:
				return 'datetime';
			
			case 252:
			case 253:
				return 'string';
				
			case 254:
			case 255:
				return 'blob';
		}
		
		return 'string';
	}
	
	private function parseType($meta) {
		$type = 'string';
		$binary = false;
		$length = 0;
		
		if ($this->info->isPdo) {
			foreach ($meta['flags'] as $value) {
				if ($value == 'blob')
					$binary = true;
			}
			$type = $meta['native_type'];
			$length = $meta['len'];
		}
		else {
			if ($meta->flags & 128) $binary = true;
			$type = $this->getStringType($meta->type);
			$length = $meta->length;
		}
		
		$type = strtolower($type);
		switch ($type) {
			case 'short':
			case 'int':
			case 'int24':
			case 'long':
			case 'longlong':
			case 'bit':
				return 'int';
				
			case 'newdecimal':
			case 'float':
			case 'double':
				return 'number';
				
			case 'tiny':
				if ($length == 1) return 'boolean';
				return 'int';
			
			case 'string':
			case 'var_string':
				if ($binary) return 'array';
				return 'string';
			
			case 'date':
			case 'datetime':
			case 'timestamp':
			case 'time':
			case 'year':
				return 'datetime';
			
			case 'blob':
			case 'geometry':
				return 'array';
		}
		
		return 'string';
	}
	
	public function test() {
		$result = $this->connect();
		if ($result->success) $this->disconnect();
		return $result;


	}
	
	public  function getTableName($formName){
		$result = $this->connect();
		if ($result->success) {	
			
			$query = $this->link->query($this->prepare($this->querydefinitions["getSchema"]." WHERE NombreFormulario = '".$formName."';"));
			if (!$query)
				return '';//$this->getLastErrorResult();''
			
			if ($query->num_rows > 0) {
				$rowItem = $query->fetch_assoc();
				if ($formName == $rowItem['nombreFormulario'])
					return ''.$rowItem['esquema'].'.'.$rowItem['nombreTabla'];
			}
			
		}	
		return '';	
	}	

	private function getFieldName($variable,$idReporte,$datasource){
		if($datasource == '800_usuarios')
			return 'fechaCreacion';
		else 
			return '';
	}


	public function execute($queryString,$substitute=true,$variables=null,$idReporte=null,$dataSource=null) {
		$starttime = microtime(true);
		$result = $this->connect();
		$endtime = microtime(true);
		$statistics = new stdClass();
		$statistics->connection = $endtime - $starttime;
		$whereclause = null;
		
		if ($result->success) {
			//obtain the column names associated with the report variables.
			if ($variables){
				$whereclause = "";	
				foreach($variables as $variable){
					$statistics->variablename = $variable->name;
					$statistics->idReporte = $idReporte;				
					$fieldname = $this->getFieldName($variable,$idReporte,$dataSource);
					if ($fieldname != ''){ //the parameter applies to this table.
						$whereclause .= ' AND '.$fieldname.'=';
						if ($variable->type == "DateTime")
							$whereclause .= "'".$variable->value."'";
						else
							$whereclause .= $variable->value;
					}
					
				}
			}
			$realQuery = '';
			$starttime = microtime(true);
			if ($substitute)
				$realQuery = $this->getTableName($queryString);
			else
				$realQuery = $queryString;
			$endtime = microtime(true);
			$statistics->getTable = $endtime - $starttime;
			if ($realQuery == ''){
				return StiResult::error("[100] {la tabla ".$queryString." (alias de ".$realQuery.") no existe.}");		
			}
			if ($whereclause)
				$realQuery = "SELECT * FROM ".$realQuery." WHERE 1=1 ".$whereclause;
			else
				$realQuery = 'SELECT * FROM '.$realQuery." LIMIT 1000";

			$query = $this->link->query($realQuery);
			$statistics->parsedquery=$realQuery;
			if (!$query)
				return $this->getLastErrorResult();
			$result->handlerVersion = $this->version;
			$result->adapterVersion = $this->version;
			$result->types = array();
			$result->columns = array();
			$result->rows = array();
			
			
			if ($this->info->isPdo) {
				$result->count = $query->columnCount();
				
				for ($i = 0; $i < $result->count; $i++) {
					$meta = $query->getColumnMeta($i);
					$result->columns[] = $meta['name'];
					$result->types[] = $this->parseType($meta);
				}
				$starttime = microtime(true);
				while ($rowItem = $query->fetch()) {
					$row = array();
					for ($i = 0; $i < $result->count; $i++) {
						$type = count($result->types) >= $i + 1 ? $result->types[$i] : 'string';
						
						if ($type == 'array') $row[] = base64_encode($rowItem[$i]);
						else if ($type == 'datetime') $row[] = gmdate("Y-m-d\TH:i:s.v\Z", strtotime($rowItem[$i]));
						else $row[] = $rowItem[$i];
					}
					$result->rows[] = $row;
				}
				$endtime = microtime(true);
				$statistics->getDataPDO = $endtime - $starttime;
				$statistics->variables = $variables;
			}
			else {
				$result->count = $query->field_count;
				date_default_timezone_set('America/Mexico_City');
				while ($meta = $query->fetch_field()) {
					$result->columns[] = $meta->name;
					$result->types[] = $this->parseType($meta);
				}
				
				if ($query->num_rows > 0) {
					$isColumnsEmpty = count($result->columns) == 0;
					$starttime = microtime(true);
					while ($rowItem = $query->fetch_assoc()) {
						$row = array();
						foreach ($rowItem as $key => $value) {
							if ($isColumnsEmpty && count($result->columns) < count($rowItem)) $result->columns[] = $key;
							$type = count($result->types) >= count($row) + 1 ? $result->types[count($row)] : 'string';
							
							if ($type == 'array') $row[] = base64_encode($value);
							else if ($type == 'datetime') $row[] = gmdate("Y-m-d\TH:i:s.v\Z", strtotime($value));
							else $row[] = $value;
						}
						$result->rows[] = $row;
					}
					$endtime = microtime(true);
					$statistics->getData = $endtime - $starttime;
					$statistics->variables = $variables;
					
				}
			}
			$result->timeStatistics = $statistics;
			$this->disconnect();
		}
		
		return $result;
	}
}