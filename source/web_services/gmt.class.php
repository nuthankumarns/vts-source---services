<?php
	require_once('config.php');

	class gmt extends DB_Mysql
{
		public $dbH;
		public $dbC;

		public $zoneId;
		public $zoneSecDiff;

		public $serverGMT;
		public $dateFormat;
		public $dateToConvert;

		/**
		* Constructor
		* Initialize default values
		*/
		public function __construct(){
			//$config['date_format']	= 'Y-m-d H:i:s';
			$this->dateFormat	= 'Y-m-d H:i:s';
			$this->serverGMT	= gmdate($this->dateFormat);
			$this->dateToConvert= date($this->dateFormat);
		}

		/**
		* Set the zone based on which the conversion should be done.
		* Refer the mysql table for zone ids.
		* @param int $zoneId
	 	*/
		public function setZoneId($zoneId = 0){
			$this->zoneId = $zoneId;
		}

		/**
		* Reset the zone id to zero(GMT +00:00).
	 	*/
		public function resetZoneId(){
			$this->zoneId = 0;
		}

		/**
		* Set the date for which the conversion should be done.
		* If not given, server date will be used
		* @param string $dateToConvert
	 	*/
		public function setDateToConvert($dateToConvert = ''){
			$this->dateToConvert = empty($dateToConvert) ? date($this->dateFormat) : $dateToConvert;
		}

		/**
		* Reset the "date-to-convert" to server date.
	 	*/
		public function resetDateToConvert(){
			$this->dateToConvert = date($this->dateFormat);
		}

		/**
		* Set the format of the date which should be used.
		* Default format will be as in config file.
		* @param string dateFormat
		*/
		public function setDateFormat($dateFormat = 'Y-m-d H:i:s'){
			$this->dateFormat = $dateFormat;
		}

		/*
		* Get the date based on the zone provided
		* @return date
		*/
		public function getByGMT(){
			$this->setZoneSecDiff();
			$this->prepareTimeData($this->dateToConvert);
			return date($this->dateFormat, strtotime($this->serverGMT) + $this->zoneSecDiff );
		}

		/**
		* Defines the class variable required for conversion
		* Dont call this function. It is used internally
		*/
		private function prepareTimeData($dateToConvert = ''){
			$dateToConvert 		 = empty($dateToConvert) ? date($this->dateFormat) : $dateToConvert;
			$this->dateToConvert = strtotime($dateToConvert);
			$this->serverGMT 	 = gmdate($this->dateFormat, $this->dateToConvert);
		}

		/**
		* Defines the class variable required for conversion
		* Dont call this function. It is used internally
		*/
		private function setZoneSecDiff(){
			if(empty($this->zoneId)){
				$this->zoneSecDiff = 0;
				return ;
			}

			$query 				= CLS_MYSQL::Query('SELECT secondsDiff FROM gmt_zones WHERE id = '.$this->zoneId);
			//if(!$this->dbH)
				//$this->connectDB();

			//$recordSet 			= mysql_query($query, $this->dbH);
			$recordSet=CLS_MYSQL::GetResultNumber($query);
			if( $recordSet != 1 )
				die('Error : Invalid zone id');

			//$this->zoneSecDiff	= mysql_result($recordSet, 0);
			$this->zoneSecDiff = CLS_MYSQL::GetResultValue($recordSet,0,'secondsDiff');
		}

		/**
		* Establish database connection. Configure the settings in config file
		* Dont call this function. It is used internally
		*/
		/*private function connectDB(){
			global $config;
			$this->dbH			= mysql_connect($config['db_host'],$config['db_user'],$config['db_pass']);
			if($this->dbH){
				$this->dbC		= mysql_select_db($config['db_name'], $this->dbH);
				if(!$this->dbH)
					die('Error : Configure DB connections');
			}
			else
				die('Error : Configure DB connections');
		}*/
	}
?>
