<?php

session_start();

//print_r($_SESSION);



/*
if(isset($_GET["action"]) && $logged)
{
  switch($_GET["action"])
  {
    case "generate":
      //generateBlindTest();
      break;
  }
}
else */if(isset($_GET["page"])/* && $logged*/)
{
  switch($_GET["page"])
  {
    case "gabarit":
      require("view/template.php");
      break;

    case "connection":
      require("view/connection.php");
      //displayUpload();
      break;

    case "generate":
      require("view/generator.php");
      //displayUpload();
      break;

    case "play":
      require("view/play.php");
      //displayUpload();
      break;

    case "upload":
      require("view/upload.php");
      //displayUpload();
      break;

    //default:
      //displayGenerator();

  }
}


else if(isset($_GET["action"]))
{
  switch($_GET["action"])
  {
    case "createAccount":
      //createAccount($_POST);
      break;

    case "loginAccount":
      //loginAccount($_POST);
      break;
  }
}
else
{
  require("view/template.php");
  //displayConnection();
}
