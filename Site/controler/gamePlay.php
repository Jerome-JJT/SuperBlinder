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


//Process game's advancement
function processGame($getData)
{
  //Check if a game is started
  if(!isset($_SESSION["game"]))
  {
    $_SESSION["filling"] = array("generationError" => "Partie non commencée");
    header("Location:/"); exit();
  }

  //User's game advancement
  $current = $_SESSION["game"]["advancement"];

  //Check if an answer is provided
  if(isset($getData["answer"]))
  {
    //Get current advancement's answer
    $goodAnswer = $_SESSION["game"]["list"][$current]["answerId"];

    //If current answer equal user's answer, add point
    if($getData["answer"] == $goodAnswer)
    {
      $_SESSION["game"]["list"][$current]["state"] = 1;
    }

    //Increase advancement
    $_SESSION["game"]["advancement"]++;

    header("Location:/?page=play"); exit();
  }

  //Prepare game display infos
  $gameCode = $_SESSION["game"]["gameCode"];

  $history = array();
  $goodAnswers = 0;
  $answered = 0;

  //For each already played tracks
  for($i = 0; $i < $_SESSION["game"]["advancement"]; $i++)
  {
    $answerId = $_SESSION["game"]["list"][$i]["answerId"];

    //Add already played tracks for display
    $history[] = array("state" => $_SESSION["game"]["list"][$i]["state"],
    "text" => $_SESSION["game"]["list"][$i]["options"][$answerId]);

    //Keep number of answers tracks and good answers
    $answered++;
    if($_SESSION["game"]["list"][$i]["state"] == 1) { $goodAnswers++; }
  }

  //Process game score on 100, manage 0 division
  $scoreRatio = $answered != 0 ? round($goodAnswers/$answered*100) : 0;

  //If game isn't finished
  if($_SESSION["game"]["advancement"] < count($_SESSION["game"]["list"]))
  {
    $gameUrl = $_SESSION["game"]["list"][$current]["path"];

    //Prepare options list
    $answerList = array();
    foreach($_SESSION["game"]["list"][$current]["options"] as $key => $value)
    {
      $answerList[] = array("key" => $key, "value" => $value);
    }

    //Shuffle list and separe it in 2 parts of 3
    shuffle($answerList);
    $answerList = array_chunk($answerList, 3);
  }
  else
  {
    require_once("model/userManagement.php");

    //Save user's score
    addScore($_SESSION["game"]["gameId"], $_SESSION["logInfo"]["id"], $scoreRatio);
    $_SESSION["logInfo"] = getUserInfos($_SESSION["logInfo"]["email"]);

    //Clear game
    unset($_SESSION["game"]);

    require("view/endgame.php");
    exit();
  }

  require("view/play.php");
}
