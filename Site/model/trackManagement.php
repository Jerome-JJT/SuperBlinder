<?php


function getTracks($gameType)
{
  $query = "SELECT id, difficulty FROM TRACKS";
  $data = array();

  if($gameType == "movie")
  {
    $query.=" WHERE type = Movie";
  }
  else if($gameType == "serie")
  {
    $query.=" WHERE type = Serie";
  }


  require_once("model/dbConnector.php");
  $result = executeQuerySelect($query, $data);

  return $result;
}

function insertGame($tracksIds)
{
  $query = "SELECT id, difficulty FROM TRACKS";
  $data = array();

  foreach ($tracksIds as $id)
  {
    $data[] =
  }

  if($gameType == "movie")
  {
    $query.=" WHERE type = Movie";
  }
  else if($gameType == "serie")
  {
    $query.=" WHERE type = Serie";
  }


  require_once("model/dbConnector.php");
  $result = executeQuerySelect($query, $data);

  return $result;
}
