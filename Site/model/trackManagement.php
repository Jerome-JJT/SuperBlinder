<?php

class GameGenerationException extends Exception { }
class GameSeedNotfoundException extends Exception { }

function getTracks()
{
  $query = "SELECT id, title, fullPath, difficulty, type FROM tracks";
  $data = array();

  require_once("model/dbConnector.php");
  $result = executeQuerySelect($query, $data);

  return $result;
}


function insertTrack($title, $fullPath, $difficulty, $type, $creatorId)
{
  $query = "INSERT INTO tracks (title, fullpath, difficulty, type, creatorId)
  VALUES (:title, :fullpath, :difficulty, :type, :creatorId)";

  $data = array(":title" => $title, ":fullpath" => $fullPath,
  ":difficulty" => $difficulty, ":type" => $type, ":creatorId" => $creatorId);

  require_once("model/dbConnector.php");
  $result = executeQueryAction($query, $data);

  return $result;
}

function getAllSeeds()
{
  $query = "SELECT seed FROM games";
  $data = array();

  require_once("model/dbConnector.php");
  $result = executeQuerySelect($query, $data);

  return $result;
}


function getGameInfos($code)
{
  $query = "SELECT games.id AS gameId, games.seed, tracks.id AS trackId, tracks.title FROM games
    INNER JOIN games_tracks ON games.id = games_tracks.gameId
    INNER JOIN tracks ON games_tracks.trackId = tracks.id
    WHERE games.seed = :code";

  $data = array(":code" => $code);

  require_once("model/dbConnector.php");
  $result = executeQuerySelect($query, $data);

  if(count($result) === 0)
  {
    throw new GameSeedNotfoundException();
  }

  return $result;
}


function insertGame($seed, $tracksIds)
{
  $query = "INSERT INTO games (seed) VALUES (:seed)";

  $data = array(":seed" => $seed);

  $gameId = executeQueryAction($query, $data);

  if($gameId == false)
  {
    throw new GameGenerationException();
  }


  $query = "INSERT INTO games_tracks (gameId, trackId) VALUES (:gameId, :trackId)";
  $data = array();

  foreach ($tracksIds as $trackId)
  {
    $data[] = array(":gameId" => $gameId, ":trackId" => $trackId);
  }

  $result = executeQueryAction($query, $data, true);

  return $gameId;
}
