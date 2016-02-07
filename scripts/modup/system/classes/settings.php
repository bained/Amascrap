<?php
class Settings{

	public $settings = array();

	public function __construct() {
		$ini_file_location = realpath(DIR_MODUP.'/system/settings.ini');

	    if(!file_exists($ini_file_location)){
	       die("INI FILE could not be loaded: ".$ini_file_location); //or default to a language
	    } else {
	    	// $this->ini_file = parse_ini_file($ini_file_location);
	    	$this->ini_file_location = $ini_file_location;
	    }
	}

	public function allSettings($query=false){
		$ini_file = parse_ini_file($this->ini_file_location);
		if(!$query)
			return $ini_file;
		else {
			// $array = $ini_file;
			return $ini_file[$query];
		}
	}

	public function restoreDefaultDB(){
		$as = $this->allSettings();
		// print_r($as);
		$as['database_file'] = DEFAULT_DB;
		$this->write_php_ini($as);
	}

	public function productsPerPage($productsPerPage){
		if($productsPerPage < 2) return "Too low number or not a number!";

		$as = $this->allSettings();
		$as['productsPerPage'] = $productsPerPage;
		$this->write_php_ini($as);
	}

	public function write_php_ini($array)
	{
		// $file = $this->ini_file;
		$res = array();
		foreach($array as $key => $val)
		{
			if(is_array($val))
			{
				$res[] = "[$key]";
				foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
			}
			else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
		}
		// print_r($this->ini_file);
		$this->safefilerewrite($this->ini_file_location, implode("\r\n", $res));
	}

	private function safefilerewrite($fileName, $dataToSave)
	{	if ($fp = fopen($fileName, 'w'))
		{
			$startTime = microtime(TRUE);
			do
			{			$canWrite = flock($fp, LOCK_EX);
			   // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
			   if(!$canWrite) usleep(round(rand(0, 100)*1000));
			} while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

			//file was locked so now we can store information
			if ($canWrite)
			{			fwrite($fp, $dataToSave);
				flock($fp, LOCK_UN);
			}
			fclose($fp);
		}

	}




}

?>