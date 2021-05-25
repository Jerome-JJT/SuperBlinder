<?php


function generateGame($postData)
{
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
      $auth = array("Easy");
      break;

      case 2:
      $auth = array("Easy", "Normal");
      break;

      default:
      case 3:
      $auth = array("Normal");
      break;

      case 4:
      $auth = array("Normal", "Hard");
      break;

      case 5:
      $auth = array("Hard");
      break;
    }

    $gameType = $postData["type"];

    //Filter tracks with wrong difficulty
    $usable = array_filter($tracks, function($track) use ($auth, $gameType) {
      if(array_search($track["difficulty"], $auth) !== false
      && ($gameType == "all"
        || $gameType == $track["type"]))
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
    } while (in_array($gameCode, $seeds));


    try
    {
      //Store game
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


function searchGame($postData)
{
  if(isset($postData["code"]))
  {
    require_once("model/trackManagement.php");
    $tracks = getTracks();

    $gameCode = substr($postData["code"], 0, 10);

    try
    {

      $gameInfos = getGameInfos($gameCode);
    }
    catch(GameSeedNotfoundException $e)
    {
      $_SESSION["filling"] = array("generationError" => "Partie non trouvée");
      header("Location:/"); exit();
    }

    $gameId = $gameInfos[0]["gameId"];
    $gameTracks = array();

    foreach($gameInfos as $track)
    {
      $gameTracks[] = $track["trackId"];
    }

    startGame($gameId, $gameCode, $tracks, $gameTracks);
  }
}

function startGame($gameId, $gameCode, $tracks, $gameTracks)
{

  $_SESSION["game"] = array("gameId" => $gameId, "gameCode" => $gameCode, "advancement" => 0, "list" => array());

  foreach($gameTracks as $trackId)
  {
    $localTrackId = array_search($trackId, array_column($tracks, 'id'));

    $localOptions = array($trackId => $tracks[$localTrackId]["title"]);

    for($i = 0; $i < 5; $i++)
    {
      $rand = rand(0, count($tracks)-1);

      if(isset($localOptions[$rand]))
      {
        $i--;
        continue;
      }

      $localOptions[$rand] = $tracks[$rand]["title"];
    }

    //print_r($tracks);

    $_SESSION["game"]["list"][] = array(
      "state" => 0,
      "answerId" => $trackId,
      "path" => $tracks[$localTrackId]["fullPath"],
      "options" => $localOptions);

  }

  //print_r($_SESSION["game"]);

  echo("Id game "); print_r($_SESSION["game"]["gameId"]); echo("<br>");
  echo("Game code "); print_r($_SESSION["game"]["gameCode"]); echo("<br>");

  foreach($_SESSION["game"]["list"] as $list)
  {
    echo("Answer "); print_r($list["answerId"]); echo("<br>");
    echo("Path "); print_r($list["path"]); echo("<br>");echo("<br>");


    foreach($list["options"] as $key => $option)
    {
      echo("Option id "); print_r($key); echo("<br>");
      echo("Option text "); print_r($option); echo("<br>");
    }
    echo("<br>");echo("<br>");echo("<br>");
  }
  //header("Location:/?page=play");
}

















//.
