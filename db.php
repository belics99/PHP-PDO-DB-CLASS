<?php
/**
* 
*/
class DB 
{
	const host = '';
	const user = '';
	const pass = '';
	const dbname = '';
	const charset = '';

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
		$dsn = "mysql:host=".self::host.";dbname=".self::dbname.";charset=".self::charset;
		try {
			$this->pdo = new PDO($dsn, self::user, self::pass, $this->options);
		} catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(),(int)$e->getCode());		
		}
	}	

	public static function getInstance()
	{
		if( !isset(self::$_instance) ){
			self::$_instance = new DB;	
		}
		return self::$_instance;
	}

	/*----- QueryType -----*/
	//$queryType = 0 == SELECT
	//$queryType = 1 == INSERT,UPDATE,DELETE,DROP
	/*----- FetchType -----*/
	//$fetchType = 0 == fetchColumn()
	//$fetchType = 1 == fetch()
	//$fetchType = 2 == fetchAll()
	public function query($queryType, $sql, $params = [], $fetchType = null){
		if ( count($params) ){
			$this->query = $this->pdo->prepare($sql);
			$this->query->execute($params);
		}
		else $this->query = $this->pdo->query($sql);
		if ( !$queryType ){
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
