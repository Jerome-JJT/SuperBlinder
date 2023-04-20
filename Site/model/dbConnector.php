<?php
/**
 * Author   : Jerome Jaquemet
 * Email : jerome.jaquemet@cpnv.ch
 * Project  : SuperBlinder
 * Last modified  : 2021-06-01
 *
 * Github  : [https://github.com/Jerome-JJT/SuperBlinder]
 *
 */


//Database select function, return with indexed column name and not numeral
function executeQuerySelect($query, $data = array())
{
  $queryResult = array();

  //Open database connection
  $pdo = openDBConnection();

  if ($pdo != null)
  {
    $stm = $pdo->prepare($query);
    $stm->execute($data);
    $queryResult = $stm->fetchAll(PDO::FETCH_ASSOC);
  }

  //Close database connection
  $pdo = null;
  return $queryResult;
}


//Database insert function, allow sending multiple data with same query with repeat option
//For single query, return inserted id and false for query error
function executeQueryAction($query, $data = array(), $repeat = false)
{
  //Open database connection
  $pdo = openDBConnection();
  $result = true;

  if ($pdo != null)
  {
    $stm = $pdo->prepare($query);

    //Single query option
    if(!$repeat)
    {
      $stm->execute($data);
      $result = $pdo->lastInsertId();
    }
    else
    {
      //Multiple query option
      foreach ($data as $value)
      {
        $result &= $stm->execute($value);
      }
    }
  }

  //Close database connection
  $pdo = null;
  return $result;
}


//Database connection management
function openDBConnection()
{
  $dbConnection = null;

  $sql = 'mysql';
  $hostname = 'mysql';
  $port = 3306;
  $charset = 'utf8';
  $dbName = getenv('MYSQL_DATABASE');
  $userName = getenv('MYSQL_USER');
  $userPwd = getenv('MYSQL_PASSWORD');
  $dsn = $sql.':host='.$hostname.';dbname='.$dbName.';port='.$port.';charset='.$charset;

  try
  {
    $dbConnection = new PDO($dsn, $userName, $userPwd);
  }
  catch (PDOException $e)
  {
    echo("PDO error"); print_r($e); echo("<br>");
  }

  return $dbConnection;
}
