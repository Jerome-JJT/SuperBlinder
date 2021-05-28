<?php


function displayGame($getData)
{
  if(!isset($_SESSION["game"]))
  {
    $_SESSION["filling"] = array("generationError" => "Partie non commencée");
    header("Location:/"); exit();
  }

  $current = $_SESSION["game"]["advancement"];

  if(isset($getData["answer"]))
  {
    $goodAnswer = $_SESSION["game"]["list"][$current]["answerId"];

    if($getData["answer"] == $goodAnswer)
    {
      $_SESSION["game"]["list"][$current]["state"] = 1;
    }

    $_SESSION["game"]["advancement"]++;

    header("Location:/?page=play"); exit();
  }


  $gameUrl = $_SESSION["game"]["list"][$current]["path"];
  $gameCode = $_SESSION["game"]["gameCode"];


  $history = array();
  $goodAnswers = 0;
  $answered = 0;

  for($i = 0; $i < $_SESSION["game"]["advancement"]; $i++)
  {
    $answerId = $_SESSION["game"]["list"][$i]["answerId"];

    $history[] = array("state" => $_SESSION["game"]["list"][$i]["state"],
    "text" => $_SESSION["game"]["list"][$i]["options"][$answerId]);

    $answered++;
    if($_SESSION["game"]["list"][$i]["state"] == 1) { $goodAnswers++; }
  }

  $scoreRatio = $answered != 0 ? round($goodAnswers/$answered*100) : 0;

  //If game isn't finished
  if($_SESSION["game"]["advancement"] < count($_SESSION["game"]["list"]))
  {
    $answerList = array();
    foreach($_SESSION["game"]["list"][$current]["options"] as $key => $value)
    {
      $answerList[] = array("key" => $key, "value" => $value);
    }
    shuffle($answerList);
    $answerList = array_chunk($answerList, 3);

  }
  else
  {
    $notGame = true;

    require_once("model/userManagement.php");
    addScore($_SESSION["game"]["gameId"], $_SESSION["logInfo"]["id"], $scoreRatio);
    $_SESSION["logInfo"] = getUserInfos($_SESSION["logInfo"]["email"]);

    unset($_SESSION["game"]);

    require("view/endgame.php");
    exit();
  }

  require("view/play.php");
}
