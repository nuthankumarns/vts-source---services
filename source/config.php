<?php

include'mysql.php';
    //YOUR MySQL CONNECTION DETAILS
    class DB_Mysql extends CLS_MYSQL {
    	var $DATABASE;
    	function __construct()
    	{
    		 $this->DATABASE["server"] = "localhost";
 		$this->DATABASE["port"] = "3306";
 		$this->DATABASE["username"] = "nuthan";
 		$this->DATABASE["password"] = "tritone123";
		$this->DATABASE["database"] = "vts";

		parent::CLS_MYSQL($this->DATABASE);
		parent::Connect();
    	}

    	function encode($decode){
		$result = '';
		switch(gettype($decode)){
			case	'array':
					if(!count($decode) || array_keys($decode) === range(0, count($decode) - 1)) {
						$keys = array();
						foreach($decode as $value) {
							if(($value = DB_Mysql::encode($value)) !== '')
								array_push($keys, $value);
						}
						$result = '['.implode(',', $keys).']';
					}
					else
						$result = DB_Mysql::convert($decode);
					break;
			case	'string':
					$replacement = DB_Mysql::__getStaticReplacement();
					$result = '"'.str_replace($replacement['find'], $replacement['replace'], $decode).'"';
					break;
			default:
					if(!is_callable($decode))
						$result = DB_Mysql::convert($decode);
					break;
		}
		return $result;
	}

	function convert($params, $result = null){
		switch(gettype($params)){
			case	'array':
					$tmp = array();
					foreach($params as $key => $value) {
						if(($value = DB_Mysql::encode($value)) !== '')
							array_push($tmp, DB_Mysql::encode(strval($key)).':'.$value);
					};
					$result = '{'.implode(',', $tmp).'}';
					break;
			case	'boolean':
					$result = $params ? 'true' : 'false';
					break;
			case	'double':
			case	'float':
			case	'integer':
					$result = $result !== null ? strftime('%Y-%m-%dT%H:%M:%S', $params) : strval($params);
					break;
			case	'NULL':
					$result = 'null';
					break;
			case	'string':
					$i = create_function('&$e, $p, $l', 'return intval(substr($e, $p, $l));');
					if(preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $params))
						$result = mktime($i($params, 11, 2), $i($params, 14, 2), $i($params, 17, 2), $i($params, 5, 2), $i($params, 9, 2), $i($params, 0, 4));
					break;
			case	'object':
					$tmp = array();
					if(is_object($result)) {
						foreach($params as $key => $value)
							$result->$key = $value;
					} else {
						$result = get_object_vars($params);
						foreach($result as $key => $value) {
							if(($value = DB_Mysql::encode($value)) !== '')
								array_push($tmp, DB_Mysql::encode($key).':'.$value);
						};
						$result = '{'.implode(',', $tmp).'}';
					}
					break;
		}
		return $result;
	}

		function __getStaticReplacement(){
		static $replacement = array('find'=>array(), 'replace'=>array());
		if($replacement['find'] == array()) {
			foreach(array_merge(range(0, 7), array(11), range(14, 31)) as $v) {
				$replacement['find'][] = chr($v);
				$replacement['replace'][] = "\\u00".sprintf("%02x", $v);
			}
			$replacement['find'] = array_merge(array(chr(0x5c), chr(0x2F), chr(0x22), chr(0x0d), chr(0x0c), chr(0x0a), chr(0x09), chr(0x08)), $replacement['find']);
			$replacement['replace'] = array_merge(array('\\\\', '\\/', '\\"', '\r', '\f', '\n', '\t', '\b'), $replacement['replace']);
		}
		return $replacement;
	}
    }

?>
