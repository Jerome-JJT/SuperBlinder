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


//Used to create a new game with a seed and tracks
function generateGame($postData)
{
  //Verify user form input
  if(isset($postData["difficulty"])
  && isset($postData["trackNb"])
  && isset($postData["type"]))
  {
    require_once("model/trackManagement.php");
    $tracks = getTracks();

    //Convert slider to allowed difficulties
    switch($postData["difficulty"])
    {
      case 1:
      $diff = array("Easy");
      break;

      case 2:
      $diff = array("Easy", "Normal");
      break;

      default:
      case 3:
      $diff = array("Normal");
      break;

      case 4:
      $diff = array("Normal", "Hard");
      break;

      case 5:
      $diff = array("Hard");
      break;
    }

    $gameType = $postData["type"];

    //Filter tracks with wrong difficulty
    $usable = array_filter($tracks, function($track) use ($diff, $gameType) {
      if(array_search($track["difficulty"], $diff) !== false
      && ($gameType == "all" || $gameType == $track["type"]))
      {
        return true;
      }
    });

    //Shuffle, get X wanted tracks and get only ids
    shuffle($usable);
    $usable = array_chunk($usable, $postData["trackNb"])[0];
    $gameIds = array_column($usable, "id");

    //Generate game seed
    $seeds = array_column(getAllSeeds(), "seed");
    $consonants = str_split("BCDFGHJKLMNPRSTVWXZ");
    $vowels = str_split("AEIOU");

    do
    {
      $gameCode = "";
      $type = 0;

      for($i = 0; $i < 10; $i++)
      {
          $xx = rand(0, 1000);

          //Alternate between vowels and consonants
          if($type == 0)
          {
              $gameCode .= ($consonants[$xx % count($consonants)]);
              $type = 1;
          }
          else if($type == 1)
          {
              $gameCode .= ($vowels[$xx % count($vowels)]);
              $type = 0;
          }
      }
      //Verify if code doesnt already exists
    } while (in_array($gameCode, $seeds));


    try
    {
      //Store game and tracks, get game id in return
      $gameId = insertGame($gameCode, $gameIds);

      if($gameId == false)
      {
        $_SESSION["filling"] = array("generationError" => "Erreur d'ajout");
        header("Location:/"); exit();
      }
    }
    catch(GameGenerationException $e)
    {
      $_SESSION["filling"] = array("generationError" => "Erreur de génération");
      header("Location:/"); exit();
    }

    startGame($gameId, $gameCode, $tracks, $gameIds);
  }
  else
  {
    $_SESSION["filling"] = array("generationError" => "Erreur");
    header("Location:/"); exit();
  }
}


//Require an already existing game's tracks
function searchGame($postData)
{
  //Verify user form input
  if(isset($postData["code"]))
  {
    require_once("model/trackManagement.php");
    $tracks = getTracks();

    //Get game's code, limited to 10 chars
    $gameCode = substr($postData["code"], 0, 10);

    //Get game's tracks request
    try
    {
      $gameInfos = getGameInfos($gameCode);
    }
    catch(GameSeedNotfoundException $e)
    {
      $_SESSION["filling"] = array("generationError" => "Partie non trouvée");
      header("Location:/"); exit();
    }

    //Get game's infos out of the request
    $gameId = $gameInfos[0]["gameId"];

    $gameTracks = array();
    foreach($gameInfos as $track)
    {
      $gameTracks[] = $track["trackId"];
    }

    startGame($gameId, $gameCode, $tracks, $gameTracks);
  }
}


//Store game into session, create wrong options list
function startGame($gameId, $gameCode, $tracks, $gameTracks)
{
  //Store game's important informations
  $_SESSION["game"] = array("gameId" => $gameId, "gameCode" => $gameCode, "advancement" => 0, "list" => array());

  foreach($gameTracks as $trackId)
  {
    //Get tracks from requested tracks list and not the database id
    $localTrackId = array_search($trackId, array_column($tracks, 'id'));

    //Store track options, initialized with good answer
    $localOptions = array($trackId => $tracks[$localTrackId]["title"]);

    //Adds 5 additionnal wrong answers
    for($i = 0; $i < 5; $i++)
    {
      $rand = rand(0, count($tracks)-1);

      //Get database id of random tracks
      $randId = $tracks[$rand]["id"];

      //If option is already in answers list, search a new one
      if(isset($localOptions[$randId]))
      {
        $i--;
        continue;
      }

      $localOptions[$randId] = $tracks[$rand]["title"];
    }

    //Add current tracks and tracks options to the list
    $_SESSION["game"]["list"][] = array(
      "state" => 0,
      "answerId" => $trackId,
      "path" => $tracks[$localTrackId]["fullPath"],
      "options" => $localOptions);

  }

  header("Location:/?page=play");exit();
}
