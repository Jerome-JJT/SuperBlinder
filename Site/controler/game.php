<?php


function generateGame($postData)
{
  if(isset($postData["difficulty"])
  && isset($postData["trackNb"])
  && isset($postData["type"]))
  {
    require_once("model/trackManagement.php");
    $tracks = getTracks($postData["type"]);


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

    $usable = array_filter($tracks, function($track) use (&$auth) {
      if(array_search($track["difficulty"], $auth) !== false)
      {
        return true;
      }
    });

    shuffle($usable);
    $usable = array_chunk($usable, $postData["trackNb"])[0];
    $usableIds = array_column($usable, "id");


    insertGame($usableIds);

    print_r($tracks);echo("<br><br>");
    print_r($usable);echo("<br><br>");
    exit();
  }
  else
  {
    displayGenerator($error = "Erreur");
  }
}
