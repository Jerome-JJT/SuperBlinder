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


//Functions exceptions
class GameGenerationException extends Exception { }
class GameSeedNotfoundException extends Exception { }


//Return list of all tracks
function getTracks()
{
  $query = "SELECT id, title, fullPath, difficulty, type FROM tracks";
  $data = array();

  require_once("model/dbConnector.php");
  $result = executeQuerySelect($query, $data);

  return $result;
}


//Add a new tracks to the database
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


//Get all existing games seeds
function getAllSeeds()
{
  $query = "SELECT seed FROM games";
  $data = array();

  require_once("model/dbConnector.php");
  $result = executeQuerySelect($query, $data);

  return $result;
}


//Get game tracks and informations for given seed
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


//Add a new game into the database and add all linked tracks
function insertGame($seed, $tracksIds)
{
  $query = "INSERT INTO games (seed) VALUES (:seed)";

  $data = array(":seed" => $seed);

  $gameId = executeQueryAction($query, $data);

  //if return id is an error
  if($gameId == false)
  {
    throw new GameGenerationException();
  }


  $query = "INSERT INTO games_tracks (gameId, trackId) VALUES (:gameId, :trackId)";
  $data = array();

  //Prepare tracks for a multiple query
  foreach ($tracksIds as $trackId)
  {
    $data[] = array(":gameId" => $gameId, ":trackId" => $trackId);
  }

  $result = executeQueryAction($query, $data, true);

  return $gameId;
}
