<?php

class GameGenerationException extends Exception { }

function getTracks($gameType)
{
  $query = "SELECT id, title, fullPath, difficulty FROM TRACKS";
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

function getAllSeeds()
{
  $query = "SELECT seed FROM GAMES";
  $data = array();

  require_once("model/dbConnector.php");
  $result = executeQuerySelect($query, $data);

  return $result;
}


function insertGame($seed, $tracksIds)
{
  $query = "INSERT INTO GAMES (seed) VALUES (:seed)";

  $data = array(":seed" => $seed);

  $gameId = executeQueryAction($query, $data);

  if($gameId == false)
  {
    throw new GameGenerationException();
  }


  $query = "INSERT INTO GAMES_TRACKS (gameId, trackId) VALUES (:gameId, :trackId)";
  $data = array();

  foreach ($tracksIds as $trackId)
  {
    $data[] = array(":gameId" => $gameId, ":trackId" => $trackId);
  }

  $result = executeQueryAction($query, $data, $repeat = true);

  return $gameId;
}
