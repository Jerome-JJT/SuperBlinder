<?php


function executeQuerySelect($query, $data = array()){
  $queryResult = array();

  //Open database connection
  $pdo = openDBConnexion();

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


function executeQueryAction($query, $data = array())
{
  //Open database connection
  $pdo = openDBConnexion();

  if ($pdo != null)
  {
    $stm = $pdo->prepare($query);
    $result = $stm->execute($data);
  }

  //Close database connection
  $pdo = null;
  return ($result !== false);
}


function openDBConnexion()
{
  $dbConnection = null;

  $sql = 'mysql';
  $hostname = 'localhost';
  $port = 3306;
  $charset = 'utf8';
  $dbName = 'superblinder';
  $userName = 'tempTPI';
  $userPwd = 'toor';
  $dsn = $sql.':host='.$hostname.';dbname='.$dbName.';port='.$port.';charset='.$charset;

  try
  {
    $tempDbConnexion = new PDO($dsn, $userName, $userPwd);
  }
  catch (PDOException $exception)
  {
  }

  return $dbConnection;
}