<?php

session_start();

$logged = isset($_SESSION["logInfo"]);
require("controler/views.php");


if(isset($_GET["action"]) && $logged)
{
  switch($_GET["action"])
  {
    case "logout":
      require("controler/connections.php");
      logout();
      break;

    case "generateGame":
      require("controler/gameGeneration.php");
      generateGame($_POST);
      break;

    case "searchGame":
      require("controler/gameGeneration.php");
      searchGame($_POST);
      break;

    case "upload":
      require("controler/uploading.php");
      uploadTrack($_POST, $_FILES);
      break;
  }
}
else if(isset($_GET["page"]) && $logged)
{
  switch($_GET["page"])
  {

    case "play":
      require("controler/gamePlay.php");
      displayGame($_GET);
      break;

    case "upload":
      displayUploader();
      break;
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
else if(isset($_GET["page"]))
{
  header("Location:/"); exit();
}
else
{
  displayConnection();
}
