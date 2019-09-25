# PHP-PDO-DB-CLASS

## Simple usage with some advanced abilities 
```php
/*----- QueryType -----*/
//$queryType = 0 == SELECT
//$queryType = 1 == INSERT,UPDATE,DELETE,DROP
/*----- FetchType -----*/
//$fetchType = 0 == fetchColumn()
//$fetchType = 1 == fetch()
//$fetchType = 2 == fetchAll()
public function query($queryType, $sql, $params = [], $fetchType = 0){
  ...
}
```
## Examples
```php
//get instance, you need to make object first so you can use DB query method
$_db = DB::getInstance();
```

### SELECT
```php
$sql = "SELECT TOP 1 ID FROM USER"
$_db->query(0, $sql);
//Now you'll get only 1 column, just ID value for TOP 1 FROM USER table 

$sql = "SELECT * FROM USER WHERE HAIR_COLOR = ? AND NAME = ?";
$params = ["Black", "Strahinja"];
$_db->query(0, $sql, $params, 2);
/*
Now you'll get all users with name Strahinja and hair color black
query will return two dimensional array ( [][] )
so you can loop through it with foreach loop.
If you put 1 instead 2 you'll get only 1 row,  just array ( [] )
$_db->query(0, $sql, $params, 1);
*/
```

### UPDATE
```php
$sql = "UPDATE USER SET HAIR_COLOR = ?, NAME = ? WHERE ID = ?";
$params = ["Black", "Strahinja", 1];
$_db->query(1, $sql, $params);
```
