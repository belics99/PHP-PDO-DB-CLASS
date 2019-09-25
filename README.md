# PHP-PDO-DB-CLASS

##Simple usage with some advanced abilities 
/*----- QueryType -----*/
//$queryType = 0 == SELECT
//$queryType = 1 == INSERT,UPDATE,DELETE,DROP
/*----- FetchType -----*/
//$fetchType = 0 == fetchColumn()
//$fetchType = 1 == fetch()
//$fetchType = 2 == fetchAll()
public function query($queryType, $sql, $params = [], $fetchType = null)
