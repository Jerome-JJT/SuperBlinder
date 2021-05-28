<?php


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


function executeQueryAction($query, $data = array(), $repeat = false)
{
  //Open database connection
  $pdo = openDBConnection();
  $result = true;

  if ($pdo != null)
  {
    $stm = $pdo->prepare($query);
    if(!$repeat)
    {
      $stm->execute($data);
      $result = $pdo->lastInsertId();
    }
    else
    {
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


function openDBConnection()
{
  $dbConnection = null;

  $sql = 'mysql';
  $hostname = 'localhost';
  $port = 3306;
  $charset = 'utf8';
  $dbName = 'tpi21blind_db';
  $userName = 'tpi21blind_db';
  $userPwd = 'ROOTtoor8$';
  $dsn = $sql.':host='.$hostname.';dbname='.$dbName.';port='.$port.';charset='.$charset;

  try
  {
    $dbConnection = new PDO($dsn, $userName, $userPwd);
  }
  catch (PDOException $e)
  {
    //echo("PDO error"); print_r($e); echo("<br>");
  }

  return $dbConnection;
}
