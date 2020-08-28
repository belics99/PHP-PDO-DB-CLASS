<?php
class DB 
{	
	const host = '';
	const user = '';
	const pass = '';
	const dbname = '';
	const charset = '';
	
	/*
		Cubrid
		FreeTDS / Microsoft SQL Server / Sybase
		Firebird
		IBM DB2
		IBM Informix Dynamic Server
		MySQL 3.x/4.x/5.x
		Oracle Call Interface
		ODBC v3 (IBM DB2, unixODBC and win32 ODBC)
		PostgreSQL
		SQLite 3 and SQLite 2
		Microsoft SQL Server / SQL Azure
		4D	
	*/
	const dbTech = [
		0 => 'curbid',
		1 => 'dblib',
		2 => 'firebird',
		3 => 'ibm',
		4 => 'informix',
		5 => 'mysql',
		6 => 'oci',
		7 => 'odbc',
		8 => 'pgsql',
		9 => 'sqlite',
		10 => 'sqlsrv',
		11 => '4d'
	];
	
	protected $lastInsertedID;

	private static $_instance = null;
	private $pdo, $query;
	private $options = [
		PDO::ATTR_ERRMODE		=> PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE	=> PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES	=> false
	]; 

	function __construct(){
		$this::connect();
	}

	private function connect()
	{
		$dsn = self::dbTech[5] . ":host=" . self::host . ";dbname=" . self::dbname . ";charset=" . self::charset;
		try {
			$this->pdo = new PDO($dsn, self::user, self::pass, $this->options);
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(),(int)$e->getCode());		
		}
	}	

	public static function getInstance()
	{
		if( !isset(self::$_instance) ) self::$_instance = new DB;
		return self::$_instance;
	}

	/*----- QueryType -----*/
	//$queryType = 0 == SELECT
	//$queryType = 1 == INSERT
	//$queryType = 2 == UPDATE,DELETE,DROP
	/*----- FetchType -----*/
	//$fetchType = 0 == fetchColumn()
	//$fetchType = 1 == fetch()
	//$fetchType = 2 == fetchAll()
	public function query($queryType, $sql, $fetchType = 0, $params = []){
		if ( count($params) ){
			$this->query = $this->pdo->prepare($sql);
			$this->query->execute($params);
			$this->$lastInsertedID = ($queryType === 1)? $this->pdo->lastInsertId() : null;
		}
		else $this->query = $this->pdo->query($sql);
		if ( $queryType > 0 ){
			switch ( $fetchType ) {
				case 0:
					return $this->query->fetchColumn();
					break;				
				case 1:
					return $this->query->fetch();
					break;
				case 2:
					return $this->query->fetchAll();
					break;
			}
		}		
	} 
}
