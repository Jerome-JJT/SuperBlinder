<?php

session_start();

//print_r($_SESSION);

$logged = isset($_SESSION["logInfo"]);

require("controler/views.php");

if(isset($_GET["action"]) && $logged)
{
  switch($_GET["action"])
  {
    case "generateGame":
      require("controler/game.php");
      generateGame($_POST);
      break;
  }
}
else if(isset($_GET["page"]) && $logged)
{
  switch($_GET["page"])
  {
    case "gabarit":
      //require("view/template.php");
      break;

    case "connection":
      //require("view/connection.php");
      //displayUpload();
      break;

    case "generate":
      //require("view/generator.php");
      //displayGenerator();
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
else if($logged)
{
  displayGenerator();
}


else if(isset($_GET["action"]))
{
  switch($_GET["action"])
  {
    case "createAccount":
      require("controler/connections.php");
      register($_POST);
      break;

    case "loginAccount":
      require("controler/connections.php");
      login($_POST);
      break;
  }
}
else
{
  displayConnection();
}
