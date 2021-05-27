<?php


function displayGame($getData)
{
  print_r($_SESSION["game"]);

  if(!isset($_SESSION["game"]))
  {
    $_SESSION["filling"] = array("generationError" => "Partie non commencée");
    header("Location:/"); exit();
  }

  if(isset($getData["answer"]))
  {

  }

  $gameCode = $_SESSION["game"]["gameCode"];

  $answerList = array();

  foreach($_SESSION["game"]["list"][0]["options"] as $key => $value)
  {
    $answerList[] = array("key" => $key, "value" => $value);
  }
  shuffle($answerList);
  $answerList = array_chunk($answerList, 3);

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

  //$advancement = $_SESSION["game"]["advancement"]
  //$list = $_SESSION["game"]["list"]



  require("view/play.php");
}
