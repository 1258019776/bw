<?php 
// Copyright: Byke
if (!defined ('P')) {
	die ('Access Denied.');
} 

class bwDatabase extends PDO {
	private $errorMsg;
	public $qNum;
	public function __construct ()
	{
		include_once (P . 'conf/dbcon.php');
		$errorMsg = array();
		$this -> qNum = 0;

		try {
			$this -> dbh = parent :: __construct ('sqlite:' . DBNAME);
		} 
		catch (PDOException $e) {
			$this -> errorMsg[] = $e -> getCode();
			$this -> errorMsg[] = $e -> getMessage();
			$this -> throwError ();
		} 
	} 

	public function getSingleRow ($query, $bindarray = null, $defaultmode = false)
	{
		$stmt = $this -> dbExec ($query, $bindarray);
		$return = $this -> getSingleRowByStmt ($stmt, $defaultmode);
		return $return;
	} 

	public function getRows ($query, $bindarray = null, $defaultmode = false)
	{
		$stmt = $this -> dbExec ($query, $bindarray);
		$return = $this -> getRowsByStmt ($stmt, $defaultmode);
		return $return;
	} 

	public function getColums ($query, $bindarray = null)
	{
		$stmt = $this -> dbExec ($query, $bindarray);
		$return = $this -> getColumsByStmt ($stmt);
		return $return;
	} 

	public function countRows ($query, $bindarray = null)
	{
		$stmt = $this -> dbExec ($query, $bindarray);
		$stmt -> setFetchMode (PDO :: FETCH_NUM);
		$return = $stmt -> fetchAll ();
		return count($return);
	} 

	private function getSingleRowByStmt ($statement, $defaultmode = false)
	{
		if (!$defaultmode) {
			$statement -> setFetchMode (PDO :: FETCH_ASSOC);
		} 
		$return = $statement -> fetch ();
		return $return;
	} 

	private function getRowsByStmt ($statement, $defaultmode = false)
	{
		if (!$defaultmode) {
			$statement -> setFetchMode (PDO :: FETCH_ASSOC);
		} 
		$return = $statement -> fetchAll ();
		return $return;
	} 

	private function getColumsByStmt ($statement)
	{
		$array = $this -> getRowsByStmt ($statement);
		if (!$array) {
			return $array;
		} 
		$result = array();
		for ($i = 0; $i < count($array); $i++) {
			foreach ($array[$i] as $key => $val) {
				$result[$key][$i] = $val;
			} 
		} 
		return $result;
	} 

	public function dbExec ($queryStr, $bindarray = null)
	{
		$stmt = $this -> prepare ($queryStr);
		if ($stmt) {
			$return = $stmt -> execute ($bindarray);
			$this -> qNum++;
		} else {
			$this -> errorMsg = $this -> errorInfo();
			$this -> throwError ();
		} 
		if ($this -> errorCode() != '00000') {
			$this -> errorMsg = $this -> errorInfo();
			$this -> errorMsg[] = $stmt -> queryString;
			$this -> throwError ();
		} 
		return $stmt;
	} 

	public function dbExecBatch ($queryStr, $bindarrays)
	{
		$stmt = $this -> prepare ($queryStr);
		if ($stmt && is_array($bindarrays)) {
			foreach ($bindarrays as $bindarray) {
				$stmt -> execute ($bindarray);
				$this -> qNum++;
			} 
		} else {
			$this -> errorMsg = $this -> errorInfo();
			$this -> throwError ();
		} 
		if ($this -> errorCode() != '00000') {
			$this -> errorMsg = $this -> errorInfo();
			$this -> errorMsg[] = $stmt -> queryString;
			$this -> throwError ();
		} 
		return $stmt;
	} 

	private function throwError ()
	{
		global $conf;
		stopError ('Database Error: ' . implode(', ', $this -> errorMsg));
		exit ();
	} 
} 
